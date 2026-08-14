// Validierung der Akte beim Speichern

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
	// Start eigene überprüfungen

	// Prüfung Währung
	if (errMsg=='') {
		var isEUR = getElementFromId('EUR').checked;
		var isATS = getElementFromId('ATS').checked;
		
		if (!isEUR && !isATS ) {
			errMsg = 'Währung muss festgelegt werden!'; 
			check_element = getElementFromName('akt_waehrung');
		}
		
	}
	
	// Ende eigene Üerprüfungen
	// Prüfung ob Fehler und evtl. Abbruch
	if (errMsg!='') {
		alert(errMsg);
		check_element.focus();
		return false;
	}
		
    return true;
}



		