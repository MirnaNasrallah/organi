<?php

declare(strict_types=1);

namespace App\Modules\Planning\Tests\Unit;

use App\Modules\Planning\Targets\ActivityLevel;
use App\Modules\Planning\Targets\Bmr\KatchMcArdle;
use App\Modules\Planning\Targets\Bmr\MifflinStJeor;
use App\Modules\Planning\Targets\Goal;
use App\Modules\Planning\Targets\Sex;
use App\Modules\Planning\Targets\TargetsInput;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MifflinStJeor::class)]
#[CoversClass(KatchMcArdle::class)]
#[CoversClass(TargetsInput::class)]
final class BmrFormulaTest extends TestCase
{
    private const float DELTA = 0.001;

    #[Test]
    public function mifflin_st_jeor_for_a_man(): void
    {
        // 10 × 80 + 6.25 × 180 − 5 × 30 + 5
        $this->assertEqualsWithDelta(1780.0, (new MifflinStJeor)->bmr($this->person(Sex::Male, 30, 180, 80)), self::DELTA);
    }

    #[Test]
    public function mifflin_st_jeor_for_a_woman(): void
    {
        // 10 × 60 + 6.25 × 165 − 5 × 30 − 161
        $this->assertEqualsWithDelta(1320.25, (new MifflinStJeor)->bmr($this->person(Sex::Female, 30, 165, 60)), self::DELTA);
    }

    #[Test]
    public function katch_mcardle_uses_lean_mass(): void
    {
        // 370 + 21.6 × (80 × 0.8)
        $this->assertEqualsWithDelta(1752.4, (new KatchMcArdle)->bmr($this->person(Sex::Male, 30, 180, 80, bodyFat: 20.0)), self::DELTA);
    }

    #[Test]
    public function katch_mcardle_refuses_to_guess_body_fat(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new KatchMcArdle)->bmr($this->person(Sex::Male, 30, 180, 80));
    }

    private function person(Sex $sex, int $age, float $heightCm, float $weightKg, ?float $bodyFat = null): TargetsInput
    {
        return new TargetsInput($sex, $age, $heightCm, $weightKg, ActivityLevel::Sedentary, Goal::Maintain, bodyFatPercent: $bodyFat);
    }
}
