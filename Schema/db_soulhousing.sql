-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2024 at 03:00 PM
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
(1, 33, NULL, '1', NULL, 'Oxygen, Blood', NULL, NULL, 'vacand', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(2, 33, NULL, '2', NULL, 'Hydra, Water', NULL, NULL, 'vacand', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(3, 34, NULL, '3', NULL, 'Oxygen, Blood', NULL, NULL, 'vacand', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(4, 34, NULL, '4', NULL, 'Oxygen, Blood', NULL, NULL, 'vacand', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(5, 35, NULL, '1', NULL, 'Blood', NULL, NULL, 'vacand', '2024-05-03 07:04:58', '2024-05-03 07:04:58'),
(6, 35, NULL, '2', NULL, 'Oxygen', NULL, NULL, 'vacand', '2024-05-03 07:04:58', '2024-05-03 07:04:58');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `encounter_note_sections`
--

INSERT INTO `encounter_note_sections` (`id`, `provider_id`, `patient_id`, `encounter_id`, `section_title`, `section_slug`, `section_text`, `sorting_order`, `attached_entities`, `created_at`, `updated_at`) VALUES
(223, 21, 1, 1, 'Chief Complaint', 'chief_complaint', 'Chief Complaint Text', '1', NULL, '2024-05-06 07:56:34', '2024-05-06 07:56:34'),
(224, 21, 1, 1, 'History', 'history', 'History Text', '2', NULL, '2024-05-06 07:56:34', '2024-05-06 07:56:34'),
(225, 21, 1, 1, 'Medical History', 'medical_history', 'Medical History Text', '3', NULL, '2024-05-06 07:56:34', '2024-05-06 07:56:34'),
(226, 21, 1, 1, 'Surgical History', 'surgical_history', 'Surgical History Text', '4', NULL, '2024-05-06 07:56:34', '2024-05-06 07:56:34'),
(227, 21, 1, 1, 'Family History', 'family_history', 'Family History Text', '5', NULL, '2024-05-06 07:56:34', '2024-05-06 07:56:34'),
(228, 21, 1, 1, 'Social History', 'social_history', 'Social History Text', '6', NULL, '2024-05-06 07:56:34', '2024-05-06 07:56:34'),
(229, 21, 1, 1, 'Allergies', 'allergies', 'Allergies Text', '7', NULL, '2024-05-06 07:56:34', '2024-05-06 07:56:34'),
(230, 21, 1, 1, 'Medications', 'medications', 'Medications Text', '8', NULL, '2024-05-06 07:56:35', '2024-05-06 07:56:35');

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
(27, '21402', 21, 'Floor 2', '2024-05-03 07:04:58', '2024-05-03 07:04:58');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `list_options`
--

INSERT INTO `list_options` (`id`, `list_id`, `option_id`, `title`, `sequence`, `is_default`, `option_value`, `mapping`, `notes`, `codes`, `toggle_setting_1`, `toggle_setting_2`, `activity`, `subtype`, `edit_options`, `created_at`, `updated_at`) VALUES
(1, 'Type', 'situation', 'Situation', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:49:52', '2024-04-26 07:49:52'),
(2, 'Type', 'problem', 'Problem', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:50:28', '2024-04-26 07:50:28'),
(3, 'Type', 'finding_of_functional_performance_and_activity', 'Finding of functional performance and activity', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:51:22', '2024-04-26 07:51:22'),
(4, 'Type', 'diagnosis_interpretation', 'Diagnosis interpretation', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:51:46', '2024-04-26 07:51:46'),
(5, 'Type', 'cognitive_function_finding', 'Cognitive function finding', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:52:07', '2024-04-26 07:52:07'),
(6, 'Type', 'clinical_finding', 'Clinical finding', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:52:27', '2024-04-26 07:52:27'),
(7, 'Type', 'complaint', 'Complaint', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:52:46', '2024-04-26 07:52:46'),
(8, 'Type', 'finding_reported_by_subject_or_history_provider', 'Finding reported by subject or history provider', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:53:06', '2024-04-26 07:53:06'),
(9, 'Type', 'disease', 'Disease', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:53:25', '2024-04-26 07:53:25'),
(10, 'Chronicity', 'chronic', 'Chronic', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:54:05', '2024-04-26 07:54:05'),
(11, 'Chronicity', 'acute', 'Acute', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:54:33', '2024-04-26 07:54:33'),
(12, 'Chronicity', 'self_limiting', 'Self Limiting', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:55:00', '2024-04-26 07:55:00'),
(13, 'Chronicity', 'intermittent', 'Intermittent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:55:19', '2024-04-26 07:55:19'),
(14, 'Chronicity', 'recurrent', 'Recurrent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:55:40', '2024-04-26 07:55:40'),
(15, 'Chronicity', 'distressful', 'Distressful', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:56:01', '2024-04-26 07:56:01'),
(16, 'Severity', 'unspecified_Severity', 'Unspecified Severity', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:56:35', '2024-04-26 07:56:35'),
(17, 'Severity', 'severe_persistent', 'Severe Persistent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:57:01', '2024-04-26 07:57:01'),
(18, 'Severity', 'moderate_persistent', 'Moderate Persistent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:57:26', '2024-04-26 07:57:26'),
(19, 'Severity', 'mild_persistent', 'Mild Persistent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:57:48', '2024-04-26 07:57:48'),
(20, 'Severity', 'mild_intermittent', 'Mild Intermittent', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:58:14', '2024-04-26 07:58:14'),
(21, 'Severity', 'unknown', 'Unknown', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:58:36', '2024-04-26 07:58:36'),
(22, 'Status', 'unassigned', 'Unassigned', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:59:06', '2024-04-26 07:59:06'),
(23, 'Status', 'resolved', 'Resolved', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:59:24', '2024-04-26 07:59:24'),
(24, 'Status', 'improved', 'Improved', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 07:59:43', '2024-04-26 07:59:43'),
(25, 'Status', 'status_quo', 'Status Quo', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 08:00:06', '2024-04-26 08:00:06'),
(26, 'Status', 'worse', 'Worse', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 08:00:25', '2024-04-26 08:00:25'),
(27, 'Status', 'pending_follow_up', 'Pending follow Up', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 08:00:55', '2024-04-26 08:00:55'),
(28, 'Status', 'erroneous', 'Erroneous', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 08:01:14', '2024-04-26 08:01:14'),
(29, 'Status', 'duplicate', 'Duplicate', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 08:01:33', '2024-04-26 08:01:33'),
(30, 'Allergy Type', 'general', 'General', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '', '', '', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:37:46', '2024-04-29 07:37:46'),
(32, 'Allergy Type', 'drug-allergy', 'Drup Allery', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:38:10', '2024-04-29 07:38:10'),
(33, 'Allergy Type', 'substance', 'Substance/DrugClass', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:38:45', '2024-04-29 07:38:45'),
(34, 'Reaction', 'arthralgia', 'Arthralgia', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:40:25', '2024-04-29 07:40:25'),
(35, 'Reaction', 'chills', 'Chills', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:46:48', '2024-04-29 07:47:42'),
(36, 'Reaction', 'cough', 'Cough', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:46:50', '2024-04-29 07:47:44'),
(37, 'Reaction', 'fever', 'Fever', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:46:53', '2024-04-29 07:47:46'),
(38, 'Reaction', 'headache', 'Headache', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:46:56', '2024-04-29 07:47:50'),
(39, 'Reaction', 'hives', 'Hives', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:46:59', '2024-04-29 07:47:52'),
(40, 'Reaction', 'malaise', 'Malaisa/fatigue', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:47:02', '2024-04-29 07:47:54'),
(41, 'Reaction', 'myalgia', 'Myalgia', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:47:05', '2024-04-29 07:47:57'),
(42, 'Raection', 'nasal-congestion', 'Nasal Congestion', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:47:07', '2024-04-29 07:48:00'),
(43, 'Reaction', 'nausea', 'Nausea', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:47:09', '2024-04-29 07:48:02'),
(44, 'Reaction', 'pain-soreness', 'Pain/Soreness at injection site', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:47:13', '2024-04-29 07:48:05'),
(45, 'Reaction', 'rash', 'Rash', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:47:16', '2024-04-29 07:48:08'),
(46, 'Reaction', 'rhinorrhea', 'Rhinorrhea', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:47:18', '2024-04-29 07:48:10'),
(47, 'Reaction', 'shortness-breath', 'Shortness of breath/difficulty breathing', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:47:21', '2024-04-29 07:48:14'),
(48, 'Reaction', 'sore-throat', 'Sore Throat', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:47:23', '2024-04-29 07:48:16'),
(49, 'Reaction', 'swelling', 'Swelling', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:47:26', '2024-04-29 07:48:19'),
(50, 'Reaction', 'other', 'Other', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-29 07:47:38', '2024-04-29 07:48:21'),
(51, 'Encounter Type', 'ALF-healths', 'ALF-healths', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 11:57:42', '2024-05-06 11:57:42'),
(52, 'Encounter Type', 'annual_physical', 'Annual Physical', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 11:58:36', '2024-05-06 11:58:36'),
(53, 'Encounter Type', 'annual_wellness_visit', 'Annual Wellness Visit', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 11:58:36', '2024-05-06 11:58:36'),
(54, 'Encounter Type', 'cfa', 'CFA', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 11:58:36', '2024-05-06 11:58:36'),
(55, 'Encounter Type', 'covid_test_2', 'Covid Test 2', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 11:58:36', '2024-05-06 11:58:36'),
(56, 'Encounter Type', 'covid_vaccination', 'Covid Vaccination', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 11:58:36', '2024-05-06 11:58:36'),
(57, 'Encounter Type', 'health_progress', 'Health Progress', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 11:58:36', '2024-05-06 11:58:36'),
(58, 'Specialty', 'general_medicine', 'General Medicine', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 11:58:36', '2024-05-06 11:58:36');

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
(22, '2024_04_04_093638_create_encounter_note_sections_table', 4),
(24, '2024_04_22_081822_create_pysical_exams_table', 6),
(26, '2024_04_06_090058_create_review_of_systems_table', 8),
(27, '2024_04_22_082408_create_physical_exams_table', 9),
(29, '2024_04_24_072004_create_notes_table', 10),
(30, '2024_04_24_104358_create_documents_table', 11),
(31, '2024_04_02_110353_create_user_details_table', 12),
(32, '2024_04_26_074527_create_list_options_table', 13),
(33, '2024_04_01_111829_create_problems_table', 14),
(36, '2024_04_29_074933_create_allergies_table', 15),
(41, '2024_04_01_071837_create_patients_table', 17),
(42, '2024_04_02_073544_create_beds_table', 18),
(44, '2024_04_04_093210_create_patient_encounters_table', 19);

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
(1, 21, 'sk-0001', 'Mr', 'Usama', NULL, 'Akhtar', 'cdf@gmail.com', '43', 'sammi', '771', '772347', 'Male', '03-01-2003', 'volt', NULL, 'Abc Address', 'No', 'Street # 1', NULL, 'James', 'Lesture', 'London', '8831', '1', '2024-05-03 02:33:19', '2024-05-03 02:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `patient_encounters`
--

CREATE TABLE `patient_encounters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_encounters`
--

INSERT INTO `patient_encounters` (`id`, `provider_id`, `patient_id`, `signed_by`, `encounter_date`, `encounter_type`, `specialty`, `parent_encounter`, `location`, `reason`, `attachment`, `status`, `created_at`, `updated_at`) VALUES
(1, 21, 1, 21, '2024-04-22T12:00:00', 57, 58, NULL, NULL, 'Reason', NULL, '1', '2024-05-06 07:51:19', '2024-05-06 07:51:19');

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
(1, 'App\\Models\\User', 21, 'Laravel', '42f37dcb17e7b00dde384b673a4bbf05a4d4637deb35ee647f5e4455bf3ea5fa', '[\"*\"]', '2024-05-06 07:07:44', NULL, '2024-04-06 03:23:54', '2024-05-06 07:07:44'),
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
(13, 'App\\Models\\User', 21, 'Laravel', '726b18beb60fbd279a60b3dab0675b0a057ff425fc3d9526616a59d6be7825cf', '[\"*\"]', '2024-05-03 07:05:11', NULL, '2024-05-03 01:17:11', '2024-05-03 07:05:11'),
(14, 'App\\Models\\User', 21, 'Laravel', 'ea7e20baefe187c73d4a4deee7bf335e13bcc2ecf952b4a718c5667f7e965148', '[\"*\"]', '2024-05-06 07:14:36', NULL, '2024-05-06 07:02:35', '2024-05-06 07:14:36'),
(15, 'App\\Models\\User', 21, 'Laravel', '5eb40e20f1377b41eb3df2c7dcdaa2d4468cf8bc5914cc637135b7f3ac368311', '[\"*\"]', '2024-05-06 07:56:34', NULL, '2024-05-06 07:48:37', '2024-05-06 07:56:34');

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
(35, 27, 'Room 3', '2024-05-03 07:04:58', '2024-05-03 07:04:58');

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
('6VQgK93xWuTzG3YHxtbO3GQA9srjLKYdCJuXPJpQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib1Y2dktyT1UydTRNMUdyYnZ4eEJxZDR4U1VKUzJZd1E5Y0dUVHg0RyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1714999710);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_encounters`
--
ALTER TABLE `patient_encounters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
-- Constraints for table `encounter_note_sections`
--
ALTER TABLE `encounter_note_sections`
  ADD CONSTRAINT `encounter_note_sections_encounter_id_foreign` FOREIGN KEY (`encounter_id`) REFERENCES `patient_encounters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `encounter_note_sections_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `encounter_note_sections_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `patient_encounters`
--
ALTER TABLE `patient_encounters`
  ADD CONSTRAINT `patient_encounters_encounter_type_foreign` FOREIGN KEY (`encounter_type`) REFERENCES `list_options` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_encounters_parent_encounter_foreign` FOREIGN KEY (`parent_encounter`) REFERENCES `patient_encounters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_encounters_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_encounters_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_encounters_signed_by_foreign` FOREIGN KEY (`signed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_encounters_specialty_foreign` FOREIGN KEY (`specialty`) REFERENCES `list_options` (`id`) ON DELETE CASCADE;

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
