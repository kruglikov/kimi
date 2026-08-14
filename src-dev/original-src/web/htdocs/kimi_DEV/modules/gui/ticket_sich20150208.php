<script lang="javascript">

function kopieren() { 

var htmlText=""; 
var formRef = document.forms['formTicket'];

htmlText += "<html><head>" 
htmlText += "<title>Ticket - Zusammenfassung</title>" 
htmlText += "</head>" 
htmlText += "<body BGCOLOR=#FFFFFF TEXT=#000000 LINK=#0000FF VLINK=#663399 ALINK=#FF0000>" 
htmlText += "<div align=\"center\"><center>" 
htmlText +="<br><br>"
htmlText +="<FONT SIZE=+3>Übersicht Ticketdetails für Ticket Nr.: "+formRef.elements['ticketnr'].value
htmlText +="</FONT>" 
htmlText += "<div align=\"left\"><left>" 
htmlText += "<P><TABLE width=100% border=0 cellpadding=1 cellspacing=0 bordercolor=#CCCCCC>"
htmlText += "<colgroup>" 
htmlText += "<col width=\"10%\">"
htmlText += "<col width=\"90\">"
htmlText += "</colgroup>"
htmlText += " " 



htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_TICKETNR?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['ticketnr'].value
htmlText += "</TD>" 
htmlText += "</TR>" 


var selection = formRef.elements['prioritaet_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_PRIORITY?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>" 


var selection = formRef.elements['benutzer_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_USER?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_TASK?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['beschreibung_detail'].value
htmlText += "</TD>" 
htmlText += "</TR>"   


htmlText += "<TR><TD>&nbsp</TD><TD></TD></TR>" 
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_KDNR?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['kundennummer'].value
htmlText += "</TD>" 
htmlText += "</TR>"  

htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_NAME?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['vorname'].value+" "+formRef.elements['nachname'].value
htmlText += "</TD>" 
htmlText += "</TR>"  



var selection = formRef.elements["land_id"];
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_STR?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['strasse'].value+" "+formRef.elements['hausnummer'].value+" "+formRef.elements['hausnummer_erw'].value
htmlText += "</TD>" 
htmlText += "</TR>"  
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_PLZ?>/<?php echo TXT_LBL_ORT?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText+" "+formRef.elements['plz'].value+" "+formRef.elements['ort'].value
htmlText += "</TD>" 
htmlText += "</TR>"  
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_TEL?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['telefon'].value+" "+formRef.elements['telefon2'].value
htmlText += "</TD>" 
htmlText += "</TR>"  
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_EMAIL?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['email'].value
htmlText += "</TD>" 
htmlText += "</TR>" 


htmlText += "<TR><TD>&nbsp</TD><TD></TD></TR>" 
var selection = formRef.elements['status_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_STATUS?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>" 


var selection = formRef.elements['anruf_status_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_CALL_STATE?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "</TR>"  
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_WIEDERVORLAGE?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['wiedervorlage'].value
htmlText += "</TD>" 
htmlText += "</TR>" 


htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_RESULT?>:" 
htmlText += "</TD>" 	
htmlText += "<TD>"+formRef.elements['ergebnis'].value
htmlText += "</TD>" 
htmlText += "</TR>"  

htmlText += "<TR>" 
htmlText += "<TD>&nbsp;" 
htmlText += "</TD>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_QUEST1?>:"
htmlText += "</TD>" 
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['textinfo1'].value
htmlText += "</TD>"
htmlText += "</TR>"

var selection = formRef.elements['textant11_janein_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_ANSW11?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>"

var selection = formRef.elements['textant12_nummern_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_ANSW12?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_QUEST2?>:"
htmlText += "</TD>" 
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['textinfo2'].value
htmlText += "</TD>"
htmlText += "</TR>"

var selection = formRef.elements['textant21_janein_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_ANSW21?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>"

var selection = formRef.elements['textant22_nummern_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_ANSW22?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_QUEST3?>:"
htmlText += "</TD>" 
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['textinfo3'].value
htmlText += "</TD>"
htmlText += "</TR>"

var selection = formRef.elements['textant31_janein_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_ANSW31?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>"


htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_QUEST4?>:"
htmlText += "</TD>" 
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['textinfo4'].value
htmlText += "</TD>"
htmlText += "</TR>"

var selection = formRef.elements['textant41_janein_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_ANSW41?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>"


/*
var selection = formRef.elements['textant42_nummern_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD>&nbsp;" 
htmlText += "</TD>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "</TR>"
*/

htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_STANDORT?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['standort'].value
htmlText += "</TD>" 
htmlText += "</TR>"  

htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_VERKAEUFER?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['verkaeufercode'].value+" "+formRef.elements['verkaeufername'].value
htmlText += "</TD>" 
htmlText += "</TR>" 

htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_LTZT_WKST_AUFTRAG?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['ltzt_wkst_auftrag'].value
htmlText += "</TD>" 
htmlText += "</TR>"


htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_DIREKTKONTAKT?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['erstzulassung'].value
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_DIREKTKONTAKT?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['kundenzulassung'].value
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "<TR>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "<TR>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "<TR>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "<TR>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "</TR>"


htmlText += "<TR>" 
htmlText += "<TD>&nbsp;" 
htmlText += "</TD>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "<TR>" 
htmlText += "<TD>&nbsp;" 
htmlText += "</TD>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "</TR>"

htmlText += "<TR>" 
htmlText += "<TD>&nbsp;" 
htmlText += "</TD>" 
htmlText += "<TD>"
htmlText += "</TD>" 
htmlText += "</TR>"

/*
var selection = formRef.elements['firma_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_FIRMA	?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>"

var selection = formRef.elements['produkt_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_PRODUKT?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>"


var selection = formRef.elements['grund_id']
var selectedText = selection.options[selection.selectedIndex].text;
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_GRUND?>:" 
htmlText += "</TD>" 
htmlText += "<TD>"+selectedText
htmlText += "</TD>" 
htmlText += "</TR>"
*/

htmlText += "<TR><TD>&nbsp</TD><TD></TD></TR>"
htmlText += "</TR>"  
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_BEGIN?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['beginn'].value
htmlText += "</TD>" 
htmlText += "</TR>" 


htmlText += "</TR>"  
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_END?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['ende'].value
htmlText += "</TD>" 
htmlText += "</TR>" 


htmlText += "</TR>"  
htmlText += "<TR>" 
htmlText += "<TD><?php echo TXT_LBL_STUNDEN?>:"
htmlText += "</TD>" 
htmlText += "<TD>"+formRef.elements['aufwand'].value
htmlText += "</TD>" 
htmlText += "</TR>" 



htmlText += "</TABLE>" 
htmlText += "</body></html>" 

var infowindow = window.open("","_blank");
infowindow.document.write(htmlText); 
infowindow.document.close(); 
}

</script>
<h2><?php echo TXT_LBL_TICKDETAIL; ?></h2>
<form id="formTicket" method="post" <?php if (!App::$CURRENT->has_permission("ticket", "UPD") || !App::$CURRENT->has_permission("ticket", "INS")) echo "disabled"; ?>>
    <input type="hidden" name="id" value="<?php echo $ticket->get_id() ?>" />
    <input type="hidden" name="ticket_id" value="<?php echo $ticket->get_id() ?>" />
    <table>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_TICKETNR ?></td>
            <td><input required class="column" name="ticketnr" placeholder="<?php echo TXT_LBL_TICKETNR ?>" type="text" value="<?php echo $ticket->get_ticketnr() ?>" /></td>
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
			<td bgcolor=#f50af5 ><?php echo TXT_LBL_INFO1 ?></td>
			<td bgcolor=#f50af5 colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo5	() ?>" placeholder="<?php echo TXT_LBL_INFO1 ?>" style="width: 100%" name="textinfo5" type="text" /></td>
		
		</tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_TASK ?></td>
            <td colspan="5" style="padding-right: 14px"><input value="<?php echo $ticket->get_beschreibung_detail() ?>" placeholder="<?php echo TXT_LBL_TASK ?>" style="width: 100%" name="beschreibung_detail" type="text" /></td>
			<td ></td>
			<td ></td>
			<td>&nbsp;</td>
		    <td>&nbsp;</td>					
        </tr>
		<tr bgcolor="#D3D3D3">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
		        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_KDNR ?></td>
            <td><input value="<?php echo $ticket->get_kundennummer() ?>" placeholder="<?php echo TXT_LBL_KDNR ?>" class="column" name="kundennummer" type="text" /></td>
            <td ></td>
            <td> </td> 
			<td ></td>
            <td></td>            
			<td bgcolor=#98FB98> <?php echo TXT_LBL_VERKAEUFERCODE ?></td>
            <td> <input value="<?php echo $ticket->get_verkaeufercode() ?>" placeholder="<?php echo TXT_LBL_VERKAEUFERCODE ?>" class="column" type="text" name="verkaeufercode" /></td>      
			<td bgcolor=#98FB98> <?php echo TXT_LBL_VERKAEUEFERNAME ?></td>
            <td> <input value="<?php echo $ticket->get_verkaeufername() ?>" placeholder="<?php echo TXT_LBL_VERKAEUFERNAME ?>" class="column" type="text" name="verkaeufername" /></td>  			
        </tr>
        <tr bgcolor="#D3D3D3">
            <td><?php echo TXT_LBL_LASTNAME ?></td>
            <td><input value="<?php echo $ticket->get_nachname() ?>" placeholder="<?php echo TXT_LBL_LASTNAME ?>" class="column" type="text" name="nachname" /></td>
            <td><?php echo TXT_LBL_FIRSTNAME ?></td>
            <td><input value="<?php echo $ticket->get_vorname() ?>" placeholder="<?php echo TXT_LBL_FIRSTNAME ?>" class="column" type="text" name="vorname" /></td>
            <td bgcolor=#98FB98><?php echo TXT_LBL_STANDORT ?></td>
            <td>  <input value="<?php echo $ticket->get_standort() ?>" placeholder="<?php echo TXT_LBL_STANDORT ?>" class="column" type="text" name="standort" /></td>            
			<td bgcolor=#98FB98> <?php echo TXT_LBL_DIREKTKONTAKT ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_erstzulassung() ?>" placeholder="<?php echo TXT_LBL_DIREKTKONTAKT ?>" type="date" name="erstzulassung" /></td> 
			<td> <?php echo TXT_LBL_DIREKTKONTAKT ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_kundenzulassung() ?>" placeholder="<?php echo TXT_LBL_DIREKTKONTAKT ?>" type="date" name="kundenzulassung" /></td>  			
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
            <td> <?php echo TXT_LBL_MARKENCODE ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_markencode() ?>" placeholder="<?php echo TXT_LBL_MARKENCODE ?>" type="date" name="markencode" /></td>            
			<td bgcolor=#98FB98> <?php echo TXT_LBL_BAUSPARER ?> </td>
            <td> <input value="<?php echo $ticket->get_kenner() ?>" placeholder="<?php echo TXT_LBL_BAUSPARER ?>" class="column" type="text" name="kenner" /></td> 
			<td> </td>
            <td> </td>        
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
            <td> <?php echo TXT_LBL_KILOMETERSTAND ?></td>
            <td> <input class="column" value="<?php echo $ticket->get_kilometer_stand() ?>" placeholder="<?php echo TXT_LBL_KILOMETERSTAND ?>" type="date" name="kilometer_stand" /></td>            
			<td bgcolor=#98FB98><?php echo TXT_LBL_BAUSPARERDATUM ?></td></td>
            <td><input class="column" value="<?php echo $ticket->get_ltzt_wkst_auftrag() ?>" placeholder="<?php echo TXT_LBL_BAUSPARERDATUM ?>" type="date" name="ltzt_wkst_auftrag" /></td>            
			<td> </td>
            <td> </td>  			
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td bgcolor=#98FB98 ><?php echo TXT_LBL_ANSW11 ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant11_janein_id"  id="textant11_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant11_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
				
			<td bgcolor=#98FB98><?php echo TXT_LBL_ANSW12 ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant12_nummern_id"  id="textant12_nummern_id">
			        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($nummern as $p) { ?>
                        <option <?php if ($ticket->get_textant12_nummern_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
				<!-- Kommentarzeile ein
				
			<td>&nbsp;</td>
			<td>&nbsp;</td>	
			Kommentar aus //--> 
        </tr>
		        <tr bgcolor=#98FB98>
			<td><?php echo TXT_LBL_STATUS ?></td>
            <td>
                <select class="column" name="status_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($status as $p) { ?>
                        <option <?php if ($ticket->get_status_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
			<td><?php echo TXT_LBL_CALL_STATE ?></td>
            <td>
                <select class="column" name="anruf_status_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($anruf_status as $p) { ?>
                        <option <?php if ($ticket->get_anruf_status_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><?php echo TXT_LBL_WIEDERVORLAGE ?></td>            
            <td><input class="column" value="<?php echo $ticket->get_wiedervorlage() ?>" placeholder="<?php echo TXT_LBL_WIEDERVORLAGE ?>" type="date" name="wiedervorlage" /></td>
			<td><?php echo TXT_LBL_QUEST2 ?></td>
            <td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo2() ?>" placeholder="<?php echo TXT_LBL_QUEST1 ?>" style="width: 100%" name="textinfo2" type="text" /></td>
		</tr>
        <tr bgcolor=#98FB98>
            <td><?php echo TXT_LBL_RESULT ?></td>
            <td colspan="5" style="padding-right: 14px"><textarea rows="6" style="width: 100%" placeholder="<?php echo TXT_LBL_RESULT ?>" name="ergebnis"><?php echo $ticket->get_ergebnis() ?></textarea></td>
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
            <!-- Kommentarzeile ein
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
			Kommentar aus //--> 
        </tr>
        <tr >
		<!-- Kommentarzeile ein
		<td><?php echo TXT_LBL_FIRMA ?></td>                                    
            <td>
                <select class="column" name="firma_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($firma as $p) { ?>
                        <option <?php if ($ticket->get_firma_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td> 
            <td><?php echo TXT_LBL_PRODUKT ?></td>
            <td><select class="column" name="produkt_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($produkt as $p) { ?>
                        <option <?php if ($ticket->get_produkt_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td> 
            <td><?php echo TXT_LBL_GRUND ?></td>                        
            <td><select class="column" name="grund_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($grund as $p) { ?>
                        <option <?php if ($ticket->get_grund_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>              
			Kommentar aus //--> 
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td bgcolor=#98FB98><?php echo TXT_LBL_QUEST3 ?></td>
            <td bgcolor=#98FB98 colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo3() ?>" placeholder="<?php echo TXT_LBL_QUEST3 ?>" style="width: 100%" name="textinfo3" type="text" /></td>
		</tr>
		<tr >
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td bgcolor=#98FB98><?php echo TXT_LBL_ANSW31 ?></td>
            <td bgcolor=#98FB98><select required class="column" name="textant31_janein_id"  id="textant31_janein_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($janein as $p) { ?>
                        <option <?php if ($ticket->get_textant31_janein_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
				<!-- Kommentarzeile ein
			<td ><?php echo TXT_LBL_ANSW32 ?></td>
            <td><select required class="column" name="textant32_nummern_id"  id="textant32_nummern_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
					<?php foreach ($nummern as $p) { ?>
                        <option <?php if ($ticket->get_textant32_nummern_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
				</td>
				 Kommentar aus //--> 
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
        </tr>
        <tr >
            <td><?php echo TXT_LBL_BEGIN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_beginn() ?>" placeholder="<?php echo TXT_LBL_BEGIN ?>" type="date" name="beginn" /></td>
            <td><?php echo TXT_LBL_END ?></td>
            <td><input required value="<?php echo $ticket->get_ende() ?>" placeholder="<?php echo TXT_LBL_END ?>" class="column" type="date" name="ende" /></td>
            <td><?php echo TXT_LBL_STUNDEN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_aufwand() ?>" placeholder="<?php echo TXT_LBL_STUNDEN ?>" type="text" name="aufwand" /></td>                       
			 <td><?php echo TXT_LBL_QUEST4 ?></td>
            <td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_textinfo4() ?>" placeholder="<?php echo TXT_LBL_QUEST4 ?>" style="width: 100%" name="textinfo4" type="text" /></td>
		</tr>
        <tr >
            <td></td>            
            <td></td> 
			<td></td>            
            <td></td>                     
            <td></td>
            <td><a class="button" onclick="kopieren()" ><?php echo TXT_LBL_COPYTICKET ?></a></td>
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
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
        </tr>
    </table>

    <input type="hidden" name="site" value="ticket" />
    <input type="hidden" name="mandant_id" value="<?php echo $ticket->get_mandant_id(); ?>" />

    <input type="hidden" name="mode" value="<?php
    if ($mode == "SEL")
        echo "UPD"; else if ($mode == "NEW" || $mode == "INS")
        echo "INS";
    else
        echo "UPD";
    ?>" />

    <?php
    if (App::$CURRENT->has_permission("ticket", "UPD") ||
            App::$CURRENT->has_permission("ticket", "INS")) {
        ?>
        <input type="submit" value="<?php echo TXT_LBL_SAVE ?>" />
    <?php } ?>
    <?php if ($ticket_id != -1 && App::$CURRENT->has_permission("ticket", "DEL")) { ?>
        <a class="button confirm" href="./index.php?site=ticket&mode=DEL&ticket_id=<?php echo $ticket_id; ?>"><?php echo TXT_LBL_DEL ?></a>
    <?php }
    if (App::$CURRENT->has_permission("ticket", "INS")) {
        ?>
        <a class="button" href="./index.php?site=ticket"><?php echo TXT_LBL_NEW ?></a>
<?php } ?>
</form>