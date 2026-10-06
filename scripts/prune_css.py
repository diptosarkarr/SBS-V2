"""Remove CSS rules that reference given class names, keeping everything else byte-for-byte.

Library use (from a page build script):
    from prune_css import prune, unused_classes
    css, removed = prune(css, {"hero-badges-row", "trio-item"})

CLI (report only, never writes):
    python scripts/prune_css.py page.html            # classes defined in <style> but not used in the markup
    python scripts/prune_css.py page.html --remove a,b,c

Grouped selectors are filtered ("a, b" with b removed -> "a"); @media blocks are handled recursively and
dropped when they end up empty. Classes toggled by JavaScript (is-active, is-open, ...) do not appear in the
markup, so review the "unused" list by hand before removing anything from it.
"""
import re
import sys


def _scan_blocks(css):
    """Split css into [(kind, prelude, body, raw)] where kind is 'rule', 'at' or 'text'."""
    out, i, n = [], 0, len(css)
    buf_start = 0
    while i < n:
        if css.startswith('/*', i):
            end = css.find('*/', i + 2)
            i = n if end == -1 else end + 2
            continue
        if css[i] == '{':
            # comments before the rule stay in the preceding text chunk
            chunk = css[buf_start:i]
            last_comment_end = chunk.rfind('*/')
            lead_end = buf_start + (last_comment_end + 2 if last_comment_end != -1 else 0)
            depth, j = 1, i + 1
            while j < n and depth:
                if css.startswith('/*', j):
                    end = css.find('*/', j + 2)
                    j = n if end == -1 else end + 2
                    continue
                if css[j] == '{':
                    depth += 1
                elif css[j] == '}':
                    depth -= 1
                j += 1
            prelude = css[lead_end:i].strip()
            body = css[i + 1:j - 1]
            if lead_end > buf_start:
                out.append(('text', '', '', css[buf_start:lead_end]))
            kind = 'at' if prelude.startswith('@') else 'rule'
            out.append((kind, prelude, body, css[lead_end:j]))
            buf_start = i = j
            continue
        i += 1
    if buf_start < n:
        out.append(('text', '', '', css[buf_start:]))
    return out


def _mentions(selector, classes):
    return any(re.search(r'\.' + re.escape(c) + r'(?![\w-])', selector) for c in classes)


def prune(css, classes):
    removed = []

    def walk(text):
        parts = []
        for kind, prelude, body, raw in _scan_blocks(text):
            if kind == 'text':
                parts.append(raw)
            elif kind == 'at':
                inner = walk(body)
                if inner.strip():
                    parts.append(raw[:raw.index('{') + 1] + inner + '}')
                else:
                    removed.append(prelude + ' (emptied)')
            else:
                sels = [s.strip() for s in prelude.split(',')]
                keep = [s for s in sels if not _mentions(s, classes)]
                removed.extend(s for s in sels if s not in keep)
                if not keep:
                    continue
                if len(keep) == len(sels):
                    parts.append(raw)
                else:
                    indent = re.match(r'[ \t]*', raw).group(0) if raw[:1] in ' \t' else ''
                    parts.append(',\n'.join(indent + k for k in keep) + ' {' + body + '}')
        return ''.join(parts)

    result = walk(css)
    return _drop_orphan_comments(result), removed


def _drop_orphan_comments(css):
    """Remove /* ... */ blocks that are now followed by nothing but whitespace, another comment or a closing brace."""
    pattern = re.compile(r'[ \t]*/\*(?:(?!\*/).)*\*/[ \t]*\n?(?=\s*(?:/\*|\}|\Z))', re.S)
    prev = None
    while prev != css:
        prev = css
        css = pattern.sub('', css)
    return re.sub(r'\n{3,}', '\n\n', css)


def split_page(src):
    a = src.index('<style>') + len('<style>')
    b = src.index('</style>')
    return src[:a], src[a:b], src[b:]


def defined_classes(css):
    return set(re.findall(r'\.([a-zA-Z_][\w-]*)', re.sub(r'/\*.*?\*/', '', css, flags=re.S)))


def unused_classes(src):
    head, css, tail = split_page(src)
    markup = re.sub(r'<style>.*?</style>', '', src, flags=re.S)
    used = set()
    for m in re.finditer(r'class="([^"]*)"', markup):
        used.update(m.group(1).split())
    # class names that only appear inside script strings
    for m in re.finditer(r'<script>(.*?)</script>', markup, re.S):
        used.update(re.findall(r"[\w-]+", m.group(1)))
    return sorted(c for c in defined_classes(css) if c not in used)


if __name__ == '__main__':
    path = sys.argv[1]
    text = open(path, encoding='utf-8').read().replace('\r\n', '\n')
    if '--remove' in sys.argv:
        names = set(sys.argv[sys.argv.index('--remove') + 1].split(','))
        _, css, _ = split_page(text)
        new, removed = prune(css, names)
        print(f'{len(removed)} selectors removed, {len(css) - len(new)} characters')
        for r in removed:
            print('  ', r)
    else:
        for c in unused_classes(text):
            print(c)
