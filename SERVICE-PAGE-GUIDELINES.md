# Service Page Content Guidelines (MUST READ before editing any service page)

> **Read this file in full at the start of every service-page task, and re-read the checklist in §8 before saying the page is done.**
> It exists because these rules were skipped after a few turns. "I forgot" is not acceptable: run the checker (§7) and tick §8 every time.
>
> Scope: the service landing pages (`local-seo-services.html`, `crm-build-setup-management.html`, `web-development.html`, …).
> Relationship to other docs: `design.md` = how a page *looks*, `build-guide.md` = how a page is *built*, **this file = what the page may *say***.
> Where this file conflicts with `design.md` / `build-guide.md` (e.g. price ranges in JSON-LD, "grounded price range"), **this file wins**.

---

## 1. The client directive (2026-10-04)

Page copy must be **generic and stable**. Anything that can change in the order system (prices, packages, tiers, add-ons, radii, frequencies, counts) lives **only in the pricing cards (rendered from the order system)**, never typed into the page text.

Why: the client changed the pricing package (e.g. Local SEO lost "3-Pack Optimization" and the graduated plans) and the page text instantly became wrong. Page copy must not go stale when the order system changes.

Second directive: **light, not empty.** Keep the core meaning and cut repetition and anything specific, but never strip a page bare. The first Local SEO cleanup went too far and the client said it "feels so empty" (2026-10-04); §5 now sets minimums as well as maximums.

---

## 2. Content rules: what the page text must NOT contain

| Never write | Examples of what to avoid |
|---|---|
| **Numbers as claims or highlights** | "4 tiers", "5 or 10 square mile radius", "8-step", "fifth location", "24/7", "99.9% uptime", "within 48 hours", "50+ pages" |
| **Prices / billing / cost** | `$`, "price", "cost", "fee", "monthly", "weekly", "one-time", "retainer", "per month", "minimum term", "billed", "starting at", "free trial" |
| **Package / tier / add-on names and contents** | "Local Domination Package", "Starter / Plus / Growth", "Additional Location Add-On", "3-Pack Optimization", "Local SEO Plans" |
| **What a specific package includes** | bullet lists of package scope (the order-system card owns this) |
| **Frequencies, durations, turnaround, guarantees** | "weekly updates", "ongoing monthly", "results in 30 days", "guaranteed", "#1 ranking" |
| **Comparisons between plans** | "difference between Plans and the Package", "start smaller or scale up" |
| **Platform / tool / integration lists, policies** | anything only the client knows. Do not invent; write the safest generic wording and list it as an assumption for the user |
| **Superlatives you can't prove** | "best", "leading", "top", "dominate", "#1" |

Allowed:
- Plain-language description of the *kind of work* ("keyword research, local listings, Google Business Profile and Maps management, reporting").
- Pointing at pricing without stating it: the button **View Pricing & Plans** (`#pricing`), "see the pricing above".
- The shared trust strip numbers (managed globally, see §4).
- Numerals used purely as step/list labels (`.scope-num`, `.prep-list-num`) and the FAQ `+` icon.
- Real proper nouns that contain digits only when unavoidable (e.g. a legal name). Prefer not to.

### Generic wording cheat-sheet

| Instead of | Write |
|---|---|
| "Google 3-Pack Optimization at 5 or 10 square miles" | "map and local search visibility" |
| "Local Domination Package" | "our local SEO service" / "the options above" |
| "Additional Location Add-On, billed monthly" | "support for businesses with more than one location" |
| "weekly Google Business Profile updates" | "ongoing Google Business Profile management" |
| "See Local Domination pricing" | "View pricing" |
| "4 graduated tiers" | (delete) |

---

## 2b. Client-mandated disclosures (explicit exceptions)

When the user explicitly asks for a specific term to be stated on a page, that request overrides the rules above for that one statement. Wrap it in `<span class="client-disclosure">…</span>` so the checker ignores it, keep it to a single plain sentence, and list it here so it is never "cleaned up" by mistake.

| Page | Statement (client request) | Where it appears |
|---|---|---|
| `go-high-level-services.html` | Page copy supplied by the client as `paste_786fdf2a-….html` (2026-10-07): the 6-month Management block and cancellation-fee wording, the GoHighLevel affiliate disclosure, example rollout sizes and the "$400 to $800" savings line. It replaces the earlier (2026-10-06) "6-month minimum applies to Management only, not Setup" sentence. The client's Essentials / Complete plan copy (compare table, "Complete" step tags, upgrade FAQ) was REMOVED the same day because pricing id 110 is still the CRM page's "Starter Setup $750"; the page runs on ids 133 and 139. Restore it from the client file only when the order system has renamed and repriced the cards | fine print `.section-note` under the pricing cards, management rollout section, FAQ (7 items) and a few CTA/stack-card spans. All wrapped in `client-content` (see below) |
| `merchant-processing-addon.html` | Page copy supplied by the client as the "Payment Processing & E-Commerce Integration" mockup (2026-10-17). **The one page where prices and rates may sit in the page text**: only the three "Platform processing rates" cards (Stripe, PayPal Checkout, PayPal Enterprise Payments, the platforms' own published US rates). Our own integration fees stay in the order-system cards (`[sbs_pricing_cards]`), never typed. Also client-copy: the platform cards, the Venmo / Cash App rule, the compatibility table, the six steps and the 9-question FAQ (budget 4-5, no story rows or scope grid). Every such block is wrapped in `client-content`. The FAQ keeps no typed prices. Before launch the client must confirm the platform facts (which method runs on which platform, the Braintree rename, the monthly-volume note) and supply a "rates verified" date if wanted (the mockup's `[DATE]` was dropped, each card links to the provider's official pricing page instead) | `#platforms`, `#compatibility`, `#rates`, `#process`, `#faq` and the disclaimer under the closing banner |
| `crm-build-setup-management.html` | "Your CRM keeps growing": the monthly feature examples (newsletter, social scheduling, AI receptionist and chat, CRO improvements, billing) supplied in `CRM_Revised_Pricing_Section.pdf` (2026-10-07) | `.crm-growth` panel directly under the pricing cards, wrapped in `client-disclosure` |

**Case studies (user-requested 2026-10-06).** Real client results are numbers by nature, so a page may carry a case-study section when the user asks for one. Wrap the whole section in `class="case-studies-section"` (the checker skips it, like the testimonials section), take every figure verbatim from the original source (the original page or its PDF) and never round, extend or invent a result. Link the original PDF if one exists. Current use: `amazon-store-setup-ads-management.html` (two cases: a senior healthcare product launch, and the October 2023 comparison against Flywheel AI). Everything outside that section still follows the generic rules.

**Client-supplied page copy (`client-content`, 2026-10-07).** When the client hands over finished copy for a page (so far only `go-high-level-services.html`), keep it verbatim and wrap each block that contains numbers, prices, tier names or billing terms in `class="client-content"`; the checker skips those blocks exactly like `client-disclosure`. Wrap only what the client wrote: headings, leads, hero, story rows and anything else still follow the generic rules. Never genericise a `client-content` block without asking. Because that copy names plans and prices, it must be edited together with the order-system cards whenever they are renamed or repriced (on 2026-10-07 the live cards for ids 110 and 133 were still called "Starter Setup" and "GHL Setup"). That page is also the documented exception for: 7 FAQ items (budget 4-5), 2 story rows plus an extra section (the management rollout), a fine-print note under the pricing cards, and a phone button next to the consultation button.

**Portfolio galleries (user-requested 2026-10-08).** `design.html` carries a tabbed portfolio section (`id="portfolio"`, between Pricing and How it works; pattern in `design.md` 5.39). Each piece sits inside a `.portfolio-card` (checker-skipped, like the web-development portfolio), so client names and digits in captions and alt text (for example "208 Moving") are allowed there. Everything else in the section (eyebrow, heading, lead sentence, tab labels, the note linking to `/our-portfolio/`) still follows the generic rules: no counts (never put a number on a tab or write "30+ projects"), no claims. Items come only from the live page's Logo Design, Print Designs and Branding tabs; do not add pieces the client has not published. The live Websites tab is deliberately left out.

Disclosures that were removed and have NOT been re-requested: Shopify's own subscription and payment fees, ad spend paid directly to Google/Meta/Walmart, and the Google/Microsoft license note on Email Setup. Do not add them back unless the user asks.

---

## 3. FAQ rules

- **Generic questions only.** Allowed topics: what the service is, who it is for, how it works, how to get started, what to prepare, whether it is ongoing vs. a project **without stating billing**, results/timing **without numbers or promises**, support/communication.
- **Banned topics:** cost, pricing, "how much", "what's included in package X", contract / minimum term, billing frequency, discounts, plan or tier comparisons, refunds.
- **4–5 questions max.** Each answer 1–2 short sentences. No bold key-point lists.
- If a visitor's honest question is about price/scope, the answer belongs to the consultation, not the FAQ.
- The visible FAQ and the `FAQPage` JSON-LD are **generated from ONE data list in a script** and compared as plain text. They must match exactly. (The checker verifies this.)

---

## 4. Fixed page structure and shared components (do not improvise)

Order: Banner → Hero → **Shared trust strip** → Pricing → Scope grid → Story rows → FAQ → CTA banner.
(Five pages also carry the optional **Local presence** section between FAQ and CTA banner, see below.)

- **Headless fragment.** No `<html>`, `<head>`, `<body>`, `<meta>`, `<title>`, no `<header>`/`<footer>`. Pages are pasted into Elementor HTML widgets.
- **Trust strip:** the identical homepage strip (`.site-trust-strip`: 2007 / 300+ / awards count, with the count-up script). Never write a page-specific strip. The awards number is global; if it changes, update it sitewide (home-body, about, every service page).
- **Pricing:** exactly **ONE** `[sbs_pricing_cards ids="..." popular="..." title="..."]` shortcode holding every card of the page (no groups, no "starting at" summary card). The pricing plugin renders it on the server, so plans, prices and inclusions are in the page HTML that crawlers read (the old iframe page was `noindex`). No iframe and no resize script (since 2026-10-15). No extra text around it: no billing notes, no tier notes, no currency/billing bar, no disclaimer.
  - `src="https://order.sitesbysara.com/configure/pricing-cards?ids=a,b,c&title=Short%20Service%20Label"`. **Always set `title`**: it renders the small label above the cards (without it the cards float with no heading; the client flagged this). Use a short generic label such as the service name, URL-encoded. Only one `popular` id; do not add one unless the client asked.
  - **Read what the live cards say before writing copy** (names, what is included). Card names change (the CRM tiers were renamed and "training" disappeared) and page copy must never promise something the cards no longer show.
  - **Verify the ids before touching copy:** fetch `…/pricing-cards?ids=<id>` for each id and read the `pc-name` values (see §7). Ids that return no card are stale: drop them from the URL.
  - Never put prices in page text. Never edit what the cards say (they come from the order system).
  - **Pilot (2026-10-15): server-rendered pricing.** `wordpress-maintenance-bundle.html` has no iframe: the pricing block is the plugin shortcode `[sbs_pricing_cards ids="..." popular="..." title="..."]` (same `ids` syntax as the iframe URL, `|` joins the two billing variants of one card), so the plans, prices and inclusions are in the HTML the server sends (the iframe page is `noindex`, so Google did not count them). The text is rendered from the order system, never typed into the repo, so it cannot go stale and the "no prices in page text" rule still holds for the repo file. The checker accepts either form (one iframe + resize listener, or exactly one shortcode and no iframe). If the pilot is confirmed in Search Console, move the other service pages over the same way. `pricing.html` is the exception on labels: it prints its own group heading above every shortcode, so those shortcodes carry no `title=` (otherwise each group name shows twice). The shortcode must run in a Shortcode widget (or wherever the site processes shortcodes); if the raw text shows on the page, move it out of the HTML widget.
- **Hero:** secondary button `href="#pricing"` reading **View Pricing & Plans**. No hero footnote line.
- **Never** add a "← Browse All Services" / `all-services` link on a service page.
- **Spacing:** every full-width section uses `padding: var(--section-gap) 0` (token defined in `:root` on every page). No custom section paddings.
- **Links:** own-site links are root-relative (`/book-a-free-consultation/`), external links open in a new tab with `rel="noopener noreferrer"`.
- **Local presence section (2026-10-14, SEO review "local relevance"):** only on `seo-site-audits-analytics-services.html`, `local-seo-services.html`, `web-development.html`, `design.html` and `google-meta-ads.html`. Markup: `<section class="local-section">` directly before the CTA banner, with a section header (eyebrow "Local Expertise", H2 "<Service> for Utah and Colorado Businesses", one lead sentence), two `.local-card` links (Salt Lake City, Utah → `/contact-us/`; Colorado Springs, Colorado → `/colorado/`) and one `.section-note` with `.related-link` links to local case studies (`/utah-center-for-psychological-services/`, `/jfs-utah/`, `/cornerstone-exteriors/`) and to `/what-our-clients-say/`. The copy follows section 2: place names only, no numbers, no claims. The Service JSON-LD of these pages also carries `areaServed` (State Utah, State Colorado). Do not add it to other service pages without asking. Facts used (assumptions to confirm with the client): Utah base = Salt Lake City (footer/About), Colorado office = Colorado Springs (Contact page). The CSS lives in each page's own stylesheet (`.local-section`, `.local-grid`, `.local-card*`).
- **Related services:** link 1-2 natural peer service pages directly under the pricing cards (`class="related-link"`, root-relative, label = the page's nav label). The checker ignores the text of `.related-link` links, so peer page names are allowed there.
- **Alt text:** specific, descriptive, no package names, no numbers.
- **JSON-LD:** `Service` (generic `description`, **no `offers` / `AggregateOffer` / prices**) and `FAQPage` (mirrors the visible FAQ).

---

## 5. Length budget (light, not empty)

Cut specifics and repetition, **not** the supporting sentences that make a page feel finished. Every section keeps a little text above and, for grids, below.

| Element | Budget |
|---|---|
| Banner subtitle | one short parenthesized phrase, generic |
| Hero lead | 2 short sentences (~35-45 words) |
| Section header lead (`.lead-text`) | **required**: one sentence under the H2 of the pricing, scope and FAQ sections |
| Pricing | lead above the iframe, `title=` label inside the iframe, and under the cards only the related-services `.section-note` line (no consultation line: the client removed it). Never billing/tier notes |
| Scope cards | 4 (or 8): title + one short sentence; one `.section-note` sentence under the grid |
| Story rows | 3 (min 2, max 3): eyebrow, title, description ≤ 2 sentences (~30 words), link |
| FAQ | 5 questions (min 4, max 5): answers 1-2 short sentences; one lead sentence under the H2 |
| Related services | one `.section-note` line **directly under the pricing cards** with 1-2 `.related-link` links to peer service pages (nav labels from `header.html`) |
| CTA prep checklist | ≤ 4 items; every item must be something the page actually covers |
| Repetition | the same message may not appear in hero, pricing header, story row *and* FAQ. Say it once |

When cutting or adding rows/cards, keep the layout correct: `.is-reversed` must alternate (row 1 normal, row 2 reversed, …); the scope grid is 4 columns on desktop, so use 4 or 8 cards. A story row needs a real image: if a generated image already exists for the page (check `/wp-content/uploads/2026/09/…` on the dev site and look at it), reuse it with an alt text that describes what it actually shows.

---

## 5b. Tool / platform logos (when a page should show the tools we work with)

- Put them in a story row as a logo grid (`.platform-card` > `.platform-grid` > `.platform-tile`, copy the CSS from `crm-build-setup-management.html`), 5 tools + an "And more" tile. No dedicated section needed.
- Logos are **inline SVG** (Simple Icons, CC0, filled with the brand colour) so nothing has to be uploaded. If Simple Icons lacks a mark, reuse a logo already in the media library (`/wp-content/uploads/2026/10/…`, see `tools-we-love.html`). Never fabricate a logo or hot-link a third-party CDN.
- The existing `highlevel.png` is a wide wordmark with white text: the grid crops it to the icon (`.platform-logo.is-crop`).
- Tile = logo + the plain tool name, and every tool tile is a link to that tool's own website (`<a class="platform-tile" target="_blank" rel="noopener noreferrer" aria-label="Name (opens in a new tab)">`). The "And more" tile links to `/book-a-free-consultation/` in the same tab. SVGs are `aria-hidden`. Brevo uses its official current icon (green circle with a white B, from brevo.com), not the older Simple Icons mark. Current CRM page tools: ClickUp, Go High Level, HubSpot, Brevo, Airtable (Salesforce was replaced by Brevo on request, 2026-10-06).
- Which tools are listed is a business claim: take them from the user, and list any tool the user did not name as an **assumption to confirm**.
- Copy never claims specifics about a tool ("certified partner", integrations counts, etc.).

---

## 6. Don't invent, don't copy blindly

- Never invent a business fact (policy, timeline, platform, guarantee). If an answer needs one, use hedged generic wording and list it as an **assumption to confirm** in the report.
- Don't "fix" an eyebrow by rewriting real content; reword the eyebrow (`design.md` §5.35).
- Do not touch the content of the pricing cards.

---

## 7. Workflow and tooling (do these in order)

1. **Read this file** and note the page's current banned-content hits:
   ```bash
   python scripts/check_service_page.py <page>.html
   ```
2. **Check live cards:** `python scripts/check_service_page.py <page>.html --check-ids` (fetches each pricing id and lists the card names it really renders, flags dead ids).
3. **Rewrite** the page to §2–§5. Build FAQ + JSON-LD from one list in a script.
4. **Re-run the checker** until it reports `0 errors`. Review warnings by hand.
5. **Preview** in a local wrapper page (headless fragment inside `<body>` of a temp HTML file), check desktop + mobile, open FAQ items, delete temp files.
6. **Report**: what was cut, what was reworded, assumptions, anything that needs the client / order system.

Build helpers (use them, they already encode these rules):
- `scripts/page_build.py`: `Page` (safe read/replace/save that keeps CRLF and retries Windows locks), `set_head` (generic Service + FAQPage JSON-LD from one FAQ list), `apply_standard(page, cfg, ...)` which regenerates a whole standard page (banner, hero, shared trust strip, pricing iframe + related-links line, scope grid, story rows, FAQ, CTA) from a small config dict. See the finished pages for examples of the config.
- `scripts/prune_css.py`: removes dead/unused CSS by class name (grouped selectors and @media blocks handled). Run `python scripts/prune_css.py <page>.html` to list classes defined but unused, then pass the ones for deleted markup to `apply_standard(..., remove_classes)`. Check the diff of removed selectors before saving.
- Pages with a custom long-form layout (e.g. `web-development.html`: benefits, services, portfolio, testimonials, process) are edited in place with `Page.sub1/between/cut` instead of `apply_standard`. The testimonials section is client words and is exempt from the checker.

Technical notes:
- Many files are **CRLF**. Detect, normalise to LF for edits, write back with the original line endings.
- Windows can briefly lock files that are open in the preview pane: write with retry.
- Write scripts with the Write tool (not heredocs) when they contain quotes/apostrophes.
- The browser tab must be fronted (`tabs_select`) for `IntersectionObserver` / count-up to run.

---

## 8. Done checklist (tick every line before reporting)

- [ ] `check_service_page.py` → **0 errors** (digits / prices / billing words / package names / wrapper tags / FAQ ↔ JSON-LD).
- [ ] No numbers or specifics in prose, headings, alt text, FAQ, JSON-LD, meta.
- [ ] No pricing, cost, billing, tier, plan-comparison, or "what's included" talk anywhere outside the pricing cards.
- [ ] FAQ is generic, 4–5 questions, no bold key points, JSON-LD identical.
- [ ] One `[sbs_pricing_cards]` shortcode (no iframe, no resize script), only live ids, `title=` label set, only the related-services `.section-note` line under it.
- [ ] Shared trust strip (identical to homepage), shared awards number.
- [ ] Hero secondary button → `#pricing` "View Pricing & Plans". No hero footnote.
- [ ] Story rows alternate correctly after any row removal; images/alt still match their row.
- [ ] No `all-services` link, no `<html>/<head>/<body>/<meta>/<title>`.
- [ ] If the page lists tools/platforms: logos shown (§5b), names confirmed with the user.
- [ ] Page is not bare: lead sentence under each section heading, note under pricing and scope, 3 story rows, 5 FAQ, related-service line under the pricing cards (§5).
- [ ] Scope grid shows one even row (or rows) on desktop: the page's own CSS must be `repeat(4, 1fr)` for 4 or 8 cards, 2 columns on tablet, 1 on phones (the checker enforces this; the hosting page once wrapped 3+1).
- [ ] Previewed desktop + mobile; FAQ opened; temp files removed.
- [ ] On the five pages listed in section 4 the Local presence section is still there (before the CTA banner) and `areaServed` is in the Service JSON-LD.
- [ ] Report lists assumptions and out-of-scope items (order-system issues, stale pages).
