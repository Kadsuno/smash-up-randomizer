## Title
Rebuild home page as marketing landing (sliders, imagery, CTAs)

## Summary
Replace the minimal hero + two-card layout with a full landing experience: hero with marketing copy and dual CTAs, image carousel (Alpine), feature grid, testimonial-style quote carousel, and closing CTA band — while keeping the shuffle `<dialog>` flow and bilingual EN/DE copy.

## Requirements
- [x] Controller passes structured slide data for the hero carousel.
- [x] At least one image slider + secondary content carousel; autoplay with pause on hover; prev/next + dots; accessible labels.
- [x] Multiple CTAs (shuffle modal, factions list, optional contact); shuffle opener works from all triggers.
- [x] `lang/en`, `lang/de`, `resources/lang/en/frontend.php` strings for all new copy.
- [x] Styles in `app.css` (`sur-landing-*`) where helpful; no fake data in PHP beyond asset paths.
- [x] Tests, `CHANGELOG`, `docs/roadmap.md`.

## Testing
- `php artisan test`
- Manual: home EN/DE, carousel controls, open shuffle from each CTA, mobile layout
