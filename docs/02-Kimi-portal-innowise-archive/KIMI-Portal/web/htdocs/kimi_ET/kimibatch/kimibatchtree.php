<!DOCTYPE html>
<html>
<head>

     <title>Batchtree KIMI-Plus</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
ul, #myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}

.caret {
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
}

.caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

.caret-down::before {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Safari */'
  transform: rotate(90deg);  
}

.nested {
  display: none;
}

.active {
  display: block;
}
</style>
</head>
<body>

<h2>KIMIBATCH Tree View PROD kimi_ET </h2>
<p>Click on the arrow(s) to open or close the tree branches.</p>

<ul id="myUL">
  <li><span class="caret">INKODE</span>
    <ul class="nested">
      <li><span class="caret">TAGESBATCH SCHNITTSTELLEN</span>
        <ul class="nested">
          <li><a href="./inkodeimp2.php" target="_blank">IMPORT INKODE-Daten</a></li>
          <li><a href="./inkode05_update_ratenhinweise.php" target="_blank">INKODE Update Ratenhinweise </a></li>		  
          <li><a href="./inkodecheck.php" target="_blank">Check INKODE-Ticket-Daten</a></li>
          <li><a href="./inkodeexp.php" target="_blank">EXPORT INKODE-Schnittstelle</a></li>		  
          <li><a href="./inkodereport.php" target="_blank">REPORT INKODE </a></li>		
		  <li><a href="./inkodeschnupd.php" target="_blank">INKODE Stati updaten</a></li>	
          <li><span class="caret">OPTIONAL</span>
            <ul class="nested">
              <li><a href="./inkode04_status_offen_auf_inA_setzen.php" target="_blank">INKODE Status OFFEN auf IN BEARBEITUNG setzen</a></li>				
              <li><a href="./inkodeexp_new.php" target="_blank">EXPORT INKODE TEST Schnittstelle</a></li>
             </ul>
          </li>
        </ul>
      </li>  
	  <li><span class="caret">ELSBETH</span>
        <ul class="nested">
          <li><a href="./inkode02_daten_off_fuer_elsbeth_import.php" target="_blank">EXPORT INKODE offen OUTBOUND</a></li>
          <li><a href="./inkode01_daten_inA_fuer_elsbeth_import.php" target="_blank">EXPORT INKODE inA OUTBOUND</a></li>         


          <li><span class="caret">OPTIONAL</span>
            <ul class="nested">
              <li><a href="./inkode03_verarbeitung_elsbeth_out.php" target="_blank">INKODE Verarbeitung Elsbeth Outboundergebnisse </a></li>
              <li><a href="./inkode05_daten_email_fuer_elsbeth_import.php" target="_blank">INKODE Daten für Email Kampagne Elsbeth  </a></li>			  
              <li><a href="./inkodesepaexp.php" target="_blank">INKODE SEPA DATEN EXPORT TÄGLICH</a></li>
              <li><a href="./inkodeemail1ktoexp.php" target="_blank">INKODE EMAIL1 Kontoauszug DATEN EXPORT TÄGLICH</a></li>
              <li><a href="./inkodeemail2zvexp.php" target="_blank">INKODE EMAIL2 Zahlungsvereinbarung DATEN EXPORT TÄGLICH</a></li>
              <li><a href="./inkodeemail3zwexp.php" target="_blank">INKODE EMAIL3 Zahlungswunsch DATEN EXPORT TÄGLICH</a></li>
            </ul>
          </li>
        </ul>
      </li>  
    </ul>
  </li>
</ul>
<ul id="myUL">
  <li><span class="caret">INKO2016</span>
    <ul class="nested">
      <li><span class="caret">TAGESBATCH SCHNITTSTELLEN</span>
        <ul class="nested">
          <li><a href="./inko2016imp3.php" target="_blank">IMPORT INKO2016-Daten</a></li>
          <li><a href="./inko201605_update_ratenhinweise.php" target="_blank">INKO2016 Update Ratenhinweise </a></li>
          <li><a href="./inko2016check.php" target="_blank">Check INKO2016 Ticket-Daten</a></li>
          <li><a href="./inko2016exp.php" target="_blank">EXPORT INKO2016 Schnittstelle</a></li>
          <li><a href="./inko2016report.php" target="_blank">REPORT INKO2016 </a></li>
          <li><a href="./inko2016schnupd.php" target="_blank">INKO2016 Stati updaten</a></li>
	  
          <li><span class="caret">OPTIONAL</span>
            <ul class="nested">
              <li><a href="./inko201604_status_offen_auf_inA_setzen.php" target="_blank">INKO2016 Status OFFEN auf IN BEARBEITUNG setzen</a></li>
              <li><a href="./inko2016exp_new.php" target="_blank">EXPORT INKO2016 TEST Schnittstelle</a/li>
            </ul>
          </li>
        </ul>
      </li>  
	  <li><span class="caret">ELSBETH</span>
        <ul class="nested">
          <li><a href="./inko201602_daten_off_fuer_elsbeth_import.php" target="_blank">EXPORT INKO2016 offen OUTBOUND</a></li>
          <li><a href="./inko201601_daten_inA_fuer_elsbeth_import.php" target="_blank">EXPORT INKO2016 inA OUTBOUND</a></li>
          <li><span class="caret">OPTIONAL</span>
            <ul class="nested">
              <li><a href="./inko201603_verarbeitung_elsbeth_out.php" target="_blank">INKO2016 Verarbeitung Elsbeth Outboundergebnisse </a></li>
              <li><a href="./inko201605_daten_email_fuer_elsbeth_import.php" target="_blank">INKO2016 Daten für Email Kampagne Elsbeth  </a></li>			  
              <li><a href="./inko2016sepaexp.php" target="_blank">INKO2016 SEPA DATEN EXPORT TÄGLICH</a></li>
              <li><a href="./inko2016email1ktoexp.php" target="_blank">INKO2016 EMAIL1 Kontoauszug DATEN EXPORT TÄGLICH</a></li>
              <li><a href="./inko2016email2zvexp.php" target="_blank">INKO2016 EMAIL2 Zahlungsvereinbarung DATEN EXPORT TÄGLICH</a></li>
              <li><a href="./inko2016email3zwexp.php" target="_blank">INKO2016 EMAIL3 Zahlungswunsch DATEN EXPORT TÄGLICH</a></li>

            </ul>
          </li>
        </ul>
      </li>  
    </ul>
  </li>
</ul>
<ul id="myUL">
  <li><span class="caret">OKO</span>
    <ul class="nested">
      <li><span class="caret">TAGESBATCH SCHNITTSTELLEN</span>
        <ul class="nested">
          <li><a href="./okoimp.php" target="_blank">Import OKO-Daten</a></li>
          <li><a href="./oko04_mehrfach_tickets_anzeigen.php" target="_blank">OKO Mehrfach Tickets nach Import anzeigen</a></li>
          <li><a href="./okocheck.php" target="_blank">Check OKO Ticket-Daten</a></li>
          <li><a href="./okoexp.php" target="_blank">EXPORT Schnittstelle OKO </a></li>
          <li><a href="./okoreport.php" target="_blank">REPORT OKO </a></li>
          <li><a href="./okoschnupd.php" target="_blank">OKO Stati updaten</a></li>
          <li><span class="caret">OPTIONAL</span>
            <ul class="nested">
              <li><a href="./oko04_status_offen_auf_inA_setzen.php" target="_blank">OKO Status OFFEN ALLE auf IN BEARBEITUNG setzen</a></li>
              <li><a href="./oko04_status_offen_vortage_auf_inA_setzen.php" target="_blank">OKO Status OFFEN VORTAGE auf IN BEARBEITUNG setzen</a></li>			  
              <li><a href="./okoexpzwb.php" target="_blank">EXPORT Schnittstelle OKO-SCB ZWISCHENBERICHT</a></li>
              <li>xxx</li>
              <li>xxx</li>
            </ul>
          </li>
        </ul>
      </li>  
	  <li><span class="caret">ELSBETH</span>
        <ul class="nested">
          <li><a href="./oko02_daten_off_fuer_elsbeth_import.php" target="_blank">EXPORT OKO off OUTBOUND</a></li>
          <li><a href="./oko01_daten_inA_fuer_elsbeth_import.php" target="_blank">EXPORT OKO inA OUTBOUND</a></li>
          <li><a href="./oko01_daten_inA_fuer_elsbeth_import_telefon1.php" target="_blank">EXPORT OKO inA OUTBOUND NUR TELEFONNR #1 für Predicitve</a></li>
          <li><a href="./oko01_daten_inA_fuer_elsbeth_import_telefon2.php" target="_blank">EXPORT OKO inA OUTBOUND NUR TELEFONNR #2 für Predicitve</a></li>
          <li><a href="./oko01_daten_inA_fuer_elsbeth_import_telefon3.php" target="_blank">EXPORT OKO inA OUTBOUND NUR TELEFONNR #3 für Predicitve</a></li>
          <li><a href="./oko01_daten_inA_fuer_elsbeth_import_telefon4.php" target="_blank">EXPORT OKO inA OUTBOUND NUR TELEFONNR #4 für manuelle Liste</a></li>

          <li><span class="caret">OPTIONAL</span>
            <ul class="nested">
              <li><a href="./oko03_verarbeitung_elsbeth_out.php" target="_blank">OKO Verarbeitung Elsbeth Outboundergebnisse </a></li>
            </ul>
          </li>
        </ul>
      </li>  
    </ul>
  </li>
</ul>
<ul id="myUL">
  <li><span class="caret">COEO</span>
    <ul class="nested">
      <li><span class="caret">TAGESBATCH SCHNITTSTELLEN</span>
        <ul class="nested">
          <li><a href="./coeo01_import_telnr_optimierung.php" target="_blank">IMPORTDATEN Telefonnummern Optimierung</a></li>
          <li><a href="./coeo01_import_telefonie_taeglich.php"  target="_blank">#1 COEO Import Telefoniedaten taeglich</a></</li>
          <li><a href="./knp1check.php" target="_blank">Check KNP 1 Ticket-Daten</a></</li>
          <li><a href="./knp1report.php" target="_blank">REPORT KNP 1 </a></</li>
          <li><a href="./knp1schnupd.php" target="_blank">KNP 1 Stati updaten</a></</li>		  
          <li><span class="caret">ELSBETH - COEO tägliche Daten für Elsbeth_Import aufbereiten</span>
            <ul class="nested">
              <li><span class="caret">STANDARD ALLE</span>
					<ul class="nested">
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import.php" target="_blank">#2 COEO tägliche Daten für Elsbeth_Import aufbereiten</a></li>
					</ul>
              <li><span class="caret">Sonderauswertungen</span>
					<ul class="nested">
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_neue.php" target="_blank">#2 COEO tägliche NEUE Daten für Elsbeth_Import aufbereiten</a></li>
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_l2tage.php" target="_blank">#2 COEO tägliche Daten LETZTE 2 Tage nicht telefoniert für Elsbeth_Import aufbereiten</a></li>
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_l3tage.php" target="_blank">#2 COEO tägliche Daten  LETZTE 3 Tage nicht telefoniert für Elsbeth_Import aufbereiten</a></li>
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_RATENERINNERUNG_import.php" target="_blank">#2 COEO tägliche Daten für Elsbeth_Import RATENERINNERUNG aufbereiten</a></li>
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_SONDERKAMPAGNE_import.php" target="_blank">#2 COEO tägliche Daten für Elsbeth_Import SONDERKAMPAGNE aufbereiten</a></li>
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_alle.php" target="_blank">#2 COEO tägliche Daten für Elsbeth_Import ALLE aufbereiten</a></li>		
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_telefonnrfalsch.php" target="_blank">#2 COEO tägliche Daten für Elsbeth_Import TELEFONNRFALSCH aufbereiten</a></li>							
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_nur_klarna.php" target="_blank">#2 COEO tägliche Daten für Elsbeth_Import ALLE NUR KLARNA aufbereiten</a></li>							
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_nicht_klarna.php" target="_blank">#2 COEO tägliche Daten für Elsbeth_Import ALLE NICHT KLARNA aufbereiten</a></li>							

					</ul>	
              <li><span class="caret">TRENNUNG KAMPAGNEN KLARNA & RATENERINNERUNGEN</span>
					<ul class="nested">
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_l2tage_klarna.php" target="_blank">#2 COEO tägliche Daten KLARNA LETZTE 2 Tage nicht telefoniert für Elsbeth_Import aufbereiten</a></li>
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_l3tage_klarna.php" target="_blank">#2 COEO tägliche Daten KLARNA LETZTE 3 Tage nicht telefoniert für Elsbeth_Import aufbereiten</a></li>
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_l2tage_raten.php" target="_blank">#2 COEO tägliche Daten RATENERINNERUNG LETZTE 2 Tage nicht telefoniert für Elsbeth_Import aufbereiten</a></li>
						<li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_l3tage_raten.php" target="_blank">#2 COEO tägliche Daten RATENERINNERUNG LETZTE 3 Tage nicht telefoniert für Elsbeth_Import aufbereiten</a></li>
					</ul>						
            </ul>
          </li>
        </ul>
      </li>  
	  <li><span class="caret">ELSBETH</span>
        <ul class="nested">
		  <li><a href="./coeo02_tagl_daten_fuer_elsbeth_import_alle.php" target="_blank">EXPORT COEO inA OUTBOUND - COEO tägliche Daten für Elsbeth_Import ALLE aufbereiten</a></li>	
		  <li></li>
          <li><a href="./coeo03_verarbeitung_elsbeth_out.php" target="_blank">#3.1 COEO Verarbeitung Elsbeth Outboundergebnisse laufend</a></li>
          <li><a href="./coeo03_verarbeitung_elsbeth_out.php?abschluss=J" target="_blank">3.2 COEO Verarbeitung Elsbeth Outboundergebnisse Tagesabschluss</a></li>
          <li><span class="caret">OPTIONAL</span>
            <ul class="nested">
              <li>xxx</li>
              <li>xxx</li>
              <li>xxx</li>
              <li>xxx</li>
            </ul>
          </li>
        </ul>
      </li>  
    </ul>
  </li>
</ul>

<ul id="myUL">
  <li><span class="caret">COEO DREI</span>
    <ul class="nested">
      <li><span class="caret">TAGESBATCH SCHNITTSTELLEN</span>
        <ul class="nested">
          <li><a href="./coeodrei01_import_telnr_optimierung.php" target="_blank">IMPORTDATEN COEO DREI  Telefonnummern Optimierung</a></li>
          <li><a href="./coeodrei01_import_telefonie_taeglich.php"  target="_blank">#1 COEO DREI Import Telefoniedaten taeglich</a></</li>
          <li><a href="./coeodreicheck.php" target="_blank">Check DREI 1 Ticket-Daten</a></</li>
          <li><a href="./coeodreireport.php" target="_blank">REPORT COEO DREI </a></</li>
          <li><a href="./coeodreischnupd.php" target="_blank">COEO DREI Stati updaten</a></</li>		  
          <li><span class="caret">ELSBETH - COEO DREI tägliche Daten für Elsbeth_Import aufbereiten</span>
            <ul class="nested">
              <li><span class="caret">STANDARD ALLE</span>
					<ul class="nested">
						<li><a href="./coeodrei02_tagl_daten_fuer_elsbeth_import.php" target="_blank">#2 COEO DREI tägliche Daten für Elsbeth_Import aufbereiten</a></li>
					</ul>
              <li><span class="caret">Sonderauswertungen</span>
					<ul class="nested">
						<li><a href="./coeodrei02_tagl_daten_fuer_elsbeth_import_neue.php" target="_blank">#2 COEO DREI tägliche NEUE Daten für Elsbeth_Import aufbereiten</a></li>
						<li><a href="./coeodrei02_tagl_daten_fuer_elsbeth_import_alle.php" target="_blank">#2 COEO DREI tägliche Daten für Elsbeth_Import ALLE aufbereiten</a></li>		
					</ul>	
					</ul>						
            </ul>
          </li>

	  <li><span class="caret">ELSBETH</span>
        <ul class="nested">
		  <li><a href="./coeodrei02_tagl_daten_fuer_elsbeth_import_alle.php" target="_blank">EXPORT COEO DREI inA OUTBOUND - COEO tägliche Daten für Elsbeth_Import ALLE aufbereiten</a></li>	
		  <li></li>
          <li><a href="./coeodrei03_verarbeitung_elsbeth_out.php" target="_blank">#3.1 COEO DREI Verarbeitung Elsbeth Outboundergebnisse laufend</a></li>
          <li><a href="./coeodrei03_verarbeitung_elsbeth_out.php?abschluss=J" target="_blank">3.2 COEO DREI Verarbeitung Elsbeth Outboundergebnisse Tagesabschluss</a></li>
          <li><span class="caret">OPTIONAL</span>
            <ul class="nested">
              <li>xxx</li>
              <li>xxx</li>
              <li>xxx</li>
              <li>xxx</li>
        </ul>

            </ul>
          </li>
        </ul>
      </li>  
    </ul>
  </li>
</ul>

<ul id="myUL">
  <li><span class="caret">COEO CH  - Schweiz</span>
    <ul class="nested">
      <li><span class="caret">TAGESBATCH SCHNITTSTELLEN</span>
        <ul class="nested">
          <li><a href="./coeoch01_import_telnr_optimierung.php" target="_blank">IMPORTDATEN CH  Telefonnummern Optimierung</a></li>
          <li><a href="./coeoch01_import_telefonie_taeglich.php"  target="_blank">#1 COEO CH Import Telefoniedaten taeglich</a></</li>
          <li><a href="./coeochcheck.php" target="_blank">Check CH 1 Ticket-Daten</a></</li>
          <li><a href="./coeochreport.php" target="_blank">REPORT COEO CH </a></</li>
          <li><a href="./coeochschnupd.php" target="_blank">COEO CH Stati updaten</a></</li>		  
          <li><span class="caret">ELSBETH - COEO CH tägliche Daten für Elsbeth_Import aufbereiten</span>
            <ul class="nested">
              <li><span class="caret">STANDARD ALLE</span>
					<ul class="nested">
						<li><a href="./coeoch02_tagl_daten_fuer_elsbeth_import.php" target="_blank">#2 COEO tägliche Daten für Elsbeth_Import aufbereiten</a></li>
					</ul>
              <li><span class="caret">Sonderauswertungen</span>
					<ul class="nested">
						<li><a href="./coeochde02_tagl_daten_fuer_elsbeth_import_neue.php" target="_blank">#2 COEO CH tägliche NEUE Daten für Elsbeth_Import aufbereiten</a></li>
						<li><a href="./coeochde02_tagl_daten_fuer_elsbeth_import_alle.php" target="_blank">#2 COEO CH tägliche Daten für Elsbeth_Import ALLE aufbereiten</a></li>		
					</ul>	
            </ul>
          </li>
        </ul>
      </li>  
	  <li><span class="caret">ELSBETH</span>
        <ul class="nested">
		  <li><a href="./coeoch02_tagl_daten_fuer_elsbeth_import_alle.php" target="_blank">EXPORT COEO inA OUTBOUND - COEO CH tägliche Daten für Elsbeth_Import ALLE aufbereiten</a></li>	
		  <li></li>
          <li><a href="./coeoch03_verarbeitung_elsbeth_out.php" target="_blank">#3.1 COEO Verarbeitung Elsbeth Outboundergebnisse laufend</a></li>
          <li><a href="./coeoch03_verarbeitung_elsbeth_out.php?abschluss=J" target="_blank">3.2 COEO Verarbeitung Elsbeth Outboundergebnisse Tagesabschluss</a></li>
          <li><span class="caret">REPORTING</span>
            <ul class="nested">
              <li><a href="./coeochdeexp.php" target="_blank">#2 COEO CH DE tägliches Reportfile</a></li>
            </ul>
          </li>
        </ul>
      </li>  
    </ul>
  </li>
</ul>

<ul id="myUL">
  <li><span class="caret">QUESTER</span>
    <ul class="nested">
      <li><span class="caret">TAGESBATCH SCHNITTSTELLEN</span>
        <ul class="nested">
          <li><a href="./schlaustrom01_import_telefonie_taeglich.php" target="_blank">QUESTER IMPORT Ticket-Daten</a></li>
          <li><a href="./schlaustromcheck.php" target="_blank">Check QUESTER Ticket-Daten</a></li>
          <li><a href="./questerexp20250208.php" target="_blank">EXPORT Schnittstelle QUESTER </a></li>
          <li><a href="./schlaustromreport.php" target="_blank">REPORT QUESTER </a></li>
          <li><a href="./schlaustromschnupd.php" target="_blank">QUESTER Stati updaten</a></li>		  
          <li><span class="caret">OPTIONAL</span>
            <ul class="nested">
              <li>xxx</li>
              <li>xxx</li>
              <li>xxx</li>
              <li>xxx</li>
            </ul>
          </li>
        </ul>
      </li>  
	  <li><span class="caret">ELSBETH</span>
        <ul class="nested">
          <li><a href="./schlaustrom02_daten_off_fuer_elsbeth_import.php" target="_blank">EXPORT SCHLAUSTROM off OUTBOUND</a></li>
          <li><a href="./schlaustrom01_daten_inA_fuer_elsbeth_import.php" target="_blank">EXPORT SCHLAUSTROM inA OUTBOUND</a></li>
          <li><a href="./schlaustrom01SONDER_daten_inA_fuer_elsbeth_import.php" target="_blank">EXPORT SCHLAUSTROM SONDER inA OUTBOUND</a></li>		  
          <li><span class="caret">OPTIONAL</span>
            <ul class="nested">
              <li><a href="./schlaustrom03_verarbeitung_elsbeth_out.php" target="_blank">SCHLAUSTROM Verarbeitung Elsbeth Outboundergebnisse </a></li>
            </ul>
          </li>
        </ul>
      </li>  
    </ul>
  </li>
</ul>

<ul id="myUL">
  <li><span class="caret">ALLGEMEIN ÜBERGREIFEND</span>
    <ul class="nested">
      <li><span class="caret">SEPA</span>
        <ul class="nested">
          <li><a href="./inkosepaexp.php" target="_blank">INKO SEPA DATEN EXPORT TÄGLICH</a></li>
          <li><a href="./inkoseparep.php" target="_blank">INKO SEPA REPORT DATEN </a></li>			  
          <li><span class="caret">OPTIONAL</span>
            <ul class="nested">
              <li>xxx</li>
              <li>xxx</li>
              <li>xxx</li>
              <li>xxx</li>
            </ul>
          </li>
        </ul>
      <li><span class="caret">INBOUND - OUTBOUND</span>
        <ul class="nested">
          <li><a href="./inboundoutboundrep.php" target="_blank">INBOUND OUTBOUND REPORT DATEN</a></li>		  		  		  
            </ul>
          </li>
        </ul>
    </ul>
  </li>
</ul>

<script>
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}
</script>

</body>
</html>