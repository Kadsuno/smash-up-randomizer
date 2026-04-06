## Title
Upgrade to Tailwind CSS v4 (`@tailwindcss/vite`) and DDEV Node 22

## Summary
Tailwind v4 requires Node.js 20+ for `@tailwindcss/oxide`. The project moves from Tailwind v3 + `tailwind.config.js` to v4 with CSS-first `@import "tailwindcss"`, `@theme` tokens, and the Vite plugin. DDEV `nodejs_version` is raised to 22 so `ddev exec npm run build` works reliably.

## Requirements
- [ ] `package.json` lists `tailwindcss` ^4 and `@tailwindcss/vite`; `engines.node` is `>=20`.
- [ ] `vite.config.js` registers `tailwindcss()` from `@tailwindcss/vite` before the Laravel plugin.
- [ ] `resources/css/app.css` uses `@import "tailwindcss"` (no `@tailwind` directives); `tailwind.config.js` removed.
- [ ] PostCSS runs Autoprefixer only (no Tailwind PostCSS plugin).
- [ ] Gradient utilities updated to v4 names (`bg-linear-to-*`) where used.
- [ ] `.ddev/config.yaml` sets `nodejs_version: "22"`; README documents Node requirement.
- [ ] `npm run build` succeeds inside DDEV after `ddev restart`.

## Testing
- `ddev restart` then `ddev exec npm ci` / `npm install` and `ddev exec npm run build`
- `ddev exec php artisan test`
