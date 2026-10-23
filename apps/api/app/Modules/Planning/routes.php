<?php

declare(strict_types=1);

use App\Modules\Planning\Http\Controllers\CalculateTargetsController;
use Illuminate\Support\Facades\Route;

Route::post('targets', CalculateTargetsController::class)
    ->middleware('throttle:calculator')
    ->name('targets.calculate');
