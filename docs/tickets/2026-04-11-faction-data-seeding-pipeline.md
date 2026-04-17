## Seed faction data via versioned JSON files and Artisan import command

## Summary

Introduce a systematic, version-controlled way to populate the `decks` table with all known Smash Up factions. JSON data files (one per expansion) serve as the single source of truth; a `DeckSeeder` and a new `factions:import` Artisan command both consume them idempotently via `updateOrCreate`.

## Background / Context

- Currently the `decks` table is empty on a fresh install; the only write path is the admin CSV importer, which only sets `name` and no other fields.
- No faction data is committed to the repository — every environment starts blank.
- The Smash Up Wiki (smashup.fandom.com) provides overview text, complexity, and expansion grouping for all 106 factions, making it possible to pre-populate at least `name`, `expansion`, `teaser`, `mechanics`, and `playstyle` for every faction.
- **User story:** As a developer setting up a fresh environment, I want to run `php artisan db:seed` (or `php artisan factions:import`) and immediately have all known factions available.

## Requirements

- [ ] `database/data/factions/` directory contains one JSON file per official expansion/set, each holding an array of faction objects.
- [ ] Each JSON object maps to `Deck` fillable fields; unknown/unpopulated fields default to empty string.
- [ ] `DeckSeeder` reads all JSON files and calls `Deck::updateOrCreate(['name' => ...], [...])` — safe to re-run without duplicating rows.
- [ ] `php artisan factions:import` Artisan command replicates the same idempotent import (useful for production re-sync without a full seed).
- [ ] `DatabaseSeeder` calls `DeckSeeder`.
- [ ] All 106 factions (as listed on the Smash Up Wiki at time of writing) are included across the JSON files.
- [ ] `docs/roadmap.md` updated to reflect this foundational data work.
- [ ] `CHANGELOG.md` updated under `[Unreleased]`.

## Technical notes

- **Affected areas:** `database/data/`, `database/seeders/DeckSeeder.php`, `database/seeders/DatabaseSeeder.php`, `app/Console/Commands/ImportFactions.php`
- JSON filenames: kebab-case of expansion name, e.g. `core-set.json`, `awesome-level-9000.json`
- Seeder uses `Deck::updateOrCreate(['name' => $faction['name']], $faction)` — idempotent on `name`
- Artisan command: `php artisan factions:import` — prints progress with `$this->info()`
- No migrations needed; all columns already exist
- No frontend or language file changes needed

## Testing

- **PHPUnit Unit:** `DeckSeeder` imports all JSON fixtures into a fresh in-memory / test DB; assert correct count and field values for a sample faction per expansion
- **PHPUnit Feature:** `factions:import` command exits 0, outputs success message, and `Deck::count()` matches expected number; re-running does not duplicate rows
- **Manual:** `ddev exec php artisan factions:import` on a fresh DB → all 106 factions present

## Impact / Risks

- **Low risk:** purely additive; no schema change, no UI change
- Re-running seeder on a live DB with existing rows: `updateOrCreate` on `name` means existing content is overwritten with seed data for matching names — acceptable since seed data only fills fields that are empty by default
- If a faction name changes in a future expansion release, the JSON file must be updated and the import re-run
