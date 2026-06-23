# Activate all Sentry features (tracing, user context, frontend SDK, logs)

## Summary
The Sentry SDK is installed but 90% of its features are inactive. This ticket enables
performance tracing, user context, frontend JS error tracking, structured logs, and
cleans up exception noise.

## Background / Context
- `traces_sample_rate` is `null` → all tracing config is dead code
- No `ignore_exceptions` → 404/422/Auth errors flood Sentry with noise
- No user context → impossible to see affected users per error
- No `@sentry/browser` → frontend JS errors invisible
- `SENTRY_RELEASE` never set → no deploy correlation
- `SENTRY_ENABLE_LOGS` disabled → logs not shipped
- No `SENTRY_ENVIRONMENT` guard → local dev could leak into production Sentry

## Requirements
- [ ] `ignore_exceptions`: filter NotFoundHttpException, ValidationException, AuthenticationException, ModelNotFoundException
- [ ] Enable tracing: `SENTRY_TRACES_SAMPLE_RATE=0.1` default for prod in `.env.example`
- [ ] `SENTRY_RELEASE` set dynamically from git hash in `config/sentry.php`
- [ ] `SentryUserContext` middleware: set user ID + role on authenticated requests
- [ ] Install `@sentry/browser`, initialize in `resources/js/sentry.js`, imported before Alpine
- [ ] `SENTRY_ENABLE_LOGS=true` in `.env.example`
- [ ] `SENTRY_ENVIRONMENT` in `.env.example`; default to `APP_ENV` in config

## Technical notes
- Plan: skipped — new npm dep but follows Sentry's documented Laravel + browser integration 1:1; no arch fork
- Affected: `config/sentry.php`, `.env.example`, `app/Http/Middleware/SentryUserContext.php` (new), `bootstrap/app.php`, `resources/js/sentry.js` (new), `resources/js/app.js`
- Middleware registered as web-append after Localization (auth context available)
- Frontend DSN exposed via Blade meta tag — never hardcode in JS bundle
- `send_default_pii` stays `false` (GDPR); only numeric user ID + role sent

## Testing
- **PHPUnit**: middleware test — authenticated request sets Sentry user scope; unauthenticated skips
- **Manual**: trigger a 404, verify it does NOT appear in Sentry; trigger a 500, verify it does

## Impact / Risks
- Tracing at 0.1 = 10% of requests sampled — negligible performance overhead
- Frontend DSN is public by design (Sentry client-side DSN is meant to be public)
- `SENTRY_ENABLE_LOGS` with `debug` level could be noisy — set to `error` in prod `.env`
