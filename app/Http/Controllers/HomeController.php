<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permission:view-dashboard', ['only' => ['root']]);
  }

  public function root()
  {
    // get count of all products
    $products = DB::table('products')->count();

    // get count of all customers
    $customers = DB::table('customers')->count();

    // get top 3 products with highest sales
    $topProducts = DB::table('transactions')
      ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
      ->join('products', 'orders.product_id', '=', 'products.id')
      ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
      ->select('products.name', DB::raw('SUM(orders.quantity) as total'), 'products.thumbnail', 'product_categories.name as category')
      ->groupBy('products.name', 'products.thumbnail', 'product_categories.name')
      ->orderBy('total', 'desc')
      ->limit(3)
      ->get();


    return view('index', compact(
      'products',
      'customers',
      'topProducts',
    ));
  }

  public function ok()
  {
    return redirect()->route('root');
  }

  /*Language Translation*/
  public function lang($locale)
  {
    // dd($locale);
    if ($locale) {
      App::setLocale($locale);
      Session::put('lang', $locale);
      Session::save();
      return redirect()->back()->with('locale', $locale);
    } else {
      return redirect()->back();
    }
  }

  public function updateProfile(Request $request, $id)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email'],
      'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
    ]);

    $user = User::find($id);
    $user->name = $request->get('name');
    $user->email = $request->get('email');

    if ($request->file('avatar')) {
      $avatar = $request->file('avatar');
      $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
      $avatarPath = public_path('/images/');
      $avatar->move($avatarPath, $avatarName);
      $user->avatar = '/images/' . $avatarName;
    }

    $user->update();
    if ($user) {
      Session::flash('message', 'User Details Updated successfully!');
      Session::flash('alert-class', 'alert-success');
      return response()->json([
        'isSuccess' => true,
        'Message' => "User Details Updated successfully!"
      ], 200); // Status code here
    } else {
      Session::flash('message', 'Something went wrong!');
      Session::flash('alert-class', 'alert-danger');
      return response()->json([
        'isSuccess' => true,
        'Message' => "Something went wrong!"
      ], 200); // Status code here
    }
  }

  public function updatePassword(Request $request, $id)
  {
    $request->validate([
      'current_password' => ['required', 'string'],
      'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);

    if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
      return response()->json([
        'isSuccess' => false,
        'Message' => "Your Current password does not matches with the password you provided. Please try again."
      ], 200); // Status code
    } else {
      $user = User::find($id);
      $user->password = Hash::make($request->get('password'));
      $user->update();
      if ($user) {
        Session::flash('message', 'Password updated successfully!');
        Session::flash('alert-class', 'alert-success');
        return response()->json([
          'isSuccess' => true,
          'Message' => "Password updated successfully!"
        ], 200); // Status code here
      } else {
        Session::flash('message', 'Something went wrong!');
        Session::flash('alert-class', 'alert-danger');
        return response()->json([
          'isSuccess' => true,
          'Message' => "Something went wrong!"
        ], 200); // Status code here
      }
    }
  }
}
