# Landing page imagery

## Hero carousel — faction spotlights

The home page hero carousel highlights **four factions from the Smash Up base game** (public faction names: **Pirates**, **Aliens**, **Dinosaurs**, **Zombies** — see [AEG’s Smash Up overview](https://www.alderac.com/smashup/)).

Each slide uses **original AI-generated illustration** (Cursor image generation) themed on that faction’s **concept** (sailing action, alien invasion, prehistoric beasts, undead horde). **These are not Alderac Entertainment Group (AEG) card or box illustrations** and must not be mistaken for official product art. No copyrighted characters from licensed expansions appear by design.

**Trademark:** *Smash Up* and faction themes are trademarks or property of their respective owners. This site is an independent fan randomizer.

| File | Faction (base game) | Prompt theme |
| ---- | -------------------- | ------------ |
| `slide-01-faction-pirates.png` | Pirates | Galleon, sea battle, Age of Sail adventure |
| `slide-02-faction-aliens.png` | Aliens | Flying saucer, tractor beam, invasion sci‑fi |
| `slide-03-faction-dinosaurs.png` | Dinosaurs | T. rex, prehistoric jungle |
| `slide-04-faction-zombies.png` | Zombies | Suburban zombie horde, horror-comedy tone |

**Regeneration:** Replace PNGs in `public/images/landing/` and keep filenames in sync with `app/Http/Controllers/HomeController.php` and `tests/Feature/HomeLandingTest.php`.

**Note:** Full-size PNGs; consider WebP or compression if performance budgets require it.
