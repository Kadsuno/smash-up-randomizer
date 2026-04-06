# Landing page imagery

## Hero carousel (home `/`)

The four slides under `public/images/landing/slide-0*-ai-*.png` are **AI-generated artwork** created with **Cursor’s image generation** (prompted for generic board-game / card-night / smartphone themes). They are **not** official *Smash Up* product art and intentionally avoid logos, readable text, and franchise-specific depictions.

| File | Theme (prompt intent) |
| ---- | --------------------- |
| `slide-01-ai-game-night.png` | Cozy evening table, generic game pieces and cards, moody lighting |
| `slide-02-ai-cards-table.png` | Top-down cards on wood, warm light |
| `slide-03-ai-friends-cards.png` | Friends around a table, casual card game |
| `slide-04-ai-smartphone.png` | Phone glow suggesting an app; background out of focus |

**Regeneration:** Replace the PNGs in `public/images/landing/` and keep filenames in sync with `app/Http/Controllers/HomeController.php` and `tests/Feature/HomeLandingTest.php`.

**Note:** Files are full-resolution PNGs; consider WebP or stronger compression in a follow-up if LCP budgets require it.
