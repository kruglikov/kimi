<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : kbf_script_template.php

* Purpose :

* Creation Date : 14-08-2015

* Last Modified : Son 16 Aug 2015 21:34:06 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  require_once (Settings::getPublic('root_dir')."classes/KimiBatch.php");


    /*Template für die Erstellung von Kimi Batch Framework-Scripts

    Verfügbare Funktionen:
      + Constructor: KimiBatch(String $activity)
        Parameter
          $activity muss in der Datenbank angelegt sein!
        
        Ein neues KimiBatch Objekt erstellen;

      + executeHttpScript (String $scriptURL, boolean $scriptReturnFile=false)
        Parameter:
          $scriptURL muss eine Gültige URL sein mit http://;
          $scriptReturnFile ist standardmäßig false, und ist auf true zu setzen, wenn das auszuführende Skript einen Datei-Download zur Verfügung stellt;

        Ruft ein Batch Skript über http auf.

      + copyScriptOutputFileToFtp (String $ftpPath, boolean $bookingDateDir=true)
        Parameter:
          $ftpPath Pfad zum Verzeichnis auf dem FTP-Server;
          $bookingDateDir wenn true wird ein Buchungstag-Ordner erstellt;
        
        Funktion um eine Datei die von einem Skript erstellt wurde auf den FTP-Server zu kopieren. Diese Funktion darf nur nach der Funktion executeHttpScript ausgeführt werden und nur dann wenn diese Funktion eine Datei zurückliefert ( $scriptReturnFile === true )

      + copyScriptInputFileFromFtp (String $ftpFilepath, String $filepath)
        Parameter:
          $ftpFilepath: Pfad zu einer Datei auf dem FTP-Server
          $filepath: Pfad, wohin die Datei kopiert werden soll mit Dateinamen

        Funktion um eine Datei vom FTP-Server auf den Webserver zu kopieren. Diese Funktion ist für IMPORT-Skripte gedacht, die sich Dateien in einem bestimmten Verzeichnis erwarten. Diese Funktion sollte vor der Funktion executeHttpScript ausgeführt werden.


        -------------Beispiele-------------

        ---Skriptaufruf mit HTML-Output---

          $kb = new KimiBatch ("CHECK Verarbeitung Buchungstag durchführen");
          $kb->executeHttpScript("http://HOST/PFAD_ZUR_DATEI/SKRIPT.php", false);

        ---Skriptaufruf mit Datei-Output---

          $kb = new KimiBatch ("CHECK Verarbeitung Buchungstag durchführen");
          $kb->executeHttpScript("http://HOST/PFAD_ZUR_DATEI/SKRIPT.php", false);
          $kb->copyScriptOutputFileToFtp(Settings::getPublic('toFtp_test'), true);

        ---Skriptaufruf mit Datei-Input---

          $kb = new KimiBatch ("CHECK Verarbeitung Buchungstag durchführen");
          $kb->copyScriptInputFileFromFtp (Settings::getPublic('ftpFrom_test')."/phpinfo.php", Settings::getPublic('root_dir')."tmp/phpinfo.php");
          $kb->executeHttpScript("http://HOST/PFAD_ZUR_DATEI/SKRIPT.php", false);

        ---Mehrere Skripte aufrufen---

          $kb1 = new KimiBatch ("Buchungsjournal File");
          $kb1->executeHttpScript("http://HOST/PFAD_ZUR_DATEI/buchungsjournalfile.php", false);
          $kb1->copyScriptOutputFileToFtp(Settings::getPublic('toFtp_test'), true);

          $kb2 = new KimiBatch ("Zahlungsjournal File");
          $kb2->executeHttpScript("http://HOST/PFAD_ZUR_DATEI/zahlungsjournalfile.php", false);
          $kb2->copyScriptOutputFileToFtp(Settings::getPublic('toFtp_test'), true);

        ----------------------------------

  */


  

?>
