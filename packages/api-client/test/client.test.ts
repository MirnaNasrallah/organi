import assert from 'node:assert/strict';
import { describe, it } from 'node:test';
import { createApiClient, type Locale } from '../src/index.ts';

const BASE_URL = 'https://api.example.test/api/v1';

// Answers like the real status endpoint and remembers every request it saw.
function fakeApi() {
  const requests: Request[] = [];
  const fetch = async (request: Request) => {
    requests.push(request);
    return Response.json({ data: { status: 'ok', locale: request.headers.get('Accept-Language') } });
  };
  return { requests, fetch };
}

describe('createApiClient', () => {
  it('calls paths from the spec under the versioned base URL', async () => {
    const api = fakeApi();
    const client = createApiClient({ baseUrl: BASE_URL, locale: () => 'en', fetch: api.fetch });

    const { data } = await client.GET('/status');

    assert.equal(api.requests[0]?.url, `${BASE_URL}/status`);
    assert.deepEqual(data, { data: { status: 'ok', locale: 'en' } });
  });

  it('sends the current language with every request', async () => {
    const api = fakeApi();
    let locale: Locale = 'en';
    const client = createApiClient({ baseUrl: BASE_URL, locale: () => locale, fetch: api.fetch });

    await client.GET('/status');
    locale = 'ar';
    await client.GET('/status');

    assert.deepEqual(
      api.requests.map((request) => request.headers.get('Accept-Language')),
      ['en', 'ar'],
    );
  });
});
