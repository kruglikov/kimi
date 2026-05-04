<h1><?php echo TXT_LBL_BANKEN ?></h1>

<form method="get">
    <table>
        <tr>
            <td><?php echo TXT_LBL_BANK_BLZ; ?></td>
            <td>
                <input type="text" placeholder="<?php echo TXT_LBL_BANK_BLZ ?>" name="sblz" class="column" value="<?php echo $sblz; ?>" />
            </td>
            <td>
            <td><?php echo TXT_LBL_BANK_BANK ?></td>
            </td>
            <td>
                <input type="text" placeholder="<?php echo TXT_LBL_BANK_BANK ?>" name="sbank" class="column" value="<?php echo $sbank; ?>" />
            </td>
            <td>
                <input type="hidden" name="site" value="bankleitzahl" />
                <input type="submit" value="<?php echo TXT_LBL_SEARCH; ?>" />
            </td>
        </tr>
    </table>
</form>

<hr>

<form method="post">
    <table>
        <tr>
            <?php if (App::$CURRENT->has_permission("bankleitzahl", "INS")  && !$show_new && !$show_modify) {
                ?>
                <td>
                    <a <?php if ($show_new) echo "disabled" ?> class="button column" href="./index.php?site=bankleitzahl&showNew=true"><?php echo TXT_LBL_NEW ?></a>
                </td>
                <?php }
            ?>
            <?php if ($show_new || $show_modify) { ?>
                <td> 
                    <input type="submit" value="<?php echo TXT_LBL_SAVE ?>" class="column" />
                    <a class="button column" href="./index.php?site=bankleitzahl"><?php echo TXT_LBL_CANCEL ?></a>
                </td>
            <?php } ?>
        </tr>
    </table>

    <?php if (isset($cur_id)) { ?>
        <input type="hidden" name="cur_id" value="<?php echo $cur_id; ?>" />
    <?php } ?>

    <table class="designed">
        <tr>
            <?php if (App::$CURRENT->has_permission("bankleitzahl", "UPD") ) { ?>
            <th align="center" style="width: 10px"></th>
            <?php } ?>
            <?php if (App::$CURRENT->has_permission("bankleitzahl", "DEL") ) { ?>
            <th align="center" style="width: 10px"></th>
            <?php } ?>
            <th style="width: 50px"><?php echo TXT_LBL_BANK_BLZ ?></th>
            <th style="width: 400px"><?php echo TXT_LBL_BANK_BANK ?></th>
            <th style="width: 100px"><?php echo TXT_LBL_BANK_BIC ?></th>
            <th style="width: 500px"><?php echo TXT_LBL_BANK_KZ_SEPA_FAEHIG ?></th>
        </tr>

        <?php if ($show_new) { ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("bankleitzahl", "UPD") ) { ?>
                <td></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("bankleitzahl", "DEL") ) { ?>
                <td></td>
                <?php } ?>
                <td><input name="blz" type="text" value="" /></td>
                <td><input name="bank" style="min-width: 300%" type="text" value="" /></td>
                <td><input name="bic" type="text" value="" /></td>
                <td>
                    <select  name="kz_sepa_faehig" >
                        <option value="N"><?php echo TXT_LBL_NEIN ?></option>
                        <option selected value="J"><?php echo TXT_LBL_JA ?></option>
                    </select>
                </td>
            </tr>
            <tr  style="line-height: 15px"  >
                <td >&nbsp;</td>
            </tr>
            <?php
        } else if ($show_modify && isset($modify)) {
            ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("bankleitzahl", "UPD") ) { ?>
                <td></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("bankleitzahl", "DEL") ) { ?>
                <td></td>
                <?php } ?>
                <td><input name="blz" type="text" value="<?php echo $modify->blz ?>" /></td>
                <td><input name="bank" style="min-width: 300%" type="text" value="<?php echo $modify->bank ?>" /></td>
                <td><input name="bic" type="text" value="<?php echo $modify->bic ?>" /></td>
                <td>
                    <select  name="kz_sepa_faehig" >
                        <option value="N"><?php echo TXT_LBL_NEIN ?></option>
                        <option <?php if ($modify->kz_sepa_faehig == 'J') { echo " selected "; } ?> value="J"><?php echo TXT_LBL_JA ?></option>
                    </select>
                </td>
            </tr>
            <tr  style="line-height: 15px"  >
                <td >&nbsp;</td>
            </tr>

            <?php
        }

        if (isset($bankleitzahl) && count($bankleitzahl)> 0) {
        foreach ($bankleitzahl as $item) {
            ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("bankleitzahl", "UPD") ) { ?>
                <td align="center" style="" ><a href="./index.php?site=bankleitzahl&showModify=true&modify_id=<?php echo $item->get_id(); ?>"><img src="../images/portal/<?php echo ICON_EDIT ?>" width="16px" height="16px" /></a></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("bankleitzahl", "DEL") ) { ?>
                <td align="center"><a onclick="return AskDelete()" href="./index.php?site=bankleitzahl&showDelete=true&modify_id=<?php echo $item->get_id(); ?>"><img src="../images/portal/<?php echo ICON_DELETE ?>" width="16px" height="16px" /></a></td>
                <?php } ?>
                <td><?php echo $item->get_blz(); ?></td>
                <td><?php echo $item->get_bank(); ?></td>
                <td><?php echo $item->get_bic(); ?></td>
                <td><?php if ($item->get_kz_sepa_faehig() == 'J') { echo TXT_LBL_JA; } else { echo TXT_LBL_NEIN; } ?></td>
            </tr>
        <?php } } ?>
    </table>
    <?php if (!$exists) { ?>
        <input type="hidden" value="INS" name="mode" />
    <?php } else { ?>
        <input type="hidden" value="<?php echo $cur_id ?>" name="edited_id" />
        <input type="hidden" value="UPD" name="mode" />
    <?php } ?>
    <input type="hidden" value="bankleitzahl" name="site" />
   

</form>        

<div class="buttonset">
    <a href="index.php?site=bankleitzahl&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=bankleitzahl&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>

    <a href="index.php?site=bankleitzahl&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>
</div>