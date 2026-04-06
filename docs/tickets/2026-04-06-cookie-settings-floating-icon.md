## Title
Replace footer cookie-settings text link with a floating cookie icon

## Summary
Move reopening of cookie preferences from the footer list to a fixed, floating control so it matches a common CMP pattern and stays visible without cluttering Quick Links.

## Requirements
- [ ] Remove the cookie-settings entry from the footer link list.
- [ ] Add a fixed-position circular button with a cookie icon and `aria-label` (EN/DE via existing or new lang keys).
- [ ] Style to match the dark theme and accent color; offset when the bottom consent strip is visible (`body.sur-cookie-bar-visible`).

## Testing
- Manual: icon opens modal; position clears the consent bar when shown; keyboard focus visible.
