<?php
include 'opendb.php'; 
$filter=$_GET['id'];
$id=explode(',',$filter);
$ident=$id[0];
$long=explode('~',$id[1]);
$start=$long[0];
$end=$long[1];
$newsID=$long[2];
$query='select * from videotimestamp v,newsvideo n where newsID="'.$newsID.'" and v.videoID=n.newsID and v.start="'.$start.'" and v.end="'.$end.'"';
$result=mysql_query($query) or die (mysql_error());
$rec=mysql_fetch_assoc($result);
$startTime=$rec['startTime'];
$endTime=$rec['EndTime'];
$start=$rec['start'];
$start=sprintf("%07d",$start);
$end=$rec['end'];
$end=sprintf("%07d",$end);
$seek=$rec['seek'];
$thumbnail=$rec['thumbnail'];
$subT=$rec['subTopic'];
$subTopic=ucfirst($subT);
$mainT=$rec['mainTopic'];
$summary=$rec['summary'];
$summ=ucfirst($summary);
$mainTopic=ucfirst($mainT);
$newsName=$rec['newsName'];
$videoName=$rec['newsName'];
$newsID=$rec['newsID'];
$mainTopic=$rec['mainTopic'];
$full=$rec['fullstory'];
$fullstory=ucfirst($full);
$duration=intval(($end-$start)/60000);
if($duration==0)
	$duration='< 1';
$str=$newsID.','.$newsName;
if($ident==2)
echo'<div id=single><a href="#" onclick="news();">News</a>< <a href="#" onclick="indinews(\''.$str.'\');">'.$newsName.'</a>< '.$subTopic.'</div><hr /><div id=page><br></div><div id=fill>';
else if($ident==1)
echo'<div id=latest><a href="#" onclick="filter(\'latest\');">Latest News</a>< '.$subTopic.'</div><hr /><div id=page><br></div><div id=fill>';
else if($ident==3)
echo'<div id=topiclist><a href="#" onclick="thirdbar();">Topic</a>< '.$subTopic.'</div><hr /><div id=page><br></div><div id=fill>';
echo '<table align="right" width="100"><tr><td><div class="scroll">';
echo'<table class="TFtable">';
echo'<tr><td valign="top"><img src="'.$thumbnail.'.jpeg" border=1><br>News Story video: <a class="inline" onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$seek.');" href="#container"><img src="movieicon.jpg" border=1></a>
<br>News: '.$videoName.'<br>Category: '.$mainTopic.'</td><td valign="top">Estimated Duration: '.$duration.' minutes<br>Full story: '.$fullstory.'</td></tr></table>
</td></tr></table></div>';
?>