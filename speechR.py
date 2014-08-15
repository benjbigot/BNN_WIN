import sys
import urllib2
import urllib
import json
import time

def speechR(a,b,c,d,e):
    output=open(e+"transcription.txt","a")
    Recording=a
    url='https://www.google.com/speech-api/v2/recognize?lang=en-us&key=AIzaSyBOti4mM-6x9WDnZIjIeyEU21OpBXqWBgw'
    flac=open(Recording,"rb").read()
    header={'Content-Type':'audio/x-flac; rate=16000'}
    dat='string,'
    counter=0
    req = urllib2.Request(url,flac,header)
    while True:
        try:           
            data=urllib2.urlopen(req)
            dat=data.read()
            break
        except urllib2.HTTPError, detail:
            if (detail.errno==500):
                time.sleep(1)
                if(counter>5):
                   break
                else:
                   counter=counter+1
                   continue
            elif(detail.errno==10054):
                 break
            else:
                 raise

    c=str(int(float(c)*10)).zfill(6)+"~"
    d=str(int((float(d)*10))).zfill(6)+"~"
    dat=dat.split(",")
    text=dat[0].split('"transcript":')
    if(len(text)>1):
       answer=text[1]
       answer=answer.replace('"','')
       answer=answer.replace("}",'')
    else:
       answer=""
    print c+" "+d+" "+answer
    output.write(c+d+answer+"\n")
if __name__ == "__main__":
    if len(sys.argv) != 6 or "--help" in sys.argv:
        print "not available"
        sys.exit(-1)
    else:
        speechR(sys.argv[1],sys.argv[2],sys.argv[3],sys.argv[4],sys.argv[5])