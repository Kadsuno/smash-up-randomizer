## Title
Replace Cookiebot with a self-hosted cookie consent banner and deferred Matomo

## Summary
Remove the third-party Cookiebot script and implement a lightweight, bilingual cookie banner that stores consent in the browser and loads Matomo analytics only after the user opts in to statistics cookies. This avoids recurring Cookiebot cost while keeping analytics behind consent.

## Background / Context
- **Current behavior:** `header.blade.php` loads Cookiebot from `consent.cookiebot.com` and injects Matomo when `config('matomo.enabled')` is true, without gating the tracker on consent in the Blade output.
- **Relevant modules:** `resources/views/components/layouts/header.blade.php`, `resources/views/legal/privacyPolicy.blade.php`, `lang/en|de/frontend.php`, `resources/lang/en/frontend.php`, `tests/Feature/MatomoTrackingTest.php`, `config/matomo.php`.
- **User story:** As a site owner, I want to stop paying for Cookiebot but still show a consent UI and only run analytics after opt-in.

## Requirements
- [ ] Remove all Cookiebot script references and any dependency on Cookiebot IDs in the codebase.
- [ ] Show a first-visit cookie banner (EN/DE via existing `__()` frontend keys) with at least: short explanation, link to privacy policy, “Necessary only”, “Accept analytics” (or equivalent), and a way to reopen settings (e.g. footer link).
- [ ] Persist consent in the browser (e.g. `localStorage` with a versioned key) so repeat visits do not show the banner until preferences change.
- [ ] When Matomo is enabled in config, do not load the Matomo tracker script until the user has accepted analytics; after opt-out or “necessary only”, do not load Matomo on subsequent page loads.
- [ ] Update privacy policy copy to describe the in-house consent mechanism instead of Cookiebot (EN + DE).
- [ ] Update `docs/roadmap.md` shipped privacy row if it still mentions Cookiebot.

## Technical notes
- Prefer Bootstrap 5 patterns already used; implement JS in `resources/js/` (new module imported from `app.js` or footer stack).
- Expose Matomo tracker URL and site id to JS via a small JSON/config block in Blade when `matomo.enabled` is true (no secrets).
- Remove unused `public/vendor/cookie-consent` asset link from the layout; optionally delete orphaned vendor assets in the same change if safe.
- **Public copy:** Yes — banner text + privacy policy + CHANGELOG `[Unreleased]`.

## Testing
- **PHPUnit:** Adjust `MatomoTrackingTest` (and add assertions if needed) so expectations match server-rendered HTML: when Matomo is enabled, the page exposes configuration for deferred loading and does not include an unconditional inline Matomo bootstrap that fires before consent; when Matomo is disabled, no Matomo markers.
- **Manual:** Visit home as new session (or clear site data), verify banner; accept analytics and confirm network request to Matomo host; “necessary only” and verify no Matomo; footer link reopens settings; switch locale EN/DE if applicable.

## Impact / Risks
- Existing Cookiebot consent cookies are not migrated; users may see the banner again once (acceptable).
- Legal wording is informational only; operator remains responsible for final privacy text.
