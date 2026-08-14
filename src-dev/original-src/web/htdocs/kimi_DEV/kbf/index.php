<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : index.php

* Purpose :

* Creation Date : 14-08-2015

* Last Modified : Mon 17 Aug 2015 18:03:03 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");

  $kimiBatchConsole = array();

  function addCategory ($categoryName) {
    global $kimiBatchConsole;
    $tableRow = "<tr class='category' ><td colspan='3'>" . $categoryName . "</td></tr>";
    array_push($kimiBatchConsole, $tableRow);
  }

  function addScriptEntry ($topic, $scriptFileName, $scriptDisplayName, $note=null) {
    global $kimiBatchConsole;
    $tableRow = "<tr class='entry' ><td class='topic' >" . $topic . "</td><td><a href='" . Settings::getPublic('http_home') . "kimiBatchScripts/" . $scriptFileName . "' target='_blank' >" . $scriptDisplayName . "</a></td><td>" . $note . "</td></tr>";
    array_push($kimiBatchConsole, $tableRow);
  }

  function displayEntries() {
    global $kimiBatchConsole;

    foreach ($kimiBatchConsole as $entry) {
      echo $entry;
    }

  }

/*
  Hier werden die Einträge in der Kimi Batch Framework-Konsole hinterlegt. Angezeigt werden Sie in der Reihenfolge in der Sie mit den Funktionen addCategory und addScriptEntry definiert werden.
*/

  addCategory ("Tagesstart");

  addScriptEntry("Verwaltungssatz", "kbf_test.php", "Testausführung");

  addCategory ("Tagesverarbeitung");

  addCategory ("Tagesabschluss");

  addCategory ("Inkasso");

  addCategory ("Reporting");

?>

<!DOCTYPE html>
<html>

  <head>
    <title>Kimi Batch Framework-Konsole</title>
    <link href='css/main.css' type='text/css' rel='stylesheet'>
  </head>

  <body>
    <h1>Kimi Batch Framework</h1>
    <h3><a href='./logView.php' target='_blank' >KIMI-Plus Batch-Protokoll</a></h3>
    <h2>Buchungsdatum festlegen</h2>
    <form name='setLogDay' action='saveCookie.php' method='POST' >
    <table>
     <tr>
        <td>Buchungs-Tag/Datum festlegen (Format: dd.mm.yyyy):</td>
        <td><input type='text' name='value' placeholder='dd.mm.yyyy' pattern='(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}' value='
<?php if (isset($_COOKIE['bookingDate'])) {
          echo $_COOKIE['bookingDate']; 
        } else {
          echo "";
} ?>' required></td>
        <td><input type='submit' value='speichern'><input type='hidden' name='sourceURI' value='<?php echo $_SERVER['REQUEST_URI']?>'><input type='hidden' name='cookieName' value='bookingDate'></td>
      </tr>
    </table>
    </form>

    <h2>Protokoll Benutzer festlegen</h2>
    <form name='setLogUser' action='saveCookie.php' method='POST' >
    <table>
      <tr>
          <td>Protokoll User festlegen:</td>
          <td>
<?php 
include_once (Settings::getPublic('root_dir') . "instances/LogUser_inst.php");
echo "<select name='value' required><option></option>";
  foreach ($logUser->getLogUserArray() as $key => $value) {

    echo "<option value='".$key."'";
    if (isset($_COOKIE['logUser']) && strcmp($key, $_COOKIE['logUser']) === 0) {
      echo " selected";
    }
    echo " >".$value."</option>";
  }
  echo "</select>";

?>
          </td>
          <td><input type='submit' value='speichern'><input type='hidden' name='sourceURI' value='<?php echo $_SERVER['REQUEST_URI']?>'><input type='hidden' name='cookieName' value='logUser'></td>
      </tr>
    </table>
    </form>

    <h2>Kimi Batch Framework-Konsole</h2>
    <table id='kbf_console' > <?php displayEntries(); ?> </table>
  
  
  </body>

</html>
