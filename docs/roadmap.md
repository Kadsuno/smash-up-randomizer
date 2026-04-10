# Smash Up Randomizer — Roadmap

High-level product and engineering priorities. Update this file in the same PR when work **implements, completes, or materially advances** items listed under **Now** or **Next** (see project Cursor rule: full development workflow).

## Vision

- Help Smash Up players set up games quickly with fair randomization and a clear, bilingual (EN/DE), GDPR-respecting experience.

## Shipped / On main


| Area     | Notes                                                                        |
| -------- | ---------------------------------------------------------------------------- |
| Core app | Laravel 13, Blade, Vite, **Tailwind CSS 4** (dark-first UI), Alpine.js (`sur-*` layout components, scroll-reveal), bilingual frontend strings; modern public header/footer (pill nav, footer columns); custom global scrollbar (indigo/violet “SUR” thumb + zinc track, `.sur-scrollbar` utility); **marketing landing** on `/` (carousels, CTAs, **faction spotlight** hero art — four base factions, original AI — see `docs/image-credits.md`); **shuffle `<dialog>`** wizard (stepper, radio player tiles, sticky footer); **landing marketing enhancements** — stats bar, "How it works" 3-step section, faction combo tiles, faction teaser strip, improved eyebrow copy (EN/DE) |
| Branding | SVG logo mark + generated favicons / touch icons; manifest paths under `/images/favicons/` |
| Privacy  | First-party cookie UI (bottom strip + preference modal); web analytics via **self-hosted Matomo** (`analytics.kadsuno.com`) only after opt-in, configurable (see `config/matomo.php`, CHANGELOG) |
| Ops      | Optional **Sentry** error reporting (`sentry/sentry-laravel`, `SENTRY_LARAVEL_DSN`, `config/sentry.php`); transactional email via Laravel mailer — **SMTP** (`MAIL_*`) or **Brevo API** (`MAIL_MAILER=brevo`, `BREVO_API_KEY`, same pattern as Issue Forge; see README) |


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
- `docs/tickets/2026-04-07-shuffle-modal-reconceive-option-a.md` — shuffle wizard modal option A (native `<dialog>`, fixed chrome + scrolling body)