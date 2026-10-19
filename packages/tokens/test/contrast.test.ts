import assert from 'node:assert/strict';
import { describe, it } from 'node:test';
import { contrastRatio } from '../src/contrast.ts';
import { brandTokens } from './fixture.ts';

const AA_NORMAL_TEXT = 4.5;

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

describe('contrastRatio', () => {
  it('matches the WCAG extremes', () => {
    assert.ok(Math.abs(contrastRatio('#000000', '#FFFFFF') - 21) < 1e-9);
    assert.equal(contrastRatio('#777777', '#777777'), 1);
  });
});

describe('brand text colours meet WCAG AA (RULES §11)', () => {
  const tokens = brandTokens();

  for (const scheme of ['light', 'dark'] as const) {
    for (const [text, background] of TEXT_PAIRS) {
      it(`${text} on ${background} (${scheme})`, () => {
        const fg = tokens.colors.find((c) => c.name === text);
        const bg = tokens.colors.find((c) => c.name === background);
        assert.ok(fg && bg, `tokens.json is missing ${text} or ${background}`);

        const ratio = contrastRatio(fg[scheme], bg[scheme]);
        assert.ok(ratio >= AA_NORMAL_TEXT, `${ratio.toFixed(2)}:1 is below ${AA_NORMAL_TEXT}:1`);
      });
    }
  }
});
