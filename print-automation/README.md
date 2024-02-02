# Print automation

For generating the critical infrastructure lab document series.

# Scope

A markdown file that correctly renders to PDF using vanilla pandoc, as
in `pandoc input.md -o out-vanilla.pdf` should work if "correctly" if
you don't find confusing rendering artefacts in the output.

This should work on recent Debian-based GNU/Linux distributions.

# Manually verify:

- that there are no paragraphs with bold text disguising as a headline →
  please make them into h3 headlines manually!

# Generating the PDF

Start a new document:

    ./new.sh

The command creates a new directory with an incremented serial number. For example, if the last document was CIL002 then the next document will live in the folder CIL003.  Empty files are created for all the parts. Look at CIL000 as an example and this file for explanation!

Run the pipeline to generate a PDF from the plain text files with Markdown syntax:

    ./render.sh N

Where “N” is the number of the document.  For example 5 for CIL005, etc. If all goes well, the generated file will appear in the same folder as render.sh. The new document will be called CIL005.pdf

# Markup examples

Single logo:

    ![logo critical infrastructure lab](./assets/images/logo-criticalinfralab.svg)\

Multiple logos:

    ![logo Open Future](./assets/images/logo-open-future.svg)
    ![logo critical infrastructure lab](./assets/images/logo-criticalinfralab.svg)
    ![logo New America](./assets/images/logo-new-america.png)
    ![logo Ford Foundation](./assets/images/logo-ford-foundation.svg)

Images of multiple sizes:

    ![Fucino example photo, by ESA](examples/image.jpg){width=100% height=100%}

    ![Fucino example photo, by ESA](examples/image.jpg#fullcolumnwidth)

    ![Fucino](examples/image.jpg#fullpagewidth)

Pulled quote:

     ###### This is a fake pulled quote which needs to be longer so we can test the border

Table:

     | Item         | Price     | # In stock |
     |--------------|-----------|------------|
     | Juicy Apples | 1.99      | *7*        |
     | Bananas      | **1.89**  | 5234       |

Code:

    Indent 4 spaces!

Code with backticks is currently not working as the :has()
pseudo-selector cannot undo the margin-left of our paragraphs and pandoc
produces "p > code".

Colored dot on cover:

    <span class="category all"></span>

Possible values: `all, environment, geopolitics, standards, standards-geopolitics, environment-geopolitics, environment-standards`.  Don't delete the `category` class!

# HACKING

## Documentation

* Weasyprint CSS support in detail
  https://doc.courtbouillon.org/weasyprint/v52.5/features.html#css

* Pandoc manual
  https://www.uv.es/wikibase/doc/eng/pandoc_manual_2.7.3.wiki

* Standard
  https://www.w3.org/TR/css-gcpm-3/

## Requirements

Currently, the cover is best interpreted by pagedjs-cli, while the
contents is best interpreted by weasyprint. Ideally, both would work
with one or the other.

  `sudo apt install pandoc python3-pandocfilters python-is-python3 weasyprint qpdf npm`
  `npm install -g pagedjs-cli`

## Additional requirements

for SVG output `librsvg2-bin` is needed only if not using one of the
above mentioned pdf rendering engines.

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
- [x] generate and have a backcover (that should be fairly easy, but it's
      one more step in the process.)

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

