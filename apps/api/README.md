# Lockmate API

Laravel 13, API only. Every route lives under `/api/v1` and every module lives in `app/Modules/<Domain>` with its own routes file, tests and README (RULES §8).

```bash
composer setup   # install, .env, key, migrate
composer lint    # Pint (check) + PHPStan at max level
composer format  # Pint (fix)
composer test    # PHPUnit
```

Tests run on in-memory SQLite for now; they move to Postgres with the first real migrations.
