<?php

use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FormLoginController;
use App\Http\Controllers\ProductShowController;
use App\Http\Controllers\TemporaryFileController;
use App\Http\Controllers\TopupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', [LandingController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
  Route::get('/', function () {
    return redirect()->route('root');
  });
  Route::prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

    Route::resource('/products', App\Http\Controllers\Admin\ProductController::class, ['as' => 'admin']);

    Route::get('/products-list', [App\Http\Controllers\Admin\ProductController::class, 'list'])->name('admin.products.list');

    Route::resource('/categories', App\Http\Controllers\Admin\ProductCategoryController::class, ['as' => 'admin']);


    Route::resource('/suppliers', App\Http\Controllers\Admin\SupplierController::class, ['as' => 'admin']);
    Route::get('/get-suppliers', [App\Http\Controllers\Admin\SupplierController::class, 'getSuppliers'])->name('admin.suppliers.getSuppliers');
    Route::get('/get-products', [App\Http\Controllers\Admin\ProductController::class, 'getProducts'])->name('admin.products.getProducts');
    Route::resource('/purchases', App\Http\Controllers\Admin\PurchaseController::class, ['as' => 'admin']);


    Route::resource('/users', App\Http\Controllers\Admin\UserController::class, ['as' => 'admin']);
    Route::resource('/customers', App\Http\Controllers\Admin\CustomerController::class, ['as' => 'admin']);
    // Route::resource('/roles', App\Http\Controllers\Admin\RoleController::class, ['as' => 'admin']);
    // Route::resource('/permissions', App\Http\Controllers\Admin\PermissionController::class, ['as' => 'admin']);
    Route::resource('/member', App\Http\Controllers\Admin\MemberController::class, ['as' => 'admin']);
    
    Route::get('/cashier', [App\Http\Controllers\Admin\CashierController::class, 'index'])->name('admin.cashier.index');
    Route::post('/cashier', [App\Http\Controllers\Admin\CashierController::class, 'store'])->name('admin.cashier.store');
    Route::get('/cashier/{id}', [App\Http\Controllers\Admin\CashierController::class, 'invoice'])->name('admin.cashier.invoice');
    Route::get('/getBarangData', [App\Http\Controllers\Admin\CashierController::class, 'product_data'])->name('admin.cashier.product_data');
    Route::get('/register_pos', [App\Http\Controllers\Admin\CashierRegisterController::class, 'index'])->name('admin.pos.register');
    Route::get('/close_pos', [App\Http\Controllers\Admin\CashierController::class, 'close'])->name('admin.pos.close');
    Route::get('/close_cashier', [App\Http\Controllers\Admin\CashierController::class, 'close_cashier'])->name('admin.pos.close_cashier');
    Route::post('/register_pos', [App\Http\Controllers\Admin\CashierRegisterController::class, 'store'])->name('admin.pos.store');

    Route::get('/cards', [App\Http\Controllers\Admin\CardController::class, 'index'])->name('admin.card');
    Route::get('/get-rfid-data', [App\Http\Controllers\Admin\CardController::class, 'getRfidData'])->name('get.rfid.data');
    Route::post('/delete-rfid-data', [App\Http\Controllers\Admin\CardController::class, 'deleteRfidData'])->name('delete.rfid.data');
    Route::post('/cards', [App\Http\Controllers\Admin\CardController::class, 'store'])->name('admin.card.store');
    Route::get('/cards/{id}', [App\Http\Controllers\Admin\CardController::class, 'edit'])->name('admin.card.edit');
    Route::post('/cards/{id}', [App\Http\Controllers\Admin\CardController::class, 'update'])->name('admin.card.update');

    Route::get('/slip-kasir', function () {
      return view('pages._Main.Cashier.slip');
    })->name('admin.cashier.slip');

    // Route::name('admin.report.')->group(function () {
    //   Route::get('/report', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.report.index');
    // });

    Route::get('/report', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.report.index');

    // Route::get('/report', function () {
    //   return view('pages._Main.Accounting.Report.index');
    // })->name('admin.report.index');

    Route::get('/profit_loss', [App\Http\Controllers\Admin\ProfitLossController::class, 'index'])->name('admin.profit-loss.index');


    //filepond route
    Route::post('/upload', [TemporaryFileController::class, 'store'])->name('filepond.upload');
    Route::delete('/revert', [TemporaryFileController::class, 'destroy'])->name('filepond.revert');

    Route::get('/test', function () {
      return view('test');
    })->name('admin.test.index');
  });
});
Route::get('admin/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::group(['middleware' => 'auth2:member'], function () {
  Route::get('user/produk', [ProductShowController::class, 'index'])->name('product.show');
  Route::post('user/produk/checkout', [ProductShowController::class, 'getSnapToken'])->name('product.snaptoken');
  Route::post('user/produk/checkout/store', [ProductShowController::class, 'saveTransaction'])->name('product.savetransaction');
  Route::post('/store-transaction', [ProductShowController::class, 'store'])->name('product.storeTransaction');

  Route::get('/user/checkout', [CheckoutController::class, 'index'])->name('checkout');
  Route::get('user/topup', [TopupController::class, 'index'])->name('topup');
  Route::post('/user/topup/store', [TopupController::class, 'getSnapToken'])->name('topup.checkout');
  Route::post('/topup/update-saldo', [TopupController::class, 'updateSaldo'])->name('topup.updateSaldo');
});

Route::get('/user/login', [FormLoginController::class, 'index'])->name('signIn');
Route::get('/user/signup', [FormLoginController::class, 'signup'])->name('signUp');
Route::post('/checkLogin', [FormLoginController::class, 'login'])->name('member.login.submit');
Route::post('/user/logout', [FormLoginController::class, 'logout'])->name('logout');
// abort 404
Route::fallback(function () {
  return abort(404);
});
