## Title
Modernize Blade layout structure, reusable UI components, and motion

## Summary
Introduce consistent page structure (`sur-*` layout components), semantic `<main>` with skip link, footer stagger, and accessible motion (scroll-reveal via `@alpinejs/intersect`, staggered entrances; `prefers-reduced-motion` respected via existing global rules). Refactor public and backend guest views to use shared primitives and reduce reliance on animate.css for primary layout.

## Background / Context
- **Current state:** Pages mixed ad hoc wrappers (`max-w-7xl`, heroes), many `animate__*` classes, and inline page `<style>` blocks (e.g. shuffle wizard, faction list).
- **Goal:** One predictable structure aligned with the indigo/zinc Tailwind design system, with subtle motion and less duplication.

## Requirements
- [x] Shared Blade components: **container**, **section**, **hero**, **panel** (glass), **reveal** (scroll-in), **page-heading**.
- [x] **Main layout:** `id="main-content"`, flex column shell with `sur-main`, skip link to main content (EN/DE string).
- [x] **Motion:** `x-intersect.once` + `.sur-reveal` / `.sur-reveal--in`; footer columns use CSS stagger; no infinite pulse on primary CTAs (replaced with hover/active scale).
- [x] Refactor public pages: home, contact, about, imprint, privacy, faction list, shuffle results, login; backend dashboard and decks manager.
- [x] **Alpine:** `@alpinejs/intersect` registered; `alpinejs` bumped to 3.15.x for compatibility.
- [x] Production `npm run build` and PHPUnit green.

## Technical notes
- **Files:** `resources/views/components/sur/*`, `resources/views/components/layouts/{main,header,footer}.blade.php`, listed feature views, `resources/js/app.js`, `resources/css/app.css`, `lang/*/frontend.php`, `resources/lang/en/frontend.php`.
- **Faction detail** (`decks/detail.blade.php`): kept existing scroll-snap + IntersectionObserver (separate motion model); not wrapped in `x-sur.reveal` to avoid double animation.
- **Shuffle wizard:** Step classes renamed to `shuffle-step-content`, `shuffle-step-label`, `shuffle-progress-bar`; styles moved to `app.css`.

## Testing
- **PHPUnit:** `php artisan test` — all passing.
- **Manual:** Home hero + modal steps, contact form, legal pages, faction list, shuffle results, login, backend dashboard and decks manager; tab to skip link; EN/DE if switching locale.

## Impact / Risks
- **Low:** Visual timing changes; animate.css still imported for any remaining utilities.
- **Rollback:** Revert branch; restore previous Blade files from git.
