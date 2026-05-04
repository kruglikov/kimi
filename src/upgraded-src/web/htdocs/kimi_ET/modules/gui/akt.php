<script type="text/javascript">
<?php include_once "./modules/gui/akt_validate.js" ?>    
</script>

<h2><?php echo TXT_LBL_AKTE ?>
<?php
    $herkunft = $akt->get_herkunft();
    if ($herkunft=="") {
        $msg = " ".TXT_LBL_AKTE_NICHTZUGEORDNET;
    } else if ($herkunft=="A") {
        $msg = " ".TXT_LBL_AKTE_AUSARCHIV;
    } else {
        $msg = " ".TXT_LBL_AKTE_PRODUKTIV;
    }
    echo " ".$msg;
?></h2>
<?php //TXT_LBL_AKTE ?>
<form action="" method="get" onsubmit="return validateFormOnSave()">
    <?php if (isset($akt)) { ?>
        <input type="hidden" value="<?php echo $akt->get_kunde_kdnr(); ?>" name="kundennummer_backup" />
    <?php } ?>
    <table>
			 <!-- Kommentarzeile ein
	
        <tr>
            <td><?php echo TXT_LBL_KDNR ?></td>
            <td>
                <input disabled name="kundennummer" required placeholder="<?php echo TXT_LBL_KDNR ?>" name="kunde_kdnr" class="column" type="text" value="<?php echo $akt->get_kunde_kdnr() ?>" />
            </td>
            <td>
                <?php echo TXT_LBL_ANREDE ?>/<?php echo TXT_LBL_TITEL ?>
            </td>
            <td>
                <?php // <input type="submit" value="<?php echo TXT_LBL_SEARCH ?>
                <input disabled name="kunde_anrede"  type="text" value="<?php echo $akt->get_kunde_anrede_text() . " " . $akt->get_kunde_titel_text() ?>" /> 
            </td>
            <td>Kundenart</td>
            <td><input disabled name="kunde_kundenart" class="search" type="text" value="<?php echo $akt->get_kunde_kundenart() ?> <?php echo $akt->get_kunde_kundenartbeschreibung() ?>" /></td>
            <td><?php echo TXT_LBL_KENNER ?></td>
            <td><input disabled name="stammdaten_kto_kenner" class="search" type="text" value="<?php echo $akt->get_stammdaten_kto_kenner() ?>" /> </td>
        </tr>
        <?php if (isset($akt)) { ?>
            <tr disabled>
                <td><?php echo TXT_LBL_LASTNAME ?></td>
                <td>
                    <input disabled required class="column" type="text" value="<?php echo $akt->get_kunde_nachname() ?>" />
                </td>
                <td><?php echo TXT_LBL_FIRSTNAME ?></td>
                <td>
                    <input disabled required name="vorname" class="column" type="text" value="<?php echo $akt->get_kunde_vorname() ?>" />
                </td>
                <td><?php echo TXT_LBL_LASTNAME2 ?></td>
                <td><input disabled required name="nachname" class="column" type="text" value="<?php echo $akt->get_kunde_nachname2() ?>" /></td>
                <td><?php echo TXT_LBL_FIRSTNAME2 ?></td>
                <td><input disabled required name="vorname" class="column" type="text" value="<?php echo $akt->get_kunde_vorname2() ?>" /> </td>
            </tr>
            <tr disabled>
                <td><?php echo TXT_LBL_BIRTH ?></td>
                <td>
                    <input disabled class="search" type="date" value="<?php echo $akt->get_kunde_geburtsdatum() ?>" />
                </td>
                <td></td>
                <td></td>
                <td><?php echo TXT_LBL_BIRTH2 ?></td>
                <td> <input disabled class="search" type="date" value="<?php echo $akt->get_kunde_geburtsdatum2() ?>" /> </td>
                <td> </td>
                <td></td>
            </tr>
            <tr disabled>
                <td><?php echo TXT_LBL_STR ?></td>
                <td>
                    <input disabled required class="column" type="text" value="<?php echo $akt->get_kunde_strasse() ?>" />
                </td>

                <td><?php echo TXT_LBL_HNR ?></td>
                <td>
                    <table class="column padded">
                        <tr>
                            <td>
                                <input disabled size="10" name="hausnummer" type="text" value="<?php echo $akt->get_kunde_hausnummer() ?>" />
                            </td>
                            <td class="placeholder"></td>
                            <td>
                                <input disabled size="10" name="hausnummer_erw" type="text" value="<?php echo $akt->get_kunde_hausnummer_erw() ?>" />
                            </td>
                        </tr>
                    </table>
                </td>
                <td><?php echo TXT_LBL_PLZ ?></td>
                <td>
                    <input disabled size="10" name="plzort" type="text" value="<?php echo $akt->get_kunde_land() . " " . $akt->get_kunde_plz() ?>" />
                </td>
                <td><?php echo TXT_LBL_ORT ?></td>
                <td><input required disabled placeholder="<?php echo TXT_LBL_ORT ?>" name="ort" class="search" type="text" value="<?php echo $akt->get_kunde_ort() ?>" /></td>
            </tr>
            <tr disabled>
                <td><?php echo TXT_LBL_TEL ?></td>
                <td>
                    <input disabled name="telefon" class="search" type="text" value="<?php echo $akt->get_kunde_telefon() ?>" /> <br />
                </td>
                <td><?php echo TXT_LBL_EMAIL ?></td>
                <td>
                    <input disabled size="40" name="email" class="search" type="email" value="<?php echo $akt->get_kunde_email() ?>" /> <br />
                </td>
            </tr>
        <?php } ?>
    </table>
</form>

<?php if (isset($akt)) { ?>
    <hr>
    <form method="post" action="" <?php if (!App::$CURRENT->has_permission("akt", "UPD")) echo 'disabled'; ?>>
        <input type="hidden" name="id" value="<?php if (isset($akt)) echo $akt->get_id(); ?>" />
        <table>
            <tr>
                <td><?php echo TXT_LBL_ZAHLTAG ?></td>
                <td><input disabled <?php
                    if (isset($akt)) {
                        echo "value=\"" . $akt->get_stammdaten_zahltag() . "\"";
                    }
                    ?> type="date" placeholder="<?php echo TXT_LBL_ZAHLTAG ?>" name="zahltag" required /></td>
                <td><label for="mahnsperre"><?php echo TXT_LBL_MAHNSPERRE ?></label></td>
                <td><input disabled <?php
                    if (isset($akt) && $akt->get_stammdaten_mahnsperre() == "MS") {
                        echo "checked";
                    }
                    ?> id="mahnsperre" type="checkbox" name="mahnsperre" /></td>
                <td><?php echo TXT_LBL_MAHNSTATUS ?></td>
                <td><input disabled name="mahnstufe" class="search" type="text" value="<?php echo $akt->get_stammdaten_mahnstufe() ?>" /></td>
                <td><?php echo TXT_LBL_INKASSOSTATUS ?></td>
                <td>
                    <input disabled name="inkstatus" class="search" type="text" value="<?php echo $akt->get_stammdaten_inkassostatus_text() . "...". $akt->get_stammdaten_inkassosstatus_bezeichnung ?>" />
                </td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_STICHTAG ?></td>
                <td><input disabled <?php
                    if (isset($akt)) {
                        echo "value=\"" . $akt->get_stammdaten_stichtag() . "\"";
                    }
                    ?> type="date" required name="stichtag" /></td>
                <td><?php echo TXT_LBL_MAHNSPERR_DATUM ?></td>
                <td><input disabled <?php
                    if (isset($akt)) {
                        echo "value=\"" . $akt->get_stammdaten_mahnsperre_datum() . "\"";
                    }
                    ?> type="date" name="mahnsperre_datum" /></td>
                <td><?php echo TXT_LBL_DATLMAHNUNG ?></td>
                <td><input disabled name="dat_l_mahnlauf" class="search" type="date" value="<?php echo $akt->get_stammdaten_dat_l_mahnlauf() ?>" /></td>
                <td><?php echo TXT_LBL_INKASSOBUERO ?></td>
                <td>
                    <input disabled name="ra_buero" class="search" type="text" value="<?php echo $akt->get_stammdaten_ra_ikbuero_text() ?>" />
                </td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_RATENOFFEN ?></td>
                <td><input disabled name="offene_raten" class="search" type="text" value="<?php echo $akt->get_stammdaten_offene_raten() ?>" /></td>
                <td><?php echo TXT_LBL_RH ?></td>
                <td><input style="text-align: right" disabled name="ratenhoehe" class="search" type="text" value="<?php echo $akt->get_stammdaten_ratenhoehe() ?>" /></td>
                <td><?php echo TXT_LBL_RATENANZ ?></td>
                <td><input disabled name="ratenanzahl" class="search" type="text" value="<?php echo $akt->get_stammdaten_ratenanzahl() ?>" /></td>
                <td><?php echo TXT_LBL_GESSALDO ?></td>
                <td><input style="text-align: right" disabled name="gesamtsaldo" class="search" type="date" value="<?php echo $akt->get_stammdaten_gesamtsaldo() ?>" /> 
                    <?php echo TXT_LBL_GESSALDO_SK ?>
                    <input style="text-align: right" disabled name="gesamtsaldo_sk" class="search" type="date" value="<?php echo $sk_gessaldo ?>" /> 
                </td>
            </tr>

        </table>
        <input type="hidden" name="mode" value="UPD" />
        <input type="hidden" name="site" value="akt" />
    </form>
<?php } ?>

<hr>


<form>

    <table class="designed">
        <tr>
            <th style="width: 400px"><?php echo TXT_LBL_IKSTATUS ?></th>            
            <th style="width: 150px"><?php echo TXT_LBL_IKSTATUSDAT ?></th>            
            <th style="width: 300px"><?php echo TXT_LBL_IKBUERO ?></th>
            <th style="width: 80px"><?php echo TXT_LBL_IKANZUEBER ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_IKUEBBETR ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_IKUEBDAT ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_IKUNEINBRING ?></th>
            <th style="width: 50px"><?php echo TXT_LBL_IKDUBIOSENINK ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_IKUEBBETR_DU ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_IKERLDAT_DU ?></th>
            <th style="width: 200px"><?php echo TXT_LBL_IKERLEDQUAL ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_IKERLDAT ?></th>
            <th style="width: 300px"><?php echo TXT_LBL_IKAUSBUCHGRUND ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_IKLETZTEAEND ?></th>
            <th style="width: 200px"><?php echo TXT_LBL_VERWENDUNGSZWECK ?></th>
            <th style="display: none" ></th>
        </tr>
        
            <tr>
                <td><?php echo $akt->get_inkasso_inkassostatus() . "&nbsp;" . $akt->get_inkasso_inkassostatus_text(); ?></td>
                <td style="text-align: center"><?php echo $akt->get_inkasso_status_dat(); ?></td>
                <td><?php echo $akt->get_inkasso_ra_ikbuero() . " " . $akt->get_inkasso_ra_ikbuero_text(); ?></td>
                <td style="text-align: center"><?php echo $akt->get_inkasso_anz_uebergab(); ?></td>
                <td style="text-align: right"><?php echo $akt->get_inkasso_uebergabe_betrag(); ?></td>
                <td style="text-align: center"><?php echo $akt->get_inkasso_uebergabe_dat(); ?></td>
                <td style="text-align: right"><?php echo $akt->get_inkasso_uneinbringlich(); ?></td>
                <td><?php echo $akt->get_inkasso_dubiosenink(); ?></td>
                <td style="text-align: right"><?php echo $akt->get_inkasso_uebetr_du(); ?></td>
                <td style="text-align: center"><?php echo $akt->get_inkasso_erl_du_dat(); ?></td>
                <td><?php echo $akt->get_inkasso_erled_qual() . " " . $akt->get_inkasso_erled_qual_text(); ?></td>
                <td style="text-align: center"><?php echo $akt->get_inkasso_erl_dat(); ?></td>
                <td><?php echo $akt->get_inkasso_ausbuchungsgrund() . " " . $akt->get_inkasso_ausbuchungsgrund_text(); ?></td>
                <td style="text-align: center"><?php echo $akt->get_inkasso_letzte_aenderung(); ?></td>
                <td><?php echo $akt->get_inkasso_verwendungszweck() ?></td>
            </tr>
					Kommentar aus //-->    

      </table>
</form>        

<form action="index.php" method="post" onsubmit="return validateFormOnSave()" <?php
if (!App::$CURRENT->has_permission("akt", "UPD"))
    echo "disabled";?>>
    <input type="hidden" value="<?php echo $akt->get_id() ?>" name="id" />
    <input type="hidden" value="<?php echo $akt->get_id() ?>" name="akt_id" />
    <input type="hidden" value="<?php echo $akt->get_ticket_id() ?>" name="ticket_id" />
    <hr>
    <table bgcolor="#99d6ff" width="100%">
		 <tr>
		    <td><?php echo 'SU-Anrede H/F/Fam' ?>
                <input placeholder="<?php echo TXT_LBL_AKTE_SU_ANREDE ?>" name="akt_su_anrede" class="column"  type="text" value="<?php echo $akt->get_akt_su_anrede() ?>" /> 
            </td>
			 <td><?php echo TXT_LBL_AKTE_SU_NACHNAME ?> 
               <input placeholder="<?php echo TXT_LBL_AKTE_SU_NACHNAME ?>" name="akt_su_nachname" class="column"  type="text" value="<?php echo $akt->get_akt_su_nachname() ?>" />                 
			 </td>
            <td><?php echo TXT_LBL_AKTE_SU_VORNAME ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_SU_VORNAME ?>" name="akt_su_vorname" class="column"  type="text" value="<?php echo $akt->get_akt_su_vorname() ?>" />                 
            </td>
            <td><?php echo TXT_LBL_AKTE_SU_GEBDATUM ?>
               <input  value="<?php echo $akt->get_akt_su_gebdatum() ?>" placeholder="<?php echo TXT_LBL_AKTE_SU_GEBDATUM ?>" class="column" type="date" name="akt_su_gebdatum" /> 
            </td>
            <td><?php echo TXT_LBL_AKTE_SU_FIRMENBUCHNUMMER ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_SU_FIRMENBUCHNUMMER ?>" name="akt_su_firmenbuchnummer" class="column"  type="text" value="<?php echo $akt->get_akt_su_firmenbuchnummer() ?>" />                  
            </td>
			<td></td>
			<td></td>
        </tr>
	   <tr>
		    <td><?php echo TXT_LBL_AKTE_SU_STRHNR ?>
                <input placeholder="<?php echo TXT_LBL_AKTE_SU_STRHNR ?>" name="akt_su_strhnr" class="column"  type="text" value="<?php echo $akt->get_akt_su_strhnr() ?>" /> 
            </td>
			 <td><?php echo TXT_LBL_AKTE_SU_PLZ  ?> 
               <input placeholder="<?php echo TXT_LBL_AKTE_SU_PLZ ?>" name="akt_su_plz" class="column"  type="text" value="<?php echo $akt->get_akt_su_plz() ?>" />                 
			 </td>
            <td><?php echo TXT_LBL_AKTE_SU_ORT  ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_SU_ORT ?>" name="akt_su_ort" class="column"  type="text" value="<?php echo $akt->get_akt_su_ort() ?>" />                 
            </td>
            <td colspan="3"><?php echo '2te verpflichtete Partei (NN,VN,PLZ,ORT,STR+HNR)' ?>
                <input placeholder="<?php echo TXT_LBL_AKTE_FORDERUNGSGRUND01 ?>" name="akt_forderungsgrund01" class="column" style="width:85%" type="text"  value="<?php echo $akt->get_akt_forderungsgrund01() ?>" /> 
	         <td><?php echo TXT_LBL_AKTE_FORDERUNGSGRUND12 ?>
 			   <input placeholder="<?php echo TXT_LBL_AKTE_FORDERUNGSGRUND12 ?>" name="akt_forderungsgrund12" class="column" disabled type="text"  style="width:100px" value="<?php echo $akt->get_akt_forderungsgrund12() ?>" /> 
			 <input placeholder="<?php echo TXT_LBL_AKTE_FORDERUNGSGRUND12 ?>" name="akt_forderungsgrund12" class="column" type="hidden"  style="width:100px" value="<?php echo $akt->get_akt_forderungsgrund12() ?>" /> 			   
            </td>
        </tr>



	<tr>
           <td><?php echo 'Klagsbetrag (auf Deckblatt)' ?>
            
                <input placeholder="<?php echo TXT_LBL_AKTE_RESTL_HAUPTFORDERUNG ?>" name="akt_restl_hauptforderung" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_restl_hauptforderung() ?>" />                 
            </td>
            <td><?php echo 'Zinssatz aus Urteil' ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_ZINSSATZ_KAPITAL ?>" name="akt_zinssatz_kapital" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_zinssatz_kapital() ?>" />                     
            </td>
           <td><?php echo 'Zinsstartdatum aus Urteil' ?>
			   <input  value="<?php echo $akt->get_akt_zinsstartdatum() ?>" placeholder="<?php echo 'Zinsstartdatum aus Urteil' ?>" class="column" type="date" name="akt_zinsstartdatum" /> 			   
            </td>
		  <td><?php echo 'verzinste RA-Kosten (auf Deckblatt)' ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_KAP_ZINSEN_BIS_STICHTAG ?>" name="akt_kap_zinsen_bis_stichtag2" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_kap_zinsen_bis_stichtag2() ?>" />                                
            </td>
			
			<td><?php echo 'unverzinste RA-Kosten (auf Deckblatt)' ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_RESTL_BARAUSLAGEN ?>" name="akt_kosten_sonst" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_kosten_sonst() ?>" />                   
            </td>
			<td><?php echo 'Summe Zahlungen' ?>
               <input placeholder="<?php echo 'Summe Zahlungen' ?>" name="akt_rest_ra_honorar" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_rest_ra_honorar() ?>" />                   
            </td>			
			 <!-- Kommentarzeile ein

           <td><?php echo TXT_LBL_AKTE_KAP_ZINSEN_BIS_STICHTAG ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_KAP_ZINSEN_BIS_STICHTAG ?>" disabled name="akt_kap_zinsen_bis_stichtag" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_kap_zinsen_bis_stichtag() ?>" />                                
            </td>
			Kommentar aus //-->    

 	     <td>
             </td>
     	  <td>
            </td>
			<td>   
            </td>

        </tr>
					 <!-- Kommentarzeile ein

	<tr>
           <td>                  </td>
		  <td><?php echo 'Kosten Titel'  ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_RESTL_BARAUSLAGEN ?>" name="akt_kosten_titel" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_kosten_titel() ?>" />                   
            </td>
           <td><?php echo 'Kosten EXE' ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_RESTL_BARAUSLAGEN ?>" name="akt_kosten_exe" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_kosten_exe() ?>" />                   
            </td>
 	     <td><?php echo 'KostenGeb' ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_RESTL_BARAUSLAGEN ?>" name="akt_kosten_geb" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_kosten_geb() ?>" />                   
             </td>
     	  <td><?php echo 'unverzinste RA-Kosten (auf Deckblatt)' ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_RESTL_BARAUSLAGEN ?>" name="akt_kosten_sonst" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_kosten_sonst() ?>" />                   
            </td>
			<td><?php echo TXT_LBL_AKTE_RESTL_BARAUSLAGEN  ?>
               <input placeholder="<?php echo TXT_LBL_AKTE_RESTL_BARAUSLAGEN ?>" disabled name="akt_restl_barauslagen" class="column" style="text-align: right;width:100px" type="text" value="<?php echo $akt->get_akt_restl_barauslagen() ?>" />                   
            </td>
<td>                  </td>
<td>                  </td>
        </tr>
					Kommentar aus //-->    


		<!-- 
		 <tr>
		   <td><?php echo TXT_LBL_AKTE_KAP_ZINSEN_BIS_STICHTAG ?></td>
            <td>
               <input placeholder="<?php echo TXT_LBL_AKTE_KAP_ZINSEN_BIS_STICHTAG ?>" name="akt_kap_zinsen_bis_stichtag" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_kap_zinsen_bis_stichtag() ?>" />                                
            </td>
            <td><?php echo TXT_LBL_AKTE_RESTL_RA_HONORAR ?></td>
            <td>
               <input placeholder="<?php echo TXT_LBL_AKTE_RESTL_RA_HONORAR ?>" name="akt_rest_ra_honorar" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_rest_ra_honorar() ?>" />                   
            </td>
            <td><?php echo TXT_LBL_AKTE_RESTL_BARAUSLAGEN ?></td>
            <td>
               <input placeholder="<?php echo TXT_LBL_AKTE_RESTL_BARAUSLAGEN ?>" name="akt_restl_barauslagen" class="column" style="text-align: right" type="text" value="<?php echo $akt->get_akt_restl_barauslagen() ?>" />                   
            </td>
            <td></td>
            <td>
                
            </td>
           
        </tr>
		-->
        <tr>
            <td><?php echo TXT_LBL_AKTE_TITELGERICHT ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_AKTE_TITELGERICHT ?>" name="akt_titel_gericht" class="column" type="text" value="<?php echo $akt->get_akt_titel_gericht() ?>" /> 
            </td>
			            <td><?php echo TXT_LBL_AKTE_TITELVOM ?></td>
            <td>
                <input  value="<?php echo $akt->get_akt_titel_datum() ?>" placeholder="<?php echo TXT_LBL_AKTE_TITELVOM ?>" class="column" type="date" name="akt_titel_datum" /> 
            </td>
             <td><?php echo TXT_LBL_AKTE_GESCHZLTITEL ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_AKTE_GESCHZLTITEL ?>" name="akt_titel_geschaeftszahl" class="column" type="text" value="<?php echo $akt->get_akt_titel_geschaeftszahl() ?>" /> 
            </td>
            <td></td>
            <td></td>


        </tr>
        <tr>
            <td><?php echo TXT_LBL_AKTE_LETZTEEXECGER ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_AKTE_LETZTEEXECGER ?>" name="akt_letztes_exekutionsgericht" class="column" type="text" value="<?php echo $akt->get_akt_letztes_exekutionsgericht() ?>" /> 
            </td>
             <td><?php echo TXT_LBL_AKTE_GESCHZLEXE ?></td>

            <td>
                <input placeholder="<?php echo TXT_LBL_AKTE_GESCHZLEXE ?>" name="akt_exekution_geschaeftszahl" class="column" type="text" value="<?php echo $akt->get_akt_exekution_geschaeftszahl() ?>" /> 
            </td>
			<td></td>
            <td></td>
			<td></td>
            <td></td>

			
        </tr>
     
        <tr>
             <td><?php echo TXT_LBL_AKTE_HINWEISE ?></td>
            <td colspan="3" style="padding-right: 14px">
                <textarea rows="3" style="width: 100%" placeholder="<?php echo TXT_LBL_AKTE_HINWEISE ?>" name="akt_hinweise"><?php echo $akt->get_akt_hinweise() ?></textarea>
            </td>
           <!-- 
			<td><?php echo TXT_LBL_AKTE_ANZAHL_DOK ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_AKTE_ANZAHL_DOK ?>" name="akt_anzahl_dokumente" class="column" type="text" value="<?php echo $akt->get_akt_anzahl_dokumente() ?>" /> 
            </td>
			
			 <td><?php echo TXT_LBL_AKTE_WAEHRUNG ?><fieldset>
                    <input type="radio" id="EUR" <?php if ($akt->get_akt_waehrung()=="EUR") echo "checked"; ?> name="akt_waehrung" value="EUR"><label for="EUR"> <?php echo TXT_LBL_AKTE_EUR?></label> 
                    <input type="radio" id="ATS" <?php if ($akt->get_akt_waehrung()=="ATS") echo "checked"; ?> name="akt_waehrung" value="ATS"><label for="ATS"> <?php echo TXT_LBL_AKTE_ATS?></label><br> 
                </fieldset>
			</td>
			-->
		    <td><?php echo TXT_LBL_AKTE_ABRECHNUNGSSTICHTAG ?></td>
            <td>
                <input  value="<?php echo $akt->get_akt_abrechnungsstichtag() ?>" placeholder="<?php echo TXT_LBL_AKTE_ABRECHNUNGSSTICHTAG ?>" disabled class="column" type="date" name="akt_abrechnungsstichtag" /> 
            </td>
			<td></td>
            <td></td>
			<td></td>
        </tr>

        
    </table>
    <br>
    <input name="mandant_id" type="hidden" value="<?php echo App::$CURRENT->MANDANT->get_id() ?>" />
    
    <input type="hidden" name="site" id="site" value="akt" />
    <input type="hidden" name="mode" value="UPD" />

<?php 
if (App::$CURRENT->has_permission("akt", "UPD")) {
    ?>
        <input accesskey="S" type="submit" class="column"  value="<?php echo TXT_LBL_SAVE ?>" />
    <?php } ?>
</form>