## Title
Point Matomo tracker to self-hosted analytics.kadsuno.com

## Summary
Replace the current Matomo Cloud embed in the public layout with the self-hosted Matomo instance at `analytics.kadsuno.com`, matching the provided tracking snippet. Configuration should be environment-driven so local and staging can disable tracking without editing Blade.

## Background / Context
- **Current behavior:** `resources/views/components/layouts/header.blade.php` loads Matomo from `smashuprandomizer.matomo.cloud` and the Matomo Cloud CDN script URL.
- **Desired state:** Use the self-hosted tracker base `//analytics.kadsuno.com/` (equivalent to HTTPS in production), `matomo.js` from the same host, site id `1`, as in the product snippet.
- Privacy copy already references Matomo; roadmap currently states no third-party analytics — self-hosted first-party analytics should be reflected there.

## Requirements
- [ ] Public frontend layout loads Matomo from `analytics.kadsuno.com` (tracker URL + `matomo.js`), with site id configurable (default `1`).
- [ ] Tracking can be turned off via environment (e.g. local dev) without removing Blade structure unnecessarily.
- [ ] `docs/roadmap.md` Shipped/Privacy row updated to describe self-hosted Matomo instead of “no third-party analytics” where accurate.
- [ ] `CHANGELOG.md` `[Unreleased]` notes the tracker endpoint change.
- [ ] English and German privacy strings updated if the disclosure should name the self-hosted host (analytics subdomain).

## Technical notes
- Add `config/matomo.php` (or `config/services.php` matomo key) reading `MATOMO_*` env vars; default tracker base `https://analytics.kadsuno.com/` with trailing slash behavior aligned with the snippet.
- Blade: `@if(config('matomo.enabled'))` wrapping the script; use `@json()` for URLs in JS where appropriate.

## Testing
- **PHPUnit:** Unit test for config defaults / disabled state (optional, lightweight).
- **Manual:** Load home page with `MATOMO_ENABLED=true` — network request to analytics host; with `false` — no Matomo script in HTML.

## Impact / Risks
- **Analytics continuity:** Cloud vs self-hosted are different Matomo properties; historical Cloud data is not migrated by this change.
- **CORS / mixed content:** Ensure production site uses HTTPS so tracker URL remains valid (HTTPS base avoids mixed content).
