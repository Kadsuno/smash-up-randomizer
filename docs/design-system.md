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

---

## UI inventory (Blade views)

Inventory of **first-party** views under `resources/views/` (excluding `vendor/*` and `emails/*` unless noted). Use this to see **which patterns exist today** and what should converge.

### Surfaces by route family

| Zone | Typical layout | Dominant patterns today |
|------|----------------|-------------------------|
| **Marketing + public app shell** | `x-layouts.main`, `x-sur.section` / `x-sur.container`, `x-sur.reveal` | `sur-btn-*`, `sur-card`, hero carousel (`sur-landing-carousel*`), shuffle `<dialog>` in [`start/home.blade.php`](../resources/views/start/home.blade.php) |
| **Account hub & subpages** | `min-h-screen bg-zinc-950`, `sur-account-radial-bg`, `sur-account-grid-bg` | Glass panels `rounded-2xl border border-white/10 bg-white/[0.04]`, stat/feature **clickable tiles**, emerald **flash banners** |
| **Auth (frontend + legacy admin login)** | Centered column, `rounded-2xl border border-white/8 bg-zinc-900/80 p-7 shadow-2xl backdrop-blur-sm` | **Inline** “primary” buttons (`bg-indigo-600` …) and **inline** inputs (not `sur-input`) — **high drift** vs marketing |
| **Legal / contact** | `x-sur.section` + `sur-card` | Mostly aligned; contact uses `sur-input` + `sur-btn-primary` |
| **Factions / expansions / shuffle result** | `x-sur.section`, grid cards | Mix of `sur-card`-style blocks and **custom** `rounded-2xl border border-white/8` grid cards; some **raw** primary CTAs |
| **Admin backend** | `x-layouts.backend.backendMain`, sidebar | `sidebar-link`, **inline** `bg-indigo-600` actions, tables with `divide-y` — separate visual language (lighter zinc UI) |

**Canonical public marketing reference remains [`start/home.blade.php`](../resources/views/start/home.blade.php).** Account shell is a **secondary** reference for logged-in glass aesthetic.

---

## UI concepts (catalog)

These are the **named concepts** the product uses. New work should map to a concept (or add one CSS class + a row here).

### 1. Actions (buttons & links)

| Concept | Implementation | When to use |
|---------|----------------|-------------|
| **Primary action** | `sur-btn-primary` (+ optional hero shadow tier from [Buttons](#buttons-mandatory-patterns)) | Main CTA per block |
| **Secondary action** | `sur-btn-secondary` | Alternative safe action |
| **Tertiary / low emphasis** | `sur-btn-ghost` | Select-all, cancel-style, low visual weight |
| **Destructive** | Dedicated styles (e.g. red border/bg); **prefer** one shared `sur-btn-danger` if usage grows — today: inline in account/OAuth cancel | Delete, revoke, dangerous confirm |
| **Nav CTA (header)** | `sur-btn-primary` + `min-h-10 rounded-full` + optional `shadow-indigo-500/20` | Single persistent “Shuffle” in site header |
| **Icon + label** | `inline-flex items-center gap-2` + FA `text-xs` | Any `sur-btn-*` with icon |
| **Cookie bar** | `btn-sur-cookie-primary`, `btn-sur-cookie-outline` | Consent bar only |
| **Share helper** | `sur-share-copy-text-btn` | Copy-as-text variant only |

**Anti-pattern:** `rounded-xl bg-indigo-600 px-4 py-2` (or `py-2.5`) without `sur-btn-primary` — replace on touch.

### 2. Form controls

| Concept | Preferred | Current drift |
|---------|-----------|----------------|
| **Text field (public forms)** | `sur-input` | Contact: yes. Auth/account presets: **duplicated** long class string on `<input>` |
| **Select / textarea** | `sur-input` (+ `min-h-*` / `resize-y` as needed) | Contact: yes |
| **Checkbox / radio** | Tailwind pattern `h-4 w-4 rounded border-white/20 bg-zinc-800 text-indigo-500 focus:ring-indigo-500/50` | Repeated across auth/account — **candidate** for `sur-checkbox` if extracted |
| **Form panel (auth)** | Today: `rounded-2xl border border-white/8 bg-zinc-900/80 p-7 shadow-2xl backdrop-blur-sm` | **Candidate** `sur-panel-auth` in `app.css` to one-shot replace |

### 3. Containers & cards

| Concept | Implementation | Notes |
|---------|----------------|-------|
| **Content card** | `sur-card` (+ optional `border-white/8` override) | Legal, contact side panels, faction detail sections |
| **Interactive marketing card** | `sur-card` + `group` + `hover:border-indigo-500/40` etc. | Landing feature grid |
| **Interactive grid tile (catalog)** | `group … rounded-2xl border border-white/8 bg-zinc-900/60 hover:border-indigo-500/30` | Faction list, expansion grid — **candidate** `sur-tile-grid` |
| **Account glass panel** | `rounded-2xl border border-white/10 bg-white/[0.04] shadow-lg shadow-black/20 backdrop-blur-sm` | Dashboard hero, tiles, forms — **candidate** `sur-panel-glass` |
| **Shuffle modal chrome** | `.shuffle-modal-card`, `fieldset` / labels with `has-[:checked]:*` | Document only; don’t duplicate outside modal |

### 4. Feedback & status

| Concept | Typical classes | Use |
|---------|-----------------|-----|
| **Success flash** | `rounded-lg border border-emerald-500/20 bg-emerald-900/20` (or `bg-emerald-500/10`) + `text-emerald-400` | Form success, verified state |
| **Error flash** | `border-red-500/20 bg-red-900/20` + `text-red-400` | Validation / failures |
| **Warning** | `border-amber-500/30 bg-amber-900/20` + `text-amber-200` | MFA / caution |
| **Inline validation** | `@error` → `border-red-500/40` on field | Laravel errors |

### 5. Chips, badges, pills

| Concept | Pattern | Examples |
|---------|---------|----------|
| **Faction / combo chip** | `rounded-xl border border-indigo-500/35-40 bg-indigo-500/10-12 text-indigo-200` | Landing combos, history rows, filters |
| **Filter pill (toggle)** | `rounded-full border px-3 py-1.5 text-xs font-semibold` + active indigo treatment | Faction list complexity filter |
| **Stat pill** | `rounded-full bg-zinc-800 px-2 py-0.5 text-zinc-400` | History meta |
| **Eyebrow pill** | `rounded-full border border-indigo-500/20 bg-indigo-900/20 px-3 py-1 text-xs font-bold uppercase tracking-widest text-indigo-400` | Shuffle result hero |

### 6. Navigation & chrome

| Concept | Class(es) | Location |
|---------|-----------|----------|
| **Site header** | `sur-site-header`, `sur-site-header--scrolled` | [`header.blade.php`](../resources/views/components/layouts/header.blade.php) |
| **Nav pills (desktop)** | `sur-nav-pill`, `sur-nav-pill-active`, `sur-nav-pill-idle` | Header |
| **Mobile drawer links** | `sur-nav-mobile-link`, `-active`, `-idle` | Header |
| **Footer** | `sur-site-footer`, `sur-footer-heading`, `sur-footer-link`, `sur-social-btn` | Footer |
| **Skip link** | `sur-skip-link` | a11y |

### 7. Marketing-only components

| Concept | Class / markup | Notes |
|---------|----------------|-------|
| **Hero carousel shell** | `sur-landing-carousel` | Aspect ratio + border + shadow |
| **Carousel chrome button** | `sur-landing-carousel-btn` | Prev/next |
| **Quote / secondary carousel** | Same btn + dot classes inline | Dots: `bg-indigo-400 shadow-md shadow-indigo-500/40` when active |
| **Stats / steps icon tile** | `rounded-2xl bg-*-500/15 ring-1 ring-*-500/30` | Landing “how it works” |

### 8. Account-specific

| Concept | Pattern |
|---------|---------|
| **Page background** | `sur-account-radial-bg`, `sur-account-grid-bg` |
| **Stat link tile** | Large `py-14` glass card with icon in tinted `rounded-2xl` |

### 9. Admin backend

| Concept | Pattern |
|---------|---------|
| **Sidebar link** | `sidebar-link` + active `bg-indigo-500/10 text-indigo-300` |
| **Table / list** | White/zinc panels, `divide-y divide-white/8` |

Backend is **intentionally** a different density; still use **semantic** primary color for main actions, but full unification with marketing buttons is **optional** (track as chore).

### 10. Errors

| Concept | Pattern |
|---------|---------|
| **Minimal error page** | Large `text-indigo-500/90` code + `text-zinc-300` message | [`errors/minimal.blade.php`](../resources/views/errors/minimal.blade.php) |

---

## Border & shadow tokens (quick reference)

Use **one** convention per surface type:

| Token use | Border | Background | Shadow |
|-----------|--------|------------|--------|
| Default card | `border-white/10` | `bg-zinc-900/80` | `shadow-xl shadow-black/40` (`sur-card`) |
| Softer card / legal | `border-white/8` | same | as `sur-card` override |
| Glass account | `border-white/10` | `bg-white/[0.04]` | `shadow-lg shadow-black/20` |
| Auth panel | `border-white/8` | `bg-zinc-900/80` | `shadow-2xl backdrop-blur-sm` |
| Section divider | `border-white/6` | — | Often `border-t` / `border-b` on `x-sur.section` |

---

## Known drift hotspots (refactor when touching)

Files with **repeated raw primary** (`bg-indigo-600` / similar) or duplicate form shells — migrate toward `sur-btn-*`, `sur-input`, and optional future `sur-panel-*`:

- `resources/views/auth/*.blade.php` (frontend + `login.blade.php`)
- `resources/views/account/edit.blade.php`, `two-factor-setup.blade.php`, `presets.blade.php`, `index.blade.php` (partially already `sur-btn-*`)
- `resources/views/expansions/show.blade.php`, `decks/detail.blade.php`, `decks/edit.blade.php`, `decks/_form.blade.php`
- `resources/views/backend/decks-manager.blade.php`
- `resources/views/components/layouts/footer.blade.php` (small CTA link — consider `sur-btn-ghost` or `sur-footer-link` pattern)

**Already aligned:** landing `home.blade.php` (with documented hero shadow), `contact/contactForm.blade.php`, much of `legal/*`, `shuffle` wizard footer actions, `vendor/passport/authorize.blade.php` (uses `sur-btn-*`; cancel is special-case).

---

## Future CSS extractions (optional tickets)

When the same **7+ token** string appears in **3+ files**, extract to `app.css`:

| Candidate class | Purpose |
|-----------------|---------|
| `sur-panel-auth` | Auth card shell |
| `sur-panel-glass` | Account glass container |
| `sur-tile-grid` | Faction/expansion grid item |
| `sur-checkbox` | Standard checkbox |
| `sur-btn-danger` | Destructive button |
| `sur-flash-success` / `sur-flash-error` | Flash banners |

---

## Checklist — extended

6. Map the feature to a **row in the UI concepts catalog** (or add one + CSS).  
7. Prefer **`sur-input`** for new fields on public/account forms.  
8. **Backend** changes: keep sidebar/table consistency; align primary actions with indigo semantic if adding new screens.
