## Title
Modernize public site header and footer

## Summary
Redesign the guest layout header and footer for a contemporary SaaS-style shell: pill navigation with route-aware active states, scroll-based header elevation, an improved mobile menu with primary CTA, and a structured footer (brand, explore, legal, social) with bilingual strings and a copyright row.

## Background / Context
- Previous header used flat `sur-link-nav` links and a basic mobile dropdown; nav labels were English-only in the Blade file.
- Footer mixed a tagline with three columns; legal links sat under “Quick links” without clear information architecture.

## Requirements
- [x] Desktop: pill-style nav inside a frosted container, primary **Shuffle** CTA to `home`, active states for `factionList`/`factionDetail`, `about`, `contact`.
- [x] Mobile: absolute full-width panel under the bar, large touch targets, shuffle CTA at the bottom.
- [x] Header scroll shadow via Alpine (`sur-site-header--scrolled`).
- [x] Footer: four sections (brand, explore, legal, connect) + bottom bar; cookie settings shortcut when Matomo is enabled.
- [x] All new user-visible strings in `lang/en`, `lang/de`, and `resources/lang/en/frontend.php`.
- [x] Main content `padding-top` adjusted for the taller header.
- [x] `CHANGELOG`, `docs/roadmap.md`, tests + production build.

## Technical notes
- New component: `resources/views/components/site-nav-link.blade.php` (`routeName`, optional `routes` array, `label`, `mobile`).
- New/updated `sur-*` classes in `resources/css/app.css` (`sur-site-header`, nav pills, mobile links, `sur-site-footer`, `sur-footer-link`, `sur-social-btn`).
- Fourth `sur-footer-col` stagger delay added.

## Testing
- `php artisan test` — all passing.
- Manual: locale EN/DE; routes home, factions list/detail, about, contact, legal pages; Matomo on/off for cookie link; mobile menu.

## Impact / Risks
- Visual layout shift due to increased main top padding; minor risk on pages with `pt-*` overrides — spot-check faction detail scroll layout.
