import assert from 'node:assert/strict';
import { describe, it } from 'node:test';
import { contrastRatio } from '../src/contrast.ts';
import { brandTokens } from './fixture.ts';

const AA_NORMAL_TEXT = 4.5;
const AA_NON_TEXT = 3;

// Every text-on-background pairing the design system allows (its usage notes).
// Sprout (accent) is left out on purpose: the brand never uses it for text on light backgrounds.
const TEXT_PAIRS = [
  ['ink', 'bg'],
  ['ink', 'surface'],
  ['ink', 'tint'],
  ['ink-muted', 'bg'],
  ['ink-muted', 'surface'],
  ['ink-muted', 'tint'],
  ['brand', 'bg'],
  ['brand', 'surface'],
  ['brand', 'tint'],
  ['on-brand', 'brand'],
  ['on-accent', 'accent'],
  ['danger', 'bg'],
  ['danger', 'surface'],
] as const;

// Control edges (WCAG 1.4.11): the border is what shows an input is there.
const CONTROL_PAIRS = [
  ['line-strong', 'bg'],
  ['line-strong', 'surface'],
  ['line-strong', 'tint'],
] as const;

const CHECKS = [
  { title: 'text colours meet WCAG AA', minimum: AA_NORMAL_TEXT, pairs: TEXT_PAIRS },
  { title: 'control borders meet WCAG non-text contrast', minimum: AA_NON_TEXT, pairs: CONTROL_PAIRS },
];

describe('contrastRatio', () => {
  it('matches the WCAG extremes', () => {
    assert.ok(Math.abs(contrastRatio('#000000', '#FFFFFF') - 21) < 1e-9);
    assert.equal(contrastRatio('#777777', '#777777'), 1);
  });
});

for (const { title, minimum, pairs } of CHECKS) {
  describe(`brand ${title} (RULES §11)`, () => {
    const tokens = brandTokens();

    for (const scheme of ['light', 'dark'] as const) {
      for (const [foreground, background] of pairs) {
        it(`${foreground} on ${background} (${scheme})`, () => {
          const fg = tokens.colors.find((c) => c.name === foreground);
          const bg = tokens.colors.find((c) => c.name === background);
          assert.ok(fg && bg, `tokens.json is missing ${foreground} or ${background}`);

          const ratio = contrastRatio(fg[scheme], bg[scheme]);
          assert.ok(ratio >= minimum, `${ratio.toFixed(2)}:1 is below ${minimum}:1`);
        });
      }
    }
  });
}
