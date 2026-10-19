---
description: Lockmate engineering house rules for every code change
alwaysApply: true
---

# Lockmate — Engineering Rules

> These are the house rules for everyone who writes code here, humans and AI agents alike.
> They're short on purpose. If a rule gets in the way, change the rule in a PR — don't quietly break it.
>
> Status: **Draft v0.1 — Mirna to edit** · Last updated: 2026-10-18
> Tip: this file doubles as agent instructions. Symlink or import it from `CLAUDE.md` / `AGENTS.md`.

---

## The eight principles

1. **Stupid simple.** Use the simplest thing that works today.
2. **Clean.** Code reads like the domain.
3. **Reusable.** Build it once, use it everywhere it fits.
4. **DRY.** Every fact lives in one place.
5. **SOLID.** Small parts with one job, depending on contracts.
6. **Scalable.** Ready to grow, without building for scale we don't have.
7. **Continuous validation & testing.** Nothing merges unproven.
8. **Modular.** Domains are boxes with doors, not open-plan offices.

---

## 1. Stupid simple
- Solve today's requirement. No speculative abstractions and no "we might need it" (YAGNI).
- Boring tech wins. A new dependency needs a one-paragraph justification in the PR.
- If it takes more than a minute to explain, it's too clever. Rewrite it.
- Functions are short and do one thing. Files with more than ~200 lines are a smell.
- Prefer plain data and plain functions over class hierarchies.

## 2. Clean
- Name things with the domain words from `CONTEXT.md §4` (Plan, Targets, Meal slot, Swap…). No `data`, `info`, `manager`, `helper`, `utils`.
- **PHP:** PSR-12, enforced by Pint; Larastan/PHPStan at level ≥ 8; `declare(strict_types=1);` everywhere.
- **TypeScript:** `strict: true`; no `any`; ESLint and Prettier enforced in CI.
- No dead code, commented-out code, or `TODO` without an issue link.
- Comments explain **why**, never **what**.
- No magic numbers. Named constants or config (`MIN_DAILY_KCAL`, not `1200`).

## 3. Reusable
- UI is built from shared primitives (Button, Card, Field, MacroBar…) driven by **design tokens**, never by hard-coded colours or sizes.
- Business logic lives in framework-free services or actions that controllers, jobs, commands and the admin all call.
- One generated API client (`packages/api-client`) is used by both web and mobile. Never hand-write fetch calls to our API.
- Formatting (money, kcal, grams, dates) comes from shared helpers.

## 4. DRY
- **One source of truth for each fact:**
  - API shapes → the OpenAPI spec generated from Laravel → TS types.
  - Validation rules → Laravel Form Requests (server). Clients mirror them with schemas derived from the spec, never invented separately.
  - Nutrition → computed from ingredients, never stored twice by hand.
  - Colours, type and spacing → `packages/tokens`.
  - UI strings → `packages/i18n` keys (ar, en).
- Sorting, filtering and pagination are **query parameters on one endpoint**, never separate endpoints or views (the old `shopLow` / `shopHigh` mistake).
- Rule of three: duplicate once if you must; on the third copy, extract.

## 5. SOLID
- **S:** a controller only takes the request, calls one action or service, and returns a Resource. No business logic in controllers, models, or views.
- **O:** extend through new classes (e.g. a new `BmrFormula`), not `if/else` chains on type.
- **L:** implementations of a contract are truly interchangeable. Tests run against the contract.
- **I:** small contracts (`CalculatesTargets`, `ComposesMenu`), not god-interfaces.
- **D:** depend on contracts bound in the container, especially at the edges: `AiClient`, `PaymentGateway`, `SmsSender`, `Storage`.

## 6. Scalable
- The API is stateless. Sessions live in Redis and files in object storage.
- Anything slow or external (AI, email, SMS, image processing, payments webhooks) runs **in queued jobs**.
- No N+1 queries: eager-load, and enable `Model::preventLazyLoading()` outside production.
- Every list endpoint is paginated (cursor pagination for feeds).
- Every query used in a list has an index. Check migrations in review.
- Cache read-heavy public content (recipes, foods, swaps) and invalidate on write.
- The API is versioned (`/api/v1`) and breaking changes need a new version.
- Money is integer minor units; weight is grams; energy is kcal. Store UTC and display in local time.

## 7. Continuous validation & testing
**Validate at every boundary:**
- Input: Form Requests on every endpoint. Nothing reaches a service unvalidated.
- External data: schema-validate AI output, webhook payloads and third-party responses before use.
- Database: constraints back up code (foreign keys, unique, not null, check constraints where cheap).

**Test pyramid:**
| Layer | What | Tool |
|---|---|---|
| Unit | Domain services: targets calculator, macro split, swap ranking, cart builder | PHPUnit (ADR 0007), Vitest / Jest |
| Feature / API | Every endpoint: happy path, validation errors, auth and authorization | Laravel HTTP tests |
| Contract | The OpenAPI spec matches the responses; client types compile | Spec diff in CI |
| Component | Shared UI primitives, RTL and LTR | React Testing Library |
| E2E | Critical flows: onboarding → plan; (Ph2) plan → cart → pay | Maestro (mobile), Playwright (web) |
| AI evals | Golden-set inputs per prompt; outputs must pass schema plus target validation | Runs in CI on prompt changes |

**Non-negotiables:**
- **Health maths has 100% branch coverage**, with tests for every safety gate (calorie floor, under-18, pregnancy, conditions).
- A bug fix starts with a failing test that reproduces it.
- CI must be green to merge: lint, static analysis, types, tests and a build for every touched app.
- No merging your own PR without review once there's more than one developer.

## 8. Modular
- Backend code lives in **domain modules** (`app/Modules/<Domain>`). See `CONTEXT.md §5`.
- A module may use another module only through its **public service or contract, or by listening to its events**. Never import another module's models, and never join across module tables in raw queries.
- Each module has its own routes file, tests folder and README stating what it owns.
- Frontend code is organised by feature (`features/plan`, `features/recipes`…), with shared things in `packages/` or `shared/`.
- Features can be switched off with feature flags so Phase 2 and 3 work can merge early and stay dark.

---

## Suggested additions (keep, edit, or delete)

### 9. Security
- Mutations never use GET. Policies authorise every model access.
- Secrets go in env or a secret manager, never in git. `.env` stays gitignored.
- Health fields are encrypted at rest; logs never contain health data, tokens, or personal data.
- Rate-limit auth, AI and search endpoints.

### 10. Health & AI safety
- **AI never produces a number the user sees.** Numbers come from code or the database (`PLAN.md §4.2`).
- Allergies are hard filters everywhere: plan, recipes, swaps and shop.
- Any change to plan maths needs a reviewer and updated tests, and bumps `formula_version`.

### 11. i18n & accessibility
- No hard-coded user-facing strings. Every string is an i18n key in Arabic and English.
- Numbers always use Western digits (0–9), in Arabic too. Inputs accept Eastern Arabic digits (٠–٩) and normalise them. See ADR 0006.
- Use logical layout properties (`start`/`end`, never `left`/`right`). Test every screen in RTL.
- Meet WCAG AA contrast, use touch targets of at least 44 pt, and label every image and control.

### 12. Git & delivery
- Small PRs (aim for less than ~400 changed lines). One concern per PR.
- Conventional commits (`feat:`, `fix:`, `refactor:`…).
- Every architectural decision gets an ADR in `docs/adr/`.
- Migrations are forward-only in production and must be reversible locally.
