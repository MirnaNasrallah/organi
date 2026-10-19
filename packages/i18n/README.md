# @lockmate/i18n

Every user-facing string, in English and Arabic (RULES §4, §11), shared by web and mobile.

- `src/en.ts` is the source: add a key there first.
- `src/ar.ts` must have the same keys; the type check fails otherwise. Write Arabic for Arabic readers rather than translating word for word, and get it reviewed by a native speaker before launch.
- `translate(locale, key, params)` fills `{name}` placeholders. Format numbers before passing them in (Western digits, ADR 0006).
- `resolveLocale(tags)` picks `en` or `ar` from a preference list (device settings, `Accept-Language`), defaulting to English. `direction(locale)` gives `ltr` or `rtl`.
- `Locale` comes from the API spec (`@lockmate/api-client`), so the app and the API always agree on the languages.

Brand names stay in Latin script in both languages: don't transliterate "Lockmate" (see the design system's README).
