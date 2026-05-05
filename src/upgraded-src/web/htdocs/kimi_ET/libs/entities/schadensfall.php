<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of schadensfall
 *
 * @author Roni
 */
class Schadensfall {

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

    public function get_mandant_id() {
        return $this->item["mandant_id"];
    }

    public function set_mandant_id($val, $sql_valid = FALSE) {
        $this->item["mandant_id"] = $val;
    }

    public function get_schadensfall_art_id() {
        return $this->item["schadensfall_art_id"];
    }

    public function set_schadensfall_art_id($val, $sql_valid = FALSE) {
        $this->item["schadensfall_art_id"] = $val;
    }

    public function get_status_schadensfall_id() {
        return $this->item["status_schadensfall_id"];
    }

    public function set_status_schadensfall_id($val, $sql_valid = FALSE) {
        $this->item["status_schadensfall_id"] = $val;
    }

    public function get_dat_schadenseintritt($sql_valid = FALSE) {
        if (!isset($this->item["dat_schadenseintritt"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_schadenseintritt"]) . "'";
        }

        $date = date_create($this->item["dat_schadenseintritt"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_schadenseintritt($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["dat_schadenseintritt"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_schadenseintritt"] = date_format($date, "Y-m-d");
        }
    }

    public function get_dat_ende_schadensleistung($sql_valid = FALSE) {
        if (!isset($this->item["dat_ende_schadensleistung"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_ende_schadensleistung"]) . "'";
        }

        $date = date_create($this->item["dat_ende_schadensleistung"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_ende_schadensleistung($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["dat_ende_schadensleistung"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_ende_schadensleistung"] = date_format($date, "Y-m-d");
        }
    }

    public function get_dat_gemeldet($sql_valid = FALSE) {
        if (!isset($this->item["dat_gemeldet"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_gemeldet"]) . "'";
        }

        $date = date_create($this->item["dat_gemeldet"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_gemeldet($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["dat_gemeldet"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_gemeldet"] = date_format($date, "Y-m-d");
        }
    }

    public function get_dat_pruefung($sql_valid = FALSE) {
        if (!isset($this->item["dat_pruefung"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_pruefung"]) . "'";
        }

        $date = date_create($this->item["dat_pruefung"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_pruefung($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["dat_pruefung"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_pruefung"] = date_format($date, "Y-m-d");
        }
    }

    public function get_dat_leistung($sql_valid = FALSE) {
        if (!isset($this->item["dat_leistung"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_leistung"]) . "'";
        }

        $date = date_create($this->item["dat_leistung"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_leistung($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["dat_leistung"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_leistung"] = date_format($date, "Y-m-d");
        }
    }

    public function get_dat_zahlungseingang($sql_valid = FALSE) {
        if (!isset($this->item["dat_zahlungseingang"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_zahlungseingang"]) . "'";
        }

        $date = date_create($this->item["dat_zahlungseingang"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_zahlungseingang($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["dat_zahlungseingang"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_zahlungseingang"] = date_format($date, "Y-m-d");
        }
    }

    public function get_dat_erledigt($sql_valid = FALSE) {
        if (!isset($this->item["dat_erledigt"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_erledigt"]) . "'";
        }

        $date = date_create($this->item["dat_erledigt"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_erledigt($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["dat_erledigt"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_erledigt"] = date_format($date, "Y-m-d");
        }
    }

    public function get_saldo_gemeldet($sql_valid = FALSE) {
        if (!isset($this->item["saldo_gemeldet"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["saldo_gemeldet"], 2, ".", "");
        }

        return number_format((float) $this->item["saldo_gemeldet"], 2, ",", ".");
    }

    public function set_saldo_gemeldet($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["saldo_gemeldet"] = $val;
    }

    public function get_forderungsart($sql_valid = FALSE) {
        if (!isset($this->item["forderungsart"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["forderungsart"]) . "'";
        }
        return $this->item["forderungsart"];
    }

    public function set_forderungsart($val, $sql_valid = FALSE) {
        $this->item["forderungsart"] = $val;
    }

    public function get_forderungsbetrag($sql_valid = FALSE) {
        if (!isset($this->item["forderungsbetrag"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["forderungsbetrag"], 2, ".", "");
        }

        return number_format((float) $this->item["forderungsbetrag"], 2, ",", ".");
    }

    public function set_forderungsbetrag($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["forderungsbetrag"] = $val;
    }

    public function get_leistung_ab($sql_valid = FALSE) {
        if (!isset($this->item["leistung_ab"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["leistung_ab"]) . "'";
        }

        $date = date_create($this->item["leistung_ab"]);
        return date_format($date, "d.m.Y");
    }

    public function set_leistung_ab($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["leistung_ab"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["leistung_ab"] = date_format($date, "Y-m-d");
        }
    }

    public function get_maximale_leistung($sql_valid = FALSE) {
        if (!isset($this->item["maximale_leistung"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["maximale_leistung"], 2, ".", "");
        }

        return number_format((float) $this->item["maximale_leistung"], 2, ",", ".");
    }

    public function set_maximale_leistung($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["maximale_leistung"] = $val;
    }

    public function get_zahlungsbetrag($sql_valid = FALSE) {
        if (!isset($this->item["zahlungsbetrag"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["zahlungsbetrag"], 2, ".", "");
        }

        return number_format((float) $this->item["zahlungsbetrag"], 2, ",", ".");
    }

    public function set_zahlungsbetrag($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["zahlungsbetrag"] = $val;
    }

    public function get_geaendert_von() {
        return $this->item["geaendert_von"];
    }

    public function set_geaendert_von($val, $sql_valid = FALSE) {
        $this->item["geaendert_von"] = $val;
    }

    // Sonstige Getter

    public function get_schadensfall_text($sql_valid = FALSE) {
        if (!isset($this->item["schadensfall_text"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["schadensfall_text"]) . "'";
        }
        return $this->item["schadensfall_text"];
    }

    public function get_status_kurz_text($sql_valid = FALSE) {
        if (!isset($this->item["status_kurz_text"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["status_kurz_text"]) . "'";
        }
        return $this->item["status_kurz_text"];
    }

    public function get_status_text($sql_valid = FALSE) {
        if (!isset($this->item["status_text"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["status_text"]) . "'";
        }
        return $this->item["status_text"];
    }

    public static function count($mandant_id, $kdnr) {

        $query = "SELECT COUNT(s.id) as 'count' FROM schadensfall s
                JOIN stammdaten sd ON sd.id = s.stammdaten_id
                JOIN kunde k ON k.id = sd.kunde_id
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";
        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public static function load_items($mandant_id, $kdnr, $start, $count, $order = "s.dat_schadenseintritt desc, s.dat_erledigt, s.id") {

        $query = "SELECT s.*, sa.text as 'schadensfall_text', ss.kurz_text as 'status_kurz_text', ss.text as 'status_text' 
                FROM schadensfall s 
                JOIN stammdaten sd ON sd.id = s.stammdaten_id
                JOIN kunde k ON k.id = sd.kunde_id
                JOIN status_schadensfall ss on ss.id = s.status_schadensfall_id
                JOIN schadensfall_art sa on sa.id = s.schadensfall_art_id
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";

        $query .= " ORDER BY $order LIMIT $start, $count";
        try {
            $items = App::$CURRENT->DB->query($query);
            $schadensfall = array();
            foreach ($items as $value) {
                array_push($schadensfall, new Schadensfall($value));
            }

            if (count($schadensfall) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $schadensfall;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get($id) {

        $query = "SELECT s.*, sa.text as 'schadensfall_text', ss.kurz_text as 'status_kurz_text', ss.text as 'status_text' 
            FROM schadensfall s
                JOIN status_schadensfall ss on ss.id = s.status_schadensfall_id
                JOIN schadensfall_art sa on sa.id = s.schadensfall_art_id
            WHERE s.id = $id";
        try {
            return new Schadensfall(App::$CURRENT->DB->singleObjectQuery($query));
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function insert($record) {
        $con = App::$CURRENT->DB->manualOpen();

        $query = "INSERT INTO `schadensfall`( 
            `stammdaten_id`, 
            `mandant_id`, 
            `schadensfall_art_id`,
            `dat_schadenseintritt`,
            `dat_ende_schadensleistung`,
            `status_schadensfall_id`,
            `dat_gemeldet`,
            `dat_pruefung`,
            `dat_leistung`,
            `dat_zahlungseingang`,
            `dat_erledigt`,
            `saldo_gemeldet`,
            `forderungsart`,
            `forderungsbetrag`,
            `leistung_ab`,
            `maximale_leistung`,
            `zahlungsbetrag`,
            `geaendert_am`,
            `geaendert_von`) 

            VALUES (" . $record->get_stammdaten_id(TRUE) . ",
                " . $record->get_mandant_id(TRUE) . ",
                " . $record->get_schadensfall_art_id(TRUE) . ",
                " . $record->get_dat_schadenseintritt(TRUE) . ",
                " . $record->get_dat_ende_schadensleistung(TRUE) . ",
                " . $record->get_status_schadensfall_id(TRUE) . ",
                " . $record->get_dat_gemeldet(TRUE) . ",
                " . $record->get_dat_pruefung(TRUE) . ",
                " . $record->get_dat_leistung(TRUE) . ",
                " . $record->get_dat_zahlungseingang(TRUE) . ",
                " . $record->get_dat_erledigt(TRUE) . ",
                " . $record->get_saldo_gemeldet(TRUE) . ",
                " . $record->get_forderungsart(TRUE) . ",
                " . $record->get_forderungsbetrag(TRUE) . ",
                " . $record->get_leistung_ab(TRUE) . ",
                " . $record->get_maximale_leistung(TRUE) . ",
                " . $record->get_zahlungsbetrag(TRUE) . ",
                '" . date("Y-m-d H:i:s") . "',
                '" . App::$CURRENT->USER->get_name() . "')";


        try {
            App::$CURRENT->DB->manualQuery($query, $con, FALSE);
            App::$CURRENT->DB->commit($con);
            App::$CURRENT->DB->manualClose($con);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            App::$CURRENT->DB->rollback($con);
            App::$CURRENT->DB->manualClose($con);
        }
    }

    public static function update($record, $id) {
        $con = App::$CURRENT->DB->manualOpen();
        $query = "UPDATE `schadensfall` SET
            `schadensfall_art_id` = " . $record->get_schadensfall_art_id(TRUE) . ", 
            `dat_schadenseintritt` = " . $record->get_dat_schadenseintritt(TRUE) . ", 
            `dat_ende_schadensleistung` = " . $record->get_dat_ende_schadensleistung(TRUE) . ", 
            `status_schadensfall_id` = " . $record->get_status_schadensfall_id(TRUE) . ", 
            `dat_gemeldet` = " . $record->get_dat_gemeldet(TRUE) . ", 
            `dat_pruefung` = " . $record->get_dat_pruefung(TRUE) . ", 
            `dat_leistung` = " . $record->get_dat_leistung(TRUE) . ", 
            `dat_zahlungseingang` = " . $record->get_dat_zahlungseingang(TRUE) . ", 
            `dat_erledigt` = " . $record->get_dat_erledigt(TRUE) . ", 
            `saldo_gemeldet` = " . $record->get_saldo_gemeldet(TRUE) . ", 
            `forderungsart` = " . $record->get_forderungsart(TRUE) . ", 
            `forderungsbetrag` = " . $record->get_forderungsbetrag(TRUE) . ", 
            `leistung_ab` = " . $record->get_leistung_ab(TRUE) . ", 
            `maximale_leistung` = " . $record->get_maximale_leistung(TRUE) . ", 
            `zahlungsbetrag` = " . $record->get_zahlungsbetrag(TRUE) . ", 
            `geaendert_am` = '" . date("Y-m-d H:i:s") . "',
            `geaendert_von` = '" . App::$CURRENT->USER->get_name() . "' 
            WHERE id = " . $id;
        try {
            App::$CURRENT->DB->manualQuery($query, $con, FALSE);
            App::$CURRENT->DB->commit($con);
            App::$CURRENT->DB->manualClose($con);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function delete($id) {
        $con = App::$CURRENT->DB->manualOpen();
        $query = "DELETE FROM `schadensfall` 
            WHERE id = " . $id;
        try {
            App::$CURRENT->DB->manualQuery($query, $con, FALSE);
            App::$CURRENT->DB->commit($con);
            App::$CURRENT->DB->manualClose($con);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

}

