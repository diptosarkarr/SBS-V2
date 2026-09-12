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
> **Strict No-Emoji Rule:** Never use emojis anywhere on the site. Always use crisp, scalable inline SVG icons styled with SBS palette tokens.

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

<!-- Card Action Buttons -->
<a href="/contact/" class="btn-plan btn-plan-primary">Book Consultation</a>
<a href="/contact/" class="btn-plan btn-plan-outline">Select Service</a>
```

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

#### 5.6.1 Collapsible Full Tier Breakdown (Many-Tier Services)
Some services (e.g. a page-count-scaled WordPress build) have far more pricing tiers than fit cleanly in a 4-card grid — rendering all of them as flat rows reads as a wall of text and was flagged as looking "weird" on review. For any service with **more than ~4 tiers**:
1. Group the tiers into 3–4 representative cards using the standard pricing-card pattern above. Use the source's own named tiers where given (e.g. `"Starter"`, `"Standard"`), and a literal quantity/page range as the card title where the source has no name (e.g. `"21–100 Pages"`) — never invent a category name like "Growth" or "Enterprise" that isn't in the source.
2. For a grouped/ranged card, show **"Starting at $X"** using the true lowest price inside that bracket. Never average, round, or invent a number.
3. Preserve every exact tier by putting the full breakdown inside a `<details class="pricing-breakdown-details">` / `<summary class="pricing-breakdown-summary">` disclosure below the grid, reusing the FAQ accordion's visual language (rotating `+` → `×` icon via `details[open] .pricing-breakdown-icon`, `::-webkit-details-marker` hidden). Nothing is lost — it's deferred, not deleted.

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

### 5.12 Site Footer
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
   - Point `<img src>` at the placeholder WordPress upload path already used across pages — `https://sitesbysara.com/wp-content/uploads/2026/09/{filename}.webp` — so the markup is upload-ready even before the asset exists.
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
- Every service page must link to `all-services.html` (a small "← Browse All Services" link near the footer/end of the page is sufficient).
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
- [ ] Any service with more than ~4 pricing tiers uses the grouped-cards + collapsible-breakdown pattern (§5.6.1), not a flat list of rows.
- [ ] No fabricated "Most Popular"/"Best Value" badges — only labels the source data states or that are objectively derivable.
- [ ] All images are unique, niche-specific, `4:3` ratio, contain no third-party brand names, and are handed off as generation prompts (§6) — not fabricated.
- [ ] No standalone `<header>` or `<footer>` if creating Elementor body templates.
- [ ] **SEO (§7):** unique `<title>` (≤60 chars) and `<meta description>` (150–160 chars); exactly one `<h1>`; every `<img>` has a specific descriptive `alt` plus `width`/`height`; `Service` (and `FAQPage`, if the page has a FAQ) JSON-LD added with real on-page numbers only; links to `all-services.html` and any natural peer/alternative service page.
- [ ] Page previewed in-browser at desktop width — every section scrolled through, any accordion/`<details>` clicked at least once.
- [ ] `all-services.html` gets a new card for this page in the same pass (§5.11) — title, grounded short description, grounded price range, "See More" button.

> For the full research/process checklist (what to read before starting, how to combine multiple services into one page, the image handoff workflow), see **`build-guide.md`** — that file governs *how a page gets built*; this file governs *how it looks*.
