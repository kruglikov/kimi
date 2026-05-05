-- Scratch tables used by kimibatch check/export scripts.
-- Each script TRUNCATEs these before use, then INSERTs ticket numbers,
-- then JOINs against them for status counting.
-- Schema: single ticketnr column matching ticket.ticketnr (INT UNSIGNED).

USE kimi_et;

-- KNP1 campaign check tables
CREATE TABLE IF NOT EXISTS knp1erledigt           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knp1erreicht           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knp1erreichtap         (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knp1unerreichbar       (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knp1telefonnummerfalsch(ticketnr INT(10) UNSIGNED);

-- KNP3 campaign check tables
CREATE TABLE IF NOT EXISTS knp3erledigt           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knp3erreicht           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knp3erreichtap         (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knp3unerreichbar       (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knp3telefonnummerfalsch(ticketnr INT(10) UNSIGNED);

-- KNPDREI campaign check tables
CREATE TABLE IF NOT EXISTS knpdreierledigt           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knpdreierreicht           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knpdreierreichtap         (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knpdreiunerreichbar       (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS knpdreitelefonnummerfalsch(ticketnr INT(10) UNSIGNED);

-- INKODE campaign check tables
CREATE TABLE IF NOT EXISTS inkodeerledigt           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS inkodeerreicht           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS inkodeerreichtap         (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS inkodeunerreichbar       (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS inkodetelefonnummerfalsch(ticketnr INT(10) UNSIGNED);

-- INKO2016 campaign check tables
CREATE TABLE IF NOT EXISTS inko2016erledigt           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS inko2016erreicht           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS inko2016erreichtap         (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS inko2016unerreichbar       (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS inko2016telefonnummerfalsch(ticketnr INT(10) UNSIGNED);

-- IFS campaign check tables (used by schlaustrom* and quester* scripts)
CREATE TABLE IF NOT EXISTS ifserledigt           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS ifserreicht           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS ifserreichtap         (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS ifsunerreichbar       (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS ifstelefonnummerfalsch(ticketnr INT(10) UNSIGNED);

-- OKO campaign check tables (4 tables: no erreichtap)
CREATE TABLE IF NOT EXISTS okoerledigt           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS okoerreicht           (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS okounerreichbar       (ticketnr INT(10) UNSIGNED);
CREATE TABLE IF NOT EXISTS okotelefonnummerfalsch(ticketnr INT(10) UNSIGNED);