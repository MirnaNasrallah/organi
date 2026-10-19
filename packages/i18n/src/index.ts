import type { Locale } from '@lockmate/api-client';
import { ar } from './ar.ts';
import { en, type MessageKey } from './en.ts';

export type { Locale, MessageKey };

export const DEFAULT_LOCALE: Locale = 'en';

// Keyed by the API's Locale type, so a language the API adds fails here until it has strings.
const messages: Record<Locale, Record<MessageKey, string>> = { en, ar };

const RTL_LOCALES: ReadonlySet<Locale> = new Set(['ar']);

/** The message for `key`, with `{name}` placeholders filled from `params`. */
export function translate(locale: Locale, key: MessageKey, params: Record<string, string | number> = {}): string {
  return messages[locale][key].replace(/\{(\w+)\}/g, (placeholder, name: string) =>
    name in params ? String(params[name]) : placeholder,
  );
}

/** The first supported language in the user's preference list (BCP 47 tags such as "ar-EG"), else English. */
export function resolveLocale(languageTags: readonly string[]): Locale {
  for (const tag of languageTags) {
    const language = tag.split('-')[0]?.toLowerCase() ?? '';
    if (isLocale(language)) return language;
  }
  return DEFAULT_LOCALE;
}

function isLocale(value: string): value is Locale {
  return Object.hasOwn(messages, value);
}

export function direction(locale: Locale): 'ltr' | 'rtl' {
  return RTL_LOCALES.has(locale) ? 'rtl' : 'ltr';
}
