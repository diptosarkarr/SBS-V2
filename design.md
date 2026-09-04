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

| Style | Font Size | Weight | Line Height | Letter Spacing | Color |
|---|---|---|---|---|---|
| **Page Banner H1** | `clamp(2.2rem, 4.4vw, 3.2rem)` | `800` | `1.16` | `-0.025em` | `#FFFFFF` |
| **Page Banner Sub** | `clamp(1.15rem, 2.2vw, 1.45rem)` | `500` | `1.3` | `0.01em` | `rgba(255, 255, 255, 0.94)` |
| **H1 (Hero Heading)** | `clamp(2.4rem, 2rem + 2vw, 3.8rem)` | `800` | `1.12` | `-0.035em` | `var(--navy)` |
| **H2 (Section Titles)** | `clamp(1.85rem, 1.5rem + 1.2vw, 2.6rem)` | `800` | `1.2` | `-0.025em` | `var(--navy)` |
| **H3 (Card Titles)** | `1.2rem - 1.35rem` | `800` | `1.35` | `-0.015em` | `var(--navy)` |
| **Eyebrow / Kicker** | `0.82rem` (13px) | `800` | `1.4` | `0.08em` (Uppercase) | `var(--slate)` |
| **Lead Paragraph** | `clamp(1.05rem, 0.95rem + 0.3vw, 1.2rem)` | `400` | `1.65` | `normal` | `var(--slate)` |
| **Body Copy** | `0.98rem` (15.5px) | `400 / 500` | `1.55` | `normal` | `var(--navy)` |
| **Footnote / Caption**| `0.88rem` (14px) | `400 / 600` | `1.5` | `normal` | `var(--slate-light)` |

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

### 4.2 Section Vertical Rhythm
- **Default Section Padding:** `padding: clamp(70px, 8vw, 110px) 0;`
- **Tight Section Padding:** `padding: clamp(40px, 5vw, 65px) 0;`
- **Hero Section:** `padding: clamp(48px, 6vw, 76px) 0 clamp(40px, 6vw, 70px);`
- **Page Title Banner:** `padding: clamp(52px, 6vw, 76px) 24px;`

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
  font-size: clamp(2.2rem, 4.4vw, 3.2rem);
  font-weight: 800;
  line-height: 1.16;
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
- Text is `0.82rem`, uppercase, `font-weight: 800`, letter-spacing `0.08em`.

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
- **Links (`.story-link`):** `color: var(--brand-coral); font-weight: 700;` transitions to `var(--brand-coral-hover)` with rightward nudge `transform: translateX(4px)`.

---

### 5.6 Pricing Grid & Cards (4-Col or 3-Col)
- Outer container has subtle border and card radius (`--radius-lg: 24px`).
- **Featured Card (`.is-featured`):**
  - Relative elevation with gradient top badge (`Most Popular` / `Recommended`).
  - Outline with `var(--brand-blue)` and subtle floating box-shadow.
  - Primary button (`btn-plan-primary`).
  - Feature checkmarks tinted in brand blue (`#3A539B`).
- **Standard Cards:** Clean white surface, gray border, green checkmarks (`#1E8E3E`), outline button.

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
    font-weight: 800;
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

---

## 7. Responsive Breakpoints & Mobile Rules

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

## 8. Page Construction Checklist for New Pages

When creating any new page for SBS:
- [ ] Has Manrope typography linked and set on `body`.
- [ ] Uses exact CSS variables from `:root`.
- [ ] Starts with `.page-title-banner` using `--brand-gradient` (clean H1 + subtitle, without badge).
- [ ] Uses `.btn-primary` with gradient fill and `.btn-outline` with blue border.
- [ ] Alternating feature rows use `.is-reversed` on even rows.
- [ ] All images are unique, niche-specific, `4:3` ratio, and saved in `images/` or dev server URLs.
- [ ] No standalone `<header>` or `<footer>` if creating Elementor body templates.
- [ ] Includes SEO title tag, meta description, and unique IDs on interactive sections.
