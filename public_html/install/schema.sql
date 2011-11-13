-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 13, 2011 at 04:07 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `societaspro`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_actions`
--

DROP TABLE IF EXISTS `tbl_audit_actions`;
CREATE TABLE IF NOT EXISTS `tbl_audit_actions` (
  `actionID` int(11) NOT NULL AUTO_INCREMENT,
  `actionName` varchar(50) NOT NULL,
  `actionLocalised` varchar(50) NOT NULL,
  PRIMARY KEY (`actionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_entries`
--

DROP TABLE IF EXISTS `tbl_audit_entries`;
CREATE TABLE IF NOT EXISTS `tbl_audit_entries` (
  `entryID` int(11) NOT NULL AUTO_INCREMENT,
  `entryAction` int(11) NOT NULL,
  `entryMember` int(11) NOT NULL DEFAULT '0',
  `entryDate` datetime NOT NULL,
  `entryOldData` text NOT NULL,
  `entryNewData` text NOT NULL,
  PRIMARY KEY (`entryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_posts`
--

DROP TABLE IF EXISTS `tbl_blog_posts`;
CREATE TABLE IF NOT EXISTS `tbl_blog_posts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `postName` varchar(255) NOT NULL,
  `postSlug` varchar(255) NOT NULL,
  `postContent` text NOT NULL,
  `postDate` datetime NOT NULL,
  PRIMARY KEY (`postID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_config`
--

DROP TABLE IF EXISTS `tbl_config`;
CREATE TABLE IF NOT EXISTS `tbl_config` (
  `configOption` varchar(50) NOT NULL,
  `configValue` text NOT NULL,
  PRIMARY KEY (`configOption`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_error_logs`
--

DROP TABLE IF EXISTS `tbl_error_logs`;
CREATE TABLE IF NOT EXISTS `tbl_error_logs` (
  `logID` int(11) NOT NULL AUTO_INCREMENT,
  `logCode` smallint(5) NOT NULL,
  `logURL` varchar(255) NOT NULL,
  `logDate` datetime NOT NULL,
  `logDetails` varchar(255) NOT NULL,
  `logSQL` varchar(255) NOT NULL,
  PRIMARY KEY (`logID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

DROP TABLE IF EXISTS `tbl_events`;
CREATE TABLE IF NOT EXISTS `tbl_events` (
  `eventID` int(11) NOT NULL AUTO_INCREMENT,
  `eventName` varchar(255) NOT NULL,
  `eventLocation` int(11) NOT NULL DEFAULT '0',
  `eventDate` datetime NOT NULL,
  `eventDescription` text NOT NULL,
  PRIMARY KEY (`eventID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_locations`
--

DROP TABLE IF EXISTS `tbl_locations`;
CREATE TABLE IF NOT EXISTS `tbl_locations` (
  `locationID` int(11) NOT NULL AUTO_INCREMENT,
  `locationName` varchar(25) NOT NULL,
  `locationDescription` text NOT NULL,
  PRIMARY KEY (`locationID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_members`
--

DROP TABLE IF EXISTS `tbl_members`;
CREATE TABLE IF NOT EXISTS `tbl_members` (
  `memberID` int(11) NOT NULL AUTO_INCREMENT,
  `memberEmail` varchar(255) NOT NULL,
  `memberPassword` varchar(255) NOT NULL,
  `memberForename` varchar(255) NOT NULL,
  `memberSurname` varchar(255) NOT NULL,
  `memberPrivileges` tinyint(1) NOT NULL DEFAULT '1',
  `memberAddress` text NOT NULL,
  `memberNotes` text NOT NULL,
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_members_fields`
--

DROP TABLE IF EXISTS `tbl_members_fields`;
CREATE TABLE IF NOT EXISTS `tbl_members_fields` (
  `fieldID` int(11) NOT NULL AUTO_INCREMENT,
  `fieldName` varchar(255) NOT NULL,
  PRIMARY KEY (`fieldID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pages`
--

DROP TABLE IF EXISTS `tbl_pages`;
CREATE TABLE IF NOT EXISTS `tbl_pages` (
  `pageID` int(11) NOT NULL AUTO_INCREMENT,
  `pageParent` int(11) NOT NULL DEFAULT '0',
  `pageOrder` int(11) NOT NULL DEFAULT '0',
  `pageName` varchar(255) NOT NULL,
  `pageSlug` varchar(255) NOT NULL,
  `pageContent` text NOT NULL,
  PRIMARY KEY (`pageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscribers`
--

DROP TABLE IF EXISTS `tbl_subscribers`;
CREATE TABLE IF NOT EXISTS `tbl_subscribers` (
  `subscriberID` int(11) NOT NULL AUTO_INCREMENT,
  `subscriberEmail` varchar(255) NOT NULL,
  `subscriberIP` varchar(50) NOT NULL,
  `subscriberDate` datetime NOT NULL,
  PRIMARY KEY (`subscriberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
