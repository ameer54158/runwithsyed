-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2021 at 12:30 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `runwithsyed`
--

-- --------------------------------------------------------

--
-- Table structure for table `ambassador_payments`
--

CREATE TABLE `ambassador_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `month_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ambassador_payments`
--

INSERT INTO `ambassador_payments` (`id`, `user_id`, `month_year`, `payment_id`, `created_at`, `updated_at`) VALUES
(22, 2, '03-2021', 52, '2021-06-10 06:51:05', '2021-06-10 06:51:05'),
(23, 2, '04-2021', 52, '2021-06-10 06:51:05', '2021-06-10 06:51:05');

-- --------------------------------------------------------

--
-- Table structure for table `ambassador_runs`
--

CREATE TABLE `ambassador_runs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `distance_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'km',
  `distance` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ambassador_runs`
--

INSERT INTO `ambassador_runs` (`id`, `user_id`, `distance_type`, `distance`, `date`, `created_at`, `updated_at`) VALUES
(1, 2, 'km', 10, '2021-03-01', '2021-03-30 09:09:49', '2021-03-30 09:09:49'),
(2, 2, 'km', 5, '2021-03-05', '2021-03-30 09:10:03', '2021-03-30 09:10:03'),
(3, 2, 'km', 2, '2021-03-08', '2021-03-30 09:10:12', '2021-03-30 09:10:25'),
(4, 2, 'km', 3, '2021-03-15', '2021-03-30 09:10:37', '2021-03-30 09:10:37'),
(5, 2, 'km', 4, '2021-03-22', '2021-03-30 09:11:02', '2021-03-30 09:11:02'),
(6, 2, 'km', 3, '2021-03-26', '2021-03-30 09:11:11', '2021-03-30 09:11:11'),
(7, 2, 'km', 11, '2021-03-29', '2021-03-30 09:11:19', '2021-03-30 09:11:19'),
(8, 2, 'km', 2, '2021-03-30', '2021-03-30 09:11:34', '2021-03-30 09:11:34'),
(9, 3, 'km', 10, '2021-03-05', '2021-03-30 09:18:51', '2021-03-30 09:18:51'),
(10, 3, 'km', 2, '2021-03-15', '2021-03-30 09:19:06', '2021-03-30 09:19:06'),
(11, 3, 'km', 2, '2021-03-28', '2021-03-30 09:20:30', '2021-03-30 09:20:30'),
(12, 3, 'km', 6, '2021-03-30', '2021-03-30 09:20:39', '2021-03-30 09:20:39'),
(13, 2, 'km', 5, '2021-03-31', '2021-03-31 04:07:31', '2021-03-31 04:07:31'),
(14, 3, 'km', 2, '2021-03-31', '2021-03-31 04:08:36', '2021-03-31 04:08:36'),
(15, 2, 'km', 3, '2021-04-01', '2021-04-01 05:37:03', '2021-04-01 05:37:03'),
(16, 3, 'km', 4, '2021-04-01', '2021-04-01 05:37:47', '2021-04-01 05:37:47'),
(17, 2, 'km', 4, '2021-04-02', '2021-04-02 04:53:45', '2021-04-02 04:53:45'),
(18, 3, 'km', 2, '2021-04-02', '2021-04-02 04:54:25', '2021-04-02 04:54:25'),
(19, 2, 'km', 2, '2021-04-03', '2021-04-05 03:34:50', '2021-04-05 03:34:50'),
(20, 2, 'km', 1, '2021-04-04', '2021-04-05 03:34:59', '2021-04-05 03:34:59'),
(21, 2, 'km', 2, '2021-04-05', '2021-04-06 06:11:02', '2021-04-06 06:11:02'),
(22, 3, 'km', 1, '2021-04-03', '2021-04-06 06:11:36', '2021-04-06 06:11:36'),
(23, 3, 'km', 2, '2021-04-04', '2021-04-06 06:11:45', '2021-04-06 06:11:45'),
(24, 3, 'km', 3, '2021-04-05', '2021-04-06 06:11:54', '2021-04-06 06:11:54'),
(25, 9, 'km', 20, '2021-04-06', '2021-04-06 11:42:51', '2021-04-06 11:42:51'),
(26, 9, 'km', 5, '2021-04-06', '2021-04-06 11:45:41', '2021-04-06 11:45:41'),
(27, 9, 'km', 5, '2021-04-08', '2021-04-08 08:41:06', '2021-04-08 08:41:06'),
(28, 2, 'km', 2, '2021-04-06', '2021-04-12 03:27:03', '2021-04-12 03:27:03'),
(29, 9, 'km', 22, '2021-04-12', '2021-04-12 10:20:22', '2021-04-12 10:20:22'),
(30, 2, 'km', 2, '2021-04-07', '2021-04-13 03:14:59', '2021-04-13 03:14:59'),
(31, 2, 'km', 2, '2021-04-08', '2021-04-13 03:15:17', '2021-04-13 03:15:17'),
(32, 9, 'km', 40, '2021-04-14', '2021-04-14 08:31:41', '2021-04-14 08:31:41'),
(33, 2, 'km', 2, '2021-04-09', '2021-04-14 11:27:27', '2021-04-14 11:27:27'),
(34, 9, 'km', 12, '2021-04-14', '2021-04-14 12:43:46', '2021-04-14 12:43:46'),
(35, 9, 'km', 14, '2021-04-14', '2021-04-14 12:44:00', '2021-04-14 12:44:00'),
(36, 9, 'km', 16, '2021-04-14', '2021-04-14 12:44:12', '2021-04-14 12:44:12'),
(37, 11, 'km', 5, '2021-04-14', '2021-04-14 13:32:02', '2021-04-14 13:32:02'),
(38, 2, 'km', 2, '2021-04-10', '2021-04-15 07:24:46', '2021-04-15 07:24:46'),
(39, 13, 'km', 5, '2021-04-16', '2021-04-16 16:05:07', '2021-04-16 16:05:07'),
(40, 2, 'km', 2, '2021-04-15', '2021-04-19 04:35:03', '2021-04-19 04:35:03'),
(41, 2, 'km', 3, '2021-04-18', '2021-04-19 04:35:16', '2021-04-19 04:35:16'),
(42, 2, 'km', 3, '2021-04-19', '2021-04-19 04:35:26', '2021-04-19 04:35:26'),
(43, 13, 'km', 17, '2021-04-20', '2021-04-20 17:23:36', '2021-04-20 17:23:36'),
(44, 3, 'km', 4, '2021-04-06', '2021-04-23 07:21:45', '2021-04-23 07:21:45'),
(45, 3, 'km', 2, '2021-04-15', '2021-04-23 07:22:15', '2021-04-23 07:22:15'),
(46, 3, 'km', 1, '2021-04-17', '2021-04-23 07:22:30', '2021-04-23 07:22:30'),
(47, 2, 'km', 2, '2021-04-20', '2021-04-28 08:53:13', '2021-04-28 08:53:13'),
(48, 2, 'km', 5, '2021-04-28', '2021-04-29 08:44:27', '2021-04-29 08:44:27'),
(49, 3, 'km', 3, '2021-04-25', '2021-04-29 08:46:20', '2021-04-29 08:46:20'),
(50, 2, 'km', 3, '2021-04-29', '2021-04-29 08:47:33', '2021-04-29 08:47:33'),
(51, 2, 'km', 2, '2021-05-01', '2021-05-05 06:04:22', '2021-05-05 06:04:22'),
(52, 2, 'km', 2, '2021-06-03', '2021-06-10 05:54:25', '2021-06-10 05:54:25'),
(53, 2, 'km', 3, '2021-06-04', '2021-06-10 06:50:26', '2021-06-10 06:50:26'),
(54, 2, 'km', 1, '2021-07-01', '2021-07-08 00:48:58', '2021-07-08 00:48:58'),
(55, 2, 'km', 5, '2021-08-03', '2021-08-20 01:51:00', '2021-08-20 01:51:00'),
(56, 2, 'km', 2, '2021-08-04', '2021-08-20 01:51:16', '2021-08-20 01:51:16');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `first_name`, `last_name`, `telephone`, `email`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(15, 'Ameer', 'Hamza', '65557000', 'ameer54158@gmail.com', 'Become initiator', 'I want to become initiator in your organization. Thanks!', '2021-06-15 06:44:12', '2021-06-15 06:44:12'),
(16, 'Ameer', 'Hamza', '+923476555700', 'ameer54158@gmail.com', 'Become initiator', 'I want to become initiator in your organization.', '2021-06-15 06:48:29', '2021-06-15 06:48:29');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `name`, `payment_id`, `created_at`, `updated_at`) VALUES
(2, 'Ameer Hamza', 51, NULL, NULL),
(3, 'Muhammad Ameer', 41, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dymantic_instagram_basic_profiles`
--

CREATE TABLE `dymantic_instagram_basic_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dymantic_instagram_basic_profiles`
--

INSERT INTO `dymantic_instagram_basic_profiles` (`id`, `username`, `created_at`, `updated_at`) VALUES
(1, 'runwithsyed', '2021-05-06 07:47:05', '2021-05-06 07:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `dymantic_instagram_feed_tokens`
--

CREATE TABLE `dymantic_instagram_feed_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `profile_id` int(10) UNSIGNED NOT NULL,
  `access_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dymantic_instagram_feed_tokens`
--

INSERT INTO `dymantic_instagram_feed_tokens` (`id`, `profile_id`, `access_code`, `username`, `user_id`, `user_fullname`, `user_profile_picture`, `created_at`, `updated_at`) VALUES
(1, 1, 'IGQVJWNkt6TmVOWkgwbkNJR1VyZAnFic2ZAhVkxtak1rajk4UmhEd2MyeDVuRTAzaXVydmlqN3pSc3FTekRIR3VUZAHVIZATZApWDQ1WWtsa2xRQTl3b3pjRTF0WlZAjcUFWOVhHZA092VTJn', 'runwithsyed', '17841438583497313', 'not available', 'not available', '2021-05-06 08:10:12', '2021-09-03 01:26:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `initiators`
--

CREATE TABLE `initiators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_no` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `initiators`
--

INSERT INTO `initiators` (`id`, `name`, `description_en`, `description_no`, `order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ghazi Alamdar Syed', '<h5>I joined RunWithSyed because I want to help people with mental illness. I lost a family member who struggled with this and have personally experienced challenges with mental health. It is extremely important for me to promote this issue which is very taboo. I want to help children and young people overcome their mental illness.</h5>', '<h5>Jeg ble med i RunWithSyed fordi jeg vil hjelpe mennesker med psykiske lidelser. Jeg mistet et familiemedlem som slet med dette og personlig har opplevd utfordringer med mental helse. Det er ekstremt viktig for meg &aring; markedsf&oslash;re denne saken som er veldig tabu. Jeg vil hjelpe barn og unge med &aring; overvinne deres psykiske lidelse.</h5>', 1, 1, '2021-03-30 04:47:05', '2021-03-30 04:47:05'),
(2, 'Narve Wilsgaard', '<h5>I have struggled with mental illness but was lucky enough to get help and am completely healthy today. Now I want to help others who do not have access to the same follow-up as we have in Norway. My stamina is not the same as it once was, but with this project I hopefully will be able to put some kilometers behind me in the years to come. I hope you will join me!</h5>', '<h5>Jeg har slitt med psykiske lidelser, men var heldig nok til &aring; f&aring; hjelp og er helt frisk i dag. N&aring; vil jeg hjelpe andre som ikke har tilgang til samme oppf&oslash;lging som vi har i Norge. Min utholdenhet er ikke den samme som den en gang var, men med dette prosjektet vil jeg forh&aring;pentligvis kunne legge noen kilometer bak meg i &aring;rene som kommer. Jeg h&aring;per du vil bli med meg!</h5>', 2, 1, '2021-03-30 04:51:12', '2021-03-30 04:51:12'),
(3, 'Steffen Bjerknes Pedersen', '<h5>My name is Steffen Pedersen. I have experienced challenges with my mental health, and thought it was awful to be ashamed of something that is already perceived as a burden. Participating in changing people\'s views on mental health and giving children and women a chance to overcome their mental illnesses, gives me enormous motivation to promote RWS \'message.</h5>', '<h5>Jeg heter Steffen Pedersen. Jeg har opplevd utfordringer med min mentale helse, og syntes det var forferdelig &aring; skamme meg over noe som allerede oppleves som en byrde. &Aring; delta i &aring; endre folks syn p&aring; mental helse og gi barn og kvinner en sjanse til &aring; overvinne deres psykiske sykdommer, gir meg enorm motivasjon for &aring; fremme RWS \'budskap.</h5>', 3, 1, '2021-03-30 04:52:08', '2021-03-30 04:52:08'),
(4, 'Mohammad Ali Syed', '<h5>I want to promote a taboo subject in the Eastern world and help create openness and understanding of mental health. I have seen what challenges close and acquaintances face in our society even with the various opportunities for help we have and then think about how cruel it must be for people who do not have access to this. With us, our donors will help people deal with their mental illness as well as improve their own mental health.</h5>', '<h5>Jeg &oslash;nsker &aring; fremme et tabubelagt tema i den &oslash;stlige verden og bidra til &aring; skape &aring;penhet og forst&aring;else av mental helse. Jeg har sett hvilke utfordringer n&aelig;re og bekjente m&oslash;ter i samfunnet v&aring;rt selv med de ulike mulighetene for hjelp vi har og tenker s&aring; p&aring; hvor grusomt det m&aring; v&aelig;re for mennesker som ikke har tilgang til dette. Hos oss vil donorene v&aring;re hjelpe mennesker med &aring; h&aring;ndtere sin psykiske sykdom, samt forbedre sin egen mentale helse.</h5>', 4, 1, '2021-03-30 04:53:03', '2021-03-30 04:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mediable_id` int(11) DEFAULT NULL,
  `mediable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `name_unique` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `mediable_id`, `mediable_type`, `name`, `order`, `name_unique`, `type`, `created_at`, `updated_at`) VALUES
(3, 38, 'App\\Models\\Setting', 'Al Mudassar Trust - Sykehuset .jpeg', 3, '210330-1617085353-2716377.jpeg', 'about_us_image', '2021-03-30 04:22:33', '2021-03-30 04:22:33'),
(5, 1, 'App\\Models\\Initiator', 'Ghazi Syed.jpeg', 2, '210330-1617086922-7768729.jpeg', 'image', '2021-03-30 04:48:42', '2021-03-30 04:48:42'),
(6, 2, 'App\\Models\\Initiator', 'Narve Wilsgaard.jpeg', 1, '210330-1617087072-9290367.jpeg', 'image', '2021-03-30 04:51:12', '2021-03-30 04:51:12'),
(7, 3, 'App\\Models\\Initiator', 'Steffen Pedersen.jpeg', 1, '210330-1617087128-3769296.jpeg', 'image', '2021-03-30 04:52:08', '2021-03-30 04:52:08'),
(8, 4, 'App\\Models\\Initiator', 'Mohammed Ali Syed.jpeg', 1, '210330-1617087183-7468412.jpeg', 'image', '2021-03-30 04:53:03', '2021-03-30 04:53:03'),
(10, 2, 'App\\Models\\News', 'ambassador.jpg', 1, '210330-1617101174-6791417.jpg', 'image', '2021-03-30 08:46:15', '2021-03-30 08:46:15'),
(11, 3, 'App\\Models\\News', 'sponsor.jpg', 1, '210330-1617101310-8706433.jpg', 'image', '2021-03-30 08:48:31', '2021-03-30 08:48:31'),
(12, 2, 'App\\Models\\User', 'user3.jpg', 1, '210330-1617102542-9005423.jpg', 'profile-image', '2021-03-30 09:09:03', '2021-03-30 09:09:03'),
(13, 3, 'App\\Models\\User', 'user1.jpg', 1, '210330-1617103105-1356931.jpg', 'profile-image', '2021-03-30 09:18:25', '2021-03-30 09:18:25'),
(26, 1, 'App\\Models\\News', '360x220-img-RWS-01.jpg', 13, '210406-1617714669-3754190.jpg', 'image', '2021-04-06 13:11:11', '2021-04-06 13:11:11'),
(27, 29, 'App\\Models\\AmbassadorRun', 'log EDS.JPG', 1, '210412-1618222822-1373945.JPG', 'proof', '2021-04-12 10:20:23', '2021-04-12 10:20:23'),
(28, 30, 'App\\Models\\AmbassadorRun', 'RWS-logo-168x116-n.png', 1, '210413-1618283699-4244792.png', 'proof', '2021-04-13 03:15:00', '2021-04-13 03:15:00'),
(29, 9, 'App\\Models\\User', 'bilde av meg.PNG', 1, '210414-1618389870-5774223.PNG', 'profile-image', '2021-04-14 08:44:33', '2021-04-14 08:44:33'),
(30, 12, 'App\\Models\\User', 'IMG_2076.jpeg', 1, '210415-1618474877-8570883.jpeg', 'profile-image', '2021-04-15 08:21:19', '2021-04-15 08:21:19');

-- --------------------------------------------------------

--
-- Table structure for table `metas`
--

CREATE TABLE `metas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `metable_id` int(11) NOT NULL,
  `metable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metas`
--

INSERT INTO `metas` (`id`, `metable_id`, `metable_type`, `key`, `value`, `created_at`, `updated_at`) VALUES
(13, 2, 'App\\Models\\User', 'ambassador_membership_fee_payment_id', '29', '2021-06-08 11:08:55', '2021-06-08 11:08:55'),
(15, 9, 'App\\Models\\User', 'ambassador_membership_fee_payment_id', '43', '2021-06-09 11:05:32', '2021-06-09 11:05:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_01_15_105324_create_roles_table', 1),
(4, '2016_01_15_114412_create_role_user_table', 1),
(5, '2016_01_26_115212_create_permissions_table', 1),
(6, '2016_01_26_115523_create_permission_role_table', 1),
(7, '2016_02_09_132439_create_permission_user_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2021_03_04_095906_create_user_details_table', 1),
(10, '2021_03_04_100342_create_media_table', 1),
(11, '2021_03_04_100503_create_settings_table', 1),
(12, '2021_03_05_104013_create_initiators_table', 1),
(13, '2021_03_08_043219_create_news_table', 1),
(14, '2021_03_12_122350_add_gender_column_in_user_details', 1),
(15, '2021_03_15_073612_add_column_to_user_details_table', 1),
(16, '2021_03_16_113128_create_contact_us_table', 1),
(17, '2021_03_16_124434_create_payments_table', 1),
(18, '2021_03_17_071627_create_ambassador_runs_table', 1),
(19, '2021_03_17_071747_create_ambassador_payments_table', 1),
(20, '2021_03_17_071955_create_sponsor_ambassadors_table', 1),
(21, '2021_03_17_072028_create_sponsor_ambassador_payments_table', 1),
(22, '2021_03_19_075655_add_profile_image_permission_column_in_user_details', 1),
(23, '2021_03_22_065356_drop_ambassador_runs_id_constraints_in_sponsor_ambassador_payments', 1),
(24, '2021_03_29_082733_add_payment_user_column_in_payments', 1),
(25, '2021_04_05_034026_create_metas_table', 2),
(26, '2021_04_05_123604_create_donations_table', 3),
(27, '2021_04_20_074307_create_our_top_ambassadors_table', 4),
(28, '2021_05_06_082715_create_instagram_basic_profile_table', 5),
(29, '2021_05_06_082715_create_instagram_feed_token_table', 5),
(30, '2021_06_08_094836_add_order_id_column_in_payments', 6),
(31, '2021_06_15_113830_add_subject_column_in_contact_us', 7),
(32, '2021_06_30_064932_update_column_in_donations', 8);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_no` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title_en`, `title_no`, `slug_en`, `slug_no`, `description_en`, `description_no`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Our first ambassador', 'Vår første ambassadør', 'our-first-ambassador', 'vår-første-ambassadør', '<p>RunWithSyed wants to present our very first ambassador as Fredrik Lillevik Johansen. Here is some info about him and why he chose to become an ambassador with us. We are proud to have him as an ambassador member of RWS.</p>\r\n<p>Briefly about Fredrik: Fredrik is 28 years old and is from Lier. He has worked as an extra guard psychiatrist since 2015. He now lives in Oslo and is very happy to take a jog.</p>\r\n<p>I became an ambassador for Run With Syed because I want to help people with mental illness. In Pakistan, people with mental illness are looked down upon due to lack of knowledge about the many different diseases. I hope that my contribution will be able to help children and women cope with and understand their illness. The best scenario is to see that the funds raised help to give those we help a normal and safe life. RunWithSyed has given me a new meaning for my running ahead, it\'s so cool to be part of creating openness about mental health.</p>', '<p>RunWithSyed &oslash;nsker &aring; presentere v&aring;r aller f&oslash;rste ambassad&oslash;r som Fredrik Lillevik Johansen. Her er litt info om han og hvorfor han valgte &aring; bli ambassad&oslash;r hos oss. Vi er stolte av &aring; ha han som en ambassad&oslash;r medlem i RWS.</p>\r\n<p>Kort om Fredrik: Fredrik er 28 &aring;r og er fra Lier. Han har jobbet som ekstravakt psykiatrien siden 2015. Han bor n&aring; i Oslo og er veldig glad i &aring; ta seg en joggetur.</p>\r\n<p>Jeg ble ambassad&oslash;r i Run With Syed fordi jeg &oslash;nsker &aring; hjelpe mennesker med psykiske lidelser. I Pakistan blir mennesker med mentale lidelser sett ned p&aring;, p&aring; grunn av manglende kunnskap om de mange forskjellige sykdommene. Jeg h&aring;per at mitt bidrag skal kunne hjelpe barn og kvinner med &aring; takle og forst&aring; sin sykdom. Beste scenario er &aring; se at innsamlede midler bidrar til &aring; gi de vi hjelper et normalt og trygt liv. RunWithSyed har gitt meg en ny mening for l&oslash;ping min fremover, det er s&aring; kult &aring; v&aelig;re med p&aring; &aring; skape &aring;penhet om mental helse.</p>', 1, '2021-03-30 08:40:05', '2021-03-30 08:40:05'),
(2, 'Interview with Huma Latif', 'Intervju med Huma Latif', 'interview-with-huma-latif', 'intervju-med-huma-latif', '<p>RunWithSyed has been in dialogue with the psychologist Huma Latif to increase knowledge in mental health and why this topic is so taboo. It has been incredibly instructive to hear from a professional about this team.</p>\r\n<ol>\r\n<li><strong>Want to tell a little about yourself and your background?</strong></li>\r\n<li><strong>Why did you agree to an interview with us?</strong></li>\r\n<li><strong>What are the most common causes of mental illness? (In Norway / Pakistan)</strong></li>\r\n<li><strong>Why is it so taboo to talk about mental health in general? And is it particularly challenging among minority groups?</strong></li>\r\n<li><strong>Why is physical activity so important in preventing mental health?</strong></li>\r\n<li><strong>What is your advice to those out there who are sitting with bad thoughts and feelings, but do not dare to talk openly about it, and are afraid of bothering friends and family with their problems?</strong></li>\r\n<li><strong>Is there something you feel we should ask you, or something you want to say in the end?</strong></li>\r\n<li><strong>Questions on Instagram to the people about what they would have asked if they had the opportunity to ask a professional?</strong></li>\r\n</ol>\r\n<p>&nbsp;</p>', '<p>RunWithSyed har v&aelig;rt i dialog med psykologen Huma Latif for &aring; f&aring; &aring; &oslash;ke kunnskap innen mental helse og hvorfor dette temaet er s&aring; tabubelagt. Det har v&aelig;rt utrolig l&aelig;rerikt &aring; h&oslash;re fra faglig person om dette teamet.</p>\r\n<ol>\r\n<li><strong> Vil du fortelle litt om deg selv og din bakgrunn?</strong></li>\r\n<li><strong> Hvorfor takket du ja til &aring; stille til et intervju med oss?</strong></li>\r\n<li><strong> Hva er de vanligste &aring;rsakene bak psykiske lidelser? (I Norge/Pakistan)</strong></li>\r\n<li><strong> Hvorfor er det s&aring; tabubelagt om &aring; snakke om mental helse generelt? Og er det spesielt utfordrende blant minoritetsgrupper?</strong></li>\r\n<li><strong> Hvorfor er fysisk aktivitet s&aring; viktig for &aring; forebygge mental helse?</strong></li>\r\n<li><strong> Hva er ditt r&aring;d til de der ute som sitter med vonde tanker og f&oslash;lelser, men ikke t&oslash;r &aring; prate &aring;pent om det, og er redd for &aring; plage venner og familie med problemene sine?</strong></li>\r\n<li><strong> Er det noe du f&oslash;ler vi burde spurt deg om, eller noe du &oslash;nsker &aring; si helt til slutt?</strong></li>\r\n<li><strong>Sp&oslash;rsm&aring;l p&aring; Instagram til folket om hva de hadde spurt dersom de fikk muligheten til &aring; sp&oslash;rre en fagperson?</strong></li>\r\n</ol>\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 39px; top: 252px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 1, '2021-03-30 08:46:14', '2021-03-30 08:46:14'),
(3, 'Establishment of an association and the articles of association', 'Stiftelse av forening og vedtektene', 'establishment-of-an-association-and-the-articles-of-association', 'stiftelse-av-forening-og-vedtektene', '<p>RunWithSyed is proud to found the association and is ready to make a difference. In this article you will find our founding document and our articles of association if you want to read these. If you want to give us feedback on what you read, you can contact us via our contact form.</p>', '<p>RunWithSyed er stolte over &aring; stifte foreningen og er klare for &aring; gj&oslash;re en forskjell. I denne artikkel vil du finne v&aring;rt stiftelsesdokument og v&aring;re vedtekter dersom du &oslash;nsker &aring; lese disse. Hvis du &oslash;nsker &aring; gi oss en tilbakemelding p&aring; det du leser kan du kontakte oss via v&aring;r kontaktskjema.</p>', 1, '2021-03-30 08:48:30', '2021-03-30 08:48:30');

-- --------------------------------------------------------

--
-- Table structure for table `our_top_ambassadors`
--

CREATE TABLE `our_top_ambassadors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `our_top_ambassadors`
--

INSERT INTO `our_top_ambassadors` (`id`, `user_id`, `order`, `created_at`, `updated_at`) VALUES
(6, 12, 1, '2021-04-20 07:26:08', '2021-04-20 07:26:08'),
(7, 13, 2, '2021-04-20 07:26:08', '2021-04-20 07:26:08'),
(8, 15, 3, '2021-04-20 07:26:08', '2021-04-20 07:26:08'),
(9, 11, 4, '2021-04-20 07:26:08', '2021-04-20 07:26:08'),
(10, 14, 5, '2021-04-20 07:26:08', '2021-04-20 07:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('ameer@digitalmx.no', '$2y$10$HMj0PQq0dmdy7MXYqmvEMOD8QOi8dLwwwE5KmJfeDp2xOyRNkpNoy', '2021-05-11 07:35:08');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `payment_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `transaction_id`, `amount`, `payment_user`, `status`, `created_at`, `updated_at`) VALUES
(29, '0806-2021-0108-28309', '2079000210', 200, 'ambassador_membership_fee', 'completed', '2021-06-08 11:08:55', '2021-06-08 11:08:55'),
(38, '0906-2021-1201-15700', '2616000254', 10, 'donation', 'completed', '2021-06-09 10:01:36', '2021-06-09 10:01:36'),
(39, '0906-2021-1205-00518', '2638000241', 5, 'donation', 'completed', '2021-06-09 10:05:29', '2021-06-09 10:05:29'),
(40, '0906-2021-1207-11799', '2475000216', 15, 'donation', 'completed', '2021-06-09 10:07:39', '2021-06-09 10:07:39'),
(41, '0906-2021-1246-19731', '2056000192', 200, 'donation', 'completed', '2021-06-09 10:47:33', '2021-06-09 10:47:33'),
(43, '0906-2021-0105-10770', '2859000242', 200, 'ambassador_membership_fee', 'completed', '2021-06-09 11:05:32', '2021-06-09 11:05:32'),
(51, '1006-2021-0756-20498', '2242000217', 100, 'donation', 'completed', '2021-06-10 05:57:42', '2021-06-10 05:57:42'),
(52, '1006-2021-0850-37820', '2526000259', 85, 'ambassador', 'completed', '2021-06-10 06:51:05', '2021-06-10 06:51:05'),
(54, '1006-2021-0850-37820', '2526000259', 85, 'sponsor', 'completed', '2021-06-10 06:51:05', '2021-06-10 06:51:05');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `description`, `model`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Can View Users', 'view.users', 'Can view users', 'Permission', '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(2, 'Can Create Users', 'create.users', 'Can create new users', 'Permission', '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(3, 'Can Edit Users', 'edit.users', 'Can edit users', 'Permission', '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(4, 'Can Delete Users', 'delete.users', 'Can delete users', 'Permission', '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(2, 2, 1, '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(3, 3, 1, '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(4, 4, 1, '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `level`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin', 'Admin Role', 5, '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(2, 'User', 'user', 'User Role', 1, '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(3, 'Unverified', 'unverified', 'Unverified Role', 0, '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(4, 'Ambassador', 'ambassador', 'Ambassador role', 2, '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(5, 'Sponsor', 'sponsor', 'Sponsor role', 3, '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(6, 'Contributor', 'contributor', 'Contributor role', 4, '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2021-03-30 03:13:05', '2021-03-30 03:13:05', NULL),
(2, 4, 2, '2021-03-30 09:08:36', '2021-03-30 09:08:36', NULL),
(3, 4, 3, '2021-03-30 09:14:03', '2021-03-30 09:14:03', NULL),
(4, 5, 4, '2021-03-30 09:37:49', '2021-03-30 09:37:49', NULL),
(9, 4, 9, '2021-04-06 11:33:25', '2021-04-06 11:33:25', NULL),
(10, 5, 10, '2021-04-14 13:25:38', '2021-04-14 13:25:38', NULL),
(11, 4, 11, '2021-04-14 13:26:27', '2021-04-14 13:26:27', NULL),
(12, 4, 12, '2021-04-15 08:18:09', '2021-04-15 08:18:09', NULL),
(13, 4, 13, '2021-04-15 08:24:51', '2021-04-15 08:24:51', NULL),
(14, 4, 14, '2021-04-15 08:28:24', '2021-04-15 08:28:24', NULL),
(15, 4, 15, '2021-04-16 16:00:57', '2021-04-16 16:00:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'home_banner_section_title_en', 'Improving life one mile at a time', '2021-03-30 03:43:30', '2021-03-30 03:43:30'),
(2, 'home_banner_section_title_no', 'Forbedrer liv en kilometer om gangen', '2021-03-30 03:43:30', '2021-03-30 03:43:30'),
(3, 'banner_section_description_en', 'In Pakistan there is one psychologist per half million capita. Join us running for your and others health!', '2021-03-30 03:54:30', '2021-03-30 03:54:30'),
(4, 'banner_section_description_no', 'I Pakistan er det en psykolog per halv million innbyggere. Bli med å løp for din og andres helse!', '2021-03-30 03:54:30', '2021-03-30 03:54:30'),
(5, 'privacy_title_en', 'Privacy statement for RunWithSyed', '2021-03-30 03:57:47', '2021-03-30 05:15:32'),
(6, 'privacy_title_no', 'Personvernerklæring for RunWithSyed', '2021-03-30 03:57:47', '2021-03-30 03:57:47'),
(7, 'privacy_description_en', '<p><strong>About the statement</strong></p>\r\n<p>For RWS, it is important that you feel safe when you are in contact with us. We comply with Norwegian privacy laws and the EU Privacy Regulation (GDPR) - which means that we respect your integrity and your right to have control over your personal information.</p>\r\n<p>Our guiding principles are simple; we are open about what information we have about you and why, and we protect your information in the best possible way.</p>\r\n<p>The privacy statement describes RWS \'handling of personal information in detail and indicates the contact person in the organization for questions related to privacy. RWS is responsible for processing in the manner described in this document, and we are responsible for ensuring that the processing takes place in accordance with current regulations.</p>\r\n<p>The statement applies to you who are in contact with us as a sponsor, ambassador or are interested or engaged in our business for other reasons.</p>\r\n<p><strong>1. TREATMENT MANAGER</strong></p>\r\n<p style=\"padding-left: 40px;\">The general manager is, on behalf of RWS, responsible for the organization\'s processing of personal data.</p>\r\n<p><strong>2. COLLECTION OF PERSONAL INFORMATION</strong></p>\r\n<p style=\"padding-left: 40px;\">RWS collects and stores personal information about you:</p>\r\n<ul>\r\n<li style=\"list-style-type: none;\">\r\n<ul>\r\n<li><strong>When you register as a sponsor or ambassador in RWS</strong></li>\r\n<li><strong>When you provide support via our websites, SMS, vipps or other channels / apps</strong></li>\r\n<li><strong>When you fill in a form that requests personal information on our website</strong></li>\r\n<li><strong>When you are elected to a position of trust in RWS</strong></li>\r\n<li><strong>When you contact us via email, phone, website or social media</strong></li>\r\n<li><strong>When visiting our websites.</strong></li>\r\n</ul>\r\n</li>\r\n</ul>\r\n<p style=\"padding-left: 40px;\">RWS mainly collects personal information directly from you. We do not collect more information than is necessary to carry out the purpose of collecting personal information. See point 3 for detailed information about what personal information we store about our various supporters.</p>\r\n<p><strong>3. WHAT PERSONAL INFORMATION WE STORE AND HOW LONG DO WE STORE THEM</strong></p>\r\n<p style=\"padding-left: 40px;\">RWS does not collect and store more information than is necessary to fulfill the purpose of the processing.</p>\r\n<p style=\"padding-left: 40px;\">You have the right to access the information RWS has registered about you and may request that information be updated, archived or deleted. RWS has established routines for deleting and archiving personal information. The routines vary depending on your connection to RWS, see section 3.1. - 3.4 for what information we store about our supporters and how long we store the information.</p>\r\n<p style=\"padding-left: 40px;\"><strong>3.1. Sponsors and ambassadors</strong></p>\r\n<p style=\"padding-left: 40px;\">To give our sponsors and ambassadors a good follow-up, we store name, address, telephone number, e-mail address, amount collected, gender.</p>\r\n<p style=\"padding-left: 40px;\">Information we have received in connection with your agreement in RWS is stored in our sponsor and ambassador register as long as you are considered an active donor in RWS. In line with the industry standard for voluntary organizations and the processing of personal data, a donor is considered to be an active donor for 3 years after the last contribution was made. Information we are obliged to keep in accordance with the Accounting Act is stored for 5 years, in accordance with the requirements of the Act.</p>\r\n<p style=\"padding-left: 40px;\">If you provide your telephone number and agree to further communication, we may call you or send you an SMS to ask if you would like to support the work of RWS.</p>\r\n<p><strong>4. PURPOSE OF THE TREATMENT</strong></p>\r\n<p style=\"padding-left: 40px;\">&nbsp;</p>\r\n<p style=\"padding-left: 40px;\">RWS processes personal data for the purposes stated in this statement. Purpose is also stated when collecting information.</p>\r\n<p style=\"padding-left: 40px;\">We collect information about our sponsors and ambassadors to be able to;</p>\r\n<p style=\"padding-left: 40px;\">Confirm your identity</p>\r\n<p style=\"padding-left: 40px;\">Receive and register support for RWS</p>\r\n<p style=\"padding-left: 40px;\">Complete ordering of services through channels offered by RWS</p>\r\n<p style=\"padding-left: 40px;\">Register different memberships and to follow up on these</p>\r\n<p style=\"padding-left: 40px;\">Enable good service, such as handling your inquiries, correcting incorrect information or sending you information.</p>\r\n<p style=\"padding-left: 40px;\">We also process personal data in order to run our business, which means, among other things, that we process your personal data when you are in contact with us for various reasons. Examples of administration that involve the processing of personal data are:</p>\r\n<p style=\"padding-left: 40px;\">When you contact us by e-mail, we handle personal information in order to keep in touch with you and respond to your inquiry.</p>\r\n<p style=\"padding-left: 40px;\">If you are in contact with us in connection with a professional role or the like, your personal information can be stored in minutes, on invoices and the like.</p>\r\n<p style=\"padding-left: 40px;\">In our financial administration and follow-up, personal information appears on invoices / credit notes and disbursement reimbursement.</p>\r\n<p><strong>5. THE BASIS OF THE TREATMENT</strong></p>\r\n<p style=\"padding-left: 40px;\">&nbsp;</p>\r\n<p style=\"padding-left: 40px;\">We mainly process personal information about you in order to fulfill our obligation and agreement with you as a sponsor, ambassador, donor, member, or in connection with other services that we offer.</p>\r\n<p style=\"padding-left: 40px;\">Some of the information about you may also be stored due to requirements in Norwegian law. An example of this is reporting your contribution to RWS to the tax authorities if you want a tax deduction for your contribution, or fulfilling our obligations under the Accounting Act.</p>\r\n<p style=\"padding-left: 40px;\">The processing of personal data takes place in accordance with current regulations and means that information about you is not stored longer than necessary and with regard to the purpose of the processing. We have internal routines to ensure this, see point 3 which describes how long we keep information about you.</p>\r\n<p><strong>6. Pictures and movies of children</strong></p>\r\n<p style=\"padding-left: 40px;\">In some cases, we publish photos and films of children on our website if we have consent from the children themselves and their parents / guardians. Pictures and movies are removed when children or parents request it by phone or email.</p>\r\n<p><strong>7. WEB ANALYSIS, COOKIES AND COOKIES AND STORAGE</strong></p>\r\n<p style=\"padding-left: 40px;\">We use cookies on our websites to give you the best possible user experience and service. In accordance with the Electronic Communications Act, we inform our visitors about the use of cookies. Read more about our use of cookies on our website.</p>\r\n<p><strong>8. PROVISION OF INFORMATION TO THIRD PARTIES</strong></p>\r\n<p style=\"padding-left: 40px;\">Personal information is only shared with other companies or subcontractors who perform tasks on behalf of RWS and in connection with the delivery of our services. All our subcontractors are subject to a data processor agreement with RWS. RWS has data processor responsibility for all data collected.</p>\r\n<p style=\"padding-left: 40px;\">In some contexts, we share, transfer or otherwise disclose personal information to others because we are legally obliged to do so, such as when we disclose necessary information to the Br&oslash;nn&oslash;ysund Register and the tax authorities.</p>\r\n<p style=\"padding-left: 40px;\">In order to be able to fulfill our obligations by agreement with you, the necessary information is provided to our partners and subcontractors. For example, personal information is stored in our donor and member register. When we process an invoice, payment information is stored in our invoicing system. These systems are operated by other companies and information is therefore also stored with them in accordance with our data processor agreement.</p>\r\n<p><strong>9. RIGHTS OF THE REGISTERED</strong></p>\r\n<p style=\"padding-left: 40px;\">We process your personal data in accordance with the Personal Data Act and current regulations. You can demand access to your own personal information, as well as demand correction or deletion of information. You can also complain to the Data Inspectorate about processing that is in violation of the rules.</p>\r\n<p><strong>10. PRIVACY REPRESENTATIVE</strong></p>\r\n<p style=\"padding-left: 40px;\">RWS has appointed a privacy representative. The Privacy Ombudsman ensures that the Personal Data Act\'s rules on the processing of personal data are followed. The Privacy Ombudsman can be reached at the contact information provided in clause 13 of this statement.</p>\r\n<p><strong>11. INFORMATION SECURITY</strong></p>\r\n<p style=\"padding-left: 40px;\">RWS has established and documented routines and measures to ensure your personal information, the integrity of the information, the availability and confidentiality of it.</p>\r\n<p style=\"padding-left: 40px;\">We secure your personal information by both physical and virtual access and access control, as well as by encrypting sensitive parts of information.</p>\r\n<p><strong>12. CONTACT INFORMATION</strong></p>\r\n<p style=\"padding-left: 40px;\">If you have inquiries regarding personal information and privacy, please contact us as follows:</p>\r\n<p style=\"padding-left: 40px;\">Email: info@rws.no</p>\r\n<p style=\"padding-left: 40px;\">Phone: + (47) 47962700</p>\r\n<p style=\"padding-left: 40px;\">Address: Vipeveien 15, 1384 Asker.</p>', '2021-03-30 03:57:47', '2021-03-30 05:25:38'),
(8, 'privacy_description_no', '<p><strong>Om erkl&aelig;ringen</strong></p>\r\n<p>For RWS er det viktig at du kjenner deg trygg n&aring;r du er i kontakt med oss. Vi f&oslash;lger norske lover for personvern og EUs personvern&shy;forordning (GDPR) &ndash; noe som betyr at vi respekterer din integritet og din rett til &aring; ha kontroll over dine person&shy;opplysninger.</p>\r\n<p>V&aring;re veiledende prinsipper er enkle; vi er &aring;pne om hvilke opplysninger vi har om deg og hvorfor, og vi beskytter dine opplysninger p&aring; best mulig m&aring;te.</p>\r\n<p>Personvernerkl&aelig;ringen beskriver RWS h&aring;ndtering av person&shy;opplysninger i detalj og angir kontaktperson i organisasjonen for sp&oslash;rsm&aring;l relatert til personvern. RWS er behandlings&shy;ansvarlig p&aring; den m&aring;ten det beskrives i dette dokumentet, og vi er ansvarlig for at behandlingen skjer i tr&aring;d med gjeldende regelverk.</p>\r\n<p>Erkl&aelig;ringen gjelder for deg som er i kontakt med oss som sponsor, ambassad&oslash;r eller er interessert eller engasjert i v&aring;r virksomhet av andre grunner.</p>\r\n<p><strong>1. BEHANDLINGS&shy;ANSVARLIG</strong></p>\r\n<p style=\"padding-left: 40px;\">Daglig leder er p&aring; vegne av RWS, ansvarlig for organisasjonens behandling av person&shy;opplysninger.</p>\r\n<p><strong>2.</strong>&nbsp;<strong>INNHENTING AV PERSON&shy;OPPLYSNINGER</strong></p>\r\n<p style=\"padding-left: 40px;\">RWS innhenter og lagrer person&shy;opplysninger om deg:</p>\r\n<ul>\r\n<li style=\"list-style-type: none;\">\r\n<ul>\r\n<li><strong>N&aring;r du registrerer deg som sponsor eller ambassad&oslash;r i RWS</strong></li>\r\n<li><strong>N&aring;r du gir st&oslash;tte via v&aring;re nettsider, SMS, vipps eller andre kanaler/apper</strong></li>\r\n<li><strong>N&aring;r du fyller inn et skjema som ber om person&shy;opplysninger p&aring; v&aring;re nettsider</strong></li>\r\n<li><strong>N&aring;r du du blir valgt til tillitsverv i RWS</strong></li>\r\n<li><strong>N&aring;r du kontakter oss via epost, telefon, nettside eller sosiale medier</strong></li>\r\n<li><strong>Ved bes&oslash;k p&aring; v&aring;re nettsider.</strong></li>\r\n</ul>\r\n</li>\r\n</ul>\r\n<p style=\"padding-left: 40px;\">RWS samler i all hovedsak inn person&shy;opplysninger direkte fra deg. Vi henter ikke inn mer informasjon enn det som er n&oslash;dvendig for &aring; gjennomf&oslash;re form&aring;let med innhentingen av person&shy;opplysninger. Se punkt 3 for detaljert informasjon om hvilke person&shy;opplysninger vi lagrer om de ulike st&oslash;ttespillerne v&aring;re.</p>\r\n<p><strong>3.&nbsp;</strong><strong>HVILKE PERSON&shy;OPPLYSNINGER VI LAGRER OG HVOR LENGE VI LAGRER DEM</strong></p>\r\n<p style=\"padding-left: 40px;\">RWS innhenter og lagrer ikke flere opplysninger enn n&oslash;dvendig for &aring; oppfylle form&aring;let med behandlingen.</p>\r\n<p style=\"padding-left: 40px;\">Du har rett til innsyn i de opplysninger RWS har registrert om deg og kan be om at opplysninger oppdateres, arkiveres eller slettes. RWS har etablert rutiner for &aring; slette og arkivere person&shy;opplysninger. Rutinene varierer avhengig av hvilken tilknytning du har til RWS, se punkt 3.1. &ndash; 3.4 for hvilke opplysninger vi lagrer om v&aring;re st&oslash;tte&shy;spillere og hvor lenge vi lagrer informasjonen.</p>\r\n<p style=\"padding-left: 40px;\"><strong>3.1. Sponsorer og ambassad&oslash;rer</strong></p>\r\n<p style=\"padding-left: 40px;\">For &aring; gi v&aring;re sponsorer og ambassad&oslash;rer en god oppf&oslash;lging lagrer vi navn, adresse, telefon&shy;nummer, e-postadresse, innsamlet bel&oslash;p, kj&oslash;nn.</p>\r\n<p style=\"padding-left: 40px;\">Opplysninger vi har mottatt i forbindelse med din avtale i RWS lagres i v&aring;rt sponsor- og ambassad&oslash;rregister s&aring; lenge du anses &aring; v&aelig;re aktiv giver i RWS. I tr&aring;d med bransjenormen for frivillige organisasjoner og behandling av personopplysninger anses en giver &aring; v&aelig;re aktiv giver i 3 &aring;r etter at siste bidrag ble gitt. Opplysninger vi etter bokf&oslash;ringsloven er forpliktet til &aring; bevare lagres i 5 &aring;r, i henhold til lovens krav.</p>\r\n<p style=\"padding-left: 40px;\">Hvis du oppgir telefonnummeret ditt og samtykker til videre kommunikasjon kan det hende at vi ringer deg eller sender SMS for &aring; sp&oslash;rre om du vil st&oslash;tte arbeidet til RWS.</p>\r\n<p><strong>4.</strong>&nbsp;<strong>FORM&Aring;L MED BEHANDLINGEN</strong></p>\r\n<p style=\"padding-left: 40px;\">RWS behandler person&shy;opplysninger for de form&aring;l som oppgis i denne erkl&aelig;ringen. Form&aring;l oppgis ogs&aring; ved innsamling av opplysninger.</p>\r\n<p style=\"padding-left: 40px;\">Vi samler inn informasjon om v&aring;re sponsorer og ambassad&oslash;rer for &aring; kunne;</p>\r\n<p style=\"padding-left: 40px;\">Bekrefte din identitet</p>\r\n<p style=\"padding-left: 40px;\">Ta imot og registrere st&oslash;tte til RWS</p>\r\n<p style=\"padding-left: 40px;\">Fullf&oslash;re bestilling av tjenester via kanaler som tilbys av RWS</p>\r\n<p style=\"padding-left: 40px;\">Registrere ulike medlemskap og &aring; f&oslash;lge opp disse</p>\r\n<p style=\"padding-left: 40px;\">Muliggj&oslash;re god service, slik som &aring; h&aring;ndtere dine henvendelser, rette opp feil informasjon eller &aring; sende deg informasjon.</p>\r\n<p style=\"padding-left: 40px;\">Vi behandler ogs&aring; personopplysninger for &aring; kunne drive v&aring;r virksomhet, det inneb&aelig;rer blant annet at vi behandler dine personopplysninger n&aring;r du er i kontakt med oss av ulike grunner. Eksempler p&aring; administrasjon som inneb&aelig;rer behandling av person&shy;opplysninger er:</p>\r\n<p style=\"padding-left: 40px;\">N&aring;r du henvender deg til oss p&aring; e-post h&aring;ndterer vi person&shy;opplysninger for &aring; kunne holde kontakt med deg og svare p&aring; din henvendelse.</p>\r\n<p style=\"padding-left: 40px;\">Om du er i kontakt med oss i forbindelse med yrkesrolle eller lignende kan dine person&shy;opplysninger lagres i referater, p&aring; fakturaer og lignende.</p>\r\n<p style=\"padding-left: 40px;\">I v&aring;r &oslash;konomiske administrasjon og oppf&oslash;lging forekommer person&shy;opplysninger p&aring; fakturaer/ kreditnota og utleggs&shy;refusjon.</p>\r\n<p><strong>5. GRUNNLAGET FOR BEHANDLINGEN</strong></p>\r\n<p style=\"padding-left: 40px;\">Vi behandler i all hovedsak person&shy;opplysninger om deg for &aring; ivareta v&aring;r forpliktelse og avtale med deg som sponsor, ambassad&oslash;r, giver, medlem, eller i forbindelse med andre tjenester som vi tilbyr.</p>\r\n<p style=\"padding-left: 40px;\">Noen av opplysningene om deg kan ogs&aring; oppbevares p&aring; grunn av krav i norsk lov. Eksempel p&aring; dette er rapportering av ditt bidrag til RWS til skatte&shy;myndighetene dersom du &oslash;nsker skattefradrag for ditt bidrag, eller &aring; innfri v&aring;re plikter i henhold til bokf&oslash;ringsloven.</p>\r\n<p style=\"padding-left: 40px;\">Behandling av personopplysninger skjer i tr&aring;d med gjeldende regelverk og inneb&aelig;rer at opplysninger om deg ikke lagres lengre enn n&oslash;dvendig og med hensyn til form&aring;let med behandlingen. Vi har interne rutiner for &aring; sikre dette, se punkt 3 som beskriver hvor lenge vi oppbevarer opplysninger om deg.</p>\r\n<p><strong>6. Bilder og filmer av barn</strong></p>\r\n<p style=\"padding-left: 40px;\">I noen tilfeller publiserer vi bilder og filmer av barn p&aring; nettsidene v&aring;re dersom vi har samtykke om dette fra barna selv og deres foreldre/foresatte. Bilder og filmer fjernes n&aring;r barn eller foreldrene ber om det via telefon eller e-post.</p>\r\n<p><strong>7. WEBANALYSE, INFORMASJONS&shy;KAPSLER/COOKIES OG LAGRING</strong></p>\r\n<p style=\"padding-left: 40px;\">Vi bruker informasjons&shy;kapsler/cookies p&aring; v&aring;re nettsider for &aring; gi deg best mulig bruker&shy;opplevelse og service. I henhold til lov om elektronisk kommunikasjon informerer vi v&aring;re bes&oslash;kende om bruk av informasjons&shy;kapsler (cookies). Les mer om v&aring;r bruk av informasjons&shy;kapsler p&aring; nettsidene v&aring;re.</p>\r\n<p><strong>8. UTLEVERING AV OPPLYSNINGER TIL TREDJE&shy;PARTER</strong></p>\r\n<p style=\"padding-left: 40px;\">Personopplysninger deles kun med andre selskaper eller underleverand&oslash;rer som utf&oslash;rer oppgaver p&aring; vegne av RWS og i forbindelse med levering av v&aring;re tjenester. Alle v&aring;re under&shy;leverand&oslash;rer er underlagt data&shy;behandler&shy;avtale med RWS. Det er RWS som har data&shy;behandler&shy;ansvar for all data som innhentes.</p>\r\n<p style=\"padding-left: 40px;\">I noen sammenhenger deler vi, overf&oslash;rer eller p&aring; annen m&aring;te utleverer person&shy;opplysninger til andre fordi vi er rettslig forpliktet til det, slik som n&aring;r vi utleverer n&oslash;dvendig informasjon til Br&oslash;nn&oslash;ysund&shy;registeret og skatteetaten.</p>\r\n<p style=\"padding-left: 40px;\">For &aring; kunne oppfylle v&aring;re forpliktelser etter avtale med deg utleveres n&oslash;dvendige opplysninger til v&aring;re sam&shy;arbeids&shy;partnere og under&shy;leverand&oslash;rer. Eksempelvis lagres personopplysninger i v&aring;rt giver- og medlemsregister. N&aring;r vi behandler en faktura lagres betalings&shy;informasjon i v&aring;rt fakturerings&shy;system. Disse systemene driftes av andre selskaper og informasjon lagres derfor ogs&aring; hos dem i tr&aring;d med v&aring;r data&shy;behandler&shy;avtale.</p>\r\n<p><strong>9. RETTIGHETER FOR DEN REGISTRERTE</strong></p>\r\n<p style=\"padding-left: 40px;\">Vi behandler dine personopplysninger i henhold til personopplysningsloven og gjeldende forskrifter. Du kan kreve innsyn i egne personopplysninger, samt kreve retting eller sletting av opplysninger. Du kan ogs&aring; klage til Datatilsynet p&aring; behandling som er i strid med reglene.</p>\r\n<p><strong>10. PERSONVERN&shy;OMBUD</strong></p>\r\n<p style=\"padding-left: 40px;\">RWS har oppnevnt et person&shy;vern&shy;ombud. Personvern&shy;ombudet p&aring;ser at person&shy;opplysningslovens regler om behandling av person&shy;opplysninger blir fulgt. Personvern&shy;ombudet n&aring;s p&aring; kontak&shy;tinformasjonen som gis i punkt 13 i denne erkl&aelig;ringen.</p>\r\n<p><strong>11. INFORMASJONS&shy;SIKKERHET</strong></p>\r\n<p style=\"padding-left: 40px;\">RWS har etablert og dokumentert rutiner og tiltak som skal sikre dine personopplysninger, integriteten av opplysningene, tilgjengeligheten og konfidensialiteten av dem.</p>\r\n<p style=\"padding-left: 40px;\">Vi sikrer dine person&shy;opplysninger ved b&aring;de fysisk og virtuell adgangs- og tilgangs&shy;kontroll, samt ved kryptering av sensitive deler av opplysninger.</p>\r\n<p><strong>12. KONTAKT&shy;INFORMASJON</strong></p>\r\n<p style=\"padding-left: 40px;\">Dersom du har henvendelser som gjelder personopplysninger og personvern n&aring;r du oss slik:</p>\r\n<p style=\"padding-left: 40px;\">E-post: info@rws.no</p>\r\n<p style=\"padding-left: 40px;\">Telefon: +(47) 47962700</p>\r\n<p style=\"padding-left: 40px;\">Adresse: Vipeveien 15, 1384 Asker.</p>\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 48px; top: 2554px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', '2021-03-30 03:57:47', '2021-03-30 05:11:40'),
(9, 'ambassador_section_title_en', 'AMBASSADOR MEMBER', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(10, 'ambassador_section_title_no', 'AMBASSADØR MEDLEM', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(11, 'ambassador_section_description_en', 'As an ambassador, you will donate 1 kroner for every kilometer you run. In addition, the sponsor members will be able to choose you as an ambassador, and they will also donate NOK 1 for each kilometer you run. Click below to get started!', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(12, 'ambassador_section_description_no', 'Som ambassadør vil du donere 1 krone for hver kilometer du løper. I tillegg vil sponsormedlemmene kunne velge deg som ambassadør, og de vil også donere 1 kr for hver kilometer du løper. Klikk nedenfor for å komme i gang!', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(13, 'sponsor_section_title_en', 'SPONSOR MEMBER', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(14, 'sponsor_section_title_no', 'SPONSOR MEDLEM', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(15, 'sponsor_section_description_en', 'As a sponsor, you choose an ambassador - you get a donation claim of NOK 1 x the number of kilometers you run. Click below to get started!', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(16, 'sponsor_section_description_no', 'Som sponsor velger du en ambassadør - du får et donasjonskrav på 1 kr x antall kilometer du løper. Klikk nedenfor for å komme i gang!', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(17, 'contributor_section_title_en', 'CONTRIBUTION', '2021-03-30 04:00:36', '2021-04-14 12:37:37'),
(18, 'contributor_section_title_no', 'ENGANGSBIDRAG', '2021-03-30 04:00:36', '2021-04-14 12:37:37'),
(19, 'contributor_section_description_en', 'We are happy to accept one-off contributions as well. Click below to donate any amount!', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(20, 'contributor_section_description_no', 'Vi tar gjerne imot engangsbidrag også. Klikk nedenfor for å gi et valgfritt beløp!', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(21, 'contact_us_phone', '47 96 27 00', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(22, 'contact_us_email', 'info@rws.no', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(23, 'contact_us_website', 'www.runwithsyed.no', '2021-03-30 04:00:36', '2021-03-30 04:00:36'),
(24, 'about_us_description_en', 'According to the WHO report from 2009, about 400 psychiatrists are registered in a country with around 200 million inhabitants. This corresponds to 1 psychiatrist per. 500,000 inhabitants. (WHO & Health Ministry, 2009). Research on mental health is limited in Pakistan, but the available evidence suggests that there are a large number of children living with mental illness without access to help (Raman, Hussain, 2001). And that in a populous country where approx. 35% of the inhabitants are children (Statista, 2020). At the same time, we see that Pakistan, according to a ranking from 2018, is the sixth most dangerous country for women to live in the world, so it is clear that this is an area that needs more focus and resources. (Thomson Reuters Foundation 2018, p 2)', '2021-03-30 04:03:59', '2021-03-30 04:03:59'),
(25, 'about_us_description_no', 'I følge WHOs rapport fra 2009 er om lag 400 psykiatere registrert i et land med rundt 200 millioner innbyggere. Dette tilsvarer 1 psykiater pr. 500 000 innbyggere. (WHO & Health Ministry, 2009). Forskning på mental helse er begrenset i Pakistan, men de tilgjengelige bevisene antyder at det er et stort antall barn som lever med psykiske lidelser uten tilgang til hjelp (Raman, Hussain, 2001). Og det i et folkerikt land hvor ca. 35% av innbyggerne er barn (Statista, 2020). Samtidig ser vi at Pakistan, ifølge en rangering fra 2018, er det sjette farligste landet for kvinner å leve i verden, så det er klart at dette er et område som trenger mer fokus og midler. (Thomson Reuters Foundation 2018, s 2)', '2021-03-30 04:03:59', '2021-03-30 04:03:59'),
(26, 'vision_and_goal_title_en', 'VISION AND GOALS', '2021-03-30 04:03:59', '2021-03-30 04:03:59'),
(27, 'vision_and_goal_title_no', 'VISJON OG MÅL', '2021-03-30 04:03:59', '2021-03-30 04:03:59'),
(28, 'vision_and_goal_description_en', 'Our vision is \"to improve life one mile at a time\". Our goal is to raise funds for our purpose by encouraging physical activity among the Norwegian population and making a difference in Norwegian and Pakistani public health. \r\n\r\nThe Pakistani hospital has promised us access to information so we can see exactly how many we can help thanks to the funds raised from our members.', '2021-03-30 04:03:59', '2021-04-19 06:29:26'),
(29, 'vision_and_goal_description_no', 'Vår visjon er \"å forbedre livet en mil om gangen\". Målet vårt er å samle inn midler til vårt formål ved å oppmuntre til fysisk aktivitet blant den norske befolkningen og gjøre en forskjell i norsk og pakistansk folkehelse.\r\n\r\nDet pakistanske sykehuset har lovet oss tilgang til informasjon slik at vi kan se nøyaktig hvor mange vi kan hjelpe takket være midlene som er samlet inn fra medlemmene våre.', '2021-03-30 04:03:59', '2021-03-30 04:03:59'),
(30, 'how_we_help_title_en', 'HOW SHOULD WE HELP?', '2021-03-30 04:03:59', '2021-03-30 04:03:59'),
(32, 'how_we_help_description_en', 'RunWithSyed is a volunteer-based association that aims to raise money for the situation in Pakistan while encouraging physical activity among its members.\r\n\r\nOur goal is that all the funds we collect will go directly to the purpose. Our costs must be as low as possible, so that the organization\'s management can cover these from its own pocket.', '2021-03-30 04:03:59', '2021-04-19 06:29:26'),
(33, 'how_we_help_description_no', 'RunWithSyed er en forening, basert på frivillighet, som har som mål å samle inn penger til situasjonen i Pakistan og samtidig oppmuntre til fysisk aktivitet blant medlemmene.\r\n\r\nMålet vårt er at alle midlene vi samler inn skal gå direkte til formålet. Våre kostnader skal være så lave som mulig, slik at organisasjonens ledelse kan dekke disse fra egen lomme.', '2021-03-30 04:03:59', '2021-03-30 04:03:59'),
(34, 'about_us_last_title_en', 'About Al-Mudassar Trust Hospital', '2021-03-30 04:03:59', '2021-03-30 04:03:59'),
(35, 'about_us_last_title_no', 'Om Sykehuset Al-Mudassar Trust', '2021-03-30 04:03:59', '2021-03-30 04:03:59'),
(36, 'about_us_last_description_en', 'Al-Mudassar Trust is an organization in Pakistan that aims to help children with various ailments.\r\n \r\nThe organization was started in 1999 and then treated children in old disused buildings, but in 2009 they raised enough funds to open their own modern hospital near the village of Baharwal, northeast of Pakistan.\r\n \r\nToday, the Al-Mudassar trust helps 450 disabled children live with their difficulties.\r\n \r\nThey are in the process of opening a ward for mentally ill children and our contributions will be earmarked for this ward.', '2021-03-30 04:03:59', '2021-04-06 10:44:21'),
(37, 'about_us_last_description_no', 'Al-Mudassar Trust er en organisasjon i Pakistan med formål å hjelpe barn med ulike lidelser. \r\n \r\nOrganisasjonen ble startet i 1999 og behandlet da barn i gamle nedlagte bygninger, men i 2009 fikk de samlet nok midler til å åpne sitt eget moderne sykehus nær landsbyen Baharwal, nordøst i Pakistan.\r\n \r\nI dag hjelper Al-Mudassar trust 450 funksjonsnedsatte barn med å leve med deres vanskeligheter.\r\n \r\nDe er i gang med å åpne en avdeling for mentalt syke barn og våre bidrag vil bli øremerket til denne avdelingen.', '2021-03-30 04:03:59', '2021-04-06 10:44:21'),
(38, 'about_us_image', 'exist', '2021-03-30 04:05:50', '2021-03-30 04:05:50'),
(39, 'how_we_help_title_no', 'HVORDAN SKAL VI HJELPE?', '2021-03-30 04:23:04', '2021-03-30 04:23:04'),
(40, 'ambassador_membership_fee', '200', '2021-04-05 03:36:40', '2021-04-05 03:36:40'),
(41, 'register_success_title_en', 'Welcome', '2021-04-15 10:53:49', '2021-04-15 10:53:49'),
(42, 'register_success_title_no', 'Velkommen', '2021-04-15 10:53:49', '2021-04-15 10:53:49'),
(43, 'register_success_description_en', '<p>You are receiving this email because you have made an important choice. The decision you have made will help mentally disadvantaged women and children in Pakistan. We are very grateful for this.</p>\r\n<p>RunWithSyed is an association that wants most people to participate in jogging to combat mental illness. For every kilometer that is run, a donation of NOK will be made. 1, - Your contribution will promote an issue that is taboo and help women fight challenges in everyday life with the disorder.</p>\r\n<p>For you as an ambassador, you will be a front figure for the association. Other members will have the opportunity to make donations based on the kilometers you have covered.</p>\r\n<p>For you as a sponsor, you will have the opportunity to choose between different ambassadors to sponsor. They run the distances and you choose who you want to sponsor. You are not tied to the same ambassador every month.</p>\r\n<p>We take good care of your personal data, and process it in a safe way. Here you can read more about privacy_link and terms_of_sale_link.</p>', '2021-04-15 10:53:49', '2021-06-29 08:46:09'),
(44, 'register_success_description_no', '<p>Du mottar denne eposten fordi du har gjort et viktig valg. Beslutningen du har tatt vil v&aelig;re med p&aring; &aring; hjelpe psykisk vanskeligstilte kvinner og barn i Pakistan. For dette er vi sv&aelig;rt takknemlig.&nbsp;</p>\r\n<p>RunWithSyed er en forening som &oslash;nsker at folk flest skal delta i jogge for &aring; bekjempe psykisk lidelse. For hver kilometer som l&oslash;pes vil det gj&oslash;res en donasjon p&aring; kr. 1,- Ditt bidrag vil fremme en problemstilling som er tabubelagt samt hjelpe kvinner bekjempe utfordringer i hverdagen med lidelsen.</p>\r\n<p>For deg som ambassad&oslash;r vil du v&aelig;re en frontfigurer for foreningen. Andre medlemmer vil ha muligheten til &aring; gi donasjoner p&aring; bakgrunn av de kilometerne du har lagt bak deg.</p>\r\n<p>For deg som sponsor vil du ha muligheten til &aring; velge mellom ulike ambassad&oslash;rer &aring; sponse. De l&oslash;per distansene og du velger hvem du vil sponse. Du er ikke bundet til samme ambassad&oslash;r hver m&aring;ned.&nbsp;</p>\r\n<p>Vi tar godt h&aring;nd om dine persondata, og behandler de p&aring; en trygg m&aring;te. Her kan du lese mer om personvern_link og salgsvilkar_link.</p>', '2021-04-15 10:53:49', '2021-06-29 09:40:01'),
(45, 'organization_no', '925 516 236', '2021-06-07 11:26:38', '2021-06-07 11:26:38'),
(46, 'sales_terms_title_en', 'Terms of sale', '2021-06-10 09:21:29', '2021-06-10 09:21:29'),
(47, 'sales_terms_title_no', 'Salgsbetingelser', '2021-06-10 09:21:29', '2021-06-10 09:21:29'),
(48, 'sales_terms_description_en', '<h5><strong>Partene</strong></h5>\r\n<p>Selger / Mottaker er RunWithSyed, ORG NR 925516236, Vipeveien 15, 1384 Asker, <a href=\"mailto:finance@rws.no\">finance@rws.no</a>.</p>\r\n<p>Kj&oslash;per / Giver: Du som donerer penger.</p>\r\n<h5><strong>Betaling</strong></h5>\r\n<p>Alle RunWithSyed sine donasjoner mottas gjennom betaling &ldquo;betal med Vipps&rdquo; funksjonen fra v&aring;re nettsider. Alle donasjoner er frivillige, og &ldquo;kj&oslash;per&rdquo; har ingen forpliktelser mot RunWithSyed.</p>\r\n<h5><strong>Levering</strong></h5>\r\n<p>RunWithSyed selger ingen produkter eller tjenester og har ingen form for levering.</p>\r\n<h5><strong>Angrerett</strong></h5>\r\n<p>Alle v&aring;re donasjoner er frivillige og anser dem som gaver. Dersom noen av v&aring;re givere skulle angre p&aring; gaven de har gitt m&aring; de si ifra innen rimelig tid og skal f&aring; gaven returnert i l&oslash;pet av tre arbeidsdager.</p>\r\n<h5><strong>Mangel ved varen - Kj&oslash;perens rettigheter og reklamasjonsfrist</strong></h5>\r\n<p>RunWithSyed selger ingen produkter eller tjenester og har derfor ikke noen reklamasjonsfrister. Givere kan kontakte oss innen rimelig tid for &aring; f&aring; gaven returnert.&nbsp;</p>\r\n<h5><strong>Konfliktl&oslash;sning</strong></h5>\r\n<p>Klager rettes til selger innen rimelig tid, jf. punkt 9 og 10. Partene skal fors&oslash;ke &aring; l&oslash;se eventuelle tvister i minnelighet. Dersom dette ikke lykkes, kan kj&oslash;peren ta kontakt med Forbrukertilsynet for mekling. Forbrukertilsynet er tilgjengelig p&aring;&nbsp;telefon 23 400 600.</p>', '2021-06-10 09:21:29', '2021-06-10 09:29:22'),
(49, 'sales_terms_description_no', '<h5><strong>Partene</strong></h5>\r\n<p>Selger / Mottaker er RunWithSyed, ORG NR 925516236, Vipeveien 15, 1384 Asker, <a href=\"mailto:finance@rws.no\">finance@rws.no</a>.</p>\r\n<p>Kj&oslash;per / Giver: Du som donerer penger.</p>\r\n<h5><strong>Betaling</strong></h5>\r\n<p>Alle RunWithSyed sine donasjoner mottas gjennom betaling &ldquo;betal med Vipps&rdquo; funksjonen fra v&aring;re nettsider. Alle donasjoner er frivillige, og &ldquo;kj&oslash;per&rdquo; har ingen forpliktelser mot RunWithSyed.</p>\r\n<h5><strong>Levering</strong></h5>\r\n<p>RunWithSyed selger ingen produkter eller tjenester og har ingen form for levering.</p>\r\n<h5><strong>Angrerett</strong></h5>\r\n<p>Alle v&aring;re donasjoner er frivillige og anser dem som gaver. Dersom noen av v&aring;re givere skulle angre p&aring; gaven de har gitt m&aring; de si ifra innen rimelig tid og skal f&aring; gaven returnert i l&oslash;pet av tre arbeidsdager.</p>\r\n<h5><strong>Mangel ved varen - Kj&oslash;perens rettigheter og reklamasjonsfrist</strong></h5>\r\n<p>RunWithSyed selger ingen produkter eller tjenester og har derfor ikke noen reklamasjonsfrister. Givere kan kontakte oss innen rimelig tid for &aring; f&aring; gaven returnert.&nbsp;</p>\r\n<h5><strong>Konfliktl&oslash;sning</strong></h5>\r\n<p>Klager rettes til selger innen rimelig tid, jf. punkt 9 og 10. Partene skal fors&oslash;ke &aring; l&oslash;se eventuelle tvister i minnelighet. Dersom dette ikke lykkes, kan kj&oslash;peren ta kontakt med Forbrukertilsynet for mekling. Forbrukertilsynet er tilgjengelig p&aring;&nbsp;telefon 23 400 600.</p>\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 98px; top: 646px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', '2021-06-10 09:21:29', '2021-06-10 09:29:22'),
(50, 'become_sponsor_success_description_en', '<p>You have now chosen your sponsor and in the future you will donate NOK 1 for every kilometer your ambassador runs. You can click on my page to see the number of KM your ambassador has run each month.</p>\r\n<p>You will have the opportunity to pay only when the current month is over.</p>', '2021-08-20 02:41:33', '2021-08-20 02:42:55'),
(51, 'become_sponsor_success_description_no', '<p>Du har n&aring; valgt din sponser og fremover s&aring; vil du donere 1kr for hver kilometer din ambassad&oslash;r l&oslash;per. Du kan klikke deg inn p&aring; min side for &aring; se antall KM din ambassad&oslash;r har l&oslash;pt hver m&aring;ned.</p>\r\n<p>Du vil ha muligheten til &aring; betale f&oslash;rst n&aring;r innev&aelig;rende m&aring;neden er over.</p>', '2021-08-20 02:41:33', '2021-08-20 02:42:23');

-- --------------------------------------------------------

--
-- Table structure for table `sponsor_ambassadors`
--

CREATE TABLE `sponsor_ambassadors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sponsor_user_id` bigint(20) UNSIGNED NOT NULL,
  `ambassador_user_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sponsor_ambassadors`
--

INSERT INTO `sponsor_ambassadors` (`id`, `sponsor_user_id`, `ambassador_user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 1, '2021-03-30 07:37:31', '2021-08-23 04:05:12'),
(2, 4, 3, 1, '2021-03-30 09:38:19', '2021-03-31 06:43:26'),
(3, 10, 9, 1, '2021-04-14 13:36:06', '2021-04-14 13:36:06');

-- --------------------------------------------------------

--
-- Table structure for table `sponsor_ambassador_payments`
--

CREATE TABLE `sponsor_ambassador_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sponsor_ambassador_id` bigint(20) UNSIGNED NOT NULL,
  `month_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sponsor_ambassador_payments`
--

INSERT INTO `sponsor_ambassador_payments` (`id`, `sponsor_ambassador_id`, `month_year`, `payment_id`, `created_at`, `updated_at`) VALUES
(11, 1, '04-2021', 54, NULL, NULL),
(12, 1, '05-2021', 54, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `mobile_no`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'RWS', 'Admin', 'firmapost@digitalmx.no', NULL, '$2y$10$bfudFLSKReMfwYW9.jyyheqMqfrctDe0Ze2uFlfknFxHgCl.9dvgy', NULL, 1, NULL, '2021-03-30 03:13:05', '2021-05-05 08:33:42'),
(2, 'Ameer', 'Hamza', 'ameer@digitalmx.no', NULL, '$2y$10$K8K/balkHXJPmKkhRG6OFekWs1fhaOPcQr7DoiVZGOLetsm4lTnEK', '76555700', 1, NULL, '2021-03-30 09:08:36', '2021-04-23 07:52:41'),
(3, 'Second', 'DMX Ambassador', 'ambassador1@gmail.com', NULL, '$2y$10$By0zff0bF21tNZ6XyBScsuhH7IVF3zsv09DQbbA9mZ.Z2cVf.OnHS', '76555722', 1, NULL, '2021-03-30 09:14:03', '2021-04-16 11:35:02'),
(4, 'DMX', 'Sponsor', 'ameer54158@gmail.com', NULL, '$2y$10$YZulxiWoHrNlF.Mvr85im.YA6QVINJ4av7Ls7DNJQEiuo9UGTr.G6', '69606417', 1, NULL, '2021-03-30 09:37:49', '2021-08-20 01:43:34'),
(9, 'Azeem', 'Iqbal', 'azeem@digitalmx.no', NULL, '$2y$10$TN4bVmMAZ9U/oU1IAy1A0O1hZCsnhFSc00YuqoWu0ZTdWXTSrqeKK', '92212103', 1, 'e3dZ8Kfj08xbIsBSfCO6OFfVoiYheo68uCIkDX5qHmoXqRNrhu7VNXV3fD2l', '2021-04-06 11:33:25', '2021-06-09 10:55:15'),
(10, 'Ghazi', 'Syed', 'ghazialamdar@gmail.com', NULL, '$2y$10$9BTG4g21w/xngBAOdX7Yle/NhFienFaGPlZX3pBR3z22cf99trami', '47962700', 1, NULL, '2021-04-14 13:25:38', '2021-04-14 13:29:26'),
(11, 'Narve', 'Wilsgaard', 'narve_wilsgaard@hotmail.com', NULL, '$2y$10$agd/m4DHg8U0L/PajEWZd.wBEF2AGMuwP1uiAH9LQIUHShrxDtB62', '93457801', 1, NULL, '2021-04-14 13:26:27', '2021-04-16 11:35:02'),
(12, 'Ghazi', 'Syed', 'sga1411@gmail.com', NULL, '$2y$10$akgC9peb7jGXUQgmdcy.eeZ2ADdCVZ2Klkx/tBi2no/ZYXUNDO9Y2', '47962700', 1, NULL, '2021-04-15 08:18:09', '2021-04-16 11:35:02'),
(13, 'Mohammad Ali', 'Syed', 'mohammedali11@gmail.com', NULL, '$2y$10$OzdMha07IByS6rqwIjTJYeyYKeupxcJTAucDn9k2SH6YQZeaZMXkq', '40087072', 1, NULL, '2021-04-15 08:24:51', '2021-04-16 11:35:02'),
(14, 'steffen', 'pedersen', 'steffen.bjerknes.pedersen@gmail.com', NULL, '$2y$10$d1xa27QdjEWSayTl9f2FTO0yuYd7r6EnRF3GVgP6zRcr2nooesmce', '92689405', 1, NULL, '2021-04-15 08:28:24', '2021-04-16 11:35:02'),
(15, 'Håkon', 'Bogen', 'hakon.bogen@live.no', NULL, '$2y$10$H8A/UdF2zxsc6kOyEW.Gge.ljMwKme5gTsuKTM.mo4eDR1MrOXRx6', '40463454', 1, NULL, '2021-04-16 16:00:57', '2021-04-16 16:00:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image_permission` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `gender`, `zip_code`, `zip_city`, `address`, `profile_image_permission`, `created_at`, `updated_at`, `description`) VALUES
(1, 2, 'male', NULL, NULL, NULL, 1, '2021-03-30 09:08:36', '2021-04-06 07:52:53', 'Jeg ble med i RunWithSyed fordi jeg vil hjelpe mennesker med psykiske lidelser. Jeg mistet et familiemedlem som slet med dette og personlig har opplevd utfordringer med mental helse.'),
(2, 3, 'male', '1384', 'Asker', 'Vipeveien 15, 1384 Asker, Norway', 1, '2021-03-30 09:14:03', '2021-04-19 05:53:18', 'Jeg har slitt med psykiske lidelser, men var heldig nok til å få hjelp og er helt frisk i dag. Nå vil jeg hjelpe andre som ikke har tilgang til samme oppfølging'),
(3, 4, 'male', NULL, NULL, NULL, 1, '2021-03-30 09:37:49', '2021-08-20 03:20:07', NULL),
(5, 9, 'male', '1472', 'Fjellhamar', 'Lørdagsrudveien 2', 1, '2021-04-06 11:33:25', '2021-04-14 08:44:30', 'Jeg valgte å bli amabassadør fordi det motiverer meg å støtte en god sak ved å løpe noen km hver dag.'),
(6, 10, 'male', '1384', 'Asker', 'Vipeveien 15', 1, '2021-04-14 13:25:38', '2021-04-14 13:25:38', NULL),
(7, 11, 'male', '3408', 'Tranby', 'Hyllveien 18 H', 1, '2021-04-14 13:26:27', '2021-04-14 13:33:36', 'Jeg er en av initiativtakerne i RWS. RWS brukes som en godt påskudd til å ta vare på meg selv samtidig som jeg bidrar til en god sak!'),
(8, 12, 'male', '1384', 'Asker', 'Vipeveien 15', 1, '2021-04-15 08:18:09', '2021-04-15 08:19:12', 'Jeg er en av initiativtakerne i RWS. RWS brukes som en godt påskudd til å ta vare på meg selv samtidig som jeg bidrar til en god sak!'),
(9, 13, 'male', '1384', 'Asker', 'Vipeveien 15', 1, '2021-04-15 08:24:51', '2021-04-16 16:06:32', 'Hei, Jeg heter Ali.'),
(10, 14, 'male', '0655', 'Oslo', 'sigurd hoels veis 17', 1, '2021-04-15 08:28:24', '2021-04-15 08:28:24', NULL),
(11, 15, 'male', '0356', 'Oslo', 'Vibes Gate 31 B', 1, '2021-04-16 16:00:57', '2021-04-16 16:00:57', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ambassador_payments`
--
ALTER TABLE `ambassador_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ambassador_payments_user_id_foreign` (`user_id`),
  ADD KEY `ambassador_payments_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `ambassador_runs`
--
ALTER TABLE `ambassador_runs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ambassador_runs_user_id_foreign` (`user_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dymantic_instagram_basic_profiles`
--
ALTER TABLE `dymantic_instagram_basic_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dymantic_instagram_basic_profiles_username_unique` (`username`);

--
-- Indexes for table `dymantic_instagram_feed_tokens`
--
ALTER TABLE `dymantic_instagram_feed_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `initiators`
--
ALTER TABLE `initiators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metas`
--
ALTER TABLE `metas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_top_ambassadors`
--
ALTER TABLE `our_top_ambassadors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `our_top_ambassadors_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_user_permission_id_index` (`permission_id`),
  ADD KEY `permission_user_user_id_index` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_role_id_index` (`role_id`),
  ADD KEY `role_user_user_id_index` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsor_ambassadors`
--
ALTER TABLE `sponsor_ambassadors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sponsor_ambassadors_sponsor_user_id_foreign` (`sponsor_user_id`),
  ADD KEY `sponsor_ambassadors_ambassador_user_id_foreign` (`ambassador_user_id`);

--
-- Indexes for table `sponsor_ambassador_payments`
--
ALTER TABLE `sponsor_ambassador_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sponsor_ambassador_payments_sponsor_ambassador_id_foreign` (`sponsor_ambassador_id`),
  ADD KEY `sponsor_ambassador_payments_payment_id_foreign` (`payment_id`);

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
-- AUTO_INCREMENT for table `ambassador_payments`
--
ALTER TABLE `ambassador_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `ambassador_runs`
--
ALTER TABLE `ambassador_runs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dymantic_instagram_basic_profiles`
--
ALTER TABLE `dymantic_instagram_basic_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dymantic_instagram_feed_tokens`
--
ALTER TABLE `dymantic_instagram_feed_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `initiators`
--
ALTER TABLE `initiators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `metas`
--
ALTER TABLE `metas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `our_top_ambassadors`
--
ALTER TABLE `our_top_ambassadors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permission_user`
--
ALTER TABLE `permission_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `sponsor_ambassadors`
--
ALTER TABLE `sponsor_ambassadors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sponsor_ambassador_payments`
--
ALTER TABLE `sponsor_ambassador_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ambassador_payments`
--
ALTER TABLE `ambassador_payments`
  ADD CONSTRAINT `ambassador_payments_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ambassador_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ambassador_runs`
--
ALTER TABLE `ambassador_runs`
  ADD CONSTRAINT `ambassador_runs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `our_top_ambassadors`
--
ALTER TABLE `our_top_ambassadors`
  ADD CONSTRAINT `our_top_ambassadors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sponsor_ambassadors`
--
ALTER TABLE `sponsor_ambassadors`
  ADD CONSTRAINT `sponsor_ambassadors_ambassador_user_id_foreign` FOREIGN KEY (`ambassador_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sponsor_ambassadors_sponsor_user_id_foreign` FOREIGN KEY (`sponsor_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sponsor_ambassador_payments`
--
ALTER TABLE `sponsor_ambassador_payments`
  ADD CONSTRAINT `sponsor_ambassador_payments_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sponsor_ambassador_payments_sponsor_ambassador_id_foreign` FOREIGN KEY (`sponsor_ambassador_id`) REFERENCES `sponsor_ambassadors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
