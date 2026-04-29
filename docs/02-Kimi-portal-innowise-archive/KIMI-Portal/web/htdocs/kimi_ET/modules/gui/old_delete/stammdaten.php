<h1><?php echo TXT_LBL_BASE_DATA ?></h1>

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
                <input type="hidden" name="site" value="stammdaten" />
                <input type="submit" value="<?php echo TXT_LBL_SEARCH ?>" />
            </td>
            <?php if (isset($kunde)) { ?>
                <td>
                    <table class="column">
                        <tr>
                            <td><?php echo TXT_LBL_ANREDE ?>/<?php echo TXT_LBL_TITEL ?></td>
                            <td>
                                <select disabled name="anrede_id" ">
                                    <option selected value="-1"><?php echo $kunde->get_anrede() ?></option>
                                </select>
                            </td>
                            <td>
                                <input class="columnSmall" disabled placeholder="<?php echo TXT_LBL_TITEL ?>" name="titel"  type="text" value="<?php echo $kunde->get_titel() ?>" /> 
                                <?php /*
                                  <select disabled name="titel_id" style="width: 100%;">
                                  <option selected value="-1"><?php echo $kunde->get_titel() ?></option>
                                  </select> */ ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>Kundenart</td>
                <td><input disabled  name="kundenart" class="search" type="text" value="<?php echo $kunde->get_kundenart() ?> <?php echo $kunde->get_kundenartbeschreibung() ?>" /></td>
                <td><?php echo TXT_LBL_ADRKENNER ?></td>
                <td><input disabled  name="adr_kenner"  class="column" type="text" value="<?php echo $kunde->get_kenner() ?>" /> </td>
            <?php } ?>
        </tr>

        <?php if (isset($kunde)) { ?>
            <tr disabled>
                <td><?php echo TXT_LBL_LASTNAME ?></td>
                <td>
                    <input disabled  name="nachname" class="column" type="text" value="<?php echo $kunde->get_nachname() ?>" />
                </td>
                <td><?php echo TXT_LBL_FIRSTNAME ?></td>
                <td>
                    <input disabled  name="vorname" class="column" type="text" value="<?php echo $kunde->get_vorname() ?>" />
                </td>
                <td><?php echo TXT_LBL_LASTNAME ?>2</td>
                <td><input disabled  name="nachname" class="column" type="text" value="<?php echo $kunde->get_nachname2() ?>" /></td>
                <td><?php echo TXT_LBL_FIRSTNAME ?>2</td>
                <td><input disabled  name="vorname" class="column" type="text" value="<?php echo $kunde->get_vorname2() ?>" /> </td>
            </tr>
            <tr disabled>
                <td><?php echo TXT_LBL_BIRTH ?></td>
                <td>
                    <input disabled  name="geburtsdatum" class="search" type="date" value="<?php echo $kunde->get_geburtsdatum() ?>" />
                </td>
                <td></td>
                <td></td>
                <td><?php echo TXT_LBL_BIRTH ?>2</td>
                <td> <input disabled  name="geburtsdatum2" class="search" type="date" value="<?php echo $kunde->get_geburtsdatum2() ?>" /> </td>
                <td> </td>
                <td></td>
            </tr>
            <tr disabled>
                <td><?php echo TXT_LBL_STR ?></td>
                <td>
                    <input disabled  name="strasse" class="column" type="text" value="<?php echo $kunde->get_strasse() ?>" />
                </td>

                <td><?php echo TXT_LBL_HNR ?></td>
                <td>
                    <table class="column padded">
                        <tr>
                            <td>
                                <input disabled  size="10" name="hausnummer" type="text" value="<?php echo $kunde->get_hausnummer() ?>" />
                            </td>
                            <td class="placeholder"></td>
                            <td>
                                <input disabled  size="10" name="hausnummer_erw" type="text" value="<?php echo $kunde->get_hausnummer_erw() ?>" />
                            </td>
                        </tr>
                    </table>
                </td>
                <td><?php echo TXT_LBL_PLZ ?></td>
                <td>
                    <table class="column">
                        <tr>
                            <td>
                                <select disabled  name="land_id">
                                    <option selected value="-1"><?php echo $kunde->get_land(); ?></option>
                                </select>
                            </td>
                            <td>
                                <input disabled  name="plz" type="text" value="<?php echo $kunde->get_plz() ?>" />
                            </td>
                        </tr>
                    </table>
                </td>
                <td><?php echo TXT_LBL_ORT ?></td>
                <td><input required disabled  name="ort" class="search" type="text" value="<?php echo $kunde->get_ort() ?>" /></td>
            </tr>
            <tr disabled>
                <td><?php echo TXT_LBL_TEL ?></td>
                <td>
                    <input disabled  name="telefon" class="search" type="text" value="<?php echo $kunde->get_telefon() ?>" /> <br />
                </td>
                <td><?php echo TXT_LBL_EMAIL ?></td>
                <td>
                    <input disabled  size="40" name="email" class="search" type="email" value="<?php echo $kunde->get_email() ?>" /> <br />
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
                <td><input <?php
                    if ($exists) {
                        echo "value=\"" . $stammdaten->get_zahltag() . "\"";
                    }
                    ?> type="date" placeholder="<?php echo TXT_LBL_ZAHLTAG ?>" name="zahltag" required /></td>
                <td><label for="mahnsperre"><?php echo TXT_LBL_MAHNSPERRE ?></label></td>
                <td><input <?php
                    if ($exists && $stammdaten->get_mahnsperre() == "MS") {
                        echo "checked";
                    }
                    ?> id="mahnsperre" type="checkbox" name="mahnsperre" /></td>
                <td><?php echo TXT_LBL_MAHNSTATUS ?></td>
                <td><input placeholder="<?php echo TXT_LBL_MAHNSTATUS ?>" name="mahnstufe" class="search" type="text" value="<?php echo $stammdaten->get_mahnstufe() ?>" /></td>
                <td><?php echo TXT_LBL_INKASSOSTATUS ?></td>
                <td>
                    <select disabled required name="inkassostatus_id" style="width: 410px" >
                        <option value="0"><?php echo TXT_LBL_NOONE ?></option>
                        <?php
                        foreach ($ikstat as $iks) {
                            ?>
                            <option <?php
                            if ($stammdaten->get_inkassostatus_id() == $iks->get_id()) {
                                echo "selected";
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
                <td><input <?php
                    if ($exists) {
                        echo "value=\"" . $stammdaten->get_stichtag() . "\"";
                    }
                    ?> type="date" placeholder="<?php echo TXT_LBL_STICHTAG ?>" required name="stichtag" /></td>
                <td><?php echo TXT_LBL_MAHNSPERR_DATUM ?></td>
                <td><input <?php
                    if ($exists) {
                        echo "value=\"" . $stammdaten->get_mahnsperre_datum() . "\"";
                    }
                    ?> type="date" placeholder="<?php echo TXT_LBL_MAHNSPERR_DATUM ?>" name="mahnsperre_datum" /></td>
                <td><?php echo TXT_LBL_DATLMAHNUNG ?></td>
                <td><input disabled  name="dat_l_mahnlauf" class="search" type="date" value="<?php echo $stammdaten->get_dat_l_mahnlauf() ?>" /></td>
                <td><?php echo TXT_LBL_INKASSOBUERO ?></td>
                <td>
                    <select disabled required name="ra_ikbuero_id" style="width: 200px" >
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
                    <?php echo TXT_LBL_IKSTATUSDAT . " " . $ikinfo->get_status_dat() ?>
                </td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_RATENOFFEN ?></td>
                <td><input disabled  name="offene_raten" class="search" type="text" value="<?php echo $stammdaten->get_offene_raten() ?>" /></td>
                <td><?php echo TXT_LBL_RH ?></td>
                <td><input style="text-align: right" disabled  name="ratenhoehe" class="search" type="text" value="<?php echo $stammdaten->get_ratenhoehe() ?>" /></td>
                <td><?php echo TXT_LBL_RATENANZ ?></td>
                <td><input disabled  name="ratenanzahl" class="search" type="text" value="<?php echo $stammdaten->get_ratenanzahl() ?>" /></td>
                <td><?php echo TXT_LBL_KTO_KENNER ?></td>
                <td>
                    <table>
                        <tr>
                            <td><input   name="kto_kenner"  class="search" type="text" value="<?php echo $stammdaten->get_kto_kenner() ?>" /> </td>
                            <td><?php echo TXT_LBL_ENDE_SOZINS ?></td>
                            <td><input name="dat_ende_sonderzins"  class="searc" type="date" value="<?php echo $stammdaten->get_dat_ende_sonderzins() ?>" /> </td>
                        </tr>
                    </table>
                </td>

            </tr>
            <tr>
                <td><?php echo TXT_LBL_EINZIEHUNG ?></td>
                <td><input  placeholder="<?php echo TXT_LBL_EINZIEHUNG ?>" name="lastschrift" class="search" type="text" value="<?php echo $stammdaten->get_lastschrift() ?>" /></td>
                <td><?php echo TXT_LBL_DATLEINZUG ?></td>
                <td><input disabled  class="search" type="date" value="<?php echo $stammdaten->get_dat_einzbetrag() ?>" /></td>
                <td><?php echo TXT_LBL_MAXEINZIEHBETRAG ?></td>
                <td><input style="text-align: right" disabled  name="max_einzbetr" class="search" type="text" value="<?php echo $stammdaten->get_max_einzbetrag() ?>" /></td>
                <td><?php echo TXT_LBL_KRSV ?></td>
                <td><input disabled  name="krsv" class="search" type="text" value="<?php echo $stammdaten->get_krsv() ?>" /></td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_DATLZAHLUNG ?></td>
                <td><input disabled  name="dat_l_zahlung" class="search" type="date" value="<?php echo $stammdaten->get_dat_l_zahlung() ?>" /></td>
                <td><?php echo TXT_LBL_BETRLZAHLUNG ?></td>
                <td><input style="text-align: right" disabled  name="betrag_l_zahlung" class="search" type="text" value="<?php echo $stammdaten->get_betrag_l_zahlung() ?>" /></td>
                <td><?php echo TXT_LBL_DATLAUSL ?></td>
                <td><input disabled  name="dat_l_auslagerung" class="search" type="date" value="<?php echo $stammdaten->get_dat_l_auslagerung() ?>" /></td>
                <td><?php echo TXT_LBL_BETRLAUSL ?></td>
                <td><input style="text-align: right" disabled  name="betrag_l_auslagerung" class="search" type="text" value="<?php echo $stammdaten->get_betrag_l_auslagerung() ?>" /></td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_DATLKA ?></td>
                <td><input disabled  name="dat_l_kontoauszug" class="search" type="date" value="<?php echo $stammdaten->get_dat_l_kontoauszug() ?>" /></td>
                <td><?php echo TXT_LBL_BETRLKA ?></td>
                <td><input style="text-align: right" disabled name="betrag_l_kontoauszug" class="search" type="text" value="<?php echo $stammdaten->get_betrag_l_kontoauszug() ?>" /></td>
                <td><?php echo TXT_LBL_DATLBUCH ?></td>
                <td><input disabled name="dat_ltzt_buchung" class="search" type="date" value="<?php echo $stammdaten->get_dat_ltzt_buchung() ?>" /></td>
                <td><?php echo TXT_LBL_DATLAEND ?></td>
                <td><input disabled name="geaendert_am" class="search" type="date" value="<?php echo $stammdaten->get_geaendert_am() ?>" /> </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo TXT_LBL_GESSALDO ?></td>
                <td><input style="text-align: right" disabled placeholder="<?php echo TXT_LBL_GESSALDO ?>" name="gesamtsaldo" class="search" type="date" value="<?php echo $stammdaten->get_gesamtsaldo() ?>" /> </td>
            </tr>
        </table>
        <?php if ($exists) { ?>
            <input type="hidden" name="mode" value="UPD" />
        <?php } else { ?>
            <input type="hidden" name="mode" value="INS" />
        <?php } ?>

        <input type="hidden" name="site" value="stammdaten" />
        <input type="hidden" name="kunde" value="<?php echo $kunde_id; ?>" />

        <table style="width: 100%">
            <tr>
                <td>
                    <?php if (App::$CURRENT->has_permission("stammdaten", "UPD")) { ?>
                        <input type="submit" class="column" value="<?php echo TXT_LBL_SAVE ?>" />
                    <?php } ?>
                </td>
                <td style="width: 100%; text-align: right">
                    <?php if (App::$CURRENT->has_permission("buchungen", "UPD")) { ?>
                        <a style="text-align: right" class="button column" href="./index.php?site=buchungen"><?php echo TXT_LBL_BUCHUNGEN . "..." ?></a>
                    <?php } ?>  
                </td>
                <td style="width: 100%; text-align: right">
                    <?php if (App::$CURRENT->has_permission("inkassoinformation", "UPD")) { ?>
                        <a style="text-align: right" class="button column" href="./index.php?site=inkassoinformation"><?php echo TXT_LBL_INKASSO . "..." ?></a>
                    <?php } ?>  
                </td>
                <td style="width: 100%; text-align: right">
                    <?php if (App::$CURRENT->has_permission("ratenrechner", "SEL")) { ?>
                        <a style="text-align: right" class="button column" href="./index.php?site=ratenrechner&kunde_id=<?php echo $kunde_id?>" ><?php echo TXT_LBL_RATE_HEADER . "..." ?></a>
                    <?php } ?>  
                </td>

            </tr>
        </table>
    </form>

    <?php if ($exists) { ?>
        <table class = 'designed-last'>
            <tr>
                <th><?php echo TXT_LBL_ZA ?></th>
                <th><?php echo TXT_LBL_M4 ?></th>
                <th><?php echo TXT_LBL_M3 ?></th>
                <th><?php echo TXT_LBL_M2 ?></th>
                <th><?php echo TXT_LBL_M1 ?></th>
                <th><?php echo TXT_LBL_M0 ?></th>
                <th><?php echo TXT_LBL_REST ?></th>
                <th><?php echo TXT_LBL_V1 ?></th>
                <th><?php echo TXT_LBL_V2 ?></th>
                <th><?php echo TXT_LBL_V3 ?></th>
                <th><?php echo TXT_LBL_V4 ?></th>
                <th><?php echo TXT_LBL_SALDO ?></th>
            </tr>
            <?php
            $summen = array("m4" => 0, "m3" => 0, "m2" => 0, "m1" => 0, "m0" => 0, "rest" => 0, "v1" => 0, "v2" => 0, "v3" => 0, "v4" => 0, "saldo" => 0);
            foreach ($subkonten as $konto) {
                $summen["m4"] = $summen["m4"] + $konto->get_m4(TRUE);
                $summen["m3"] = $summen["m3"] + $konto->get_m3(TRUE);
                $summen["m2"] = $summen["m2"] + $konto->get_m2(TRUE);
                $summen["m1"] = $summen["m1"] + $konto->get_m1(TRUE);
                $summen["m0"] = $summen["m0"] + $konto->get_m0(TRUE);
                $summen["rest"] = $summen["rest"] + $konto->get_rest(TRUE);
                $summen["v1"] = $summen["v1"] + $konto->get_v1(TRUE);
                $summen["v2"] = $summen["v2"] + $konto->get_v2(TRUE);
                $summen["v3"] = $summen["v3"] + $konto->get_v3(TRUE);
                $summen["v4"] = $summen["v4"] + $konto->get_v4(TRUE);
                $summen["saldo"] = $summen["saldo"] + $konto->get_saldo(TRUE);
                ?>
                <tr>
                    <td style="text-align: right"><?php echo $konto->get_zahlart(); ?></td>
                    <td style="text-align: right"><?php echo $konto->get_m4(); ?></td>
                    <td style="text-align: right"><?php echo $konto->get_m3(); ?></td>
                    <td style="text-align: right"><?php echo $konto->get_m2(); ?></td>
                    <td style="text-align: right"><?php echo $konto->get_m1(); ?></td>
                    <td style="text-align: right"><?php echo $konto->get_m0(); ?></td>
                    <td style="text-align: right"><?php echo $konto->get_rest(); ?></td>
                    <td style="text-align: right"><?php echo $konto->get_v1(); ?></td>
                    <td style="text-align: right"><?php echo $konto->get_v2(); ?></td>
                    <td style="text-align: right"><?php echo $konto->get_v3(); ?></td>
                    <td style="text-align: right"><?php echo $konto->get_v4(); ?></td>
                    <td style="text-align: right"><?php echo $konto->get_saldo(); ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td style="text-align: right"><?php echo TXT_SUM; ?></td>
                <td style="text-align: right"><?php echo number_format($summen["m4"], 2, ',', '.'); ?></td>
                <td style="text-align: right"><?php echo number_format($summen["m3"], 2, ',', '.'); ?></td>
                <td style="text-align: right"><?php echo number_format($summen["m2"], 2, ',', '.'); ?></td>
                <td style="text-align: right"><?php echo number_format($summen["m1"], 2, ',', '.'); ?></td>
                <td style="text-align: right"><?php echo number_format($summen["m0"], 2, ',', '.'); ?></td>
                <td style="text-align: right"><?php echo number_format($summen["rest"], 2, ',', '.'); ?></td>
                <td style="text-align: right"><?php echo number_format($summen["v1"], 2, ',', '.'); ?></td>
                <td style="text-align: right"><?php echo number_format($summen["v2"], 2, ',', '.'); ?></td>
                <td style="text-align: right"><?php echo number_format($summen["v3"], 2, ',', '.'); ?></td>
                <td style="text-align: right"><?php echo number_format($summen["v4"], 2, ',', '.'); ?></td>
                <td style="text-align: right"><?php echo number_format($summen["saldo"], 2, ',', '.'); ?></td>
            </tr>
        </table>
    <?php } ?>
<?php } ?>