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
			case 16:	// INKODE
				newStatusIdErledigt = 55;
				newAnrufStatusIdTelFaschl = 203;
				telNrSubStrStart = 0;
				break;
		}
		// Setzen der Werte
		_setComboSelectedId(getElementFromName('status_id'), newStatusIdErledigt); 
		_setComboSelectedId(getElementFromName('anruf_status_id'), newAnrufStatusIdTelFaschl);
		_setComboSelectedId(getElementFromName('benutzer_id'), pnCurrentUserId);
		telNrSubStrStart = parseInt(telNrSubStrStart);
		//sTelNr = getElementFromName('telefon').value;
		//getElementFromName('modell').value = sTelNr.substring(telNrSubStrStart, 100);
		//sTelNr = getElementFromName('telefon2').value;
		//getElementFromName('amtliches_kennzeichen').value = sTelNr.substring(telNrSubStrStart, 100);

		// Ergebnis
		if (newAnrufStatusIdTelFaschl == 203) {		// unerreichbar
			// Prüfe ob Text schon eingetragen
			newErgebnis = getElementFromName('ergebnis').value;
			ergtext =  "Telefonnummer falsch";
			if (newErgebnis.search(ergtext) < 0) {
				if (newErgebnis != "") {
					newErgebnis = newErgebnis + ', ';
				}
				newErgebnis = newErgebnis + ergtext;
			}
			getElementFromName('ergebnis').value = newErgebnis;
		}		
		aktAnrufstatus = parseInt(_getComboSelectedId(getElementFromName('anruf_status_id')));
		if (aktAnrufstatus == 203) {	// Telefonnummer falsch - Vorlage auf "Nein"
			_setComboSelectedId(getElementFromName('textant31_janein_id'), 19); 
			
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
			case 16:	// INKODE
				// Anrufstatus
				switch(aktAnrufstatus) {
					case -1:		// keine Angabe
						newAnrufstatus = 193;	// 1ter Anruf nicht erreicht - 2ter Anruf
						break;
					case 193:		// 1ter Anruf nicht erreicht - 2ter Anruf
						newAnrufstatus = 194;	// 2ter Anruf nicht erreicht - 3ter Anruf
						break;
					case 194:		// 2ter Anruf nicht erreicht - 3ter Anruf
						newAnrufstatus = 195;	// 3ter Anruf nicht erreicht - 4ter Anruf
						break;
					case 195:		// 3ter Anruf nicht erreicht - 4ter Anruf
						newAnrufstatus = 196;	// 4ter Anruf nicht erreicht - 5ter Anruf
						break;
					case 196:		// 4ter Anruf nicht erreicht - 5ter Anruf
						newAnrufstatus = 204;	// unerreichbar
						break;
					
						
				}
				// Status
				if (aktStatus==58) {	// offen
					newStatus = 57;	// in Bearbeitung
					// getElementFromName('wiedervorlage_automatik').checked = true; // Wiedervorlage-Automatik auf checked setzen
				}
				if (newAnrufstatus == 204) {	// unerreichbar
					newStatus = 55; 	// erledigt
				}
				// Ergebnis
				if (newAnrufstatus == 204) {		// unerreichbar
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
				// Vorlage
				if (newAnrufstatus == 204) {	// unerreichbar - Vorlage auf "Nein"
					aktJaNein = parseInt(_getComboSelectedId(getElementFromName('textant31_janein_id')));
					if (aktJaNein!=19) {
						_setComboSelectedId(getElementFromName('textant31_janein_id'), 20); 
					}
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
		getElementFromName('dummy_text4').value = telnr;
		// alert("Telefonnummer");
		// alert(telnr);
		// 2 Status "Erledigt" und Anrufstatue "Erreicht" setzen

		switch ( pnMandantId) {
			case 16:               // INKO2016
				newStatus = 55;
				newAnrufstatus = 197;
		// 3 Connect-parameter alle auf "1" setzen 

		
		// 4 Identifikation auf "OK" TABELLE JANEIN
		aktIdentifikation = parseInt(_getComboSelectedId(getElementFromName('textant21_janein_id')));
		newIdentifikation = 51;

		// 5 Vorlage auf "nein"  Tabelle JANEIN
		aktVorlage = parseInt(_getComboSelectedId(getElementFromName('textant31_janein_id')));
		newVorlage = 20;

		// 6 Lösungsvorschlag auf "Ratenzahlung"  Tabelle NUMMERN
		aktLoesungVorschlag = parseInt(_getComboSelectedId(getElementFromName('textant22_nummern_id')));
		newLoesungVorschlag = 63;

		// 7 Ratenhöhe übernehmen 
		ratenhoehe = getElementFromName('dummy_number2').value;
		getElementFromName('dummy_number6').value = ratenhoehe;
		
		
		// 8 Ratenbriefhinweis auf "JA"  Tabelle GRUND
		aktRatenbriefhinweis = parseInt(_getComboSelectedId(getElementFromName('grund_id')));
		newRatenbriefhinweis = 42;

		// 9 Datum fällig bis übernehmen 
		faelligbis = getElementFromName('dummy_date2').value;
		getElementFromName('dummy_date1').value = faelligbis;
		
		
		// 10 EMailcheck auf "JA"  Tabelle JANEIN
		// aktEMailcheck = parseInt(_getComboSelectedId(getElementFromName('textant41_janein_id')));
		// newEMailcheck = 19;

		// 11 Arbeitgeberdaten auf "JA" TABELLE JANEIN
		// aktArbeitgeberdaten = parseInt(_getComboSelectedId(getElementFromName('textant11_janein_id')));
		// newArbeitgeberdaten = 19;

		// 12 Benutzer

			break;
		}
		// setze Status, Anrufstatus und Benutzer, usw.
		
		_setComboSelectedId(getElementFromName('textant21_janein_id'), newIdentifikation); 
		_setComboSelectedId(getElementFromName('textant31_janein_id'), newVorlage); 
		_setComboSelectedId(getElementFromName('textant22_nummern_id'), newLoesungVorschlag); 
		_setComboSelectedId(getElementFromName('grund_id'), newRatenbriefhinweis); 
		// _setComboSelectedId(getElementFromName('textant41_janein_id'), newEMailcheck); 		
		//_setComboSelectedId(getElementFromName('textant11_janein_id'), newArbeitgeberdaten); 				
	
	
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

	