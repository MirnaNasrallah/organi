# Lockmate

**Lock in. We've got you.** A mobile-first nutrition and fitness app that ends in a meal shop.

Start with [`docs/CONTEXT.md`](docs/CONTEXT.md), then [`docs/PLAN.md`](docs/PLAN.md), [`docs/RULES.md`](docs/RULES.md) and the [ADRs](docs/adr/README.md).

## Layout

| Path | What |
|---|---|
| `apps/api` | Laravel 13 API (`/api/v1`), organised by domain module in `app/Modules` |
| `apps/web` | Next.js website (coming) |
| `apps/mobile` | Expo app (coming) |
| `packages/*` | Generated API client, design tokens, i18n strings, shared config (coming) |

The 2021 Organi app this grew from is tagged `legacy`.

## Local setup

Needs PHP 8.4, Composer, Node 24 (see `.nvmrc`) and pnpm. Redis, and Postgres once the first migrations land.

```bash
pnpm install
cd apps/api && composer setup && herd link lockmate-api
```

From the repo root:

```bash
pnpm lint   # Pint + PHPStan (and ESLint once JS apps exist)
pnpm test   # PHPUnit (and JS tests once they exist)
```
