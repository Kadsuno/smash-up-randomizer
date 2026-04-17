## Add "What is Smash Up?" explainer section to landing page

## Summary

The landing marketing enhancement removed the original "What is Smash Up?" help card. Newcomers and SEO now lack a concise game explanation. This ticket adds a compact two-column explainer section directly below the combo tiles: short descriptive text on the left, key-fact badges on the right.

## Background / Context

- The previous help cards had a wall-of-text game description (author, mechanics, publisher). These were replaced by visual combo tiles in the marketing enhancement PR.
- Combo tiles show the *appeal* of Smash Up but not the *basics* — what the game is, how many players, how long it takes.
- User story: as a first-time visitor I want to understand what Smash Up is in under 10 seconds without reading a paragraph.

## Requirements

- [ ] New section below combo tiles: heading "What is Smash Up?", 2–3 sentence body (condensed from existing `help_smashup_body` / `help_smashup_function` keys)
- [ ] Key-fact badges on the right (or below on mobile): "2–4 players", "~45 min", "Ages 12+", "Paul Peterson", "Since 2012"
- [ ] Two-column layout on `md+`, stacked on mobile
- [ ] Bilingual EN + DE
- [ ] Reuse existing `sur-card` / `sur-reveal` patterns; no new JS

## Technical notes

- Affected: `resources/views/start/home.blade.php`, `lang/en/frontend.php`, `lang/de/frontend.php`, `resources/lang/en/frontend.php`
- New lang keys: `landing_whatis_eyebrow`, `landing_whatis_title`, `landing_whatis_body`, `landing_whatis_fact_{players,duration,age,author,year}`
- Place section after `{{-- Faction combo examples --}}` section, before faction teaser strip

## Testing

- **PHPUnit:** add assertion to `HomeLandingTest` for `landing_whatis_title`
- **Manual / browser:** EN locale on DDEV; check mobile stacking

## Impact / Risks

- Pure Blade + lang change; no migrations, no API changes
