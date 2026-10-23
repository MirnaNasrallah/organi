<?php

declare(strict_types=1);

use App\Modules\Identity\Http\Controllers\CurrentUserController;
use App\Modules\Identity\Http\Controllers\LoginController;
use App\Modules\Identity\Http\Controllers\LogoutController;
use App\Modules\Identity\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:auth')->group(function (): void {
    Route::post('auth/register', RegisterController::class)->name('auth.register');
    Route::post('auth/login', LoginController::class)->name('auth.login');
});

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('auth/logout', LogoutController::class)->name('auth.logout');
    Route::get('me', CurrentUserController::class)->name('me');
});
