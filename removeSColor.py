from duplicate import *
from collections import Counter
from story import *
import os
import math
def removeCo(newphoto,a):
    checkimgcolor=[]
    newpath=a+'image'
    for i in range(len(newphoto)):
        img=newpath+'/'+str(i+1)+".jpeg"
        im1 = Image.open(img).resize((8,8)).convert("L")
        im1_data = list(im1.getdata())
        counts=Counter(im1_data)
        common=counts.most_common()
        if(common[0][1]>=32 and len(common) <=2):
            checkimgcolor.append(img)
    if(len(checkimgcolor)!=0):
        for i in range(len(checkimgcolor)):
            imgsplit=checkimgcolor[i][:-5].split("/")
            imgsplit=int(imgsplit[1])
            newphoto.pop(imgsplit-1)
            os.remove(checkimgcolor[i])
            for j in range(imgsplit,len(newphoto)+1):
                splitedimg=j+1
                splitedimg=newpath+'/'+str(j+1)+".jpeg"
                newimg=newpath+'/'+str(j)+".jpeg"
                checkimgcolor=[newimg if x==splitedimg else x for x in checkimgcolor]
                os.rename(splitedimg,newimg)