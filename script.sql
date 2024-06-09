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
  `actived` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `licenses_license_key_unique` (`license_key`),
  KEY `licenses_site_id_foreign` (`site_id`),
  KEY `licenses_user_id_foreign` (`user_id`),
  CONSTRAINT `licenses_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sitios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `licenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.licenses: ~0 rows (aproximadamente)
INSERT INTO `licenses` (`id`, `site_id`, `user_id`, `license_key`, `expires_at`, `actived`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, '4D2A7E9B8C5F1A0D', '2024-07-09', NULL, NULL, NULL);

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

-- Volcando datos para la tabla agsuite.password_reset_tokens: ~0 rows (aproximadamente)
INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
	('davgomruiz@gmail.com', '$2y$12$0SUSQuhn210FeKqoXrGEcOJiKEdGyhLubW6VCmYr99ckYrBrf94C6', '2024-05-26 06:47:12');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sitios_dominio_unique` (`dominio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.sitios: ~2 rows (aproximadamente)
INSERT INTO `sitios` (`id`, `nombre`, `dominio`, `ruta_logo`, `ruta_logo_nav`, `ruta_estilos`, `db_host`, `db_name`, `db_user`, `db_password`, `central`, `created_at`, `updated_at`) VALUES
	(1, 'GastroManager Plus', 'localhost', 'images\\logo.png', 'images\\logo-nav.png', 'css\\app.css', '127.0.0.1', 'agsuite', 'root', '', 1, '2024-06-07 14:01:52', '2024-06-07 14:01:53'),
	(2, 'El Despiste', 'eldespiste', 'images\\logo-despiste.png', 'images\\logo-despiste-nav.png', 'css\\eldespiste.css', '127.0.0.1', 'eldespiste', 'root', '', 0, '2024-06-06 20:40:57', '2024-06-06 20:40:58');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla agsuite.users: ~0 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `image`, `role_id`, `phone_number`, `email_verified_at`, `password`, `remember_token`, `site_id`, `created_at`, `updated_at`) VALUES
	(1, 'David Gómez', 'davgomruiz@gmail.com', '1717279293.jpg', 1, '658907397', NULL, '$2y$12$fC0T8Hvr/2oOyOHcUKFF3ewwfdEQLZmISocvLdCtvGGbIVFhw9eJy', 'NkqYVoXAoXRfx3WQvCtBCxg4iYX2kMcN7DnkQxMKYenGlMQExns1UjYpncLE', 2, '2023-11-29 13:26:44', '2024-06-01 20:01:33');


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

-- Volcando datos para la tabla eldespiste.ajustes: ~1 rows (aproximadamente)
INSERT INTO `ajustes` (`id`, `precio_invitado`, `max_invitados_cobrar`, `primer_invitado_gratis`, `activar_invitados_grupo`, `permitir_comprar_sin_stock`, `created_at`, `updated_at`) VALUES
	('1', 1.00, 14, 1, 1, 1, '2024-06-04 20:59:46', '2024-06-04 20:59:47');

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
	('606bc5fa-4ed0-4e54-a9a2-307b46a170c6', '324af123-f263-4246-965e-c3d6f5ec7d96', 'c588647f-f121-4ab8-8dd9-8e4430b972e3', '2024-06-02 17:55:19', '2024-06-02 17:55:19'),
	('8f823860-9e1e-4b7d-b253-e80c22eb0f6f', '324af123-f263-4246-965e-c3d6f5ec7d96', 'bf1adb6d-24ab-4358-95eb-45ba62973926', '2024-06-02 17:55:19', '2024-06-02 17:55:19');

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
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invitados_grupo` int NOT NULL,
  `fecha` timestamp NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE,
  KEY `fichas_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.fichas: ~1 rows (aproximadamente)
INSERT INTO `fichas` (`uuid`, `user_id`, `tipo`, `estado`, `descripcion`, `invitados_grupo`, `fecha`, `precio`, `created_at`, `updated_at`) VALUES
	('7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 1, 'prueba descontar stock', 0, '2024-06-08 22:00:00', 2.80, '2024-06-09 13:02:36', '2024-06-09 13:17:08');

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

-- Volcando datos para la tabla eldespiste.fichas_gastos: ~0 rows (aproximadamente)

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

-- Volcando datos para la tabla eldespiste.fichas_productos: ~1 rows (aproximadamente)
INSERT INTO `fichas_productos` (`uuid`, `id_ficha`, `id_producto`, `cantidad`, `precio`, `created_at`, `updated_at`) VALUES
	('df57f3bf-1910-43ed-97f5-b63fb2dada2d', '7b9f660a-db32-462b-b140-6bede845b081', '324af123-f263-4246-965e-c3d6f5ec7d96', 1, 2.80, '2024-06-09 13:03:16', '2024-06-09 13:03:16');

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

-- Volcando datos para la tabla eldespiste.fichas_recibos: ~2 rows (aproximadamente)
INSERT INTO `fichas_recibos` (`uuid`, `id_ficha`, `user_id`, `tipo`, `precio`, `fecha`, `estado`, `created_at`, `updated_at`) VALUES
	('44bc53a1-8e61-4e32-a40b-665ad51b4dbb', 'e2b08eb8-99bb-4df4-84c2-51e8c10b8f5e', 1, 2, 5.00, '2024-06-08 18:59:31', 1, '2024-06-08 18:59:31', '2024-06-08 19:19:17'),
	('93e20d1f-b364-4cef-b895-2070539de715', 'e2b08eb8-99bb-4df4-84c2-51e8c10b8f5e', 1, 1, 35.80, '2024-06-08 18:59:31', 1, '2024-06-08 18:59:31', '2024-06-08 19:19:17'),
	('63b945e6-1cfe-46d8-92bb-00154ce4ec88', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 1.80, '2024-06-09 13:03:35', 0, '2024-06-09 13:03:35', '2024-06-09 13:03:35'),
	('05f5ba89-6e80-4177-b361-ca1b1b69f8a5', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:09:20', 0, '2024-06-09 13:09:20', '2024-06-09 13:09:20'),
	('eabb3bd4-32f6-495c-877a-7a6e37b2828f', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:11:30', 0, '2024-06-09 13:11:30', '2024-06-09 13:11:30'),
	('c7c03120-8408-4820-a1ec-590c93f7438e', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:11:57', 0, '2024-06-09 13:11:57', '2024-06-09 13:11:57'),
	('499f2b47-0270-46e5-844b-9cdc8dbd8a3b', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:12:50', 0, '2024-06-09 13:12:50', '2024-06-09 13:12:50'),
	('c22c7011-15ab-44cf-bb57-1a094c91535f', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:13:10', 0, '2024-06-09 13:13:10', '2024-06-09 13:13:10'),
	('226fc102-b06e-4fb4-8b9a-8877c6dd1ab6', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:14:01', 0, '2024-06-09 13:14:01', '2024-06-09 13:14:01'),
	('4824a8f9-b8bc-4489-8414-df3d456a9140', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:15:04', 0, '2024-06-09 13:15:04', '2024-06-09 13:15:04'),
	('048a3f17-a3d6-471b-8104-43617603ab64', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:15:32', 0, '2024-06-09 13:15:32', '2024-06-09 13:15:32'),
	('f4b5987e-bb67-4a4b-9a10-299e93e141aa', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:15:58', 0, '2024-06-09 13:15:58', '2024-06-09 13:15:58'),
	('2c569ac3-1ed3-4df9-8e25-5fab9c228d53', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:16:24', 0, '2024-06-09 13:16:24', '2024-06-09 13:16:24'),
	('c2757e1d-799c-4447-9693-18cfa2ec6170', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:16:46', 0, '2024-06-09 13:16:46', '2024-06-09 13:16:46'),
	('3c588297-bb07-4af7-a242-dd2a954559e3', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:16:55', 0, '2024-06-09 13:16:55', '2024-06-09 13:16:55'),
	('8a3ba253-ce21-422d-99de-fcd588ae8dba', '7b9f660a-db32-462b-b140-6bede845b081', 1, 1, 2.80, '2024-06-09 13:17:08', 0, '2024-06-09 13:17:08', '2024-06-09 13:17:08');

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

-- Volcando estructura para tabla eldespiste.fichas_usuarios
CREATE TABLE IF NOT EXISTS `fichas_usuarios` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ficha` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `invitados` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE,
  KEY `fichas_usuarios_id_ficha_foreign` (`id_ficha`),
  KEY `FK_fichas_usuarios_agsuite.users` (`user_id`),
  CONSTRAINT `fichas_usuarios_id_ficha_foreign` FOREIGN KEY (`id_ficha`) REFERENCES `fichas` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.fichas_usuarios: ~1 rows (aproximadamente)
INSERT INTO `fichas_usuarios` (`uuid`, `id_ficha`, `user_id`, `invitados`, `created_at`, `updated_at`) VALUES
	('9f431c73-9d55-43aa-8b4c-8f5a85b97b0a', '7b9f660a-db32-462b-b140-6bede845b081', 1, 0, '2024-06-09 13:03:21', '2024-06-09 13:03:21');

-- Volcando estructura para tabla eldespiste.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla eldespiste.migrations: ~19 rows (aproximadamente)
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
	('bf1adb6d-24ab-4358-95eb-45ba62973926', 'Absolut', '1717257903.png', 1, '29a066b2-8a8d-4874-a774-ebd94218926e', 0, 0.80, 3, '2024-06-01 14:05:03', '2024-06-09 13:17:08'),
	('c588647f-f121-4ab8-8dd9-8e4430b972e3', 'Kas Limón', '1717357894.png', 1, '86b87798-f1f0-4a62-a4e6-5ee98ecc5751', 0, 2.00, 0, '2024-06-02 17:51:34', '2024-06-09 13:17:08'),
	('f0fd0d30-24d0-44d2-93e6-9713ddf71c20', 'Croquetas Hongos', '1717357863.png', 1, '96a3b68a-53e4-4fcd-88d2-cf283d01438d', 0, 1.00, 6, '2024-06-02 17:51:03', '2024-06-09 11:54:52');

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

-- Volcando datos para la tabla eldespiste.reservas: ~1 rows (aproximadamente)
INSERT INTO `reservas` (`uuid`, `name`, `user_id`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
	('a1a21640-cae6-4ffc-90f7-ccbe88114c5c', 'Cumple David', '1', '2024-07-20 21:43:00', '2024-08-02 21:43:00', '2024-06-07 17:43:56', '2024-06-07 17:43:56');

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

-- Volcando datos para la tabla eldespiste.servicios: ~5 rows (aproximadamente)
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
