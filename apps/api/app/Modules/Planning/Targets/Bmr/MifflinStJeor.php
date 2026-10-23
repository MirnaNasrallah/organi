<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets\Bmr;

use App\Modules\Planning\Targets\TargetsInput;

/** Mifflin-St Jeor (1990): the default, more accurate than the Harris-Benedict the old app used. */
final class MifflinStJeor implements BmrFormula
{
    private const array SEX_ADJUSTMENT = [
        'female' => -161,
        'male' => 5,
    ];

    public function bmr(TargetsInput $input): float
    {
        return 10 * $input->weightKg
            + 6.25 * $input->heightCm
            - 5 * $input->ageYears
            + self::SEX_ADJUSTMENT[$input->sex->value];
    }
}
