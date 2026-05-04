<?php
$ergebnis = "neue Adresse: Mozartstrassed 8/3/9, 8434 Obergurgel, Email ergänzt: hirtlw203@gmx.at, Geburtsdatum auf 28.06.1982 geändert, neue Telefonnummer: 0664/123456, monatliche Rate ok, sendet Ratenvertrag retour  Identifikation: _PersonOK";

$textzeile1 = substr($ergebnis,0,71);
$textzeile1 = str_pad($textzeile1, 70, ' ');   /* mit blank auffüllen */
$textzeile2 = substr($ergebnis,71,71);
$textzeile2 = str_pad($textzeile2, 70, ' ');   /* mit blank auffüllen */
$textzeile3 = substr($ergebnis,142,71);
$textzeile3 = str_pad($textzeile3, 70, ' ');   /* mit blank auffüllen */
$textzeile4 = substr($ergebnis,213,71);
$textzeile4 = str_pad($textzeile4, 70, ' ');   /* mit blank auffüllen */


echo "Textzeile1: ".$textzeile1."<br>";
echo "Textzeile2: ".$textzeile2."<br>";
echo "Textzeile3: ".$textzeile3."<br>";
echo "Textzeile4: ".$textzeile4."<br>";

echo "<br><br>2 ter Test mit 0,70: <br>";
$textzeile1 = substr("0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789",0,70);
$textzeile1 = str_pad($textzeile1, 70, ' ');   /* mit blank auffüllen */
echo "Textzeile1: ".$textzeile1."<br>";

echo "<br><br>3 ter Test mit 0,71: <br>";
$textzeile1 = substr("0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789",0,71);
$textzeile1 = str_pad($textzeile1, 70, ' ');   /* mit blank auffüllen */
echo "Textzeile1: ".$textzeile1."<br>";


echo "<br><br>4 ter Test mit 0,70 ohne Umlaute: <br>";

$ergebnis = "neue Adresse: Mozartstrassed 8/3/9, 8434 Obergurgel, Email ergaenzt: hirtlw203@gmx.at, Geburtsdatum auf 28.06.1982 geaendert, neue Telefonnummer: 0664/123456, monatliche Rate ok, sendet Ratenvertrag retour  Identifikation: _PersonOK";


$textzeile1 = substr($ergebnis,0,70);
$textzeile1 = str_pad($textzeile1, 70, ' ');   /* mit blank auffüllen */
$textzeile2 = substr($ergebnis,70,70);
$textzeile2 = str_pad($textzeile2, 70, ' ');   /* mit blank auffüllen */
$textzeile3 = substr($ergebnis,140,70);
$textzeile3 = str_pad($textzeile3, 70, ' ');   /* mit blank auffüllen */
$textzeile4 = substr($ergebnis,210,70);
$textzeile4 = str_pad($textzeile4, 70, ' ');   /* mit blank auffüllen */


echo "Textzeile1: ".$textzeile1."<br>";
echo "Textzeile2: ".$textzeile2."<br>";
echo "Textzeile3: ".$textzeile3."<br>";
echo "Textzeile4: ".$textzeile4."<br>";


echo "<br><br>5 ter Test mit 0,70 mit Umlaute: <br>";

$ergebnis = "neue Adresse: Mozartstrassed 8/3/9, 8434 Obergurgel, Email ergänzt: hirtlw203@gmx.at, Geburtsdatum auf 28.06.1982 geändert, neue Telefonnummer: 0664/123456, monatliche Rate ok, sendet Ratenvertrag retour  Identifikation: _PersonOK";

$textzeile1 = substr($ergebnis,0,70);
$textzeile1 = str_pad($textzeile1, 70, ' ');   /* mit blank auffüllen */
$textzeile2 = substr($ergebnis,70,71);
$textzeile2 = str_pad($textzeile2, 70, ' ');   /* mit blank auffüllen */
$textzeile3 = substr($ergebnis,140,70);
$textzeile3 = str_pad($textzeile3, 70, ' ');   /* mit blank auffüllen */
$textzeile4 = substr($ergebnis,210,70);
$textzeile4 = str_pad($textzeile4, 70, ' ');   /* mit blank auffüllen */


echo "Textzeile1: ".$textzeile1."<br>";
echo "Textzeile2: ".$textzeile2."<br>";
echo "Textzeile3: ".$textzeile3."<br>";
echo "Textzeile4: ".$textzeile4."<br>";

?>
