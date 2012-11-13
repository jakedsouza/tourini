-- MySQL dump 10.13  Distrib 5.5.15, for Win32 (x86)
--
-- Host: localhost    Database: project
-- ------------------------------------------------------
-- Server version	5.1.59-community

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `project`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `project` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `project`;

--
-- Table structure for table `circle_list`
--

DROP TABLE IF EXISTS `circle_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `circle_list` (
  `circleid` int(11) NOT NULL AUTO_INCREMENT,
  `circlename` varchar(45) NOT NULL,
  PRIMARY KEY (`circleid`,`circlename`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circle_list`
--

LOCK TABLES `circle_list` WRITE;
/*!40000 ALTER TABLE `circle_list` DISABLE KEYS */;
INSERT INTO `circle_list` VALUES (1,'private'),(2,'public'),(20,'family');
/*!40000 ALTER TABLE `circle_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendship`
--

DROP TABLE IF EXISTS `friendship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendship` (
  `from_name` varchar(45) NOT NULL,
  `to_name` varchar(45) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `isaccepted` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`from_name`,`to_name`),
  KEY `from` (`from_name`),
  KEY `to` (`to_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendship`
--

LOCK TABLES `friendship` WRITE;
/*!40000 ALTER TABLE `friendship` DISABLE KEYS */;
/*!40000 ALTER TABLE `friendship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendship_request`
--

DROP TABLE IF EXISTS `friendship_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendship_request` (
  `from_name` varchar(45) NOT NULL,
  `to_name` varchar(45) NOT NULL,
  `isaccepted` tinyint(4) DEFAULT '0',
  `date_requested` timestamp NULL DEFAULT NULL,
  `date_accepted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`from_name`,`to_name`),
  KEY `friend_request_from` (`from_name`),
  KEY `friend_request_to` (`to_name`),
  CONSTRAINT `friend_request_from` FOREIGN KEY (`from_name`) REFERENCES `users` (`uname`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `friend_request_to` FOREIGN KEY (`to_name`) REFERENCES `users` (`uname`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendship_request`
--

LOCK TABLES `friendship_request` WRITE;
/*!40000 ALTER TABLE `friendship_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `friendship_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location_info`
--

DROP TABLE IF EXISTS `location_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location_info` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `longitude` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `address` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location_info`
--

LOCK TABLES `location_info` WRITE;
/*!40000 ALTER TABLE `location_info` DISABLE KEYS */;
INSERT INTO `location_info` VALUES (16,' 11.07238540000003','52.21588089999999','Autobahn, 39365 Harbke, Germany'),(17,' -73.8299958','40.6900311','95-50 115th St, Queens, NY 11419, USA'),(18,' -154.4930619','63.588753','Alaska, USA'),(19,' 77.17977960000007','31.0886523','Shimla, Himachal Pradesh, India');
/*!40000 ALTER TABLE `location_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `uname` varchar(45) NOT NULL,
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `time_upload` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `caption` varchar(45) DEFAULT NULL,
  `post` varchar(140) DEFAULT NULL,
  `lid` int(11) DEFAULT NULL,
  PRIMARY KEY (`mid`,`uname`),
  KEY `uuname` (`uname`),
  CONSTRAINT `uuname` FOREIGN KEY (`uname`) REFERENCES `users` (`uname`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES ('jake',79,'2012-05-20 13:13:52','this is the first private message','this is a private message',17),('jake',80,'2012-05-20 22:09:16','this is the second private message','second message from alaska',18);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_privacy`
--

DROP TABLE IF EXISTS `message_privacy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_privacy` (
  `mid` int(11) NOT NULL,
  `circleid` int(11) NOT NULL,
  PRIMARY KEY (`mid`,`circleid`),
  KEY `mid` (`mid`),
  KEY `ccid` (`circleid`),
  CONSTRAINT `mid` FOREIGN KEY (`mid`) REFERENCES `message` (`mid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_privacy`
--

LOCK TABLES `message_privacy` WRITE;
/*!40000 ALTER TABLE `message_privacy` DISABLE KEYS */;
INSERT INTO `message_privacy` VALUES (79,1),(80,1);
/*!40000 ALTER TABLE `message_privacy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo_privacy`
--

DROP TABLE IF EXISTS `photo_privacy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo_privacy` (
  `pid` int(11) NOT NULL,
  `circleid` int(11) NOT NULL,
  PRIMARY KEY (`pid`,`circleid`),
  KEY `pid` (`pid`),
  KEY `cid` (`circleid`),
  CONSTRAINT `cid` FOREIGN KEY (`circleid`) REFERENCES `circle_list` (`circleid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `pid` FOREIGN KEY (`pid`) REFERENCES `photos` (`pid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo_privacy`
--

LOCK TABLES `photo_privacy` WRITE;
/*!40000 ALTER TABLE `photo_privacy` DISABLE KEYS */;
INSERT INTO `photo_privacy` VALUES (12,1),(13,1),(14,1);
/*!40000 ALTER TABLE `photo_privacy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(45) NOT NULL,
  `pname` varchar(45) DEFAULT NULL,
  `timetaken` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `timeuploaded` timestamp NULL DEFAULT NULL,
  `caption` varchar(140) DEFAULT NULL,
  `photo` varchar(45) DEFAULT NULL,
  `lid` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`,`uname`),
  KEY `uname` (`uname`),
  KEY `photolid` (`lid`),
  CONSTRAINT `photolid` FOREIGN KEY (`lid`) REFERENCES `location_info` (`lid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `uname` FOREIGN KEY (`uname`) REFERENCES `users` (`uname`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
INSERT INTO `photos` VALUES (12,'jake','only people in private must see this','2012-05-20 12:43:58','2012-05-20 12:43:58','This is the first picture shared with circle private','../images/userphotos/1',16),(13,'jake','second uploaded photo only shared in private','2012-05-20 12:47:16','2012-05-20 12:47:16','second uploaded photo only shared in private','../images/userphotos/13',17),(14,'jake','lake','2012-05-20 22:12:02','2012-05-20 22:12:02','third private photo','../images/userphotos/14',19);
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_circles`
--

DROP TABLE IF EXISTS `user_circles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_circles` (
  `uname` varchar(45) NOT NULL,
  `frienduname` varchar(45) NOT NULL,
  `circleid` int(11) NOT NULL,
  PRIMARY KEY (`uname`,`frienduname`,`circleid`),
  KEY `unname` (`uname`),
  KEY `circleid` (`circleid`),
  KEY `funame` (`frienduname`),
  CONSTRAINT `circleid` FOREIGN KEY (`circleid`) REFERENCES `circle_list` (`circleid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `funame` FOREIGN KEY (`frienduname`) REFERENCES `users` (`uname`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `unname` FOREIGN KEY (`uname`) REFERENCES `users` (`uname`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_circles`
--

LOCK TABLES `user_circles` WRITE;
/*!40000 ALTER TABLE `user_circles` DISABLE KEYS */;
INSERT INTO `user_circles` VALUES ('jake','jake',1),('mihir','mihir',1),('jake','jake',2),('mihir','mihir',2),('jake','jake',20);
/*!40000 ALTER TABLE `user_circles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_location`
--

DROP TABLE IF EXISTS `user_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_location` (
  `ulid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(45) DEFAULT NULL,
  `lid` int(11) DEFAULT NULL,
  `dateupdated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ulid`),
  KEY `uloc_lid` (`lid`),
  KEY `uloc_uname` (`uname`),
  CONSTRAINT `uloc_lid` FOREIGN KEY (`lid`) REFERENCES `user_location` (`lid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `uloc_uname` FOREIGN KEY (`uname`) REFERENCES `users` (`uname`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_location`
--

LOCK TABLES `user_location` WRITE;
/*!40000 ALTER TABLE `user_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_location_privacy`
--

DROP TABLE IF EXISTS `user_location_privacy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_location_privacy` (
  `ulid` int(11) NOT NULL,
  `circleid` int(11) NOT NULL,
  PRIMARY KEY (`ulid`,`circleid`),
  KEY `uloc_privacy_ulid` (`ulid`),
  KEY `uloc_privacy_circleid` (`circleid`),
  CONSTRAINT `uloc_privacy_circleid` FOREIGN KEY (`circleid`) REFERENCES `circle_list` (`circleid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `uloc_privacy_ulid` FOREIGN KEY (`ulid`) REFERENCES `user_location` (`ulid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_location_privacy`
--

LOCK TABLES `user_location_privacy` WRITE;
/*!40000 ALTER TABLE `user_location_privacy` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_location_privacy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uname` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `usertype` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `middlename` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `isActiveuser` tinyint(4) DEFAULT NULL,
  `ucreate_date` timestamp NULL DEFAULT NULL,
  `lastlogin_date` timestamp NULL DEFAULT NULL,
  `about` longtext,
  PRIMARY KEY (`uname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('jake','b858cb282617fb0956d960215c8e84d1ccf909c6','normal','jake','','','','jakedsouza88@gmail.com',1,'2012-05-20 12:36:55','2012-05-20 12:36:55',''),('mihir','b858cb282617fb0956d960215c8e84d1ccf909c6','normal','mihir','','','','mvalot01@students.poly.edu',1,'2012-05-21 10:34:27','2012-05-21 10:34:27','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-05-21  7:01:17
