<?php

define ("TELEMATICA_URL", "https://vbox6813.telematica.at/admin/apimodules/callmanager/?auth=c82c7aa2b7a6aff583ef70ed3db2e672&command=dial");
$agent_reference = "";
$source_number = "";
$target_number = "";
 
$logfile = dirname(__FILE__)."/log/callTelematica.log";

$response = array();
/*	$source= $_REQUEST["iptel_durchwahl"];
	$destclid= $_REQUEST["kampagne_iptel_destclid"];
	
	$dest = $_REQUEST["dest"];
	//20220623/ab
	$nebenstelle  = $_REQUEST["nebenstelle"]; */
	
	$agent_reference = $_REQUEST["nebenstelle"];
	$source_number = $_REQUEST["kampagne_iptel_destclid"];
	$target_number = $_REQUEST["dest"];
	$auto_vorwahl = $_REQUEST["kampagne_iptel_auto_vorwahl"];
	$client_ip = $_REQUEST["client_ip"];
	
/*} else {
	$source= $_GET["iptel_durchwahl"];
	$destclid= $_GET["kampagne_iptel_destclid"];
	$auto_vorwahl = $_GET["kampagne_iptel_auto_vorwahl"];
	$dest = $_GET["dest"];
	$client_ip = $_GET["client_ip"];
}*/

$loginfo = date('d.m.Y H:i:s', time()).": client_ip=".$client_ip.", agent_reference=".$agent_reference.", source_number=".$source_number.", auto_vorwahl=".$auto_vorwahl.", target_number=".$target_number;
file_put_contents($logfile, $loginfo."\n", FILE_APPEND );


/*if ($client_ip == "" ) {
	$client_ip = $_SERVER['REMOTE_ADDR'];
}
*/

//20220623/ab
//$source = $nebenstelle;

// format destination number
$target_number = str_replace(" ", "", $target_number);
if (substr($target_number, 0, 1) == "+") {
	$target_number = substr_replace($target_number, "00", 0, 1);
}
$target_number = str_replace("/", "", $target_number);
$target_number = str_replace("-", "", $target_number);
$target_number = str_replace(".", "", $target_number);
$target_number = str_replace(",", "", $target_number);
//20191013
if ( (substr($target_number, 0, 1) != "0") && (substr($target_number, 0, 4) != "1090") && (substr($target_number, 0, 4) != "1091") && (substr($target_number, 0, 4) != "1092") ) {
	$target_number = "0".$target_number;
}

// suche nicht numerische Zeichen und schneide ab
preg_match("/[^0-9]/", $target_number, $matches);
if ($matches[0] != "") {
	$pos = strpos($target_number, $matches[0]);

	if ($pos != false) {
		$target_number = substr($target_number, 0, $pos);
	}
}

// Prüfe führende 00
if ( substr($target_number, 0, 2) == "00") {
	$target_number = substr($target_number, 2, strlen($target_number) );
}

if ($agent_reference === "") {
	$response['retcode'] = '9';
	$response['status'] = "Error";
	$response['msg'] = "Keine Agentreferenz vorhanden!";
	$response['queudid'] = "";
	file_put_contents($logfile, "\nFEHLER: Keine Agent-Referenz\n", FILE_APPEND );
	echo json_encode($response);
	exit;
}
if ($source_number == "") {
	$response['retcode'] = '9';
	$response['status'] = "Error";
	$response['msg'] = "Keine Absendernummer (destclid) in Kampange eingetragen!";
	$response['queudid'] = "";
	file_put_contents($logfile, "\nFEHLER: Keine Absendernummer(destclid)\n", FILE_APPEND );
	echo json_encode($response);
	exit;
}
if ($target_number == "") {
	$response['retcode'] = '9';
	$response['status'] = "Error";
	$response['msg'] = "Keine Telefonnummer übergeben!";
	$response['queudid'] = "";
	file_put_contents($logfile, "\nFEHLER: Keine Telefonnummer (target_number)\n", FILE_APPEND );
	echo json_encode($response);
	exit;
}

if ($auto_vorwahl != "") {
	if (substr($target_number, 0, strlen($auto_vorwahl)) != $auto_vorwahl) {
		if (substr($target_number, 0, 1) == "0") {
			$target_number = substr($target_number, 1, strlen($target_number)-1);
		}
		$target_number = $auto_vorwahl.$target_number;
	}
}

$url=TELEMATICA_URL."&agent_reference=".$agent_reference."&source_number=".$source_number."&target_number=".$target_number;

$loginfo .= " -> ". $url;
file_put_contents($logfile, $loginfo."\n", FILE_APPEND );

$return=file_get_contents($url);


// für Test
//$return = '{"result":false,"data":"Error: Agent profile not identified."}';
/*
$resp = array();
$resp['result'] = true;
$resp['data'] = 'OK';

$return = json_encode($resp);
file_put_contents($logfile, "RETURN=".var_export($return, true)."\n", FILE_APPEND );
 -- Ende Test */




//$url = "https://www.geeksforgeeks.org/";
//$return=file_get_contents($url);
//file_put_contents($logfile, "Result=".$return."\n", FILE_APPEND );

$retObj = json_decode($return, true);
file_put_contents($logfile, "RETURN=".var_export($retObj, true)."\n", FILE_APPEND );


if ($retObj["result"] == 'true') {
	$response['retcode'] = "0";
	$response['msg'] = $retObj["data"];
} else {
	$response['retcode'] = "1";
	$response['msg'] = $retObj["data"];
}

$response['status'] = $retObj["result"];
$response['msg'] = $retObj["data"];
$response['queudid'] = ""; //$tokens[2];
$response['url'] = $url;

echo json_encode($response);

exit;

?>
