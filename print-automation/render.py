#!/bin/python3

import os.path, subprocess, sys

# Utility functions ------------------------------------------------------------

def assert_debian_based():
    if os.path.isfile('/etc/debian_version'):
        print("Found Debian-based GNU/Linux distro.  Good!")
    else:
        exit("""You need a Debian-based GNU/Linux distro to run this script.
ERROR Incompatible OS: Not a Debian-based GNU/Linux operating system distribution""", 1)

def assert_correct_number_of_arguments():
    if len(sys.argv) > 2:
        exit("Illegal number of parameters.  Render accepts zero or one argument.  The optional argument is the serial number of the CIL publication (1-999) that points to a relevant directory like CIL001 or CIL999.")

def assert_correct_type_of_arguments():
    if len(sys.argv) == 2:
        try:
            int(sys.argv[1])
        except:
            raise ValueError("""ERROR: First parameter should be a number (e.g. an integer).

Render accepts zero or one argument.  The optional argument is the serial number of the CIL publication (1-999) that points to a relevant directory like CIL001 or CIL999.""")

def assert_sudo_capability():
    sudo, cmd = False, subprocess.run(['sudo', '-l'], capture_output=True)
    for line in cmd.stdout.decode().split('\n'):
        if "ALL" in line:
           sudo = True
    if not sudo:
        exit("""You need sudo rights to run this script.
ERROR: Permission problem: Missing sudo rights""")

# Sanity checks ----------------------------------------------------------------
        
assert_debian_based()
assert_correct_number_of_arguments()
assert_correct_type_of_arguments()
assert_sudo_capability()

if len(sys.argv) == 2:
    serial = sys.argv[1].zfill(3)








