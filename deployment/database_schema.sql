-- ============================================================
-- The Living Code 2026 - MySQL Veritabani Semasi
-- Laravel 12 migration'larindan olusturulmustur
--
-- KURULUM:
-- 1. cPanel > MySQL Databases > Yeni veritabani olustur
-- 2. Ayni sayfada yeni kullanici olustur
-- 3. Kullaniciyi veritabanina ekle (ALL PRIVILEGES)
-- 4. cPanel > phpMyAdmin > Veritabanini sec > Import > Bu dosyayi yukle
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Laravel migrations tablosu
CREATE TABLE IF NOT EXISTS `migrations` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 1. Users, Password Resets, Sessions
-- ============================================================

CREATE TABLE IF NOT EXISTS `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL PRIMARY KEY,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sessions` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    INDEX `sessions_user_id_index` (`user_id`),
    INDEX `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 2. Cache
-- ============================================================

CREATE TABLE IF NOT EXISTS `cache` (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL,
    INDEX `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache_locks` (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT NOT NULL,
    INDEX `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. Jobs, Job Batches, Failed Jobs
-- ============================================================

CREATE TABLE IF NOT EXISTS `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `reserved_at` INT UNSIGNED NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    INDEX `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `job_batches` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL DEFAULT 0,
    `pending_jobs` INT NOT NULL DEFAULT 0,
    `failed_jobs` INT NOT NULL DEFAULT 0,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL,
    `cancelled_at` INT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `failed_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `uuid` VARCHAR(255) NOT NULL UNIQUE,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. Role Interactions (Projenin ana tablosu)
-- ============================================================

CREATE TABLE IF NOT EXISTS `role_interactions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `role_key` VARCHAR(255) NOT NULL,
    `ip_address` VARCHAR(255) NOT NULL,
    `type` ENUM('click', 'registration') NOT NULL DEFAULT 'click',
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    UNIQUE KEY `role_interactions_unique` (`role_key`, `ip_address`, `type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Migration kayitlari
-- ============================================================

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2026_02_28_081842_create_role_clicks_table', 1),
('2026_02_28_090000_create_role_interactions_table', 1);

SET FOREIGN_KEY_CHECKS = 1;
