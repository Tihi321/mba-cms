# Posluzitelj: localhost
# Vrijeme kreacije: 28. srpanj 2006 17:50
# MySQL verzija: 4.1.20
# PHP verzija: 5.0.1
# 
# Baza podataka : prazna2
# 

# --------------------------------------------------------

#
# Struktura tablice `podrucje`
#

DROP DATABASE IF EXISTS `prazna2`;

CREATE DATABASE prazna2;

GRANT ALL PRIVILEGES ON prazna2.* TO admin@localhost IDENTIFIED BY 'admin' WITH GRANT OPTION;

USE prazna2;

DROP TABLE IF EXISTS `podrucje`;

CREATE TABLE podrucje (
  podrucje_id int(11) NOT NULL auto_increment,
  ime varchar(50) NOT NULL default '',
  opis TEXT default NULL,
  PRIMARY KEY  (podrucje_id)
);

DROP TABLE IF EXISTS `cjelina`;

CREATE TABLE `cjelina` (
`cjelina_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`podrucje_id` INT UNSIGNED NOT NULL ,
`ime` VARCHAR( 50 ) NOT NULL ,
`opis` TEXT ,
PRIMARY KEY ( `cjelina_id` )
);

DROP TABLE IF EXISTS `jedinica`;

CREATE TABLE `jedinica` (
`jedinica_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`ime` VARCHAR( 50 ) NOT NULL ,
`opis` TEXT NOT NULL ,
`slika_1` VARCHAR( 50 ) ,
`slika_2` VARCHAR( 50 ) ,
`promidzba_na_razini_homepage` VARCHAR( 1 ) NOT NULL ,
`promidzba_na_razini_podrucja` VARCHAR( 1 ) NOT NULL ,
PRIMARY KEY ( `jedinica_id` )
);

DROP TABLE IF EXISTS `cjelina_jedinica`;

CREATE TABLE `cjelina_jedinica` (
`cjelina_id` INT UNSIGNED NOT NULL ,
`jedinica_id` INT UNSIGNED NOT NULL ,
PRIMARY KEY ( `cjelina_id` , `jedinica_id` )
);

