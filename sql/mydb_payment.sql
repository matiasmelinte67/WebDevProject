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
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment` (
  `Payment_ID` int NOT NULL AUTO_INCREMENT,
  `Payment_Method` varchar(50) DEFAULT NULL,
  `Shipping` varchar(255) DEFAULT NULL,
  `Order_Order_ID` int NOT NULL,
  `Order_Product_Product_ID` int DEFAULT NULL,
  PRIMARY KEY (`Payment_ID`),
  KEY `fk_Payment_Order1_idx` (`Order_Order_ID`,`Order_Product_Product_ID`),
  CONSTRAINT `fk_Payment_Order1` FOREIGN KEY (`Order_Order_ID`) REFERENCES `order` (`Order_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (1,'Credit Card','10 Allendale Elms, Blanchardstown, Dublin, D15 C9W0',5,NULL),(2,'Credit Card','10 Allendale Elms, Blanchardstown, Dublin, D15 C9W0',6,NULL),(3,'Credit Card','58 Rusheeney Park, Blanchardstown, Dublin, D15 C9W0',7,NULL),(4,'Credit Card','58 Rusheeney Park, Maieru, Dublin, D15 C9W0',8,NULL),(5,'Credit Card','8 The Mills, Castleknock, Dublin, D15 C9W0',9,NULL),(6,'Credit Card','10 Allendale Elms, Blanchardstown, Dublin, D15 C9W0',10,NULL),(7,'Credit Card','10 Allendale Elms, Blanchardstown, Dublin, D15 C9W0',11,NULL),(11,'Credit Card','10 Allendale Elms, Maieru, Dublin, D15 C9W0',15,NULL),(12,'Credit Card','69 Littlepace Bendover, Blanchardstown, Dublin, D15 C9W0',16,NULL),(14,'Credit Card','10 Allendale Elms, Blanchardstown, Dublin, D15 C9W0',18,NULL),(15,'Credit Card','10 Allendale Elms, Blanchardstown, Dublin, D15 C9W0',19,NULL),(16,'Credit Card','10 Allendale Elms, Blanchardstown, Dublin, D15 C9W0',20,NULL);
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
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
