// tokens.json is copied from the Claude Design artifact (ADR 0005), so it is
// external data: check its shape here and fail the build loudly if it changes.

export type ColorToken = { name: string; light: string; dark: string };

export type TextStyle = {
  name: string;
  fontSize: number;
  lineHeight: number;
  fontWeight: number;
  letterSpacing: number | null;
  tabularNumbers: boolean;
};

export type SizeToken = { name: string; px: number };

export type Tokens = {
  colors: ColorToken[];
  fontFamily: string;
  textStyles: TextStyle[];
  space: SizeToken[];
  radius: SizeToken[];
  size: SizeToken[];
};

type Json = Record<string, unknown>;

// The brand says calories and macros use tabular figures so columns line up.
// tokens.json only states it in prose, so it is named here once.
const TABULAR_STYLES = new Set(['metric']);

const HEX = /^#[0-9a-f]{6}$/i;
const PX = /^-?\d+(\.\d+)?px$/;

export function parseTokens(raw: unknown): Tokens {
  const root = record(raw, 'root');
  const type = record(root.type, 'type');

  return {
    colors: list(record(root.color, 'color').tokens, 'color.tokens').map((item, i) => {
      const token = record(item, `color.tokens[${i}]`);
      const value = record(token.value, `color.tokens[${i}].value`);
      return {
        name: text(token.name, `color.tokens[${i}].name`),
        light: hex(value.light, `color.tokens[${i}].value.light`),
        dark: hex(value.dark, `color.tokens[${i}].value.dark`),
      };
    }),
    fontFamily: text(record(type.families, 'type.families').sans, 'type.families.sans'),
    textStyles: list(type.groups, 'type.groups').flatMap((group, g) =>
      list(record(group, `type.groups[${g}]`).styles, `type.groups[${g}].styles`).map((item, s) => {
        const at = `type.groups[${g}].styles[${s}]`;
        const style = record(item, at);
        const name = text(style.name, `${at}.name`);
        return {
          name,
          fontSize: px(style.fontSize, `${at}.fontSize`),
          lineHeight: px(style.lineHeight, `${at}.lineHeight`),
          fontWeight: num(style.fontWeight, `${at}.fontWeight`),
          letterSpacing: style.letterSpacing === undefined ? null : px(style.letterSpacing, `${at}.letterSpacing`),
          tabularNumbers: TABULAR_STYLES.has(name),
        };
      }),
    ),
    space: sizes(root.spacing, 'spacing', 'space-'),
    radius: sizes(root.radius, 'radius', 'radius-'),
    size: sizes(root.size, 'size', 'size-'),
  };
}

function sizes(value: unknown, at: string, prefix: string): SizeToken[] {
  return list(record(value, at).tokens, `${at}.tokens`).map((item, i) => {
    const token = record(item, `${at}.tokens[${i}]`);
    const name = text(token.name, `${at}.tokens[${i}].name`);
    if (!name.startsWith(prefix)) fail(`${at}.tokens[${i}].name`, `a name starting with "${prefix}"`, name);
    return { name, px: px(token.value, `${at}.tokens[${i}].value`) };
  });
}

function record(value: unknown, at: string): Json {
  if (typeof value !== 'object' || value === null || Array.isArray(value)) fail(at, 'an object', value);
  return value as Json;
}

function list(value: unknown, at: string): unknown[] {
  if (!Array.isArray(value)) fail(at, 'an array', value);
  return value;
}

function text(value: unknown, at: string): string {
  if (typeof value !== 'string' || value === '') fail(at, 'a non-empty string', value);
  return value;
}

function num(value: unknown, at: string): number {
  if (typeof value !== 'number' || !Number.isFinite(value)) fail(at, 'a number', value);
  return value;
}

function hex(value: unknown, at: string): string {
  if (typeof value !== 'string' || !HEX.test(value)) fail(at, 'a #RRGGBB colour', value);
  return value.toUpperCase();
}

function px(value: unknown, at: string): number {
  if (typeof value !== 'string' || !PX.test(value)) fail(at, 'a px value like "16px"', value);
  return Number.parseFloat(value);
}

function fail(at: string, expected: string, got: unknown): never {
  throw new Error(`tokens.json: expected ${at} to be ${expected}, got ${JSON.stringify(got)}`);
}
