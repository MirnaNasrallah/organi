import { mkdirSync, readFileSync, writeFileSync } from 'node:fs';
import { toCss } from '../src/css.ts';
import { toThemeModule } from '../src/theme.ts';
import { parseTokens } from '../src/tokens.ts';

const root = new URL('../', import.meta.url);
const dist = new URL('dist/', root);

const raw: unknown = JSON.parse(readFileSync(new URL('tokens.json', root), 'utf8'));
const tokens = parseTokens(raw);
const theme = toThemeModule(tokens);

mkdirSync(dist, { recursive: true });
writeFileSync(new URL('tokens.css', dist), toCss(tokens));
writeFileSync(new URL('index.js', dist), theme.js);
writeFileSync(new URL('index.d.ts', dist), theme.dts);
