<?php
include 'opendb.php';
	$q=$_GET["id"];
	$long=explode(',',$q);
	$total_records=0;

    $query='select * from videotimestamp v,newsvideo n where (';

		for($i=0; $i<sizeof($long);$i++)
		{
			if($i==sizeof($long)-1)
				$query=$query.'mainTopic="'.$long[$i].'"';
			else
				$query=$query.'mainTopic="'.$long[$i].'" or ';
		
		}
	
	$query=$query.') and v.videoID=n.newsID order by mainTopic';
	$result=mysql_query($query) or die (mysql_error());
	$row=mysql_num_rows($result);
	$total_records=$total_records+$row;
	
	echo $total_records;
?>