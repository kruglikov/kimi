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
			case 24:	// INKODE
				newStatusIdErledigt = 101;
				newAnrufStatusIdTelFaschl = 339;
				telNrSubStrStart = 0;
				break;
		}
		// Setzen der Werte
		_setComboSelectedId(getElementFromName('status_id'), newStatusIdErledigt); 
		_setComboSelectedId(getElementFromName('anruf_status_id'), newAnrufStatusIdTelFaschl);
		_setComboSelectedId(getElementFromName('benutzer_id'), pnCurrentUserId);
		telNrSubStrStart = parseInt(telNrSubStrStart);
		sTelNr = getElementFromName('telefon').value;
		getElementFromName('modell').value = sTelNr.substring(telNrSubStrStart, 100);
		sTelNr = getElementFromName('telefon2').value;
		getElementFromName('amtliches_kennzeichen').value = sTelNr.substring(telNrSubStrStart, 100);
		
		aktAnrufstatus = parseInt(_getComboSelectedId(getElementFromName('anruf_status_id')));
		if (aktAnrufstatus == 340 || aktAnrufstatus == 339) {
			getElementFromName('dummy_text3').value = "0";	// Connect
			getElementFromName('dummy_text4').value = "0";	// RPC
			getElementFromName('dummy_text5').value = "0";	// PTP

		}
		
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
			case 24:	// INKODE
				// Anrufstatus
				switch(aktAnrufstatus) {
					case -1:		// keine Angabe
						newAnrufstatus = 329;	// 1ter Anruf nicht erreicht - 2ter Anruf
						break;
					case 329:		// 1ter Anruf nicht erreicht - 2ter Anruf
						newAnrufstatus = 330;	// 2ter Anruf nicht erreicht - 3ter Anruf
						break;
					case 330:		// 2ter Anruf nicht erreicht - 3ter Anruf
						newAnrufstatus = 331;	// 3ter Anruf nicht erreicht - 4ter Anruf
						break;
					case 331:		// 3ter Anruf nicht erreicht - 4ter Anruf
						newAnrufstatus = 332;	// 4ter Anruf nicht erreicht - 5ter Anruf
						break;
					case 332:		// 4ter Anruf nicht erreicht - 5ter Anruf
						newAnrufstatus = 340;	// unerreichbar
						break;
					
						
				}
				// Status
				if (aktStatus==104) {	// offen
					newStatus = 103;	// in Bearbeitung
				//	getElementFromName('wiedervorlage_automatik').checked = true; // Wiedervorlage-Automatik auf checked setzen
				}
				if (newAnrufstatus == 340) {	// unerreichbar
					newStatus = 101; 	// erledigt
				}
				// Ergebnis
				if (newAnrufstatus == 340) {		// unerreichbar
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
				if (newAnrufstatus == 340 || newAnrufstatus == 339) {
					getElementFromName('dummy_text3').value = "0";	// Connect
					getElementFromName('dummy_text4').value = "0";	// RPC
					getElementFromName('dummy_text5').value = "0";	// PTP

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
			vorwahl = telnr.substring(0, 3);
			hauptwahl = telnr.substring(3, 99);
		}
		getElementFromName('verkaeufercode').value = vorwahl;
		getElementFromName('standort').value = hauptwahl;



		// 2 Status "Erledigt" und Anrufstatue "Erreicht" setzen

		
		switch ( pnMandantId) {
			case 24:               // INKODE
				newStatus = 101;
				newAnrufstatus = 333;
		// 3 Connect-parameter alle auf "1" setzen 

		if (newAnrufstatus == 333 ) {
														getElementFromName('dummy_text3').value = "1";       // Connect
														getElementFromName('dummy_text4').value = "1";       // RPC
													   getElementFromName('dummy_text5').value = "1";       // PTP
		}
		
		// 4 Lösungsbereitschaft auf "JA" TABELLE JANEIN
		aktLoesungStatus = parseInt(_getComboSelectedId(getElementFromName('textant11_janein_id')));
		newLoesungStatus = 35;

		// 5 Lösungsvorschlag auf "Ratenzahlung"  Tabelle NUMMERN
		aktLoesungVorschlag = parseInt(_getComboSelectedId(getElementFromName('textant22_nummern_id')));
		newLoesungVorschlag = 92;

 
		// 6 SEPA AUF "NEIN   Tabelle PRODUKT
		aktSEPA = parseInt(_getComboSelectedId(getElementFromName('produkt_id')));
		newSEPA = 63;

		// 7 Benutzer

			break;
		}

		// setze Status, Anrufstatus und Benutzer, Lösungsbereitschaft, Lösungsvorschlag
		
		_setComboSelectedId(getElementFromName('textant11_janein_id'), newLoesungStatus); 
		_setComboSelectedId(getElementFromName('textant22_nummern_id'), newLoesungVorschlag); 
		// _setComboSelectedId(getElementFromName('produkt_id'), newSEPA);  // 2022-06-13 Tafr muss man. eingegeben werden

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

	