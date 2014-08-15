from duplicate import *
from facedetection import *
from itertools import groupby
from collections import Counter
import os
import subprocess
import math
def story():
    readImgList=open('imgDurationFiltered.txt','r').readlines()

    for i in range(len(readImgList)):
        readImgList[i]=readImgList[i].replace("\n","")
	imgAndDurationList=[i.split(',') for i in readImgList]
    readasr=open('output.txt','r').readlines()
    boundary=[i.replace("\n","").split('~') for i in readasr]

    for i in range(len(boundary)):
        for j in range(len(boundary[i])):
            boundary[i][j]=boundary[i][j].strip()
    for i in reversed(range(len(boundary))):
        if(len(boundary[i])<5): #possible that boundary may contain empty lines, we need to remove them.
			pop(boundary[i])
    convertStartTime=0
    convertDuration=0
    trackcount=0

    index=0
    newIndexCluster=1
        
    while(index!=len(boundary)-1):   #if index of boundary not complete, it will not end
        for i in range(newIndexCluster+1,len(boundary)):
           print i
           if(boundary[i][3]==boundary[i][4]):
               if(trackcount==0):
                   convertStartTime=int(boundary[i][0])/1000
                   trackcount=1
                   currentIndexCluster=i
               if(i==len(boundary)-1):  #if the last index happen to be anchor, capture the duration and end
                   convertDuration=(int(boundary[i][0])+int(boundary[i][1]))/1000
           else:
               if(boundary[i-1][3]==boundary[i-1][4]): #if it is not the anchor
                   boundary[i][0]=boundary[i][0].strip()
                   boundary[i][1]=boundary[i][1].strip()
                   convertDuration=(int(boundary[i][0])+int(boundary[i][1]))/1000
                   trackcount=0
                   newIndexCluster=i
                   if(newIndexCluster==len(boundary)-1):
                       index=newIndexCluster
                   break
           index=i
        #----derive the shot time and duration based on the audio time and duration--------
        faceCropList=[[] for _ in range(1)]
        def binarySearchforDuration(a,b):
            if(convertDuration<int(b[a-1][1])):
               return binarySearchforDuration(a/2,b)
            else:
                return a*2
        def binarySearchforStartTime(a,b):
            if(convertStartTime>int(b[a][1])):
                if(a!=len(b)-1):
                    if(a*2+1>len(b)-1):
                        return binarySearchforStartTime(len(b)-1,b)
                    else:
                        return binarySearchforStartTime(a*2+1,b)
                else:
                    return a
            else:
                return a/2
        if(i==len(boundary)-1):
            imgEndDuration=len(imgAndDurationList)
        else:
            imgEndDuration=binarySearchforDuration(len(imgAndDurationList),imgAndDurationList) 
        imgStartDuration=binarySearchforStartTime(0,imgAndDurationList)
        sIndex=0      
		#-----------from each start and end of boundary, identify the anchor using popular face-----------------------------------------
        for j in range(imgStartDuration,imgEndDuration):
               imgTime=int(imgAndDurationList[j][1])
               if(imgTime>=convertStartTime-1 and imgTime<=convertDuration-1):
                   if(sIndex==len(faceCropList)):
                        faceCropList.append([])
                   faceCropList[sIndex].append(imgAndDurationList[j][0])
                   faceCropList[sIndex].append(imgAndDurationList[j][1])
                   faceCropList[sIndex].append(imgAndDurationList[j][4])
                   sIndex=sIndex+1
        if(len(faceCropList)>1):
            for k in range(len(faceCropList)):
               ttk=faceCrop(faceCropList[k][2],boxScale=1)
               faceCropList[k].append(str(ttk))
            imgWithCrop=[[]]
            for k in range(len(faceCropList)):
                if(faceCropList[k][3]!='None'): #possible no face
                    compareIm=Image.open(faceCropList[k][3])
                    (width, height) = compareIm.size
                    if(width >25 and height>25):
                        imgWithCrop.append(faceCropList[k])
            imgWithCrop.pop(0)
            imgComparisonList=[[] for _ in range(len(imgWithCrop))]
            if(len(imgWithCrop)>1):
                for k in range(len(imgWithCrop)):
                    for z in range(len(imgWithCrop)):
                           img=str(imgWithCrop[k][3])
                           img2=str(imgWithCrop[z][3])
                           hash1=avhash(img)
                           hash2=avhash(img2)
                           dist = hamming(hash1, hash2)
                           percent=(64 - dist) * 100 / 64
                           if(percent>78):
                               imgComparisonList[k].append(imgWithCrop[z])
                maxList=max(imgComparisonList,key=lambda tup: len(tup))
                checkdigit=0
                tocounter=0
                trackCLusterID=boundary[currentIndexCluster][2]
                comparelist=[]
                if(len(maxList)>1):
                    for y in range(len(maxList)):
                        comparelist.append(int(maxList[y][1])) 
		#---------------------------If there are changes in the comparelist, where there is a change of shot between the anchor speech, restructure the cluster-------------------------
                    for g in range(currentIndexCluster,newIndexCluster):
                                 start=int(boundary[g][0])/1000
                                 diff=[(abs(start-n),idx) for (idx,n) in enumerate(comparelist)]
                                 diff.sort()
                                 imgTimeStamp=int(maxList[int(diff[0][1])][1])
                                 if(checkdigit!=imgTimeStamp):
                                     tocounter=g
                                 boundary[g][2]=imgTimeStamp
                                 checkdigit=imgTimeStamp
                                 go=trackCLusterID
                                 if(g==newIndexCluster-1):
                                     for c in range(tocounter,g+1):
                                         boundary[c][2]=go
        #-------------------------------------------------------------------------------------------------------------------------------------------                     
    out=open('output.txt','w')
    for i in range(len(boundary)):
            for j in range(len(boundary[i])-1):
                boundary[i][j]=str(boundary[i][j])
                out.write(boundary[i][j]+'~')
            out.write(boundary[i][len(boundary[i])-1]+"\n")