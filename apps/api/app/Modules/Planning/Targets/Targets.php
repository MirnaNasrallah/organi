<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets;

/** Daily calories and macros (CONTEXT §4), with the numbers behind them for explaining and reproducing. */
final readonly class Targets
{
    /**
     * @param  list<SafetyNote>  $notes
     */
    public function __construct(
        public int $kcal,
        public int $proteinG,
        public int $carbsG,
        public int $fatG,
        public int $bmrKcal,
        public int $maintenanceKcal,
        public array $notes,
        public string $formulaVersion,
    ) {}
}
