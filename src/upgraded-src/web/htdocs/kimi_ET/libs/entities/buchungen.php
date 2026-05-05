<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of buchungen
 *
 * @author David
 */
class Buchung {

    private $item;

    public function __construct($item) {
        $this->item = (array) $item;
        $this->add_informations($item, TRUE);
    }

    public function add_informations($informations, $sql_valid = FALSE) {
        foreach ($informations as $key => $value) {
            $name = "set_" . $key;

            if (method_exists($this, $name)) {
                $this->$name($value, $sql_valid);
            }
        }
    }

    public function get_id() {
        return $this->item["id"];
    }

    public function set_id($val, $sql_valid = FALSE) {
        $this->item["id"] = $val;
    }

    public function get_stammdaten_id() {
        return $this->item["stammdaten_id"];
    }

    public function set_stammdaten_id($val, $sql_valid = FALSE) {
        $this->item["stammdaten_id"] = $val;
    }

    public function get_bua_bgr_man_id() {
        return $this->item["bua_bgr_man_id"];
    }

    public function set_bua_bgr_man_id($val, $sql_valid = FALSE) {
        $this->item["bua_bgr_man_id"] = $val;
    }

    public function get_betrag($sql_valid = FALSE) {
        if (!isset($this->item["betrag"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["betrag"], 2, ".", "");
        }

        return number_format((float) $this->item["betrag"], 2, ",", ".");
    }

    public function set_betrag($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["betrag"] = $val;
    }

    public function get_buchungsdatum($sql_valid = FALSE) {
        if (!isset($this->item["buchungsdatum"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["buchungsdatum"]) . "'";
        }

        $date = date_create($this->item["buchungsdatum"]);
        return date_format($date, "d.m.Y");
    }

    public function set_buchungsdatum($val, $sql_valid = FALSE) { {
            if (strlen((string) $val) == 0) {
                $this->item["buchungsdatum"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["buchungsdatum"] = date_format($date, "Y-m-d H:i:s");
        }
    }

    public function get_valutadatum($sql_valid = FALSE) {
        if (!isset($this->item["valutadatum"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["valutadatum"]) . "'";
        }

        $date = date_create($this->item["valutadatum"]);
        return date_format($date, "d.m.Y");
    }

    public function set_valutadatum($val, $sql_valid = FALSE) { {
            if (strlen((string) $val) == 0) {
                $this->item["valutadatum"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["valutadatum"] = date_format($date, "Y-m-d H:i:s");
        }
    }

    public function get_mwst_id($sql_valid = FALSE) {
        if (!isset($this->item["mwst_id"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        return $this->item["mwst_id"];
    }

    public function set_mwst_id($val, $sql_valid = FALSE) {
        $this->item["mwst_id"] = $val;
    }

    public function get_zahlart_id($sql_valid = FALSE) {
        if (!isset($this->item["zahlart_id"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        return $this->item["zahlart_id"];
    }

    public function set_zahlart_id($val, $sql_valid = FALSE) {
        $this->item["zahlart_id"] = $val;
    }

    public function get_geaendert_von() {
        return $this->item["geaendert_von"];
    }

    public function set_geaendert_von($val, $sql_valid = FALSE) {
        $this->item["geaendert_von"] = $val;
    }

    public function get_kz_gebucht() {
        return $this->item["kz_gebucht"];
    }

    public function set_kz_gebucht($val, $sql_valid = FALSE) {
        $this->item["kz_gebucht"] = $val;
    }

    public function get_buchungskennzeichen($sql_valid = FALSE) {
        if (!isset($this->item["buchungskennzeichen"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["buchungskennzeichen"]) . "'";
        }
        return $this->item["buchungskennzeichen"];
    }

    public function set_buchungskennzeichen($val, $sql_valid = FALSE) {
        $this->item["buchungskennzeichen"] = $val;
    }

    public function get_mwst_20($sql_valid = FALSE) {
        if (!isset($this->item["mwst_20"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["mwst_20"], 2, ".", "");
        }

        return number_format((float) $this->item["mwst_20"], 2, ",", ".");
    }

    public function set_mwst_20($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["mwst_20"] = $val;
    }

    public function get_mwst_0($sql_valid = FALSE) {
        if (!isset($this->item["mwst_0"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["mwst_0"], 2, ".", "");
        }

        return number_format((float) $this->item["mwst_0"], 2, ",", ".");
    }

    public function set_mwst_0($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["mwst_0"] = $val;
    }

    public function get_mwst_10($sql_valid = FALSE) {
        if (!isset($this->item["mwst_10"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["mwst_10"], 2, ".", "");
        }

        return number_format((float) $this->item["mwst_10"], 2, ",", ".");
    }

    public function set_mwst_10($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["mwst_10"] = $val;
    }

    public function get_spesen($sql_valid = FALSE) {
        if (!isset($this->item["spesen"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["spesen"], 2, ".", "");
        }

        return number_format((float) $this->item["spesen"], 2, ",", ".");
    }

    public function set_spesen($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["spesen"] = $val;
    }

    public function get_rabatt($sql_valid = FALSE) {
        if (!isset($this->item["rabatt"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["rabatt"], 2, ".", "");
        }

        return number_format((float) $this->item["rabatt"], 2, ",", ".");
    }

    public function set_rabatt($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["rabatt"] = $val;
    }

    public function get_verguetung($sql_valid = FALSE) {
        if (!isset($this->item["verguetung"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["verguetung"], 2, ".", "");
        }

        return number_format((float) $this->item["verguetung"], 2, ",", ".");
    }

    public function set_verguetung($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["verguetung"] = $val;
    }

    public function get_ratenhoehe($sql_valid = FALSE) {
        if (!isset($this->item["ratenhoehe"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["ratenhoehe"], 2, ".", "");
        }

        return number_format((float) $this->item["ratenhoehe"], 2, ",", ".");
    }

    public function set_ratenhoehe($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["ratenhoehe"] = $val;
    }

    public function get_auftragsnummer($sql_valid = FALSE) {
        if (!isset($this->item["auftragsnummer"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["auftragsnummer"];
    }

    public function set_auftragsnummer($val, $sql_valid = FALSE) {
        $this->item["auftragsnummer"] = $val;
    }

    public function get_kz_manbuchung($sql_valid = FALSE) {
        if (!isset($this->item["kz_manbuchung"])) {
            if ($sql_valid) {
                return "'N'";
            }
            return NULL;
        }

        return $this->item["kz_manbuchung"];
    }

    public function set_kz_manbuchung($val, $sql_valid = FALSE) {
        $this->item["kz_manbuchung"] = $val;
    }

    public function get_herkunft($sql_valid = FALSE) {
        if (!isset($this->item["herkunft"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["herkunft"];
    }

    public function set_herkunft($val, $sql_valid = FALSE) {
        $this->item["herkunft"] = $val;
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

    public function get_bugru_key($sql_valid = FALSE) {
        return $this->item["bg_bugru_key"];
    }

    public function get_bugru_key_om($sql_valid = FALSE) {
        return $this->item["bg_bugru_key_om"];
    }

    public function get_kz_berechnung($sql_valid = FALSE) {
        return $this->item["bg_kz_berechnung"];
    }

    public function get_bugru_text($sql_valid = FALSE) {
        return $this->item["bg_text"];
    }

    public function get_buart_key($sql_valid = FALSE) {
        return $this->item["ba_buart_key"];
    }

    public function get_buart_text($sql_valid = FALSE) {
        return $this->item["ba_text"];
    }

    public function get_zahlart_text($sql_valid = FALSE) {
        return $this->item["zahlart_text"];
    }

    public static function count($mandant_id, $kdnr) {

        $query = "SELECT COUNT(b.id) as 'count' FROM buchungen b
                LEFT JOIN zahlart z on z.id = b.zahlart_id
                LEFT JOIN stammdaten sd ON sd.id = b.stammdaten_id
                LEFT JOIN kunde k ON k.id = sd.kunde_id
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";

        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public static function load_items($mandant_id, $kdnr, $start, $count, $order = "b.buchungsdatum DESC, b.id DESC ") {

        $query = "SELECT b.*, z.text as 'zahlart_text', bg.bugru_key as 'bg_bugru_key', right( cast(bg.bugru_key as char), 4) as 'bg_bugru_key_om', bg.kz_berechnung as 'bg_kz_berechnung', bg.kontoauszugstext as 'bg_text', 
                ba.buart_key as 'ba_buart_key', ba.text as 'ba_text' FROM buchungen b
                LEFT JOIN zahlart z on z.id = b.zahlart_id
                JOIN stammdaten sd ON sd.id = b.stammdaten_id
                JOIN kunde k ON k.id = sd.kunde_id
                JOIN bua_bgr_man bbm ON bbm.id = b.bua_bgr_man_id
                JOIN buchungsgrund bg on bg.id = bbm.bugru_id
                JOIN buchungsart ba on ba.id = bg.buchungsart_id
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";

        $query .= " ORDER BY $order LIMIT $start, $count";

        try {
            $items = App::$CURRENT->DB->query($query);
            $buchungen = array();
            foreach ($items as $value) {
                array_push($buchungen, new Buchung($value));
            }

            if (count($buchungen) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $buchungen;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function getarr($id) {

        $query = "SELECT b.*, k.kdnr as 'kdnr', z.text as 'zahlart_text', 
            bg.text as 'buchungstext', bg.id as 'bugru_id'
            FROM buchungen b
            LEFT JOIN zahlart z on z.id = b.zahlart_id
            LEFT JOIN stammdaten sd ON sd.id = b.stammdaten_id
            LEFT JOIN kunde k ON k.id = sd.kunde_id
            LEFT JOIN bua_bgr_man bgr ON bgr.id = b.bua_bgr_man_id
            LEFT JOIN buchungsgrund bg ON bg.id = bgr.bugru_id
            WHERE b.id = $id";

        try {
            $items = App::$CURRENT->DB->query($query);
            $buchungen = array();
            foreach ($items as $value) {
                array_push($buchungen, new Buchung($value));
            }

            if (count($buchungen) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $buchungen[0];
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
        
        
        
    }    

    public static function get($id) {

        $query = "SELECT b.*, k.kdnr as 'kdnr', z.text as 'zahlart_text', 
            bg.text as 'buchungstext', bg.id as 'bugru_id'
            FROM buchungen b
            LEFT JOIN zahlart z on z.id = b.zahlart_id
            LEFT JOIN stammdaten sd ON sd.id = b.stammdaten_id
            LEFT JOIN kunde k ON k.id = sd.kunde_id
            LEFT JOIN bua_bgr_man bgr ON bgr.id = b.bua_bgr_man_id
            LEFT JOIN buchungsgrund bg ON bg.id = bgr.bugru_id
            WHERE b.id = $id";
        try {
            //return new Buchung(App::$CURRENT->DB->singleObjectQuery($query));
            
            return App::$CURRENT->DB->singleObjectQuery($query);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    
    public static function insert($buchung, $closedb = TRUE, $con = NULL) {

        if ($con == NULL) {
            $con = App::$CURRENT->DB->manualOpen();
        }


        $query = "INSERT INTO `buchungen`( 
            `stammdaten_id`, 
            `bua_bgr_man_id`, 
            `betrag`,
            `buchungsdatum`,
            `valutadatum`,
            `mwst_id`,
            `zahlart_id`,
            `geaendert_am`,
            `geaendert_von`,
            `buchungskennzeichen`,
            `mwst_20`,
            `mwst_0`,
            `mwst_10`,
            `spesen`,
            `rabatt`,
            `verguetung`,
            `ratenhoehe`,
            `auftragsnummer`,
            `kz_manbuchung`,
            `kz_gebucht`,
            `herkunft`,
            `verwendungszweck`) 

            VALUES (" . $buchung->get_stammdaten_id() . ",
                " . $buchung->get_bua_bgr_man_id() . ",
                " . $buchung->get_betrag(TRUE) . ",
                " . $buchung->get_buchungsdatum(TRUE) . ",
                " . $buchung->get_valutadatum(TRUE) . ",
                " . $buchung->get_mwst_id(TRUE) . ",
                " . $buchung->get_zahlart_id(TRUE) . ",
                '" . date("Y-m-d H:i:s") . "',
                '" . App::$CURRENT->USER->get_name() . "',
                " . $buchung->get_buchungskennzeichen(TRUE) . ",
                " . $buchung->get_mwst_20(TRUE) . ",
                " . $buchung->get_mwst_0(TRUE) . ",
                " . $buchung->get_mwst_10(TRUE) . ",
                " . $buchung->get_spesen(TRUE) . ",
                " . $buchung->get_rabatt(TRUE) . ",
                " . $buchung->get_verguetung(TRUE) . ",
                " . $buchung->get_ratenhoehe(TRUE) . ",
                " . $buchung->get_auftragsnummer(TRUE) . ",
                " . $buchung->get_kz_manbuchung(TRUE) . ",
                " . $buchung->get_kz_gebucht(TRUE) . ",
                    " . $buchung->get_herkunft(TRUE) . ",
                " . $buchung->get_verwendungszweck(TRUE) . ")";

        try {
            if (Buchung::buch_saldo($con, $buchung->get_betrag(TRUE), $buchung->get_buchungsdatum(TRUE), $buchung->get_stammdaten_id(), $buchung->get_bua_bgr_man_id(), ($buchung->get_zahlart_id() == 2), $buchung->get_buchungskennzeichen(TRUE))) {
                App::$CURRENT->DB->manualQuery($query, $con, FALSE);
                if ($closedb) {
                    App::$CURRENT->DB->commit($con);
                    App::$CURRENT->DB->manualClose($con);
                }
                return TRUE;
            } else {
                if ($closedb) {
                    App::$CURRENT->DB->rollback($con);
                    App::$CURRENT->DB->manualClose($con);
                }
                Return FALSE;
            }
        } catch (Exception $e) {

            App::$CURRENT->add_error($e->getMessage());
            if ($closedb) {
                App::$CURRENT->DB->rollback($con);
                App::$CURRENT->DB->manualClose($con);
            }
            Return FALSE;
        }
        Return TRUE;
    }

    public static function update_kz_gebucht($buchung, $id, $closedb = TRUE, $con = NULL) {
//        $con = App::$CURRENT->DB->manualOpen();
        if ($con == NULL) {
            $con = App::$CURRENT->DB->manualOpen();
        }


        $query = "UPDATE `buchungen` SET
                kz_gebucht = " . $buchung->kz_gebucht . ",
                geaendert_von = '" . App::$CURRENT->USER->get_name() . "',
                geaendert_am = '" . date("Y-m-d H:i:s") . "'
            WHERE id = " . $id;
        try {
            $weiter = TRUE;

            if ($buchung->kz_gebucht == "'J'") {

                $weiter = Buchung::buch_saldo($con, $buchung->betrag, $buchung->buchungsdatum, $buchung->stammdaten_id, $buchung->bua_bgr_man_id, ($buchung->zahlart_id == 2), $buchung->buchungskennzeichen);
            }
            if ($weiter) {
                App::$CURRENT->DB->manualQuery($query, $con, FALSE);
                if ($closedb) {
                    App::$CURRENT->DB->commit($con);
                    App::$CURRENT->DB->manualClose($con);
                }
                return TRUE;
            } else {
                if ($closedb) {
                    App::$CURRENT->DB->rollback($con);
                    App::$CURRENT->DB->manualClose($con);
                }
                return FALSE;
            }
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            Return FALSE;
        }
        Return TRUE;
    }

    public static function buch_saldo($db, $buchungsbetrag, $buchungsdatum, $stammdaten_id, $bua_bgr_man_id, $is_rvc, $storno) {

        $bugrund = Buchungsgrund::get_from_bua_bgr_man_id($bua_bgr_man_id);
        $stamm = Stammdaten::get($stammdaten_id);

        if ($buchungsbetrag == 0 || ($bugrund->kz_saldowirksam != 'J')) {
            $buchungsdatum = str_replace("'", "", $buchungsdatum);
            $stamm->set_dat_ltzt_buchung($buchungsdatum);
            return ( Stammdaten::update_from_buchung($db, $stamm));
            //return TRUE;
        }

        if ($bugrund->kz_berechnung == "M") {
            $multi = 1;
        } else {
            $multi = -1;
        }

        if ($storno == 1 || $storno == "'1'") {
            $multi = $multi * -1;
        }

        $betrag = $buchungsbetrag * $multi;


        if ($is_rvc == TRUE) {
            $temp = $stamm->get_gesamtsaldo_rcs(TRUE);
            $temp += $betrag;
            $stamm->set_gesamtsaldo_rvc($temp, TRUE);
        } else {
            $temp = $stamm->get_gesamtsaldo_1x(TRUE);
            $temp += $betrag;
            $stamm->set_gesamtsaldo_1x($temp, TRUE);
        }
        $gessaldo = $stamm->get_gesamtsaldo(TRUE);
        $gessaldo += $betrag;
        $stamm->set_gesamtsaldo($gessaldo, TRUE);

        $buchungsdatum = str_replace("'", "", $buchungsdatum);
        $datestamm = substr((string) $stamm->get_dat_ltzt_buchung(FALSE), 6, 4) . substr((string) $stamm->get_dat_ltzt_buchung(FALSE), 3, 2) . substr((string) $stamm->get_dat_ltzt_buchung(FALSE), 0, 2);

        $date = date_format(date_create($buchungsdatum), "Y-m-d H:i:s");

        if ($date > $datestamm || 1 == 1) {
            $stamm->set_dat_ltzt_buchung($buchungsdatum);
        }
        return ( Stammdaten::update_from_buchung($db, $stamm));
    }

    public static function calc_saldo($buchungsbetrag, $kz_berechnung, $kz_saldowirksam, $storno) {

        $buchungsbetrag = abs($buchungsbetrag);

        if ($buchungsbetrag == 0 || ($kz_saldowirksam != 'J')) {
            return 0;
        }

        if ($kz_berechnung == 'M') {
            $multi = 1;
        } else {
            $multi = -1;
        }

        if ($storno == 1) {
            $multi = $multi * -1;
        }

        return $buchungsbetrag * $multi;
    }

}

