#!/usr/bin/env python3
"""Make the two images a client-site sample card needs from a live URL.

    python scripts/make_client_site_images.py <slug> <https://client-site.com/> [--name "Client Name"]

Writes into images/:
  client-<slug>-home.webp      1200x900 browser-frame mockup of the real home page (hero and story slots)
  site-preview-<slug>.webp     720 px wide full-page screenshot (the scroll-on-hover sample card)

Needs: pip install playwright pillow, and Google Chrome installed (Playwright uses channel="chrome").
Look at both files before using them: cookie banners, pop-ups, minors' faces, or stale promo bars should be
cropped out or the site skipped. Only use sites the client has approved (design.md 5.47).
Then upload both to the media library and add one card (copy the markup of an existing .sample-card).
"""
import argparse
import pathlib
import sys

from PIL import Image, ImageDraw, ImageFilter, ImageFont
from playwright.sync_api import sync_playwright

IMAGES = pathlib.Path(__file__).resolve().parent.parent / "images"
VIEW_W, VIEW_H = 1440, 900
FONT = "C:/Windows/Fonts/segoeui.ttf"  # falls back to PIL's default font where it is missing


def capture(url: str) -> tuple[Image.Image, str]:
    with sync_playwright() as p:
        browser = p.chromium.launch(channel="chrome", headless=True)
        page = browser.new_context(viewport={"width": VIEW_W, "height": VIEW_H}).new_page()
        page.goto(url, wait_until="load", timeout=45000)
        try:
            page.wait_for_load_state("networkidle", timeout=12000)
        except Exception:
            pass
        page.add_style_tag(content="html{scroll-behavior:auto !important}")
        height = page.evaluate("document.documentElement.scrollHeight")
        y = 0
        while y < height:  # scroll through so lazy images and reveal animations fire
            page.evaluate(f"window.scrollTo(0,{y})")
            page.wait_for_timeout(250)
            y += 700
            height = page.evaluate("document.documentElement.scrollHeight")
        page.evaluate("window.scrollTo(0,0)")
        page.wait_for_timeout(600)
        page.evaluate("""() => {
          document.querySelectorAll('.grecaptcha-badge').forEach(e => e.style.display = 'none');
          document.querySelectorAll('body *').forEach(el => {
            if (getComputedStyle(el).position === 'fixed') {
              const r = el.getBoundingClientRect();
              if (r.top > innerHeight * 0.55 && r.height < 220 && r.width < 420) el.style.display = 'none';
            }
          });
        }""")
        shot = pathlib.Path(IMAGES / "_capture_tmp.png")
        page.screenshot(path=str(shot), full_page=True)
        title = page.title()
        browser.close()
    img = Image.open(shot).convert("RGB")
    shot.unlink()
    return img.crop((0, 0, VIEW_W, img.height)), title


def rounded_mask(size: tuple[int, int], radius: int, scale: int = 4) -> Image.Image:
    big = Image.new("L", (size[0] * scale, size[1] * scale), 0)
    ImageDraw.Draw(big).rounded_rectangle((0, 0, big.width - 1, big.height - 1), radius * scale, fill=255)
    return big.resize(size, Image.LANCZOS)


def browser_frame(full: Image.Image, domain: str) -> Image.Image:
    canvas = Image.new("RGB", (1200, 900))
    px = canvas.load()
    c1, c2 = (236, 240, 249), (253, 241, 243)
    for y in range(900):
        for x in range(1200):
            t = x / 1200 * 0.45 + y / 900 * 0.55
            px[x, y] = tuple(round(c1[i] + (c2[i] - c1[i]) * t) for i in range(3))
    width = 1040
    content = full.crop((0, 0, VIEW_W, VIEW_H)).resize((width, round(VIEW_H * width / VIEW_W)), Image.LANCZOS)
    bar = 44
    win = Image.new("RGB", (width, bar + content.height), (255, 255, 255))
    d = ImageDraw.Draw(win)
    d.rectangle((0, 0, width, bar), fill=(236, 239, 244))
    d.line((0, bar - 1, width, bar - 1), fill=(217, 221, 229))
    for i, col in enumerate(((255, 95, 87), (254, 188, 46), (40, 200, 64))):
        cx = 26 + i * 22
        d.ellipse((cx - 6, bar / 2 - 6, cx + 6, bar / 2 + 6), fill=col)
    d.rounded_rectangle((100, 8, width - 100, bar - 8), 14, fill=(255, 255, 255))
    try:
        font = ImageFont.truetype(FONT, 15)
    except OSError:
        font = ImageFont.load_default()
    d.text((116, bar / 2), domain, fill=(95, 99, 104), font=font, anchor="lm")
    win.paste(content, (0, bar))
    xy = (80, (900 - win.height) // 2 - 10)
    mask = rounded_mask(win.size, 16)
    shadow = Image.new("RGBA", canvas.size, (0, 0, 0, 0))
    shadow.paste(Image.new("RGBA", win.size, (20, 30, 70, 70)), (xy[0], xy[1] + 18), mask)
    shadow = shadow.filter(ImageFilter.GaussianBlur(24))
    canvas.paste(Image.alpha_composite(canvas.convert("RGBA"), shadow).convert("RGB"))
    canvas.paste(win, xy, mask)
    return canvas


def main() -> None:
    ap = argparse.ArgumentParser(description=__doc__, formatter_class=argparse.RawDescriptionHelpFormatter)
    ap.add_argument("slug")
    ap.add_argument("url")
    ap.add_argument("--name", default="")
    args = ap.parse_args()
    domain = args.url.split("//", 1)[-1].strip("/").split("/")[0].removeprefix("www.")
    full, title = capture(args.url)
    print(f"captured {args.url}: {full.width}x{full.height}, title {title!r}")
    if "suspended" in title.lower() or "not found" in title.lower():
        sys.exit("The page title looks like an error page; not writing images.")
    home = IMAGES / f"client-{args.slug}-home.webp"
    browser_frame(full, domain).save(home, "WEBP", quality=82, method=6)
    preview = IMAGES / f"site-preview-{args.slug}.webp"
    full.resize((720, round(full.height * 720 / VIEW_W)), Image.LANCZOS).save(preview, "WEBP", quality=74, method=6)
    print(f"wrote {home.name} ({home.stat().st_size // 1024} KB) and {preview.name} ({preview.stat().st_size // 1024} KB, {720}x{round(full.height * 720 / VIEW_W)})")


if __name__ == "__main__":
    main()
