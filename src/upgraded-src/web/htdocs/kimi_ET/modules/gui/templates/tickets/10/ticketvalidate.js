// Validierung der Ticketbearbeitung beim Speichern

function getComboSelectedId(objElement) {
	return objElement.options[objElement.selectedIndex].value;
}
function getElementFromId(element_id) {
	return document.getElementById(element_id);
}
function getElementFromName(element_name) {
	return document.getElementsByName(element_name)[0];
}

function checkNum(input)
{
	// alert (input);
	// alert ('before for');
	// feld = input;
	// alert (feld);
	return (input - 0) == input && (''+input).trim().length > 0;

 
}





function validateFormOnSave() {
	var errMsg = '';
		
	// Hier können die Prüfungen vorgenommen werden, ist ein Fehler, so ist der Fehlertext der
	// die Variable errMsg zuzuweisen, wodurch automatisch die Meldung erfolgt und das Speichern 
	// verhindert wird.
	// Start eigene Überprüfungen

	
	// 20210702/ar
	// Prüfung Benutzer Elsbeth
	var loginUserName = document.getElementById("loginUserName").value;

	if (loginUserName == 'elsbeth') {
		var e = document.getElementById("benutzer_id");
		var selectedUser = e.options[e.selectedIndex].text;

		if (selectedUser == 'elsbeth') {
			alert('Benutzer darf nicht elsbeth sein!');
			return false;
		} else if (selectedUser == 'tausch') {
			alert('Benutzer darf nicht tausch sein!');
			return false;
		}
		// Log Eintrag
		var ticketid = document.getElementsByName("ticket_id")[0].value;
		if (ticketid != '') {
			$.ajax({
				url: "./index.php?site=add_log&ajax=true",
				type: "POST",
				data: {
					'objekt': 'TICKET',
					'objekt_id': ticketid,
					'logart': 'MAN_START',
					'logUserName': selectedUser 
				}
			});
		}
	}	
	
	// Prüfung Status/Anrufstatus
	if (errMsg=='') {
		var statusId = getComboSelectedId(getElementFromName('status_id'));
		var anrufStatusId = getComboSelectedId(getElementFromName('anruf_status_id'));
		
		// alert (statusId) ;
		
		
		// Erledigt und Anrufstatus in 234 240 241 
		if (statusId==68 && !(anrufStatusId==234 | anrufStatusId==240 | anrufStatusId==241 | anrufStatusId==445) ) {
			errMsg = 'Ungueltiger Anfrufstatus fuer Status erledigt!'; 
			check_element = getElementFromName('anruf_status_id');
		}
		
		//Wenn bei Inko ,, 1-1-0“ eingetragen wird und bei Lösungsbereitschaft ,,JA“ soll im Check eine Fehlermeldung kommen. 
				
            var textant11_janein_id = getComboSelectedId(getElementFromName('textant11_janein_id'));
            if (textant11_janein_id == 23 && document.getElementById("dummy_text3").value == "1"
                    && document.getElementById("dummy_text4").value == "1"
                    && document.getElementById("dummy_text5").value == "0" ){
                    errMsg = 'PTP muss nicht 0 sein';
				check_element = getElementFromName('dummy_text5');
            }
		// Check bei erledigt - und erreicht
		if (errMsg=='' && statusId==68) {
			// Connect
			if (errMsg=='' && anrufStatusId==234 && getElementFromName('dummy_text3').value == ''  ) {
				errMsg = 'CONNECT muss eingetragen werden!';
				check_element = getElementFromName('dummy_text3');
			}
			// RPC
			if (errMsg=='' && anrufStatusId==234 && getElementFromName('dummy_text4').value == ''  ) {
				errMsg = 'RPC muss eingetragen werden!';
				check_element = getElementFromName('dummy_text4');
			}
			// PTP
			if (errMsg=='' && anrufStatusId==234 && getElementFromName('dummy_text5').value == ''  ) {
				errMsg = 'PTP muss eingetragen werden!';
				check_element = getElementFromName('dummy_text5');
			}
			// Kontakttelefonnummer
			if (errMsg=='' && anrufStatusId==234 && getElementFromName('verkaeufercode').value == ''  ) {
				errMsg = 'KontakttelefonnummerVW muss eingetragen werden!';
				check_element = getElementFromName('verkaeufercode');
			}
			if (errMsg=='' && anrufStatusId==234 && getElementFromName('standort').value == ''  ) {
				errMsg = 'KontakttelefonnummerHW muss eingetragen werden!';
				check_element = getElementFromName('standort');
			}
			if (errMsg=='' && anrufStatusId==234 && checkNum(getElementFromName('verkaeufercode').value) == 0  ) {
				errMsg = 'KontakttelefonnummerVW nur Nummern!';
				check_element = getElementFromName('verkaeufercode');
			}	
			if (errMsg=='' && anrufStatusId==234 && checkNum(getElementFromName('standort').value) == 0  ) {
				errMsg = 'KontakttelefonnummerHW nur Nummern!';
				check_element = getElementFromName('standort');
				
			}			
			// NEUE TELEFONNUMMER wenn belegt nur NUMMER 0-9
			if (errMsg=='' && anrufStatusId==234 && getElementFromName('verkaeufername').value != ''  ) {
		
		    	if (errMsg=='' && anrufStatusId==234 && checkNum(getElementFromName('verkaeufername').value) == 0  ) {
		     		errMsg = 'NEUE TelnrVW nur Nummern!';
			    	check_element = getElementFromName('verkaeufername');			
			    }
			}
			// Neue Telefonnummer wenn belegt nur NUMMER 0-9
			if (errMsg=='' && anrufStatusId==234 && getElementFromName('markencode').value != ''  ) {
			
				if (errMsg=='' && anrufStatusId==234 && checkNum(getElementFromName('markencode').value) == 0  ) {
					errMsg = 'NEUE TelnrHW nur Nummern!';
					check_element = getElementFromName('markencode');			
				}
			}
			// Neue Telefonnummer wenn belegt dann beide VW und HW
			if (errMsg=='' && anrufStatusId==234  ) {
			    
				if (getElementFromName('markencode').value != ''  && getElementFromName('verkaeufername').value == '') {
					//alert ('X');
					errMsg = 'NEUE TelnrVW/HW nur teilweise belegt!';
					check_element = getElementFromName('markencode');			
				}
				if (getElementFromName('markencode').value == ''  && getElementFromName('verkaeufername').value != '') {
					//alert ('X');
					errMsg = 'NEUE TelnrVW/HW nur teilweise belegt!';
					check_element = getElementFromName('verkaeufername');			
				}
			}
		




			//Zeigen Sie lösungsbereitschaft? Unter welcher Telefonnummer?
			var textant11_janein_id = getComboSelectedId(getElementFromName('textant11_janein_id'));
			if (errMsg=='' && anrufStatusId==234 && textant11_janein_id == -1  ) {
				errMsg = 'Zeigen Sie lösungsbereitschaft? --- muss eingetragen werden!';
				check_element = getElementFromName('dummy_text6');
			}
			//Telefon1Falsch wenn Telefonnummer falsch muss eine eingetragen sein
			if (errMsg=='' && anrufStatusId==240 ) {
				//alert ('X');
				if (getElementFromName('modell').value == '' && getElementFromName('amtliches_kennzeichen').value == '' && getElementFromName('dummy_text15').value == ''   ) {
					errMsg = 'Telefonnummer falsch muss eingetragen sein!';
					check_element = getElementFromName('modell');			
				}
			}

			
			// Erreicht und Connect muss = 1 sein
			if (errMsg=='' && anrufStatusId==234 && getElementFromName('dummy_text3').value != '1'  ) {
				errMsg = 'CONNECT muss bei Erreicht = 1 sein!';
				check_element = getElementFromName('dummy_text3');
			}

			// Connect darf nur 0 oder 1 sein
			if (errMsg=='' && getElementFromName('dummy_text3').value > '1' ) {
				errMsg = 'CONNECT darf nur 0 oder 1 sein!';
				check_element = getElementFromName('dummy_text3');
			}
			// RPC darf nur 0 oder 1 sein
			if (errMsg=='' && getElementFromName('dummy_text4').value > '1' ) {
				errMsg = 'RPC darf nur 0 oder 1 sein!';
				check_element = getElementFromName('dummy_text4');
			}
			// PTP darf nur 0 oder 1 sein
			if (errMsg=='' && getElementFromName('dummy_text5').value > '1' ) {
				errMsg = 'PTP darf nur 0 oder 1 sein!';
				check_element = getElementFromName('dummy_text5');
			}

			// TELEFONNUMMER FALSCH und RPC darf NICHT = 1 sein
			if (errMsg=='' && anrufStatusId==240 && getElementFromName('dummy_text4').value == '1'  ) {
				errMsg = 'RPC darf bei Telefonnummer falsch NICHT = 1 sein!';
				check_element = getElementFromName('dummy_text4');
			}
			// UNNERREICHBAR und RPC darf NICHT = 1 sein
			if (errMsg=='' && anrufStatusId==241 && getElementFromName('dummy_text4').value == '1'  ) {
				errMsg = 'RPC darf bei unerreiohbar  NICHT = 1 sein!';
				check_element = getElementFromName('dummy_text4');
			}
			// UNNERREICHBAR und PTP darf NICHT = 1 sein
			if (errMsg=='' && anrufStatusId==241 && getElementFromName('dummy_text5').value == '1'  ) {
				errMsg = 'PTP darf bei unerreiohbar  NICHT = 1 sein!';
				check_element = getElementFromName('dummy_text5');
			}

			// ERREICHTAP und RPC darf NICHT = 1 sein
			if (errMsg=='' && anrufStatusId==445 && getElementFromName('dummy_text4').value == '1'  ) {
				errMsg = 'RPC darf bei erreichtap  NICHT = 1 sein!';
				check_element = getElementFromName('dummy_text4');
			}
			// ERREICHTAP und PTP darf NICHT = 1 sein
			if (errMsg=='' && anrufStatusId==445 && getElementFromName('dummy_text5').value == '1'  ) {
				errMsg = 'PTP darf bei erreichtap  NICHT = 1 sein!';
				check_element = getElementFromName('dummy_text5');
			}
			
			// TELEFONNUMMER FALSCH und KontaktnummerVW darf NICHT belegt sein
			if (errMsg=='' && anrufStatusId==240 && getElementFromName('verkaeufercode').value != ''  ) {
				errMsg = 'KontakttelefonnummerHW darf  NICHT belegt sein!';
				check_element = getElementFromName('verkaeufercode');
			}
			// TELEFONNUMMER FALSCH und KontaktnummerHW darf NICHT belegt sein
			if (errMsg=='' && anrufStatusId==240 && getElementFromName('standort').value != ''  ) {
				errMsg = 'KontakttelefonnummerHW darf  NICHT belegt sein!';
				check_element = getElementFromName('standort');
			}
			//	Wenn der Anrufstatus auf erreicht gesetzt wird und eine Zahlungsvereinbarung gibt,  dann muss beim CONNECT und beim RPC die 1 gesetzt sein!
			var textant11_janein_id = getComboSelectedId(getElementFromName('textant11_janein_id'));
			if (errMsg=='' && anrufStatusId==234 && textant11_janein_id != -1  ) {
				if (errMsg=='' && getElementFromName('dummy_text3').value != '1'  ) {
					errMsg = 'CONNECT muss bei erreicht und Lösungsbereitschaft = 1 sein!';
					check_element = getElementFromName('dummy_text3');
				}
				if (errMsg=='' && getElementFromName('dummy_text4').value != '1'  ) {
					errMsg = 'RPC muss bei erreicht und Lösungsbereitschaft = 1 sein!';
					check_element = getElementFromName('dummy_text4');
				}
			}
			//?	Wenn der Anrufstatus auf erreicht gesetzt wird, dann muss man SEPA auswählen
			var telefon = getComboSelectedId(getElementFromName('produkt_id'));
			if (errMsg=='' && anrufStatusId==234 && telefon == -1  ) {
				errMsg = 'Bei erreicht muss SEPA ausgewählt sein!';
				check_element = getElementFromName('produkt_id');
			}
			var telefon = getComboSelectedId(getElementFromName('produkt_id'));
			if (errMsg=='' && anrufStatusId==234 && (telefon == 39 || telefon == 2 || telefon == 3) && getElementFromName('dummy_number6').value == '') {
				errMsg = telefon;
				errMsg = getElementFromName('dummy_number6').value;
				errMsg = 'Bei SEPA/Email 2 und 3 muss Ratenhöhe vorhanden sein!';
				check_element = getElementFromName('produkt_id');
			}
			var telefon = getComboSelectedId(getElementFromName('produkt_id'));
			var einzugam = getComboSelectedId(getElementFromName('grund_id'));
			if (errMsg=='' && anrufStatusId==234 && (telefon == 39 || telefon == 2 || telefon == 3)&& einzugam == -1) {
				errMsg = 'Bei SEPA, EMail 2,3 muss EINZUG AM vorhanden sein!';
				check_element = getElementFromName('produkt_id');
			}
			
			//	Wenn der Anrufstatus auf erreicht gesetzt wird und eine Zahlungsvereinbarung gibt,  dann muss Lösungsvorscgkag belegt sein!
			var textant11_janein_id = getComboSelectedId(getElementFromName('textant11_janein_id'));
			var textant22_nummern_id = getComboSelectedId(getElementFromName('textant22_nummern_id'));
			if (errMsg=='' && anrufStatusId==234 && textant11_janein_id != -1  ) {
				if (errMsg=='' && textant22_nummern_id == -1  ) {
					errMsg = 'Lösungsvorschlag muss ausgewählt sein!';
					check_element = getElementFromName('textant22_nummern_id');
				}
			}
		}
		// deaktiviert am 25.6.2022 /Tafr 
		//	Wenn "Status in Bearbeitung" muss Wiedervorlage und Anrufzeitpunkt belegt sein -- 20160423/Tafr
		//var anrufzeitpunkt = getComboSelectedId(getElementFromName('firma_id'));
		//alert (statusId) ;
		//if (errMsg=='' && statusId==67 && anrufzeitpunkt == -1  ) {
		//	errMsg = 'Anrufzeitpunkt muss belegt sein!';
		//	check_element = getElementFromName('firma_id');
		//}
		//if (errMsg=='' && statusId==67 && getElementFromName('wiedervorlage').value == ''  ) {
		//	errMsg = 'Wiedervorlage muss belegt sein!';
		//	check_element = getElementFromName('wiedervorlage');
		//}	
		
		//	Wenn "Status erledigt und erreicht" muss Art belegt sein -- 20220528/Tafr
		var art = getComboSelectedId(getElementFromName('dummy_id1'));
		if (errMsg=='' && statusId== 68 && anrufStatusId == 234 && art == -1  ) {
			errMsg = 'Art OUTBOUND/INBOUND muss belegt sein!';
			check_element = getElementFromName('dummy_id1');
		}

		//	Wenn "SEPA NEIN muss genauer angegeben sein" -- 20220613/Tafr
		var sepa_janein = getComboSelectedId(getElementFromName('produkt_id'));	
		// alert (sepa_janein)
		if (errMsg=='' && statusId==68 && anrufStatusId == 234 && sepa_janein == 38  ) {
			errMsg = 'SEPA NEIN muss mit Grund genauer angegeben sein!';
			check_element = getElementFromName('dummy_id1');
		}	
		
		//	Wenn "SEPA = JA muss Anrede belegt sein " -- 20220613/Tafr
		var sepa_janein = getComboSelectedId(getElementFromName('produkt_id'));	
		var sepa_anrede = getComboSelectedId(getElementFromName('dummy_id2'));
		if (errMsg=='' && statusId==68 && anrufStatusId == 234 && (sepa_janein == 39 || sepa_janein == 1 || sepa_janein == 2 || sepa_janein == 3) && sepa_anrede == -1  ) {
			errMsg = 'SEPA, EMail 1,2,3 Anrede muss belegt sein!';
			check_element = getElementFromName('dummy_id1');
		}	

		//	Wenn "SEPA = JA muss EMAIL belegt sein " -- 20220617/Tafr
		var sepa_janein = getComboSelectedId(getElementFromName('produkt_id'));	
		if (errMsg=='' && statusId==68 && anrufStatusId == 234 && (sepa_janein == 39 || sepa_janein == 1 || sepa_janein == 2 || sepa_janein == 3) && getElementFromName('email').value  == ''  ) {
			errMsg = 'EMAIL muss bei SEPA, EMail 1,2,3 belegt sein!';
			check_element = getElementFromName('email');
		}	
							
			
		
	}
	
	
	// Ende eigene Überprüfungen
	// Prüfung ob Fehler und evtl. Abbruch
	if (errMsg!='') {
		alert(errMsg);
		check_element.focus();
		return false;
	}
		
    return true;
}



		