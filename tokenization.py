from nltk.stem.wordnet import WordNetLemmatizer
from nltk import *
import nltk
def tokens(wordlist):	
	
		
	tokenized=[[]  for _ in range(len(wordlist))]
	lmtzr = WordNetLemmatizer()
	#------------------------------Tokenization--------------------------------
	for i in range (len(wordlist)):
		tokenized[i]=nltk.word_tokenize(wordlist[i])
		for j in reversed(range(len(tokenized[i]))):
			lowercase=tokenized[i][j].lower()
			#correctedword=correct(lowercase)
			#if(correctedword!=""):
			tokenized[i][j]=lmtzr.lemmatize(lowercase)
			if(len(tokenized[i][j])<3):
				tokenized[i].pop(j)
			elif(any(c in tokenized[i][j] for c in "'$&.")):
				tokenized[i].pop(j)
	return tokenized