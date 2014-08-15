import re
import time
import math


def dspTrans(name):
	def converttime(time):
		timing=time.split(",")
		times=timing[0].split(":")
		hour=int(times[0])
		min=int(times[1])
		sec=int(times[2])
		miliseconds=(3600000*hour +60000*min+1000*sec+int(timing[1]))
		tTime=str(miliseconds).zfill(6)
		return tTime


	transcript=open(name+".srt","r").readlines()
	transcript=[i.replace("\n","") for i in transcript]
	transcript=[i for i in transcript if i.isdigit()==False]
	transcript=[i for i in transcript if len(i)!=0]
	count=0
	tracker=-1
	result=''
	for i in range(len(transcript)):
		if("-->"  in transcript[i]):
			count=count+1
	newlist=[[] for _ in range(count)]
	timelist=[]
	for j in range(len(transcript)):
		 if("-->" in transcript[j]):
			 tracker=tracker+1
		 newlist[tracker].append(transcript[j])

	trans=open(name+"transcription.txt","w")
	for i in range(len(newlist)):
		timelist=newlist[i][0].split("-->")
		timing=converttime(timelist[0])
		trans.write(timing+"~")
		tim=converttime(timelist[1])
		duration=str(int(tim)-int(timing)).zfill(6)
		trans.write(duration+"~")
		for j in range(1,len(newlist[i])):
				  result=(result+' '+newlist[i][j]).lstrip()
		trans.write(result+"\n")
		result=''
	trans.close()
