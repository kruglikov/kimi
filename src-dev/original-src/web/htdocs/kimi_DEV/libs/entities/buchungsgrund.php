<?php
/*
 * To change this template, choose Tools | Templates 
 * and open the template in the editor.
 */

/**
 * Description of buchungsgrund
 * 
 * @author David
 */

class Buchungsgrund {

    private $item;
    
    public function get_id() {
        return $this->item->id;
    }

    public function get_text() {
        return $this->item->text;
    }

    public function get_kontoauszugstext() {
        return $this->item->kontoauszugstext;
    }

    public function get_plusminus() {
        return $this->item->kz_berechnung;
    }

    
    public function get_buchungsart_id() {
        return $this->item->buchungsart_id;
    }

    public function get_bgr_man_id() {
        return $this->item->bua_bgr_man_id;
    }

    public function get_bugru_key() {
        return $this->item->bugru_key;
    }

    public function get_bugru_key_om() {
        return $this->item->bugru_key_om;
    }

    public function get_buart_text() {
        return $this->item->buart_text;
    }

    public function get_buabgr_man_id() {
        return $this->item->bua_bgr_man_id;
    }

    public function get_kz_berechnung($sql_valid = FALSE) {
        if (!isset($this->item["kz_berechnung"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["kz_berechnung"];
    }

    public function get_kz_bearbeitung($sql_valid = FALSE) {
        if (!isset($this->item["kz_bearbeitung"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["kz_bearbeitung"];
    }

    
    public function get_kz_subkonto($sql_valid = FALSE) {
        if (!isset($this->item["kz_subkonto"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["kz_subkonto"];
    }
    
    public function get_kz_zinsberechnung($sql_valid = FALSE) {
        if (!isset($this->item["kz_zinsberechnung"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["kz_zinsberechnung"];
    }
    
    public function get_kz_manuell($sql_valid = FALSE) {
        if (!isset($this->item["kz_manuell"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["kz_manuell"];
    }

    public function get_kz_saldowirksam($sql_valid = FALSE) {
        if (!isset($this->item["kz_saldowirksam"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["kz_saldowirksam"];
    }
    
    public function __construct($item) {
        $this->item = $item;
    }

    public static function load($mandant_id, $markt = 0) {

        $where = "";
        if ($markt > 0) {
            $where = " AND b.bugru_key LIKE '$markt%' ";
        }
        
        $query = "SELECT b.*, right( cast(b.bugru_key as char), 4) as 'bugru_key_om', bbm.id as 'bua_bgr_man_id', ba.text as 'buart_text'
                    FROM bua_bgr_man bbm
                    JOIN buchungsgrund b ON b.id = bbm.bugru_id
                    JOIN buchungsart ba ON ba.id = b.buchungsart_id
                    WHERE bbm.mandant_id = $mandant_id".$where.
                    " ORDER BY b.bugru_key,  b.text";

        try {
            $result = App::$CURRENT->DB->query($query);
            $response = array();
            foreach ($result as $item) {
                array_push($response, new Buchungsgrund($item));
            }
            return $response;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get_from_bua_bgr_man_id($bua_bgr_man_id) {
        
        $query = "SELECT b.*, right( cast(b.bugru_key as char), 4) as 'bugru_key_om', bbm.id as 'bua_bgr_man_id', ba.text as 'buart_text'
                    FROM bua_bgr_man bbm
                    JOIN buchungsgrund b ON b.id = bbm.bugru_id
                    JOIN buchungsart ba ON ba.id = b.buchungsart_id
                    WHERE bbm.id = $bua_bgr_man_id".
                    " ORDER BY b.text";

        try {
            return App::$CURRENT->DB->singleObjectQuery($query);

        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }
    
    
    public static function get_bua_bgr_man_id($mandant_id, $bugru_id) {
        $query = "SELECT id FROM bua_bgr_man WHERE mandant_id = $mandant_id AND bugru_id = $bugru_id";
        try {
            $result = App::$CURRENT->DB->singleObjectQuery($query);
            return $result->id;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }
}
?>

