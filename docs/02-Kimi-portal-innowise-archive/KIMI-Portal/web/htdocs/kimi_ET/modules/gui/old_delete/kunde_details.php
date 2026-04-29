<h2><?php echo TXT_LBL_CUSTOMER_DETAILS ?></h2>

<form action="index.php" method="post" <?php
if (!App::$CURRENT->has_permission("kunde_details", "UPD"))
    echo "disabled";?>>
    <input type="hidden" value="<?php echo $kunde->get_id() ?>" name="id" />
    <table>
        <tr>
            <td><?php echo TXT_LBL_KDNR ?></td>
            <td>
                <input required placeholder="<?php echo TXT_LBL_KDNR ?>" name="kdnr" class="column" type="text" value="<?php echo $kunde->get_kdnr() ?>" /> 
            </td>
            <td><?php echo TXT_LBL_KUNDENART ?></td>
            <td>
                <input required placeholder="<?php echo TXT_LBL_KUNDENART ?>" name="kundenart" class="column" type="text" value="<?php echo $kunde->get_kundenart() ?>" /> 
            </td>
            <td><?php echo TXT_LBL_MARKT ?></td>
            <td><input required placeholder="<?php echo TXT_LBL_MARKT ?>" name="markt" class="column" type="text" value="<?php echo $kunde->get_markt() ?>" /> </td>
            <td><?php echo TXT_LBL_ANLAGE ?></td>
            <td>
                <input required placeholder="<?php echo TXT_LBL_ANLAGE ?>" name="anlagedatum" class="column" type="date" value="<?php echo $kunde->get_anlagedatum() ?>" /> 
            </td>
        </tr>
        <tr>
            <td><?php echo TXT_LBL_PRIMAERKDNR ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_KDNR ?>" name="primaerkdnr" class="column" type="text" value="<?php echo $kunde->get_primaerkdnr() ?>" /> 
            </td>
            <td><?php echo TXT_LBL_ADRKENNER ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_ADRKENNER ?>" name="kenner" class="search" type="text" value="<?php echo $kunde->get_kenner() ?>" /> 
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><?php echo TXT_LBL_ANREDE ?></td>
            <td>
                <select required name="anrede_id" style="width: 100%;">
                    <?php
                    foreach ($anreden as $anrede) {
                        ?>
                        <option <?php
                        if ($kunde->get_anrede_id() == $anrede->get_id()) {
                            echo "selected";
                        }
                        ?> value="<?php echo $anrede->get_id() ?>"><?php echo $anrede->get_text() ?></option>
                            <?php
                        }
                        ?>
                </select>                
            </td>
            <td><?php echo TXT_LBL_TITEL ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_TITEL ?>" name="titel" class="search" type="text" value="<?php echo $kunde->get_titel() ?>" /> 

            </td>
            <td><?php echo TXT_LBL_ANREDE2 ?></td>
            <td>
                <select  name="anrede2_id" style="width: 100%;">
                    <?php
                    foreach ($anreden as $anrede2) {
                        ?>
                        <option <?php
                        if ($kunde->get_anrede2_id() == $anrede2->get_id()) {
                            echo "selected";
                        }
                        if (!isset($kunde_id) && $anrede2->get_text() == 'Keine') {
                            echo "selected";
                        }
                        ?> value="<?php echo $anrede2->get_id() ?>"><?php echo $anrede2->get_text() ?></option>
                            <?php
                        }
                        ?>
                </select>                
            </td>
            <td><?php echo TXT_LBL_TITEL2 ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_TITEL2 ?>" name="titel2" class="search" type="text" value="<?php echo $kunde->get_titel2() ?>" /> 
<!--                <select name="titel2_id" style="width: 100%;">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php
                    foreach ($titel as $t2) {
                        ?>
                        <option <?php
                        if ($kunde->get_titel2_id() == $t2->get_id()) {
                            echo "selected";
                        }
                        ?> value="<?php echo $t2->get_id() ?>"><?php echo $t2->get_text() ?></option>
                        <?php
                    }
                    ?>
                </select> -->
            </td>

            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><?php echo TXT_LBL_LASTNAME ?></td>
            <td>
                <input required placeholder="<?php echo TXT_LBL_LASTNAME ?>" name="nachname" class="column" type="text" value="<?php echo $kunde->get_nachname() ?>" />
            </td>
            <td><?php echo TXT_LBL_FIRSTNAME ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_FIRSTNAME ?>" name="vorname" class="column" type="text" value="<?php echo $kunde->get_vorname() ?>" /> 
            </td>
            <td><?php echo TXT_LBL_LASTNAME2 ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_LASTNAME2 ?>" name="nachname2" class="column" type="text" value="<?php echo $kunde->get_nachname2() ?>" />
            </td>
            <td><?php echo TXT_LBL_FIRSTNAME2 ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_FIRSTNAME2 ?>" name="vorname2" class="column" type="text" value="<?php echo $kunde->get_vorname2() ?>" /> 
            </td>
        </tr>
      
        <tr>
            <td><?php echo TXT_LBL_BIRTH ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_BIRTH ?>" name="geburtsdatum" class="search" type="date" value="<?php echo $kunde->get_geburtsdatum() ?>" /> 
            </td>
            <td></td>
            <td></td>
            <td><?php echo TXT_LBL_BIRTH2 ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_BIRTH2 ?>" name="geburtsdatum2" class="search" type="date" value="<?php echo $kunde->get_geburtsdatum2() ?>" /> 
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr></tr>
    </table>
    <hr>
    <table>
        <tr></tr>
        <tr>
            <td><?php echo TXT_LBL_STR ?></td>
            <td>
                <input required placeholder="<?php echo TXT_LBL_STR ?>" name="strasse" class="column" type="text" value="<?php echo $kunde->get_strasse() ?>" /> 
            </td>
            <td><?php echo TXT_LBL_HNR."/".TXT_LBL_HNR_EXTENDED ?></td>
            <td>
                <table class="columnSmall">
                    <tr>
                        <td>
                            <input required class="columnSmall" placeholder="<?php echo TXT_LBL_HNR ?>" name="hausnummer" type="text" value="<?php echo $kunde->get_hausnummer() ?>" /> 
                        </td>
                        <td>
                            <input class="columnSmall" placeholder="<?php echo TXT_LBL_HNR_EXTENDED ?>" name="hausnummer_erw" type="text" value="<?php echo $kunde->get_hausnummer_erw() ?>" />
                        </td>
                    </tr>
                </table>
            </td>

            <td><?php echo TXT_LBL_ADRZUSATZ ?></td>
            <td>
                <input  placeholder="<?php echo TXT_LBL_ADRZUSATZ ?>" name="adresszusatz" class="column" type="text" value="<?php echo $kunde->get_adresszusatz() ?>" /> 
            </td>
            <td></td>
            <td>
            </td>
        </tr>
        <tr>
            <td><?php echo TXT_LBL_ORT ?></td>
            <td>
                <table class="column">
                    <tr>
                        <td>
                            <select required name="land_id">
                                <?php
                                foreach ($laender as $land) {
                                    ?>
                                    <option <?php
                                    if ($kunde->get_land_id() == $land->get_id())
                                        echo "selected";
                                    ?> value="<?php echo $land->get_id() ?>"><?php echo $land->get_kurzzeichen() ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input required maxlength="50" placeholder="<?php echo TXT_LBL_PLZ ?>" name="plz" type="text" value="<?php echo $kunde->get_plz() ?>" /> 
                        </td>
                    </tr>
                </table>
            </td>
            <td><?php echo TXT_LBL_ORT ?></td>
            <td>
                <input required placeholder="<?php echo TXT_LBL_ORT ?>" name="ort" class="search" type="text" value="<?php echo $kunde->get_ort() ?>" />
            </td>
            <td><?php echo TXT_LBL_ORTSTEIL ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_ORTSTEIL ?>" name="ortsteil" class="search" type="text" value="<?php echo $kunde->get_ortsteil() ?>" />
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><?php echo TXT_LBL_TEL ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_TEL ?>" name="telefon" class="search" type="text" value="<?php echo $kunde->get_telefon() ?>" /> <br />
            </td>
            <td><?php echo TXT_LBL_EMAIL ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_EMAIL ?>" name="email" class="search" type="email" value="<?php echo $kunde->get_email() ?>" /> <br />
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <br>
    <input type="hidden" name="benutzer_id" value="1" />
    <input name="mandant_id" type="hidden" value="<?php echo App::$CURRENT->MANDANT->get_id() ?>" />
    <input type="hidden" name="site" id="site" value="kunde_details" />
<?php if (isset($kunde_id)) { ?>
        <input type="hidden" name="kunde" id="kunde" value="<?php echo $kunde_id ?>" />
<?php } ?>
    <input type="hidden" name="mode" id="mode" value="<?php echo $mode ?>" />
<?php
if (App::$CURRENT->has_permission("kunde_details", "INS")) {
    ?>
        <a class="button column" href="index.php?site=kunde_details&new=true"><?php echo TXT_LBL_NEW ?></a>
    <?php
}

if (App::$CURRENT->has_permission("kunde_details", "UPD")) {
    ?>
        <input type="submit" class="column" value="<?php echo TXT_LBL_SAVE ?>" />
    <?php } if ($mode != "INS" && isset($kunde_id) && App::$CURRENT->has_permission("kunde_details", "DEL")) { ?>
        <a class="confirm button column" href="index.php?site=kunde_details&id=<?php echo $kunde->get_id() ?>&mode=DEL"><?php echo TXT_LBL_DEL ?></a>
    <?php } ?>
</form>

