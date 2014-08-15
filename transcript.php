<?php
include 'opendbDSP.php';
	$q=$_GET["req"];
	$long=explode('~',$q);
	$aArray=array();
	$trans='';
		$query='SELECT distinct type FROM singleterm where videoID='.$long[0];	
		$result=mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($result)!=0)
		{	
			while($record=mysql_fetch_assoc($result))
			{
				$type=$record['type'];
			    $aArray[]=$type;
			}
		}
		echo '<table border=1>';
		for ($i=0; $i<sizeof($aArray); $i++)
		{
			$termString='';
			echo '<tr><td><font color="red">speech ASR:</font> '.$aArray[$i].'</td></tr>';
			$query='SELECT * FROM singleterm where videoID='.$long[0].' and type="'.$aArray[$i].'" and startTime>'.$long[2].' and endTime<='.$long[3];
			$result=mysql_query($query) or die (mysql_error());
			if(mysql_num_rows($result)!=0)
			{	
				while($record=mysql_fetch_assoc($result))
				{
					$start=$record['startTime'];
					$end=$record['endTime'];
					$term=$record['term'];
					$termString=$termString.' '.$term;
				}
			echo '<tr><td><font color="red">Text:</font>'.$termString.'</td><td><font color="red">Start Time:</font>'.$long[2].' seconds</td><td><font color="red">End Time:</font>'.$long[3].' seconds</td></tr>';
			}
		}
		echo '</table>';
		
?>