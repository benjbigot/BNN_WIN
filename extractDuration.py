from duplicate import *
from collections import Counter
import os
import subprocess
import math
def extractDuration(newphoto,a):
    newcsv=open("ncc.csv","w")
    newpath=a+'image'
    for i in range(len(newphoto)):
        newcsv.write(newphoto[i])
    newcsv.close()
    subprocess.call('EDLGenerator.exe ncc.csv 30 nbc.mp4 ncc.edl',shell=True)
    openedl=open("ncc.edl","r")
    readedl=openedl.readlines()
    edllist=[]
    imgDurationList=[]
    for i in range(len(readedl)):
        if(bool('B  C' in readedl[i])==True):
            edllist.append(readedl[i])
    edllist.pop(0)
    for i in range(len(edllist)):
        imgDurationList.append(edllist[i].split(" "))
    splitnode=[]
    imgDurationFiltered=[[] for _ in range(len(imgDurationList))]
    point=1
    for i in range(len(imgDurationList)):
        tim=imgDurationList[i][19]
        splitnode=tim.split(":")
        free=splitnode[0]+splitnode[1]+splitnode[2]+splitnode[3]
        coco=(int(splitnode[0])*60*60)+(int(splitnode[1])*60)+int(splitnode[2])
        imgDurationList[i].append(coco)
        imreplace=newpath+'/'+str(point)+'.jpeg'
        freereplace=newpath+'/'+free+'.jpeg'
        imgDurationList[i].append(freereplace)
        imgDurationFiltered[i].append(freereplace)
        imgDurationFiltered[i].append(coco)
        os.rename(imreplace,freereplace)
        point=point+1 
    for i in range(len(imgDurationFiltered)):
        imgHalf=imgDurationFiltered[i][0].replace(".jpeg","")
        imgHalf=imgHalf+"Half.jpeg"
        im = Image.open(imgDurationFiltered[i][0])
        box=(0,0,90,82)
        cropImage=im.crop(box)
        cropImage.save(imgHalf,"JPEG")
        imgDurationFiltered[i].append(imgHalf)

    solo=open('imgDurationFiltered.txt','w')
    for j in range(len( imgDurationFiltered)):
        starttime=str( imgDurationFiltered[j][0])
        duration=str( imgDurationFiltered[j][1])
        solo.write(starttime+','+duration+','+imgDurationList[j][19]+','+imgDurationList[j][20]+','+imgDurationFiltered[j][2]+'\n')
    solo.close() 