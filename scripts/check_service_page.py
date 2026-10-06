"""Check a service landing page against SERVICE-PAGE-GUIDELINES.md.

Usage:
    python scripts/check_service_page.py local-seo-services.html [--check-ids] [--names "Pkg A,Pkg B"]

Errors (exit code 1) are hard rule breaks. Warnings need a human look.
"""
import argparse
import html
import json
import os
import re
import sys
import urllib.error
import urllib.parse
import urllib.request
from html.parser import HTMLParser

sys.stdout.reconfigure(encoding="utf-8")

SKIP_CLASSES = {"site-trust-strip", "scope-num", "prep-list-num", "faq-icon", "related-link", "step-num-badge",
                "testimonials-section", "portfolio-card", "page-banner-h1", "client-disclosure"}
SKIP_TAGS = {"style", "script"}
VOID_TAGS = {"img", "br", "hr", "input", "meta", "link", "source", "path", "circle", "rect", "line", "polyline",
             "polygon", "ellipse", "use", "stop"}

ALLOWED_PHRASES = [r"view pricing\s*&\s*plans", r"the pricing above", r"free consultation", r"book a free",
                   r"free cyber score ?card", r"(microsoft|office|outlook|windows) ?365"]

ERROR_PATTERNS = [
    (r"\d", "digit in copy"),
    (r"\$", "currency symbol"),
    (r"\b(prices?|costs?|fees?|billed|billing|retainer|subscription)\b", "price/billing word"),
    (r"\b(monthly|weekly|daily|annual(ly)?|yearly|one-time|per (month|year|week|hour))\b", "frequency/billing term"),
    (r"\b(tiers?|tiered|graduated)\b", "tier wording"),
    (r"\b(minimum|contract)\b", "term/contract wording"),
    (r"\b(guarantee[sd]?|unlimited)\b", "guarantee/unlimited claim"),
]
WARN_PATTERNS = [
    (r"\b(packages?|plans?|add-ons?|bundles?)\b", "package/plan wording (name or contents leaking?)"),
    (r"\b(best|leading|top|dominat\w*|always|never|#1)\b", "superlative/absolute"),
    (r"\bfree\b", "'free' claim"),
]


class TextCollector(HTMLParser):
    def __init__(self):
        super().__init__(convert_charrefs=True)
        self.stack = []
        self.skip_depth = 0
        self.segments = []

    def handle_starttag(self, tag, attrs):
        a = dict(attrs)
        if self.skip_depth == 0:
            for key in ("alt", "title", "aria-label"):
                if a.get(key):
                    self.segments.append((key, a[key]))
        if tag in VOID_TAGS:
            return
        classes = set((a.get("class") or "").split())
        skip = tag in SKIP_TAGS or bool(classes & SKIP_CLASSES)
        self.stack.append((tag, skip))
        if skip:
            self.skip_depth += 1

    def handle_endtag(self, tag):
        if tag in VOID_TAGS:
            return
        while self.stack:
            top, skip = self.stack.pop()
            if skip:
                self.skip_depth -= 1
            if top == tag:
                break

    def handle_data(self, data):
        data = re.sub(r"\[/?sg_popup[^\]]*\]", " ", data)  # WordPress popup shortcodes are not copy
        if self.skip_depth == 0 and data.strip():
            self.segments.append(("text", " ".join(data.split())))


def clean(text):
    for phrase in ALLOWED_PHRASES:
        text = re.sub(phrase, " ", text, flags=re.I)
    return text


def plain(markup):
    return " ".join(html.unescape(re.sub(r"<[^>]+>", " ", markup)).split())


def check_structure(src, errors, warns):
    if re.search(r"<(!doctype|html|head|body|meta|title)\b", src, re.I):
        errors.append("wrapper tag present (<html>/<head>/<body>/<meta>/<title>)")
    if re.search(r"<(header|footer)\b", src, re.I):
        errors.append("standalone <header>/<footer> present")
    if re.search(r'href="[^"]*all-services', src, re.I):
        errors.append("all-services link present")
    if src.count("site-trust-strip") < 2 or 'data-count-to="2007"' not in src:
        errors.append("shared trust strip missing")
    frames = re.findall(r"<iframe\b[^>]*sbs-pricing-frame[^>]*>", src, re.S)
    if len(frames) != 1:
        errors.append(f"expected exactly 1 pricing iframe, found {len(frames)}")
    if "sbs-pricing-cards" not in src:
        errors.append("pricing iframe resize listener missing")
    if not re.search(r'href="#pricing"[^>]*>\s*View Pricing\s*&amp;\s*Plans', src):
        errors.append('hero button "View Pricing & Plans" -> #pricing missing')
    if 'class="related-link"' not in src:
        errors.append("no related-service links (class related-link) near the bottom")
    header_re = r'<div class="section-header">(.*?)</h2>(\s*<p class="lead-text")?'
    for m in re.finditer(header_re, src, re.S):
        if not m.group(2):
            warns.append("a section header has no lead sentence: " + plain(m.group(1))[-60:])
    if frames and "title=" not in frames[0]:
        warns.append("pricing iframe has no title= param (label above the cards)")
    if "hero-footnote" in src:
        warns.append("hero footnote present (guidelines: none)")
    for cls, ok, label in (("scope-card", (4, 8), "scope cards"), ("story-row", (2, 3), "story rows")):
        n = len(re.findall(rf'class="{cls}[ "]', src))
        if n and n not in range(ok[0], ok[1] + 1):  # pages with a custom layout may have none
            warns.append(f"{n} {label} (budget {ok[0]}-{ok[1]})")
    rows = re.findall(r'class="story-row( is-reversed)?"', src)
    for i, rev in enumerate(rows):
        if bool(rev) != (i % 2 == 1):
            warns.append(f"story row {i + 1} does not alternate correctly")
            break
    return frames


def check_text(src, errors, warns, names):
    collector = TextCollector()
    collector.feed(src)
    for kind, text in collector.segments:
        probe = clean(text)
        for pattern, label in ERROR_PATTERNS:
            for m in re.finditer(pattern, probe, re.I):
                errors.append(f'{label}: "{m.group(0)}" in {kind}: {text[:90]}')
        for pattern, label in WARN_PATTERNS:
            for m in re.finditer(pattern, probe, re.I):
                warns.append(f'{label}: "{m.group(0)}" in {kind}: {text[:90]}')
        for name in names:
            if name and name.lower() in probe.lower():
                errors.append(f'package/tier name "{name}" in {kind}: {text[:90]}')


def check_jsonld(src, errors, warns):
    blocks = re.findall(r'<script type="application/ld\+json">(.*?)</script>', src, re.S)
    faq_ld = []
    for raw in blocks:
        try:
            data = json.loads(raw)
        except ValueError as exc:
            errors.append(f"JSON-LD does not parse: {exc}")
            continue
        if data.get("@type") == "Service":
            if "offers" in data:
                errors.append("Service JSON-LD has offers (no prices allowed)")
            if re.search(r"\d|\$", clean(data.get("description", ""))):
                errors.append("digit/currency in Service JSON-LD description")
        if data.get("@type") == "FAQPage":
            for q in data.get("mainEntity", []):
                faq_ld.append((q["name"], q["acceptedAnswer"]["text"]))
    items = re.findall(
        r'<details class="faq-item">\s*<summary[^>]*>\s*<span[^>]*>(.*?)</span>.*?<div class="faq-answer">(.*?)</div>\s*</details>',
        src,
        re.S,
    )
    faq_html = [(plain(q), plain(a)) for q, a in items]
    if faq_html and faq_html != faq_ld:
        errors.append("visible FAQ and FAQPage JSON-LD differ")
    if not 4 <= len(faq_html) <= 5:
        warns.append(f"{len(faq_html)} FAQ items (budget 4-5)")
    for q, a in faq_html:
        if len(a.split()) > 45:
            warns.append(f"FAQ answer long ({len(a.split())} words): {q[:60]}")


def check_ids(frames, errors):
    if not frames:
        return
    src = re.search(r'src="([^"]+)"', frames[0]).group(1)
    ids = urllib.parse.parse_qs(urllib.parse.urlparse(html.unescape(src)).query).get("ids", [""])[0].split(",")
    for card_id in ids:
        url = "https://order.sitesbysara.com/configure/pricing-cards?ids=" + urllib.parse.quote(card_id)
        req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
        try:
            body = urllib.request.urlopen(req, timeout=20).read().decode("utf-8", "ignore")
        except OSError as exc:
            errors.append(f"could not fetch id {card_id}: {exc}")
            continue
        names = re.findall(r'class="pc-name">([^<]*)', body)
        print(f"  id {card_id:>8} -> {', '.join(html.unescape(n) for n in names) or 'NO CARD'}")
        if not names:
            errors.append(f"dead pricing id {card_id} (renders no card): drop it from the iframe URL")


def check_layout(src, errors, warns):
    """The scope grid must be 4 columns on desktop (cards come in 4 or 8), 2 on tablet and 1 on phones."""
    m = re.search(r"<style>(.*?)</style>", src, re.S)
    css = re.sub(r"/\*.*?\*/", "", m.group(1), flags=re.S) if m else ""
    if re.search(r",[ \t]*\n[ \t]*\n", css):
        errors.append("CSS has a selector list ending in a comma before a blank line (a rule lost its body)")
    cards = len(re.findall(r'class="scope-card"', src))
    if not cards:
        return
    block = r"\{(?:[^{}]|\{[^{}]*\})*\}"
    is_scope_grid = re.compile(r"(^|,)\s*\.scope-grid\s*($|,)")
    cols = {}
    for media in re.finditer(r"(@media[^{]*)(" + block + ")", css):
        for sel, decl in re.findall(r"([^{}]+)\{([^{}]*)\}", media.group(2)[1:-1]):
            if is_scope_grid.search(sel.strip()):
                c = re.search(r"grid-template-columns:\s*([^;]+);", decl)
                if c:
                    cols[media.group(1).strip()] = c.group(1).strip()
    top = re.sub(r"@media[^{]*" + block, "", css)
    for sel, decl in re.findall(r"([^{}]+)\{([^{}]*)\}", top):
        if is_scope_grid.search(sel.strip()):
            c = re.search(r"grid-template-columns:\s*([^;]+);", decl)
            if c:
                cols["desktop"] = c.group(1).strip()
    if cols.get("desktop") != "repeat(4, 1fr)":
        errors.append(f"scope grid is {cols.get('desktop')} on desktop (expected repeat(4, 1fr)); {cards} cards would wrap unevenly")
    if cols.get("@media (max-width: 600px)") != "1fr":
        errors.append("scope grid is not a single column on phones (@media max-width 600px)")


def check_links(src, page_path, warns):
    """Root-relative links must point at a page that exists in the site navigation (header.html)."""
    header_path = os.path.join(os.path.dirname(os.path.abspath(page_path)), "header.html")
    known = set(re.findall(r'href="(/[^"#?]*)"', open(header_path, encoding="utf-8").read()))
    known.update({"/book-a-free-consultation/", "/"})
    for href in sorted(set(re.findall(r'href="(/[^"#?]*)"', src))):
        if href.startswith("/wp-content"):
            continue
        if href not in known:
            warns.append(f"link target not found in header navigation: {href}")


def check_images(src, warns, base="https://sbs.sbsdevserver.com"):
    """Every /wp-content image the page references should exist on the dev site."""
    for path in sorted(set(re.findall(r'src="(/wp-content/[^"]+)"', src))):
        req = urllib.request.Request(base + path, method="HEAD", headers={"User-Agent": "Mozilla/5.0"})
        try:
            status = urllib.request.urlopen(req, timeout=20).status
        except urllib.error.HTTPError as exc:
            status = exc.code
        except OSError as exc:
            status = str(exc)
        if status != 200:
            warns.append(f"image not reachable on dev site ({status}): {path}")


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("page")
    parser.add_argument("--check-ids", action="store_true")
    parser.add_argument("--assets", action="store_true", help="also verify internal links and image URLs")
    parser.add_argument("--names", default="", help="comma-separated package/tier names that must not appear in copy")
    args = parser.parse_args()

    src = open(args.page, encoding="utf-8").read().replace("\r\n", "\n")
    errors, warns = [], []
    frames = check_structure(src, errors, warns)
    check_text(src, errors, warns, [n.strip() for n in args.names.split(",")])
    check_jsonld(src, errors, warns)
    check_layout(src, errors, warns)
    if args.check_ids:
        print("Pricing ids:")
        check_ids(frames, errors)
    if args.assets:
        check_links(src, args.page, warns)
        check_images(src, warns)

    for label, items in (("ERROR", errors), ("WARN", warns)):
        for item in dict.fromkeys(items):
            print(f"{label}: {item}")
    print(f"\n{args.page}: {len(set(errors))} errors, {len(set(warns))} warnings")
    sys.exit(1 if errors else 0)


if __name__ == "__main__":
    main()
