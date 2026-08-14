<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : test_ftp.php

* Purpose :

* Creation Date : 06-08-2015

* Last Modified : Fre 07 Aug 2015 13:16:30 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  include ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include ($rootDir."instances/Ftp_inst.php");

  var_dump($ftp->connect());
  //var_dump($ftp->changeDirectory("kbf"));
  var_dump($ftp->getCurrentDirectory());
  //var_dump($ftp->getActualContent());
  //var_dump($ftp->exists("/phpinfo.phdp"));
  var_dump($ftp->makeDirectory ("/ftp_exchange/test_mkdir"));
  var_dump($ftp->getCurrentDirectory());
  //var_dump(explode(DIRECTORY_SEPARATOR, "/ftp_exchange/test_mkdir"));
  $ftp->close();

  var_dump(DIRECTORY_SEPARATOR);

  

?>
