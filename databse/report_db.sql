-- MySQL dump 10.13  Distrib 8.0.25, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: report_db
-- ------------------------------------------------------
-- Server version	5.7.34-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `user_access`
--

DROP TABLE IF EXISTS `user_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_access` (
  `RecID` int(11) NOT NULL AUTO_INCREMENT,
  `firtname` varchar(345) DEFAULT NULL,
  `lastname` varchar(345) DEFAULT NULL,
  `middlename` varchar(345) DEFAULT NULL,
  `email` varchar(245) DEFAULT NULL,
  `username` varchar(245) DEFAULT NULL,
  `password` varchar(345) DEFAULT NULL,
  `phone_number` varchar(12) DEFAULT NULL,
  `user_type` varchar(245) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lang` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `Status` int(11) DEFAULT '0',
  PRIMARY KEY (`RecID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_access`
--

LOCK TABLES `user_access` WRITE;
/*!40000 ALTER TABLE `user_access` DISABLE KEYS */;
INSERT INTO `user_access` VALUES (1,'John javier','Romero','Romero','johnjavieridmilao12@gmail.com','jhayjhay','f0a226b7092c7bc6b1fff499d62630a0d6ac9ea0','639750148734','admin',NULL,NULL,'2021-08-09 15:24:01',1),(3,'Reggie','Ngenge','R.','johnjavieridmilao12@gmail.com','reggie','f0a226b7092c7bc6b1fff499d62630a0d6ac9ea0','639750148734','user',16.9247,121.746,'2021-08-10 02:58:38',1),(4,'Clarise','Dana','Dana','clarise@gmail.com','clarise','f0a226b7092c7bc6b1fff499d62630a0d6ac9ea0','639750148734','user',16.9411,121.743,'2021-08-12 03:07:08',1),(5,'Maribel','Idmilao','Romero','maribel@gmail.com','maribel','f0a226b7092c7bc6b1fff499d62630a0d6ac9ea0','639750148734','user',16.9411,121.743,'2021-08-13 00:54:53',1),(7,'TEST','TEST','TEST','test@gmail.com','test','4028a0e356acc947fcd2bfbf00cef11e128d484a','6332323232','user',NULL,NULL,'2021-10-18 06:33:50',1),(8,'TEST','TEST','TEST','johnjavieridmilao12@gmail.com','TEST','f5435753d769c58217a8439d42cfe1cabaaa31a4','09750148734','user',16.9247,121.746,'2021-10-18 07:16:22',1);
/*!40000 ALTER TABLE `user_access` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-20 23:15:06
