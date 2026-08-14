<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : DBHandler.php

* Purpose :

* Creation Date : 28-07-2015

* Last Modified : Mon 17 Aug 2015 15:43:25 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/
  
  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include_once (Settings::getPublic('root_dir') . 'classes/LogActivity.php');
  include_once (Settings::getPUblic('root_dir') . 'classes/LogEntry.php');

  class DBHandler {

    public function __construct () {

    }
    
    //DB-Methods for LogActivities
    public function insertLogActivity (LogActivity $entry) {
      
      include (Settings::getPublic('root_dir').'config/db_config.php');
      
      $sql = "INSERT INTO kimiLogActivity (topic, activity, pos, note) VALUES (?,?,?,?);";

      $stmt = $mysqli->prepare($sql);
      $topic = $entry->getTopic();
      $act = $entry->getActivity();
      $pos = $entry->getPosition();
      $note = $entry->getNote();

      $stmt->bind_param('ssis', $topic, $act, $pos, $note);

      if (!$stmt->execute()) {
        throw new Exception ("Error: Insert not successful! " . $stmt->error);
        $stmt->close();
        $mysqli->close();
        return false;
      }

      $stmt->close();
      $mysqli->close();
      return true;
    }

    public function getLogActivityPos ($activity) {
      
      include (Settings::getPublic('root_dir').'config/db_config.php');
      $sql = "SELECT pos FROM kimiLogActivity WHERE activity=?;";

      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param('s', $activity);
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->store_result();

      if ($stmt->num_rows > 1) {
        throw new Exception ("There can't be more than one rows in the resultset");
        return false;
      }

      $data = $result->fetch_assoc();
      $result->free();
      $stmt->close();
      $mysqli->close();

      return $data['pos'];

    }

    public function increaseLogActivityPos ($posGreaterThan) {

      include (Settings::getPublic('root_dir').'config/db_config.php');

      $sql = "UPDATE kimiLogActivity SET pos=pos+1 WHERE pos>=?;";

      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param('i', $posGreaterThan);

      if (!$stmt->execute()) {
        throw new Exception ("Update not successful! " . $stmt->error);
        $stmt->close();
        $mysqli->close();
        return false;
      }

      $stmt->close();
      $mysqli->close();

      return true;

    }

    public function existsLogActivity($logActivity) {

      include (Settings::getPublic('root_dir').'config/db_config.php');

      $sql = "SELECT activity FROM kimiLogActivity WHERE activity=?;";

      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param('s', $logActivity);
      $stmt->execute();

      $result = $stmt->get_result();

      if ($result->num_rows > 1) {
        throw new Exception ("There can't be more than one rows in the resultset");
        $stmt->close();
        $mysqli->close();
        return false;
      }

      $data = $result->fetch_assoc();
      $exists = false;
      if ($data['activity'] === $logActivity) {
        $exists = true;
      }

      $result->free();
      $stmt->close();
      $mysqli->close();

      return $exists;

    }

    public function getLogActivities() {

      include (Settings::getPublic('root_dir').'config/db_config.php');

      $sql = "SELECT topic, activity, pos, note, id FROM kimiLogActivity ORDER BY pos;";

      $stmt = $mysqli->prepare($sql);
      
      if (!$stmt->execute()) {
        $stmt->close();
        $mysqli->close();
        return false;
      }

      $result = $stmt->get_result();

      $logEntries = array ();

      while ($data = $result->fetch_assoc()) {
        array_push($logEntries, new LogActivity($data['topic'], $data['activity'], $data['pos'], $data['note'], $data['id']));
      }

      $result->free();
      $stmt->close();
      $mysqli->close();

      return $logEntries;
    }

    public function getLogActivityId ($activity) {
      
      include (Settings::getPublic('root_dir').'config/db_config.php');

      $sql = "SELECT id FROM kimiLogActivity WHERE activity=?;";

      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param('s', $activity);

      if (!$stmt->execute()) {
        echo "error2";
        $stmt->close();
        $mysqli->close();
        return false;
      }

      $result = $stmt->get_result();

      if ($result->num_rows > 1 || $result->num_rows === 0) {
        echo "error3";
        $result->free();
        $stmt->close();
        $mysqli->close();
        return false;
      }

      $data = $result->fetch_assoc();

      $result->free();
      $stmt->close();
      $mysqli->close();

      return $data['id'];
    }

      

    //DB-Methods for LogEntries


    public function insertLogEntry (LogEntry $log) {
      
      if (!$logActivityId = $log->getLogActivityId()) {
        echo "error1";
        return false;
      }

      //var_dump($logActivityId);

      include (Settings::getPublic('root_dir').'config/db_config.php');
      include (Settings::getPublic('root_dir').'config/dateformat_config.php');

      $sql = "INSERT INTO kimiLogEntry (logActivityId, logDay, statusId, created, userId, scriptLog) VALUES (?,STR_TO_DATE(?, '".$dateformat['date']['mysql']."'),?,STR_TO_DATE(?, '" . $dateformat['timestamp']['mysql'] . "'),?,?);";
      
      $status = $log->getStatusId();
      $date = $log->getLogDay();
      $created = $log->getCreated()->format($dateformat['timestamp']['php']);
      $user = $log->getUserId();
      $scriptLog = $log->getScriptLog();

      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param('isisis', $logActivityId, $date, $status, $created, $user, $scriptLog);

      if (!$stmt->execute()) {
        
        echo "error4";
        printf("Error: %s.\n", $stmt->error);
        $stmt->close();
        $mysqli->close();
        return false;
      }

      $stmt->close();
      $mysqli->close();
      return true;
    }

    public function getLogEntries ($activity, $logDay) {
      
      include (Settings::getPublic('root_dir').'config/db_config.php');
      include (Settings::getPublic('root_dir').'config/dateformat_config.php');

      $sql = "SELECT la.activity, le.logDay, le.statusId, le.created, le.userId, le.scriptLog, le.id FROM kimiLogEntry le JOIN kimiLogActivity la ON le.logActivityId = la.id WHERE la.activity=? AND le.logDay=STR_TO_DATE(?, '" . $dateformat['date']['mysql'] . "') ORDER BY created;";

      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param('ss', $activity, $logDay);

      if (!$stmt->execute()) {
        printf("Mysql-Error: %s.\n", $stmt->error);
        $stmt->close();
        $mysqli->close();
        return false;
      }

      $result = $stmt->get_result();
      $logEntries = array();
      while ($data = $result->fetch_assoc()) {
        $logEntry = new LogEntry ($data['activity'], $data['logDay'], $data['statusId'], $data['userId'], $data['scriptLog'], $data['id']);
        $logEntry->setCreated(new DateTime($data['created']));
        array_push($logEntries, $logEntry);
      }

      $result->free();
      $stmt->close();
      $mysqli->close();

      return $logEntries;
    }

    public function updateLogEntryStatus ($logStatusId, $scriptLog, $logEntryId) {
      
      include (Settings::getPublic('root_dir').'config/db_config.php');

      $sql = "UPDATE kimiLogEntry SET statusId=?, scriptLog=? WHERE id=?;";
      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param('isi', $logStatusId, $scriptLog, $logEntryId);

      if (!$stmt->execute()) {
        printf("Mysql-Error: %s.\n", $stmt->error);
        $stmt->close();
        $mysqli->close();
        return false;
      }

      $stmt->close();
      $mysqli->close();

      return true;
    }


    //db-function for setup


    public function executeSqlFile ($filepath) {
      include (Settings::getPublic('root_dir').'config/db_config.php');

      if (!is_file($filepath)) {
        return false;
      }

      $commands = file_get_contents($filepath);
      $success = $mysqli->multi_query($commands);
      $mysqli->close();
      return $success;

    }


  }

?>
