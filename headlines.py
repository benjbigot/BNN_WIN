import nltk
from nltk.stem.wordnet import WordNetLemmatizer
from nltk import *
from collections import Counter
def headlines(tokenized):
   temporarywords=[]
   tempsentencelist=[]
   sentencelist=[[]  for _ in range(len(tokenized))]
   tokenlist=[[]  for _ in range(len(tokenized))]
   for i in range (len(tokenized)):
		tagged=nltk.pos_tag(tokenized[i])
		tokenlist[i]=[z[0] for z in tagged if z[1]=="NNP" or z[1]=="NN"]
   for i in range (len(tokenized)):
        tagged= nltk.pos_tag(tokenized[i])
        grammer="""NP:       {<DT|PP\$>?<JJ>+<NN|NNP>+}
                                {<DT|PP\$>?<JJ>+<NNP|NN>+}
                                {<DT|PP\$><NNP|NN>+}
                                {<NNP>?<NN>+<NNP>+}
                                {<NN>?<NNP>+<NN>+}
                                """
        cp=nltk.RegexpParser(grammer)
        result=cp.parse(tagged)
        for subtree in result.subtrees(filter=lambda t: t.node=='NP'):
                    tempsentencelist=subtree.leaves()
                    for j in range(len(tempsentencelist)):
                        temporarywords.append(tempsentencelist[j][0])
                    temporarystringwords=" ".join(temporarywords)
                    sentencelist[i].append(temporarystringwords.lower())
                    temporarywords=[]
            
   toplist=[]
   newList=[]
   for i in range(len(tokenlist)):
               fdist=FreqDist(tokenlist[i])
               toplist=fdist.keys()
               x=0
               subTlist=[]
               capList=[]
               tapList=[]
               commonList=[]
               while(x!=len(toplist)-1):
                   if(x==3):
                       break
                   subTlist.append(toplist[x])
                   x=x+1
               for g in range(len(subTlist)):
                 for k in range(len(sentencelist[i])):
                     if(bool(subTlist[g] in sentencelist[i][k])==True):
                         capList.append(sentencelist[i][k])
               if(len(capList)!=0):
                   common=Counter(capList).most_common()
                   for d in range(len(common)):
                       tapList.append(common[d][1])
                   for u in range(len(tapList)):
                       if(common[u][1]==max(tapList)):
                           commonList.append(common[u][0])
                   newList.append(max(commonList,key=len))
               else:
                newList.append(toplist[0])   
   return newList
    