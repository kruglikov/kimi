<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of anrede
 *
 * @author David
 */
class Kampagne {

    private $item;
    public function get_id() {
        return $this->item->id;
    }

    public function get_bezeichnung() {
        return $this->item->bezeichnung;
    }

    public function get_iptel_destclid() {
        return $this->item->iptel_destclid;
    }

    public function get_iptel_auto_vorwahl() {
        return $this->item->iptel_auto_vorwahl;
    }
	
    public function __construct($item) {
        $this->item = $item;
    }

    public static function load_all() {
        try {
            $query = "SELECT * FROM kampagne WHERE aktiv = 1";
            $con = new DBConnection();
            $con->set_auto_commit();
            $con->set_query($query);
            $result = array();
            $response = $con->query();
            $con->close();

            foreach ($response as $item) {
                array_push($result, new Kampagne($item));
            }
            return $result;
        }
        catch(Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            return NULL;
        }
    }

    public static function load_last_campaign() {
        $user = App::$CURRENT->USER->get_letzte_kampagne_id();
    }

    public static function load_for_id($kId) {
        $query = "SELECT * FROM kampagne WHERE id = $kId";

        try {
            $item = App::$CURRENT->DB->singleObjectQuery($query);
            return new Kampagne($item);
        }
        catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }
}
?>

