<?php
session_start();
include 'opendbDSP.php'; 
	$myFile=$_GET['id'];
	$query='select * from transcription t,lectvideo n where t.videoID=n.videoID and videoName="'.$myFile.'"';
	$query2='select max(seek) as maxseek from transcription t,lectvideo n where t.videoID=n.videoID and videoName="'.$myFile.'"';
	$result=mysql_query($query) or die (mysql_error());
	$result2=mysql_query($query2) or die (mysql_error());
	$bArray=array();
	$cArray=array();
	if(mysql_num_rows($result)!=0)
	{
		$record=mysql_fetch_assoc($result);
		$record2=mysql_fetch_assoc($result2);
		$videoID=$record['videoID'];
		$seek=$record2['maxseek'];
		$average=$seek/10;
		$total=$average*10;
		$leftover=0;
		if($seek-$total>0)
		{
			$leftover=$seek-$total;
			$average++;
		}
		$seekvalue=0;
		for($i=0; $i<$average; $i++)
		{
			$bArray[]=$seekvalue;
			if($i!=$average-1) //you need for left over time
				$seekvalue=$seekvalue+10;
			else
				$seekvalue=$seekvalue+$leftover;
				
		}

	}
	
	$cArray=array("one"=>$videoID,"two"=>$bArray);
	echo json_encode($cArray);

	


?>