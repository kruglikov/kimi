<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : test_HTTP.php

* Purpose :

* Creation Date : 14-08-2015

* Last Modified : Fre 14 Aug 2015 17:32:50 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include_once (Settings::getPublic('root_dir')."classes/Http.php");

  //file_get_contents("http://www.google.at");
  //var_dump($http_response_header);

  $url1 = "http://gcvirsv03/kbf/test_scripts/buchungsjournalfile_test.php";
  $url2 = "http://gcvirsv03/kbf/test_scripts/test.php";
  $httpinfo = new Http ($url1);
  var_dump($httpinfo->getFile());
  //var_dump ($httpinfo->info);
  echo "< /br>< /br>";
  //var_dump ($httpinfo->header);
  //var_dump ($httpinfo->responseHeaders);
  var_dump ($httpinfo->getAttachmentFilename());

?>
