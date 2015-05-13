-- MySQL dump 10.13  Distrib 5.6.12, for Win64 (x86_64)
--
-- Host: localhost    Database: scsim_phoenix
-- ------------------------------------------------------
-- Server version	5.6.12-log

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
-- Table structure for table `cd_gamesets`
--

DROP TABLE IF EXISTS `cd_gamesets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_gamesets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_gamesets`
--

LOCK TABLES `cd_gamesets` WRITE;
/*!40000 ALTER TABLE `cd_gamesets` DISABLE KEYS */;
INSERT INTO `cd_gamesets` VALUES (6,'SCSIM Standard',7,'2014-04-07 09:28:27');
/*!40000 ALTER TABLE `cd_gamesets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_inputparts`
--

DROP TABLE IF EXISTS `cd_inputparts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_inputparts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_step_id` int(11) NOT NULL,
  `cd_product_id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `admin_id` int(11) NOT NULL,
  `cd_gameset_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_CD_PARTCOMB_PROD_ID_idx` (`cd_product_id`),
  KEY `FK_CD_PARTCOMB_STEP_ID_idx` (`cd_step_id`),
  CONSTRAINT `FK_CD_PARTCOMB_PROD_ID` FOREIGN KEY (`cd_product_id`) REFERENCES `cd_products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_CD_PARTCOMB_STEP_ID` FOREIGN KEY (`cd_step_id`) REFERENCES `cd_steps` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=latin1 COMMENT='Mappingtable Product2Steps';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_inputparts`
--

LOCK TABLES `cd_inputparts` WRITE;
/*!40000 ALTER TABLE `cd_inputparts` DISABLE KEYS */;
INSERT INTO `cd_inputparts` VALUES (6,37,52,1,7,6,'2014-04-07 10:17:53'),(7,37,55,1,7,6,'2014-04-07 10:17:53'),(8,37,57,1,7,6,'2014-04-07 10:17:54'),(9,37,42,1,7,6,'2014-04-07 10:17:54'),(10,37,48,1,7,6,'2014-04-07 10:17:55'),(11,38,38,1,7,6,'2014-04-07 10:19:10'),(12,38,37,1,7,6,'2014-04-07 10:19:10'),(13,38,47,1,7,6,'2014-04-07 10:19:11'),(14,38,55,1,7,6,'2014-04-07 10:19:11'),(15,38,57,1,7,6,'2014-04-07 10:19:12'),(16,39,71,2,7,6,'2014-04-07 10:20:25'),(17,39,75,2,7,6,'2014-04-07 10:20:26'),(18,40,74,1,7,6,'2014-04-07 10:20:27'),(19,41,70,1,7,6,'2014-04-07 10:23:10'),(20,41,71,1,7,6,'2014-04-07 10:23:11'),(21,41,72,1,7,6,'2014-04-07 10:23:11'),(22,41,73,1,7,6,'2014-04-07 10:23:12'),(23,42,58,1,7,6,'2014-04-07 10:27:33'),(24,43,55,1,7,6,'2014-04-07 10:27:34'),(25,43,68,1,7,6,'2014-04-07 10:27:34'),(26,43,82,1,7,6,'2014-04-07 10:27:34'),(27,43,69,2,7,6,'2014-04-07 10:27:35'),(28,44,25,1,7,6,'2014-04-07 10:29:47'),(29,44,46,1,7,6,'2014-04-07 10:29:47'),(30,44,31,1,7,6,'2014-04-07 10:29:48'),(31,44,55,2,7,6,'2014-04-07 10:29:48'),(32,44,56,2,7,6,'2014-04-07 10:29:49'),(33,45,34,1,7,6,'2014-04-07 10:30:57'),(34,45,39,1,7,6,'2014-04-07 10:30:58'),(35,45,28,1,7,6,'2014-04-07 10:30:58'),(36,45,55,2,7,6,'2014-04-07 10:30:58'),(37,45,56,2,7,6,'2014-04-07 10:30:59'),(38,46,76,1,7,6,'2014-04-07 10:32:06'),(39,46,77,36,7,6,'2014-04-07 10:32:06'),(40,47,62,2,7,6,'2014-04-07 10:32:07'),(41,47,63,1,7,6,'2014-04-07 10:32:07'),(42,48,81,1,7,6,'2014-04-07 10:37:43'),(43,52,59,1,7,6,'2014-04-07 10:37:45'),(44,53,76,1,7,6,'2014-04-07 10:38:58'),(45,53,77,36,7,6,'2014-04-07 10:38:59'),(46,54,62,2,7,6,'2014-04-07 10:39:00'),(47,54,64,1,7,6,'2014-04-07 10:39:00'),(48,54,65,1,7,6,'2014-04-07 10:39:00'),(49,55,58,3,7,6,'2014-04-07 10:42:18'),(50,57,80,2,7,6,'2014-04-07 10:42:19'),(51,58,59,1,7,6,'2014-04-07 10:42:20'),(52,59,81,1,7,6,'2014-04-07 10:44:23'),(53,63,59,1,7,6,'2014-04-07 10:44:25'),(54,64,81,1,7,6,'2014-04-07 10:52:15'),(55,68,59,1,7,6,'2014-04-07 10:52:17'),(56,69,58,4,7,6,'2014-04-07 10:53:42'),(57,71,80,2,7,6,'2014-04-07 10:53:43'),(58,72,59,1,7,6,'2014-04-07 10:53:44'),(59,73,78,1,7,6,'2014-04-07 10:54:54'),(60,73,79,36,7,6,'2014-04-07 10:54:54'),(61,74,62,2,7,6,'2014-04-07 10:54:55'),(62,74,64,1,7,6,'2014-04-07 10:54:56'),(63,74,65,1,7,6,'2014-04-07 10:54:56'),(64,75,78,1,7,6,'2014-04-07 10:55:51'),(65,75,79,36,7,6,'2014-04-07 10:55:51'),(66,76,62,2,7,6,'2014-04-07 10:55:52'),(67,76,63,1,7,6,'2014-04-07 10:55:52'),(68,77,81,1,7,6,'2014-04-07 10:57:19'),(69,81,59,1,7,6,'2014-04-07 10:57:21'),(75,83,49,1,7,6,'2014-04-07 10:59:11'),(76,83,26,1,7,6,'2014-04-07 10:59:12'),(77,83,32,1,7,6,'2014-04-07 10:59:12'),(78,83,55,2,7,6,'2014-04-07 10:59:13'),(79,83,56,2,7,6,'2014-04-07 10:59:13'),(80,84,38,1,7,6,'2014-04-07 11:00:08'),(81,84,37,1,7,6,'2014-04-07 11:00:08'),(82,84,50,1,7,6,'2014-04-07 11:00:09'),(83,84,55,1,7,6,'2014-04-07 11:00:09'),(84,84,57,1,7,6,'2014-04-07 11:00:09'),(85,85,51,1,7,6,'2014-04-07 11:01:04'),(86,85,42,1,7,6,'2014-04-07 11:01:04'),(87,85,53,1,7,6,'2014-04-07 11:01:05'),(88,85,55,1,7,6,'2014-04-07 11:01:05'),(89,85,57,1,7,6,'2014-04-07 11:01:06'),(90,86,45,1,7,6,'2014-04-07 11:07:34'),(91,86,42,1,7,6,'2014-04-07 11:07:34'),(92,86,54,1,7,6,'2014-04-07 11:07:34'),(93,86,55,1,7,6,'2014-04-07 11:07:35'),(94,86,57,1,7,6,'2014-04-07 11:07:35'),(95,87,38,1,7,6,'2014-04-07 11:08:34'),(96,87,37,1,7,6,'2014-04-07 11:08:34'),(97,87,44,1,7,6,'2014-04-07 11:08:35'),(98,87,55,1,7,6,'2014-04-07 11:08:35'),(99,87,57,1,7,6,'2014-04-07 11:08:36'),(100,88,43,1,7,6,'2014-04-07 11:10:00'),(101,88,27,1,7,6,'2014-04-07 11:10:00'),(102,88,33,1,7,6,'2014-04-07 11:10:01'),(103,88,55,2,7,6,'2014-04-07 11:10:01'),(104,88,56,2,7,6,'2014-04-07 11:10:01'),(105,89,36,1,7,6,'2014-04-07 11:11:09'),(106,89,41,1,7,6,'2014-04-07 11:11:09'),(107,89,30,1,7,6,'2014-04-07 11:11:10'),(108,89,55,2,7,6,'2014-04-07 11:11:10'),(109,89,56,2,7,6,'2014-04-07 11:11:10'),(110,90,60,1,7,6,'2014-04-07 11:12:42'),(111,90,61,36,7,6,'2014-04-07 11:12:42'),(112,91,62,2,7,6,'2014-04-07 11:12:43'),(113,91,63,1,7,6,'2014-04-07 11:12:43'),(114,92,60,1,7,6,'2014-04-07 11:14:13'),(115,92,61,36,7,6,'2014-04-07 11:14:13'),(116,93,62,2,7,6,'2014-04-07 11:14:14'),(117,93,64,1,7,6,'2014-04-07 11:14:14'),(118,93,65,1,7,6,'2014-04-07 11:14:15'),(119,94,58,5,7,6,'2014-04-07 11:15:50'),(120,96,80,2,7,6,'2014-04-07 11:15:52'),(121,97,59,1,7,6,'2014-04-07 11:15:52'),(122,98,81,1,7,6,'2014-04-07 11:18:24'),(123,102,59,1,7,6,'2014-04-07 11:18:26'),(124,103,81,1,7,6,'2014-04-07 11:20:13'),(125,107,59,1,7,6,'2014-04-07 11:20:15'),(126,108,35,1,7,6,'2014-08-18 16:47:25'),(127,108,40,1,7,6,'2014-08-18 16:47:25'),(128,108,29,1,7,6,'2014-08-18 16:47:26'),(129,108,55,2,7,6,'2014-08-18 16:47:26'),(130,108,56,2,7,6,'2014-08-18 16:47:27');
/*!40000 ALTER TABLE `cd_inputparts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_machines`
--

DROP TABLE IF EXISTS `cd_machines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_machines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `ident` varchar(45) DEFAULT NULL COMMENT 'Identifikation der Maschine global',
  `admin_id` int(11) DEFAULT NULL,
  `running_costs` double DEFAULT NULL COMMENT 'Variable Kosten pro Minute in Euro',
  `fixed_costs` double DEFAULT NULL COMMENT 'Fixe Kosten pro Minute in Euro',
  `cost_price` double DEFAULT NULL COMMENT 'Anschaffungspreis in Euro',
  `replacement_time` double DEFAULT NULL,
  `replacement_deviation` double DEFAULT NULL,
  `cd_gameset_id` int(11) DEFAULT NULL,
  `wage_shift_one` double DEFAULT NULL,
  `wage_shift_two` double DEFAULT NULL,
  `wage_shift_three` double DEFAULT NULL,
  `wage_overtime` double DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_CD_MACHINES_USER_ID_idx` (`admin_id`),
  CONSTRAINT `FK_CD_MACHINES_USER_ID` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_machines`
--

LOCK TABLES `cd_machines` WRITE;
/*!40000 ALTER TABLE `cd_machines` DISABLE KEYS */;
INSERT INTO `cd_machines` VALUES (30,'Blechschere','13',7,0.35,0.15,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:07:45'),(31,'Blech Biegemaschine','12',7,0.2,0.1,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:08:05'),(32,'Stanze','8',7,0.2,0.1,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:08:19'),(33,'Schweißplatz','7',7,0.2,0.1,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:08:36'),(34,'Lackierplatz','9',7,0.55,0.25,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:08:48'),(35,'Rohr Biegemaschine','6',7,0.2,0.1,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:09:02'),(36,'End-Montage','4',7,0.04,0.01,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:09:43'),(37,'Montage','3',7,0.04,0.01,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:09:55'),(38,'Hinterrad-Montage','2',7,0.04,0.01,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:10:14'),(39,'Vorderrad-Montage','1',7,0.04,0.01,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:10:38'),(40,'Rad-Montage','10',7,0.2,0.1,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:10:51'),(41,'Naben-Montage','11',7,0.2,0.1,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:11:03'),(42,'Lenker-Montage','14',7,0.04,0.01,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:11:16'),(43,'Montage','15',7,0.04,0.01,0,0,0,6,0.45,0.55,0.7,0.9,'2014-04-07 10:11:31');
/*!40000 ALTER TABLE `cd_machines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_periodevents`
--

DROP TABLE IF EXISTS `cd_periodevents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_periodevents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text,
  `period` int(11) DEFAULT NULL,
  `cd_gameset_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_periodevents`
--

LOCK TABLES `cd_periodevents` WRITE;
/*!40000 ALTER TABLE `cd_periodevents` DISABLE KEYS */;
INSERT INTO `cd_periodevents` VALUES (4,'Period 1',1,6,7,'2014-08-26 14:11:23'),(5,'Period 2',2,6,7,'2014-08-26 14:17:28'),(6,'Period 3',3,6,7,'2014-08-26 14:17:59'),(7,'Period 4',4,6,7,'2014-08-26 14:18:28'),(8,'Period 5',5,6,7,'2014-08-26 14:18:54'),(9,'Period 6',6,6,7,'2014-08-26 14:20:36'),(10,'Period 7',7,6,7,'2014-08-26 14:21:06'),(11,'Period 8',8,6,7,'2014-08-26 14:21:35');
/*!40000 ALTER TABLE `cd_periodevents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_products`
--

DROP TABLE IF EXISTS `cd_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kind` varchar(1) DEFAULT NULL COMMENT 'k für Kaufteil und e für Erzeugnis und p für Produkt',
  `number` varchar(45) DEFAULT NULL,
  `description` varchar(100) NOT NULL,
  `value` double DEFAULT '0' COMMENT 'Teilewert in Euro',
  `discount_amount` int(11) DEFAULT '0' COMMENT 'Diskontmenge in Stueck',
  `delivery_costs` double DEFAULT '0',
  `delivery_time` double DEFAULT '0' COMMENT 'Wiederbeschaffungszeit in Perioden',
  `delivery_deviation` double DEFAULT '0' COMMENT 'Abweichung der Wiederbeschaffungszeit in Perioden',
  `admin_id` int(11) NOT NULL,
  `cd_gameset_id` int(11) DEFAULT NULL,
  `start_amount` int(11) DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_CD_PRODUCTS_ADMIN_ID_idx` (`admin_id`),
  CONSTRAINT `FK_CD_PRODUCTS_ADMIN_ID` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_products`
--

LOCK TABLES `cd_products` WRITE;
/*!40000 ALTER TABLE `cd_products` DISABLE KEYS */;
INSERT INTO `cd_products` VALUES (22,'p','1 P','Kinderfahrrad',156.13,0,0,0,0,7,6,100,'2014-04-07 09:33:12'),(23,'p','2 P','Damenfahrrad',163.33,0,0,0,0,7,6,100,'2014-04-07 09:33:34'),(24,'p','3 P','Herrenfahrrad',165.08,0,0,0,0,7,6,100,'2014-04-07 09:33:59'),(25,'e','4 E','Hinterradgruppe',40.85,0,0,0,0,7,6,100,'2014-04-07 09:34:38'),(26,'e','5 E','Hinterradgruppe',39.85,0,0,0,0,7,6,100,'2014-04-07 09:35:05'),(27,'e','6 E','Hinterradgruppe',40.85,0,0,0,0,7,6,100,'2014-04-07 09:35:22'),(28,'e','7 E','Vorderradgruppe',35.85,0,0,0,0,7,6,100,'2014-04-07 09:35:41'),(29,'e','8 E','Vorderradgruppe',35.85,0,0,0,0,7,6,100,'2014-04-07 09:36:03'),(30,'e','9 E','Vorderradgruppe',35.85,0,0,0,0,7,6,100,'2014-04-07 09:36:28'),(31,'e','10 E','Schutzblech h.',12.4,0,0,0,0,7,6,100,'2014-04-07 09:36:54'),(32,'e','11 E','Schutzblech h.',14.65,0,0,0,0,7,6,100,'2014-04-07 09:37:10'),(33,'e','12 E','Schutzblech h.',14.65,0,0,0,0,7,6,100,'2014-04-07 09:37:28'),(34,'e','13 E','Schutzblech v.',12.4,0,0,0,0,7,6,100,'2014-04-07 09:37:48'),(35,'e','14 E','Schutzbelch v.',14.65,0,0,0,0,7,6,100,'2014-04-07 09:38:05'),(36,'e','15 E','Schutzblech v.',14.65,0,0,0,0,7,6,100,'2014-04-07 09:38:22'),(37,'e','16 E','Lenker cpl.',7.02,0,0,0,0,7,6,300,'2014-04-07 09:39:02'),(38,'e','17 E','Sattel cpl.',7.16,0,0,0,0,7,6,300,'2014-04-07 09:39:20'),(39,'e','18 E','Rahmen',13.15,0,0,0,0,7,6,100,'2014-04-07 09:39:35'),(40,'e','19 E','Rahmen',14.35,0,0,0,0,7,6,100,'2014-04-07 09:40:50'),(41,'e','20 E','Rahmen',15.55,0,0,0,0,7,6,100,'2014-04-07 09:41:06'),(42,'e','26 E','Pedal cpl.',10.5,0,0,0,0,7,6,300,'2014-04-07 09:41:29'),(43,'e','29 E','Vorderrad mont.',69.29,0,0,0,0,7,6,100,'2014-04-07 09:42:09'),(44,'e','30 E','Rahmen u. Räder',127.53,0,0,0,0,7,6,100,'2014-04-07 09:42:29'),(45,'e','31 E','Fahrrad o. Ped.',144.42,0,0,0,0,7,6,100,'2014-04-07 09:42:58'),(46,'e','49 E','Vorderrad cpl.',64.64,0,0,0,0,7,6,100,'2014-04-07 09:43:24'),(47,'e','50 E','Rahmen u. Räder',120.63,0,0,0,0,7,6,100,'2014-04-07 09:43:50'),(48,'e','51 E','Fahrrad o. Pedal',137.47,0,0,0,0,7,6,100,'2014-04-07 09:44:17'),(49,'e','54 E','Vorderrad cpl.',68.09,0,0,0,0,7,6,100,'2014-04-07 09:44:48'),(50,'e','55 E','Rahmen u. Räder',125.33,0,0,0,0,7,6,100,'2014-04-07 09:45:08'),(51,'e','56 E','Fahrrad o. Pedal',142.67,0,0,0,0,7,6,100,'2014-04-07 09:45:38'),(52,'k','21 K','Kette',5,300,50,1.8,0.4,7,6,2300,'2014-04-07 09:50:26'),(53,'k','22 K','Kette',6.5,300,50,1.7,0.4,7,6,300,'2014-04-07 09:51:18'),(54,'k','23 K','Kette',6.5,300,50,1.2,0.2,7,6,300,'2014-04-07 09:52:48'),(55,'k','24 K','Mutter 3/8\"',0.06,6100,100,3.2,0.3,7,6,6100,'2014-04-07 09:53:32'),(56,'k','25 K','Scheibe 3/8\"',0.06,3600,50,0.9,0.2,7,6,3600,'2014-04-07 09:54:01'),(57,'k','27 K','Schraube 3/8\"',0.1,1800,75,0.9,0.2,7,6,1800,'2014-04-07 09:54:43'),(58,'k','28 K','Rohr 3/4\"',1.2,4500,50,1.7,0.4,7,6,4500,'2014-04-07 09:55:20'),(59,'k','32 K','Farbe',0.75,2700,50,2.1,0.5,7,6,2500,'2014-04-07 09:55:40'),(60,'k','33 K','Felge cpl.',22,900,75,1.9,0.5,7,6,900,'2014-04-07 09:56:11'),(61,'k','34 K','Speiche',0.1,22000,50,1.6,0.3,7,6,22000,'2014-04-07 09:56:41'),(62,'k','35 K','Nabe',1,3600,75,2.2,0.4,7,6,3600,'2014-04-07 09:57:15'),(63,'k','36 K','Freilauf',8,900,100,1.2,0.1,7,6,900,'2014-04-07 09:57:35'),(64,'k','37 K','Gabel',1.5,900,50,1.5,0.3,7,6,900,'2014-04-07 09:57:59'),(65,'k','38 K','Welle',1.5,300,50,1.7,0.4,7,6,300,'2014-04-07 09:58:23'),(68,'k','41 K','Mutter 3/4\"',0.06,900,50,0.9,0.2,7,6,900,'2014-04-07 09:59:37'),(69,'k','42 K','Griff',0.1,1800,50,1.2,0.3,7,6,1800,'2014-04-07 10:00:02'),(70,'k','43 K','Sattel',5,2700,75,2,0.5,7,6,1900,'2014-04-07 10:00:22'),(71,'k','44 K','Stange 1/2\"',0.5,900,50,1,0.2,7,6,2700,'2014-04-07 10:00:49'),(72,'k','45 K','Mutter 1/4\"',0.06,900,50,1.7,0.3,7,6,900,'2014-04-07 10:01:17'),(73,'k','46 K','Schraube 1/4\"',0.1,900,50,0.9,0.3,7,6,900,'2014-04-07 10:01:41'),(74,'k','47 K','Zahnkranz',3.5,900,50,1.1,0.1,7,6,900,'2014-04-07 10:02:06'),(75,'k','48 K','Pedal',1.5,1800,75,1,0.2,7,6,1800,'2014-04-07 10:02:32'),(76,'k','52 K','Felge cpl.',22,600,50,1.6,0.4,7,6,600,'2014-04-07 10:02:58'),(77,'k','53 K','Speiche',0.1,22000,50,1.6,0.2,7,6,22000,'2014-04-07 10:03:23'),(78,'k','57 K','Felge cpl.',22,600,50,1.7,0.3,7,6,600,'2014-04-07 10:03:43'),(79,'k','58 K','Speiche',0.1,22000,50,1.6,0.5,7,6,22000,'2014-04-07 10:04:07'),(80,'k','59 K','Schweißdraht',0.15,1800,50,0.7,0.2,7,6,1800,'2014-04-07 10:04:30'),(81,'k','39 K','Blech',1.5,1800,75,1.5,0.3,7,6,700,'2014-04-07 10:25:53'),(82,'k','40 K','Lenker',2.5,900,50,1.7,0.2,7,6,900,'2014-04-07 10:26:20');
/*!40000 ALTER TABLE `cd_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_sellingforecasts`
--

DROP TABLE IF EXISTS `cd_sellingforecasts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_sellingforecasts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_product_id` int(11) DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `solid_sales` int(11) DEFAULT '0',
  `additional_sales` int(11) DEFAULT '0',
  `cd_gameset_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_sellingforecasts`
--

LOCK TABLES `cd_sellingforecasts` WRITE;
/*!40000 ALTER TABLE `cd_sellingforecasts` DISABLE KEYS */;
INSERT INTO `cd_sellingforecasts` VALUES (10,22,1,150,0,6,7,'2014-08-26 14:17:12'),(11,23,1,150,0,6,7,'2014-08-26 14:17:12'),(12,24,1,150,0,6,7,'2014-08-26 14:17:13'),(13,22,2,150,0,6,7,'2014-08-26 14:17:49'),(14,23,2,100,0,6,7,'2014-08-26 14:17:50'),(15,24,2,100,0,6,7,'2014-08-26 14:17:50'),(16,22,3,150,0,6,7,'2014-08-26 14:18:14'),(17,23,3,100,0,6,7,'2014-08-26 14:18:15'),(18,24,3,50,0,6,7,'2014-08-26 14:18:15'),(19,22,4,200,0,6,7,'2014-08-26 14:18:43'),(20,23,4,100,0,6,7,'2014-08-26 14:18:44'),(21,24,4,50,0,6,7,'2014-08-26 14:18:44'),(22,22,5,200,0,6,7,'2014-08-26 14:20:24'),(23,23,5,150,0,6,7,'2014-08-26 14:20:24'),(24,24,5,100,0,6,7,'2014-08-26 14:20:24'),(25,22,6,150,0,6,7,'2014-08-26 14:20:55'),(26,23,6,250,0,6,7,'2014-08-26 14:20:55'),(27,24,6,100,0,6,7,'2014-08-26 14:20:56'),(28,22,7,100,0,6,7,'2014-08-26 14:21:22'),(29,23,7,200,0,6,7,'2014-08-26 14:21:22'),(30,24,7,100,0,6,7,'2014-08-26 14:21:22'),(31,22,8,100,0,6,7,'2014-08-26 14:21:52'),(32,23,8,100,0,6,7,'2014-08-26 14:21:52'),(33,24,8,150,0,6,7,'2014-08-26 14:21:53');
/*!40000 ALTER TABLE `cd_sellingforecasts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_steps`
--

DROP TABLE IF EXISTS `cd_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_machine_id` int(11) DEFAULT NULL,
  `cycle_time` int(11) DEFAULT NULL COMMENT 'Durchlaufzeit',
  `set_up_time` int(11) DEFAULT NULL COMMENT 'Rüstzeit',
  `clearing_time` int(11) DEFAULT NULL COMMENT 'Abrüstzeit',
  `cd_workflow_id` int(11) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cd_gameset_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_CD_STEPS_MASCHINE_ID_idx` (`cd_machine_id`),
  KEY `FK_CD_STEPS_WORKFLOW_ID_idx` (`cd_workflow_id`),
  CONSTRAINT `FK_CD_STEPS_MASCHINE_ID` FOREIGN KEY (`cd_machine_id`) REFERENCES `cd_machines` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_CD_STEPS_WORKFLOW_ID` FOREIGN KEY (`cd_workflow_id`) REFERENCES `cd_workflows` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_steps`
--

LOCK TABLES `cd_steps` WRITE;
/*!40000 ALTER TABLE `cd_steps` DISABLE KEYS */;
INSERT INTO `cd_steps` VALUES (37,36,6,30,0,19,1,'2014-04-07 10:17:53',6,7),(38,37,5,20,0,20,1,'2014-04-07 10:19:10',6,7),(39,33,2,30,0,21,1,'2014-04-07 10:20:25',6,7),(40,43,3,15,0,21,2,'2014-04-07 10:20:26',6,7),(41,43,3,15,0,22,1,'2014-04-07 10:23:10',6,7),(42,35,2,15,0,23,1,'2014-04-07 10:24:25',6,7),(43,42,3,0,0,23,2,'2014-04-07 10:24:26',6,7),(44,38,5,30,0,24,1,'2014-04-07 10:29:47',6,7),(45,39,6,20,0,25,1,'2014-04-07 10:30:57',6,7),(46,40,4,20,0,26,1,'2014-04-07 10:32:05',6,7),(47,41,3,10,0,26,2,'2014-04-07 10:32:07',6,7),(48,30,2,0,0,27,1,'2014-04-07 10:37:42',6,7),(49,31,3,0,0,27,2,'2014-04-07 10:37:43',6,7),(50,32,1,15,0,27,3,'2014-04-07 10:37:43',6,7),(51,33,2,20,0,27,4,'2014-04-07 10:37:44',6,7),(52,34,3,15,0,27,5,'2014-04-07 10:37:44',6,7),(53,40,4,20,0,28,1,'2014-04-07 10:38:58',6,7),(54,41,3,20,0,28,2,'2014-04-07 10:38:59',6,7),(55,35,3,15,0,29,1,'2014-04-07 10:42:17',6,7),(56,32,3,20,0,29,2,'2014-04-07 10:42:18',6,7),(57,33,2,20,0,29,3,'2014-04-07 10:42:18',6,7),(58,34,2,15,0,29,4,'2014-04-07 10:42:19',6,7),(59,30,2,0,0,30,1,'2014-04-07 10:43:27',6,7),(60,31,3,0,0,30,2,'2014-04-07 10:43:27',6,7),(61,32,1,15,0,30,3,'2014-04-07 10:43:27',6,7),(62,33,2,20,0,30,4,'2014-04-07 10:43:28',6,7),(63,34,3,15,0,30,5,'2014-04-07 10:43:28',6,7),(64,30,2,0,0,31,1,'2014-04-07 10:52:15',6,7),(65,31,3,0,0,31,2,'2014-04-07 10:52:16',6,7),(66,32,2,15,0,31,3,'2014-04-07 10:52:16',6,7),(67,33,2,20,0,31,4,'2014-04-07 10:52:16',6,7),(68,34,3,15,0,31,5,'2014-04-07 10:52:17',6,7),(69,35,3,15,0,32,1,'2014-04-07 10:53:41',6,7),(70,32,3,25,0,32,2,'2014-04-07 10:53:42',6,7),(71,33,2,20,0,32,3,'2014-04-07 10:53:43',6,7),(72,34,2,20,0,32,4,'2014-04-07 10:53:43',6,7),(73,40,4,20,0,33,1,'2014-04-07 10:54:54',6,7),(74,41,3,20,0,33,2,'2014-04-07 10:54:55',6,7),(75,40,4,20,0,34,1,'2014-04-07 10:55:50',6,7),(76,41,3,10,0,34,2,'2014-04-07 10:55:52',6,7),(77,30,2,0,0,35,1,'2014-04-07 10:57:19',6,7),(78,31,3,0,0,35,2,'2014-04-07 10:57:20',6,7),(79,32,2,15,0,35,3,'2014-04-07 10:57:20',6,7),(80,33,2,20,0,35,4,'2014-04-07 10:57:20',6,7),(81,34,3,15,0,35,5,'2014-04-07 10:57:21',6,7),(83,38,5,30,0,37,1,'2014-04-07 10:59:11',6,7),(84,37,6,20,0,38,1,'2014-04-07 11:00:07',6,7),(85,36,6,20,0,39,1,'2014-04-07 11:01:03',6,7),(86,36,7,30,0,40,1,'2014-04-07 11:07:33',6,7),(87,37,6,20,0,41,1,'2014-04-07 11:08:34',6,7),(88,38,5,20,0,42,1,'2014-04-07 11:09:59',6,7),(89,39,6,20,0,43,1,'2014-04-07 11:11:08',6,7),(90,40,4,20,0,44,1,'2014-04-07 11:12:41',6,7),(91,41,3,20,0,44,2,'2014-04-07 11:12:43',6,7),(92,40,4,20,0,45,1,'2014-04-07 11:14:12',6,7),(93,41,3,20,0,45,2,'2014-04-07 11:14:13',6,7),(94,35,3,15,0,46,1,'2014-04-07 11:15:50',6,7),(95,32,3,20,0,46,2,'2014-04-07 11:15:51',6,7),(96,33,2,20,0,46,3,'2014-04-07 11:15:51',6,7),(97,34,2,15,0,46,4,'2014-04-07 11:15:52',6,7),(98,30,2,0,0,47,1,'2014-04-07 11:18:23',6,7),(99,31,3,0,0,47,2,'2014-04-07 11:18:24',6,7),(100,32,2,15,0,47,3,'2014-04-07 11:18:24',6,7),(101,33,2,20,0,47,4,'2014-04-07 11:18:25',6,7),(102,34,3,15,0,47,5,'2014-04-07 11:18:25',6,7),(103,30,2,0,0,48,1,'2014-04-07 11:20:12',6,7),(104,31,3,0,0,48,2,'2014-04-07 11:20:13',6,7),(105,32,2,15,0,48,3,'2014-04-07 11:20:14',6,7),(106,33,2,20,0,48,4,'2014-04-07 11:20:14',6,7),(107,34,3,15,0,48,5,'2014-04-07 11:20:14',6,7),(108,39,6,20,0,49,1,'2014-08-18 16:47:25',6,7);
/*!40000 ALTER TABLE `cd_steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_workflows`
--

DROP TABLE IF EXISTS `cd_workflows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_workflows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `output_product_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `cd_gameset_id` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_WORKFLOW_OUTPUT_PRODUCT_idx` (`output_product_id`),
  KEY `FK_WORKFLOW_ADMIN_ID_idx` (`admin_id`),
  CONSTRAINT `FK_WORKFLOW_ADMIN_ID` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_WORKFLOW_OUTPUT_PRODUCT` FOREIGN KEY (`output_product_id`) REFERENCES `cd_products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_workflows`
--

LOCK TABLES `cd_workflows` WRITE;
/*!40000 ALTER TABLE `cd_workflows` DISABLE KEYS */;
INSERT INTO `cd_workflows` VALUES (19,'Kinderfahrrad',22,7,6,'2014-04-07 10:17:52'),(20,'Fahrrad o. Pedale',48,7,6,'2014-04-07 10:19:09'),(21,'Pedal',42,7,6,'2014-04-07 10:20:25'),(22,'Sattel cpl.',38,7,6,'2014-04-07 10:23:10'),(23,'Lenker cpl.',37,7,6,'2014-04-07 10:24:25'),(24,'Rahmen u. R?der',47,7,6,'2014-04-07 10:29:46'),(25,'Vorderrad cpl.',46,7,6,'2014-04-07 10:30:56'),(26,'Hinterrad',25,7,6,'2014-04-07 10:32:05'),(27,'Schutzblech h.',31,7,6,'2014-04-07 10:37:42'),(28,'Vorderrad',28,7,6,'2014-04-07 10:38:58'),(29,'Rahmen',39,7,6,'2014-04-07 10:42:17'),(30,'Schutzblech v.',34,7,6,'2014-04-07 10:43:26'),(31,'Schutzblech v.',35,7,6,'2014-04-07 10:52:14'),(32,'Rahmen',40,7,6,'2014-04-07 10:53:41'),(33,'Vorderrad',29,7,6,'2014-04-07 10:54:53'),(34,'Hinterrad',26,7,6,'2014-04-07 10:55:50'),(35,'Schutzblech h.',32,7,6,'2014-04-07 10:57:18'),(37,'Rahmen u. Räder',50,7,6,'2014-04-07 10:59:11'),(38,'Fahrrad o. Pedale',51,7,6,'2014-04-07 11:00:07'),(39,'Damenfahrrad',23,7,6,'2014-04-07 11:01:03'),(40,'Herrenfahrrad',24,7,6,'2014-04-07 11:07:33'),(41,'Fahrrad o. Pedal',45,7,6,'2014-04-07 11:08:33'),(42,'Rahmen u. Räder',44,7,6,'2014-04-07 11:09:59'),(43,'Vorderrad',43,7,6,'2014-04-07 11:11:08'),(44,'Hinterrad',27,7,6,'2014-04-07 11:12:41'),(45,'Vorderrad',30,7,6,'2014-04-07 11:14:12'),(46,'Rahmen',41,7,6,'2014-04-07 11:15:49'),(47,'Schutzblech h.',33,7,6,'2014-04-07 11:18:23'),(48,'Schutzblech v.',36,7,6,'2014-04-07 11:20:12'),(49,'Vorderrad cpl.',49,7,6,'2014-08-18 16:47:24');
/*!40000 ALTER TABLE `cd_workflows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `game_key` varchar(20) DEFAULT NULL COMMENT 'Passwort ist erforderlich, um diesem Spiel beizutreten.',
  `admin_id` int(11) DEFAULT NULL COMMENT 'Referenz auf User_id. Dieser User ist Admin des Games',
  `cd_gameset_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_games_user_id` (`admin_id`),
  CONSTRAINT `fk_games_user_id` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(100) DEFAULT NULL COMMENT 'Beispielsweise der Firmenname',
  `game_id` int(11) DEFAULT NULL COMMENT 'Diese Gruppe spielt im Spiel x',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_count` int(11) DEFAULT '0',
  `user_max` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_groups_game_id` (`game_id`),
  CONSTRAINT `fk_groups_game_id` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=208 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) DEFAULT NULL,
  `header` varchar(200) DEFAULT NULL,
  `message` text,
  `unique_id` varchar(30) DEFAULT NULL,
  `read` tinyint(4) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '0',
  `order_type` varchar(10) DEFAULT 'n' COMMENT 'e fuer Eilbestellung und n für Normalbestellung',
  `calculated_delivery_time` double DEFAULT '0' COMMENT 'In welcher Periode die Bestellung verfuegbar ist.',
  `delivered` tinyint(4) DEFAULT '0',
  `delivery_costs` double DEFAULT '0' COMMENT 'Lieferkosten',
  `unit_price` double DEFAULT '0' COMMENT 'Einzelpreis',
  `total_price` double DEFAULT '0' COMMENT 'Einzelpreis mal Menge',
  `end_price` double DEFAULT '0' COMMENT 'Gesamtkosten der Bestellung',
  `order_period` double NOT NULL DEFAULT '0',
  `delivery_period` double DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_ORDERS_PRODUCT_ID_idx` (`cd_product_id`),
  KEY `FK_ORDERS_GROUP_ID_idx` (`group_id`),
  CONSTRAINT `FK_ORDERS_GROUP_ID` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_ORDERS_PRODUCT_ID` FOREIGN KEY (`cd_product_id`) REFERENCES `cd_products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `production_orders`
--

DROP TABLE IF EXISTS `production_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `production_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `cd_product_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `order_period` double DEFAULT NULL,
  `color_gantt` varchar(45) DEFAULT NULL,
  `order_number` int(11) DEFAULT NULL,
  `ready_period` int(11) DEFAULT '-1',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_PRODUCTION_ORDERS__idx` (`cd_product_id`),
  KEY `FK_PRODUCTION_ORDERS__idx1` (`group_id`),
  CONSTRAINT `FK_PRODUCTION_ORDERS_GROUP_ID` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_PRODUCTION_ORDERS_PRODUCT_ID` FOREIGN KEY (`cd_product_id`) REFERENCES `cd_products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1900 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `production_orders`
--

LOCK TABLES `production_orders` WRITE;
/*!40000 ALTER TABLE `production_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `production_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rights`
--

DROP TABLE IF EXISTS `rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ident` varchar(20) DEFAULT NULL,
  `set_to` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_rights_user_id` (`user_id`),
  CONSTRAINT `fk_rights_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rights`
--

LOCK TABLES `rights` WRITE;
/*!40000 ALTER TABLE `rights` DISABLE KEYS */;
/*!40000 ALTER TABLE `rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rules`
--

DROP TABLE IF EXISTS `rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ident` varchar(20) DEFAULT NULL,
  `set_to` varchar(200) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_rules_game_id` (`game_id`),
  CONSTRAINT `fk_rules_game_id` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rules`
--

LOCK TABLES `rules` WRITE;
/*!40000 ALTER TABLE `rules` DISABLE KEYS */;
/*!40000 ALTER TABLE `rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shift_schedulings`
--

DROP TABLE IF EXISTS `shift_schedulings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shift_schedulings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_machine_id` int(11) DEFAULT NULL,
  `shift_amount` int(11) DEFAULT NULL,
  `overtime` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `machine_modus` varchar(45) DEFAULT 'min_set_up',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_SHIFT_SCHEDULING_MASCHINE_ID_idx` (`cd_machine_id`),
  KEY `FK_SHIFT_SCHEDULING_GROUP_ID_idx` (`group_id`),
  CONSTRAINT `FK_SHIFT_SCHEDULING_GROUP_ID` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_SHIFT_SCHEDULING_MASCHINE_ID` FOREIGN KEY (`cd_machine_id`) REFERENCES `cd_machines` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shift_schedulings`
--

LOCK TABLES `shift_schedulings` WRITE;
/*!40000 ALTER TABLE `shift_schedulings` DISABLE KEYS */;
/*!40000 ALTER TABLE `shift_schedulings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim_debug_logs`
--

DROP TABLE IF EXISTS `sim_debug_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sim_debug_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `simtime` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `production_order_id` int(11) DEFAULT NULL,
  `sim_production_order_id` int(11) DEFAULT NULL,
  `sim_operating_data_id` int(11) DEFAULT NULL,
  `sim_machine_id` int(11) DEFAULT NULL,
  `cd_product_id` int(11) DEFAULT NULL,
  `cd_workflow_id` int(11) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `cd_step_id` int(11) DEFAULT NULL,
  `text` text,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim_debug_logs`
--

LOCK TABLES `sim_debug_logs` WRITE;
/*!40000 ALTER TABLE `sim_debug_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `sim_debug_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim_logs`
--

DROP TABLE IF EXISTS `sim_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sim_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `log_id` varchar(45) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_GROUP_STATUS_idx` (`group_id`),
  CONSTRAINT `FK_GROUP_STATUS` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim_logs`
--

LOCK TABLES `sim_logs` WRITE;
/*!40000 ALTER TABLE `sim_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `sim_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim_machine_datas`
--

DROP TABLE IF EXISTS `sim_machine_datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sim_machine_datas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_machine_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `idle_time` double DEFAULT '0',
  `production_time` double DEFAULT '0',
  `set_up_time` double DEFAULT '0',
  `clearing_time` double DEFAULT '0',
  `period` int(11) DEFAULT NULL,
  `idle_time_shift_1` double DEFAULT '0',
  `idle_time_shift_2` double DEFAULT '0',
  `idle_time_shift_3` double DEFAULT '0',
  `idle_time_overtime` double DEFAULT '0',
  `production_time_shift_1` double DEFAULT '0',
  `production_time_shift_2` double DEFAULT '0',
  `production_time_shift_3` double DEFAULT '0',
  `production_time_overtime` double DEFAULT '0',
  `costs_idle_time_shift_1` double DEFAULT '0',
  `costs_idle_time_shift_2` double DEFAULT '0',
  `costs_idle_time_shift_3` double DEFAULT '0',
  `costs_idle_time_overtime` double DEFAULT '0',
  `costs_idle_time` double DEFAULT '0',
  `costs_production_time_shift_1` double DEFAULT '0',
  `costs_production_time_shift_2` double DEFAULT '0',
  `costs_production_time_shift_3` double DEFAULT '0',
  `costs_production_time_overtime` double DEFAULT '0',
  `costs_production_time` double DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_MSCHINE_DATA_GROUP_idx` (`group_id`),
  CONSTRAINT `FK_MSCHINE_DATA_GROUP` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim_machine_datas`
--

LOCK TABLES `sim_machine_datas` WRITE;
/*!40000 ALTER TABLE `sim_machine_datas` DISABLE KEYS */;
/*!40000 ALTER TABLE `sim_machine_datas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim_operating_datas`
--

DROP TABLE IF EXISTS `sim_operating_datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sim_operating_datas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_machine_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `simtime_start` int(11) DEFAULT NULL,
  `simtime_end` int(11) DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `day_start` int(11) DEFAULT NULL,
  `day_end` int(11) DEFAULT NULL,
  `shift` varchar(45) DEFAULT NULL,
  `production_order_id` int(11) DEFAULT NULL,
  `sim_production_order_id` int(11) DEFAULT NULL,
  `shift_costs` double DEFAULT NULL,
  `machine_costs` double DEFAULT NULL,
  `costs` double DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_GROUP_ID_GROUP_idx` (`group_id`),
  KEY `cd_machine_id` (`cd_machine_id`),
  KEY `sim_production_order_id` (`sim_production_order_id`),
  CONSTRAINT `FK_GROUP_ID_GROUP` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim_operating_datas`
--

LOCK TABLES `sim_operating_datas` WRITE;
/*!40000 ALTER TABLE `sim_operating_datas` DISABLE KEYS */;
/*!40000 ALTER TABLE `sim_operating_datas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim_period_status`
--

DROP TABLE IF EXISTS `sim_period_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sim_period_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `orders_set` tinyint(4) DEFAULT NULL,
  `shift_schedulings_set` tinyint(4) DEFAULT NULL,
  `production_orders_set` tinyint(4) DEFAULT NULL,
  `simulation_started` tinyint(4) DEFAULT NULL,
  `simulated` tinyint(4) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_PERIODSTATUS_GROUP_idx` (`group_id`),
  CONSTRAINT `FK_PERIODSTATUS_GROUP` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim_period_status`
--

LOCK TABLES `sim_period_status` WRITE;
/*!40000 ALTER TABLE `sim_period_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `sim_period_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim_production_orders`
--

DROP TABLE IF EXISTS `sim_production_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sim_production_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period` int(11) DEFAULT NULL,
  `cd_machine_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `production_order_id` int(11) DEFAULT NULL,
  `finished` tinyint(4) DEFAULT NULL,
  `finish_period` double DEFAULT NULL,
  `cycle_time` int(11) DEFAULT NULL,
  `elapsed_cycle_time` int(11) DEFAULT NULL,
  `costs` double DEFAULT NULL,
  `set_up_time` double DEFAULT NULL,
  `clearing_time` double DEFAULT NULL,
  `cd_workflow_id` int(11) DEFAULT NULL,
  `cd_step_id` int(11) DEFAULT NULL,
  `production_number` int(11) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `color_gantt` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT 'wait',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_PRODORDERS_GROUP_idx` (`group_id`),
  KEY `FK_SIMPRODORDER_PRODORDER_idx` (`production_order_id`),
  KEY `cd_workflow_id` (`cd_workflow_id`),
  KEY `sequence` (`sequence`),
  KEY `cd_machine_id` (`cd_machine_id`),
  CONSTRAINT `FK_SIMPRODORDER_GROUP` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_SIMPRODORDER_PRODORDER` FOREIGN KEY (`production_order_id`) REFERENCES `production_orders` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim_production_orders`
--

LOCK TABLES `sim_production_orders` WRITE;
/*!40000 ALTER TABLE `sim_production_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `sim_production_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim_results`
--

DROP TABLE IF EXISTS `sim_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sim_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `normal_capacity` int(11) DEFAULT NULL,
  `possible_capacity` int(11) DEFAULT NULL,
  `capacity_ratio` double DEFAULT NULL,
  `productive_time` int(11) DEFAULT NULL,
  `efficiency` double DEFAULT NULL,
  `sales` int(11) DEFAULT NULL,
  `sales_quantity` int(11) DEFAULT NULL,
  `delivery_reliability` double DEFAULT NULL,
  `idle_time` int(11) DEFAULT NULL,
  `idle_time_costs` double DEFAULT NULL,
  `stock_value` double DEFAULT NULL,
  `storage_costs` double DEFAULT NULL,
  `normal_sale_price` double DEFAULT NULL,
  `normal_sale_profit` double DEFAULT NULL,
  `normal_sale_profit_unit` double DEFAULT NULL,
  `summary` double DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim_results`
--

LOCK TABLES `sim_results` WRITE;
/*!40000 ALTER TABLE `sim_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `sim_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim_sellings`
--

DROP TABLE IF EXISTS `sim_sellings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sim_sellings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_product_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `end_price` double DEFAULT NULL,
  `ordered_amount` int(11) DEFAULT NULL,
  `delivery_reliability` double DEFAULT NULL,
  `selling_type` varchar(45) DEFAULT NULL,
  `to_group_id` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim_sellings`
--

LOCK TABLES `sim_sellings` WRITE;
/*!40000 ALTER TABLE `sim_sellings` DISABLE KEYS */;
/*!40000 ALTER TABLE `sim_sellings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim_waiting_products`
--

DROP TABLE IF EXISTS `sim_waiting_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sim_waiting_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `missing_product_id` int(11) DEFAULT NULL,
  `output_product_id` int(11) DEFAULT NULL,
  `cd_machine_id` int(11) DEFAULT NULL,
  `production_order_id` int(11) DEFAULT NULL,
  `sim_production_order_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_WAIT_MATERIAL_GROUPS_idx` (`group_id`),
  CONSTRAINT `FK_WAIT_MATERIAL_GROUPS` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim_waiting_products`
--

LOCK TABLES `sim_waiting_products` WRITE;
/*!40000 ALTER TABLE `sim_waiting_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `sim_waiting_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `source_informations`
--

DROP TABLE IF EXISTS `source_informations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `source_informations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=443 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `source_informations`
--

LOCK TABLES `source_informations` WRITE;
/*!40000 ALTER TABLE `source_informations` DISABLE KEYS */;
INSERT INTO `source_informations` VALUES (1,'app','This is a test!'),(2,'app','Games'),(3,'app','Choose Game'),(4,'app','Join Game'),(5,'app','Marketplace'),(6,'app','Profile'),(7,'app','Change Password'),(8,'app','Login'),(9,'app','Regsiter'),(10,'app','Gruppe wählen'),(11,'app','Game:'),(12,'app','Group:'),(13,'app','Period:'),(14,'app','Hello this is a long text! '),(15,'app','Machines'),(16,'app','Products'),(17,'app','Workflows'),(18,'app','Overview'),(19,'app','START'),(20,'app','Purchased part'),(21,'app','Subassembly'),(22,'app','Product'),(23,'app','Please wait while loading...'),(24,'app','Loading...'),(25,'app','Starting translation...'),(26,'app','Translation completed'),(27,'app','Get data from SCSIM...'),(28,'app','SCSIM data loaded'),(29,'app','Build Tree...'),(30,'app','Tree ready'),(31,'app','Standard'),(32,'app','Logout'),(33,'app','Save'),(34,'app','Discard all changes'),(35,'app','New'),(36,'app','Machine'),(37,'app','All changes will be lost! Are you sure?'),(38,'app','Inbox'),(39,'app',''),(40,'app','New Message'),(41,'app','State'),(42,'app','From'),(43,'app','Subject'),(44,'app','Date'),(45,'app','Options'),(46,'app','message'),(47,'app','Receivers'),(48,'app','Detail'),(49,'app','view of Message'),(50,'app','From:'),(51,'app','Date:'),(52,'app','Subject:'),(53,'app','reply'),(54,'app','remove'),(55,'app','Message:'),(56,'app','Back to Inbox'),(57,'app','Choose'),(58,'app','current game'),(59,'app','use this'),(60,'app','Edit or create a machine'),(61,'app','Cancel'),(62,'app','ID:'),(63,'app','none'),(64,'app','Description:'),(65,'app','Ident:'),(66,'app','Running costs:'),(67,'app','Fixed costs:'),(68,'app','Cost price:'),(69,'app','Replacement time:'),(70,'app','Replacement deviation:'),(71,'app','Gameset:'),(72,'app','periods'),(73,'app','Scan gamesets'),(74,'app','Scan completed'),(75,'app','Scand completed'),(76,'app','The GameSet is invalid!'),(77,'app','ID'),(78,'app','Description'),(79,'app','Ident'),(80,'app','Admin'),(81,'app','Running Costs'),(82,'app','Fixed Costs'),(83,'app','Cost Price'),(84,'app','Replacement Time'),(85,'app','Replacement Deviation'),(86,'app','Gameset'),(87,'app','Created'),(88,'app','You have to fill out all fields'),(89,'app','Edit or create a product'),(90,'app','Number:'),(91,'app','Value:'),(92,'app','Delivery costs:'),(93,'app','Delivery time:'),(94,'app','Delivery deviaton:'),(95,'app','Discount amount:'),(96,'app','Product kind:'),(97,'app','pc.'),(98,'app','Scan product kinds'),(99,'app','Edit'),(100,'app','Delete'),(101,'app','Add'),(102,'app','Would you like to delete the selected machine?'),(103,'app','WORKFLOW'),(104,'app','Add product to step'),(105,'app','Next Workplace to this one:'),(106,'app','Output product:'),(107,'app','Prepare GUI...'),(108,'app','GUI ready'),(109,'app','Choose a gameset'),(110,'app','What gameset should be used?'),(111,'app','Please choose a Gameset!'),(112,'app','How many pieces of this product should be added?'),(113,'app','Discard changes'),(114,'app','Save and close all'),(115,'app','Cycle time:'),(116,'app','Setup time:'),(117,'app','Clearing time:'),(118,'app','minutes'),(119,'app','Input parts:'),(120,'app','Amount'),(121,'app','New Workflow'),(122,'app','Delete step'),(123,'app','Circular connections are not allowed'),(124,'app','Several starting points in a workflow are not allowed'),(125,'app','You must specify a description'),(126,'app','Any unsaved changes will be lost! Are you sure?'),(127,'app','Saving is not possible as long as there are errors in the workflow'),(128,'app','You must specify a output product'),(129,'app','It is required at least one step'),(130,'app','Would you like to delete the selected workflow?'),(131,'app','Tree options'),(132,'app','Edit or create a gameset'),(133,'app','Would you like to delete the selected gameset?'),(134,'app','A workflow of the current gameset is open. Close it first!'),(135,'app','Email'),(136,'app','Password'),(137,'app','Remember me next time'),(138,'app','I forgot my password'),(139,'app','Reset'),(140,'app','Home'),(141,'app','Orders'),(142,'app','Planen'),(143,'app','Production Orders'),(144,'app','Shift Scheduling'),(145,'app','Save and proceed'),(146,'app','Save and simulate'),(147,'app','Shift Amount'),(148,'app','Overtime'),(149,'app','Group'),(150,'app','Period'),(151,'app','The Machine is invalid!'),(152,'app','Order Period'),(153,'app','There are no groups in the current game!'),(154,'app','Choose Group'),(155,'app','The group is invalid!'),(156,'app','The Product is invalid!'),(157,'app','Order Type'),(158,'app','Calculated Delivery Time'),(159,'app','Delivered'),(160,'app','Delivery Costs'),(161,'app','Unit Price'),(162,'app','Total Price'),(163,'app','End Price'),(164,'app','To use this function please choose a game!'),(165,'app','Your message has been send successfully!'),(166,'app','Inventory'),(167,'app','Group darf nicht leer sein.'),(168,'app','Product darf nicht leer sein.'),(169,'app','Product muss eine Zahl sein.'),(170,'app','Amount muss eine Zahl sein.'),(171,'app','Simulate now'),(172,'app','Overall stock value'),(173,'app','€'),(174,'app','Overall stock amount'),(175,'app','Zero stock products'),(176,'app','Article'),(177,'app','Current stock amount'),(178,'app','Old stock amount'),(179,'app','Current stock value'),(180,'app','Old stock value'),(181,'app','Start stock amount'),(182,'app','Amount darf nicht leer sein.'),(183,'app','Maximum shift amount is 3!'),(184,'app','Maximum ovetime is 3600 (1200 per shift)!'),(185,'app','Edit Profile'),(186,'app','your profile'),(187,'app','Prename'),(188,'app','Lastname'),(189,'app','Organisation'),(190,'app','Password Crypted'),(191,'app','Blocked'),(192,'app','Gamekey'),(193,'app','Password repeat'),(194,'app','Old password'),(195,'app','Is a administrator'),(196,'app','Administration'),(197,'app','Manage Games'),(198,'app','Manage User'),(199,'app','Status'),(200,'app','Is a moderator'),(201,'app','userindex'),(202,'app','Users'),(203,'app','Administration of Users'),(204,'app','E-Mail'),(205,'app','Administrator'),(206,'app','User'),(207,'app','Moderator'),(208,'app','No Filter'),(209,'app','Optionen'),(210,'app','Do you want to delete {user}?'),(211,'app','Do you want to block {user}?'),(212,'app','Do you want to unblock {user}?'),(213,'app','Valid until'),(214,'app','unlimited'),(215,'app','Please ask your trainer for this!'),(216,'app','groups'),(217,'app','Maximal Groups'),(218,'app','Maximal Games'),(219,'app','Maximal User per Group'),(220,'app','Maximal User/Group'),(221,'app','Manage '),(222,'app','Data successfully changed!'),(223,'app','Please check the errors below!'),(224,'app','Administration of Games'),(225,'app','Game Name'),(226,'app','Game Key'),(227,'app','Game Set'),(228,'app','Do you want to delete {game}?'),(229,'app','empty'),(230,'app','2 of3users'),(231,'app','0 of3users'),(232,'app','(2 of 3 users)'),(233,'app','(0 of 3 users)'),(234,'app',' (2 of 3 users)'),(235,'app',' (0 of 3 users)'),(236,'app','Do you want to really want to remove {user} from {group}?'),(237,'app',' (9 of 10 users)'),(238,'app',' (0 of 10 users)'),(239,'app',' (1 of 10 users)'),(240,'app',' (1 of 3 users)'),(241,'app',' (-1 of 3 users)'),(242,'app',' (-2 of 3 users)'),(243,'app','Game'),(244,'app',' (-3 of 3 users)'),(245,'app',' (-4 of 3 users)'),(246,'app',' (-5 of 3 users)'),(247,'app','no member of a group'),(248,'app','Join now!'),(249,'app','{usercount} of {usermax} members are in the group'),(250,'app','You have joined the chosen group!'),(251,'app','You are no admin!'),(252,'app','Create Game'),(253,'app',' Create a new game'),(254,'app','Create'),(255,'app','Group count'),(256,'app','User per group'),(257,'app','The Game is invalid!'),(258,'app',' ( of 5 users)'),(259,'app','Select your GameSet'),(260,'app','Join'),(261,'app','to a additional game'),(262,'app','You will get your key from your trainer!'),(263,'app','Gamekey not valid!'),(264,'app','Name'),(265,'app','Group {i}'),(266,'app','New Game'),(267,'app',' (0 of 111 users)'),(268,'app','Successfully joined the game!'),(269,'app',' (1 of 5 users)'),(270,'app',' (0 of 5 users)'),(271,'app','Group is full'),(272,'app','Reset Period'),(273,'app','Wage Shift 1:'),(274,'app','Wage Shift 2:'),(275,'app','Wage Shift 3:'),(276,'app','Wage Overtime:'),(277,'app',' (1 of 1 users)'),(278,'app','Current period: {p}'),(279,'app','Reset to Period {p}'),(280,'app',' (0 of 2 users)'),(281,'app','Current stock value per piece'),(282,'app','Old stock value per piece'),(283,'app','Quantity/StartQuantity'),(284,'app','Stock'),(285,'app','Arrival Parts'),(286,'app','Order number'),(287,'app','Order mode'),(288,'app','Quantity'),(289,'app','Finished'),(290,'app','Material costs'),(291,'app','Order costs'),(292,'app','Entire costs'),(293,'app','Piece costs'),(294,'app','Eil'),(295,'app','Normal'),(296,'app','Period: {period} Day: {day}'),(297,'app','Period: {period} -  Day: {day}'),(298,'app','Period: {period}-{day}'),(299,'app','{period}-{day}-0-0'),(300,'app',' (1 of 2 users)'),(301,'app','Missing Parts'),(302,'app','Lower quantile'),(303,'app','Upper quantile'),(304,'app','Inward stock movement'),(305,'app','Day'),(306,'app','Detail of Product'),(307,'app','Create machines to simulate'),(308,'app','Prepare Stock for the new period'),(309,'app','Split production orders'),(310,'app','Create events for machines and orders'),(311,'app','Simulation ready'),(312,'app','Go to startpage'),(313,'app','Simulation processing'),(314,'app','Admin Choose Group'),(315,'app','Switch'),(316,'app','To use this function please choose a group!'),(317,'app','Choose Period'),(318,'app','current period'),(319,'app','Gantt for machines'),(320,'app','Gantt'),(321,'app','for machines'),(322,'app','Other teammember has already started simulation!'),(323,'app','Amount cannot be blank.'),(324,'app','Day 1'),(325,'app','Day 2'),(326,'app','Day 3'),(327,'app','Day 4'),(328,'app','Day 5'),(329,'app','Product:'),(330,'app','Order period:'),(331,'app','Total order amount:'),(332,'app','End product:'),(333,'app','Single order amount:'),(334,'app','Further informations'),(335,'app','pieces'),(336,'app','Total costs:'),(337,'app','Total setup time:'),(338,'app','Create events for orders'),(339,'app','Simulation sarted...'),(340,'app','Simulation started...'),(341,'app','Simulation in progress...'),(342,'app','Period events'),(343,'app','Edit or create a Period event'),(344,'app','Solid Sales'),(345,'app','Additional Sales'),(346,'app','No data to display'),(347,'app','Period event'),(348,'app','Upload Simulation Data'),(349,'app','Upload'),(350,'app',' simulation data'),(351,'app','Reset Password'),(352,'app',' password for SCSIM'),(353,'app','Register'),(354,'app',' on SCSIM Phönix'),(355,'app','Change'),(356,'app','password for SCSIM'),(357,'app','Password successfully changed!'),(358,'app','The Product  \"{product}\" is invalid!'),(359,'app','Cd Product cannot be blank.'),(360,'app','The Product  \"\" is invalid!'),(361,'app','Current played period: {p}'),(362,'app','Currently no period played'),(363,'app','Filetransfer'),(364,'app','Download'),(365,'app','Operating numbers'),(366,'app','Value'),(367,'app','unfinished batches'),(368,'app','simulation time'),(369,'app','Cd Product must be a number.'),(370,'app','The Product  \"njijnik\" is invalid!'),(371,'app','#'),(372,'app','€/min '),(373,'app','Result'),(374,'app','Current result'),(375,'app','Avarage of all periods'),(376,'app','Quantity of all periods'),(377,'app','Normal capacity'),(378,'app','Possible capacity'),(379,'app','Capacity ration'),(380,'app','%'),(381,'app','Productive time'),(382,'app','Efficiency'),(383,'app','Sales'),(384,'app','Sales Quantity'),(385,'app','Delivery reliability'),(386,'app','Idle time'),(387,'app','Stock value'),(388,'app','Storage costs'),(389,'app','Normal sale'),(390,'app','Sales price'),(391,'app','Profit'),(392,'app','Profit/Units'),(393,'app','Summary'),(394,'app','Sum of all periods'),(395,'app','Work place'),(396,'app','Setup events'),(397,'app','Wage idle time costs'),(398,'app','Wage costs'),(399,'app','Machine idle time costs'),(400,'app','Shift Amount muss eine Zahl sein.'),(401,'app','Back to orders'),(402,'app','Back to production orders'),(403,'app','Dashboard'),(404,'app','Shift Amount ist zu groß (Maximum ist 3).'),(405,'app','Shift Amount darf nicht leer sein.'),(406,'app','The Product  \"dsfg\" is invalid!'),(407,'app','ready'),(408,'app','Order id'),(409,'app','Gantt color'),(410,'app','not ready'),(411,'app','Amount finished'),(412,'app','Time need'),(413,'app','Benchmark of group results'),(414,'app','Benchmark of group sales'),(415,'app','Benchmark of group sales wishes'),(416,'app','Sales wishes'),(417,'app','Benchmark of stock value'),(418,'app','Benchmark of delivery reliability'),(419,'app','Percent'),(420,'app','Benchmark of group idle time costs'),(421,'app','Idle time costs'),(422,'app','Benchmark of group idle time'),(423,'app','Benchmark of group overall results'),(424,'app','Overall result'),(425,'app','Benchmark of group storage costs'),(426,'app','Benchmark of group productivity'),(427,'app','Productivity'),(428,'app','Benchmark of group production efficiency'),(429,'app','Production efficiency'),(430,'app','Benchmark of group delivery reliability'),(431,'app','Benchmark of group capacity ratio'),(432,'app','Capacity ratio'),(433,'app','Benchmark of capacity ratio'),(434,'app','Benchmark of group profit/unit'),(435,'app','Profit/Unit'),(436,'app','Benchmark'),(437,'app','Sale'),(438,'app','Sell wish'),(439,'app','Workload'),(440,'app','Benchmark of group sell wishes'),(441,'app','Sell wishes'),(442,'app','Benchmark of group stock value');
/*!40000 ALTER TABLE `source_informations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_rotations`
--

DROP TABLE IF EXISTS `stock_rotations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_rotations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_product_id` int(11) NOT NULL COMMENT 'ID des Produktes',
  `group_id` int(11) NOT NULL COMMENT 'ID der Gruppe',
  `period` double NOT NULL COMMENT 'Periode der Änderung',
  `sim_time` int(11) NOT NULL COMMENT 'Simulationszeit der Änderung',
  `amount` int(11) NOT NULL DEFAULT '0' COMMENT 'Stückzahl positiv/negativ',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_STOCK_ROTATION_GROUP_ID_idx` (`group_id`),
  KEY `FK_STOCK_ROTATION_PRODUCT_ID_idx` (`cd_product_id`),
  CONSTRAINT `FK_STOCK_ROTATION_GROUP_ID` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_STOCK_ROTATION_PRODUCT_ID` FOREIGN KEY (`cd_product_id`) REFERENCES `cd_products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_rotations`
--

LOCK TABLES `stock_rotations` WRITE;
/*!40000 ALTER TABLE `stock_rotations` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_rotations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_product_id` int(11) NOT NULL COMMENT 'ID des Produktes',
  `group_id` int(11) NOT NULL COMMENT 'ID der Gruppe',
  `period` int(11) NOT NULL COMMENT 'Periode des Lagerbestandes',
  `amount` int(11) NOT NULL COMMENT 'Anzahl der Lagerteile',
  `price` double DEFAULT NULL COMMENT 'Durchschnittspreis der Teile',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Erstellt am',
  PRIMARY KEY (`id`),
  KEY `FK_STOCKS_GROUPS_idx` (`group_id`),
  CONSTRAINT `FK_STOCKS_GROUPS` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translated_informations`
--

DROP TABLE IF EXISTS `translated_informations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translated_informations` (
  `id` int(11) NOT NULL DEFAULT '0',
  `language` varchar(16) NOT NULL DEFAULT '',
  `translation` text,
  PRIMARY KEY (`id`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translated_informations`
--

LOCK TABLES `translated_informations` WRITE;
/*!40000 ALTER TABLE `translated_informations` DISABLE KEYS */;
INSERT INTO `translated_informations` VALUES (1,'de','Das ist ein Test!'),(1,'el',NULL),(1,'es',NULL),(1,'fr',NULL),(1,'it',NULL),(1,'ja',NULL),(1,'pl',NULL),(1,'ru',NULL),(2,'de',NULL),(2,'el',NULL),(2,'es',NULL),(2,'fr',NULL),(2,'gr',NULL),(2,'it',NULL),(2,'ja',NULL),(2,'pl',NULL),(2,'ru',NULL),(3,'de',NULL),(3,'el',NULL),(3,'es',NULL),(3,'fr',NULL),(3,'gr',NULL),(3,'it',NULL),(3,'ja',NULL),(3,'pl',NULL),(3,'ru',NULL),(4,'de',NULL),(4,'el',NULL),(4,'es',NULL),(4,'fr',NULL),(4,'gr',NULL),(4,'it',NULL),(4,'ja',NULL),(4,'pl',NULL),(4,'ru',NULL),(5,'de',NULL),(5,'el',NULL),(5,'es',NULL),(5,'fr',NULL),(5,'gr',NULL),(5,'it',NULL),(5,'ja',NULL),(5,'pl',NULL),(5,'ru',NULL),(6,'de',NULL),(6,'el',NULL),(6,'es',NULL),(6,'fr',NULL),(6,'gr',NULL),(6,'it',NULL),(6,'ja',NULL),(6,'pl',NULL),(6,'ru',NULL),(7,'de',NULL),(7,'el',NULL),(7,'es',NULL),(7,'fr',NULL),(7,'gr',NULL),(7,'it',NULL),(7,'ja',NULL),(7,'pl',NULL),(7,'ru',NULL),(8,'de',NULL),(8,'el',NULL),(8,'es',NULL),(8,'fr',NULL),(8,'gr',NULL),(8,'it',NULL),(8,'ja',NULL),(8,'pl',NULL),(8,'ru',NULL),(9,'de',NULL),(9,'el',NULL),(9,'es',NULL),(9,'fr',NULL),(9,'gr',NULL),(9,'it',NULL),(9,'ja',NULL),(9,'pl',NULL),(9,'ru',NULL),(10,'de',NULL),(10,'el',NULL),(10,'es',NULL),(10,'fr',NULL),(10,'gr',NULL),(10,'it',NULL),(10,'ja',NULL),(10,'pl',NULL),(10,'ru',NULL),(11,'de',NULL),(11,'el',NULL),(11,'es',NULL),(11,'fr',NULL),(11,'gr',NULL),(11,'it',NULL),(11,'ja',NULL),(11,'pl',NULL),(11,'ru',NULL),(12,'de',NULL),(12,'el',NULL),(12,'es',NULL),(12,'fr',NULL),(12,'gr',NULL),(12,'it',NULL),(12,'ja',NULL),(12,'pl',NULL),(12,'ru',NULL),(13,'de',NULL),(13,'el',NULL),(13,'es',NULL),(13,'fr',NULL),(13,'gr',NULL),(13,'it',NULL),(13,'ja',NULL),(13,'pl',NULL),(13,'ru',NULL),(14,'de',NULL),(14,'es',NULL),(14,'fr',NULL),(14,'gr',NULL),(14,'it',NULL),(14,'ja',NULL),(14,'pl',NULL),(14,'ru',NULL),(15,'de',NULL),(15,'el',NULL),(15,'es',NULL),(15,'fr',NULL),(15,'gr',NULL),(15,'it',NULL),(15,'ja',NULL),(15,'pl',NULL),(15,'ru',NULL),(16,'de',NULL),(16,'el',NULL),(16,'es',NULL),(16,'fr',NULL),(16,'gr',NULL),(16,'it',NULL),(16,'ja',NULL),(16,'pl',NULL),(16,'ru',NULL),(17,'de',NULL),(17,'el',NULL),(17,'es',NULL),(17,'fr',NULL),(17,'gr',NULL),(17,'it',NULL),(17,'ja',NULL),(17,'pl',NULL),(17,'ru',NULL),(18,'de','Übersicht'),(18,'el',NULL),(18,'es',NULL),(18,'fr',NULL),(18,'gr',NULL),(18,'it',NULL),(18,'ja',NULL),(18,'pl',NULL),(18,'ru',NULL),(19,'de',NULL),(19,'el',NULL),(19,'es',NULL),(19,'fr',NULL),(19,'gr',NULL),(19,'it',NULL),(19,'ja',NULL),(19,'pl',NULL),(19,'ru',NULL),(20,'de',NULL),(20,'el',NULL),(20,'es',NULL),(20,'fr',NULL),(20,'gr',NULL),(20,'it',NULL),(20,'ja',NULL),(20,'pl',NULL),(20,'ru',NULL),(21,'de',NULL),(21,'el',NULL),(21,'es',NULL),(21,'fr',NULL),(21,'gr',NULL),(21,'it',NULL),(21,'ja',NULL),(21,'pl',NULL),(21,'ru',NULL),(22,'de',NULL),(22,'el',NULL),(22,'es',NULL),(22,'fr',NULL),(22,'gr',NULL),(22,'it',NULL),(22,'ja',NULL),(22,'pl',NULL),(22,'ru',NULL),(23,'de',NULL),(23,'el',NULL),(23,'es',NULL),(23,'fr',NULL),(23,'gr',NULL),(23,'it',NULL),(23,'ja',NULL),(23,'pl',NULL),(23,'ru',NULL),(24,'de',NULL),(24,'el',NULL),(24,'es',NULL),(24,'fr',NULL),(24,'gr',NULL),(24,'it',NULL),(24,'ja',NULL),(24,'pl',NULL),(24,'ru',NULL),(25,'de','Übersetzungen laden...'),(25,'el',NULL),(25,'es',NULL),(25,'fr',NULL),(25,'gr',NULL),(25,'it',NULL),(25,'ja',NULL),(25,'pl',NULL),(25,'ru',NULL),(26,'de','Übersetzung geladen'),(26,'el',NULL),(26,'es',NULL),(26,'fr',NULL),(26,'gr',NULL),(26,'it',NULL),(26,'ja',NULL),(26,'pl',NULL),(26,'ru',NULL),(27,'de','Daten von SCSIM laden...'),(27,'el',NULL),(27,'es',NULL),(27,'fr',NULL),(27,'gr',NULL),(27,'it',NULL),(27,'ja',NULL),(27,'pl',NULL),(27,'ru',NULL),(28,'de','SCSIM Daten geladen'),(28,'el',NULL),(28,'es',NULL),(28,'fr',NULL),(28,'gr',NULL),(28,'it',NULL),(28,'ja',NULL),(28,'pl',NULL),(28,'ru',NULL),(29,'de','Baum erstellen...'),(29,'el',NULL),(29,'es',NULL),(29,'fr',NULL),(29,'gr',NULL),(29,'it',NULL),(29,'ja',NULL),(29,'pl',NULL),(29,'ru',NULL),(30,'de','Baum erstellt'),(30,'el',NULL),(30,'es',NULL),(30,'fr',NULL),(30,'gr',NULL),(30,'it',NULL),(30,'ja',NULL),(30,'pl',NULL),(30,'ru',NULL),(31,'de',NULL),(31,'el',NULL),(31,'es',NULL),(31,'fr',NULL),(31,'gr',NULL),(31,'it',NULL),(31,'ja',NULL),(31,'pl',NULL),(31,'ru',NULL),(32,'de',NULL),(32,'el',NULL),(32,'es',NULL),(32,'fr',NULL),(32,'gr',NULL),(32,'it',NULL),(32,'ja',NULL),(32,'pl',NULL),(32,'ru',NULL),(33,'de',NULL),(33,'el',NULL),(33,'es',NULL),(33,'fr',NULL),(33,'gr',NULL),(33,'it',NULL),(33,'ja',NULL),(33,'pl',NULL),(33,'ru',NULL),(34,'de',NULL),(34,'el',NULL),(34,'es',NULL),(34,'fr',NULL),(34,'gr',NULL),(34,'it',NULL),(34,'ja',NULL),(34,'pl',NULL),(34,'ru',NULL),(35,'de',NULL),(35,'el',NULL),(35,'es',NULL),(35,'fr',NULL),(35,'gr',NULL),(35,'it',NULL),(35,'ja',NULL),(35,'pl',NULL),(35,'ru',NULL),(36,'de',NULL),(36,'el',NULL),(36,'es',NULL),(36,'fr',NULL),(36,'gr',NULL),(36,'it',NULL),(36,'ja',NULL),(36,'pl',NULL),(36,'ru',NULL),(37,'de',NULL),(37,'es',NULL),(37,'fr',NULL),(37,'gr',NULL),(37,'it',NULL),(37,'ja',NULL),(37,'pl',NULL),(37,'ru',NULL),(38,'de',NULL),(38,'el',NULL),(38,'es',NULL),(38,'fr',NULL),(38,'gr',NULL),(38,'it',NULL),(38,'ja',NULL),(38,'pl',NULL),(38,'ru',NULL),(39,'de',NULL),(39,'el',NULL),(39,'es',NULL),(39,'fr',NULL),(39,'gr',NULL),(39,'it',NULL),(39,'ja',NULL),(39,'pl',NULL),(39,'ru',NULL),(40,'de',NULL),(40,'el',NULL),(40,'es',NULL),(40,'fr',NULL),(40,'gr',NULL),(40,'it',NULL),(40,'ja',NULL),(40,'pl',NULL),(40,'ru',NULL),(41,'de',NULL),(41,'el',NULL),(41,'es',NULL),(41,'fr',NULL),(41,'gr',NULL),(41,'it',NULL),(41,'ja',NULL),(41,'pl',NULL),(41,'ru',NULL),(42,'de',NULL),(42,'el',NULL),(42,'es',NULL),(42,'fr',NULL),(42,'gr',NULL),(42,'it',NULL),(42,'ja',NULL),(42,'pl',NULL),(42,'ru',NULL),(43,'de',NULL),(43,'el',NULL),(43,'es',NULL),(43,'fr',NULL),(43,'gr',NULL),(43,'it',NULL),(43,'ja',NULL),(43,'pl',NULL),(43,'ru',NULL),(44,'de',NULL),(44,'el',NULL),(44,'es',NULL),(44,'fr',NULL),(44,'gr',NULL),(44,'it',NULL),(44,'ja',NULL),(44,'pl',NULL),(44,'ru',NULL),(45,'de',NULL),(45,'el',NULL),(45,'es',NULL),(45,'fr',NULL),(45,'gr',NULL),(45,'it',NULL),(45,'ja',NULL),(45,'pl',NULL),(45,'ru',NULL),(46,'de',NULL),(46,'el',NULL),(46,'es',NULL),(46,'fr',NULL),(46,'gr',NULL),(46,'it',NULL),(46,'ja',NULL),(46,'pl',NULL),(46,'ru',NULL),(47,'de',NULL),(47,'el',NULL),(47,'es',NULL),(47,'fr',NULL),(47,'gr',NULL),(47,'it',NULL),(47,'ja',NULL),(47,'pl',NULL),(47,'ru',NULL),(48,'de',NULL),(48,'el',NULL),(48,'es',NULL),(48,'fr',NULL),(48,'gr',NULL),(48,'it',NULL),(48,'ja',NULL),(48,'pl',NULL),(48,'ru',NULL),(49,'de',NULL),(49,'el',NULL),(49,'es',NULL),(49,'fr',NULL),(49,'gr',NULL),(49,'it',NULL),(49,'ja',NULL),(49,'pl',NULL),(49,'ru',NULL),(50,'de',NULL),(50,'el',NULL),(50,'es',NULL),(50,'fr',NULL),(50,'gr',NULL),(50,'it',NULL),(50,'ja',NULL),(50,'pl',NULL),(50,'ru',NULL),(51,'de',NULL),(51,'el',NULL),(51,'es',NULL),(51,'fr',NULL),(51,'gr',NULL),(51,'it',NULL),(51,'ja',NULL),(51,'pl',NULL),(51,'ru',NULL),(52,'de',NULL),(52,'el',NULL),(52,'es',NULL),(52,'fr',NULL),(52,'gr',NULL),(52,'it',NULL),(52,'ja',NULL),(52,'pl',NULL),(52,'ru',NULL),(53,'de',NULL),(53,'el',NULL),(53,'es',NULL),(53,'fr',NULL),(53,'gr',NULL),(53,'it',NULL),(53,'ja',NULL),(53,'pl',NULL),(53,'ru',NULL),(54,'de',NULL),(54,'el',NULL),(54,'es',NULL),(54,'fr',NULL),(54,'gr',NULL),(54,'it',NULL),(54,'ja',NULL),(54,'pl',NULL),(54,'ru',NULL),(55,'de',NULL),(55,'el',NULL),(55,'es',NULL),(55,'fr',NULL),(55,'gr',NULL),(55,'it',NULL),(55,'ja',NULL),(55,'pl',NULL),(55,'ru',NULL),(56,'de',NULL),(56,'el',NULL),(56,'es',NULL),(56,'fr',NULL),(56,'gr',NULL),(56,'it',NULL),(56,'ja',NULL),(56,'pl',NULL),(56,'ru',NULL),(57,'de',NULL),(57,'el',NULL),(57,'es',NULL),(57,'fr',NULL),(57,'gr',NULL),(57,'it',NULL),(57,'ja',NULL),(57,'pl',NULL),(57,'ru',NULL),(58,'de',NULL),(58,'el',NULL),(58,'es',NULL),(58,'fr',NULL),(58,'gr',NULL),(58,'it',NULL),(58,'ja',NULL),(58,'pl',NULL),(58,'ru',NULL),(59,'de',NULL),(59,'el',NULL),(59,'es',NULL),(59,'fr',NULL),(59,'gr',NULL),(59,'it',NULL),(59,'ja',NULL),(59,'pl',NULL),(59,'ru',NULL),(60,'de',NULL),(60,'el',NULL),(60,'es',NULL),(60,'fr',NULL),(60,'gr',NULL),(60,'it',NULL),(60,'ja',NULL),(60,'pl',NULL),(60,'ru',NULL),(61,'de',NULL),(61,'el',NULL),(61,'es',NULL),(61,'fr',NULL),(61,'gr',NULL),(61,'it',NULL),(61,'ja',NULL),(61,'pl',NULL),(61,'ru',NULL),(62,'de',NULL),(62,'el',NULL),(62,'es',NULL),(62,'fr',NULL),(62,'gr',NULL),(62,'it',NULL),(62,'ja',NULL),(62,'pl',NULL),(62,'ru',NULL),(63,'de',NULL),(63,'el',NULL),(63,'es',NULL),(63,'fr',NULL),(63,'gr',NULL),(63,'it',NULL),(63,'ja',NULL),(63,'pl',NULL),(63,'ru',NULL),(64,'de',NULL),(64,'el',NULL),(64,'es',NULL),(64,'fr',NULL),(64,'gr',NULL),(64,'it',NULL),(64,'ja',NULL),(64,'pl',NULL),(64,'ru',NULL),(65,'de',NULL),(65,'el',NULL),(65,'es',NULL),(65,'fr',NULL),(65,'gr',NULL),(65,'it',NULL),(65,'ja',NULL),(65,'pl',NULL),(65,'ru',NULL),(66,'de',NULL),(66,'el',NULL),(66,'es',NULL),(66,'fr',NULL),(66,'gr',NULL),(66,'it',NULL),(66,'ja',NULL),(66,'pl',NULL),(66,'ru',NULL),(67,'de',NULL),(67,'el',NULL),(67,'es',NULL),(67,'fr',NULL),(67,'gr',NULL),(67,'it',NULL),(67,'ja',NULL),(67,'pl',NULL),(67,'ru',NULL),(68,'de',NULL),(68,'el',NULL),(68,'es',NULL),(68,'fr',NULL),(68,'gr',NULL),(68,'it',NULL),(68,'ja',NULL),(68,'pl',NULL),(68,'ru',NULL),(69,'de',NULL),(69,'el',NULL),(69,'es',NULL),(69,'fr',NULL),(69,'gr',NULL),(69,'it',NULL),(69,'ja',NULL),(69,'pl',NULL),(69,'ru',NULL),(70,'de',NULL),(70,'el',NULL),(70,'es',NULL),(70,'fr',NULL),(70,'gr',NULL),(70,'it',NULL),(70,'ja',NULL),(70,'pl',NULL),(70,'ru',NULL),(71,'de',NULL),(71,'el',NULL),(71,'es',NULL),(71,'fr',NULL),(71,'gr',NULL),(71,'it',NULL),(71,'ja',NULL),(71,'pl',NULL),(71,'ru',NULL),(72,'de',NULL),(72,'el',NULL),(72,'es',NULL),(72,'fr',NULL),(72,'gr',NULL),(72,'it',NULL),(72,'ja',NULL),(72,'pl',NULL),(72,'ru',NULL),(73,'de',NULL),(73,'el',NULL),(73,'es',NULL),(73,'fr',NULL),(73,'gr',NULL),(73,'it',NULL),(73,'ja',NULL),(73,'pl',NULL),(73,'ru',NULL),(74,'de',NULL),(74,'el',NULL),(74,'es',NULL),(74,'fr',NULL),(74,'gr',NULL),(74,'it',NULL),(74,'ja',NULL),(74,'pl',NULL),(74,'ru',NULL),(75,'de',NULL),(75,'es',NULL),(75,'fr',NULL),(75,'gr',NULL),(75,'it',NULL),(75,'ja',NULL),(75,'pl',NULL),(75,'ru',NULL),(76,'de',NULL),(76,'el',NULL),(76,'es',NULL),(76,'fr',NULL),(76,'gr',NULL),(76,'it',NULL),(76,'ja',NULL),(76,'pl',NULL),(76,'ru',NULL),(77,'de',NULL),(77,'el',NULL),(77,'es',NULL),(77,'fr',NULL),(77,'gr',NULL),(77,'it',NULL),(77,'ja',NULL),(77,'pl',NULL),(77,'ru',NULL),(78,'de',NULL),(78,'el',NULL),(78,'es',NULL),(78,'fr',NULL),(78,'gr',NULL),(78,'it',NULL),(78,'ja',NULL),(78,'pl',NULL),(78,'ru',NULL),(79,'de',NULL),(79,'el',NULL),(79,'es',NULL),(79,'fr',NULL),(79,'gr',NULL),(79,'it',NULL),(79,'ja',NULL),(79,'pl',NULL),(79,'ru',NULL),(80,'de',NULL),(80,'el',NULL),(80,'es',NULL),(80,'fr',NULL),(80,'gr',NULL),(80,'it',NULL),(80,'ja',NULL),(80,'pl',NULL),(80,'ru',NULL),(81,'de',NULL),(81,'el',NULL),(81,'es',NULL),(81,'fr',NULL),(81,'gr',NULL),(81,'it',NULL),(81,'ja',NULL),(81,'pl',NULL),(81,'ru',NULL),(82,'de',NULL),(82,'el',NULL),(82,'es',NULL),(82,'fr',NULL),(82,'gr',NULL),(82,'it',NULL),(82,'ja',NULL),(82,'pl',NULL),(82,'ru',NULL),(83,'de',NULL),(83,'el',NULL),(83,'es',NULL),(83,'fr',NULL),(83,'gr',NULL),(83,'it',NULL),(83,'ja',NULL),(83,'pl',NULL),(83,'ru',NULL),(84,'de',NULL),(84,'el',NULL),(84,'es',NULL),(84,'fr',NULL),(84,'gr',NULL),(84,'it',NULL),(84,'ja',NULL),(84,'pl',NULL),(84,'ru',NULL),(85,'de',NULL),(85,'el',NULL),(85,'es',NULL),(85,'fr',NULL),(85,'gr',NULL),(85,'it',NULL),(85,'ja',NULL),(85,'pl',NULL),(85,'ru',NULL),(86,'de',NULL),(86,'el',NULL),(86,'es',NULL),(86,'fr',NULL),(86,'gr',NULL),(86,'it',NULL),(86,'ja',NULL),(86,'pl',NULL),(86,'ru',NULL),(87,'de',NULL),(87,'el',NULL),(87,'es',NULL),(87,'fr',NULL),(87,'gr',NULL),(87,'it',NULL),(87,'ja',NULL),(87,'pl',NULL),(87,'ru',NULL),(88,'de',NULL),(88,'el',NULL),(88,'es',NULL),(88,'fr',NULL),(88,'gr',NULL),(88,'it',NULL),(88,'ja',NULL),(88,'pl',NULL),(88,'ru',NULL),(89,'de',NULL),(89,'es',NULL),(89,'fr',NULL),(89,'gr',NULL),(89,'it',NULL),(89,'ja',NULL),(89,'pl',NULL),(89,'ru',NULL),(90,'de',NULL),(90,'es',NULL),(90,'fr',NULL),(90,'gr',NULL),(90,'it',NULL),(90,'ja',NULL),(90,'pl',NULL),(90,'ru',NULL),(91,'de',NULL),(91,'es',NULL),(91,'fr',NULL),(91,'gr',NULL),(91,'it',NULL),(91,'ja',NULL),(91,'pl',NULL),(91,'ru',NULL),(92,'de',NULL),(92,'es',NULL),(92,'fr',NULL),(92,'gr',NULL),(92,'it',NULL),(92,'ja',NULL),(92,'pl',NULL),(92,'ru',NULL),(93,'de',NULL),(93,'es',NULL),(93,'fr',NULL),(93,'gr',NULL),(93,'it',NULL),(93,'ja',NULL),(93,'pl',NULL),(93,'ru',NULL),(94,'de',NULL),(94,'es',NULL),(94,'fr',NULL),(94,'gr',NULL),(94,'it',NULL),(94,'ja',NULL),(94,'pl',NULL),(94,'ru',NULL),(95,'de',NULL),(95,'es',NULL),(95,'fr',NULL),(95,'gr',NULL),(95,'it',NULL),(95,'ja',NULL),(95,'pl',NULL),(95,'ru',NULL),(96,'de',NULL),(96,'es',NULL),(96,'fr',NULL),(96,'gr',NULL),(96,'it',NULL),(96,'ja',NULL),(96,'pl',NULL),(96,'ru',NULL),(97,'de',NULL),(97,'es',NULL),(97,'fr',NULL),(97,'gr',NULL),(97,'it',NULL),(97,'ja',NULL),(97,'pl',NULL),(97,'ru',NULL),(98,'de',NULL),(98,'es',NULL),(98,'fr',NULL),(98,'gr',NULL),(98,'it',NULL),(98,'ja',NULL),(98,'pl',NULL),(98,'ru',NULL),(99,'de',NULL),(99,'el',NULL),(99,'es',NULL),(99,'fr',NULL),(99,'gr',NULL),(99,'it',NULL),(99,'ja',NULL),(99,'pl',NULL),(99,'ru',NULL),(100,'de',NULL),(100,'el',NULL),(100,'es',NULL),(100,'fr',NULL),(100,'gr',NULL),(100,'it',NULL),(100,'ja',NULL),(100,'pl',NULL),(100,'ru',NULL),(101,'de',NULL),(101,'el',NULL),(101,'es',NULL),(101,'fr',NULL),(101,'gr',NULL),(101,'it',NULL),(101,'ja',NULL),(101,'pl',NULL),(101,'ru',NULL),(102,'de',NULL),(102,'es',NULL),(102,'fr',NULL),(102,'gr',NULL),(102,'it',NULL),(102,'ja',NULL),(102,'pl',NULL),(102,'ru',NULL),(103,'de',NULL),(103,'el',NULL),(103,'es',NULL),(103,'fr',NULL),(103,'gr',NULL),(103,'it',NULL),(103,'ja',NULL),(103,'pl',NULL),(103,'ru',NULL),(104,'de',NULL),(104,'es',NULL),(104,'fr',NULL),(104,'gr',NULL),(104,'it',NULL),(104,'ja',NULL),(104,'pl',NULL),(104,'ru',NULL),(105,'de',NULL),(105,'es',NULL),(105,'fr',NULL),(105,'gr',NULL),(105,'it',NULL),(105,'ja',NULL),(105,'pl',NULL),(105,'ru',NULL),(106,'de',NULL),(106,'es',NULL),(106,'fr',NULL),(106,'gr',NULL),(106,'it',NULL),(106,'ja',NULL),(106,'pl',NULL),(106,'ru',NULL),(107,'de',NULL),(107,'el',NULL),(107,'es',NULL),(107,'fr',NULL),(107,'gr',NULL),(107,'it',NULL),(107,'ja',NULL),(107,'pl',NULL),(107,'ru',NULL),(108,'de',NULL),(108,'el',NULL),(108,'es',NULL),(108,'fr',NULL),(108,'gr',NULL),(108,'it',NULL),(108,'ja',NULL),(108,'pl',NULL),(108,'ru',NULL),(109,'de',NULL),(109,'es',NULL),(109,'fr',NULL),(109,'gr',NULL),(109,'it',NULL),(109,'ja',NULL),(109,'pl',NULL),(109,'ru',NULL),(110,'de',NULL),(110,'es',NULL),(110,'fr',NULL),(110,'gr',NULL),(110,'it',NULL),(110,'ja',NULL),(110,'pl',NULL),(110,'ru',NULL),(111,'de',NULL),(111,'es',NULL),(111,'fr',NULL),(111,'gr',NULL),(111,'it',NULL),(111,'ja',NULL),(111,'pl',NULL),(111,'ru',NULL),(112,'de',NULL),(112,'es',NULL),(112,'fr',NULL),(112,'gr',NULL),(112,'it',NULL),(112,'ja',NULL),(112,'pl',NULL),(112,'ru',NULL),(113,'de',NULL),(113,'el',NULL),(113,'es',NULL),(113,'fr',NULL),(113,'gr',NULL),(113,'it',NULL),(113,'ja',NULL),(113,'pl',NULL),(113,'ru',NULL),(114,'de',NULL),(114,'el',NULL),(114,'es',NULL),(114,'fr',NULL),(114,'gr',NULL),(114,'it',NULL),(114,'ja',NULL),(114,'pl',NULL),(114,'ru',NULL),(115,'de',NULL),(115,'el',NULL),(115,'es',NULL),(115,'fr',NULL),(115,'gr',NULL),(115,'it',NULL),(115,'ja',NULL),(115,'pl',NULL),(115,'ru',NULL),(116,'de',NULL),(116,'el',NULL),(116,'es',NULL),(116,'fr',NULL),(116,'gr',NULL),(116,'it',NULL),(116,'ja',NULL),(116,'pl',NULL),(116,'ru',NULL),(117,'de',NULL),(117,'el',NULL),(117,'es',NULL),(117,'fr',NULL),(117,'gr',NULL),(117,'it',NULL),(117,'ja',NULL),(117,'pl',NULL),(117,'ru',NULL),(118,'de',NULL),(118,'el',NULL),(118,'es',NULL),(118,'fr',NULL),(118,'gr',NULL),(118,'it',NULL),(118,'ja',NULL),(118,'pl',NULL),(118,'ru',NULL),(119,'de',NULL),(119,'el',NULL),(119,'es',NULL),(119,'fr',NULL),(119,'gr',NULL),(119,'it',NULL),(119,'ja',NULL),(119,'pl',NULL),(119,'ru',NULL),(120,'de',NULL),(120,'el',NULL),(120,'es',NULL),(120,'fr',NULL),(120,'gr',NULL),(120,'it',NULL),(120,'ja',NULL),(120,'pl',NULL),(120,'ru',NULL),(121,'de',NULL),(121,'es',NULL),(121,'fr',NULL),(121,'gr',NULL),(121,'it',NULL),(121,'ja',NULL),(121,'pl',NULL),(121,'ru',NULL),(122,'de',NULL),(122,'el',NULL),(122,'es',NULL),(122,'fr',NULL),(122,'gr',NULL),(122,'it',NULL),(122,'ja',NULL),(122,'pl',NULL),(122,'ru',NULL),(123,'de',NULL),(123,'es',NULL),(123,'fr',NULL),(123,'gr',NULL),(123,'it',NULL),(123,'ja',NULL),(123,'pl',NULL),(123,'ru',NULL),(124,'de',NULL),(124,'es',NULL),(124,'fr',NULL),(124,'gr',NULL),(124,'it',NULL),(124,'ja',NULL),(124,'pl',NULL),(124,'ru',NULL),(125,'de',NULL),(125,'es',NULL),(125,'fr',NULL),(125,'gr',NULL),(125,'it',NULL),(125,'ja',NULL),(125,'pl',NULL),(125,'ru',NULL),(126,'de',NULL),(126,'es',NULL),(126,'fr',NULL),(126,'gr',NULL),(126,'it',NULL),(126,'ja',NULL),(126,'pl',NULL),(126,'ru',NULL),(127,'de',NULL),(127,'es',NULL),(127,'fr',NULL),(127,'gr',NULL),(127,'it',NULL),(127,'ja',NULL),(127,'pl',NULL),(127,'ru',NULL),(128,'de',NULL),(128,'es',NULL),(128,'fr',NULL),(128,'gr',NULL),(128,'it',NULL),(128,'ja',NULL),(128,'pl',NULL),(128,'ru',NULL),(129,'de',NULL),(129,'es',NULL),(129,'fr',NULL),(129,'gr',NULL),(129,'it',NULL),(129,'ja',NULL),(129,'pl',NULL),(129,'ru',NULL),(130,'de',NULL),(130,'el',NULL),(130,'es',NULL),(130,'fr',NULL),(130,'gr',NULL),(130,'it',NULL),(130,'ja',NULL),(130,'pl',NULL),(130,'ru',NULL),(131,'de',NULL),(131,'el',NULL),(131,'es',NULL),(131,'fr',NULL),(131,'gr',NULL),(131,'it',NULL),(131,'ja',NULL),(131,'pl',NULL),(131,'ru',NULL),(132,'de',NULL),(132,'es',NULL),(132,'fr',NULL),(132,'gr',NULL),(132,'it',NULL),(132,'ja',NULL),(132,'pl',NULL),(132,'ru',NULL),(133,'de',NULL),(133,'es',NULL),(133,'fr',NULL),(133,'gr',NULL),(133,'it',NULL),(133,'ja',NULL),(133,'pl',NULL),(133,'ru',NULL),(134,'de',NULL),(134,'es',NULL),(134,'fr',NULL),(134,'gr',NULL),(134,'it',NULL),(134,'ja',NULL),(134,'pl',NULL),(134,'ru',NULL),(135,'de',NULL),(135,'el',NULL),(135,'es',NULL),(135,'fr',NULL),(135,'gr',NULL),(135,'it',NULL),(135,'ja',NULL),(135,'pl',NULL),(135,'ru',NULL),(136,'de',NULL),(136,'el',NULL),(136,'es',NULL),(136,'fr',NULL),(136,'gr',NULL),(136,'it',NULL),(136,'ja',NULL),(136,'pl',NULL),(136,'ru',NULL),(137,'de',NULL),(137,'el',NULL),(137,'es',NULL),(137,'fr',NULL),(137,'gr',NULL),(137,'it',NULL),(137,'ja',NULL),(137,'pl',NULL),(137,'ru',NULL),(138,'de',NULL),(138,'el',NULL),(138,'es',NULL),(138,'fr',NULL),(138,'gr',NULL),(138,'it',NULL),(138,'ja',NULL),(138,'pl',NULL),(138,'ru',NULL),(139,'de',NULL),(139,'el',NULL),(139,'es',NULL),(139,'fr',NULL),(139,'gr',NULL),(139,'it',NULL),(139,'ja',NULL),(139,'pl',NULL),(139,'ru',NULL),(140,'de',NULL),(140,'el',NULL),(140,'es',NULL),(140,'fr',NULL),(140,'gr',NULL),(140,'it',NULL),(140,'ja',NULL),(140,'pl',NULL),(140,'ru',NULL),(141,'de',NULL),(141,'el',NULL),(141,'es',NULL),(141,'fr',NULL),(141,'gr',NULL),(141,'it',NULL),(141,'ja',NULL),(141,'pl',NULL),(141,'ru',NULL),(142,'de',NULL),(142,'es',NULL),(142,'fr',NULL),(142,'gr',NULL),(142,'it',NULL),(142,'ja',NULL),(142,'pl',NULL),(142,'ru',NULL),(143,'de',NULL),(143,'el',NULL),(143,'es',NULL),(143,'fr',NULL),(143,'gr',NULL),(143,'it',NULL),(143,'ja',NULL),(143,'pl',NULL),(143,'ru',NULL),(144,'de',NULL),(144,'el',NULL),(144,'es',NULL),(144,'fr',NULL),(144,'gr',NULL),(144,'it',NULL),(144,'ja',NULL),(144,'pl',NULL),(144,'ru',NULL),(145,'de',NULL),(145,'el',NULL),(145,'es',NULL),(145,'fr',NULL),(145,'gr',NULL),(145,'it',NULL),(145,'ja',NULL),(145,'pl',NULL),(145,'ru',NULL),(146,'de',NULL),(146,'el',NULL),(146,'es',NULL),(146,'fr',NULL),(146,'gr',NULL),(146,'it',NULL),(146,'ja',NULL),(146,'pl',NULL),(146,'ru',NULL),(147,'de',NULL),(147,'el',NULL),(147,'es',NULL),(147,'fr',NULL),(147,'gr',NULL),(147,'it',NULL),(147,'ja',NULL),(147,'pl',NULL),(147,'ru',NULL),(148,'de',NULL),(148,'el',NULL),(148,'es',NULL),(148,'fr',NULL),(148,'gr',NULL),(148,'it',NULL),(148,'ja',NULL),(148,'pl',NULL),(148,'ru',NULL),(149,'de',NULL),(149,'el',NULL),(149,'es',NULL),(149,'fr',NULL),(149,'gr',NULL),(149,'it',NULL),(149,'ja',NULL),(149,'pl',NULL),(149,'ru',NULL),(150,'de',NULL),(150,'el',NULL),(150,'es',NULL),(150,'fr',NULL),(150,'gr',NULL),(150,'it',NULL),(150,'ja',NULL),(150,'pl',NULL),(150,'ru',NULL),(151,'de',NULL),(151,'es',NULL),(151,'fr',NULL),(151,'gr',NULL),(151,'it',NULL),(151,'ja',NULL),(151,'pl',NULL),(151,'ru',NULL),(152,'de',NULL),(152,'el',NULL),(152,'es',NULL),(152,'fr',NULL),(152,'gr',NULL),(152,'it',NULL),(152,'ja',NULL),(152,'pl',NULL),(152,'ru',NULL),(153,'de',NULL),(153,'es',NULL),(153,'fr',NULL),(153,'gr',NULL),(153,'it',NULL),(153,'ja',NULL),(153,'pl',NULL),(153,'ru',NULL),(154,'de',NULL),(154,'el',NULL),(154,'es',NULL),(154,'fr',NULL),(154,'gr',NULL),(154,'it',NULL),(154,'ja',NULL),(154,'pl',NULL),(154,'ru',NULL),(155,'de',NULL),(155,'el',NULL),(155,'es',NULL),(155,'fr',NULL),(155,'gr',NULL),(155,'it',NULL),(155,'ja',NULL),(155,'pl',NULL),(155,'ru',NULL),(156,'de',NULL),(156,'el',NULL),(156,'es',NULL),(156,'fr',NULL),(156,'gr',NULL),(156,'it',NULL),(156,'ja',NULL),(156,'pl',NULL),(156,'ru',NULL),(157,'de',NULL),(157,'el',NULL),(157,'es',NULL),(157,'fr',NULL),(157,'gr',NULL),(157,'it',NULL),(157,'ja',NULL),(157,'pl',NULL),(157,'ru',NULL),(158,'de',NULL),(158,'el',NULL),(158,'es',NULL),(158,'fr',NULL),(158,'gr',NULL),(158,'it',NULL),(158,'ja',NULL),(158,'pl',NULL),(158,'ru',NULL),(159,'de',NULL),(159,'el',NULL),(159,'es',NULL),(159,'fr',NULL),(159,'gr',NULL),(159,'it',NULL),(159,'ja',NULL),(159,'pl',NULL),(159,'ru',NULL),(160,'de',NULL),(160,'el',NULL),(160,'es',NULL),(160,'fr',NULL),(160,'gr',NULL),(160,'it',NULL),(160,'ja',NULL),(160,'pl',NULL),(160,'ru',NULL),(161,'de',NULL),(161,'el',NULL),(161,'es',NULL),(161,'fr',NULL),(161,'gr',NULL),(161,'it',NULL),(161,'ja',NULL),(161,'pl',NULL),(161,'ru',NULL),(162,'de',NULL),(162,'el',NULL),(162,'es',NULL),(162,'fr',NULL),(162,'gr',NULL),(162,'it',NULL),(162,'ja',NULL),(162,'pl',NULL),(162,'ru',NULL),(163,'de',NULL),(163,'el',NULL),(163,'es',NULL),(163,'fr',NULL),(163,'gr',NULL),(163,'it',NULL),(163,'ja',NULL),(163,'pl',NULL),(163,'ru',NULL),(164,'de',NULL),(164,'el',NULL),(164,'es',NULL),(164,'fr',NULL),(164,'gr',NULL),(164,'it',NULL),(164,'ja',NULL),(164,'pl',NULL),(164,'ru',NULL),(165,'de',NULL),(165,'el',NULL),(165,'es',NULL),(165,'fr',NULL),(165,'gr',NULL),(165,'it',NULL),(165,'ja',NULL),(165,'pl',NULL),(165,'ru',NULL),(166,'de',NULL),(166,'el',NULL),(166,'es',NULL),(166,'fr',NULL),(166,'gr',NULL),(166,'it',NULL),(166,'ja',NULL),(166,'pl',NULL),(166,'ru',NULL),(167,'de',NULL),(167,'es',NULL),(167,'fr',NULL),(167,'gr',NULL),(167,'it',NULL),(167,'ja',NULL),(167,'pl',NULL),(167,'ru',NULL),(168,'de',NULL),(168,'es',NULL),(168,'fr',NULL),(168,'gr',NULL),(168,'it',NULL),(168,'ja',NULL),(168,'pl',NULL),(168,'ru',NULL),(169,'de',NULL),(169,'es',NULL),(169,'fr',NULL),(169,'gr',NULL),(169,'it',NULL),(169,'ja',NULL),(169,'pl',NULL),(169,'ru',NULL),(170,'de',NULL),(170,'el',NULL),(170,'es',NULL),(170,'fr',NULL),(170,'gr',NULL),(170,'it',NULL),(170,'ja',NULL),(170,'pl',NULL),(170,'ru',NULL),(171,'de',NULL),(171,'el',NULL),(171,'es',NULL),(171,'fr',NULL),(171,'gr',NULL),(171,'it',NULL),(171,'ja',NULL),(171,'pl',NULL),(171,'ru',NULL),(172,'de',NULL),(172,'el',NULL),(172,'es',NULL),(172,'fr',NULL),(172,'gr',NULL),(172,'it',NULL),(172,'ja',NULL),(172,'pl',NULL),(172,'ru',NULL),(173,'de',NULL),(173,'el',NULL),(173,'es',NULL),(173,'fr',NULL),(173,'gr',NULL),(173,'it',NULL),(173,'ja',NULL),(173,'pl',NULL),(173,'ru',NULL),(174,'de',NULL),(174,'el',NULL),(174,'es',NULL),(174,'fr',NULL),(174,'gr',NULL),(174,'it',NULL),(174,'ja',NULL),(174,'pl',NULL),(174,'ru',NULL),(175,'de',NULL),(175,'el',NULL),(175,'es',NULL),(175,'fr',NULL),(175,'gr',NULL),(175,'it',NULL),(175,'ja',NULL),(175,'pl',NULL),(175,'ru',NULL),(176,'de',NULL),(176,'el',NULL),(176,'es',NULL),(176,'fr',NULL),(176,'gr',NULL),(176,'it',NULL),(176,'ja',NULL),(176,'pl',NULL),(176,'ru',NULL),(177,'de',NULL),(177,'el',NULL),(177,'es',NULL),(177,'fr',NULL),(177,'gr',NULL),(177,'it',NULL),(177,'ja',NULL),(177,'pl',NULL),(177,'ru',NULL),(178,'de',NULL),(178,'el',NULL),(178,'es',NULL),(178,'fr',NULL),(178,'gr',NULL),(178,'it',NULL),(178,'ja',NULL),(178,'pl',NULL),(178,'ru',NULL),(179,'de',NULL),(179,'el',NULL),(179,'es',NULL),(179,'fr',NULL),(179,'gr',NULL),(179,'it',NULL),(179,'ja',NULL),(179,'pl',NULL),(179,'ru',NULL),(180,'de',NULL),(180,'el',NULL),(180,'es',NULL),(180,'fr',NULL),(180,'gr',NULL),(180,'it',NULL),(180,'ja',NULL),(180,'pl',NULL),(180,'ru',NULL),(181,'de',NULL),(181,'el',NULL),(181,'es',NULL),(181,'fr',NULL),(181,'gr',NULL),(181,'it',NULL),(181,'ja',NULL),(181,'pl',NULL),(181,'ru',NULL),(182,'de',NULL),(182,'es',NULL),(182,'fr',NULL),(182,'gr',NULL),(182,'it',NULL),(182,'ja',NULL),(182,'pl',NULL),(182,'ru',NULL),(183,'de',NULL),(183,'es',NULL),(183,'fr',NULL),(183,'gr',NULL),(183,'it',NULL),(183,'ja',NULL),(183,'pl',NULL),(183,'ru',NULL),(184,'de',NULL),(184,'es',NULL),(184,'fr',NULL),(184,'gr',NULL),(184,'it',NULL),(184,'ja',NULL),(184,'pl',NULL),(184,'ru',NULL),(185,'de',NULL),(185,'el',NULL),(185,'es',NULL),(185,'fr',NULL),(185,'gr',NULL),(185,'it',NULL),(185,'ja',NULL),(185,'pl',NULL),(185,'ru',NULL),(186,'de',NULL),(186,'el',NULL),(186,'es',NULL),(186,'fr',NULL),(186,'gr',NULL),(186,'it',NULL),(186,'ja',NULL),(186,'pl',NULL),(186,'ru',NULL),(187,'de',NULL),(187,'el',NULL),(187,'es',NULL),(187,'fr',NULL),(187,'gr',NULL),(187,'it',NULL),(187,'ja',NULL),(187,'pl',NULL),(187,'ru',NULL),(188,'de',NULL),(188,'el',NULL),(188,'es',NULL),(188,'fr',NULL),(188,'gr',NULL),(188,'it',NULL),(188,'ja',NULL),(188,'pl',NULL),(188,'ru',NULL),(189,'de',NULL),(189,'el',NULL),(189,'es',NULL),(189,'fr',NULL),(189,'gr',NULL),(189,'it',NULL),(189,'ja',NULL),(189,'pl',NULL),(189,'ru',NULL),(190,'de',NULL),(190,'el',NULL),(190,'es',NULL),(190,'fr',NULL),(190,'gr',NULL),(190,'it',NULL),(190,'ja',NULL),(190,'pl',NULL),(190,'ru',NULL),(191,'de',NULL),(191,'el',NULL),(191,'es',NULL),(191,'fr',NULL),(191,'gr',NULL),(191,'it',NULL),(191,'ja',NULL),(191,'pl',NULL),(191,'ru',NULL),(192,'de',NULL),(192,'el',NULL),(192,'es',NULL),(192,'fr',NULL),(192,'gr',NULL),(192,'it',NULL),(192,'ja',NULL),(192,'pl',NULL),(192,'ru',NULL),(193,'de',NULL),(193,'el',NULL),(193,'es',NULL),(193,'fr',NULL),(193,'gr',NULL),(193,'it',NULL),(193,'ja',NULL),(193,'pl',NULL),(193,'ru',NULL),(194,'de',NULL),(194,'el',NULL),(194,'es',NULL),(194,'fr',NULL),(194,'gr',NULL),(194,'it',NULL),(194,'ja',NULL),(194,'pl',NULL),(194,'ru',NULL),(195,'de',NULL),(195,'el',NULL),(195,'es',NULL),(195,'fr',NULL),(195,'gr',NULL),(195,'it',NULL),(195,'ja',NULL),(195,'pl',NULL),(195,'ru',NULL),(196,'de',NULL),(196,'el',NULL),(196,'es',NULL),(196,'fr',NULL),(196,'gr',NULL),(196,'it',NULL),(196,'ja',NULL),(196,'pl',NULL),(196,'ru',NULL),(197,'de',NULL),(197,'el',NULL),(197,'es',NULL),(197,'fr',NULL),(197,'gr',NULL),(197,'it',NULL),(197,'ja',NULL),(197,'pl',NULL),(197,'ru',NULL),(198,'de',NULL),(198,'el',NULL),(198,'es',NULL),(198,'fr',NULL),(198,'gr',NULL),(198,'it',NULL),(198,'ja',NULL),(198,'pl',NULL),(198,'ru',NULL),(199,'de',NULL),(199,'el',NULL),(199,'es',NULL),(199,'fr',NULL),(199,'gr',NULL),(199,'it',NULL),(199,'ja',NULL),(199,'pl',NULL),(199,'ru',NULL),(200,'de',NULL),(200,'el',NULL),(200,'es',NULL),(200,'fr',NULL),(200,'gr',NULL),(200,'it',NULL),(200,'ja',NULL),(200,'pl',NULL),(200,'ru',NULL),(201,'de',NULL),(201,'es',NULL),(201,'fr',NULL),(201,'gr',NULL),(201,'it',NULL),(201,'ja',NULL),(201,'pl',NULL),(201,'ru',NULL),(202,'de',NULL),(202,'el',NULL),(202,'es',NULL),(202,'fr',NULL),(202,'gr',NULL),(202,'it',NULL),(202,'ja',NULL),(202,'pl',NULL),(202,'ru',NULL),(203,'de',NULL),(203,'el',NULL),(203,'es',NULL),(203,'fr',NULL),(203,'gr',NULL),(203,'it',NULL),(203,'ja',NULL),(203,'pl',NULL),(203,'ru',NULL),(204,'de',NULL),(204,'el',NULL),(204,'es',NULL),(204,'fr',NULL),(204,'gr',NULL),(204,'it',NULL),(204,'ja',NULL),(204,'pl',NULL),(204,'ru',NULL),(205,'de',NULL),(205,'el',NULL),(205,'es',NULL),(205,'fr',NULL),(205,'gr',NULL),(205,'it',NULL),(205,'ja',NULL),(205,'pl',NULL),(205,'ru',NULL),(206,'de',NULL),(206,'el',NULL),(206,'es',NULL),(206,'fr',NULL),(206,'gr',NULL),(206,'it',NULL),(206,'ja',NULL),(206,'pl',NULL),(206,'ru',NULL),(207,'de',NULL),(207,'el',NULL),(207,'es',NULL),(207,'fr',NULL),(207,'gr',NULL),(207,'it',NULL),(207,'ja',NULL),(207,'pl',NULL),(207,'ru',NULL),(208,'de',NULL),(208,'el',NULL),(208,'es',NULL),(208,'fr',NULL),(208,'gr',NULL),(208,'it',NULL),(208,'ja',NULL),(208,'pl',NULL),(208,'ru',NULL),(209,'de',NULL),(209,'el',NULL),(209,'es',NULL),(209,'fr',NULL),(209,'gr',NULL),(209,'it',NULL),(209,'ja',NULL),(209,'pl',NULL),(209,'ru',NULL),(210,'de',NULL),(210,'el',NULL),(210,'es',NULL),(210,'fr',NULL),(210,'gr',NULL),(210,'it',NULL),(210,'ja',NULL),(210,'pl',NULL),(210,'ru',NULL),(211,'de',NULL),(211,'el',NULL),(211,'es',NULL),(211,'fr',NULL),(211,'gr',NULL),(211,'it',NULL),(211,'ja',NULL),(211,'pl',NULL),(211,'ru',NULL),(212,'de',NULL),(212,'el',NULL),(212,'es',NULL),(212,'fr',NULL),(212,'gr',NULL),(212,'it',NULL),(212,'ja',NULL),(212,'pl',NULL),(212,'ru',NULL),(213,'de',NULL),(213,'el',NULL),(213,'es',NULL),(213,'fr',NULL),(213,'gr',NULL),(213,'it',NULL),(213,'ja',NULL),(213,'pl',NULL),(213,'ru',NULL),(214,'de',NULL),(214,'el',NULL),(214,'es',NULL),(214,'fr',NULL),(214,'it',NULL),(214,'ja',NULL),(214,'pl',NULL),(214,'ru',NULL),(215,'de',NULL),(215,'el',NULL),(215,'es',NULL),(215,'fr',NULL),(215,'it',NULL),(215,'ja',NULL),(215,'pl',NULL),(215,'ru',NULL),(216,'de',NULL),(216,'el',NULL),(216,'es',NULL),(216,'fr',NULL),(216,'it',NULL),(216,'ja',NULL),(216,'pl',NULL),(216,'ru',NULL),(217,'de',NULL),(217,'el',NULL),(217,'es',NULL),(217,'fr',NULL),(217,'it',NULL),(217,'ja',NULL),(217,'pl',NULL),(217,'ru',NULL),(218,'de',NULL),(218,'el',NULL),(218,'es',NULL),(218,'fr',NULL),(218,'it',NULL),(218,'ja',NULL),(218,'pl',NULL),(218,'ru',NULL),(219,'de',NULL),(219,'el',NULL),(219,'es',NULL),(219,'fr',NULL),(219,'it',NULL),(219,'ja',NULL),(219,'pl',NULL),(219,'ru',NULL),(220,'de',NULL),(220,'el',NULL),(220,'es',NULL),(220,'fr',NULL),(220,'it',NULL),(220,'ja',NULL),(220,'pl',NULL),(220,'ru',NULL),(221,'de',NULL),(221,'el',NULL),(221,'es',NULL),(221,'fr',NULL),(221,'it',NULL),(221,'ja',NULL),(221,'pl',NULL),(221,'ru',NULL),(222,'de',NULL),(222,'el',NULL),(222,'es',NULL),(222,'fr',NULL),(222,'it',NULL),(222,'ja',NULL),(222,'pl',NULL),(222,'ru',NULL),(223,'de',NULL),(223,'el',NULL),(223,'es',NULL),(223,'fr',NULL),(223,'it',NULL),(223,'ja',NULL),(223,'pl',NULL),(223,'ru',NULL),(224,'de',NULL),(224,'el',NULL),(224,'es',NULL),(224,'fr',NULL),(224,'it',NULL),(224,'ja',NULL),(224,'pl',NULL),(224,'ru',NULL),(225,'de',NULL),(225,'el',NULL),(225,'es',NULL),(225,'fr',NULL),(225,'it',NULL),(225,'ja',NULL),(225,'pl',NULL),(225,'ru',NULL),(226,'de',NULL),(226,'el',NULL),(226,'es',NULL),(226,'fr',NULL),(226,'it',NULL),(226,'ja',NULL),(226,'pl',NULL),(226,'ru',NULL),(227,'de',NULL),(227,'el',NULL),(227,'es',NULL),(227,'fr',NULL),(227,'it',NULL),(227,'ja',NULL),(227,'pl',NULL),(227,'ru',NULL),(228,'de',NULL),(228,'el',NULL),(228,'es',NULL),(228,'fr',NULL),(228,'it',NULL),(228,'ja',NULL),(228,'pl',NULL),(228,'ru',NULL),(229,'de',NULL),(229,'el',NULL),(229,'es',NULL),(229,'fr',NULL),(229,'it',NULL),(229,'ja',NULL),(229,'pl',NULL),(229,'ru',NULL),(230,'de',NULL),(230,'el',NULL),(230,'es',NULL),(230,'fr',NULL),(230,'it',NULL),(230,'ja',NULL),(230,'pl',NULL),(230,'ru',NULL),(231,'de',NULL),(231,'el',NULL),(231,'es',NULL),(231,'fr',NULL),(231,'it',NULL),(231,'ja',NULL),(231,'pl',NULL),(231,'ru',NULL),(232,'de',NULL),(232,'el',NULL),(232,'es',NULL),(232,'fr',NULL),(232,'it',NULL),(232,'ja',NULL),(232,'pl',NULL),(232,'ru',NULL),(233,'de',NULL),(233,'el',NULL),(233,'es',NULL),(233,'fr',NULL),(233,'it',NULL),(233,'ja',NULL),(233,'pl',NULL),(233,'ru',NULL),(234,'de',NULL),(234,'el',NULL),(234,'es',NULL),(234,'fr',NULL),(234,'it',NULL),(234,'ja',NULL),(234,'pl',NULL),(234,'ru',NULL),(235,'de',NULL),(235,'el',NULL),(235,'es',NULL),(235,'fr',NULL),(235,'it',NULL),(235,'ja',NULL),(235,'pl',NULL),(235,'ru',NULL),(236,'de',NULL),(236,'el',NULL),(236,'es',NULL),(236,'fr',NULL),(236,'it',NULL),(236,'ja',NULL),(236,'pl',NULL),(236,'ru',NULL),(237,'de',NULL),(237,'el',NULL),(237,'es',NULL),(237,'fr',NULL),(237,'it',NULL),(237,'ja',NULL),(237,'pl',NULL),(237,'ru',NULL),(238,'de',NULL),(238,'el',NULL),(238,'es',NULL),(238,'fr',NULL),(238,'it',NULL),(238,'ja',NULL),(238,'pl',NULL),(238,'ru',NULL),(239,'de',NULL),(239,'el',NULL),(239,'es',NULL),(239,'fr',NULL),(239,'it',NULL),(239,'ja',NULL),(239,'pl',NULL),(239,'ru',NULL),(240,'de',NULL),(240,'el',NULL),(240,'es',NULL),(240,'fr',NULL),(240,'it',NULL),(240,'ja',NULL),(240,'pl',NULL),(240,'ru',NULL),(241,'de',NULL),(241,'el',NULL),(241,'es',NULL),(241,'fr',NULL),(241,'it',NULL),(241,'ja',NULL),(241,'pl',NULL),(241,'ru',NULL),(242,'de',NULL),(242,'el',NULL),(242,'es',NULL),(242,'fr',NULL),(242,'it',NULL),(242,'ja',NULL),(242,'pl',NULL),(242,'ru',NULL),(243,'de',NULL),(243,'el',NULL),(243,'es',NULL),(243,'fr',NULL),(243,'it',NULL),(243,'ja',NULL),(243,'pl',NULL),(243,'ru',NULL),(244,'de',NULL),(244,'el',NULL),(244,'es',NULL),(244,'fr',NULL),(244,'it',NULL),(244,'ja',NULL),(244,'pl',NULL),(244,'ru',NULL),(245,'de',NULL),(245,'el',NULL),(245,'es',NULL),(245,'fr',NULL),(245,'it',NULL),(245,'ja',NULL),(245,'pl',NULL),(245,'ru',NULL),(246,'de',NULL),(246,'el',NULL),(246,'es',NULL),(246,'fr',NULL),(246,'it',NULL),(246,'ja',NULL),(246,'pl',NULL),(246,'ru',NULL),(247,'de',NULL),(247,'el',NULL),(247,'es',NULL),(247,'fr',NULL),(247,'it',NULL),(247,'ja',NULL),(247,'pl',NULL),(247,'ru',NULL),(248,'de',NULL),(248,'el',NULL),(248,'es',NULL),(248,'fr',NULL),(248,'it',NULL),(248,'ja',NULL),(248,'pl',NULL),(248,'ru',NULL),(249,'de',NULL),(249,'el',NULL),(249,'es',NULL),(249,'fr',NULL),(249,'it',NULL),(249,'ja',NULL),(249,'pl',NULL),(249,'ru',NULL),(250,'de',NULL),(250,'el',NULL),(250,'es',NULL),(250,'fr',NULL),(250,'it',NULL),(250,'ja',NULL),(250,'pl',NULL),(250,'ru',NULL),(251,'de',NULL),(251,'el',NULL),(251,'es',NULL),(251,'fr',NULL),(251,'it',NULL),(251,'ja',NULL),(251,'pl',NULL),(251,'ru',NULL),(252,'de',NULL),(252,'el',NULL),(252,'es',NULL),(252,'fr',NULL),(252,'it',NULL),(252,'ja',NULL),(252,'pl',NULL),(252,'ru',NULL),(253,'de',NULL),(253,'el',NULL),(253,'es',NULL),(253,'fr',NULL),(253,'it',NULL),(253,'ja',NULL),(253,'pl',NULL),(253,'ru',NULL),(254,'de',NULL),(254,'el',NULL),(254,'es',NULL),(254,'fr',NULL),(254,'it',NULL),(254,'ja',NULL),(254,'pl',NULL),(254,'ru',NULL),(255,'de',NULL),(255,'el',NULL),(255,'es',NULL),(255,'fr',NULL),(255,'it',NULL),(255,'ja',NULL),(255,'pl',NULL),(255,'ru',NULL),(256,'de',NULL),(256,'el',NULL),(256,'es',NULL),(256,'fr',NULL),(256,'it',NULL),(256,'ja',NULL),(256,'pl',NULL),(256,'ru',NULL),(257,'de',NULL),(257,'el',NULL),(257,'es',NULL),(257,'fr',NULL),(257,'it',NULL),(257,'ja',NULL),(257,'pl',NULL),(257,'ru',NULL),(258,'de',NULL),(258,'el',NULL),(258,'es',NULL),(258,'fr',NULL),(258,'it',NULL),(258,'ja',NULL),(258,'pl',NULL),(258,'ru',NULL),(259,'de',NULL),(259,'el',NULL),(259,'es',NULL),(259,'fr',NULL),(259,'it',NULL),(259,'ja',NULL),(259,'pl',NULL),(259,'ru',NULL),(260,'de',NULL),(260,'el',NULL),(260,'es',NULL),(260,'fr',NULL),(260,'it',NULL),(260,'ja',NULL),(260,'pl',NULL),(260,'ru',NULL),(261,'de',NULL),(261,'el',NULL),(261,'es',NULL),(261,'fr',NULL),(261,'it',NULL),(261,'ja',NULL),(261,'pl',NULL),(261,'ru',NULL),(262,'de',NULL),(262,'el',NULL),(262,'es',NULL),(262,'fr',NULL),(262,'it',NULL),(262,'ja',NULL),(262,'pl',NULL),(262,'ru',NULL),(263,'de',NULL),(263,'el',NULL),(263,'es',NULL),(263,'fr',NULL),(263,'it',NULL),(263,'ja',NULL),(263,'pl',NULL),(263,'ru',NULL),(264,'de',NULL),(264,'el',NULL),(264,'es',NULL),(264,'fr',NULL),(264,'it',NULL),(264,'ja',NULL),(264,'pl',NULL),(264,'ru',NULL),(265,'de',NULL),(265,'el',NULL),(265,'es',NULL),(265,'fr',NULL),(265,'it',NULL),(265,'ja',NULL),(265,'pl',NULL),(265,'ru',NULL),(266,'de',NULL),(266,'el',NULL),(266,'es',NULL),(266,'fr',NULL),(266,'it',NULL),(266,'ja',NULL),(266,'pl',NULL),(266,'ru',NULL),(267,'de',NULL),(267,'el',NULL),(267,'es',NULL),(267,'fr',NULL),(267,'it',NULL),(267,'ja',NULL),(267,'pl',NULL),(267,'ru',NULL),(268,'de',NULL),(268,'el',NULL),(268,'es',NULL),(268,'fr',NULL),(268,'it',NULL),(268,'ja',NULL),(268,'pl',NULL),(268,'ru',NULL),(269,'de',NULL),(269,'el',NULL),(269,'es',NULL),(269,'fr',NULL),(269,'it',NULL),(269,'ja',NULL),(269,'pl',NULL),(269,'ru',NULL),(270,'de',NULL),(270,'el',NULL),(270,'es',NULL),(270,'fr',NULL),(270,'it',NULL),(270,'ja',NULL),(270,'pl',NULL),(270,'ru',NULL),(271,'de',NULL),(271,'el',NULL),(271,'es',NULL),(271,'fr',NULL),(271,'it',NULL),(271,'ja',NULL),(271,'pl',NULL),(271,'ru',NULL),(272,'de',NULL),(272,'el',NULL),(272,'es',NULL),(272,'fr',NULL),(272,'it',NULL),(272,'ja',NULL),(272,'pl',NULL),(272,'ru',NULL),(273,'de',NULL),(273,'el',NULL),(273,'es',NULL),(273,'fr',NULL),(273,'it',NULL),(273,'ja',NULL),(273,'pl',NULL),(273,'ru',NULL),(274,'de',NULL),(274,'el',NULL),(274,'es',NULL),(274,'fr',NULL),(274,'it',NULL),(274,'ja',NULL),(274,'pl',NULL),(274,'ru',NULL),(275,'de',NULL),(275,'el',NULL),(275,'es',NULL),(275,'fr',NULL),(275,'it',NULL),(275,'ja',NULL),(275,'pl',NULL),(275,'ru',NULL),(276,'de',NULL),(276,'el',NULL),(276,'es',NULL),(276,'fr',NULL),(276,'it',NULL),(276,'ja',NULL),(276,'pl',NULL),(276,'ru',NULL),(277,'de',NULL),(277,'el',NULL),(277,'es',NULL),(277,'fr',NULL),(277,'it',NULL),(277,'ja',NULL),(277,'pl',NULL),(277,'ru',NULL),(278,'de',NULL),(278,'el',NULL),(278,'es',NULL),(278,'fr',NULL),(278,'it',NULL),(278,'ja',NULL),(278,'pl',NULL),(278,'ru',NULL),(279,'de',NULL),(279,'el',NULL),(279,'es',NULL),(279,'fr',NULL),(279,'it',NULL),(279,'ja',NULL),(279,'pl',NULL),(279,'ru',NULL),(280,'de',NULL),(280,'el',NULL),(280,'es',NULL),(280,'fr',NULL),(280,'it',NULL),(280,'ja',NULL),(280,'pl',NULL),(280,'ru',NULL),(281,'de',NULL),(281,'el',NULL),(281,'es',NULL),(281,'fr',NULL),(281,'it',NULL),(281,'ja',NULL),(281,'pl',NULL),(281,'ru',NULL),(282,'de',NULL),(282,'el',NULL),(282,'es',NULL),(282,'fr',NULL),(282,'it',NULL),(282,'ja',NULL),(282,'pl',NULL),(282,'ru',NULL),(283,'de',NULL),(283,'el',NULL),(283,'es',NULL),(283,'fr',NULL),(283,'it',NULL),(283,'ja',NULL),(283,'pl',NULL),(283,'ru',NULL),(284,'de',NULL),(284,'el',NULL),(284,'es',NULL),(284,'fr',NULL),(284,'it',NULL),(284,'ja',NULL),(284,'pl',NULL),(284,'ru',NULL),(285,'de',NULL),(285,'el',NULL),(285,'es',NULL),(285,'fr',NULL),(285,'it',NULL),(285,'ja',NULL),(285,'pl',NULL),(285,'ru',NULL),(286,'de',NULL),(286,'el',NULL),(286,'es',NULL),(286,'fr',NULL),(286,'it',NULL),(286,'ja',NULL),(286,'pl',NULL),(286,'ru',NULL),(287,'de',NULL),(287,'el',NULL),(287,'es',NULL),(287,'fr',NULL),(287,'it',NULL),(287,'ja',NULL),(287,'pl',NULL),(287,'ru',NULL),(288,'de',NULL),(288,'el',NULL),(288,'es',NULL),(288,'fr',NULL),(288,'it',NULL),(288,'ja',NULL),(288,'pl',NULL),(288,'ru',NULL),(289,'de',NULL),(289,'el',NULL),(289,'es',NULL),(289,'fr',NULL),(289,'it',NULL),(289,'ja',NULL),(289,'pl',NULL),(289,'ru',NULL),(290,'de',NULL),(290,'el',NULL),(290,'es',NULL),(290,'fr',NULL),(290,'it',NULL),(290,'ja',NULL),(290,'pl',NULL),(290,'ru',NULL),(291,'de',NULL),(291,'el',NULL),(291,'es',NULL),(291,'fr',NULL),(291,'it',NULL),(291,'ja',NULL),(291,'pl',NULL),(291,'ru',NULL),(292,'de',NULL),(292,'el',NULL),(292,'es',NULL),(292,'fr',NULL),(292,'it',NULL),(292,'ja',NULL),(292,'pl',NULL),(292,'ru',NULL),(293,'de',NULL),(293,'el',NULL),(293,'es',NULL),(293,'fr',NULL),(293,'it',NULL),(293,'ja',NULL),(293,'pl',NULL),(293,'ru',NULL),(294,'de',NULL),(294,'el',NULL),(294,'es',NULL),(294,'fr',NULL),(294,'it',NULL),(294,'ja',NULL),(294,'pl',NULL),(294,'ru',NULL),(295,'de',NULL),(295,'el',NULL),(295,'es',NULL),(295,'fr',NULL),(295,'it',NULL),(295,'ja',NULL),(295,'pl',NULL),(295,'ru',NULL),(296,'de',NULL),(296,'el',NULL),(296,'es',NULL),(296,'fr',NULL),(296,'it',NULL),(296,'ja',NULL),(296,'pl',NULL),(296,'ru',NULL),(297,'de',NULL),(297,'el',NULL),(297,'es',NULL),(297,'fr',NULL),(297,'it',NULL),(297,'ja',NULL),(297,'pl',NULL),(297,'ru',NULL),(298,'de',NULL),(298,'el',NULL),(298,'es',NULL),(298,'fr',NULL),(298,'it',NULL),(298,'ja',NULL),(298,'pl',NULL),(298,'ru',NULL),(299,'de',NULL),(299,'el',NULL),(299,'es',NULL),(299,'fr',NULL),(299,'it',NULL),(299,'ja',NULL),(299,'pl',NULL),(299,'ru',NULL),(300,'de',NULL),(300,'el',NULL),(300,'es',NULL),(300,'fr',NULL),(300,'it',NULL),(300,'ja',NULL),(300,'pl',NULL),(300,'ru',NULL),(301,'de',NULL),(301,'el',NULL),(301,'es',NULL),(301,'fr',NULL),(301,'it',NULL),(301,'ja',NULL),(301,'pl',NULL),(301,'ru',NULL),(302,'de',NULL),(302,'el',NULL),(302,'es',NULL),(302,'fr',NULL),(302,'it',NULL),(302,'ja',NULL),(302,'pl',NULL),(302,'ru',NULL),(303,'de',NULL),(303,'el',NULL),(303,'es',NULL),(303,'fr',NULL),(303,'it',NULL),(303,'ja',NULL),(303,'pl',NULL),(303,'ru',NULL),(304,'de',NULL),(304,'el',NULL),(304,'es',NULL),(304,'fr',NULL),(304,'it',NULL),(304,'ja',NULL),(304,'pl',NULL),(304,'ru',NULL),(305,'de',NULL),(305,'el',NULL),(305,'es',NULL),(305,'fr',NULL),(305,'it',NULL),(305,'ja',NULL),(305,'pl',NULL),(305,'ru',NULL),(306,'de',NULL),(306,'el',NULL),(306,'es',NULL),(306,'fr',NULL),(306,'it',NULL),(306,'ja',NULL),(306,'pl',NULL),(306,'ru',NULL),(307,'de',NULL),(307,'el',NULL),(307,'es',NULL),(307,'fr',NULL),(307,'it',NULL),(307,'ja',NULL),(307,'pl',NULL),(307,'ru',NULL),(308,'de',NULL),(308,'el',NULL),(308,'es',NULL),(308,'fr',NULL),(308,'it',NULL),(308,'ja',NULL),(308,'pl',NULL),(308,'ru',NULL),(309,'de',NULL),(309,'el',NULL),(309,'es',NULL),(309,'fr',NULL),(309,'it',NULL),(309,'ja',NULL),(309,'pl',NULL),(309,'ru',NULL),(310,'de',NULL),(310,'el',NULL),(310,'es',NULL),(310,'fr',NULL),(310,'it',NULL),(310,'ja',NULL),(310,'pl',NULL),(310,'ru',NULL),(311,'de',NULL),(311,'el',NULL),(311,'es',NULL),(311,'fr',NULL),(311,'it',NULL),(311,'ja',NULL),(311,'pl',NULL),(311,'ru',NULL),(312,'de',NULL),(312,'el',NULL),(312,'es',NULL),(312,'fr',NULL),(312,'it',NULL),(312,'ja',NULL),(312,'pl',NULL),(312,'ru',NULL),(313,'de',NULL),(313,'el',NULL),(313,'es',NULL),(313,'fr',NULL),(313,'it',NULL),(313,'ja',NULL),(313,'pl',NULL),(313,'ru',NULL),(314,'de',NULL),(314,'el',NULL),(314,'es',NULL),(314,'fr',NULL),(314,'it',NULL),(314,'ja',NULL),(314,'pl',NULL),(314,'ru',NULL),(315,'de',NULL),(315,'el',NULL),(315,'es',NULL),(315,'fr',NULL),(315,'it',NULL),(315,'ja',NULL),(315,'pl',NULL),(315,'ru',NULL),(316,'de',NULL),(316,'el',NULL),(316,'es',NULL),(316,'fr',NULL),(316,'it',NULL),(316,'ja',NULL),(316,'pl',NULL),(316,'ru',NULL),(317,'de',NULL),(317,'el',NULL),(317,'es',NULL),(317,'fr',NULL),(317,'it',NULL),(317,'ja',NULL),(317,'pl',NULL),(317,'ru',NULL),(318,'de',NULL),(318,'el',NULL),(318,'es',NULL),(318,'fr',NULL),(318,'it',NULL),(318,'ja',NULL),(318,'pl',NULL),(318,'ru',NULL),(319,'de',NULL),(319,'el',NULL),(319,'es',NULL),(319,'fr',NULL),(319,'it',NULL),(319,'ja',NULL),(319,'pl',NULL),(319,'ru',NULL),(320,'de',NULL),(320,'el',NULL),(320,'es',NULL),(320,'fr',NULL),(320,'it',NULL),(320,'ja',NULL),(320,'pl',NULL),(320,'ru',NULL),(321,'de',NULL),(321,'el',NULL),(321,'es',NULL),(321,'fr',NULL),(321,'it',NULL),(321,'ja',NULL),(321,'pl',NULL),(321,'ru',NULL),(322,'de',NULL),(322,'el',NULL),(322,'es',NULL),(322,'fr',NULL),(322,'it',NULL),(322,'ja',NULL),(322,'pl',NULL),(322,'ru',NULL),(323,'de',NULL),(323,'el',NULL),(323,'es',NULL),(323,'fr',NULL),(323,'it',NULL),(323,'ja',NULL),(323,'pl',NULL),(323,'ru',NULL),(324,'de',NULL),(324,'el',NULL),(324,'es',NULL),(324,'fr',NULL),(324,'it',NULL),(324,'ja',NULL),(324,'pl',NULL),(324,'ru',NULL),(325,'de',NULL),(325,'el',NULL),(325,'es',NULL),(325,'fr',NULL),(325,'it',NULL),(325,'ja',NULL),(325,'pl',NULL),(325,'ru',NULL),(326,'de',NULL),(326,'el',NULL),(326,'es',NULL),(326,'fr',NULL),(326,'it',NULL),(326,'ja',NULL),(326,'pl',NULL),(326,'ru',NULL),(327,'de',NULL),(327,'el',NULL),(327,'es',NULL),(327,'fr',NULL),(327,'it',NULL),(327,'ja',NULL),(327,'pl',NULL),(327,'ru',NULL),(328,'de',NULL),(328,'el',NULL),(328,'es',NULL),(328,'fr',NULL),(328,'it',NULL),(328,'ja',NULL),(328,'pl',NULL),(328,'ru',NULL),(329,'de',NULL),(329,'el',NULL),(329,'es',NULL),(329,'fr',NULL),(329,'it',NULL),(329,'ja',NULL),(329,'pl',NULL),(329,'ru',NULL),(330,'de',NULL),(330,'el',NULL),(330,'es',NULL),(330,'fr',NULL),(330,'it',NULL),(330,'ja',NULL),(330,'pl',NULL),(330,'ru',NULL),(331,'de',NULL),(331,'el',NULL),(331,'es',NULL),(331,'fr',NULL),(331,'it',NULL),(331,'ja',NULL),(331,'pl',NULL),(331,'ru',NULL),(332,'de',NULL),(332,'el',NULL),(332,'es',NULL),(332,'fr',NULL),(332,'it',NULL),(332,'ja',NULL),(332,'pl',NULL),(332,'ru',NULL),(333,'de',NULL),(333,'el',NULL),(333,'es',NULL),(333,'fr',NULL),(333,'it',NULL),(333,'ja',NULL),(333,'pl',NULL),(333,'ru',NULL),(334,'de',NULL),(334,'el',NULL),(334,'es',NULL),(334,'fr',NULL),(334,'it',NULL),(334,'ja',NULL),(334,'pl',NULL),(334,'ru',NULL),(335,'de',NULL),(335,'el',NULL),(335,'es',NULL),(335,'fr',NULL),(335,'it',NULL),(335,'ja',NULL),(335,'pl',NULL),(335,'ru',NULL),(336,'de',NULL),(336,'el',NULL),(336,'es',NULL),(336,'fr',NULL),(336,'it',NULL),(336,'ja',NULL),(336,'pl',NULL),(336,'ru',NULL),(337,'de',NULL),(337,'el',NULL),(337,'es',NULL),(337,'fr',NULL),(337,'it',NULL),(337,'ja',NULL),(337,'pl',NULL),(337,'ru',NULL),(338,'de',NULL),(338,'el',NULL),(338,'es',NULL),(338,'fr',NULL),(338,'it',NULL),(338,'ja',NULL),(338,'pl',NULL),(338,'ru',NULL),(339,'de',NULL),(339,'el',NULL),(339,'es',NULL),(339,'fr',NULL),(339,'it',NULL),(339,'ja',NULL),(339,'pl',NULL),(339,'ru',NULL),(340,'de',NULL),(340,'el',NULL),(340,'es',NULL),(340,'fr',NULL),(340,'it',NULL),(340,'ja',NULL),(340,'pl',NULL),(340,'ru',NULL),(341,'de',NULL),(341,'el',NULL),(341,'es',NULL),(341,'fr',NULL),(341,'it',NULL),(341,'ja',NULL),(341,'pl',NULL),(341,'ru',NULL),(342,'de',NULL),(342,'el',NULL),(342,'es',NULL),(342,'fr',NULL),(342,'it',NULL),(342,'ja',NULL),(342,'pl',NULL),(342,'ru',NULL),(343,'de',NULL),(343,'el',NULL),(343,'es',NULL),(343,'fr',NULL),(343,'it',NULL),(343,'ja',NULL),(343,'pl',NULL),(343,'ru',NULL),(344,'de',NULL),(344,'el',NULL),(344,'es',NULL),(344,'fr',NULL),(344,'it',NULL),(344,'ja',NULL),(344,'pl',NULL),(344,'ru',NULL),(345,'de',NULL),(345,'el',NULL),(345,'es',NULL),(345,'fr',NULL),(345,'it',NULL),(345,'ja',NULL),(345,'pl',NULL),(345,'ru',NULL),(346,'de',NULL),(346,'el',NULL),(346,'es',NULL),(346,'fr',NULL),(346,'it',NULL),(346,'ja',NULL),(346,'pl',NULL),(346,'ru',NULL),(347,'de',NULL),(347,'el',NULL),(347,'es',NULL),(347,'fr',NULL),(347,'it',NULL),(347,'ja',NULL),(347,'pl',NULL),(347,'ru',NULL),(348,'de',NULL),(348,'el',NULL),(348,'es',NULL),(348,'fr',NULL),(348,'it',NULL),(348,'ja',NULL),(348,'pl',NULL),(348,'ru',NULL),(349,'de',NULL),(349,'el',NULL),(349,'es',NULL),(349,'fr',NULL),(349,'it',NULL),(349,'ja',NULL),(349,'pl',NULL),(349,'ru',NULL),(350,'de',NULL),(350,'el',NULL),(350,'es',NULL),(350,'fr',NULL),(350,'it',NULL),(350,'ja',NULL),(350,'pl',NULL),(350,'ru',NULL),(351,'de',NULL),(351,'el',NULL),(351,'es',NULL),(351,'fr',NULL),(351,'it',NULL),(351,'ja',NULL),(351,'pl',NULL),(351,'ru',NULL),(352,'de',NULL),(352,'el',NULL),(352,'es',NULL),(352,'fr',NULL),(352,'it',NULL),(352,'ja',NULL),(352,'pl',NULL),(352,'ru',NULL),(353,'de',NULL),(353,'el',NULL),(353,'es',NULL),(353,'fr',NULL),(353,'it',NULL),(353,'ja',NULL),(353,'pl',NULL),(353,'ru',NULL),(354,'de',NULL),(354,'el',NULL),(354,'es',NULL),(354,'fr',NULL),(354,'it',NULL),(354,'ja',NULL),(354,'pl',NULL),(354,'ru',NULL),(355,'de',NULL),(355,'el',NULL),(355,'es',NULL),(355,'fr',NULL),(355,'it',NULL),(355,'ja',NULL),(355,'pl',NULL),(355,'ru',NULL),(356,'de',NULL),(356,'el',NULL),(356,'es',NULL),(356,'fr',NULL),(356,'it',NULL),(356,'ja',NULL),(356,'pl',NULL),(356,'ru',NULL),(357,'de',NULL),(357,'el',NULL),(357,'es',NULL),(357,'fr',NULL),(357,'it',NULL),(357,'ja',NULL),(357,'pl',NULL),(357,'ru',NULL),(358,'de',NULL),(358,'el',NULL),(358,'es',NULL),(358,'fr',NULL),(358,'it',NULL),(358,'ja',NULL),(358,'pl',NULL),(358,'ru',NULL),(359,'de',NULL),(359,'el',NULL),(359,'es',NULL),(359,'fr',NULL),(359,'it',NULL),(359,'ja',NULL),(359,'pl',NULL),(359,'ru',NULL),(360,'de',NULL),(360,'el',NULL),(360,'es',NULL),(360,'fr',NULL),(360,'it',NULL),(360,'ja',NULL),(360,'pl',NULL),(360,'ru',NULL),(361,'de',NULL),(361,'el',NULL),(361,'es',NULL),(361,'fr',NULL),(361,'it',NULL),(361,'ja',NULL),(361,'pl',NULL),(361,'ru',NULL),(362,'de',NULL),(362,'el',NULL),(362,'es',NULL),(362,'fr',NULL),(362,'it',NULL),(362,'ja',NULL),(362,'pl',NULL),(362,'ru',NULL),(363,'de',NULL),(363,'el',NULL),(363,'es',NULL),(363,'fr',NULL),(363,'it',NULL),(363,'ja',NULL),(363,'pl',NULL),(363,'ru',NULL),(364,'de',NULL),(364,'el',NULL),(364,'es',NULL),(364,'fr',NULL),(364,'it',NULL),(364,'ja',NULL),(364,'pl',NULL),(364,'ru',NULL),(365,'de',NULL),(365,'el',NULL),(365,'es',NULL),(365,'fr',NULL),(365,'it',NULL),(365,'ja',NULL),(365,'pl',NULL),(365,'ru',NULL),(366,'de',NULL),(366,'el',NULL),(366,'es',NULL),(366,'fr',NULL),(366,'it',NULL),(366,'ja',NULL),(366,'pl',NULL),(366,'ru',NULL),(367,'de',NULL),(367,'el',NULL),(367,'es',NULL),(367,'fr',NULL),(367,'it',NULL),(367,'ja',NULL),(367,'pl',NULL),(367,'ru',NULL),(368,'de',NULL),(368,'el',NULL),(368,'es',NULL),(368,'fr',NULL),(368,'it',NULL),(368,'ja',NULL),(368,'pl',NULL),(368,'ru',NULL),(369,'de',NULL),(369,'el',NULL),(369,'es',NULL),(369,'fr',NULL),(369,'it',NULL),(369,'ja',NULL),(369,'pl',NULL),(369,'ru',NULL),(370,'de',NULL),(370,'el',NULL),(370,'es',NULL),(370,'fr',NULL),(370,'it',NULL),(370,'ja',NULL),(370,'pl',NULL),(370,'ru',NULL),(371,'de',NULL),(371,'el',NULL),(371,'es',NULL),(371,'fr',NULL),(371,'it',NULL),(371,'ja',NULL),(371,'pl',NULL),(371,'ru',NULL),(372,'de',NULL),(372,'el',NULL),(372,'es',NULL),(372,'fr',NULL),(372,'it',NULL),(372,'ja',NULL),(372,'pl',NULL),(372,'ru',NULL),(373,'de',NULL),(373,'el',NULL),(373,'es',NULL),(373,'fr',NULL),(373,'it',NULL),(373,'ja',NULL),(373,'pl',NULL),(373,'ru',NULL),(374,'de',NULL),(374,'el',NULL),(374,'es',NULL),(374,'fr',NULL),(374,'it',NULL),(374,'ja',NULL),(374,'pl',NULL),(374,'ru',NULL),(375,'de',NULL),(375,'el',NULL),(375,'es',NULL),(375,'fr',NULL),(375,'it',NULL),(375,'ja',NULL),(375,'pl',NULL),(375,'ru',NULL),(376,'de',NULL),(376,'el',NULL),(376,'es',NULL),(376,'fr',NULL),(376,'it',NULL),(376,'ja',NULL),(376,'pl',NULL),(376,'ru',NULL),(377,'de',NULL),(377,'el',NULL),(377,'es',NULL),(377,'fr',NULL),(377,'it',NULL),(377,'ja',NULL),(377,'pl',NULL),(377,'ru',NULL),(378,'de',NULL),(378,'el',NULL),(378,'es',NULL),(378,'fr',NULL),(378,'it',NULL),(378,'ja',NULL),(378,'pl',NULL),(378,'ru',NULL),(379,'de',NULL),(379,'el',NULL),(379,'es',NULL),(379,'fr',NULL),(379,'it',NULL),(379,'ja',NULL),(379,'pl',NULL),(379,'ru',NULL),(380,'de',NULL),(380,'el',NULL),(380,'es',NULL),(380,'fr',NULL),(380,'it',NULL),(380,'ja',NULL),(380,'pl',NULL),(380,'ru',NULL),(381,'de',NULL),(381,'el',NULL),(381,'es',NULL),(381,'fr',NULL),(381,'it',NULL),(381,'ja',NULL),(381,'pl',NULL),(381,'ru',NULL),(382,'de',NULL),(382,'el',NULL),(382,'es',NULL),(382,'fr',NULL),(382,'it',NULL),(382,'ja',NULL),(382,'pl',NULL),(382,'ru',NULL),(383,'de',NULL),(383,'el',NULL),(383,'es',NULL),(383,'fr',NULL),(383,'it',NULL),(383,'ja',NULL),(383,'pl',NULL),(383,'ru',NULL),(384,'de',NULL),(384,'el',NULL),(384,'es',NULL),(384,'fr',NULL),(384,'it',NULL),(384,'ja',NULL),(384,'pl',NULL),(384,'ru',NULL),(385,'de',NULL),(385,'el',NULL),(385,'es',NULL),(385,'fr',NULL),(385,'it',NULL),(385,'ja',NULL),(385,'pl',NULL),(385,'ru',NULL),(386,'de',NULL),(386,'el',NULL),(386,'es',NULL),(386,'fr',NULL),(386,'it',NULL),(386,'ja',NULL),(386,'pl',NULL),(386,'ru',NULL),(387,'de',NULL),(387,'el',NULL),(387,'es',NULL),(387,'fr',NULL),(387,'it',NULL),(387,'ja',NULL),(387,'pl',NULL),(387,'ru',NULL),(388,'de',NULL),(388,'el',NULL),(388,'es',NULL),(388,'fr',NULL),(388,'it',NULL),(388,'ja',NULL),(388,'pl',NULL),(388,'ru',NULL),(389,'de',NULL),(389,'el',NULL),(389,'es',NULL),(389,'fr',NULL),(389,'it',NULL),(389,'ja',NULL),(389,'pl',NULL),(389,'ru',NULL),(390,'de',NULL),(390,'el',NULL),(390,'es',NULL),(390,'fr',NULL),(390,'it',NULL),(390,'ja',NULL),(390,'pl',NULL),(390,'ru',NULL),(391,'de',NULL),(391,'el',NULL),(391,'es',NULL),(391,'fr',NULL),(391,'it',NULL),(391,'ja',NULL),(391,'pl',NULL),(391,'ru',NULL),(392,'de',NULL),(392,'el',NULL),(392,'es',NULL),(392,'fr',NULL),(392,'it',NULL),(392,'ja',NULL),(392,'pl',NULL),(392,'ru',NULL),(393,'de',NULL),(393,'el',NULL),(393,'es',NULL),(393,'fr',NULL),(393,'it',NULL),(393,'ja',NULL),(393,'pl',NULL),(393,'ru',NULL),(394,'de',NULL),(394,'el',NULL),(394,'es',NULL),(394,'fr',NULL),(394,'it',NULL),(394,'ja',NULL),(394,'pl',NULL),(394,'ru',NULL),(395,'de',NULL),(395,'el',NULL),(395,'es',NULL),(395,'fr',NULL),(395,'it',NULL),(395,'ja',NULL),(395,'pl',NULL),(395,'ru',NULL),(396,'de',NULL),(396,'el',NULL),(396,'es',NULL),(396,'fr',NULL),(396,'it',NULL),(396,'ja',NULL),(396,'pl',NULL),(396,'ru',NULL),(397,'de',NULL),(397,'el',NULL),(397,'es',NULL),(397,'fr',NULL),(397,'it',NULL),(397,'ja',NULL),(397,'pl',NULL),(397,'ru',NULL),(398,'de',NULL),(398,'el',NULL),(398,'es',NULL),(398,'fr',NULL),(398,'it',NULL),(398,'ja',NULL),(398,'pl',NULL),(398,'ru',NULL),(399,'de',NULL),(399,'el',NULL),(399,'es',NULL),(399,'fr',NULL),(399,'it',NULL),(399,'ja',NULL),(399,'pl',NULL),(399,'ru',NULL),(400,'de',NULL),(400,'el',NULL),(400,'es',NULL),(400,'fr',NULL),(400,'it',NULL),(400,'ja',NULL),(400,'pl',NULL),(400,'ru',NULL),(401,'de',NULL),(401,'el',NULL),(401,'es',NULL),(401,'fr',NULL),(401,'it',NULL),(401,'ja',NULL),(401,'pl',NULL),(401,'ru',NULL),(402,'de',NULL),(402,'el',NULL),(402,'es',NULL),(402,'fr',NULL),(402,'it',NULL),(402,'ja',NULL),(402,'pl',NULL),(402,'ru',NULL),(403,'de',NULL),(403,'el',NULL),(403,'es',NULL),(403,'fr',NULL),(403,'it',NULL),(403,'ja',NULL),(403,'pl',NULL),(403,'ru',NULL),(404,'de',NULL),(404,'el',NULL),(404,'es',NULL),(404,'fr',NULL),(404,'it',NULL),(404,'ja',NULL),(404,'pl',NULL),(404,'ru',NULL),(405,'de',NULL),(405,'el',NULL),(405,'es',NULL),(405,'fr',NULL),(405,'it',NULL),(405,'ja',NULL),(405,'pl',NULL),(405,'ru',NULL),(406,'de',NULL),(406,'el',NULL),(406,'es',NULL),(406,'fr',NULL),(406,'it',NULL),(406,'ja',NULL),(406,'pl',NULL),(406,'ru',NULL),(407,'de',NULL),(407,'el',NULL),(407,'es',NULL),(407,'fr',NULL),(407,'it',NULL),(407,'ja',NULL),(407,'pl',NULL),(407,'ru',NULL),(408,'de',NULL),(408,'el',NULL),(408,'es',NULL),(408,'fr',NULL),(408,'it',NULL),(408,'ja',NULL),(408,'pl',NULL),(408,'ru',NULL),(409,'de',NULL),(409,'el',NULL),(409,'es',NULL),(409,'fr',NULL),(409,'it',NULL),(409,'ja',NULL),(409,'pl',NULL),(409,'ru',NULL),(410,'de',NULL),(410,'el',NULL),(410,'es',NULL),(410,'fr',NULL),(410,'it',NULL),(410,'ja',NULL),(410,'pl',NULL),(410,'ru',NULL),(411,'de',NULL),(411,'el',NULL),(411,'es',NULL),(411,'fr',NULL),(411,'it',NULL),(411,'ja',NULL),(411,'pl',NULL),(411,'ru',NULL),(412,'de',NULL),(412,'el',NULL),(412,'es',NULL),(412,'fr',NULL),(412,'it',NULL),(412,'ja',NULL),(412,'pl',NULL),(412,'ru',NULL),(413,'de',NULL),(413,'el',NULL),(413,'es',NULL),(413,'fr',NULL),(413,'it',NULL),(413,'ja',NULL),(413,'pl',NULL),(413,'ru',NULL),(414,'de',NULL),(414,'el',NULL),(414,'es',NULL),(414,'fr',NULL),(414,'it',NULL),(414,'ja',NULL),(414,'pl',NULL),(414,'ru',NULL),(415,'de',NULL),(415,'el',NULL),(415,'es',NULL),(415,'fr',NULL),(415,'it',NULL),(415,'ja',NULL),(415,'pl',NULL),(415,'ru',NULL),(416,'de',NULL),(416,'el',NULL),(416,'es',NULL),(416,'fr',NULL),(416,'it',NULL),(416,'ja',NULL),(416,'pl',NULL),(416,'ru',NULL),(417,'de',NULL),(417,'el',NULL),(417,'es',NULL),(417,'fr',NULL),(417,'it',NULL),(417,'ja',NULL),(417,'pl',NULL),(417,'ru',NULL),(418,'de',NULL),(418,'el',NULL),(418,'es',NULL),(418,'fr',NULL),(418,'it',NULL),(418,'ja',NULL),(418,'pl',NULL),(418,'ru',NULL),(419,'de',NULL),(419,'el',NULL),(419,'es',NULL),(419,'fr',NULL),(419,'it',NULL),(419,'ja',NULL),(419,'pl',NULL),(419,'ru',NULL),(420,'de',NULL),(420,'el',NULL),(420,'es',NULL),(420,'fr',NULL),(420,'it',NULL),(420,'ja',NULL),(420,'pl',NULL),(420,'ru',NULL),(421,'de',NULL),(421,'el',NULL),(421,'es',NULL),(421,'fr',NULL),(421,'it',NULL),(421,'ja',NULL),(421,'pl',NULL),(421,'ru',NULL),(422,'de',NULL),(422,'el',NULL),(422,'es',NULL),(422,'fr',NULL),(422,'it',NULL),(422,'ja',NULL),(422,'pl',NULL),(422,'ru',NULL),(423,'de',NULL),(423,'el',NULL),(423,'es',NULL),(423,'fr',NULL),(423,'it',NULL),(423,'ja',NULL),(423,'pl',NULL),(423,'ru',NULL),(424,'de',NULL),(424,'el',NULL),(424,'es',NULL),(424,'fr',NULL),(424,'it',NULL),(424,'ja',NULL),(424,'pl',NULL),(424,'ru',NULL),(425,'de',NULL),(425,'el',NULL),(425,'es',NULL),(425,'fr',NULL),(425,'it',NULL),(425,'ja',NULL),(425,'pl',NULL),(425,'ru',NULL),(426,'de',NULL),(426,'el',NULL),(426,'es',NULL),(426,'fr',NULL),(426,'it',NULL),(426,'ja',NULL),(426,'pl',NULL),(426,'ru',NULL),(427,'de',NULL),(427,'el',NULL),(427,'es',NULL),(427,'fr',NULL),(427,'it',NULL),(427,'ja',NULL),(427,'pl',NULL),(427,'ru',NULL),(428,'de',NULL),(428,'el',NULL),(428,'es',NULL),(428,'fr',NULL),(428,'it',NULL),(428,'ja',NULL),(428,'pl',NULL),(428,'ru',NULL),(429,'de',NULL),(429,'el',NULL),(429,'es',NULL),(429,'fr',NULL),(429,'it',NULL),(429,'ja',NULL),(429,'pl',NULL),(429,'ru',NULL),(430,'de',NULL),(430,'el',NULL),(430,'es',NULL),(430,'fr',NULL),(430,'it',NULL),(430,'ja',NULL),(430,'pl',NULL),(430,'ru',NULL),(431,'de',NULL),(431,'el',NULL),(431,'es',NULL),(431,'fr',NULL),(431,'it',NULL),(431,'ja',NULL),(431,'pl',NULL),(431,'ru',NULL),(432,'de',NULL),(432,'el',NULL),(432,'es',NULL),(432,'fr',NULL),(432,'it',NULL),(432,'ja',NULL),(432,'pl',NULL),(432,'ru',NULL),(433,'de',NULL),(433,'el',NULL),(433,'es',NULL),(433,'fr',NULL),(433,'it',NULL),(433,'ja',NULL),(433,'pl',NULL),(433,'ru',NULL),(434,'de',NULL),(434,'el',NULL),(434,'es',NULL),(434,'fr',NULL),(434,'it',NULL),(434,'ja',NULL),(434,'pl',NULL),(434,'ru',NULL),(435,'de',NULL),(435,'el',NULL),(435,'es',NULL),(435,'fr',NULL),(435,'it',NULL),(435,'ja',NULL),(435,'pl',NULL),(435,'ru',NULL),(436,'de',NULL),(436,'el',NULL),(436,'es',NULL),(436,'fr',NULL),(436,'it',NULL),(436,'ja',NULL),(436,'pl',NULL),(436,'ru',NULL),(437,'de',NULL),(437,'el',NULL),(437,'es',NULL),(437,'fr',NULL),(437,'it',NULL),(437,'ja',NULL),(437,'pl',NULL),(437,'ru',NULL),(438,'de',NULL),(438,'el',NULL),(438,'es',NULL),(438,'fr',NULL),(438,'it',NULL),(438,'ja',NULL),(438,'pl',NULL),(438,'ru',NULL),(439,'de',NULL),(439,'el',NULL),(439,'es',NULL),(439,'fr',NULL),(439,'it',NULL),(439,'ja',NULL),(439,'pl',NULL),(439,'ru',NULL),(440,'de',NULL),(440,'el',NULL),(440,'es',NULL),(440,'fr',NULL),(440,'it',NULL),(440,'ja',NULL),(440,'pl',NULL),(440,'ru',NULL),(441,'de',NULL),(441,'el',NULL),(441,'es',NULL),(441,'fr',NULL),(441,'it',NULL),(441,'ja',NULL),(441,'pl',NULL),(441,'ru',NULL),(442,'de',NULL),(442,'el',NULL),(442,'es',NULL),(442,'fr',NULL),(442,'it',NULL),(442,'ja',NULL),(442,'pl',NULL),(442,'ru',NULL);
/*!40000 ALTER TABLE `translated_informations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user2games`
--

DROP TABLE IF EXISTS `user2games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user2games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user2games_game_id` (`game_id`),
  KEY `fk_user2games_group_id` (`group_id`),
  KEY `fk_user2games_user_id` (`user_id`),
  CONSTRAINT `fk_user2games_game_id` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user2games_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user2games_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user2games`
--

LOCK TABLES `user2games` WRITE;
/*!40000 ALTER TABLE `user2games` DISABLE KEYS */;
/*!40000 ALTER TABLE `user2games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ident` varchar(50) DEFAULT NULL COMMENT 'Beispielsweise die Matrikelnummer',
  `organisation` varchar(50) DEFAULT NULL,
  `password_md5` varchar(40) DEFAULT NULL,
  `blocked` tinyint(4) DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_mod` tinyint(1) DEFAULT '0',
  `cookieauthkey` varchar(50) DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `max_groups` int(11) DEFAULT '0',
  `max_games` int(11) DEFAULT '0',
  `max_user_per_group` int(11) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (7,'Andreas','Vratny','andreas@vratny.de','33764','Hochschule','e10adc3949ba59abbe56e057f20f883e',0,1,1,'d4b221ae3a6db9e29235e65fafc3b07e','2024-08-15',100,100,100,'2013-11-30 14:43:24'),(8,'Marius','Heinemann-Grüder','marius.hg@live.de','34229','HS KA4','e10adc3949ba59abbe56e057f20f883e',0,1,1,'6e87b2bc1133a0b3f2a7f1901df6f089',NULL,1,1,1,'2014-03-23 14:11:06'),(9,'Rest','Test','test@rest.de','RESTTEST','HS KA','e10adc3949ba59abbe56e057f20f883e',0,1,0,NULL,'0000-00-00',0,0,0,'2014-03-28 06:36:59');
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

-- Dump completed on 2014-09-24 10:48:48
