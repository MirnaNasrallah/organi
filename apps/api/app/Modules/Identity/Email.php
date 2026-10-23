<?php

declare(strict_types=1);

namespace App\Modules\Identity;

use Illuminate\Support\Str;

use function trim;

/** One account per address whatever its case or spacing: the old app let duplicates in (CONTEXT §2). */
final class Email
{
    public static function normalise(string $email): string
    {
        return Str::lower(trim($email));
    }
}
