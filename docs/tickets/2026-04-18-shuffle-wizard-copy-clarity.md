## Title
Clarify shuffle wizard include/exclude copy and align landing with faction-level filtering

## Summary
Users reported confusion about optional include/exclude steps and expected set-level toggles in the shuffle dialog. This ticket adds explicit helper text in the wizard and tightens marketing copy so it matches actual behavior (factions in the modal; expansions via account collection or `/expansions`).

## Background / Context
- **Current behavior:** Empty `includeFactions` means the full eligible pool (`ShuffleDeckPool`); exclude removes factions from that pool. The landing carousel and “How it works” step still emphasize “filter sets,” which oversells set toggles inside the wizard.
- **Feedback:** Mobile user thought exclude was redundant if include exists; unclear that leaving include unchecked = all factions.

## Requirements
- [ ] Shuffle wizard step 2 shows short helper copy: unchecked include = all eligible factions; checked = narrowed pool; mention logged-in collection constraint where relevant.
- [ ] Shuffle wizard step 3 shows short helper copy: exclude is optional and useful to drop a few factions without selecting many on step 2.
- [ ] Bilingual EN/DE strings in canonical lang files; keep duplicate `lang/` tree in sync if present.
- [ ] Landing carousel slide 2 + “How it works” step 2 + meta description no longer imply a set-toggle inside the shuffle dialog; account collection path referenced where appropriate.

## Technical notes (optional)
- Files: `resources/views/start/home.blade.php`, `resources/lang/{en,de}/frontend.php`, `lang/{en,de}/frontend.php`, `CHANGELOG.md`.
- No controller or pool logic changes.

## Testing
- **PHPUnit:** `ddev exec php artisan test` — existing `HomeLandingTest` should still pass (assertions use translation keys).
- **Manual:** Open home → Shuffle → step 2/3; switch locale EN/DE if applicable.

## Impact / Risks
- Low risk: copy-only. Ensure string length fits mobile modal layout.
