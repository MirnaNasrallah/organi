# @lockmate/api-client

The typed client web and mobile use to call the API (ADR 0003, RULES §3). Never hand-write `fetch` calls to our API.

## How it's made

1. Scramble reads the Laravel routes, Form Requests and Resources and writes `openapi.json` (`pnpm --filter @lockmate/api spec`). **This file is committed**, so API changes show up as a reviewable diff. Scramble reads column types from the database to document models, so the export needs a migrated Postgres (CI runs one).
2. `pnpm build` turns it into `src/schema.generated.ts` with `openapi-typescript` (not committed).
3. `createApiClient` wraps `openapi-fetch` with those types.

CI exports the spec again and fails if `openapi.json` differs from the committed copy. When you change an endpoint, run `pnpm build` and commit the new `openapi.json`.

## Use

```ts
import { createApiClient } from '@lockmate/api-client';

const api = createApiClient({ baseUrl: 'https://api.example.com/api/v1', locale: () => currentLocale });
const { data, error } = await api.GET('/status'); // paths, params and responses are all typed
```

Every request sends `Accept-Language` from `locale()`, so content comes back in the user's language. TanStack Query hooks (`openapi-react-query`) arrive with the first React app.
