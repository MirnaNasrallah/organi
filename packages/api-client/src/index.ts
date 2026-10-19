import createClient from 'openapi-fetch';
import type { components, paths } from './schema.generated.ts';

export type { components, paths };

/** The languages the API answers in, straight from the spec (en, ar). */
export type Locale = components['schemas']['Locale'];

export type ApiClientOptions = {
  /** API origin plus version, e.g. "https://api.example.com/api/v1". */
  baseUrl: string;
  /** Read on every request, so switching language applies to the next call. */
  locale: () => Locale;
  /** Swap the transport, e.g. in tests. */
  fetch?: (request: Request) => Promise<Response>;
};

// The only way the apps talk to the API (RULES §3). Every request carries the
// user's language because the API answers in it (ADR 0002).
export function createApiClient({ baseUrl, locale, fetch }: ApiClientOptions) {
  const client = createClient<paths>({ baseUrl, ...(fetch === undefined ? {} : { fetch }) });

  client.use({
    onRequest({ request }) {
      request.headers.set('Accept-Language', locale());
      return request;
    },
  });

  return client;
}

export type ApiClient = ReturnType<typeof createApiClient>;
