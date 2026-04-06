## Title
Add modern SVG brand logo and wire it in the UI

## Summary
Replace the legacy favicon-as-logo with a dedicated vector mark (indigo/violet, dark card-game motif) and reference it from public headers; add SVG favicon support and point social/meta images to the new asset where appropriate.

## Background / Context
- Nav currently uses `images/favicons/favicon.ico` as the visible logo — low resolution and not on-brand.
- App visual language: dark zinc, indigo/violet accents (`sur-*` design).

## Requirements
- [ ] New logo asset(s) under `public/images/` (SVG mark; optional derived PNGs for legacy favicon sizes).
- [ ] Frontend and backend nav use the new logo with sensible `alt` text (translatable or neutral English).
- [ ] `<link rel="icon">` includes SVG; existing PNG favicons updated or regenerated for consistency.
- [ ] `CHANGELOG` under `[Unreleased]`; `docs/roadmap.md` if product-facing branding is tracked.

## Testing
- Manual: home + backend — logo crisp on retina; browser tab icon; no broken paths.

## Impact / Risks
- Low: static assets only; cache busting via new filenames if needed.
