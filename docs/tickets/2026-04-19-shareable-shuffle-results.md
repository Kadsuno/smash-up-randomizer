## Title
Add shareable shuffle results (permalink and copy as text)

## Summary
Persist each successful shuffle outcome behind an opaque public id and expose a guest-readable permalink. On the result screen, let users copy the link or a plain-text summary for chat apps.

## Background / Context
- **User story:** Groups want to reuse the same faction assignment without re-running the wizard; a stable URL or pasted text works across Discord/WhatsApp.
- **Current behavior:** `DeckController::shuffle` and `quickShuffle` render `shuffle.shuffle-decks` with in-memory `$selectedDecks` only; no public persistence for guests or cross-device sharing.
- **Related:** Roadmap item **Shareable shuffle results**; play history remains separate (no FK in this slice).

## Requirements
- [ ] Every successful `POST /shuffle/result` and `GET /random` persists the assignment in `shared_shuffle_results` (same JSON shape as `shuffle_histories.results`).
- [ ] `GET /shuffle/share/{publicId}` returns 200 and renders the same visual result layout when `publicId` exists; unknown id returns 404.
- [ ] Result page shows actions to copy the permalink and copy a localized plain-text summary (EN/DE).
- [ ] Share permalink responses use `noindex` robots meta (guest-visible thin content).
- [ ] PHPUnit covers create-on-shuffle, show success, show 404, and `/random` persistence.

## Technical notes
- `public_id`: `Str::ulid()`; unique index.
- Thin `SharedShuffleController`; mirror `DeckController` view data for `shuffle.shuffle-decks`.
- Pass `metaRobots` into `x-layouts.main` / header only for the share route.
- Approach: mirror existing shuffle persistence + public read-by-token pattern.

## Testing
- **PHPUnit:** `POST /shuffle/result` with valid player count creates row and response references share URL or id; `GET /shuffle/share/{id}` content; invalid id 404; `GET /random` creates row.
- **Manual:** DDEV — run shuffle, copy link, open in private window; copy text.

## Impact / Risks
- Extra DB row per shuffle (including bots); mitigated by existing app usage patterns; no PII in payload.
- Duplicate `robots` meta if misconfigured — use single header prop for `metaRobots`.
