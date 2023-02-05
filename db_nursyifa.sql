/*
 Navicat Premium Data Transfer

 Source Server         : MySql Local
 Source Server Type    : MySQL
 Source Server Version : 100422
 Source Host           : localhost:3306
 Source Schema         : db_laravel

 Target Server Type    : MySQL
 Target Server Version : 100422
 File Encoding         : 65001

 Date: 30/08/2022 16:25:28
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for tb_m_menu
-- ----------------------------
DROP TABLE IF EXISTS `tb_m_menu`;
CREATE TABLE `tb_m_menu`  (
  `MENU_ID` int NOT NULL AUTO_INCREMENT,
  `MENU_NAME` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `MENU_ICON` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `MENU_URL` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `PARENT_ID` int NULL DEFAULT NULL,
  `SEQUENCE` int NULL DEFAULT NULL,
  `CREATED_BY` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `CREATED_DATE` datetime NULL DEFAULT NULL,
  `UPDATED_BY` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `UPDATED_DATE` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`MENU_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 237 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_m_menu
-- ----------------------------
INSERT INTO `tb_m_menu` VALUES (1, 'Dashboard', 'fa fa-dashboard', 'menu', 0, 1, 'admin', '2022-06-02 15:40:33', 'admin', '2022-08-05 23:45:50');
INSERT INTO `tb_m_menu` VALUES (2, 'Settings', 'fa fa-gears', 'setting', 0, 10, 'admin', '2022-08-05 09:58:39', 'admin', '2022-08-05 23:54:20');
INSERT INTO `tb_m_menu` VALUES (3, 'Menu', 'bi-archive-fill', 'menu', 2, 1, 'admin', '2022-08-05 09:59:03', 'admin', '2022-08-05 09:59:03');
INSERT INTO `tb_m_menu` VALUES (4, 'Role Permission', 'bi-archive-fill', 'role', 2, 2, 'admin', '2022-08-05 09:59:26', 'admin', '2022-08-05 09:59:26');
INSERT INTO `tb_m_menu` VALUES (5, 'System', 'bi-archive-fill', 'system', 2, 3, 'admin', '2022-08-05 09:59:47', 'admin', '2022-08-05 09:59:47');
INSERT INTO `tb_m_menu` VALUES (235, 'Master', 'fa fa-database', 'user', 0, 2, 'admin', '2022-08-06 12:14:40', 'admin', '2022-08-06 12:14:40');
INSERT INTO `tb_m_menu` VALUES (236, 'Users', 'fa fa-user', 'user', 235, 1, 'admin', '2022-08-06 12:15:14', 'admin', '2022-08-06 12:15:14');

-- ----------------------------
-- Table structure for tb_m_permission
-- ----------------------------
DROP TABLE IF EXISTS `tb_m_permission`;
CREATE TABLE `tb_m_permission`  (
  `ROLE_ID` int NOT NULL,
  `MENU_ID` int NOT NULL,
  `CREATED_DATE` datetime NULL DEFAULT NULL,
  `CREATED_BY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `UPDATED_DATE` datetime NULL DEFAULT NULL,
  `UPDATED_BY` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ROLE_ID`, `MENU_ID`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_m_permission
-- ----------------------------
INSERT INTO `tb_m_permission` VALUES (1, 2, '2022-08-06 12:15:34', 'admin', '2022-08-06 12:15:34', 'admin');
INSERT INTO `tb_m_permission` VALUES (1, 3, '2022-08-06 12:15:34', 'admin', '2022-08-06 12:15:34', 'admin');
INSERT INTO `tb_m_permission` VALUES (1, 4, '2022-08-06 12:15:34', 'admin', '2022-08-06 12:15:34', 'admin');
INSERT INTO `tb_m_permission` VALUES (1, 5, '2022-08-06 12:15:34', 'admin', '2022-08-06 12:15:34', 'admin');
INSERT INTO `tb_m_permission` VALUES (1, 235, '2022-08-06 12:15:34', 'admin', '2022-08-06 12:15:34', 'admin');
INSERT INTO `tb_m_permission` VALUES (1, 236, '2022-08-06 12:15:34', 'admin', '2022-08-06 12:15:34', 'admin');
INSERT INTO `tb_m_permission` VALUES (2, 1, '2022-08-05 16:29:48', 'admin', '2022-08-05 16:29:48', 'admin');
INSERT INTO `tb_m_permission` VALUES (2, 2, '2022-08-05 16:29:48', 'admin', '2022-08-05 16:29:48', 'admin');
INSERT INTO `tb_m_permission` VALUES (2, 3, '2022-08-05 16:29:48', 'admin', '2022-08-05 16:29:48', 'admin');
INSERT INTO `tb_m_permission` VALUES (2, 4, '2022-08-05 16:29:48', 'admin', '2022-08-05 16:29:48', 'admin');
INSERT INTO `tb_m_permission` VALUES (2, 5, '2022-08-05 16:29:48', 'admin', '2022-08-05 16:29:48', 'admin');

-- ----------------------------
-- Table structure for tb_m_role
-- ----------------------------
DROP TABLE IF EXISTS `tb_m_role`;
CREATE TABLE `tb_m_role`  (
  `ROLE_ID` int NOT NULL AUTO_INCREMENT,
  `ROLE_NAME` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ROLE_DESC` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `CREATED_BY` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `CREATED_DATE` datetime NULL DEFAULT NULL,
  `UPDATED_BY` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `UPDATED_DATE` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`ROLE_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_m_role
-- ----------------------------
INSERT INTO `tb_m_role` VALUES (1, 'Super Admin', 'Super Admin Website', 'admin', '2022-08-05 10:52:15', 'admin', '2022-08-05 10:52:15');
INSERT INTO `tb_m_role` VALUES (2, 'Administrator', 'Admin Website', 'admin', '2022-08-05 07:09:29', 'admin', '2022-08-05 10:13:39');

-- ----------------------------
-- Table structure for tb_m_system
-- ----------------------------
DROP TABLE IF EXISTS `tb_m_system`;
CREATE TABLE `tb_m_system`  (
  `SYSTEM_TYPE` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `SYSTEM_CD` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `SYSTEM_VAL` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `SYSTEM_DESC` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `CREATED_BY` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `CREATED_DATE` datetime NULL DEFAULT NULL,
  `UPDATED_BY` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `UPDATED_DATE` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`SYSTEM_TYPE`, `SYSTEM_CD`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_m_system
-- ----------------------------

-- ----------------------------
-- Table structure for tb_m_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_m_user`;
CREATE TABLE `tb_m_user`  (
  `USER_ID` int NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `PASSWORD` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `FULL_NAME` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `EMAIL` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `PHONE` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ADDRESS` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ROLE_ID` int NULL DEFAULT NULL,
  `CREATED_BY` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `CREATED_DATE` datetime NULL DEFAULT NULL,
  `UPDATED_BY` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `UPDATED_DATE` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`USER_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_m_user
-- ----------------------------
INSERT INTO `tb_m_user` VALUES (1, 'admin', '$2a$12$xrWvgqa3VvkVR2yv8HL0Cug/kBBHao29nzmap5jmVE8Cq82ymUAhi', 'Administrator', 'hafidzms92@gmail.com', NULL, NULL, NULL, NULL, 1, 'admin', '2022-05-20 16:26:16', NULL, NULL);
INSERT INTO `tb_m_user` VALUES (8, 'admin2', '$2y$10$yH9/zvPJe9qUqE6fK/lDEunRKD86JIBweBellMrHiId9a66OCvKRS', 'Admin Saya Bundar', 'admin2@gmail.com', NULL, NULL, NULL, NULL, 1, 'admin', '2022-08-11 10:58:11', 'admin', '2022-08-11 10:58:11');
INSERT INTO `tb_m_user` VALUES (9, 'admin3', '$2y$10$Q8Q6bFoxsSNBwpTzsxAv2Oig6xZgdFBdQ1JikHU9NQNBmWNznCKUC', 'Admin Saya Bundar', 'admin3@gmail.com', NULL, NULL, NULL, NULL, 1, 'admin', '2022-08-11 10:58:37', 'admin', '2022-08-11 10:58:37');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', 'admin@gmail.com', NULL, '$2y$10$Rs1rYEVodU.vj8BKvUAmruqFtnXnz6iqakEFe4uKTGfpqXhNkeNdy', NULL, '2022-07-27 05:38:00', '2022-07-27 05:38:00');

SET FOREIGN_KEY_CHECKS = 1;
