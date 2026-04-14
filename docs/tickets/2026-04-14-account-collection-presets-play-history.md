## Title
Add faction collection, shuffle presets, and play history for logged-in users

## Summary
Ship the three authenticated features described on the account dashboard: users mark which expansion sets they own (shuffle pool), save named shuffle configurations, and view recent shuffle results. Shuffle and `/random` respect the collection when configured.

## Background / Context
- Roadmap **Next** items: faction collection, shuffle presets, play history.
- Shuffle today uses `DeckController::shuffle` / `quickShuffle` over all factions unless include/exclude are posted.

## Requirements
- [ ] Persist per-user owned expansions; when at least one is saved, constrain shuffle/random pools and home wizard faction lists to those expansions.
- [ ] CRUD shuffle presets (name, player count, include/exclude faction names) with apply-from-home via query param.
- [ ] Store each shuffle result for authenticated users; list recent plays on a history page.
- [ ] Account dashboard shows real counts and links; bilingual EN/DE strings.

## Testing
- PHPUnit: pool filtering, preset ownership, history creation on shuffle.

## Impact / Risks
- New migrations; existing guests unchanged.
