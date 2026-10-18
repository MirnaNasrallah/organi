---
description: Lockmate project context — product, glossary, system shape, data model, and stack
alwaysApply: true
---

# Lockmate — Project Context

> Read this first. It explains what Lockmate is, where it came from, who it's for, and how the system is shaped.
> It is written for humans and for AI coding agents working in this repo.
>
> Status: **Draft v0.1** · Last updated: 2026-10-18 · See also: `PLAN.md`, `RULES.md`

---

## 1. What Lockmate is

Lockmate is a **mobile-first nutrition and fitness app that ends in a meal shop**.

- On the surface it's your pocket fitness coach: a personalised plan, healthy recipes, a food-swap bank, a fast-food guide and a coach directory.
- Underneath it's **e-commerce**. Your plan decides which meals the shop shows you, and you buy a meal, a day or a week that fits.
- **The shop is the centre and every other service orbits it.** When in doubt, ask "does this bring users in, or move them toward a plan-matched order?"

## 2. Where it came from

This repo started in 2021 as **Organi**, a student project by six junior developers. It was an organic-products shop in Laravel with Blade, Bootstrap 4 and jQuery, and it was recently bumped to Laravel 13.

**What's worth keeping is the idea:** a shop that is filtered by the user's own body data. The old app already computed BMI and maintenance calories (Harris-Benedict) on the dashboard, and had a "My Plan" shop view.

**What is not worth keeping is the code.** It is a reference for what not to do:

| Old pattern | Why it's a problem | New rule |
|---|---|---|
| `GET /addtocart/{id}`, `GET /deletefromcart/{id}` | State changes over GET: CSRF and prefetch risk | Mutations use POST, PATCH or DELETE only |
| `shopIndexLow` / `shopIndexHigh` / `shopIndexPlan`, each with its own view | Copy-pasted controllers and views for what are just sort orders | One endpoint with `?sort=` and `?filter=` |
| Calorie and BMI maths inside `AuthController::update` | Domain logic in a controller, untestable | Pure, unit-tested domain services |
| `price` stored as `string` | Can't sort or sum, and has rounding bugs | Money stored as integer minor units (piastres) |
| `users.email` as `text` with no unique index | Duplicate accounts | Unique, normalised email |
| `carts` / `wishlists` with nullable IDs and no foreign keys | Orphan rows | Foreign keys with explicit `onDelete` |
| Lowercase model class names (`product`, `cart`) | PSR violations and autoload surprises | PSR-12 and Pint-enforced |
| Messages built by string concatenation in controllers | Not translatable | i18n keys, Arabic and English |

**Plan:** tag the old code as `legacy`, then rebuild in the monorepo layout below.

## 3. Who it's for

**Primary market:** Egypt, starting in Alexandria and then Cairo. The app is in Arabic and English, with RTL as a first-class layout.

| Persona | Wants | Pain today |
|---|---|---|
| **The busy cutter** (24–40, office job) | Lose fat without cooking every day | Calorie apps don't know Egyptian food; healthy delivery is random |
| **The gym regular** | Hit protein, keep variety | Meal prep is boring; macros at restaurants are a guess |
| **The beginner** | "Just tell me what to eat" | Overwhelmed by conflicting advice |
| **The coach** (Phase 1 listed, Phase 3 self-serve) | Clients and a way to deliver plans | Plans go out as PDFs on WhatsApp and nobody follows them |
| **The kitchen / home cook** (Phase 3) | Steady orders | Hard to reach health-focused buyers |

**Local realities to design for:**
- Cash on delivery is still common, so it must be supported alongside cards and wallets.
- WhatsApp is the default channel for contact, sharing and support.
- Egyptian dishes (koshary, foul, molokhia, fiteer and the like) must be in the food database with real values. Generic Western databases don't cover them.
- Many users are on mid-range Android phones with patchy data, so the app must stay light, cache content, and handle offline gracefully.

## 4. Glossary (use these words consistently in code and UI)

| Term | Meaning |
|---|---|
| **Profile** | A user's body and lifestyle data. Measurements are a **time series**, never overwritten. |
| **Goal** | Lose fat, maintain, or gain muscle, with a target and pace |
| **Targets** | Daily calories and macros (protein, carbs, fat) computed by the plan engine |
| **Plan** | A versioned set of targets plus meal slots, plus an optional suggested menu. A new check-in creates a new plan version. |
| **Meal slot** | A position in the day (breakfast, lunch, snack…) with its own calorie and macro share |
| **Food** | One ingredient or item with nutrition per 100 g (or per unit) |
| **Recipe** | Content: ingredients, steps and computed nutrition per serving |
| **Product** (Phase 2) | A sellable **variant** of a recipe at a fixed portion and calorie tier, with price and stock |
| **Swap** | A pair or group of foods that are interchangeable within a calorie and macro tolerance |
| **Restaurant item** | A menu item from a fast-food or restaurant chain, with source and confidence for its nutrition data |
| **Coach** | A listed professional, online or in person |
| **Vendor** (Phase 3) | An external kitchen or cook selling through Lockmate |
| **Order intent** | A recorded "Order this" tap from before the shop exists, used as the Phase 2 demand signal |

## 5. System shape

```
                ┌─────────────┐        ┌─────────────┐
                │  Mobile app │        │   Website   │
                │ Expo / RN   │        │  Next.js    │
                └──────┬──────┘        └──────┬──────┘
                       │  packages/api-client (generated from OpenAPI)
                       └──────────┬───────────┘
                                  ▼
                       ┌─────────────────────┐        ┌──────────────┐
                       │   Laravel 13 API     │◄──────►│  Filament    │ admin / ops
                       │   /api/v1 · Sanctum  │        └──────────────┘
                       └──┬──────┬──────┬────┘
                          │      │      │
                   ┌──────┘  ┌───┘      └────┐
                   ▼         ▼               ▼
              PostgreSQL   Redis          Meilisearch          S3-compatible storage + CDN
              (primary)    (cache,        (Scout: recipes,     (images)
                           queues,        foods, swaps)
                           Horizon)
                                 │
                                 ▼
                          AI provider (behind AiClient contract, queued jobs only)
```

### Repository layout
```
apps/
  api/        Laravel 13 (API only + Filament admin)
  web/        Next.js App Router
  mobile/     Expo + React Native (Expo Router)
packages/
  api-client/ generated TS client + types (never hand-edited)
  tokens/     design tokens (JSON) → CSS vars + RN theme
  i18n/       shared translation keys (ar, en)
  config/     shared eslint / tsconfig / prettier
docs/         PLAN.md · CONTEXT.md · RULES.md · adr/ (architecture decision records)
```

### Laravel module layout (inside `apps/api`)
Organise by **domain module**, not by technical layer:
```
app/Modules/
  Identity/      users, auth, consent
  Profile/       measurements (time series), preferences, allergies
  Planning/      targets calculator, plan versions, meal slots, AI composer
  Nutrition/     foods, recipes, nutrition calculation
  Swaps/         swap groups, ranking
  Restaurants/   chains, menu items, guide
  Coaches/       directory (Ph1), services & bookings (Ph3)
  Content/       blog
  Commerce/      products, cart, orders, payments, delivery (Ph2)
  Marketplace/   vendors, payouts (Ph3)
  Shared/        money, units, AI client, i18n helpers
```
Each module owns its models, actions or services, HTTP layer (controllers, requests, resources), policies, events and tests. Modules talk to each other through **public services and events**, never through each other's models directly.

## 6. Core data model (Phase 1, with Phase 2 in mind)

```
users ─┬─ profiles (1:1)              goal, sex, birth_date, activity_level, locale
       ├─ measurements (1:N, dated)   weight_kg, height_cm, waist_cm, … (time series)
       ├─ dietary_restrictions (N:M)  allergies (hard) / dislikes (soft)
       ├─ plans (1:N, versioned)      kcal, protein_g, carbs_g, fat_g, formula_version
       │    └─ plan_slots             slot, kcal_share, macros
       │         └─ plan_slot_suggestions → recipes
       └─ order_intents               recipe_id, slot, created_at

foods                      name_ar, name_en, per_100g macros, source, verified_by
recipes                    title_ar/en, steps, servings, nutrition_per_serving (computed), tags
recipe_ingredients         recipe_id, food_id, grams
swap_groups / swap_items   food_id, tolerance
restaurants / restaurant_items   nutrition, source_url, confidence (official | estimated)
coaches                    mode (online|in_person), city, specialties, price_band, contact

── Phase 2 ──
products                   recipe_id, kcal_tier, portion_g, price_minor, active
orders / order_items / payments / deliveries / subscriptions
```

**Key decisions:**
- **A recipe is content and a product is a sellable variant of a recipe.** Phase 1 recipes become Phase 2 products without a migration. Design recipes so they can scale to calorie tiers.
- Nutrition is **computed from ingredients**, never typed in by hand on the recipe.
- Money is stored as integer minor units with a currency code. Weights are stored in grams and energy in kcal.
- Every user-facing text field is bilingual. They use `*_ar` / `*_en` columns, not a translations table (ADR 0002).

## 7. Plan engine (Phase 1 core)

1. **Inputs:** sex, age, height, weight, activity level, goal and pace, meals per day, restrictions.
2. **BMR:** Mifflin-St Jeor by default (more accurate than the Harris-Benedict the old app used). Katch-McArdle when body-fat % is known.
3. **TDEE:** BMR × activity factor.
4. **Target:** TDEE adjusted for the goal, clamped by the safety floor and maximum rate in `PLAN.md §4.3`.
5. **Macros:** protein by body weight (g/kg), fat minimum, carbs as the remainder.
6. **Slots:** split the targets across meals.
7. **Menu (AI):** choose recipes from the catalogue per slot, then **validate in code** against targets ± tolerance. If validation fails, retry once and then fall back to a deterministic picker.
8. **Adjust:** weekly check-ins update the target from the real weight trend, not from the formula alone.

Every plan stores `formula_version` so results are reproducible and explainable.

## 8. Constraints and compliance

- **Personal data:** Egypt's Personal Data Protection Law (Law No. 151 of 2020) treats health data as sensitive. That means explicit consent at onboarding, a minimal set of fields, encryption at rest for health fields, data export and delete on request, and a clear privacy policy. **Get a legal review before public launch.**
- **Health claims:** the app gives general guidance, not medical advice. It has safety gates (see `PLAN.md §4.3`) and must not make claims about treating disease.
- **Payments (Phase 2):** never store card data. Use the gateway's hosted fields or tokens.
- **Food (Phase 2/3):** kitchens and vendors need valid food-safety licensing, with documents kept in the vendor profile.
- **Brands:** fast-food chain names are used factually only, with no logos and no implied partnership.

## 9. Tech stack (decided vs. to decide)

| Area | Choice | Status |
|---|---|---|
| Backend | Laravel 13, PHP 8.3+ | Decided |
| Mobile | React Native (Expo) | Decided |
| Web | Next.js (App Router) | Recommended (SEO) |
| Auth | Sanctum tokens for mobile; no web auth in Phase 1 | Decided, ADR 0004 |
| DB | PostgreSQL | Recommended (JSONB, full-text, robust) |
| Cache / queue | Redis + Horizon | Recommended |
| Search | Meilisearch via Scout | Recommended (typo-tolerant, Arabic OK) |
| Admin | Filament | Recommended |
| API spec | Scramble → `openapi.json` → openapi-typescript + openapi-fetch | Decided, ADR 0003 |
| Mobile data | TanStack Query (via openapi-react-query); minimal global state | Recommended |
| Monorepo | pnpm workspaces + Turborepo | Decided, ADR 0001 |
| Bilingual content | `*_ar` / `*_en` columns | Decided, ADR 0002 |
| Design tokens | Claude Design artifact → `packages/tokens` | Decided, ADR 0005 |
| Number display | Western digits (0–9) in every locale | Decided, ADR 0006 |
| Backend tests | PHPUnit | Decided, ADR 0007 |
| Payments | Paymob / Kashier / Fawry, plus COD | To evaluate in Phase 2 |
| AI provider | Behind `AiClient`, chosen per feature | To decide |
| Hosting | — | To decide |

Record each decision as an ADR in `docs/adr/NNNN-title.md` when it's made.
