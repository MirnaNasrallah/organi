# ADR-0005: Design tokens come from the Claude Design artifact

**Status:** Accepted
**Date:** 2026-10-18
**Deciders:** Mirna Nasrallah

## Context
Colours, type, spacing and radii come from `packages/tokens` (RULES §3, §4). The web needs CSS variables; React Native has no CSS variables and needs a TS theme. The brand lives in a Claude Design artifact: <https://claude.ai/artifact/1kJZbiAh1RMwwHLfVtYdtK>. Its tokens are in the artifact's `project/tokens.json` (v4: Forest and Sprout palette, Rubik, the Flex symbol). CI cannot read a claude.ai artifact.

## Decision
- The Claude Design artifact is the source of truth. Brand changes are made there first; the latest version is the final one.
- `packages/tokens/tokens.json` is an unedited copy of the artifact's `project/tokens.json`. The package README records the artifact version it was copied from.
- A small script generates `tokens.css` (CSS variables for light and dark) and `theme.ts` (a typed light/dark object for mobile). Generated files are never edited by hand.
- Logos are copied as-is from the artifact's Logos group (lockup, symbol, app icon, wordmark).

## Options considered
- **Copy plus a small script (chosen):** 11 colours, 8 text styles, 5 spacing steps and 3 radii fit in a ~50-line script.
- **Style Dictionary:** the standard tool, but it needs custom transforms for this file's light/dark shape and React Native fonts.
- **A hand-written theme per app:** two copies of every value; breaks DRY.

## Consequences
- React Native gets one font family per weight (`Rubik_400Regular`, `Rubik_500Medium`, `Rubik_600SemiBold`) instead of `fontWeight`, which is unreliable with variable fonts on Android.
- Letter-spacing applies to Latin text only. Arabic gets 0 so letters keep joining.
- Copy from `tokens.json` and the Logos group only. Generated files left from an earlier direction (Evergreen/Brass, Readex Pro) were removed in design system v0.5; the old mark and name-candidate images stay in the artifact's asset storage, unreferenced.

## Action items
1. [x] Add to the design system before building form controls: a control-border colour with at least 3:1 contrast (`line` is 1.16:1 and decorative only) and a 44 pt minimum touch target. Done in v0.5: `line-strong` and `size-touch-target`, both guarded by tests.
2. [x] Check Rubik has tabular figures (`tnum`) for the `metric` style on web and mobile. It does, in every weight we load. Its default digits are proportional, so `metric` must keep `tabular-nums`. The same files cover the Arabic alphabet and Eastern Arabic digits.
3. [x] Remove the stale files from the artifact (v0.5).
