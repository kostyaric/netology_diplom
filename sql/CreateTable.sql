DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS categorys;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS answers;

CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(20) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `categorys`
(
    `ID` INT Not NULL AUTO_INCREMENT,
    `descr` VarChar(60) Not NULL,
    Primary Key (`ID`)
) Engine innoDB DEFAULT Charset=utf8;

CREATE TABLE `questions`
(
    `ID` INT Not NULL AUTO_INCREMENT,
    `qdate` TimeStamp Not NULL,
    `userID` INT Not NULL,
    `categoryID` INT Not NULL,
    `descr` VarChar(255) Not NULL,
    `status` TINYINT Not NULL DEFAULT 0,
    Primary Key (`ID`)
) Engine innoDB DEFAULT Charset=utf8;

CREATE TABLE `answers`
(
    `ID` INT Not NULL AUTO_INCREMENT,
    `questionID` INT Not NULL,
    `adate` TimeStamp Not NULL,
    `descr` VarChar(255) Not NULL,
    Primary Key (`ID`)
) Engine innoDB DEFAULT Charset=utf8;


