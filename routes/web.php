<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\wishlistController;
use Illuminate\Support\Facades\App;
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

Route::get('/',[ShopController::class,'mainPageindex'])->name('/');

Route::get('/shop',[ShopController::class,'shopIndex'])->name('shop');

Route::get('/search',[ShopController::class,'searchIndex'])->name('search');

Route::get('/wishlist',[AuthController::class,'wish'])->name('wishlist');

Route::get('/cart',[AuthController::class,'cart'])->name('cart');

Route::get('/shopLow',[ShopController::class,'shopIndexLow'])->name('shopLow');

Route::get('/shopHigh',[ShopController::class,'shopIndexHigh'])->name('shopHigh');

Route::get('/shopPlan',[ShopController::class,'shopIndexPlan'])->name('shopPlan');
/*********************/

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('/addtowishlist/{id}',[AuthController::class,'addtowishlist']);
Route::get('/deletefromwishlist/{id}',[AuthController::class,'deletefromwishlist']);
Route::get('/deletefromcart/{id}',[AuthController::class,'deletefromcart']);
Route::get('/addtocart/{id}',[AuthController::class,'addtocart']);
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('dashboard', [AuthController::class, 'update'])->name('user.update');


Route::get('logout', [AuthController::class, 'logout'])->name('logout');
