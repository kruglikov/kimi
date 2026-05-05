<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of buchungsart
 *
 * @author David
 */
class Buchungsart {

    private $item;

    public function get_id() {
        return $this->item->id;
    }

    public function get_text() {
        return $this->item->text;
    }

    public function get_buart_key() {
        return $this->item->buart_key;
    }

    public function get_bugru_key() {
        return $this->item->bugru_key;
    }

    public function get_bugru_text() {
        return $this->item->bugru_text;
    }

    public function get_bua_bgr_man_id() {
        return $this->item->bua_bgr_man_id;
    }

    
    public function __construct($item) {
        $this->item = $item;
    }

    public static function get_list($mandant_id) {
        $query = "SELECT DISTINCT b.* FROM `buchungsart` b
                JOIN buchungsgrund bg ON bg.buchungsart_id = b.id
                JOIN bua_bgr_man bbm ON bbm.bugru_id = bg.id
                WHERE bbm.mandant_id = $mandant_id
                ORDER BY b.text";
        try {
            $result = App::$CURRENT->DB->query($query);
            $response = array();
            foreach ($result as $item) {
                array_push($response, new Buchungsart($item));
            }
            return $response;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }
    
        public static function get_list_bugr($mandant_id) {
        $query = "SELECT  b.*, bg.bugru_key as 'bugru_key', bg.text as 'bugru_text', bbm.id as 'bua_bgr_man_id' FROM `buchungsart` b
                JOIN buchungsgrund bg ON bg.buchungsart_id = b.id
                JOIN bua_bgr_man bbm ON bbm.bugru_id = bg.id
                WHERE bbm.mandant_id = $mandant_id
                ORDER BY bg.bugru_key ";
        try {
            $result = App::$CURRENT->DB->query($query);
            $response = array();
            foreach ($result as $item) {
                array_push($response, new Buchungsart($item));
            }
            return $response;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }
}
