<h1><?php echo TXT_LBL_BUCHUNGEN ?></h1>
<script type="text/javascript">
    function EnableDisableSKBuch() {

        //var bugru = document.getElementById('bua_bgr_man_id').value;
        var selindex = document.getElementById('bua_bgr_man_id').selectedIndex;
        var bugru_berechnung = document.getElementById('bua_bgr_man_id').options[selindex].title;
		var bugru_art = document.getElementById('bua_bgr_man_id').options[selindex].text.substr(0,4);
        //var betrag = document.getElementById('buchungsbetrag');
        var buchkz = document.getElementById('buchungskennzeichen');
        var bukz_selindex = document.getElementById('buchungskennzeichen').selectedIndex;
        var cbBuch = document.getElementById('buch_auf_sk');

        var EnableBuch = false;

        if (bukz_selindex == 0 && (bugru_berechnung == 'P' | bugru_art=='4770'))  {
            EnableBuch = true;
            cbBuch.checked = true;
        } else {
            cbBuch.checked = false;
        }
        cbBuch.disabled = !EnableBuch;
        return true;
    }
</script>
<form action="index.php" method="get">

    <?php if (isset($kunde)) { ?>
        <input type="hidden" value="<?php echo $kunde->get_kdnr(); ?>" name="kundennummer_backup" />
    <?php } ?>
    <table>
        <tr>
            <td><?php echo TXT_LBL_KDNR ?></td>
            <td>
                <input name="kundennummer" required placeholder="<?php echo TXT_LBL_KDNR ?>" name="kdnr" class="column" type="text" value="<?php if (isset($kunde)) echo $kunde->get_kdnr(); ?>" />
            </td>
            <td>
                <input type="hidden" name="site" value="buchungen" />
                <input type="submit" value="<?php echo TXT_LBL_SEARCH ?>" />
            </td>

            <td>
                <?php echo TXT_LBL_ANREDE ?>/<?php echo TXT_LBL_TITEL ?>
                <?php // <input type="submit" value="<?php echo TXT_LBL_SEARCH ?>
                <input disabled name="anrede"  type="text" value="<?php echo $kunde->get_anrede() . " " . $kunde->get_titel() ?>" /> 
            </td>
            <td>Kundenart</td>
            <td><input disabled name="kundenart" class="search" type="text" value="<?php echo $kunde->get_kundenart() ?> <?php echo $kunde->get_kundenartbeschreibung() ?>" /></td>
            <td><?php echo TXT_LBL_KENNER ?></td>
            <td><input disabled name="kto_kenner" class="search" type="text" value="<?php echo $stammdaten->get_kto_kenner() ?>" /> </td>
        </tr>
        <?php if (isset($kunde)) { ?>
            <tr disabled>
                <td><?php echo TXT_LBL_LASTNAME ?></td>
                <td>
                    <input disabled required class="column" type="text" value="<?php echo $kunde->get_nachname() ?>" />
                </td>
                <td><?php echo TXT_LBL_FIRSTNAME ?></td>
                <td>
                    <input disabled required name="vorname" class="column" type="text" value="<?php echo $kunde->get_vorname() ?>" />
                </td>
                <td><?php echo TXT_LBL_LASTNAME2 ?></td>
                <td><input disabled required name="nachname" class="column" type="text" value="<?php echo $kunde->get_nachname2() ?>" /></td>
                <td><?php echo TXT_LBL_FIRSTNAME2 ?></td>
                <td><input disabled required name="vorname" class="column" type="text" value="<?php echo $kunde->get_vorname2() ?>" /> </td>
            </tr>
            <tr disabled>
                <td><?php echo TXT_LBL_BIRTH ?></td>
                <td>
                    <input disabled class="search" type="date" value="<?php echo $kunde->get_geburtsdatum() ?>" />
                </td>
                <td></td>
                <td></td>
                <td><?php echo TXT_LBL_BIRTH2 ?></td>
                <td> <input disabled class="search" type="date" value="<?php echo $kunde->get_geburtsdatum2() ?>" /> </td>
                <td> </td>
                <td></td>
            </tr>
            <tr disabled>
                <td><?php echo TXT_LBL_STR ?></td>
                <td>
                    <input disabled required class="column" type="text" value="<?php echo $kunde->get_strasse() ?>" />
                </td>

                <td><?php echo TXT_LBL_HNR ?></td>
                <td>
                    <table class="column padded">
                        <tr>
                            <td>
                                <input disabled size="10" name="hausnummer" type="text" value="<?php echo $kunde->get_hausnummer() ?>" />
                            </td>
                            <td class="placeholder"></td>
                            <td>
                                <input disabled size="10" name="hausnummer_erw" type="text" value="<?php echo $kunde->get_hausnummer_erw() ?>" />
                            </td>
                        </tr>
                    </table>
                </td>
                <td><?php echo TXT_LBL_PLZ ?></td>
                <td>
                    <input disabled size="10" name="plzort" type="text" value="<?php echo $kunde->get_land() . " " . $kunde->get_plz() ?>" />
                </td>
                <td><?php echo TXT_LBL_ORT ?></td>
                <td><input required disabled  name="ort" class="search" type="text" value="<?php echo $kunde->get_ort() ?>" /></td>
            </tr>
            <tr disabled>
                <td><?php echo TXT_LBL_TEL ?></td>
                <td>
                    <input disabled name="telefon" class="search" type="text" value="<?php echo $kunde->get_telefon() ?>" /> <br />
                </td>
                <td><?php echo TXT_LBL_EMAIL ?></td>
                <td>
                    <input disabled size="40" name="email" class="search" type="email" value="<?php echo $kunde->get_email() ?>" /> <br />
                </td>
            </tr>
        <?php } ?>
    </table>
</form>

<?php if (isset($kunde)) { ?>
    <hr>
    <form method="post" action="index.php" <?php if (!App::$CURRENT->has_permission("stammdaten", "UPD")) echo 'disabled'; ?>>
        <input type="hidden" name="id" value="<?php if ($exists) echo $stammdaten->get_id(); ?>" />
        <table>
            <tr>
                <td><?php echo TXT_LBL_ZAHLTAG ?></td>
                <td><input disabled <?php
                    if ($exists) {
                        echo "value=\"" . $stammdaten->get_zahltag() . "\"";
                    }
                    ?> type="date" placeholder="<?php echo TXT_LBL_ZAHLTAG ?>" name="zahltag" required /></td>
                <td><label for="mahnsperre"><?php echo TXT_LBL_MAHNSPERRE ?></label></td>
                <td><input disabled <?php
                    if ($exists && $stammdaten->get_mahnsperre() == "MS") {
                        echo "checked";
                    }
                    ?> id="mahnsperre" type="checkbox" name="mahnsperre" /></td>
                <td><?php echo TXT_LBL_MAHNSTATUS ?></td>
                <td><input disabled name="mahnstufe" class="search" type="text" value="<?php echo $stammdaten->get_mahnstufe() ?>" /></td>
                <td><?php echo TXT_LBL_INKASSOSTATUS ?></td>
                <td> 
                    <select disabled required name="inkassostatus_id" style="width: 300px" >
                        <option value="0"><?php echo TXT_LBL_NOONE ?></option>
                        <?php
                        foreach ($ikstat as $iks) {
                            ?>
                            <option <?php
                            if ($stammdaten->get_inkassostatus_id() == $iks->get_id()) {
                                echo " selected ";
                            }
                            ?> value="<?php echo $iks->get_id() ?>"><?php echo $iks->get_inkassostatus() . "..." . $iks->get_bezeichnung() ?></option>
                                <?php
                            }
                            ?>
                    </select>  
                </td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_STICHTAG ?></td>
                <td><input disabled <?php
                    if ($exists) {
                        echo "value=\"" . $stammdaten->get_stichtag() . "\"";
                    }
                    ?> type="date" required name="stichtag" /></td>
                <td><?php echo TXT_LBL_MAHNSPERR_DATUM ?></td>
                <td><input disabled <?php
                    if ($exists) {
                        echo "value=\"" . $stammdaten->get_mahnsperre_datum() . "\"";
                    }
                    ?> type="date" name="mahnsperre_datum" /></td>
                <td><?php echo TXT_LBL_DATLMAHNUNG ?></td>
                <td><input disabled name="dat_l_mahnlauf" class="search" type="date" value="<?php echo $stammdaten->get_dat_l_mahnlauf() ?>" /></td>
                <td><?php echo TXT_LBL_INKASSOBUERO ?></td>
                <td>
                    <select disabled required name="ra_ikbuero_id" style="width: 300px" >
                        <option value="0"><?php echo TXT_LBL_NOONE ?></option>
                        <?php
                        foreach ($ikbueros as $ikb) {
                            ?>
                            <option <?php
                            if ($stammdaten->get_ra_ikbuero_id() == $ikb->get_id()) {
                                echo "selected";
                            }
                            ?> value="<?php echo $ikb->get_id() ?>"><?php echo $ikb->get_ra_buero() . " " . $ikb->get_text() ?></option>
                                <?php
                            }
                            ?>
                    </select>  
                </td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_RATENOFFEN ?></td>
                <td><input disabled name="offene_raten" class="search" type="text" value="<?php echo $stammdaten->get_offene_raten() ?>" /></td>
                <td><?php echo TXT_LBL_RH ?></td>
                <td><input style="text-align: right" disabled name="ratenhoehe" class="search" type="text" value="<?php echo $stammdaten->get_ratenhoehe() ?>" /></td>
                <td><?php echo TXT_LBL_RATENANZ ?></td>
                <td><input disabled name="ratenanzahl" class="search" type="text" value="<?php echo $stammdaten->get_ratenanzahl() ?>" /></td>
                <td><?php echo TXT_LBL_GESSALDO ?></td>
                <td><input style="text-align: right" disabled name="gesamtsaldo" class="search" type="date" value="<?php echo $stammdaten->get_gesamtsaldo() ?>" /> 
                    <?php echo TXT_LBL_GESSALDO_SK ?>
                    <input style="text-align: right" disabled name="gesamtsaldo_sk" class="search" type="date" value="<?php echo $sk_gessaldo ?>" /> 
                </td>
            </tr>

        </table>
        <?php if ($exists) { ?>
            <input type="hidden" name="mode" value="UPD" />
        <?php } else { ?>
            <input type="hidden" name="mode" value="INS" />
        <?php } ?>

        <input type="hidden" name="site" value="stammdaten" />
        <input type="hidden" name="kunde" value="<?php echo $kunde_id; ?>" />

    </form>
<?php } ?>

<hr>


<form method="post">
    <table>
        <tr>
            <?php if (App::$CURRENT->has_permission("buchungen", "INS")) { ?>
                <td>
                    <a <?php if ($show_new) echo "disabled" ?> class="button column" href="./index.php?site=buchungen&showNew=true"><?php echo TXT_LBL_NEW ?></a>
                </td>
            <?php } ?>
            <?php if ($show_new) { ?>
                <td> <input type="submit" value="<?php echo TXT_LBL_SAVE ?>" class="column" />
                    <a class="button column" href="./index.php?site=buchungen"><?php echo TXT_LBL_CANCEL ?></a>
                </td>
            <?php } ?>
        </tr>
    </table>

    <?php if (isset($cur_buchung_id)) { ?>
        <input type="hidden" name="cur_id" value="<?php echo $cur_buchung_id; ?>" />
    <?php } ?>

    <table class="designed">
        <tr>
            <th style="width: 400px"><?php echo TXT_LBL_BUARTGRUND ?></th>            
            <th style="width: 90px"><?php echo TXT_LBL_BUCHZA ?></th>            
            <th style="width: 40px"><?php echo TXT_LBL_BUCHSTORNO ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_BDAT ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_BUCHVALUTADAT ?></th>
            <?php if ($show_new) { ?>
                <th style="width: 100px"><?php echo TXT_LBL_BETR ?></th>
                <th style="width: 100px"> </th>
            <?php } else { ?>
                <th style="width: 100px"><?php echo TXT_LBL_BUCHSOLL ?></th>
                <th style="width: 100px"><?php echo TXT_LBL_BUCHHABEN ?></th>
            <?php } ?>                
            <th style="width: 100px"><?php echo TXT_LBL_BUCHRABATT ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_BUCHVERGUETUNG ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_BUCHSPESEN ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_BUCHKZGEBUCHT ?></th>
            <th style="width: 200px"><?php echo TXT_LBL_VERWENDUNGSZWECK ?></th>
            <th style="display: none" ></th>
            <th style="display: none" ></th>
        </tr>

        <?php if ($show_new) { ?>
            <tr>
                <td>
                    <select onchange="EnableDisableSKBuch()" class="column" name="bua_bgr_man_id" id="bua_bgr_man_id"  >
                        <?php foreach ($buchungsgruende as $p) { ?>
                            <option  value="<?php echo $p->get_buabgr_man_id() ?>" title="<?php echo $p->get_plusminus() ?>"><?php echo $p->get_bugru_key_om() . " " . $p->get_buart_text() . " " . $p->get_kontoauszugstext() ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select  name="zahlart_id"  >
                        <?php foreach ($zahlarten as $p) { ?>
                            <option  value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                        <?php } ?>
                    </select>
                </td> 
                <td>
                    <select  name="buchungskennzeichen" id="buchungskennzeichen" onchange="EnableDisableSKBuch()" >
                        <option value="0"></option>
                        <option value="1"><?php echo TXT_LBL_JA ?></option>
                    </select>
                </td>
                <td><input name="buchungsdatum"  type="hidden" value="<?php echo $verwaltungssatz[0]->get_buchungsdatum(); ?>" />
                    <input name="buchungsdatumdisplay" disabled type="date" value="<?php echo $verwaltungssatz[0]->get_buchungsdatum(); ?>" />
                </td>
                <td><input required name="valutadatum"  type="date" value="<?php echo $verwaltungssatz[0]->get_buchungsdatum(); ?>" /></td>
                <td><input name="betrag" style="text-align: right" type="text" value="0,00" /></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <select disabled class="column" name="kz_gebucht"  >
                        <option  value="J"><?php echo TXT_LBL_JA ?></option>
                        <option  value="N"><?php echo TXT_LBL_NEIN ?></option>
                    </select>
                </td>
                <td><input style="min-width:200px" name="verwendungszweck" type="text" value="" /></td>

            </tr>
            <tr  style="line-height: 15px"  >
                <td style="text-align: right;padding-left: 20px;color: #1c94c4;font-style: inherit;"><?php echo TXT_LBL_BU_BTN_BUCHSK ?> 
                    <input type="checkbox" disabled="" name="buch_auf_sk" id="buch_auf_sk" value="1"> 
                </td>
                <td >&nbsp;</td>
            </tr>

            <?php
        }

        foreach ($buchungen as $item) {
            ?>
            <tr>
                <td><?php echo $item->get_bugru_key_om() . " " . $item->get_buart_text() . " " . $item->get_bugru_text() ?></td>
                <td><?php echo $item->get_zahlart_text() ?></td>
                <td style="text-align: right" ><?php if ($item->get_buchungskennzeichen() == 1) echo TXT_LBL_BUCHSTORNO; ?></td>
                <td disabled ><?php echo $item->get_buchungsdatum(); ?></td>
                <td><?php echo $item->get_valutadatum(); ?></td>
                <td style="text-align: right" ><?php if (($item->get_kz_berechnung() == 'M' && $item->get_buchungskennzeichen() == 0) || ($item->get_kz_berechnung() == 'P' && $item->get_buchungskennzeichen() == 1)) echo $item->get_betrag(); ?></td>
                <td style="text-align: right" ><?php if (($item->get_kz_berechnung() == 'P' && $item->get_buchungskennzeichen() == 0) || ($item->get_kz_berechnung() == 'M' && $item->get_buchungskennzeichen() == 1)) echo $item->get_betrag(); ?></td>
                <td style="text-align: right" ><?php echo $item->get_rabatt(); ?></td>
                <td style="text-align: right" ><?php echo $item->get_verguetung(); ?></td>
                <td style="text-align: right" ><?php echo $item->get_spesen(); ?></td>
                <td >
                    <?php
                    if ($item->get_kz_gebucht() == 'J') {
                        echo TXT_LBL_JA;
                    } elseif ($item->get_kz_gebucht() == 'N') {
                        echo TXT_LBL_NEIN;
                    } else {
                        ?>
                        <?php if (App::$CURRENT->has_permission("buchungen", "INS") && !$show_new) { ?>
                        <?php if ($item->get_kz_berechnung() == 'P' && $item->get_buchungskennzeichen() != 1) { ?>
                            <a class="button column" href="./index.php?site=buchungen&mode=KZBUCH_BUSK&update_buchung_oid=<?php echo $item->get_id(); ?>"><?php echo TXT_LBL_BUCHBTN_BUCHEN_MIT_SK ?></a>
                        <?php } else { ?>
                            <a class="button column" href="./index.php?site=buchungen&mode=KZBUCH_BU&update_buchung_oid=<?php echo $item->get_id(); ?>"><?php echo TXT_LBL_BUCHBTN_BUCHEN ?></a>
                        <?php } ?>
                            <a class="button column" href="./index.php?site=buchungen&mode=KZBUCH_ST&update_buchung_oid=<?php echo $item->get_id(); ?>"><?php echo TXT_LBL_BUCHBTN_STORNO ?></a>
                        <?php } ?>
                        <?php
                    }
                    ?>
                </td>
                <td ><?php echo $item->get_verwendungszweck(); ?></td>
            </tr>
        <?php } ?>
    </table>
    <?php if (!isset($cur_buchung_id)) { ?>
        <input type="hidden" value="INS" name="mode" />
    <?php } else { ?>
        <input type="hidden" value="<?php echo $cur_buchung_id ?>" name="edited_id" />
        <input type="hidden" value="UPD" name="mode" />
    <?php } ?>
    <input type="hidden" value="buchungen" name="site" />
    <input type="hidden" value="<?php echo $buchung_id ?>" name="buchungen" />

</form>        

<div class="buttonset">
    <a href="index.php?site=buchungen&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=buchungen&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>

    <a href="index.php?site=buchungen&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>
</div>

<?php if (isset($sk_aufteilung) && count($sk_aufteilung) > 0) { ?>
    <div>
        <?php echo "<br>";?>
        <h2><?php echo TXT_LBL_BU_SK_AUFTEILUNG ?></h2>
        <table style="width: 900px" class="designed">
            <colgroup>
                <col width="100">
                <col width="100">
                <col width="100">
                <col width="100">
                <col width="100">
                <col width="100">
                <col width="100">
                <col width="100">
                <col width="100">
            </colgroup>

            <tr>
                <th style="width: 100px"><?php echo TXT_LBL_RECHNUNG ?></th>            
                <th style="width: 100px"><?php echo TXT_LBL_M4 ?></th>            
                <th style="width: 100px"><?php echo TXT_LBL_M3 ?></th>
                <th style="width: 100px"><?php echo TXT_LBL_M2 ?></th>
                <th style="width: 100px"><?php echo TXT_LBL_M1 ?></th>
                <th style="width: 100px"><?php echo TXT_LBL_M0 ?></th>
                <th style="width: 100px"><?php echo TXT_LBL_REST ?></th>
                <th style="width: 100px"><?php echo TXT_LBL_SALDO ?></th>
                <th style="width: 100px"><?php echo TXT_LBL_BETR ?></th>
            </tr>
            <tr></tr>
            <?php $anz = 0;
            $n = 1;
            $anz = count($sk_aufteilung);
            foreach ($sk_aufteilung as $row) { ?>
                <tr>
                    <?php if ($n==$anz) {?>
                <th></th>            
                <th></th>            
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right"><?php echo $row['Saldo'] ?></th>
                <th style="text-align: right"><?php echo $row['Buch']; ?></th>

                    <?php } else {?>
                    <td><?php echo $row['sklfdnr']; ?>
                    <td style="text-align: right"><?php echo $row['M4']; ?>
                    <td style="text-align: right"><?php echo $row['M3']; ?>
                    <td style="text-align: right"><?php echo $row['M2']; ?>
                    <td style="text-align: right"><?php echo $row['M1']; ?>
                    <td style="text-align: right"><?php echo $row['M0']; ?>
                    <td style="text-align: right"><?php echo $row['Rest']; ?>
                    <td style="text-align: right"><?php echo $row['Saldo']; ?>
                    <td style="text-align: right"><?php echo $row['Buch']; ?>
                    <?php }?>
                </tr>
                
            <?php $n++; } ?>

        </table>
<?php echo "<br>";?>
    </div>
    <?php unset($sk_aufteilung); ?>
<?php } ?>
    