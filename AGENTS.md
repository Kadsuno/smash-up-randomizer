# AGENTS.md

> **Scope:** This file is read by **Cursor Cloud agents and CI runners** that operate without DDEV. Local development uses DDEV; see `.cursor/rules/smash-up-full-workflow-detail.mdc` for the authoritative local workflow.

## Stack overview

Laravel 13 + PHP 8.3 + Vite 5 + Tailwind CSS 4 + Alpine.js. See `README.md` for full details.

---

## Environment detection — ALWAYS do this first

Before running any `php`, `composer`, or `npm` command, detect the environment:

```bash
if ddev describe 2>/dev/null | grep -q "smash-up-randomizer"; then
  DDEV_AVAILABLE=true
else
  DDEV_AVAILABLE=false
fi
```

Or use the short inline form:

```bash
# With DDEV (local dev — preferred):
ddev exec php artisan test

# Without DDEV (Cloud VM fallback only):
php artisan test
```

---

## Local development (DDEV — preferred)

The project uses **DDEV** (`smash-up-randomizer.ddev.site`) with MariaDB 10.4. All `php`, `composer`, and `npm` commands MUST be prefixed with `ddev exec` / `ddev composer` / `ddev npm` when DDEV is running.

```bash
ddev exec php artisan serve       # not needed — ddev start covers this
ddev exec php artisan test        # run tests
ddev exec php artisan migrate     # run migrations
ddev exec php artisan db:seed --class=DeckSeeder
ddev composer install
ddev npm run build
ddev npm run dev
```

App URL: `https://smash-up-randomizer.ddev.site`  
phpMyAdmin: `https://smash-up-randomizer.ddev.site:8037`

---

## Cursor Cloud agent environments (no DDEV)

Cloud VMs do not have DDEV. Use direct commands as a fallback **only in this context**:

```bash
php artisan serve --host=0.0.0.0 --port=8000   # HTTP server
npm run dev                                       # Vite dev server (HMR)
```

The `.env` is configured with `DB_CONNECTION=sqlite` and a pre-created `database/database.sqlite` file. No MySQL/MariaDB needed.

---

## Tests

```bash
# Local (DDEV):
ddev exec php artisan test

# Cloud VM fallback:
php artisan test
```

All tests use SQLite in-memory — no database server required. The Vite manifest (`public/build/manifest.json`) must exist for Blade `@vite` directives; run `npm run build` (or `ddev npm run build`) once if tests fail with "Vite manifest not found".

---

## Linting

Laravel Pint is installed as a dev dependency and runs in CI (`pint --test`). PSR-12 is the style convention.

```bash
ddev exec ./vendor/bin/pint        # local
./vendor/bin/pint                  # Cloud VM fallback
```

---

## Frontend build

```bash
ddev npm run dev      # Vite dev server with HMR (local)
ddev npm run build    # production build (local)
```

---

## Database

- **Local (DDEV):** MariaDB 10.4 via DDEV (`db` service). `ddev exec php artisan migrate`.
- **Cloud VM / Tests:** SQLite at `database/database.sqlite` (dev) or `:memory:` (tests, via `phpunit.xml`).
- Seed factions: `ddev exec php artisan db:seed --class=DeckSeeder` (idempotent, uses `updateOrCreate`)

---

## Gotchas

- Always use `ddev exec` for artisan/composer/npm when DDEV is running — direct invocations bypass the DDEV PHP/Node versions.
- `MATOMO_ENABLED=false` in `.env` to avoid loading external analytics scripts locally.
- The `database/data/factions/` directory contains JSON seed data for all 106 factions.
- When giving the DDEV hostname to browser subagents, use `https://smash-up-randomizer.ddev.site` (not `127.0.0.1:8000`).
