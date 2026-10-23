<?php

declare(strict_types=1);

namespace App\Modules\Planning\Http\Requests;

use App\Modules\Planning\Targets\ActivityLevel;
use App\Modules\Planning\Targets\Goal;
use App\Modules\Planning\Targets\HealthCondition;
use App\Modules\Planning\Targets\Sex;
use App\Modules\Planning\Targets\TargetsInput;
use App\Modules\Shared\Http\Requests\NormalisesDigits;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function array_values;

final class CalculateTargetsRequest extends FormRequest
{
    use NormalisesDigits;

    // Plausible human ranges: anything outside is a typo, not a person. Safety limits live in TargetRules.
    private const int MIN_AGE = 13;

    private const int MAX_AGE = 100;

    private const int MIN_HEIGHT_CM = 100;

    private const int MAX_HEIGHT_CM = 250;

    private const int MIN_WEIGHT_KG = 30;

    private const int MAX_WEIGHT_KG = 300;

    private const int MIN_BODY_FAT_PERCENT = 3;

    private const int MAX_BODY_FAT_PERCENT = 70;

    /** Above the safe rate on purpose: the calculator caps the pace itself and says so (`pace_capped`). */
    private const int MAX_WEEKLY_PACE_KG = 2;

    /**
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        return [
            'sex' => ['required', Rule::enum(Sex::class)],
            'age' => ['required', 'integer', 'between:'.self::MIN_AGE.','.self::MAX_AGE],
            'height_cm' => ['required', 'numeric', 'between:'.self::MIN_HEIGHT_CM.','.self::MAX_HEIGHT_CM],
            'weight_kg' => ['required', 'numeric', 'between:'.self::MIN_WEIGHT_KG.','.self::MAX_WEIGHT_KG],
            'activity' => ['required', Rule::enum(ActivityLevel::class)],
            'goal' => ['required', Rule::enum(Goal::class)],
            'weekly_pace_kg' => ['required_unless:goal,'.Goal::Maintain->value, 'numeric', 'between:0,'.self::MAX_WEEKLY_PACE_KG],
            'body_fat_percent' => ['nullable', 'numeric', 'between:'.self::MIN_BODY_FAT_PERCENT.','.self::MAX_BODY_FAT_PERCENT],
            'conditions' => ['array'],
            'conditions.*' => ['distinct', Rule::enum(HealthCondition::class)],
        ];
    }

    public function toInput(): TargetsInput
    {
        return new TargetsInput(
            sex: Sex::from($this->string('sex')->value()),
            ageYears: $this->integer('age'),
            heightCm: $this->float('height_cm'),
            weightKg: $this->float('weight_kg'),
            activity: ActivityLevel::from($this->string('activity')->value()),
            goal: Goal::from($this->string('goal')->value()),
            weeklyPaceKg: $this->float('weekly_pace_kg'),
            bodyFatPercent: $this->filled('body_fat_percent') ? $this->float('body_fat_percent') : null,
            conditions: array_values($this->enums('conditions', HealthCondition::class)),
        );
    }

    /**
     * @return list<string>
     */
    protected function numberFields(): array
    {
        return ['age', 'height_cm', 'weight_kg', 'weekly_pace_kg', 'body_fat_percent'];
    }
}
