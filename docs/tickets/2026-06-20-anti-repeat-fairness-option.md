## Anti-repeat / Fairness Option (History-based)

## Summary
Add an opt-in "Avoid recently played factions" toggle to the shuffle wizard (and quick shuffle) that excludes faction names already seen in the user's recent play history from the eligible pool, reducing repetition across consecutive games.

## Background / Context

- **Current behavior:** Every shuffle draws from the full eligible pool (optionally constrained by collection/include/exclude), with no memory of past results. Repeat factions appear frequently when the pool is small.
- **Domain context:** Only logged-in users have `shuffle_histories`. Guests will see the UI hint but the option is effectively a no-op (no history to exclude from).
- **Pattern to mirror:** `ShuffleDeckPool::eligibleDecks` already filters by collection ownership and include/exclude lists — anti-repeat fits as a third filter layer using the same service.
- **History data:** `shuffle_histories.results` stores faction **names** as nested JSON — directly usable for `whereNotIn('name', ...)` on `Deck`.

**User story:** As a logged-in player, I want the randomizer to avoid factions I've played recently, so each session feels fresh.

## Requirements

- [ ] Wizard shows an "Avoid recently played" checkbox (step 1 or below player-count radios); visible to all, greyed-out / tooltip for guests
- [ ] `ShuffleDeckPool` gains a method to resolve recently-played faction names from history (last N shuffles, window configurable via `config/shuffle.php` or default constant)
- [ ] `POST /shuffle/result` and `GET /random` respect the flag when provided (auth users only; guests: ignore silently)
- [ ] **Soft fallback:** if anti-repeat exclusion shrinks the pool below the required minimum, retry without anti-repeat and surface a flash message / UI note explaining the fallback
- [ ] Quick shuffle (`/random`) applies anti-repeat automatically for logged-in users without a UI toggle (always-on since there is no wizard)
- [ ] EN + DE lang keys for all new visible strings
- [ ] No DB migration (feature is per-shuffle toggle, not a stored preference)

## Technical notes

- **Affected areas:** `app/Services/ShuffleDeckPool.php`, `app/Http/Controllers/DeckController.php`, `resources/views/start/home.blade.php`, `resources/lang/en/`, `resources/lang/de/`, `config/shuffle.php` (new or existing config file for window constant)
- **Approach:** add `recentFactionNames(?User $user, int $window): array` to `ShuffleDeckPool`; update `eligibleDecks` signature or add a thin wrapper; both controller endpoints pass the flag
- **Plan mode:** skipped — no migration, no new route, no new dependency, no arch fork; mirrors exact `ShuffleDeckPool` collection-filter pattern
- **Window default:** 5 most recent shuffle history rows (covers ~10–20 factions) — configurable via `config('shuffle.anti_repeat_window', 5)`
- **Edge case — small pools:** use a two-pass approach: attempt with anti-repeat; if `count($pool) < $players * 2`, fall back to full pool + flash warning `shuffle_anti_repeat_fallback`

## Testing

- **PHPUnit Feature:** `tests/Feature/Shuffle/AntiRepeatTest.php` (new):
  - Logged-in user with history: anti-repeat excludes recent names from drawn factions
  - Logged-in user, pool too small after exclusion: fallback to full pool, flash message present
  - Guest: anti-repeat flag ignored, shuffle proceeds normally
  - Empty history: anti-repeat no-op, same as normal shuffle
  - Quick shuffle (GET /random) with history: recent factions excluded
- **Manual / browser:** wizard checkbox visible, greyed for guest; successful shuffle with and without checked; fallback flash on tiny pool

## Impact / Risks

- **Performance:** history query is at most `config('shuffle.anti_repeat_window')` rows — negligible
- **Regression:** soft fallback ensures existing pool-too-small error path is not duplicated; existing tests stay green
- **Guests:** feature is auth-scoped; no change to guest shuffle behavior
- **Presets:** presets do not store anti-repeat flag — that is a separate backlog item if needed
