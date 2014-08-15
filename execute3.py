import os,sys,time,re
from subprocess import Popen, list2cmdline
import subprocess
import multiprocessing as mp
from duplicate import *
from audioProcessing import *
from glob import glob
from os import rename
def ffmpeg2(a):
		os.chdir('C://xampp/htdocs/bnn')
		p='"C://Program Files (x86)/VideoLAN/VLC/vlc.exe" -I dummy --no-sout-video --sout-audio --no-sout-rtp-sap --no-sout-standard-sap --ttl=1 --sout-keep --sout "#transcode{acodec=s16l,channels=1,samplerate=16000}:std{access=file,mux=wav,dst=output.wav}" "'+a+'.mp4" vlc://quit'
		subprocess.call(p,shell=True)
		subprocess.call("java -Xmx1024m -jar ./LIUM_SpkDiarization-8.4.1.jar --fInputMask=./output.wav --sOutputMask=./output.seg --doCEClustering  output",shell=True)
		audioProcessing('output.seg',a)
if __name__ == "__main__":
	if len(sys.argv) !=2 or "--help" in sys.argv:
		print "not available"
		sys.exit(-1)
	else:
		ffmpeg2(sys.argv[1])