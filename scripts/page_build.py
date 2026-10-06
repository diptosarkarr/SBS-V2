"""Helpers for rewriting a service page (see SERVICE-PAGE-GUIDELINES.md).

Typical build script:
    import sys; sys.path.insert(0, 'scripts')
    from page_build import Page, FAQ_NOTE_CSS, set_head, faq_items_html
    p = Page('some-page.html')
    p.sub1('old text', 'new text')            # exactly one occurrence or it fails loudly
    set_head(p, 'Service Type', 'Generic description.', FAQ)
    p.save()                                  # keeps the file's original line endings, retries on Windows locks
"""
import html
import json
import re
import time

SECTION_NOTE_CSS = '''  /* Short supporting line under a section's cards/grid; also used for related-service links */
  .section-note {
    text-align: center;
    max-width: 720px;
    margin: 28px auto 0;
    font-size: 0.98rem;
    color: var(--slate);
    line-height: 1.6;
  }

  .section-note + .section-note {
    margin-top: 12px;
  }

  .section-note a {
    color: var(--brand-blue);
    font-weight: 600;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.2s ease;
  }

  .section-note a:hover,
  .section-note a:focus,
  .section-note a:focus-visible,
  .section-note a:active {
    color: var(--brand-blue-hover) !important;
  }

'''

ARROW_SVG = ('<svg viewBox="0 0 24 24" fill="none"\n'
             '            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">\n'
             '            <path d="M5 12h14M13 5l7 7-7 7" />\n'
             '          </svg>')


class Page:
    def __init__(self, path):
        self.path = path
        raw = open(path, 'rb').read().decode('utf-8')
        self.eol = '\r\n' if '\r\n' in raw else '\n'
        self.s = raw.replace('\r\n', '\n')

    def sub1(self, old, new):
        n = self.s.count(old)
        assert n == 1, f'expected 1 match, found {n}: {old[:80]!r}'
        self.s = self.s.replace(old, new)

    def between(self, start, end, new, keep_end=True):
        """Replace the text from `start` up to (not including) `end` with `new`."""
        a = self.s.index(start)
        b = self.s.index(end, a + len(start))
        self.s = self.s[:a] + new + (self.s[b:] if keep_end else self.s[b + len(end):])

    def cut(self, start, end):
        """Delete from `start` up to (not including) `end`."""
        self.between(start, end, '')

    def save(self):
        out = self.s.replace('\n', self.eol).encode('utf-8')
        for _ in range(8):
            try:
                open(self.path, 'wb').write(out)
                return
            except OSError:
                time.sleep(1)
        raise SystemExit('write failed: ' + self.path)


def indent(block, n):
    pad = ' ' * n
    return '\n'.join((pad + line) if line else line for line in block.split('\n'))


def faq_items_html(faq, pad=6):
    sp = ' ' * pad
    return '\n'.join(
        f'''{sp}<details class="faq-item">
{sp}  <summary class="faq-question">
{sp}    <span>{html.escape(q, quote=False)}</span>
{sp}    <span class="faq-icon">+</span>
{sp}  </summary>
{sp}  <div class="faq-answer">
{sp}    {html.escape(a, quote=False)}
{sp}  </div>
{sp}</details>
''' for q, a in faq)


def set_head(page, service_type, description, faq):
    """Replace everything before <style> with the standard head + generated Service and FAQPage JSON-LD."""
    service = json.dumps({
        '@context': 'https://schema.org', '@type': 'Service', 'serviceType': service_type,
        'provider': {'@type': 'Organization', 'name': 'Sites by Sara'}, 'description': description,
    }, indent=2, ensure_ascii=False)
    faq_ld = json.dumps({
        '@context': 'https://schema.org', '@type': 'FAQPage',
        'mainEntity': [{'@type': 'Question', 'name': q, 'acceptedAnswer': {'@type': 'Answer', 'text': a}}
                       for q, a in faq],
    }, indent=2, ensure_ascii=False)
    head = ('<link rel="preconnect" href="https://fonts.googleapis.com">\n'
            '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>\n'
            '<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" '
            'rel="stylesheet">\n\n'
            '<!-- SEO: Service structured data (generic by design, see SERVICE-PAGE-GUIDELINES.md) -->\n'
            '<script type="application/ld+json">\n' + indent(service, 2) + '\n</script>\n'
            '<!-- SEO: FAQPage structured data, generated from the same list as the visible FAQ -->\n'
            '<script type="application/ld+json">\n' + indent(faq_ld, 2) + '\n</script>\n\n')
    page.s = head + page.s[page.s.index('<style>'):]


def add_css(page, css, before='</style>'):
    """Insert css text before the first occurrence of `before` (default: end of the stylesheet)."""
    i = page.s.index(before)
    page.s = page.s[:i] + css + page.s[i:]


def prune_page_css(page, classes):
    from prune_css import prune
    a = page.s.index('<style>') + len('<style>')
    b = page.s.index('</style>')
    css, removed = prune(page.s[a:b], set(classes))
    page.s = page.s[:a] + css + page.s[b:]
    return removed


# ---------------------------------------------------------------------------------------------------------------
# Standard page body (banner > hero > trust strip > pricing > scope grid > story rows > FAQ > CTA)
# ---------------------------------------------------------------------------------------------------------------
import textwrap


def _dedented(s, start, end):
    line_start = s.rfind('\n', 0, start) + 1
    pad = s[line_start:start]
    return textwrap.dedent(pad + s[start:end]) if not pad.strip() else s[start:end]


def extract_shared(page):
    """Return (trust_block, resizer_script) from the existing page, dedented, to reuse verbatim."""
    s = page.s
    sec = s.index('<section class="site-trust-strip"')
    start = s.rfind('<!--', 0, sec)
    end = s.index('</script>', sec) + len('</script>')
    trust = _dedented(s, start, end)
    m = re.search(r"<script>\s*window\.addEventListener\('message'.*?</script>", s, re.S)
    resizer = _dedented(s, m.start(), m.end())
    assert 'data-count-to="2007"' in trust and 'sbs-pricing-cards' in resizer
    return trust + '\n', resizer + '\n'


def story_row_html(row, reversed_):
    cls = 'story-row is-reversed' if reversed_ else 'story-row'
    visual = row.get('visual_html') or (
        f'''<div class="story-image-card">
          <img src="{row['img']}"
            alt="{row['alt']}" width="520" height="390" />
        </div>''')
    return f'''    <div class="{cls}">
      <div class="story-text-col">
        <div class="eyebrow">
          <span class="eyebrow-dot"></span>
          {row['eyebrow']}
        </div>
        <h2 class="story-title">{row['title']}</h2>
        <p class="story-desc">
          {row['desc']}
        </p>
{row.get('extra_html', '')}        <a href="{row.get('href', '#pricing')}" class="story-link">{row.get('link', 'View pricing')}{ARROW_SVG}</a>
      </div>
      <div class="story-visual-col">
        {visual}
      </div>
    </div>
'''


DEFAULT_PRICING_LEAD = "Compare the options below, or book a free consultation and we'll help you decide."


def standard_body(cfg, trust, resizer):
    """cfg keys: h1 sub hero{eyebrow,h2,lead,img,alt} pricing{h2,lead,src,related[(href,label)]} scope{eyebrow,h2,
    lead,cards[(title,desc)],note} story[rows] faq faq_lead cta{h2,p,prep[...]}"""
    h, pr, sc, ct = cfg['hero'], cfg['pricing'], cfg['scope'], cfg['cta']
    related = ' and\n      '.join(f'<a class="related-link" href="{href}">{label}</a>' for href, label in pr['related'])
    cards = '\n'.join(f'''      <div class="scope-card">
        <div class="scope-num">{i}</div>
        <h3 class="scope-title">{t}</h3>
        <p class="scope-desc">{d}</p>
      </div>
''' for i, (t, d) in enumerate(sc['cards'], 1))
    rows = '\n'.join(story_row_html(r, i % 2 == 1) for i, r in enumerate(cfg['story']))
    prep = '\n'.join(f'''          <li>
            <span class="prep-list-num">{i}</span>
            <span>{t}</span>
          </li>''' for i, t in enumerate(ct['prep'], 1))
    pricing_lead = pr.get('lead', DEFAULT_PRICING_LEAD)
    scope_eyebrow = sc.get('eyebrow', 'How It Works')
    return f'''</style>

<!-- ============================================================
       PAGE TITLE BANNER
       ============================================================ -->
<section class="page-title-banner" aria-label="Page Title">
  <div class="page-title-banner-mesh" aria-hidden="true"></div>
  <div class="container page-title-inner">
    <h1 class="page-banner-h1">{cfg['h1']}</h1>
    <p class="page-banner-sub">{cfg['sub']}</p>
  </div>
</section>

<!-- ============================================================
       HERO SECTION
       ============================================================ -->
<section class="hero-section" id="overview">
  <div class="container">
    <div class="hero-grid">

      <!-- Hero Copy -->
      <div class="hero-left">
        <div class="eyebrow">
          <span class="eyebrow-dot"></span>
          {h['eyebrow']}
        </div>

        <h2 class="h2-title">{h['h2']}</h2>

        <p class="lead-text">
          {h['lead']}
        </p>

        <div class="btn-group">
          <a href="/book-a-free-consultation/" class="btn btn-primary">Book a Free
            Consultation</a>
          <a href="#pricing" class="btn btn-outline">View Pricing &amp; Plans</a>
        </div>
      </div>

      <!-- Hero Visual Mockup -->
      <div class="hero-visual-wrap">
        <div class="hero-image-card">
          <img src="{h['img']}"
            alt="{h['alt']}" width="600" height="450" />
        </div>
      </div>

    </div>
  </div>
</section>

{trust}
{cfg.get('after_trust_html', '')}<!-- ============================================================
     PRICING SECTION
     ============================================================ -->
<section class="pricing-section" id="pricing">
  <div class="container">

    <div class="section-header">
      <div class="eyebrow">
        <span class="eyebrow-dot"></span>
        Pricing
      </div>
      <h2 class="h2-title">{pr['h2']}</h2>
      <p class="lead-text">{pricing_lead}</p>
    </div>

    <div class="pricing-outer-container">
      <iframe class="sbs-pricing-frame"
        src="{pr['src']}"
        title="Pricing options" style="width:100%;border:0;display:block;" loading="lazy"></iframe>
    </div>

    <p class="section-note">Looking for more ways to grow your business? Explore
      {related}.</p>

  </div>
</section>

{resizer}
<!-- ============================================================
     HOW IT WORKS (SCOPE GRID)
     ============================================================ -->
<section class="{cfg.get('scope_class', 'section-space scope-section')}" aria-label="How it works">
  <div class="container">

    <div class="section-header">
      <div class="eyebrow">
        <span class="eyebrow-dot"></span>
        {scope_eyebrow}
      </div>
      <h2 class="h2-title">{sc['h2']}</h2>
      <p class="lead-text">{sc['lead']}</p>
    </div>

    <div class="scope-grid">

{cards}
    </div>

    <p class="section-note">{sc['note']}</p>

  </div>
</section>

<!-- ============================================================
     ALTERNATING STORYTELLING FEATURES (High Breathing Space)
     ============================================================ -->
<section class="story-features-section">
  <div class="container">

{rows}
  </div>
</section>

<!-- ============================================================
     FAQ SECTION (Clean Accordion)
     ============================================================ -->
<section class="faq-section" id="faq" aria-label="Frequently Asked Questions">
  <div class="container">

    <div class="section-header">
      <div class="eyebrow">
        <span class="eyebrow-dot"></span>
        Common Questions
      </div>
      <h2 class="h2-title">Frequently Asked Questions</h2>
      <p class="lead-text">{cfg['faq_lead']}</p>
    </div>

    <div class="faq-wrap">

{faq_items_html(cfg['faq'])}
    </div>

  </div>
</section>

<!-- ============================================================
     NEXT STEPS / CONSULTATION CHECKLIST BANNER
     ============================================================ -->
<section class="cta-banner-section" id="consultation">
  <div class="container">
    <div class="cta-banner-box">

      <div class="cta-banner-left">
        <div class="eyebrow">
          <span class="eyebrow-dot"></span>
          Next Steps
        </div>
        <h2>{ct['h2']}</h2>
        <p>
          {ct['p']}
        </p>
        <a href="/book-a-free-consultation/" class="btn btn-primary">Book a Free
          Consultation</a>
      </div>

      <div class="prep-card-right">
        <h4 class="prep-card-title">Helpful to have ready:</h4>
        <ul class="prep-list">
{prep}
        </ul>
      </div>

    </div>
  </div>
</section>
'''


def apply_standard(page, cfg, service_type, description, remove_classes=(), auto_prune=True):
    """Rewrite the page body from cfg, keep the page's own stylesheet (pruned), regenerate head + JSON-LD.

    auto_prune also drops every class the stylesheet defines but the regenerated markup no longer uses (standard
    pages have no JavaScript-toggled classes). Review the removed-selector list printed by verify_build.py."""
    from prune_css import unused_classes
    trust, resizer = extract_shared(page)
    css_end = page.s.index('</style>')
    page.s = page.s[:css_end] + standard_body(cfg, trust, resizer)
    set_head(page, service_type, description, cfg['faq'])
    classes = set(remove_classes)
    if auto_prune:
        classes |= set(unused_classes(page.s))
    removed = prune_page_css(page, classes) if classes else []
    add_css(page, SECTION_NOTE_CSS)
    return removed
