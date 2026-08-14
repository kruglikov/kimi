<!DOCTYPE html>
<html>
<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : logView.php

* Purpose :

* Creation Date : 30-07-2015

* Last Modified : Son 16 Aug 2015 18:14:18 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include_once ("classes/LogActivity.php");
  include_once ("classes/LogEntry.php");
  include_once ("instances/DBHandler_inst.php");
  include_once ("instances/LogUser_inst.php");
  include_once ("instances/LogStatus_inst.php");
  include ("config/dateformat_config.php");

  if (isset($_COOKIE['bookingDate'])) {
    $bookingDate = $_COOKIE['bookingDate'];
  } else {
    $bookingDate = date($dateformat['date']['php'], time());
   
  }

  $logActivities = $dbHandler->getLogActivities();

?>
  <head>
    <title>KIMI-Plus - Batch-Protokoll</title>
    <link href='css/main.css' type='text/css' rel='stylesheet'>
  </head>
  <body>
  <h1>KIMI-Plus - Batch-Protokoll vom <?php echo $bookingDate ?></h1>
  
  <h2>Buchungsdatum festlegen</h2>
  <form name='setLogDay' action='saveCookie.php' method='POST' >
  <table>
    <tr>
      <td>Buchungs-Tag/Datum festlegen (Format: dd.mm.yyyy):</td>
      <td><input type='text' name='value' placeholder='dd.mm.yyyy' pattern='(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}' value='<?php echo $bookingDate; ?>' required></td>
      <td><input type='submit' value='speichern'><input type='hidden' name='sourceURI' value='<?php echo $_SERVER['REQUEST_URI']?>'><input type='hidden' name='cookieName' value='bookingDate'></td>
    </tr>
  </table>
  </form>
  <h2>Protokoll-Eintrag einfügen</h2>
  <form name='insertLogEntry' action='insertLogEntry.php' method='POST' >
  <table>
    <tr>
      <td>Aktivität</td>
      <td>Status</td>
      <td>User</td>
      <td>SkriptAusgabe</td>
    </tr>
    <tr>
      <td>
<?php
  echo "<select name='logActivity' required><option></option>";
  foreach ($logActivities as $logActivity) {
    echo "<option value='".$logActivity->getActivity()."'>".$logActivity->getActivity()."</option>";
  }
  echo "</select>";
?>
      </td>
      <td>
<?php
  echo "<select name='logStatus' required><option></option>";
  foreach ($logStatus->getLogStatusArray() as $key => $value) {
    echo "<option value='".$key."'>".$value."</option>";
  }
  echo "</select>";
?>
      </td>
      <td>
<?php
  echo "<select name='logUser' required><option></option>";
  foreach ($logUser->getLogUserArray() as $key => $value) {
    echo "<option value='".$key."'>".$value."</option>";
  }
  echo "</select>";
?>
      </td>
      <td><textarea name='scriptLog' required cols='75'></textarea></td>
    </tr>
    <tr>
      <td colspan='4'><input type='submit' value='einfügen'><input type='hidden' name='sourceURI' value='<?php echo $_SERVER['REQUEST_URI']?>'><input type='hidden' name='bookingDate' value='<?php echo $bookingDate ?>'></td>
    </tr>
  </table>
  </form>
<?php
  
  

  //TO-DO: bookingDate auswählen und verändern; bookingDate in Cookie speichern
  
  echo "<h2>Protokoll-Einträge vom " . $bookingDate ."</h2>";
  echo "<table class='log'>";

  foreach ($logActivities as $logActivity) {
    echo "<tr class='log activity'>";
    echo "<td>" . $logActivity->getTopic() . "</td>";
    echo "<td>" . $logActivity->getActivity() . "</td>";
    echo "<td colspan='3'>" . $logActivity->getNote() . "</td>";
    echo "</tr>";
    $logEntries = $logActivity->getLogEntries($bookingDate);

    foreach ($logEntries as $logEntry) {
      if (isset($_POST['logEntryId']) && (int)$_POST['logEntryId'] === $logEntry->getId()) {
        echo "<tr class='log entry status_".strtolower($logStatus->getLogStatus($logEntry->getStatusId()))."'>";
        echo "<form id=editEntry".$logEntry->getId()."' action='editLogEntry.php' method='POST'>";
        echo "<td><select name='logStatus' required><option></option>";
        foreach ($logStatus->getLogStatusArray() as $key => $value) {
          if ($key === $logEntry->getStatusId()) {
            echo "<option value='".$key."' selected>".$value."</option>";
          } else {
            echo "<option value='".$key."'>".$value."</option>";
          }
        }
        echo "</select></td>";
        echo "<td><input type='text' value='".$logEntry->getCreated()->format($dateformat['timestamp']['php'])."' disabled></td>";
        echo "<td><input type='text' value='".$logUser->getUserName($logEntry->getUserId())."' disabled></td>";
        echo "<td><textarea name='scriptLog' required cols='75'>".$logEntry->getScriptLog()."</textarea></td>";
        echo "<td><input type='submit' value='speichern'><input type='hidden' name='logEntryId' value='".$logEntry->getId()."'><input type='hidden' name='sourceURI' value='".$_SERVER['REQUEST_URI']."'></td>";
        echo "</form></tr>";


      } else {
        echo "<tr class='log entry status_".strtolower($logStatus->getLogStatus($logEntry->getStatusId()))."'>";
        echo "<td>" . $logStatus->getLogStatus($logEntry->getStatusId()) . "</td>";
        echo "<td>" . $logEntry->getCreated()->format($dateformat['timestamp']['php']) . "</td>";
        echo "<td>" . $logUser->getUserName($logEntry->getUserId()) . "</td>";
        echo "<td>" . nl2br($logEntry->getScriptLog()) . "</td>";
        echo "<td><form id='editButton" . $logEntry->getId() . "' action='logView.php' method='POST'>";
        echo "<input type='hidden' name='logEntryId' value='" . $logEntry->getId() . "'><input type='submit' value='bearb.'></form></td>";
        echo "</tr>";
      }
    }
  }

  echo "</table>";

?>

  </body>
</html>
