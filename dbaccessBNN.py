import time
import MySQLdb
from datetime import timedelta

def dbBNN(news_Name,newStory,summarized,wordlist,topicClassification,headL,searchlist):
	db = MySQLdb.connect("127.0.0.1","root","","broadcastnews" )
	cursor=db.cursor()
	sql="INSERT INTO newsvideo(newsName,newsVideoFile) \
			VALUES('%s','%s')"
	try:
		cursor.execute(sql %(news_Name,news_Name+".mp4"))
		db.commit()
	except:
		db.rollback()
		
	sql="SELECT newsID from newsVideo where newsName='%s'" %(news_Name)
	try:
		cursor.execute(sql)
		results=cursor.fetchone()
		newsID=int(results[0])
	except:
		print "Error: Unable to fetch data"
	
		
	for i in range(len(newStory)):
		times=timedelta(milliseconds=int(newStory[i][0]))
		times=str(times).rstrip("0")
		startTime=times.zfill(11)
		times=timedelta(milliseconds=int(newStory[i][1]))
		times=str(times).rstrip("0")
		endTime=times.zfill(11)
		image=str(newStory[i][2]).zfill(8)
		image=news_Name+'image/'+image
		fullstory=wordlist[i].replace("'","\\'")
		start=int(newStory[i][0])
		end=int(newStory[i][1])
		seek=int(newStory[i][0])/1000
		text=headL[i].replace("'","\\'")
		summary=summarized[i].replace("'","\\'")
		sql="INSERT INTO videotimestamp(startTime,EndTime,start,end,seek,summary,fullstory,thumbnail,mainTopic,subTopic,videoID) \
				VALUES('%s','%s','%d','%d','%d','%s','%s','%s','%s','%s','%d')" 
				
		try: 
			cursor.execute(sql % (startTime,endTime,start,end,seek,summary,fullstory,image,topicClassification[i],text,newsID))
			db.commit()
		except:
				db.rollback()
	  
	for i in range(len(searchlist)):
		started=int(searchlist[i][0])
		ended=int(searchlist[i][1])+started
		times=timedelta(milliseconds=int(searchlist[i][0]))
		times=str(times).rstrip("0")
		startTime=times.zfill(11)
		times=timedelta(milliseconds=int(ended))
		times=str(times).rstrip("0")
		endTime=times.zfill(11)
		start=int(searchlist[i][0])
		end=int(searchlist[i][1])+int(searchlist[i][0])
		seek=int(searchlist[i][0])/1000
		clusterstart=int(searchlist[i][3])
		clusterend=int(searchlist[i][4])
		for j in range(5,len(searchlist[i])):
			sql="INSERT INTO search(startTime,endTime,start,end,seek,keyword,clusterStart,clusterEnd,videoID) \
				VALUES('%s','%s','%d','%d','%d','%s','%d','%d','%d')" 
			try:        
				cursor.execute(sql %  (startTime,endTime,start,end,seek,searchlist[i][j],clusterstart,clusterend,newsID))
				db.commit()
			except:
				db.rollback()
			
	db.close()