## Title
Align cookie consent UI with site design system and Cookiebot-like UX

## Summary
Restyle the cookie consent UI to match the dark Smash Up frontend (typography, accent color, surfaces) and adopt a Cookiebot-style flow: a fixed bottom consent strip on first visit plus a preference modal for granular choices (necessary vs statistics), without reintroducing third-party CMP scripts.

## Background / Context
- Current banner uses a light modal (`bg-light`) that clashes with `bg-black` / dark navbar patterns.
- Cookiebot typically provides a bottom notice, “accept all”, “necessary only”, and a “customize” path with category toggles.

## Requirements
- [ ] Dark, on-brand styling (consistent with existing header/footer hover accent and Nunito/Bootstrap usage).
- [ ] First visit: show a bottom consent strip (not a blocking full-screen modal by default).
- [ ] Strip actions: reject optional / necessary-only, open detailed settings, accept all (statistics).
- [ ] Modal: category rows (strictly necessary locked on; statistics toggle; marketing row as explicitly unused/disabled if shown).
- [ ] Persist behavior in `localStorage`; optional tiny inline guard to reduce flash for returning users.
- [ ] EN + DE strings for new/updated copy.

## Technical notes
- `resources/sass/components/_cookie-consent.scss` + import from `app.scss`; keep JS in `resources/js/cookie-banner.js`.

## Testing
- PHPUnit: existing Matomo/cookie markup assertions updated if DOM ids change.
- Manual: first visit strip, all buttons, footer reopen, locale DE/EN.

## Impact / Risks
- Visual change only for consent UI; consent storage key unchanged unless migration is required (prefer same key + shape).
