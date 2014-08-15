from nltk.stem.wordnet import WordNetLemmatizer
from nltk import *
import nltk
from spellCheck import *
def search(boundary,newsStory):
	countChangeNewC=0
	countChangeNewP=-1
	searchlist=[[] for _ in range(len(boundary))]
	for i in range(len(boundary)):
		searchlist[i].append(boundary[i][0])
		searchlist[i].append(boundary[i][1])
		searchlist[i].append(boundary[i][2])
		if(countChangeNewC!=boundary[i][2]):
			countChangeNewP=countChangeNewP+1
		searchlist[i].append(newsStory[countChangeNewP][0])
		searchlist[i].append(newsStory[countChangeNewP][1])
		boundary[i][5]=boundary[i][5].replace("\n","")
		tokenized=nltk.word_tokenize(boundary[i][5])
		tagged=nltk.pos_tag(tokenized)
		for z in range(len(tagged)):
				 lowercase=tagged[z][0].lower()
				 if(tagged[z][1]=="NNP" or tagged[z][1]=="NN"):  
					 searchlist[i].append(tagged[z][0])
		countChangeNewC=boundary[i][2]
	return searchlist