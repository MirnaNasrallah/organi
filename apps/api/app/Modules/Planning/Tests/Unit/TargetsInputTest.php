<?php

declare(strict_types=1);

namespace App\Modules\Planning\Tests\Unit;

use App\Modules\Planning\Targets\ActivityLevel;
use App\Modules\Planning\Targets\Goal;
use App\Modules\Planning\Targets\Sex;
use App\Modules\Planning\Targets\TargetsInput;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TargetsInput::class)]
final class TargetsInputTest extends TestCase
{
    /**
     * @return iterable<string, array{float, float, float, int, float|null}>
     */
    public static function impossibleValues(): iterable
    {
        // pace, height, weight, age, body fat
        yield 'a negative pace, which would turn a loss into a gain' => [-0.5, 170, 70, 30, null];
        yield 'no height' => [0.5, 0, 70, 30, null];
        yield 'no weight' => [0.5, 170, 0, 30, null];
        yield 'a negative age' => [0.5, 170, 70, -1, null];
        yield 'no body fat' => [0.5, 170, 70, 30, 0.0];
        yield 'all body fat' => [0.5, 170, 70, 30, 100.0];
    }

    #[Test]
    #[DataProvider('impossibleValues')]
    public function it_refuses_impossible_values(float $pace, float $heightCm, float $weightKg, int $age, ?float $bodyFat): void
    {
        $this->expectException(InvalidArgumentException::class);

        new TargetsInput(Sex::Female, $age, $heightCm, $weightKg, ActivityLevel::Light, Goal::LoseFat, $pace, $bodyFat);
    }

    #[Test]
    public function it_accepts_a_realistic_person(): void
    {
        $input = new TargetsInput(Sex::Female, 30, 165, 60, ActivityLevel::Light, Goal::LoseFat, 0.5, 28.0);

        $this->assertSame(28.0, $input->bodyFatPercent);
    }
}
