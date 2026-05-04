<?php  
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once './config/config.php';
include_once './libs/database.php';
/*
// Allgemeine globale Funktionen
function param($array, $name, $nullvalue = NULL) {
	if (isset($array[$name])) {
		return $array[$name];
	}
	return $nullvalue;
}

function isEmpty($value, $checkZero = false) {
	
	$result = false;
	
	if ($value == "" || $value == null) {
		$result = true;
	}
	elseif ($checkZero && $value = "0") {
		$result = true;
	}
	return $result;
}

*/
// Request Classe
/*class Request {

    private $mandantId;
    private $mandantName;
    private $benutzer;
    private $telefonGruppe;
	private $telefonNr;
	private $test;
	
	public $response;
  
  
  public function __construct($Params)
  {
    $this->mandantId = param($Params, "mandantId", "");
    $this->mandantName = param($Params, "mandantName", "");
    $this->benutzer = param($Params, "benutzer", "");
	$this->telefonGruppe = param($Params, "telefonGruppe", "");
	$this->telefonNr = param($Params, "telefonNr", "");
	$this->test = param($Params, "test", "");
	
	$this->response  = new Response();
  }  
  
//  public function getMandantId() {
//	  return $this->mandantId;
//  } 
 
  public function validateParams() {
	  
	  if ( isEmpty($this->getMandantId()) ) {
		  $this->response->setResponse(400, "", "Fehlende Mandantenkennung", "", "");
	  }
	  elseif ( isEmpty($this->getMandantName()) ) {
		  $this->response->setResponse(400, "", "Fehlender MandantenName", "", "");
	  }
	  elseif ( isEmpty($this->getBenutzer()) ) {
		  $this->response->setResponse(400, "", "Fehlender Benutzer", "","");
	  }
	  elseif ( isEmpty($this->getTelefonGruppe()) ) {
		  $this->response->setResponse(400, "", "Fehlender Telefongruppe", "", "");
	  }
	  elseif ( isEmpty($this->getTelefonNr()) ) {
		  $this->response->setResponse(400, "", "Fehlende Telefonnummer", "", "");
	  }
	  
	  return ($this->response->getResultCode() != 400 );
	  
  }
  
   
  public function getJsonResponse() {
	//  return json_encode($this->response, JSON_UNESCAPED_UNICODE);
	  
	return $this->response->getJsonResponse();
  }
 
  public function getMandantId()
  {
    return $this->mandantId;
  }
   public function getMandantName()
  {
    return $this->mandantName;
  }
  public function getBenutzer()
  {
    return $this->benutzer;
  }
   public function getTelefonGruppe()
  {
    return $this->telefonGruppe;
  }
   public function getTelefonNr()
  {
    return $this->telefonNr;
  }
   public function setMandantId($value)
  {
     $this->mandantId = $value;
  }
 
}
*/
// Response
class Response {
	
	private $response = array();
	
	public function __construct() {
		$this->response["success"] = true;
		$this->response["error_message"] = "";
	}  

	public function setSuccess($value) {
		$this->response["success"] = $value;
	}
	public function setErrorMessage($value) {
		$this->response["error_message"] = $value;
	}
	public function getSuccess() {
		return $this->response["success"];
	}
	
	public function getJsonResponse() {
		return json_encode($this->response, JSON_UNESCAPED_UNICODE);
	}
	
}

$errtext = "";
$isError = false;
$startTime = date('Y-m-d H:i:s');
$file = "./ajax/log/callinfo.log";

//$fh = fopen($file, "a");


//Make sure that it is a POST request.
/*if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) {
    //throw new Exception('Request method must be POST!');
	$errtext = 'Request method must be POST!';
}
*/

/*
//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if (strcasecmp($contentType, 'application/json') != 0) {
//    throw new Exception('Content type must be: application/json');
	$errtext = 'Content type must be: application/json';
	$isError = true;
}
*/
//Receive the RAW post data.
$content = file_get_contents("php://input", true);

file_put_contents($file,$startTime.': '.$content.PHP_EOL, FILE_APPEND);

//fwrite($fh, $startTime);
//fwrite($fh, $content);
//fclose($fh);


//Attempt to decode the incoming RAW post data from JSON.
$decoded = json_decode($content, true);

//If json_decode failed, the JSON is invalid.

if (!is_array($decoded)) {
    //throw new Exception('Received content contained invalid JSON!');
	$errtext = 'Received content contained invalid JSON!';
	$isError = true;
}

if ($isError) {
//	var_dump($decoded);	
	file_put_contents($file,$startTime.': FEHLER -> '.$errtext.PHP_EOL, FILE_APPEND);
}

$resp = new Response();

if ($errtext !== "") {
	$resp->setErrorMessage($errtext);	
	$resp->setSuccess(false);
}

echo $resp->getJsonResponse();

?>