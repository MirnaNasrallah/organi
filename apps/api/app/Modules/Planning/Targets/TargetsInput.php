<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets;

use InvalidArgumentException;

/**
 * What the calculator needs. Requests are validated at the boundary (RULES §7); this refuses
 * impossible values as a last line of defence, because a negative pace would turn a loss into a gain.
 */
final readonly class TargetsInput
{
    /**
     * @param  float  $weeklyPaceKg  How fast to lose or gain, in kg per week; ignored when maintaining.
     * @param  float|null  $bodyFatPercent  When known, BMR comes from lean mass (Katch-McArdle).
     * @param  list<HealthCondition>  $conditions
     */
    public function __construct(
        public Sex $sex,
        public int $ageYears,
        public float $heightCm,
        public float $weightKg,
        public ActivityLevel $activity,
        public Goal $goal,
        public float $weeklyPaceKg = 0.0,
        public ?float $bodyFatPercent = null,
        public array $conditions = [],
    ) {
        $impossibleBodyFat = $bodyFatPercent !== null && ($bodyFatPercent <= 0 || $bodyFatPercent >= 100);

        if ($weeklyPaceKg < 0 || $heightCm <= 0 || $weightKg <= 0 || $ageYears < 0 || $impossibleBodyFat) {
            throw new InvalidArgumentException(
                'Targets need a pace of 0 or more, a positive height and weight, an age of 0 or more, and body fat between 0 and 100%.',
            );
        }
    }
}
