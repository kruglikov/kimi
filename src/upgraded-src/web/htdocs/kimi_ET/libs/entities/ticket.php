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

	static function getTicketColumns () {
		
		$columns = " t.* ";
		
		
		if ( App::$CURRENT->isEncryptionEnabled()) {
					
			
			$columns = "t.id,".
						"t.ticketnr,". 
						"t.mandant_id,". 
						"t.kunde_id,". 
						"t.benutzer_id,". 
						"t.kundennummer,". 
						"kimi_decrypt(t.anrede) as anrede,". 
						"kimi_decrypt(t.titel) as titel,". 
						"kimi_decrypt(t.nachname) as nachname,". 
						"kimi_decrypt(t.vorname) as vorname,". 
						"kimi_decrypt(t.plz) as plz,". 
						"t.land_id,".
						"kimi_decrypt(t.ort) as ort,". 
						"kimi_decrypt(t.strasse) as strasse,". 
						"kimi_decrypt(t.hausnummer) as hausnummer,". 
						"kimi_decrypt(t.hausnummer_erw) as hausnummer_erw,". 
						"kimi_decrypt(t.telefon) as telefon,". 
						"kimi_decrypt(t.email) as email,". 
						"kimi_decrypt_date(t.geburtsdatum) as geburtsdatum,". 
						"t.kenner,". 
						"t.anruf_status_id,". 
						"t.ergebnis,". 
						"t.wiedervorlage,". 
						"t.wiedervorlage_zeitpunkt,". 
						"t.letzte_wiedervorlage,". 
						"t.letzte_wiedervorlage_zeitpunkt,". 
						"t.wiedervorlage_automatik,". 
						"t.anzahl_anrufe,". 
						"t.letzter_anruf,".
						"t.status_id,". 
						"t.prioritaet_id,". 
						"t.beginn,". 
						"t.ende,". 
						"t.aufwand,". 
						App::$CURRENT->getTicketDecryptionColumn("beschreibung_detail", "t.").",".
						"t.geaendert_am,". 
						"t.geaendert_von,".
						"t.grund_id,". 
						"t.firma_id,". 
						"t.produkt_id,". 
						"t.bewertung,".
						"t.katalogversand,".
						"t.emailversand,".
						"t.textinfo1,". 			
						"t.textant11_janein_id,".
						"t.textant12_nummern_id,".
						"t.textant21_janein_id,".
						"t.textant22_nummern_id,".
						"kimi_decrypt(t.telefon2) as telefon2,".				
						"t.standort,".
						"t.verkaeufercode,".
						"t.verkaeufername,".
						"t.erstzulassung,".
						"t.kundenzulassung,".
						"t.markencode,".
						"t.modell,".
						"t.amtliches_kennzeichen,".
						"t.fahrgestellnummer,".
						"t.kilometer_stand,".
						"t.textinfo2,".
						"t.ltzt_wkst_auftrag,".
						"t.textant31_janein_id,".
						"t.textant32_nummern_id,".
						"t.textinfo4,".
						"t.textant41_janein_id,".
						"t.textant42_nummern_id,".
						"t.textinfo3,".
						"t.textinfo5,".
						"t.textant51_janein_id,".
						"t.textant51_janein_id,".
						"t.kampagne_id,".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text1", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text2", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text3", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text4", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text5", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text6", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text7", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text8", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text9", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text10", "t.").",".
						"t.dummy_number1,".
						"t.dummy_number2,".
						"t.dummy_number3,".
						"t.dummy_number4,".
						"t.dummy_number5,".
						"t.dummy_number6,".
						"t.dummy_number7,".
						"t.dummy_number8,".
						"t.dummy_number9,".
						"t.dummy_number10,".
						"t.dummy_date1,".
						"t.dummy_date2,".
						"t.dummy_date3,".
						"t.dummy_date4,".
						"t.dummy_date5,".
						"t.dummy_date6,".
						"t.dummy_date7,".
						"t.dummy_date8,".
						"t.dummy_date9,".
						"t.dummy_date10,".
						"t.dummy_id1,".
						"t.dummy_id2,".
						"t.dummy_id3,".
						"t.dummy_id4,".
						"t.dummy_id5,".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text11", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text12", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text13", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text14", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text15", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text16", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text17", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text18", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text19", "t.").",".
						App::$CURRENT->getTicketDecryptionColumn("dummy_text20", "t.")." ";
						
		}

		return $columns;		
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
            return "'".App::$CURRENT->DB->escape_string($this->item["ergebnis"])."'";
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
		if (!$sql_valid) {
			return NULL;
		} else {
			return "NULL";
		}
	}
	if ($sql_valid) {
		//20220420
		$value = "'".App::$CURRENT->DB->escape_string($this->item["beschreibung_detail"])."'";
		if ( App::$CURRENT->isEncryptionEnabled()) {
		   $value =  App::$CURRENT->getTicketEncryptionValue("beschreibung_detail", $value);

		}
		return $value; 
	}
		return $this->item["beschreibung_detail"];
	}

	public function set_beschreibung_detail($val) {
		$this->item["beschreibung_detail"] = $val;
	}
	

    public function get_ticketnr($sql_valid = FALSE) {
        if (!isset($this->item["ticketnr"])) {
            if ($sql_valid) {
                return "NULL";
            }
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
            if ($sql_valid) return "NULL";
            return NULL;
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["kundennummer"])."'";
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
			//20211215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["nachname"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return "'".App::$CURRENT->DB->escape_string($this->item["nachname"])."'";
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
			//20211215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["vorname"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return "'".App::$CURRENT->DB->escape_string($this->item["vorname"])."'";
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
			//20211215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["plz"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return "'".App::$CURRENT->DB->escape_string($this->item["plz"])."'";
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
			//20211215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["ort"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return "'".App::$CURRENT->DB->escape_string($this->item["ort"])."'";
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
			//20211215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["strasse"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return "'".App::$CURRENT->DB->escape_string($this->item["strasse"])."'";
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
		if ($sql_valid) {
			//20211215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["hausnummer"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
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
			//20211215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["hausnummer_erw"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return "'".App::$CURRENT->DB->escape_string($this->item["hausnummer_erw"])."'";
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
			//20211215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["telefon"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return "'".App::$CURRENT->DB->escape_string($this->item["telefon"])."'";
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
			//20211215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["email"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return "'".App::$CURRENT->DB->escape_string($this->item["email"])."'";
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
			//201215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["geburtsdatum"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
			//"'".App::$CURRENT->DB->escape_string($this->item["geburtsdatum"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["kenner"])."'";
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
        if ($sql_valid) {
			//20211215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["anrede"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return "'".App::$CURRENT->DB->escape_string($this->item["telefon"])."'";
        }
        return $this->item["anrede"];
    }


    public function get_anrede3($sql_valid = FALSE) {
        if (!isset($this->item["anrede"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20211215
			//$value = $this->item["anrede"];
			$value = "'".App::$CURRENT->DB->escape_string($this->item["anrede"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return $this->item["anrede"];
        }
        return "'".App::$CURRENT->DB->escape_string($this->item["anrede"])."'";
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
			//20211215
			$value = $this->item["titel"];
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return $this->item["titel"];
        }
        return "'".App::$CURRENT->DB->escape_string($this->item["titel"])."'";
    }

    public function set_titel($titel) {
        $this->item["titel"] = $titel;
    }

    public function __construct($item = null, $sql_valid = FALSE) {
		if (isset($item)) {
            $this->item = array();
            $item = (array) $item;

            foreach($item as $key => $value) {
                $name = "set_".$key;

                //!empty($value)
                if (method_exists($this, $name) && $value != "") {
                    $this->$name($value, $sql_valid);
                }
            }
		}
    }

    public function get_wiedervorlage($sql_valid = FALSE) {
        if (!isset($this->item["wiedervorlage"]) || empty($this->item["wiedervorlage"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["wiedervorlage"])."'";
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

	public function get_wiedervorlage_zeitpunkt($sql_valid = FALSE) {
        if (!isset($this->item["wiedervorlage_zeitpunkt"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if (!$sql_valid) {
            return $this->item["wiedervorlage_zeitpunkt"];
        }
        return "'".App::$CURRENT->DB->escape_string($this->item["wiedervorlage_zeitpunkt"])."'";
    }

    public function set_wiedervorlage_zeitpunkt($value) {
        $this->item["wiedervorlage_zeitpunkt"] = $value;
    }

    public function get_letzte_wiedervorlage($sql_valid = FALSE) {
        if (!isset($this->item["letzte_wiedervorlage"]) || empty($this->item["letzte_wiedervorlage"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["letzte_wiedervorlage"])."'";
        }

        $date = date_create($this->item["letzte_wiedervorlage"]);
        return date_format($date, "d.m.Y");
    }

    public function set_letzte_wiedervorlage($value) {
        if (strlen($value) == 0 || strlen($value) == 0) {
            $this->item["letzte_wiedervorlage"] = NULL;
            return;
        }

        $date = date_create($value);

        $this->item["letzte_wiedervorlage"] = date_format($date, "Y-m-d H:i:s");
    }

	public function get_letzte_wiedervorlage_zeitpunkt($sql_valid = FALSE) {
        if (!isset($this->item["letzte_wiedervorlage_zeitpunkt"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if (!$sql_valid) {
            return $this->item["letzte_wiedervorlage_zeitpunkt"];
        }
        return "'".App::$CURRENT->DB->escape_string($this->item["letzte_wiedervorlage_zeitpunkt"])."'";
    }

    public function set_letzte_wiedervorlage_zeitpunkt($value) {
        $this->item["letzte_wiedervorlage_zeitpunkt"] = $value;
    }

    public function get_wiedervorlage_automatik($sql_valid = FALSE) {
        if (!isset($this->item["wiedervorlage_automatik"])) {
            if ($sql_valid) {
                return "1";
            }
            return NULL;
        }
        return $this->item["wiedervorlage_automatik"];
    }

    public function set_wiedervorlage_automatik($val) {
        $this->item["wiedervorlage_automatik"] = $val;
    }

    public function get_anzahl_anrufe($sql_valid = FALSE) {
        if (!isset($this->item["anzahl_anrufe"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return "0";
        }
        return $this->item["anzahl_anrufe"];
    }

    public function set_anzahl_anrufe($val) {
        $this->item["anzahl_anrufe"] = $val;
    }

    public function get_letzter_anruf($sql_valid = FALSE) {
        if (!isset($this->item["letzter_anruf"]) || empty($this->item["letzter_anruf"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["letzter_anruf"])."'";
        }

        $date = date_create($this->item["letzter_anruf"]);
        return date_format($date, "d.m.Y H:i:s");
    }

    public function set_letzter_anruf($value) {
        if (strlen($value) == 0 || strlen($value) == 0) {
            $this->item["letzter_anruf"] = NULL;
            return;
        }

        $date = date_create($value);

        $this->item["letzter_anruf"] = date_format($date, "Y-m-d H:i:s");
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
            return "'".App::$CURRENT->DB->escape_string($this->item["beginn"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["ende"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textinfo1"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textant11_janein_id"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textant12_nummern_id"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textinfo2"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textant21_janein_id"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textant22_nummern_id"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textinfo5"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textant51_janein_id"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textant52_nummern_id"])."'";
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
			//201215
			$value = "'".App::$CURRENT->DB->escape_string($this->item["telefon2"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
			   $value = " kimi_encrypt(".$value.")";
			}
            return $value; 
            //return "'".App::$CURRENT->DB->escape_string($this->item["telefon2"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["standort"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["verkaeufercode"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["verkaeufername"])."'";
        }
        return $this->item["verkaeufername"];
    }

    public function set_verkaeufername($val) {
        $this->item["verkaeufername"] = $val;
    }



    public function get_ltzt_wkst_auftrag($sql_valid = FALSE) {
        if (!isset($this->item["ltzt_wkst_auftrag"]) || empty($this->item["ltzt_wkst_auftrag"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["ltzt_wkst_auftrag"])."'";
        }
        return $this->item["ltzt_wkst_auftrag"];
    }

    public function set_ltzt_wkst_auftrag($val) {
        $this->item["ltzt_wkst_auftrag"] = $val;
    }


    public function get_erstzulassung($sql_valid = FALSE) {
        if (!isset($this->item["erstzulassung"]) || empty($this->item["erstzulassung"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["erstzulassung"])."'";
        }
        return $this->item["erstzulassung"];
    }

    public function set_erstzulassung($val) {
        $this->item["erstzulassung"] = $val;
    }


    public function get_kundenzulassung($sql_valid = FALSE) {
        if (!isset($this->item["kundenzulassung"]) || empty($this->item["kundenzulassung"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["kundenzulassung"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["markencode"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["modell"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["amtliches_kennzeichen"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["kilometer_stand"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["fahrgestellnummer"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textinfo3"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textant31_janein_id"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textant32_nummern_id"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textinfo4"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textant41_janein_id"])."'";
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
            return "'".App::$CURRENT->DB->escape_string($this->item["textant42_nummern_id"])."'";
        }
        return $this->item["textant42_nummern_id"];
    }

    public function set_textant42_nummern_id($val) {
        $this->item["textant42_nummern_id"] = $val;
    }


    public function get_dummy_text1($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text1"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text1"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text1", $value);

			  // $value = " kimi_encrypt(".$value.")";
			}
            return $value; 

            //return "'".App::$CURRENT->DB->escape_string($this->item["dummy_text1"])."'";
        }
        return $this->item["dummy_text1"];
    }

    public function set_dummy_text1($dummy_text1) {
        $this->item["dummy_text1"] = $dummy_text1;
    }
    public function get_dummy_text2($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text2"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text2"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text2", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text2"];
    }

    public function set_dummy_text2($dummy_text2) {
        $this->item["dummy_text2"] = $dummy_text2;
    }

    public function get_dummy_text3($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text3"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text3"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text3", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text3"];
    }

    public function set_dummy_text3($dummy_text3) {
        $this->item["dummy_text3"] = $dummy_text3;
    }
    public function get_dummy_text4($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text4"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text4"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text4", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text4"];
    }

    public function set_dummy_text4($dummy_text4) {
        $this->item["dummy_text4"] = $dummy_text4;
    }
    public function get_dummy_text5($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text5"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text5"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text5", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text5"];
    }

    public function set_dummy_text5($dummy_text5) {
        $this->item["dummy_text5"] = $dummy_text5;
    }
    public function get_dummy_text6($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text6"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text6"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text6", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text6"];
    }

    public function set_dummy_text6($dummy_text6) {
        $this->item["dummy_text6"] = $dummy_text6;
    }

    public function get_dummy_text7($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text7"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text7"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text7", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text7"];
    }

    public function set_dummy_text7($dummy_text7) {
        $this->item["dummy_text7"] = $dummy_text7;
    }
    public function get_dummy_text8($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text8"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text8"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text8", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text8"];
    }

    public function set_dummy_text8($dummy_text8) {
        $this->item["dummy_text8"] = $dummy_text8;
    }
    public function get_dummy_text9($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text9"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text9"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text9", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text9"];
    }

    public function set_dummy_text9($dummy_text9) {
        $this->item["dummy_text9"] = $dummy_text9;
    }
	
    public function get_dummy_text10($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text10"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text10"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text10", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text10"];
    }

    public function set_dummy_text10($dummy_text10) {
        $this->item["dummy_text10"] = $dummy_text10;
    }

	
	public function get_dummy_text11($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text11"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text11"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text11", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text11"];
    }

    public function set_dummy_text11($dummy_text11) {
        $this->item["dummy_text11"] = $dummy_text11;
    }
	
	public function get_dummy_text12($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text12"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text12"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text12", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text12"];
    }

    public function set_dummy_text12($dummy_text12) {
        $this->item["dummy_text12"] = $dummy_text12;
    }
	
	public function get_dummy_text13($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text13"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text13"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text13", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text13"];
    }

    public function set_dummy_text13($dummy_text13) {
        $this->item["dummy_text13"] = $dummy_text13;
    }
	
	public function get_dummy_text14($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text14"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text14"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text14", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text14"];
    }

    public function set_dummy_text14($dummy_text14) {
        $this->item["dummy_text14"] = $dummy_text14;
    }
	
	public function get_dummy_text15($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text15"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text15"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text15", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text15"];
    }

    public function set_dummy_text15($dummy_text15) {
        $this->item["dummy_text15"] = $dummy_text15;
    }
	
	public function get_dummy_text16($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text16"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text16"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text16", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text16"];
    }

    public function set_dummy_text16($dummy_text16) {
        $this->item["dummy_text16"] = $dummy_text16;
    }
	
	public function get_dummy_text17($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text17"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text17"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text17", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text17"];
    }

    public function set_dummy_text17($dummy_text17) {
        $this->item["dummy_text17"] = $dummy_text17;
    }
	
	public function get_dummy_text18($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text18"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text18"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text18", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text18"];
    }

    public function set_dummy_text18($dummy_text18) {
        $this->item["dummy_text18"] = $dummy_text18;
    }
	
	public function get_dummy_text19($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text19"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text19"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text19", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text19"];
    }

    public function set_dummy_text19($dummy_text19) {
        $this->item["dummy_text19"] = $dummy_text19;
    }
	
	public function get_dummy_text20($sql_valid = FALSE) {
        if (!isset($this->item["dummy_text20"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }
        if ($sql_valid) {
			//20220420
			$value = "'".App::$CURRENT->DB->escape_string($this->item["dummy_text20"])."'";
			if ( App::$CURRENT->isEncryptionEnabled()) {
               $value =  App::$CURRENT->getTicketEncryptionValue("dummy_text20", $value);
			}
            return $value; 
        }
        return $this->item["dummy_text20"];
    }

    public function set_dummy_text20($dummy_text20) {
        $this->item["dummy_text20"] = $dummy_text20;
    }
	
    public function get_dummy_number1($sql_valid = FALSE) {
        if (!isset($this->item["dummy_number1"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["dummy_number1"], 2, ".", "");
        }

        return number_format((float) $this->item["dummy_number1"], 2, ",", ".");
    }

    public function set_dummy_number1($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);
        $this->item["dummy_number1"] = $val;
    }
    public function get_dummy_number2($sql_valid = FALSE) {
        if (!isset($this->item["dummy_number2"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["dummy_number2"], 2, ".", "");
        }

        return number_format((float) $this->item["dummy_number2"], 2, ",", ".");
    }

    public function set_dummy_number2($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);

        $this->item["dummy_number2"] = $val;
    }
    public function get_dummy_number3($sql_valid = FALSE) {
        if (!isset($this->item["dummy_number3"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["dummy_number3"], 2, ".", "");
        }

        return number_format((float) $this->item["dummy_number3"], 2, ",", ".");
    }

    public function set_dummy_number3($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);

        $this->item["dummy_number3"] = $val;
    }
    public function get_dummy_number4($sql_valid = FALSE) {
        if (!isset($this->item["dummy_number4"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["dummy_number4"], 2, ".", "");
        }

        return number_format((float) $this->item["dummy_number4"], 2, ",", ".");
    }

    public function set_dummy_number4($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);

        $this->item["dummy_number4"] = $val;
    }
    public function get_dummy_number5($sql_valid = FALSE) {
        if (!isset($this->item["dummy_number5"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["dummy_number5"], 2, ".", "");
        }

        return number_format((float) $this->item["dummy_number5"], 2, ",", ".");
    }

    public function set_dummy_number5($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);

        $this->item["dummy_number5"] = $val;
    }
    public function get_dummy_number6($sql_valid = FALSE) {
        if (!isset($this->item["dummy_number6"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["dummy_number6"], 2, ".", "");
        }

        return number_format((float) $this->item["dummy_number6"], 2, ",", ".");
    }

    public function set_dummy_number6($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);

        $this->item["dummy_number6"] = $val;
    }
    public function get_dummy_number7($sql_valid = FALSE) {
        if (!isset($this->item["dummy_number7"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["dummy_number7"], 2, ".", "");
        }

        return number_format((float) $this->item["dummy_number7"], 2, ",", ".");
    }

    public function set_dummy_number7($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);

        $this->item["dummy_number7"] = $val;
    }
    public function get_dummy_number8($sql_valid = FALSE) {
        if (!isset($this->item["dummy_number8"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["dummy_number8"], 2, ".", "");
        }

        return number_format((float) $this->item["dummy_number8"], 2, ",", ".");
    }

    public function set_dummy_number8($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);

        $this->item["dummy_number8"] = $val;
    }
    public function get_dummy_number9($sql_valid = FALSE) {
        if (!isset($this->item["dummy_number9"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["dummy_number9"], 2, ".", "");
        }

        return number_format((float) $this->item["dummy_number9"], 2, ",", ".");
    }

    public function set_dummy_number9($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);

        $this->item["dummy_number9"] = $val;
    }
    public function get_dummy_number10($sql_valid = FALSE) {
        if (!isset($this->item["dummy_number10"])) {
            if (!$sql_valid) {
                return NULL;
            } else {
                return "NULL";
            }
        }

        if ($sql_valid) {
            return number_format((float) $this->item["dummy_number10"], 2, ".", "");
        }

        return number_format((float) $this->item["dummy_number10"], 2, ",", ".");
    }

    public function set_dummy_number10($val, $sql_valid = FALSE) {
        if (!$sql_valid) {
            $val = str_replace(".", "", $val);
        }
        $val = str_replace(",", ".", $val);

        $this->item["dummy_number10"] = $val;
    }

    public function get_dummy_date1($sql_valid = FALSE) {
        if (!isset($this->item["dummy_date1"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["dummy_date1"])."'";
        }

        $date = date_create($this->item["dummy_date1"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dummy_date1($val, $sql_valid = FALSE) {
        {
            if (strlen($val) == 0) {
                $this->item["dummy_date1"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["dummy_date1"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    public function get_dummy_date2($sql_valid = FALSE) {
        if (!isset($this->item["dummy_date2"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["dummy_date2"])."'";
        }

        $date = date_create($this->item["dummy_date2"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dummy_date2($val, $sql_valid = FALSE) {
        {
            if (strlen($val) == 0) {
                $this->item["dummy_date2"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["dummy_date2"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    public function get_dummy_date3($sql_valid = FALSE) {
        if (!isset($this->item["dummy_date3"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["dummy_date3"])."'";
        }

        $date = date_create($this->item["dummy_date3"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dummy_date3($val, $sql_valid = FALSE) {
        {
            if (strlen($val) == 0) {
                $this->item["dummy_date3"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["dummy_date3"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    public function get_dummy_date4($sql_valid = FALSE) {
        if (!isset($this->item["dummy_date4"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["dummy_date4"])."'";
        }

        $date = date_create($this->item["dummy_date4"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dummy_date4($val, $sql_valid = FALSE) {
        {
            if (strlen($val) == 0) {
                $this->item["dummy_date4"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["dummy_date4"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    public function get_dummy_date5($sql_valid = FALSE) {
        if (!isset($this->item["dummy_date5"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["dummy_date5"])."'";
        }

        $date = date_create($this->item["dummy_date5"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dummy_date5($val, $sql_valid = FALSE) {
        {
            if (strlen($val) == 0) {
                $this->item["dummy_date5"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["dummy_date5"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    public function get_dummy_date6($sql_valid = FALSE) {
        if (!isset($this->item["dummy_date6"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["dummy_date6"])."'";
        }

        $date = date_create($this->item["dummy_date6"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dummy_date6($val, $sql_valid = FALSE) {
        {
            if (strlen($val) == 0) {
                $this->item["dummy_date6"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["dummy_date6"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    public function get_dummy_date7($sql_valid = FALSE) {
        if (!isset($this->item["dummy_date7"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["dummy_date7"])."'";
        }

        $date = date_create($this->item["dummy_date7"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dummy_date7($val, $sql_valid = FALSE) {
        {
            if (strlen($val) == 0) {
                $this->item["dummy_date7"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["dummy_date7"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    public function get_dummy_date8($sql_valid = FALSE) {
        if (!isset($this->item["dummy_date8"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["dummy_date8"])."'";
        }

        $date = date_create($this->item["dummy_date8"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dummy_date8($val, $sql_valid = FALSE) {
        {
            if (strlen($val) == 0) {
                $this->item["dummy_date8"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["dummy_date8"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    public function get_dummy_date9($sql_valid = FALSE) {
        if (!isset($this->item["dummy_date9"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["dummy_date9"])."'";
        }

        $date = date_create($this->item["dummy_date9"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dummy_date9($val, $sql_valid = FALSE) {
        {
            if (strlen($val) == 0) {
                $this->item["dummy_date9"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["dummy_date9"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    public function get_dummy_date10($sql_valid = FALSE) {
        if (!isset($this->item["dummy_date10"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'".App::$CURRENT->DB->escape_string($this->item["dummy_date10"])."'";
        }

        $date = date_create($this->item["dummy_date10"]);
        return date_format($date, "d.m.Y");
    }

    public function set_dummy_date10($val, $sql_valid = FALSE) {
        {
            if (strlen($val) == 0) {
                $this->item["dummy_date10"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["dummy_date10"] = date_format($date, "Y-m-d H:i:s");
        }
    }

    public function get_dummy_id1($sql_valid = FALSE) {
        if (!isset($this->item["dummy_id1"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["dummy_id1"];
    }

    public function set_dummy_id1($val) {
        $this->item["dummy_id1"] = $val;
    }
    public function get_dummy_id2($sql_valid = FALSE) {
        if (!isset($this->item["dummy_id2"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["dummy_id2"];
    }

    public function set_dummy_id2($val) {
        $this->item["dummy_id2"] = $val;
    }
    public function get_dummy_id3($sql_valid = FALSE) {
        if (!isset($this->item["dummy_id3"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["dummy_id3"];
    }

    public function set_dummy_id3($val) {
        $this->item["dummy_id3"] = $val;
    }
    public function get_dummy_id4($sql_valid = FALSE) {
        if (!isset($this->item["dummy_id4"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["dummy_id4"];
    }

    public function set_dummy_id4($val) {
        $this->item["dummy_id4"] = $val;
    }
    public function get_dummy_id5($sql_valid = FALSE) {
        if (!isset($this->item["dummy_id5"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["dummy_id5"];
    }

    public function set_dummy_id5($val) {
        $this->item["dummy_id5"] = $val;
    }


    public static

    function search($start, $count, $filter, $kId) {
		//20211216
        $query = "SELECT ".Ticket::getTicketColumns().", p.text as 'prioritaet', b.name as 'benutzer', s.text as 'status', k.kdnr, ars.text as 'anruf_status', f.text as 'firma_text' 
            FROM ticket t
            LEFT JOIN status s ON s.id = t.status_id
            LEFT JOIN prioritaet p ON p.id = t.prioritaet_id
            LEFT JOIN benutzer b ON b.id = t.benutzer_id
            LEFT JOIN kunde k ON k.id = t.kunde_id
            LEFT JOIN anruf_status ars ON ars.id = t.anruf_status_id
            LEFT JOIN firma f ON f.id = t.firma_id
            WHERE t.kampagne_id = $kId AND t.mandant_id = ".App::$CURRENT->MANDANT->get_id();

        foreach($filter as $item) {
            $query .= " AND $item";
        }

        $query .= " ORDER BY 1 LIMIT $start, $count";

        try {
            $response = array();
            $result = App::$CURRENT->DB->query($query);

            foreach($result as $item) {
                array_push($response, new Ticket($item, TRUE));
            }

            return $response;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    // NICHT VERWENDEN
    public static

    function count2($start, $count, $filter) {
        $query = "SELECT count(t.id) as 'count' FROM ticket t
            WHERE t.mandant_id = ".App::$CURRENT->MANDANT->get_id();

        foreach($filter as $item) {
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

    public static

    function count($mandant_id, $filter, $kId) {
        $query = "SELECT COUNT(t.id) AS 'count' FROM ticket t WHERE t.kampagne_id = $kId AND t.mandant_id = $mandant_id";

        foreach($filter as $item) {
            $query .= " AND $item";
        }
        try {
            return App::$CURRENT->DB->singleObjectQuery($query)->count;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
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

    public function get_anruf_status() {
        if (!isset($this->item["anruf_status"])) {
            return NULL;
        }
        return $this->item["anruf_status"];
    }

    private function set_anruf_status($val) {
        $this->item["anruf_status"] = $val;
    }

    public function get_firma_text() {
        if (!isset($this->item["firma_text"])) {
            return NULL;
        }
        return $this->item["firma_text"];
    }

    private function set_firma_text($val) {
        $this->item["firma_text"] = $val;
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


    public function get_kampagne_id($sql_valid = FALSE) {
        if (!isset($this->item["kampagne_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["kampagne_id"];
    }

    public function set_kampagne_id($val) {
        $this->item["kampagne_id"] = $val;
    }





    public static

    function get_by_ticke_nr($ticket_nr) {
        $query = "SELECT ".Ticket::getTicketColumns()." FROM ticket t WHERE t.ticketnr = $ticket_nr";

        try {
            $response = App::$CURRENT->DB->singleObjectQuery($query);
            return new Ticket($response);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static

    function get($id) {
        $query = "SELECT ".Ticket::getTicketColumns()." FROM ticket t WHERE t.id = $id";

        try {
            $response = App::$CURRENT->DB->singleObjectQuery($query);
            return new Ticket($response, TRUE);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }
	


    public static

    function update($ticket) {
        try {
            $db = new DBConnection();

            $query = "UPDATE `ticket` SET 
            `ticketnr`=".$ticket->get_ticketnr().",
            `mandant_id`=".$ticket->get_mandant_id(TRUE).",
            `kunde_id`=".$ticket->get_kunde_id(TRUE).",
            `benutzer_id`=".$ticket->get_benutzer_id(TRUE).",
            `kundennummer`=".$ticket->get_kundennummer(TRUE).",
            `anrede`=".$ticket->get_anrede(TRUE).",
            `titel`=".$ticket->get_titel(TRUE).",
            `nachname`=".$ticket->get_nachname(TRUE).",
            `vorname`=".$ticket->get_vorname(TRUE).",
            `plz`=".$ticket->get_plz(TRUE).",
            `ort`=".$ticket->get_ort(TRUE).",
            `strasse`=".$ticket->get_strasse(TRUE).",
            `hausnummer`=".$ticket->get_hausnummer(TRUE).",
            `hausnummer_erw`=".$ticket->get_hausnummer_erw(TRUE).",
            `telefon`=".$ticket->get_telefon(TRUE).",
            `email`=".$ticket->get_email(TRUE).",
            `geburtsdatum`=".$ticket->get_geburtsdatum(TRUE).",
            `kenner`=".$ticket->get_kenner(TRUE).",
            `anruf_status_id`=".$ticket->get_anruf_status_id(TRUE).",
            `ergebnis`=".$ticket->get_ergebnis(TRUE).",
            `wiedervorlage`=".$ticket->get_wiedervorlage(TRUE).",
			`wiedervorlage_zeitpunkt`=".$ticket->get_wiedervorlage_zeitpunkt(TRUE).",
			`wiedervorlage_automatik`=".$ticket->get_wiedervorlage_automatik(TRUE).",
            `status_id`=".$ticket->get_status_id(TRUE).",
            `prioritaet_id`=".$ticket->get_prioritaet_id(TRUE).",
            `beginn`=".$ticket->get_beginn(TRUE).",
            `land_id`=".$ticket->get_land_id(TRUE).",
            `ende`=".$ticket->get_ende(TRUE).",
            `aufwand`=".$ticket->get_aufwand(TRUE).",
            `beschreibung_detail`=".$ticket->get_beschreibung_detail(TRUE).",
            `grund_id`=".$ticket->get_grund_id(TRUE).",
            `firma_id`=".$ticket->get_firma_id(TRUE).",
            `produkt_id`=".$ticket->get_produkt_id(TRUE).",                        
            `textinfo1`=".$ticket->get_textinfo1(TRUE).",                        			
            `textinfo2`=".$ticket->get_textinfo2(TRUE).",                        						
            `textinfo3`=".$ticket->get_textinfo3(TRUE).",                        			
            `textinfo4`=".$ticket->get_textinfo4(TRUE).",                        						
            `textinfo5`=".$ticket->get_textinfo5(TRUE).",                        									
            `telefon2`=".$ticket->get_telefon2(TRUE).",			
            `standort`=".$ticket->get_standort(TRUE).",
            `verkaeufercode`=".$ticket->get_verkaeufercode(TRUE).",
            `verkaeufername`=".$ticket->get_verkaeufername(TRUE).",
            `ltzt_wkst_auftrag`=".$ticket->get_ltzt_wkst_auftrag(TRUE).",
            `erstzulassung`=".$ticket->get_erstzulassung(TRUE).",
            `kundenzulassung`=".$ticket->get_kundenzulassung(TRUE).",
            `markencode`=".$ticket->get_markencode(TRUE).",
            `modell`=".$ticket->get_modell(TRUE).",
            `amtliches_kennzeichen`=".$ticket->get_amtliches_kennzeichen(TRUE).",
            `kilometer_stand`=".$ticket->get_kilometer_stand(TRUE).",
            `fahrgestellnummer`=".$ticket->get_fahrgestellnummer(TRUE).",
            `textant11_janein_id`=".$ticket->get_textant11_janein_id(TRUE).",			
			`textant21_janein_id`=".$ticket->get_textant21_janein_id(TRUE).",			
            `textant31_janein_id`=".$ticket->get_textant31_janein_id(TRUE).",			
			`textant41_janein_id`=".$ticket->get_textant41_janein_id(TRUE).",			
			`textant51_janein_id`=".$ticket->get_textant51_janein_id(TRUE).",						
			`textant12_nummern_id`=".$ticket->get_textant12_nummern_id(TRUE).",						
			`textant22_nummern_id`=".$ticket->get_textant22_nummern_id(TRUE).",
			`textant32_nummern_id`=".$ticket->get_textant32_nummern_id(TRUE).",						
			`textant42_nummern_id`=".$ticket->get_textant42_nummern_id(TRUE).",				
			`textant52_nummern_id`=".$ticket->get_textant52_nummern_id(TRUE).",							
            `dummy_text1`=".$ticket->get_dummy_text1(TRUE).",
            `dummy_text2`=".$ticket->get_dummy_text2(TRUE).",
            `dummy_text3`=".$ticket->get_dummy_text3(TRUE).",
            `dummy_text4`=".$ticket->get_dummy_text4(TRUE).",
            `dummy_text5`=".$ticket->get_dummy_text5(TRUE).",
            `dummy_text6`=".$ticket->get_dummy_text6(TRUE).",
            `dummy_text7`=".$ticket->get_dummy_text7(TRUE).",
            `dummy_text8`=".$ticket->get_dummy_text8(TRUE).",
            `dummy_text9`=".$ticket->get_dummy_text9(TRUE).",
            `dummy_text10`=".$ticket->get_dummy_text10(TRUE).",
			`dummy_text11`=".$ticket->get_dummy_text11(TRUE).",
            `dummy_text12`=".$ticket->get_dummy_text12(TRUE).",
            `dummy_text13`=".$ticket->get_dummy_text13(TRUE).",
            `dummy_text14`=".$ticket->get_dummy_text14(TRUE).",
            `dummy_text15`=".$ticket->get_dummy_text15(TRUE).",
            `dummy_text16`=".$ticket->get_dummy_text16(TRUE).",
            `dummy_text17`=".$ticket->get_dummy_text17(TRUE).",
            `dummy_text18`=".$ticket->get_dummy_text18(TRUE).",
            `dummy_text19`=".$ticket->get_dummy_text19(TRUE).",
            `dummy_text20`=".$ticket->get_dummy_text20(TRUE).",
            `dummy_number1`=".$ticket->get_dummy_number1(TRUE).",
            `dummy_number2`=".$ticket->get_dummy_number2(TRUE).",
            `dummy_number3`=".$ticket->get_dummy_number3(TRUE).",
            `dummy_number4`=".$ticket->get_dummy_number4(TRUE).",
            `dummy_number5`=".$ticket->get_dummy_number5(TRUE).",
            `dummy_number6`=".$ticket->get_dummy_number6(TRUE).",
            `dummy_number7`=".$ticket->get_dummy_number7(TRUE).",
            `dummy_number8`=".$ticket->get_dummy_number8(TRUE).",
            `dummy_number9`=".$ticket->get_dummy_number9(TRUE).",
            `dummy_number10`=".$ticket->get_dummy_number10(TRUE).",
            `dummy_date1`=".$ticket->get_dummy_date1(TRUE).",
            `dummy_date2`=".$ticket->get_dummy_date2(TRUE).",
            `dummy_date3`=".$ticket->get_dummy_date3(TRUE).",
            `dummy_date4`=".$ticket->get_dummy_date4(TRUE).",
            `dummy_date5`=".$ticket->get_dummy_date5(TRUE).",
            `dummy_date6`=".$ticket->get_dummy_date6(TRUE).",
            `dummy_date7`=".$ticket->get_dummy_date7(TRUE).",
            `dummy_date8`=".$ticket->get_dummy_date8(TRUE).",
            `dummy_date9`=".$ticket->get_dummy_date9(TRUE).",
            `dummy_date10`=".$ticket->get_dummy_date10(TRUE).",    
            `dummy_id1`=".$ticket->get_dummy_id1(TRUE).",
            `dummy_id2`=".$ticket->get_dummy_id2(TRUE).",
            `dummy_id3`=".$ticket->get_dummy_id3(TRUE).",
            `dummy_id4`=".$ticket->get_dummy_id4(TRUE).",
            `dummy_id5`=".$ticket->get_dummy_id5(TRUE).",

            `geaendert_am`='".date("Y-m-d H:i:s")."',
            `geaendert_von`='".App::$CURRENT->USER->get_name()."'
                WHERE id = ".$ticket->get_id();

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

    public static

    function insert($ticket, $insert_akt = FALSE, $kampId = 0) {
        try {
            $db = new DBConnection();
			// 20160522/ar
		    if ($kampId==CONF_KAMPAGNE_AKT ){
				$ticketnr = Ticket::get_next_ticket_nr($kampId);
				$ticket->set_ticketnr($ticketnr);
            }
            //20191204/ab
            if($ticket->get_ticketnr(TRUE)=="NULL"){
                $ticketnr = Ticket::get_next_ticket_nr_mandant();
				$ticket->set_ticketnr($ticketnr);
            }

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
			`wiedervorlage_zeitpunkt`, 
			`letzte_wiedervorlage`, 
			`letzte_wiedervorlage_zeitpunkt`, 
			`wiedervorlage_automatik`, 
			`anzahl_anrufe`, 
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
            `kampagne_id`, 
            `dummy_text1`,
            `dummy_text2`,
            `dummy_text3`,
            `dummy_text4`,
            `dummy_text5`,
            `dummy_text6`,
            `dummy_text7`,
            `dummy_text8`,
            `dummy_text9`,
            `dummy_text10`,
            `dummy_text11`,
            `dummy_text12`,
            `dummy_text13`,
            `dummy_text14`,
            `dummy_text15`,
            `dummy_text16`,
            `dummy_text17`,
            `dummy_text18`,
            `dummy_text19`,
            `dummy_text20`,
            `dummy_number1`,
            `dummy_number2`,
            `dummy_number3`,
            `dummy_number4`,
            `dummy_number5`,
            `dummy_number6`,
            `dummy_number7`,
            `dummy_number8`,
            `dummy_number9`,
            `dummy_number10`,
            `dummy_date1`,
            `dummy_date2`,
            `dummy_date3`,
            `dummy_date4`,
            `dummy_date5`,
            `dummy_date6`,
            `dummy_date7`,
            `dummy_date8`,
            `dummy_date9`,
            `dummy_date10`,
            `dummy_id1`,
            `dummy_id2`,
            `dummy_id3`,
            `dummy_id4`,
            `dummy_id5`,
            `geaendert_am`, 
            `geaendert_von`,
            land_id) 
            VALUES (
            ".$ticket->get_ticketnr(TRUE).",
            ".$ticket->get_mandant_id(TRUE).",
            ".$ticket->get_kunde_id(TRUE).",
            ".$ticket->get_benutzer_id(TRUE).",
            ".$ticket->get_kundennummer(TRUE).",
            ".$ticket->get_anrede(TRUE).",
            ".$ticket->get_titel(TRUE).",
            ".$ticket->get_nachname(TRUE).",
            ".$ticket->get_vorname(TRUE).",
            ".$ticket->get_plz(TRUE).",
            ".$ticket->get_ort(TRUE).",
            ".$ticket->get_strasse(TRUE).",
            ".$ticket->get_hausnummer(TRUE).",
            ".$ticket->get_hausnummer_erw(TRUE).",
            ".$ticket->get_telefon(TRUE).",
            ".$ticket->get_email(TRUE).",
            ".$ticket->get_geburtsdatum(TRUE).",
            ".$ticket->get_kenner(TRUE).",
            ".$ticket->get_anruf_status_id(TRUE).",
            ".$ticket->get_ergebnis(TRUE).",
            ".$ticket->get_wiedervorlage(TRUE).",
			".$ticket->get_wiedervorlage_zeitpunkt(TRUE).",
			".$ticket->get_letzte_wiedervorlage(TRUE).",
			".$ticket->get_letzte_wiedervorlage_zeitpunkt(TRUE).",
			".$ticket->get_wiedervorlage_automatik(TRUE).",
			".$ticket->get_anzahl_anrufe(TRUE).",
            ".$ticket->get_status_id(TRUE).",
            ".$ticket->get_prioritaet_id(TRUE).",
            ".$ticket->get_beginn(TRUE).",
            ".$ticket->get_ende(TRUE).",
            ".$ticket->get_aufwand(TRUE).",
            ".$ticket->get_beschreibung_detail(TRUE).",
            ".$ticket->get_grund_id(TRUE).",
            ".$ticket->get_firma_id(TRUE).",
            ".$ticket->get_produkt_id(TRUE).",            
            ".$ticket->get_textinfo1(TRUE).",            			
            ".$ticket->get_textinfo2(TRUE).",            						
            ".$ticket->get_textinfo3(TRUE).",            			
            ".$ticket->get_textinfo4(TRUE).",
            ".$ticket->get_textinfo5(TRUE).",
            ".$ticket->get_telefon2(TRUE).",            						
            ".$ticket->get_standort(TRUE).",            						
            ".$ticket->get_verkaeufercode(TRUE).",            						
            ".$ticket->get_verkaeufername(TRUE).",            						
            ".$ticket->get_ltzt_wkst_auftrag(TRUE).",            						
            ".$ticket->get_erstzulassung(TRUE).",            						
            ".$ticket->get_kundenzulassung(TRUE).",            						
            ".$ticket->get_markencode(TRUE).",            						
            ".$ticket->get_modell(TRUE).",            						
            ".$ticket->get_amtliches_kennzeichen(TRUE).",            						
            ".$ticket->get_kilometer_stand(TRUE).",            						
            ".$ticket->get_fahrgestellnummer(TRUE).",            									
            ".$ticket->get_textant11_janein_id(TRUE).",            						
            ".$ticket->get_textant21_janein_id(TRUE).",    
            ".$ticket->get_textant31_janein_id(TRUE).",            						
            ".$ticket->get_textant41_janein_id(TRUE).", 			
            ".$ticket->get_textant51_janein_id(TRUE).", 			
            ".$ticket->get_textant12_nummern_id(TRUE).",            						
            ".$ticket->get_textant22_nummern_id(TRUE).",    
            ".$ticket->get_textant32_nummern_id(TRUE).",            						
            ".$ticket->get_textant42_nummern_id(TRUE).",  			
            ".$ticket->get_textant52_nummern_id(TRUE).",  			
            ".$ticket->get_kampagne_id(TRUE).",  			
            ".$ticket->get_dummy_text1(TRUE).",
            ".$ticket->get_dummy_text2(TRUE).",
            ".$ticket->get_dummy_text3(TRUE).",
            ".$ticket->get_dummy_text4(TRUE).",
            ".$ticket->get_dummy_text5(TRUE).",
            ".$ticket->get_dummy_text6(TRUE).",
            ".$ticket->get_dummy_text7(TRUE).",
            ".$ticket->get_dummy_text8(TRUE).",
            ".$ticket->get_dummy_text9(TRUE).",
            ".$ticket->get_dummy_text10(TRUE).",
            ".$ticket->get_dummy_text11(TRUE).",
            ".$ticket->get_dummy_text12(TRUE).",
            ".$ticket->get_dummy_text13(TRUE).",
            ".$ticket->get_dummy_text14(TRUE).",
            ".$ticket->get_dummy_text15(TRUE).",
            ".$ticket->get_dummy_text16(TRUE).",
            ".$ticket->get_dummy_text17(TRUE).",
            ".$ticket->get_dummy_text18(TRUE).",
            ".$ticket->get_dummy_text19(TRUE).",
            ".$ticket->get_dummy_text20(TRUE).",
            ".$ticket->get_dummy_number1(TRUE).",
            ".$ticket->get_dummy_number2(TRUE).",
            ".$ticket->get_dummy_number3(TRUE).",
            ".$ticket->get_dummy_number4(TRUE).",
            ".$ticket->get_dummy_number5(TRUE).",
            ".$ticket->get_dummy_number6(TRUE).",
            ".$ticket->get_dummy_number7(TRUE).",
            ".$ticket->get_dummy_number8(TRUE).",
            ".$ticket->get_dummy_number9(TRUE).",
            ".$ticket->get_dummy_number10(TRUE).",
            ".$ticket->get_dummy_date1(TRUE).",
            ".$ticket->get_dummy_date2(TRUE).",
            ".$ticket->get_dummy_date3(TRUE).",
            ".$ticket->get_dummy_date4(TRUE).",
            ".$ticket->get_dummy_date5(TRUE).",
            ".$ticket->get_dummy_date6(TRUE).",
            ".$ticket->get_dummy_date7(TRUE).",
            ".$ticket->get_dummy_date8(TRUE).",
            ".$ticket->get_dummy_date9(TRUE).",
            ".$ticket->get_dummy_date10(TRUE).",
            ".$ticket->get_dummy_id1(TRUE).",
            ".$ticket->get_dummy_id2(TRUE).",
            ".$ticket->get_dummy_id3(TRUE).",
            ".$ticket->get_dummy_id4(TRUE).",
            ".$ticket->get_dummy_id5(TRUE).",
			'".date("Y-m-d H:i:s")."',
			'".App::$CURRENT->USER->get_name()."',
				".$ticket->get_land_id(TRUE).")";
            $db->set_query($query);
            $db->execute();
            $id = $db->get_generated_id();
            if ($insert_akt == TRUE) {
                $query = "INSERT INTO `akt`(
            `mandant_id`, 
            `ticket_id`, 
            `geaendert_am`, 
            `geaendert_von`) 
            VALUES (
            ".$ticket->get_mandant_id(TRUE).",
            ".$id.",
			'".date("Y-m-d H:i:s")."',
			'".App::$CURRENT->USER->get_name()."')";
                $db->set_query($query);
                $db->execute();
                $akt_id = $db->get_generated_id();

            }
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

    public static

    function delete($ticket_id) {
        try {
            $db = new DBConnection();
            $db->set_auto_commit();
            $query = "UPDATE `ticket` SET 
               `geaendert_von`='".App::$CURRENT->USER->get_name()."'
                WHERE id = ".$ticket_id;

            $db->set_query($query);
            $db->execute();

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

    public static

    function get_next_ticket_nr($kampid) {

        $query = "select ifnull(max(ticketnr),0)+1 as next_ticket_nr from ticket t
        WHERE t.mandant_id = ".App::$CURRENT->MANDANT->get_id()." AND t.kampagne_id=".$kampid;

        $erg = App::$CURRENT->DB->singleObjectQuery($query);
        if (isset($erg)) {
            return $erg->next_ticket_nr;
        }
        return "0";
    }

    function get_next_ticket_nr_mandant() {

        $query = "select ifnull(max(ticketnr),0)+1 as next_ticket_nr from ticket t
        WHERE t.mandant_id = ".App::$CURRENT->MANDANT->get_id();

        $erg = App::$CURRENT->DB->singleObjectQuery($query);
        if (isset($erg)) {
            return $erg->next_ticket_nr;
        }
        return "0";
    }

    public static function add_anruf($ticket_id, $automatik, $log = "") {
		
        try {
			
            $db = new DBConnection();
            $db->set_auto_commit();
	
			$query = "select setAnrufTicket(".$ticket_id.", TRUE) from dual;";
            $db->set_query($query);
            $db->execute(); 
            $db->close();
			return true;
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