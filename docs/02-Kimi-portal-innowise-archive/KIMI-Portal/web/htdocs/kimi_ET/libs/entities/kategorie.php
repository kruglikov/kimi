<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of kategorie
 *
 * @author Ronald
 */
class Kategorie {

    private $item;
    public function get_id() {
        return $this->item->id;
    }

    public function get_text() {
        return $this->item->text;
    }
    
    public function __construct($item) {
        $this->item = $item;
    }

    public static function load_all() {

        $query = "SELECT * FROM kategorie ORDER BY text";
        $result = array();
        $response = App::$CURRENT->DB->query($query);

        foreach ($response as $item) {
            array_push($result, new Kategorie($item));
        }
        return $result;
    }

}
?>

