<h1><?php echo TXT_LBL_VERSICHERUNGEN ?></h1>

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
            <?php if (App::$CURRENT->has_permission("versicherung", "INS") && !$show_new && !$show_modify) {
                ?>
                <td>
                    <a <?php if ($show_new) echo "disabled" ?> class="button column" href="./index.php?site=versicherung&showNew=true"><?php echo TXT_LBL_NEW ?></a>
                </td>
                <?php }
            ?>
            <?php if ($show_new || $show_modify) { ?>
                <td> 
                    <input type="submit" value="<?php echo TXT_LBL_SAVE ?>" class="column" />
                    <a class="button column" href="./index.php?site=versicherung"><?php echo TXT_LBL_CANCEL ?></a>
                </td>
            <?php } ?>
        </tr>
    </table>

    <?php if (isset($cur_id)) { ?>
        <input type="hidden" name="cur_id" value="<?php echo $cur_id; ?>" />
    <?php } ?>

    <table class="designed">
        <tr>
            <?php if (App::$CURRENT->has_permission("versicherung", "UPD") ) { ?>
            <th align="center" style="width: 10px"></th>
            <?php } ?>
            <?php if (App::$CURRENT->has_permission("versicherung", "DEL") ) { ?>
            <th align="center" style="width: 10px"></th>
            <?php } ?>
            <th style="width: 50px"><?php echo TXT_LBL_VERS_VARIANTE ?></th>
            <th style="width: 400px"><?php echo TXT_LBL_VERS_BEZ ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_VERS_DAT_ABSCHLUSS ?></th>
            <th style="width: 150px"><?php echo TXT_LBL_VERS_USER_ABSCHLUSS ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_VERS_DAT_STORNO ?></th>
            <th style="width: 150px"><?php echo TXT_LBL_VERS_USER_STORNO ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_VERS_DAT_MELD_ABSCHLUSS ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_VERS_DAT_INFO_AEND_BED ?></th>
        </tr>

        <?php if ($show_new) { ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("versicherung", "UPD") ) { ?>
                <td></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("versicherung", "DEL") ) { ?>
                <td></td>
                <?php } ?>
                <td><input required name="versicherungsvariante" type="text" value="1" /></td>
                <td><input required name="versicherung_bezeichnung" style="min-width: 300px" type="text" value="" /></td>
                <td><input name="dat_abschluss"  type="date" value="" /></td>
                <td><input name="user_abschluss" style="min-width: 120px" type="text" value="" /></td>
                <td><input name="dat_storno"  type="date" value="" /></td>
                <td><input name="user_storno" style="min-width: 120px" type="text" value="" /></td>
                <td><input name="dat_meldung_abschluss"  type="date" value="" /></td>
                <td><input name="dat_info_aend_bed"  type="date" value="" /></td>
            </tr>
            <tr  style="line-height: 15px"  >
                <td >&nbsp;</td>
            </tr>
            <?php
        } else if ($show_modify && isset($modify)) {
            ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("versicherung", "UPD") ) { ?>
                <td></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("versicherung", "DEL") ) { ?>
                <td></td>
                <?php } ?>
                
                <td><input required name="versicherungsvariante" type="text" value="<?php echo $modify->get_versicherungsvariante() ?>" /></td>
                <td><input required name="versicherung_bezeichnung" style="min-width: 300px" type="text" value="<?php echo $modify->get_versicherung_bezeichnung() ?>" /></td>
                <td><input name="dat_abschluss"  type="date" value="<?php echo $modify->get_dat_abschluss() ?>" /></td>
                <td><input name="user_abschluss" style="min-width: 120px" type="text" value="<?php echo $modify->get_user_abschluss() ?>" /></td>
                <td><input name="dat_storno"  type="date" value="<?php echo $modify->get_dat_storno() ?>" /></td>
                <td><input name="user_storno" style="min-width: 120px" type="text" value="<?php echo $modify->get_user_storno() ?>" /></td>
                <td><input name="dat_meldung_abschluss"  type="date" value="<?php echo $modify->get_dat_meldung_abschluss() ?>" /></td>
                <td><input name="dat_info_aend_bed"  type="date" value="<?php echo $modify->get_dat_info_aend_bed() ?>" /></td>
                
            </tr>
            <tr  style="line-height: 15px"  >
                <td >&nbsp;</td>
            </tr>

            <?php
        }

        foreach ($versicherung as $item) {
            ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("versicherung", "UPD") ) { ?>
                <td align="center" style="" ><a href="./index.php?site=versicherung&showModify=true&modify_id=<?php echo $item->get_id(); ?>"><img src="../images/portal/<?php echo ICON_EDIT ?>" width="16px" height="16px" /></a></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("versicherung", "DEL") ) { ?>
                <td align="center"><a onclick="return AskDelete()" href="./index.php?site=versicherung&showDelete=true&modify_id=<?php echo $item->get_id(); ?>"><img src="../images/portal/<?php echo ICON_DELETE ?>" width="16px" height="16px" /></a></td>
                <?php } ?>
                <td><?php echo $item->get_versicherungsvariante(); ?></td>
                <td><?php echo $item->get_versicherung_bezeichnung(); ?></td>
                <td><?php echo $item->get_dat_abschluss(); ?></td>
                <td><?php echo $item->get_user_abschluss(); ?></td>
                <td><?php echo $item->get_dat_storno(); ?></td>
                <td><?php echo $item->get_user_storno(); ?></td>
                <td><?php echo $item->get_dat_meldung_abschluss(); ?></td>
                <td><?php echo $item->get_dat_info_aend_bed(); ?></td>
            </tr>
        <?php } ?>
    </table>
    <?php if (!$exists) { ?>
        <input type="hidden" value="INS" name="mode" />
    <?php } else { ?>
        <input type="hidden" value="<?php echo $cur_id ?>" name="edited_id" />
        <input type="hidden" value="UPD" name="mode" />
    <?php } ?>
    <input type="hidden" value="versicherung" name="site" />
    <input type="hidden" value="<?php echo $versicherung_id ?>" name="versicherung" />

</form>        

<div class="buttonset">
    <a href="index.php?site=versicherung&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=versicherung&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>

    <a href="index.php?site=versicherung&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>
</div>