# Sites by Sara (SBS) — Design System & Page Construction Guide

> **Single Source of Truth for all SBS landing pages and sub-pages.**  
> Whenever instructed to **"follow the design file"**, use this document as the strict blueprint for colors, typography, layout, component architecture, spacing, buttons, and visual styling.

---

## 1. Brand Identity & Color Palette

The SBS visual language combines trusted enterprise stability with vibrant, modern energy using a curated palette:

### 1.1 Core Brand Colors
| Token Name | Hex Code | Purpose & Usage |
|---|---|---|
| `--brand-blue` | `#3A539B` | Primary brand identity, secondary buttons, primary checkmarks, borders, key links |
| `--brand-blue-hover` | `#2F437D` | Hover state for blue buttons/links |
| `--brand-blue-tint` | `#EEF2FA` | Soft background fills, highlighted card tags, icon backgrounds |
| `--brand-blue-subtle` | `#F6F8FD` | Extremely soft table/row tints, alternate section fills |
| `--brand-coral` | `#ea4e5f` | High-conversion accent, eyebrow dots, price tags, text links, urgent callouts |
| `--brand-coral-hover` | `#d43d4e` | Hover state for coral elements |
| `--brand-coral-tint` | `#FDEEEE` | Danger/alert tint, coral icon background discs |
| `--brand-peach` | `#FCEFE5` | Warm neutral accent, CTA banner backgrounds, outline button hover fills |
| `--brand-peach-hover` | `#F8E3D4` | Hover fill on peach backgrounds, border accents |
| `--brand-peach-tint` | `#FFF9F5` | Delicate warm card backdrops |

### 1.2 Brand Gradient
```css
--brand-gradient: linear-gradient(135deg, #0250c5 0%, #d43f8d 100%);
--brand-gradient-hover: linear-gradient(135deg, #0243a4 0%, #c0337d 100%);
```
- **Where to use:** Top Page Title Banner, Primary CTA Buttons (`.btn-primary`, `.btn-plan-primary`), "Most Popular / Featured" plan badges.
- **Rule:** Always pair with white text (`#FFFFFF`) and a subtle gradient box-shadow `0 4px 16px rgba(2, 80, 197, 0.28)`.

### 1.3 Neutrals, Backgrounds & Borders
```css
/* Text & Hierarchy */
--navy: #1E2140;          /* Main headings, card titles, high-emphasis body */
--navy-dark: #13152C;     /* Ultra-high contrast text */
--slate: #5F6368;         /* Subtitles, secondary copy, lead paragraphs */
--slate-light: #80868B;   /* Captions, footnotes, breadcrumbs, borders */
--slate-subtle: #9AA0A6;  /* Inactive states, placeholder text */

/* Surface Colors */
--bg-white: #FFFFFF;      /* Clean cards, pure surface */
--bg-light: #F9FAFD;      /* Alternate section backgrounds */
--bg-banner: #FCEFE5;     /* Warm CTA banner boxes */
--bg-callout: #FFFBF7;    /* Warm accent notes */

/* Borders */
--border: #DCE2EE;        /* Default borders on cards, tables, inputs */
--border-light: #ECEFF5;  /* Subtle dividers, feature row separators */
--border-card: #DFE4EE;   /* Outlines for pricing cards */
```

### 1.4 Status & Utility Accents
```css
--green: #1E8E3E;         /* Success checkmarks, verified badges */
--green-tint: #E6F4EA;    /* Background pill for verified status */
--yellow: #FBBC04;        /* Attention alerts, ratings */
--yellow-tint: #FEF7E0;
```

---

## 2. Typography System

### 2.1 Font Family
- **Primary Font:** `'Manrope', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif`
- **Import:**
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
```

### 2.2 Type Hierarchy & Scale

> **Standardized Title Rule (Font Weight & Size Consistency):**  
> All main titles (`h1`, `h2`, `.page-banner-h1`, `.h1-title`, `.h2-title`, `.story-title`, `.scorecard-callout-title`, `.quote-text`) strictly use **`font-weight: 700`** and the standardized title size **`clamp(1.85rem, 1.5rem + 1.2vw, 2.6rem)`**.  
> Colors may vary depending on context (e.g. `#FFFFFF` on the gradient banner, `var(--navy)` on light sections), but font size, weight, and line-height must be **identical across all main titles on all pages**.  
> **Secondary Bold Elements:** All other bold text (`h3`, `h4`, buttons, prices, eyebrows, badges, status chips, card titles, and `strong`/`b`) must use **`font-weight: 600`**.  
> **Strict No-Emoji Rule:** Never use emojis anywhere on the site. Always use crisp, scalable inline SVG icons styled with SBS palette tokens. This extends to every other text-glyph stand-in for an icon too — a trailing arrow character (`→`) on a link, an `&times;`/`×` close button, a text-only bullet used as a checkmark — none of these render consistently across fonts/platforms and none pick up `currentColor` the way an SVG does. The one exception is an arrow used mid-sentence in actual prose to mean "leads to" (e.g. "migrating from domainA.com → domainB.com") — that's language, not a UI icon standing in for a button/link affordance.

| Style | Font Size | Weight | Line Height | Letter Spacing | Color |
|---|---|---|---|---|---|
| **Page Banner H1** | `clamp(1.85rem, 1.5rem + 1.2vw, 2.6rem)` | `700` | `1.2` | `-0.025em` | `#FFFFFF` |
| **Page Banner Sub** | `clamp(1.15rem, 2.2vw, 1.45rem)` | `500` | `1.3` | `0.01em` | `rgba(255, 255, 255, 0.94)` |
| **H1 (Hero Heading)** | `clamp(1.85rem, 1.5rem + 1.2vw, 2.6rem)` | `700` | `1.2` | `-0.025em` | `var(--navy)` |
| **H2 (Section Titles)** | `clamp(1.85rem, 1.5rem + 1.2vw, 2.6rem)` | `700` | `1.2` | `-0.025em` | `var(--navy)` |
| **H3 (Card Titles / Callouts)** | `1.15rem - 1.35rem` | `600` | `1.35` | `-0.015em` | `var(--navy)` |
| **Eyebrow / Kicker** | `0.82rem` (13px) | `600` | `1.4` | `0.08em` (Uppercase) | `var(--slate)` |
| **Buttons & Interactive** | `0.95rem - 0.98rem` | `600` | `1.4` | `normal` | `#FFFFFF` / `var(--navy)` |
| **Plan Prices & Tags** | `2.1rem / 0.88rem` | `600` | `1` | `normal` | `var(--navy)` / `var(--brand-coral)` |
| **Lead Paragraph** | `clamp(1.05rem, 0.95rem + 0.3vw, 1.2rem)` | `400` | `1.65` | `normal` | `var(--slate)` |
| **Body Copy & Details** | `0.98rem` (15.5px) | `400 / 500` | `1.55` | `normal` | `var(--navy)` |
| **Footnote & Bold Emphasis** | `0.88rem` (14px) / `<strong>` | `600` | `1.5` | `normal` | `var(--slate)` |

---

## 3. Elevation, Shadows & Radii

### 3.1 Border Radii
```css
--radius-sm: 8px;       /* Tags, small pills, code badges */
--radius-md: 16px;      /* Standard cards, addon boxes, visual containers */
--radius-lg: 24px;      /* Main pricing cards, story visual wrappers, CTA banners */
--radius-xl: 32px;      /* Extra-large feature containers */
--radius-pill: 9999px;  /* Buttons, status chips, notification tags */
```

### 3.2 Shadows
```css
--shadow-subtle: 0 1px 3px rgba(30, 33, 64, 0.06), 0 4px 10px rgba(30, 33, 64, 0.04);
--shadow-card: 0 1px 3px rgba(30, 33, 64, 0.08), 0 4px 14px rgba(30, 33, 64, 0.05);
--shadow-card-hover: 0 12px 28px -6px rgba(30, 33, 64, 0.12), 0 4px 12px rgba(30, 33, 64, 0.06);
--shadow-floating: 0 14px 36px -4px rgba(30, 33, 64, 0.12), 0 2px 8px rgba(30, 33, 64, 0.04);
--shadow-featured: 0 16px 40px -8px rgba(58, 83, 155, 0.22), 0 4px 14px rgba(30, 33, 64, 0.06);
```

---

## 4. Spacing, Containers & Layout Rules

### 4.1 Max Widths
- **Main Container:** `max-width: 1200px; padding: 0 24px; margin: 0 auto;`
- **Narrow Content (Headers, FAQs, Centered Copy):** `max-width: 720px; margin: 0 auto;`
- **Banner / Title Inner:** `max-width: 860px; margin: 0 auto;`

> **Anti-Pattern — Shorthand Padding Overriding Side Padding:** Never add vertical-only spacing to an element that also carries `.container` by writing `padding: <top> 0 <bottom>` (3-value) or `padding: <vertical> 0` (2-value). Both forms explicitly set left/right to `0`, which wins over `.container`'s `padding: 0 24px` (same specificity, later in source order) — the 24px side padding silently disappears. It's masked on wide viewports (the `max-width: 1200px` auto-margin still creates visual breathing room) but breaks completely once the container goes full-width on mobile/tablet, leaving content flush against the screen edge. Always set `padding-top` / `padding-bottom` individually instead, and never touch `padding-left`/`padding-right` on a `.container` element.

### 4.2 Section Vertical Rhythm
- **Default Section Padding:** `padding: clamp(70px, 8vw, 110px) 0;`
- **Tight Section Padding:** `padding: clamp(40px, 5vw, 65px) 0;`
- **Hero Section:** `padding: clamp(48px, 6vw, 76px) 0 clamp(40px, 6vw, 70px);`
- **Page Title Banner:** `padding: clamp(52px, 6vw, 76px) 24px;`

> **Anti-Pattern — Stacked Whitespace:** Two consecutive sections that are both plain white with no border/background change will double up their `.section-space` padding (bottom of one + top of the next), producing up to ~220px of dead space. This is especially visible when the first section ends in something visually light (a disclaimer line, a small note). When that happens, override `padding-bottom` on the first section to a smaller explicit value (e.g. `clamp(30px, 4vw, 50px)`) instead of leaving the default `section-space` value on both sides.

---

## 5. Standard Component Specifications

### 5.1 Top Page Title Banner (Full-Width Gradient)
Placed immediately inside `<body>` before any content section.  
**Design Standard:**
- Clean, focused, and high-impact.
- Gradient background with soft layered atmospheric radial meshes (`radial-gradient` + blurred floating ambient pseudo-elements).
- Centered bold H1 title + clear subtitle in parentheses.
- **No pill badge on top** (per brand direction: clean and un-cluttered).

```html
<section class="page-title-banner" aria-label="Page Title">
  <div class="page-title-banner-mesh" aria-hidden="true"></div>
  <div class="container page-title-inner">
    <h1 class="page-banner-h1">Service Name / Page Title</h1>
    <p class="page-banner-sub">(Subcategory / Short Scope)</p>
  </div>
</section>
```

```css
.page-title-banner {
  position: relative;
  overflow: hidden;
  background: var(--brand-gradient);
  padding: clamp(52px, 6vw, 76px) 24px;
  text-align: center;
  color: #FFFFFF;
  box-shadow: 0 6px 28px rgba(2, 80, 197, 0.18);
}
.page-title-banner::before {
  content: "";
  position: absolute;
  inset: 0;
  background-image:
    radial-gradient(circle at 14% 20%, rgba(255, 255, 255, 0.2) 0%, transparent 40%),
    radial-gradient(circle at 86% 80%, rgba(212, 63, 141, 0.32) 0%, transparent 50%),
    linear-gradient(180deg, rgba(255, 255, 255, 0.08) 0%, rgba(0, 0, 0, 0.08) 100%);
  pointer-events: none;
}
.page-title-banner-mesh {
  position: absolute;
  inset: 0;
  pointer-events: none;
  overflow: hidden;
}
.page-title-banner-mesh::before,
.page-title-banner-mesh::after {
  content: "";
  position: absolute;
  border-radius: 50%;
  filter: blur(55px);
  opacity: 0.22;
}
.page-title-banner-mesh::before {
  width: 320px;
  height: 320px;
  background: #FFFFFF;
  top: -120px;
  left: 8%;
}
.page-title-banner-mesh::after {
  width: 280px;
  height: 280px;
  background: var(--brand-coral);
  bottom: -80px;
  right: 10%;
}
.page-title-inner {
  position: relative;
  z-index: 2;
  max-width: 860px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.page-banner-h1 {
  font-size: clamp(1.85rem, 1.5rem + 1.2vw, 2.6rem);
  font-weight: 700;
  line-height: 1.2;
  color: #FFFFFF;
  letter-spacing: -0.025em;
  margin: 0 0 10px;
  text-shadow: 0 2px 16px rgba(2, 40, 100, 0.3);
}
.page-banner-sub {
  font-size: clamp(1.15rem, 2.2vw, 1.45rem);
  font-weight: 500;
  color: rgba(255, 255, 255, 0.94);
  letter-spacing: 0.01em;
  margin: 0;
  text-shadow: 0 1px 8px rgba(0, 0, 0, 0.18);
}
```

---

### 5.2 Buttons System
All SBS buttons use full pill rounding (`border-radius: 9999px`), bold weight (`700`), and smooth transitions.

```html
<!-- Primary Action Button -->
<a href="/contact/" class="btn btn-primary">Book a Free Consultation</a>

<!-- Secondary / Outline Button -->
<a href="#pricing" class="btn btn-outline">View Pricing & Plans</a>

<!-- Card Action Buttons — every priced card/addon box gets one -->
<a href="https://order.sitesbysara.com/configure?id=<ID>" class="btn-plan btn-plan-primary">Order Now</a>
<a href="https://order.sitesbysara.com/configure?id=<ID>" class="btn-plan btn-plan-outline">Order Now</a>
```

> **Card button rule:** Every pricing card and every priced addon box uses the label **"Order Now"**, linking to `https://order.sitesbysara.com/configure?id=<ID>` — a deep link into the live `/configure` wizard that pre-selects that exact service/tier. The `<ID>` must be looked up per exact tier (not guessed or reused across tiers) from the "Configure Wizard Links" reference tool; a compound ID like `122-1` or `130-1` is a single token, used exactly as given. If a card's displayed price/copy doesn't correspond to any real entry in that tool (this happens — some live-site copy doesn't match a configurator line item 1:1), leave that button's existing label and destination alone rather than mislabeling it "Order Now" with nowhere real for it to go. This replaced the older "Book Consultation" / "Select Service" / "Select Plan" card-button labels sitewide (2026-09-13) — never reintroduce those on a new page.

```css
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font);
  font-size: 0.98rem;
  font-weight: 700;
  padding: 13px 28px;
  border-radius: var(--radius-pill);
  cursor: pointer;
  transition: all 0.2s ease;
  border: 1.5px solid transparent;
  text-decoration: none;
  white-space: nowrap;
}

/* Primary Button: Gradient Fill + Gradient Hover Glow */
.btn-primary {
  background: var(--brand-gradient);
  color: #FFFFFF;
  box-shadow: 0 4px 16px rgba(2, 80, 197, 0.28);
}
.btn-primary:hover {
  background: var(--brand-gradient-hover);
  transform: translateY(-1px);
  box-shadow: 0 6px 22px rgba(212, 63, 141, 0.35);
}

/* Outline Button: Crisp Blue Border + Warm Peach Hover */
.btn-outline {
  background-color: transparent;
  color: var(--brand-blue);
  border-color: var(--brand-blue);
}
.btn-outline:hover {
  background-color: var(--brand-peach);
  border-color: var(--brand-blue);
  color: var(--brand-blue);
}

/* Pricing Card Buttons (Full Width) */
.btn-plan {
  width: 100%;
  display: block;
  text-align: center;
  padding: 12px 20px;
  border-radius: var(--radius-pill);
  font-weight: 700;
  font-size: 0.95rem;
  transition: all 0.2s ease;
  margin-bottom: 24px;
}
.btn-plan-primary {
  background: var(--brand-gradient);
  color: #FFFFFF;
  border: none;
  box-shadow: 0 4px 12px rgba(2, 80, 197, 0.25);
}
.btn-plan-primary:hover {
  background: var(--brand-gradient-hover);
  transform: translateY(-1px);
  box-shadow: 0 6px 18px rgba(212, 63, 141, 0.32);
}
.btn-plan-outline {
  background-color: transparent;
  border: 1.5px solid var(--border);
  color: var(--navy);
}
.btn-plan-outline:hover {
  border-color: var(--brand-blue);
  color: var(--brand-blue);
  background-color: var(--brand-peach);
}
```

#### 5.2.1 Every Interactive State Must Explicitly Restate Its Own Color (Live-Theme Bleed)
**Real incident, found on the live site (2026-09-16):** once pasted into WordPress, several buttons and links rendered invisible text on hover or on focus — e.g. a white "SUBSCRIBE"-style button losing its white text on hover, a coral "Read less" toggle going white-on-white when focused. Root cause: our own CSS only declared `color` for *some* interaction states (commonly the base state and `:hover`) and never declared it at all for `:focus`/`:focus-visible`/`:active`. Wherever our rule was silent for a given state, the browser fell through to the live theme's own generic `a`/`button` state styling — which uses a completely different color — instead of inheriting anything from us. This is not a specificity fight we lost; it's a rule we never wrote.

**The fix, and the rule going forward:**
- **Any class that sets `color` (or a background a text color depends on for contrast) in its base rule must restate that exact property in `:hover`, `:focus`, `:focus-visible`, AND `:active` — chained into one selector list, one shared declaration block.** Never leave a state to "inherit" styling from a sibling state's rule; write it out every time, even when the value doesn't change between states (e.g. `.testimonial-toggle` only visually changes on `:hover`, but `:focus`/`:active` still need their own explicit `color: var(--brand-coral-hover) !important;` line so the theme has nothing to fill in).
  ```css
  /* WRONG — :focus and :active are silently left to the theme */
  .btn-primary { color: #FFFFFF; background: var(--brand-gradient); }
  .btn-primary:hover { color: #FFFFFF; background: var(--brand-gradient-hover); }

  /* RIGHT — every interactive state is explicit */
  .btn-primary { color: #FFFFFF; background: var(--brand-gradient); }
  .btn-primary:hover,
  .btn-primary:focus,
  .btn-primary:focus-visible,
  .btn-primary:active {
    color: #FFFFFF !important;
    background: var(--brand-gradient-hover);
  }
  ```
- **`!important` on the `color` (and `background-color` where contrast depends on it) declaration is deliberate, not sloppy** — we have direct, repeated evidence the live theme's own state styling wins the cascade otherwise. This matches precedent already in the codebase before this fix (`.cta-button`, `.custom-footer-link-strong`, `.partner-popup-btn` all already used `!important` for exactly this reason). Don't add `!important` anywhere else on these rules — only on the color-contrast-critical properties.
- **Applies to every clickable element with its own text/icon color**: `.btn-primary`/`.btn-outline`/`.btn-plan-primary`/`.btn-plan-outline`, every `.story-link`-style inline text link, icon-only buttons whose SVG uses `stroke="currentColor"` (a close "×" button, a slider nav arrow, a hamburger icon), circular social icons, tab pills, and any custom `<a>`/`<button>` styling anywhere in `header.html`/`footer.html`/every landing page.
- **Does not apply to purely decorative hover changes** on non-interactive elements (a `<div>` card's `transform`/`box-shadow`/`border-color` lift-on-hover) — those aren't focusable and don't carry a theme-bleed risk. Don't blanket-apply `:focus` states to things a user can't focus.
- When auditing a page for this, grep for `:hover {` blocks whose body contains a real `color:` property (not `border-color`/`background-color` as a false-positive substring match) and confirm a `:focus` rule exists for that same selector — that's the fast way to find every remaining gap.

---

### 5.3 Eyebrow / Kicker Badge
Appears above section titles to categorize context:
```html
<div class="eyebrow">
  <span class="eyebrow-dot"></span>
  Zero Data Loss
</div>
```
- Dot is `7px × 7px` circle with `background-color: var(--coral);` (or `var(--brand-blue)`).
- Text is `0.82rem`, uppercase, `font-weight: 600`, letter-spacing `0.08em`.

---

### 5.4 Hero Section Layout
- Two-column grid (`1.05fr 0.95fr`) with `gap: clamp(40px, 6vw, 80px)`.
- Left: Eyebrow + `h2-title` + `lead-text` + `.btn-group` + `.hero-footnote`.
- Right: `.hero-visual-wrap` containing `.hero-image-card` with 4:3 WebP dashboard mockup and subtle border + rounded corners (`border-radius: 20px`).

---

### 5.5 Alternating Storytelling Feature Rows (High Breathing Room)
Used for deep feature breakdowns:
```html
<div class="story-row">
  <div class="story-text-col">
    <div class="eyebrow"><span class="eyebrow-dot"></span>Category</div>
    <h2 class="story-title">Heading</h2>
    <p class="story-desc">Detailed explanation...</p>
    <a href="#pricing" class="story-link">Action link →</a>
  </div>
  <div class="story-visual-col">
    <div class="story-image-card">
      <img src="images/name.webp" alt="..." width="520" height="390" />
    </div>
  </div>
</div>

<!-- Alternating reversed row -->
<div class="story-row is-reversed"> ... </div>
```
- **Spacing:** `gap: clamp(40px, 6vw, 80px); margin-bottom: clamp(60px, 8vw, 100px);`
- **Links (`.story-link`):** `color: var(--brand-coral); font-weight: 600;` transitions to `var(--brand-coral-hover)` with rightward nudge `transform: translateX(4px)`.

---

### 5.6 Pricing Grid & Cards (4-Col or 3-Col)
- Outer container has subtle border and card radius (`--radius-lg: 24px`), typically wrapped in a `.pricing-outer-container` (white surface, `--border-card`, `--shadow-card`, generous internal padding) that also holds the shared top bar, included-inclusions note, dividers, and any secondary offer box for the same pricing section.
- **Featured Card (`.is-featured`):**
  - Relative elevation with gradient top badge (`Most Popular` / `Recommended`).
  - Outline with `var(--brand-blue)` and subtle floating box-shadow.
  - Primary button (`btn-plan-primary`).
  - Feature checkmarks tinted in brand blue (`#3A539B`).
- **Standard Cards:** Clean white surface, gray border, green checkmarks (`#1E8E3E`), outline button.
- **Every card must contain its own `plan-features-label` + `plan-features-list`.** Do not hoist shared inclusions (e.g. "Mobile-responsive", "Training included") into one shared row below the grid — put them inside each card, even when the same 3–4 bullets repeat across every tier. A shared row below the grid reads as incomplete/unfinished on review.
- **Badge honesty rule:** Only give a card a `featured-badge` when you have a literal, factual descriptor for it — either the source data names it that way (e.g. `Services-info.html` literally says `"Standard (Most Popular)"`), or the descriptor is objectively true and derivable from the data itself (e.g. `"Fewest Pages"`, `"Single-Page Store"`). Never invent a popularity/value claim (`"Most Popular"`, `"Best Value"`, `"Most Common Starting Point"`) that isn't stated in the source.
- Standard class names to reuse verbatim across pages: `pricing-grid-4`, `pricing-card-col`, `featured-badge`, `plan-name`, `plan-price-row`, `plan-price`, `plan-period`, `plan-subtext`, `plan-features-label`, `plan-features-list`, `btn-plan` / `btn-plan-primary` / `btn-plan-outline`. Don't rename these per page — consistency across pages matters more than a locally "nicer" name.
- **Checkmark icon (standardized 2026-09-16):** every `plan-features-list li` checkmark — and any other "included/differentiator" checklist bullet sitewide, like `about.html`'s "What Sets Us Apart" cards — uses this exact path, never a smaller/cramped one:
  ```html
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M20 6 9 17l-5-5"></path>
  </svg>
  ```
  The previous path (`M9 12l2 2 4-4`) drew a check confined to the lower-right quadrant of the 24×24 box, so even at 16–18px it read as small and lopsided. This path spans corner-to-corner of the same viewBox, so it reads as a bold, correctly-proportioned check at the same rendered size. Color still comes from `currentColor` + a parent rule (`.pricing-card-col.is-featured` → brand blue, `:not(.is-featured)` → green per the Standard/Featured split above) — only the `<path d>` and `stroke-width` changed, not the color mechanism. Don't confuse this with the unrelated shield-plus-check compound badge icon (`.hero-badge-pill`, `.app-icon-img-wrap`) used for "verified/secure" trust badges elsewhere — that one keeps its own two-path shield shape.

#### 5.6.1 Many-Tier Services — One Card Per Real Tier (Superseded 2026-09-13)
**Deprecated approach — do not use:** this section previously said to group many tiers (e.g. a page-count-scaled WordPress build) into 3–4 representative "starting at $X" cards with the full list hidden behind a `<details class="pricing-breakdown-details">` disclosure. **This was explicitly rejected by the client**: every real tier is individually orderable (each has its own ID in the `order.sitesbysara.com` configure wizard — see §5.2's Order Now rule), and a grouped "starting at" card can only link to one of several real Order Now destinations, which is misleading. `custom-development.html`'s WordPress Website section was rebuilt from this pattern into 11 separate cards as the reference example.

**Current rule:** give **every** real tier its own full `pricing-card-col`, each with its own exact price and its own `Order Now` link — never a range, never "starting at." Keep the class name `pricing-grid-4` regardless of tier count; the grid simply wraps into additional rows (11 tiers in a 4-column grid wraps to 4+4+3). Only the smallest tier may carry an objectively-derivable badge (e.g. `"Fewest Pages"`); do not invent a name for tiers the source only labels by quantity/range (e.g. keep `"21–30 Pages"` as the card title verbatim, not "Growth" or "Enterprise").

### 5.7 Addon Services Grid
- 2x2 or 4-column clean card grid with `--bg-light` or pure white.
- Features prominent price badge `.addon-price-tag` styled with `color: var(--brand-coral)` and bold typography.

### 5.8 8-Step Scope / Process Cards
- Compact 4-column responsive grid.
- Each step features a numeric badge (`.scope-num`):
  ```css
  .scope-num {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: var(--brand-blue-tint);
    color: var(--brand-blue);
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  ```

### 5.9 FAQ Accordion (`<details>` / `<summary>`)
- No heavy JS dependencies — uses native semantic `<details class="faq-item">`.
- Distinct border divider, smooth cursor hover, custom `+` icon that rotates `45deg` into an `×` when open.

### 5.10 Final CTA Banner Box
```html
<section class="cta-banner-section">
  <div class="container">
    <div class="cta-banner-box">
      <div class="cta-banner-left">
        <h2 class="h2-title">Headline</h2>
        <p class="lead-text">Sub-copy...</p>
        <a href="/contact/" class="btn btn-primary">Primary Action</a>
      </div>
      <div class="cta-banner-checklist">
        <!-- Bullets with checkmarks -->
      </div>
    </div>
  </div>
</section>
```
- Background is `--brand-peach` (`#FCEFE5`).
- Border: `1.5px solid var(--brand-peach-hover)`.

---

### 5.11 Services Directory Grid (All-Services Page)
Used on the top-level `all-services.html` index that lists every landing page as a card. Card content order is fixed: **icon → title → short description → price range → "See More" button.**

```html
<div class="service-directory-card">
  <div class="service-directory-icon">
    <svg><!-- niche-relevant icon, 24-26px --></svg>
  </div>
  <h3 class="service-directory-title">Service Name</h3>
  <p class="service-directory-desc">One or two sentences, pulled from that page's own hero/meta description — never new copy invented for the directory.</p>
  <div class="service-directory-price-row">
    <span class="service-directory-price-label">Price Range</span>
    <span class="service-directory-price-value">$X – $Y</span>
  </div>
  <a href="service-page.html" class="service-directory-btn">See More</a>
</div>
```

- Grid is `repeat(3, 1fr)` on desktop — **3 cards per row, not 2 or 4** — collapsing to `repeat(2, 1fr)` at `≤1024px` and `1fr` at `≤600px`.
- When the card count isn't a multiple of 3, center the remainder row instead of leaving it left-aligned: e.g. for 4 cards, target the last card with `grid-column: 2;` at desktop so it centers under the middle column on its own row. Reset to `grid-column: auto;` inside the ≤1024px breakpoint where the grid drops to 2 columns.
- The description and price range must be pulled from the linked page's own content (hero copy, meta description, pricing section) — the directory is a summary, not a new source of claims.
- Every time a new service landing page is added, add its card here in the same pass — the directory must stay in sync with the set of pages that exist.

---

### 5.12 Site Header
Standalone reusable component, built in its own `header.html` file (same pattern as `title-banner.html` and `footer.html`).

**Design Standard — white, single-row, sticky.** The original build was two-row (see history note below); it was rebuilt single-row once the client supplied a smaller reference menu (`sbs-megamenu-preview.html`) that collapsed 7 top-level items down to 5 (Company, Services, Portfolio, Contact, Blog) — logo + 5 nav items + 2 buttons + hamburger fits `max-width:1200px` comfortably where 7 items didn't.
- **`.custom-header-inner`:** one flex row — logo (left), nav (center, `flex:1` so it centers in the remaining space), action buttons + hamburger (right).
- **Desktop dropdowns are JS-driven, not CSS-only `:hover`.** This changed from the earlier CSS-only approach because the Services item is a 4-column mega-menu that needs a dimming backdrop (`.custom-mega-overlay`) synced to open/close state — a separate overlay element can't react to a pure-CSS `:hover` on a distant sibling without JS. One shared `openDropdown()`/`closeAllDropdowns()` pair drives both the simple one-column dropdowns (Company/Portfolio/Contact) and the mega dropdown (Services): hover-intent on desktop (with a 160ms close delay so moving the mouse from trigger to panel doesn't close it), click-to-toggle (also works on desktop, required on touch/mobile-width-but-not-hamburger cases), Escape key, backdrop click, and outside click all close it.
- **Mega dropdown (`.custom-dropdown-mega`):** `position:fixed; top:88px` (clears the single-row header height), centered via `left:50%; transform:translateX(-50%)`, `width:min(1200px, calc(100% - 32px))`. 4 columns (`.custom-mega-grid`), each with a colored icon + title (`.custom-mega-col-icon.icon-blue/-coral/-peach/-green`) and one or more labeled subgroups (`.custom-mega-sub-label`).
- **"Coming Soon" convention:** every mega-menu / mobile-accordion service link that maps to a page we've actually built gets that page's real href (sourced from `all-services.html`'s own "See More" links — never invented). Every item with no built page gets `href="#"`, class `.custom-mega-link.is-soon` (or `.custom-m-link.is-soon` on mobile), and a trailing `.custom-badge-soon` pill reading "Coming Soon". A delegated click handler on `.is-soon` calls `preventDefault()` so the dead `#` href doesn't jump the page to top. When a reference menu lists several items that we already built as one merged page (e.g. "WooCommerce Stores" + "WooCommerce Design Refresh" + "Add Pages/Posts" all live inside `woocommerce-stores.html`), only the single real page is listed — the other line items are dropped, not duplicated with the same link.
- **Mobile (`≤992px`):** nav + both action buttons hide; only logo + hamburger remain. The hamburger opens a right-side off-canvas panel (`position:fixed`, `translateX(100%)` → `translateX(0)`, dark overlay behind it) containing the same 5 sections rebuilt as JS accordions (`.custom-m-acc-item`, single-open-at-a-time, `max-height` transition) rather than native `<details>` — kept consistent with the desktop mega-menu's JS-driven approach and its Coming Soon badge logic. Both action buttons repeat at the bottom of the panel, full-width.
- **Never change, drop, or rewrite a link when building this component from a client-supplied menu export**, other than the merge/Coming-Soon handling above, which is an explicit, instructed exception — not a silent edit.
- Sticky via `position: sticky; top: 0` (not `fixed` — avoids needing to manually offset page content). A `scroll` listener toggles `.custom-is-scrolled` past `4px` of scroll, adding a soft shadow so the header reads as flush/seamless at the very top of the page and gains definition once content scrolls beneath it.
- *History:* a single-row layout was tried first for the ORIGINAL 7-item menu and rejected — with one item (Marketing) carrying a 10-item mega-menu, everything fighting for one row inside `max-width:1200px` overflowed regardless of viewport width, so it was split into two rows. That two-row build stayed in place until the client-supplied replacement menu (5 items, all under one `Services` mega-menu) made single-row viable again.
- **`position: sticky` breaks silently inside Elementor** if any ancestor between the header and the page (a section/container/column, or `.elementor-widget-wrap`) has `overflow` set to anything but `visible` — Elementor sets this automatically in several cases (any section using a Shape Divider, or manually via Advanced → Overflow). First check Elementor's own Overflow setting on the header section and its parents. As a defensive backstop, the header's script also walks up from itself on load (and once more ~1s later, to catch anything Elementor applies asynchronously) and forces any non-`visible` ancestor back to `visible` — stopping before `<body>`/`<html>` so it doesn't fight the theme's own horizontal-scroll fix or the off-canvas menu's body-scroll-lock.
- **Logo load priority:** the header logo is the page's LCP element and must never wait behind normal image discovery. It carries `loading="eager"`, `fetchpriority="high"`, `decoding="sync"`, and the file opens with a `<link rel="preload" as="image" fetchpriority="high">` pointing at the same URL — without these, a noticeable load delay shows up on every page even though the image is small, because the browser (or an overly-aggressive theme/plugin lazy-load script) doesn't otherwise know it's above-the-fold and urgent.

#### 5.12.1 WordPress-Safe Class Naming (applies to every pasteable component)
`header.html` and `footer.html` are pasted directly into a live WordPress site (via an Elementor HTML widget) alongside a theme and other plugins whose CSS we don't control. Generic class names collide:
- **Every class in `header.html` and `footer.html` is prefixed `custom-`** (e.g. `.container` → `.custom-container`, `.btn-primary` → `.custom-btn-primary`, `.header-menu` → `.custom-header-menu`). This was retrofitted after the unprefixed version's `.container`/`.btn`/`.btn-primary` (and the reset's bare `a`/`ul`/`button` selectors) leaked into and altered unrelated elements elsewhere on the live page — a real incident, not a hypothetical.
- IDs (`id="siteHeader"`, `id="hamburgerBtn"`, etc.) were left unprefixed — they're already page-unique by definition and specific enough (camelCase, multi-word) to not collide.
- **When doing a bulk rename like this, watch for two traps:** (1) substring collisions — `.header-top` naively string-replaced will also corrupt `.header-top-inner`; match whole tokens only (not preceded/followed by a word character or hyphen). (2) prose comments that happen to contain the same word for an unrelated reason — e.g. a comment explaining Elementor's own DOM structure said "...a section/container/column..." where "container" refers to Elementor's concept, not our `.container` class; blindly renaming inside comments would have corrupted that sentence into nonsense. Scope the rename to actual CSS selectors and `class="..."` attribute values, not the entire file text.
- This prefixing rule applies to **any future standalone component file** meant to be pasted into the live site outside of our own landing pages (which stay unprefixed, since each landing page is a fully self-contained document with no competing CSS on the same page).

---

### 5.13 Site Footer
Standalone reusable component, built in its own `footer.html` file (same pattern as `title-banner.html`) — not spliced into the individual landing pages by default.

**Design Standard — light, 4-column grid with vertical link lists. Not a dark mega-footer, not a single flattened row either — both were tried and corrected on client review.**
- Light surface (`--bg-light: #F9FAFD`) with a `1px solid var(--border-light)` top border as the only separation from page content above.
- **4-column grid on desktop** (`1.3fr 1fr 1fr 1.1fr`):
  1. **Brand** — real image logo (`<img>`, not styled text), one-sentence description, all 7 of the live site's social links (Facebook, Instagram, Twitter, Pinterest, LinkedIn, YouTube, TikTok) as small circular icons in a `flex-wrap` row — match the live site's actual social link set exactly rather than curating it down; use the link's real destination even if the live site's own CSS class name for it is mislabeled (e.g. its "TikTok" link is classed `social medium` on the live site — go by the href, not the class).
  2. **Services** — vertical link list to every landing page, ending in a bold coral "View All Services →".
  3. **Company** — vertical link list (About Us, Portfolio, Awards, Blog, Contact).
  4. **Get in Touch** — in this exact order: the site's actual `book-free-consultation.jpg` promo image (sized large enough to keep its own baked-in "Book a Free Consultation" text legible — 140px, not a small icon-sized crop), then phone, then email, each on its own line below the image.
- A too-sparse 4-link single row and an over-cropped 56px version of the same image were both tried first and corrected — the working balance is the full column layout above with the promo image large enough to read.
- Below a second hairline divider: a compact bottom bar with the copyright/DBA disclosure line on the left and Terms of Service / Privacy Policy on the right.
- Collapses to 2 columns at `≤992px`, 1 column at `≤600px`.
- Every link must be a real, confirmed URL — verified against the live site's actual nav/footer hrefs, never guessed. Internal links to our own pages use relative filenames (`all-services.html`); everything else points at the confirmed live `sitesbysara.com` path.
- **Logo:** use the real brand logo image, not styled text — pulled from the live site's actual asset URL. If the source PNG has a baked-in light background (not transparent), placing it on an equally light footer background needs no extra framing; only wrap it in a white card if the footer surface is dark enough to clash.

---

### 5.14 Homepage
Split into two standalone reusable components — `home-hero.html` and `home-body.html` — same pasteable-component pattern as `header.html`/`footer.html`, **not** a single self-contained landing page. Live paste order: `home-hero.html` → Trustindex testimonial shortcode → `home-body.html`.

- **Why split:** the live homepage's testimonial slider is a Trustindex plugin widget rendered via a WordPress shortcode. Its container carries `data-pid="wp-widget"` and no portable widget-ID — the rendering is tied to the WordPress plugin/account context, not a generic copy-paste embed, so it can't be reliably reproduced in static HTML. `home-hero.html` covers the hero only; the real Trustindex shortcode gets pasted directly into WordPress right after it; `home-body.html` picks up from the trust ribbon onward.
- **`home-body.html` was briefly split a second time** (into `home-body-part-1.html` / `home-body-part-2.html`) to make room for a client-supplied portfolio shortcode in place of the hand-built portfolio section — then un-split once the client instead handed over real markup/CSS for a custom portfolio interaction to integrate directly into the page. **Don't re-split unless a genuine non-reproducible WordPress widget (like Trustindex) requires it** — a client handing over their own HTML/CSS for a section is not that case; reimplement it in our own component vocabulary instead, the same as everything else on this page.
- **First pass copied the live page's flat structure with only new colors — rejected.** The client wanted an actual redesign (new structure, genuinely more modern hero, additional real content pulled from elsewhere on the site), not a reskin of the existing layout. The rule going forward: reproducing the live homepage's section order 1:1 with our palette is not sufficient — pull our own established component vocabulary (two-column hero grids, trust ribbons, alternating story rows) the same way every service landing page does, and add grounded content the live homepage doesn't currently show if it makes the page more complete.
- **Hero is a real two-column layout, not a centered text block:** left side is eyebrow + H1 + subhead + button group + a small real trust line (star icons + "Excellent — 56 Google Reviews", sourced from the Trustindex badge's own real numbers); right side is a floating stat-card composition (`.home-hero-stat-card`, absolutely positioned, staggered) showing three grounded facts — "Since 2007", "200+ Customer success stories", "Award-Winning" — instead of a photo. This avoids needing a generated hero image entirely (all real text/numbers, no §6 image-prompt workflow needed) while still giving the hero actual visual depth. Collapses to a static stacked column below `900px`.
- **`home-body.html` adds two sections beyond what the live homepage shows**, both built from real content already on other pages in this project rather than invented copy:
  1. **Trust/stats ribbon** directly under the hero split point — four grounded numbers: `2007` (since, matches the live homepage's own text), `200+` (success stories, matches the live final-CTA headline), `56` (Google reviews, from the Trustindex badge), `11` (the exact count of real award/recognition images in the Awards marquee below — not a rounded guess).
  2. **"What We Do" services overview** — a 6-card grid linking to `custom-development.html`, `woocommerce-stores.html`, `shopify-ecommerce-store.html`, `cybersecurity-packages.html`, `email-setup-migration.html`, `site-audit-priority-fixes.html`. Each card's icon and description is copied verbatim from that exact page's own `all-services.html` directory card (same "pulled from the linked page's own content" rule as §5.11) — not new copy. Ends in a "View All Services" button to `all-services.html`. This is homepage → directory navigation, which is a different case from the individual-service-page rule in §7.6 — that rule is about not adding a browse-all link *on* a service page, not about the homepage linking to the directory.
- **Portfolio section (`.home-portfolio-*`) — hover-to-scroll full-page preview.** The client supplied reference markup/CSS using a fixed-height frame (`overflow: hidden`) containing a full, un-cropped page screenshot that pans upward on hover to reveal the rest of the page, then pans back down on mouse-leave. Reimplemented in our own tokens/classes rather than using the client's raw CSS verbatim (`.homework`/`.pageh`/`.sitehover-N`):
  - `.home-portfolio-frame` is a fixed `260px` box with `overflow: hidden`; the `<img>` inside is `width: 100%; height: auto` (so it renders at its true, un-cropped tall aspect ratio) with `transition: transform 6s ease`.
  - Resting state: `transform: translateY(0)` — shows the top of the page.
  - `.home-portfolio-card:hover .home-portfolio-frame img { transform: translateY(calc(-100% + 260px)); }` — `-100%` resolves against the image's own *rendered* height (not the frame's), so this works correctly regardless of each screenshot's actual aspect ratio; adding back `260px` leaves the bottom of the page exactly flush with the frame's bottom edge with zero gap, verified via computed `getBoundingClientRect()` math, not just eyeballed.
  - Kept the existing `.home-portfolio-card`/`.home-portfolio-card-footer`/`.home-portfolio-name`/`.home-portfolio-visit` shell (border, shadow, hover-lift) — only the image-frame internals changed from a static `object-fit: cover` crop to this interactive pan.
  - Real content unchanged: same 3 real sites (Leavity Bread, Girlyish Skincare, Arbor Plus), same real screenshot images and live URLs the client's snippet pointed at, same real intro paragraph.
- **Content is real, pulled live from `sitesbysara.com`** — hero headline/subhead, all 11 award badge images, the 3 real portfolio screenshots with their real live-site URLs, both Press & Publications logos/articles (BizWeekly, USA News), and the closing stats CTA. Award/portfolio/press images point directly at their real existing `sitesbysara.com` media-library URLs — this is real existing content, not a generated mockup, so §6's image-prompt workflow does not apply here.
- **Styling follows our system, not the live site's current button colors** — e.g. the live hero uses plain solid coral/white buttons; we use the established `.btn-primary` gradient for the strongest CTA ("Let's Discuss Your Project") and a new light-on-dark outline variant for the secondary action, matching how every other landing page treats its primary consultation CTA.
- **WordPress-safe class naming applies** (§5.12.1) — both files are pasted into the live homepage alongside the header, footer, and the Trustindex widget, so every class is prefixed `home-` (distinct from header/footer's `custom-` prefix, but same methodology) and every reset rule is scoped under a root class, never bare `*`/`a`/`img`.
- **Awards marquee** is a pure-CSS infinite scroll (the image list duplicated once for a seamless loop via `translateX(-50%)`), not the live site's Owl Carousel JS — avoids adding a JS dependency for a decorative logo strip. Respects `prefers-reduced-motion` by disabling the animation and falling back to manual horizontal scroll.
- **Awards marquee redesign (2026-09-16):** the original version floated the raw badge PNGs directly on the section's flat gray background at a fixed `120px` height — every badge has different baked-in transparent padding, so they visually varied in size/weight next to each other and read as dated. Fixed by wrapping each badge in its own `.home-award-tile` (white card, `var(--border-light)` border, `var(--shadow-card)`, fixed `172×128px` box, `object-fit: contain` on the image) — the same "logo sits in a normalized white slot" treatment as `web-awards.html`'s `.award-card-badge`, just without that page's title/link underneath since this is a compact marquee, not a full showcase grid. Added `.home-awards-track-wrap:hover .home-awards-track { animation-play-state: paused; }` so a visitor can actually stop the scroll to read a badge, plus a per-tile hover lift (`translateY(-3px)` + `shadow-card-hover`) for depth. The "View Our Awards" button also picked up the sitewide trailing-arrow-icon treatment (§2.2) and its `href` was corrected to the real `/awards-recognition/` slug — it had drifted to a stale `/about-us/awards/` guess from an earlier pass.
- **Portfolio cards link out to the real client sites** (`leavitybread.com`, `girlyishskincare.com`, `arborplus.us`) and press cards link to the real articles (`bizweekly.com`, `usanews.com`) — both get `target="_blank" rel="noopener noreferrer"` per §5.15, since they're genuinely external. Hero/Awards/Portfolio/CTA buttons that point at `sitesbysara.com`/`www.sitesbysara.com` stay same-tab.
- **Local testing note:** `resize_window`'s mobile/custom viewport emulation did not reliably apply when previewing these fragment files directly (window.innerWidth stayed at desktop size regardless of the requested preset). Verified responsive behavior instead via a same-origin `<iframe>` with a fixed pixel width injected via `javascript_exec` — a reliable workaround when the viewport tool itself is misbehaving for a given file. Similarly, CSS `:hover` interactions on a `computer` hover action can't always be checked live via `getComputedStyle` (a stale/ambiguous match), so verify hover-triggered transforms by setting `transition: none` and the target `transform` directly via `javascript_exec`, then read `getBoundingClientRect()` — deterministic, not screenshot-dependent. A `.claude/launch.json` (`sbs-static-preview`, Python `http.server` on port 8420) now exists in this project for serving these fragment files over `http://localhost` during testing, since `file://` previews of files handled as static snapshots also block real interaction.

---

### 5.15 External Links Open in a New Tab
Applies site-wide, on every page, to every `<a>` whose `href` is an absolute URL:

- **Same tab (no `target`):** any of our own pages/media (see §5.15.1 — as of 2026-09-16 these are root-relative paths, not an absolute hostname at all) — this includes Book a Free Consultation, all header/footer nav, the all-services directory, and every internal cross-link. It also includes same-page anchors (`#pricing`) — those were never in scope for this rule, they just never get a `target` at all.
- **New tab (`target="_blank" rel="noopener noreferrer"`):** every other hostname — `order.sitesbysara.com` (all Order Now buttons), social icons, real portfolio client sites, press/publication links, third-party embeds (Brevo, Google Calendar), and any other genuinely third-party domain.
- **Always pair `target="_blank"` with `rel="noopener noreferrer"`** — never one without the other. Without it, the opened tab can use `window.opener` to redirect the original tab (reverse tabnabbing).
- `order.sitesbysara.com` is a different hostname from our own site and always counts as "external" for this rule, even though it shares the same root domain — it's a distinct checkout/configurator tool, not a content page of the site.
- The distinction is the **hostname's role** (own site vs. a separate tool), not "is this technically the same company." A link can be 100% real Sites by Sara content and still open in a new tab (Order Now) if it's on a different subdomain that functions as a separate tool.

#### 5.15.1 Own-Site Links Are Root-Relative Paths, Not Absolute URLs (2026-09-16)
**Problem:** this project is built and previewed against a staging domain (`sbs.sbsdevserver.com`) but ships to the live domain (`sitesbysara.com`/`www.sitesbysara.com`) — two different hostnames for the same content. Every internal link/media reference that was hardcoded to one absolute domain broke (or silently pointed at the wrong environment) the moment the same HTML got pasted somewhere else, since a hardcoded `https://sbs.sbsdevserver.com/...` link doesn't magically become `https://sitesbysara.com/...` just because the page it's embedded in changed domains.

**Fix:** every `href`/`src`/CSS `url(...)` that points at one of *our own* hostnames — `sbs.sbsdevserver.com`, `sitesbysara.com`, or `www.sitesbysara.com` — has the protocol and hostname stripped, leaving only the root-relative path: `https://sbs.sbsdevserver.com/book-a-free-consultation/` → `/book-a-free-consultation/`, `https://sbs.sbsdevserver.com/wp-content/uploads/2026/09/shopify-store-hero.webp` → `/wp-content/uploads/2026/09/shopify-store-hero.webp`. A root-relative path always resolves against whatever domain the page is currently being served from — same HTML, correct link, on either domain, with zero per-environment find-and-replace needed before a deploy. The one bare-root case (`href="https://sitesbysara.com"` with no path at all, on the footer logo) becomes `href="/"`, not an empty string — an empty `href` re-links to the current page, not the site root.
- **Never shorten a hostname that only superficially contains our name.** `i0.wp.com/sitesbysara.com/wp-content/uploads/...` is Jetpack's/WordPress.com's own image CDN mirror — the real host is `i0.wp.com`; "sitesbysara.com" only appears later, inside the *path* it's proxying. Leave every `i0.wp.com` URL fully absolute. Same logic protects `order.sitesbysara.com` and `profile.sitesbysara.com` from being touched — different hostname, different (external-tool) rule per §5.15 above.
- **This doesn't change the new-tab/same-tab rule, it simplifies it** — a root-relative path was already implicitly "same tab" (there's no hostname in it to evaluate), so these links simply never carry a `target` attribute, same as before.
- When auditing for stray absolute self-links later, grep for `https?://(www\.)?sitesbysara\.com|https?://sbs\.sbsdevserver\.com` across `*.html` — zero matches should remain outside of genuinely third-party contexts.

---

### 5.16 Year / Category Tab Showcase (Badge & Card Grid)
Introduced on `web-awards.html` (the Awards & Recognition page) to replicate the live site's year-by-year awards tabs in a cleaner, fully responsive form. Reusable any time content naturally segments into named groups too numerous to show all at once (e.g. a future testimonials-by-industry or portfolio-by-category page).

- **Tablist:** a single horizontal row of pill buttons (`role="tablist"`, each button `role="tab"` with `aria-selected`), `overflow-x: auto` with a hidden scrollbar so it degrades to horizontal scroll on narrow viewports instead of wrapping or squeezing — never switch to a vertical sidebar-of-tabs layout like the live site's original WPBakery widget, which doesn't collapse cleanly on mobile.
- **One active panel at a time:** each `.awards-tabpanel` (`role="tabpanel"`) is plain `display:none` until it carries `.is-active`; a small delegated click handler toggles `.is-active` on the clicked tab + its matching panel and clears it from all others. No routing/URL-hash state — this is presentational, not a page section someone links to directly.
- **Badge cards use `object-fit: contain`, not `cover`.** This is the opposite choice from the photo cards on `web-awards.html`'s sibling pages (`giving-back.html`'s campaign photos, the homepage portfolio screenshots) — those are photographs where cropping to fill the frame looks intentional; these are third-party award logos/seals where cropping would cut off part of the mark. The image sits in a fixed-height (`140px`) light-gray slot and is never allowed to exceed it, so mixed real-world logo aspect ratios (square badges, tall seals, wide wordmarks) all sit centered and fully visible.
- **Text-only fallback card:** a handful of real recognitions (personal honors for the founder, originally embedded as `schema.org` microdata on the live page rather than a visible badge image) have no logo image to show. Rather than inventing a placeholder image, `.award-card-badge.is-text-only` swaps in one shared inline SVG trophy icon (brand-blue, matches the "no emoji, always SVG" rule in §2.2) and the card body carries a description + an `.award-card-meta` line (issuer · date) instead of the usual "View Award →" link.
- **Every card's outbound link is genuinely third-party** (we-awards.com, Clutch, ThreeBestRated, Expertise.com, etc.) — all get `target="_blank" rel="noopener noreferrer"` per §5.15. Items where the live page's own "Read More" link was empty/dead don't get a link at all — never point an award card at a guessed or generic URL just to have something clickable.
- **Grid**: `repeat(4, 1fr)` desktop → `repeat(3,1fr)` at `≤1020px` → `repeat(2,1fr)` at `≤820px` → `1fr` at `≤600px`, same wrapping convention as `pricing-grid-4` — a non-multiple-of-4 year (e.g. 5, 6, 7, 11, 14 items) simply wraps its last row short, left-aligned, no centering trick needed since (unlike §5.11's services directory) there's no fixed 3-column grid to center a remainder under.

---

### 5.17 Full-Width Native Video Embed
Introduced on `testimonials.html` to replace the live site's click-to-open lightbox thumbnail with a real, always-visible embed — used any time a page needs to show a real existing YouTube video prominently rather than behind a click.

- **Responsive 16:9 wrapper, no JS required for the aspect ratio:** `.testimonials-video-wrap` uses the `padding-top: 56.25%` intrinsic-ratio trick (`56.25% = 9/16`) with the `<iframe>` positioned `absolute; inset:0; width:100%; height:100%`. This scales correctly at any container width without a resize listener — prefer it over `aspect-ratio` only when the container's own width is already fluid (it is here, full `.container` width), both work but this project already leans on this pattern's simplicity.
- Wrapped in the same rounded/bordered/shadowed card treatment as `.hero-image-card` (`border-radius:var(--radius-lg)`, `border`, `box-shadow:var(--shadow-floating)`) so a real YouTube frame doesn't look like a bare, un-styled rectangle dropped onto the page.
- `title` on the `<iframe>` must be the video's real on-YouTube title (fetched from the actual video page, e.g. "Sites by Sara Web Design Client Testimonial") — never a generic "video" or "embedded content" label, same specificity rule as image `alt` text (§7.4).
- `loading="lazy"` on the iframe is safe here since the video sits below the page banner, not literally the first paint element.

### 5.18 Variable-Length Quote/Review Card Grid (Auto-Detected "Read More")
Introduced on `testimonials.html` for the 31 real client testimonials (45–825 characters each). Reusable for any future grid of real, unrewritable third-party text (reviews, quotes, case-study pull-quotes) where lengths vary too much to just rewrite for symmetry (§5.6's "bake the content length equal" fix only works when the copy is ours to rewrite — a client's own testimonial text is not).
- **CSS line-clamp caps every card's resting height** (`.testimonial-quote { -webkit-line-clamp: 6; overflow: hidden; }`) so a grid row never stretches to fit one 825-character outlier while its neighbors sit on mostly-empty cards — grid's default `align-items: stretch` already equalizes height *within* a row, but only clamping keeps that shared height visually tight instead of ballooning to the longest quote in the row.
- **The "Read more" toggle is only inserted where truncation actually happened**, detected on load via `quote.scrollHeight > quote.clientHeight` — not a hand-picked character-count threshold. This is a general technique: character counts are a poor proxy for whether N lines actually overflow (line length varies with card width, word-wrap points, and viewport), so measure the real rendered box instead of guessing. A short quote ("Talented, artistic, timely and experienced.") correctly gets no button at all.
- Toggling adds `.is-expanded` (`display:block; -webkit-line-clamp:unset; overflow:visible`) and flips the button label between "Read more"/"Read less" — no animation needed, this is a content-reveal, not a decorative transition.
- Every card still gets a real per-person avatar photo (`object-fit:cover`, 48px circle) pulled from the live site's own uploads — this content had 1:1 real photos for all 31 entries, so unlike §5.16's text-only award fallback, no icon-fallback case was needed here.

---

### 5.19 Page Title Banner — Real Photo Variant
Introduced on `newsletters.html`. The default banner (§5.1) is a pure gradient; this variant is for when the live page's own title section has a real background photo worth carrying over.

- **Layer the existing `--brand-gradient` as a semi-transparent tint over the real photo**, both in one `background-image` (gradient first, photo second — CSS paints the first `background-image` layer on top): `linear-gradient(135deg, rgba(2,80,197,0.86) 0%, rgba(212,63,141,0.86) 100%), url('<real-photo-url>')`, plus `background-size:cover; background-position:center`. ~0.86 alpha keeps the photo just barely visible as texture while the gradient still fully carries the brand color and keeps white H1 text readable — do not drop below ~0.8 alpha or busier photos will hurt text contrast.
- Pull the photo from the live site's own existing media URL (same "real content, not generated" rule as everywhere else) — never generate a new banner photo for this variant; if a page's title section is plain-gradient-only on the live site, keep it plain-gradient (§5.1's default), don't invent a photo to justify using this variant.
- The floating mesh blobs (`.page-title-banner-mesh`) still work fine layered on top and were kept unchanged — they read as atmospheric glow either way, over a flat gradient or a tinted photo.

### 5.20 Restyling a Third-Party Embeddable Form In Place
Introduced on `newsletters.html` for a real Brevo/Sendinblue subscription form the client supplied as raw embed code. The general technique, for any future third-party embed (Brevo, GHL, Mailchimp, etc.) that needs to visually match the site but must keep functioning:

- **Never rename or remove the provider's functional attributes**: element `id`s the provider's own JS targets (`#sib-form`, `#sib-container`, `#error-message`, `#success-message`), `name`/`type`/`required`/`data-*` attributes on real form fields, the `action` URL, and the reCAPTCHA `data-sitekey`. These are load-bearing — the form silently stops submitting or validating if any are altered, and there's no visual symptom to catch it in a static preview.
- **Keep the provider's own stylesheet linked** (`sibforms.com/forms/end-form/build/sib-styles.css` here) and its `<script>` blocks (the config globals + `main.js` + the reCAPTCHA script) verbatim, at the bottom of the page — this project's own JS never re-implements what a provider's `main.js` already handles (loading-spinner swap, inline error/success panel toggling).
- **Restyle by editing the provided inline `style="..."` attributes in place, swapping literal hex/px values for this project's own `var(--token)` references** (e.g. the field wrapper's `border-radius:3px; border-color:#C0CCD9` became `border-radius:var(--radius-md); border-color:var(--border)`) — inline styles resolve CSS custom properties from the page's own `:root` normally, so this works without fighting the provider's stylesheet on specificity. Only reach for a supplementary ID-scoped override block with `!important` (e.g. `#sib-form .input { ... !important }`) for the handful of things the provider only styles via an external class with no matching inline attribute to edit directly (input border/radius/font here).
- **Status colors were mapped onto this project's own semantic tokens** — the error panel's given red stayed red but now uses `var(--brand-coral)`/`var(--brand-coral-tint)`, and the success panel's given green now uses `var(--green)`/`var(--green-tint)` (added to this page's `:root` specifically for this — most other pages don't need a success/green token). Never repurpose the brand's decorative blue/coral gradient for a status color; error/success need their own semantic meaning independent of brand color choices.
- **Drop any font-face the provider bundles that this project doesn't use** — the supplied code included three `@font-face` declarations for Roboto; since every visible font-family reference was switched to `var(--font)` (Manrope) during the restyle, those Roboto files would just be dead weight, so they were removed rather than kept "just in case." This follows the sitewide two-font-family cap already in place — never let a pasted embed silently add a third.
- **The newsletter archive below the form reuses §5.16's year-tab pattern outright** (`.newsletter-tablist`/`.newsletter-tab`/`.newsletter-tabpanel`, same JS shape) rather than inventing a new tab component — only 2 years exist today (2026, 2025) versus the Awards page's 7, but the same reusable pattern applies whenever content is naturally year/category-grouped.
- **Emoji were stripped from the real newsletter subject lines** (e.g. "In-House Financing Is Here! 💳" → "In-House Financing Is Here!") to keep the sitewide no-emoji typography rule (§2.2) intact — this is the one case in the project where reproduced real content was edited rather than kept verbatim, and it's limited to removing decorative emoji, never the actual wording/meaning of a subject line.

### 5.21 Opaque Third-Party Iframe (Can't Be Restyled) vs. §5.20's Reachable Form
Introduced on `book-a-free-consultation.html` for the real Google Calendar Appointment Scheduling embed. This is a **different case from §5.20's Brevo form**, worth telling apart before reaching for the same technique:
- Brevo's embed is real HTML/CSS that lands directly in *our* document — its inline `style="..."` attributes and classes live in our DOM, so our page's CSS (and `:root` custom properties) can reach in and restyle it.
- A Google Calendar scheduling embed is a cross-origin `<iframe>` — everything inside it renders in Google's own document, completely inaccessible to our CSS/JS (no styling, no DOM access, by browser design, not a bug to work around). **Don't attempt inline-style edits or an override stylesheet against a cross-origin iframe's internals — there's nothing on our side to target.**
- The only thing we control is the **frame around it**: `.booking-card` (white surface, `var(--radius-lg)`, `var(--shadow-floating)`, matching the same card language as every other embed on the site) plus a header row (icon + title) above the `<iframe>`, so an otherwise plain gray Google widget still reads as "designed," not bolted on.
- Kept the given `src`, `width`, `frameborder` attributes from the provided embed code untouched — only added a descriptive `title` attribute (accessibility, same specificity rule as image `alt` text) and let `height` grow to `900px` under `≤600px` via a media query, since the widget's own day/time-slot grid needs more vertical room once it stacks to a single visible day on a narrow screen.
- Real compliance/legal text that comes bundled with a scheduling or form embed (here, the SMS opt-in disclosure) is kept close to verbatim, not trimmed for "cleaner copy" — unlike marketing copy, disclosure text has a specific legal meaning that paraphrasing can quietly break.

---

## 6. Image Standards & Asset Guidelines

To ensure every page looks cohesive, executive, and custom-built:

1. **Strict Niche Relevance:**
   - **Never use generic stock imagery** (e.g. random handshakes, generic laptops with video call grids, or blank keyboards).
   - Visuals must represent the exact service topic (e.g. Google Workspace/Microsoft 365 admin dashboards, DNS verification tables, custom domain inbox mockups, cloud migration flow diagrams).
2. **Aspect Ratio:**
   - Hero Visual: `4:3` (rendered width `600px`, height `450px`).
   - Story Visuals: `4:3` (rendered width `520px`, height `390px`).
3. **Format & Sizing:**
   - Production format: `.webp` (optimized under 150KB for fast loading).
   - Local fallback: `.jpg` or `.png` in `images/` directory.
4. **Visual Styling:**
   - Clean, bright UI aesthetic with white surfaces and soft studio lighting.
   - Accents in screenshots/mockups should echo SBS colors (`#3A539B` blue, `#ea4e5f` coral).
   - Enclosed inside `.hero-image-card` or `.story-image-card` with `border: 1px solid var(--border-light); border-radius: 20px; box-shadow: var(--shadow-card);`.
5. **No Third-Party Brand Names:** Generated images must never show any other brand, company, or product name/logo — no placeholder store names, no third-party payment-provider logos, no fake competitor branding. If a mockup needs a visible site/brand name at all, it must read **"Sites By Sara"** and nothing else.
6. **We never generate images ourselves** — every image referenced on a page is a **prompt handed to the user** to generate and place. When building a page:
   - Write an explicit prompt per image covering: subject/mockup content, aspect ratio (4:3 per the rules above), the SBS accent colors to echo, lighting/style, and the no-other-brand-names clause from point 5.
   - Point `<img src>` at the placeholder WordPress upload path already used across pages — `https://sbs.sbsdevserver.com/wp-content/uploads/2026/09/{filename}.webp` — so the markup is upload-ready even before the asset exists.
   - Tell the user the exact filename to save a local mirror as under `images/{filename}.jpg`, matching the convention of existing local assets (`custom-web-dev-hero.jpg`, `cyber-security-hero.jpg`, `cyber-score-card.jpg`).
   - Never fabricate a placeholder (no stock photo URLs, no unrelated existing image reused for a different service). A missing/broken image icon in preview is expected and correct until the real asset is generated.

---

## 7. SEO Best Practices

Every page must be built SEO-ready from the first draft — not patched in afterward. This applies to every page listed in `build-guide.md` §1.4, including the directory page.

### 7.1 Title Tags
- One `<title>` per page, unique across the site, format: `{Service/Page Name} — {Optional Differentiator} — Sites by Sara`.
- Keep to **≤60 characters** where possible so it doesn't truncate in search results.
- Lead with the service name (the keyword a customer would search), not the brand — the brand suffix comes last.

### 7.2 Meta Descriptions
- One unique `<meta name="description">` per page, **150–160 characters**.
- Summarize the concrete offer (what it is, key scope/price signal) rather than generic marketing fluff — it should read like a compressed version of the hero's lead paragraph, grounded in the same facts.

### 7.3 Heading Hierarchy
- **Exactly one `<h1>` per page** — the `.page-banner-h1` inside the title banner. Never add a second `<h1>` anywhere else on the page (hero headings, story titles, etc. are all `<h2>`).
- Don't skip levels (no `<h3>` directly under an `<h2>`-less section). Card/callout titles inside a section use `<h3>`; nothing goes deeper than `<h4>`.
- Heading text should contain the actual service/topic keywords naturally (as all existing hero/section titles already do) rather than generic labels like "Our Services" with no topic word.

### 7.4 Image Alt Text
- Every `<img>` gets a specific, descriptive `alt` — describe what the mockup actually depicts (e.g. `"Shopify Product Catalog Admin Screen Mockup"`), not the filename, not "image", not empty.
- Decorative-only elements (mesh/blob pseudo-elements, icon-only SVGs already labeled by adjacent text) don't need alt text — they're CSS backgrounds or inline SVGs, not `<img>` tags, so this rarely comes up; if it does, use `aria-hidden="true"` instead of a redundant alt.
- Never reuse one generic alt string across multiple different images on the same page.

### 7.5 Structured Data (JSON-LD)
Add machine-readable structured data in `<head>` for every service landing page:

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "serviceType": "Exact Service Name",
  "provider": { "@type": "Organization", "name": "Sites by Sara" },
  "description": "One-sentence grounded description, same facts as the meta description.",
  "offers": {
    "@type": "AggregateOffer",
    "priceCurrency": "USD",
    "lowPrice": "<true lowest number shown anywhere on the page>",
    "highPrice": "<true highest number shown anywhere on the page>"
  }
}
</script>
```

If the page has a FAQ section, also add `FAQPage` structured data whose `Question`/`acceptedAnswer` text **mirrors the visible FAQ content verbatim or near-verbatim** — schema must never diverge from what a visitor actually sees on the page:

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Exact visible question text",
      "acceptedAnswer": { "@type": "Answer", "text": "Exact visible answer text" }
    }
  ]
}
</script>
```

- `lowPrice`/`highPrice` must be real numbers already printed on the page — never invented or estimated.
- Don't add `url`, `@id`, `image`, or Open Graph (`og:url`, `og:image`) properties that would require a production domain path or a generated asset that doesn't exist yet. Add those only once the page is actually published and its final URL/image are known — a placeholder or guessed URL here is a fabricated fact, not a real one. `og:title`/`og:description` are safe to add early since they just mirror the title tag and meta description.

### 7.6 Internal Linking
- **Never add a "← Browse All Services" / `all-services.html` link on individual service pages.** This was tried across every existing page and explicitly rejected by the client — do not re-add it, on any current or future page.
- Cross-link **peer/alternative services** where a visitor would naturally want the option — e.g. the WooCommerce and Shopify pages link to each other ("Prefer a WordPress-based store instead? See our WooCommerce Stores page.") since they're two platform choices for the same underlying need.
- Use descriptive anchor text (the actual service/page name), never "click here" or "learn more" with no context.

### 7.7 Performance Signals That Affect SEO
- Every `<img>` has explicit `width`/`height` attributes (already required by §6) — this prevents layout shift (CLS), a ranking factor.
- Hero image loads eagerly (`loading="eager"` or no `loading` attribute); below-the-fold images (portfolio grids, story rows further down the page) use `loading="lazy"`.
- Font loading already uses `preconnect` + a single Google Fonts request (§2.1) — don't add additional font families or extra font-weight requests without reason.

### 7.8 URLs & Filenames
- Filenames are kebab-case and describe the service (`shopify-ecommerce-store.html`, not `page3.html` or `new-landing.html`).
- If/when a page is published to WordPress, its slug should mirror the filename's naming pattern so the URL itself carries the keyword.

---

## 8. Responsive Breakpoints & Mobile Rules

```css
/* Tablet Landscape & Below */
@media (max-width: 992px) {
  .pricing-grid-4 {
    grid-template-columns: repeat(2, 1fr);
  }
  .scope-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Tablet Portrait & Below */
@media (max-width: 820px) {
  .hero-grid,
  .story-row,
  .cta-banner-box {
    grid-template-columns: 1fr;
    gap: 40px;
  }
  .story-row.is-reversed .story-text-col {
    order: 1;
  }
  .story-row.is-reversed .story-visual-col {
    order: 2;
  }
  .pricing-callouts-row {
    grid-template-columns: 1fr;
  }
}

/* Mobile Devices */
@media (max-width: 600px) {
  .page-title-banner {
    padding: 48px 18px;
  }
  .pricing-grid-4,
  .pricing-addons-grid,
  .scope-grid {
    grid-template-columns: 1fr;
  }
  .btn-group {
    flex-direction: column;
    width: 100%;
  }
  .btn {
    width: 100%;
  }
}
```

---

## 9. Page Construction Checklist for New Pages

When creating any new page for SBS:
- [ ] Has Manrope typography linked and set on `body`.
- [ ] Uses exact CSS variables from `:root`.
- [ ] Starts with `.page-title-banner` using `--brand-gradient` (clean H1 + subtitle, without badge).
- [ ] Uses `.btn-primary` with gradient fill and `.btn-outline` with blue border.
- [ ] Hero's secondary button links to `#pricing` and reads "View Pricing & Plans" — pricing must always be reachable from the hero.
- [ ] Alternating feature rows use `.is-reversed` on even rows.
- [ ] Every price, feature bullet, and requirement note traces back to an exact line in `Services-info.html` — nothing invented. See `build-guide.md` §2 for the full zero-assumption rule.
- [ ] Pricing cards each carry their own `plan-features-list` (§5.6) — no shared "included everywhere" row below the grid.
- [ ] Every real tier gets its own full pricing card with its own exact price and its own Order Now link (§5.6.1) — never grouped into a "starting at $X" range card, regardless of tier count.
- [ ] Every pricing card and priced addon box has an "Order Now" button linking to `https://order.sitesbysara.com/configure?id=<ID>` with the correct per-tier ID looked up from the Configure Wizard Links tool (§5.2) — never left as "Book Consultation"/"Select Service", and never linked when no real matching ID exists.
- [ ] No fabricated "Most Popular"/"Best Value" badges — only labels the source data states or that are objectively derivable.
- [ ] All images are unique, niche-specific, `4:3` ratio, contain no third-party brand names, and are handed off as generation prompts (§6) — not fabricated.
- [ ] No standalone `<header>` or `<footer>` if creating Elementor body templates.
- [ ] **SEO (§7):** unique `<title>` (≤60 chars) and `<meta description>` (150–160 chars); exactly one `<h1>`; every `<img>` has a specific descriptive `alt` plus `width`/`height`; `Service` (and `FAQPage`, if the page has a FAQ) JSON-LD added with real on-page numbers only; cross-link to any natural peer/alternative service page. **No `all-services.html` / "← Browse All Services" link on the page itself.**
- [ ] Page previewed in-browser at desktop width — every section scrolled through, any accordion/`<details>` clicked at least once.
- [ ] `all-services.html` gets a new card for this page in the same pass (§5.11) — title, grounded short description, grounded price range, "See More" button.

> For the full research/process checklist (what to read before starting, how to combine multiple services into one page, the image handoff workflow), see **`build-guide.md`** — that file governs *how a page gets built*; this file governs *how it looks*.
