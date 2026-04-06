# Smash Up Randomizer

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MariaDB](https://img.shields.io/badge/MariaDB-10.4-003545?style=flat-square&logo=mariadb&logoColor=white)](https://mariadb.org)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Vite](https://img.shields.io/badge/Vite-5.x-646CFF?style=flat-square&logo=vite&logoColor=white)](https://vitejs.dev)
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)](LICENSE)
[![GitHub last commit](https://img.shields.io/github/last-commit/kadsuno/smash-up-randomizer?style=flat-square)](https://github.com/kadsuno/smash-up-randomizer/commits)
[![GitHub issues](https://img.shields.io/github/issues/kadsuno/smash-up-randomizer?style=flat-square)](https://github.com/kadsuno/smash-up-randomizer/issues)
[![Conventional Commits](https://img.shields.io/badge/Conventional%20Commits-1.0.0-yellow.svg?style=flat-square)](https://conventionalcommits.org)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com)

A web application to help Smash Up players randomly assign factions (decks) and browse faction details. UI copy is maintained in **English and German** where applicable.

## About the Project

Smash Up Randomizer supports:

- Random assignment of factions to players (player count, include/exclude factions via the **home** page shuffle modal → `POST /shuffle/result`)
- Browsing all factions and per-faction detail pages
- Contact form with email delivery (SendGrid)
- Admin area for managing deck data (authenticated users)
- XML sitemap (`/sitemap`) via `spatie/laravel-sitemap`
- Dark-themed, responsive frontend (Bootstrap 5, Vite, Blade)

## Repository layout & workflow


| Path              | Purpose                                                                             |
| ----------------- | ----------------------------------------------------------------------------------- |
| `docs/roadmap.md` | Product/engineering priorities — update when work matches listed items              |
| `docs/tickets/`   | Ticket specs (`YYYY-MM-DD-short-slug.md`), see `.cursor/rules/ticket-authoring.mdc` |
| `.cursor/rules/`  | Cursor project rules (full workflow, ticket format, etc.)                           |


Default branch for integration work is **dev** (see `.cursor/rules/smash-up-full-workflow.mdc`).

## Features

- **Random faction selection**: `POST /shuffle/result` (shuffle UI on the **home** page)
- **Filters**: Number of players and owned expansions on the shuffle form
- **Faction browser**: `/factions` and `/factions/{name}`
- **Legal & info**: `/imprint`, `/privacy-policy`, `/about`
- **Contact**: `/contact-us` (throttled)
- **Admin**: `/admin` (login), `/admin/register`, `/admin/backend/*` (deck manager — auth required)

## Getting Started

### Prerequisites

- PHP **8.3+** (see `composer.json`)
- Composer 2.x
- Node.js **18+** recommended (matches DDEV `nodejs_version`)
- MariaDB or MySQL compatible with Laravel’s requirements

### DDEV (recommended)

Local stack is defined in `.ddev/config.yaml` (PHP 8.3, MariaDB 10.4, Node 18, nginx-fpm).

1. Install [DDEV](https://ddev.readthedocs.io/en/stable/)
2. Clone the repository:

    ```bash
    git clone https://github.com/kadsuno/smash-up-randomizer.git
    cd smash-up-randomizer
    ```

3. Start DDEV:

    ```bash
    ddev start
    ```

4. Install dependencies:

    ```bash
    ddev composer install
    ddev npm install
    ```

5. Environment and app key:

    ```bash
    ddev exec cp .env.example .env
    ddev exec php artisan key:generate
    ```

6. Configure `.env` (database credentials are usually pre-filled for DDEV; adjust `MAIL_*` / SendGrid for email).

7. Migrations:

    ```bash
    ddev exec php artisan migrate
    ```

8. Frontend assets:

    ```bash
    ddev npm run dev
    ```

9. Open **https://smash-up-randomizer.ddev.site** (hostname follows `name:` in `.ddev/config.yaml`).

### Standard installation (without DDEV)

1. `git clone https://github.com/kadsuno/smash-up-randomizer.git && cd smash-up-randomizer`
2. `composer install`
3. `npm install`
4. `cp .env.example .env` — set `DB_*` and mail settings
5. `php artisan key:generate`
6. `php artisan migrate`
7. `npm run dev` (or `npm run build` for production assets)
8. `php artisan serve` (or your web server of choice pointing at `public/`)

## Database (overview)

Typical tables after migrations:

- **users** — admin/backend accounts (Laravel UI auth under `/admin`)
- **decks** — faction/deck content (name, expansion, text fields, image path, etc.)
- **contacts** — contact form submissions
- **jobs**, **failed_jobs** — queue
- **password_resets** — legacy reset tokens if enabled
- **personal_access_tokens** — Sanctum/API-style tokens if used
- **`oauth_*`** — Laravel Passport OAuth tables

DDEV uses **MariaDB** by default; production may use MySQL — both work with Laravel’s database layer.

## Application structure (short)

### Models (`app/Models/`)

- **User** — admin users
- **Deck** — factions / decks
- **Contact** — contact messages

### HTTP

- **HomeController** — home
- **DeckController** — shuffle, list, detail, admin CRUD/CSV
- **ContactController** — contact form
- **Auth controllers** (`App\Http\Controllers\Auth\`) — login/register/logout for admin area (`routes/auth.php`)

### Views

Blade under `resources/views/`: `start/`, `shuffle/`, `decks/`, `frontend/`, `backend/`, `legal/`, `contact/`, `components/`, `errors/`, `emails/`.

### Frontend assets

- **Vite** (`vite.config.js`): entries under `resources/js/`, styles under `resources/sass/`
- **Stack**: Bootstrap 5, jQuery, Alpine.js (see `package.json`), Font Awesome / Bootstrap Icons

### Email

`App\Services\SendgridMailService` uses the SendGrid API (`services.sendgrid.api_key` / env). Symfony mailer transports are also available in `composer.json` for alternative mail configuration.

### Routes (high level)


| Path                                               | Notes                                                                          |
| -------------------------------------------------- | ------------------------------------------------------------------------------ |
| `/`                                                | Home (shuffle modal → `POST /shuffle/result`)                                  |
| `POST /shuffle/result`                             | Shuffle results (`DeckController@shuffle`)                                   |
| `/factions`, `/factions/{name}`                    | Faction list & detail                                                          |
| `/contact-us`                                      | GET/POST contact                                                               |
| `/about`                                           | About                                                                          |
| `/imprint`, `/privacy-policy`                      | Legal                                                                          |
| `/sitemap`                                         | Dynamic XML sitemap                                                            |
| `/admin`, `POST /admin`                            | Login                                                                          |
| `/admin/register`                                  | Registration (guest)                                                           |
| `/admin/backend`, `/admin/backend/decks-manager/*` | Admin UI (auth)                                                                |


## Development

### Commands

- Assets (dev): `npm run dev`
- Assets (prod): `npm run build`
- Tests: `php artisan test` (or `ddev exec php artisan test`)

### Git branches

- **main** — production-ready
- **dev** — integration branch for features/fixes
- Feature branches: `feat/…`, `fix/…`, `chore/…` as needed

### Commits

[Conventional Commits](https://www.conventionalcommits.org/) style, for example:

```
feat: add expansion filter to shuffle form
fix: correct deck image path on detail view
docs: update README prerequisites
```

## Style guide

- **PHP**: PSR-12, typed properties/parameters where appropriate, DocBlocks for public API per project conventions
- **JS**: ES modules, match existing file style in `resources/js/`
- **Blade / i18n**: User-visible strings via `__('frontend.*')` etc.; maintain **EN** (`resources/lang/en/`, `lang/en/`) and **DE** (`resources/lang/de/`, `lang/de/`) when changing copy

## License

MIT — see [LICENSE](LICENSE).