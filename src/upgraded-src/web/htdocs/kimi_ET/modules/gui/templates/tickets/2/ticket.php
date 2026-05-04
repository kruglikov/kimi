    <table>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_TICKETNR ?></td>
            <td><input required class="column" name="ticketnr" placeholder="<?php echo TXT_LBL_TICKETNR ?>" type="text" value="<?php echo $ticket->get_ticketnr() ?>" /></td>
           <td><?php echo "Art" ?></td>
            <td bgcolor=#98FB98><select class="column" name="grund_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($grund as $p) { ?>
                        <option <?php if ($ticket->get_grund_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
			<td bgcolor=#98FB98><?php echo 'Betreibung' ?></td>
            <td bgcolor=#FF00000>
                <select class="column" name="prioritaet_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($prioritaet as $p) { ?>
                        <option <?php if ($ticket->get_prioritaet_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
			<td><?php echo TXT_LBL_USER ?></td>
            <td>
                <select required class="column" name="benutzer_id"  id="benutzer_id">
                    <?php foreach ($benutzer as $p) { ?>
                        <option <?php if ($ticket->get_benutzer_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_name() ?></option>
                    <?php } ?>
                </select>
            </td>
			<!-- Kommentarzeile ein			
			<td bgcolor=#98FB98><?php echo 'StatusForderung/nächster Schritt'  ?></td>
			<td bgcolor=#98FB98 colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo5	() ?>" placeholder="<?php echo TXT_LBL_INFO1 ?>" style="width: 100%" name="textinfo5" type="text" /></td>
						Kommentar aus //--> 
		</tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_TASK ?></td>
			<!-- Kommentarzeile ein
            
			<td colspan="5" style="padding-right: 14px"><input value="<?php echo $ticket->get_beschreibung_detail() ?>" placeholder="<?php echo TXT_LBL_TASK ?>" style="width: 100%" name="beschreibung_detail" type="text" /></td>
				Kommentar aus //--> 
 
			<td bgcolor=#98FB98 colspan="5" style="padding-right: 14px"><textarea rows="2" style="width: 100%" placeholder="<?php echo 'Aufgabe' ?>" name="beschreibung_detail"><?php echo $ticket->get_beschreibung_detail() ?></textarea></td>
			<!-- Kommentarzeile ein
			<td >Sachbearbeiter</td>
			<td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_kenner() ?>" placeholder="<?php echo 'Sachbearbeiterinformationen' ?>" style="width: 100%" name="kenner" type="text" /></td>
        				Kommentar aus //--> 
			<td>  
			</td>
			<td >
			 
			</td>
			<td >
			 
			</td>
			
	</tr>
		<tr bgcolor="#D3D3D3">
		
            <td bgcolor=#F7D358> <?php echo 'Hotel' ?></td>
            <td colspan="3" style="padding-right: 20px"> <input readonly="readonly" value="<?php echo $ticket->get_fahrgestellnummer() ?>" placeholder="<?php echo 'Hotel' ?>" class="column" type="text" style="background-color:#F7D358; border:0px;" style="width: 100%" name="fahrgestellnummer" /></td>      
            <td > <?php echo 'AKTnummer' ?></td>
            <td> <input value="<?php echo $ticket->get_dummy_text9() ?>" placeholder="<?php echo 'AKTnummer' ?>" class="column" type="text" name="dummy_text9" /></td> 
			<td >
			 
				</td>		
			<td >	
		 
			
			</td>
			<td >	
		 
			
			</td>

						<!-- Kommentarzeile ein
			<td> <a href="http://10.20.12.14/kimi/kimi_ET/modules/gui/templates/tickets/10/knpdoku.pdf" target="_blank"><b>KNP Financial Service DOKU</b></a></td>
            <td>&nbsp;</td>
            <td><a href="http://10.20.12.14/kimi/kimi_ET/kimibatch/knp1check.php" target="_blank"><b>KNP Financial Service CHECK	</b></a></td>
			        				Kommentar aus //--> 
        </tr>
								<!-- Kommentarzeile ein
		        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_KDNR ?></td>
            <td><input value="<?php echo $ticket->get_kundennummer() ?>" placeholder="<?php echo TXT_LBL_KDNR ?>" class="column" name="kundennummer" type="text" /></td>
	        				Kommentar aus //--> 	
			<td ><?php echo 'Anrede' ?></td>
            <td ><input value="<?php echo $ticket->get_anrede() ?>" placeholder="<?php echo 'Anrede' ?>" class="column" name="anrede" type="text" /></td>
            <td></td>	
			<td></td>
			<td bgcolor=#FF00000> <?php echo 'Saldo' ?></td></td>
            <td bgcolor=#FF00000> <input value="<?php echo $ticket->get_dummy_number4() ?>" placeholder="<?php echo 'Saldo' ?>" class="column" type="decimal" name="dummy_number4" /></td>    
             <td >
			 
			 </td>	
			<td>
			 
			</td>
			<td >	
		 
			
			</td>			
									<!-- Kommentarzeile ein
			<td > <?php echo 'IBAN' ?></td>
            <td> <input value="<?php echo $ticket->get_dummy_text1() ?>" placeholder="<?php echo 'IBAN' ?>" class="column" type="text" name="dummy_text1" /></td>      
			<td> <?php echo 'BIC' ?></td>
            <td> <input value="<?php echo $ticket->get_dummy_text2() ?>" placeholder="<?php echo 'BIC' ?>" class="column" type="text" name="dummy_text2" /></td>  
			        				Kommentar aus //-->  
 </tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_LASTNAME ?></td>
            <td><input value="<?php echo $ticket->get_nachname() ?>" placeholder="<?php echo TXT_LBL_LASTNAME ?>" class="column" type="text" name="nachname" /></td>
            <td><?php echo TXT_LBL_FIRSTNAME ?></td>
            <td><input value="<?php echo $ticket->get_vorname() ?>" placeholder="<?php echo TXT_LBL_FIRSTNAME ?>" class="column" type="text" name="vorname" /></td>
												<!-- Kommentarzeile ein   
            <td bgcolor=#FF00000> <?php echo 'Verzzinsen' ?></td>
									<!-- Kommentarzeile ein     
			<td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_dummy_text8() ?>" placeholder="<?php echo 'Verzinsen' ?>" type="text" name="dummy_text8" /></td>            
			<td bgcolor=#FF00000> <?php echo 'CONNECT (Telefonnr gibt es)' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_dummy_text3() ?>" placeholder="<?php echo 'CONNECT (Telefonnr gibt es)' ?>" type="text" name="dummy_text3" id="dummy_text3" /></td> 
			<td bgcolor=#FF00000> <?php echo 'RPC(Schuldner ereicht)' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_dummy_text4() ?>" placeholder="<?php echo '(Schuldner ereicht' ?>" type="text" name="dummy_text4" id="dummy_text4" /></td>  			
			        				Kommentar aus //-->  
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
            <td> <?php echo 'Geburtsdatum' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_geburtsdatum() ?>" placeholder="<?php echo 'Geburtsdatum' ?>" type="date" name="geburtsdatum" /></td>            
									<!-- Kommentarzeile ein		
			<td bgcolor=#FF00000> <?php echo 'PTP(Vereinbarung Bezahlung)<font color="#fffafa">[0=NEIN,1=JA]</font>' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_dummy_text5() ?>" placeholder="<?php echo '(Vereinbarung Bezahlung)' ?>" type="text" name="dummy_text5" id="dummy_text5"/></td>             
			<!-- Kommentarzeile ein
 
			<td> <?php echo 'IndexA' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_dummy_number1() ?>" placeholder="<?php echo 'IndexA' ?>" type="text" name="dummy_number1" /></td>  
            <td ></td>	
			<td ></td>
				
			<td bgcolor=#F7D358> <?php echo 'ANGEBOT Zahlung' ?></td>
			<td style="padding-right: 14px"><input readonly="readonly" style="width: 170px" placeholder="<?php echo 'ANGEBOT Zahlung' ?>" name="dummy_text11" class="column" type="text" value="<?php echo $ticket->get_dummy_text11() ?>" /> </td>
 Kommentar aus //--> 	
 </tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_STR ?></td>
            <td><input class="column" value="<?php echo $ticket->get_strasse() ?>" placeholder="<?php echo TXT_LBL_STR ?>" type="text" name="strasse" /></td>
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
				Kommentar aus //--> 
            <td ></td>	
			<td ></td>
			<td bgcolor=#FF00000 > <?php echo 'Alter' ?></td>
            <td bgcolor=#FF00000 > <input class="column" value="<?php echo $ticket->get_dummy_number5() ?>" placeholder="<?php echo 'Alter' ?>" type="text" name="dummy_number5" /></td>          
 			<!-- Kommentarzeile ein

			<td> <?php echo 'IndexB' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_dummy_number2() ?>" placeholder="<?php echo 'IndexB' ?>" type="text" name="dummy_number2" /></td>             
			<td> <?php echo 'IndexC' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_dummy_number3() ?>" placeholder="<?php echo 'IndexC' ?>" type="text" name="dummy_number3" /></td>  			
		
            <td bgcolor=#FFFF00> <?php echo 'mögliche Raten' ?></td>
			<td colspan="3" style="padding-right: 14px" bgcolor=#FFFF00><input  placeholder="<?php echo 'mögliche Raten' ?>" name="dummy_text11" class="column" style="width: 100%" type="text" value="<?php echo $ticket->get_dummy_text11() ?>" /> </td>
 		
            <td bgcolor=#F7D358> <?php echo 'MINDEST Zahlung' ?></td>
			<td style="padding-right: 14px"><input readonly="readonly" style="width: 170px" placeholder="<?php echo 'Mindest Zahlung' ?>" name="dummy_text12" class="column" type="text" value="<?php echo $ticket->get_dummy_text12() ?>" /> </td>
 Kommentar aus //--> 
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
            <td><?php echo TXT_LBL_EMAIL ?></td>
            <td> 
			    <input placeholder="<?php echo TXT_LBL_EMAIL ?>" name="email" class="column" type="email" value="<?php echo $ticket->get_email() ?>" /> <br />
			</td>    
									<!-- Kommentarzeile ein
			<td bgcolor=#98FB98><?php echo TXT_LBL_QUEST1 ?></td>
            <td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo1() ?>" placeholder="<?php echo TXT_LBL_QUEST1 ?>" style="width: 100%" name="textinfo1" type="text" /></td>			
        </tr>
		<tr >
		 <td bgcolor=#FF00000> <?php echo 'Telefon1Falsch' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_modell() ?>" placeholder="<?php echo 'Telefon1Falsch' ?>" type="text" name="modell" /></td>  			
            <td bgcolor=#FF00000> <?php echo 'Telefon2Falsch' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_amtliches_kennzeichen() ?>" placeholder="<?php echo 'Telefon2Falsch' ?>" type="text" name="amtliches_kennzeichen" /></td>  			

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
	
  
		<td bgcolor=#98FB98><?php echo 'Anrufzeitpunkt' ?></td>
            <td><select class="column" name="firma_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($firma as $p) { ?>
                        <option <?php if ($ticket->get_firma_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select></td>
										<!-- Kommentarzeile ein
            <td bgcolor=#98FB98 ><?php echo 'Lösungsbereitschaft' ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant11_janein_id"  id="textant11_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant11_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
				<td bgcolor=#98FB98><?php echo 'Vorlage Ja/Nein' ?></td>
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

            <td bgcolor=#F7D358> <?php echo 'späteste Fälligkeit' ?></td>
			<td style="padding-right: 14px"><input readonly="readonly" style="width: 170px" placeholder="<?php echo 'späteste Fälligkeit' ?>" name="dummy_text13" class="column" type="text" value="<?php echo $ticket->get_dummy_text13() ?>" /> </td>
        Kommentar aus //--> 
		</tr>
			<tr >
            <td bgcolor=#FF00000> <?php echo 'KontaktTelnr' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_verkaeufercode() ?>" placeholder="<?php echo 'KontaktTelnr' ?>" type="text" name="verkaeufercode" /></td>  
            <td ></td>	
			<td ></td>
				<!-- Kommentarzeile ein
			
            <td bgcolor=#FF00000> <?php echo 'KontaktTelnrHW' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_standort() ?>" placeholder="<?php echo 'KontaktTelnrHW' ?>" type="text" name="standort" /></td>  		
				Kommentar aus //--> 
			
           <td bgcolor=#98FB98><?php echo TXT_LBL_WIEDERVORLAGE ?></td>            
            <td bgcolor=#98FB98>
				<input style="width:80px;" class="column" value="<?php echo $ticket->get_wiedervorlage() ?>" placeholder="<?php echo TXT_LBL_WIEDERVORLAGE ?>" type="date" name="wiedervorlage" />
				<select style="width:115px;" class="column" name="wiedervorlage_zeitpunkt">
					<option <?php if($ticket->get_wiedervorlage_zeitpunkt()=="" | $ticket->get_wiedervorlage_zeitpunkt()==TXT_LBL_NOONE) echo "selected"; ?> value="<?php echo TXT_LBL_NOONE?>"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($anrufzeiten as $p) { ?>
						<option <?php if ($ticket->get_wiedervorlage_zeitpunkt() == $p->get_text()) echo "selected"; ?> value="<?php echo $p->get_text() ?>"><?php echo $p->get_text() ?></option>
					<?php } ?>
				</select>
				<?php echo "<br>"?>
				<input type="checkbox" name="wiedervorlage_automatik" value="<?php echo $ticket->get_wiedervorlage_automatik() ?>" <?php if($ticket->get_wiedervorlage_automatik()==1) echo " checked "?>  /><?php echo TXT_LBL_AUTOMATISCH?>
			</td>
									<!-- Kommentarzeile ein
		    <td bgcolor=#98FB98><?php echo TXT_LBL_QUEST2 ?></td>
            <td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo2() ?>" placeholder="<?php echo TXT_LBL_QUEST2 ?>" style="width: 100%" name="textinfo2" type="text" /></td>			
				
				Kommentar aus //--> 
        </tr>
		
		<tr >
		    <td bgcolor=#FF00000> <?php echo 'NEUE Telnr' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_verkaeufername() ?>" placeholder="<?php echo 'NEUE Telnr' ?>" type="text" name="verkaeufername" /></td>  

				<!-- Kommentarzeile ein

			<td bgcolor=#FFFF00> <?php echo 'AplTelnrVW' ?></td>
            <td bgcolor=#FFFF00> <input class="column" value="<?php echo $ticket->get_dummy_text13() ?>" placeholder="<?php echo 'AplTelnrVW' ?>" type="text" name="dummy_text13" /></td>  			
            <td bgcolor=#FFFF00> <?php echo 'AplTelnrHW' ?></td>
            <td bgcolor=#FFFF00> <input class="column" value="<?php echo $ticket->get_dummy_text14() ?>" placeholder="<?php echo 'AplTelnrHW' ?>" type="text" maxlength="9" name="dummy_text14" /></td>  			
            <td bgcolor=#FFFF00> <?php echo 'AplTelFalsch' ?></td>
            <td bgcolor=#FFFF00> <input class="column" value="<?php echo $ticket->get_dummy_text15() ?>" placeholder="<?php echo 'AplTelFalsch' ?>" type="text" name="dummy_text15" /></td>  			
				Kommentar aus //--> 
            <td ></td>	
			<td ></td>
            <td ></td>	
			<td ></td>		
				<!-- Kommentarzeile ein			
			<td bgcolor=#98FB98><?php echo 'Lösungsvorschlag' ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant22_nummern_id"  id="textant22_nummern_id">
			        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($nummern as $p) { ?>
                        <option <?php if ($ticket->get_textant22_nummern_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>				
            <td bgcolor=#98FB98><?php echo 'BeschäftigunsStatus' ?></td>
            <td bgcolor=#98FB98><select class="column" name="grund_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($grund as $p) { ?>
                        <option <?php if ($ticket->get_grund_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>				
				
						Kommentar aus //--> 
				

        </tr>
		
			<tr bgcolor="#D3D3D3">
            <td ></td>	
			<td ></td> 
            <td ></td>	
			<td ></td> 
			<td ></td> 
			<td ></td>
				<!-- Kommentarzeile ein	
	     	<td bgcolor=#FFFF00> <?php echo 'Zahlbetrag' ?></td>
            <td bgcolor=#FFFF00> <input value="<?php echo $ticket->get_dummy_number6() ?>" placeholder="<?php echo 'Zahlbetrag' ?>" class="column" type="decimal" name="dummy_number6" /></td>    </td> 
            <td bgcolor=#FFFF00> <?php echo 'Zahlung am' ?></td>
            <td bgcolor=#FFFF00> <input class="column" value="<?php echo $ticket->get_dummy_date1() ?>" placeholder="<?php echo 'Zahlung am' ?>" type="date" name="dummy_date1" /></td>            
			Kommentar aus //--> 
            <td ></td>	

        </tr>

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
			<td bgcolor=#98FB98><?php echo TXT_LBL_CALL_STATE ?></td>
            <td bgcolor=#98FB98>
                <select class="column" name="anruf_status_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($anruf_status as $p) { ?>
                        <option <?php if ($ticket->get_anruf_status_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
            <td bgcolor=#98FB98><?php echo TXT_LBL_LETZTER_ANRUF ?></td>           
            <td bgcolor=#98FB98> 
				<input disabled  class="column" value="<?php echo $ticket->get_letzter_anruf()." ".TXT_LBL_LETZTER_ANRUF_GESAMT." ".$ticket->get_anzahl_anrufe() ?>" type="date" name="anruf_info" /> 
			</td>  			
							<!-- Kommentarzeile ein	
            <td bgcolor=#98FB98><?php echo "Letzte Vorlage"  ?></td>           
            <td bgcolor=#98FB98>
				<input disabled style="width:180px;" class="column" value="<?php echo $ticket->get_letzte_wiedervorlage()." ".$ticket->get_letzte_wiedervorlage_zeitpunkt() ?>" type="date" name="letzte_wiedervorlage_info" />
			</td>

           <td bgcolor=#FF00000><?php echo "Abschlussgrund" ?></td>
            <td bgcolor=#FF00000>
                <select class="column" name="prioritaet_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($prioritaet as $p) { ?>
                        <option <?php if ($ticket->get_prioritaet_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
            			Kommentar aus //--> 
		</tr>
		
					<tr bgcolor="#D3D3D3">
            <td><button  onclick="copyToClipboard('ergebnis')" id="copy-button">Kopieren</button></td>
            <!-- 20210215 -->
            <td><a class="button" onclick="setNote('M', 'ergebnis', '<?php echo  App::$CURRENT->USER->get_nachname()?>','<?php echo App::$CURRENT->USER->get_vorname() ?>')" ><?php echo "Notiz" ?></a></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
   
		
        <tr >
            <td bgcolor=#98FB98><?php echo TXT_LBL_RESULT ?><br><button  onmouseover="copyToClipboard('ergebnis')" id="copy-button">Kopieren</button>
			</td>
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
            <td bgcolor=#98FB98 colspan="6" style="padding-right: 14px"><textarea rows="6" style="width: 100%" placeholder="<?php echo 'INFO' ?>" name="dummy_text10"><?php echo $ticket->get_dummy_text10() ?></textarea></td>
        </tr>
      
        <tr >
            <td><?php echo TXT_LBL_BEGIN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_beginn() ?>" placeholder="<?php echo TXT_LBL_BEGIN ?>" type="date" name="beginn" /></td>
            <td><?php echo TXT_LBL_END ?></td>
            <td><input required value="<?php echo $ticket->get_ende() ?>" placeholder="<?php echo TXT_LBL_END ?>" class="column" type="date" name="ende" /></td>
            <td><?php echo TXT_LBL_STUNDEN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_aufwand() ?>" placeholder="<?php echo TXT_LBL_STUNDEN ?>" type="text" name="aufwand" /></td>                       
            <td>&nbsp;</td>
			<td><a class="button" onclick="kopieren()" ><?php echo TXT_LBL_COPYTICKET ?></a></td>
			<td >&nbsp;</td>            
            <td >&nbsp;</td>
		</tr>
		
    </table>