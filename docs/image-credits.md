# Landing page imagery

## Hero carousel (home `/`)

The four slides use **AI-generated PNGs** (Cursor image generation) created as **original artwork**. They are inspired by the *idea* of a shufflebuilding game with **two factions**, **bases**, and **many faction decks** — similar in *theme* to how [Smash Up](https://www.alderac.com/smashup/) is described publicly (combine two factions, fight over bases). **They are not official Alderac Entertainment Group (AEG) product art**, do not depict copyrighted characters from licensed Smash Up sets, and must not be mistaken for AEG assets.

**Trademark:** *Smash Up* is a trademark of its respective owner. This project is a fan tool; carousel art is independent fan-site illustration.

| File | Theme (prompt intent) |
| ---- | --------------------- |
| `slide-01-mashup-bases.png` | Mash-up factions clashing around a central “base” / scoring focal point — pirates vs sci‑fi, original characters |
| `slide-02-faction-stacks.png` | Many distinct faction deck stacks — collection / “every expansion” vibe |
| `slide-03-house-rules-table.png` | Dice, rulebook, curated deck piles — house rules and card pool |
| `slide-04-pairings-clear.png` | Abstract player pairings on a device — instant clear assignments |

**Regeneration:** Replace PNGs in `public/images/landing/` and keep filenames in sync with `app/Http/Controllers/HomeController.php` and `tests/Feature/HomeLandingTest.php`.

**Note:** PNGs are full resolution; consider WebP or compression if LCP budgets require it.
