-- MySQL

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `societaspro`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_actions`
--

CREATE TABLE `tbl_audit_actions` (
  `actionID` int(11) NOT NULL AUTO_INCREMENT,
  `actionName` varchar(50) NOT NULL,
  `actionLocalised` varchar(50) NOT NULL,
  PRIMARY KEY (`actionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_entries`
--

CREATE TABLE `tbl_audit_entries` (
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

CREATE TABLE `tbl_blog_posts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `postName` varchar(255) NOT NULL,
  `postSlug` varchar(255) NOT NULL,
  `postStatus` enum('Published','Draft') NOT NULL DEFAULT 'Published',
  `postContent` text NOT NULL,
  `postDate` datetime NOT NULL,
  PRIMARY KEY (`postID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_config`
--

CREATE TABLE `tbl_config` (
  `configOption` varchar(50) NOT NULL,
  `configValue` text NOT NULL,
  PRIMARY KEY (`configOption`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_error_logs`
--

CREATE TABLE `tbl_error_logs` (
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

CREATE TABLE `tbl_events` (
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

CREATE TABLE `tbl_locations` (
  `locationID` int(11) NOT NULL AUTO_INCREMENT,
  `locationName` varchar(25) NOT NULL,
  `locationDescription` text NOT NULL,
  PRIMARY KEY (`locationID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_members`
--

CREATE TABLE `tbl_members` (
  `memberID` int(11) NOT NULL AUTO_INCREMENT,
  `memberEmail` varchar(255) NOT NULL,
  `memberPassword` varchar(50) NOT NULL,
  `memberPasswordResetKey` varchar(12) NOT NULL,
  `memberForename` varchar(50) NOT NULL,
  `memberSurname` varchar(50) NOT NULL,
  `memberPrivileges` tinyint(1) NOT NULL DEFAULT '1',
  `memberAdminStyle` tinyint(1) NOT NULL DEFAULT '0',
  `memberAddress` text NOT NULL,
  `memberNotes` text NOT NULL,
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_members_archives`
--

CREATE TABLE `tbl_members_archives` (
  `memberID` int(11) NOT NULL,
  `memberEmail` varchar(255) NOT NULL,
  `memberForename` varchar(50) NOT NULL,
  `memberSurname` varchar(50) NOT NULL,
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_members_data`
--

CREATE TABLE `tbl_members_data` (
  `dataMember` int(11) NOT NULL,
  `dataField` int(11) NOT NULL,
  `dataValue` text NOT NULL,
  PRIMARY KEY (`dataMember`,`dataField`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_members_fields`
--

CREATE TABLE `tbl_members_fields` (
  `fieldID` int(11) NOT NULL AUTO_INCREMENT,
  `fieldName` varchar(50) NOT NULL,
  `fieldType` varchar(50) NOT NULL DEFAULT 'input',
  `fieldOptions` text NOT NULL,
  PRIMARY KEY (`fieldID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pages`
--

CREATE TABLE `tbl_pages` (
  `pageID` int(11) NOT NULL AUTO_INCREMENT,
  `pageParent` int(11) NOT NULL DEFAULT '0',
  `pageOrder` int(11) NOT NULL DEFAULT '0',
  `pageStatus` enum('Published','Draft') NOT NULL DEFAULT 'Published',
  `pageName` varchar(255) NOT NULL,
  `pageDescription` varchar(255) NOT NULL,
  `pageSlug` varchar(255) NOT NULL,
  `pageContent` text NOT NULL,
  PRIMARY KEY (`pageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_photos`
--

CREATE TABLE `tbl_photos` (
  `photoID` int(11) NOT NULL AUTO_INCREMENT,
  `photoCollection` int(11) NOT NULL,
  PRIMARY KEY (`photoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_photo_collections`
--

CREATE TABLE `tbl_photo_collections` (
  `collectionID` int(11) NOT NULL AUTO_INCREMENT,
  `collectionName` varchar(50) NOT NULL,
  `collectionCreated` date NOT NULL,
  PRIMARY KEY (`collectionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscribers`
--

CREATE TABLE `tbl_subscribers` (
  `subscriberID` int(11) NOT NULL AUTO_INCREMENT,
  `subscriberEmail` varchar(255) NOT NULL,
  `subscriberIP` varchar(50) NOT NULL,
  `subscriberDate` datetime NOT NULL,
  PRIMARY KEY (`subscriberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
