<?php

define("INNTELCO_TENANT", "kimi-plus");
define("INNTELCO_KEY", "E8WW3JhDBNPjHuCS");
//define("INNTELCO_URL_PBX_PROXY", "https://10.10.2.10/pbx/proxyapi.php");
define("INNTELCO_URL_PBX_PROXY", "https://vpbx4.inntelco.at/pbx/proxyapi.php");
//define("INNTELCO_URL_PBX_PROXY", "https://10.1.255.100/pbx/proxyapi.php");
// statt 10.10.2.10
// fallback-Server Attnang
//define("INNTELCO_URL_PBX_PROXY", "https://10.1.255.100/pbx/proxyapi.php");

// https://vpbx4.inntelco.at/pbx/proxyapi.php?reqtype=DIAL&tenant=kimi-plus&key=E8WW3JhDBNPjHuCS&source=600&dest=004359810&destclid=07322099900

$logfile = dirname(__FILE__)."/log/callInntelco.log";

$response = array();
/*if (isset($_POST) && $_POST["iptel_durchwahl"] != "") {*/
	$source= $_REQUEST["iptel_durchwahl"];
	$destclid= $_REQUEST["kampagne_iptel_destclid"];
	$auto_vorwahl = $_REQUEST["kampagne_iptel_auto_vorwahl"];
	$dest = $_REQUEST["dest"];
	$client_ip = $_REQUEST["client_ip"];
/*} else {
	$source= $_GET["iptel_durchwahl"];
	$destclid= $_GET["kampagne_iptel_destclid"];
	$auto_vorwahl = $_GET["kampagne_iptel_auto_vorwahl"];
	$dest = $_GET["dest"];
	$client_ip = $_GET["client_ip"];
}*/

$loginfo = date('d.m.Y H:i:s', time()).": client_ip=".$client_ip.", source=".$source.", destclid=".$destclid.", auto_vorwahl=".$auto_vorwahl.", dest=".$dest;
file_put_contents($logfile, $loginfo."\n", FILE_APPEND );
// TEST-Only
//$source= "630";
//$destclid = "1234";
//$dest = "06606590009";
//$auto_vorwahl = "0049";


if ($client_ip == "" ) {
	$client_ip = $_SERVER['REMOTE_ADDR'];
}

// source über IP-Adresse ermitteln
// Susanne Lauer		600
// Rita Eller			610
// Anita Obran			630
// Jacqueline Posch		640
// Renate Allerstorfer	650
// Sonia Egger			660
// Marlene Weissacher	670
// Lukas Pirerfellner	680
// Tamara Tyoler		690
// Franz Tausch			900

$durchwahlen = array(
	"192.168.100.57"=>"600",
	"192.168.100.51"=>"610",
	"192.168.100.53"=>"630",
	"192.168.100.56"=>"640",
	"192.168.100.50"=>"650",
	"192.168.100.52"=>"660",
	"192.168.100.58"=>"670",
	"192.168.100.55"=>"680",
	"192.168.100.54"=>"690",
	"192.168.100.100"=>"900",
	"192.168.100.203"=>"900",
	"192.168.100.202"=>"640",
	"192.168.100.204"=>"600",
	"10.1.255.241"=>"600",
	"10.1.253.241"=>"600",
	"192.168.100.201"=>"630",
	"10.1.255.240"=>"900",
	"10.1.253.240"=>"900",
	"10.1.255.242"=>"640",
	"10.1.253.242"=>"640",	
	"10.1.255.243"=>"630",
	"10.1.253.243"=>"630",
	"10.20.12.103"=>"900",
	"10.20.12.105"=>"600",	
	"10.20.12.101"=>"630",
	"10.20.12.102"=>"640",
	"10.20.12.18"=>"671",
	"10.20.12.19"=>"672",
	"10.20.12.16"=>"673",
	"10.20.12.58"=>"670",
	"10.20.12.61"=>"674",
	"10.20.12.15"=>"674",	
        "10.1.253.244"=>"610",
		"10.20.12.10"=>"999",
		"192.168.0.29"=>"999"
	
);
$sourceDW = $durchwahlen[$client_ip];
if ($sourceDW != "") {
	$source = $sourceDW;
}

// format destination number
$dest = str_replace(" ", "", $dest);
if (substr($dest, 0, 1) == "+") {
	$dest = substr_replace($dest, "00", 0, 1);
}
$dest = str_replace("/", "", $dest);
$dest = str_replace("-", "", $dest);
$dest = str_replace(".", "", $dest);
$dest = str_replace(",", "", $dest);
//20191013
if ( (substr($dest, 0, 1) != "0") && (substr($dest, 0, 4) != "1090") && (substr($dest, 0, 4) != "1091") && (substr($dest, 0, 4) != "1092") ) {
	$dest = "0".$dest;
}

// suche nicht numerische Zeichen und schneide ab
preg_match("/[^0-9]/", $dest, $matches);
if ($matches[0] != "") {
	$pos = strpos($dest, $matches[0]);

	if ($pos != false) {
		$dest = substr($dest, 0, $pos);
	}
}

if ($source === "") {
	$response['retcode'] = '9';
	$response['status'] = "Error";
	$response['msg'] = "Keine Durchwahl für den Arbeitsplatz ".$client_ip." hinterlegt!";
	$response['queudid'] = "";
	file_put_contents($logfile, "\nFEHLER: Keine Durchwahl\n", FILE_APPEND );
	echo json_encode($response);
	exit;
}
if ($destclid == "") {
	$response['retcode'] = '9';
	$response['status'] = "Error";
	$response['msg'] = "Keine Absendernummer (destclid) in Kampange eingetragen!";
	$response['queudid'] = "";
	file_put_contents($logfile, "\nFEHLER: Keine Absendernummer(destclid)\n", FILE_APPEND );
	echo json_encode($response);
	exit;
}
if ($dest == "") {
	$response['retcode'] = '9';
	$response['status'] = "Error";
	$response['msg'] = "Keine Telefonnummer übergeben!";
	$response['queudid'] = "";
	file_put_contents($logfile, "\nFEHLER: Keine Telefonnummer (dest)\n", FILE_APPEND );
	echo json_encode($response);
	exit;
}

if ($auto_vorwahl != "") {
	if (substr($dest, 0, strlen($auto_vorwahl)) != $auto_vorwahl) {
		if (substr($dest, 0, 1) == "0") {
			$dest = substr($dest, 1, strlen($dest)-1);
		}
		$dest = $auto_vorwahl.$dest;
	}
}

$url=INNTELCO_URL_PBX_PROXY."?reqtype=DIAL&tenant=".INNTELCO_TENANT."&key=".INNTELCO_KEY."&source=".$source."&account=".$source."-kimi-plus"."&dest=".$dest."&destclid=".$destclid;
$loginfo .= " -> ". $url;
file_put_contents($logfile, $loginfo."\n", FILE_APPEND );

// Testurl
//$url="https://10.10.2.10/pbx/proxyapi.php?reqtype=DIAL&tenant=kimi-plus&key=E8WW3JhDBNPjHuCS&source=630&dest=066065900091&destclid=07322099900";

$return=file_get_contents($url);

file_put_contents($logfile, "RETURN=".var_export($return, true)."\n", FILE_APPEND );

//$url = "https://www.geeksforgeeks.org/";
//$return=file_get_contents($url);
//file_put_contents($logfile, "Result=".$return."\n", FILE_APPEND );


$tokens = explode("|", $return);

if (count($tokens)<2) {
	$tokens[0] = "error";
	$tokens[1] = "Fehler beim Aufruf von ".$url;
	$tokens[2] = "";
}

if (strtolower($tokens[0])=="success") {
	$response['retcode'] = "0";
} else {
	$response['retcode'] = "1";
}
$response['status'] = $tokens[0];
$response['msg'] = $tokens[1];
$response['queudid'] = $tokens[2];
$response['url'] = $url;

echo json_encode($response);
exit;

?>
