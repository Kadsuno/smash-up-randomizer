## Title
Reconceive shuffle wizard modal (native `<dialog>` option A)

## Summary
Restructure the landing-page shuffle wizard so **header, step badge + stepper, and footer stay fixed** while **only the step body** scrolls. Keep **`/`** and **`shuffle-result`** URLs unchanged; remain on native `<dialog>` with `showModal()`.

## Background / Context
- Prior iterations mixed **wizard chrome** (badge, stepper) inside the same scroll container as long faction grids, which complicated scrolling, focus, and layout.
- **Option A** (product choice): keep `<dialog>`, fix the **flex column chain** (`min-height: 0`, scroll only where needed), reduce reliance on defensive scroll JS where layout is correct.

## Requirements
- [ ] **DOM structure:** Title/close row → **non-scrolling** strip with step badge + stepper → **single scroll region** with step panels only → **non-scrolling** footer (Back / Next / Submit).
- [ ] **URLs:** No new routes; form still posts to existing `shuffle-result` route.
- [ ] **Behavior:** Opening the modal or changing step **scrolls the body region to top** (no stale scroll from previous step).
- [ ] **Bilingual:** Reuse existing `frontend.*` strings; no new copy unless required for structure.
- [ ] **A11y:** Preserve `aria-labelledby` / `aria-describedby`, `closedby="any"` + backdrop click close, keyboard flow.

## Technical notes
- **Files:** `resources/views/start/home.blade.php` (markup + inline script), `resources/css/app.css` (shuffle modal layout utilities).
- **JS:** Simplify focus/scroll mitigations if layout fixes the root cause; keep `dialog` under `document.body`, `close` viewport nudge, submit `disabled` guard, Enter on checkbox suppression.
- **CSS:** Ensure `#shuffle-modal` + `.shuffle-modal-card` + form remain a valid flex chain; `.shuffle-modal-scroll` targets **body** only.

## Testing
- **PHPUnit:** `tests/Feature/HomeLandingTest` (home still renders).
- **Manual:** Open shuffle from `/`, all three steps, long include/exclude list scrolls; footer visible; backdrop dismiss; Chrome + Firefox smoke.

## Impact / Risks
- **Low:** Markup/CSS-only restructure; rollback by reverting Blade/CSS/JS in one PR.
