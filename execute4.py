import os,sys,time,re
from subprocess import Popen, list2cmdline
import subprocess
from Translate import *
import multiprocessing as mp
from duplicate import *
from glob import glob
from os import rename
from dsp import *
def ffmpeg3(a,num):
	os.chdir('C://xampp/htdocs/bnn')
	if(num=="1"):
		subprocess.call('transcription.bat',shell=True)
	else:
		dspTrans(a)
	#trans(a+'transcription.txt',a)
if __name__ == "__main__":
	if len(sys.argv) != 3 or "--help" in sys.argv:
		print "not available"
		sys.exit(-1)
	else:
		ffmpeg3(sys.argv[1],sys.argv[2])