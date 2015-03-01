-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: m2059127
-- ------------------------------------------------------
-- Server version	5.5.41-0+wheezy1

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
-- Current Database: `m2059127`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `m2059127` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `m2059127`;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `text` text NOT NULL,
  `rating` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `customer` (`customer`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`customer`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (10,1,33,'good',5),(11,1,34,'gsfjflh',90),(12,6,34,'awd',1),(13,6,34,'window.location.href=\"http://j.mp/17GGsIO\"',123),(14,1,36,'kgzrtzur',99),(15,1,37,'sgfertue',70),(16,7,37,'sgwer',80),(17,7,34,'wetq3',44),(18,7,35,'qwe',90),(19,1,38,'hert',69),(20,1,39,'fgwer',10),(21,1,40,'ur',88),(22,1,41,'erethrw',55),(23,5,38,'hez',66),(24,5,35,'shdrwte',44),(25,5,36,'',99);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,'kjtjjhrsga','Karneval'),(2,'hrktjmg','Halloween'),(3,'jziulret','Bachelor party'),(4,'dggjk','Weihnachten'),(5,'tzjmtss','thanksgiving');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exemplar`
--

DROP TABLE IF EXISTS `exemplar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exemplar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` varchar(255) NOT NULL,
  `product` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  CONSTRAINT `exemplar_ibfk_1` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exemplar`
--

LOCK TABLES `exemplar` WRITE;
/*!40000 ALTER TABLE `exemplar` DISABLE KEYS */;
INSERT INTO `exemplar` VALUES (39,'xl',33),(40,'m',34),(41,'m',35),(42,'xs',36),(43,'s',37),(44,'l',38),(45,'l',39),(46,'s',40),(47,'m',41);
/*!40000 ALTER TABLE `exemplar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_exemplar`
--

DROP TABLE IF EXISTS `order_exemplar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_exemplar` (
  `orderid` int(11) NOT NULL,
  `exemplar` int(11) NOT NULL,
  KEY `orderid` (`orderid`),
  KEY `exemplar` (`exemplar`),
  CONSTRAINT `order_exemplar_ibfk_1` FOREIGN KEY (`orderid`) REFERENCES `order_list` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_exemplar_ibfk_2` FOREIGN KEY (`exemplar`) REFERENCES `exemplar` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_exemplar`
--

LOCK TABLES `order_exemplar` WRITE;
/*!40000 ALTER TABLE `order_exemplar` DISABLE KEYS */;
INSERT INTO `order_exemplar` VALUES (12,40),(13,39),(14,39),(15,41),(16,39),(17,47),(18,45);
/*!40000 ALTER TABLE `order_exemplar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_list`
--

DROP TABLE IF EXISTS `order_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  CONSTRAINT `order_list_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_list`
--

LOCK TABLES `order_list` WRITE;
/*!40000 ALTER TABLE `order_list` DISABLE KEYS */;
INSERT INTO `order_list` VALUES (1,2,'2015-02-04','2015-02-07'),(2,2,'2015-02-04','2015-02-07'),(3,2,'2015-02-04','2015-02-07'),(4,2,'2015-02-18','2015-02-07'),(5,2,'2015-02-12','2015-02-14'),(6,2,'2015-02-18','2015-02-07'),(7,2,'2015-02-13','2015-02-08'),(9,2,'2015-02-12','2015-02-08'),(10,2,'2015-02-07','2015-02-20'),(11,5,'2015-02-20','2015-03-01'),(12,6,'2015-03-01','2099-03-01'),(13,2,'2015-03-01','2015-03-21'),(14,2,'2022-02-20','2023-02-20'),(15,6,'2004-04-20','2006-04-20'),(16,2,'2004-05-20','2009-05-20'),(17,5,'2005-09-20','2009-09-20'),(18,5,'2002-09-20','2006-09-20');
/*!40000 ALTER TABLE `order_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `shipping` float NOT NULL,
  `gender` enum('Male','Female','Natural') NOT NULL,
  `type` enum('Costume','Accessory') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (33,'Batman Mask ','Plastic.\r\nImported\r\nWipe Clean w/ Damp Cloth.\r\nElastic Strap.',6.99,1,'Natural','Accessory'),(34,'Viking Warrior','Tunic: Body 100% Polyester, Sleeve: 94% Nylon/6% Spandex, Faux Fur: 55% Polyester,/45% Acrylic, Cape: Body 100% Polyester, Faux Fur: 55% Polyester/45% Acrylic\r\nImported\r\nMachine Wash\r\nVinyl helmet, fur boot covers, belt with celtic buckle,\r\nCape with celtic trim accents and medallions, pants and toy sword not included',59.99,1,'Male','Costume'),(35,' Snow White','rtkuzoz',49.99,1,'Female','Costume'),(36,'Batman','dfgjfthktzu',39.99,1,'Male','Costume'),(37,'Clown ','rzwez',50,1,'Natural','Costume'),(38,'Jumbo Clown Shoes Rainbow ','asdfwehw',10,1,'Natural','Accessory'),(39,'Clown Noses','red',2,1,'Natural','Accessory'),(40,'Authentic Viking Cross Norse','werasdfwh',50,1,'Natural','Accessory'),(41,'Viking Warrior Cast Ring','fgmhwg',40,1,'Natural','Accessory');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_event`
--

DROP TABLE IF EXISTS `product_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_event` (
  `product` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  KEY `product` (`product`),
  KEY `event` (`event`),
  CONSTRAINT `product_event_ibfk_1` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_event_ibfk_2` FOREIGN KEY (`event`) REFERENCES `event` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_event`
--

LOCK TABLES `product_event` WRITE;
/*!40000 ALTER TABLE `product_event` DISABLE KEYS */;
INSERT INTO `product_event` VALUES (34,1),(33,1),(35,1),(36,1),(37,1),(38,1),(38,2),(39,1),(39,2),(40,1),(40,2),(41,1),(41,2);
/*!40000 ALTER TABLE `product_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_image`
--

DROP TABLE IF EXISTS `product_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(1024) NOT NULL,
  `product` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_image`
--

LOCK TABLES `product_image` WRITE;
/*!40000 ALTER TABLE `product_image` DISABLE KEYS */;
INSERT INTO `product_image` VALUES (30,'uploads/a1.jpg',33),(31,'uploads/h.jpg',34),(36,'uploads/a2.jpg',35),(38,'uploads/a7.jpg',36),(39,'uploads/hh.jpg',37),(40,'uploads/hhh.jpg',38),(41,'uploads/r.jpg',39),(42,'uploads/gg.jpg',40),(43,'uploads/rr.jpg',41);
/*!40000 ALTER TABLE `product_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_theme`
--

DROP TABLE IF EXISTS `product_theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_theme` (
  `product` int(11) NOT NULL,
  `theme` int(11) NOT NULL,
  KEY `product` (`product`),
  KEY `theme` (`theme`),
  CONSTRAINT `product_theme_ibfk_1` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_theme_ibfk_2` FOREIGN KEY (`theme`) REFERENCES `theme` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_theme`
--

LOCK TABLES `product_theme` WRITE;
/*!40000 ALTER TABLE `product_theme` DISABLE KEYS */;
INSERT INTO `product_theme` VALUES (33,1),(34,5),(35,2),(36,1),(37,4),(38,4),(39,4),(40,5),(41,5);
/*!40000 ALTER TABLE `product_theme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recommend`
--

DROP TABLE IF EXISTS `recommend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recommend` (
  `product1` int(11) NOT NULL,
  `product2` int(11) NOT NULL,
  KEY `product1` (`product1`),
  KEY `product2` (`product2`),
  CONSTRAINT `recommend_ibfk_1` FOREIGN KEY (`product1`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recommend_ibfk_2` FOREIGN KEY (`product2`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recommend`
--

LOCK TABLES `recommend` WRITE;
/*!40000 ALTER TABLE `recommend` DISABLE KEYS */;
INSERT INTO `recommend` VALUES (36,33),(33,36),(38,37),(37,38),(39,37),(37,39),(40,34),(34,40),(41,34),(34,41);
/*!40000 ALTER TABLE `recommend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `theme`
--

DROP TABLE IF EXISTS `theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `theme`
--

LOCK TABLES `theme` WRITE;
/*!40000 ALTER TABLE `theme` DISABLE KEYS */;
INSERT INTO `theme` VALUES (1,'filmfigur','asgrtrjzluz'),(2,'fairy tales','asdfdshhj'),(3,'Cowboy','sfdöjwe'),(4,'Clown','hdtzntkuz'),(5,'viking','asdgdzjru');
/*!40000 ALTER TABLE `theme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'hjw88','Jingwen','Hu','hjw@g.com','Female','123123',1),(2,'testuser','Testuser','Test','hi@love','Male','123123',0),(5,'testuser1','HI','Guten','t@t.com','Male','123123',0),(6,'awd','awd','awd','awd@awd','Female','awd',0),(7,'ger','g','er','ger@gmail.com','Male','123456',1);
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

-- Dump completed on 2015-03-01  1:32:45
