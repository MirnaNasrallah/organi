# ADR-0004: Sanctum tokens for mobile; no web login in Phase 1

**Status:** Accepted
**Date:** 2026-10-18
**Deciders:** Mirna Nasrallah

## Context
Mobile is the main product and needs accounts. The Phase 1 website is public: SEO pages, calculators, the blog and app links (PLAN §3). PLAN Phase 0 planned Sanctum cookies for the web, but cookie (SPA) auth means the web and API must share a parent domain, plus CORS, CSRF and forwarding cookies through server rendering, all for pages that don't need a user.

## Decision
- Mobile uses Sanctum personal access tokens: one per device, stored in `expo-secure-store`, sent as a bearer token, with an expiry (`sanctum.expiration`), and revoked on logout.
- The website has no login in Phase 1. Its calculators call public, rate-limited API endpoints, so plan maths lives only in PHP.
- Revisit when web checkout or a web account area is planned (Phase 2).

## Options considered
- **Tokens on mobile, no web auth (chosen):** the least moving parts for what Phase 1 ships.
- **Tokens plus SPA cookies now:** as PLAN Phase 0 says; pays the domain, CORS and CSRF cost a phase early.
- **Passport / OAuth:** for third-party clients, which we don't have.

## Consequences
- PLAN Phase 0 points here instead of planning cookie auth for the web.
- Login, register and calculator endpoints are rate-limited (RULES §9). Tokens are never logged.
