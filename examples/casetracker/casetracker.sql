-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: casetracker
-- ------------------------------------------------------
-- Server version	10.1.26-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `casetracker`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `casetracker` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `casetracker`;

--
-- Table structure for table `clientcases`
--

DROP TABLE IF EXISTS `clientcases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientcases` (
  `id` mediumint(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `anumber` varchar(32) NOT NULL,
  `clientname` varchar(128) NOT NULL,
  `casetype` varchar(32) NOT NULL,
  `oneyrdl` date DEFAULT NULL,
  `workperm` date DEFAULT NULL,
  `filed` date DEFAULT NULL,
  `approved` date DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  `supportdocs` date DEFAULT NULL,
  `hearingtype` varchar(32) NOT NULL,
  `hearing` datetime DEFAULT NULL,
  `locationtype` varchar(32) NOT NULL,
  `judgename` varchar(128) NOT NULL,
  `attorneyid` smallint(4) unsigned zerofill NOT NULL,
  `decisiontype` varchar(32) NOT NULL,
  `decision` date DEFAULT NULL,
  `appealtype` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientcases`
--

LOCK TABLES `clientcases` WRITE;
/*!40000 ALTER TABLE `clientcases` DISABLE KEYS */;
INSERT INTO `clientcases` VALUES 
(000014,'999-999-999','Jane Doe','i360','0000-00-00','2019-03-05','0000-00-00','0000-00-00','0000-00-00','2018-12-31','master','1998-06-29 17:00:00','denver','',0035,'','0000-00-00',''),
(000018,'123-456-898','Juan Perez','eoir42b','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','master','2008-12-31 17:00:00','aurora','',0033,'','0000-00-00',''),
(000019,'012-345-678','Jon Doe','eoir42b;i360;aos','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','master','1976-12-31 17:00:00','aurora','',0035,'','0000-00-00',''),
(000020,'012-345-678','Juana Perez','eoir42b','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','2019-03-07','master','2019-03-07 13:00:00','aurora','',0038,'','0000-00-00','');
/*!40000 ALTER TABLE `clientcases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personnel`
--

DROP TABLE IF EXISTS `personnel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personnel` (
  `id` smallint(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `email` varchar(64) COLLATE utf8_bin NOT NULL,
  `phone` varchar(12) COLLATE utf8_bin NOT NULL,
  `workfunction` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personnel`
--

LOCK TABLES `personnel` WRITE;
/*!40000 ALTER TABLE `personnel` DISABLE KEYS */;
INSERT INTO `personnel` VALUES 
(0001,'Saul Goodman','saul@goodman.com','999-999-9999','attorney'),
(0002,'Mary Jane','mary@goodman.com','999-999-9999','paralegal');
/*!40000 ALTER TABLE `personnel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_state`
--

DROP TABLE IF EXISTS `tbl_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_state` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK: State ID',
  `statename` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'State name with first letter capital',
  `stateabv` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Optional state abbreviation (US 2 cap letters)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_state`
--

LOCK TABLES `tbl_state` WRITE;
/*!40000 ALTER TABLE `tbl_state` DISABLE KEYS */;
INSERT INTO `tbl_state` VALUES (1,'Alabama','AL'),(2,'Alaska','AK'),(3,'Arizona','AZ'),(4,'Arkansas','AR'),(5,'California','CA'),(6,'Colorado','CO'),(7,'Connecticut','CT'),(8,'Delaware','DE'),(9,'District of Columbia','DC'),(10,'Florida','FL'),(11,'Georgia','GA'),(12,'Hawaii','HI'),(13,'Idaho','ID'),(14,'Illinois','IL'),(15,'Indiana','IN'),(16,'Iowa','IA'),(17,'Kansas','KS'),(18,'Kentucky','KY'),(19,'Louisiana','LA'),(20,'Maine','ME'),(21,'Maryland','MD'),(22,'Massachusetts','MA'),(23,'Michigan','MI'),(24,'Minnesota','MN'),(25,'Mississippi','MS'),(26,'Missouri','MO'),(27,'Montana','MT'),(28,'Nebraska','NE'),(29,'Nevada','NV'),(30,'New Hampshire','NH'),(31,'New Jersey','NJ'),(32,'New Mexico','NM'),(33,'New York','NY'),(34,'North Carolina','NC'),(35,'North Dakota','ND'),(36,'Ohio','OH'),(37,'Oklahoma','OK'),(38,'Oregon','OR'),(39,'Pennsylvania','PA'),(40,'Rhode Island','RI'),(41,'South Carolina','SC'),(42,'South Dakota','SD'),(43,'Tennessee','TN'),(44,'Texas','TX'),(45,'Utah','UT'),(46,'Vermont','VT'),(47,'Virginia','VA'),(48,'Washington','WA'),(49,'West Virginia','WV'),(50,'Wisconsin','WI'),(51,'Wyoming','WY');
/*!40000 ALTER TABLE `tbl_state` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-17 11:53:54
