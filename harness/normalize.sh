#!/usr/bin/env bash
# Strip values that legitimately differ run to run, so a diff shows only real
# behavioural change. Tune by capturing 8074 twice and diffing the two.
#
# Whitespace handling matters more than it looks. PHP emits a newline BEFORE
# each diagnostic; capture.sh strips the message text but the newline stays.
# So a version emitting 11 deprecations and one emitting 0 would differ purely
# in leading blank lines. cat -s collapses runs, and the perl trim removes
# leading/trailing blank space entirely.
sed -E \
  -e 's#[0-9]{4}-[0-9]{2}-[0-9]{2}[T ][0-9]{2}:[0-9]{2}:[0-9]{2}#<TIMESTAMP>#g' \
  -e 's#[0-9]+\.[0-9]{3,} ?(sec|seconds|ms)#<ELAPSED>#gi' \
  -e 's#localhost:(8074|8083)#localhost:<PORT>#g' \
  -e 's#(<li>)[0-9]+\.[0-9]+s(</li>)#\1<ELAPSED>\2#g' \
  -e 's#(class="bench">)[0-9]+\.[0-9]+s#\1<ELAPSED>s#g' \
  -e 's#(name="secret" value=")[^"]*#\1<SECRET>#g' \
  -e 's#(image\.php\?text=)[^"]*#\1<SECRET>#g' \
  | cat -s \
  | perl -0777 -pe '
      # addons/figure.php picks a random row, so the whole <img> varies per
      # request -- src, dimensions, alt and title. Collapse it.
      s{<img\s+src="[^"]*actionfigures/[^"]*".*?/>}{<FIGURE/>}gs;
      s/\A\s*\n//; s/\s+\z/\n/'
