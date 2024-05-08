-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para eldespiste
CREATE DATABASE IF NOT EXISTS `eldespiste` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `eldespiste`;

-- Volcando estructura para tabla eldespiste.composicion_productos
CREATE TABLE IF NOT EXISTS `composicion_productos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `id_componente` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.composicion_productos: ~2 rows (aproximadamente)
DELETE FROM `composicion_productos`;
INSERT INTO `composicion_productos` (`id`, `id_producto`, `id_componente`, `created_at`, `updated_at`) VALUES
	(34, 1, 3, '2024-05-01 19:38:22', '2024-05-01 19:38:22'),
	(35, 1, 4, '2024-05-01 19:38:22', '2024-05-01 19:38:22');

-- Volcando estructura para tabla eldespiste.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
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

-- Volcando datos para la tabla eldespiste.failed_jobs: ~0 rows (aproximadamente)
DELETE FROM `failed_jobs`;

-- Volcando estructura para tabla eldespiste.familias
CREATE TABLE IF NOT EXISTS `familias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posicion` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.familias: ~2 rows (aproximadamente)
DELETE FROM `familias`;
INSERT INTO `familias` (`id`, `nombre`, `imagen`, `posicion`, `created_at`, `updated_at`) VALUES
	(15, 'Combinados', '1706018244.png', 1, '2024-01-23 12:57:24', '2024-01-23 12:57:24'),
	(16, 'Licores', '1706022016.png', 2, '2024-01-23 14:00:16', '2024-01-23 14:00:16'),
	(17, 'Aperitivos', '1706895368.png', 3, '2024-02-02 16:36:08', '2024-02-02 16:36:08'),
	(18, 'Refrescos', '1713101057.png', 4, '2024-04-14 11:24:17', '2024-04-14 11:24:17');

-- Volcando estructura para tabla eldespiste.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.migrations: ~7 rows (aproximadamente)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_100000_create_password_resets_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2024_01_17_213609_crear_tabla_familias', 2),
	(7, '2024_01_21_00_crear_tabla_productos_y_actualizar_tabla_usuarios', 3),
	(8, '2024_01_24_141438_create_permission_tables', 4),
	(9, '2024_04_14_133037_crear_tabla_composicion_productos', 5),
	(10, '2024_05_04_205935_crear_tabla_servicios', 6),
	(11, '2024_05_05_000015_crear_tabla_permisos_usuarios', 7);

-- Volcando estructura para tabla eldespiste.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.model_has_permissions: ~0 rows (aproximadamente)
DELETE FROM `model_has_permissions`;

-- Volcando estructura para tabla eldespiste.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.model_has_roles: ~0 rows (aproximadamente)
DELETE FROM `model_has_roles`;

-- Volcando estructura para tabla eldespiste.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.password_resets: ~0 rows (aproximadamente)
DELETE FROM `password_resets`;

-- Volcando estructura para tabla eldespiste.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.password_reset_tokens: ~0 rows (aproximadamente)
DELETE FROM `password_reset_tokens`;

-- Volcando estructura para tabla eldespiste.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.permissions: ~16 rows (aproximadamente)
DELETE FROM `permissions`;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Ver usuarios', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(2, 'Crear usuarios', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(3, 'Editar usuarios', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(4, 'Borrar usuarios', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(5, 'Ver familias', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(6, 'Crear familias', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(7, 'Editar familias', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(8, 'Borrar familias', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(9, 'Ver productos', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(10, 'Crear productos', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(11, 'Editar productos', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(12, 'Borrar productos', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(13, 'Ver servicios', 'web', '2024-01-24 13:58:55', '2024-01-24 13:58:55'),
	(14, 'Crear servicios', 'web', '2024-01-24 13:58:56', '2024-01-24 13:58:56'),
	(15, 'Editar servicios', 'web', '2024-01-24 13:58:56', '2024-01-24 13:58:56'),
	(16, 'Borrar servicios', 'web', '2024-01-24 13:58:56', '2024-01-24 13:58:56');

-- Volcando estructura para tabla eldespiste.permission_user
CREATE TABLE IF NOT EXISTS `permission_user` (
  `user_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `permission_user_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.permission_user: ~0 rows (aproximadamente)
DELETE FROM `permission_user`;

-- Volcando estructura para tabla eldespiste.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.personal_access_tokens: ~0 rows (aproximadamente)
DELETE FROM `personal_access_tokens`;

-- Volcando estructura para tabla eldespiste.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posicion` int NOT NULL,
  `familia` int NOT NULL,
  `combinado` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.productos: ~4 rows (aproximadamente)
DELETE FROM `productos`;
INSERT INTO `productos` (`id`, `nombre`, `imagen`, `posicion`, `familia`, `combinado`, `precio`, `created_at`, `updated_at`) VALUES
	(1, 'Absolut - Limón', '1706020700.png', 1, 15, 1, 0.00, '2024-01-23 13:38:20', '2024-01-24 12:54:21'),
	(2, 'Croquetas hongos (4u)', '1706895471.png', 1, 17, 0, 2.00, '2024-02-02 16:37:51', '2024-02-02 16:37:51'),
	(3, 'Absolut', '1713101109.png', 1, 16, 0, 1.57, '2024-04-14 11:25:09', '2024-04-14 11:25:09'),
	(4, 'Kas Limón', '1713101136.png', 3, 18, 0, 0.83, '2024-04-14 11:25:36', '2024-04-14 11:25:36');

-- Volcando estructura para tabla eldespiste.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.roles: ~2 rows (aproximadamente)
DELETE FROM `roles`;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Administrador', 'web', '2024-01-24 13:58:28', '2024-01-24 13:58:28'),
	(2, 'Socio', 'web', '2024-01-24 13:58:28', '2024-01-24 13:58:28');

-- Volcando estructura para tabla eldespiste.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.role_has_permissions: ~16 rows (aproximadamente)
DELETE FROM `role_has_permissions`;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(15, 1),
	(16, 1);

-- Volcando estructura para tabla eldespiste.role_user
CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`) USING BTREE,
  KEY `user_has_role_id_foreign` (`role_id`) USING BTREE,
  CONSTRAINT `user_has_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_has_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla eldespiste.role_user: ~0 rows (aproximadamente)
DELETE FROM `role_user`;
INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
	(1, 1);

-- Volcando estructura para tabla eldespiste.servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posicion` int NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.servicios: ~0 rows (aproximadamente)
DELETE FROM `servicios`;
INSERT INTO `servicios` (`id`, `nombre`, `posicion`, `precio`, `created_at`, `updated_at`) VALUES
	(1, 'Uso de cocina', 1, 2.00, NULL, '2024-05-04 19:55:24'),
	(2, 'Uso de cocina externo', 2, 5.00, '2024-05-04 19:22:22', '2024-05-04 19:22:22');

-- Volcando estructura para tabla eldespiste.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.users: ~1 rows (aproximadamente)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `image`, `role_id`, `phone_number`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'David Gómez', 'davgomruiz@gmail.com', '1714867019.jpg', 1, '658907397', NULL, '$2y$12$cqXmc.RdZs43RvaGmp87BOgAnd3QmmnQLfZxfZpGT0gYFIvWbJrDC', '6lBfPKpmrhHH0HuJNk1bwg85NYnwqc434n6spbyuOvP9Sy1hU64HoLA5VfDJ', '2023-11-29 13:26:44', '2024-05-04 21:56:59'),
	(3, 'Alberto Amigot', 'grillomusicrecords@hotmail.com', '1714867322.jpg', 2, '677882882', NULL, '$2y$12$5fIFc6EUChvbLA2TptAM1.AtZ2xdbyCq8GIUXIMZhJZuB2RIhnzva', NULL, '2024-05-04 22:02:03', '2024-05-04 22:02:03');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
