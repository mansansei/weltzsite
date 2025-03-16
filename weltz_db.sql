-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: weltz_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

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
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_logs` (
  `auditID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL DEFAULT 0,
  `actionType` varchar(50) NOT NULL DEFAULT '',
  `tableName` varchar(50) NOT NULL DEFAULT '',
  `recordID` int(11) NOT NULL DEFAULT 0,
  `oldValues` text DEFAULT NULL,
  `newValues` text DEFAULT NULL,
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`auditID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-16 10:38:10'),(2,1,'CREATE','users_tbl',3,NULL,'{\"userFname\":\"Ken\",\"userLname\":\"Gopez\",\"userAdd\":\"Valenzuela\",\"userPhone\":\"12345678910\",\"userEmail\":\"kristoffer.gopez.cics@ust.edu.ph\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-16 10:39:02'),(3,1,'CREATE','users_tbl',4,NULL,'{\"userFname\":\"Cyril\",\"userLname\":\"Labao\",\"userAdd\":\"Bacoor\",\"userPhone\":\"12345678910\",\"userEmail\":\"cyrillabao@gmail.com\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-16 10:39:43'),(4,1,'CREATE','users_tbl',5,NULL,'{\"userFname\":\"Dummy\",\"userLname\":\"Admin\",\"userAdd\":\"DummyCity\",\"userPhone\":\"12345678910\",\"userEmail\":\"dummy@email.com\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-16 10:40:21'),(5,1,'DELETE','users_tbl',5,'{\"userFname\":\"Dummy\",\"userLname\":\"Admin\",\"userAdd\":\"DummyCity\",\"userPhone\":\"12345678910\",\"userEmail\":\"dummy@email.com\"}',NULL,'2025-03-16 10:40:38'),(6,1,'UPDATE','users_tbl',2,'{\"userEmail\":\"mertisepic031@gmail.com\"}','{\"userEmail\":\"mertiscool031@gmail.com\"}','2025-03-16 10:43:34'),(7,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-16 10:44:55'),(8,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-16 12:25:26'),(9,1,'CREATE','products_tbl',8,NULL,'{\"userID\":1,\"productName\":\"testProduct\",\"productIMG\":\"..\\/images\\/products\\/low-poly-fire-hydrant-03_67d6b75b28f3e.jpg\",\"categoryID\":\"1\",\"productDesc\":\"this is a test description for test product\",\"productPrice\":\"1000000\",\"inStock\":\"1\"}','2025-03-16 12:34:51');
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs_tbl`
--

DROP TABLE IF EXISTS `blogs_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs_tbl` (
  `blogID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `blogIMG` text NOT NULL,
  `blogTitle` varchar(50) NOT NULL,
  `blogDesc` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`blogID`),
  UNIQUE KEY `blogTitle` (`blogTitle`),
  KEY `blogUserFK` (`userID`),
  CONSTRAINT `blogUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs_tbl`
--

LOCK TABLES `blogs_tbl` WRITE;
/*!40000 ALTER TABLE `blogs_tbl` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogs_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items_tbl`
--

DROP TABLE IF EXISTS `cart_items_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items_tbl` (
  `cartItemID` int(11) NOT NULL AUTO_INCREMENT,
  `cartID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cartItemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items_tbl`
--

LOCK TABLES `cart_items_tbl` WRITE;
/*!40000 ALTER TABLE `cart_items_tbl` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts_tbl`
--

DROP TABLE IF EXISTS `carts_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts_tbl` (
  `cartID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cartID`),
  KEY `cartUserFK` (`userID`),
  CONSTRAINT `cartUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts_tbl`
--

LOCK TABLES `carts_tbl` WRITE;
/*!40000 ALTER TABLE `carts_tbl` DISABLE KEYS */;
INSERT INTO `carts_tbl` VALUES (1,2,'2025-03-16 14:25:52','2025-03-16 14:25:52');
/*!40000 ALTER TABLE `carts_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories_tbl`
--

DROP TABLE IF EXISTS `categories_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_tbl` (
  `categoryID` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`categoryID`),
  UNIQUE KEY `categoryName` (`categoryName`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories_tbl`
--

LOCK TABLES `categories_tbl` WRITE;
/*!40000 ALTER TABLE `categories_tbl` DISABLE KEYS */;
INSERT INTO `categories_tbl` VALUES (1,'Fire Extinguisher','2025-03-07 10:42:00','2025-03-07 10:42:00'),(2,'Smoke Detector','2025-03-07 10:42:37','2025-03-07 10:42:37');
/*!40000 ALTER TABLE `categories_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modes_of_payment_tbl`
--

DROP TABLE IF EXISTS `modes_of_payment_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modes_of_payment_tbl` (
  `mopID` int(11) NOT NULL AUTO_INCREMENT,
  `mopName` varchar(50) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`mopID`),
  UNIQUE KEY `mopName` (`mopName`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modes_of_payment_tbl`
--

LOCK TABLES `modes_of_payment_tbl` WRITE;
/*!40000 ALTER TABLE `modes_of_payment_tbl` DISABLE KEYS */;
INSERT INTO `modes_of_payment_tbl` VALUES (1,'Cash on Pickup','2025-03-15 16:29:15','2025-03-15 16:29:15');
/*!40000 ALTER TABLE `modes_of_payment_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_statuses_tbl`
--

DROP TABLE IF EXISTS `order_statuses_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_statuses_tbl` (
  `statusID` int(11) NOT NULL AUTO_INCREMENT,
  `statusName` varchar(50) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`statusID`),
  UNIQUE KEY `statusName` (`statusName`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_statuses_tbl`
--

LOCK TABLES `order_statuses_tbl` WRITE;
/*!40000 ALTER TABLE `order_statuses_tbl` DISABLE KEYS */;
INSERT INTO `order_statuses_tbl` VALUES (1,'Processing','2025-03-13 16:40:50','2025-03-13 16:40:50'),(2,'To Pick Up','2025-03-13 16:40:58','2025-03-13 16:40:58'),(3,'Cancelled','2025-03-13 16:41:25','2025-03-13 16:41:25');
/*!40000 ALTER TABLE `order_statuses_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_tbl`
--

DROP TABLE IF EXISTS `orders_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_tbl` (
  `orderID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `orderQuantity` int(11) NOT NULL,
  `orderTotal` float NOT NULL DEFAULT 0,
  `mopID` int(11) NOT NULL,
  `statusID` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`orderID`),
  KEY `productOrderFK` (`productID`) USING BTREE,
  KEY `userOrderFK` (`userID`) USING BTREE,
  KEY `orderStatusFK` (`statusID`) USING BTREE,
  KEY `mopOrderFK` (`mopID`),
  CONSTRAINT `mopOrderFK` FOREIGN KEY (`mopID`) REFERENCES `modes_of_payment_tbl` (`mopID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `orderStatusFK` FOREIGN KEY (`statusID`) REFERENCES `order_statuses_tbl` (`statusID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `productOrderFK` FOREIGN KEY (`productID`) REFERENCES `products_tbl` (`productID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `userOrderFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_tbl`
--

LOCK TABLES `orders_tbl` WRITE;
/*!40000 ALTER TABLE `orders_tbl` DISABLE KEYS */;
INSERT INTO `orders_tbl` VALUES (4,2,4,5,11400,1,1,'2025-03-16 14:23:00','2025-03-16 14:23:00');
/*!40000 ALTER TABLE `orders_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_tbl`
--

DROP TABLE IF EXISTS `products_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_tbl` (
  `productID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `productName` varchar(50) NOT NULL,
  `productIMG` varchar(100) NOT NULL,
  `categoryID` int(11) DEFAULT NULL,
  `productDesc` text NOT NULL,
  `productPrice` float NOT NULL,
  `inStock` int(11) NOT NULL DEFAULT 0,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`productID`),
  UNIQUE KEY `productName` (`productName`),
  KEY `productCategoryFK` (`categoryID`) USING BTREE,
  KEY `productUserFK` (`userID`),
  CONSTRAINT `productCategoryFK` FOREIGN KEY (`categoryID`) REFERENCES `categories_tbl` (`categoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `productUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_tbl`
--

LOCK TABLES `products_tbl` WRITE;
/*!40000 ALTER TABLE `products_tbl` DISABLE KEYS */;
INSERT INTO `products_tbl` VALUES (1,1,'Dry Chemical Fire Extinguisher','../images/products/fire-ex_dry-chem.jpg',1,'A dry chemical fire extinguisher is a versatile and widely used firefighting device designed to combat various types of fires. It contains a dry chemical powder, such as monoammonium phosphate, which quickly extinguishes flames by interrupting the chemical reaction of the fire. These extinguishers are effective against Class A (ordinary combustibles), Class B (flammable liquids), and Class C (electrical) fires, making them essential for homes, offices, and industrial settings.',2149,0,'2025-03-07 10:56:42','2025-03-07 10:56:42'),(2,1,'HCFC-123 Fire Extinguisher','../images/products/fire-ex_HCFC-123.jpg',1,'The HCFC-123 fire extinguisher utilizes a clean agent called hydrochlorofluorocarbon-123 (HCFC-123) to suppress fires. It is highly effective for use in areas with sensitive electronic equipment, as it leaves no residue and causes minimal damage. This extinguisher is suitable for Class A, B, and C fires, making it an ideal choice for data centers, laboratories, and telecommunications facilities.',3499,0,'2025-03-07 10:58:51','2025-03-07 10:58:51'),(4,1,'AFFF Fire Extinguisher','../images/products/fire-ex_AFFF.jpg',1,'An Aqueous Film Forming Foam (AFFF) fire extinguisher is designed to combat flammable liquid fires by creating a smothering foam blanket over the burning liquid. It is highly effective for use on Class B fires, which involve flammable liquids such as gasoline, oil, and solvents. AFFF extinguishers are commonly used in airports, industrial facilities, and fuel storage areas to provide quick and efficient fire suppression.',2280,0,'2025-03-07 11:11:22','2025-03-07 11:11:22'),(5,1,'AH-0715 Smoke Detector','../images/products/smoke-detect_AH-0715.jpeg',2,'The AH-0715 smoke detector is a combination smoke and heat detector designed for reliable fire detection. It features a twin-color LED display for easy status identification and is made of fire-proof plastic for durability. This detector is suitable for various applications, including residential and commercial buildings, and is available in 2-wire, 3-wire, and 4-wire configurations.',1299,0,'2025-03-07 11:13:26','2025-03-07 11:13:26'),(6,1,'AH-9920 Smoke Detector','../images/products/smoke-detect_AH-9920.jpeg',2,'The AH-9920 smoke detector is a mechanical fixed-temperature heat detector designed to operate on the temperature differential sensing principle. It features a UL-approved sensor and is made of high-quality, fire-proof plastic, ensuring durability and reliability even in challenging environments. This detector is suitable for locations with high temperature differentials, such as kitchens, restaurants, and boiler houses.',1399,0,'2025-03-07 11:13:54','2025-03-07 11:13:54'),(7,1,'AQ05 Smoke Detector','../images/products/smoke-detect_QA05.jpeg',2,'The QA05 smoke detector is an addressable combination smoke and heat detector designed for reliable fire detection. It features address coding by dip switch, a latching function for clear alarm identification, and a magnetic test feature for easy maintenance. Made of high endurance, fire-proof plastic, it also includes dual LEDs for 360-degree visibility and has passed strict EMC tests to minimize false alarms.',1499,0,'2025-03-07 11:17:06','2025-03-07 11:17:06'),(8,1,'testProduct','../images/products/low-poly-fire-hydrant-03_67d6b75b28f3e.jpg',1,'this is a test description for test product',1000000,1,'2025-03-16 12:34:51','2025-03-16 12:34:51');
/*!40000 ALTER TABLE `products_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_tbl`
--

DROP TABLE IF EXISTS `roles_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles_tbl` (
  `roleID` int(11) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(50) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`roleID`),
  UNIQUE KEY `roleName` (`roleName`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_tbl`
--

LOCK TABLES `roles_tbl` WRITE;
/*!40000 ALTER TABLE `roles_tbl` DISABLE KEYS */;
INSERT INTO `roles_tbl` VALUES (1,'Customer','2025-03-07 10:37:49','2025-03-07 10:37:49'),(2,'Admin','2025-03-07 10:38:02','2025-03-07 10:38:02');
/*!40000 ALTER TABLE `roles_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_tbl`
--

DROP TABLE IF EXISTS `users_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_tbl` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userFname` varchar(50) NOT NULL,
  `userLname` varchar(50) NOT NULL,
  `userAdd` varchar(100) NOT NULL,
  `userPhone` varchar(11) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userPass` varchar(50) NOT NULL,
  `roleID` int(11) NOT NULL,
  `otp` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userEmail` (`userEmail`),
  KEY `userRoleFK` (`roleID`) USING BTREE,
  CONSTRAINT `userRoleFK` FOREIGN KEY (`roleID`) REFERENCES `roles_tbl` (`roleID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_tbl`
--

LOCK TABLES `users_tbl` WRITE;
/*!40000 ALTER TABLE `users_tbl` DISABLE KEYS */;
INSERT INTO `users_tbl` VALUES (1,'Mert','Isip','Manila','09562898062','mertalexis.isip.cics@ust.edu.ph','86f686503ff41169c870faf4be188517',2,0,'Verified','2025-03-11 13:05:02','2025-03-11 13:05:02'),(2,'Mert','Isip','Manila','09562898062','mertiscool031@gmail.com','0f05ad7e167ac3a8484979dd35913e90',1,0,'Verified','2025-03-11 13:05:21','2025-03-16 10:43:34'),(3,'Ken','Gopez','Valenzuela','12345678910','kristoffer.gopez.cics@ust.edu.ph','86f686503ff41169c870faf4be188517',2,0,'Verified','2025-03-16 10:39:02','2025-03-16 10:39:02'),(4,'Cyril','Labao','Bacoor','12345678910','cyrillabao@gmail.com','86f686503ff41169c870faf4be188517',2,0,'Verified','2025-03-16 10:39:43','2025-03-16 10:39:43');
/*!40000 ALTER TABLE `users_tbl` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-16 19:40:53
