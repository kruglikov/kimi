<?php

/*
  $files = scandir("./libs./entities");

  foreach ($files as $file) {
  require_once './libs/entities'.$file;
  } */


require_once './libs/entities/user.php';
require_once './libs/entities/role.php';
require_once './libs/entities/mandant.php';
require_once './libs/entities/permission.php';
require_once './libs/entities/menu_item.php';
require_once './libs/entities/portal_text.php';
require_once './libs/entities/customer.php';
require_once './libs/entities/anrede.php';
require_once './libs/entities/titel.php';
require_once './libs/entities/country.php';
require_once './libs/entities/stammdaten.php';
require_once './libs/entities/subkonto.php';
require_once './libs/entities/buchungsgrund.php';
require_once './libs/entities/zahlart.php';
require_once './libs/entities/buchungsart.php';
require_once './libs/entities/ticket.php';
require_once './libs/entities/text.php';
require_once './libs/entities/buchungen.php';
require_once './libs/entities/ra_ikbuero.php';
require_once './libs/entities/ausbuchungsgrund.php';
require_once './libs/entities/erled_qual.php';
require_once './libs/entities/inkassostatus.php';
require_once './libs/entities/verwaltungssatz.php';
require_once './libs/entities/inkassoinformation.php';
require_once './libs/entities/anstoss.php';
require_once './libs/entities/kategorie.php';
require_once './libs/entities/kundenhistorie.php';
require_once './libs/entities/benutzer.php';
require_once './libs/entities/schadensfall_art.php';
require_once './libs/entities/status_schadensfall.php';
require_once './libs/entities/versicherung.php';
require_once './libs/entities/schadensfall.php';
require_once './libs/entities/lastschrift.php';
require_once './libs/entities/bankleitzahl.php';
require_once './libs/entities/ratenrechner.php';
require_once './libs/entities/kampagne.php';
require_once './libs/entities/log.php';
require_once './libs/entities/ticket_historie.php';
require_once './libs/entities/akt.php';
// 20160710/Roni
require_once './libs/entities/anrufzeiten.php';

function throw_exception($message = null, $code = null) {
    throw new Exception($message, $code);
}


class App {

    /**
     * @var App
     */
    public static $CURRENT;
    public $ERRORS;
    public $INFORMATION;

    /**
     * @var DB
     */
    public $DB;

    /**
     * @var User
     */
    public $USER;

    /**
     * @var Mandant
     */
    public $MANDANT;

    function __construct() {
        $this->ERRORS = array();
        $this->INFORMATION = array();
        $this->DB = new DB();
    }

    public function add_error($message) {
        array_push($this->ERRORS, $message);
    }

    public function add_information($message) {
        array_push($this->INFORMATION, $message);
    }

    public function has_permission($site, $permission) {
        if (!CONF_USER_PERMISSION) {
            return true;
        }
        $user = $this->USER;
        $mandant = $this->MANDANT;

        $role = Role::get_role($user, $mandant);
        $permissions = Permission::get_permissions($role->get_id(), $site . '.php', $permission);

        return count($permissions) > 0;
    }
	//20211216
	public function isEncryptionEnabled() {
		$return = FALSE;
		//return TRUE;
		if (defined('CONF_ENCRYPTION_MANDANT_ID') != TRUE) {
			return true;
		}
	
		$pos = strpos(",".CONF_ENCRYPTION_MANDANT_ID.",", ",".$this->MANDANT->get_id().",");
	
		
		if ($pos === FALSE) {
			$return = FALSE;
		} else {
			$return = TRUE;
		}
		
		return $return;
	} 
}

App::$CURRENT = new App();

?>
