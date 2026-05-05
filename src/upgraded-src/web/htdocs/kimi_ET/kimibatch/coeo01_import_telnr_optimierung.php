<?php
error_reporting(E_ALL);
include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "telefon;schuldner;aktenzeichen;mandant;schuldner_vorname;geburtsdatum;anlagedatum;strasse;plz;ort;email;zahlungen;gesamtkapitalhf;gesamtkapitalnf;offenes_kapitalhf;offenes_kapitalnf;zinsen;gesamtrueckstand;inkassokosten;kampagne;anwalt";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 40;

$heute = date("d.m.Y H:i:s");    
echo "COEO 1 IMPORT - Start: ".$heute;
echo "<br><b>COEO_import_telnr_optimierung</b><br><br>";

// 1. Lese Daten aus File
// 2. Telefonnummer Landesvorwahl optimieren
// 3. Ausgabe Datei


// Eingabe
$lines = file('./files/40/IN/KNP0.CSV');
// Ausgabe
$filename = "./files/40/OUT/KNP2.CSV";
$fp = fopen($filename, 'w');

echo "<br>Anzeige: Eingabefile: <br>";
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
	//20170127 AR: wenn nicht UTF-8 dann konvertieren
	$line = convert2Utf8($line);

    // echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
	
	// String auf 2 Teile für die evtl. Korrektur vorbereiten
	$telnr = substr((string) $line, 0,strpos((string) $line, ";"));   // Telefonnummer - und erster Teil des Strings
	
	$line_abtelnr = substr((string) $line, strpos((string) $line, ";")+1,strlen((string) $line));   // 2ter Teil des Strings
	$telnrneu = $telnr; // telnrneu auf jeden Fall Default mit telnr belegen damit diese sicher belegt ist
	// Prüfungen
	$telnrlw = substr((string) $line, 0,2);   // Landesvorwahl Stelle 1-2
	$telnrlw3 = substr((string) $line, 0,3);   // Landesvorwahl Stelle 1-3
	$telnrlw4 = substr((string) $line, 0,4);   // Landesvorwahl Stelle 1-4
	
	// echo "Landesvorwahl: ".$telnrlw."<br>";
	// #1 keine Landesvorwahl
	if ($telnrlw != "43") {
		
		// wenn Mobilnummer-Vorwahl dann Landesvorwahl ergänzen
		// 0650 bis 0653 und 0655  und 0657 und 0659 bis 0661  und 0663 bis 0699 
		if(($telnrlw3 >= "650" && $telnrlw3 <= "653") or ($telnrlw3 >= "655" && $telnrlw3 <= "655") or  ($telnrlw3 >= "657" && $telnrlw3 <= "657") or ($telnrlw3 >= "659" && $telnrlw3 <= "661")  or  ($telnrlw3 >= "663" && $telnrlw3 <= "699") ) {
			
			$telnrneu = "43".$telnr;
		
			echo "Telefon-Landesvorwahl nicht 43: Satz# ".$line_num.": ".$telnr."  --> neue Telnr: ".$telnrneu."<br>";		
		
		} else {
	
			echo "Telefon-Landesvorwahl nicht 43: Satz# ".$line_num.": ".$telnr."  --> neue Telnr: !! NICHT ersetzt!!!<br>";		
			
		}
	}
	// #2 Landesvorwahl mit "0" --> "430"
	if ($telnrlw3 == "430") {
		
		$telnrneu = "43". substr($telnr, 3,strlen($telnr));

		echo "Telefon-Landesvorwahl 430: Satz# ".$line_num.": ".$telnr."  --> neue Telnr: ".$telnrneu."<br>";		
		
	}
	// #3 Landesvorwahl mit "4343" --> "4343"
	if ($telnrlw4 == "4343") {

		$telnrneu = "43". substr($telnr, 4,strlen($telnr));
		
		echo "Telefon-Landesvorwahl 4343: Satz# ".$line_num.": ".$telnr."  --> neue Telnr: ".$telnrneu."<br>";
	}
		
    fwrite($fp, $telnrneu.";".$line_abtelnr); // will proccess /n as newline ... 	
}

fclose($fp);

echo "<br><br>"."COEO 1 IMPORT TELNR OPTIMIERUNG - Ende: ".$heute;

dbClose($dbconn);

?>