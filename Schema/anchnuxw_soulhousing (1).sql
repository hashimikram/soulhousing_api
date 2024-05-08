-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 08, 2024 at 05:13 AM
-- Server version: 10.6.17-MariaDB-cll-lve-log
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anchnuxw_soulhousing`
--

-- --------------------------------------------------------

--
-- Table structure for table `allergies`
--

CREATE TABLE `allergies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `allergy_type` bigint(20) UNSIGNED NOT NULL,
  `reaction` bigint(20) UNSIGNED DEFAULT NULL,
  `severity` bigint(20) UNSIGNED DEFAULT NULL,
  `allergy` varchar(255) NOT NULL,
  `onset_date` varchar(255) DEFAULT NULL,
  `comments` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bed_no` varchar(255) NOT NULL,
  `bed_title` varchar(255) DEFAULT NULL,
  `comments` longtext DEFAULT NULL,
  `occupied_from` varchar(255) DEFAULT NULL,
  `booked_till` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beds`
--

INSERT INTO `beds` (`id`, `room_id`, `patient_id`, `bed_no`, `bed_title`, `comments`, `occupied_from`, `booked_till`, `status`, `created_at`, `updated_at`) VALUES
(1, 33, 1, '1', NULL, 'Oxygen, Blood', NULL, NULL, 'vacant', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(2, 33, 2, '2', NULL, 'Hydra, Water', NULL, NULL, 'pending', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(3, 33, 3, '3', NULL, 'Oxygen, Blood', '2024-04-22 12:00:00', NULL, 'occupied', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(4, 34, 1, '4', NULL, 'Oxygen, Blood', NULL, NULL, 'pending', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(5, 35, 1, '1', NULL, 'Blood', NULL, NULL, 'vacant', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(6, 35, 1, '2', NULL, 'Oxygen', NULL, NULL, 'pending', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(7, 36, 1, '1', NULL, 'Oxygen, Blood', NULL, NULL, 'vacant', '2024-05-03 16:20:29', '2024-05-03 16:20:29'),
(8, 36, 1, '2', NULL, 'Hydra, Water', NULL, NULL, 'pending', '2024-05-03 16:20:29', '2024-05-03 16:20:29'),
(9, 37, 1, '3', NULL, 'Oxygen, Blood', NULL, NULL, 'vacant', '2024-05-03 16:20:29', '2024-05-03 16:20:29'),
(10, 37, 1, '4', NULL, 'Oxygen, Blood', '2024-04-22 12:00:00', '2024-04-23 12:00:00', 'occupied', '2024-05-03 16:20:29', '2024-05-03 21:20:54'),
(11, 38, 1, '1', NULL, 'Blood', NULL, NULL, 'vacant', '2024-05-03 16:20:29', '2024-05-03 16:20:29'),
(12, 38, 1, '2', NULL, 'Oxygen', NULL, NULL, 'pending', '2024-05-03 16:20:29', '2024-05-03 16:20:29');

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
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `date` datetime NOT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `file` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `encounter_note_sections`
--

CREATE TABLE `encounter_note_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `encounter_id` bigint(20) UNSIGNED NOT NULL,
  `section_title` varchar(255) DEFAULT NULL,
  `section_slug` varchar(255) DEFAULT NULL,
  `section_text` longtext DEFAULT NULL,
  `sorting_order` varchar(255) DEFAULT NULL,
  `attached_entities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attached_entities`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `encounter_note_sections`
--

INSERT INTO `encounter_note_sections` (`id`, `provider_id`, `patient_id`, `encounter_id`, `section_title`, `section_slug`, `section_text`, `sorting_order`, `attached_entities`, `created_at`, `updated_at`) VALUES
(52, 21, 1, 5, 'Plan', 'plan', 'Plan Text', '1', NULL, '2024-05-08 12:40:22', '2024-05-08 12:40:22'),
(51, 21, 1, 5, 'Physical Examination', 'physical-examination', 'pgysical_examination Text', '1', NULL, '2024-05-08 12:40:22', '2024-05-08 12:40:22'),
(50, 21, 1, 5, 'Vital Sign', 'vital-sign', 'vital_sign Text', '1', NULL, '2024-05-08 12:40:22', '2024-05-08 12:40:22'),
(49, 21, 1, 5, 'Allergies', 'allergies', 'allergy Text', '1', NULL, '2024-05-08 12:40:22', '2024-05-08 12:40:22'),
(48, 21, 1, 5, 'Medications', 'medications', 'medication Text', '1', NULL, '2024-05-08 12:40:22', '2024-05-08 12:40:22'),
(47, 21, 1, 5, 'Social History', 'social-history', 'social_history Text', '1', NULL, '2024-05-08 12:40:22', '2024-05-08 12:40:22'),
(46, 21, 1, 5, 'Family History', 'family-history', 'family_history Text', '1', NULL, '2024-05-08 12:40:22', '2024-05-08 12:40:22'),
(43, 21, 1, 5, 'History of Present Illness', 'history-of-present-illness', 'history_of_present_illness Text', '1', NULL, '2024-05-08 12:40:22', '2024-05-08 12:40:22'),
(45, 21, 1, 5, 'Post Medical History', 'post-medical-history', 'Post Medical History Text', '1', NULL, '2024-05-08 12:40:22', '2024-05-08 12:40:22'),
(44, 21, 1, 5, 'Review of Systems', 'review-of-systems', 'review_of_systems Text', '1', NULL, '2024-05-08 12:40:22', '2024-05-08 12:40:22'),
(42, 21, 1, 5, 'Chief Complaint', 'chief-complaint', 'chief_complaint Text One 5324234242', '1', NULL, '2024-05-08 12:40:22', '2024-05-08 12:40:36');

-- --------------------------------------------------------

--
-- Table structure for table `encounter_templates`
--

CREATE TABLE `encounter_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `encounter_template` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`encounter_template`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `encounter_templates`
--

INSERT INTO `encounter_templates` (`id`, `provider_id`, `template_name`, `encounter_template`, `created_at`, `updated_at`) VALUES
(3, 21, 'First Template', '[{\"section_title\":\"Chief Complaint\",\"section_text\":null,\"sorting_order\":\"1\",\"section_slug\":\"chief_complaint\"},{\"section_title\":\"History of Present Illness\",\"section_text\":null,\"sorting_order\":\"2\",\"section_slug\":\"history_of_present_illness\"},{\"section_title\":\"Review of Systems\",\"section_text\":null,\"sorting_order\":\"3\",\"section_slug\":\"review_of_systems\"},{\"section_title\":\"Post Medical History\",\"section_text\":null,\"sorting_order\":\"4\",\"section_slug\":\"post_medical_history\"},{\"section_title\":\"Family History\",\"section_text\":null,\"sorting_order\":\"5\",\"section_slug\":\"family_history\"},{\"section_title\":\"Social History\",\"section_text\":null,\"sorting_order\":\"6\",\"section_slug\":\"social_history\"},{\"section_title\":\"Medications\",\"section_text\":null,\"sorting_order\":\"7\",\"section_slug\":\"medications\"},{\"section_title\":\"Allergies\",\"section_text\":null,\"sorting_order\":\"8\",\"section_slug\":\"allergies\"},{\"section_title\":\"Vital Sign\",\"section_text\":null,\"sorting_order\":\"9\",\"section_slug\":\"vital_sign\"},{\"section_title\":\"Physical Examination\",\"section_text\":null,\"sorting_order\":\"10\",\"section_slug\":\"physical_examination\"},{\"section_title\":\"Plan\",\"section_text\":null,\"sorting_order\":\"11\",\"section_slug\":\"plan\"}]', '2024-05-08 04:07:39', '2024-05-08 04:07:39');

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

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `facility_id`, `provider_id`, `floor_name`, `created_at`, `updated_at`) VALUES
(26, '21402', 21, 'Floor 1', '2024-05-03 07:04:57', '2024-05-03 07:04:57'),
(27, '21402', 21, 'Floor 2', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(28, '52994', 21, 'Floor 1', '2024-05-03 16:20:29', '2024-05-03 16:20:29'),
(29, '52994', 21, 'Floor 2', '2024-05-03 16:20:29', '2024-05-03 16:20:29');

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
-- Table structure for table `list_options`
--

CREATE TABLE `list_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `list_id` varchar(255) NOT NULL,
  `option_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sequence` varchar(255) NOT NULL DEFAULT '0',
  `is_default` varchar(255) NOT NULL DEFAULT '0',
  `option_value` varchar(255) NOT NULL DEFAULT '0',
  `mapping` varchar(255) DEFAULT NULL,
  `notes` longtext DEFAULT NULL,
  `codes` varchar(255) DEFAULT NULL,
  `toggle_setting_1` varchar(255) DEFAULT NULL,
  `toggle_setting_2` varchar(255) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `subtype` varchar(255) DEFAULT NULL,
  `edit_options` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `list_options`
--

INSERT INTO `list_options` (`id`, `list_id`, `option_id`, `title`, `sequence`, `is_default`, `option_value`, `mapping`, `notes`, `codes`, `toggle_setting_1`, `toggle_setting_2`, `activity`, `subtype`, `edit_options`, `created_at`, `updated_at`) VALUES
(1, 'Type', 'situation', 'Situation', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:49:52', '2024-04-26 11:49:52'),
(2, 'Type', 'problem', 'Problem', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:50:28', '2024-04-26 11:50:28'),
(3, 'Type', 'finding_of_functional_performance_and_activity', 'Finding of functional performance and activity', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:51:22', '2024-04-26 11:51:22'),
(4, 'Type', 'diagnosis_interpretation', 'Diagnosis interpretation', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:51:46', '2024-04-26 11:51:46'),
(5, 'Type', 'cognitive_function_finding', 'Cognitive function finding', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:52:07', '2024-04-26 11:52:07'),
(6, 'Type', 'clinical_finding', 'Clinical finding', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:52:27', '2024-04-26 11:52:27'),
(7, 'Type', 'complaint', 'Complaint', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:52:46', '2024-04-26 11:52:46'),
(8, 'Type', 'finding_reported_by_subject_or_history_provider', 'Finding reported by subject or history provider', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:53:06', '2024-04-26 11:53:06'),
(9, 'Type', 'disease', 'Disease', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:53:25', '2024-04-26 11:53:25'),
(10, 'Chronicity', 'chronic', 'Chronic', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:54:05', '2024-04-26 11:54:05'),
(11, 'Chronicity', 'acute', 'Acute', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:54:33', '2024-04-26 11:54:33'),
(12, 'Chronicity', 'self_limiting', 'Self Limiting', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:55:00', '2024-04-26 11:55:00'),
(13, 'Chronicity', 'intermittent', 'Intermittent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:55:19', '2024-04-26 11:55:19'),
(14, 'Chronicity', 'recurrent', 'Recurrent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:55:40', '2024-04-26 11:55:40'),
(15, 'Chronicity', 'distressful', 'Distressful', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:56:01', '2024-04-26 11:56:01'),
(16, 'Severity', 'unspecified_Severity', 'Unspecified Severity', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:56:35', '2024-04-26 11:56:35'),
(17, 'Severity', 'severe_persistent', 'Severe Persistent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:57:01', '2024-04-26 11:57:01'),
(18, 'Severity', 'moderate_persistent', 'Moderate Persistent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:57:26', '2024-04-26 11:57:26'),
(19, 'Severity', 'mild_persistent', 'Mild Persistent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:57:48', '2024-04-26 11:57:48'),
(20, 'Severity', 'mild_intermittent', 'Mild Intermittent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:58:14', '2024-04-26 11:58:14'),
(21, 'Severity', 'unknown', 'Unknown', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:58:36', '2024-04-26 11:58:36'),
(22, 'Status', 'unassigned', 'Unassigned', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:59:06', '2024-04-26 11:59:06'),
(23, 'Status', 'resolved', 'Resolved', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:59:24', '2024-04-26 11:59:24'),
(24, 'Status', 'improved', 'Improved', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:59:43', '2024-04-26 11:59:43'),
(25, 'Status', 'status_quo', 'Status Quo', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 12:00:06', '2024-04-26 12:00:06'),
(26, 'Status', 'worse', 'Worse', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 12:00:25', '2024-04-26 12:00:25'),
(27, 'Status', 'pending_follow_up', 'Pending follow Up', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 12:00:55', '2024-04-26 12:00:55'),
(28, 'Status', 'erroneous', 'Erroneous', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 12:01:14', '2024-04-26 12:01:14'),
(29, 'Status', 'duplicate', 'Duplicate', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 12:01:33', '2024-04-26 12:01:33'),
(30, 'Allergy Type', 'general', 'General', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '', '', '', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:37:46', '2024-04-29 11:37:46'),
(32, 'Allergy Type', 'drug-allergy', 'Drup Allery', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:38:10', '2024-04-29 11:38:10'),
(33, 'Allergy Type', 'substance', 'Substance/DrugClass', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:38:45', '2024-04-29 11:38:45'),
(34, 'Reaction', 'arthralgia', 'Arthralgia', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:40:25', '2024-04-29 11:40:25'),
(35, 'Reaction', 'chills', 'Chills', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:46:48', '2024-04-29 11:47:42'),
(36, 'Reaction', 'cough', 'Cough', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:46:50', '2024-04-29 11:47:44'),
(37, 'Reaction', 'fever', 'Fever', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:46:53', '2024-04-29 11:47:46'),
(38, 'Reaction', 'headache', 'Headache', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:46:56', '2024-04-29 11:47:50'),
(39, 'Reaction', 'hives', 'Hives', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:46:59', '2024-04-29 11:47:52'),
(40, 'Reaction', 'malaise', 'Malaisa/fatigue', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:47:02', '2024-04-29 11:47:54'),
(41, 'Reaction', 'myalgia', 'Myalgia', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:47:05', '2024-04-29 11:47:57'),
(42, 'Raection', 'nasal-congestion', 'Nasal Congestion', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:47:07', '2024-04-29 11:48:00'),
(43, 'Reaction', 'nausea', 'Nausea', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:47:09', '2024-04-29 11:48:02'),
(44, 'Reaction', 'pain-soreness', 'Pain/Soreness at injection site', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:47:13', '2024-04-29 11:48:05'),
(45, 'Reaction', 'rash', 'Rash', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:47:16', '2024-04-29 11:48:08'),
(46, 'Reaction', 'rhinorrhea', 'Rhinorrhea', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:47:18', '2024-04-29 11:48:10'),
(47, 'Reaction', 'shortness-breath', 'Shortness of breath/difficulty breathing', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:47:21', '2024-04-29 11:48:14'),
(48, 'Reaction', 'sore-throat', 'Sore Throat', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:47:23', '2024-04-29 11:48:16'),
(49, 'Reaction', 'swelling', 'Swelling', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:47:26', '2024-04-29 11:48:19'),
(50, 'Reaction', 'other', 'Other', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:47:38', '2024-04-29 11:48:21'),
(51, 'Encounter Type', 'ALF-healths', 'ALF-healths', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 15:57:42', '2024-05-06 15:57:42'),
(52, 'Encounter Type', 'annual_physical', 'Annual Physical', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 15:58:36', '2024-05-06 15:58:36'),
(53, 'Encounter Type', 'annual_wellness_visit', 'Annual Wellness Visit', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 15:58:36', '2024-05-06 15:58:36'),
(54, 'Encounter Type', 'cfa', 'CFA', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 15:58:36', '2024-05-06 15:58:36'),
(55, 'Encounter Type', 'covid_test_2', 'Covid Test 2', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 15:58:36', '2024-05-06 15:58:36'),
(56, 'Encounter Type', 'covid_vaccination', 'Covid Vaccination', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 15:58:36', '2024-05-06 15:58:36'),
(57, 'Encounter Type', 'health_progress', 'Health Progress', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 15:58:36', '2024-05-06 15:58:36'),
(58, 'Specialty', 'general_medicine', 'General Medicine', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 15:58:36', '2024-05-06 15:58:36');

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
(6, '2024_04_01_080823_create_insurances_table', 1),
(7, '2024_04_01_103901_create_contacts_table', 1),
(9, '2024_04_02_073532_create_floors_table', 1),
(10, '2024_04_02_073539_create_rooms_table', 1),
(12, '2024_04_02_104409_create_pins_table', 1),
(13, '2024_04_02_110012_create_notifications_table', 1),
(15, '2024_04_03_064855_create_medications_table', 1),
(24, '2024_04_22_081822_create_pysical_exams_table', 6),
(26, '2024_04_06_090058_create_review_of_systems_table', 8),
(27, '2024_04_22_082408_create_physical_exams_table', 9),
(29, '2024_04_24_072004_create_notes_table', 10),
(30, '2024_04_24_104358_create_documents_table', 11),
(31, '2024_04_02_110353_create_user_details_table', 12),
(33, '2024_04_01_111829_create_problems_table', 14),
(36, '2024_04_29_074933_create_allergies_table', 15),
(41, '2024_04_01_071837_create_patients_table', 17),
(42, '2024_04_02_073544_create_beds_table', 18),
(43, '2024_04_26_074527_create_list_options_table', 19),
(46, '2024_04_04_093210_create_patient_encounters_table', 20),
(47, '2024_04_04_093638_create_encounter_note_sections_table', 21);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `mrn_no` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) NOT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `ssn` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` varchar(255) NOT NULL,
  `general_identity` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `pharmacy` varchar(255) DEFAULT NULL,
  `address_1` longtext NOT NULL,
  `address_2` longtext DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `provider_id`, `mrn_no`, `title`, `first_name`, `middle_name`, `last_name`, `email`, `phone_no`, `nick_name`, `suffix`, `ssn`, `gender`, `date_of_birth`, `general_identity`, `other`, `location`, `pharmacy`, `address_1`, `address_2`, `city`, `state`, `country`, `zip_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 21, 'sk-0001', 'Mr', 'Usama', NULL, 'Akhtar', 'cdf@gmail.com', '43', 'sammi', '771', '772347', 'Male', '03-01-2003', 'volt', NULL, 'Abc Address', 'No', 'Street # 1', NULL, 'James', 'Lesture', 'London', '8831', '1', '2024-05-03 02:33:19', '2024-05-03 02:33:20'),
(2, 21, 'sk-0002', 'Mr', 'Ahmad', NULL, 'Raza', 'ahmad@gmail.com', '45', 'sammi', '771', '772347', 'Male', '03-01-2003', 'volt', NULL, 'Abc Address', 'No', 'Street # 1', NULL, 'James', 'Lesture', 'London', '8831', '1', '2024-05-06 11:13:55', '2024-05-06 11:13:55'),
(3, 21, 'sk-0003', 'Mr', 'Asad', NULL, 'Mustafa', 'asad@gmail.com', '46', 'sammi', '771', '772347', 'Male', '03-01-2003', 'volt', NULL, 'Abc Address', 'No', 'Street # 1', NULL, 'James', 'Lesture', 'London', '8831', '1', '2024-05-06 11:14:16', '2024-05-06 11:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `patient_encounters`
--

CREATE TABLE `patient_encounters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `provider_id_patient` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `signed_by` bigint(20) UNSIGNED NOT NULL,
  `encounter_date` varchar(255) NOT NULL,
  `encounter_type` bigint(20) UNSIGNED DEFAULT NULL,
  `specialty` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_encounter` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `reason` longtext NOT NULL,
  `attachment` longtext DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_encounters`
--

INSERT INTO `patient_encounters` (`id`, `provider_id`, `provider_id_patient`, `patient_id`, `signed_by`, `encounter_date`, `encounter_type`, `specialty`, `parent_encounter`, `location`, `reason`, `attachment`, `status`, `created_at`, `updated_at`) VALUES
(1, 21, 1, 3, 21, '2024-04-22 12:00:00', 57, 58, NULL, 'No Location Found', 'Reason', NULL, '1', '2024-05-07 10:15:00', '2024-05-07 10:15:00'),
(2, 21, 1, 3, 21, '2024-04-22 12:00:00', 57, 58, 1, 'No Location Found', 'Reason', NULL, '1', '2024-05-07 10:15:18', '2024-05-07 10:15:18'),
(3, 21, 1, 3, 21, '2024-04-22 12:00:00', 57, 58, 1, 'No Location Found', 'Reason', NULL, '1', '2024-05-07 10:48:28', '2024-05-07 10:48:28'),
(4, 21, 21, 3, 21, '2024-04-22 12:00:00', 55, 58, NULL, 'Canda', 'NA', NULL, '1', '2024-05-07 11:19:07', '2024-05-07 11:19:07'),
(5, 21, 21, 3, 21, '2024-04-22 12:00:00', 53, 58, NULL, 'na', 'NA', NULL, '1', '2024-05-07 11:22:17', '2024-05-07 11:22:17'),
(6, 21, 21, 3, 21, '2024-04-22 12:00:00', 54, 58, NULL, 'Canada', 'NA', '202405070736_6639d9e9cd96a.pdf', '1', '2024-05-07 11:36:09', '2024-05-07 11:36:09'),
(7, 21, 21, 2, 21, '2024-04-22 12:00:00', 56, 58, NULL, 'Canada', 'NA', '202405070802_6639dffbd9af2.pdf', '1', '2024-05-07 12:02:03', '2024-05-07 12:02:03'),
(8, 21, 1, 3, 21, '2024-04-22 12:00:00', 57, 58, 1, 'No Location Found', 'Reason', NULL, '1', '2024-05-08 15:32:29', '2024-05-08 15:32:29'),
(9, 21, 1, 3, 21, '2024-04-22 12:00:00', 57, 58, 1, 'No Location Found', 'Reason', NULL, '1', '2024-05-08 15:33:06', '2024-05-08 15:33:06');

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
(1, 'App\\Models\\User', 21, 'Laravel', '42f37dcb17e7b00dde384b673a4bbf05a4d4637deb35ee647f5e4455bf3ea5fa', '[\"*\"]', '2024-05-08 12:09:25', NULL, '2024-04-06 03:23:54', '2024-05-08 12:09:25'),
(2, 'App\\Models\\User', 21, 'Laravel', '6f19c0e4fdad9efc30080eb28f3e9ca586415f6dc9b0d8e94f4924db655719b9', '[\"*\"]', '2024-04-17 07:19:45', NULL, '2024-04-15 00:29:21', '2024-04-17 07:19:45'),
(3, 'App\\Models\\User', 21, 'Laravel', '11c7a0310d94575347c78331b605b285770cd58130ee70c2e62079e658ecafb0', '[\"*\"]', '2024-04-16 03:40:24', NULL, '2024-04-16 03:15:06', '2024-04-16 03:40:24'),
(4, 'App\\Models\\User', 21, 'Laravel', '4a591a54e2471205853fbbac42607c7ae3008156fce1bb6f4107c1b0c8a4b6f7', '[\"*\"]', '2024-04-22 01:51:52', NULL, '2024-04-22 01:45:35', '2024-04-22 01:51:52'),
(5, 'App\\Models\\User', 21, 'Laravel', 'b1e64a810bff6d34a7591d407a515d628b8a8f3291a6e3f35f59c9f3b1358697', '[\"*\"]', '2024-04-24 06:52:43', NULL, '2024-04-24 02:32:24', '2024-04-24 06:52:43'),
(6, 'App\\Models\\User', 21, 'Laravel', '38f12692b1045eacba98298509bf4cf699aa8d3b09638ecd182a16e5eab2cd42', '[\"*\"]', '2024-04-25 05:01:51', NULL, '2024-04-25 04:51:46', '2024-04-25 05:01:51'),
(7, 'App\\Models\\User', 21, 'Laravel', 'eb26f83e1d588c259fd89a094de980ce235c46157d18363a98603c2d8c0826ae', '[\"*\"]', '2024-04-26 05:21:35', NULL, '2024-04-26 03:10:26', '2024-04-26 05:21:35'),
(8, 'App\\Models\\User', 21, 'Laravel', '98414c125a927b80a1f62aed037a261f1e59d5be09b17f5b381f4ea3d723f3b8', '[\"*\"]', NULL, NULL, '2024-04-29 01:51:03', '2024-04-29 01:51:03'),
(9, 'App\\Models\\User', 21, 'Laravel', '4aec56065f4223d34c42020db3b7bad400e69af84ed1dae406ebe450b9382a35', '[\"*\"]', '2024-04-29 02:14:05', NULL, '2024-04-29 01:58:52', '2024-04-29 02:14:05'),
(10, 'App\\Models\\User', 21, 'Laravel', '77b073dc4b15094b1131b76af0e37791bf5efc8cc95e195ef690eaea1deb4c9f', '[\"*\"]', NULL, NULL, '2024-04-29 03:16:31', '2024-04-29 03:16:31'),
(11, 'App\\Models\\User', 21, 'Laravel', '1dd51c284c0bd82e1532d574f26a5523006d757b37489fc1f56e73499186cfaf', '[\"*\"]', '2024-04-29 03:42:39', NULL, '2024-04-29 03:16:34', '2024-04-29 03:42:39'),
(12, 'App\\Models\\User', 21, 'Laravel', '6848c237538a351c77059d88adfe34e72b5a879a035d722581b363da50316a84', '[\"*\"]', '2024-05-02 02:38:19', NULL, '2024-05-02 02:31:35', '2024-05-02 02:38:19'),
(13, 'App\\Models\\User', 21, 'Laravel', '726b18beb60fbd279a60b3dab0675b0a057ff425fc3d9526616a59d6be7825cf', '[\"*\"]', '2024-05-06 12:40:17', NULL, '2024-05-03 01:17:11', '2024-05-06 12:40:17'),
(14, 'App\\Models\\User', 21, 'Laravel', '02fed38a642491ca2630e4c56e7c3126417616eadf7446265920bbb354f43d76', '[\"*\"]', '2024-05-03 16:11:55', NULL, '2024-05-03 16:11:46', '2024-05-03 16:11:55'),
(15, 'App\\Models\\User', 21, 'Laravel', '4c66bd1b920a4323fae541a14b83c55b6a90d8055bb293c7670244e939a8968c', '[\"*\"]', '2024-05-03 16:20:29', NULL, '2024-05-03 16:20:07', '2024-05-03 16:20:29'),
(16, 'App\\Models\\User', 21, 'Laravel', '5893d75fa4e0f901bf4d79810fe8e6b47091328106d8b89c72a3b8b29c71de5a', '[\"*\"]', '2024-05-06 13:33:32', NULL, '2024-05-06 09:23:11', '2024-05-06 13:33:32'),
(17, 'App\\Models\\User', 21, 'Laravel', 'a2f5c48638b38118928e0232c5376c9250d9f39bf860ba9f2bf079ea3925e760', '[\"*\"]', '2024-05-06 16:39:44', NULL, '2024-05-06 13:33:50', '2024-05-06 16:39:44'),
(18, 'App\\Models\\User', 21, 'Laravel', '62e78e5f139eed0c8d2de8e118646ad3e62562575d951e88ccd42bbc74a8774a', '[\"*\"]', '2024-05-06 15:22:18', NULL, '2024-05-06 15:21:27', '2024-05-06 15:22:18'),
(19, 'App\\Models\\User', 21, 'Laravel', 'f1a42ce958bb60f9a7f83dac268faec06a54b712fea03289cfad79f48562ff36', '[\"*\"]', '2024-05-06 15:52:38', NULL, '2024-05-06 15:23:36', '2024-05-06 15:52:38'),
(20, 'App\\Models\\User', 21, 'Laravel', 'b8c28c0ae5015c59fd5c9361e3f39cecc4cc4d99a6e161a14523f253f10e132f', '[\"*\"]', '2024-05-06 17:18:30', NULL, '2024-05-06 15:59:38', '2024-05-06 17:18:30'),
(21, 'App\\Models\\User', 21, 'Laravel', '67b825c1f941b54a362df6f180b0d76d0d8e5f31db018c6313484f15c4ddc267', '[\"*\"]', '2024-05-07 10:44:40', NULL, '2024-05-06 16:18:08', '2024-05-07 10:44:40'),
(22, 'App\\Models\\User', 21, 'Laravel', '1ccb7e0c6bf99da16932fbf6a18f97eb94686ce9a604c51411e0696bd1183b52', '[\"*\"]', NULL, NULL, '2024-05-06 17:23:08', '2024-05-06 17:23:08'),
(23, 'App\\Models\\User', 21, 'Laravel', '747608707986b7b86e2b6b8aa347d8279ce4a321686a92fd9d4de086a0141b13', '[\"*\"]', '2024-05-06 17:23:18', NULL, '2024-05-06 17:23:08', '2024-05-06 17:23:18'),
(24, 'App\\Models\\User', 21, 'Laravel', '16b675cb0cd6d0cd15f9494d06fcafbd512e806f62496d056e9020d04f6ef9d8', '[\"*\"]', '2024-05-07 13:23:25', NULL, '2024-05-07 09:03:13', '2024-05-07 13:23:25'),
(25, 'App\\Models\\User', 21, 'Laravel', 'f42d76eb71a7fa12a3e3db3ddb36003fe8864415b57ecbaec5eec77bdfb4be54', '[\"*\"]', '2024-05-08 10:33:06', NULL, '2024-05-07 09:59:05', '2024-05-08 10:33:06'),
(26, 'App\\Models\\User', 21, 'Laravel', 'd67737cf4bea55a89000cbb1b1a11704d384c7f0a6f80d8322f3a291009c41ee', '[\"*\"]', '2024-05-07 16:08:08', NULL, '2024-05-07 14:44:42', '2024-05-07 16:08:08'),
(27, 'App\\Models\\User', 21, 'Laravel', '3b0cad8c9c9e574b0417e07249a7ec1886c656f4ef27934972b01aa21ae9df3e', '[\"*\"]', '2024-05-07 14:54:27', NULL, '2024-05-07 14:54:15', '2024-05-07 14:54:27'),
(28, 'App\\Models\\User', 21, 'Laravel', 'b3f4c3721a721dd377cba4470c2a237241bae1ab6aedc39b1ce06ae0dba539b1', '[\"*\"]', NULL, NULL, '2024-05-07 15:08:56', '2024-05-07 15:08:56'),
(29, 'App\\Models\\User', 21, 'Laravel', '271a68ce3df6073f98332e89963fc96fccb7e7e439968329597bdd6693f63eb0', '[\"*\"]', '2024-05-08 12:40:36', NULL, '2024-05-07 15:09:15', '2024-05-08 12:40:36'),
(30, 'App\\Models\\User', 21, 'Laravel', 'c88f31a1317f3085df75ba7914b860980ef325d26ddf3299169ea107f581d00b', '[\"*\"]', '2024-05-07 15:13:23', NULL, '2024-05-07 15:09:46', '2024-05-07 15:13:23'),
(31, 'App\\Models\\User', 21, 'Laravel', 'aee2f7aa374b9ef88337cfdad3d00356db8ab4ec8528e2fd95698cfc24d8d027', '[\"*\"]', '2024-05-08 12:38:38', NULL, '2024-05-08 09:25:40', '2024-05-08 12:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `physical_exams`
--

CREATE TABLE `physical_exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `encounter_id` bigint(20) UNSIGNED NOT NULL,
  `section_title` varchar(255) DEFAULT NULL,
  `section_slug` varchar(255) DEFAULT NULL,
  `section_text` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `name` longtext NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `chronicity_id` bigint(20) UNSIGNED NOT NULL,
  `severity_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `comments` longtext NOT NULL,
  `onset` varchar(255) DEFAULT NULL,
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
  `encounter_id` bigint(20) UNSIGNED NOT NULL,
  `section_title` varchar(255) DEFAULT NULL,
  `section_slug` varchar(255) DEFAULT NULL,
  `section_text` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `floor_id`, `room_name`, `created_at`, `updated_at`) VALUES
(33, 26, 'Room 1', '2024-05-03 07:04:57', '2024-05-03 07:04:57'),
(34, 26, 'Room 2', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(35, 27, 'Room 3', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(36, 28, 'Room 1', '2024-05-03 16:20:29', '2024-05-03 16:20:29'),
(37, 28, 'Room 2', '2024-05-03 16:20:29', '2024-05-03 16:20:29'),
(38, 29, 'Room 3', '2024-05-03 16:20:29', '2024-05-03 16:20:29');

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
('7xyAsYd0StVjv1wEKsVkShOER4ZI1dqhXuyfsfVI', NULL, '198.235.24.141', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWVNjQzJlWUJtam5ad1FyVG9wZmc4bG12NGVpcjJ0RUZHWFNNN0tEViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vc291bGhvdXNpbmctYXBpLmFuY2hvcnN0ZWNoLm5ldCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1714776393),
('htnZ5lmzzPSfT3igt35uYwycZKtuIBv6U1A1mC5u', NULL, '50.18.84.237', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidG9VTHJleWlMQWdXODl0a0x6SlFnNE5oN2xQSDVwYlplSjhVMlNieSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vc291bGhvdXNpbmctYXBpLmFuY2hvcnN0ZWNoLm5ldCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1714795923),
('n9YZhSnPfu5l8Ntx4CTOIyrd9fxm8PjmhaIPjYgq', NULL, '182.185.210.106', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM3JKSUgwbFJ1R3dJN2RZclVWQXFmMUpDN2g0dEs1YlZMU3ZRdGJWQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vc291bGhvdXNpbmctYXBpLmFuY2hvcnN0ZWNoLm5ldCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1715063419),
('R3wBXKQWWtPNa81yHsW1U49cj0wyzbmVx8JMJatF', NULL, '182.185.210.106', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGFONGZBQ1ZUU0dndG83MmhtVkhHMzVJNllFVWxRd0dwcTdOQktzbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vc291bGhvdXNpbmctYXBpLmFuY2hvcnN0ZWNoLm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1714993092),
('SYcmoC7jCpkyAcFCEeNwKZNC1oB07YdfJnhBPHWT', NULL, '182.185.210.106', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTklWMlplS0Izb1gybzRXYWlWbWZqaDBwQThkblNlSXRJZlFXNXdkSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vc291bGhvdXNpbmctYXBpLmFuY2hvcnN0ZWNoLm5ldCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1715063422),
('XoZdiYZkOAu70KGaIzxBqSdyy9ljRWLXNna8n7Wv', NULL, '198.235.24.5', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWEVPSU84U3QyN1I0elQ4Znp1Z2w4TGN6ME8wRUtCb0l5SmFLVXFjayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vc291bGhvdXNpbmctYXBpLmFuY2hvcnN0ZWNoLm5ldCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1715082709);

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
(21, 'new Name', 'provider@gmail.com', NULL, '$2y$12$2dT2vzAcs8IwHKJND6o6bOGg2mwmw26n4wsNUqnVm6lZySlfPWJZi', 'provider', NULL, '2024-04-06 08:23:25', '2024-04-29 01:59:01');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `home_phone` varchar(255) DEFAULT NULL,
  `npi` varchar(255) DEFAULT NULL,
  `tax_type` varchar(255) DEFAULT NULL,
  `snn` varchar(255) DEFAULT NULL,
  `ein` varchar(255) DEFAULT NULL,
  `epcs_status` varchar(255) DEFAULT NULL,
  `dea_number` varchar(255) DEFAULT NULL,
  `nadean` varchar(255) DEFAULT NULL,
  `image` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `title`, `middle_name`, `last_name`, `suffix`, `gender`, `date_of_birth`, `country`, `city`, `zip_code`, `home_phone`, `npi`, `tax_type`, `snn`, `ein`, `epcs_status`, `dea_number`, `nadean`, `image`, `created_at`, `updated_at`) VALUES
(1, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-25 09:58:30', '2024-04-25 09:58:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allergies`
--
ALTER TABLE `allergies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `allergies_provider_id_foreign` (`provider_id`),
  ADD KEY `allergies_patient_id_foreign` (`patient_id`),
  ADD KEY `allergies_allergy_type_foreign` (`allergy_type`),
  ADD KEY `allergies_reaction_foreign` (`reaction`),
  ADD KEY `allergies_severity_foreign` (`severity`);

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
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_provider_id_foreign` (`provider_id`),
  ADD KEY `documents_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `encounter_note_sections`
--
ALTER TABLE `encounter_note_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `encounter_note_sections_provider_id_foreign` (`provider_id`),
  ADD KEY `encounter_note_sections_patient_id_foreign` (`patient_id`),
  ADD KEY `encounter_note_sections_encounter_id_foreign` (`encounter_id`);

--
-- Indexes for table `encounter_templates`
--
ALTER TABLE `encounter_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `encounter_templates_provider_id_foreign` (`provider_id`);

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
-- Indexes for table `list_options`
--
ALTER TABLE `list_options`
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
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notes_provider_id_foreign` (`provider_id`),
  ADD KEY `notes_patient_id_foreign` (`patient_id`);

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
  ADD KEY `patient_encounters_provider_id_patient_foreign` (`provider_id_patient`),
  ADD KEY `patient_encounters_patient_id_foreign` (`patient_id`),
  ADD KEY `patient_encounters_signed_by_foreign` (`signed_by`),
  ADD KEY `patient_encounters_encounter_type_foreign` (`encounter_type`),
  ADD KEY `patient_encounters_specialty_foreign` (`specialty`),
  ADD KEY `patient_encounters_parent_encounter_foreign` (`parent_encounter`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `physical_exams`
--
ALTER TABLE `physical_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `physical_exams_provider_id_foreign` (`provider_id`),
  ADD KEY `physical_exams_patient_id_foreign` (`patient_id`),
  ADD KEY `physical_exams_encounter_id_foreign` (`encounter_id`);

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
  ADD KEY `problems_patient_id_foreign` (`patient_id`),
  ADD KEY `problems_type_id_foreign` (`type_id`),
  ADD KEY `problems_chronicity_id_foreign` (`chronicity_id`),
  ADD KEY `problems_severity_id_foreign` (`severity_id`),
  ADD KEY `problems_status_id_foreign` (`status_id`);

--
-- Indexes for table `review_of_systems`
--
ALTER TABLE `review_of_systems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_of_systems_provider_id_foreign` (`provider_id`),
  ADD KEY `review_of_systems_patient_id_foreign` (`patient_id`),
  ADD KEY `review_of_systems_encounter_id_foreign` (`encounter_id`);

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
-- AUTO_INCREMENT for table `allergies`
--
ALTER TABLE `allergies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `beds`
--
ALTER TABLE `beds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `encounter_note_sections`
--
ALTER TABLE `encounter_note_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `encounter_templates`
--
ALTER TABLE `encounter_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
-- AUTO_INCREMENT for table `list_options`
--
ALTER TABLE `list_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `medications`
--
ALTER TABLE `medications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patient_encounters`
--
ALTER TABLE `patient_encounters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `physical_exams`
--
ALTER TABLE `physical_exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pins`
--
ALTER TABLE `pins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `review_of_systems`
--
ALTER TABLE `review_of_systems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allergies`
--
ALTER TABLE `allergies`
  ADD CONSTRAINT `allergies_allergy_type_foreign` FOREIGN KEY (`allergy_type`) REFERENCES `list_options` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `allergies_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `allergies_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `allergies_reaction_foreign` FOREIGN KEY (`reaction`) REFERENCES `list_options` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `allergies_severity_foreign` FOREIGN KEY (`severity`) REFERENCES `list_options` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `encounter_templates`
--
ALTER TABLE `encounter_templates`
  ADD CONSTRAINT `encounter_templates_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notes_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `physical_exams`
--
ALTER TABLE `physical_exams`
  ADD CONSTRAINT `physical_exams_encounter_id_foreign` FOREIGN KEY (`encounter_id`) REFERENCES `patient_encounters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `physical_exams_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `physical_exams_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pins`
--
ALTER TABLE `pins`
  ADD CONSTRAINT `pins_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `problems_chronicity_id_foreign` FOREIGN KEY (`chronicity_id`) REFERENCES `list_options` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `problems_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `problems_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `problems_severity_id_foreign` FOREIGN KEY (`severity_id`) REFERENCES `list_options` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `problems_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `list_options` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `problems_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `list_options` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_of_systems`
--
ALTER TABLE `review_of_systems`
  ADD CONSTRAINT `review_of_systems_encounter_id_foreign` FOREIGN KEY (`encounter_id`) REFERENCES `patient_encounters` (`id`) ON DELETE CASCADE,
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
