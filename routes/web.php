<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/product_lists',[\App\Http\Controllers\backend\ProductController::class,'product_lists']);
Route::post('/add_to_cart',[\App\Http\Controllers\backend\ProductController::class,'add_to_carts'])->name('add_to_cart');
Route::post('/cart_session_delete',[\App\Http\Controllers\backend\ProductController::class,'destroy'])->name('cart_session_delete');
Route::get('/cart_details',[\App\Http\Controllers\frontend\FrontendController::class,'cart_details'])->name('cart_details');
Route::get('/product_view',[\App\Http\Controllers\backend\ProductController::class,'create'])->name('product_view');
Route::get('/product_table_list',[\App\Http\Controllers\backend\ProductController::class,'product_table_view'])->name('product_table');
Route::get('/product_read/{id}',[\App\Http\Controllers\backend\ProductController::class,'product_read'])->name('product_reads');


Route::resource('/',\App\Http\Controllers\frontend\FrontendController::class);
Route::resource('/add_product',\App\Http\Controllers\frontend\FrontendController::class);   
Route::resource('/cart',\App\Http\Controllers\backend\ProductController::class);