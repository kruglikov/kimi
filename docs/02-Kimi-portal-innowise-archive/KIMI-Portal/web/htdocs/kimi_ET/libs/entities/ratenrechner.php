<?php

/*
  function test () {
  echo "test";
  exit;
  }


  $rate = new Ratenrechner();
  $anzraten= $rate->get_ratenanzahl(1000, 1.55, 100);
  echo "Anzahl Raten: ".$anzraten;
  exit;

 */

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of anrede
 *
 * @author Aberl
 */
class Ratenrechner {

//    private $item;
//    public function __construct($item) {
//        $this->item = $item;
//    }

    public static function calc_ratenanzahl($kreditbetrag, $zinssatz, $ratenhoehe) {

        $kreditbetrag = str_replace(',', '.', $kreditbetrag);
        $ratenhoehe = str_replace(',', '.', $ratenhoehe);
        $zinssatz = str_replace(',', '.', $zinssatz);
        if ((float) $ratenhoehe == 0 || (float) $kreditbetrag == 0) {
            return 0;
        }

        if ((float) $zinssatz > 0) {
            //$query = "SELECT round( LOG(($zinssatz / $ratenhoehe) + 1, 10) / log(($ratenhoehe / ($ratenhoehe - (($zinssatz / $ratenhoehe) * $kreditbetrag))),10), 2) as 'Ratenanzahl' FROM dual";
            $query = "SELECT round( LOG(($zinssatz / 100) + 1, 10) / log(($ratenhoehe / ($ratenhoehe - (($zinssatz / 100) * $kreditbetrag))),10), 2) as 'Ratenanzahl' FROM dual";
        } else {
            $query = "SELECT  round( $kreditbetrag/$ratenhoehe, 2) as 'Ratenanzahl' FROM dual";
        }

        $result = array();
        //$response = App::$CURRENT->DB->query($query);
        $erg = App::$CURRENT->DB->singleObjectQuery($query);
        //print_r($erg);
        return $erg->Ratenanzahl;
    }

    public static function calc_ratenhoehe($kreditbetrag, $zinssatz, $ratenanzahl) {


        $kreditbetrag = str_replace(',', '.', $kreditbetrag);
        $ratenanzahl = str_replace(',', '.', $ratenanzahl);
        $zinssatz = str_replace(',', '.', $zinssatz);
        if ((float) $ratenanzahl == 0 || (float) $kreditbetrag == 0) {
            return 0;
        }

        if ((float) $zinssatz > 0) {
            $query = "SELECT round(($kreditbetrag * ($zinssatz / 100) * POWER((($zinssatz / 100) + 1), $ratenanzahl)) / (POWER((($zinssatz / 100) + 1), $ratenanzahl) - 1), 2) as 'Ratenhoehe' FROM dual";
        } else {
            $query = "SELECT  round( $kreditbetrag/$ratenanzahl, 2) as 'Ratenhoehe' FROM dual";
        }

        $result = array();
        $erg = App::$CURRENT->DB->singleObjectQuery($query);
        return $erg->Ratenhoehe;
    }

    public static function get_tilgungsplan($saldo, $ratenhoehe, $zinssatz, $ratenanzahl, &$sum_zinsen, &$sum_tilgung) {

        $offen = (float) $saldo;
        $ratenhoehe = (float) $ratenhoehe;
        $zinssatz = (float) $zinssatz;
        $zinsen = 0;
        $rate = 1;
        $vortrag = 0;
        $sum_zinsen = 0;
        $sum_tilgung = 0;
        $date = new DateTime(date("Y-m"));
        $interval = new DateInterval('P1M');

        while ($offen > 0) {
            $vortrag = $offen;
            $zinsen = $vortrag * $zinssatz / 100;
            $zinsen = round($zinsen, 2);
            $offen = $offen + $zinsen;

            if ($offen < $ratenhoehe) {
                // Restrate
                $tilgung = $offen;
            } else {
                // normale Rate
                $tilgung = $ratenhoehe;
            }
            $offen = $offen - $tilgung;
           
            if ($offen == 0) {
                $rate_text = TXT_LBL_TILG_RATE_REST;
            } else {
                $rate_text = ($rate) . ". " . TXT_LBL_TILG_RATE;
            }
            
            $sum_zinsen = $sum_zinsen + $zinsen;
            $sum_tilgung = $sum_tilgung + $tilgung;
            $tilgungsplan[] = array('rate' => $rate_text,
                'zahltag' => $date->format("M Y"),
                'saldovortrag' => number_format((float) $vortrag, 2, ",", "."),
                'zinsen' => number_format((float) $zinsen, 2, ",", "."),
                'tilgung' => number_format((float) $tilgung, 2, ",", "."),
                'saldoneu' => number_format((float) $offen, 2, ",", "."));
            $rate++;
            $date->add($interval);
        }
        if (isset($tilgungsplan) ) {
            $tilgungsplan[] = array('rate' => TXT_LBL_TILG_GESAMT,
                'zahltag' => "",
                'saldovortrag' => '',
                'zinsen' => number_format((float) $sum_zinsen, 2, ",", "."),
                'tilgung' => number_format((float) $sum_tilgung, 2, ",", "."),
                'saldoneu' => "");
            return $tilgungsplan;
        }
        return NULL;
    }

}
?>

