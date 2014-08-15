import os,sys,time,re
from subprocess import Popen, list2cmdline
import subprocess
from Translate import *
import multiprocessing as mp
from duplicate import *
from boundaryCreation import *
from textProcessing import *
from glob import glob
from os import rename
def ffmpeg4(a,num):
	os.chdir('C://xampp/htdocs/bnn')
	boundaryCreation(a,num)
	textProcessing(a,num)
if __name__ == "__main__":
    if len(sys.argv) != 3 or "--help" in sys.argv:
        print "not available"
        sys.exit(-1)
    else:
        ffmpeg4(sys.argv[1],sys.argv[2])