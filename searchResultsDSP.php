<?php
include 'opendbDSP.php';
	$q=$_GET["id"];
	$long=explode(' ',$q);
	$lectArray=Array();
	echo '<table align="right" width="100"><tr><td><div class="scroll">';
	echo'<table class="TFtable">';
			for($i=0; $i<sizeof($long); $i++)
			{
				$query='select * from externalref where score=(select max(score) from externalref where tWord="'.$long[$i].'") and tWord="'.$long[$i].'"';
				$result=mysql_query($query) or die (mysql_error());
				if(mysql_num_rows($result)!=0)
				{
					while($record=mysql_fetch_assoc($result))
					{
					$lect=$record['lectN'];
					}
					$lectArray[]=$lect;
				}	
			}
			$bestScore=0;
			$bestlecture='';
			for($i=0; $i<sizeof($lectArray); $i++)
			{
				$countScore=0;
				$query='select * from externalref where (';
				for ($j=0; $j<sizeof($long); $j++)
				{
					if($j!=sizeof($long)-1)
						$query=$query.'tWord="'.$long[$j].'" or ';
					else
						$query=$query.'tWord="'.$long[$j].'")';
				}
				$query=$query.'and lectN="'.$lectArray[$i].'"';
				$result=mysql_query($query) or die (mysql_error());
				if(mysql_num_rows($result)!=0)
				{
					while($record=mysql_fetch_assoc($result))
					{
						$score=$record['score'];
						$countScore=$countScore+$score;
					}
					$countScore=$countScore/sizeof($long);
				if($countScore>$bestScore)
					$bestScore=$countScore;
					$bestlecture=$lectArray[$i];
				}
				
			}
			$pdf=$bestlecture.'.pdf';
			echo '<a href='.$pdf.'>'.$bestlecture.'.pdf</a>';
			echo'<tr><td valign="top">lecture video:'.$bestlecture.'<a class="inline" onclick="loadVideo(\''.$bestlecture.'\'); dynamicVideo(\''.$bestlecture.'\');" href="#inline_contain"><img src="movieicon.jpg" border=1></td>
			<td id="middle" valign="top">Summary of topic</td><td id="least" valign="top">Topic: <a href='.$pdf.'>'.$bestlecture.'.pdf</a>';
			
			$query='SELECT startTime,endTime,seek,videoName FROM transcription t,lectvideo l where t.videoID=l.videoID and  (';
			for($i=0;$i<sizeof($long);$i++){
			if($i!=sizeof($long)-1)
				$query=$query.'keyword="'.$long[$i].'" or ';
			else
				$query=$query.'keyword="'.$long[$i].'" ) order by t.videoID DESC';
			}
	
		$result=mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($result)!=0)
		{	

			while($record=mysql_fetch_assoc($result))
			{
				$seek=$record['seek'];
				$start=$record['startTime'];
				$end=$record['endTime'];
				$videoName=$record['videoName'];				
				echo'<tr><td valign="top">lecture video:'.$videoName.'<a class="inline" onclick="loadVideo(\''.$videoName.'\'); dynamicVideo(\''.$videoName.'\');" href="#inline_contain"><img src="movieicon.jpg" border=1></td>
				<td id="middle" valign="top"></td><td id="least" valign="top">lecture: '.$videoName.'<br>Keyword found in: ';
				echo'<br>'.$start.'-'.$end.' <a class="inline" onclick="loadVideo(\''.$videoName.'\');jwplayer().seek('.$seek.'); dynamicVideo(\''.$videoName.'\');" href="#inline_contain"><img src="movieicon.jpg" border=1></a>';
			}
			echo'</td></tr>';
			echo'</table>';
		}
		else
		{

				echo'Sorry no such keyword was found in the database!';
				echo'<br>';
		}
	echo'</div></td></tr></table>';	
	
		
?>