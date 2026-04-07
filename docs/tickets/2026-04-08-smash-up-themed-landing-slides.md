## Title
Regenerate landing carousel art with Smash Up–inspired (original) faction mash-up themes

## Summary
Research Smash Up’s public positioning (two factions, bases, diverse faction decks). Replace the four hero PNGs with **new AI-generated illustrations** that evoke that fantasy/sci‑fi mash-up table feel **without** copying AEG artwork, logos, or third-party licensed characters. Update `HomeController` asset filenames if renamed, refresh EN/DE alt text to match scenes, and extend `docs/image-credits.md` with IP disclaimer.

## Background / Context
- Smash Up® is a commercial product; **official card/box art is not reusable** in-repo.
- Goal: **Original** visuals aligned with slide copy (mash-ups, collection, house rules, clear pairings).

## Requirements
- [ ] Four new PNGs under `public/images/landing/` with stable filenames referenced from `HomeController`.
- [ ] Prompts avoid recognizable Marvel/Disney/Smash Up-specific illustrations; no readable trademark text.
- [ ] `docs/image-credits.md`: fan-inspired / original AI disclaimer; Smash Up trademark note.
- [ ] EN/DE `landing_slide_*_alt` strings describe the new illustrations accurately.
- [ ] `CHANGELOG` [Unreleased]; `HomeLandingTest` asserts first slide filename.
- [ ] Remove superseded carousel PNGs from git.

## Testing
- `php artisan test`; manual `/` carousel loads all slides.

## Impact / Risks
- Repo binary size may change; note in credits if PNGs remain large.
