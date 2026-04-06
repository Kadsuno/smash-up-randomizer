## Title
Replace Bootstrap with Tailwind: dark-first UI, mobile-first layout, modern motion

## Summary
Migrate the frontend from Bootstrap 5 + SCSS to Tailwind CSS v4 with a cohesive dark theme, design tokens, and accessible motion. Remove Bootstrap JavaScript in favor of native `<dialog>`, Alpine.js patterns, and lean vanilla JS so cookie consent, navigation, and modals stay functional.

## Background / Context
- **User story:** As a visitor, I want a modern, readable, mobile-friendly dark UI with smooth but restrained animations so the app feels current and trustworthy.
- **Current state:** Bootstrap 5 is imported via `resources/sass/app.scss`; Blade views rely heavily on Bootstrap grid, utilities, components, and `data-bs-*` behavior. Cookie consent and shuffle flow use Bootstrap modals. `cookie-banner.js` imports `Modal` from `bootstrap`.
- **Constraints:** Bilingual EN/DE strings live in Lang files — this change is styling/markup only unless copy must change. GDPR cookie behavior must remain equivalent (localStorage, Matomo load rules).

## Requirements
- [ ] Tailwind CSS is the primary styling layer; Bootstrap and `@import 'bootstrap/scss/bootstrap'` are removed from the build.
- [ ] Dark-first visual design: semantic surfaces (background, elevated panels, borders), readable contrast, accent color aligned with existing brand cyan/teal cues.
- [ ] **Mobile-first:** base styles target small viewports; `sm`/`md`/`lg` breakpoints enhance layout (e.g. horizontal nav on large screens, collapsible nav on small).
- [ ] Motion: subtle transitions (navigation, dialogs, cards); respect `prefers-reduced-motion` where custom animations are added.
- [ ] Cookie consent: bottom bar + settings UI remain functional; preference modal works without Bootstrap JS (e.g. `<dialog>` or Alpine with focus management).
- [ ] Public shuffle modal on the home page works without Bootstrap JS.
- [ ] Backend layout: user dropdown and sidebar behavior work without Bootstrap JS (Alpine/vanilla acceptable).
- [ ] Forms: HTML5 validation still works; invalid states are visibly styled.
- [ ] Pagination (if used) uses a Tailwind-based view consistent with the dark theme.
- [ ] Vite entry uses the new CSS bundle; production `npm run build` succeeds.

## Technical notes
- **Stack:** Vite 5, `@tailwindcss/vite`, `resources/css/app.css`, optional `animate.css` for existing `animate__*` class names.
- **Remove:** `bootstrap`, `@popperjs/core` from npm; drop `resources/sass/app.scss` from Vite (SCSS partials can be deleted or left unused after migration).
- **JS:** Remove `import * as bootstrap from 'bootstrap'` from `resources/js/app.js`; refactor `cookie-banner.js`; update `nav.js` / inline scripts that assume Bootstrap classes.
- **Icons:** Keep Font Awesome as today; avoid introducing new icon sets unless necessary.

## Testing
- **PHPUnit:** Run existing suite; add/adjust tests only if application code changes (expect minimal PHP changes).
- **Manual / browser (DDEV):** Home (shuffle modal steps), cookie bar + customize modal + FAB (with `MATOMO_ENABLED=true`), contact form validation, faction list, backend dashboard + decks manager + login, legal pages; switch EN/DE where routes exist.

## Impact / Risks
- **High visual diff:** Full regression pass on all routes; third-party Passport authorize Blade may still reference old classes if touched.
- **Mitigation:** Keep behavior parity; test cookie consent and Matomo load paths carefully.
