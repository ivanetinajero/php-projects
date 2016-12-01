-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: trello
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.14.04.1

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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `oauth_token` varchar(100) NOT NULL,
  `oauth_token_secret` varchar(100) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'ivan117','e5ba41927e73246f3b98774613807eea897c1f0b0fa05c147b9b160f0ec7176e','',1),(9,'sophirita','87f15001a67717564224926a18e0c519a0308e45f8b52267e9be668c2aec34d4','',1),(10,'juanjo50','c5905f092082474dd1c67c77e22600a8117363d5446703cd11cb7c0959ca87da','',1),(12,'josevizcaya','98fffc2363aa3050e30c861518f6c04cd34c96a7ba884ab3d4f17281ffdf10fc','',1),(13,'alejandromadariaganavarrete','52ff90b7a2379692dc2b1b050c4fe53e8977c4360b4a27dd7fae41901947fa0b','',1),(14,'ivanetinajero','c7f6a462e8c5177ef0e425b7ff872417a4ccb392b21f573ba5b24e595965c0e9','',1),(15,'mariamota1','9ab48288c7e5a973040f18ce85658e7c0921812244d9fe628bab230041b46445','',1),(16,'pablosantillan1','d1b44b141b8fcf035ede181ade40da814b5c12ea9ddfa58035709ef252a11785','',1),(17,'anagonzaleztapia','b072e11085ddee0cb066a189c02b0b24d3ddc1987085825e4a9d5370aa7e350c','',1),(18,'jarturomora','88d9c9614feead6d3e1f0dacead0c477b0c17b6197cbd1ca8c9306e4651c428a','',1);
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

-- Dump completed on 2015-12-23 17:45:03
