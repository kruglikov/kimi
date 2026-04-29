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
            if (strlen($val) == 0) {
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

    public function get_negbuchungsbetrag($sql_valid = FALSE) {
        if (!isset($this->item["buchungsbetrag"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        if ($this->item["buchungsbetrag"]==null) {
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) ($this->item["buchungsbetrag"]*-1), 4, ".", "");
        }

        return number_format((float) ($this->item["buchungsbetrag"]*-1), 4, ",", ".");
    }

    public function set_buchungsbetrag($val) {
        $val = str_replace(",", ".", $val);
        $this->item["buchungsbetrag"] = $val;
    }

    public function get_buchungskennzeichen($sql_valid = FALSE) {
        if (!isset($this->item["buchungskennzeichen"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
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
        if (strlen($val) == 0) {
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
        if (strlen($val) == 0) {
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

    public function get_valutierung($sql_valid = FALSE) {
        if (!isset($this->item["valutierung"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["valutierung"]) . "'";
        }
        return $this->item["valutierung"];
    }

    public function set_valutierung($val) {
        $this->item["valutierung"] = $val;
    }

    public function get_zahlungsfrist($sql_valid = FALSE) {
        if (!isset($this->item["zahlungsfrist"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["zahlungsfrist"]) . "'";
        }

        $date = date_create($this->item["zahlungsfrist"]);
        return date_format($date, "d.m.Y");
    }

    public function set_zahlungsfrist($val) {
        if (strlen($val) == 0) {
            $this->item["zahlungsfrist"] = NULL;
            return;
        }

        $date = date_create($val);
        $this->item["zahlungsfrist"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_prozent_zinsen($sql_valid = FALSE) {
        if (!isset($this->item["prozent_zinsen"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return number_format((float) $this->item["prozent_zinsen"], 4, ".", "");
        }

        return number_format((float) $this->item["prozent_zinsen"], 4, ",", ".");
    }

    public function set_prozent_zinsen($val) {
        $val = str_replace(",", ".", $val);
        $this->item["prozent_zinsen"] = $val;
    }

    public function get_tageszinshoehe($sql_valid = FALSE) {
        if (!isset($this->item["tageszinshoehe"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return number_format((float) $this->item["tageszinshoehe"], 4, ".", "");
        }

        return number_format((float) $this->item["tageszinshoehe"], 4, ",", ".");
    }

    public function set_tageszinshoehe($val) {
        $val = str_replace(",", ".", $val);
        $this->item["tageszinshoehe"] = $val;
    }

    public function get_datum_l_tz_erm($sql_valid = FALSE) {
        if (!isset($this->item["datum_l_tz_erm"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["datum_l_tz_erm"]) . "'";
        }

        $date = date_create($this->item["datum_l_tz_erm"]);
        return date_format($date, "d.m.Y");
    }

    public function set_datum_l_tz_erm($val) {
        if (strlen($val) == 0) {
            $this->item["datum_l_tz_erm"] = NULL;
            return;
        }

        $date = date_create($val);
        $this->item["datum_l_tz_erm"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_l_st_kap_zins($sql_valid = FALSE) {
        if (!isset($this->item["l_st_kap_zins"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return number_format((float) $this->item["l_st_kap_zins"], 4, ".", "");
        }

        return number_format((float) $this->item["l_st_kap_zins"], 4, ",", ".");
    }

    public function set_l_st_kap_zins($val) {
        $val = str_replace(",", ".", $val);
        $this->item["l_st_kap_zins"] = $val;
    }

    public function get_vl_st_kap_zins($sql_valid = FALSE) {
        if (!isset($this->item["vl_st_kap_zins"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return number_format((float) $this->item["vl_st_kap_zins"], 4, ".", "");
        }

        return number_format((float) $this->item["vl_st_kap_zins"], 4, ",", ".");
    }

    public function set_vl_st_kap_zins($val) {
        $val = str_replace(",", ".", $val);
        $this->item["vl_st_kap_zins"] = $val;
    }

    public function get_kz_ratenplanaend($sql_valid = FALSE) {
        if (!isset($this->item["kz_ratenplanaend"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        return $this->item["kz_ratenplanaend"];
    }

    public function set_kz_ratenplanaend($val) {
        $this->item["kz_ratenplanaend"] = $val;
    }

    public function get_datum_debsaldo($sql_valid = FALSE) {
        if (!isset($this->item["datum_debsaldo"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["datum_debsaldo"]) . "'";
        }

        $date = date_create($this->item["datum_debsaldo"]);
        return date_format($date, "d.m.Y");
    }

    public function set_datum_debsaldo($val) {
        if (strlen($val) == 0) {
            $this->item["datum_debsaldo"] = NULL;
            return;
        }

        $date = date_create($val);
        $this->item["datum_debsaldo"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_verguetung($sql_valid = FALSE) {
        if (!isset($this->item["verguetung"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["verguetung"], 2, ".", "");
        }

        return number_format((float) $this->item["verguetung"], 2, ",", ".");
    }

    public function set_verguetung($val) {
        $val = str_replace(",", ".", $val);
        $this->item["verguetung"] = $val;
    }

    public function get_faelligkeit($sql_valid = FALSE) {
        if (!isset($this->item["faelligkeit"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        return $this->item["faelligkeit"];
    }

    public function set_faelligkeit($val) {
        $this->item["faelligkeit"] = $val;
    }

    public function get_markt() {
        return $this->item["markt"];
    }

    public function get_bugru_key($sql_valid = FALSE) {
        return $this->item["bg_bugru_key"];
    }

    public function get_bugru_key_om($sql_valid = FALSE) {
        return $this->item["bg_bugru_key_om"];
    }

    public function set_bugru_key_om($val) {
        $this->item["bg_bugru_key_om"] = $val;
    }

    public function get_kz_berechnung($sql_valid = FALSE) {
        return $this->item["bg_kz_berechnung"];
    }

    public function get_kz_saldowirksam($sql_valid = FALSE) {
        return $this->item["bg_kz_saldowirksam"];
    }

    public function get_bugru_text($sql_valid = FALSE) {
        return $this->item["bg_text"];
    }

    public function set_bugru_text($val) {
        $this->item["bg_text"] = $val;
    }

    public function get_buart_key($sql_valid = FALSE) {
        return $this->item["ba_buart_key"];
    }

    public function get_buart_text($sql_valid = FALSE) {
        return $this->item["ba_text"];
    }

    public function set_buart_text($val) {
        $this->item["ba_text"] = $val;
    }

    public function get_zinsen_aufgel($sql_valid = FALSE) {
        if (!isset($this->item["zinsen_aufgel"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["zinsen_aufgel"], 4, ".", "");
        }

        return number_format((float) $this->item["zinsen_aufgel"], 4, ",", ".");
    }

    public function get_saldo_neu($sql_valid = FALSE) {
        if (!isset($this->item["saldo_neu"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["saldo_neu"], 2, ".", "");
        }

        return number_format((float) $this->item["saldo_neu"], 2, ",", ".");
    }

    public function get_tgz_anzeige($sql_valid = FALSE) {
        return $this->item["tgz_anzeige"];
    }

    public function set_tgz_anzeige($val) {
        $this->item["tgz_anzeige"] = $val;
    }

    public function get_tgz_tage($sql_valid = FALSE) {
        return $this->item["tgz_tage"];
    }

    public function set_tgz_tage($val) {
        $this->item["tgz_tage"] = $val;
    }

    public function set_saldo_neu($val) {
        $val = str_replace(",", ".", $val);
        $this->item["saldo_neu"] = $val;
    }

    public function set_zinsen_aufgel($val) {
        $val = str_replace(",", ".", $val);
        $this->item["zinsen_aufgel"] = $val;
    }

    public static function calculate_subkonten($stammdaten_id) {

        $query = "SELECT z.text as 'zahlart', SUM(s.m4) as 'm4',
                SUM(s.m3) as 'm3', SUM(s.m2) as 'm2', SUM(s.m1) as 'm1', SUM(s.m0) as 'm0', SUM(s.rest) as 'rest', SUM(s.v1) as 'v1',
                SUM(s.v2) as 'v2', SUM(s.v3) as 'v3', SUM(s.v4) as 'v4', SUM(s.saldo) as 'saldo' 
                FROM `subkonto_neu` s
                JOIN zahlart z ON z.id = s.zahlart_id
                WHERE s.stammdaten_id = $stammdaten_id AND s.kz_aktuell = 'J'
                GROUP BY s.zahlart_id
                ORDER BY 1";
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

    public static function get_by_kdnr($kdnr, $order = " ORDER BY s.eroeffnet_am, s.sk_lfdnr, s.buchungsdatum, s.id") {

        $query = "SELECT s.*, z.text as 'zahlart', k.markt as 'markt' 
                FROM subkonto_neu s
                LEFT JOIN zahlart z on z.id = s.zahlart_id
                LEFT JOIN stammdaten sd ON sd.id = s.stammdaten_id
                LEFT JOIN kunde k ON k.id = sd.kunde_id
                WHERE k.kdnr = '$kdnr' AND s.kz_aktuell = 'J'" . $order;
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

    public static function load_items($start, $count, $filter, $silent, $order = "s.sk_lfdnr, s.buchungsdatum DESC, s.id DESC") {

        $query = "SELECT s.*, z.text as 'zahlart', k.markt as 'markt',
                bg.bugru_key as 'bg_bugru_key', right( cast(bg.bugru_key as char), 4) as 'bg_bugru_key_om', bg.kz_berechnung as 'bg_kz_berechnung', bg.text as 'bg_text', 
                ba.buart_key as 'ba_buart_key', ba.text as 'ba_text'
                FROM subkonto_neu s
                LEFT JOIN zahlart z on z.id = s.zahlart_id
                LEFT JOIN stammdaten sd ON sd.id = s.stammdaten_id
                LEFT JOIN kunde k ON k.id = sd.kunde_id
                LEFT JOIN bua_bgr_man bbm ON bbm.id = s.bua_bgr_man_id
                LEFT JOIN buchungsgrund bg on bg.id = bbm.bugru_id
                LEFT JOIN buchungsart ba on ba.id = bg.buchungsart_id
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
            if (count($subkonten) == 0 && !$silent) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $subkonten;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get_all_for_subkonto($subkonto_id, $start, $count) {

        $query = "SELECT sn.*, k.kdnr as 'kdnr', k.markt as 'markt', z.text as 'zahlart', bg.text as 'buchungstext', bg.id as 'bugru_id',
                bg.bugru_key as 'bg_bugru_key', right( cast(bg.bugru_key as char), 4) as 'bg_bugru_key_om', bg.kz_berechnung as 'bg_kz_berechnung', bg.text as 'bg_text', 
                ba.buart_key as 'ba_buart_key', ba.text as 'ba_text'
            FROM subkonto_neu s
            LEFT JOIN subkonto_neu sn ON sn.sk_lfdnr = s.sk_lfdnr
            LEFT JOIN zahlart z on z.id = sn.zahlart_id
            LEFT JOIN stammdaten sd ON sd.id = sn.stammdaten_id
            LEFT JOIN kunde k ON k.id = sd.kunde_id
            LEFT JOIN bua_bgr_man bgr ON bgr.id = sn.bua_bgr_man_id
            LEFT JOIN buchungsgrund bg ON bg.id = bgr.bugru_id
            LEFT JOIN buchungsart ba on ba.id = bg.buchungsart_id
            WHERE s.id = $subkonto_id ORDER BY sn.sk_lfdnr, sn.buchungsdatum DESC, sn.id DESC
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

        $query = "SELECT s.*, k.kdnr as 'kdnr', k.markt as 'markt', z.text as 'zahlart', bg.text as 'buchungstext', bg.id as 'bugru_id',
            bg.bugru_key as 'bg_bugru_key', right( cast(bg.bugru_key as char), 4) as 'bg_bugru_key_om', bg.kz_berechnung as 'bg_kz_berechnung', bg.text as 'bg_text', 
            ba.buart_key as 'ba_buart_key', ba.text as 'ba_text'
            FROM subkonto_neu s
            LEFT JOIN zahlart z on z.id = s.zahlart_id
            LEFT JOIN stammdaten sd ON sd.id = s.stammdaten_id
            LEFT JOIN kunde k ON k.id = sd.kunde_id
            LEFT JOIN bua_bgr_man bgr ON bgr.id = s.bua_bgr_man_id
            LEFT JOIN buchungsgrund bg ON bg.id = bgr.bugru_id
            LEFT JOIN buchungsart ba on ba.id = bg.buchungsart_id
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

        $query = "SELECT sn.*, k.kdnr as 'kdnr', k.markt as 'markt', z.text as 'zahlart', bg.text as 'buchungstext',
            bg.bugru_key as 'bg_bugru_key', right( cast(bg.bugru_key as char), 4) as 'bg_bugru_key_om', bg.kz_berechnung as 'bg_kz_berechnung', bg.text as 'bg_text', 
            ba.buart_key as 'ba_buart_key', ba.text as 'ba_text'
            FROM subkonto_neu s
            
            LEFT JOIN subkonto_neu sn ON sn.sk_lfdnr = s.sk_lfdnr
            LEFT JOIN zahlart z on z.id = sn.zahlart_id
            LEFT JOIN stammdaten sd ON sd.id = sn.stammdaten_id
            LEFT JOIN kunde k ON k.id = sd.kunde_id
            LEFT JOIN bua_bgr_man bgr ON bgr.id = sn.bua_bgr_man_id
            LEFT JOIN buchungsgrund bg ON bg.id = bgr.bugru_id
            LEFT JOIN buchungsart ba on ba.id = bg.buchungsart_id
            WHERE s.id = $subkonto_id AND sn.kz_aktuell = 'J'";
        try {
            return new Subkonto(App::$CURRENT->DB->singleObjectQuery($query));
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
            `bua_bgr_man_id`, 
            `buchungsdatum`, 
            `buchungsbetrag`, 
            `m4`, `m3`, `m2`, `m1`, `m0`, 
            `rest`, `v1`, `v2`, `v3`, `v4`, 
            `saldo`, `geaendert_am`, 
            `kz_aktuell`, `status_id`, 
            `geaendert_von`,
            `belegdatum`,
            `buchungskennzeichen`,
            `valutierung`,
            `zahlungsfrist`,
            `prozent_zinsen`,
            `tageszinshoehe`,
            `datum_l_tz_erm`,
            `l_st_kap_zins`,
            `vl_st_kap_zins`,
            `kz_ratenplanaend`,
            `datum_debsaldo`,
            `verguetung`,
            `faelligkeit`
            ) 

            VALUES (" . $subkonto->get_sk_lfdnr() . ",
                " . $subkonto->get_stammdaten_id() . ",
                " . $subkonto->get_rechnungsnummer(TRUE) . ",
                " . $subkonto->get_zahlart_id() . ",
                " . $subkonto->get_zinssatz(TRUE) . ",
                " . $subkonto->get_eroeffnet_am(TRUE) . ",
                " . $subkonto->get_kaufwert(TRUE) . ",
                " . $subkonto->get_ratenhoehe(TRUE) . ",
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
                '" . App::$CURRENT->USER->get_name() . "',
                " . $subkonto->get_belegdatum(TRUE) . ",
                " . $subkonto->get_buchungskennzeichen(TRUE) . ",
                " . $subkonto->get_valutierung(TRUE) . ",
                " . $subkonto->get_zahlungsfrist(TRUE) . ",
                " . $subkonto->get_prozent_zinsen(TRUE) . ",
                " . $subkonto->get_tageszinshoehe(TRUE) . ",
                " . $subkonto->get_datum_l_tz_erm(TRUE) . ",
                " . $subkonto->get_l_st_kap_zins(TRUE) . ",
                " . $subkonto->get_vl_st_kap_zins(TRUE) . ",
                " . $subkonto->get_kz_ratenplanaend(TRUE) . ",
                " . $subkonto->get_datum_debsaldo(TRUE) . ",
                " . $subkonto->get_verguetung(TRUE) . ",
                " . $subkonto->get_faelligkeit(TRUE) . ")";
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
                belegdatum = " . $subkonto->get_belegdatum(TRUE) . ",
                buchungskennzeichen = " . $subkonto->get_buchungskennzeichen(TRUE) . ",
                valutierung = " . $subkonto->get_valutierung(TRUE) . ",
                zahlungsfrist = " . $subkonto->get_zahlungsfrist(TRUE) . ",
                prozent_zinsen = " . $subkonto->get_prozent_zinsen(TRUE) . ",
                tageszinshoehe = " . $subkonto->get_tageszinshoehe(TRUE) . ",
                datum_l_tz_erm = " . $subkonto->get_datum_l_tz_erm(TRUE) . ",
                l_st_kap_zins = " . $subkonto->get_l_st_kap_zins(TRUE) . ",
                vl_st_kap_zins = " . $subkonto->get_vl_st_kap_zins(TRUE) . ",
                kz_ratenplanaend = " . $subkonto->get_kz_ratenplanaend(TRUE) . ",
                datum_debsaldo = " . $subkonto->get_datum_debsaldo(TRUE) . ",
                verguetung = " . $subkonto->get_verguetung(TRUE) . ",
                faelligkeit = " . $subkonto->get_faelligkeit(TRUE) . ",
               
            WHERE id = " . $subkonto->get_id();
        try {
            App::$CURRENT->DB->query($query, FALSE);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function select_for_tgz($kdnr, $mandant_id, $markt, $bugru_keys, $datum_bis, $order = "s.sk_lfdnr, ifnull(s.kz_aktuell, 'X') ASC, s.belegdatum desc, s.buchungsdatum DESC, s.id DESC") {

        $bugrumarkt = $markt . $bugru_keys;
        $bugrumarkt = str_replace(",", $markt . ",", $bugrumarkt);

        $query = "SELECT s.*, z.text as 'zahlart', k.markt as 'markt',
                bg.bugru_key as 'bg_bugru_key', right( cast(bg.bugru_key as char), 4) as 'bg_bugru_key_om', bg.kz_berechnung as 'bg_kz_berechnung', bg.text as 'bg_text', bg.kz_saldowirksam as 'bg_kz_saldowirksam', 
                ba.buart_key as 'ba_buart_key', ba.text as 'ba_text', 0 as 'zinsen_aufgel', 0 as 'saldo_neu', 1 as 'tgz_anzeige', 0 as 'tgz_tage'
                FROM subkonto_neu s
                JOIN zahlart z on z.id = s.zahlart_id
                JOIN stammdaten sd ON sd.id = s.stammdaten_id
                JOIN kunde k ON k.id = sd.kunde_id
                JOIN bua_bgr_man bbm ON bbm.id = s.bua_bgr_man_id
                JOIN buchungsgrund bg on bg.id = bbm.bugru_id
                JOIN buchungsart ba on ba.id = bg.buchungsart_id
                WHERE k.kdnr = '$kdnr' 
                AND s.zahlart_id = 2 and s.rechnungsnummer = 'Z09108291'
                AND belegdatum >= (select max(belegdatum) 
                                        FROM subkonto_neu sn 
                                        JOIN bua_bgr_man bbm2 ON bbm2.id = sn.bua_bgr_man_id
                                        JOIN buchungsgrund bg2 on bg2.id = bbm2.bugru_id
                                        WHERE sn.stammdaten_id = s.stammdaten_id 
                                        AND sn.sk_lfdnr = s.sk_lfdnr 
                                        AND bg2.bugru_key IN ($bugrumarkt) )
                AND sd.mandant_id = $mandant_id ";
        $query .= " ORDER BY $order ";
        echo $query;
        exit;
        try {
            $items = App::$CURRENT->DB->query($query);
            $subkonten = array();
            $subkonten_return = array();
            $finished = FALSE;
            $last_sk_lfdnr = 0;
            $saldo_neu = 0;
            $akt_tageszinssatz = CONF_TGZ_ZINSSATZ;
            $datum_done = FALSE;
            $datum_end = NULL;


            foreach ($items as $value) {
                $sk = new Subkonto($value);
                if ($last_sk_lfdnr != $sk->get_sk_lfdnr()) {
                    $finished = FALSE;
                    $datum_done = FALSE;
                    $akt_tageszinssatz = CONF_TGZ_ZINSSATZ;
                }

                if (!$datum_done && $sk->get_belegdatum() != $datum_bis) {
                    $datum_done = TRUE;
                    $sk_new = new Subkonto($value);
                    $sk_new->set_belegdatum($datum_bis);
                    $sk_new->set_buchungstext(TXT_LBL_TGZ_AUFGEL_ZINSEN);
                    $sk_new->set_bugru_key_om(null);
                    $sk_new->set_buart_text(TXT_LBL_TGZ_AUFGEL_ZINSEN_BIS . " " . $datum_bis);
                    $sk_new->set_bugru_text(null);
                    $sk_new->set_buchungsbetrag(null);
                    $sk_new->set_saldo_neu($sk_new->get_saldo());
                    $subkonten[$sk->get_sk_lfdnr()] = array();
                    array_push($subkonten[$sk_new->get_sk_lfdnr()], $sk_new);
                }


                $last_sk_lfdnr = $sk->get_sk_lfdnr();

                if (!$finished) {
                    if ($sk->get_saldo() == NULL || $sk->get_saldo(TRUE) == 0) {
                        $saldo_neu = $saldo_neu - Buchung::calc_saldo($sk_save->get_buchungsbetrag(TRUE), $sk_save->get_kz_berechnung(), $sk_save->get_kz_saldowirksam(), $sk_save->get_buchungskennzeichen());
                        $sk->set_saldo_neu($saldo_neu);
                        $sk->set_saldo($saldo_neu);
                    } else {
                        $saldo_neu = $sk->get_saldo(TRUE);
                        $sk->set_saldo_neu($saldo_neu);
                    }
                    $sk->set_buchungsbetrag(Buchung::calc_saldo($sk->get_buchungsbetrag(TRUE), $sk->get_kz_berechnung(), $sk->get_kz_saldowirksam(), $sk->get_buchungskennzeichen()) * -1);
                    if ($sk->get_zinssatz() == NULL || $sk->get_zinssatz(TRUE) == 0) {
                        $sk->set_zinssatz($akt_tageszinssatz);
                    } else {
                        $akt_tageszinssatz = $sk->get_zinssatz(TRUE);
                    }

                    if (!isset($subkonten[$sk->get_sk_lfdnr()])) {
                        $subkonten[$sk->get_sk_lfdnr()] = array();
                    }
                    array_push($subkonten[$sk->get_sk_lfdnr()], $sk);
                }
                if ($sk->get_bugru_key_om() == $bugru_keys) {
                    $datum_end = $sk->get_belegdatum();
                }
                if ($datum_end != NULL && $datum_end != $sk->get_belegdatum()) {
                    $finished = TRUE;
                }
                $sk_save = $sk;
            }

            $subkonten_return["sk_lfdnr"] = array();
            $tz_sum = 0;
            $datum_start_done = FALSE;
            $anz_tgz = 0;
            foreach ($subkonten as $key => $sks) {
                $datum_old = $sks[count($sks) - 1]->get_belegdatum();
                
                $datum_sich = $datum_old;
                $saldo_sich = 0;
                $zinssatz_sich = 0;
                $tz_sum = 0;
                $tgz_anz_tage = 0;
                $datum_start_done = FALSE;
                for ($i = count($sks) - 1; $i >= 0; $i--) {
                    $datum_new = $sks[$i]->get_belegdatum();
                    //echo $datum_sich . $datum_new."<br>";
                    if ($datum_sich != $datum_new) {
                        $tz = self::calc_zinsen($sks[$i]->get_saldo_neu(TRUE), $sks[$i]->get_zinssatz(TRUE), $datum_old, $datum_new, $tgz_anz_tage, ($datum_start_done==FALSE));
                        $tz_sum += $tz;
                        $sks[$i]->set_tgz_tage(self::get_tage($datum_old, $datum_new, $tgz_anz_tage, ($datum_start_done==FALSE)));
                        $tgz_anz_tage += $sks[$i]->get_tgz_tage();
                        $sks[$i]->set_zinsen_aufgel($tz);
                        $datum_old = $datum_new;
                        $datum_start_done = TRUE;
                    } else {
                        $sks[$i]->set_zinsen_aufgel(0);
                    }
                    $datum_sich = $datum_new;
                }
                $subkonten_return["sk_lfdnr"][$key] = $tz_sum;
                $subkonten[$key] = array_reverse($subkonten[$key]);
            }

            $subkonten_return["subkonten"] = $subkonten;

            return $subkonten_return;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function calc_zinsen($saldo, $zinssatz, $dat_start, $dat_ende, $anz_total_tage, $ignore_first_day) {

        $tage = self::get_tage($dat_start, $dat_ende, $anz_total_tage, $ignore_first_day );
        return $saldo * $zinssatz / 100 / CONF_TGZ_ZINSSATZ * $tage;
    }

    public static function get_tage($dat_start, $dat_ende, $anz_total_tage, $ignore_first_day) {

        $result = floor((strtotime($dat_ende) - strtotime($dat_start)) / 86400);
        if ($ignore_first_day){
            $result -= 1;
            if (date_format(date_create($dat_start), 'd')==31) {
                $result -= 1;
            } 
            if (date_format(date_create($dat_start), 'dm') == 2902 ) {
                $result -= 1;
            }
        } 
        if ($anz_total_tage+$result > CONF_TGZ_MAX_DAYS) {
            $result = CONF_TGZ_ZINSSATZ - $anz_total_tage;
        }
        return $result;
    }

}

?>
