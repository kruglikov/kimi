<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING);
include_once './config/config.php';
//include_once './kimibatch/db.php';


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
	elseif ($checkZero && $value == "0") {
		$result = true;
	}
	return $result;
}




// Request Classe
class Request {
	private $status;
    private $cdr_unique_id;
    private $source_num;
    private $target_num;
    private $start_time;
	private $connect_time;
	private $end_time;
	private $call_duration;
	private $talk_duration;
	private $client_reference;
	private $project_reference;
	private $ticket_reference;
	private $action_url;
	private $pickup_user_id;
	private $outgoing_number;
	private $id;
	//
	private $mandantId;
	private $ticketId;
	private $dauer_sec;
	
	public $response;

  
	public function __construct($Params)
	{
	$this->status = param($Params, "status", "");
	$this->cdr_unique_id = param($Params, "cdr_unique_id", "");
	$this->source_num = param($Params, "source_num", "");
	$this->target_num = param($Params, "target_num", "");
	$this->start_time = param($Params, "start_time", "");
	$this->connect_time = param($Params, "connect_time", "");
	$this->end_time = param($Params, "end_time", "");	
	$this->call_duration = param($Params, "call_duration", "");
	$this->talk_duration = param($Params, "talk_duration", "");
	$this->client_reference = param($Params, "client_reference", "");
	$this->project_reference = param($Params, "project_reference", "");
	$this->ticket_reference = param($Params, "ticket_reference", "");
	$this->action_url = param($Params, "action_url", "");
	$this->pickup_user_id = param($Params, "pickup_user_id", "");
	$this->outgoing_number = param($Params, "outgoing_number", "");
	$this->id = param($Params, "id", "");

	$this->mandantId = 0;
	$this->ticketId = 0;
	$this->dauer_sec = 0;

	if ($this->start_time != "") {
		$setTime = false;
		$diff = 0;
		if ($this->end_time != "") {
			$this->dauer_sec  = strtotime((string) $this->end_time) - strtotime((string) $this->start_time);
		} elseif($this->connect_time != "") {
			$this->dauer_sec  = strtotime((string) $this->connect_time) - strtotime((string) $this->start_time);			
		}

	}

	//$this->response  = new Response();
	}  


	public function getJsonResponse() {
	//  return json_encode($this->response, JSON_UNESCAPED_UNICODE);
	  
	return $this->response->getJsonResponse();
	}

	public function getItemValue($value, $search) {
	  
	  $ret = "";
	  $pos = strpos((string) $value, (string) $search);
	  if ($pos !== false) {
		  $pos2 = strpos((string) $value, '&', $pos);
		  if ($pos2 !== false) {
			  $ret = substr((string) $value, $pos+strlen((string) $search), $pos2-$pos-strlen((string) $search));
		  }
	  }
	  return $ret;
	}

	public function getTicketInfo($urlLink, &$mandant_id, &$ticket_id) {
	  $mandant_id = 0;
	  $ticket_id = 0;
	  if ($urlLink != "") {
		$mandant_id = $this->getItemValue($urlLink, 'mandant=');
		$ticket_id = $this->getItemValue($urlLink, 'ticket_id=');
		return true;
	  } 
	  return false;
	}


	public function getStatus()
	{
		return $this->status;
	}
	public function getCdrUniqueId()
	{
		return $this->cdr_unique_id;
	}
	public function getSourceNum()
	{
		return $this->source_num;
	}
	public function getTargetNum()
	{
		return $this->target_num;
	}  
	public function getStartTime()
	{
		return $this->start_time;
	}
	public function getConnectTime()
	{
		return $this->connect_time;
	}
	public function getEndTime()
	{
		return $this->end_time;
	}
	public function getCallDuration()
	{
		return $this->call_duration;
	}
	public function getTalkDuration()
	{
		return $this->talk_duration;
	}
	public function getClientReference()
	{
		return $this->client_reference;
	}
	public function getProjectReference()
	{
		return $this->project_reference;
	}
	public function getTicketReference()
	{
		return $this->ticket_reference;
	}
	public function getActionUrl()
	{
		return $this->action_url;
	}
	public function getPickupUserId()
	{
		return $this->pickup_user_id;
	}
	public function getOutgoingNumber()
	{
		return $this->outgoing_number;
	}
	public function getId()
	{
		return $this->id;
	}

	public function setMandantId($value)
	{
		$this->mandantId = $value;
	}
	public function setTicketId($value)
	{
		$this->ticketId = $value;
	}
	public function setDauer($value)
	{
		$this->dauer_sec = $value;
	}

	public function insert_callmanager($db, &$errMsg) {
		$result = true;
		$errMsg = "";
		$sql = "insert into callmanager_log (status, timestamp, cdr_unique_id, source_num, target_num, start_time, connect_time, end_time, call_duration, talk_duration, ".
			"client_reference, project_reference, ticket_reference, action_url, pickup_user_id, outgoing_number, call_id, mandant_id, ticket_id, dauer_sec)".
			" values ('$this->status', sysdate(), '$this->cdr_unique_id','$this->source_num','$this->target_num', '$this->start_time', '$this->connect_time', ".
			"'$this->end_time', '$this->call_duration', '$this->talk_duration',".
			"'$this->client_reference', '$this->project_reference', $this->ticket_reference, '$this->action_url', '$this->pickup_user_id',  ".
			"'$this->outgoing_number', $this->id, $this->mandantId, $this->ticketId, $this->dauer_sec)";
			/*
			"'$this->client_reference', '$this->project_reference', '$this->ticket_reference', '$this->$action_url', '$this->pickup_user_id',";
			$sql.="'$this->outgoing_number', $this->id, $this->mandant_id, $this->ticket_id, $this->dauer_sec)";
			*/
		//$sql = "insert into callmanager_call (status, cdr_unique_id, source_num) values ('$this->status', '$this->cdr_unique_id','$this->source_num') ";
		if (!mysqli_query($db, $sql)) {
			$result = false;
			$errMsg = mysqli_error($db)."\n".$sql;
		}
		return $result;
	} 
} 

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

$errText = "";
$startTime = date('Y-m-d H:i:s');
$file = "./ajax/log/callinfo.log";

$request = new Request($_POST);

$mId = 0;
$tId = 0;

$ret = $request->getTicketInfo($request->getActionUrl(), $mId, $tId);

if ($ret == true ) {
	$request->setMandantId($mId);
	$request->setTicketId($tId);
}

$debug = var_export($request, true);
file_put_contents($file,$startTime.': DATA->'.$debug.PHP_EOL, FILE_APPEND);

$resp = new Response();

$dbconn = mysqli_connect(CONF_MYSQL_SERVER, CONF_MYSQL_USER, CONF_MYSQL_PASSWORD);
mysqli_set_charset($dbconn, 'utf8');
mysqli_select_db($dbconn, CONF_MYSQL_DB);
mysqli_set_charset($dbconn, 'utf8');
mysqli_options($dbconn, MYSQLI_OPT_LOCAL_INFILE, true);

$errText = "";
$ret = $request->insert_callmanager($dbconn, $errText);

mysqli_close($dbconn);

if ($errText !== "") {
	$resp->setErrorMessage($errText);	
	$resp->setSuccess(false);
//	file_put_contents($file,$startTime.':DATA->'.$debug.PHP_EOL, FILE_APPEND);
	file_put_contents($file,$startTime.':ERROR->'.$errText.PHP_EOL, FILE_APPEND);
}

echo $resp->getJsonResponse();

?>