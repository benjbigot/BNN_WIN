
//--------------------------------------------Keyword search--------------------------------------------------------------



function showResult(str){
	var mov=new XMLHttpRequest();
	mov.open("GET","searchResultsDSP.php?id="+str,true);
	mov.onreadystatechange=function(){
	if (mov.readyState==4 && mov.status==200){
		document.getElementById("fill").innerHTML=mov.responseText;}
			$(document).ready(function() {
				$(".inline").colorbox({inline:true, innerWidth:800, innerHeight:600 });
		});}
mov.send();} 


//--------------------------------------------------------------------------------------------------------------------------------------

function dynamicVideo(myFile)	
{	
	dynamic=new XMLHttpRequest();
	dynamic.open("GET","Summ.php?id="+myFile,true);
	dynamic.send();
	b=[];
	dynamic.onreadystatechange=function()
	{
		if (dynamic.readyState==4 && dynamic.status==200){
			myData=JSON.parse(dynamic.responseText);
			a=myData.one;
			b=myData.two;
			var tempA=0;
			var tempB=0;

	
			jwplayer().onTime(function()
			{
			var currentPosition=jwplayer().getPosition();
			var code=0; 
			if((currentPosition<tempA || currentPosition>tempB)){
			for (var x in b) {
				if (currentPosition<b[b.length-1]){
						if (currentPosition>b[code] && currentPosition<b[code+1]){
							passString(a+"~"+b[code]+"~"+b[code]+"~"+b[code+1]); tempA=b[code]; tempB=b[code+1]; code=0; break;}}
				else{
					code=b.length-1;
					passString(a+"~"+b[code]+"~"+b[code]+"~"+b[code+1]); tempA=b[code];  tempB=b[code]+10000; code=0; break;	}code=code+1;}}});
					}
	}	
}

function passString(id)
{

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'transcript.php?req='+id, true);
    xhr.onload = function() 
    {
		if(xhr.readyState==4 && xhr.status==200)
		{
			document.getElementById("contain").innerHTML=xhr.responseText;
		}
    }
    xhr.send(null);
}



