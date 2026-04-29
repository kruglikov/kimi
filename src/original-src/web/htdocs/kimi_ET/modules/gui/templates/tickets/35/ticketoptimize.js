// Ticket-Optimierungsroutinen

function _getComboSelectedId(objElement) {
	return objElement.options[objElement.selectedIndex].value;
}
function _setComboSelectedId(objElement, nValue) {
	if (nValue != 0 && nValue != '0' ) {
		objElement.value = nValue;
	}
}
function _getElementFromId(element_id) {
	return document.getElementById(element_id);
}
function _getElementFromName(element_name) {
	return document.getElementsByName(element_name)[0];
}


// Hauptfunktion für Logik

function formDoAction(psAction, pnMandantId, pnCurrentUserId) {
	pnMandantId = parseInt(pnMandantId);
	// Wenn Telefonnummer falsch
	if (psAction =='OnTelWrongNo') {
		// Hilfsvariablen initialisieren
		telNrSubStrStart = 0;
		newStatusIdErledigt = 0;
		newAnrufStatusIdTelFaschl = 0;
		
		// Zuordnung der Werte je Mandant
		switch ( pnMandantId) {
			case 41:	// KNP
				newStatusIdErledigt = 191;
				newAnrufStatusIdTelFaschl = 629;
				telNrSubStrStart = 0;
				break;
		}
		// Setzen der Werte
		_setComboSelectedId(getElementFromName('status_id'), newStatusIdErledigt); 
		_setComboSelectedId(getElementFromName('anruf_status_id'), newAnrufStatusIdTelFaschl);
		_setComboSelectedId(getElementFromName('benutzer_id'), pnCurrentUserId);
		telNrSubStrStart = parseInt(telNrSubStrStart);
		sTelNr = getElementFromName('telefon').value;
		// getElementFromName('modell').value = sTelNr.substring(telNrSubStrStart, 100);
		sTelNr = getElementFromName('telefon2').value;
		// getElementFromName('amtliches_kennzeichen').value = sTelNr.substring(telNrSubStrStart, 100);
		

		
	} // Ende Telefonnummer falsch
	else if (psAction == 'OnTelNotReachable' ) {
		// nicht erreichbar
		// Hilfsvariablen initialisieren
		newAnrufstatus = 0;
		newErgebnis = '';
		newStatus = 0;
		aktAnrufstatus = 0;
		aktStatus = 0;
		// lese aktuelle Status
		aktAnrufstatus = parseInt(_getComboSelectedId(getElementFromName('anruf_status_id')));
		aktStatus = parseInt(_getComboSelectedId(getElementFromName('status_id')));
		newErgebnis = getElementFromName('ergebnis').value;
		newAnrufstatus = aktAnrufstatus;
		newStatus = aktStatus;
		
		switch (pnMandantId) {
			case 41:	// INKODE
				// Anrufstatus
				switch(aktAnrufstatus) {
					case -1:		// keine Angabe
						newAnrufstatus = 615;	// 1ter Anruf nicht erreicht - 2ter Anruf
						break;
					case 615:		// 1ter Anruf nicht erreicht - 2ter Anruf
						newAnrufstatus = 616;	// 2ter Anruf nicht erreicht - 3ter Anruf
						break;
					case 616:		// 2ter Anruf nicht erreicht - 3ter Anruf
						newAnrufstatus = 617;	// 3ter Anruf nicht erreicht - 4ter Anruf
						break;
					case 617:		// 3ter Anruf nicht erreicht - 4ter Anruf
						newAnrufstatus = 618;	// 4ter Anruf nicht erreicht - 5ter Anruf
						break;
					case 618:		// 4ter Anruf nicht erreicht - 5ter Anruf
						newAnrufstatus = 630;	// unerreichbar
						break;
					
						
				}
				// Status
				if (aktStatus==194) {	// offen
					newStatus = 193;	// in Bearbeitung
					getElementFromName('wiedervorlage_automatik').checked = true; // Wiedervorlage-Automatik auf checked setzen
				}
				if (newAnrufstatus == 630) {	// unerreichbar
					newStatus = 191; 	// erledigt
				}
				// Ergebnis
				if (newAnrufstatus == 545) {		// unerreichbar
					// Prüfe ob Text schon eingetragen
					ergtext =  "5 Anrufversuche kein Rückruf";
					if (newErgebnis.search(ergtext) < 0) {
						if (newErgebnis != "") {
							newErgebnis = newErgebnis + ', ';
						}
						newErgebnis = newErgebnis + ergtext;
					}
					getElementFromName('ergebnis').value = newErgebnis;
				}

				break;
		}
		// setze Status, Anrufstatus und Benutzer
		_setComboSelectedId(getElementFromName('status_id'), newStatus); 
		_setComboSelectedId(getElementFromName('anruf_status_id'), newAnrufstatus);
		_setComboSelectedId(getElementFromName('benutzer_id'), pnCurrentUserId);
		

	} 	// Ende "nicht erreichbar"
	else if (psAction == 'OnTelReachable' ) {
		//
		// erreichbar
		//
		// lese aktuelle Status
		aktAnrufstatus = parseInt(_getComboSelectedId(getElementFromName('anruf_status_id')));
		aktStatus = parseInt(_getComboSelectedId(getElementFromName('status_id')));
		newErgebnis = getElementFromName('ergebnis').value;
		newAnrufstatus = aktAnrufstatus;
		newStatus = aktStatus;
		//
		// erreichbar
		//
		// 1- Telefonnummer 1 oder 2 aufteilen auf ("KontaktTelnrVW") name="verkaeufercode"  bzw. "KontaktTelnrHW" (name="standort" )
		// LOGIK ist ; wenn erste Telefonnummer ( name="telefon")belegt diese, wenn leer dann 2te (name="telefon2")
		// Aufteilung ist die Vorwahl (die erster 3 Stellen) und den Rest auf die Hauptwahl - kein Hexenwerk draus, es wird dann eh noch kontrolliert
		//
		telnr = getElementFromName('telefon').value;
		telnr = telnr.trim();
		if (telnr==="" ) {
			telnr = getElementFromName('telefon2').value
		} 
		pos = telnr.search(" ");
		vorwahl = "";
		hauptwahl = "";
		if (pos > 0) {
			vorwahl = telnr.substring(0, pos);
			hauptwahl = telnr.substring(pos+1, telnr.length);

		} else {
			vorwahl = telnr.substring(0, 99);
		}
		getElementFromName('verkaeufercode').value = vorwahl;


		// 2 Status "Erledigt" und Anrufstatue "Erreicht" setzen

		
		switch ( pnMandantId) {
			case 41:               // KNP
				newStatus = 191;
				newAnrufstatus = 620;
		// 3 Connect-parameter alle auf "1" setzen 

	
			break;
		}

		// setze Status, Anrufstatus und Benutzer

		//
		_setComboSelectedId(getElementFromName('status_id'), newStatus); 
		_setComboSelectedId(getElementFromName('anruf_status_id'), newAnrufstatus);
		_setComboSelectedId(getElementFromName('benutzer_id'), pnCurrentUserId);

		} // Ende Erreichbar

	else {
		return false;
	}
	return true;
	
}

	