-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 07, 2025 at 10:26 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cipherecc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@site.com', 'admin', NULL, '67c00e2484edd1740639780.png', '$2y$12$e6/3cuUybzXR/2SJclGW..RoJfHrvmNBsMUKCakC0k7a8LPLsegtK', NULL, NULL, '2025-03-05 02:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `click_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `batch_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '\r\n',
  `et` tinyint NOT NULL DEFAULT '0',
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `schedule` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_contacts`
--

CREATE TABLE `campaign_contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `campaign_id` int UNSIGNED NOT NULL DEFAULT '0',
  `contact_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `firstname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>enable, 0=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_jobs`
--

CREATE TABLE `cron_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cron_schedule_id` int NOT NULL DEFAULT '0',
  `next_run` datetime DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `is_running` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_jobs`
--

INSERT INTO `cron_jobs` (`id`, `name`, `alias`, `action`, `url`, `cron_schedule_id`, `next_run`, `last_run`, `is_running`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Send SMS Cron', 'send_sms_cron', '[\"App\\\\Http\\\\Controllers\\\\CronController\", \"sendSMS\"]', NULL, 1, '2025-02-27 10:10:24', '2025-02-27 09:10:24', 1, 1, '2023-06-21 17:29:14', '2025-02-27 03:10:24'),
(2, 'Resend SMS Cron', 'resend_sms_cron', '[\"App\\\\Http\\\\Controllers\\\\CronController\", \"resendSMS\"]', NULL, 1, '2025-02-05 18:16:10', '2025-02-05 17:16:10', 1, 1, '2023-06-22 00:04:49', '2025-02-05 11:16:10'),
(3, 'Check Expired Plans', 'plan_expired_cron', '[\"App\\\\Http\\\\Controllers\\\\CronController\", \"checkExpiredPlan\"]', NULL, 1, '2025-02-05 20:28:51', '2025-02-05 19:28:51', 1, 1, '2023-06-22 00:04:49', '2025-02-05 13:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `cron_job_logs`
--

CREATE TABLE `cron_job_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `cron_job_id` int UNSIGNED NOT NULL DEFAULT '0',
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `duration` int UNSIGNED NOT NULL DEFAULT '0',
  `error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_schedules`
--

CREATE TABLE `cron_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interval` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_schedules`
--

INSERT INTO `cron_schedules` (`id`, `name`, `interval`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hourly', 3600, 1, '2024-03-13 23:34:09', '2024-05-06 04:45:32'),
(3, 'Daily', 86400, 1, '2024-05-06 04:46:39', '2024-05-06 04:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `plan_id` int UNSIGNED NOT NULL DEFAULT '0',
  `method_code` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `method_currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `final_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `btc_amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_try` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT '0',
  `admin_feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `success_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failed_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_cron` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `device_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `android_version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>connected\r\n, 0=>disconnected',
  `sim` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `is_app` tinyint(1) NOT NULL DEFAULT '0',
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'object',
  `support` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'twak.png', 0, '2019-10-18 11:16:05', '2024-05-16 06:23:02'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"6LdPC88fAAAAADQlUf_DV6Hrvgm-pZuLJFSLDOWV\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"6LdPC88fAAAAAG5SVaRYDnV2NpCrptLg2XLYKRKB\"}}', 'recaptcha.png', 0, '2019-10-18 11:16:05', '2025-02-23 09:39:39'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 11:16:05', '2025-02-23 09:39:36'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google_analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{measurement_id}}\"></script>\n                <script>\n                  window.dataLayer = window.dataLayer || [];\n                  function gtag(){dataLayer.push(arguments);}\n                  gtag(\"js\", new Date());\n                \n                  gtag(\"config\", \"{{measurement_id}}\");\n                </script>', '{\"measurement_id\":{\"title\":\"Measurement ID\",\"value\":\"------\"}}', 'ganalytics.png', 0, NULL, '2021-05-03 22:19:12'),
(5, 'fb-comment', 'Facebook Comment ', 'Key location is shown bellow', 'Facebook.png', '<div id=\"fb-root\"></div><script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1\"></script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}', 'fb_com.png', 0, NULL, '2022-03-21 17:18:36');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint UNSIGNED NOT NULL,
  `data_keys` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tempname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `created_at`, `updated_at`) VALUES
(2, 'cookie.data', '{\"short_desc\":\"We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.\",\"description\":\"<h4>Cookie Policy<\\/h4>\\r\\n\\r\\n<p>This Cookie Policy explains how to use cookies and similar technologies to recognize you when you visit our website. It explains what these technologies are and why we use them, as well as your rights to control our use of them.<\\/p>\\r\\n<br>\\r\\n<h4>What are cookies?<\\/h4>\\r\\n\\r\\n<p>Cookies are small pieces of data stored on your computer or mobile device when you visit a website. Cookies are widely used by website owners to make their websites work, or to work more efficiently, as well as to provide reporting information.<\\/p>\\r\\n<br>\\r\\n<h4>Why do we use cookies?<\\/h4>\\r\\n\\r\\n<p>We use cookies for several reasons. Some cookies are required for technical reasons for our Website to operate, and we refer to these as \\\"essential\\\" or \\\"strictly necessary\\\" cookies. Other cookies enable us to track and target the interests of our users to enhance the experience on our Website. Third parties serve cookies through our Website for advertising, analytics, and other purposes.<\\/p>\\r\\n<br>\\r\\n<h4>What types of cookies do we use?<\\/h4>\\r\\n\\r\\n<div>\\r\\n    <ul style=\\\"list-style: unset;\\\">\\r\\n        <li>\\r\\n            <strong>Essential Website Cookies:<\\/strong> \\r\\n            These cookies are strictly necessary to provide you with services available through our Website and to use some of its features.\\r\\n        <\\/li>\\r\\n        <li>\\r\\n            <strong>Analytics and Performance Cookies:<\\/strong> \\r\\n            These cookies allow us to count visits and traffic sources to measure and improve our Website\'s performance.\\r\\n        <\\/li>\\r\\n        <li>\\r\\n            <strong>Advertising Cookies:<\\/strong> \\r\\n            These cookies make advertising messages more relevant to you and your interests. They perform functions like preventing the same ad from continuously reappearing, ensuring that ads are properly displayed, and in some cases selecting advertisements that are based on your interests.\\r\\n        <\\/li>\\r\\n    <\\/ul>\\r\\n<\\/div>\\r\\n<br>\\r\\n<h4>Data Collected by Cookies<\\/h4>\\r\\n<p>Cookies may collect various types of data, including but not limited to:<\\/p>\\r\\n<ul style=\\\"list-style: unset;\\\">\\r\\n    <li>IP addresses<\\/li>\\r\\n    <li>Browser and device information<\\/li>\\r\\n    <li>Referring website addresses<\\/li>\\r\\n    <li>Pages visited on our website<\\/li>\\r\\n    <li>Interactions with our website, such as clicks and mouse movements<\\/li>\\r\\n    <li>Time spent on our website<\\/li>\\r\\n<\\/ul>\\r\\n<br>\\r\\n<h4>How We Use Collected Data<\\/h4>\\r\\n\\r\\n<p>We may use data collected by cookies for the following purposes:<\\/p>\\r\\n<ul style=\\\"list-style: unset;\\\">\\r\\n    <li>To personalize your experience on our website<\\/li>\\r\\n    <li>To improve our website\'s functionality and performance<\\/li>\\r\\n    <li>To analyze trends and gather demographic information about our user base<\\/li>\\r\\n    <li>To deliver targeted advertising based on your interests<\\/li>\\r\\n    <li>To prevent fraudulent activity and enhance website security<\\/li>\\r\\n<\\/ul>\\r\\n<br>\\r\\n<h4>Third-party cookies<\\/h4>\\r\\n\\r\\n<p>In addition to our cookies, we may also use various third-party cookies to report usage statistics of our Website, deliver advertisements on and through our Website, and so on.<\\/p>\\r\\n<br>\\r\\n<h4>How can we control cookies?<\\/h4>\\r\\n\\r\\n<p>You have the right to decide whether to accept or reject cookies. You can exercise your cookie preferences by clicking on the \\\"Cookie Settings\\\" link in the footer of our website. You can also set or amend your web browser controls to accept or refuse cookies. If you choose to reject cookies, you may still use our Website though your access to some functionality and areas of our Website may be restricted.<\\/p>\\r\\n<br>\\r\\n<h4>Changes to our Cookie Policy<\\/h4>\\r\\n\\r\\n<p>We may update our Cookie Policy from time to time. We will notify you of any changes by posting the new Cookie Policy on this page.<\\/p>\",\"status\":1}', NULL, NULL, NULL, '2020-07-04 23:42:52', '2025-01-11 05:02:52'),
(3, 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"details\":\"<h5>Introduction<\\/h5>\\n<p>\\n    This Privacy Policy describes how we collect, use, and disclose information, including personal information, in\\n    connection with your use of our website.\\n<\\/p>\\n<br \\/>\\n<h5>Information We Collect<\\/h5>\\n<p>We collect two main types of information on the Website:<\\/p><p><br \\/><\\/p>\\n<ul>\\n    <li>\\n        <p class=\\\"mb-2\\\"><span class=\\\"fw-bold\\\">Personal Information: <\\/span>This includes data that can identify you as an individual, such as\\n            your name, email address, phone number, or mailing address. We only collect this information when you\\n            voluntarily provide it to us, like signing up for a newsletter, contacting us through a form, or making a\\n            purchase.<\\/p><\\/li><li>\\n        <p><span class=\\\"fw-bold\\\">Non-Personal Information: <\\/span>This data cannot be used to identify you directly. It includes\\n            details like your browser type, device type, operating system, IP address, browsing activity, and usage\\n            statistics. We collect this information automatically through cookies and other tracking technologies.<\\/p>\\n    <\\/li>\\n<\\/ul>\\n<br \\/>\\n<h5>How We Use Information<\\/h5>\\n<p>The information we collect allows us to:<\\/p>\\n<ul>\\n    <li>Operate and maintain the Website effectively.<\\/li>\\n    <li>Send you newsletters or marketing communications, but only with your consent.<\\/li>\\n    <li>Respond to your inquiries and fulfill your requests.<\\/li>\\n    <li>Improve the Website and your user experience.<\\/li>\\n    <li>Personalize your experience on the Website based on your browsing habits.<\\/li>\\n    <li>Analyze how the Website is used to improve our services.<\\/li>\\n    <li>Comply with legal and regulatory requirements.<\\/li>\\n<\\/ul>\\n<br \\/>\\n<h5>Sharing of Information<\\/h5>\\n<p>We may share your information with trusted third-party service providers who assist us in operating the Website and\\n    delivering our services. These providers are obligated by contract to keep your information confidential and use it\\n    only for the specific purposes we disclose it.<\\/p>\\n<p>We will never share your personal information with any third parties for marketing purposes without your explicit\\n    consent.<\\/p>\\n<br \\/>\\n<h5>Data Retention<\\/h5>\\n<p>We retain your personal information only for as long as necessary to fulfill the purposes it was collected. We\\n    may retain it for longer periods only if required or permitted by law.<\\/p>\\n<br \\/>\\n<h5>Security Measures<\\/h5>\\n<p>We take reasonable precautions to protect your information from unauthorized access, disclosure, alteration, or\\n    destruction. However, complete security cannot be guaranteed for any website or internet transmission.<\\/p>\\n<br \\/>\\n<h5>Changes to this Privacy Policy<\\/h5>\\n<p>We may update this Privacy Policy periodically. We will notify you of any changes by posting the revised policy on\\n    the Website. We recommend reviewing this policy regularly to stay informed of any updates.<\\/p>\\n<p><strong>Remember:<\\/strong> This is a sample policy and may need adjustments to comply with specific laws and reflect\\n    your website\'s unique data practices. Consider consulting with a legal professional to ensure your policy is fully\\n    compliant.<\\/p>\"}', NULL, 'basic', 'privacy-policy', '2021-06-09 08:50:42', '2025-03-12 01:47:21'),
(4, 'policy_pages.element', '{\"title\":\"Terms of Service\",\"details\":\"<div class=\\\"mb-5\\\">\\n    <h5 class=\\\"mb-3\\\">What information do we collect?<\\/h5>\\n    <p>We\\n        gather data from you when you register on our site, submit a request,\\n        buy any services, react to an overview, or round out a structure. At the\\n        point when requesting any assistance or enrolling on our site, as\\n        suitable, you might be approached to enter your: name, email address, or\\n        telephone number. You may, nonetheless, visit our site anonymously.<\\/p>\\n<\\/div>\\n<div class=\\\"mb-5\\\">\\n    <h5 class=\\\"mb-3\\\">How do we protect your information?<\\/h5>\\n    <p>All provided delicate\\/credit data is\\n        sent through Stripe.<br \\/>After\\n        an exchange, your private data (credit cards, social security numbers,\\n        financials, and so on) won\'t be put away on our workers.<\\/p>\\n<\\/div>\\n<div class=\\\"mb-5\\\">\\n    <h5 class=\\\"mb-3\\\">Do we disclose any information to outside parties?<\\/h5>\\n    <p>We\\n        don\'t sell, exchange, or in any case, move to outside gatherings by and\\n        by recognizable data. This does exclude confided-in outsiders who help\\n        us in working our site, leading our business, or adjusting you since\\n        those gatherings consent to keep this data private. We may likewise\\n        deliver your data when we accept discharge is suitable to follow the\\n        law, implement our site strategies, or ensure our own or others\' rights,\\n        property, or wellbeing.<\\/p>\\n<\\/div>\\n<div class=\\\"mb-5\\\">\\n    <h5 class=\\\"mb-3\\\">Children\'s Online Privacy Protection Act Compliance<\\/h5>\\n    <p>We\\n        are consistent with the prerequisites of COPPA (Children\'s Online\\n        Privacy Protection Act), we don\'t gather any data from anybody under 13\\n        years old. Our site, items, and administrations are completely\\n        coordinated to individuals who are in any event 13 years of age or more\\n        established.<\\/p>\\n<\\/div>\\n<div class=\\\"mb-5\\\">\\n    <h5 class=\\\"mb-3\\\">\\n        Changes to our Privacy Policy<\\/h5>\\n    <p>If we decide to change our privacy\\n        policy, we will post those changes on this page.<\\/p>\\n<\\/div>\\n<div class=\\\"mb-5\\\">\\n    <h5 class=\\\"mb-3\\\">How long we retain your information?<\\/h5>\\n    <p>At\\n        the point when you register for our site, we cycle and keep the\\n        information we have about you however long you don\'t erase the record or\\n        withdraw yourself (subject to laws and guidelines).<\\/p>\\n<\\/div>\\n<div>\\n    <h5 class=\\\"mb-3\\\">What we don\\u2019t do with your data<\\/h5>\\n    <p>We\\n        don\'t and will never share, unveil, sell, or in any case give your\\n        information to different organizations for the promotion of their items\\n        or administrations.<\\/p>\\n<\\/div>\"}', NULL, 'basic', 'terms-of-service', '2021-06-09 08:51:18', '2025-03-12 02:16:51'),
(5, 'maintenance.data', '{\"description\":\"<div class=\\\"mb-5\\\" style=\\\"font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"text-align: center; font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif;\\\"><font color=\\\"#ff0000\\\">THE SITE IS UNDER MAINTENANCE<\\/font><\\/h3><p class=\\\"font-18\\\" style=\\\"color: rgb(111, 111, 111); text-align: center; margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We\'re just tuning up a few things.We apologize for the inconvenience but Front is currently undergoing planned maintenance. Thanks for your patience.<\\/p><\\/div>\",\"image\":\"6603c203472ad1711522307.png\"}', NULL, NULL, NULL, '2020-07-04 23:42:52', '2024-03-27 06:51:47'),
(6, 'register_disable.content', '{\"has_image\":\"1\",\"heading\":\"Registration Currently Disabled\",\"subheading\":\"Page you are looking for doesn\'t exit or an other error occurred or temporarily unavailable.\",\"button_name\":\"Go to Home\",\"button_url\":\"#\"}', NULL, 'basic', '', '2024-05-07 05:23:12', '2025-01-11 05:04:42'),
(7, 'banner.content', '{\"has_image\":\"1\",\"title\":\"SMS Marketing Platform\",\"heading\":\"Grow Your Business with CipherECC!\",\"subheading\":\"CipherECC is a powerful SMS marketing platform that lets you send bulk messages, manage contacts, and grow your business effortlessly.\",\"left_button_text\":\"Get Started\",\"left_button_link\":\"user\\/register\",\"right_button_text\":\"Pricing Plans\",\"right_button_link\":\"pricing\",\"thumbnail_image\":\"67d03339512b81741697849.png\"}', NULL, 'basic', '', '2024-12-19 01:04:07', '2025-03-12 02:02:18'),
(8, 'about.content', '{\"has_image\":\"1\",\"title\":\"About Us\",\"heading\":\"Effective SMS Marketing for Your Audience\",\"subheading\":\"Our Android app provides a simple and reliable solution for sending SMS easily.\",\"description\":\"We empower businesses to connect with their audience through targeted SMS campaigns, delivering messages to the right people at the right time. Our platform simplifies engagement, helping you build strong relationships and drive results.\",\"button_text\":\"Get Started\",\"button_url\":\"user\\/register\",\"about_image\":\"67d037b8ad41c1741699000.png\"}', NULL, 'basic', '', '2024-12-19 02:43:45', '2025-03-12 00:51:36'),
(9, 'about.element', '{\"about_info\":\"Manage SMS\"}', NULL, 'basic', '', '2024-12-19 02:47:30', '2024-12-19 02:47:30'),
(10, 'feature.content', '{\"title\":\"Our Best Features\",\"heading\":\"Awesome Features\",\"subheading\":\"We provide simple and professional Android App based SMS-sending system.\"}', NULL, 'basic', '', '2024-12-19 03:39:38', '2025-03-12 00:49:31'),
(11, 'service.content', '{\"title\":\"What we offer\",\"heading\":\"Our Services\",\"subheading\":\"We provide powerful SMS marketing solutions to help businesses reach, engage, and convert their audience effectively.\"}', NULL, 'basic', '', '2024-12-19 03:58:39', '2025-02-26 09:46:09'),
(12, 'service.element', '{\"has_image\":[\"1\"],\"title\":\"Multiple Device\",\"description\":\"Enables SMS services to be accessed and synchronized across multiple devices for seamless communication and management.\",\"icon_image\":\"67d04d59768ff1741704537.png\"}', NULL, 'basic', '', '2024-12-19 04:12:53', '2025-03-11 08:48:57'),
(13, 'plan.content', '{\"has_image\":\"1\",\"title\":\"Pricing Plan\",\"heading\":\"Choose Your Best Plan\",\"subheading\":\"Select the perfect plan to fit your business needs and boost your SMS marketing.\",\"background_image_left\":\"6783bd1f3bbbe1736686879.png\",\"background_image_right\":\"6783bd1f9aedb1736686879.png\"}', NULL, 'basic', '', '2024-12-19 04:18:56', '2025-02-26 12:11:10'),
(14, 'faq.content', '{\"has_image\":\"1\",\"title\":\"FAQ\",\"heading\":\"Some Common Questions About Us\",\"subheading\":\"Find answers to frequently asked questions and learn more about our services.\",\"faq_image\":\"67d0427cd59b81741701756.png\"}', NULL, 'basic', '', '2024-12-19 04:33:55', '2025-03-11 08:02:37'),
(15, 'cta.content', '{\"has_image\":\"1\",\"title\":\"Download App\",\"heading\":\"Download the app and stay connected with us.\",\"subheading\":\"Get started by downloading the app and enjoy seamless access to all our features.\",\"playstore_url\":\"https:\\/\\/play.google.com\\/store\",\"cta_image\":\"67d0473df39281741702973.png\"}', NULL, 'basic', '', '2024-12-19 04:55:24', '2025-03-11 08:22:54'),
(16, 'cta.element', '{\"has_image\":\"1\",\"download_title\":\"Get In Now\",\"download_name\":\"Play Store\",\"download_url\":\"#\",\"download_icon_image\":\"6763fd847f1071734606212.png\"}', NULL, 'basic', '', '2024-12-19 04:58:40', '2024-12-19 05:03:32'),
(17, 'cta.element', '{\"has_image\":\"1\",\"download_title\":\"Download on the\",\"download_name\":\"App Store\",\"download_url\":\"#\",\"download_icon_image\":\"6763fd7e2d9f81734606206.png\"}', NULL, 'basic', '', '2024-12-19 04:59:33', '2024-12-19 05:03:26'),
(18, 'subscribe.content', '{\"heading\":\"Subscribe to Our Newsletter\",\"subheading\":\"Subscribe to receive the latest news, updates, and exclusive offers directly to your inbox.\",\"button_text\":\"Subscribe Now\"}', NULL, 'basic', '', '2024-12-19 05:18:53', '2025-02-26 12:20:19'),
(19, 'social_icon.element', '{\"social_icon\":\"<i class=\\\"fab fa-facebook-f\\\"><\\/i>\",\"url\":\"https:\\/\\/www.facebook.com\"}', NULL, 'basic', '', '2024-12-19 06:34:43', '2024-12-19 06:34:43'),
(20, 'social_icon.element', '{\"social_icon\":\"<i class=\\\"fa-brands fa-x-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/x.com\"}', NULL, 'basic', '', '2024-12-19 06:35:07', '2025-03-05 03:01:34'),
(21, 'social_icon.element', '{\"social_icon\":\"<i class=\\\"fab fa-vimeo-v\\\"><\\/i>\",\"url\":\"https:\\/\\/vimeo.com\\/\"}', NULL, 'basic', '', '2024-12-19 06:35:50', '2024-12-19 06:35:50'),
(22, 'social_icon.element', '{\"social_icon\":\"<i class=\\\"fab fa-pinterest-p\\\"><\\/i>\",\"url\":\"https:\\/\\/www.pinterest.com\\/\"}', NULL, 'basic', '', '2024-12-19 06:36:32', '2024-12-19 06:36:32'),
(23, 'footer.content', '{\"short_description\":\"Simplifying SMS marketing with powerful tools to help you connect, engage, and grow your audience. Experience seamless communication and drive results with our easy-to-use platform.\"}', NULL, 'basic', '', '2024-12-19 06:47:38', '2025-02-26 13:05:08'),
(24, 'contact.content', '{\"has_image\":\"1\",\"address\":\"Group Connecting Blue Street, London, United Kingdom\",\"primary_email_address\":\"CipherECC@hotmail.com\",\"secondary_email_address\":\"CipherECC@support.com\",\"primary_phone_number\":\"(+44) 10 1234-9876\",\"secondary_phone_number\":\"(+44) 10 3654-4835\",\"location_map_url\":\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d9930.539626840724!2d-0.12433517618053506!3d51.51991374905573!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761b4df01ad43b%3A0x743398820b6bb233!2sConnect%20Group!5e0!3m2!1sen!2sbd!4v1741754522352!5m2!1sen!2sbd\",\"form_title\":\"Contact Us\",\"form_button_text\":\"Send Message\",\"image\":\"67d143f3d4b251741767667.png\"}', NULL, 'basic', '', '2024-12-19 07:40:39', '2025-03-12 02:21:08'),
(25, 'auth.content', '{\"has_image\":\"1\",\"auth_image\":\"67666a848bb341734765188.png\"}', NULL, 'basic', '', '2024-12-19 08:30:24', '2025-03-05 03:40:26'),
(26, 'blog.content', '{\"title\":\"Blog\",\"heading\":\"Our Latest Articles\",\"subheading\":\"Stay updated with the latest insights, trends, and news through our articles.\"}', NULL, 'basic', '', '2025-01-13 01:08:16', '2025-03-11 22:39:45'),
(27, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"How to Boost Sales with SMS Marketing\",\"description\":\"<p class=\\\"blog-details__desc\\\">Retirement planning is essential for ensuring financial security and peace of mind in\\r\\n    your golden years. In this blog post, we discuss key retirement planning strategies, including setting\\r\\n    retirement goals, estimating retirement expenses, maximizing retirement savings accounts, and creating a\\r\\n    sustainable withdrawal plan. Whether you\'re decades away from retirement or nearing your retirement age, this\\r\\n    guide will help you take proactive steps towards a financially secure future.<br \\/><br \\/>\\r\\n<\\/p>\\r\\n<h5>From setting clear retirement goals to estimating your future expenses and income needs<\\/h5>\\r\\n<div>we\'ll guide you through the process of creating a solid retirement plan tailored to your unique circumstances.\\r\\n    Whether you\'re decades away from retirement or nearing your retirement age, this guide offers valuable insights\\r\\n    to help you make informed decisions and take proactive steps towards achieving your retirement objectives.<br \\/>\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n\\r\\n<blockquote style=\\\"font-style:italic;text-align:left;padding:20px;background:#4255ff1a;font-weight:500;font-size:18px;border-left:4px solid #4255ff;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam\\r\\n    phasellus hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n\\r\\n\\r\\n<h5>Planning for retirement doesn\'t end with accumulating savings<\\/h5>\\r\\n<div>It also involves developing a sustainable withdrawal strategy to ensure your funds last throughout your\\r\\n    retirement years. We\'ll discuss key factors to consider when creating a withdrawal plan, such as your expected\\r\\n    lifespan, inflation, and investment returns, to help you strike the right balance between enjoying your\\r\\n    retirement lifestyle and preserving your financial security.<br \\/><\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h5>Planning before starting<\\/h5>\\r\\n<div>Whether you\'re just starting your career, mid-career, or approaching retirement age, it\'s never too early or\\r\\n    too late to begin planning for your future. Join us as we empower you with the knowledge and tools you need to\\r\\n    take control of your retirement destiny and embark on the path towards a financially secure and fulfilling\\r\\n    retirement.<br \\/><\\/div>\",\"image\":\"67bae7b9b81d21740302265.png\"}', NULL, 'basic', 'how-to-boost-sales-with-sms-marketing', '2025-01-13 01:11:32', '2025-03-12 01:17:56'),
(28, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"SMS Marketing Platform\",\"bulk sms\",\"single sms\",\"sms automation\",\"sms campaign\"],\"description\":\"CipherECC is a powerful SaaS-based SMS marketing platform that allows businesses to send bulk messages, automate campaigns, and engage customers with ease. With advanced features like scheduling, API integration, and real-time analytics, CipherECC helps you boost communication effortlessly.\",\"social_title\":\"CipherECC - SMS Marketing Platform as SaaS\",\"social_description\":\"Send bulk SMS, automate campaigns, and engage your audience with ease using CipherECC\\u2014a powerful SaaS-based SMS marketing platform. With real-time analytics, scheduling, and API integration, reaching your customers has never been easier.\",\"image\":\"67d153c691c461741771718.png\"}', NULL, NULL, '', '2025-01-13 01:11:39', '2025-03-12 03:28:38'),
(29, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Why SMS Marketing is a Game-Changer for Businesses\",\"description\":\"<p class=\\\"blog-details__desc\\\">Retirement planning is essential for ensuring financial security and peace of mind in\\r\\n    your golden years. In this blog post, we discuss key retirement planning strategies, including setting\\r\\n    retirement goals, estimating retirement expenses, maximizing retirement savings accounts, and creating a\\r\\n    sustainable withdrawal plan. Whether you\'re decades away from retirement or nearing your retirement age, this\\r\\n    guide will help you take proactive steps towards a financially secure future.<br \\/><br \\/>\\r\\n<\\/p>\\r\\n<h5>From setting clear retirement goals to estimating your future expenses and income needs<\\/h5>\\r\\n<div>we\'ll guide you through the process of creating a solid retirement plan tailored to your unique circumstances.\\r\\n    Whether you\'re decades away from retirement or nearing your retirement age, this guide offers valuable insights\\r\\n    to help you make informed decisions and take proactive steps towards achieving your retirement objectives.<br \\/>\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n\\r\\n<blockquote style=\\\"font-style:italic;text-align:left;padding:20px;background:#4255ff1a;font-weight:500;font-size:18px;border-left:4px solid #4255ff;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam\\r\\n    phasellus hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n\\r\\n\\r\\n<h5>Planning for retirement doesn\'t end with accumulating savings<\\/h5>\\r\\n<div>It also involves developing a sustainable withdrawal strategy to ensure your funds last throughout your\\r\\n    retirement years. We\'ll discuss key factors to consider when creating a withdrawal plan, such as your expected\\r\\n    lifespan, inflation, and investment returns, to help you strike the right balance between enjoying your\\r\\n    retirement lifestyle and preserving your financial security.<br \\/><\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h5>Planning before starting<\\/h5>\\r\\n<div>Whether you\'re just starting your career, mid-career, or approaching retirement age, it\'s never too early or\\r\\n    too late to begin planning for your future. Join us as we empower you with the knowledge and tools you need to\\r\\n    take control of your retirement destiny and embark on the path towards a financially secure and fulfilling\\r\\n    retirement.<br \\/><\\/div>\",\"image\":\"67bae6c76c7cd1740302023.png\"}', NULL, 'basic', 'why-sms-marketing-is-a-game-changer-for-businesses', '2025-01-13 01:13:49', '2025-03-12 01:17:46'),
(30, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"5 Tips for Creating Engaging SMS Campaigns\",\"description\":\"<p class=\\\"blog-details__desc\\\">Retirement planning is essential for ensuring financial security and peace of mind in\\r\\n    your golden years. In this blog post, we discuss key retirement planning strategies, including setting\\r\\n    retirement goals, estimating retirement expenses, maximizing retirement savings accounts, and creating a\\r\\n    sustainable withdrawal plan. Whether you\'re decades away from retirement or nearing your retirement age, this\\r\\n    guide will help you take proactive steps towards a financially secure future.<br \\/><br \\/>\\r\\n<\\/p>\\r\\n<h5>From setting clear retirement goals to estimating your future expenses and income needs<\\/h5>\\r\\n<div>we\'ll guide you through the process of creating a solid retirement plan tailored to your unique circumstances.\\r\\n    Whether you\'re decades away from retirement or nearing your retirement age, this guide offers valuable insights\\r\\n    to help you make informed decisions and take proactive steps towards achieving your retirement objectives.<br \\/>\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n\\r\\n<blockquote style=\\\"font-style:italic;text-align:left;padding:20px;background:#4255ff1a;font-weight:500;font-size:18px;border-left:4px solid #4255ff;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam\\r\\n    phasellus hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n\\r\\n\\r\\n<h5>Planning for retirement doesn\'t end with accumulating savings<\\/h5>\\r\\n<div>It also involves developing a sustainable withdrawal strategy to ensure your funds last throughout your\\r\\n    retirement years. We\'ll discuss key factors to consider when creating a withdrawal plan, such as your expected\\r\\n    lifespan, inflation, and investment returns, to help you strike the right balance between enjoying your\\r\\n    retirement lifestyle and preserving your financial security.<br \\/><\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h5>Planning before starting<\\/h5>\\r\\n<div>Whether you\'re just starting your career, mid-career, or approaching retirement age, it\'s never too early or\\r\\n    too late to begin planning for your future. Join us as we empower you with the knowledge and tools you need to\\r\\n    take control of your retirement destiny and embark on the path towards a financially secure and fulfilling\\r\\n    retirement.<br \\/><\\/div>\",\"image\":\"67bae343ebd0a1740301123.png\"}', NULL, 'basic', '5-tips-for-creating-engaging-sms-campaigns', '2025-01-13 03:19:29', '2025-03-12 01:17:36'),
(31, 'about.element', '{\"about_info\":\"Manage Device\"}', NULL, 'basic', '', '2025-02-03 04:40:26', '2025-02-03 04:40:26'),
(32, 'about.element', '{\"about_info\":\"Manage Group\"}', NULL, 'basic', '', '2025-02-03 04:40:32', '2025-02-26 09:44:55'),
(33, 'about.element', '{\"about_info\":\"Manage SMS Template\"}', NULL, 'basic', '', '2025-02-03 04:40:37', '2025-02-03 04:40:37'),
(34, 'about.element', '{\"about_info\":\"Manage Campaign\"}', NULL, 'basic', '', '2025-02-03 04:40:42', '2025-02-26 09:45:00'),
(35, 'about.element', '{\"about_info\":\"Manage Contact\"}', NULL, 'basic', '', '2025-02-03 04:40:48', '2025-02-26 09:45:05'),
(36, 'service.element', '{\"has_image\":[\"1\"],\"title\":\"Bulk SMS\",\"description\":\"A service that allows businesses to send large volumes of messages to multiple recipients simultaneously for marketing, alerts, or notifications.\",\"icon_image\":\"67d04d4f22d421741704527.png\"}', NULL, 'basic', '', '2025-02-03 04:42:22', '2025-03-11 08:48:47'),
(37, 'service.element', '{\"has_image\":[\"1\"],\"title\":\"Short Message Service\",\"description\":\"A communication protocol for sending and receiving text messages over mobile networks, enabling fast and reliable text-based communication.\",\"icon_image\":\"67d12c0f9ab541741761551.png\"}', NULL, 'basic', '', '2025-02-03 04:42:43', '2025-03-12 00:39:11'),
(38, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Schedule SMS\",\"description\":\"Schedule SMS in advance to automatically send messages at the perfect time, ensuring timely communication with your audience.\",\"icon_image\":\"67d12b4acf1081741761354.png\"}', NULL, 'basic', '', '2025-02-03 04:44:17', '2025-03-12 00:35:54'),
(39, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Campaign Builder\",\"description\":\"Create and customize SMS campaigns effortlessly with our intuitive Campaign Builder, designed for maximum reach and engagement.\",\"icon_image\":\"67d12b442a2a11741761348.png\"}', NULL, 'basic', '', '2025-02-03 04:44:40', '2025-03-12 00:35:48'),
(40, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Group Builder\",\"description\":\"Easily organize your contacts into groups for targeted messaging and more effective SMS campaigns.\",\"icon_image\":\"67d123d7c4d0b1741759447.png\"}', NULL, 'basic', '', '2025-02-03 04:45:14', '2025-03-12 00:04:07'),
(41, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Developer Tools\",\"description\":\"Integrate SMS functionality into your applications seamlessly with our powerful APIs and developer-friendly tools.\",\"icon_image\":\"67d12b3c859771741761340.png\"}', NULL, 'basic', '', '2025-02-03 04:45:31', '2025-03-12 00:35:40'),
(42, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Template Builder\",\"description\":\"Easily create and personalize SMS templates to streamline your messaging and maintain consistency.\",\"icon_image\":\"67d123cb64e121741759435.png\"}', NULL, 'basic', '', '2025-02-03 04:45:55', '2025-03-12 00:03:55'),
(43, 'feature.element', '{\"has_image\":\"1\",\"title\":\"SMS History\",\"description\":\"View and manage your sent, received, and scheduled messages, with an option to resend failed SMS.\",\"icon_image\":\"67d12a9e3f8f71741761182.png\"}', NULL, 'basic', '', '2025-02-03 04:46:20', '2025-03-12 00:33:02'),
(44, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Push Notifications\",\"description\":\"Receive real-time updates and alerts while sending SMS with our powerful push notification feature.\",\"icon_image\":\"67d12913d017d1741760787.png\"}', NULL, 'basic', '', '2025-02-03 04:46:45', '2025-03-12 00:26:27'),
(45, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Support Ticket\",\"description\":\"Submit and track support tickets to resolve any issues quickly with our dedicated support team.\",\"icon_image\":\"67d12a5a9f2661741761114.png\"}', NULL, 'basic', '', '2025-02-03 04:47:02', '2025-03-12 00:31:54'),
(46, 'faq.element', '{\"question\":\"How does SMS marketing work?\",\"answer\":\"SMS marketing allows businesses to send promotional messages, updates, and alerts directly to customers\' mobile phones, driving engagement and conversions.\"}', NULL, 'basic', '', '2025-02-03 04:49:45', '2025-02-26 12:13:21'),
(47, 'faq.element', '{\"question\":\"How do I create an SMS campaign?\",\"answer\":\"After logging in, navigate to \\\"Manage Campaign\\\" and select \\\"Create Campaign\\\". Fill out the form with the required details, then submit it. Your campaign will be successfully created.\"}', NULL, 'basic', '', '2025-02-03 04:50:03', '2025-02-26 12:14:58'),
(48, 'faq.element', '{\"question\":\"What is the cost of SMS marketing?\",\"answer\":\"Our pricing varies depending on the plan and volume of messages sent. You can choose a plan that best fits your needs.\"}', NULL, 'basic', '', '2025-02-03 04:50:44', '2025-02-26 12:15:26'),
(49, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Increase Customer Engagement with Bulk SMS\",\"description\":\"<p class=\\\"blog-details__desc\\\">Retirement planning is essential for ensuring financial security and peace of mind in\\r\\n    your golden years. In this blog post, we discuss key retirement planning strategies, including setting\\r\\n    retirement goals, estimating retirement expenses, maximizing retirement savings accounts, and creating a\\r\\n    sustainable withdrawal plan. Whether you\'re decades away from retirement or nearing your retirement age, this\\r\\n    guide will help you take proactive steps towards a financially secure future.<br \\/><br \\/>\\r\\n<\\/p>\\r\\n<h5>From setting clear retirement goals to estimating your future expenses and income needs<\\/h5>\\r\\n<div>we\'ll guide you through the process of creating a solid retirement plan tailored to your unique circumstances.\\r\\n    Whether you\'re decades away from retirement or nearing your retirement age, this guide offers valuable insights\\r\\n    to help you make informed decisions and take proactive steps towards achieving your retirement objectives.<br \\/>\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n\\r\\n<blockquote style=\\\"font-style:italic;text-align:left;padding:20px;background:#4255ff1a;font-weight:500;font-size:18px;border-left:4px solid #4255ff;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam\\r\\n    phasellus hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n\\r\\n\\r\\n<h5>Planning for retirement doesn\'t end with accumulating savings<\\/h5>\\r\\n<div>It also involves developing a sustainable withdrawal strategy to ensure your funds last throughout your\\r\\n    retirement years. We\'ll discuss key factors to consider when creating a withdrawal plan, such as your expected\\r\\n    lifespan, inflation, and investment returns, to help you strike the right balance between enjoying your\\r\\n    retirement lifestyle and preserving your financial security.<br \\/><\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h5>Planning before starting<\\/h5>\\r\\n<div>Whether you\'re just starting your career, mid-career, or approaching retirement age, it\'s never too early or\\r\\n    too late to begin planning for your future. Join us as we empower you with the knowledge and tools you need to\\r\\n    take control of your retirement destiny and embark on the path towards a financially secure and fulfilling\\r\\n    retirement.<br \\/><\\/div>\",\"image\":\"67bae9409cb7e1740302656.png\"}', NULL, 'basic', 'increase-customer-engagement-with-bulk-sms', '2025-02-23 09:24:16', '2025-03-12 01:04:40'),
(50, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"SMS vs. Email Marketing: Which Works Best?\",\"description\":\"<p class=\\\"blog-details__desc\\\">Retirement planning is essential for ensuring financial security and peace of mind in\\r\\n    your golden years. In this blog post, we discuss key retirement planning strategies, including setting\\r\\n    retirement goals, estimating retirement expenses, maximizing retirement savings accounts, and creating a\\r\\n    sustainable withdrawal plan. Whether you\'re decades away from retirement or nearing your retirement age, this\\r\\n    guide will help you take proactive steps towards a financially secure future.<br \\/><br \\/>\\r\\n<\\/p>\\r\\n<h5>From setting clear retirement goals to estimating your future expenses and income needs<\\/h5>\\r\\n<div>we\'ll guide you through the process of creating a solid retirement plan tailored to your unique circumstances.\\r\\n    Whether you\'re decades away from retirement or nearing your retirement age, this guide offers valuable insights\\r\\n    to help you make informed decisions and take proactive steps towards achieving your retirement objectives.<br \\/>\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n\\r\\n<blockquote style=\\\"font-style:italic;text-align:left;padding:20px;background:#4255ff1a;font-weight:500;font-size:18px;border-left:4px solid #4255ff;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam\\r\\n    phasellus hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n\\r\\n\\r\\n<h5>Planning for retirement doesn\'t end with accumulating savings<\\/h5>\\r\\n<div>It also involves developing a sustainable withdrawal strategy to ensure your funds last throughout your\\r\\n    retirement years. We\'ll discuss key factors to consider when creating a withdrawal plan, such as your expected\\r\\n    lifespan, inflation, and investment returns, to help you strike the right balance between enjoying your\\r\\n    retirement lifestyle and preserving your financial security.<br \\/><\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h5>Planning before starting<\\/h5>\\r\\n<div>Whether you\'re just starting your career, mid-career, or approaching retirement age, it\'s never too early or\\r\\n    too late to begin planning for your future. Join us as we empower you with the knowledge and tools you need to\\r\\n    take control of your retirement destiny and embark on the path towards a financially secure and fulfilling\\r\\n    retirement.<br \\/><\\/div>\",\"image\":\"67baea44baab01740302916.png\"}', NULL, 'basic', 'sms-vs-email-marketing-which-works-best', '2025-02-23 09:28:36', '2025-03-12 01:05:12'),
(51, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"How to Grow Your Business with Targeted SMS Messages\",\"description\":\"<p class=\\\"blog-details__desc\\\">Retirement planning is essential for ensuring financial security and peace of mind in\\r\\n    your golden years. In this blog post, we discuss key retirement planning strategies, including setting\\r\\n    retirement goals, estimating retirement expenses, maximizing retirement savings accounts, and creating a\\r\\n    sustainable withdrawal plan. Whether you\'re decades away from retirement or nearing your retirement age, this\\r\\n    guide will help you take proactive steps towards a financially secure future.<br \\/><br \\/>\\r\\n<\\/p>\\r\\n<h5>From setting clear retirement goals to estimating your future expenses and income needs<\\/h5>\\r\\n<div>we\'ll guide you through the process of creating a solid retirement plan tailored to your unique circumstances.\\r\\n    Whether you\'re decades away from retirement or nearing your retirement age, this guide offers valuable insights\\r\\n    to help you make informed decisions and take proactive steps towards achieving your retirement objectives.<br \\/>\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n\\r\\n<blockquote style=\\\"font-style:italic;text-align:left;padding:20px;background:#4255ff1a;font-weight:500;font-size:18px;border-left:4px solid #4255ff;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam\\r\\n    phasellus hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n\\r\\n\\r\\n<h5>Planning for retirement doesn\'t end with accumulating savings<\\/h5>\\r\\n<div>It also involves developing a sustainable withdrawal strategy to ensure your funds last throughout your\\r\\n    retirement years. We\'ll discuss key factors to consider when creating a withdrawal plan, such as your expected\\r\\n    lifespan, inflation, and investment returns, to help you strike the right balance between enjoying your\\r\\n    retirement lifestyle and preserving your financial security.<br \\/><\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h5>Planning before starting<\\/h5>\\r\\n<div>Whether you\'re just starting your career, mid-career, or approaching retirement age, it\'s never too early or\\r\\n    too late to begin planning for your future. Join us as we empower you with the knowledge and tools you need to\\r\\n    take control of your retirement destiny and embark on the path towards a financially secure and fulfilling\\r\\n    retirement.<br \\/><\\/div>\",\"image\":\"67baeb533d8691740303187.png\"}', NULL, 'basic', 'how-to-grow-your-business-with-targeted-sms-messages', '2025-02-23 09:33:07', '2025-03-12 01:17:13'),
(52, 'policy_pages.element', '{\"title\":\"Refund Policy\",\"details\":\"<p>We strive to ensure that our services meet the highest standards of quality and reliability. We are\\n    committed to\\n    providing a positive experience for our customers. If for any reason you are not satisfied with the service you\\n    have\\n    purchased, we offer a refund policy designed to provide transparency and fairness.<\\/p>\\n\\n<div class=\\\"my-4\\\">\\n    <h5 class=\\\"mb-3\\\">Eligibility for Refunds<\\/h5>\\n    <p>Refund requests are eligible within <strong>14 days<\\/strong> from the date of purchase. After\\n        this period, we\\n        cannot offer a refund. To qualify for a refund, the following conditions must be met:<\\/p><p><br \\/><\\/p>\\n    <ol>\\n        <li class=\\\"mb-2\\\">\\n            <p><strong>Service Delivery Failure<\\/strong>: If the service you purchased was not delivered\\n                as per the\\n                agreed\\n                terms or experienced significant issues, we will review the situation and consider issuing a refund.\\n            <\\/p>\\n        <\\/li>\\n        <li class=\\\"mb-2\\\">\\n            <p><strong>Technical Issues<\\/strong>: In case the purchased service was unusable due to\\n                technical\\n                problems,\\n                such\\n                as system outages or unfulfilled functionalities, a refund will be processed after a thorough\\n                evaluation\\n                of\\n                the issue.<\\/p>\\n        <\\/li>\\n    <\\/ol>\\n<\\/div>\\n\\n<div class=\\\"mb-4\\\">\\n    <h5 class=\\\"mb-3\\\">Non-refundable Services<\\/h5>\\n    <p>Certain services are not eligible for refunds, including but not limited to:<\\/p>\\n    <ul>\\n        <li><strong>Credits Used for SMS Delivery<\\/strong>: Once SMS messages are sent, they cannot be refunded.\\n        <\\/li>\\n        <li><strong>Custom Services<\\/strong>: Services that are highly personalized, including custom templates or\\n            integrations, may not be refundable after they are delivered or used.<\\/li>\\n    <\\/ul>\\n<\\/div>\\n\\n<div class=\\\"mb-4\\\">\\n    <h5 class=\\\"mb-3\\\">How to Request a Refund<\\/h5>\\n    <p>To request a refund, please follow these steps:<\\/p>\\n    <ol>\\n        <li class=\\\"mb-2\\\"><strong>Contact Us<\\/strong>: Reach out to our customer support team via email at\\n            [<a>support@example.com<\\/a>] or\\n            through our support portal.<\\/li>\\n        <li class=\\\"mb-2\\\"><strong>Provide Details<\\/strong>: Include your order number, a description of the issue, and any\\n            relevant\\n            documentation (e.g., screenshots or error messages).<\\/li>\\n        <li class=\\\"mb-2\\\"><strong>Review Process<\\/strong>: Our team will review your request and get back to you within 3-5\\n            business\\n            days.\\n            If your refund request is approved, it will be processed immediately.<\\/li>\\n    <\\/ol>\\n<\\/div>\\n\\n<div class=\\\"mb-4\\\">\\n    <h5 class=\\\"mb-3\\\">Refund Processing<\\/h5>\\n    <p>Refunds will be issued to the original payment method. Depending on your payment provider, it may\\n        take up to\\n        <strong>7-10 business days<\\/strong> for the refund to appear in your account.\\n    <\\/p>\\n<\\/div>\\n\\n<div>\\n    <h5 class=\\\"mb-3\\\">Customer Satisfaction<\\/h5>\\n    <p>We aim to resolve any issues promptly and ensure that you are satisfied with our services. If you\\n        are\\n        dissatisfied\\n        with any aspect of our service, please contact us, and we will do our best to address your concerns.<\\/p>\\n    <p>By using our services, you agree to this Refund Policy. Thank you for choosing us!<\\/p>\\n<\\/div>\"}', NULL, 'basic', 'refund-policy', '2025-02-26 12:41:07', '2025-03-12 02:20:06'),
(53, 'login.content', '{\"title\":\"Welcome Back\",\"heading\":\"Sign In to Your Account\"}', NULL, 'basic', '', '2025-03-05 03:43:27', '2025-03-11 05:48:17'),
(54, 'brands.element', '{\"has_image\":\"1\",\"image\":\"67d1283fd6c861741760575.png\"}', NULL, 'basic', '', '2025-03-08 06:54:18', '2025-03-12 00:22:56'),
(55, 'brands.element', '{\"has_image\":\"1\",\"image\":\"67d128458d8a81741760581.png\"}', NULL, 'basic', '', '2025-03-08 06:54:24', '2025-03-12 00:23:01'),
(56, 'brands.element', '{\"has_image\":\"1\",\"image\":\"67d1284a17c101741760586.png\"}', NULL, 'basic', '', '2025-03-08 06:54:29', '2025-03-12 00:23:06'),
(57, 'brands.element', '{\"has_image\":\"1\",\"image\":\"67d1285309e7f1741760595.png\"}', NULL, 'basic', '', '2025-03-08 06:54:34', '2025-03-12 00:23:15'),
(58, 'brands.element', '{\"has_image\":\"1\",\"image\":\"67d12857d86131741760599.png\"}', NULL, 'basic', '', '2025-03-08 06:54:39', '2025-03-12 00:23:19'),
(59, 'brands.element', '{\"has_image\":\"1\",\"image\":\"67d1285c7dcf71741760604.png\"}', NULL, 'basic', '', '2025-03-08 06:54:48', '2025-03-12 00:23:24'),
(60, 'how_it_works.content', '{\"title\":\"How It Works\",\"heading\":\"Send SMS Quickly with These Simple Steps\",\"subheading\":\"Get started easily, engage your audience, and watch your business grow!\"}', NULL, 'basic', '', '2025-03-08 07:02:30', '2025-03-08 07:09:05'),
(61, 'how_it_works.element', '{\"title\":\"Purchase Plan\",\"description\":\"Choose a subscription plan that fits your needs.\"}', NULL, 'basic', '', '2025-03-08 07:03:00', '2025-03-08 07:06:22'),
(62, 'how_it_works.element', '{\"title\":\"Download APK\",\"description\":\"Get the CipherECC Android app and install it.\"}', NULL, 'basic', '', '2025-03-08 07:03:27', '2025-03-08 07:06:43'),
(63, 'how_it_works.element', '{\"title\":\"Scan QR Code\",\"description\":\"Link your device quickly by scanning the QR code within the app.\"}', NULL, 'basic', '', '2025-03-08 07:03:50', '2025-03-08 07:03:50'),
(64, 'how_it_works.element', '{\"title\":\"Send SMS\",\"description\":\"Start sending bulk SMS instantly and connect with your audience effortlessly.\"}', NULL, 'basic', '', '2025-03-08 07:04:08', '2025-03-08 07:04:08'),
(65, 'testimonial.content', '{\"title\":\"Testimonial\",\"heading\":\"What Our Client Says\",\"subheading\":\"Hear from our satisfied clients about their success with CipherECC!\"}', NULL, 'basic', '', '2025-03-08 07:16:33', '2025-03-08 07:16:33'),
(66, 'service.element', '{\"has_image\":[\"1\"],\"title\":\"SMS Campaign\",\"description\":\"A targeted messaging strategy to send bulk SMS for promotions, alerts, or notifications. It ensures quick and direct communication with customers or users.\",\"icon_image\":\"67d12c05240321741761541.png\"}', NULL, 'basic', '', '2025-03-08 07:18:16', '2025-03-12 00:39:01'),
(67, 'service.element', '{\"has_image\":[\"1\"],\"title\":\"API Integrations\",\"description\":\"Connects SMS services with external systems for automated messaging, notifications, and two-way communication. It enables seamless data exchange for efficient workflow automation.\",\"icon_image\":\"67d04d3be3e4e1741704507.png\"}', NULL, 'basic', '', '2025-03-08 07:18:47', '2025-03-11 08:48:27'),
(68, 'service.element', '{\"has_image\":[\"1\"],\"title\":\"Import & Exports\",\"description\":\"Allows users to upload contacts, templates, or data in bulk for SMS campaigns.\\r\\nExport: Enables users to download reports, contact lists, and message logs for analysis or backup.\",\"icon_image\":\"67d12c4ed6a7e1741761614.png\"}', NULL, 'basic', '', '2025-03-08 07:19:33', '2025-03-12 00:40:14'),
(69, 'testimonial.element', '{\"has_image\":\"1\",\"quote\":\"This service has completely transformed our business. The team is highly professional and responsive.\",\"name\":\"John Doe\",\"designation\":\"CEO, InnovateTech\",\"image\":\"67d11c9f18acf1741757599.png\"}', NULL, 'basic', '', '2025-03-08 07:34:31', '2025-03-11 23:33:19'),
(70, 'testimonial.element', '{\"has_image\":\"1\",\"quote\":\"I couldn\'t be more satisfied with the results! The solution was exactly what we needed to improve our reach.\",\"name\":\"Emily Johnson\",\"designation\":\"Marketing Director, GreenLeaf Co.\",\"image\":\"67d11caadf9781741757610.png\"}', NULL, 'basic', '', '2025-03-08 07:34:58', '2025-03-11 23:33:30'),
(71, 'testimonial.element', '{\"has_image\":\"1\",\"quote\":\"An exceptional experience from start to finish. The product was delivered on time, and the quality exceeded our expectations.\",\"name\":\"Michael Williams\",\"designation\":\"Product Manager, Bright Innovations\",\"image\":\"67d11cb5b72c91741757621.png\"}', NULL, 'basic', '', '2025-03-08 07:35:27', '2025-03-11 23:33:41'),
(72, 'testimonial.element', '{\"has_image\":\"1\",\"quote\":\"Their expertise helped us streamline our processes, and we\'ve seen significant efficiency improvements.\",\"name\":\"Sarah Lee\",\"designation\":\"Operations Manager, TechZone\",\"image\":\"67d11cbc878c01741757628.png\"}', NULL, 'basic', '', '2025-03-08 07:35:53', '2025-03-11 23:33:48');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `created_at`, `updated_at`) VALUES
(73, 'testimonial.element', '{\"has_image\":\"1\",\"quote\":\"Professional, reliable, and always delivering high-quality work. We look forward to working with them again.\",\"name\":\"David Batista\",\"designation\":\"Founder, NextGen Solutions\",\"image\":\"67d11ccf2ea191741757647.png\"}', NULL, 'basic', '', '2025-03-08 07:36:19', '2025-03-11 23:34:07'),
(74, 'testimonial.element', '{\"has_image\":\"1\",\"quote\":\"Working with this team was a pleasure. They understood our needs and delivered the perfect solution tailored to our requirements.\",\"name\":\"Olivia Martinez\",\"designation\":\"Lead Designer, Visionary Designs\",\"image\":\"67d11cd7377ed1741757655.png\"}', NULL, 'basic', '', '2025-03-08 07:36:49', '2025-03-11 23:34:15'),
(75, 'api_integration.content', '{\"has_image\":\"1\",\"title\":\"API Integration\",\"heading\":\"Simple & Fast API Integration\",\"subheading\":\"Easily integrate our API into your system to enable seamless SMS functionalities, automating and managing messaging operations efficiently.\",\"button_text\":\"Get Started\",\"button_url\":\"user\\/register\",\"image\":\"67d1376ed5ad41741764462.png\"}', NULL, 'basic', '', '2025-03-08 07:53:28', '2025-03-12 01:27:43'),
(76, 'api_integration.element', '{\"title\":\"API Key\",\"description\":\"Securely authenticate and authorize access to our SMS services by using an API Key, ensuring seamless integration and functionality.\",\"has_image\":\"1\",\"icon_image\":\"67d12667c10821741760103.png\"}', NULL, 'basic', '', '2025-03-08 07:56:18', '2025-03-12 00:15:03'),
(77, 'api_integration.element', '{\"title\":\"Send SMS\",\"description\":\"Send SMS messages to individuals or groups with ease, track delivery statuses, and automate messaging campaigns.\",\"has_image\":\"1\",\"icon_image\":\"67d117eecaad41741756398.png\"}', NULL, 'basic', '', '2025-03-08 07:56:38', '2025-03-12 00:48:50'),
(78, 'api_integration.element', '{\"title\":\"Receive SMS\",\"description\":\"Receive incoming SMS messages directly into your system, capture replies, and trigger actions based on specific content.\",\"has_image\":\"1\",\"icon_image\":\"67d1265ea5e351741760094.png\"}', NULL, 'basic', '', '2025-03-08 07:57:10', '2025-03-12 00:48:43'),
(79, 'register.content', '{\"title\":\"Welcome\",\"heading\":\"Sign Up to Join Us\"}', NULL, 'basic', '', '2025-03-11 05:45:43', '2025-03-11 05:50:22'),
(80, 'brands.element', '{\"has_image\":\"1\",\"image\":\"67d12860699d11741760608.png\"}', NULL, 'basic', '', '2025-03-12 00:23:28', '2025-03-12 00:23:28'),
(81, 'brands.element', '{\"has_image\":\"1\",\"image\":\"67d128645ca511741760612.png\"}', NULL, 'basic', '', '2025-03-12 00:23:32', '2025-03-12 00:23:32'),
(82, 'brands.element', '{\"has_image\":\"1\",\"image\":\"67d128684a24b1741760616.png\"}', NULL, 'basic', '', '2025-03-12 00:23:36', '2025-03-12 00:23:36'),
(83, 'brands.element', '{\"has_image\":\"1\",\"image\":\"67d1286c4d4f81741760620.png\"}', NULL, 'basic', '', '2025-03-12 00:23:40', '2025-03-12 00:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `code` int DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `supported_currencies` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `crypto` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `image`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 101, 'Paypal', 'Paypal', '663a38d7b455d1715091671.png', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-owud61543012@business.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:21:11'),
(2, 0, 102, 'Perfect Money', 'PerfectMoney', '663a3920e30a31715091744.png', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"hR26aw02Q1eEeUPSIfuwNypXX\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:22:24'),
(3, 0, 103, 'Stripe Hosted', 'Stripe', '663a39861cb9d1715091846.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:24:06'),
(4, 0, 104, 'Skrill', 'Skrill', '663a39494c4a91715091785.png', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:23:05'),
(5, 0, 105, 'PayTM', 'Paytm', '663a390f601191715091727.png', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:22:07'),
(6, 0, 106, 'Payeer', 'Payeer', '663a38c9e2e931715091657.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}', NULL, '2019-09-14 13:14:22', '2024-05-07 08:20:57'),
(7, 0, 107, 'PayStack', 'Paystack', '663a38fc814e91715091708.png', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_cd330608eb47970889bca397ced55c1dd5ad3783\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_8a0b1f199362d7acc9c390bff72c4e81f74e2ac3\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\",\"GHS\":\"GHS\",\"KES\":\"KES\",\"ZAR\":\"ZAR\",\"XOF\":\"XOF\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n', NULL, '2019-09-14 13:14:22', '2024-05-07 08:21:48'),
(9, 0, 109, 'Flutterwave', 'Flutterwave', '663a36c2c34d61715091138.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"----------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"------------------\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:12:18'),
(10, 0, 110, 'RazorPay', 'Razorpay', '663a393a527831715091770.png', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:22:50'),
(11, 0, 111, 'Stripe Storefront', 'StripeJs', '663a3995417171715091861.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:24:21'),
(12, 0, 112, 'Instamojo', 'Instamojo', '663a384d54a111715091533.png', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:18:53'),
(13, 0, 501, 'Blockchain', 'Blockchain', '663a35efd0c311715090927.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"55529946-05ca-48ff-8710-f279d86b1cc5\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:08:47'),
(15, 0, 503, 'CoinPayments', 'Coinpayments', '663a36a8d8e1d1715091112.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"---------------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"---------------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"---------------------\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:11:52'),
(16, 0, 504, 'CoinPayments Fiat', 'CoinpaymentsFiat', '663a36b7b841a1715091127.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"6515561\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:12:07'),
(17, 0, 505, 'Coingate', 'Coingate', '663a368e753381715091086.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"6354mwVCEw5kHzRJ6thbGo-N\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:11:26'),
(18, 0, 506, 'Coinbase Commerce', 'CoinbaseCommerce', '663a367e46ae51715091070.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}', NULL, '2019-09-14 13:14:22', '2024-05-07 08:11:10'),
(24, 0, 113, 'Paypal Express', 'PaypalSdk', '663a38ed101a61715091693.png', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:21:33'),
(25, 0, 114, 'Stripe Checkout', 'StripeV3', '663a39afb519f1715091887.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"whsec_lUmit1gtxwKTveLnSe88xCSDdnPOt8g5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}', NULL, '2019-09-14 13:14:22', '2024-05-07 08:24:47'),
(27, 0, 115, 'Mollie', 'Mollie', '663a387ec69371715091582.png', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"vi@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:19:42'),
(30, 0, 116, 'Cashmaal', 'Cashmaal', '663a361b16bd11715090971.png', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.Cashmaal\"}}', NULL, NULL, '2024-05-07 08:09:31'),
(36, 0, 119, 'Mercado Pago', 'MercadoPago', '663a386c714a91715091564.png', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"APP_USR-7924565816849832-082312-21941521997fab717db925cf1ea2c190-1071840315\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\",\"ARS\":\"ARS\",\"BRL\":\"BRL\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"MXN\":\"MXN\",\"PEN\":\"PEN\",\"UYU\":\"UYU\",\"VEF\":\"VEF\",\"BOB\":\"BOB\"}', 0, NULL, NULL, NULL, '2024-05-07 08:19:24'),
(37, 0, 120, 'Authorize.net', 'Authorize', '663a35b9ca5991715090873.png', 1, '{\"login_id\":{\"title\":\"Login ID\",\"global\":true,\"value\":\"59e4P9DBcZv\"},\"transaction_key\":{\"title\":\"Transaction Key\",\"global\":true,\"value\":\"47x47TJyLw2E7DbR\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-05-07 08:07:53'),
(46, 0, 121, 'NMI', 'NMI', '663a3897754cf1715091607.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"2F822Rw39fx762MaV7Yy86jXGTC7sCDy\"}}', '{\"AED\":\"AED\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"RUB\":\"RUB\",\"SEC\":\"SEC\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2024-05-07 08:20:07'),
(50, 0, 507, 'BTCPay', 'BTCPay', '663a35cd25a8d1715090893.png', 1, '{\"store_id\":{\"title\":\"Store Id\",\"global\":true,\"value\":\"HsqFVTXSeUFJu7caoYZc3CTnP8g5LErVdHhEXPVTheHf\"},\"api_key\":{\"title\":\"Api Key\",\"global\":true,\"value\":\"4436bd706f99efae69305e7c4eff4780de1335ce\"},\"server_name\":{\"title\":\"Server Name\",\"global\":true,\"value\":\"https:\\/\\/testnet.demo.btcpayserver.org\"},\"secret_code\":{\"title\":\"Secret Code\",\"global\":true,\"value\":\"SUCdqPn9CDkY7RmJHfpQVHP2Lf2\"}}', '{\"BTC\":\"Bitcoin\",\"LTC\":\"Litecoin\"}', 1, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.BTCPay\"}}', NULL, NULL, '2024-05-07 08:08:13'),
(51, 0, 508, 'Now payments hosted', 'NowPaymentsHosted', '663a38b8d57a81715091640.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------------\"}}', '{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}', 1, '', NULL, NULL, '2024-05-07 08:20:40'),
(52, 0, 509, 'Now payments checkout', 'NowPaymentsCheckout', '663a38a59d2541715091621.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"---------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 1, '', NULL, NULL, '2024-05-07 08:20:21'),
(53, 0, 122, '2Checkout', 'TwoCheckout', '663a39b8e64b91715091896.png', 1, '{\"merchant_code\":{\"title\":\"Merchant Code\",\"global\":true,\"value\":\"253248016872\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"eQM)ID@&vG84u!O*g[p+\"}}', '{\"AFN\": \"AFN\",\"ALL\": \"ALL\",\"DZD\": \"DZD\",\"ARS\": \"ARS\",\"AUD\": \"AUD\",\"AZN\": \"AZN\",\"BSD\": \"BSD\",\"BDT\": \"BDT\",\"BBD\": \"BBD\",\"BZD\": \"BZD\",\"BMD\": \"BMD\",\"BOB\": \"BOB\",\"BWP\": \"BWP\",\"BRL\": \"BRL\",\"GBP\": \"GBP\",\"BND\": \"BND\",\"BGN\": \"BGN\",\"CAD\": \"CAD\",\"CLP\": \"CLP\",\"CNY\": \"CNY\",\"COP\": \"COP\",\"CRC\": \"CRC\",\"HRK\": \"HRK\",\"CZK\": \"CZK\",\"DKK\": \"DKK\",\"DOP\": \"DOP\",\"XCD\": \"XCD\",\"EGP\": \"EGP\",\"EUR\": \"EUR\",\"FJD\": \"FJD\",\"GTQ\": \"GTQ\",\"HKD\": \"HKD\",\"HNL\": \"HNL\",\"HUF\": \"HUF\",\"INR\": \"INR\",\"IDR\": \"IDR\",\"ILS\": \"ILS\",\"JMD\": \"JMD\",\"JPY\": \"JPY\",\"KZT\": \"KZT\",\"KES\": \"KES\",\"LAK\": \"LAK\",\"MMK\": \"MMK\",\"LBP\": \"LBP\",\"LRD\": \"LRD\",\"MOP\": \"MOP\",\"MYR\": \"MYR\",\"MVR\": \"MVR\",\"MRO\": \"MRO\",\"MUR\": \"MUR\",\"MXN\": \"MXN\",\"MAD\": \"MAD\",\"NPR\": \"NPR\",\"TWD\": \"TWD\",\"NZD\": \"NZD\",\"NIO\": \"NIO\",\"NOK\": \"NOK\",\"PKR\": \"PKR\",\"PGK\": \"PGK\",\"PEN\": \"PEN\",\"PHP\": \"PHP\",\"PLN\": \"PLN\",\"QAR\": \"QAR\",\"RON\": \"RON\",\"RUB\": \"RUB\",\"WST\": \"WST\",\"SAR\": \"SAR\",\"SCR\": \"SCR\",\"SGD\": \"SGD\",\"SBD\": \"SBD\",\"ZAR\": \"ZAR\",\"KRW\": \"KRW\",\"LKR\": \"LKR\",\"SEK\": \"SEK\",\"CHF\": \"CHF\",\"SYP\": \"SYP\",\"THB\": \"THB\",\"TOP\": \"TOP\",\"TTD\": \"TTD\",\"TRY\": \"TRY\",\"UAH\": \"UAH\",\"AED\": \"AED\",\"USD\": \"USD\",\"VUV\": \"VUV\",\"VND\": \"VND\",\"XOF\": \"XOF\",\"YER\": \"YER\"}', 0, '{\"approved_url\":{\"title\": \"Approved URL\",\"value\":\"ipn.TwoCheckout\"}}', NULL, NULL, '2024-05-07 08:24:56'),
(54, 0, 123, 'Checkout', 'Checkout', '663a3628733351715090984.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------\"},\"public_key\":{\"title\":\"PUBLIC KEY\",\"global\":true,\"value\":\"------\"},\"processing_channel_id\":{\"title\":\"PROCESSING CHANNEL\",\"global\":true,\"value\":\"------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"AUD\":\"AUD\",\"CAN\":\"CAN\",\"CHF\":\"CHF\",\"SGD\":\"SGD\",\"JPY\":\"JPY\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-05-07 08:09:44'),
(56, 0, 510, 'Binance', 'Binance', '663a35db4fd621715090907.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"tsu3tjiq0oqfbtmlbevoeraxhfbp3brejnm9txhjxcp4to29ujvakvfl1ibsn3ja\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"jzngq4t04ltw8d4iqpi7admfl8tvnpehxnmi34id1zvfaenbwwvsvw7llw3zdko8\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"231129033\"}}', '{\"BTC\":\"Bitcoin\",\"USD\":\"USD\",\"BNB\":\"BNB\"}', 1, '{\"cron\":{\"title\": \"Cron Job URL\",\"value\":\"ipn.Binance\"}}', NULL, NULL, '2024-05-07 08:08:27'),
(57, 0, 124, 'SslCommerz', 'SslCommerz', '663a397a70c571715091834.png', 1, '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"store_password\":{\"title\":\"Store Password\",\"global\":true,\"value\":\"----------\"}}', '{\"BDT\":\"BDT\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"SGD\":\"SGD\",\"INR\":\"INR\",\"MYR\":\"MYR\"}', 0, NULL, NULL, NULL, '2024-05-07 08:23:54'),
(58, 0, 125, 'Aamarpay', 'Aamarpay', '663a34d5d1dfc1715090645.png', 1, '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"signature_key\":{\"title\":\"Signature Key\",\"global\":true,\"value\":\"----------\"}}', '{\"BDT\":\"BDT\"}', 0, NULL, NULL, NULL, '2024-05-07 08:04:05'),
(60, 0, 126, 'bKash', 'BKash', '67e1432683b5a1742816038.png', 1, '{\"username\":{\"title\":\"Username\",\"global\":true,\"value\":\"01770618567\"},\"password\":{\"title\":\"Password\",\"global\":true,\"value\":\"D7DaC<*E*eG\"},\"app_key\":{\"title\":\"App Key\",\"global\":true,\"value\":\"0vWQuCRGiUX7EPVjQDr0EUAYtc\"},\"app_secret\":{\"title\":\"App Secret\",\"global\":true,\"value\":\"jcUNPBgbcqEDedNKdvE4G1cAK7D3hCjmJccNPZZBq96QIxxwAMEx\"}}', '{\"BDT\":\"BDT\"}', 0, NULL, NULL, NULL, '2025-03-15 21:58:31');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_code` int DEFAULT NULL,
  `gateway_alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `max_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `percent_charge` decimal(5,2) NOT NULL DEFAULT '0.00',
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `gateway_parameter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'email configuration',
  `sms_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `firebase_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `global_shortcodes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kv` tinyint(1) NOT NULL DEFAULT '0',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sms notification, 0 - dont send, 1 - send',
  `pn` tinyint(1) NOT NULL DEFAULT '1',
  `force_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT '0',
  `secure_password` tinyint(1) NOT NULL DEFAULT '0',
  `agree` tinyint(1) NOT NULL DEFAULT '0',
  `multi_language` tinyint(1) NOT NULL DEFAULT '1',
  `registration` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Off	, 1: On',
  `active_template` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_cron` datetime DEFAULT NULL,
  `cron_error_message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available_version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_customized` tinyint(1) NOT NULL DEFAULT '0',
  `paginate_number` int NOT NULL DEFAULT '0',
  `currency_format` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>Both\r\n2=>Text Only\r\n3=>Symbol Only',
  `config_progress` text COLLATE utf8mb4_unicode_ci,
  `batch_id_prefix` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_from_name`, `email_template`, `sms_template`, `sms_from`, `push_title`, `push_template`, `base_color`, `mail_config`, `sms_config`, `firebase_config`, `global_shortcodes`, `kv`, `ev`, `en`, `sv`, `sn`, `pn`, `force_ssl`, `maintenance_mode`, `secure_password`, `agree`, `multi_language`, `registration`, `active_template`, `last_cron`, `cron_error_message`, `available_version`, `system_customized`, `paginate_number`, `currency_format`, `config_progress`, `batch_id_prefix`, `created_at`, `updated_at`) VALUES
(1, 'CipherECC', 'USD', '$', 'info@cipherecc.com', '{{site_name}}', '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n  <!--[if !mso]><!-->\r\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n  <!--<![endif]-->\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <title></title>\r\n  <style type=\"text/css\">\r\n.ReadMsgBody { width: 100%; background-color: #ffffff; }\r\n.ExternalClass { width: 100%; background-color: #ffffff; }\r\n.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }\r\nhtml { width: 100%; }\r\nbody { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }\r\ntable { border-spacing: 0; table-layout: fixed; margin: 0 auto;border-collapse: collapse; }\r\ntable table table { table-layout: auto; }\r\n.yshortcuts a { border-bottom: none !important; }\r\nimg:hover { opacity: 0.9 !important; }\r\na { color: #0087ff; text-decoration: none; }\r\n.textbutton a { font-family: \'open sans\', arial, sans-serif !important;}\r\n.btn-link a { color:#FFFFFF !important;}\r\n\r\n@media only screen and (max-width: 480px) {\r\nbody { width: auto !important; }\r\n*[class=\"table-inner\"] { width: 90% !important; text-align: center !important; }\r\n*[class=\"table-full\"] { width: 100% !important; text-align: center !important; }\r\n/* image */\r\nimg[class=\"img1\"] { width: 100% !important; height: auto !important; }\r\n}\r\n</style>\r\n\r\n\r\n\r\n  <table bgcolor=\"#414a51\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n    <tbody><tr>\r\n      <td height=\"50\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n          <tbody><tr>\r\n            <td align=\"center\" width=\"600\">\r\n              <!--header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#0087ff\" style=\"border-top-left-radius:6px; border-top-right-radius:6px;text-align:center;vertical-align:top;font-size:0;\" align=\"center\">\r\n                    <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#FFFFFF; font-size:16px; font-weight: bold;\">This is a System Generated Email</td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n              <!--end header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"35\"></td>\r\n                      </tr>\r\n                      <!--logo-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"vertical-align:top;font-size:0;\">\r\n                          <a href=\"#\">\r\n                            <img style=\"display:block; line-height:0px; font-size:0px; border:0px;\" src=\"https://i.ibb.co/rw2fTRM/logo-dark.png\" width=\"220\" alt=\"img\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                      <!--end logo-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n                      <!--headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px;color:#414a51;font-weight: bold;\">Hello {{fullname}} ({{username}})</td>\r\n                      </tr>\r\n                      <!--end headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                          <table width=\"40\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tbody><tr>\r\n                              <td height=\"20\" style=\" border-bottom:3px solid #0087ff;\"></td>\r\n                            </tr>\r\n                          </tbody></table>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <!--content-->\r\n                      <tr>\r\n                        <td align=\"left\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#7f8c8d; font-size:16px; line-height: 28px;\">{{message}}</td>\r\n                      </tr>\r\n                      <!--end content-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n              \r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td height=\"45\" align=\"center\" bgcolor=\"#f4f4f4\" style=\"border-bottom-left-radius:6px;border-bottom-right-radius:6px;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                      <!--preference-->\r\n                      <tr>\r\n                        <td class=\"preference-link\" align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#95a5a6; font-size:14px;\">\r\n                          © 2024 <a href=\"#\">{{site_name}}</a>&nbsp;. All Rights Reserved. \r\n                        </td>\r\n                      </tr>\r\n                      <!--end preference-->\r\n                      <tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n            </td>\r\n          </tr>\r\n        </tbody></table>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td height=\"60\"></td>\r\n    </tr>\r\n  </tbody></table>', 'hi {{fullname}} ({{username}}), {{message}}', '{{site_name}}', '{{site_name}}', 'hi {{fullname}} ({{username}}), {{message}}', '4155FF', '{\"name\":\"php\"}', '{\"name\":\"clickatell\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname.com\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\"apiKey\":\"AIzaSyCb6zm7_8kdStXjZMgLZpwjGDuTUg0e_qM\",\"authDomain\":\"flutter-prime-df1c5.firebaseapp.com\",\"projectId\":\"flutter-prime-df1c5\",\"storageBucket\":\"flutter-prime-df1c5.appspot.com\",\"messagingSenderId\":\"274514992002\",\"appId\":\"1:274514992002:web:4d77660766f4797500cd9b\",\"measurementId\":\"G-KFPM07RXRC\",\"serverKey\":\"AAAA14oqxFc:APA91bE9uJdrjU_FX3gg_EtCfApRqoNojV71m6J-9yCQC7GoL2pBFcN9pdJjLLQxEAUcNxxatfWKLcnl5qCuLsmpPdr_3QRtH9XzfIu1MrLUJU3dHkBc4CGIkYMM9EWgXCNFjudhhQmH\"}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 1, 1, 'basic', '2025-02-27 09:53:21', NULL, '0', 0, 20, 1, '[\"general_setting\",\"logo_favicon\",\"notification_template\",\"deposit_method\",\"seo\",\"policy_content\",\"plan\"]', 'BTH', NULL, '2025-03-11 07:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>enable, 0=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_contacts`
--

CREATE TABLE `group_contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `group_id` int UNSIGNED NOT NULL DEFAULT '0',
  `contact_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not default language, 1: default language',
  `image` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `is_default`, `image`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '660b94fa876ac1712035066.png', '2020-07-06 03:47:55', '2024-04-01 23:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_06_14_061757_create_support_tickets_table', 3),
(5, '2020_06_14_061837_create_support_messages_table', 3),
(6, '2020_06_14_061904_create_support_attachments_table', 3),
(7, '2020_06_14_062359_create_admins_table', 3),
(8, '2020_06_14_064604_create_transactions_table', 4),
(9, '2020_06_14_065247_create_general_settings_table', 5),
(12, '2014_10_12_100000_create_password_resets_table', 6),
(13, '2020_06_14_060541_create_user_logins_table', 6),
(14, '2020_06_14_071708_create_admin_password_resets_table', 7),
(15, '2020_09_14_053026_create_countries_table', 8),
(16, '2021_03_15_084721_create_admin_notifications_table', 9),
(17, '2016_06_01_000001_create_oauth_auth_codes_table', 10),
(18, '2016_06_01_000002_create_oauth_access_tokens_table', 10),
(19, '2016_06_01_000003_create_oauth_refresh_tokens_table', 10),
(20, '2016_06_01_000004_create_oauth_clients_table', 10),
(21, '2016_06_01_000005_create_oauth_personal_access_clients_table', 10),
(22, '2021_05_08_103925_create_sms_gateways_table', 11),
(23, '2019_12_14_000001_create_personal_access_tokens_table', 12),
(24, '2021_05_23_111859_create_email_logs_table', 13),
(25, '2022_02_26_061836_create_forms_table', 14),
(26, '2023_06_15_144908_create_update_logs_table', 15),
(29, '2024_12_21_111129_create_plans_table', 16),
(30, '2024_12_24_062114_create_contacts_table', 17),
(31, '2024_12_24_062538_create_groups_table', 17),
(32, '2024_12_24_062545_create_group_contacts_table', 17),
(33, '2024_12_24_063548_create_api_keys_table', 17),
(34, '2024_12_24_063645_create_batches_table', 17),
(35, '2024_12_24_063704_create_devices_table', 17),
(36, '2024_12_24_063723_create_sms_table', 17),
(37, '2024_12_24_063749_create_sms_failed_error_codes_table', 17),
(38, '2024_12_24_064101_create_templates_table', 17),
(39, '2024_12_30_122807_create_purchase_plans_table', 18),
(40, '2025_01_06_132902_create_campaigns_table', 19),
(41, '2025_01_07_141831_create_campaign_contacts_table', 20);

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sender` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notification_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_read` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `push_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcodes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_status` tinyint(1) NOT NULL DEFAULT '1',
  `email_sent_from_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_sent_from_address` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_status` tinyint(1) NOT NULL DEFAULT '1',
  `sms_sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES
(1, 'BAL_ADD', 'Balance - Added', 'Your Account has been Credited', '{{site_name}} - Balance Added', '<div>We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.</div><div><br></div><div>Here are the details of the transaction:</div><div><br></div><div><b>Transaction Number: </b>{{trx}}</div><div><b>Current Balance:</b> {{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>If you have any questions or require further assistance, please don\'t hesitate to contact us. We\'re here to assist you.</div>', 'We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.', '{{amount}} {{site_currency}} has been successfully added to your account.', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Finance', NULL, 0, NULL, 1, '2021-11-03 12:00:00', '2025-03-11 04:37:24'),
(2, 'BAL_SUB', 'Balance - Subtracted', 'Your Account has been Debited', '{{site_name}} - Balance Subtracted', '<div>We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.</div><div><br></div><div>Below are the details of the transaction:</div><div><br></div><div><b>Transaction Number:</b> {{trx}}</div><div><b>Current Balance: </b>{{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>Should you require any further clarification or assistance, please do not hesitate to reach out to us. We are here to assist you in any way we can.</div><div><br></div><div>Thank you for your continued trust in {{site_name}}.</div>', 'We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.', '{{amount}} {{site_currency}} debited from your account.', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:17:48'),
(3, 'DEPOSIT_COMPLETE', 'Deposit - Automated - Successful', 'Deposit Completed Successfully', '{{site_name}} - Deposit successful', '<div>We\'re delighted to inform you that your deposit of {{amount}} {{site_currency}} via {{method_name}} has been completed.</div><div><br></div><div>Below, you\'ll find the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received:</b> {{method_amount}} {{method_currency}}</div><div><b>Paid via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Your current balance stands at {{post_balance}} {{site_currency}}.</div><div><br></div><div>If you have any questions or need further assistance, feel free to reach out to our support team. We\'re here to assist you in any way we can.</div>', 'We\'re delighted to inform you that your deposit of {{amount}} {{site_currency}} via {{method_name}} has been completed.', 'Deposit Completed Successfully', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 1, '2021-11-03 12:00:00', '2024-05-08 07:20:34'),
(4, 'DEPOSIT_APPROVE', 'Deposit - Manual - Approved', 'Deposit Request Approved', '{{site_name}} - Deposit Request Approved', '<div>We are pleased to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been approved.</div><div><br></div><div>Here are the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received: </b>{{method_amount}} {{method_currency}}</div><div><b>Paid via: </b>{{method_name}}</div><div><b>Transaction Number: </b>{{trx}}</div><div><br></div><div>Your current balance now stands at {{post_balance}} {{site_currency}}.</div><div><br></div><div>Should you have any questions or require further assistance, please feel free to contact our support team. We\'re here to help.</div>', 'We are pleased to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been approved.', 'Deposit of {{amount}} {{site_currency}} via {{method_name}} has been approved.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:19:49'),
(5, 'DEPOSIT_REJECT', 'Deposit - Manual - Rejected', 'Deposit Request Rejected', '{{site_name}} - Deposit Request Rejected', '<div>We regret to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.</div><div><br></div><div>Here are the details of the rejected deposit:</div><div><br></div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received:</b> {{method_amount}} {{method_currency}}</div><div><b>Paid via:</b> {{method_name}}</div><div><b>Charge:</b> {{charge}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>If you have any questions or need further clarification, please don\'t hesitate to contact us. We\'re here to assist you.</div><div><br></div><div>Rejection Reason:</div><div>{{rejection_message}}</div><div><br></div><div>Thank you for your understanding.</div>', 'We regret to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', 'Your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:20:13'),
(6, 'DEPOSIT_REQUEST', 'Deposit - Manual - Requested', 'Deposit Request Submitted Successfully', NULL, '<div>We are pleased to confirm that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.</div><div><br></div><div>Below are the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Payable:</b> {{method_amount}} {{method_currency}}</div><div><b>Pay via: </b>{{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Should you have any questions or require further assistance, please feel free to reach out to our support team. We\'re here to assist you.</div>', 'We are pleased to confirm that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.', 'Your deposit request of {{amount}} {{site_currency}} via {{method_name}} submitted successfully.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:42'),
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', '{{site_name}} Password Reset Code', '<div>We\'ve received a request to reset the password for your account on <b>{{time}}</b>. The request originated from\r\n            the following IP address: <b>{{ip}}</b>, using <b>{{browser}}</b> on <b>{{operating_system}}</b>.\r\n    </div><br>\r\n    <div><span>To proceed with the password reset, please use the following account recovery code</span>: <span><b><font size=\"6\">{{code}}</font></b></span></div><br>\r\n    <div><span>If you did not initiate this password reset request, please disregard this message. Your account security\r\n            remains our top priority, and we advise you to take appropriate action if you suspect any unauthorized\r\n            access to your account.</span></div>', 'To proceed with the password reset, please use the following account recovery code: {{code}}', 'To proceed with the password reset, please use the following account recovery code: {{code}}', '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, '{{site_name}} Authentication Center', NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:24:57'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'Password Reset Successful', NULL, '<div><div><span>We are writing to inform you that the password reset for your account was successful. This action was completed at {{time}} from the following browser</span>: <span>{{browser}}</span><span>on {{operating_system}}, with the IP address</span>: <span>{{ip}}</span>.</div><br><div><span>Your account security is our utmost priority, and we are committed to ensuring the safety of your information. If you did not initiate this password reset or notice any suspicious activity on your account, please contact our support team immediately for further assistance.</span></div></div>', 'We are writing to inform you that the password reset for your account was successful.', 'We are writing to inform you that the password reset for your account was successful.', '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, '{{site_name}} Authentication Center', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:24'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Re: {{ticket_subject}} - Ticket #{{ticket_id}}', '{{site_name}} - Support Ticket Replied', '<div>\r\n    <div><span>Thank you for reaching out to us regarding your support ticket with the subject</span>:\r\n        <span>\"{{ticket_subject}}\"&nbsp;</span><span>and ticket ID</span>: {{ticket_id}}.</div><br>\r\n    <div><span>We have carefully reviewed your inquiry, and we are pleased to provide you with the following\r\n            response</span><span>:</span></div><br>\r\n    <div>{{reply}}</div><br>\r\n    <div><span>If you have any further questions or need additional assistance, please feel free to reply by clicking on\r\n            the following link</span>: <a href=\"{{link}}\" title=\"\" target=\"_blank\">{{link}}</a><span>. This link will take you to\r\n            the ticket thread where you can provide further information or ask for clarification.</span></div><br>\r\n    <div><span>Thank you for your patience and cooperation as we worked to address your concerns.</span></div>\r\n</div>', 'Thank you for reaching out to us regarding your support ticket with the subject: \"{{ticket_subject}}\" and ticket ID: {{ticket_id}}. We have carefully reviewed your inquiry. To check the response, please go to the following link: {{link}}', 'Re: {{ticket_subject}} - Ticket #{{ticket_id}}', '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, '{{site_name}} Support Team', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:06'),
(10, 'EVER_CODE', 'Verification - Email', 'Email Verification Code', NULL, '<div>\r\n    <div><span>Thank you for taking the time to verify your email address with us. Your email verification code\r\n            is</span>: <b><font size=\"6\">{{code}}</font></b></div><br>\r\n    <div><span>Please enter this code in the designated field on our platform to complete the verification\r\n            process.</span></div><br>\r\n    <div><span>If you did not request this verification code, please disregard this email. Your account security is our\r\n            top priority, and we advise you to take appropriate measures if you suspect any unauthorized access.</span>\r\n    </div><br>\r\n    <div><span>If you have any questions or encounter any issues during the verification process, please don\'t hesitate\r\n            to contact our support team for assistance.</span></div><br>\r\n    <div><span>Thank you for choosing us.</span></div>\r\n</div>', '---', '---', '{\"code\":\"Email verification code\"}', 1, '{{site_name}} Verification Center', NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:12'),
(11, 'SVER_CODE', 'Verification - SMS', 'Verify Your Mobile Number', NULL, '---', 'Your mobile verification code is {{code}}. Please enter this code in the appropriate field to verify your mobile number. If you did not request this code, please ignore this message.', '---', '{\"code\":\"SMS Verification Code\"}', 0, '{{site_name}} Verification Center', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:03'),
(12, 'WITHDRAW_APPROVE', 'Withdraw - Approved', 'Withdrawal Confirmation: Your Request Processed Successfully', '{{site_name}} - Withdrawal Request Approved', '<div>We are writing to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been processed successfully.</div><div><br></div><div>Below are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>You will receive:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><hr><div><br></div><div><b>Details of Processed Payment:</b></div><div>{{admin_details}}</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>', 'We are writing to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been processed successfully.', 'Withdrawal Confirmation: Your Request Processed Successfully', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:37'),
(13, 'WITHDRAW_REJECT', 'Withdraw - Rejected', 'Withdrawal Request Rejected', '{{site_name}} - Withdrawal Request Rejected', '<div>We regret to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.</div><div><br></div><div>Here are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Expected Amount:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><hr><div><br></div><div><b>Refund Details:</b></div><div>{{amount}} {{site_currency}} has been refunded to your account, and your current balance is {{post_balance}} {{site_currency}}.</div><div><br></div><hr><div><br></div><div><b>Reason for Rejection:</b></div><div>{{admin_details}}</div><div><br></div><div>If you have any questions or concerns regarding this rejection or need further assistance, please do not hesitate to contact our support team. We apologize for any inconvenience this may have caused.</div>', 'We regret to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', 'Withdrawal Request Rejected', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"admin_details\":\"Rejection message by the admin\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:55'),
(14, 'WITHDRAW_REQUEST', 'Withdraw - Requested', 'Withdrawal Request Confirmation', '{{site_name}} - Requested for withdrawal', '<div>We are pleased to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.</div><div><br></div><div>Here are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Expected Amount:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Your current balance is {{post_balance}} {{site_currency}}.</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>', 'We are pleased to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.', 'Withdrawal request submitted successfully', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:27:20'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', '{{subject}}', '{{message}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, NULL, NULL, 1, NULL, 1, '2019-09-14 13:14:22', '2024-05-16 01:32:53'),
(18, 'PLAN_PURCHASE', 'Plan Purchase', 'Plan purchase successfully', '{{site_name}} - Plan purchase successfully', '<p>We are pleased to inform you that your request to purchase the<strong>&nbsp;</strong><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align);\">{{plan_name}}</span><strong style=\"font-size: 0.875rem; background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align);\">&nbsp;</strong><span style=\"font-size: 0.875rem; background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align);\">has been successfully processed. Your account balance is</span><strong style=\"font-size: 0.875rem; background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align);\"> </strong><span style=\"font-size: 0.875rem; background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align);\">{{post_balance}}</span></p><p><strong>Plan Details:</strong></p><p>Trx<strong>:&nbsp;</strong><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align);\">{{trx}}</span></p><ul><li>Name<span style=\"font-weight: bolder;\">:</span>&nbsp;&nbsp;{{plan_name}}<br></li></ul><ul><li>Price<strong>:</strong>&nbsp;&nbsp;{{amount}}</li><li>Recurring Type<strong>:</strong>&nbsp;{{plan_recurring_type}}</li><li>Payment Method<strong>:</strong> {{method_name}}</li></ul>', 'We are pleased to inform you that your request to purchase a plan if successful', 'We are pleased to inform you that your request to purchase a plan if successful', '{ \"trx\": \"Transaction number for the deposit\", \"plan_name\": \"Plan of the user for the deposit\", \"plan_recurring_type\" : \"Recurring type of the plan\", \"amount\": \"Amount inserted by the user\", \"method_name\": \"Name of the deposit method\", \"method_currency\": \"Currency of the deposit method\", \"post_balance\": \"Balance of the user after this transaction\" }', 1, '{{site_name}} Billing', NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2025-01-01 07:37:17'),
(19, 'PLAN_EXPIRED', 'Plan Expired', 'Plan expired', '{{site_name}} - Your plan has been expired.', '<p>Dear {{username}}, we are pleased to inform you that your plan<span style=\"margin-top: 0px; margin-right: 0px; margin-left: 0px; padding: 0px;\">&nbsp;</span><span style=\"font-size: 0.875rem; background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align);\">has been expired.&nbsp;</span><span style=\"color: var(--bs-card-color); background-color: var(--bs-card-bg); font-size: 1rem; text-align: var(--bs-body-text-align);\">Please renew your plan to continue enjoying our services</span></p>', 'Dear {{username}}, your current plan has been expired. Please renew your plan to continue enjoying our services.', 'Dear {{username}}, your current plan has been expired. Please renew your plan to continue enjoying our services.', '{ \"username\": \"Plan of the user for the deposit\", \"plan_name\": \"Plan name\" }', 1, '{{site_name}} Support', NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2025-02-05 13:22:31');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `seo_content`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', '/', 'templates.basic.', '[\"service\",\"about\",\"feature\",\"how_it_works\",\"api_integration\",\"plan\",\"faq\",\"testimonial\",\"blog\",\"cta\",\"brands\",\"subscribe\"]', NULL, 1, '2020-07-11 06:23:58', '2025-03-08 08:24:43'),
(4, 'Blog', 'blog', 'templates.basic.', '[\"service\",\"cta\",\"subscribe\"]', NULL, 1, '2020-10-22 01:14:43', '2025-03-12 02:11:26'),
(5, 'Contact', 'contact', 'templates.basic.', '[\"subscribe\"]', NULL, 1, '2020-10-22 01:14:53', '2024-12-19 07:20:38'),
(27, 'Pricing', 'pricing', 'templates.basic.', '[\"about\",\"feature\",\"subscribe\"]', NULL, 1, '2024-12-31 03:51:07', '2025-03-12 02:10:39'),
(28, 'About', 'about', 'templates.basic.', '[\"about\",\"service\",\"faq\",\"feature\",\"subscribe\"]', NULL, 0, '2025-01-11 09:07:07', '2025-03-12 02:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `device_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `image` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recurring_type` tinyint NOT NULL DEFAULT '1',
  `sms_limit` int NOT NULL DEFAULT '0',
  `device_limit` int NOT NULL DEFAULT '0',
  `api_available` tinyint NOT NULL DEFAULT '0',
  `daily_sms_limit` int NOT NULL DEFAULT '0',
  `contact_limit` int NOT NULL DEFAULT '0',
  `group_limit` int NOT NULL DEFAULT '0',
  `scheduled_sms` tinyint NOT NULL DEFAULT '0',
  `campaign` tinyint NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_plans`
--

CREATE TABLE `purchase_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `plan_id` int UNSIGNED NOT NULL DEFAULT '0',
  `price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `payment_type` tinyint NOT NULL DEFAULT '1' COMMENT '1=>wallet, 2=>gateway',
  `method_code` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>enable, 0=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `campaign_id` int UNSIGNED NOT NULL DEFAULT '0',
  `api_key_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `device_slot_number` int NOT NULL DEFAULT '0',
  `device_id` int UNSIGNED NOT NULL DEFAULT '0',
  `device_slot_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=initial, 1=>delivered, 2=>pending, 3=>scheduled, 4=>processing, 9=>failed',
  `sms_type` tinyint NOT NULL DEFAULT '1' COMMENT '1=>send, 2=>received',
  `batch_id` int UNSIGNED NOT NULL DEFAULT '0',
  `et` tinyint NOT NULL DEFAULT '0',
  `error_code` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_failed_error_codes`
--

CREATE TABLE `sms_failed_error_codes` (
  `id` bigint UNSIGNED NOT NULL,
  `code` int NOT NULL,
  `error_keyword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `error_explanation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_failed_error_codes`
--

INSERT INTO `sms_failed_error_codes` (`id`, `code`, `error_keyword`, `error_explanation`) VALUES
(1, 1, 'RESULT_ERROR_GENERIC_FAILURE', 'Something went wrong and there\'s no way to tell what, why or how.'),
(2, 2, 'RESULT_ERROR_RADIO_OFF', 'You switched your device into airplane mode, which tells your device exactly \"turn all radios off\" (cell, wifi, Bluetooth, NFC, ...).'),
(3, 3, 'RESULT_ERROR_NULL_PDU', 'Failed because no pdu provided'),
(4, 4, 'RESULT_ERROR_NO_SERVICE', 'Failed because service is currently unavailable'),
(5, 5, 'RESULT_ERROR_LIMIT_EXCEEDED', 'Failed because we reached the sending queue limit.'),
(6, 6, 'RESULT_ERROR_FDN_CHECK_FAILURE', 'Failed because FDN is enabled.'),
(7, 7, 'RESULT_ERROR_SHORT_CODE_NOT_ALLOWED', 'Failed because user denied the sending of this short code.'),
(8, 8, 'RESULT_ERROR_SHORT_CODE_NEVER_ALLOWED', 'Failed because the user has denied this app ever send premium short codes.'),
(9, 9, 'RESULT_RADIO_NOT_AVAILABLE', 'Failed because the radio was not available'),
(10, 10, 'RESULT_NETWORK_REJECT', 'Failed because of network rejection'),
(11, 11, 'RESULT_INVALID_ARGUMENTS', 'Failed because of invalid arguments'),
(12, 12, 'RESULT_INVALID_STATE', 'Failed because of an invalid state'),
(13, 13, 'RESULT_NO_MEMORY', 'Failed because there is no memory'),
(14, 14, 'RESULT_INVALID_SMS_FORMAT', 'Failed because the sms format is not valid'),
(15, 15, 'RESULT_SYSTEM_ERROR', 'Failed because of a system error'),
(16, 16, 'RESULT_MODEM_ERROR', 'Failed because of a modem error'),
(17, 17, 'RESULT_NETWORK_ERROR', 'Failed because of a network error'),
(18, 18, 'RESULT_ENCODING_ERROR', 'Failed because of an encoding error'),
(19, 19, 'RESULT_INVALID_SMSC_ADDRESS', 'Failed because of an invalid smsc address'),
(20, 20, 'RESULT_OPERATION_NOT_ALLOWED', 'Failed because the operation is not allowed'),
(21, 21, 'RESULT_INTERNAL_ERROR', 'Failed because of an internal error'),
(22, 22, 'RESULT_NO_RESOURCES', 'Failed because there are no resources'),
(23, 23, 'RESULT_CANCELLED', 'Failed because the operation was cancelled'),
(24, 24, 'RESULT_REQUEST_NOT_SUPPORTED', 'Failed because the request is not supported'),
(25, 28, 'RESULT_UNEXPECTED_EVENT_STOP_SENDING', 'Failed sending because the user denied or canceled the dialog displayed for a premium shortcode sms or rate-limited sms.'),
(26, 29, 'RESULT_SMS_BLOCKED_DURING_EMERGENCY', 'Failed sending during an emergency call'),
(27, 30, 'RESULT_SMS_SEND_RETRY_FAILED', 'Failed to send an sms retry'),
(28, 31, 'RESULT_REMOTE_EXCEPTION', 'Set by BroadcastReceiver to indicate a remote exception while handling a message.'),
(29, 32, 'RESULT_NO_DEFAULT_SMS_APP', 'Set by BroadcastReceiver to indicate there\'s no default sms app.'),
(30, 100, 'RESULT_RIL_RADIO_NOT_AVAILABLE', 'The radio did not start or is resetting.'),
(31, 101, 'RESULT_RIL_SMS_SEND_FAIL_RETRY', 'The radio failed to send the sms and needs to retry.'),
(32, 102, 'RESULT_RIL_NETWORK_REJECT', 'The sms request was rejected by the network.'),
(33, 103, 'RESULT_RIL_INVALID_STATE', 'The radio returned an unexpected request for the current state.'),
(34, 104, 'RESULT_RIL_INVALID_ARGUMENTS', 'The radio received invalid arguments in the request.'),
(35, 105, 'RESULT_RIL_NO_MEMORY', 'The radio didn\'t have sufficient memory to process the request.'),
(36, 106, 'RESULT_RIL_REQUEST_RATE_LIMITED', 'The radio denied the operation due to overly-frequent requests.'),
(37, 107, 'RESULT_RIL_INVALID_SMS_FORMAT', 'The radio returned an error indicating invalid sms format.'),
(38, 108, 'RESULT_RIL_SYSTEM_ERR', 'The radio encountered a platform or system error.'),
(39, 109, 'RESULT_RIL_ENCODING_ERR', 'The SMS message was not encoded properly.'),
(40, 110, 'RESULT_RIL_INVALID_SMSC_ADDRESS', 'The specified SMSC address was invalid.'),
(41, 111, 'RESULT_RIL_MODEM_ERR', 'The vendor RIL received an unexpected or incorrect response.'),
(42, 112, 'RESULT_RIL_NETWORK_ERR', 'The radio received an error from the network.'),
(43, 113, 'RESULT_RIL_INTERNAL_ERR', 'The modem encountered an unexpected error scenario while handling the request.'),
(44, 114, 'RESULT_RIL_REQUEST_NOT_SUPPORTED', 'The request was not supported by the radio.'),
(45, 115, 'RESULT_RIL_INVALID_MODEM_STATE', 'The radio cannot process the request in the current modem state.'),
(46, 116, 'RESULT_RIL_NETWORK_NOT_READY', 'The network is not ready to perform the request.'),
(47, 117, 'RESULT_RIL_OPERATION_NOT_ALLOWED', 'The radio reports the request is not allowed.'),
(48, 118, 'RESULT_RIL_NO_RESOURCES', 'There are insufficient resources to process the request.'),
(49, 119, 'RESULT_RIL_CANCELLED', 'The request has been cancelled.'),
(50, 120, 'RESULT_RIL_SIM_ABSENT', 'The radio failed to set the location where the CDMA subscription can be retrieved because the SIM or RUIM is absent.'),
(51, 121, 'RESULT_RIL_SIMULTANEOUS_SMS_AND_CALL_NOT_ALLOWED', '1X voice and SMS are not allowed simulteneously.'),
(52, 122, 'RESULT_RIL_ACCESS_BARRED', 'Access is barred.'),
(53, 123, 'RESULT_RIL_BLOCKED_DUE_TO_CALL', 'SMS is blocked due to call control, e.g., resource unavailable in the SMR entity.'),
(54, 500, 'RESULT_RECEIVE_DISPATCH_FAILURE', 'SMS receive dispatch failure.'),
(55, 501, 'RESULT_RECEIVE_INJECTED_NULL_PDU', 'SMS receive injected null PDU.'),
(56, 502, 'RESULT_RECEIVE_RUNTIME_EXCEPTION', 'SMS receive encountered runtime exception.'),
(57, 503, 'RESULT_RECEIVE_NULL_MESSAGE_FROM_RIL', 'SMS received null message from the radio interface layer.'),
(58, 504, 'RESULT_RECEIVE_WHILE_ENCRYPTED', 'SMS short code received while the phone is in encrypted state.'),
(59, 505, 'RESULT_RECEIVE_SQL_EXCEPTION', 'SMS receive encountered an SQL exception.'),
(60, 506, 'RESULT_RECEIVE_URI_EXCEPTION', 'SMS receive an exception parsing a uri.');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `support_message_id` int UNSIGNED NOT NULL DEFAULT '0',
  `attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `support_ticket_id` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT '0',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `post_balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `update_logs`
--

CREATE TABLE `update_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dial_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int UNSIGNED NOT NULL DEFAULT '0',
  `balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: banned, 1: active',
  `plan_id` int UNSIGNED NOT NULL DEFAULT '0',
  `available_sms` int NOT NULL DEFAULT '0' COMMENT 'total sms user has',
  `plan_api_available` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Active plan api status',
  `plan_scheduled_sms` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Active plan scheduled sms status',
  `available_device_limit` int NOT NULL DEFAULT '0' COMMENT 'total device limit left',
  `available_group_limit` int NOT NULL DEFAULT '0' COMMENT 'total group limit left',
  `available_contact_limit` int NOT NULL DEFAULT '0' COMMENT 'total contact limit',
  `daily_sms_limit` int NOT NULL DEFAULT '0' COMMENT 'active plan daily sms limit',
  `plan_campaign_available` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Active plan campaign available status',
  `plan_expires_at` timestamp NULL DEFAULT NULL,
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT '0',
  `ver_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `tsc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_ip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_contacts`
--
ALTER TABLE `campaign_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_contacts`
--
ALTER TABLE `group_contacts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_plans`
--
ALTER TABLE `purchase_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_failed_error_codes`
--
ALTER TABLE `sms_failed_error_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_logs`
--
ALTER TABLE `update_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign_contacts`
--
ALTER TABLE `campaign_contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_contacts`
--
ALTER TABLE `group_contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_plans`
--
ALTER TABLE `purchase_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_failed_error_codes`
--
ALTER TABLE `sms_failed_error_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `update_logs`
--
ALTER TABLE `update_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
