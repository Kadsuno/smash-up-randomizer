## Title
Modernize home page Shuffle modal (wizard UI)

## Summary
Refresh the `<dialog id="shuffle-modal">` on the landing page: clearer stepper, sticky footer with **primary action on the right**, improved spacing and glass/ring styling, optional **player count as radio tiles** instead of a plain select, and **bilingual** strings for all wizard copy (replace hardcoded English).

## Requirements
- [ ] Visual refresh: border/ring, radius, header, backdrop-consistent footer.
- [ ] Step indicator: numbered steps with current/complete states (accessible).
- [ ] Footer navigation: Previous (left), Next / Submit Shuffle (right); hidden state per step.
- [ ] EN/DE `frontend.*` keys for step labels, headings, buttons, placeholder text.
- [ ] JS: central footer buttons; validate player count before step 2; reset step UI when modal opens.
- [ ] `CHANGELOG` [Unreleased]; feature test asserts translated wizard string.

## Testing
- PHPUnit: home renders new shuffle copy.
- Manual: open modal, step through 1→2→3, Previous works; submit posts to shuffle result.

## Impact / Risks
- Low risk; same form fields and route.
