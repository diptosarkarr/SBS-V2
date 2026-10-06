# Sites by Sara — Landing Page Build Guide

> **Purpose:** This is the standing checklist for building any new SBS service landing page. It captures the *process*, research, and data-integrity rules that apply to every page, so they don't need to be repeated in every request.
>
> `design.md` governs **how a page looks** — colors, typography, spacing, component markup/CSS.
> This file governs **how a page gets built** — what to read first, where data comes from, how to structure the work, and how to know it's actually done.
>
> Read both before starting a new page.
>
> **Service page copy rules:** what a page may *say* (no numbers, prices, package/tier names, generic FAQ, short copy) lives in `SERVICE-PAGE-GUIDELINES.md`. Read it too, and run `python scripts/check_service_page.py <page>.html`. Where it conflicts with this file or `design.md` (e.g. price ranges in JSON-LD, "grounded price range" on cards), that file wins.

---

## 1. Required Reading Before Starting Any Page

1. **`design.md`** — the strict visual/component blueprint. Every color, spacing value, and component pattern must come from here. Don't invent a new card style, spacing scale, or color when an existing one already covers the case.
2. **`Services-info.html`** — the single source of truth for service names, pricing, tiers, included features, and requirement notes. This is a live pricing/services configurator export. Every price, feature bullet, and note in it is ground truth for the page being built.
3. **The live site (`sitesbysara.com`)** — browse it for brand voice and agency facts (Salt Lake City / Utah, 10+ years of WordPress experience, serving businesses since 2007, award-winning), and to check whether a page already exists live for the service being built (it may not — some of these are brand-new offerings, e.g. the cybersecurity service).
4. **The existing built pages in this repo** — treat them as precedent, not just reference. Reuse their exact class names and structure rather than inventing new ones. As of this writing: `custom-development.html`, `cybersecurity-packages.html`, `email-setup-migration.html`, `woocommerce-stores.html`, `shopify-ecommerce-store.html`, and the directory page `all-services.html`.
5. **`header.html` and `footer.html`** are a different category from the pages above: they're pasted directly into a live WordPress site (via Elementor HTML widgets in the site's Header/Footer templates), not opened as standalone documents. Every class in these two files is prefixed `custom-` for exactly that reason — see `design.md` §5.12.1 before touching either file, and follow the same convention for any new standalone component meant to be pasted into the live site outside of our own landing pages.

---

## 2. Zero-Assumption Pricing & Content Rule

This is the most important rule, and the one most likely to be violated by default:

- **Never invent a price, feature, tier name, or requirement.** Every number and bullet on a pricing card must trace back to an exact line in `Services-info.html`.
- If `Services-info.html` only gives full feature detail for one option in a dropdown group (usually the default/selected one), and the other options are the *same service* just scaled up (more products, more pages, etc.), it's fine to apply that shared feature list across all tiers of that one service line — that's recognizing they're one service, not fabricating new facts.
- **Never add a "Most Popular" / "Best Value" / similar superlative badge unless the source data explicitly labels it that way**, or the label is objectively derivable from the data (e.g. "Fewest Pages" for the smallest tier). Example: WHAM's `"Standard (Most Popular)"` is grounded and may be labeled as such; a WordPress Website page-count tier with no such label may not be.
- If a service has an add-on that is priced **separately** in `Services-info.html` (e.g. merchant/payment processing on top of a WooCommerce store), never fold it into another package's "included" list — call it out as a separate add-on instead, even if it would read better from a marketing angle.
- When combining two related services into one landing page (as with "WooCommerce Stores" + "WooCommerce Design Refresh"), keep each service's pricing and features scoped to what that specific service's data says. Don't blend numbers across them, and don't imply one service includes something that's actually part of the other.
- If asked to add more "detail" to a card and the source data doesn't differentiate tiers beyond price/quantity, reuse the same grounded feature list per tier rather than fabricating unique bullets per tier just to make cards look different.
- When in doubt about whether something is a fact from the data or an inference you're making, err toward stating it plainly from the data or leaving it out — not toward a persuasive-sounding guess.

---

## 3. Research Before Writing Code

For every new page:
1. Search `Services-info.html` for every category/card relevant to the requested service(s). Note the exact `data-id`, price range, option list, and the feature bullets given for the default/selected option.
2. Check the live site for an existing page covering the same topic (nav menu, footer links, `grep`-style link search via the browser). If one exists, its copy and structure are useful context — but the *pricing and features on the new page must still come from `Services-info.html`*, not scraped from the live page.
3. Check the `images/` folder for any already-generated assets that might be reusable or that establish a naming convention.
4. Skim at least one sibling landing page fully (not just the CSS) to confirm current class-naming conventions before writing new markup.

---

## 4. Page Structure & Flow

Default section order for a new service landing page (deviate only if the service genuinely doesn't fit this shape):

1. Page Title Banner
2. Hero Section — secondary button always links to `#pricing` and reads "View Pricing & Plans"
3. Capability/trust ribbon (icons or stats) — optional but common
4. Pricing Section (`id="pricing"`) — see `design.md` §5.6 / §5.6.1 for card rules
5. Detailed breakdown / process steps (scope grid, typically ~8 steps)
6. Alternating storytelling feature rows (`.story-row`, `.is-reversed` on even rows)
7. FAQ accordion
8. Final consultation CTA banner

If combining two services into one page, decide up front which is the "primary" flow (gets the multi-tier grid) and which is "secondary" (gets a single highlighted offer box, e.g. a Design Refresh box next to a New Build grid) — don't give both equal-weight competing grids unless the source data genuinely supports that.

---

## 5. SEO

Every page must follow `design.md` §7 (SEO Best Practices) from the first draft, not as a post-launch pass:
- Unique `<title>` (≤60 chars) and `<meta description>` (150–160 chars).
- Exactly one `<h1>` — the page banner heading. Everything else is `<h2>`/`<h3>`.
- Descriptive, specific `alt` text on every image — never a filename, never empty, never reused generically across different images.
- `Service` JSON-LD in `<head>`, plus `FAQPage` JSON-LD if the page has a FAQ section — using only real numbers/text already printed on the page. Never add `url`/`og:url`/`og:image` pointing at a production path or generated asset that doesn't exist yet.
- A cross-link to any natural peer/alternative service page (e.g. WooCommerce ↔ Shopify). **Do not add a "← Browse All Services" / `all-services.html` link on individual service pages — this was tried and explicitly rejected; never add it, on this page or any future page.**
- Explicit `width`/`height` on every image (also required by the image rules below) to avoid layout shift.

## 6. Image Workflow

This project never generates images directly — every image is a **prompt handed to the user**, who generates it externally and places it.

- For every image the page needs, write an explicit generation prompt covering: subject/mockup content, aspect ratio (4:3 unless noted otherwise), the brand accent colors to echo (`#3A539B` navy-blue, `#ea4e5f` coral), and lighting/style (clean, bright, minimal, studio lighting).
- **Every prompt must explicitly state: no third-party brand names, logos, or product names anywhere in the image. If a brand/site name must appear in the mockup, it must read "Sites By Sara" and nothing else.**
- Give the exact filename to use, matching the pattern already in `images/` (e.g. `service-name-hero.jpg`, `service-name-detail.jpg`).
- In the HTML, point `<img src>` at the placeholder WordPress upload path already used across pages: `https://sbs.sbsdevserver.com/wp-content/uploads/2026/09/{filename}.webp`, so the markup is upload-ready. Tell the user to also save a local mirror as `images/{filename}.jpg` for offline preview — matching how `custom-web-dev-hero.jpg` and `cyber-security-hero.jpg` already exist locally.
- Never fabricate a placeholder image (no stock photo URLs, no base64 filler, no unrelated existing image reused for a different service). A missing/broken image icon in preview is expected and correct until the real asset is generated — don't try to "fix" that by substituting something else in.

---

## 7. Definition of Done

Before reporting a page as finished, confirm:

- [ ] Every price/feature/requirement traces to `Services-info.html`; nothing invented (§2).
- [ ] Hero secondary button links to `#pricing`.
- [ ] Pricing cards each have their own feature list; no shared/duplicate "included everywhere" row below the grid.
- [ ] Any 5+ tier pricing is grouped into cards + a collapsible full breakdown, not a flat list of rows (`design.md` §5.6.1).
- [ ] No invented "Most Popular"/"Best Value" claims anywhere on the page.
- [ ] All class names match the existing pages' conventions — checked against at least one sibling page, not just `design.md`'s snippets.
- [ ] SEO checklist from §5 above is fully applied (title/meta length, single `<h1>`, alt text, JSON-LD, internal links).
- [ ] Page previewed in-browser at desktop width; scrolled through every section; any `<details>`/accordion interaction clicked at least once to confirm it actually works.
- [ ] Image prompts written for every visual asset, each with the "no other brand names, only Sites By Sara if needed" clause, and the exact target filename given.
- [ ] `all-services.html` updated with a card for the new page (title, grounded short description, grounded price range, "See More" button) — the directory must stay in sync with the set of pages that exist.
- [ ] `design.md` updated if the page introduced a new reusable component pattern; this file updated if it introduced a new process rule.
