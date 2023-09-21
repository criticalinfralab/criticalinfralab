#!/usr/bin/env python

"""
Pandoc filter to delete empty header lines
from the input file such as "###"
"""

from pandocfilters import toJSONFilter, Header

def delemptyheader(key, value, format, meta):
  if key == 'Header' and not(value[2]):
    return []
if __name__ == "__main__":
    toJSONFilter(delemptyheader)
