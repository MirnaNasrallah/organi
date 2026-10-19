<?php

declare(strict_types=1);

namespace App\Modules\Shared;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

enum Locale: string
{
    case English = 'en';
    case Arabic = 'ar';

    public static function default(): self
    {
        return self::from(Config::string('app.locale'));
    }

    public static function current(): self
    {
        return self::from(App::currentLocale());
    }

    /**
     * Locale codes for content negotiation, default first, because Symfony
     * falls back to the first entry when Accept-Language matches none of them.
     *
     * @return list<string>
     */
    public static function negotiable(): array
    {
        $default = self::default();

        $others = array_filter(self::cases(), fn (self $locale): bool => $locale !== $default);

        return [$default->value, ...array_map(fn (self $locale): string => $locale->value, array_values($others))];
    }
}
