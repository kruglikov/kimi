<?php
  include ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
	echo "Teste Datenbank verbindung...";
	include ($rootDir.'config/db.php');
	if (isset($mysqli)) {
		echo "\nDatenbankverbindung erfolgreich: ";
		echo $mysqli->host_info;
	}

?>
