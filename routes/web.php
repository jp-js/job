<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\OrdersController;
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

Route::get('/', [App\Http\Controllers\ProductController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\ProductController::class, 'index'])->name('home');


Route::get('cart', [App\Http\Controllers\ProductController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [App\Http\Controllers\ProductController::class, 'addToCart'])->name('add.to.cart');
Route::patch('update-cart', [App\Http\Controllers\ProductController::class, 'updateCart'])->name('update.cart');
Route::delete('remove-from-cart', [App\Http\Controllers\ProductController::class, 'remove'])->name('remove.from.cart');


Route::get('checkout-form', [App\Http\Controllers\ProductController::class, 'checkoutform'])->name('checkoutform')->middleware('auth:web');
Route::post('checkout', [App\Http\Controllers\ProductController::class, 'checkout'])->name('checkout')->middleware('auth:web');

Route::group(['prefix' => 'admin'], function(){
    Route::group(['middleware' => 'admin.guest'],function(){
        Route::view('login','admin.login')->name('admin.login');
        Route::post('login',[App\Http\Controllers\AdminController::class,'login'])->name('admin.auth');        
    });
    Route::group(['middleware' => 'admin.auth'],function(){
        Route::view('dashboard','admin.home')->name('admin.home');
        Route::resource('products', ProductsController::class);
        Route::resource('orders', OrdersController::class);
        // Route::post('edit/item/{id}', [ProductsController::class,'update'])->name('products.update');
        Route::post('logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');

    });
});