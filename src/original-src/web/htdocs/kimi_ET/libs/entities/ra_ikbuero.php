<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of ra_ikbuero
 *
 * @author Ronald
 */
class IKBuero {

    private $item;
    public function get_id() {
        return $this->item->id;
    }

    public function get_ra_buero() {
        return $this->item->ra_buero;
    }

    public function get_text() {
        return $this->item->text;
    }

    public function get_markt() {
        return $this->item->markt;
    }

    public function get_kz_aktiv() {
        return $this->item->kz_aktiv;
    }

    
    public function __construct($item) {
        $this->item = $item;
    }

    public static function load_all($markt = 0) {

        $query = "SELECT * FROM ra_ikbuero ";
        if (!$markt == 0) {
            $query.= " WHERE markt = $markt";
        }
        $query.=" ORDER BY ra_buero";
        $result = array();
        $response = App::$CURRENT->DB->query($query);

        foreach ($response as $item) {
            array_push($result, new IKBuero($item));
        }
        return $result;
    }

}
