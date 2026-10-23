<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets;

enum ActivityLevel: string
{
    case Sedentary = 'sedentary';
    case Light = 'light';
    case Moderate = 'moderate';
    case Active = 'active';
    case VeryActive = 'very_active';

    /** The standard multipliers from resting energy (BMR) to daily energy use (TDEE). */
    private const array FACTORS = [
        'sedentary' => 1.2,
        'light' => 1.375,
        'moderate' => 1.55,
        'active' => 1.725,
        'very_active' => 1.9,
    ];

    public function factor(): float
    {
        return self::FACTORS[$this->value];
    }
}
