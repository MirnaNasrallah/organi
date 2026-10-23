<?php

declare(strict_types=1);

namespace App\Modules\Planning;

use App\Modules\Planning\Targets\CalculatesTargets;
use App\Modules\Planning\Targets\TargetsCalculator;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

final class PlanningServiceProvider extends ServiceProvider
{
    /** Per IP: plenty for someone filling in a calculator, too few for scraping it (RULES §9). */
    public const int CALCULATOR_REQUESTS_PER_MINUTE = 60;

    public function register(): void
    {
        $this->app->bind(CalculatesTargets::class, TargetsCalculator::class);
    }

    public function boot(): void
    {
        RateLimiter::for(
            'calculator',
            fn (Request $request) => Limit::perMinute(self::CALCULATOR_REQUESTS_PER_MINUTE)->by($request->ip() ?? ''),
        );
    }
}
