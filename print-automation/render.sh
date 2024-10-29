#!/bin/bash

# Install dependencies:
## sudo apt install pandoc python3-pandocfilters python-is-python3 weasyprint qpdf npm
## npm install

# Exit values:
## 1 = Incompatible OS: Not a Debian-based GNU/Linux operating system distribution;9u
## 2 = Permission problem: Missing sudo rights
## 3 = File not found

# For DEBUG change to
# set -x
set +x

# Parse arguments

if [ "$#" -eq "0" ]; then
    N=0
elif [ "$#" -eq "1" ]; then
    N=$1
else
    echo "Illegal number of parameters.  Render accepts zero or one argument.  The optional argument is the serial number of the CIL publication (1-999) that points to a relevant directory like CIL001 or CIL999."
    exit 1
fi

if ! [[ $N =~ ^[0-9]+$ ]] ; then
    echo "ERROR: First parameter should be a number (e.g. an integer).

Render accepts zero or one argument.  The optional argument is the serial number of the CIL publication (1-999) that points to a relevant directory like CIL001 or CIL999."
    exit 2
fi

N=$(printf "%03d\n" $N) # Pad to three digits.  Example: 3->003; 33->033; 333->333

# Utility functions

is_debian_based () {
    if test -f "/etc/debian_version"; then
        echo Found Debian-based GNU/Linux distro.  Good!
    else
        echo You need a Debian-based GNU/Linux distro to run this script.
        echo ERROR Incompatible OS: Not a Debian-based GNU/Linux operating system distribution
        exit 1
    fi
}

has_sudo () {
    if sudo -l | grep ALL; then
        echo Found sudo rights.  Good!
    else
        echo You need sudo rights to run this script.
        echo ERROR: Permission problem: Missing sudo rights
        exit 2
    fi
}

is_installed_apt () {
    if ! dpkg -s $! >/dev/null 2>&1; then
        echo Missing Debian package dependency found: INSTALL $1
        has_sudo # this is a kind of assertion here because it will exit on fail
        sudo apt install $1
    else
        echo Found Debian package dependency $1
    fi
}

is_installed_npm () {
    if npm list -g | grep pagedjs-cli; then
        echo Found NPM dependency $1
    else
        echo Found missing NPM dependency $1
        npm install $1
    fi
}

# 0. Sanity checks

## Check if this is a Debian-based distro
is_debian_based

## Check Debian package dependencies
for x in pandoc\
             python3-pandocfilters\
             python-is-python3\
             weasyprint\
             qpdf\
             npm; do
    echo Checking for Debian package dependency $x
    is_installed_apt $x
done

## Check NPM package dependency
is_installed_npm pagedjs-cli

## Check necessary files

for x in filters/deleteemptyheader.py\
             filters/remove-space-before-note.lua\
             assets/print.css\
             assets/cover.css\
             assets/backcover.css\
             assets/xapers.bib; do
    if test -f $x; then
        echo File dependency $x exists.  Good!
    else
        echo File dependency $x missing.  Bad!
        echo ERROR: File not found
        exit 3
    fi
done

rm -rf /tmp/render/
mkdir /tmp/render/
cd CIL$N

if test -f 0title.md; then
    TITLE=$(cat 0title.md)
else
    echo "CIL$N/0title.md missing.  No source file for the title!  Please add a file with that name with a single line for the title.  Skipping title for now..."
fi

# 1. Generate cover
if test -f 1cover.md; then
    pandoc 1cover.md\
           --css=../assets/cover.css\
           --pdf-engine=pagedjs-cli\
           -o /tmp/render/1.pdf
else
   echo "CIL$N/1cover.md missing.  No source file for the cover!  Skipping cover..."
fi

# 2. Generate colophon
if test -f 2colophon.md; then
    pandoc 2colophon.md\
           --reference-location=section\
           --metadata title=""\
           --filter ../filters/deleteemptyheader.py\
           --lua-filter ../filters/remove-space-before-note.lua\
           --pdf-engine=weasyprint\
           --pdf-engine-opt=--pdf-variant=pdf/ua-1\
           --dpi=300\
           --css=../assets/colophon.css\
           -o /tmp/render/2.pdf
else
   echo "CIL$N/2colophon.md missing.  No source file for the colophon!  Skipping colophon..."
fi

# 3. Generate pages
if test -f 3main.md; then
    pandoc 3main.md\
       --reference-location=section\
       --toc -V toc-title:"Table of Contents"\
       --toc-depth=2\
       --citeproc\
       --bibliography=../assets/xapers.bib\
       --metadata title="$TITLE"\
       --filter ../filters/deleteemptyheader.py\
       --lua-filter ../filters/remove-space-before-note.lua\
       --pdf-engine=weasyprint\
       --pdf-engine-opt=--pdf-variant=pdf/ua-1\
       --dpi=300\
       --css=../assets/print.css\
       -o /tmp/render/3.pdf
else
   echo "CIL$N/3main.md missing.  No source file for the main text!  Skipping the main text..."
fi

# 4. Generate backcover
if test -f 4backcover.md; then
    pandoc 4backcover.md\
           --css=../assets/backcover.css\
           --pdf-engine=pagedjs-cli\
           -o /tmp/render/4.pdf
else
   echo "CIL$N/4backcover.md missing.  No source file for the back cover!  Skipping the back cover..."
fi

# 5. Insert orange pages for the inside of the cover pages
## Rename files to make space for orange pages

# 1 cover (was 1)
# 2 orange (new)
# 3 colophon (was 2)
# 4 main (was 3)
# 5 orange (new)
# 6 backcover (was 4)

cd /tmp/render/
mv 4.pdf 6.pdf
mv 3.pdf 4.pdf
mv 2.pdf 3.pdf
cd -

## Copy orange pages in place

cp -v ../assets/placeholder-cover-inside-A4-orange-bleed-surely-there.pdf /tmp/render/2.pdf

cp -v ../assets/placeholder-cover-inside-A4-orange-bleed-surely-there.pdf /tmp/render/5.pdf

# 6. Combine cover, text, and backcover
qpdf --empty --pages /tmp/render/?.pdf -- ../output/CIL$N.pdf

# 7. Clean up
# rm -rf /tmp/render
cd ..
echo "Wrote CIL$N.pdf to the \"output\" directory."

if ps ax | grep -v grep | grep CIL$N.pdf; then
    echo DONE
else
    echo DONE
    echo "Opening the document in PDF reader using xdg-open."
    xdg-open output/CIL$N.pdf &
fi
