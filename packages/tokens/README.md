# @lockmate/tokens

Colours, type, spacing and radii for web and mobile, from one file (ADR 0005).

## Source

`tokens.json` is an unedited copy of `project/tokens.json` in the Lockmate Claude Design artifact. Never edit it here; change the design system, then copy it again.

| | |
|---|---|
| Artifact | <https://claude.ai/artifact/1kJZbiAh1RMwwHLfVtYdtK> |
| Version copied | `1792331203-6097` (design system v0.4: Forest/Sprout, Rubik) |
| SHA-256 | `ea74740462e8901b3b422b26f96482b4e34095230d8450fb8bf82306fbf63b90` |

To update: ask Claude to read `project/tokens.json` from the artifact, replace this copy, update the table above, then run `pnpm --filter @lockmate/tokens build test`. The tests fail if the format changes or a text colour drops below WCAG AA.

## Outputs (`pnpm build` → `dist/`, not committed)

| Import | For | What |
|---|---|---|
| `@lockmate/tokens/tokens.css` | Web | CSS variables (`--brand`, `--space-6`, `--radius-md`, `--font-sans`…) with light and dark values, plus `.text-<style>` classes |
| `@lockmate/tokens` | Mobile | `theme` object: `colors.light` / `colors.dark` (camelCase), `space`, `radius`, `text` as React Native numbers |

Dark mode follows the OS unless `<html data-theme="light|dark">` overrides it. Text styles with tracking reset it under `:lang(ar)`, and `metric` uses tabular figures.
