# @lockmate/tokens

Colours, type, spacing and radii for web and mobile, from one file (ADR 0005).

## Source

`tokens.json` is an unedited copy of `project/tokens.json` in the Lockmate Claude Design artifact. Never edit it here; change the design system, then copy it again.

|                |                                                                                                  |
| -------------- | ------------------------------------------------------------------------------------------------ |
| Artifact       | <https://claude.ai/artifact/1kJZbiAh1RMwwHLfVtYdtK>                                              |
| Version copied | `1792395642-3ad2` (design system v0.5: Forest/Sprout, Rubik, `line-strong`, `size-touch-target`) |
| SHA-256        | `fe4ff4262ac8e3b125a7b5b0d52f2a4891a44d065738958ea73db8977b1e8629`                               |

To update: ask Claude to read `project/tokens.json` from the artifact, replace this copy, update the table above, then run `pnpm --filter @lockmate/tokens build test`. The tests fail if the format changes, a text colour drops below WCAG AA (4.5:1), or `line-strong` drops below 3:1.

## Outputs (`pnpm build` → `dist/`, not committed)

| Import                        | For    | What                                                                                                                                                                   |
| ----------------------------- | ------ | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `@lockmate/tokens/tokens.css` | Web    | CSS variables (`--brand`, `--line-strong`, `--space-6`, `--radius-md`, `--size-touch-target`, `--font-sans`…) with light and dark values, plus `.text-<style>` classes |
| `@lockmate/tokens`            | Mobile | `theme` object: `colors.light` / `colors.dark` (camelCase), `space`, `radius`, `size` (`size.touchTarget`), `text` as React Native numbers                             |

Dark mode follows the OS unless `<html data-theme="light|dark">` overrides it. Text styles with tracking reset it under `:lang(ar)`, and `metric` uses tabular figures.
