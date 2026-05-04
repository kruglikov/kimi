<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ticket
 *
 * @author David
 */
class Ticket {

    private $item;

    public function get_benutzer_id($sql_valid = FALSE) {
        if (!isset($this->item["benutzer_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["benutzer_id"];
    }

    public function set_benutzer_id($val) {
        $this->item["benutzer_id"] = $val;
    }

    public function get_raw_item() {
        return $this->item;
    }

    public function get_anruf_status_id($sql_valid = FALSE) {
        if (!isset($this->item["anruf_status_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["anruf_status_id"];
    }

    public function set_anruf_status_id($val) {
        if ($val == -1) {
            $val = NULL;
        }
        $this->item["anruf_status_id"] = $val;
    }

    public function get_ergebnis($sql_valid = FALSE) {
        if (!isset($this->item["ergebnis"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["ergebnis"]) . "'";
        }
        return $this->item["ergebnis"];
    }

    public function set_ergebnis($val) {
        $this->item["ergebnis"] = $val;
    }

    public function get_status_id($sql_valid = FALSE) {
        if (!isset($this->item["status_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["status_id"];
    }

    public function set_status_id($val) {
        if ($val == -1) {
            $this->item["status_id"] = NULL;
        } else {
            $this->item["status_id"] = $val;
        }
    }

    public function get_prioritaet_id($sql_valid = FALSE) {
        if (!isset($this->item["prioritaet_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["prioritaet_id"];
    }

    public function set_prioritaet_id($val) {
        if ($val == -1) {
            $this->item["prioritaet_id"] = NULL;
        } else {
            $this->item["prioritaet_id"] = $val;
        }
    }

    public function get_aufwand($sql_valid = FALSE) {
        if (!isset($this->item["aufwand"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["aufwand"];
    }

    public function set_aufwand($val) {
        if (strlen($val) == 0) {
            unset($this->item["aufwand"]);
        } else {
            $this->item["aufwand"] = $val;
        }
    }

    public function get_beschreibung_detail($sql_valid = FALSE) {
        if (!isset($this->item["beschreibung_detail"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["beschreibung_detail"]) . "'";
        }
        return $this->item["beschreibung_detail"];
    }

    public function set_beschreibung_detail($val) {
        $this->item["beschreibung_detail"] = $val;
    }

    public function get_ticketnr() {
        if (!(isset($this->item["ticketnr"]))) {
            return NULL;
        }

        return $this->item["ticketnr"];
    }

    public function set_ticketnr($item) {
        $this->item["ticketnr"] = $item;
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

    public function set_kunde_id($val) {
        $this->item["kunde_id"] = $val;
    }

    public function get_land_id($sql_valid = FALSE) {
        if (!isset($this->item["land_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["land_id"];
    }

    public function set_land_id($land_id) {
        if ($land_id == -1) {
            $land_id = NULL;
        }
        
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
            }
            return NULL;
        }

        return $this->item["mandant_id"];
    }

    public function set_mandant_id($mandant_id) {
        if (strlen($mandant_id) == 0) {
            unset($this->item["mandant_id"]);
        } else {
            $this->item["mandant_id"] = $mandant_id;
        }
    }

    public function get_kundennummer($sql_valid = FALSE) {
        if (!isset($this->item["kundennummer"])) {
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kundennummer"]) . "'";
        }
        return $this->item["kundennummer"];
    }

    public function set_kundennummer($kdnr) {
        $this->item["kundennummer"] = $kdnr;
    }

    public function get_nachname($sql_valid = FALSE) {
        if (!isset($this->item["nachname"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
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
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
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
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
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
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
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
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
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
            }
            return NULL;
        }
        return $this->item["hausnummer"];
    }

    public function set_hausnummer($hausnummer) {
        if (strlen($hausnummer) == 0) {
            unset($this->item["hausnummer"]);
        } else {
            $this->item["hausnummer"] = $hausnummer;
        }
    }

    public function get_hausnummer_erw($sql_valid = FALSE) {
        if (!isset($this->item["hausnummer_erw"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
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
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
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
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
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
        if (strlen($geburtsdatum) == 0 || strlen($geburtsdatum) == 0) {
            $this->item["geburtsdatum"] = NULL;
            return;
        }

        $date = date_create($geburtsdatum);

        $this->item["geburtsdatum"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_kenner($sql_valid = FALSE) {
        if (!isset($this->item["kenner"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
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
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if (!$sql_valid) {
            return $this->item["anrede"];
        }
        return "'" . App::$CURRENT->DB->escape_string($this->item["anrede"]) . "'";
    }

    private function set_anrede($anrede) {
        $this->item["anrede"] = $anrede;
    }

    public function get_titel($sql_valid = FALSE) {
        if (!isset($this->item["titel"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if (!$sql_valid) {
            return $this->item["titel"];
        }
        return "'" . App::$CURRENT->DB->escape_string($this->item["titel"]) . "'";
    }

    public function set_titel($titel) {
        $this->item["titel"] = $titel;
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

    public function get_wiedervorlage($sql_valid = FALSE) {
        if (!isset($this->item["wiedervorlage"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["wiedervorlage"]) . "'";
        }

        $date = date_create($this->item["wiedervorlage"]);
        return date_format($date, "d.m.Y");
    }

    public function set_wiedervorlage($geburtsdatum) {
        if (strlen($geburtsdatum) == 0 || strlen($geburtsdatum) == 0) {
            $this->item["wiedervorlage"] = NULL;
            return;
        }

        $date = date_create($geburtsdatum);

        $this->item["wiedervorlage"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_beginn($sql_valid = FALSE) {
        if (!isset($this->item["beginn"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["beginn"]) . "'";
        }

        $date = date_create($this->item["beginn"]);
        return date_format($date, "d.m.Y");
    }

    public function set_beginn($geburtsdatum) {
        if (strlen($geburtsdatum) == 0 || strlen($geburtsdatum) == 0) {
            $this->item["beginn"] = NULL;
            return;
        }

        $date = date_create($geburtsdatum);

        $this->item["beginn"] = date_format($date, "Y-m-d H:i:s");
    }

    public function get_ende($sql_valid = FALSE) {
        if (!isset($this->item["ende"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["ende"]) . "'";
        }

        $date = date_create($this->item["ende"]);
        return date_format($date, "d.m.Y");
    }

    public function set_ende($geburtsdatum) {
        if (strlen($geburtsdatum) == 0 || strlen($geburtsdatum) == 0) {
            $this->item["ende"] = NULL;
            return;
        }

        $date = date_create($geburtsdatum);

        if (!$date) {
            return NULL;
        }

        $this->item["ende"] = date_format($date, "Y-m-d H:i:s");
    }
	
    public function get_textinfo1($sql_valid = FALSE) {
        if (!isset($this->item["textinfo1"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textinfo1"]) . "'";
        }
        return $this->item["textinfo1"];
    }

    public function set_textinfo1($val) {
        $this->item["textinfo1"] = $val;
    }
		
    public function get_textant11_janein_id($sql_valid = FALSE) {
        if (!isset($this->item["textant11_janein_id"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textant11_janein_id"]) . "'";
        }
        return $this->item["textant11_janein_id"];
    }

    public function set_textant11_janein_id($val) {
        $this->item["textant11_janein_id"] = $val;
    }
		
    public function get_textant12_nummern_id($sql_valid = FALSE) {
        if (!isset($this->item["textant12_nummern_id"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textant12_nummern_id"]) . "'";
        }
        return $this->item["textant12_nummern_id"];
    }

    public function set_textant12_nummern_id($val) {
        $this->item["textant12_nummern_id"] = $val;
    }
		 	 				
   public function get_textinfo2($sql_valid = FALSE) {
        if (!isset($this->item["textinfo2"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textinfo2"]) . "'";
        }
        return $this->item["textinfo2"];
    }

    public function set_textinfo2($val) {
        $this->item["textinfo2"] = $val;
    }
		
    public function get_textant21_janein_id($sql_valid = FALSE) {
        if (!isset($this->item["textant21_janein_id"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textant21_janein_id"]) . "'";
        }
        return $this->item["textant21_janein_id"];
    }

    public function set_textant21_janein_id($val) {
        $this->item["textant21_janein_id"] = $val;
    }
		
    public function get_textant22_nummern_id($sql_valid = FALSE) {
        if (!isset($this->item["textant22_nummern_id"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textant22_nummern_id"]) . "'";
        }
        return $this->item["textant22_nummern_id"];
    }

    public function set_textant22_nummern_id($val) {
        $this->item["textant22_nummern_id"] = $val;
    }							

	
    public function get_textinfo5($sql_valid = FALSE) {
        if (!isset($this->item["textinfo5"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textinfo5"]) . "'";
        }
        return $this->item["textinfo5"];
    }

    public function set_textinfo5($val) {
        $this->item["textinfo5"] = $val;
    }
		
    public function get_textant51_janein_id($sql_valid = FALSE) {
        if (!isset($this->item["textant51_janein_id"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textant51_janein_id"]) . "'";
        }
        return $this->item["textant51_janein_id"];
    }

    public function set_textant51_janein_id($val) {
        $this->item["textant51_janein_id"] = $val;
    }
		
    public function get_textant52_nummern_id($sql_valid = FALSE) {
        if (!isset($this->item["textant52_nummern_id"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textant52_nummern_id"]) . "'";
        }
        return $this->item["textant52_nummern_id"];
    }

    public function set_textant52_nummern_id($val) {
        $this->item["textant52_nummern_id"] = $val;
    }
	
	
    public function get_telefon2($sql_valid = FALSE) {
        if (!isset($this->item["telefon2"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["telefon2"]) . "'";
        }
        return $this->item["telefon2"];
    }

    public function set_telefon2($telefon2) {
        $this->item["telefon2"] = $telefon2;
    }							
				
				
    public function get_standort($sql_valid = FALSE) {
        if (!isset($this->item["standort"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["standort"]) . "'";
        }
        return $this->item["standort"];
    }

    public function set_standort($val) {
        $this->item["standort"] = $val;
    }				

	
    public function get_verkaeufercode($sql_valid = FALSE) {
        if (!isset($this->item["verkaeufercode"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["verkaeufercode"]) . "'";
        }
        return $this->item["verkaeufercode"];
    }

    public function set_verkaeufercode($val) {
        $this->item["verkaeufercode"] = $val;
    }				

		
    public function get_verkaeufername($sql_valid = FALSE) {
        if (!isset($this->item["verkaeufername"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["verkaeufername"]) . "'";
        }
        return $this->item["verkaeufername"];
    }

    public function set_verkaeufername($val) {
        $this->item["verkaeufername"] = $val;
    }				
		

		
    public function get_ltzt_wkst_auftrag($sql_valid = FALSE) {
        if (!isset($this->item["ltzt_wkst_auftrag"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["ltzt_wkst_auftrag"]) . "'";
        }
        return $this->item["ltzt_wkst_auftrag"];
    }

    public function set_ltzt_wkst_auftrag($val) {
        $this->item["ltzt_wkst_auftrag"] = $val;
    }				
		
		
    public function get_erstzulassung($sql_valid = FALSE) {
        if (!isset($this->item["erstzulassung"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["erstzulassung"]) . "'";
        }
        return $this->item["erstzulassung"];
    }

    public function set_erstzulassung($val) {
        $this->item["erstzulassung"] = $val;
    }				
				

    public function get_kundenzulassung($sql_valid = FALSE) {
        if (!isset($this->item["kundenzulassung"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kundenzulassung"]) . "'";
        }
        return $this->item["kundenzulassung"];
    }

    public function set_kundenzulassung($val) {
        $this->item["kundenzulassung"] = $val;
    }				
		
    public function get_markencode($sql_valid = FALSE) {
        if (!isset($this->item["markencode"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["markencode"]) . "'";
        }
        return $this->item["markencode"];
    }

    public function set_markencode($val) {
        $this->item["markencode"] = $val;
    }				
			
				
						
		
    public function get_modell($sql_valid = FALSE) {
        if (!isset($this->item["modell"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["modell"]) . "'";
        }
        return $this->item["modell"];
    }

    public function set_modell($val) {
        $this->item["modell"] = $val;
    }				
			
				
		
    public function get_amtliches_kennzeichen($sql_valid = FALSE) {
        if (!isset($this->item["amtliches_kennzeichen"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["amtliches_kennzeichen"]) . "'";
        }
        return $this->item["amtliches_kennzeichen"];
    }

    public function set_amtliches_kennzeichen($val) {
        $this->item["amtliches_kennzeichen"] = $val;
    }				
				
						
    public function get_kilometer_stand($sql_valid = FALSE) {
        if (!isset($this->item["kilometer_stand"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kilometer_stand"]) . "'";
        }
        return $this->item["kilometer_stand"];
    }

    public function set_kilometer_stand($val) {
        $this->item["kilometer_stand"] = $val;
    }				
				
			
    public function get_fahrgestellnummer($sql_valid = FALSE) {
        if (!isset($this->item["fahrgestellnummer"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["fahrgestellnummer"]) . "'";
        }
        return $this->item["fahrgestellnummer"];
    }

    public function set_fahrgestellnummer($val) {
        $this->item["fahrgestellnummer"] = $val;
    }				
		
    public function get_textinfo3($sql_valid = FALSE) {
        if (!isset($this->item["textinfo3"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textinfo3"]) . "'";
        }
        return $this->item["textinfo3"];
    }

    public function set_textinfo3($val) {
        $this->item["textinfo3"] = $val;
    }
		
    public function get_textant31_janein_id($sql_valid = FALSE) {
        if (!isset($this->item["textant31_janein_id"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textant31_janein_id"]) . "'";
        }
        return $this->item["textant31_janein_id"];
    }

    public function set_textant31_janein_id($val) {
        $this->item["textant31_janein_id"] = $val;
    }
		
    public function get_textant32_nummern_id($sql_valid = FALSE) {
        if (!isset($this->item["textant32_nummern_id"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textant32_nummern_id"]) . "'";
        }
        return $this->item["textant32_nummern_id"];
    }

    public function set_textant32_nummern_id($val) {
        $this->item["textant32_nummern_id"] = $val;
    }									
	
    public function get_textinfo4($sql_valid = FALSE) {
        if (!isset($this->item["textinfo4"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textinfo4"]) . "'";
        }
        return $this->item["textinfo4"];
    }

    public function set_textinfo4($val) {
        $this->item["textinfo4"] = $val;
    }
		
    public function get_textant41_janein_id($sql_valid = FALSE) {
        if (!isset($this->item["textant41_janein_id"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textant41_janein_id"]) . "'";
        }
        return $this->item["textant41_janein_id"];
    }

    public function set_textant41_janein_id($val) {
        $this->item["textant41_janein_id"] = $val;
    }
		
    public function get_textant42_nummern_id($sql_valid = FALSE) {
        if (!isset($this->item["textant42_nummern_id"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["textant42_nummern_id"]) . "'";
        }
        return $this->item["textant42_nummern_id"];
    }

    public function set_textant42_nummern_id($val) {
        $this->item["textant42_nummern_id"] = $val;
    }								
	
    public static function search($start, $count, $filter) {
        $query = "SELECT t.*, p.text as 'prioritaet', b.name as 'benutzer', s.text as 'status', k.kdnr FROM ticket t
            LEFT JOIN status s ON s.id = t.status_id
            LEFT JOIN prioritaet p ON p.id = t.prioritaet_id
            LEFT JOIN benutzer b ON b.id = t.benutzer_id
            LEFT JOIN kunde k ON k.id = t.kunde_id
            WHERE t.mandant_id = " . App::$CURRENT->MANDANT->get_id();

        foreach ($filter as $item) {
            $query .= " AND $item";
        }

        $query .= " ORDER BY 1 LIMIT $start, $count";

        try {
            $response = array();
            $result = App::$CURRENT->DB->query($query);

            foreach ($result as $item) {
                array_push($response, new Ticket($item));
            }

            return $response;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function count2($start, $count, $filter) {
        $query = "SELECT count(t.id) as 'count' FROM ticket t
            WHERE t.mandant_id = " . App::$CURRENT->MANDANT->get_id();

        foreach ($filter as $item) {
            $query .= " AND $item";
        }

        $query .= " ORDER BY 1 LIMIT $start, $count";

        try {
            //$result = App::$CURRENT->DB->singleObjectQuery($query)->count;
            //return $result;
            return App::$CURRENT->DB->singleObjectQuery($query)->count;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }
    
    public static function count($mandant_id, $filter) {
        $query = "SELECT COUNT(t.id) AS 'count' FROM ticket t WHERE t.mandant_id = $mandant_id";

        foreach ($filter as $item) {
            $query .= " AND $item";
        }
        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public function get_status() {
        if (!isset($this->item["status"])) {
            return NULL;
        }
        return $this->item["status"];
    }

    private function set_status($val) {
        $this->item["status"] = $val;
    }

    public function get_prioritaet() {
        if (!isset($this->item["prioritaet"])) {
            return NULL;
        }
        return $this->item["prioritaet"];
    }

    private function set_prioritaet($val) {
        $this->item["prioritaet"] = $val;
    }

    public function get_benutzer() {
        if (!isset($this->item["benutzer"])) {
            return NULL;
        }
        return $this->item["benutzer"];
    }

    private function set_benutzer($val) {
        $this->item["benutzer"] = $val;
    }

    public function get_kunde() {
        if (!isset($this->item["kunde"])) {
            return NULL;
        }
        return $this->item["kunde"];
    }

    private function set_kunde($val) {
        $this->item["kunde"] = $val;
    }

    public function get_grund_id($sql_valid = FALSE) {
        if (!isset($this->item["grund_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["grund_id"];
    }

    public function set_grund_id($val) {
        if ($val == -1) {
            $val = NULL;
        }
        $this->item["grund_id"] = $val;
    }
    
    
    public function get_firma_id($sql_valid = FALSE) {
        if (!isset($this->item["firma_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["firma_id"];
    }

    public function set_firma_id($val) {
        if ($val == -1) {
            $val = NULL;
        }
        $this->item["firma_id"] = $val;
    }


    public function get_produkt_id($sql_valid = FALSE) {
        if (!isset($this->item["produkt_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["produkt_id"];
    }

    public function set_produkt_id($val) {
        if ($val == -1) {
            $val = NULL;
        }
        $this->item["produkt_id"] = $val;
    }
	

	

    
    public static function get_by_ticke_nr($ticket_nr) {
        $query = "SELECT t.* FROM ticket t WHERE t.ticketnr = $ticket_nr";

        try {
            $response = App::$CURRENT->DB->singleObjectQuery($query);
            return new Ticket($response);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get($id) {
        $query = "SELECT t.* FROM ticket t WHERE t.id = $id";

        try {
            $response = App::$CURRENT->DB->singleObjectQuery($query);
            return new Ticket($response);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

        
    public static function update($ticket) {
        try {
            $db = new DBConnection();

            $query = "UPDATE `ticket` SET 
            `ticketnr`=" . $ticket->get_ticketnr() . ",
            `mandant_id`=" . $ticket->get_mandant_id(TRUE) . ",
            `kunde_id`=" . $ticket->get_kunde_id(TRUE) . ",
            `benutzer_id`=" . $ticket->get_benutzer_id(TRUE) . ",
            `kundennummer`=" . $ticket->get_kundennummer(TRUE) . ",
            `anrede`=" . $ticket->get_anrede(TRUE) . ",
            `titel`=" . $ticket->get_titel(TRUE) . ",
            `nachname`=" . $ticket->get_nachname(TRUE) . ",
            `vorname`=" . $ticket->get_vorname(TRUE) . ",
            `plz`=" . $ticket->get_plz(TRUE) . ",
            `ort`=" . $ticket->get_ort(TRUE) . ",
            `strasse`=" . $ticket->get_strasse(TRUE) . ",
            `hausnummer`=" . $ticket->get_hausnummer(TRUE) . ",
            `hausnummer_erw`=" . $ticket->get_hausnummer_erw(TRUE) . ",
            `telefon`=" . $ticket->get_telefon(TRUE) . ",
            `email`=" . $ticket->get_email(TRUE) . ",
            `geburtsdatum`=" . $ticket->get_geburtsdatum(TRUE) . ",
            `kenner`=" . $ticket->get_kenner(TRUE) . ",
            `anruf_status_id`=" . $ticket->get_anruf_status_id(TRUE) . ",
            `ergebnis`=" . $ticket->get_ergebnis(TRUE) . ",
            `wiedervorlage`=" . $ticket->get_wiedervorlage(TRUE) . ",
            `status_id`=" . $ticket->get_status_id(TRUE) . ",
            `prioritaet_id`=" . $ticket->get_prioritaet_id(TRUE) . ",
            `beginn`=" . $ticket->get_beginn(TRUE) . ",
            land_id=" . $ticket->get_land_id(TRUE) . ",
            `ende`=" . $ticket->get_ende(TRUE) . ",
            `aufwand`=" . $ticket->get_aufwand(TRUE) . ",
            `beschreibung_detail`=" . $ticket->get_beschreibung_detail(TRUE) . ",
            `grund_id`=" . $ticket->get_grund_id(TRUE) . ",
            `firma_id`=" . $ticket->get_firma_id(TRUE) . ",
            `produkt_id`=" . $ticket->get_produkt_id(TRUE) . ",                        
            `textinfo1`=" . $ticket->get_textinfo1(TRUE) . ",                        			
            `textinfo2`=" . $ticket->get_textinfo2(TRUE) . ",                        						
            `textinfo3`=" . $ticket->get_textinfo3(TRUE) . ",                        			
            `textinfo4`=" . $ticket->get_textinfo4(TRUE) . ",                        						
            `textinfo5`=" . $ticket->get_textinfo5(TRUE) . ",                        									
            `telefon2`=" . $ticket->get_telefon2(TRUE) . ",			
            `standort`=" . $ticket->get_standort(TRUE) . ",
            `verkaeufercode`=" . $ticket->get_verkaeufercode(TRUE) . ",
            `verkaeufername`=" . $ticket->get_verkaeufername(TRUE) . ",
            `ltzt_wkst_auftrag`=" . $ticket->get_ltzt_wkst_auftrag(TRUE) . ",
            `erstzulassung`=" . $ticket->get_erstzulassung(TRUE) . ",
            `kundenzulassung`=" . $ticket->get_kundenzulassung(TRUE) . ",
            `markencode`=" . $ticket->get_markencode(TRUE) . ",
            `modell`=" . $ticket->get_modell(TRUE) . ",
            `amtliches_kennzeichen`=" . $ticket->get_amtliches_kennzeichen(TRUE) . ",
            `kilometer_stand`=" . $ticket->get_kilometer_stand(TRUE) . ",
            `fahrgestellnummer`=" . $ticket->get_fahrgestellnummer(TRUE) . ",
            `textant11_janein_id`=" . $ticket->get_textant11_janein_id(TRUE) . ",			
			`textant21_janein_id`=" . $ticket->get_textant21_janein_id(TRUE) . ",			
            `textant31_janein_id`=" . $ticket->get_textant31_janein_id(TRUE) . ",			
			`textant41_janein_id`=" . $ticket->get_textant41_janein_id(TRUE) . ",			
			`textant51_janein_id`=" . $ticket->get_textant51_janein_id(TRUE) . ",						
			`textant12_nummern_id`=" . $ticket->get_textant12_nummern_id(TRUE) . ",						
			`textant22_nummern_id`=" . $ticket->get_textant22_nummern_id(TRUE) . ",
			`textant32_nummern_id`=" . $ticket->get_textant32_nummern_id(TRUE) . ",						
			`textant42_nummern_id`=" . $ticket->get_textant42_nummern_id(TRUE) . ",				
			`textant52_nummern_id`=" . $ticket->get_textant52_nummern_id(TRUE) . ",							
            `geaendert_am`='" . date("Y-m-d H:i:s") . "',
            `geaendert_von`='" . App::$CURRENT->USER->get_name() . "'
                WHERE id = " . $ticket->get_id();

            $db->set_query($query);
            $db->set_auto_commit();
            $db->execute();

            App::$CURRENT->add_information(MSG_SAVED);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            if (isset($db)) {
                $db->rollback();
                $db->close();
            }
        }
    }

    public static function insert($ticket) {
        try {
            $db = new DBConnection();

            $query = "INSERT INTO `ticket`(
            `ticketnr`, 
            `mandant_id`, 
            `kunde_id`, 
            `benutzer_id`, 
            `kundennummer`, 
            `anrede`, 
            `titel`, 
            `nachname`, 
            `vorname`, 
            `plz`, 
            `ort`, 
            `strasse`, 
            `hausnummer`, 
            `hausnummer_erw`, 
            `telefon`, 
            `email`, 
            `geburtsdatum`, 
            `kenner`, 
            `anruf_status_id`, 
            `ergebnis`, 
            `wiedervorlage`, 
            `status_id`, 
            `prioritaet_id`, 
            `beginn`, 
            `ende`, 
            `aufwand`, 
            `beschreibung_detail`, 
            `grund_id`, 
            `firma_id`, 
            `produkt_id`, 
            `textinfo1`, 			
            `textinfo2`, 						
            `textinfo3`, 			
            `textinfo4`, 				
            `textinfo5`, 				
            `telefon2`, 						
			`standort`,
            `verkaeufercode`,
            `verkaeufername`,
            `ltzt_wkst_auftrag`,
            `erstzulassung`,
            `kundenzulassung`,
            `markencode`,
            `modell`,
            `amtliches_kennzeichen`,
            `kilometer_stand`,
            `fahrgestellnummer`,
            `textant11_janein_id`,			
			`textant21_janein_id`,			
            `textant31_janein_id`,			
			`textant41_janein_id`,				
			`textant51_janein_id`,							
			`textant12_nummern_id`,						
			`textant22_nummern_id`,				
			`textant32_nummern_id`,						
			`textant42_nummern_id`,				
			`textant52_nummern_id`,							
            `geaendert_am`, 
            `geaendert_von`,
            land_id) 
            VALUES (
            " . $ticket->get_ticketnr() . ",
            " . $ticket->get_mandant_id(TRUE) . ",
            " . $ticket->get_kunde_id(TRUE) . ",
            " . $ticket->get_benutzer_id(TRUE) . ",
            " . $ticket->get_kundennummer(TRUE) . ",
            " . $ticket->get_anrede(TRUE) . ",
            " . $ticket->get_titel(TRUE) . ",
            " . $ticket->get_nachname(TRUE) . ",
            " . $ticket->get_vorname(TRUE) . ",
            " . $ticket->get_plz(TRUE) . ",
            " . $ticket->get_ort(TRUE) . ",
            " . $ticket->get_strasse(TRUE) . ",
            " . $ticket->get_hausnummer(TRUE) . ",
            " . $ticket->get_hausnummer_erw(TRUE) . ",
            " . $ticket->get_telefon(TRUE) . ",
            " . $ticket->get_email(TRUE) . ",
            " . $ticket->get_geburtsdatum(TRUE) . ",
            " . $ticket->get_kenner(TRUE) . ",
            " . $ticket->get_anruf_status_id(TRUE) . ",
            " . $ticket->get_ergebnis(TRUE) . ",
            " . $ticket->get_wiedervorlage(TRUE) . ",
            " . $ticket->get_status_id(TRUE) . ",
            " . $ticket->get_prioritaet_id(TRUE) . ",
            " . $ticket->get_beginn(TRUE) . ",
            " . $ticket->get_ende(TRUE) . ",
            " . $ticket->get_aufwand(TRUE) . ",
            " . $ticket->get_beschreibung_detail(TRUE) . ",
            " . $ticket->get_grund_id(TRUE) . ",
            " . $ticket->get_firma_id(TRUE) . ",
            " . $ticket->get_produkt_id(TRUE) . ",            
            " . $ticket->get_textinfo1(TRUE) . ",            			
            " . $ticket->get_textinfo2(TRUE) . ",            						
            " . $ticket->get_textinfo3(TRUE) . ",            			
            " . $ticket->get_textinfo4(TRUE) . ",
            " . $ticket->get_telefon2(TRUE) . ",            						
            " . $ticket->get_standort(TRUE) . ",            						
            " . $ticket->get_verkaeufercode(TRUE) . ",            						
            " . $ticket->get_verkaeufername(TRUE) . ",            						
            " . $ticket->get_ltzt_wkst_auftrag(TRUE) . ",            						
            " . $ticket->get_erstzulassung(TRUE) . ",            						
            " . $ticket->get_kundenzulassung(TRUE) . ",            						
            " . $ticket->get_markencode(TRUE) . ",            						
            " . $ticket->get_modell(TRUE) . ",            						
            " . $ticket->get_amtliches_kennzeichen(TRUE) . ",            						
            " . $ticket->get_kilometer_stand(TRUE) . ",            						
            " . $ticket->get_fahrgestellnummer(TRUE) . ",            									
            " . $ticket->get_textant11_janein_id(TRUE) . ",            						
            " . $ticket->get_textant21_janein_id(TRUE) . ",    
            " . $ticket->get_textant31_janein_id(TRUE) . ",            						
            " . $ticket->get_textant41_janein_id(TRUE) . ", 			
            " . $ticket->get_textant12_nummern_id(TRUE) . ",            						
            " . $ticket->get_textant22_nummern_id(TRUE) . ",    
            " . $ticket->get_textant32_nummern_id(TRUE) . ",            						
            " . $ticket->get_textant42_nummern_id(TRUE) . ",  			
			'" . date("Y-m-d H:i:s") . "',
			'" . App::$CURRENT->USER->get_name() . "',
				" . $ticket->get_land_id(TRUE) . ")";

            $db->set_query($query);
            $db->execute();
            $id = $db->get_generated_id();
            $db->commit();

            $db->close();
            App::$CURRENT->add_information(MSG_SAVED);

            return $id;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            if (isset($db)) {
                $db->rollback();
                $db->close();
            }
            return 0;
        }
    }

    public static function delete($ticket_id) {
        try {
            $db = new DBConnection();
            $db->set_auto_commit();
            
            $query = "DELETE FROM `ticket` WHERE id = $ticket_id";
            
            $db->set_query($query);
            
            $db->execute();
            $db->close();
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            if (isset($db)) {
                $db->rollback();
                $db->close();
            }
        }
    }

}
?>
