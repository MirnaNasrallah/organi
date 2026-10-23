<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets\Bmr;

use App\Modules\Planning\Targets\TargetsInput;
use InvalidArgumentException;

/** Katch-McArdle: from lean body mass, so used only when body fat % is known. */
final class KatchMcArdle implements BmrFormula
{
    public function bmr(TargetsInput $input): float
    {
        $bodyFatPercent = $input->bodyFatPercent
            ?? throw new InvalidArgumentException('Katch-McArdle needs a body fat percentage.');

        $leanMassKg = $input->weightKg * (1 - $bodyFatPercent / 100);

        return 370 + 21.6 * $leanMassKg;
    }
}
