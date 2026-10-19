import type { TextStyle, Tokens } from './tokens.ts';

export function toCss(tokens: Tokens): string {
  const light = tokens.colors.map((color) => `--${color.name}: ${color.light};`);
  const dark = tokens.colors.map((color) => `--${color.name}: ${color.dark};`);
  const shared = [
    `--font-sans: ${tokens.fontFamily};`,
    ...[...tokens.space, ...tokens.radius, ...tokens.size].map((size) => `--${size.name}: ${size.px}px;`),
  ];

  return [
    '/* Generated from tokens.json by @lockmate/tokens. Do not edit. */',
    block(':root', ['color-scheme: light;', ...light, ...shared]),
    '@media (prefers-color-scheme: dark) {',
    block(':root:not([data-theme="light"])', ['color-scheme: dark;', ...dark], '  '),
    '}',
    block(':root[data-theme="dark"]', ['color-scheme: dark;', ...dark]),
    ...tokens.textStyles.flatMap(textClass),
  ].join('\n') + '\n';
}

function textClass(style: TextStyle): string[] {
  const selector = `.text-${style.name}`;
  const rules = [`font: ${style.fontWeight} ${style.fontSize}px/${style.lineHeight}px var(--font-sans);`];
  if (style.letterSpacing !== null) rules.push(`letter-spacing: ${style.letterSpacing}px;`);
  if (style.tabularNumbers) rules.push('font-variant-numeric: tabular-nums;');

  return style.letterSpacing === null
    ? [block(selector, rules)]
    : // Tracking breaks the joins between Arabic letters (ADR 0005).
      [block(selector, rules), block(`${selector}:lang(ar)`, ['letter-spacing: normal;'])];
}

function block(selector: string, declarations: string[], indent = ''): string {
  return [`${indent}${selector} {`, ...declarations.map((d) => `${indent}  ${d}`), `${indent}}`].join('\n');
}
