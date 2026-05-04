-- =============================================================================
-- KIMI Portal — Local Development Seed Data
-- =============================================================================
-- Purpose: minimal, deterministic data for local login and smoke testing.
-- Scope:   development only; do not use these credentials outside local Docker.
--
-- Login:
--   URL:      http://localhost:8080/kimi_ET/
--   User:     admin
--   Password: admin123
-- =============================================================================

USE kimi_et;

-- Keep this seed usable against an already-created local draft DB.
CREATE TABLE IF NOT EXISTS `janein` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,
    `text`       VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `nummern` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,
    `text`       VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `dummy_id_referenz` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mandant_id` INT UNSIGNED DEFAULT NULL,
    `dummy_id`   INT UNSIGNED NOT NULL,
    `sort`       INT          NOT NULL DEFAULT 0,
    `text`       VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `prioritaet`  ADD COLUMN IF NOT EXISTS `mandant_id` INT UNSIGNED DEFAULT NULL AFTER `id`;
ALTER TABLE `status`      ADD COLUMN IF NOT EXISTS `mandant_id` INT UNSIGNED DEFAULT NULL AFTER `id`;
ALTER TABLE `anruf_status` ADD COLUMN IF NOT EXISTS `mandant_id` INT UNSIGNED DEFAULT NULL AFTER `id`;
ALTER TABLE `firma`       ADD COLUMN IF NOT EXISTS `mandant_id` INT UNSIGNED DEFAULT NULL AFTER `id`;
ALTER TABLE `grund`       ADD COLUMN IF NOT EXISTS `mandant_id` INT UNSIGNED DEFAULT NULL AFTER `id`;
ALTER TABLE `produkt`     ADD COLUMN IF NOT EXISTS `mandant_id` INT UNSIGNED DEFAULT NULL AFTER `id`;

INSERT INTO `rolle` (`id`, `bezeichnung`) VALUES
    (1, 'Local Admin')
ON DUPLICATE KEY UPDATE
    `bezeichnung` = VALUES(`bezeichnung`);

INSERT INTO `benutzer` (
    `id`, `name`, `nachname`, `vorname`, `email`, `telefon`, `land`, `gruppe`, `sprache`,
    `passwort`, `iptel_durchwahl`, `default_bua_bgr_key`, `default_belegdatum`,
    `letzte_kampagne_id`, `letzter_mandant_id`
) VALUES (
    1, 'admin', 'Admin', 'Local', 'admin@example.test', '+43 1 000000', 'AT', 'admin', 'de',
    'bbbf241ee1ec01bdc83a5f5f646d26d2cfe88c81e3bd7d6310b6174e1603c927',
    '100', NULL, NULL, 1, 1
)
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `email` = VALUES(`email`),
    `sprache` = VALUES(`sprache`),
    `passwort` = VALUES(`passwort`),
    `letzte_kampagne_id` = VALUES(`letzte_kampagne_id`),
    `letzter_mandant_id` = VALUES(`letzter_mandant_id`);

INSERT INTO `mandant` (
    `id`, `mandant`, `text`, `uid`, `land`, `plz`, `ort`, `strasse`, `hausnummer`,
    `telefon`, `email`, `encryption_aktiv`, `encryption_columns_ticket`
) VALUES (
    1, 'local-demo', 'Local Demo Mandant', 'ATU00000000', 'AT', '1010', 'Wien',
    'Demo Strasse', '1', '+43 1 000000', 'office@example.test', 'N', NULL
)
ON DUPLICATE KEY UPDATE
    `mandant` = VALUES(`mandant`),
    `text` = VALUES(`text`),
    `encryption_aktiv` = VALUES(`encryption_aktiv`),
    `encryption_columns_ticket` = VALUES(`encryption_columns_ticket`);

INSERT INTO `mandant_benutzer` (`mandant_id`, `benutzer_id`, `rolle_id`) VALUES
    (1, 1, 1)
ON DUPLICATE KEY UPDATE
    `rolle_id` = VALUES(`rolle_id`);

INSERT INTO `berechtigung` (`id`, `seitenname`, `berechtigung`) VALUES
    (1, 'portal.php', 'ALL'),
    (2, 'kampauswahl.php', 'ALL'),
    (3, 'ticketsuch.php', 'ALL'),
    (4, 'ticketsuch2.php', 'ALL'),
    (5, 'ticket.php', 'ALL'),
    (6, 'ticket2.php', 'ALL'),
    (7, 'ticket_sich.php', 'ALL'),
    (8, 'akt.php', 'ALL'),
    (9, 'menu_verw.php', 'ALL'),
    (10, 'np.php', 'ALL'),
    (11, 'logout.php', 'ALL')
ON DUPLICATE KEY UPDATE
    `seitenname` = VALUES(`seitenname`),
    `berechtigung` = VALUES(`berechtigung`);

INSERT INTO `rolle_berechtigung` (`rolle_id`, `berechtigung_id`) VALUES
    (1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6),
    (1, 7), (1, 8), (1, 9), (1, 10), (1, 11)
ON DUPLICATE KEY UPDATE
    `rolle_id` = VALUES(`rolle_id`);

INSERT INTO `portaltext` (`id`, `sprache`, `text`) VALUES
    (1, 'de', 'Lokale Demo-Daten fuer Entwicklung und Smoke-Tests.')
ON DUPLICATE KEY UPDATE
    `sprache` = VALUES(`sprache`),
    `text` = VALUES(`text`);

INSERT INTO `kampagne` (`id`, `bezeichnung`, `aktiv`, `iptel_auto_vorwahl`, `iptel_destclid`) VALUES
    (1, 'Local Demo Campaign', 1, '', '')
ON DUPLICATE KEY UPDATE
    `bezeichnung` = VALUES(`bezeichnung`),
    `aktiv` = VALUES(`aktiv`);

INSERT INTO `prioritaet` (`id`, `mandant_id`, `text`) VALUES
    (1, 1, 'Normal')
ON DUPLICATE KEY UPDATE
    `mandant_id` = VALUES(`mandant_id`),
    `text` = VALUES(`text`);

INSERT INTO `status` (`id`, `mandant_id`, `text`) VALUES
    (1, 1, 'Offen'),
    (2, 1, 'Erledigt')
ON DUPLICATE KEY UPDATE
    `mandant_id` = VALUES(`mandant_id`),
    `text` = VALUES(`text`);

INSERT INTO `anruf_status` (`id`, `mandant_id`, `text`) VALUES
    (1, 1, 'Nicht angerufen'),
    (2, 1, 'Erreicht')
ON DUPLICATE KEY UPDATE
    `mandant_id` = VALUES(`mandant_id`),
    `text` = VALUES(`text`);

INSERT INTO `firma` (`id`, `mandant_id`, `text`) VALUES
    (1, 1, 'Demo Company GmbH')
ON DUPLICATE KEY UPDATE
    `mandant_id` = VALUES(`mandant_id`),
    `text` = VALUES(`text`);

INSERT INTO `grund` (`id`, `mandant_id`, `text`) VALUES
    (1, 1, 'Demo Forderungsgrund')
ON DUPLICATE KEY UPDATE
    `mandant_id` = VALUES(`mandant_id`),
    `text` = VALUES(`text`);

INSERT INTO `produkt` (`id`, `mandant_id`, `text`) VALUES
    (1, 1, 'Demo Produkt')
ON DUPLICATE KEY UPDATE
    `mandant_id` = VALUES(`mandant_id`),
    `text` = VALUES(`text`);

INSERT INTO `janein` (`id`, `mandant_id`, `text`) VALUES
    (1, 1, 'Ja'),
    (2, 1, 'Nein')
ON DUPLICATE KEY UPDATE
    `mandant_id` = VALUES(`mandant_id`),
    `text` = VALUES(`text`);

INSERT INTO `nummern` (`id`, `mandant_id`, `text`) VALUES
    (1, 1, '0'),
    (2, 1, '1'),
    (3, 1, '2'),
    (4, 1, '3')
ON DUPLICATE KEY UPDATE
    `mandant_id` = VALUES(`mandant_id`),
    `text` = VALUES(`text`);

INSERT INTO `dummy_id_referenz` (`id`, `mandant_id`, `dummy_id`, `sort`, `text`) VALUES
    (1, 1, 1, 10, 'Demo Grund 1'),
    (2, 1, 1, 20, 'Demo Grund 2'),
    (3, 1, 2, 10, 'Demo Auswahl 1'),
    (4, 1, 2, 20, 'Demo Auswahl 2'),
    (5, 1, 3, 10, 'Demo Option 1'),
    (6, 1, 3, 20, 'Demo Option 2'),
    (7, 1, 4, 10, 'Demo Eintrag 1'),
    (8, 1, 4, 20, 'Demo Eintrag 2'),
    (9, 1, 5, 10, 'Demo Wert 1'),
    (10, 1, 5, 20, 'Demo Wert 2')
ON DUPLICATE KEY UPDATE
    `mandant_id` = VALUES(`mandant_id`),
    `dummy_id` = VALUES(`dummy_id`),
    `sort` = VALUES(`sort`),
    `text` = VALUES(`text`);

INSERT INTO `zahlart` (`id`, `text`) VALUES
    (1, 'Ueberweisung'),
    (2, 'Lastschrift')
ON DUPLICATE KEY UPDATE
    `text` = VALUES(`text`);

INSERT INTO `mwst` (`id`, `text`, `satz`) VALUES
    (1, '0%', 0.00),
    (2, '20%', 20.00)
ON DUPLICATE KEY UPDATE
    `text` = VALUES(`text`),
    `satz` = VALUES(`satz`);

INSERT INTO `buchungsart` (`id`, `text`, `buart_key`, `bugru_key`, `bugru_text`) VALUES
    (1, 'Demo Buchungsart', 'DEMO', 'DEMO01', 'Demo Buchungsgrund')
ON DUPLICATE KEY UPDATE
    `text` = VALUES(`text`),
    `buart_key` = VALUES(`buart_key`);

INSERT INTO `buchungsgrund` (
    `id`, `text`, `buchungsart_id`, `bugru_key`, `bugru_key_om`, `buart_text`,
    `kontoauszugstext`, `kz_bearbeitung`, `kz_berechnung`, `kz_manuell`,
    `kz_saldowirksam`, `kz_subkonto`, `kz_zinsberechnung`
) VALUES (
    1, 'Demo Buchungsgrund', 1, 'DEMO01', '0001', 'Demo Buchungsart',
    'Demo Buchung', 'J', 'J', 'J', 'J', 'J', 'N'
)
ON DUPLICATE KEY UPDATE
    `text` = VALUES(`text`),
    `buchungsart_id` = VALUES(`buchungsart_id`),
    `bugru_key` = VALUES(`bugru_key`);

INSERT INTO `bua_bgr_man` (`id`, `mandant_id`, `bugru_id`) VALUES
    (1, 1, 1)
ON DUPLICATE KEY UPDATE
    `mandant_id` = VALUES(`mandant_id`),
    `bugru_id` = VALUES(`bugru_id`);

INSERT INTO `kunde` (
    `id`, `kdnr`, `mandant_id`, `nachname`, `vorname`, `strasse`, `hausnummer`,
    `plz`, `ort`, `telefon`, `email`, `kundenart`, `markt`
) VALUES (
    1, '100001', 1, 'Mustermann', 'Max', 'Demo Strasse', '10',
    '1010', 'Wien', '+43 1 123456', 'max.mustermann@example.test', 'Demo', 'AT'
)
ON DUPLICATE KEY UPDATE
    `kdnr` = VALUES(`kdnr`),
    `mandant_id` = VALUES(`mandant_id`),
    `nachname` = VALUES(`nachname`),
    `vorname` = VALUES(`vorname`);

INSERT INTO `stammdaten` (
    `id`, `kunde_id`, `mandant_id`, `kdnr`, `vorname`, `nachname`, `strasse`,
    `plz`, `ort`, `gesamtsaldo`, `datum_anlage`, `geaendert_am`
) VALUES (
    1, 1, 1, '100001', 'Max', 'Mustermann', 'Demo Strasse 10',
    '1010', 'Wien', 123.45, NOW(), NOW()
)
ON DUPLICATE KEY UPDATE
    `kunde_id` = VALUES(`kunde_id`),
    `mandant_id` = VALUES(`mandant_id`),
    `gesamtsaldo` = VALUES(`gesamtsaldo`);

INSERT INTO `ticket` (
    `id`, `ticketnr`, `mandant_id`, `kampagne_id`, `kunde_id`, `benutzer_id`,
    `kundennummer`, `anrede`, `nachname`, `vorname`, `plz`, `ort`, `strasse`,
    `hausnummer`, `telefon`, `email`, `kenner`, `anruf_status_id`, `ergebnis`,
    `wiedervorlage`, `status_id`, `prioritaet_id`, `beginn`, `beschreibung_detail`,
    `geaendert_am`, `geaendert_von`, `grund_id`, `firma_id`, `produkt_id`
) VALUES (
    1, 100001, 1, 1, 1, 1,
    '100001', 'Herr', 'Mustermann', 'Max', '1010', 'Wien', 'Demo Strasse',
    '10', '+43 1 123456', 'max.mustermann@example.test', 'DEMO', 1, '',
    'N', 1, 1, CURDATE(), 'Lokales Demo-Ticket', NOW(), 'admin', 1, 1, 1
)
ON DUPLICATE KEY UPDATE
    `ticketnr` = VALUES(`ticketnr`),
    `mandant_id` = VALUES(`mandant_id`),
    `kampagne_id` = VALUES(`kampagne_id`),
    `status_id` = VALUES(`status_id`),
    `prioritaet_id` = VALUES(`prioritaet_id`);

INSERT INTO `subkonto_neu` (
    `id`, `sk_lfdnr`, `stammdaten_id`, `rechnungsnummer`, `zahlart_id`, `zinssatz`,
    `eroeffnet_am`, `kaufwert`, `ratenhoehe`, `bua_bgr_man_id`, `buchungsdatum`,
    `buchungsbetrag`, `m4`, `m3`, `m2`, `m1`, `m0`, `rest`, `v1`, `v2`, `v3`, `v4`,
    `saldo`, `geaendert_am`, `kz_aktuell`, `status_id`, `geaendert_von`,
    `belegdatum`, `buchungskennzeichen`, `valutierung`, `kz_gebucht`, `verwendungszweck`
) VALUES (
    1, 1, 1, 'RE-100001', 1, 0.0000,
    NOW(), 123.45, 0.00, 1, CURDATE(),
    123.45, 0, 0, 0, 0, 123.45, 123.45, 0, 0, 0, 0,
    123.45, NOW(), 'J', 1, 'admin',
    CURDATE(), 'S', CURDATE(), 'J', 'Demo Rechnung'
)
ON DUPLICATE KEY UPDATE
    `stammdaten_id` = VALUES(`stammdaten_id`),
    `saldo` = VALUES(`saldo`),
    `kz_aktuell` = VALUES(`kz_aktuell`);

INSERT INTO `buchungen` (
    `id`, `stammdaten_id`, `buchungsdatum`, `valutadatum`, `betrag`,
    `buchungskennzeichen`, `buart_key`, `bua_bgr_man_id`, `herkunft`,
    `kz_gebucht`, `kz_manbuchung`, `mwst_id`, `zahlart_id`, `zahlart_text`,
    `verwendungszweck`, `geaendert_von`
) VALUES (
    1, 1, CURDATE(), CURDATE(), 123.45,
    'S', 'DEMO', 1, 'DEV-SEED',
    'J', 'J', 1, 1, 'Ueberweisung',
    'Demo Rechnung', 'admin'
)
ON DUPLICATE KEY UPDATE
    `stammdaten_id` = VALUES(`stammdaten_id`),
    `betrag` = VALUES(`betrag`),
    `bua_bgr_man_id` = VALUES(`bua_bgr_man_id`);
