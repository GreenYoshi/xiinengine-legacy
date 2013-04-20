<?php

function getSqlDump($installVars,$userPassword) {
    
return '

-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Skapad: 14 mars 2013 kl 07:37
-- Serverversion: 5.5.27
-- PHP-version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `xe1`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `XE_NCategories`
--

DROP TABLE IF EXISTS `XE_NCategories`;
CREATE TABLE IF NOT EXISTS `XE_NCategories` (
  `NCatID` int(11) NOT NULL AUTO_INCREMENT,
  `NCatName` varchar(50) NOT NULL,
  `NCatPretty` varchar(50) NOT NULL,
  `NCatColor` varchar(8) NOT NULL,
  PRIMARY KEY (`NCatID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `XE_NComments`
--

DROP TABLE IF EXISTS `XE_NComments`;
CREATE TABLE IF NOT EXISTS `XE_NComments` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `NewsID` int(11) NOT NULL,
  `PPLID` int(11) DEFAULT NULL,
  `CommentDate` datetime NOT NULL,
  `CommentContent` mediumtext NOT NULL,
  `CommentReplyID` int(11) DEFAULT NULL,
  `CommentGuestName` varchar(50) DEFAULT NULL,
  `CommentGuestEmail` varchar(50) DEFAULT NULL,
  `CommentGuestIP` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CommentID`),
  KEY `PPLID` (`PPLID`),
  KEY `NewsID` (`NewsID`),
  FULLTEXT KEY `CommentContent` (`CommentContent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `XE_News`
--

DROP TABLE IF EXISTS `XE_News`;
CREATE TABLE IF NOT EXISTS `XE_News` (
  `NewsID` int(11) NOT NULL AUTO_INCREMENT,
  `NewsTitle` varchar(50) NOT NULL,
  `NewsPretty` varchar(50) NOT NULL,
  `NewsDate` datetime NOT NULL,
  `NewsBanner` varchar(255) DEFAULT NULL,
  `NewsContent` longtext NOT NULL,
  `NewsHighlight` tinyint(1) NOT NULL,
  `NewsPublished` tinyint(1) NOT NULL,
  `NewsSource` varchar(255) DEFAULT NULL,
  `NewsTags` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`NewsID`),
  FULLTEXT KEY `NewsContent` (`NewsContent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `XE_News_Author`
--

DROP TABLE IF EXISTS `XE_News_Author`;
CREATE TABLE IF NOT EXISTS `XE_News_Author` (
  `NewsID` int(11) NOT NULL,
  `PPLID` int(11) NOT NULL,
  KEY `NewsID` (`NewsID`),
  KEY `PPLID` (`PPLID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `XE_News_Categories`
--

DROP TABLE IF EXISTS `XE_News_Categories`;
CREATE TABLE IF NOT EXISTS `XE_News_Categories` (
  `NewsID` int(11) NOT NULL,
  `NCatID` int(11) NOT NULL,
  KEY `NewsID` (`NewsID`),
  KEY `NCatID` (`NCatID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `XE_Permissions`
--

DROP TABLE IF EXISTS `XE_Permissions`;
CREATE TABLE IF NOT EXISTS `XE_Permissions` (
  `PermID` int(11) NOT NULL AUTO_INCREMENT,
  `PermAccessName` varchar(32) NOT NULL,
  `PermHexColor` varchar(8) NOT NULL,
  PRIMARY KEY (`PermID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

INSERT INTO `XE_Permissions` (`PermID`, `PermAccessName`, `PermHexColor`) VALUES (1, "ROOT", "#000000");
INSERT INTO `XE_Permissions` (`PermID`, `PermAccessName`, `PermHexColor`) VALUES (2, "Administrator", "#000000");


-- --------------------------------------------------------

--
-- Tabellstruktur `XE_Pages`
--

DROP TABLE IF EXISTS `XE_Pages`;
CREATE TABLE IF NOT EXISTS `XE_Pages` (
  `PageID` int(11) NOT NULL AUTO_INCREMENT,
  `PageTitle` varchar(50) NOT NULL,
  `PagePretty` varchar(50) NOT NULL,
  `PageDate` datetime NOT NULL,
  `PageBanner` varchar(255) DEFAULT NULL,
  `PageContent` longtext NOT NULL,
  `PageHeaderNav` tinyint(1) NOT NULL,
  `PageFooterNav` tinyint(1) NOT NULL,
  `PagePublished` tinyint(1) NOT NULL,
  `PageTags` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PageID`),
  FULLTEXT KEY `PageContent` (`PageContent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `XE_PPL`
--

DROP TABLE IF EXISTS `XE_PPL`;
CREATE TABLE IF NOT EXISTS `XE_PPL` (
  `PPLID` int(11) NOT NULL AUTO_INCREMENT,
  `PPLAlias` varchar(20) NOT NULL,
  `PPLEmail` varchar(50) NOT NULL,
  `PPLPretty` varchar(50) NOT NULL,
  `PPLTitle` varchar(30) DEFAULT NULL,
  `PPLFName` varchar(20) DEFAULT NULL,
  `PPLSName` varchar(50) DEFAULT NULL,
  `PPLIconURL` varchar(100) NOT NULL,
  `PPLBio` mediumtext,
  `PPLURL` varchar(30) DEFAULT NULL,
  `PPLPass` varchar(255) NOT NULL,
  `PPLRememberPassKey` varchar(255) NOT NULL,
  `PPLLastLogin` datetime NOT NULL,
  `PPLLastIP` varchar(15) NOT NULL,
  `PPLSecurityQuestion` varchar(255) NOT NULL,
  `PPLSecurityAnswer` varchar(255) NOT NULL,
  `PPLCreationDate` datetime NOT NULL,
  `PPLBanDate` datetime DEFAULT NULL,
  PRIMARY KEY (`PPLID`),
  FULLTEXT KEY `PPLBio` (`PPLBio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- The password generated is "xiinengine" with the default salts ("Changeme1", "Changeme2")
INSERT INTO  `XE_PPL` (
`PPLID` ,
`PPLAlias` ,
`PPLEmail` ,
`PPLPretty` ,
`PPLTitle` ,
`PPLFName` ,
`PPLSName` ,
`PPLIconURL` ,
`PPLBio` ,
`PPLURL` ,
`PPLPass` ,
`PPLRememberPassKey` ,
`PPLLastLogin` ,
`PPLLastIP` ,
`PPLSecurityQuestion` ,
`PPLSecurityAnswer` ,
`PPLCreationDate` ,
`PPLBanDate`
)
VALUES (
"1",  "ROOTMAN",  "root@sandbox.xiinet.com",  "ROOTMAN", NULL , NULL , NULL ,  "http://dummyimage.com/100x100/000/fff", NULL , NULL , "'.$userPassword.'",  "",  "1970-01-01 00:00:00", "127.0.0.1",  "none",  "none", NOW( ) , NULL
);

-- --------------------------------------------------------

--
-- Tabellstruktur `XE_PPL_Permissions`
--

DROP TABLE IF EXISTS `XE_PPL_Permissions`;
CREATE TABLE IF NOT EXISTS `XE_PPL_Permissions` (
  `PPLID` int(11) NOT NULL,
  `PermID` int(11) NOT NULL,
  KEY `PPLID` (`PPLID`),
  KEY `PermID` (`PermID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `XE_PPL_Permissions` (`PPLID`, `PermID`) VALUES (1, 1);
INSERT INTO `XE_PPL_Permissions` (`PPLID`, `PermID`) VALUES (1, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `XE_Switchboard`
--

DROP TABLE IF EXISTS `XE_Switchboard`;
CREATE TABLE IF NOT EXISTS `XE_Switchboard` (
  `SwitchID` int(11) NOT NULL AUTO_INCREMENT,
  `SwitchName` varchar(50) NOT NULL,
  `SwitchValue` varchar(150) NOT NULL,
  PRIMARY KEY (`SwitchID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `XE_Switchboard` (`SwitchID`, `SwitchName`, `SwitchValue`) VALUES (1, "public_enabled", "0");
INSERT INTO `XE_Switchboard` (`SwitchID`, `SwitchName`, `SwitchValue`) VALUES (2, "public_closed_message", "");
INSERT INTO `XE_Switchboard` (`SwitchID`, `SwitchName`, `SwitchValue`) VALUES (3, "public_announcement_enabled", "0");
INSERT INTO `XE_Switchboard` (`SwitchID`, `SwitchName`, `SwitchValue`) VALUES (4, "public_announcement", "");
INSERT INTO `XE_Switchboard` (`SwitchID`, `SwitchName`, `SwitchValue`) VALUES (5, "site_name", "'.$installVars['XE_SITE_NAME'].'");
INSERT INTO `XE_Switchboard` (`SwitchID`, `SwitchName`, `SwitchValue`) VALUES (6, "site_description", "'.$installVars['XE_SITE_DESCRIPTION'].'");
INSERT INTO `XE_Switchboard` (`SwitchID`, `SwitchName`, `SwitchValue`) VALUES (7, "public_site_tags", "xiin, networks, engine, xiin engine, cms");
INSERT INTO `XE_Switchboard` (`SwitchID`, `SwitchName`, `SwitchValue`) VALUES (8, "public_site_theme", "'.$installVars['XE_THEME_SELECT'].'");
-- INSERT INTO `XE_Switchboard` (`SwitchID`, `SwitchName`, `SwitchValue`) VALUES (9, "base_site_url", "http://sandbox.xiinet.com/");
-- INSERT INTO `XE_Switchboard` (`SwitchID`, `SwitchName`, `SwitchValue`) VALUES (10, "base_site_url_offset", "xe1/");

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
';
}
?>
