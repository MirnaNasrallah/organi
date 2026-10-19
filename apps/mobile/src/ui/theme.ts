import type { Locale } from '@lockmate/i18n';
import { theme, type ColorName } from '@lockmate/tokens';
import { useColorScheme, type TextStyle } from 'react-native';
import { fontFamily } from './fonts';

export type { ColorName };
export type TextVariant = keyof typeof theme.text;

export const { space, radius, size } = theme;

/** The brand colours for the phone's light or dark setting. */
export function useColors(): Record<ColorName, string> {
  return theme.colors[useColorScheme() === 'dark' ? 'dark' : 'light'];
}

type TokenTextStyle = {
  fontSize: number;
  lineHeight: number;
  fontWeight: number;
  letterSpacing?: number;
  fontVariant?: 'tabular-nums'[];
};

export function textStyle(variant: TextVariant, locale: Locale): TextStyle {
  const token: TokenTextStyle = theme.text[variant];
  return {
    fontSize: token.fontSize,
    lineHeight: token.lineHeight,
    fontFamily: fontFamily(token.fontWeight),
    // Arabic is cursive: tracking breaks the joins between letters (ADR 0005).
    ...(token.letterSpacing !== undefined && locale !== 'ar' ? { letterSpacing: token.letterSpacing } : {}),
    ...(token.fontVariant ? { fontVariant: token.fontVariant } : {}),
  };
}
