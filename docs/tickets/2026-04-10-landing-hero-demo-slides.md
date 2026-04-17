## Replace hero carousel artwork slides with product-demo HTML slides

## Summary

The current hero carousel shows four faction artwork images (Pirates, Aliens, Dinosaurs, Zombies). These are visually nice but don't explain what the tool does. Replace with three HTML mockup slides that walk the visitor through the randomizer workflow: player selection → faction filter → assigned result.

## Background / Context

- Current slides: 4 image-based slides using PNGs in `public/images/landing/`; data driven by `$landingSlides` array in `HomeController`.
- Problem: artwork builds no understanding of the product for first-time visitors.
- Goal: every slide should make the visitor think "oh, that's how it works" — converting curiosity into a shuffle click.
- User story: as a first-time visitor I want to see the tool in action before I use it.

## Requirements

- [ ] **Slide 1 — Choose players**: styled mockup of the 2/3/4 player radio tiles from the wizard (one highlighted as selected), title + tagline
- [ ] **Slide 2 — Filter your sets**: horizontally/grid-wrapped faction chips from DB (`$factions`), some visually "checked" some "unchecked"; title + tagline. Graceful fallback if DB empty.
- [ ] **Slide 3 — Your combos**: result mockup showing 2 players each with 2 faction names from `$factions->take(4)`; title + tagline. Graceful fallback if fewer than 4 factions in DB.
- [ ] Remove `$landingSlides` from `HomeController` and from `compact()`; hardcode slide count `3` in the Blade `x-data`
- [ ] Remove unused `landing_slide_{1,2,3,4}_{alt,title,tagline}` lang keys (EN + DE) and add 3 new slide keys
- [ ] Carousel dots/prev/next: update to 3 slides (already driven by Alpine count)
- [ ] Update `HomeLandingTest`: remove PNG assertion, add assertions for new slide content
- [ ] Bilingual EN + DE

## Technical notes

- Affected: `app/Http/Controllers/HomeController.php`, `resources/views/start/home.blade.php`, `lang/en/frontend.php`, `lang/de/frontend.php`, `resources/lang/en/frontend.php`, `tests/Feature/HomeLandingTest.php`
- Slides are pure Blade/Tailwind HTML inside the existing `.sur-landing-carousel` container — no new JS
- Use existing `sur-*` utility classes and faction chip styles; aim for visual consistency with the wizard
- Faction chips for slide 2: `$factions->take(8)` — first 4 visually "included" (indigo), next 4 "excluded" (zinc)
- Result for slide 3: `$factions->take(4)` split into two pairs

## Testing

- **PHPUnit:** update `test_home_page_renders_marketing_landing_copy` — remove `slide-01-faction-pirates.png` assertion, add assertions for new slide 1/3 lang keys; add faction-based assertion for slide 3 when factions exist
- **Manual / browser:** EN on DDEV; check all 3 slides render; check dots/prev/next; check graceful empty-DB fallback

## Impact / Risks

- Removes `$landingSlides` compact var — Blade references must all be updated
- Old `landing_slide_*` lang keys removed — confirm nothing else references them
- PNG files in `public/images/landing/` are no longer used by the carousel (can be cleaned up separately)
