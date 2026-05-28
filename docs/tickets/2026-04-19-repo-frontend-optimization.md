## Title
Trim unused frontend dependencies and CSS imports; tighten Vite production build settings.

## Summary
Remove npm packages and CSS that are not referenced by the Vite entrypoints or first-party views, update documentation to match, and apply safe Vite `build` defaults to speed CI/production builds. Reduces install size and shipped CSS without changing user-visible behavior.

## Background / Context
- `package.json` lists **jQuery** and **lodash** with no imports in `resources/js` or Blade.
- **`animate.css`** is imported in `resources/css/app.css` but `docs/design-system.md` already notes no `animate__*` usage in first-party views.
- **Font Awesome** remains required (classes used across Blade).

## Requirements
- [ ] Remove unused npm dependencies (`jquery`, `lodash` if confirmed unused, `animate.css`) and regenerate lockfile.
- [ ] Remove `@import 'animate.css'` from `resources/css/app.css`.
- [ ] Adjust `vite.config.js` with safe production build options (no new npm plugins).
- [ ] Update `README.md` stack line, `docs/design-system.md` motion/residual sections, and `CHANGELOG.md` `[Unreleased]` for this internal chore.
- [ ] `ddev npm run build` succeeds; `ddev exec php artisan test` passes (no PHP logic change expected).

## Technical notes
- Affected paths: `package.json`, `package-lock.json`, `resources/css/app.css`, `vite.config.js`, `README.md`, `docs/design-system.md`, `CHANGELOG.md`, `.cursor/rules/smash-up-full-workflow-detail.mdc`.
- Do not add new npm dependencies; rely on Vite built-in `build` options only.
- Public copy: N/A (no new user-facing strings). Roadmap: N/A (chore not tied to Now/Next).

## Testing
- **PHPUnit:** `ddev exec php artisan test` — full suite; expect green with no test edits.
- **Manual:** `ddev npm run build`; spot-check home page if time permits (optional — no UI change intended).

## Impact / Risks
- **Low:** Smaller CSS bundle; if any forgotten `animate__*` reference existed, animation would disappear — grep confirms none in `resources/views`.
- Rollback: restore previous `package.json` / lock / `app.css` import.

## Plan
Plan: skipped — no migration, new route, controller, or added dependency; dependency removal and docs follow existing chore patterns (see `CHANGELOG` axios removal).
