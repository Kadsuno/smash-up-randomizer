# Design system — Smash Up Randomizer

Single reference for **public-facing UI** so colors, spacing, and controls stay consistent. When in doubt, match the **marketing landing**.

## Canonical sources

| Concern | Source of truth |
|--------|------------------|
| **Layout & marketing patterns** | [`resources/views/start/home.blade.php`](../resources/views/start/home.blade.php) (hero CTAs, carousel chrome, shuffle dialog, chips, section rhythm) |
| **Named component styles** | [`resources/css/app.css`](../resources/css/app.css) → `@layer components` (prefix `sur-`) |
| **Page shell** | [`resources/views/components/layouts/header.blade.php`](../resources/views/components/layouts/header.blade.php), [`main.blade.php`](../resources/views/components/layouts/main.blade.php) |
| **Copy** | [`resources/lang/en/`](../resources/lang/en/), [`resources/lang/de/`](../resources/lang/de/) — always ship **EN + DE** for user-visible strings |

## Layout & spacing

- **Sections:** `<x-sur.section>` — default vertical padding `py-12 md:py-16 lg:py-20` (see [`components/sur/section.blade.php`](../resources/views/components/sur/section.blade.php)).
- **Horizontal container:** `<x-sur.container>` — `px-4 sm:px-6 lg:px-8`, `max-w-7xl` (or `narrow` → `max-w-3xl` for prose-heavy pages).
- **Scroll reveal:** `<x-sur.reveal>` for staggered entrance; keep delays modest (landing uses ~80ms steps).
- **Button groups:** prefer `flex flex-wrap items-center justify-center gap-3` (or `justify-start` when aligned to copy in a card). Avoid one-off `gap-4` / `gap-2` mix on the same page without reason.

## Buttons (mandatory patterns)

### Standard classes

Use these **instead of** ad-hoc `bg-indigo-600`, `rounded-xl`, `px-5 py-2.5` combinations.

| Role | Class | Notes |
|------|--------|------|
| Primary | `sur-btn-primary` | Includes indigo fill, **default glow** `shadow-lg shadow-indigo-500/25`, hover, focus ring, `active:scale-[0.98]`. |
| Secondary | `sur-btn-secondary` | Bordered subtle surface; same min-height and radius as primary. |
| Ghost | `sur-btn-ghost` | Text-forward; optional `border-white/15` override on landing for contrast. |

- **Element:** Use real `<button>` or `<a>`; for forms, [`components/button.blade.php`](../resources/views/components/button.blade.php) defaults to `sur-btn-primary`.
- **Icons:** `inline-flex items-center gap-2` + Font Awesome icon `text-xs` (see landing hero CTAs).
- **Heights:** Default from CSS is `min-h-11`. **Hero / band CTAs** may use `min-h-12` with `px-8` / `px-10` and `text-base` — copy the exact pattern from `home.blade.php`.

### Hero emphasis (glow tier)

The landing adds **extra** indigo glow on top of `sur-btn-primary` for key CTAs, e.g.:

- `shadow-lg shadow-indigo-500/30` or `shadow-indigo-500/35` / `shadow-indigo-500/25`

**Rule:** For **hero, mid-page band, or teaser CTAs**, you may add **one** of these shadow utilities alongside `sur-btn-primary`, consistent with the nearest block on `home.blade.php`. Do **not** invent new shadow colors or opacities per view.

**Inner pages** (shuffle results, account, legal): use plain `sur-btn-primary` / `sur-btn-secondary` unless the block is explicitly a “hero”-style spotlight.

### Documented exceptions

If a control is **not** a standard primary/secondary/ghost (e.g. destructive, toggle, share helper), add a **named** class in `app.css` under `@layer components`, document it here in a short table, and **do not** duplicate the same pattern inline across Blade files.

Current examples:

| Class | Use |
|--------|-----|
| `sur-share-copy-text-btn` | Share strip “copy as text” — outline style with strong `:hover` (explicit CSS). |

## Surfaces & borders

- **Cards:** `rounded-2xl` / `rounded-3xl`, `border border-white/10`, background `bg-zinc-900/50–bg-zinc-900/70` — align with landing cards.
- **Accent chips / tags:** `border-indigo-500/35–/40`, `bg-indigo-500/10–/12`, `text-indigo-200` (or violet analogue) — see combo tiles on the landing.

## Typography

- **UI font:** Nunito (see `@theme` in `app.css`).
- **Eyebrows:** `text-xs font-bold uppercase tracking-widest` + accent color (`text-indigo-400` class family).
- **Body on dark:** `text-zinc-300`–`text-zinc-500` for secondary lines; avoid pure gray-400 on gray-900 without checking contrast in context.

## Accessibility

- Focus: rely on `focus-visible:ring-*` patterns already on `sur-btn-*`.
- Interactive non-button elements: if you must use a div, add `role`, keyboard handler, and `cursor-pointer`; prefer native `<button>` / `<a>`.

## Checklist — new or refactored UI

1. Compare **side-by-side** with the same control type on **`home.blade.php`**.
2. Buttons use **`sur-btn-primary` / `sur-btn-secondary` / `sur-btn-ghost`** or a **documented** `sur-*` exception in this file.
3. Section spacing uses **`x-sur.section` / `x-sur.container`** where applicable.
4. All guest-visible strings exist in **EN + DE** lang files.
5. After CSS/class changes that affect Tailwind compilation, run **`ddev npm run build`** (or project’s Vite build) before assuming utilities exist in production CSS.

## Drift cleanup

When touching a Blade file, prefer migrating **inline Tailwind button stacks** to `sur-btn-*` in the same PR if the change is local. Larger audits: track in `docs/roadmap.md` or a ticket.
