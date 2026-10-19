import assert from 'node:assert/strict';
import { describe, it } from 'node:test';
import { toCss } from '../src/css.ts';
import { buildTheme, toThemeModule } from '../src/theme.ts';
import { parseTokens } from '../src/tokens.ts';
import { fixture } from './fixture.ts';

const tokens = parseTokens(fixture());

describe('toCss', () => {
  const css = toCss(tokens);

  it('puts light colours on :root and dark ones behind the OS setting or data-theme', () => {
    assert.match(css, /^:root \{\n {2}color-scheme: light;\n {2}--ink-muted: #56685D;/m);
    assert.match(css, /^ {2}:root:not\(\[data-theme="light"\]\) \{\n {4}color-scheme: dark;\n {4}--ink-muted: #A6BCAD;/m);
    assert.match(css, /^:root\[data-theme="dark"\] \{\n {2}color-scheme: dark;\n {2}--ink-muted: #A6BCAD;/m);
  });

  it('exposes spacing, radius, sizes and the font stack as variables', () => {
    assert.match(css, /--space-1: 4px;/);
    assert.match(css, /--radius-sm: 8px;/);
    assert.match(css, /--size-touch-target: 44px;/);
    assert.match(css, /--font-sans: "Rubik", sans-serif;/);
  });

  it('drops letter-spacing for Arabic text only where a style has tracking', () => {
    assert.match(css, /\.text-metric:lang\(ar\) \{\n {2}letter-spacing: normal;\n\}/);
    assert.doesNotMatch(css, /\.text-body:lang\(ar\)/);
  });

  it('sets tabular figures after the font shorthand, which would otherwise reset them', () => {
    assert.match(css, /font: 500 28px\/32px var\(--font-sans\);\n {2}letter-spacing: -0\.5px;\n {2}font-variant-numeric: tabular-nums;/);
  });
});

describe('buildTheme', () => {
  it('gives React Native numbers and camelCase colour names per scheme', () => {
    assert.deepEqual(buildTheme(tokens), {
      colors: { light: { inkMuted: '#56685D' }, dark: { inkMuted: '#A6BCAD' } },
      space: { 1: 4 },
      radius: { sm: 8 },
      size: { touchTarget: 44 },
      text: {
        body: { fontSize: 16, lineHeight: 24, fontWeight: 400 },
        metric: { fontSize: 28, lineHeight: 32, fontWeight: 500, letterSpacing: -0.5, fontVariant: ['tabular-nums'] },
      },
    });
  });

  it('declares literal types, with mutable arrays React Native accepts', () => {
    const { dts } = toThemeModule(tokens);

    assert.match(dts, /readonly "inkMuted": "#56685D";/);
    assert.match(dts, /readonly "fontVariant": \("tabular-nums"\)\[\];/);
  });
});
