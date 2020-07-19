-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2020 at 11:27 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `info_biro`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `no` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `no`, `isActive`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Hipotekarna banka', '520', 1, 1, NULL, NULL),
(2, 'Erste banka', '540', 1, 1, NULL, NULL),
(3, 'Podgorička banka Societe Generale', '550', 1, 1, NULL, NULL),
(4, 'Prva banka Crne Gore', '535', 1, 1, NULL, NULL),
(5, 'Addiko banka', '555', 1, 1, NULL, NULL),
(6, 'Crnogorska komercijalna banka', '510', 1, 1, NULL, NULL),
(7, 'Atlas Mont banka', '505', 1, 1, NULL, NULL),
(8, 'Montenegrobanka AD Podgorica', '530', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_number` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `post_code` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `post_code`, `isActive`, `user_id`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'Bar', '85000', 1, 1, 1, NULL, NULL),
(2, 'Beograd', '11000', 1, 1, 2, NULL, NULL),
(3, 'Bijelo polje', '84000', 1, 1, 1, NULL, NULL),
(4, 'Brisel', '1000', 1, 1, 3, NULL, NULL),
(5, 'Budva', '85300', 1, 1, 1, NULL, NULL),
(6, 'Cetinje', '81250', 1, 1, 1, NULL, NULL),
(7, 'Danilovgrad', '81410', 1, 1, 1, NULL, NULL),
(8, 'Ðenovići', '85345', 1, 1, 1, NULL, NULL),
(9, 'Dobrota', '85331', 1, 1, 1, NULL, NULL),
(10, 'Drniš', '22320', 1, 1, 4, NULL, NULL),
(11, 'Herceg novi', '85340', 1, 1, 1, NULL, NULL),
(12, 'Jerusalim', '9100000', 1, 1, 5, NULL, NULL),
(13, 'Kolašin', '81210', 1, 1, 1, NULL, NULL),
(14, 'Kongeus Lyngby', '2800', 1, 1, 6, NULL, NULL),
(15, 'Kotor', '85330', 1, 1, 1, NULL, NULL),
(16, 'Kragujevac', '34000', 1, 1, 2, NULL, NULL),
(17, 'Madrid', '28001', 1, 1, 7, NULL, NULL),
(18, 'Maribor', '2000', 1, 1, 8, NULL, NULL),
(19, 'Milano', '20019', 1, 1, 9, NULL, NULL),
(20, 'Mojkovac', '84205', 1, 1, 1, NULL, NULL),
(21, 'Nikšić', '81400', 1, 1, 1, NULL, NULL),
(22, 'Niš', '18000', 1, 1, 2, NULL, NULL),
(23, 'Novi Sad', '21000', 1, 1, 2, NULL, NULL),
(24, 'Pescara', '65100', 1, 1, 9, NULL, NULL),
(25, 'Petnjica', '84312', 1, 1, 1, NULL, NULL),
(26, 'Plandište ', '26360', 1, 1, 2, NULL, NULL),
(27, 'Pljevlja', '84210', 1, 1, 1, NULL, NULL),
(28, 'Podgorica', '81000', 1, 1, 1, NULL, NULL),
(29, 'Samobor', '10430', 1, 1, 2, NULL, NULL),
(30, 'Sarajevo', '71000', 1, 1, 10, NULL, NULL),
(31, 'Tivat', '85320', 1, 1, 1, NULL, NULL),
(32, 'Ulcinj', '85360', 1, 1, 1, NULL, NULL),
(33, 'Žabljak', '84220', 1, 1, 1, NULL, NULL),
(34, 'Zagreb', '10000', 1, 1, 4, NULL, NULL),
(35, 'Zlatibor', '31315', 1, 1, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_croatian_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `evidention_id` bigint(20) UNSIGNED NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `contact_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `contact`, `partner_id`, `isActive`, `user_id`, `contact_type_id`, `created_at`, `updated_at`) VALUES
(1, '069/363646', 4, 1, 1, 2, NULL, NULL),
(2, '69170004', 126, 1, 1, 2, NULL, NULL),
(3, '032/334536', 256, 1, 1, 2, NULL, NULL),
(4, '113334701', 394, 1, 1, 2, NULL, NULL),
(5, ' +382 67 222 737', 462, 1, 1, 2, NULL, NULL),
(6, '020/606-053', 631, 1, 1, 2, NULL, NULL),
(7, 'bnikcevic@karismaadriatic.com', 261, 1, 1, 1, NULL, NULL),
(8, 'vasoprele@t-com.me', 318, 1, 1, 1, NULL, NULL),
(9, 'andjela.kadovic@molsoncoors.com', 462, 1, 1, 1, NULL, NULL),
(10, 'milos.popovic@skijalista-cg.me', 535, 1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_people`
--

CREATE TABLE `contact_people` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `person` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `contact_people`
--

INSERT INTO `contact_people` (`id`, `person`, `description`, `partner_id`, `isActive`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Dejan Jovanovic', NULL, 318, 1, 1, NULL, NULL),
(2, 'Andjela Kadovic', NULL, 462, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_types`
--

CREATE TABLE `contact_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `icon` text COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `contact_types`
--

INSERT INTO `contact_types` (`id`, `name`, `isActive`, `user_id`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'email', 1, 1, 'mdi-email-outline', NULL, NULL),
(2, 'phone', 1, 1, 'mdi-phone-outline', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `dateFrom` date NOT NULL,
  `dateTo` date NOT NULL,
  `number_of_recordings` bigint(20) NOT NULL,
  `recordings_remaining` bigint(20) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `isActive`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Crna Gora', 1, NULL, NULL, 1),
(2, 'Srbija', 1, NULL, NULL, 1),
(3, 'Belgija', 1, NULL, NULL, 1),
(4, 'Hrvatska', 1, NULL, NULL, 1),
(5, 'Izrael', 1, NULL, NULL, 1),
(6, 'Danska', 1, NULL, NULL, 1),
(7, 'Španija', 1, NULL, NULL, 1),
(8, 'Slovenija', 1, NULL, NULL, 1),
(9, 'Italija', 1, NULL, NULL, 1),
(10, 'Bosna i Hercegovina', 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `evidentions`
--

CREATE TABLE `evidentions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `date` date NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `is_commercial` tinyint(1) DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(191) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evidention_items`
--

CREATE TABLE `evidention_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `value` decimal(8,2) NOT NULL,
  `evidention_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evidention_statuses`
--

CREATE TABLE `evidention_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `evidention_id` bigint(20) UNSIGNED DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evidention_workers`
--

CREATE TABLE `evidention_workers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `evidention_id` bigint(20) UNSIGNED NOT NULL,
  `worker_type_id` bigint(20) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `salary` decimal(8,2) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `user_id`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 'Vozilo', 1, 1, NULL, NULL),
(2, 'Sopstveno vozilo', 1, 1, NULL, NULL),
(3, 'Dron', 1, 1, NULL, NULL),
(4, 'Kran', 1, 1, NULL, NULL),
(5, 'Fotoaparat', 1, 1, NULL, NULL),
(6, 'Smjestaj', 1, 1, NULL, NULL),
(7, 'Gorivo i parking', 1, 1, NULL, NULL),
(8, 'Tunel/trajekt', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `flag` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `value`, `flag`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 'Crnogorski', 'me', 'me', 1, NULL, NULL),
(2, 'English', 'en', 'gb', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_11_100551_create_languages_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(5, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(6, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(7, '2016_06_01_000004_create_oauth_clients_table', 1),
(8, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(9, '2019_09_02_100519_create_countries_table', 1),
(10, '2019_09_02_111851_create_cities_table', 1),
(11, '2019_09_03_090248_create_contact_types_table', 1),
(12, '2019_09_03_092831_create_banks_table', 1),
(13, '2019_09_03_101707_create_partner_types_table', 1),
(14, '2019_09_03_101708_create_partners_table', 1),
(15, '2019_09_03_101709_create_contacts_table', 1),
(16, '2019_09_03_101710_create_contact_people_table', 1),
(17, '2019_09_03_101711_create_bank_accounts_table', 1),
(18, '2019_09_10_120450_create_contracts_table', 1),
(19, '2019_10_28_122604_create_worker_types_table', 1),
(20, '2019_10_28_123656_create_statuses_table', 1),
(21, '2019_10_29_102354_create_workers_table', 1),
(22, '2019_10_30_122621_create_evidentions_table', 1),
(23, '2019_10_30_122744_create_worker_type_workers_table', 1),
(24, '2019_10_30_122745_create_evidention_workers_table', 1),
(25, '2019_10_30_123924_create_evidention_statuses_table', 1),
(26, '2019_11_04_051111_create_vehicles_table', 1),
(27, '2019_11_04_101306_create_items_table', 1),
(28, '2019_11_04_101905_create_evidention_items_table', 1),
(29, '2019_11_10_124337_create_comments_table', 1),
(30, '2019_12_21_125026_create_notifications_table', 1),
(31, '2019_12_21_125632_create_notification_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `evidention_id` bigint(20) UNSIGNED NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_users`
--

CREATE TABLE `notification_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `evidention_id` bigint(20) UNSIGNED NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_croatian_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'INFO_BIRO Personal Access Client', 'mdYJWr0v4N0YSUK5i2bgxraKDdN0WBsI5Jmp3LXV', 'http://localhost', 1, 0, 0, '2020-02-07 21:25:21', '2020-02-07 21:25:21'),
(2, NULL, 'INFO_BIRO Password Grant Client', 'v66WeJm1rwL3bnxnd6xCoYGjJRcP0ThXBKZ0aV1o', 'http://localhost', 0, 1, 0, '2020-02-07 21:25:21', '2020-02-07 21:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-02-07 21:25:21', '2020-02-07 21:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `pib` varchar(191) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `pdv` varchar(191) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `note` varchar(191) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `partner_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `code`, `name`, `address`, `pib`, `pdv`, `isActive`, `note`, `created_at`, `updated_at`, `partner_type_id`, `city_id`, `user_id`) VALUES
(1, '551', 'Javna ustanova viša stručna škola \"Policijska akademija\" Danilovgrad', 'BOŽOVA GLAVICA BB 81040', '02624036', NULL, 1, NULL, NULL, NULL, NULL, 7, 1),
(2, '561', ' ŠUBERIÈ BIBEROVIC VANJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(3, '152', '13 jul - Plantaže AD', 'Put Radomira Ivanovica bb', '02016281', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(4, '113', 'Acme doo', 'Velimira Terzica BR.9', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(5, '28', 'ADDIKO BANK AD PODGORICA', 'Bulevar Dzordza Vasingtona br.98', '02454190', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(6, '468', 'ADP-ZID ', ' UL GOJKA RADONJICA 32', '02045648', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(7, '8', 'Adriatic marinas doo', NULL, '02467593', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(8, '96', 'Agencija za civilno vazduhoplovstvo Crne Gore', 'Josipa Broza Tita bb', '02638649', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(9, '5', 'Agencija za elektronske komunikacije i postansku d', 'Bulevar Dzordza Vasingtona bb,lamela C', '02326710', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(10, '624', 'Agencija za konsalting Glory Box Baric ', 'Barickih boraca 20,Baric', '111417287', NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(11, '644', 'AGENCIJA ZA PREVODJENJE I PODUCAVANJE-PREVEDI', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 23, 1),
(12, '406', 'AGENCIJA ZA SPRJEÈAVANJE KORUPCIJE', 'KRALJA NIKOLE 27/V', '11006507', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(13, '651', 'AIRBNB', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(14, '233', 'Aktuar doo', NULL, '02706415', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(15, '548', 'ALFA CENTAR NVO', 'UL JOLA PILETIÆA 1/1 81400', NULL, NULL, 1, NULL, NULL, NULL, NULL, 21, 1),
(16, '29', 'Ambasada Republike Austrije', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(17, '137', 'AMD Stanic-duplooooo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(18, '573', 'AMERIÈKA PRIVREDNA KOMORA U CRNOJ GORI', 'RIMSKI TRG BR.4/V 81000 PODGORICA', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(19, '95', 'Amia-Astra Montenegro investment association', NULL, '02772426', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(20, '265', 'Antena M', NULL, '02373211', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(21, '225', 'Antitalent  produkcija', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 34, 1),
(22, '477', 'ANTONIJEVIC MILOS', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(23, '621', 'ANTONINA PATAKI-NINA APARTMENTS', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(24, '497', 'APARTMANI GRBOVIC', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 33, 1),
(25, '338', 'AQUA TERRA SOLUTIONS DOO BUDVA', 'Trg Sunca br.4', '02970520', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(26, '586', 'ARIA DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(27, '275', 'Artcore studio snimatelj', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(28, '120', 'Astra Montenegro investment', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(29, '68', 'Atlanski savez Crne Gore', NULL, '02629496', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(30, '384', 'ATLAS BANKA AD', 'ul.V.Djurovica bb', '02348772', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(31, '64', 'Atlas fondacija', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(32, '157', 'Atlas life ad', NULL, '02695227', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(33, '172', 'Auris Capital AD ', NULL, '20307978', NULL, 1, NULL, NULL, NULL, NULL, 16, 1),
(34, '348', 'AUTO MOTO DRUSTVO STANIC', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(35, '412', 'Autoventura doo', NULL, NULL, '30/31-01588-0', 1, NULL, NULL, NULL, NULL, 6, 1),
(36, '564', 'AVISTA REALTY GROUP DOO', 'TOPOLICA 1 BR 29', '02699532', NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(37, '119', 'Azmont Investments DOO', 'Brace Grakalica 94,Meljine', '02893126', NULL, 1, NULL, NULL, NULL, NULL, 11, 1),
(38, '483', 'BALETSKA SKOLA PRINCEZA KSENIJA', 'BUL.STANKA DRAGOJEVICA 40', '02421348', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(39, '238', 'Barter centar', 'ÆELUGA 43 BAR', '03035824', NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(40, '619', 'BATEL DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(41, '639', 'BATRICEVIC MAJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(42, '227', 'Becanovic Nemanja', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(43, '35', 'Bega pres u stecaju', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(44, '469', 'Benefit Communications doo', 'Dr.Vukasina Markovica 102', '02966506', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(45, '102', 'Berkuljan Gojko', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(46, '318', 'BEŠOVIÆ BRANKA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(47, '370', 'BioSave DOO', 'Svetozara Markovica br 4', '02896168', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(48, '463', 'Biro za ekonomsku saradnju i podrsku biznis zajedn', 'GG PODGORICA', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(49, '252', 'BM Kameleon doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(50, '169', 'Bojana Femic', NULL, '0601983215029', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(51, '133', 'Boka golf development doo', 'PC Marinovic ,Radanovici bb Kotor', '02469731', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(52, '592', 'BOLJEVIC IVANA', NULL, '1410981215297', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(53, '93', 'Borovic Gordana', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(54, '180', 'Bozovic Ivana', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(55, '397', 'BOŽOVIÈ SRÐAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 21, 1),
(56, '328', 'Bracanovic Zeljko', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(57, '272', 'Brajovic  Aleksandar', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(58, '380', 'BRAJOVIC NIKOLA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(59, '313', 'BREŽANIN ÐORÐE', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(60, '179', 'Brkanovic  Ilija', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(61, '461', 'BTA BUDVA', 'TRG PALMI 8', '02410966', '20/31-00016-8', 1, NULL, NULL, NULL, NULL, 5, 1),
(62, '425', 'Budvanska Rivijera AD', 'Trg Slobode 1', '02005328', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(63, '142', 'Bull and bear ad', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(64, '471', 'BURIC OLIVERA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(65, '357', 'BVS Centar Bogojevic & co - Podgorica', 'Belvederska 91', '02061627', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(66, '522', 'Car Travel doo', 'Dubovica Lux bb', '03060292', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(67, '377', 'CARINE DOO', 'ul.Slobode 43', '02094754', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(68, '70', 'Castellana doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(69, '485', 'CENTAR ZA GRADJANSKO OBRAZOVANJE', 'BUL.SV.PETRA CETINJSKOG 96 III/6', '02358832', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(70, '33', 'Centar za inicijative', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(71, '127', 'Centar za monitoring i istrazivanja - Cemi', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(72, '270', 'Centar za odrzivi razvoj / UNDP', 'Bulevar Revolucije br.17-A/13', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(73, '80', 'Centralna banka Crne Gore', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(74, '86', 'Centralna narodna biblioteka', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(75, '369', 'Centre For Sustainable Tourism Initiatives', 'Piperska bb (Televex 3/1)', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(76, '623', 'CHERRY WINE DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(77, '186', 'Cikom Doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(78, '294', 'Cilimara doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(79, '34', 'CKB', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(80, '21', 'CNB ,, Djurdje Crnojevic ,,', NULL, '02010470', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(81, '195', 'Cojbasic  Ivan', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(82, '223', 'Comfortably Numb doo', NULL, '02789566', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(83, '72', 'Communis Media S', NULL, '02681315', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(84, '362', 'CONDRIC PAVLE ', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 34, 1),
(85, '153', 'Congress travel doo', NULL, '02673053', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(86, '65', 'Cooperative Housing Foundation', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(87, '450', 'Copacabana Montenegro doo', 'Donji Stoj bb', '02984695', NULL, 1, NULL, NULL, NULL, NULL, 32, 1),
(88, '433', 'Corleone DOO', 'Seljanovo bb', '02855755', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(89, '345', 'COWI-IPF', 'Parallelvej DK-2800 ,Kongeus Lyngby, Denmark', NULL, NULL, 1, NULL, NULL, NULL, NULL, 14, 1),
(90, '232', 'Creative group aquarius', NULL, '02960966', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(91, '495', 'CRNOGORSKA KINOTEKA JU', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(92, '569', 'CRNOGORSKA PRAVOSLAVNA CRKVA', 'LJETNJIKOVAC KRALJA NIKOLE', '02304252', '30/31-16162-1', 1, NULL, NULL, NULL, NULL, 21, 1),
(93, '428', 'Crnogorski elektrodistributivni sistem DOO Podgori', 'Ivana Milutinovica br.12', '03099873', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(94, '94', 'Crnogorski elektroprenosni sistem  ad', NULL, '02010658', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(95, '42', 'Crnogorski fond za solidarnu stambenu izgradnju', 'Crnogorskih serdara bb', '02247097', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(96, '438', 'Crnogorski olimpijski komitet', 'Ul 19.Decembra 21', '02192136', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(97, '122', 'Crnogorski telekom - fiksna tel.', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(98, '198', 'Crnogorski telekom - mob. tel.', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(99, '215', 'Cupic Drazen', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(100, '284', 'Daa Montenegro doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(101, '292', 'DAA MontenegroDUPLOOOOOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(102, '104', 'Dabanovic Nemanja', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(103, '97', 'Data link', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(104, '24', 'Demokratska Partija Socijalista', 'Jovana Tomasevica bb', '02011514', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(105, '473', 'DESPOTOVIC DUSKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(106, '577', 'DESPOTOVIC FILIP', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(107, '253', 'Direct  Media  doo', 'Cetinjski put Lamela 5-1', '02350394', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(108, '389', 'Direkcija javnih radova', 'Novaka Miloseva br.18', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(109, '147', 'Discover Montenegro doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(110, '235', 'Djakovic Perica', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(111, '259', 'Djuranovic  Zarko', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(112, '79', 'Djuranovic Drasko', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(113, '187', 'Djuranovic Tinka', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(114, '32', 'Djurovic Goran', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(115, '579', 'DOBRIŠA BOŽO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(116, '36', 'Dolto  doo', NULL, '02883864', '30/31-00774-6', 1, NULL, NULL, NULL, NULL, NULL, 1),
(117, '339', 'Donator DOO', 'Tuzi bb', '02129183', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(118, '519', 'ÐONDOVIC JELENA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(119, '474', 'ÐORÐEVIÆ VLATKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(120, '228', 'DPC DOO', 'Ulica Marka Radovic br.16', '02731525', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(121, '131', 'DPS Danilovgrad', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(122, '430', 'Drobac Sonja', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(123, '155', 'Drustvo ekonomista i menadzera Crne Gore', NULL, '02361566', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(124, '609', 'ÐUKIÆ VOJISLAV', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(125, '618', 'ÐUKIÈ ŽELJKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(126, '610', 'DUKLEY HOTEL', 'Jadranski put,Zavala Peninsula', '03050831', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(127, '349', 'ÐURAŠKOVIÆ VANJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(128, '513', 'DURMITORSKA VILA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 33, 1),
(129, '459', 'ÐURNIÆ ANA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(130, '82', 'Dvarp doo', 'Serdara Jola Piletica br.28', '02860635', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(131, '310', 'Efel motors', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(132, '476', 'ÈISTOÆA JP', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(133, '421', 'EKONOMSKI FAKULTET UCG', 'Jovana Tomaševiæa br 37', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(134, '360', 'ELDORADO DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 13, 1),
(135, '85', 'Elektroprivreda CG', NULL, NULL, '20/31-00112-1', 1, NULL, NULL, NULL, NULL, 21, 1),
(136, '371', 'Elektroprivreda-ddduplo', 'Vuka Karadzica br.2', '02002230', NULL, 1, NULL, NULL, NULL, NULL, 21, 1),
(137, '409', 'ELMON DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(138, '500', 'ENERGOMONT DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(139, '48', 'Enter Computers  doo', NULL, '02851172', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(140, '399', 'Èondiæ Pavle', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 34, 1),
(141, '305', 'EPSILON DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(142, '61', 'Eptisa', NULL, '02430428', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(143, '156', 'Euro - unit doo', NULL, NULL, '30/31-13814-8', 1, NULL, NULL, NULL, NULL, 28, 1),
(144, '572', 'EURO DOM DOO', 'GORICA C BLOK 1', '03010996', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(145, '303', 'EURO-BALKANS SPRL', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 4, 1),
(146, '547', 'EVROPSKI POKRET U CRNOJ GORI-duplo', 'VASA RAIÈKOVIÆA 9/ I SPRAT', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(147, '418', 'FAKULTET PRAVNIH NAUKA', 'Donja Gorica bb', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(148, '192', 'Fakultet za dizajn i multimediju univerzitet DG', 'Donja Gorica', '02924323', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(149, '193', 'Fakultet za humanisticke studije univerzitet DG', 'Donja Gorica', '02692112', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(150, '417', 'Fakultet za medj. ekonomiju,finansije i biznis', 'Donja Gorica bb', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(151, '482', 'Fakultet za prehrambenu tehnologiju ,bezb.hrane  ', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(152, '635', 'Fakultet za sport i viziè.vaspitanje UCG', 'NARODNE OMLADINE BB', NULL, NULL, 1, NULL, NULL, NULL, NULL, 21, 1),
(153, '375', 'FALCONERO DOO', NULL, '03038432', NULL, 1, NULL, NULL, NULL, NULL, 11, 1),
(154, '557', 'FANFANI DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 11, 1),
(155, '342', 'Farmont M.P', 'Kosic - Stari put bb', '02327066', NULL, 1, NULL, NULL, NULL, NULL, 7, 1),
(156, '589', 'FAXIMILE DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(157, '489', 'FC SNADBIJEVANJE ', NULL, NULL, 'VAT No G82053851,Projekt Code 170500,ACT 0.2', 1, NULL, NULL, NULL, NULL, 21, 1),
(158, '608', 'FIIAPP F.S.P C', 'Beatriz Bpbadilla,18 28040 Madrid', 'Closing Meeti', NULL, 1, NULL, NULL, NULL, NULL, 17, 1),
(159, '7', 'Filmski festival Herceg Novi - Montenegro film fes', NULL, '02252902', NULL, 1, NULL, NULL, NULL, NULL, 11, 1),
(160, '394', 'FINEDART DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(161, '652', 'FINISSIMA DOO ', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(162, '536', 'FLAER DOO', 'MOMISICI S-1,3/4', '02702860', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(163, '203', 'Fond za zdravstveno osiguranje CG', NULL, '02010810', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(164, '350', 'FONDACIJA DBS', 'Sv.Vraca 3/2', '11003630', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(165, '596', 'FONTANA CENTAR DOO BUDVA', 'SLOVENSKA OBALA 23', '03161617', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(166, '613', 'FOTOEIS SZR ', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 3, 1),
(167, '71', 'G Tech', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(168, '191', 'Gallileo doo', NULL, '02349795', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(169, '234', 'Ganic Suzana', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(170, '327', 'Gardovic Jelena', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(171, '217', 'Generali osiguranje Montenegro ad', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(172, '143', 'Generalni sekretarijat Predsjednika Crne Gore', NULL, '12018721', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(173, '402', 'Gimnazija Slobodan Skerovic', 'Vaka Djurovica br.36', '02011336', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(174, '216', 'GIZ  ORF  EE', NULL, '02422956', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(175, '282', 'Glavni grad Podgorica', 'NJegoševa br.13', '02019710', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(176, '478', 'GLUMAC DAMIR', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 10, 1),
(177, '325', 'GLUSCEVIC IGOR', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(178, '466', 'GNJIDIC BOJAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(179, '299', 'Golubovic Milena', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(180, '475', 'GOŠOVIÆ MARKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(181, '340', 'Gradska Opština Golubovci', 'Golubovci bb', '02647109', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(182, '261', 'Grbovic  Esad', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(183, '205', 'Grbovic Nihada', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(184, '346', 'GREENEL DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(185, '114', 'Grto Bijelo Polje provjeri', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(186, '538', 'GRUPA GRAÐANA BIRAM BAR', 'RISTA LEKICA D12/2 85000', NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(187, '366', 'GULIVER DOO', 'Hercegovacka 10', '02904870', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(188, '185', 'Hard discount Lakovic  doo', NULL, '02739500', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(189, '129', 'Haus majstor doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(190, '372', 'HEC MANAGEMENT COMPANY', 'Jadranski pt bb,Milocer', '02709457', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(191, '605', 'HEMERA DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(192, '57', 'Herc international doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(193, '69', 'Hipotekarna banka', 'Josipa Broza Tita 67', '02085020', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(194, '530', 'HOFFMANN-LA ROCHE LTD DIO STARNOG DRUSTVA', 'SVETLANE KANE RADEVIC BR.3', '02639408', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(195, '209', 'Hosteli i turizam doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 34, 1),
(196, '240', 'Hot  moon  drustvo za ugostiteljstvo, trgovinu i t', NULL, '02377390', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(197, '208', 'Hotel Jadran', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 34, 1),
(198, '521', 'HOTEL SIDRO DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(199, '38', 'Hotels group Montenegro Stars  doo', 'Becici', '02358040', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(200, '359', 'ICENTAR', 'radoja dakica bb', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(201, '442', 'ILIC VEDRAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(202, '260', 'Ilincic Vukic', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(203, '204', 'Industriaimport - Industriaimpex', NULL, '02013576', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(204, '219', 'Infobiro  doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(205, '255', 'Infocom doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(206, '201', 'Information Technology Service', NULL, '02749386', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(207, '87', 'Ingreated property contractor ser.Montenegro LTD', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(208, '447', 'INSTITUT ALTERNATIVA', 'Bul.Dzordza Vasingtona br.57 I/20', '02682320', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(209, '160', 'Institut sertifikovanih racunovodja CG', 'Dr Vukasina Markovica 114', '02617927', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(210, '544', 'INSTITUT ZA DRUŠTVENO ODGOVORNO POSLOVANJE CG', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(211, '297', 'Institut za javnu politiku', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(212, '183', 'Institut za strateške studije i projekcije', 'Ul.CRNOGORSKIH SERDARA,LAMELA C I-II', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(213, '99', 'Internacionalni TV festival', NULL, '02317451', NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(214, '132', 'Investiciono razvojni fond Crne Gore', NULL, '022417937', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(215, '636', 'ISTORIJSKI INSTITUT UCG', 'BULEVAR REVOLUCIJE 5', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(216, '189', 'ITS Information tehnology service', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(217, '175', 'ITV Movie SRL', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 19, 1),
(218, '315', 'IVANOVIÆ IVAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(219, '301', 'Jakovljevic Mirko', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(220, '403', 'JANJUŠEVIÈ ANDRIJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(221, '491', 'JANKOVIC NEMANJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(222, '507', 'JASOVIC DANKA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(223, '241', 'Javni izvrsitelj  Sinisa  Mugosa', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(224, '398', 'Javni izvrsitelj Kekovic Dejan', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(225, '488', 'JAVNI IZVRSITELJ MIROVIC MITAR', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 32, 1),
(226, '486', 'Javni izvrsitelj Rakovic Darko', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(227, '92', 'Jerkov Kristina', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(228, '578', 'JOKIC MILAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(229, '267', 'Jovanovic  Ratka', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(230, '532', 'JOVANOVIC RADOJE', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(231, '386', 'Jovovic Dejan', NULL, NULL, '20/31-00135-0', 1, NULL, NULL, NULL, NULL, 28, 1),
(232, '480', 'JP Aerodromi Crne Gore', 'Aerodrom bb p.fax 202', '02305623', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(233, '151', 'JP Morsko dobro Crne Gore', 'Ul.Popa Jola Zeca bb', '02116146', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(234, '622', 'JP PARKING SERVIS ', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 11, 1),
(235, '218', 'JP Regionalni vodovod Crnogorsko Primorje', 'Trg Sunca bb', '02090198', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(236, '405', 'JPU IRENA RADOVIÆ', 'LAZARA ÐUROVIÆA BB', '02039648', NULL, 1, NULL, NULL, NULL, NULL, 7, 1),
(237, '22', 'JU ,, Ratkoviceve veceri poezije ,,', NULL, '02894246', NULL, 1, NULL, NULL, NULL, NULL, 3, 1),
(238, '574', 'JU CENTAR ZA DNEVNI BORAVAK CETINJE', 'BAJICE BB 81250 CETINJE', '02949989', NULL, 1, NULL, NULL, NULL, NULL, 6, 1),
(239, '352', 'JU CENTAR ZA KULTURU - TIVAT', 'UL. LUKE TOMANOVICA 4', '02015218', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(240, '449', 'JU CENTAR ZA KULTURU DANILOVGRAD', 'TRG 9 DECEMBAR BB', NULL, NULL, 1, NULL, NULL, NULL, NULL, 7, 1),
(241, '568', 'JU CENTAR ZA SOCIJALNI RAD ZA OPSTINU DANILOVGRAD', 'ULICA BIJELOG PAVLA BB 81410 DANILOVGRAD', '03105687', NULL, 1, NULL, NULL, NULL, NULL, 7, 1),
(242, '429', 'JU Dnevni centar Pljevlja ', 'ul.Voja Djenisijevica 14', '02848252', NULL, 1, NULL, NULL, NULL, NULL, 27, 1),
(243, '545', 'JU GRAD TEATAR', '13 JULA BB', '02105152', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(244, '502', 'JU MUZEJI I GALERIJE BUDVE', 'UL.CARA DUSANA 19, Stari grad', '03017575', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(245, '632', 'JU MUZICKA SKOLA TIVAT', 'UL.STANIÆICA BB-KALIMANJ', NULL, NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(246, '344', 'JU Muzicki centar Crne Gore', 'Bulevar Dzordza Vasingtona bb', '02464535', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(247, '634', 'JU POMORSKI MUZEJ CG KOTOR', 'TRG BOKELJSKE MORNARICE 391-ST.GRAD KO', '02012685', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(248, '481', 'JU SERGEJ STANIC', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(249, '239', 'JU VSS POLICIJSKA AKADEMIJA', 'Bozova glavica bb', NULL, NULL, 1, NULL, NULL, NULL, NULL, 7, 1),
(250, '390', 'JU Zavod \"Komanski most\"-Podgorica', 'Gornja Gorica bb', '02016923', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(251, '594', 'JUGOINSPEKT CONTROL DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(252, '383', 'JUGOPETROL AD', 'Stanka Dragojevica bb', '02013258', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(253, '125', 'JUK Herceg Fest', 'Ul. Njegoseva bb ', NULL, NULL, 1, NULL, NULL, NULL, NULL, 11, 1),
(254, '321', 'JUQS DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(255, '322', 'JZU DOM ZDRAVLJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(256, '523', 'JZU DOM ZDRAVLJA ', 'DOBROTA BB 85330 KOTOR', '02032643', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(257, '630', 'KALANJ STEVO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(258, '17', 'Kalezic  Nenad', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(259, '452', 'KALUDJEROVIC ILIJA', NULL, NULL, '30/31-17489-8', 1, NULL, NULL, NULL, NULL, 28, 1),
(260, '529', 'KARISMA HOTELS ADRIATIC MONTENEGRO DOO', 'CETINJSKA BR.11 V SPRAT DCAPITAL PLAZA CENTAR', '03134687', '30/31-17669-6', 1, NULL, NULL, NULL, NULL, 28, 1),
(261, '576', 'Karisma Hotels Management Montenegro doo', 'Cetinjska 11 Podgorica', '03150054', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(262, '631', 'KAVARIC GROUP DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(263, '262', 'Kern Ivan', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(264, '563', 'KK BUDUCNOST VOLI', 'NJEGOSEV PARK BB', '02044463', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(265, '58', 'KKL', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 12, 1),
(266, '330', 'KNJIGA PROMET DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(267, '422', 'KOMNENOVIC MAJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(268, '508', 'Komora fizioterapeuta Crne Gore', NULL, '03143465', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(269, '237', 'Komora javnih izvrsitelja', NULL, '02968479', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(270, '30', 'Komunalno - stambeno javno preduzece ,,Budva,,', NULL, '02005719', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(271, '657', 'KONOBA BANDICI', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(272, '654', 'KONOBA LOLA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(273, '588', 'KONSTATINOVSKI SLAVN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(274, '376', 'KORAC ALEKSANDAR', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(275, '4', 'Kotor art  nvo', 'Stari grad 456', '02351838', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(276, '542', 'KOTOR ART DOO', 'SV VRACA BR3/2 85330-KOTOR', '03193659', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(277, '271', 'Kovacevic  Zoran', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(278, '316', 'KRGOVIC RAJKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(279, '140', 'Krgovic Rajko-duplo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(280, '615', 'KRUNIC IVANA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(281, '49', 'Kulturni centar Nikola Djurkovic', 'Stari grad bb', '02012952', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(282, '550', 'KULTURNO INFORMATIVNI CENTAR BIJELI PAVLE', 'Hotel Gostilje 81410', NULL, NULL, 1, NULL, NULL, NULL, NULL, 7, 1),
(283, '106', 'Kvir Montenegro', NULL, '02936267', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(284, '188', 'Kvisko Doo', 'Neznanih Junaka 52', '02369818', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(285, '379', 'LABOVIÆ STEFAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(286, '440', 'LACEVIC SAMIR', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(287, '306', 'LACKY ART DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(288, '601', 'LAKICEVIC MARIJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(289, '640', 'LATIC ISMET', 'Lagatore bb ', '1004980271993', NULL, 1, NULL, NULL, NULL, NULL, 25, 1),
(290, '67', 'LGBT Forum Progres', NULL, '02821419', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(291, '274', 'Living pictures doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(292, '116', 'Ljetopis doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(293, '278', 'Ljumovic  Nikola', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(294, '616', 'LOPICIC DEJAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(295, '470', 'LOVCEN AUTO AD PODGORICA', NULL, '02830043', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(296, '311', 'LOVCEN OSIGURANJE', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(297, '10', 'Luka Bar  ad', NULL, '02002558', NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(298, '333', 'LUKA KOTOR', 'PARK SLOBODE 1 85330 KOTOR', '020441188', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(299, '518', 'LUMONTE', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 3, 1),
(300, '250', 'Lustica Development', 'Novo Naselje bb', '02744597', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(301, '3', 'Magna  doo', NULL, '02710153', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(302, '655', 'MAISON DU MONDE-finestra pro doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 11, 1),
(303, '387', 'MANOJLOVIC VUK', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(304, '266', 'Maras Vladimir', NULL, NULL, '30/31-12090-9', 1, NULL, NULL, NULL, NULL, NULL, 1),
(305, '583', 'Marco Polo Travel doo', 'Radoja Dakica bb,novi city kvart', '02920905', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(306, '479', 'MARIN MED', 'STARI GRAD BR.444', '03043452', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(307, '285', 'Markovic  Miodrag', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(308, '434', 'MARKOVIC ANA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(309, '435', 'MARKOVIC NIKOLA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(310, '385', 'MARKOVIC SASA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(311, '300', 'Markovic Vlado', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(312, '194', 'Marunovic  Danilo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(313, '249', 'Marunovic Slobodan', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(314, '337', 'MAŠINSKI FAKULTET CRNE GORE', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(315, '451', 'MATOVIC DRAGO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(316, '263', 'Matt  Whiffen', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(317, '571', 'MAXIM INVESTMENT DOO', NULL, NULL, '30/31-15759-4', 1, NULL, NULL, NULL, NULL, 28, 1),
(318, '343', 'MAY FEST MONTENEGRO DOO', 'Beogradska 16A', '03083284', '91/31-01777-1', 1, NULL, NULL, NULL, NULL, 28, 1),
(319, '637', 'MC2 DOO', '85320 TIVAT,21 NOVEMBAR 2A', '03186784', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(320, '184', 'Me - Net doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(321, '130', 'Media Communis S', NULL, NULL, '30/31-10118-1', 1, NULL, NULL, NULL, NULL, NULL, 1),
(322, '445', 'Media Connection doo', 'Bul.Ivana Crnojeviæa 2B', '02820650', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(323, '581', 'MEDIA DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(324, '190', 'Media Montenegro doo', NULL, '02061988', '80/31-00622-9', 1, NULL, NULL, NULL, NULL, NULL, 1),
(325, '456', 'MEDIA PRO doo', NULL, '02380820', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(326, '162', 'Media Support $ Consulting doo', NULL, '20864095', NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(327, '580', 'MEDIA TERRA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(328, '286', 'Medijski savjet za samoregulaciju Crne Gore', 'Bul.Svetog Petra Cetinjskog br.9', '02874512', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(329, '562', 'MEPRO DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(330, '393', 'Merit Montenegro doo', NULL, '03075958', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(331, '45', 'Micanovic Dusan', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(332, '441', 'MIJATOVIC DRAGAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(333, '16', 'Mijovic  Mirjana', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(334, '279', 'Mikulic  Zoran', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(335, '460', 'MILIÆEVIÈ NEMANJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(336, '458', 'MILOSEVIC TANJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(337, '465', 'MILOŠEVIÈ MIRKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(338, '14', 'Ministarstvo ekonomije', NULL, '02010780', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(339, '298', 'Ministarstvo finansija', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(340, '575', 'MINISTARSTVO JAVNE UPRAVE', 'RIMSKITRG BR 45', '11018220', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(341, '226', 'Ministarstvo kulture', 'Ulica Njergoseva bb 81250 Cetinje', '02372126', NULL, 1, NULL, NULL, NULL, NULL, 6, 1),
(342, '165', 'Ministarstvo nauke', 'Rimski Trg', '02821613', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(343, '50', 'Ministarstvo odrzivog razvoja i turizma', 'Cetvrte proleterske br.19', '02760517', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(344, '111', 'Ministarstvo poljoprivrede i ruralnog razvoja', 'Rimski Trg 46', '02030802', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(345, '467', 'Ministarstvo prosvjete ', 'Vaka Djurovica bb', '02014432', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(346, '56', 'Ministarstvo rada i socijalnog staranja', 'Rimski trg 46', '02759837', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(347, '51', 'Ministarstvo saobracaja i pomorstva', 'rimski trg 46', '02156369', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(348, '112', 'Ministarstvo unutrasnjih poslova', NULL, '02016010', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(349, '62', 'Ministarstvo vanjskih poslova i evropskih integrac', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(350, '25', 'Ministarstvo za inform.  drustvo i telekomunikacij', 'Rimski trg 45', '02742365', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(351, '516', 'MINISTARSTVO ZDRAVLJA', 'Rimski trg br.46', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(352, '329', 'Mirkovic Zeljka', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(353, '625', 'MIROSS doo', 'Marka Miljanova 1/1', '02274086', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(354, '382', 'MIROSS TRAVEL AGENCY DOO', 'Majke Jevrosime br.19', '100048877', NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(355, '149', 'Misahara jewelry doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(356, '139', 'Misurovic  Lazar', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(357, '181', 'Misurovic Mirjana', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(358, '361', 'MOBILELAND DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(359, '257', 'Modni krojacki atelje LidaMard.me', NULL, '02944308', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(360, '504', 'MONA CG', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(361, '653', 'MONA HOTEL MENAGEMENT DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 35, 1),
(362, '210', 'Mondaine doo', 'ulica 4.jula.zgrada Zetagradnje,ulaz111,5/74', '02977290', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(363, '347', 'MONDOAUTO DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(364, '159', 'Monte - HU Trading', NULL, '02995204', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(365, '626', 'MONTE EVENTS DOO ULCINJ', 'VOJA LAKCEVICA BB', '03240380', NULL, 1, NULL, NULL, NULL, NULL, 32, 1),
(366, '302', 'Monteguma ', NULL, '02246333', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(367, '167', 'Montekargo AD', NULL, '02011298', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(368, '109', 'Montenegro advertising AND production - MAPA', 'ul. 19 Decembra br.13', '02321360', '30-31-08386-8', 1, NULL, NULL, NULL, NULL, 28, 1),
(369, '77', 'Montenegro airlines ad', 'Bulevar Sv.Perta Cetinjskog 130', '02737175', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(370, '206', 'Montenegro bet NVO', NULL, '2789191', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(371, '499', 'MONTENEGRO EVENT AGENCY DOO', 'Vasa Raickovica 31', '02787962', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(372, '462', 'MONTENEGRO TOURIST SERVICE DOO', 'STUDENTSKA BB,LAMELA 7', '02685825', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(373, '243', 'Montenomaks', NULL, '02378426', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(374, '331', 'MONTEPASS DOO', NULL, NULL, '30/31-13542-6', 1, NULL, NULL, NULL, NULL, 28, 1),
(375, '552', 'MONTEPASS DOO-ddduuuploo', 'DALMATINSKA ', '02882094', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(376, '658', 'MORSKI TALAS DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(377, '242', 'Mos - av doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(378, '505', 'MPM DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(379, '531', 'MRVALJEVIC VESELUN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(380, '212', 'MSI invest', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(381, '510', 'MUJOVIC DARKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(382, '319', 'MULTICOM RETALI DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 21, 1),
(383, '174', 'Nacionalna bibl. CG Djurdj Crnojevic', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 6, 1),
(384, '39', 'Nacionalna turisticka organizacija CG', 'Marka Miljanova br.17', '02242505', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(385, '148', 'Nacionalni parkovi Crne Gore', 'Trg Becir - bega Osmanagica br.16', '02039460', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(386, '54', 'Nacionalno udruzenje somelijera Crne Gore', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(387, '395', 'NATENANE PRODUCTION DOO', 'Piperska 369 Podgorica', '03024288', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(388, '512', 'NATURAL CAKE', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(389, '416', 'NEDELJKOVIC MILICA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(390, '401', 'NET MONTENEGRO DOO', 'Bul.Dzodza Vasingtona br 51', '03076067', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(391, '135', 'Nevladina Fondacija KKL-JNF Balkan', NULL, '02956608', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(392, '211', 'New media team doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(393, '202', 'Nimas doo', NULL, '03009076', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(394, '27', 'NIN doo', 'Zorza Klemansoa 19', '100061871', NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(395, '629', 'NINA APARTMENTS', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(396, '607', 'NINAMEDIA KLIPING DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(397, '534', 'NJUNJIC PREDRAG', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(398, '597', 'NLB Banka Podgorica', 'Stanka Dragojevica 46', '02011395', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(399, '123', 'Norveski konzulat', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(400, '197', 'Notar Adzic Jadranka', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(401, '224', 'Notar Darko Curic', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(402, '214', 'Notar Tanja Cepic', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(403, '199', 'Nova lira', NULL, '02648857', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(404, '280', 'Novakovic  Sanja', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(405, '358', 'nu grota -ko je ovo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(406, '341', 'NVO \"Searock\"', 'Sv.Stasije L13/8', '02906198', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(407, '40', 'NVO Centar za inicijative iz oblasti odrzivog turi', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(408, '170', 'NVO Evropski pokret u Crnoj Gori', 'Vasa Raickovica 9,I sprat', '02321998', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(409, '173', 'NVO Karampana', NULL, '02906651', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(410, '336', 'NVO KONVENCIJA ZENA ZAPADNOG BALKANA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(411, '81', 'NVO Kotor ART-DDUPLA SIFRA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(412, '1', 'NVO kotorski festival pozorista za djecu', NULL, '02401070', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(413, '543', 'NVO MEDITERANSKE NOTE', 'KRALJA NIKOLE BR.126 81000 ', '11035159', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(414, '431', 'NVO MLADI ROMI ', 'BratstvAa Jedinstva br 19/8', '02440989', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(415, '222', 'NVO Udruzenje studenata ek. i menadz. AIESEC CG', NULL, '02764318', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(416, '641', 'NVO ZERO WASTE MONTENEGRO', 'VUKA KARADZICA 29', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(417, '617', 'NVU MAŠKARADA ', 'POD KUK BB 85320 TIVAT', '11009182', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(418, '353', 'OFFICE CENTER MOTORS DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(419, '487', 'OHM MAMULA MONTENEGRO DSD', 'NOVO NASELJE BB 85323', '03095924', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(420, '268', 'Oivivio  doo', NULL, '102884591', NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(421, '308', 'OJU MUZEJI ', 'Stari grad bb', '02012669', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(422, '567', 'OKOV DOO', 'JOSIPA BROZA TITA BR.26  81000 PODGORICA', '02226782', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(423, '196', 'Omniauto - AS doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(424, '108', 'OO DPS Cetinje', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(425, '163', 'Oprema doo', NULL, '02299950', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(426, '287', 'Opstina  Kotor', 'Stari Grad 315', '02012936', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(427, '171', 'Opstina  Pljevlja', 'Kralja Petra I broj 48', '02019868', NULL, 1, NULL, NULL, NULL, NULL, 27, 1),
(428, '110', 'Opstina Bar', 'Bulevar Revolucije br.1', '02015099', NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(429, '89', 'Opstina Berane', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(430, '107', 'Opstina Bijelo Polje', NULL, '02003554', NULL, 1, NULL, NULL, NULL, NULL, 3, 1),
(431, '75', 'Opstina Budva', 'Trg Sunca br.3', '02005409', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(432, '101', 'Opstina Cetinje', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(433, '41', 'Opstina Danilovgrad', 'Trg 9. decembra', '02000156', NULL, 1, NULL, NULL, NULL, NULL, 7, 1),
(434, '351', 'Opstina Herceg Novi', 'Trg Marsala Tita 2', '02008459', NULL, 1, NULL, NULL, NULL, NULL, 11, 1),
(435, '164', 'Opstina Herceg Novi-----DUPLA SIFRA', NULL, '2008459', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(436, '12', 'Opstina Kolasin', NULL, '02017725', NULL, 1, NULL, NULL, NULL, NULL, 13, 1),
(437, '356', 'Opstina Mojkovac ', 'Trg Ljubomira Bakoca', '02007100', NULL, 1, NULL, NULL, NULL, NULL, 20, 1),
(438, '20', 'Opstina Niksic', NULL, '02021633', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(439, '158', 'Opstina Tivat', 'Trg Magnolija', '02008599', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(440, '154', 'Opstina Zabljak', NULL, '02018535', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(441, '509', 'OPSTINSKI ODBOR DPS TIVAT', 'ul.II Dalmatinske br.3/a', NULL, NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(442, '585', 'OPTIMUS PRIME INFORMATIKA DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 34, 1),
(443, '100', 'OR doo', 'Novaka Miloseva br.42', '02088762', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(444, '453', 'ORSUS INTERNATIONAL DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(445, '454', 'OSMANOVIC RUZMIR', NULL, NULL, '80/31-00073-5', 1, NULL, NULL, NULL, NULL, 28, 1),
(446, '515', 'PADRINO MONT DOO', 'RONKULA BB ', '02262622', NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(447, '444', 'PAPAGAJ DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 8, 1),
(448, '628', 'PARKING SERVIS  HERCEG NOVI DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 11, 1),
(449, '565', 'PARKING SERVIS DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(450, '570', 'Parkovi Dinarida NVO', 'Bulevar Radoja Dakica Lamela C ulaz 1', '03026230', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(451, '582', 'PAUNOVIÆ NADJA', NULL, '1604976215253', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(452, '18', 'Paunovic  Dusan', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(453, '560', 'PAVICEVIC MILICA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(454, '326', 'PEJOVIC BORIS', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(455, '236', 'Pendo Danilo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(456, '254', 'Peric  Jovan', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(457, '492', 'PERIC ILIJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(458, '554', 'PEROVIÆ  ÈADJENOVIÆ BOJANA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(459, '392', 'petrovic ilija-pomoc za andjelu', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(460, '528', 'PIPEROVIC TATJANA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(461, '556', 'PIPPOS YACHT SUPPLIJES DOO', NULL, NULL, '20/30-002828-', 1, NULL, NULL, NULL, NULL, 31, 1),
(462, '427', 'Pivara \"Trebjesa” DOO', 'Njegoševa 18', '0204983', '91/31-00735-0', 1, NULL, NULL, NULL, NULL, 21, 1),
(463, '378', 'PM Hotels Tivat', 'Obala bb', '0279020', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(464, '128', 'POC Knightsbrdige schools Montenegro', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(465, '103', 'Pocek Balsa', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(466, '648', 'Podgoricka banka ad Member of OTP group', 'Bulevar Revolucije 17', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(467, '423', 'PODVOLAT U.R BIFE', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(468, '391', 'Poliplan 1to1 DOO', 'Vuka Karadzica 49', '106104861', NULL, 1, NULL, NULL, NULL, NULL, 26, 1),
(469, '590', 'Pomilio Blumm srl', 'Via venezia 4, 65121 PESCARA-ITALY', '01304780685', NULL, 1, NULL, NULL, NULL, NULL, 24, 1),
(470, '642', 'POP ART STUDIO', 'IVAN ANDABAK', NULL, NULL, 1, NULL, NULL, NULL, NULL, 29, 1),
(471, '520', 'POPOVIC BOBAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(472, '290', 'Poreska uprava', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(473, '334', 'PORT OF  ADRIA ', 'OBALA 13JULA BB 85000', NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(474, '633', 'PORTA APERTA DOO PG', 'MOSKOVSKA 127/9', '02743922', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(475, '177', 'Portal press', 'Djoka Mirasevica 67a', '02770237', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(476, '47', 'Posta Crne Gore  doo', 'ul.Slobode br.1', '02867940', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(477, '74', 'PR $ Media Consultancy - prime Consultancy doo', NULL, '02835878', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(478, '88', 'Prijestonica Cetinje', 'Ul Bajova 2', '02005115', NULL, 1, NULL, NULL, NULL, NULL, 6, 1),
(479, '144', 'Prirodnjacki muzej  Crne  Gore', 'TRG VOJVODE BECIR BEGA OSMANAGICA 16', '02239329', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(480, '213', 'Prisma  doo', 'ljesnica bb', '02373394', NULL, 1, NULL, NULL, NULL, NULL, 3, 1),
(481, '381', 'Privredna Komora Crne Gore', 'Novaka Miloseva br.29/II', '02019574', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(482, '182', 'Projektna kancelarija Njemacke Raz. banke - KFW', NULL, '02853213', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(483, '11', 'Prva banka Crne Gore ad', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(484, '374', 'PURIC BOSKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(485, '63', 'PVK Jadran', NULL, '02018608', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(486, '457', 'QUANTUM DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(487, '105', 'Queer Montenegro nvo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(488, '514', 'R-2000 DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(489, '317', 'RADENOVIC MILICA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(490, '535', 'RADOVIC DRASKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(491, '146', 'Radovic Milos', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(492, '115', 'Radulovic Jovan', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(493, '638', 'RADULOVIC TIJANA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(494, '436', 'RADULOVIC ZORAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(495, '9', 'Raimont international company doo', NULL, '02742217', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(496, '494', 'RAJKOVIC VESNA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(497, '19', 'Rakocevic  Balsa', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(498, '410', 'RAŠKA7523 doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(499, '145', 'Rasovic Dusko', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(500, '166', 'Refill', NULL, '02435900', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(501, '276', 'Regionalni centar za zivotnu sredinu REC', NULL, '02419815', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(502, '645', 'RENTA A MOTO DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(503, '121', 'Represent Communications doo', 'Bulevar Dzordza Vašingtona br.65', '02851822', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(504, '283', 'ReSPA - Regional School of Public', 'Branelovica bb', NULL, NULL, 1, NULL, NULL, NULL, NULL, 7, 1),
(505, '506', 'RESTORAN KONAK', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 6, 1),
(506, '526', 'RESTORAN MAJKA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(507, '558', 'RIANA MONTENEGRO HOLDINGS DOO', 'BUL IVANA CRNOJEVICA 99/2', '02790190', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(508, '455', 'RID DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(509, '6', 'Ringier Axel Springer  doo', NULL, '100000889', NULL, 1, NULL, NULL, NULL, NULL, 2, 1);
INSERT INTO `partners` (`id`, `code`, `name`, `address`, `pib`, `pdv`, `isActive`, `note`, `created_at`, `updated_at`, `partner_type_id`, `city_id`, `user_id`) VALUES
(510, '83', 'RLC DOO PODGORICA', 'VUKICE MITROVIC 16b', '02778289', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(511, '136', 'Roksped - Auto centar', NULL, '02096552', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(512, '363', 'ROMA BOJAN MEDIC SP', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(513, '404', 'RUNNING KLUB NVO', NULL, NULL, '30/31-02804-2', 1, NULL, NULL, NULL, NULL, 28, 1),
(514, '364', 'Ruža vjetrova doo', 'Veliki pijesak bb', '02172879', NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(515, '604', 'SALAS 23 DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(516, '614', 'ŠAPURIÈ ŽELJKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(517, '60', 'Sava Montenegro', NULL, '02303388', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(518, '611', 'SAVEZ EKONOMISTA SRBIJE ', 'BULEVAR MIHAJLA PUPINA 147 NOVI BEOGRAD', NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(519, '408', 'SAVJET ZA EKOLOSKU GRADNJU CG', 'Ivangradska bb', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(520, '484', 'SAVJETNIK DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(521, '258', 'Scepanovic Ana', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(522, '600', 'SCEPANOVIC MAJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(523, '541', 'Sekretarijat za kult i drustv djelatn-Opstina Tiva', 'Trg magnolije 1   85320-Tivat', NULL, NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(524, '448', 'Sekretarijat za kulturu glavnog grada', 'Marka Miljanova br.4', '02029710', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(525, '439', 'SENIC DEJAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(526, '643', 'SIGMA DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(527, '533', 'SIMANIC DRAGANA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(528, '141', 'Simic Jelena', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(529, '546', 'SIMICEVIC VELJKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(530, '231', 'Sindikat medija Crne Gore', NULL, '02927179', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(531, '269', 'Sindikat odbrane i vojske Crne Gore', NULL, '02808285', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(532, '84', 'Sindikat uprave policije', NULL, '02632241', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(533, '288', 'Sindikat zdravstva Crne Gore', NULL, '02749564', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(534, '124', 'Sipa', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(535, '603', 'SKIJALIŠTA CRNE GORE', 'Bulevar Revolucije br.11 81000 Podgorica', '03168816', NULL, 1, NULL, NULL, NULL, NULL, 20, 1),
(536, '464', 'SKUPŠTINA CRNE GORE', 'Bul.Sv.Petra Cetinjskog 10', '02017482', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(537, '296', 'Skupstina Etaznih Vlasnika-SEV', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(538, '656', 'SLASH PRO DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(539, '415', 'SLUZBENI LIST JU', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(540, '13', 'Societe generale Montenegro', NULL, '02136228', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(541, '324', 'SOCIJALDEMOKRATE CRNE GORE', 'BULEVAR DZORDZA VASINGTONA 24/2', '11008283', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(542, '134', 'Socijalisticka narodna partija Crne Gore', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(543, '620', 'ŠOFRANAC ANA', NULL, '0311992259995', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(544, '646', 'SOHO GRADNJA DOO BAR', 'BULEVAR REVOLUCIJE 10A', '03037347', NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(545, '498', 'SPEKTROOM OD', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 30, 1),
(546, '396', 'Srdjan Bozovic 0910992260021', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(547, '659', 'STADIO DOO-RESTORAN 100 MANIRA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(548, '407', 'Stambena zgrada Dobrota', 'ŠKRDIO BB', '02936097', NULL, 1, NULL, NULL, NULL, NULL, 9, 1),
(549, '400', 'STAMBENA ZGRADA -ulica nova dalm A1', 'NOVA DALMATINSKA A1', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(550, '293', 'Stanisic Sladjana', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(551, '247', 'Stanisic Slobodan', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(552, '540', 'STEAM TRADE DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(553, '411', 'STOJANOVIC  NEGOVAN ALEKSANDRA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 22, 1),
(554, '73', 'Strana NVO ,,EAST - WEST,,management institute INC', NULL, '02803933', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(555, '220', 'Stratex Montenegro sales and marketing doo', 'Ulica Popa Jola Zeca br 2-zgrada regionalnog vodov', '02990954', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(556, '304', 'STUDIO VIDEO M', 'Slokanova ulica 5', NULL, NULL, 1, NULL, NULL, NULL, NULL, 18, 1),
(557, '138', 'Studio X doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(558, '78', 'Stylos doo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(559, '549', 'ŠUBERIÈ BIBEROVIC VANJA ', NULL, '1709974235024', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(560, '503', 'SUD ZA PREKRSAJE', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(561, '437', 'SULJEVIC SALINDA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(562, '420', 'SUMICOM', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(563, '612', 'SUN POWER DOO', 'BOGISICI BB', '03067173', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(564, '527', 'SUTAJ EDITA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(565, '291', 'SWISSMONT', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(566, '31', 'Synergy  doo', 'ul.Slobode br.78/II', '02836670', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(567, '178', 'T mobile', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(568, '517', 'TATAR MILAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(569, '244', 'Tehno centar Knezevic', NULL, '02698242', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(570, '118', 'Tehno max doo', NULL, '02404281', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(571, '200', 'Telemach ad', NULL, '02811618', '20/31-00099-0', 1, NULL, NULL, NULL, NULL, NULL, 1),
(572, '414', 'TELENOR DOO', 'RIMSKI TRG BR.4', '02242974', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(573, '307', 'TELENOR FONDACIJA', 'Rimski Trg 4', '02980819', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(574, '117', 'Tena doo', NULL, '02095882', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(575, '312', 'TIJANIÈ NINA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(576, '602', 'TK MULTISPORT AKADEMIJA MAYER ', 'ANDRIJE PALTASICA 26 81000 PODGORICA', '11011802', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(577, '221', 'Tmusic Svetlana', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(578, '537', 'TNT NVO', 'UL BORA I RAMIZA', '02721970', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(579, '335', 'TOMAŠEVIÆ MILOŠ', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 21, 1),
(580, '413', 'TORTE CAROLIJA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(581, '98', 'Toshiba ttde spa djenova dio stranog drustva', NULL, '02918102', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(582, '368', 'TRADEUNIQUE CG DOO', 'TQ PLAZA MEDITERANSKA BB', '02398311', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(583, '593', 'TRAPARA VLADISLAV', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(584, '525', 'TRAVELUXE', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(585, '15', 'Trezor za rjesavanje', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(586, '595', 'Turisricka organizacija Prijestonice Cetinje', 'Njegoseva br.39', '02427273', NULL, 1, NULL, NULL, NULL, NULL, 6, 1),
(587, '277', 'Turisticka organizacija  Tivat', 'PALIH BORACA 19', '02428695', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(588, '44', 'Turisticka organizacija Budva', 'Mediteranska 8/6 (TQ Plaza)', '02410575', NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(589, '150', 'Turisticka organizacija Kotor', 'Stari Grad 315', '02439425', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(590, '446', 'Turisticka organizacija Mojkovac', 'ul.Serdara Janka Vukotica ', '02696789', NULL, 1, NULL, NULL, NULL, NULL, 20, 1),
(591, '176', 'Turisticka organizacija opstina  Bar', 'Obala 13.jula bb', '02421933', NULL, 1, NULL, NULL, NULL, NULL, 1, 1),
(592, '230', 'Turisticka organizacija Podgorice', 'ul Slobode 30', '02431688', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(593, '161', 'Turisticka organizacija Ulcinj', 'Bulevar Majke Tereze  bb-zgrada Idea market', '02770881', NULL, 1, NULL, NULL, NULL, NULL, 32, 1),
(594, '627', 'Turisticka organizacija Zabljak', 'Trg Durmitorskih ratnika bb', NULL, NULL, 1, NULL, NULL, NULL, NULL, 33, 1),
(595, '599', 'UCG Metalursko-tehnoloski fakultet', 'Cetinjski put', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(596, '598', 'UCG Pomorski fakultet', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(597, '426', 'UCG-Fakultet za sport i fizicko vaspitanje', 'Narodne omladine bb 81400-Niksic', NULL, NULL, 1, NULL, NULL, NULL, NULL, 21, 1),
(598, '649', 'UCG-INSTITUT ZA BIOLOGIJU MORA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(599, '650', 'UDRUZENJE VODOVODA CG', 'VELJKA VLAHOVICA BR 34', '02313146', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(600, '309', 'ULTRA SJAJ DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(601, '59', 'UNHCR', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(602, '424', 'UNIBRAND MONTENEGRO DOO', 'Dobrota br.25', '02867184', '40/31-00075-6', 1, NULL, NULL, NULL, NULL, 15, 1),
(603, '367', 'UNIPROM NIKSIC ', 'Novaka Ramova br.17', '02049520', NULL, 1, NULL, NULL, NULL, NULL, 21, 1),
(604, '511', 'UNITED CONSULTING TEAM-RESTORAN MAJKA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(605, '332', 'UNITED NATIONS DEVELOPMENT', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(606, '168', 'Univerzitet  Donja Gorica', 'Donja Gorica', '02779129', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(607, '256', 'Univerzitet Crne Gore  ', NULL, '02016702', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(608, '26', 'Uprava carina Crne Gore', NULL, '02305631', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(609, '496', 'UPRAVA ZA IGRE NA SRECU', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(610, '66', 'Uprava za inspekcijske poslove', NULL, '02869993', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(611, '2', 'Uprava za sume', NULL, '02345196', NULL, 1, NULL, NULL, NULL, NULL, 27, 1),
(612, '320', 'VALTEC DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(613, '432', 'Vaterpolo plivaèki savez', 'Šuranj,zgrada LOP.FAH 33', '02392992', NULL, 1, NULL, NULL, NULL, NULL, 15, 1),
(614, '472', 'VATROGASNO DRUSTVO ILIREKS', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(615, '591', 'VIDEONET DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, 1),
(616, '647', 'VISION EVENT DOO', 'MOSKOVSKA 65', '02633922', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(617, '606', 'VITRUVIJE DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 5, 1),
(618, '23', 'Vlada Crne Gore  -  Generalni Sekretarijat', NULL, '02010666', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(619, '566', 'VLAHOVIÆ DEJAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(620, '553', 'VLAHOVIC ALEKSANDAR', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(621, '539', 'VODACOM DOO', 'LUKE TOMANOVICA BR.2  85320 TIVAT', '02426331', NULL, 1, NULL, NULL, NULL, NULL, 31, 1),
(622, '207', 'Vodovod i kanalizacija', NULL, '02015641', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(623, '46', 'Vojvodic  Vladimir', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(624, '43', 'Voli trade doo', NULL, '02227312', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(625, '365', 'VOX + CONSULTING DOO', 'Veljka Vlahovica 40,IV sprat,st 51', '03046826', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(626, '229', 'Vrhovni sud Crne Gore', NULL, '02010577', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(627, '246', 'Vucinic Srecko - 2205967780039', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(628, '273', 'Vucinic Vladimir', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(629, '289', 'Vuèje doo', NULL, '02770156', NULL, 1, NULL, NULL, NULL, NULL, 21, 1),
(630, '490', 'VUGDELIC DUSICA', NULL, NULL, '30/31-01167-0', 1, NULL, NULL, NULL, NULL, 28, 1),
(631, '251', 'Vujacic ID  doo', 'cijevna bb', '02316994', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(632, '355', 'Vujaèiæ Marko', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(633, '248', 'Vujosevic Ivona', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(634, '443', 'VUJOSEVIC VUKSA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(635, '264', 'Vujovic  Zarko', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(636, '419', 'VUKAJLOVIC MARKO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(637, '314', 'VUKÈEVIÆ IVAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(638, '373', 'Vukèeviæ Veselin', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(639, '245', 'Vukovic Selver - 1705984220070', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(640, '493', 'VULEKOVIC DUSAN', NULL, NULL, '30/31-19882-7', 1, NULL, NULL, NULL, NULL, 28, 1),
(641, '587', 'WEB MEDIA GROUP DOO', 'SERDARA JOLA PILETICA 8/1', '032225879', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(642, '76', 'Yellow Event service  doo', NULL, '02416174', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(643, '37', 'Zajednica Jevreja u Crnoj Gori', 'Filipa Lainovica 19,stan 17', '02927276', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(644, '555', 'ZAJEDNICA OPSTINA CRNE GORE', 'ULICA AVDA MEÐEDOVIÆA BR.138', '02018772', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(645, '126', 'Zanatsko preduzetnicka komora Crne Gore', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(646, '388', 'Zavod za statistiku', 'IV Proleterske', '02011506', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(647, '281', 'Zavod za udzbenike i nastavna sredstva', NULL, '02242052', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(648, '52', 'Zavod za zaposljavanje CG', 'BUL. REVOLUCIJE 3', NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(649, '90', 'Zecevic Nenad', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(650, '91', 'Zecevic Predrag', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(651, '524', 'ZEKOVIC MILENA', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(652, '584', 'ŽELJEZNICA CG SEKTOR ZA PREVOZ', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(653, '53', 'Zeljeznicka infrastruktura Crne Gore', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(654, '55', 'Zeljeznicki prevoz Crne Gore', 'Trg golootockih zrtava 13', '02723620', NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(655, '354', 'Živaljeviæ Rade', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(656, '559', 'ZONES DOO', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1),
(657, '295', 'Zukovic Edin', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1),
(658, '323', 'ZVICER DEJAN', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 28, 1);

-- --------------------------------------------------------

--
-- Table structure for table `partner_types`
--

CREATE TABLE `partner_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `partner_types`
--

INSERT INTO `partner_types` (`id`, `name`, `isActive`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Pravno lice', 1, 1, NULL, NULL),
(2, 'Fizicko lice', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `isActive`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Naručeno', 1, 1, NULL, NULL),
(2, 'Prihvaćeno', 1, 1, NULL, NULL),
(3, 'Odbijeno', 1, 1, NULL, NULL),
(4, 'U izradi', 1, 1, NULL, NULL),
(5, 'Završeno', 1, 1, NULL, NULL),
(6, 'Kompletirano', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `partner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `isActive`, `created_at`, `updated_at`, `partner_id`, `language_id`) VALUES
(1, 'Administrator', 'admin', '$2y$10$vTdIdVw7Hf6znLUxQxdW5OZMATE/8DTyJl1JnfhPvBNaybZTbwcAa', 1, NULL, NULL, NULL, 1),
(2, 'Petar Radunović', 'petarr', '$2y$10$8GuKitPJLIbIMqwNHFmlFO1GXTpm6xZ/Bzlvnwr7yVlxpJ4YrZJ8m', 1, NULL, NULL, NULL, 1),
(3, 'Mirjana Mišurović', 'mirjanam', '$2y$10$FmrIcs/3ypi0PUw.K.bnmuB7j4eoJi2SV0XLxDaIE1BAPUPcqMDae', 1, NULL, NULL, NULL, 1),
(4, 'Dušan Paunović', 'dusanp', '$2y$10$UgD2y9QuDiPm7MVthYIVheBxKpgu.6EeP9Q4mdb0/9PsnjaXQCWvO', 1, NULL, NULL, NULL, 1),
(5, 'Lazar Mišurović', 'lazarm', '$2y$10$hlzc.n23JklxpoquFJ/b/uqCAb9aGIQWGpytlf8p/2TJg/qEbBbq.', 1, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `plates` varchar(191) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `type`, `plates`, `user_id`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 'Renault Clio 1.5dci', 'PG FB-792', 1, 1, NULL, NULL),
(2, 'Renault Clio 1.5dci', 'PG HE-218', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `surname` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`id`, `name`, `surname`, `isActive`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Rajko', 'Krgović', 1, 1, NULL, NULL),
(2, 'Zoran', 'Mikulić', 1, 1, NULL, NULL),
(3, 'Dušan', 'Paunović', 1, 1, NULL, NULL),
(4, 'Jovan', 'Perić', 1, 1, NULL, NULL),
(5, 'Tijana', 'Radulović', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `worker_types`
--

CREATE TABLE `worker_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_croatian_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `worker_types`
--

INSERT INTO `worker_types` (`id`, `name`, `isActive`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Snimatelj', 1, 1, NULL, NULL),
(2, 'Montažer', 1, 1, NULL, NULL),
(3, 'Organizator', 1, 1, NULL, NULL),
(4, 'Novinar', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `worker_type_workers`
--

CREATE TABLE `worker_type_workers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `worker_type_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `worker_type_workers`
--

INSERT INTO `worker_type_workers` (`id`, `worker_id`, `worker_type_id`, `user_id`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 1, 1, NULL, NULL),
(2, 3, 1, 1, 1, NULL, NULL),
(3, 1, 1, 1, 1, NULL, NULL),
(4, 2, 1, 1, 1, NULL, NULL),
(5, 4, 2, 1, 1, NULL, NULL),
(6, 4, 3, 1, 1, NULL, NULL),
(7, 4, 4, 1, 1, NULL, NULL),
(8, 5, 2, 1, 1, NULL, NULL),
(9, 5, 4, 1, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banks_user_id_foreign` (`user_id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_bank_id_foreign` (`bank_id`),
  ADD KEY `bank_accounts_partner_id_foreign` (`partner_id`),
  ADD KEY `bank_accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`),
  ADD KEY `cities_user_id_foreign` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_evidention_id_foreign` (`evidention_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_partner_id_foreign` (`partner_id`),
  ADD KEY `contacts_contact_type_id_foreign` (`contact_type_id`),
  ADD KEY `contacts_user_id_foreign` (`user_id`);

--
-- Indexes for table `contact_people`
--
ALTER TABLE `contact_people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_people_user_id_foreign` (`user_id`),
  ADD KEY `contact_people_partner_id_foreign` (`partner_id`);

--
-- Indexes for table `contact_types`
--
ALTER TABLE `contact_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_types_user_id_foreign` (`user_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contracts_partner_id_foreign` (`partner_id`),
  ADD KEY `contracts_user_id_foreign` (`user_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_user_id_foreign` (`user_id`);

--
-- Indexes for table `evidentions`
--
ALTER TABLE `evidentions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evidentions_contract_id_foreign` (`contract_id`),
  ADD KEY `evidentions_city_id_foreign` (`city_id`),
  ADD KEY `evidentions_user_id_foreign` (`user_id`);

--
-- Indexes for table `evidention_items`
--
ALTER TABLE `evidention_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evidention_items_item_id_foreign` (`item_id`),
  ADD KEY `evidention_items_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `evidention_items_evidention_id_foreign` (`evidention_id`),
  ADD KEY `evidention_items_user_id_foreign` (`user_id`);

--
-- Indexes for table `evidention_statuses`
--
ALTER TABLE `evidention_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evidention_statuses_status_id_foreign` (`status_id`),
  ADD KEY `evidention_statuses_evidention_id_foreign` (`evidention_id`),
  ADD KEY `evidention_statuses_user_id_foreign` (`user_id`);

--
-- Indexes for table `evidention_workers`
--
ALTER TABLE `evidention_workers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evidention_workers_evidention_id_foreign` (`evidention_id`),
  ADD KEY `evidention_workers_worker_id_foreign` (`worker_id`),
  ADD KEY `evidention_workers_worker_type_id_foreign` (`worker_type_id`),
  ADD KEY `evidention_workers_user_id_foreign` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_user_id_foreign` (`user_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_evidention_id_foreign` (`evidention_id`);

--
-- Indexes for table `notification_users`
--
ALTER TABLE `notification_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notification_users_user_id_foreign` (`user_id`),
  ADD KEY `notification_users_evidention_id_foreign` (`evidention_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partners_partner_type_id_foreign` (`partner_type_id`),
  ADD KEY `partners_city_id_foreign` (`city_id`),
  ADD KEY `partners_user_id_foreign` (`user_id`);

--
-- Indexes for table `partner_types`
--
ALTER TABLE `partner_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_types_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statuses_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_language_id_foreign` (`language_id`),
  ADD KEY `users_partner_id_foreign` (`partner_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workers_user_id_foreign` (`user_id`);

--
-- Indexes for table `worker_types`
--
ALTER TABLE `worker_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `worker_types_user_id_foreign` (`user_id`);

--
-- Indexes for table `worker_type_workers`
--
ALTER TABLE `worker_type_workers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `worker_type_workers_worker_id_foreign` (`worker_id`),
  ADD KEY `worker_type_workers_worker_type_id_foreign` (`worker_type_id`),
  ADD KEY `worker_type_workers_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_people`
--
ALTER TABLE `contact_people`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_types`
--
ALTER TABLE `contact_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `evidentions`
--
ALTER TABLE `evidentions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evidention_items`
--
ALTER TABLE `evidention_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evidention_statuses`
--
ALTER TABLE `evidention_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evidention_workers`
--
ALTER TABLE `evidention_workers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_users`
--
ALTER TABLE `notification_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=659;

--
-- AUTO_INCREMENT for table `partner_types`
--
ALTER TABLE `partner_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `worker_types`
--
ALTER TABLE `worker_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `worker_type_workers`
--
ALTER TABLE `worker_type_workers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banks`
--
ALTER TABLE `banks`
  ADD CONSTRAINT `banks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  ADD CONSTRAINT `bank_accounts_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  ADD CONSTRAINT `bank_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `cities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_evidention_id_foreign` FOREIGN KEY (`evidention_id`) REFERENCES `evidentions` (`id`),
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_contact_type_id_foreign` FOREIGN KEY (`contact_type_id`) REFERENCES `contact_types` (`id`),
  ADD CONSTRAINT `contacts_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  ADD CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contact_people`
--
ALTER TABLE `contact_people`
  ADD CONSTRAINT `contact_people_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  ADD CONSTRAINT `contact_people_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contact_types`
--
ALTER TABLE `contact_types`
  ADD CONSTRAINT `contact_types_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  ADD CONSTRAINT `contracts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `countries`
--
ALTER TABLE `countries`
  ADD CONSTRAINT `countries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `evidentions`
--
ALTER TABLE `evidentions`
  ADD CONSTRAINT `evidentions_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `evidentions_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  ADD CONSTRAINT `evidentions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `evidention_items`
--
ALTER TABLE `evidention_items`
  ADD CONSTRAINT `evidention_items_evidention_id_foreign` FOREIGN KEY (`evidention_id`) REFERENCES `evidentions` (`id`),
  ADD CONSTRAINT `evidention_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `evidention_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `evidention_items_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

--
-- Constraints for table `evidention_statuses`
--
ALTER TABLE `evidention_statuses`
  ADD CONSTRAINT `evidention_statuses_evidention_id_foreign` FOREIGN KEY (`evidention_id`) REFERENCES `evidentions` (`id`),
  ADD CONSTRAINT `evidention_statuses_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `evidention_statuses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `evidention_workers`
--
ALTER TABLE `evidention_workers`
  ADD CONSTRAINT `evidention_workers_evidention_id_foreign` FOREIGN KEY (`evidention_id`) REFERENCES `evidentions` (`id`),
  ADD CONSTRAINT `evidention_workers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `evidention_workers_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`id`),
  ADD CONSTRAINT `evidention_workers_worker_type_id_foreign` FOREIGN KEY (`worker_type_id`) REFERENCES `worker_types` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_evidention_id_foreign` FOREIGN KEY (`evidention_id`) REFERENCES `evidentions` (`id`),
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notification_users`
--
ALTER TABLE `notification_users`
  ADD CONSTRAINT `notification_users_evidention_id_foreign` FOREIGN KEY (`evidention_id`) REFERENCES `evidentions` (`id`),
  ADD CONSTRAINT `notification_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `partners`
--
ALTER TABLE `partners`
  ADD CONSTRAINT `partners_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `partners_partner_type_id_foreign` FOREIGN KEY (`partner_type_id`) REFERENCES `partner_types` (`id`),
  ADD CONSTRAINT `partners_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `partner_types`
--
ALTER TABLE `partner_types`
  ADD CONSTRAINT `partner_types_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `statuses`
--
ALTER TABLE `statuses`
  ADD CONSTRAINT `statuses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `users_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);

--
-- Constraints for table `workers`
--
ALTER TABLE `workers`
  ADD CONSTRAINT `workers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `worker_types`
--
ALTER TABLE `worker_types`
  ADD CONSTRAINT `worker_types_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `worker_type_workers`
--
ALTER TABLE `worker_type_workers`
  ADD CONSTRAINT `worker_type_workers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `worker_type_workers_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`id`),
  ADD CONSTRAINT `worker_type_workers_worker_type_id_foreign` FOREIGN KEY (`worker_type_id`) REFERENCES `worker_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
