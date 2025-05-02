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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `User_ID` int NOT NULL AUTO_INCREMENT,
  `Email` varchar(45) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `First_Name` varchar(45) NOT NULL,
  `Last_Name` varchar(45) NOT NULL,
  PRIMARY KEY (`User_ID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'davidmatiasmelinte@gmail.com','$2y$10$XNo8jR7hQiopFK4spaR4wOSABCvbDGiSJEj29Hffc2XeMpqP3JUsq','Matias','Melinte'),(2,'geo_lidya2008@yahoo.com','$2y$10$2.PQLZ9hoDj276sVODh.5Oy2TCGR/qFC1PGVUK7z2b7lCBsqf3qSK','Matias','Melinte'),(3,'B00160765@mytudublin.ie','$2y$10$v1IfrjT2zDyzDv8XaxZE1OF3tRsgwSYXERqMqN5RjmesIv10vVOGC','Matias','Timotei'),(4,'lidiamelinte1983@yahoo.com','$2y$10$bLNj3qQDOPC0izXIvwkgbOWJ.dENeXeAQOpu6H5BwCIRZEbWno0By','Matias','Melinte'),(5,'davidmelinte2008@gmail.com','$2y$10$zxYULa7ggKW54xN9ujjct.LNIAAxqV1IkES5e0MUA/BC9BlkJaLbW','Gheorghe Ioan','Melinte'),(6,'david@gmail.com','$2y$10$mZP/ItlXNlsUXugGte7nkeeB4Y89PZvHeDJgemvjgVpjLPuYcD8Uq','Boss','Man'),(7,'vasiledeac15@gmail.com','$2y$10$w9U1K643O4OVLGOFJfF7o.lq6khNSRIOGUv/g5zD5Jp7MUYiiNAgy','Vasile','Deac'),(8,'matias@gmail.com','$2y$10$wFd7l5V.MWP0V.cxkGHDaulFZ5j/KViZiXECanYvUrWR8.0JPUi3a','Lucretia','Deac'),(9,'edwardlupea69@gmail.com','$2y$10$QiODD6n5urI0f8Trq5z/vuhGnbR4.IqEmw3b8RAFntkENY.cNvtVq','Edwrd','Lupea'),(11,'davidtheman@gmail.com','$2y$10$TxOhzdG6.xDFt1lvapKCTu5YHhIqXNBLrWcJKuA291aigQKYa4ulm','David','Melinte'),(15,'nathanmelinte@gmail.com','$2y$10$GmAZx8ci7kz8xjjBOTPMkel2owBlOIgDEXAL5XvjLQjty/vkqE2iu','Nathan','Melinte'),(17,'ioanghita@gmail.com','$2y$10$U.e7SfwFL6e4BtC8Wky/d.5AIn9lhiRuClbQK/8JKjXvlmHNxU6Au','Ioan','Ghita');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
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
