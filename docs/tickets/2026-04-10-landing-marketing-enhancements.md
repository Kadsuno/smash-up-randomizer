## Enhance landing page with stronger marketing sections

## Summary

The current `/` landing page has a hero, features, quotes, CTA band, and help cards — but it lacks key marketing conversion elements and doesn't explain what Smash Up Randomizer is to first-time visitors. This ticket adds five targeted improvements: a stats bar, a "How it works" 3-step section, visual faction combo examples, a faction teaser strip, and fixes the internal "Social proof" eyebrow copy.

## Background / Context

- Current state: the landing page assumes visitors already know what Smash Up is. "What is Smash Up?" is buried at the very bottom. No quick visual overview of the workflow exists.
- The "Social proof" eyebrow is developer-speak (`'landing_showcase_eyebrow' => 'Social proof'`) — not user-facing copy.
- No credibility signals (faction count, free, no account) appear prominently.
- The faction combo concept (e.g. "Ninja Zombies") — the core appeal of the game — is never illustrated visually.
- User story: as a first-time visitor I want to understand what this tool does and why it's fun in under 10 seconds.

## Requirements

- [ ] **Stats bar** — horizontal strip directly below the hero: dynamic faction count (from `$factions`), "100% free", "No account needed", "All expansions supported". EN + DE strings.
- [ ] **"How it works" 3-step section** — between the feature grid and the quotes carousel: numbered steps (Choose players → Filter sets → Get combos). Each step has a number badge, icon, heading, and 1-sentence body. EN + DE strings.
- [ ] **Faction combo examples** — replace the dry "What is Smash Up?" help card wall-of-text with a visually engaging version: 3 hardcoded combo tiles showing `Faction A + Faction B = Combo Name` (e.g. Ninja + Zombie = Ninja Zombies). EN + DE strings.
- [ ] **Faction teaser strip** — horizontal scrollable row of faction chips (using existing `.faction-chip` component style) below the combo examples, showing all DB factions, with a "View all →" link. Reuse `$factions` already passed from `HomeController`.
- [ ] **Fix "Social proof" eyebrow** — change `landing_showcase_eyebrow` in EN/DE to "Trusted by game nights everywhere" / "Von Spieleabenden rund um die Welt".
- [ ] **Hero eyebrow** — make `landing_eyebrow` more explicit for SEO newcomers: "Smash Up faction randomizer · Free · No signup".
- [ ] All changes bilingual (EN + DE).
- [ ] No new JS dependencies; use existing Alpine.js / Tailwind patterns.

## Technical notes

- Affected: `resources/views/start/home.blade.php`, `lang/en/frontend.php`, `lang/de/frontend.php`
- Faction count available via `count($factions)` in Blade (no controller change needed)
- Combo examples are static / hardcoded in lang strings (no DB needed)
- Reuse `.faction-chip`, `.sur-card`, `.sur-reveal`, `<x-sur.section>`, `<x-sur.reveal>` patterns
- Faction teaser strip should be horizontally scrollable on mobile (overflow-x-auto)
- CSS additions in `resources/css/app.css` only if Tailwind utilities are insufficient

## Testing

- **PHPUnit:** `HomeLandingTest` — assert new sections render (stats bar, how-it-works, combo tiles, faction strip)
- **Manual / browser:** verify EN and DE locales on DDEV (`smash-up-randomizer.ddev.site`); check mobile scroll on faction strip; confirm faction count is dynamic

## Impact / Risks

- Pure Blade/lang change; no migrations, no API changes
- Faction strip renders all factions from DB — empty DB in tests should still render gracefully (empty strip or hidden)
- No new tracking/analytics introduced
