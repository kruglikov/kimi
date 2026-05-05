<?php

/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */

/**

 * Description of subkonto

 *

 * @author David

 */
class Subkonto {

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

    public function get_sk_lfdnr() {
        return $this->item["sk_lfdnr"];
    }

    public function set_sk_lfdnr($val) {
        $this->item["sk_lfdnr"] = $val;
    }

    public function get_stammdaten_id() {

        return $this->item["stammdaten_id"];
    }

    public function set_stammdaten_id($val) {
        $this->item["stammdaten_id"] = $val;
    }

    public function get_rechnungsnummer($sql_valid = FALSE) {
        if (!isset($this->item["rechnungsnummer"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["rechnungsnummer"]) . "'";
        }
        return $this->item["rechnungsnummer"];
    }

    public function set_rechnungsnummer($val) {
        $this->item["rechnungsnummer"] = $val;
    }

    public function get_eroeffnet_am($sql_valid = FALSE) {
        if (!isset($this->item["eroeffnet_am"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["eroeffnet_am"]) . "'";
        }

        $date = date_create($this->item["eroeffnet_am"]);
        return date_format($date, "d.m.Y");
    }

    public function set_eroeffnet_am($val) { {
            if (strlen((string) $val) == 0) {
                $this->item["eroeffnet_am"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["eroeffnet_am"] = date_format($date, "Y-m-d H:i:s");
        }
    }

    public function get_kaufwert($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["kaufwert"], 2, ".", "");
        }

        return number_format((float) $this->item["kaufwert"], 2, ",", ".");
    }

    public function set_kaufwert($val) {
        $val = str_replace(",", ".", $val);

        $this->item["kaufwert"] = $val;
    }

    public function get_ratenhoehe($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["ratenhoehe"], 2, ".", "");
        }

        return number_format((float) $this->item["ratenhoehe"], 2, ",", ".");
    }

    public function set_ratenhoehe($val) {
        $val = str_replace(",", ".", $val);
        $this->item["ratenhoehe"] = $val;
    }

    public function get_buchung_lfdnr() {

        return $this->item["buchung_lfdnr"];
    }

    public function set_buchung_lfdnr($val) {
        $this->item["buchung_lfdnr"] = $val;
    }

    public function get_bua_bgr_man_id() {

        return $this->item["bua_bgr_man_id"];
    }

    public function set_bua_bgr_man_id($val) {
        $this->item["bua_bgr_man_id"] = $val;
    }

    public function get_buchungstext($sql_valid = FALSE) {
        if (!isset($this->item["buchungstext"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["buchungstext"]) . "'";
        }
        return $this->item["buchungstext"];
    }

    public function set_buchungstext($val) {
        $this->item["buchungstext"] = $val;
    }

    public function get_buchungsbetrag($sql_valid = FALSE) {
        if (!isset($this->item["buchungsbetrag"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        
        if ($sql_valid) {
            return number_format((float) $this->item["buchungsbetrag"], 4, ".", "");
        }

        return number_format((float) $this->item["buchungsbetrag"], 4, ",", ".");
    }

       
    public function set_buchungsbetrag($val) {
        $val = str_replace(",", ".", $val);
        $this->item["buchungsbetrag"] = $val;
    }

   public function get_buchungskennzeichen($sql_valid = FALSE) {
        if (!isset($this->item["buchungskennzeichen"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["buchungskennzeichen"]) . "'";
        }
        return $this->item["buchungskennzeichen"];
    }

    public function set_buchungskennzeichen($val) {
        $this->item["buchungskennzeichen"] = $val;
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

    public function set_buchungsdatum($val) {
        if (strlen((string) $val) == 0) {
            $this->item["buchungsdatum"] = NULL;
            return;
        }

        $date = date_create($val);
        $this->item["buchungsdatum"] = date_format($date, "Y-m-d H:i:s");
    }


    public function get_belegdatum($sql_valid = FALSE) {
        if (!isset($this->item["belegdatum"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["belegdatum"]) . "'";
        }

        $date = date_create($this->item["belegdatum"]);
        return date_format($date, "d.m.Y");
    }

    public function set_belegdatum($val) {
        if (strlen((string) $val) == 0) {
            $this->item["belegdatum"] = NULL;
            return;
        }

        $date = date_create($val);
        $this->item["belegdatum"] = date_format($date, "Y-m-d H:i:s");
    }
    
    
    public function get_kz_aktuell($sql_valid = FALSE) {
        if (!isset($this->item["kz_aktuell"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kz_aktuell"]) . "'";
        }
        return $this->item["kz_aktuell"];
    }

    public function set_kz_aktuell($val) {
        $this->item["kz_aktuell"] = $val;
    }


   public function get_kz_gebucht($sql_valid = FALSE) {
        if (!isset($this->item["kz_gebucht"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kz_gebucht"]) . "'";
        }
        return $this->item["kz_gebucht"];
    }

    public function set_kz_gebucht($val) {
        $this->item["kz_gebucht"] = $val;
    }    
    
    public function get_status() {

        return $this->item["status"];
    }

    public function set_status($val) {
        $this->item["status"] = $val;
    }

    public function get_zinssatz($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["zinssatz"], 2, ".", "");
        }

        return number_format((float) $this->item["zinssatz"], 2, ",", ".");
    }

    public function set_zinssatz($val) {
        $val = str_replace(",", ".", $val);
        $this->item["zinssatz"] = $val;
    }

    public function get_zahlart_id() {

        return $this->item["zahlart_id"];
    }

    public function set_zahlart_id($val) {
        $this->item["zahlart_id"] = $val;
    }

    public function get_zahlart() {

        return $this->item["zahlart"];
    }

    private function set_zahlart($val) {
        $this->item["zahlart"] = $val;
    }

    public function get_bugru_id($sql_valid = FALSE) {
        if ($sql_valid && $this->item["bugru_id"] < 0) {
            return "NULL";
        }
        return $this->item["bugru_id"];
    }

    public function set_bugru_id($val) {
        if ($val < 0) {
            $val = NULL;
        }

        $this->item["bugru_id"] = $val;
    }

    public function get_kdnr($sql_valid = FALSE) {
        if (!isset($this->item["kdnr"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kdnr"]) . "'";
        }
        return $this->item["kdnr"];
    }

    public function set_kdnr($val) {
        $this->item["kdnr"] = $val;
    }

    public function get_m4($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["m4"], 2, ".", "");
        }

        return number_format((float) $this->item["m4"], 2, ",", ".");
    }

    public function set_m4($val) {
        $val = str_replace(",", ".", $val);
        $this->item["m4"] = $val;
    }

    public function get_m3($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["m3"], 2, ".", "");
        }

        return number_format((float) $this->item["m3"], 2, ",", ".");
    }

    public function set_m3($val) {
        $val = str_replace(",", ".", $val);
        $this->item["m3"] = $val;
    }

    public function get_m2($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["m2"], 2, ".", "");
        }

        return number_format((float) $this->item["m2"], 2, ",", ".");
    }

    public function set_m2($val) {
        $val = str_replace(",", ".", $val);
        $this->item["m2"] = $val;
    }

    public function get_m1($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["m1"], 2, ".", "");
        }

        return number_format((float) $this->item["m1"], 2, ",", ".");
    }

    public function set_m1($val) {
        $val = str_replace(",", ".", $val);
        $this->item["m1"] = $val;
    }

    public function get_m0($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["m0"], 2, ".", "");
        }

        return number_format((float) $this->item["m0"], 2, ",", ".");
    }

    public function set_m0($val) {
        $val = str_replace(",", ".", $val);
        $this->item["m0"] = $val;
    }

    public function get_rest($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["rest"], 2, ".", "");
        }

        return number_format((float) $this->item["rest"], 2, ",", ".");
    }

    public function set_rest($val) {
        $val = str_replace(",", ".", $val);
        $this->item["rest"] = $val;
    }

    public function get_v1($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["v1"], 2, ".", "");
        }

        return number_format((float) $this->item["v1"], 2, ",", ".");
    }

    public function set_v1($val) {
        $val = str_replace(",", ".", $val);
        $this->item["v1"] = $val;
    }

    public function get_v2($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["v2"], 2, ".", "");
        }

        return number_format((float) $this->item["v2"], 2, ",", ".");
    }

    public function set_v2($val) {
        $val = str_replace(",", ".", $val);
        $this->item["v2"] = $val;
    }

    public function get_v3($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["v3"], 2, ".", "");
        }

        return number_format((float) $this->item["v3"], 2, ",", ".");
    }

    public function set_v3($val) {
        $val = str_replace(",", ".", $val);
        $this->item["v3"] = $val;
    }

    public function get_v4($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["v4"], 2, ".", "");
        }

        return number_format((float) $this->item["v4"], 2, ",", ".");
    }

    public function set_v4($val) {
        $val = str_replace(",", ".", $val);
        $this->item["v4"] = $val;
    }

    public function get_saldo($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["saldo"], 2, ".", "");
        }

        return number_format((float) $this->item["saldo"], 2, ",", ".");
    }

    public function set_saldo($val) {
        $val = str_replace(",", ".", $val);
        $this->item["saldo"] = $val;
    }

    public static function calculate_subkonten($stammdaten_id) {

        $query = "SELECT 1 as 'order_key', z.text as 'zahlart', SUM(s.m4) as 'm4',
                SUM(s.m3) as 'm3', SUM(s.m2) as 'm2', SUM(s.m1) as 'm1', SUM(s.m0) as 'm0', SUM(s.rest) as 'rest', SUM(s.v1) as 'v1',
                SUM(s.v2) as 'v2', SUM(s.v3) as 'v3', SUM(s.v4) as 'v4', SUM(s.saldo) as 'saldo' FROM `subkonto_neu` s
                JOIN zahlart z ON z.id = s.zahlart_id
                WHERE s.stammdaten_id = $stammdaten_id AND s.kz_aktuell = 'J'
                GROUP BY s.zahlart_id
                ORDER BY 1, 2";
        try {
            $result = App::$CURRENT->DB->query($query);
            $response = array();
            foreach ($result as $item) {
                array_push($response, new Subkonto($item));
            }
            return $response;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get_by_kdnr2($kdnr) {

        $query = "SELECT s.id, s.sk_lfdnr, s.stammdaten_id, s.rechnungsnummer, s.zahlart_id, s.zinssatz, s.eroeffnet_am, s.kaufwert, s.ratenhoehe, s.buchung_lfdnr, s.bua_bgr_man_id, s.buchungsdatum, s.buchungsbetrag, s.m4, s.m3, s.m2, s.m1, s.m0, s.rest, s.v1, s.v2, s.v3, s.v4, s.saldo, s.kz_aktuell, s.status_id,
                z.text as 'zahlart' 
                FROM subkonto_neu s
                LEFT JOIN zahlart z on z.id = s.zahlart_id
                LEFT JOIN stammdaten sd ON sd.id = s.stammdaten_id
                LEFT JOIN kunde k ON k.id = sd.kunde_id
                WHERE k.kdnr = '$kdnr' AND s.kz_aktuell = 'J' ORDER BY s.eroeffnet_am , s.sk_lfdnr ";
        
        try {
            $result = App::$CURRENT->DB->query($query);
            $response = array();
            foreach ($result as $item) {
                array_push($response, new Subkonto($item));
            }
            return $response;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function count($filter) {

        $query = "SELECT COUNT(s.id) as 'count' FROM subkonto_neu s
                LEFT JOIN zahlart z on z.id = s.zahlart_id
                LEFT JOIN stammdaten sd ON sd.id = s.stammdaten_id
                LEFT JOIN kunde k ON k.id = sd.kunde_id
                WHERE s.kz_aktuell = 'J'";

        foreach ($filter as $item) {
            $query .= " AND $item";
        }
        $query .= " LIMIT  1000 ";
        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public static function load_items($start, $count, $filter, $order = "s.sk_lfdnr, s.buchungsdatum DESC, s.buchung_lfdnr DESC") {

        $query = "SELECT s.*, z.text as 'zahlart' FROM subkonto_neu s
                LEFT JOIN zahlart z on z.id = s.zahlart_id
                LEFT JOIN stammdaten sd ON sd.id = s.stammdaten_id
                LEFT JOIN kunde k ON k.id = sd.kunde_id
                WHERE s.kz_aktuell = 'J' AND sd.mandant_id = " . App::$CURRENT->MANDANT->get_id();
        foreach ($filter as $item) {
            $query .= " AND $item";
        }
        $query .= " ORDER BY $order LIMIT $start, $count";
        try {
            $items = App::$CURRENT->DB->query($query);
            $subkonten = array();
            foreach ($items as $value) {
                array_push($subkonten, new Subkonto($value));
            }
            if (count($subkonten) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $subkonten;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get_all_for_subkonto($subkonto_id, $start, $count) {

        $query = "SELECT sn.*, k.kdnr as 'kdnr', z.text as 'zahlart', bg.text as 'buchungstext', bg.id as 'bugru_id'
            FROM subkonto_neu s
            LEFT JOIN subkonto_neu sn ON sn.sk_lfdnr = s.sk_lfdnr
            LEFT JOIN zahlart z on z.id = sn.zahlart_id
            LEFT JOIN stammdaten sd ON sd.id = sn.stammdaten_id
            LEFT JOIN kunde k ON k.id = sd.kunde_id
            LEFT JOIN bua_bgr_man bgr ON bgr.id = sn.bua_bgr_man_id
            LEFT JOIN buchungsgrund bg ON bg.id = bgr.bugru_id
            WHERE s.id = $subkonto_id ORDER BY sn.sk_lfdnr, sn.buchungsdatum DESC, sn.buchung_lfdnr DESC
                LIMIT $start, $count";
        try {
            $result = App::$CURRENT->DB->query($query);
            $subkonten = array();
            foreach ($result as $item) {
                array_push($subkonten, new Subkonto($item));
            }
            if (count($subkonten) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $subkonten;
        } catch (Exception $e) {

            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get($id) {
        $query = "SELECT s.*, k.kdnr as 'kdnr', z.text as 'zahlart', bg.text as 'buchungstext', bg.id as 'bugru_id'
            FROM subkonto_neu s
            LEFT JOIN zahlart z on z.id = s.zahlart_id
            LEFT JOIN stammdaten sd ON sd.id = s.stammdaten_id
            LEFT JOIN kunde k ON k.id = sd.kunde_id
            LEFT JOIN bua_bgr_man bgr ON bgr.id = s.bua_bgr_man_id
            LEFT JOIN buchungsgrund bg ON bg.id = bgr.bugru_id
            WHERE s.id = $id";
        try {
            return new Subkonto(App::$CURRENT->DB->singleObjectQuery($query));
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function count_all_for_subkonto($subkonto_id) {

        $query = "SELECT COUNT(s.id) as 'count'
            FROM subkonto_neu s
            LEFT JOIN subkonto_neu sn ON sn.sk_lfdnr = s.sk_lfdnr
            LEFT JOIN zahlart z on z.id = sn.zahlart_id
            LEFT JOIN stammdaten sd ON sd.id = sn.stammdaten_id
            LEFT JOIN kunde k ON k.id = sd.kunde_id
            LEFT JOIN bua_bgr_man bgr ON bgr.id = sn.bua_bgr_man_id
            LEFT JOIN buchungsgrund bg ON bg.id = bgr.bugru_id
            WHERE s.id = $subkonto_id ORDER BY sn.buchungsdatum DESC";
        try {
            return App::$CURRENT->DB->singleObjectQuery($query)->count;
        } catch (Exception $e) {

            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get_gessaldo($mandant_id, $kdnr) {

        $query = "SELECT sum(s.saldo) as 'gessaldo'
                FROM subkonto_neu s
                JOIN stammdaten sd ON sd.id = s.stammdaten_id
                JOIN kunde k ON k.id = sd.kunde_id 
                WHERE k.mandant_id = $mandant_id AND k.kdnr = '$kdnr' AND s.kz_aktuell = 'J'";

        try {
            return App::$CURRENT->DB->singleObjectQuery($query)->gessaldo;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

	
    public static function get_current($subkonto_id) {

        $query = "SELECT sn.*, k.kdnr as 'kdnr', z.text as 'zahlart', bg.text as 'buchungstext'
            FROM subkonto_neu s
            LEFT JOIN subkonto_neu sn ON sn.sk_lfdnr = s.sk_lfdnr
            LEFT JOIN zahlart z on z.id = sn.zahlart_id
            LEFT JOIN stammdaten sd ON sd.id = sn.stammdaten_id
            LEFT JOIN kunde k ON k.id = sd.kunde_id
            LEFT JOIN bua_bgr_man bgr ON bgr.id = sn.bua_bgr_man_id
            LEFT JOIN buchungsgrund bg ON bg.id = bgr.bugru_id
            WHERE s.id = $subkonto_id AND sn.kz_aktuell = 'J'";
        try {
            return new Subkonto(App::$CURRENT->DB->singleObjectQuery($query));
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function generate_buchung_lfdnr($subkonto_id) {

        $query = "SELECT MAX(sn.buchung_lfdnr) as 'buchung_lfdnr'
            FROM subkonto_neu s
            LEFT JOIN subkonto_neu sn ON sn.sk_lfdnr = s.sk_lfdnr
            WHERE s.id = $subkonto_id";
        try {

            return App::$CURRENT->DB->singleObjectQuery($query)->buchung_lfdnr + 1;
        } catch (Exception $e) {

            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function generate_sk_lfdnr() {

        $query = "SELECT MAX(sk_lfdnr) as 'sk_lfdnr' FROM subkonto_neu";

        try {

            return App::$CURRENT->DB->singleObjectQuery($query)->sk_lfdnr + 1;
        } catch (Exception $e) {

            App::$CURRENT->add_error($e->getMessage());
        }
    }

    private static function delete_current($sk_lfdnr, $manual_connection) {

        $query = "UPDATE subkonto_neu SET kz_aktuell = NULL WHERE sk_lfdnr = $sk_lfdnr";



        try {

            App::$CURRENT->DB->manualQuery($query, $manual_connection, FALSE);
        } catch (Exception $e) {

            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function insert($subkonto) {
        $con = App::$CURRENT->DB->manualOpen();

        if ($subkonto->get_kz_aktuell() == "J") {
            self::delete_current($subkonto->get_sk_lfdnr(), $con);
        }

        $query = "INSERT INTO `subkonto_neu`( 
            `sk_lfdnr`, 
            `stammdaten_id`, 
            `rechnungsnummer`, 
            `zahlart_id`, 
            `zinssatz`, 
            `eroeffnet_am`, 
            `kaufwert`, 
            `ratenhoehe`, 
            `buchung_lfdnr`, 
            `bua_bgr_man_id`, 
            `buchungsdatum`, 
            `buchungsbetrag`, 
            `m4`, `m3`, `m2`, `m1`, `m0`, 
            `rest`, `v1`, `v2`, `v3`, `v4`, 
            `saldo`, `geaendert_am`, 
            `kz_aktuell`, `status_id`, 
            `geaendert_von`) 

            VALUES (" . $subkonto->get_sk_lfdnr() . ",
                " . $subkonto->get_stammdaten_id() . ",
                " . $subkonto->get_rechnungsnummer(TRUE) . ",
                " . $subkonto->get_zahlart_id() . ",
                " . $subkonto->get_zinssatz(TRUE) . ",
                " . $subkonto->get_eroeffnet_am(TRUE) . ",
                " . $subkonto->get_kaufwert(TRUE) . ",
                " . $subkonto->get_ratenhoehe(TRUE) . ",
                " . $subkonto->get_buchung_lfdnr() . ",
                " . $subkonto->get_bua_bgr_man_id() . ",
                " . $subkonto->get_buchungsdatum(TRUE) . ",
                " . $subkonto->get_buchungsbetrag(TRUE) . ",
                " . $subkonto->get_m4(TRUE) . ",
                " . $subkonto->get_m3(TRUE) . ",
                " . $subkonto->get_m2(TRUE) . ",
                " . $subkonto->get_m1(TRUE) . ",
                " . $subkonto->get_m0(TRUE) . ",
                " . $subkonto->get_rest(TRUE) . ",
                " . $subkonto->get_v1(TRUE) . ",
                " . $subkonto->get_v2(TRUE) . ",
                " . $subkonto->get_v3(TRUE) . ",
                " . $subkonto->get_v4(TRUE) . ",
                " . $subkonto->get_saldo(TRUE) . ",
                    '" . date("Y-m-d H:i:s") . "',
                " . $subkonto->get_kz_aktuell(TRUE) . ",
                    1,
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

    public static function update($subkonto) {

        $query = "UPDATE `subkonto_neu` SET
                zinssatz = " . $subkonto->get_zinssatz(TRUE) . ",
                ratenhoehe = " . $subkonto->get_ratenhoehe(TRUE) . ",
                bua_bgr_man_id = " . $subkonto->get_bua_bgr_man_id() . ",
                buchungsdatum = " . $subkonto->get_buchungsdatum(TRUE) . ",
                buchungsbetrag = " . $subkonto->get_buchungsbetrag(TRUE) . ",
                m4 = " . $subkonto->get_m4(TRUE) . ",
                m3 = " . $subkonto->get_m3(TRUE) . ",
                m2 = " . $subkonto->get_m2(TRUE) . ",
                m1 = " . $subkonto->get_m1(TRUE) . ",
                m0 = " . $subkonto->get_m0(TRUE) . ",
                rest = " . $subkonto->get_rest(TRUE) . ",
                v1 = " . $subkonto->get_v1(TRUE) . ",
                v2 = " . $subkonto->get_v2(TRUE) . ",
                v3 = " . $subkonto->get_v3(TRUE) . ",
                v4 = " . $subkonto->get_v4(TRUE) . ",
                saldo = " . $subkonto->get_saldo(TRUE) . ",
                geaendert_von = '" . App::$CURRENT->USER->get_name() . "',
                geaendert_am = '" . date("Y-m-d H:i:s") . "'
            WHERE id = " . $subkonto->get_id();

        try {

            App::$CURRENT->DB->query($query, FALSE);
        } catch (Exception $e) {

            App::$CURRENT->add_error($e->getMessage());
        }
    }

}
?>

