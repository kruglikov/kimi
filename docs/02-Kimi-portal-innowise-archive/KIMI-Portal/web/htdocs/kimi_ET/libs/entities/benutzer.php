<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of benutzer
 *
 * @author Ronald
 */
class Benutzer {

    private $item;

    public function get_id() {
        return $this->item["id"];
    }
    public function _get_id() {
        return $this->item->id;
    }

    public function _get_name() {
        return $this->item->name;
    }
    
    public function get_name($sql_valid = FALSE) {
        if (!isset($this->item["name"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["name"]) . "'";
        }
        return $this->item["name"];
    }

    public function get_passwort($sql_valid = FALSE) {
        if (!isset($this->item["passwort"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["passwort"]) . "'";
        }
        return $this->item["passwort"];
    }

    public function get_letzter_mandant_id($sql_valid = FALSE) {
        if (!isset($this->item["letzter_mandant_id"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        return $this->item["letzter_mandant_id"];
    }

    public function get_gruppe($sql_valid = FALSE) {
        if (!isset($this->item["gruppe"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["gruppe"]) . "'";
        }
        return $this->item["gruppe"];
    }

    public function get_nachname($sql_valid = FALSE) {
        if (!isset($this->item["get_nachname"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["get_nachname"]) . "'";
        }

        return $this->item["nachname"];
    }

    public function get_vorname($sql_valid = FALSE) {
        if (!isset($this->item["get_vorname"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["get_vorname"]) . "'";
        }

        return $this->item["vorname"];
    }

    public function get_email($sql_valid = FALSE) {
        if (!isset($this->item["get_email"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["get_email"]) . "'";
        }

        return $this->item["email"];
    }

    public function get_telefon($sql_valid = FALSE) {
        if (!isset($this->item["get_telefon"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["get_telefon"]) . "'";
        }

        return $this->item["telefon"];
    }

    public function get_iptel_durchwahl($sql_valid = FALSE) {
        if (!isset($this->item["get_iptel_durchwahl"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["get_iptel_durchwahl"]) . "'";
        }

        return $this->item["iptel_durchwahl"];
    }

	
    public function get_sprache($sql_valid = FALSE) {
        if (!isset($this->item["get_sprache"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["get_sprache"]) . "'";
        }

        return $this->item["sprache"];
    }

    public function get_land($sql_valid = FALSE) {
        if (!isset($this->item["get_land"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["get_land"]) . "'";
        }

        return $this->item["land"];
    }
    
    public function get_default_belegdatum($sql_valid = FALSE) {
        if (!isset($this->item["default_belegdatum"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["default_belegdatum"]) . "'";
        }

        $date = date_create($this->item["default_belegdatum"]);
        return date_format($date, "d.m.Y");
    }

    public function set_default_belegdatum($value) {
        if (strlen(default_belegdatum) == 0) {
            $this->item["default_belegdatum"] = NULL;
            return;
        }

        $date = date_create($value);
        $this->item["default_belegdatum"] = date_format($date, "Y-m-d");
    }

    public function get_default_bua_bgr_key($sql_valid = FALSE) {
        if (!isset($this->item["default_bua_bgr_key"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["default_bua_bgr_key"]) . "'";
        }
        return $this->item["default_bua_bgr_key"];
    }

    public function set_default_bua_bgr_key($value) {
        $this->item["default_bua_bgr_key"] = $value;
    }



    public function __construct($item) {
        $this->item = $item;
    }

    public static function load_items($mandant_id, $start, $count) {

        $query = "SELECT b.* FROM benutzer b "
                . " JOIN mandant_benutzer mb ON mb.benutzer_id = b.id"
                . " WHERE mb.mandant_id = $mandant_id ORDER BY name";
        $result = array();
        $response = App::$CURRENT->DB->query($query);

        try {
            $items = App::$CURRENT->DB->query($query);
            $benutzer = array();
            foreach ($items as $value) {
                array_push($benutzer, new Benutzer($value));
            }

            if (count($benutzer) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $benutzer;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
        return $result;
    }
	
    public static function get($id) {
        $query = "SELECT b.* FROM benutzer b WHERE b.id = $id";

        try {
            $response = App::$CURRENT->DB->singleObjectQuery($query);
            return new Benutzer($response, TRUE);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function load_all($mandant_id) {

        $query = "SELECT b.* FROM benutzer b "
                . " JOIN mandant_benutzer mb ON mb.benutzer_id = b.id"
                . " WHERE mb.mandant_id = $mandant_id ORDER BY name";

        $result = array();
        $response = App::$CURRENT->DB->query($query);

        foreach ($response as $item) {
            array_push($result, new Benutzer($item));
        }
        return $result;
    }

    public static function update_default_werte($user_id, $belegdatum, $bua_bgr_key) {
        if ($user_id==NULL || $user_id == '') {
            return TRUE;
        }
        if ($belegdatum == '' || $belegdatum == NULL) {
            $belegdatum = "NULL";
        } else {
            $date = date_create($belegdatum);
            $belegdatum = "'".date_format($date, "Y-m-d")."'";
            
        }
        
        if ($bua_bgr_key == '' || $bua_bgr_key == '0' || $bua_bgr_key == NULL) {
            $bua_bgr_key = "NULL";
        } else {
            $bua_bgr_key = "'".$bua_bgr_key."'";
        }
        
        try {
            $query = "UPDATE `benutzer` 
            SET `default_belegdatum`=" . $belegdatum . ",
            `default_bua_bgr_key`=" . $bua_bgr_key . "
             WHERE id = " . $user_id;

            App::$CURRENT->DB->query($query, FALSE);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            return FALSE;
        }
        return TRUE;
    }

    
}

?>