<?php
include 'opendb.php'; 
$filter=$_GET['id'];
if($filter==1)
{
		echo '<table align="right" width="100"><tr><td><div class="scroll">';
			$query='select * from newsvideo';
			$result=mysql_query($query) or die (mysql_error());
			if(mysql_num_rows($result)!=0)
			{
				while($rec=mysql_fetch_assoc($result))
				{
					$newsName=$rec['newsName'];
					$newsID=$rec['newsID'];
					$str=$newsID.','.$newsName;
					echo'<h2><a href="#" onclick="indinews(\''.$str.'\');">'.$newsName.'</a></h2>';
					echo'<div class="scroll3">';
					echo'<table><tr><td><div class="scroll2">';
					echo'<table><tr>';
					$qu='select * from newsvideo n, videotimestamp v where n.newsID=v.videoID and newsID="'.$newsID.'"';
					$re=mysql_query($qu) or die (mysql_error());
					while($rr=mysql_fetch_assoc($re))
					{
						$thumbnail=$rr['thumbnail'];
						echo'<td><a href="#" onclick="indinews(\''.$str.'\');"><img src="'.$thumbnail.'.jpeg"></a></td>';
					}
					echo'</tr></table>';
					echo'</div></td></tr></table>';
					echo'</div>';
					
					
				}
			}
		echo'</div></td></tr></table>';
}
else
{
	echo '<table align="right" width="100"><tr><td><div class="scroll">';
	$query='select * from videotimestamp v,newsvideo n where newsID="'.$filter.'" and v.videoID=n.newsID';
	$result=mysql_query($query) or die (mysql_error());
			$result2=mysql_query($query) or die (mysql_error());

			if(mysql_num_rows($result)!=0)
			{	
				$record=mysql_fetch_assoc($result);
				$mainT=$record['newsName'];
				echo'<table class="TFtable">';
				while($rec=mysql_fetch_assoc($result2))
				{
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
					$videoName=$rec['newsName'];
					$newsID=$rec['newsID'];
					$mainTopic=$rec['mainTopic'];
					$duration=intval(($end-$start)/60000);
					$id=2;
					$str=$id.','.$start.'~'.$end.'~'.$newsID;
					if($duration==0)
						$duration='< 1';
					echo'<tr><td valign="top"><img src="'.$thumbnail.'.jpeg" border=1><br>News Story: <a class="inline" onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$seek.');" href="#container"><img src="movieicon.jpg" border=1></td>
					<td id="middle" valign="top"><h3>'.$subTopic.'</h3>'.$summ.'</td><td id="least" valign="top">News: '.$videoName.'<br>Category: '.$mainTopic.'<br>Estimated Duration: '.$duration.' minutes<br>Full story: <a id="story" href="#" onclick="singlenews(\''.$str.'\');">link</a>';
				}
				echo'</td></tr></table>';
			}


		echo'</div></td></tr></table>';
}
?>