<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of stammdaten
 *
 * @author David
 */
class Stammdaten {

    private $item;

    public function get_id() {
        return $this->item["id"];
    }

    public function set_id($id, $sql_valid = FALSE) {
        $this->item["id"] = $id;
    }

    public function get_ktonr($sql_valid = FALSE) {
        if (!isset($this->item["ktonr"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["ktonr"]) . "'";
        }
        return $this->item["ktonr"];
    }

    public function set_ktonr($ktonr, $sql_valid = FALSE) {
        $this->item["ktonr"] = $ktonr;
    }

    public function get_mandant_id() {
        return $this->item["mandant_id"];
    }

    public function set_mandant_id($mandant_id, $sql_valid = FALSE) {
        $this->item["mandant_id"] = $mandant_id;
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

    public function set_kunde_id($kunde_id, $sql_valid = FALSE) {
        $this->item["kunde_id"] = $kunde_id;
    }

    public function get_datum_anlage($sql_valid = FALSE) {
        if (!isset($this->item["datum_anlage"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["datum_anlage"]) . "'";
        }

        $date = date_create($this->item["datum_anlage"]);
        return date_format($date, "d.m.Y");
    }

    public function set_datum_anlage($datum_anlage, $sql_valid = FALSE) {
        if (strlen((string) $datum_anlage) == 0) {
            $this->item["datum_anlage"] = NULL;
            return;
        }

        $date = date_create($datum_anlage);
        $this->item["datum_anlage"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_stichtag($sql_valid = FALSE) {
        if (!isset($this->item["stichtag"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["stichtag"]) . "'";
        }

        $date = date_create($this->item["stichtag"]);
        return date_format($date, "d.m.Y");
    }

    public function set_stichtag($stichtag, $sql_valid = FALSE) {
        if (strlen((string) $stichtag) == 0) {
            $this->item["stichtag"] = NULL;
            return;
        }

        $date = date_create($stichtag);
        $this->item["stichtag"] = date_format($date, "Y-m-d");
    }

    public function get_zahltag($sql_valid = FALSE) {
        if (!isset($this->item["zahltag"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["zahltag"]) . "'";
        }

        $date = date_create($this->item["zahltag"]);
        return date_format($date, "d.m.Y");
    }

    public function set_zahltag($zahltag, $sql_valid = FALSE) {
        if (strlen((string) $zahltag) == 0) {
            $this->item["zahltag"] = NULL;
            return;
        }

        $date = date_create($zahltag);
        $this->item["zahltag"] = date_format($date, "Y-m-d");
    }

    public function get_mahnsperre($sql_valid = FALSE) {
        if (!isset($this->item["mahnsperre"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string(strtoupper($this->item["mahnsperre"])) . "'";
        }
        return strtoupper($this->item["mahnsperre"]);
    }

    public function set_mahnsperre($mahnsperre, $sql_valid = FALSE) {
        $this->item["mahnsperre"] = $mahnsperre;
    }

    public function get_mahnsperre_datum($sql_valid = FALSE) {
        if (!isset($this->item["mahnsperre_datum"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["mahnsperre_datum"]) . "'";
        }

        $date = date_create($this->item["mahnsperre_datum"]);
        return date_format($date, "d.m.Y");
    }

    public function set_mahnsperre_datum($mahnsperre_datum, $sql_valid = FALSE) {
        if (strlen((string) $mahnsperre_datum) == 0) {
            $this->item["mahnsperre_datum"] = NULL;
            return;
        }

        $date = date_create($mahnsperre_datum);
        $this->item["mahnsperre_datum"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_kunde_kdnr($sql_valid = FALSE) {
        if (!isset($this->item["kdnr"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kdnr"]) . "'";
        }
        return $this->item["kdnr"];
    }

    public function set_kunde_kdnr($kdnr, $sql_valid = FALSE) {
        return $this->item["kdnr"] = $kdnr;
    }

    public function get_kunde_nachname($sql_valid = FALSE) {
        if (!isset($this->item["nachname"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["nachname"]) . "'";
        }
        return $this->item["nachname"];
    }

    public function set_kunde_nachname($nachname, $sql_valid = FALSE) {
        $this->item["nachname"] = $nachname;
    }

    public function get_kunde_vorname($sql_valid = FALSE) {
        if (!isset($this->item["vorname"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["vorname"]) . "'";
        }
        return $this->item["vorname"];
    }

    public function set_kunde_vorname($vorname, $sql_valid = FALSE) {
        $this->item["vorname"] = $vorname;
    }

    public function get_kunde_plz($sql_valid = FALSE) {
        if (!isset($this->item["plz"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["plz"]) . "'";
        }
        return $this->item["plz"];
    }

    public function set_kunde_plz($plz, $sql_valid = FALSE) {
        $this->item["plz"] = $plz;
    }

    public function get_kunde_ort($sql_valid = FALSE) {
        if (!isset($this->item["ort"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["ort"]) . "'";
        }
        return $this->item["ort"];
    }

    public function set_kunde_ort($ort, $sql_valid = FALSE) {
        $this->item["ort"] = $ort;
    }

    public function get_kunde_strasse($sql_valid = FALSE) {
        if (!isset($this->item["strasse"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["strasse"]) . "'";
        }
        return $this->item["strasse"];
    }

    public function set_kunde_strasse($strasse, $sql_valid = FALSE) {
        $this->item["strasse"] = $strasse;
    }

    public function get_kto_kenner($sql_valid = FALSE) {
        if (!isset($this->item["kto_kenner"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string(strtoupper($this->item["kto_kenner"])) . "'";
        }
        return strtoupper($this->item["kto_kenner"]);
    }

    public function set_kto_kenner($kto_kenner, $sql_valid = FALSE) {
        $this->item["kto_kenner"] = $kto_kenner;
    }

    public function get_offene_raten($sql_valid = FALSE) {
        if (!isset($this->item["offene_raten"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string(strtoupper($this->item["offene_raten"])) . "'";
        }
        return strtoupper($this->item["offene_raten"]);
    }

    public function set_offene_raten($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["offene_raten"] = $val;
    }

    public function get_ratenanzahl($sql_valid = FALSE) {
        if (!isset($this->item["ratenanzahl"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string(strtoupper($this->item["ratenanzahl"])) . "'";
        }
        return strtoupper($this->item["ratenanzahl"]);
    }

    public function set_ratenanzahl($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);

        $this->item["ratenanzahl"] = $val;
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

    public function get_krsv($sql_valid = FALSE) {
        if (!isset($this->item["krsv"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string(strtoupper($this->item["krsv"])) . "'";
        }
        return strtoupper($this->item["krsv"]);
    }

    public function set_krsv($krsv, $sql_valid = FALSE) {
        $this->item["krsv"] = $krsv;
    }

    public function get_lastschrift($sql_valid = FALSE) {
        if (!isset($this->item["lastschrift"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string(strtoupper($this->item["lastschrift"])) . "'";
        }
        return strtoupper($this->item["lastschrift"]);
    }

    public function set_lastschrift($lastschrift, $sql_valid = FALSE) {
        $this->item["lastschrift"] = $lastschrift;
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
        $this->item["max_einzbetag"] = $val;
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

    public function set_dat_einzbetrag($val, $sql_valid = FALSE) {
        if (strlen((string) $val) == 0) {
            $this->item["dat_einzbetrag"] = NULL;
            return;
        }

        $date = date_create($val);
        $this->item["dat_einzbetrag"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_dat_l_zahlung($sql_valid = FALSE) {
        if (!isset($this->item["dat_l_zahlung"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_l_zahlung"]) . "'";
        }

        $date = date_create($this->item["dat_l_zahlung"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_l_zahlung($dat_l_zahlung, $sql_valid = FALSE) {
        if (strlen((string) $dat_l_zahlung) == 0) {
            $this->item["dat_l_zahlung"] = NULL;
            return;
        }

        $date = date_create($dat_l_zahlung);
        $this->item["dat_l_zahlung"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_betrag_l_zahlung($sql_valid = FALSE) {
        if (!isset($this->item["betrag_l_zahlung"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["betrag_l_zahlung"], 2, ".", "");
        }
        return number_format((float) $this->item["betrag_l_zahlung"], 2, ",", ".");
    }

    public function set_betrag_l_zahlung($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["betrag_l_zahlung"] = $val;
    }

    public function get_dat_l_auslagerung($sql_valid = FALSE) {
        if (!isset($this->item["dat_l_auslagerung"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_l_auslagerung"]) . "'";
        }

        $date = date_create($this->item["dat_l_auslagerung"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_l_auslagerung($dat_l_auslagerung, $sql_valid = FALSE) {
        if (strlen((string) $dat_l_auslagerung) == 0) {
            $this->item["dat_l_auslagerung"] = NULL;
            return;
        }

        $date = date_create($dat_l_auslagerung);
        $this->item["dat_l_auslagerung"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_betrag_l_auslagerung($sql_valid = FALSE) {
        if (!isset($this->item["betrag_l_auslagerung"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["betrag_l_auslagerung"], 2, ".", "");
        }
        return number_format((float) $this->item["betrag_l_auslagerung"], 2, ",", ".");
    }

    public function set_betrag_l_auslagerung($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["betrag_l_auslagerung"] = $val;
    }

    public function get_dat_l_kontoauszug($sql_valid = FALSE) {
        if (!isset($this->item["dat_l_kontoauszug"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_l_kontoauszug"]) . "'";
        }

        $date = date_create($this->item["dat_l_kontoauszug"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_l_kontoauszug($dat_l_kontoauszug, $sql_valid = FALSE) {
        if (strlen((string) $dat_l_kontoauszug) == 0) {
            $this->item["dat_l_kontoauszug"] = NULL;
            return;
        }

        $date = date_create($dat_l_kontoauszug);
        $this->item["dat_l_kontoauszug"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_betrag_l_kontoauszug($sql_valid = FALSE) {
        if (!isset($this->item["betrag_l_kontoauszug"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["betrag_l_kontoauszug"], 2, ".", "");
        }
        return number_format((float) $this->item["betrag_l_kontoauszug"], 2, ",", ".");
    }

    public function set_betrag_l_kontoauszug($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["betrag_l_kontoauszug"] = $val;
    }

    public function get_dat_ltzt_buchung($sql_valid = FALSE) {
        if (!isset($this->item["dat_ltzt_buchung"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_ltzt_buchung"]) . "'";
        }

        $date = date_create($this->item["dat_ltzt_buchung"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_ltzt_buchung($dat_ltzt_buchung, $sql_valid = FALSE) {
        if (strlen((string) $dat_ltzt_buchung) == 0) {
            $this->item["dat_ltzt_buchung"] = NULL;
            return;
        }

        $date = date_create($dat_ltzt_buchung);
        $this->item["dat_ltzt_buchung"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_geaendert_am($sql_valid = FALSE) {
        if (!isset($this->item["geaendert_am"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["geaendert_am"]) . "'";
        }

        $date = date_create($this->item["geaendert_am"]);
        return date_format($date, "d.m.Y");
    }

    public function set_geaendert_am($geaendert_am, $sql_valid = FALSE) {
        if (strlen((string) $geaendert_am) == 0) {
            $this->item["geaendert_am"] = NULL;
            return;
        }

        $date = date_create($geaendert_am);
        $this->item["geaendert_am"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_dat_l_mahnlauf($sql_valid = FALSE) {
        if (!isset($this->item["dat_l_mahnlauf"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_l_mahnlauf"]) . "'";
        }

        $date = date_create($this->item["dat_l_mahnlauf"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_l_mahnlauf($dat_l_mahnlauf, $sql_valid = FALSE) {
        if (strlen((string) $dat_l_mahnlauf) == 0) {
            $this->item["dat_l_mahnlauf"] = NULL;
            return;
        }

        $date = date_create($dat_l_mahnlauf);
        $this->item["dat_l_mahnlauf"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_mahnstufe($sql_valid = FALSE) {
        if (!isset($this->item["mahnstufe"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string(strtoupper($this->item["mahnstufe"])) . "'";
        }
        return strtoupper($this->item["mahnstufe"]);
    }

    public function set_mahnstufe($mahnstufe, $sql_valid = FALSE) {
        $this->item["mahnstufe"] = $mahnstufe;
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
        if ($val == -1) {
            $val = NULL;
        }
        $this->item["inkassostatus_id"] = $val;
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
        if ($val == -1) {
            $val = NULL;
        }
        $this->item["ra_ikbuero_id"] = $val;
    }

    public function get_gesamtsaldo($sql_valid = FALSE) {
        if (!isset($this->item["gesamtsaldo"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["gesamtsaldo"], 2, ".", "");
        }

        return number_format((float) $this->item["gesamtsaldo"], 2, ",", ".");
    }

    public function set_gesamtsaldo($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["gesamtsaldo"] = $val;
    }

    public function get_gesamtsaldo_1x($sql_valid = FALSE) {
        if (!isset($this->item["gesamtsaldo_1x"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["gesamtsaldo_1x"], 2, ".", "");
        }

        return number_format((float) $this->item["gesamtsaldo_1x"], 2, ",", ".");
    }

    public function set_gesamtsaldo_1x($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["gesamtsaldo_1x"] = $val;
    }

    public function get_gesamtsaldo_rcs($sql_valid = FALSE) {
        if (!isset($this->item["gesamtsaldo_rvc"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return number_format((float) $this->item["gesamtsaldo_rvc"], 2, ".", "");
        }

        return number_format((float) $this->item["gesamtsaldo_rvc"], 2, ",", ".");
    }

    public function set_gesamtsaldo_rvc($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["gesamtsaldo_rcs"] = $val;
    }

    public function get_letzter_stichtag($sql_valid = FALSE) {
        if (!isset($this->item["letzter_stichtag"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["letzter_stichtag"]) . "'";
        }

        $date = date_create($this->item["letzter_stichtag"]);
        return date_format($date, "d.m.Y");
    }

    public function set_letzter_stichtag($val, $sql_valid = FALSE) {
        if (strlen((string) $val) == 0) {
            $this->item["letzter_stichtag"] = NULL;
            return;
        }

        $date = date_create($val);
        $this->item["letzter_stichtag"] = date_format($date, "Y-m-d");
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

    public function set_status_dat($val, $sql_valid = FALSE) {
        if (strlen((string) $val) == 0) {
            $this->item["status_dat"] = NULL;
            return;
        }

        $date = date_create($val);
        $this->item["status_dat"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_letzter_zahltag($sql_valid = FALSE) {
        if (!isset($this->item["letzter_zahltag"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["letzter_zahltag"]) . "'";
        }

        $date = date_create($this->item["letzter_zahltag"]);
        return date_format($date, "d.m.Y");
    }

    public function set_letzter_zahltag($val, $sql_valid = FALSE) {
        if (strlen((string) $val) == 0) {
            $this->item["letzter_zahltag"] = NULL;
            return;
        }

        $date = date_create($val);
        $this->item["letzter_zahltag"] = date_format($date, "Y-m-d");
    }

    public function get_dat_ende_sonderzins($sql_valid = FALSE) {
        if (!isset($this->item["dat_ende_sonderzins"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["dat_ende_sonderzins"]) . "'";
        }

        $date = date_create($this->item["dat_ende_sonderzins"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dat_ende_sonderzins($val, $sql_valid = FALSE) {
        if (strlen((string) $val) == 0) {
            $this->item["dat_ende_sonderzins"] = NULL;
            return;
        }

        $date = date_create($val);
        $this->item["dat_ende_sonderzins"] = date_format($date, "Y-m-d");
    }

    public function __construct($item) {
        $this->item = (array) $item;
        $this->add_informations($item, TRUE);
    }

    public function add_informations($informations, $sql_valid = FALSE) {
        foreach ($informations as $key => $value) {
            $name = "set_" . $key;
            $name_kunde = "set_kunde_" . $key;

            if (method_exists($this, $name)) {
                $this->$name($value, $sql_valid);
            } else if (method_exists($this, $name_kunde)) {
                $this->$name_kunde($value, $sql_valid);
            }
        }
    }

    public static function insert($stammdaten, $db = null) {
        try {
            $commit = FALSE;
            if ($db == null) {
                $db = App::$CURRENT->DB->manualOpen();
                $commit = TRUE;
            }

            $query = "INSERT INTO `stammdaten`
            (`ktonr`, 
            `mandant_id`, 
            `kunde_id`, 
            `datum_anlage`, 
            `stichtag`, 
            `zahltag`, 
            `mahnsperre`, 
            `mahnsperre_datum`,
            `kto_kenner`,
            `dat_ende_sonderzins`,
            `geaendert_am`, 
            `geaendert_von`) 
            VALUES (" . $stammdaten->get_ktonr(TRUE) . ",
            " . $stammdaten->get_mandant_id() . ",
            " . $stammdaten->get_kunde_id() . ",
            '" . date("Y-m-d H:i:s") . "',
            " . $stammdaten->get_stichtag(TRUE) . ",
            " . $stammdaten->get_zahltag(TRUE) . ",
            " . $stammdaten->get_mahnsperre(TRUE) . ",
            " . $stammdaten->get_mahnsperre_datum(TRUE) . ",
            " . $stammdaten->get_kto_kenner(TRUE) . ",
            " . $stammdaten->dat_ende_sonderzins(TRUE) . ",
            '" . date("Y-m-d H:i:s") . "',
            '" . App::$CURRENT->USER->get_name() . "')";

            $id = App::$CURRENT->DB->manualQueryReturningId($query, $db);

            //$db->set_query($query);
            //$db->execute();
            //$id = $db->get_generated_id();
            if ($commit) {
                App::$CURRENT->DB->commit($db);
                //$db->commit();
                //App::$CURRENT->add_information(MSG_SAVED);
                //$db->close();
            }

            return $id;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());

            if (isset($db) && $commit) {
                App::$CURRENT->DB->rollback($db);
                //$db->rollback();
                //$db->close();
            }
            return 0;
        }
    }

    public static function update($stammdaten) {
        try {
            $db = new DBConnection();
            $query = "UPDATE `stammdaten` 
            SET `ktonr`=" . $stammdaten->get_ktonr(TRUE) . ",
            `mandant_id`=" . $stammdaten->get_mandant_id() . ",
            `kunde_id`=" . $stammdaten->get_kunde_id() . ",
            `stichtag`=" . $stammdaten->get_stichtag(TRUE) . ",
            `zahltag`=" . $stammdaten->get_zahltag(TRUE) . ",
            `mahnsperre`=" . $stammdaten->get_mahnsperre(TRUE) . ",
            `mahnsperre_datum`=" . $stammdaten->get_mahnsperre_datum(TRUE) . ",
            `inkassostatus_id`=" . $stammdaten->get_inkassostatus_id(TRUE) . ",            
            `mahnstufe`=" . $stammdaten->get_mahnstufe(TRUE) . ",
            `kto_kenner`=" . $stammdaten->get_kto_kenner(TRUE) . ",
            `ra_ikbuero_id`=" . $stammdaten->get_ra_ikbuero_id(TRUE) . ",
            `status_dat`=" . $stammdaten->get_status_dat(TRUE) . ",
            `dat_ende_sonderzins`=" . $stammdaten->get_dat_ende_sonderzins(TRUE) . ",
            `geaendert_am`='" . date("Y-m-d H:i:s") . "',
            `geaendert_von`='" . App::$CURRENT->USER->get_name() . "'
             WHERE id = " . $stammdaten->get_id();

            $db->set_query($query);
            $db->execute();
            $db->commit();
            $db->close();

            App::$CURRENT->add_information(MSG_SAVED);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            if (isset($db)) {
                $db->rollback();
                $db->close();
            }
        }
    }

    public static function update_from_buchung($db, $stammdaten) {
        try {
            $query = "UPDATE `stammdaten` 
            SET `gesamtsaldo`=" . $stammdaten->get_gesamtsaldo(TRUE) . ",
            `dat_ltzt_buchung`=" . $stammdaten->get_dat_ltzt_buchung(TRUE) . ",
            `geaendert_am`='" . date("Y-m-d H:i:s") . "' 
             WHERE id = " . $stammdaten->get_id();

            App::$CURRENT->DB->manualQuery($query, $db, FALSE);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            return FALSE;
        }
        return TRUE;
    }

    public static function update_from_inkassoinformation($db, $stammdaten) {
        try {
            $query = "UPDATE `stammdaten` 
            SET `inkassostatus_id`=" . $stammdaten->get_inkassostatus_id(TRUE) . ",
            `ra_ikbuero_id`=" . $stammdaten->get_ra_ikbuero_id(TRUE) . ",
            `status_dat`=" . $stammdaten->get_status_dat(TRUE) . ",
            `geaendert_am`='" . date("Y-m-d H:i:s") . "' 
             WHERE id = " . $stammdaten->get_id();

            App::$CURRENT->DB->manualQuery($query, $db, FALSE);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            return FALSE;
        }
        return TRUE;
    }

    public static function get_by_kunde($kunde_id) {

        $query = "SELECT * FROM stammdaten WHERE kunde_id = $kunde_id";

        try {
            $result = App::$CURRENT->DB->singleObjectQuery($query);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            return NULL;
        }
        if (!isset($result))
            return NULL;
        return new Stammdaten($result);
    }

    public static function get_by_kdnr($kdnr) {
        $query = "SELECT s.* FROM stammdaten s
                    JOIN kunde k ON k.id = s.kunde_id
                    WHERE k.kdnr = '$kdnr'";
        $result = App::$CURRENT->DB->singleObjectQuery($query);
        if (!isset($result))
            return NULL;
        return new Stammdaten($result);
    }

    public static function get($id) {
        $query = "SELECT * FROM stammdaten WHERE id = $id";
        $result = App::$CURRENT->DB->singleObjectQuery($query);
        return new Stammdaten($result);
    }

    public static function search($mandant_id, $start, $count, $filter) {
        $query = "SELECT s.*, k.kdnr, k.nachname, k.vorname, k.plz, k.ort, k.strasse FROM stammdaten s
                    JOIN kunde k ON k.ID = s.kunde_id
                    WHERE s.mandant_id = $mandant_id";
        foreach ($filter as $item) {
            $query .= " AND $item";
        }
        $query .= " LIMIT $start, $count";
        try {
            $results = App::$CURRENT->DB->query($query);
            $response = array();
            foreach ($results as $item) {
                array_push($response, new Stammdaten($item));
            }
            return $response;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function count_results($mandant_id, $start, $count, $filter) {
        $query = "SELECT COUNT(s.id) as 'count' FROM stammdaten s
                    JOIN kunde k ON k.ID = s.kunde_id
                    WHERE s.mandant_id = $mandant_id";
        foreach ($filter as $item) {
            $query .= " AND $item";
        }
        $query .= " LIMIT $start, $count";
        try {
            return App::$CURRENT->DB->singleObjectQuery($query)->count;
//            return App::$CURRENT->DB->query($query, FALSE);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function count($mandant_id, $filter) {
        $query = "SELECT COUNT(s.id) AS 'count' FROM stammdaten s "
                . " JOIN kunde k ON k.ID = s.kunde_id "
                . "WHERE s.mandant_id = $mandant_id";

        foreach ($filter as $item) {
            $query .= " AND $item";
        }
        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

}
