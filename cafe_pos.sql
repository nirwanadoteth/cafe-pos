-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20250128.1cd46b0589
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 14, 2025 at 03:58 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.16
USE `cafe_pos`;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafe_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_visible` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `is_visible`, `created_at`, `updated_at`) VALUES
(1, 'Vegan Options', 'vegan-options', 'Corrupti qui corrupti consequuntur qui aperiam a numquam.', 1, '2024-01-19 13:01:28', '2025-02-12 08:23:31'),
(2, 'Dinner', 'dinner', 'Repellendus aut quod est perspiciatis ab ullam accusantium.', 1, '2024-02-28 23:25:15', '2024-12-09 19:35:21'),
(3, 'Hot Coffee', 'hot-coffee', 'Blanditiis quas voluptates libero ut.', 1, '2024-04-02 13:35:38', '2024-12-09 19:35:24'),
(4, 'Breakfast', 'breakfast', 'Aut nobis neque et fugiat.', 1, '2023-12-09 18:34:06', '2024-09-21 23:51:13'),
(5, 'Desserts', 'desserts', 'Voluptatem aperiam facere praesentium corrupti ducimus.', 1, '2023-12-27 08:00:34', '2024-12-09 19:35:27'),
(6, 'Seasonal Specials', 'seasonal-specials', 'Dicta a aspernatur est eligendi ut ut nihil.', 1, '2024-04-28 21:53:50', '2024-11-28 13:58:12'),
(7, 'Tea', 'tea', 'Consequatur veritatis qui id consectetur nisi sit.', 1, '2024-04-21 18:42:04', '2024-12-02 08:53:06'),
(8, 'Non-Coffee Beverages', 'non-coffee-beverages', 'Voluptas amet adipisci deserunt ut ut suscipit.', 1, '2024-05-13 11:14:53', '2024-08-03 01:46:51'),
(11, 'tes nama', 'tes-nama', 'deskripsi tes', 1, '2025-02-10 20:17:08', '2025-02-10 20:17:08');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Camila Wolf', '2024-04-01 17:48:42', '2024-09-20 05:43:47', NULL),
(2, 'Lonnie Dach II', '2023-12-20 07:19:57', '2024-09-21 15:54:44', NULL),
(3, 'Betty Ratke', '2024-05-10 22:51:44', '2024-10-04 07:24:46', NULL),
(4, 'Roselyn Reinger', '2024-03-02 15:25:41', '2024-09-08 15:52:20', NULL),
(5, 'Jerome Cole', '2023-12-31 13:19:05', '2024-09-11 00:06:08', NULL),
(6, 'Holly Raynor I', '2024-02-19 04:12:56', '2024-11-22 00:09:04', NULL),
(7, 'Grayson Erdman', '2024-01-11 22:44:24', '2024-08-15 17:38:15', NULL),
(8, 'Cole Shields Jr.', '2023-12-20 02:09:23', '2024-12-01 14:40:19', NULL),
(9, 'Alyson Zieme III', '2024-03-26 15:48:52', '2024-08-26 13:18:03', NULL),
(10, 'Liliane Kuphal', '2024-05-21 18:37:13', '2024-12-02 11:44:28', NULL),
(11, 'Elsa Morissette', '2024-01-28 17:56:54', '2024-08-28 09:57:43', NULL),
(12, 'Pierre Bins', '2024-03-19 03:28:06', '2024-09-05 13:02:41', NULL),
(13, 'Celia Lueilwitz', '2024-05-20 15:52:32', '2024-11-20 16:19:31', NULL),
(14, 'Miss Kathryn Harris', '2024-03-13 22:14:24', '2024-08-01 05:36:48', NULL),
(15, 'Angela Eichmann', '2024-01-26 00:33:37', '2024-08-14 08:02:32', NULL),
(16, 'Cayla Bartell', '2024-06-04 08:23:49', '2024-08-25 17:32:03', NULL),
(17, 'Fermin Schneider PhD', '2024-01-03 02:40:33', '2024-08-17 22:33:13', NULL),
(18, 'Gene Miller', '2024-03-05 16:02:40', '2024-07-31 07:51:58', NULL),
(19, 'Adele Schamberger', '2024-04-17 12:06:15', '2024-10-11 14:56:26', NULL),
(20, 'Cathy Halvorson IV', '2024-03-05 17:19:14', '2024-09-03 14:49:52', NULL),
(21, 'Selina McLaughlin', '2023-12-28 18:39:51', '2024-11-02 23:07:50', NULL),
(22, 'Brycen Kuhlman', '2024-04-06 00:22:44', '2024-11-11 09:37:34', NULL),
(23, 'Domingo Huels', '2024-05-04 21:51:22', '2024-10-16 11:13:53', NULL),
(24, 'Maverick Kuphal', '2024-05-12 13:35:07', '2024-07-14 14:01:26', NULL),
(25, 'Ms. Crystal Kilback', '2024-06-04 16:27:59', '2024-07-11 10:56:36', NULL),
(26, 'Kira Rogahn Sr.', '2024-06-02 20:27:49', '2024-09-25 03:39:58', NULL),
(27, 'Clint Ernser', '2024-03-30 03:34:50', '2024-09-27 14:14:31', NULL),
(28, 'Clement Vandervort', '2024-01-17 00:16:31', '2024-08-04 20:19:34', NULL),
(29, 'Mr. Deven Zemlak', '2024-05-26 01:52:26', '2024-11-12 17:52:21', NULL),
(30, 'Adrien Lowe', '2024-03-21 09:11:22', '2024-08-07 01:52:53', NULL),
(31, 'Jovanny O\'Reilly', '2024-03-13 21:48:04', '2024-07-29 06:28:17', NULL),
(32, 'Americo O\'Kon', '2024-05-17 04:16:38', '2024-07-24 05:10:41', NULL),
(33, 'Vladimir Hauck', '2024-03-01 10:57:09', '2024-10-18 12:40:53', NULL),
(34, 'Keanu Bode', '2023-12-29 18:10:44', '2024-10-18 08:57:24', NULL),
(35, 'Nat Effertz', '2024-01-16 23:21:36', '2024-07-31 00:55:54', NULL),
(36, 'Jeramie Hand', '2023-12-11 01:34:53', '2024-08-24 22:46:09', NULL),
(37, 'Madaline Johns', '2024-02-02 16:26:24', '2024-09-06 15:31:47', NULL),
(38, 'Rowland Hoppe Sr.', '2024-05-05 18:46:59', '2024-11-13 18:22:55', NULL),
(39, 'Cathy Buckridge', '2024-03-04 11:51:46', '2024-12-02 10:49:59', NULL),
(40, 'Dr. Francesco Lockman', '2024-04-22 15:52:52', '2024-08-14 06:14:28', NULL),
(41, 'Carolanne Bednar', '2024-04-06 09:55:41', '2024-08-01 08:51:07', NULL),
(42, 'Fae Carter', '2024-03-01 07:30:31', '2024-08-29 10:13:44', NULL),
(43, 'Dr. Sidney Roberts Sr.', '2024-02-29 19:04:21', '2024-07-18 14:38:55', NULL),
(44, 'Mr. Ramon Gerlach II', '2024-03-12 22:33:00', '2024-12-09 09:12:46', NULL),
(45, 'Amalia Bruen', '2024-02-12 18:54:41', '2024-10-02 10:27:17', NULL),
(46, 'Sim Mosciski', '2024-06-03 14:25:13', '2024-08-14 19:37:03', NULL),
(47, 'Jessy Hirthe', '2024-03-07 23:38:18', '2024-12-08 13:15:23', NULL),
(48, 'Lawrence Hills', '2024-02-07 13:07:17', '2024-08-12 09:20:00', NULL),
(49, 'Dr. Maximo Jaskolski Sr.', '2024-02-28 12:08:56', '2024-09-11 17:12:52', NULL),
(50, 'Andreane Vandervort', '2024-02-04 01:04:03', '2024-08-23 07:05:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exports`
--

CREATE TABLE `exports` (
  `id` bigint UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exporter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `total_rows` int UNSIGNED NOT NULL,
  `successful_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exports`
--

INSERT INTO `exports` (`id`, `completed_at`, `file_disk`, `file_name`, `exporter`, `processed_rows`, `total_rows`, `successful_rows`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '2024-12-12 08:43:40', 'local', 'export-1-categories', 'App\\Filament\\Exports\\CategoryExporter', 8, 8, 8, 1, '2024-12-12 08:43:39', '2024-12-12 08:43:40'),
(2, '2024-12-12 08:44:02', 'local', 'export-2-categories', 'App\\Filament\\Exports\\CategoryExporter', 8, 8, 8, 1, '2024-12-12 08:44:02', '2024-12-12 08:44:02'),
(3, NULL, 'sftp', 'export-3-products', 'App\\Filament\\Exports\\ProductExporter', 0, 14, 0, 1, '2024-12-13 23:37:17', '2024-12-13 23:37:17'),
(4, '2024-12-14 03:01:25', 'sftp', 'export-4-products', 'App\\Filament\\Exports\\ProductExporter', 14, 14, 14, 1, '2024-12-14 03:01:17', '2024-12-14 03:01:25'),
(5, '2024-12-14 03:02:03', 'sftp', 'export-5-products', 'App\\Filament\\Exports\\ProductExporter', 14, 14, 14, 1, '2024-12-14 03:01:56', '2024-12-14 03:02:03'),
(6, '2024-12-14 20:50:01', 'local', 'export-6-products', 'App\\Filament\\Exports\\ProductExporter', 14, 14, 14, 1, '2024-12-14 20:49:56', '2024-12-14 20:50:01'),
(7, '2024-12-17 15:38:22', 'local', 'export-7-categories', 'App\\Filament\\Exports\\CategoryExporter', 8, 8, 8, 1, '2024-12-17 15:38:16', '2024-12-17 15:38:22'),
(8, '2024-12-17 15:39:03', 'local', 'export-8-categories', 'App\\Filament\\Exports\\CategoryExporter', 8, 8, 8, 1, '2024-12-17 15:38:59', '2024-12-17 15:39:03'),
(9, '2025-02-10 20:15:05', 'local', 'export-9-categories', 'App\\Filament\\Exports\\CategoryExporter', 8, 8, 8, 2, '2025-02-10 20:15:05', '2025-02-10 20:15:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_import_rows`
--

CREATE TABLE `failed_import_rows` (
  `id` bigint UNSIGNED NOT NULL,
  `data` json NOT NULL,
  `import_id` bigint UNSIGNED NOT NULL,
  `validation_error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `health_check_result_history_items`
--

CREATE TABLE `health_check_result_history_items` (
  `id` bigint UNSIGNED NOT NULL,
  `check_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `short_summary` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` json NOT NULL,
  `ended_at` timestamp NOT NULL,
  `batch` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `health_check_result_history_items`
--

INSERT INTO `health_check_result_history_items` (`id`, `check_name`, `check_label`, `status`, `notification_message`, `short_summary`, `meta`, `ended_at`, `batch`, `created_at`, `updated_at`) VALUES
(1, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"file\"}', '2024-12-09 19:31:07', '6217a0bb-a395-43a5-8f88-64a423ce2906', '2024-12-09 19:31:08', '2024-12-09 19:31:08'),
(2, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-09 19:31:07', '6217a0bb-a395-43a5-8f88-64a423ce2906', '2024-12-09 19:31:08', '2024-12-09 19:31:08'),
(3, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '5 connections', '{\"connection_count\": 5}', '2024-12-09 19:31:07', '6217a0bb-a395-43a5-8f88-64a423ce2906', '2024-12-09 19:31:08', '2024-12-09 19:31:08'),
(4, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-09 19:31:07', '6217a0bb-a395-43a5-8f88-64a423ce2906', '2024-12-09 19:31:08', '2024-12-09 19:31:08'),
(5, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-09 19:31:07', '6217a0bb-a395-43a5-8f88-64a423ce2906', '2024-12-09 19:31:08', '2024-12-09 19:31:08'),
(6, 'OptimizedApp', 'Optimized App', 'ok', '', 'Ok', '[]', '2024-12-09 19:31:07', '6217a0bb-a395-43a5-8f88-64a423ce2906', '2024-12-09 19:31:08', '2024-12-09 19:31:08'),
(7, 'DebugMode', 'Debug Mode', 'ok', '', 'false', '{\"actual\": false, \"expected\": false}', '2024-12-09 19:31:07', '6217a0bb-a395-43a5-8f88-64a423ce2906', '2024-12-09 19:31:08', '2024-12-09 19:31:08'),
(8, 'Environment', 'Environment', 'ok', '', 'production', '{\"actual\": \"production\", \"expected\": \"production\"}', '2024-12-09 19:31:07', '6217a0bb-a395-43a5-8f88-64a423ce2906', '2024-12-09 19:31:08', '2024-12-09 19:31:08'),
(9, 'UsedDiskSpace', 'Used Disk Space', 'ok', '', '3%', '{\"disk_space_used_percentage\": 3}', '2024-12-09 19:31:08', '6217a0bb-a395-43a5-8f88-64a423ce2906', '2024-12-09 19:31:08', '2024-12-09 19:31:08'),
(10, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-09 19:31:08', '6217a0bb-a395-43a5-8f88-64a423ce2906', '2024-12-09 19:31:08', '2024-12-09 19:31:08'),
(11, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"file\"}', '2024-12-10 18:28:59', '0c350167-0b3b-47fc-8ca8-28af217051f2', '2024-12-10 18:29:00', '2024-12-10 18:29:00'),
(12, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-10 18:28:59', '0c350167-0b3b-47fc-8ca8-28af217051f2', '2024-12-10 18:29:01', '2024-12-10 18:29:01'),
(13, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '5 connections', '{\"connection_count\": 5}', '2024-12-10 18:28:59', '0c350167-0b3b-47fc-8ca8-28af217051f2', '2024-12-10 18:29:01', '2024-12-10 18:29:01'),
(14, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-10 18:28:59', '0c350167-0b3b-47fc-8ca8-28af217051f2', '2024-12-10 18:29:01', '2024-12-10 18:29:01'),
(15, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-10 18:28:59', '0c350167-0b3b-47fc-8ca8-28af217051f2', '2024-12-10 18:29:01', '2024-12-10 18:29:01'),
(16, 'OptimizedApp', 'Optimized App', 'ok', '', 'Ok', '[]', '2024-12-10 18:28:59', '0c350167-0b3b-47fc-8ca8-28af217051f2', '2024-12-10 18:29:01', '2024-12-10 18:29:01'),
(17, 'DebugMode', 'Debug Mode', 'ok', '', 'false', '{\"actual\": false, \"expected\": false}', '2024-12-10 18:28:59', '0c350167-0b3b-47fc-8ca8-28af217051f2', '2024-12-10 18:29:01', '2024-12-10 18:29:01'),
(18, 'Environment', 'Environment', 'ok', '', 'production', '{\"actual\": \"production\", \"expected\": \"production\"}', '2024-12-10 18:28:59', '0c350167-0b3b-47fc-8ca8-28af217051f2', '2024-12-10 18:29:01', '2024-12-10 18:29:01'),
(19, 'UsedDiskSpace', 'Used Disk Space', 'ok', '', '3%', '{\"disk_space_used_percentage\": 3}', '2024-12-10 18:28:59', '0c350167-0b3b-47fc-8ca8-28af217051f2', '2024-12-10 18:29:01', '2024-12-10 18:29:01'),
(20, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-10 18:29:00', '0c350167-0b3b-47fc-8ca8-28af217051f2', '2024-12-10 18:29:01', '2024-12-10 18:29:01'),
(21, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"file\"}', '2024-12-11 04:02:39', 'c24f5389-9cf3-41db-a964-e0fc9f2a9077', '2024-12-11 04:02:40', '2024-12-11 04:02:40'),
(22, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-11 04:02:39', 'c24f5389-9cf3-41db-a964-e0fc9f2a9077', '2024-12-11 04:02:40', '2024-12-11 04:02:40'),
(23, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '5 connections', '{\"connection_count\": 5}', '2024-12-11 04:02:39', 'c24f5389-9cf3-41db-a964-e0fc9f2a9077', '2024-12-11 04:02:40', '2024-12-11 04:02:40'),
(24, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-11 04:02:39', 'c24f5389-9cf3-41db-a964-e0fc9f2a9077', '2024-12-11 04:02:40', '2024-12-11 04:02:40'),
(25, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-11 04:02:39', 'c24f5389-9cf3-41db-a964-e0fc9f2a9077', '2024-12-11 04:02:40', '2024-12-11 04:02:40'),
(26, 'OptimizedApp', 'Optimized App', 'ok', '', 'Ok', '[]', '2024-12-11 04:02:39', 'c24f5389-9cf3-41db-a964-e0fc9f2a9077', '2024-12-11 04:02:40', '2024-12-11 04:02:40'),
(27, 'DebugMode', 'Debug Mode', 'ok', '', 'false', '{\"actual\": false, \"expected\": false}', '2024-12-11 04:02:39', 'c24f5389-9cf3-41db-a964-e0fc9f2a9077', '2024-12-11 04:02:40', '2024-12-11 04:02:40'),
(28, 'Environment', 'Environment', 'ok', '', 'production', '{\"actual\": \"production\", \"expected\": \"production\"}', '2024-12-11 04:02:39', 'c24f5389-9cf3-41db-a964-e0fc9f2a9077', '2024-12-11 04:02:40', '2024-12-11 04:02:40'),
(29, 'UsedDiskSpace', 'Used Disk Space', 'ok', '', '3%', '{\"disk_space_used_percentage\": 3}', '2024-12-11 04:02:39', 'c24f5389-9cf3-41db-a964-e0fc9f2a9077', '2024-12-11 04:02:40', '2024-12-11 04:02:40'),
(30, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-11 04:02:39', 'c24f5389-9cf3-41db-a964-e0fc9f2a9077', '2024-12-11 04:02:40', '2024-12-11 04:02:40'),
(31, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"file\"}', '2024-12-11 04:03:17', 'c6852f5d-254f-4034-b005-96df8cf91964', '2024-12-11 04:03:18', '2024-12-11 04:03:18'),
(32, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-11 04:03:17', 'c6852f5d-254f-4034-b005-96df8cf91964', '2024-12-11 04:03:18', '2024-12-11 04:03:18'),
(33, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '5 connections', '{\"connection_count\": 5}', '2024-12-11 04:03:17', 'c6852f5d-254f-4034-b005-96df8cf91964', '2024-12-11 04:03:18', '2024-12-11 04:03:18'),
(34, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-11 04:03:17', 'c6852f5d-254f-4034-b005-96df8cf91964', '2024-12-11 04:03:18', '2024-12-11 04:03:18'),
(35, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-11 04:03:17', 'c6852f5d-254f-4034-b005-96df8cf91964', '2024-12-11 04:03:18', '2024-12-11 04:03:18'),
(36, 'OptimizedApp', 'Optimized App', 'ok', '', 'Ok', '[]', '2024-12-11 04:03:17', 'c6852f5d-254f-4034-b005-96df8cf91964', '2024-12-11 04:03:18', '2024-12-11 04:03:18'),
(37, 'DebugMode', 'Debug Mode', 'ok', '', 'false', '{\"actual\": false, \"expected\": false}', '2024-12-11 04:03:17', 'c6852f5d-254f-4034-b005-96df8cf91964', '2024-12-11 04:03:18', '2024-12-11 04:03:18'),
(38, 'Environment', 'Environment', 'ok', '', 'production', '{\"actual\": \"production\", \"expected\": \"production\"}', '2024-12-11 04:03:17', 'c6852f5d-254f-4034-b005-96df8cf91964', '2024-12-11 04:03:18', '2024-12-11 04:03:18'),
(39, 'UsedDiskSpace', 'Used Disk Space', 'ok', '', '3%', '{\"disk_space_used_percentage\": 3}', '2024-12-11 04:03:17', 'c6852f5d-254f-4034-b005-96df8cf91964', '2024-12-11 04:03:18', '2024-12-11 04:03:18'),
(40, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-11 04:03:18', 'c6852f5d-254f-4034-b005-96df8cf91964', '2024-12-11 04:03:18', '2024-12-11 04:03:18'),
(41, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"file\"}', '2024-12-11 21:45:56', 'a69fe09d-14a0-4ed6-9168-6cb47d3bd829', '2024-12-11 21:45:57', '2024-12-11 21:45:57'),
(42, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-11 21:45:56', 'a69fe09d-14a0-4ed6-9168-6cb47d3bd829', '2024-12-11 21:45:57', '2024-12-11 21:45:57'),
(43, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '5 connections', '{\"connection_count\": 5}', '2024-12-11 21:45:56', 'a69fe09d-14a0-4ed6-9168-6cb47d3bd829', '2024-12-11 21:45:57', '2024-12-11 21:45:57'),
(44, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-11 21:45:56', 'a69fe09d-14a0-4ed6-9168-6cb47d3bd829', '2024-12-11 21:45:57', '2024-12-11 21:45:57'),
(45, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-11 21:45:56', 'a69fe09d-14a0-4ed6-9168-6cb47d3bd829', '2024-12-11 21:45:57', '2024-12-11 21:45:57'),
(46, 'OptimizedApp', 'Optimized App', 'ok', '', 'Ok', '[]', '2024-12-11 21:45:56', 'a69fe09d-14a0-4ed6-9168-6cb47d3bd829', '2024-12-11 21:45:57', '2024-12-11 21:45:57'),
(47, 'DebugMode', 'Debug Mode', 'ok', '', 'false', '{\"actual\": false, \"expected\": false}', '2024-12-11 21:45:56', 'a69fe09d-14a0-4ed6-9168-6cb47d3bd829', '2024-12-11 21:45:57', '2024-12-11 21:45:57'),
(48, 'Environment', 'Environment', 'ok', '', 'production', '{\"actual\": \"production\", \"expected\": \"production\"}', '2024-12-11 21:45:56', 'a69fe09d-14a0-4ed6-9168-6cb47d3bd829', '2024-12-11 21:45:57', '2024-12-11 21:45:57'),
(49, 'UsedDiskSpace', 'Used Disk Space', 'ok', '', '3%', '{\"disk_space_used_percentage\": 3}', '2024-12-11 21:45:56', 'a69fe09d-14a0-4ed6-9168-6cb47d3bd829', '2024-12-11 21:45:57', '2024-12-11 21:45:57'),
(50, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-11 21:45:57', 'a69fe09d-14a0-4ed6-9168-6cb47d3bd829', '2024-12-11 21:45:57', '2024-12-11 21:45:57'),
(51, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"file\"}', '2024-12-12 08:43:11', 'b40aea7f-38c2-4d45-a62a-cc3c7a6fbabc', '2024-12-12 08:43:16', '2024-12-12 08:43:16'),
(52, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-12 08:43:11', 'b40aea7f-38c2-4d45-a62a-cc3c7a6fbabc', '2024-12-12 08:43:16', '2024-12-12 08:43:16'),
(53, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '5 connections', '{\"connection_count\": 5}', '2024-12-12 08:43:11', 'b40aea7f-38c2-4d45-a62a-cc3c7a6fbabc', '2024-12-12 08:43:16', '2024-12-12 08:43:16'),
(54, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-12 08:43:13', 'b40aea7f-38c2-4d45-a62a-cc3c7a6fbabc', '2024-12-12 08:43:16', '2024-12-12 08:43:16'),
(55, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-12 08:43:13', 'b40aea7f-38c2-4d45-a62a-cc3c7a6fbabc', '2024-12-12 08:43:16', '2024-12-12 08:43:16'),
(56, 'OptimizedApp', 'Optimized App', 'ok', '', 'Ok', '[]', '2024-12-12 08:43:13', 'b40aea7f-38c2-4d45-a62a-cc3c7a6fbabc', '2024-12-12 08:43:16', '2024-12-12 08:43:16'),
(57, 'DebugMode', 'Debug Mode', 'ok', '', 'false', '{\"actual\": false, \"expected\": false}', '2024-12-12 08:43:13', 'b40aea7f-38c2-4d45-a62a-cc3c7a6fbabc', '2024-12-12 08:43:16', '2024-12-12 08:43:16'),
(58, 'Environment', 'Environment', 'ok', '', 'production', '{\"actual\": \"production\", \"expected\": \"production\"}', '2024-12-12 08:43:13', 'b40aea7f-38c2-4d45-a62a-cc3c7a6fbabc', '2024-12-12 08:43:16', '2024-12-12 08:43:16'),
(59, 'UsedDiskSpace', 'Used Disk Space', 'ok', '', '3%', '{\"disk_space_used_percentage\": 3}', '2024-12-12 08:43:13', 'b40aea7f-38c2-4d45-a62a-cc3c7a6fbabc', '2024-12-12 08:43:16', '2024-12-12 08:43:16'),
(60, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-12 08:43:14', 'b40aea7f-38c2-4d45-a62a-cc3c7a6fbabc', '2024-12-12 08:43:16', '2024-12-12 08:43:16'),
(61, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"array\"}', '2024-12-13 16:07:19', '5af5f137-9f54-44b3-900a-9e427139a986', '2024-12-13 16:07:20', '2024-12-13 16:07:20'),
(62, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-13 16:07:19', '5af5f137-9f54-44b3-900a-9e427139a986', '2024-12-13 16:07:20', '2024-12-13 16:07:20'),
(63, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '3 connections', '{\"connection_count\": 3}', '2024-12-13 16:07:19', '5af5f137-9f54-44b3-900a-9e427139a986', '2024-12-13 16:07:21', '2024-12-13 16:07:21'),
(64, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-13 16:07:19', '5af5f137-9f54-44b3-900a-9e427139a986', '2024-12-13 16:07:21', '2024-12-13 16:07:21'),
(65, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-13 16:07:19', '5af5f137-9f54-44b3-900a-9e427139a986', '2024-12-13 16:07:22', '2024-12-13 16:07:22'),
(66, 'OptimizedApp', 'Optimized App', 'failed', 'Configs are not cached.', 'Failed', '[]', '2024-12-13 16:07:19', '5af5f137-9f54-44b3-900a-9e427139a986', '2024-12-13 16:07:22', '2024-12-13 16:07:22'),
(67, 'DebugMode', 'Debug Mode', 'failed', 'The debug mode was expected to be `false`, but actually was `true`', 'true', '{\"actual\": true, \"expected\": false}', '2024-12-13 16:07:19', '5af5f137-9f54-44b3-900a-9e427139a986', '2024-12-13 16:07:22', '2024-12-13 16:07:22'),
(68, 'Environment', 'Environment', 'ok', '', 'production', '{\"actual\": \"production\", \"expected\": \"production\"}', '2024-12-13 16:07:19', '5af5f137-9f54-44b3-900a-9e427139a986', '2024-12-13 16:07:23', '2024-12-13 16:07:23'),
(69, 'UsedDiskSpace', 'Used Disk Space', 'failed', 'The disk is almost full (100% used).', '100%', '{\"disk_space_used_percentage\": 100}', '2024-12-13 16:07:19', '5af5f137-9f54-44b3-900a-9e427139a986', '2024-12-13 16:07:23', '2024-12-13 16:07:23'),
(70, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-13 16:07:20', '5af5f137-9f54-44b3-900a-9e427139a986', '2024-12-13 16:07:23', '2024-12-13 16:07:23'),
(71, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"array\"}', '2024-12-13 22:25:32', '5d2d8446-ab3d-4cbf-a17d-02966750462a', '2024-12-13 22:25:33', '2024-12-13 22:25:33'),
(72, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-13 22:25:32', '5d2d8446-ab3d-4cbf-a17d-02966750462a', '2024-12-13 22:25:33', '2024-12-13 22:25:33'),
(73, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '2 connections', '{\"connection_count\": 2}', '2024-12-13 22:25:32', '5d2d8446-ab3d-4cbf-a17d-02966750462a', '2024-12-13 22:25:33', '2024-12-13 22:25:33'),
(74, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-13 22:25:32', '5d2d8446-ab3d-4cbf-a17d-02966750462a', '2024-12-13 22:25:33', '2024-12-13 22:25:33'),
(75, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-13 22:25:32', '5d2d8446-ab3d-4cbf-a17d-02966750462a', '2024-12-13 22:25:33', '2024-12-13 22:25:33'),
(76, 'OptimizedApp', 'Optimized App', 'failed', 'Configs are not cached.', 'Failed', '[]', '2024-12-13 22:25:32', '5d2d8446-ab3d-4cbf-a17d-02966750462a', '2024-12-13 22:25:33', '2024-12-13 22:25:33'),
(77, 'DebugMode', 'Debug Mode', 'failed', 'The debug mode was expected to be `false`, but actually was `true`', 'true', '{\"actual\": true, \"expected\": false}', '2024-12-13 22:25:32', '5d2d8446-ab3d-4cbf-a17d-02966750462a', '2024-12-13 22:25:33', '2024-12-13 22:25:33'),
(78, 'Environment', 'Environment', 'ok', '', 'production', '{\"actual\": \"production\", \"expected\": \"production\"}', '2024-12-13 22:25:32', '5d2d8446-ab3d-4cbf-a17d-02966750462a', '2024-12-13 22:25:33', '2024-12-13 22:25:33'),
(79, 'UsedDiskSpace', 'Used Disk Space', 'failed', 'The disk is almost full (100% used).', '100%', '{\"disk_space_used_percentage\": 100}', '2024-12-13 22:25:32', '5d2d8446-ab3d-4cbf-a17d-02966750462a', '2024-12-13 22:25:33', '2024-12-13 22:25:33'),
(80, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-13 22:25:33', '5d2d8446-ab3d-4cbf-a17d-02966750462a', '2024-12-13 22:25:33', '2024-12-13 22:25:33'),
(81, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"array\"}', '2024-12-14 02:17:28', '270a9e93-f860-419e-b057-5d2147ffb695', '2024-12-14 02:17:30', '2024-12-14 02:17:30'),
(82, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-14 02:17:28', '270a9e93-f860-419e-b057-5d2147ffb695', '2024-12-14 02:17:30', '2024-12-14 02:17:30'),
(83, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '2 connections', '{\"connection_count\": 2}', '2024-12-14 02:17:29', '270a9e93-f860-419e-b057-5d2147ffb695', '2024-12-14 02:17:31', '2024-12-14 02:17:31'),
(84, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-14 02:17:29', '270a9e93-f860-419e-b057-5d2147ffb695', '2024-12-14 02:17:31', '2024-12-14 02:17:31'),
(85, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-14 02:17:29', '270a9e93-f860-419e-b057-5d2147ffb695', '2024-12-14 02:17:31', '2024-12-14 02:17:31'),
(86, 'OptimizedApp', 'Optimized App', 'failed', 'Configs are not cached.', 'Failed', '[]', '2024-12-14 02:17:29', '270a9e93-f860-419e-b057-5d2147ffb695', '2024-12-14 02:17:32', '2024-12-14 02:17:32'),
(87, 'DebugMode', 'Debug Mode', 'failed', 'The debug mode was expected to be `false`, but actually was `true`', 'true', '{\"actual\": true, \"expected\": false}', '2024-12-14 02:17:29', '270a9e93-f860-419e-b057-5d2147ffb695', '2024-12-14 02:17:32', '2024-12-14 02:17:32'),
(88, 'Environment', 'Environment', 'failed', 'The environment was expected to be `production`, but actually was `local`', 'local', '{\"actual\": \"local\", \"expected\": \"production\"}', '2024-12-14 02:17:29', '270a9e93-f860-419e-b057-5d2147ffb695', '2024-12-14 02:17:33', '2024-12-14 02:17:33'),
(89, 'UsedDiskSpace', 'Used Disk Space', 'ok', '', '2%', '{\"disk_space_used_percentage\": 2}', '2024-12-14 02:17:29', '270a9e93-f860-419e-b057-5d2147ffb695', '2024-12-14 02:17:33', '2024-12-14 02:17:33'),
(90, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-14 02:17:30', '270a9e93-f860-419e-b057-5d2147ffb695', '2024-12-14 02:17:33', '2024-12-14 02:17:33'),
(91, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"file\"}', '2024-12-14 15:08:06', '9ee18729-7424-4432-b4d0-d472fe824e4b', '2024-12-14 15:08:07', '2024-12-14 15:08:07'),
(92, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-14 15:08:06', '9ee18729-7424-4432-b4d0-d472fe824e4b', '2024-12-14 15:08:07', '2024-12-14 15:08:07'),
(93, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '2 connections', '{\"connection_count\": 2}', '2024-12-14 15:08:06', '9ee18729-7424-4432-b4d0-d472fe824e4b', '2024-12-14 15:08:07', '2024-12-14 15:08:07'),
(94, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-14 15:08:06', '9ee18729-7424-4432-b4d0-d472fe824e4b', '2024-12-14 15:08:07', '2024-12-14 15:08:07'),
(95, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-14 15:08:06', '9ee18729-7424-4432-b4d0-d472fe824e4b', '2024-12-14 15:08:07', '2024-12-14 15:08:07'),
(96, 'OptimizedApp', 'Optimized App', 'ok', '', 'Ok', '[]', '2024-12-14 15:08:06', '9ee18729-7424-4432-b4d0-d472fe824e4b', '2024-12-14 15:08:07', '2024-12-14 15:08:07'),
(97, 'DebugMode', 'Debug Mode', 'ok', '', 'false', '{\"actual\": false, \"expected\": false}', '2024-12-14 15:08:06', '9ee18729-7424-4432-b4d0-d472fe824e4b', '2024-12-14 15:08:07', '2024-12-14 15:08:07'),
(98, 'Environment', 'Environment', 'ok', '', 'production', '{\"actual\": \"production\", \"expected\": \"production\"}', '2024-12-14 15:08:06', '9ee18729-7424-4432-b4d0-d472fe824e4b', '2024-12-14 15:08:07', '2024-12-14 15:08:07'),
(99, 'UsedDiskSpace', 'Used Disk Space', 'ok', '', '3%', '{\"disk_space_used_percentage\": 3}', '2024-12-14 15:08:06', '9ee18729-7424-4432-b4d0-d472fe824e4b', '2024-12-14 15:08:08', '2024-12-14 15:08:08'),
(100, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-14 15:08:07', '9ee18729-7424-4432-b4d0-d472fe824e4b', '2024-12-14 15:08:08', '2024-12-14 15:08:08'),
(101, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"file\"}', '2024-12-14 20:50:45', '0e325813-3b99-4a29-a208-0fd484c003a7', '2024-12-14 20:50:46', '2024-12-14 20:50:46'),
(102, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-14 20:50:45', '0e325813-3b99-4a29-a208-0fd484c003a7', '2024-12-14 20:50:46', '2024-12-14 20:50:46'),
(103, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '2 connections', '{\"connection_count\": 2}', '2024-12-14 20:50:45', '0e325813-3b99-4a29-a208-0fd484c003a7', '2024-12-14 20:50:47', '2024-12-14 20:50:47'),
(104, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-14 20:50:46', '0e325813-3b99-4a29-a208-0fd484c003a7', '2024-12-14 20:50:47', '2024-12-14 20:50:47'),
(105, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-14 20:50:46', '0e325813-3b99-4a29-a208-0fd484c003a7', '2024-12-14 20:50:47', '2024-12-14 20:50:47'),
(106, 'OptimizedApp', 'Optimized App', 'ok', '', 'Ok', '[]', '2024-12-14 20:50:46', '0e325813-3b99-4a29-a208-0fd484c003a7', '2024-12-14 20:50:47', '2024-12-14 20:50:47'),
(107, 'DebugMode', 'Debug Mode', 'ok', '', 'false', '{\"actual\": false, \"expected\": false}', '2024-12-14 20:50:46', '0e325813-3b99-4a29-a208-0fd484c003a7', '2024-12-14 20:50:47', '2024-12-14 20:50:47'),
(108, 'Environment', 'Environment', 'ok', '', 'production', '{\"actual\": \"production\", \"expected\": \"production\"}', '2024-12-14 20:50:46', '0e325813-3b99-4a29-a208-0fd484c003a7', '2024-12-14 20:50:47', '2024-12-14 20:50:47'),
(109, 'UsedDiskSpace', 'Used Disk Space', 'ok', '', '3%', '{\"disk_space_used_percentage\": 3}', '2024-12-14 20:50:46', '0e325813-3b99-4a29-a208-0fd484c003a7', '2024-12-14 20:50:47', '2024-12-14 20:50:47'),
(110, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-14 20:50:46', '0e325813-3b99-4a29-a208-0fd484c003a7', '2024-12-14 20:50:47', '2024-12-14 20:50:47'),
(111, 'Cache', 'Cache', 'ok', '', 'Ok', '{\"driver\": \"file\"}', '2024-12-17 15:57:47', '002b1336-07b9-41ea-a254-c7f29157a9ef', '2024-12-17 15:57:49', '2024-12-17 15:57:49'),
(112, 'Database', 'Database', 'ok', '', 'Ok', '{\"connection_name\": \"mysql\"}', '2024-12-17 15:57:47', '002b1336-07b9-41ea-a254-c7f29157a9ef', '2024-12-17 15:57:49', '2024-12-17 15:57:49'),
(113, 'DatabaseConnectionCount', 'Database Connection Count', 'ok', '', '2 connections', '{\"connection_count\": 2}', '2024-12-17 15:57:47', '002b1336-07b9-41ea-a254-c7f29157a9ef', '2024-12-17 15:57:49', '2024-12-17 15:57:49'),
(114, 'DatabaseSize', 'Database Size', 'ok', '', '0 GB', '{\"database_size\": 0}', '2024-12-17 15:57:47', '002b1336-07b9-41ea-a254-c7f29157a9ef', '2024-12-17 15:57:49', '2024-12-17 15:57:49'),
(115, 'DatabaseTableSize', 'Database Table Size', 'ok', '', 'Table sizes are ok', '[]', '2024-12-17 15:57:47', '002b1336-07b9-41ea-a254-c7f29157a9ef', '2024-12-17 15:57:49', '2024-12-17 15:57:49'),
(116, 'OptimizedApp', 'Optimized App', 'ok', '', 'Ok', '[]', '2024-12-17 15:57:47', '002b1336-07b9-41ea-a254-c7f29157a9ef', '2024-12-17 15:57:50', '2024-12-17 15:57:50'),
(117, 'DebugMode', 'Debug Mode', 'ok', '', 'false', '{\"actual\": false, \"expected\": false}', '2024-12-17 15:57:47', '002b1336-07b9-41ea-a254-c7f29157a9ef', '2024-12-17 15:57:50', '2024-12-17 15:57:50'),
(118, 'Environment', 'Environment', 'ok', '', 'production', '{\"actual\": \"production\", \"expected\": \"production\"}', '2024-12-17 15:57:47', '002b1336-07b9-41ea-a254-c7f29157a9ef', '2024-12-17 15:57:50', '2024-12-17 15:57:50'),
(119, 'UsedDiskSpace', 'Used Disk Space', 'ok', '', '3%', '{\"disk_space_used_percentage\": 3}', '2024-12-17 15:57:48', '002b1336-07b9-41ea-a254-c7f29157a9ef', '2024-12-17 15:57:50', '2024-12-17 15:57:50'),
(120, 'SecurityAdvisories', 'Security Advisories', 'ok', '', 'Ok', '[]', '2024-12-17 15:57:49', '002b1336-07b9-41ea-a254-c7f29157a9ef', '2024-12-17 15:57:50', '2024-12-17 15:57:50');

-- --------------------------------------------------------

--
-- Table structure for table `imports`
--

CREATE TABLE `imports` (
  `id` bigint UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `importer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `total_rows` int UNSIGNED NOT NULL,
  `successful_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `imports`
--

INSERT INTO `imports` (`id`, `completed_at`, `file_name`, `file_path`, `importer`, `processed_rows`, `total_rows`, `successful_rows`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '2025-02-10 20:17:08', 'category-importer-example.csv', 'C:\\repo\\kuliah\\s5\\pti\\UTS_10122222_MUHAMMAD IRKHAM NURMAULUDIFA\\aplikasi\\storage\\app/public\\livewire-tmp/91LRH2I4uIvanB3EJXVq3Tfpx1LyHp-metaY2F0ZWdvcnktaW1wb3J0ZXItZXhhbXBsZS5jc3Y=-.csv', 'App\\Filament\\Imports\\CategoryImporter', 1, 1, 1, 2, '2025-02-10 20:17:08', '2025-02-10 20:17:08');

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_batches`
--

INSERT INTO `job_batches` (`id`, `name`, `total_jobs`, `pending_jobs`, `failed_jobs`, `failed_job_ids`, `options`, `cancelled_at`, `created_at`, `finished_at`) VALUES
('9db4abcc-f59c-4394-9510-de817eca55e7', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5582:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:37:\"App\\Filament\\Exports\\CategoryExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-12 08:43:39\";s:10:\"created_at\";s:19:\"2024-12-12 08:43:39\";s:2:\"id\";i:1;s:9:\"file_name\";s:19:\"export-1-categories\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-12 08:43:39\";s:10:\"created_at\";s:19:\"2024-12-12 08:43:39\";s:2:\"id\";i:1;s:9:\"file_name\";s:19:\"export-1-categories\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-1-categories\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2442:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:37:\"App\\Filament\\Exports\\CategoryExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-12 08:43:39\";s:10:\"created_at\";s:19:\"2024-12-12 08:43:39\";s:2:\"id\";i:1;s:9:\"file_name\";s:19:\"export-1-categories\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-12 08:43:39\";s:10:\"created_at\";s:19:\"2024-12-12 08:43:39\";s:2:\"id\";i:1;s:9:\"file_name\";s:19:\"export-1-categories\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-1-categories\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000e0b0000000000000000\";}\";s:4:\"hash\";s:44:\"hN42UxFdY46puhtpK8Ij4WVc/uD4azA1ZPqmKLe2+1s=\";}}}}', NULL, 1733993020, 1733993020),
('9db4abee-8a8e-4ec6-92b1-2a2ba629327e', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5582:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:37:\"App\\Filament\\Exports\\CategoryExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-12 08:44:02\";s:10:\"created_at\";s:19:\"2024-12-12 08:44:02\";s:2:\"id\";i:2;s:9:\"file_name\";s:19:\"export-2-categories\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-12 08:44:02\";s:10:\"created_at\";s:19:\"2024-12-12 08:44:02\";s:2:\"id\";i:2;s:9:\"file_name\";s:19:\"export-2-categories\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-2-categories\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:2;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2442:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:37:\"App\\Filament\\Exports\\CategoryExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-12 08:44:02\";s:10:\"created_at\";s:19:\"2024-12-12 08:44:02\";s:2:\"id\";i:2;s:9:\"file_name\";s:19:\"export-2-categories\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-12 08:44:02\";s:10:\"created_at\";s:19:\"2024-12-12 08:44:02\";s:2:\"id\";i:2;s:9:\"file_name\";s:19:\"export-2-categories\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-2-categories\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:2;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000e0b0000000000000000\";}\";s:4:\"hash\";s:44:\"k2TlF8GNMR98pRTCuZKfpwafJUxeSdHI5jGMmooMeW8=\";}}}}', NULL, 1733993042, 1733993042),
('9db7ee5f-6caf-42df-8c0f-31c52dd2271b', '', 0, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5804:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:36:\"App\\Filament\\Exports\\ProductExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-13 23:37:17\";s:10:\"created_at\";s:19:\"2024-12-13 23:37:17\";s:2:\"id\";i:3;s:9:\"file_name\";s:17:\"export-3-products\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-13 23:37:17\";s:10:\"created_at\";s:19:\"2024-12-13 23:37:17\";s:2:\"id\";i:3;s:9:\"file_name\";s:17:\"export-3-products\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"export-3-products\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:2:\"id\";s:2:\"ID\";s:13:\"category.name\";s:8:\"Category\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:5:\"price\";s:5:\"Price\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:2:\"id\";s:2:\"ID\";s:13:\"category.name\";s:8:\"Category\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:5:\"price\";s:5:\"Price\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2553:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:36:\"App\\Filament\\Exports\\ProductExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-13 23:37:17\";s:10:\"created_at\";s:19:\"2024-12-13 23:37:17\";s:2:\"id\";i:3;s:9:\"file_name\";s:17:\"export-3-products\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-13 23:37:17\";s:10:\"created_at\";s:19:\"2024-12-13 23:37:17\";s:2:\"id\";i:3;s:9:\"file_name\";s:17:\"export-3-products\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"export-3-products\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:2:\"id\";s:2:\"ID\";s:13:\"category.name\";s:8:\"Category\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:5:\"price\";s:5:\"Price\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:2:\"id\";s:2:\"ID\";s:13:\"category.name\";s:8:\"Category\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:5:\"price\";s:5:\"Price\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000f6e0000000000000000\";}\";s:4:\"hash\";s:44:\"7O5oytFdV7TzTP1Dfesr2ujf8VArQn34SOE6lkXa7UI=\";}}}}', NULL, 1734133038, NULL),
('9db83754-4e07-40d5-ae08-dd52cfede7d2', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5318:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:36:\"App\\Filament\\Exports\\ProductExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-14 03:01:18\";s:10:\"created_at\";s:19:\"2024-12-14 03:01:17\";s:2:\"id\";i:4;s:9:\"file_name\";s:17:\"export-4-products\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-14 03:01:18\";s:10:\"created_at\";s:19:\"2024-12-14 03:01:17\";s:2:\"id\";i:4;s:9:\"file_name\";s:17:\"export-4-products\";}s:10:\"\0*\0changes\";a:2:{s:10:\"updated_at\";s:19:\"2024-12-14 03:01:18\";s:9:\"file_name\";s:17:\"export-4-products\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:5:\"price\";s:5:\"Price\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:4;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:5:\"price\";s:5:\"Price\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2310:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:36:\"App\\Filament\\Exports\\ProductExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-14 03:01:18\";s:10:\"created_at\";s:19:\"2024-12-14 03:01:17\";s:2:\"id\";i:4;s:9:\"file_name\";s:17:\"export-4-products\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-14 03:01:18\";s:10:\"created_at\";s:19:\"2024-12-14 03:01:17\";s:2:\"id\";i:4;s:9:\"file_name\";s:17:\"export-4-products\";}s:10:\"\0*\0changes\";a:2:{s:10:\"updated_at\";s:19:\"2024-12-14 03:01:18\";s:9:\"file_name\";s:17:\"export-4-products\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:5:\"price\";s:5:\"Price\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:4;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:5:\"price\";s:5:\"Price\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000f690000000000000000\";}\";s:4:\"hash\";s:44:\"7JTQCpR9BxysswBXnqzwbNt53zf9JCxKczrvtTKmwb0=\";}}}}', NULL, 1734145278, 1734145285),
('9db8378f-3197-4576-83ac-27cb34d18160', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:4820:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:36:\"App\\Filament\\Exports\\ProductExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-14 03:01:56\";s:10:\"created_at\";s:19:\"2024-12-14 03:01:56\";s:2:\"id\";i:5;s:9:\"file_name\";s:17:\"export-5-products\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-14 03:01:56\";s:10:\"created_at\";s:19:\"2024-12-14 03:01:56\";s:2:\"id\";i:5;s:9:\"file_name\";s:17:\"export-5-products\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"export-5-products\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:1:{s:4:\"name\";s:4:\"Name\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:5;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:1:{s:4:\"name\";s:4:\"Name\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2061:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:36:\"App\\Filament\\Exports\\ProductExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-14 03:01:56\";s:10:\"created_at\";s:19:\"2024-12-14 03:01:56\";s:2:\"id\";i:5;s:9:\"file_name\";s:17:\"export-5-products\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:4:\"sftp\";s:10:\"updated_at\";s:19:\"2024-12-14 03:01:56\";s:10:\"created_at\";s:19:\"2024-12-14 03:01:56\";s:2:\"id\";i:5;s:9:\"file_name\";s:17:\"export-5-products\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"export-5-products\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:1:{s:4:\"name\";s:4:\"Name\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:5;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:1:{s:4:\"name\";s:4:\"Name\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000f690000000000000000\";}\";s:4:\"hash\";s:44:\"quljH0yb/7ZETYdwTU7OJvBsy4WCuX6+qIxP8m8w5rU=\";}}}}', NULL, 1734145316, 1734145323),
('9db9b582-7ab6-4478-b716-26814d1b4d60', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5808:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:36:\"App\\Filament\\Exports\\ProductExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-14 20:49:56\";s:10:\"created_at\";s:19:\"2024-12-14 20:49:56\";s:2:\"id\";i:6;s:9:\"file_name\";s:17:\"export-6-products\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-14 20:49:56\";s:10:\"created_at\";s:19:\"2024-12-14 20:49:56\";s:2:\"id\";i:6;s:9:\"file_name\";s:17:\"export-6-products\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"export-6-products\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:2:\"id\";s:2:\"ID\";s:13:\"category.name\";s:8:\"Category\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:5:\"price\";s:5:\"Price\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:6;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:2:\"id\";s:2:\"ID\";s:13:\"category.name\";s:8:\"Category\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:5:\"price\";s:5:\"Price\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2555:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:36:\"App\\Filament\\Exports\\ProductExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-14 20:49:56\";s:10:\"created_at\";s:19:\"2024-12-14 20:49:56\";s:2:\"id\";i:6;s:9:\"file_name\";s:17:\"export-6-products\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:36:\"App\\Filament\\Exports\\ProductExporter\";s:10:\"total_rows\";i:14;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-14 20:49:56\";s:10:\"created_at\";s:19:\"2024-12-14 20:49:56\";s:2:\"id\";i:6;s:9:\"file_name\";s:17:\"export-6-products\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"export-6-products\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:2:\"id\";s:2:\"ID\";s:13:\"category.name\";s:8:\"Category\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:5:\"price\";s:5:\"Price\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:6;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:2:\"id\";s:2:\"ID\";s:13:\"category.name\";s:8:\"Category\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:5:\"price\";s:5:\"Price\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000f220000000000000000\";}\";s:4:\"hash\";s:44:\"fD0E4cObbrIryAGy7mnOWtXVCGr+fdErHS9To7JIB/c=\";}}}}', NULL, 1734209397, 1734209401),
('9dbf4f01-f099-4400-990d-df1c7ab5e993', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5582:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:37:\"App\\Filament\\Exports\\CategoryExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-17 15:38:16\";s:10:\"created_at\";s:19:\"2024-12-17 15:38:16\";s:2:\"id\";i:7;s:9:\"file_name\";s:19:\"export-7-categories\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-17 15:38:16\";s:10:\"created_at\";s:19:\"2024-12-17 15:38:16\";s:2:\"id\";i:7;s:9:\"file_name\";s:19:\"export-7-categories\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-7-categories\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:7;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2442:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:37:\"App\\Filament\\Exports\\CategoryExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-17 15:38:16\";s:10:\"created_at\";s:19:\"2024-12-17 15:38:16\";s:2:\"id\";i:7;s:9:\"file_name\";s:19:\"export-7-categories\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-17 15:38:16\";s:10:\"created_at\";s:19:\"2024-12-17 15:38:16\";s:2:\"id\";i:7;s:9:\"file_name\";s:19:\"export-7-categories\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-7-categories\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:7;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000db90000000000000000\";}\";s:4:\"hash\";s:44:\"1cHzPn753bYA7BTvgQncUf2+92EnB6Ap8RgABMEy5JI=\";}}}}', NULL, 1734449898, 1734449902);
INSERT INTO `job_batches` (`id`, `name`, `total_jobs`, `pending_jobs`, `failed_jobs`, `failed_job_ids`, `options`, `cancelled_at`, `created_at`, `finished_at`) VALUES
('9dbf4f41-c46e-4bb6-a4c0-8e4d7f7b4b56', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5294:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:37:\"App\\Filament\\Exports\\CategoryExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-17 15:38:59\";s:10:\"created_at\";s:19:\"2024-12-17 15:38:59\";s:2:\"id\";i:8;s:9:\"file_name\";s:19:\"export-8-categories\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-17 15:38:59\";s:10:\"created_at\";s:19:\"2024-12-17 15:38:59\";s:2:\"id\";i:8;s:9:\"file_name\";s:19:\"export-8-categories\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-8-categories\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:8;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2298:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:37:\"App\\Filament\\Exports\\CategoryExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-17 15:38:59\";s:10:\"created_at\";s:19:\"2024-12-17 15:38:59\";s:2:\"id\";i:8;s:9:\"file_name\";s:19:\"export-8-categories\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2024-12-17 15:38:59\";s:10:\"created_at\";s:19:\"2024-12-17 15:38:59\";s:2:\"id\";i:8;s:9:\"file_name\";s:19:\"export-8-categories\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-8-categories\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:8;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000db90000000000000000\";}\";s:4:\"hash\";s:44:\"10+ikqlhUqjOxla1suviVfFpF0JTZWvMvP/Qb1POLhM=\";}}}}', NULL, 1734449940, 1734449943),
('9e2eec52-c1ab-42fe-8b44-0217ca48fe03', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5582:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:37:\"App\\Filament\\Exports\\CategoryExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:2;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-02-11 03:15:05\";s:10:\"created_at\";s:19:\"2025-02-11 03:15:05\";s:2:\"id\";i:9;s:9:\"file_name\";s:19:\"export-9-categories\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:2;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-02-11 03:15:05\";s:10:\"created_at\";s:19:\"2025-02-11 03:15:05\";s:2:\"id\";i:9;s:9:\"file_name\";s:19:\"export-9-categories\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-9-categories\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:9;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2442:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:37:\"App\\Filament\\Exports\\CategoryExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:2;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-02-11 03:15:05\";s:10:\"created_at\";s:19:\"2025-02-11 03:15:05\";s:2:\"id\";i:9;s:9:\"file_name\";s:19:\"export-9-categories\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:2;s:8:\"exporter\";s:37:\"App\\Filament\\Exports\\CategoryExporter\";s:10:\"total_rows\";i:8;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-02-11 03:15:05\";s:10:\"created_at\";s:19:\"2025-02-11 03:15:05\";s:2:\"id\";i:9;s:9:\"file_name\";s:19:\"export-9-categories\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-9-categories\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:9;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:7:{s:2:\"id\";s:2:\"ID\";s:4:\"name\";s:4:\"Name\";s:4:\"slug\";s:4:\"Slug\";s:11:\"description\";s:11:\"Description\";s:10:\"is_visible\";s:10:\"Is visible\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000df80000000000000000\";}\";s:4:\"hash\";s:44:\"BskD/RsNTMV+e9BK63wjL3VVzHNgh1b7e+qIz229j+w=\";}}}}', NULL, 1739243705, 1739243705),
('9e2eed0e-8240-477d-b4ea-e336a7b8478d', '', 1, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:3538:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:4:{s:9:\"columnMap\";a:4:{s:4:\"name\";s:4:\"name\";s:4:\"slug\";s:4:\"slug\";s:11:\"description\";s:11:\"description\";s:10:\"is_visible\";s:10:\"is_visible\";}s:6:\"import\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Imports\\Models\\Import\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:13:\"jobConnection\";N;s:7:\"options\";a:0:{}}s:8:\"function\";s:2925:\"function () use ($columnMap, $import, $jobConnection, $options) {\n                    $import->touch(\'completed_at\');\n\n                    event(new \\Filament\\Actions\\Imports\\Events\\ImportCompleted($import, $columnMap, $options));\n\n                    if (! $import->user instanceof \\Illuminate\\Contracts\\Auth\\Authenticatable) {\n                        return;\n                    }\n\n                    $failedRowsCount = $import->getFailedRowsCount();\n\n                    \\Filament\\Notifications\\Notification::make()\n                        ->title($import->importer::getCompletedNotificationTitle($import))\n                        ->body($import->importer::getCompletedNotificationBody($import))\n                        ->when(\n                            ! $failedRowsCount,\n                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->success(),\n                        )\n                        ->when(\n                            $failedRowsCount && ($failedRowsCount < $import->total_rows),\n                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->warning(),\n                        )\n                        ->when(\n                            $failedRowsCount === $import->total_rows,\n                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->danger(),\n                        )\n                        ->when(\n                            $failedRowsCount,\n                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->actions([\n                                \\Filament\\Notifications\\Actions\\Action::make(\'downloadFailedRowsCsv\')\n                                    ->label(trans_choice(\'filament-actions::import.notifications.completed.actions.download_failed_rows_csv.label\', $failedRowsCount, [\n                                        \'count\' => \\Illuminate\\Support\\Number::format($failedRowsCount),\n                                    ]))\n                                    ->color(\'danger\')\n                                    ->url(route(\'filament.imports.failed-rows.download\', [\'import\' => $import], absolute: false), shouldOpenInNewTab: true)\n                                    ->markAsRead(),\n                            ]),\n                        )\n                        ->when(\n                            ($jobConnection === \'sync\') ||\n                                (blank($jobConnection) && (config(\'queue.default\') === \'sync\')),\n                            fn (\\Filament\\Notifications\\Notification $notification) => $notification\n                                ->persistent()\n                                ->send(),\n                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->sendToDatabase($import->user, isEventDispatched: true),\n                        );\n                }\";s:5:\"scope\";s:29:\"Filament\\Actions\\ImportAction\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000c6c0000000000000000\";}\";s:4:\"hash\";s:44:\"oUEB5mX9FMPBYyPqf1+yVi5+6k9Vp3j1Yj420NIOEsU=\";}}}}', NULL, 1739243828, 1739243828);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(29, 'App\\Models\\Product', 10, '03ae1c5b-da67-4ef8-a645-bf9ecfcc6637', 'product-images', 'chocolate_brownie', '01JK37WG22PXZWXMKHN7V7GKK2.webp', 'image/webp', 'public', 'public', 29370, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 04:49:10', '2025-02-02 04:49:10'),
(30, 'App\\Models\\Product', 9, '588b90a9-cdd7-4a67-aa31-ecd62df9375a', 'product-images', 'bagel', '01JK37Y3AC65ZCTMC8SMM1BEHQ.jpg', 'image/jpeg', 'public', 'public', 4359, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 04:50:02', '2025-02-02 04:50:03'),
(31, 'App\\Models\\Product', 5, 'b589e5df-08f5-45ae-85f5-9364073f0c2a', 'product-images', 'muffin', '01JK383FKWMFDEP59T73K4RWDX.jpg', 'image/jpeg', 'public', 'public', 6534, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 04:52:59', '2025-02-02 04:52:59'),
(32, 'App\\Models\\Product', 8, '46a0db1a-59d2-47b7-9cd0-80ce2a05a720', 'product-images', 'flatwhite', '01JK388PAXWT6B4HZ03KCJEWE7.webp', 'image/webp', 'public', 'public', 37370, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 04:55:49', '2025-02-02 04:55:50'),
(33, 'App\\Models\\Product', 6, '699bc1eb-9724-483c-b68b-a3f7015888c5', 'product-images', 'matcha', '01JK38C9J6A4WWZXRB3798Q994.jpg', 'image/jpeg', 'public', 'public', 26099, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 04:57:47', '2025-02-02 04:57:48'),
(34, 'App\\Models\\Product', 13, '09807da0-3bf0-4b4e-a842-6661523e9e11', 'product-images', 'icedcm', '01JK38GS98FBTN8A2YFKTQ9M11.jpg', 'image/jpeg', 'public', 'public', 2567, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 05:00:15', '2025-02-02 05:00:15'),
(35, 'App\\Models\\Product', 11, '6c0b406f-adaf-41ff-a429-506d49a08d16', 'product-images', 'cheesecake', '01JK38JKDH8PPQ1FT88H254CB3.webp', 'image/webp', 'public', 'public', 126392, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 05:01:14', '2025-02-02 05:01:15'),
(36, 'App\\Models\\Product', 3, '560dafc9-649f-4fd5-8b5c-5e1d4483a31e', 'product-images', 'chai-tea-latte', '01JK38KK6M97DE8HJV8V3FRVSV.jpg', 'image/jpeg', 'public', 'public', 64565, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 05:01:47', '2025-02-02 05:01:47'),
(37, 'App\\Models\\Product', 14, '0d419743-1f72-4bf0-8f29-e3467b6254fb', 'product-images', 'eskopisusu', '01JK38N2RV5K3PGS359A0DPB38.jpg', 'image/jpeg', 'public', 'public', 5854, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 05:02:35', '2025-02-02 05:02:36'),
(38, 'App\\Models\\Product', 4, 'f4c9d32f-2b84-45a4-b013-4cc36f0719c4', 'product-images', 'croissant', '01JK38P895CNJW7XDNSG3X4J16.jpg', 'image/jpeg', 'public', 'public', 5019, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 05:03:14', '2025-02-02 05:03:14'),
(39, 'App\\Models\\Product', 7, '2c8dc366-fd5d-4610-880d-267b8fcf3452', 'product-images', 'clubsandwich', '01JK38SKS90CSE9NP0Q9VJ937J.jpg', 'image/webp', 'public', 'public', 108778, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 05:05:04', '2025-02-02 05:05:04'),
(40, 'App\\Models\\Product', 12, '5afd952d-0e9f-46ce-bfd7-5c00edbd399a', 'product-images', 'Americano', '01JK38V71N5MN8C3Y7C4HRTFDH.jpg', 'image/jpeg', 'public', 'public', 1252931, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 05:05:56', '2025-02-02 05:05:57'),
(41, 'App\\Models\\Product', 1, 'dca936c6-0fde-4dc0-a0f8-e2339774cbed', 'product-images', 'Caffe_Latte', '01JK38VX2M8C4WEQ9P3QWCVTD6.jpg', 'image/jpeg', 'public', 'public', 105605, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 05:06:19', '2025-02-02 05:06:19'),
(42, 'App\\Models\\Product', 2, '5452a39a-0c3e-4f83-b9bd-3080a4ad801f', 'product-images', 'halved-blueberry-scone-hero', '01JK38WMV3ZHJC5BC4JVXXH683.jpg', 'image/jpeg', 'public', 'public', 49741, '[]', '[]', '{\"webp\": true}', '[]', 1, '2025-02-02 05:06:43', '2025-02-02 05:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_09_235953_create_categories_table', 1),
(5, '2024_11_10_000403_create_products_table', 1),
(6, '2024_11_10_022105_create_customers_table', 1),
(7, '2024_11_10_071032_create_orders_table', 1),
(8, '2024_11_10_071200_create_order_item_table', 1),
(9, '2024_11_11_200613_create_payments_table', 1),
(10, '2024_11_17_123334_create_imports_table', 1),
(11, '2024_11_17_123335_create_exports_table', 1),
(12, '2024_11_17_123336_create_failed_import_rows_table', 1),
(13, '2024_11_17_123609_create_notifications_table', 1),
(14, '2024_11_19_214515_create_media_table', 1),
(15, '2024_11_19_221901_create_permission_tables', 1),
(16, '2024_11_24_013451_create_health_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('f3fa0054-0859-4626-91a8-4fea7e1e7fdf', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[{\"name\":\"View\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"View\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"https:\\/\\/irkham.azurewebsites.net\\/orders\\/52\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"**Adele Schamberger ordered 2 products.**\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-shopping-bag\",\"iconColor\":null,\"status\":null,\"title\":\"New order\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2024-12-17 15:52:40', '2024-12-17 15:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `number` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` int UNSIGNED DEFAULT NULL,
  `status` enum('new','processing','completed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `number`, `total_price`, `status`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 12, 'OR-486720', 64401500, 'completed', NULL, '2024-02-14 21:08:24', '2024-12-09 17:31:22', NULL),
(2, 39, 'OR-319275', 80298700, 'cancelled', NULL, '2024-01-26 17:03:30', '2024-12-09 17:31:22', NULL),
(3, 4, 'OR-641486', 78593700, 'new', NULL, '2024-05-24 00:46:27', '2024-12-09 17:31:22', NULL),
(4, 7, 'OR-113427', 85763500, 'processing', 'Extra hot', '2024-10-19 19:19:49', '2024-12-09 17:31:22', NULL),
(5, 30, 'OR-902558', 91800400, 'processing', 'No sugar', '2024-06-17 19:45:19', '2024-12-09 17:31:22', NULL),
(6, 8, 'OR-57208', 71849100, 'processing', NULL, '2024-04-21 04:20:03', '2024-12-09 17:31:22', NULL),
(7, 13, 'OR-607481', 15150100, 'new', NULL, '2024-07-21 19:39:34', '2024-12-09 17:31:22', NULL),
(8, 15, 'OR-677495', 111039500, 'completed', 'Less ice', '2024-11-11 23:43:39', '2024-12-09 17:31:22', NULL),
(9, 4, 'OR-28159', 35922300, 'cancelled', NULL, '2024-02-01 03:26:25', '2024-12-09 17:31:22', NULL),
(10, 41, 'OR-381021', 54826100, 'completed', NULL, '2024-12-02 22:18:37', '2024-12-09 17:31:22', NULL),
(11, 19, 'OR-644353', 36985900, 'processing', NULL, '2024-06-28 07:12:47', '2024-12-09 17:31:22', NULL),
(12, 42, 'OR-538537', 86620300, 'cancelled', 'No sugar', '2024-06-14 00:53:15', '2024-12-09 17:31:22', NULL),
(13, 24, 'OR-218831', 106662500, 'completed', NULL, '2024-09-19 04:42:07', '2024-12-09 17:31:23', NULL),
(14, 39, 'OR-845954', 65666200, 'processing', NULL, '2024-08-05 02:31:13', '2024-12-09 17:31:23', NULL),
(15, 6, 'OR-565851', 24014900, 'processing', 'Extra hot', '2024-08-12 06:33:20', '2024-12-09 17:31:23', NULL),
(16, 3, 'OR-325618', 67933000, 'completed', NULL, '2024-09-10 22:59:59', '2024-12-09 17:31:23', NULL),
(17, 43, 'OR-601449', 25112500, 'cancelled', NULL, '2024-06-30 03:50:36', '2024-12-09 17:31:23', NULL),
(18, 42, 'OR-835862', 25058700, 'new', 'No whipped cream', '2024-08-08 15:00:50', '2024-12-09 17:31:23', NULL),
(19, 34, 'OR-596774', 32859900, 'processing', NULL, '2024-09-26 09:24:48', '2024-12-09 17:31:23', NULL),
(20, 46, 'OR-715036', 27038200, 'new', NULL, '2024-10-11 06:18:33', '2024-12-09 17:31:23', NULL),
(21, 24, 'OR-309158', 104743000, 'new', NULL, '2024-09-21 18:17:44', '2024-12-09 17:31:23', NULL),
(22, 26, 'OR-894362', 51753100, 'new', 'No sugar', '2024-10-03 03:28:30', '2024-12-09 17:31:23', NULL),
(23, 13, 'OR-705152', 60213300, 'cancelled', 'Regular ice', '2024-07-13 15:26:38', '2024-12-09 17:31:23', NULL),
(24, 40, 'OR-311683', 53116700, 'cancelled', NULL, '2024-02-11 12:16:07', '2024-12-09 17:31:23', NULL),
(25, 38, 'OR-823336', 47712800, 'processing', 'Extra hot', '2024-08-16 12:28:33', '2024-12-09 17:31:23', NULL),
(26, 20, 'OR-991654', 67214900, 'completed', 'No whipped cream', '2024-03-18 03:44:04', '2024-12-09 17:31:23', NULL),
(27, 22, 'OR-283925', 82763600, 'processing', 'Regular ice', '2024-05-27 18:09:38', '2024-12-09 17:31:23', NULL),
(28, 42, 'OR-539189', 50507000, 'completed', NULL, '2024-05-23 02:43:08', '2024-12-09 17:31:24', NULL),
(29, 9, 'OR-540669', 68340900, 'cancelled', NULL, '2024-03-02 01:49:45', '2024-12-09 17:31:24', NULL),
(30, 37, 'OR-227850', 53636500, 'completed', NULL, '2024-02-04 19:09:08', '2024-12-09 17:31:24', NULL),
(31, 44, 'OR-217889', 63278800, 'new', NULL, '2024-01-23 12:36:07', '2024-12-09 17:31:24', NULL),
(32, 33, 'OR-289953', 63121200, 'new', NULL, '2024-07-08 09:21:04', '2024-12-09 17:31:24', NULL),
(33, 29, 'OR-261547', 61439400, 'processing', 'Extra hot', '2024-01-12 11:49:16', '2024-12-09 17:31:24', NULL),
(34, 12, 'OR-66991', 39661300, 'processing', 'Regular ice', '2024-11-16 06:24:11', '2024-12-09 17:31:24', NULL),
(35, 19, 'OR-348638', 52116300, 'processing', 'Extra hot', '2024-03-24 13:36:52', '2024-12-09 17:31:24', NULL),
(36, 26, 'OR-805293', 84028200, 'new', NULL, '2024-08-20 22:13:57', '2024-12-09 17:31:24', NULL),
(37, 48, 'OR-892627', 40133900, 'cancelled', NULL, '2024-03-18 02:20:27', '2024-12-09 17:31:24', NULL),
(38, 14, 'OR-466636', 49525200, 'new', NULL, '2024-01-26 09:19:04', '2024-12-09 17:31:24', NULL),
(39, 48, 'OR-728841', 61097400, 'processing', 'No whipped cream', '2024-01-04 20:30:03', '2024-12-09 17:31:24', NULL),
(40, 15, 'OR-17434', 89349900, 'cancelled', 'No whipped cream', '2024-11-16 19:09:14', '2024-12-09 17:31:24', NULL),
(41, 5, 'OR-981568', 52040000, 'processing', NULL, '2024-11-11 07:59:10', '2024-12-09 17:31:24', NULL),
(42, 21, 'OR-992526', 81672800, 'cancelled', 'Less ice', '2024-09-05 21:49:37', '2024-12-09 17:31:25', NULL),
(43, 2, 'OR-5379', 57648900, 'processing', NULL, '2024-08-03 09:17:28', '2024-12-09 17:31:25', NULL),
(44, 41, 'OR-41501', 59074300, 'cancelled', 'Extra hot', '2024-05-20 10:32:17', '2024-12-09 17:31:25', NULL),
(45, 37, 'OR-520297', 50654200, 'completed', NULL, '2024-08-17 04:28:50', '2024-12-09 17:31:25', NULL),
(46, 46, 'OR-854507', 98312500, 'new', NULL, '2024-07-07 16:19:52', '2024-12-09 17:31:25', NULL),
(47, 49, 'OR-276869', 55899500, 'cancelled', 'Less ice', '2024-05-26 20:34:42', '2024-12-09 17:31:25', NULL),
(48, 5, 'OR-139805', 65072100, 'processing', 'No whipped cream', '2024-03-21 23:32:11', '2024-12-09 17:31:25', NULL),
(49, 16, 'OR-694939', 46494300, 'new', 'Less ice', '2024-08-27 01:22:21', '2024-12-09 17:31:25', NULL),
(50, 50, 'OR-937151', 63156300, 'new', 'No whipped cream', '2024-10-27 15:24:56', '2024-12-09 17:31:25', NULL),
(51, 9, 'OR-891945', 11228800, 'processing', NULL, '2024-12-12 08:56:01', '2024-12-12 08:56:02', NULL),
(52, 19, 'OR-233743', 10776100, 'new', NULL, '2024-12-17 15:52:39', '2024-12-17 15:52:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `qty` int NOT NULL,
  `unit_price` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `qty`, `unit_price`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 5, 5917400, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(2, 1, 4, 3, 6358700, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(3, 1, 6, 4, 3934600, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(4, 2, 8, 4, 6781500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(5, 2, 12, 4, 6328800, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(6, 2, 2, 5, 5571500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(7, 3, 13, 3, 4624500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(8, 3, 9, 3, 4954100, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(9, 3, 3, 5, 7428100, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(10, 3, 4, 2, 6358700, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(11, 4, 11, 2, 6614500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(12, 4, 8, 4, 6781500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(13, 4, 2, 4, 5571500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(14, 4, 13, 3, 4624500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(15, 4, 13, 2, 4624500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(16, 5, 7, 5, 3905600, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(17, 5, 8, 4, 6781500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(18, 5, 9, 3, 4954100, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(19, 5, 11, 1, 6614500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(20, 5, 10, 4, 5917400, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(21, 6, 4, 1, 6358700, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(22, 6, 4, 3, 6358700, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(23, 6, 9, 5, 4954100, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(24, 6, 9, 3, 4954100, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(25, 6, 8, 1, 6781500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(26, 7, 13, 1, 4624500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(27, 7, 9, 1, 4954100, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(28, 7, 2, 1, 5571500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(29, 8, 1, 1, 6032500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(30, 8, 11, 3, 6614500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(31, 8, 8, 5, 6781500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(32, 8, 8, 4, 6781500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(33, 8, 1, 4, 6032500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(34, 9, 8, 3, 6781500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(35, 9, 12, 1, 6328800, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(36, 9, 13, 1, 4624500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(37, 9, 13, 1, 4624500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(38, 10, 2, 2, 5571500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(39, 10, 9, 2, 4954100, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(40, 10, 2, 5, 5571500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(41, 10, 10, 1, 5917400, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(42, 11, 5, 2, 4447300, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(43, 11, 9, 3, 4954100, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(44, 11, 11, 2, 6614500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(45, 12, 2, 3, 5571500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(46, 12, 12, 5, 6328800, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(47, 12, 6, 3, 3934600, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(48, 12, 11, 4, 6614500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(49, 13, 1, 5, 6032500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(50, 13, 13, 5, 4624500, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(51, 13, 12, 1, 6328800, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(52, 13, 9, 2, 4954100, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(53, 13, 3, 5, 7428100, '2024-12-09 17:31:22', '2024-12-09 17:31:22'),
(54, 14, 12, 2, 6328800, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(55, 14, 8, 1, 6781500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(56, 14, 11, 5, 6614500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(57, 14, 13, 2, 4624500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(58, 14, 7, 1, 3905600, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(59, 15, 1, 3, 6032500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(60, 15, 10, 1, 5917400, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(61, 16, 6, 5, 3934600, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(62, 16, 1, 3, 6032500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(63, 16, 1, 3, 6032500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(64, 16, 1, 2, 6032500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(65, 17, 13, 1, 4624500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(66, 17, 11, 1, 6614500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(67, 17, 13, 3, 4624500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(68, 18, 7, 3, 3905600, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(69, 18, 5, 3, 4447300, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(70, 19, 13, 3, 4624500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(71, 19, 12, 3, 6328800, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(72, 20, 5, 4, 4447300, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(73, 20, 13, 2, 4624500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(74, 21, 1, 1, 6032500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(75, 21, 1, 4, 6032500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(76, 21, 12, 5, 6328800, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(77, 21, 4, 5, 6358700, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(78, 21, 2, 2, 5571500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(79, 22, 9, 1, 4954100, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(80, 22, 8, 4, 6781500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(81, 22, 6, 5, 3934600, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(82, 23, 1, 4, 6032500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(83, 23, 9, 2, 4954100, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(84, 23, 9, 4, 4954100, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(85, 23, 4, 1, 6358700, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(86, 24, 3, 1, 7428100, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(87, 24, 9, 1, 4954100, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(88, 24, 13, 4, 4624500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(89, 24, 5, 5, 4447300, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(90, 25, 13, 2, 4624500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(91, 25, 6, 4, 3934600, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(92, 25, 3, 2, 7428100, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(93, 25, 6, 2, 3934600, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(94, 26, 11, 1, 6614500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(95, 26, 2, 4, 5571500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(96, 26, 13, 2, 4624500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(97, 26, 9, 4, 4954100, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(98, 26, 13, 2, 4624500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(99, 27, 11, 1, 6614500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(100, 27, 8, 1, 6781500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(101, 27, 13, 4, 4624500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(102, 27, 4, 4, 6358700, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(103, 27, 4, 4, 6358700, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(104, 28, 8, 3, 6781500, '2024-12-09 17:31:23', '2024-12-09 17:31:23'),
(105, 28, 1, 5, 6032500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(106, 29, 7, 1, 3905600, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(107, 29, 2, 5, 5571500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(108, 29, 2, 2, 5571500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(109, 29, 4, 4, 6358700, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(110, 30, 4, 4, 6358700, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(111, 30, 3, 3, 7428100, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(112, 30, 10, 1, 5917400, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(113, 31, 4, 4, 6358700, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(114, 31, 9, 3, 4954100, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(115, 31, 4, 3, 6358700, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(116, 31, 7, 1, 3905600, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(117, 32, 5, 3, 4447300, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(118, 32, 4, 3, 6358700, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(119, 32, 12, 3, 6328800, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(120, 32, 7, 3, 3905600, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(121, 33, 11, 2, 6614500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(122, 33, 3, 4, 7428100, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(123, 33, 13, 4, 4624500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(124, 34, 2, 5, 5571500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(125, 34, 6, 3, 3934600, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(126, 35, 8, 1, 6781500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(127, 35, 7, 4, 3905600, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(128, 35, 3, 4, 7428100, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(129, 36, 10, 4, 5917400, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(130, 36, 2, 5, 5571500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(131, 36, 12, 2, 6328800, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(132, 36, 11, 3, 6614500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(133, 37, 11, 2, 6614500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(134, 37, 8, 2, 6781500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(135, 37, 5, 3, 4447300, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(136, 38, 12, 1, 6328800, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(137, 38, 4, 1, 6358700, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(138, 38, 5, 1, 4447300, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(139, 38, 6, 5, 3934600, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(140, 38, 4, 2, 6358700, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(141, 39, 3, 2, 7428100, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(142, 39, 9, 5, 4954100, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(143, 39, 11, 1, 6614500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(144, 39, 3, 2, 7428100, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(145, 40, 3, 3, 7428100, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(146, 40, 6, 5, 3934600, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(147, 40, 9, 2, 4954100, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(148, 40, 12, 3, 6328800, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(149, 40, 13, 4, 4624500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(150, 41, 9, 5, 4954100, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(151, 41, 11, 1, 6614500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(152, 41, 8, 1, 6781500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(153, 41, 13, 3, 4624500, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(154, 42, 3, 5, 7428100, '2024-12-09 17:31:24', '2024-12-09 17:31:24'),
(155, 42, 10, 2, 5917400, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(156, 42, 2, 1, 5571500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(157, 42, 8, 4, 6781500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(158, 43, 12, 1, 6328800, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(159, 43, 2, 5, 5571500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(160, 43, 6, 1, 3934600, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(161, 43, 7, 5, 3905600, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(162, 44, 12, 1, 6328800, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(163, 44, 6, 5, 3934600, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(164, 44, 11, 5, 6614500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(165, 45, 11, 1, 6614500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(166, 45, 10, 1, 5917400, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(167, 45, 12, 1, 6328800, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(168, 45, 4, 5, 6358700, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(169, 46, 1, 4, 6032500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(170, 46, 2, 3, 5571500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(171, 46, 9, 5, 4954100, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(172, 46, 8, 4, 6781500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(173, 46, 2, 1, 5571500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(174, 47, 7, 2, 3905600, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(175, 47, 1, 2, 6032500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(176, 47, 4, 1, 6358700, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(177, 47, 3, 1, 7428100, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(178, 47, 5, 5, 4447300, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(179, 48, 8, 2, 6781500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(180, 48, 5, 4, 4447300, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(181, 48, 1, 3, 6032500, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(182, 48, 7, 4, 3905600, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(183, 49, 5, 4, 4447300, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(184, 49, 6, 1, 3934600, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(185, 49, 9, 5, 4954100, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(186, 50, 10, 2, 5917400, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(187, 50, 7, 5, 3905600, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(188, 50, 4, 5, 6358700, '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(189, 51, 5, 1, 4447300, '2024-12-12 08:56:01', '2024-12-12 08:56:01'),
(190, 51, 8, 1, 6781500, '2024-12-12 08:56:02', '2024-12-12 08:56:02'),
(191, 52, 5, 1, 4447300, '2024-12-17 15:52:39', '2024-12-17 15:52:39'),
(192, 52, 12, 1, 6328800, '2024-12-17 15:52:39', '2024-12-17 15:52:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `amount` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 25076400, '2024-02-09 13:30:48', '2024-11-07 16:36:41'),
(2, 2, 11406000, '2024-02-06 21:31:41', '2024-09-02 20:21:30'),
(3, 3, 23777800, '2023-12-27 16:40:23', '2024-10-21 11:43:53'),
(4, 4, 4628900, '2024-03-28 20:20:25', '2024-08-24 21:22:41'),
(5, 5, 17285200, '2024-04-20 18:40:04', '2024-09-09 18:50:20'),
(6, 6, 7820000, '2024-01-26 05:20:30', '2024-10-06 05:28:12'),
(7, 7, 6669000, '2024-01-10 02:01:15', '2024-07-22 07:52:28'),
(8, 8, 7232700, '2023-12-19 11:34:42', '2024-11-12 07:59:41'),
(9, 9, 2780300, '2024-04-27 19:05:47', '2024-09-08 17:45:43'),
(10, 10, 17599800, '2024-04-06 06:18:55', '2024-09-30 09:39:32'),
(11, 11, 17339000, '2024-06-01 21:00:52', '2024-10-20 07:45:18'),
(12, 12, 9708700, '2024-04-15 03:44:58', '2024-11-07 09:47:38'),
(13, 13, 17052200, '2024-05-03 20:58:04', '2024-10-22 03:38:27'),
(14, 14, 24927300, '2023-12-13 22:43:41', '2024-09-02 06:54:36'),
(15, 15, 13371000, '2024-02-07 04:00:17', '2024-10-20 05:07:56'),
(16, 16, 9812900, '2024-05-10 04:17:31', '2024-10-30 08:38:39'),
(17, 17, 11562300, '2024-03-04 09:35:01', '2024-11-28 22:39:02'),
(18, 18, 25582600, '2024-04-26 13:33:36', '2024-11-20 02:54:37'),
(19, 19, 3892800, '2024-05-23 07:15:38', '2024-10-27 11:51:58'),
(20, 20, 4009400, '2024-01-14 05:17:09', '2024-09-10 19:25:40'),
(21, 21, 22774800, '2023-12-26 04:03:50', '2024-09-02 06:20:52'),
(22, 22, 21656800, '2024-01-17 23:13:53', '2024-07-20 00:58:56'),
(23, 23, 29310800, '2024-01-29 21:50:47', '2024-07-30 00:26:31'),
(24, 24, 12097400, '2024-02-24 01:01:38', '2024-11-22 10:39:26'),
(25, 25, 8974300, '2024-03-22 01:54:58', '2024-08-14 04:20:14'),
(26, 26, 15446300, '2024-01-26 07:08:19', '2024-10-08 03:27:18'),
(27, 27, 19167800, '2024-04-06 20:45:23', '2024-10-07 02:41:54'),
(28, 28, 10152700, '2024-05-21 08:17:57', '2024-09-19 05:04:19'),
(29, 29, 4691500, '2023-12-11 16:50:36', '2024-11-11 16:23:43'),
(30, 30, 15325500, '2024-01-20 10:06:01', '2024-10-02 00:38:44'),
(31, 31, 21815400, '2024-02-06 13:59:55', '2024-08-19 09:07:39'),
(32, 32, 24415300, '2024-03-25 14:22:06', '2024-10-04 08:54:56'),
(33, 33, 15328600, '2024-05-26 21:57:13', '2024-08-12 03:47:00'),
(34, 34, 28376700, '2024-05-22 11:42:33', '2024-12-05 16:57:07'),
(35, 35, 27937300, '2024-06-05 22:04:00', '2024-07-31 03:28:23'),
(36, 36, 12912600, '2024-06-08 15:21:02', '2024-09-02 11:49:44'),
(37, 37, 20723300, '2024-04-01 14:20:39', '2024-09-29 16:24:56'),
(38, 38, 25262200, '2024-05-19 23:33:03', '2024-10-12 13:20:24'),
(39, 39, 13359600, '2024-01-08 10:45:02', '2024-08-18 09:31:39'),
(40, 40, 6613700, '2024-04-07 14:35:38', '2024-10-02 05:12:45'),
(41, 41, 8293200, '2024-05-07 01:48:53', '2024-07-22 21:15:11'),
(42, 42, 22790600, '2024-05-29 06:57:50', '2024-11-10 14:00:19'),
(43, 43, 6618000, '2024-01-10 20:02:36', '2024-09-02 19:01:21'),
(44, 44, 16596500, '2024-05-27 03:52:59', '2024-09-22 08:45:33'),
(45, 45, 6336400, '2024-05-14 11:19:05', '2024-07-24 08:49:37'),
(46, 46, 25938100, '2024-05-03 01:45:16', '2024-10-06 19:40:18'),
(47, 47, 18281600, '2024-02-13 04:36:20', '2024-07-19 00:22:13'),
(48, 48, 3468200, '2023-12-23 16:03:42', '2024-09-16 14:21:14'),
(49, 49, 18163900, '2024-04-16 07:26:40', '2024-12-09 13:19:38'),
(50, 50, 10227100, '2024-05-26 00:32:01', '2024-08-04 16:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'page_HealthCheckResults', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(2, 'view_category', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(3, 'view_any_category', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(4, 'create_category', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(5, 'update_category', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(6, 'delete_category', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(7, 'delete_any_category', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(8, 'view_product', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(9, 'view_any_product', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(10, 'create_product', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(11, 'update_product', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(12, 'delete_product', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(13, 'delete_any_product', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(14, 'view_order', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(15, 'view_any_order', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(16, 'create_order', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(17, 'update_order', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(18, 'delete_order', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(19, 'delete_any_order', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(20, 'force_delete_order', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(21, 'force_delete_any_order', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(22, 'restore_order', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(23, 'restore_any_order', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(24, 'view_user', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(25, 'view_any_user', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(26, 'create_user', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(27, 'update_user', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(28, 'delete_user', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(29, 'delete_any_user', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(30, 'view_role', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(31, 'view_any_role', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(32, 'create_role', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(33, 'update_role', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(34, 'delete_role', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(35, 'delete_any_role', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(36, 'page_ProductReports', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(37, 'page_SalesReports', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(38, 'widget_LatestOrders', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_visible` tinyint(1) NOT NULL DEFAULT '0',
  `price` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `is_visible`, `price`, `created_at`, `updated_at`) VALUES
(1, 5, 'CafÃ© Latte', 'cafe-latte', 'Sunt nulla qui odio numquam odit omnis nisi.', 1, 6032500, '2024-03-06 15:42:48', '2024-12-14 20:15:12'),
(2, 4, 'Blueberry Scone', 'blueberry-scone', 'Facere laborum possimus dignissimos voluptate.', 1, 5571500, '2024-01-15 23:29:17', '2024-12-10 17:49:55'),
(3, 8, 'Chai Tea Latte', 'chai-tea-latte', 'Sint consequatur adipisci officia laborum.', 1, 7428100, '2024-03-18 08:58:26', '2024-09-29 11:55:07'),
(4, 4, 'Croissant', 'croissant', 'Inventore perspiciatis maiores numquam exercitationem.', 1, 6358700, '2024-02-07 10:27:23', '2024-11-10 03:30:33'),
(5, 1, 'Chocolate Muffin', 'chocolate-muffin', 'Aut qui esse consequatur aut modi recusandae occaecati.', 1, 4447300, '2024-04-07 03:23:18', '2024-07-19 22:22:53'),
(6, 7, 'Matcha Latte', 'matcha-latte', 'Reiciendis aut aut rerum hic suscipit.', 1, 3934600, '2024-05-21 21:19:08', '2024-10-22 09:33:50'),
(7, 3, 'Club Sandwich', 'club-sandwich', 'Molestiae dolorum eum dolores repellat.', 1, 3905600, '2024-04-30 03:29:52', '2024-12-09 20:11:44'),
(8, 7, 'Flat White', 'flat-white', 'Eum incidunt beatae qui saepe.', 1, 6781500, '2024-04-03 20:57:08', '2024-12-09 20:11:50'),
(9, 1, 'Bagel with Cream Cheese', 'bagel-with-cream-cheese', 'Maxime nihil iusto expedita magnam est qui aut.', 1, 4954100, '2024-01-24 17:31:02', '2024-11-22 13:46:36'),
(10, 1, 'Chocolate Brownie', 'chocolate-brownie', 'Quasi veritatis distinctio distinctio corrupti sapiente ea at totam.', 1, 5917400, '2024-01-21 08:37:31', '2024-12-13 22:31:45'),
(11, 8, 'Cheesecake', 'cheesecake', 'Eligendi sed repellat nihil.', 1, 6614500, '2024-04-13 22:14:33', '2024-12-13 22:31:50'),
(12, 5, 'Americano', 'americano', 'Perferendis commodi rerum sint omnis quidem ab nihil ea.', 1, 6328800, '2024-04-22 10:53:08', '2024-12-10 13:07:27'),
(13, 6, 'Iced Caramel Macchiato', 'iced-caramel-macchiato', 'Sit non et molestiae nihil impedit ut.', 1, 4624500, '2024-01-19 21:08:41', '2024-12-10 22:49:56'),
(14, 3, 'Es Kopi Susu', 'es-kopi-susu', NULL, 1, 2500000, '2024-12-09 22:40:08', '2024-12-09 22:40:08');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2024-12-09 17:31:25', '2024-12-09 17:31:25'),
(2, 'kasir', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26'),
(3, 'inventaris', 'web', '2024-12-09 17:31:26', '2024-12-09 17:31:26');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

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
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(2, 2),
(3, 2),
(8, 2),
(9, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(37, 2),
(38, 2),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(36, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'atlas', 'atlas@cafe.pos', '2024-12-09 19:29:22', '$2y$12$uxdTt/VEeHUOyIrGnH0q1.5BB9TcYGqMH7DGrZ8hTWhACzxc4zoi2', 'U94wShvN7niAGDovTkKGvPAJv2OZUhylMaznn9iqRMC2bKXHkkJjyAwHjDa1', '2024-12-09 17:33:08', '2024-12-09 17:33:08'),
(2, 'admin', 'admin@cafe.pos', '2024-12-17 15:56:01', '$2y$12$CC8LIu/OQM26b2dFXYvOeeIOt84ucs07fisfVZR1XMWb1pNlszDLG', '45G2QMGTjm6HRestnFseLGwnIN8ni5BiPFST6R8fyGQZY5mUFsGSzLnibMp5', '2024-12-17 15:56:01', '2024-12-17 15:56:01'),
(3, 'kasir', 'kasir@cafe.pos', '2024-12-17 16:56:50', '$2y$12$lL8Z92iVDatg7Zt0d3SavumAeZldxPbjN4Ndk5GEsph0IqsyMBct2', NULL, '2024-12-17 16:56:50', '2024-12-17 16:56:50'),
(4, 'inventaris', 'inventaris@cafe.pos', '2024-12-17 16:57:50', '$2y$12$9pE57PjVxK3fU1xj6pBAxufiSmldmC/Dvle3DfgERLYyqyKlFeEyG', NULL, '2024-12-17 16:57:50', '2024-12-17 16:57:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exports`
--
ALTER TABLE `exports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exports_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `failed_import_rows_import_id_foreign` (`import_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `health_check_result_history_items`
--
ALTER TABLE `health_check_result_history_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `health_check_result_history_items_created_at_index` (`created_at`),
  ADD KEY `health_check_result_history_items_batch_index` (`batch`);

--
-- Indexes for table `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imports_user_id_foreign` (`user_id`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_number_unique` (`number`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_order_id_foreign` (`order_id`),
  ADD KEY `order_item_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `exports`
--
ALTER TABLE `exports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `health_check_result_history_items`
--
ALTER TABLE `health_check_result_history_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `imports`
--
ALTER TABLE `imports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exports`
--
ALTER TABLE `exports`
  ADD CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `imports`
--
ALTER TABLE `imports`
  ADD CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
