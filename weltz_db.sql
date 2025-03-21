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
  `userID` int(11) NOT NULL DEFAULT 0,
  `actionType` varchar(50) NOT NULL DEFAULT '',
  `tableName` varchar(50) NOT NULL DEFAULT '',
  `recordID` int(11) NOT NULL DEFAULT 0,
  `oldValues` text DEFAULT NULL,
  `newValues` text DEFAULT NULL,
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`auditID`)
) ENGINE=InnoDB AUTO_INCREMENT=336 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-16 10:38:10'),(2,1,'CREATE','users_tbl',3,NULL,'{\"userFname\":\"Ken\",\"userLname\":\"Gopez\",\"userAdd\":\"Valenzuela\",\"userPhone\":\"12345678910\",\"userEmail\":\"kristoffer.gopez.cics@ust.edu.ph\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-16 10:39:02'),(3,1,'CREATE','users_tbl',4,NULL,'{\"userFname\":\"Cyril\",\"userLname\":\"Labao\",\"userAdd\":\"Bacoor\",\"userPhone\":\"12345678910\",\"userEmail\":\"cyrillabao@gmail.com\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-16 10:39:43'),(4,1,'CREATE','users_tbl',5,NULL,'{\"userFname\":\"Dummy\",\"userLname\":\"Admin\",\"userAdd\":\"DummyCity\",\"userPhone\":\"12345678910\",\"userEmail\":\"dummy@email.com\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-16 10:40:21'),(5,1,'DELETE','users_tbl',5,'{\"userFname\":\"Dummy\",\"userLname\":\"Admin\",\"userAdd\":\"DummyCity\",\"userPhone\":\"12345678910\",\"userEmail\":\"dummy@email.com\"}',NULL,'2025-03-16 10:40:38'),(6,1,'UPDATE','users_tbl',2,'{\"userEmail\":\"mertisepic031@gmail.com\"}','{\"userEmail\":\"mertiscool031@gmail.com\"}','2025-03-16 10:43:34'),(7,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-16 10:44:55'),(8,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-16 12:25:26'),(9,1,'CREATE','products_tbl',8,NULL,'{\"userID\":1,\"productName\":\"testProduct\",\"productIMG\":\"..\\/images\\/products\\/low-poly-fire-hydrant-03_67d6b75b28f3e.jpg\",\"categoryID\":\"1\",\"productDesc\":\"this is a test description for test product\",\"productPrice\":\"1000000\",\"inStock\":\"1\"}','2025-03-16 12:34:51'),(10,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-16 13:27:39'),(11,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-17 10:09:03'),(12,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-17 10:09:28'),(13,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-17 12:31:47'),(14,1,'UPDATE','products_tbl',1,'{\"categoryID\":1,\"inStock\":0}','{\"categoryID\":\"1\",\"inStock\":\"10\"}','2025-03-17 13:02:00'),(15,1,'UPDATE','users_tbl',2,'{\"userEmail\":\"mertiscool031@gmail.com\"}','{\"userEmail\":\"mertisepic031@gmail.com\"}','2025-03-17 13:17:14'),(16,1,'UPDATE','products_tbl',2,'{\"categoryID\":1,\"inStock\":0}','{\"categoryID\":\"1\",\"inStock\":\"10\"}','2025-03-17 13:26:59'),(17,1,'UPDATE','products_tbl',1,'{\"categoryID\":1,\"inStock\":10}','{\"categoryID\":\"1\",\"inStock\":\"10\"}','2025-03-17 13:27:26'),(18,1,'UPDATE','products_tbl',4,'{\"inStock\":0}','{\"inStock\":10}','2025-03-17 13:31:06'),(19,1,'UPDATE','products_tbl',5,'{\"inStock\":0}','{\"inStock\":10}','2025-03-17 13:31:10'),(20,1,'UPDATE','products_tbl',7,'{\"inStock\":0}','{\"inStock\":10}','2025-03-17 13:31:15'),(21,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-17 13:31:25'),(22,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-17 13:31:54'),(23,1,'UPDATE','products_tbl',6,'{\"inStock\":0}','{\"inStock\":10}','2025-03-17 13:34:10'),(24,1,'DELETE','products_tbl',8,'{\"productID\":8,\"productName\":\"testProduct\",\"productIMG\":\"..\\/images\\/products\\/low-poly-fire-hydrant-03_67d6b75b28f3e.jpg\",\"categoryID\":1,\"productDesc\":\"this is a test description for test product\",\"productPrice\":\"1000000.00\",\"inStock\":1}',NULL,'2025-03-17 14:14:12'),(25,1,'CREATE','products_tbl',9,NULL,'{\"userID\":1,\"productName\":\"testProduct\",\"productIMG\":\"..\\/images\\/products\\/low-poly-fire-hydrant-03_67d82143cef2e.jpg\",\"categoryID\":\"1\",\"productDesc\":\"this is a description for test product\",\"productPrice\":\"1000000\",\"inStock\":\"1\"}','2025-03-17 14:18:59'),(26,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-17 14:19:39'),(27,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-17 14:22:58'),(28,1,'CREATE','users_tbl',6,NULL,'{\"userFname\":\"Admin\",\"userLname\":\"User\",\"userAdd\":\"AdminCity\",\"userPhone\":\"12345678910\",\"userEmail\":\"admin@example.com\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-17 14:23:33'),(29,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-17 14:23:47'),(30,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-17 14:29:43'),(31,1,'DELETE','users_tbl',6,'{\"userFname\":\"Admin\",\"userLname\":\"User\",\"userAdd\":\"AdminCity\",\"userPhone\":\"12345678910\",\"userEmail\":\"admin@example.com\"}',NULL,'2025-03-17 14:29:58'),(32,1,'CREATE','users_tbl',7,NULL,'{\"userFname\":\"Admin\",\"userLname\":\"User\",\"userAdd\":\"AdminCity\",\"userPhone\":\"12345678910\",\"userEmail\":\"admin@example.com\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-17 14:32:59'),(33,7,'LOGIN','users_tbl',7,NULL,'{\"status\":\"success\"}','2025-03-18 19:33:29'),(34,7,'LOGOUT','users_tbl',7,NULL,'{\"status\":\"logged out\"}','2025-03-18 20:01:01'),(35,2,'LOGIN','users_tbl',2,NULL,'{\"status\":\"success\"}','2025-03-18 20:01:13'),(36,2,'LOGIN','users_tbl',2,NULL,'{\"status\":\"success\"}','2025-03-18 20:01:35'),(37,2,'LOGIN','users_tbl',2,NULL,'{\"status\":\"success\"}','2025-03-19 12:45:14'),(38,2,'UPDATE','cart_items_tbl',4,'{\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495.00\"}','{\"cartItemQuantity\":10,\"cartItemTotal\":12990,\"updatedAt\":\"2025-03-19 15:09:01\"}','2025-03-19 15:09:01'),(39,2,'DELETE','cart_items_tbl',6,'{\"cartItemID\":6,\"cartID\":1,\"productID\":7,\"cartItemQuantity\":5,\"cartItemTotal\":\"7495.00\"}',NULL,'2025-03-19 16:56:35'),(40,2,'DELETE','cart_items_tbl',6,'null',NULL,'2025-03-19 16:56:47'),(41,2,'DELETE','cart_items_tbl',6,'null',NULL,'2025-03-19 16:56:47'),(42,2,'DELETE','cart_items_tbl',6,'null',NULL,'2025-03-19 16:56:51'),(43,2,'DELETE','cart_items_tbl',6,'null',NULL,'2025-03-19 16:56:51'),(44,2,'DELETE','cart_items_tbl',6,'null',NULL,'2025-03-19 16:56:52'),(45,2,'DELETE','cart_items_tbl',6,'null',NULL,'2025-03-19 16:56:52'),(46,2,'DELETE','cart_items_tbl',5,'{\"cartItemID\":5,\"cartID\":1,\"productID\":6,\"cartItemQuantity\":5,\"cartItemTotal\":\"6995.00\"}',NULL,'2025-03-19 16:56:59'),(47,2,'DELETE','cart_items_tbl',4,'{\"cartItemID\":4,\"cartID\":1,\"productID\":5,\"cartItemQuantity\":10,\"cartItemTotal\":\"12990.00\"}',NULL,'2025-03-19 16:57:49'),(48,2,'DELETE','cart_items_tbl',3,'{\"cartItemID\":3,\"cartID\":1,\"productID\":4,\"cartItemQuantity\":5,\"cartItemTotal\":\"11400.00\"}',NULL,'2025-03-19 16:58:06'),(49,2,'DELETE','cart_items_tbl',2,'{\"cartItemID\":2,\"cartID\":1,\"productID\":2,\"cartItemQuantity\":5,\"cartItemTotal\":\"17495.00\"}',NULL,'2025-03-19 17:01:11'),(50,2,'DELETE','cart_items_tbl',1,'{\"cartItemID\":1,\"cartID\":1,\"productID\":1,\"cartItemQuantity\":25,\"cartItemTotal\":\"53725.00\"}',NULL,'2025-03-19 17:01:13'),(51,2,'INSERT','cart_items_tbl',7,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"2149\"}','2025-03-19 17:11:48'),(52,2,'INSERT','cart_items_tbl',8,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"3499\"}','2025-03-19 17:11:54'),(53,2,'INSERT','cart_items_tbl',9,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"2280\"}','2025-03-19 17:11:59'),(54,2,'DELETE','cart_items_tbl',9,'{\"cartItemID\":9,\"cartID\":1,\"productID\":4,\"cartItemQuantity\":1,\"cartItemTotal\":\"2280.00\"}',NULL,'2025-03-19 17:20:51'),(55,2,'DELETE','cart_items_tbl',7,'{\"cartItemID\":7,\"cartID\":1,\"productID\":1,\"cartItemQuantity\":1,\"cartItemTotal\":\"2149.00\"}',NULL,'2025-03-19 17:20:55'),(56,2,'DELETE','cart_items_tbl',8,'{\"cartItemID\":8,\"cartID\":1,\"productID\":2,\"cartItemQuantity\":1,\"cartItemTotal\":\"3499.00\"}',NULL,'2025-03-19 17:20:56'),(57,2,'INSERT','cart_items_tbl',10,NULL,'{\"cartID\":\"1\",\"productID\":\"9\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1000000\"}','2025-03-19 18:34:13'),(58,2,'INSERT','cart_items_tbl',11,NULL,'{\"cartID\":\"1\",\"productID\":\"7\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1499\"}','2025-03-19 18:34:25'),(59,2,'INSERT','cart_items_tbl',12,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1399\"}','2025-03-19 18:34:36'),(60,2,'INSERT','cart_items_tbl',13,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1299\"}','2025-03-19 18:34:39'),(61,2,'INSERT','cart_items_tbl',14,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"2280\"}','2025-03-19 18:34:55'),(62,2,'INSERT','cart_items_tbl',15,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"3499\"}','2025-03-19 18:34:58'),(63,2,'INSERT','cart_items_tbl',16,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"2149\"}','2025-03-19 18:35:02'),(64,2,'DELETE','cart_items_tbl',11,'{\"cartItemID\":11,\"cartID\":1,\"productID\":7,\"cartItemQuantity\":1,\"cartItemTotal\":\"1499.00\"}',NULL,'2025-03-19 18:45:46'),(65,2,'DELETE','cart_items_tbl',12,'{\"cartItemID\":12,\"cartID\":1,\"productID\":6,\"cartItemQuantity\":1,\"cartItemTotal\":\"1399.00\"}',NULL,'2025-03-19 18:46:36'),(66,2,'DELETE','cart_items_tbl',13,'{\"cartItemID\":13,\"cartID\":1,\"productID\":5,\"cartItemQuantity\":1,\"cartItemTotal\":\"1299.00\"}',NULL,'2025-03-19 18:46:37'),(67,2,'DELETE','cart_items_tbl',10,'{\"cartItemID\":10,\"cartID\":1,\"productID\":9,\"cartItemQuantity\":1,\"cartItemTotal\":\"1000000.00\"}',NULL,'2025-03-20 06:06:25'),(68,2,'DELETE','cart_items_tbl',14,'{\"cartItemID\":14,\"cartID\":1,\"productID\":4,\"cartItemQuantity\":1,\"cartItemTotal\":\"2280.00\"}',NULL,'2025-03-20 06:06:35'),(69,2,'DELETE','products_tbl',9,'{\"productID\":9,\"productName\":\"testProduct\",\"productIMG\":\"..\\/images\\/products\\/low-poly-fire-hydrant-03_67d82143cef2e.jpg\",\"categoryID\":1,\"productDesc\":\"this is a description for test product\",\"productPrice\":\"1000000.00\",\"inStock\":1}',NULL,'2025-03-20 06:31:34'),(70,2,'INSERT','cart_items_tbl',17,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"2280\"}','2025-03-20 07:51:29'),(71,2,'INSERT','cart_items_tbl',18,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1299\"}','2025-03-20 07:51:42'),(72,2,'DELETE','cart_items_tbl',16,'{\"cartItemID\":16,\"cartID\":1,\"productID\":1,\"cartItemQuantity\":1,\"cartItemTotal\":\"2149.00\"}',NULL,'2025-03-20 08:14:31'),(73,2,'DELETE','cart_items_tbl',18,'{\"cartItemID\":18,\"cartID\":1,\"productID\":5,\"cartItemQuantity\":1,\"cartItemTotal\":\"1299.00\"}',NULL,'2025-03-20 08:14:41'),(74,2,'DELETE','cart_items_tbl',15,'{\"cartItemID\":15,\"cartID\":1,\"productID\":2,\"cartItemQuantity\":1,\"cartItemTotal\":\"3499.00\"}',NULL,'2025-03-20 08:14:46'),(75,2,'DELETE','cart_items_tbl',17,'{\"cartItemID\":17,\"cartID\":1,\"productID\":4,\"cartItemQuantity\":1,\"cartItemTotal\":\"2280.00\"}',NULL,'2025-03-20 08:14:46'),(76,2,'INSERT','cart_items_tbl',19,NULL,'{\"cartID\":\"1\",\"productID\":\"7\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1499\"}','2025-03-20 08:15:55'),(77,2,'INSERT','cart_items_tbl',20,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1399\"}','2025-03-20 08:15:57'),(78,2,'INSERT','cart_items_tbl',21,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1299\"}','2025-03-20 08:16:01'),(79,2,'UPDATE','cart_items_tbl',19,'{\"cartItemQuantity\":\"2\",\"cartItemTotal\":\"2998.00\"}','{\"cartItemQuantity\":\"2\",\"cartItemTotal\":\"2998\"}','2025-03-20 08:24:46'),(80,2,'UPDATE','cart_items_tbl',19,'{\"cartItemQuantity\":\"3\",\"cartItemTotal\":\"4497.00\"}','{\"cartItemQuantity\":\"3\",\"cartItemTotal\":\"4497\"}','2025-03-20 08:25:37'),(81,2,'UPDATE','cart_items_tbl',20,'{\"cartItemQuantity\":\"2\",\"cartItemTotal\":\"2798.00\"}','{\"cartItemQuantity\":\"2\",\"cartItemTotal\":\"2798\"}','2025-03-20 08:25:52'),(82,2,'UPDATE','cart_items_tbl',20,'{\"cartItemQuantity\":\"3\",\"cartItemTotal\":\"4197.00\"}','{\"cartItemQuantity\":\"3\",\"cartItemTotal\":\"4197\"}','2025-03-20 08:25:52'),(83,2,'UPDATE','cart_items_tbl',21,'{\"cartItemQuantity\":\"2\",\"cartItemTotal\":\"2598.00\"}','{\"cartItemQuantity\":\"2\",\"cartItemTotal\":\"2598\"}','2025-03-20 08:25:53'),(84,2,'UPDATE','cart_items_tbl',21,'{\"cartItemQuantity\":\"3\",\"cartItemTotal\":\"3897.00\"}','{\"cartItemQuantity\":\"3\",\"cartItemTotal\":\"3897\"}','2025-03-20 08:25:53'),(85,2,'UPDATE','cart_items_tbl',19,'{\"cartItemQuantity\":\"2\",\"cartItemTotal\":\"2998.00\"}','{\"cartItemQuantity\":\"2\",\"cartItemTotal\":\"2998\"}','2025-03-20 08:26:00'),(86,2,'INSERT','cart_items_tbl',22,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-20 08:33:08'),(87,2,'UPDATE','cart_items_tbl',20,'{\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1399.00\"}','{\"cartItemQuantity\":5,\"cartItemTotal\":6995}','2025-03-20 08:48:18'),(88,2,'UPDATE','products_tbl',1,'{\"inStock\":10}','{\"inStock\":100}','2025-03-20 09:43:04'),(89,2,'UPDATE','products_tbl',2,'{\"inStock\":10}','{\"inStock\":100}','2025-03-20 09:43:07'),(90,2,'UPDATE','products_tbl',4,'{\"inStock\":10}','{\"inStock\":100}','2025-03-20 09:43:12'),(91,2,'UPDATE','products_tbl',5,'{\"inStock\":10}','{\"inStock\":100}','2025-03-20 09:43:16'),(92,2,'UPDATE','products_tbl',6,'{\"inStock\":10}','{\"inStock\":100}','2025-03-20 09:43:20'),(93,2,'UPDATE','products_tbl',7,'{\"inStock\":10}','{\"inStock\":100}','2025-03-20 09:43:26'),(94,2,'UPDATE','cart_items_tbl',19,'{\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495.00\"}','{\"cartItemQuantity\":6,\"cartItemTotal\":8994}','2025-03-20 09:58:47'),(95,2,'DELETE','cart_items_tbl',19,'{\"cartItemID\":19,\"cartID\":1,\"productID\":7,\"cartItemQuantity\":5,\"cartItemTotal\":\"7495.00\"}',NULL,'2025-03-20 12:35:43'),(96,2,'DELETE','cart_items_tbl',20,'{\"cartItemID\":20,\"cartID\":1,\"productID\":6,\"cartItemQuantity\":5,\"cartItemTotal\":\"6995.00\"}',NULL,'2025-03-20 12:35:44'),(97,2,'DELETE','cart_items_tbl',22,'{\"cartItemID\":22,\"cartID\":1,\"productID\":4,\"cartItemQuantity\":5,\"cartItemTotal\":\"11400.00\"}',NULL,'2025-03-20 12:35:48'),(98,2,'DELETE','cart_items_tbl',21,'{\"cartItemID\":21,\"cartID\":1,\"productID\":5,\"cartItemQuantity\":5,\"cartItemTotal\":\"6495.00\"}',NULL,'2025-03-20 12:35:48'),(99,2,'INSERT','cart_items_tbl',23,NULL,'{\"cartID\":\"1\",\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495\"}','2025-03-20 12:35:56'),(100,2,'LOGIN','users_tbl',2,NULL,'{\"status\":\"success\"}','2025-03-20 12:36:34'),(101,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-20 12:36:42'),(102,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-20 12:36:45'),(103,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-20 12:38:19'),(104,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-20 12:38:20'),(105,2,'LOGIN','users_tbl',2,NULL,'{\"status\":\"success\"}','2025-03-20 12:38:48'),(106,2,'INSERT','cart_items_tbl',24,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1399\"}','2025-03-20 13:28:45'),(107,2,'INSERT','cart_items_tbl',25,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1299\"}','2025-03-20 13:28:49'),(108,2,'INSERT','cart_items_tbl',26,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"2149\"}','2025-03-20 13:42:37'),(109,2,'INSERT','cart_items_tbl',27,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"3499\"}','2025-03-20 13:42:42'),(110,2,'INSERT','cart_items_tbl',28,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"2280\"}','2025-03-20 13:42:49'),(111,2,'INSERT','cart_items_tbl',29,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"4\",\"cartItemTotal\":\"8596\"}','2025-03-20 13:58:39'),(112,2,'INSERT','cart_items_tbl',30,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"4\",\"cartItemTotal\":\"13996\"}','2025-03-20 13:58:44'),(113,2,'INSERT','cart_items_tbl',31,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"4\",\"cartItemTotal\":\"9120\"}','2025-03-20 13:58:48'),(114,2,'INSERT','cart_items_tbl',32,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"4\",\"cartItemTotal\":\"5196\"}','2025-03-20 13:58:52'),(115,2,'INSERT','cart_items_tbl',33,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"4\",\"cartItemTotal\":\"5596\"}','2025-03-20 13:58:56'),(116,2,'INSERT','cart_items_tbl',34,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"4\",\"cartItemTotal\":\"5196\"}','2025-03-20 14:01:01'),(117,2,'INSERT','cart_items_tbl',35,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"4\",\"cartItemTotal\":\"5596\"}','2025-03-20 14:01:06'),(118,2,'INSERT','cart_items_tbl',36,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-03-20 14:12:46'),(119,2,'INSERT','cart_items_tbl',37,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-20 14:12:50'),(120,2,'INSERT','cart_items_tbl',38,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-20 14:12:56'),(121,2,'INSERT','cart_items_tbl',39,NULL,'{\"cartID\":\"1\",\"productID\":\"7\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1499\"}','2025-03-20 14:24:27'),(122,2,'INSERT','cart_items_tbl',40,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1399\"}','2025-03-20 14:24:31'),(123,2,'INSERT','cart_items_tbl',41,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"1\",\"cartItemTotal\":\"1299\"}','2025-03-20 14:24:33'),(124,2,'INSERT','cart_items_tbl',42,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"9\",\"cartItemTotal\":\"12591\"}','2025-03-20 14:32:23'),(125,2,'INSERT','cart_items_tbl',43,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 14:32:29'),(126,2,'INSERT','cart_items_tbl',44,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-20 14:36:14'),(127,2,'INSERT','cart_items_tbl',45,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-20 14:36:20'),(128,2,'INSERT','cart_items_tbl',46,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-20 14:37:41'),(129,2,'INSERT','cart_items_tbl',47,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-20 14:37:52'),(130,2,'INSERT','cart_items_tbl',48,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-03-20 14:40:14'),(131,2,'INSERT','cart_items_tbl',49,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 14:40:18'),(132,2,'INSERT','cart_items_tbl',50,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 14:48:12'),(133,2,'INSERT','cart_items_tbl',51,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-20 14:48:16'),(134,2,'INSERT','cart_items_tbl',52,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 14:49:04'),(135,2,'INSERT','cart_items_tbl',53,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-20 14:49:11'),(136,2,'INSERT','cart_items_tbl',54,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-03-20 14:49:15'),(137,2,'INSERT','cart_items_tbl',55,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 14:58:56'),(138,2,'INSERT','cart_items_tbl',56,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-03-20 14:59:05'),(139,2,'INSERT','cart_items_tbl',57,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 15:02:04'),(140,2,'INSERT','cart_items_tbl',58,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-03-20 15:02:09'),(141,2,'INSERT','cart_items_tbl',59,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-03-20 15:03:02'),(142,2,'INSERT','cart_items_tbl',60,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 15:03:08'),(143,2,'INSERT','cart_items_tbl',61,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 15:12:50'),(144,2,'INSERT','cart_items_tbl',62,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-20 15:12:53'),(145,2,'INSERT','cart_items_tbl',63,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 15:13:34'),(146,2,'INSERT','cart_items_tbl',64,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-20 15:13:39'),(147,2,'INSERT','cart_items_tbl',65,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-03-20 15:13:42'),(148,2,'INSERT','cart_items_tbl',66,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-03-20 15:35:52'),(149,2,'INSERT','cart_items_tbl',67,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-20 15:35:57'),(150,2,'INSERT','cart_items_tbl',68,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-20 15:37:15'),(151,2,'INSERT','cart_items_tbl',69,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-20 15:40:39'),(152,2,'INSERT','cart_items_tbl',70,NULL,'{\"cartID\":\"1\",\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495\"}','2025-03-20 15:40:46'),(153,2,'INSERT','cart_items_tbl',71,NULL,'{\"cartID\":\"1\",\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495\"}','2025-03-20 15:41:23'),(154,2,'INSERT','cart_items_tbl',72,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-03-20 15:41:27'),(155,2,'INSERT','cart_items_tbl',73,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-03-20 16:07:14'),(156,2,'INSERT','cart_items_tbl',74,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 16:07:19'),(157,2,'INSERT','cart_items_tbl',75,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 16:12:15'),(158,2,'INSERT','cart_items_tbl',76,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-20 16:12:19'),(159,2,'UPDATE','products_tbl',1,'{\"inStock\":80}','{\"inStock\":100}','2025-03-20 16:14:11'),(160,2,'UPDATE','products_tbl',2,'{\"inStock\":80}','{\"inStock\":100}','2025-03-20 16:14:16'),(161,2,'UPDATE','products_tbl',4,'{\"inStock\":75}','{\"inStock\":100}','2025-03-20 16:14:20'),(162,2,'UPDATE','products_tbl',5,'{\"inStock\":80}','{\"inStock\":100}','2025-03-20 16:14:24'),(163,2,'UPDATE','products_tbl',6,'{\"inStock\":75}','{\"inStock\":100}','2025-03-20 16:14:28'),(164,2,'UPDATE','products_tbl',7,'{\"inStock\":75}','{\"inStock\":100}','2025-03-20 16:14:33'),(165,2,'INSERT','cart_items_tbl',1,NULL,'{\"cartID\":\"1\",\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495\"}','2025-03-20 16:15:38'),(166,2,'INSERT','cart_items_tbl',2,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-03-20 16:15:42'),(167,2,'INSERT','cart_items_tbl',3,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 16:15:47'),(168,2,'INSERT','cart_items_tbl',1,NULL,'{\"cartID\":\"1\",\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495\"}','2025-03-20 16:21:15'),(169,2,'INSERT','cart_items_tbl',2,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-03-20 16:21:19'),(170,2,'INSERT','cart_items_tbl',3,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 16:21:22'),(171,2,'INSERT','cart_items_tbl',4,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-20 16:28:15'),(172,2,'INSERT','cart_items_tbl',5,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-20 16:28:21'),(173,2,'INSERT','cart_items_tbl',6,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-03-20 16:28:26'),(174,2,'INSERT','cart_items_tbl',1,NULL,'{\"cartID\":\"1\",\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495\"}','2025-03-20 16:33:11'),(175,2,'INSERT','cart_items_tbl',2,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-03-20 16:33:17'),(176,2,'INSERT','cart_items_tbl',3,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 16:33:23'),(177,2,'INSERT','orders_tbl',2,'[]','{\"referenceNum\":\"NN7SlZq0t9G\",\"userID\":2,\"totalAmount\":\"14490.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-20 16:50:18'),(178,2,'INSERT','order_items_tbl',2,'[]','{\"orderID\":2,\"productID\":\"7\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":7495}','2025-03-20 16:50:18'),(179,2,'UPDATE','products_tbl',7,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":\"95\",\"prodSold\":\"5\"}','2025-03-20 16:50:18'),(180,2,'INSERT','order_items_tbl',2,'[]','{\"orderID\":2,\"productID\":\"6\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":6995}','2025-03-20 16:50:18'),(181,2,'UPDATE','products_tbl',6,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":\"95\",\"prodSold\":\"5\"}','2025-03-20 16:50:18'),(182,2,'DELETE','cart_items_tbl',1,'{\"statusID\":6}','[]','2025-03-20 16:50:18'),(183,2,'INSERT','cart_items_tbl',1,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-03-20 17:05:03'),(184,2,'INSERT','cart_items_tbl',2,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-20 17:05:07'),(185,2,'INSERT','cart_items_tbl',3,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-20 17:05:11'),(186,2,'INSERT','orders_tbl',1,NULL,'{\"referenceNum\":\"r7fgmG5f0Dv\",\"userID\":2,\"totalAmount\":\"11400.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-20 17:05:17'),(187,2,'INSERT','order_items_tbl',1,NULL,'{\"orderID\":1,\"productID\":\"4\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":11400}','2025-03-20 17:05:17'),(188,2,'UPDATE','products_tbl',4,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":95,\"prodSold\":5}','2025-03-20 17:05:17'),(189,2,'DELETE','cart_items_tbl',3,'{\"cartItemID\":\"3\",\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 00:05:11\",\"updatedAt\":\"2025-03-21 00:05:11\"}',NULL,'2025-03-20 17:05:17'),(190,2,'INSERT','orders_tbl',2,NULL,'{\"referenceNum\":\"BA68K64HCYG\",\"userID\":2,\"totalAmount\":\"28240.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-20 17:06:23'),(191,2,'INSERT','order_items_tbl',2,NULL,'{\"orderID\":2,\"productID\":\"1\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":10745}','2025-03-20 17:06:23'),(192,2,'UPDATE','products_tbl',1,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":95,\"prodSold\":5}','2025-03-20 17:06:23'),(193,2,'INSERT','order_items_tbl',3,NULL,'{\"orderID\":2,\"productID\":\"2\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":17495}','2025-03-20 17:06:23'),(194,2,'UPDATE','products_tbl',2,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":95,\"prodSold\":5}','2025-03-20 17:06:23'),(195,2,'DELETE','cart_items_tbl',2,'{\"cartItemID\":\"2\",\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 00:05:07\",\"updatedAt\":\"2025-03-21 00:05:07\"}',NULL,'2025-03-20 17:06:23'),(196,2,'INSERT','cart_items_tbl',4,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 17:08:52'),(197,2,'INSERT','cart_items_tbl',5,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-03-20 17:09:01'),(198,2,'INSERT','orders_tbl',3,NULL,'{\"referenceNum\":\"kcEr7HOLKRz\",\"userID\":2,\"totalAmount\":\"17240.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-20 17:09:14'),(199,2,'INSERT','order_items_tbl',4,NULL,'{\"orderID\":3,\"productID\":\"1\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":10745}','2025-03-20 17:09:14'),(200,2,'UPDATE','products_tbl',1,'{\"inStock\":\"95\",\"prodSold\":\"5\"}','{\"inStock\":90,\"prodSold\":10}','2025-03-20 17:09:14'),(201,2,'INSERT','order_items_tbl',5,NULL,'{\"orderID\":3,\"productID\":\"5\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":6495}','2025-03-20 17:09:14'),(202,2,'UPDATE','products_tbl',5,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":95,\"prodSold\":5}','2025-03-20 17:09:14'),(203,2,'DELETE','cart_items_tbl',1,'{\"cartItemID\":\"1\",\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 00:05:03\",\"updatedAt\":\"2025-03-21 00:05:03\"}',NULL,'2025-03-20 17:09:14'),(204,2,'DELETE','cart_items_tbl',4,'{\"cartItemID\":\"4\",\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 00:08:52\",\"updatedAt\":\"2025-03-21 00:08:52\"}',NULL,'2025-03-20 17:09:14'),(205,2,'DELETE','cart_items_tbl',5,'{\"cartItemID\":\"5\",\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 00:09:01\",\"updatedAt\":\"2025-03-21 00:09:01\"}',NULL,'2025-03-20 17:09:14'),(206,2,'INSERT','cart_items_tbl',1,NULL,'{\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-03-20 17:17:55'),(207,2,'INSERT','cart_items_tbl',2,NULL,'{\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-20 17:17:59'),(208,2,'INSERT','cart_items_tbl',3,NULL,'{\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-20 17:18:04'),(209,2,'INSERT','orders_tbl',1,NULL,'{\"referenceNum\":\"Gv52f1FMDcN\",\"userID\":2,\"totalAmount\":\"11400.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-20 17:18:12'),(210,2,'INSERT','order_items_tbl',1,NULL,'{\"orderID\":1,\"productID\":\"4\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":11400}','2025-03-20 17:18:12'),(211,2,'UPDATE','products_tbl',4,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":95,\"prodSold\":5}','2025-03-20 17:18:12'),(212,2,'DELETE','cart_items_tbl',3,'{\"cartItemID\":\"3\",\"cartID\":\"1\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 00:18:04\",\"updatedAt\":\"2025-03-21 00:18:04\"}',NULL,'2025-03-20 17:18:12'),(213,2,'INSERT','orders_tbl',2,NULL,'{\"referenceNum\":\"qHz5x1n5xtE\",\"userID\":2,\"totalAmount\":\"28240.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-20 17:18:44'),(214,2,'INSERT','order_items_tbl',2,NULL,'{\"orderID\":2,\"productID\":\"1\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":10745}','2025-03-20 17:18:44'),(215,2,'UPDATE','products_tbl',1,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":95,\"prodSold\":5}','2025-03-20 17:18:44'),(216,2,'INSERT','order_items_tbl',3,NULL,'{\"orderID\":2,\"productID\":\"2\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":17495}','2025-03-20 17:18:44'),(217,2,'UPDATE','products_tbl',2,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":95,\"prodSold\":5}','2025-03-20 17:18:44'),(218,2,'DELETE','cart_items_tbl',1,'{\"cartItemID\":\"1\",\"cartID\":\"1\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 00:17:55\",\"updatedAt\":\"2025-03-21 00:17:55\"}',NULL,'2025-03-20 17:18:44'),(219,2,'DELETE','cart_items_tbl',2,'{\"cartItemID\":\"2\",\"cartID\":\"1\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 00:17:59\",\"updatedAt\":\"2025-03-21 00:17:59\"}',NULL,'2025-03-20 17:18:44'),(220,2,'INSERT','cart_items_tbl',4,NULL,'{\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-20 17:20:58'),(221,2,'INSERT','orders_tbl',3,NULL,'{\"referenceNum\":\"IanjGRWFzBa\",\"userID\":2,\"totalAmount\":\"6495.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-20 17:21:04'),(222,2,'INSERT','order_items_tbl',4,NULL,'{\"orderID\":3,\"productID\":\"5\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":6495}','2025-03-20 17:21:04'),(223,2,'UPDATE','products_tbl',5,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":95,\"prodSold\":5}','2025-03-20 17:21:04'),(224,2,'DELETE','cart_items_tbl',4,'{\"cartItemID\":\"4\",\"cartID\":\"1\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 00:20:58\",\"updatedAt\":\"2025-03-21 00:20:58\"}',NULL,'2025-03-20 17:21:04'),(225,2,'INSERT','cart_items_tbl',5,NULL,'{\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-03-20 17:21:38'),(226,2,'INSERT','orders_tbl',4,NULL,'{\"referenceNum\":\"jx4liIuSN36\",\"userID\":2,\"totalAmount\":\"6995.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-20 17:21:47'),(227,2,'INSERT','order_items_tbl',5,NULL,'{\"orderID\":4,\"productID\":\"6\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":6995}','2025-03-20 17:21:47'),(228,2,'UPDATE','products_tbl',6,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":95,\"prodSold\":5}','2025-03-20 17:21:47'),(229,2,'DELETE','cart_items_tbl',5,'{\"cartItemID\":\"5\",\"cartID\":\"1\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 00:21:38\",\"updatedAt\":\"2025-03-21 00:21:38\"}',NULL,'2025-03-20 17:21:47'),(230,2,'INSERT','cart_items_tbl',6,NULL,'{\"cartID\":\"1\",\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495\"}','2025-03-20 17:24:04'),(231,2,'INSERT','orders_tbl',5,NULL,'{\"referenceNum\":\"v8fNRLujvSk\",\"userID\":2,\"totalAmount\":\"7495.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-20 17:24:10'),(232,2,'INSERT','order_items_tbl',6,NULL,'{\"orderID\":5,\"productID\":\"7\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":7495}','2025-03-20 17:24:10'),(233,2,'UPDATE','products_tbl',7,'{\"inStock\":\"100\",\"prodSold\":\"0\"}','{\"inStock\":95,\"prodSold\":5}','2025-03-20 17:24:10'),(234,2,'DELETE','cart_items_tbl',6,'{\"cartItemID\":\"6\",\"cartID\":\"1\",\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 00:24:04\",\"updatedAt\":\"2025-03-21 00:24:04\"}',NULL,'2025-03-20 17:24:10'),(235,8,'LOGIN','users_tbl',8,NULL,'{\"status\":\"success\"}','2025-03-20 18:49:28'),(236,8,'LOGOUT','users_tbl',8,NULL,'{\"status\":\"logged out\"}','2025-03-20 18:53:27'),(237,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-20 18:56:10'),(238,2,'LOGIN','users_tbl',2,NULL,'{\"status\":\"success\"}','2025-03-20 18:56:27'),(239,2,'DELETE','users_tbl',7,'{\"userFname\":\"Admin\",\"userLname\":\"User\",\"userAdd\":\"AdminCity\",\"userPhone\":\"12345678910\",\"userEmail\":\"admin@example.com\"}',NULL,'2025-03-20 19:06:34'),(240,2,'DELETE','users_tbl',8,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\"}',NULL,'2025-03-20 19:06:44'),(241,2,'LOGOUT','users_tbl',2,NULL,'{\"status\":\"logged out\"}','2025-03-20 19:07:17'),(242,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-20 19:07:20'),(243,1,'DELETE','users_tbl',9,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\"}',NULL,'2025-03-20 19:15:17'),(244,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-20 19:46:19'),(245,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-20 19:46:46'),(246,1,'DELETE','users_tbl',10,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\"}',NULL,'2025-03-20 19:46:49'),(247,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-20 19:48:19'),(248,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-20 19:48:21'),(249,1,'DELETE','users_tbl',11,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\"}',NULL,'2025-03-20 19:48:25'),(250,1,'DELETE','users_tbl',12,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\"}',NULL,'2025-03-20 19:53:58'),(251,1,'DELETE','users_tbl',13,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\"}',NULL,'2025-03-20 19:54:55'),(252,1,'DELETE','users_tbl',15,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\"}',NULL,'2025-03-20 19:58:59'),(253,1,'DELETE','users_tbl',16,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\"}',NULL,'2025-03-20 19:59:44'),(254,1,'DELETE','users_tbl',17,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\"}',NULL,'2025-03-20 20:00:26'),(255,1,'DELETE','users_tbl',18,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\"}',NULL,'2025-03-20 20:08:01'),(256,21,'LOGIN','users_tbl',21,NULL,'{\"status\":\"success\"}','2025-03-20 20:37:56'),(257,21,'LOGOUT','users_tbl',21,NULL,'{\"status\":\"logged out\"}','2025-03-20 20:39:14'),(258,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-20 20:39:15'),(259,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-20 20:39:53'),(260,1,'CREATE','users_tbl',22,NULL,'{\"userFname\":\"Admin\",\"userLname\":\"User\",\"userAdd\":\"AdminCity\",\"userPhone\":\"12345678910\",\"userEmail\":\"admin@example.com\",\"roleID\":2,\"otp\":0,\"status\":\"Verified\"}','2025-03-20 20:41:01'),(261,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-20 20:41:04'),(262,22,'LOGIN','users_tbl',22,NULL,'{\"status\":\"success\"}','2025-03-20 20:41:10'),(263,22,'DELETE','users_tbl',21,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"9562898062\",\"userEmail\":\"mertiscool031@gmail.com\"}',NULL,'2025-03-20 20:46:35'),(264,22,'DELETE','users_tbl',22,'{\"userFname\":\"Admin\",\"userLname\":\"User\",\"userAdd\":\"AdminCity\",\"userPhone\":\"12345678910\",\"userEmail\":\"admin@example.com\"}',NULL,'2025-03-20 20:46:42'),(265,22,'LOGOUT','users_tbl',22,NULL,'{\"status\":\"logged out\"}','2025-03-20 20:46:47'),(266,24,'CREATE','users_tbl',24,NULL,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\",\"roleID\":1,\"otp\":441970,\"status\":\"Unverified\",\"createdAt\":\"2025-03-20 21:03:44\",\"updatedAt\":\"2025-03-20 21:03:44\"}','2025-03-20 21:03:44'),(267,24,'CREATE','carts_tbl',2,NULL,'{\"cartID\":2,\"userID\":24}','2025-03-20 21:03:44'),(268,25,'CREATE','users_tbl',25,NULL,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"Manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\",\"roleID\":1,\"otp\":707663,\"status\":\"Unverified\",\"createdAt\":\"2025-03-20 21:05:02\",\"updatedAt\":\"2025-03-20 21:05:02\"}','2025-03-20 21:05:02'),(269,25,'CREATE','carts_tbl',2,NULL,'{\"cartID\":2,\"userID\":25}','2025-03-20 21:05:02'),(270,25,'LOGIN','users_tbl',25,NULL,'{\"status\":\"success\"}','2025-03-20 21:05:34'),(271,25,'LOGOUT','users_tbl',25,NULL,'{\"status\":\"logged out\"}','2025-03-20 21:28:05'),(272,25,'LOGIN','users_tbl',25,'{\"email\":\"mertiscool031@gmail.com\"}','{\"status\":\"failed\"}','2025-03-20 21:28:16'),(273,25,'LOGIN','users_tbl',25,'{\"email\":\"mertiscool031@gmail.com\"}','{\"status\":\"failed\"}','2025-03-20 21:35:51'),(274,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-21 04:59:44'),(275,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-21 04:59:49'),(276,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-21 04:59:51'),(277,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-21 05:06:50'),(278,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-21 05:12:36'),(279,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-21 05:12:40'),(280,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-21 07:43:06'),(281,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-21 07:43:08'),(282,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-21 07:43:11'),(283,25,'LOGIN','users_tbl',25,NULL,'{\"status\":\"success\"}','2025-03-21 07:43:50'),(284,25,'LOGOUT','users_tbl',25,NULL,'{\"status\":\"logged out\"}','2025-03-21 07:43:56'),(285,25,'LOGIN','users_tbl',25,'{\"email\":\"mertiscool031@gmail.com\"}','{\"status\":\"failed\"}','2025-03-21 07:44:07'),(286,26,'CREATE','users_tbl',26,NULL,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\",\"roleID\":1,\"otp\":158573,\"status\":\"Unverified\",\"createdAt\":\"2025-03-21 07:44:36\",\"updatedAt\":\"2025-03-21 07:44:36\"}','2025-03-21 07:44:36'),(287,26,'CREATE','carts_tbl',3,NULL,'{\"cartID\":3,\"userID\":26}','2025-03-21 07:44:36'),(288,27,'CREATE','users_tbl',27,NULL,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\",\"roleID\":1,\"otp\":160395,\"status\":\"Unverified\",\"createdAt\":\"2025-03-21 07:46:08\",\"updatedAt\":\"2025-03-21 07:46:08\"}','2025-03-21 07:46:08'),(289,27,'CREATE','carts_tbl',4,NULL,'{\"cartID\":4,\"userID\":27}','2025-03-21 07:46:08'),(290,28,'CREATE','users_tbl',28,NULL,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\",\"roleID\":1,\"otp\":944509,\"status\":\"Unverified\",\"createdAt\":\"2025-03-21 07:46:33\",\"updatedAt\":\"2025-03-21 07:46:33\"}','2025-03-21 07:46:33'),(291,28,'CREATE','carts_tbl',5,NULL,'{\"cartID\":5,\"userID\":28}','2025-03-21 07:46:33'),(292,29,'CREATE','users_tbl',29,NULL,'{\"userFname\":\"Mert\",\"userLname\":\"Isip\",\"userAdd\":\"manila\",\"userPhone\":\"09562898062\",\"userEmail\":\"mertiscool031@gmail.com\",\"roleID\":1,\"otp\":636681,\"status\":\"Unverified\",\"createdAt\":\"2025-03-21 07:47:03\",\"updatedAt\":\"2025-03-21 07:47:03\"}','2025-03-21 07:47:03'),(293,29,'CREATE','carts_tbl',6,NULL,'{\"cartID\":6,\"userID\":29}','2025-03-21 07:47:03'),(294,29,'LOGIN','users_tbl',29,NULL,'{\"status\":\"success\"}','2025-03-21 07:47:32'),(295,29,'INSERT','cart_items_tbl',7,NULL,'{\"cartID\":\"6\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-03-21 07:47:58'),(296,29,'INSERT','cart_items_tbl',8,NULL,'{\"cartID\":\"6\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-21 07:48:06'),(297,29,'INSERT','cart_items_tbl',9,NULL,'{\"cartID\":\"6\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-21 07:48:13'),(298,29,'INSERT','orders_tbl',6,NULL,'{\"referenceNum\":\"UHgG6qKej8m\",\"userID\":29,\"totalAmount\":\"11400.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-21 07:48:26'),(299,29,'INSERT','order_items_tbl',7,NULL,'{\"orderID\":6,\"productID\":\"4\",\"orderItemQuantity\":\"5\",\"orderItemTotal\":11400}','2025-03-21 07:48:26'),(300,29,'UPDATE','products_tbl',4,'{\"inStock\":\"95\",\"prodSold\":\"5\"}','{\"inStock\":90,\"prodSold\":10}','2025-03-21 07:48:26'),(301,29,'DELETE','cart_items_tbl',9,'{\"cartItemID\":\"9\",\"cartID\":\"6\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400.00\",\"statusID\":\"6\",\"createdAt\":\"2025-03-21 14:48:13\",\"updatedAt\":\"2025-03-21 14:48:13\"}',NULL,'2025-03-21 07:48:26'),(302,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-21 07:49:07'),(303,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-21 07:57:05'),(304,29,'LOGIN','users_tbl',29,NULL,'{\"status\":\"success\"}','2025-03-21 07:57:13'),(305,29,'INSERT','orders_tbl',7,NULL,'{\"referenceNum\":\"9sZpoq407Yg\",\"userID\":29,\"totalAmount\":\"28240.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-21 07:57:26'),(306,29,'INSERT','cart_items_tbl',10,NULL,'{\"cartID\":\"6\",\"productID\":\"7\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"7495\"}','2025-03-21 08:02:37'),(307,29,'INSERT','cart_items_tbl',11,NULL,'{\"cartID\":\"6\",\"productID\":\"6\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6995\"}','2025-03-21 08:02:44'),(308,29,'INSERT','cart_items_tbl',12,NULL,'{\"cartID\":\"6\",\"productID\":\"5\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"6495\"}','2025-03-21 08:02:51'),(309,29,'INSERT','orders_tbl',8,NULL,'{\"referenceNum\":\"yDKWi5EJaBz\",\"userID\":29,\"totalAmount\":\"20985.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-21 08:02:59'),(310,29,'LOGIN','users_tbl',29,NULL,'{\"status\":\"success\"}','2025-03-21 09:37:22'),(311,29,'LOGOUT','users_tbl',29,NULL,'{\"status\":\"logged out\"}','2025-03-21 10:29:57'),(312,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-21 10:30:30'),(313,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-21 10:30:32'),(314,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-21 10:30:33'),(315,29,'LOGIN','users_tbl',29,NULL,'{\"status\":\"success\"}','2025-03-21 10:30:45'),(316,29,'INSERT','cart_items_tbl',13,NULL,'{\"cartID\":\"6\",\"productID\":\"1\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"10745\"}','2025-03-21 11:04:37'),(317,29,'INSERT','cart_items_tbl',14,NULL,'{\"cartID\":\"6\",\"productID\":\"2\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"17495\"}','2025-03-21 11:04:47'),(318,29,'INSERT','cart_items_tbl',15,NULL,'{\"cartID\":\"6\",\"productID\":\"4\",\"cartItemQuantity\":\"5\",\"cartItemTotal\":\"11400\"}','2025-03-21 11:05:00'),(319,29,'INSERT','orders_tbl',9,NULL,'{\"referenceNum\":\"LUtugIb71SI\",\"userID\":29,\"totalAmount\":\"39640.00\",\"mopID\":\"1\",\"statusID\":1}','2025-03-21 11:05:27'),(320,29,'LOGIN','users_tbl',29,NULL,'{\"status\":\"success\"}','2025-03-21 11:55:04'),(321,29,'LOGOUT','users_tbl',29,NULL,'{\"status\":\"logged out\"}','2025-03-21 11:56:57'),(322,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-21 11:57:18'),(323,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-21 11:57:20'),(324,29,'LOGIN','users_tbl',29,NULL,'{\"status\":\"success\"}','2025-03-21 11:57:30'),(325,29,'LOGOUT','users_tbl',29,NULL,'{\"status\":\"logged out\"}','2025-03-21 12:00:15'),(326,29,'LOGIN','users_tbl',29,NULL,'{\"status\":\"success\"}','2025-03-21 12:00:23'),(327,29,'LOGOUT','users_tbl',29,NULL,'{\"status\":\"logged out\"}','2025-03-21 12:01:35'),(328,29,'LOGIN','users_tbl',29,NULL,'{\"status\":\"success\"}','2025-03-21 12:12:22'),(329,29,'LOGOUT','users_tbl',29,NULL,'{\"status\":\"logged out\"}','2025-03-21 12:14:40'),(330,29,'LOGIN','users_tbl',29,NULL,'{\"status\":\"success\"}','2025-03-21 12:14:51'),(331,29,'LOGOUT','users_tbl',29,NULL,'{\"status\":\"logged out\"}','2025-03-21 12:25:06'),(332,1,'LOGIN','users_tbl',1,'{\"email\":\"mertalexis.isip.cics@ust.edu.ph\"}','{\"status\":\"failed\"}','2025-03-21 12:25:08'),(333,1,'LOGIN','users_tbl',1,NULL,'{\"status\":\"success\"}','2025-03-21 12:25:15'),(334,1,'LOGOUT','users_tbl',1,NULL,'{\"status\":\"logged out\"}','2025-03-21 12:25:17'),(335,29,'LOGIN','users_tbl',29,NULL,'{\"status\":\"success\"}','2025-03-21 12:25:28');
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
  KEY `cartItemStatusFK` (`statusID`),
  KEY `cartItemCartFK` (`cartID`),
  KEY `cartItemProductFK` (`productID`),
  CONSTRAINT `cartItemCartFK` FOREIGN KEY (`cartID`) REFERENCES `carts_tbl` (`cartID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cartItemProductFK` FOREIGN KEY (`productID`) REFERENCES `products_tbl` (`productID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cartItemStatusFK` FOREIGN KEY (`statusID`) REFERENCES `statuses_tbl` (`statusID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts_tbl`
--

LOCK TABLES `carts_tbl` WRITE;
/*!40000 ALTER TABLE `carts_tbl` DISABLE KEYS */;
INSERT INTO `carts_tbl` VALUES (1,2,'2025-03-16 14:25:52','2025-03-16 14:25:52'),(2,NULL,'2025-03-21 04:05:02','2025-03-21 04:05:02'),(3,NULL,'2025-03-21 14:44:36','2025-03-21 14:44:36'),(4,NULL,'2025-03-21 14:46:08','2025-03-21 14:46:08'),(5,NULL,'2025-03-21 14:46:33','2025-03-21 14:46:33'),(6,29,'2025-03-21 14:47:03','2025-03-21 14:47:03');
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
  `userID` int(11) DEFAULT 0,
  `notifName` varchar(50) NOT NULL,
  `notifMessage` text NOT NULL,
  `statusID` int(11) DEFAULT 9,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`notifID`),
  KEY `notifStatusFK` (`statusID`),
  KEY `notifUserFK` (`userID`),
  CONSTRAINT `notifStatusFK` FOREIGN KEY (`statusID`) REFERENCES `statuses_tbl` (`statusID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `notifUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifs_tbl`
--

LOCK TABLES `notifs_tbl` WRITE;
/*!40000 ALTER TABLE `notifs_tbl` DISABLE KEYS */;
INSERT INTO `notifs_tbl` VALUES (1,29,'Order Placed','Your order #9sZpoq407Yg has been successfully placed.',9,'2025-03-21 14:57:26','2025-03-21 14:57:26'),(2,29,'Order Placed','Your order #yDKWi5EJaBz has been successfully placed.',9,'2025-03-21 15:02:59','2025-03-21 15:02:59'),(3,29,'Order Placed','Your order #LUtugIb71SI has been successfully placed.',9,'2025-03-21 18:05:27','2025-03-21 18:05:27');
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
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`orderItemID`),
  KEY `orderItemOrderFK` (`orderID`),
  KEY `orderItemProductFK` (`productID`),
  CONSTRAINT `orderItemOrderFK` FOREIGN KEY (`orderID`) REFERENCES `orders_tbl` (`orderID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `orderItemProductFK` FOREIGN KEY (`productID`) REFERENCES `products_tbl` (`productID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items_tbl`
--

LOCK TABLES `order_items_tbl` WRITE;
/*!40000 ALTER TABLE `order_items_tbl` DISABLE KEYS */;
INSERT INTO `order_items_tbl` VALUES (1,1,4,5,11400.00,'2025-03-21 00:18:12'),(2,2,1,5,10745.00,'2025-03-21 00:18:44'),(3,2,2,5,17495.00,'2025-03-21 00:18:44'),(4,3,5,5,6495.00,'2025-03-21 00:21:04'),(5,4,6,5,6995.00,'2025-03-21 00:21:47'),(6,5,7,5,7495.00,'2025-03-21 00:24:10'),(7,6,4,5,11400.00,'2025-03-21 14:48:26'),(8,7,1,5,10745.00,'2025-03-21 14:57:26'),(9,7,2,5,17495.00,'2025-03-21 14:57:26'),(10,8,7,5,7495.00,'2025-03-21 15:02:59'),(11,8,6,5,6995.00,'2025-03-21 15:02:59'),(12,8,5,5,6495.00,'2025-03-21 15:02:59'),(13,9,1,5,10745.00,'2025-03-21 18:05:27'),(14,9,2,5,17495.00,'2025-03-21 18:05:27'),(15,9,4,5,11400.00,'2025-03-21 18:05:27');
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
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`orderID`) USING BTREE,
  KEY `orderUserFK` (`userID`),
  KEY `orderMopFK` (`mopID`),
  KEY `orderStatusFK` (`statusID`),
  CONSTRAINT `orderMopFK` FOREIGN KEY (`mopID`) REFERENCES `modes_of_payment_tbl` (`mopID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `orderStatusFK` FOREIGN KEY (`statusID`) REFERENCES `statuses_tbl` (`statusID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `orderUserFK` FOREIGN KEY (`userID`) REFERENCES `users_tbl` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_tbl`
--

LOCK TABLES `orders_tbl` WRITE;
/*!40000 ALTER TABLE `orders_tbl` DISABLE KEYS */;
INSERT INTO `orders_tbl` VALUES (1,'Gv52f1FMDcN',2,11400.00,1,1,'2025-03-21 00:18:12','2025-03-21 00:18:12'),(2,'qHz5x1n5xtE',2,28240.00,1,1,'2025-03-21 00:18:44','2025-03-21 00:18:44'),(3,'IanjGRWFzBa',2,6495.00,1,1,'2025-03-21 00:21:04','2025-03-21 00:21:04'),(4,'jx4liIuSN36',2,6995.00,1,1,'2025-03-21 00:21:47','2025-03-21 00:21:47'),(5,'v8fNRLujvSk',2,7495.00,1,1,'2025-03-21 00:24:10','2025-03-21 00:24:10'),(6,'UHgG6qKej8m',29,11400.00,1,1,'2025-03-21 14:48:26','2025-03-21 14:48:26'),(7,'9sZpoq407Yg',29,28240.00,1,1,'2025-03-21 14:57:26','2025-03-21 14:57:26'),(8,'yDKWi5EJaBz',29,20985.00,1,1,'2025-03-21 15:02:59','2025-03-21 15:02:59'),(9,'LUtugIb71SI',29,39640.00,1,1,'2025-03-21 18:05:27','2025-03-21 18:05:27');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_tbl`
--

LOCK TABLES `products_tbl` WRITE;
/*!40000 ALTER TABLE `products_tbl` DISABLE KEYS */;
INSERT INTO `products_tbl` VALUES (1,1,'Dry Chemical Fire Extinguisher','../images/products/fire-ex_dry-chem.jpg',1,'A dry chemical fire extinguisher is a versatile and widely used firefighting device designed to combat various types of fires. It contains a dry chemical powder, such as monoammonium phosphate, which quickly extinguishes flames by interrupting the chemical reaction of the fire. These extinguishers are effective against Class A (ordinary combustibles), Class B (flammable liquids), and Class C (electrical) fires, making them essential for homes, offices, and industrial settings.',2149.00,85,15,'2025-03-07 10:56:42','2025-03-20 16:14:11'),(2,1,'HCFC-123 Fire Extinguisher','../images/products/fire-ex_HCFC-123.jpg',1,'The HCFC-123 fire extinguisher utilizes a clean agent called hydrochlorofluorocarbon-123 (HCFC-123) to suppress fires. It is highly effective for use in areas with sensitive electronic equipment, as it leaves no residue and causes minimal damage. This extinguisher is suitable for Class A, B, and C fires, making it an ideal choice for data centers, laboratories, and telecommunications facilities.',3499.00,85,15,'2025-03-07 10:58:51','2025-03-20 16:14:16'),(4,1,'AFFF Fire Extinguisher','../images/products/fire-ex_AFFF.jpg',1,'An Aqueous Film Forming Foam (AFFF) fire extinguisher is designed to combat flammable liquid fires by creating a smothering foam blanket over the burning liquid. It is highly effective for use on Class B fires, which involve flammable liquids such as gasoline, oil, and solvents. AFFF extinguishers are commonly used in airports, industrial facilities, and fuel storage areas to provide quick and efficient fire suppression.',2280.00,85,15,'2025-03-07 11:11:22','2025-03-20 16:14:20'),(5,1,'AH-0715 Smoke Detector','../images/products/smoke-detect_AH-0715.jpeg',2,'The AH-0715 smoke detector is a combination smoke and heat detector designed for reliable fire detection. It features a twin-color LED display for easy status identification and is made of fire-proof plastic for durability. This detector is suitable for various applications, including residential and commercial buildings, and is available in 2-wire, 3-wire, and 4-wire configurations.',1299.00,90,10,'2025-03-07 11:13:26','2025-03-20 16:14:24'),(6,1,'AH-9920 Smoke Detector','../images/products/smoke-detect_AH-9920.jpeg',2,'The AH-9920 smoke detector is a mechanical fixed-temperature heat detector designed to operate on the temperature differential sensing principle. It features a UL-approved sensor and is made of high-quality, fire-proof plastic, ensuring durability and reliability even in challenging environments. This detector is suitable for locations with high temperature differentials, such as kitchens, restaurants, and boiler houses.',1399.00,90,10,'2025-03-07 11:13:54','2025-03-20 16:14:28'),(7,1,'AQ05 Smoke Detector','../images/products/smoke-detect_QA05.jpeg',2,'The QA05 smoke detector is an addressable combination smoke and heat detector designed for reliable fire detection. It features address coding by dip switch, a latching function for clear alarm identification, and a magnetic test feature for easy maintenance. Made of high endurance, fire-proof plastic, it also includes dual LEDs for 360-degree visibility and has passed strict EMC tests to minimize false alarms.',1499.00,90,10,'2025-03-07 11:17:06','2025-03-20 16:14:33');
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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_tbl`
--

LOCK TABLES `users_tbl` WRITE;
/*!40000 ALTER TABLE `users_tbl` DISABLE KEYS */;
INSERT INTO `users_tbl` VALUES (1,'Mert','Isip','Manila','09562898062','mertalexis.isip.cics@ust.edu.ph','$2y$10$ROaSDaPeOe5K0FpQhmtziOdjzsd7kgMUoLhYmMcKhEpVy6OBRCOHa',2,0,'Verified',0,NULL,'2025-03-11 13:05:02','2025-03-11 13:05:02'),(2,'Mert','Isip','Manila','09562898062','mertisepic031@gmail.com','0f05ad7e167ac3a8484979dd35913e90',1,0,'Verified',0,NULL,'2025-03-11 13:05:21','2025-03-17 13:17:14'),(3,'Ken','Gopez','Valenzuela','12345678910','kristoffer.gopez.cics@ust.edu.ph','86f686503ff41169c870faf4be188517',2,0,'Verified',0,NULL,'2025-03-16 10:39:02','2025-03-16 10:39:02'),(4,'Cyril','Labao','Bacoor','12345678910','cyrillabao@gmail.com','86f686503ff41169c870faf4be188517',2,0,'Verified',0,NULL,'2025-03-16 10:39:43','2025-03-16 10:39:43'),(29,'Mert','Isip','manila','9562898062','mertiscool031@gmail.com','$2y$10$M0pkFuYAug/U2ZB.GOK08eTFS7WtvHFQZ8KW0sE4R5DboJM6KxRaK',1,636681,'Verified',0,NULL,'2025-03-21 07:47:03','2025-03-21 07:47:03');
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

-- Dump completed on 2025-03-21 21:43:32
