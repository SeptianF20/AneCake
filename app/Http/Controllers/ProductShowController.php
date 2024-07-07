<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Product;
use App\Models\pemesanan;
use Midtrans\Notification;
use Illuminate\Http\Request;
use App\Models\detailPemesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class ProductShowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')->get();
        // dd(Auth::guard('member')->user()->email);
        return view('pages.landing.produk.detail', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getSnapToken(Request $request)
    {
        try {
            // Set midtrans configuration
            \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
            \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
            \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

            $total = $request->input('totalPembayaran');
            // $items = $request->all();
            $id = 'OD-' . rand();

            $payload = [
                'transaction_details' => [
                    'order_id' => $id,
                    'gross_amount' => $total,
                ],
                'customer_details' => [
                    'first_name' => Auth::guard('member')->user()->nama,
                    'email' => Auth::guard('member')->user()->email,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            return response()->json(['snapToken' => $snapToken, 'id' => $id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function saveTransaction(Request $request)
    {
        try {
            // Validasi jika diperlukan

            // Ambil data transaksi dari input JSON
            $transactionId = $request->input('transactionId');

            // Simpan informasi transaksi ke dalam database atau lakukan tindakan lainnya
            // Contoh penyimpanan sederhana ke dalam log
            Log::info('Transaction saved with ID: ' . $transactionId);

            // Response jika diperlukan
            return response()->json(['message' => 'Transaction saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        // Validasi data
        // $request->validate([
        //     'items' => 'required|array',
        //     'totalPembayaran' => 'required|numeric',
        //     'items.*.idProduk' => 'required|integer',
        //     'items.*.namaProduk' => 'required|string',
        //     'items.*.kuantiti' => 'required|integer',
        //     'items.*.hargaProduk' => 'required|integer',
        //     'order_id' => 'required|string',
        //     'transaction_status' => 'required|string',
        //     'gross_amount' => 'required|numeric',
        //     'payment_type' => 'required|string',
        //     'transaction_time' => 'required|date',
        // ]);

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Simpan transaksi
            $transaction = new pemesanan();
            $transaction->order_id = $request->order_id;
            $transaction->transaction_status = 'Terbayar';
            $transaction->tanggal = $request->orderDate;
            $transaction->gross_amount = $request->totalPembayaran;
            $transaction->payment_type = 'Transfer';
            $transaction->transaction_time = now();
            
            $transaction->save();

            // Simpan detail transaksi
            foreach ($request->items as $item) {
                $transactionDetail = new detailPemesanan();
                $transactionDetail->pemesanan_id = $transaction->id;
                $transactionDetail->product_id = $item['idProduk'];
                $transactionDetail->product_name = $item['namaProduk'];
                $transactionDetail->quantity = $item['kuantiti'];
                $transactionDetail->price= $item['hargaProduk'];
                $transactionDetail->total_price= $request->totalPembayaran;
                $transactionDetail->save();

                // Kurangi stok produk
                $product = Product::find($item['idProduk']);
                if ($product) {
                    $product->stock -= $item['kuantiti'];
                    if ($product->stock < 0) {
                        throw new \Exception("Stok produk dengan ID {$item['idProduk']} tidak mencukupi.");
                    }
                    $product->save();
                } else {
                    throw new \Exception("Produk dengan ID {$item['idProduk']} tidak ditemukan.");
                }
            }
            // Commit transaksi database
            DB::commit();

            return response()->json(['message' => 'Transaction stored successfully'], 200);

        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollBack();
            return response()->json(['message' => 'Error storing transaction', 'error' => $e->getMessage()], 500);
        }
    }

    public function checkout(Request $request)
    {
        try {
            // Validasi jika diperlukan

            // Ambil data transaksi dari input JSON
            $transactionData = json_decode($request->input('transactionData'), true);

            // Simpan transaksi utama
            $transaction = new pemesanan();
            $transaction->order_id = 'OD-' . rand(); // Sesuaikan dengan order_id yang sesuai kebutuhan
            $transaction->transaction_status = 'pending'; // Misalnya, awalnya status pending
            $transaction->gross_amount = $transactionData['totalPembayaran'];
            $transaction->payment_type = 'Midtrans'; // Sesuaikan dengan metode pembayaran
            $transaction->transaction_time = $transactionData['orderDate']; // Waktu transaksi saat ini
            $transaction->save();

            // Simpan detail produk dari $transactionData['items']
            foreach ($transactionData['items'] as $item) {
                $transactionItem = new detailPemesanan();
                $transactionItem->transaction_id = $transaction->id;
                $transactionItem->product_id = $item['idProduk'];
                $transactionItem->product_name = $item['namaProduk'];
                $transactionItem->quantity = $item['kuantiti'];
                $transactionItem->price = $item['hargaProduk'];
                $transactionItem->total_price = $item['kuantiti'] * $item['hargaProduk'];
                $transactionItem->save();
            }

            // Response jika diperlukan
            return response()->json(['message' => 'Transaction saved successfully', 'transaction_id' => $transaction->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
