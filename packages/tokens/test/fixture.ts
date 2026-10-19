import { readFileSync } from 'node:fs';
import { parseTokens, type Tokens } from '../src/tokens.ts';

type ColorEntry = { name: string; value: { light?: string; dark?: string } };
type StyleEntry = { name: string; fontSize: string; lineHeight: string; fontWeight: number; letterSpacing?: string };
type SizeEntry = { name: string; value: string };

// The smallest tokens.json the parser accepts, in the artifact's format.
export function fixture() {
  return {
    color: {
      tokens: [{ name: 'ink-muted', value: { light: '#56685d', dark: '#A6BCAD' } }] as ColorEntry[],
    },
    type: {
      families: { sans: '"Rubik", sans-serif' },
      groups: [
        {
          styles: [
            { name: 'body', fontSize: '16px', lineHeight: '24px', fontWeight: 400 },
            {
              name: 'metric',
              fontSize: '28px',
              lineHeight: '32px',
              fontWeight: 500,
              letterSpacing: '-0.5px',
            },
          ] as StyleEntry[],
        },
      ],
    },
    spacing: { tokens: [{ name: 'space-1', value: '4px' }] as SizeEntry[] },
    radius: { tokens: [{ name: 'radius-sm', value: '8px' }] as SizeEntry[] },
    size: { tokens: [{ name: 'size-touch-target', value: '44px' }] as SizeEntry[] },
  };
}

export function brandTokens(): Tokens {
  const raw: unknown = JSON.parse(readFileSync(new URL('../tokens.json', import.meta.url), 'utf8'));
  return parseTokens(raw);
}
