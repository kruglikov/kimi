<?php
// AJAX zum schreiben einer Datei

$response = array();
$content = $_REQUEST["content"];

if (isset($_REQUEST["filename"]) && $_REQUEST["filename"] != "") {
	$filename = $_REQUEST["filename"];
} else {
	$filename = "";
	$response['filename'] = "NO_FILE_NAME";
	echo json_encode($response);
	exit;
}
 

if ($_REQUEST["content"]) {
	file_put_contents($filename, $content);
	$response['fileName'] = $filename;
	echo json_encode($response);
	exit;
} else {
	$response['fileName'] = "ERROR";
	echo json_encode($response);
	exit;
}


?>

