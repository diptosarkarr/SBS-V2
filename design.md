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
**Single combined component as of 2026-09-21 — `home-body.html` now contains the hero too.** Originally split into two standalone reusable components (`home-hero.html` and `home-body.html`, same pasteable-component pattern as `header.html`/`footer.html`) specifically to make room for a Trustindex testimonial shortcode between them; recombined into one file by explicit instruction once that split was no longer needed ("combine home hero and home body, we don't need to split that anymore"). `home-hero.html` no longer exists — its `:root` tokens (deduped against home-body's own, `--yellow`/`--shadow-floating` were the only ones unique to it), its CSS, its `<section class="home-hero-root">` markup (now the first child of `.home-body-root`), and its JS (now its own `<script>` block, right before the existing testimonials-lightbox script) were merged directly into `home-body.html`. Paste order is now simply: Trustindex testimonial shortcode → `home-body.html` (the combined file's own testimonials section still exists independently below the hero, per the pre-existing dual-marquee section — the Trustindex widget is a separate plugin embed elsewhere on the live page, not a replacement for it).

- **Why it was split in the first place (historical, no longer the reason for two files):** the live homepage's testimonial slider is a Trustindex plugin widget rendered via a WordPress shortcode. Its container carries `data-pid="wp-widget"` and no portable widget-ID — the rendering is tied to the WordPress plugin/account context, not a generic copy-paste embed, so it couldn't be reliably reproduced in static HTML, so the hero and body were kept as separate pastes with the shortcode sandwiched between them. That constraint apparently no longer applies to how this page gets assembled — if it resurfaces, re-split rather than trying to embed a WordPress shortcode inside this static file.
- **`home-body.html` was briefly split a second time** (into `home-body-part-1.html` / `home-body-part-2.html`) to make room for a client-supplied portfolio shortcode in place of the hand-built portfolio section — then un-split once the client instead handed over real markup/CSS for a custom portfolio interaction to integrate directly into the page. **Don't re-split unless a genuine non-reproducible WordPress widget (like Trustindex) requires it** — a client handing over their own HTML/CSS for a section is not that case; reimplement it in our own component vocabulary instead, the same as everything else on this page.
- **First pass copied the live page's flat structure with only new colors — rejected.** The client wanted an actual redesign (new structure, genuinely more modern hero, additional real content pulled from elsewhere on the site), not a reskin of the existing layout. The rule going forward: reproducing the live homepage's section order 1:1 with our palette is not sufficient — pull our own established component vocabulary (two-column hero grids, trust ribbons, alternating story rows) the same way every service landing page does, and add grounded content the live homepage doesn't currently show if it makes the page more complete.
- **Hero is a real two-column layout, not a centered text block:** left side is eyebrow + H1 + subhead + button group + a small real trust line (star icons + "Excellent — 56 Google Reviews", sourced from the Trustindex badge's own real numbers).
- **Right side (redesigned 2026-09-17, refined same day): a 2×2 grid of real website design examples, with 2 small trust facts floating over it, not a stat-cards-only visual.** The original version filled the whole right column with 3 absolutely-positioned `.home-hero-stat-card` cards and no imagery — functional, but visually empty/"old school" once the rest of the site had real photography elsewhere. Fixed by adding `.home-hero-image-grid` (`display:grid; grid-template-columns/rows: 1fr 1fr; aspect-ratio:1/1`), 4 tiles (`.home-hero-image-tile`, `object-fit:cover`, rounded + bordered + shadowed) showing 4 *different* real hero-mockup images already generated for other service pages (`custom-web-dev-hero-1.webp`, `shopify-store-hero.webp`, `woocommerce-store-hero.webp`, `static-html-sites-hero.webp` — all real existing assets, not newly generated, and deliberately not the same 3 client portfolio screenshots already shown further down this same page in `home-body.html`'s portfolio section, to avoid repeating identical images twice on one page).
  - **First cut floated all 3 original stat facts (top-left, center, bottom-right) — client felt it took up too much space.** The center card in particular sat directly over the grid's inner seam, competing with the images for attention. Cut down to 2 floating cards only — top-left ("Since 2007") and bottom-right ("200+ Customer success stories") — and dropped "Award-Winning" from this visual entirely rather than finding it a 3rd spot; that fact isn't otherwise duplicated elsewhere on the page, so it was a deliberate content trim, not an oversight, per explicit client direction.
  - The 2 remaining cards also shrank again in this pass (`188px`→`152px` wide, `36px`→`28px` icon, tighter padding/font) so they read as small accent badges rather than competing visual elements. `z-index:2` keeps them layered above the grid; `aria-hidden="true"` stays on both (they restate facts already said in real text elsewhere on the page); the image grid itself is NOT aria-hidden since its alt text is the only place that content exists.
  - **Three responsive tiers, not two — the tablet range must NOT collapse the 2×2 grid.** The first breakpoint pass collapsed `.home-hero-grid` to one column *and* `.home-hero-image-grid` to `1fr` at the same `900px` threshold, so a tablet-width viewport got the mobile 1×4 stack instead of a properly-sized 2×2. Fixed by splitting the behavior: `@media (max-width: 900px)` only stacks `.home-hero-grid` to one column and re-centers `.home-hero-visual` (`margin: 24px auto 0; max-width: 480px`) below the copy — `.home-hero-image-grid` keeps its `1fr 1fr` columns/rows untouched, so tablet gets the exact same 2×2 composition as desktop, just relocated and capped in width so it doesn't stretch to the full text-column width. The 1×4 single-column collapse (`grid-template-columns: 1fr`, tile `aspect-ratio: 4/3`, stat cards to `position: static`) only happens in the separate `@media (max-width: 600px)` block. When adding a new responsive component, default to checking whether "stack the outer layout" and "reflow this specific grid's own column count" actually need to trigger at the same width — they frequently don't, and conflating them is what caused this bug.
- **Collapses to a `1fr` single column (the requested "1×4 on mobile") below `900px`** — same breakpoint as before. The stat cards revert to `position:static; width:100%` stacked below the grid (matching the original mobile fallback), and the grid's `aspect-ratio` resets to `4/3` per-tile instead of a `1/1` grid-wide ratio, since a single column of tall square tiles wastes far more vertical scroll than a column of 4:3 ones.
- **`home-body.html` adds two sections beyond what the live homepage shows**, both built from real content already on other pages in this project rather than invented copy:
  1. **Trust/stats ribbon** directly under the hero split point — three grounded numbers: `2007` (since, matches the live homepage's own text), `200+` (success stories, matches the live final-CTA headline), `54` (industry recognitions & awards, the exact real `<div class="award-card">` count on `awards-and-recognition.html` across all years — not the smaller 11-image homepage marquee subset, which is just a highlights reel). `.home-trust-grid` is `repeat(3, 1fr)` (not 4) to match, collapsing straight to a single stacked column at `≤820px` rather than an intermediate 2-column state, since 3 items don't divide evenly into 2.
     - **The Google reviews count (`56`, from the Trustindex badge) was removed from this ribbon (2026-09-19)** — it already appears in the hero's own real trust line ("Excellent — 56 Google Reviews"), directly above this section, so repeating it here read as duplicated rather than adding new information.
     - **A live `all-services.html` card-count stat (`20+` "Services & Solutions Offered") was tried as its replacement, then also removed the same day** — the directory isn't finished growing yet, so a live count would need continual upkeep and reads as an unstable claim rather than a settled fact, unlike `2007`/`200+`/`54` which don't change on their own. Left at 3 stats rather than force a 4th filler claim; add a 4th back only if a genuinely stable, distinct real number surfaces.
  2. **"What We Do" services overview** — a 6-card grid linking to `custom-development.html`, `woocommerce-stores.html`, `shopify-ecommerce-store.html`, `cybersecurity-packages.html`, `email-setup-migration.html`, `site-audit-priority-fixes.html`. Each card's icon and description is copied verbatim from that exact page's own `all-services.html` directory card (same "pulled from the linked page's own content" rule as §5.11) — not new copy. Ends in a "View All Services" button to `all-services.html`. This is homepage → directory navigation, which is a different case from the individual-service-page rule in §7.6 — that rule is about not adding a browse-all link *on* a service page, not about the homepage linking to the directory.
- **Portfolio section (`.home-portfolio-*`) — hover-to-scroll full-page preview.** The client supplied reference markup/CSS using a fixed-height frame (`overflow: hidden`) containing a full, un-cropped page screenshot that pans upward on hover to reveal the rest of the page, then pans back down on mouse-leave. Reimplemented in our own tokens/classes rather than using the client's raw CSS verbatim (`.homework`/`.pageh`/`.sitehover-N`):
  - `.home-portfolio-frame` is a fixed `260px` box with `overflow: hidden`; the `<img>` inside is `width: 100%; height: auto` (so it renders at its true, un-cropped tall aspect ratio) with `transition: transform 14s ease` (slowed from an initial `6s` on 2026-09-19 — the shorter duration read as an abrupt jump-scroll rather than a slow, readable pan down the page).
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
- **Testimonials dual marquee (2026-09-17):** `.home-testimonials-section` inserted directly after the Trust Ribbon, before "What We Do" — pulls all 31 real testimonials straight from `testimonials.html` (not a curated subset) and splits them across two independently-scrolling tracks: top track (16 quotes) scrolls left-to-right, bottom track (15 quotes) scrolls right-to-left. Opposite directions read as more dynamic than two rows scrolling the same way. Same marquee mechanics as the Awards section (§5.14 above): each track's card list is duplicated once in the DOM (`aria-hidden="true"` on the copy) for a seamless loop via `translateX(0 → -50%)`; direction is a `.home-testi-track--ltr`/`--rtl` modifier class pointing at two separate `@keyframes` (the LTR one is just the RTL one's `from`/`to` reversed); hover-pause via `.home-testi-track-wrap:hover .home-testi-track { animation-play-state: paused; }`.
  - **"Read more" opens a lightbox instead of expanding inline.** Unlike `testimonials.html`'s own inline expand/collapse (§5.18), a card inside a moving flex row can't grow taller without breaking the row, so overflowing quotes — detected the same overflow-measurement way as §5.18 (`quote.scrollHeight > quote.clientHeight`, never a character-count guess) — get a "Read more" button that opens a shared lightbox. The lightbox reads its content **directly from the clicked card's own DOM** (avatar `src`/`alt`, name/role text, full quote text) rather than keeping a parallel JS data array — this also means it works identically whether the clicked card is the original or its aria-hidden duplicate, since both share the same DOM shape.
  - **Opening the lightbox pauses both tracks, not just whichever one was hovered.** A JS `pauseAllTracks()` toggles `.is-paused` on every `.home-testi-track-wrap` (independent of the CSS-only `:hover` pause) the moment the lightbox opens, since a reader's mouse is normally sitting over the "Read more" button, not necessarily still over the track, and may leave the section entirely while reading. Closing the lightbox (✕ button, backdrop click, or `Escape`) removes `.is-paused` from all wraps and resumes them.
- **New shared `.home-story-row` component** — a reusable 2-column `[image card | content]` layout (either side can hold the image) built for the two sections below and reused as-is; collapses to a single column at `≤900px`. `.home-story-image-card` reuses the same rounded/bordered/shadowed treatment as `.hero-image-card`/existing story visuals elsewhere on the site.
- **"Why Choose Us" section** — inserted after "What We Do," before Awards: image left, a 4-item differentiator list right (`.home-story-item`, icon + title + description) covering direct team access, published pricing, post-launch support, and the 2007 track record — all facts already established elsewhere on this page/site, not invented marketing claims.
- **"Our Process" section** — inserted after Awards, before Portfolio: mirrors "Why Choose Us" with the image on the right instead of left and a 4-step numbered list (Discovery Call → Design & Strategy → Development & Testing → Launch & Support) in place of icons — same `.home-story-item` shell, just a numeral in the icon slot instead of an SVG, showing the component is icon-agnostic rather than needing a rebuild.
- **Both new sections use generated-image placeholders per §6** (`home-why-choose-us.webp`, `home-our-process.webp`) since no existing real photo on the site fits either topic — the first not-yet-generated images added to `home-body.html`; every other image on this page is real existing content per the "Content is real" bullet above.
- **Final `home-body.html` section order:** Trust Ribbon → Testimonials (new) → What We Do → Why Choose Us (new) → Awards → Our Process (new) → Portfolio → Press & Publications → Final CTA.

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
- **The same bug also existed as raw local filenames, not just absolute URLs** (found 2026-09-16, 32 instances across 12 service pages): peer-page cross-links like "Prefer Shopify instead? See our Shopify E-Commerce Stores page" were written as `href="shopify-ecommerce-store.html"` — a relative link to a literal file that doesn't exist once the page is live in WordPress (there is no `/shopify-ecommerce-store.html` at the site root; the real page lives at `/shopify-ecommerce-store/`). Every such link — `.story-link` peer-service links (§7.6), inline `<strong>` FAQ mentions, and any other same-site cross-reference — must use the real slug from `all-services.html`'s own "See More" hrefs (same source of truth as §5.16/header nav), never the local `.html` filename it happens to be saved as in this repo. When auditing for this variant, grep for `href="[a-zA-Z0-9_-]+\.html"` across `*.html` — the only legitimate hit should be design.md's own illustrative markdown snippet, not a live page.

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
- **The "Read more" button is only inserted where truncation actually happened**, detected on load via `quote.scrollHeight > quote.clientHeight` — not a hand-picked character-count threshold. This is a general technique: character counts are a poor proxy for whether N lines actually overflow (line length varies with card width, word-wrap points, and viewport), so measure the real rendered box instead of guessing. A short quote ("Talented, artistic, timely and experienced.") correctly gets no button at all.
- **Clicking "Read more" opens a lightbox (`.testimonials-lightbox`), not an inline expand (2026-09-18, superseding the original inline `.is-expanded` toggle).** Originally the button toggled `.testimonial-quote.is-expanded` open in place and flipped its own label between "Read more"/"Read less" — that worked fine in this page's static grid (expanding a card just pushes the row taller), but once the homepage's testimonials marquee (§5.14) needed a lightbox instead — a card mid-animation can't grow height without breaking the scrolling row — the lightbox became the better pattern generally, so this page was switched to match for a consistent read-more experience site-wide. Same technique as §5.14: the lightbox reads avatar/name/role/quote straight from the clicked `.testimonial-card`'s own DOM rather than a parallel data array, so it stays correct even if card content changes; closes via ✕ button, backdrop click, or `Escape`. The button's label no longer needs to flip (always reads "Read more" — the action is "open," not "toggle"), and `.testimonial-quote` has no `.is-expanded` state to manage anymore.
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

### 5.22 Single Real-Tier Pricing Block (vs. §5.6's Multi-Card Grid)
Introduced on `simple-site-hosting-bundle.html`, whose only ground-truth data point is one price (`Simple Site | Domain Renewal & Hosting`, $25/mo). §5.6's `pricing-grid-4` assumes 2+ real tiers to compare side by side — forcing a single tier into that grid leaves it looking like an unfinished page with empty neighboring slots.
- **`.pricing-single-grid`** (`1.1fr 0.9fr` two-column, collapsing to one column at `≤820px`): left column is plain descriptive copy (a `plan-features-label` + `plan-features-list`, no card chrome) explaining what the one real tier includes; right column is the single real `pricing-card-col.is-featured`, centered and full-width within its column rather than capped to a narrow max-width — this reads as "one clear offer explained, then priced," not a grid with only one card in it.
- Still follows §5.6's core rule: the one real tier gets its own exact price and its own real Order Now link — this pattern only changes the *layout* for a tier count of 1, not the "never a range, never starting-at" pricing-card rule itself.
- Use this pattern only when a service genuinely has one real price point in `Services-info.html`/the order-link artifact — if a second real tier ever appears for the same service, move it back into a standard `pricing-grid-4` (or `pricing-grid-2`, per §5.6's cybersecurity-packages.html precedent) instead of stretching this single-column layout to fit two cards.

### 5.23 Content-Duplication Risk When Extracting a Dedicated Page From an Existing Cross-Sell Blurb
Discovered 2026-09-18 while building three new bundle pages (`wordpress-maintenance-bundle.html`, `simple-site-hosting-bundle.html`, `website-care.html`) from services that were already being sold as small embedded pricing blocks inside other, already-built pages:
- `static-html-sites.html`'s own "Hosting & Ongoing Care" pricing block already sells the exact same WHAM Squeeze Page tier (`id=132-1`) and Domain Renewal & Hosting tier (`id=27`) that `wordpress-maintenance-bundle.html` and `simple-site-hosting-bundle.html` now have full dedicated pages for.
- `hourly-dev-blocks.html`'s pricing section already sells all 4 of the exact same hourly services (`id=109/128/129/29`) that `website-care.html` now has a full dedicated page for.
- **This is a real duplicate-content risk** (two live pages both claiming to be the authoritative page for the same `order.sitesbysara.com` line items), not a hypothetical — it happened here because a service was first added as a small cross-sell blurb inside a *different* page's pricing section, then later "graduated" into its own full landing page, and nothing automatically trims or cross-links the original blurb once that happens.
- **When extracting a dedicated page for a service that already appears as an embedded pricing blurb elsewhere, flag the source page(s) to the user before/alongside the new build** — don't silently leave both live, and don't silently trim the older page's blurb either. Which one becomes the summary-with-a-cross-link and which one stays the full page is a product decision, not a default to assume.
- **Recurred 2026-09-18** while building `seo-plans-site-audit.html` and `google-analytics-search-console-setup.html`: `site-audit-priority-fixes.html`'s own pricing section already sells the exact same SEO Site Audit & Priority Fixes (`id=49`), GA/GTM Setup (`id=51`), and GSC Setup (`id=50`) that these two new pages now also feature as their own primary/addon offers. Same open question as above, not yet resolved — flagged to the user rather than silently trimmed.

---

### 5.24 Gradient-Button Corner Bleed — `background-clip: padding-box` Required on Every `-primary` Button Rule
Discovered 2026-09-21 on the homepage hero's "Book a Free Consultation" button, but the root cause is a sitewide pattern: **every** `.btn-primary` / `.home-btn-primary` / `.custom-btn-primary` / `.btn-plan-primary` class across every page had a faint rasterization seam ("color bleed") right at the rounded corners.
- **Root cause:** the shared base class (`.btn` / `.home-btn` / `.custom-btn` / `.btn-plan`) sets `border: 1.5px solid transparent;` alongside `border-radius: var(--radius-pill);`. By default `background-clip` is `border-box`, so the gradient paints all the way under that (invisible) border — and at a rounded corner, the browser rasterizes the border-box's own radius arc and the background's radius arc as two separate operations that don't perfectly coincide at the sub-pixel level, leaving a hairline fringe of gradient color peeking past the curve.
- **The fix is `background-clip: padding-box;`**, added to the `-primary` variant's rule (not the shared base class) — since the border is invisible anyway, clipping the background to the padding box (just inside the border) looks identical but removes the double-radius rasterization seam.
- **It must be set on BOTH the resting-state rule and the `:hover/:focus/:focus-visible/:active` rule, not just one.** `background: var(--brand-gradient)` and `background: var(--brand-gradient-hover)` are both shorthand `background` declarations — writing the shorthand resets every background sub-property to its initial value, including `background-clip`, even when `background-clip` isn't mentioned in that declaration. Setting it once on the base class doesn't survive into the hover rule; each rule that writes a fresh `background:` shorthand needs its own `background-clip: padding-box;` line right after it, or the bleed comes back the moment the button is hovered/focused.
- **This does not apply to every `background: var(--brand-gradient)` usage on a page** — only to elements that also have a `border: <width> solid transparent` (or any invisible border) at the same rounded corners. Decorative gradient fills with no border (`.page-title-banner`, `.featured-badge`, `.service-icon-wrap`, slider dots, step-number badges, etc.) don't have the border-box/padding-box mismatch and don't need this fix — don't add it reflexively to every gradient background in the codebase.
- **One file (`cybersecurity-packages.html`) has a page-specific `!important` override block** (`button.btn, button.btn-primary, .btn-primary, .btn.btn-primary { ... border: none !important; ... }`) that sets `border: none` instead of `border: transparent` — with a zero-width border there's no border-box/padding-box gap to begin with, so that specific override rule is correctly exempt and doesn't need `background-clip` added, even though its own base `.btn` class still has the usual `border: 1.5px solid transparent`.
- Applied across all 27 affected pasteable-component files in one pass on 2026-09-21; verify any *new* `-primary` button rule follows the same two-rule (resting + hover) pattern going forward.

---

### 5.25 Living Hero — Brand Gradient + Reactive Dot-Grid + Cursor-Parallax Shapes + Masonry Showcase (`home-body.html`, formerly `home-hero.html`)
Added 2026-09-21 at the client's request for "a continuously running animation that reacts with cursor movement." Went through several rejected/corrected passes before landing here — all worth recording so a future revisit doesn't repeat them:
1. **Canvas particle-network** (dots/lines, matching the client's own reference screenshot) — the reference was for the *interaction style* only ("continuous + cursor-reactive"), not a literal spec.
2. **Same loud `--brand-gradient` background, just with motion layered on top** — rejected at the time as reading dated regardless of what animates over it ("old school vibe").
3. **Invented dark-navy/indigo/violet gradient + a violet mesh blob + a cursor-follow spotlight glow** — rejected for introducing colors outside the token set ("why you changed the color theme? it should stay on their color theme").
4. **Flat `var(--navy)` as the base surface** — an existing token, but `--navy` is documented in §1.1 as a *text* color, not the brand's primary identity color; still read as "this dark blue," not their brand color.
5. **Flat `var(--brand-blue)` as the base surface** — correct token family, but ultimately overridden by direct instruction to restore the original `--brand-gradient` treatment instead ("i told you to add their brand gradient in the background as before was"). **Net lesson across passes 2→5: the client's actual objection was never the gradient itself — it was a flat, static, undecorated gradient with nothing moving. Once the dot-grid/mesh/shape animation layers existed on top, the original brand gradient was the right call after all.**

**Current background** (`.home-hero-root`): `background: var(--brand-gradient)` (`linear-gradient(135deg, #0250c5 0%, #d43f8d 100%)`) — the same token used for title banners sitewide, restored as the hero base per explicit instruction, now with the animation layers below layered on top of it rather than under a flat color. `min-height: 100vh` (with `100dvh` fallback for mobile browser chrome) + `display:flex; align-items:center;` makes the section genuinely full viewport height with vertically-centered content, instead of height driven by content length.
- **Reactive canvas dot-grid** (`<canvas class="home-hero-dots" id="homeHeroDots">`) replaces both the old static CSS dot-texture and the removed spotlight as the single interactive background layer. JS lays out a fixed 30px-spaced grid of dot positions once per resize, then on every `requestAnimationFrame` tick redraws all dots with alpha/radius boosted for any dot within a 160px falloff radius of the live cursor position — so the reactivity lives in the grid itself, not in a separate glow layer. Paused via `IntersectionObserver` when the hero scrolls out of view (no wasted RAF ticks off-screen); draws exactly one static frame (no loop, no mousemove listener attached) when `prefers-reduced-motion: reduce`.
- **Two soft mesh-gradient color blobs** layered on top of the brand gradient for extra depth/motion: `.home-hero-mesh::before` = `var(--navy)` (a dark accent patch, kept from the brand-blue pass since it still reads clearly against the gradient), 420px, `home-hero-drift-a` 22s ; `::after` = `var(--brand-coral)`, 380px, `home-hero-drift-b` 26s — `filter: blur(80px); opacity:0.35;`, independent durations so they never sync. (The earlier violet blob was deleted outright, not just hidden.)
- **Four thin-outline geometric shapes** (`.home-hero-shapes`: circle, triangle, plus, hexagon SVGs, stroke-only) are now the cursor-*parallax* layer instead of passive texture: each is wrapped in a `.home-hero-shape-wrap` div that holds the shape's fixed position (top/right/etc., unchanged from pass 3) and receives a JS-driven `transform: translate3d(dx, dy, 0)` pulled toward the cursor (max 22px, `distance * 0.06`, eased back via `transition: transform 0.6s cubic-bezier(0.22,1,0.36,1)` on `mouseleave`). The shape's own slow independent CSS rotation/pulse `animation` stays on the **inner** `<svg>`, never the wrap — see the transform-conflict note below for why the split is required.
- **`.home-hero-spotlight` removed entirely** — markup, CSS, and its JS `mousemove` handler all deleted, not just hidden. Its job (visible cursor reactivity) is now carried by the dot-grid + shape-parallax instead, per the client's explicit direction.
- **Property-conflict trap, same class of bug as the stat-card one below, solved by splitting elements this time**: a continuous CSS `animation` and a JS-driven `transform` can't safely coexist on the *same* element (the animation silently overwrites the JS value every frame). Rather than moving one of the two effects to a different CSS property (as done for stat-card hover), each shape was split across two nested elements — outer wrap owns the JS parallax `transform`, inner svg owns the CSS `animation` — so neither ever touches the other's `transform`.

**Showcase image grid — true masonry, not CSS Grid:**
- `.home-hero-grid { grid-template-columns: 1fr 1fr; }` — an even 50%/50% split between the copy column and the image column (verified via computed pixel widths: `544px`/`544px` at a 1366px-wide test viewport). Started as a 2fr/3fr (40%/60%) split per an earlier "images take 60% width" instruction; changed to 50/50 by explicit correction ("this content section became too much thin in width... make both side 50:50"). The narrower 40% copy column had been forcing the long subhead to wrap ~7 lines and the H1 to 2–3 lines, which was itself the main driver of a separate hero-height overflow (see below) — widening the copy column to 50% fixed both the visual "too thin" complaint and most of that overflow in one change.
- **`min-width: auto` grid-item blowout — the 50/50 split still wasn't landing equal once real images were in play.** The screenshot the client sent back showed the copy column rendering at roughly 300px against a ~760px image column — nowhere near 50/50 — even though `grid-template-columns: 1fr 1fr` was correctly in place. Root cause: `.home-hero-left` and `.home-hero-visual` are grid items with no explicit `min-width`, so each defaults to `min-width: auto`, which resolves to that item's content **min-content size** — and for `.home-hero-visual`, that min-content size is computed through its nested flex layers all the way down to the `<img>` tags' real intrinsic dimensions (these are large `-scaled` WordPress uploads, easily 1500px+ on a side; a synthetic 1600×2400/1600×3200 test reproduced the same shape of problem). When that min-content floor exceeds the track's naive 1fr share, the grid track sizing algorithm grows the track to fit it — cleanly, with no visible overflow — stealing width from the sibling track, which is exactly the clean-but-unbalanced layout in the screenshot (not a rendering glitch, a real track-sizing outcome). **Fix:** `min-width: 0` on both `.home-hero-left` and `.home-hero-visual` overrides the `auto` default, so the grid track sizing algorithm uses `0` instead of the deep descendant min-content size as each item's floor — the columns then split strictly 50/50 as specified, and the now-fixed-544px `.home-hero-visual` box simply lets its still-oversized descendants resolve down to `width:100%`/`object-fit:cover` as normal, no overflow. **General lesson: any grid item containing images, flex layouts, or other content with a large intrinsic/min-content size needs an explicit `min-width: 0` (or `overflow: hidden`) to make `fr`-based column splits actually hold — the "auto" default is the trap, and it's a per-level default, so it must be set on the grid item itself, not just somewhere deeper in the nesting.**
- `.home-hero-image-grid { display:flex; gap:14px; }` contains two independent `.home-hero-image-col { display:flex; flex-direction:column; gap:14px; flex:1; }` columns — column 1 holds tiles 1 & 3, column 2 holds tiles 2 & 4. Two flex columns stacking independently (rather than one CSS Grid with row/column placement, which can't gap-fill and would leave forced empty space when adjacent row heights differ) is what produces genuine masonry stagger at the seam between tiles while both columns still end flush at the bottom — confirmed by comparing each column's internal seam height against the other and the two columns' total rendered heights.
- **Tiles are portrait, not square** on tablet/mobile (`≤900px`), matching "as it's showing a website screenshot, that would be more practical": tile 1 and 4 keep `aspect-ratio: 2/3`, tiles 2 and 3 keep `aspect-ratio: 2/4`. `<img>` `width`/`height` attributes match proportionally so there's no layout-shift on image load.
- **Desktop (`≥901px`) height cap — width-driven `aspect-ratio` first shipped a real 100vh-overflow bug:** with the image column at (then-)60% width, two stacked `aspect-ratio: 2/3` + `2/4` tiles computed their height purely from that width, running the masonry column to 900px+ tall on ordinary desktop widths and pushing `.home-hero-root` well past `100vh` — exactly the "image section too long, hero taller than 100vh" bug the client caught. Fixed by decoupling height from width at this breakpoint: `.home-hero-image-grid` gets an explicit `height: min(70vh, 560px)`, `.home-hero-image-col` gets `height: 100%`, and each tile drops `aspect-ratio` in favor of `flex: 3 1 0%` (tiles 1 & 4) / `flex: 4 1 0%` (tiles 2 & 3) — the same 3:4 proportion as before, but now dividing a fixed, viewport-bounded height instead of being derived from width. `object-fit: cover` (already in place) absorbs the resulting crop. This also fixed a related complaint ("1st/4th too short/flat") for free — the old width-driven aspect-ratio was independently producing a very flat box at that column width regardless of the 100vh bug.
- **Verified fit after both the 50/50 split and the height cap landed together:** `.home-hero-root`'s rendered height matches `window.innerHeight` exactly at 1280×720, 1366×768, 1440×900, and 1920×1080 (all checked via `getBoundingClientRect()`) — including the 1280×720 case, which previously overflowed by ~18–20px purely from the copy column's text wrap before the 50/50 change (copy column height dropped from ~594px to ~465px once it gained the extra width). Tile ratios at these sizes land ~0.9–1.0:1 for tiles 1/4 and ~1.1–1.3:1 for tiles 2/3 — both noticeably closer to square than the pre-fix ~0.6:1.
- **Mobile (`≤600px`) gotcha — `display:contents` does not interleave DOM order:** the mobile rule flattens both `.home-hero-image-col` wrappers with `display:contents` so the 4 tiles stack in one column, but `display:contents` only removes the wrapper visually — it does **not** merge/interleave the children's document order. Because column 1 contains tiles 1 & 3 and column 2 contains tiles 2 & 4 in source order, flattening naively produces stacking order `1, 3, 2, 4`, not the intended `1, 2, 3, 4`. Fixed with explicit `order: 1;` / `order: 2;` / `order: 3;` / `order: 4;` on the four `.home-hero-image-tile--N` classes inside the same media query — `order` still applies correctly to the actual flex items even once their wrapper has been flattened away. **General lesson for future masonry-via-flex-columns layouts that later collapse to a single mobile column: always re-check visual order explicitly (e.g. via `getBoundingClientRect().top`), never assume `display:contents` preserves reading order.**
- Each tile keeps its own portrait `aspect-ratio` on mobile too (the old forced `aspect-ratio:4/3` override at this breakpoint was removed).

**Carried over unchanged from pass 3** (never the problem, kept as-is): ambient mesh drift being pure CSS/zero-JS-cost; magnetic tilt on the 4 showcase tiles (`perspective(900px) rotateX() rotateY() translateY(-6px) scale(1.03)`, JS per-tile `mousemove`, reset on `mouseleave`); independently-floating stat cards (`home-hero-float-a`/`-b`, out-of-phase via negative `animation-delay`) with their hover feedback on `box-shadow` rather than `transform` (avoids the same animation/hover conflict class as above); full `prefers-reduced-motion: reduce` support (disables all mesh/shape/stat-card animation, skips attaching the dots-canvas and shape-parallax `mousemove` listeners entirely rather than just hiding the visual result, resets image-tile transition to box-shadow-only); mobile stat cards using `animation:none !important` alongside `transform:none !important` once collapsed to static stacked blocks.
- **Verification note:** none of this is visible in a single static screenshot (motion, by definition) and this session's screenshot tool has documented staleness issues besides — verified deterministically instead: `getComputedStyle(...).transform`/`.gridTemplateColumns`/`.aspectRatio` diffed against exact expected values; `canvas.toDataURL()` diffed before/after a wait and after a synthetic `mousemove` to confirm the dot-grid actually redraws; scripted `mousemove`/`mouseleave` `MouseEvent`s dispatched at real coordinates (via `getBoundingClientRect()`) confirm shape-wrap parallax `transform` and tile tilt, and their clean reset back to `''` on `mouseleave`; mobile tile stacking order re-verified via each tile's `getBoundingClientRect().top` after the `order` fix; a hex-color-inventory check confirmed zero non-token colors remain in the file.

---

### 5.26 Body Scroll-Motion System (`home-body.html`)
Added 2026-09-21 at the client's request — the hero already had continuous motion (§5.25) and the testimonials/awards marquees (§5.14, §5.17-ish) already scrolled continuously, but every other body section (services, why-choose-us, our-process, portfolio, press, final CTA) was completely static. Rather than forcing the marquee treatment onto sections that don't suit it (a services grid or a numbered process list scrolling sideways would read as gimmicky, not polished), each section got a **scroll-triggered entrance** instead, plus two section-specific motion touches.

- **`.home-reveal` — the shared entrance primitive.** `opacity:0; transform:translateY(28px)` at rest, `.is-visible` (added by JS) animates both to their resting values over `0.7s cubic-bezier(0.22,1,0.36,1)`. Six `.home-reveal-delay-1` through `-6` modifier classes (0.08s increments) stagger multi-item grids so cards/items animate in sequence rather than all at once. One shared `IntersectionObserver` (`threshold:0.15`, `rootMargin:'0px 0px -60px 0px'`) drives every instance — it adds `.is-visible` and immediately `unobserve()`s that element, so this is a **one-time** reveal (scrolling back up and down again does not re-hide/re-show it), which reads as intentional rather than distracting on repeat scroll. Applied to: all 5 section headers (services/awards/portfolio/press/testimonials), all 6 service cards (staggered), the why-choose-us image card + its 4 story items (staggered), the our-process image card + its 4 story items (staggered), all 3 portfolio cards (staggered), both press cards (staggered), and the final-CTA inner content block.
- **Trust ribbon count-up.** Each `.home-trust-stat-number` gets `data-count-to` (`2007`/`200`/`54`) and an optional `data-count-suffix` (`+` on the `200`). A separate, dedicated `IntersectionObserver` (`threshold:0.4`, observing `.home-trust-grid` itself) triggers a `requestAnimationFrame` count from `0` to the target over `1400ms` with a cubic ease-out, on top of the grid's own `.home-reveal` fade-up — two independent effects (CSS opacity/transform vs. JS `textContent`), no property conflict, same "split concerns across mechanisms" pattern used throughout this project.
- **Our Process gets an animated connecting line, Why Choose Us doesn't** — a deliberate distinction, not an oversight. Our Process's 4 items are literally numbered steps (`1`–`4`); its `.home-story-list` gets an extra `.home-story-list--numbered` modifier whose `::before` is a `2px`-wide vertical bar (`height:0` at rest) positioned behind the step circles (`left:19px`, matching the circle's center), growing to `calc(100% - 40px)` over `1.1s` once `.is-visible` is added by the same shared observer (the list itself, not the individual items, is what's observed for this one). Why Choose Us's 4 items use SVG icons, not sequence numbers — a connecting line there would visually claim an ordering ("step 1 → step 2") that doesn't exist, so it intentionally only gets the plain per-item `.home-reveal` stagger.
- **Service card icon hover** — `.home-service-icon` gets `transform: scale(1.08) rotate(-4deg)` plus an inverted `background`/`color` swap (tint → solid `--brand-blue`, `--brand-blue` text → white) on `.home-service-card:hover`, a small stateful motion detail layered on top of the card's pre-existing lift-and-shadow hover.
- **Final CTA background drift** — the section's existing decorative `::before` (two static radial gradients) now runs `home-cta-drift` (`16s ease-in-out infinite alternate`, `translate + scale`), the same "ambient, always-on, low-cost" motion language as the hero's mesh blobs, so the CTA doesn't read as the one static block on an otherwise-alive page.
- **`prefers-reduced-motion: reduce` respected throughout:** the reveal JS checks the media query up front and, if it matches (or `IntersectionObserver` isn't available), immediately adds `.is-visible` to every reveal element with no animation rather than leaving content invisible; count-up skips the `requestAnimationFrame` loop and jumps straight to the final number; the connecting-line and CTA-drift `@keyframes`/transitions are disabled via matching CSS media blocks as a backstop.
- **Verification:** confirmed `.home-reveal` elements sit at `opacity:0` before their section scrolls into view and `opacity:1`/`is-visible` after, via `getComputedStyle` before/after a scripted `scrollIntoView`; count-up confirmed to land exactly on `2007`/`200+`/`54` after the animation window; connecting-line confirmed via computed `::before` height reaching `calc(100% - 40px)`; CTA drift confirmed via computed `animationName`. No console errors after the merge (below) or these additions.

---

### 5.27 Sitewide Content-Accuracy Audit (2026-09-21)
The client flagged that content pulled from the live site during earlier research (per §0's research workflow) can itself be stale or wrong — the live site is not infallible ground truth, just a starting point to verify against real facts, not copy blindly. Three categories were audited across every page (3 parallel research passes, one per page group, read-only):

1. **"Years of experience" math.** Sites by Sara was founded in **2007**; the correct figure is **current year − 2007** (19 as of 2026), not a fixed number that ages every time this project is revisited — recompute it against today's date rather than reusing whatever number was last written. Found and fixed two files still saying "10 years"/"10+" (copied from the live site, which is itself out of date): `about.html` (stat pullout + founder paragraph) and `custom-development.html` (hero prose, hero badge, trust-ribbon stat — 3 separate instances in one file). `support.html`'s "19+ Years Experience" was already correct and used as the reference value. Audited every other page for the same pattern — no other instances found.
2. **Eyebrow/title vs. actual content mismatches.** An eyebrow+title makes an implicit promise about what the section body delivers; the audit checks whether the copy underneath actually delivers it. Two confirmed:
   - `about.html`'s "Meet The Founder" section had a paragraph that mentioned Sara's name once and then pivoted to generic company-mission copy — never actually introduced her. Rewritten using only facts already established elsewhere on the site (founded 2007, boutique agency, "you work directly with Sara and our core team" — the same real claim already used in home-body.html's Why Choose Us section) — no invented biographical details.
   - `giving-back.html`'s "Total Contributions" section showed exactly one $2,000 donation, not an aggregate total (most other listed campaigns are in-kind/volunteer work with no disclosed dollar figure, so a real total isn't computable from what's on the page) — retitled to **"A Recent Contribution"** to match what's actually shown, rather than inventing a total.
   - `home-body.html`'s "What We Do" section title ("...Development & Marketing") and lead text ("digital marketing solutions") but the 6 service cards were 100% Build/Maintain-group services — zero Grow-group (marketing) services. Swapped the most redundant Build-group card (Shopify — WooCommerce already covers "e-commerce platform") for **Local SEO & Google Business Profile** (icon/title/description copied verbatim from its `all-services.html` directory card, per the existing verbatim-copy rule in §5.14). Also fixed the hero subcopy, which listed "Google Ads" as a current offering — `header.html`'s own mega-menu marks Google Ads Management `is-soon` ("Coming Soon"), so the page was overstating its own live capability; swapped for "Local SEO" (real, live, and now also represented in the services grid below it).
3. **Related/cross-sell service link relevance.** Audited every inline "pricing-inline-link" / FAQ cross-sell across all service pages against the real site taxonomy (Build / Maintain & Protect / Grow, per `header.html`'s mega-menu columns). Almost every existing cross-sell turned out to be genuinely justified (verified case-by-case, not assumed) — the client's general worry about "random service links" corresponded to two real, narrower bugs rather than a widespread problem:
   - `hourly-dev-blocks.html`: a link's anchor text promised "full WordPress hosting & maintenance" but the `href` pointed to Custom WordPress Development (a new-build service, Build group) instead of the WordPress Maintenance & Hosting Bundle (Maintain & Protect group) — a genuine text/destination mismatch, not just a taxonomy quibble. Fixed to point to `/wordpress-maintenance-hosting-bundle/`.
   - `amazon-listing-store-setup.html`: "Also selling on Walmart?" led into a link to Walmart **Ads Management**, implying Walmart store/listing setup (the direct parallel to "Amazon listing and store setup," this page's own service) when the linked page is actually ads management for a store you'd already own. No Walmart listing/store-setup page exists yet, so the link itself was the only option available — the fix was reframing the lead-in text ("Want to advertise your listings on Walmart too?") to accurately describe the destination rather than removing the only available cross-sell.
   - `giving-back.html`'s "Contact Us" CTA linked `/contact/`, which doesn't match the site's actual, consistently-used contact URL (`/contact-us-2/`, confirmed via `header.html`'s own nav links) — fixed.
   - Two items were investigated and confirmed to be **non-issues**, not fixed: `cybersecurity-packages.html`'s `[sg_popup id="14928" event="click"]...[/sg_popup]` wrapping several CTA buttons looks like a stray artifact at a glance but is a legitimate WordPress popup-plugin shortcode meant to survive as literal text in the static file until WordPress renders it (same pattern as the Trustindex shortcode noted in §5.14) — left untouched. `go-high-level-services.html`'s Order Now button `href="#"` looks like a placeholder but is intentional per explicit earlier instruction (no real `order.sitesbysara.com` ID exists yet for GHL) — left untouched.
- **Process note:** given the scale (30+ pages), the audit itself was delegated to 3 parallel read-only research agents (one per page group) with the taxonomy and "19 = correct" math given as fixed criteria up front, specifically to avoid rediscovering the same taxonomy/math independently 30 times; all fixes were then applied and re-verified directly, not delegated, to keep judgment calls (what to retitle something to, which replacement card to pick, exact link-text rewording) consistent across the whole site rather than fragmented across 3 independent agents' individual style choices.

---

### 5.28 Multi-Sub-Service Pricing Pattern — "Paid Advertising" (`paid-advertising.html`)
First of a batch of new combined pages (2026-09-21), merging several `is-soon` mega-menu placeholders — and, in this case, one already-live page — into one landing page. Introduces a new pricing-section pattern for pages where the combined services don't share one pricing shape.

**The problem this solves:** existing multi-tier pages (`walmart-ads-management.html`, now merged in) all used a single `.pricing-grid-4` Starter/Growth/Bloom/Harvest block, because the underlying `Services-info.html` data was already one clean 4-tier dropdown. "Paid Advertising" combines four platforms with three *different* pricing shapes: Google Ads and Meta Ads are flat one-time-setup-plus-flat-or-spend-based-ongoing items (3 and 4 separate cards respectively, no tiers), while Amazon Ads Management and Walmart Ads Management are each a clean 4-tier dropdown. Forcing the flat items into 4-column tier cards would fabricate tiers that don't exist in the source data — a `§2` violation.

**Pattern:** inside one shared `.pricing-outer-container` (unchanged), each platform gets its own labeled block in document order:
- `.pricing-divider` — a small uppercase label (`"Google Ads"`, `"Meta Ads (Facebook & Instagram)"`, `"Amazon Ads Management"`, `"Walmart Ads Management"`) that also doubles as a visual section break (`border-top`, extra `margin-top`) between platforms. First divider in the container has that border/margin suppressed (`.pricing-outer-container > .pricing-divider:first-of-type`) so it doesn't add a stray line right under the top bar.
- **Flat/non-tiered items** (Google, Meta) use a new lightweight card — `.pricing-addons-grid` (a 4-column, `.pricing-grid-4`-sized grid) of `.addon-item-box` cards: price tag, title, one-line description, optional `.addon-item-note` for a spend-based pricing caveat (e.g. Google Ads Ongoing's "$500/mo under $2,000 ad spend; 20% of spend above"), and its own real `order.sitesbysara.com` Order Now button. This is the same `.addon-item-box` pattern already used for `amazon-listing-store-setup.html`'s "Listing Enhancement Add-Ons" — reused here as a second, independent instance of the same component rather than inventing a new one, per the "reuse existing patterns" rule in `build-guide.md` §1.
- **Tiered items** (Amazon Ads Management, Walmart Ads Management) keep the existing `.pricing-grid-4` Starter/Growth/Bloom/Harvest block, one per platform, each followed by its own `.pricing-tier-note` (new, small print directly under that platform's grid) for a per-platform disclaimer that doesn't apply to the other platform's tiers (Amazon's $500 onboarding + 20% of spend vs. Walmart's flat $350 onboarding) — deliberately *not* folded into the single shared `.pricing-disclaimer` below the whole container, since that text is common to the page and a platform-specific fee doesn't belong there.
- Top bar's `.pricing-platform-pills` lists all platforms covered (`Google Ads` / `Meta Ads` / `Amazon Ads` / `Walmart Ads`) as plain `.platform-tag` pills — same component as the single-platform pages, just with more than one tag now that the container spans multiple platforms.
- **When to reach for this pattern vs. a single `.pricing-grid-4`:** only when the source data genuinely doesn't give the combined services one shared tier structure. A page combining two services that *do* share the same tier shape should stay as one grid — don't split into per-service dividers just because there are two names in the page title.

**Grounding note (per `build-guide.md` §2):** Amazon Ads Management's Growth/Bloom/Harvest tiers only had a price in `Services-info.html` (no separate feature list beyond the Starter/default option's "Up to $5k ad spend" / "1 strategy call") — per the existing "shared feature list across scaled tiers" rule, the higher tiers use a deliberately generic, still-true pair of bullets ("Scaled ad spend management" / "Ongoing strategy support") rather than inventing specific spend caps or deliverables for those tiers that aren't in the source data.

**Sitewide merge-and-relink, since this absorbed a real live page:** `walmart-ads-management.html` is deleted outright, not left as a redirect stub or orphaned file — its exact pricing/copy was folded into this page's Walmart section first (verified against the old file before deleting it), then every real reference to it was found (`Grep` for the filename across all `.html`, not just the obvious nav spots) and repointed: `header.html`'s desktop mega-menu and mobile menu both collapsed a 4-link "Paid Advertising" subgroup (3 `is-soon` placeholders + 1 real Walmart link) down to one real link now that the whole subgroup is live; `all-services.html`'s directory card was replaced (new icon, combined description, combined price range) rather than just re-pointing its href; `amazon-listing-store-setup.html`'s 3 Walmart cross-sell mentions (FAQ JSON-LD, inline pricing link, visible FAQ answer) were reworded, not just re-linked, since "See our Walmart Ads Management page" no longer describes what's at the new URL. `sbs-megamenu-preview.html` (client reference file) and `Services-info.html` (pricing source-of-truth export) were deliberately left untouched — neither is our output.

---

### 5.29 Primary-Grid + Secondary-Single-Offer Pricing — "CRM Build, Setup & Management" (`crm-build-setup-management.html`)
Second of the new combined-service pages (2026-09-21). Combines two `is-soon` mega-menu placeholders (CRM Build & Setup, CRM Management) into one page — no existing live page absorbed this time, so no delete/relink sweep, just two new real links replacing two `is-soon` ones in `header.html`'s existing "CRM" subgroup (which also keeps its pre-existing real `Go High Level (GHL)` link untouched, since GHL is a separate live product, not part of this merge).

**Pricing shape is different again from both prior pages** — not a multi-platform combine (§5.28) and not a single 4-tier dropdown. `Services-info.html` gives **CRM Build** as one 3-option dropdown (Automation Build $350, Starter Setup $750, Full Build & Training $3,000 — one-time) and **CRM Management & Optimization** as a single flat non-tiered $500/mo card. Per `build-guide.md` §4's "decide which flow is primary vs. secondary" guidance: CRM Build (3 real tiers, the thing a new client orders first) is the **primary** flow and gets a proper tier grid; CRM Management (one flat ongoing add-on, the thing an *already-built* CRM needs) is **secondary** and gets a single centered highlighted offer box instead of being forced into a fake tier grid.
- New `.pricing-grid-3` (a straightforward 3-equal-column sibling of the existing `.pricing-grid-4`) for the CRM Build tier cards — same `.pricing-card-col` component as every other tiered page, just three of them instead of four.
- New `.single-offer-wrap` (`max-width: 380px; margin: 0 auto;`) wrapping a single `.pricing-card-col.is-featured` for CRM Management — reuses the exact same card component as the tier grid (no new visual language), just presented alone and centered instead of in a grid, so it doesn't look like a 4th tier of the build grid it's describing.
- Both blocks sit under their own `.pricing-divider` inside the same `.pricing-outer-container`, same pattern as §5.28's per-platform dividers.

**A source-data inconsistency was caught and deliberately not reproduced, per this round's "no misleading content" directive:** `Services-info.html`'s `CRM Build` dropdown's shown feature list (for the default "Starter Setup" option) is `Workflow tweaks / Data cleanup / Monthly review / Ongoing optimization` — but "Monthly review" and "Ongoing optimization" are recurring-sounding deliverables listed under a **one-time** price, and that exact same 4-item list is *separately, independently* given as `CRM Management & Optimization`'s own feature list (the actual $500/mo ongoing service), where it's internally coherent. This reads as a copy-paste duplication in the source configurator, not a real claim that a one-time build includes ongoing monthly reviews forever. Rather than either blindly reproducing a self-contradictory claim (misleading) or silently inventing different build-tier features (fabricating), the CRM Build tiers show only the two items that plausibly describe one-time build work (`Workflow tweaks`, `Data cleanup`; Full Build & Training additionally shows `Team training`, since that tier's name explicitly promises it) — the full, unedited 4-item list stays on CRM Management, where `Services-info.html` gives it a second time and it's actually accurate. **General lesson: "ground truth" data can itself contain internal contradictions (a duplicated feature list pasted under the wrong price shape) — when two data points from the same source directly contradict each other, that's a real defect to flag/route around via judgment, not something to launder onto the page as fact just because it's technically "in the data."**

**Reciprocal cross-link added, not just a one-way link from the new page:** `crm-build-setup-management.html` links out to `/go-high-level-service/` (pricing-inline-link, a story row, and an FAQ item — "want it all in one platform instead?"), and since GHL's own existing FAQ ("Can you migrate my existing CRM into GHL?") answers the migrate-in direction but never addressed "I don't want GHL's funnel/marketing bundle, just a CRM," a new FAQ item (visible + JSON-LD) was added to `go-high-level-services.html` itself pointing the other way, rather than leaving the relationship one-directional.

---

### 5.30 Merging a New Service *Into* an Existing Live Page — "Marketing Visibility Package" → `local-seo-google-business-services.html`
Third of the new-page batch (2026-09-22), and a genuinely different case from §5.28/§5.29: no new URL was requested. The client's instruction was to combine `is-soon` "Marketing Visibility Packages" directly into the *already-live* Local SEO & Google Business Profile page — same page, same URL, expanded scope. This is the pattern to reuse for any future "merge into an existing page" request (distinct from "combine several `is-soon` items into a brand-new page," §5.28/§5.29's pattern).

**Scoped, non-destructive CSS addition — new grid, new card class, zero changes to the existing card's styling.** The page's pre-existing `.pricing-card-col` (used for the single Local Domination Package offer) is unconditionally centered/always-blue-bordered — it has no "plain vs. featured" tier concept, because until now it only ever rendered one card. Rather than retrofitting that shared class to support both the old single-offer look and a new 4-tier grid (risking a visual regression on the untouched Local Domination card), the new tier grid uses its own parallel class, `.mvp-tier-card` (+ `.pricing-grid-4`, + `.mvp-featured-badge`), modeled on the `.pricing-card-col`/`.featured-badge` convention from §5.28/§5.29 but fully self-contained. **General lesson: when adding a new pricing shape to a page whose existing single-offer card was never designed to have variants, give the new shape its own class rather than overloading the old one "since it looks similar" — a shared class two different call sites depend on is exactly what turns a scoped addition into an unintended regression.**

**Same source-data "shared feature list across tiers" rule as §5.28/§5.29, applied a third time:** `Services-info.html`'s `Marketing Visibility Package` dropdown only gives full feature detail for the default "Basic" option (GBP optimization / 12-15 keywords / 2 content pieces/mo / 6 social posts/mo) — the same list is shown on all 4 tiers (Basic $1,500/mo through Elite $7,500/mo) per the established rule, with an honest `.pricing-tier-note` disclaimer ("scope scales with tier — Basic tier's scope shown above") rather than inventing specific per-tier scope numbers that aren't in the source data.

**Page-level framing updated everywhere the added scope shows through, not just the pricing section** — this is the operational meaning of "eyebrow/title must match content" (§5.27) applied proactively during a merge, instead of reactively during an audit: meta description, `og:description`, the `Service` JSON-LD `description` and `offers.highPrice` (149→7500), the page banner's `<h1>` subtitle, the hero lead paragraph and footnote, a new alternating story row, 2 new FAQ items (visible + `FAQPage` JSON-LD), and the pricing section's own header copy ("One core package, plus focused add-ons" → "One core package, focused add-ons, or an all-in-one visibility package") all changed. Leaving any one of these stale after a scope-expanding merge would recreate exactly the "eyebrow promises X, content only delivers Y" class of bug documented in §5.27 — a merge into an existing page needs the same full-page consistency pass as building a new one, not just a pricing-block insertion.
- **What was deliberately left alone:** the trust ribbon's 3 existing stats (`$750/mo` Local Domination, `5` Local & GBP Services, `5 or 10 sq mi` 3-Pack radius) are still individually true after the merge — none became wrong, they're just no longer the *complete* picture. Per the established "don't force a 4th filler stat just to be exhaustive" precedent (`home-body.html`'s trust ribbon, §5.14), and since the Marketing Visibility Package is already prominent in the hero, pricing grid, story row, and FAQ, the ribbon was left at 3 stats rather than padded to fit the addition.

**Nav cleanup removed a whole placeholder subgroup, not just relabeled it:** `header.html` had a standalone "Marketing Packages" mega-menu subgroup (in the "Market & Brand" column) whose only entry was the `is-soon` "Marketing Visibility Packages" link. Since that service now lives inside the existing "Local SEO" subgroup's real link, the entire "Marketing Packages" subgroup (both desktop mega-menu and mobile menu) was deleted outright rather than pointed at the Local SEO URL — a second nav entry for content that's one click away inside another page would be a confusing duplicate link, not a helpful shortcut. `all-services.html`'s existing Local SEO card was updated in place (description + price range widened to `$149 – $7,500 / mo`) rather than a second directory card being added, since this is still fundamentally one service page, not two.

---

### 5.31 "Social Media Setup & Management" (`social-media-setup-and-management.html`)
Fourth of the new-page batch (2026-09-22). Straightforward instance of the §5.29 primary-grid + secondary-single-offer pattern (same shape as CRM Build/Management) — `Services-info.html`'s `Social Media` category has exactly two services: **Social Media Management** (a 3-option dropdown by posting volume — 5/mo $450, 12/mo $900, 20/mo $1,250, each covering up to 3 networks) as the primary `.pricing-grid-3`, and **Social Account Setup** ($325 one-time, per profile — handle reservation + branded profile image) as the secondary `.single-offer-wrap` offer, reusing both component classes verbatim from `crm-build-setup-management.html` rather than re-deriving them.
- **Ordering follows the real dependency, not just "biggest service first":** Account Setup is a prerequisite for a client with no existing profiles, so the copy (hero footnote, story row 2, FAQ) explicitly frames it as "only if you don't already have social profiles" / "so your accounts are ready before Social Media Management starts posting" — the two services are ordered Management-first in the pricing section (it's the bigger, more central offering) but the *narrative* makes the actual real-world sequencing (setup before management, for new accounts) explicit rather than leaving the reader to guess which comes first.
- **Deliberately excluded, not overlooked:** `Services-info.html`'s "Google & Meta Ads" category includes `Meta Boost Posts | Setup` and `Meta Boost Posts | Ongoing` — these sound social-media-adjacent by name, but they're **paid** promotion of existing posts (an ads-spend product, already scoped into `paid-advertising.html`'s Meta Ads section in §5.28), not organic content management. Including them here would have double-listed the same two `Services-info.html` cards under two different pages with two different order links. A pricing-inline-link, a story row, and an FAQ item all point from this page to Paid Advertising for exactly this "organic vs. paid" distinction, so a reader looking for boosted-post pricing isn't left without a path — but the actual pricing card only appears once, on the page that owns it.

---

### 5.32 URL Collision Caught Before Building — "Newsletter" (`newsletter-services.html`, not `/newsletter/`)
Fifth of the new-page batch (2026-09-22), and the first one where the client's literal requested URL was already taken by something unrelated. The client asked for a combined newsletter *service* page at `/newsletter` — but `newsletter.html` already exists and is live: a "Subscribe to Our Newsletter" page (a Brevo email-capture form) for *readers* to subscribe to Sites by Sara's own company newsletter, linked from the header's utility nav and footer as "Newsletter Archive" / "Subscribe to Newsletter". Building the new client-facing service page at that same URL would have silently overwritten a different, unrelated, already-functioning page.
- **Caught by checking for the literal file before writing it, not assumed away.** The instinct to "just use the URL the client gave" would have been wrong here — the client's naming request and the existing site's own information architecture collided, and the existing page wasn't something to guess about overwriting.
- **Escalated instead of silently picking a resolution.** Given the destructive potential (a live, linked, functioning subscribe form is not a placeholder — overwriting it isn't reversible via this project's normal "just re-edit the file" workflow, since the form's Brevo integration details would be gone), this was a genuine call for the client to make, not a judgment call to make alone. Presented with the conflict and 3 concrete resolutions (two alternate-URL options, one "move the existing page" option); client picked **`/newsletter-services/`**, leaving `newsletter.html`/`/newsletter/` completely untouched.
- **General lesson: before creating a new page at a client-specified URL, check whether that exact path already resolves to something live** — a quick `Grep` for the target filename/URL across the project, the same reflex already used for the "is this an existing real page vs. an `is-soon` placeholder" check in `build-guide.md`'s research step, just applied to the *destination* URL instead of the *service name*.

**Otherwise a standard primary-grid + addons-grid page** (same pricing shape as §5.28's Google/Meta Ads blocks, not the primary+single-offer shape of §5.29/§5.31): `Services-info.html`'s "Email Marketing" category has one 3-tier dropdown (**Newsletter Management** — Monthly $150/mo, Bi-Weekly $275/mo, Weekly $450/mo, `.pricing-grid-3`) plus 5 genuinely separate one-time services (Template Design $500, Deliverability & Domain Verification $180, Email List Import $65, Subsequent Campaign Send $250/send, Email Metrics Reporting $35/report — all in one `.pricing-addons-grid`, 4-per-row with the 5th wrapping naturally). A planned cross-link to a "Copywriting" page (for newsletter content writing) was written into the first draft, then removed before shipping — `/copywriting/` doesn't exist yet (it's a later page in this same batch), and this project's own rule is to never link to a page that isn't real; the cross-link is a candidate to add back once that page exists, not before.

---

### 5.33 "Graphic Design & Branding" (`design.html`) — Presenting Genuinely Different Products as an Ascending Tier Grid
Sixth of the new-page batch (2026-09-22). `Services-info.html`'s "Graphic Design" category is the largest single-category merge in this batch — 10 services, none of them dropdown/tiered on their own, ranging from a $15 business-card edit to an $8,500 brand-development engagement. The mega-menu's `is-soon` placeholder for this whole category was just one item, "Branding Package" — a reminder that a placeholder's name in the nav isn't necessarily the full scope of what it stands for; `Services-info.html`, not the nav label, is what actually defines the category (per `build-guide.md` §1's research order).
- **Verified the URL had no real conflict before reusing the client's exact requested slug.** Page 5 (§5.32) needed a substitute URL because `/newsletter` was already live; this page's requested `/design` had no existing `design.html` — confirmed by checking, not assumed — so unlike §5.32, the client's exact requested URL was used as-is. (`design.md`, this very file, is a different filename entirely — no collision.) The file was briefly drafted as `design-services.html` out of the same over-caution that page 5's real conflict justified, then renamed back to `design.html` once the "no such file" check came back clean — a reminder not to let one genuine collision (§5.32) generalize into avoiding every literal requested URL by default.
- **Four genuinely distinct products presented as an ascending 4-tier grid, not a "tier" in the dropdown sense.** Basic Logo ($500) → Logo Design Package ($1,000) → Branding Package ($2,200) → Brand Development ($8,500) are four separate `Services-info.html` cards with their own independent feature lists (not one dropdown card with shared/scaled features, unlike every prior tier grid in this batch) — but they form a natural scope progression, so they're grouped into one `.pricing-grid-4` for presentation, each card keeping its own real, distinct feature list (no shared-list rule needed here, since each tier's list is separately grounded in the source data). This is a different flavor of "primary grid" from §5.28's platform-divided grids or §5.29/§5.31's dropdown-tier grids — worth remembering as a third valid shape: same visual component, different underlying data relationship (independent products vs. one scaled service).
- **The remaining 6 services are a flat `.pricing-addons-grid`** (Business Card Design $300, Business Card Edit $15/card, Envelope Design $75, Poster Design $250, Postcard Design $450, Mailer/EDDM Design & Printing — custom quote), 3-per-row.
- **Custom-quote item handled the same way as every other page's custom-quote items:** Mailer/EDDM Design & Printing has no fixed price in `Services-info.html` (shown as "TBD" in the Configure Wizard Links tool) — the addon card shows `"Custom Quote"` as its price tag instead of a dollar figure, and its `Order Now` link still points at its real order ID (`#42`) since a custom-quote item still has a real, live configurator entry, it just doesn't have a fixed number to display. Excluded from the page's own JSON-LD `AggregateOffer` price range (`lowPrice`/`highPrice` are both drawn only from the 9 fixed-price items) rather than guessing a number for it.

---

### 5.34 "Copywriting & Content Writing" (`copywriting.html`) — Final Page of the Batch, and a Real Non-Monotonic Price Left As-Is
Seventh and last of the new-page batch (2026-09-22). `Services-info.html`'s "Content & Copywriting" category: one 6-option dropdown (**Content Writing**, priced by word count — 150/250/500/750/1000/1500 words) as the primary `.pricing-grid-3` (6 cards, wraps to 2 rows of 3 — the same grid class reused a third time, now proving out at a 4th, 5th, and 6th item count after 3-item and 4-item uses elsewhere in this batch, confirming it as a genuinely reusable "N small tier cards" component rather than a one-off), plus 3 one-time/per-word services (Blog Post Add-On $437/post, Human Content Writing $0.25/word, AI-Human Hybrid Content Writing $0.20/word, min. 250 words) in one `.pricing-addons-grid`.
- **A real internal inconsistency in the source data was left exactly as-is, not "fixed."** The Content Writing dropdown's prices are *not* monotonically increasing with word count: 150w=$45, 250w=$75, 500w=**$1,000**, 750w=$225, 1000w=$250, 1500w=$375 — the 500-word tier costs 4-13x more than every neighboring tier despite being priced by the same per-word logic as the rest. Verified via the Configure Wizard Links tool independently (not just `Services-info.html`'s own display) that `$1,000` is the real, live order price at ID `#68`, not a copy-paste or OCR-style error on this project's side. Unlike the CRM Build duplicate-feature-list case in §5.29 (where two *different* cards contradicted each other, making one demonstrably wrong), this is a single card with an internally-plausible-if-unusual price and no contradicting second data point to weigh it against — there's nothing to reconcile, just an unusual number. Per `build-guide.md` §2's "state plainly from the data, don't invent" rule, the tier displays $1,000 for 500 words exactly as given, in its natural word-count position in the grid (not reordered by price, which would scatter the tiers out of intuitive reading order) — a real example of the "no misleading content" standard meaning *report the real number accurately*, not *make the real number look more sensible*.
- **Two per-word (not per-piece) services get a price-tag format not used elsewhere in this batch:** Human Content Writing and AI-Human Hybrid Content Writing both have `price-empty` entries in `Services-info.html` (no flat card price, only a `svc-card-note` rate) — same shape as the Mailer/EDDM "Custom Quote" case in §5.33, but with a real, displayable number this time (a rate, not "TBD"). The `.addon-price-tag` shows `"$0.25 / Word"` / `"$0.20 / Word"` instead of a dollar amount, which is more informative than "Custom Quote" would have been here since these genuinely do have a fixed, known price — it's just denominated per-word instead of per-piece.
- **Reciprocal cross-links completed on both sides, closing out two links deferred earlier in the batch:** `newsletter-services.html` (§5.32) had a Copywriting cross-link written and then deliberately removed because this page didn't exist yet — it's added back now. `design.html` (§5.33) gets a new second `.pricing-inline-link` to this page (previously only linked to Newsletter), alongside this page's own outbound links to both Design and Newsletter — every page introduced in this batch that has a natural content/design pairing now links to its pair in both directions, not just forward to whichever page happened to be built first.
- **Batch-closing nav check:** after this page's `header.html` update, a `Grep` for `is-soon" href` across the whole file returned zero real matches — every mega-menu/mobile-menu link that was `is-soon` at the start of this batch (Paid Advertising's 3 sub-items, CRM's 2, Social Media's 2, Email Newsletter's 2, Design & Copy's 2 — 11 placeholder links total across §5.28-§5.34) is now a real link to a real page. The `.is-soon` CSS rules and the JS `querySelectorAll('.is-soon')` wiring were left in place (dead but harmless) rather than removed, since a future new service will need the same placeholder pattern again.

### 5.35 Corrected Audit Principle — Eyebrows Flex To Match Real Content, Never The Reverse (2026-09-22)
The §5.27 audit made one real mistake: on `about.html`, a section's eyebrow ("Meet The Founder") didn't match its body paragraph (real, original live-site copy that only mentioned the founder's name once, not an actual founder bio). The fix applied at the time **rewrote the real paragraph** — adding invented framing ("led it ever since," "Nearly two decades later") — to make it match the eyebrow. This was backwards. **Corrected principle, applied in this full re-audit:** the eyebrow/title is the thing this project added; the body copy underneath is usually the real, original content. When the two don't match, reword the eyebrow to fit the real content — never rewrite real content to fit an eyebrow. Content itself should only change to correct a specific wrong/stale fact (a number), preserving the original sentence's structure and meaning, never to add new claims or framing.
- **about.html fix:** reverted the "Meet The Founder" paragraph to its original wording (only "10 years"→"19 years" corrected numerically) and changed the eyebrow to "About The Agency."
- **Full re-audit dispatched:** 4 parallel read-only agents covering every page on the site (build-category pages, maintain/grow pages, the 7 new combined-service + company pages, and homepage/info pages + header), each given the corrected principle verbatim plus a new image-vs-content mismatch check. Result: the about.html case was the only real eyebrow-vs-content violation found anywhere — every other eyebrow/title on the site already matches its real content.
- **Genuine bugs found and fixed directly** (factual/numeric errors or leaked markup, not eyebrow-vs-content issues): `hourly-dev-blocks.html`'s WHAM Plus Hour Blocks Tier 2/3 cards wrongly reused Tier 1's "3 hours... for the rate of 1" bullet instead of stating their own 6/9-hour counts (also fixed in the visible FAQ + its JSON-LD mirror); `custom-development.html`'s FAQ JSON-LD was missing "24/7" that the visible answer includes; `giving-back.html`'s Aug. 2024 sponsorship card title only named one of the two organizations the real body copy covers (widened the title, left the body untouched) and had a stale `aria-label="Total Contributions"` left over from the §5.27 retitle; `support.html`'s ContactPage JSON-LD listed `addressLocality: "Salt Lake City"` under a ZIP (84107) that is actually Murray, UT — corrected to match the Murray, UT claim used consistently on `contact-us.html`/`book-a-free-consultation.html`; `home-body.html` had three internal-link drifts (a "View Our Portfolio" button pointing to a nonexistent `/our-portfolio` slug instead of the real `/portfolio/` convention, a hero "View Our Services" button pointing to a nonexistent `/services/marketing/` instead of the real `/all-services/` hub, and a "View Our Success Stories" link using `/testimonials/` instead of the real `/what-our-clients-say/` slug used elsewhere on the same page); `cybersecurity-packages.html` had a WordPress popup shortcode (`[sg_popup id="14928" event="click"]...[/sg_popup]`) leaked as literal visible bracket text around 4 separate CTA buttons in this static export — stripped the shortcode text (the button's real click-behavior still needs wiring to a real popup/lead-form destination, left as an open item since no real destination exists in this static export to point to).
- **Re-confirmed as already correct, not new findings:** `giving-back.html`'s earlier "Total Contributions"→"A Recent Contribution" retitle (§5.27) was the right call under this principle — the body was always a single real donation, never a running total. `copywriting.html`'s non-monotonic "500 words = $1,000" price (§5.34) was already independently verified against the real Configure Wizard order link before shipping — not a new/unverified anomaly.
- **Items surfaced for the business owner, not auto-fixed** (each requires a real-world fact or business decision this project has no way to look up, so per the "never guess/invent a number" rule they're reported rather than resolved): a direct contradiction between `seo-plans-site-audit.html`'s FAQ ("GA/Search Console setup is a separate service") and `google-analytics-search-console-setup.html`'s FAQ/hero/trust-ribbon ("included with any SEO plan," stated 3 times) — pick one and align both; 4 email add-on services on `email-setup-migration.html` (Outgoing Assistance, Company Catch-All, Send & Reply As Another Alias, Email Group Setup) with no matching entry in `Services-info.html` or the live order system, kept as real (per a standing project memory noting these are known not to map 1:1 to the configurator) rather than removed; `go-high-level-services.html`'s Order Now button is wired to `href="#"` (no real order ID exists yet) and its $3,000+$500/mo pricing is only inferred from generic CRM catalog entries that never mention "GHL" by name — **explicitly left untouched per the user's instruction** in §5.36; unsourced/inconsistent uptime claims ("99.999%" on `wordpress-maintenance-bundle.html` vs. "99.9%" on `simple-site-hosting-bundle.html`, same underlying hosting); `cybersecurity-packages.html`'s "Certified IT Assessment" claim has no supporting detail on the page; and both `seo-plans-site-audit.html` and the Marketing Visibility Package tiers on `local-seo-google-business-services.html` show identical feature bullets across tiers with a 2-5x price spread (source data only ever exposes detail for the default/cheapest option, same limitation noted in §5.29/§5.33/§5.34).

### 5.36 Full Coverage Cross-Check Against the Live Order System (2026-09-22)
The user asked for a direct check against the "Configure Wizard Links" artifact (the live order-system catalog, 128 services — see the `reference-order-link-generator` memory) rather than just re-checking `Services-info.html` again: does every real, live service have a home somewhere on the site? Read through the artifact's full catalog (all 20 categories, scroll-captured via the Browser pane since it renders in a cross-origin sandboxed iframe with no accessible DOM/network payload) and cross-referenced each category against the page(s) that should cover it.
- **Result: only 2 real gaps, both now fixed.** Every other category (WordPress Website, E-Commerce, Shopify, Simple/Static Site, Hosting, Graphic Design, SEO, Google & Meta Ads, Social Media, Amazon Marketplace, Website Care, CRM, Content & Copywriting, Development: Other, Walmart Ads) was already fully represented on its corresponding page, confirming the 4-agent audit's per-page pricing checks in §5.35 were accurate.
- **Gap 1 — "Press Release Distribution" ($150, card-64) and "Press Release Writing & Distribution" ($275, card-65)** existed in `Services-info.html`'s Marketing category but were not on any built page. Added as a new "Press Release Distribution" addon block on `copywriting.html` (the natural home, since one variant includes writing the release) with real Order Now links.
- **Gap 2 — "Local SEO Plans" (card-52, a `dd-card` with 4 tiers: Starter $350/mo, Growth $500/mo, Bloom $650/mo, Harvest $2,250/mo)** was completely absent from `local-seo-google-business-services.html`, which only covered the separate flat-rate "Local Domination Package" ($750/mo). Added as a new 4-tier `.pricing-grid-4` block (same "same feature list across tiers + scope-scales-with-tier footnote" pattern as the page's existing Marketing Visibility Package block, since the source data only exposes full feature detail for the default/Starter option) plus a new FAQ item (visible + JSON-LD) distinguishing it from Local Domination Package so the two don't read as redundant.
- **Bonus finding — resolved, not just reported:** cross-referencing the order system's "Google Workspace / Microsoft 365 Setup & Migration" category (4 real items: Initial Setup $350 one-time *including* 1 free migration up to 10GB [card-118], Email Migration $225/account for anything beyond that [card-119], Email Account Setup $59 [card-120], Email Alias Setup $29 [card-121]) against `email-setup-migration.html` surfaced the exact contradiction flagged as unresolved in §5.35 — the page's own top pricing card charged **$500** for setup-with-migration and reserved $350 for a "no migration" discount, backwards from the real $350-already-includes-migration structure confirmed independently by both `Services-info.html` and the live order system. Fixed: card price $500→$350, added a real Order Now link (`?id=118`, previously just linked to a "Contact Now"/`/contact/` button with no real destination), reframed the "Full Data Migration" ($225/account) card's copy from looking like a required second cost to being for migrations *beyond* the included 10GB or migration-only engagements, corrected the FAQ answer and JSON-LD to match, and updated the page's stale `/contact/` links (3 of them) to the real `/contact-us-2/` slug used elsewhere on the site. The page's other 2 cards (Outgoing Assistance $39, Company Catch-All $250) and 2 of its 4 addon items (Send & Reply As Another Alias $129, Email Group Setup $59) still have no matching order-system entry — left as-is, treated as real custom-quote-only services per the standing project memory on this exact page, not removed.
- **GHL exception:** the user explicitly said to leave `go-high-level-services.html` untouched in this pass (its broken Order Now link and unverified CRM-catalog price mapping, both noted in §5.35, remain open).

### 5.37 Terms of Service & Privacy Policy — Verbatim Legal Content, Design-Only (2026-09-23)
The user asked for these two pages with the explicit instruction: exact same content, no changes allowed, except correcting anything date-related that's genuinely stale. Pulled both pages live from `sitesbysara.com/terms-of-service/` and `sitesbysara.com/privacy-policy/` (via the Browser pane, since neither existed anywhere in this project) and transcribed the text verbatim — including the source's own inconsistent capitalization/punctuation quirks (e.g. "site edtior" typo in Terms §12, "this section 7" self-reference inside what's numbered §8, the bracketed `[Brevo] — [purpose...]` placeholder-style entries in Privacy's Third-Party Sharing list) rather than silently correcting them, since the instruction was content-verbatim, not copyediting.
- **Date check: nothing needed updating.** Both pages share "Last updated: April 10, 2026," which predates today (2026-09-23) and is therefore a real, still-valid historical edit date, not a stale figure — left untouched. Privacy's "At this writing (4/2026), we do not currently use AI tools..." parenthetical is internally consistent with that same date. No calendar dates anywhere in either document needed correction.
- **Bonus cross-check:** Privacy Policy's real contact address ("5769 S Sagewood Drive, Murray, UT 84107") independently confirms the `support.html` JSON-LD fix made in §5.36 (which corrected `addressLocality` from "Salt Lake City" to "Murray" based on the ZIP code alone, before this page's content was pulled) was the right call.
- **Design approach:** built `terms-of-service.html` and `privacy-policy.html` as a shared "legal document" template — the standard `page-title-banner` (brand gradient) + a small meta bar (For/Website/Last-Updated pill) + a sticky-on-desktop table-of-contents sidebar with anchor links into each numbered/named section, collapsing to a full-width card above the content on mobile (`@media max-width: 900px`). This is new page-chrome/navigation scaffolding around the real content, not a content change — no sentence, number, or list item was reworded, reordered, or omitted from either source page.
- **Filenames match the real live slugs** (`/terms-of-service/`, `/privacy-policy/`) already referenced in `footer.html` — no other file in the project referenced these pages, so no other links needed updating.
- **Correction (2026-09-23):** the real slugs on the dev server are actually `/terms-of-service-2/` and `/privacy-policy-2/` (the plain slugs are occupied by older pages, same "-2" pattern already established for `/contact-us-2/`). Renamed both files to `terms-of-service-2.html` / `privacy-policy-2.html` and updated `footer.html`'s two legal links to match. The one real quoted URL inside `terms-of-service-2.html` itself (§16(e)'s `https://www.sitesbysara.com/privacy-policy/`, pointing at the live public site, not this dev server) was left as-is — that's real source content referencing production, not an internal nav link.

### 5.38 Services Mega-Menu Rebalance (2026-09-23)
The 4-column Services mega-menu (`header.html`, both the desktop grid and the mobile accordion) had two real problems, not just a subjective "looks off": columns were badly imbalanced (Build had 10 items across 3 subgroups while Market & Brand had only 4 across 3), and 7 of its 13 subgroups contained exactly one link each (Shopify, SEO, Local SEO, Analytics & Tracking, Paid Advertising, Social Media, Email Newsletter) — each got a full bordered subgroup box and label for a single item, which is what actually reads as "ugly": lots of wasted header chrome for no real grouping benefit.
- **Regrouped by actual service relationship, not just to hit even counts** — e.g. Merchant Processing Add-On moved from a generic "Other Services" catch-all into "WordPress & E-Commerce" (it's a checkout add-on for those builds); Site Audit & Priority Fixes moved from Build into Grow's "SEO & Visibility" (its own page already bundles optional GA/GTM + GSC add-ons, so it's a technical-SEO service, not a one-time dev project); Hourly Dev Blocks moved from Build into Maintain & Protect's new "Ongoing Support" subgroup (it's a recurring retainer, not a one-time build, paired naturally with Website Care); Go High Level + CRM Build/Setup/Management moved from Grow into Market & Brand's new "CRM & Automation" subgroup (customer-relationship/communication tooling reads closer to email/social nurture than to traffic-acquisition SEO/Ads).
- **Result:** Build 8 (WordPress & E-Commerce ×4, Simple & Static Sites ×2, Apps & Marketplaces ×2), Maintain & Protect 6 (Hosting & Maintenance ×2, Ongoing Support ×2, Security & Email ×2), Grow 5 (SEO & Visibility ×4, plus a single bare Paid Advertising link with no wasted label since there's no natural sibling for it), Market & Brand 6 (Content & Design ×2, Social & Email Marketing ×2, CRM & Automation ×2) — 25 links total, same as before (verified via `grep` that every real href survived the move with none dropped or duplicated). Column-height variance dropped from a 10-vs-4 spread to 8-vs-5.
- **Mobile accordion brought in sync and improved beyond parity:** the mobile Services panel previously had *no* top-level grouping at all — its 13 subgroup labels just ran together in one flat list with zero indication of Build/Maintain/Grow/Market structure. Added a new `.custom-m-top-title` style (bold, navy, larger than the existing `.custom-m-group-title`, with a small color-coded dot matching each column's desktop icon color) as a section divider between the 4 top-level groups, so mobile now shows the same structure as desktop instead of a flatter, less legible version of it.
- Verified in the Browser pane at both desktop (1440px, forced `.custom-is-open` via `javascript_exec` since click/hover doesn't fire on a standalone `file://` snapshot) and mobile (375px) — both render correctly, and a `grep` diff confirmed the mobile and desktop link sets are identical (25 hrefs each, same set).

### 5.39 Tabbed Portfolio Gallery With Lightbox (`design.html`, 2026-10-08)
Brought over from the live `/marketing/branding-and-graphic-design` page (Logo Design, Print Designs, Branding tabs; the live "Websites" tab was left out because those projects live on `/our-portfolio/`). Built on §5.16 (horizontal pill tablist, one `.is-active` panel at a time), with these differences for artwork that must never be cropped:

- **Natural proportions, no crop.** Every `<img>` is `width:100%; height:auto` with its real `width`/`height` attributes. Logos and print pieces are 1024x824, the Branding boards are 16:9, and a 4-column row only ever holds one proportion (Branding is exactly 4 + 4). Cards in a row stretch to equal height (`align-items: stretch`) so a two-line caption does not leave a ragged bottom edge. A short last row stays left-aligned (§5.16).
- **Grid:** `repeat(4, 1fr)` desktop, `repeat(2, 1fr)` at `<=900px`, `1fr` at `<=600px`. The tablist scrolls horizontally on narrow screens instead of wrapping.
- **Card = `<figure class="portfolio-card">`** holding a `<button class="portfolio-thumb">` (zoom icon bottom-right, always visible on touch via `@media (hover: none)`) and a `<figcaption>` with the client or piece name. `.portfolio-card` is a checker-skipped class, so client names containing digits are allowed there.
- **Lightbox** (`#portfolioLightbox`, `role="dialog"`, `aria-modal`): click or Enter on a thumbnail opens it; it browses only the images of the open tab (previous/next buttons and Left/Right arrow keys, wrapping); Escape, the close button or a backdrop click closes it; focus moves to the close button, is trapped among the three buttons, and returns to the thumbnail that opened it. Page scrolling is locked while open.
- **Tabs are accessible:** `role="tablist"/"tab"/"tabpanel"`, `aria-selected`, `aria-controls`, roving `tabindex`, Left/Right/Home/End keys.
- **Images come from the existing Media Library through the image CDN** (`https://i0.wp.com/sitesbysara.com/wp-content/uploads/...?fit=W%2CH&ssl=1`). Oversized originals (a 4608x2592 PNG weighs 4.2 MB) are never loaded as-is: thumbnails use `fit=800%2C450` and the lightbox `fit=1600%2C900`. All images are `loading="lazy"`, so the hidden tabs cost nothing until opened.
- **Buttons need explicit `:hover/:focus/:active` resets** (background and `color ... !important`) because Hello Elementor styles bare `button` elements pink on hover.

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
