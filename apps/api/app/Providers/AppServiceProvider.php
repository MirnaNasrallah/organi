<?php

declare(strict_types=1);

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\Server;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Lazy loading, silently dropped attributes and missing attributes throw outside production (RULES §6).
        Model::shouldBeStrict(! $this->app->isProduction());

        // A relative server keeps the committed spec identical on every machine, whatever APP_URL is.
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi): void {
            $openApi->servers = [new Server('/api/v1')];
        });
    }
}
