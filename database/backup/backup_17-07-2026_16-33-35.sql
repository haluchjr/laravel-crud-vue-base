-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: dev_sistema
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

--
-- Table structure for table `kanban`
--

DROP TABLE IF EXISTS `kanban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kanban` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `priority` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'medium',
  `column_index` int DEFAULT '0',
  `position` int DEFAULT '0',
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kanban`
--

LOCK TABLES `kanban` WRITE;
/*!40000 ALTER TABLE `kanban` DISABLE KEYS */;
INSERT INTO `kanban` VALUES (22,'teste1',NULL,'medium',6,0,'[]','2026-07-16 00:54:33','2026-07-16 00:57:49',NULL),(23,'teste 2','230123231','medium',1,1,'[]','2026-07-16 00:55:14','2026-07-16 11:43:41',NULL),(24,'testrre4',NULL,'medium',1,2,'[]','2026-07-16 11:40:42','2026-07-16 11:40:42',NULL);
/*!40000 ALTER TABLE `kanban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kanbanColumns`
--

DROP TABLE IF EXISTS `kanbanColumns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kanbanColumns` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `text` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kanbanColumns`
--

LOCK TABLES `kanbanColumns` WRITE;
/*!40000 ALTER TABLE `kanbanColumns` DISABLE KEYS */;
INSERT INTO `kanbanColumns` VALUES (1,'bi-inbox','Backlog'),(2,'bi-card-checklist','To Do'),(3,'bi-gear','In Progress'),(4,'bi-eye','Review'),(5,'bi-beaker','Testing'),(6,'bi-check-circle-fill','Done');
/*!40000 ALTER TABLE `kanbanColumns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kanbanLog`
--

DROP TABLE IF EXISTS `kanbanLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kanbanLog` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `card_id` int DEFAULT NULL,
  `column_index_old` int unsigned DEFAULT NULL,
  `column_index_new` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kanbanLog`
--

LOCK TABLES `kanbanLog` WRITE;
/*!40000 ALTER TABLE `kanbanLog` DISABLE KEYS */;
INSERT INTO `kanbanLog` VALUES (15,22,1,2,'2026-07-16 00:56:47','2026-07-16 00:56:47'),(16,22,2,3,'2026-07-16 00:57:18','2026-07-16 00:57:18'),(17,22,3,5,'2026-07-16 00:57:28','2026-07-16 00:57:28'),(18,22,5,4,'2026-07-16 00:57:37','2026-07-16 00:57:37'),(19,22,4,6,'2026-07-16 00:57:49','2026-07-16 00:57:49');
/*!40000 ALTER TABLE `kanbanLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_06_01_230314_create_telescope_entries_table',1),(5,'2026_06_03_014907_create_projetos_table',1),(6,'2026_06_04_134146_create_menu_table',1),(7,'2026_06_09_000001_create_acl_table',1),(8,'2026_06_16_010919_cadastro',1),(10,'2026_06_27_192224_create_personal_access_tokens_table',2),(13,'2026_06_29_111939_create_pedidos_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_cache`
--

DROP TABLE IF EXISTS `tb_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_cache`
--

LOCK TABLES `tb_cache` WRITE;
/*!40000 ALTER TABLE `tb_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_cache_locks`
--

DROP TABLE IF EXISTS `tb_cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_cache_locks`
--

LOCK TABLES `tb_cache_locks` WRITE;
/*!40000 ALTER TABLE `tb_cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_cadastro`
--

DROP TABLE IF EXISTS `tb_cadastro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_cadastro` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ddd_telefone` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ddd_celular` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cpf_cnpj` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cep` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `endereco` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nr` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bairro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cidade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estado` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `tb_cadastro_email_unique` (`email`) USING BTREE,
  UNIQUE KEY `tb_cadastro_cpf_cnpj_unique` (`cpf_cnpj`) USING BTREE,
  UNIQUE KEY `tb_cadastro_uuid_unique` (`uuid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_cadastro`
--

LOCK TABLES `tb_cadastro` WRITE;
/*!40000 ALTER TABLE `tb_cadastro` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_cadastro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_componentes`
--

DROP TABLE IF EXISTS `tb_componentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_componentes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tipo_arquivo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_componentes`
--

LOCK TABLES `tb_componentes` WRITE;
/*!40000 ALTER TABLE `tb_componentes` DISABLE KEYS */;
INSERT INTO `tb_componentes` VALUES (1,'Frente','frente','_frente'),(2,'Capa','capa','_capa'),(7,'Miolo','miolo','_miolo'),(8,'Trás','tras','_tras'),(9,'Hot Stamping','hotstamping','_hs'),(10,'Verniz Total Frente','verniztotalfrente','_vtf');
/*!40000 ALTER TABLE `tb_componentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_enderecos`
--

DROP TABLE IF EXISTS `tb_enderecos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_enderecos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `estado` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cep` int DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `status` varchar(255) DEFAULT '1',
  `apelido` varchar(255) DEFAULT NULL,
  `tipo_endereco_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuarios_id` (`usuario_id`),
  KEY `tipo_endereco_id` (`tipo_endereco_id`),
  CONSTRAINT `tb_enderecos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuarios` (`id`),
  CONSTRAINT `tb_enderecos_ibfk_2` FOREIGN KEY (`tipo_endereco_id`) REFERENCES `tb_tipo_endereco` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_enderecos`
--

LOCK TABLES `tb_enderecos` WRITE;
/*!40000 ALTER TABLE `tb_enderecos` DISABLE KEYS */;
INSERT INTO `tb_enderecos` VALUES (6,10,'Rua Alberto Klemtz','Portão','Curitiba','PR',80330380,1,NULL,'1','ertgr',1),(7,10,'Rua Padre Leonardo Nunes teste','Portão','Curitiba','PR',80330320,1,NULL,'1','teste teste',2);
/*!40000 ALTER TABLE `tb_enderecos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_extensoes`
--

DROP TABLE IF EXISTS `tb_extensoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_extensoes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome_formato` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `extensao` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_extensoes`
--

LOCK TABLES `tb_extensoes` WRITE;
/*!40000 ALTER TABLE `tb_extensoes` DISABLE KEYS */;
INSERT INTO `tb_extensoes` VALUES (1,'Corel Draw(CDR)','.cdr'),(2,'Portable Document','.pdf');
/*!40000 ALTER TABLE `tb_extensoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_failed_jobs`
--

DROP TABLE IF EXISTS `tb_failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `tb_failed_jobs_uuid_unique` (`uuid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_failed_jobs`
--

LOCK TABLES `tb_failed_jobs` WRITE;
/*!40000 ALTER TABLE `tb_failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_fones`
--

DROP TABLE IF EXISTS `tb_fones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_fones` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned DEFAULT NULL,
  `ddd_numero` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tipo_fone` int DEFAULT NULL COMMENT '1-Cel / 2-Fixo',
  `status` tinyint DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `teste` (`usuario_id`),
  CONSTRAINT `teste` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_fones`
--

LOCK TABLES `tb_fones` WRITE;
/*!40000 ALTER TABLE `tb_fones` DISABLE KEYS */;
INSERT INTO `tb_fones` VALUES (1,10,'99 99999-9999',1,1),(2,10,'22 2222-2225',2,1);
/*!40000 ALTER TABLE `tb_fones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_job_batches`
--

DROP TABLE IF EXISTS `tb_job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_job_batches`
--

LOCK TABLES `tb_job_batches` WRITE;
/*!40000 ALTER TABLE `tb_job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_jobs`
--

DROP TABLE IF EXISTS `tb_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `tb_jobs_queue_index` (`queue`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_jobs`
--

LOCK TABLES `tb_jobs` WRITE;
/*!40000 ALTER TABLE `tb_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_log_status_pedido`
--

DROP TABLE IF EXISTS `tb_log_status_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_log_status_pedido` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `status_id` int unsigned DEFAULT NULL,
  `data_inclusao` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `usuario_id` bigint unsigned DEFAULT NULL COMMENT 'Operador que mexeu no pedido',
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `tb_log_status_pedido_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `tb_status_pedido` (`id`),
  CONSTRAINT `tb_log_status_pedido_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_log_status_pedido`
--

LOCK TABLES `tb_log_status_pedido` WRITE;
/*!40000 ALTER TABLE `tb_log_status_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_log_status_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_log_status_pedido_itens`
--

DROP TABLE IF EXISTS `tb_log_status_pedido_itens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_log_status_pedido_itens` (
  `id` int unsigned NOT NULL,
  `usuario_id` bigint unsigned DEFAULT NULL,
  `status_pedido_id` int unsigned DEFAULT NULL,
  `data_inclusao` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `status_pedido_id` (`status_pedido_id`),
  CONSTRAINT `tb_log_status_pedido_itens_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuarios` (`id`),
  CONSTRAINT `tb_log_status_pedido_itens_ibfk_2` FOREIGN KEY (`status_pedido_id`) REFERENCES `tb_status_pedido_item` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_log_status_pedido_itens`
--

LOCK TABLES `tb_log_status_pedido_itens` WRITE;
/*!40000 ALTER TABLE `tb_log_status_pedido_itens` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_log_status_pedido_itens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_menus`
--

DROP TABLE IF EXISTS `tb_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '#',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ordem` int NOT NULL DEFAULT '0',
  `nivel_permissao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'usuario',
  `menu_pai_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `tb_menus_menu_pai_id_foreign` (`menu_pai_id`) USING BTREE,
  CONSTRAINT `tb_menus_menu_pai_id_foreign` FOREIGN KEY (`menu_pai_id`) REFERENCES `tb_menus` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_menus`
--

LOCK TABLES `tb_menus` WRITE;
/*!40000 ALTER TABLE `tb_menus` DISABLE KEYS */;
INSERT INTO `tb_menus` VALUES (1,'Pedidos','#','bi-cart',1,'[1]',NULL),(9,'Novo Pedido','usuario.novo','bi-cart',1,'[1]',1),(11,'Sistema','#','bi-gear',2,'[1,5]',NULL),(12,'Relatório','usuario.listar','bi-postcard',2,'[1]',1),(14,'Meus dados','usuario.ajustes','bi-postcard',1,'[1,5]',11),(15,'Financeiro','#','bi-postcard',1,'[5]',NULL),(16,'Pedidos','#','bi-cart',1,'[5]',15),(17,'Kanban','kanban.index','bi-kanban',3,'[99]',11),(18,'Telescope','#','bi-radioactive',99,'[99]',11);
/*!40000 ALTER TABLE `tb_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_nivel`
--

DROP TABLE IF EXISTS `tb_nivel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_nivel` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `perfil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descricao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_nivel`
--

LOCK TABLES `tb_nivel` WRITE;
/*!40000 ALTER TABLE `tb_nivel` DISABLE KEYS */;
INSERT INTO `tb_nivel` VALUES (1,'Usuario','Usuário comum'),(3,'Baixa','Operador Baixa'),(4,'Bureau','Operador Bureau'),(5,'Financeiro','Financeiro'),(99,'Admin','Administrador');
/*!40000 ALTER TABLE `tb_nivel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_nivel_permissoes`
--

DROP TABLE IF EXISTS `tb_nivel_permissoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_nivel_permissoes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nivel_id` int unsigned DEFAULT NULL COMMENT 'Nivel do usuario, ver tb_nivel',
  `menu_id` bigint unsigned DEFAULT NULL COMMENT 'Chave Primaria da tb_menu, nao usar os que tem #',
  `ver` bit(1) DEFAULT NULL,
  `criar` bit(1) DEFAULT NULL,
  `editar` bit(1) DEFAULT NULL,
  `excluir` bit(1) DEFAULT NULL,
  `btn_pdf` binary(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nivel_id` (`nivel_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `tb_nivel_permissoes_ibfk_1` FOREIGN KEY (`nivel_id`) REFERENCES `tb_nivel` (`id`),
  CONSTRAINT `tb_nivel_permissoes_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `tb_menus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_nivel_permissoes`
--

LOCK TABLES `tb_nivel_permissoes` WRITE;
/*!40000 ALTER TABLE `tb_nivel_permissoes` DISABLE KEYS */;
INSERT INTO `tb_nivel_permissoes` VALUES (1,1,9,_binary '',_binary '',_binary '',_binary '',NULL),(4,1,1,_binary '',_binary '',_binary '',_binary '',NULL),(6,1,12,_binary '',_binary '',_binary '',_binary '',NULL);
/*!40000 ALTER TABLE `tb_nivel_permissoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_password_reset_tokens`
--

DROP TABLE IF EXISTS `tb_password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_password_reset_tokens`
--

LOCK TABLES `tb_password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `tb_password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_pedido_itens`
--

DROP TABLE IF EXISTS `tb_pedido_itens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_pedido_itens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint unsigned DEFAULT NULL,
  `produto_id` int unsigned DEFAULT NULL,
  `tamanho_id` int unsigned DEFAULT NULL,
  `status_pedido_item_id` int unsigned DEFAULT NULL,
  `pdf_valido` tinyint DEFAULT NULL,
  `boneco_gerado` tinyint DEFAULT NULL,
  `data_boneco_gerado` date DEFAULT NULL,
  `total_paginas_pdf` int DEFAULT NULL,
  `dimensao_pdf_com_sangra` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dimensao_pdf_sem_sangra` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `data_impressao` datetime DEFAULT NULL,
  `data_entrega` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedidos_id` (`pedido_id`),
  KEY `status_pedido_item_id` (`status_pedido_item_id`),
  KEY `produto_id` (`produto_id`),
  KEY `tamanho_id` (`tamanho_id`),
  CONSTRAINT `tb_pedido_itens_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `tb_pedidos` (`id`),
  CONSTRAINT `tb_pedido_itens_ibfk_2` FOREIGN KEY (`status_pedido_item_id`) REFERENCES `tb_status_pedido_item` (`id`),
  CONSTRAINT `tb_pedido_itens_ibfk_3` FOREIGN KEY (`produto_id`) REFERENCES `tb_produtos` (`id`),
  CONSTRAINT `tb_pedido_itens_ibfk_4` FOREIGN KEY (`tamanho_id`) REFERENCES `tb_tamanhos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pedido_itens`
--

LOCK TABLES `tb_pedido_itens` WRITE;
/*!40000 ALTER TABLE `tb_pedido_itens` DISABLE KEYS */;
INSERT INTO `tb_pedido_itens` VALUES (20,25,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,26,2,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,27,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(23,28,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(24,29,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(25,30,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(26,31,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tb_pedido_itens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_pedidos`
--

DROP TABLE IF EXISTS `tb_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_pedidos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint unsigned NOT NULL,
  `descricao` text NOT NULL,
  `data_inclusao` date NOT NULL,
  `data_entrega` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `observacao` varchar(255) DEFAULT NULL,
  `status_pedido_id` int unsigned DEFAULT '1',
  `valor_total_pedido` float(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_pedidos_fk_cliente_foreign` (`cliente_id`),
  KEY `status_pedido_id` (`status_pedido_id`),
  CONSTRAINT `tb_pedidos_fk_cliente_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `tb_usuarios` (`id`),
  CONSTRAINT `tb_pedidos_ibfk_1` FOREIGN KEY (`status_pedido_id`) REFERENCES `tb_status_pedido` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pedidos`
--

LOCK TABLES `tb_pedidos` WRITE;
/*!40000 ALTER TABLE `tb_pedidos` DISABLE KEYS */;
INSERT INTO `tb_pedidos` VALUES (25,10,'teeste','2026-07-02','2026-07-02','2026-07-02 14:43:56','2026-07-02 14:43:56','teeste',1,NULL),(26,10,'sd','2026-07-02','2026-07-02','2026-07-02 14:44:35','2026-07-02 14:44:35','sd',1,NULL),(27,10,'12','2026-07-17','2026-07-17','2026-07-17 04:46:05','2026-07-17 04:46:05','12',1,NULL),(28,10,'12','2026-07-17','2026-07-17','2026-07-17 04:46:18','2026-07-17 04:46:18','12',1,NULL),(29,10,'12','2026-07-17','2026-07-17','2026-07-17 04:48:23','2026-07-17 04:48:23','12',1,NULL),(30,10,'12','2026-07-17','2026-07-17','2026-07-17 04:48:55','2026-07-17 04:48:55','12',1,NULL),(31,10,'hg','2026-07-17','2026-07-17','2026-07-17 04:49:19','2026-07-17 04:49:19','hg',1,NULL);
/*!40000 ALTER TABLE `tb_pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_pedidos_itens_arquivos`
--

DROP TABLE IF EXISTS `tb_pedidos_itens_arquivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_pedidos_itens_arquivos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pedido_item_id` bigint unsigned DEFAULT NULL,
  `produto_componente_id` int unsigned DEFAULT NULL,
  `nome_original` varchar(255) DEFAULT NULL,
  `nome_interno` varchar(255) DEFAULT NULL,
  `data_inclusao` datetime DEFAULT NULL,
  `caminho_arquivo` varchar(255) DEFAULT NULL,
  `caminho_backup` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_item_id` (`pedido_item_id`),
  KEY `produto_componente_id` (`produto_componente_id`),
  CONSTRAINT `tb_pedidos_itens_arquivos_ibfk_1` FOREIGN KEY (`pedido_item_id`) REFERENCES `tb_pedido_itens` (`id`),
  CONSTRAINT `tb_pedidos_itens_arquivos_ibfk_2` FOREIGN KEY (`produto_componente_id`) REFERENCES `tb_componentes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pedidos_itens_arquivos`
--

LOCK TABLES `tb_pedidos_itens_arquivos` WRITE;
/*!40000 ALTER TABLE `tb_pedidos_itens_arquivos` DISABLE KEYS */;
INSERT INTO `tb_pedidos_itens_arquivos` VALUES (7,20,1,'untitled.pdf','25_20_frente.pdf','2026-07-02 11:43:56','/var/www/html/public/artes/2026/07/02/25/25_20_frente.pdf','tmp/untitled.pdf'),(8,20,7,'untitled.pdf','25_20_miolo.pdf','2026-07-02 11:43:56','/var/www/html/public/artes/2026/07/02/25/25_20_miolo.pdf','tmp/untitled.pdf'),(9,21,1,'recomendacao_Luis_Renato_Haluch_Jr.pdf','26_21_frente.pdf','2026-07-02 11:44:35','/var/www/html/public/artes/2026/07/02/26/26_21_frente.pdf','tmp/recomendacao_Luis_Renato_Haluch_Jr.pdf'),(10,21,2,'banner.png','26_21_capa.png','2026-07-02 11:44:35','/var/www/html/public/artes/2026/07/02/26/26_21_capa.png','tmp/banner.png'),(11,22,NULL,'CRLV_859754200-3.pdf','27_22_frente.pdf','2026-07-17 01:46:05','/var/www/html/public/artes/2026/07/17/27/27_22_frente.pdf','tmp/CRLV_859754200-3.pdf'),(12,22,NULL,'CRLV_859754200-3.pdf','27_22_miolo.pdf','2026-07-17 01:46:05','/var/www/html/public/artes/2026/07/17/27/27_22_miolo.pdf','tmp/CRLV_859754200-3.pdf'),(13,23,NULL,'CRLV_859754200-3.pdf','28_23_frente.pdf','2026-07-17 01:46:18','/var/www/html/public/artes/2026/07/17/28/28_23_frente.pdf','tmp/CRLV_859754200-3.pdf'),(14,23,NULL,'CRLV_859754200-3.pdf','28_23_miolo.pdf','2026-07-17 01:46:18','/var/www/html/public/artes/2026/07/17/28/28_23_miolo.pdf','tmp/CRLV_859754200-3.pdf'),(15,24,NULL,'CRLV_859754200-3.pdf','29_24_frente.pdf','2026-07-17 01:48:23','/var/www/html/public/artes/2026/07/17/29/29_24_frente.pdf','tmp/CRLV_859754200-3.pdf'),(16,24,NULL,'CRLV_859754200-3.pdf','29_24_miolo.pdf','2026-07-17 01:48:23','/var/www/html/public/artes/2026/07/17/29/29_24_miolo.pdf','tmp/CRLV_859754200-3.pdf'),(17,25,NULL,'CRLV_859754200-3.pdf','30_25_frente.pdf','2026-07-17 01:48:55','/var/www/html/public/artes/2026/07/17/30/30_25_frente.pdf','tmp/CRLV_859754200-3.pdf'),(18,25,NULL,'CRLV_859754200-3.pdf','30_25_miolo.pdf','2026-07-17 01:48:55','/var/www/html/public/artes/2026/07/17/30/30_25_miolo.pdf','tmp/CRLV_859754200-3.pdf'),(19,26,NULL,'CRLV_859754200-3.pdf','31_26_frente.pdf','2026-07-17 01:49:19','/var/www/html/public/artes/2026/07/17/31/31_26_frente.pdf','tmp/CRLV_859754200-3.pdf'),(20,26,NULL,'CRLV_859754200-3.pdf','31_26_miolo.pdf','2026-07-17 01:49:19','/var/www/html/public/artes/2026/07/17/31/31_26_miolo.pdf','tmp/CRLV_859754200-3.pdf');
/*!40000 ALTER TABLE `tb_pedidos_itens_arquivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_perfil`
--

DROP TABLE IF EXISTS `tb_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_perfil` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `perfil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descricao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_perfil`
--

LOCK TABLES `tb_perfil` WRITE;
/*!40000 ALTER TABLE `tb_perfil` DISABLE KEYS */;
INSERT INTO `tb_perfil` VALUES (1,'Usuario','Usuário comum'),(3,'Baixa','Operador Baixa'),(4,'Bureau','Operador Bureau'),(5,'Orcamentista','Pessoa Orçamentista'),(99,'Admin','Administrador');
/*!40000 ALTER TABLE `tb_perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_produtos`
--

DROP TABLE IF EXISTS `tb_produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_produtos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_produtos`
--

LOCK TABLES `tb_produtos` WRITE;
/*!40000 ALTER TABLE `tb_produtos` DISABLE KEYS */;
INSERT INTO `tb_produtos` VALUES (1,'Caderno'),(2,'Livro');
/*!40000 ALTER TABLE `tb_produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_produtos_componentes`
--

DROP TABLE IF EXISTS `tb_produtos_componentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_produtos_componentes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `produto_id` int unsigned DEFAULT NULL,
  `componente_id` int unsigned DEFAULT NULL,
  `requerido` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produto_id` (`produto_id`),
  KEY `componente_id` (`componente_id`),
  CONSTRAINT `tb_produtos_componentes_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `tb_produtos` (`id`),
  CONSTRAINT `tb_produtos_componentes_ibfk_2` FOREIGN KEY (`componente_id`) REFERENCES `tb_componentes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_produtos_componentes`
--

LOCK TABLES `tb_produtos_componentes` WRITE;
/*!40000 ALTER TABLE `tb_produtos_componentes` DISABLE KEYS */;
INSERT INTO `tb_produtos_componentes` VALUES (1,1,1,1),(2,1,7,1),(4,2,1,1),(5,2,2,1);
/*!40000 ALTER TABLE `tb_produtos_componentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_produtos_componentes_extensoes`
--

DROP TABLE IF EXISTS `tb_produtos_componentes_extensoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_produtos_componentes_extensoes` (
  `produto_componente_id` int unsigned DEFAULT NULL,
  `extensao_id` int unsigned DEFAULT NULL,
  KEY `produto_componente_id` (`produto_componente_id`),
  KEY `extensao_id` (`extensao_id`),
  CONSTRAINT `tb_produtos_componentes_extensoes_ibfk_1` FOREIGN KEY (`produto_componente_id`) REFERENCES `tb_produtos_componentes` (`id`),
  CONSTRAINT `tb_produtos_componentes_extensoes_ibfk_2` FOREIGN KEY (`extensao_id`) REFERENCES `tb_extensoes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_produtos_componentes_extensoes`
--

LOCK TABLES `tb_produtos_componentes_extensoes` WRITE;
/*!40000 ALTER TABLE `tb_produtos_componentes_extensoes` DISABLE KEYS */;
INSERT INTO `tb_produtos_componentes_extensoes` VALUES (1,1),(1,2),(2,2);
/*!40000 ALTER TABLE `tb_produtos_componentes_extensoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_projetos`
--

DROP TABLE IF EXISTS `tb_projetos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_projetos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ativo',
  `arquivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_projetos`
--

LOCK TABLES `tb_projetos` WRITE;
/*!40000 ALTER TABLE `tb_projetos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_projetos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_sessions`
--

DROP TABLE IF EXISTS `tb_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `tb_sessions_user_id_index` (`user_id`) USING BTREE,
  KEY `tb_sessions_last_activity_index` (`last_activity`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_sessions`
--

LOCK TABLES `tb_sessions` WRITE;
/*!40000 ALTER TABLE `tb_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_status_pedido`
--

DROP TABLE IF EXISTS `tb_status_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_status_pedido` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `descricao_site` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `ordem` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_status_pedido`
--

LOCK TABLES `tb_status_pedido` WRITE;
/*!40000 ALTER TABLE `tb_status_pedido` DISABLE KEYS */;
INSERT INTO `tb_status_pedido` VALUES (1,'Ok','Aguardando Pagamento',1,1),(2,'Aguardando Pagamento','Aguardando Pagamento',1,2),(3,'Em Processamento','Produção',1,3),(4,'Pronto para Retirada','Disponível para retidada',1,4),(5,'Em Transporte / Saiu para Entrega','Saiu para entrega',1,5),(6,'Entregue','Entregue',1,6);
/*!40000 ALTER TABLE `tb_status_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_status_pedido_item`
--

DROP TABLE IF EXISTS `tb_status_pedido_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_status_pedido_item` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `descricao_site` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `ordem` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_status_pedido_item`
--

LOCK TABLES `tb_status_pedido_item` WRITE;
/*!40000 ALTER TABLE `tb_status_pedido_item` DISABLE KEYS */;
INSERT INTO `tb_status_pedido_item` VALUES (1,'Ok','Recebido',1,NULL),(2,'Aguardando Arquivo','Aguardando Arquivo',1,NULL),(3,'Em Análise de Arte (Pré-impressão)','Em Análise de Arte (Pré-impressão)',1,NULL),(4,'Correção Solicitada','Correção Solicitada',1,NULL),(5,'Aprovado para Produção','Produção',1,NULL),(6,'Em Impressão','Produção',1,NULL),(7,'Em Acabamento','Produção',1,NULL),(8,'Pronto (Aguardando Agrupamento)','Pronto (Aguardando Agrupamento)',1,NULL),(9,'Pronto','Pronto',1,NULL);
/*!40000 ALTER TABLE `tb_status_pedido_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tamanhos`
--

DROP TABLE IF EXISTS `tb_tamanhos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_tamanhos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tamanho_real` varchar(255) DEFAULT NULL,
  `tamanho_com_sangra` varchar(255) DEFAULT NULL,
  `produto_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produto_id` (`produto_id`),
  CONSTRAINT `tb_tamanhos_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `tb_produtos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tamanhos`
--

LOCK TABLES `tb_tamanhos` WRITE;
/*!40000 ALTER TABLE `tb_tamanhos` DISABLE KEYS */;
INSERT INTO `tb_tamanhos` VALUES (1,'300x200','300x200',1),(2,'200x200','3200x200',2);
/*!40000 ALTER TABLE `tb_tamanhos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tipo_endereco`
--

DROP TABLE IF EXISTS `tb_tipo_endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_tipo_endereco` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tipo_endereco`
--

LOCK TABLES `tb_tipo_endereco` WRITE;
/*!40000 ALTER TABLE `tb_tipo_endereco` DISABLE KEYS */;
INSERT INTO `tb_tipo_endereco` VALUES (1,'Comercial'),(2,'Residencial'),(3,'Faturamento'),(4,'Entrega');
/*!40000 ALTER TABLE `tb_tipo_endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_usuarios`
--

DROP TABLE IF EXISTS `tb_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_usuarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nivel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'usuario',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '1' COMMENT '[1 Ativo / 0 Inativo ]',
  `cpf_cnpj` varchar(15) DEFAULT NULL,
  `ie` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `tb_usuarios_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_usuarios`
--

LOCK TABLES `tb_usuarios` WRITE;
/*!40000 ALTER TABLE `tb_usuarios` DISABLE KEYS */;
INSERT INTO `tb_usuarios` VALUES (9,'Luis','teste@teste.com',NULL,'$2y$12$WFomLjXuYjSSJiua1tR5aO2iOCS/qjh0xnKtpv2y1tT26c1YsfEC2',NULL,'2026-06-22 15:47:20','2026-06-22 15:47:20','99','1',NULL,NULL),(10,'admin@local.com','admin@local.com',NULL,'$2y$12$PV5jod6TLTmBYJi6MA7h7.fwpBeOwMbMDWIpqpInUUUhLWSOCMi.W',NULL,'2026-06-29 00:00:45','2026-07-08 21:05:15','99','1','111.222.333-11','23fd');
/*!40000 ALTER TABLE `tb_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries`
--

DROP TABLE IF EXISTS `telescope_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telescope_entries` (
  `sequence` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `batch_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `family_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sequence`) USING BTREE,
  UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`) USING BTREE,
  KEY `telescope_entries_batch_id_index` (`batch_id`) USING BTREE,
  KEY `telescope_entries_family_hash_index` (`family_hash`) USING BTREE,
  KEY `telescope_entries_created_at_index` (`created_at`) USING BTREE,
  KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries`
--

LOCK TABLES `telescope_entries` WRITE;
/*!40000 ALTER TABLE `telescope_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries_tags`
--

DROP TABLE IF EXISTS `telescope_entries_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`entry_uuid`,`tag`) USING BTREE,
  KEY `telescope_entries_tags_tag_index` (`tag`) USING BTREE,
  CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries_tags`
--

LOCK TABLES `telescope_entries_tags` WRITE;
/*!40000 ALTER TABLE `telescope_entries_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_entries_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_monitoring`
--

DROP TABLE IF EXISTS `telescope_monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`tag`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_monitoring`
--

LOCK TABLES `telescope_monitoring` WRITE;
/*!40000 ALTER TABLE `telescope_monitoring` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_monitoring` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-17 19:33:36
