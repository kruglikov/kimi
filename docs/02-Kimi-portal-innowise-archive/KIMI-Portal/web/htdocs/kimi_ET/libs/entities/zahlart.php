<?php

/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */

/**

 * Description of zahlart
 
 *

 * @author David

 */
class Zahlart {

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

    public static function get_all() {

        $query = "SELECT * FROM zahlart";



        try {

            $result = App::$CURRENT->DB->query($query);

            $response = array();



            foreach ($result as $item) {

                array_push($response, new Zahlart($item));
            }



            return $response;
        } catch (Exception $e) {

            App::$CURRENT->add_error($e->getMessage());
        }
    }

}
?>

