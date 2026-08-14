<?php

$ratenhoehe= '75,55';
$ratenhoehe_verein = '100,00';
$int1 = (int)$ratenhoehe;
$int2 = (int)$ratenhoehe_verein;
echo 'Ratenhöhe: '.$ratenhoehe;
echo 'Ratenhöhe_verein: '.$ratenhoehe_verein;

if ($int2 > 0  and $int2 < $int1 ) {
	 	   $ratenhoehehinweis = 'RH pruefen('.$$int1.') ';
		   $vorlage = 91; /* Vorlage automatisch setzen */
		   echo 'ergebnis: '.$ratenhoehehinweis;
		   }  else {
            $ratenhoehehinweis = '';
			echo 'ergebnis: '.$ratenhoehehinweis;
        }

echo '<br>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br>';		
$ratenhoehe= '45,55';
$ratenhoehe_verein = '45,55';
$int1 = (int)$ratenhoehe;
$int2 = (int)$ratenhoehe_verein;
echo 'Ratenhöhe: '.$ratenhoehe;
echo 'Ratenhöhe_verein: '.$ratenhoehe_verein;

if ($int2 > 0  and $int2 < $int1 ) {
	 	   $ratenhoehehinweis = 'RH pruefen('.$$int1.') ';
		   $vorlage = 91; /* Vorlage automatisch setzen */
		   echo 'ergebnis: '.$ratenhoehehinweis;
		   }  else {
            $ratenhoehehinweis = '';
			echo 'ergebnis: '.$ratenhoehehinweis;
        }
		
echo '<br>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br>';		
$ratenhoehe= '45,12';
$ratenhoehe_verein = '25,12';
$int1 = (int)$ratenhoehe;
$int2 = (int)$ratenhoehe_verein;
echo 'Ratenhöhe: '.$ratenhoehe;
echo 'Ratenhöhe_verein: '.$ratenhoehe_verein;

if ($int2 > 0  and $int2 < $int1 ) {
	 	   $ratenhoehehinweis = 'RH pruefen('.$int1.') ';
		   $vorlage = 91; /* Vorlage automatisch setzen */
		   echo 'ergebnis: '.$ratenhoehehinweis;
		   }  else {
            $ratenhoehehinweis = '';
			echo 'ergebnis: '.$ratenhoehehinweis;
        }		
phpinfo();  // allg. Informationen zur PHP-Installation
?>
