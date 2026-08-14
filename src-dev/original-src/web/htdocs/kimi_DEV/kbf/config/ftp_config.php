<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : ftp_config.php

* Purpose :

* Creation Date : 04-08-2015

* Last Modified : Mit 12 Aug 2015 17:13:25 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");

  $ftp_config = array (
    'host' => 'gcvirsv03',
    'port' => 21,
    'timeout' => 90,
    'ssl' => true,
    'user' => 'ftpuser',
    'password' => 'ftpuser',
    'passiveMode' => false, 
    'transferMode' => FTP_ASCII, //FTP-Transfermodus: FTP_ASCII oder FTP_BINARY
  );

?>
