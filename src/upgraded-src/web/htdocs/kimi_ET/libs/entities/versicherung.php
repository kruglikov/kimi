<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of versicherung
 *
 * @author Roni
 */
class Versicherung {

    private $item;

    public function __construct($item) {
        $this->item = (array) $item;
        $this->add_informations($item);
    }

    public function add_informations($informations) {
        foreach ($informations as $key => $value) {
            $name = "set_" . $key;

            if (method_exists($this, $name)) {
                $this->$name($value);
            }
        }
    }

    public function get_id() {
        return $this->item["id"];
    }

    public function set_id($val) {
        $this->item["id"] = $val;
    }

    public function get_stammdaten_id() {
        return $this->item["stammdaten_id"];
    }

    public function set_stammdaten_id($val) {
        $this->item["stammdaten_id"] = $val;
    }

    public function get_mandant_id() {
        return $this->item["mandant_id"];
    }

    public function set_mandant_id($val) {
        $this->item["mandant_id"] = $val;
    }

    public function get_versicherungsvariante($sql_valid = FALSE) {
        if (!isset($this->item["versicherungsvariante"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["versicherungsvariante"];
    }

    public function set_versicherungsvariante($val) {
        $this->item["versicherungsvariante"] = $val;
    }

    public function get_versicherung_bezeichnung($sql_valid = FALSE) {
        if (!isset($this->item["versicherung_bezeichnung"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["versicherung_bezeichnung"]) . "'";
        }
        return $this->item["versicherung_bezeichnung"];
    }

    public function set_versicherung_bezeichnung($val) {
        $this->item["versicherung_bezeichnung"] = $val;
    }

    public function get_dat_abschluss($sql_valid = FALSE) {
        if (!isset($this->item["dat_abschluss"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_abschluss"]) . "'";
        }

        $date = date_create($this->item["dat_abschluss"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_abschluss($val) { {
            if (strlen((string) $val) == 0) {
                $this->item["dat_abschluss"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_abschluss"] = date_format($date, "Y-m-d");
        }
    }

    public function get_user_abschluss($sql_valid = FALSE) {
        if (!isset($this->item["user_abschluss"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["user_abschluss"]) . "'";
        }
        return $this->item["user_abschluss"];
    }

    public function set_user_abschluss($val) {
        $this->item["user_abschluss"] = $val;
    }

    public function get_dat_storno($sql_valid = FALSE) {
        if (!isset($this->item["dat_storno"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_storno"]) . "'";
        }

        $date = date_create($this->item["dat_storno"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_storno($val) { {
            if (strlen((string) $val) == 0) {
                $this->item["dat_storno"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_storno"] = date_format($date, "Y-m-d");
        }
    }

    public function get_user_storno($sql_valid = FALSE) {
        if (!isset($this->item["user_storno"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["user_storno"]) . "'";
        }
        return $this->item["user_storno"];
    }

    public function set_user_storno($val) {
        $this->item["user_storno"] = $val;
    }

    public function get_dat_meldung_abschluss($sql_valid = FALSE) {
        if (!isset($this->item["dat_meldung_abschluss"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_meldung_abschluss"]) . "'";
        }

        $date = date_create($this->item["dat_meldung_abschluss"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_meldung_abschluss($val) { {
            if (strlen((string) $val) == 0) {
                $this->item["dat_meldung_abschluss"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_meldung_abschluss"] = date_format($date, "Y-m-d");
        }
    }

    public function get_dat_info_aend_bed($sql_valid = FALSE) {
        if (!isset($this->item["dat_info_aend_bed"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_info_aend_bed"]) . "'";
        }

        $date = date_create($this->item["dat_info_aend_bed"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_info_aend_bed($val) { {
            if (strlen((string) $val) == 0) {
                $this->item["dat_info_aend_bed"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_info_aend_bed"] = date_format($date, "Y-m-d");
        }
    }

    public function get_geaendert_von() {
        return $this->item["geaendert_von"];
    }

    public function set_geaendert_von($val) {
        $this->item["geaendert_von"] = $val;
    }

    public static function count($mandant_id, $kdnr) {

        $query = "SELECT COUNT(v.id) as 'count' FROM versicherung v
                JOIN stammdaten sd ON sd.id = v.stammdaten_id
                JOIN kunde k ON k.id = sd.kunde_id
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";
        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public static function load_items($mandant_id, $kdnr, $start, $count, $order = "v.dat_abschluss ASC, v.id ") {

        $query = "SELECT v.* 
                FROM versicherung v 
                JOIN stammdaten sd ON sd.id = v.stammdaten_id
                JOIN kunde k ON k.id = sd.kunde_id
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";

        $query .= " ORDER BY $order LIMIT $start, $count";
        try {
            $items = App::$CURRENT->DB->query($query);
            $versicherungen = array();
            foreach ($items as $value) {
                array_push($versicherungen, new Versicherung($value));
            }

            if (count($versicherungen) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $versicherungen;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get($id) {

        $query = "SELECT v.*
            FROM versicherung v
            WHERE v.id = $id";
        try {
            return new Versicherung(App::$CURRENT->DB->singleObjectQuery($query));
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function insert($record) {
        $con = App::$CURRENT->DB->manualOpen();

        $query = "INSERT INTO `versicherung`( 
            `stammdaten_id`, 
            `mandant_id`, 
            `versicherungsvariante`,
            `versicherung_bezeichnung`,
            `dat_abschluss`,
            `user_abschluss`,
            `dat_storno`,
            `user_storno`,
            `dat_meldung_abschluss`,
            `dat_info_aend_bed`,
            `geaendert_am`,
            `geaendert_von`) 

            VALUES (" . $record->get_stammdaten_id(TRUE) . ",
                " . $record->get_mandant_id(TRUE) . ",
                " . $record->get_versicherungsvariante(TRUE) . ",
                " . $record->get_versicherung_bezeichnung(TRUE) . ",
                " . $record->get_dat_abschluss(TRUE) . ",
                " . $record->get_user_abschluss(TRUE) . ",
                " . $record->get_dat_storno(TRUE) . ",
                " . $record->get_user_storno(TRUE) . ",
                " . $record->get_dat_meldung_abschluss(TRUE) . ",
                " . $record->get_dat_info_aend_bed(TRUE) . ",
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
        $query = "UPDATE `versicherung` SET
            `versicherungsvariante` = " . $record->get_versicherungsvariante(TRUE) . ", 
            `dat_abschluss` = " . $record->get_dat_abschluss(TRUE) . ", 
            `user_abschluss` = " . $record->get_user_abschluss(TRUE) . ", 
            `dat_storno` = " . $record->get_dat_storno(TRUE) . ", 
            `user_storno` = " . $record->get_user_storno(TRUE) . ", 
            `dat_meldung_abschluss` = " . $record->get_dat_meldung_abschluss(TRUE) . ", 
            `dat_info_aend_bed` = " . $record->get_dat_info_aend_bed(TRUE) . ", 
            `versicherung_bezeichnung` = " . $record->get_versicherung_bezeichnung(TRUE) . ", 
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
        $query = "DELETE FROM `versicherung` 
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

