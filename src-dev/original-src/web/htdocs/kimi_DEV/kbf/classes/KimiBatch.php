<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : KimiBatch.php

* Purpose :

* Creation Date : 11-08-2015

* Last Modified : Son 16 Aug 2015 21:55:26 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  require_once (Settings::getPublic('root_dir')."classes/File.php");
  require (Settings::getPublic('root_dir')."config/dateformat_config.php");

  class KimiBatch {
    
    private $activity;

    private $scriptPath;
    private $scriptOutputFile = null;
    private $scriptInputFile = null;

    private $log = "";

    private $logStatus;
    private $bookingDate;
    private $logUser;

    private $error = false;

    public function __construct ($activity) {
      require (Settings::getPublic('root_dir')."instances/LogStatus_inst.php");
      require (Settings::getPublic('root_dir')."config/dateformat_config.php");

      $this->log = $this->log . "Kimi Batch Framework mit Aktivität " . $activity . " gestartet...\n\n";
      $this->activity = $activity;

      if (isset($_COOKIE['bookingDate']) && isset($_COOKIE['logUser'])) {
        $this->bookingDate = DateTime::createFromFormat($dateformat['date']['php'], $_COOKIE['bookingDate']);
        $this->logUser = $_COOKIE['logUser'];
      } else {
        $this->log = $this->log . "Error: Log-User oder Buchungsdatum nicht gesetzt!\n\n";
        $this->error = true;
        exit();
      }

      $this->logStatus = $logStatus->getLogStatusId ('KONTROLLE');

    }

    public function __destruct () {

      if ($this->error) {
        $this->log = $this->log . "Kimi Batch Framework mit Fehlern beendet!\n";
      } else {
        $this->log = $this->log . "Kimi Batch Framework ohne Fehler beendet.\n";
      }

      include_once (Settings::getPublic('root_dir') . "classes/LogEntry.php");
      require (Settings::getPublic('root_dir')."config/dateformat_config.php");
      
      $le = new LogEntry ($this->activity, $this->bookingDate->format($dateformat['date']['php']), $this->logStatus, $this->logUser, $this->log);
      
      if (!$le->insert()) {
        $this->log .= "Error: Protokoll-Eintrag konnte nicht in die Datenbank geschrieben werden!\n\n";
      }
      //debug outputs
      //var_dump($le->insert());
      //var_dump($this->log);
      self::logHtmlOutput();
    }

    private function logHtmlOutput() {
      $htmlLog = str_replace ("\n", "<br />", $this->log);
      $htmlLog .= "<br />"; 
      
      for ($i=0; $i<51; $i++) {
        $htmlLog .= ".~.";
      }

      $htmlLog .= "<br /><br />";
      echo $htmlLog;
    }

    public function executeHttpScript ($scriptURL, $scriptReturnFile=false) {
      include_once (Settings::getPublic('root_dir')."classes/Http.php");
      require (Settings::getPublic('root_dir')."instances/LogStatus_inst.php");
      
      if ($scriptReturnFile) {

        $http = new Http ($scriptURL);
        if (($outputFile = $http->getFile()) === false) {
          $this->error = true;
          $this->logStatus = $logStatus->getLogStatusId ('FEHLER');
          $this->log .= "Error: Fehler beim download von der Datei!\n\n";
          exit();
        }
          
        $this->scriptOutputFile = new File ($outputFile);

        $this->log .= "Datei: " . $this->scriptOutputFile->getBasename() . " erfolgreich herunterladen.\n\n";

      } else {

        

        $http = new Http ($scriptURL);

        $script_output = $http->getHtmlContent();
        $script_output = strip_tags($script_output, '<h1></h1><br><br/>');
        $script_output = str_replace ("h1", "h2", $script_output);

        //var_dump($http->getHttpCode());
        
        if ($http->getHttpCode() < 200 || $http->getHttpCode() > 299) {
          $this->error = true;
          $this->logStatus = $logStatus->getLogStatusId ('FEHLER');
          $this->log .= "Error: Skript wurde nicht ordnungsgemäß ausgeführt! HTTP-Status Code: " . $http->getHttpCode() . "\n\n";
          $this->log .= "<p>Script-Output:</p><blockquote>" . $script_output . "</blockquote>";

          exit();
        }

        $this->log = $this->log . "<p>Script-Output:</p><blockquote>" . $script_output . "</blockquote>";

      }

    }

    public function copyScriptOutputFileToFtp ($path, $bookingDateDir=true) {
      require (Settings::getPublic('root_dir')."instances/LogStatus_inst.php");
      require (Settings::getPublic('root_dir')."config/dateformat_config.php");
      
      if ($this->scriptOutputFile === null) {
        $this->error = true;
        $this->logStatus = $logStatus->getLogStatus ('FEHLER');
        $this->log .= "Error: Skript-Output Datei nicht gefunden!\n\n";
        exit();
      }

      $copySuccess = $this->scriptOutputFile->putToFtp ($path, $bookingDateDir);

      if ($copySuccess) {
        $ftpFilepath = $path;
        if ($bookingDateDir) {
          
          //var_dump($this->bookingDate);
          $ftpFilepath .= "/" . $this->bookingDate->format($dateformat['folder']['php']);
        }
        $ftpFilepath .= "/" . $this->scriptOutputFile->getBasename();
        $this->log .= "Datei " . $this->scriptOutputFile->getBasename() . " erfolgreich von " . $this->scriptOutputFile->getFilepath() . " zu FTP Verzeichnis " . $ftpFilepath . " kopiert.\n\n";

        if ($this->scriptOutputFile->deleteMe()) {
          $this->log .= "Temporäre Datei " . $this->scriptOutputFile->getFilepath() . " wurde gelöscht\n\n";
        } else {
          $this->error = true;
          $this->logStatus = $logStatus->getLogStatusId ('FEHLER');
          $this->log .= "Error: Temporäre Datei " . $this->scriptOutputFile->getFilepath() . " konnte nicht gelöscht werden!\n\n";
          exit();
        }

      } else {
        

        $this->error = true;
        $this->logStatus = $logStatus->getLogStatusId ('FEHLER');
        $this->log .= "Error: Beim kopieren der Datei auf den FTP-Server ist ein Fehler aufgetreten!\n\n";
        exit();
      }

    }

    public function copyScriptInputFileFromFtp ($ftpPath, $webserverPath) {
      require (Settings::getPublic('root_dir')."instances/LogStatus_inst.php");

      $this->scriptInputFile = new File ($webserverPath);
      
      if ($this->scriptInputFile->getFromFtp($ftpPath)) {
        $this->log .= "Datei " . $ftpPath . " wurde erfolgreich vom FTP-Server heruntergeladen.\nSpeicherort: " . $webserverPath . "\n\n";
      } else {
        $this->error = true;
        $this->logStatus = $logStatus->getLogStatusId ('FEHLER');
        $this->log .= "Error: Datei " . $ftpPath . " konnte nicht vom FTP-Server heruntergeladen werden!\n\n";
        exit();
      }

    }


  }

?>
