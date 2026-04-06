## Title
Use AI-generated artwork for landing hero carousel slides

## Summary
Replace the current Pexels JPEGs in `public/images/landing/` with **four AI-generated images** (generic board-game / card-night themes, no third-party IP). Update `HomeController` paths, `HomeLandingTest`, and `docs/image-credits.md` to document AI provenance instead of Pexels attribution.

## Background / Context
- **Current:** Slider uses stock photos from Pexels (`docs/image-credits.md` lists photographers).
- **Goal:** User-requested **AI imagery** for a more cohesive marketing look while staying clear of Smash Up trademarked artwork.

## Requirements
- [ ] Four new raster images committed under `public/images/landing/` (PNG or WebP).
- [ ] No depictions of official Smash Up cards, logos, or recognizable franchise art.
- [ ] `HomeController` and tests reference the new filenames.
- [ ] `docs/image-credits.md` describes AI generation (tool/process) and retires Pexels table for these slides.
- [ ] Remove superseded JPEGs from the repo.
- [ ] `CHANGELOG.md` [Unreleased]; roadmap line if it still mentions Pexels-only.

## Testing
- `php artisan test` including `HomeLandingTest`.
- Manual: `/` loads all four slides without 404s.

## Impact / Risks
- Larger PNGs may affect LQIP/LCP — acceptable unless CI or deploy limits complain.
