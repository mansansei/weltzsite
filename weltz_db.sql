-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: weltz_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
  `userID` int(11) DEFAULT NULL,
  `actionType` varchar(50) NOT NULL DEFAULT '',
  `tableName` varchar(50) NOT NULL DEFAULT '',
  `recordID` int(11) DEFAULT NULL,
  `oldValues` text DEFAULT NULL,
  `newValues` text DEFAULT NULL,
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`auditID`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-16 10:38:10'),(2,1,'CREATE','users_tbl',3,NULL,'{\"userFname\":\"Ken\",\"userLname\":\"Gopez\",\"userAdd\":\"Valenzuela\",\"userPhone\":\"12345678910\",\"userEmail\":\"kristoffer.gopez.cics@ust.edu.ph\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-16 10:39:02'),(3,1,'CREATE','users_tbl',4,NULL,'{\"userFname\":\"Cyril\",\"userLname\":\"Labao\",\"userAdd\":\"Bacoor\",\"userPhone\":\"12345678910\",\"userEmail\":\"cyrillabao@gmail.com\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-16 10:39:43'),(4,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-04-07 15:17:14'),(5,5,'CREATE CUSTOMER','users_tbl',5,NULL,'{\"firstname\":\"Mert\",\"lastname\":\"Isip\",\"address\":\"2960 Rizal Ave. Sta. Cruz\",\"phone\":\"09562898062\",\"email\":\"mertiscool031@gmail.com\",\"role\":1,\"otp\":325017,\"status\":\"Unverified\",\"currentDateTime\":\"2025-04-07 15:17:27\"}','2025-04-07 15:17:27'),(6,5,'CREATE CART','carts_tbl',4,NULL,'{\"cartID\":4,\"userID\":5}','2025-04-07 15:17:27'),(7,5,'LOGIN','users_tbl',5,NULL,'{\"status\":\"success\"}','2025-04-07 15:19:01'),(8,5,'ADD TO CART','cart_items_tbl',1,NULL,'{\"cartID\":4,\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-04-07 15:19:08'),(9,5,'ADD TO CART','cart_items_tbl',2,NULL,'{\"cartID\":4,\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-04-07 15:19:12'),(10,5,'ADD TO CART','cart_items_tbl',3,NULL,'{\"cartID\":4,\"productID\":\"4\",\"cartItemQuantity\":\"4\",\"cartItemTotal\":\"9120\"}','2025-04-07 15:19:16'),(11,5,'UPDATE CART ITEM','cart_items_tbl',3,'{\"cartItemQuantity\":4,\"cartItemTotal\":\"9120.00\"}','{\"cartItemQuantity\":9,\"cartItemTotal\":20520}','2025-04-07 15:19:20'),(12,5,'ADD TO CART','cart_items_tbl',4,NULL,'{\"cartID\":4,\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-04-07 15:19:24'),(13,5,'ADD TO CART','cart_items_tbl',5,NULL,'{\"cartID\":4,\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-04-07 15:19:29'),(14,5,'ADD TO CART','cart_items_tbl',6,NULL,'{\"cartID\":4,\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495\"}','2025-04-07 15:19:33'),(15,5,'PLACE ORDER','orders_tbl',1,NULL,'{\"referenceNum\":\"CTXWh78Zjft\",\"totalAmount\":\"48760.00\",\"mopID\":\"1\"}','2025-04-07 15:19:43'),(16,5,'PLACE ORDER ITEMS','order_items_tbl',1,NULL,'{\"productID\":\"1\",\"quantity\":\"5\",\"total\":10745}','2025-04-07 15:19:43'),(17,5,'UPDATE PRODUCT STOCK','products_tbl',1,'{\"productID\":\"1\",\"old stock\":100}','{\"productID\":\"1\",\"new stock\":95}','2025-04-07 15:19:43'),(18,5,'PLACE ORDER ITEMS','order_items_tbl',1,NULL,'{\"productID\":\"2\",\"quantity\":\"5\",\"total\":17495}','2025-04-07 15:19:43'),(19,5,'UPDATE PRODUCT STOCK','products_tbl',2,'{\"productID\":\"2\",\"old stock\":100}','{\"productID\":\"2\",\"new stock\":95}','2025-04-07 15:19:43'),(20,5,'PLACE ORDER ITEMS','order_items_tbl',1,NULL,'{\"productID\":\"4\",\"quantity\":\"9\",\"total\":20520}','2025-04-07 15:19:43'),(21,5,'UPDATE PRODUCT STOCK','products_tbl',4,'{\"productID\":\"4\",\"old stock\":100}','{\"productID\":\"4\",\"new stock\":91}','2025-04-07 15:19:43'),(22,5,'DELETE CART ITEM','cart_items_tbl',4,NULL,'Removed items that were ordered','2025-04-07 15:19:43'),(23,5,'CREATE NOTIFICATION','notifs_tbl',1,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #CTXWh78Zjft has been successfully placed.\",\"statusID\":9}','2025-04-07 15:19:43'),(24,5,'PLACE ORDER','orders_tbl',2,NULL,'{\"referenceNum\":\"SqxNeCd9D88\",\"totalAmount\":\"6495.00\",\"mopID\":\"1\"}','2025-04-07 15:19:54'),(25,5,'PLACE ORDER ITEMS','order_items_tbl',2,NULL,'{\"productID\":\"5\",\"quantity\":\"5\",\"total\":6495}','2025-04-07 15:19:54'),(26,5,'UPDATE PRODUCT STOCK','products_tbl',5,'{\"productID\":\"5\",\"old stock\":100}','{\"productID\":\"5\",\"new stock\":95}','2025-04-07 15:19:54'),(27,5,'DELETE CART ITEM','cart_items_tbl',4,NULL,'Removed items that were ordered','2025-04-07 15:19:54'),(28,5,'CREATE NOTIFICATION','notifs_tbl',2,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #SqxNeCd9D88 has been successfully placed.\",\"statusID\":9}','2025-04-07 15:19:54'),(29,5,'PLACE ORDER','orders_tbl',3,NULL,'{\"referenceNum\":\"KgV3OcMCKvm\",\"totalAmount\":\"6995.00\",\"mopID\":\"1\"}','2025-04-07 15:20:07'),(30,5,'PLACE ORDER ITEMS','order_items_tbl',3,NULL,'{\"productID\":\"6\",\"quantity\":\"5\",\"total\":6995}','2025-04-07 15:20:07'),(31,5,'UPDATE PRODUCT STOCK','products_tbl',6,'{\"productID\":\"6\",\"old stock\":100}','{\"productID\":\"6\",\"new stock\":95}','2025-04-07 15:20:07'),(32,5,'DELETE CART ITEM','cart_items_tbl',4,NULL,'Removed items that were ordered','2025-04-07 15:20:07'),(33,5,'CREATE NOTIFICATION','notifs_tbl',3,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #KgV3OcMCKvm has been successfully placed.\",\"statusID\":9}','2025-04-07 15:20:07'),(34,5,'PLACE ORDER','orders_tbl',4,NULL,'{\"referenceNum\":\"wnwGPngRSxu\",\"totalAmount\":\"7495.00\",\"mopID\":\"1\"}','2025-04-07 15:20:17'),(35,5,'PLACE ORDER ITEMS','order_items_tbl',4,NULL,'{\"productID\":\"7\",\"quantity\":\"5\",\"total\":7495}','2025-04-07 15:20:17'),(36,5,'UPDATE PRODUCT STOCK','products_tbl',7,'{\"productID\":\"7\",\"old stock\":100}','{\"productID\":\"7\",\"new stock\":95}','2025-04-07 15:20:17'),(37,5,'DELETE CART ITEM','cart_items_tbl',4,NULL,'Removed items that were ordered','2025-04-07 15:20:17'),(38,5,'CREATE NOTIFICATION','notifs_tbl',4,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #wnwGPngRSxu has been successfully placed.\",\"statusID\":9}','2025-04-07 15:20:17'),(39,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-04-07 15:20:39'),(40,1,'UPDATE ORDER STATUS','orders_tbl',1,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-07 15:20:56'),(41,5,'CREATE NOTIFICATION','notifs_tbl',5,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #CTXWh78Zjft is now ready for pickup.\",\"statusID\":9}','2025-04-07 15:20:56'),(42,1,'UPDATE ORDER STATUS','orders_tbl',4,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-07 15:21:47'),(43,5,'CREATE NOTIFICATION','notifs_tbl',6,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #wnwGPngRSxu is now ready for pickup.\",\"statusID\":9}','2025-04-07 15:21:47'),(44,1,'UPDATE ORDER STATUS','orders_tbl',3,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-07 15:21:56'),(45,5,'CREATE NOTIFICATION','notifs_tbl',7,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #KgV3OcMCKvm is now ready for pickup.\",\"statusID\":9}','2025-04-07 15:21:56'),(46,1,'UPDATE ORDER STATUS','orders_tbl',1,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"4\"}','2025-04-07 15:22:48'),(47,5,'CREATE NOTIFICATION','notifs_tbl',8,NULL,'{\"notifName\":\"Order Picked Up\",\"notifMessage\":\"Your order #CTXWh78Zjft has been successfully picked up.\",\"statusID\":9}','2025-04-07 15:22:48'),(48,5,'RESTORE STOCK','products_tbl',6,'{\"inStock\":95}','{\"inStock\":100}','2025-04-07 15:23:18'),(49,5,'UPDATE ORDER STATUS','orders_tbl',3,'{\"statusID\":\"Previous Status\"}','{\"statusID\":3}','2025-04-07 15:23:18'),(50,5,'ADD TO CART','cart_items_tbl',7,NULL,'{\"cartID\":4,\"productID\":\"4\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"2280\"}','2025-04-07 15:23:40'),(51,5,'PLACE ORDER','orders_tbl',5,NULL,'{\"referenceNum\":\"KM9OaNhYJS1\",\"totalAmount\":\"2280.00\",\"mopID\":\"1\"}','2025-04-07 15:23:45'),(52,5,'PLACE ORDER ITEMS','order_items_tbl',5,NULL,'{\"productID\":\"4\",\"quantity\":\"1\",\"total\":2280}','2025-04-07 15:23:45'),(53,5,'UPDATE PRODUCT STOCK','products_tbl',4,'{\"productID\":\"4\",\"old stock\":91}','{\"productID\":\"4\",\"new stock\":90}','2025-04-07 15:23:45'),(54,5,'DELETE CART ITEM','cart_items_tbl',4,NULL,'Removed items that were ordered','2025-04-07 15:23:45'),(55,5,'CREATE NOTIFICATION','notifs_tbl',9,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #KM9OaNhYJS1 has been successfully placed.\",\"statusID\":9}','2025-04-07 15:23:45'),(56,1,'UPDATE ORDER STATUS','orders_tbl',5,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-07 15:24:41'),(57,5,'CREATE NOTIFICATION','notifs_tbl',10,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #KM9OaNhYJS1 is now ready for pickup.\",\"statusID\":9}','2025-04-07 15:24:41'),(58,1,'UPDATE ORDER STATUS','orders_tbl',5,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"4\"}','2025-04-07 15:25:06'),(59,5,'CREATE NOTIFICATION','notifs_tbl',11,NULL,'{\"notifName\":\"Order Picked Up\",\"notifMessage\":\"Your order #KM9OaNhYJS1 has been successfully picked up.\",\"statusID\":9}','2025-04-07 15:25:06'),(60,5,'LOGIN','users_tbl',5,NULL,'{\"status\":\"success\"}','2025-04-07 15:27:27'),(61,5,'CREATE REVIEW','reviews_tbl',1,NULL,'{\"productID\":10,\"userID\":5,\"reviewDesc\":\"very poggers\",\"reviewRating\":5}','2025-04-07 17:34:14');
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items_tbl`
--

DROP TABLE IF EXISTS `cart_items_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items_tbl` (
  `cartItemID` int(11) NOT NULL AUTO_INCREMENT,
  `cartID` int(11) DEFAULT NULL,
  `productID` int(11) DEFAULT NULL,
  `cartItemQuantity` int(11) NOT NULL,
  `cartItemTotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `statusID` int(11) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cartItemID`) USING BTREE,
  KEY `cartItemCartFK` (`cartID`),
  KEY `cartItemProductFK` (`productID`),
  KEY `cartItemStatusFK` (`statusID`),
  CONSTRAINT `cartItemCartFK` FOREIGN KEY (`cartID`) REFERENCES `carts_tbl` (`cartID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `cartItemProductFK` FOREIGN KEY (`productID`) REFERENCES `products_tbl` (`productID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `cartItemStatusFK` FOREIGN KEY (`statusID`) REFERENCES `statuses_tbl` (`statusID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
  `userID` int(11) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cartID`),
  KEY `cartUserFK` (`userID`),
  CONSTRAINT `cartUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts_tbl`
--

LOCK TABLES `carts_tbl` WRITE;
/*!40000 ALTER TABLE `carts_tbl` DISABLE KEYS */;
INSERT INTO `carts_tbl` VALUES (1,2,'2025-03-16 14:25:52','2025-03-16 14:25:52'),(2,NULL,'2025-03-23 20:53:05','2025-03-23 20:53:05'),(3,NULL,'2025-04-07 21:15:57','2025-04-07 21:15:57'),(4,5,'2025-04-07 21:17:27','2025-04-07 21:17:27');
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
INSERT INTO `modes_of_payment_tbl` VALUES (1,'Payment on Pickup','2025-03-15 16:29:15','2025-03-15 16:29:15');
/*!40000 ALTER TABLE `modes_of_payment_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifs_tbl`
--

DROP TABLE IF EXISTS `notifs_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifs_tbl` (
  `notifID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `notifName` varchar(50) NOT NULL,
  `notifMessage` text NOT NULL,
  `statusID` int(11) DEFAULT 9,
  `notifType` varchar(50) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`notifID`),
  KEY `notifStatusFK` (`statusID`),
  KEY `notifUserFK` (`userID`),
  CONSTRAINT `notifStatusFK` FOREIGN KEY (`statusID`) REFERENCES `statuses_tbl` (`statusID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `notifUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifs_tbl`
--

LOCK TABLES `notifs_tbl` WRITE;
/*!40000 ALTER TABLE `notifs_tbl` DISABLE KEYS */;
INSERT INTO `notifs_tbl` VALUES (1,5,'Order Placed','Your order #CTXWh78Zjft has been successfully placed.',9,'Order','2025-04-07 21:19:43','2025-04-07 21:19:43'),(2,5,'Order Placed','Your order #SqxNeCd9D88 has been successfully placed.',9,'Order','2025-04-07 21:19:54','2025-04-07 21:19:54'),(3,5,'Order Placed','Your order #KgV3OcMCKvm has been successfully placed.',9,'Order','2025-04-07 21:20:07','2025-04-07 21:20:07'),(4,5,'Order Placed','Your order #wnwGPngRSxu has been successfully placed.',9,'Order','2025-04-07 21:20:17','2025-04-07 21:20:17'),(5,5,'Order Ready for Pickup','Your order #CTXWh78Zjft is now ready for pickup.',9,'Order','2025-04-07 21:20:56','2025-04-07 21:20:56'),(6,5,'Order Ready for Pickup','Your order #wnwGPngRSxu is now ready for pickup.',9,'Order','2025-04-07 21:21:47','2025-04-07 21:21:47'),(7,5,'Order Ready for Pickup','Your order #KgV3OcMCKvm is now ready for pickup.',9,'Order','2025-04-07 21:21:56','2025-04-07 21:21:56'),(8,5,'Order Picked Up','Your order #CTXWh78Zjft has been successfully picked up.',9,'Order','2025-04-07 21:22:48','2025-04-07 21:22:48'),(9,5,'Order Placed','Your order #KM9OaNhYJS1 has been successfully placed.',9,'Order','2025-04-07 21:23:45','2025-04-07 21:23:45'),(10,5,'Order Ready for Pickup','Your order #KM9OaNhYJS1 is now ready for pickup.',9,'Order','2025-04-07 21:24:41','2025-04-07 21:24:41'),(11,5,'Order Picked Up','Your order #KM9OaNhYJS1 has been successfully picked up.',9,'Order','2025-04-07 21:25:06','2025-04-07 21:25:06');
/*!40000 ALTER TABLE `notifs_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items_tbl`
--

DROP TABLE IF EXISTS `order_items_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items_tbl` (
  `orderItemID` int(11) NOT NULL AUTO_INCREMENT,
  `orderID` int(11) DEFAULT NULL,
  `productID` int(11) DEFAULT NULL,
  `orderItemQuantity` int(11) NOT NULL DEFAULT 0,
  `orderItemTotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `orderReceipt` text DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`orderItemID`),
  KEY `orderItemOrderFK` (`orderID`),
  KEY `orderItemProductFK` (`productID`),
  CONSTRAINT `orderItemOrderFK` FOREIGN KEY (`orderID`) REFERENCES `orders_tbl` (`orderID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `orderItemProductFK` FOREIGN KEY (`productID`) REFERENCES `products_tbl` (`productID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items_tbl`
--

LOCK TABLES `order_items_tbl` WRITE;
/*!40000 ALTER TABLE `order_items_tbl` DISABLE KEYS */;
INSERT INTO `order_items_tbl` VALUES (1,1,1,5,10745.00,NULL,'2025-04-07 21:19:43'),(2,1,2,5,17495.00,NULL,'2025-04-07 21:19:43'),(3,1,4,9,20520.00,NULL,'2025-04-07 21:19:43'),(4,2,5,5,6495.00,NULL,'2025-04-07 21:19:54'),(5,3,6,5,6995.00,NULL,'2025-04-07 21:20:07'),(6,4,7,5,7495.00,NULL,'2025-04-07 21:20:17'),(7,5,4,1,2280.00,NULL,'2025-04-07 21:23:45');
/*!40000 ALTER TABLE `order_items_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_tbl`
--

DROP TABLE IF EXISTS `orders_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_tbl` (
  `orderID` int(11) NOT NULL AUTO_INCREMENT,
  `referenceNum` varchar(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `totalAmount` decimal(10,2) DEFAULT NULL,
  `mopID` int(11) DEFAULT NULL,
  `statusID` int(11) DEFAULT NULL,
  `orderReceipt` text DEFAULT NULL,
  `toReceive` datetime DEFAULT NULL,
  `receivedAt` datetime DEFAULT NULL,
  `cancelledAt` datetime DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`orderID`) USING BTREE,
  KEY `orderMopFK` (`mopID`),
  KEY `orderStatusFK` (`statusID`),
  KEY `orderUserFK` (`userID`),
  CONSTRAINT `orderMopFK` FOREIGN KEY (`mopID`) REFERENCES `modes_of_payment_tbl` (`mopID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `orderStatusFK` FOREIGN KEY (`statusID`) REFERENCES `statuses_tbl` (`statusID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `orderUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_tbl`
--

LOCK TABLES `orders_tbl` WRITE;
/*!40000 ALTER TABLE `orders_tbl` DISABLE KEYS */;
INSERT INTO `orders_tbl` VALUES (1,'CTXWh78Zjft',5,48760.00,1,4,'images/receipts/CTXWh78Zjft_67f3d192b2f4b.png','2025-04-07 21:20:56','2025-04-07 21:22:48',NULL,'2025-04-07 21:19:43','2025-04-07 21:19:43'),(2,'SqxNeCd9D88',5,6495.00,1,1,NULL,NULL,NULL,NULL,'2025-04-07 21:19:54','2025-04-07 21:19:54'),(3,'KgV3OcMCKvm',5,6995.00,1,3,NULL,'2025-04-07 21:21:55',NULL,'2025-04-07 21:23:18','2025-04-07 21:20:07','2025-04-07 21:23:18'),(4,'wnwGPngRSxu',5,7495.00,1,2,NULL,'2025-04-07 21:21:47',NULL,NULL,'2025-04-07 21:20:17','2025-04-07 21:20:17'),(5,'KM9OaNhYJS1',5,2280.00,1,4,'images/receipts/KM9OaNhYJS1_67f3d227a884a.png','2025-04-07 21:24:41','2025-04-07 21:25:06',NULL,'2025-04-07 21:23:45','2025-04-07 21:23:45');
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
  `productPrice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `inStock` int(11) NOT NULL DEFAULT 0,
  `prodSold` int(11) NOT NULL DEFAULT 0,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`productID`),
  UNIQUE KEY `productName` (`productName`),
  KEY `productCategoryFK` (`categoryID`) USING BTREE,
  KEY `productUserFK` (`userID`),
  CONSTRAINT `productCategoryFK` FOREIGN KEY (`categoryID`) REFERENCES `categories_tbl` (`categoryID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `productUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_tbl`
--

LOCK TABLES `products_tbl` WRITE;
/*!40000 ALTER TABLE `products_tbl` DISABLE KEYS */;
INSERT INTO `products_tbl` VALUES (1,1,'Dry Chemical Fire Extinguisher','../images/products/fire-ex_dry-chem.jpg',1,'A dry chemical fire extinguisher is a versatile and widely used firefighting device designed to combat various types of fires. It contains a dry chemical powder, such as monoammonium phosphate, which quickly extinguishes flames by interrupting the chemical reaction of the fire. These extinguishers are effective against Class A (ordinary combustibles), Class B (flammable liquids), and Class C (electrical) fires, making them essential for homes, offices, and industrial settings.',2149.00,95,90,'2025-03-07 10:56:42','2025-04-07 15:07:11'),(2,1,'HCFC-123 Fire Extinguisher','../images/products/fire-ex_HCFC-123.jpg',1,'The HCFC-123 fire extinguisher utilizes a clean agent called hydrochlorofluorocarbon-123 (HCFC-123) to suppress fires. It is highly effective for use in areas with sensitive electronic equipment, as it leaves no residue and causes minimal damage. This extinguisher is suitable for Class A, B, and C fires, making it an ideal choice for data centers, laboratories, and telecommunications facilities.',3499.00,95,90,'2025-03-07 10:58:51','2025-04-07 15:07:15'),(4,1,'AFFF Fire Extinguisher','../images/products/fire-ex_AFFF.jpg',1,'An Aqueous Film Forming Foam (AFFF) fire extinguisher is designed to combat flammable liquid fires by creating a smothering foam blanket over the burning liquid. It is highly effective for use on Class B fires, which involve flammable liquids such as gasoline, oil, and solvents. AFFF extinguishers are commonly used in airports, industrial facilities, and fuel storage areas to provide quick and efficient fire suppression.',2280.00,90,95,'2025-03-07 11:11:22','2025-04-07 15:07:18'),(5,1,'AH-0715 Smoke Detector','../images/products/smoke-detect_AH-0715.jpeg',2,'The AH-0715 smoke detector is a combination smoke and heat detector designed for reliable fire detection. It features a twin-color LED display for easy status identification and is made of fire-proof plastic for durability. This detector is suitable for various applications, including residential and commercial buildings, and is available in 2-wire, 3-wire, and 4-wire configurations.',1299.00,95,75,'2025-03-07 11:13:26','2025-04-07 15:07:25'),(6,1,'AH-9920 Smoke Detector','../images/products/smoke-detect_AH-9920.jpeg',2,'The AH-9920 smoke detector is a mechanical fixed-temperature heat detector designed to operate on the temperature differential sensing principle. It features a UL-approved sensor and is made of high-quality, fire-proof plastic, ensuring durability and reliability even in challenging environments. This detector is suitable for locations with high temperature differentials, such as kitchens, restaurants, and boiler houses.',1399.00,100,75,'2025-03-07 11:13:54','2025-04-07 15:13:58'),(7,1,'AQ05 Smoke Detector','../images/products/smoke-detect_QA05.jpeg',2,'The QA05 smoke detector is an addressable combination smoke and heat detector designed for reliable fire detection. It features address coding by dip switch, a latching function for clear alarm identification, and a magnetic test feature for easy maintenance. Made of high endurance, fire-proof plastic, it also includes dual LEDs for 360-degree visibility and has passed strict EMC tests to minimize false alarms.',1499.00,95,75,'2025-03-07 11:17:06','2025-04-07 15:07:39'),(10,NULL,'testProduct','../images/products/low-poly-fire-hydrant-03_67e08e2d62eb2.jpg',1,'testDescription',1000.00,1,10,'2025-03-22 19:28:28','2025-03-23 23:41:49');
/*!40000 ALTER TABLE `products_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews_tbl`
--

DROP TABLE IF EXISTS `reviews_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews_tbl` (
  `reviewID` int(11) NOT NULL AUTO_INCREMENT,
  `productID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `reviewDesc` text NOT NULL,
  `reviewRating` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`reviewID`),
  KEY `reviewProductFK` (`productID`),
  KEY `reviewUserFK` (`userID`),
  CONSTRAINT `reviewProductFK` FOREIGN KEY (`productID`) REFERENCES `products_tbl` (`productID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `reviewUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews_tbl`
--

LOCK TABLES `reviews_tbl` WRITE;
/*!40000 ALTER TABLE `reviews_tbl` DISABLE KEYS */;
INSERT INTO `reviews_tbl` VALUES (1,10,5,'very poggers',5,'2025-04-07 23:34:14');
/*!40000 ALTER TABLE `reviews_tbl` ENABLE KEYS */;
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
-- Table structure for table `statuses_tbl`
--

DROP TABLE IF EXISTS `statuses_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `statuses_tbl` (
  `statusID` int(11) NOT NULL AUTO_INCREMENT,
  `statusName` varchar(50) NOT NULL,
  `statusType` varchar(50) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`statusID`),
  UNIQUE KEY `statusName` (`statusName`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses_tbl`
--

LOCK TABLES `statuses_tbl` WRITE;
/*!40000 ALTER TABLE `statuses_tbl` DISABLE KEYS */;
INSERT INTO `statuses_tbl` VALUES (1,'Processing','Orders','2025-03-13 16:40:50','2025-03-13 16:40:50'),(2,'To Pick Up','Orders','2025-03-13 16:40:58','2025-03-13 16:40:58'),(3,'Cancelled','Orders','2025-03-13 16:41:25','2025-03-13 16:41:25'),(4,'Picked Up','Orders','2025-03-20 15:03:22','2025-03-20 15:03:22'),(5,'Active','Cart Items','2025-03-20 15:03:29','2025-03-20 15:03:29'),(6,'Removed','Cart Items','2025-03-20 15:03:49','2025-03-20 15:03:49'),(7,'Ordered','Cart Items','2025-03-20 15:04:00','2025-03-20 15:04:00'),(8,'Read','Notifications','2025-03-20 15:04:15','2025-03-20 15:04:15'),(9,'Unread','Notifications','2025-03-20 15:04:26','2025-03-20 15:04:26');
/*!40000 ALTER TABLE `statuses_tbl` ENABLE KEYS */;
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
  `userPass` varchar(255) NOT NULL,
  `roleID` int(11) DEFAULT NULL,
  `otp` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `failedAttempts` int(11) NOT NULL DEFAULT 0,
  `lockedUntil` datetime DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userEmail` (`userEmail`),
  KEY `userRoleFK` (`roleID`) USING BTREE,
  CONSTRAINT `userRoleFK` FOREIGN KEY (`roleID`) REFERENCES `roles_tbl` (`roleID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_tbl`
--

LOCK TABLES `users_tbl` WRITE;
/*!40000 ALTER TABLE `users_tbl` DISABLE KEYS */;
INSERT INTO `users_tbl` VALUES (1,'Weltz','Admin','Cainta','09562898062','weltzphils@gmail.com','$2y$10$9kIflVamTp1lba06/HSYbO9qwiqK9RzVWpZkXibdcm10WZjdVyxjq',2,0,'Verified',0,NULL,'2025-03-11 13:05:02','2025-03-22 11:18:19'),(2,'Mert','Isip','Manila','09562898062','mertalexis.isip.cics@ust.edu.ph','$2y$10$9kIflVamTp1lba06/HSYbO9qwiqK9RzVWpZkXibdcm10WZjdVyxjq',2,0,'Verified',0,NULL,'2025-03-11 13:05:21','2025-03-17 13:17:14'),(3,'Ken','Gopez','Valenzuela','12345678910','kristoffer.gopez.cics@ust.edu.ph','$2y$10$9kIflVamTp1lba06/HSYbO9qwiqK9RzVWpZkXibdcm10WZjdVyxjq',2,0,'Verified',0,NULL,'2025-03-16 10:39:02','2025-03-16 10:39:02'),(4,'Cyril','Labao','Bacoor','12345678910','cyrillabao@gmail.com','$2y$10$9kIflVamTp1lba06/HSYbO9qwiqK9RzVWpZkXibdcm10WZjdVyxjq',2,0,'Verified',0,NULL,'2025-03-16 10:39:43','2025-03-16 10:39:43'),(5,'Mert','Isip','2960 Rizal Ave. Sta. Cruz','9562898062','mertiscool031@gmail.com','$2y$10$Z9Vc6jgQ2w2aPFALzF9YIOvfj5tD4nffzKD3RFxgCXc57lGM.X.vO',1,0,'Verified',0,NULL,'2025-04-07 15:17:27','2025-04-07 15:17:27');
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

-- Dump completed on 2025-04-08  9:09:26
