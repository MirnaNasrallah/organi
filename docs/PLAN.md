---
description: Lockmate product and build plan — phases, AI limits, safety gates, and milestones
alwaysApply: true
---

# Lockmate — Product & Build Plan

> **Tagline:** Lock in. We've got you.
>
> Status: **Draft v0.1** · Owner: Mirna Nasrallah · Last updated: 2026-10-18

---

## 1. The one-line thesis

**Lockmate is a meal shop wearing a fitness coach's clothes.**

People come for free value: a plan, a recipe, a food swap, or "what do I order at KFC?". The plan tells us what they should eat, and the shop sells them exactly that. Every feature either **brings people in** or **pushes them toward a plan-matched order**. A feature that does neither doesn't ship.

```
        ┌──────────── acquisition (free, SEO, shareable) ────────────┐
        │  Recipes · Food swaps · Fast-food guide · Coaches · Blog    │
        └──────────────────────────────┬──────────────────────────────┘
                                       ▼
                         ┌──────────────────────────┐
                         │   MY PLAN (the profile)   │  ← calories, macros, meal slots, likes/dislikes
                         └─────────────┬────────────┘
                                       ▼
                         ┌──────────────────────────┐
                         │   SHOP (the business)     │  ← "fill my day / my week" from plan-matched meals
                         └─────────────┬────────────┘
                                       ▼
                     Delivery → progress check-in → plan adjusts → reorder
```

## 2. Services and the job each one does

| Service | User gets | Business gets | Phase |
|---|---|---|---|
| **My Plan** | A personalised calorie, macro and meal-slot plan built from measurements, diet history, activity and goal | The targeting data the shop runs on | 1 |
| **Recipes** | Healthy recipes made from unprocessed ingredients, with exact macros | SEO pages, and a catalogue of future products | 1 |
| **Food Swaps Bank** | Searchable, sortable, filterable swaps with matched calories and macros | SEO long tail ("rice substitute low carb") and daily repeat use | 1 |
| **Fast-food Guide** | The best order at trending restaurants and chains for your plan | SEO, social shares and habit | 1 |
| **Coaches** | A directory of online and in-person coaches | Trust and partnerships; later a revenue share | 1 (listing) → 3 (self-serve) |
| **Shop** | Buy plan-matched meals for one meal, a day or a week, with online payment and delivery | **Revenue** | 2 |
| **Blog** | Articles and guides | SEO | 1 (blog only) |
| **Community** | Posts, progress, challenges | Retention | Undecided, see §8 |
| **Marketplace** | Coaches, home cooks and cloud kitchens sell through Lockmate | Supply without building kitchens, plus commission | 3 |

## 3. Phases

### Phase 0 — Foundation (≈ 3–4 weeks)
The goal is a clean base that won't need rewriting.

- [ ] Archive the old app on a `legacy` branch or tag. Don't port its code; keep only the idea (see `CONTEXT.md §2`).
- [ ] Set up the monorepo: `apps/api` (Laravel 13), `apps/web` (Next.js), `apps/mobile` (Expo / React Native), `packages/*`.
- [ ] Make Laravel API-only, with versioned routes (`/api/v1`), Sanctum tokens for mobile (no web login in Phase 1, see ADR 0004), and an OpenAPI spec generated from code.
- [ ] Generate a typed TS API client from the OpenAPI spec into `packages/api-client`, used by both web and mobile.
- [ ] Put design tokens in `packages/tokens` as the single source for colours, type and spacing on web and mobile.
- [ ] Support Arabic and English with RTL from the first screen. Retrofitting RTL later is painful.
- [ ] Add CI on every PR: lint, static analysis, tests, type-check, and a build for each app.
- [ ] Configure environments (local / staging / production), secrets management, error tracking and logs.
- [ ] Settle the data model for Phase 1 **with Phase 2 products already in mind** (see `CONTEXT.md §6`).

### Phase 1 — The magnet (MVP) (≈ 8–10 weeks)
The goal is to get people to create a plan and to measure how many would buy.

**Mobile app (the main product)**
- [ ] Onboarding becomes the plan questionnaire: goal, sex, age, height, weight, optional measurements, activity level, diet history, allergies and dislikes, and meals per day.
- [ ] Plan engine: calories and macros calculated deterministically by code, plus an AI-composed sample day/week chosen **only from our recipe catalogue**. See §4.
- [ ] Safety gates: under-18, pregnancy and medical conditions route to "see a professional", with a minimum calorie floor and an eating-disorder risk screen. See §4.3.
- [ ] Recipes: browse, filter by meal slot and macros, save, and "fits my plan" badges.
- [ ] Food Swaps: search, sort by kcal and protein, filter by category or diet tag, and "swap within ±X kcal".
- [ ] Fast-food Guide: by restaurant, "best picks for my remaining calories today".
- [ ] Coaches: a directory with filters (online / in-person, city, specialty, price band) and contact through WhatsApp or a form.
- [ ] Weekly check-in: weight and optional measurements, after which the plan recalculates.
- [ ] **"Order this" buttons on every recipe, recording intent only.** They show "coming soon to your area — notify me". This is the demand test for Phase 2.

**Web (Next.js, SEO-first and mobile-first)**
- [ ] Statically generated pages for every recipe, swap pair, food, restaurant and coach, with structured data (`Recipe`, `NutritionInformation`, `FAQPage`).
- [ ] Calculator landing pages (TDEE, BMI, protein needs) that lead into the app.
- [ ] Blog.
- [ ] App store links, deep links and smart banners.

**Admin**
- [ ] A back-office for recipes, foods, swaps, restaurants, coaches and blog posts, using Filament on Laravel to save months.

**Exit criteria:** plans created, D30 retention, order-intent clicks per plan, and organic traffic. If intent is weak, fix the funnel before building the shop.

### Phase 2 — The shop (the business) (≈ 10–12 weeks)
- [ ] **Decide the fulfilment model first.** This is a business decision, not a code one: own kitchen, partner cloud kitchens, or a hybrid. It drives everything else.
- [ ] Products are meal variants of recipes in calorie-tier portions (e.g. 400 / 550 / 700 kcal) with fixed macros per variant.
- [ ] **Plan → cart builder:** "fill my meal", "fill my day" and "fill my week" match plan slots to product variants within tolerance. This is the core feature of the whole company.
- [ ] Cart, checkout and delivery slots, with zones starting in one city (Alexandria).
- [ ] Payments through Egyptian gateways (evaluate Paymob, Kashier and Fawry), cards and wallets, plus **cash on delivery**, which is still expected in Egypt.
- [ ] Weekly subscription boxes, the biggest lever on retention and revenue.
- [ ] Order tracking, notifications, ratings, and reorder in one tap.
- [ ] Kitchen and ops dashboard covering order queue, prep lists, and delivery batches.
- [ ] Promotions such as first-order discounts, referrals and coach codes.

### Phase 3 — The marketplace
- [ ] Coach self-serve: profile, services and pricing, their own recipes, and clients they bring in (with a referral/commission).
- [ ] User-submitted recipes, with nutrition estimated by AI **and confirmed by a reviewer before publishing**.
- [ ] Vendors (cloud kitchens, caterers and home cooks) get onboarding, KYC, menu management with mandatory macros, order handling, payouts and commission.
- [ ] Vendor quality: food-safety documentation, ratings, and delisting rules.
- [ ] Lockmate becomes "Talabat, but every meal fits your plan".

## 4. AI — where it helps and where it is not allowed

### 4.1 Where AI is used
| Feature | AI does | Code does |
|---|---|---|
| Plan | Picks and arranges meals from our catalogue to fit targets and preferences; writes the friendly explanation | Calculates BMR/TDEE, calorie target, macros and safety floors; **validates** the AI's meal set against targets and rejects it if it is off |
| Swaps | Suggests swaps in natural language ("I'm craving something crunchy") | Ranks by real macro distance from the database |
| Fast-food guide | Explains picks and handles "no sauce" variations | Filters items by remaining calories and macros |
| Check-ins | Tone, encouragement and pattern spotting | Adjusts the trend-based calorie target |
| Recipe submissions (Ph3) | Drafts ingredient parsing and a nutrition estimate | A human reviewer approves; nothing is published unreviewed |
| Shop (Ph2) | "Build me a week under 1,800 kcal, no fish" | Cart builder enforces targets and stock |
| Support | First-line chat | Escalates to a human |

### 4.2 Rules for AI
1. **The AI never invents a number shown to the user.** Calories and macros come from the database or the calculator.
2. AI output is **structured JSON validated against a schema**. If it fails validation, retry once and then fall back to the deterministic plan.
3. One `AiClient` contract keeps the provider swappable, with prompts versioned in the repo and per-feature cost and latency logging.
4. All AI calls run **in queued jobs**. A request never blocks on a model.
5. A golden-set eval runs in CI for each prompt (see `RULES.md §7`).

### 4.3 Health and safety (non-negotiable)
- Minimum calorie floor and a maximum weekly loss rate, enforced in code.
- Under-18, pregnant or breastfeeding users, and anyone who reports conditions such as diabetes, kidney disease or a history of eating disorders, get no aggressive deficit and are told to see a professional.
- Allergies act as hard filters. They are never a "preference".
- Every plan screen says it is general guidance and not medical advice.
- Health data is sensitive personal data. See `CONTEXT.md §8` (Egypt PDPL).

## 5. Architecture (summary — details in `CONTEXT.md`)

```
apps/
  api/       Laravel 13 · REST /api/v1 · Sanctum · Queues (Redis + Horizon) · Scout + Meilisearch · Filament admin
  web/       Next.js (App Router) · SSG/ISR for SEO pages · mobile-first
  mobile/    Expo + React Native · Expo Router · TanStack Query
packages/
  api-client/  generated from OpenAPI, the only way apps talk to the API
  tokens/      design tokens → CSS variables (web) + TS theme (mobile)
  ui/          shared primitives where it makes sense (logic, formatting, i18n strings)
  config/      eslint, tsconfig, prettier
```

**Why Next.js and not plain React:** the website's job is SEO, and that needs server-rendered or static HTML for thousands of recipe, swap and food pages. Plain React doesn't give you that without extra work.

## 6. Milestones

| # | Milestone | Done when |
|---|---|---|
| M0 | Foundation | CI green on all three apps; auth works end to end; tokens are shared |
| M1 | Plan engine | A user finishes onboarding and gets a validated plan; safety gates are tested |
| M2 | Content engines | Recipes, swaps, fast-food guide and coaches are live in the app and on SEO pages |
| M3 | Public beta | App store builds plus website; intent tracking live |
| M4 | Shop pilot | One kitchen, one city, plan → cart → pay → deliver |
| M5 | Subscriptions | Weekly box with recurring payment |
| M6 | Marketplace alpha | First external kitchen and first self-serve coach |

## 7. Metrics

- **North star (Phase 2+):** weekly plan-matched meals delivered.
- **Phase 1:** plans completed, % of plan users who tap "Order this", D7 and D30 retention, weekly check-ins, organic sessions.
- **Phase 2:** conversion from plan to first order, repeat rate, subscription share, average order value, contribution margin per order.

## 8. Open decisions

| Decision | Options | Leaning |
|---|---|---|
| Fulfilment model | Own kitchen / partner kitchens / hybrid | Pilot with **one partner kitchen** to validate before capex |
| Community | Full feed / challenges only / none | **Start with challenges**, which are cheaper to moderate; a feed later if retention needs it |
| Coaches monetisation | Listing fee / lead fee / commission | Free listings in Ph1, commission once booking is in-app |
| Nutrition data source | Own curated DB / licensed / mixed | Curated DB seeded from public tables, with Egyptian dishes added by a nutritionist |
| Monorepo tooling | pnpm + Turborepo / Nx | pnpm + Turborepo, the simplest that works |
| Nutritionist | Hire / contract / advisor | Need at least a **contract reviewer** before public beta |

## 9. Risks

- **Nutrition accuracy.** Wrong macros kill trust. Mitigate with a curated database, reviewer sign-off, and "estimated" labels where data is estimated.
- **Food ops are hard.** Margins, spoilage and delivery windows are the real risk. Pilot small and measure margin per order early.
- **Health liability.** Mitigate with safety gates, disclaimers and a legal review before launch.
- **Fast-food brand use.** Use restaurant names only factually, without logos or affiliation claims unless there's a partnership. Mark estimated nutrition clearly.
- **Scope creep.** Six services is a lot. Phase 1 ships the minimum version of each, and nothing reaches Phase 2 before its exit criteria are met.
