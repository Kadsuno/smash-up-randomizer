# AGENTS.md

## Cursor Cloud specific instructions

### Stack overview

Laravel 13 + PHP 8.3 + Vite 5 + Tailwind CSS 4 + Alpine.js. See `README.md` for full details.

### Running the app (without DDEV)

The Cloud VM does not have DDEV. Use `php artisan serve` + `npm run dev` directly:

```bash
php artisan serve --host=0.0.0.0 --port=8000   # HTTP server
npm run dev                                       # Vite dev server (HMR)
```

The `.env` is configured with `DB_CONNECTION=sqlite` and a pre-created `database/database.sqlite` file. No MySQL/MariaDB needed for local dev or tests.

### Database

- **Dev/local:** SQLite at `database/database.sqlite`
- **Tests:** SQLite `:memory:` (configured in `phpunit.xml`, no extra setup needed)
- After pulling, run `php artisan migrate` to apply any new migrations to the dev SQLite DB.
- Seed factions: `php artisan db:seed --class=DeckSeeder` (idempotent, uses `updateOrCreate`)

### Tests

```bash
php artisan test
```

All 167 tests use SQLite in-memory — no database server required. The Vite manifest (`public/build/manifest.json`) must exist for Blade `@vite` directives; run `npm run build` once if tests fail with "Vite manifest not found".

### Linting

No Pint or ESLint is configured in this project. The CI workflow (`ci.yml`) only runs tests. PSR-12 is the style convention for PHP.

### Frontend build

- `npm run dev` — Vite dev server with HMR (for development)
- `npm run build` — production build (generates `public/build/`)

### Gotchas

- `APP_URL` must be `http://127.0.0.1:8000` (not the DDEV hostname) when running outside DDEV.
- `MATOMO_ENABLED=false` in `.env` to avoid loading external analytics scripts locally.
- The `.ddev/` directory is not present in this checkout — it's gitignored or only exists on dev machines.
- The `database/data/factions/` directory contains JSON seed data for all 106 factions.
