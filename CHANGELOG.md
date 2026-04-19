# Changelog

All notable changes to this project are documented in this file.

## [Unreleased]

### Fixed

- **i18n source of truth:** Removed the duplicate root `lang/` directory. Laravel resolves translations from **`resources/lang`** when that folder exists, so the previous landing-copy update in root `lang/` never reached the running app. Landing strings are synced in **`resources/lang/en/frontend.php`** and **`resources/lang/de/frontend.php`**.

### Changed

- **Home landing copy (EN/DE):** Hero, feature headings, quote strip eyebrow, bottom CTA band, faction strip, result preview, and Open Graph title now read as a **tool-first randomizer** instead of SaaS-style pitch lines (single-line hero, less “trusted everywhere” / triple-beat marketing cadence). Layout unchanged.

### Security

- **immutable (prototype pollution):** Pinned transitive **`immutable`** to **5.1.5** via npm **`overrides`** (was 5.1.4) to pick up fixes for unsafe handling of `__proto__` in merge / `Map.toJS` / `Map.toObject` paths used by the optional Sass toolchain.

- **Rollup (CVE-2026-27606 / GHSA-mw96-cpmx-2vgc):** Added an explicit **`rollup`** devDependency at **≥ 4.59** (resolved to 4.60.x) so the Vite build no longer uses a vulnerable Rollup 4.53.x. Mitigates arbitrary file write via path traversal in crafted output chunk/asset names during bundling.

### Fixed

- **Landing hero carousel:** Demo slides use consistent horizontal padding, centered step labels, even grids for player tiles and faction chips, and a fixed two-column faction row on the “combos” slide so card height stays uniform on small screens. Pagination dots stay in a thin top row with an `h-11` spacer below; prev/next share a **horizontal flex row** with the demo. The row uses **`items-stretch`** so the center column fills the available height and **`justify-center`** vertically centers the step/cards; chevron buttons use **`self-center`** so they sit on the same vertical axis as that content (avoids `items-center` collapsing the row to content height and sticking the block to the bottom).

- **Landing hero carousel (slides 2–3, mobile):** Demo columns are **top-aligned** (`justify-start`) inside the scrollable band instead of vertically centered — centered flex + bounded height was clipping the first/last rows (faction chips on slide 2, player combo cards on slide 3) on narrow viewports. Slide 3 combo cards use slightly tighter mobile padding/gaps; faction names use **two-line clamp** instead of single-line truncate so long names stay readable in narrow cells. `touch-pan-y` / `overscroll-y-contain` on both slides.

### Changed

- **Shuffle wizard & landing copy:** Clarified that **include** is optional (nothing checked = all eligible factions; logged-in users follow **Collection** when set), explained when **exclude** saves clicks, and aligned carousel / how-it-works / FAQ with **faction-level** choices in the dialog (set-level filtering via account collection, not set toggles in the wizard). Bilingual EN/DE.

- **Social preview (Open Graph / Twitter):** Default share image is now **`images/og-share.png`** (1200×630) instead of `images/result.png`, for consistent link previews on Discord and other platforms. URLs include **`?v=`** from `OG_SHARE_VERSION` / `config('app.og_share_version')` so you can bust crawler caches after replacing the PNG.

### Added

- **Admin backend:** Expanded `/admin/backend` with **Contacts** (list + detail for stored contact form messages), **Users** (promote/demote with protection for the last admin), **Shuffle stats** (aggregates + recent history), and a **CLI reference** page (read-only Artisan hints). Faction manager now uses **server-side search**, content and expansion filters, **pagination**, **DELETE + CSRF** for removals (replacing GET delete), and validated **CSV upload** via `UploadedFile`. Dashboard stats include contacts, users, and shuffle totals; faction admin actions moved to `App\Http\Controllers\Admin\*`.

### Changed

- **Admin login:** `POST /admin` now logs out and returns a validation error if the account is not `role=admin` (instead of redirecting to the dashboard and hitting HTTP 403). This matches deployments where the `users.role` migration set every existing row to `user` — use `php artisan users:promote email@example.com` to restore backend access. README documents the promote step after `migrate`.

- **Landing result preview:** Marketing screenshot is now a **1920×1650 PNG** (`images/landing/result-preview.png`) from a **2× device-scale** headless capture and Lanczos downscale — replaces the small, over-compressed JPEG.

### Added

- **Account: collection, shuffle presets, play history:** Authenticated users can save **owned expansion sets** (`/account/collection`), manage **shuffle presets** (`/account/presets`) and open the home shuffle with one click (`/?shuffle_preset=id`), and browse **recent shuffles** (`/account/history`). When at least one expansion is saved, the shuffle wizard, `POST /shuffle/result`, and `/random` only draw from factions in those sets (guests and users with an empty selection still use all factions). New tables: `user_expansions`, `shuffle_presets`, `shuffle_histories`.

- **Two-factor authentication (TOTP):** Optional MFA for frontend accounts — after password or OAuth sign-in, users with MFA enabled must enter a 6-digit authenticator code or a one-time recovery code. Enable/disable and recovery-code regeneration from **Account → Edit account**. New Composer dependencies: `pragmarx/google2fa`, `pragmarx/google2fa-qrcode`, `bacon/bacon-qr-code`. New columns on `users`: `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`.

- **Brand assets:** `public/images/brand/logo-mark.png` (512×512 PNG from `logo-mark.svg`); `public/images/brand/logo-mark-oauth.png` same mark on a light gray background for OAuth consoles (GitHub’s dark crop UI).

- **Social login (OAuth):** Optional Google and GitHub sign-in via Laravel Socialite (`/auth/{provider}/redirect` + callback). New `users.provider` and `users.provider_id` columns; `password` is nullable for OAuth-only accounts. Login and register show provider buttons when `GOOGLE_CLIENT_ID` / `GITHUB_CLIENT_ID` are set. See `.env.example` and README.

- **Account profile editing:** Authenticated users can now update their display name, e-mail address, and password directly from the `/account` page. E-mail changes re-trigger the verification flow automatically.

- **Frontend user authentication:** Public registration (`/register`), login (`/login`), e-mail verification, and password reset flows for non-admin users. Frontend and admin auth are fully separated: all `/admin/*` routes are now protected by the new `EnsureUserIsAdmin` middleware (403 for non-admins). New `role` column on the `users` table (`admin` | `user`, default `user`). Existing admin users must be re-promoted via `php artisan users:promote {email}`. Nav header shows "Login" link for guests and the user's display name for authenticated non-admin users. Bilingual (EN + DE) — `resources/lang/de/frontend.php` created.

- **Expansions pages:** New `/expansions` overview lists every officially released Smash Up set as a card with faction count and up to four faction thumbnails. `/expansions/{slug}` shows all factions from that set. Linked from footer and from the `/factions` hero.
- **Faction complexity filter:** Filter pills (All / Easy / Medium / Hard) on the `/factions` list allow players to narrow by difficulty without a page reload (client-side Alpine). Also adds a "Browse by expansion" link to the faction list hero.
- **Quick shuffle `/random`:** Hitting `/random` immediately assigns two random factions to each of two players using all available factions — no wizard steps required.

- **Faction wiki enrichment:** New `php artisan factions:enrich` command fetches each faction's full wiki page from the Smash Up Fandom wiki via the MediaWiki API, parses the wikitext into structured fields (`description`, `characters`, `actions`, `actionList`, `actionTeaser`, `bases`, `clarifications`, `effects`, `tips`, `synergy`, `suggestionTeaser`, `cardsTeaser`), writes the enriched data back to the versioned JSON files, and then calls `factions:import`. Supports `--faction=Name` (single faction), `--dry-run` (preview only), and `--skip-import` flags. Rate-limited with 300 ms delay and exponential-backoff retry. New `App\Services\WikitextParser` service handles markup stripping and section extraction.
- **Faction data pipeline:** All 106 Smash Up factions are now seeded from versioned JSON files in `database/data/factions/` (one file per expansion). `DeckSeeder` and the new `php artisan factions:import` Artisan command both run idempotently via `updateOrCreate` on faction name — safe to re-run at any time without creating duplicates. Each faction is pre-populated with `name`, `expansion`, `teaser`, `mechanics`, and `playstyle` from the Smash Up Wiki. Run `php artisan db:seed` or `php artisan factions:import` on a fresh environment to import all factions immediately. Includes `--dry-run` flag for preview without writes.
- **Migration fix:** `create_decks_table` migration now correctly includes `$table->id()` and `$table->timestamps()`. A companion migration (`2026_04_11_000000_add_id_and_timestamps_to_decks_table`) adds these columns idempotently on existing databases that were set up before this fix.

### Changed

- **Landing visual rhythm pass:** Hero carousel slides get individual gradient backgrounds (indigo / violet / indigo+violet) instead of flat zinc-900. Feature-grid section adds a subtle `bg-zinc-900/30` tint with `border-y` and colored 2 px top-border accents per card (indigo / violet). "How it works" redesigned from a card grid to a centred step-flow with arrow connectors on desktop and numbered badges (h-7 solid fill) on the icons. Combo-card section gets a matching section tint. Result-preview section tinted `indigo-950/20`. Logo simplified to two overlapping cards without the shuffle-symbol overlay.

### Added

- **Frontend:** Tailwind CSS v4 with `@tailwindcss/vite` (mobile-first utilities), dark-first layout, and component tokens (`sur-*` classes) replace Bootstrap 5 across Blade views. Vite builds `resources/css/app.css` (`@import "tailwindcss"`, tokens in `@theme`; Font Awesome + animate.css retained). **Requires Node.js 20+** (DDEV `nodejs_version` set to 22). Cookie preferences use the native `<dialog>` API instead of Bootstrap modals; navigation uses Alpine.js for mobile menus and backend user dropdown. Default Laravel pagination views set to Tailwind (`AppServiceProvider`).
- **Theme:** Accent palette shifted to **indigo / violet** (SaaS-style primary indigo, violet for gradients and secondary highlights; replaces cyan accents).
- **SMTP / Brevo API transactional mail:** contact form and `php artisan email:test` use Laravel’s configured mailer via `App\Services\TransactionalMailService`. **`MAIL_MAILER=brevo`** uses `getbrevo/brevo-php` and `App\Mail\Transport\BrevoApiTransport` (same pattern as Issue Forge; `BREVO_API_KEY`). **`MAIL_MAILER=smtp`** uses `MAIL_*` for any SMTP relay. See README and `.env.example`. Removed `sendgrid/sendgrid` and `symfony/sendgrid-mailer`.
- **Cookie consent:** first-party UI (dark-themed bottom strip + preference modal with categories, Cookiebot-style actions) stores analytics preference in the browser and loads Matomo only after opt-in. A floating cookie icon reopens settings; Cookiebot dependency removed.
- **Sentry** (`sentry/sentry-laravel`): unhandled exceptions can be reported to Sentry when `SENTRY_LARAVEL_DSN` is set in `.env`. Configuration in `config/sentry.php`; exception handling wired in `bootstrap/app.php`. Use `php artisan sentry:test` to verify after configuring the DSN.

### Added

- **Marketing landing home:** Rebuilt `/` as a campaign-style page — hero with dual CTAs (shuffle, factions, contact), autoplay image carousel (pause on hover, dots, prev/next), three-column feature grid, rotating quote carousel, gradient CTA band, and compact legacy “What is Smash Up?” cards; shuffle opens a `<dialog>` wizard (see **Shuffle modal** under Changed). New Alpine registrars in `resources/js/landing-home.js`. Feature test `HomeLandingTest`.
- **Landing carousel imagery:** Hero slider uses **AI-generated PNGs** (Cursor image generation) stored under `public/images/landing/`; **four base-game faction spotlights** (Pirates, Aliens, Dinosaurs, Zombies) with **original** art — not AEG card/box illustrations. Provenance, trademark note, and filenames in `docs/image-credits.md`. Slide titles/taglines name each faction (EN/DE).
- **Landing atmosphere images:** Added two free Unsplash photos (Unsplash License) as subtle background textures — a B&W game-night social photo (Maximo Lopez) behind the testimonials section and a B&W scattered-cards-on-dark-surface photo (Phạm Mạnh) behind the CTA band. Both use `opacity` + `mix-blend-luminosity` so the existing gradients remain dominant and readability is unaffected.
- **Landing hero demo carousel:** Replaced four faction artwork image slides with three HTML product-demo slides — Step 1 shows the player count picker (2/3/4 tiles), Step 2 shows faction chips from DB (first 6 highlighted as included, next 4 struck-through as excluded), Step 3 shows a two-player combo result using the first four DB factions. Removes `$landingSlides` array from `HomeController`; carousel count hardcoded to 3. Bilingual slide titles/taglines (EN/DE). Graceful fallback if DB is empty.
- **Landing result preview:** New "See it in action" section between the faction strip and FAQ shows an actual screenshot of the result screen alongside a CTA button. Image stored as `public/images/landing/result-preview.jpg` (800 px, 116 KB).
- **Landing FAQ:** Accordion section with four bilingual Q&As (official product?, account needed?, expansion support, privacy/tracking). Alpine.js accordion; keyboard accessible; placed before the final CTA band.
- **Open Graph / meta improvements:** Updated `og:title` and `twitter:title` to "Smash Up Randomizer — Fair factions, zero drama"; `og:image` and `twitter:image` now use the 1792×1024 faction artwork (`images/result.png`) instead of the 512px favicon; canonical `<link>` now uses `url()->current()`. Added `@stack('head')` slot for per-page meta overrides. Schema.org `WebApplication` JSON-LD added (production env only).
- **Meta description lang keys:** New `meta_description` and `meta_og_title` keys in `lang/en/frontend.php`, `lang/de/frontend.php`, and `resources/lang/en/frontend.php`.
- **Landing Smash Up explainer section:** Compact "What is Smash Up?" card below the combo tiles — two-column layout (description text left, key-fact badges right: 2–4 players, ~45 min, Ages 12+, Paul Peterson, Since 2012); stacks on mobile. Bilingual EN/DE. Restores game context removed by the marketing enhancement PR without reverting to wall-of-text.
- **Landing marketing enhancements:** Five new/updated sections on `/` — (1) **Stats bar** (dynamic faction count, free, no account, all expansions) directly below the hero; (2) **"How it works"** 3-step section (choose players → filter sets → get combos) between features and quotes; (3) **Faction combo tiles** (Ninja Zombies, Space Buccaneers, Dino Mages) replace dry help-card text to illustrate the Smash Up combo concept visually; (4) **Faction teaser strip** — horizontally scrollable row of all DB factions; (5) **Eyebrow copy fixes** — "Social proof" renamed to "Trusted by game nights everywhere" (EN/DE), hero eyebrow updated to include "Smash Up faction randomizer". Bilingual (EN + DE).

### Changed

- **Shuffle modal (home):** **Option A reconceive** — **step badge + stepper** live in a non-scrolling **`.shuffle-modal-chrome`** strip; **only step body** (player tiles / faction grids) scrolls inside **`.shuffle-modal-scroll`**. Opening the wizard or changing steps **scrolls the body region to top**. Same URLs (`/`, `shuffle-result`) and native `<dialog>` behavior.
- **Shuffle modal (home):** Redesigned wizard — gradient header with subtitle, numbered stepper with done/current states, sticky footer with **Back** (left) and **Continue** / **Shuffle factions** (right), player count as **radio tiles** (2–4), bilingual copy via `frontend.*`; stronger backdrop blur and card chrome. Inline script uses central footer actions and resets the wizard when opened.
- **Scrollbars:** Document-wide (`html`) scrollbar uses shared SUR-themed styling (indigo/violet gradient thumb, zinc track with indigo hairline, glow). The same chrome applies to `.scroll-container` (faction detail), and the utility class `.sur-scrollbar` is used on scrollable regions (e.g. shuffle modal body, cookie preference panel).
- **Faction detail:** Full-page scroll container uses the global scrollbar theme (see above) instead of hiding the scrollbar.
- **Public shell:** Header and footer redesigned (pill navigation with active route states, scroll elevation, full-width mobile panel with primary CTA; footer columns for brand, explore, legal, and community links + copyright bar). Navigation and footer copy use `frontend.*` translations (EN/DE).
- **Branding:** New vector logo (`public/images/brand/logo-mark.svg`, indigo/violet card-stack motif) used in public and backend nav; favicons and touch icons regenerated from the artwork; PWA manifest paths and theme colors aligned with the dark UI; Open Graph / Twitter preview image uses the 512×512 app icon.
- **Frontend layout:** Blade views use shared `x-sur.*` components (container, section, hero, panel, page heading, scroll reveal) with `@alpinejs/intersect` for in-view motion; main landmark skip link; footer column entrance animation; shuffle wizard styles consolidated in `app.css`. Primary CTAs no longer use infinite pulse animations.
- Matomo: frontend tracker now uses the self-hosted instance at `analytics.kadsuno.com` (replaces Matomo Cloud). Toggle with `MATOMO_ENABLED`; tracker URL and site id via `MATOMO_TRACKER_URL` and `MATOMO_SITE_ID` (`config/matomo.php`).
- **Brevo (`MAIL_MAILER=brevo`):** uses the **Brevo HTTP API** (`getbrevo/brevo-php`, `App\Mail\Transport\BrevoApiTransport`, `Mail::extend` in `AppServiceProvider`) — same approach as [Issue Forge](https://github.com/Kadsuno/issue-forge). Set **`BREVO_API_KEY`** (not SMTP). For classic SMTP to any provider, keep **`MAIL_MAILER=smtp`** and `MAIL_*`.

### Fixed

- Define `mail.mailers.brevo` in `config/mail.php` so `MAIL_MAILER=brevo` works (Brevo SMTP; same `MAIL_*` as `smtp`, default host `smtp-relay.brevo.com`).
- **Shuffle modal:** Scrolling the faction list and toggling **lower rows** could **shift the dialog upward off-screen** (Chromium re-centered when focus / **`:has(:checked)`** nudged layout). The open dialog is now **top-anchored** (`position: fixed`, `top` + `translateX(-50%)` only) instead of **`margin: auto`** vertical centering; an extra **`requestAnimationFrame`** pass re-applies **`.shuffle-modal-scroll` `scrollTop`** after focus.
- **Shuffle modal:** **`display: flex`** on `#shuffle-modal` (without **`:open`**) overrode the user-agent **`dialog:not(:open) { display: none }`**, so the wizard appeared **on every page load**. Layout rules are now scoped to **`#shuffle-modal:open`**.
- **Shuffle modal:** Toggling include/exclude faction chips could paint the dialog contents **solid black** (GPU compositing with `backdrop-blur` + Tailwind `peer` variants). Removed blur layers on the modal card/footer, switched checked styling to **`:has()`** on `.faction-item`, renamed the form class to `shuffle-wizard-form` (no `needs-validation`), added `overflow-anchor: none` on the scroll region and `isolate` on the card.
- **Shuffle modal:** **Light dismiss** — close when clicking the dimmed **backdrop** outside the card (`closedby="any"` + JS fallback for engines that ignore it).
- **Shuffle modal:** Long **include/exclude** lists with **sr-only** inputs could **shift the dialog off-screen** (focus `scrollInto-view` + scroll position). The dialog node is **moved to `document.body`**, and **pointerdown** / **focusin** handlers **restore page scroll** and **`focus({ preventScroll: true })`** for wizard radios/checkboxes (Chromium especially). **`pointerdown` also stores `.shuffle-modal-scroll` `scrollTop`** and it is **re-applied after 2× and 3× `requestAnimationFrame`** so Chromium cannot leave the list scrolled to the focused control in a later frame.
- **Shuffle modal:** Forcing **`min-h` = `max-h` ~90vh** on the inner card caused the native `<dialog>` to be **too tall for the viewport** when centered — **top edge clipped** (especially with `vh` vs mobile UI). **Reverted** that `min-h`; **`max-h`** now uses **`90dvh`** in Blade and **`max-height: min(calc(100dvh - 1.5rem), 52rem)`** on `#shuffle-modal` so the box stays **inside the visible viewport**.
- **Shuffle modal:** **`max-height` on `<dialog>` without a flex layout** let the inner column grow to **content height**; the dialog then **clipped** with `overflow: hidden` so the faction list **did not scroll**. **`#shuffle-modal`** is now **`display: flex; flex-direction: column`**, and **`.shuffle-modal-card`** uses **`flex: 1 1 auto; min-height: 0; max-height: 100%`** so the scroll region gets a bounded height again.
- **Shuffle modal:** On the last faction rows, **Enter** could trigger **implicit form submit** while the submit button was only `hidden` (still the default submit control), closing/navigating with a **stuck blurred `::backdrop`** in some browsers. The submit control is now **`disabled` unless step 3 is active**, `::backdrop` uses a **solid dim** (no `backdrop-filter`), plus **Enter** on checkboxes is suppressed. **`close` handler:** double `requestAnimationFrame`, forced layout on `html`/`body`, and a **scroll nudge** to fix **Chromium** (Chrome/Brave/Edge) leaving a stuck dim/blur after `dialog.close()`; `::backdrop` uses `transition: none`.
- Add `sessions` and `cache` / `cache_locks` migrations for apps using `SESSION_DRIVER=database` and database-backed cache (Laravel 13 default-style tables).

### Changed

- Upgraded the application stack to **Laravel 13** (PHP **8.3+**). DDEV local PHP is set to 8.3. The app uses the Laravel 11+ bootstrap (`bootstrap/app.php`, `bootstrap/providers.php`) instead of `Http/Kernel` and `RouteServiceProvider`.
- **Passport 13**: `User` implements `OAuthenticatable` and uses Passport’s `HasApiTokens`; the `api` guard uses the `passport` driver. The sample `/api/user` route uses `auth:api` instead of `auth:sanctum`.
- Default **cache key prefix** follows Laravel 13’s slug-based pattern. Existing deployments should set `CACHE_PREFIX` (and optionally `SESSION_COOKIE` / `REDIS_PREFIX`) in `.env` if they must keep previous cache or session cookie names (see [Laravel 13 upgrade guide](https://laravel.com/docs/13.x/upgrade)).
