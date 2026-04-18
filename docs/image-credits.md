# Landing page imagery

## Hero carousel — faction spotlights

The home page hero carousel highlights **four factions from the Smash Up base game** (public faction names: **Pirates**, **Aliens**, **Dinosaurs**, **Zombies** — see [AEG’s Smash Up overview](https://www.alderac.com/smashup/)).

Each slide uses **original AI-generated illustration** (Cursor image generation) themed on that faction’s **concept** (sailing action, alien invasion, prehistoric beasts, undead horde). **These are not Alderac Entertainment Group (AEG) card or box illustrations** and must not be mistaken for official product art. No copyrighted characters from licensed expansions appear by design.

**Trademark:** *Smash Up* and faction themes are trademarks or property of their respective owners. This site is an independent fan randomizer.


| File                             | Faction (base game) | Prompt theme                                 |
| -------------------------------- | ------------------- | -------------------------------------------- |
| `slide-01-faction-pirates.png`   | Pirates             | Galleon, sea battle, Age of Sail adventure   |
| `slide-02-faction-aliens.png`    | Aliens              | Flying saucer, tractor beam, invasion sci‑fi |
| `slide-03-faction-dinosaurs.png` | Dinosaurs           | T. rex, prehistoric jungle                   |
| `slide-04-faction-zombies.png`   | Zombies             | Suburban zombie horde, horror-comedy tone    |


**Regeneration:** Replace PNGs in `public/images/landing/` and keep filenames in sync with `app/Http/Controllers/HomeController.php` and `tests/Feature/HomeLandingTest.php`.

**Note:** Full-size PNGs; consider WebP or compression if performance budgets require it.

## Open Graph / social share (`og-share.png`)

**Path:** `public/images/og-share.png` — **1200×630** PNG used for `og:image` and `twitter:image` (see `resources/views/components/layouts/header.blade.php`).

Purpose: a **dedicated** social preview card (title + tagline + abstract card-stack motif) so Discord, Twitter/X, and similar crawlers get a consistent crop without reusing the old `result.png` asset.

**Regeneration:** Replace the PNG and bump dimensions in the layout only if the aspect ratio changes from 1.91∶1 (1200×630). After replacing the file, increment **`OG_SHARE_VERSION`** in `.env` (or `config('app.og_share_version')` default in `config/app.php`) so `og:image` / `twitter:image` URLs change and crawlers refetch.

## Result preview (`result-preview.png`)

Screenshot of the live **shuffle result** page (`GET /random`, two players) for the home page marketing block. **Hi-DPI capture** (2× device scale) then Lanczos downscale to 1920×1650 for sharp UI text; **PNG** (not JPEG) to avoid compression artifacts.

Use `?sur_screenshot=1` so the Matomo cookie strip and FAB are **not** rendered (only when `APP_ENV` is not `production`).

```bash
google-chrome --headless=new --no-sandbox --disable-dev-shm-usage \
  --window-size=1920,1650 --force-device-scale-factor=2 \
  --hide-scrollbars --virtual-time-budget=12000 \
  --screenshot=/tmp/sur-result-raw.png "https://YOUR_SITE/random?sur_screenshot=1"
ffmpeg -y -i /tmp/sur-result-raw.png \
  -vf "scale=1920:1650:flags=lanczos+accurate_rnd+full_chroma_int" -frames:v 1 \
  public/images/landing/result-preview.png
```

