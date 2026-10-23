<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets;

enum Goal: string
{
    case LoseFat = 'lose_fat';
    case Maintain = 'maintain';
    case GainMuscle = 'gain_muscle';

    /** The sign of the weekly weight change each goal aims for. */
    private const array DIRECTION = [
        'lose_fat' => -1,
        'maintain' => 0,
        'gain_muscle' => 1,
    ];

    private const array PROTEIN_G_PER_KG = [
        'lose_fat' => TargetRules::PROTEIN_G_PER_KG_LOSING,
        'maintain' => TargetRules::PROTEIN_G_PER_KG_MAINTAINING,
        'gain_muscle' => TargetRules::PROTEIN_G_PER_KG_GAINING,
    ];

    public function direction(): int
    {
        return self::DIRECTION[$this->value];
    }

    public function proteinGramsPerKg(): float
    {
        return self::PROTEIN_G_PER_KG[$this->value];
    }
}
