import nltk
from nltk.stem.wordnet import WordNetLemmatizer
from nltk import *
from collections import Counter
import math
def topicClass(tokenized):
	
    def inverseDoc(value):
        alp=ord(value[0])-65
        tempscore=0
        for g in range(len(dictList)):
            for a in range(len(dictList[g][alp])):
                if(value==dictList[g][alp][a]):
                    tempscore=tempscore+1
                    break
        actualscore=(10-tempscore)+1
        logscore=math.log10(actualscore)
        return logscore    

    def openTopicList(textfile,dictList):
        value='ABCDEFGHIJKLMNOPQRSTUVWXYZ'
        alpabet=list(value)
        topi=open(textfile,"r").readlines()
        tot=[i.replace("\n","").replace("\t","") for i in topi]
        tot.sort()
        for j in range(len(alpabet)):
            dictList[j]=[i for i in tot if i[0]==alpabet[j]]
    

    dictList=[ [[] for _ in range(26)] for _ in range(10)]    
    tokenlist=[[]  for _ in range(len(tokenized))]
    mainTList=[[] for _ in range (len(tokenized))]
    upperTokenList=[[] for _ in range (len(tokenized))]
    newList=[]
	
    for i in range (len(tokenized)):
		tagged=nltk.pos_tag(tokenized[i])
		tokenlist[i]=[z[0] for z in tagged if z[1]=="NNP" or z[1]=="NN"]
     
    topiclist=['Business','Culture and Religion','Education','Entertainment','History and Geography','Health','Military and Weapons','Politics and Governance','Science and Technology','Sport']
    openTopicList("Business.txt",dictList[0])
    openTopicList("Culture and Religion.txt",dictList[1])
    openTopicList("Education.txt",dictList[2])
    openTopicList("Entertainment.txt",dictList[3])
    openTopicList("Geography and History.txt",dictList[4])
    openTopicList("Health.txt",dictList[5])
    openTopicList("Military and Weapons.txt",dictList[6])
    openTopicList("Politics and Governance.txt",dictList[7])
    openTopicList("Science and Technology.txt",dictList[8])
    openTopicList("Sport.txt",dictList[9])

    for i in range(len(tokenlist)):
        for j in range(len(tokenlist[i])):
            upperTokenList[i].append(tokenlist[i][j].upper())
    for i in range(len(upperTokenList)):

        counts=Counter(upperTokenList[i])
        common=list(counts.most_common())
        for k in range(len(dictList)):
            listScore=0
            for j in range(len(common)):
                alpa=common[j][0][0]
                val=ord(alpa)-65
                for d in range(len(dictList[k][val])):
                    if(common[j][0]==dictList[k][val][d]):
                        termFreq=1+math.log10(common[j][1])
                        lgscore=inverseDoc(common[j][0])
                        listScore=listScore+termFreq+lgscore
                        break
            mainTList[i].append(listScore)
    for i in range(len(mainTList)):
        newList.append(topiclist[mainTList[i].index(max(mainTList[i]))])
    return newList