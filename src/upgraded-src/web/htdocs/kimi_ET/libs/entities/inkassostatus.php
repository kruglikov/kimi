<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Inkassostatus
 *
 * @author Ronald
 */
class IKStatus {

    private $item;
    public function get_id() {
        return $this->item->id;
    }

    public function get_inkassostatus() {
        return $this->item->inkassostatus;
    }

    public function get_text() {
        return $this->item->text;
    }

    public function get_bezeichnung() {
        return $this->item->bezeichnung;
    }

    public function get_kz_krsv_erlaubt() {
        return $this->item->kz_krsv_erlaubt;
    }

    public function get_kz_akt_betreibung() {
        return $this->item->kz_akt_betreibung;
    }

    public function get_kz_inaktiv() {
        return $this->item->kz_inaktiv;
    }
        
    public function __construct($item) {
        $this->item = $item;
    }

    public static function load_all() {

        $query = "SELECT * FROM inkassostatus ORDER BY inkassostatus ";
        $result = array();
        $response = App::$CURRENT->DB->query($query);

        foreach ($response as $item) {
            array_push($result, new IKStatus($item));
        }
        return $result;
    }

}
