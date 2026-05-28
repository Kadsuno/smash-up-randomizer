## Title
Clarify landing demo carousel, validate shuffle include/exclude pool, improve faction detail readability

## Summary
Address user feedback: the hero carousel should read clearly as a non-interactive preview; the shuffle wizard should warn when include/exclude selections leave no (or too few) factions; faction detail pages should render long HTML copy with more breathing room.

## Background / Context
- **User story:** Players confused the marketing carousel with the real shuffle UI; toggling “all” on both include and exclude felt like “nothing happens”; faction prose felt cramped.
- **Approach:** Mirror existing Blade/JS patterns in `home.blade.php`; extend `DeckController::shuffle` validation with clearer errors; tighten `.deck-html` typography in `decks/detail.blade.php`.

## Requirements
- [ ] Landing hero carousel shows an explicit **preview-only** cue (copy + semantics) so users know chips are illustrative.
- [ ] Shuffle wizard: client-side validation with an in-modal **toast** when the eligible pool is empty or smaller than `players × 2`; optional warning after **Toggle all** when the pool becomes empty.
- [ ] Server: distinct flash messages for **include fully covered by exclude** vs **empty pool** (e.g. excluded everything), before the generic “not enough factions” case.
- [ ] Faction detail: improved spacing/line-height for `.deck-html` (description, characters, etc.) without breaking existing HTML content.

## Technical notes
- `resources/views/start/home.blade.php`, `resources/lang/en|de/frontend.php`, `app/Http/Controllers/DeckController.php`
- `resources/views/decks/detail.blade.php` (scoped CSS)
- Feature tests for new redirect/session messages

## Testing
- **PHPUnit:** `POST /shuffle/result` with conflicting include/exclude; empty pool; assert session error keys/messages.
- **Manual:** Landing demo banner visible EN/DE; open shuffle modal, trigger toast; faction detail long text readable.

## Impact / Risks
- Low risk: copy and validation only; no migrations.
