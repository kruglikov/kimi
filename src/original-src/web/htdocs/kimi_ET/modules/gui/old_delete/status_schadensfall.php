<h1><?php echo TXT_LBL_VW_STATUSSCHADENSFALL ?></h1>

<hr>

<form method="post">
    <table>
        <tr>
            <?php if (App::$CURRENT->has_permission("status_schadensfall", "INS") && !$show_new && !$show_modify) {
                ?>
                <td>
                    <a <?php if ($show_new) echo "disabled" ?> class="button column" href="./index.php?site=status_schadensfall&showNew=true"><?php echo TXT_LBL_NEW ?></a>
                </td>
                <?php }
            ?>
            <?php if ($show_new || $show_modify) { ?>
                <td> 
                    <input type="submit" value="<?php echo TXT_LBL_SAVE ?>" class="column" />
                    <a class="button column" href="./index.php?site=status_schadensfall"><?php echo TXT_LBL_CANCEL ?></a>
                </td>
            <?php } ?>
        </tr>
    </table>

    <?php if (isset($cur_id)) { ?>
        <input type="hidden" name="cur_id" value="<?php echo $cur_id; ?>" />
    <?php } ?>

    <table class="designed">
        <tr>
            <?php if (App::$CURRENT->has_permission("status_schadensfall", "UPD") ) { ?>
            <th align="center" style="width: 10px"></th>
            <?php } ?>
            <?php if (App::$CURRENT->has_permission("status_schadensfall", "DEL") ) { ?>
            <th align="center" style="width: 10px"></th>
            <?php } ?>
            <th style="width: 50px"><?php echo TXT_LBL_ID ?></th>
            <th style="width: 50px"><?php echo TXT_LBL_TEXTKURZ ?></th>
            <th style="width: 400px"><?php echo TXT_LBL_TEXT ?></th>
        </tr>

        <?php if ($show_new) { ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("status_schadensfall", "UPD") ) { ?>
                <td></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("status_schadensfall", "DEL") ) { ?>
                <td></td>
                <?php } ?>
                <td></td>
                <td><input name="kurz_text" type="text" value="" /></td>
                <td><input name="text" style="min-width: 95%" type="text" value="" /></td>
            </tr>
            <tr  style="line-height: 15px"  >
                <td >&nbsp;</td>
            </tr>
            <?php
        } else if ($show_modify && isset($modify)) {
            ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("status_schadensfall", "UPD") ) { ?>
                <td></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("status_schadensfall", "DEL") ) { ?>
                <td></td>
                <?php } ?>
                <td><?php echo $modify->id; ?></td>
                <td><input name="kurz_text" type="text" value="<?php echo $modify->kurz_text ?>" /></td>
                <td><input name="text" type="text" style="min-width: 95%" value="<?php echo $modify->text ?>" /></td>
            </tr>
            <tr  style="line-height: 15px"  >
                <td >&nbsp;</td>
            </tr>

            <?php
        }

        foreach ($status_schadensfall as $item) {
            ?>
            <tr>
                <?php if (App::$CURRENT->has_permission("status_schadensfall", "UPD") ) { ?>
                <td align="center" style="" ><a href="./index.php?site=status_schadensfall&showModify=true&modify_id=<?php echo $item->get_id(); ?>"><img src="../images/portal/<?php echo ICON_EDIT ?>" width="16px" height="16px" /></a></td>
                <?php } ?>
                <?php if (App::$CURRENT->has_permission("status_schadensfall", "DEL") ) { ?>
                <td align="center"><a onclick="return AskDelete()" href="./index.php?site=status_schadensfall&showDelete=true&modify_id=<?php echo $item->get_id(); ?>"><img src="../images/portal/<?php echo ICON_DELETE ?>" width="16px" height="16px" /></a></td>
                <?php } ?>

                <td><?php echo $item->get_id(); ?></td>
                <td><?php echo $item->get_kurz_text(); ?></td>
                <td><?php echo $item->get_text(); ?></td>
            </tr>
        <?php } ?>
    </table>
    <?php if (!$exists) { ?>
        <input type="hidden" value="INS" name="mode" />
    <?php } else { ?>
        <input type="hidden" value="<?php echo $cur_id ?>" name="edited_id" />
        <input type="hidden" value="UPD" name="mode" />
    <?php } ?>
    <input type="hidden" value="status_schadensfall" name="site" />
    <input type="hidden" value="<?php echo $status_schadensfall_id ?>" name="status_schadensfall" />

</form>        

<div class="buttonset">
    <a href="index.php?site=status_schadensfall&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=status_schadensfall&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>

    <a href="index.php?site=status_schadensfall&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>
</div>