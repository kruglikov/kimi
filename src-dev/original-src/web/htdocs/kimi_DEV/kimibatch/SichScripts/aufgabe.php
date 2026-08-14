<!DOCTYPE HTML>

<HTML>
<head>
<body>
<form action="index.php" name ="myform" method = "post">

Vorname:	<input type = "text" name = "text0" align="middle" > <br>
Nachname:	<input type = "text" name = "text1" align="middle"> <br>
Email:	<input type = "text" name = "text2" align="middle" > <br>
<input type= "submit" name ="mbutton" onclick= "return myfunction1() "  >

<form/>
<body/>

<script>

function myfunction1() 
{
var err = 0
var vname=document.forms["myform"]["text0"].value;
var nnach=document.forms["myform"]["text1"].value;
var email=document.forms["myform"]["text2"].value;

if (vname==null||vname=="")
	{ 
	alert("vorname muss belegt sein");
	err=1
	
}
if (nnach==null||nnach=="")
	{
	alert ("Nachname muss belegt sein");
	err=1
	}	
if (email==null||email=="") 
	{
	alert ("email muss belegt sein");
	err=1
	}
if (err==0)
{
	return true;

}
else
{
	return false;
}
}


</script>

</head>

</HTML>