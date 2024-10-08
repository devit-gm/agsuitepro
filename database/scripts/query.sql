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


-- Volcando estructura de base de datos para agsuite
CREATE DATABASE IF NOT EXISTS `agsuite` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `agsuite`;

-- Volcando estructura para tabla agsuite.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla agsuite.licenses
CREATE TABLE IF NOT EXISTS `licenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `site_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `license_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` date NOT NULL,
  `actived` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `licenses_license_key_unique` (`license_key`),
  KEY `licenses_site_id_foreign` (`site_id`),
  KEY `licenses_user_id_foreign` (`user_id`),
  CONSTRAINT `licenses_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sitios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `licenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.licenses: ~1 rows (aproximadamente)
INSERT INTO `licenses` (`id`, `site_id`, `user_id`, `license_key`, `expires_at`, `actived`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, '4D2A7E9B8C5F1A0D', '2024-07-09', 1, '2024-06-10 17:41:11', '2024-06-10 16:02:56'),
	(9, 2, 15, 'DF9929B5C5844D8E', '2025-06-12', 1, '2024-06-12 17:40:44', '2024-06-12 19:08:13');

-- Volcando estructura para tabla agsuite.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.model_has_permissions: ~0 rows (aproximadamente)

-- Volcando estructura para tabla agsuite.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.model_has_roles: ~0 rows (aproximadamente)

-- Volcando estructura para tabla agsuite.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.password_resets: ~0 rows (aproximadamente)

-- Volcando estructura para tabla agsuite.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.password_reset_tokens: ~1 rows (aproximadamente)

-- Volcando estructura para tabla agsuite.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.permissions: ~16 rows (aproximadamente)
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

-- Volcando estructura para tabla agsuite.permission_user
CREATE TABLE IF NOT EXISTS `permission_user` (
  `user_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `permission_user_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.permission_user: ~0 rows (aproximadamente)

-- Volcando estructura para tabla agsuite.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.personal_access_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla agsuite.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.roles: ~4 rows (aproximadamente)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'SuperAdmin', 'web', '2024-06-07 19:48:07', '2024-06-07 19:48:08'),
	(2, 'Administrador', 'web', '2024-01-24 13:58:28', '2024-01-24 13:58:28'),
	(3, 'Secretario', 'web', '2024-06-07 19:47:30', '2024-06-07 19:47:31'),
	(4, 'Socio', 'web', '2024-01-24 13:58:28', '2024-01-24 13:58:28');

-- Volcando estructura para tabla agsuite.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.role_has_permissions: ~0 rows (aproximadamente)

-- Volcando estructura para tabla agsuite.role_user
CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`) USING BTREE,
  KEY `user_has_role_id_foreign` (`role_id`) USING BTREE,
  CONSTRAINT `user_has_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_has_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla agsuite.role_user: ~1 rows (aproximadamente)
INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
	(1, 1);

-- Volcando estructura para tabla agsuite.sitios
CREATE TABLE IF NOT EXISTS `sitios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dominio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruta_logo_nav` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruta_estilos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_host` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `central` tinyint(1) DEFAULT '0',
  `favicon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sitios_dominio_unique` (`dominio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.sitios: ~2 rows (aproximadamente)
INSERT INTO `sitios` (`id`, `nombre`, `dominio`, `ruta_logo`, `ruta_logo_nav`, `ruta_estilos`, `db_host`, `db_name`, `db_user`, `db_password`, `central`, `favicon`, `created_at`, `updated_at`) VALUES
	(1, 'GastroManager Plus', 'localhost', 'images\\logo.png', 'images\\logo-nav.png', 'css\\app.css', '127.0.0.1', 'agsuite', 'root', '', 1, '/images/favicon', '2024-06-07 14:01:52', '2024-06-07 14:01:53'),
	(2, 'El Despiste', '192.168.1.133', 'images\\logo-despiste.png', 'images\\logo-despiste-nav.png', 'css\\eldespiste.css', '127.0.0.1', 'eldespiste', 'root', '', 0, '/images/favicon-eldespiste', '2024-06-06 20:40:57', '2024-06-06 20:40:58');

-- Volcando estructura para tabla agsuite.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.users: ~1 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `image`, `role_id`, `phone_number`, `email_verified_at`, `password`, `remember_token`, `site_id`, `created_at`, `updated_at`) VALUES
	(1, 'David Gómez', 'dgomez@jofemar.com', '1717279293.jpg', 1, '34658907397', NULL, '$2y$12$yZLcQ1OAeTQuRJTa0ygIiek711UrYgNS4ouKXnVU/mvaqb/xzMgSC', 'xVXUV9Q6nnN9bbiw2z1z8f2i4cVxkp6dsAozq5OTypLNUtzmGGJKZq59uUwt', 2, '2023-11-29 13:26:44', '2024-06-12 17:38:49'),
	(15, 'David Socio', 'davgomruiz@gmail.com', '1718221244.jpg', 1, '658907397', NULL, '$2y$12$3pdE65GtAk8MMGdCv/R.xO2QoYmK6wn1O6WI5TznKLNq.an1gJTwa', NULL, 2, '2024-06-12 17:40:44', '2024-06-12 17:40:44');


-- Volcando estructura de base de datos para eldespiste
CREATE DATABASE IF NOT EXISTS `eldespiste` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `eldespiste`;

-- Volcando estructura para tabla eldespiste.ajustes
CREATE TABLE IF NOT EXISTS `ajustes` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_invitado` decimal(10,2) NOT NULL,
  `max_invitados_cobrar` int NOT NULL,
  `primer_invitado_gratis` int NOT NULL,
  `activar_invitados_grupo` int NOT NULL,
  `permitir_comprar_sin_stock` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.ajustes: ~0 rows (aproximadamente)
INSERT INTO `ajustes` (`id`, `precio_invitado`, `max_invitados_cobrar`, `primer_invitado_gratis`, `activar_invitados_grupo`, `permitir_comprar_sin_stock`, `created_at`, `updated_at`) VALUES
	('1', 1.00, 14, 1, 0, 1, '2024-06-04 20:59:46', '2024-06-10 19:40:02');

-- Volcando estructura para tabla eldespiste.composicion_productos
CREATE TABLE IF NOT EXISTS `composicion_productos` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_producto` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_componente` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.composicion_productos: ~2 rows (aproximadamente)
INSERT INTO `composicion_productos` (`uuid`, `id_producto`, `id_componente`, `created_at`, `updated_at`) VALUES
	('2e06a243-e04d-4e48-9843-9435e7313921', '324af123-f263-4246-965e-c3d6f5ec7d96', 'bf1adb6d-24ab-4358-95eb-45ba62973926', '2024-06-14 19:50:32', '2024-06-14 19:50:32'),
	('885d7c31-51b4-4599-b8ef-84c4d16c04ec', '324af123-f263-4246-965e-c3d6f5ec7d96', 'c588647f-f121-4ab8-8dd9-8e4430b972e3', '2024-06-14 19:50:32', '2024-06-14 19:50:32');

-- Volcando estructura para tabla eldespiste.familias
CREATE TABLE IF NOT EXISTS `familias` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posicion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.familias: ~3 rows (aproximadamente)
INSERT INTO `familias` (`uuid`, `nombre`, `imagen`, `posicion`, `created_at`, `updated_at`) VALUES
	('29a066b2-8a8d-4874-a774-ebd94218926e', 'Licores', '1717255002.png', '1', '2024-06-01 13:16:42', '2024-06-01 13:16:42'),
	('8309aa5e-2a14-40d2-ab9f-356a0138a1d7', 'Combinados', '1717357825.png', '4', '2024-06-02 17:50:25', '2024-06-02 17:50:25'),
	('86b87798-f1f0-4a62-a4e6-5ee98ecc5751', 'Refrescos', '1717357790.png', '3', '2024-06-02 17:49:50', '2024-06-02 17:49:50'),
	('96a3b68a-53e4-4fcd-88d2-cf283d01438d', 'Aperitivos', '1717357769.png', '2', '2024-06-02 17:49:29', '2024-06-02 17:49:29');

-- Volcando estructura para tabla eldespiste.fichas
CREATE TABLE IF NOT EXISTS `fichas` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `tipo` int NOT NULL,
  `estado` int NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invitados_grupo` int NOT NULL,
  `fecha` timestamp NOT NULL,
  `hora` time DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `menu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responsables` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE,
  KEY `fichas_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.fichas: ~3 rows (aproximadamente)
INSERT INTO `fichas` (`uuid`, `user_id`, `tipo`, `estado`, `descripcion`, `invitados_grupo`, `fecha`, `hora`, `precio`, `menu`, `responsables`, `created_at`, `updated_at`) VALUES
	('1ff3c3a0-9ce0-43d3-9adb-71303ad7ee84', 15, 3, 0, '', 0, '2024-09-07 22:00:00', '09:34:00', 0.00, NULL, NULL, '2024-09-08 05:34:33', '2024-09-08 05:34:33'),
	('593c073c-3115-483c-8887-4ba2d3803439', 15, 1, 0, '', 0, '2024-09-09 22:00:00', '17:39:00', 0.00, NULL, NULL, '2024-09-10 13:39:08', '2024-09-10 13:39:08'),
	('bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 1, 1, 1, 'Ficha de prueba individual', 0, '2024-06-13 22:00:00', '22:10:00', 59.00, NULL, NULL, '2024-06-14 18:11:04', '2024-06-14 18:13:34'),
	('cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 1, 1, 1, 'Ficha de prueba individual', 0, '2024-06-09 22:00:00', NULL, 16.00, NULL, NULL, '2024-06-10 19:10:15', '2024-06-10 19:35:51'),
	('e95199da-5e6a-4ffc-8650-604a8d52c467', 1, 1, 1, 'Evento', 0, '2024-06-15 22:00:00', '10:13:00', 2.80, NULL, NULL, '2024-06-16 06:13:49', '2024-06-16 06:19:27');

-- Volcando estructura para tabla eldespiste.fichas_gastos
CREATE TABLE IF NOT EXISTS `fichas_gastos` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ficha` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE,
  KEY `fichas_gastos_id_ficha_foreign` (`id_ficha`),
  KEY `FK_fichas_gastos_agsuite.users` (`user_id`),
  CONSTRAINT `fichas_gastos_id_ficha_foreign` FOREIGN KEY (`id_ficha`) REFERENCES `fichas` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.fichas_gastos: ~1 rows (aproximadamente)
INSERT INTO `fichas_gastos` (`uuid`, `id_ficha`, `user_id`, `descripcion`, `ticket`, `precio`, `created_at`, `updated_at`) VALUES
	('177a0d9f-6ce3-42ec-8a6c-8c93a0352323', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 1, 'Postre', '1718395986.png', 10.00, '2024-06-14 18:13:06', '2024-06-14 18:13:06'),
	('b3346212-524b-446f-9333-468ff025dba6', '1ff3c3a0-9ce0-43d3-9adb-71303ad7ee84', 15, 'gasto', '1725781064.jpg', 2.00, '2024-09-08 05:37:44', '2024-09-08 05:37:44');

-- Volcando estructura para tabla eldespiste.fichas_productos
CREATE TABLE IF NOT EXISTS `fichas_productos` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ficha` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_producto` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE,
  KEY `fichas_productos_id_ficha_foreign` (`id_ficha`),
  KEY `fichas_productos_id_producto_foreign` (`id_producto`),
  CONSTRAINT `fichas_productos_id_ficha_foreign` FOREIGN KEY (`id_ficha`) REFERENCES `fichas` (`uuid`) ON DELETE CASCADE,
  CONSTRAINT `fichas_productos_id_producto_foreign` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.fichas_productos: ~28 rows (aproximadamente)
INSERT INTO `fichas_productos` (`uuid`, `id_ficha`, `id_producto`, `cantidad`, `precio`, `created_at`, `updated_at`) VALUES
	('07e14088-a652-4bb4-aacb-dad58ab355d6', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', '324af123-f263-4246-965e-c3d6f5ec7d96', 1, 2.80, '2024-06-14 18:11:27', '2024-06-14 18:11:27'),
	('1048229a-6e16-4a6f-b772-70151a917b51', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 1, 1.00, '2024-06-10 19:31:39', '2024-06-10 19:31:39'),
	('25e2f1e0-75da-4339-a408-f19b88a5481d', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'c588647f-f121-4ab8-8dd9-8e4430b972e3', 1, 2.00, '2024-06-10 19:30:07', '2024-06-10 19:30:07'),
	('2edc5e30-cd0c-4c82-aa91-608d338b0c44', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', '324af123-f263-4246-965e-c3d6f5ec7d96', 1, 2.80, '2024-06-14 18:12:13', '2024-06-14 18:12:13'),
	('3a12e3a4-7707-45cd-b688-b4dfb8128c26', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 1, 1.00, '2024-06-10 19:31:39', '2024-06-10 19:31:39'),
	('3f097d49-e6eb-484f-a4ea-3ce76a9198e8', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 1, 1.00, '2024-06-10 19:32:15', '2024-06-10 19:32:15'),
	('422aa4ed-bc89-445b-88dc-27aeba13aabd', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'c588647f-f121-4ab8-8dd9-8e4430b972e3', 1, 2.00, '2024-06-10 19:30:07', '2024-06-10 19:30:07'),
	('46c3e7fc-a351-4d57-9a10-a6b630d582b8', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 'c588647f-f121-4ab8-8dd9-8e4430b972e3', 1, 2.00, '2024-06-14 18:12:26', '2024-06-14 18:12:26'),
	('48260178-3bc1-4852-877a-6bf7f3300c95', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 1, 1.00, '2024-06-10 19:32:15', '2024-06-10 19:32:15'),
	('5551a48a-3736-401e-97ad-d2ded3a9055e', '593c073c-3115-483c-8887-4ba2d3803439', 'c588647f-f121-4ab8-8dd9-8e4430b972e3', 1, 2.00, '2024-09-10 13:42:50', '2024-09-10 13:42:50'),
	('57ee902f-d315-46e6-8508-8a69a8cd4292', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 'bf1adb6d-24ab-4358-95eb-45ba62973926', 1, 0.80, '2024-06-14 18:12:21', '2024-06-14 18:12:21'),
	('59f94991-eab4-47fe-be73-91c60a53260e', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', '324af123-f263-4246-965e-c3d6f5ec7d96', 1, 2.80, '2024-06-14 18:12:13', '2024-06-14 18:12:13'),
	('5bb3b33e-db62-445e-928b-58a274247bbe', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 1, 1.00, '2024-06-10 19:31:39', '2024-06-10 19:31:39'),
	('63f7783b-2669-4d94-92d5-267f179b9e43', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 'f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 1, 1.00, '2024-06-14 18:11:16', '2024-06-14 18:11:16'),
	('7366e81d-26e4-491d-a37b-9c95a998e71d', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', '324af123-f263-4246-965e-c3d6f5ec7d96', 1, 2.80, '2024-06-14 18:12:13', '2024-06-14 18:12:13'),
	('79bbce9f-4b1b-48e6-81c2-d89e7932a106', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 'bf1adb6d-24ab-4358-95eb-45ba62973926', 1, 0.80, '2024-06-14 18:12:21', '2024-06-14 18:12:21'),
	('8a0cf920-a450-4973-a768-ebccd3f1909f', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 'c588647f-f121-4ab8-8dd9-8e4430b972e3', 1, 2.00, '2024-06-14 18:12:26', '2024-06-14 18:12:26'),
	('9a33214e-ecc7-4373-b2ad-59772a045a00', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 'c588647f-f121-4ab8-8dd9-8e4430b972e3', 1, 2.00, '2024-06-14 18:12:26', '2024-06-14 18:12:26'),
	('adf3b483-f1ee-48bf-9086-8db090ec4c88', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 'bf1adb6d-24ab-4358-95eb-45ba62973926', 1, 0.80, '2024-06-14 18:12:21', '2024-06-14 18:12:21'),
	('b3aa899f-61ac-440f-b430-b7365b1534c4', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 1, 1.00, '2024-06-10 19:31:39', '2024-06-10 19:31:39'),
	('b4de2b2b-1c08-458f-8678-d472a28ba24e', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', '324af123-f263-4246-965e-c3d6f5ec7d96', 1, 2.80, '2024-06-14 18:12:13', '2024-06-14 18:12:13'),
	('c9d1d13d-d06d-4c3e-9c69-ff57aa715e85', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 1, 1.00, '2024-06-10 19:24:20', '2024-06-10 19:24:20'),
	('cddc7208-7e40-48c5-8159-c35b1a0b3e8c', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 'bf1adb6d-24ab-4358-95eb-45ba62973926', 1, 0.80, '2024-06-14 18:11:09', '2024-06-14 18:11:09'),
	('ce0a8fbe-6f23-470a-9755-fa6e24f1fb44', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 1, 1.00, '2024-06-10 19:31:39', '2024-06-10 19:31:39'),
	('d685539f-ce6a-49ad-84b7-398cdb1d3f8e', '593c073c-3115-483c-8887-4ba2d3803439', 'f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 1, 1.00, '2024-09-10 13:42:30', '2024-09-10 13:42:30'),
	('dcd0a983-24c8-4ba9-aca4-39b58b12574a', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 'c588647f-f121-4ab8-8dd9-8e4430b972e3', 1, 2.00, '2024-06-14 18:11:22', '2024-06-14 18:11:22'),
	('e005333d-aa0a-424b-94b8-05da9717ba22', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', '324af123-f263-4246-965e-c3d6f5ec7d96', 1, 2.80, '2024-06-14 18:12:13', '2024-06-14 18:12:13'),
	('e4fd5b13-c75e-440c-bbcd-20999baf8b8f', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'c588647f-f121-4ab8-8dd9-8e4430b972e3', 1, 2.00, '2024-06-10 19:32:29', '2024-06-10 19:32:29'),
	('ecb9ffb2-bc59-434b-979a-2c1dfd6549ed', 'e95199da-5e6a-4ffc-8650-604a8d52c467', '324af123-f263-4246-965e-c3d6f5ec7d96', 1, 2.80, '2024-06-16 06:19:15', '2024-06-16 06:19:15'),
	('f074487c-d155-4e0e-9d9d-c4bc5f071a37', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 'c588647f-f121-4ab8-8dd9-8e4430b972e3', 1, 2.00, '2024-06-10 19:10:33', '2024-06-10 19:10:33');

-- Volcando estructura para tabla eldespiste.fichas_recibos
CREATE TABLE IF NOT EXISTS `fichas_recibos` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ficha` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `tipo` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL,
  `estado` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.fichas_recibos: ~3 rows (aproximadamente)
INSERT INTO `fichas_recibos` (`uuid`, `id_ficha`, `user_id`, `tipo`, `precio`, `fecha`, `estado`, `created_at`, `updated_at`) VALUES
	('7571f0af-12ec-42ac-853d-6700bab3306b', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 1, 1, 16.00, '2024-06-10 19:35:51', 1, '2024-06-10 19:35:51', '2024-06-14 18:15:05'),
	('a5f5458a-be2f-410c-9d74-4f2b3c88fe90', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 1, 2, 10.00, '2024-06-14 18:13:34', 1, '2024-06-14 18:13:34', '2024-06-14 18:15:05'),
	('effee6f0-f41e-4f9b-b5e1-06f951e1dfeb', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 1, 1, 59.00, '2024-06-14 18:13:34', 1, '2024-06-14 18:13:34', '2024-06-14 18:15:05'),
	('2883f363-a3dd-4479-8310-00b5015844b0', 'e95199da-5e6a-4ffc-8650-604a8d52c467', 1, 1, 2.80, '2024-06-16 06:19:27', 0, '2024-06-16 06:19:27', '2024-06-16 06:19:27');

-- Volcando estructura para tabla eldespiste.fichas_servicios
CREATE TABLE IF NOT EXISTS `fichas_servicios` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ficha` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_servicio` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE,
  KEY `fichas_servicios_id_ficha_foreign` (`id_ficha`),
  KEY `fichas_servicios_id_servicio_foreign` (`id_servicio`),
  CONSTRAINT `fichas_servicios_id_ficha_foreign` FOREIGN KEY (`id_ficha`) REFERENCES `fichas` (`uuid`) ON DELETE CASCADE,
  CONSTRAINT `fichas_servicios_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.fichas_servicios: ~2 rows (aproximadamente)
INSERT INTO `fichas_servicios` (`uuid`, `id_ficha`, `id_servicio`, `precio`, `created_at`, `updated_at`) VALUES
	('3ebba0f0-2b92-4c97-ac07-07faf3834e14', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 'd60637b5-b358-41f1-b11e-07d721b6e7dc', 24.00, '2024-06-14 18:12:48', '2024-06-14 18:12:48'),
	('58ae76e7-0467-4758-b4a6-9c02042d4012', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 'b2eb11f2-efc9-44a7-a21a-05c212268496', 2.00, '2024-06-14 18:12:48', '2024-06-14 18:12:48');

-- Volcando estructura para tabla eldespiste.fichas_usuarios
CREATE TABLE IF NOT EXISTS `fichas_usuarios` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ficha` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `invitados` int NOT NULL DEFAULT '0',
  `ninos` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE,
  KEY `fichas_usuarios_id_ficha_foreign` (`id_ficha`),
  KEY `FK_fichas_usuarios_agsuite.users` (`user_id`),
  CONSTRAINT `fichas_usuarios_id_ficha_foreign` FOREIGN KEY (`id_ficha`) REFERENCES `fichas` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.fichas_usuarios: ~3 rows (aproximadamente)
INSERT INTO `fichas_usuarios` (`uuid`, `id_ficha`, `user_id`, `invitados`, `ninos`, `created_at`, `updated_at`) VALUES
	('0fe06bff-79e0-41ac-88b1-561369380769', '1ff3c3a0-9ce0-43d3-9adb-71303ad7ee84', 15, 0, 0, '2024-09-08 05:34:34', '2024-09-08 05:34:34'),
	('65edeffd-dace-4735-8a73-87be2a75200c', 'e95199da-5e6a-4ffc-8650-604a8d52c467', 1, 0, 0, '2024-06-16 06:13:53', '2024-06-16 06:13:53'),
	('8b4dce72-3c3e-4688-8f59-efc81a43f509', '593c073c-3115-483c-8887-4ba2d3803439', 15, 0, 0, '2024-09-10 13:39:09', '2024-09-10 13:39:09'),
	('aa860547-9aaf-4098-b65f-8ccb5051231c', 'cef9cb7f-e4ed-4596-a747-fcea5a43d4e2', 1, 0, 0, '2024-06-10 19:10:30', '2024-06-10 19:10:30'),
	('b555f4d4-6a4c-424f-8436-659cbd5da245', 'bd87957c-c56e-4bc7-91a1-b4a5591c6d8b', 1, 5, 0, '2024-06-14 18:12:36', '2024-06-14 18:12:36');

-- Volcando estructura para tabla eldespiste.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.migrations: ~16 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(8, '2024_01_24_141438_create_permission_tables', 4),
	(21, '2014_10_12_100000_create_password_resets_table', 5),
	(24, '2019_08_19_000000_create_failed_jobs_table', 6),
	(32, '2019_12_14_000001_create_personal_access_tokens_table', 7),
	(33, '2024_01_17_213609_crear_tabla_familias', 7),
	(34, '2024_01_21_00_crear_tabla_productos_y_actualizar_tabla_usuarios', 7),
	(35, '2024_04_14_133037_crear_tabla_composicion_productos', 7),
	(36, '2024_05_04_205935_crear_tabla_servicios', 7),
	(37, '2024_05_25_131608_create_reservas_table', 7),
	(38, '2024_05_27_193845_crear_tabla_fichas', 7),
	(39, '2024_05_27_194140_crear_tabla_fichas_productos', 7),
	(40, '2024_05_27_194524_crear_tabla_fichas_servicios', 7),
	(41, '2024_05_27_194733_crear_tabla_fichas_usuarios', 7),
	(42, '2024_05_27_194906_crear_tabla_fichas_gastos', 7),
	(43, '2024_06_04_204523_crear_tabla_ajustes', 8),
	(44, '2024_06_06_200829_crear_tabla_sitios', 9),
	(45, '2024_06_06_200835_crear_tabla_licencias', 9);

-- Volcando estructura para tabla eldespiste.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posicion` int NOT NULL,
  `familia` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `combinado` int NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.productos: ~4 rows (aproximadamente)
INSERT INTO `productos` (`uuid`, `nombre`, `imagen`, `posicion`, `familia`, `combinado`, `precio`, `stock`, `created_at`, `updated_at`) VALUES
	('324af123-f263-4246-965e-c3d6f5ec7d96', 'Absolut - Limón', '1717357910.png', 1, '8309aa5e-2a14-40d2-ab9f-356a0138a1d7', 1, 2.80, 0, '2024-06-02 17:51:50', '2024-06-09 13:09:20'),
	('bf1adb6d-24ab-4358-95eb-45ba62973926', 'Absolut', '1717257903.png', 1, '29a066b2-8a8d-4874-a774-ebd94218926e', 0, 0.80, -8, '2024-06-01 14:05:03', '2024-06-16 06:19:27'),
	('c588647f-f121-4ab8-8dd9-8e4430b972e3', 'Kas Limón', '1717357894.png', 1, '86b87798-f1f0-4a62-a4e6-5ee98ecc5751', 0, 2.00, -15, '2024-06-02 17:51:34', '2024-06-16 06:19:27'),
	('f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 'Croquetas Hongos', '1717357863.png', 1, '96a3b68a-53e4-4fcd-88d2-cf283d01438d', 0, 1.00, -3, '2024-06-02 17:51:03', '2024-06-14 18:13:34');

-- Volcando estructura para tabla eldespiste.reservas
CREATE TABLE IF NOT EXISTS `reservas` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.reservas: ~0 rows (aproximadamente)

-- Volcando estructura para tabla eldespiste.servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posicion` int NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.servicios: ~4 rows (aproximadamente)
INSERT INTO `servicios` (`uuid`, `nombre`, `posicion`, `precio`, `created_at`, `updated_at`) VALUES
	('0d4ad88a-856b-4ba5-ad0b-cdee4127a84b', 'Uso de cocina externo', 2, 5.00, '2024-06-01 20:17:46', '2024-06-01 20:17:46'),
	('295372a3-203b-4344-ab01-d71ed434174c', 'Limpieza (4h)', 5, 48.00, '2024-06-01 20:19:05', '2024-06-01 20:19:05'),
	('b2eb11f2-efc9-44a7-a21a-05c212268496', 'Uso de cocina', 1, 2.00, '2024-06-01 19:02:17', '2024-06-01 19:02:17'),
	('b61b6e43-4b6c-455e-a6a3-079eed4f5560', 'Limpieza (3h)', 4, 36.00, '2024-06-01 20:18:50', '2024-06-01 20:18:50'),
	('d60637b5-b358-41f1-b11e-07d721b6e7dc', 'Limpieza (2h)', 3, 24.00, '2024-06-01 20:18:35', '2024-06-01 20:18:35');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
