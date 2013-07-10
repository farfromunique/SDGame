
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `Characters`
--

-- --------------------------------------------------------

--
-- Table structure for table `Character_Details`
--

CREATE TABLE IF NOT EXISTS `Character_Details` (
  `UID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'UniqueID',
  `Name` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'Character''s Name',
  `Age` int(11) NOT NULL COMMENT 'Character''s apparent age (waking)',
  `Gender` set('M','F','Other') CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'Character''s apparent gender (waking)',
  `Rank` int(11) NOT NULL DEFAULT '1' COMMENT 'Character''s Rank',
  `Height` int(11) NOT NULL COMMENT 'Character''s height (in centimeters) (waking)',
  `Height_Category` set('very short','short','average height','tall','very tall','Monstrous') CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'Character''s height category (waking)',
  `Skin` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'Character''s skin color and description (waking)',
  `Eyes` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'Character''s eye color and description (waking)',
  `Hair` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'Character''s hair color and description (waking)',
  `Distinguishing_Marks` text CHARACTER SET ascii COLLATE ascii_bin COMMENT 'Description of any distinguishing features (waking)',
  `Ch_Age` int(11) DEFAULT NULL COMMENT 'Character''s apparent age (dreaming)',
  `Ch_Gender` set('M','F','Other') CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL COMMENT 'Character''s apparent gender (dreaming)',
  `Ch_Height` int(11) DEFAULT NULL COMMENT 'Character''s height (in centimeters) (dreaming)',
  `Ch_Height_Category` set('Very Short','Short','Average','Tall','Very Tall','Monstrous') CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL COMMENT 'Character''s height category (dreaming)',
  `Ch_Skin` text CHARACTER SET ascii COLLATE ascii_bin COMMENT 'Character''s skin color and description (dreaming)',
  `Ch_Eyes` text CHARACTER SET ascii COLLATE ascii_bin COMMENT 'Character''s eye color and description (dreaming)',
  `Ch_Hair` text CHARACTER SET ascii COLLATE ascii_bin COMMENT 'Character''s hair color and description (dreaming)',
  `Ch_Distinguishing_Marks` text CHARACTER SET ascii COLLATE ascii_bin COMMENT 'Description of any distinguishing features (dreaming)',
  `Current_Location_W` int(11) NOT NULL DEFAULT '1' COMMENT 'Character''s current location in the real-world',
  `XP_Total` int(11) NOT NULL DEFAULT '1' COMMENT 'Amount of XP Total',
  `XP_Current` int(11) NOT NULL COMMENT 'Amount of XP Currently Possessed',
  PRIMARY KEY (`UID`),
  UNIQUE KEY `UID` (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `Conversations`
--

CREATE TABLE IF NOT EXISTS `Conversations` (
  `UID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'UniqueID',
  `Location` int(11) NOT NULL COMMENT 'UID of Location',
  `TDS` datetime NOT NULL COMMENT 'Time Date Stamp',
  `Comment` blob NOT NULL COMMENT 'What was said',
  `Char_num` int(11) NOT NULL COMMENT 'UID of Character',
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=105 ;

-- --------------------------------------------------------

--
-- Table structure for table `Conversations_bkup`
--

CREATE TABLE IF NOT EXISTS `Conversations_bkup` (
  `UID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'UniqueID',
  `Location` int(11) NOT NULL COMMENT 'UID of Location',
  `TDS` datetime NOT NULL COMMENT 'Time Date Stamp',
  `Comment` blob NOT NULL COMMENT 'What was said',
  `Char_num` int(11) NOT NULL COMMENT 'UID of Character',
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=ascii AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Locations`
--

CREATE TABLE IF NOT EXISTS `Locations` (
  `UID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'UniqueID',
  `LocationName_W` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'Location Name (waking)',
  `LocationName_D` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'Location Name (dreaming)',
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `Logins`
--

CREATE TABLE IF NOT EXISTS `Logins` (
  `UID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'UniqueID',
  `LoginName` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `Password` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `CharUID` bigint(20) NOT NULL COMMENT 'CharacterUID',
  `LastLogin` date NOT NULL,
  `TimeZone` text COMMENT 'Name of the timezone the person wants to see their times in.',
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=70 ;

-- --------------------------------------------------------

--
-- Table structure for table `Powers`
--

CREATE TABLE IF NOT EXISTS `Powers` (
  `UID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'UniqueID',
  `Power` text NOT NULL COMMENT 'Name of base Power',
  `AddonType` set('Base','Desc','Choice','Positive','Negative') NOT NULL COMMENT 'Type of Power Addon (Base, Desc, Positive, Negative)',
  `Name` text NOT NULL COMMENT 'Short description of the Power',
  `Description` blob NOT NULL COMMENT 'Long description of the Power',
  `XP_Cost` int(11) NOT NULL COMMENT 'XP Cost of the Power',
  `Requires_Specifics` tinyint(1) NOT NULL COMMENT 'Does this power require specifics?',
  `Requires_Other_Power` int(11) DEFAULT NULL COMMENT 'UID of Prerequisite Power',
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii COMMENT='Definitions of Powers' AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Table structure for table `PowersLink`
--

CREATE TABLE IF NOT EXISTS `PowersLink` (
  `UID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'UniqueID of Character->Power Link',
  `CharUID` int(11) NOT NULL COMMENT 'UID of Character',
  `PowerUID` int(11) NOT NULL COMMENT 'UID of Power',
  `PowerSpecifics` text NOT NULL COMMENT 'Specificy details about the power',
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii COMMENT='Link Table of who has which power(s)' AUTO_INCREMENT=7 ;
