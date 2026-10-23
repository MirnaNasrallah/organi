<?php

declare(strict_types=1);

namespace App\Modules\Shared;

use function strtr;

/** Numbers are always Western digits (ADR 0006); what people type on Arabic keyboards is converted on the way in. */
final class Digits
{
    private const array WESTERN = [
        // Arabic-Indic
        '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
        '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
        // Extended Arabic-Indic (Persian and Urdu keyboards)
        '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
        '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
        // Arabic decimal separator
        '٫' => '.',
    ];

    public static function toWestern(string $value): string
    {
        return strtr($value, self::WESTERN);
    }
}
