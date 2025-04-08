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
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-16 10:38:10'),(2,1,'CREATE','users_tbl',3,NULL,'{\"userFname\":\"Ken\",\"userLname\":\"Gopez\",\"userAdd\":\"Valenzuela\",\"userPhone\":\"12345678910\",\"userEmail\":\"kristoffer.gopez.cics@ust.edu.ph\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-16 10:39:02'),(3,1,'CREATE','users_tbl',4,NULL,'{\"userFname\":\"Cyril\",\"userLname\":\"Labao\",\"userAdd\":\"Bacoor\",\"userPhone\":\"12345678910\",\"userEmail\":\"cyrillabao@gmail.com\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-16 10:39:43'),(4,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-04-07 15:17:14'),(5,5,'CREATE CUSTOMER','users_tbl',5,NULL,'{\"firstname\":\"Mert\",\"lastname\":\"Isip\",\"address\":\"2960 Rizal Ave. Sta. Cruz\",\"phone\":\"09562898062\",\"email\":\"mertiscool031@gmail.com\",\"role\":1,\"otp\":325017,\"status\":\"Unverified\",\"currentDateTime\":\"2025-04-07 15:17:27\"}','2025-04-07 15:17:27'),(6,5,'CREATE CART','carts_tbl',4,NULL,'{\"cartID\":4,\"userID\":5}','2025-04-07 15:17:27'),(7,5,'LOGIN','users_tbl',5,NULL,'{\"status\":\"success\"}','2025-04-07 15:19:01'),(8,5,'ADD TO CART','cart_items_tbl',1,NULL,'{\"cartID\":4,\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-04-07 15:19:08'),(9,5,'ADD TO CART','cart_items_tbl',2,NULL,'{\"cartID\":4,\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-04-07 15:19:12'),(10,5,'ADD TO CART','cart_items_tbl',3,NULL,'{\"cartID\":4,\"productID\":\"4\",\"cartItemQuantity\":\"4\",\"cartItemTotal\":\"9120\"}','2025-04-07 15:19:16'),(11,5,'UPDATE CART ITEM','cart_items_tbl',3,'{\"cartItemQuantity\":4,\"cartItemTotal\":\"9120.00\"}','{\"cartItemQuantity\":9,\"cartItemTotal\":20520}','2025-04-07 15:19:20'),(12,5,'ADD TO CART','cart_items_tbl',4,NULL,'{\"cartID\":4,\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-04-07 15:19:24'),(13,5,'ADD TO CART','cart_items_tbl',5,NULL,'{\"cartID\":4,\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-04-07 15:19:29'),(14,5,'ADD TO CART','cart_items_tbl',6,NULL,'{\"cartID\":4,\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495\"}','2025-04-07 15:19:33'),(15,5,'PLACE ORDER','orders_tbl',1,NULL,'{\"referenceNum\":\"CTXWh78Zjft\",\"totalAmount\":\"48760.00\",\"mopID\":\"1\"}','2025-04-07 15:19:43'),(16,5,'PLACE ORDER ITEMS','order_items_tbl',1,NULL,'{\"productID\":\"1\",\"quantity\":\"5\",\"total\":10745}','2025-04-07 15:19:43'),(17,5,'UPDATE PRODUCT STOCK','products_tbl',1,'{\"productID\":\"1\",\"old stock\":100}','{\"productID\":\"1\",\"new stock\":95}','2025-04-07 15:19:43'),(18,5,'PLACE ORDER ITEMS','order_items_tbl',1,NULL,'{\"productID\":\"2\",\"quantity\":\"5\",\"total\":17495}','2025-04-07 15:19:43'),(19,5,'UPDATE PRODUCT STOCK','products_tbl',2,'{\"productID\":\"2\",\"old stock\":100}','{\"productID\":\"2\",\"new stock\":95}','2025-04-07 15:19:43'),(20,5,'PLACE ORDER ITEMS','order_items_tbl',1,NULL,'{\"productID\":\"4\",\"quantity\":\"9\",\"total\":20520}','2025-04-07 15:19:43'),(21,5,'UPDATE PRODUCT STOCK','products_tbl',4,'{\"productID\":\"4\",\"old stock\":100}','{\"productID\":\"4\",\"new stock\":91}','2025-04-07 15:19:43'),(22,5,'DELETE CART ITEM','cart_items_tbl',4,NULL,'Removed items that were ordered','2025-04-07 15:19:43'),(23,5,'CREATE NOTIFICATION','notifs_tbl',1,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #CTXWh78Zjft has been successfully placed.\",\"statusID\":9}','2025-04-07 15:19:43'),(24,5,'PLACE ORDER','orders_tbl',2,NULL,'{\"referenceNum\":\"SqxNeCd9D88\",\"totalAmount\":\"6495.00\",\"mopID\":\"1\"}','2025-04-07 15:19:54'),(25,5,'PLACE ORDER ITEMS','order_items_tbl',2,NULL,'{\"productID\":\"5\",\"quantity\":\"5\",\"total\":6495}','2025-04-07 15:19:54'),(26,5,'UPDATE PRODUCT STOCK','products_tbl',5,'{\"productID\":\"5\",\"old stock\":100}','{\"productID\":\"5\",\"new stock\":95}','2025-04-07 15:19:54'),(27,5,'DELETE CART ITEM','cart_items_tbl',4,NULL,'Removed items that were ordered','2025-04-07 15:19:54'),(28,5,'CREATE NOTIFICATION','notifs_tbl',2,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #SqxNeCd9D88 has been successfully placed.\",\"statusID\":9}','2025-04-07 15:19:54'),(29,5,'PLACE ORDER','orders_tbl',3,NULL,'{\"referenceNum\":\"KgV3OcMCKvm\",\"totalAmount\":\"6995.00\",\"mopID\":\"1\"}','2025-04-07 15:20:07'),(30,5,'PLACE ORDER ITEMS','order_items_tbl',3,NULL,'{\"productID\":\"6\",\"quantity\":\"5\",\"total\":6995}','2025-04-07 15:20:07'),(31,5,'UPDATE PRODUCT STOCK','products_tbl',6,'{\"productID\":\"6\",\"old stock\":100}','{\"productID\":\"6\",\"new stock\":95}','2025-04-07 15:20:07'),(32,5,'DELETE CART ITEM','cart_items_tbl',4,NULL,'Removed items that were ordered','2025-04-07 15:20:07'),(33,5,'CREATE NOTIFICATION','notifs_tbl',3,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #KgV3OcMCKvm has been successfully placed.\",\"statusID\":9}','2025-04-07 15:20:07'),(34,5,'PLACE ORDER','orders_tbl',4,NULL,'{\"referenceNum\":\"wnwGPngRSxu\",\"totalAmount\":\"7495.00\",\"mopID\":\"1\"}','2025-04-07 15:20:17'),(35,5,'PLACE ORDER ITEMS','order_items_tbl',4,NULL,'{\"productID\":\"7\",\"quantity\":\"5\",\"total\":7495}','2025-04-07 15:20:17'),(36,5,'UPDATE PRODUCT STOCK','products_tbl',7,'{\"productID\":\"7\",\"old stock\":100}','{\"productID\":\"7\",\"new stock\":95}','2025-04-07 15:20:17'),(37,5,'DELETE CART ITEM','cart_items_tbl',4,NULL,'Removed items that were ordered','2025-04-07 15:20:17'),(38,5,'CREATE NOTIFICATION','notifs_tbl',4,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #wnwGPngRSxu has been successfully placed.\",\"statusID\":9}','2025-04-07 15:20:17'),(39,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-04-07 15:20:39'),(40,1,'UPDATE ORDER STATUS','orders_tbl',1,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-07 15:20:56'),(41,5,'CREATE NOTIFICATION','notifs_tbl',5,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #CTXWh78Zjft is now ready for pickup.\",\"statusID\":9}','2025-04-07 15:20:56'),(42,1,'UPDATE ORDER STATUS','orders_tbl',4,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-07 15:21:47'),(43,5,'CREATE NOTIFICATION','notifs_tbl',6,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #wnwGPngRSxu is now ready for pickup.\",\"statusID\":9}','2025-04-07 15:21:47'),(44,1,'UPDATE ORDER STATUS','orders_tbl',3,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-07 15:21:56'),(45,5,'CREATE NOTIFICATION','notifs_tbl',7,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #KgV3OcMCKvm is now ready for pickup.\",\"statusID\":9}','2025-04-07 15:21:56'),(46,1,'UPDATE ORDER STATUS','orders_tbl',1,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"4\"}','2025-04-07 15:22:48'),(47,5,'CREATE NOTIFICATION','notifs_tbl',8,NULL,'{\"notifName\":\"Order Picked Up\",\"notifMessage\":\"Your order #CTXWh78Zjft has been successfully picked up.\",\"statusID\":9}','2025-04-07 15:22:48'),(48,5,'RESTORE STOCK','products_tbl',6,'{\"inStock\":95}','{\"inStock\":100}','2025-04-07 15:23:18'),(49,5,'UPDATE ORDER STATUS','orders_tbl',3,'{\"statusID\":\"Previous Status\"}','{\"statusID\":3}','2025-04-07 15:23:18'),(50,5,'ADD TO CART','cart_items_tbl',7,NULL,'{\"cartID\":4,\"productID\":\"4\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"2280\"}','2025-04-07 15:23:40'),(51,5,'PLACE ORDER','orders_tbl',5,NULL,'{\"referenceNum\":\"KM9OaNhYJS1\",\"totalAmount\":\"2280.00\",\"mopID\":\"1\"}','2025-04-07 15:23:45'),(52,5,'PLACE ORDER ITEMS','order_items_tbl',5,NULL,'{\"productID\":\"4\",\"quantity\":\"1\",\"total\":2280}','2025-04-07 15:23:45'),(53,5,'UPDATE PRODUCT STOCK','products_tbl',4,'{\"productID\":\"4\",\"old stock\":91}','{\"productID\":\"4\",\"new stock\":90}','2025-04-07 15:23:45'),(54,5,'DELETE CART ITEM','cart_items_tbl',4,NULL,'Removed items that were ordered','2025-04-07 15:23:45'),(55,5,'CREATE NOTIFICATION','notifs_tbl',9,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #KM9OaNhYJS1 has been successfully placed.\",\"statusID\":9}','2025-04-07 15:23:45'),(56,1,'UPDATE ORDER STATUS','orders_tbl',5,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-07 15:24:41'),(57,5,'CREATE NOTIFICATION','notifs_tbl',10,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #KM9OaNhYJS1 is now ready for pickup.\",\"statusID\":9}','2025-04-07 15:24:41'),(58,1,'UPDATE ORDER STATUS','orders_tbl',5,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"4\"}','2025-04-07 15:25:06'),(59,5,'CREATE NOTIFICATION','notifs_tbl',11,NULL,'{\"notifName\":\"Order Picked Up\",\"notifMessage\":\"Your order #KM9OaNhYJS1 has been successfully picked up.\",\"statusID\":9}','2025-04-07 15:25:06'),(60,5,'LOGIN','users_tbl',5,NULL,'{\"status\":\"success\"}','2025-04-07 15:27:27'),(61,5,'CREATE REVIEW','reviews_tbl',1,NULL,'{\"productID\":10,\"userID\":5,\"reviewDesc\":\"very poggers\",\"reviewRating\":5}','2025-04-07 17:34:14'),(62,5,'LOGIN','users_tbl',5,NULL,'{\"status\":\"success\"}','2025-04-08 04:47:03'),(63,5,'LOGOUT','users_tbl',5,NULL,'{\"status\":\"logged out\"}','2025-04-08 04:49:55'),(64,5,'LOGIN','users_tbl',5,NULL,'{\"status\":\"success\"}','2025-04-08 04:51:55'),(65,5,'LOGOUT','users_tbl',5,NULL,'{\"status\":\"logged out\"}','2025-04-08 05:06:17'),(66,6,'CREATE CUSTOMER','users_tbl',6,NULL,'{\"firstname\":\"Mert\",\"lastname\":\"Isip\",\"address\":\"2960 Rizal Ave. Sta. Cruz\",\"phone\":\"09562898062\",\"email\":\"mertisepic031@gmail.com\",\"role\":1,\"otp\":571380,\"status\":\"Unverified\",\"currentDateTime\":\"2025-04-08 05:06:50\"}','2025-04-08 05:06:50'),(67,6,'CREATE CART','carts_tbl',5,NULL,'{\"cartID\":5,\"userID\":6}','2025-04-08 05:06:50'),(68,6,'CREATE CUSTOMER','users_tbl',6,NULL,'{\"firstname\":\"Mert\",\"lastname\":\"Isip\",\"address\":\"2960 Rizal Ave. Sta. Cruz\",\"phone\":\"09562898062\",\"email\":\"mertisepic031@gmail.com\",\"role\":1,\"otp\":972464,\"status\":\"Unverified\",\"currentDateTime\":\"2025-04-08 05:10:52\"}','2025-04-08 05:10:52'),(69,6,'CREATE CART','carts_tbl',6,NULL,'{\"cartID\":6,\"userID\":6}','2025-04-08 05:10:52'),(70,6,'CREATE CUSTOMER','users_tbl',6,NULL,'{\"firstname\":\"Mert\",\"lastname\":\"Isip\",\"address\":\"2960 Rizal Ave. Sta. Cruz\",\"phone\":\"09562898062\",\"email\":\"mertisepic031@gmail.com\",\"role\":1,\"otp\":171204,\"status\":\"Unverified\",\"currentDateTime\":\"2025-04-08 05:15:57\"}','2025-04-08 05:15:57'),(71,6,'CREATE CART','carts_tbl',7,NULL,'{\"cartID\":7,\"userID\":6}','2025-04-08 05:15:57'),(72,6,'LOGIN','users_tbl',6,NULL,'{\"status\":\"success\"}','2025-04-08 05:26:59'),(73,6,'ADD TO CART','cart_items_tbl',8,NULL,'{\"cartID\":7,\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-04-08 05:27:17'),(74,6,'ADD TO CART','cart_items_tbl',9,NULL,'{\"cartID\":7,\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-04-08 05:27:30'),(75,6,'ADD TO CART','cart_items_tbl',10,NULL,'{\"cartID\":7,\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495\"}','2025-04-08 05:27:47'),(76,6,'PLACE ORDER','orders_tbl',6,NULL,'{\"referenceNum\":\"w82EtoQ0brg\",\"totalAmount\":\"20985.00\",\"mopID\":\"1\"}','2025-04-08 05:27:59'),(77,6,'PLACE ORDER ITEMS','order_items_tbl',6,NULL,'{\"productID\":\"5\",\"quantity\":\"5\",\"total\":6495}','2025-04-08 05:27:59'),(78,6,'UPDATE PRODUCT STOCK','products_tbl',5,'{\"productID\":\"5\",\"old stock\":95}','{\"productID\":\"5\",\"new stock\":90}','2025-04-08 05:28:00'),(79,6,'PLACE ORDER ITEMS','order_items_tbl',6,NULL,'{\"productID\":\"6\",\"quantity\":\"5\",\"total\":6995}','2025-04-08 05:28:00'),(80,6,'UPDATE PRODUCT STOCK','products_tbl',6,'{\"productID\":\"6\",\"old stock\":100}','{\"productID\":\"6\",\"new stock\":95}','2025-04-08 05:28:00'),(81,6,'PLACE ORDER ITEMS','order_items_tbl',6,NULL,'{\"productID\":\"7\",\"quantity\":\"5\",\"total\":7495}','2025-04-08 05:28:00'),(82,6,'UPDATE PRODUCT STOCK','products_tbl',7,'{\"productID\":\"7\",\"old stock\":95}','{\"productID\":\"7\",\"new stock\":90}','2025-04-08 05:28:00'),(83,6,'DELETE CART ITEM','cart_items_tbl',7,NULL,'Removed items that were ordered','2025-04-08 05:28:00'),(84,6,'CREATE NOTIFICATION','notifs_tbl',12,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #w82EtoQ0brg has been successfully placed.\",\"statusID\":9}','2025-04-08 05:28:00'),(85,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-04-08 05:28:53'),(86,1,'UPDATE ORDER STATUS','orders_tbl',6,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-08 05:29:14'),(87,6,'CREATE NOTIFICATION','notifs_tbl',13,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #w82EtoQ0brg is now ready for pickup.\",\"statusID\":9}','2025-04-08 05:29:14'),(88,6,'ADD TO CART','cart_items_tbl',11,NULL,'{\"cartID\":7,\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-04-08 05:34:08'),(89,6,'ADD TO CART','cart_items_tbl',12,NULL,'{\"cartID\":7,\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-04-08 05:34:19'),(90,6,'PLACE ORDER','orders_tbl',7,NULL,'{\"referenceNum\":\"rjDlFxWTzy1\",\"totalAmount\":\"28240.00\",\"mopID\":\"1\"}','2025-04-08 05:34:33'),(91,6,'PLACE ORDER ITEMS','order_items_tbl',7,NULL,'{\"productID\":\"2\",\"quantity\":\"5\",\"total\":17495}','2025-04-08 05:34:33'),(92,6,'UPDATE PRODUCT STOCK','products_tbl',2,'{\"productID\":\"2\",\"old stock\":95}','{\"productID\":\"2\",\"new stock\":90}','2025-04-08 05:34:33'),(93,6,'PLACE ORDER ITEMS','order_items_tbl',7,NULL,'{\"productID\":\"1\",\"quantity\":\"5\",\"total\":10745}','2025-04-08 05:34:33'),(94,6,'UPDATE PRODUCT STOCK','products_tbl',1,'{\"productID\":\"1\",\"old stock\":95}','{\"productID\":\"1\",\"new stock\":90}','2025-04-08 05:34:33'),(95,6,'DELETE CART ITEM','cart_items_tbl',7,NULL,'Removed items that were ordered','2025-04-08 05:34:33'),(96,6,'CREATE NOTIFICATION','notifs_tbl',14,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #rjDlFxWTzy1 has been successfully placed.\",\"statusID\":9}','2025-04-08 05:34:33'),(97,1,'UPDATE ORDER STATUS','orders_tbl',7,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-08 05:41:11'),(98,6,'CREATE NOTIFICATION','notifs_tbl',15,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #rjDlFxWTzy1 is now ready for pickup.\",\"statusID\":9}','2025-04-08 05:41:11'),(99,6,'ADD TO CART','cart_items_tbl',13,NULL,'{\"cartID\":7,\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-04-08 05:47:39'),(100,6,'PLACE ORDER','orders_tbl',8,NULL,'{\"referenceNum\":\"bMaEvwLZMxw\",\"totalAmount\":\"10745.00\",\"mopID\":\"1\"}','2025-04-08 05:48:02'),(101,6,'PLACE ORDER ITEMS','order_items_tbl',8,NULL,'{\"productID\":\"1\",\"quantity\":\"5\",\"total\":10745}','2025-04-08 05:48:02'),(102,6,'UPDATE PRODUCT STOCK','products_tbl',1,'{\"productID\":\"1\",\"old stock\":90}','{\"productID\":\"1\",\"new stock\":85}','2025-04-08 05:48:02'),(103,6,'DELETE CART ITEM','cart_items_tbl',7,NULL,'Removed items that were ordered','2025-04-08 05:48:02'),(104,6,'CREATE NOTIFICATION','notifs_tbl',16,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #bMaEvwLZMxw has been successfully placed.\",\"statusID\":9}','2025-04-08 05:48:02'),(105,6,'ADD TO CART','cart_items_tbl',14,NULL,'{\"cartID\":7,\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-04-08 08:03:47'),(106,6,'PLACE ORDER','orders_tbl',9,NULL,'{\"referenceNum\":\"1iebR3ZWtby\",\"totalAmount\":\"6995.00\",\"mopID\":\"1\"}','2025-04-08 08:04:15'),(107,6,'PLACE ORDER ITEMS','order_items_tbl',9,NULL,'{\"productID\":\"6\",\"quantity\":\"5\",\"total\":6995}','2025-04-08 08:04:15'),(108,6,'UPDATE PRODUCT STOCK','products_tbl',6,'{\"productID\":\"6\",\"old stock\":95}','{\"productID\":\"6\",\"new stock\":90}','2025-04-08 08:04:15'),(109,6,'DELETE CART ITEM','cart_items_tbl',7,NULL,'Removed items that were ordered','2025-04-08 08:04:15'),(110,6,'CREATE NOTIFICATION','notifs_tbl',17,NULL,'{\"notifName\":\"Order Placed\",\"notifMessage\":\"Your order #1iebR3ZWtby has been successfully placed.\",\"statusID\":9}','2025-04-08 08:04:15'),(111,1,'UPDATE ORDER STATUS','orders_tbl',2,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-08 09:01:26'),(112,5,'CREATE NOTIFICATION','notifs_tbl',18,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #SqxNeCd9D88 is now ready for pickup.\",\"statusID\":9}','2025-04-08 09:01:26'),(113,1,'UPDATE ORDER STATUS','orders_tbl',8,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"2\"}','2025-04-08 09:01:42'),(114,6,'CREATE NOTIFICATION','notifs_tbl',19,NULL,'{\"notifName\":\"Order Ready for Pickup\",\"notifMessage\":\"Your order #bMaEvwLZMxw is now ready for pickup.\",\"statusID\":9}','2025-04-08 09:01:42'),(115,1,'UPDATE ORDER STATUS','orders_tbl',8,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"4\"}','2025-04-08 09:03:25'),(116,6,'CREATE NOTIFICATION','notifs_tbl',20,NULL,'{\"notifName\":\"Order Picked Up\",\"notifMessage\":\"Your order #bMaEvwLZMxw has been successfully picked up.\",\"statusID\":9}','2025-04-08 09:03:25'),(117,1,'UPDATE ORDER STATUS','orders_tbl',7,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"4\"}','2025-04-08 09:03:48'),(118,6,'CREATE NOTIFICATION','notifs_tbl',21,NULL,'{\"notifName\":\"Order Picked Up\",\"notifMessage\":\"Your order #rjDlFxWTzy1 has been successfully picked up.\",\"statusID\":9}','2025-04-08 09:03:48'),(119,1,'UPDATE ORDER STATUS','orders_tbl',6,'{\"statusID\":\"Previous Status\"}','{\"statusID\":\"4\"}','2025-04-08 09:04:10'),(120,6,'CREATE NOTIFICATION','notifs_tbl',22,NULL,'{\"notifName\":\"Order Picked Up\",\"notifMessage\":\"Your order #w82EtoQ0brg has been successfully picked up.\",\"statusID\":9}','2025-04-08 09:04:10'),(121,6,'LOGOUT','users_tbl',6,NULL,'{\"status\":\"logged out\"}','2025-04-08 12:23:25'),(122,6,'LOGIN','users_tbl',6,NULL,'{\"status\":\"success\"}','2025-04-08 12:29:50'),(123,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-04-08 12:31:21'),(124,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-04-08 12:36:58'),(125,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-04-08 12:37:05'),(126,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-04-08 13:10:14'),(127,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-04-08 13:10:19'),(128,1,'CREATE PRODUCT','products_tbl',11,NULL,'{\"userID\":1,\"productName\":\"testProduct\",\"productIMG\":\"..\\/images\\/products\\/low-poly-fire-hydrant-03_67f513c01a6b4.jpg\",\"categoryID\":\"1\",\"productDesc\":\"test description\",\"productPrice\":\"1000000\",\"inStock\":\"1\"}','2025-04-08 14:17:04'),(129,1,'ARCHIVE PRODUCT','products_tbl',11,'{\"statusID\":5}','{\"statusID\":6,\"updatedAt\":\"2025-04-08 14:19:54\"}','2025-04-08 14:19:54'),(130,1,'RESTORE PRODUCT','products_tbl',11,'{\"statusID\":6}','{\"statusID\":5,\"updatedAt\":\"2025-04-08 14:51:53\"}','2025-04-08 14:51:53'),(131,1,'ARCHIVE PRODUCT','products_tbl',4,'{\"statusID\":5}','{\"statusID\":6,\"updatedAt\":\"2025-04-08 14:52:04\"}','2025-04-08 14:52:04'),(132,1,'RESTORE PRODUCT','products_tbl',4,'{\"statusID\":6}','{\"statusID\":5,\"updatedAt\":\"2025-04-08 14:55:50\"}','2025-04-08 14:55:50'),(133,1,'ARCHIVE PRODUCT','products_tbl',11,'{\"statusID\":5}','{\"statusID\":6,\"updatedAt\":\"2025-04-08 15:25:12\"}','2025-04-08 15:25:12'),(134,1,'UPDATE PRODUCT INFO','products_tbl',7,'{\"productName\":\"AQ05 Smoke Detector\"}','{\"productName\":\"QA05 Smoke Detector\"}','2025-04-08 17:48:20'),(135,1,'CREATE PRODUCT','products_tbl',12,NULL,'{\"userID\":1,\"productName\":\"testProduct1\",\"productIMG\":\"..\\/images\\/products\\/low-poly-fire-hydrant-03_67f5662bbe885.jpg\",\"categoryID\":\"1\",\"productDesc\":\"test description\",\"productPrice\":\"10000\",\"inStock\":\"1\",\"productSpecs\":\"Type: AFFF (Aqueous Film Forming Foam) Stored Pressure\\r\\nCapacity Options: 2L \\/ 6L \\/ 9L (commonly available)\\r\\nExtinguishing Agent: AFFF Concentrate (typically 6%) mixed with water\\r\\nPropellant: Dry Nitrogen or Compressed Air\\r\\nDischarge Range: ~4\\u20136 meters\\r\\nOperating Temperature Range: +5\\u00b0C to +60\\u00b0C\\r\\nWorking Pressure: 12\\u201315 bar\\r\\nCylinder Material: Mild Steel (with internal corrosion-resistant lining)\\r\\nValve Type: Squeeze grip control valve with safety pin and seal\\r\\nFinish: Red powder-coated body (RAL 3000)\\r\\nSuitable For: Class A fires (solids such as wood, paper, textiles), Class B fires (flammable liquids like petrol, diesel)\\r\\nNot Suitable For: Live electrical fires (unless tested as dielectric safe)\\r\\nCompliance: BS EN 3\\r\\nCertifications: CE Marked, Kitemark (optional), ISO 9001 Manufacturing Standard\"}','2025-04-08 20:08:43'),(136,1,'UPDATE PRODUCT INFO','products_tbl',12,'{\"productSpecs\":\"Type: AFFF (Aqueous Film Forming Foam) Stored Pressure\\r\\nCapacity Options: 2L \\/ 6L \\/ 9L (commonly available)\\r\\nExtinguishing Agent: AFFF Concentrate (typically 6%) mixed with water\\r\\nPropellant: Dry Nitrogen or Compressed Air\\r\\nDischarge Range: ~4\\u20136 meters\\r\\nOperating Temperature Range: +5\\u00b0C to +60\\u00b0C\\r\\nWorking Pressure: 12\\u201315 bar\\r\\nCylinder Material: Mild Steel (with internal corrosion-resistant lining)\\r\\nValve Type: Squeeze grip control valve with safety pin and seal\\r\\nFinish: Red powder-coated body (RAL 3000)\\r\\nSuitable For: Class A fires (solids such as wood, paper, textiles), Class B fires (flammable liquids like petrol, diesel)\\r\\nNot Suitable For: Live electrical fires (unless tested as dielectric safe)\\r\\nCompliance: BS EN 3\\r\\nCertifications: CE Marked, Kitemark (optional), ISO 9001 Manufacturing Standard\"}','{\"productSpecs\":\"Type: AFFF (Aqueous Film Forming Foam) Stored Pressure\\r\\nCapacity Options: 2L \\/ 6L \\/ 9L (commonly available)\\r\\nExtinguishing Agent: AFFF Concentrate (typically 6%) mixed with water\\r\\nPropellant: Dry Nitrogen or Compressed Air\\r\\nDischarge Range: ~4\\u20136 meters\\r\\nOperating Temperature Range: +5\\u00b0C to +60\\u00b0C\\r\\nWorking Pressure: 12\\u201315 bar\\r\\nCylinder Material: Mild Steel (with internal corrosion-resistant lining)\\r\\nValve Type: Squeeze grip control valve with safety pin and seal\\r\\nFinish: Red powder-coated body (RAL 3000)\\r\\nSuitable For: Class A fires (solids such as wood, paper, textiles), Class B fires (flammable liquids like petrol, diesel)\\r\\nNot Suitable For: Live electrical fires (unless tested as dielectric safe)\\r\\nCompliance: BS EN 3\"}','2025-04-08 20:37:24'),(137,1,'UPDATE PRODUCT INFO','products_tbl',4,'{\"productSpecs\":\"\"}','{\"productSpecs\":\"Type: AFFF (Aqueous Film Forming Foam) Stored Pressure\\r\\nFire Rating: Typically 8A:144B (varies by size)\\r\\nCapacity Options: 2L \\/ 6L \\/ 9L (commonly available)\\r\\nExtinguishing Agent: AFFF Concentrate (typically 6%) mixed with water\\r\\nPropellant: Dry Nitrogen or Compressed Air\\r\\nDischarge Time: 2L: ~12 seconds, 6L: ~20 seconds, 9L: ~30 seconds\\r\\nDischarge Range: ~4\\u20136 meters\\r\\nOperating Temperature Range: +5\\u00b0C to +60\\u00b0C\\r\\nWorking Pressure: 12\\u201315 bar\\r\\nCylinder Material: Mild Steel (with internal corrosion-resistant lining)\\r\\nValve Type: Squeeze grip control valve with safety pin and seal\\r\\nFinish: Red powder-coated body (RAL 3000)\\r\\nSuitable For: Class A fires (solids such as wood, paper, textiles), Class B fires (flammable liquids like petrol, diesel)\\r\\nNot Suitable For: Live electrical fires (unless tested as dielectric safe)\\r\\nCompliance: BS EN 3\\r\\nCertifications: CE Marked, Kitemark (optional), ISO 9001 Manufacturing Standard\"}','2025-04-08 20:38:03'),(138,1,'ARCHIVE PRODUCT','products_tbl',12,'{\"statusID\":5}','{\"statusID\":6,\"updatedAt\":\"2025-04-08 20:38:13\"}','2025-04-08 20:38:13'),(139,1,'UPDATE PRODUCT INFO','products_tbl',1,'{\"productSpecs\":\"\"}','{\"productSpecs\":\"Type: Dry Chemical Powder (ABC Type \\u2013 Monoammonium Phosphate)\\r\\nFire Rating: Typically 2A:10B:C \\/ 4A:60B:C \\/ 6A:80B:C (varies by size)\\r\\nCapacity Options: 1kg \\/ 2kg \\/ 4kg \\/ 6kg \\/ 9kg \\/ 12kg\\r\\nExtinguishing Agent: ABC Dry Chemical Powder\\r\\nPropellant: Dry Nitrogen\\r\\nDischarge Time: 2kg: ~8 seconds, 6kg: ~15 seconds, 9kg: ~20 seconds\\r\\nDischarge Range: ~2\\u20136 meters\\r\\nOperating Temperature Range: -20\\u00b0C to +60\\u00b0C\\r\\nWorking Pressure: ~15 bar at 20\\u00b0C\\r\\nCylinder Material: Mild Steel with corrosion-resistant coating\\r\\nValve Type: Squeeze grip control valve with safety pin and pressure gauge\\r\\nFinish: Red powder-coated body (RAL 3000)\\r\\nSuitable For: Class A fires (ordinary combustibles: wood, paper, cloth), Class B fires (flammable liquids: gasoline, oil, paint), Class C fires (electrical fires: appliances, wiring)\\r\\nNot Recommended For: Sensitive electronic equipment (powder leaves residue)\\r\\nCompliance: IS 15683 \\/ BS EN 3 \\/ NFPA 10\\r\\nCertifications: CE, ISO 9001, PESO, UL\\/FM (depending on manufacturer)\"}','2025-04-08 20:39:56'),(140,1,'UPDATE PRODUCT INFO','products_tbl',2,'{\"productSpecs\":\"\"}','{\"productSpecs\":\"Type: Clean Agent (Halocarbon-based) Fire Extinguisher\\r\\nExtinguishing Agent: HCFC-123 (Hydrochlorofluorocarbon-123)\\r\\nFire Rating: Typically 1A:5B \\/ 2A:10B (varies by size)\\r\\nCapacity Options: 1kg \\/ 2kg \\/ 4kg \\/ 6kg \\/ 9kg\\r\\nPropellant: Dry Nitrogen\\r\\nDischarge Time: 2kg: ~9 seconds, 6kg: ~20 seconds\\r\\nDischarge Range: ~2\\u20134 meters\\r\\nOperating Temperature Range: -20\\u00b0C to +55\\u00b0C\\r\\nWorking Pressure: ~12 bar at 20\\u00b0C\\r\\nCylinder Material: Mild Steel or Stainless Steel\\r\\nValve Type: Squeeze lever valve with pressure gauge\\r\\nFinish: Red or Green powder-coated body (depending on region)\\r\\nSuitable For: Class B fires (flammable liquids), Class C fires (flammable gases), Safe for use on electrical equipment\\r\\nCommon Usage: Data centers, telecom rooms, control rooms, medical facilities, etc., Leaves no residue and minimal damage to sensitive equipment\\r\\nCompliance: IS 15683 \\/ NFPA 10 (depending on country)\\r\\nCertifications: CE, ISO 9001, PESO\\/UL\\/FM (based on manufacturer)\"}','2025-04-08 20:45:19'),(141,1,'UPDATE PRODUCT INFO','products_tbl',5,'{\"productSpecs\":\"\"}','{\"productSpecs\":\"Type: Photoelectric Smoke Detector\\r\\nPower Supply: DC 9V (Battery operated)\\r\\nAlarm Sound Level: \\u2265 85 dB at 3 meters\\r\\nSensor Type: Photoelectric sensing chamber\\r\\nAlarm Indicator: Red LED (Flashes in standby, solid during alarm)\\r\\nTest Button: Yes (for manual testing)\\r\\nLow Battery Indicator: Yes (audible beep + LED flash)\\r\\nMounting Type: Ceiling or wall mount\\r\\nOperating Temperature: -10\\u00b0C to +50\\u00b0C\\r\\nHumidity Range: \\u2264 95% RH (non-condensing)\\r\\nDimensions: Approx. 100mm diameter \\u00d7 35mm height\\r\\nWeight: ~115g (with battery)\\r\\nCompliance: EN14604\\r\\nCertifications: CE, RoHS\"}','2025-04-08 20:46:19'),(142,1,'UPDATE PRODUCT INFO','products_tbl',6,'{\"productSpecs\":\"\"}','{\"productSpecs\":\"Type: Photoelectric Smoke Detector\\r\\nPower Supply: DC 9V (Battery operated)\\r\\nAlarm Sound Level: \\u2265 85 dB at 3 meters\\r\\nSensor Type: Photoelectric sensing chamber\\r\\nAlarm Indicator: Red LED (Flashes in standby, solid during alarm)\\r\\nTest Button: Yes (for manual testing)\\r\\nLow Battery Indicator: Yes (audible beep + LED flash)\\r\\nMounting Type: Ceiling or wall mount\\r\\nOperating Temperature: -10\\u00b0C to +50\\u00b0C\\r\\nHumidity Range: \\u2264 95% RH (non-condensing)\\r\\nDimensions: Approx. 100mm diameter \\u00d7 35mm height\\r\\nWeight: ~110g (with battery)\\r\\nCompliance: EN14604\\r\\nCertifications: CE, RoHS\"}','2025-04-08 20:47:29'),(143,1,'UPDATE PRODUCT INFO','products_tbl',7,'{\"productSpecs\":\"\"}','{\"productSpecs\":\"Type: Photoelectric Smoke Detector\\r\\nPower Supply: DC 9V (Battery operated)\\r\\nAlarm Sound Level: \\u2265 85 dB at 3 meters\\r\\nSensor Type: Photoelectric sensing chamber\\r\\nAlarm Indicator: Red LED (Flashes in standby, solid during alarm)\\r\\nTest Button: Yes (for manual testing)\\r\\nLow Battery Indicator: Yes (audible beep + LED flash)\\r\\nMounting Type: Ceiling or wall mount\\r\\nOperating Temperature: -10\\u00b0C to +50\\u00b0C\\r\\nHumidity Range: \\u2264 95% RH (non-condensing)\\r\\nDimensions: Approx. 100mm diameter \\u00d7 35mm height\\r\\nWeight: ~120g (with battery)\\r\\nCompliance: EN14604 \\/ UL 217 (depending on region)\\r\\nCertifications: CE, RoHS\"}','2025-04-08 20:48:11'),(144,5,'LOGIN','users_tbl',5,NULL,'{\"status\":\"success\"}','2025-04-08 21:02:47'),(145,1,'RESTORE PRODUCT','products_tbl',12,'{\"statusID\":6}','{\"statusID\":5,\"updatedAt\":\"2025-04-08 21:03:43\"}','2025-04-08 21:03:43'),(146,5,'CREATE REVIEW','reviews_tbl',2,NULL,'{\"productID\":12,\"userID\":5,\"reviewDesc\":\"very cool\",\"reviewRating\":5}','2025-04-08 21:04:14'),(147,1,'ARCHIVE PRODUCT','products_tbl',12,'{\"statusID\":5}','{\"statusID\":6,\"updatedAt\":\"2025-04-08 21:14:53\"}','2025-04-08 21:14:53'),(148,1,'RESTORE PRODUCT','products_tbl',11,'{\"statusID\":6}','{\"statusID\":5,\"updatedAt\":\"2025-04-08 21:15:08\"}','2025-04-08 21:15:08'),(149,5,'LOGOUT','users_tbl',5,NULL,'{\"status\":\"logged out\"}','2025-04-08 21:26:02'),(150,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-04-08 21:35:42');
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
  `userID` int(11) DEFAULT NULL,
  `blogIMG` text NOT NULL,
  `blogTitle` varchar(50) NOT NULL,
  `blogDesc` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`blogID`),
  UNIQUE KEY `blogTitle` (`blogTitle`),
  KEY `blogUserFK` (`userID`),
  CONSTRAINT `blogUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE SET NULL ON UPDATE NO ACTION
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
  CONSTRAINT `FK_cart_items_tbl_statuses_tbl` FOREIGN KEY (`statusID`) REFERENCES `statuses_tbl` (`statusID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `cartItemCartFK` FOREIGN KEY (`cartID`) REFERENCES `carts_tbl` (`cartID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `cartItemProductFK` FOREIGN KEY (`productID`) REFERENCES `products_tbl` (`productID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts_tbl`
--

LOCK TABLES `carts_tbl` WRITE;
/*!40000 ALTER TABLE `carts_tbl` DISABLE KEYS */;
INSERT INTO `carts_tbl` VALUES (1,2,'2025-03-16 14:25:52','2025-03-16 14:25:52'),(2,NULL,'2025-03-23 20:53:05','2025-03-23 20:53:05'),(3,NULL,'2025-04-07 21:15:57','2025-04-07 21:15:57'),(4,5,'2025-04-07 21:17:27','2025-04-07 21:17:27'),(5,NULL,'2025-04-08 11:06:50','2025-04-08 11:06:50'),(6,NULL,'2025-04-08 11:10:52','2025-04-08 11:10:52'),(7,6,'2025-04-08 11:15:57','2025-04-08 11:15:57');
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifs_tbl`
--

LOCK TABLES `notifs_tbl` WRITE;
/*!40000 ALTER TABLE `notifs_tbl` DISABLE KEYS */;
INSERT INTO `notifs_tbl` VALUES (1,5,'Order Placed','Your order #CTXWh78Zjft has been successfully placed.',9,'Order','2025-04-07 21:19:43','2025-04-07 21:19:43'),(2,5,'Order Placed','Your order #SqxNeCd9D88 has been successfully placed.',9,'Order','2025-04-07 21:19:54','2025-04-07 21:19:54'),(3,5,'Order Placed','Your order #KgV3OcMCKvm has been successfully placed.',9,'Order','2025-04-07 21:20:07','2025-04-07 21:20:07'),(4,5,'Order Placed','Your order #wnwGPngRSxu has been successfully placed.',9,'Order','2025-04-07 21:20:17','2025-04-07 21:20:17'),(5,5,'Order Ready for Pickup','Your order #CTXWh78Zjft is now ready for pickup.',9,'Order','2025-04-07 21:20:56','2025-04-07 21:20:56'),(6,5,'Order Ready for Pickup','Your order #wnwGPngRSxu is now ready for pickup.',9,'Order','2025-04-07 21:21:47','2025-04-07 21:21:47'),(7,5,'Order Ready for Pickup','Your order #KgV3OcMCKvm is now ready for pickup.',9,'Order','2025-04-07 21:21:56','2025-04-07 21:21:56'),(8,5,'Order Picked Up','Your order #CTXWh78Zjft has been successfully picked up.',9,'Order','2025-04-07 21:22:48','2025-04-07 21:22:48'),(9,5,'Order Placed','Your order #KM9OaNhYJS1 has been successfully placed.',9,'Order','2025-04-07 21:23:45','2025-04-07 21:23:45'),(10,5,'Order Ready for Pickup','Your order #KM9OaNhYJS1 is now ready for pickup.',9,'Order','2025-04-07 21:24:41','2025-04-07 21:24:41'),(11,5,'Order Picked Up','Your order #KM9OaNhYJS1 has been successfully picked up.',9,'Order','2025-04-07 21:25:06','2025-04-07 21:25:06'),(12,6,'Order Placed','Your order #w82EtoQ0brg has been successfully placed.',9,'Order','2025-04-08 11:28:00','2025-04-08 11:28:00'),(13,6,'Order Ready for Pickup','Your order #w82EtoQ0brg is now ready for pickup.',9,'Order','2025-04-08 11:29:14','2025-04-08 11:29:14'),(14,6,'Order Placed','Your order #rjDlFxWTzy1 has been successfully placed.',9,'Order','2025-04-08 11:34:33','2025-04-08 11:34:33'),(15,6,'Order Ready for Pickup','Your order #rjDlFxWTzy1 is now ready for pickup.',9,'Order','2025-04-08 11:41:11','2025-04-08 11:41:11'),(16,6,'Order Placed','Your order #bMaEvwLZMxw has been successfully placed.',9,'Order','2025-04-08 11:48:02','2025-04-08 11:48:02'),(17,6,'Order Placed','Your order #1iebR3ZWtby has been successfully placed.',9,'Order','2025-04-08 14:04:15','2025-04-08 14:04:15'),(18,5,'Order Ready for Pickup','Your order #SqxNeCd9D88 is now ready for pickup.',9,'Order','2025-04-08 15:01:26','2025-04-08 15:01:26'),(19,6,'Order Ready for Pickup','Your order #bMaEvwLZMxw is now ready for pickup.',9,'Order','2025-04-08 15:01:42','2025-04-08 15:01:42'),(20,6,'Order Picked Up','Your order #bMaEvwLZMxw has been successfully picked up.',9,'Order','2025-04-08 15:03:25','2025-04-08 15:03:25'),(21,6,'Order Picked Up','Your order #rjDlFxWTzy1 has been successfully picked up.',9,'Order','2025-04-08 15:03:48','2025-04-08 15:03:48'),(22,6,'Order Picked Up','Your order #w82EtoQ0brg has been successfully picked up.',9,'Order','2025-04-08 15:04:10','2025-04-08 15:04:10');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items_tbl`
--

LOCK TABLES `order_items_tbl` WRITE;
/*!40000 ALTER TABLE `order_items_tbl` DISABLE KEYS */;
INSERT INTO `order_items_tbl` VALUES (1,1,1,5,10745.00,NULL,'2025-04-07 21:19:43'),(2,1,2,5,17495.00,NULL,'2025-04-07 21:19:43'),(3,1,4,9,20520.00,NULL,'2025-04-07 21:19:43'),(4,2,5,5,6495.00,NULL,'2025-04-07 21:19:54'),(5,3,6,5,6995.00,NULL,'2025-04-07 21:20:07'),(6,4,7,5,7495.00,NULL,'2025-04-07 21:20:17'),(7,5,4,1,2280.00,NULL,'2025-04-07 21:23:45'),(8,6,5,5,6495.00,NULL,'2025-04-08 11:27:59'),(9,6,6,5,6995.00,NULL,'2025-04-08 11:28:00'),(10,6,7,5,7495.00,NULL,'2025-04-08 11:28:00'),(11,7,2,5,17495.00,NULL,'2025-04-08 11:34:33'),(12,7,1,5,10745.00,NULL,'2025-04-08 11:34:33'),(13,8,1,5,10745.00,NULL,'2025-04-08 11:48:02'),(14,9,6,5,6995.00,NULL,'2025-04-08 14:04:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_tbl`
--

LOCK TABLES `orders_tbl` WRITE;
/*!40000 ALTER TABLE `orders_tbl` DISABLE KEYS */;
INSERT INTO `orders_tbl` VALUES (1,'CTXWh78Zjft',5,48760.00,1,4,'images/receipts/CTXWh78Zjft_67f3d192b2f4b.png','2025-04-07 21:20:56','2025-04-07 21:22:48',NULL,'2025-04-07 21:19:43','2025-04-07 21:19:43'),(2,'SqxNeCd9D88',5,6495.00,1,2,NULL,'2025-04-08 15:01:26',NULL,NULL,'2025-04-07 21:19:54','2025-04-07 21:19:54'),(3,'KgV3OcMCKvm',5,6995.00,1,3,NULL,'2025-04-07 21:21:55',NULL,'2025-04-07 21:23:18','2025-04-07 21:20:07','2025-04-07 21:23:18'),(4,'wnwGPngRSxu',5,7495.00,1,2,NULL,'2025-04-07 21:21:47',NULL,NULL,'2025-04-07 21:20:17','2025-04-07 21:20:17'),(5,'KM9OaNhYJS1',5,2280.00,1,4,'images/receipts/KM9OaNhYJS1_67f3d227a884a.png','2025-04-07 21:24:41','2025-04-07 21:25:06',NULL,'2025-04-07 21:23:45','2025-04-07 21:23:45'),(6,'w82EtoQ0brg',6,20985.00,1,4,'images/receipts/w82EtoQ0brg_67f4ca0966a13.png','2025-04-08 11:29:14','2025-04-08 15:04:10',NULL,'2025-04-08 11:27:59','2025-04-08 11:27:59'),(7,'rjDlFxWTzy1',6,28240.00,1,4,'images/receipts/rjDlFxWTzy1_67f4ca17a2401.png','2025-04-08 11:41:11','2025-04-08 15:03:48',NULL,'2025-04-08 11:34:33','2025-04-08 11:34:33'),(8,'bMaEvwLZMxw',6,10745.00,1,4,'images/receipts/bMaEvwLZMxw_67f4ca2b8c4a2.png','2025-04-08 15:01:42','2025-04-08 15:03:25',NULL,'2025-04-08 11:48:02','2025-04-08 11:48:02'),(9,'1iebR3ZWtby',6,6995.00,1,1,NULL,NULL,NULL,NULL,'2025-04-08 14:04:15','2025-04-08 14:04:15');
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
  `productSpecs` text NOT NULL,
  `productPrice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `inStock` int(11) NOT NULL DEFAULT 0,
  `prodSold` int(11) NOT NULL DEFAULT 0,
  `statusID` int(11) NOT NULL DEFAULT 5,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`productID`),
  UNIQUE KEY `productName` (`productName`),
  KEY `productCategoryFK` (`categoryID`) USING BTREE,
  KEY `productUserFK` (`userID`),
  KEY `productStatusFK` (`statusID`) USING BTREE,
  CONSTRAINT `productCategoryFK` FOREIGN KEY (`categoryID`) REFERENCES `categories_tbl` (`categoryID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `productStatusFK` FOREIGN KEY (`statusID`) REFERENCES `statuses_tbl` (`statusID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `productsUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_tbl`
--

LOCK TABLES `products_tbl` WRITE;
/*!40000 ALTER TABLE `products_tbl` DISABLE KEYS */;
INSERT INTO `products_tbl` VALUES (1,1,'Dry Chemical Fire Extinguisher','../images/products/fire-ex_dry-chem.jpg',1,'A dry chemical fire extinguisher is a versatile and widely used firefighting device designed to combat various types of fires. It contains a dry chemical powder, such as monoammonium phosphate, which quickly extinguishes flames by interrupting the chemical reaction of the fire. These extinguishers are effective against Class A (ordinary combustibles), Class B (flammable liquids), and Class C (electrical) fires, making them essential for homes, offices, and industrial settings.','Type: Dry Chemical Powder (ABC Type – Monoammonium Phosphate)\r\nFire Rating: Typically 2A:10B:C / 4A:60B:C / 6A:80B:C (varies by size)\r\nCapacity Options: 1kg / 2kg / 4kg / 6kg / 9kg / 12kg\r\nExtinguishing Agent: ABC Dry Chemical Powder\r\nPropellant: Dry Nitrogen\r\nDischarge Time: 2kg: ~8 seconds, 6kg: ~15 seconds, 9kg: ~20 seconds\r\nDischarge Range: ~2–6 meters\r\nOperating Temperature Range: -20°C to +60°C\r\nWorking Pressure: ~15 bar at 20°C\r\nCylinder Material: Mild Steel with corrosion-resistant coating\r\nValve Type: Squeeze grip control valve with safety pin and pressure gauge\r\nFinish: Red powder-coated body (RAL 3000)\r\nSuitable For: Class A fires (ordinary combustibles: wood, paper, cloth), Class B fires (flammable liquids: gasoline, oil, paint), Class C fires (electrical fires: appliances, wiring)\r\nNot Recommended For: Sensitive electronic equipment (powder leaves residue)\r\nCompliance: IS 15683 / BS EN 3 / NFPA 10\r\nCertifications: CE, ISO 9001, PESO, UL/FM (depending on manufacturer)',2149.00,85,100,5,'2025-03-07 10:56:42','2025-04-08 20:39:56'),(2,1,'HCFC-123 Fire Extinguisher','../images/products/fire-ex_HCFC-123.jpg',1,'The HCFC-123 fire extinguisher utilizes a clean agent called hydrochlorofluorocarbon-123 (HCFC-123) to suppress fires. It is highly effective for use in areas with sensitive electronic equipment, as it leaves no residue and causes minimal damage. This extinguisher is suitable for Class A, B, and C fires, making it an ideal choice for data centers, laboratories, and telecommunications facilities.','Type: Clean Agent (Halocarbon-based) Fire Extinguisher\r\nExtinguishing Agent: HCFC-123 (Hydrochlorofluorocarbon-123)\r\nFire Rating: Typically 1A:5B / 2A:10B (varies by size)\r\nCapacity Options: 1kg / 2kg / 4kg / 6kg / 9kg\r\nPropellant: Dry Nitrogen\r\nDischarge Time: 2kg: ~9 seconds, 6kg: ~20 seconds\r\nDischarge Range: ~2–4 meters\r\nOperating Temperature Range: -20°C to +55°C\r\nWorking Pressure: ~12 bar at 20°C\r\nCylinder Material: Mild Steel or Stainless Steel\r\nValve Type: Squeeze lever valve with pressure gauge\r\nFinish: Red or Green powder-coated body (depending on region)\r\nSuitable For: Class B fires (flammable liquids), Class C fires (flammable gases), Safe for use on electrical equipment\r\nCommon Usage: Data centers, telecom rooms, control rooms, medical facilities, etc., Leaves no residue and minimal damage to sensitive equipment\r\nCompliance: IS 15683 / NFPA 10 (depending on country)\r\nCertifications: CE, ISO 9001, PESO/UL/FM (based on manufacturer)',3499.00,90,95,5,'2025-03-07 10:58:51','2025-04-08 20:45:19'),(4,1,'AFFF Fire Extinguisher','../images/products/fire-ex_AFFF.jpg',1,'An Aqueous Film Forming Foam (AFFF) fire extinguisher is designed to combat flammable liquid fires by creating a smothering foam blanket over the burning liquid. It is highly effective for use on Class B fires, which involve flammable liquids such as gasoline, oil, and solvents. AFFF extinguishers are commonly used in airports, industrial facilities, and fuel storage areas to provide quick and efficient fire suppression.','Type: AFFF (Aqueous Film Forming Foam) Stored Pressure\r\nFire Rating: Typically 8A:144B (varies by size)\r\nCapacity Options: 2L / 6L / 9L (commonly available)\r\nExtinguishing Agent: AFFF Concentrate (typically 6%) mixed with water\r\nPropellant: Dry Nitrogen or Compressed Air\r\nDischarge Time: 2L: ~12 seconds, 6L: ~20 seconds, 9L: ~30 seconds\r\nDischarge Range: ~4–6 meters\r\nOperating Temperature Range: +5°C to +60°C\r\nWorking Pressure: 12–15 bar\r\nCylinder Material: Mild Steel (with internal corrosion-resistant lining)\r\nValve Type: Squeeze grip control valve with safety pin and seal\r\nFinish: Red powder-coated body (RAL 3000)\r\nSuitable For: Class A fires (solids such as wood, paper, textiles), Class B fires (flammable liquids like petrol, diesel)\r\nNot Suitable For: Live electrical fires (unless tested as dielectric safe)\r\nCompliance: BS EN 3\r\nCertifications: CE Marked, Kitemark (optional), ISO 9001 Manufacturing Standard',2280.00,90,95,5,'2025-03-07 11:11:22','2025-04-08 20:38:03'),(5,1,'AH-0715 Smoke Detector','../images/products/smoke-detect_AH-0715.jpeg',2,'The AH-0715 smoke detector is a combination smoke and heat detector designed for reliable fire detection. It features a twin-color LED display for easy status identification and is made of fire-proof plastic for durability. This detector is suitable for various applications, including residential and commercial buildings, and is available in 2-wire, 3-wire, and 4-wire configurations.','Type: Photoelectric Smoke Detector\r\nPower Supply: DC 9V (Battery operated)\r\nAlarm Sound Level: ≥ 85 dB at 3 meters\r\nSensor Type: Photoelectric sensing chamber\r\nAlarm Indicator: Red LED (Flashes in standby, solid during alarm)\r\nTest Button: Yes (for manual testing)\r\nLow Battery Indicator: Yes (audible beep + LED flash)\r\nMounting Type: Ceiling or wall mount\r\nOperating Temperature: -10°C to +50°C\r\nHumidity Range: ≤ 95% RH (non-condensing)\r\nDimensions: Approx. 100mm diameter × 35mm height\r\nWeight: ~115g (with battery)\r\nCompliance: EN14604\r\nCertifications: CE, RoHS',1299.00,90,80,5,'2025-03-07 11:13:26','2025-04-08 20:46:19'),(6,1,'AH-9920 Smoke Detector','../images/products/smoke-detect_AH-9920.jpeg',2,'The AH-9920 smoke detector is a mechanical fixed-temperature heat detector designed to operate on the temperature differential sensing principle. It features a UL-approved sensor and is made of high-quality, fire-proof plastic, ensuring durability and reliability even in challenging environments. This detector is suitable for locations with high temperature differentials, such as kitchens, restaurants, and boiler houses.','Type: Photoelectric Smoke Detector\r\nPower Supply: DC 9V (Battery operated)\r\nAlarm Sound Level: ≥ 85 dB at 3 meters\r\nSensor Type: Photoelectric sensing chamber\r\nAlarm Indicator: Red LED (Flashes in standby, solid during alarm)\r\nTest Button: Yes (for manual testing)\r\nLow Battery Indicator: Yes (audible beep + LED flash)\r\nMounting Type: Ceiling or wall mount\r\nOperating Temperature: -10°C to +50°C\r\nHumidity Range: ≤ 95% RH (non-condensing)\r\nDimensions: Approx. 100mm diameter × 35mm height\r\nWeight: ~110g (with battery)\r\nCompliance: EN14604\r\nCertifications: CE, RoHS',1399.00,90,85,5,'2025-03-07 11:13:54','2025-04-08 20:47:29'),(7,1,'QA05 Smoke Detector','../images/products/smoke-detect_QA05.jpeg',2,'The QA05 smoke detector is an addressable combination smoke and heat detector designed for reliable fire detection. It features address coding by dip switch, a latching function for clear alarm identification, and a magnetic test feature for easy maintenance. Made of high endurance, fire-proof plastic, it also includes dual LEDs for 360-degree visibility and has passed strict EMC tests to minimize false alarms.','Type: Photoelectric Smoke Detector\r\nPower Supply: DC 9V (Battery operated)\r\nAlarm Sound Level: ≥ 85 dB at 3 meters\r\nSensor Type: Photoelectric sensing chamber\r\nAlarm Indicator: Red LED (Flashes in standby, solid during alarm)\r\nTest Button: Yes (for manual testing)\r\nLow Battery Indicator: Yes (audible beep + LED flash)\r\nMounting Type: Ceiling or wall mount\r\nOperating Temperature: -10°C to +50°C\r\nHumidity Range: ≤ 95% RH (non-condensing)\r\nDimensions: Approx. 100mm diameter × 35mm height\r\nWeight: ~120g (with battery)\r\nCompliance: EN14604 / UL 217 (depending on region)\r\nCertifications: CE, RoHS',1499.00,90,80,5,'2025-03-07 11:17:06','2025-04-08 20:48:11'),(11,1,'testProduct','../images/products/low-poly-fire-hydrant-03_67f513c01a6b4.jpg',1,'test description','',1000000.00,1,0,5,'2025-04-08 14:17:04','2025-04-09 03:15:08'),(12,1,'testProduct1','../images/products/low-poly-fire-hydrant-03_67f5662bbe885.jpg',1,'test description','Type: AFFF (Aqueous Film Forming Foam) Stored Pressure\r\nCapacity Options: 2L / 6L / 9L (commonly available)\r\nExtinguishing Agent: AFFF Concentrate (typically 6%) mixed with water\r\nPropellant: Dry Nitrogen or Compressed Air\r\nDischarge Range: ~4–6 meters\r\nOperating Temperature Range: +5°C to +60°C\r\nWorking Pressure: 12–15 bar\r\nCylinder Material: Mild Steel (with internal corrosion-resistant lining)\r\nValve Type: Squeeze grip control valve with safety pin and seal\r\nFinish: Red powder-coated body (RAL 3000)\r\nSuitable For: Class A fires (solids such as wood, paper, textiles), Class B fires (flammable liquids like petrol, diesel)\r\nNot Suitable For: Live electrical fires (unless tested as dielectric safe)\r\nCompliance: BS EN 3',10000.00,1,0,6,'2025-04-08 20:08:43','2025-04-09 03:14:53');
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
  CONSTRAINT `reviewProductFK` FOREIGN KEY (`productID`) REFERENCES `products_tbl` (`productID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `reviewUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews_tbl`
--

LOCK TABLES `reviews_tbl` WRITE;
/*!40000 ALTER TABLE `reviews_tbl` DISABLE KEYS */;
INSERT INTO `reviews_tbl` VALUES (1,NULL,5,'very poggers',5,'2025-04-07 23:34:14'),(2,12,5,'very cool',5,'2025-04-09 03:04:14');
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
INSERT INTO `statuses_tbl` VALUES (1,'Processing','Orders','2025-03-13 16:40:50','2025-03-13 16:40:50'),(2,'To Pick Up','Orders','2025-03-13 16:40:58','2025-03-13 16:40:58'),(3,'Cancelled','Orders','2025-03-13 16:41:25','2025-03-13 16:41:25'),(4,'Picked Up','Orders','2025-03-20 15:03:22','2025-03-20 15:03:22'),(5,'Active','Cart Items, Products','2025-03-20 15:03:29','2025-03-20 15:03:29'),(6,'Removed','Cart Items, Products','2025-03-20 15:03:49','2025-03-20 15:03:49'),(7,'Ordered','Cart Items','2025-03-20 15:04:00','2025-03-20 15:04:00'),(8,'Read','Notifications','2025-03-20 15:04:15','2025-03-20 15:04:15'),(9,'Unread','Notifications','2025-03-20 15:04:26','2025-03-20 15:04:26');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_tbl`
--

LOCK TABLES `users_tbl` WRITE;
/*!40000 ALTER TABLE `users_tbl` DISABLE KEYS */;
INSERT INTO `users_tbl` VALUES (1,'Weltz','Admin','Cainta','09562898062','weltzphils@gmail.com','$2y$10$9kIflVamTp1lba06/HSYbO9qwiqK9RzVWpZkXibdcm10WZjdVyxjq',2,0,'Verified',0,NULL,'2025-03-11 13:05:02','2025-03-22 11:18:19'),(2,'Mert','Isip','Manila','09562898062','mertalexis.isip.cics@ust.edu.ph','$2y$10$9kIflVamTp1lba06/HSYbO9qwiqK9RzVWpZkXibdcm10WZjdVyxjq',2,0,'Verified',0,NULL,'2025-03-11 13:05:21','2025-03-17 13:17:14'),(3,'Ken','Gopez','Valenzuela','12345678910','kristoffer.gopez.cics@ust.edu.ph','$2y$10$9kIflVamTp1lba06/HSYbO9qwiqK9RzVWpZkXibdcm10WZjdVyxjq',2,0,'Verified',0,NULL,'2025-03-16 10:39:02','2025-03-16 10:39:02'),(4,'Cyril','Labao','Bacoor','12345678910','cyrillabao@gmail.com','$2y$10$9kIflVamTp1lba06/HSYbO9qwiqK9RzVWpZkXibdcm10WZjdVyxjq',2,0,'Verified',0,NULL,'2025-03-16 10:39:43','2025-03-16 10:39:43'),(5,'Mert','Isip','2960 Rizal Ave. Sta. Cruz','9562898062','mertiscool031@gmail.com','$2y$10$39f9Tryyai09GYaCYy1Fh.CnAvkTMaKTL8em0GI2qYNPUbnwMCdsu',1,132096,'Verified',0,NULL,'2025-04-07 15:17:27','2025-04-07 15:17:27'),(6,'Mert','Isip','2960 Rizal Ave. Sta. Cruz','9562898062','mertisepic031@gmail.com','$2y$10$NSQntOnzyDgJWScsa0.qxeaAhKklF6hynnuJvjc88lE4jqC8OS1cy',1,307262,'Unverified',0,NULL,'2025-04-08 05:15:57','2025-04-08 05:15:57');
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

-- Dump completed on 2025-04-09  3:42:29
