# Identity

Owns users, sign-up, sign-in and device tokens (CONTEXT §5). Consent records arrive with onboarding.

## Public surface

| Route | Auth | What |
|---|---|---|
| `POST /api/v1/auth/register` | none, rate-limited | Creates an account; returns a token for this device (201) |
| `POST /api/v1/auth/login` | none, rate-limited | Returns a new token for this device |
| `POST /api/v1/auth/logout` | bearer | Revokes the token the request used (204) |
| `GET /api/v1/me` | bearer | The signed-in user |

- `Models\User` is the account. Other modules refer to users by id or through this module's actions, never by querying it directly (RULES §8).
- `Actions\RegisterUser`, `Actions\LogIn`, `Actions\LogOut` hold the logic; controllers only call them.

## Rules

- **Tokens (ADR 0004):** Sanctum personal access tokens, one per device. They expire after 90 days (`config/sanctum.php`), and expired ones are pruned daily. The mobile app keeps them in `expo-secure-store`.
- **Emails** are stored trimmed and lower-cased (`Email::normalise`), so one address is one account whatever its case. The old app let duplicates in.
- **Passwords:** at least 8 characters (`IdentityServiceProvider`), stored hashed.
- **Sign-in** gives the same answer for a wrong email and a wrong password, and takes the same time either way (Laravel's timebox), so neither can reveal who has an account.
- **Rate limits:** 5 attempts a minute per email and IP, for sign-up and sign-in (RULES §9).

## Not yet

- Email verification and password reset.
- Consent records for health data (PDPL, CONTEXT §8), at onboarding.
- Arabic validation messages: Laravel only ships English, so errors come back in English even for `Accept-Language: ar`.
- Checking passwords against known breaches (an external call, so it needs care: RULES §6).
