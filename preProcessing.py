def preprocess(transcript):
#--------------------------------------------Topic speechline finalization------------------------------------------------
	outputFile=open('output.txt','r').readlines()
	speechline=[]
	for i in range(len(outputFile)):
		outputFile[i]=outputFile[i].replace("\n","")
		speechline.append(outputFile[i].split('~'))
		speechline[i].append(transcript[i][2])
#----------------------------------------------Count how many stories we have-------------------------------------------
	countcluster=int(speechline[0][2])
	con=1
	for i in range(len(speechline)):
		if(countcluster!=int(speechline[i][2])):
			countcluster=int(speechline[i][2])
			con=con+1
#---------------------------------------------------------------------------------------------------------------
	storyWords=[[] for _ in range(con)]
	newStory=[[] for _ in range(con)]

	temp=speechline[0][2].strip()
	counter=0
	j=0
	num=0
	initial=0
#-----------------------------------------Retrieve total newStory of stories------------------------------------
	for i in range(len(speechline)):
		while(counter==0):
			if (speechline[i][2].strip()==temp):
				replace=speechline[i][5].replace("\n","").strip()
				storyWords[j].append(replace)
				counter=1
			else:
				newStory[num].append(speechline[initial][0].strip()) #get the start time of story
				newStory[num].append(int(speechline[i-1][1])+int(speechline[i-1][0])) #get the end time of story
				newStory[num].append(int(speechline[initial][2]))
				temp=speechline[i][2].strip()
				initial=i
				num=num+1
				j=j+1
				counter=0
		counter=0
	newStory[num].append(speechline[initial][0].strip()) #for the last story
	newStory[num].append(int(speechline[len(speechline)-1][0])+int(speechline[len(speechline)-1][1]))
	newStory[num].append(speechline[initial][2])
#----------------------------------------------------------------------------------------------------------------
#----------------------------------------Story less than 20sec, remove, possible of noise------------------------
	for i in reversed(range(len(newStory))):
		if((int(newStory[i][1])-int(newStory[i][0]))<15000):
			for j in reversed(range(len(speechline))):
				if(int(speechline[j][2])==int(newStory[i][2])):
					speechline.pop(j)
			newStory.pop(i)
			storyWords.pop(i)
	for i in reversed(range(len(speechline))): #do for first story, since cant compare
		if(int(speechline[i][2])==int(newStory[0][2])):
			print i
			speechline.pop(i)
#----------------------------------------------------------------------------------------------------------------
	
#-------------------------------------------------Removal of empty speech lines----------------------------------
	stamp=0
	for i in reversed(range(len(storyWords))):
		for j in reversed(range(len(storyWords[i]))):
			if(storyWords[i][j]==''):
				stamp=1
			else:
				stamp=0
				break
		if(stamp==1):
			for k in reversed(range(len(speechline))):
				if(int(speechline[k][2])==int(newStory[i][2])):
					speechline.pop(k)
			newStory.pop(i)
			storyWords.pop(i)
	newStory.pop(0)
	storyWords.pop(0)
	for i in range(len(newStory)):
		newStory[i].pop(2)
		print newStory[i]
		
	newList=[]
	newList.append(speechline)
	newList.append(storyWords)
	newList.append(newStory)
	return newList	