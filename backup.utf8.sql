mysqldump: [Warning] Using a password on the command line interface can be insecure.
-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: app
-- ------------------------------------------------------
-- Server version	8.0.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
mysqldump: Error: 'Access denied; you need (at least one of) the PROCESS privilege(s) for this operation' when trying to dump tablespaces

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  KEY `invoice_items_product_id_foreign` (`product_id`),
  CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoice_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_items`
--

LOCK TABLES `invoice_items` WRITE;
/*!40000 ALTER TABLE `invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_15_041012_create_invoices_table',1),(5,'2026_05_15_041012_create_products_table',1),(6,'2026_05_15_041013_create_invoice_items_table',1),(7,'2026_05_15_153224_add_category_and_size_to_products_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (4,'csc moy1kg','Couscous','1kg',14.98,'products/BDNwX7yxgnZPFdrSoOtV3E6haABqJQW2XVkvuvI1.jpg','2026-05-16 22:09:09','2026-05-18 21:27:04'),(5,'Finot5kg','Semoule','5kg',44.00,'products/P93QzTJGkk6tgHjcLCV4RlIuLrLDf5tUPVqHswo1.png','2026-05-16 22:19:27','2026-05-18 23:37:11'),(6,'csc moy5kg','Couscous','5kg',21.85,'products/pFmX8a3L0vgREBxrb9idQMAqf4nOhwAjOlQVwDk1.jpg','2026-05-16 22:34:20','2026-05-18 21:26:39'),(7,'csc fine1kg','Couscous','1kg',15.00,'products/uwHZHaMBkHb4yKLJbsZIGKqof7IFa9zYyUODCsn3.jpg','2026-05-16 22:36:59','2026-05-18 21:24:39'),(8,'csc fine5kg','Couscous','5kg',22.00,'products/JdacOZ0VJwVrPyDNzJLygLHgphoQwIC3euRAsvIo.jpg','2026-05-16 22:40:27','2026-05-18 21:24:56'),(9,'csc fine10kg','Couscous','10kg',22.00,'products/2grAC5oljtr4zOiLK14rfy4xMjhBYxnX1JjrYehS.jpg','2026-05-16 22:43:22','2026-05-18 21:25:11'),(10,'csc moy10kg','Couscous','10kg',22.00,'products/eDGZ0OTWdo1I7kkXRsyrk65kQ6qSxuDWlTiCs7R6.jpg','2026-05-16 22:44:58','2026-05-18 21:25:29'),(11,'csc complet1kg','Couscous','1kg',50.00,'products/OEmdoN2XuXLlObHnfNwrnN6aAqKlThnDHaswca9Z.png','2026-05-16 22:49:18','2026-05-18 21:23:27'),(12,'Fleur1kg','Farine','1kg',21.84,'products/dhZNWQWJa35Ao6sVvTdEWllpOgtgo5JXRhHxdY3B.png','2026-05-16 22:54:27','2026-05-17 22:46:51'),(13,'Finot1kg','Semoule','1kg',21.91,'products/Y37e7LmveazrrCXWc5LwSoB2qFHsz7S72h7ci0cZ.png','2026-05-16 22:57:15','2026-05-18 23:36:55'),(14,'csc fine1/2','Couscous','500g',22.00,'products/9SXu45baxet80qRvdcgqW3UZ62xUViGRfuBCDOKK.png','2026-05-16 23:04:56','2026-05-18 21:23:42'),(15,'csc moy1/2','Couscous','500g',21.83,'products/EKcwfgwjW40387lOdprjZ1kCr3SIIzZL2UZX7wSp.png','2026-05-16 23:06:36','2026-05-18 21:25:56'),(16,'seml gros1kg','Semoule','1kg',1.00,'products/alSjRqQuIobe9KZP8qnKzLizjxKAyoONviLGecxj.png','2026-05-16 23:12:13','2026-05-18 23:38:46'),(17,'ch_d\'ang500g','Cheveux d\'Ange','500g',0.98,'products/0HonElSDer6kNwMbWNWxjYP1WE56ExmpCen8z9jK.jpg','2026-05-17 03:59:24','2026-05-18 23:35:49'),(18,'ch_d\'ang1kg','Cheveux d\'Ange','1kg',22.00,'products/kqA11jCmbMdbR9JPRzpaQcOZnrfxklnHPEtmAKBL.png','2026-05-17 04:00:05','2026-05-18 23:35:30'),(19,'ch_d\'ang5kg','Cheveux d\'Ange','5kg',22.00,'products/VXY0njJN9lUpgxWh4e2G27j40JjvaySpEKHUtT4L.jpg','2026-05-17 04:00:25','2026-05-18 23:34:51'),(20,'ch_d\'ang10kg','Cheveux d\'Ange','10kg',22.00,'products/m9VrF4YeSPa4lLjFRFX3k0IuVtdJGP6c2HjDYose.jpg','2026-05-17 04:00:43','2026-05-18 23:34:18'),(21,'Fleur5kg','Farine','5kg',21.86,'products/1x7FT7RwQGcCmOCwJUqPL2Sq0Z168wkUVWTlujV3.jpg','2026-05-17 04:01:30','2026-05-17 22:46:16'),(22,'Fleur10kg','Farine','10kg',22.00,'products/NQVHybG5dR5O8SsZHmpCo6q21VhZvGUQmAxsVWBL.jpg','2026-05-17 04:01:48','2026-05-17 22:58:38'),(23,'Fleur25kg','Farine','25kg',1.00,'products/y3P0ukPQLvvwkLijUdMuwrYWG13oL4PLjmdQ8ncj.jpg','2026-05-17 04:02:10','2026-05-17 22:59:03'),(24,'Finot10kg','Semoule','10kg',1.00,'products/sq9dRbqELsTXJaMjIlVcbdKjmd1XUVT7guKDURx4.jpg','2026-05-17 04:03:05','2026-05-18 23:36:40'),(25,'seml fine1kg','Semoule','1kg',1.00,'products/EmHMRrHrMkxRh6MdvtFEPtkwHZrVfsoHPw3sFKiU.png','2026-05-17 04:04:21','2026-05-18 23:38:07'),(26,'seml gros10kg','Semoule','10kg',1.00,'products/Rih7ehtf1tIDNYD8vP8VSAN9BWZZ635dQGtEhI4g.jpg','2026-05-17 04:04:50','2026-05-18 23:38:23'),(27,'seml fine5kg','Semoule','5kg',1.00,'products/EpC8f87IUAsoRH10GUlfvtuWApxRPtlafx07O1Kk.png','2026-05-17 04:05:49','2026-05-18 23:37:52'),(28,'seml fine10kg','Semoule','10kg',0.97,'products/9Iwctutrmzf47AjIURHEmj5HrL5dBTEufedRqr8i.jpg','2026-05-17 04:06:06','2026-05-18 23:37:37'),(29,'torsade','P├ótes vrac','10kg',1.00,NULL,'2026-05-17 04:07:38','2026-05-17 04:07:38'),(30,'penne','P├ótes vrac','10kg',1.00,NULL,'2026-05-17 04:08:05','2026-05-17 04:08:05'),(31,'langue d\'oiseau','P├ótes vrac','5kg',0.99,NULL,'2026-05-17 04:08:28','2026-05-17 04:17:25'),(32,'etoiles','P├ótes vrac','5kg',1.00,NULL,'2026-05-17 04:16:49','2026-05-17 04:16:49'),(33,'petit plomb','P├ótes vrac','10kg',1.00,NULL,'2026-05-17 04:18:11','2026-05-17 04:18:11'),(34,'verm moy','P├ótes vrac','10kg',1.00,NULL,'2026-05-17 04:18:31','2026-05-17 04:18:31'),(35,'verm fine','P├ótes vrac','10kg',1.00,NULL,'2026-05-17 04:19:43','2026-05-17 04:19:43'),(36,'verm gros','P├ótes vrac','10kg',1.00,NULL,'2026-05-17 04:20:01','2026-05-17 04:20:01'),(37,'code','P├ótes vrac','10kg',1.00,NULL,'2026-05-17 04:20:19','2026-05-17 04:20:19'),(38,'code rayes','P├ótes vrac','10kg',1.00,NULL,'2026-05-17 04:20:41','2026-05-17 04:20:41'),(39,'coquilles','P├ótes vrac','10kg',1.00,NULL,'2026-05-17 04:20:56','2026-05-17 04:20:56'),(40,'Fleur 2kg','Farine','2kg',0.01,'products/KcY22XniOtQYCLF7XLXYxxDnrtrZc0eIwnFB3Qpd.jpg','2026-05-17 22:44:06','2026-05-18 00:05:44'),(41,'torsade500g','P├ótes ptc','500g',9.00,'products/j6toRSk0WDP4tHAyfZ6ZkgtoindtUTrqBFfGuWU6.jpg','2026-05-18 00:20:00','2026-05-18 23:41:18'),(42,'pennes500g','P├ótes ptc','500g',3.00,'products/DyZC9Bhag5VNny6ZhwYzoN3EqjQ1KFOH5tpI85vr.jpg','2026-05-18 00:20:50','2026-05-18 23:42:20'),(43,'langue d\'oiseau','P├ótes ptc','500g',2.99,NULL,'2026-05-18 00:21:52','2026-05-18 00:21:52'),(44,'etoiles','P├ótes ptc','500g',3.00,NULL,'2026-05-18 00:22:10','2026-05-18 00:22:10'),(45,'petit plomb','P├ótes ptc','500g',3.00,NULL,'2026-05-18 00:22:49','2026-05-18 00:22:49'),(46,'verm moy','P├ótes ptc','500g',3.00,NULL,'2026-05-18 00:23:05','2026-05-18 00:23:05'),(47,'verm fine','P├ótes ptc','500g',3.00,NULL,'2026-05-18 00:23:25','2026-05-18 00:23:25'),(48,'verm gros','P├ótes ptc','500g',3.00,NULL,'2026-05-18 00:23:41','2026-05-18 00:23:41'),(49,'codes','P├ótes ptc','500g',3.00,NULL,'2026-05-18 00:24:17','2026-05-18 00:24:17'),(50,'code rayes','P├ótes ptc','500g',3.00,NULL,'2026-05-18 00:24:37','2026-05-18 00:24:37'),(51,'coquilles','P├ótes ptc','500g',3.00,NULL,'2026-05-18 00:24:54','2026-05-18 00:24:54'),(52,'spaghettis','P├ótes ptc','500g',2.90,'products/l5rUh2cfM4yzoTfXZrOe9FQPYwJHqB6aJbQzIV8J.jpg','2026-05-18 00:25:23','2026-05-18 23:29:39'),(53,'spaghettis','P├ótes ptc','250g',3.00,'products/vzrjLvy4mVLtbMs4fJXc4Na0cWiQbwcxUguXwIFT.jpg','2026-05-18 00:25:40','2026-05-18 23:30:16'),(54,'annelini500g','P├ótes ptc','500g',3.00,'products/bEL8Gb2lX14geMyBc5DlGMkICfuTO00MGIFJF714.jpg','2026-05-18 00:25:58','2026-05-18 23:45:05'),(55,'farafallini','P├ótes ptc','500g',3.00,NULL,'2026-05-18 00:26:21','2026-05-18 00:26:21'),(56,'farfales','P├ótes ptc','500g',3.00,NULL,'2026-05-18 00:26:41','2026-05-18 00:26:41'),(57,'Finot2kg','Semoule','2kg',3.00,'products/B2sOIwgpAr6RUkG2QjxtW8ddyJqgqxJOATav51Ds.jpg','2026-05-18 00:29:09','2026-05-18 23:36:25'),(58,'complet2kg','Semoule','2kg',3.00,'products/t0TBs3t27HvzcrxdBQbkQ0JHhr1A1PpDaNsMzPEF.jpg','2026-05-18 00:29:37','2026-05-18 22:10:45'),(59,'complet5kg','Semoule','5kg',3.00,'products/4G1SEuR3jdEGaC0Qc2t0KeZmeBoDI0NN3qclZQPU.jpg','2026-05-18 00:29:53','2026-05-18 22:11:04'),(60,'complet10kg','Semoule','10kg',3.00,'products/gPzYOffrmfjNP8NtnHEqp2RQAfkFv21zYtKEYQgF.jpg','2026-05-18 00:30:09','2026-05-18 23:32:01'),(61,'csc aman fine 10kg','Amane','10kg',84.00,'products/DHrGbjA7ZfVV8hrQ4VD6t53m573AwYHIA2GDhKYS.jpg','2026-05-18 20:00:50','2026-05-18 22:14:26'),(62,'csc aman moy 10kg','Amane','10kg',84.00,'products/7mDF0TqtlzOyjifEC7X5Ir74tbrYjYIpwMQ5f6Pu.jpg','2026-05-18 20:03:11','2026-05-18 22:14:49'),(63,'csc balboula1kg','Couscous','1kg',2.00,'products/WJjlt9ehkgk3NbgDel4fKDns0lzsSRnaqRSKssWW.jpg','2026-05-18 21:37:52','2026-05-18 21:57:50'),(64,'pates aman 10kg','Amane','10kg',84.00,'products/nDN2SzuIuwmNnGU2s5ol7hvC7Zplldn1rUtaz9C8.jpg','2026-05-18 22:12:38','2026-05-18 22:12:38');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('Iy1CT6Ur68nS8FMjcEn5Z4hBdP2FNmNfCTdz5PAW',1,'105.74.67.194','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJFN0pKYzZ5SWQ2MVZMck5nOFB6VHFQSk8yVFR2OEtpV1VuUGtKaUxhIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9mYWN0dXJvLTZiM2E1NC53d3cuZG9ja2hvc3RpbmcuZGV2XC9wcm9kdWN0LWltYWdlc1wvcHJvZHVjdHNcL0Iyc09Jd2dwQXI2UlVrRzJRanh0VzhkZHlKcWdxeEpPQVRhdjUxRHMuanBnIiwicm91dGUiOiJnZW5lcmF0ZWQ6OnVOWXFxWEpsMmdSNElyUGgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=',1779145769),('M9NtFAJb5NeyoaDSO0aPjpZYdQEKQNpQkAsPhsHb',1,'105.76.178.16','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJOYUwzVEhFT01pUjdNd29mM2VwY3g1U2JhWnBHVWRUYVVCSmtDVEpJIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9mYWN0dXJvLTZiM2E1NC53d3cuZG9ja2hvc3RpbmcuZGV2XC9wcm9kdWN0LWltYWdlc1wvcHJvZHVjdHNcL2JFTDhHYjJsWDE0Z2VNeUJjNURsR01rSUNmdVRPMDBNR0lGSkY3MTQuanBnIiwicm91dGUiOiJnZW5lcmF0ZWQ6OnVOWXFxWEpsMmdSNElyUGgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=',1779147905);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Oumar','admin@facturo.com',NULL,'$2y$12$LderVgsVv8egeK9UMg1leOKjMH8PxISz1cGbt.oOh5GpVqyUwfwFq',NULL,'2026-05-16 20:51:23','2026-05-16 20:51:23');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-19  0:00:04
