# Harden GitHub repository configuration

## Summary
Extend the existing CI/CD and repository configuration to enforce branch protection,
surface security issues faster, reduce Dependabot noise, and automate releases.

## Background / Context
- Current CI is a single sequential job; no branch protection on `master`; no PR template
- `npm audit` is missing from CI (only `composer audit` runs)
- Dependabot opens individual PRs per package (high noise)
- No release automation when `master` is tagged
- Codecov is integrated but no coverage threshold enforcement

## Requirements
- [ ] Branch protection on `master`: require PR + CI pass + no force push
- [ ] Add `npm audit --audit-level=high` to CI after `npm ci`
- [ ] PR template at `.github/pull_request_template.md` (Roadmap + Public copy sections)
- [ ] Dependabot grouped updates for `laravel/*`, `symfony/*`, and npm devDependencies
- [ ] Release workflow: on `v*.*.*` tag, create GitHub Release from CHANGELOG
- [ ] Split CI into parallel `lint` and `test` jobs for faster feedback
- [ ] `.codecov.yml` with coverage threshold (fail PR if coverage drops >2%)

## Technical notes
- Plan: skipped — no migration, route, >8 files, dependency, or arch fork
- Affected: `.github/workflows/ci.yml`, `.github/dependabot.yml`, new `.github/workflows/release.yml`, new `.github/pull_request_template.md`, new `.codecov.yml`
- Branch protection via `gh api repos/{owner}/{repo}/branches/master/protection`
- CI parallelization: `lint` job (Pint + composer audit) runs in parallel with `test` job; PHP tests still depend on Vite build so `test` job remains sequential internally

## Testing
- **CI:** Push branch, verify two parallel jobs appear in GitHub Actions
- **Manual:** Open a draft PR and verify the PR template loads

## Impact / Risks
- Branch protection blocks direct pushes to `master` — intended
- Coverage threshold may initially fail if current coverage is below the floor; check before setting the threshold
- `npm audit` may surface existing advisories — `--audit-level=high` limits to high/critical only
