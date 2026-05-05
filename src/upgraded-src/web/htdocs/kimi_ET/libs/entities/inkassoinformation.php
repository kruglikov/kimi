<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inkassoinformation
 *
 * @author Roni
 */
class Inkassoinformation {

    private $item;

    public function __construct($item) {
        $this->item = (array) $item;
        $this->add_informations($item, TRUE);
    }

    public function add_informations($informations, $sql_valid = FALSE) {
        if (count($informations) > 0) {
            foreach ($informations as $key => $value) {
                $name = "set_" . $key;

                if (method_exists($this, $name)) {
                    $this->$name($value, $sql_valid);
                }
            }
        }
    }

    public function get_id() {
        return $this->item["id"];
    }

    public function set_id($val, $sql_valid = FALSE) {
        $this->item["id"] = $val;
    }

    public function get_kundennummer($sql_valid = FALSE) {
        if (!isset($this->item["kundennummer"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kundennummer"]) . "'";
        }
        return $this->item["kundennummer"];
    }

    public function set_kundennummer($val, $sql_valid = FALSE) {
        $this->item["kundennummer"] = $val;
    }

    public function get_inkassostatus_id($sql_valid = FALSE) {
        if (!isset($this->item["inkassostatus_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["inkassostatus_id"];
    }

    public function set_inkassostatus_id($val, $sql_valid = FALSE) {
        $this->item["inkassostatus_id"] = $val;
    }

    public function get_status_dat($sql_valid = FALSE) {
        if (!isset($this->item["status_dat"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["status_dat"]) . "'";
        }

        $date = date_create($this->item["status_dat"]);
        return date_format($date, "d.m.Y H:i:s");
    }

    public function set_status_dat($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["status_dat"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["status_dat"] = date_format($date, "Y-m-d H:i:s");
        }
    }

    public function get_ra_ikbuero_id($sql_valid = FALSE) {
        if (!isset($this->item["ra_ikbuero_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["ra_ikbuero_id"];
    }

    public function set_ra_ikbuero_id($val, $sql_valid = FALSE) {
        $this->item["ra_ikbuero_id"] = $val;
    }

    public function get_anz_uebergab($sql_valid = FALSE) {
        if (!isset($this->item["anz_uebergab"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["anz_uebergab"];
    }

    public function set_anz_uebergab($val, $sql_valid = FALSE) {
        $this->item["anz_uebergab"] = $val;
    }

    public function get_letzte_aenderung($sql_valid = FALSE) {
        if (!isset($this->item["letzte_aenderung"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["letzte_aenderung"]) . "'";
        }

        $date = date_create($this->item["letzte_aenderung"]);
        return date_format($date, "d.m.Y");
    }

    public function set_letzte_aenderung($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["letzte_aenderung"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["letzte_aenderung"] = date_format($date, "Y-m-d");
        }
    }

    public function get_uebergabe_betrag($sql_valid = FALSE) {
        if (!isset($this->item["uebergabe_betrag"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["uebergabe_betrag"], 2, ".", "");
        }

        return number_format((float) $this->item["uebergabe_betrag"], 2, ",", ".");
    }

    public function set_uebergabe_betrag($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["uebergabe_betrag"] = $val;
    }

    public function get_uneinbringlich($sql_valid = FALSE) {
        if (!isset($this->item["uneinbringlich"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["uneinbringlich"], 2, ".", "");
        }

        return number_format((float) $this->item["uneinbringlich"], 2, ",", ".");
    }

    public function set_uneinbringlich($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["uneinbringlich"] = $val;
    }

    public function get_uebergabe_dat($sql_valid = FALSE) {
        if (!isset($this->item["uebergabe_dat"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["uebergabe_dat"]) . "'";
        }

        $date = date_create($this->item["uebergabe_dat"]);
        return date_format($date, "d.m.Y");
    }

    public function set_uebergabe_dat($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["uebergabe_dat"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["uebergabe_dat"] = date_format($date, "Y-m-d");
        }
    }

    public function get_uebetr_du($sql_valid = FALSE) {
        if (!isset($this->item["uebetr_du"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["uebetr_du"], 2, ".", "");
        }

        return number_format((float) $this->item["uebetr_du"], 2, ",", ".");
    }

    public function set_uebetr_du($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["uebetr_du"] = $val;
    }

    public function get_dubiosenink($sql_valid = FALSE) {
        if (!isset($this->item["dubiosenink"]) || $this->item["dubiosenink"] == NULL) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["dubiosenink"];
    }

    public function set_dubiosenink($val, $sql_valid = FALSE) {
        $this->item["dubiosenink"] = $val;
    }

    public function get_erl_du_dat($sql_valid = FALSE) {
        if (!isset($this->item["erl_du_dat"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["erl_du_dat"]) . "'";
        }

        $date = date_create($this->item["erl_du_dat"]);
        return date_format($date, "d.m.Y");
    }

    public function set_erl_du_dat($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["erl_du_dat"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["erl_du_dat"] = date_format($date, "Y-m-d");
        }
    }

    public function get_erled_qual_id($sql_valid = FALSE) {
        if (!isset($this->item["erled_qual_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["erled_qual_id"];
    }

    public function set_erled_qual_id($val, $sql_valid = FALSE) {
        $this->item["erled_qual_id"] = $val;
    }

    public function get_erl_dat($sql_valid = FALSE) {
        if (!isset($this->item["erl_dat"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["erl_dat"]) . "'";
        }

        $date = date_create($this->item["erl_dat"]);
        return date_format($date, "d.m.Y");
    }

    public function set_erl_dat($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["erl_dat"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["erl_dat"] = date_format($date, "Y-m-d");
        }
    }

    public function get_ausbuchungsgrund_id($sql_valid = FALSE) {
        if (!isset($this->item["ausbuchungsgrund_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["ausbuchungsgrund_id"];
    }

    public function set_ausbuchungsgrund_id($val, $sql_valid = FALSE) {
        $this->item["ausbuchungsgrund_id"] = $val;
    }

    public function get_kunde_id($sql_valid = FALSE) {
        if (!isset($this->item["kunde_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["kunde_id"];
    }

    public function set_kunde_id($val, $sql_valid = FALSE) {
        $this->item["kunde_id"] = $val;
    }

    public function get_geaendert_von() {
        return $this->item["geaendert_von"];
    }

    public function set_geaendert_von($val, $sql_valid = FALSE) {
        $this->item["geaendert_von"] = $val;
    }
    
    
    public function get_verwendungszweck($sql_valid = FALSE) {
        if (!isset($this->item["verwendungszweck"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid && $this->item["verwendungszweck"] == '') {
            return "NULL";
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["verwendungszweck"]) . "'";
        }
        return $this->item["verwendungszweck"];
    }

    public function set_verwendungszweck($val, $sql_valid = FALSE) {
        $this->item["verwendungszweck"] = $val;
    }

// Sontige geter
    public function get_inkassostatus() {
        return $this->item["inkassostatus"];
    }

    public function get_ikstat_text() {
        return $this->item["ikstat_text"];
    }

    public function get_ikstat_bezeichnung() {
        return $this->item["ikstat_bezeichnung"];
    }

    public function get_erled_qual() {
        return $this->item["erled_qual"];
    }

    public function get_erl_text() {
        return $this->item["erl_text"];
    }

    public function get_ra_buero() {
        return $this->item["ra_buero"];
    }

    public function get_rab_text() {
        return $this->item["rab_text"];
    }

    public function get_ausbuch_grund() {
        return $this->item["ausbuch_grund"];
    }

    public function get_ausbuch_text() {
        return $this->item["ausbuch_text"];
    }

    public function get_max_id() {
        return $this->item["max_id"];
    }

    
    public static function count($mandant_id, $kdnr) {

        $query = "SELECT COUNT(i.id) as 'count' FROM inkassoinformation i
                JOIN kunde k ON k.id = i.kunde_id
                JOIN stammdaten sd ON sd.kunde_id = k.id
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";

        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public static function load_items($mandant_id, $kdnr, $start, $count, $order = "i.status_dat DESC, i.id DESC ") {

        $query = "SELECT i.*, 
                s.inkassostatus, s.text as 'ikstat_text', s.bezeichnung as 'ikstat_bezeichnung',
                e.erled_qual, e.text as 'erl_text',
                r.ra_buero, r.text as 'rab_text',
                a.ausbuch_grund, a.text as 'ausbuch_text'
                FROM inkassoinformation i
                JOIN inkassostatus s ON s.id = i.inkassostatus_id
                LEFT JOIN erled_qual e ON e.id = i.erled_qual_id
                LEFT JOIN ra_ikbuero r ON r.id = i.ra_ikbuero_id
                LEFT JOIN ausbuchungsgrund a ON a.id = i.ausbuchungsgrund_id
                JOIN kunde k ON k.id = i.kunde_id
                JOIN stammdaten sd ON sd.kunde_id = k.id
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";

        $query .= " ORDER BY $order LIMIT $start, $count";
        try {
            $items = App::$CURRENT->DB->query($query);
            $inkassoinfos = array();
            foreach ($items as $value) {
                array_push($inkassoinfos, new Inkassoinformation($value));
            }

            if (count($inkassoinfos) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $inkassoinfos;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get($id) {

        $query = "SELECT i.*,
                s.inkassostatus, s.text as 'ikstat_text', s.bezeichnung as 'ikstat_bezeichnung',
                e.erled_qual, e.text as 'erl_text',
                r.ra_buero, r.text as 'rab_text',
                a.ausbuch_grund, a.text as 'ausbuch_text',
                (select max(id) from inkassoinformation i2 where i2.kunde_id = i.kunde_id) as 'max_id'
            FROM inkassoinformation i
            JOIN kunde k ON k.id = i.kunde_id
            JOIN stammdaten sd ON sd.kunde_id = k.id
            JOIN inkassostatus s ON s.inkassostatus = i.inkassostatus_id
            LEFT JOIN erled_qual e ON e.id = i.erled_qual_id
            LEFT JOIN ra_ikbuero r ON r.id = i.ra_ikbuero_id
            LEFT JOIN ausbuchungsgrund a ON a.id = i.ausbuchungsgrund_id
            WHERE i.id = $id";
        try {
            return new Inkassoinformation(App::$CURRENT->DB->singleObjectQuery($query));
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get_last_status_dat($kunde_id) {

        $query = "SELECT i.*,
                s.inkassostatus, s.text as 'ikstat_text', s.bezeichnung as 'ikstat_bezeichnung',
                e.erled_qual, e.text as 'erl_text',
                r.ra_buero, r.text as 'rab_text',
                a.ausbuch_grund, a.text as 'ausbuch_text'
            FROM inkassoinformation i
            JOIN inkassostatus s ON s.inkassostatus = i.inkassostatus_id
            LEFT JOIN erled_qual e ON e.id = i.erled_qual_id
            LEFT JOIN ra_ikbuero r ON r.id = i.ra_ikbuero_id
            LEFT JOIN ausbuchungsgrund a ON a.id = i.ausbuchungsgrund_id
            WHERE i.kunde_id = $kunde_id ORDER BY i.status_dat desc LIMIT 1 ";
        try {
            return new Inkassoinformation(App::$CURRENT->DB->singleObjectQuery($query));
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function insert($inkassoinfo) {
        $con = App::$CURRENT->DB->manualOpen();

        $query = "INSERT INTO `inkassoinformation`( 
            `kundennummer`, 
            `inkassostatus_id`, 
            `status_dat`,
            `ra_ikbuero_id`,
            `anz_uebergab`,
            `letzte_aenderung`,
            `uebergabe_betrag`,
            `uneinbringlich`,
            `uebergabe_dat`,
            `uebetr_du`,
            `dubiosenink`,
            `erl_du_dat`,
            `erled_qual_id`,
            `erl_dat`,
            `ausbuchungsgrund_id`,
            `geaendert_am`,
            `geaendert_von`,
            `kunde_id`,
            `verwendungszweck`) 

            VALUES (" . $inkassoinfo->get_kundennummer(TRUE) . ",
                " . $inkassoinfo->get_inkassostatus_id(TRUE) . ",
                " . $inkassoinfo->get_status_dat(TRUE) . ",
                " . $inkassoinfo->get_ra_ikbuero_id(TRUE) . ",
                " . $inkassoinfo->get_anz_uebergab(TRUE) . ",
                " . $inkassoinfo->get_letzte_aenderung(TRUE) . ",
                " . $inkassoinfo->get_uebergabe_betrag(TRUE) . ",
                " . $inkassoinfo->get_uneinbringlich(TRUE) . ",
                " . $inkassoinfo->get_uebergabe_dat(TRUE) . ",
                " . $inkassoinfo->get_uebetr_du(TRUE) . ",
                " . $inkassoinfo->get_dubiosenink(TRUE) . ",
                " . $inkassoinfo->get_erl_du_dat(TRUE) . ",
                " . $inkassoinfo->get_erled_qual_id(TRUE) . ",
                " . $inkassoinfo->get_erl_dat(TRUE) . ",
                " . $inkassoinfo->get_ausbuchungsgrund_id(TRUE) . ",
                '" . date("Y-m-d H:i:s") . "',
                '" . App::$CURRENT->USER->get_name() . "',
                " . $inkassoinfo->get_kunde_id(TRUE) . ",
                " . $inkassoinfo->get_verwendungszweck(TRUE) . ")";

        try {

            if (Inkassoinformation::stammdaten_aktualisieren($con, $inkassoinfo->get_inkassostatus_id(TRUE), $inkassoinfo->get_ra_ikbuero_id(TRUE), $inkassoinfo->get_kunde_id(TRUE))) {
                App::$CURRENT->DB->manualQuery($query, $con, FALSE);
                App::$CURRENT->DB->commit($con);
                App::$CURRENT->DB->manualClose($con);
            } else {
                App::$CURRENT->DB->rollback($con);
                App::$CURRENT->DB->manualClose($con);
            }
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            App::$CURRENT->DB->rollback($con);
            App::$CURRENT->DB->manualClose($con);
        }
    }

    public static function update($inkassoinfo, $id) {
        $con = App::$CURRENT->DB->manualOpen();
        $query = "UPDATE `inkassoinformation` SET
            `kundennummer` = " . $inkassoinfo->get_kundennummer(TRUE) . ", 
            `inkassostatus_id` = " . $inkassoinfo->get_inkassostatus_id(TRUE) . ", 
            `status_dat` = " . $inkassoinfo->get_status_dat(TRUE) . ", 
            `ra_ikbuero_id` = " . $inkassoinfo->get_ra_ikbuero_id(TRUE) . ", 
            `anz_uebergab` = " . $inkassoinfo->get_anz_uebergab(TRUE) . ", 
            `letzte_aenderung` = " . $inkassoinfo->get_letzte_aenderung(TRUE) . ", 
            `uebergabe_betrag` = " . $inkassoinfo->get_uebergabe_betrag(TRUE) . ", 
            `uneinbringlich` = " . $inkassoinfo->get_uneinbringlich(TRUE) . ", 
            `uebergabe_dat` = " . $inkassoinfo->get_uebergabe_dat(TRUE) . ", 
            `uebetr_du` = " . $inkassoinfo->get_uebetr_du(TRUE) . ", 
            `dubiosenink` = " . $inkassoinfo->get_dubiosenink(TRUE) . ", 
            `erl_du_dat` = " . $inkassoinfo->get_erl_du_dat(TRUE) . ", 
            `erled_qual_id` = " . $inkassoinfo->get_erled_qual_id(TRUE) . ", 
            `erl_dat` = " . $inkassoinfo->get_erl_dat(TRUE) . ", 
            `ausbuchungsgrund_id` = " . $inkassoinfo->get_ausbuchungsgrund_id(TRUE) . ", 
            `geaendert_am` = '" . date("Y-m-d H:i:s") . "',
            `geaendert_von` = '" . App::$CURRENT->USER->get_name() . "',
            `verwendungszweck` = " . $inkassoinfo->get_verwendungszweck(TRUE) . ",
            `kunde_id` = " . $inkassoinfo->get_kunde_id(TRUE) . " 
            WHERE id = " . $id;
        try {
            $weiter = TRUE;

            /*            if ($buchung->kz_gebucht == "'J'") {
              $weiter = Buchung::buch_saldo($con, $buchung->betrag, $buchung->stammdaten_id, $buchung->bua_bgr_man_id, ($buchung->zahlart_id == 2), $buchung->buchungskennzeichen);
              } */
            if ($weiter) {
                App::$CURRENT->DB->manualQuery($query, $con, FALSE);
                App::$CURRENT->DB->commit($con);
                App::$CURRENT->DB->manualClose($con);
            } else {
                App::$CURRENT->DB->rollback($con);
                App::$CURRENT->DB->manualClose($con);
            }
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function stammdaten_aktualisieren($db, $inkassostatus_id, $ra_buero_id, $kunde_id) {

        $stamm = Stammdaten::get_by_kunde($kunde_id);

        $stamm->set_inkassostatus_id($inkassostatus_id);
        $stamm->set_ra_ikbuero_id($ra_buero_id);
        return ( Stammdaten::update_from_inkassoinformation($db, $stamm));
    }

}

