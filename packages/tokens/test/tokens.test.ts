import assert from 'node:assert/strict';
import { describe, it } from 'node:test';
import { parseTokens } from '../src/tokens.ts';
import { brandTokens, fixture } from './fixture.ts';

describe('parseTokens', () => {
  it('reads the brand tokens copied from the design artifact', () => {
    const tokens = brandTokens();

    assert.ok(tokens.colors.length > 0);
    assert.ok(tokens.textStyles.length > 0);
  });

  it('turns px strings into numbers and upper-cases colours', () => {
    const tokens = parseTokens(fixture());

    assert.deepEqual(tokens.colors, [{ name: 'ink-muted', light: '#56685D', dark: '#A6BCAD' }]);
    assert.deepEqual(tokens.space, [{ name: 'space-1', px: 4 }]);
    assert.deepEqual(tokens.textStyles, [
      { name: 'body', fontSize: 16, lineHeight: 24, fontWeight: 400, letterSpacing: null, tabularNumbers: false },
      { name: 'metric', fontSize: 28, lineHeight: 32, fontWeight: 500, letterSpacing: -0.5, tabularNumbers: true },
    ]);
  });

  it('rejects a colour with no dark value', () => {
    const raw = fixture();
    delete raw.color.tokens[0]?.value.dark;

    assert.throws(() => parseTokens(raw), /color\.tokens\[0\]\.value\.dark to be a #RRGGBB colour/);
  });

  it('rejects sizes that are not in px', () => {
    const raw = fixture();
    raw.spacing.tokens = [{ name: 'space-1', value: '0.25rem' }];

    assert.throws(() => parseTokens(raw), /spacing\.tokens\[0\]\.value to be a px value/);
  });

  it('rejects sizes whose names break the space-/radius- convention', () => {
    const raw = fixture();
    raw.radius.tokens = [{ name: 'round', value: '8px' }];

    assert.throws(() => parseTokens(raw), /radius\.tokens\[0\]\.name to be a name starting with "radius-"/);
  });
});
