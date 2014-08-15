import os,sys,time,re
import shutil
from subprocess import Popen, list2cmdline
import subprocess
import multiprocessing as mp
from duplicate import *
from glob import glob
from os import rename
def ffmpeg1(a):
		oldpath='C://xampp/htdocs/bnn'
		os.chdir(oldpath)
		newpath="C://xampp/htdocs/bnn/"+a+"image"
		if not os.path.exists(newpath): os.makedirs(newpath)
		shutil.copyfile("ffmpeg.exe",newpath+"/ffmpeg.exe")
		shutil.copyfile(a+".mp4",newpath+"/"+a+".mp4")
		os.chdir(newpath)
		subprocess.call("ffmpeg -i "+a+".mp4 -vf select='eq(pict_type\,PICT_TYPE_I)' -vsync 2 -s 146x82 -f image2 %02d.jpeg",shell=True)
		os.chdir(oldpath)
		subprocess.call('ffprobe -show_frames -of compact=p=0 -f lavfi "movie='+a+'.mp4,select=eq(pict_type\,PICT_TYPE_I)">nbcc.csv',shell=True)

if __name__ == "__main__":
	if len(sys.argv) != 2 or "--help" in sys.argv:
		print "not available"
		sys.exit(-1)
	else:
		ffmpeg1(sys.argv[1])