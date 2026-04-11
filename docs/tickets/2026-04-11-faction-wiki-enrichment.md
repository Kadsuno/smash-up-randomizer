## Enrich faction JSON data from the Smash Up Wiki via MediaWiki API

## Summary

Add a `php artisan factions:enrich` command that fetches the full wikitext for each faction from smashup.fandom.com, parses it into structured fields, writes the result back into the versioned JSON files in `database/data/factions/`, and triggers `factions:import` to sync the database. This fills the ~13 currently empty fields (`description`, `characters`, `actions`, `synergy`, `tips`, etc.) with real content sourced from the community wiki.

## Background / Context

- Current state: the 22 JSON files seeded in [2026-04-11-faction-data-seeding-pipeline.md](2026-04-11-faction-data-seeding-pipeline.md) contain only `name`, `expansion`, `teaser`, `mechanics`, and `playstyle`. All other `Deck` model fields are empty strings.
- The Smash Up Fandom Wiki (smashup.fandom.com) provides a MediaWiki API at `https://smashup.fandom.com/api.php`. One request per faction retrieves the full wikitext, which contains structured sections (Cards, Minions, Actions, Bases, Clarifications, Mechanics, Strategy, Synergy).
- The wiki wikitext uses `[[links]]`, `{{templates}}`, `'''bold'''`, heading markers, and external link syntax that must be stripped before storing as plain text.

## Requirements

- [ ] `app/Services/WikitextParser` parses a raw wikitext string into a keyed array matching `Deck` fillable fields.
- [ ] `factions:enrich` command reads all 106 faction names from the JSON files, fetches each wiki page, merges parsed fields into the JSON, writes the file, and respects a 300 ms delay between requests.
- [ ] Fields with empty wiki output are **not** overwritten (existing data is kept).
- [ ] `--faction=Name` option restricts the run to a single faction (useful for testing and re-runs).
- [ ] `--skip-import` option writes JSON only, does not trigger `factions:import`.
- [ ] `--dry-run` option prints the parsed fields to console without writing files or DB.
- [ ] Rate-limit protection: exponential backoff (up to 3 retries) on HTTP 429 / timeout.
- [ ] URL encoding handled correctly for faction names containing dots (`S.H.I.E.L.D.`), apostrophes (`Grimms' Fairy Tales`), etc.
- [ ] The command exits with `Command::FAILURE` and a clear message if the wiki returns a "missing" page.

## Technical notes

- **Affected areas:** `app/Services/`, `app/Console/Commands/`, `database/data/factions/*.json`
- Use Laravel's `Http` facade (`Illuminate\Support\Facades\Http`) for HTTP requests — already available.
- `WikitextParser` has no framework dependency (pure PHP, instantiable in PHPUnit without booting Laravel) to keep unit tests fast.
- Section mapping:
  | Wiki section header | Target field(s) |
  |---|---|
  | Intro (section 0) | `description` |
  | `== Cards ==` intro text | `cardsTeaser` |
  | `=== Minions ===` | `characters` |
  | `=== Actions ===` intro line | `actionTeaser` |
  | `=== Actions ===` card list | `actionList`, `actions` |
  | `=== Bases ===` | `bases` |
  | `== Clarifications ==` | `clarifications` |
  | `== Mechanics ==` intro | `effects` |
  | `=== Strategy ===` | `tips` |
  | `=== Synergy ===` | `synergy`; first sentence → `suggestionTeaser` |
- `image` field: **not** populated by this command (managed separately).
- FAQ, Trivia, "In other languages" sections: ignored.

## Testing

- **PHPUnit Unit (`WikitextParserTest`):** use a hardcoded Aliens wikitext fixture; assert correct extraction of each field; assert markup is stripped cleanly.
- **PHPUnit Feature (`EnrichFactionsCommandTest`):** mock `Http` facade; assert command exits 0, JSON files are updated, `--dry-run` writes nothing, `--faction` limits scope.
- **Manual:** `ddev exec php artisan factions:enrich --faction=Aliens` → inspect JSON + DB row.

## Impact / Risks

- **Network dependency:** command requires internet access; CI should mock or skip live calls.
- **Wiki structure variance:** older factions may have different section names or missing sections — handled by returning empty string and skipping overwrite.
- **Rate limiting by Fandom:** 300 ms delay between requests + retry logic mitigates this.
- **Rollback:** JSON files are in git; reverting the enrichment is a `git checkout` away.
