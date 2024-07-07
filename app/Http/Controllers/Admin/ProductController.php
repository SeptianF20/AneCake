<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductLabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;
use App\Helpers\ProductHelper;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'ASC')->get();

        return view('pages._Main.Product.product.index', compact('products'));
    }

    public function list()
    {
        $products = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->select(
                'products.*',
                'product_categories.name as category_name',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
            )
            ->orderBy('products.created_at', 'ASC')
            ->when(request()->q, function ($products) {
                $products = $products->where('products.name', 'like', '%' . request()->q . '%');
            })
            ->when(request()->slug, function ($products) {
                $products = $products->where('products.slug', 'like', '%' . request()->slug . '%');
            })
            ->when(request()->filter, function ($products) {
                if (request()->filter == 'active') {
                    $products = $products->where('products.is_active', '=', 1);
                } elseif (request()->filter == 'draft') {
                    $products = $products->where('products.is_active', '=', 0);
                }
            })
            ->when(request()->sort, function ($products) {
                if (request()->sort == 'newest') {
                    $products = $products->orderBy('products.created_at', 'DESC');
                } elseif (request()->sort == 'oldest') {
                    $products = $products->orderBy('products.created_at', 'ASC');
                } elseif (request()->sort == 'price_asc') {
                    $products = $products->orderBy('products.price', 'ASC');
                } elseif (request()->sort == 'price_desc') {
                    $products = $products->orderBy('products.price', 'DESC');
                }
            })
            ->when(request()->category, function ($products) {
                $products = $products->where('products.product_category_id', '=', request()->category);
            })
            ->groupBy('products.id', 'product_categories.name')
            ->paginate(6);

        $categories = DB::table('product_categories')->get();
        $labels = DB::table('product_labels')->get();

        return view('pages._Main.Product.product.list', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::all();

        return view('pages._Main.Product.product.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                // 'name'                  => 'required|unique:products, name',
                // name unique:products, name where delete_at is null
                'name'                  => 'required|unique:products,name,NULL,id,deleted_at,NULL',
                'slug'                  => 'required|unique:products,slug,NULL,id,deleted_at,NULL',
                'thumbnail'             => 'required',
                'price'                 => 'required',
                'product_category_id'   => 'required',
            ],
            [
                'name.required'                 => 'Nama produk harus diisi',
                'slug.required'                 => 'Slug produk harus diisi',
                'name.unique'                   => 'Nama produk sudah ada',
                'thumbnail.required'            => 'Thumbnail produk harus diisi',
                'price.required'                => 'Harga produk harus diisi',
                'product_category_id.required'  => 'Kategori produk harus diisi',
            ]
        );


        if ($request->slug == null) {
            $slug = str_replace(' ', '-', strtolower($request->name));
        } else {
            $slug = $request->slug;
        }

        if ($request->thumbnail != null) {
            $path = $request->thumbnail;
            $filename = explode('/', $path);

            $directory = explode('/', $path);
            array_pop($directory);
            $directory = implode('/', $directory);

            if (!File::exists(public_path('images/products/' . $slug . '/thumbnail'))) {
                File::makeDirectory(public_path('images/products/' . $slug . '/thumbnail'), 0777, true, true);
            }

            File::move(storage_path('app/' . $path), public_path('images/products/' . $slug . '/' . 'thumbnail/' . $filename[3]));
            File::deleteDirectory(storage_path('app/' . $directory));

            $urlThumbnailFile = url('images/products/' . $slug . '/' . 'thumbnail/' . $filename[3]);
        };


        $product = Product::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name ?? null,
            'slug' => $slug ?? null,
            'thumbnail' => $urlThumbnailFile ?? null,
            'price' => $request->price ?? null,
            'discount' => $request->discount ?? null,
            'product_category_id' => $request->product_category_id ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
        ], 200);
    }

    public function getProducts()
    {
        $products = Product::where('name', 'ILIKE', '%' . request()->q . '%')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
        ], 200);
    }

    public function show($slug)
    {
        $product = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->leftJoin('orders', 'products.id', '=', 'orders.product_id')
            ->select(
                'products.*',
                'product_categories.name as category_name',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
                DB::raw('CAST(products.price AS INTEGER) as product_price'),
                DB::raw('CAST(products.price - (products.price * products.discount / 100) AS INTEGER) as price_after_discount'),
            )
            ->addSelect(DB::raw('SUM(orders.quantity) as order_quantity'))
            ->where('products.slug', '=', $slug)
            ->groupBy('products.id', 'product_categories.name')
            ->first();

        // dd($product);

        // // related products by category
        // $relatedProducts = DB::table('products')
        //     ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
        //     ->join('product_labels', 'products.product_label_id', '=', 'product_labels.id')
        //     ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
        //     ->select(
        //         'products.*',
        //         'product_categories.name as category_name',
        //         'product_labels.name as label_name',
        //         DB::raw('COUNT(reviews.id) as review_count'),
        //         DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
        //         DB::raw('CAST(products.price AS INTEGER) as product_price'),
        //         DB::raw('CAST(products.price - (products.price * products.discount / 100) AS INTEGER) as price_after_discount'),
        //     )
        //     ->where('products.product_category_id', '=', $product->product_category_id)
        //     ->where('products.id', '!=', $product->id)
        //     ->orderBy('products.created_at', 'DESC')
        //     ->groupBy('products.id', 'product_categories.name', 'product_labels.name')
        //     ->limit(4)
        //     ->get();

        // if (!$product) {
        //     return abort(404);
        // }

        // return view('pages._Main.Product.product.detail', compact(
        //     'product',
        //     'reviews',
        //     'productImages',
        //     'relatedProducts',
        // ));
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus',
        ], 200);
    }

    public function edit($id)
    {
        $product = Product::where('id', '=', $id)->first();

        // $productImages = DB::table('product_images')
        //     ->select('product_images.*')
        //     ->where('product_images.product_id', '=', $product->id)
        //     ->orderBy('product_images.created_at', 'ASC')
        //     ->get();

        // // set product images to array
        // $arrProductImages = [];
        // foreach ($productImages as $productImage) {
        //     array_push($arrProductImages, $productImage->image);
        // }
        // // to string
        // $arrProductImages = json_encode($arrProductImages);

        // if (!$product) {
        //     return abort(404);
        // }

        $categories = ProductCategory::all();

        return view('pages._Main.Product.product.edit', compact(
            'product',
            'categories',
        ));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'slug' => 'unique:products,slug,' . $id,
            'price' => 'required',
            'product_category_id' => 'required',
        ]);

        if ($request->slug == null) {
            $slug = str_replace(' ', '-', strtolower($request->name));
        } else {
            $slug = $request->slug;
        }

        if ($request->thumbnail != null) {
            $path = $request->thumbnail;
            $filename = explode('/', $path);

            $directory = explode('/', $path);
            array_pop($directory);
            $directory = implode('/', $directory);

            if (!File::exists(public_path('images/products/' . $slug . '/thumbnail'))) {
                File::makeDirectory(public_path('images/products/' . $slug . '/thumbnail'), 0777, true, true);
            }

            File::move(storage_path('app/' . $path), public_path('images/products/' . $slug . '/' . 'thumbnail/' . $filename[3]));
            File::deleteDirectory(storage_path('app/' . $directory));

            $urlThumbnailFile = url('images/products/' . $slug . '/' . 'thumbnail/' . $filename[3]);
        };

        // $arrImages = json_decode($request->images);
        // if ($request->images != null && is_array($arrImages)) {
        //     foreach ($arrImages as $path) {
        //         $filename = explode('/', $path);

        //         $directory = explode('/', $path);
        //         array_pop($directory);
        //         $directory = implode('/', $directory);

        //         if (!File::exists(public_path('images/products/' . $slug . '/images'))) {
        //             File::makeDirectory(public_path('images/products/' . $slug . '/images'), 0777, true, true);
        //         }

        //         File::move(storage_path('app/' . $path), public_path('images/products/' . $slug . '/images/' . $filename[3]));
        //         File::deleteDirectory(storage_path('app/' . $directory));
        //     }

        //     $urlProductImages = array_map(function ($path) use ($slug) {
        //         $filename = explode('/', $path);
        //         return url('images/products/' . $slug . '/images/' . $filename[3]);
        //     }, $arrImages);
        // };

        $product = Product::find($id);
        $product->update([
            'user_id' => auth()->user()->id,
            'name' => $request->name ?? null,
            'slug' => $slug ?? null,
            'thumbnail' => $urlThumbnailFile ?? null,
            'price' => $request->price ?? null,
            'discount' => $request->discount ?? null,
            'product_category_id' => $request->product_category_id ?? null,
        ]);

        // if ($request->images != null && is_array($arrImages)) {
        //     // delete old product images
        //     DB::table('product_images')->where('product_id', '=', $product->id)->delete();

        //     // insert new product images
        //     foreach ($urlProductImages as $urlProductImage) {
        //         ProductImage::create([
        //             'product_id' => $product->id,
        //             'image' => $urlProductImage,
        //         ]);
        //     }
        // }
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diubah',
        ], 200);
    }

    // public function lowStockProducts()
    // {
    //     $products = ProductHelper::getLowStockProducts();
    //     dd($products); // Debugging: tampilkan isi dari $products
    //     return view('products.low_stock', compact('products'));
    // }

}
