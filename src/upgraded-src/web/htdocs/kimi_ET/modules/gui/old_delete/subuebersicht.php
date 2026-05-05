<h1><?php echo TXT_LBL_SUBOVERVIEW ?></h1>
<form method="get">
    <table style="width: 100%">
        <tr>
            <td><?php echo TXT_LBL_KDNR; ?></td>
            <td>
                <input type="text" placeholder="<?php echo TXT_LBL_KDNR ?>" name="kundennummer" class="column" value="<?php if (isset($kunde)) echo $kunde->get_kdnr(); ?>" />
                <input type="hidden" name="kundennummer_backup" value="<?php if (isset($kunde)) echo $kunde->get_kdnr(); ?>" />
            </td>
            <td>
                <input type="hidden" name="site" value="subuebersicht" />
                <input type="submit" value="<?php echo TXT_LBL_SEARCH; ?>" />
            </td>
            <?php if (App::$CURRENT->has_permission("subverwalt", "INS") && isset($kunde)) { ?>
                <td><a href="./index.php?site=subverwalt&kdnr=<?php if (isset($kunde)) echo $kunde->get_kdnr(); ?>" class="button column"><?php echo TXT_LBL_NEW ?></a></td>
            <td style="width: 100%; text-align: right">
                <?php if (isset($subkonten) && count($subkonten) > 0 && !($show_tgz && CONF_TGZ_SHOWDETAILS && isset($sk_tgz) && count($sk_tgz["subkonten"]) > 0 )) { ?>
                    <a <?php if ($show_tgz) echo "disabled " ?> href="./index.php?site=subuebersicht&kdnr=<?php if (isset($kunde)) echo $kunde->get_kdnr(); ?>&TGZ=1" style="width: 200px" class="button column"><?php echo TXT_LBL_TGZ_SHOW ?></a>
                <?php } ?>
            </td>
            <?php } else { ?>
            <td> </td>
            <td style="width: 100%; text-align: right"> </td>
            <?php } ?>

        </tr>
    </table>
</form>

<?php if (isset($kunde)) { ?>
    <table class="designed-last">
        <tr>
            <th><?php echo TXT_LBL_LINK ?></th>
            <th><?php echo TXT_LBL_RECHNUNG ?></th>
            <th><?php echo TXT_LBL_ZA ?></th>
            <th><?php echo TXT_LBL_ZINS ?></th>
            <th><?php echo TXT_LBL_OPENED ?></th>
            <th><?php echo TXT_LBL_KW ?></th>
            <th><?php echo TXT_LBL_RH ?></th>
            <th><?php echo TXT_LBL_M4 ?></th>
            <th><?php echo TXT_LBL_M3 ?></th>
            <th><?php echo TXT_LBL_M2 ?></th>
            <th><?php echo TXT_LBL_M1 ?></th>
            <th><?php echo TXT_LBL_M0 ?></th>
            <th><?php echo TXT_LBL_REST ?></th>
            <th><?php echo TXT_LBL_SALDO ?></th>
            <th <?php if (!$show_tgz) echo "hidden " ?>> <?php echo TXT_LBL_TGZ ?></th>
            <th <?php if (!$show_tgz) echo "hidden " ?>> <?php echo TXT_LBL_TGZ_BUCH ?></th>
        </tr>

        <?php
        $summen = array("kaufwert" => 0.00, "ratenhoehe" => 0, "m4" => 0, "m3" => 0, "m2" => 0, "m1" => 0, "m0" => 0, "rest" => 0, "saldo" => 0, "tgz" => 0);
        $tgz_ids = array("id" => 0);
        $tgz_summen = array("tgz" => 0);
        $tgz_summen_buch = array("tgz" => 0);
        $n = 0;
        $idx_first_sk = -1;
        $tgz_sum_switch = 0;
        $sum_saldo = 0;

        // Zuerst Berechnung
        foreach ($subkonten as $item) {
            $summen["kaufwert"] = $summen["kaufwert"] + $item->get_kaufwert(TRUE);
            $summen["ratenhoehe"] = $summen["ratenhoehe"] + $item->get_ratenhoehe(TRUE);
            $summen["m4"] = $summen["m4"] + $item->get_m4(TRUE);
            $summen["m3"] = $summen["m3"] + $item->get_m3(TRUE);
            $summen["m2"] = $summen["m2"] + $item->get_m2(TRUE);
            $summen["m1"] = $summen["m1"] + $item->get_m1(TRUE);
            $summen["m0"] = $summen["m0"] + $item->get_m0(TRUE);
            $summen["rest"] = $summen["rest"] + $item->get_rest(TRUE);
            $summen["saldo"] = $summen["saldo"] + $item->get_saldo(TRUE);
            if (isset($sk_tgz["sk_lfdnr"][$item->get_sk_lfdnr()])) {
                $summen["tgz"] += round($sk_tgz["sk_lfdnr"][$item->get_sk_lfdnr()], 2);
                if ($item->get_saldo() == 0) {
                    $tgz_sum_switch += round($sk_tgz["sk_lfdnr"][$item->get_sk_lfdnr()], 2);
                    $tgz_ids[$n] = $item->get_sk_lfdnr();
                    $tgz_summen[$n] = round($sk_tgz["sk_lfdnr"][$item->get_sk_lfdnr()], 2);
                    $tgz_summen_buch[$n] = 0;
                } else {
                    if ($idx_first_sk == -1) {
                        $idx_first_sk = $n;
                    }
                    $tgz_ids[$n] = $item->get_sk_lfdnr();
                    $tgz_summen[$n] = round($sk_tgz["sk_lfdnr"][$item->get_sk_lfdnr()], 2);
                    $tgz_summen_buch[$n] = round($sk_tgz["sk_lfdnr"][$item->get_sk_lfdnr()], 2);
                    if ($tgz_sum_switch != 0) {
                        $tgz_summen_buch[$idx_first_sk] += $tgz_sum_switch;
                        $tgz_sum_switch = 0;
                    }
                }
                $n++;
            }
        }

        $n = 0;
        foreach ($subkonten as $item) {
            $n++;
            ?>
            <tr>
                <td>
                    <a href="index.php?site=subdetail&subkonto=<?php echo $item->get_id();?>"><?php echo TXT_LBL_LINKSKD; ?></a><?php echo ' - ';echo $n; ?>
                </td>
                <td><?php echo $item->get_rechnungsnummer(); ?></td>
                <td><?php echo $item->get_zahlart(); ?></td>
                <td style="text-align: right"><?php echo $item->get_zinssatz(); ?></td>
                <td><?php echo $item->get_eroeffnet_am(); ?></td>
                <td style="text-align: right"><?php echo $item->get_kaufwert(); ?></td>
                <td style="text-align: right"><?php echo $item->get_ratenhoehe(); ?></td>
                <td style="text-align: right"><?php echo $item->get_m4(); ?></td>
                <td style="text-align: right"><?php echo $item->get_m3(); ?></td>
                <td style="text-align: right"><?php echo $item->get_m2(); ?></td>
                <td style="text-align: right"><?php echo $item->get_m1(); ?></td>
                <td style="text-align: right"><?php echo $item->get_m0(); ?></td>
                <td style="text-align: right"><?php echo $item->get_rest(); ?></td>
                <td style="text-align: right"><?php echo $item->get_saldo(); ?></td>
                <?php if ($item->get_zahlart() == "RV" && isset($sk_tgz["sk_lfdnr"][$item->get_sk_lfdnr()])) { ?>
                    <?php if ($item->get_saldo() == 0 && $sk_tgz["sk_lfdnr"][$item->get_sk_lfdnr()] != 0) { ?>
                        <td  <?php if (!$show_tgz) echo "hidden " ?> style="text-align: right;color: red" ><?php echo number_format($sk_tgz["sk_lfdnr"][$item->get_sk_lfdnr()], 2, ',', '.'); ?></td>
                    <?php } else { ?>
                        <td  <?php if (!$show_tgz) echo "hidden " ?> style="text-align: right" ><?php echo number_format($sk_tgz["sk_lfdnr"][$item->get_sk_lfdnr()], 2, ',', '.'); ?></td>
                    <?php } ?>
                    <?php if ($n - 1 == $idx_first_sk && $tgz_summen_buch[$n - 1] != 0 && $tgz_summen_buch[$n - 1] != $sk_tgz["sk_lfdnr"][$item->get_sk_lfdnr()]) { ?>
                        <td  <?php if (!$show_tgz) echo "hidden " ?> style="text-align: right;color: blue" ><?php echo number_format($tgz_summen_buch[$n - 1], 2, ',', '.'); ?></td>
                    <?php } else { ?>
                        <td  <?php if (!$show_tgz) echo "hidden " ?> style="text-align: right" ><?php echo number_format($tgz_summen_buch[$n - 1], 2, ',', '.'); ?></td>
                    <?php } ?>
                <?php } else { ?>
                    <td>
                    </td>
                    <td>
                    </td>
                <?php } ?>
            </tr>
            <?php
        }
        ?>
        <?php
        if (isset($gessaldo)) {
            $sum_saldo = $gessaldo + $summen["tgz"];
        } else {
            $sum_saldo = 0;
        }
        $sum_cardif = 0;
        if ($sum_saldo > 0 && isset($stammdaten) && substr((string) $stammdaten->get_krsv(), 0, 1) == 1) {
            $sum_cardif = $sum_saldo / 100 * CONF_CARDIF_ZINSSATZ;
            $sum_cardif = number_format((float) round($sum_cardif, 2), 2, ',', '.');
        }

//        echo $sum_saldo;
//        exit;
        ?>
        <tr>
            <td>
            </td>
            <td><?php echo TXT_SUM; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: right"><?php echo number_format($summen["kaufwert"], 2, ',', '.'); ?></td>
            <td></td>
            <td style="text-align: right"><?php echo number_format($summen["m4"], 2, ',', '.'); ?></td>
            <td style="text-align: right"><?php echo number_format($summen["m3"], 2, ',', '.'); ?></td>
            <td style="text-align: right"><?php echo number_format($summen["m2"], 2, ',', '.'); ?></td>
            <td style="text-align: right"><?php echo number_format($summen["m1"], 2, ',', '.'); ?></td>
            <td style="text-align: right"><?php echo number_format($summen["m0"], 2, ',', '.'); ?></td>
            <td style="text-align: right"><?php echo number_format($summen["rest"], 2, ',', '.'); ?></td>
            <td style="text-align: right"><?php echo number_format($summen["saldo"], 2, ',', '.'); ?></td>
            <td <?php if (!$show_tgz) echo "hidden " ?> style="text-align: right"><?php echo number_format($summen["tgz"], 2, ',', '.'); ?></td>
            <td <?php if (!$show_tgz) echo "hidden " ?> style="text-align: right"><?php echo number_format($summen["tgz"], 2, ',', '.'); ?></td>
        </tr>
    </table>
<?php //&& $summen["tgz"] > 0 ?>
    <?php if ($show_tgz ) { ?>
        <table style="width: 100%">
            <tr>

                <td style="text-align: right">
                    <?php
                    if ($sum_cardif > 0) {
                        echo TXT_LBL_TGZ_CARDIF . " <b>" . $sum_cardif . "</b> (auf Basis " . $sum_saldo . ") " . TXT_LBL_TGZ_CARDIF2 . "&nbsp;&nbsp;";
                    }
                    ?>
                    <a href="./index.php?site=subuebersicht&kdnr=<?php if (isset($kunde)) echo $kunde->get_kdnr(); ?>&BUCHTGZ=1&TotalTgz=<?php echo round($summen["tgz"], 2); ?>&Summen=<?php echo implode("@", $tgz_summen_buch); ?>&SummenIDs=<?php echo implode("@", $tgz_ids); ?>" style="width: 200px" class="button column"><?php echo TXT_LBL_TGZ_BUCHEN ?></a>
                </td>
            </tr>
        </table>

    <?php } ?>

    <?php
    if ($show_tgz && CONF_TGZ_SHOWDETAILS && isset($sk_tgz) && count($sk_tgz["subkonten"]) > 0) {
        ?> <div class="space"></div><h2><?php echo TXT_LBL_TGZ_UEBERSICHT ?></h2>
        <?php
        foreach ($sk_tgz["subkonten"] as $item) {
            echo "<h3 style = 'margin-bottom:0;' >" . TXT_LBL_RECHNUNG . " " . $item[0]->get_rechnungsnummer() . "</h3>";
            ?>
            <table class="designed-last"  >
                <th style="width: 100px"><?php echo TXT_LBL_TGZ_DATUM ?> </th>
                <th style="width: 400px" ><?php echo TXT_LBL_BART ?> </th>
                <th style="width: 100px"><?php echo TXT_LBL_TGZ_BETRAG ?> </th>
                <th style="width: 70px"><?php echo TXT_LBL_TGZ_ZINSSATZ ?> </th>
                <th style="width: 100px"><?php echo TXT_LBL_TGZ_AUFGEL_ZINSEN ?> </th>
                <th style="width: 50px"><?php echo TXT_LBL_TGZ_TAGE ?> </th>
                <th style="width: 100px"><?php echo TXT_LBL_TGZ_SALDONEU ?> </th>
                <?php
                foreach ($item as $p) {
                    ?>
                    <tr>
                        <td> <?php echo $p->get_belegdatum(); ?>
                        </td>
                        <td> <?php
                            echo $p->get_bugru_key_om() . " " . $p->get_buart_text() . " " . $p->get_bugru_text();
                            ?>
                        </td>
                        <td style="text-align: right" > <?php
                            echo $p->get_negbuchungsbetrag();
                            ?>
                        </td>
                        <td style="text-align: right"> <?php
                            echo $p->get_zinssatz();
                            ?>
                        </td>
                        <td style="text-align: right"> <?php
                            echo $p->get_zinsen_aufgel();
                            ?>
                        </td>

                        <td style="text-align: right"> <?php
                            echo $p->get_tgz_tage();
                            ?>
                        </td>
                        <td style="text-align: right" > <?php
                            echo $p->get_saldo_neu();
                            ?>
                        </td>

                    </tr> 
                    <?php
                }
                ?>
                <tr>
                    <td></td>
                    <td><?php echo TXT_SUM; ?> </td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right"><?php echo number_format($sk_tgz["sk_lfdnr"][$p->get_sk_lfdnr()], 4, ',', '.'); ?> </td>
                    <td></td>
                    <td></td>
                </tr>

            </table> <?php
        }
    }
    ?>
<?php } ?>