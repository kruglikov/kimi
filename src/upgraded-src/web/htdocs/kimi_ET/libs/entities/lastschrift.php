<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lastschrift
 *
 * @author Roni
 */
class Lastschrift {

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

    public function get_iban($sql_valid = FALSE) {
        if (!isset($this->item["iban"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["iban"]) . "'";
        }
        return $this->item["iban"];
    }

    public function set_iban($val, $sql_valid = FALSE) {
        $this->item["iban"] = $val;
    }

    public function get_kontonummer($sql_valid = FALSE) {
        if (!isset($this->item["kontonummer"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return (float) $this->item["kontonummer"];
    }

    public function set_kontonummer($val, $sql_valid = FALSE) {
        $this->item["kontonummer"] = $val;
    }

    public function get_bankleitzahl_id($sql_valid = FALSE) {
        return $this->item["bankleitzahl_id"];
    }

    public function set_bankleitzahl_id($val, $sql_valid = FALSE) {
        $this->item["bankleitzahl_id"] = $val;
    }

    public function get_kontoinhaber($sql_valid = FALSE) {
        if (!isset($this->item["kontoinhaber"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kontoinhaber"]) . "'";
        }
        return $this->item["kontoinhaber"];
    }

    public function set_kontoinhaber($val, $sql_valid = FALSE) {
        $this->item["kontoinhaber"] = $val;
    }

    public function get_kz_lastschrift($sql_valid = FALSE) {
        if (!isset($this->item["kz_lastschrift"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kz_lastschrift"]) . "'";
        }
        return $this->item["kz_lastschrift"];
    }

    public function set_kz_lastschrift($val, $sql_valid = FALSE) {
        $this->item["kz_lastschrift"] = $val;
    }

    public function get_kz_kzinaktiv($sql_valid = FALSE) {
        if (!isset($this->item["kz_kzinaktiv"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kz_kzinaktiv"]) . "'";
        }
        return $this->item["kz_kzinaktiv"];
    }

    public function set_kz_kzinaktiv($val, $sql_valid = FALSE) {
        $this->item["kz_kzinaktiv"] = $val;
    }

    public function get_dat_lastschrift($sql_valid = FALSE) {
        if (!isset($this->item["dat_lastschrift"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_lastschrift"]) . "'";
        }

        $date = date_create($this->item["dat_lastschrift"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_lastschrift($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["dat_lastschrift"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_lastschrift"] = date_format($date, "Y-m-d");
        }
    }

    public function get_dat_unterschrift($sql_valid = FALSE) {
        if (!isset($this->item["dat_unterschrift"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_unterschrift"]) . "'";
        }

        $date = date_create($this->item["dat_unterschrift"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_unterschrift($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["dat_unterschrift"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_unterschrift"] = date_format($date, "Y-m-d");
        }
    }

    public function get_dat_inaktiv($sql_valid = FALSE) {
        if (!isset($this->item["dat_inaktiv"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_inaktiv"]) . "'";
        }

        $date = date_create($this->item["dat_inaktiv"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_inaktiv($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["dat_inaktiv"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_inaktiv"] = date_format($date, "Y-m-d");
        }
    }

    public function get_sepa_einzug_sequenz($sql_valid = FALSE) {
        if (!isset($this->item["sepa_einzug_sequenz"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["sepa_einzug_sequenz"]) . "'";
        }
        return $this->item["sepa_einzug_sequenz"];
    }

    public function set_sepa_einzug_sequenz($val, $sql_valid = FALSE) {
        $this->item["sepa_einzug_sequenz"] = $val;
    }

    public function get_max_einzbetrag($sql_valid = FALSE) {
        if (!isset($this->item["max_einzbetrag"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["max_einzbetrag"], 2, ".", "");
        }

        return number_format((float) $this->item["max_einzbetrag"], 2, ",", ".");
    }

    public function set_max_einzbetrag($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
        $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["max_einzbetrag"] = $val;
    }

    public function get_dat_einzbetrag($sql_valid = FALSE) {
        if (!isset($this->item["dat_einzbetrag"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_einzbetrag"]) . "'";
        }

        $date = date_create($this->item["dat_einzbetrag"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_einzbetrag($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["dat_einzbetrag"] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item["dat_einzbetrag"] = date_format($date, "Y-m-d");
        }
    } 

    public function get_geaendert_von() {
        return $this->item["geaendert_von"];
    }

    public function set_geaendert_von($val, $sql_valid = FALSE) {
        $this->item["geaendert_von"] = $val;
    }

    // Sonstige Getter

    public function get_blz_bankleitzahl($sql_valid = FALSE) {
        if (!isset($this->item["blz_bankleitzahl"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["blz_bankleitzahl"];
    }

    public function get_blz_bank($sql_valid = FALSE) {
        if (!isset($this->item["blz_bank"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["blz_bank"];
    }

    public function get_blz_bic($sql_valid = FALSE) {
        if (!isset($this->item["blz_bic"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["blz_bic"];
    }

    public function get_blz_kz_sepa_faehig($sql_valid = FALSE) {
        if (!isset($this->item["blz_kz_sepa_faehig"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["blz_kz_sepa_faehig"];
    }

  

    public static function count($mandant_id, $kdnr) {

        $query = "SELECT COUNT(s.id) as 'count' FROM lastschrift s
                JOIN stammdaten sd ON sd.id = s.stammdaten_id
                JOIN kunde k ON k.id = sd.kunde_id
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";
        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public static function load_items($mandant_id, $kdnr, $start, $count, $order = "s.dat_lastschrift desc, s.id desc") {

        $query = "SELECT s.*, b.bankleitzahl as 'blz_bankleitzahl', b.bank as 'blz_bank', b.bic as 'blz_bic', b.kz_sepa_faehig as 'blz_kz_sepa_faehig'  
                FROM lastschrift s 
                JOIN stammdaten sd ON sd.id = s.stammdaten_id
                JOIN kunde k ON k.id = sd.kunde_id
                JOIN bankleitzahl b on b.id = s.bankleitzahl_id
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";

        $query .= " ORDER BY $order LIMIT $start, $count";
        try {
            $items = App::$CURRENT->DB->query($query);
            $lastschrift = array();
            foreach ($items as $value) {
                array_push($lastschrift, new Lastschrift($value));
            }

            if (count($lastschrift) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $lastschrift;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get($id) {

        $query = "SELECT s.*, b.bankleitzahl as 'blz_bankleitzahl', b.bank as 'blz_bank', b.bic as 'blz_bic', b.kz_sepa_faehig as 'blz_kz_sepa_faehig'  
            FROM lastschrift s
                JOIN bankleitzahl b on b.id = s.bankleitzahl_id
            WHERE s.id = $id";
        try {
            return new Lastschrift(App::$CURRENT->DB->singleObjectQuery($query));
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function insert($record) {
        $con = App::$CURRENT->DB->manualOpen();

        $query = "INSERT INTO `lastschrift`( 
            `stammdaten_id`, 
            `mandant_id`, 
            `iban`,
            `kontonummer`,
            `bankleitzahl_id`,
            `kontoinhaber`,
            `kz_lastschrift`,
            `kz_kzinaktiv`,
            `dat_lastschrift`,
            `dat_unterschrift`,
            `dat_inaktiv`,
            `sepa_einzug_sequenz`,
            `max_einzbetrag`,
            `dat_einzbetrag`,
            `geaendert_am`,
            `geaendert_von`) 

            VALUES (" . $record->get_stammdaten_id(TRUE) . ",
                " . $record->get_mandant_id(TRUE) . ",
                " . $record->get_iban(TRUE) . ",
                " . $record->get_kontonummer(TRUE) . ",
                " . $record->get_bankleitzahl_id(TRUE) . ",
                " . $record->get_kontoinhaber(TRUE) . ",
                " . $record->get_kz_lastschrift(TRUE) . ",
                " . $record->get_kz_kzinaktiv(TRUE) . ",
                " . $record->get_dat_lastschrift(TRUE) . ",
                " . $record->get_dat_unterschrift(TRUE) . ",
                " . $record->get_dat_inaktiv(TRUE) . ",
                " . $record->get_sepa_einzug_sequenz(TRUE) . ",
                " . $record->get_max_einzbetrag(TRUE) . ",
                " . $record->get_dat_einzbetrag(TRUE) . ",
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
        $query = "UPDATE `lastschrift` SET
            `iban` = " . $record->get_iban(TRUE) . ", 
            `kontonummer` = " . $record->get_kontonummer(TRUE) . ", 
            `bankleitzahl_id` = " . $record->get_bankleitzahl_id(TRUE) . ", 
            `kontoinhaber` = " . $record->get_kontoinhaber(TRUE) . ", 
            `kz_lastschrift` = " . $record->get_kz_lastschrift(TRUE) . ", 
            `kz_kzinaktiv` = " . $record->get_kz_kzinaktiv(TRUE) . ", 
            `dat_lastschrift` = " . $record->get_dat_lastschrift(TRUE) . ", 
            `dat_unterschrift` = " . $record->get_dat_unterschrift(TRUE) . ", 
            `dat_inaktiv` = " . $record->get_dat_inaktiv(TRUE) . ", 
            `sepa_einzug_sequenz` = " . $record->get_sepa_einzug_sequenz(TRUE) . ", 
            `max_einzbetrag` = " . $record->get_max_einzbetrag(TRUE) . ", 
            `dat_einzbetrag` = " . $record->get_dat_einzbetrag(TRUE) . ", 
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
        $query = "DELETE FROM `lastschrift` 
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

