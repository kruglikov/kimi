-- Creates the archive database and its dedicated user.
-- The main kimi_et database and sql_kimi_et user are created by docker-compose
-- via MYSQL_DATABASE / MYSQL_USER / MYSQL_PASSWORD environment variables.

CREATE DATABASE IF NOT EXISTS kimi_archiv
    CHARACTER SET utf8
    COLLATE utf8_general_ci;

CREATE USER IF NOT EXISTS 'kimi'@'%' IDENTIFIED BY 'password';
CREATE USER IF NOT EXISTS 'sql_kimi_et'@'localhost' IDENTIFIED BY 'NS889Hs4bhL1aub7HyEH6AjdYpYAlx';
GRANT ALL PRIVILEGES ON kimi_archiv.* TO 'kimi'@'%';
GRANT ALL PRIVILEGES ON kimi_et.*     TO 'kimi'@'%';
GRANT ALL PRIVILEGES ON kimi_et.*     TO 'sql_kimi_et'@'localhost';

FLUSH PRIVILEGES;
