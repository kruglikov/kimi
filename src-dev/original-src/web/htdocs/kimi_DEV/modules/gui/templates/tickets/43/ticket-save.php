    <table>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_TASK ?></td>
            <td colspan="5" style="padding-right: 14px"><input value="<?php echo $ticket->get_beschreibung_detail() ?>" placeholder="<?php echo TXT_LBL_TASK ?>" style="width: 100%" name="beschreibung_detail" type="text" readonly /></td>
            <td > <?php echo 'GLName/Ort' ?></td>
            <td colspan="3" style="padding-right: 14px"> <input value="<?php echo $ticket->get_fahrgestellnummer() ?>" placeholder="<?php echo 'GLName/Ort' ?>" class="column" type="text" style="width: 100%" name="fahrgestellnummer" readonly /></td>      
        </tr>

		<tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_TICKETNR ?></td>
            <td><input required class="column" name="ticketnr" placeholder="<?php echo TXT_LBL_TICKETNR ?>" type="text" value="<?php echo $ticket->get_ticketnr() ?>" /></td>
                      <td > <?php echo 'Päckchennummer' ?></td>
            <td> <input value="<?php echo $ticket->get_dummy_text9() ?>" placeholder="<?php echo 'Päckchennummer' ?>" class="column" type="text" name="dummy_text9" /></td> 
            <td><td/>
	        <td>direkt zum Akte</td>
			<td><a href="http://192.168.100.14/kimi/kimi_ET/index.php?kundennummer=1633866&site=stammdaten" target="_blank"><b>AKTE</b></a></td>
            <td>Titel anzeigen</td>
            <td><a href="http://192.168.100.14/kimi/kimi_ET/modules/gui/templates/tickets/14/Akt/1.jpg" target="_blank"><b>TITEL</b></a></td>
		
		
		</tr>
       </tr>
		        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_KDNR ?></td>
            <td><input value="<?php echo $ticket->get_kundennummer() ?>" placeholder="<?php echo TXT_LBL_KDNR ?>" class="column" name="kundennummer" type="text" /></td>
            <td> <?php echo 'erledigt' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_geburtsdatum() ?>" placeholder="<?php echo 'erledigt' ?>" type="date" name="geburtsdatum" /></td>            
			<!-- Kommentarzeile ein
			<td bgcolor=#FF00000> <?php echo 'Saldo' ?></td></td>
            <td bgcolor=#FF00000> <input value="<?php echo $ticket->get_dummy_number4() ?>" placeholder="<?php echo 'Saldo' ?>" class="column" type="decimal" name="dummy_number4" /></td>            
			<td > <?php echo 'IBAN' ?></td>
            <td> <input value="<?php echo $ticket->get_dummy_text1() ?>" placeholder="<?php echo 'IBAN' ?>" class="column" type="text" name="dummy_text1" /></td>      
			<td> <?php echo 'BIC' ?></td>
            <td> <input value="<?php echo $ticket->get_dummy_text2() ?>" placeholder="<?php echo 'BIC' ?>" class="column" type="text" name="dummy_text2" /></td>  
			Kommentar aus //--> 
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
        </tr>
 		
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_LASTNAME ?></td>
            <td><input value="<?php echo $ticket->get_nachname() ?>" placeholder="<?php echo TXT_LBL_LASTNAME ?>" class="column" type="text" name="nachname" /></td>
            <td><?php echo TXT_LBL_FIRSTNAME ?></td>
            <td><input value="<?php echo $ticket->get_vorname() ?>" placeholder="<?php echo TXT_LBL_FIRSTNAME ?>" class="column" type="text" name="vorname" /></td>
            <!-- Kommentarzeile ein
			<td bgcolor=#FF00000> <?php echo 'Verzzinsen' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_dummy_text8() ?>" placeholder="<?php echo 'Verzinsen' ?>" type="text" name="dummy_text8" /></td>            
			<td bgcolor=#FF00000> <?php echo 'CONNECT (Telefonnr gibt es)' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_dummy_text3() ?>" placeholder="<?php echo 'CONNECT (Telefonnr gibt es)' ?>" type="text" name="dummy_text3" /></td> 
			<td bgcolor=#FF00000> <?php echo 'RPC(Schuldner ereicht)' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_dummy_text4() ?>" placeholder="<?php echo '(Schuldner ereicht' ?>" type="text" name="dummy_text4" /></td>  			
			Kommentar aus //--> 
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
        </tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_PLZ ?></td>
            <td>
                <select required name="land_id">
                    <option value="-1">-</option>
                    <?php
                    foreach ($laender as $land) {
                        ?>
                        <option <?php
                        if ($ticket->get_land_id() == $land->get_id())
                            echo "selected";
                        ?> value="<?php echo $land->get_id() ?>"><?php echo $land->get_kurzzeichen() ?></option>
                            <?php
                        }
                        ?>
                </select>
                <input value="<?php echo $ticket->get_plz() ?>" placeholder="<?php echo TXT_LBL_PLZ ?>" style="width: 150px" type="text" name="plz" /></td>
            <td><?php echo TXT_LBL_ORT ?></td>
            <td><input class="column" value="<?php echo $ticket->get_ort() ?>" placeholder="<?php echo TXT_LBL_ORT ?>" type="text" name="ort" /></td>
            <td></td>
			<td></td>
			<!-- Kommentarzeile ein
			<td bgcolor=#FF00000> <?php echo 'PTP(Vereinbarung Bezahlung)' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_dummy_text5() ?>" placeholder="<?php echo '(Vereinbarung Bezahlung)' ?>" type="text" name="dummy_text5" /></td>             
			<td> <?php echo 'IndexA' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_dummy_number1() ?>" placeholder="<?php echo 'IndexA' ?>" type="text" name="dummy_number1" /></td>  
			Kommentar aus //--> 
			<td></td>
			<td></td>
			<td></td>
			<td></td>
        </tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_STR ?></td>
            <td><input class="column" value="<?php echo $ticket->get_strasse() ?>" placeholder="<?php echo TXT_LBL_STR ?>" type="text" name="strasse" /></td>
            <td><?php echo TXT_LBL_HNR ?></td>
            <td style="width: 200px">
                <table style="width: 200px !important;">
                    <tr>
                        <td>
                            <input style="width: 90px" placeholder="<?php echo TXT_LBL_HNR ?>" name="hausnummer" type="text" value="<?php echo $ticket->get_hausnummer() ?>" /> 
                        </td>
                        <td>
                            <input style="width: 90px" placeholder="<?php echo TXT_LBL_HNR_EXTENDED ?>" name="hausnummer_erw" type="text" value="<?php echo $ticket->get_hausnummer_erw() ?>" />
                        </td>
                    </tr>
                </table>
            </td>
			<!-- Kommentarzeile ein
            <td bgcolor=#FF00000 > <?php echo 'Alter' ?></td>
            <td bgcolor=#FF00000 > <input class="column" value="<?php echo $ticket->get_dummy_number5() ?>" placeholder="<?php echo 'Alter' ?>" type="text" name="dummy_number5" /></td>          
			<td> <?php echo 'IndexB' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_dummy_number2() ?>" placeholder="<?php echo 'IndexB' ?>" type="text" name="dummy_number2" /></td>             
			<td> <?php echo 'IndexC' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_dummy_number3() ?>" placeholder="<?php echo 'IndexC' ?>" type="text" name="dummy_number3" /></td>  			
			Kommentar aus //--> 
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
        </tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_TEL ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_TEL ?>" name="telefon" class="column" type="text" value="<?php echo $ticket->get_telefon() ?>" /> <br />
            </td>
            <td><?php echo TXT_LBL_TELEFON2 ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_TELEFON2 ?>" name="telefon2" class="column" type="text" value="<?php echo $ticket->get_telefon2() ?>" /> <br />
            </td>
            <td><?php echo TXT_LBL_EMAIL ?></td>
            <td> 
			    <input placeholder="<?php echo TXT_LBL_EMAIL ?>" name="email" class="column" type="email" value="<?php echo $ticket->get_email() ?>" /> <br />
			</td>    
			<td bgcolor=#98FB98><?php echo TXT_LBL_QUEST1 ?></td>
            <td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo1() ?>" placeholder="<?php echo TXT_LBL_QUEST1 ?>" style="width: 100%" name="textinfo1" type="text" /></td>			
        </tr>
		<tr >
            <td bgcolor=#FFFF00><?php echo TXT_LBL_TEL ?></td>
            <td bgcolor=#FFFF00><input placeholder="<?php echo TXT_LBL_TEL ?>" name="dummy_text6" class="column" type="text" value="<?php echo $ticket->get_dummy_text6() ?>" /> <br /></td>
            <td bgcolor=#FFFF00><?php echo TXT_LBL_TELEFON2 ?></td>
			<td bgcolor=#FFFF00><input placeholder="<?php echo TXT_LBL_TELEFON2 ?>" name="dummy_text7" class="column" type="text" value="<?php echo $ticket->get_dummy_text7() ?>" /> <br /></td>
             <td bgcolor=#98FB98><?php echo 'Anrufzeitpunkt' ?></td>
            <td><select class="column" name="firma_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($firma as $p) { ?>
                        <option <?php if ($ticket->get_firma_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select></td>
            <td bgcolor=#98FB98 ><?php echo Betreibung ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant11_janein_id"  id="textant11_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant11_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
				<td bgcolor=#98FB98><?php echo 'Währung' ?></td>
            <td bgcolor=#98FB98><select class="column" name="produkt_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($produkt as $p) { ?>
                        <option <?php if ($ticket->get_produkt_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td> 
				<!-- Kommentarzeile ein
			<td bgcolor=#98FB98><?php echo TXT_LBL_ANSW12 ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant12_nummern_id"  id="textant12_nummern_id">
			        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($nummern as $p) { ?>
                        <option <?php if ($ticket->get_textant12_nummern_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
				Kommentar aus //--> 

        </tr>
			<tr >
            <td bgcolor=#FF00000> <?php echo 'KontaktTelnrVW' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_verkaeufercode() ?>" placeholder="<?php echo 'KontaktTelnrVW' ?>" type="text" name="verkaeufercode" /></td>  			
            <td bgcolor=#FF00000> <?php echo 'KontaktTelnrHW' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_standort() ?>" placeholder="<?php echo 'KontaktTelnrHW' ?>" type="text" name="standort" /></td>  			
            <td bgcolor=#98FB98><?php echo TXT_LBL_WIEDERVORLAGE ?></td>            
            <td bgcolor=#98FB98><input class="column" value="<?php echo $ticket->get_wiedervorlage() ?>" placeholder="<?php echo TXT_LBL_WIEDERVORLAGE ?>" type="date" name="wiedervorlage" /></td>
            <td bgcolor=#98FB98><?php echo TXT_LBL_QUEST2 ?></td>
            <td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo2() ?>" placeholder="<?php echo TXT_LBL_QUEST2 ?>" style="width: 100%" name="textinfo2" type="text" /></td>			
				

        </tr>
		<!-- Kommentarzeile ein
			<tr bgcolor="#D3D3D3">
            <td bgcolor=#FF00000> <?php echo 'NEUE TelnrVW' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_verkaeufername() ?>" placeholder="<?php echo 'NEUE TelnrVW' ?>" type="text" name="verkaeufername" /></td>  			
            <td bgcolor=#FF00000> <?php echo 'NEUE TelnrHW' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_markencode() ?>" placeholder="<?php echo 'NEUE TelnrHW' ?>" type="text" name="markencode" /></td>  			
           <td bgcolor=#FF00000> <?php echo 'Telefon1Falsch' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_modell() ?>" placeholder="<?php echo 'Telefon1Falsch' ?>" type="text" name="modell" /></td>  			
            <td bgcolor=#FF00000> <?php echo 'Telefon2Falsch' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_amtliches_kennzeichen() ?>" placeholder="<?php echo 'Telefon2Falsch' ?>" type="text" name="amtliches_kennzeichen" /></td>  			
           <td bgcolor=#98FB98>&nbsp;</td>
				

        </tr>
		Kommentar aus //--> 

		

		        <tr >
			<td bgcolor=#98FB98><?php echo TXT_LBL_STATUS ?></td>
            <td bgcolor=#98FB98>
                <select class="column" name="status_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($status as $p) { ?>
                        <option <?php if ($ticket->get_status_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
			<td bgcolor=#98FB98><?php echo Unterstatus ?></td>
            <td bgcolor=#98FB98>
                <select class="column" name="anruf_status_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($anruf_status as $p) { ?>
                        <option <?php if ($ticket->get_anruf_status_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
            <td >&nbsp;</td>            
            <td >&nbsp;</td>
            <td bgcolor=#98FB98><?php echo 'Detailbewertung1' ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant22_nummern_id"  id="textant22_nummern_id">
			        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($nummern as $p) { ?>
                        <option <?php if ($ticket->get_textant22_nummern_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>				
            <td bgcolor=#98FB98><?php echo 'Ausbuchungsgrund' ?></td>
            <td bgcolor=#98FB98><select class="column" name="grund_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($grund as $p) { ?>
                        <option <?php if ($ticket->get_grund_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>				
				
		</tr>
        <tr >
            <td bgcolor=#98FB98><?php echo TXT_LBL_RESULT ?></td>
            <td bgcolor=#98FB98 colspan="5" style="padding-right: 14px"><textarea rows="6" style="width: 100%" placeholder="<?php echo TXT_LBL_RESULT ?>" name="ergebnis"><?php echo $ticket->get_ergebnis() ?></textarea></td>
			<!-- Kommentarzeile ein
			<td><?php echo TXT_LBL_ANSW21 ?></td>
            <td><select required class="column" name="textant21_janein_id"  id="textant21_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant21_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
				
			<td ><?php echo TXT_LBL_ANSW22 ?></td>
            <td ><select required class="column" name="textant22_nummern_id"  id="textant22_nummern_id">
			        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($nummern as $p) { ?>
                        <option <?php if ($ticket->get_textant22_nummern_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
				Kommentar aus //--> 
            <td bgcolor=#98FB98 colspan="5" style="padding-right: 14px"><textarea rows="10" style="width: 100%" placeholder="<?php echo 'INFO' ?>" name="dummy_text10"><?php echo $ticket->get_dummy_text10() ?></textarea></td>
        </tr>
      		 <tr bgcolor="#D3D3D3">
           <td><?php echo TXT_LBL_PRIORITY ?></td>
            <td>
                <select class="column" name="prioritaet_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($prioritaet as $p) { ?>
                        <option <?php if ($ticket->get_prioritaet_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
			<td><?php echo TXT_LBL_USER ?></td>
            <td>
                <select required class="column" name="benutzer_id"  id="benutzer_id">
                    <?php foreach ($benutzer as $p) { ?>
                        <option <?php if ($ticket->get_benutzer_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_name() ?></option>
                    <?php } ?>
                </select>
            </td>
            <td></td>
            <td></td>

			<td bgcolor=#98FB98><?php echo TXT_LBL_INFO1 ?></td>
			<td bgcolor=#98FB98 colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo5	() ?>" placeholder="<?php echo TXT_LBL_INFO1 ?>" style="width: 100%" name="textinfo5" type="text" /></td>
		
		</tr>

        <tr >
            <td><?php echo TXT_LBL_BEGIN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_beginn() ?>" placeholder="<?php echo TXT_LBL_BEGIN ?>" type="date" name="beginn" /></td>
            <td><?php echo TXT_LBL_END ?></td>
            <td><input required value="<?php echo $ticket->get_ende() ?>" placeholder="<?php echo TXT_LBL_END ?>" class="column" type="date" name="ende" /></td>
            <td><?php echo TXT_LBL_STUNDEN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_aufwand() ?>" placeholder="<?php echo TXT_LBL_STUNDEN ?>" type="text" name="aufwand" /></td>                       
			<td><a class="button" onclick="kopieren()" ><?php echo TXT_LBL_COPYTICKET ?></a></td>
            <td>&nbsp;</td>

		</tr>
		
    </table>