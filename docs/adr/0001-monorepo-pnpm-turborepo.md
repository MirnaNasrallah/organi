# ADR-0001: Monorepo with pnpm workspaces and Turborepo

**Status:** Accepted
**Date:** 2026-10-18
**Deciders:** Mirna Nasrallah

## Context
Three apps (Laravel API, Next.js web, Expo mobile) share a generated API client, design tokens and i18n strings. RULES §4 wants one source of truth for each, and CI must lint, test and build every touched app. The old Organi app sits at the repo root and is not being ported (CONTEXT §2).

## Decision
- One git repo: `apps/api`, `apps/web`, `apps/mobile` and `packages/*`, as in CONTEXT §5.
- pnpm workspaces for the JS side. Turborepo runs `lint`, `typecheck`, `test` and `build`, cached and only for affected packages.
- `apps/api` stays a normal Composer project. Its `package.json` exposes the same task names (`lint` → Pint + PHPStan, `test` → `php artisan test`) so one `turbo run test` covers PHP too.
- The current root app is tagged `legacy` and removed. `apps/api` starts from a fresh Laravel 13 install, not a moved copy.

## Options considered
- **pnpm + Turborepo (chosen):** the smallest setup that works; two small config files; good Next.js and Expo support.
- **Nx:** more features (generators, project graph) and more to learn. We don't need its plugins.
- **Separate repos:** shared packages would need publishing to a registry, and the generated client would drift between apps.

## Consequences
- A shared package changes in the same PR as the apps that use it.
- Expo's Metro bundler needs monorepo config. Follow Expo's current monorepo guide when scaffolding (pnpm may need `node-linker=hoisted`).
- Laravel Herd serves `~/Herd/Organi/public` today. Re-link the site to `apps/api/public` after the move.
- Node and pnpm versions are pinned (`packageManager` in the root `package.json`) so local and CI match.

## Action items
1. [ ] Commit `docs/`; tag `c333d50` (last commit of the old app) as `legacy`.
2. [ ] Remove the old app from `main`; scaffold `apps/api` fresh.
3. [ ] Add `pnpm-workspace.yaml`, `turbo.json` and the CI workflow.
