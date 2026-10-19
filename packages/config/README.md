# @lockmate/config

Shared TypeScript, ESLint and Prettier settings, so every package checks code the same way (RULES §2, §3).

## Use it in a package

```jsonc
// package.json
"prettier": "@lockmate/config/prettier",
"scripts": { "lint": "eslint . && prettier --check .", "format": "prettier --write ." },
"devDependencies": { "@lockmate/config": "workspace:*", "eslint": "…", "prettier": "…", "typescript": "…" }
```

```js
// eslint.config.js
export { default } from '@lockmate/config/eslint';
```

```jsonc
// tsconfig.json: the base sets strictness only; each package adds its own module settings
{ "extends": "@lockmate/config/tsconfig.base.json", "compilerOptions": { "module": "…" } }
```

## What it enforces

- **TypeScript:** `strict`, plus `noUncheckedIndexedAccess` and `exactOptionalPropertyTypes`.
- **ESLint:** `@eslint/js` recommended + `typescript-eslint` strict (which bans `any` and non-null assertions).
- **Prettier:** 2-space indent, 120 columns, single quotes, trailing commas. PHP keeps 4 spaces (Pint, PSR-12).

## Why TypeScript 6, not 7

TypeScript 7 is the native (Go) compiler. As of October 2026, `typescript-eslint` supports TypeScript up to `<6.1` and `openapi-typescript` declares 5.x: both need the JavaScript compiler API that 7 doesn't offer yet. The repo stays on `~6.0.3` until they support 7.
