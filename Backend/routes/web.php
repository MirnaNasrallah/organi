<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlanDayController;
use App\Http\Controllers\PlanItemController;
use App\Http\Controllers\BMIRecordController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;

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
    return view('mainPage');
});

// Index routes for all models
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/order-items', [OrderItemController::class, 'index'])->name('order-items.index');
Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
Route::get('/plan-days', [PlanDayController::class, 'index'])->name('plan-days.index');
Route::get('/plan-items', [PlanItemController::class, 'index'])->name('plan-items.index');
Route::get('/bmi-records', [BMIRecordController::class, 'index'])->name('bmi-records.index');
Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/wishlists', [WishlistController::class, 'index'])->name('wishlists.index');
Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
