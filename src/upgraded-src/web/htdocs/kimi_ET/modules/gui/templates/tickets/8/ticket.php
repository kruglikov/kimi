    <table>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_TICKETNR ?></td>
            <td><input required class="column" name="ticketnr" placeholder="<?php echo TXT_LBL_TICKETNR ?>" type="text" value="<?php echo $ticket->get_ticketnr() ?>" /></td>
            <td bgcolor=#F7D358><?php echo 'Art' ?><br>
			        <select class="column" name="dummy_id1">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($dummy_id1  as $p) { ?>
                        <option <?php if ($ticket->get_dummy_id1() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
			</td>
			<td><?php echo TXT_LBL_BEGIN ?><br>
            <input class="column" value="<?php echo $ticket->get_beginn() ?>" placeholder="<?php echo TXT_LBL_BEGIN ?>" type="date" name="beginn" /></td>
			<td><?php echo TXT_LBL_USER ?><br>
                <select required class="column" name="benutzer_id"  id="benutzer_id">
                    <?php foreach ($benutzer as $p) { ?>
                        <option <?php if ($ticket->get_benutzer_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_name() ?></option>
                    <?php } ?>
                </select>
            </td>
			<td> &nbsp;</td>			
			<td bgcolor=#98FB98><?php echo TXT_LBL_INFO1 ?></td>
			<td bgcolor=#98FB98 colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo5	() ?>" placeholder="<?php echo TXT_LBL_INFO1 ?>" style="width: 100%" name="textinfo5" type="text" /></td>
		
		</tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_TASK ?></td>
            <td colspan="5" style="padding-right: 14px"><textarea rows="2" style="width: 95%" placeholder="<?php echo TXT_LBL_TASK ?>" name="beschreibung_detail"><?php echo $ticket->get_beschreibung_detail() ?></textarea></td>			
            <td> <?php echo 'Sachbearbeiter' ?></td>			
            <td> <input class="column" value="<?php echo $ticket->get_dummy_text5() ?>" placeholder="<?php echo 'Sachbearbeiter' ?>" type="text" name="dummy_text5" /></td>             
            <!-- Kommentarzeile ein
			<td ><a href="https://10.196.69.11/kimi_ET/modules/gui/templates/tickets/8/OKO_Sachbearbeiter.pdf" target="_blank"><b>OKO_Sachbearbeiter</b></a> </td>
			<td >
			<a href="https://10.196.69.11/kimi_ET/modules/gui/templates/tickets/8/OKO_Leitfaden.pdf" target="_blank"><b>OKO_Leitfaden</b></a> 
			<a href="https://10.196.69.11/kimi_ET/kimibatch/OKO_Leitfaden.pdf" target="_blank"><b>OKO_Leitfaden</b></a> 			
            <!-- Kommentarzeile ein Kommentar aus //--> 												
			<td ><a href="https://10.196.69.11/kimi_ET/kimibatch/OKO_SachbearbeiterNEU.pdf" target="_blank"><b>OKO_Sachbearbeiter</b></a> </td>
			<td ><a href="https://10.196.69.11/kimi_ET/kimibatch/OKO_Leitfaden.pdf" target="_blank"><b>OKO_Leitfaden</b></a> 	
			<a href="https://10.196.69.11/kimi_ET/kimibatch/OKO_Leitfaden_20220627.pdf" target="_blank"><b>OKO_LeitfadenNEU</b></a> 			
			
			<a href="https://10.196.69.11/kimi_ET/kimibatch/okocheck.php" target="_blank"><b>OKO_Check</b></a>
			</td>
        </tr>
		<tr bgcolor="#D3D3D3">
			<td > <?php echo 'Gl-Name' ?></td>
            <td colspan="3" > <input class="column" value="<?php echo $ticket->get_dummy_text3() ?>" placeholder="<?php echo 'Gl-Name' ?>" style="width: 95%" type="text" name="dummy_text3" /></td> 
			<td > <?php echo 'Aktnr:' ?></td>
            <td> <input value="<?php echo $ticket->get_dummy_text9() ?>" placeholder="<?php echo 'Aktnr' ?>" class="column" type="text" name="dummy_text9" /></td> 
			<td > <?php echo 'IBAN' ?></td>
            <td> <input value="<?php echo $ticket->get_dummy_text1() ?>" placeholder="<?php echo 'IBAN' ?>" class="column" type="text" name="dummy_text1" /></td>      
			<td> <?php echo 'BIC (Allg. Sparkasse Linz)' ?></td>
            <td> <input value="<?php echo $ticket->get_dummy_text2() ?>" placeholder="<?php echo 'BIC' ?>" class="column" type="text" name="dummy_text2" /></td>  			
			</tr>
		    <tr bgcolor="#D3D3D3">
            <!-- Kommentarzeile ein
            <td><?php echo 'Stadium-Betreibung' ?></td>
            <td><input value="<?php echo $ticket->get_kenner() ?>" placeholder="<?php echo 'Stadium-Betreibung' ?>" class="column" name="kenner" type="text" /></td>
            <!-- Kommentarzeile ein Kommentar aus //--> 									
            <td> </td>
            <td> </td> 
            <td> </td>
            <td> </td> 
			<td bgcolor=#FF00000> <?php echo 'Saldo Einmalzahlung' ?></td></td>
            <td bgcolor=#FF00000> <input value="<?php echo $ticket->get_dummy_number4() ?>" placeholder="<?php echo 'Saldo Einmalzahlung' ?>" class="column" type="decimal" name="dummy_number4" /></td>            
			<td bgcolor=#FF00000><?php echo 'Gesamtzahlung Ratenzahlung' ?></td>
			<td bgcolor=#FF00000> <input value="<?php echo $ticket->get_dummy_number3() ?>" placeholder="<?php echo 'Gesamtzahlung Ratenzahlung' ?>" class="column" type="decimal" name="dummy_number3" /></td>    </td>
			<td bgcolor=#FF00000><?php echo 'FälligBis' ?></td>
			<td bgcolor=#FF00000>  <input class="column" value="<?php echo $ticket->get_dummy_date2() ?>" placeholder="<?php echo 'FälligBis' ?>" type="date" name="dummy_date2" /></td>            
			</tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_LASTNAME ?></td>
            <td colspan="3" ><input value="<?php echo $ticket->get_nachname() ?>" placeholder="<?php echo TXT_LBL_LASTNAME ?>" class="column" style="width: 95%" maxlength="50" type="text" name="nachname" /></td>
            <!-- Kommentarzeile ein
			<td><?php echo TXT_LBL_FIRSTNAME ?></td>
			<td><input value="<?php echo $ticket->get_vorname() ?>" placeholder="<?php echo TXT_LBL_FIRSTNAME ?>" class="column" type="text" name="vorname" /></td>
            Kommentar aus //-->    
            <!-- Kommentarzeile ein Kommentar aus //--> 			
			<td bgcolor=#FF00000> <?php echo 'Mitschuldner' ?></td>
			<td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_dummy_text8() ?>" placeholder="<?php echo 'Mitschuldner' ?>" type="text" name="dummy_text8" /></td>            
			<td bgcolor=#FF00000> <?php echo 'Ratenanzahl' ?></td>
            <td bgcolor=#FF00000> <input value="<?php echo $ticket->get_dummy_number1() ?>" placeholder="<?php echo 'Ratenanzahl' ?>" class="column" type="decimal" name="dummy_number1" /></td>    </td> 
			<td bgcolor=#FF00000> <?php echo 'Ratenhoehe' ?></td>
            <td bgcolor=#FF00000> <input value="<?php echo $ticket->get_dummy_number2() ?>" placeholder="<?php echo 'Ratenhoehe' ?>" class="column" type="decimal" name="dummy_number2" /></td>    </td> 
        </tr>
        <tr bgcolor="#D3D3D3">
		<!-- Kommentarzeile ein 
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
		
		Kommentar aus //--> 			
		<td><?php echo TXT_LBL_ORT ?><button  onmouseover="copyToClipboard('ort')" id="copy-button">Copy</button></td>
            <td colspan="3" ><input class="column" value="<?php echo $ticket->get_ort() ?>" placeholder="<?php echo TXT_LBL_ORT ?>" style="width: 95%" maxlength="50" type="text" name="ort" /></td>
			<td> <?php echo 'Geburtsdatum' ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_geburtsdatum() ?>" placeholder="<?php echo 'Geburtsdatum' ?>" type="date" name="geburtsdatum" /></td>            
			<td> &nbsp;</td>
            <td> &nbsp;</td> 
			<td> &nbsp;</td>
            <td> &nbsp;</td> 
        </tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_STR ?><br><button  onmouseover="copyToClipboard('strasse')" id="copy-button">Copy</button></td>
            <td colspan="3" ><input class="column" value="<?php echo $ticket->get_strasse() ?>" placeholder="<?php echo TXT_LBL_STR ?>" style="width: 95%" maxlength="50" type="text" name="strasse" /></td>
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
            <td bgcolor=#FF00000 > <?php echo 'Alter' ?></td>
            <td bgcolor=#FF00000 > <input class="column" value="<?php echo $ticket->get_dummy_number5() ?>" placeholder="<?php echo 'Alter' ?>" type="text" name="dummy_number5" /></td>          
			<!-- Kommentarzeile ein
			<td bgcolor=#98FB98><?php echo TXT_LBL_QUEST1 ?></td>
            <td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo1() ?>" placeholder="<?php echo TXT_LBL_QUEST1 ?>" style="width: 100%" name="textinfo1" type="text" /></td>			
			Kommentar aus //--> 
            <td bgcolor=#FF00000><?php echo 'Identifikation' ?></td>
			<td bgcolor=#FF00000><select required class="column" name="textant21_janein_id"  id="textant21_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant21_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
			<!-- Kommentarzeile ein
			
			<td bgcolor=#FF00000> <?php echo 'eMail-Check' ?></td>
            <td bgcolor=#FF00000><select required class="column" name="textant41_janein_id"  id="textant41_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant41_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
			</td>   
			Kommentar aus //--> 
			<td> &nbsp;</td>
            <td> &nbsp;</td> 
			
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
           <td bgcolor=#98FB98 ><?php echo TXT_LBL_ANSW11 ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant11_janein_id"  id="textant11_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant11_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
			<td bgcolor=#98FB98><?php echo 'Telefon' ?></td>
            <td bgcolor=#98FB98><select class="column" name="produkt_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($produkt as $p) { ?>
                        <option <?php if ($ticket->get_produkt_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td> 
			Kommentar aus //--> 
			<td bgcolor=#ff00ff> <?php echo 'Vorlage' ?></td>
            <td bgcolor=#ff00ff><select required class="column" name="textant31_janein_id"  id="textant31_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant31_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>			
           <!-- Kommentarzeile ein			
				
			<td bgcolor=#98FB98> <?php echo 'Arbeitgeberdaten' ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant11_janein_id"  id="textant11_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant11_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>	        </tr>
			Kommentar aus //--> 
				
			<td> &nbsp;</td>
            <td> &nbsp;</td> 
				
		<tr >
            <td bgcolor=#FFFF00><?php echo "weitere Telefonnummern (tele4+)?" ?></td>
            <td bgcolor=#FFFF00><input placeholder="<?php echo "weitere Telefonnummern (tele4+)" ?>" name="dummy_text6" class="column" type="text" value="<?php echo $ticket->get_dummy_text6() ?>" /> <br /></td>
            <td bgcolor=#FFFF00><?php echo "Telefon 3" ?></td>
            <td>
                <input style="width: 170px" placeholder="<?php echo "Telefon 3" ?>" name="dummy_text7" class="column" type="text" value="<?php echo $ticket->get_dummy_text7() ?>" /> 
				<img style="vertical-align: middle;" src="../images/telephone.png" id="callTelco3"  name="callTelco3" onClick="callTelco3()" width="16" height="16" alt="dummy_text7"  />
            </td>			
	
			<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td bgcolor=#98FB98><?php echo TXT_LBL_QUEST1 ?></td>
            <td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo2() ?>" placeholder="<?php echo TXT_LBL_QUEST1 ?>" style="width: 100%" name="textinfo2" type="text" /></td>			
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
            <td bgcolor=#FF00000> <?php echo 'KontaktTelnr' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_dummy_text4() ?>" placeholder="<?php echo 'KontaktTelnr' ?>" type="text" name="dummy_text4" /></td>  			
            <td bgcolor=#FF00000> <?php echo 'NeueTelnr' ?></td>
            <td bgcolor=#FF00000> <input class="column" value="<?php echo $ticket->get_standort() ?>" placeholder="<?php echo 'NeueTelnr' ?>" type="text" name="standort" /></td>  			
			<td>&nbsp;</td>
            <td>&nbsp;</td>			
			<!-- Kommentarzeile ein
            <td><select class="column" name="firma_id">

                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($firma as $p) { ?>
                        <option <?php if ($ticket->get_firma_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select></td>
				Kommentar aus //--> 
				
            <td bgcolor=#98FB98><?php echo 'Lösungsvorschlag' ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant22_nummern_id"  id="textant22_nummern_id">
			        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($nummern as $p) { ?>
                        <option <?php if ($ticket->get_textant22_nummern_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>				
            <td bgcolor=#98FB98><?php echo 'RatenbriefHinweis' ?></td>
            <td bgcolor=#98FB98><select class="column" name="grund_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($grund as $p) { ?>
                        <option <?php if ($ticket->get_grund_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>				
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
			<td>&nbsp;</td>
            <td>&nbsp;</td>
		
			<!-- Kommentarzeile ein
 
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
				Kommentar aus //--> 

			<td bgcolor=#98FB98> <?php echo 'Ratenhöhe' ?></td></td>
            <td bgcolor=#98FB98> <input value="<?php echo $ticket->get_dummy_number6() ?>" placeholder="<?php echo 'Ratenhöhe' ?>" class="column" type="decimal" name="dummy_number6" /></td>            
            <td bgcolor=#98FB98> <?php echo 'Zahlung am' ?>
            <input class="column" value="<?php echo $ticket->get_dummy_date1() ?>" placeholder="<?php echo 'Zahlung am' ?>" type="date" name="dummy_date1" />
            <td bgcolor=#98FB98>
				<?php echo 'Datum ZAHLUNG AM geprüft?' ?>
		         <select required class="column" name="textant41_janein_id"  id="textant41_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant41_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
			</td> 
			</td>            
				
		</tr>

		<tr style='visibility:collapse'>
            <td> </td>
            <td> </td>  			
            <td bgcolor=#98FB98><?php echo TXT_LBL_LETZTER_ANRUF ?></td>           
            <td bgcolor=#98FB98> 
				<input disabled  class="column" value="<?php echo $ticket->get_letzter_anruf()." ".TXT_LBL_LETZTER_ANRUF_GESAMT." ".$ticket->get_anzahl_anrufe() ?>" type="date" name="anruf_info" /> 
			</td>  			
			
            <td bgcolor=#98FB98><?php echo "Letzte Vorlage"  ?></td>           
            <td bgcolor=#98FB98>
				<input disabled style="width:180px;" class="column" value="<?php echo $ticket->get_letzte_wiedervorlage()." ".$ticket->get_letzte_wiedervorlage_zeitpunkt() ?>" type="date" name="letzte_wiedervorlage_info" />
			</td>
            <td ></td>
            <td ></td>			
				

        </tr>		
		
        <tr style='visibility:collapse'>
          <td bgcolor=#00BFFF><?php echo 'SCB-KorrKZ' ?></td>
            <td bgcolor=#00BFFF>
                <select class="column" name="prioritaet_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($prioritaet as $p) { ?>
                        <option <?php if ($ticket->get_prioritaet_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
			<td colspan="6">Belegen wenn Gläubiger "Santander Consumer Bank GmbH, Wagramer Straße 19,1220 Wien"</td>            
            

        </tr>
        <tr >
            <td bgcolor=#98FB98><?php echo TXT_LBL_RESULT ?><br><button  onmouseover="copyToClipboard('ergebnis')" id="copy-button">Kopieren</button></td>
            <td bgcolor=#98FB98 colspan="5" style="padding-right: 14px"><textarea rows="6" maxlength="420" style="width: 100%" placeholder="<?php echo TXT_LBL_RESULT ?>" name="ergebnis"><?php echo $ticket->get_ergebnis() ?></textarea></td>
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
            <td bgcolor=#98FB98 colspan="4" style="padding-right: 14px"><textarea rows="6" style="width: 100%" placeholder="<?php echo 'INFO' ?>" name="dummy_text10"><?php echo $ticket->get_dummy_text10() ?></textarea></td>
        </tr>
      
        <tr style='visibility:collapse' >
            <td><?php echo TXT_LBL_BEGIN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_beginn() ?>" placeholder="<?php echo TXT_LBL_BEGIN ?>" type="date" name="beginn" /></td>
            <td><?php echo TXT_LBL_END ?></td>
            <td><input required value="<?php echo $ticket->get_ende() ?>" placeholder="<?php echo TXT_LBL_END ?>" class="column" type="date" name="ende" /></td>
            <td><?php echo TXT_LBL_STUNDEN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_aufwand() ?>" placeholder="<?php echo TXT_LBL_STUNDEN ?>" type="text" name="aufwand" /></td>                       
			 <!-- Kommentarzeile ein
			 <td><?php echo TXT_LBL_QUEST4 ?></td>
            <td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo4() ?>" placeholder="<?php echo TXT_LBL_QUEST4 ?>" style="width: 100%" name="textinfo4" type="text" /></td>
			Kommentar aus //--> 
            <td colspan="3" ><a class="button" onclick="kopieren()" ><?php echo TXT_LBL_COPYTICKET ?></a></td>

		</tr>
        <tr >
            <td></td>            
            <td></td> 
			<td></td>            
            <td></td>                     
            <td></td>
            <td></td>
			
			<!-- Kommentarzeile ein
			<td><?php echo TXT_LBL_ANSW41 ?></td>
            <td><select required class="column" name="textant41_janein_id"  id="textant41_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant41_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
				<!-- Kommentarzeile ein
			<td><?php echo TXT_LBL_ANSW42 ?></td>
            <td><select required class="column" name="textant42_nummern_id"  id="textant42_nummern_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($nummern as $p) { ?>
                        <option <?php if ($ticket->get_textant42_nummern_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
				Kommentar aus //--> 
            <td></td>            
            <td></td> 

        </tr>
    </table>