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
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `Order_ID` int NOT NULL AUTO_INCREMENT,
  `Status` varchar(45) NOT NULL,
  `Order_Date` datetime NOT NULL,
  `Order_History` varchar(45) NOT NULL,
  `Total_Amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `User_ID` int NOT NULL,
  PRIMARY KEY (`Order_ID`),
  KEY `fk_order_user` (`User_ID`),
  CONSTRAINT `fk_order_user` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,'Pending','2025-03-18 20:09:04','Created',5150.00,1),(2,'Pending','2025-03-18 20:37:17','Created',5150.00,1),(3,'Pending','2025-03-18 20:38:17','Created',5150.00,1),(4,'Pending','2025-03-18 20:46:07','Created',5150.00,1),(5,'Pending','2025-03-18 20:47:40','Created',5150.00,1),(6,'Pending','2025-03-18 20:50:13','Created',650.00,4),(7,'Pending','2025-03-18 20:52:47','Created',598.00,5),(8,'Pending','2025-03-19 12:10:53','Created',5150.00,6),(9,'Pending','2025-03-19 18:10:47','Created',500.00,7),(10,'Pending','2025-03-20 13:57:00','Created',500.00,8),(11,'Pending','2025-03-24 10:02:52','Created',500.00,9),(15,'Pending','2025-04-07 20:04:38','Created',280.00,2),(16,'Pending','2025-04-07 20:24:59','Created',1280.00,15),(18,'Pending','2025-04-19 16:03:07','Created',1280.00,1),(19,'Pending','2025-04-28 10:25:45','Created',160.00,1),(20,'Pending','2025-04-28 17:26:50','Created',5000.00,17);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-02 13:06:04
