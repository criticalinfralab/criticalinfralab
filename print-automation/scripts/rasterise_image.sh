#!/bin/bash

if [ $# -ne 1 ]; then
    echo "This scripts accepts a single argument that has to be the file name of an image in the same directory as the script."
    exit 1
fi

has_sudo () {
    if sudo -l | grep ALL; then
        echo "Found sudo rights.  Good!"
    else
        echo "You need sudo rights to run this script."
        echo "ERROR: Permission problem: Missing sudo rights"
        exit 2
    fi
}

is_installed_apt () {
if ! dpkg -s $! >/dev/null 2>&1; then
        echo "Missing Debian package dependency found: INSTALL $1"
        has_sudo # this is a kind of assertion here because it will exit on fail
        sudo apt install $1
    else
        echo Found Debian package dependency $1
    fi
}

echo "Checking for Debian package dependency imagemagick"
is_installed_apt imagemagick


# You can find the various dithering patterns such ash h8x8o here:
echo "Running the following imagemagick command:"
set -x
# Do the image magick:
mogrify -verbose $1 -colors 4 -ordered-dither h8x8o $1
set +x
echo "Overwrote image $1 in this folder."
echo "-----------------------------------------------------------------------------"
echo "You can try to change the -ordered-dither pattern based on the documentation:"
echo "Run `convert -list threshold` to see the choice of patterns!"
echo "You can also try to change the number of -colors (now it was 4)."
