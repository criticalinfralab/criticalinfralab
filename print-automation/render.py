#!/bin/python3

from sys import argv
from os import path
from subprocess import run
from subprocess import DEVNULL

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

def assert_installed_deb(name):
    dpkg = run(['dpkg', '-s', name], stout=DEVNULL, sterr=DEVNULL)
    if dpkg.returncode:
        print(f'Missing Debian package dependency found: INSTAL {name}')
    else:
        print(f'Found installed Debian package {name}')

# Sanity checks ----------------------------------------------------------------
        
assert_debian_based()
assert_correct_number_of_arguments()
assert_correct_type_of_arguments()
assert_sudo_capability()
dependencies = {}
dependencies['Debian'] = ['pandoc',
                          'python3-pandocfilters',
                          'python-is-python3',
                          'weasyprint',
                          'pdf',
                          'npm']
for name in dependencies['Debian']:
    assert_installed_deb(name)

if len(argv) == 2:
    serial = argv[1].zfill(3)








