-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2024 at 03:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_soulhousing`
--

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `occupied_at` varchar(255) NOT NULL,
  `booked_till` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `date_of_birth` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `home_phone` longtext DEFAULT NULL,
  `work_phone` longtext DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `method_of_contact` varchar(255) DEFAULT NULL,
  `support_contact` enum('1','0') NOT NULL DEFAULT '0',
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `indefinitely` enum('1','0') NOT NULL DEFAULT '0',
  `power_of_attorney` enum('1','0') NOT NULL DEFAULT '0',
  `from_date2` varchar(255) DEFAULT NULL,
  `to_date2` varchar(255) DEFAULT NULL,
  `status2` varchar(255) DEFAULT NULL,
  `indefinitely2` enum('1','0') NOT NULL DEFAULT '0',
  `power_of_attorney2` enum('1','0') NOT NULL DEFAULT '0',
  `from_date3` varchar(255) DEFAULT NULL,
  `to_date3` varchar(255) DEFAULT NULL,
  `status3` varchar(255) DEFAULT NULL,
  `indefinitely3` enum('1','0') NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `encounter_note_sections`
--

CREATE TABLE `encounter_note_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `encounter_id` bigint(20) UNSIGNED NOT NULL,
  `section_title` varchar(255) DEFAULT NULL,
  `section_slug` varchar(255) DEFAULT NULL,
  `section_text` longtext DEFAULT NULL,
  `sorting_order` varchar(255) DEFAULT NULL,
  `attached_entities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attached_entities`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `encounter_note_sections`
--

INSERT INTO `encounter_note_sections` (`id`, `encounter_id`, `section_title`, `section_slug`, `section_text`, `sorting_order`, `attached_entities`, `created_at`, `updated_at`) VALUES
(9, 3, 'chief_complained', 'chief-complained', 'Text Added', NULL, NULL, '2024-04-06 05:01:31', '2024-04-06 10:34:19'),
(10, 3, 'history', 'history', NULL, NULL, NULL, '2024-04-06 05:01:31', '2024-04-06 05:01:31'),
(11, 3, 'medical_history', 'medical-history', NULL, NULL, NULL, '2024-04-06 05:01:31', '2024-04-06 05:01:31'),
(12, 3, 'surgical_history', 'surgical-history', NULL, NULL, NULL, '2024-04-06 05:01:31', '2024-04-06 05:01:31'),
(13, 3, 'family_history', 'family-history', NULL, NULL, NULL, '2024-04-06 05:01:31', '2024-04-06 05:01:31'),
(14, 3, 'social_history', 'social-history', NULL, NULL, NULL, '2024-04-06 05:01:31', '2024-04-06 05:01:31'),
(15, 3, 'allergies', 'allergies', NULL, NULL, NULL, '2024-04-06 05:01:31', '2024-04-06 05:01:31'),
(16, 3, 'medications', 'medications', NULL, NULL, NULL, '2024-04-06 05:01:31', '2024-04-06 05:01:31');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE `floors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facility_id` varchar(255) NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `floor_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurances`
--

CREATE TABLE `insurances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `effective_date` varchar(255) NOT NULL,
  `effective_date_end` varchar(255) NOT NULL,
  `policy_number` varchar(255) NOT NULL,
  `group_number` varchar(255) NOT NULL,
  `subscriber_employee` varchar(255) NOT NULL,
  `se_address` varchar(255) NOT NULL,
  `se_address_2` varchar(255) NOT NULL,
  `se_city` varchar(255) NOT NULL,
  `se_state` varchar(255) NOT NULL,
  `se_zip_code` varchar(255) NOT NULL,
  `se_country` varchar(255) NOT NULL,
  `relationship` varchar(255) NOT NULL,
  `subscriber` varchar(255) NOT NULL,
  `date_of_birth` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `s_s` varchar(255) DEFAULT NULL,
  `subscriber_address` longtext NOT NULL,
  `subscriber_address2` longtext NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `subscriber_phone` varchar(255) DEFAULT NULL,
  `co_pay` varchar(255) NOT NULL,
  `accept_assignment` varchar(255) NOT NULL,
  `secondary_medicare_type` longtext DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medications`
--

CREATE TABLE `medications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `favourite_medication` varchar(255) NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `user_free_text` varchar(255) NOT NULL DEFAULT '0',
  `prescribe_date` varchar(255) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `dosage_unit` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `days_supply` varchar(255) NOT NULL,
  `refills` varchar(255) NOT NULL,
  `dispense` varchar(255) NOT NULL,
  `dispense_unit` varchar(255) NOT NULL,
  `primary_diagnosis` varchar(255) NOT NULL,
  `secondary_diagnosis` varchar(255) NOT NULL,
  `substitutions` varchar(255) NOT NULL DEFAULT '0',
  `one_time` varchar(255) NOT NULL DEFAULT '0',
  `prn` varchar(255) NOT NULL DEFAULT '0',
  `administered` varchar(255) NOT NULL DEFAULT '0',
  `prn_options` varchar(255) DEFAULT NULL,
  `patient_directions` longtext NOT NULL,
  `additional_sig` longtext DEFAULT NULL,
  `status` enum('inactive','active') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_04_01_063455_create_personal_access_tokens_table', 1),
(5, '2024_04_01_071837_create_patients_table', 1),
(6, '2024_04_01_080823_create_insurances_table', 1),
(7, '2024_04_01_103901_create_contacts_table', 1),
(8, '2024_04_01_111829_create_problems_table', 1),
(9, '2024_04_02_073532_create_floors_table', 1),
(10, '2024_04_02_073539_create_rooms_table', 1),
(11, '2024_04_02_073544_create_beds_table', 1),
(12, '2024_04_02_104409_create_pins_table', 1),
(13, '2024_04_02_110012_create_notifications_table', 1),
(14, '2024_04_02_110353_create_user_details_table', 1),
(15, '2024_04_03_064855_create_medications_table', 1),
(16, '2024_04_04_093210_create_patient_encounters_table', 1),
(17, '2024_04_04_093638_create_encounter_note_sections_table', 1),
(18, '2024_04_06_090058_create_review_of_systems_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `recipient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `show_to` varchar(255) NOT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) NOT NULL,
  `ssn` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `date_of_birth` varchar(255) NOT NULL,
  `general_identity` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `pharmacy` varchar(255) NOT NULL,
  `address_1` longtext NOT NULL,
  `address_2` longtext DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `suffix_1` varchar(255) NOT NULL,
  `ssn_1` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `provider_id`, `patient_id`, `first_name`, `middle_name`, `last_name`, `nick_name`, `suffix`, `ssn`, `gender`, `date_of_birth`, `general_identity`, `other`, `location`, `pharmacy`, `address_1`, `address_2`, `city`, `state`, `suffix_1`, `ssn_1`, `zip_code`, `country`, `status`, `created_at`, `updated_at`) VALUES
(1, 21, '24041', 'John', NULL, 'Nick', 'sam_nic', '771', 'abc', 'Make', '03-01-2003', 'volt', NULL, 'Abc Address', 'No', 'Street # 1', NULL, 'James', 'Lesture', '881', 'hjm#1', '8831', 'London', '1', '2024-04-06 03:24:36', '2024-04-06 03:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `patient_encounters`
--

CREATE TABLE `patient_encounters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `signed_by` bigint(20) UNSIGNED NOT NULL,
  `signed_at` varchar(255) NOT NULL,
  `encounter_type` varchar(255) NOT NULL,
  `encounter_template` varchar(255) NOT NULL,
  `reason` longtext NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_encounters`
--

INSERT INTO `patient_encounters` (`id`, `provider_id`, `patient_id`, `signed_by`, `signed_at`, `encounter_type`, `encounter_template`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(3, 21, 1, 21, '03-01-2003', 'singal Edit', 'Second Thing', 'A Lot of reaons available', '1', '2024-04-06 05:01:31', '2024-04-06 05:05:54');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 21, 'Laravel', '42f37dcb17e7b00dde384b673a4bbf05a4d4637deb35ee647f5e4455bf3ea5fa', '[\"*\"]', '2024-04-15 08:44:37', NULL, '2024-04-06 03:23:54', '2024-04-15 08:44:37'),
(2, 'App\\Models\\User', 21, 'Laravel', '6f19c0e4fdad9efc30080eb28f3e9ca586415f6dc9b0d8e94f4924db655719b9', '[\"*\"]', '2024-04-15 00:29:32', NULL, '2024-04-15 00:29:21', '2024-04-15 00:29:32');

-- --------------------------------------------------------

--
-- Table structure for table `pins`
--

CREATE TABLE `pins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `pin` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `diagnosis` longtext NOT NULL,
  `cd_description` longtext NOT NULL,
  `select_1` varchar(255) DEFAULT NULL,
  `select_2` varchar(255) DEFAULT NULL,
  `select_3` varchar(255) DEFAULT NULL,
  `select_4` varchar(255) DEFAULT NULL,
  `select_5` varchar(255) DEFAULT NULL,
  `comments` longtext NOT NULL,
  `icd10` varchar(255) DEFAULT NULL,
  `snowed` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_of_systems`
--

CREATE TABLE `review_of_systems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `constitutional` varchar(255) NOT NULL DEFAULT 'All Good',
  `heent` varchar(255) NOT NULL DEFAULT 'All Good',
  `cv` varchar(255) NOT NULL DEFAULT 'All Good',
  `gi` varchar(255) NOT NULL DEFAULT 'All Good',
  `gu` varchar(255) NOT NULL DEFAULT 'All Good',
  `musculoskeletal` varchar(255) NOT NULL DEFAULT 'All Good',
  `skin` varchar(255) NOT NULL DEFAULT 'All Good',
  `psychiatric` varchar(255) NOT NULL DEFAULT 'All Good',
  `endocrine` varchar(255) NOT NULL DEFAULT 'All Good',
  `physical_exam` varchar(255) NOT NULL DEFAULT 'All Good',
  `general_appearance` varchar(255) NOT NULL DEFAULT 'All Good',
  `head_and_neck` varchar(255) NOT NULL DEFAULT 'All Good',
  `eyes` varchar(255) NOT NULL DEFAULT 'All Good',
  `ears` varchar(255) NOT NULL DEFAULT 'All Good',
  `nose` varchar(255) NOT NULL DEFAULT 'All Good',
  `mouth_and_throat` varchar(255) NOT NULL DEFAULT 'All Good',
  `cardiovascular` varchar(255) NOT NULL DEFAULT 'All Good',
  `respiratory_system` varchar(255) NOT NULL DEFAULT 'All Good',
  `abdomen` varchar(255) NOT NULL DEFAULT 'All Good',
  `musculoskeletal_system` varchar(255) NOT NULL DEFAULT 'All Good',
  `neurological_system` varchar(255) NOT NULL DEFAULT 'All Good',
  `genitourinary_system` varchar(255) NOT NULL DEFAULT 'All Good',
  `psychosocial_assessment` varchar(255) NOT NULL DEFAULT 'All Good',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review_of_systems`
--

INSERT INTO `review_of_systems` (`id`, `provider_id`, `patient_id`, `constitutional`, `heent`, `cv`, `gi`, `gu`, `musculoskeletal`, `skin`, `psychiatric`, `endocrine`, `physical_exam`, `general_appearance`, `head_and_neck`, `eyes`, `ears`, `nose`, `mouth_and_throat`, `cardiovascular`, `respiratory_system`, `abdomen`, `musculoskeletal_system`, `neurological_system`, `genitourinary_system`, `psychosocial_assessment`, `created_at`, `updated_at`) VALUES
(2, 21, 1, 'All not God Edit', 'All Good', 'CV Edit', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', 'All Good', '2024-04-06 04:29:05', '2024-04-06 04:44:52');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `floor_id` bigint(20) UNSIGNED NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('47ll9p2biSQ8nI7gRWTCVeubC7J42WCVVQerlI1B', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMENGbmJrejAzbHh0SW9Na3BPMDZtM2J0blVjY05MN2ZraFNFZ2Z4NSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1712420060),
('AhMjgKjmFBtbzZykAN7L7SMu8oUYjNiJOYYAVd76', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoibTNxYjlPZWx2a0dnSjBHY0Q2S01EMjJuQm1wM3cxVXBFZ0RWOVI1ciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1713188377),
('imY6GblQlbKrbQJGMyksHJfeCR9AFwhmCAnEOBK7', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidm5DenpBVmpsSXNENTBYaUJyNWw3Uk0ydDJyZTJmSDVVelNOT09uZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6NDUwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1713159846),
('pvxKyAdOuqG9dPAHbjvSuBiDPDgkHFBEBN1DbS18', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXJQQWhieUlOQm9XYWVLWThZWDdSOXRSUlV0WDBOOFdIOHZIY1UwWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712562044);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'provider',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `user_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(21, 'Doctor', 'provider@gmail.com', NULL, '$2y$12$2dT2vzAcs8IwHKJND6o6bOGg2mwmw26n4wsNUqnVm6lZySlfPWJZi', 'provider', NULL, '2024-04-06 08:23:25', '2024-04-06 03:23:54'),
(22, 'abc', 'abc@gmail.com', NULL, '$2y$12$0ZQP.h4WkN1xL4FQknk4D.SGwaqdsbnT1Qg.rSrjtlgKWKVxFCzBy', 'provider', NULL, '2024-04-06 11:14:08', '2024-04-06 11:14:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `image` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `image`, `created_at`, `updated_at`) VALUES
(2, 22, NULL, '2024-04-06 11:14:09', '2024-04-06 11:14:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beds_room_id_foreign` (`room_id`),
  ADD KEY `beds_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_provider_id_foreign` (`provider_id`),
  ADD KEY `contacts_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `encounter_note_sections`
--
ALTER TABLE `encounter_note_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `encounter_note_sections_encounter_id_foreign` (`encounter_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `floors_provider_id_foreign` (`provider_id`);

--
-- Indexes for table `insurances`
--
ALTER TABLE `insurances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurances_provider_id_foreign` (`provider_id`),
  ADD KEY `insurances_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medications`
--
ALTER TABLE `medications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medications_provider_id_foreign` (`provider_id`),
  ADD KEY `medications_patient_id_foreign` (`patient_id`);

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
  ADD KEY `notifications_sender_id_foreign` (`sender_id`),
  ADD KEY `notifications_recipient_id_foreign` (`recipient_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_provider_id_foreign` (`provider_id`);

--
-- Indexes for table `patient_encounters`
--
ALTER TABLE `patient_encounters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_encounters_provider_id_foreign` (`provider_id`),
  ADD KEY `patient_encounters_patient_id_foreign` (`patient_id`),
  ADD KEY `patient_encounters_signed_by_foreign` (`signed_by`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pins`
--
ALTER TABLE `pins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pins_provider_id_foreign` (`provider_id`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `problems_provider_id_foreign` (`provider_id`),
  ADD KEY `problems_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `review_of_systems`
--
ALTER TABLE `review_of_systems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_of_systems_provider_id_foreign` (`provider_id`),
  ADD KEY `review_of_systems_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_floor_id_foreign` (`floor_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_details_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beds`
--
ALTER TABLE `beds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encounter_note_sections`
--
ALTER TABLE `encounter_note_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurances`
--
ALTER TABLE `insurances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medications`
--
ALTER TABLE `medications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_encounters`
--
ALTER TABLE `patient_encounters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pins`
--
ALTER TABLE `pins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_of_systems`
--
ALTER TABLE `review_of_systems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beds`
--
ALTER TABLE `beds`
  ADD CONSTRAINT `beds_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `beds_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contacts_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `encounter_note_sections`
--
ALTER TABLE `encounter_note_sections`
  ADD CONSTRAINT `encounter_note_sections_encounter_id_foreign` FOREIGN KEY (`encounter_id`) REFERENCES `patient_encounters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `floors`
--
ALTER TABLE `floors`
  ADD CONSTRAINT `floors_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `insurances`
--
ALTER TABLE `insurances`
  ADD CONSTRAINT `insurances_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `insurances_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medications`
--
ALTER TABLE `medications`
  ADD CONSTRAINT `medications_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medications_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_recipient_id_foreign` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_encounters`
--
ALTER TABLE `patient_encounters`
  ADD CONSTRAINT `patient_encounters_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_encounters_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_encounters_signed_by_foreign` FOREIGN KEY (`signed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pins`
--
ALTER TABLE `pins`
  ADD CONSTRAINT `pins_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `problems_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `problems_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_of_systems`
--
ALTER TABLE `review_of_systems`
  ADD CONSTRAINT `review_of_systems_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_of_systems_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
