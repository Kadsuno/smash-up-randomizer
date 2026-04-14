## Optimize Cursor implementation workflow rule

## Summary
Refactor `smash-up-full-workflow.mdc` to reduce unnecessary friction for small changes while keeping full governance for non-trivial work. Introduces a two-tier system, cleaner phase numbering, and sharper criteria throughout.

## Background / Context
- Current behavior: every code change — from a typo fix to a new feature — triggers the identical 13-phase workflow including mandatory ticket, Plan mode, and roadmap scan.
- This creates real friction for small bug fixes and makes the rule feel heavy, leading to implicit skipping rather than explicit opt-out.
- No external designs or prior tickets; improvements identified via workflow review session.

## Requirements
- [x] Introduce explicit Quick Track (≤ 3 files, no migration, no UX impact) skipping ticket + Plan mode
- [x] Define concrete Plan mode trigger criteria (new route/controller, migration, > 5 files, new dependency)
- [x] Remove Phase 5 (DDEV) as standalone phase; inline DDEV note into Phase 6
- [x] Renumber phases cleanly: 6/6b/6c → sequential integers
- [x] Conditionalise roadmap scan: only for features and roadmap-adjacent chores; auto N/A for bugfixes
- [x] Shorten "Violations — NEVER" section (remove pure duplicates)
- [x] Make opt-out examples bilingual (EN + DE)

## Technical notes
- Affected file: `.cursor/rules/smash-up-full-workflow.mdc`
- No code changes; no migration; no lang files.

## Testing
- **Manual:** trigger a Quick Track change and verify AI follows lightweight path; trigger a full feature and verify all gates still apply.

## Impact / Risks
- AI behaviour governed by this rule changes immediately on merge to `dev`.
- Rollback: revert the file; no side effects.
