<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Lazy loading, silently dropped attributes and missing attributes throw outside production (RULES §6).
        Model::shouldBeStrict(! $this->app->isProduction());
    }
}
