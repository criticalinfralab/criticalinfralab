#!/bin/bash

# Install dependencies:
## sudo apt install pandoc python3-pandocfilters python-is-python3 weasyprint qpdf npm
## npm install

# Exit values:
## 1 = Incompatible OS: Not a Debian-based GNU/Linux operating system distribution;9u
## 2 = Permission problem: Missing sudo rights
## 3 = File not found

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
    if apt policy $1 | grep Installed | grep none; then
        echo Missing Debian package dependency found: INSTALL $1
        has_sudo # this is a kind of assertion here because it will exit on fail
        sudo apt install $1
    else
        echo Found Debian package dependency $1
    fi
}

is_installed_npm () {
    if npm list | grep pagedjs-cli; then
        echo Found missing NPM dependency $1;
        npm install $1
    else
        echo Found NPM dependency $1
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
    echo Checking dor Debian package dependency $x
    is_installed_apt $1
done

## Check NPM package dependency
is_installed_npm pagedjs-cli

## Check necessary files

for x in ./examples/input.md\
             assets/cover.css\
             assets/xapers.bib\
             filters/deleteemptyheader.py\
             filters/remove-space-before-note.lua\
             assets/print.css; do
    if test -f $x; then
        echo File dependency $x exists.  Good!
    else
        echo File dependency $x missing.  Bad!
        echo ERROR: File not found
        exit 3
    fi
done

# 1. Generate cover
pandoc ./examples/cover.md\
       --css=assets/cover.css\
       --pdf-engine=pagedjs-cli\
       -o cover.pdf

# 2. Generate pages
pandoc ./examples/input.md\
       --reference-location=section\
       --toc -V toc-title:"Table of Contents"\
       --toc-depth=2\
       --citeproc\
       --bibliography=assets/xapers.bib\
       --metadata title="Shifting terrain"\
       --filter filters/deleteemptyheader.py\
       --lua-filter filters/remove-space-before-note.lua\
       --pdf-engine=weasyprint\
       --dpi=300\
       --css=assets/print.css\
       -o output.pdf

# 3. Combine cover and text
qpdf --empty --pages cover.pdf output.pdf -- combined.pdf
