import math
def termP(name):
	writeup=open(name+".ctm","r").readlines()
	writeup=[i.split(" ") for i in writeup]
	for x in range(len(writeup)):
		writeup[x][4]=writeup[x][4].replace("\n","").lower()
		writeup[x][2]=int(math.floor(float(writeup[x][2])+0.5))
		writeup[x][3]=int(math.floor(float(writeup[x][2])+float(writeup[x][3])+0.5))
	return writeup

