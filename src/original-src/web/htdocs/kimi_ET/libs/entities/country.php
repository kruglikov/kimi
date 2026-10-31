<?php



/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of country

 *

 * @author David

 */

class Country {

    private $item;

    

    public function get_id() {

        return $this->item->id;

    }

    public function get_kurzzeichen() {

        return $this->item->kurzzeichen;

    }

    public function get_iso2() {

        return $this->item->iso2;

    }

    public function get_eu() {

        return $this->item->eu;

    }

    public function get_bezeichnung() {

        return $this->item->bezeichnung;

    }



    public function __construct($item) {

        $this->item = $item;

    }

    

    public static function load_all() {

        $query = "SELECT * FROM land";

        $response = App::$CURRENT->DB->query($query);

        $result = array();

        

        foreach ($response as $item) {

            array_push($result, new Country($item));

        }

        

        return $result;

    }

}



