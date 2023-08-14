# Manually verify:

- that there are no paragraphs with bold text disguising as a headline →
  please make them into h3 headlines manually

# Documentation

* Weasyprint CSS support in detail
  https://doc.courtbouillon.org/weasyprint/v52.5/features.html#css

* Pandoc manual
  https://www.uv.es/wikibase/doc/eng/pandoc_manual_2.7.3.wiki

* Standard
  https://www.w3.org/TR/css-gcpm-3/

# TODO

## Preprocessing

This can be achieved with pandoc [filters](https://pandoc.org/filters.html)

- script to clean trainling whitespace
  sed -i 's/[ \t]*$//' "$1"
  → seems to not matter at all, this is already done by Pandoc
- transform single paragraphs with strong> into h3 → this proves to be
  super tedious, I'm abandoning
- remove empty lines which have only "###" or #### or #####
  → filters/delemptyheader.py
- remove spaces before notes
  → filters/remove-space-before-note.lua
- maybe script to remove unicode chars

### Useful for writing filters

see AST produced by pandoc:

 `pandoc -s -t native input.md | more`

# TODO list

- [x] font variants
      https://css-tricks.com/almanac/properties/f/font-variant-numeric/
      https://fonts.google.com/knowledge/using_type/implementing_open_type_features_on_the_web
- [x] styles for footnotes
- [x] footnotes instead of endnotes
      https://pandoc.org/MANUAL.html#footnotes
- [x] preprocessing
- [x] test images
- [x] test logos
- [x] test tables
- [x] footnotes and tables both appear weirdly bold in Sans, I think
  weasy might have an issue with the font weight settings, will try with
  separate fonts
- [x] bibliography
      https://pandoc.org/MANUAL.html#option--bibliography
- [x] cover page
  - [x] need to add logo infralab to front page
  - [x] need to add background image to front page
- [x] style toc and place it correctly
- [x] footnote counter is broken

### Nice to have

the following things would be nice to have but require much more time:

- [] Make page generation use pagedjs-cli as well
  - [] custom footnote counter not working correctly with pagedjs
       (ignores `before:` when counting)
  - [] pagedjs-cli page bottom rendering sucks
  - [] pagedjs-cli fails to render the page numbers in toc
- [] improve footnote placement - we want to have them at the bottom of
     the page, not right after the text
- [] improve citation rendering and layout
      https://pandoc.org/MANUAL.html#citations
- [] Check hyphenation style, we can use CSS hyphenation but we need a
     lang attribute for this to work correctly
- [] See if widows and orphans can be handled better:
     https://en.wikipedia.org/wiki/Widows_and_orphans
- [] if possible break titles after colons ":"
- [] compute page number placement → currently seems impossible to do
- [] generate and have a backcover (that should be fairly easy, but it's
  one more step in the process.)

# Scope

A markdown file that correctly renders to PDF using vanilla pandoc, as
in `pandoc input.md -o out-vanilla.pdf` should work if "correctly" if
you don't find confusing rendering artefacts in the output.

# Generating the PDF

## 1. Generate cover

`pandoc ./examples/cover.md\
       -c assets/cover.css
       --pdf-engine=pagedjs-cli
       -o cover.pdf`

## 2. Generate pages

`pandoc input.md\
       --reference-location=section\
       --toc -V toc-title:"Table of Contents"\
       --toc-depth=2
       --citeproc\
       --bibliography=assets/xapers.bib
       --metadata title="Shifting terrain"\
       --filter filters/deleteemptyheader.py
       --lua-filter filters/remove-space-before-note.lua
       --pdf-engine=weasyprint\
       --dpi=300\
       --css=assets/print.css\
       -o output.pdf`

## 3. Combine cover and text

`qpdf --empty --pages cover.pdf output.pdf -- combined.pdf`

# Requirements

Currently, the cover is best interpreted by pagedjs-cli, while the
contents is best interpreted by weasyprint. Ideally, both would work
with one or the other.

  `sudo apt install pandoc python3-pandocfilters python-is-python3 weasyprint qpdf npm`
  `npm install -g pagedjs-cli`

# Additional requirements

for SVG output `librsvg2-bin` is needed only if not using one of the
above mentioned pdf rendering engines.

# Markup examples

single logo:

![logo critical infrastructure lab](./assets/images/logo-criticalinfralab.svg)\

logos:

  ### Logos

  ![logo Open Future](./assets/images/logo-open-future.svg)
  ![logo critical infrastructure lab](./assets/images/logo-criticalinfralab.svg)
  ![logo New America](./assets/images/logo-new-america.png)
  ![logo Ford Foundation](./assets/images/logo-ford-foundation.svg)

table:

  | Item         | Price     | # In stock |
  |--------------|-----------|------------|
  | Juicy Apples | 1.99      | *7*        |
  | Bananas      | **1.89**  | 5234       |

code:

    indent 4 spaces

code with backticks is currently not working as the :has()
pseudo-selector cannot undo the margin-left of our paragraphs and pandoc
produces "p > code"

colored dot on cover:

<span class="category all"><!-- dot: don't delete the class "category".
possible values: all, environment, geopolitics, standards,
standards-geopolitics, environment-geopolitics, environment-standards
---></span>
