<?php

/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */

/**

 * Description of role

 *

 * @author David

 */
class Role {

    private $item;

    public function get_id() {

        return $this->item->id;
    }

    public function get_bezeichnung() {

        return $this->item->bezeichnung;
    }

    public function __construct($item) {

        $this->item = $item;
    }

    public static function get_role($user, $mandant) {

        $query = "SELECT r.* FROM rolle r, mandant_benutzer mb WHERE mb.mandant_id = "
                . $mandant->get_id() .
                " AND mb.benutzer_id = "
                . $user->get_id() .
                " AND r.id = mb.rolle_id";



        return new Role(App::$CURRENT->DB->singleObjectQuery($query));
    }

}
