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
		var betreibung = getComboSelectedId(getElementFromName('prioritaet_id'));
		var art = getComboSelectedId(getElementFromName('grund_id'));
		//	Wenn "Status erledigt" und Art "Rückruf Outbund" muss Betreibung belegt sein -- 20211226/Tafr
		if (errMsg=='' && statusId==187 && art == 183  && betreibung == -1  ) {
			errMsg = 'Betreibung muss belegt sein!';
			check_element = getElementFromName('prioritaet_id');
		}
		
		// Erledigt und Anrufstatus in 536 544 545 
		if (errMsg=='' && statusId==187 && !(anrufStatusId==536 | anrufStatusId==544 | anrufStatusId==545 | anrufStatusId==537) ) {
			errMsg = 'Ungueltiger Anfrufstatus fuer Status erledigt!'; 
			check_element = getElementFromName('anruf_status_id');
		}
		// Prüfung ob Fehler und evtl. Abbruch
		if (errMsg!='') {
			alert(errMsg);
			check_element.focus();
			return false;
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



		