<head>
<link rel="stylesheet" type="text/css" href="mystyleDSP.css">
</head>

<body link=white >
<script type="text/javascript">

</script>
<link rel="stylesheet" href="colorbox.css" />
<script src="myscriptsDSP.js"></script>
<script src="jquery-1.11.0.min.js"></script>
<script src="jquery.colorbox.js"></script>
<script type="text/javascript" src="jwplayer.js"></script>

<div style='display:none' id="player">
<div id="inline_contain">
<div id="container">Loading the player ...</div>
<div id="contain"></div>
</div>
<script type="text/javascript"> 
jwplayer("container").setup({
				"flashplayer":"jwplayer.flash.swf",
				"file":"lecture1.mp4",
				"autostart": "false",
                "controlbar.position": "bottom",
				tracks: [
                     { file: "lecture1en.vtt", label: "English", kind: "captions" },
                     { file: "lecture2cn.vtt", label: "Mandarin", kind: "captions" },
                     { file: "lecture3ms.vtt", label: "Melayu", kind: "captions" },
                     { file: "lecture3ta.vtt", label: "Tamil", kind: "captions" },
					 { file: "lecture1thumb.vtt",kind: "thumbnails"}
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
		"file":myFile+".mp4",
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
<li><a href="#">FAQ</a></li>
</ul>
</div>

<script type="text/javascript">cssdropdown.startchrome("chromemenu")</script>
<div id=bbn align=center>dsp</div>
<div id=searchbox align=center>
<form id="formelement" onsubmit="showResult(this.search.value); return false">
<input id="search" type="text" placeholder="Search lecture">
<input id="submit" type="submit" value="Search" >
</form>
</div>

<div id=list>
<div id=fill></div>

</div>
</div>


