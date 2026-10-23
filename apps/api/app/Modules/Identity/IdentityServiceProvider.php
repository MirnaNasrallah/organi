<?php

declare(strict_types=1);

namespace App\Modules\Identity;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

final class IdentityServiceProvider extends ServiceProvider
{
    /** Sign-up and sign-in attempts per minute, per email and IP: slows password guessing (RULES §9). */
    public const int AUTH_ATTEMPTS_PER_MINUTE = 5;

    /** Length over character rules, as NIST SP 800-63B recommends. */
    public const int PASSWORD_MIN_LENGTH = 8;

    public function boot(): void
    {
        Password::defaults(fn (): Password => Password::min(self::PASSWORD_MIN_LENGTH));

        RateLimiter::for('auth', fn (Request $request): Limit => Limit::perMinute(self::AUTH_ATTEMPTS_PER_MINUTE)
            ->by(Email::normalise($request->string('email')->value()).'|'.$request->ip()));
    }
}
