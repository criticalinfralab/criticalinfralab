# Editing style

- don't have headlines follow each other, there should always be text
  between normally. → that's something that cannot be automated but
  needs to be checked when editing the text

# Documentation

* Weasyprint CSS support in detail
  https://doc.courtbouillon.org/weasyprint/v52.5/features.html#css

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
      https://wakamaifondue.com/beta
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
- [] generate and style toc
- [] improve footnote placement
- [] place toc after cover or generate cover separately and join later?
- [] cover page
  - [] need to add logo infralab to front page
  - [] need to add background image to front page
  https://stackoverflow.com/questions/25591517/pandoc-inserting-pages-before-generated-table-of-contents could be useful
- [] backcover
- [] improve citation rendering and layout
      https://pandoc.org/MANUAL.html#citations
- [x] bibliography
      https://pandoc.org/MANUAL.html#option--bibliography

### Nice to have

the following things would be nice to have but require much more time:

- [] Check hyphenation style, we can use CSS hyphenation but we need a
     lang attribute for this to work correctly
- [] See if widows and orphans can be handled better:
     https://en.wikipedia.org/wiki/Widows_and_orphans
- [] if possible break titles after colons ":"
- [] footnote counter not working with pagedjs, but it works with
     weasyprint
- [] compute page number placement → currently seems impossible to do

→ probably I first need to generate the front cover page, then the toc,
then the contents and then merge it

# Scope

A markdown file that correctly renders to PDF using vanilla pandoc, as
in `pandoc input.md -o out-vanilla.pdf` should work if "correctly" if
you don't find confusing rendering artefacts in the output.

# Using pandoc and weasyprint or pagedjs-cli

pandoc input.md\
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
       -css=assets/print.css\
       -o output.pdf

pandoc input.md\
       --reference-location=section\
       --toc -V toc-title:"Table of Contents"\
       --toc-depth=2
       --citeproc\
       --bibliography=assets/xapers.bib
       --metadata title="Shifting terrain"\
       --filter filters/deleteemptyheader.py
       --lua-filter filters/remove-space-before-note.lua
       --pdf-engine=pagedjs-cli\
       --dpi=300\
       -css=assets/print.css\
       -o output.pdf

# Requirements

Using weasyprint:

  `sudo apt install pandoc python3-pandocfilters python-is-python3 weasyprint`

Using pagedjs-cli:

  `sudo apt install pandoc python3-pandocfilters python-is-python3 npm`
  `sudo npm install -g pagedjs-cli`

# Additional requirements

(to be tested)
* for SVG output: librsvg2-bin

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
