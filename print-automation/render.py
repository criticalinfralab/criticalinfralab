#!/bin/python3

from sys import argv
from os import chdir, getcwd, path, mkdir, rmdir, remove, replace, walk
from subprocess import run, DEVNULL, PIPE

# Utility functions ------------------------------------------------------------

def assert_debian_based():
    if path.isfile('/etc/debian_version'):
        print("Found Debian-based GNU/Linux distro.  Good!")
    else:
        exit("""
        This script only runs on Debian-based GNU/Linux distros.
        ERROR Incompatible OS:
              Not a Debian-based GNU/Linux operating system distribution
        """)

def assert_correct_number_of_arguments():
    if len(argv) > 2:
        exit("""
        The first and only argument should be an integer or nothing.
        ARGUMENT ERROR:
                 Illegal number of parameters.
                 Render accepts zero or one argument.
                 The optional argument is the serial number
                 of the CIL publication (1-999) that points
                 to a relevant directory like CIL001 or CIL999.
        """)

def assert_correct_type_of_arguments():
    if len(argv) == 2:
        try:
            int(argv[1])
        except:
            exit("""
            VALUE ERROR:
                  First parameter should be a number (e.g. an integer).
                  Render accepts zero or one argument.
                  The optional argument is a serial number of a CIL publication (1-999)
                  that points to a relevant directory like CIL001 or CIL999.
            """)

def assert_sudo_capability():
    su = run(['sudo', '-l'], stdout=DEVNULL)
    if su.returncode:
        exit("""
        You need sudo rights to run this script.
        PERMISSION ERROR:
                   Missing sudo rights
        """)

def assert_deb_dependency(name):
    dpkg = run(['dpkg', '-s', name], stdout=DEVNULL, stderr=DEVNULL)
    if dpkg.returncode:
        print(f'Missing Debian package dependency found: INSTALL {name}')
        exit()
    else:
        print(f'Found installed Debian package {name}')

def assert_npm_dependency(name):
    npm = run(['npm', 'list', name], capture_output=True, text=True)
    if name not in npm.stdout:
        print(f'Missing NPM package dependency found: INSTALL {name}')
        exit()
    else:
        print(f'Found installed NPM package {name}')

def assert_file_dependency(name):
    if path.isfile(name):
        print(f'File dependency {name} exists.  Good!')
    else:
        print('File dependency $x missing.  Bad!')
        print('ERROR: File not found')
        exit(3)

def delete(which):
    '''Delete a directory recursively'''
    print(f'Deleting {which}...')
    for root, dirs, files in walk(which, topdown=False):
        for name in files:
            remove(path.join(root, name))
            print('RM')
        for name in dirs:
            rmdir(path.join(root,name))
            print('RMDIR')
        rmdir(which)

def r(cmd):
    '''Run the passed list of command line function and arguments'''
    run(cmd, stdout=DEVNULL, stderr=DEVNULL)
        
# Dependencies ----------------------------------------------------------------

# Pad to three digits.  Example: 3->003; 33->033; 333->333
if len(argv) == 2:
    serial = argv[1].zfill(3)
    serialdir = 'CIL'+str(serial)+'/'
dependencies = {}
dependencies['files'] = ['filters/deleteemptyheader.py',
                         'filters/remove-space-before-note.lua',
                         'assets/print.css',
                         'assets/cover.css',
                         'assets/backcover.css',
                         'assets/xapers.bib',
                         serialdir+'1cover.md',
                         serialdir+'2colophon.md',
                         serialdir+'3main.md',
                         serialdir+'4backcover.md']
dependencies['Debian'] = ['pandoc',
                          'python3-pandocfilters',
                          'python-is-python3',
                          'weasyprint',
                          'pdf',
                          'npm']
dependencies['NPM'] = ['pagedjs-cli']
tmpdir = '/tmp/render/'

# Sanity checks ----------------------------------------------------------------
        
assert_debian_based()
assert_correct_number_of_arguments()
assert_correct_type_of_arguments()
assert_sudo_capability()
for name in dependencies['Debian']:
    assert_deb_dependency(name)
for name in dependencies['NPM']:
    assert_npm_dependency(name)
for name in dependencies['files']:
    assert_file_dependency(name)
    
# Clean up ---------------------------------------------------------------------

delete(tmpdir)
mkdir(tmpdir)
chdir(f'CIL{serial}')

# Render -----------------------------------------------------------------------

with open('0title.md') as f: title = f.read()

## 1. Generate cover
r (['pandoc',
    '1cover.md',
    '--css=../assets/cover.css',
    '--pdf-engine=pagedjs-cli',
    f'-o {tmpdir}1.pdf'])

## 2. Generate colophon
r (['pandoc',
    '2colophon.md',
    '--reference-location=section',
    f'--metadata title="{title}"',
    '--filter ../filters/deleteemptyheader.py'
    '--lua-filter ../filters/remove-space-before-note.lua'
    '--pdf-engine=weasyprint',
    '--dpi=300',
    '--css=../assets/colophon.css',
    f'-o {tmpdir}2.pdf'])

## 3. Generate pages
r (['pandoc',
    '3main.md',
    'reference-location=section',
    'toc -V toc-title:"Table of Contents"',
    'toc-depth=2',
    'citeproc',
    'bibliography=../assets/xapers.bib',
    'metadata title="$TITLE"',
    'filter ../filters/deleteemptyheader.py',
    'lua-filter ../filters/remove-space-before-note.lua',
    'pdf-engine=weasyprint',
    'dpi=300',
    'css=../assets/print.css',
    '-o /tmp/render/3.pdf'])

# 4. Generate backcover
r (['pandoc'
    '4backcover.md',
    '--css=../assets/backcover.css',
    '--pdf-engine=pagedjs-cli',
    '-o /tmp/render/4.pdf'])

# 5. Insert orange pages for the inside of the cover pages
## Rename files to make space for orange pages 

# 1 cover (was 1)
# 2 orange (new)
# 3 colophon (was 2)
# 4 main (was 3)
# 5 orange (new)
# 6 backcover (was 4)

working_directory = getcwd()
chdir($tmpdir)
replace('4.pdf' '6.pdf')
replace('3.pdf' '4.pdf')
replace('2.pdf' '3.pdf')
chdir(working_directory)

## 6. Copy orange pages in place

# cp -v ../assets/placeholder-cover-inside-A4-orange-bleed-surely-there.pdf /tmp/render/2.pdf

# cp -v ../assets/placeholder-cover-inside-A4-orange-bleed-surely-there.pdf /tmp/render/5.pdf

