<?php

use Illuminate\Http\Request;
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
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Index routes for all models
Route::get('/users', [UserController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/order-items', [OrderItemController::class, 'index']);
Route::get('/plans', [PlanController::class, 'index']);
Route::get('/plan-days', [PlanDayController::class, 'index']);
Route::get('/plan-items', [PlanItemController::class, 'index']);
Route::get('/bmi-records', [BMIRecordController::class, 'index']);
Route::get('/payments', [PaymentController::class, 'index']);
Route::get('/wishlists', [WishlistController::class, 'index']);
Route::get('/carts', [CartController::class, 'index']);
