<?php

declare(strict_types=1);

namespace App\Modules\Shared\Http\Middleware;

use App\Modules\Shared\Locale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

final class SetLocaleFromHeader
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->getPreferredLanguage(Locale::negotiable()) ?? Locale::default()->value;

        App::setLocale($locale);

        $response = $next($request);

        // Content differs per language (ADR 0002), so shared caches must key on it.
        $response->setVary('Accept-Language', replace: false);
        $response->headers->set('Content-Language', $locale);

        return $response;
    }
}
