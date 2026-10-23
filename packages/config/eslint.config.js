import js from '@eslint/js';
import prettier from 'eslint-config-prettier';
import { defineConfig, globalIgnores } from 'eslint/config';
import tseslint from 'typescript-eslint';

// Shared lint rules for every TypeScript package (RULES §2: strict, no `any`).
// Prettier owns formatting, so its config switches off ESLint's style rules.
export default defineConfig(
  // `*.generated.*` files come from tools (e.g. openapi-typescript) and are never edited by hand.
  globalIgnores(['dist/', '**/*.generated.*']),
  {
    files: ['**/*.{ts,tsx,mts,cts}'],
    extends: [js.configs.recommended, tseslint.configs.strict],
  },
  prettier,
);
