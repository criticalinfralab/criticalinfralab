#!/bin/bash

if [ $# -ne 0 ]; then
    echo "new.sh does not take any arguments."
    echo
    echo "It just tries to see what is the next available serial number in the folder."
    exit 1
fi

# Number of last document in the series:
N=$((10#$(ls -1d CIL*/ | tail -n 1 | tr -d \[:alpha:\] | tr -d /)))
# Number of next document in the series:
N=$(echo $N+1 | bc)
# Pad to three digits.  Example: 3->003; 33->033; 333->333
N=$(printf "%03d\n" $N) 
# Make new directory for the next document:
DIR=CIL$N
mkdir -v $DIR
# Create empty files
for x in 0title 1cover 2colophon 3main 4backcover;do
         touch $DIR/"$x".md
done
