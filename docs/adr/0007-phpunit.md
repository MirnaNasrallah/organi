# ADR-0007: PHPUnit for PHP tests

**Status:** Accepted
**Date:** 2026-10-18
**Deciders:** Mirna Nasrallah

## Context
The API needs one test runner. Laravel 13 supports PHPUnit and Pest. RULES §7 requires 100% branch coverage on the health maths.

## Decision
- PHPUnit 12 for all PHP tests, run with `php artisan test`. Each module keeps unit and feature tests in its own tests folder (RULES §8).
- Use attributes (`#[Test]`, `#[DataProvider]`, `#[CoversClass]`). PHPUnit 12 no longer reads docblock annotations.
- Formula tests are table-driven with data providers: inputs → expected kcal and macros.
- The new app doesn't allow the `pestphp/pest-plugin` Composer plugin.

## Options considered
- **PHPUnit (chosen):** Laravel's default; plain classes; no extra dependency; widely known.
- **Pest:** terser syntax and `arch()` tests that could enforce module boundaries.

## Consequences
- Branch coverage needs Xdebug (PCOV only measures lines) with `--path-coverage`. `php artisan test --coverage --min` checks lines only, so CI checks branch coverage of the health maths with a small script.
- Without Pest's `arch()`, module boundaries (RULES §8) are enforced with a PHPStan rule or a test that scans imports. Decide when the second module exists.
