# ADR-0002: Bilingual content as `*_ar` / `*_en` columns

**Status:** Accepted
**Date:** 2026-10-18
**Deciders:** Mirna Nasrallah

## Context
Every user-facing text field (recipe titles, food names, steps, coach bios…) needs Arabic and English (CONTEXT §6). Staff enter content in Filament, Meilisearch indexes it, and the website renders a separate SEO page per locale. There is no plan for a third language.

## Decision
- Each translatable field is two columns: `title_ar`, `title_en`, `name_ar`, `name_en`, and so on.
- Both languages are required before content can be published. Drafts may have one.
- API Resources return one resolved field (`title`) in the request's locale (`Accept-Language`), with `Vary: Accept-Language`. One shared helper does the resolving, so no Resource repeats it.

## Options considered
- **Two columns (chosen):** plain SQL, normal indexes and sorting, maps 1:1 to Meilisearch fields, two plain inputs in Filament, no package.
- **JSON column per field** (e.g. `spatie/laravel-translatable`): one column and easy to add languages, but sorting and filtering by locale need JSON operators and expression indexes, plus a dependency.
- **Translations table:** the most flexible, but a join on every read, N+1 risk, and the most code.

## Consequences
- Adding a third language means a migration on each content table. We accept that as unlikely.
- Mobile includes the locale in its query keys, so switching language refetches content.
- Meilisearch indexes both fields. Check Arabic search with real spellings Egyptians mix (ملوخية / ملوخيه, أ / ا) before launch.
