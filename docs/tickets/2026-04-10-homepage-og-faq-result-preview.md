## Add Open Graph improvements, FAQ section, and result preview to homepage

## Summary
Improve the homepage's social sharing metadata (OG/Twitter/Schema.org), add an FAQ section for trust and SEO, and surface the actual result screen as a "See it in action" preview image. These three low-effort, high-impact marketing enhancements increase discoverability and reduce first-time-visitor hesitation.

## Background / Context
- Current OG `og:title` reads "Assigning randomized factions" — unclear to unfamiliar visitors.
- `og:image` uses the 512px favicon — tiny and uninspiring for social previews.
- Canonical URL is hardcoded; it should use `url()->current()`.
- No FAQ section exists; common questions (account needed? official? all sets?) go unanswered.
- No actual app screenshot is shown anywhere on the landing page.
- Schema.org structured data (`WebApplication`) is absent — affects rich snippets in search.

## Requirements
- [ ] OG `og:title` updated to "Smash Up Randomizer — Fair factions, zero drama"
- [ ] `og:image` / `twitter:image` point to the faction artwork (`images/result.png`, 1792×1024)
- [ ] Canonical `<link>` uses `url()->current()` (already done for `og:url`)
- [ ] `@stack('head')` slot added to header so individual pages can push page-specific meta
- [ ] Schema.org `WebApplication` JSON-LD added to `<head>` (with `@env('production')` guard)
- [ ] FAQ section added to `home.blade.php` (4 Q&As, bilingual EN/DE)
- [ ] "See it in action" section added to `home.blade.php` with the result-preview.jpg screenshot
- [ ] All new lang keys present in `lang/en/frontend.php`, `lang/de/frontend.php`, `resources/lang/en/frontend.php`
- [ ] PHPUnit feature tests assert FAQ headings and result preview visible
- [ ] No regressions in existing `HomeLandingTest`

## Technical notes
- Affected areas: `resources/views/components/layouts/header.blade.php`, `resources/views/start/home.blade.php`, `lang/en/frontend.php`, `lang/de/frontend.php`, `resources/lang/en/frontend.php`, `tests/Feature/HomeLandingTest.php`
- Result preview image: `public/images/landing/result-preview.jpg` (800×805, 116 KB, taken from DDEV result page)
- OG image: `public/images/result.png` (1792×1024 WebP) — already present, good ratio for social
- FAQ placement: before the final CTA band section
- Result preview placement: between the "How it works" section and the testimonials section
- Reuse existing `<x-sur.section>` and `<x-sur.reveal>` Blade components

## Testing
- **PHPUnit**: `HomeLandingTest` — assert FAQ heading present, assert result preview `<img>` visible
- **Manual / browser**: EN and DE locale; check Open Graph tags with og:title meta in browser DevTools; verify Schema.org JSON-LD via browser console

## Impact / Risks
- Low: changes are purely additive HTML/meta; no DB, no migrations
- OG image change affects social card appearance for all pages sharing the global header
- Schema.org JSON-LD only output in production via `@env('production')` guard to keep test noise low
