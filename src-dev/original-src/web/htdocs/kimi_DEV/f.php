 <?php
ini_set('track_errors',1);
$myfile = fopen("webdictionary.txt", "w");
if (!$myfile ){
	echo "fopen failed. reason:",$php_errormsg;
}

//echo fread($myfile,filesize("webdictionary.txt"));
fclose($myfile);
?> 