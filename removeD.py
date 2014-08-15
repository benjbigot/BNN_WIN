from duplicate import *
from collections import Counter
import os
import math
def removeD(a):
    oldpath='C://xampp/htdocs/bnn'
    os.chdir(oldpath)
    newpath=a+'image'
    opencsv=open("nbcc.csv","r")
    mon=opencsv.readlines()
    newphoto=[]
    imgWithCrop=[[]]
    photolist=len(mon)
    point=1
    tute=0
    tempimage=''
    for i in range(1,photolist):
      if(i!=len(mon)-1):
        ec=str(i+1)
        dc=ec.zfill(2)
        img=newpath+'/'+dc+'.jpeg'
        ec=str(i+2)
        dc=ec.zfill(2)
        img2=newpath+'/'+dc+'.jpeg'
        hash1=avhash(img)
        hash2=avhash(img2)
        dist = hamming(hash1, hash2)
        percent=(64 - dist) * 100 / 64
        if(percent>75):
            if(img!=tempimage):
                if (tute==0):
                    newphoto.append(mon[i])
                    imreplace=newpath+'/'+str(point)+'.jpeg'
                    os.rename(img,imreplace)
                    point=point+1
                    tempimage=img2
                    tute=1
                else:
                    os.remove(img)
            else:
                tempimage=img2
                os.remove(img)
        else:
            if(img!=tempimage):
                newphoto.append(mon[i])
                imreplace=newpath+'/'+str(point)+'.jpeg'
                os.rename(img,imreplace)
                point=point+1
                tute=0 
            else:
                os.remove(img)
                tute=0
      else:
            img=newpath+'/'+str(photolist)+'.jpeg'
            newphoto.append(mon[i])
            imreplace=newpath+'/'+str(point)+'.jpeg'
            os.rename(img,imreplace)
    return newphoto