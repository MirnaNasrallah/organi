<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets;

use App\Modules\Planning\Targets\Bmr\BmrFormula;
use App\Modules\Planning\Targets\Bmr\KatchMcArdle;
use App\Modules\Planning\Targets\Bmr\MifflinStJeor;

use function max;
use function min;
use function round;

/**
 * Daily calories and macros from body stats and a goal (CONTEXT §7, steps 2–5), with the
 * safety gates from PLAN §4.3. Pure maths: no database, no AI. Every number comes from
 * TargetRules or a published formula.
 */
final class TargetsCalculator implements CalculatesTargets
{
    /** Stored on every plan so its numbers can be reproduced and explained (CONTEXT §7). */
    public const string FORMULA_VERSION = '1';

    private const int CM_PER_M = 100;

    public function calculate(TargetsInput $input): Targets
    {
        $bmr = $this->bmrFormula($input)->bmr($input);
        $maintenance = $bmr * $input->activity->factor();
        $notes = [];

        if ($this->needsProfessional($input)) {
            $goal = Goal::Maintain;
            $weeklyChangeKg = 0.0;
            $notes[] = SafetyNote::SeeAProfessional;
        } else {
            $goal = $input->goal;
            $requestedKg = $goal->direction() * $input->weeklyPaceKg;
            $weeklyChangeKg = $this->withinSafeRate($requestedKg, $input->weightKg);

            if ($weeklyChangeKg !== $requestedKg) {
                $notes[] = SafetyNote::PaceCapped;
            }
        }

        $kcal = $maintenance + $weeklyChangeKg * TargetRules::KCAL_PER_KG / TargetRules::DAYS_PER_WEEK;

        if ($kcal < $input->sex->minDailyKcal()) {
            $kcal = $input->sex->minDailyKcal();
            $notes[] = SafetyNote::RaisedToCalorieFloor;
        }

        $kcal = (int) (round($kcal / TargetRules::KCAL_ROUNDING) * TargetRules::KCAL_ROUNDING);
        [$proteinG, $carbsG, $fatG] = $this->macros($kcal, $goal, $input);

        return new Targets(
            kcal: $kcal,
            proteinG: $proteinG,
            carbsG: $carbsG,
            fatG: $fatG,
            bmrKcal: (int) round($bmr),
            maintenanceKcal: (int) round($maintenance),
            notes: $notes,
            formulaVersion: self::FORMULA_VERSION,
        );
    }

    private function bmrFormula(TargetsInput $input): BmrFormula
    {
        return $input->bodyFatPercent === null ? new MifflinStJeor : new KatchMcArdle;
    }

    private function needsProfessional(TargetsInput $input): bool
    {
        return $input->ageYears < TargetRules::ADULT_AGE || $input->conditions !== [];
    }

    /** The weekly change, clamped to the fastest safe loss or gain. Negative means losing. */
    private function withinSafeRate(float $weeklyChangeKg, float $weightKg): float
    {
        $maxLossKg = min(TargetRules::MAX_WEEKLY_LOSS_KG, $weightKg * TargetRules::MAX_WEEKLY_LOSS_SHARE_OF_WEIGHT);

        return max(-$maxLossKg, min(TargetRules::MAX_WEEKLY_GAIN_KG, $weeklyChangeKg));
    }

    /**
     * Protein by goal, fat as a share of calories with a floor, carbs as the remainder (CONTEXT §7, step 5).
     *
     * @return array{int, int, int} protein, carbs and fat in grams
     */
    private function macros(int $kcal, Goal $goal, TargetsInput $input): array
    {
        $heightM = $input->heightCm / self::CM_PER_M;
        $referenceKg = min($input->weightKg, TargetRules::REFERENCE_BMI * $heightM ** 2);

        $proteinG = $goal->proteinGramsPerKg() * $referenceKg;
        $fatG = max(
            TargetRules::FAT_MIN_G_PER_KG * $referenceKg,
            $kcal * TargetRules::FAT_SHARE_OF_KCAL / TargetRules::KCAL_PER_G_FAT,
        );
        $remainingKcal = $kcal - $proteinG * TargetRules::KCAL_PER_G_PROTEIN - $fatG * TargetRules::KCAL_PER_G_FAT;
        $carbsG = max(0, $remainingKcal / TargetRules::KCAL_PER_G_CARBS);

        return [(int) round($proteinG), (int) round($carbsG), (int) round($fatG)];
    }
}
