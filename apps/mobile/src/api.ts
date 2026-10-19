import { createApiClient } from '@lockmate/api-client';
import createQueryHooks from 'openapi-react-query';
import { deviceLocale } from './locale';

const baseUrl = process.env.EXPO_PUBLIC_API_URL;
if (!baseUrl) {
  throw new Error('EXPO_PUBLIC_API_URL is not set: copy apps/mobile/.env.example to apps/mobile/.env');
}

const locale = deviceLocale();

/** Typed TanStack Query hooks for every API path, e.g. `api.useQuery('get', '/status')`. */
export const api = createQueryHooks(createApiClient({ baseUrl, locale: () => locale }));
