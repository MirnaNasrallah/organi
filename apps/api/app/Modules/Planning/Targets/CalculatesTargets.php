<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets;

interface CalculatesTargets
{
    public function calculate(TargetsInput $input): Targets;
}
