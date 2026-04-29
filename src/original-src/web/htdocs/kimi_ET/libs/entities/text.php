<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of text
 *
 * @author David
 */
class Texte {

    private $item;

    public function get_id() {
        return $this->item["id"];
    }

    public function get_text() {
        return $this->item["text"];
    }

    public function __construct($item) {
        $this->item = (array) $item;
    }

    public static function get_prioritaet() {
        return self::get("prioritaet");
    }
    public static function get_status() {
        return self::get("status");
    }
    public static function get_anruf_status() {
        return self::get("anruf_status");
    }
    
    public static function get_grund() {
        return self::get("grund");
    }
    
    public static function get_firma() {
        return self::get("firma");
    }
    
    public static function get_produkt() {
        return self::get("produkt");
    }

    public static function get_janein() {
        return self::get("janein");
    }

    public static function get_nummern() {
        return self::get("nummern");
    }
	
    public static function get_dummy_id($refId) {
        return self::get("dummy_id_referenz", $refId);
    }
		
	
    private static function get($table_name, $dummy_id=null) {
        $where = "";

        if ($dummy_id !== null) {
            $where = " and dummy_id = ".$dummy_id. " order by sort, id";
        }

        $query = "SELECT * FROM $table_name WHERE mandant_id = " . App::$CURRENT->MANDANT->get_id().$where;

        try {
            $result = array();
            $response = App::$CURRENT->DB->query($query);
            
            foreach ($response as $item) {
                array_push($result, new Texte($item));
            }
            
            return $result;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

}

?>
