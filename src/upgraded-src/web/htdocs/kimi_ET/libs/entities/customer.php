<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**

 * Description of customer
 *
 * @author David
 */
class Customer {

    private $item;

    public function get_raw_item() {
        return $this->item;
    }

    public function get_land($sql_valid = FALSE) {
        if (!isset($this->item["land"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["land"]) . "'";
        }

        return $this->item["land"];
    }

    private function set_land($land) {
        $this->item["land"] = $land;
    }

    public function get_land_id($sql_valid = FALSE) {
        if (!isset($this->item["land_id"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        return $this->item["land_id"];
    }

    public function set_land_id($land_id) {
        $this->item["land_id"] = $land_id;
    }

    public function get_id() {
        if (!isset($this->item["id"])) {
            return NULL;
        }

        return $this->item["id"];
    }

    public function set_id($id) {

        return $this->item["id"] = $id;
    }

    public function get_mandant_id($sql_valid = FALSE) {
        if (!isset($this->item["mandant_id"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        return $this->item["mandant_id"];
    }

    public function set_mandant_id($mandant_id) {
        $this->item["mandant_id"] = $mandant_id;
    }

    public function get_kdnr($sql_valid = FALSE) {
        if (!isset($this->item["kdnr"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kdnr"]) . "'";
        }
        return $this->item["kdnr"];
    }

    public function set_kdnr($kdnr) {
        $this->item["kdnr"] = $kdnr;
    }

    public function get_anrede_id($sql_valid = FALSE) {
        if (!isset($this->item["anrede_id"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        return $this->item["anrede_id"];
    }

    public function set_anrede_id($anrede_id) {
        $this->item["anrede_id"] = $anrede_id;
    }

    public function get_titel_id($sql_valid = FALSE) {
        if (!isset($this->item["titel_id"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        return $this->item["titel_id"];
    }

    public function set_titel_id($titel_id) {
        if ($titel_id < 0) {
            $titel_id = 'NULL';
        }
        $this->item["titel_id"] = $titel_id;
    }

    public function get_anrede2_id($sql_valid = FALSE) {
        if (!isset($this->item["anrede2_id"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        return $this->item["anrede2_id"];
    }

    public function set_anrede2_id($anrede_id) {
        $this->item["anrede2_id"] = $anrede_id;
    }

    public function get_titel2_id($sql_valid = FALSE) {
        if (!isset($this->item["titel2_id"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        return $this->item["titel2_id"];
    }

    public function set_titel2_id($titel2_id) {
        if ($titel2_id < 0) {
            $titel2_id = 'NULL';
        }
        $this->item["titel2_id"] = $titel2_id;
    }

    
    public function get_nachname($sql_valid = FALSE) {
        if (!isset($this->item["nachname"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["nachname"]) . "'";
        }
        return $this->item["nachname"];
    }

    public function set_nachname($nachname) {
        $this->item["nachname"] = $nachname;
    }

    public function get_vorname($sql_valid = FALSE) {
        if (!isset($this->item["vorname"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["vorname"]) . "'";
        }
        return $this->item["vorname"];
    }

    public function set_vorname($vorname) {
        $this->item["vorname"] = $vorname;
    }

    public function get_plz($sql_valid = FALSE) {
        if (!isset($this->item["plz"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["plz"]) . "'";
        }
        return $this->item["plz"];
    }

    public function set_plz($plz) {
        $this->item["plz"] = $plz;
    }

    public function get_ort($sql_valid = FALSE) {
        if (!isset($this->item["ort"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["ort"]) . "'";
        }
        return $this->item["ort"];
    }

    public function set_ort($ort) {
        $this->item["ort"] = $ort;
    }

    public function get_strasse($sql_valid = FALSE) {
        if (!isset($this->item["strasse"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["strasse"]) . "'";
        }
        return $this->item["strasse"];
    }

    public function set_strasse($strasse) {
        $this->item["strasse"] = $strasse;
    }

    public function get_hausnummer($sql_valid = FALSE) {
        if (!isset($this->item["hausnummer"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        return $this->item["hausnummer"];
    }

    public function set_hausnummer($hausnummer) {
        $this->item["hausnummer"] = $hausnummer;
    }

    public function get_hausnummer_erw($sql_valid = FALSE) {
        if (!isset($this->item["hausnummer_erw"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["hausnummer_erw"]) . "'";
        }
        return $this->item["hausnummer_erw"];
    }

    public function set_hausnummer_erw($hausnummer_erw) {
        $this->item["hausnummer_erw"] = $hausnummer_erw;
    }

    public function get_telefon($sql_valid = FALSE) {
        if (!isset($this->item["telefon"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["telefon"]) . "'";
        }
        return $this->item["telefon"];
    }

    public function set_telefon($telefon) {
        $this->item["telefon"] = $telefon;
    }

    public function get_email($sql_valid = FALSE) {
        if (!isset($this->item["email"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["email"]) . "'";
        }
        return $this->item["email"];
    }

    public function set_email($email) {
        $this->item["email"] = $email;
    }

    public function get_geburtsdatum($sql_valid = FALSE) {
        if (!isset($this->item["geburtsdatum"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["geburtsdatum"]) . "'";
        }

        $date = date_create($this->item["geburtsdatum"]);
        return date_format($date, "d.m.Y");
    }

    public function set_geburtsdatum($geburtsdatum) {
        if (strlen($geburtsdatum) == 0) {
            $this->item["geburtsdatum"] = NULL;
            return;
        }

        $date = date_create($geburtsdatum);
        $this->item["geburtsdatum"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_kenner($sql_valid = FALSE) {
        if (!isset($this->item["kenner"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kenner"]) . "'";
        }
        return $this->item["kenner"];
    }

    public function set_kenner($kenner) {
        $this->item["kenner"] = $kenner;
    }

    public function get_anrede($sql_valid = FALSE) {
        if (!isset($this->item["anrede"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["anrede"]) . "'";
        }

        return $this->item["anrede"];
    }

    private function set_anrede($anrede) {
        $this->item["anrede"] = $anrede;
    }

    public function get_titel($sql_valid = FALSE) {
        if (!isset($this->item["titel"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["titel"]) . "'";
        }

        return $this->item["titel"];
    }

    public function set_titel($titel) {
        $this->item["titel"] = $titel;
    }

    public function get_anrede2($sql_valid = FALSE) {
        if (!isset($this->item["anrede2"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["anrede2"]) . "'";
        }

        return $this->item["anrede2"];
    }

    private function set_anrede2($anrede2) {
        $this->item["anrede2"] = $anrede2;
    }

    public function get_titel2($sql_valid = FALSE) {
        if (!isset($this->item["titel2"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["titel2"]) . "'";
        }

        return $this->item["titel2"];
    }

    public function set_titel2($titel2) {
        $this->item["titel2"] = $titel2;
    }

    
    public function get_primaerkdnr($sql_valid = FALSE) {
        if (!isset($this->item["primaerkdnr"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["primaerkdnr"]) . "'";
        }
        return $this->item["primaerkdnr"];
    }

    public function set_primaerkdnr($primaerkdnr) {
        $this->item["primaerkdnr"] = $primaerkdnr;
    }

	    public function get_nachname2($sql_valid = FALSE) {
        if (!isset($this->item["nachname2"])) {
            return NULL;
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["nachname2"]) . "'";
        }
        return $this->item["nachname2"];
    }    
    
    public function set_nachname2($nachname2) {
        $this->item["nachname2"] = $nachname2;
    }

    public function get_vorname2($sql_valid = FALSE) {
        if (!isset($this->item["vorname2"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["vorname2"]) . "'";
        }
        return $this->item["vorname2"];
    }

    public function set_vorname2($vorname2) {
        $this->item["vorname2"] = $vorname2;
    }

   public function get_kundenart($sql_valid = FALSE) {
        if (!isset($this->item["kundenart"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kundenart"]) . "'";
        }
        return $this->item["kundenart"];
    }

    public function set_kundenart($kundenart) {
        $this->item["kundenart"] = $kundenart;
    }    
    
    public function get_kundenartbeschreibung($sql_valid = FALSE) {
        if (!isset($this->item["kundenartbeschreibung"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kundenartbeschreibung"]) . "'";
        }
        return $this->item["kundenartbeschreibung"];
    }

    public function set_kundenartbeschreibung($kundenartbeschreibung) {
        $this->item["kundenartbeschreibung"] = $kundenartbeschreibung;
    }      
    
    public function get_geburtsdatum2($sql_valid = FALSE) {
        if (!isset($this->item["geburtsdatum2"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["geburtsdatum2"]) . "'";
        }

        $date = date_create($this->item["geburtsdatum2"]);
        return date_format($date, "d.m.Y");
    }

    public function set_geburtsdatum2($geburtsdatum2) {
        if (strlen($geburtsdatum2) == 0) {
            $this->item["geburtsdatum2"] = NULL;
            return;
        }
        $date = date_create($geburtsdatum2);
        $this->item["geburtsdatum2"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_anlagedatum($sql_valid = FALSE) {
        if (!isset($this->item["anlagedatum"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["anlagedatum"]) . "'";
        }

        $date = date_create($this->item["anlagedatum"]);
        return date_format($date, "d.m.Y");
    }

    public function set_anlagedatum($anlagedatum) {
        if (strlen($anlagedatum) == 0) {
            $this->item["anlagedatum"] = NULL;
            return;
        }

        $date = date_create($anlagedatum);
        $this->item["anlagedatum"] = date_format($date, "Y-m-d");
    }

    public function get_adresszusatz($sql_valid = FALSE) {
        if (!isset($this->item["adresszusatz"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["adresszusatz"]) . "'";
        }
        return $this->item["adresszusatz"];
    }

    public function set_adresszusatz($adresszusatz) {
        $this->item["adresszusatz"] = $adresszusatz;
    }

    public function get_ortsteil($sql_valid = FALSE) {
        if (!isset($this->item["ortsteil"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["ortsteil"]) . "'";
        }
        return $this->item["ortsteil"];
    }

    public function set_ortsteil($ortsteil) {
        $this->item["ortsteil"] = $ortsteil;
    }
    
    public function get_markt($sql_valid = FALSE) {
        if (!isset($this->item["markt"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        return $this->item["markt"];
    }

    public function set_markt($markt) {
        $this->item["markt"] = $markt;
    }

    
    public function __construct($item) {
        $this->item = array();
        $item = (array) $item;

        foreach ($item as $key => $value) {
            $name = "set_" . $key;

            if (method_exists($this, $name)) {
                $this->$name($value);
            }
        }
    }

    public static function load_items($mandant_id, $start, $count, $filter, $order) {

        $query = "SELECT k.*, a.text as 'anrede', t.text as 'ttitel', a2.text as 'anrede2', l.kurzzeichen as 'land' FROM kunde k
                LEFT JOIN anrede a ON a.ID = k.anrede_id
                LEFT JOIN titel t ON t.ID = k.titel_id
                LEFT JOIN land l ON l.ID = k.land_id
                LEFT JOIN anrede a2 on a2.ID = k.anrede2_id
                WHERE k.mandant_id = $mandant_id";

        foreach ($filter as $item) {
            $query .= " AND $item";
        }

        $query .= " ORDER BY $order LIMIT $start, $count";

        try {
            $items = App::$CURRENT->DB->query($query);
            $customers = array();

            foreach ($items as $value) {
                array_push($customers, new Customer($value));
            }
            if (count($customers) == 0) {

                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $customers;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function load_all_items($mandant_id) {
        $query = "SELECT * FROM kunde WHERE mandant_id = $mandant_id";
        $items = App::$CURRENT->DB->query($query);
        $customers = array();

        foreach ($items as $value) {
            array_push($customers, new Customer($value));
        }
        return $customers;
    }

    public static function count($mandant_id, $filter) {
        $query = "SELECT COUNT(id) AS 'count' FROM kunde WHERE mandant_id = $mandant_id";

        foreach ($filter as $item) {
            $query .= " AND $item";
        }
        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public static function get($id) {

        $query = "SELECT k.*, a.text as 'anrede', t.text as 'ttitel', a2.text as 'anrede2', l.kurzzeichen as 'land' FROM kunde k
                LEFT JOIN anrede a ON a.ID = k.anrede_id
                LEFT JOIN titel t ON t.ID = k.titel_id
                LEFT JOIN land l ON l.ID = k.land_id
                LEFT JOIN anrede a2 on a2.ID = k.anrede2_id
                WHERE k.ID = $id";

        try {
            return new Customer(App::$CURRENT->DB->singleObjectQuery($query));
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get_by_kunde_nr($kunde_nr, $mandant_id) {

        $query = "SELECT k.*, a.text as 'anrede', t.text as 'ttitel', a2.text as 'anrede2', l.kurzzeichen as 'land' FROM kunde k
                LEFT JOIN anrede a ON a.ID = k.anrede_id
                LEFT JOIN titel t ON t.ID = k.titel_id
                LEFT JOIN land l ON l.ID = k.land_id
                LEFT JOIN anrede a2 on a2.ID = k.anrede2_id
                WHERE k.kdnr = '$kunde_nr' AND mandant_id = $mandant_id";

        try {
            return new Customer(App::$CURRENT->DB->singleObjectQuery($query));
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function insert($kunde) {
        try {
            $con = App::$CURRENT->DB->manualOpen();
            $query = "INSERT INTO `kunde` (
                    `mandant_id` ,
                    `kdnr` ,
                    `anrede_id` ,
                    `titel_id` ,
                    `nachname` ,
                    `vorname` ,
                    `plz` ,
                    `ort` ,
                    `strasse` ,
                    `hausnummer` ,
                    `hausnummer_erw` ,
                    `telefon` ,
                    `email` ,
                    `geburtsdatum` ,
                    `kenner` ,
                    `geaendert_am` ,
                    `geaendert_von` ,
                    `land_id`,
                    `primaerkdnr`,
                    `nachname2`,
                    `vorname2`,
                    `anrede2_id`,
                    `kundenart`,
                    `kundenartbeschreibung`,
                    `geburtsdatum2`,
                    `anlagedatum`,
                    `titel`,
                    `titel2`,
                    `adresszusatz`,
                    `ortsteil`
                    )
                    VALUES (
                        " . $kunde->get_mandant_id() . ",
                        " . $kunde->get_kdnr(TRUE) . ",
                        " . $kunde->get_anrede_id(TRUE) . ",
                        " . $kunde->get_titel_id(TRUE) . ",
                        " . $kunde->get_nachname(TRUE) . ",
                        " . $kunde->get_vorname(TRUE) . ",
                        " . $kunde->get_plz(TRUE) . ",
                        " . $kunde->get_ort(TRUE) . ",
                        " . $kunde->get_strasse(TRUE) . ",
                        " . $kunde->get_hausnummer() . ",
                        " . $kunde->get_hausnummer_erw(TRUE) . ",
                        " . $kunde->get_telefon(TRUE) . ",
                        " . $kunde->get_email(TRUE) . ",
                        " . $kunde->get_geburtsdatum(TRUE) . ",
                        " . $kunde->get_kenner(TRUE) . ",
                        '" . date("Y-m-d H:i:s") . "',
                        '" . App::$CURRENT->USER->get_name(TRUE) . "',
                        " . $kunde->get_land_id(TRUE) . ",
			" . $kunde->get_primaerkdnr(TRUE) . ",
			" . $kunde->get_nachname2(TRUE) . ",
			" . $kunde->get_vorname2(TRUE) . ",
                        " . $kunde->get_anrede2_id(TRUE) . ",
			" . $kunde->get_kundenart(TRUE) . ",
			" . $kunde->get_kundenartbeschreibung(TRUE) . ",
			" . $kunde->get_geburtsdatum2(TRUE) . ",
                        " . $kunde->get_anlagedatum(TRUE) . ",
                        " . $kunde->get_titel(TRUE) . ",
                        " . $kunde->get_titel2(TRUE) . ",
                        " . $kunde->get_adresszusatz(TRUE) . ",
                        " . $kunde->get_ortsteil(TRUE) . "
                    )";
            $id = App::$CURRENT->DB->manualQueryReturningId($query, $con);
            if (isset($id)) {
                // Anlage Konto
                $sd = new Stammdaten($kunde->get_raw_item(), $con);
                $sd->set_kunde_id($id);
                $sd->set_ktonr($kunde->get_kdnr(FALSE));
                $sd->set_mandant_id($kunde->get_mandant_id());
                $sd->set_datum_anlage(date("Y-m-d"));
                
                $sd->set_stichtag(date("Y-m-d"));
                $sd->set_zahltag(date("Y-m-d"));
                
                $date = new DateTime( date("Y-m-d") );
                $date = date_add($date, date_interval_create_from_date_string('15 days'));
                
                if ( date_format($date, "m") != 2 &&  date_format($date, "d") == 31) {
                    $date = date_add($date, date_interval_create_from_date_string('1 days'));
                } else if ( date_format($date, "m") == 2 &&  date_format($date, "d") == 29) {
                    $date = date_add($date, date_interval_create_from_date_string('1 days'));
                }
                
                if (date_format($date, "w") == 0) {
                    $date = date_add($date, date_interval_create_from_date_string('1 days'));
                } else if (date_format($date, "w") == 6) {
                    $date = date_add($date, date_interval_create_from_date_string('2 days'));
                }
                
                $sd->set_zahltag(date_format($date, "Y-m-d"));

                
                $sd_id = Stammdaten::insert($sd, $con);
                if (!isset($sd_id) || !$sd_id > 0) {
                  App::$CURRENT->DB->rollback($con);  
                }
            }
            App::$CURRENT->DB->commit($con);
            return $id;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            if (isset($con)) {
                App::$CURRENT->DB->rollback($con);
            }
            return false;
        }
    }

    public static function update($kunde) {
        try {
            $con = App::$CURRENT->DB->manualOpen();
            $query = "UPDATE `kunde`
                    SET `mandant_id` = " . $kunde->get_mandant_id(TRUE) . ",
                    `kdnr` = " . $kunde->get_kdnr(TRUE) . ",
                    `anrede_id` = " . $kunde->get_anrede_id(TRUE) . ",
                    `titel_id` = " . $kunde->get_titel_id(TRUE) . ",
                    `nachname` = " . $kunde->get_nachname(TRUE) . ",
                    `vorname` = " . $kunde->get_vorname(TRUE) . ",
                    `plz` = " . $kunde->get_plz(TRUE) . ",
                    `ort` = " . $kunde->get_ort(TRUE) . ",
                    `strasse` = " . $kunde->get_strasse(TRUE) . ",
                    `hausnummer` = " . $kunde->get_hausnummer() . ",
                    `hausnummer_erw` = " . $kunde->get_hausnummer_erw(TRUE) . ",
                    `telefon` = " . $kunde->get_telefon(TRUE) . ",
                    `email` = " . $kunde->get_email(TRUE) . ",
                    `geburtsdatum` = " . $kunde->get_geburtsdatum(TRUE) . ",
                    `kenner` = " . $kunde->get_kenner(TRUE) . ",
                    `geaendert_am` = '" . date("Y-m-d H:i:s") . "',
                    `geaendert_von` = '" . App::$CURRENT->USER->get_name(TRUE) . "' ,
                    `land_id` = " . $kunde->get_land_id(TRUE) . ",
                    `primaerkdnr` = " . $kunde->get_primaerkdnr(TRUE) . ",
                    `nachname2` = " . $kunde->get_nachname2(TRUE) . ",
                    `vorname2` = " . $kunde->get_vorname2(TRUE) . ",
                    `kundenart` = " . $kunde->get_kundenart(TRUE) . ",
                    `kundenartbeschreibung` = " . $kunde->get_kundenartbeschreibung(TRUE) . ",
                    `anlagedatum` = " . $kunde->get_anlagedatum(TRUE) . ",
                    `anrede2_id` = " . $kunde->get_anrede2_id(TRUE) . ",
                    `titel` = " . $kunde->get_titel(TRUE) . ",
                    `titel2` = " . $kunde->get_titel2(TRUE) . ",
                    `geburtsdatum2` = " . $kunde->get_geburtsdatum2(TRUE) . ",
                    `adresszusatz` = " . $kunde->get_adresszusatz(TRUE) . ",
                    `ortsteil` = " . $kunde->get_ortsteil(TRUE) . "
                    WHERE id = " . $kunde->get_id();


            App::$CURRENT->DB->manualQuery($query, $con, FALSE);
            App::$CURRENT->DB->commit($con);
            return true;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            if (isset($con)) {
                App::$CURRENT->DB->rollback($con);
            }
            return false;
        }
    }

    public static function delete($id) {
        $query = "DELETE FROM kunde WHERE id = $id";
        try {
            App::$CURRENT->DB->query($query, FALSE);
            return TRUE;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            return FALSE;
        }
    }
}

