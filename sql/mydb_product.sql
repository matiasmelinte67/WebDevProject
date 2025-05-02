-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: mydb
-- ------------------------------------------------------
-- Server version	8.0.39

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
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `Product_ID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Price` int NOT NULL,
  `Category` varchar(45) NOT NULL,
  `Stock` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `Admin_Admin_ID` int NOT NULL,
  `Description` text,
  PRIMARY KEY (`Product_ID`),
  KEY `fk_Product_Admin1_idx` (`Admin_Admin_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Thermaltake CPU Cooler',80,'Cooling',50,'images/cooler.jpg',1,'High-performance CPU air cooler with dual fans and heat pipes.'),(2,'NVIDIA RTX 5090',2500,'Graphics Card',10,'images/rtx.png',1,'The NVIDIA RTX 5090 is the ultimate next-gen graphics card, delivering unmatched performance with cutting-edge AI rendering and ray tracing. Featuring 48GB GDDR7 memory, DLSS 4.0, and 3rd-gen RT cores, it is built for 8K gaming, high-end content creation, and AI workloads.'),(3,'AMD Ryzen 5 9000 Series',300,'Processor',40,'images/cpu.jpg',1,'Powerful AMD Ryzen 5 9000 series processor for gaming and productivity.'),(4,'ASUS ROG STRIX Motherboard',250,'Motherboard',30,'images/motherboard.jpg',1,'High-end gaming motherboard with support for latest Intel processors.'),(5,'GIGABYTE P1000GM 1000W  Power Supply',140,'Power Supply',70,'images/psu.jpg',1,'The GIGABYTE P1000GM is a high-performance 1000W fully modular power supply featuring 80 PLUS Gold certification, delivering efficient, reliable power for gaming and high-end PC builds.'),(6,'Nvidia RTX 4090',500,'Graphics Card',20,'images/rtx1.jpg',1,'The NVIDIA RTX 4090 is a top-tier GPU delivering extreme performance, advanced ray tracing, and AI-powered graphics.');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-02 13:06:05
