import type { SizeToken, TextStyle, Tokens } from './tokens.ts';

// The TS theme is for React Native, which has no CSS variables: plain numbers
// instead of px strings, camelCase colour names, and one colour set per scheme.

type Value = string | number | Value[] | { [key: string]: Value };

export function buildTheme(tokens: Tokens): { [key: string]: Value } {
  return {
    colors: {
      light: Object.fromEntries(tokens.colors.map((c) => [camel(c.name), c.light])),
      dark: Object.fromEntries(tokens.colors.map((c) => [camel(c.name), c.dark])),
    },
    space: scale(tokens.space, 'space-'),
    radius: scale(tokens.radius, 'radius-'),
    text: Object.fromEntries(tokens.textStyles.map((style) => [style.name, textStyle(style)])),
  };
}

export function toThemeModule(tokens: Tokens): { js: string; dts: string } {
  const theme = buildTheme(tokens);
  const header = '// Generated from tokens.json by @lockmate/tokens. Do not edit.\n';

  return {
    js: `${header}export const theme = ${JSON.stringify(theme, null, 2)};\n`,
    dts: [
      header.trimEnd(),
      `export declare const theme: ${typeOf(theme, '')};`,
      'export type Theme = typeof theme;',
      'export type ColorScheme = keyof Theme["colors"];',
      'export type ColorName = keyof Theme["colors"]["light"];',
      '',
    ].join('\n'),
  };
}

function textStyle(style: TextStyle): { [key: string]: Value } {
  return {
    fontSize: style.fontSize,
    lineHeight: style.lineHeight,
    fontWeight: style.fontWeight,
    ...(style.letterSpacing === null ? {} : { letterSpacing: style.letterSpacing }),
    ...(style.tabularNumbers ? { fontVariant: ['tabular-nums'] } : {}),
  };
}

function scale(sizes: SizeToken[], prefix: string): { [key: string]: number } {
  return Object.fromEntries(sizes.map((size) => [size.name.slice(prefix.length), size.px]));
}

function camel(name: string): string {
  return name.replace(/-([a-z])/g, (_, letter: string) => letter.toUpperCase());
}

// Literal types let editors autocomplete exact colour values and keys.
function typeOf(value: Value, indent: string): string {
  if (typeof value === 'string') return JSON.stringify(value);
  if (typeof value === 'number') return String(value);
  // Mutable arrays, because React Native style props reject readonly ones.
  if (Array.isArray(value)) return `(${value.map((v) => typeOf(v, indent)).join(' | ')})[]`;

  const inner = `${indent}  `;
  const fields = Object.entries(value).map(([key, v]) => `${inner}readonly ${JSON.stringify(key)}: ${typeOf(v, inner)};`);
  return `{\n${fields.join('\n')}\n${indent}}`;
}
