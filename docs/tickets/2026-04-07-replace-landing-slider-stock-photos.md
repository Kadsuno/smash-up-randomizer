## Title
Replace landing hero slider images with licensed stock photography

## Summary
The home carousel currently references PNG paths that may be missing or unsuitable. We will ship four **local JPEGs** from **Pexels** (free-use license), chosen to match game-night / cards / social / phone themes, update **alt text** so it describes the photos honestly (no implied official Smash Up artwork), and document **attribution** in-repo.

## Background / Context
- **Current behavior:** `HomeController` uses `images/smashup_hero.png`, `smashup_1.png`, `smashup_2.png`, `result.png`; alt strings mention “Smash Up style” / “faction artwork,” which is misleading for third-party photos.
- **Constraint:** No copyrighted game art; use only sources we may redistribute (Pexels License).

## Requirements
- [ ] Store four carousel images under `public/images/landing/` with stable filenames.
- [ ] Point `HomeController` `$landingSlides` `src` values at those files.
- [ ] Update EN/DE `landing_slide_*_alt` strings to accurate, neutral descriptions of each photo.
- [ ] Add `docs/image-credits.md` listing source URL, photographer, and license link; link from `README.md` (repository layout or short “Assets” note).
- [ ] Update `CHANGELOG.md` under `[Unreleased]`.
- [ ] Adjust `docs/roadmap.md` only if the shipped row should mention stock imagery (optional one-line).

## Technical notes (optional)
- Affected: `app/Http/Controllers/HomeController.php`, `lang/en/frontend.php`, `lang/de/frontend.php`, `resources/lang/en/frontend.php`, `docs/image-credits.md`, `README.md`.

## Testing
- **PHPUnit:** `tests/Feature/HomeLandingTest` still passes; optionally assert one new asset filename appears in HTML.
- **Manual:** Load `/`, confirm carousel shows four distinct photos and no broken images.

## Impact / Risks
- **Repo size:** +~1 MB JPEGs; acceptable for marketing assets.
- **Rollback:** Revert commit; restore previous `asset()` paths if needed.
