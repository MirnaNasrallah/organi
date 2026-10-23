// Renders the app icon, Android's adaptive icon layers and the splash images from the
// brand SVGs in @lockmate/tokens (ADR 0005). Run it after the logos change:
//   pnpm --filter @lockmate/mobile brand-assets
// The PNGs are committed because Expo's native builds read them from assets/.
import { Resvg } from '@resvg/resvg-js';
import { readFileSync, writeFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';

const SIZE = 1024;

// Launchers crop the adaptive icon's 108 dp canvas to as little as a 66 dp circle,
// so the leaves shrink around the centre to stay clear of the mask.
const ADAPTIVE_SCALE = 0.72;

const HEX_FILL = /fill="#[0-9A-Fa-f]{6}"/g;
const HEX_STROKE = /stroke="#[0-9A-Fa-f]{6}"/g;

const appIcon = logo('app-icon.svg');
const leaves = only(appIcon, /<g transform="[^"]+">[\s\S]*<\/g>/, 'leaf group');

// iOS needs a square, opaque icon and rounds the corners itself.
render(only(appIcon, / rx="[\d.]+"/, 'corner radius', ''), 'icon.png');

// Android foreground: the same leaves on transparency, over the forest background colour in app.json.
render(adaptive(leaves), 'android-icon-foreground.png');

// Android themed icon: the launcher only reads alpha, so the midrib is cut out of the leaves.
const leafShapes = recolour(recolour(leaves, HEX_FILL, 2, 'fill="#FFFFFF"'), HEX_STROKE, 1, 'stroke="none"');
const midribCut = recolour(recolour(leaves, HEX_FILL, 2, 'fill="none"'), HEX_STROKE, 1, 'stroke="#000000"');
render(
  adaptive(
    `<defs><mask id="midrib"><rect width="${SIZE}" height="${SIZE}" fill="#FFFFFF"/>${midribCut}</mask></defs>` +
      `<g mask="url(#midrib)">${leafShapes}</g>`,
  ),
  'android-icon-monochrome.png',
);

// Splash: the symbol on the light and dark backgrounds set in app.json.
render(logo('symbol.svg'), 'splash-icon.png');
render(logo('symbol-reversed.svg'), 'splash-icon-dark.png');

function logo(file: string): string {
  return readFileSync(fileURLToPath(import.meta.resolve(`@lockmate/tokens/logos/${file}`)), 'utf8');
}

function adaptive(content: string): string {
  const centre = SIZE / 2;
  return (
    `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${SIZE} ${SIZE}">` +
    `<g transform="translate(${centre} ${centre}) scale(${ADAPTIVE_SCALE}) translate(-${centre} -${centre})">${content}</g>` +
    `</svg>`
  );
}

/** The single match of `pattern`, or `svg` with it replaced; anything else means the logo changed shape. */
function only(svg: string, pattern: RegExp, what: string, replacement?: string): string {
  const matches = svg.match(new RegExp(pattern, 'g')) ?? [];
  if (matches.length !== 1 || matches[0] === undefined) {
    throw new Error(`Expected one ${what} in the logo, found ${matches.length}: check the SVG before regenerating`);
  }
  return replacement === undefined ? matches[0] : svg.replace(pattern, replacement);
}

function recolour(svg: string, pattern: RegExp, expected: number, replacement: string): string {
  const found = svg.match(pattern)?.length ?? 0;
  if (found !== expected) {
    throw new Error(`Expected ${expected} matches of ${pattern} in the leaf group, found ${found}`);
  }
  return svg.replace(pattern, replacement);
}

function render(svg: string, file: string): void {
  const png = new Resvg(svg, { fitTo: { mode: 'width', value: SIZE } }).render().asPng();
  writeFileSync(new URL(`../assets/${file}`, import.meta.url), png);
  console.log(`assets/${file}`);
}
