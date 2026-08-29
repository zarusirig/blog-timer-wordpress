#!/usr/bin/env python3
"""Minify style.css -> style.min.css.

Deliberately conservative: it only strips comments and collapses whitespace.
It never touches values, so calc(), url(), custom properties and quoted
strings all survive untouched. functions.php only serves style.min.css when
it is newer than style.css, so a stale build is ignored instead of shipped.

Run:  python3 tools/build-css.py
"""
import os
import re

THEME = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
SRC = os.path.join(THEME, 'style.css')
DST = os.path.join(THEME, 'style.min.css')

css = open(SRC, encoding='utf-8').read()
header = re.match(r'\s*/\*.*?\*/', css, re.S)
banner = '/*! The Blog Timer — built from style.css by tools/build-css.py */\n'

css = re.sub(r'/\*.*?\*/', '', css, flags=re.S)   # comments
css = re.sub(r'\s+', ' ', css)                     # collapse whitespace
css = re.sub(r'\s*([{};])\s*', r'\1', css)         # tighten braces / semicolons
css = css.replace(';}', '}').strip()

open(DST, 'w', encoding='utf-8').write(banner + css + '\n')

s, d = os.path.getsize(SRC), os.path.getsize(DST)
print('style.css     %6d bytes' % s)
print('style.min.css %6d bytes  (-%d%%)' % (d, round(100 - d * 100 / s)))
