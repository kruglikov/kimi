<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of erled_qual
 *
 * @author Ronald
 */
class Erled_Qual {

    private $item;
    public function get_id() {
        return $this->item->id;
    }

    public function get_erled_qual() {
        return $this->item->erled_qual;
    }

    public function get_text() {
        return $this->item->text;
    }

    
    public function __construct($item) {
        $this->item = $item;
    }

    public static function load_all() {

        $query = "SELECT * FROM erled_qual ORDER BY erled_qual";
        $result = array();
        $response = App::$CURRENT->DB->query($query);

        foreach ($response as $item) {
            array_push($result, new Erled_Qual($item));
        }
        return $result;
    }

}
