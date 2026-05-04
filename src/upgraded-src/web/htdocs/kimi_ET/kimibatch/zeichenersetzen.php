<?php

$line = 'kein Stern * -> wird ersetzt und auch EIN Hochkomma '.chr(39).' darf sind sein ';

echo "<br>".$line = 'kein Stern * -> wird ersetzt und auch EIN Hochkomma '.chr(39).' darf sind sein ';

//  ohne Stern
$line = str_replace('*', ' ', $line);
echo  "<br>".$line;
// ohne Hochkomma
$line = str_replace(chr(39), ' ', $line);
echo  "<br>".$line;

?>