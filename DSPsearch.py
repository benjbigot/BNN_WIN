import nltk
from nltk import *
def DSPsearch(transcript):
		tokenforsearch=[[] for _ in range(len(transcript))]
		tokenized=[]
		for i in range(len(transcript)):
			tokenized=nltk.word_tokenize(transcript[i][2])
			tokenforsearch[i].append(transcript[i][0])
			tokenforsearch[i].append(transcript[i][1])     
			for z in range(len(tokenized)):
						 tokenforsearch[i].append(tokenized[z])		
		return tokenforsearch