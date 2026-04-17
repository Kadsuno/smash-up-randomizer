## Add Expansions pages, complexity filter, and /random quick-shuffle

## Summary
Three connected UX improvements that make the app more useful for returning players: a dedicated Expansions section for browsing factions by set, a client-side complexity filter on the Faction list, and a one-click `/random` endpoint that skips the shuffle wizard entirely.

## Background / Context
- Current state: all 106 factions are listed on a single flat `/factions` page with name search only. There is no way to browse by expansion set, filter by difficulty, or get a quick random shuffle without going through the 3-step wizard.
- User story: As a player who only owns certain sets, I want to quickly see which factions belong to each expansion — and as a new player I want to filter by difficulty.
- Related: faction data pipeline (shipped) already provides `expansion` and `playstyle` fields for all 106 factions.

## Requirements
- [ ] `GET /expansions` — grid of expansion cards showing name, faction count, and up to 4 faction thumbnails
- [ ] `GET /expansions/{slug}` — faction grid scoped to that expansion; 404 for unknown slugs
- [ ] Complexity filter pills (All / Easy / Medium / Hard) on `/factions` — client-side Alpine, no page reload
- [ ] `GET /random` — immediately shuffles 2 players using all factions, renders existing result view
- [ ] Expansions linked from footer Quick Links and from `/factions` hero
- [ ] All new strings in `resources/lang/en/frontend.php`
- [ ] Sitemap updated to include `/expansions` and each expansion slug URL

## Technical notes
- Affected areas: `app/Http/Controllers/DeckController.php`, `routes/web.php`, `resources/views/expansions/`, `resources/views/decks/list.blade.php`, `resources/views/components/layouts/footer.blade.php`, `resources/lang/en/frontend.php`
- Slug → expansion: `Str::slug($expansion)` for URL generation; reverse lookup via iterating unique expansion names
- Complexity filter: purely Alpine (`x-show` + `data-playstyle` attribute); no controller change
- Reuse existing faction card markup from `decks/list.blade.php` for consistency

## Testing
- **PHPUnit Feature:** `ExpansionsControllerTest` (index 200, detail 200, 404 for bad slug), `QuickShuffleTest` (200, result view rendered)
- **Manual/browser:** visit `/expansions`, click into a set, use filter pills on `/factions`, visit `/random`

## Impact / Risks
- No DB migrations; pure read-only queries
- `DeckController` grows to ~290 lines — within soft limit
- Rollback: revert 3 routes + 3 controller methods; no data affected
