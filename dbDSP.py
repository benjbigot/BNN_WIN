import time
import MySQLdb
from datetime import timedelta

def dbDSP(news_Name,dsptoken,singleTerm,singleTerm2):
	db = MySQLdb.connect("127.0.0.1","root","","dsp" )
	cursor=db.cursor()
	sql="INSERT INTO lectvideo(videoName,videofile) \
			VALUES('%s','%s')"
	try:
		cursor.execute(sql %(news_Name,news_Name+".mp4"))
		db.commit()
	except:
		db.rollback()
		
	sql="SELECT videoID from lectvideo where videoName='%s'" %(news_Name)
	try:
		cursor.execute(sql)
		results=cursor.fetchone()
		videoID=int(results[0])
	except:
		print "Error: Unable to fetch data"
	
	  
	for i in range(len(dsptoken)):
		started=int(dsptoken[i][0])
		ended=int(dsptoken[i][1])+started
		times=timedelta(milliseconds=int(dsptoken[i][0]))
		times=str(times).rstrip("0")
		startTime=times.zfill(11)
		times=timedelta(milliseconds=int(ended))
		times=str(times).rstrip("0")
		endTime=times.zfill(11)
		seek=int(dsptoken[i][0])/1000
		for j in range(2,len(dsptoken[i])):
			sql="INSERT INTO transcription(startTime,endTime,seek,keyword,videoID) \
				VALUES('%s','%s','%d','%s','%d')" 
			try:        
				cursor.execute(sql %  (startTime,endTime,seek,dsptoken[i][j],videoID))
				db.commit()
			except:
				db.rollback()

	for i in range(len(singleTerm)):
		term=singleTerm[i][4].replace("'","\\'")
		sql="INSERT INTO singleterm(startTime,endTime,term,type,videoID) \
			VALUES('%d','%d','%s','%s','%d')" 
      
		cursor.execute(sql %  (singleTerm[i][2],singleTerm[i][3],term,'manuel',videoID))
		db.commit()

	for i in range(len(singleTerm2)):
		term=singleTerm2[i][4].replace("'","\\'")
		sql="INSERT INTO singleterm(startTime,endTime,term,type,videoID) \
			VALUES('%d','%d','%s','%s','%d')" 
      
		cursor.execute(sql %  (singleTerm2[i][2],singleTerm2[i][3],term,'kaldi',videoID))
		db.commit()

			
	db.close()