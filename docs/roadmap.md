# Smash Up Randomizer — Roadmap

High-level product and engineering priorities. Update this file in the same PR when work **implements, completes, or materially advances** items listed under **Now** or **Next** (see project Cursor rule: full development workflow).

## Vision

- Help Smash Up players set up games quickly with fair randomization and a clear, bilingual (EN/DE), GDPR-respecting experience.

## Shipped / On main


| Area     | Notes                                                                        |
| -------- | ---------------------------------------------------------------------------- |
| Core app | Laravel 13, Blade, Vite, Bootstrap 5, bilingual frontend strings               |
| Privacy  | First-party cookie UI (bottom strip + preference modal); web analytics via **self-hosted Matomo** (`analytics.kadsuno.com`) only after opt-in, configurable (see `config/matomo.php`, CHANGELOG) |
| Ops      | Optional **Sentry** error reporting (`sentry/sentry-laravel`, `SENTRY_LARAVEL_DSN`, `config/sentry.php`) |


*Add rows or subsections here as major capabilities ship.*

## Now

- *(Add current focus bullets.)*

## Next

- *(Upcoming increments.)*

## First release readiness

- *(Checklist for launch-quality bar, if applicable.)*

## Related

- `CHANGELOG.md` — user-visible changes
- `resources/lang/en/`, `resources/lang/de/` — copy and UI strings