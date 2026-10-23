<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets;

/**
 * Every policy number the targets calculator uses, in one place (RULES §2, §10).
 * Changing one changes people's plans: it needs a nutritionist's review, updated
 * tests and a new TargetsCalculator::FORMULA_VERSION.
 */
final class TargetRules
{
    /** Below this age the adult formulas don't apply: no deficit, see a professional (PLAN §4.3). */
    public const int ADULT_AGE = 18;

    /** Energy in one kg of body-weight change: the usual 7,700 kcal approximation. */
    public const int KCAL_PER_KG = 7700;

    public const int DAYS_PER_WEEK = 7;

    /** Fastest loss we plan for: 1 kg a week, and never more than 1% of body weight a week. */
    public const float MAX_WEEKLY_LOSS_KG = 1.0;

    public const float MAX_WEEKLY_LOSS_SHARE_OF_WEIGHT = 0.01;

    /** Fastest gain we plan for; faster gain is mostly fat. */
    public const float MAX_WEEKLY_GAIN_KG = 0.5;

    /** The daily calorie floor, whatever the goal (PLAN §4.3). */
    public const int MIN_DAILY_KCAL_FEMALE = 1200;

    public const int MIN_DAILY_KCAL_MALE = 1500;

    /** Protein in grams per kg of reference weight, by goal: more while losing, to keep muscle. */
    public const float PROTEIN_G_PER_KG_LOSING = 2.0;

    public const float PROTEIN_G_PER_KG_MAINTAINING = 1.6;

    public const float PROTEIN_G_PER_KG_GAINING = 1.8;

    /** Fat is a share of calories, but never below a minimum per kg of reference weight. */
    public const float FAT_SHARE_OF_KCAL = 0.25;

    public const float FAT_MIN_G_PER_KG = 0.6;

    /**
     * Per-kg macros use at most the weight at this BMI, so protein and fat don't
     * overshoot for larger bodies.
     */
    public const float REFERENCE_BMI = 25.0;

    public const int KCAL_PER_G_PROTEIN = 4;

    public const int KCAL_PER_G_CARBS = 4;

    public const int KCAL_PER_G_FAT = 9;

    /** Calorie targets are shown to the nearest 10 kcal: calm numbers (design system voice). */
    public const int KCAL_ROUNDING = 10;
}
