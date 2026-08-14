    <table>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_TICKETNR ?></td>
            <td><input readonly="readonly" required class="column" name="ticketnr" placeholder="<?php echo TXT_LBL_TICKETNR ?>" type="text" value="<?php echo $ticket->get_ticketnr() ?>" /></td>
           <td><?php echo "Leistung" ?></td>
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
            <td bgcolor=#FF00000><?php echo 'Mahnsperre' ?>
            <select class="column" name="grund_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($grund as $p) { ?>
                        <option <?php if ($ticket->get_grund_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>		
			<td bgcolor=#FF00000 style="padding-right: 14px"><?php echo 'Grund' ?> <input value="<?php echo $ticket->get_dummy_text2() ?>" placeholder="<?php echo 'Grund der Mahnsperre' ?>" class="column" type="text" style="width: 100%" name="dummy_text2" /></td> 
			<td bgcolor=#FF00000 colspan="3" style="padding-right: 14px"><?php echo 'Datum bis' ?> 	<input style="width:80px;" class="column" value="<?php echo $ticket->get_dummy_date3() ?>" placeholder="<?php echo 'Mahnsperre bis' ?>" type="date" name="dummy_date3" /></td>			
			<!-- Kommentarzeile ein	
			<td bgcolor=#98FB98><?php echo TXT_LBL_INFO1 ?></td>
			<td bgcolor=#98FB98 colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo5	() ?>" placeholder="<?php echo TXT_LBL_INFO1 ?>" style="width: 100%" name="textinfo5" type="text" /></td>
				
			<td><a href="http://10.10.2.211/kimi_SB/modules/gui/templates/tickets/43/SBERBANK_Leitfaden.pdf" target="_blank"><b>Leitfaden</b></a>
				<a href="http://10.10.2.211/kimi_SB/modules/gui/templates/tickets/43/SBERBANK_Dokumentation.pdf" target="_blank"><b>Dokumentation</b></a></td>
            <td><a href="http://10.10.2.211/kimi_SB/kimibatch/sberbankcheck.php" target="_blank"><b>SBERBANK_Check</b></a></td>	
			Kommentar aus //-->  			
		</tr>
        <tr bgcolor="#D3D3D3">
           <td><?php echo TXT_LBL_TASK ?></td>
            <td colspan="5" style="padding-right: 14px"><textarea readonly="readonly" rows="2" style="width: 95%" placeholder="<?php echo TXT_LBL_TASK ?>" name="beschreibung_detail"><?php echo $ticket->get_beschreibung_detail() ?></textarea></td>			
		<!-- Kommentarzeile ein		
		<td >Sachbearbeiter</td>
			<td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_kenner() ?>" placeholder="<?php echo 'Sachbearbeiterinformationen' ?>" style="width: 100%" name="kenner" type="text" /></td>
				Kommentar aus //-->  
			<td bgcolor=#98FB98><?php echo TXT_LBL_INFO1 ?></td>
            <td colspan="3" style="padding-right: 14px"><textarea rows="2" style="width: 95%" placeholder="<?php echo TXT_LBL_INFO1 ?>" name="textinfo5"><?php echo $ticket->get_textinfo5() ?></textarea></td>			

		</tr>
		<tr bgcolor="#D3D3D3">
            <td > <?php echo 'GLName/Ort' ?></td>
            <td colspan="3" style="padding-right: 14px"> <input readonly="readonly" value="<?php echo $ticket->get_fahrgestellnummer() ?>" placeholder="<?php echo 'GLName/Ort' ?>" class="column" type="text" style="width: 100%" name="fahrgestellnummer" /></td>      
 	     	<td bgcolor=#FF00000> <?php echo 'aktueller Aussenstand Gesamt' ?></td>
            <td bgcolor=#FF00000> <input readonly="readonly" value="<?php echo $ticket->get_dummy_number5() ?>" placeholder="<?php echo 'aktueller Aussenstand Gesamt' ?>" class="column" type="decimal" name="dummy_number5" /></td>    </td> 
            <td > <?php echo 'Kontonummer' ?></td>
            <td> <input readonly="readonly"value="<?php echo $ticket->get_dummy_text9() ?>" placeholder="<?php echo 'Kontonummer' ?>" class="column" type="text" name="dummy_text9" /></td> 
			<td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
		        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_KDNR ?></td>
            <td><input readonly="readonly"value="<?php echo $ticket->get_kundennummer() ?>" placeholder="<?php echo TXT_LBL_KDNR ?>" class="column" name="kundennummer" type="text" /></td>
            <td><?php echo 'Anrede' ?></td>
            <td><input readonly="readonly"value="<?php echo $ticket->get_anrede() ?>" placeholder="<?php echo 'Anrede' ?>" class="column" name="anrede" type="text" /></td>
			<td bgcolor=#FF00000> <?php echo 'Überfälliger Aussenstand' ?></td></td>
            <td bgcolor=#FF00000> <input readonly="readonly" value="<?php echo $ticket->get_dummy_number4() ?>" placeholder="<?php echo 'Überfälliger Aussenstand' ?>" class="column" type="decimal" name="dummy_number4" /></td>            
			<td > <?php echo 'IBAN' ?></td>
            <td> <input readonly="readonly"value="<?php echo $ticket->get_dummy_text1() ?>" placeholder="<?php echo 'IBAN' ?>" class="column" type="text" name="dummy_text1" /></td>      
			<td></td>
            <td></td>  
        </tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_LASTNAME ?></td>
            <td colspan="3" style="padding-right: 14px"><input readonly="readonly" value="<?php echo $ticket->get_nachname() ?>" placeholder="<?php echo TXT_LBL_LASTNAME ?>" class="column" type="text" style="width: 100%" name="nachname" /></td>
			<!-- Kommentarzeile ein			
            <td><?php echo TXT_LBL_FIRSTNAME ?></td>
            <td><input value="<?php echo $ticket->get_vorname() ?>" placeholder="<?php echo TXT_LBL_FIRSTNAME ?>" class="column" type="text" name="vorname" /></td>
			Kommentar aus //--> 			
            <td bgcolor=#FF00000> <?php echo 'monatliche Rate' ?></td>
            <td bgcolor=#FF00000> <input readonly="readonly" class="column" value="<?php echo $ticket->get_dummy_text8() ?>" placeholder="<?php echo 'monatliche Rate' ?>" type="text" name="dummy_text8" /></td>            
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
                <input readonly="readonly" value="<?php echo $ticket->get_plz() ?>" placeholder="<?php echo TXT_LBL_PLZ ?>" style="width: 150px" type="text" name="plz" /></td>
            <td><?php echo TXT_LBL_ORT ?>
            <input readonly="readonly"class="column" value="<?php echo $ticket->get_ort() ?>" placeholder="<?php echo TXT_LBL_ORT ?>" type="text" name="ort" /></td>
            <td><?php echo TXT_LBL_STR ?>
            <input readonly="readonly"class="column" value="<?php echo $ticket->get_strasse() ?>" placeholder="<?php echo TXT_LBL_STR ?>" type="text" name="strasse" /></td>         
            <td> <?php echo 'Geburtsdatum' ?></td>
            <td> <input readonly="readonly" class="column" value="<?php echo $ticket->get_geburtsdatum() ?>" placeholder="<?php echo 'Geburtsdatum' ?>" type="date" name="geburtsdatum" /></td>  
			<!-- Kommentarzeile ein
			<td> <?php echo 'IndexA' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_dummy_number1() ?>" placeholder="<?php echo 'IndexA' ?>" type="text" name="dummy_number1" /></td>  
			Kommentar aus //--> 			
        </tr>
        <tr bgcolor="#D3D3D3">
			<td><?php echo 'CO-Borrower' ?></td>
			<td colspan="5" style="padding-right: 14px"> <input readonly="readonly" value="<?php echo $ticket->get_dummy_text11() ?>" placeholder="<?php echo 'CO_BORROWER' ?>" class="column" type="text" style="width: 100%" name="dummy_text11" /></td>      </td>
			<!-- Kommentarzeile ein			
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
    
			<td> <?php echo 'Telefon falsch (1=falsch)' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_dummy_number2() ?>" placeholder="<?php echo 'Telefon falsch' ?>" type="text" name="dummy_number2" /></td>             
			<td> <?php echo 'E-Mail falsch (1=falsch)' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_dummy_number3() ?>" placeholder="<?php echo 'E-Mail falsch' ?>" type="text" name="dummy_number3" /></td>  			
			Kommentar aus //--> 
			<td bgcolor=#FF00000> <?php echo 'CONNECT (Telefonnr gibt es)<font color="#fffafa">[0=NEIN,1=JA]</font>' ?>
            <input class="column" value="<?php echo $ticket->get_dummy_text3() ?>" placeholder="<?php echo 'CONNECT (Telefonnr gibt es)' ?>" type="text" name="dummy_text3" id="dummy_text3" /></td> 
			<td bgcolor=#FF00000> <?php echo 'RPC(Schuldner ereicht)<font color="#fffafa">[0=NEIN,1=JA]</font>' ?>
			<input class="column" value="<?php echo $ticket->get_dummy_text4() ?>" placeholder="<?php echo '(Schuldner ereicht' ?>" type="text" name="dummy_text4" id="dummy_text4" /></td>  	
			<td bgcolor=#FF00000> <?php echo 'PTP(Vereinbarung Bezahlung)<font color="#fffafa">[0=NEIN,1=JA]</font>' ?>
             <input class="column" value="<?php echo $ticket->get_dummy_text5() ?>" placeholder="<?php echo '(Vereinbarung Bezahlung)' ?>" type="text" name="dummy_text5" id="dummy_text5"/></td>    
			
        </tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_TEL ?></td>
            <td>
                <input style="width: 170px" placeholder="<?php echo TXT_LBL_TEL ?>" name="telefon" class="column" type="text" value="<?php echo $ticket->get_telefon() ?>" /> 
				<img style="vertical-align: middle;" src="../images/telephone.png" id="callTelco1" name="callTelco1" width="16" height="16" />
            </td>
            <td><?php echo TXT_LBL_TELEFON2 ?></td>
            <td>
                <input style="width: 170px" placeholder="<?php echo TXT_LBL_TELEFON2 ?>" name="telefon2" class="column" type="text" value="<?php echo $ticket->get_telefon2() ?>" /> 
				<img style="vertical-align: middle;" src="../images/telephone.png" id="callTelco2" name="callTelco2" onClick="callTelco2('telefon')" width="16" height="16" />
            </td>
			<td ><?php echo 'CO-Borrower Telnr' ?></td>
            <td>
                <input style="width: 170px" placeholder="<?php echo 'CO-Borrower' ?>" name="dummy_text12" class="column" type="text" value="<?php echo $ticket->get_dummy_text12() ?>" /> 
				<img style="vertical-align: middle;" src="../images/telephone.png" id="callTelco3" name="callTelco3" onClick="callTelco3('telefon')" width="16" height="16" />
            </td> 	
			<td bgcolor=#81F7F3><?php echo TXT_LBL_QUEST1 ?></td>
            <td colspan="3" style="padding-right: 14px"><input readonly="readonly"  value="<?php echo $ticket->get_textinfo1() ?>" placeholder="<?php echo TXT_LBL_QUEST1 ?>" style="width: 100%" name="textinfo1" type="text" /></td>			
        </tr>
		<tr >
			<!-- Kommentarzeile ein
            <td bgcolor=#FFFF00><?php echo 'TelnrApl' ?></td>
            <td>
                <input style="width: 170px" placeholder="<?php echo 'TelnrApl' ?>" name="dummy_text11" class="column" type="text" value="<?php echo $ticket->get_dummy_text11() ?>" /> 
				<img style="vertical-align: middle;" src="../images/telephone.png" id="callTelco1" name="callTelco1" width="16" height="16" />
            </td>
            <td bgcolor=#FFFF00><?php echo 'ArbPlatz' ?></td>
            <td>
                <input style="width: 170px" placeholder="<?php echo 'ArbPlatz' ?>" name="dummy_text12" class="column" type="text" value="<?php echo $ticket->get_dummy_text12() ?>" /> 
            </td>
			Kommentar aus //--> 
            <td bgcolor=#FF00000> <?php echo 'Kontakt mit / Optin' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_standort() ?>" placeholder="<?php echo 'Kontakt mit / Optin' ?>" type="text" name="standort" /></td>  			
 
			<td><?php echo TXT_LBL_EMAIL ?></td>
            <td> 
			    <input placeholder="<?php echo TXT_LBL_EMAIL ?>" name="email" class="column" type="email" value="<?php echo $ticket->get_email() ?>" /> <br />
			</td>    
            <td><?php echo 'CO-Borrower EMail' ?></td>
            <td> 
			    <input placeholder="<?php echo 'CO-Borrower EMail' ?>" name="dummy_text7" class="column" type="email" value="<?php echo $ticket->get_dummy_text7() ?>" /> <br />
			<td bgcolor=#98FB98 ><?php echo 'Datenabgleich' ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant11_janein_id"  id="textant11_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant11_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>		
			<td ></td>              
			<td ></td> 	            
	
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
            <td bgcolor=#FF00000> <?php echo 'Kontakt-Telnr/EMail' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_verkaeufercode() ?>" placeholder="<?php echo 'Kontakt-Telnr/EMail' ?>" type="text" name="verkaeufercode" /></td>  
			<td ></td>              
			<td ></td> 
			<td ></td>              
			<td ></td>    
            <td bgcolor=#81F7F3><?php echo TXT_LBL_QUEST2 ?></td>
            <td colspan="3" style="padding-right: 14px"><input readonly="readonly" value="<?php echo $ticket->get_textinfo2() ?>" placeholder="<?php echo TXT_LBL_QUEST2 ?>" style="width: 100%" name="textinfo2" type="text" /></td>			
				

        </tr>

       </tr>
			<tr >
           <td bgcolor=#FF00000> <?php echo 'Telefon1Falsch' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_modell() ?>" placeholder="<?php echo 'Telefon1Falsch' ?>" type="text" name="modell" /></td>  			
            <td bgcolor=#FF00000> <?php echo 'Telefon2Falsch' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_amtliches_kennzeichen() ?>" placeholder="<?php echo 'Telefon2Falsch' ?>" type="text" name="amtliches_kennzeichen" /></td>  
            <td bgcolor=#FF00000> <?php echo 'Email falsch' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_verkaeufername() ?>" placeholder="<?php echo 'Email falsch' ?>" type="text" name="verkaeufername" /></td>  			
						<!-- Kommentarzeile ein

           <td bgcolor=#FFFF00> <?php echo 'AplTelnrVW' ?></td>
            <td bgcolor=#FFFF00> <input class="column" value="<?php echo $ticket->get_dummy_text13() ?>" placeholder="<?php echo 'AplTelnrVW' ?>" type="text" name="dummy_text13" /></td>  			
            <td bgcolor=#FFFF00> <?php echo 'AplTelnrHW' ?></td>
            <td bgcolor=#FFFF00> <input class="column" value="<?php echo $ticket->get_dummy_text14() ?>" placeholder="<?php echo 'AplTelnrHW' ?>" type="text" maxlength="9" name="dummy_text14" /></td>  			
            <td bgcolor=#FFFF00> <?php echo 'AplTelFalsch' ?></td>
            <td bgcolor=#FFFF00> <input class="column" value="<?php echo $ticket->get_dummy_text15() ?>" placeholder="<?php echo 'AplTelFalsch' ?>" type="text" name="dummy_text15" /></td>  			
           					Kommentar aus //--> 
			<td bgcolor=#98FB98><?php echo 'Lösungsvorschlag' ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant22_nummern_id"  id="textant22_nummern_id">
			        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($nummern as $p) { ?>
                        <option <?php if ($ticket->get_textant22_nummern_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>				
            <td bgcolor=#FF00000> <?php echo 'Referenz Unterticket PTP' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_markencode() ?>" placeholder="<?php echo 'Referenz Unterticket PTP' ?>" type="text" name="markencode" /></td> 
        </tr>
			<!-- Kommentarzeile ein
			<tr bgcolor="#D3D3D3">
            <td bgcolor=#FF00000> <?php echo 'NEUE TelnrVW' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_verkaeufername() ?>" placeholder="<?php echo 'NEUE TelnrVW' ?>" type="text" name="verkaeufername" /></td>  			
            <td bgcolor=#FF00000> <?php echo 'NEUE TelnrHW' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_markencode() ?>" placeholder="<?php echo 'NEUE TelnrHW' ?>" type="text" name="markencode" /></td>  			
			Kommentar aus //-->  
			<td ></td>              
			<td ></td>              
            <td bgcolor=#FF00000> <?php echo 'Email falsch' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_verkaeufername() ?>" placeholder="<?php echo 'Email falsch' ?>" type="text" name="verkaeufername" /></td>  			
            <td bgcolor=#FF00000> <?php echo 'CO-Borrower Email falsch' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_dummy_text14() ?>" placeholder="<?php echo 'CO-Borrower Email falsch' ?>" type="text" maxlength="9" name="dummy_text14" /></td>  			
 	     	<td bgcolor=#98FB98> <?php echo 'Überfälliger Aussenstand=Zahlungsbetrag' ?></td>
            <td bgcolor=#98FB98> <input value="<?php echo $ticket->get_dummy_number6() ?>" placeholder="<?php echo 'Überfälliger Aussenstand=Zahlungsbetrag' ?>" class="column" type="decimal" name="dummy_number6" /></td>    </td> 
 	     	<td bgcolor=#98FB98> <?php echo 'maximaler PTP' ?>
			 	<input style="width:80px;" class="column" value="<?php echo $ticket->get_dummy_date1() ?>" placeholder="<?php echo 'maximaler PTP' ?>" type="date" name="dummy_date1" /></td>
 	     	<td bgcolor=#98FB98> <?php echo 'vereinbarter PTP' ?>
			<input style="width:80px;" class="column" value="<?php echo $ticket->get_dummy_date4() ?>" placeholder="<?php echo 'vereinbarter PTP' ?>" type="date" name="dummy_date4" /></td>			

        </tr>
					<tr bgcolor="#D3D3D3">
			<!-- Kommentarzeile ein

           <td bgcolor=#FF00000> <?php echo 'Telefon1Falsch' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_modell() ?>" placeholder="<?php echo 'Telefon1Falsch' ?>" type="text" name="modell" /></td>  			
            <td bgcolor=#FF00000> <?php echo 'Telefon2Falsch' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_amtliches_kennzeichen() ?>" placeholder="<?php echo 'Telefon2Falsch' ?>" type="text" name="amtliches_kennzeichen" /></td>  			
			Kommentar aus //-->  
           <td bgcolor=#FFFF00> <?php echo 'Status of the phone call' ?></td>
            <td bgcolor=#FFFF00> <input readonly="readonly" class="column" value="<?php echo $ticket->get_dummy_text13() ?>" placeholder="<?php echo 'Status of the phone call' ?>" type="text" name="dummy_text13" /></td>  			<td ></td>              
			<td ></td>              
			<td ></td> 		
			<td ></td> 	
			<td bgcolor=#98FB98><?php echo 'SEPA Ja/Nein' ?></td>
            <td bgcolor=#98FB98><select class="column" name="produkt_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($produkt as $p) { ?>
                        <option <?php if ($ticket->get_produkt_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td> 
			<td bgcolor=#98FB98><?php echo 'Abbuchungsdatum Wunsch' ?></td>
			<td > 	<input style="width:80px;" class="column" value="<?php echo $ticket->get_dummy_date2() ?>" placeholder="<?php echo 'Abbuchungsdatum Wunsch' ?>" type="date" name="dummy_date2" /></td>
		


        </tr>

		        <tr >
			<td bgcolor=#F7D358><?php echo TXT_LBL_STATUS ?></td>
            <td bgcolor=#F7D358>
                <select class="column" name="status_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($status as $p) { ?>
                        <option <?php if ($ticket->get_status_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
			<td bgcolor=#F7D358><?php echo TXT_LBL_CALL_STATE ?></td>
            <td bgcolor=#F7D358>
                <select class="column" name="anruf_status_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($anruf_status as $p) { ?>
                        <option <?php if ($ticket->get_anruf_status_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
            <td bgcolor=#F7D358><?php echo 'Reason of delay' ?></td>
			<td bgcolor=#F7D358>
                <select class="column" name="dummy_id1">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($dummy_id1  as $p) { ?>
                        <option <?php if ($ticket->get_dummy_id1() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
			</td>	
            <td bgcolor=#F7D358><?php echo 'Grund für Beendigung des Anrufs' ?></td>
			<td bgcolor=#F7D358>
                <select class="column" name="dummy_id2">
                    <option value="-1"><?php echo 'Grund für Beendigung des Anrufs'?></option>
                    <?php foreach ($dummy_id2  as $p) { ?>
                        <option <?php if ($ticket->get_dummy_id2() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
			</td>		
			<td bgcolor=#F7D358><?php echo 'Leistung Anstoss' ?></td>
            <td bgcolor=#F7D358>
                <select class="column" name="dummy_id3">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($dummy_id3  as $p) { ?>
                        <option <?php if ($ticket->get_dummy_id3() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select></td>
							<!-- Kommentarzeile ein
		   <td bgcolor=#98FB98><?php echo TXT_LBL_WIEDERVORLAGE ?></td>            
            <td bgcolor=#98FB98>
				<input style="width:80px;" class="column" value="<?php echo $ticket->get_wiedervorlage() ?>" placeholder="<?php echo TXT_LBL_WIEDERVORLAGE ?>" type="date" name="wiedervorlage" />		
			</td>				

             <td bgcolor=#98FB98><?php echo TXT_LBL_LETZTER_ANRUF ?></td>           
            <td bgcolor=#98FB98> 
				<input disabled  class="column" value="<?php echo $ticket->get_letzter_anruf()." ".TXT_LBL_LETZTER_ANRUF_GESAMT." ".$ticket->get_anzahl_anrufe() ?>" type="date" name="anruf_info" /> 
			</td>  			
			
            <td bgcolor=#98FB98><?php echo "Letzte Vorlage"  ?></td>           
            <td bgcolor=#98FB98>
				<input disabled style="width:180px;" class="column" value="<?php echo $ticket->get_letzte_wiedervorlage()." ".$ticket->get_letzte_wiedervorlage_zeitpunkt() ?>" type="date" name="letzte_wiedervorlage_info" />
			</td>
				Kommentar aus //--> 			

		</tr>
				
		<!-- Kommentarzeile ein
		<tr bgcolor="#D3D3D3">
            <td><button  onclick="copyToClipboard('ergebnis')" id="copy-button">Kopieren</button></td>
          //   20210215 
            <td><a class="button" onclick="setNote('M', 'ergebnis', '<?php echo  App::$CURRENT->USER->get_nachname()?>','<?php echo App::$CURRENT->USER->get_vorname() ?>')" ><?php echo "Notiz" ?></a></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>			
            <td>&nbsp;</td>
            <td>&nbsp;</td>            
				Kommentar aus //--> 	

        </tr>		
	
        <tr >
            <td bgcolor=#98FB98><?php echo TXT_LBL_RESULT ?><br><button  onmouseover="copyToClipboard('ergebnis')" id="copy-button">Kopieren</button><a class="button" onclick="setNote('M', 'ergebnis', '<?php echo  App::$CURRENT->USER->get_nachname()?>','<?php echo App::$CURRENT->USER->get_vorname() ?>')" ><?php echo "Notiz" ?></a></td>
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
            <td><?php echo '<font color "red"> <center> <marquee>!!! A C H T U N G !!! </marquee>   <br> Änderungen zu Kunden und  zur Forderung im HAUPTTICKET<br><br>' ?>
				<br><a href="http://10.10.2.211/kimi_SB/modules/gui/templates/tickets/43/SBERBANK_Leitfaden.pdf" target="_blank"><b>Leitfaden</b></a><br>
				<a href="http://10.10.2.211/kimi_SB/modules/gui/templates/tickets/43/SBERBANK_Dokumentation.pdf" target="_blank"><b>Dokumentation</b></a><br>
				<a href="http://10.10.2.211/kimi_SB/kimibatch/sberbankcheck.php" target="_blank"><b>SBERBANK_Check</b></a><br><br>
				<a href="http://10.10.2.211/kimi_SB/kimibatch/sberbank07_unterticket_aufbauen.php?name=kimi&hauptticketnr=XXXXXXX" target="_blank"><b>UNTERTICKET AUFBAUEN</b></a>
				<?php echo '</center></font>' ?>
			</td>	
            <td bgcolor=#98FB98 colspan="4" style="padding-right: 14px"><textarea rows="6" style="width: 100%" placeholder="<?php echo 'INTERNER VERMERK' ?>" name="dummy_text10"><?php echo $ticket->get_dummy_text10() ?></textarea></td>
        </tr>
      
        <tr >
            <td><?php echo TXT_LBL_BEGIN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_beginn() ?>" placeholder="<?php echo TXT_LBL_BEGIN ?>" type="date" name="beginn" /></td>
            <td><?php echo TXT_LBL_END ?></td>
            <td><input required value="<?php echo $ticket->get_ende() ?>" placeholder="<?php echo TXT_LBL_END ?>" class="column" type="date" name="ende" /></td>
            <td><?php echo TXT_LBL_STUNDEN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_aufwand() ?>" placeholder="<?php echo TXT_LBL_STUNDEN ?>" type="text" name="aufwand" /></td>                       
            <td>&nbsp;</td>
            <td bgcolor=#FF00000></td>			
			<td bgcolor=#FF00000><a class="button" onclick="kopieren()" ><?php echo 'SONSTIGE (individuelle Bearbeitung)' ?></a></td>
            <td bgcolor=#FF00000></td>			

		</tr>
		
    </table>