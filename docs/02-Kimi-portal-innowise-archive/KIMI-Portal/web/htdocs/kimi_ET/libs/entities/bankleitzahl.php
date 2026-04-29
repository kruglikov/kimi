<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bankleitzahl
 *
 * @author Ronald
 */
class Bankleitzahl {

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

    public function get_blz($sql_valid = FALSE) {
        if (!isset($this->item["blz"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        return $this->item["blz"];
    }
    public function set_blz($val) { 
        $this->item["blz"] = $val;
    }
    

    public function get_bank($sql_valid = FALSE) {
        if (!isset($this->item["bank"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["bank"]) . "'";
        }
        return $this->item["bank"];
    }
    public function set_bank($val) { 
        $this->item["bank"] = $val;
    }
        
    public function get_bic($sql_valid = FALSE) {
        if (!isset($this->item["bic"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["bic"]) . "'";
        }
        return $this->item["bic"];
    }
    public function set_bic($val) { 
        $this->item["bic"] = $val;
    }

    public function get_kz_sepa_faehig($sql_valid = FALSE) {
        if (!isset($this->item["kz_sepa_faehig"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kz_sepa_faehig"]) . "'";
        }
        return $this->item["kz_sepa_faehig"];
    }
    public function set_kz_sepa_faehig($val) { 
        $this->item["kz_sepa_faehig"] = $val;
    }
    
    

    public static function load_all() {

        $query = "SELECT b.id, b.bankleitzahl as 'blz', b.bank, b.bic, b.kz_sepa_faehig, b.geaendert_am, b.geaendert_von FROM bankleitzahl b ORDER BY bankleitzahl, bank";
        $result = array();
        $response = App::$CURRENT->DB->query($query);

        foreach ($response as $item) {
            array_push($result, new Bankleitzahl($item));
        }
        return $result;
    }

    public static function count($blz, $bank) {

        $where = "";
        $query = "SELECT COUNT(id) as 'count' FROM bankleitzahl ";
        
        if ($blz != NULL) {
            $where .= " WHERE bankleitzahl = $blz ";
        }
        if ($bank != NULL) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where = " WHERE ";
            }
            $where .= " bank like '%$bank%'";
        }
        $query .= $where;
        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public static function load_items($blz, $bank, $start, $count, $order = "bankleitzahl, id ") {

        $query = "SELECT b.id, b.bankleitzahl as 'blz', b.bank, b.bic, b.kz_sepa_faehig, b.geaendert_am, b.geaendert_von FROM bankleitzahl b ";
        $where = "";
        if ($blz != NULL) {
            $where .= " WHERE bankleitzahl = $blz ";
        }
        if ($bank != NULL) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where = " WHERE ";
            }
            $where .= " bank like '%$bank%'";
        }
        $query .= $where;
        $query .= " ORDER BY $order LIMIT $start, $count";
        try {
            $items = App::$CURRENT->DB->query($query);
            $records = array();
            foreach ($items as $value) {
                array_push($records, new Bankleitzahl($value));
            }

            if (count($records) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $records;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get($id) {

        $query = "SELECT b.id, b.bankleitzahl as 'blz', b.bank, b.bic, b.kz_sepa_faehig, b.geaendert_am, b.geaendert_von
            FROM bankleitzahl b 
            WHERE b.id = $id";
        try {
            return App::$CURRENT->DB->singleObjectQuery($query);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get_from_blz($blz) {

        $query = "SELECT b.id, b.bankleitzahl as 'blz', b.bank, b.bic, b.kz_sepa_faehig, b.geaendert_am, b.geaendert_von
            FROM bankleitzahl b 
            WHERE b.bankleitzahl = $blz";
        try {
            return App::$CURRENT->DB->singleObjectQuery($query);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    
    public static function insert($record) {
        $con = App::$CURRENT->DB->manualOpen();

        $query = "INSERT INTO `bankleitzahl`( 
            `bankleitzahl`, 
            `bank`, 
            `bic`, 
            `kz_sepa_faehig`, 
            `geaendert_am`,
            `geaendert_von`) 

            VALUES (" . $record->get_blz(TRUE) . ",
                " . $record->get_bank(TRUE). ",
                " . $record->get_bic(TRUE). ",
                " . $record->get_kz_sepa_faehig(TRUE). ",
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
    
    public static function update($current, $id) {
        $con = App::$CURRENT->DB->manualOpen();
        $query = "UPDATE `bankleitzahl` SET
                bankleitzahl = " . $current->blz. ",
                bic = '" . $current->bic. "',
                bank = '" . $current->bank. "',
                kz_sepa_faehig = '" . $current->kz_sepa_faehig. "',
                geaendert_von = '" . App::$CURRENT->USER->get_name() . "',
                geaendert_am = '" . date("Y-m-d H:i:s") . "'
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
        $query = "DELETE FROM `bankleitzahl` 
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

?>