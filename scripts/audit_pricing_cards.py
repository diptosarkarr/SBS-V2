"""Audit every page's [sbs_pricing_cards] shortcode against the order system (https://order.sitesbysara.com/).

    python scripts/audit_pricing_cards.py          # audit every page, exit code 1 if anything needs fixing
    python scripts/audit_pricing_cards.py --list   # print the order system's categories and card ids

Rules it enforces (SERVICE-PAGE-GUIDELINES.md section 4, "Pricing"):
  * a page calls its whole category: [sbs_pricing_cards category="<slug>" popular="<id>" title="..."]
  * ids="..." is only for a card outside the page's own category (or on a page with no dedicated category)
  * no stale id (one the order system no longer has) and no unknown category slug
"""
from __future__ import annotations

import html
import json
import re
import sys
import urllib.parse
import urllib.request
from pathlib import Path

sys.stdout.reconfigure(encoding="utf-8")
ROOT = Path(__file__).resolve().parent.parent
ORDER = "https://order.sitesbysara.com/"

# Pages that keep ids on purpose (page -> why).
KEEP_IDS = {
    "custom-apps-cybersecurity.html": "its four cards sit in the shared dev_other category next to the WordPress to HTML items",
}
# Pages that split a category into labelled sub-sections (several shortcodes per page).
SECTIONED = {"pricing.html"}

SHORTCODE = re.compile(r"\[sbs_pricing_cards\b([^\]]*)\]")


def fetch(url: str) -> str:
    request = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
    return urllib.request.urlopen(request, timeout=40).read().decode("utf-8", "ignore")


def load_catalog() -> dict:
    """The CATALOG object embedded in the order page: {category slug: {label, group, items: [...]}}."""
    page = fetch(ORDER)
    match = re.search(r"\bCATALOG\s*=\s*\{", page)
    if not match:
        raise SystemExit("CATALOG not found on the order page (did its markup change?)")
    start, depth, in_string, escaped = match.end() - 1, 0, False, False
    for index in range(start, len(page)):
        char = page[index]
        if in_string:
            escaped = (char == "\\") and not escaped
            if char == '"' and not escaped:
                in_string = False
            continue
        if char == '"':
            in_string = True
        elif char == "{":
            depth += 1
        elif char == "}":
            depth -= 1
            if depth == 0:
                return json.loads(page[start : index + 1])
    raise SystemExit("unterminated CATALOG on the order page")


def card_ids(query: str) -> list[str]:
    """Service ids of the cards the pricing plugin renders for a query (read from each Order Now link)."""
    body = fetch(f"{ORDER}configure/pricing-cards?{query}")
    return re.findall(r'configure\?service=([^"&]+)', body)


def parse(text: str) -> list[dict[str, str]]:
    found = []
    for match in SHORTCODE.finditer(text):
        attrs = dict(re.findall(r'(\w+)="([^"]*)"', html.unescape(match.group(1))))
        found.append({key: re.sub(r"\s+", " ", value).strip() for key, value in attrs.items()})
    return found


def split_ids(value: str) -> list[str]:
    return [one.strip() for part in value.split(",") for one in part.split("|") if one.strip()]


def audit(catalog: dict) -> int:
    owner = {item["id"]: slug for slug, cat in catalog.items() for item in cat["items"]}
    members = {slug: [item["id"] for item in cat["items"]] for slug, cat in catalog.items()}
    shown_anywhere: set[str] = set()  # every card id some page renders (ids, or all members of a category)
    problems = 0
    for path in sorted(ROOT.glob("*.html")):
        shortcodes = parse(path.read_text(encoding="utf-8"))
        if not shortcodes:
            continue
        name, notes = path.name, []
        for sc in shortcodes:
            category, ids = sc.get("category", ""), split_ids(sc.get("ids", ""))
            shown_anywhere.update(ids)
            if category in catalog:
                shown_anywhere.update(members[category])
            if category and category not in catalog:
                notes.append(f"unknown category '{category}' (known: python scripts/audit_pricing_cards.py --list)")
            elif category and not card_ids("category=" + urllib.parse.quote(category)):
                notes.append(f"category '{category}' renders no card")
            for card in ids:
                if card not in owner:
                    notes.append(f"stale id {card} (not in the order system)")
                elif category and owner[card] == category:
                    notes.append(f"id {card} is already in category '{category}': drop it from ids=")
            known = [card for card in ids if card in owner]
            if not category and known and name not in KEEP_IDS:
                covers = [slug for slug in {owner[card] for card in known} if set(members[slug]) <= set(known)]
                if name not in SECTIONED or covers:
                    slug = sorted(covers or {owner[card] for card in known})[0]
                    notes.append(f'lists ids only: use category="{slug}"')
        if name in KEEP_IDS:
            print(f"INFO  {name}: ids kept on purpose, {KEEP_IDS[name]}")
        if notes:
            problems += len(notes)
            for note in dict.fromkeys(notes):
                print(f"FIX   {name}: {note}")
        elif name not in KEEP_IDS:
            print(f"OK    {name}")
    for slug, ids in members.items():  # site-wide: nothing in the order system may be left off every page
        missing = [card for card in ids if card not in shown_anywhere]
        if missing:
            problems += 1
            print(f"FIX   (site) category '{slug}' has cards no page shows: {missing}")
    print(f"\n{problems} thing(s) to fix")
    return 1 if problems else 0


def list_catalog(catalog: dict) -> None:
    for slug, cat in catalog.items():
        print(f"\n{slug}  [{cat.get('label')}]  group={cat.get('group')}  ({len(cat['items'])} items)")
        for item in cat["items"]:
            print(f"  {item['id']:<9} {item['name']}")


if __name__ == "__main__":
    data = load_catalog()
    if "--list" in sys.argv:
        list_catalog(data)
        sys.exit(0)
    sys.exit(audit(data))
