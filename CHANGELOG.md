# Changelog

All notable changes to this project are documented in this file.

## [Unreleased]

### Added

- **Frontend:** Tailwind CSS v3 (mobile-first utilities), dark-first layout, and component tokens (`sur-*` classes) replace Bootstrap 5 across Blade views. Vite builds `resources/css/app.css` (Font Awesome + animate.css retained). Cookie preferences use the native `<dialog>` API instead of Bootstrap modals; navigation uses Alpine.js for mobile menus and backend user dropdown. Default Laravel pagination views set to Tailwind (`AppServiceProvider`).
- **SMTP / Brevo API transactional mail:** contact form and `php artisan email:test` use Laravel’s configured mailer via `App\Services\TransactionalMailService`. **`MAIL_MAILER=brevo`** uses `getbrevo/brevo-php` and `App\Mail\Transport\BrevoApiTransport` (same pattern as Issue Forge; `BREVO_API_KEY`). **`MAIL_MAILER=smtp`** uses `MAIL_*` for any SMTP relay. See README and `.env.example`. Removed `sendgrid/sendgrid` and `symfony/sendgrid-mailer`.
- **Cookie consent:** first-party UI (dark-themed bottom strip + preference modal with categories, Cookiebot-style actions) stores analytics preference in the browser and loads Matomo only after opt-in. A floating cookie icon reopens settings; Cookiebot dependency removed.
- **Sentry** (`sentry/sentry-laravel`): unhandled exceptions can be reported to Sentry when `SENTRY_LARAVEL_DSN` is set in `.env`. Configuration in `config/sentry.php`; exception handling wired in `bootstrap/app.php`. Use `php artisan sentry:test` to verify after configuring the DSN.

### Changed

- Matomo: frontend tracker now uses the self-hosted instance at `analytics.kadsuno.com` (replaces Matomo Cloud). Toggle with `MATOMO_ENABLED`; tracker URL and site id via `MATOMO_TRACKER_URL` and `MATOMO_SITE_ID` (`config/matomo.php`).
- **Brevo (`MAIL_MAILER=brevo`):** uses the **Brevo HTTP API** (`getbrevo/brevo-php`, `App\Mail\Transport\BrevoApiTransport`, `Mail::extend` in `AppServiceProvider`) — same approach as [Issue Forge](https://github.com/Kadsuno/issue-forge). Set **`BREVO_API_KEY`** (not SMTP). For classic SMTP to any provider, keep **`MAIL_MAILER=smtp`** and `MAIL_*`.

### Fixed

- Add `sessions` and `cache` / `cache_locks` migrations for apps using `SESSION_DRIVER=database` and database-backed cache (Laravel 13 default-style tables).

### Changed

- Upgraded the application stack to **Laravel 13** (PHP **8.3+**). DDEV local PHP is set to 8.3. The app uses the Laravel 11+ bootstrap (`bootstrap/app.php`, `bootstrap/providers.php`) instead of `Http/Kernel` and `RouteServiceProvider`.
- **Passport 13**: `User` implements `OAuthenticatable` and uses Passport’s `HasApiTokens`; the `api` guard uses the `passport` driver. The sample `/api/user` route uses `auth:api` instead of `auth:sanctum`.
- Default **cache key prefix** follows Laravel 13’s slug-based pattern. Existing deployments should set `CACHE_PREFIX` (and optionally `SESSION_COOKIE` / `REDIS_PREFIX`) in `.env` if they must keep previous cache or session cookie names (see [Laravel 13 upgrade guide](https://laravel.com/docs/13.x/upgrade)).
