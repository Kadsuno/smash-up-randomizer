## Title
Landing carousel: four base-game faction spotlight slides (original art)

## Summary
Use **four Smash Up base-game factions** (public names only: Pirates, Aliens, Dinosaurs, Zombies) as the hero carousel theme. Replace PNGs with **new original AI illustrations** per faction (not AEG card/box art). Update slide titles/taglines and alt text (EN/DE); `HomeController` asset paths; `docs/image-credits.md` disclaimer.

## Requirements
- [ ] Four factions from base set; document choice in `docs/image-credits.md`.
- [ ] New files under `public/images/landing/` with stable names; remove prior carousel PNGs.
- [ ] EN/DE `landing_slide_*` title/tagline/alt aligned to each faction.
- [ ] `HomeLandingTest` asserts first slide filename.
- [ ] `CHANGELOG` [Unreleased].

## Testing
- `php artisan test`; manual `/` carousel.

## Notes
- *Smash Up* and faction themes are trademarks/IP of their owners; artwork must remain **original fan illustration**, not reproductions of published cards.
