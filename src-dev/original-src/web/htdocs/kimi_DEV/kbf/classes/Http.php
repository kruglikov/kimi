<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : Http.php

* Purpose :

* Creation Date : 14-08-2015

* Last Modified : Son 16 Aug 2015 21:41:05 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");

  class Http {

    public $info;
    private $url;
    private $timeout = 5;
    public $responseHeaders;


    public function __construct ($url) {

      $this->url = $url;

    }

    public function getHtmlContent () {

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $this->url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
      $html = curl_exec($curl);
      $this->info = curl_getinfo ($curl);
      curl_close($curl);
      return $html;
    }

    public function getFile () {
      
      $targetPath = Settings::getPublic('dir_tmp');
      $filename = $targetPath . "tmpfile";
      $fileTarget = fopen ($filename, 'w');

      $error = false;
      
      $curl = curl_init($this->url);
      curl_setopt($curl, CURLOPT_TIMEOUT, 50);
      curl_setopt($curl, CURLOPT_FILE, $fileTarget);
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($curl, CURLOPT_HEADERFUNCTION, array(&$this, 'readHeader'));

      curl_exec($curl);

      if (curl_errno($curl)) {
        $error = true;
        /*
        foreach ($this->responseHeaders[$this->url] as $header) {
          if (preg_match ('/Content-Disposition: .*filename=([^ ]+)/', $header, $matches)) {
            //var_dump ($matches);
            rename ($filename, $targetPath . str_replace(" ", "%20",$matches[1]));
          }
        }*/
      }

      curl_close($curl);
      fclose($fileTarget);

      if ($error)  {
        delete ($filename);
        return false;
      }

      $newFilename = $targetPath . $this->getAttachmentFilename();
      //var_dump ($newFilename);
      rename ($filename, $newFilename);
      return $newFilename;
    }

    public function readHeader ($ch, $header) {
      $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
      $this->responseHeaders[$url][] = $header;
      return strlen($header);
    }

    public function getURL () {
      return $this->info['url'];
    }

    public function getContentType () {
      return $this->info['content_type'];
    }

    public function getHttpCode () {
      return $this->info['http_code'];
    }

    public function getAttachmentFilename () {

      //var_dump ($this->responseHeaders[$this->url]);
      $filename = '';
      foreach ($this->responseHeaders[$this->url] as $header) {
        if (preg_match ('/Content-Disposition: .*filename=([^ ]+)/', $header, $matches)) {
          $filename = $matches[1];
        }
      }

      //$filename = trim($filename, " ");
      $filename = preg_replace('/[\r\n]/', '', $filename);
      return $filename;

    }

  }

?>
