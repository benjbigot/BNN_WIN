<?php
include 'opendb.php'; 
$filter=explode("~",$_GET['id']);
$length=$filter[0];
if(sizeof($filter)>1){
	$long=explode(",",$filter[1]);
	$start_from=($length-1)*10;
	}
$topic=array("Entertainment","Business","Health","Politics and Governance","Culture and Religion","Education","Science and Technology","Military and Weapons","Sport","Geography and History");


if($filter[0]=='topic' or $filter[0]=='news')
{
	if($filter[0]=='topic')
	{
		
		for($i=0; $i<sizeof($topic); $i++)
		{
			$query='select * from videotimestamp v,newsvideo n where mainTopic="'.$topic[$i].'" and v.videoID=n.newsID';
			$result=mysql_query($query) or die (mysql_error());
			$result2=mysql_query($query) or die (mysql_error());

			if(mysql_num_rows($result)!=0)
			{	
				$record=mysql_fetch_assoc($result);
				$mainT=$record['mainTopic'];
				echo'<table border=1><tr><td><img src="'.$mainT.'.jpg"></td></tr><tr><td>';
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
					$subTopic=$rec['subTopic'];
					$videoName=$rec['newsName'];
					$newsID=$rec['newsID'];
					echo'<table border=1><tr><td>';
					echo'<a title="IN '.$startTime.' - OUT '.$endTime.'" onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$seek.');  dynamicVideo(\''.$videoName.'\');  videoTitle(\''.$videoName.'\');recent(\''.$newsID.'\'); passString(this); return false" href="#'.$start.'+'.$end.'"><img src="'.$thumbnail.'.jpeg"></a></td><td><h5><a title="IN '.$startTime.' - OUT '.$endTime.'" onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$seek.');  dynamicVideo(\''.$videoName.'\');  videoTitle(\''.$videoName.'\');recent(\''.$newsID.'\'); passString(this); return false" href="#'.$start.'+'.$end.'">'.$subTopic.'</a></h5></td></tr></table>';
					
				}
				echo'</td></tr></table>';
			}

		}
		echo'</div></td></tr></table>';
	}
	else if($filter[0]=='news')
	{
		$sql='select newsID from newsvideo';
		$que=mysql_query($sql) or die (mysql_error());
		if(mysql_num_rows($que)!=0)
		{
			$as=array();

			while($record=mysql_fetch_assoc($que))
			{
				$as[]=$record['newsID']; 

			}
		}
		for($i=0; $i<sizeof($as); $i++)
		{
			$query='select * from videotimestamp v,newsvideo n where newsID="'.$as[$i].'" and v.videoID=n.newsID';
			$result=mysql_query($query) or die (mysql_error());
			$result2=mysql_query($query) or die (mysql_error());

			if(mysql_num_rows($result)!=0)
			{	
				$record=mysql_fetch_assoc($result);
				$mainT=$record['newsName'];
				echo'<table><tr><td><h2>'.$mainT.'</h2></td></tr><tr><td>';
				while($rec=mysql_fetch_assoc($result2))
				{
					$startTime=$rec['startTime'];
					$endTime=$rec['EndTime'];
					$start=$rec['start'];
					$start=sprintf("%07d",$start);
					$end=$rec['end'];
					$end=sprintf("%07d",$end);
					$seek=$rec['seek'];
					$newsID=$rec['newsID'];
					$thumbnail=$rec['thumbnail'];
					$subTopic=$rec['subTopic'];
					$mainTopic=$rec['mainTopic'];
					$videoName=$rec['newsName'];
					echo'<table><tr><td>';
					echo'<a title="IN '.$startTime.' - OUT '.$endTime.'" onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$seek.');   dynamicVideo(\''.$videoName.'\'); videoTitle(\''.$videoName.'\');recent(\''.$newsID.'\'); passString(this); return false" href="#'.$start.'+'.$end.'"><img src="'.$thumbnail.'.jpeg"></a></td><td><h5 ><a title="IN '.$startTime.' - OUT '.$endTime.'" onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$seek.');   dynamicVideo(\''.$videoName.'\'); videoTitle(\''.$videoName.'\');recent(\''.$newsID.'\'); passString(this); return false" href="#'.$start.'+'.$end.'">'.$subTopic.'</a><br>('.$mainTopic.')</h5></td></tr></table>';
					
				}
				echo'</td></tr></table>';
			}

		}
		echo'</div></td></tr></table>';
	}
}
else if($filter[0]=='latest')
{
	$query='select newsID from newsvideo order by newsID DESC limit 1';
	$result=mysql_query($query) or die (mysql_error());
	$tracker=0;
	if(mysql_num_rows($result)!=0)
			{	
				$record=mysql_fetch_assoc($result);
				$last=$record['newsID'];
				$que='select * from videotimestamp v,newsvideo n where newsID="'.$last.'" and v.videoID=n.newsID';
				$res=mysql_query($que) or die (mysql_error());
				echo '<table align="right" width="100"><tr><td><div class="scroll">';
				echo'<table>';
				while($rec=mysql_fetch_assoc($res))
				{
					$startTime=$rec['startTime'];
					$endTime=$rec['EndTime'];
					$start=$rec['start'];
					$start=sprintf("%07d",$start);
					$end=$rec['end'];
					$end=sprintf("%07d",$end);
					$seek=$rec['seek'];
					$newsID=$rec['newsID'];
					$thumbnail=$rec['thumbnail'];
					$subT=$rec['subTopic'];
					$subTopic=ucfirst($subT);
					$mainTopic=$rec['mainTopic'];
					$videoName=$rec['newsName'];
					$id=1;
					$str=$id.','.$start.'~'.$end.'~'.$newsID;
					if($tracker==0)
					{
					echo'<tr><td>';
					echo'<a onclick="singlenews(\''.$str.'\');" href="#"><img src="'.$thumbnail.'.jpeg" border=1></a></td><td id="geo"><h5 ><a onclick="singlenews(\''.$str.'\');" href="#">'.$subTopic.'</a><br>('.$mainTopic.')<br><a class="inline"  onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$seek.');" href="#container"><img src="movieicon.jpg" border=1></a></h5></td>';
					$tracker=1;
					}
					else
					{
					echo'<td>';
					echo'<a  onclick="singlenews(\''.$str.'\');" href="#"><img src="'.$thumbnail.'.jpeg" border=1></a></td><td id="geo"><h5 ><a onclick="singlenews(\''.$str.'\');" href="#">'.$subTopic.'</a><br>('.$mainTopic.')<br><a class="inline"  onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$seek.');" href="#container"><img src="movieicon.jpg" border=1></a></h5></td></tr>';
					$tracker=1;
					$tracker=0;
					}
				}
				echo'</td></tr></table>';
				
				
				}
}
else
	{
	$query='select * from videotimestamp v,newsvideo n where (';

		for($i=0; $i<sizeof($long);$i++)
		{
			if($i==sizeof($long)-1)
				$query=$query.'mainTopic="'.$long[$i].'"';
			else
				$query=$query.'mainTopic="'.$long[$i].'" or ';
		
		}
	
	$query=$query.') and v.videoID=n.newsID order by mainTopic limit '.$start_from.',10';
	$result=mysql_query($query) or die (mysql_error());
	$result2=mysql_query($query) or die (mysql_error());
	$tracker=0;

	echo '<table align="right" width="100"><tr><td><div class="scroll">';
	if(mysql_num_rows($result)!=0)
			{

				$tempString='';
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
					$videoName=$rec['newsName'];
					$mainT=$rec['mainTopic'];
					$newsID=$rec['newsID'];
					$summary=$rec['summary'];
					$summ=ucfirst($summary);
					$duration=intval(($end-$start)/60000);
					$id=3;
					$str=$id.','.$start.'~'.$end.'~'.$newsID;
					if($duration==0)
						$duration='< 1';

					echo'<tr><td valign="top"><img src="'.$thumbnail.'.jpeg" border=1><br>News Story: <a class="inline" onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$seek.');" href="#container"><img src="movieicon.jpg" border=1></td>
					<td id="middle" valign="top"><h3>'.$subTopic.'</h3>'.$summ.'</td><td id="least" valign="top">News: '.$videoName.'<br>Category: '.$mainT.'<br>Estimated Duration: '.$duration.' minutes<br>Full story: <a id="story" href="#" onclick="singlenews(\''.$str.'\');">link</a>';
				}
				echo'</td></tr></table>';
			
		}
		else
		{
		echo'please enter a topic';
		}
	}
	
echo'</div></td></tr></table>';

?>
