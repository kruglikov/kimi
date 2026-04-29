<h1><?php echo TXT_LBL_KUNDENHISTORIE ?></h1>

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
            <?php if (App::$CURRENT->has_permission("kundenhistorie", "INS") && !$show_new && !$show_modify ) {
                ?>
            <td>
                <a <?php if ($show_new) echo "disabled" ?> class="button column" href="./index.php?site=kundenhistorie&showNew=true"><?php echo TXT_LBL_NEW ?></a>
            </td>
            <?php
            } ?>
            <?php if ($show_new || $show_modify) { ?>
                <td> 
                    <input type="submit" value="<?php echo TXT_LBL_SAVE ?>" class="column" />
                    <a class="button column" href="./index.php?site=kundenhistorie"><?php echo TXT_LBL_CANCEL ?></a>
                </td>
            <?php } ?>
        </tr>
    </table>

    <?php if (isset($cur_kundenhistorie_id)) { ?>
        <input type="hidden" name="cur_id" value="<?php echo $cur_kundenhistorie_id; ?>" />
    <?php } ?>

    <table class="designed">
        <tr>
            <th style="width: 200px"><?php echo TXT_LBL_KHISTBENUTZER1 ?></th>            
            <th style="width: 500px"><?php echo TXT_LBL_KHISTTEXT ?></th>            
            <th style="width: 200px"><?php echo TXT_LBL_KHISTKAT ?></th>
            <th style="width: 200px"><?php echo TXT_LBL_KHISTANSTOSS ?></th>
            <th style="width: 150px"><?php echo TXT_LBL_KHISTGEAENDERTAM ?></th>
            <th style="width: 200px"><?php echo TXT_LBL_KHISTBENUTZER2 ?></th>
            <th style="width: 200px"><?php echo TXT_LBL_KHISTBENUTZERDEVIS ?></th>
            <th style="display: none" ></th>
        </tr>
        <?php if ($show_new) { ?>
            <tr>
                <td>
                    <select disabled name="benutzer_id1"  >
                        <?php foreach ($ben as $p) { ?>
                            <option <?php if ($p->_get_name() == App::$CURRENT->USER->get_name(TRUE)) echo " selected "; ?> value="<?php echo $p->_get_id() ?>"><?php echo $p->_get_name();  ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input style="min-width: 350px" maxlength="200"  class="columnLarge" type="text" required name="text" value="" />
                </td>
                <td>
                    <select name="kategorie_id"  >
                        <option value="-1"><?php echo TXT_LBL_KEINE ?></option>
                        <?php foreach ($kategorie as $p) { ?>
                            <option value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                        <?php } ?>
                    </select>
                </td> 
                <td>
                    <select name="anstoss_id"  >
                        <option value="-1"><?php echo TXT_LBL_KEIN ?></option>
                        <?php foreach ($anstoss as $p) { ?>
                            <option value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                        <?php } ?>
                    </select>
                </td> 
                <td><input disabled name="geaendert_am" type="text" value="<?php echo date("d.m.Y H:i:s"); ?>" /></td>
                <td>
                    <select name="benutzer_id2"  >
                        <?php foreach ($ben as $p) { ?>
                            <option <?php if ($p->_get_name() == App::$CURRENT->USER->get_name(TRUE)) echo " selected "; ?> value="<?php echo $p->_get_id() ?>"><?php echo $p->_get_name();  ?></option>
                        <?php } ?>
                    </select>

                </td>
                <td><input name="benutzer_devis" type="text" value="" /></td>

                <td></td>
            </tr>
            <tr  style="line-height: 15px"  >
                <td >&nbsp;</td>
            </tr>

            <?php
        }

        foreach ($kundenhistorie as $item) {
            ?>
            <tr>
                <td><?php echo $item->get_benutzer1_name(); ?></td>
                <td><?php echo $item->get_text(); ?></td>
                <td><?php echo $item->get_kategorie_text(); ?></td>
                <td><?php echo $item->get_anstoss_text(); ?></td>
                <td><?php echo $item->get_geaendert_am(); ?></td>
                <td><?php echo $item->get_benutzer2_name(); ?></td>
                <td><?php echo $item->get_benutzer_devis(); ?></td>
                <td hidden><?php echo $item->get_id(); ?></td>
            </tr>
        <?php } ?>
    </table>
    <?php if (!$exists) { ?>
        <input type="hidden" value="INS" name="mode" />
    <?php } else { ?>
        <input type="hidden" value="<?php echo $cur_kundenhistorie_id ?>" name="edited_id" />
        <input type="hidden" value="UPD" name="mode" />
    <?php } ?>
    <input type="hidden" value="kundenhistorie" name="site" />
    <input type="hidden" value="<?php echo $kundenhistorie_id ?>" name="kundenhistorie" />

</form>        

<div class="buttonset">
    <a href="index.php?site=kundenhistorie&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=kundenhistorie&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>

    <a href="index.php?site=kundenhistorie&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>
</div>