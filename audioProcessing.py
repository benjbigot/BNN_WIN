from collections import Counter
from operator import itemgetter
def audioProcessing(lium,a):
  text=open(lium,"r")
  lines=text.readlines()
  arr=[]
  sett=[[]]
  itemfreq=[]
  durationtrack=[]

#-------------------------------------append list--------------------------------------------
  for i in range(len(lines)):
      if(";;" not in lines[i]):
          arr.append(lines[i])
  for i in range(len(arr)):
      sett.append(arr[i].split(" "))
  sett.pop(0)
#--------------------------------------------------------------------------------------------


#--------------------------------Sort the list------------------------------------------------
  blocklist=[[] for _ in range(len(sett))]
  for i in range(len(sett)):
     itemfreq.append(sett[i][7].replace("\n",""))
     durationtrack.append(int(sett[i][2]))
  itemfreq.sort()
  count=1
  temp=''
  point=0
  word=''
  for i in range(len(itemfreq)):
      if(itemfreq[i]!=temp):
          if(count>point):
              point=count
              word=temp
          temp=itemfreq[i]
          count=1    
      else:
          count=count+1
  durationtrack.sort()
  for i in range(len(durationtrack)):
      for j in range(len(sett)):
          if(int(sett[j][2])==durationtrack[i]):
              blocklist[i].append(sett[j][2])
              blocklist[i].append(sett[j][3])
              blocklist[i].append(sett[j][7].replace("\n",""))
              blocklist[i].append(word)
  finalList=[]
  newList=[]
 #----------------------------------------------------------------------------------------------
 
 #---------------------------------need to split the line if it is more than 10 sec------------------------------
  for i in range(len(blocklist)):
      if(int(blocklist[i][1])>=1800):
          newList.append(blocklist[i][0])
          newList.append(str(float(blocklist[i][1])/2))
          newList.append(blocklist[i][2])
          newList.append(blocklist[i][3])
          finalList.append(newList)
          newList=[]
          newList.append(str(float(blocklist[i][0])+int(blocklist[i][1])/2))
          newList.append(str(float(blocklist[i][1])/2))
          newList.append(blocklist[i][2])
          newList.append(blocklist[i][3])
          finalList.append(newList)
          newList=[]
      else:
          finalList.append(blocklist[i])
  clust=0
  for i in range(len(finalList)):
      if(finalList[i][2]!=finalList[i][3]):
          finalList[i].append(clust)
      else:
          if(i!=0):
              if(finalList[i-1][2]!=finalList[i][3]):
                     clust=clust+1
                     finalList[i].append(clust)
              else:
                  if(float(finalList[i][0])-(float(finalList[i-1][0])+float(finalList[i-1][1]))<1000):
                      finalList[i].append(clust)
                  else:
                      clust=clust+1
                      finalList[i].append(clust)
          else:
              finalList[i].append(clust)
  
  #-----------------------------------------------------------------------------------------------------
  #----------------------write to text file for asr computation----------------------------------------- 
  mon=0
  fTrans=open("transcription.bat","w")
  for i in range(len(finalList)):
			startS=str(float(finalList[i][0])/100)
			endD=str(float(finalList[i][1])/100)
			fTrans.write("sox output.wav "+str(mon)+'.flac trim '+startS+' '+endD+'\n')
			mon=mon+1
  fTrans.write('\n')
  mon=0
  for i in range(len(finalList)):
          fTrans.write("python speechR.py "+str(mon)+".flac en "+finalList[i][0]+' '+finalList[i][1]+' '+a+'\n')
          mon=mon+1
  fTrans.close()
  fOut=open("output.txt","w")
  for i in range(len(finalList)):
	c=str(int(float(finalList[i][0])*10)).zfill(6)
	d=str(int(float(finalList[i][1])*10)).zfill(6)
	fOut.write(c+'~'+d+'~'+str(finalList[i][4])+'~'+finalList[i][3]+'~'+finalList[i][2]+"\n")
  fOut.close()
  #-----------------------------------------------------------------------------------------------------------
#cluster("nbc.seg")