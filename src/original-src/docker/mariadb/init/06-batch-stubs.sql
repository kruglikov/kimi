-- Stub stored functions and campaign data tables required by kimibatch scripts.
-- All functions return empty/zero values — sufficient for smoke testing.
-- All tables have the columns referenced in the batch scripts but start empty.

USE kimi_et;

-- ---------------------------------------------------------------------------
-- Stored function stubs
-- ---------------------------------------------------------------------------

-- Used in WHERE clause: getLogAnrufVorhanden(ticket.id) = 0
-- Returning 0 means "no call log found" — includes all tickets in the check.
CREATE FUNCTION IF NOT EXISTS getLogAnrufVorhanden(p_id INT UNSIGNED)
    RETURNS TINYINT(1)
    DETERMINISTIC
    RETURN 0;

-- Used in: DATE_FORMAT(getLogStartGes(ticket.id, ''), '%d.%m.%Y')
CREATE FUNCTION IF NOT EXISTS getLogStartGes(p_id INT UNSIGNED, p_param VARCHAR(255))
    RETURNS DATETIME
    DETERMINISTIC
    RETURN NULL;

-- Used in: getLogAgentAnrede(ticket.id, '')
CREATE FUNCTION IF NOT EXISTS getLogAgentAnrede(p_id INT UNSIGNED, p_param VARCHAR(255))
    RETURNS VARCHAR(50)
    DETERMINISTIC
    RETURN '';

-- Used in: getLogAgentVorname(ticket.id, '')
CREATE FUNCTION IF NOT EXISTS getLogAgentVorname(p_id INT UNSIGNED, p_param VARCHAR(255))
    RETURNS VARCHAR(100)
    DETERMINISTIC
    RETURN '';

-- Used in: getLogAgentNachname(ticket.id, '')
CREATE FUNCTION IF NOT EXISTS getLogAgentNachname(p_id INT UNSIGNED, p_param VARCHAR(255))
    RETURNS VARCHAR(100)
    DETERMINISTIC
    RETURN '';

-- Used in export scripts (mostly commented out, added for completeness)
CREATE FUNCTION IF NOT EXISTS getLogZeit(p_id INT UNSIGNED, p_param VARCHAR(255))
    RETURNS INT
    DETERMINISTIC
    RETURN 0;

-- Used in checktest and quester/schlau export scripts (complex log subquery)
CREATE FUNCTION IF NOT EXISTS get_log_last_user(p_objekt VARCHAR(100), p_objekt_id INT UNSIGNED, p_logart VARCHAR(50))
    RETURNS VARCHAR(255)
    DETERMINISTIC
    RETURN '';

-- ---------------------------------------------------------------------------
-- Campaign import data tables
-- Column lists derived from INSERT statements in the corresponding imp scripts.
-- ---------------------------------------------------------------------------

-- INKODE campaign original data (inkodeimp2.php)
CREATE TABLE IF NOT EXISTS inkode (
    id              INT(10) UNSIGNED NOT NULL,
    indexa          DECIMAL(15,2),
    indexb          DECIMAL(15,2),
    indexc          DECIMAL(15,2),
    name            TEXT,
    vorname         TEXT,
    strasse         TEXT,
    plz             TEXT,
    ort             TEXT,
    telnr           TEXT,
    telnr2          TEXT,
    gebdatum        TEXT,
    saldo           DECIMAL(15,2),
    iban            VARCHAR(50),
    bic             VARCHAR(30),
    bemerkung       TEXT,
    verzzinsen      DECIMAL(15,2),
    connect         VARCHAR(50),
    rpc             VARCHAR(50),
    ptp             VARCHAR(50),
    import          DATETIME,
    email           TEXT,
    glname          VARCHAR(200),
    glort           VARCHAR(200),
    sbname          VARCHAR(200),
    sbemail         VARCHAR(200),
    sbtelnr         VARCHAR(100),
    naechsterschritt TEXT,
    telnrapl        TEXT,
    arbplatz        VARCHAR(100),
    rh              VARCHAR(50),
    faell           VARCHAR(50),
    datlzahl        VARCHAR(50),
    betrlzahl       DECIMAL(15,2),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- INKO2016 campaign original data (inko2016imp3.php) — identical structure
CREATE TABLE IF NOT EXISTS inko2016 (
    id              INT(10) UNSIGNED NOT NULL,
    indexa          DECIMAL(15,2),
    indexb          DECIMAL(15,2),
    indexc          DECIMAL(15,2),
    name            TEXT,
    vorname         TEXT,
    strasse         TEXT,
    plz             TEXT,
    ort             TEXT,
    telnr           TEXT,
    telnr2          TEXT,
    gebdatum        TEXT,
    saldo           DECIMAL(15,2),
    iban            VARCHAR(50),
    bic             VARCHAR(30),
    bemerkung       TEXT,
    verzzinsen      DECIMAL(15,2),
    connect         VARCHAR(50),
    rpc             VARCHAR(50),
    ptp             VARCHAR(50),
    import          DATETIME,
    email           TEXT,
    glname          VARCHAR(200),
    glort           VARCHAR(200),
    sbname          VARCHAR(200),
    sbemail         VARCHAR(200),
    sbtelnr         VARCHAR(100),
    naechsterschritt TEXT,
    telnrapl        TEXT,
    arbplatz        VARCHAR(100),
    rh              VARCHAR(50),
    faell           VARCHAR(50),
    datlzahl        VARCHAR(50),
    betrlzahl       DECIMAL(15,2),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- OKO campaign original data (okoimp.php)
CREATE TABLE IF NOT EXISTS oko (
    id                   INT(10) UNSIGNED NOT NULL,
    aktnr1               VARCHAR(100),
    aktnr2               VARCHAR(100),
    sachbearb            VARCHAR(200),
    glaeubiger           TEXT,
    glaeubiger_anschrift TEXT,
    schuldner            TEXT,
    schuldner_strasse    TEXT,
    schuldner_ort        TEXT,
    mitschuldner         TEXT,
    aufgabe1             TEXT,
    aufgabe2             TEXT,
    saldo                DECIMAL(15,2),
    telnr1               TEXT,
    telnr2               TEXT,
    telnr3               TEXT,
    telnr4               TEXT,
    iban                 VARCHAR(50),
    bic                  VARCHAR(30),
    bemerkung            TEXT,
    geburtsdatum         TEXT,
    ratenanzahl          INT,
    ratenhoehe           DECIMAL(15,2),
    gesamtzahlung        DECIMAL(15,2),
    faelligbis           VARCHAR(50),
    import               DATETIME,
    email01              TEXT,
    telefon3plus         TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- OKO daily call summary (okoexp.php LEFT JOIN)
CREATE TABLE IF NOT EXISTS okozwb (
    id         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    mandant    INT(10) UNSIGNED NOT NULL,
    ticketnr   INT(10) UNSIGNED NOT NULL,
    tagesdatum DATE             NOT NULL,
    anzahl     INT              NOT NULL DEFAULT 0,
    text       VARCHAR(255),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- INKODE urgency notes (inkodeimp2.php)
CREATE TABLE IF NOT EXISTS inkodeurgenz (
    mandant_id  INT(10) UNSIGNED NOT NULL,
    ticketnr    INT(10) UNSIGNED NOT NULL,
    urgenztext  TEXT,
    PRIMARY KEY (mandant_id, ticketnr)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- INKO2016 urgency notes (inko2016imp3.php)
CREATE TABLE IF NOT EXISTS inko2016urgenz (
    mandant_id  INT(10) UNSIGNED NOT NULL,
    ticketnr    INT(10) UNSIGNED NOT NULL,
    urgenztext  TEXT,
    PRIMARY KEY (mandant_id, ticketnr)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- SCHLAUSTROM campaign original data (schlaustromexp*.php alias: sst)
CREATE TABLE IF NOT EXISTS schlaustrom (
    id                  INT(10) UNSIGNED NOT NULL,
    rg_nr               VARCHAR(100),
    kunde               TEXT,              -- encrypted customer name; referenced as kimi_decrypt(kunde) in export query
    rg_titel            TEXT,
    kunden_nummer       VARCHAR(100),
    rg_datum            DATE,
    rg_total            DECIMAL(15,2),
    rueckent_bank       DECIMAL(15,2),
    total_inklusive     DECIMAL(15,2),
    kd_gesamt_offen     DECIMAL(15,2),
    kd_anzahl_offen     INT,
    ruecklastschrift    DECIMAL(15,2),
    rg_datum_mahn1      DATE,
    rg_datum_mahn2      DATE,
    rg_telefoniestatusM1 VARCHAR(100),
    rg_telefoniestatusM2 VARCHAR(100),
    rg_ruecklast_erl    VARCHAR(100),
    rg_keine_sepaLG     VARCHAR(100),
    rg_beschreibung     TEXT,
    kd_geburtsdatum     TEXT,
    kd_vorname          TEXT,
    kd_name             TEXT,
    kd_titel            TEXT,
    kd_telefon          TEXT,
    kd_handy            TEXT,
    kd_email            TEXT,
    kd_lyoness          VARCHAR(100),
    kd_etoxx            VARCHAR(100),
    kd_name_liefer      TEXT,
    kd_str_liefer       TEXT,
    kd_hnr_liefer       TEXT,
    kd_plz_liefer       TEXT,
    kd_ort_liefer       TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- KNP3 campaign data table (coeochdeexp*.php — joined as knp3)
CREATE TABLE IF NOT EXISTS knp3 (
    id          INT(10) UNSIGNED NOT NULL,
    kampagneid  VARCHAR(100),
    vorgangid   VARCHAR(100),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- KNP3 outbound call result table (coeochdeexp*.php alias: ki / ki2)
CREATE TABLE IF NOT EXISTS knp3_out (
    id                              INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    imp_str_ticketnr                INT(10) UNSIGNED,
    import                          DATETIME,
    verarbeitet                     DATE,
    status                          VARCHAR(100),
    beschreibung_positiver_ausgang  TEXT,
    grund_negativer_ausgang         TEXT,
    nachname_agenten                VARCHAR(200),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- OKO dated snapshot table referenced by okoexp_dev / okoexp_ansi variants
CREATE TABLE IF NOT EXISTS okoerledigt20220713 (
    ticketnr INT(10) UNSIGNED NOT NULL,
    PRIMARY KEY (ticketnr)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- QUESTER campaign original data (questerexp20250208.php alias: sst)
CREATE TABLE IF NOT EXISTS quester (
    id            INT(10) UNSIGNED NOT NULL,
    kunden_nummer VARCHAR(100),
    rg_total      DECIMAL(15,2),
    kunde         TEXT,              -- encrypted customer name; referenced as kimi_decrypt(kunde) in export query
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- ticket_* stub views for KPI scripts (kpis.php, kpiscsv.php, kpisemail.php)
-- Each view returns an empty result set with the required column signature.
-- All views expose the standard ticket columns plus erstellt (DATETIME alias).
-- ---------------------------------------------------------------------------

CREATE OR REPLACE VIEW ticket_inkoinbound AS
    SELECT *, CAST(NULL AS DATETIME) AS erstellt
    FROM ticket WHERE 1=0;

CREATE OR REPLACE VIEW ticket_inko2016 AS
    SELECT *, CAST(NULL AS DATETIME) AS erstellt
    FROM ticket WHERE 1=0;

CREATE OR REPLACE VIEW ticket_inkode AS
    SELECT *, CAST(NULL AS DATETIME) AS erstellt
    FROM ticket WHERE 1=0;

CREATE OR REPLACE VIEW ticket_schlaustrom AS
    SELECT *, CAST(NULL AS DATETIME) AS erstellt
    FROM ticket WHERE 1=0;

CREATE OR REPLACE VIEW ticket_knp1 AS
    SELECT *, CAST(NULL AS DATETIME) AS erstellt
    FROM ticket WHERE 1=0;

CREATE OR REPLACE VIEW ticket_knp3 AS
    SELECT *, CAST(NULL AS DATETIME) AS erstellt
    FROM ticket WHERE 1=0;

CREATE OR REPLACE VIEW ticket_oko AS
    SELECT *, CAST(NULL AS DATETIME) AS erstellt
    FROM ticket WHERE 1=0;
