SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2026_06_01_230314_create_telescope_entries_table', 1);
INSERT INTO `migrations` VALUES (5, '2026_06_03_014907_create_projetos_table', 1);
INSERT INTO `migrations` VALUES (6, '2026_06_04_134146_create_menu_table', 1);
INSERT INTO `migrations` VALUES (7, '2026_06_09_000001_create_acl_table', 1);
INSERT INTO `migrations` VALUES (8, '2026_06_16_010919_cadastro', 1);

-- ----------------------------
-- Table structure for tb_cache
-- ----------------------------
DROP TABLE IF EXISTS `tb_cache`;
CREATE TABLE `tb_cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_cache
-- ----------------------------

-- ----------------------------
-- Table structure for tb_cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `tb_cache_locks`;
CREATE TABLE `tb_cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for tb_cadastro
-- ----------------------------
DROP TABLE IF EXISTS `tb_cadastro`;
CREATE TABLE `tb_cadastro`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tb_cadastro_email_unique`(`email` ASC) USING BTREE,
  UNIQUE INDEX `tb_cadastro_cpf_cnpj_unique`(`cpf_cnpj` ASC) USING BTREE,
  UNIQUE INDEX `tb_cadastro_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_cadastro
-- ----------------------------

-- ----------------------------
-- Table structure for tb_failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `tb_failed_jobs`;
CREATE TABLE `tb_failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tb_failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for tb_job_batches
-- ----------------------------
DROP TABLE IF EXISTS `tb_job_batches`;
CREATE TABLE `tb_job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for tb_jobs
-- ----------------------------
DROP TABLE IF EXISTS `tb_jobs`;
CREATE TABLE `tb_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tb_jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for tb_menus
-- ----------------------------
DROP TABLE IF EXISTS `tb_menus`;
CREATE TABLE `tb_menus`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '#',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `ordem` int NOT NULL DEFAULT 0,
  `nivel_permissao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'usuario',
  `menu_pai_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tb_menus_menu_pai_id_foreign`(`menu_pai_id` ASC) USING BTREE,
  CONSTRAINT `tb_menus_menu_pai_id_foreign` FOREIGN KEY (`menu_pai_id`) REFERENCES `tb_menus` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_menus
-- ----------------------------
INSERT INTO `tb_menus` VALUES (1, 'Pedidos', '#', 'bi-cart', 1, '[1]', NULL, '2026-06-22 14:57:43', '2026-06-22 14:57:43');
INSERT INTO `tb_menus` VALUES (2, 'Nacionais', '#', 'bi-flag', 1, '[1]', 1, '2026-06-22 14:57:43', '2026-06-22 14:57:43');
INSERT INTO `tb_menus` VALUES (3, 'Vendas Próprias', '/pedidos/nacionais/proprias', 'bi-dot', 1, '[1]', 2, '2026-06-22 14:57:43', '2026-06-22 14:57:43');
INSERT INTO `tb_menus` VALUES (4, 'Revenda', '/pedidos/nacionais/revenda', 'bi-dot', 2, '[1]', 2, '2026-06-22 14:57:43', '2026-06-22 14:57:43');
INSERT INTO `tb_menus` VALUES (5, 'Sistema', '#', 'bi-sliders', 2, '[1]', NULL, '2026-06-22 14:57:43', '2026-06-22 14:57:43');
INSERT INTO `tb_menus` VALUES (6, 'Usuários', '#', 'bi-people', 1, '[1]', 5, '2026-06-22 14:57:43', '2026-06-22 14:57:43');
INSERT INTO `tb_menus` VALUES (7, 'Listar Todos', '/usuarios', 'bi-list-task', 1, '[1]', 6, '2026-06-22 14:57:43', '2026-06-22 14:57:43');
INSERT INTO `tb_menus` VALUES (8, 'Permissões (ACL)', '/usuarios/permissoes', 'bi-shield-lock', 2, '[1]', 6, '2026-06-22 14:57:43', '2026-06-22 14:57:43');

-- ----------------------------
-- Table structure for tb_nivel
-- ----------------------------
DROP TABLE IF EXISTS `tb_nivel`;
CREATE TABLE `tb_nivel`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `perfil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descricao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 100 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_nivel
-- ----------------------------
INSERT INTO `tb_nivel` VALUES (2, 'Usuario', 'Usuário comum');
INSERT INTO `tb_nivel` VALUES (3, 'Baixa', 'Operador Baixa');
INSERT INTO `tb_nivel` VALUES (4, 'Bureau', 'Operador Bureau');
INSERT INTO `tb_nivel` VALUES (5, 'Orcamentista', 'Pessoa Orçamentista');
INSERT INTO `tb_nivel` VALUES (99, 'Admin', 'Administrador');

-- ----------------------------
-- Table structure for tb_password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `tb_password_reset_tokens`;
CREATE TABLE `tb_password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for tb_projetos
-- ----------------------------
DROP TABLE IF EXISTS `tb_projetos`;
CREATE TABLE `tb_projetos`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ativo',
  `arquivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_projetos
-- ----------------------------

-- ----------------------------
-- Table structure for tb_sessions
-- ----------------------------
DROP TABLE IF EXISTS `tb_sessions`;
CREATE TABLE `tb_sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tb_sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `tb_sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_sessions
-- ----------------------------

-- ----------------------------
-- Table structure for tb_usuarios
-- ----------------------------
DROP TABLE IF EXISTS `tb_usuarios`;
CREATE TABLE `tb_usuarios`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nivel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'usuario',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'analise',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tb_usuarios_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_usuarios
-- ----------------------------
INSERT INTO `tb_usuarios` VALUES (9, 'Luis', 'teste@teste.com', NULL, '$2y$12$WFomLjXuYjSSJiua1tR5aO2iOCS/qjh0xnKtpv2y1tT26c1YsfEC2', NULL, '2026-06-22 15:47:20', '2026-06-22 15:47:20', '99', '1');

-- ----------------------------
-- Table structure for telescope_entries
-- ----------------------------
DROP TABLE IF EXISTS `telescope_entries`;
CREATE TABLE `telescope_entries`  (
  `sequence` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `batch_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `family_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`sequence`) USING BTREE,
  UNIQUE INDEX `telescope_entries_uuid_unique`(`uuid` ASC) USING BTREE,
  INDEX `telescope_entries_batch_id_index`(`batch_id` ASC) USING BTREE,
  INDEX `telescope_entries_family_hash_index`(`family_hash` ASC) USING BTREE,
  INDEX `telescope_entries_created_at_index`(`created_at` ASC) USING BTREE,
  INDEX `telescope_entries_type_should_display_on_index_index`(`type` ASC, `should_display_on_index` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of telescope_entries
-- ----------------------------

-- ----------------------------
-- Table structure for telescope_entries_tags
-- ----------------------------
DROP TABLE IF EXISTS `telescope_entries_tags`;
CREATE TABLE `telescope_entries_tags`  (
  `entry_uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`entry_uuid`, `tag`) USING BTREE,
  INDEX `telescope_entries_tags_tag_index`(`tag` ASC) USING BTREE,
  CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of telescope_entries_tags
-- ----------------------------

-- ----------------------------
-- Table structure for telescope_monitoring
-- ----------------------------
DROP TABLE IF EXISTS `telescope_monitoring`;
CREATE TABLE `telescope_monitoring`  (
  `tag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`tag`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of telescope_monitoring
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
