# ADR-0006: Western digits in every locale

**Status:** Accepted
**Date:** 2026-10-18
**Deciders:** Mirna Nasrallah

## Context
Numbers are the core of the app: kcal, grams, macros and prices. Arabic locales often default to Eastern Arabic digits (٠–٩): `Intl.NumberFormat('ar-EG')` in JS and `NumberFormatter('ar_EG')` in PHP both produce them unless told otherwise.

## Decision
- Every number shown to a user uses Western digits (0–9), in Arabic and English alike: kcal, macros, weights, prices, dates, times and order numbers.
- Formatting goes through the shared helpers (RULES §3), which force the Latin numbering system: `numberingSystem: 'latn'` (or the locale `ar-EG-u-nu-latn`) in JS, and `ar_EG@numbers=latn` in PHP's intl.
- Inputs accept Eastern Arabic (٠–٩) and Persian (۰–۹) digits and the Arabic decimal separator (٫), and normalise them to `0–9` and `.`. Clients do it as the user types; Form Requests do it again in `prepareForValidation`.

## Consequences
- One rule for every locale; no digit logic per screen.
- People typing on an Arabic keyboard still produce valid input.
- Formatting helpers have unit tests in both locales. A lint rule flags direct `toLocaleString` / `Intl.NumberFormat` calls outside the helpers.
