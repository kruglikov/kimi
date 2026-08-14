<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : LogUser_inst.php

* Purpose :

* Creation Date : 06-08-2015

* Last Modified : Mit 12 Aug 2015 19:50:53 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include_once (Settings::getPublic('root_dir').'config/LogUser_config.php');

  $logUser = new LogUser();

?>
