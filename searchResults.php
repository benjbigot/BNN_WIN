<?php
include 'opendb.php';
	$q=$_GET["id"];
	$short=explode(',',$q);
	$type=explode('|',$short[1]);
	$long=explode(' ',$type[0]);
	$tempkey='';
	$start_from=($short[0]-1)*5;
	echo '<table align="right" width="100"><tr><td><div class="scroll">';
		if($type[1]=="keyword")
		{
			$query='SELECT distinct v.start,v.end,thumbnail,summary,mainTopic,subTopic,newsName, newsID,v.seek FROM search s,videotimestamp v, newsvideo n where s.clusterStart=v.start and s.clusterEnd=v.end and n.newsID=v.videoID and  (';
			for($i=0;$i<sizeof($long);$i++){
			if($i!=sizeof($long)-1)
				$query=$query.'keyword="'.$long[$i].'" or ';
			else
				$query=$query.'keyword="'.$long[$i].'" ) order by newsID DESC limit '.$start_from.',5';
			}
		}
		else
		{
			$query='SELECT * FROM videotimestamp v,newsvideo n  where n.newsID=v.videoID and  (';
			for($i=0;$i<sizeof($long);$i++){
			if($i!=sizeof($long)-1)
				$query=$query.'subTopic like "%'.$long[$i].'%" or ';
			else
				$query=$query.'subTopic like "%'.$long[$i].'%" ) order by newsID DESC  limit '.$start_from.',5';
			}
		}
		$result=mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($result)!=0)
		{	
			echo'<table class="TFtable">';
			while($record=mysql_fetch_assoc($result))
			{
				$newsSeek=$record['seek'];
				$thumbnail=$record['thumbnail'];
				$clusterS=$record['start'];
				$clusterS=sprintf("%07d",$clusterS);
				$clusterE=$record['end'];
				$clusterE=sprintf("%07d",$clusterE);
				$summary=$record['summary'];
				$summ=ucfirst($summary);
				$mainT=$record['mainTopic'];
				$mainTopic=ucfirst($mainT);
				$subT=$record['subTopic'];
				$subTopic=ucfirst($subT);
				$newsID=$record['newsID'];
				$videoName=$record['newsName'];
				$str=$clusterS.'~'.$clusterE.'~'.$newsID.'~'.$short[1];
				$duration=intval(($clusterE-$clusterS)/60000);
				if($duration==0)
					$duration='< 1';
				
				if($type[1]=="keyword")
				{
					for($i=0; $i<sizeof($long);$i++)
					$summ=str_ireplace($long[$i],'<span style="background-color:red;">'.$long[$i].'</span>',$summ);
					echo'<tr><td valign="top"><img src="'.$thumbnail.'.jpeg" border=1><br>News Story: <a class="inline" onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$newsSeek.');" href="#container"><img src="movieicon.jpg" border=1></td>
					<td id="middle" valign="top"><h3>'.$subTopic.'</h3>'.$summ.'</td><td id="least" valign="top">News: '.$videoName.'<br>Category: '.$mainTopic.'<br>Estimated Duration: '.$duration.' minutes<br>Full story: <a id="story" href="#" onclick="singlenewsforsearch(\''.$str.'\');">link</a><br>Keyword found in: ';
					$quu='select distinct s.startTime,s.endTime,s.seek from videotimestamp v, search s where v.start=s.clusterStart and v.end=s.clusterEnd and (';
					for($i=0;$i<sizeof($long);$i++){
					if($i!=sizeof($long)-1)
						$quu=$quu.'keyword="'.$long[$i].'" or ';
					else
						$quu=$quu.'keyword="'.$long[$i].'" )';
					}
					$quu=$quu.' and clusterStart="'.$record['start'].'" and clusterEnd="'.$record['end'].'"';
					$ress=mysql_query($quu) or die (mysql_error());
					while($req=mysql_fetch_assoc($ress))
					{
						$startS=$req['startTime'];
						$startE=$req['endTime'];
						$seek=$req['seek'];

						echo'<br>'.$startS.'-'.$startE.' <a class="inline" onclick="loadVideo(\''.$videoName.'\'); jwplayer().seek('.$seek.');" href="#container"><img src="movieicon.jpg" border=1></a>';
					}
				}
				else
				{
					echo'<tr><td valign="top"><img src="'.$thumbnail.'.jpeg" border=1><br>News Story: <a class="inline" onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$newsSeek.');" href="#container"><img src="movieicon.jpg" border=1></td>
					<td id="middle" valign="top"><h3>'.$subTopic.'</h3>'.$summ.'</td><td id="least" valign="top">News: '.$videoName.'<br>Category: '.$mainTopic.'<br>Estimated Duration: '.$duration.' minutes<br>Full story: <a id="story" href="#" onclick="singlenewsforsearch(\''.$str.'\');">link</a>';
				}
				echo'</td></tr>';
			}
			echo'</table>';
		
			
		}
		else
		{

				echo'Sorry no such keyword was found in the database!';
				echo'<br>';
		}
		
		
	
	echo'</div></td></tr></table>';	
	
		
?>