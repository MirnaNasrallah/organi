# Shared

Cross-cutting pieces every module may use (CONTEXT §5). Later this module also owns money, units, the `AiClient` contract and i18n helpers.

## Public surface
- `Locale`: the supported locales, English (the default, `APP_LOCALE=en`) and Arabic.
- `SetLocaleFromHeader`: API middleware that picks the locale from `Accept-Language`, then sets `Content-Language` and `Vary: Accept-Language` on the response.
- `Digits::toWestern()` and the `NormalisesDigits` Form Request trait: number fields accept Eastern Arabic digits (٠–٩, ۰–۹, ٫) and get Western ones before validation (ADR 0006).
- `GET /api/v1/status`: liveness plus the negotiated locale. Clients use it to check the API → spec → client pipeline end to end.
