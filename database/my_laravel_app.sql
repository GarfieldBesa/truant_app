-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: my_laravel_app
-- ------------------------------------------------------
-- Server version	8.0.43

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

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab','i:2;',1788758451),('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer','i:1788758451;',1788758451),('laravel-cache-livewire-rate-limiter:056fc329aaaa757d31db450f525da23fde4d1b36','i:1;',1788754864),('laravel-cache-livewire-rate-limiter:056fc329aaaa757d31db450f525da23fde4d1b36:timer','i:1788754864;',1788754864),('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6','i:1;',1788423366),('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer','i:1788423366;',1788423366),('truant-application-cache-livewire-rate-limiter:056fc329aaaa757d31db450f525da23fde4d1b36','i:1;',1788784853),('truant-application-cache-livewire-rate-limiter:056fc329aaaa757d31db450f525da23fde4d1b36:timer','i:1788784853;',1788784853);
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
  `expiration` int NOT NULL,
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
-- Table structure for table `cash_advances`
--

DROP TABLE IF EXISTS `cash_advances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cash_advances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `applied_timesheet_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cash_advances_employee_id_foreign` (`employee_id`),
  KEY `cash_advances_applied_timesheet_id_foreign` (`applied_timesheet_id`),
  CONSTRAINT `cash_advances_applied_timesheet_id_foreign` FOREIGN KEY (`applied_timesheet_id`) REFERENCES `timesheets` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cash_advances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_advances`
--

LOCK TABLES `cash_advances` WRITE;
/*!40000 ALTER TABLE `cash_advances` DISABLE KEYS */;
INSERT INTO `cash_advances` VALUES (1,1,1500.00,'Car repair','approved','2026-09-06 23:17:52',10,'2026-09-02 05:48:25','2026-09-06 23:17:52'),(2,2,800.00,'Medical expenses','approved','2026-09-02 06:03:25',19,'2026-09-02 05:48:25','2026-09-02 06:03:25'),(3,1,2500.00,'Emergency medical expense','pending',NULL,NULL,'2026-09-03 01:25:07','2026-09-03 01:25:07'),(4,1,2500.00,'Emergency medical expense','declined',NULL,NULL,'2026-09-03 01:25:48','2026-09-06 23:15:56'),(5,4,3000.00,'test','pending',NULL,NULL,'2026-09-03 01:28:42','2026-09-03 01:28:42');
/*!40000 ALTER TABLE `cash_advances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'employee',
  `roles` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `position_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_username_unique` (`username`),
  KEY `employees_position_id_foreign` (`position_id`),
  CONSTRAINT `employees_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Jane','Doe','123 Main St, Springfield','1990-05-15','1234567890','janedoe','$2y$12$cv7X8cZYSEJkCdWNHfAyge592Ro53oQLSBySl0VyWx7Puu8m4NpUa','timesheet_portal','[\"timesheet_portal\"]','2026-08-26 20:22:52','2026-09-03 02:19:29',1),(2,'Garfield','Besa','Baguio City','1992-08-27','09778393536','besaadmin@gmail.com','$2y$12$qyq6PJGtrrDB.Gc/DG5zZO5KYw6NDk5VeH6NKfw18cyhSrv9C/KBy','employee','[]','2026-08-26 23:25:43','2026-09-03 02:14:01',4),(3,'John','Smith','456 Oak Rd, Springfield','1985-08-20','9876543210','john','$2y$12$eQ5fhdBfJKiaiES4ASg5M.PpFidVTV0.pVg7Z.04AovgDAqvmBd7W','timesheet_portal','[\"timesheet_portal\"]','2026-08-26 23:51:06','2026-09-03 02:14:01',8),(4,'test','test','test','1992-09-07','23423423444','test','$2y$12$Tp7vt91GartZgDcoelNQjuj3PvSBot4MYGQI0BgXcXyv9MfQUD6xa','timesheet_portal','[\"timesheet_portal\"]','2026-09-03 01:09:41','2026-09-03 02:14:01',3);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_registration_forms`
--

DROP TABLE IF EXISTS `event_registration_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_registration_forms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_start_date` date DEFAULT NULL,
  `registration_end_date` date DEFAULT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT '1',
  `consent_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Consent & Data Privacy Agreement',
  `consent_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `consent_checkbox_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'I have read and agree to the consent and terms of registration.',
  `fields` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_registration_forms_event_id_unique` (`event_id`),
  CONSTRAINT `event_registration_forms_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_registration_forms`
--

LOCK TABLES `event_registration_forms` WRITE;
/*!40000 ALTER TABLE `event_registration_forms` DISABLE KEYS */;
INSERT INTO `event_registration_forms` VALUES (2,2,'Registration Form - InnovateTech Global Summit 2026','Please fill out the form below to register for InnovateTech Global Summit 2026.','events/form-banners/01M1X46D121KV12DB9QXJS2HRR.png','2026-09-07','2026-10-01',1,'Consent & Data Privacy Agreement','By submitting this registration, I hereby grant permission and voluntary consent to the organizers to collect, process, and retain my personal information for the purposes of event coordination, security, and updates.\n\nI confirm that all information provided is true, accurate, and complete to the best of my knowledge.','I have read, understood, and voluntarily agree to the consent and privacy policy.','[{\"type\": \"text\", \"label\": \"Last Name\", \"help_text\": \"Last Name\", \"is_required\": true, \"placeholder\": \"Enter your Last Name\"}, {\"type\": \"text\", \"label\": \"First Name\", \"help_text\": \"First name\", \"is_required\": true, \"placeholder\": \"Enter your First Name\"}, {\"type\": \"radio\", \"label\": \"Jersey Size\", \"options\": [\"XL\", \"L\", \"S\", \"XS\", \"XXXSSS\", \"XXXLL\"], \"help_text\": null, \"is_required\": true}, {\"type\": \"image_upload\", \"label\": \"Identification card\", \"help_text\": null, \"is_required\": true}]','2026-09-06 21:01:52','2026-09-06 22:25:45'),(3,3,'Registration - Executive Leadership & AI Strategy Forum 2026','Complete this form to reserve your registration pass for Executive Leadership & AI Strategy Forum 2026.','events/banners/banner_leadership.jpg','2026-09-02','2026-10-17',1,'Terms & Privacy Consent','By registering for this event, I agree to the terms of attendance, event guidelines, and data processing policies.\nI confirm all details provided are accurate.','I understand and agree to the event registration guidelines and privacy terms.','[{\"type\": \"text\", \"label\": \"Full Name\", \"is_required\": true, \"placeholder\": \"Enter your full name\"}, {\"type\": \"text\", \"label\": \"Job Title & Company\", \"is_required\": true, \"placeholder\": \"e.g. Chief Technology Officer, Acme Corp\"}, {\"type\": \"select\", \"label\": \"Executive Track\", \"options\": [\"AI Governance & Policy\", \"Enterprise Cloud & Data\", \"Strategic Leadership\"], \"is_required\": true}]','2026-09-07 00:23:52','2026-09-07 00:23:52'),(4,4,'Registration - Corporate Wellness Marathon & Sports Festival','Complete this form to reserve your registration pass for Corporate Wellness Marathon & Sports Festival.','events/banners/banner_sports.jpg','2026-09-05','2026-10-27',1,'Terms & Privacy Consent','By registering for this event, I agree to the terms of attendance, event guidelines, and data processing policies.\nI confirm all details provided are accurate.','I understand and agree to the event registration guidelines and privacy terms.','[{\"type\": \"text\", \"label\": \"Runner Name\", \"is_required\": true, \"placeholder\": \"Full name of participant\"}, {\"type\": \"radio\", \"label\": \"Race Category\", \"options\": [\"3K Fun Walk\", \"5K Speed Run\", \"10K Challenge Run\"], \"is_required\": true}, {\"type\": \"select\", \"label\": \"Singlet Size\", \"options\": [\"XS\", \"S\", \"M\", \"L\", \"XL\", \"2XL\"], \"is_required\": true}]','2026-09-07 00:23:52','2026-09-07 00:23:52'),(5,5,'Registration - Cloud Architecture & DevOps Masterclass','Complete this form to reserve your registration pass for Cloud Architecture & DevOps Masterclass.','events/banners/banner_tech.jpg','2026-09-06','2026-11-11',1,'Terms & Privacy Consent','By registering for this event, I agree to the terms of attendance, event guidelines, and data processing policies.\nI confirm all details provided are accurate.','I understand and agree to the event registration guidelines and privacy terms.','[{\"type\": \"text\", \"label\": \"Developer Name\", \"is_required\": true, \"placeholder\": \"Your full name\"}, {\"type\": \"text\", \"label\": \"GitHub Username\", \"is_required\": false, \"placeholder\": \"e.g. octocat\"}, {\"type\": \"radio\", \"label\": \"Experience Level\", \"options\": [\"Intermediate\", \"Advanced\", \"Staff / Principal\"], \"is_required\": true}]','2026-09-07 00:23:52','2026-09-07 00:23:52'),(6,6,'Registration - Annual Corporate Gala & Excellence Awards','Complete this form to reserve your registration pass for Annual Corporate Gala & Excellence Awards.','events/banners/banner_leadership.jpg','2026-09-27','2026-11-26',1,'Terms & Privacy Consent','By registering for this event, I agree to the terms of attendance, event guidelines, and data processing policies.\nI confirm all details provided are accurate.','I understand and agree to the event registration guidelines and privacy terms.','[{\"type\": \"text\", \"label\": \"Employee Name\", \"is_required\": true, \"placeholder\": \"Enter official name\"}, {\"type\": \"select\", \"label\": \"Department\", \"options\": [\"Engineering\", \"Finance\", \"Operations\", \"Human Resources\", \"Marketing\"], \"is_required\": true}, {\"type\": \"radio\", \"label\": \"Dietary Restrictions\", \"options\": [\"None (Standard Menu)\", \"Vegetarian\", \"Halal\", \"Gluten-Free\"], \"is_required\": true}]','2026-09-07 00:23:52','2026-09-07 00:23:52'),(7,7,'Registration - Fintech & Cybersecurity Summit 2026','Complete this form to reserve your registration pass for Fintech & Cybersecurity Summit 2026.','events/banners/banner_tech.jpg','2026-09-04','2026-11-16',1,'Terms & Privacy Consent','By registering for this event, I agree to the terms of attendance, event guidelines, and data processing policies.\nI confirm all details provided are accurate.','I understand and agree to the event registration guidelines and privacy terms.','[{\"type\": \"text\", \"label\": \"Attendee Name\", \"is_required\": true, \"placeholder\": \"Full name\"}, {\"type\": \"text\", \"label\": \"Organization / Bank\", \"is_required\": true, \"placeholder\": \"Institution name\"}, {\"type\": \"select\", \"label\": \"Primary Interest\", \"options\": [\"Zero Trust Architecture\", \"Payment Fraud Prevention\", \"Cloud Compliance\"], \"is_required\": true}]','2026-09-07 00:23:52','2026-09-07 00:23:52'),(8,8,'Registration - HR Leaders & People Culture Symposium','Complete this form to reserve your registration pass for HR Leaders & People Culture Symposium.','events/banners/banner_leadership.jpg','2026-09-03','2026-12-16',1,'Terms & Privacy Consent','By registering for this event, I agree to the terms of attendance, event guidelines, and data processing policies.\nI confirm all details provided are accurate.','I understand and agree to the event registration guidelines and privacy terms.','[{\"type\": \"text\", \"label\": \"Delegate Name\", \"is_required\": true, \"placeholder\": \"Full name\"}, {\"type\": \"text\", \"label\": \"Email Address\", \"is_required\": true, \"placeholder\": \"work.email@company.com\"}, {\"type\": \"select\", \"label\": \"Company Size\", \"options\": [\"1-50 employees\", \"51-200 employees\", \"201-1,000 employees\", \"1,000+ employees\"], \"is_required\": true}]','2026-09-07 00:23:52','2026-09-07 00:23:52'),(9,9,'Registration - Summer Hackathon & Rapid Prototyping Sprint','Complete this form to reserve your registration pass for Summer Hackathon & Rapid Prototyping Sprint.','events/banners/banner_sports.jpg','2026-07-29','2026-08-08',0,'Terms & Privacy Consent','By registering for this event, I agree to the terms of attendance, event guidelines, and data processing policies.\nI confirm all details provided are accurate.','I understand and agree to the event registration guidelines and privacy terms.','[{\"type\": \"text\", \"label\": \"Hacker Name\", \"is_required\": true, \"placeholder\": \"Full name\"}, {\"type\": \"text\", \"label\": \"Team Name\", \"is_required\": true, \"placeholder\": \"Team codename\"}]','2026-09-07 00:23:52','2026-09-07 00:23:52');
/*!40000 ALTER TABLE `event_registration_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_registrations`
--

DROP TABLE IF EXISTS `event_registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_registrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `registration_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json NOT NULL,
  `consent_agreed` tinyint(1) NOT NULL DEFAULT '1',
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_registrations_event_id_registration_reference_unique` (`event_id`,`registration_reference`),
  CONSTRAINT `event_registrations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_registrations`
--

LOCK TABLES `event_registrations` WRITE;
/*!40000 ALTER TABLE `event_registrations` DISABLE KEYS */;
INSERT INTO `event_registrations` VALUES (1,2,'REG-20260907-CGQYM','{\"Last Name\": \"Alex Morgan\", \"First Name\": \"Alex Morgan\", \"Jersey Size\": \"XL\"}',1,'127.0.0.1','2026-09-06 22:06:59','2026-09-06 22:06:59'),(2,2,'REG-20260907-WMVZR','{\"Last Name\": \"Carlos Santos\", \"First Name\": \"Carlos Santos\", \"Jersey Size\": \"L\"}',1,'127.0.0.1','2026-09-06 22:06:59','2026-09-06 22:06:59'),(3,2,'REG-20260907-YRQM2','{\"Last Name\": \"Danielle Reyes\", \"First Name\": \"Danielle Reyes\", \"Jersey Size\": \"S\"}',1,'127.0.0.1','2026-09-06 22:06:59','2026-09-06 22:06:59'),(4,2,'REG-20260907-ZRSKG','{\"Last Name\": \"Elena Rostova\", \"First Name\": \"Elena Rostova\", \"Jersey Size\": \"XS\"}',1,'127.0.0.1','2026-09-06 22:06:59','2026-09-06 22:06:59'),(5,2,'REG-20260907-KRHOT','{\"Last Name\": \"Franklin Moore\", \"First Name\": \"Franklin Moore\", \"Jersey Size\": \"XXXSSS\"}',1,'127.0.0.1','2026-09-06 22:06:59','2026-09-06 22:06:59'),(6,2,'REG-20260907-OYNQW','{\"Last Name\": \"Grace Kim\", \"First Name\": \"Grace Kim\", \"Jersey Size\": \"XXXLL\"}',1,'127.0.0.1','2026-09-06 22:06:59','2026-09-06 22:06:59'),(7,2,'REG-20260907-MHHTI','{\"Last Name\": \"Hannah Abbott\", \"First Name\": \"Hannah Abbott\", \"Jersey Size\": \"XL\"}',1,'127.0.0.1','2026-09-06 22:06:59','2026-09-06 22:06:59'),(8,2,'REG-20260907-GDA7I','{\"Last Name\": \"Ian Wright\", \"First Name\": \"Ian Wright\", \"Jersey Size\": \"L\"}',1,'127.0.0.1','2026-09-06 22:06:59','2026-09-06 22:06:59'),(9,3,'REG-20260907-3C5UQ','{\"Full Name\": \"Garfield Besa\", \"Executive Track\": \"AI Governance & Policy\", \"Job Title & Company\": \"Test\"}',1,'127.0.0.1','2026-09-07 00:58:12','2026-09-07 00:58:12'),(10,2,'REG-20260907-OPHFR','{\"Last Name\": \"test123\", \"First Name\": \"test123\", \"Jersey Size\": \"L\", \"Identification card\": \"events/registrations/xry3oZ7GPY6SfiSsBqjRL1EDtxNU03may9d8aqEz.jpg\"}',1,'127.0.0.1','2026-09-07 04:19:20','2026-09-07 04:19:20'),(11,4,'REG-20260907-GDA7I','{\"Last Name\": \"Ian Wright\", \"First Name\": \"Ian Wright\", \"Jersey Size\": \"L\"}',1,'127.0.0.1','2026-09-07 04:32:36','2026-09-07 04:32:36');
/*!40000 ALTER TABLE `event_registrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_team_members`
--

DROP TABLE IF EXISTS `event_team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_team_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_team_id` bigint unsigned NOT NULL,
  `event_registration_id` bigint unsigned NOT NULL,
  `registration_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_team_members_event_team_id_event_registration_id_unique` (`event_team_id`,`event_registration_id`),
  KEY `event_team_members_event_registration_id_foreign` (`event_registration_id`),
  CONSTRAINT `event_team_members_event_registration_id_foreign` FOREIGN KEY (`event_registration_id`) REFERENCES `event_registrations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_team_members_event_team_id_foreign` FOREIGN KEY (`event_team_id`) REFERENCES `event_teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_team_members`
--

LOCK TABLES `event_team_members` WRITE;
/*!40000 ALTER TABLE `event_team_members` DISABLE KEYS */;
INSERT INTO `event_team_members` VALUES (1,1,1,'REG-20260907-CGQYM','Alex Morgan','2026-09-07 04:05:28','2026-09-07 04:05:28'),(2,1,8,'REG-20260907-GDA7I','Ian Wright','2026-09-07 04:05:28','2026-09-07 04:05:28'),(3,2,11,'REG-20260907-GDA7I','Ian Wright','2026-09-07 04:33:17','2026-09-07 04:33:17');
/*!40000 ALTER TABLE `event_team_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_teams`
--

DROP TABLE IF EXISTS `event_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_teams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `team_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_teams_event_id_team_name_unique` (`event_id`,`team_name`),
  UNIQUE KEY `event_teams_team_reference_unique` (`team_reference`),
  CONSTRAINT `event_teams_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_teams`
--

LOCK TABLES `event_teams` WRITE;
/*!40000 ALTER TABLE `event_teams` DISABLE KEYS */;
INSERT INTO `event_teams` VALUES (1,2,'InnovateTech Champions','TEAM-20260907-WI00I','2026-09-07 04:05:28','2026-09-07 04:05:28'),(2,4,'team2','TEAM-20260907-G8P8M','2026-09-07 04:33:17','2026-09-07 04:33:17');
/*!40000 ALTER TABLE `event_teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `event_date` date NOT NULL,
  `registration_start_date` date DEFAULT NULL,
  `registration_date` date NOT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admission` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'free',
  `ticket_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (2,'InnovateTech Global Summit 2026','Join us for the largest tech summit of the year featuring AI & Cloud innovations! Connect with global pioneers, engineers, and digital innovators.','2026-10-15','2026-09-02','2026-10-01','events/banners/01M1X4YD0BMNAB3QW332XFHPRE.png','free',NULL,'2026-09-06 20:54:21','2026-09-07 00:43:55'),(3,'Executive Leadership & AI Strategy Forum 2026','A premier executive gathering bringing together C-level leaders, strategists, and decision makers to explore enterprise artificial intelligence adoption, governance, and business transformation.','2026-10-22','2026-09-02','2026-10-17','events/banners/banner_leadership.jpg','paid','₱2,500','2026-09-07 00:23:52','2026-09-07 00:43:55'),(4,'Corporate Wellness Marathon & Sports Festival','Unite and thrive! An action-packed community wellness festival featuring 5K/10K fun runs, corporate relay tournaments, fitness workshops, and health vitality booths.','2026-11-06','2026-09-05','2026-10-27','events/banners/banner_sports.jpg','free',NULL,'2026-09-07 00:23:52','2026-09-07 00:23:52'),(5,'Cloud Architecture & DevOps Masterclass','Deep dive into microservices, automated CI/CD pipelines, Kubernetes orchestration, and resilient cloud architectures with industry enterprise cloud practitioners.','2026-11-21','2026-09-06','2026-11-11','events/banners/banner_tech.jpg','paid','$35.00','2026-09-07 00:23:52','2026-09-07 00:43:55'),(6,'Annual Corporate Gala & Excellence Awards','An evening honoring standout performers, breakthrough innovations, and exemplary leadership. Formal black-tie gala dinner, live performances, and awards ceremony.','2026-12-11','2026-09-27','2026-11-26','events/banners/banner_leadership.jpg','free',NULL,'2026-09-07 00:23:52','2026-09-07 00:23:52'),(7,'Fintech & Cybersecurity Summit 2026','Explore the modern landscape of zero-trust security, real-time fraud mitigation, decentralized finance compliance, and threat intelligence in the financial sector.','2026-12-01','2026-09-04','2026-11-16','events/banners/banner_tech.jpg','paid','₱1,800','2026-09-07 00:23:52','2026-09-07 00:43:55'),(8,'HR Leaders & People Culture Symposium','Empower your workplace. Discuss progressive compensation benchmarks, hybrid team engagement, agile talent acquisition, and employee retention strategies.','2026-12-26','2026-09-03','2026-12-16','events/banners/banner_leadership.jpg','free',NULL,'2026-09-07 00:23:52','2026-09-07 00:23:52'),(9,'Summer Hackathon & Rapid Prototyping Sprint','A past 48-hour intensive coding sprint where developers competed to prototype next-generation employee automation and workforce workflow tools.','2026-08-13','2026-07-29','2026-08-08','events/banners/banner_sports.jpg','free',NULL,'2026-09-07 00:23:52','2026-09-07 00:23:52');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
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
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
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
  `attempts` tinyint unsigned NOT NULL,
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
-- Table structure for table `leave_requests`
--

DROP TABLE IF EXISTS `leave_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leave_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `leave_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leave_requests_employee_id_foreign` (`employee_id`),
  CONSTRAINT `leave_requests_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_requests`
--

LOCK TABLES `leave_requests` WRITE;
/*!40000 ALTER TABLE `leave_requests` DISABLE KEYS */;
INSERT INTO `leave_requests` VALUES (1,1,'Vacation Leave','2026-09-06','2026-09-07','Family trip','approved','2026-09-03 09:25:48','2026-09-03 01:25:07','2026-09-03 01:25:48'),(2,1,'Vacation Leave','2026-09-06','2026-09-07','Family trip','pending',NULL,'2026-09-03 01:25:48','2026-09-03 01:25:48');
/*!40000 ALTER TABLE `leave_requests` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_08_27_041030_create_employees_table',2),(5,'2026_08_27_074435_create_positions_table',3),(6,'2026_08_27_074455_add_position_id_to_employees_table',3),(7,'2026_08_27_075853_add_rates_to_positions_table',4),(8,'2026_08_27_075900_create_position_audit_logs_table',4),(9,'2026_08_27_092509_create_timesheets_table',5),(10,'2026_09_02_133814_create_cash_advances_table',6),(11,'2026_09_03_164000_add_role_to_employees_table',7),(12,'2026_09_03_173000_create_leave_requests_table',8),(13,'2026_09_03_181500_add_roles_to_employees_table',9),(14,'2026_09_07_120000_create_events_table',10),(15,'2026_09_07_120100_create_event_registration_forms_table',10),(16,'2026_09_07_130500_add_banner_to_event_registration_forms_table',11),(17,'2026_09_07_131000_add_registration_start_and_open_status',12),(18,'2026_09_07_140000_create_event_registrations_table',13),(20,'2026_09_07_150000_add_admission_to_events_table',14),(21,'2026_09_07_160000_create_event_teams_tables',15),(22,'2026_09_07_170000_update_event_registrations_reference_unique',16);
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
-- Table structure for table `position_audit_logs`
--

DROP TABLE IF EXISTS `position_audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `position_audit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `position_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `changes` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `position_audit_logs_position_id_foreign` (`position_id`),
  KEY `position_audit_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `position_audit_logs_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `position_audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `position_audit_logs`
--

LOCK TABLES `position_audit_logs` WRITE;
/*!40000 ALTER TABLE `position_audit_logs` DISABLE KEYS */;
INSERT INTO `position_audit_logs` VALUES (1,1,1,'updated','{\"sss\": {\"new\": 150, \"old\": \"0.00\"}, \"pag_ibig\": {\"new\": 50, \"old\": \"0.00\"}, \"base_rate\": {\"new\": 500, \"old\": \"0.00\"}, \"philhealth\": {\"new\": 100, \"old\": \"0.00\"}, \"overtime_rate\": {\"new\": 75, \"old\": \"0.00\"}}','2026-08-27 00:01:35'),(2,1,1,'updated','{\"base_rate\": {\"new\": 550, \"old\": \"500.00\"}}','2026-08-27 00:03:05'),(3,3,1,'updated','{\"sss\": {\"new\": 250, \"old\": \"0.00\"}, \"pag_ibig\": {\"new\": 250, \"old\": \"0.00\"}, \"base_rate\": {\"new\": 550, \"old\": \"0.00\"}, \"philhealth\": {\"new\": 250, \"old\": \"0.00\"}}','2026-09-02 00:43:43'),(4,4,1,'updated','{\"sss\": {\"new\": 250, \"old\": \"0.00\"}, \"pag_ibig\": {\"new\": 250, \"old\": \"0.00\"}, \"base_rate\": {\"new\": 550, \"old\": \"0.00\"}, \"philhealth\": {\"new\": 250, \"old\": \"0.00\"}, \"overtime_rate\": {\"new\": 23, \"old\": \"0.00\"}}','2026-09-02 00:45:49'),(5,4,1,'updated','{\"sss\": {\"new\": 252.5, \"old\": \"250.00\"}, \"pag_ibig\": {\"new\": 100, \"old\": \"250.00\"}, \"base_rate\": {\"new\": 505, \"old\": \"550.00\"}, \"philhealth\": {\"new\": 125, \"old\": \"250.00\"}}','2026-09-02 00:49:49'),(6,4,1,'updated','{\"overtime_rate\": {\"new\": 82, \"old\": \"23.00\"}}','2026-09-02 00:55:20');
/*!40000 ALTER TABLE `position_audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `positions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `base_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `overtime_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sss` decimal(10,2) NOT NULL DEFAULT '0.00',
  `philhealth` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pag_ibig` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `positions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
INSERT INTO `positions` VALUES (1,'Secretary','2026-08-26 23:45:12','2026-08-27 00:03:05',550.00,75.00,150.00,100.00,50.00),(2,'Part Time','2026-08-26 23:45:12','2026-08-26 23:45:12',0.00,0.00,0.00,0.00,0.00),(3,'Production Staff','2026-08-26 23:45:12','2026-09-02 00:43:43',550.00,0.00,250.00,250.00,250.00),(4,'Production head','2026-08-26 23:45:12','2026-09-02 00:55:20',505.00,82.00,252.50,125.00,100.00),(5,'Jr. Graphic Designer','2026-08-26 23:45:12','2026-08-26 23:45:12',0.00,0.00,0.00,0.00,0.00),(6,'Sr. Graphic Designer','2026-08-26 23:45:12','2026-08-26 23:45:12',0.00,0.00,0.00,0.00,0.00),(7,'Semi-Skilled','2026-08-26 23:45:12','2026-08-26 23:45:12',0.00,0.00,0.00,0.00,0.00),(8,'Labor','2026-08-26 23:45:12','2026-08-26 23:45:12',0.00,0.00,0.00,0.00,0.00);
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('vVmhglKDVE3dswnk1vxxjozXnf8Dhn7Npdfk4orZ',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYVZJY3RXRjY5UkRMazFWakoxOEtPTVNIcEZlcnltOEluU25BZXpVYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9ldmVudHMvMi9yZWdpc3RyYXRpb24tZm9ybSI7czo1OiJyb3V0ZSI7czozNjoiZmlsYW1lbnQuYWRtaW4ucmVzb3VyY2VzLmV2ZW50cy5mb3JtIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiNDljMWUwYmM4MmNjNTg0MDJiNDU3NDgwMmJjNzU5ZjQ3YWZmMTE4OGI3N2U3YmE3ZjZlYjYyZjQ3MTNkYWM4OSI7czo2OiJ0YWJsZXMiO2E6Mzp7czo0MDoiM2UzNjg3NjgxNTAxZDQ2NTdhNzQ4OTM5NzA0NzlkYWVfY29sdW1ucyI7YTo5OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NjoiYmFubmVyIjtzOjU6ImxhYmVsIjtzOjY6IkJhbm5lciI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtZSI7czo1OiJsYWJlbCI7czoxMDoiRXZlbnQgTmFtZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImV2ZW50X2RhdGUiO3M6NToibGFiZWwiO3M6MTA6IkV2ZW50IERhdGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE5OiJyZWdpc3RyYXRpb25fcGVyaW9kIjtzOjU6ImxhYmVsIjtzOjE5OiJSZWdpc3RyYXRpb24gUGVyaW9kIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxOToicmVnaXN0cmF0aW9uX3N0YXR1cyI7czo1OiJsYWJlbCI7czo2OiJTdGF0dXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6ImFkbWlzc2lvbiI7czo1OiJsYWJlbCI7czo5OiJBZG1pc3Npb24iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE5OiJyZWdpc3RyYXRpb25zX2NvdW50IjtzOjU6ImxhYmVsIjtzOjEwOiJSZWdpc3RlcmVkIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6ODthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiI5MTFkMmQzNjIzMjlmNjQzOTQ0NzgzNjAxOTcyODFkMF9jb2x1bW5zIjthOjU6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMzoiYXR0ZW5kZWVfbmFtZSI7czo1OiJsYWJlbCI7czoxMzoiQXR0ZW5kZWUgTmFtZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MjI6InJlZ2lzdHJhdGlvbl9yZWZlcmVuY2UiO3M6NToibGFiZWwiO3M6MjM6IlJlZmVyZW5jZSBOdW1iZXIgKFJlZiMpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMjoiZXZlbnRzX2NvdW50IjtzOjU6ImxhYmVsIjtzOjE3OiJFdmVudHMgUmVnaXN0ZXJlZCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6InRlYW1zX2NvdW50IjtzOjU6ImxhYmVsIjtzOjEyOiJUZWFtcyBKb2luZWQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjIwOiJEYXRlIG9mIFJlZ2lzdHJhdGlvbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiNzJjMzI3MGQ1MGVjMGNjNTFiNTU4MjZkNmQxYWE0ODJfY29sdW1ucyI7YTo0OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImV2ZW50Lm5hbWUiO3M6NToibGFiZWwiO3M6NToiRXZlbnQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6InRlYW1fbmFtZSI7czo1OiJsYWJlbCI7czo5OiJUZWFtIE5hbWUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE0OiJ0ZWFtX3JlZmVyZW5jZSI7czo1OiJsYWJlbCI7czoxNDoiVGVhbSBSZWZlcmVuY2UiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjE3OiJSZWdpc3RyYXRpb24gRGF0ZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319fX0=',1788786319);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timesheets`
--

DROP TABLE IF EXISTS `timesheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timesheets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `is_on_leave` tinyint(1) NOT NULL DEFAULT '0',
  `force_meal_allowance` tinyint(1) NOT NULL DEFAULT '0',
  `deduction` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deduction_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra_income` decimal(10,2) NOT NULL DEFAULT '0.00',
  `extra_income_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `timesheets_employee_id_foreign` (`employee_id`),
  CONSTRAINT `timesheets_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timesheets`
--

LOCK TABLES `timesheets` WRITE;
/*!40000 ALTER TABLE `timesheets` DISABLE KEYS */;
INSERT INTO `timesheets` VALUES (1,1,'2026-08-27',NULL,'17:30:00',0,0,150.00,'Late return penalty',300.00,'Target performance bonus','2026-08-27 01:29:12','2026-08-27 01:34:24'),(2,3,'2026-08-27',NULL,'17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-08-27 01:29:44','2026-08-27 01:34:45'),(3,3,'2026-08-26',NULL,'17:40:00',0,1,0.00,NULL,0.00,NULL,'2026-08-27 01:30:10','2026-08-27 01:35:08'),(4,1,'2026-08-26',NULL,NULL,1,0,0.00,NULL,0.00,NULL,'2026-08-27 01:31:49','2026-08-27 01:35:30'),(5,1,'2026-09-01','08:28:00','17:23:00',0,0,0.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(6,1,'2026-09-02','08:08:00','17:02:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(8,1,'2026-09-04','08:21:00','17:05:00',0,0,0.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(9,1,'2026-09-05','08:17:00','17:26:00',0,0,50.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(10,1,'2026-09-07','08:49:00','17:30:00',1,0,1550.00,'Test Ded., Cash Advance',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-06 23:17:52'),(11,1,'2026-09-08','08:40:00','17:16:00',0,0,50.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(12,1,'2026-09-09','08:25:00','18:20:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(13,1,'2026-09-10','08:17:00','17:22:00',0,0,0.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(14,1,'2026-09-11','08:11:00','17:06:00',0,0,0.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(15,1,'2026-09-12','08:49:00','18:04:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(16,1,'2026-09-14','08:22:00','17:27:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(17,1,'2026-09-15','08:24:00','17:09:00',0,0,0.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(18,2,'2026-09-01','08:11:00','18:25:00',0,0,0.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(19,2,'2026-09-02','08:25:00','17:11:00',0,0,850.00,'Test Ded., Cash Advance',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 06:03:25'),(20,2,'2026-09-03','08:14:00','17:25:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(21,2,'2026-09-04','08:41:00','17:20:00',0,0,50.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(22,2,'2026-09-05','08:45:00','17:24:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(23,2,'2026-09-07','08:25:00','17:17:00',0,0,0.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(24,2,'2026-09-08','08:09:00','17:13:00',0,0,0.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(25,2,'2026-09-09','08:22:00','17:09:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(26,2,'2026-09-10','08:22:00','17:07:00',0,0,0.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(27,2,'2026-09-11','08:14:00','17:09:00',0,0,0.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(28,2,'2026-09-12','08:47:00','17:16:00',0,0,50.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(29,2,'2026-09-14','08:15:00','17:27:00',0,0,0.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(30,2,'2026-09-15','08:49:00','17:14:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(31,3,'2026-09-01','08:21:00','17:01:00',0,0,0.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(32,3,'2026-09-02','08:40:00','17:01:00',0,0,0.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(33,3,'2026-09-03','08:43:00','17:17:00',0,0,50.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(34,3,'2026-09-04','08:06:00','17:23:00',0,0,0.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(35,3,'2026-09-05','08:48:00','17:06:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(36,3,'2026-09-07','08:14:00','20:20:00',0,0,0.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(37,3,'2026-09-09','08:34:00','17:14:00',0,0,0.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(38,3,'2026-09-10','08:02:00','17:03:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(39,3,'2026-09-11','08:11:00','17:09:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(40,3,'2026-09-12','08:40:00','17:12:00',0,0,50.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(41,3,'2026-09-14','08:18:00','17:29:00',0,0,0.00,'Test Ded.',0.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(42,3,'2026-09-15','08:13:00','17:04:00',0,0,50.00,'Test Ded.',100.00,'Test Extra','2026-09-02 00:41:38','2026-09-02 00:41:38'),(43,2,'2026-08-17','08:49:00','17:30:00',0,1,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(44,2,'2026-08-18','08:22:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(45,2,'2026-08-19','09:59:00','17:30:00',0,1,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(46,2,'2026-08-20','08:30:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(47,2,'2026-08-21','08:30:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(48,2,'2026-08-22','08:47:00','17:30:00',0,1,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(49,2,'2026-08-23','08:20:00','18:23:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(50,2,'2026-08-24','08:30:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(51,2,'2026-08-25','08:30:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(52,2,'2026-08-26','08:25:00','18:56:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(53,2,'2026-08-27','08:47:00','17:30:00',0,1,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(54,2,'2026-08-28','08:30:00','18:51:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(55,2,'2026-08-29','09:12:00','19:19:00',0,1,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(56,2,'2026-08-30','08:14:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:50:04','2026-09-02 00:50:04'),(57,2,'2026-08-01','08:49:00','17:30:00',0,1,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(58,2,'2026-08-02','08:22:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(59,2,'2026-08-03','09:59:00','17:30:00',0,1,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(60,2,'2026-08-04','08:30:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(61,2,'2026-08-05','08:30:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(62,2,'2026-08-06','08:47:00','17:30:00',0,1,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(63,2,'2026-08-07','08:20:00','18:23:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(64,2,'2026-08-08','08:30:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(65,2,'2026-08-09','08:30:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(66,2,'2026-08-10','08:25:00','18:56:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(67,2,'2026-08-11','08:47:00','17:30:00',0,1,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(68,2,'2026-08-12','08:30:00','18:51:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(69,2,'2026-08-13','09:12:00','19:19:00',0,1,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(70,2,'2026-08-14','08:14:00','17:30:00',0,0,0.00,NULL,0.00,NULL,'2026-09-02 00:53:55','2026-09-02 00:53:55'),(71,2,'2026-09-02','09:02:48','18:37:56',0,1,0.00,NULL,0.00,NULL,'2026-09-02 06:03:11','2026-09-02 06:03:11'),(72,1,'2026-09-03','17:05:32','17:05:32',0,0,0.00,NULL,0.00,NULL,'2026-09-03 01:05:32','2026-09-03 01:05:32'),(73,4,'2026-09-03','17:10:19',NULL,0,0,0.00,NULL,0.00,NULL,'2026-09-03 01:10:19','2026-09-03 01:10:19'),(74,1,'2026-09-06',NULL,NULL,1,0,0.00,NULL,0.00,NULL,'2026-09-03 01:25:07','2026-09-03 01:25:07');
/*!40000 ALTER TABLE `timesheets` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@example.com',NULL,'$2y$12$eil54ulY1u9rShH7F9jJhuC/IdfrAbd/LY6Fg4NeRM5EGkIP5ZcuG',NULL,'2026-08-26 01:35:57','2026-09-07 01:17:16');
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

-- Dump completed on 2026-09-08  8:31:42
