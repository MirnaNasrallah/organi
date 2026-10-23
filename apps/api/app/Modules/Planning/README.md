# Planning

Owns the plan engine (CONTEXT §7): targets now; plan versions, meal slots and the menu composer later.

## Public surface

- `CalculatesTargets` / `TargetsCalculator`: body stats and a goal in (`TargetsInput`), daily calories and macros out (`Targets`). Pure PHP, with no database and no AI.
- `Targets::$notes`: why the result differs from what was asked (`SafetyNote`), so the apps can explain it.
- `TargetsCalculator::FORMULA_VERSION`: stored on every plan so results can be reproduced.

## How targets are worked out

1. **BMR:** Mifflin-St Jeor, or Katch-McArdle when body fat % is known.
2. **Maintenance:** BMR × activity factor.
3. **Safety gates (PLAN §4.3):**
   - Under 18 or any reported condition (pregnant, breastfeeding, diabetes, kidney disease, eating-disorder history): maintenance only, plus `see_a_professional`.
   - Otherwise the weekly pace is capped at 1 kg (and at 1% of body weight) for loss, or 0.5 kg for gain: `pace_capped`.
   - The result never goes below the daily floor for the person's sex: `raised_to_calorie_floor`.
4. **Calories:** maintenance ± pace × 7,700 kcal ÷ 7, rounded to the nearest 10.
5. **Macros:** protein by goal, fat at 25% of calories with a per-kg minimum, carbs as the remainder. Per-kg amounts use at most the weight at BMI 25, so they don't overshoot for larger bodies.

## Numbers that need a nutritionist's review

All of these are in `TargetRules`. They're common evidence-based defaults, not clinical advice, and need sign-off before public beta (PLAN §8). Changing any of them means updated tests and a new `FORMULA_VERSION`.

| Rule | Value |
|---|---|
| Adult age | 18 |
| Max weekly loss | 1.0 kg and 1% of body weight |
| Max weekly gain | 0.5 kg |
| Daily calorie floor | 1,200 kcal (female), 1,500 kcal (male) |
| Energy per kg of weight change | 7,700 kcal |
| Protein | 2.0 g/kg losing, 1.6 maintaining, 1.8 gaining (of reference weight) |
| Fat | 25% of calories, at least 0.6 g/kg of reference weight |
| Reference weight | actual weight, capped at BMI 25 |
| Activity factors | 1.2 / 1.375 / 1.55 / 1.725 / 1.9 |

**Open question:** for referred people (under 18, or a reported condition), the targets are adult maintenance numbers. Should the app show any numbers at all, or only the referral?

## Tests

- `Tests/Unit` must keep **100% branch coverage** of `Targets/` (RULES §7). CI runs `composer test:health` with Xdebug and fails below 100%; locally it needs Xdebug too. `php artisan test` runs the same tests without coverage.
- Expected values in the tests were worked out by hand and checked against an independent implementation.
- A grid test checks about 2,000 profiles never go under the floor or over the safe rate.
- Native functions are imported (`use function min;`, enforced by Pint). Called unqualified in a namespace, PHP 8.4 compiles `min`/`max` with a runtime jump to check for a namespaced version. That path never runs, so it would leave branches no test can cover.
- Enums map values with lookup tables rather than `match`: a `match` without `default` has an implicit "no arm" branch that can never run, which would make 100% branch coverage impossible.
