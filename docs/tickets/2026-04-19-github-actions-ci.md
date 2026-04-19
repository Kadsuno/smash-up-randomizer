## Title
Add GitHub Actions CI and drop unused axios dependency

## Summary
Run PHPUnit and the Vite production build on every push and pull request targeting `dev` or `master`, so regressions are caught before merge. Remove the unused `axios` devDependency left from the Laravel scaffold to reduce supply-chain noise.

## Background / Context
- The project has solid PHPUnit coverage (`phpunit.xml` uses SQLite in memory) but no automated CI workflow in the repository.
- `axios` is not imported anywhere under `resources/js`; keeping an outdated 0.21.x line adds audit surface without benefit.

## Requirements
- [x] GitHub Actions workflow runs on `push` and `pull_request` for branches `dev` and `master`.
- [x] Job installs Composer dependencies, copies `.env` from `.env.example`, generates `APP_KEY`, runs `php artisan test`.
- [x] Job uses Node 20+, runs `npm ci` and `npm run build`.
- [x] README documents CI (status badge linked to the workflow).
- [x] `CHANGELOG.md` `[Unreleased]` notes CI and dependency cleanup.
- [x] `axios` removed from `package.json` / lockfile if still unused.

## Technical notes
- PHP 8.3 on `ubuntu-latest`; extensions include `pdo_sqlite` for in-memory tests.
- Use Composer and npm caching where straightforward.
- **Approach:** Standard Laravel + Vite CI pattern; no new application dependencies.

## Testing
- **PHPUnit:** `php artisan test` locally and in CI.
- **Manual / browser:** not required (no guest-visible UI).

## Impact / Risks
- PRs will fail if tests or `npm run build` break; intended.
- First-time contributors need passing CI before merge; document in README.
