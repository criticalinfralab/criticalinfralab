#!/bin/python3

import os
from glob import glob
from shutil import copy
from sys import argv
from subprocess import run, DEVNULL, PIPE

# Utility functions ------------------------------------------------------------

def assert_debian_based():
    if os.path.isfile('/etc/debian_version'):
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

def if_su():
    su = run(['sudo', '--list', '--non-interactive'], stdout=DEVNULL)
    return su.returncode
#    if su.returncode:
#        exit("""
#        You need sudo rights to run this script.
#        PERMISSION ERROR:
#                   Missing sudo rights
#        """)

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
    if os.path.isfile(name):
        print(f'File dependency {name} exists.  Good!')
    else:
        print(f'File dependency {name} missing.  Bad!')
        print('ERROR: File not found')
        exit(3)

def delete(which):
    '''Delete a directory recursively'''
    print(f'Deleting {which}...')
    for root, dirs, files in os.walk(which, topdown=False):
        for name in files:
            os.remove(os.path.join(root, name))
            print(f'Debug: RM {name}')
        for name in dirs:
            os.rmdir(os.path.join(root,name))
            print(f'Debug: RMDIR {name}')
        os.rmdir(which)
        print(f'Debug: RMDIR {which}')

def clean_up():
    delete(tmpdir)
    # Sometimes there are also leftover temporary directories from renderers! 
    # rm -rf /tmp/puppeteer_dev_chrome_profile-* /tmp/weasyprint-*
    delete('/tmp/puppeteer_dev_chrome_profile-*')
    delete('/tmp/weasyprint-*')
    os.chdir(f'{cwd}/{serialdir}')
    print("Cleaned up the temporary directory!")

def r(cmd):
    '''Run the passed list of command line function and arguments'''
    print(f"Executing {cmd}")
    # run(cmd, stdout=DEVNULL, stderr=DEVNULL)
    print(run(cmd, capture_output=True))
        
# Constants -------------------------------------------------------------------

# Pad to three digits.  Example: 3->003; 33->033; 333->333
if len(argv) == 2:
    serial = argv[1].zfill(3)
    serialdir = f'CIL{str(serial)}/'
else:
    serial = 0
    ls = os.listdir()
    for x in ls:
        if "CIL" in x and os.path.isfile(x):
            x = int(x[3:].lstrip("0"))
            serial = x if x > serial else x
    serial = str(serial).zfill(3)
    serialdir = f'CIL{serial}/'

cwd = os.getcwd()

# Dependencies ----------------------------------------------------------------

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
                          'pdftk-java',
                          'npm']
dependencies['NPM'] = ['pagedjs-cli']
tmpdir = '/tmp/render/'


# Sanity checks ----------------------------------------------------------------
        
assert_debian_based()
assert_correct_number_of_arguments()
assert_correct_type_of_arguments()
for name in dependencies['Debian']:
    assert_deb_dependency(name)
for name in dependencies['NPM']:
    assert_npm_dependency(name)
for name in dependencies['files']:
    assert_file_dependency(name)
    
# Render -----------------------------------------------------------------------

clean_up()
os.mkdir(tmpdir)

with open('0title.md') as f: title = f.read()

## 1. Generate cover
print()
print("## 1. Generate cover")
r (['pandoc',
    '1cover.md',
    '--metadata',
    f'title="{title}"',
    '--css=../assets/cover.css',
    '--pdf-engine=pagedjs-cli',
    f'--output={tmpdir}1.pdf'])

## 2. Generate colophon
print()
print("## 2. Generate colophon")
r (['pandoc',
    '2colophon.md',
    '--reference-location=section',
    '--metadata',
    # f'title="{title}"',
    '--filter=../filters/deleteemptyheader.py',
    '--lua-filter=../filters/remove-space-before-note.lua',
    '--pdf-engine=weasyprint',
    '--dpi=300',
    '--css=../assets/colophon.css',
    f'--output={tmpdir}2.pdf'])

## 3. Generate pages
print()
print("## 3. Generate pages")
r (['pandoc',
    '3main.md',
    '--reference-location=section',
    '--toc',
    '-V',
    'toc-title:Table of Contents',
    '--toc-depth=2',
    # '--citeproc',
    # '--bibliography=../assets/xapers.bib',
    '--metadata',
    # f'--title="{title}"',
    '--filter=../filters/deleteemptyheader.py',
    '--lua-filter=../filters/remove-space-before-note.lua',
    '--pdf-engine=weasyprint',
    '--dpi=300',
    '--css=../assets/print.css',
    f'--output={tmpdir}3.pdf'])

## 4. Generate backcover
print()
print("## 4. Generate backcover")
r (['pandoc',
    '4backcover.md',
    '--css=../assets/backcover.css',
    '--pdf-engine=pagedjs-cli',
    f'--output={tmpdir}4.pdf'])

## 5. Insert orange pages for the inside of the cover pages
print()
print("## 5. Insert orange pages for the inside of the cover pages")

## Rename files to make space for orange pages 

# 1 cover (was 1)
# 2 orange (new)
# 3 colophon (was 2)
# 4 main (was 3)
# 5 orange (new)
# 6 backcover (was 4)

working_directory = os.getcwd()
os.chdir(tmpdir)
os.replace('4.pdf', '6.pdf')
os.replace('3.pdf', '4.pdf')
os.replace('2.pdf', '3.pdf')
os.chdir(working_directory)

## 6. Copy orange pages in place
print()
print('## 6. Copy orange pages in place')
placeholder=f'{os.getcwd()}/../assets/placeholder-cover-inside-A4-orange-bleed-surely-there.pdf'

copy(placeholder, f'{tmpdir}5.pdf')
copy(placeholder, f'{tmpdir}2.pdf')

## 7. Join PDF files
print()
print('## 7. Join PDF files')
outputfilepath = f'../output/CIL{serial}.pdf'

print(f"tmpdir = {tmpdir}")

r(['qpdf',
   '--empty',
   '--pages',
   *sorted(glob(f'{tmpdir}?.pdf')),
   '--',
   outputfilepath])

## 8. Clean up
print()
print('## 8. Clean up')
clean_up() # again, like in the beginning
# Leave a copy in /tmp
copy(outputfilepath, '/tmp/')

## 9. Notify user or open file
print()
print('## 9. Notify user or open file')
print(f"Rendered PDF file ready under {outputfilepath} !")
print() # Print an empty line when all is done

# Only open the output file in a PDF viewer if there is a graphical environment:
if 'DISPLAY' in os.environ.keys(): r(['xdg-open', outputfilepath])


