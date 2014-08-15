import nltk
from nltk.tokenize import sent_tokenize
from nltk.tokenize import word_tokenize
from nltk.probability import FreqDist 
from nltk.corpus import stopwords

def summarize(input, num_sentences ):
                s=[]
                punt_list=['.',',','!','?']
                summ_sentences = []
                sentences=input
                #sentences = sent_tokenize(input)
                lowercase_sentences =[sentence.lower() 
                        for sentence in sentences]
                #print lowercase_sentences
                saito=' '.join(sentences)
                s=input
                ts=''.join([ o for o in s if not o in  punt_list ]).split()
                lowercase_words=[word.lower() for word in ts]
                words = [word for word in lowercase_words if word not in stopwords.words()]
                word_frequencies = FreqDist(words)
                
                most_frequent_words = [pair[0] for pair in 
                        word_frequencies.items()[:100]]

                # add sentences with the most frequent words
                if(len(s) < num_sentences):
                    num_sentences=len(s)
                for word in most_frequent_words:
                        for i in range(len(lowercase_sentences)):
                            if len(summ_sentences) < num_sentences:
                                        if (lowercase_sentences[i] not in summ_sentences and word in lowercase_sentences[i]):
                                                summ_sentences.append(lowercase_sentences[i])
                            else:
								break
                        if len(summ_sentences) >= num_sentences:
                             break  
                        
                # reorder the selected sentences
                summ_sentences.sort( lambda s1, s2: saito.find(s1) - saito.find(s2) )
                return '~'.join(summ_sentences)

