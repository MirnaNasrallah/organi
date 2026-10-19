import { DEFAULT_LOCALE, resolveLocale, translate, type Locale, type MessageKey } from '@lockmate/i18n';
import { getLocales } from 'expo-localization';
import { createContext, use, useCallback, type ReactNode } from 'react';

/**
 * The app's language: the first of English or Arabic in the phone's preferences.
 * People switch it in system Settings (per-app language), which restarts the app,
 * so it never changes while the app runs.
 */
export function deviceLocale(): Locale {
  return resolveLocale(getLocales().map((locale) => locale.languageTag));
}

const LocaleContext = createContext<Locale>(DEFAULT_LOCALE);

export function LocaleProvider({ locale, children }: { locale: Locale; children: ReactNode }) {
  return <LocaleContext value={locale}>{children}</LocaleContext>;
}

export function useLocale(): Locale {
  return use(LocaleContext);
}

export function useTranslate() {
  const locale = useLocale();
  return useCallback(
    (key: MessageKey, params?: Record<string, string | number>) => translate(locale, key, params),
    [locale],
  );
}
