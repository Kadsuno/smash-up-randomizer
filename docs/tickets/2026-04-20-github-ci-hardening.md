## Title
Harden GitHub integration: Dependabot, Pint in CI, Composer audit

## Summary
Align automation with project rules: add Dependabot for Composer and npm, run Laravel Pint (`--test`) and `composer audit` in CI alongside existing PHPUnit and Vite build. Adds `laravel/pint` as a dev dependency so local and CI gates match.

## Background / Context
- CI currently runs Composer install, frontend build, and `php artisan test` on `dev` / `master`.
- Cursor workflow expects Pint when present; Pint was not in `composer.json` or CI.
- No Dependabot configuration; dependency updates rely on manual bumps.

## Requirements
- [x] Dependabot opens weekly version PRs for Composer, npm, and GitHub Actions
- [x] CI fails on known vulnerable Composer dependencies (`composer audit`)
- [x] CI runs Pint in test mode (`./vendor/bin/pint --test`) after Composer install
- [x] `laravel/pint` is a `require-dev` dependency with lockfile updated
- [x] `CHANGELOG.md` and `README.md` CI description reflect new checks

## Technical notes
- Paths: `.github/workflows/ci.yml`, new `.github/dependabot.yml`, `composer.json`, `composer.lock`, `CHANGELOG.md`, `README.md`
- **Plan:** User confirmed scope in chat after analysis (“anpassen”); standard GitHub/Laravel patterns, no new routes or product behavior

## Testing
- **PHPUnit:** existing suite unchanged; run `php artisan test` after edits
- **Lint:** `./vendor/bin/pint --test` must pass locally and in CI

## Impact / Risks
- First Pint run may touch many PHP files (formatting only); review diff for accidental logic changes (should be none)
- `composer audit` may fail until vulnerable transitive deps are upgraded (address via Dependabot or manual bumps)
