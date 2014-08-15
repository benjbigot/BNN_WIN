import nltk
import re
import time
import MySQLdb
from nltk import *
from nltk.collocations import *
from nltk.stem.wordnet import WordNetLemmatizer
from datetime import timedelta
from summary import *
from itertools import groupby
from operator import itemgetter
from collections import Counter
from nltk.corpus import conll2000
from spellCheck import *
from tokenization import *
from TopicClassification import *
from searchToken import *
from keyframe import *
from headlines import *
from preProcessing import *
from dbaccessBNN import *
from DSPsearch import *
from dbDSP import *
from termp import *
import math

def textProcessing(name,num):
    #--------------------------------Transcription-------------------------------------------------
    transcription=open(name+'transcription.txt','r').readlines()
    transcript=[i.split('~') for i in transcription]
	#---------------------------------preProcessing------------------------------------------------
    if(num=="1"):
		newList=preprocess(transcript)
		speechline=newList[0] #individual lines with speaker speech, timestamp of speech
		storyWords=newList[1]  #extraction only just the speech for each lines, easier to manipulate
		newStory=newList[2]   #the story boundary containing mutiple speechlines
		wordlist=[" ".join(i) for i in storyWords] #a complete story for each newstory
	#-------------------------tokenization and extraction of noun terms-----------------------------
		tokenized=tokens(wordlist)
	#--------------------------------------Search---------------------------------------------------
		searchlist=search(speechline,newStory)
	#--------------------------------Summarization--------------------------------------------------
		summarized=[summarize(i,4) for i in storyWords]
	#------------------------------------Headlines--------------------------------------------------
		headL=headlines(tokenized)
	#---------------------------------main-topic detection------------------------------------------
		topicClassification=topicClass(tokenized)
	#--------------------------extraction of keyframe from each news story--------------------------
		keyFrame(newStory)
		thumbnail(name)
	#----------------------------------Insert into Database-----------------------------------------
		dbBNN(name,newStory,summarized,wordlist,topicClassification,headL,searchlist)
    else:
		singleTerm=termP(name+"M")
		singleTerm2=termP(name+"C")
		dsptoken=DSPsearch(transcript)
		thumbnail(name)
		dbDSP(name,dsptoken,singleTerm,singleTerm2)
