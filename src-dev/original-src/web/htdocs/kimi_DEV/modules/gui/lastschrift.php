<h1><?php echo TXT_LBL_LASTSCHRIFTEN ?></h1>

<form action="index.php" method="get">

    <?php if (isset($kunde)) { ?>
        <input type="hidden" value="<?php echo $kunde->get_kdnr(); ?>" name="kundennummer_backup" />
    <?php } ?>
    <table>
        <tr>
            <td><?php echo TXT_LBL_KDNR ?></td>
            <td>
                <input disabled name="kundennummer" required placeholder="<?php echo TXT_LBL_KDNR ?>" name="kdnr" class="column" type="text" value="<?php if (isset($kunde)) echo $kunde->get_kdnr(); ?>" />
            </td>
            <td>
                <?php echo TXT_LBL_ANREDE ?>/<?php echo TXT_LBL_TITEL ?>
                <?php // <input type="submit" value="<?php echo TXT_LBL_SEARCH ?>
            </td>
            <td>
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
<hr>

<form method="post">
    <table>
        <tr>
            <?php if (App::$CURRENT->has_permission("lastschrift", "INS") && !$show_new && !$show_modify) {
                ?>
                <td>
                    <a <?php if ($show_new) echo "disabled" ?> class="button column" href="./index.php?site=lastschrift&showNew=true"><?php echo TXT_LBL_NEW ?></a>
                </td>
            <?php }
            ?>
            <?php if ($show_new || $show_modify) { ?>
                <td> 
                    <input type="submit" value="<?php echo TXT_LBL_SAVE ?>" class="column" />
                    <a class="button column" href="./index.php?site=lastschrift"><?php echo TXT_LBL_CANCEL ?></a>
                </td>
            <?php } ?>
        </tr>
    </table>

    <?php if (isset($cur_id)) { ?>
        <input type="hidden" name="cur_id" value="<?php echo $cur_id; ?>" />
    <?php } ?>

    <table class="designed">
        <tr>
            <?php if (App::$CURRENT->has_permission("lastschrift", "UPD")) { ?>
                <th align="center" style="width: 10px"></th>
            <?php } ?>
            <?php if (App::$CURRENT->has_permission("lastschrift", "DEL")) { ?>
                <th align="center" style="width: 10px"></th>
            <?php } ?>
            <th style="width: 100px"><?php echo TXT_LBL_LASTS_BLZ ?></th>
            <th style="width: 150px"><?php echo TXT_LBL_LASTS_IBAN ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_LASTS_KONTONR ?></th>
            <th style="width: 150px"><?php echo TXT_LBL_LASTS_KONTOINHABER ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_LASTS_KZ_LASTSCHRIFT ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_LASTS_DAT_LASTSCHRIFT ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_LASTS_DAT_UNTERSCHRIFT ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_LASTS_MAX_EINZBETRAG ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_LASTS_DAT_EINZBETRAG ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_LASTS_SEPA_SEQUENCE ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_LASTS_KZ_INAKTIV ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_LASTS_DAT_INAKTIV ?></th>
        </tr>

        <?php if ($show_new) { ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("lastschrift", "UPD")) { ?>
                    <td></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("lastschrift", "DEL")) { ?>
                    <td></td>
                <?php } ?>
                    <td><input required name="blz" type="text" value="" /></td>
                <td><input style="min-width: 150px" name="iban" type="text" value="" /></td>
                <td><input style="min-width: 100px" name="kontonummer"  type="texct" value="" /></td>
                <td><input required style="min-width: 150px" name="kontoinhaber"  type="text" value="" /></td>
                <td>
                    <select name="kz_lastschrift"  >
                        <option selected value="J"><?php echo TXT_LBL_JA ?></option>
                        <option value="N"><?php echo TXT_LBL_NEIN ?></option>
                    </select>
                </td>
                <td><input name="dat_lastschrift"  type="date" value="" /></td>
                <td><input name="dat_unterschrift"  type="date" value="" /></td>
                <td><input style="text-align: right;min-width: 120px;" name="max_einzbetrag"  type="text" value="0,00" /></td>
                <td><input name="dat_einzbetrag" type="date" value="" /></td>
                <td>
                    <select name="sepa_einzug_seuqence"  >
                        <option value=""></option>
                        <option value="<?php echo TXT_LBL_LASTS_FRST ?>"><?php echo TXT_LBL_LASTS_FRST ?></option>
                        <option value="<?php echo TXT_LBL_LASTS_RCUR ?>"><?php echo TXT_LBL_LASTS_RCUR ?></option>
                    </select>
                </td>
                <td>
                    <select name="kz_kzinaktiv"  >
                        <option value="J"><?php echo TXT_LBL_JA ?></option>
                        <option selected value=""><?php echo TXT_LBL_NEIN ?></option>
                    </select>
                </td>
                <td><input name="dat_inaktiv" type="date" value="" /></td>
            </tr>
            <tr  style="line-height: 15px"  >
                <td >&nbsp;</td>
            </tr>
            <?php
        } else if ($show_modify && isset($modify)) {
            ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("lastschrift", "UPD")) { ?>
                    <td></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("lastschrift", "DEL")) { ?>
                    <td></td>
                <?php } ?>
                <td><input required name="blz" type="text" value="<?php echo $modify->get_blz_bankleitzahl() ?>" /></td>
                <td><input style="min-width: 150px" name="iban"  type="text" value="<?php echo $modify->get_iban() ?>" /></td>
                <td><input style="min-width: 100px" name="kontonummer"  type="texct" value="<?php echo $modify->get_kontonummer() ?>" /></td>
                <td><input required style="min-width: 150px" name="kontoinhaber"  type="text" value="<?php echo $modify->get_kontoinhaber() ?>" /></td>
                <td>
                    <select name="kz_lastschrift"  >
                        <option <?php if ($modify->get_kz_lastschrift()=="J") { echo " selected "; } ?> value="J"><?php echo TXT_LBL_JA ?></option>
                        <option <?php if ($modify->get_kz_lastschrift()=="N") { echo " selected "; } ?> value="N"><?php echo TXT_LBL_NEIN ?></option>
                    </select>
                </td>
                <td><input name="dat_lastschrift"  type="date" value="<?php echo $modify->get_dat_lastschrift() ?>" /></td>
                <td><input name="dat_unterschrift"  type="date" value="<?php echo $modify->get_dat_unterschrift() ?>" /></td>
                <td><input style="text-align: right;min-width: 120px;" name="max_einzbetrag"  type="text" value="<?php echo $modify->get_max_einzbetrag() ?>" /></td>
                <td><input name="dat_einzbetrag" type="date" value="<?php echo $modify->get_dat_einzbetrag() ?>" /></td>
                <td>
                    <select name="sepa_einzug_sequenz"  >
                        <option <?php if ($modify->get_sepa_einzug_sequenz()=='') { echo " selected "; } ?> value=""></option>
                        <option <?php if ($modify->get_sepa_einzug_sequenz()==TXT_LBL_LASTS_FRST) { echo " selected "; } ?> value="<?php echo TXT_LBL_LASTS_FRST ?>"><?php echo TXT_LBL_LASTS_FRST ?></option>
                        <option <?php if ($modify->get_sepa_einzug_sequenz()==TXT_LBL_LASTS_RCUR) { echo " selected "; } ?> value="<?php echo TXT_LBL_LASTS_RCUR ?>"><?php echo TXT_LBL_LASTS_RCUR ?></option>
                    </select>
                </td>
                <td>
                    <select name="kz_kzinaktiv"  >
                        <option <?php if ($modify->get_kz_kzinaktiv()=='J') { echo " selected "; } ?> value="J"><?php echo TXT_LBL_JA ?></option>
                        <option <?php if ($modify->get_kz_kzinaktiv()!='J') { echo " selected "; } ?> value=""><?php echo TXT_LBL_NEIN ?></option>
                    </select>
                </td>
                <td><input name="dat_inaktiv" type="date" value="<?php echo $modify->get_dat_inaktiv() ?>" /></td>
                
                
                
            </tr>
            <tr  style="line-height: 15px"  >
                <td >&nbsp;</td>
            </tr>

            <?php
        }

        foreach ($lastschriften as $item) {
            ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("lastschrift", "UPD")) { ?>
                    <td align="center" style="" ><a href="./index.php?site=lastschrift&showModify=true&modify_id=<?php echo $item->get_id(); ?>"><img src="../images/portal/<?php echo ICON_EDIT ?>" width="16px" height="16px" /></a></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("lastschrift", "DEL")) { ?>
                    <td align="center"><a onclick="return AskDelete()" href="./index.php?site=lastschrift&showDelete=true&modify_id=<?php echo $item->get_id(); ?>"><img src="../images/portal/<?php echo ICON_DELETE ?>" width="16px" height="16px" /></a></td>
                <?php } ?>
                <td><?php echo $item->get_blz_bankleitzahl(); ?></td>
                <td><?php echo $item->get_iban(); ?></td>
                <td><?php echo $item->get_kontonummer(); ?></td>
                <td style="min-width: 100px"><?php echo $item->get_kontoinhaber(); ?></td>
                <td style="text-align: center"><?php if($item->get_kz_lastschrift() == "J") { echo TXT_LBL_JA; } else { echo TXT_LBL_NEIN;} ?></td>
                <td><?php echo $item->get_dat_lastschrift(); ?></td>
                <td><?php echo $item->get_dat_unterschrift(); ?></td>
                <td style="text-align: right"><?php echo $item->get_max_einzbetrag(); ?></td>
                <td><?php echo $item->get_dat_einzbetrag(); ?></td>
                <td><?php echo $item->get_sepa_einzug_sequenz(); ?></td>
                <td style="text-align: center"><?php if($item->get_kz_kzinaktiv() == "J") { echo TXT_LBL_JA; } else { echo TXT_LBL_NEIN;} ?></td>
                <td><?php echo $item->get_dat_inaktiv(); ?></td>
            </tr>
        <?php } ?>
    </table>
    <?php if (!$exists) { ?>
        <input type="hidden" value="INS" name="mode" />
    <?php } else { ?>
        <input type="hidden" value="<?php echo $cur_id ?>" name="edited_id" />
        <input type="hidden" value="UPD" name="mode" />
    <?php } ?>
    <input type="hidden" value="lastschrift" name="site" />
    <input type="hidden" value="<?php echo $lastschrift_id ?>" name="lastschrift" />

</form>        

<div class="buttonset">
    <a href="index.php?site=lastschrift&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=lastschrift&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>

    <a href="index.php?site=lastschrift&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>
</div>