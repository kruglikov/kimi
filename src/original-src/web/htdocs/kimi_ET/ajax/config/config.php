<?php
define("CONF_MYSQL_SERVER", "localhost");
define("CONF_MYSQL_USER", "sql_kimiportaldev");
define("CONF_MYSQL_PASSWORD", "coa23j1a1J3Eo5s1OvuBOnMDW35s5w");
define("CONF_MYSQL_DB", "kimiportaldev");
define("CONF_PORTAL_MENU_COLUMNS", 5);
define("CONF_PORTAL_LINE_PER_SITE", 20);
define("CONF_PORTAL_MAX_PAGES", 20);

define("CONF_USER_PERMISSION", true);

define("CONF_CONTACT_ADDRESS", "franz.tausch@kimi-plus.at");
define("CONF_CONTACT_SUBJECT", "Kontaktanfrage KIMI-Plus");

// Tageszinsermittlung
define("CONF_TGZ_SHOWDETAILS", TRUE);
define("CONF_TGZ_ZINSSATZ", 1.55);
define("CONF_TGZ_BUABUGRUMAN_ID_KAPITALISIERT", "4000");
define("CONF_TGZ_MAX_DAYS", 30);

// Cardif
define("CONF_CARDIF_ZINSSATZ", 0.79);
define("CONF_CARDIF_BUABUGRUMAN_ID_KAPITALISIERT", "4030");


// Icons
define("ICON_EDIT", "pencil16x16.png");
define("ICON_DELETE", "delete.png");

// SK-Buchungskonstanten
define("CONF_SKBUCH_CLEAR_BETRAG", "8888");
define("CONF_SKBUCH_ENABLE_BTN_NRATE", "8888");
define("CONF_SKBUCH_ENABLE_BTN_MAHNGEB", "4234,4270,4235,4242,4244,7000,2255,4770,4237");

//20140420 - Verbindung zum Archiv
define("CONF_MYSQL_SERVER_ARCHIV", "localhost");
define("CONF_MYSQL_USER_ARCHIV", "kimi");
define("CONF_MYSQL_PASSWORD_ARCHIV", "KimiPlus@13");
define("CONF_MYSQL_DB_ARCHIV", "kimi_archiv");

// Akte 
define("CONF_KAMPAGNE_AKT", ".14..21.");  // Kampange
    // Basispfad wo der Akt (JPG, PDF) liegt, darunter muss es als Unterverzeichnis die Kampange geben, danach das Verzeichnis "Akt"
    // Der Dateiname selbst ist die akt.akt_lfd_nr gefolgt von der nachfolgenden Extension
define("CONF_AKTE_DOK_URL", "./modules/gui/templates/tickets/");
define("CONF_AKTE_DOK_EXTENSION", "jpg");   

//20191202/ab
// FARBEN
define("CONF_COLOR_GREEN", "#7CFC00");
define("CONF_COLOR_RED", "red");
define("CONF_COLOR_YELLOW", "yellow");

define("CONF_KAMPAGNE_TICKET_NO_TELEFON", ".30.");
define("CONF_KAMPAGNE_TICKET_NO_NEWDELETE", ".30.");

define("CONF_KAMPAGNE_USER", ".99999=30.41=30.42=30.43=30.44=30.45=30.46=30.47=30.48=30.49=30.50=30.51=30.52=30.53=30.");

//20200720
define("CONF_TICKETTELABFRAGE_KAMPID", ",8,10,16,19,");

//20211215
define("CONF_ENCRYPTION_MANDANT_ID", "43");

?>
