<?php 

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**

 * Description of customer
 *
 * @author AR
 */
class Akt {
    private $item;

    public function get_raw_item() {
        return $this->item;
    }

    public function isFormatEscape($dtype) {
        return ($dtype == "varchar" | $dtype == "char");
    }

    public function isFormatDate($dtype) {
        return ($dtype == "date" | $dtype == "datetime");
    }
    public function isFormatInt($dtype) {
        return ($dtype == "int" | $dtype == "bigint" | $dtype == "mediumint" | $dtype == "smallint" | $dtype == "mediumint");
    }
    public function isFormatDecimal($dtype) {
        return ($dtype == "decimal" | $dtype == "double" | $dtype == "float");
    }

    public function get_value($key, $sql_valid = FALSE, $dtype = "varchar") {
        if (!isset($this->item[$key])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid && $this->isFormatEscape($dtype)) {
            return "'".App::$CURRENT->DB->escape_string($this->item[$key])."'";
        }

        if ($this->isFormatDate($dtype)) {
            if ($sql_valid){
            return "'".App::$CURRENT->DB->escape_string($this->item[$key])."'";
        }
            $date = date_create($this->item[$key]);
            return date_format($date, "d.m.Y");
        }
        elseif($this->isFormatDecimal($dtype)) {
			$val=$this->item[$key];

			if ($sql_valid) {
				$val = str_replace(".", "", $val);
			}
			$val = str_replace(",", ".", $val);
			$val = (float)$val;
			
            if ($sql_valid) {
				return $val;
              //  return number_format((float) $this->item[$key], 2, ".", "");
            }
            return number_format((float) $this->item[$key], 2, ",", ".");
        } else {
            return $this->item[$key];
        }
    }

    public function set_value($key, $val, $sql_valid = FALSE, $dtype = "varchar") {

        if ($this->isFormatDecimal($dtype)) {
            if ($sql_valid) {
                $val = str_replace(".", "", $val);
	            $val = str_replace(",", ".", $val);
            }
            $this->item[$key] = $val;

        }
        elseif($this->isFormatDate($dtype)) {
            if (strlen((string) $val) == 0 || strlen((string) $val) == 0) {
                $this->item[$key] = NULL;
                return;
            }
            $date = date_create($val);
            $this->item[$key] = date_format($date, "Y-m-d H:i:s");
        } else {
            $this->item[$key] = $val;
        }
    }

    public function get_id() {
        if (!isset($this->item["id"])) {
            return NULL;
        }
        return $this->item["id"];
    }

    public function get_mandant_id($sql_valid = FALSE) {
        return $this->get_value("mandant_id", $sql_valid, "int");
    }

    public function get_ticket_id($sql_valid = FALSE) {
        return $this->get_value("ticket_id", $sql_valid);
    }

    public function get_herkunft($sql_valid = FALSE) {
        return $this->get_value("herkunft", $sql_valid, "char");
    }
    public function get_kunde_id($sql_valid = FALSE) {
        return $this->get_value("kunde_id", $sql_valid, "int");
    }
    public function get_kunde_kdnr($sql_valid = FALSE) {
        return $this->get_value("kunde_kdnr", $sql_valid, "varchar");
    }
    public function get_kunde_anrede_id($sql_valid = FALSE) {
        return $this->get_value("kunde_anrede_id", $sql_valid, "int");
    }
    public function get_kunde_anrede_text($sql_valid = FALSE) {
        return $this->get_value("kunde_anrede_text", $sql_valid, "varchar");
    }
    public function get_kunde_titel_id($sql_valid = FALSE) {
        return $this->get_value("kunde_titel_id", $sql_valid, "int");
    }
    public function get_kunde_titel_text($sql_valid = FALSE) {
        return $this->get_value("kunde_titel_text", $sql_valid, "varchar");
    }
    public function get_kunde_nachname($sql_valid = FALSE) {
        return $this->get_value("kunde_nachname", $sql_valid, "varchar");
    }
    public function get_kunde_vorname($sql_valid = FALSE) {
        return $this->get_value("kunde_vorname", $sql_valid, "varchar");
    }
    public function get_kunde_land($sql_valid = FALSE) {
        return $this->get_value("kunde_land", $sql_valid, "varchar");
    }
    public function get_kunde_plz($sql_valid = FALSE) {
        return $this->get_value("kunde_plz", $sql_valid, "varchar");
    }
    public function get_kunde_ort($sql_valid = FALSE) {
        return $this->get_value("kunde_ort", $sql_valid, "varchar");
    }
    public function get_kunde_strasse($sql_valid = FALSE) {
        return $this->get_value("kunde_strasse", $sql_valid, "varchar");
    }
    public function get_kunde_hausnummer($sql_valid = FALSE) {
        return $this->get_value("kunde_hausnummer", $sql_valid, "int");
    }
    public function get_kunde_hausnummer_erw($sql_valid = FALSE) {
        return $this->get_value("kunde_hausnummer_erw", $sql_valid, "varchar");
    }
    public function get_kunde_telefon($sql_valid = FALSE) {
        return $this->get_value("kunde_telefon", $sql_valid, "varchar");
    }
    public function get_kunde_email($sql_valid = FALSE) {
        return $this->get_value("kunde_email", $sql_valid, "varchar");
    }
    public function get_kunde_geburtsdatum($sql_valid = FALSE) {
        return $this->get_value("kunde_geburtsdatum", $sql_valid, "date");
    }
    public function get_kunde_kenner($sql_valid = FALSE) {
        return $this->get_value("kunde_kenner", $sql_valid, "varchar");
    }
    public function get_kunde_titel($sql_valid = FALSE) {
        return $this->get_value("kunde_titel", $sql_valid, "varchar");
    }
    public function get_kunde_markt($sql_valid = FALSE) {
        return $this->get_value("kunde_markt", $sql_valid, "int");
    }
    public function get_kunde_vorname2($sql_valid = FALSE) {
        return $this->get_value("kunde_vorname2", $sql_valid, "varchar");
    }
    public function get_kunde_geburtsdatum2($sql_valid = FALSE) {
        return $this->get_value("kunde_geburtsdatum2", $sql_valid, "date");
    }
    public function get_kunde_ortsteil($sql_valid = FALSE) {
        return $this->get_value("kunde_ortsteil", $sql_valid, "varchar");
    }
    public function get_kunde_hausnr_zusatz($sql_valid = FALSE) {
        return $this->get_value("kunde_hausnr_zusatz", $sql_valid, "varchar");
    }
    public function get_kunde_adresszusatz($sql_valid = FALSE) {
        return $this->get_value("kunde_adresszusatz", $sql_valid, "varchar");
    }
    public function get_kunde_primaerkdnr($sql_valid = FALSE) {
        return $this->get_value("kunde_primaerkdnr", $sql_valid, "varchar");
    }
    public function get_kunde_kundenart($sql_valid = FALSE) {
        return $this->get_value("kunde_kundenart", $sql_valid, "varchar");
    }
    public function get_kunde_kundenartbeschreibung($sql_valid = FALSE) {
        return $this->get_value("kunde_kundenartbeschreibung", $sql_valid, "varchar");
    }
    public function get_kunde_kz_betreut($sql_valid = FALSE) {
        return $this->get_value("kunde_kz_betreut", $sql_valid, "varchar");
    }
    public function get_kunde_anlagedatum($sql_valid = FALSE) {
        return $this->get_value("kunde_anlagedatum", $sql_valid, "date");
    }
    public function get_kunde_anrede2_id($sql_valid = FALSE) {
        return $this->get_value("kunde_anrede2_id", $sql_valid, "int");
    }
    public function get_kunde_geschlecht1($sql_valid = FALSE) {
        return $this->get_value("kunde_geschlecht1", $sql_valid, "varchar");
    }
    public function get_kunde_geschlecht2($sql_valid = FALSE) {
        return $this->get_value("kunde_geschlecht2", $sql_valid, "varchar");
    }
    public function get_kunde_titel2($sql_valid = FALSE) {
        return $this->get_value("kunde_titel2", $sql_valid, "varchar");
    }
    public function get_kunde_nachname2($sql_valid = FALSE) {
        return $this->get_value("kunde_nachname2", $sql_valid, "varchar");
    }
    public function get_stammdaten_id($sql_valid = FALSE) {
        return $this->get_value("stammdaten_id", $sql_valid, "int");
    }
    public function get_stammdaten_ktonr($sql_valid = FALSE) {
        return $this->get_value("stammdaten_ktonr", $sql_valid, "varchar");
    }
    public function get_stammdaten_datum_anlage($sql_valid = FALSE) {
        return $this->get_value("stammdaten_datum_anlage", $sql_valid, "date");
    }
    public function get_stammdaten_stichtag($sql_valid = FALSE) {
        return $this->get_value("stammdaten_stichtag", $sql_valid, "date");
    }
    public function get_stammdaten_zahltag($sql_valid = FALSE) {
        return $this->get_value("stammdaten_zahltag", $sql_valid, "date");
    }
    public function get_stammdaten_mahnsperre($sql_valid = FALSE) {
        return $this->get_value("stammdaten_mahnsperre", $sql_valid, "char");
    }
    public function get_stammdaten_mahnsperre_datum($sql_valid = FALSE) {
        return $this->get_value("stammdaten_mahnsperre_datum", $sql_valid, "date");
    }
    public function get_stammdaten_geaendert_am($sql_valid = FALSE) {
        return $this->get_value("stammdaten_geaendert_am", $sql_valid, "datetime");
    }
    public function get_stammdaten_geaendert_von($sql_valid = FALSE) {
        return $this->get_value("stammdaten_geaendert_von", $sql_valid, "varchar");
    }
    public function get_stammdaten_kto_kenner($sql_valid = FALSE) {
        return $this->get_value("stammdaten_kto_kenner", $sql_valid, "varchar");
    }
    public function get_stammdaten_mahnstufe($sql_valid = FALSE) {
        return $this->get_value("stammdaten_mahnstufe", $sql_valid, "int");
    }
    public function get_stammdaten_ratenanzahl($sql_valid = FALSE) {
        return $this->get_value("stammdaten_ratenanzahl", $sql_valid, "int");
    }
    public function get_stammdaten_ratenhoehe($sql_valid = FALSE) {
        return $this->get_value("stammdaten_ratenhoehe", $sql_valid, "decimal");
    }
    public function get_stammdaten_max_einzbetrag($sql_valid = FALSE) {
        return $this->get_value("stammdaten_max_einzbetrag", $sql_valid, "decimal");
    }
    public function get_stammdaten_dat_einzbetrag($sql_valid = FALSE) {
        return $this->get_value("stammdaten_dat_einzbetrag", $sql_valid, "date");
    }
    public function get_stammdaten_gesamtsaldo($sql_valid = FALSE) {
        return $this->get_value("stammdaten_gesamtsaldo", $sql_valid, "decimal");
    }
    public function get_stammdaten_gesamtsaldo_1x($sql_valid = FALSE) {
        return $this->get_value("stammdaten_gesamtsaldo_1x", $sql_valid, "decimal");
    }
    public function get_stammdaten_gesamtsaldo_rvc($sql_valid = FALSE) {
        return $this->get_value("stammdaten_gesamtsaldo_rvc", $sql_valid, "decimal");
    }
    public function get_stammdaten_inkassostatus_id($sql_valid = FALSE) {
        return $this->get_value("stammdaten_inkassostatus_id", $sql_valid, "int");
    }
    public function get_stammdaten_inkassostatus($sql_valid = FALSE) {
        return $this->get_value("stammdaten_inkassostatus", $sql_valid, "int");
    }
    public function get_stammdaten_inkassostatus_text($sql_valid = FALSE) {
        return $this->get_value("stammdaten_inkassostatus_text", $sql_valid, "varchar");
    }
    public function get_stammdaten_inkassostatus_bezeichnung($sql_valid = FALSE) {
        return $this->get_value("stammdaten_inkassostatus_bezeichnung", $sql_valid, "varchar");
    }
    public function get_stammdaten_ra_ikbuero_id($sql_valid = FALSE) {
        return $this->get_value("stammdaten_ra_ikbuero_id", $sql_valid, "int");
    }
    public function get_stammdaten_ra_ikbuero($sql_valid = FALSE) {
        return $this->get_value("stammdaten_ra_ikbuero", $sql_valid, "int");
    }

    public function get_stammdaten_ra_ikbuero_text($sql_valid = FALSE) {
        return $this->get_value("stammdaten_ra_ikbuero_text", $sql_valid, "varchar");
    }
    public function get_stammdaten_status_dat($sql_valid = FALSE) {
        return $this->get_value("stammdaten_status_dat", $sql_valid, "datetime");
    }
    public function get_stammdaten_dat_ltzt_buchung($sql_valid = FALSE) {
        return $this->get_value("stammdaten_dat_ltzt_buchung", $sql_valid, "date");
    }
    public function get_stammdaten_dat_l_mahnlauf($sql_valid = FALSE) {
        return $this->get_value("stammdaten_dat_l_mahnlauf", $sql_valid, "date");
    }
    public function get_stammdaten_dat_l_kontoauszug($sql_valid = FALSE) {
        return $this->get_value("stammdaten_dat_l_kontoauszug", $sql_valid, "date");
    }
    public function get_stammdaten_betrag_l_kontoauszug($sql_valid = FALSE) {
        return $this->get_value("stammdaten_betrag_l_kontoauszug", $sql_valid, "decimal");
    }
    public function get_stammdaten_dat_l_auslagerung($sql_valid = FALSE) {
        return $this->get_value("stammdaten_dat_l_auslagerung", $sql_valid, "date");
    }
    public function get_stammdaten_betrag_l_auslagerung($sql_valid = FALSE) {
        return $this->get_value("stammdaten_betrag_l_auslagerung", $sql_valid, "decimal");
    }
    public function get_stammdaten_dat_l_zahlung($sql_valid = FALSE) {
        return $this->get_value("stammdaten_dat_l_zahlung", $sql_valid, "date");
    }
    public function get_stammdaten_betrag_l_zahlung($sql_valid = FALSE) {
        return $this->get_value("stammdaten_betrag_l_zahlung", $sql_valid, "decimal");
    }
    public function get_stammdaten_dat_erster_kauf($sql_valid = FALSE) {
        return $this->get_value("stammdaten_dat_erster_kauf", $sql_valid, "date");
    }
    public function get_stammdaten_dat_l_retoure($sql_valid = FALSE) {
        return $this->get_value("stammdaten_dat_l_retoure", $sql_valid, "date");
    }
    public function get_stammdaten_betrag_l_retoure($sql_valid = FALSE) {
        return $this->get_value("stammdaten_betrag_l_retoure", $sql_valid, "decimal");
    }
    public function get_stammdaten_mahnstat_mst1_2013($sql_valid = FALSE) {
        return $this->get_value("stammdaten_mahnstat_mst1_2013", $sql_valid, "int");
    }
    public function get_stammdaten_mahnstat_mst2_2013($sql_valid = FALSE) {
        return $this->get_value("stammdaten_mahnstat_mst2_2013", $sql_valid, "int");
    }
    public function get_stammdaten_mahnstat_mst3_2013($sql_valid = FALSE) {
        return $this->get_value("stammdaten_mahnstat_mst3_2013", $sql_valid, "int");
    }
    public function get_stammdaten_mahnstat_mst4_2013($sql_valid = FALSE) {
        return $this->get_value("stammdaten_mahnstat_mst4_2013", $sql_valid, "int");
    }
    public function get_stammdaten_offene_raten($sql_valid = FALSE) {
        return $this->get_value("stammdaten_offene_raten", $sql_valid, "int");
    }
    public function get_stammdaten_krsv($sql_valid = FALSE) {
        return $this->get_value("stammdaten_krsv", $sql_valid, "int");
    }
    public function get_stammdaten_lastschrift($sql_valid = FALSE) {
        return $this->get_value("stammdaten_lastschrift", $sql_valid, "char");
    }
    public function get_stammdaten_letzter_stichtag($sql_valid = FALSE) {
        return $this->get_value("stammdaten_letzter_stichtag", $sql_valid, "date");
    }
    public function get_stammdaten_letzter_zahltag($sql_valid = FALSE) {
        return $this->get_value("stammdaten_letzter_zahltag", $sql_valid, "date");
    }
    public function get_stammdaten_dat_ende_sonderzins($sql_valid = FALSE) {
        return $this->get_value("stammdaten_dat_ende_sonderzins", $sql_valid, "date");
    }
    public function get_stammdaten_stichtagtagdesmonats($sql_valid = FALSE) {
        return $this->get_value("stammdaten_stichtagtagdesmonats", $sql_valid, "int");
    }
    public function get_inkasso_id($sql_valid = FALSE) {
        return $this->get_value("inkasso_id", $sql_valid, "int");
    }
    public function get_inkasso_kundennummer($sql_valid = FALSE) {
        return $this->get_value("inkasso_kundennummer", $sql_valid, "varchar");
    }
    public function get_inkasso_inkassostatus_text($sql_valid = FALSE) {
        return $this->get_value("inkasso_inkassostatus_text", $sql_valid, "varchar");
    }
    public function get_inkasso_inkassostatus($sql_valid = FALSE) {
        return $this->get_value("inkasso_inkassostatus", $sql_valid, "int");
    }
    public function get_inkasso_inkassostatus_bezeichnung($sql_valid = FALSE) {
        return $this->get_value("inkasso_inkassostatus_bezeichnung", $sql_valid, "varchar");
    }
    public function get_inkasso_status_dat($sql_valid = FALSE) {
        return $this->get_value("inkasso_status_dat", $sql_valid, "datetime");
    }
    public function get_inkasso_ra_ikbuero_id($sql_valid = FALSE) {
        return $this->get_value("inkasso_ra_ikbuero_id", $sql_valid, "int");
    }
    public function get_inkasso_ra_ikbuero($sql_valid = FALSE) {
        return $this->get_value("inkasso_ra_ikbuero", $sql_valid, "int");
    }

    public function get_inkasso_ra_ikbuero_text($sql_valid = FALSE) {
        return $this->get_value("inkasso_ra_ikbuero_text", $sql_valid, "varchar");
    }
    public function get_inkasso_anz_uebergab($sql_valid = FALSE) {
        return $this->get_value("inkasso_anz_uebergab", $sql_valid, "int");
    }
    public function get_inkasso_letzte_aenderung($sql_valid = FALSE) {
        return $this->get_value("inkasso_letzte_aenderung", $sql_valid, "datetime");
    }
    public function get_inkasso_uebergabe_betrag($sql_valid = FALSE) {
        return $this->get_value("inkasso_uebergabe_betrag", $sql_valid, "decimal");
    }
    public function get_inkasso_uneinbringlich($sql_valid = FALSE) {
        return $this->get_value("inkasso_uneinbringlich", $sql_valid, "decimal");
    }
    public function get_inkasso_uebergabe_dat($sql_valid = FALSE) {
        return $this->get_value("inkasso_uebergabe_dat", $sql_valid, "date");
    }
    public function get_inkasso_uebetr_du($sql_valid = FALSE) {
        return $this->get_value("inkasso_uebetr_du", $sql_valid, "decimal");
    }
    public function get_inkasso_dubiosenink($sql_valid = FALSE) {
        return $this->get_value("inkasso_dubiosenink", $sql_valid, "int");
    }
    public function get_inkasso_erl_du_dat($sql_valid = FALSE) {
        return $this->get_value("inkasso_erl_du_dat", $sql_valid, "date");
    }
    public function get_inkasso_erled_qual_id($sql_valid = FALSE) {
        return $this->get_value("inkasso_erled_qual_id", $sql_valid, "int");
    }
    public function get_inkasso_erled_qual($sql_valid = FALSE) {
        return $this->get_value("inkasso_erled_qual", $sql_valid, "char");
    }
    public function get_inkasso_erled_qual_text($sql_valid = FALSE) {
        return $this->get_value("inkasso_erled_qual_text", $sql_valid, "varchar");
    }

    public function get_inkasso_erl_dat($sql_valid = FALSE) {
        return $this->get_value("inkasso_erl_dat", $sql_valid, "date");
    }
    public function get_inkasso_ausbuchungsgrund_id($sql_valid = FALSE) {
        return $this->get_value("inkasso_ausbuchungsgrund_id", $sql_valid, "int");
    }
    public function get_inkasso_ausbuchungsgrund($sql_valid = FALSE) {
        return $this->get_value("inkasso_ausbuchungsgrund", $sql_valid, "int");
    }

    public function get_inkasso_ausbuchungsgrund_text($sql_valid = FALSE) {
        return $this->get_value("inkasso_ausbuchungsgrund_text", $sql_valid, "varchar");
    }
    public function get_inkasso_geaendert_am($sql_valid = FALSE) {
        return $this->get_value("inkasso_geaendert_am", $sql_valid, "datetime");
    }
    public function get_inkasso_geaendert_von($sql_valid = FALSE) {
        return $this->get_value("inkasso_geaendert_von", $sql_valid, "varchar");
    }
    public function get_inkasso_verwendungszweck($sql_valid = FALSE) {
        return $this->get_value("inkasso_verwendungszweck", $sql_valid, "varchar");
    }

    // Tatsächliche Felder für den akt
    public function get_akt_titel_gericht($sql_valid = FALSE) {
        return $this->get_value("akt_titel_gericht", $sql_valid, "varchar");
    }

    public function get_akt_titel_datum($sql_valid = FALSE) {
        return $this->get_value("akt_titel_datum", $sql_valid, "date");
    }

    public function get_akt_titel_geschaeftszahl($sql_valid = FALSE) {
        return $this->get_value("akt_titel_geschaeftszahl", $sql_valid, "varchar");
    }
    public function get_akt_letztes_exekutionsgericht($sql_valid = FALSE) {
        return $this->get_value("akt_letztes_exekutionsgericht", $sql_valid, "varchar");
    }

    public function get_akt_exekution_geschaeftszahl($sql_valid = FALSE) {
        return $this->get_value("akt_exekution_geschaeftszahl", $sql_valid, "varchar");
    }
    public function get_akt_forderungsgrund01($sql_valid = FALSE) {
        return $this->get_value("akt_forderungsgrund01", $sql_valid, "varchar");
    }
    public function get_akt_forderungsbetrag($sql_valid = FALSE) {
        return $this->get_value("akt_forderungsbetrag", $sql_valid, "decimal");
    }

    public function get_akt_waehrung($sql_valid = FALSE) {
        return $this->get_value("akt_waehrung", $sql_valid, "varchar");
    }

    public function get_akt_hinweise($sql_valid = FALSE) {
        return $this->get_value("akt_hinweise", $sql_valid, "varchar");
    }
    public function get_akt_anzahl_dokumente($sql_valid = FALSE) {
        return $this->get_value("akt_anzahl_dokumente", $sql_valid, "int");
    }
	// 2016-05-04 FranZ
    public function get_akt_restl_hauptforderung($sql_valid = FALSE) {
        return $this->get_value("akt_restl_hauptforderung", $sql_valid, "decimal");
    }
	public function get_akt_zinssatz_kapital($sql_valid = FALSE) {
        return $this->get_value("akt_zinssatz_kapital", $sql_valid, "decimal");
    }
    public function get_akt_restl_nebenforderung($sql_valid = FALSE) {
        return $this->get_value("akt_restl_nebenforderung", $sql_valid, "decimal");
    }
    public function get_akt_kap_zinsen_bis_stichtag($sql_valid = FALSE) {
        return $this->get_value("akt_kap_zinsen_bis_stichtag", $sql_valid, "decimal");
    }
    public function get_akt_rest_ra_honorar($sql_valid = FALSE) {
        return $this->get_value("akt_rest_ra_honorar", $sql_valid, "decimal");
    }
    public function get_akt_restl_barauslagen($sql_valid = FALSE) {
        return $this->get_value("akt_restl_barauslagen", $sql_valid, "decimal");
    }
    public function get_akt_abrechnungsstichtag($sql_valid = FALSE) {
        return $this->get_value("akt_abrechnungsstichtag", $sql_valid, "date");
    }
	// 2016-06-02 FranZ
    public function get_akt_kosten_titel($sql_valid = FALSE) {
        return $this->get_value("akt_kosten_titel", $sql_valid, "decimal");
    }
    public function get_akt_kosten_exe($sql_valid = FALSE) {
        return $this->get_value("akt_kosten_exe", $sql_valid, "decimal");
    }
    public function get_akt_kosten_geb($sql_valid = FALSE) {
        return $this->get_value("akt_kosten_geb", $sql_valid, "decimal");
    }	
    public function get_akt_kosten_sonst($sql_valid = FALSE) {
        return $this->get_value("akt_kosten_sonst", $sql_valid, "decimal");
    }	
	public function get_akt_su_anrede($sql_valid = FALSE) {
        return $this->get_value("akt_su_anrede", $sql_valid, "varchar");
    }
	public function get_akt_su_nachname($sql_valid = FALSE) {
			return $this->get_value("akt_su_nachname", $sql_valid, "varchar");
		}
	public function get_akt_su_vorname($sql_valid = FALSE) {
        return $this->get_value("akt_su_vorname", $sql_valid, "varchar");
    }
    public function get_akt_su_gebdatum($sql_valid = FALSE) {
        return $this->get_value("akt_su_gebdatum", $sql_valid, "date");
    }
    public function get_akt_zinsstartdatum($sql_valid = FALSE) {
        return $this->get_value("akt_zinsstartdatum", $sql_valid, "date");
    }
	public function get_akt_su_firmenbuchnummer($sql_valid = FALSE) {
        return $this->get_value("akt_su_firmenbuchnummer", $sql_valid, "varchar");
    }
	public function get_akt_su_strhnr($sql_valid = FALSE) {
        return $this->get_value("akt_su_strhnr", $sql_valid, "varchar");
    }
	public function get_akt_su_plz($sql_valid = FALSE) {
        return $this->get_value("akt_su_plz", $sql_valid, "varchar");
    }
	public function get_akt_su_ort($sql_valid = FALSE) {
        return $this->get_value("akt_su_ort", $sql_valid, "varchar");
    }
    public function get_akt_forderungsgrund12($sql_valid = FALSE) {
        return $this->get_value("akt_forderungsgrund12", $sql_valid, "varchar");
    }	
	// 2016-07-07 FranZ
    public function get_akt_kap_zinsen_bis_stichtag1($sql_valid = FALSE) {
        return $this->get_value("akt_kap_zinsen_bis_stichtag1", $sql_valid, "decimal");
    }
	public function get_akt_kap_zinsen_bis_stichtag2($sql_valid = FALSE) {
        return $this->get_value("akt_kap_zinsen_bis_stichtag2", $sql_valid, "decimal");
    }
	

    // SETTER
    public function set_id($val, $sql_valid = FALSE) {
        return $this->set_value("id", $val, $sql_valid, "int");
    }
    public function set_mandant_id($val, $sql_valid = FALSE) {
        return $this->set_value("mandant_id", $val, $sql_valid, "int");
    }
    public function set_ticket_id($val, $sql_valid = FALSE) {
        return $this->set_value("ticket_id", $val, $sql_valid, "int");
    }
    public function set_herkunft($val, $sql_valid = FALSE) {
        return $this->set_value("herkunft", $val, $sql_valid, "char");
    }
    public function set_kunde_id($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_id", $val, $sql_valid, "int");
    }
    public function set_kunde_kdnr($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_kdnr", $val, $sql_valid, "varchar");
    }
    public function set_kunde_anrede_id($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_anrede_id", $val, $sql_valid, "int");
    }
    public function set_kunde_anrede_text($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_anrede_text", $val, $sql_valid, "varchar");
    }
    public function set_kunde_titel_id($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_titel_id", $val, $sql_valid, "int");
    }
    public function set_kunde_titel_text($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_titel_text", $val, $sql_valid, "varchar");
    }
    public function set_kunde_nachname($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_nachname", $val, $sql_valid, "varchar");
    }
    public function set_kunde_vorname($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_vorname", $val, $sql_valid, "varchar");
    }
    public function set_kunde_land($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_land", $val, $sql_valid, "varchar");
    }
    public function set_kunde_plz($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_plz", $val, $sql_valid, "varchar");
    }
    public function set_kunde_ort($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_ort", $val, $sql_valid, "varchar");
    }
    public function set_kunde_strasse($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_strasse", $val, $sql_valid, "varchar");
    }
    public function set_kunde_hausnummer($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_hausnummer", $val, $sql_valid, "int");
    }
    public function set_kunde_hausnummer_erw($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_hausnummer_erw", $val, $sql_valid, "varchar");
    }
    public function set_kunde_telefon($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_telefon", $val, $sql_valid, "varchar");
    }
    public function set_kunde_email($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_email", $val, $sql_valid, "varchar");
    }
    public function set_kunde_geburtsdatum($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_geburtsdatum", $val, $sql_valid, "date");
    }
    public function set_kunde_kenner($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_kenner", $val, $sql_valid, "varchar");
    }
    public function set_kunde_titel($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_titel", $val, $sql_valid, "varchar");
    }
    public function set_kunde_markt($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_markt", $val, $sql_valid, "int");
    }
    public function set_kunde_vorname2($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_vorname2", $val, $sql_valid, "varchar");
    }
    public function set_kunde_geburtsdatum2($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_geburtsdatum2", $val, $sql_valid, "date");
    }
    public function set_kunde_ortsteil($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_ortsteil", $val, $sql_valid, "varchar");
    }
    public function set_kunde_hausnr_zusatz($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_hausnr_zusatz", $val, $sql_valid, "varchar");
    }
    public function set_kunde_adresszusatz($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_adresszusatz", $val, $sql_valid, "varchar");
    }
    public function set_kunde_primaerkdnr($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_primaerkdnr", $val, $sql_valid, "varchar");
    }
    public function set_kunde_kundenart($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_kundenart", $val, $sql_valid, "varchar");
    }
    public function set_kunde_kundenartbeschreibung($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_kundenartbeschreibung", $val, $sql_valid, "varchar");
    }
    public function set_kunde_kz_betreut($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_kz_betreut", $val, $sql_valid, "varchar");
    }
    public function set_kunde_anlagedatum($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_anlagedatum", $val, $sql_valid, "date");
    }
    public function set_kunde_anrede2_id($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_anrede2_id", $val, $sql_valid, "int");
    }
    public function set_kunde_geschlecht1($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_geschlecht1", $val, $sql_valid, "varchar");
    }
    public function set_kunde_geschlecht2($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_geschlecht2", $val, $sql_valid, "varchar");
    }
    public function set_kunde_titel2($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_titel2", $val, $sql_valid, "varchar");
    }
    public function set_kunde_nachname2($val, $sql_valid = FALSE) {
        return $this->set_value("kunde_nachname2", $val, $sql_valid, "varchar");
    }
    public function set_stammdaten_id($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_id", $val, $sql_valid, "int");
    }
    public function set_stammdaten_ktonr($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_ktonr", $val, $sql_valid, "varchar");
    }
    public function set_stammdaten_datum_anlage($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_datum_anlage", $val, $sql_valid, "date");
    }
    public function set_stammdaten_stichtag($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_stichtag", $val, $sql_valid, "date");
    }
    public function set_stammdaten_zahltag($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_zahltag", $val, $sql_valid, "date");
    }
    public function set_stammdaten_mahnsperre($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_mahnsperre", $val, $sql_valid, "char");
    }
    public function set_stammdaten_mahnsperre_datum($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_mahnsperre_datum", $val, $sql_valid, "date");
    }
    public function set_stammdaten_geaendert_am($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_geaendert_am", $val, $sql_valid, "datetime");
    }
    public function set_stammdaten_geaendert_von($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_geaendert_von", $val, $sql_valid, "varchar");
    }
    public function set_stammdaten_kto_kenner($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_kto_kenner", $val, $sql_valid, "varchar");
    }
    public function set_stammdaten_mahnstufe($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_mahnstufe", $val, $sql_valid, "int");
    }
    public function set_stammdaten_ratenanzahl($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_ratenanzahl", $val, $sql_valid, "int");
    }
    public function set_stammdaten_ratenhoehe($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_ratenhoehe", $val, $sql_valid, "decimal");
    }
    public function set_stammdaten_max_einzbetrag($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_max_einzbetrag", $val, $sql_valid, "decimal");
    }
    public function set_stammdaten_dat_einzbetrag($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_dat_einzbetrag", $val, $sql_valid, "date");
    }
    public function set_stammdaten_gesamtsaldo($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_gesamtsaldo", $val, $sql_valid, "decimal");
    }
    public function set_stammdaten_gesamtsaldo_1x($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_gesamtsaldo_1x", $val, $sql_valid, "decimal");
    }
    public function set_stammdaten_gesamtsaldo_rvc($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_gesamtsaldo_rvc", $val, $sql_valid, "decimal");
    }
    public function set_stammdaten_inkassostatus_id($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_inkassostatus_id", $val, $sql_valid, "int");
    }
    public function set_stammdaten_inkassostatus($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_inkassostatus", $val, $sql_valid, "int");
    }
    public function set_stammdaten_inkassostatus_text($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_inkassostatus_text", $val, $sql_valid, "varchar");
    }
    public function set_stammdaten_inkassostatus_bezeichnung($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_inkassostatus_bezeichnung", $val, $sql_valid, "varchar");
    }
    public function set_stammdaten_ra_ikbuero_id($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_ra_ikbuero_id", $val, $sql_valid, "int");
    }
    public function set_stammdaten_ra_ikbuero($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_ra_ikbuero", $val, $sql_valid, "int");
    }
    public function set_stammdaten_ra_ikbuero_text($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_ra_ikbuero_text", $val, $sql_valid, "varchar");
    }
    public function set_stammdaten_status_dat($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_status_dat", $val, $sql_valid, "datetime");
    }
    public function set_stammdaten_dat_ltzt_buchung($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_dat_ltzt_buchung", $val, $sql_valid, "date");
    }
    public function set_stammdaten_dat_l_mahnlauf($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_dat_l_mahnlauf", $val, $sql_valid, "date");
    }
    public function set_stammdaten_dat_l_kontoauszug($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_dat_l_kontoauszug", $val, $sql_valid, "date");
    }
    public function set_stammdaten_betrag_l_kontoauszug($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_betrag_l_kontoauszug", $val, $sql_valid, "decimal");
    }
    public function set_stammdaten_dat_l_auslagerung($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_dat_l_auslagerung", $val, $sql_valid, "date");
    }
    public function set_stammdaten_betrag_l_auslagerung($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_betrag_l_auslagerung", $val, $sql_valid, "decimal");
    }
    public function set_stammdaten_dat_l_zahlung($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_dat_l_zahlung", $val, $sql_valid, "date");
    }
    public function set_stammdaten_betrag_l_zahlung($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_betrag_l_zahlung", $val, $sql_valid, "decimal");
    }
    public function set_stammdaten_dat_erster_kauf($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_dat_erster_kauf", $val, $sql_valid, "date");
    }
    public function set_stammdaten_dat_l_retoure($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_dat_l_retoure", $val, $sql_valid, "date");
    }
    public function set_stammdaten_betrag_l_retoure($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_betrag_l_retoure", $val, $sql_valid, "decimal");
    }
    public function set_stammdaten_mahnstat_mst1_2013($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_mahnstat_mst1_2013", $val, $sql_valid, "int");
    }
    public function set_stammdaten_mahnstat_mst2_2013($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_mahnstat_mst2_2013", $val, $sql_valid, "int");
    }
    public function set_stammdaten_mahnstat_mst3_2013($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_mahnstat_mst3_2013", $val, $sql_valid, "int");
    }
    public function set_stammdaten_mahnstat_mst4_2013($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_mahnstat_mst4_2013", $val, $sql_valid, "int");
    }
    public function set_stammdaten_offene_raten($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_offene_raten", $val, $sql_valid, "int");
    }
    public function set_stammdaten_krsv($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_krsv", $val, $sql_valid, "int");
    }
    public function set_stammdaten_lastschrift($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_lastschrift", $val, $sql_valid, "char");
    }
    public function set_stammdaten_letzter_stichtag($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_letzter_stichtag", $val, $sql_valid, "date");
    }
    public function set_stammdaten_letzter_zahltag($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_letzter_zahltag", $val, $sql_valid, "date");
    }
    public function set_stammdaten_dat_ende_sonderzins($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_dat_ende_sonderzins", $val, $sql_valid, "date");
    }
    public function set_stammdaten_stichtagtagdesmonats($val, $sql_valid = FALSE) {
        return $this->set_value("stammdaten_stichtagtagdesmonats", $val, $sql_valid, "int");
    }
    public function set_inkasso_id($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_id", $val, $sql_valid, "int");
    }
    public function set_inkasso_kundennummer($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_kundennummer", $val, $sql_valid, "varchar");
    }
    public function set_inkasso_inkassostatus($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_inkassostatus", $val, $sql_valid, "int");
    }

    public function set_inkasso_inkassostatus_text($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_inkassostatus_text", $val, $sql_valid, "varchar");
    }
    public function set_inkasso_inkassostatus_bezeichnung($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_inkassostatus_bezeichnung", $val, $sql_valid, "varchar");
    }
    public function set_inkasso_status_dat($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_status_dat", $val, $sql_valid, "datetime");
    }
    public function set_inkasso_ra_ikbuero_id($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_ra_ikbuero_id", $val, $sql_valid, "int");
    }
    public function set_inkasso_ra_ikbuero($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_ra_ikbuero", $val, $sql_valid, "int");
    }
    public function set_inkasso_ra_ikbuero_text($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_ra_ikbuero_text", $val, $sql_valid, "varchar");
    }
    public function set_inkasso_anz_uebergab($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_anz_uebergab", $val, $sql_valid, "int");
    }
    public function set_inkasso_letzte_aenderung($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_letzte_aenderung", $val, $sql_valid, "datetime");
    }
    public function set_inkasso_uebergabe_betrag($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_uebergabe_betrag", $val, $sql_valid, "decimal");
    }
    public function set_inkasso_uneinbringlich($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_uneinbringlich", $val, $sql_valid, "decimal");
    }
    public function set_inkasso_uebergabe_dat($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_uebergabe_dat", $val, $sql_valid, "date");
    }
    public function set_inkasso_uebetr_du($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_uebetr_du", $val, $sql_valid, "decimal");
    }
    public function set_inkasso_dubiosenink($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_dubiosenink", $val, $sql_valid, "int");
    }
    public function set_inkasso_erl_du_dat($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_erl_du_dat", $val, $sql_valid, "date");
    }
    public function set_inkasso_erled_qual_id($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_erled_qual_id", $val, $sql_valid, "int");
    }
    public function set_inkasso_erled_qual($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_erled_qual", $val, $sql_valid, "char");
    }
    public function set_inkasso_erled_qual_text($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_erled_qual_text", $val, $sql_valid, "varchar");
    }

    public function set_inkasso_erl_dat($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_erl_dat", $val, $sql_valid, "date");
    }
    public function set_inkasso_ausbuchungsgrund_id($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_ausbuchungsgrund_id", $val, $sql_valid, "int");
    }
    public function set_inkasso_ausbuchungsgrund($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_ausbuchungsgrund", $val, $sql_valid, "int");
    }
    public function set_inkasso_ausbuchungsgrund_text($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_ausbuchungsgrund_text", $val, $sql_valid, "varchar");
    }
    public function set_inkasso_geaendert_am($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_geaendert_am", $val, $sql_valid, "datetime");
    }
    public function set_inkasso_geaendert_von($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_geaendert_von", $val, $sql_valid, "varchar");
    }
    public function set_inkasso_verwendungszweck($val, $sql_valid = FALSE) {
        return $this->set_value("inkasso_verwendungszweck", $val, $sql_valid, "varchar");
    }
    public function set_akt_titel_gericht($val, $sql_valid = FALSE) {
        return $this->set_value("akt_titel_gericht", $val, $sql_valid, "varchar");
    }
    public function set_akt_titel_datum($val, $sql_valid = FALSE) {
        return $this->set_value("akt_titel_datum", $val, $sql_valid, "date");
    }
    public function set_akt_titel_geschaeftszahl($val, $sql_valid = FALSE) {
        return $this->set_value("akt_titel_geschaeftszahl", $val, $sql_valid, "varchar");
    }
    public function set_akt_letztes_exekutionsgericht($val, $sql_valid = FALSE) {
        return $this->set_value("akt_letztes_exekutionsgericht", $val, $sql_valid, "varchar");
    }
    public function set_akt_exekution_geschaeftszahl($val, $sql_valid = FALSE) {
        return $this->set_value("akt_exekution_geschaeftszahl", $val, $sql_valid, "varchar");
    }
    public function set_akt_forderungsgrund01($val, $sql_valid = FALSE) {
        return $this->set_value("akt_forderungsgrund01", $val, $sql_valid, "varchar");
    }
    public function set_akt_forderungsbetrag($val, $sql_valid = FALSE) {
        return $this->set_value("akt_forderungsbetrag", $val, $sql_valid, "decimal");
    }
    public function set_akt_waehrung($val, $sql_valid = FALSE) {
        return $this->set_value("akt_waehrung", $val, $sql_valid, "varchar");
    }
    public function set_akt_hinweise($val, $sql_valid = FALSE) {
        return $this->set_value("akt_hinweise", $val, $sql_valid, "varchar");
    }
    public function set_akt_anzahl_dokumente($val, $sql_valid = FALSE) {
        return $this->set_value("akt_anzahl_dokumente", $val, $sql_valid, "int");
    }
    public function set_geaendert_am($val, $sql_valid = FALSE) {
        return $this->set_value("geaendert_am", $val, $sql_valid, "datetime");
    }
    public function set_geaendert_von($val, $sql_valid = FALSE) {
        return $this->set_value("geaendert_von", $val, $sql_valid, "varchar");
    }
	// 2016-05-04 FranZ
	public function set_akt_restl_hauptforderung($val, $sql_valid = FALSE) {
        return $this->set_value("akt_restl_hauptforderung", $val, $sql_valid, "decimal");
    }
	public function set_akt_zinssatz_kapital($val, $sql_valid = FALSE) {
        return $this->set_value("akt_zinssatz_kapital", $val, $sql_valid, "decimal");
    }
	public function set_akt_restl_nebenforderung($val, $sql_valid = FALSE) {
        return $this->set_value("akt_restl_nebenforderung", $val, $sql_valid, "decimal");
    }
	public function set_akt_kap_zinsen_bis_stichtag($val, $sql_valid = FALSE) {
        return $this->set_value("akt_kap_zinsen_bis_stichtag", $val, $sql_valid, "decimal");
    }
	public function set_akt_rest_ra_honorar($val, $sql_valid = FALSE) {
        return $this->set_value("akt_rest_ra_honorar", $val, $sql_valid, "decimal");
    }
	public function set_akt_restl_barauslagen($val, $sql_valid = FALSE) {
        return $this->set_value("akt_restl_barauslagen", $val, $sql_valid, "decimal");
    }
	public function set_akt_abrechnungsstichtag($val, $sql_valid = FALSE) {
        return $this->set_value("akt_abrechnungsstichtag", $val, $sql_valid, "date");
    }
	// 2016-06-02 FranZ
	public function set_akt_kosten_titel($val, $sql_valid = FALSE) {
        return $this->set_value("akt_kosten_titel", $val, $sql_valid, "decimal");
    }
	public function set_akt_kosten_exe($val, $sql_valid = FALSE) {
        return $this->set_value("akt_kosten_exe", $val, $sql_valid, "decimal");
    }
	public function set_akt_kosten_geb($val, $sql_valid = FALSE) {
        return $this->set_value("akt_kosten_geb", $val, $sql_valid, "decimal");
    }
	public function set_akt_kosten_sonst($val, $sql_valid = FALSE) {
        return $this->set_value("akt_kosten_sonst", $val, $sql_valid, "decimal");
    }
    public function set_akt_su_anrede($val, $sql_valid = FALSE) {
        return $this->set_value("akt_su_anrede", $val, $sql_valid, "varchar");
    }
	public function set_akt_su_nachname($val, $sql_valid = FALSE) {
        return $this->set_value("akt_su_nachname", $val, $sql_valid, "varchar");
    }
	public function set_akt_su_vorname($val, $sql_valid = FALSE) {
        return $this->set_value("akt_su_vorname", $val, $sql_valid, "varchar");
    }
	public function set_akt_su_gebdatum($val, $sql_valid = FALSE) {
        return $this->set_value("akt_su_gebdatum", $val, $sql_valid, "date");
    }
	public function set_akt_zinsstartdatum($val, $sql_valid = FALSE) {
        return $this->set_value("akt_zinsstartdatum", $val, $sql_valid, "date");
    }	
	public function set_akt_su_firmenbuchnummer($val, $sql_valid = FALSE) {
        return $this->set_value("akt_su_firmenbuchnummer", $val, $sql_valid, "varchar");
    }
	public function set_akt_su_strhnr($val, $sql_valid = FALSE) {
        return $this->set_value("akt_su_strhnr", $val, $sql_valid, "varchar");
    }
	public function set_akt_su_plz($val, $sql_valid = FALSE) {
        return $this->set_value("akt_su_plz", $val, $sql_valid, "varchar");
    }
	public function set_akt_su_ort($val, $sql_valid = FALSE) {
        return $this->set_value("akt_su_ort", $val, $sql_valid, "varchar");
    }
	public function set_akt_forderungsgrund12($val, $sql_valid = FALSE) {
        return $this->set_value("akt_forderungsgrund12", $val, $sql_valid, "varchar");
    }
	// 2016-07-07 FranZ
	public function set_akt_kap_zinsen_bis_stichtag1($val, $sql_valid = FALSE) {
        return $this->set_value("akt_kap_zinsen_bis_stichtag1", $val, $sql_valid, "decimal");
    }
	public function set_akt_kap_zinsen_bis_stichtag2($val, $sql_valid = FALSE) {
        return $this->set_value("akt_kap_zinsen_bis_stichtag2", $val, $sql_valid, "decimal");
    }
	

    // Allgemein
    public function __construct($item) {
        $this->item = array();

        $item = (array) $item;

        foreach($item as $key => $value) {
            $name = "set_".$key;

            if (method_exists($this, $name)) {
                $this->$name($value);
            }
        }
    }


    public static

    function search($start, $count, $filter) {
        $query = "SELECT a.* 
            FROM akt a
            WHERE a.mandant_id = ".App::$CURRENT->MANDANT->get_id();

        foreach($filter as $item) {
            $query .= " AND $item";
        }

        $query .= " ORDER BY ticket_id LIMIT $start, $count";

        try {
            $response = array();
            $result = App::$CURRENT->DB->query($query);

            foreach($result as $item) {
                array_push($response, new Akt($item, TRUE));
            }

            return $response;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static

    function get_by_ticket_id($ticket_id) {
        $query = "SELECT a.* FROM akt a WHERE a.ticket_id = ".$ticket_id;
        try {
            $response = App::$CURRENT->DB->singleObjectQuery($query);
            return new Akt($response);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static

    function get($id) {
        $query = "SELECT a.* FROM akt a WHERE a.id = $id";

        try {
            $response = App::$CURRENT->DB->singleObjectQuery($query);
            return new Akt($response, TRUE);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static

    function update($akt) {
        try {
            $db = new DBConnection();
			$restl_barauslagen = $akt->get_akt_kosten_titel(TRUE) + $akt->get_akt_kosten_exe(TRUE)+$akt->get_akt_kosten_geb(TRUE)+$akt->get_akt_kosten_sonst(TRUE);
			$akt_kap_zinsen_bis_stichtag_sum = $akt->get_akt_kap_zinsen_bis_stichtag1(TRUE) + $akt->get_akt_kap_zinsen_bis_stichtag2(TRUE);
            $query = "UPDATE `akt` SET 
            `akt_titel_gericht`=".$akt->get_akt_titel_gericht(TRUE).",
            `akt_titel_datum`=".$akt->get_akt_titel_datum(TRUE).",
            `akt_titel_geschaeftszahl`=".$akt->get_akt_titel_geschaeftszahl(TRUE).",
            `akt_letztes_exekutionsgericht`=".$akt->get_akt_letztes_exekutionsgericht(TRUE).",
            `akt_exekution_geschaeftszahl`=".$akt->get_akt_exekution_geschaeftszahl(TRUE).",
            `akt_forderungsgrund01`=".$akt->get_akt_forderungsgrund01(TRUE).",
            `akt_forderungsbetrag`=".$akt->get_akt_forderungsbetrag(TRUE).",
            `akt_waehrung`=".$akt->get_akt_waehrung(TRUE).",
            `akt_hinweise`=".$akt->get_akt_hinweise(TRUE).",
            `akt_anzahl_dokumente`=".$akt->get_akt_anzahl_dokumente(TRUE).",
			`akt_restl_hauptforderung`=".$akt->get_akt_restl_hauptforderung(TRUE).",
			`akt_zinssatz_kapital`=".$akt->get_akt_zinssatz_kapital(TRUE).",
			`akt_restl_nebenforderung`=".$akt->get_akt_restl_nebenforderung(TRUE).",
			`akt_kap_zinsen_bis_stichtag1`=".$akt->get_akt_kap_zinsen_bis_stichtag1(TRUE).",			
			`akt_kap_zinsen_bis_stichtag2`=".$akt->get_akt_kap_zinsen_bis_stichtag2(TRUE).",			
			`akt_kap_zinsen_bis_stichtag`=".$akt_kap_zinsen_bis_stichtag_sum.",						
			`akt_rest_ra_honorar`=".$akt->get_akt_rest_ra_honorar(TRUE).",
			`akt_restl_barauslagen`=".$restl_barauslagen.",			
			`akt_abrechnungsstichtag`=".$akt->get_akt_abrechnungsstichtag(TRUE).",			
			`akt_kosten_titel`=".$akt->get_akt_kosten_titel(TRUE).",	
			`akt_kosten_exe`=".$akt->get_akt_kosten_exe(TRUE).",	
			`akt_kosten_geb`=".$akt->get_akt_kosten_geb(TRUE).",	
			`akt_kosten_sonst`=".$akt->get_akt_kosten_sonst(TRUE).",
			`akt_su_anrede`=".$akt->get_akt_su_anrede(TRUE).",	
			`akt_su_nachname`=".$akt->get_akt_su_nachname(TRUE).",	
			`akt_su_vorname`=".$akt->get_akt_su_vorname(TRUE).",	
			`akt_su_gebdatum`=".$akt->get_akt_su_gebdatum(TRUE).",	
			`akt_zinsstartdatum`=".$akt->get_akt_zinsstartdatum(TRUE).",	
			`akt_su_firmenbuchnummer`=".$akt->get_akt_su_firmenbuchnummer(TRUE).",	
			`akt_su_strhnr`=".$akt->get_akt_su_strhnr(TRUE).",	
			`akt_su_plz`=".$akt->get_akt_su_plz(TRUE).",	
			`akt_su_ort`=".$akt->get_akt_su_ort(TRUE).",	
			`akt_forderungsgrund12`=".$akt->get_akt_forderungsgrund12(TRUE).",
			`akt_zinsstartdatum`=".$akt->get_akt_zinsstartdatum(TRUE).",	
            `geaendert_am`='".date("Y-m-d H:i:s")."',
            `geaendert_von`='".App::$CURRENT->USER->get_name()."'
                WHERE id = ".$akt->get_id();

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

    function insert($akt) {
        
        try {
            $db = new DBConnection();
            $query = "INSERT INTO `akt`(
            `mandant_id`, 
            `ticket_id`, 
            `geaendert_am`, 
            `geaendert_von`) 
            VALUES (
            ".$akt->get_mandant_id(TRUE).",
            ".$akt->get_ticket_id(TRUE).",
			'".date("Y-m-d H:i:s")."',
			'".App::$CURRENT->USER->get_name()."')";
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
}
