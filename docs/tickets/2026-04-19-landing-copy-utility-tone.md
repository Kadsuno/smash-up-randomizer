## Title
Tone down home landing copy toward utility-tool voice (EN/DE)

## Summary
Guest feedback described the `/` page as overly “marketing / vibe-coded” — especially the triple headline and SaaS-style section labels. This ticket adjusts bilingual strings so the page reads as a randomizer tool first, without changing layout or routes.

## Background / Context
- Current hero uses three short claims separated by periods (`landing_hero_title`), which reads like generic landing-page patterning.
- Sections such as “Why groups use us”, “Trusted by game nights everywhere”, and “Setup that feels like a power-up” reinforce a product-pitch tone.
- Canonical strings live in `lang/en/frontend.php` and `lang/de/frontend.php` (Laravel `lang/` path).

## Requirements
- [ ] Replace the triple headline with a single descriptive H1-style line (EN + DE).
- [ ] Soften or replace marketing-heavy eyebrows/titles for features, quote strip, bottom CTA band, faction strip, and result preview — still accurate to behavior.
- [ ] Update `meta_og_title` (and thus OG/Twitter titles) to match the new positioning.
- [ ] Keep shuffle wizard flow, FAQ, and factual content unchanged unless copy overlaps the same tone problem.
- [ ] No new routes, assets, or Blade structure changes required.

## Technical notes (optional)
- Files: `lang/en/frontend.php`, `lang/de/frontend.php`, `CHANGELOG.md` under `[Unreleased]`.
- Tests: `HomeLandingTest` asserts translation keys, not literal English — expect green without test edits unless assertions reference removed literals elsewhere.

## Testing
- **PHPUnit:** `ddev exec php artisan test --filter=HomeLandingTest`
- **Manual:** Load `/` in EN and DE; confirm hero and sections read as tool-first; spot-check OG title in page source.

## Impact / Risks
- Low risk: string-only change. SEO/social snippets change wording slightly; share images unchanged.
