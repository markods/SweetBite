-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 22, 2020 at 02:11 PM
-- Server version: 8.0.18
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slatkizalogaj`
--
CREATE DATABASE IF NOT EXISTS `slatkizalogaj` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `slatkizalogaj`;

-- --------------------------------------------------------

--
-- Table structure for table `dijeta`
--

DROP TABLE IF EXISTS `dijeta`;
CREATE TABLE IF NOT EXISTS `dijeta` (
  `dijeta_id` binary(16) NOT NULL,
  `dijeta_naziv` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`dijeta_id`),
  UNIQUE KEY `dijeta_id_UNIQUE` (`dijeta_id`),
  UNIQUE KEY `dijeta_naziv_UNIQUE` (`dijeta_naziv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dijeta`
--

INSERT INTO `dijeta` (`dijeta_id`, `dijeta_naziv`) VALUES
(0x1e8d7478ff3044799549db534acb332d, 'Bez glutena'),
(0x0157be8cf8c64c93957d71cad57ff4ca, 'Bez laktoze'),
(0x11508ef7c4b34898b97b16519dfd6525, 'Mrsno'),
(0x1e12ccceb44c4af99790395337818906, 'Nije dijetalno'),
(0xc0f19e9164e44ccd97cb26c80acb34fb, 'Posno'),
(0x35816bc86dba40858cc551e8aa8749cc, 'Vegansko'),
(0xada26c3cede6489bb1f2c28ed52da0de, 'Vegetarijansko');

-- --------------------------------------------------------

--
-- Table structure for table `fav`
--

DROP TABLE IF EXISTS `fav`;
CREATE TABLE IF NOT EXISTS `fav` (
  `fav_id` binary(16) NOT NULL,
  `fav_kor_id` binary(16) NOT NULL,
  `fav_jelo_id` binary(16) NOT NULL,
  PRIMARY KEY (`fav_id`),
  UNIQUE KEY `fav_id_UNIQUE` (`fav_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jelo`
--

DROP TABLE IF EXISTS `jelo`;
CREATE TABLE IF NOT EXISTS `jelo` (
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

-- --------------------------------------------------------

--
-- Table structure for table `kor`
--

DROP TABLE IF EXISTS `kor`;
CREATE TABLE IF NOT EXISTS `kor` (
  `kor_id` binary(16) NOT NULL,
  `kor_naziv` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `kor_email` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `kor_tel` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `kor_pwdhash` char(128) NOT NULL,
  `kor_tipkor_id` binary(16) NOT NULL,
  `kor_datkre` datetime NOT NULL,
  `kor_datuklanj` datetime DEFAULT NULL,
  PRIMARY KEY (`kor_id`),
  UNIQUE KEY `kor_id_UNIQUE` (`kor_id`),
  UNIQUE KEY `kor_email_UNIQUE` (`kor_email`),
  UNIQUE KEY `kor_pwdhash_UNIQUE` (`kor_pwdhash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kor`
--

INSERT INTO `kor` (`kor_id`, `kor_naziv`, `kor_email`, `kor_tel`, `kor_pwdhash`, `kor_tipkor_id`, `kor_datkre`, `kor_datuklanj`) VALUES
(0x5c3cc08a3fa34e9dadeb034698c39e41, 'admin', 'admin@nightbird.com', '+381000000000', '$2y$10$isBjozKorcgcvVRcf3rqSurbY6OUX.OZJSny1YVNhGRB.mIGMDnYe', 0xfd212504b62c4c31ada1707cc6cf6f3e, '2020-05-22 08:51:26', NULL),
(0x60ef332158214aa483c8b53aeb28898a, 'menadzer', 'menadzer@nightbird.com', '+381111111111', '$2y$10$mamTgRHPYUXZYuvTOEruTOOIMLlqcWNNt4C2fooW0IKSsITa5.VIS', 0xf23cf09a4b994bf580e88224a1a0589a, '2020-05-22 08:51:26', NULL),
(0xd73e606df77b42abbedcfd63c29ff78d, 'kuvar', 'kuvar@nightbird.com', '+381222222222', '$2y$10$N3BYdXcgMi.vCDKN3Oh4NewGIDVWLZSeQSzoIcYER0Ug3dwWKV3dK', 0xb6c2dcdc4bf0405b9fc763f7c4373e5f, '2020-05-22 08:51:26', NULL),
(0xd95b5211352e4b13b151e89f1181d00a, 'korisnik', 'korisnik@nightbird.com', '+381333333333', '$2y$10$QD1M030H2UaZoh4FMhFSDO5tXRqfNHYol9gAumJ2K1e9jgj6b2Kl6', 0x6454cab9746e4d388a766c9a83df41b6, '2020-05-22 08:51:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `por`
--

DROP TABLE IF EXISTS `por`;
CREATE TABLE IF NOT EXISTS `por` (
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

-- --------------------------------------------------------

--
-- Table structure for table `povod`
--

DROP TABLE IF EXISTS `povod`;
CREATE TABLE IF NOT EXISTS `povod` (
  `povod_id` binary(16) NOT NULL,
  `povod_opis` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`povod_id`),
  UNIQUE KEY `povod_id_UNIQUE` (`povod_id`),
  UNIQUE KEY `povod_opis_UNIQUE` (`povod_opis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `povod`
--

INSERT INTO `povod` (`povod_id`, `povod_opis`) VALUES
(0x9061d7c288d44ffabcea40358c8ebfeb, 'Krštenje'),
(0xb3d78185370348ffb71c4a121f908d2a, 'Ostalo'),
(0x1b0ae3daa5b646aa8dcb0ee003ee5238, 'Proslava'),
(0x436056c2fd79404da8840db4b97f9309, 'Radije ne bih naveo/la'),
(0x4010362b95a643ab9da10ed6223a1701, 'Rođendan'),
(0x71d6ba2879184f9498e23ed6f44bff81, 'Slava'),
(0xcfde0a7a446f4e79beefb328a776006a, 'Venčanje'),
(0xf3ace07fc62541f78338ad044999b43a, 'Žurka');

-- --------------------------------------------------------

--
-- Table structure for table `stavka`
--

DROP TABLE IF EXISTS `stavka`;
CREATE TABLE IF NOT EXISTS `stavka` (
  `stavka_id` binary(16) NOT NULL,
  `stavka_por_id` binary(16) NOT NULL,
  `stavka_jelo_id` binary(16) NOT NULL,
  `stavka_kol` int(11) NOT NULL,
  `stavka_cenakom` decimal(15,2) NOT NULL,
  `stavka_datkre` datetime NOT NULL,
  `stavka_datizrade` datetime DEFAULT NULL,
  PRIMARY KEY (`stavka_id`),
  UNIQUE KEY `stavka_id_UNIQUE` (`stavka_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipjela`
--

DROP TABLE IF EXISTS `tipjela`;
CREATE TABLE IF NOT EXISTS `tipjela` (
  `tipjela_id` binary(16) NOT NULL,
  `tipjela_naziv` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`tipjela_id`),
  UNIQUE KEY `tipjela_id_UNIQUE` (`tipjela_id`),
  UNIQUE KEY `tipjela_naziv_UNIQUE` (`tipjela_naziv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tipjela`
--

INSERT INTO `tipjela` (`tipjela_id`, `tipjela_naziv`) VALUES
(0xc291761a691c431bacdccc9cf8e332c9, 'Čorba'),
(0x952af6ad208948a8ad565335a12fcc67, 'Kolač'),
(0x731edc748dbb4dd89c8b266b798a0d9c, 'Kuvano jelo'),
(0x101330b5281f460c9cbeab7c21aa16f3, 'Morski plodovi'),
(0xa8626bec7e1143e0b5cdb5824a8bfea4, 'Pasta'),
(0x49cbd79491a649289af11db1b563cfcf, 'Pecivo'),
(0x874182da722641c2bdd9e5fc4d799ecd, 'Pica'),
(0xcaf73ab0c8de475dbacad7834749d401, 'Pita'),
(0xbcc3160940704cb8bcabbda5a589cf46, 'Predjelo'),
(0x7d54c7d379174be082ac3f685f473a5b, 'Riba'),
(0xad136d9bfbcd41c59bd19e8553619543, 'Roštilj'),
(0xc1534d7c136f4a649ba85fe157ce664d, 'Salata'),
(0xdee1170497a74988a92bd1434f0a4f2c, 'Supa'),
(0xeeaed40f38de4a758150c192e1d2abc0, 'Torta');

-- --------------------------------------------------------

--
-- Table structure for table `tipkor`
--

DROP TABLE IF EXISTS `tipkor`;
CREATE TABLE IF NOT EXISTS `tipkor` (
  `tipkor_id` binary(16) NOT NULL,
  `tipkor_naziv` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`tipkor_id`),
  UNIQUE KEY `tipkor_naziv_UNIQUE` (`tipkor_naziv`),
  UNIQUE KEY `tipkor_id_UNIQUE` (`tipkor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tipkor`
--

INSERT INTO `tipkor` (`tipkor_id`, `tipkor_naziv`) VALUES
(0xfd212504b62c4c31ada1707cc6cf6f3e, 'Admin'),
(0x6454cab9746e4d388a766c9a83df41b6, 'Korisnik'),
(0xb6c2dcdc4bf0405b9fc763f7c4373e5f, 'Kuvar'),
(0xf23cf09a4b994bf580e88224a1a0589a, 'Menadzer');

-- --------------------------------------------------------

--
-- Table structure for table `ukus`
--

DROP TABLE IF EXISTS `ukus`;
CREATE TABLE IF NOT EXISTS `ukus` (
  `ukus_id` binary(16) NOT NULL,
  `ukus_naziv` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`ukus_id`),
  UNIQUE KEY `ukus_id_UNIQUE` (`ukus_id`),
  UNIQUE KEY `ukus_naziv_UNIQUE` (`ukus_naziv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ukus`
--

INSERT INTO `ukus` (`ukus_id`, `ukus_naziv`) VALUES
(0x85e8bc3dcce149cf9ccbbd1de9bdecb4, 'Gorko'),
(0x7288397f043043e187137cd818561b84, 'Kiselo'),
(0x5d00911ffc2b475380b4cb299e8e8d18, 'Ljuto'),
(0xc4eb0b10f8d744849c942a36e4a59664, 'Slano'),
(0x369daaa2814b4a17811b8abd590d1b1a, 'Slatko');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
