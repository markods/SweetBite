-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 17, 2020 at 04:59 PM
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
(0x5cc0ad40bd5f4b099ce68682e24cc2c6, 'bez glutena'),
(0x383c1a8376b845d4bf1e179dc6cd6160, 'posno'),
(0x8560ce1c4a8a4daab061b82637c9f2e2, 'vegetarijansko');

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
(0x029422b9d00040f29d329eeacf39bd33, 'admin', 'admin@nightbird.com', '+381000000000', '$2y$10$hrlXmLs2vxpE9yZJ7y6eDefdAB91oC81LAn4VRb2K.Vefx2uLTjoq', 0x91a95e1b81344f8288a8662500bd65f7, '2020-05-17 11:43:09', NULL),
(0x4b2a88b725c44765ab31c0fbdb887c3c, 'menadzer', 'menadzer@nightbird.com', '+381111111111', '$2y$10$CVFt3zyrBGGPqnTQK1reLOVQ8eS4/7MWsRNcRg1MSI0FwcVs/MpMG', 0xe5ef4d68aac64f01b1a67d596ed0d1ad, '2020-05-17 11:43:13', NULL),
(0x82c2597ce6c142f2ad52721a7c451fb5, 'kuvar', 'kuvar@nightbird.com', '+381222222222', '$2y$10$tA53BBG5ePe5vGGQwiN5xudVTaeak9.DZd7I.goaOOKilzyco.Zu.', 0x85b99b2124be4391ad52924db0ffb505, '2020-05-17 11:43:16', NULL),
(0xd11a8f715c1b4e3da9c22657b09c0f34, 'korisnik', 'korisnik@nightbird.com', '+381333333333', '$2y$10$3.0w/EOHplwFExZDE/uwUeYYUudEq/jy3qwQRopdAe1S8StqxRH2G', 0x720cfc11e2cc468d8a4771d9423d957b, '2020-05-17 11:43:16', NULL);

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
(0xa418a46ae3a14e39b902c070460f50f9, 'krštenje'),
(0xa0e2230cca074bf892f552722465f19d, 'ostalo'),
(0xfa2c4784991347bebc3fd24677e87dc8, 'proslava'),
(0x9a87553630b044c68a0041e83ace9569, 'radije ne bih naveo/la'),
(0x696bbcbc37ac4af7a3a8a041e367da8d, 'rođendan'),
(0x7e800afa95804bfaa41dcd131439101b, 'slava'),
(0x255e9a20a9064384826a4b9e40354a8c, 'venčanje'),
(0x1b902141d95540859f6f85984e60bc43, 'žurka');

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
(0xf1019678986b497da2ee45fb6dc413b8, 'Čorba'),
(0xda899e322ddb4ddd904a41bd42b1944d, 'Kolač'),
(0x7f27f6c5cbdf4c62918dc2421f21fafb, 'Kuvano jelo'),
(0x43cdf9fefd4645f9a23853034a415bef, 'Morski plodovi'),
(0xf6a58ebadbbc419a9a57ab5b47bdf101, 'Pasta'),
(0x7d6d5f889b704458a3f589e2e2d3ed7c, 'Pecivo'),
(0xc182321ee3944514b4118e411d22ae05, 'Pica'),
(0xe1a4f5f489624f3a85f76e2c2656693b, 'Pita'),
(0x763ec829046c4b2e8d26e7d1da421a18, 'Predjelo'),
(0x56f68b9feb51485091faaa357de963d5, 'Riba'),
(0xf47e92376ee8426181e2e169a189f43f, 'Roštilj'),
(0x36d8683af023437fb2a26e2ecd706bf4, 'Salata'),
(0x4e5b3e2330814c5b8f7e874af88d0d17, 'Supa'),
(0x400d1b5f92894f7784c40599644ff033, 'Torta');

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
(0x91a95e1b81344f8288a8662500bd65f7, 'Admin'),
(0x720cfc11e2cc468d8a4771d9423d957b, 'Korisnik'),
(0x85b99b2124be4391ad52924db0ffb505, 'Kuvar'),
(0xe5ef4d68aac64f01b1a67d596ed0d1ad, 'Menadzer');

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
(0x1438864505414711a05bf98091d31e1d, 'ljuto'),
(0x038c317d2d37443b835a11ecfe707cb4, 'slano'),
(0xe1ac2db3ffa1498893fe96b8e93caf45, 'slatko');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
