CREATE DATABASE  IF NOT EXISTS `slatkizalogaj` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `slatkizalogaj`;
-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: slatkizalogaj
-- ------------------------------------------------------
-- Server version	8.0.18

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
-- Table structure for table `dijeta`
--

DROP TABLE IF EXISTS `dijeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dijeta` (
  `dijeta_id` binary(16) NOT NULL,
  `dijeta_naziv` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`dijeta_id`),
  UNIQUE KEY `dijeta_id_UNIQUE` (`dijeta_id`),
  UNIQUE KEY `dijeta_naziv_UNIQUE` (`dijeta_naziv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dijeta`
--

LOCK TABLES `dijeta` WRITE;
/*!40000 ALTER TABLE `dijeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `dijeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fav`
--

DROP TABLE IF EXISTS `fav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fav` (
  `fav_kor_id` binary(16) NOT NULL,
  `fav_jelo_id` binary(16) NOT NULL,
  PRIMARY KEY (`fav_id`),
  UNIQUE KEY `fav_id_UNIQUE` (`fav_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fav`
--

LOCK TABLES `fav` WRITE;
/*!40000 ALTER TABLE `fav` DISABLE KEYS */;
/*!40000 ALTER TABLE `fav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jelo`
--

DROP TABLE IF EXISTS `jelo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jelo` (
  `jelo_id` binary(16) NOT NULL,
  `jelo_naziv` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `jelo_opis` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `jelo_slika` mediumblob NOT NULL,
  `jelo_cena` float NOT NULL,
  `jelo_masa` int(11) NOT NULL,
  `jelo_tipjela_id` binary(16) NOT NULL,
  `jelo_ukus_id` binary(16) NOT NULL,
  `jelo_dijeta_id` binary(16) NOT NULL,
  `jelo_datkre` datetime NOT NULL,
  `jelo_datsakriv` datetime DEFAULT NULL,
  `jelo_datuklanj` datetime DEFAULT NULL,
  PRIMARY KEY (`jelo_id`),
  UNIQUE KEY `jelo_id_UNIQUE` (`jelo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jelo`
--

LOCK TABLES `jelo` WRITE;
/*!40000 ALTER TABLE `jelo` DISABLE KEYS */;
/*!40000 ALTER TABLE `jelo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kor`
--

DROP TABLE IF EXISTS `kor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kor` (
  `kor_id` binary(16) NOT NULL,
  `kor_naziv` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `kor_email` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `kor_tel` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `kor_pwdhash` binary(16) NOT NULL,
  `kor_tipkor_id` binary(16) NOT NULL,
  `kor_datkre` datetime NOT NULL,
  `kor_datuklanj` datetime DEFAULT NULL,
  PRIMARY KEY (`kor_id`),
  UNIQUE KEY `kor_id_UNIQUE` (`kor_id`),
  UNIQUE KEY `kor_email_UNIQUE` (`kor_email`),
  UNIQUE KEY `kor_pwdhash_UNIQUE` (`kor_pwdhash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kor`
--

LOCK TABLES `kor` WRITE;
/*!40000 ALTER TABLE `kor` DISABLE KEYS */;
/*!40000 ALTER TABLE `kor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `por`
--

DROP TABLE IF EXISTS `por`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `por` (
  `por_id` binary(16) NOT NULL,
  `por_kor_id` binary(16) NOT NULL,
  `por_naziv` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `por_povod_id` binary(16) NOT NULL,
  `por_br_osoba` int(11) NOT NULL,
  `por_za_dat` datetime NOT NULL,
  `por_popust_proc` decimal(5,2) DEFAULT NULL,
  `por_datkre` datetime NOT NULL,
  `por_datporuc` datetime DEFAULT NULL,
  `por_datodluke` datetime DEFAULT NULL,
  `por_odluka` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `por_datizrade` datetime DEFAULT NULL,
  `por_datpreuz` datetime DEFAULT NULL,
  PRIMARY KEY (`por_id`),
  UNIQUE KEY `por_id_UNIQUE` (`por_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `por`
--

LOCK TABLES `por` WRITE;
/*!40000 ALTER TABLE `por` DISABLE KEYS */;
/*!40000 ALTER TABLE `por` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `povod`
--

DROP TABLE IF EXISTS `povod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `povod` (
  `povod_id` binary(16) NOT NULL,
  `povod_opis` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`povod_id`),
  UNIQUE KEY `povod_id_UNIQUE` (`povod_id`),
  UNIQUE KEY `povod_opis_UNIQUE` (`povod_opis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `povod`
--

LOCK TABLES `povod` WRITE;
/*!40000 ALTER TABLE `povod` DISABLE KEYS */;
/*!40000 ALTER TABLE `povod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stavka`
--

DROP TABLE IF EXISTS `stavka`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stavka` (
  `stavka_por_id` binary(16) NOT NULL,
  `stavka_jelo_id` binary(16) NOT NULL,
  `stavka_kol` int(11) NOT NULL,
  `stavka_cenakom` decimal(15,2) NOT NULL,
  `stavka_datkre` datetime NOT NULL,
  `stavka_datizrade` datetime DEFAULT NULL,
  PRIMARY KEY (`stavka_id`),
  UNIQUE KEY `stavka_id_UNIQUE` (`stavka_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stavka`
--

LOCK TABLES `stavka` WRITE;
/*!40000 ALTER TABLE `stavka` DISABLE KEYS */;
/*!40000 ALTER TABLE `stavka` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipjela`
--

DROP TABLE IF EXISTS `tipjela`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipjela` (
  `tipjela_id` binary(16) NOT NULL,
  `tipjela_naziv` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`tipjela_id`),
  UNIQUE KEY `tipjela_id_UNIQUE` (`tipjela_id`),
  UNIQUE KEY `tipjela_naziv_UNIQUE` (`tipjela_naziv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipjela`
--

LOCK TABLES `tipjela` WRITE;
/*!40000 ALTER TABLE `tipjela` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipjela` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipkor`
--

DROP TABLE IF EXISTS `tipkor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipkor` (
  `tipkor_id` binary(16) NOT NULL,
  `tipkor_naziv` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`tipkor_id`),
  UNIQUE KEY `tipkor_naziv_UNIQUE` (`tipkor_naziv`),
  UNIQUE KEY `tipkor_id_UNIQUE` (`tipkor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipkor`
--

LOCK TABLES `tipkor` WRITE;
/*!40000 ALTER TABLE `tipkor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipkor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ukus`
--

DROP TABLE IF EXISTS `ukus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ukus` (
  `ukus_id` binary(16) NOT NULL,
  `ukus_naziv` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`ukus_id`),
  UNIQUE KEY `ukus_id_UNIQUE` (`ukus_id`),
  UNIQUE KEY `ukus_naziv_UNIQUE` (`ukus_naziv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ukus`
--

LOCK TABLES `ukus` WRITE;
/*!40000 ALTER TABLE `ukus` DISABLE KEYS */;
/*!40000 ALTER TABLE `ukus` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-01 23:16:03
