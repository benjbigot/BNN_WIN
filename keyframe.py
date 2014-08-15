def keyFrame(duration):  
    imglist=open('imgDurationFiltered.txt','r').readlines()
    imagedict=[i.split(',') for i in imglist]

    for i in range(len(imagedict)):
        tempimg=imagedict[i][0][:-5].split("/")
        imagedict[i].append(tempimg[1])

    for u in range(len(duration)):
        tempB=1000000000
        a=int(duration[u][1])
        b=int(duration[u][0])
        kao=((a+b)/2)/1000
        for y in range(len(imagedict)):
            tempA=abs(kao-int(imagedict[y][1]))
            if (tempA<tempB):
                tempB=tempA
                tempC=int(imagedict[y][5])
        duration[u].append(tempC)


def thumbnail(news_Name):
    imglist=open('imgDurationFiltered.txt','r').readlines()
    imagedict=[i.split(',') for i in imglist]
    for i in range(len(imagedict)):
        tempimg=imagedict[i][0][:-5].split("/")
        imagedict[i].append(tempimg[1])
	tempimgduration=[]
    for i in range(len(imagedict)):
		tempimgduration=imagedict[i][2].split(":")
		tmping=tempimgduration[0]+":"+tempimgduration[1]+":"+tempimgduration[2]+"."+tempimgduration[3]
		imagedict[i][2]=tmping
		tempimgduration=imagedict[i][3].split(":")
		tmping=tempimgduration[0]+":"+tempimgduration[1]+":"+tempimgduration[2]+"."+tempimgduration[3]
		imagedict[i][3]=tmping
	
    thumbN=open(news_Name+"thumb.vtt","w")
    for y in range(len(imagedict)):
		thumbN.write(imagedict[y][2]+" --> "+imagedict[y][3]+"\n"+imagedict[y][0]+"\n\n")