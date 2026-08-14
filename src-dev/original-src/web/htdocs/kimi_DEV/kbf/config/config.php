<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : config.php

* Purpose :

* Creation Date : 23-07-2015

* Last Modified : Mon 17 Aug 2015 20:07:25 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  //set error message
  error_reporting(E_ALL);
	ini_set("display_errors", true);
  //mb_internal_encoding("UTF-8");

  require_once ($_SERVER['DOCUMENT_ROOT'] . "/kimi/kimi_ET/kbf/classes/Settings.php");


  //general framework settings -- don't change
  Settings::setPublic('kbf_home', "/kimi/kimi_ET/kbf/");
  Settings::setPublic('root_dir', $_SERVER['DOCUMENT_ROOT'] . Settings::getPublic('kbf_home'));
  Settings::setPublic('http_home', "http://".$_SERVER['HTTP_HOST'].Settings::getPublic('kbf_home'));
  Settings::setPublic('html_home', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);
  

  //db settings
  Settings::setProtected('db_user', 'kimi');
  Settings::setProtected('db_pwd', 'KimiPlus@13');
  Settings::setProtected('db_host', '192.168.100.14');
  Settings::setProtected('db_name', 'kimi_BatchFramework');
  Settings::setProtected('db_port', ini_get('mysqli.default_port')); //mysql default
  Settings::setProtected('db_socket', ini_get('mysqli.default_socket')); //mysql default
  Settings::setProtected('db_charset', 'utf8');


  //ftp settings

  Settings::setProtected('ftp_host', '192.168.100.10');
  Settings::setProtected('ftp_port', 21);
  Settings::setProtected('ftp_timeout', 90);
  Settings::setProtected('ftp_ssl', false);
  Settings::setProtected('ftp_user', 'Kimi-Ftp');
  Settings::setProtected('ftp_pwd', 'Imik4020ptf');
  Settings::setProtected('ftp_passiveMode', true);
  Settings::setProtected('ftp_transferMode', FTP_ASCII); //FTP-Transfermodus: FTP_ASCII oder FTP_BINARY


  //temp directory
  Settings::setPublic('dir_tmp', Settings::getPublic('root_dir') . "tmp/");
  
  //ftp directory locations for file output
  Settings::setPublic('toFtp_test', '/ftp_exchange/to_ftp');

  
  //ftp directory locations for file input
  Settings::setPublic('fromFtp_test', '/ftp_exchange/from_ftp');

  
  //FS directory locations for file input



?>
