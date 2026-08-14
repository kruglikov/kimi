/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : kimiBatch_tabellen.sql

* Purpose :

* Creation Date : 23-07-2015

* Last Modified : Mon 10 Aug 2015 15:03:57 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

CREATE TABLE IF NOT EXISTS kimiLogActivity (
  id int NOT NULL AUTO_INCREMENT,
  topic varchar(50) DEFAULT NULL,
  activity varchar(100) NOT NULL UNIQUE,
  pos int NOT NULL UNIQUE,
  note text DEFAULT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS kimiLogEntry (
  id int NOT NULL AUTO_INCREMENT,
  logActivityId int NOT NULL,
  logDay date NOT NULL,
  statusId int NOT NULL,
  created timestamp NOT NULL,
  userId int NOT NULL,
  scriptLog text NOT NULL,
  PRIMARY KEY(id),
  INDEX (logActivityId),
  FOREIGN KEY (logActivityId) REFERENCES kimiLogActivity(id)
);

ALTER TABLE `kimiLogEntry` CHANGE `created` `created` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL;
ALTER TABLE `kimiLogEntry` CHANGE `created` `created` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00';
