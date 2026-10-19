# Lockmate mobile

The main product (PLAN §3): Expo SDK 58, React Native, Expo Router and TanStack Query.

## Run it

```bash
cp .env.example .env    # points the app at the API Herd serves
pnpm --filter @lockmate/mobile start
```

Then press `i` for the iOS simulator (needs Xcode) or scan the QR code with Expo Go on a phone. A phone can't resolve `lockmate-api.test`: serve the API on your network (`php artisan serve --host 0.0.0.0` in `apps/api`) and set `EXPO_PUBLIC_API_URL` to `http://<your Mac's LAN IP>:8000/api/v1`. The Android emulator reaches the Mac at `10.0.2.2`.

## How it's put together

- `src/app/`: routes only (Expo Router). `_layout.tsx` loads Rubik, then provides the language and the query client.
- `src/features/<feature>/`: one folder per feature (RULES §8). A screen's data hook stays apart from its view, so views are tested without the network.
- `src/ui/`: shared primitives (`Screen`, `Card`, `Text`, `Button`) built only from `@lockmate/tokens`. Never use raw colours or sizes.
- `src/api.ts`: `api.useQuery('get', '/status')`, typed from the API spec (`@lockmate/api-client`).
- `src/locale.tsx`: the language. It comes from the phone, English by default; people switch it in system Settings (per-app language), which restarts the app. All strings come from `@lockmate/i18n`.

## Arabic and RTL

- Native layout mirrors for Arabic (`supportsRTL`). Use `start`/`end`, never `left`/`right`: ESLint rejects physical sides in styles.
- `Text` drops letter-spacing in Arabic, because tracking breaks the joins between letters.
- Each Rubik weight is loaded as its own family (`Rubik_500Medium`…), because Android can't pick weights within one family. Only the three weights the tokens use are bundled.

## Checks

`pnpm lint` (ESLint + Prettier), `pnpm typecheck`, `pnpm test` (Jest with React Native Testing Library) and `pnpm build` (bundles iOS and Android with `expo export`).
