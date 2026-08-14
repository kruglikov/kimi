<script lang="javascript">

    $(document).ready(function() {

        $("#sel_buchungsart").change(function() {

            $("#sel_buchungsgrund").find("option").remove();

            var $buchungsart = $("#sel_buchungsart").val();



            var entries = $("#hid_sel_buchungsgrund").find("option." + $buchungsart).clone();

            entries.eq(0).prop("selected", true);

            entries.appendTo("#sel_buchungsgrund");

        });



        var $buchungsart = $("#sel_buchungsart").val();

        var entries = $("#hid_sel_buchungsgrund").find("option." + $buchungsart).clone();

        entries.eq(0).prop("selected", true);

        entries.appendTo("#sel_buchungsgrund");

    });

</script>

<h1><?php echo TXT_LBL_SUBACC ?></h1>

<form method="POST" <?php if (!App::$CURRENT->has_permission("subverwalt", "UPD") && !App::$CURRENT->has_permission("subverwalt", "INS")) echo "disabled"; ?>>

    <table>

        <tr>

            <td><?php echo TXT_LBL_KDNR; ?></td>

            <td>

                <input type="text" value="<?php echo $kdnr ?>" placeholder="<?php echo TXT_LBL_KDNR; ?>" disabled />

                <input type="hidden" name="kdnr" value="<?php echo $kdnr ?>" />

            </td>

            <td></td>

            <td></td>

        </tr>

        <tr>

            <td><?php echo TXT_LBL_RNR ?></td>

            <td><input placeholder="<?php echo TXT_LBL_RNR ?>" required type="text" name="rechungsnummer" /></td>

            <td></td>

            <td></td>

        </tr>

        <tr>

            <td><?php echo TXT_LBL_ZA ?></td>

            <td>

                <select name="zahlart_id">

                    <?php foreach ($zahlarten as $item) { ?>

                        <option value="<?php echo $item->get_id(); ?>"><?php echo $item->get_text() ?></option>

                    <?php } ?>

                </select>

            </td>

            <td><?php echo TXT_LBL_ZINS ?></td>

            <td><input placeholder="<?php echo TXT_LBL_ZINS ?>" required type="text" name="zinssatz" /></td>

        </tr>

        <tr>

            <td><?php echo TXT_LBL_OPENED ?></td>

            <td><input placeholder="<?php echo TXT_LBL_OPENED ?>" required type="date" name="eroeffnet_am" /></td>

            <td><?php echo TXT_LBL_KW ?></td>

            <td><input placeholder="<?php echo TXT_LBL_KW ?>" required type="text" name="kaufwert" /></td>

        </tr>

        <tr>

            <td><?php echo TXT_LBL_RH ?></td>

            <td><input placeholder="<?php echo TXT_LBL_RH ?>" type="text" name="ratenhoehe" /></td>

            <td></td>

            <td></td>

        </tr>

        <tr>

            <td><?php echo TXT_LBL_BDAT ?></td>

            <td><input placeholder="<?php echo TXT_LBL_BDAT ?>" required type="date" name="buchungsdatum" /></td>

            <td></td>

            <td></td>

        </tr>

        <tr>

            <td><?php echo TXT_LBL_BART ?></td>

            <td>

                <select name="buchungsart_id" id="sel_buchungsart">

                    <?php foreach ($buchungsarten as $item) { ?>

                        <option value="<?php echo $item->get_id(); ?>"><?php echo $item->get_text() ?></option>

                    <?php } ?>

                </select>

            </td>

            <td><?php echo TXT_LBL_BUGRU ?></td>

            <td>

                <select required name="bua_bgr_man_id" id="sel_buchungsgrund">

                </select>

                <select class="hidden" id="hid_sel_buchungsgrund">

                    <?php foreach ($buchungsgruende as $item) { ?>

                        <option class="<?php echo $item->get_buchungsart_id(); ?>" value="<?php echo $item->get_bgr_man_id(); ?>"><?php echo $item->get_text() ?></option>

                    <?php } ?>

                </select>

            </td>

        </tr>

    </table>

    <h2><?php echo TXT_LBL_BETR ?></h2>

    <table class="designed">

        <tr>

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

        <tr>

            <td><input type="text" name="m4" /></td>

            <td><input type="text" name="m3" /></td>

            <td><input type="text" name="m2" /></td>

            <td><input type="text" name="m1" /></td>

            <td><input type="text" name="m0" /></td>

            <td><input type="text" name="rest" /></td>

            <td><input type="text" name="v1" /></td>

            <td><input type="text" name="v2" /></td>

            <td><input type="text" name="v3" /></td>

            <td><input type="text" name="v4" /></td>

            <td><input type="text" name="saldo" /></td>

        </tr>

    </table>

    <div class="buttonset">
        <?php if (App::$CURRENT->has_permission("subverwalt", "INS") ||
                App::$CURRENT->has_permission("subverwalt", "UPD")) {
            ?>

    <?php if ($new) { ?>

                <input type="hidden" name="mode" value="INS" />

    <?php } else { ?>

                <input type="hidden" name="mode" value="UPD" />

    <?php } ?>

            <input type="hidden" name="site" value="subverwalt" />

            <input type="submit" value="<?php echo TXT_LBL_SAVE ?>" class="column" />

            <a href="./index.php?site=subverwalt&kdnr=<?php echo $kdnr; ?>" class="column button"><?php echo TXT_LBL_RESET ?></a>

            <!--<a href="#" class="column button hidden">Löschen</a>-->
<?php } ?>
    </div>

</form>