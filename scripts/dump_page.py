"""Print a service page as plain text (plus its image paths, link targets and the live pricing cards) for review.

    python scripts/dump_page.py <page>.html
"""
import html
import re
import sys
import urllib.parse
import urllib.request

sys.stdout.reconfigure(encoding='utf-8')


def text_of(markup):
    markup = re.sub(r'<(style|script|svg)\b.*?</\1>', '', markup, flags=re.S)
    markup = re.sub(r'<!--.*?-->', '', markup, flags=re.S)
    markup = re.sub(r'</?(div|section|p|h[1-6]|li|ul|details|summary|a|span|button)\b[^>]*>', '\n', markup)
    markup = re.sub(r'<[^>]+>', '', markup)
    lines = [' '.join(html.unescape(l).split()) for l in markup.split('\n')]
    return '\n'.join(l for l in lines if l)


def live_cards(src):
    m = re.search(r'pricing-cards\?([^"]+)"', src)
    if not m:
        return
    query = urllib.parse.parse_qs(html.unescape(m.group(1)))
    ids = query.get('ids', [''])[0]
    url = 'https://order.sitesbysara.com/configure/pricing-cards?' + html.unescape(m.group(1))
    body = urllib.request.urlopen(urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'}), timeout=30).read()
    body = re.sub(r'<(style|script)\b.*?</\1>', '', body.decode('utf-8', 'ignore'), flags=re.S)
    print(f'\n=== LIVE CARDS (ids={ids}) ===')
    for card in re.split(r'<div class="pc-card', body)[1:]:
        t = html.unescape(re.sub(r'\s+', ' ', re.sub(r'<[^>]+>', '|', card)))
        t = re.sub(r'(\| ?)+', ' | ', t).strip(' |')
        print('-', t[:400])


def main():
    src = open(sys.argv[1], encoding='utf-8').read().replace('\r\n', '\n')
    body = src[src.index('</style>') + 8:]
    print('=== PAGE TEXT ===')
    print(text_of(body))
    print('\n=== IMAGES ===')
    for s, a in re.findall(r'<img[^>]*?src="([^"]+)"[^>]*?alt="([^"]*)"', body, flags=re.S):
        print('-', s.split('/')[-1], '|', a)
    print('\n=== LINKS ===')
    print(', '.join(sorted(set(re.findall(r'href="(/[^"#]*)"', body)))))
    live_cards(src)


if __name__ == '__main__':
    main()
