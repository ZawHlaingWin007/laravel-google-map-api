<?php

use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/shops', [ShopController::class, 'getNearByShops'])->name('shops.getNearByShops');
Route::get('/shops/{shop}', [ShopController::class, 'getShopBySlug'])->name('shops.getShopBySlug');
