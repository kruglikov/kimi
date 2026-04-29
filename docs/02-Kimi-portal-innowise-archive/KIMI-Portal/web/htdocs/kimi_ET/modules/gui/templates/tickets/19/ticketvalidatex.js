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

function validateFormOnSave() {
	var errMsg = '';
		
	// Hier können die Prüfungen vorgenommen werden, ist ein Fehler, so ist der Fehlertext der
	// die Variable errMsg zuzuweisen, wodurch automatisch die Meldung erfolgt und das Speichern 
	// verhindert wird.
	// Start eigene Überprüfungen

	// Prüfung Vorlage
	var check_element = getElementFromId('textant31_janein_id');
	var selectedID = getComboSelectedId(check_element);
	var statusId = getComboSelectedId(getElementFromName('status_id'));
	if (statusId==117) {
	    if (selectedID == '-1'){
		errMsg = 'Vorlage muss gewaehlt werden!';
	    }
	}
	
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
	
	// Prüfung Lösungsvorschlag JA-Einmal, JA-Raten
	if (errMsg=='') {
		check_element = getElementFromId('textant22_nummern_id');
		selectedID = getComboSelectedId(check_element);
		// Prüfe ob JA-Raten gewählt
		if (selectedID==110 )	{		// Raten-JA
			// Prüfe ob Ratenhöhe belegt ist
			check_element = getElementFromName('dummy_number6');
			if (check_element.value == '') {
				errMsg = 'Ratenhoehe muss eingetragen werden';
			}
			// Prüfung Zahlung am
			if (errMsg=='') {
				check_element = getElementFromName('dummy_date1');
				if (check_element.value == '') {
					errMsg = 'Zahlung am muss eingetragen werden';
				}
			}
		}
	}
	
	// Prüfung Status/Anrufstatus
	if (errMsg=='') {
		var statusId = getComboSelectedId(getElementFromName('status_id'));
		var anrufStatusId = getComboSelectedId(getElementFromName('anruf_status_id'));
		var adressCheck = getComboSelectedId(getElementFromName('textant21_janein_id'));
		var emailCheck = getComboSelectedId(getElementFromName('textant41_janein_id'));
		
		
		// Erledigt und Anrufstatus in 197,203,204
		if (statusId==117 && !(anrufStatusId==373 | anrufStatusId==378 | anrufStatusId==379) ) {
			errMsg = 'Ungueltiger Anfrufstatus fuer Status erledigt!'; 
			check_element = getElementFromName('anruf_status_id');
		}
		// Check bei erledigt - und erreicht
		if (errMsg=='' && statusId==117) {
			// Adress
			if ( (anrufStatusId==373 ) && adressCheck == -1 ) {
				errMsg = 'Adresscheck muss gesetzt werden!';
				check_element = getElementFromName('textant21_janein_id');
			}
			// EMailcheck
			if (errMsg=='' && (anrufStatusId==373 ) && emailCheck == -1 ) {
				errMsg = 'EMail-Check muss gesetzt werden!';
				check_element = getElementFromName('textant41_janein_id');
			}
			// Kontakttelefonnummer
			if (errMsg=='' && anrufStatusId==373 && getElementFromName('dummy_text4').value == ''  ) {
				errMsg = 'Kontakttelefonnummer muss eingetragen werden!';
				check_element = getElementFromName('dummy_text4');
			}
		}
		//	Wenn "Status in Bearbeitung" muss Wiedervorlage und Anrufzeitpunkt belegt sein -- 20160423/Tafr
		var anrufzeitpunkt = getComboSelectedId(getElementFromName('firma_id'));
		//alert (statusId) ;
		if (errMsg=='' && statusId==119 && anrufzeitpunkt == -1  ) {
			errMsg = 'Anrufzeitpunkt muss belegt sein!';
			check_element = getElementFromName('firma_id');
		}
		if (errMsg=='' && statusId==119 && getElementFromName('wiedervorlage').value == ''  ) {
			errMsg = 'Wiedervorlage muss belegt sein!';
			check_element = getElementFromName('wiedervorlage');
		}		
	}
	
    //	
	// Prüfung SCB-Korrezeichen muss belegt sein bei Gläubiger Santander
	if (errMsg=='') {
		var prioritaetId = getComboSelectedId(getElementFromName('prioritaet_id'));
		check_element = getElementFromName('dummy_text3');
        if ( (check_element.value.substr(0, 38) == 'Santander Consumer Bank GmbH, Wagramer') && prioritaetId == -1) {
              errMsg = 'SCB-KORREZEICHEN muss eingetragen werden';
			  check_element = getElementFromName('prioritaet_id');
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
