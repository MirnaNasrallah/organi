<?php

declare(strict_types=1);

namespace App\Modules\Planning\Tests\Feature;

use App\Modules\Planning\PlanningServiceProvider;
use App\Modules\Planning\Targets\TargetsCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CalculateTargetsTest extends TestCase
{
    private const string URL = '/api/v1/targets';

    private const array MAN_MAINTAINING = [
        'sex' => 'male',
        'age' => 30,
        'height_cm' => 180,
        'weight_kg' => 80,
        'activity' => 'moderate',
        'goal' => 'maintain',
    ];

    #[Test]
    public function it_calculates_targets_without_an_account(): void
    {
        $this->postJson(self::URL, self::MAN_MAINTAINING)
            ->assertOk()
            ->assertExactJson(['data' => [
                'kcal' => 2760,
                'protein_g' => 128,
                'carbs_g' => 390,
                'fat_g' => 77,
                'bmr_kcal' => 1780,
                'maintenance_kcal' => 2759,
                'notes' => [],
                'formula_version' => TargetsCalculator::FORMULA_VERSION,
            ]]);
    }

    #[Test]
    public function it_explains_when_the_safety_gates_changed_the_targets(): void
    {
        $this->postJson(self::URL, [
            'sex' => 'female',
            'age' => 30,
            'height_cm' => 165,
            'weight_kg' => 60,
            'activity' => 'light',
            'goal' => 'lose_fat',
            'weekly_pace_kg' => 1,
        ])
            ->assertOk()
            ->assertJsonPath('data.kcal', 1200)
            ->assertJsonPath('data.notes', ['pace_capped', 'raised_to_calorie_floor']);
    }

    #[Test]
    public function it_refers_people_who_report_a_condition(): void
    {
        $this->postJson(self::URL, [...self::MAN_MAINTAINING, 'goal' => 'lose_fat', 'weekly_pace_kg' => 0.5, 'conditions' => ['diabetes']])
            ->assertOk()
            ->assertJsonPath('data.notes', ['see_a_professional'])
            ->assertJsonPath('data.kcal', 2760);
    }

    #[Test]
    public function it_accepts_numbers_typed_on_an_arabic_keyboard(): void
    {
        $this->postJson(self::URL, [...self::MAN_MAINTAINING, 'age' => '٣٠', 'height_cm' => '١٨٠', 'weight_kg' => '٨٠٫٠'])
            ->assertOk()
            ->assertJsonPath('data.kcal', 2760);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function impossibleInputs(): iterable
    {
        $person = self::MAN_MAINTAINING;
        unset($person['sex']);

        yield 'no sex' => [$person, 'sex'];
        yield 'too young for the formulas' => [[...self::MAN_MAINTAINING, 'age' => 8], 'age'];
        yield 'a weight that is a typo' => [[...self::MAN_MAINTAINING, 'weight_kg' => 800], 'weight_kg'];
        yield 'an unknown activity' => [[...self::MAN_MAINTAINING, 'activity' => 'couch'], 'activity'];
        yield 'losing without a pace' => [[...self::MAN_MAINTAINING, 'goal' => 'lose_fat'], 'weekly_pace_kg'];
        yield 'a negative pace' => [[...self::MAN_MAINTAINING, 'goal' => 'lose_fat', 'weekly_pace_kg' => -0.5], 'weekly_pace_kg'];
        yield 'an implausible body fat' => [[...self::MAN_MAINTAINING, 'body_fat_percent' => 90], 'body_fat_percent'];
        yield 'an unknown condition' => [[...self::MAN_MAINTAINING, 'conditions' => ['flu']], 'conditions.0'];
        yield 'a repeated condition' => [[...self::MAN_MAINTAINING, 'conditions' => ['diabetes', 'diabetes']], 'conditions.0'];
    }

    /**
     * @param  array<string, mixed>  $input
     */
    #[Test]
    #[DataProvider('impossibleInputs')]
    public function it_rejects_impossible_input(array $input, string $field): void
    {
        $this->postJson(self::URL, $input)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([$field]);
    }

    #[Test]
    public function it_is_rate_limited(): void
    {
        for ($i = 0; $i < PlanningServiceProvider::CALCULATOR_REQUESTS_PER_MINUTE; $i++) {
            $this->postJson(self::URL, self::MAN_MAINTAINING)->assertOk();
        }

        $this->postJson(self::URL, self::MAN_MAINTAINING)->assertTooManyRequests();
    }
}
