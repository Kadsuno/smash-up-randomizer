## Title
Integrate Sentry Laravel SDK for error reporting

## Summary
Add `sentry/sentry-laravel`, wire exception handling in `bootstrap/app.php`, publish `config/sentry.php`, and document `SENTRY_LARAVEL_DSN` so production and staging can report unhandled exceptions to Sentry without changing application business logic.

## Background / Context
- **Current behavior:** Unhandled exceptions are handled by Laravel only (logs, Ignition in dev); no centralized error aggregation for production.
- **Goal:** Follow [Sentry Laravel](https://docs.sentry.io/platforms/php/guides/laravel/) setup: Composer package, `Sentry\Laravel\Integration::handles($exceptions)`, DSN from environment.
- **User story:** As an operator, I want crashes reported to Sentry so I can diagnose issues without relying only on server logs.

## Requirements
- [ ] `sentry/sentry-laravel` is required via Composer and autoloads correctly.
- [ ] `bootstrap/app.php` registers Sentry exception handling via `Integration::handles($exceptions)` inside the existing `withExceptions` callback (preserve proxy trust, schedule, middleware, API routes).
- [ ] `config/sentry.php` exists (published) and DSN is read from `SENTRY_LARAVEL_DSN` in `.env` (not committed with real secrets).
- [ ] README documents optional Sentry DSN for deployments; CHANGELOG notes the integration under `[Unreleased]`.
- [ ] `php artisan sentry:test` succeeds when DSN is configured (documented for manual verification).

## Technical notes (optional)
- **Affected:** `composer.json`, `composer.lock`, `bootstrap/app.php`, `config/sentry.php` (new), `docs/roadmap.md`, `CHANGELOG.md`, `README.md`.
- **Local:** Run `ddev exec php artisan sentry:publish --dsn=...` only on developer machines; CI should not require a real DSN (empty DSN = no reporting).
- **PHP.ini:** Stack trace arguments — document that `zend.exception_ignore_args` should be Off for full Sentry stack args (server-level note in README or technical notes).

## Testing
- **PHPUnit:** No new unit tests required for third-party wiring; existing suite must still pass (`php artisan test`).
- **Manual:** After configuring DSN locally, `php artisan sentry:test` sends a test event; verify in Sentry UI.

## Impact / Risks
- **Privacy:** Error payloads may contain request/user context; ensure Sentry project settings and scrubbing match GDPR expectations (already a privacy-conscious app).
- **Noise:** Dev/test can send events if DSN is set; recommend leaving DSN empty locally or using a separate Sentry environment.
- **Rollback:** Remove package and revert `bootstrap/app.php` if Sentry is discontinued.
