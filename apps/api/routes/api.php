<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// Every module brings its own routes file; all of them live under /api/v1 (RULES §6, §8).
Route::prefix('v1')->name('v1.')->group(function (): void {
    require app_path('Modules/Shared/routes.php');
});
