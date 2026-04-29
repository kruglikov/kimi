<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once './config/config.php';
include_once './libs/database.php';

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

function getTicketIdFromPhone ($dbconn, $queueName, $phoneNo, &$ticket_id, &$mandant_name, &$projekt, &$ticketNr, &$mandantId, &$kampId ) {
    $ticket_id = "";
    $ticketData = FALSE;
    $result = FALSE;
    $row = FALSE;
	
	$return = FALSE;
	
   
    $mandant_id = 0;
	$mandant_name = "";
	$projekt = "";
	$mandant_lvorwahl = "43";

    if ($queueName != "" & $queueName != null ) {
        // Ermittle Mandant-ID
        $sql = "select id, text, getCleanPhoneNoN('$phoneNo', '', false) phoneNo from mandant where clid_name = '$queueName';";
        $result = mysqli_query($dbconn, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row!=false) {
			
            $mandant_id = $row['id'];
            $phoneNo = $row['phoneNo'];
			$mandantName = $row['text'];
			$mandant_name = $mandantName;
        }
		//20230412/ab
		//                     " and (getCleanPhoneNoN(search_telnr1, $mandant_lvorwahl, false) = '$phoneNo' or getCleanPhoneNoN(search_telnr2, $mandant_lvorwahl, false) = '$phoneNo') ". 

        if ($mandant_id != 0 & $mandant_id != "" & $mandant_id != null & $phoneNo != ""){
            $sql = "select if(s.text='offen', 1, if(s.text='in Bearbeitung', 2, 3)) status, t.id ticket_id, ticketnr, kimi_decrypt(vorname) vname, kimi_decrypt(nachname) nname, t.mandant_id, t.kampagne_id from ticket t ".
                    " left join status s on s.id = t.status_id ". 
                    " where t.mandant_id = $mandant_id ".
                    " and (search_telnr1 = '$phoneNo' or search_telnr2 = '$phoneNo') ". 
                    " order by 1 asc, 2 desc; ";
                    $result = mysqli_query($dbconn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    if ($row!=false) {
                        $ticket_id = $row['ticket_id'];
						$ticketNr = $row['ticketnr'];
						$projekt = $row['vname'] . " " . $row['nname'];
						$projekt = trim($projekt);
						$projekt = $mandantName.": ".$projekt;

						$mandantId = $row['mandant_id'];
						$kampId = $row['kampagne_id'];
						$return = TRUE;
						// 20230409
                    } elseif ($mandant_id == 2 | $mandant_id == "2") {
						$statusOffen = 5;
						$statusBearbeitung = 6;
						// Lese leeres Ticket
						$sql = "SELECT 1, t.id ticket_id, ticketnr, kimi_decrypt(vorname) vname, kimi_decrypt(nachname) nname, 
							t.mandant_id, t.kampagne_id from ticket t ".
							 " where t.mandant_id = $mandant_id ".
							 " and status_id = $statusOffen  ".
							 " order by ticketnr ";
						$result = mysqli_query($dbconn, $sql);
						$row = mysqli_fetch_assoc($result);
						if ($row!=false) {
							// Update Status
							$sql = "UPDATE ticket set status_id = $statusBearbeitung ".
								" WHERE id = ".$row['ticket_id'];
							mysqli_query($dbconn, $sql);
							
							$ticket_id = $row['ticket_id'];
							$ticketNr = $row['ticketnr'];
							$projekt = $row['vname'] . " " . $row['nname'];
							$projekt = trim($projekt);
							$projekt = $mandantName.": ".$projekt;

							$mandantId = $row['mandant_id'];
							//20230508/ar
							$kampId = $row['kampagne_id'];

							$return = TRUE;
						}
					}	
        }
    }
	return $return;
}


// Request Classe
class Request {

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

// Response
class Response {
	
	private $response = array();
	
	public function __construct() {
		$this->response["resultCode"] = "";
		$this->response["url"] = "";
		$this->response["text"] = "";
		$this->response["mandant"] = "";
		$this->response["ticketNr"] = "";
	}  

	public function setResultCode($value) {
		$this->response["resultCode"] = $value;
	}
	public function setUrl($value) {
		$this->response["url"] = $value;
	}
	public function setText($value) {
		$this->response["text"] = $value;
	}

	public function setMandant($value) {
		$this->response["mandant"] = $value;
	}	
	public function setTicketNr($value) {
		$this->response["ticketNr"] = intval($value);
	}	
	public function setResponse($resultCode, $url, $text, $mandant, $ticketNr) {
		$this->setResultCode($resultCode);
		$this->setUrl($url);
		$this->setText($text);
		$this->setMandant($mandant);
		$this->setTicketNr($ticketNr);
	}
	public function getResultCode() {
		return $this->response["resultCode"];
	}
	
	public function getJsonResponse() {
		return json_encode($this->response, JSON_UNESCAPED_UNICODE);
	}
	
}
// Übergabeparameter zuordnen
$request = new Request($_GET );
/*
$ret = $request->getResp();
var_dump($ret->getResultCode());
exit;
*/
// Valutierung der Werte
if (!$request->validateParams()) {
	echo $request->response->getJsonResponse();
	exit;
}


// DB-connection
$dbconn = mysqli_connect(CONF_MYSQL_SERVER, CONF_MYSQL_USER, CONF_MYSQL_PASSWORD);
mysqli_set_charset($dbconn, 'utf8');
mysqli_select_db($dbconn, CONF_MYSQL_DB);
mysqli_set_charset($dbconn, 'utf8');

$mandant_name = "";
$projekt = "";
$ticket_id = "";
$ticketNr = "";
$ergMandantId = "";
$ergKampId = "";


if (getTicketIdFromPhone($dbconn, $request->getTelefonGruppe(), $request->getTelefonNr(), $ticket_id, $mandant_name, $projekt, $ticketNr, $ergMandantId, $ergKampId)) {
	$request->response->setResponse(200, "https://10.196.69.11/kimi_ET/index.php?autologin=true&loginuser=userReferenz&mandant=".$ergMandantId."&kId=".$ergKampId."&ticket_id=".$ticket_id."&site=ticket&selected_tickets=".$ticket_id."&selected_ticket_index=0", 
	$projekt, 
	$mandant_name,
	$ticketNr);
} else {
	if ($mandant_name == "") {
		$request->response->setResponse(402, "", "Telefongruppe ". $request->getTelefonGruppe(). " nicht gefunden", "", "");	
	} else {
		$request->response->setResponse(204, "", "", "", "");		
	}
	
}

mysqli_close($dbconn);

// $response = new Response();
/*$request->response->setResponse(200, "https://10.196.69.21/kimidev_ET/index.php?autologin=true&loginuser=userReferenz&mandant=16&kId=8&ticket_id=1382&site=ticket&selected_tickets=1382&selected_ticket_index=0", 
	"Testlink auf Entwicklungsumgebung",
	$mandant_name,
	$ticketNr);
*/
echo $request->response->getJsonResponse();

?>