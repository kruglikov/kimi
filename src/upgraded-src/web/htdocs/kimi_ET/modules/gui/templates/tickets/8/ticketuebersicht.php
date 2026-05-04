<script lang="javascript">

    function kopieren() {

        var htmlText="";
        var emailBody="";
        var emailForm="";
        var emailSubject="";
        var formRef = document.forms['formTicket'];
	

        // EMail-Subject
        emailSubject="KIMI-Plus - OKO Telefonat mit " +  formRef.elements['nachname'].value +" Aktnr: #" +formRef.elements['dummy_text9'].value; 
        
        // EMail-Inhalt
        emailBody = "Sehr geehrte Damen und Herren,<br><br>";
        emailBody += "hiermit möchten wir Sie über folgendes OKO Gespräch, das wir für Sie geführt haben, informieren:<br><br>";
        emailBody += "Aktnr: " +formRef.elements['dummy_text9'].value +  "<br>";
        emailBody += "Name: "  + formRef.elements['nachname'].value + "<br>";
		emailBody += "  "  + "<br>";
		emailBody += "Anschrift: " +  formRef.elements['ort'].value + " " + formRef.elements['strasse'].value +"<br>";
        emailBody += "Telefon1: " + formRef.elements['telefon'].value +"<br>";
		emailBody += "Telefon2: " + formRef.elements['telefon2'].value +"<br>";
		emailBody += "  "  + "<br>";
		emailBody += "Aufgabe: " + formRef.elements['beschreibung_detail'].value +"<br>";
		emailBody += "  "  + "<br>";
		emailBody += "Ergebnis: " + formRef.elements['ergebnis'].value + "<br>";
		var selection = formRef.elements['textant22_nummern_id']
        var selectedText = selection.options[selection.selectedIndex].text;
		emailBody += "Lösungsvorschlag: " + selectedText + "<br>";
		var selection = formRef.elements['textant21_janein_id']
        var selectedText = selection.options[selection.selectedIndex].text;
		emailBody += "Zahlschein: " + selectedText + "<br>";
 		var selection = formRef.elements['textant31_janein_id']
        var selectedText = selection.options[selection.selectedIndex].text;
        emailBody += "Vorlage: " + selectedText + "<br>";
 		var selection = formRef.elements['textant41_janein_id']
        var selectedText = selection.options[selection.selectedIndex].text;
        emailBody += "Mahnsperre: " + selectedText + "<br>";		
 		var selection = formRef.elements['grund_id']
        var selectedText = selection.options[selection.selectedIndex].text;
        emailBody += "Ratenbriefhinweis: " + selectedText + "<br>";				
		emailBody += "Ratenhöhe: " + formRef.elements['dummy_number6'].value +"<br>";
		emailBody += "Zahlung am: " + formRef.elements['dummy_date1'].value +"<br>";
		emailBody += "<br><br>";
        // Gruß
        emailBody += "<br><br>";
        emailBody += "Mit freundlichem Gruß" +"<br><br>";
        emailBody += "<?php echo App::$CURRENT->USER->get_vorname().' '.App::$CURRENT->USER->get_nachname(); ?>" +"<br>";
        emailBody += "KIMI-Plus Service Team" +"<br>";
        emailBody += "<br>";
        emailBody += "im Auftrag der:" +"<br>";
        emailBody += "<br>";
        emailBody += "KIMI-Plus GmbH, Hafenstraße 1-3, 4020 Linz, Österreich" +"<br>";
        emailBody += "Telefon: +43(0) 732 2099, mail: <a href='mailto:kundenservice@kimi-plus.at'>kundenservice@kimi-plus.at</a>, Internet: <a href='http://www.kimi-plus.at' target='_blank'>www.kimi-plus.at</a>" + "<br>";
        emailBody += "<br><br><br>";

        emailForm += "<form id=\"formTicketView\" action=\"./libs/addons/phpmail/send_ticket_mail.php\" method=\"post\" accept-charset=\"UTF-8\" > ";
        emailForm += "<input type=\"hidden\" name=\"mail_to\" value=\"<?php echo App::$CURRENT->MANDANT->get_email(); ?>\" />";
        emailForm += "<input type=\"hidden\" name=\"mail_to_name\" value=\"<?php echo App::$CURRENT->MANDANT->get_text(); ?>\" />";
        emailForm += "<input type=\"hidden\" name=\"subject\" value=\"" + emailSubject + "\" />";
        emailForm += "<input type=\"hidden\" name=\"body\" value=\"" +  $('<div/>').text(emailBody).html() + "\" />";
        <?php if (App::$CURRENT->MANDANT->get_email() != NULL) { ?>
        emailForm += "<input type=\"submit\" value=\"EMail an <?php echo App::$CURRENT->MANDANT->get_email(); ?> senden\" />";
        <?php } ?>
        emailForm += "</form>";
       
       
        // INFO: wird ab hier bis zum return auskommentiert wird die bisherige Übersicht angezeigt!
        
        htmlText += "<html><head>";
        htmlText += "<title>Ticket - Zusammenfassung</title>";
        htmlText += "<meta charset=\"utf-8\">";
        htmlText += "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
        htmlText += "</head>";
        htmlText += "<body BGCOLOR=#FFFFFF TEXT=#000000 LINK=#0000FF VLINK=#663399 ALINK=#FF0000>";
        htmlText += "<div align=\"center\"><center>";
        htmlText +="<br><br>";
        htmlText +="<FONT SIZE=+3>Übersicht Ticketdetails für Ticket Nr.: "+formRef.elements['ticketnr'].value;
        htmlText +="</FONT>";
        htmlText += "<div align=\"left\"><left>";
        htmlText += "<P><TABLE width=100% border=0 cellpadding=1 cellspacing=0 bordercolor=#CCCCCC>";
        htmlText += "<colgroup>";
        htmlText += "<col width=\"10%\">";
        htmlText += "<col width=\"90\">";
        htmlText += "</colgroup>";
        htmlText += " ";

        htmlText += "<b>"+emailSubject+"</b><br><br><br>";
        htmlText += emailBody;
        htmlText += emailForm;


        htmlText += "</TABLE>"
        htmlText += "</body></html>"

        var infowindow = window.open("","_blank");
        infowindow.document.write(htmlText);
        infowindow.document.close();
        return;

        // ab hier ist die bisherige Ticketübersicht !!!

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
        htmlText += "<TD>"+formRef.elements['telefon'].value 
        htmlText += "</TD>"
        htmlText += "</TR>"
		htmlText += "<TR>"
        htmlText += "<TD><?php echo 'Telefon2'?>:"
        htmlText += "</TD>"
        htmlText += "<TD>"+formRef.elements['telefon2'].value
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
		
		var selection = formRef.elements['produkt_id']
        var selectedText = selection.options[selection.selectedIndex].text;
        htmlText += "<TR>"
        htmlText += "<TD><?php echo 'Telefon'?>:"
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
		
		
		var selection = formRef.elements['textant22_nummern_id']
        var selectedText = selection.options[selection.selectedIndex].text;
        htmlText += "<TR>"
        htmlText += "<TD>&nbsp;"
        htmlText += "</TD>"
        htmlText += "<TD>"
        htmlText += "</TD>"
        htmlText += "</TR>"
		 
		var selection = formRef.elements['textant22_nummern_id']
        var selectedText = selection.options[selection.selectedIndex].text;
        htmlText += "<TR>"
        htmlText += "<TD><?php echo 'Lösungsvorschlag' ?>:"
        htmlText += "</TD>"
        htmlText += "<TD>"+selectedText
        htmlText += "</TD>"
        htmlText += "</TR>"	
		
		
		var selection = formRef.elements['grund_id']
        var selectedText = selection.options[selection.selectedIndex].text;
        htmlText += "<TR>"
        htmlText += "<TD><?php echo 'Hintergrund'?>:"
        htmlText += "</TD>"
        htmlText += "<TD>"+selectedText
        htmlText += "</TD>"
        htmlText += "</TR>"

        /*
        var selection = formRef.elements['textant21_janein_id']
        var selectedText = selection.options[selection.selectedIndex].text;
        htmlText += "<TR>"
        htmlText += "<TD><?php echo TXT_LBL_ANSW21?>:"
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
        */

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
        /*
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
        htmlText += "<TD><?php echo TXT_LBL_ERSTZULASSUNG?>:"
        htmlText += "</TD>"
        htmlText += "<TD>"+formRef.elements['erstzulassung'].value
        htmlText += "</TD>"
        htmlText += "</TR>"

        htmlText += "<TR>"
        htmlText += "<TD><?php echo TXT_LBL_KUNDENZULASSUNG?>:"
        htmlText += "</TD>"
        htmlText += "<TD>"+formRef.elements['kundenzulassung'].value
        htmlText += "</TD>"
        htmlText += "</TR>"

        htmlText += "<TR>"
        htmlText += "<TD><?php echo TXT_LBL_MODELL?>:"
        htmlText += "</TD>"
        htmlText += "<TD>"+formRef.elements['markencode'].value+" "+formRef.elements['modell'].value
        htmlText += "</TD>"
        htmlText += "</TR>"

        htmlText += "<TR>"
        htmlText += "<TD><?php echo TXT_LBL_AMTLICHES_KENNZEICHEN?>:"
        htmlText += "</TD>"
        htmlText += "<TD>"+formRef.elements['amtliches_kennzeichen'].value
        htmlText += "</TD>"
        htmlText += "</TR>"

        htmlText += "<TR>"
        htmlText += "<TD><?php echo TXT_LBL_KILOMETERSTAND?>:"
        htmlText += "</TD>"
        htmlText += "<TD>"+formRef.elements['kilometer_stand'].value
        htmlText += "</TD>"
        htmlText += "</TR>"

        htmlText += "<TR>"
        htmlText += "<TD><?php echo TXT_LBL_FAHRGESTELLNUMMER?>:"
        htmlText += "</TD>"
        htmlText += "<TD>"+formRef.elements['fahrgestellnummer'].value
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
        */
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
        /*
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
        */


        htmlText += "</TABLE>"
        htmlText += "</body></html>"

        var infowindow = window.open("","_blank");
        infowindow.document.write(htmlText);
        infowindow.document.close();
    }

</script>