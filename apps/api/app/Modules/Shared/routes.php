<?php

declare(strict_types=1);

use App\Modules\Shared\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

Route::get('status', StatusController::class)->name('status');
