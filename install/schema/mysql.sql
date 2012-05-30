-- MySQL

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `societaspro`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_actions`
--

DROP TABLE IF EXISTS `tbl_audit_actions`;
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

DROP TABLE IF EXISTS `tbl_audit_entries`;
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

DROP TABLE IF EXISTS `tbl_blog_posts`;
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

DROP TABLE IF EXISTS `tbl_config`;
CREATE TABLE `tbl_config` (
  `configOption` varchar(50) NOT NULL,
  `configValue` text NOT NULL,
  PRIMARY KEY (`configOption`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_error_logs`
--

DROP TABLE IF EXISTS `tbl_error_logs`;
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

DROP TABLE IF EXISTS `tbl_events`;
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

DROP TABLE IF EXISTS `tbl_locations`;
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

DROP TABLE IF EXISTS `tbl_members`;
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

DROP TABLE IF EXISTS `tbl_members_archives`;
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

DROP TABLE IF EXISTS `tbl_members_data`;
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

DROP TABLE IF EXISTS `tbl_members_fields`;
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

DROP TABLE IF EXISTS `tbl_pages`;
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

DROP TABLE IF EXISTS `tbl_photos`;
CREATE TABLE `tbl_photos` (
  `photoID` int(11) NOT NULL AUTO_INCREMENT,
  `photoCollection` int(11) NOT NULL,
  PRIMARY KEY (`photoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_photo_collections`
--

DROP TABLE IF EXISTS `tbl_photo_collections`;
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

DROP TABLE IF EXISTS `tbl_subscribers`;
CREATE TABLE `tbl_subscribers` (
  `subscriberID` int(11) NOT NULL AUTO_INCREMENT,
  `subscriberEmail` varchar(255) NOT NULL,
  `subscriberIP` varchar(50) NOT NULL,
  `subscriberDate` datetime NOT NULL,
  PRIMARY KEY (`subscriberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_audit_actions`
--

INSERT INTO `tbl_audit_actions` VALUES(1, 'Create member', '{$lang_create} {$lang_member}');
INSERT INTO `tbl_audit_actions` VALUES(2, 'Edit member', '{$lang_edit} {$lang_member}');
INSERT INTO `tbl_audit_actions` VALUES(3, 'Create location', '{$lang_create} {$lang_location}');
INSERT INTO `tbl_audit_actions` VALUES(4, 'Edit location', '{$lang_edit} {$lang_location}');
INSERT INTO `tbl_audit_actions` VALUES(5, 'Create blog post', '{$lang_create} {$lang_blog} {$lang_post}');
INSERT INTO `tbl_audit_actions` VALUES(6, 'Edit blog post', '{$lang_edit} {$lang_blog} {$lang_post}');
INSERT INTO `tbl_audit_actions` VALUES(7, 'Create event', '{$lang_create} {$lang_event}');
INSERT INTO `tbl_audit_actions` VALUES(8, 'Edit event', '{$lang_edit} {$lang_event}');
INSERT INTO `tbl_audit_actions` VALUES(9, 'Create page', '{$lang_create} {$lang_page}');
INSERT INTO `tbl_audit_actions` VALUES(10, 'Edit page', '{$lang_edit} {$lang_page}');
INSERT INTO `tbl_audit_actions` VALUES(11, 'Edit configuration option', '{$lang_edit} {$lang_configuration}');
INSERT INTO `tbl_audit_actions` VALUES(12, 'Export members', '{$lang_export} {$lang_members}');
INSERT INTO `tbl_audit_actions` VALUES(13, 'Export mailing list', '{$lang_export} {$lang_mailing_list}');
INSERT INTO `tbl_audit_actions` VALUES(14, 'Create subscriber', '{$lang_create} {$lang_subscriber}');
INSERT INTO `tbl_audit_actions` VALUES(15, 'Clone event', '{$lang_clone} {$lang_event}');
INSERT INTO `tbl_audit_actions` VALUES(16, 'Clone page', '{$lang_clone} {$lang_page}');
INSERT INTO `tbl_audit_actions` VALUES(17, 'Delete member', '{$lang_delete} {$lang_member}');
INSERT INTO `tbl_audit_actions` VALUES(18, 'Delete blog post', '{$lang_delete} {$lang_blog} {$lang_post}');
INSERT INTO `tbl_audit_actions` VALUES(19, 'Delete page', '{$lang_delete} {$lang_page}');
INSERT INTO `tbl_audit_actions` VALUES(20, 'Delete location', '{$lang_delete} {$lang_location}');
INSERT INTO `tbl_audit_actions` VALUES(21, 'Delete event', '{$lang_delete} {$lang_event}');
INSERT INTO `tbl_audit_actions` VALUES(22, 'Delete subscriber', '{$lang_delete} {$lang_subscriber}');
INSERT INTO `tbl_audit_actions` VALUES(23, 'Create members field', '{$lang_create} {$lang_members} {$lang_field}');
INSERT INTO `tbl_audit_actions` VALUES(24, 'Edit members field', '{$lang_edit} {$lang_members} {$lang_field}');
INSERT INTO `tbl_audit_actions` VALUES(25, 'Delete members field', '{$lang_delete} {$lang_members} {$lang_field}');

--
-- Dumping data for table `tbl_config`
--

INSERT INTO `tbl_config` VALUES('db_version', '1');
INSERT INTO `tbl_config` VALUES('feature_blog', 'on');
INSERT INTO `tbl_config` VALUES('feature_events', 'on');
INSERT INTO `tbl_config` VALUES('feature_mailing_list', 'on');
INSERT INTO `tbl_config` VALUES('feature_members', 'on');
INSERT INTO `tbl_config` VALUES('feature_pages', 'on');
INSERT INTO `tbl_config` VALUES('group_name', 'SocietasPro');
INSERT INTO `tbl_config` VALUES('language', 'en');
INSERT INTO `tbl_config` VALUES('theme', 'default');