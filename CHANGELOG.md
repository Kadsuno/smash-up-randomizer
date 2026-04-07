# Changelog

All notable changes to this project are documented in this file.

## [Unreleased]

### Added

- **Frontend:** Tailwind CSS v4 with `@tailwindcss/vite` (mobile-first utilities), dark-first layout, and component tokens (`sur-*` classes) replace Bootstrap 5 across Blade views. Vite builds `resources/css/app.css` (`@import "tailwindcss"`, tokens in `@theme`; Font Awesome + animate.css retained). **Requires Node.js 20+** (DDEV `nodejs_version` set to 22). Cookie preferences use the native `<dialog>` API instead of Bootstrap modals; navigation uses Alpine.js for mobile menus and backend user dropdown. Default Laravel pagination views set to Tailwind (`AppServiceProvider`).
- **Theme:** Accent palette shifted to **indigo / violet** (SaaS-style primary indigo, violet for gradients and secondary highlights; replaces cyan accents).
- **SMTP / Brevo API transactional mail:** contact form and `php artisan email:test` use Laravel’s configured mailer via `App\Services\TransactionalMailService`. **`MAIL_MAILER=brevo`** uses `getbrevo/brevo-php` and `App\Mail\Transport\BrevoApiTransport` (same pattern as Issue Forge; `BREVO_API_KEY`). **`MAIL_MAILER=smtp`** uses `MAIL_*` for any SMTP relay. See README and `.env.example`. Removed `sendgrid/sendgrid` and `symfony/sendgrid-mailer`.
- **Cookie consent:** first-party UI (dark-themed bottom strip + preference modal with categories, Cookiebot-style actions) stores analytics preference in the browser and loads Matomo only after opt-in. A floating cookie icon reopens settings; Cookiebot dependency removed.
- **Sentry** (`sentry/sentry-laravel`): unhandled exceptions can be reported to Sentry when `SENTRY_LARAVEL_DSN` is set in `.env`. Configuration in `config/sentry.php`; exception handling wired in `bootstrap/app.php`. Use `php artisan sentry:test` to verify after configuring the DSN.

### Added

- **Marketing landing home:** Rebuilt `/` as a campaign-style page — hero with dual CTAs (shuffle, factions, contact), autoplay image carousel (pause on hover, dots, prev/next), three-column feature grid, rotating quote carousel, gradient CTA band, and compact legacy “What is Smash Up?” cards; shuffle opens a `<dialog>` wizard (see **Shuffle modal** under Changed). New Alpine registrars in `resources/js/landing-home.js`. Feature test `HomeLandingTest`.
- **Landing carousel imagery:** Hero slider uses **AI-generated PNGs** (Cursor image generation) stored under `public/images/landing/`; **four base-game faction spotlights** (Pirates, Aliens, Dinosaurs, Zombies) with **original** art — not AEG card/box illustrations. Provenance, trademark note, and filenames in `docs/image-credits.md`. Slide titles/taglines name each faction (EN/DE).

### Changed

- **Shuffle modal (home):** Redesigned wizard — gradient header with subtitle, numbered stepper with done/current states, sticky footer with **Back** (left) and **Continue** / **Shuffle factions** (right), player count as **radio tiles** (2–4), bilingual copy via `frontend.*`; stronger backdrop blur and card chrome. Inline script uses central footer actions and resets the wizard when opened.
- **Scrollbars:** Document-wide (`html`) scrollbar uses shared SUR-themed styling (indigo/violet gradient thumb, zinc track with indigo hairline, glow). The same chrome applies to `.scroll-container` (faction detail), and the utility class `.sur-scrollbar` is used on scrollable regions (e.g. shuffle modal body, cookie preference panel).
- **Faction detail:** Full-page scroll container uses the global scrollbar theme (see above) instead of hiding the scrollbar.
- **Public shell:** Header and footer redesigned (pill navigation with active route states, scroll elevation, full-width mobile panel with primary CTA; footer columns for brand, explore, legal, and community links + copyright bar). Navigation and footer copy use `frontend.*` translations (EN/DE).
- **Branding:** New vector logo (`public/images/brand/logo-mark.svg`, indigo/violet card-stack motif) used in public and backend nav; favicons and touch icons regenerated from the artwork; PWA manifest paths and theme colors aligned with the dark UI; Open Graph / Twitter preview image uses the 512×512 app icon.
- **Frontend layout:** Blade views use shared `x-sur.*` components (container, section, hero, panel, page heading, scroll reveal) with `@alpinejs/intersect` for in-view motion; main landmark skip link; footer column entrance animation; shuffle wizard styles consolidated in `app.css`. Primary CTAs no longer use infinite pulse animations.
- Matomo: frontend tracker now uses the self-hosted instance at `analytics.kadsuno.com` (replaces Matomo Cloud). Toggle with `MATOMO_ENABLED`; tracker URL and site id via `MATOMO_TRACKER_URL` and `MATOMO_SITE_ID` (`config/matomo.php`).
- **Brevo (`MAIL_MAILER=brevo`):** uses the **Brevo HTTP API** (`getbrevo/brevo-php`, `App\Mail\Transport\BrevoApiTransport`, `Mail::extend` in `AppServiceProvider`) — same approach as [Issue Forge](https://github.com/Kadsuno/issue-forge). Set **`BREVO_API_KEY`** (not SMTP). For classic SMTP to any provider, keep **`MAIL_MAILER=smtp`** and `MAIL_*`.

### Fixed

- **Shuffle modal:** Toggling include/exclude faction chips could paint the dialog contents **solid black** (GPU compositing with `backdrop-blur` + Tailwind `peer` variants). Removed blur layers on the modal card/footer, switched checked styling to **`:has()`** on `.faction-item`, renamed the form class to `shuffle-wizard-form` (no `needs-validation`), added `overflow-anchor: none` on the scroll region and `isolate` on the card.
- **Shuffle modal:** On the last faction rows, **Enter** could trigger **implicit form submit** while the submit button was only `hidden` (still the default submit control), closing/navigating with a **stuck blurred `::backdrop`** in some browsers. The submit control is now **`disabled` unless step 3 is active**, `::backdrop` uses a **solid dim** (no `backdrop-filter`), plus **Enter** on checkboxes is suppressed and a light **`close` reflow** hook was added.
- Add `sessions` and `cache` / `cache_locks` migrations for apps using `SESSION_DRIVER=database` and database-backed cache (Laravel 13 default-style tables).

### Changed

- Upgraded the application stack to **Laravel 13** (PHP **8.3+**). DDEV local PHP is set to 8.3. The app uses the Laravel 11+ bootstrap (`bootstrap/app.php`, `bootstrap/providers.php`) instead of `Http/Kernel` and `RouteServiceProvider`.
- **Passport 13**: `User` implements `OAuthenticatable` and uses Passport’s `HasApiTokens`; the `api` guard uses the `passport` driver. The sample `/api/user` route uses `auth:api` instead of `auth:sanctum`.
- Default **cache key prefix** follows Laravel 13’s slug-based pattern. Existing deployments should set `CACHE_PREFIX` (and optionally `SESSION_COOKIE` / `REDIS_PREFIX`) in `.env` if they must keep previous cache or session cookie names (see [Laravel 13 upgrade guide](https://laravel.com/docs/13.x/upgrade)).
