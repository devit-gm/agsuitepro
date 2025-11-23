-- Crear tabla mesa_historial
CREATE TABLE IF NOT EXISTS `mesa_historial` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mesa_id` CHAR(36) NOT NULL,
  `accion` ENUM('abrir', 'tomar', 'añadir_consumo', 'cerrar', 'liberar') NOT NULL,
  `camarero_id` BIGINT UNSIGNED NULL,
  `camarero_anterior_id` BIGINT UNSIGNED NULL,
  `detalles` JSON NULL,
  `fecha_accion` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `mesa_historial_mesa_id_index` (`mesa_id`),
  INDEX `mesa_historial_camarero_id_index` (`camarero_id`),
  INDEX `mesa_historial_fecha_accion_index` (`fecha_accion`),
  CONSTRAINT `mesa_historial_mesa_id_foreign` FOREIGN KEY (`mesa_id`) REFERENCES `fichas` (`uuid`) ON DELETE CASCADE,
  CONSTRAINT `mesa_historial_camarero_id_foreign` FOREIGN KEY (`camarero_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `mesa_historial_camarero_anterior_id_foreign` FOREIGN KEY (`camarero_anterior_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
