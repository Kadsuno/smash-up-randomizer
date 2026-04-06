## Title
Add Cursor full development workflow and ticket authoring rules

## Summary
Introduces an Aura-style, repo-specific workflow (analyze → ticket → branch → DDEV → implement → tests → docs → PR → merge) plus structured English tickets and a starter `docs/roadmap.md`. Restores superseded pointer rules where legacy files were removed on `dev`.

## Background / Context
- **User story:** As a maintainer, I want consistent AI-assisted development steps so changes stay traceable, tested, and aligned with roadmap and bilingual copy.
- Prior work lived on another branch with partial overlap; this ticket ships the workflow files from a clean `chore/` branch off `dev`.

## Requirements
- [ ] `.cursor/rules/smash-up-full-workflow.mdc` documents phases and Smash Up stack (Laravel, Blade, Vite, DDEV, PHPUnit, EN/DE lang, CHANGELOG vs roadmap).
- [ ] `.cursor/rules/ticket-authoring.mdc` defines ticket Markdown structure and `docs/tickets/` naming.
- [ ] `docs/roadmap.md` exists as a scannable roadmap stub.
- [ ] Legacy `create-ticket.mdc` / `implementation-rules.mdc` either removed or replaced by pointers — here: **pointers restored** so old references still resolve.
- [ ] **IssueForge:** N/A (not configured in this repository).

## Technical notes (optional)
- Optional IssueForge POST skipped — no `ISSUE_FORGE_*` in project env.

## Testing
- **PHPUnit:** Run full suite — docs-only + rule files should leave tests green.
- **Manual:** N/A.

## Impact / Risks
- Low risk; developer workflow and Cursor behavior only.
