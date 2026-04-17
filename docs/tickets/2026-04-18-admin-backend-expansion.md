## Title
Expand internal admin backend (navigation, CRUD hardening, stats)

## Summary
Grow `/admin/backend` beyond dashboard + faction list: contact inbox, user roles, shuffle analytics, server-side faction filtering/pagination, safe destructive actions, validated CSV import, and dedicated admin controllers.

## Background / Context
- Admins authenticate via `/admin` and use a Blade + Tailwind sidebar (`backendMain`).
- Faction CRUD and CSV import currently live on `DeckController` alongside public routes; delete uses GET.
- Contacts are persisted (`Contact` model) but there is no admin UI to review them.

## Requirements
- [ ] Add admin navigation entries: Contacts, Users, Shuffle stats, Maintenance (CLI reference — no remote execution).
- [ ] Replace dashboard closure with `Admin\DashboardController`; surface aggregate stats (factions, contacts, users, shuffle history) and bilingual copy where the UI already uses `__()`.
- [ ] Move faction admin actions to `Admin\FactionDeckController`; public `DeckController` keeps only guest/user shuffle and faction pages.
- [ ] Faction manager: server-side search, content filter, expansion filter, pagination; keep usable UX at large deck counts.
- [ ] Delete faction via POST/DELETE with CSRF (remove GET delete).
- [ ] CSV import via `UploadedFile` validation and efficient existence checks (no per-row `Deck::all()`).
- [ ] Contacts: paginated list + detail view for admins.
- [ ] Users: list non-admin emails with role toggle; prevent removing the last admin.
- [ ] Shuffle stats: totals, breakdown by player count, recent rows (admin-only).
- [ ] PHPUnit coverage for new/changed admin behavior; PSR-12 + DocBlocks on new PHP.

## Technical notes
- Routes stay under `/admin/backend` with `auth` + `admin` middleware; reuse named routes where tests and views already depend on them (`dashboard`, `decks-manager`, …).
- Optional small service for repeated faction attribute arrays from requests.

## Testing
- Feature tests: admin can access new pages; non-admin forbidden; faction delete method; CSV validation failure; user role guard (last admin); contact list visibility.

## Impact / Risks
- Admin bookmarks to GET delete URLs will break (intentional). Public site unaffected.
