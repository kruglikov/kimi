<h1><?php echo TXT_LBL_INKASSOINFORMATION ?></h1>

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
                <input type="hidden" name="site" value="inkassoinformation" />
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
                <td><input required disabled placeholder="<?php echo TXT_LBL_ORT ?>" name="ort" class="search" type="text" value="<?php echo $kunde->get_ort() ?>" /></td>
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
        <input type="hidden" name="id" value="<?php if (isset($stammdaten)) echo $stammdaten->get_id(); ?>" />
        <table>
            <tr>
                <td><?php echo TXT_LBL_ZAHLTAG ?></td>
                <td><input disabled <?php
                    if (isset($stammdaten)) {
                        echo "value=\"" . $stammdaten->get_zahltag() . "\"";
                    }
                    ?> type="date" placeholder="<?php echo TXT_LBL_ZAHLTAG ?>" name="zahltag" required /></td>
                <td><label for="mahnsperre"><?php echo TXT_LBL_MAHNSPERRE ?></label></td>
                <td><input disabled <?php
                    if (isset($stammdaten) && $stammdaten->get_mahnsperre() == "MS") {
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
                <td><input disabled <?php
                    if (isset($stammdaten)) {
                        echo "value=\"" . $stammdaten->get_stichtag() . "\"";
                    }
                    ?> type="date" required name="stichtag" /></td>
                <td><?php echo TXT_LBL_MAHNSPERR_DATUM ?></td>
                <td><input disabled <?php
                    if (isset($stammdaten)) {
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
            <?php if (App::$CURRENT->has_permission("inkassoinformation", "INS") && !$show_new && !$show_modify ) {
                ?>
            <td>
                <a <?php if ($show_new) echo "disabled" ?> class="button column" href="./index.php?site=inkassoinformation&showNew=true"><?php echo TXT_LBL_NEW ?></a>
            </td>
            <?php
            } ?>
            <?php if ($show_new || $show_modify) { ?>
                <td> 
                    <input type="submit" value="<?php echo TXT_LBL_SAVE ?>" class="column" />
                    <a class="button column" href="./index.php?site=inkassoinformation"><?php echo TXT_LBL_CANCEL ?></a>
                </td>
            <?php } ?>
        </tr>
    </table>

    <?php if (isset($cur_inkassoinformation_id)) { ?>
        <input type="hidden" name="cur_id" value="<?php echo $cur_inkassoinformation_id; ?>" />
    <?php } ?>

    <table class="designed">
        <tr>
            <th style="width: 10px"></th>
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

        <?php if ($show_new) { ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("inkassoinformation", "UPD") ) { ?>
                    <td></td>
                <?php } ?>

                <td>
                    <select name="inkassostatus_id"  >
                        <?php foreach ($ikstat as $p) { ?>
                            <option value="<?php echo $p->get_id() ?>"><?php echo $p->get_inkassostatus() . " " . $p->get_text() ?></option>
                        <?php } ?>
                    </select>

                </td>
                <td><input name="status_dat"  type="hidden" value="<?php echo date("d.m.Y H:i:s"); ?>" />
                    <input disabled name="status_datumdisplay" type="date" value="<?php echo date("d.m.Y H:i:s"); ?>" />
                </td>
                <td>
                    <select name="ra_ikbuero_id"  >
                        <option value="-1"><?php echo TXT_LBL_KEINES ?></option>
                        <?php foreach ($ikbueros as $p) { ?>
                            <?php if ($p->get_kz_aktiv()=='J') { ?>
                            <option value="<?php echo $p->get_id() ?>"><?php echo $p->get_ra_buero() . " " . $p->get_text() ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </td> 
                <td><input name="anz_uebergab" style="text-align: right" type="text" value="0" /></td>
                <td><input name="uebergabe_betrag" style="text-align: right" type="text" value="0,00" /></td>
                <td><input name="uebergabe_dat"  type="date" value="" /></td>
                <td><input name="uneinbringlich" style="text-align: right" type="text" value="0,00" /></td>
                <td><input name="dubiosenink" style="text-align: right" type="text" value="" /></td>
                <td><input name="uebetr_du" style="text-align: right" type="text" value="0,00" /></td>
                <td><input name="erl_du_dat"  type="date" value="" /></td>

                <td>
                    <select name="erled_qual_id"  >
                        <option value="-1"><?php echo TXT_LBL_KEINE ?></option>
                        <?php foreach ($erled_qual as $p) { ?>
                            <option value="<?php echo $p->get_id() ?>"><?php echo $p->get_erled_qual() . " " . $p->get_text() ?></option>
                        <?php } ?>
                    </select>
                </td> 
                <td><input name="erl_dat"  type="date" value="" /></td>
                <td>
                    <select name="ausbuchungsgrund_id"  >
                        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                        <?php foreach ($ausbuchungsgrund as $p) { ?>
                            <option value="<?php echo $p->get_id() ?>"><?php echo $p->get_ausbuch_grund() . " " . $p->get_text() ?></option>
                        <?php } ?>
                    </select>
                </td> 
                <td><input name="letzte_aenderung"  type="date" value="<?php echo date("d.m.Y"); ?>" /></td>
                <td><input style="min-width:200px" name="verwendungszweck" type="text" value="" /></td>
                <td></td>

            </tr>
            <tr  style="line-height: 15px"  >
                <td >&nbsp;</td>
            </tr>

            <?php
        }
        
        else if ($show_modify && isset ($inkasso_modify) ) { ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("inkassoinformation", "UPD") ) { ?>
                    <td></td>
                <?php } ?>

                <td>
                    <select name="inkassostatus_id"  >
                        <?php foreach ($ikstat as $p) { ?>
                            <option <?php if ($inkasso_modify->get_inkassostatus_id()==$p->get_id()) echo " selected "?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_inkassostatus() . " " . $p->get_text() ?></option>
                        <?php } ?>
                    </select>

                </td>
                <td><input name="status_dat"  type="hidden" value="<?php echo date("d.m.Y H:i:s"); ?>" />
                    <input disabled name="status_datumdisplay" type="text" value="<?php echo date("d.m.Y H:i:s");; ?>" />
                </td>
                <td>
                    <select name="ra_ikbuero_id"  >
                        <option value="-1"><?php echo TXT_LBL_KEINES ?></option>
                        <?php foreach ($ikbueros as $p) { ?>
                            <?php if ($p->get_kz_aktiv()=='J') { ?>
                                <option <?php if ($inkasso_modify->get_ra_ikbuero_id()==$p->get_id()) echo " selected "?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_ra_buero() . " " . $p->get_text() ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </td> 
                <td><input name="anz_uebergab" style="text-align: center" type="text" value="<?php echo $inkasso_modify->get_anz_uebergab(); ?>" /></td>
                <td><input name="uebergabe_betrag" style="text-align: right" type="text" value="<?php echo $inkasso_modify->get_uebergabe_betrag() ?>" /></td>
                <td><input name="uebergabe_dat"  type="date" value="<?php echo $inkasso_modify->get_uebergabe_dat(); ?>" /></td>
                <td><input name="uneinbringlich" style="text-align: right" type="text" value="<?php echo $inkasso_modify->get_uneinbringlich(); ?> " /></td>
                <td><input name="dubiosenink" style="text-align: center" type="text" value="<?php echo $inkasso_modify->get_dubiosenink(); ?>" /></td>
                <td><input name="uebetr_du" style="text-align: right" type="text" value="<?php echo $inkasso_modify->get_uebetr_du(); ?>" /></td>
                <td><input name="erl_du_dat"  type="date" value="<?php echo $inkasso_modify->get_erl_du_dat(); ?>" /></td>

                <td>
                    <select name="erled_qual_id"  >
                        <option value="-1"><?php echo TXT_LBL_KEINE ?></option>
                        <?php foreach ($erled_qual as $p) { ?>
                            <option <?php if ($inkasso_modify->get_erled_qual_id() == $p->get_id()) echo " selected";?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_erled_qual() . " " . $p->get_text() ?></option>
                        <?php } ?>
                    </select>
                </td> 
                <td><input name="erl_dat"  type="date" value="<?php echo $inkasso_modify->get_erl_dat(); ?>" /></td>
                <td>
                    <select name="ausbuchungsgrund_id"  >
                        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                        <?php foreach ($ausbuchungsgrund as $p) { ?>
                            <option <?php if ($inkasso_modify->get_ausbuchungsgrund_id()==$p->get_id()) echo " selected "?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_ausbuch_grund() . " " . $p->get_text() ?></option>
                        <?php } ?>
                    </select>
                </td> 
                <td><input  name="letzte_aenderung"  type="date" value="<?php echo $inkasso_modify->get_letzte_aenderung(); ?>" /></td>
                <td><input style="min-width:200px" name="verwendungszweck" type="text" value="<?php echo $inkasso_modify->get_verwendungszweck(); ?>" /></td>
                <td></td>
            </tr>
            <tr  style="line-height: 15px"  >
                <td >&nbsp;</td>
            </tr>

            <?php
        }

        foreach ($inkassoinfo as $item) {
            ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("inkassoinformation", "UPD") ) { ?>
                    <td align="center" style="" ><a href="./index.php?site=inkassoinformation&showModify=true&modify_id=<?php echo $item->get_id(); ?>"><img src="../images/portal/<?php echo ICON_EDIT ?>" width="16px" height="16px" /></a></td>
                <?php } else {?>
                    <td></td>
                <?php } ?>
                <td><?php echo $item->get_inkassostatus() . " " . $item->get_ikstat_text(); ?></td>
                <td style="text-align: center"><?php echo $item->get_status_dat(); ?></td>
                <td><?php echo $item->get_ra_buero() . " " . $item->get_rab_text(); ?></td>
                <td style="text-align: center"><?php echo $item->get_anz_uebergab(); ?></td>
                <td style="text-align: right"><?php echo $item->get_uebergabe_betrag(); ?></td>
                <td style="text-align: center"><?php echo $item->get_uebergabe_dat(); ?></td>
                <td style="text-align: right"><?php echo $item->get_uneinbringlich(); ?></td>
                <td><?php echo $item->get_dubiosenink(); ?></td>
                <td style="text-align: right"><?php echo $item->get_uebetr_du(); ?></td>
                <td style="text-align: center"><?php echo $item->get_erl_du_dat(); ?></td>
                <td><?php echo $item->get_erled_qual() . " " . $item->get_erl_text(); ?></td>
                <td style="text-align: center"><?php echo $item->get_erl_dat(); ?></td>
                <td><?php echo $item->get_ausbuch_grund() . " " . $item->get_ausbuch_text(); ?></td>
                <td style="text-align: center"><?php echo $item->get_letzte_aenderung(); ?></td>
                <td><?php echo $item->get_verwendungszweck() ?></td>
                <td hidden><?php echo $item->get_id(); ?></td>
            </tr>
        <?php } ?>
    </table>
    <?php if (!$exists) { ?>
        <input type="hidden" value="INS" name="mode" />
    <?php } else { ?>
        <input type="hidden" value="<?php echo $cur_inkassoinformation_id ?>" name="edited_id" />
        <input type="hidden" value="UPD" name="mode" />
    <?php } ?>
    <input type="hidden" value="inkassoinformation" name="site" />
    <input type="hidden" value="<?php echo $inkassoinformation_id ?>" name="inkassoinformation" />

</form>        

<div class="buttonset">
    <a href="index.php?site=inkassoinformation&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=inkassoinformation&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>

    <a href="index.php?site=inkassoinformation&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>
</div>