<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets\Bmr;

use App\Modules\Planning\Targets\TargetsInput;

/** Resting energy use in kcal a day. A new formula is a new class (RULES §5). */
interface BmrFormula
{
    public function bmr(TargetsInput $input): float;
}
