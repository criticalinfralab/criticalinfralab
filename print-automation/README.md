# TODO

- script to clean trainling whitespace
  sed -i 's/[ \t]*$//' "$1"
- maybe script to remove unicode chars
- other unclean things
  - remove empty elements such as <h5>
  - remove spaces before notes
  - remove empty lines which have only "###" or #### or #####
  - transform single parapgraphs with <b> or <strong> into h3

- [x] font variants
       https://wakamaifondue.com/beta
       https://css-tricks.com/almanac/properties/f/font-variant-numeric/
       https://fonts.google.com/knowledge/using_type/implementing_open_type_features_on_the_web
- [x] styles for footnotes
- [x] footnotes instead of endnotes
      https://pandoc.org/MANUAL.html#footnotes
- [] improve footnote placement
- [] generate and style toc
- [] place toc after cover or generate cover separately and join later
- [] cover page
  - [] need to add logo infralab to front page
  - [] need to add background image to front page
- [] backcover
- [] compute page number placement
- [] test images
- [] test logos
- [] improve citation rendering and layout
      https://pandoc.org/MANUAL.html#citations
- [x] bibliography
      https://pandoc.org/MANUAL.html#option--bibliography
- [] Schusterjunge/Hurenkinder, what to do about these?
- [] if possible break titles after colons ":"

# Editing rules

- don't have headlines follow each other, there should always be text
  between normally.

# Using pandoc and weasyprint
pandoc input.md\
       --reference-location=section\
       --toc\
       --citeproc\
       --bibliography=assets/xapers.bib
       --metadata title="Shifting terrain"\
       --pdf-engine=weasyprint\
       --dpi=300\
       -css=print.css\
       -o output.pdf

# Using pandoc and paged-js

$ sudo apt install npm
$ sudo npm install -g pagedjs-cli
$ pandoc input.md -o output.html
$ pagedjs-cli output.html -s A4 -o paged.pdf

# Additional requirements

* for SVG output: librsvg2-bin
