## Add subtle atmosphere images to landing testimonials and CTA sections

## Summary

Two free Unsplash photos are added as very-low-opacity background textures to break up the all-dark monotone of the landing page and add warmth without disrupting the existing dark aesthetic.

## Images

| File | Unsplash ID | Author | Section |
|---|---|---|---|
| `public/images/landing/game-night-social.jpg` | `rqcKBlxh-Kk` | Maximo Lopez | Testimonials/Voices section |
| `public/images/landing/cards-dark-surface.jpg` | `c-XQQ7ijYaI` | Phạm Mạnh | CTA band |

Both are free under the [Unsplash License](https://unsplash.com/license).

## Changes

- Testimonials section: added `relative overflow-hidden` + `<img>` with `opacity-[0.07] mix-blend-luminosity`
- CTA band: added `<img>` as first child (before gradient divs) with `opacity-20 mix-blend-luminosity`
- Both images are `aria-hidden="true"` with empty `alt` (decorative)
- Both use `loading="lazy"` and explicit `width`/`height`

## Testing

- PHPUnit: 19/19 passing (no assertions reference these images; they are decorative)
- Browser: verified both sections visually — images render subtly without affecting text readability
