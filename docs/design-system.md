# Design system — Smash Up Randomizer

Single source of truth for **UI foundations** (typography, color, spacing, motion) and **named patterns** (components, shells, modals). Scope: **marketing site**, **logged-in account**, **auth**, **legal/contact**, **shuffle UI** (including the home dialog), **cookie consent**, **admin backend**, and **system** styles in [`resources/css/app.css`](../resources/css/app.css). When a pattern is not listed here, add it (and any new `sur-*` class) in the same change.

## Canonical sources

| Concern | Source of truth |
|--------|------------------|
| **Layout & marketing patterns** | [`resources/views/start/home.blade.php`](../resources/views/start/home.blade.php) (hero CTAs, carousel chrome, shuffle dialog, chips, section rhythm) |
| **Named component styles** | [`resources/css/app.css`](../resources/css/app.css) — `@layer base`, `@layer components`, and file sections below components (shuffle wizard, scroll snap, carousel) |
| **Layout primitives** | [`components/sur/section.blade.php`](../resources/views/components/sur/section.blade.php), [`container.blade.php`](../resources/views/components/sur/container.blade.php), [`reveal.blade.php`](../resources/views/components/sur/reveal.blade.php) |
| **Page shell** | [`components/layouts/header.blade.php`](../resources/views/components/layouts/header.blade.php), [`main.blade.php`](../resources/views/components/layouts/main.blade.php) |
| **Backend shell** | [`components/layouts/backend/backendMain.blade.php`](../resources/views/components/layouts/backend/backendMain.blade.php), [`backendHeader.blade.php`](../resources/views/components/layouts/backend/backendHeader.blade.php) |
| **Copy** | [`resources/lang/en/`](../resources/lang/en/), [`resources/lang/de/`](../resources/lang/de/) — always ship **EN + DE** for user-visible strings |

---

## Foundations

### Typography & fonts

| Item | Specification |
|------|----------------|
| **Primary typeface** | **Nunito** — loaded from Google Fonts in `app.css`: weights **400, 600, 700, 800** (`wght@400;600;700;800`). |
| **CSS token** | `--font-sans` in `@theme` → `'Nunito', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'`. |
| **Base application** | `body`: `font-sans`, `antialiased`, default text `text-zinc-100` on `bg-zinc-950` (`@layer base`). |
| **`font-medium` (500)** | Not included in the Google Fonts URL; browsers may synthesize. Prefer **`font-semibold` (600)** or **`font-bold` (700)** for UI labels where precision matters. |
| **Italic** | Nunito italic is **not** imported; avoid relying on italic for critical UI. |

**Semantic type roles** (conventions; match nearby blocks on [`home.blade.php`](../resources/views/start/home.blade.php) when unsure):

| Role | Typical utilities |
|------|-------------------|
| **Eyebrow / kicker** | `text-xs font-bold uppercase tracking-widest` + accent (`text-indigo-400`, `text-violet-400`, etc.) |
| **Section title** | `text-2xl font-bold text-white` or `text-sm font-semibold text-zinc-400` for in-card headings |
| **Marketing H1** | `text-4xl font-extrabold tracking-tight text-white sm:text-5xl` (and variants on inner pages) |
| **Lead / hero body** | `text-base`–`text-lg` `text-zinc-400` `leading-relaxed` |
| **Default UI body** | `text-sm`–`text-base` `text-zinc-300` |
| **Secondary / muted** | `text-sm` `text-zinc-500`–`text-zinc-600` |
| **Legal / longform** | Narrow container `max-w-3xl`; prose-friendly line length |

**Monospace** (e.g. 2FA secret): `font-mono` where shown in account views.

### Iconography

| Item | Specification |
|------|----------------|
| **Set** | **Font Awesome 6 Free** (CSS) via `@import '@fortawesome/fontawesome-free/css/all.css'` in `app.css`. |
| **Default pairing with buttons** | `inline-flex items-center gap-2`; icon size often `text-xs` next to `text-sm` button label. |
| **Decorative icons** | `aria-hidden="true"` when adjacent text conveys meaning; otherwise provide `aria-label` on the control. |

### Color system

**Core palette:** Tailwind **zinc** for neutrals, **indigo** / **violet** for brand accent, plus **emerald** / **red** / **amber** / **sky** for semantic states. Prefer Tailwind utility opacity forms (`bg-indigo-500/10`) for surfaces; use **hex/rgba** only where already codified in `app.css` (cookie FAB, dialogs) or for scrollbar gradients.

| Semantic | Typical utilities | Notes |
|----------|-------------------|--------|
| **Page background** | `bg-zinc-950` | Default `body`. |
| **Elevated surface** | `bg-zinc-900/80`, `bg-zinc-900/60` | Cards, tables, panels. |
| **Glass account panels** | `bg-white/[0.04]` + `border-white/10` | Account dashboard. |
| **Primary accent fill** | `bg-indigo-500`, hover `bg-indigo-400` | `sur-btn-primary`, progress fill gradient start. |
| **Primary accent text** | `text-indigo-300`, `text-indigo-400` | Links, eyebrows, highlights. |
| **Chip / selection** | `border-indigo-500/35`–`40`, `bg-indigo-500/10`–`12`, `text-indigo-200` | Faction chips, combo tiles. |
| **Success** | `emerald-*` with `/10`–`/20` borders/bg | Flashes, complete wizard step. |
| **Danger** | `red-*` with `/20` borders, `text-red-400` | Errors, destructive actions. |
| **Warning** | `amber-*` | Cautionary copy. |

**Hardcoded colors in `app.css` (authoritative):**

| Location | Value | Role |
|----------|-------|------|
| Cookie primary button | `#fafafa` on `#6366f1` | `btn-sur-cookie-primary` |
| Cookie outline | `#a5b4fc`, border `rgba(129, 140, 248, 0.55)` | `btn-sur-cookie-outline` |
| Cookie FAB | `#a5b4fc`, borders `rgba(129, 140, 248, 0.55)` / `#818cf8` | `.sur-cookie-fab` |
| Cookie modal | bg `#18181b`, text `#fafafa`, backdrop `rgba(0,0,0,0.72)` | `#surCookieConsentModal` |
| Shuffle modal backdrop | `rgba(9, 9, 11, 0.88)` | `#shuffle-modal::backdrop` |
| Skip link | bg `#18181b`, text `#fafafa` | `.sur-skip-link` |
| Scrollbar vars | `--sur-scrollbar-fg`, `--sur-scrollbar-bg` | `:root` |

### Spacing & layout rhythm

| Item | Value / rule |
|------|----------------|
| **Scale** | Tailwind default spacing scale (0.25rem increments) unless noted. |
| **Section vertical padding** | `<x-sur.section>`: `py-12 md:py-16 lg:py-20` when `padded` (default). |
| **Horizontal padding** | `<x-sur.container>`: `px-4 sm:px-6 lg:px-8`. |
| **Content max width** | `max-w-7xl` default; `narrow` → `max-w-3xl`. |
| **Button groups** | Prefer `gap-3`; align with `flex-wrap` / `justify-center` or `justify-start` per block. |
| **Cookie bar body offset** | `body.sur-cookie-bar-visible`: `padding-bottom: 8rem` (&lt;1024px), `5.5rem` (≥1024px). |

### Sizing & touch targets

| Element | Rule |
|---------|------|
| **Primary / secondary / ghost buttons** | `min-h-11` (`sur-btn-*`). |
| **Hero / band CTAs** | May use `min-h-12` + larger horizontal padding — copy [`home.blade.php`](../resources/views/start/home.blade.php). |
| **Header nav CTA** | Often `min-h-10` + `rounded-full`. |
| **Cookie bar buttons** | `min-h-9` (`btn-sur-cookie-*`). |
| **Cookie FAB** | `3.25rem` × `3.25rem` square, `rounded-full`. |
| **Carousel chrome buttons** | `h-10 w-10` → `sm:h-11 sm:w-11` (`.sur-landing-carousel-btn`). |
| **Mobile nav links** | `min-h-12` (`.sur-nav-mobile-link`). |
| **Social footer buttons** | `h-11 w-11` (`.sur-social-btn`). |
| **Shuffle wizard step index** | `2.5rem` circle (`shuffle-wizard-step__index`). |

### Border radius

| Token | Use |
|-------|-----|
| `rounded-xl` | Buttons (`sur-btn-*`), inputs (`sur-input`), many chips. |
| `rounded-2xl` | Cards (`sur-card`), account tiles, modal inner cards. |
| `rounded-3xl` | Marketing carousel shell (`.sur-landing-carousel`). |
| `rounded-full` | Pills, FAB, carousel buttons, wizard step circles. |
| `0.75rem` | Cookie consent `<dialog>` (`#surCookieConsentModal`). |
| `1rem` | Shuffle `<dialog>` outer radius (`#shuffle-modal:open`). |

### Motion & animation

| Mechanism | Duration / easing | Where |
|-----------|-------------------|--------|
| **Default transitions** | `duration-200 ease-out` | Buttons, nav pills, many hovers. |
| **Header / surfaces** | `duration-300` | `sur-site-header`, `sur-card` base transition. |
| **Card lift (interactive)** | `duration-300 ease-out`, `hover:-translate-y-1` | `sur-card-interactive`. |
| **Scroll reveal** | `0.55s cubic-bezier(0.22, 1, 0.36, 1)` for opacity + `translateY` | `.sur-reveal` → `.sur-reveal--in` (via [`reveal.blade.php`](../resources/views/components/sur/reveal.blade.php) + Alpine `x-intersect`). Optional delay: CSS var `--sur-reveal-delay` (ms). |
| **Footer columns** | `sur-footer-in` animation `0.55s` same easing; stagger **0 / 80 / 160 / 240ms** | `.sur-footer-col` |
| **Shuffle step body** | `0.3s ease` opacity + transform | `.shuffle-step-content` / `.slide-out` / `.slide-in` |
| **Wizard step index** | `0.2s ease` | `shuffle-wizard-step__index`, labels |
| **Cookie FAB** | `0.2s ease` multi-property | `.sur-cookie-fab` |
| **Primary button press** | `active:scale-[0.98]` | `sur-btn-primary`, `sur-btn-secondary` |
| **Share copy button hover** | `transform: scale(1.02)` + shadow | `.sur-share-copy-text-btn:hover` |
| **Smooth scroll** | `scroll-smooth` on `html` | Disabled for reduced-motion (see below). |
| **Faction detail scroll snap** | `scroll-behavior: smooth` on `.scroll-container` | Overridden to `auto` when reduced motion. |

**`prefers-reduced-motion: reduce`** (`app.css`): global rule sets `animation-duration`, `transition-duration`, and `scroll-behavior` to effectively instant/auto for `*`, `::before`, `::after`. **Do not** bypass for essential feedback without an accessible alternative.

**Third-party animation libraries:** None are bundled; motion uses Tailwind utilities, `app.css` keyframes, and Alpine-driven classes. If Animate.css or similar is ever added back, document `animate__*` usage here and verify reduced-motion behavior.

**Marketing-only motion:** Landing hero may use **`hover:scale`** / **`active:scale`** on top of `sur-btn-primary` (see [Buttons § Hero emphasis](#hero-emphasis-glow-tier)). Inner pages should stay on default button motion unless the block is explicitly hero-style.

### Z-index scale (documented)

| Layer | Z-index | Notes |
|-------|---------|--------|
| Skip link (focused) | `100` | `.sur-skip-link` |
| Site header | `50` | `.sur-site-header` |
| Backend sidebar | `40` | Fixed aside under header |
| Cookie bar | `1040` | `.sur-cookie-bar` |
| Cookie FAB | `1045` | `.sur-cookie-fab` |
| Native `<dialog>` | Top layer | Shuffle + cookie modals use backdrop pseudo-elements |

### Scrollbars

| Scope | Class / selector | Behavior |
|-------|------------------|----------|
| **Document** | `html` | `scrollbar-gutter: stable`; thin scrollbar; WebKit + Firefox themed per `:root` vars. |
| **Opt-in regions** | `.scroll-container`, `.sur-scrollbar` | Same thumb/track styling as document. |
| **Faction strip** | `.sur-faction-strip` | Scrollbar hidden (horizontal teaser). |

Thumb visual: rounded pill, indigo→violet gradient, inset highlight; track: dark zinc gradient + indigo hairline (see `app.css`).

### Breakpoints

Standard **Tailwind** defaults apply (`sm` 40rem, `md` 48rem, `lg` 64rem, `xl` 80rem, `2xl` 96rem). Section padding and container gutters step up at `sm` / `lg` as defined on `x-sur.*` components.

---

## Layout & spacing (quick reference)

- **Sections:** `<x-sur.section>` — see [Spacing & layout rhythm](#spacing--layout-rhythm).
- **Scroll reveal:** `<x-sur.reveal>` — intersection-triggered `sur-reveal`; keep delays modest (e.g. **60–120ms** steps on marketing pages).
- **Button groups:** `gap-3` baseline; avoid mixing arbitrary gaps in the same toolbar without reason.

## Buttons (mandatory patterns)

### Standard classes

Use these **instead of** ad-hoc `bg-indigo-600`, `rounded-xl`, `px-5 py-2.5` combinations.

| Role | Class | Notes |
|------|--------|-------|
| Primary | `sur-btn-primary` | Indigo fill, `shadow-lg shadow-indigo-500/25`, hover, focus ring, `active:scale-[0.98]`. |
| Secondary | `sur-btn-secondary` | Bordered subtle surface; same min-height and radius as primary. |
| Ghost | `sur-btn-ghost` | Text-forward; optional `border-white/15` override on landing for contrast. |

- **Element:** Use real `<button>` or `<a>`; for forms, [`components/button.blade.php`](../resources/views/components/button.blade.php) defaults to `sur-btn-primary`.
- **Icons:** `inline-flex items-center gap-2` + Font Awesome icon `text-xs` (see landing hero CTAs).
- **Heights:** Default `min-h-11`. **Hero / band CTAs** may use `min-h-12` with `px-8` / `px-10` and `text-base` — copy from `home.blade.php`.

### Hero emphasis (glow tier)

The landing adds **extra** indigo shadow on top of `sur-btn-primary` for key CTAs, e.g. `shadow-lg shadow-indigo-500/30` (or `/35` / `/25`).

**Rule:** For **hero, mid-page band, or teaser CTAs**, add **at most one** documented shadow utility, consistent with the nearest block on `home.blade.php`. Do **not** invent new shadow colors or opacities per view.

**Inner pages** (shuffle results, account, legal): plain `sur-btn-primary` / `sur-btn-secondary` unless the block is explicitly a “hero” spotlight.

### Documented exceptions

| Class | Use |
|--------|-----|
| `sur-share-copy-text-btn` | Share strip “copy as text”; strong `:hover` + scale (see `app.css`). |
| `btn-sur-cookie-primary` | Cookie bar / modal primary. |
| `btn-sur-cookie-outline` | Cookie bar / modal secondary. |

For any new exception, add **`sur-*` (or `btn-sur-*`) in `app.css`** and a row in this table.

## Surfaces & borders

- **Cards:** prefer `sur-card` / `sur-card-interactive`; radius `rounded-2xl`, border `border-white/10`, `bg-zinc-900/80`.
- **Accent chips / tags:** `border-indigo-500/35–/40`, `bg-indigo-500/10–/12`, `text-indigo-200` (or violet analogue) — see landing combo tiles.
- **Dividers:** common `border-white/6`–`10` depending on contrast needs; see [Border & shadow tokens](#border--shadow-tokens-quick-reference).

## Accessibility

- Focus: use `focus-visible:ring-*` patterns on interactive controls (`sur-btn-*`, nav, cookie).
- Interactive non-buttons: prefer `<button>` / `<a>`; if a `div` is unavoidable, add `role`, keyboard handlers, and `cursor-pointer`.
- Skip link: `.sur-skip-link` moves into view on focus.

## Checklist — new or refactored UI

1. Compare **side-by-side** with the same control type on **`home.blade.php`** (or account glass patterns for logged-in-only features).
2. Buttons use **`sur-btn-primary` / `sur-btn-secondary` / `sur-btn-ghost`** or a **documented** exception above.
3. Section spacing uses **`x-sur.section` / `x-sur.container`** where applicable.
4. All guest-visible strings exist in **EN + DE** lang files.
5. After CSS/class changes, run **`npm run build`** (or `ddev npm run build`) before assuming utilities exist in production CSS.
6. Motion: respect **`prefers-reduced-motion`**; no new animation library without documenting it here.

## Drift cleanup

When touching a Blade file, migrate **inline Tailwind button/input stacks** to `sur-btn-*` / `sur-input` in the same PR when local. Larger audits: `docs/roadmap.md` or a ticket.

---

## UI inventory (Blade views)

Inventory of **first-party** views under `resources/views/` (excluding `vendor/*` and `emails/*` unless noted).

### Surfaces by route family

| Zone | Typical layout | Dominant patterns today |
|------|----------------|-------------------------|
| **Marketing + public app shell** | `x-layouts.main`, `x-sur.section` / `x-sur.container`, `x-sur.reveal` | `sur-btn-*`, `sur-card`, `sur-landing-carousel`, shuffle `<dialog>` in [`start/home.blade.php`](../resources/views/start/home.blade.php) |
| **Account hub & subpages** | `min-h-screen bg-zinc-950`, `sur-account-radial-bg`, `sur-account-grid-bg` | Glass panels, stat/feature tiles, `sur-btn-*`, `sur-input` on forms |
| **Auth (frontend + admin login)** | Centered column, auth card shell | `sur-btn-*`, `sur-input` on forms (aligned with design tokens) |
| **Legal / contact** | `x-sur.section` + `sur-card` | `sur-input`, `sur-btn-primary` |
| **Factions / expansions / shuffle result** | `x-sur.section`, grid cards | Mix of `sur-card`-style and catalog grid tiles; CTAs use `sur-btn-*` |
| **Admin backend** | `x-layouts.backend.backendMain`, sidebar | `sidebar-link`, tables, `sur-btn-*` on primary manager actions; separate density from marketing |

**Canonical public marketing reference:** [`start/home.blade.php`](../resources/views/start/home.blade.php). **Secondary (logged-in):** account glass aesthetic.

---

## UI concepts (catalog)

These are the **named concepts** the product uses. New work should map to a concept (or add one CSS class + a row here).

### 1. Actions (buttons & links)

| Concept | Implementation | When to use |
|---------|----------------|-------------|
| **Primary action** | `sur-btn-primary` (+ optional hero shadow tier) | Main CTA per block |
| **Secondary action** | `sur-btn-secondary` | Alternative safe action |
| **Tertiary / low emphasis** | `sur-btn-ghost` | Cancel-style, low visual weight |
| **Destructive** | Red border/bg patterns; **candidate** `sur-btn-danger` | Delete, revoke |
| **Nav CTA (header)** | `sur-btn-primary` + `min-h-10 rounded-full` + optional `shadow-indigo-500/20` | Persistent “Shuffle” |
| **Icon + label** | `inline-flex items-center gap-2` + FA `text-xs` | Any `sur-btn-*` with icon |
| **Cookie bar** | `btn-sur-cookie-primary`, `btn-sur-cookie-outline` | Consent UI only |
| **Share helper** | `sur-share-copy-text-btn` | Copy-as-text only |

**Anti-pattern:** raw `bg-indigo-600` button stacks without `sur-btn-primary`.

### 2. Form controls

| Concept | Preferred | Notes |
|---------|-----------|--------|
| **Text field** | `sur-input` | Auth, account, contact, backend filters where applicable |
| **Select / textarea** | `sur-input` (+ `min-h-*` / `resize-y`) | Match focus ring to `sur-input` |
| **Checkbox / radio** | Documented Tailwind pattern in concept table below | **Candidate** `sur-checkbox` |
| **Form panel (auth)** | `rounded-2xl border border-white/8 bg-zinc-900/80 p-7 shadow-2xl backdrop-blur-sm` | **Candidate** `sur-panel-auth` |

Repeated **checkbox / radio** pattern: `h-4 w-4 rounded border-white/20 bg-zinc-800 text-indigo-500 focus:ring-indigo-500/50` (adjust `rounded` for radio).

### 3. Containers & cards

| Concept | Implementation | Notes |
|---------|----------------|-------|
| **Content card** | `sur-card` (+ optional `border-white/8`) | Legal, contact, detail sections |
| **Interactive marketing card** | `sur-card-interactive` or `sur-card` + group hover | Landing |
| **Interactive grid tile (catalog)** | `rounded-2xl border border-white/8 bg-zinc-900/60` + hover indigo | Faction/expansion grids — **candidate** `sur-tile-grid` |
| **Account glass panel** | `rounded-2xl border border-white/10 bg-white/[0.04] shadow-lg shadow-black/20 backdrop-blur-sm` | **Candidate** `sur-panel-glass` |
| **Shuffle modal chrome** | `#shuffle-modal`, `.shuffle-modal-card`, `.faction-*`, `.shuffle-wizard-*` | [Shuffle dialog](#shuffle-dialog-native-dialog) |

### 4. Feedback & status

| Concept | Typical classes | Use |
|---------|-----------------|-----|
| **Success flash** | `border-emerald-500/20 bg-emerald-900/20` or `bg-emerald-500/10` + `text-emerald-400` | Forms, verified |
| **Error flash** | `border-red-500/20 bg-red-900/20` + `text-red-400` | Failures |
| **Warning** | `border-amber-500/30 bg-amber-900/20` + `text-amber-200` | MFA / caution |
| **Inline validation** | `@error` → `border-red-500/40` on field | Laravel |

### 5. Chips, badges, pills

| Concept | Pattern | Examples |
|---------|---------|----------|
| **Faction / combo chip** | `rounded-xl border border-indigo-500/35-40 bg-indigo-500/10-12 text-indigo-200` | Combos, history |
| **Filter pill** | `rounded-full border px-3 py-1.5 text-xs font-semibold` + active indigo | Faction list |
| **Stat pill** | `rounded-full bg-zinc-800 px-2 py-0.5 text-zinc-400` | History meta |
| **Eyebrow pill** | `rounded-full border border-indigo-500/20 bg-indigo-900/20 px-3 py-1 text-xs font-bold uppercase tracking-widest text-indigo-400` | Result hero |

### 6. Navigation & chrome

| Concept | Class(es) | Location |
|---------|-----------|----------|
| **Site header** | `sur-site-header`, `sur-site-header--scrolled` | [`header.blade.php`](../resources/views/components/layouts/header.blade.php) |
| **Nav pills (desktop)** | `sur-nav-pill`, `sur-nav-pill-active`, `sur-nav-pill-idle` | Header |
| **Mobile drawer links** | `sur-nav-mobile-link`, `-active`, `-idle` | Header |
| **Footer** | `sur-site-footer`, `sur-footer-heading`, `sur-footer-link`, `sur-social-btn` | Footer |
| **Skip link** | `sur-skip-link` | a11y |
| **In-content nav link** | `sur-link-nav` | Optional utility in `app.css` |

### 7. Marketing-only components

| Concept | Class / markup | Notes |
|---------|----------------|-------|
| **Hero carousel shell** | `sur-landing-carousel` | **Markup hook** on `home.blade.php` (Tailwind utilities only — no CSS rule); aspect `4/3` → `16/10`, `rounded-3xl`, border + shadow |
| **Carousel chrome button** | `sur-landing-carousel-btn` | See [Sizing](#sizing--touch-targets) |
| **Quote carousel** | Same btn; dots use indigo active state | Inline in `home.blade.php` |
| **Stats / steps icon tile** | `rounded-2xl bg-*-500/15 ring-1 ring-*-500/30` | “How it works” |

### 8. Account-specific

| Concept | Pattern |
|---------|---------|
| **Page background** | `sur-account-radial-bg`, `sur-account-grid-bg` |
| **Stat link tile** | Large `py-14` glass card with tinted icon |

### 9. Admin backend

| Concept | Pattern |
|---------|---------|
| **Shell** | `pt-14` main offset for fixed header; sidebar `width: 220px`, `top-14`, `z-40`, `border-white/6` |
| **Sidebar link** | `sidebar-link` + active `bg-indigo-500/10 text-indigo-300` |
| **Tables** | `divide-y divide-white/8`, `bg-zinc-900/60` panels |

Backend is **intentionally** denser than marketing; still use **`sur-btn-*`** and indigo semantic for primary actions on new screens.

### 10. Errors

| Concept | Pattern |
|---------|---------|
| **Minimal error page** | `text-indigo-500/90` code + `text-zinc-300` message | [`errors/minimal.blade.php`](../resources/views/errors/minimal.blade.php) |

---

## Shuffle dialog (native `<dialog>`)

Used on the landing shuffle wizard (`#shuffle-modal` in [`home.blade.php`](../resources/views/start/home.blade.php)). **Do not** reuse these hooks outside the modal without review.

| Item | Specification |
|------|----------------|
| **Open layout** | Fixed, centered horizontally (`left: 50%`, `translateX(-50%)`), top `max(0.75rem, safe-area)`, `width: min(100vw - 1.25rem, 42rem)`, `max-height: min(100dvh - 1.5rem, 52rem)`, `border-radius: 1rem`, flex column, `overflow: hidden`. |
| **Backdrop** | Solid `rgba(9,9,11,0.88)` — **no** `backdrop-filter` (compositor / close quirks). |
| **Scroll body** | `.shuffle-modal-scroll`: `overscroll-behavior: contain`, bottom safe-area padding. |
| **Faction grid** | `.faction-grid`: `minmax(140px,1fr)` / 150px sm+, gaps `0.5rem` / `0.625rem` sm+. |
| **Selected chip** | `.faction-item:has(input:checked) .faction-chip` — indigo border/bg per `app.css`. |
| **Wizard stepper** | `.shuffle-wizard-step__*` states: default, `.is-current` (indigo), `.is-complete` (emerald); connector `.shuffle-wizard-connector`. |
| **Step content motion** | `.shuffle-step-content` 0.3s; `.slide-out` / `.slide-in` for horizontal swap. |
| **Error outline** | `.shuffle-wizard--error` red ring. |

---

## Cookie consent layer

| Piece | Role |
|-------|------|
| `.sur-cookie-bar` | Fixed bar; z-index **1040**; top border indigo; blur per `app.css`. |
| `.btn-sur-cookie-*` | Primary / outline actions (see [Color](#color-system) hex table). |
| `.sur-cookie-fab` | Floating settings trigger; z-index **1045**; motion on hover. |
| `#surCookieConsentModal` | Native dialog; zinc-900 surface; `max-width` ~42rem; backdrop blur **6px**. |
| `body.sur-cookie-bar-visible` | Bottom padding so content clears the bar (see [Spacing](#spacing--layout-rhythm)). |

---

## Rich text (faction editor)

Backend multi-step faction form ([`decks/_form.blade.php`](../resources/views/decks/_form.blade.php)) loads **CKEditor 5** from CDN. Dark theme overrides live in a `<style>` block in that view (zinc surfaces, indigo focus). **Treat that block as part of the design system** for admin content editing; if theme changes, update alongside `sur-input` / card tokens.

---

## Progress & layout utilities

| Class | Use |
|-------|-----|
| `sur-progress-track` | Track: `h-2`, `rounded-full`, zinc-700 bg. |
| `sur-progress-fill` | Fill: indigo→violet gradient, `transition-all duration-300 ease-out`. |
| `sur-main` | Flex column main content wrapper in public layout. |

---

## Complete register — `sur-*` & related components in `app.css`

Alphabetical (includes `@layer components` and critical global hooks). **Implementations live in `app.css`** — this table is the index.

| Class / selector | Purpose |
|------------------|---------|
| `btn-sur-cookie-outline` | Cookie secondary button |
| `btn-sur-cookie-primary` | Cookie primary button |
| `body.sur-cookie-bar-visible` | Adds bottom padding when bar shown |
| `sur-account-grid-bg` | Account page grid overlay |
| `sur-account-radial-bg` | Account page indigo radial |
| `sur-btn-ghost` | Tertiary button |
| `sur-btn-primary` | Primary button |
| `sur-btn-secondary` | Secondary button |
| `sur-card` | Static elevated card |
| `sur-card-interactive` | Hover-lift card |
| `sur-cookie-bar` | Cookie bar container |
| `sur-cookie-category` | Cookie modal section spacing |
| `sur-cookie-fab` | Cookie settings FAB |
| `sur-faction-strip` | Horizontal strip; scrollbar hidden |
| `sur-footer-col` | Footer column + stagger animation |
| `sur-footer-heading` | Footer section title |
| `sur-footer-link` | Footer text link |
| `sur-input` | Text-like form control |
| `sur-landing-carousel-btn` | Carousel round control |
| `sur-link-nav` | Inline nav link |
| `sur-main` | Main flex column |
| `sur-nav-mobile-link` (+ `-active` / `-idle`) | Mobile drawer row |
| `sur-nav-pill` (+ `-active` / `-idle`) | Desktop nav pill |
| `sur-progress-fill` / `sur-progress-track` | Progress bar |
| `sur-reveal` / `sur-reveal--in` | Scroll-triggered fade/slide-in |
| `sur-share-copy-text-btn` | Share “copy as text” |
| `sur-site-footer` | Footer shell + top gradient hairline |
| `sur-site-header` (+ `--scrolled`) | Sticky header |
| `sur-skip-link` | Accessibility skip |
| `sur-social-btn` | Footer social icon button |
| `sur-scrollbar` | Opt-in scrollbar styling |
| `#shuffle-modal` (+ `::backdrop`, inner classes) | Shuffle wizard dialog |
| `#surCookieConsentModal` (+ `::backdrop`) | Cookie preferences dialog |
| `.faction-grid` / `.faction-item` / `.faction-chip` | Modal faction picker layout + chip |
| `.shuffle-modal-card` / `.shuffle-modal-scroll` / `.shuffle-modal-chrome` | Modal layout regions |
| `.shuffle-wizard-*` | Stepper UI |
| `.shuffle-step-content` | Step body transition |
| `.scroll-container` | Faction detail full-height scroll-snap |
| `@keyframes sur-footer-in` | Footer stagger entrance |

**Legacy / utility:** `.bg-options`, `.hero-height` (background positioning helpers).

---

## Border & shadow tokens (quick reference)

| Token use | Border | Background | Shadow |
|-----------|--------|------------|--------|
| Default card | `border-white/10` | `bg-zinc-900/80` | `shadow-xl shadow-black/40` (`sur-card`) |
| Softer card / legal | `border-white/8` | same | as `sur-card` override |
| Glass account | `border-white/10` | `bg-white/[0.04]` | `shadow-lg shadow-black/20` |
| Auth panel | `border-white/8` | `bg-zinc-900/80` | `shadow-2xl backdrop-blur-sm` |
| Section divider | `border-white/6` | — | `border-t` / `border-b` on sections |

---

## Residual drift & extractions

**Candidates** (not bugs — optional DRY):

| Item | Direction |
|------|-----------|
| `sur-panel-auth`, `sur-panel-glass`, `sur-tile-grid` | Extract when the same 7+ token string appears in 3+ files |
| `sur-checkbox`, `sur-btn-danger`, `sur-flash-*` | Extract when usage grows |

**Aligned in code:** Auth and account forms use `sur-input` / `sur-btn-*`; public CTAs and faction manager primary actions use `sur-btn-primary`; footer contact uses `sur-btn-ghost` variant.

---

## Future CSS extractions (optional tickets)

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

7. Map the feature to a **row in the UI concepts catalog** (or add one + CSS).  
8. Prefer **`sur-input`** for new fields on public/account forms.  
9. **Typography:** stay within [Nunito loaded weights](#typography--fonts); avoid unsourced fonts.  
10. **Motion:** document new durations/easing here; test with **reduced motion** enabled.  
11. **Backend:** keep sidebar/table consistency; use **`sur-btn-*`** for new primary actions.
