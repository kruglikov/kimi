-- =============================================================================
-- KIMI Portal — Database Schema (kimi_et)
-- =============================================================================
-- Source:  Reverse-engineered from src/original-src/web/htdocs/kimi_ET/libs/entities/
--          and JOIN queries across the PHP codebase.
-- Status:  DRAFT — column names are authoritative; types are inferred.
--          Lengths, NULLability and defaults must be verified with client.
-- Legend:  -- inferred: ...   marks uncertain type/constraint decisions
-- =============================================================================

USE kimi_et;

-- ---------------------------------------------------------------------------
-- RBAC
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `rolle` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `bezeichnung` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `berechtigung` (
    -- entity class: Permission; table confirmed in permission.php query
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `seitenname`   VARCHAR(100) NOT NULL,   -- e.g. "ticket.php"
    `berechtigung` VARCHAR(50)  NOT NULL,   -- e.g. "ALL", "read", "write"
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rolle_berechtigung` (
    -- junction: role ↔ permission
    `rolle_id`        INT UNSIGNED NOT NULL,
    `berechtigung_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`rolle_id`, `berechtigung_id`),
    FOREIGN KEY (`rolle_id`)        REFERENCES `rolle`       (`id`),
    FOREIGN KEY (`berechtigung_id`) REFERENCES `berechtigung`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- USERS & TENANTS
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `benutzer` (
    -- entity class: User / Benutzer; table: benutzer
    `id`                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`                VARCHAR(100) NOT NULL,           -- login username
    `nachname`            VARCHAR(100) DEFAULT NULL,
    `vorname`             VARCHAR(100) DEFAULT NULL,
    `email`               VARCHAR(255) DEFAULT NULL,
    `telefon`             VARCHAR(50)  DEFAULT NULL,
    `land`                VARCHAR(10)  DEFAULT NULL,       -- inferred: ISO country code
    `gruppe`              VARCHAR(50)  DEFAULT NULL,       -- inferred: user group/department
    `sprache`             VARCHAR(10)  DEFAULT NULL,       -- inferred: language code
    `passwort`            VARCHAR(64)  DEFAULT NULL,       -- SHA-256("kimiplus" + pw), truncated to 64 chars
    `iptel_durchwahl`     VARCHAR(50)  DEFAULT NULL,       -- VoIP extension
    `default_bua_bgr_key` VARCHAR(50)  DEFAULT NULL,       -- inferred: default booking key
    `default_belegdatum`  DATE         DEFAULT NULL,       -- inferred
    `letzte_kampagne_id`  INT UNSIGNED DEFAULT NULL,       -- last active campaign
    `letzter_mandant_id`  INT UNSIGNED DEFAULT NULL,       -- last active mandant
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `mandant` (
    -- entity class: Mandant; multi-tenant client company
    `id`                         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant`                    VARCHAR(100) NOT NULL,
    `text`                       TEXT         DEFAULT NULL,
    `uid`                        VARCHAR(50)  DEFAULT NULL,  -- UID/VAT number
    `land`                       VARCHAR(10)  DEFAULT NULL,
    `plz`                        VARCHAR(20)  DEFAULT NULL,
    `ort`                        VARCHAR(100) DEFAULT NULL,
    `strasse`                    VARCHAR(100) DEFAULT NULL,
    `hausnummer`                 VARCHAR(20)  DEFAULT NULL,
    `hausnummer_erw`             VARCHAR(20)  DEFAULT NULL,
    `telefon`                    VARCHAR(50)  DEFAULT NULL,
    `email`                      VARCHAR(255) DEFAULT NULL,
    `encryption_aktiv`           CHAR(1)      DEFAULT 'N',  -- 'J' = encryption enabled
    `encryption_columns_ticket`  TEXT         DEFAULT NULL,  -- comma-separated column names
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `mandant_benutzer` (
    -- junction: mandant ↔ benutzer ↔ rolle (one user can belong to multiple mandants)
    `mandant_id`  INT UNSIGNED NOT NULL,
    `benutzer_id` INT UNSIGNED NOT NULL,
    `rolle_id`    INT UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`mandant_id`, `benutzer_id`),
    FOREIGN KEY (`mandant_id`)  REFERENCES `mandant` (`id`),
    FOREIGN KEY (`benutzer_id`) REFERENCES `benutzer`(`id`),
    FOREIGN KEY (`rolle_id`)    REFERENCES `rolle`   (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- CAMPAIGNS
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `kampagne` (
    -- entity class: Kampagne
    `id`                INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `bezeichnung`       VARCHAR(255) NOT NULL,
    `aktiv`             TINYINT(1)   NOT NULL DEFAULT 1,    -- 1 = active
    `iptel_auto_vorwahl` VARCHAR(20) DEFAULT NULL,          -- VoIP auto-prefix
    `iptel_destclid`    VARCHAR(50)  DEFAULT NULL,          -- VoIP caller ID
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- LOOKUP / REFERENCE TABLES
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `anrede` (
    `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text` VARCHAR(50)  NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `titel` (
    `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text` VARCHAR(50)  NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `land` (
    -- land (region/country) — distinct from `country`; used by kunde.land_id
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `bezeichnung` VARCHAR(100) DEFAULT NULL,  -- inferred
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `country` (
    -- ISO country reference (entity class: Country)
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `bezeichnung` VARCHAR(100) NOT NULL,
    `kurzzeichen` VARCHAR(10)  DEFAULT NULL,
    `iso2`        CHAR(2)      DEFAULT NULL,
    `eu`          TINYINT(1)   DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `prioritaet` (
    -- entity file is empty; table confirmed in LEFT JOIN prioritaet p ON p.id = t.prioritaet_id
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,  -- inferred: Texte::get() filters by active mandant
    `text`       VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `status` (
    -- ticket status; table confirmed in LEFT JOIN status s ON s.id = t.status_id
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,  -- inferred: Texte::get() filters by active mandant
    `text`       VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `anruf_status` (
    -- call status; table confirmed in LEFT JOIN anruf_status ars ON ars.id = t.anruf_status_id
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,  -- inferred: Texte::get() filters by active mandant
    `text`       VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `firma` (
    -- company; table confirmed in LEFT JOIN firma f ON f.id = t.firma_id
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,  -- inferred: Texte::get() filters by active mandant
    `text`       VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `kategorie` (
    `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `zahlart` (
    `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `mwst` (
    -- VAT lookup; referenced by buchungen.mwst_id, no direct SELECT found in web code
    `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text` VARCHAR(100) DEFAULT NULL,  -- inferred
    `satz` DECIMAL(5,2) DEFAULT NULL,  -- inferred: VAT percentage
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `grund` (
    -- ticket reason lookup; referenced by ticket.grund_id, no direct SELECT found in web code
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,  -- inferred: Texte::get() filters by active mandant
    `text`       VARCHAR(255) DEFAULT NULL,  -- inferred
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `produkt` (
    -- product lookup; referenced by ticket.produkt_id, no direct SELECT found in web code
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,  -- inferred: Texte::get() filters by active mandant
    `text`       VARCHAR(255) DEFAULT NULL,  -- inferred
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `janein` (
    -- yes/no lookup; loaded by Texte::get_janein() for ticket form dropdowns
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,
    `text`       VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `nummern` (
    -- numeric choice lookup; loaded by Texte::get_nummern() for ticket form dropdowns
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,
    `text`       VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `dummy_id_referenz` (
    -- tenant-scoped option lists for dummy_id1..dummy_id5 fields on ticket screens
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,
    `dummy_id`   INT UNSIGNED NOT NULL,
    `sort`       INT          NOT NULL DEFAULT 0,
    `text`       VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `anstoss` (
    `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `anrufzeiten` (
    -- permitted call time slots
    `id`      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text`    VARCHAR(100) DEFAULT NULL,
    `von`     TIME         DEFAULT NULL,
    `bis`     TIME         DEFAULT NULL,
    `reihung` INT          DEFAULT NULL,  -- sort order
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `ausbuchungsgrund` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text`         VARCHAR(255) NOT NULL,
    `ausbuch_grund` VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `erled_qual` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text`        VARCHAR(255) NOT NULL,
    `erled_qual`  VARCHAR(50)  DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `inkassostatus` (
    `id`                INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `inkassostatus`     VARCHAR(50)  DEFAULT NULL,
    `text`              VARCHAR(255) DEFAULT NULL,
    `bezeichnung`       VARCHAR(255) DEFAULT NULL,
    `kz_akt_betreibung` CHAR(1)      DEFAULT 'N',
    `kz_inaktiv`        CHAR(1)      DEFAULT 'N',
    `kz_krsv_erlaubt`   CHAR(1)      DEFAULT 'N',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `bankleitzahl` (
    `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `blz`             VARCHAR(20)  DEFAULT NULL,
    `bank`            VARCHAR(255) DEFAULT NULL,
    `bic`             VARCHAR(20)  DEFAULT NULL,
    `kz_sepa_faehig`  CHAR(1)      DEFAULT 'N',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `buchungsart` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text`         VARCHAR(255) DEFAULT NULL,
    `buart_key`    VARCHAR(50)  DEFAULT NULL,
    `bugru_key`    VARCHAR(50)  DEFAULT NULL,
    `bugru_text`   VARCHAR(255) DEFAULT NULL,
    `bua_bgr_man_id` INT UNSIGNED DEFAULT NULL,  -- inferred FK
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `buchungsgrund` (
    `id`               INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text`             VARCHAR(255) DEFAULT NULL,
    `buchungsart_id`   INT UNSIGNED DEFAULT NULL,
    `bugru_key`        VARCHAR(50)  DEFAULT NULL,
    `bugru_key_om`     VARCHAR(50)  DEFAULT NULL,
    `buart_text`       VARCHAR(255) DEFAULT NULL,
    `bua_bgr_man_id`   INT UNSIGNED DEFAULT NULL,
    `kontoauszugstext` VARCHAR(255) DEFAULT NULL,
    `kz_bearbeitung`   CHAR(1)      DEFAULT 'N',
    `kz_berechnung`    CHAR(1)      DEFAULT 'N',
    `kz_manuell`       CHAR(1)      DEFAULT 'N',
    `kz_saldowirksam`  CHAR(1)      DEFAULT 'N',
    `kz_subkonto`      CHAR(1)      DEFAULT 'N',
    `kz_zinsberechnung` CHAR(1)     DEFAULT 'N',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`buchungsart_id`) REFERENCES `buchungsart`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `bua_bgr_man` (
    -- links buchungsart/buchungsgrund to mandant; confirmed: WHERE mandant_id = ? AND bugru_id = ?
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED NOT NULL,
    `bugru_id`   INT UNSIGNED DEFAULT NULL,   -- FK to buchungsgrund
    PRIMARY KEY (`id`),
    FOREIGN KEY (`mandant_id`) REFERENCES `mandant`(`id`),
    FOREIGN KEY (`bugru_id`)   REFERENCES `buchungsgrund`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `ra_ikbuero` (
    -- law firm / collection office
    `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ra_buero` VARCHAR(255) DEFAULT NULL,
    `text`     VARCHAR(255) DEFAULT NULL,
    `markt`    VARCHAR(50)  DEFAULT NULL,
    `kz_aktiv` CHAR(1)      DEFAULT 'J',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `schadensfall_art` (
    `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `status_schadensfall` (
    `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `text`      VARCHAR(255) DEFAULT NULL,
    `kurz_text` VARCHAR(50)  DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `portaltext` (
    -- entity class: Portal_Text; table confirmed in portal_text.php
    `id`      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `sprache` VARCHAR(10)  NOT NULL,
    `text`    TEXT         DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- CUSTOMER DATA
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `kunde` (
    -- entity class: Customer (file: customer.php); table name: kunde (confirmed in JOINs)
    `id`                INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `kdnr`              VARCHAR(50)  DEFAULT NULL,
    `mandant_id`        INT UNSIGNED DEFAULT NULL,
    `anrede_id`         INT UNSIGNED DEFAULT NULL,
    `anrede2_id`        INT UNSIGNED DEFAULT NULL,
    `titel_id`          INT UNSIGNED DEFAULT NULL,
    `titel2_id`         INT UNSIGNED DEFAULT NULL,
    `nachname`          VARCHAR(100) DEFAULT NULL,
    `nachname2`         VARCHAR(100) DEFAULT NULL,
    `vorname`           VARCHAR(100) DEFAULT NULL,
    `vorname2`          VARCHAR(100) DEFAULT NULL,
    `adresszusatz`      VARCHAR(255) DEFAULT NULL,
    `strasse`           VARCHAR(100) DEFAULT NULL,
    `hausnummer`        VARCHAR(20)  DEFAULT NULL,
    `hausnummer_erw`    VARCHAR(20)  DEFAULT NULL,
    `plz`               VARCHAR(20)  DEFAULT NULL,
    `ort`               VARCHAR(100) DEFAULT NULL,
    `ortsteil`          VARCHAR(100) DEFAULT NULL,
    `land_id`           INT UNSIGNED DEFAULT NULL,
    `telefon`           VARCHAR(50)  DEFAULT NULL,
    `email`             VARCHAR(255) DEFAULT NULL,
    `geburtsdatum`      DATE         DEFAULT NULL,
    `geburtsdatum2`     DATE         DEFAULT NULL,
    `kenner`            VARCHAR(50)  DEFAULT NULL,  -- inferred: identifier/tag
    `kundenart`         VARCHAR(50)  DEFAULT NULL,
    `kundenartbeschreibung` VARCHAR(255) DEFAULT NULL,
    `markt`             VARCHAR(50)  DEFAULT NULL,
    `primaerkdnr`       VARCHAR(50)  DEFAULT NULL,  -- primary customer number
    PRIMARY KEY (`id`),
    FOREIGN KEY (`mandant_id`)  REFERENCES `mandant`(`id`),
    FOREIGN KEY (`anrede_id`)   REFERENCES `anrede` (`id`),
    FOREIGN KEY (`anrede2_id`)  REFERENCES `anrede` (`id`),
    FOREIGN KEY (`titel_id`)    REFERENCES `titel`  (`id`),
    FOREIGN KEY (`titel2_id`)   REFERENCES `titel`  (`id`),
    FOREIGN KEY (`land_id`)     REFERENCES `land`   (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `stammdaten` (
    -- customer case/master data; one record per customer per campaign/case
    `id`                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `kunde_id`             INT UNSIGNED NOT NULL,
    `mandant_id`           INT UNSIGNED NOT NULL,
    `kdnr`                 VARCHAR(50)  DEFAULT NULL,
    `vorname`              VARCHAR(100) DEFAULT NULL,
    `nachname`             VARCHAR(100) DEFAULT NULL,
    `strasse`              VARCHAR(100) DEFAULT NULL,
    `plz`                  VARCHAR(20)  DEFAULT NULL,
    `ort`                  VARCHAR(100) DEFAULT NULL,
    `inkassostatus_id`     INT UNSIGNED DEFAULT NULL,
    `ra_ikbuero_id`        INT UNSIGNED DEFAULT NULL,
    `gesamtsaldo`          DECIMAL(15,2) DEFAULT NULL,
    `gesamtsaldo_1x`       DECIMAL(15,2) DEFAULT NULL,
    `gesamtsaldo_rcs`      DECIMAL(15,2) DEFAULT NULL,
    `gesamtsaldo_rvc`      DECIMAL(15,2) DEFAULT NULL,
    `betrag_l_zahlung`     DECIMAL(15,2) DEFAULT NULL,
    `betrag_l_auslagerung` DECIMAL(15,2) DEFAULT NULL,
    `betrag_l_kontoauszug` DECIMAL(15,2) DEFAULT NULL,
    `dat_l_zahlung`        DATE         DEFAULT NULL,
    `dat_l_auslagerung`    DATE         DEFAULT NULL,
    `dat_l_kontoauszug`    DATE         DEFAULT NULL,
    `dat_l_mahnlauf`       DATE         DEFAULT NULL,
    `dat_ltzt_buchung`     DATE         DEFAULT NULL,
    `dat_einzbetrag`       DATE         DEFAULT NULL,
    `dat_ende_sonderzins`  DATE         DEFAULT NULL,
    `datum_anlage`         DATETIME     DEFAULT NULL,
    `geaendert_am`         DATETIME     DEFAULT NULL,
    `krsv`                 VARCHAR(50)  DEFAULT NULL,  -- inferred
    `kto_kenner`           VARCHAR(50)  DEFAULT NULL,
    `ktonr`                VARCHAR(50)  DEFAULT NULL,
    `lastschrift`          CHAR(1)      DEFAULT 'N',
    `letzter_stichtag`     DATE         DEFAULT NULL,
    `letzter_zahltag`      DATE         DEFAULT NULL,
    `mahnsperre`           CHAR(1)      DEFAULT 'N',
    `mahnsperre_datum`     DATE         DEFAULT NULL,
    `mahnstufe`            INT          DEFAULT NULL,
    `max_einzbetag`        DECIMAL(15,2) DEFAULT NULL,  -- note: typo in original (einzbetag vs einzbetrag)
    `max_einzbetrag`       DECIMAL(15,2) DEFAULT NULL,
    `offene_raten`         INT          DEFAULT NULL,
    `ratenanzahl`          INT          DEFAULT NULL,
    `ratenhoehe`           DECIMAL(15,2) DEFAULT NULL,
    `status_dat`           DATE         DEFAULT NULL,
    `stichtag`             DATE         DEFAULT NULL,
    `zahltag`              INT          DEFAULT NULL,    -- inferred: day of month
    PRIMARY KEY (`id`),
    FOREIGN KEY (`kunde_id`)         REFERENCES `kunde`        (`id`),
    FOREIGN KEY (`mandant_id`)       REFERENCES `mandant`      (`id`),
    FOREIGN KEY (`inkassostatus_id`) REFERENCES `inkassostatus`(`id`),
    FOREIGN KEY (`ra_ikbuero_id`)    REFERENCES `ra_ikbuero`   (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- TICKETS
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `ticket` (
    -- main work item (one customer case per agent session)
    -- columns confirmed via INSERT in ticket.php and getTicketColumns() decrypt list
    `id`                       INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ticketnr`                 INT UNSIGNED DEFAULT NULL,
    `mandant_id`               INT UNSIGNED NOT NULL,
    `kampagne_id`              INT UNSIGNED DEFAULT NULL,
    `kunde_id`                 INT UNSIGNED DEFAULT NULL,
    `benutzer_id`              INT UNSIGNED DEFAULT NULL,
    `kundennummer`             VARCHAR(50)  DEFAULT NULL,
    -- personal data (encrypted at DB level when mandant.encryption_aktiv = 'J')
    `anrede`                   VARCHAR(50)  DEFAULT NULL,
    `titel`                    VARCHAR(50)  DEFAULT NULL,
    `nachname`                 VARCHAR(100) DEFAULT NULL,
    `vorname`                  VARCHAR(100) DEFAULT NULL,
    `plz`                      VARCHAR(20)  DEFAULT NULL,
    `land_id`                  INT UNSIGNED DEFAULT NULL,
    `ort`                      VARCHAR(100) DEFAULT NULL,
    `strasse`                  VARCHAR(100) DEFAULT NULL,
    `hausnummer`               VARCHAR(20)  DEFAULT NULL,
    `hausnummer_erw`           VARCHAR(20)  DEFAULT NULL,
    `telefon`                  VARCHAR(50)  DEFAULT NULL,
    `telefon2`                 VARCHAR(50)  DEFAULT NULL,
    `email`                    VARCHAR(255) DEFAULT NULL,
    `geburtsdatum`             DATE         DEFAULT NULL,
    -- ticket state
    `kenner`                   VARCHAR(50)  DEFAULT NULL,
    `anruf_status_id`          INT UNSIGNED DEFAULT NULL,
    `ergebnis`                 TEXT         DEFAULT NULL,
    `wiedervorlage`            CHAR(1)      DEFAULT NULL,  -- inferred: Y/N flag
    `wiedervorlage_zeitpunkt`  DATETIME     DEFAULT NULL,
    `letzte_wiedervorlage`     CHAR(1)      DEFAULT NULL,
    `letzte_wiedervorlage_zeitpunkt` DATETIME DEFAULT NULL,
    `wiedervorlage_automatik`  CHAR(1)      DEFAULT NULL,
    `anzahl_anrufe`            INT          DEFAULT 0,
    `letzter_anruf`            DATETIME     DEFAULT NULL,
    `status_id`                INT UNSIGNED DEFAULT NULL,
    `prioritaet_id`            INT UNSIGNED DEFAULT NULL,
    `beginn`                   DATE         DEFAULT NULL,
    `ende`                     DATE         DEFAULT NULL,
    `aufwand`                  DECIMAL(10,2) DEFAULT NULL,
    `beschreibung_detail`      TEXT         DEFAULT NULL,  -- may be encrypted
    `geaendert_am`             DATETIME     DEFAULT NULL,
    `geaendert_von`            VARCHAR(100) DEFAULT NULL,
    `grund_id`                 INT UNSIGNED DEFAULT NULL,  -- inferred FK; no entity found
    `firma_id`                 INT UNSIGNED DEFAULT NULL,
    `produkt_id`               INT UNSIGNED DEFAULT NULL,  -- inferred FK; no entity found
    `bewertung`                INT          DEFAULT NULL,
    `katalogversand`           CHAR(1)      DEFAULT NULL,
    `emailversand`             CHAR(1)      DEFAULT NULL,
    -- campaign-specific free-text fields
    `textinfo1`                TEXT         DEFAULT NULL,
    `textinfo2`                TEXT         DEFAULT NULL,
    `textinfo3`                TEXT         DEFAULT NULL,
    `textinfo4`                TEXT         DEFAULT NULL,
    `textinfo5`                TEXT         DEFAULT NULL,
    -- vehicle-related fields (used by auto insurance campaigns)
    `standort`                 VARCHAR(255) DEFAULT NULL,
    `verkaeufercode`           VARCHAR(50)  DEFAULT NULL,
    `verkaeufername`           VARCHAR(100) DEFAULT NULL,
    `ltzt_wkst_auftrag`        VARCHAR(50)  DEFAULT NULL,
    `erstzulassung`            DATE         DEFAULT NULL,
    `kundenzulassung`          DATE         DEFAULT NULL,
    `markencode`               VARCHAR(50)  DEFAULT NULL,
    `modell`                   VARCHAR(100) DEFAULT NULL,
    `amtliches_kennzeichen`    VARCHAR(20)  DEFAULT NULL,
    `kilometer_stand`          INT          DEFAULT NULL,
    `fahrgestellnummer`        VARCHAR(50)  DEFAULT NULL,
    -- text answer fields (janein = yes/no; nummern = numeric)
    `textant11_janein_id`      INT UNSIGNED DEFAULT NULL,
    `textant12_nummern_id`     INT UNSIGNED DEFAULT NULL,
    `textant21_janein_id`      INT UNSIGNED DEFAULT NULL,
    `textant22_nummern_id`     INT UNSIGNED DEFAULT NULL,
    `textant31_janein_id`      INT UNSIGNED DEFAULT NULL,
    `textant32_nummern_id`     INT UNSIGNED DEFAULT NULL,
    `textant41_janein_id`      INT UNSIGNED DEFAULT NULL,
    `textant42_nummern_id`     INT UNSIGNED DEFAULT NULL,
    `textant51_janein_id`      INT UNSIGNED DEFAULT NULL,
    `textant52_nummern_id`     INT UNSIGNED DEFAULT NULL,
    -- generic extensibility columns (used per-campaign for extra data)
    `dummy_text1`              TEXT         DEFAULT NULL,
    `dummy_text2`              TEXT         DEFAULT NULL,
    `dummy_text3`              TEXT         DEFAULT NULL,
    `dummy_text4`              TEXT         DEFAULT NULL,
    `dummy_text5`              TEXT         DEFAULT NULL,
    `dummy_text6`              TEXT         DEFAULT NULL,
    `dummy_text7`              TEXT         DEFAULT NULL,
    `dummy_text8`              TEXT         DEFAULT NULL,
    `dummy_text9`              TEXT         DEFAULT NULL,
    `dummy_text10`             TEXT         DEFAULT NULL,
    `dummy_text11`             TEXT         DEFAULT NULL,
    `dummy_text12`             TEXT         DEFAULT NULL,
    `dummy_text13`             TEXT         DEFAULT NULL,
    `dummy_text14`             TEXT         DEFAULT NULL,
    `dummy_text15`             TEXT         DEFAULT NULL,
    `dummy_text16`             TEXT         DEFAULT NULL,
    `dummy_text17`             TEXT         DEFAULT NULL,
    `dummy_text18`             TEXT         DEFAULT NULL,
    `dummy_text19`             TEXT         DEFAULT NULL,
    `dummy_text20`             TEXT         DEFAULT NULL,
    `dummy_number1`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number2`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number3`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number4`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number5`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number6`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number7`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number8`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number9`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number10`           DECIMAL(15,2) DEFAULT NULL,
    `dummy_date1`              DATE         DEFAULT NULL,
    `dummy_date2`              DATE         DEFAULT NULL,
    `dummy_date3`              DATE         DEFAULT NULL,
    `dummy_date4`              DATE         DEFAULT NULL,
    `dummy_date5`              DATE         DEFAULT NULL,
    `dummy_date6`              DATE         DEFAULT NULL,
    `dummy_date7`              DATE         DEFAULT NULL,
    `dummy_date8`              DATE         DEFAULT NULL,
    `dummy_date9`              DATE         DEFAULT NULL,
    `dummy_date10`             DATE         DEFAULT NULL,
    `dummy_id1`                INT UNSIGNED DEFAULT NULL,
    `dummy_id2`                INT UNSIGNED DEFAULT NULL,
    `dummy_id3`                INT UNSIGNED DEFAULT NULL,
    `dummy_id4`                INT UNSIGNED DEFAULT NULL,
    `dummy_id5`                INT UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`mandant_id`)      REFERENCES `mandant`      (`id`),
    FOREIGN KEY (`kampagne_id`)     REFERENCES `kampagne`     (`id`),
    FOREIGN KEY (`kunde_id`)        REFERENCES `kunde`        (`id`),
    FOREIGN KEY (`benutzer_id`)     REFERENCES `benutzer`     (`id`),
    FOREIGN KEY (`anruf_status_id`) REFERENCES `anruf_status` (`id`),
    FOREIGN KEY (`status_id`)       REFERENCES `status`       (`id`),
    FOREIGN KEY (`prioritaet_id`)   REFERENCES `prioritaet`   (`id`),
    FOREIGN KEY (`firma_id`)        REFERENCES `firma`        (`id`),
    FOREIGN KEY (`land_id`)         REFERENCES `land`         (`id`),
    FOREIGN KEY (`grund_id`)        REFERENCES `grund`        (`id`),
    FOREIGN KEY (`produkt_id`)      REFERENCES `produkt`      (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `ticket_historie` (
    -- audit trail: copy of ticket state at each save; same columns minus letzter_anruf / wiedervorlage_automatik
    `id`                       INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ticketnr`                 INT UNSIGNED DEFAULT NULL,
    `mandant_id`               INT UNSIGNED DEFAULT NULL,
    `kampagne_id`              INT UNSIGNED DEFAULT NULL,
    `kunde_id`                 INT UNSIGNED DEFAULT NULL,
    `benutzer_id`              INT UNSIGNED DEFAULT NULL,
    `kundennummer`             VARCHAR(50)  DEFAULT NULL,
    `anrede`                   VARCHAR(50)  DEFAULT NULL,
    `titel`                    VARCHAR(50)  DEFAULT NULL,
    `nachname`                 VARCHAR(100) DEFAULT NULL,
    `vorname`                  VARCHAR(100) DEFAULT NULL,
    `plz`                      VARCHAR(20)  DEFAULT NULL,
    `land_id`                  INT UNSIGNED DEFAULT NULL,
    `ort`                      VARCHAR(100) DEFAULT NULL,
    `strasse`                  VARCHAR(100) DEFAULT NULL,
    `hausnummer`               VARCHAR(20)  DEFAULT NULL,
    `hausnummer_erw`           VARCHAR(20)  DEFAULT NULL,
    `telefon`                  VARCHAR(50)  DEFAULT NULL,
    `telefon2`                 VARCHAR(50)  DEFAULT NULL,
    `email`                    VARCHAR(255) DEFAULT NULL,
    `geburtsdatum`             DATE         DEFAULT NULL,
    `kenner`                   VARCHAR(50)  DEFAULT NULL,
    `anruf_status_id`          INT UNSIGNED DEFAULT NULL,
    `ergebnis`                 TEXT         DEFAULT NULL,
    `wiedervorlage`            CHAR(1)      DEFAULT NULL,
    `wiedervorlage_zeitpunkt`  DATETIME     DEFAULT NULL,
    `letzte_wiedervorlage`     CHAR(1)      DEFAULT NULL,
    `status_id`                INT UNSIGNED DEFAULT NULL,
    `prioritaet_id`            INT UNSIGNED DEFAULT NULL,
    `beginn`                   DATE         DEFAULT NULL,
    `ende`                     DATE         DEFAULT NULL,
    `aufwand`                  DECIMAL(10,2) DEFAULT NULL,
    `beschreibung_detail`      TEXT         DEFAULT NULL,
    `geaendert_am`             DATETIME     DEFAULT NULL,
    `geaendert_von`            VARCHAR(100) DEFAULT NULL,
    `grund_id`                 INT UNSIGNED DEFAULT NULL,
    `firma_id`                 INT UNSIGNED DEFAULT NULL,
    `produkt_id`               INT UNSIGNED DEFAULT NULL,
    `textinfo1`                TEXT         DEFAULT NULL,
    `textinfo2`                TEXT         DEFAULT NULL,
    `textinfo3`                TEXT         DEFAULT NULL,
    `textinfo4`                TEXT         DEFAULT NULL,
    `textinfo5`                TEXT         DEFAULT NULL,
    `standort`                 VARCHAR(255) DEFAULT NULL,
    `verkaeufercode`           VARCHAR(50)  DEFAULT NULL,
    `verkaeufername`           VARCHAR(100) DEFAULT NULL,
    `ltzt_wkst_auftrag`        VARCHAR(50)  DEFAULT NULL,
    `erstzulassung`            DATE         DEFAULT NULL,
    `kundenzulassung`          DATE         DEFAULT NULL,
    `markencode`               VARCHAR(50)  DEFAULT NULL,
    `modell`                   VARCHAR(100) DEFAULT NULL,
    `amtliches_kennzeichen`    VARCHAR(20)  DEFAULT NULL,
    `kilometer_stand`          INT          DEFAULT NULL,
    `fahrgestellnummer`        VARCHAR(50)  DEFAULT NULL,
    `textant11_janein_id`      INT UNSIGNED DEFAULT NULL,
    `textant12_nummern_id`     INT UNSIGNED DEFAULT NULL,
    `textant21_janein_id`      INT UNSIGNED DEFAULT NULL,
    `textant22_nummern_id`     INT UNSIGNED DEFAULT NULL,
    `textant31_janein_id`      INT UNSIGNED DEFAULT NULL,
    `textant32_nummern_id`     INT UNSIGNED DEFAULT NULL,
    `textant41_janein_id`      INT UNSIGNED DEFAULT NULL,
    `textant42_nummern_id`     INT UNSIGNED DEFAULT NULL,
    `textant51_janein_id`      INT UNSIGNED DEFAULT NULL,
    `textant52_nummern_id`     INT UNSIGNED DEFAULT NULL,
    `dummy_text1`              TEXT         DEFAULT NULL,
    `dummy_text2`              TEXT         DEFAULT NULL,
    `dummy_text3`              TEXT         DEFAULT NULL,
    `dummy_text4`              TEXT         DEFAULT NULL,
    `dummy_text5`              TEXT         DEFAULT NULL,
    `dummy_text6`              TEXT         DEFAULT NULL,
    `dummy_text7`              TEXT         DEFAULT NULL,
    `dummy_text8`              TEXT         DEFAULT NULL,
    `dummy_text9`              TEXT         DEFAULT NULL,
    `dummy_text10`             TEXT         DEFAULT NULL,
    `dummy_number1`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number2`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number3`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number4`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number5`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number6`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number7`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number8`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number9`            DECIMAL(15,2) DEFAULT NULL,
    `dummy_number10`           DECIMAL(15,2) DEFAULT NULL,
    `dummy_date1`              DATE         DEFAULT NULL,
    `dummy_date2`              DATE         DEFAULT NULL,
    `dummy_date3`              DATE         DEFAULT NULL,
    `dummy_date4`              DATE         DEFAULT NULL,
    `dummy_date5`              DATE         DEFAULT NULL,
    `dummy_date6`              DATE         DEFAULT NULL,
    `dummy_date7`              DATE         DEFAULT NULL,
    `dummy_date8`              DATE         DEFAULT NULL,
    `dummy_date9`              DATE         DEFAULT NULL,
    `dummy_date10`             DATE         DEFAULT NULL,
    `dummy_id1`                INT UNSIGNED DEFAULT NULL,
    `dummy_id2`                INT UNSIGNED DEFAULT NULL,
    `dummy_id3`                INT UNSIGNED DEFAULT NULL,
    `dummy_id4`                INT UNSIGNED DEFAULT NULL,
    `dummy_id5`                INT UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- FINANCIAL RECORDS
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `subkonto` (
    -- sub-account records; subkonto_s and subkonto_1 appear to share the same structure
    `id`               INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `stammdaten_id`    INT UNSIGNED NOT NULL,
    `sk_lfdnr`         INT          DEFAULT NULL,  -- sequential number within case
    `kdnr`             VARCHAR(50)  DEFAULT NULL,
    `rechnungsnummer`  VARCHAR(100) DEFAULT NULL,
    `status`           VARCHAR(50)  DEFAULT NULL,
    `kaufwert`         DECIMAL(15,2) DEFAULT NULL,
    `saldo`            DECIMAL(15,2) DEFAULT NULL,
    `saldo_neu`        DECIMAL(15,2) DEFAULT NULL,
    `rest`             DECIMAL(15,2) DEFAULT NULL,
    `buchungsdatum`    DATE         DEFAULT NULL,
    `belegdatum`       DATE         DEFAULT NULL,
    `faelligkeit`      DATE         DEFAULT NULL,
    `eroeffnet_am`     DATE         DEFAULT NULL,
    `valutierung`      DATE         DEFAULT NULL,
    `zahlart`          VARCHAR(50)  DEFAULT NULL,
    `zahlart_id`       INT UNSIGNED DEFAULT NULL,
    `buchungskennzeichen` VARCHAR(50) DEFAULT NULL,
    `buchungstext`     VARCHAR(255) DEFAULT NULL,
    `bugru_id`         INT UNSIGNED DEFAULT NULL,
    `bua_bgr_man_id`   INT UNSIGNED DEFAULT NULL,
    `ba_buart_key`     VARCHAR(50)  DEFAULT NULL,
    `ba_text`          VARCHAR(255) DEFAULT NULL,
    `bg_bugru_key`     VARCHAR(50)  DEFAULT NULL,
    `bg_bugru_key_om`  VARCHAR(50)  DEFAULT NULL,
    `bg_kz_berechnung` CHAR(1)      DEFAULT NULL,
    `bg_kz_saldowirksam` CHAR(1)    DEFAULT NULL,
    `bg_text`          VARCHAR(255) DEFAULT NULL,
    `kz_aktuell`       CHAR(1)      DEFAULT NULL,
    `kz_gebucht`       CHAR(1)      DEFAULT NULL,
    `kz_ratenplanaend` CHAR(1)      DEFAULT NULL,
    `l_st_kap_zins`    DECIMAL(15,2) DEFAULT NULL,
    `vl_st_kap_zins`   DECIMAL(15,2) DEFAULT NULL,
    `m0`               DECIMAL(15,2) DEFAULT NULL,
    `m1`               DECIMAL(15,2) DEFAULT NULL,
    `m2`               DECIMAL(15,2) DEFAULT NULL,
    `m3`               DECIMAL(15,2) DEFAULT NULL,
    `m4`               DECIMAL(15,2) DEFAULT NULL,
    `v1`               DECIMAL(15,2) DEFAULT NULL,
    `v2`               DECIMAL(15,2) DEFAULT NULL,
    `v3`               DECIMAL(15,2) DEFAULT NULL,
    `v4`               DECIMAL(15,2) DEFAULT NULL,
    `zinssatz`         DECIMAL(10,4) DEFAULT NULL,
    `zinsen_aufgel`    DECIMAL(15,2) DEFAULT NULL,
    `tageszinshoehe`   DECIMAL(15,4) DEFAULT NULL,
    `tgz_anzeige`      DECIMAL(15,2) DEFAULT NULL,
    `tgz_tage`         INT           DEFAULT NULL,
    `datum_debsaldo`   DATE          DEFAULT NULL,
    `datum_l_tz_erm`   DATE          DEFAULT NULL,
    `prozent_zinsen`   DECIMAL(10,4) DEFAULT NULL,
    `markt`            VARCHAR(50)   DEFAULT NULL,
    `ratenhoehe`       DECIMAL(15,2) DEFAULT NULL,
    `max_id`           INT UNSIGNED  DEFAULT NULL,
    `verwendungszweck` VARCHAR(255)  DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`stammdaten_id`) REFERENCES `stammdaten`   (`id`),
    FOREIGN KEY (`zahlart_id`)    REFERENCES `zahlart`      (`id`),
    FOREIGN KEY (`bugru_id`)      REFERENCES `buchungsgrund`(`id`),
    FOREIGN KEY (`bua_bgr_man_id`) REFERENCES `bua_bgr_man`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `subkonto_s` LIKE `subkonto`;  -- inferred: same structure, separate partition/variant
CREATE TABLE IF NOT EXISTS `subkonto_1` LIKE `subkonto`;  -- inferred: same structure, separate partition/variant

CREATE TABLE IF NOT EXISTS `subkonto_neu` (
    -- active/recalculated sub-account rows; columns confirmed by subkonto.php INSERT/UPDATE
    `id`                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `sk_lfdnr`             INT          DEFAULT NULL,
    `stammdaten_id`        INT UNSIGNED NOT NULL,
    `rechnungsnummer`      VARCHAR(100) DEFAULT NULL,
    `zahlart_id`           INT UNSIGNED DEFAULT NULL,
    `zinssatz`             DECIMAL(10,4) DEFAULT NULL,
    `eroeffnet_am`         DATETIME     DEFAULT NULL,
    `kaufwert`             DECIMAL(15,2) DEFAULT NULL,
    `ratenhoehe`           DECIMAL(15,2) DEFAULT NULL,
    `buchung_lfdnr`        INT          DEFAULT NULL,  -- selected by modules/subkonto.php; not inserted
    `bua_bgr_man_id`       INT UNSIGNED DEFAULT NULL,
    `buchungsdatum`        DATE         DEFAULT NULL,
    `buchungsbetrag`       DECIMAL(15,2) DEFAULT NULL,
    `m4`                   DECIMAL(15,2) DEFAULT NULL,
    `m3`                   DECIMAL(15,2) DEFAULT NULL,
    `m2`                   DECIMAL(15,2) DEFAULT NULL,
    `m1`                   DECIMAL(15,2) DEFAULT NULL,
    `m0`                   DECIMAL(15,2) DEFAULT NULL,
    `rest`                 DECIMAL(15,2) DEFAULT NULL,
    `v1`                   DECIMAL(15,2) DEFAULT NULL,
    `v2`                   DECIMAL(15,2) DEFAULT NULL,
    `v3`                   DECIMAL(15,2) DEFAULT NULL,
    `v4`                   DECIMAL(15,2) DEFAULT NULL,
    `saldo`                DECIMAL(15,2) DEFAULT NULL,
    `geaendert_am`         DATETIME      DEFAULT NULL,
    `kz_aktuell`           CHAR(1)       DEFAULT NULL,
    `status_id`            INT UNSIGNED  DEFAULT NULL,
    `geaendert_von`        VARCHAR(100)  DEFAULT NULL,
    `belegdatum`           DATE          DEFAULT NULL,
    `buchungskennzeichen`  VARCHAR(50)   DEFAULT NULL,
    `valutierung`          DATE          DEFAULT NULL,
    `zahlungsfrist`        DATE          DEFAULT NULL,
    `prozent_zinsen`       DECIMAL(10,4) DEFAULT NULL,
    `tageszinshoehe`       DECIMAL(15,4) DEFAULT NULL,
    `datum_l_tz_erm`       DATE          DEFAULT NULL,
    `l_st_kap_zins`        DECIMAL(15,2) DEFAULT NULL,
    `vl_st_kap_zins`       DECIMAL(15,2) DEFAULT NULL,
    `kz_ratenplanaend`     CHAR(1)       DEFAULT NULL,
    `datum_debsaldo`       DATE          DEFAULT NULL,
    `verguetung`           DECIMAL(15,2) DEFAULT NULL,
    `faelligkeit`          DATE          DEFAULT NULL,
    `kz_gebucht`           CHAR(1)       DEFAULT NULL,
    `verwendungszweck`     VARCHAR(255)  DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`stammdaten_id`)  REFERENCES `stammdaten`  (`id`),
    FOREIGN KEY (`zahlart_id`)     REFERENCES `zahlart`     (`id`),
    FOREIGN KEY (`bua_bgr_man_id`) REFERENCES `bua_bgr_man`(`id`),
    FOREIGN KEY (`status_id`)      REFERENCES `status`     (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `buchungen` (
    -- financial booking/transaction records
    `id`                INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `stammdaten_id`     INT UNSIGNED NOT NULL,
    `buchungsdatum`     DATE         DEFAULT NULL,
    `valutadatum`       DATE         DEFAULT NULL,
    `betrag`            DECIMAL(15,2) DEFAULT NULL,
    `buchungskennzeichen` VARCHAR(50) DEFAULT NULL,
    `buart_key`         VARCHAR(50)  DEFAULT NULL,
    `bua_bgr_man_id`    INT UNSIGNED DEFAULT NULL,
    `ba_buart_key`      VARCHAR(50)  DEFAULT NULL,
    `ba_text`           VARCHAR(255) DEFAULT NULL,
    `bg_bugru_key`      VARCHAR(50)  DEFAULT NULL,
    `bg_bugru_key_om`   VARCHAR(50)  DEFAULT NULL,
    `bg_kz_berechnung`  CHAR(1)      DEFAULT NULL,
    `bg_text`           VARCHAR(255) DEFAULT NULL,
    `herkunft`          VARCHAR(50)  DEFAULT NULL,
    `kz_gebucht`        CHAR(1)      DEFAULT NULL,
    `kz_manbuchung`     CHAR(1)      DEFAULT NULL,
    `mwst_0`            DECIMAL(15,2) DEFAULT NULL,
    `mwst_10`           DECIMAL(15,2) DEFAULT NULL,
    `mwst_20`           DECIMAL(15,2) DEFAULT NULL,
    `mwst_id`           INT UNSIGNED DEFAULT NULL,  -- inferred FK to a mwst table (not found)
    `rabatt`            DECIMAL(15,2) DEFAULT NULL,
    `ratenhoehe`        DECIMAL(15,2) DEFAULT NULL,
    `spesen`            DECIMAL(15,2) DEFAULT NULL,
    `verguetung`        DECIMAL(15,2) DEFAULT NULL,
    `verwendungszweck`  VARCHAR(255) DEFAULT NULL,
    `zahlart_id`        INT UNSIGNED DEFAULT NULL,
    `zahlart_text`      VARCHAR(100) DEFAULT NULL,
    `auftragsnummer`    VARCHAR(100) DEFAULT NULL,
    `geaendert_von`     VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`stammdaten_id`)  REFERENCES `stammdaten`  (`id`),
    FOREIGN KEY (`zahlart_id`)     REFERENCES `zahlart`     (`id`),
    FOREIGN KEY (`bua_bgr_man_id`) REFERENCES `bua_bgr_man`(`id`),
    FOREIGN KEY (`mwst_id`)        REFERENCES `mwst`       (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `lastschrift` (
    -- direct debit mandate
    `id`                INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id`        INT UNSIGNED DEFAULT NULL,
    `stammdaten_id`     INT UNSIGNED NOT NULL,
    `bankleitzahl_id`   INT UNSIGNED DEFAULT NULL,
    `kontoinhaber`      VARCHAR(255) DEFAULT NULL,
    `kontonummer`       VARCHAR(50)  DEFAULT NULL,
    `iban`              VARCHAR(34)  DEFAULT NULL,
    `kz_lastschrift`    CHAR(1)      DEFAULT NULL,
    `kz_kzinaktiv`      CHAR(1)      DEFAULT NULL,
    `dat_lastschrift`   DATE         DEFAULT NULL,
    `dat_einzbetrag`    DATE         DEFAULT NULL,
    `dat_inaktiv`       DATE         DEFAULT NULL,
    `dat_unterschrift`  DATE         DEFAULT NULL,
    `sepa_einzug_sequenz` VARCHAR(20) DEFAULT NULL,
    `max_einzbetrag`    DECIMAL(15,2) DEFAULT NULL,
    `geaendert_von`     VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`mandant_id`)      REFERENCES `mandant`     (`id`),
    FOREIGN KEY (`stammdaten_id`)   REFERENCES `stammdaten`  (`id`),
    FOREIGN KEY (`bankleitzahl_id`) REFERENCES `bankleitzahl`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `verwaltungssatz` (
    -- administrative record per mandant/markt (period summaries)
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id`    INT UNSIGNED NOT NULL,
    `markt`         VARCHAR(50)  DEFAULT NULL,
    `kz_aktuell`    CHAR(1)      DEFAULT NULL,
    `buchungsdatum` DATE         DEFAULT NULL,
    `stichtag1`     DATE         DEFAULT NULL,
    `stichtag2`     DATE         DEFAULT NULL,
    `stichtag3`     DATE         DEFAULT NULL,
    `stichtag4`     DATE         DEFAULT NULL,
    `stichtag5`     DATE         DEFAULT NULL,
    `saldo_gesamt`  DECIMAL(15,2) DEFAULT NULL,
    `saldo_tag`     DECIMAL(15,2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`mandant_id`) REFERENCES `mandant`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- DEBT COLLECTION
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `inkassoinformation` (
    `id`                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `kunde_id`            INT UNSIGNED DEFAULT NULL,
    `kundennummer`        VARCHAR(50)  DEFAULT NULL,
    `inkassostatus`       VARCHAR(50)  DEFAULT NULL,
    `inkassostatus_id`    INT UNSIGNED DEFAULT NULL,
    `erled_qual`          VARCHAR(50)  DEFAULT NULL,
    `erled_qual_id`       INT UNSIGNED DEFAULT NULL,
    `anz_uebergab`        INT          DEFAULT NULL,
    `ausbuch_grund`       VARCHAR(50)  DEFAULT NULL,
    `ausbuch_text`        VARCHAR(255) DEFAULT NULL,
    `ausbuchungsgrund_id` INT UNSIGNED DEFAULT NULL,
    `dubiosenink`         CHAR(1)      DEFAULT NULL,
    `erl_dat`             DATE         DEFAULT NULL,
    `erl_du_dat`          DATE         DEFAULT NULL,
    `erl_text`            VARCHAR(255) DEFAULT NULL,
    `geaendert_von`       VARCHAR(100) DEFAULT NULL,
    `ikstat_bezeichnung`  VARCHAR(255) DEFAULT NULL,
    `ikstat_text`         VARCHAR(255) DEFAULT NULL,
    `letzte_aenderung`    DATETIME     DEFAULT NULL,
    `max_id`              INT UNSIGNED DEFAULT NULL,
    `rab_text`            VARCHAR(255) DEFAULT NULL,
    `ra_buero`            VARCHAR(255) DEFAULT NULL,
    `ra_ikbuero_id`       INT UNSIGNED DEFAULT NULL,
    `status_dat`          DATE         DEFAULT NULL,
    `uebergabe_betrag`    DECIMAL(15,2) DEFAULT NULL,
    `uebergabe_dat`       DATE         DEFAULT NULL,
    `uebetr_du`           DECIMAL(15,2) DEFAULT NULL,
    `uneinbringlich`      CHAR(1)      DEFAULT NULL,
    `verwendungszweck`    VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`kunde_id`)            REFERENCES `kunde`           (`id`),
    FOREIGN KEY (`inkassostatus_id`)    REFERENCES `inkassostatus`   (`id`),
    FOREIGN KEY (`erled_qual_id`)       REFERENCES `erled_qual`      (`id`),
    FOREIGN KEY (`ausbuchungsgrund_id`) REFERENCES `ausbuchungsgrund`(`id`),
    FOREIGN KEY (`ra_ikbuero_id`)       REFERENCES `ra_ikbuero`      (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `akt` (
    -- legal case document; columns from UPDATE statement in akt.php
    `id`                         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id`                 INT UNSIGNED NOT NULL,
    `ticket_id`                  INT UNSIGNED NOT NULL,
    `akt_titel_gericht`          VARCHAR(255) DEFAULT NULL,
    `akt_titel_datum`            DATE         DEFAULT NULL,
    `akt_titel_geschaeftszahl`   VARCHAR(100) DEFAULT NULL,
    `akt_letztes_exekutionsgericht` VARCHAR(255) DEFAULT NULL,
    `akt_exekution_geschaeftszahl` VARCHAR(100) DEFAULT NULL,
    `akt_forderungsgrund01`      TEXT         DEFAULT NULL,
    `akt_forderungsgrund12`      TEXT         DEFAULT NULL,
    `akt_forderungsbetrag`       DECIMAL(15,2) DEFAULT NULL,
    `akt_waehrung`               CHAR(3)      DEFAULT NULL,
    `akt_hinweise`               TEXT         DEFAULT NULL,
    `akt_anzahl_dokumente`       INT          DEFAULT NULL,
    `akt_restl_hauptforderung`   DECIMAL(15,2) DEFAULT NULL,
    `akt_zinssatz_kapital`       DECIMAL(10,4) DEFAULT NULL,
    `akt_restl_nebenforderung`   DECIMAL(15,2) DEFAULT NULL,
    `akt_kap_zinsen_bis_stichtag1` DECIMAL(15,2) DEFAULT NULL,
    `akt_kap_zinsen_bis_stichtag2` DECIMAL(15,2) DEFAULT NULL,
    `akt_kap_zinsen_bis_stichtag`  DECIMAL(15,2) DEFAULT NULL,  -- computed sum
    `akt_rest_ra_honorar`        DECIMAL(15,2) DEFAULT NULL,
    `akt_restl_barauslagen`      DECIMAL(15,2) DEFAULT NULL,    -- computed
    `akt_abrechnungsstichtag`    DATE         DEFAULT NULL,
    `akt_kosten_titel`           DECIMAL(15,2) DEFAULT NULL,
    `akt_kosten_exe`             DECIMAL(15,2) DEFAULT NULL,
    `akt_kosten_geb`             DECIMAL(15,2) DEFAULT NULL,
    `akt_kosten_sonst`           DECIMAL(15,2) DEFAULT NULL,
    `akt_su_anrede`              VARCHAR(50)  DEFAULT NULL,
    `akt_su_nachname`            VARCHAR(100) DEFAULT NULL,
    `akt_su_vorname`             VARCHAR(100) DEFAULT NULL,
    `akt_su_gebdatum`            DATE         DEFAULT NULL,
    `akt_su_firmenbuchnummer`    VARCHAR(50)  DEFAULT NULL,
    `akt_su_strhnr`              VARCHAR(100) DEFAULT NULL,
    `akt_su_plz`                 VARCHAR(20)  DEFAULT NULL,
    `akt_su_ort`                 VARCHAR(100) DEFAULT NULL,
    `akt_zinsstartdatum`         DATE         DEFAULT NULL,
    `geaendert_am`               DATETIME     DEFAULT NULL,
    `geaendert_von`              VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`mandant_id`) REFERENCES `mandant`(`id`),
    FOREIGN KEY (`ticket_id`)  REFERENCES `ticket` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `schadensfall` (
    -- insurance damage/claim case
    `id`                      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id`              INT UNSIGNED NOT NULL,
    `stammdaten_id`           INT UNSIGNED NOT NULL,
    `schadensfall_art_id`     INT UNSIGNED DEFAULT NULL,
    `status_schadensfall_id`  INT UNSIGNED DEFAULT NULL,
    `forderungsart`           VARCHAR(100) DEFAULT NULL,
    `forderungsbetrag`        DECIMAL(15,2) DEFAULT NULL,
    `leistung_ab`             DATE         DEFAULT NULL,
    `maximale_leistung`       DECIMAL(15,2) DEFAULT NULL,
    `zahlungsbetrag`          DECIMAL(15,2) DEFAULT NULL,
    `saldo_gemeldet`          DECIMAL(15,2) DEFAULT NULL,
    `dat_gemeldet`            DATE         DEFAULT NULL,
    `dat_erledigt`            DATE         DEFAULT NULL,
    `dat_pruefung`            DATE         DEFAULT NULL,
    `dat_schadenseintritt`    DATE         DEFAULT NULL,
    `dat_zahlungseingang`     DATE         DEFAULT NULL,
    `dat_ende_schadensleistung` DATE        DEFAULT NULL,
    `geaendert_von`           VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`mandant_id`)             REFERENCES `mandant`          (`id`),
    FOREIGN KEY (`stammdaten_id`)          REFERENCES `stammdaten`       (`id`),
    FOREIGN KEY (`schadensfall_art_id`)    REFERENCES `schadensfall_art` (`id`),
    FOREIGN KEY (`status_schadensfall_id`) REFERENCES `status_schadensfall`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `versicherung` (
    -- insurance policy record
    `id`                      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id`              INT UNSIGNED DEFAULT NULL,
    `stammdaten_id`           INT UNSIGNED NOT NULL,
    `versicherung_bezeichnung` VARCHAR(255) DEFAULT NULL,
    `versicherungsvariante`   VARCHAR(100) DEFAULT NULL,
    `dat_abschluss`           DATE         DEFAULT NULL,
    `dat_meldung_abschluss`   DATE         DEFAULT NULL,
    `dat_info_aend_bed`       DATE         DEFAULT NULL,
    `dat_storno`              DATE         DEFAULT NULL,
    `dat_leistung`            DATE         DEFAULT NULL,
    `user_abschluss`          VARCHAR(100) DEFAULT NULL,
    `user_storno`             VARCHAR(100) DEFAULT NULL,
    `geaendert_von`           VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`mandant_id`)    REFERENCES `mandant`  (`id`),
    FOREIGN KEY (`stammdaten_id`) REFERENCES `stammdaten`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- ACTIVITY / HISTORY
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `kundenhistorie` (
    -- customer history / interaction notes
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id`   INT UNSIGNED NOT NULL,
    `kdnr_id`      INT UNSIGNED DEFAULT NULL,  -- FK to kunde
    `kategorie_id` INT UNSIGNED DEFAULT NULL,
    `anstoss_id`   INT UNSIGNED DEFAULT NULL,
    `benutzer_id1` INT UNSIGNED DEFAULT NULL,
    `benutzer_id2` INT UNSIGNED DEFAULT NULL,
    `geaendert_am` DATETIME     DEFAULT NULL,
    `text`         TEXT         DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`mandant_id`)   REFERENCES `mandant`  (`id`),
    FOREIGN KEY (`kdnr_id`)      REFERENCES `kunde`    (`id`),
    FOREIGN KEY (`kategorie_id`) REFERENCES `kategorie`(`id`),
    FOREIGN KEY (`anstoss_id`)   REFERENCES `anstoss`  (`id`),
    FOREIGN KEY (`benutzer_id1`) REFERENCES `benutzer` (`id`),
    FOREIGN KEY (`benutzer_id2`) REFERENCES `benutzer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `log` (
    -- interaction / activity log; objekt = entity type, objekt_id = entity PK
    `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `objekt`    VARCHAR(100) DEFAULT NULL,
    `objekt_id` INT UNSIGNED DEFAULT NULL,
    `logart`    VARCHAR(50)  DEFAULT NULL,
    `benutzer`  VARCHAR(100) DEFAULT NULL,  -- username string (not FK)
    `timestamp` DATETIME     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================================================
-- STORED FUNCTIONS (stubs — bodies unknown; required for encryption feature)
-- =============================================================================
-- The real implementations live in the database, not in the PHP codebase.
-- These stubs allow the schema to load without error; replace with actual
-- implementations when the client provides the database dump.

DELIMITER $$

DROP FUNCTION IF EXISTS `kimi_encrypt`$$
CREATE FUNCTION `kimi_encrypt`(val TEXT) RETURNS TEXT
    DETERMINISTIC
BEGIN
    -- stub: replace with actual AES encryption implementation
    RETURN val;
END$$

DROP FUNCTION IF EXISTS `kimi_decrypt`$$
CREATE FUNCTION `kimi_decrypt`(val TEXT) RETURNS TEXT
    DETERMINISTIC
BEGIN
    -- stub: returns value unchanged until real implementation is provided
    RETURN val;
END$$

DROP FUNCTION IF EXISTS `kimi_decrypt_date`$$
CREATE FUNCTION `kimi_decrypt_date`(val TEXT) RETURNS TEXT
    DETERMINISTIC
BEGIN
    RETURN val;
END$$

DELIMITER ;
