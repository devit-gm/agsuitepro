-- ============================================
-- MIGRACIONES PARA SISTEMA DE MESAS
-- Ejecutar en la base de datos del SITIO
-- ============================================

-- 1. Añadir campos para mesas en tabla fichas
ALTER TABLE `fichas` 
ADD COLUMN `numero_mesa` VARCHAR(10) NULL AFTER `uuid`,
ADD COLUMN `numero_comensales` INT NULL DEFAULT 0 AFTER `numero_mesa`,
ADD COLUMN `modo` ENUM('ficha', 'mesa') NOT NULL DEFAULT 'ficha' AFTER `numero_comensales`,
ADD COLUMN `estado_mesa` ENUM('libre', 'ocupada', 'cerrada') NULL AFTER `modo`,
ADD COLUMN `camarero_id` BIGINT UNSIGNED NULL AFTER `estado_mesa`,
ADD COLUMN `hora_apertura` DATETIME NULL AFTER `camarero_id`,
ADD COLUMN `hora_cierre` DATETIME NULL AFTER `hora_apertura`,
ADD COLUMN `ultimo_camarero_id` BIGINT UNSIGNED NULL AFTER `hora_cierre`,
ADD INDEX `fichas_numero_mesa_index` (`numero_mesa`),
ADD INDEX `fichas_modo_index` (`modo`),
ADD INDEX `fichas_estado_mesa_index` (`estado_mesa`),
ADD INDEX `fichas_camarero_id_index` (`camarero_id`),
ADD CONSTRAINT `fichas_camarero_id_foreign` FOREIGN KEY (`camarero_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
ADD CONSTRAINT `fichas_ultimo_camarero_id_foreign` FOREIGN KEY (`ultimo_camarero_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- 2. Crear tabla mesa_historial
CREATE TABLE `mesa_historial` (
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

-- 3. Añadir campos de configuración en tabla ajustes
ALTER TABLE `ajustes`
ADD COLUMN `modo_operacion` ENUM('fichas', 'mesas') NOT NULL DEFAULT 'fichas' AFTER `id`,
ADD COLUMN `mostrar_usuarios` TINYINT(1) NOT NULL DEFAULT 1 AFTER `modo_operacion`,
ADD COLUMN `mostrar_gastos` TINYINT(1) NOT NULL DEFAULT 1 AFTER `mostrar_usuarios`,
ADD COLUMN `mostrar_compras` TINYINT(1) NOT NULL DEFAULT 1 AFTER `mostrar_gastos`;

-- ============================================
-- OPCIONAL: Configurar modo restaurante
-- ============================================
-- UPDATE ajustes SET modo_operacion = 'mesas', mostrar_usuarios = 0, mostrar_gastos = 0, mostrar_compras = 0 WHERE id = 1;
