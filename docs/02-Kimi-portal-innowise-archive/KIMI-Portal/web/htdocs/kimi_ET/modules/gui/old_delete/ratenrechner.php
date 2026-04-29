<h1><?php echo TXT_LBL_RATE_HEADER ?></h1>
<script type="text/javascript">

    function EnableDisable() {
        var inpRatenanzahl = document.getElementById('Ratenanzahl');
        var inpRatenhoehe = document.getElementById('Ratenhoehe');

        var ValueAnz = inpRatenanzahl.value;
        var ValueHoehe = inpRatenhoehe.value;
        var mode = 0;
        if ((ValueAnz === "" || ValueAnz === "0" || ValueAnz === "0,00") && (ValueHoehe === "" || ValueHoehe === "0" || ValueHoehe === "0,00")) {
            mode = 0;
        } else if (ValueHoehe === '' || ValueHoehe === '0' || ValueHoehe === '0,00') {
            mode = 2;
        } else {
            mode = 1;
        }
        if (mode === 1) {
            inpRatenanzahl.disabled = true;
            inpRatenhoehe.disabled = false;
            inpRatenanzahl.value = "0";
        } else if (mode === 2) {
            inpRatenanzahl.disabled = false;
            inpRatenhoehe.disabled = true;
            inpRatenhoehe.value = "0,00";
        } else {
            inpRatenanzahl.disabled = false;
            inpRatenhoehe.disabled = false;
        }

    }
</script>
<div>

    <?php if (isset($kunde)) { ?>
        <input type="hidden" value="<?php echo $kunde->get_kdnr(); ?>" name="kundennummer_backup" />
        <input type="hidden" value="<?php echo $kunde_id; ?>" name="kunde_id" />

        <table>
            <tr>
                <td><?php echo TXT_LBL_KDNR ?></td>
                <td>
                    <input name="kundennummer" disabled placeholder="<?php echo TXT_LBL_KDNR ?>" name="kdnr" class="column" type="text" value="<?php if (isset($kunde)) echo $kunde->get_kdnr(); ?>" />
                </td>
                <td>
                </td>
                <?php if (isset($kunde)) { ?>
                    <td>
                        <table class="column">
                            <tr>
                                <td><?php echo TXT_LBL_ANREDE ?>/<?php echo TXT_LBL_TITEL ?></td>
                                <td>
                                    <select disabled name="anrede_id" ">
                                        <option selected value="-1"><?php echo $kunde->get_anrede() ?></option>
                                    </select>
                                </td>
                                <td>
                                    <input class="columnSmall" disabled placeholder="<?php echo TXT_LBL_TITEL ?>" name="titel"  type="text" value="<?php echo $kunde->get_titel() ?>" /> 
                                    <?php /*
                                      <select disabled name="titel_id" style="width: 100%;">
                                      <option selected value="-1"><?php echo $kunde->get_titel() ?></option>
                                      </select> */ ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>Kundenart</td>
                    <td><input disabled  name="kundenart" class="search" type="text" value="<?php echo $kunde->get_kundenart() ?> <?php echo $kunde->get_kundenartbeschreibung() ?>" /></td>
                    <td><?php echo TXT_LBL_ADRKENNER ?></td>
                    <td><input disabled  name="adr_kenner"  class="column" type="text" value="<?php echo $kunde->get_kenner() ?>" /> </td>
                <?php } ?>
            </tr>

            <?php if (isset($kunde)) { ?>
                <tr disabled>
                    <td><?php echo TXT_LBL_LASTNAME ?></td>
                    <td>
                        <input disabled  name="nachname" class="column" type="text" value="<?php echo $kunde->get_nachname() ?>" />
                    </td>
                    <td><?php echo TXT_LBL_FIRSTNAME ?></td>
                    <td>
                        <input disabled  name="vorname" class="column" type="text" value="<?php echo $kunde->get_vorname() ?>" />
                    </td>
                    <td><?php echo TXT_LBL_LASTNAME ?>2</td>
                    <td><input disabled  name="nachname" class="column" type="text" value="<?php echo $kunde->get_nachname2() ?>" /></td>
                    <td><?php echo TXT_LBL_FIRSTNAME ?>2</td>
                    <td><input disabled  name="vorname" class="column" type="text" value="<?php echo $kunde->get_vorname2() ?>" /> </td>
                </tr>
                <tr disabled>
                    <td><?php echo TXT_LBL_BIRTH ?></td>
                    <td>
                        <input disabled  name="geburtsdatum" class="search" type="date" value="<?php echo $kunde->get_geburtsdatum() ?>" />
                    </td>
                    <td></td>
                    <td></td>
                    <td><?php echo TXT_LBL_BIRTH ?>2</td>
                    <td> <input disabled  name="geburtsdatum2" class="search" type="date" value="<?php echo $kunde->get_geburtsdatum2() ?>" /> </td>
                    <td> </td>
                    <td></td>
                </tr>
                <tr disabled>
                    <td><?php echo TXT_LBL_STR ?></td>
                    <td>
                        <input disabled  name="strasse" class="column" type="text" value="<?php echo $kunde->get_strasse() ?>" />
                    </td>

                    <td><?php echo TXT_LBL_HNR ?></td>
                    <td>
                        <table class="column padded">
                            <tr>
                                <td>
                                    <input disabled  size="10" name="hausnummer" type="text" value="<?php echo $kunde->get_hausnummer() ?>" />
                                </td>
                                <td class="placeholder"></td>
                                <td>
                                    <input disabled  size="10" name="hausnummer_erw" type="text" value="<?php echo $kunde->get_hausnummer_erw() ?>" />
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td><?php echo TXT_LBL_PLZ ?></td>
                    <td>
                        <table class="column">
                            <tr>
                                <td>
                                    <select disabled  name="land_id">
                                        <option selected value="-1"><?php echo $kunde->get_land(); ?></option>
                                    </select>
                                </td>
                                <td>
                                    <input disabled  name="plz" type="text" value="<?php echo $kunde->get_plz() ?>" />
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td><?php echo TXT_LBL_ORT ?></td>
                    <td><input required disabled  name="ort" class="search" type="text" value="<?php echo $kunde->get_ort() ?>" /></td>
                </tr>
                <tr disabled>
                    <td><?php echo TXT_LBL_TEL ?></td>
                    <td>
                        <input disabled  name="telefon" class="search" type="text" value="<?php echo $kunde->get_telefon() ?>" /> <br />
                    </td>
                    <td><?php echo TXT_LBL_EMAIL ?></td>
                    <td>
                        <input disabled  size="40" name="email" class="search" type="email" value="<?php echo $kunde->get_email() ?>" /> <br />
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>

    <form action="index.php" method="POST">
        <input type="hidden" name="site" id="site" value="ratenrechner" />
        <input type="hidden" name="search" id="search" value="true" />
        <?php if (isset($kunde)) { ?>
        <input type="hidden" value="<?php echo $kunde_id; ?>" name="kunde_id" />
            <hr>
        <?php } ?>
        <table>
            <?php if (isset($kunde)) {?>
            <tr>
                <td><?php echo TXT_LBL_GESSALDO ?></td>
                <td>
                    <input disabled style="text-align: right" value="<?php echo $gessaldo; ?>" name="Gessaldo" id="Gessaldo" class="search" type="text" placeholder="<?php echo TXT_LBL_GESSALDO ?>" />
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php }?>

            <tr>
                <td><?php echo TXT_LBL_RATE_KREDITBETRAG ?></td>
                <td>
                    <input style="text-align: right" value="<?php echo $ratenbetrag; ?>" name="Kreditbetrag" id="Kreditbetrag" class="search" type="text" placeholder="<?php echo TXT_LBL_RATE_KREDITBETRAG ?>" />
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_RATE_HOEHE ?></td>
                <td>
                    <input onchange="EnableDisable()" style="text-align: right" value="<?php echo $ratenhoehe; ?>" name="Ratenhoehe" id="Ratenhoehe" class="search" type="text" placeholder="<?php echo TXT_LBL_RATE_HOEHE ?>" />
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_RATE_ANZAHL ?></td>
                <td><input onchange="EnableDisable()" style="text-align: right" value="<?php echo $ratenanzahl; ?>" name="Ratenanzahl" id="Ratenanzahl" class="search" type="text" placeholder="<?php echo TXT_LBL_RATE_ANZAHL ?>" /></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_RATE_ZINSSATZ ?></td>
                <td>
                    <input style="text-align: right" value="<?php echo $ratenzinssatz; ?>" name="Zinssatz" id="Zinssatz" class="search" type="text" placeholder="<?php echo TXT_LBL_RATE_ZINSSATZ ?>" />
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <?php echo "&nbsp;"; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input class="search" type="submit" value="<?php echo TXT_LBL_RATE_BERECHNEN ?>" />
                    <a href="index.php?site=ratenrechner&reset=true" class="button search"><?php echo TXT_LBL_RESET ?></a>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </form>

    <?php if (isset($tilgung)) { ?>
        <h2><?php echo TXT_LBL_TILG_HEADER ?></h2>
        <table class="designed-last" style="width: 600px"  >
            <th style="width: 100px"><?php echo TXT_LBL_TILG_RATE ?> </th>
            <th style="width: 100px" ><?php echo TXT_LBL_TILG_ZAHLTAG ?> </th>
            <th style="width: 100px"><?php echo TXT_LBL_TILG_SALDOVORTRAG ?> </th>
            <th style="width: 100px"><?php echo TXT_LBL_TILG_ZINSEN ?> </th>
            <th style="width: 100px"><?php echo TXT_LBL_TILG_TILGUNG ?> </th>
            <th style="width: 100px"><?php echo TXT_LBL_TILG_SALDO ?> </th>

            <?php
            $anz = count($tilgung);
            $n = 1;
            $bold = "";
            $bold2 = '"';
            foreach ($tilgung as $item) {
                if ($n==$anz) {
                    $bold = 'style="font-weight: bold"';
                    $bold2 = ';font-weight: bold"';
                }
                ?>
            <tr >
                    <td <?php echo $bold?> > <?php
                        echo $item['rate'];
                        ?>
                    </td>
                    <td style="text-align: right" > <?php
                        echo $item['zahltag'];
                        ?>
                    </td>
                    <td style="text-align: right" > <?php
                        echo $item['saldovortrag'];
                        ?>
                    </td>
                    <td style="text-align: right<?php echo $bold2?> > <?php
                        echo $item['zinsen'];
                        ?>
                    </td>
                    <td style="text-align: right<?php echo $bold2?> > <?php
                        echo $item['tilgung'];
                        ?>
                    </td>
                    <td style="text-align: right" > <?php
                        echo $item['saldoneu'];
                        ?>
                    </td>
               </tr>
               
        <?php
        $n++;
        } ?>
        </table>
<?php } ?>
</div>

