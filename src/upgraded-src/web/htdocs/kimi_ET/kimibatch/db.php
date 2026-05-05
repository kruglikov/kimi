<?php
include ("../config/config.php");

//20170127 AR: Konvertierung von nicht UTF8-Strings zur Ausgabe
function convert2Utf8($value, $encoding = null)
{
	$retval = $value;

	if (!mb_check_encoding($retval, 'UTF-8')  ) {
		if ($encoding =="") {
			$encoding = "Windows-1252";
		} 
		if (!$encoding == null & !$encoding == "") {
			$retval = mb_convert_encoding($retval, 'UTF-8', $encoding);
		} 
	} 
	return $retval;
}

function convert2ANSI($value)
{
	$retval = iconv( "UTF-8", 'Windows-1252//TRANSLIT', (string) $value );
	return $retval;
}

function getReplaceCheckNull($value, $search, $replace) {

	
	//$retval = "REPLACE('NULL', NULL, REPLACE($value, $search, $replace))";
	if ($value == 'NULL' | $value == '') {
		$retval = "NULL";
	} else {
		$retval = "REPLACE('$value', '$search', '$replace')";
	}

	/*if ($retval != "NULL" & $prepostfix != "" ) {
		$retval = $prepostfix.$retval.$prepostfix;
	}*/
	Return $retval;
}

function getReplaceBlank2Null($value, $prepostfix) {

	$retval = $value;
	if ($value == 'NULL' | $value == '') {
		$retval = "NULL";
	}

	if ($retval != "NULL" & $prepostfix != "" ) {
		$retval = $prepostfix.$retval.$prepostfix;
	}
	Return $retval;
}
//20211216
function isEncryptionEnabled($mandant_id) {
	$return = FALSE;
	
	if (defined('CONF_ENCRYPTION_MANDANT_ID') != TRUE) {
		return false;
	}
	
	$pos = strpos(",".CONF_ENCRYPTION_MANDANT_ID.",", ",$mandant_id,");
	
	if ($pos === FALSE) {
		$return = FALSE;
	} else {
		$return = TRUE;
	}
	
	return $return;
}

$convert_import_csvAnsi2Utf8 = true;
$convert_export_csvUtf82Ansi = true;

$dbname="kimi_et";

$dbhost="localhost";

$dbuser="sql_kimi_et";

$dbpass="NS889Hs4bhL1aub7HyEH6AjdYpYAlx";

$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass);

mysqli_set_charset($dbconn, 'utf8');

mysqli_select_db($dbconn, $dbname);
mysqli_set_charset($dbconn, 'utf8');
mysqli_options($dbconn, MYSQLI_OPT_LOCAL_INFILE, true);

?>

