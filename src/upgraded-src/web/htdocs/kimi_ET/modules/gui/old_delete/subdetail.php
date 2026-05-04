<h1><?php echo TXT_LBL_SUBDETAILS ?></h1>
<script type="text/javascript">

    function toNumber(value) {
        var retval = value.replace(".", "");
        retval = retval.replace(",", ".");
        if (retval == "") {
            retval = 0
        }
        return parseFloat(retval);
    }

    function toStr(value) {
        return value.toLocaleString("de-DE");
    }

    function ValidateSubmit() {
        var m0 = toNumber(document.getElementById('m0').value);
        var m1 = toNumber(document.getElementById('m1').value);
        var m2 = toNumber(document.getElementById('m2').value);
        var m3 = toNumber(document.getElementById('m3').value);
        var m4 = toNumber(document.getElementById('m4').value);
        var rest = toNumber(document.getElementById('rest').value);
        var saldo = toNumber(document.getElementById('saldo').value);
        var sum_topf = 0;
        sum_topf = m0 + m1 + m2 + m3 + m4 + rest;
        sum_topf = sum_topf.toFixed(2);
        if (sum_topf != saldo) {
            alert('<?php echo TXT_ERR_SK_SALDO_TOEPFE ?>');
            return false;
        }
        return true;
    }

    function EnableDisableFromBuGru() {

        var bugru = document.getElementById('bua_bgr_man_id').value;
        var selindex = document.getElementById('bua_bgr_man_id').selectedIndex;
        var bugru_berechnung = document.getElementById('bua_bgr_man_id').options[selindex].title;
        var searchFor = ',' + bugru.substring(bugru, bugru.length - 4, 4) + ',';
        var betrag = document.getElementById('buchungsbetrag');
        var zahlart = document.getElementById('zahlart_id').value;
        var eCalc = document.getElementById('btn_calc');
        var betrag_offen = document.getElementById('betrag_offen');
        var searchFrom = ',<?php echo CONF_SKBUCH_CLEAR_BETRAG ?>,';
        var searchFromNRate = ',<?php echo CONF_SKBUCH_ENABLE_BTN_NRATE ?>,';
        var searchFromMahnGeb = ',<?php echo CONF_SKBUCH_ENABLE_BTN_MAHNGEB ?>,';
        var modus = 0;

        eCalc.value = '<?php echo TXT_LBL_SK_BTN_CALC ?>';
        betrag_offen.value = "0,00";

        var EnableCalc = false;

        if (searchFrom.search(searchFor) >= 0) {
            betrag.value = "0,00";
            //betrag.disabled = true;
        }
        else {
            betrag.disabled = false;
        }

        if (searchFromNRate.search(searchFor) >= 0 && zahlart != 1) {
            EnableCalc = true;
            modus = 1;
            eCalc.value = '<?php echo TXT_LBL_SK_BTN_NRATE ?>';
            eCalc.title = '<?php echo TXT_LBL_SK_BTN_NRATE_HINT ?>';
        }
        if (searchFromMahnGeb.search(searchFor) >= 0 && zahlart != 1) {
            EnableCalc = true;
            modus = 2;
            eCalc.value = '<?php echo TXT_LBL_SK_BTN_MAHNGEB ?>';
            eCalc.title = '<?php echo TXT_LBL_SK_BTN_MAHNGEB_HINT ?>';
        }
        if (modus == 0 && bugru_berechnung == 'P') {
            modus = 3;
            EnableCalc = true;
            eCalc.value = '<?php echo TXT_LBL_SK_BTN_ZAHLUNG_TOPF ?>';
            eCalc.title = '<?php echo TXT_LBL_SK_BTN_ZAHLUNG_TOPF_HINT ?>';
        }

        eCalc.disabled = !EnableCalc;
        document.getElementById('modus_btn_calc').value = modus;

        return true;

        if (EnableCalc) {
            eCalc.style.visibility = 'visible';
        } else {
            eCalc.style.visibility = 'hidden';
        }
        return true;
    }

    function btn_calc_click() {
        var betrag = toNumber(document.getElementById('buchungsbetrag').value);
        var bugru = document.getElementById('bua_bgr_man_id').value;
        var modus = document.getElementById('modus_btn_calc').value;
        var eCalc = document.getElementById('btn_calc');
        var betrag_offen = document.getElementById('betrag_offen');
        var zahlart = document.getElementById('zahlart_id').value;

        var m0 = toNumber(document.getElementById('m0').value);
        var m1 = toNumber(document.getElementById('m1').value);
        var m2 = toNumber(document.getElementById('m2').value);
        var m3 = toNumber(document.getElementById('m3').value);
        var m4 = toNumber(document.getElementById('m4').value);
        var bukz = toNumber(document.getElementById('buchungskennzeichen').value);
        var rest = toNumber(document.getElementById('rest').value);
        var saldo = toNumber(document.getElementById('saldo').value);
        var ratenhoehe = toNumber(document.getElementById('ratenhoehe').value);
        var offen = 0;
        var rate_offen = 0;
        var rate_hoehe = 0;
        var diff = 0;
        var check_betrag = true;
        betrag_offen.value = "0,00";
        if (modus == 1) {
            check_betrag = false;
        }

        if (bukz != 0) {
            alert('<?php echo MSG_SK_BTN_STORNO; ?>');
            return false;
        }

        if (check_betrag) {
            if (betrag <= 0) {
                alert('<?php echo MSG_INVALID_BUBETRAG; ?>');
                return false;
            }
        }

        // Fälligstellung nächste Rate oder Mahngebühr
        if (zahlart != 1 && (modus == 1 || modus == 2)) {
            if (ratenhoehe <= 0) {
                alert('<?php echo MSG_INVALID_RATENHOEHE; ?>');
                return false;
            }
            if (modus == 1 && betrag > 0) {
                ratenhoehe = betrag;
                betrag = 0;
                document.getElementById('buchungsbetrag').value = toStr(betrag);
            }
//            if (rest = 0 rest < ratenhoehe) {
//                alert('<?php echo MSG_REST_LESS_RATE; ?>');
//                return false;
//            }
            m4 = m4 + m3;
            m4 = Math.round(m4 * 100) / 100;
            m3 = m2;
            m2 = m1;
            m1 = m0;

            rate_hoehe = ratenhoehe;
            rate_offen = 0;
            if (rest < rate_hoehe) {
                rate_hoehe = rest;
                rate_offen = ratenhoehe - rest;
            }

            rest = rest - rate_hoehe;
            rest = Math.round(rest * 100) / 100;
            rate_offen = Math.round(rate_offen * 100) / 100;
            m0 = rate_hoehe;
            m4 = Math.round(m4 * 100) / 100;
            m3 = Math.round(m3 * 100) / 100;
            m2 = Math.round(m2 * 100) / 100;
            m1 = Math.round(m1 * 100) / 100;
            m0 = Math.round(m0 * 100) / 100;

            document.getElementById('m0').value = toStr(m0);
            document.getElementById('m1').value = toStr(m1);
            document.getElementById('m2').value = toStr(m2);
            document.getElementById('m3').value = toStr(m3);
            document.getElementById('m4').value = toStr(m4);
            document.getElementById('rest').value = toStr(rest);

            if (rate_offen > 0) {
                eCalc.value = ' <?php echo TXT_LBL_SK_BTN_ZAHLUNG_OFFEN . ":"; ?>';
                betrag_offen.value = toStr(rate_offen);
                //document.getElementById('buchungsbetrag').value = toStr(betrag - rate_offen);
                alert(toStr(rate_offen) + ' <?php echo TXT_LBL_SK_BTN_ZAHLUNG_OFFEN; ?>');
            }


        }

        if (modus == 2) {
            if (m4 > 0) {
                m4 = m4 + betrag;
                m4 = Math.round(m4 * 100) / 100;
                document.getElementById('m4').value = toStr(m4);
            }
            else if (m3 > 0) {
                m3 = m3 + betrag;
                m3 = Math.round(m3 * 100) / 100;
                document.getElementById('m3').value = toStr(m3);
            }
            else if (m2 > 0) {
                m2 = m2 + betrag;
                m2 = Math.round(m2 * 100) / 100;
                document.getElementById('m2').value = toStr(m2);
            }
            else {
                m1 = m1 + betrag;
                m1 = Math.round(m1 * 100) / 100;
                document.getElementById('m1').value = toStr(m1);
            }

            saldo = saldo + betrag;
            saldo = Math.round(saldo * 100) / 100;
            document.getElementById('saldo').value = toStr(saldo);

        }

        if (modus == 3) {
            offen = betrag;
            if (offen > 0 && m4 > 0) {
                diff = m4 - offen;
                if (diff < 0) {
                    offen = offen - m4;
                    m4 = 0;
                } else {
                    m4 = m4 - offen;
                    offen = 0;
                }
            }

            if (offen > 0 && m3 > 0) {
                diff = m3 - offen;
                if (diff < 0) {
                    offen = offen - m3;
                    m3 = 0;
                } else {
                    m3 = m3 - offen;
                    offen = 0;
                }
            }
            if (offen > 0 && m2 > 0) {
                diff = m2 - offen;
                if (diff < 0) {
                    offen = offen - m2;
                    m2 = 0;
                } else {
                    m2 = m2 - offen;
                    offen = 0;
                }
            }
            if (offen > 0 && m1 > 0) {
                diff = m1 - offen;
                if (diff < 0) {
                    offen = offen - m1;
                    m1 = 0;
                } else {
                    m1 = m1 - offen;
                    offen = 0;
                }
            }
            if (offen > 0 && m0 > 0) {
                diff = m0 - offen;
                if (diff < 0) {
                    offen = offen - m0;
                    m0 = 0;
                } else {
                    m0 = m0 - offen;
                    offen = 0;
                }
            }
            if (offen > 0 && rest > 0) {
                diff = rest - offen;
                if (diff < 0) {
                    offen = offen - rest;
                    rest = 0;
                } else {
                    rest = rest - offen;
                    offen = 0;
                }
            }

            m4 = Math.round(m4 * 100) / 100;
            m3 = Math.round(m3 * 100) / 100;
            m2 = Math.round(m2 * 100) / 100;
            m1 = Math.round(m1 * 100) / 100;
            m0 = Math.round(m0 * 100) / 100;
            rest = Math.round(rest * 100) / 100;
            saldo = m4 + m3 + m2 + m1 + m0 + rest;
            saldo = Math.round(saldo * 100) / 100;
            offen = Math.round(offen * 100) / 100;
            document.getElementById('m0').value = toStr(m0);
            document.getElementById('m1').value = toStr(m1);
            document.getElementById('m2').value = toStr(m2);
            document.getElementById('m3').value = toStr(m3);
            document.getElementById('m4').value = toStr(m4);
            document.getElementById('rest').value = toStr(rest);
            document.getElementById('saldo').value = toStr(saldo);

            if (offen > 0) {
                eCalc.value = ' <?php echo TXT_LBL_SK_BTN_ZAHLUNG_OFFEN . ":"; ?>';
                betrag_offen.value = toStr(offen);
                document.getElementById('buchungsbetrag').value = toStr(betrag - offen);
                alert(toStr(offen) + ' <?php echo TXT_LBL_SK_BTN_ZAHLUNG_OFFEN; ?>');
            }
        }
        eCalc.disabled = true;
        return true;
    }


</script>

<table>
    <tr>
        <td><?php echo TXT_LBL_KDNR ?></td>
        <td><input disabled type="text" class="column" value="<?php echo $kunde_nr; ?>" /></td>
        <td><?php echo TXT_LBL_RNR ?></td>
        <td><input disabled type="text" class="column" value="<?php echo $rechnung_nr; ?>" /></td>
        <td>
            <?php if (isset($subkonten) && count($subkonten) > 0) { ?>
            <td><?php echo TXT_LBL_GESSALDO ?></td>
            <td><input disabled type="text" class="column" value="<?php echo $subkonten[0]->get_saldo(); ?>" /></td>
        <?php } ?>
    </tr>
</table>

<form name="sk" method="post">
    <table>
        <tr>
            <td>    
                <?php if ($can_create && !$show_new) { ?>
                    <a class="button column" <?php if ($show_new) echo "disabled" ?>  href="./index.php?site=subdetail&showNew=true&subkonto=<?php echo $subkonto_id; ?>"><?php echo TXT_LBL_NEW ?></a>
                </td>
            <?php } ?>
            <?php if ($show_new) { ?>
                <td>
                    <input type="submit" onclick="return ValidateSubmit();" value="<?php echo TXT_LBL_SAVE ?>" class="column" />
                </td>
                <td>
                    <a class="button column" href="./index.php?site=subdetail&subkonto=<?php echo $subkonto_id; ?>"><?php echo TXT_LBL_CANCEL ?></a>
                </td>
                <td style="min-width: 115px"></td>
                <td style="color: #1c94c4;"><?php echo TXT_LBL_SK_DEFAULT_BELDAT; ?></td>
                <td style="min-width: 95px;"><input style="max-width: 70px;color: #1c94c4;" name="default_belegdatum" type="date" value="<?php echo $user_default_belegdatum; ?>" /></td>
                <td style="color: #1c94c4;"><?php echo TXT_LBL_SK_DEFAULT_BUART; ?></td>
                <td>
                    <select style="color: #1c94c4;" class="2column" id="default_bua_bgr_man_id" name="default_bua_bgr_man_id"  >
                        <option value="-1"><?php echo TXT_LBL_KEINE; ?></option>
                        <?php foreach ($buchungsgruende as $p) { ?>
                            <option <?php if ($user_default_bua_bgr_key == $p->get_bugru_key_om()) echo "selected";?> value="<?php echo $p->get_bugru_key_om() ?>"><?php echo $p->get_bugru_key_om() . " " . $p->get_buart_text() . " " . $p->get_kontoauszugstext() ?></option>
                        <?php } ?>
                    </select>

                </td>


            <?php } ?>      
            </td>        </tr>    

        <?php if (isset($cur_subkonto_id)) { ?>
            <input type="hidden" name="cur_id" value="<?php echo $cur_subkonto_id; ?>" />
        <?php } ?>

        <table class="designed">
            <tr>
                <th><?php echo TXT_LBL_BDAT ?></th>
                <th><?php echo TXT_LBL_BELDAT ?></th>            
                <th><?php echo TXT_LBL_RECHNUNG ?></th>
                <th><?php echo TXT_LBL_ZA ?></th>
                <th><?php echo TXT_LBL_ZINS ?></th>
                <th><?php echo TXT_LBL_OPENED ?></th>
                <th><?php echo TXT_LBL_KW ?></th>
                <th><?php echo TXT_LBL_RH ?></th>
                <th><?php echo TXT_LBL_BUCHTXT ?></th>
                <th><?php echo TXT_LBL_BUCHKZ ?></th>
                <th><?php echo TXT_LBL_BETR ?></th>
                <th><?php echo TXT_LBL_M4 ?></th>
                <th><?php echo TXT_LBL_M3 ?></th>
                <th><?php echo TXT_LBL_M2 ?></th>
                <th><?php echo TXT_LBL_M1 ?></th>
                <th><?php echo TXT_LBL_M0 ?></th>
                <th><?php echo TXT_LBL_REST ?></th>
                <th><?php echo TXT_LBL_SALDO ?></th>
                <th><?php echo TXT_LBL_CUR ?></th>
                <th><?php echo TXT_LBL_KZGEBUCHT ?></th>            
                <th><?php echo TXT_LBL_VERWENDUNGSZWECK ?></th>
                <th style="display: none;"></th>
            </tr>

            <?php if ($show_new) { ?>
                <tr>
                    <?php if (isset($cur_subkonto_id)) { ?>
                        <td><input disabled name="buchungsdatumd" type="date" value="<?php echo $verwaltungssatz[0]->get_buchungsdatum(); ?>" /></td>
                        <?php if ($user_default_belegdatum == '' || $user_default_belegdatum == NULL) {?>
                           <td><input name="belegdatum" type="date" value="<?php echo $verwaltungssatz[0]->get_buchungsdatum(); ?>" /></td>
                        <?php } else { ?>
                           <td><input name="belegdatum" type="date" value="<?php echo $user_default_belegdatum; ?>" /></td>
                        <?php } ?>
                    <?php } else { ?>
                            <?php // <td><?php echo Subkonto::generate_buchung_lfdnr($subkonto_id); ?></td> 
                        <td><input disabled name="buchungsdatumd" type="date" value="<?php echo $verwaltungssatz[0]->get_buchungsdatum(); ?>" /></td>
                        <?php if ($user_default_belegdatum == '' || $user_default_belegdatum == NULL) {?>
                            <td><input name="belegdatum" type="date" value="<?php echo $verwaltungssatz[0]->get_buchungsdatum(); ?>" /></td>
                        <?php } else { ?>
                            <td><input name="belegdatum" type="date" value="<?php echo $user_default_belegdatum; ?>" /></td>
                        <?php } ?>    
                    <?php } ?>

                    <td><input required disabled name="rechnung_nr" type="text" value="<?php echo $first->get_rechnungsnummer(); ?>" /></td>
                    <td><input style="max-width:50px" name="zahlart" type="text" disabled value="<?php echo $first->get_zahlart(); ?>" />
                        <input type="hidden" name="zahlart_id" id="zahlart_id" value="<?php echo $first->get_zahlart_id(); ?>" /></td>
                    <td><input style="text-align: right; max-width:50px" required name="zinssatz" type="text" value="<?php echo $first->get_zinssatz() ?>" /></td>
                    <td><input name="eroeffnet_am" type="text" disabled value="<?php echo $first->get_eroeffnet_am(); ?>" /></td>
                    <td><input name="kaufwert" type="text" disabled value="<?php echo $first->get_kaufwert(); ?>" /></td>
                    <td><input style="text-align: right; max-width:50px" name="ratenhoehe" id="ratenhoehe" type="text" value="<?php echo $first->get_ratenhoehe(); ?>" /></td>
                    <td>
                        <?php if ($first->get_zahlart_id(TRUE) == 2 || 1 == 1) { ?>
                            <select style="max-width:300px" onchange="EnableDisableFromBuGru()" onselect="EnableDisableFromBuGru()" class="2column" id="bua_bgr_man_id" name="bua_bgr_man_id"  >
                                <?php foreach ($buchungsgruende as $p) { ?>
                                    <?php if ($user_default_bua_bgr_key == $p->get_bugru_key_om())
                                        if ($p->get_plusminus()=="P") {
                                            $default_is_plus = TRUE;
                                        }
                                    ?>
                                    <option <?php if ($user_default_bua_bgr_key == $p->get_bugru_key_om()) echo "selected";?> value="<?php echo $p->get_buabgr_man_id() ?>" title="<?php echo $p->get_plusminus() ?>"><?php echo $p->get_bugru_key_om() . " " . $p->get_buart_text() . " " . $p->get_kontoauszugstext() ?></option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <select style="max-width:300px" class="2column" id="bua_bgr_man_id" name="bua_bgr_man_id"  >
                                <?php foreach ($buchungsgruende as $p) { ?>
                                    <option <?php if ($user_default_bua_bgr_key == $p->get_bugru_key_om()) echo "selected";?> value="<?php echo $p->get_buabgr_man_id() ?>"><?php echo $p->get_bugru_key_om() . " " . $p->get_buart_text() . " " . $p->get_kontoauszugstext() ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>

                    </td>

                    <td><input style="max-width:50px" id="buchungskennzeichen" name="buchungskennzeichen" type="text" value="0" /></td>
                    <td> <input style="text-align: right;min-width:80px" id="buchungsbetrag" name="buchungsbetrag" type="text" value="<?php if ($default_bugru_typ != 0) { echo "0,00"; } else { echo $first->get_buchungsbetrag(); } ?>" />
                    </td>
                    <td><input style="text-align: right; max-width:60px" name="m4" id="m4" type="text" value="<?php echo $first->get_m4(); ?>" /></td>
                    <td><input style="text-align: right; max-width:60px" name="m3" id="m3" type="text" value="<?php echo $first->get_m3(); ?>" /></td>
                    <td><input style="text-align: right; max-width:60px" name="m2" id="m2" type="text" value="<?php echo $first->get_m2(); ?>" /></td>
                    <td><input style="text-align: right; max-width:60px" name="m1" id="m1" type="text" value="<?php echo $first->get_m1(); ?>" /></td>
                    <td><input style="text-align: right; max-width:60px" name="m0" id="m0" type="text" value="<?php echo $first->get_m0(); ?>" /></td>
                    <td><input style="text-align: right; max-width:60px" name="rest" id="rest" type="text" value="<?php echo $first->get_rest(); ?>" /></td>
                    <td><input style="text-align: right; max-width:60px" name="saldo" id="saldo" type="text" value="<?php echo $first->get_saldo(); ?>" /></td>
                    <td><input <?php if (isset($cur_subkonto_id)) echo "disabled"; ?> name="kz_aktuell" type="checkbox" <?php if ($first->get_kz_aktuell() == "J") echo "checked"; ?> /></td>
                    <td><input <?php if (isset($cur_subkonto_id)) echo "disabled"; ?> name="kz_gebucht" type="checkbox" <?php if ($first->get_kz_gebucht() == "J") echo "checked"; ?> /></td>
                    <td><input style="min-width:200px" name="verwendungszweck" type="text" value="<?php echo $first->get_verwendungszweck(); ?>" /></td>
                    <td style="display:none;"><input type="hidden" name ="buchungsdatum" value="<?php echo $verwaltungssatz[0]->get_buchungsdatum(); ?>" /></td>
                </tr>
                <tr>
                    <td >&nbsp;</td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>

                    <?php 
//                    echo $default_bugru_typ."-".$first->get_zahlart_id()."-".$default_enable_calc_button;
//                    exit;
                    if ($first->get_zahlart_id() != 1 && $default_enable_calc_button && $default_bugru_typ == 1) {
                        $button_calc_label = TXT_LBL_SK_BTN_NRATE;
                    } else if ($first->get_zahlart_id() != 1 && $default_enable_calc_button && $default_bugru_typ == 2) {
                        $button_calc_label = TXT_LBL_SK_BTN_MAHNGEB;
                    } else if (!$default_enable_calc_button && $default_is_plus) {
                        $default_enable_calc_button = TRUE;
                        $default_bugru_typ = 3;
                        $button_calc_label = TXT_LBL_SK_BTN_ZAHLUNG_TOPF;
                    } else {
                        $button_calc_label = TXT_LBL_SK_BTN_CALC;
                    }
                        
                    ?>
                    <td ><input type="hidden" name="modus_btn_calc" id="modus_btn_calc" value="<?php echo $default_bugru_typ;?>" /></td>                     
                    <?php if ($first->get_zahlart_id(TRUE) == 2 || 1 == 1) { ?>
                        <td >
                            <input <?php if (!$default_enable_calc_button) echo " disabled ";?>  onclick="btn_calc_click()" id="btn_calc" name="btn_calc" style="min-width:90px;visibility='hidden'"  type="button" class="column" value="<?php echo $button_calc_label ?> " />
                        </td>
                        <td><input style="text-align: right;color: gray;" id="betrag_offen" name="betrag_offen" type="text" class="column" value="<?php echo TXT_LBL_SK_BTN_ZAHLUNG_OFFEN ?> " />
                        </td>
                    <?php } ?>


                </tr>

                <?php
            }

            foreach ($subkonten as $item) {
                ?>
                <tr>
                    <td><?php echo $item->get_buchungsdatum(); ?></td>
                    <td><?php echo $item->get_belegdatum(); ?></td>                
                    <td><?php echo $item->get_rechnungsnummer(); ?></td>
                    <td><?php echo $item->get_zahlart(); ?></td>
                    <td style="text-align: right"><?php echo $item->get_zinssatz(); ?></td>
                    <td><?php echo $item->get_eroeffnet_am(); ?></td>
                    <td style="text-align: right"><?php echo $item->get_kaufwert(); ?></td>
                    <td style="text-align: right"><?php echo $item->get_ratenhoehe(); ?></td>
                    <td style="min-width:200px"><?php echo $item->get_bugru_key_om() . " " . $item->get_buart_text() . " " . $item->get_bugru_text() ?></td>

                    <td><?php echo $item->get_buchungskennzeichen(); ?></td>
                    <td style="text-align: right"><?php echo $item->get_buchungsbetrag(); ?></td>
                    <td style="text-align: right"><?php echo $item->get_m4(); ?></td>
                    <td style="text-align: right"><?php echo $item->get_m3(); ?></td>
                    <td style="text-align: right"><?php echo $item->get_m2(); ?></td>
                    <td style="text-align: right"><?php echo $item->get_m1(); ?></td>
                    <td style="text-align: right"><?php echo $item->get_m0(); ?></td>
                    <td style="text-align: right"><?php echo $item->get_rest(); ?></td>
                    <td style="text-align: right"><?php echo $item->get_saldo(); ?></td>
                    <td><input disabled type="checkbox" <?php if ($item->get_kz_aktuell() == "J") echo "checked"; ?> /></td>
                    <td><input disabled type="checkbox" <?php if ($item->get_kz_gebucht() == "J") echo "checked"; ?> /></td>
                    <td><?php echo $item->get_verwendungszweck(); ?></td>
                </tr>
            <?php } ?>
        </table>
        <?php if (!isset($cur_subkonto_id)) { ?>
            <input type="hidden" value="INS" name="mode" />
        <?php } else { ?>
            <input type="hidden" value="<?php echo $cur_subkonto_id ?>" name="edited_id" />
            <input type="hidden" value="UPD" name="mode" />
        <?php } ?>
        <input type="hidden" value="subdetail" name="site" />
        <input type="hidden" value="<?php echo $subkonto_id ?>" name="subkonto" />

</form>

<div class="buttonset">
    <a href="index.php?site=subdetail&subkonto=<?php echo $subkonto_id; ?>&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=subdetail&subkonto=" . $subkonto_id . "&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>

    <a href="index.php?site=subdetail&subkonto=<?php echo $subkonto_id; ?>&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>
</div>