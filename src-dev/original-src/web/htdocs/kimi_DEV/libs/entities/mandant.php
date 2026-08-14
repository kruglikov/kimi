<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mandant
 *
 * @author David
 */
class Mandant {
    protected $item;
    
    public function get_id() {
        return $this->item->id;
    }
    public function get_mandant() {
        return $this->item->mandant;
    }
    public function get_text() {
        return $this->item->text;
    }
    public function get_uid() {
        return $this->item->uid;
    }
    public function get_land() {
        return $this->item->land;
    }
    public function get_plz() {
        return $this->item->plz;
    }
    public function get_ort() {
        return $this->item->ort;
    }
    public function get_strasse() {
        return $this->item->strasse;
    }
    public function get_hausnummer() {
        return $this->item->hausnummer;
    }
    public function get_hausnummer_erw() {
        return $this->item->hausnummer_erw;
    }
    public function get_telefon() {
        return $this->item->telefon;
    }
    public function get_email() {
        return $this->item->email;
    }
    
    public function __construct($item) {
        $this->item = $item;
    }
    
    public static function load_mandanten($user) {
        $query = "SELECT * FROM mandant m, mandant_benutzer mb where mb.mandant_id = m.id and mb.benutzer_id = ".$user->get_id();
        
        $results = App::$CURRENT->DB->query($query);
        $mandanten = array();
        
        foreach ($results as $item) {
            array_push($mandanten, new Mandant($item));
        }
        
        return $mandanten;
    }

    public function jsonSerialize() {
        return $this->item;
    }
    
    public static function get($mandant_id) {
        $query = "SELECT * FROM mandant WHERE id = $mandant_id";
        $man = App::$CURRENT->DB->singleObjectQuery($query);
        
        return new Mandant($man);
    }
}

?>
