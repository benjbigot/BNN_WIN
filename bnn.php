<head>
<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<?php 
include 'opendb.php'; 
$query='select newsName from newsvideo order by newsID DESC limit 1';
$result=mysql_query($query) or die (mysql_error());
if(mysql_num_rows($result)!=0)
			{	
				$record=mysql_fetch_assoc($result);
				$last=$record['newsName'];
			}
?>
<body link=white >
<script type="text/javascript">
<?php 
$myArr=json_encode($last);
echo"var myArr=".$myArr.";\n";

?>

</script>
<link rel="stylesheet" href="colorbox.css" />
<script src="myscripts.js"></script>
<script src="jquery-1.11.0.min.js"></script>
<script src="jquery.colorbox.js"></script>
<script type="text/javascript" src="jwplayer.js"></script>

<div style='display:none' id="player">
<div id="container">Loading the player ...</div>
<script type="text/javascript">
 
jwplayer("container").setup({
				"flashplayer":"jwplayer.flash.swf",
				"file":myArr+"image/"+myArr+".mp4",
				"autostart": "false",
                "controlbar.position": "bottom",
				tracks: [
                     { file: myArr+"en.vtt", label: "English", kind: "captions" },
                     { file: myArr+"cn.vtt", label: "Mandarin", kind: "captions" },
                     { file: myArr+"ms.vtt", label: "Melayu", kind: "captions" },
                     { file: myArr+"ta.vtt", label: "Tamil", kind: "captions" },
                     { file: myArr+"thumb.vtt",kind: "thumbnails"}
                ],
				captions: {
                        back: false,
                        fontsize: 10
					},
				height: "500",
				width: "800"
		
         });
</script>
<script type="text/javascript">
function loadVideo(myFile)
{
	
	jwplayer().load([{	
		"file":myFile+"image/"+myFile+".mp4",
		tracks: [
                     { file: myFile+"en.vtt", label: "English", kind: "captions" },
                     { file: myFile+"cn.vtt", label: "Mandarin", kind: "captions" },
                     { file: myFile+"ms.vtt", label: "Melayu", kind: "captions" },
                     { file: myFile+"ta.vtt", label: "Tamil", kind: "captions" },
                     { file: myFile+"thumb.vtt",kind: "thumbnails"}
                ]
				}]);
	jwplayer().play();
	
};
	
</script>
</div>
<script type="text/javascript" src="chrome.js"></script>


<div id=main>
<div class="chromestyle" id="chromemenu">
<ul>
<li><a href="#" onclick='aboutus()'>About Us</a></li>
<li><a href="#" onclick='filter("latest"); return false;'>Home</a></li>
<li><a href="#" onclick='news(); return false;'>List of News</a></li>
<li><a href="#"rel="dropmenu2" onclick="thirdbar();">List of Topics</a></li>
<li><a href="#">FAQ</a></li>
</ul>
</div>
<div id="dropmenu2" class="dropmenudiv">
<table><tr>
<td><input type="checkbox"  onClick="topicbar();"	value="Politics and Governance" name="chek[]">Politics</td>
<td><input type="checkbox" onClick="topicbar();" value="Entertainment" name="chek[]">Entertain</td></tr>
<tr><td><input type="checkbox" onClick="topicbar();" value="Health" name="chek[]">Health</td>
<td><input type="checkbox"  onClick="topicbar();"value="Science and Technology" name="chek[]">Science</td></tr>
<tr><td><input type="checkbox" onClick="topicbar();" value="Geography and History" name="chek[]">History</td>
<td><input type="checkbox" onClick="topicbar();" value="Business" name="chek[]">Business</td></tr>
<tr><td><input type="checkbox" onClick="topicbar();" value="Culture and Religion" name="chek[]">Culture</td>
<td><input type="checkbox" onClick="topicbar();" value="Military and Weapons" name="chek[]">Military</td></tr>
<tr><td><input type="checkbox" onClick="topicbar();" value="Sport" name="chek[]">Sport</td>
<td><input type="checkbox" onClick="topicbar();" value="Education" name="chek[]">Education</td></tr></table>
</div>
<script type="text/javascript">cssdropdown.startchrome("chromemenu")</script>
<div id=bbn align=center><a href="#" onclick='filter("latest"); return false;'><img src="bnn.png" width="450" height="136"></a></div>
<div id=searchbox align=center>
<form id="formelement" onsubmit="keysearch(this.search.value+'|'+getRadioValue()); return false">
<input id="search" type="text" placeholder="Search news">
<input id="submit" type="submit" value="Search" >
</form>
</div>

<div id=list>
<div id=fill></div>

</div>
<div id=rad>
<input type="radio" id="sto" name="stor" value="keyword" checked>search keyword &nbsp;&nbsp;&nbsp;<input type="radio" name="stor"  id="sto"  value="story"> search news stories

</div>

</div>


