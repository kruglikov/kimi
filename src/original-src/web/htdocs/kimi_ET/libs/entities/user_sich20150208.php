<?php

/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */

/**

 * Description of user

 *

 * @author David

 */
class User {

    private $item;

    public function get_id() {

        return $this->item->id;
    }

    public function get_name() {

        return $this->item->name;
    }

    public function get_gruppe() {

        return $this->item->gruppe;
    }

    public function get_land() {

        return $this->item->land;
    }

    public function get_vorname() {

        if (isset($this->item->vorname)) {

            return $this->item->vorname;
        } else {

            return "";
        }
    }

    public function get_nachname() {

        if (isset($this->item->nachname)) {

            return $this->item->nachname;
        } else {

            return "";
        }
    }

    public function get_email() {

        return $this->item->email;
    }

    public function get_telefon() {

        return $this->item->telefon;
    }

    public function get_sprache() {

        return $this->item->sprache;
    }

    public function __construct($user) {

        $this->item = $user;
    }

    public function get_default_bua_bgr_key($sql_valid = FALSE) {
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item->default_bua_bgr_key) . "'";
        }
        return $this->item->default_bua_bgr_key;
    }

    public function set_default_bua_bgr_key($value) {
        $this->item->default_bua_bgr_key = $value;
    }

    public function get_default_belegdatum($sql_valid = FALSE) {

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item->default_belegdatum) . "'";
        }
        if ($this->item->default_belegdatum == '' || $this->item->default_belegdatum == NULL) {
            return '';
        }
        $date = date_create($this->item->default_belegdatum);
        return date_format($date, "d.m.Y");
    }

    public function set_default_belegdatum($val) {
        if (strlen($val) == 0) {
            $this->item->default_belegdatum = NULL;
            return;
        }

        $date = date_create($val);
        $this->item->default_belegdatum = date_format($date, "Y-m-d");
    }

    public static function login($name, $passwort) {

        $passwort = self::encrypt($passwort);
        $passwort = substr($passwort, 0, 64);

        $query = "SELECT * FROM benutzer WHERE (name = '$name' OR email = '$name') AND passwort = '$passwort'";

        $user = App::$CURRENT->DB->singleObjectQuery($query);



        if ($user == NULL || !isset($user) || !$user)
            return null;

        return new User($user);
    }

    public static function get_all_current() {
        $query = "SELECT b.* FROM benutzer b
            JOIN mandant_benutzer mb ON mb.benutzer_id = b.id
            WHERE mb.mandant_id = " . App::$CURRENT->MANDANT->get_id();

        try {
            $result = array();
            $response = App::$CURRENT->DB->query($query);

            foreach ($response as $item) {
                array_push($result, new User($item));
            }

            return $result;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function encrypt($passwort) {

        return hash("sha256", "kimiplus" . $passwort);

        // return $passwort;
    }

}
?>

