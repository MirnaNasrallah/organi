<?php

declare(strict_types=1);

namespace App\Modules\Planning\Tests\Unit;

use App\Modules\Planning\Targets\ActivityLevel;
use App\Modules\Planning\Targets\Goal;
use App\Modules\Planning\Targets\HealthCondition;
use App\Modules\Planning\Targets\SafetyNote;
use App\Modules\Planning\Targets\Sex;
use App\Modules\Planning\Targets\TargetRules;
use App\Modules\Planning\Targets\Targets;
use App\Modules\Planning\Targets\TargetsCalculator;
use App\Modules\Planning\Targets\TargetsInput;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Expected values were worked out by hand and checked against an independent
 * implementation. A change here is a change to people's plans (RULES §10).
 */
#[CoversClass(TargetsCalculator::class)]
#[CoversClass(Sex::class)]
#[CoversClass(ActivityLevel::class)]
#[CoversClass(Goal::class)]
#[CoversClass(TargetsInput::class)]
#[CoversClass(Targets::class)]
final class TargetsCalculatorTest extends TestCase
{
    /**
     * @return iterable<string, array{TargetsInput, Targets}>
     */
    public static function people(): iterable
    {
        // BMR 1780, maintenance 1780 × 1.55 = 2759. Protein 1.6 × 80, fat 25% of kcal, carbs the rest.
        yield 'a moderately active man maintaining' => [
            new TargetsInput(Sex::Male, 30, 180, 80, ActivityLevel::Moderate, Goal::Maintain),
            self::targets(kcal: 2760, protein: 128, carbs: 390, fat: 77, bmr: 1780, maintenance: 2759),
        ];

        yield 'maintaining ignores any pace' => [
            new TargetsInput(Sex::Male, 30, 180, 80, ActivityLevel::Moderate, Goal::Maintain, weeklyPaceKg: 0.5),
            self::targets(kcal: 2760, protein: 128, carbs: 390, fat: 77, bmr: 1780, maintenance: 2759),
        ];

        // 0.5 kg a week = 550 kcal a day under maintenance; protein rises to 2.0 g/kg.
        yield 'losing 0.5 kg a week' => [
            new TargetsInput(Sex::Male, 30, 180, 80, ActivityLevel::Moderate, Goal::LoseFat, weeklyPaceKg: 0.5),
            self::targets(kcal: 2210, protein: 160, carbs: 254, fat: 61, bmr: 1780, maintenance: 2759),
        ];

        // Asked for 1 kg a week of gain; capped at 0.5 kg = 550 kcal a day over maintenance.
        yield 'gaining faster than the safe rate' => [
            new TargetsInput(Sex::Male, 30, 180, 80, ActivityLevel::Moderate, Goal::GainMuscle, weeklyPaceKg: 1.0),
            self::targets(kcal: 3310, protein: 144, carbs: 477, fat: 92, bmr: 1780, maintenance: 2759, notes: [SafetyNote::PaceCapped]),
        ];

        // 1 kg a week is more than 1% of 60 kg, so 0.6 kg; 1815 − 660 = 1155 is under the floor.
        yield 'a small woman asking to lose fast' => [
            new TargetsInput(Sex::Female, 30, 165, 60, ActivityLevel::Light, Goal::LoseFat, weeklyPaceKg: 1.0),
            self::targets(kcal: 1200, protein: 120, carbs: 99, fat: 36, bmr: 1320, maintenance: 1815, notes: [SafetyNote::PaceCapped, SafetyNote::RaisedToCalorieFloor]),
        ];

        // Under 18: maintenance only, maintenance protein, and see a professional.
        yield 'a 17-year-old asking to lose' => [
            new TargetsInput(Sex::Male, 17, 175, 70, ActivityLevel::Active, Goal::LoseFat, weeklyPaceKg: 0.5),
            self::targets(kcal: 2960, protein: 112, carbs: 443, fat: 82, bmr: 1714, maintenance: 2956, notes: [SafetyNote::SeeAProfessional]),
        ];

        // Body fat known: BMR from lean mass, 370 + 21.6 × 64.
        yield 'a very active man with a known body fat' => [
            new TargetsInput(Sex::Male, 30, 180, 80, ActivityLevel::VeryActive, Goal::Maintain, bodyFatPercent: 20.0),
            self::targets(kcal: 3330, protein: 128, carbs: 496, fat: 93, bmr: 1752, maintenance: 3330),
        ];

        // Per-kg macros use the weight at BMI 25 (72.25 kg), not 120 kg.
        yield 'a larger body losing' => [
            new TargetsInput(Sex::Female, 35, 170, 120, ActivityLevel::Sedentary, Goal::LoseFat, weeklyPaceKg: 0.5),
            self::targets(kcal: 1760, protein: 144, carbs: 186, fat: 49, bmr: 1927, maintenance: 2312),
        ];
    }

    #[Test]
    #[DataProvider('people')]
    public function it_calculates_targets(TargetsInput $input, Targets $expected): void
    {
        $this->assertEquals($expected, (new TargetsCalculator)->calculate($input));
    }

    /**
     * @return iterable<string, array{HealthCondition}>
     */
    public static function conditions(): iterable
    {
        foreach (HealthCondition::cases() as $condition) {
            yield $condition->value => [$condition];
        }
    }

    #[Test]
    #[DataProvider('conditions')]
    public function every_reported_condition_means_no_deficit_and_a_professional(HealthCondition $condition): void
    {
        // BMR 1314, maintenance 1314 × 1.2 = 1576.8; the requested 0.5 kg a week is ignored.
        $input = new TargetsInput(Sex::Female, 45, 160, 70, ActivityLevel::Sedentary, Goal::LoseFat, weeklyPaceKg: 0.5, conditions: [$condition]);

        $this->assertEquals(
            self::targets(kcal: 1580, protein: 102, carbs: 194, fat: 44, bmr: 1314, maintenance: 1577, notes: [SafetyNote::SeeAProfessional]),
            (new TargetsCalculator)->calculate($input),
        );
    }

    #[Test]
    public function no_one_is_planned_below_the_floor_or_faster_than_the_safe_rate(): void
    {
        $calculator = new TargetsCalculator;
        $checked = 0;

        foreach (Sex::cases() as $sex) {
            foreach ([18, 45, 75] as $age) {
                foreach ([150.0, 175.0, 195.0] as $heightCm) {
                    foreach ([45.0, 70.0, 140.0] as $weightKg) {
                        foreach (ActivityLevel::cases() as $activity) {
                            foreach (Goal::cases() as $goal) {
                                foreach ([0.0, 0.25, 0.5, 1.0, 2.0] as $pace) {
                                    $targets = $calculator->calculate(new TargetsInput($sex, $age, $heightCm, $weightKg, $activity, $goal, $pace));
                                    $this->assertSafe($targets, $sex, $weightKg);
                                    $checked++;
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->assertSame(2 * 3 * 3 * 3 * 5 * 3 * 5, $checked);
    }

    private function assertSafe(Targets $targets, Sex $sex, float $weightKg): void
    {
        $this->assertGreaterThanOrEqual($sex->minDailyKcal(), $targets->kcal);

        $maxDailyDeficit = min(TargetRules::MAX_WEEKLY_LOSS_KG, $weightKg * TargetRules::MAX_WEEKLY_LOSS_SHARE_OF_WEIGHT)
            * TargetRules::KCAL_PER_KG / TargetRules::DAYS_PER_WEEK;
        $this->assertGreaterThanOrEqual($targets->maintenanceKcal - $maxDailyDeficit - TargetRules::KCAL_ROUNDING, $targets->kcal);

        $this->assertGreaterThan(0, $targets->proteinG);
        $this->assertGreaterThan(0, $targets->fatG);
        $this->assertGreaterThanOrEqual(0, $targets->carbsG);

        // Macros add back up to the calorie target, give or take gram rounding.
        $macroKcal = $targets->proteinG * TargetRules::KCAL_PER_G_PROTEIN
            + $targets->carbsG * TargetRules::KCAL_PER_G_CARBS
            + $targets->fatG * TargetRules::KCAL_PER_G_FAT;
        $this->assertEqualsWithDelta($targets->kcal, $macroKcal, TargetRules::KCAL_PER_G_FAT);
    }

    /**
     * @param  list<SafetyNote>  $notes
     */
    private static function targets(int $kcal, int $protein, int $carbs, int $fat, int $bmr, int $maintenance, array $notes = []): Targets
    {
        return new Targets($kcal, $protein, $carbs, $fat, $bmr, $maintenance, $notes, TargetsCalculator::FORMULA_VERSION);
    }
}
