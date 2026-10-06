"""After rebuilding a page: run the checker, list every CSS selector that was removed, and write a preview wrapper.

    python scripts/verify_build.py <page>.html <backup-of-original>.html

The wrapper (_w.html) loads the page fragment with <base href=dev site> so images resolve; serve the repo folder
(launch.json "sbs-static-preview", port 8420) and open http://localhost:8420/_w.html
"""
import os
import re
import subprocess
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
from prune_css import _scan_blocks, split_page  # noqa: E402


def selectors(path):
    text = open(path, encoding='utf-8').read().replace('\r\n', '\n')
    _, css, _ = split_page(text)
    out = []

    def walk(block, prefix=''):
        for kind, prelude, body, _raw in _scan_blocks(block):
            if kind == 'rule':
                out.extend(prefix + s.strip() for s in prelude.split(','))
            elif kind == 'at':
                walk(body, prefix + prelude + ' | ')

    walk(css)
    return out


def main():
    page, backup = sys.argv[1], sys.argv[2]
    here = os.path.dirname(os.path.abspath(__file__))
    subprocess.run([sys.executable, os.path.join(here, 'check_service_page.py'), page, '--check-ids', '--assets'])
    before, after = selectors(backup), set(selectors(page))
    gone = [s for s in before if s not in after]
    print(f'\nCSS selectors removed: {len(gone)}')
    print('  ' + ', '.join(sorted(set(re.sub(r"^.*\| ", "", g) for g in gone)))[:1500])
    body = open(page, encoding='utf-8').read()
    wrapper = ('<!doctype html><html><head><meta charset="utf-8"><base href="https://sbs.sbsdevserver.com/">'
               '<meta name="viewport" content="width=device-width,initial-scale=1"></head>'
               '<body style="margin:0">' + body + '</body></html>')
    open('_w.html', 'w', encoding='utf-8').write(wrapper)
    print('preview wrapper written: _w.html')


if __name__ == '__main__':
    main()
