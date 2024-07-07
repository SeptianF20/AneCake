<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('api.login');
    Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('api.register');
    Route::get('logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('api.logout');
    // Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('api.logout');
    Route::post('refresh', [App\Http\Controllers\Api\AuthController::class, 'refreshToken'])->name('api.refresh');
    Route::middleware('auth:api')->get('me', [App\Http\Controllers\Api\AuthController::class, 'getUser'])->name('api.me');
});

Route::group(['prefix' => 'category'], function () {
    Route::get('list', [App\Http\Controllers\Api\CategoryController::class, 'getCategories'])->name('api.category.list');
});
