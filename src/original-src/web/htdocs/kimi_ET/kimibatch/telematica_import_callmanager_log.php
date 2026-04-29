<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING);
//include_once './config/config.php';
include_once './db.php';


$errorFile = "../ajax/log/telematica_import_callmanager_log_error.log";

// Allgemeine globale Funktionen

function getTestData() {
	return '{
  "result": true,
  "data": [  

    {
      "id": "11249",
      "status": "MISSED",
      "cdr_unique_id": "1668626229.157336",
      "source_num": "436769531214",
      "target_num": "queue:groupqueue32_l1",
      "start_time": "2022-11-16 20:17:09",
      "connect_time": null,
      "end_time": "2022-11-16 20:17:13",
      "call_duration": 4,
      "talk_duration": 0,
      "client_reference": "",
      "project_reference": "INKO2016: Katharina            Pemmer",
      "ticket_reference": "-",
      "action_url": "https://10.196.69.11/kimi_ET/index.php?autologin=true&loginuser=userReferenz&mandant=18&kId=10&ticket_id=92769&site=ticket&selected_tickets=92769&selected_ticket_index=0",
      "pickup_user_id": "0",
      "outgoing_number": "436765032357"
    },

    {
      "id": "11245",
      "status": "ANSWERED",
      "cdr_unique_id": "1668615897.157300",
      "source_num": "436705051124",
      "target_num": "queue:groupqueue32_l1",
      "start_time": "2022-11-16 17:24:57",
      "connect_time": "2022-11-16 17:25:05",
      "end_time": null,
      "call_duration": 0,
      "talk_duration": 0,
      "client_reference": "",
      "project_reference": "INKO2016: Burak Emin Musa      Acikgoez",
      "ticket_reference": "2464",
      "action_url": "https://10.196.69.11/kimi_ET/index.php?autologin=true&loginuser=userReferenz&mandant=18&kId=10&ticket_id=91057&site=ticket&selected_tickets=91057&selected_ticket_index=0",
      "pickup_user_id": "9",
      "outgoing_number": "436765032357"
    },
    {
      "id": "11242",
      "status": "COMPLETED",
      "cdr_unique_id": "1668615023.157297",
      "source_num": "436605298551",
      "target_num": "queue:groupqueue61_l1",
      "start_time": "2022-11-16 17:10:24",
      "connect_time": null,
      "end_time": "2022-11-16 17:11:49",
      "call_duration": 85,
      "talk_duration": 0,
      "client_reference": "",
      "project_reference": "61 - Schlaustrom",
      "ticket_reference": "0",
      "action_url": "",
      "pickup_user_id": "0",
      "outgoing_number": "43732209961"
    },
    {
      "id": "11160",
      "status": "COMPLETED",
      "cdr_unique_id": "1668588662.156425",
      "source_num": "436509155586",
      "target_num": "queue:groupqueue27_l1",
      "start_time": "2022-11-16 09:51:03",
      "connect_time": "2022-11-16 09:51:08",
      "end_time": "2022-11-16 09:51:09",
      "call_duration": 6,
      "talk_duration": 1,
      "client_reference": "",
      "project_reference": "COEO INKASSO: Monika Wolkersberger",
      "ticket_reference": "46789",
      "action_url": "https://10.196.69.11/kimi_ET/index.php?autologin=true&loginuser=userReferenz&mandant=40&kId=34&ticket_id=90891&site=ticket&selected_tickets=90891&selected_ticket_index=0",
      "pickup_user_id": "5",
      "outgoing_number": "4315223124111"
    }
  ]
}';
}

function getDataFromUrl($startId, &$errmsg) {
	$errmsg = '';
	
	$auth = 'c82c7aa2b7a6aff583ef70ed3db2e672';
	$url = 'https://vbox6813.telematica.at/admin/apimodules/callmanager/?auth='.$auth.'&command=list';
	
	if ($startId > -1){
		$url = $url."&start_id=".$startId;
	}
	$result = file_get_contents($url);
	return $result;	

	
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_URL, $url);

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;	
}

function get_import_last_key($db, &$errMsg) {
	$result = 0;
	$errMsg = "";
	$sql = "select last_id from import_config_lastkeys where import_name = 'TELEMATICA_CALLMANAGER'";
	$res = mysqli_query($db, $sql);
	if (!$res) {
		$result = -1;
		$errMsg = mysqli_error($db)."\n".$sql;
	} else {
		$row = mysqli_fetch_array($res, MYSQLI_BOTH);
		$result = $row[0];
	}
	return $result;
}	
function set_import_last_key($db, $key, &$errMsg) {
	$result = true;
	$errMsg = "";
	$sql = "update import_config_lastkeys set last_id = ".$key." where import_name = 'TELEMATICA_CALLMANAGER'";

	if (!mysqli_query($db, $sql)) {
		$result = false;
		$errMsg = mysqli_error($db)."\n".$sql;
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
	$this->status = $Params->status;
	$this->cdr_unique_id = $Params->cdr_unique_id;
	$this->source_num = $Params->source_num;
	$this->target_num = $Params->target_num;
	$this->start_time = $Params->start_time;
	$this->connect_time = $Params->connect_time;
	$this->end_time = $Params->end_time;	
	$this->call_duration = $Params->call_duration;
	$this->talk_duration = $Params->talk_duration;
	$this->client_reference = $Params->client_reference;
	$this->project_reference = $Params->project_reference;
	$this->ticket_reference = $Params->ticket_reference;
	$this->action_url = $Params->action_url;
	$this->pickup_user_id = $Params->pickup_user_id;
	$this->outgoing_number = $Params->outgoing_number;
	$this->id = $Params->id;

	$this->mandantId = 0;
	$this->ticketId = 0;
	$this->dauer_sec = 0;
	
	if ($this->ticket_reference === "") {
		$this->ticket_reference = 0;
	}

	if ($this->start_time != "") {
		$setTime = false;
		$diff = 0;
		if ($this->end_time != "") {
			$this->dauer_sec  = strtotime($this->end_time) - strtotime($this->start_time);
		} elseif($this->connect_time != "") {
			$this->dauer_sec  = strtotime($this->connect_time) - strtotime($this->start_time);			
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
	  $pos = strpos($value, $search);
	  if ($pos !== false) {
		  $pos2 = strpos($value, '&', $pos);
		  if ($pos2 !== false) {
			  $ret = substr($value, $pos+strlen($search), $pos2-$pos-strlen($search));
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
			"'$this->client_reference', '$this->project_reference', '$this->ticket_reference', '$this->action_url', '$this->pickup_user_id',  ".
			"'$this->outgoing_number', $this->id, $this->mandantId, $this->ticketId, $this->dauer_sec)";
			
		if (!mysqli_query($db, $sql)) {
			$result = false;
			$errMsg = mysqli_error($db)."\n".$sql;
		}
		return $result;
	} 
} 


$errText = "";
$startTime = date('Y-m-d H:i:s');

$heute = date("d.m.Y H:i:s");    
echo "TELEMATICA - IMPORT CALLMANAGER - Start: ".$heute;
echo "<br><b>telematica_import_callmanager</b><br><br>";

$last_key = get_import_last_key($dbconn, $errText);
if ($errText != '') {
	echo "FEHLER get_import_last_key; ".$errText."<br>";
	exit;
}


//$data = getTestData();
$data = getDataFromUrl($last_key, $errText);

$hasData = false;
if ($data != '' && $data != null) {
	$obj = json_decode($data);
	$dataarr = $obj->data;
	$hasData = true;
}

$i = 0;
$count = 0;
$count_log = 0;
$error = 0;

$savelast_key = $last_key;

if ($hasData && $obj->result === true) {
	$count = count($dataarr);
	for ($i = 0; $i < $count; $i++) {
		//echo $i."\n";
		$item = $dataarr[$i];
		//var_dump($item);
		//echo "ID: ".$item["id"]."\n";
		$request = new Request($dataarr[$i]);

		$mId = 0;
		$tId = 0;

		$ret = $request->getTicketInfo($request->getActionUrl(), $mId, $tId);

		if ($ret == true ) {
			$request->setMandantId($mId);
			$request->setTicketId($tId);
		}	
		$errText = "";
		$ret = $request->insert_callmanager($dbconn, $errText);
		
		if (!$ret) {
			//echo $errText."<br>";
			$error = $error + 1;
			file_put_contents($errorFile,$startTime.':ERROR->'.$errText.PHP_EOL, FILE_APPEND);
			file_put_contents($errorFile,$startTime.':DATA->'.var_export($dataarr[$i], true).PHP_EOL, FILE_APPEND);
		}
		
		$aktkey = $request->getId();
		
		if ($aktkey > $last_key) {
			$last_key = $aktkey;
		}

	}
}

if ($last_key > $savelast_key) {
	if (!set_import_last_key($dbconn, $last_key, $errText)) {
		echo "FEHLER set_import_last_key; ".$errText."<br>";
	}
}

mysqli_close($dbconn);

echo "Anzahl importiert: ".$count-$error." <br>";
if ($error > 0) {
	echo "<span style='color: #FF0000;'>";
	echo "<b>Anzahl Fehler: ".$error."</b> <br>";
	echo "</span>";
}
echo "<br><br>"."TELEMATICA - IMPORT CALLMANAGER - Ende: ".$heute;



?>