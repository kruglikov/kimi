<!DOCTYPE html>
<html>
<head>
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

<h2>KIMIBATCH Tree View</h2>
<p>Click on the arrow(s) to open or close the tree branches.</p>
<!--
<ul id="myUL">
  <li><span class="caret">INKODE</span>
    <ul class="nested">
      <li><span class="caret">TAGESBATCH SCHNITTSTELLEN</span>
        <ul class="nested">
          <li><a href="./inkodeimp2.php" target="_blank">IMPORT INKODE-Daten</a></li>
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
  <li><span class="caret">SCHLAUSTROM</span>
    <ul class="nested">
      <li><span class="caret">TAGESBATCH SCHNITTSTELLEN</span>
        <ul class="nested">
          <li><a href="./schlaustrom01_import_telefonie_taeglich.php" target="_blank">Schlaustrom IMPORT Ticket-Daten</a></li>
          <li><a href="./ifscheck20181128.php" target="_blank">Check Schlaustrom Ticket-Daten</a></li>
          <li><a href="./schlaustromexp20190924.php" target="_blank">EXPORT Schnittstelle Schlaustrom </a></li>
          <li><a href="./schlaustromreport.php" target="_blank">REPORT SCHLAUSTROM </a></li>
          <li><a href="./schlaustromschnupd.php" target="_blank">Schlaustrom Stati updaten</a></li>		  
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
//-->
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
<!--
<ul id="myUL">
  <li><span class="caret">ALLGEMEIN ÜBERGREIFEND</span>
    <ul class="nested">
      <li><span class="caret">SEPA</span>
        <ul class="nested">
          <li><a href="./inkosepaexp.php" target="_blank">INKO SEPA DATEN </a></li>
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
//-->
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