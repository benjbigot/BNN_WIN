<?php
include 'opendb.php';
	$q=$_GET["id"];
	$type=explode('|',$q);
	$long=explode(' ',$type[0]);
	$total_records=0;

	if($type[1]=="keyword")
	{
		$query='SELECT distinct s.clusterStart,s.clusterEnd,thumbnail,summary,mainTopic,subTopic,newsName,v.seek  FROM search s,videotimestamp v, newsvideo n where s.clusterStart=v.start and s.clusterEnd=v.end and n.newsID=v.videoID and (';  
		for($i=0;$i<sizeof($long);$i++){
			if($i!=sizeof($long)-1)
				$query=$query.'keyword="'.$long[$i].'" or ';
			else
				$query=$query.'keyword="'.$long[$i].'" )';
		}
	}
	else
	{
		$query='SELECT *  FROM videotimestamp v, newsvideo n where (';  
		for($i=0;$i<sizeof($long);$i++){
			if($i!=sizeof($long)-1)
				$query=$query.'subTopic="%'.$long[$i].'%" or';
			else
				$query=$query.'subTopic="%'.$long[$i].'%" )';
		}
	}
	$result=mysql_query($query) or die (mysql_error());
	$row=mysql_num_rows($result);
	$total_records=$total_records+$row;
	
	echo $total_records;
?>