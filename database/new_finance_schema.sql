DROP TABLE IF EXISTS `transactions`;
DROP TABLE IF EXISTS `accounts`;
DROP TABLE IF EXISTS `finance_entries`;
DROP TABLE IF EXISTS `dashboards`;
DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `usu_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `usu_nome` VARCHAR(255) NOT NULL,
  `usu_email` VARCHAR(255) NOT NULL,
  `usu_senha` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`usu_id`),
  UNIQUE KEY `usuarios_usu_email_unique` (`usu_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `accounts` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` BIGINT UNSIGNED NOT NULL,
  `current_balance` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `currency` VARCHAR(3) NOT NULL DEFAULT 'BRL',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accounts_usuario_id_foreign` (`usuario_id`),
  CONSTRAINT `accounts_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usu_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `transactions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_id` BIGINT UNSIGNED NOT NULL,
  `type` ENUM('Recebimento','Gasto') NOT NULL,
  `category` VARCHAR(255) NULL,
  `description` VARCHAR(255) NOT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `transaction_date` DATE NOT NULL,
  `status` ENUM('Pendente','Pago') NOT NULL DEFAULT 'Pago',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_account_id_foreign` (`account_id`),
  CONSTRAINT `transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
