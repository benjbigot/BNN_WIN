<?php

set_time_limit(0);
?>

<html>
<head>
    <title>Progress Bar</title>
</head>
<body>
<!-- Progress bar holder -->
<div id="progress" style="width:500px;border:1px solid #ccc;"></div>
<!-- Progress information -->
<div id="information" style="width"></div>
<?php
if(isset($_POST["video"]))
	$vvideo=$_POST["video"];
$vname=$_POST["name"];
if(isset($_POST["date"]))
	$vdate=$_POST["date"];
else
	$vdate='';
$type=$_POST["choice"];
if($vdate!='')
	$vname=$vname."_".$vdate;
if($type=='bnn')
	$num="1";
else
	$num="0";

foreach(glob("*.jpeg") as $filename){
unlink($filename);
}
foreach(glob("*.flac") as $filename){
unlink($filename);
}
foreach(glob("*.txt") as $filename){
if($filename !="Business.txt" && $filename !="Culture and Religion.txt"
&& $filename !="Education.txt" && $filename!="Entertainment.txt" && $filename != "Geography and History.txt"
&& $filename != "Health.txt" && $filename !="Military and Weapons.txt" && $filename != "Politics and Governance.txt"
&& $filename !="Science and Technology.txt" && $filename !="Sport.txt" && $filename !="big.txt")
unlink($filename);
}
foreach(glob("*.bat") as $filename){
unlink($filename);
}
foreach(glob("*.csv") as $filename){
unlink($filename);
}
foreach(glob("*.edl") as $filename){

unlink($filename);
}
foreach(glob("*.wav") as $filename){
unlink($filename);
}
foreach(glob("*.seg") as $filename){

unlink($filename);
}
/*foreach(glob("*.mp4") as $filename){
unlink($filename);
} */
foreach(glob("*.html") as $filename){
if($filename !="index.html")
unlink($filename); 
} 

if($num=="1")
{
	$percent = '0%';
	echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="downloading video";
    </script>';
    echo str_repeat(' ',512*64);
	flush();
	 $path = 'python.exe C:\xampp\htdocs\bnn\execute1.py '.$vvideo.' '.$vname;
     exec($path);
}


	$percent = '10%';
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="processing video";
    </script>';
   
    echo str_repeat(' ',512*64);
    flush();  
	$path='python.exe C:\xampp\htdocs\bnn\execute2.py '.$vname;
	exec($path);
	//sleep(1);
if($num=="1")
{
    $percent = '20%';  
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="processing audio";
    </script>';
   
    echo str_repeat(' ',512*64);
    
    flush(); 
    
	$path='python.exe C:\xampp\htdocs\bnn\execute3.py '.$vname;
	exec($path);
	
	$percent = '50%';
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="speech to text conversion";
    </script>';
}
else
{	$percent='30%';
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="Translating of Digital Signal Processing Transcription";
    </script>';
}   
    echo str_repeat(' ',512*64);
    flush();
   $path='python.exe C:\xampp\htdocs\bnn\execute4.py '.$vname.' '.$num;
	exec($path); 
	//sleep(1);
if($num=="1")
{	
    $percent = '70%';
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="creating topic boundaries and defining topics";
    </script>';
 }
else
{
    $percent = '60%';
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="Extracting individual terms of DSP and submit to database  ";
    </script>';
} 
    echo str_repeat(' ',512*64);
    flush(); 
	$path='python.exe C:\xampp\htdocs\bnn\execute5.py '.$vname.' '.$num;
	exec($path);
	sleep(20);


	$percent = '100%';    
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="task completed";
    </script>';
   
    echo str_repeat(' ',512*64);
    
    flush(); 
	
    
// Tell user that the process is completed

	echo '<script language="javascript">document.getElementById("information").innerHTML="Process completed"</script>';
if($num=="1")
	echo'<META HTTP-EQUIV="Refresh" Content="3; URL=bnn.php">';
else
	echo'<META HTTP-EQUIV="Refresh" Content="3; URL=dsp.php">';
exit();

?>

