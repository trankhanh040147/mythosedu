-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2023 at 03:38 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_actionscheduler_actions`
--

DROP TABLE IF EXISTS `wp_actionscheduler_actions`;
CREATE TABLE `wp_actionscheduler_actions` (
  `action_id` bigint(20) UNSIGNED NOT NULL,
  `hook` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scheduled_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `scheduled_date_local` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `args` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `last_attempt_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_attempt_local` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `claim_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `extended_args` varchar(8000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_actionscheduler_actions`
--

INSERT INTO `wp_actionscheduler_actions` (`action_id`, `hook`, `status`, `scheduled_date_gmt`, `scheduled_date_local`, `args`, `schedule`, `group_id`, `attempts`, `last_attempt_gmt`, `last_attempt_local`, `claim_id`, `extended_args`) VALUES
(250, 'facebook_for_woocommerce_hourly_heartbeat', 'complete', '2023-11-28 15:25:24', '2023-11-28 15:25:24', '[]', 'O:30:\"ActionScheduler_SimpleSchedule\":2:{s:22:\"\0*\0scheduled_timestamp\";i:1701185124;s:41:\"\0ActionScheduler_SimpleSchedule\0timestamp\";i:1701185124;}', 0, 1, '2023-11-28 15:25:46', '2023-11-28 15:25:46', 0, NULL),
(251, 'facebook_for_woocommerce_daily_heartbeat', 'complete', '2023-11-28 15:25:40', '2023-11-28 15:25:40', '[]', 'O:30:\"ActionScheduler_SimpleSchedule\":2:{s:22:\"\0*\0scheduled_timestamp\";i:1701185140;s:41:\"\0ActionScheduler_SimpleSchedule\0timestamp\";i:1701185140;}', 0, 1, '2023-11-28 15:25:46', '2023-11-28 15:25:46', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wp_actionscheduler_claims`
--

DROP TABLE IF EXISTS `wp_actionscheduler_claims`;
CREATE TABLE `wp_actionscheduler_claims` (
  `claim_id` bigint(20) UNSIGNED NOT NULL,
  `date_created_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_actionscheduler_groups`
--

DROP TABLE IF EXISTS `wp_actionscheduler_groups`;
CREATE TABLE `wp_actionscheduler_groups` (
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_actionscheduler_logs`
--

DROP TABLE IF EXISTS `wp_actionscheduler_logs`;
CREATE TABLE `wp_actionscheduler_logs` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `action_id` bigint(20) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `log_date_local` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_actionscheduler_logs`
--

INSERT INTO `wp_actionscheduler_logs` (`log_id`, `action_id`, `message`, `log_date_gmt`, `log_date_local`) VALUES
(538, 250, 'action created', '2023-11-28 15:25:24', '2023-11-28 15:25:24'),
(539, 251, 'action created', '2023-11-28 15:25:40', '2023-11-28 15:25:40'),
(540, 250, 'action started via Async Request', '2023-11-28 15:25:46', '2023-11-28 15:25:46'),
(541, 250, 'action complete via Async Request', '2023-11-28 15:25:46', '2023-11-28 15:25:46'),
(542, 251, 'action started via Async Request', '2023-11-28 15:25:46', '2023-11-28 15:25:46'),
(543, 251, 'action complete via Async Request', '2023-11-28 15:25:46', '2023-11-28 15:25:46');

-- --------------------------------------------------------

--
-- Table structure for table `wp_commentmeta`
--

DROP TABLE IF EXISTS `wp_commentmeta`;
CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT 0,
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_comments`
--

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'Một người bình luận WordPress', 'wapuu@wordpress.example', 'http://wordpress.org/', '', '2022-07-01 02:30:09', '2022-07-01 02:30:09', 'Xin chào, đây là một bình luận\nĐể bắt đầu với quản trị bình luận, chỉnh sửa hoặc xóa bình luận, vui lòng truy cập vào khu vực Bình luận trong trang quản trị.\nAvatar của người bình luận sử dụng <a href=\"http://gravatar.com\">Gravatar</a>.', 0, '1', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
CREATE TABLE `wp_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `link_rating` int(11) NOT NULL DEFAULT 0,
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
CREATE TABLE `wp_options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://mythosedu.com', 'yes'),
(2, 'home', 'http://mythosedu.com', 'yes'),
(3, 'blogname', 'Khóa học Online', 'yes'),
(4, 'blogdescription', 'COURSES', 'yes'),
(5, 'users_can_register', '1', 'yes'),
(6, 'admin_email', 'heckmanle@gmail.com', 'yes'),
(7, 'start_of_week', '1', 'yes'),
(8, 'use_balanceTags', '0', 'yes'),
(9, 'use_smilies', '1', 'yes'),
(10, 'require_name_email', '1', 'yes'),
(11, 'comments_notify', '1', 'yes'),
(12, 'posts_per_rss', '20', 'yes'),
(13, 'rss_use_excerpt', '0', 'yes'),
(14, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 'mailserver_login', 'login@example.com', 'yes'),
(16, 'mailserver_pass', 'password', 'yes'),
(17, 'mailserver_port', '110', 'yes'),
(18, 'default_category', '1', 'yes'),
(19, 'default_comment_status', 'open', 'yes'),
(20, 'default_ping_status', 'open', 'yes'),
(21, 'default_pingback_flag', '1', 'yes'),
(22, 'posts_per_page', '20', 'yes'),
(23, 'date_format', 'j F, Y', 'yes'),
(24, 'time_format', 'g:i a', 'yes'),
(25, 'links_updated_date_format', 'j F, Y g:i a', 'yes'),
(26, 'comment_moderation', '0', 'yes'),
(27, 'moderation_notify', '1', 'yes'),
(28, 'permalink_structure', '/%postname%/', 'yes'),
(29, 'rewrite_rules', 'a:324:{s:29:\"courses/(.+?)/lesson/(.+?)/?$\";s:43:\"index.php?post_type=lesson&name=$matches[2]\";s:33:\"courses/(.+?)/tutor_quiz/(.+?)/?$\";s:47:\"index.php?post_type=tutor_quiz&name=$matches[2]\";s:34:\"courses/(.+?)/assignments/(.+?)/?$\";s:54:\"index.php?post_type=tutor_assignments&name=$matches[2]\";s:35:\"courses/(.+?)/zoom-meeting/(.+?)/?$\";s:55:\"index.php?post_type=tutor_zoom_meeting&name=$matches[2]\";s:18:\"video-url/(.+?)/?$\";s:61:\"index.php?post_type=lesson&lesson_video=true&name=$matches[1]\";s:16:\"profile/(.+?)/?$\";s:44:\"index.php?tutor_profile_username=$matches[1]\";s:20:\"(dashboard)/index/?$\";s:57:\"index.php?pagename=$matches[1]&tutor_dashboard_page=index\";s:26:\"(dashboard)/index/(.+?)/?$\";s:94:\"index.php?pagename=$matches[1]&tutor_dashboard_page=index&tutor_dashboard_sub_page=$matches[2]\";s:25:\"(dashboard)/my-profile/?$\";s:62:\"index.php?pagename=$matches[1]&tutor_dashboard_page=my-profile\";s:31:\"(dashboard)/my-profile/(.+?)/?$\";s:99:\"index.php?pagename=$matches[1]&tutor_dashboard_page=my-profile&tutor_dashboard_sub_page=$matches[2]\";s:31:\"(dashboard)/enrolled-courses/?$\";s:68:\"index.php?pagename=$matches[1]&tutor_dashboard_page=enrolled-courses\";s:37:\"(dashboard)/enrolled-courses/(.+?)/?$\";s:105:\"index.php?pagename=$matches[1]&tutor_dashboard_page=enrolled-courses&tutor_dashboard_sub_page=$matches[2]\";s:23:\"(dashboard)/wishlist/?$\";s:60:\"index.php?pagename=$matches[1]&tutor_dashboard_page=wishlist\";s:29:\"(dashboard)/wishlist/(.+?)/?$\";s:97:\"index.php?pagename=$matches[1]&tutor_dashboard_page=wishlist&tutor_dashboard_sub_page=$matches[2]\";s:22:\"(dashboard)/reviews/?$\";s:59:\"index.php?pagename=$matches[1]&tutor_dashboard_page=reviews\";s:28:\"(dashboard)/reviews/(.+?)/?$\";s:96:\"index.php?pagename=$matches[1]&tutor_dashboard_page=reviews&tutor_dashboard_sub_page=$matches[2]\";s:31:\"(dashboard)/my-quiz-attempts/?$\";s:68:\"index.php?pagename=$matches[1]&tutor_dashboard_page=my-quiz-attempts\";s:37:\"(dashboard)/my-quiz-attempts/(.+?)/?$\";s:105:\"index.php?pagename=$matches[1]&tutor_dashboard_page=my-quiz-attempts&tutor_dashboard_sub_page=$matches[2]\";s:31:\"(dashboard)/purchase_history/?$\";s:68:\"index.php?pagename=$matches[1]&tutor_dashboard_page=purchase_history\";s:37:\"(dashboard)/purchase_history/(.+?)/?$\";s:105:\"index.php?pagename=$matches[1]&tutor_dashboard_page=purchase_history&tutor_dashboard_sub_page=$matches[2]\";s:30:\"(dashboard)/question-answer/?$\";s:67:\"index.php?pagename=$matches[1]&tutor_dashboard_page=question-answer\";s:36:\"(dashboard)/question-answer/(.+?)/?$\";s:104:\"index.php?pagename=$matches[1]&tutor_dashboard_page=question-answer&tutor_dashboard_sub_page=$matches[2]\";s:23:\"(dashboard)/calendar/?$\";s:60:\"index.php?pagename=$matches[1]&tutor_dashboard_page=calendar\";s:29:\"(dashboard)/calendar/(.+?)/?$\";s:97:\"index.php?pagename=$matches[1]&tutor_dashboard_page=calendar&tutor_dashboard_sub_page=$matches[2]\";s:26:\"(dashboard)/separator-1/?$\";s:63:\"index.php?pagename=$matches[1]&tutor_dashboard_page=separator-1\";s:32:\"(dashboard)/separator-1/(.+?)/?$\";s:100:\"index.php?pagename=$matches[1]&tutor_dashboard_page=separator-1&tutor_dashboard_sub_page=$matches[2]\";s:28:\"(dashboard)/create-course/?$\";s:65:\"index.php?pagename=$matches[1]&tutor_dashboard_page=create-course\";s:34:\"(dashboard)/create-course/(.+?)/?$\";s:102:\"index.php?pagename=$matches[1]&tutor_dashboard_page=create-course&tutor_dashboard_sub_page=$matches[2]\";s:25:\"(dashboard)/my-courses/?$\";s:62:\"index.php?pagename=$matches[1]&tutor_dashboard_page=my-courses\";s:31:\"(dashboard)/my-courses/(.+?)/?$\";s:99:\"index.php?pagename=$matches[1]&tutor_dashboard_page=my-courses&tutor_dashboard_sub_page=$matches[2]\";s:28:\"(dashboard)/announcements/?$\";s:65:\"index.php?pagename=$matches[1]&tutor_dashboard_page=announcements\";s:34:\"(dashboard)/announcements/(.+?)/?$\";s:102:\"index.php?pagename=$matches[1]&tutor_dashboard_page=announcements&tutor_dashboard_sub_page=$matches[2]\";s:23:\"(dashboard)/withdraw/?$\";s:60:\"index.php?pagename=$matches[1]&tutor_dashboard_page=withdraw\";s:29:\"(dashboard)/withdraw/(.+?)/?$\";s:97:\"index.php?pagename=$matches[1]&tutor_dashboard_page=withdraw&tutor_dashboard_sub_page=$matches[2]\";s:28:\"(dashboard)/quiz-attempts/?$\";s:65:\"index.php?pagename=$matches[1]&tutor_dashboard_page=quiz-attempts\";s:34:\"(dashboard)/quiz-attempts/(.+?)/?$\";s:102:\"index.php?pagename=$matches[1]&tutor_dashboard_page=quiz-attempts&tutor_dashboard_sub_page=$matches[2]\";s:26:\"(dashboard)/assignments/?$\";s:63:\"index.php?pagename=$matches[1]&tutor_dashboard_page=assignments\";s:32:\"(dashboard)/assignments/(.+?)/?$\";s:100:\"index.php?pagename=$matches[1]&tutor_dashboard_page=assignments&tutor_dashboard_sub_page=$matches[2]\";s:24:\"(dashboard)/analytics/?$\";s:61:\"index.php?pagename=$matches[1]&tutor_dashboard_page=analytics\";s:30:\"(dashboard)/analytics/(.+?)/?$\";s:98:\"index.php?pagename=$matches[1]&tutor_dashboard_page=analytics&tutor_dashboard_sub_page=$matches[2]\";s:26:\"(dashboard)/separator-2/?$\";s:63:\"index.php?pagename=$matches[1]&tutor_dashboard_page=separator-2\";s:32:\"(dashboard)/separator-2/(.+?)/?$\";s:100:\"index.php?pagename=$matches[1]&tutor_dashboard_page=separator-2&tutor_dashboard_sub_page=$matches[2]\";s:23:\"(dashboard)/settings/?$\";s:60:\"index.php?pagename=$matches[1]&tutor_dashboard_page=settings\";s:29:\"(dashboard)/settings/(.+?)/?$\";s:97:\"index.php?pagename=$matches[1]&tutor_dashboard_page=settings&tutor_dashboard_sub_page=$matches[2]\";s:21:\"(dashboard)/logout/?$\";s:58:\"index.php?pagename=$matches[1]&tutor_dashboard_page=logout\";s:27:\"(dashboard)/logout/(.+?)/?$\";s:95:\"index.php?pagename=$matches[1]&tutor_dashboard_page=logout&tutor_dashboard_sub_page=$matches[2]\";s:32:\"(dashboard)/retrieve-password/?$\";s:69:\"index.php?pagename=$matches[1]&tutor_dashboard_page=retrieve-password\";s:38:\"(dashboard)/retrieve-password/(.+?)/?$\";s:106:\"index.php?pagename=$matches[1]&tutor_dashboard_page=retrieve-password&tutor_dashboard_sub_page=$matches[2]\";s:24:\"^wc-auth/v([1]{1})/(.*)?\";s:63:\"index.php?wc-auth-version=$matches[1]&wc-auth-route=$matches[2]\";s:22:\"^wc-api/v([1-3]{1})/?$\";s:51:\"index.php?wc-api-version=$matches[1]&wc-api-route=/\";s:24:\"^wc-api/v([1-3]{1})(.*)?\";s:61:\"index.php?wc-api-version=$matches[1]&wc-api-route=$matches[2]\";s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:10:\"courses/?$\";s:27:\"index.php?post_type=courses\";s:40:\"courses/feed/(feed|rdf|rss|rss2|atom)/?$\";s:44:\"index.php?post_type=courses&feed=$matches[1]\";s:35:\"courses/(feed|rdf|rss|rss2|atom)/?$\";s:44:\"index.php?post_type=courses&feed=$matches[1]\";s:27:\"courses/page/([0-9]{1,})/?$\";s:45:\"index.php?post_type=courses&paged=$matches[1]\";s:9:\"lesson/?$\";s:37:\"index.php?post_type=tutor_assignments\";s:39:\"lesson/feed/(feed|rdf|rss|rss2|atom)/?$\";s:54:\"index.php?post_type=tutor_assignments&feed=$matches[1]\";s:34:\"lesson/(feed|rdf|rss|rss2|atom)/?$\";s:54:\"index.php?post_type=tutor_assignments&feed=$matches[1]\";s:26:\"lesson/page/([0-9]{1,})/?$\";s:55:\"index.php?post_type=tutor_assignments&paged=$matches[1]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:32:\"category/(.+?)/wc-api(/(.*))?/?$\";s:54:\"index.php?category_name=$matches[1]&wc-api=$matches[3]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:29:\"tag/([^/]+)/wc-api(/(.*))?/?$\";s:44:\"index.php?tag=$matches[1]&wc-api=$matches[3]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:55:\"product-category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?product_cat=$matches[1]&feed=$matches[2]\";s:50:\"product-category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?product_cat=$matches[1]&feed=$matches[2]\";s:31:\"product-category/(.+?)/embed/?$\";s:44:\"index.php?product_cat=$matches[1]&embed=true\";s:43:\"product-category/(.+?)/page/?([0-9]{1,})/?$\";s:51:\"index.php?product_cat=$matches[1]&paged=$matches[2]\";s:25:\"product-category/(.+?)/?$\";s:33:\"index.php?product_cat=$matches[1]\";s:52:\"product-tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?product_tag=$matches[1]&feed=$matches[2]\";s:47:\"product-tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?product_tag=$matches[1]&feed=$matches[2]\";s:28:\"product-tag/([^/]+)/embed/?$\";s:44:\"index.php?product_tag=$matches[1]&embed=true\";s:40:\"product-tag/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?product_tag=$matches[1]&paged=$matches[2]\";s:22:\"product-tag/([^/]+)/?$\";s:33:\"index.php?product_tag=$matches[1]\";s:35:\"product/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:45:\"product/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:65:\"product/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:60:\"product/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:60:\"product/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:41:\"product/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:24:\"product/([^/]+)/embed/?$\";s:40:\"index.php?product=$matches[1]&embed=true\";s:28:\"product/([^/]+)/trackback/?$\";s:34:\"index.php?product=$matches[1]&tb=1\";s:36:\"product/([^/]+)/page/?([0-9]{1,})/?$\";s:47:\"index.php?product=$matches[1]&paged=$matches[2]\";s:43:\"product/([^/]+)/comment-page-([0-9]{1,})/?$\";s:47:\"index.php?product=$matches[1]&cpage=$matches[2]\";s:33:\"product/([^/]+)/wc-api(/(.*))?/?$\";s:48:\"index.php?product=$matches[1]&wc-api=$matches[3]\";s:39:\"product/[^/]+/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:50:\"product/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:32:\"product/([^/]+)(?:/([0-9]+))?/?$\";s:46:\"index.php?product=$matches[1]&page=$matches[2]\";s:24:\"product/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:34:\"product/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:54:\"product/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:49:\"product/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:49:\"product/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:30:\"product/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:35:\"courses/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:45:\"courses/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:65:\"courses/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:60:\"courses/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:60:\"courses/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:41:\"courses/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:24:\"courses/([^/]+)/embed/?$\";s:40:\"index.php?courses=$matches[1]&embed=true\";s:28:\"courses/([^/]+)/trackback/?$\";s:34:\"index.php?courses=$matches[1]&tb=1\";s:48:\"courses/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:46:\"index.php?courses=$matches[1]&feed=$matches[2]\";s:43:\"courses/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:46:\"index.php?courses=$matches[1]&feed=$matches[2]\";s:36:\"courses/([^/]+)/page/?([0-9]{1,})/?$\";s:47:\"index.php?courses=$matches[1]&paged=$matches[2]\";s:43:\"courses/([^/]+)/comment-page-([0-9]{1,})/?$\";s:47:\"index.php?courses=$matches[1]&cpage=$matches[2]\";s:33:\"courses/([^/]+)/wc-api(/(.*))?/?$\";s:48:\"index.php?courses=$matches[1]&wc-api=$matches[3]\";s:39:\"courses/[^/]+/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:50:\"courses/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:32:\"courses/([^/]+)(?:/([0-9]+))?/?$\";s:46:\"index.php?courses=$matches[1]&page=$matches[2]\";s:24:\"courses/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:34:\"courses/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:54:\"courses/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:49:\"courses/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:49:\"courses/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:30:\"courses/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:56:\"course-category/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:54:\"index.php?course-category=$matches[1]&feed=$matches[2]\";s:51:\"course-category/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:54:\"index.php?course-category=$matches[1]&feed=$matches[2]\";s:32:\"course-category/([^/]+)/embed/?$\";s:48:\"index.php?course-category=$matches[1]&embed=true\";s:44:\"course-category/([^/]+)/page/?([0-9]{1,})/?$\";s:55:\"index.php?course-category=$matches[1]&paged=$matches[2]\";s:26:\"course-category/([^/]+)/?$\";s:37:\"index.php?course-category=$matches[1]\";s:51:\"course-tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?course-tag=$matches[1]&feed=$matches[2]\";s:46:\"course-tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?course-tag=$matches[1]&feed=$matches[2]\";s:27:\"course-tag/([^/]+)/embed/?$\";s:43:\"index.php?course-tag=$matches[1]&embed=true\";s:39:\"course-tag/([^/]+)/page/?([0-9]{1,})/?$\";s:50:\"index.php?course-tag=$matches[1]&paged=$matches[2]\";s:21:\"course-tag/([^/]+)/?$\";s:32:\"index.php?course-tag=$matches[1]\";s:34:\"lesson/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:44:\"lesson/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:64:\"lesson/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:59:\"lesson/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:59:\"lesson/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:40:\"lesson/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:23:\"lesson/([^/]+)/embed/?$\";s:50:\"index.php?tutor_assignments=$matches[1]&embed=true\";s:27:\"lesson/([^/]+)/trackback/?$\";s:44:\"index.php?tutor_assignments=$matches[1]&tb=1\";s:47:\"lesson/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:56:\"index.php?tutor_assignments=$matches[1]&feed=$matches[2]\";s:42:\"lesson/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:56:\"index.php?tutor_assignments=$matches[1]&feed=$matches[2]\";s:35:\"lesson/([^/]+)/page/?([0-9]{1,})/?$\";s:57:\"index.php?tutor_assignments=$matches[1]&paged=$matches[2]\";s:42:\"lesson/([^/]+)/comment-page-([0-9]{1,})/?$\";s:57:\"index.php?tutor_assignments=$matches[1]&cpage=$matches[2]\";s:32:\"lesson/([^/]+)/wc-api(/(.*))?/?$\";s:58:\"index.php?tutor_assignments=$matches[1]&wc-api=$matches[3]\";s:38:\"lesson/[^/]+/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:49:\"lesson/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:31:\"lesson/([^/]+)(?:/([0-9]+))?/?$\";s:56:\"index.php?tutor_assignments=$matches[1]&page=$matches[2]\";s:23:\"lesson/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:33:\"lesson/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:53:\"lesson/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:48:\"lesson/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:48:\"lesson/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:29:\"lesson/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:34:\"topics/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:44:\"topics/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:64:\"topics/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:59:\"topics/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:59:\"topics/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:40:\"topics/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:23:\"topics/([^/]+)/embed/?$\";s:54:\"index.php?post_type=topics&name=$matches[1]&embed=true\";s:27:\"topics/([^/]+)/trackback/?$\";s:48:\"index.php?post_type=topics&name=$matches[1]&tb=1\";s:35:\"topics/([^/]+)/page/?([0-9]{1,})/?$\";s:61:\"index.php?post_type=topics&name=$matches[1]&paged=$matches[2]\";s:42:\"topics/([^/]+)/comment-page-([0-9]{1,})/?$\";s:61:\"index.php?post_type=topics&name=$matches[1]&cpage=$matches[2]\";s:32:\"topics/([^/]+)/wc-api(/(.*))?/?$\";s:62:\"index.php?post_type=topics&name=$matches[1]&wc-api=$matches[3]\";s:38:\"topics/[^/]+/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:49:\"topics/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:31:\"topics/([^/]+)(?:/([0-9]+))?/?$\";s:60:\"index.php?post_type=topics&name=$matches[1]&page=$matches[2]\";s:23:\"topics/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:33:\"topics/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:53:\"topics/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:48:\"topics/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:48:\"topics/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:29:\"topics/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:42:\"tutor_enrolled/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:52:\"tutor_enrolled/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:72:\"tutor_enrolled/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:67:\"tutor_enrolled/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:67:\"tutor_enrolled/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:48:\"tutor_enrolled/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:31:\"tutor_enrolled/([^/]+)/embed/?$\";s:62:\"index.php?post_type=tutor_enrolled&name=$matches[1]&embed=true\";s:35:\"tutor_enrolled/([^/]+)/trackback/?$\";s:56:\"index.php?post_type=tutor_enrolled&name=$matches[1]&tb=1\";s:43:\"tutor_enrolled/([^/]+)/page/?([0-9]{1,})/?$\";s:69:\"index.php?post_type=tutor_enrolled&name=$matches[1]&paged=$matches[2]\";s:50:\"tutor_enrolled/([^/]+)/comment-page-([0-9]{1,})/?$\";s:69:\"index.php?post_type=tutor_enrolled&name=$matches[1]&cpage=$matches[2]\";s:40:\"tutor_enrolled/([^/]+)/wc-api(/(.*))?/?$\";s:70:\"index.php?post_type=tutor_enrolled&name=$matches[1]&wc-api=$matches[3]\";s:46:\"tutor_enrolled/[^/]+/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:57:\"tutor_enrolled/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:39:\"tutor_enrolled/([^/]+)(?:/([0-9]+))?/?$\";s:68:\"index.php?post_type=tutor_enrolled&name=$matches[1]&page=$matches[2]\";s:31:\"tutor_enrolled/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:41:\"tutor_enrolled/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:61:\"tutor_enrolled/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:56:\"tutor_enrolled/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:56:\"tutor_enrolled/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:37:\"tutor_enrolled/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:45:\"sp_wps_shortcodes/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:55:\"sp_wps_shortcodes/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:75:\"sp_wps_shortcodes/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:70:\"sp_wps_shortcodes/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:70:\"sp_wps_shortcodes/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:51:\"sp_wps_shortcodes/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:34:\"sp_wps_shortcodes/([^/]+)/embed/?$\";s:65:\"index.php?post_type=sp_wps_shortcodes&name=$matches[1]&embed=true\";s:38:\"sp_wps_shortcodes/([^/]+)/trackback/?$\";s:59:\"index.php?post_type=sp_wps_shortcodes&name=$matches[1]&tb=1\";s:46:\"sp_wps_shortcodes/([^/]+)/page/?([0-9]{1,})/?$\";s:72:\"index.php?post_type=sp_wps_shortcodes&name=$matches[1]&paged=$matches[2]\";s:53:\"sp_wps_shortcodes/([^/]+)/comment-page-([0-9]{1,})/?$\";s:72:\"index.php?post_type=sp_wps_shortcodes&name=$matches[1]&cpage=$matches[2]\";s:43:\"sp_wps_shortcodes/([^/]+)/wc-api(/(.*))?/?$\";s:73:\"index.php?post_type=sp_wps_shortcodes&name=$matches[1]&wc-api=$matches[3]\";s:49:\"sp_wps_shortcodes/[^/]+/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:60:\"sp_wps_shortcodes/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:42:\"sp_wps_shortcodes/([^/]+)(?:/([0-9]+))?/?$\";s:71:\"index.php?post_type=sp_wps_shortcodes&name=$matches[1]&page=$matches[2]\";s:34:\"sp_wps_shortcodes/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:44:\"sp_wps_shortcodes/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:64:\"sp_wps_shortcodes/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:59:\"sp_wps_shortcodes/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:59:\"sp_wps_shortcodes/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:40:\"sp_wps_shortcodes/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:55:\"fb_product_set/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:53:\"index.php?fb_product_set=$matches[1]&feed=$matches[2]\";s:50:\"fb_product_set/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:53:\"index.php?fb_product_set=$matches[1]&feed=$matches[2]\";s:31:\"fb_product_set/([^/]+)/embed/?$\";s:47:\"index.php?fb_product_set=$matches[1]&embed=true\";s:43:\"fb_product_set/([^/]+)/page/?([0-9]{1,})/?$\";s:54:\"index.php?fb_product_set=$matches[1]&paged=$matches[2]\";s:25:\"fb_product_set/([^/]+)/?$\";s:36:\"index.php?fb_product_set=$matches[1]\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:27:\"comment-page-([0-9]{1,})/?$\";s:39:\"index.php?&page_id=93&cpage=$matches[1]\";s:17:\"wc-api(/(.*))?/?$\";s:29:\"index.php?&wc-api=$matches[2]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:26:\"comments/wc-api(/(.*))?/?$\";s:29:\"index.php?&wc-api=$matches[2]\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:29:\"search/(.+)/wc-api(/(.*))?/?$\";s:42:\"index.php?s=$matches[1]&wc-api=$matches[3]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:32:\"author/([^/]+)/wc-api(/(.*))?/?$\";s:52:\"index.php?author_name=$matches[1]&wc-api=$matches[3]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:54:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/wc-api(/(.*))?/?$\";s:82:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&wc-api=$matches[5]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:41:\"([0-9]{4})/([0-9]{1,2})/wc-api(/(.*))?/?$\";s:66:\"index.php?year=$matches[1]&monthnum=$matches[2]&wc-api=$matches[4]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:28:\"([0-9]{4})/wc-api(/(.*))?/?$\";s:45:\"index.php?year=$matches[1]&wc-api=$matches[3]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:25:\"(.?.+?)/wc-api(/(.*))?/?$\";s:49:\"index.php?pagename=$matches[1]&wc-api=$matches[3]\";s:28:\"(.?.+?)/order-pay(/(.*))?/?$\";s:52:\"index.php?pagename=$matches[1]&order-pay=$matches[3]\";s:33:\"(.?.+?)/order-received(/(.*))?/?$\";s:57:\"index.php?pagename=$matches[1]&order-received=$matches[3]\";s:25:\"(.?.+?)/orders(/(.*))?/?$\";s:49:\"index.php?pagename=$matches[1]&orders=$matches[3]\";s:29:\"(.?.+?)/view-order(/(.*))?/?$\";s:53:\"index.php?pagename=$matches[1]&view-order=$matches[3]\";s:28:\"(.?.+?)/downloads(/(.*))?/?$\";s:52:\"index.php?pagename=$matches[1]&downloads=$matches[3]\";s:31:\"(.?.+?)/edit-account(/(.*))?/?$\";s:55:\"index.php?pagename=$matches[1]&edit-account=$matches[3]\";s:31:\"(.?.+?)/edit-address(/(.*))?/?$\";s:55:\"index.php?pagename=$matches[1]&edit-address=$matches[3]\";s:34:\"(.?.+?)/payment-methods(/(.*))?/?$\";s:58:\"index.php?pagename=$matches[1]&payment-methods=$matches[3]\";s:32:\"(.?.+?)/lost-password(/(.*))?/?$\";s:56:\"index.php?pagename=$matches[1]&lost-password=$matches[3]\";s:34:\"(.?.+?)/customer-logout(/(.*))?/?$\";s:58:\"index.php?pagename=$matches[1]&customer-logout=$matches[3]\";s:37:\"(.?.+?)/add-payment-method(/(.*))?/?$\";s:61:\"index.php?pagename=$matches[1]&add-payment-method=$matches[3]\";s:40:\"(.?.+?)/delete-payment-method(/(.*))?/?$\";s:64:\"index.php?pagename=$matches[1]&delete-payment-method=$matches[3]\";s:45:\"(.?.+?)/set-default-payment-method(/(.*))?/?$\";s:69:\"index.php?pagename=$matches[1]&set-default-payment-method=$matches[3]\";s:31:\".?.+?/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:42:\".?.+?/attachment/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";s:27:\"[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\"[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\"[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\"[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"([^/]+)/embed/?$\";s:37:\"index.php?name=$matches[1]&embed=true\";s:20:\"([^/]+)/trackback/?$\";s:31:\"index.php?name=$matches[1]&tb=1\";s:40:\"([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:35:\"([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:28:\"([^/]+)/page/?([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&paged=$matches[2]\";s:35:\"([^/]+)/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&cpage=$matches[2]\";s:25:\"([^/]+)/wc-api(/(.*))?/?$\";s:45:\"index.php?name=$matches[1]&wc-api=$matches[3]\";s:31:\"[^/]+/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:42:\"[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$\";s:51:\"index.php?attachment=$matches[1]&wc-api=$matches[3]\";s:24:\"([^/]+)(?:/([0-9]+))?/?$\";s:43:\"index.php?name=$matches[1]&page=$matches[2]\";s:16:\"[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:26:\"[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:46:\"[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:22:\"[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";}', 'yes'),
(30, 'hack_file', '0', 'yes'),
(31, 'blog_charset', 'UTF-8', 'yes'),
(32, 'moderation_keys', '', 'no'),
(33, 'active_plugins', 'a:15:{i:0;s:33:\"admin-menu-editor/menu-editor.php\";i:1;s:34:\"advanced-custom-fields-pro/acf.php\";i:2;s:32:\"dc-custom-admin/custom-admin.php\";i:3;s:53:\"facebook-for-woocommerce/facebook-for-woocommerce.php\";i:4;s:20:\"lmspro/tutor-pro.php\";i:5;s:37:\"post-types-order/post-types-order.php\";i:6;s:21:\"safe-svg/safe-svg.php\";i:7;s:45:\"taxonomy-terms-order/taxonomy-terms-order.php\";i:8;s:15:\"tutor/tutor.php\";i:9;s:37:\"user-role-editor/user-role-editor.php\";i:10;s:42:\"woo-product-bundle/wpc-product-bundles.php\";i:11;s:27:\"woo-product-slider/main.php\";i:12;s:37:\"woocommerce-ajax-cart/wooajaxcart.php\";i:13;s:27:\"woocommerce/woocommerce.php\";i:14;s:29:\"wp-mail-smtp/wp_mail_smtp.php\";}', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'comment_max_links', '2', 'yes'),
(37, 'gmt_offset', '0', 'yes'),
(38, 'default_email_category', '1', 'yes'),
(39, 'recently_edited', '', 'no'),
(40, 'template', 'site_el', 'yes'),
(41, 'stylesheet', 'site_el', 'yes'),
(42, 'comment_whitelist', '1', 'yes'),
(43, 'blacklist_keys', '', 'no'),
(44, 'comment_registration', '0', 'yes'),
(45, 'html_type', 'text/html', 'yes'),
(46, 'use_trackback', '0', 'yes'),
(47, 'default_role', 'subscriber', 'yes'),
(48, 'db_version', '45805', 'yes'),
(49, 'uploads_use_yearmonth_folders', '1', 'yes'),
(50, 'upload_path', '', 'yes'),
(51, 'blog_public', '1', 'yes'),
(52, 'default_link_category', '2', 'yes'),
(53, 'show_on_front', 'page', 'yes'),
(54, 'tag_base', '', 'yes'),
(55, 'show_avatars', '1', 'yes'),
(56, 'avatar_rating', 'G', 'yes'),
(57, 'upload_url_path', '', 'yes'),
(58, 'thumbnail_size_w', '150', 'yes'),
(59, 'thumbnail_size_h', '150', 'yes'),
(60, 'thumbnail_crop', '1', 'yes'),
(61, 'medium_size_w', '300', 'yes'),
(62, 'medium_size_h', '300', 'yes'),
(63, 'avatar_default', 'mystery', 'yes'),
(64, 'large_size_w', '1024', 'yes'),
(65, 'large_size_h', '1024', 'yes'),
(66, 'image_default_link_type', 'none', 'yes'),
(67, 'image_default_size', '', 'yes'),
(68, 'image_default_align', '', 'yes'),
(69, 'close_comments_for_old_posts', '0', 'yes'),
(70, 'close_comments_days_old', '14', 'yes'),
(71, 'thread_comments', '1', 'yes'),
(72, 'thread_comments_depth', '5', 'yes'),
(73, 'page_comments', '0', 'yes'),
(74, 'comments_per_page', '50', 'yes'),
(75, 'default_comments_page', 'newest', 'yes'),
(76, 'comment_order', 'asc', 'yes'),
(77, 'sticky_posts', 'a:0:{}', 'yes'),
(78, 'widget_categories', 'a:2:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(79, 'widget_text', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(80, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(81, 'uninstall_plugins', 'a:0:{}', 'no'),
(82, 'timezone_string', '', 'yes'),
(83, 'page_for_posts', '0', 'yes'),
(84, 'page_on_front', '93', 'yes'),
(85, 'default_post_format', '0', 'yes'),
(86, 'link_manager_enabled', '0', 'yes'),
(87, 'finished_splitting_shared_terms', '1', 'yes'),
(88, 'site_icon', '0', 'yes'),
(89, 'medium_large_size_w', '768', 'yes'),
(90, 'medium_large_size_h', '0', 'yes'),
(91, 'wp_page_for_privacy_policy', '3', 'yes'),
(92, 'show_comments_cookies_opt_in', '1', 'yes'),
(93, 'admin_email_lifespan', '1672194609', 'yes'),
(94, 'initial_db_version', '45805', 'yes');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(95, 'wp_user_roles', 'a:8:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:161:{s:16:\"activate_plugins\";b:1;s:20:\"assign_product_terms\";b:1;s:24:\"assign_shop_coupon_terms\";b:1;s:23:\"assign_shop_order_terms\";b:1;s:12:\"create_posts\";b:1;s:12:\"create_users\";b:1;s:19:\"delete_others_pages\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_others_products\";b:1;s:26:\"delete_others_shop_coupons\";b:1;s:25:\"delete_others_shop_orders\";b:1;s:12:\"delete_pages\";b:1;s:14:\"delete_plugins\";b:1;s:12:\"delete_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:20:\"delete_private_posts\";b:1;s:23:\"delete_private_products\";b:1;s:27:\"delete_private_shop_coupons\";b:1;s:26:\"delete_private_shop_orders\";b:1;s:14:\"delete_product\";b:1;s:20:\"delete_product_terms\";b:1;s:15:\"delete_products\";b:1;s:22:\"delete_published_pages\";b:1;s:22:\"delete_published_posts\";b:1;s:25:\"delete_published_products\";b:1;s:29:\"delete_published_shop_coupons\";b:1;s:28:\"delete_published_shop_orders\";b:1;s:18:\"delete_shop_coupon\";b:1;s:24:\"delete_shop_coupon_terms\";b:1;s:19:\"delete_shop_coupons\";b:1;s:17:\"delete_shop_order\";b:1;s:23:\"delete_shop_order_terms\";b:1;s:18:\"delete_shop_orders\";b:1;s:13:\"delete_themes\";b:1;s:24:\"delete_tutor_assignments\";b:1;s:19:\"delete_tutor_course\";b:1;s:20:\"delete_tutor_courses\";b:1;s:19:\"delete_tutor_lesson\";b:1;s:20:\"delete_tutor_lessons\";b:1;s:21:\"delete_tutor_question\";b:1;s:22:\"delete_tutor_questions\";b:1;s:17:\"delete_tutor_quiz\";b:1;s:20:\"delete_tutor_quizzes\";b:1;s:12:\"delete_users\";b:1;s:14:\"edit_dashboard\";b:1;s:10:\"edit_files\";b:1;s:17:\"edit_others_pages\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_others_products\";b:1;s:24:\"edit_others_shop_coupons\";b:1;s:23:\"edit_others_shop_orders\";b:1;s:29:\"edit_others_tutor_assignments\";b:1;s:25:\"edit_others_tutor_courses\";b:1;s:25:\"edit_others_tutor_lessons\";b:1;s:27:\"edit_others_tutor_questions\";b:1;s:25:\"edit_others_tutor_quizzes\";b:1;s:10:\"edit_pages\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_posts\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"edit_private_posts\";b:1;s:21:\"edit_private_products\";b:1;s:25:\"edit_private_shop_coupons\";b:1;s:24:\"edit_private_shop_orders\";b:1;s:12:\"edit_product\";b:1;s:18:\"edit_product_terms\";b:1;s:13:\"edit_products\";b:1;s:20:\"edit_published_pages\";b:1;s:20:\"edit_published_posts\";b:1;s:23:\"edit_published_products\";b:1;s:27:\"edit_published_shop_coupons\";b:1;s:26:\"edit_published_shop_orders\";b:1;s:16:\"edit_shop_coupon\";b:1;s:22:\"edit_shop_coupon_terms\";b:1;s:17:\"edit_shop_coupons\";b:1;s:15:\"edit_shop_order\";b:1;s:21:\"edit_shop_order_terms\";b:1;s:16:\"edit_shop_orders\";b:1;s:18:\"edit_theme_options\";b:1;s:11:\"edit_themes\";b:1;s:22:\"edit_tutor_assignments\";b:1;s:17:\"edit_tutor_course\";b:1;s:18:\"edit_tutor_courses\";b:1;s:17:\"edit_tutor_lesson\";b:1;s:18:\"edit_tutor_lessons\";b:1;s:19:\"edit_tutor_question\";b:1;s:20:\"edit_tutor_questions\";b:1;s:15:\"edit_tutor_quiz\";b:1;s:18:\"edit_tutor_quizzes\";b:1;s:10:\"edit_users\";b:1;s:6:\"export\";b:1;s:6:\"import\";b:1;s:15:\"install_plugins\";b:1;s:14:\"install_themes\";b:1;s:7:\"level_0\";b:1;s:7:\"level_1\";b:1;s:8:\"level_10\";b:1;s:7:\"level_2\";b:1;s:7:\"level_3\";b:1;s:7:\"level_4\";b:1;s:7:\"level_5\";b:1;s:7:\"level_6\";b:1;s:7:\"level_7\";b:1;s:7:\"level_8\";b:1;s:7:\"level_9\";b:1;s:10:\"list_users\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:14:\"manage_options\";b:1;s:20:\"manage_product_terms\";b:1;s:24:\"manage_shop_coupon_terms\";b:1;s:23:\"manage_shop_order_terms\";b:1;s:12:\"manage_tutor\";b:1;s:23:\"manage_tutor_instructor\";b:1;s:18:\"manage_woocommerce\";b:1;s:17:\"moderate_comments\";b:1;s:13:\"promote_users\";b:1;s:13:\"publish_pages\";b:1;s:13:\"publish_posts\";b:1;s:16:\"publish_products\";b:1;s:20:\"publish_shop_coupons\";b:1;s:19:\"publish_shop_orders\";b:1;s:25:\"publish_tutor_assignments\";b:1;s:21:\"publish_tutor_courses\";b:1;s:21:\"publish_tutor_lessons\";b:1;s:23:\"publish_tutor_questions\";b:1;s:21:\"publish_tutor_quizzes\";b:1;s:4:\"read\";b:1;s:18:\"read_private_pages\";b:1;s:18:\"read_private_posts\";b:1;s:21:\"read_private_products\";b:1;s:25:\"read_private_shop_coupons\";b:1;s:24:\"read_private_shop_orders\";b:1;s:30:\"read_private_tutor_assignments\";b:1;s:26:\"read_private_tutor_courses\";b:1;s:26:\"read_private_tutor_lessons\";b:1;s:28:\"read_private_tutor_questions\";b:1;s:26:\"read_private_tutor_quizzes\";b:1;s:12:\"read_product\";b:1;s:16:\"read_shop_coupon\";b:1;s:15:\"read_shop_order\";b:1;s:17:\"read_tutor_course\";b:1;s:17:\"read_tutor_lesson\";b:1;s:19:\"read_tutor_question\";b:1;s:15:\"read_tutor_quiz\";b:1;s:12:\"remove_users\";b:1;s:13:\"switch_themes\";b:1;s:15:\"unfiltered_html\";b:1;s:17:\"unfiltered_upload\";b:1;s:11:\"update_core\";b:1;s:14:\"update_plugins\";b:1;s:13:\"update_themes\";b:1;s:12:\"upload_files\";b:1;s:23:\"ure_create_capabilities\";b:1;s:16:\"ure_create_roles\";b:1;s:23:\"ure_delete_capabilities\";b:1;s:16:\"ure_delete_roles\";b:1;s:14:\"ure_edit_roles\";b:1;s:18:\"ure_manage_options\";b:1;s:15:\"ure_reset_roles\";b:1;s:24:\"view_woocommerce_reports\";b:1;}}s:6:\"admins\";a:2:{s:4:\"name\";s:6:\"Admins\";s:12:\"capabilities\";a:151:{s:20:\"assign_product_terms\";b:1;s:24:\"assign_shop_coupon_terms\";b:1;s:23:\"assign_shop_order_terms\";b:1;s:12:\"create_posts\";b:1;s:12:\"create_users\";b:1;s:19:\"delete_others_pages\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_others_products\";b:1;s:26:\"delete_others_shop_coupons\";b:1;s:25:\"delete_others_shop_orders\";b:1;s:12:\"delete_pages\";b:1;s:12:\"delete_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:20:\"delete_private_posts\";b:1;s:23:\"delete_private_products\";b:1;s:27:\"delete_private_shop_coupons\";b:1;s:26:\"delete_private_shop_orders\";b:1;s:14:\"delete_product\";b:1;s:20:\"delete_product_terms\";b:1;s:15:\"delete_products\";b:1;s:22:\"delete_published_pages\";b:1;s:22:\"delete_published_posts\";b:1;s:25:\"delete_published_products\";b:1;s:29:\"delete_published_shop_coupons\";b:1;s:28:\"delete_published_shop_orders\";b:1;s:18:\"delete_shop_coupon\";b:1;s:24:\"delete_shop_coupon_terms\";b:1;s:19:\"delete_shop_coupons\";b:1;s:17:\"delete_shop_order\";b:1;s:23:\"delete_shop_order_terms\";b:1;s:18:\"delete_shop_orders\";b:1;s:24:\"delete_tutor_assignments\";b:1;s:19:\"delete_tutor_course\";b:1;s:20:\"delete_tutor_courses\";b:1;s:19:\"delete_tutor_lesson\";b:1;s:20:\"delete_tutor_lessons\";b:1;s:21:\"delete_tutor_question\";b:1;s:22:\"delete_tutor_questions\";b:1;s:17:\"delete_tutor_quiz\";b:1;s:20:\"delete_tutor_quizzes\";b:1;s:12:\"delete_users\";b:1;s:14:\"edit_dashboard\";b:1;s:10:\"edit_files\";b:1;s:17:\"edit_others_pages\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_others_products\";b:1;s:24:\"edit_others_shop_coupons\";b:1;s:23:\"edit_others_shop_orders\";b:1;s:29:\"edit_others_tutor_assignments\";b:1;s:25:\"edit_others_tutor_courses\";b:1;s:25:\"edit_others_tutor_lessons\";b:1;s:27:\"edit_others_tutor_questions\";b:1;s:25:\"edit_others_tutor_quizzes\";b:1;s:10:\"edit_pages\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_posts\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"edit_private_posts\";b:1;s:21:\"edit_private_products\";b:1;s:25:\"edit_private_shop_coupons\";b:1;s:24:\"edit_private_shop_orders\";b:1;s:12:\"edit_product\";b:1;s:18:\"edit_product_terms\";b:1;s:13:\"edit_products\";b:1;s:20:\"edit_published_pages\";b:1;s:20:\"edit_published_posts\";b:1;s:23:\"edit_published_products\";b:1;s:27:\"edit_published_shop_coupons\";b:1;s:26:\"edit_published_shop_orders\";b:1;s:16:\"edit_shop_coupon\";b:1;s:22:\"edit_shop_coupon_terms\";b:1;s:17:\"edit_shop_coupons\";b:1;s:15:\"edit_shop_order\";b:1;s:21:\"edit_shop_order_terms\";b:1;s:16:\"edit_shop_orders\";b:1;s:22:\"edit_tutor_assignments\";b:1;s:17:\"edit_tutor_course\";b:1;s:18:\"edit_tutor_courses\";b:1;s:17:\"edit_tutor_lesson\";b:1;s:18:\"edit_tutor_lessons\";b:1;s:19:\"edit_tutor_question\";b:1;s:20:\"edit_tutor_questions\";b:1;s:15:\"edit_tutor_quiz\";b:1;s:18:\"edit_tutor_quizzes\";b:1;s:10:\"edit_users\";b:1;s:6:\"export\";b:1;s:6:\"import\";b:1;s:7:\"level_0\";b:1;s:7:\"level_1\";b:1;s:8:\"level_10\";b:1;s:7:\"level_2\";b:1;s:7:\"level_3\";b:1;s:7:\"level_4\";b:1;s:7:\"level_5\";b:1;s:7:\"level_6\";b:1;s:7:\"level_7\";b:1;s:7:\"level_8\";b:1;s:7:\"level_9\";b:1;s:10:\"list_users\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:14:\"manage_options\";b:1;s:20:\"manage_product_terms\";b:1;s:24:\"manage_shop_coupon_terms\";b:1;s:23:\"manage_shop_order_terms\";b:1;s:12:\"manage_tutor\";b:1;s:23:\"manage_tutor_instructor\";b:1;s:18:\"manage_woocommerce\";b:1;s:17:\"moderate_comments\";b:1;s:13:\"promote_users\";b:1;s:13:\"publish_pages\";b:1;s:13:\"publish_posts\";b:1;s:16:\"publish_products\";b:1;s:20:\"publish_shop_coupons\";b:1;s:19:\"publish_shop_orders\";b:1;s:25:\"publish_tutor_assignments\";b:1;s:21:\"publish_tutor_courses\";b:1;s:21:\"publish_tutor_lessons\";b:1;s:23:\"publish_tutor_questions\";b:1;s:21:\"publish_tutor_quizzes\";b:1;s:4:\"read\";b:1;s:18:\"read_private_pages\";b:1;s:18:\"read_private_posts\";b:1;s:21:\"read_private_products\";b:1;s:25:\"read_private_shop_coupons\";b:1;s:24:\"read_private_shop_orders\";b:1;s:30:\"read_private_tutor_assignments\";b:1;s:26:\"read_private_tutor_courses\";b:1;s:26:\"read_private_tutor_lessons\";b:1;s:28:\"read_private_tutor_questions\";b:1;s:26:\"read_private_tutor_quizzes\";b:1;s:12:\"read_product\";b:1;s:16:\"read_shop_coupon\";b:1;s:15:\"read_shop_order\";b:1;s:17:\"read_tutor_course\";b:1;s:17:\"read_tutor_lesson\";b:1;s:19:\"read_tutor_question\";b:1;s:15:\"read_tutor_quiz\";b:1;s:12:\"remove_users\";b:1;s:13:\"switch_themes\";b:1;s:15:\"unfiltered_html\";b:1;s:17:\"unfiltered_upload\";b:1;s:12:\"upload_files\";b:1;s:23:\"ure_create_capabilities\";b:1;s:16:\"ure_create_roles\";b:1;s:23:\"ure_delete_capabilities\";b:1;s:16:\"ure_delete_roles\";b:1;s:14:\"ure_edit_roles\";b:1;s:18:\"ure_manage_options\";b:1;s:15:\"ure_reset_roles\";b:1;s:24:\"view_woocommerce_reports\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:16:\"tutor_instructor\";a:2:{s:4:\"name\";s:10:\"Instructor\";s:12:\"capabilities\";a:36:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:12:\"upload_files\";b:1;s:23:\"manage_tutor_instructor\";b:1;s:17:\"edit_tutor_course\";b:1;s:17:\"read_tutor_course\";b:1;s:19:\"delete_tutor_course\";b:1;s:20:\"delete_tutor_courses\";b:1;s:18:\"edit_tutor_courses\";b:1;s:25:\"edit_others_tutor_courses\";b:1;s:26:\"read_private_tutor_courses\";b:1;s:17:\"edit_tutor_lesson\";b:1;s:17:\"read_tutor_lesson\";b:1;s:19:\"delete_tutor_lesson\";b:1;s:20:\"delete_tutor_lessons\";b:1;s:18:\"edit_tutor_lessons\";b:1;s:25:\"edit_others_tutor_lessons\";b:1;s:26:\"read_private_tutor_lessons\";b:1;s:21:\"publish_tutor_lessons\";b:1;s:15:\"edit_tutor_quiz\";b:1;s:15:\"read_tutor_quiz\";b:1;s:17:\"delete_tutor_quiz\";b:1;s:20:\"delete_tutor_quizzes\";b:1;s:18:\"edit_tutor_quizzes\";b:1;s:25:\"edit_others_tutor_quizzes\";b:1;s:26:\"read_private_tutor_quizzes\";b:1;s:21:\"publish_tutor_quizzes\";b:1;s:19:\"edit_tutor_question\";b:1;s:19:\"read_tutor_question\";b:1;s:21:\"delete_tutor_question\";b:1;s:22:\"delete_tutor_questions\";b:1;s:20:\"edit_tutor_questions\";b:1;s:27:\"edit_others_tutor_questions\";b:1;s:23:\"publish_tutor_questions\";b:1;s:28:\"read_private_tutor_questions\";b:1;s:21:\"publish_tutor_courses\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:7:\"Learner\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}s:12:\"shop_manager\";a:2:{s:4:\"name\";s:5:\"Staff\";s:12:\"capabilities\";a:86:{s:24:\"assign_shop_coupon_terms\";b:1;s:23:\"assign_shop_order_terms\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_others_products\";b:1;s:26:\"delete_others_shop_coupons\";b:1;s:25:\"delete_others_shop_orders\";b:1;s:12:\"delete_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:23:\"delete_private_products\";b:1;s:27:\"delete_private_shop_coupons\";b:1;s:26:\"delete_private_shop_orders\";b:1;s:14:\"delete_product\";b:1;s:20:\"delete_product_terms\";b:1;s:15:\"delete_products\";b:1;s:22:\"delete_published_pages\";b:1;s:22:\"delete_published_posts\";b:1;s:25:\"delete_published_products\";b:1;s:29:\"delete_published_shop_coupons\";b:1;s:28:\"delete_published_shop_orders\";b:1;s:18:\"delete_shop_coupon\";b:1;s:24:\"delete_shop_coupon_terms\";b:1;s:19:\"delete_shop_coupons\";b:1;s:17:\"delete_shop_order\";b:1;s:23:\"delete_shop_order_terms\";b:1;s:18:\"delete_shop_orders\";b:1;s:24:\"delete_tutor_assignments\";b:1;s:17:\"edit_others_pages\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_others_products\";b:1;s:24:\"edit_others_shop_coupons\";b:1;s:23:\"edit_others_shop_orders\";b:1;s:29:\"edit_others_tutor_assignments\";b:1;s:10:\"edit_pages\";b:1;s:10:\"edit_posts\";b:1;s:21:\"edit_private_products\";b:1;s:25:\"edit_private_shop_coupons\";b:1;s:24:\"edit_private_shop_orders\";b:1;s:12:\"edit_product\";b:1;s:18:\"edit_product_terms\";b:1;s:13:\"edit_products\";b:1;s:20:\"edit_published_pages\";b:1;s:20:\"edit_published_posts\";b:1;s:23:\"edit_published_products\";b:1;s:27:\"edit_published_shop_coupons\";b:1;s:26:\"edit_published_shop_orders\";b:1;s:16:\"edit_shop_coupon\";b:1;s:22:\"edit_shop_coupon_terms\";b:1;s:17:\"edit_shop_coupons\";b:1;s:15:\"edit_shop_order\";b:1;s:21:\"edit_shop_order_terms\";b:1;s:16:\"edit_shop_orders\";b:1;s:18:\"edit_theme_options\";b:1;s:22:\"edit_tutor_assignments\";b:1;s:7:\"level_0\";b:1;s:7:\"level_1\";b:1;s:7:\"level_2\";b:1;s:7:\"level_3\";b:1;s:7:\"level_4\";b:1;s:7:\"level_5\";b:1;s:7:\"level_6\";b:1;s:7:\"level_7\";b:1;s:7:\"level_8\";b:1;s:7:\"level_9\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:20:\"manage_product_terms\";b:1;s:24:\"manage_shop_coupon_terms\";b:1;s:23:\"manage_shop_order_terms\";b:1;s:18:\"manage_woocommerce\";b:1;s:17:\"moderate_comments\";b:1;s:13:\"publish_pages\";b:1;s:13:\"publish_posts\";b:1;s:16:\"publish_products\";b:1;s:20:\"publish_shop_coupons\";b:1;s:19:\"publish_shop_orders\";b:1;s:4:\"read\";b:1;s:18:\"read_private_pages\";b:1;s:18:\"read_private_posts\";b:1;s:21:\"read_private_products\";b:1;s:25:\"read_private_shop_coupons\";b:1;s:24:\"read_private_shop_orders\";b:1;s:12:\"read_product\";b:1;s:16:\"read_shop_coupon\";b:1;s:15:\"read_shop_order\";b:1;s:12:\"upload_files\";b:1;s:24:\"view_woocommerce_reports\";b:1;}}}', 'yes'),
(96, 'fresh_site', '0', 'yes'),
(97, 'WPLANG', 'vi', 'yes'),
(98, 'widget_search', 'a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(99, 'widget_recent-posts', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(100, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(101, 'widget_archives', 'a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(102, 'widget_meta', 'a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(103, 'sidebars_widgets', 'a:2:{s:19:\"wp_inactive_widgets\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:13:\"array_version\";i:3;}', 'yes'),
(104, 'cron', 'a:18:{i:1701185894;a:1:{s:26:\"action_scheduler_run_queue\";a:1:{s:32:\"0d04ed39571b55704c122d726248bbac\";a:3:{s:8:\"schedule\";s:12:\"every_minute\";s:4:\"args\";a:1:{i:0;s:7:\"WP Cron\";}s:8:\"interval\";i:60;}}}i:1701185921;a:1:{s:26:\"action_scheduler_run_queue\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:12:\"every_minute\";s:4:\"args\";a:0:{}s:8:\"interval\";i:60;}}}i:1701186191;a:1:{s:46:\"facebook_for_woocommerce_hourly_heartbeat_cron\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1701188724;a:1:{s:32:\"woocommerce_cancel_unpaid_orders\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:2:{s:8:\"schedule\";b:0;s:4:\"args\";a:0:{}}}}i:1701189016;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1701216000;a:1:{s:27:\"woocommerce_scheduled_sales\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1701221552;a:1:{s:28:\"woocommerce_cleanup_sessions\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1701225015;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1701225016;a:3:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1701225031;a:2:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1701225033;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1701226649;a:1:{s:30:\"tutor_once_in_day_run_schedule\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1701243152;a:1:{s:33:\"woocommerce_cleanup_personal_data\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1701243162;a:1:{s:30:\"woocommerce_tracker_send_event\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1701243791;a:1:{s:45:\"facebook_for_woocommerce_daily_heartbeat_cron\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1701253952;a:1:{s:24:\"woocommerce_cleanup_logs\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1701561600;a:1:{s:25:\"woocommerce_geoip_updater\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:7:\"monthly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:2635200;}}}s:7:\"version\";i:2;}', 'yes'),
(105, 'widget_pages', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(106, 'widget_calendar', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(107, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(108, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(109, 'widget_media_gallery', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(110, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(111, 'widget_tag_cloud', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(112, 'widget_nav_menu', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(113, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(115, 'recovery_keys', 'a:1:{s:22:\"NT66PqkrHdS1rcLnK9DBXE\";a:2:{s:10:\"hashed_key\";s:34:\"$P$BPPyvP6vVMQtM2RYFFKnoyHfe7p24I/\";s:10:\"created_at\";i:1701185496;}}', 'yes'),
(143, 'can_compress_scripts', '1', 'no'),
(148, 'recently_activated', 'a:0:{}', 'yes'),
(149, 'tutor_license_info', 'a:2:{s:9:\"activated\";b:1;s:10:\"license_to\";s:13:\"mythosedu.com\";}', 'yes'),
(150, 'tutor_pro_version', '2.0.3', 'yes'),
(151, 'tutor_option', 'a:86:{s:23:\"tutor_dashboard_page_id\";s:1:\"6\";s:25:\"enable_course_marketplace\";s:2:\"on\";s:19:\"pagination_per_page\";s:2:\"20\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:28:\"enable_become_instructor_btn\";s:3:\"off\";s:28:\"course_content_access_for_ia\";s:3:\"off\";s:21:\"enable_spotlight_mode\";s:3:\"off\";s:25:\"course_completion_process\";s:8:\"flexible\";s:21:\"course_retake_feature\";s:3:\"off\";s:25:\"enrollment_expiry_enabled\";s:2:\"on\";s:28:\"enable_lesson_classic_editor\";s:2:\"on\";s:28:\"autoload_next_course_content\";s:2:\"on\";s:25:\"enable_comment_for_lesson\";s:3:\"off\";s:22:\"quiz_when_time_expires\";s:12:\"auto_abandon\";s:21:\"quiz_attempts_allowed\";s:3:\"100\";s:28:\"quiz_previous_button_enabled\";s:3:\"off\";s:17:\"quiz_grade_method\";s:13:\"highest_grade\";s:23:\"supported_video_sources\";a:2:{i:0;s:8:\"embedded\";i:1;s:9:\"shortcode\";}s:11:\"monetize_by\";s:2:\"wc\";s:24:\"enable_guest_course_cart\";a:2:{i:0;s:2:\"on\";i:1;s:2:\"on\";}s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";s:22:\"enable_revenue_sharing\";s:3:\"off\";s:23:\"statement_show_per_page\";s:2:\"20\";s:21:\"enable_fees_deducting\";s:2:\"on\";s:9:\"fees_name\";s:0:\"\";s:15:\"fee_amount_type\";a:2:{s:9:\"fees_type\";s:2:\"-1\";s:11:\"fees_amount\";s:1:\"0\";}s:19:\"min_withdraw_amount\";s:2:\"80\";s:40:\"minimum_days_for_balance_to_be_available\";s:1:\"7\";s:24:\"tutor_withdrawal_methods\";a:3:{s:22:\"bank_transfer_withdraw\";s:22:\"bank_transfer_withdraw\";s:15:\"echeck_withdraw\";s:15:\"echeck_withdraw\";s:15:\"paypal_withdraw\";s:15:\"paypal_withdraw\";}s:40:\"tutor_bank_transfer_withdraw_instruction\";s:0:\"\";s:34:\"tutor_frontend_course_page_logo_id\";s:0:\"\";s:19:\"courses_col_per_row\";s:1:\"4\";s:21:\"course_archive_filter\";s:2:\"on\";s:16:\"courses_per_page\";s:1:\"8\";s:24:\"supported_course_filters\";a:4:{s:6:\"search\";s:6:\"search\";s:8:\"category\";s:8:\"category\";s:3:\"tag\";s:3:\"tag\";s:10:\"price_type\";s:10:\"price_type\";}s:22:\"instructor_list_layout\";s:12:\"pp-left-full\";s:21:\"public_profile_layout\";s:9:\"pp-circle\";s:29:\"student_public_profile_layout\";s:9:\"pp-circle\";s:26:\"display_course_instructors\";s:3:\"off\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:20:\"enable_course_author\";s:3:\"off\";s:19:\"enable_course_level\";s:2:\"on\";s:19:\"enable_course_share\";s:2:\"on\";s:22:\"enable_course_duration\";s:2:\"on\";s:28:\"enable_course_total_enrolled\";s:2:\"on\";s:25:\"enable_course_update_date\";s:2:\"on\";s:26:\"enable_course_progress_bar\";s:2:\"on\";s:22:\"enable_course_material\";s:2:\"on\";s:19:\"enable_course_about\";s:2:\"on\";s:25:\"enable_course_description\";s:2:\"on\";s:22:\"enable_course_benefits\";s:2:\"on\";s:26:\"enable_course_requirements\";s:2:\"on\";s:29:\"enable_course_target_audience\";s:2:\"on\";s:27:\"enable_course_announcements\";s:2:\"on\";s:20:\"enable_course_review\";s:2:\"on\";s:17:\"color_preset_type\";s:6:\"custom\";s:19:\"tutor_primary_color\";s:7:\"#3e64de\";s:25:\"tutor_primary_hover_color\";s:7:\"#28408e\";s:16:\"tutor_text_color\";s:7:\"#1a1b1e\";s:22:\"tutor_background_color\";s:7:\"#f6f8fd\";s:18:\"tutor_border_color\";s:7:\"#cdcfd5\";s:19:\"tutor_success_color\";s:7:\"#24a148\";s:19:\"tutor_warning_color\";s:7:\"#ed9700\";s:18:\"tutor_danger_color\";s:7:\"#d8d8d8\";s:19:\"tutor_disable_color\";s:7:\"#e3e6eb\";s:28:\"tutor_table_background_color\";s:7:\"#eff1f6\";s:30:\"disable_default_player_youtube\";s:3:\"off\";s:28:\"disable_default_player_vimeo\";s:3:\"off\";s:28:\"enable_gutenberg_course_edit\";s:2:\"on\";s:26:\"hide_course_from_shop_page\";s:2:\"on\";s:19:\"course_archive_page\";s:2:\"-1\";s:24:\"instructor_register_page\";s:1:\"8\";s:21:\"student_register_page\";s:1:\"7\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:37:\"lesson_video_duration_youtube_api_key\";s:0:\"\";s:25:\"enable_profile_completion\";s:2:\"on\";s:25:\"enable_tutor_native_login\";s:2:\"on\";s:24:\"hide_admin_bar_for_users\";s:2:\"on\";s:19:\"delete_on_uninstall\";s:3:\"off\";s:29:\"enable_tutor_maintenance_mode\";s:3:\"off\";s:28:\"gradebook_enable_grade_point\";s:2:\"on\";s:26:\"gradebook_show_grade_scale\";s:3:\"off\";s:25:\"gradebook_scale_separator\";s:1:\"/\";s:15:\"gradebook_scale\";s:1:\"6\";s:17:\"email_footer_text\";s:0:\"\";}', 'yes'),
(153, 'tutor_version', '2.0.0', 'yes'),
(154, 'tutor_first_activation_time', '1656644249', 'yes'),
(155, 'tutor_wizard', 'active', 'yes'),
(156, 'widget_tutor_course_widget', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(158, 'tutor_default_option', 'a:13:{s:25:\"enable_course_marketplace\";s:3:\"off\";s:21:\"public_profile_layout\";s:12:\"pp-rectangle\";s:29:\"student_public_profile_layout\";s:12:\"pp-rectangle\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:26:\"display_course_instructors\";s:2:\"on\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:19:\"courses_col_per_row\";s:1:\"4\";s:16:\"courses_per_page\";s:1:\"8\";s:28:\"enable_become_instructor_btn\";s:2:\"on\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:24:\"enable_guest_course_cart\";s:2:\"on\";s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";}', 'yes'),
(160, 'tutor_welcome_page_visited', '1', 'yes');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(161, 'tutor_settings_log', 'a:10:{s:22:\"tutor-saved-1658932618\";a:4:{s:8:\"datetime\";i:1658932618;s:12:\"history_date\";s:21:\"27 Jul, 2022, 2:36 pm\";s:8:\"datatype\";s:5:\"saved\";s:7:\"dataset\";a:86:{s:23:\"tutor_dashboard_page_id\";s:1:\"6\";s:25:\"enable_course_marketplace\";s:2:\"on\";s:19:\"pagination_per_page\";s:2:\"20\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:28:\"enable_become_instructor_btn\";s:3:\"off\";s:28:\"course_content_access_for_ia\";s:3:\"off\";s:21:\"enable_spotlight_mode\";s:3:\"off\";s:25:\"course_completion_process\";s:8:\"flexible\";s:21:\"course_retake_feature\";s:3:\"off\";s:25:\"enrollment_expiry_enabled\";s:2:\"on\";s:28:\"enable_lesson_classic_editor\";s:2:\"on\";s:28:\"autoload_next_course_content\";s:2:\"on\";s:25:\"enable_comment_for_lesson\";s:3:\"off\";s:22:\"quiz_when_time_expires\";s:12:\"auto_abandon\";s:21:\"quiz_attempts_allowed\";s:3:\"100\";s:28:\"quiz_previous_button_enabled\";s:3:\"off\";s:17:\"quiz_grade_method\";s:13:\"highest_grade\";s:23:\"supported_video_sources\";a:2:{i:0;s:8:\"embedded\";i:1;s:9:\"shortcode\";}s:11:\"monetize_by\";s:2:\"wc\";s:24:\"enable_guest_course_cart\";a:2:{i:0;s:2:\"on\";i:1;s:2:\"on\";}s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";s:22:\"enable_revenue_sharing\";s:3:\"off\";s:23:\"statement_show_per_page\";s:2:\"20\";s:21:\"enable_fees_deducting\";s:2:\"on\";s:9:\"fees_name\";s:0:\"\";s:15:\"fee_amount_type\";a:2:{s:9:\"fees_type\";s:2:\"-1\";s:11:\"fees_amount\";s:1:\"0\";}s:19:\"min_withdraw_amount\";s:2:\"80\";s:40:\"minimum_days_for_balance_to_be_available\";s:1:\"7\";s:24:\"tutor_withdrawal_methods\";a:3:{s:22:\"bank_transfer_withdraw\";s:22:\"bank_transfer_withdraw\";s:15:\"echeck_withdraw\";s:15:\"echeck_withdraw\";s:15:\"paypal_withdraw\";s:15:\"paypal_withdraw\";}s:40:\"tutor_bank_transfer_withdraw_instruction\";s:0:\"\";s:34:\"tutor_frontend_course_page_logo_id\";s:0:\"\";s:19:\"courses_col_per_row\";s:1:\"4\";s:21:\"course_archive_filter\";s:2:\"on\";s:16:\"courses_per_page\";s:1:\"8\";s:24:\"supported_course_filters\";a:4:{s:6:\"search\";s:6:\"search\";s:8:\"category\";s:8:\"category\";s:3:\"tag\";s:3:\"tag\";s:10:\"price_type\";s:10:\"price_type\";}s:22:\"instructor_list_layout\";s:12:\"pp-left-full\";s:21:\"public_profile_layout\";s:9:\"pp-circle\";s:29:\"student_public_profile_layout\";s:9:\"pp-circle\";s:26:\"display_course_instructors\";s:3:\"off\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:20:\"enable_course_author\";s:3:\"off\";s:19:\"enable_course_level\";s:2:\"on\";s:19:\"enable_course_share\";s:2:\"on\";s:22:\"enable_course_duration\";s:2:\"on\";s:28:\"enable_course_total_enrolled\";s:2:\"on\";s:25:\"enable_course_update_date\";s:2:\"on\";s:26:\"enable_course_progress_bar\";s:2:\"on\";s:22:\"enable_course_material\";s:2:\"on\";s:19:\"enable_course_about\";s:2:\"on\";s:25:\"enable_course_description\";s:2:\"on\";s:22:\"enable_course_benefits\";s:2:\"on\";s:26:\"enable_course_requirements\";s:2:\"on\";s:29:\"enable_course_target_audience\";s:2:\"on\";s:27:\"enable_course_announcements\";s:2:\"on\";s:20:\"enable_course_review\";s:2:\"on\";s:17:\"color_preset_type\";s:6:\"custom\";s:19:\"tutor_primary_color\";s:7:\"#3e64de\";s:25:\"tutor_primary_hover_color\";s:7:\"#28408e\";s:16:\"tutor_text_color\";s:7:\"#1a1b1e\";s:22:\"tutor_background_color\";s:7:\"#f6f8fd\";s:18:\"tutor_border_color\";s:7:\"#cdcfd5\";s:19:\"tutor_success_color\";s:7:\"#24a148\";s:19:\"tutor_warning_color\";s:7:\"#ed9700\";s:18:\"tutor_danger_color\";s:7:\"#d8d8d8\";s:19:\"tutor_disable_color\";s:7:\"#e3e6eb\";s:28:\"tutor_table_background_color\";s:7:\"#eff1f6\";s:30:\"disable_default_player_youtube\";s:3:\"off\";s:28:\"disable_default_player_vimeo\";s:3:\"off\";s:28:\"enable_gutenberg_course_edit\";s:2:\"on\";s:26:\"hide_course_from_shop_page\";s:2:\"on\";s:19:\"course_archive_page\";s:2:\"-1\";s:24:\"instructor_register_page\";s:1:\"8\";s:21:\"student_register_page\";s:1:\"7\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:37:\"lesson_video_duration_youtube_api_key\";s:0:\"\";s:25:\"enable_profile_completion\";s:2:\"on\";s:25:\"enable_tutor_native_login\";s:2:\"on\";s:24:\"hide_admin_bar_for_users\";s:2:\"on\";s:19:\"delete_on_uninstall\";s:3:\"off\";s:29:\"enable_tutor_maintenance_mode\";s:3:\"off\";s:28:\"gradebook_enable_grade_point\";s:2:\"on\";s:26:\"gradebook_show_grade_scale\";s:3:\"off\";s:25:\"gradebook_scale_separator\";s:1:\"/\";s:15:\"gradebook_scale\";s:1:\"6\";s:17:\"email_footer_text\";s:0:\"\";}}s:22:\"tutor-saved-1657719874\";a:4:{s:8:\"datetime\";i:1657719874;s:12:\"history_date\";s:21:\"13 Jul, 2022, 1:44 pm\";s:8:\"datatype\";s:5:\"saved\";s:7:\"dataset\";a:86:{s:23:\"tutor_dashboard_page_id\";s:1:\"6\";s:25:\"enable_course_marketplace\";s:2:\"on\";s:19:\"pagination_per_page\";s:2:\"20\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:28:\"enable_become_instructor_btn\";s:2:\"on\";s:28:\"course_content_access_for_ia\";s:3:\"off\";s:21:\"enable_spotlight_mode\";s:3:\"off\";s:25:\"course_completion_process\";s:8:\"flexible\";s:21:\"course_retake_feature\";s:3:\"off\";s:25:\"enrollment_expiry_enabled\";s:2:\"on\";s:28:\"enable_lesson_classic_editor\";s:2:\"on\";s:28:\"autoload_next_course_content\";s:2:\"on\";s:25:\"enable_comment_for_lesson\";s:3:\"off\";s:22:\"quiz_when_time_expires\";s:12:\"auto_abandon\";s:21:\"quiz_attempts_allowed\";s:3:\"100\";s:28:\"quiz_previous_button_enabled\";s:3:\"off\";s:17:\"quiz_grade_method\";s:13:\"highest_grade\";s:23:\"supported_video_sources\";a:2:{i:0;s:8:\"embedded\";i:1;s:9:\"shortcode\";}s:11:\"monetize_by\";s:2:\"wc\";s:24:\"enable_guest_course_cart\";s:2:\"on\";s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";s:22:\"enable_revenue_sharing\";s:3:\"off\";s:23:\"statement_show_per_page\";s:2:\"20\";s:21:\"enable_fees_deducting\";s:2:\"on\";s:9:\"fees_name\";s:0:\"\";s:15:\"fee_amount_type\";a:2:{s:9:\"fees_type\";s:2:\"-1\";s:11:\"fees_amount\";s:1:\"0\";}s:19:\"min_withdraw_amount\";s:2:\"80\";s:40:\"minimum_days_for_balance_to_be_available\";s:1:\"7\";s:24:\"tutor_withdrawal_methods\";a:3:{s:22:\"bank_transfer_withdraw\";s:22:\"bank_transfer_withdraw\";s:15:\"echeck_withdraw\";s:15:\"echeck_withdraw\";s:15:\"paypal_withdraw\";s:15:\"paypal_withdraw\";}s:40:\"tutor_bank_transfer_withdraw_instruction\";s:0:\"\";s:34:\"tutor_frontend_course_page_logo_id\";s:0:\"\";s:19:\"courses_col_per_row\";s:1:\"4\";s:21:\"course_archive_filter\";s:2:\"on\";s:16:\"courses_per_page\";s:1:\"8\";s:24:\"supported_course_filters\";a:4:{s:6:\"search\";s:6:\"search\";s:8:\"category\";s:8:\"category\";s:3:\"tag\";s:3:\"tag\";s:10:\"price_type\";s:10:\"price_type\";}s:22:\"instructor_list_layout\";s:12:\"pp-left-full\";s:21:\"public_profile_layout\";s:9:\"pp-circle\";s:29:\"student_public_profile_layout\";s:9:\"pp-circle\";s:26:\"display_course_instructors\";s:3:\"off\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:20:\"enable_course_author\";s:3:\"off\";s:19:\"enable_course_level\";s:2:\"on\";s:19:\"enable_course_share\";s:2:\"on\";s:22:\"enable_course_duration\";s:2:\"on\";s:28:\"enable_course_total_enrolled\";s:2:\"on\";s:25:\"enable_course_update_date\";s:2:\"on\";s:26:\"enable_course_progress_bar\";s:2:\"on\";s:22:\"enable_course_material\";s:2:\"on\";s:19:\"enable_course_about\";s:2:\"on\";s:25:\"enable_course_description\";s:2:\"on\";s:22:\"enable_course_benefits\";s:2:\"on\";s:26:\"enable_course_requirements\";s:2:\"on\";s:29:\"enable_course_target_audience\";s:2:\"on\";s:27:\"enable_course_announcements\";s:2:\"on\";s:20:\"enable_course_review\";s:2:\"on\";s:17:\"color_preset_type\";s:6:\"custom\";s:19:\"tutor_primary_color\";s:7:\"#3e64de\";s:25:\"tutor_primary_hover_color\";s:7:\"#28408e\";s:16:\"tutor_text_color\";s:7:\"#1a1b1e\";s:22:\"tutor_background_color\";s:7:\"#f6f8fd\";s:18:\"tutor_border_color\";s:7:\"#cdcfd5\";s:19:\"tutor_success_color\";s:7:\"#24a148\";s:19:\"tutor_warning_color\";s:7:\"#ed9700\";s:18:\"tutor_danger_color\";s:7:\"#d8d8d8\";s:19:\"tutor_disable_color\";s:7:\"#e3e6eb\";s:28:\"tutor_table_background_color\";s:7:\"#eff1f6\";s:30:\"disable_default_player_youtube\";s:3:\"off\";s:28:\"disable_default_player_vimeo\";s:3:\"off\";s:28:\"enable_gutenberg_course_edit\";s:2:\"on\";s:26:\"hide_course_from_shop_page\";s:2:\"on\";s:19:\"course_archive_page\";s:2:\"-1\";s:24:\"instructor_register_page\";s:1:\"8\";s:21:\"student_register_page\";s:1:\"7\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:37:\"lesson_video_duration_youtube_api_key\";s:0:\"\";s:25:\"enable_profile_completion\";s:2:\"on\";s:25:\"enable_tutor_native_login\";s:2:\"on\";s:24:\"hide_admin_bar_for_users\";s:2:\"on\";s:19:\"delete_on_uninstall\";s:3:\"off\";s:29:\"enable_tutor_maintenance_mode\";s:3:\"off\";s:28:\"gradebook_enable_grade_point\";s:2:\"on\";s:26:\"gradebook_show_grade_scale\";s:3:\"off\";s:25:\"gradebook_scale_separator\";s:1:\"/\";s:15:\"gradebook_scale\";s:1:\"6\";s:17:\"email_footer_text\";s:0:\"\";}}s:22:\"tutor-saved-1657719840\";a:4:{s:8:\"datetime\";i:1657719840;s:12:\"history_date\";s:21:\"13 Jul, 2022, 1:44 pm\";s:8:\"datatype\";s:5:\"saved\";s:7:\"dataset\";a:86:{s:23:\"tutor_dashboard_page_id\";s:1:\"6\";s:25:\"enable_course_marketplace\";s:2:\"on\";s:19:\"pagination_per_page\";s:2:\"20\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:28:\"enable_become_instructor_btn\";s:2:\"on\";s:28:\"course_content_access_for_ia\";s:3:\"off\";s:21:\"enable_spotlight_mode\";s:3:\"off\";s:25:\"course_completion_process\";s:8:\"flexible\";s:21:\"course_retake_feature\";s:3:\"off\";s:25:\"enrollment_expiry_enabled\";s:2:\"on\";s:28:\"enable_lesson_classic_editor\";s:2:\"on\";s:28:\"autoload_next_course_content\";s:2:\"on\";s:25:\"enable_comment_for_lesson\";s:3:\"off\";s:22:\"quiz_when_time_expires\";s:12:\"auto_abandon\";s:21:\"quiz_attempts_allowed\";s:3:\"100\";s:28:\"quiz_previous_button_enabled\";s:3:\"off\";s:17:\"quiz_grade_method\";s:13:\"highest_grade\";s:23:\"supported_video_sources\";a:2:{i:0;s:8:\"embedded\";i:1;s:9:\"shortcode\";}s:11:\"monetize_by\";s:4:\"free\";s:24:\"enable_guest_course_cart\";s:2:\"on\";s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";s:22:\"enable_revenue_sharing\";s:3:\"off\";s:23:\"statement_show_per_page\";s:2:\"20\";s:21:\"enable_fees_deducting\";s:2:\"on\";s:9:\"fees_name\";s:0:\"\";s:15:\"fee_amount_type\";a:2:{s:9:\"fees_type\";s:2:\"-1\";s:11:\"fees_amount\";s:1:\"0\";}s:19:\"min_withdraw_amount\";s:2:\"80\";s:40:\"minimum_days_for_balance_to_be_available\";s:1:\"7\";s:24:\"tutor_withdrawal_methods\";a:3:{s:22:\"bank_transfer_withdraw\";s:22:\"bank_transfer_withdraw\";s:15:\"echeck_withdraw\";s:15:\"echeck_withdraw\";s:15:\"paypal_withdraw\";s:15:\"paypal_withdraw\";}s:40:\"tutor_bank_transfer_withdraw_instruction\";s:0:\"\";s:34:\"tutor_frontend_course_page_logo_id\";s:0:\"\";s:19:\"courses_col_per_row\";s:1:\"4\";s:21:\"course_archive_filter\";s:2:\"on\";s:16:\"courses_per_page\";s:1:\"8\";s:24:\"supported_course_filters\";a:4:{s:6:\"search\";s:6:\"search\";s:8:\"category\";s:8:\"category\";s:3:\"tag\";s:3:\"tag\";s:10:\"price_type\";s:10:\"price_type\";}s:22:\"instructor_list_layout\";s:12:\"pp-left-full\";s:21:\"public_profile_layout\";s:9:\"pp-circle\";s:29:\"student_public_profile_layout\";s:9:\"pp-circle\";s:26:\"display_course_instructors\";s:3:\"off\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:20:\"enable_course_author\";s:3:\"off\";s:19:\"enable_course_level\";s:2:\"on\";s:19:\"enable_course_share\";s:2:\"on\";s:22:\"enable_course_duration\";s:2:\"on\";s:28:\"enable_course_total_enrolled\";s:2:\"on\";s:25:\"enable_course_update_date\";s:2:\"on\";s:26:\"enable_course_progress_bar\";s:2:\"on\";s:22:\"enable_course_material\";s:2:\"on\";s:19:\"enable_course_about\";s:2:\"on\";s:25:\"enable_course_description\";s:2:\"on\";s:22:\"enable_course_benefits\";s:2:\"on\";s:26:\"enable_course_requirements\";s:2:\"on\";s:29:\"enable_course_target_audience\";s:2:\"on\";s:27:\"enable_course_announcements\";s:2:\"on\";s:20:\"enable_course_review\";s:2:\"on\";s:17:\"color_preset_type\";s:6:\"custom\";s:19:\"tutor_primary_color\";s:7:\"#3e64de\";s:25:\"tutor_primary_hover_color\";s:7:\"#28408e\";s:16:\"tutor_text_color\";s:7:\"#1a1b1e\";s:22:\"tutor_background_color\";s:7:\"#f6f8fd\";s:18:\"tutor_border_color\";s:7:\"#cdcfd5\";s:19:\"tutor_success_color\";s:7:\"#24a148\";s:19:\"tutor_warning_color\";s:7:\"#ed9700\";s:18:\"tutor_danger_color\";s:7:\"#d8d8d8\";s:19:\"tutor_disable_color\";s:7:\"#e3e6eb\";s:28:\"tutor_table_background_color\";s:7:\"#eff1f6\";s:30:\"disable_default_player_youtube\";s:3:\"off\";s:28:\"disable_default_player_vimeo\";s:3:\"off\";s:28:\"enable_gutenberg_course_edit\";s:2:\"on\";s:26:\"hide_course_from_shop_page\";s:2:\"on\";s:19:\"course_archive_page\";s:2:\"-1\";s:24:\"instructor_register_page\";s:1:\"8\";s:21:\"student_register_page\";s:1:\"7\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:37:\"lesson_video_duration_youtube_api_key\";s:0:\"\";s:25:\"enable_profile_completion\";s:2:\"on\";s:25:\"enable_tutor_native_login\";s:2:\"on\";s:24:\"hide_admin_bar_for_users\";s:2:\"on\";s:19:\"delete_on_uninstall\";s:3:\"off\";s:29:\"enable_tutor_maintenance_mode\";s:3:\"off\";s:28:\"gradebook_enable_grade_point\";s:2:\"on\";s:26:\"gradebook_show_grade_scale\";s:3:\"off\";s:25:\"gradebook_scale_separator\";s:1:\"/\";s:15:\"gradebook_scale\";s:1:\"6\";s:17:\"email_footer_text\";s:0:\"\";}}s:22:\"tutor-saved-1657719763\";a:4:{s:8:\"datetime\";i:1657719763;s:12:\"history_date\";s:21:\"13 Jul, 2022, 1:42 pm\";s:8:\"datatype\";s:5:\"saved\";s:7:\"dataset\";a:86:{s:23:\"tutor_dashboard_page_id\";s:1:\"6\";s:25:\"enable_course_marketplace\";s:3:\"off\";s:19:\"pagination_per_page\";s:2:\"20\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:28:\"enable_become_instructor_btn\";s:2:\"on\";s:28:\"course_content_access_for_ia\";s:3:\"off\";s:21:\"enable_spotlight_mode\";s:3:\"off\";s:25:\"course_completion_process\";s:8:\"flexible\";s:21:\"course_retake_feature\";s:3:\"off\";s:25:\"enrollment_expiry_enabled\";s:2:\"on\";s:28:\"enable_lesson_classic_editor\";s:2:\"on\";s:28:\"autoload_next_course_content\";s:2:\"on\";s:25:\"enable_comment_for_lesson\";s:3:\"off\";s:22:\"quiz_when_time_expires\";s:12:\"auto_abandon\";s:21:\"quiz_attempts_allowed\";s:3:\"100\";s:28:\"quiz_previous_button_enabled\";s:3:\"off\";s:17:\"quiz_grade_method\";s:13:\"highest_grade\";s:23:\"supported_video_sources\";a:2:{i:0;s:8:\"embedded\";i:1;s:9:\"shortcode\";}s:11:\"monetize_by\";s:4:\"free\";s:24:\"enable_guest_course_cart\";s:2:\"on\";s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";s:22:\"enable_revenue_sharing\";s:3:\"off\";s:23:\"statement_show_per_page\";s:2:\"20\";s:21:\"enable_fees_deducting\";s:2:\"on\";s:9:\"fees_name\";s:0:\"\";s:15:\"fee_amount_type\";a:2:{s:9:\"fees_type\";s:2:\"-1\";s:11:\"fees_amount\";s:1:\"0\";}s:19:\"min_withdraw_amount\";s:2:\"80\";s:40:\"minimum_days_for_balance_to_be_available\";s:1:\"7\";s:24:\"tutor_withdrawal_methods\";a:3:{s:22:\"bank_transfer_withdraw\";s:22:\"bank_transfer_withdraw\";s:15:\"echeck_withdraw\";s:15:\"echeck_withdraw\";s:15:\"paypal_withdraw\";s:15:\"paypal_withdraw\";}s:40:\"tutor_bank_transfer_withdraw_instruction\";s:0:\"\";s:34:\"tutor_frontend_course_page_logo_id\";s:0:\"\";s:19:\"courses_col_per_row\";s:1:\"4\";s:21:\"course_archive_filter\";s:2:\"on\";s:16:\"courses_per_page\";s:1:\"8\";s:24:\"supported_course_filters\";a:4:{s:6:\"search\";s:6:\"search\";s:8:\"category\";s:8:\"category\";s:3:\"tag\";s:3:\"tag\";s:10:\"price_type\";s:10:\"price_type\";}s:22:\"instructor_list_layout\";s:12:\"pp-left-full\";s:21:\"public_profile_layout\";s:9:\"pp-circle\";s:29:\"student_public_profile_layout\";s:9:\"pp-circle\";s:26:\"display_course_instructors\";s:3:\"off\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:20:\"enable_course_author\";s:3:\"off\";s:19:\"enable_course_level\";s:2:\"on\";s:19:\"enable_course_share\";s:2:\"on\";s:22:\"enable_course_duration\";s:2:\"on\";s:28:\"enable_course_total_enrolled\";s:2:\"on\";s:25:\"enable_course_update_date\";s:2:\"on\";s:26:\"enable_course_progress_bar\";s:2:\"on\";s:22:\"enable_course_material\";s:2:\"on\";s:19:\"enable_course_about\";s:2:\"on\";s:25:\"enable_course_description\";s:2:\"on\";s:22:\"enable_course_benefits\";s:2:\"on\";s:26:\"enable_course_requirements\";s:2:\"on\";s:29:\"enable_course_target_audience\";s:2:\"on\";s:27:\"enable_course_announcements\";s:2:\"on\";s:20:\"enable_course_review\";s:2:\"on\";s:17:\"color_preset_type\";s:6:\"custom\";s:19:\"tutor_primary_color\";s:7:\"#3e64de\";s:25:\"tutor_primary_hover_color\";s:7:\"#28408e\";s:16:\"tutor_text_color\";s:7:\"#1a1b1e\";s:22:\"tutor_background_color\";s:7:\"#f6f8fd\";s:18:\"tutor_border_color\";s:7:\"#cdcfd5\";s:19:\"tutor_success_color\";s:7:\"#24a148\";s:19:\"tutor_warning_color\";s:7:\"#ed9700\";s:18:\"tutor_danger_color\";s:7:\"#d8d8d8\";s:19:\"tutor_disable_color\";s:7:\"#e3e6eb\";s:28:\"tutor_table_background_color\";s:7:\"#eff1f6\";s:30:\"disable_default_player_youtube\";s:3:\"off\";s:28:\"disable_default_player_vimeo\";s:3:\"off\";s:28:\"enable_gutenberg_course_edit\";s:2:\"on\";s:26:\"hide_course_from_shop_page\";s:2:\"on\";s:19:\"course_archive_page\";s:2:\"-1\";s:24:\"instructor_register_page\";s:1:\"8\";s:21:\"student_register_page\";s:1:\"7\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:37:\"lesson_video_duration_youtube_api_key\";s:0:\"\";s:25:\"enable_profile_completion\";s:2:\"on\";s:25:\"enable_tutor_native_login\";s:2:\"on\";s:24:\"hide_admin_bar_for_users\";s:2:\"on\";s:19:\"delete_on_uninstall\";s:3:\"off\";s:29:\"enable_tutor_maintenance_mode\";s:3:\"off\";s:28:\"gradebook_enable_grade_point\";s:2:\"on\";s:26:\"gradebook_show_grade_scale\";s:3:\"off\";s:25:\"gradebook_scale_separator\";s:1:\"/\";s:15:\"gradebook_scale\";s:1:\"6\";s:17:\"email_footer_text\";s:0:\"\";}}s:22:\"tutor-saved-1657719727\";a:4:{s:8:\"datetime\";i:1657719727;s:12:\"history_date\";s:21:\"13 Jul, 2022, 1:42 pm\";s:8:\"datatype\";s:5:\"saved\";s:7:\"dataset\";a:86:{s:23:\"tutor_dashboard_page_id\";s:1:\"6\";s:25:\"enable_course_marketplace\";s:3:\"off\";s:19:\"pagination_per_page\";s:2:\"20\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:28:\"enable_become_instructor_btn\";s:2:\"on\";s:28:\"course_content_access_for_ia\";s:3:\"off\";s:21:\"enable_spotlight_mode\";s:3:\"off\";s:25:\"course_completion_process\";s:8:\"flexible\";s:21:\"course_retake_feature\";s:3:\"off\";s:25:\"enrollment_expiry_enabled\";s:2:\"on\";s:28:\"enable_lesson_classic_editor\";s:2:\"on\";s:28:\"autoload_next_course_content\";s:2:\"on\";s:25:\"enable_comment_for_lesson\";s:3:\"off\";s:22:\"quiz_when_time_expires\";s:12:\"auto_abandon\";s:21:\"quiz_attempts_allowed\";s:3:\"100\";s:28:\"quiz_previous_button_enabled\";s:3:\"off\";s:17:\"quiz_grade_method\";s:13:\"highest_grade\";s:23:\"supported_video_sources\";a:2:{i:0;s:8:\"embedded\";i:1;s:9:\"shortcode\";}s:11:\"monetize_by\";s:4:\"free\";s:24:\"enable_guest_course_cart\";s:2:\"on\";s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";s:22:\"enable_revenue_sharing\";s:3:\"off\";s:23:\"statement_show_per_page\";s:2:\"20\";s:21:\"enable_fees_deducting\";s:2:\"on\";s:9:\"fees_name\";s:0:\"\";s:15:\"fee_amount_type\";a:2:{s:9:\"fees_type\";s:2:\"-1\";s:11:\"fees_amount\";s:1:\"0\";}s:19:\"min_withdraw_amount\";s:2:\"80\";s:40:\"minimum_days_for_balance_to_be_available\";s:1:\"7\";s:24:\"tutor_withdrawal_methods\";a:3:{s:22:\"bank_transfer_withdraw\";s:22:\"bank_transfer_withdraw\";s:15:\"echeck_withdraw\";s:15:\"echeck_withdraw\";s:15:\"paypal_withdraw\";s:15:\"paypal_withdraw\";}s:40:\"tutor_bank_transfer_withdraw_instruction\";s:0:\"\";s:34:\"tutor_frontend_course_page_logo_id\";s:0:\"\";s:19:\"courses_col_per_row\";s:1:\"4\";s:21:\"course_archive_filter\";s:2:\"on\";s:16:\"courses_per_page\";s:1:\"8\";s:24:\"supported_course_filters\";a:4:{s:6:\"search\";s:6:\"search\";s:8:\"category\";s:8:\"category\";s:3:\"tag\";s:3:\"tag\";s:10:\"price_type\";s:10:\"price_type\";}s:22:\"instructor_list_layout\";s:12:\"pp-left-full\";s:21:\"public_profile_layout\";s:9:\"pp-circle\";s:29:\"student_public_profile_layout\";s:9:\"pp-circle\";s:26:\"display_course_instructors\";s:3:\"off\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:20:\"enable_course_author\";s:3:\"off\";s:19:\"enable_course_level\";s:2:\"on\";s:19:\"enable_course_share\";s:2:\"on\";s:22:\"enable_course_duration\";s:2:\"on\";s:28:\"enable_course_total_enrolled\";s:2:\"on\";s:25:\"enable_course_update_date\";s:2:\"on\";s:26:\"enable_course_progress_bar\";s:2:\"on\";s:22:\"enable_course_material\";s:2:\"on\";s:19:\"enable_course_about\";s:2:\"on\";s:25:\"enable_course_description\";s:2:\"on\";s:22:\"enable_course_benefits\";s:2:\"on\";s:26:\"enable_course_requirements\";s:2:\"on\";s:29:\"enable_course_target_audience\";s:2:\"on\";s:27:\"enable_course_announcements\";s:2:\"on\";s:20:\"enable_course_review\";s:2:\"on\";s:17:\"color_preset_type\";s:6:\"custom\";s:19:\"tutor_primary_color\";s:7:\"#3e64de\";s:25:\"tutor_primary_hover_color\";s:7:\"#28408e\";s:16:\"tutor_text_color\";s:7:\"#1a1b1e\";s:22:\"tutor_background_color\";s:7:\"#f6f8fd\";s:18:\"tutor_border_color\";s:7:\"#cdcfd5\";s:19:\"tutor_success_color\";s:7:\"#24a148\";s:19:\"tutor_warning_color\";s:7:\"#ed9700\";s:18:\"tutor_danger_color\";s:7:\"#d8d8d8\";s:19:\"tutor_disable_color\";s:7:\"#e3e6eb\";s:28:\"tutor_table_background_color\";s:7:\"#eff1f6\";s:30:\"disable_default_player_youtube\";s:3:\"off\";s:28:\"disable_default_player_vimeo\";s:3:\"off\";s:28:\"enable_gutenberg_course_edit\";s:2:\"on\";s:26:\"hide_course_from_shop_page\";s:2:\"on\";s:19:\"course_archive_page\";s:2:\"-1\";s:24:\"instructor_register_page\";s:1:\"8\";s:21:\"student_register_page\";s:1:\"7\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:37:\"lesson_video_duration_youtube_api_key\";s:0:\"\";s:25:\"enable_profile_completion\";s:2:\"on\";s:25:\"enable_tutor_native_login\";s:2:\"on\";s:24:\"hide_admin_bar_for_users\";s:2:\"on\";s:19:\"delete_on_uninstall\";s:3:\"off\";s:29:\"enable_tutor_maintenance_mode\";s:3:\"off\";s:28:\"gradebook_enable_grade_point\";s:3:\"off\";s:26:\"gradebook_show_grade_scale\";s:3:\"off\";s:25:\"gradebook_scale_separator\";s:1:\"/\";s:15:\"gradebook_scale\";s:3:\"4.0\";s:17:\"email_footer_text\";s:0:\"\";}}s:22:\"tutor-saved-1657719696\";a:4:{s:8:\"datetime\";i:1657719696;s:12:\"history_date\";s:21:\"13 Jul, 2022, 1:41 pm\";s:8:\"datatype\";s:5:\"saved\";s:7:\"dataset\";a:86:{s:23:\"tutor_dashboard_page_id\";s:1:\"6\";s:25:\"enable_course_marketplace\";s:3:\"off\";s:19:\"pagination_per_page\";s:2:\"20\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:28:\"enable_become_instructor_btn\";s:2:\"on\";s:28:\"course_content_access_for_ia\";s:3:\"off\";s:21:\"enable_spotlight_mode\";s:3:\"off\";s:25:\"course_completion_process\";s:8:\"flexible\";s:21:\"course_retake_feature\";s:3:\"off\";s:25:\"enrollment_expiry_enabled\";s:2:\"on\";s:28:\"enable_lesson_classic_editor\";s:2:\"on\";s:28:\"autoload_next_course_content\";s:2:\"on\";s:25:\"enable_comment_for_lesson\";s:3:\"off\";s:22:\"quiz_when_time_expires\";s:12:\"auto_abandon\";s:21:\"quiz_attempts_allowed\";s:3:\"100\";s:28:\"quiz_previous_button_enabled\";s:3:\"off\";s:17:\"quiz_grade_method\";s:13:\"highest_grade\";s:23:\"supported_video_sources\";a:2:{i:0;s:8:\"embedded\";i:1;s:9:\"shortcode\";}s:11:\"monetize_by\";s:4:\"free\";s:24:\"enable_guest_course_cart\";s:2:\"on\";s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";s:22:\"enable_revenue_sharing\";s:3:\"off\";s:23:\"statement_show_per_page\";s:2:\"20\";s:21:\"enable_fees_deducting\";s:2:\"on\";s:9:\"fees_name\";s:0:\"\";s:15:\"fee_amount_type\";a:2:{s:9:\"fees_type\";s:2:\"-1\";s:11:\"fees_amount\";s:1:\"0\";}s:19:\"min_withdraw_amount\";s:2:\"80\";s:40:\"minimum_days_for_balance_to_be_available\";s:1:\"7\";s:24:\"tutor_withdrawal_methods\";a:3:{s:22:\"bank_transfer_withdraw\";s:22:\"bank_transfer_withdraw\";s:15:\"echeck_withdraw\";s:15:\"echeck_withdraw\";s:15:\"paypal_withdraw\";s:15:\"paypal_withdraw\";}s:40:\"tutor_bank_transfer_withdraw_instruction\";s:0:\"\";s:34:\"tutor_frontend_course_page_logo_id\";s:0:\"\";s:19:\"courses_col_per_row\";s:1:\"4\";s:21:\"course_archive_filter\";s:2:\"on\";s:16:\"courses_per_page\";s:1:\"8\";s:24:\"supported_course_filters\";a:4:{s:6:\"search\";s:6:\"search\";s:8:\"category\";s:8:\"category\";s:3:\"tag\";s:3:\"tag\";s:10:\"price_type\";s:10:\"price_type\";}s:22:\"instructor_list_layout\";s:12:\"pp-left-full\";s:21:\"public_profile_layout\";s:9:\"pp-circle\";s:29:\"student_public_profile_layout\";s:9:\"pp-circle\";s:26:\"display_course_instructors\";s:3:\"off\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:20:\"enable_course_author\";s:3:\"off\";s:19:\"enable_course_level\";s:2:\"on\";s:19:\"enable_course_share\";s:2:\"on\";s:22:\"enable_course_duration\";s:2:\"on\";s:28:\"enable_course_total_enrolled\";s:2:\"on\";s:25:\"enable_course_update_date\";s:2:\"on\";s:26:\"enable_course_progress_bar\";s:2:\"on\";s:22:\"enable_course_material\";s:2:\"on\";s:19:\"enable_course_about\";s:2:\"on\";s:25:\"enable_course_description\";s:2:\"on\";s:22:\"enable_course_benefits\";s:2:\"on\";s:26:\"enable_course_requirements\";s:2:\"on\";s:29:\"enable_course_target_audience\";s:2:\"on\";s:27:\"enable_course_announcements\";s:2:\"on\";s:20:\"enable_course_review\";s:2:\"on\";s:17:\"color_preset_type\";s:6:\"custom\";s:19:\"tutor_primary_color\";s:7:\"#3e64de\";s:25:\"tutor_primary_hover_color\";s:7:\"#28408e\";s:16:\"tutor_text_color\";s:7:\"#1a1b1e\";s:22:\"tutor_background_color\";s:7:\"#f6f8fd\";s:18:\"tutor_border_color\";s:7:\"#cdcfd5\";s:19:\"tutor_success_color\";s:7:\"#24a148\";s:19:\"tutor_warning_color\";s:7:\"#ed9700\";s:18:\"tutor_danger_color\";s:7:\"#d8d8d8\";s:19:\"tutor_disable_color\";s:7:\"#e3e6eb\";s:28:\"tutor_table_background_color\";s:7:\"#eff1f6\";s:30:\"disable_default_player_youtube\";s:3:\"off\";s:28:\"disable_default_player_vimeo\";s:3:\"off\";s:28:\"enable_gutenberg_course_edit\";s:2:\"on\";s:26:\"hide_course_from_shop_page\";s:3:\"off\";s:19:\"course_archive_page\";s:2:\"-1\";s:24:\"instructor_register_page\";s:1:\"8\";s:21:\"student_register_page\";s:1:\"7\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:37:\"lesson_video_duration_youtube_api_key\";s:0:\"\";s:25:\"enable_profile_completion\";s:2:\"on\";s:25:\"enable_tutor_native_login\";s:2:\"on\";s:24:\"hide_admin_bar_for_users\";s:2:\"on\";s:19:\"delete_on_uninstall\";s:3:\"off\";s:29:\"enable_tutor_maintenance_mode\";s:3:\"off\";s:28:\"gradebook_enable_grade_point\";s:3:\"off\";s:26:\"gradebook_show_grade_scale\";s:3:\"off\";s:25:\"gradebook_scale_separator\";s:1:\"/\";s:15:\"gradebook_scale\";s:3:\"4.0\";s:17:\"email_footer_text\";s:0:\"\";}}s:22:\"tutor-saved-1657704033\";a:4:{s:8:\"datetime\";i:1657704033;s:12:\"history_date\";s:21:\"13 Jul, 2022, 9:20 am\";s:8:\"datatype\";s:5:\"saved\";s:7:\"dataset\";a:86:{s:23:\"tutor_dashboard_page_id\";s:1:\"6\";s:25:\"enable_course_marketplace\";s:3:\"off\";s:19:\"pagination_per_page\";s:2:\"20\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:28:\"enable_become_instructor_btn\";s:2:\"on\";s:28:\"course_content_access_for_ia\";s:3:\"off\";s:21:\"enable_spotlight_mode\";s:3:\"off\";s:25:\"course_completion_process\";s:8:\"flexible\";s:21:\"course_retake_feature\";s:3:\"off\";s:25:\"enrollment_expiry_enabled\";s:2:\"on\";s:28:\"enable_lesson_classic_editor\";s:2:\"on\";s:28:\"autoload_next_course_content\";s:2:\"on\";s:25:\"enable_comment_for_lesson\";s:3:\"off\";s:22:\"quiz_when_time_expires\";s:12:\"auto_abandon\";s:21:\"quiz_attempts_allowed\";s:3:\"100\";s:28:\"quiz_previous_button_enabled\";s:3:\"off\";s:17:\"quiz_grade_method\";s:13:\"highest_grade\";s:23:\"supported_video_sources\";a:2:{i:0;s:8:\"embedded\";i:1;s:9:\"shortcode\";}s:11:\"monetize_by\";s:4:\"free\";s:24:\"enable_guest_course_cart\";s:2:\"on\";s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";s:22:\"enable_revenue_sharing\";s:3:\"off\";s:23:\"statement_show_per_page\";s:2:\"20\";s:21:\"enable_fees_deducting\";s:3:\"off\";s:9:\"fees_name\";s:0:\"\";s:15:\"fee_amount_type\";a:2:{s:9:\"fees_type\";s:5:\"fixed\";s:11:\"fees_amount\";s:1:\"0\";}s:19:\"min_withdraw_amount\";s:2:\"80\";s:40:\"minimum_days_for_balance_to_be_available\";s:1:\"7\";s:24:\"tutor_withdrawal_methods\";a:3:{s:22:\"bank_transfer_withdraw\";s:22:\"bank_transfer_withdraw\";s:15:\"echeck_withdraw\";s:15:\"echeck_withdraw\";s:15:\"paypal_withdraw\";s:15:\"paypal_withdraw\";}s:40:\"tutor_bank_transfer_withdraw_instruction\";s:0:\"\";s:34:\"tutor_frontend_course_page_logo_id\";s:0:\"\";s:19:\"courses_col_per_row\";s:1:\"4\";s:21:\"course_archive_filter\";s:2:\"on\";s:16:\"courses_per_page\";s:1:\"8\";s:24:\"supported_course_filters\";a:4:{s:6:\"search\";s:6:\"search\";s:8:\"category\";s:8:\"category\";s:3:\"tag\";s:3:\"tag\";s:10:\"price_type\";s:10:\"price_type\";}s:22:\"instructor_list_layout\";s:12:\"pp-left-full\";s:21:\"public_profile_layout\";s:9:\"pp-circle\";s:29:\"student_public_profile_layout\";s:9:\"pp-circle\";s:26:\"display_course_instructors\";s:3:\"off\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:20:\"enable_course_author\";s:3:\"off\";s:19:\"enable_course_level\";s:2:\"on\";s:19:\"enable_course_share\";s:2:\"on\";s:22:\"enable_course_duration\";s:2:\"on\";s:28:\"enable_course_total_enrolled\";s:2:\"on\";s:25:\"enable_course_update_date\";s:2:\"on\";s:26:\"enable_course_progress_bar\";s:2:\"on\";s:22:\"enable_course_material\";s:2:\"on\";s:19:\"enable_course_about\";s:2:\"on\";s:25:\"enable_course_description\";s:2:\"on\";s:22:\"enable_course_benefits\";s:2:\"on\";s:26:\"enable_course_requirements\";s:2:\"on\";s:29:\"enable_course_target_audience\";s:2:\"on\";s:27:\"enable_course_announcements\";s:2:\"on\";s:20:\"enable_course_review\";s:2:\"on\";s:17:\"color_preset_type\";s:6:\"custom\";s:19:\"tutor_primary_color\";s:7:\"#3e64de\";s:25:\"tutor_primary_hover_color\";s:7:\"#28408e\";s:16:\"tutor_text_color\";s:7:\"#1a1b1e\";s:22:\"tutor_background_color\";s:7:\"#f6f8fd\";s:18:\"tutor_border_color\";s:7:\"#cdcfd5\";s:19:\"tutor_success_color\";s:7:\"#24a148\";s:19:\"tutor_warning_color\";s:7:\"#ed9700\";s:18:\"tutor_danger_color\";s:7:\"#d8d8d8\";s:19:\"tutor_disable_color\";s:7:\"#e3e6eb\";s:28:\"tutor_table_background_color\";s:7:\"#eff1f6\";s:30:\"disable_default_player_youtube\";s:3:\"off\";s:28:\"disable_default_player_vimeo\";s:3:\"off\";s:28:\"enable_gutenberg_course_edit\";s:2:\"on\";s:26:\"hide_course_from_shop_page\";s:3:\"off\";s:19:\"course_archive_page\";s:2:\"-1\";s:24:\"instructor_register_page\";s:1:\"8\";s:21:\"student_register_page\";s:1:\"7\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:37:\"lesson_video_duration_youtube_api_key\";s:0:\"\";s:25:\"enable_profile_completion\";s:2:\"on\";s:25:\"enable_tutor_native_login\";s:2:\"on\";s:24:\"hide_admin_bar_for_users\";s:2:\"on\";s:19:\"delete_on_uninstall\";s:3:\"off\";s:29:\"enable_tutor_maintenance_mode\";s:3:\"off\";s:28:\"gradebook_enable_grade_point\";s:3:\"off\";s:26:\"gradebook_show_grade_scale\";s:3:\"off\";s:25:\"gradebook_scale_separator\";s:1:\"/\";s:15:\"gradebook_scale\";s:3:\"4.0\";s:17:\"email_footer_text\";s:0:\"\";}}s:22:\"tutor-saved-1657703829\";a:4:{s:8:\"datetime\";i:1657703829;s:12:\"history_date\";s:21:\"13 Jul, 2022, 9:17 am\";s:8:\"datatype\";s:5:\"saved\";s:7:\"dataset\";a:86:{s:23:\"tutor_dashboard_page_id\";s:1:\"6\";s:25:\"enable_course_marketplace\";s:3:\"off\";s:19:\"pagination_per_page\";s:2:\"20\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:28:\"enable_become_instructor_btn\";s:2:\"on\";s:28:\"course_content_access_for_ia\";s:3:\"off\";s:21:\"enable_spotlight_mode\";s:3:\"off\";s:25:\"course_completion_process\";s:8:\"flexible\";s:21:\"course_retake_feature\";s:3:\"off\";s:25:\"enrollment_expiry_enabled\";s:2:\"on\";s:28:\"enable_lesson_classic_editor\";s:2:\"on\";s:28:\"autoload_next_course_content\";s:2:\"on\";s:25:\"enable_comment_for_lesson\";s:3:\"off\";s:22:\"quiz_when_time_expires\";s:12:\"auto_abandon\";s:21:\"quiz_attempts_allowed\";s:3:\"100\";s:28:\"quiz_previous_button_enabled\";s:3:\"off\";s:17:\"quiz_grade_method\";s:13:\"highest_grade\";s:23:\"supported_video_sources\";a:2:{i:0;s:8:\"embedded\";i:1;s:9:\"shortcode\";}s:11:\"monetize_by\";s:4:\"free\";s:24:\"enable_guest_course_cart\";s:2:\"on\";s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";s:22:\"enable_revenue_sharing\";s:3:\"off\";s:23:\"statement_show_per_page\";s:2:\"20\";s:21:\"enable_fees_deducting\";s:3:\"off\";s:9:\"fees_name\";s:0:\"\";s:15:\"fee_amount_type\";a:2:{s:9:\"fees_type\";s:5:\"fixed\";s:11:\"fees_amount\";s:1:\"0\";}s:19:\"min_withdraw_amount\";s:2:\"80\";s:40:\"minimum_days_for_balance_to_be_available\";s:1:\"7\";s:24:\"tutor_withdrawal_methods\";a:3:{s:22:\"bank_transfer_withdraw\";s:22:\"bank_transfer_withdraw\";s:15:\"echeck_withdraw\";s:15:\"echeck_withdraw\";s:15:\"paypal_withdraw\";s:15:\"paypal_withdraw\";}s:40:\"tutor_bank_transfer_withdraw_instruction\";s:0:\"\";s:34:\"tutor_frontend_course_page_logo_id\";s:0:\"\";s:19:\"courses_col_per_row\";s:1:\"4\";s:21:\"course_archive_filter\";s:3:\"off\";s:16:\"courses_per_page\";s:1:\"8\";s:24:\"supported_course_filters\";a:2:{s:6:\"search\";s:6:\"search\";s:8:\"category\";s:8:\"category\";}s:22:\"instructor_list_layout\";s:12:\"pp-left-full\";s:21:\"public_profile_layout\";s:9:\"pp-circle\";s:29:\"student_public_profile_layout\";s:9:\"pp-circle\";s:26:\"display_course_instructors\";s:2:\"on\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:20:\"enable_course_author\";s:3:\"off\";s:19:\"enable_course_level\";s:2:\"on\";s:19:\"enable_course_share\";s:2:\"on\";s:22:\"enable_course_duration\";s:2:\"on\";s:28:\"enable_course_total_enrolled\";s:2:\"on\";s:25:\"enable_course_update_date\";s:2:\"on\";s:26:\"enable_course_progress_bar\";s:2:\"on\";s:22:\"enable_course_material\";s:2:\"on\";s:19:\"enable_course_about\";s:2:\"on\";s:25:\"enable_course_description\";s:2:\"on\";s:22:\"enable_course_benefits\";s:2:\"on\";s:26:\"enable_course_requirements\";s:2:\"on\";s:29:\"enable_course_target_audience\";s:2:\"on\";s:27:\"enable_course_announcements\";s:2:\"on\";s:20:\"enable_course_review\";s:2:\"on\";s:17:\"color_preset_type\";s:6:\"custom\";s:19:\"tutor_primary_color\";s:7:\"#3e64de\";s:25:\"tutor_primary_hover_color\";s:7:\"#28408e\";s:16:\"tutor_text_color\";s:7:\"#1a1b1e\";s:22:\"tutor_background_color\";s:7:\"#f6f8fd\";s:18:\"tutor_border_color\";s:7:\"#cdcfd5\";s:19:\"tutor_success_color\";s:7:\"#24a148\";s:19:\"tutor_warning_color\";s:7:\"#ed9700\";s:18:\"tutor_danger_color\";s:7:\"#d8d8d8\";s:19:\"tutor_disable_color\";s:7:\"#e3e6eb\";s:28:\"tutor_table_background_color\";s:7:\"#eff1f6\";s:30:\"disable_default_player_youtube\";s:3:\"off\";s:28:\"disable_default_player_vimeo\";s:3:\"off\";s:28:\"enable_gutenberg_course_edit\";s:2:\"on\";s:26:\"hide_course_from_shop_page\";s:3:\"off\";s:19:\"course_archive_page\";s:2:\"-1\";s:24:\"instructor_register_page\";s:1:\"8\";s:21:\"student_register_page\";s:1:\"7\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:37:\"lesson_video_duration_youtube_api_key\";s:0:\"\";s:25:\"enable_profile_completion\";s:2:\"on\";s:25:\"enable_tutor_native_login\";s:2:\"on\";s:24:\"hide_admin_bar_for_users\";s:2:\"on\";s:19:\"delete_on_uninstall\";s:3:\"off\";s:29:\"enable_tutor_maintenance_mode\";s:3:\"off\";s:28:\"gradebook_enable_grade_point\";s:3:\"off\";s:26:\"gradebook_show_grade_scale\";s:3:\"off\";s:25:\"gradebook_scale_separator\";s:1:\"/\";s:15:\"gradebook_scale\";s:3:\"4.0\";s:17:\"email_footer_text\";s:0:\"\";}}s:22:\"tutor-saved-1656666882\";a:4:{s:8:\"datetime\";i:1656666882;s:12:\"history_date\";s:20:\"1 Jul, 2022, 9:14 am\";s:8:\"datatype\";s:5:\"saved\";s:7:\"dataset\";a:81:{s:23:\"tutor_dashboard_page_id\";s:1:\"6\";s:25:\"enable_course_marketplace\";s:3:\"off\";s:19:\"pagination_per_page\";s:2:\"20\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:28:\"enable_become_instructor_btn\";s:2:\"on\";s:28:\"course_content_access_for_ia\";s:3:\"off\";s:21:\"enable_spotlight_mode\";s:3:\"off\";s:25:\"course_completion_process\";s:8:\"flexible\";s:21:\"course_retake_feature\";s:3:\"off\";s:25:\"enrollment_expiry_enabled\";s:2:\"on\";s:28:\"enable_lesson_classic_editor\";s:3:\"off\";s:28:\"autoload_next_course_content\";s:2:\"on\";s:25:\"enable_comment_for_lesson\";s:3:\"off\";s:21:\"quiz_attempts_allowed\";s:3:\"100\";s:28:\"quiz_previous_button_enabled\";s:2:\"on\";s:17:\"quiz_grade_method\";s:13:\"highest_grade\";s:23:\"supported_video_sources\";a:2:{i:0;s:8:\"embedded\";i:1;s:9:\"shortcode\";}s:11:\"monetize_by\";s:4:\"free\";s:24:\"enable_guest_course_cart\";s:2:\"on\";s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";s:22:\"enable_revenue_sharing\";s:3:\"off\";s:23:\"statement_show_per_page\";s:2:\"20\";s:21:\"enable_fees_deducting\";s:3:\"off\";s:9:\"fees_name\";s:0:\"\";s:15:\"fee_amount_type\";a:2:{s:9:\"fees_type\";s:5:\"fixed\";s:11:\"fees_amount\";s:1:\"0\";}s:19:\"min_withdraw_amount\";s:2:\"80\";s:40:\"minimum_days_for_balance_to_be_available\";s:1:\"7\";s:24:\"tutor_withdrawal_methods\";a:3:{s:22:\"bank_transfer_withdraw\";s:22:\"bank_transfer_withdraw\";s:15:\"echeck_withdraw\";s:15:\"echeck_withdraw\";s:15:\"paypal_withdraw\";s:15:\"paypal_withdraw\";}s:40:\"tutor_bank_transfer_withdraw_instruction\";s:0:\"\";s:34:\"tutor_frontend_course_page_logo_id\";s:0:\"\";s:19:\"courses_col_per_row\";s:1:\"4\";s:21:\"course_archive_filter\";s:3:\"off\";s:16:\"courses_per_page\";s:1:\"8\";s:24:\"supported_course_filters\";a:2:{s:6:\"search\";s:6:\"search\";s:8:\"category\";s:8:\"category\";}s:22:\"instructor_list_layout\";s:12:\"pp-left-full\";s:21:\"public_profile_layout\";s:9:\"pp-circle\";s:29:\"student_public_profile_layout\";s:9:\"pp-circle\";s:26:\"display_course_instructors\";s:2:\"on\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:20:\"enable_course_author\";s:3:\"off\";s:19:\"enable_course_level\";s:2:\"on\";s:19:\"enable_course_share\";s:2:\"on\";s:22:\"enable_course_duration\";s:2:\"on\";s:28:\"enable_course_total_enrolled\";s:2:\"on\";s:25:\"enable_course_update_date\";s:2:\"on\";s:26:\"enable_course_progress_bar\";s:2:\"on\";s:22:\"enable_course_material\";s:2:\"on\";s:19:\"enable_course_about\";s:2:\"on\";s:25:\"enable_course_description\";s:2:\"on\";s:22:\"enable_course_benefits\";s:2:\"on\";s:26:\"enable_course_requirements\";s:2:\"on\";s:29:\"enable_course_target_audience\";s:2:\"on\";s:27:\"enable_course_announcements\";s:2:\"on\";s:20:\"enable_course_review\";s:2:\"on\";s:17:\"color_preset_type\";s:6:\"custom\";s:19:\"tutor_primary_color\";s:7:\"#3e64de\";s:25:\"tutor_primary_hover_color\";s:7:\"#28408e\";s:16:\"tutor_text_color\";s:7:\"#1a1b1e\";s:22:\"tutor_background_color\";s:7:\"#f6f8fd\";s:18:\"tutor_border_color\";s:7:\"#cdcfd5\";s:19:\"tutor_success_color\";s:7:\"#24a148\";s:19:\"tutor_warning_color\";s:7:\"#ed9700\";s:18:\"tutor_danger_color\";s:7:\"#d8d8d8\";s:19:\"tutor_disable_color\";s:7:\"#e3e6eb\";s:28:\"tutor_table_background_color\";s:7:\"#eff1f6\";s:30:\"disable_default_player_youtube\";s:3:\"off\";s:28:\"disable_default_player_vimeo\";s:3:\"off\";s:28:\"enable_gutenberg_course_edit\";s:2:\"on\";s:26:\"hide_course_from_shop_page\";s:3:\"off\";s:19:\"course_archive_page\";s:2:\"-1\";s:24:\"instructor_register_page\";s:1:\"8\";s:21:\"student_register_page\";s:1:\"7\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:37:\"lesson_video_duration_youtube_api_key\";s:0:\"\";s:25:\"enable_profile_completion\";s:2:\"on\";s:25:\"enable_tutor_native_login\";s:2:\"on\";s:24:\"hide_admin_bar_for_users\";s:2:\"on\";s:19:\"delete_on_uninstall\";s:3:\"off\";s:29:\"enable_tutor_maintenance_mode\";s:3:\"off\";s:17:\"email_footer_text\";s:0:\"\";}}s:22:\"tutor-saved-1656666779\";a:4:{s:8:\"datetime\";i:1656666779;s:12:\"history_date\";s:20:\"1 Jul, 2022, 9:12 am\";s:8:\"datatype\";s:5:\"saved\";s:7:\"dataset\";a:81:{s:23:\"tutor_dashboard_page_id\";s:1:\"6\";s:25:\"enable_course_marketplace\";s:3:\"off\";s:19:\"pagination_per_page\";s:2:\"20\";s:29:\"instructor_can_publish_course\";s:2:\"on\";s:28:\"enable_become_instructor_btn\";s:2:\"on\";s:28:\"course_content_access_for_ia\";s:3:\"off\";s:21:\"enable_spotlight_mode\";s:3:\"off\";s:25:\"course_completion_process\";s:8:\"flexible\";s:21:\"course_retake_feature\";s:3:\"off\";s:25:\"enrollment_expiry_enabled\";s:2:\"on\";s:28:\"enable_lesson_classic_editor\";s:3:\"off\";s:28:\"autoload_next_course_content\";s:2:\"on\";s:25:\"enable_comment_for_lesson\";s:3:\"off\";s:21:\"quiz_attempts_allowed\";s:3:\"100\";s:28:\"quiz_previous_button_enabled\";s:2:\"on\";s:17:\"quiz_grade_method\";s:13:\"highest_grade\";s:23:\"supported_video_sources\";a:2:{i:0;s:8:\"embedded\";i:1;s:9:\"shortcode\";}s:11:\"monetize_by\";s:4:\"free\";s:24:\"enable_guest_course_cart\";s:2:\"on\";s:29:\"earning_instructor_commission\";s:2:\"80\";s:24:\"earning_admin_commission\";s:2:\"20\";s:22:\"enable_revenue_sharing\";s:3:\"off\";s:23:\"statement_show_per_page\";s:2:\"20\";s:21:\"enable_fees_deducting\";s:3:\"off\";s:9:\"fees_name\";s:0:\"\";s:15:\"fee_amount_type\";a:2:{s:9:\"fees_type\";s:5:\"fixed\";s:11:\"fees_amount\";s:1:\"0\";}s:19:\"min_withdraw_amount\";s:2:\"80\";s:40:\"minimum_days_for_balance_to_be_available\";s:1:\"7\";s:24:\"tutor_withdrawal_methods\";a:3:{s:22:\"bank_transfer_withdraw\";s:22:\"bank_transfer_withdraw\";s:15:\"echeck_withdraw\";s:15:\"echeck_withdraw\";s:15:\"paypal_withdraw\";s:15:\"paypal_withdraw\";}s:40:\"tutor_bank_transfer_withdraw_instruction\";s:0:\"\";s:34:\"tutor_frontend_course_page_logo_id\";s:0:\"\";s:19:\"courses_col_per_row\";s:1:\"4\";s:21:\"course_archive_filter\";s:3:\"off\";s:16:\"courses_per_page\";s:1:\"8\";s:24:\"supported_course_filters\";a:2:{s:6:\"search\";s:6:\"search\";s:8:\"category\";s:8:\"category\";}s:22:\"instructor_list_layout\";s:12:\"pp-left-full\";s:21:\"public_profile_layout\";s:9:\"pp-circle\";s:29:\"student_public_profile_layout\";s:9:\"pp-circle\";s:26:\"display_course_instructors\";s:2:\"on\";s:24:\"enable_q_and_a_on_course\";s:2:\"on\";s:20:\"enable_course_author\";s:3:\"off\";s:19:\"enable_course_level\";s:2:\"on\";s:19:\"enable_course_share\";s:2:\"on\";s:22:\"enable_course_duration\";s:2:\"on\";s:28:\"enable_course_total_enrolled\";s:2:\"on\";s:25:\"enable_course_update_date\";s:2:\"on\";s:26:\"enable_course_progress_bar\";s:2:\"on\";s:22:\"enable_course_material\";s:2:\"on\";s:19:\"enable_course_about\";s:2:\"on\";s:25:\"enable_course_description\";s:2:\"on\";s:22:\"enable_course_benefits\";s:2:\"on\";s:26:\"enable_course_requirements\";s:2:\"on\";s:29:\"enable_course_target_audience\";s:2:\"on\";s:27:\"enable_course_announcements\";s:2:\"on\";s:20:\"enable_course_review\";s:2:\"on\";s:17:\"color_preset_type\";s:6:\"custom\";s:19:\"tutor_primary_color\";s:7:\"#3e64de\";s:25:\"tutor_primary_hover_color\";s:7:\"#28408e\";s:16:\"tutor_text_color\";s:7:\"#1a1b1e\";s:22:\"tutor_background_color\";s:7:\"#f6f8fd\";s:18:\"tutor_border_color\";s:7:\"#cdcfd5\";s:19:\"tutor_success_color\";s:7:\"#24a148\";s:19:\"tutor_warning_color\";s:7:\"#ed9700\";s:18:\"tutor_danger_color\";s:7:\"#d8d8d8\";s:19:\"tutor_disable_color\";s:7:\"#e3e6eb\";s:28:\"tutor_table_background_color\";s:7:\"#eff1f6\";s:30:\"disable_default_player_youtube\";s:3:\"off\";s:28:\"disable_default_player_vimeo\";s:3:\"off\";s:28:\"enable_gutenberg_course_edit\";s:3:\"off\";s:26:\"hide_course_from_shop_page\";s:3:\"off\";s:19:\"course_archive_page\";s:2:\"-1\";s:24:\"instructor_register_page\";s:1:\"8\";s:21:\"student_register_page\";s:1:\"7\";s:21:\"lesson_permalink_base\";s:6:\"lesson\";s:37:\"lesson_video_duration_youtube_api_key\";s:0:\"\";s:25:\"enable_profile_completion\";s:3:\"off\";s:25:\"enable_tutor_native_login\";s:2:\"on\";s:24:\"hide_admin_bar_for_users\";s:3:\"off\";s:19:\"delete_on_uninstall\";s:3:\"off\";s:29:\"enable_tutor_maintenance_mode\";s:3:\"off\";s:17:\"email_footer_text\";s:0:\"\";}}}', 'yes'),
(162, 'tutor_option_update_time', '27 Jul, 2022, 2:36 pm', 'yes'),
(164, 'tutor_addons_config', 'a:21:{s:39:\"lmspro/addons/buddypress/buddypress.php\";a:1:{s:9:\"is_enable\";i:0;}s:35:\"lmspro/addons/calendar/calendar.php\";a:1:{s:9:\"is_enable\";i:1;}s:43:\"lmspro/addons/content-drip/content-drip.php\";a:1:{s:9:\"is_enable\";i:0;}s:41:\"lmspro/addons/enrollments/enrollments.php\";a:1:{s:9:\"is_enable\";i:1;}s:51:\"lmspro/addons/google-classroom/google-classroom.php\";a:1:{s:9:\"is_enable\";i:0;}s:37:\"lmspro/addons/gradebook/gradebook.php\";a:1:{s:9:\"is_enable\";i:1;}s:29:\"lmspro/addons/pmpro/pmpro.php\";a:1:{s:9:\"is_enable\";i:0;}s:55:\"lmspro/addons/quiz-import-export/quiz-import-export.php\";a:1:{s:9:\"is_enable\";i:1;}s:59:\"lmspro/addons/restrict-content-pro/restrict-content-pro.php\";a:1:{s:9:\"is_enable\";i:0;}s:53:\"lmspro/addons/tutor-assignments/tutor-assignments.php\";a:1:{s:9:\"is_enable\";i:1;}s:53:\"lmspro/addons/tutor-certificate/tutor-certificate.php\";a:1:{s:9:\"is_enable\";i:0;}s:67:\"lmspro/addons/tutor-course-attachments/tutor-course-attachments.php\";a:1:{s:9:\"is_enable\";i:0;}s:59:\"lmspro/addons/tutor-course-preview/tutor-course-preview.php\";a:1:{s:9:\"is_enable\";i:0;}s:41:\"lmspro/addons/tutor-email/tutor-email.php\";a:1:{s:9:\"is_enable\";i:0;}s:65:\"lmspro/addons/tutor-multi-instructors/tutor-multi-instructors.php\";a:1:{s:9:\"is_enable\";i:0;}s:57:\"lmspro/addons/tutor-notifications/tutor-notifications.php\";a:1:{s:9:\"is_enable\";i:0;}s:57:\"lmspro/addons/tutor-prerequisites/tutor-prerequisites.php\";a:1:{s:9:\"is_enable\";i:0;}s:43:\"lmspro/addons/tutor-report/tutor-report.php\";a:1:{s:9:\"is_enable\";i:1;}s:39:\"lmspro/addons/tutor-wpml/tutor-wpml.php\";a:1:{s:9:\"is_enable\";i:0;}s:39:\"lmspro/addons/tutor-zoom/tutor-zoom.php\";a:1:{s:9:\"is_enable\";i:0;}s:51:\"lmspro/addons/wc-subscriptions/wc-subscriptions.php\";a:1:{s:9:\"is_enable\";i:0;}}', 'yes'),
(165, 'sp_woo_product_slider_review_notice_dismiss', 'a:2:{s:4:\"time\";i:1656951340;s:9:\"dismissed\";b:1;}', 'yes'),
(169, 'new_admin_email', 'heckmanle@gmail.com', 'yes'),
(173, 'themeum_update_error_lmspro/tutor-pro.php', 'Please submit a valid license key.', 'yes'),
(181, 'woocommerce_store_address', 'HCMC', 'yes'),
(182, 'woocommerce_store_address_2', '', 'yes'),
(183, 'woocommerce_store_city', 'HCMC', 'yes'),
(184, 'woocommerce_default_country', 'VN', 'yes'),
(185, 'woocommerce_store_postcode', '760000', 'yes'),
(186, 'woocommerce_allowed_countries', 'all', 'yes'),
(187, 'woocommerce_all_except_countries', 'a:0:{}', 'yes'),
(188, 'woocommerce_specific_allowed_countries', 'a:0:{}', 'yes'),
(189, 'woocommerce_ship_to_countries', '', 'yes'),
(190, 'woocommerce_specific_ship_to_countries', 'a:0:{}', 'yes'),
(191, 'woocommerce_default_customer_address', 'geolocation', 'yes'),
(192, 'woocommerce_calc_taxes', 'no', 'yes'),
(193, 'woocommerce_enable_coupons', 'no', 'yes'),
(194, 'woocommerce_calc_discounts_sequentially', 'no', 'no'),
(195, 'woocommerce_currency', 'VND', 'yes'),
(196, 'woocommerce_currency_pos', 'right_space', 'yes'),
(197, 'woocommerce_price_thousand_sep', ',', 'yes'),
(198, 'woocommerce_price_decimal_sep', '.', 'yes'),
(199, 'woocommerce_price_num_decimals', '0', 'yes'),
(200, 'woocommerce_shop_page_id', '125', 'yes'),
(201, 'woocommerce_cart_redirect_after_add', 'yes', 'yes'),
(202, 'woocommerce_enable_ajax_add_to_cart', 'yes', 'yes'),
(203, 'woocommerce_placeholder_image', '11', 'yes'),
(204, 'woocommerce_weight_unit', 'kg', 'yes'),
(205, 'woocommerce_dimension_unit', 'cm', 'yes'),
(206, 'woocommerce_enable_reviews', 'yes', 'yes'),
(207, 'woocommerce_review_rating_verification_label', 'yes', 'no'),
(208, 'woocommerce_review_rating_verification_required', 'no', 'no'),
(209, 'woocommerce_enable_review_rating', 'yes', 'yes'),
(210, 'woocommerce_review_rating_required', 'yes', 'no'),
(211, 'woocommerce_manage_stock', 'yes', 'yes'),
(212, 'woocommerce_hold_stock_minutes', '60', 'no'),
(213, 'woocommerce_notify_low_stock', 'yes', 'no'),
(214, 'woocommerce_notify_no_stock', 'yes', 'no'),
(215, 'woocommerce_stock_email_recipient', 'heckmanle@gmail.com', 'no'),
(216, 'woocommerce_notify_low_stock_amount', '2', 'no'),
(217, 'woocommerce_notify_no_stock_amount', '0', 'yes'),
(218, 'woocommerce_hide_out_of_stock_items', 'no', 'yes'),
(219, 'woocommerce_stock_format', '', 'yes'),
(220, 'woocommerce_file_download_method', 'force', 'no'),
(221, 'woocommerce_downloads_require_login', 'no', 'no'),
(222, 'woocommerce_downloads_grant_access_after_payment', 'yes', 'no'),
(223, 'woocommerce_prices_include_tax', 'no', 'yes'),
(224, 'woocommerce_tax_based_on', 'shipping', 'yes'),
(225, 'woocommerce_shipping_tax_class', 'inherit', 'yes'),
(226, 'woocommerce_tax_round_at_subtotal', 'no', 'yes'),
(227, 'woocommerce_tax_classes', '', 'yes'),
(228, 'woocommerce_tax_display_shop', 'excl', 'yes'),
(229, 'woocommerce_tax_display_cart', 'excl', 'yes'),
(230, 'woocommerce_price_display_suffix', '', 'yes'),
(231, 'woocommerce_tax_total_display', 'itemized', 'no'),
(232, 'woocommerce_enable_shipping_calc', 'no', 'no'),
(233, 'woocommerce_shipping_cost_requires_address', 'no', 'yes'),
(234, 'woocommerce_ship_to_destination', 'billing_only', 'no'),
(235, 'woocommerce_shipping_debug_mode', 'no', 'yes'),
(236, 'woocommerce_enable_guest_checkout', 'yes', 'no'),
(237, 'woocommerce_enable_checkout_login_reminder', 'yes', 'no'),
(238, 'woocommerce_enable_signup_and_login_from_checkout', 'no', 'no'),
(239, 'woocommerce_enable_myaccount_registration', 'yes', 'no'),
(240, 'woocommerce_registration_generate_username', 'yes', 'no'),
(241, 'woocommerce_registration_generate_password', 'yes', 'no'),
(242, 'woocommerce_erasure_request_removes_order_data', 'no', 'no'),
(243, 'woocommerce_erasure_request_removes_download_data', 'no', 'no');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(244, 'woocommerce_allow_bulk_remove_personal_data', 'no', 'no'),
(245, 'woocommerce_registration_privacy_policy_text', 'Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our [privacy_policy].', 'yes'),
(246, 'woocommerce_checkout_privacy_policy_text', 'Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our [privacy_policy].', 'yes'),
(247, 'woocommerce_delete_inactive_accounts', 'a:2:{s:6:\"number\";s:0:\"\";s:4:\"unit\";s:6:\"months\";}', 'no'),
(248, 'woocommerce_trash_pending_orders', 'a:2:{s:6:\"number\";s:0:\"\";s:4:\"unit\";s:4:\"days\";}', 'no'),
(249, 'woocommerce_trash_failed_orders', 'a:2:{s:6:\"number\";s:0:\"\";s:4:\"unit\";s:4:\"days\";}', 'no'),
(250, 'woocommerce_trash_cancelled_orders', 'a:2:{s:6:\"number\";s:0:\"\";s:4:\"unit\";s:4:\"days\";}', 'no'),
(251, 'woocommerce_anonymize_completed_orders', 'a:2:{s:6:\"number\";s:0:\"\";s:4:\"unit\";s:6:\"months\";}', 'no'),
(252, 'woocommerce_email_from_name', 'Khóa học Online', 'no'),
(253, 'woocommerce_email_from_address', 'heckmanle@gmail.com', 'no'),
(254, 'woocommerce_email_header_image', '', 'no'),
(255, 'woocommerce_email_footer_text', '{site_title} &mdash; Built with {WooCommerce}', 'no'),
(256, 'woocommerce_email_base_color', '#96588a', 'no'),
(257, 'woocommerce_email_background_color', '#f7f7f7', 'no'),
(258, 'woocommerce_email_body_background_color', '#ffffff', 'no'),
(259, 'woocommerce_email_text_color', '#3c3c3c', 'no'),
(260, 'woocommerce_cart_page_id', '13', 'no'),
(261, 'woocommerce_checkout_page_id', '14', 'no'),
(262, 'woocommerce_myaccount_page_id', '15', 'no'),
(263, 'woocommerce_terms_page_id', '3', 'no'),
(264, 'woocommerce_checkout_pay_endpoint', 'order-pay', 'yes'),
(265, 'woocommerce_checkout_order_received_endpoint', 'order-received', 'yes'),
(266, 'woocommerce_myaccount_add_payment_method_endpoint', 'add-payment-method', 'yes'),
(267, 'woocommerce_myaccount_delete_payment_method_endpoint', 'delete-payment-method', 'yes'),
(268, 'woocommerce_myaccount_set_default_payment_method_endpoint', 'set-default-payment-method', 'yes'),
(269, 'woocommerce_myaccount_orders_endpoint', 'orders', 'yes'),
(270, 'woocommerce_myaccount_view_order_endpoint', 'view-order', 'yes'),
(271, 'woocommerce_myaccount_downloads_endpoint', 'downloads', 'yes'),
(272, 'woocommerce_myaccount_edit_account_endpoint', 'edit-account', 'yes'),
(273, 'woocommerce_myaccount_edit_address_endpoint', 'edit-address', 'yes'),
(274, 'woocommerce_myaccount_payment_methods_endpoint', 'payment-methods', 'yes'),
(275, 'woocommerce_myaccount_lost_password_endpoint', 'lost-password', 'yes'),
(276, 'woocommerce_logout_endpoint', 'customer-logout', 'yes'),
(277, 'woocommerce_api_enabled', 'no', 'yes'),
(278, 'woocommerce_allow_tracking', 'no', 'no'),
(279, 'woocommerce_show_marketplace_suggestions', 'yes', 'no'),
(280, 'woocommerce_single_image_width', '600', 'yes'),
(281, 'woocommerce_thumbnail_image_width', '300', 'yes'),
(282, 'woocommerce_checkout_highlight_required_fields', 'yes', 'yes'),
(283, 'woocommerce_demo_store', 'no', 'no'),
(284, 'woocommerce_permalinks', 'a:5:{s:12:\"product_base\";s:8:\"/product\";s:13:\"category_base\";s:16:\"product-category\";s:8:\"tag_base\";s:11:\"product-tag\";s:14:\"attribute_base\";s:0:\"\";s:22:\"use_verbose_page_rules\";b:0;}', 'yes'),
(285, 'current_theme_supports_woocommerce', 'no', 'yes'),
(286, 'woocommerce_queue_flush_rewrite_rules', 'no', 'yes'),
(287, '_transient_wc_attribute_taxonomies', 'a:0:{}', 'yes'),
(289, 'default_product_cat', '15', 'yes'),
(292, 'woocommerce_version', '3.7.0', 'yes'),
(293, 'woocommerce_db_version', '3.7.0', 'yes'),
(294, 'woocommerce_admin_notices', 'a:0:{}', 'yes'),
(295, '_transient_woocommerce_webhook_ids_status_active', 'a:0:{}', 'yes'),
(296, 'widget_woocommerce_widget_cart', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(297, 'widget_woocommerce_layered_nav_filters', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(298, 'widget_woocommerce_layered_nav', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(299, 'widget_woocommerce_price_filter', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(300, 'widget_woocommerce_product_categories', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(301, 'widget_woocommerce_product_search', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(302, 'widget_woocommerce_product_tag_cloud', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(303, 'widget_woocommerce_products', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(304, 'widget_woocommerce_recently_viewed_products', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(305, 'widget_woocommerce_top_rated_products', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(306, 'widget_woocommerce_recent_reviews', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(307, 'widget_woocommerce_rating_filter', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(312, 'woocommerce_meta_box_errors', 'a:0:{}', 'yes'),
(318, 'woocommerce_product_type', 'both', 'yes'),
(319, 'woocommerce_sell_in_person', '1', 'yes'),
(321, 'woocommerce_cheque_settings', 'a:1:{s:7:\"enabled\";s:2:\"no\";}', 'yes'),
(322, 'woocommerce_bacs_settings', 'a:1:{s:7:\"enabled\";s:2:\"no\";}', 'yes'),
(323, 'woocommerce_cod_settings', 'a:6:{s:7:\"enabled\";s:3:\"yes\";s:5:\"title\";s:16:\"Cash on delivery\";s:11:\"description\";s:28:\"Pay with cash upon delivery.\";s:12:\"instructions\";s:28:\"Pay with cash upon delivery.\";s:18:\"enable_for_methods\";a:0:{}s:18:\"enable_for_virtual\";s:3:\"yes\";}', 'yes'),
(328, 'woocommerce_admin_notice_woocommerce-admin_install_error', 'WooCommerce Admin was installed but could not be activated. <a href=\"http://mythosedu.com/wp-admin/plugins.php\">Please activate it manually by clicking here.</a>', 'yes'),
(329, 'facebook_config', 'a:4:{s:8:\"pixel_id\";s:1:\"0\";s:7:\"use_pii\";b:1;s:7:\"use_s2s\";b:0;s:12:\"access_token\";s:0:\"\";}', 'yes'),
(330, 'wc_facebook_for_woocommerce_is_active', 'yes', 'yes'),
(331, 'wc_facebook_for_woocommerce_lifecycle_events', '[{\"name\":\"install\",\"time\":1656661391,\"version\":\"2.6.16\"}]', 'no'),
(332, 'wc_facebook_for_woocommerce_version', '2.6.16', 'yes'),
(343, '_transient_shipping-transient-version', '1658304458', 'yes'),
(350, '_transient_product_query-transient-version', '1701185297', 'yes'),
(366, 'cpto_options', 'a:7:{s:23:\"show_reorder_interfaces\";a:10:{s:4:\"post\";s:4:\"show\";s:10:\"attachment\";s:4:\"show\";s:8:\"wp_block\";s:4:\"show\";s:7:\"product\";s:4:\"show\";s:10:\"shop_order\";s:4:\"show\";s:11:\"shop_coupon\";s:4:\"show\";s:7:\"courses\";s:4:\"show\";s:6:\"lesson\";s:4:\"show\";s:18:\"tutor_zoom_meeting\";s:4:\"show\";s:17:\"sp_wps_shortcodes\";s:4:\"show\";}s:8:\"autosort\";i:1;s:9:\"adminsort\";i:1;s:18:\"use_query_ASC_DESC\";s:0:\"\";s:17:\"archive_drag_drop\";i:1;s:10:\"capability\";s:14:\"manage_options\";s:21:\"navigation_sort_apply\";i:1;}', 'yes'),
(367, 'CPT_configured', 'TRUE', 'yes'),
(369, 'recovery_mode_email_last_sent', '1701185496', 'yes'),
(397, 'theme_mods_twentytwenty', 'a:2:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1656951382;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:3:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";}s:9:\"sidebar-2\";a:3:{i:0;s:10:\"archives-2\";i:1;s:12:\"categories-2\";i:2;s:6:\"meta-2\";}}}}', 'yes'),
(425, 'sp-wqv-notice-dismissed', '1', 'yes'),
(591, 'woocommerce_marketplace_suggestions', 'a:2:{s:11:\"suggestions\";a:27:{i:0;a:4:{s:4:\"slug\";s:28:\"product-edit-meta-tab-header\";s:7:\"context\";s:28:\"product-edit-meta-tab-header\";s:5:\"title\";s:22:\"Recommended extensions\";s:13:\"allow-dismiss\";b:0;}i:1;a:6:{s:4:\"slug\";s:39:\"product-edit-meta-tab-footer-browse-all\";s:7:\"context\";s:28:\"product-edit-meta-tab-footer\";s:9:\"link-text\";s:21:\"Browse all extensions\";s:3:\"url\";s:64:\"http://woocommerce.com/product-category/woocommerce-extensions/\";s:8:\"promoted\";s:31:\"category-woocommerce-extensions\";s:13:\"allow-dismiss\";b:0;}i:2;a:9:{s:4:\"slug\";s:46:\"product-edit-mailchimp-woocommerce-memberships\";s:7:\"product\";s:33:\"woocommerce-memberships-mailchimp\";s:14:\"show-if-active\";a:1:{i:0;s:23:\"woocommerce-memberships\";}s:7:\"context\";a:1:{i:0;s:26:\"product-edit-meta-tab-body\";}s:4:\"icon\";s:116:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/mailchimp-for-memberships.svg\";s:5:\"title\";s:25:\"Mailchimp for Memberships\";s:4:\"copy\";s:79:\"Completely automate your email lists by syncing membership changes to Mailchimp\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:67:\"http://woocommerce.com/products/mailchimp-woocommerce-memberships/\";}i:3;a:9:{s:4:\"slug\";s:19:\"product-edit-addons\";s:7:\"product\";s:26:\"woocommerce-product-addons\";s:14:\"show-if-active\";a:2:{i:0;s:25:\"woocommerce-subscriptions\";i:1;s:20:\"woocommerce-bookings\";}s:7:\"context\";a:1:{i:0;s:26:\"product-edit-meta-tab-body\";}s:4:\"icon\";s:106:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/product-add-ons.svg\";s:5:\"title\";s:15:\"Product Add-Ons\";s:4:\"copy\";s:93:\"Offer add-ons like gift wrapping, special messages or other special options for your products\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:49:\"http://woocommerce.com/products/product-add-ons/\";}i:4;a:9:{s:4:\"slug\";s:46:\"product-edit-woocommerce-subscriptions-gifting\";s:7:\"product\";s:33:\"woocommerce-subscriptions-gifting\";s:14:\"show-if-active\";a:1:{i:0;s:25:\"woocommerce-subscriptions\";}s:7:\"context\";a:1:{i:0;s:26:\"product-edit-meta-tab-body\";}s:4:\"icon\";s:116:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/gifting-for-subscriptions.svg\";s:5:\"title\";s:25:\"Gifting for Subscriptions\";s:4:\"copy\";s:70:\"Let customers buy subscriptions for others - they\'re the ultimate gift\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:67:\"http://woocommerce.com/products/woocommerce-subscriptions-gifting/\";}i:5;a:9:{s:4:\"slug\";s:42:\"product-edit-teams-woocommerce-memberships\";s:7:\"product\";s:33:\"woocommerce-memberships-for-teams\";s:14:\"show-if-active\";a:1:{i:0;s:23:\"woocommerce-memberships\";}s:7:\"context\";a:1:{i:0;s:26:\"product-edit-meta-tab-body\";}s:4:\"icon\";s:112:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/teams-for-memberships.svg\";s:5:\"title\";s:21:\"Teams for Memberships\";s:4:\"copy\";s:123:\"Adds B2B functionality to WooCommerce Memberships, allowing sites to sell team, group, corporate, or family member accounts\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:63:\"http://woocommerce.com/products/teams-woocommerce-memberships/\";}i:6;a:8:{s:4:\"slug\";s:29:\"product-edit-variation-images\";s:7:\"product\";s:39:\"woocommerce-additional-variation-images\";s:7:\"context\";a:1:{i:0;s:26:\"product-edit-meta-tab-body\";}s:4:\"icon\";s:118:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/additional-variation-images.svg\";s:5:\"title\";s:27:\"Additional Variation Images\";s:4:\"copy\";s:72:\"Showcase your products in the best light with a image for each variation\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:73:\"http://woocommerce.com/products/woocommerce-additional-variation-images/\";}i:7;a:9:{s:4:\"slug\";s:47:\"product-edit-woocommerce-subscription-downloads\";s:7:\"product\";s:34:\"woocommerce-subscription-downloads\";s:14:\"show-if-active\";a:1:{i:0;s:25:\"woocommerce-subscriptions\";}s:7:\"context\";a:1:{i:0;s:26:\"product-edit-meta-tab-body\";}s:4:\"icon\";s:113:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/subscription-downloads.svg\";s:5:\"title\";s:22:\"Subscription Downloads\";s:4:\"copy\";s:57:\"Give customers special downloads with their subscriptions\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:68:\"http://woocommerce.com/products/woocommerce-subscription-downloads/\";}i:8;a:8:{s:4:\"slug\";s:31:\"product-edit-min-max-quantities\";s:7:\"product\";s:30:\"woocommerce-min-max-quantities\";s:7:\"context\";a:1:{i:0;s:26:\"product-edit-meta-tab-body\";}s:4:\"icon\";s:109:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/min-max-quantities.svg\";s:5:\"title\";s:18:\"Min/Max Quantities\";s:4:\"copy\";s:81:\"Specify minimum and maximum allowed product quantities for orders to be completed\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:52:\"http://woocommerce.com/products/min-max-quantities/\";}i:9;a:8:{s:4:\"slug\";s:28:\"product-edit-name-your-price\";s:7:\"product\";s:27:\"woocommerce-name-your-price\";s:7:\"context\";a:1:{i:0;s:26:\"product-edit-meta-tab-body\";}s:4:\"icon\";s:106:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/name-your-price.svg\";s:5:\"title\";s:15:\"Name Your Price\";s:4:\"copy\";s:70:\"Let customers pay what they want - useful for donations, tips and more\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:49:\"http://woocommerce.com/products/name-your-price/\";}i:10;a:8:{s:4:\"slug\";s:42:\"product-edit-woocommerce-one-page-checkout\";s:7:\"product\";s:29:\"woocommerce-one-page-checkout\";s:7:\"context\";a:1:{i:0;s:26:\"product-edit-meta-tab-body\";}s:4:\"icon\";s:108:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/one-page-checkout.svg\";s:5:\"title\";s:17:\"One Page Checkout\";s:4:\"copy\";s:92:\"Don\'t make customers click around - let them choose products, checkout & pay all on one page\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:63:\"http://woocommerce.com/products/woocommerce-one-page-checkout/\";}i:11;a:4:{s:4:\"slug\";s:19:\"orders-empty-header\";s:7:\"context\";s:24:\"orders-list-empty-header\";s:5:\"title\";s:20:\"Tools for your store\";s:13:\"allow-dismiss\";b:0;}i:12;a:6:{s:4:\"slug\";s:30:\"orders-empty-footer-browse-all\";s:7:\"context\";s:24:\"orders-list-empty-footer\";s:9:\"link-text\";s:21:\"Browse all extensions\";s:3:\"url\";s:64:\"http://woocommerce.com/product-category/woocommerce-extensions/\";s:8:\"promoted\";s:31:\"category-woocommerce-extensions\";s:13:\"allow-dismiss\";b:0;}i:13;a:8:{s:4:\"slug\";s:19:\"orders-empty-wc-pay\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:20:\"woocommerce-payments\";s:4:\"icon\";s:111:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/woocommerce-payments.svg\";s:5:\"title\";s:20:\"WooCommerce Payments\";s:4:\"copy\";s:125:\"Securely accept payments and manage transactions directly from your WooCommerce dashboard – no setup costs or monthly fees.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:54:\"http://woocommerce.com/products/woocommerce-payments/\";}i:14;a:8:{s:4:\"slug\";s:19:\"orders-empty-zapier\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:18:\"woocommerce-zapier\";s:4:\"icon\";s:97:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/zapier.svg\";s:5:\"title\";s:6:\"Zapier\";s:4:\"copy\";s:88:\"Save time and increase productivity by connecting your store to more than 1000+ services\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:52:\"http://woocommerce.com/products/woocommerce-zapier/\";}i:15;a:8:{s:4:\"slug\";s:30:\"orders-empty-shipment-tracking\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:29:\"woocommerce-shipment-tracking\";s:4:\"icon\";s:108:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/shipment-tracking.svg\";s:5:\"title\";s:17:\"Shipment Tracking\";s:4:\"copy\";s:86:\"Let customers know when their orders will arrive by adding shipment tracking to emails\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:51:\"http://woocommerce.com/products/shipment-tracking/\";}i:16;a:8:{s:4:\"slug\";s:32:\"orders-empty-table-rate-shipping\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:31:\"woocommerce-table-rate-shipping\";s:4:\"icon\";s:110:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/table-rate-shipping.svg\";s:5:\"title\";s:19:\"Table Rate Shipping\";s:4:\"copy\";s:122:\"Advanced, flexible shipping. Define multiple shipping rates based on location, price, weight, shipping class or item count\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:53:\"http://woocommerce.com/products/table-rate-shipping/\";}i:17;a:8:{s:4:\"slug\";s:40:\"orders-empty-shipping-carrier-extensions\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:4:\"icon\";s:118:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/shipping-carrier-extensions.svg\";s:5:\"title\";s:27:\"Shipping Carrier Extensions\";s:4:\"copy\";s:116:\"Show live rates from FedEx, UPS, USPS and more directly on your store - never under or overcharge for shipping again\";s:11:\"button-text\";s:13:\"Find Carriers\";s:8:\"promoted\";s:26:\"category-shipping-carriers\";s:3:\"url\";s:99:\"http://woocommerce.com/product-category/woocommerce-extensions/shipping-methods/shipping-carriers/\";}i:18;a:8:{s:4:\"slug\";s:32:\"orders-empty-google-product-feed\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:25:\"woocommerce-product-feeds\";s:4:\"icon\";s:110:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/google-product-feed.svg\";s:5:\"title\";s:19:\"Google Product Feed\";s:4:\"copy\";s:76:\"Increase sales by letting customers find you when they\'re shopping on Google\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:53:\"http://woocommerce.com/products/google-product-feed/\";}i:19;a:4:{s:4:\"slug\";s:35:\"products-empty-header-product-types\";s:7:\"context\";s:26:\"products-list-empty-header\";s:5:\"title\";s:23:\"Other types of products\";s:13:\"allow-dismiss\";b:0;}i:20;a:6:{s:4:\"slug\";s:32:\"products-empty-footer-browse-all\";s:7:\"context\";s:26:\"products-list-empty-footer\";s:9:\"link-text\";s:21:\"Browse all extensions\";s:3:\"url\";s:64:\"http://woocommerce.com/product-category/woocommerce-extensions/\";s:8:\"promoted\";s:31:\"category-woocommerce-extensions\";s:13:\"allow-dismiss\";b:0;}i:21;a:8:{s:4:\"slug\";s:30:\"products-empty-product-vendors\";s:7:\"context\";s:24:\"products-list-empty-body\";s:7:\"product\";s:27:\"woocommerce-product-vendors\";s:4:\"icon\";s:106:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/product-vendors.svg\";s:5:\"title\";s:15:\"Product Vendors\";s:4:\"copy\";s:47:\"Turn your store into a multi-vendor marketplace\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:49:\"http://woocommerce.com/products/product-vendors/\";}i:22;a:8:{s:4:\"slug\";s:26:\"products-empty-memberships\";s:7:\"context\";s:24:\"products-list-empty-body\";s:7:\"product\";s:23:\"woocommerce-memberships\";s:4:\"icon\";s:102:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/memberships.svg\";s:5:\"title\";s:11:\"Memberships\";s:4:\"copy\";s:76:\"Give members access to restricted content or products, for a fee or for free\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:57:\"http://woocommerce.com/products/woocommerce-memberships/\";}i:23;a:9:{s:4:\"slug\";s:35:\"products-empty-woocommerce-deposits\";s:7:\"context\";s:24:\"products-list-empty-body\";s:7:\"product\";s:20:\"woocommerce-deposits\";s:14:\"show-if-active\";a:1:{i:0;s:20:\"woocommerce-bookings\";}s:4:\"icon\";s:99:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/deposits.svg\";s:5:\"title\";s:8:\"Deposits\";s:4:\"copy\";s:75:\"Make it easier for customers to pay by offering a deposit or a payment plan\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:54:\"http://woocommerce.com/products/woocommerce-deposits/\";}i:24;a:8:{s:4:\"slug\";s:40:\"products-empty-woocommerce-subscriptions\";s:7:\"context\";s:24:\"products-list-empty-body\";s:7:\"product\";s:25:\"woocommerce-subscriptions\";s:4:\"icon\";s:104:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/subscriptions.svg\";s:5:\"title\";s:13:\"Subscriptions\";s:4:\"copy\";s:97:\"Let customers subscribe to your products or services and pay on a weekly, monthly or annual basis\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:59:\"http://woocommerce.com/products/woocommerce-subscriptions/\";}i:25;a:8:{s:4:\"slug\";s:35:\"products-empty-woocommerce-bookings\";s:7:\"context\";s:24:\"products-list-empty-body\";s:7:\"product\";s:20:\"woocommerce-bookings\";s:4:\"icon\";s:99:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/bookings.svg\";s:5:\"title\";s:8:\"Bookings\";s:4:\"copy\";s:99:\"Allow customers to book appointments, make reservations or rent equipment without leaving your site\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:54:\"http://woocommerce.com/products/woocommerce-bookings/\";}i:26;a:8:{s:4:\"slug\";s:30:\"products-empty-product-bundles\";s:7:\"context\";s:24:\"products-list-empty-body\";s:7:\"product\";s:27:\"woocommerce-product-bundles\";s:4:\"icon\";s:106:\"http://woocommerce.com/wp-content/plugins/wccom-plugins/marketplace-suggestions/icons/product-bundles.svg\";s:5:\"title\";s:15:\"Product Bundles\";s:4:\"copy\";s:49:\"Offer customizable bundles and assembled products\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:49:\"http://woocommerce.com/products/product-bundles/\";}}s:7:\"updated\";i:1657696459;}', 'no'),
(762, 'current_theme', 'Drag &amp; drop layout', 'yes'),
(763, 'theme_mods_site_el', 'a:3:{i:0;b:0;s:18:\"nav_menu_locations\";a:5:{s:15:\"header_top_menu\";i:16;s:7:\"primary\";i:0;s:14:\"primary_mobile\";i:0;s:19:\"primary_menu_footer\";i:0;s:6:\"social\";i:0;}s:18:\"custom_css_post_id\";i:-1;}', 'yes'),
(764, 'theme_switched', '', 'yes'),
(765, 'woocommerce_maybe_regenerate_images_hash', '991b1ca641921cf0f5baf7a2fe85861b', 'yes'),
(1076, 'ws_menu_editor', 'a:28:{s:22:\"hide_advanced_settings\";b:1;s:16:\"show_extra_icons\";b:0;s:11:\"custom_menu\";N;s:19:\"custom_network_menu\";N;s:18:\"first_install_time\";i:1701185103;s:21:\"display_survey_notice\";b:1;s:17:\"plugin_db_version\";i:140;s:24:\"security_logging_enabled\";b:0;s:17:\"menu_config_scope\";s:6:\"global\";s:13:\"plugin_access\";s:14:\"manage_options\";s:15:\"allowed_user_id\";N;s:28:\"plugins_page_allowed_user_id\";N;s:27:\"show_deprecated_hide_button\";b:1;s:37:\"dashboard_hiding_confirmation_enabled\";b:1;s:21:\"submenu_icons_enabled\";s:9:\"if_custom\";s:22:\"force_custom_dashicons\";b:1;s:16:\"ui_colour_scheme\";s:7:\"classic\";s:13:\"visible_users\";a:0:{}s:23:\"show_plugin_menu_notice\";b:1;s:20:\"unused_item_position\";s:8:\"relative\";s:23:\"unused_item_permissions\";s:9:\"unchanged\";s:15:\"error_verbosity\";i:2;s:20:\"compress_custom_menu\";b:0;s:20:\"wpml_support_enabled\";b:1;s:24:\"bbpress_override_enabled\";b:0;s:20:\"deep_nesting_enabled\";N;s:24:\"was_nesting_ever_changed\";b:0;s:16:\"is_active_module\";a:1:{s:19:\"highlight-new-menus\";b:0;}}', 'yes'),
(1101, '_transient_as_comment_count', 'O:8:\"stdClass\":7:{s:8:\"approved\";s:1:\"1\";s:14:\"total_comments\";i:1;s:3:\"all\";i:1;s:9:\"moderated\";i:0;s:4:\"spam\";i:0;s:5:\"trash\";i:0;s:12:\"post-trashed\";i:0;}', 'yes'),
(1107, 'user_role_editor', 'a:8:{s:11:\"ure_version\";s:6:\"4.51.1\";s:15:\"show_admin_role\";s:1:\"1\";s:17:\"ure_caps_readable\";s:1:\"1\";s:24:\"ure_show_deprecated_caps\";s:1:\"1\";s:23:\"ure_confirm_role_update\";s:1:\"1\";s:14:\"edit_user_caps\";s:1:\"1\";s:18:\"caps_columns_quant\";i:1;s:24:\"count_users_without_role\";s:1:\"1\";}', 'yes'),
(1108, 'wp_backup_user_roles', 'a:8:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:148:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:12:\"manage_tutor\";b:1;s:23:\"manage_tutor_instructor\";b:1;s:17:\"edit_tutor_course\";b:1;s:17:\"read_tutor_course\";b:1;s:19:\"delete_tutor_course\";b:1;s:20:\"delete_tutor_courses\";b:1;s:18:\"edit_tutor_courses\";b:1;s:25:\"edit_others_tutor_courses\";b:1;s:26:\"read_private_tutor_courses\";b:1;s:17:\"edit_tutor_lesson\";b:1;s:17:\"read_tutor_lesson\";b:1;s:19:\"delete_tutor_lesson\";b:1;s:20:\"delete_tutor_lessons\";b:1;s:18:\"edit_tutor_lessons\";b:1;s:25:\"edit_others_tutor_lessons\";b:1;s:26:\"read_private_tutor_lessons\";b:1;s:21:\"publish_tutor_lessons\";b:1;s:15:\"edit_tutor_quiz\";b:1;s:15:\"read_tutor_quiz\";b:1;s:17:\"delete_tutor_quiz\";b:1;s:20:\"delete_tutor_quizzes\";b:1;s:18:\"edit_tutor_quizzes\";b:1;s:25:\"edit_others_tutor_quizzes\";b:1;s:26:\"read_private_tutor_quizzes\";b:1;s:21:\"publish_tutor_quizzes\";b:1;s:19:\"edit_tutor_question\";b:1;s:19:\"read_tutor_question\";b:1;s:21:\"delete_tutor_question\";b:1;s:22:\"delete_tutor_questions\";b:1;s:20:\"edit_tutor_questions\";b:1;s:27:\"edit_others_tutor_questions\";b:1;s:23:\"publish_tutor_questions\";b:1;s:28:\"read_private_tutor_questions\";b:1;s:21:\"publish_tutor_courses\";b:1;s:18:\"manage_woocommerce\";b:1;s:24:\"view_woocommerce_reports\";b:1;s:12:\"edit_product\";b:1;s:12:\"read_product\";b:1;s:14:\"delete_product\";b:1;s:13:\"edit_products\";b:1;s:20:\"edit_others_products\";b:1;s:16:\"publish_products\";b:1;s:21:\"read_private_products\";b:1;s:15:\"delete_products\";b:1;s:23:\"delete_private_products\";b:1;s:25:\"delete_published_products\";b:1;s:22:\"delete_others_products\";b:1;s:21:\"edit_private_products\";b:1;s:23:\"edit_published_products\";b:1;s:20:\"manage_product_terms\";b:1;s:18:\"edit_product_terms\";b:1;s:20:\"delete_product_terms\";b:1;s:20:\"assign_product_terms\";b:1;s:15:\"edit_shop_order\";b:1;s:15:\"read_shop_order\";b:1;s:17:\"delete_shop_order\";b:1;s:16:\"edit_shop_orders\";b:1;s:23:\"edit_others_shop_orders\";b:1;s:19:\"publish_shop_orders\";b:1;s:24:\"read_private_shop_orders\";b:1;s:18:\"delete_shop_orders\";b:1;s:26:\"delete_private_shop_orders\";b:1;s:28:\"delete_published_shop_orders\";b:1;s:25:\"delete_others_shop_orders\";b:1;s:24:\"edit_private_shop_orders\";b:1;s:26:\"edit_published_shop_orders\";b:1;s:23:\"manage_shop_order_terms\";b:1;s:21:\"edit_shop_order_terms\";b:1;s:23:\"delete_shop_order_terms\";b:1;s:23:\"assign_shop_order_terms\";b:1;s:16:\"edit_shop_coupon\";b:1;s:16:\"read_shop_coupon\";b:1;s:18:\"delete_shop_coupon\";b:1;s:17:\"edit_shop_coupons\";b:1;s:24:\"edit_others_shop_coupons\";b:1;s:20:\"publish_shop_coupons\";b:1;s:25:\"read_private_shop_coupons\";b:1;s:19:\"delete_shop_coupons\";b:1;s:27:\"delete_private_shop_coupons\";b:1;s:29:\"delete_published_shop_coupons\";b:1;s:26:\"delete_others_shop_coupons\";b:1;s:25:\"edit_private_shop_coupons\";b:1;s:27:\"edit_published_shop_coupons\";b:1;s:24:\"manage_shop_coupon_terms\";b:1;s:22:\"edit_shop_coupon_terms\";b:1;s:24:\"delete_shop_coupon_terms\";b:1;s:24:\"assign_shop_coupon_terms\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}s:16:\"tutor_instructor\";a:2:{s:4:\"name\";s:16:\"Tutor Instructor\";s:12:\"capabilities\";a:36:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:12:\"upload_files\";b:1;s:23:\"manage_tutor_instructor\";b:1;s:17:\"edit_tutor_course\";b:1;s:17:\"read_tutor_course\";b:1;s:19:\"delete_tutor_course\";b:1;s:20:\"delete_tutor_courses\";b:1;s:18:\"edit_tutor_courses\";b:1;s:25:\"edit_others_tutor_courses\";b:1;s:26:\"read_private_tutor_courses\";b:1;s:17:\"edit_tutor_lesson\";b:1;s:17:\"read_tutor_lesson\";b:1;s:19:\"delete_tutor_lesson\";b:1;s:20:\"delete_tutor_lessons\";b:1;s:18:\"edit_tutor_lessons\";b:1;s:25:\"edit_others_tutor_lessons\";b:1;s:26:\"read_private_tutor_lessons\";b:1;s:21:\"publish_tutor_lessons\";b:1;s:15:\"edit_tutor_quiz\";b:1;s:15:\"read_tutor_quiz\";b:1;s:17:\"delete_tutor_quiz\";b:1;s:20:\"delete_tutor_quizzes\";b:1;s:18:\"edit_tutor_quizzes\";b:1;s:25:\"edit_others_tutor_quizzes\";b:1;s:26:\"read_private_tutor_quizzes\";b:1;s:21:\"publish_tutor_quizzes\";b:1;s:19:\"edit_tutor_question\";b:1;s:19:\"read_tutor_question\";b:1;s:21:\"delete_tutor_question\";b:1;s:22:\"delete_tutor_questions\";b:1;s:20:\"edit_tutor_questions\";b:1;s:27:\"edit_others_tutor_questions\";b:1;s:23:\"publish_tutor_questions\";b:1;s:28:\"read_private_tutor_questions\";b:1;s:21:\"publish_tutor_courses\";b:1;}}s:8:\"customer\";a:2:{s:4:\"name\";s:8:\"Customer\";s:12:\"capabilities\";a:1:{s:4:\"read\";b:1;}}s:12:\"shop_manager\";a:2:{s:4:\"name\";s:12:\"Shop manager\";s:12:\"capabilities\";a:92:{s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:4:\"read\";b:1;s:18:\"read_private_pages\";b:1;s:18:\"read_private_posts\";b:1;s:10:\"edit_posts\";b:1;s:10:\"edit_pages\";b:1;s:20:\"edit_published_posts\";b:1;s:20:\"edit_published_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"edit_private_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:17:\"edit_others_pages\";b:1;s:13:\"publish_posts\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_posts\";b:1;s:12:\"delete_pages\";b:1;s:20:\"delete_private_pages\";b:1;s:20:\"delete_private_posts\";b:1;s:22:\"delete_published_pages\";b:1;s:22:\"delete_published_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:19:\"delete_others_pages\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:17:\"moderate_comments\";b:1;s:12:\"upload_files\";b:1;s:6:\"export\";b:1;s:6:\"import\";b:1;s:10:\"list_users\";b:1;s:18:\"edit_theme_options\";b:1;s:18:\"manage_woocommerce\";b:1;s:24:\"view_woocommerce_reports\";b:1;s:12:\"edit_product\";b:1;s:12:\"read_product\";b:1;s:14:\"delete_product\";b:1;s:13:\"edit_products\";b:1;s:20:\"edit_others_products\";b:1;s:16:\"publish_products\";b:1;s:21:\"read_private_products\";b:1;s:15:\"delete_products\";b:1;s:23:\"delete_private_products\";b:1;s:25:\"delete_published_products\";b:1;s:22:\"delete_others_products\";b:1;s:21:\"edit_private_products\";b:1;s:23:\"edit_published_products\";b:1;s:20:\"manage_product_terms\";b:1;s:18:\"edit_product_terms\";b:1;s:20:\"delete_product_terms\";b:1;s:20:\"assign_product_terms\";b:1;s:15:\"edit_shop_order\";b:1;s:15:\"read_shop_order\";b:1;s:17:\"delete_shop_order\";b:1;s:16:\"edit_shop_orders\";b:1;s:23:\"edit_others_shop_orders\";b:1;s:19:\"publish_shop_orders\";b:1;s:24:\"read_private_shop_orders\";b:1;s:18:\"delete_shop_orders\";b:1;s:26:\"delete_private_shop_orders\";b:1;s:28:\"delete_published_shop_orders\";b:1;s:25:\"delete_others_shop_orders\";b:1;s:24:\"edit_private_shop_orders\";b:1;s:26:\"edit_published_shop_orders\";b:1;s:23:\"manage_shop_order_terms\";b:1;s:21:\"edit_shop_order_terms\";b:1;s:23:\"delete_shop_order_terms\";b:1;s:23:\"assign_shop_order_terms\";b:1;s:16:\"edit_shop_coupon\";b:1;s:16:\"read_shop_coupon\";b:1;s:18:\"delete_shop_coupon\";b:1;s:17:\"edit_shop_coupons\";b:1;s:24:\"edit_others_shop_coupons\";b:1;s:20:\"publish_shop_coupons\";b:1;s:25:\"read_private_shop_coupons\";b:1;s:19:\"delete_shop_coupons\";b:1;s:27:\"delete_private_shop_coupons\";b:1;s:29:\"delete_published_shop_coupons\";b:1;s:26:\"delete_others_shop_coupons\";b:1;s:25:\"edit_private_shop_coupons\";b:1;s:27:\"edit_published_shop_coupons\";b:1;s:24:\"manage_shop_coupon_terms\";b:1;s:22:\"edit_shop_coupon_terms\";b:1;s:24:\"delete_shop_coupon_terms\";b:1;s:24:\"assign_shop_coupon_terms\";b:1;}}}', 'no'),
(1109, 'ure_tasks_queue', 'a:0:{}', 'yes'),
(1110, 'wp_mail_smtp_initial_version', '3.0.3', 'no'),
(1111, 'wp_mail_smtp_version', '3.0.3', 'no'),
(1112, 'wp_mail_smtp', 'a:3:{s:4:\"mail\";a:6:{s:10:\"from_email\";s:19:\"heckmanle@gmail.com\";s:9:\"from_name\";s:12:\"Khóa học Online\";s:6:\"mailer\";s:4:\"mail\";s:11:\"return_path\";b:0;s:16:\"from_email_force\";b:1;s:15:\"from_name_force\";b:0;}s:4:\"smtp\";a:2:{s:7:\"autotls\";b:1;s:4:\"auth\";b:1;}s:7:\"general\";a:1:{s:29:\"summary_report_email_disabled\";b:0;}}', 'no'),
(1113, 'wp_mail_smtp_activated_time', '1657014433', 'no'),
(1114, 'wp_mail_smtp_activated', 'a:1:{s:4:\"lite\";i:1657014433;}', 'yes'),
(1117, 'action_scheduler_hybrid_store_demarkation', '79', 'yes'),
(1118, 'schema-ActionScheduler_StoreSchema', '4.0.1657014434', 'yes'),
(1119, 'schema-ActionScheduler_LoggerSchema', '2.0.1657014434', 'yes'),
(1120, 'wac_notices', 'a:1:{s:19:\"premium_advertising\";a:3:{s:7:\"message\";s:233:\"You\'re using the free version of WooCommerce Ajax Cart. If you want more features and better support, please <a href=\'http://mythosedu.com/wp-admin/admin.php?page=woocommerce-ajax-cart&amp;tab=tab-buy.php\'>check the premium page</a>.\";s:4:\"type\";s:7:\"success\";s:11:\"dismissDays\";i:90;}}', 'yes'),
(1123, 'wp_mail_smtp_migration_version', '4', 'yes'),
(1124, 'wp_mail_smtp_debug_events_db_version', '1', 'yes'),
(1125, 'wp_mail_smtp_review_notice', 'a:2:{s:4:\"time\";i:1657014436;s:9:\"dismissed\";b:0;}', 'yes'),
(1126, 'action_scheduler_lock_async-request-runner', '1701185535', 'yes'),
(1128, '_transient_wc_count_comments', 'O:8:\"stdClass\":7:{s:14:\"total_comments\";i:1;s:3:\"all\";i:1;s:8:\"approved\";s:1:\"1\";s:9:\"moderated\";i:0;s:4:\"spam\";i:0;s:5:\"trash\";i:0;s:12:\"post-trashed\";i:0;}', 'yes'),
(1136, 'wp_mail_smtp_notifications', 'a:4:{s:6:\"update\";i:1657528112;s:4:\"feed\";a:0:{}s:6:\"events\";a:0:{}s:9:\"dismissed\";a:0:{}}', 'yes'),
(1139, 'ure_role_additional_options_values', 'a:3:{s:6:\"admins\";a:0:{}s:12:\"shop_manager\";a:0:{}s:13:\"administrator\";a:0:{}}', 'yes'),
(1259, 'nav_menu_options', 'a:2:{i:0;b:0;s:8:\"auto_add\";a:0:{}}', 'yes'),
(1433, 'category_children', 'a:0:{}', 'yes'),
(1565, 'acf_version', '5.7.10', 'yes'),
(1593, 'wp_mail_smtp_debug', 'a:8:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;i:7;i:8;}', 'no'),
(1594, 'wp_mail_smtp_lite_sent_email_counter', '8', 'yes'),
(1595, 'wp_mail_smtp_lite_weekly_sent_email_counter', 'a:3:{i:28;i:4;i:29;i:1;i:30;i:3;}', 'yes'),
(1891, '_transient_product-transient-version', '1658995599', 'yes'),
(2299, 'tto_options', 'a:3:{s:10:\"capability\";s:14:\"manage_options\";s:8:\"autosort\";i:0;s:9:\"adminsort\";i:0;}', 'yes'),
(2300, 'action_scheduler_migration_status', 'complete', 'yes'),
(2304, 'product_cat_children', 'a:0:{}', 'yes'),
(3248, 'woocommerce_gateway_order', 'a:4:{s:3:\"cod\";i:0;s:4:\"bacs\";i:1;s:6:\"cheque\";i:2;s:6:\"paypal\";i:3;}', 'yes'),
(3995, '_transient_timeout_external_ip_address_127.0.0.1', '1701789920', 'no'),
(3996, '_transient_external_ip_address_127.0.0.1', '116.110.41.56', 'no'),
(3999, '_transient_timeout_wc_term_counts', '1703777123', 'no'),
(4000, '_transient_wc_term_counts', 'a:1:{i:15;s:1:\"6\";}', 'no'),
(4003, '_transient_timeout_acf_plugin_updates', '1701357932', 'no'),
(4004, '_transient_acf_plugin_updates', 'a:5:{s:7:\"plugins\";a:0:{}s:9:\"no_update\";a:1:{s:34:\"advanced-custom-fields-pro/acf.php\";a:12:{s:4:\"slug\";s:26:\"advanced-custom-fields-pro\";s:6:\"plugin\";s:34:\"advanced-custom-fields-pro/acf.php\";s:11:\"new_version\";s:5:\"6.2.4\";s:3:\"url\";s:36:\"https://www.advancedcustomfields.com\";s:6:\"tested\";s:5:\"6.4.1\";s:7:\"package\";s:0:\"\";s:5:\"icons\";a:1:{s:7:\"default\";s:63:\"https://ps.w.org/advanced-custom-fields/assets/icon-256x256.png\";}s:7:\"banners\";a:2:{s:3:\"low\";s:77:\"https://ps.w.org/advanced-custom-fields/assets/banner-772x250.jpg?rev=1729102\";s:4:\"high\";s:78:\"https://ps.w.org/advanced-custom-fields/assets/banner-1544x500.jpg?rev=1729099\";}s:8:\"requires\";s:3:\"5.8\";s:12:\"requires_php\";s:3:\"7.0\";s:12:\"release_date\";s:8:\"20231128\";s:6:\"reason\";s:17:\"wp_not_compatible\";}}s:10:\"expiration\";i:172800;s:6:\"status\";i:1;s:7:\"checked\";a:1:{s:34:\"advanced-custom-fields-pro/acf.php\";s:6:\"5.7.10\";}}', 'no'),
(4005, '_transient_timeout__woocommerce_helper_subscriptions', '1701186032', 'no'),
(4006, '_transient__woocommerce_helper_subscriptions', 'a:0:{}', 'no'),
(4007, '_site_transient_timeout_theme_roots', '1701186932', 'no'),
(4008, '_site_transient_theme_roots', 'a:1:{s:7:\"site_el\";s:7:\"/themes\";}', 'no'),
(4009, '_transient_timeout__woocommerce_helper_updates', '1701228332', 'no'),
(4010, '_transient__woocommerce_helper_updates', 'a:4:{s:4:\"hash\";s:32:\"5ad608ff5a7becbcecc77476d6413ddd\";s:7:\"updated\";i:1701185132;s:8:\"products\";a:0:{}s:6:\"errors\";a:1:{i:0;s:10:\"http-error\";}}', 'no'),
(4020, '_transient_timeout_wp_mail_smtp_initiators', '1701188821', 'no'),
(4021, '_transient_wp_mail_smtp_initiators', 'a:5:{s:94:\"D:\\SRC\\traininghub_frontend_uat\\wp-content\\plugins\\wp-mail-smtp\\src\\Reports\\Emails\\Summary.php\";s:7:\"WP Core\";s:84:\"D:\\SRC\\traininghub_frontend_uat\\wp-includes\\class-wp-recovery-mode-email-service.php\";s:7:\"WP Core\";s:52:\"D:\\SRC\\traininghub_frontend_uat\\wp-includes\\user.php\";s:7:\"WP Core\";s:57:\"D:\\SRC\\traininghub_frontend_uat\\wp-includes\\pluggable.php\";s:7:\"WP Core\";s:59:\"/home/www/vu_traininghub_frontend/wp-includes/pluggable.php\";s:7:\"WP Core\";}', 'no'),
(4022, '_transient_timeout_sv_wc_plugin_wc_versions', '1701790022', 'no'),
(4023, '_transient_sv_wc_plugin_wc_versions', 'a:220:{i:0;s:5:\"8.3.1\";i:1;s:5:\"8.3.0\";i:2;s:5:\"8.2.2\";i:3;s:5:\"8.2.1\";i:4;s:5:\"8.2.0\";i:5;s:5:\"8.1.1\";i:6;s:5:\"8.1.0\";i:7;s:5:\"8.0.3\";i:8;s:5:\"8.0.2\";i:9;s:5:\"8.0.1\";i:10;s:5:\"8.0.0\";i:11;s:5:\"7.9.0\";i:12;s:5:\"7.8.2\";i:13;s:5:\"7.8.1\";i:14;s:5:\"7.8.0\";i:15;s:5:\"7.7.2\";i:16;s:5:\"7.7.1\";i:17;s:5:\"7.7.0\";i:18;s:5:\"7.6.1\";i:19;s:5:\"7.6.0\";i:20;s:5:\"7.5.1\";i:21;s:5:\"7.5.0\";i:22;s:5:\"7.4.1\";i:23;s:5:\"7.4.0\";i:24;s:5:\"7.3.0\";i:25;s:5:\"7.2.3\";i:26;s:5:\"7.2.2\";i:27;s:5:\"7.2.1\";i:28;s:5:\"7.2.0\";i:29;s:5:\"7.1.1\";i:30;s:5:\"7.1.0\";i:31;s:5:\"7.0.1\";i:32;s:5:\"7.0.0\";i:33;s:5:\"6.9.4\";i:34;s:5:\"6.9.3\";i:35;s:5:\"6.9.2\";i:36;s:5:\"6.9.1\";i:37;s:5:\"6.9.0\";i:38;s:5:\"6.8.2\";i:39;s:5:\"6.8.1\";i:40;s:5:\"6.8.0\";i:41;s:5:\"6.7.0\";i:42;s:5:\"6.6.1\";i:43;s:5:\"6.6.0\";i:44;s:5:\"6.5.1\";i:45;s:5:\"6.5.0\";i:46;s:5:\"6.4.1\";i:47;s:5:\"6.4.0\";i:48;s:5:\"6.3.1\";i:49;s:5:\"6.3.0\";i:50;s:5:\"6.2.2\";i:51;s:5:\"6.2.1\";i:52;s:5:\"6.2.0\";i:53;s:5:\"6.1.2\";i:54;s:5:\"6.1.1\";i:55;s:5:\"6.1.0\";i:56;s:5:\"6.0.1\";i:57;s:5:\"6.0.0\";i:58;s:5:\"5.9.1\";i:59;s:5:\"5.9.0\";i:60;s:5:\"5.8.1\";i:61;s:5:\"5.8.0\";i:62;s:5:\"5.7.2\";i:63;s:5:\"5.7.1\";i:64;s:5:\"5.7.0\";i:65;s:5:\"5.6.2\";i:66;s:5:\"5.6.1\";i:67;s:5:\"5.6.0\";i:68;s:5:\"5.5.4\";i:69;s:5:\"5.5.3\";i:70;s:5:\"5.5.2\";i:71;s:5:\"5.5.1\";i:72;s:5:\"5.5.0\";i:73;s:5:\"5.4.4\";i:74;s:5:\"5.4.3\";i:75;s:5:\"5.4.2\";i:76;s:5:\"5.4.1\";i:77;s:5:\"5.4.0\";i:78;s:5:\"5.3.3\";i:79;s:5:\"5.3.2\";i:80;s:5:\"5.3.1\";i:81;s:5:\"5.3.0\";i:82;s:5:\"5.2.5\";i:83;s:5:\"5.2.4\";i:84;s:5:\"5.2.3\";i:85;s:5:\"5.2.2\";i:86;s:5:\"5.2.1\";i:87;s:5:\"5.2.0\";i:88;s:5:\"5.1.3\";i:89;s:5:\"5.1.2\";i:90;s:5:\"5.1.1\";i:91;s:5:\"5.1.0\";i:92;s:5:\"5.0.3\";i:93;s:5:\"5.0.2\";i:94;s:5:\"5.0.1\";i:95;s:5:\"5.0.0\";i:96;s:5:\"4.9.5\";i:97;s:5:\"4.9.4\";i:98;s:5:\"4.9.3\";i:99;s:5:\"4.9.2\";i:100;s:5:\"4.9.1\";i:101;s:5:\"4.9.0\";i:102;s:5:\"4.8.3\";i:103;s:5:\"4.8.2\";i:104;s:5:\"4.8.1\";i:105;s:5:\"4.8.0\";i:106;s:5:\"4.7.4\";i:107;s:5:\"4.7.3\";i:108;s:5:\"4.7.2\";i:109;s:5:\"4.7.1\";i:110;s:5:\"4.7.0\";i:111;s:5:\"4.6.5\";i:112;s:5:\"4.6.4\";i:113;s:5:\"4.6.3\";i:114;s:5:\"4.6.2\";i:115;s:5:\"4.6.1\";i:116;s:5:\"4.6.0\";i:117;s:5:\"4.5.5\";i:118;s:5:\"4.5.4\";i:119;s:5:\"4.5.3\";i:120;s:5:\"4.5.2\";i:121;s:5:\"4.5.1\";i:122;s:5:\"4.5.0\";i:123;s:5:\"4.4.4\";i:124;s:5:\"4.4.3\";i:125;s:5:\"4.4.2\";i:126;s:5:\"4.4.1\";i:127;s:5:\"4.4.0\";i:128;s:5:\"4.3.6\";i:129;s:5:\"4.3.5\";i:130;s:5:\"4.3.4\";i:131;s:5:\"4.3.3\";i:132;s:5:\"4.3.2\";i:133;s:5:\"4.3.1\";i:134;s:5:\"4.3.0\";i:135;s:5:\"4.2.5\";i:136;s:5:\"4.2.4\";i:137;s:5:\"4.2.3\";i:138;s:5:\"4.2.2\";i:139;s:5:\"4.2.1\";i:140;s:5:\"4.2.0\";i:141;s:5:\"4.1.4\";i:142;s:5:\"4.1.3\";i:143;s:5:\"4.1.2\";i:144;s:5:\"4.1.1\";i:145;s:5:\"4.1.0\";i:146;s:5:\"4.0.4\";i:147;s:5:\"4.0.3\";i:148;s:5:\"4.0.2\";i:149;s:5:\"4.0.1\";i:150;s:5:\"4.0.0\";i:151;s:5:\"3.9.5\";i:152;s:5:\"3.9.4\";i:153;s:5:\"3.9.3\";i:154;s:5:\"3.9.2\";i:155;s:5:\"3.9.1\";i:156;s:5:\"3.9.0\";i:157;s:5:\"3.8.3\";i:158;s:5:\"3.8.2\";i:159;s:5:\"3.8.1\";i:160;s:5:\"3.8.0\";i:161;s:5:\"3.7.3\";i:162;s:5:\"3.7.2\";i:163;s:5:\"3.7.1\";i:164;s:5:\"3.7.0\";i:165;s:5:\"3.6.7\";i:166;s:5:\"3.6.6\";i:167;s:5:\"3.6.5\";i:168;s:5:\"3.6.4\";i:169;s:5:\"3.6.3\";i:170;s:5:\"3.6.2\";i:171;s:5:\"3.6.1\";i:172;s:5:\"3.6.0\";i:173;s:5:\"3.5.9\";i:174;s:5:\"3.5.8\";i:175;s:5:\"3.5.7\";i:176;s:5:\"3.5.6\";i:177;s:5:\"3.5.5\";i:178;s:5:\"3.5.4\";i:179;s:5:\"3.5.3\";i:180;s:5:\"3.5.2\";i:181;s:6:\"3.5.10\";i:182;s:5:\"3.5.1\";i:183;s:5:\"3.5.0\";i:184;s:5:\"3.4.8\";i:185;s:5:\"3.4.7\";i:186;s:5:\"3.4.6\";i:187;s:5:\"3.4.5\";i:188;s:5:\"3.4.4\";i:189;s:5:\"3.4.3\";i:190;s:5:\"3.4.2\";i:191;s:5:\"3.4.1\";i:192;s:5:\"3.4.0\";i:193;s:5:\"3.3.6\";i:194;s:5:\"3.3.5\";i:195;s:5:\"3.3.4\";i:196;s:5:\"3.3.3\";i:197;s:5:\"3.3.2\";i:198;s:5:\"3.3.1\";i:199;s:5:\"3.3.0\";i:200;s:5:\"3.2.6\";i:201;s:5:\"3.2.5\";i:202;s:5:\"3.2.4\";i:203;s:5:\"3.2.3\";i:204;s:5:\"3.2.2\";i:205;s:5:\"3.2.1\";i:206;s:5:\"3.2.0\";i:207;s:5:\"3.1.2\";i:208;s:5:\"3.1.1\";i:209;s:5:\"3.1.0\";i:210;s:5:\"3.0.9\";i:211;s:5:\"3.0.8\";i:212;s:5:\"3.0.7\";i:213;s:5:\"3.0.6\";i:214;s:5:\"3.0.5\";i:215;s:5:\"3.0.4\";i:216;s:5:\"3.0.3\";i:217;s:5:\"3.0.2\";i:218;s:5:\"3.0.1\";i:219;s:5:\"3.0.0\";}', 'no'),
(4024, '_site_transient_timeout_available_translations', '1701196022', 'no');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(4025, '_site_transient_available_translations', 'a:122:{s:2:\"af\";a:8:{s:8:\"language\";s:2:\"af\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 17:15:09\";s:12:\"english_name\";s:9:\"Afrikaans\";s:11:\"native_name\";s:9:\"Afrikaans\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/af.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"af\";i:2;s:3:\"afr\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"Gaan voort\";}}s:2:\"ar\";a:8:{s:8:\"language\";s:2:\"ar\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-24 15:56:34\";s:12:\"english_name\";s:6:\"Arabic\";s:11:\"native_name\";s:14:\"العربية\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/ar.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ar\";i:2;s:3:\"ara\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"متابعة\";}}s:3:\"ary\";a:8:{s:8:\"language\";s:3:\"ary\";s:7:\"version\";s:6:\"4.8.23\";s:7:\"updated\";s:19:\"2017-01-26 15:42:35\";s:12:\"english_name\";s:15:\"Moroccan Arabic\";s:11:\"native_name\";s:31:\"العربية المغربية\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/4.8.23/ary.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ar\";i:3;s:3:\"ary\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:16:\"المتابعة\";}}s:2:\"as\";a:8:{s:8:\"language\";s:2:\"as\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-11-22 18:59:07\";s:12:\"english_name\";s:8:\"Assamese\";s:11:\"native_name\";s:21:\"অসমীয়া\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/as.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"as\";i:2;s:3:\"asm\";i:3;s:3:\"asm\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:3:\"azb\";a:8:{s:8:\"language\";s:3:\"azb\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-09-12 20:34:31\";s:12:\"english_name\";s:17:\"South Azerbaijani\";s:11:\"native_name\";s:29:\"گؤنئی آذربایجان\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/azb.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"az\";i:3;s:3:\"azb\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:2:\"az\";a:8:{s:8:\"language\";s:2:\"az\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-11-06 00:09:27\";s:12:\"english_name\";s:11:\"Azerbaijani\";s:11:\"native_name\";s:16:\"Azərbaycan dili\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/az.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"az\";i:2;s:3:\"aze\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:5:\"Davam\";}}s:3:\"bel\";a:8:{s:8:\"language\";s:3:\"bel\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2019-10-29 07:54:22\";s:12:\"english_name\";s:10:\"Belarusian\";s:11:\"native_name\";s:29:\"Беларуская мова\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/4.9.24/bel.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"be\";i:2;s:3:\"bel\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:20:\"Працягнуць\";}}s:5:\"bg_BG\";a:8:{s:8:\"language\";s:5:\"bg_BG\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 21:33:50\";s:12:\"english_name\";s:9:\"Bulgarian\";s:11:\"native_name\";s:18:\"Български\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/bg_BG.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"bg\";i:2;s:3:\"bul\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"Напред\";}}s:5:\"bn_BD\";a:8:{s:8:\"language\";s:5:\"bn_BD\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2018-10-03 12:42:02\";s:12:\"english_name\";s:20:\"Bengali (Bangladesh)\";s:11:\"native_name\";s:15:\"বাংলা\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.9.24/bn_BD.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"bn\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:28:\"চালিয়ে যান\";}}s:2:\"bo\";a:8:{s:8:\"language\";s:2:\"bo\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-16 16:47:30\";s:12:\"english_name\";s:7:\"Tibetan\";s:11:\"native_name\";s:21:\"བོད་ཡིག\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/bo.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"bo\";i:2;s:3:\"tib\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:33:\"མུ་མཐུད་དུ།\";}}s:5:\"bs_BA\";a:8:{s:8:\"language\";s:5:\"bs_BA\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2021-02-03 21:38:19\";s:12:\"english_name\";s:7:\"Bosnian\";s:11:\"native_name\";s:8:\"Bosanski\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/bs_BA.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"bs\";i:2;s:3:\"bos\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:7:\"Nastavi\";}}s:2:\"ca\";a:8:{s:8:\"language\";s:2:\"ca\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 20:31:52\";s:12:\"english_name\";s:7:\"Catalan\";s:11:\"native_name\";s:7:\"Català\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/ca.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ca\";i:2;s:3:\"cat\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continua\";}}s:3:\"ceb\";a:8:{s:8:\"language\";s:3:\"ceb\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-03-02 17:25:51\";s:12:\"english_name\";s:7:\"Cebuano\";s:11:\"native_name\";s:7:\"Cebuano\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/ceb.zip\";s:3:\"iso\";a:2:{i:2;s:3:\"ceb\";i:3;s:3:\"ceb\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:7:\"Padayun\";}}s:5:\"cs_CZ\";a:8:{s:8:\"language\";s:5:\"cs_CZ\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-13 05:08:56\";s:12:\"english_name\";s:5:\"Czech\";s:11:\"native_name\";s:9:\"Čeština\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/cs_CZ.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"cs\";i:2;s:3:\"ces\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:11:\"Pokračovat\";}}s:2:\"cy\";a:8:{s:8:\"language\";s:2:\"cy\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 09:49:00\";s:12:\"english_name\";s:5:\"Welsh\";s:11:\"native_name\";s:7:\"Cymraeg\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/cy.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"cy\";i:2;s:3:\"cym\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Parhau\";}}s:5:\"da_DK\";a:8:{s:8:\"language\";s:5:\"da_DK\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-27 22:25:02\";s:12:\"english_name\";s:6:\"Danish\";s:11:\"native_name\";s:5:\"Dansk\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/da_DK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"da\";i:2;s:3:\"dan\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Fortsæt\";}}s:5:\"de_AT\";a:8:{s:8:\"language\";s:5:\"de_AT\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-14 11:38:17\";s:12:\"english_name\";s:16:\"German (Austria)\";s:11:\"native_name\";s:21:\"Deutsch (Österreich)\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/de_AT.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"de\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Weiter\";}}s:5:\"de_DE\";a:8:{s:8:\"language\";s:5:\"de_DE\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-26 16:05:58\";s:12:\"english_name\";s:6:\"German\";s:11:\"native_name\";s:7:\"Deutsch\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/de_DE.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"de\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Weiter\";}}s:12:\"de_DE_formal\";a:8:{s:8:\"language\";s:12:\"de_DE_formal\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-26 16:06:11\";s:12:\"english_name\";s:15:\"German (Formal)\";s:11:\"native_name\";s:13:\"Deutsch (Sie)\";s:7:\"package\";s:69:\"https://downloads.wordpress.org/translation/core/5.3/de_DE_formal.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"de\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Weiter\";}}s:5:\"de_CH\";a:8:{s:8:\"language\";s:5:\"de_CH\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-17 21:08:57\";s:12:\"english_name\";s:20:\"German (Switzerland)\";s:11:\"native_name\";s:17:\"Deutsch (Schweiz)\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/de_CH.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"de\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Weiter\";}}s:14:\"de_CH_informal\";a:8:{s:8:\"language\";s:14:\"de_CH_informal\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-17 21:10:01\";s:12:\"english_name\";s:30:\"German (Switzerland, Informal)\";s:11:\"native_name\";s:21:\"Deutsch (Schweiz, Du)\";s:7:\"package\";s:71:\"https://downloads.wordpress.org/translation/core/5.3/de_CH_informal.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"de\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Weiter\";}}s:3:\"dzo\";a:8:{s:8:\"language\";s:3:\"dzo\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-06-29 08:59:03\";s:12:\"english_name\";s:8:\"Dzongkha\";s:11:\"native_name\";s:18:\"རྫོང་ཁ\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/dzo.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"dz\";i:2;s:3:\"dzo\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:2:\"el\";a:8:{s:8:\"language\";s:2:\"el\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-13 12:21:16\";s:12:\"english_name\";s:5:\"Greek\";s:11:\"native_name\";s:16:\"Ελληνικά\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/el.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"el\";i:2;s:3:\"ell\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:16:\"Συνέχεια\";}}s:5:\"en_GB\";a:8:{s:8:\"language\";s:5:\"en_GB\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-24 12:17:12\";s:12:\"english_name\";s:12:\"English (UK)\";s:11:\"native_name\";s:12:\"English (UK)\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/en_GB.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"en\";i:2;s:3:\"eng\";i:3;s:3:\"eng\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"en_ZA\";a:8:{s:8:\"language\";s:5:\"en_ZA\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2020-12-11 10:21:05\";s:12:\"english_name\";s:22:\"English (South Africa)\";s:11:\"native_name\";s:22:\"English (South Africa)\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/en_ZA.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"en\";i:2;s:3:\"eng\";i:3;s:3:\"eng\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"en_CA\";a:8:{s:8:\"language\";s:5:\"en_CA\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-11 22:08:43\";s:12:\"english_name\";s:16:\"English (Canada)\";s:11:\"native_name\";s:16:\"English (Canada)\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/en_CA.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"en\";i:2;s:3:\"eng\";i:3;s:3:\"eng\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"en_AU\";a:8:{s:8:\"language\";s:5:\"en_AU\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-11 22:08:26\";s:12:\"english_name\";s:19:\"English (Australia)\";s:11:\"native_name\";s:19:\"English (Australia)\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/en_AU.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"en\";i:2;s:3:\"eng\";i:3;s:3:\"eng\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"en_NZ\";a:8:{s:8:\"language\";s:5:\"en_NZ\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-11 22:08:10\";s:12:\"english_name\";s:21:\"English (New Zealand)\";s:11:\"native_name\";s:21:\"English (New Zealand)\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/en_NZ.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"en\";i:2;s:3:\"eng\";i:3;s:3:\"eng\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:2:\"eo\";a:8:{s:8:\"language\";s:2:\"eo\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2020-03-29 13:12:46\";s:12:\"english_name\";s:9:\"Esperanto\";s:11:\"native_name\";s:9:\"Esperanto\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.2.19/eo.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"eo\";i:2;s:3:\"epo\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Daŭrigi\";}}s:5:\"es_CR\";a:8:{s:8:\"language\";s:5:\"es_CR\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-14 16:08:46\";s:12:\"english_name\";s:20:\"Spanish (Costa Rica)\";s:11:\"native_name\";s:22:\"Español de Costa Rica\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/es_CR.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_ES\";a:8:{s:8:\"language\";s:5:\"es_ES\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-26 15:21:16\";s:12:\"english_name\";s:15:\"Spanish (Spain)\";s:11:\"native_name\";s:8:\"Español\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/es_ES.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_VE\";a:8:{s:8:\"language\";s:5:\"es_VE\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 00:37:27\";s:12:\"english_name\";s:19:\"Spanish (Venezuela)\";s:11:\"native_name\";s:21:\"Español de Venezuela\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/es_VE.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_MX\";a:8:{s:8:\"language\";s:5:\"es_MX\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-27 20:00:25\";s:12:\"english_name\";s:16:\"Spanish (Mexico)\";s:11:\"native_name\";s:19:\"Español de México\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/es_MX.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_CO\";a:8:{s:8:\"language\";s:5:\"es_CO\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 22:01:17\";s:12:\"english_name\";s:18:\"Spanish (Colombia)\";s:11:\"native_name\";s:20:\"Español de Colombia\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/es_CO.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_GT\";a:8:{s:8:\"language\";s:5:\"es_GT\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2019-03-02 06:35:01\";s:12:\"english_name\";s:19:\"Spanish (Guatemala)\";s:11:\"native_name\";s:21:\"Español de Guatemala\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/es_GT.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_CL\";a:8:{s:8:\"language\";s:5:\"es_CL\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2020-12-12 02:18:45\";s:12:\"english_name\";s:15:\"Spanish (Chile)\";s:11:\"native_name\";s:17:\"Español de Chile\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/es_CL.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_PE\";a:8:{s:8:\"language\";s:5:\"es_PE\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2018-08-03 03:43:42\";s:12:\"english_name\";s:14:\"Spanish (Peru)\";s:11:\"native_name\";s:17:\"Español de Perú\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.9.24/es_PE.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_AR\";a:8:{s:8:\"language\";s:5:\"es_AR\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-15 23:16:59\";s:12:\"english_name\";s:19:\"Spanish (Argentina)\";s:11:\"native_name\";s:21:\"Español de Argentina\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/es_AR.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_UY\";a:8:{s:8:\"language\";s:5:\"es_UY\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 04:43:11\";s:12:\"english_name\";s:17:\"Spanish (Uruguay)\";s:11:\"native_name\";s:19:\"Español de Uruguay\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/es_UY.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:2:\"et\";a:8:{s:8:\"language\";s:2:\"et\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2018-11-28 16:04:33\";s:12:\"english_name\";s:8:\"Estonian\";s:11:\"native_name\";s:5:\"Eesti\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.2.19/et.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"et\";i:2;s:3:\"est\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Jätka\";}}s:2:\"eu\";a:8:{s:8:\"language\";s:2:\"eu\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 00:49:32\";s:12:\"english_name\";s:6:\"Basque\";s:11:\"native_name\";s:7:\"Euskara\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/eu.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"eu\";i:2;s:3:\"eus\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Jarraitu\";}}s:5:\"fa_IR\";a:8:{s:8:\"language\";s:5:\"fa_IR\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-26 21:17:33\";s:12:\"english_name\";s:7:\"Persian\";s:11:\"native_name\";s:10:\"فارسی\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/fa_IR.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"fa\";i:2;s:3:\"fas\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"ادامه\";}}s:2:\"fi\";a:8:{s:8:\"language\";s:2:\"fi\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 17:03:14\";s:12:\"english_name\";s:7:\"Finnish\";s:11:\"native_name\";s:5:\"Suomi\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/fi.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"fi\";i:2;s:3:\"fin\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:5:\"Jatka\";}}s:5:\"fr_FR\";a:8:{s:8:\"language\";s:5:\"fr_FR\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-21 18:40:27\";s:12:\"english_name\";s:15:\"French (France)\";s:11:\"native_name\";s:9:\"Français\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/fr_FR.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"fr\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuer\";}}s:5:\"fr_BE\";a:8:{s:8:\"language\";s:5:\"fr_BE\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2020-12-30 13:23:06\";s:12:\"english_name\";s:16:\"French (Belgium)\";s:11:\"native_name\";s:21:\"Français de Belgique\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/fr_BE.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"fr\";i:2;s:3:\"fra\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuer\";}}s:5:\"fr_CA\";a:8:{s:8:\"language\";s:5:\"fr_CA\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-18 20:41:21\";s:12:\"english_name\";s:15:\"French (Canada)\";s:11:\"native_name\";s:19:\"Français du Canada\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/fr_CA.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"fr\";i:2;s:3:\"fra\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuer\";}}s:3:\"fur\";a:8:{s:8:\"language\";s:3:\"fur\";s:7:\"version\";s:6:\"4.8.23\";s:7:\"updated\";s:19:\"2023-04-30 13:56:46\";s:12:\"english_name\";s:8:\"Friulian\";s:11:\"native_name\";s:8:\"Friulian\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/4.8.23/fur.zip\";s:3:\"iso\";a:2:{i:2;s:3:\"fur\";i:3;s:3:\"fur\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:2:\"gd\";a:8:{s:8:\"language\";s:2:\"gd\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-08-23 17:41:37\";s:12:\"english_name\";s:15:\"Scottish Gaelic\";s:11:\"native_name\";s:9:\"Gàidhlig\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/gd.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"gd\";i:2;s:3:\"gla\";i:3;s:3:\"gla\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:15:\"Lean air adhart\";}}s:5:\"gl_ES\";a:8:{s:8:\"language\";s:5:\"gl_ES\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-14 01:22:19\";s:12:\"english_name\";s:8:\"Galician\";s:11:\"native_name\";s:6:\"Galego\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/gl_ES.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"gl\";i:2;s:3:\"glg\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:2:\"gu\";a:8:{s:8:\"language\";s:2:\"gu\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2023-07-25 11:17:47\";s:12:\"english_name\";s:8:\"Gujarati\";s:11:\"native_name\";s:21:\"ગુજરાતી\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.9.24/gu.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"gu\";i:2;s:3:\"guj\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:25:\"ચાલુ રાખો\";}}s:3:\"haz\";a:8:{s:8:\"language\";s:3:\"haz\";s:7:\"version\";s:6:\"4.4.31\";s:7:\"updated\";s:19:\"2015-12-05 00:59:09\";s:12:\"english_name\";s:8:\"Hazaragi\";s:11:\"native_name\";s:15:\"هزاره گی\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/4.4.31/haz.zip\";s:3:\"iso\";a:1:{i:3;s:3:\"haz\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"ادامه\";}}s:5:\"he_IL\";a:8:{s:8:\"language\";s:5:\"he_IL\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-13 17:07:31\";s:12:\"english_name\";s:6:\"Hebrew\";s:11:\"native_name\";s:16:\"עִבְרִית\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/he_IL.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"he\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"המשך\";}}s:5:\"hi_IN\";a:8:{s:8:\"language\";s:5:\"hi_IN\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2023-08-08 11:04:01\";s:12:\"english_name\";s:5:\"Hindi\";s:11:\"native_name\";s:18:\"हिन्दी\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/hi_IN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"hi\";i:2;s:3:\"hin\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:25:\"जारी रखें\";}}s:2:\"hr\";a:8:{s:8:\"language\";s:2:\"hr\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-14 09:37:08\";s:12:\"english_name\";s:8:\"Croatian\";s:11:\"native_name\";s:8:\"Hrvatski\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/hr.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"hr\";i:2;s:3:\"hrv\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:7:\"Nastavi\";}}s:3:\"hsb\";a:8:{s:8:\"language\";s:3:\"hsb\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-11 22:06:45\";s:12:\"english_name\";s:13:\"Upper Sorbian\";s:11:\"native_name\";s:17:\"Hornjoserbšćina\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/translation/core/5.3/hsb.zip\";s:3:\"iso\";a:2:{i:2;s:3:\"hsb\";i:3;s:3:\"hsb\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:4:\"Dale\";}}s:5:\"hu_HU\";a:8:{s:8:\"language\";s:5:\"hu_HU\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2021-06-14 15:46:26\";s:12:\"english_name\";s:9:\"Hungarian\";s:11:\"native_name\";s:6:\"Magyar\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/hu_HU.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"hu\";i:2;s:3:\"hun\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"Folytatás\";}}s:2:\"hy\";a:8:{s:8:\"language\";s:2:\"hy\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-12-03 16:21:10\";s:12:\"english_name\";s:8:\"Armenian\";s:11:\"native_name\";s:14:\"Հայերեն\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/hy.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"hy\";i:2;s:3:\"hye\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:20:\"Շարունակել\";}}s:5:\"id_ID\";a:8:{s:8:\"language\";s:5:\"id_ID\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2023-04-05 13:19:48\";s:12:\"english_name\";s:10:\"Indonesian\";s:11:\"native_name\";s:16:\"Bahasa Indonesia\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/id_ID.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"id\";i:2;s:3:\"ind\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Lanjutkan\";}}s:5:\"is_IS\";a:8:{s:8:\"language\";s:5:\"is_IS\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2018-12-11 10:40:02\";s:12:\"english_name\";s:9:\"Icelandic\";s:11:\"native_name\";s:9:\"Íslenska\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.9.24/is_IS.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"is\";i:2;s:3:\"isl\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Áfram\";}}s:5:\"it_IT\";a:8:{s:8:\"language\";s:5:\"it_IT\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-22 10:38:54\";s:12:\"english_name\";s:7:\"Italian\";s:11:\"native_name\";s:8:\"Italiano\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/it_IT.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"it\";i:2;s:3:\"ita\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continua\";}}s:2:\"ja\";a:8:{s:8:\"language\";s:2:\"ja\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-21 05:08:19\";s:12:\"english_name\";s:8:\"Japanese\";s:11:\"native_name\";s:9:\"日本語\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/ja.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"ja\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"次へ\";}}s:5:\"jv_ID\";a:8:{s:8:\"language\";s:5:\"jv_ID\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2019-02-16 23:58:56\";s:12:\"english_name\";s:8:\"Javanese\";s:11:\"native_name\";s:9:\"Basa Jawa\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.9.24/jv_ID.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"jv\";i:2;s:3:\"jav\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Nerusaké\";}}s:5:\"ka_GE\";a:8:{s:8:\"language\";s:5:\"ka_GE\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2023-05-13 12:34:43\";s:12:\"english_name\";s:8:\"Georgian\";s:11:\"native_name\";s:21:\"ქართული\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/ka_GE.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ka\";i:2;s:3:\"kat\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:30:\"გაგრძელება\";}}s:3:\"kab\";a:8:{s:8:\"language\";s:3:\"kab\";s:7:\"version\";s:6:\"5.1.17\";s:7:\"updated\";s:19:\"2020-11-23 20:56:04\";s:12:\"english_name\";s:6:\"Kabyle\";s:11:\"native_name\";s:9:\"Taqbaylit\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/5.1.17/kab.zip\";s:3:\"iso\";a:2:{i:2;s:3:\"kab\";i:3;s:3:\"kab\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Kemmel\";}}s:2:\"kk\";a:8:{s:8:\"language\";s:2:\"kk\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2018-07-10 11:35:44\";s:12:\"english_name\";s:6:\"Kazakh\";s:11:\"native_name\";s:19:\"Қазақ тілі\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.9.24/kk.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"kk\";i:2;s:3:\"kaz\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:20:\"Жалғастыру\";}}s:2:\"km\";a:8:{s:8:\"language\";s:2:\"km\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2019-06-10 16:18:28\";s:12:\"english_name\";s:5:\"Khmer\";s:11:\"native_name\";s:27:\"ភាសាខ្មែរ\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.2.19/km.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"km\";i:2;s:3:\"khm\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"បន្ត\";}}s:2:\"kn\";a:8:{s:8:\"language\";s:2:\"kn\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2021-10-03 06:15:17\";s:12:\"english_name\";s:7:\"Kannada\";s:11:\"native_name\";s:15:\"ಕನ್ನಡ\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.9.24/kn.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"kn\";i:2;s:3:\"kan\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:30:\"ಮುಂದುವರಿಸು\";}}s:5:\"ko_KR\";a:8:{s:8:\"language\";s:5:\"ko_KR\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2023-06-08 00:41:01\";s:12:\"english_name\";s:6:\"Korean\";s:11:\"native_name\";s:9:\"한국어\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/ko_KR.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ko\";i:2;s:3:\"kor\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"계속\";}}s:3:\"ckb\";a:8:{s:8:\"language\";s:3:\"ckb\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2018-12-18 14:32:44\";s:12:\"english_name\";s:16:\"Kurdish (Sorani)\";s:11:\"native_name\";s:13:\"كوردی‎\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/4.9.24/ckb.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ku\";i:3;s:3:\"ckb\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:30:\"به‌رده‌وام به‌\";}}s:2:\"lo\";a:8:{s:8:\"language\";s:2:\"lo\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-11-12 09:59:23\";s:12:\"english_name\";s:3:\"Lao\";s:11:\"native_name\";s:21:\"ພາສາລາວ\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/lo.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"lo\";i:2;s:3:\"lao\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:18:\"ຕໍ່​ໄປ\";}}s:5:\"lt_LT\";a:8:{s:8:\"language\";s:5:\"lt_LT\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2023-08-19 11:44:20\";s:12:\"english_name\";s:10:\"Lithuanian\";s:11:\"native_name\";s:15:\"Lietuvių kalba\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/lt_LT.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"lt\";i:2;s:3:\"lit\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Tęsti\";}}s:2:\"lv\";a:8:{s:8:\"language\";s:2:\"lv\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2023-08-07 05:55:51\";s:12:\"english_name\";s:7:\"Latvian\";s:11:\"native_name\";s:16:\"Latviešu valoda\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.2.19/lv.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"lv\";i:2;s:3:\"lav\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Turpināt\";}}s:5:\"mk_MK\";a:8:{s:8:\"language\";s:5:\"mk_MK\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2019-09-08 12:57:25\";s:12:\"english_name\";s:10:\"Macedonian\";s:11:\"native_name\";s:31:\"Македонски јазик\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/mk_MK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"mk\";i:2;s:3:\"mkd\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:16:\"Продолжи\";}}s:5:\"ml_IN\";a:8:{s:8:\"language\";s:5:\"ml_IN\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-27 03:43:32\";s:12:\"english_name\";s:9:\"Malayalam\";s:11:\"native_name\";s:18:\"മലയാളം\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/4.7.2/ml_IN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ml\";i:2;s:3:\"mal\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:18:\"തുടരുക\";}}s:2:\"mn\";a:8:{s:8:\"language\";s:2:\"mn\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-12 07:29:35\";s:12:\"english_name\";s:9:\"Mongolian\";s:11:\"native_name\";s:12:\"Монгол\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/mn.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"mn\";i:2;s:3:\"mon\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:2:\"mr\";a:8:{s:8:\"language\";s:2:\"mr\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2019-11-22 15:32:08\";s:12:\"english_name\";s:7:\"Marathi\";s:11:\"native_name\";s:15:\"मराठी\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.9.24/mr.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"mr\";i:2;s:3:\"mar\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:25:\"सुरु ठेवा\";}}s:5:\"ms_MY\";a:8:{s:8:\"language\";s:5:\"ms_MY\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2022-02-20 09:23:22\";s:12:\"english_name\";s:5:\"Malay\";s:11:\"native_name\";s:13:\"Bahasa Melayu\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.9.24/ms_MY.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ms\";i:2;s:3:\"msa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Teruskan\";}}s:5:\"my_MM\";a:8:{s:8:\"language\";s:5:\"my_MM\";s:7:\"version\";s:6:\"4.2.36\";s:7:\"updated\";s:19:\"2017-12-26 11:57:10\";s:12:\"english_name\";s:17:\"Myanmar (Burmese)\";s:11:\"native_name\";s:15:\"ဗမာစာ\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.2.36/my_MM.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"my\";i:2;s:3:\"mya\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:54:\"ဆက်လက်လုပ်ဆောင်ပါ။\";}}s:5:\"nb_NO\";a:8:{s:8:\"language\";s:5:\"nb_NO\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-13 11:34:17\";s:12:\"english_name\";s:19:\"Norwegian (Bokmål)\";s:11:\"native_name\";s:13:\"Norsk bokmål\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/nb_NO.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"nb\";i:2;s:3:\"nob\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Fortsett\";}}s:5:\"ne_NP\";a:8:{s:8:\"language\";s:5:\"ne_NP\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2020-05-31 16:07:59\";s:12:\"english_name\";s:6:\"Nepali\";s:11:\"native_name\";s:18:\"नेपाली\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/ne_NP.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ne\";i:2;s:3:\"nep\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:43:\"जारी राख्नुहोस्\";}}s:5:\"nl_BE\";a:8:{s:8:\"language\";s:5:\"nl_BE\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-26 07:35:17\";s:12:\"english_name\";s:15:\"Dutch (Belgium)\";s:11:\"native_name\";s:20:\"Nederlands (België)\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/nl_BE.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"nl\";i:2;s:3:\"nld\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Doorgaan\";}}s:12:\"nl_NL_formal\";a:8:{s:8:\"language\";s:12:\"nl_NL_formal\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2020-10-29 20:49:15\";s:12:\"english_name\";s:14:\"Dutch (Formal)\";s:11:\"native_name\";s:20:\"Nederlands (Formeel)\";s:7:\"package\";s:72:\"https://downloads.wordpress.org/translation/core/5.2.19/nl_NL_formal.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"nl\";i:2;s:3:\"nld\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Doorgaan\";}}s:5:\"nl_NL\";a:8:{s:8:\"language\";s:5:\"nl_NL\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-26 09:11:38\";s:12:\"english_name\";s:5:\"Dutch\";s:11:\"native_name\";s:10:\"Nederlands\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/nl_NL.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"nl\";i:2;s:3:\"nld\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Doorgaan\";}}s:5:\"nn_NO\";a:8:{s:8:\"language\";s:5:\"nn_NO\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2019-10-24 08:39:27\";s:12:\"english_name\";s:19:\"Norwegian (Nynorsk)\";s:11:\"native_name\";s:13:\"Norsk nynorsk\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/nn_NO.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"nn\";i:2;s:3:\"nno\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Hald fram\";}}s:3:\"oci\";a:8:{s:8:\"language\";s:3:\"oci\";s:7:\"version\";s:6:\"4.8.23\";s:7:\"updated\";s:19:\"2017-08-25 10:03:08\";s:12:\"english_name\";s:7:\"Occitan\";s:11:\"native_name\";s:7:\"Occitan\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/4.8.23/oci.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"oc\";i:2;s:3:\"oci\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Contunhar\";}}s:5:\"pa_IN\";a:8:{s:8:\"language\";s:5:\"pa_IN\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-16 05:19:43\";s:12:\"english_name\";s:15:\"Panjabi (India)\";s:11:\"native_name\";s:18:\"ਪੰਜਾਬੀ\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/4.7.2/pa_IN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"pa\";i:2;s:3:\"pan\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:25:\"ਜਾਰੀ ਰੱਖੋ\";}}s:5:\"pl_PL\";a:8:{s:8:\"language\";s:5:\"pl_PL\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-27 15:05:00\";s:12:\"english_name\";s:6:\"Polish\";s:11:\"native_name\";s:6:\"Polski\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/pl_PL.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"pl\";i:2;s:3:\"pol\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Kontynuuj\";}}s:2:\"ps\";a:8:{s:8:\"language\";s:2:\"ps\";s:7:\"version\";s:6:\"4.3.32\";s:7:\"updated\";s:19:\"2015-12-02 21:41:29\";s:12:\"english_name\";s:6:\"Pashto\";s:11:\"native_name\";s:8:\"پښتو\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.3.32/ps.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ps\";i:2;s:3:\"pus\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:19:\"دوام ورکړه\";}}s:5:\"pt_BR\";a:8:{s:8:\"language\";s:5:\"pt_BR\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 18:56:59\";s:12:\"english_name\";s:19:\"Portuguese (Brazil)\";s:11:\"native_name\";s:20:\"Português do Brasil\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/pt_BR.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"pt\";i:2;s:3:\"por\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"pt_AO\";a:8:{s:8:\"language\";s:5:\"pt_AO\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 05:44:59\";s:12:\"english_name\";s:19:\"Portuguese (Angola)\";s:11:\"native_name\";s:20:\"Português de Angola\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/pt_AO.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"pt\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"pt_PT\";a:8:{s:8:\"language\";s:5:\"pt_PT\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2023-09-28 12:06:23\";s:12:\"english_name\";s:21:\"Portuguese (Portugal)\";s:11:\"native_name\";s:10:\"Português\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/pt_PT.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"pt\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:10:\"pt_PT_ao90\";a:8:{s:8:\"language\";s:10:\"pt_PT_ao90\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2023-09-28 12:14:28\";s:12:\"english_name\";s:27:\"Portuguese (Portugal, AO90)\";s:11:\"native_name\";s:17:\"Português (AO90)\";s:7:\"package\";s:70:\"https://downloads.wordpress.org/translation/core/5.2.19/pt_PT_ao90.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"pt\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:3:\"rhg\";a:8:{s:8:\"language\";s:3:\"rhg\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-03-16 13:03:18\";s:12:\"english_name\";s:8:\"Rohingya\";s:11:\"native_name\";s:8:\"Ruáinga\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/rhg.zip\";s:3:\"iso\";a:1:{i:3;s:3:\"rhg\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"ro_RO\";a:8:{s:8:\"language\";s:5:\"ro_RO\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-20 13:32:51\";s:12:\"english_name\";s:8:\"Romanian\";s:11:\"native_name\";s:8:\"Română\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/ro_RO.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ro\";i:2;s:3:\"ron\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuă\";}}s:5:\"ru_RU\";a:8:{s:8:\"language\";s:5:\"ru_RU\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-28 11:24:58\";s:12:\"english_name\";s:7:\"Russian\";s:11:\"native_name\";s:14:\"Русский\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/ru_RU.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ru\";i:2;s:3:\"rus\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:20:\"Продолжить\";}}s:3:\"sah\";a:8:{s:8:\"language\";s:3:\"sah\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-21 02:06:41\";s:12:\"english_name\";s:5:\"Sakha\";s:11:\"native_name\";s:14:\"Сахалыы\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/sah.zip\";s:3:\"iso\";a:2:{i:2;s:3:\"sah\";i:3;s:3:\"sah\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"Салҕаа\";}}s:3:\"snd\";a:8:{s:8:\"language\";s:3:\"snd\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 04:37:38\";s:12:\"english_name\";s:6:\"Sindhi\";s:11:\"native_name\";s:8:\"سنڌي\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/translation/core/5.3/snd.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"sd\";i:2;s:3:\"snd\";i:3;s:3:\"snd\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:15:\"اڳتي هلو\";}}s:5:\"si_LK\";a:8:{s:8:\"language\";s:5:\"si_LK\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-11-12 06:00:52\";s:12:\"english_name\";s:7:\"Sinhala\";s:11:\"native_name\";s:15:\"සිංහල\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/4.7.2/si_LK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"si\";i:2;s:3:\"sin\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:44:\"දිගටම කරගෙන යන්න\";}}s:5:\"sk_SK\";a:8:{s:8:\"language\";s:5:\"sk_SK\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-26 15:47:05\";s:12:\"english_name\";s:6:\"Slovak\";s:11:\"native_name\";s:11:\"Slovenčina\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/sk_SK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sk\";i:2;s:3:\"slk\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"Pokračovať\";}}s:3:\"skr\";a:8:{s:8:\"language\";s:3:\"skr\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2019-06-26 11:40:37\";s:12:\"english_name\";s:7:\"Saraiki\";s:11:\"native_name\";s:14:\"سرائیکی\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/5.2.19/skr.zip\";s:3:\"iso\";a:1:{i:3;s:3:\"skr\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:17:\"جاری رکھو\";}}s:5:\"sl_SI\";a:8:{s:8:\"language\";s:5:\"sl_SI\";s:7:\"version\";s:6:\"5.1.14\";s:7:\"updated\";s:19:\"2019-04-30 13:03:56\";s:12:\"english_name\";s:9:\"Slovenian\";s:11:\"native_name\";s:13:\"Slovenščina\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.1.14/sl_SI.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sl\";i:2;s:3:\"slv\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Nadaljuj\";}}s:2:\"sq\";a:8:{s:8:\"language\";s:2:\"sq\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-27 17:24:59\";s:12:\"english_name\";s:8:\"Albanian\";s:11:\"native_name\";s:5:\"Shqip\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/sq.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sq\";i:2;s:3:\"sqi\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Vazhdo\";}}s:5:\"sr_RS\";a:8:{s:8:\"language\";s:5:\"sr_RS\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-12 20:15:25\";s:12:\"english_name\";s:7:\"Serbian\";s:11:\"native_name\";s:23:\"Српски језик\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/sr_RS.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sr\";i:2;s:3:\"srp\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:14:\"Настави\";}}s:5:\"sv_SE\";a:8:{s:8:\"language\";s:5:\"sv_SE\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-23 22:47:16\";s:12:\"english_name\";s:7:\"Swedish\";s:11:\"native_name\";s:7:\"Svenska\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/sv_SE.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sv\";i:2;s:3:\"swe\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Fortsätt\";}}s:2:\"sw\";a:8:{s:8:\"language\";s:2:\"sw\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2019-10-22 00:19:41\";s:12:\"english_name\";s:7:\"Swahili\";s:11:\"native_name\";s:9:\"Kiswahili\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.2.19/sw.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sw\";i:2;s:3:\"swa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:7:\"Endelea\";}}s:3:\"szl\";a:8:{s:8:\"language\";s:3:\"szl\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-09-24 19:58:14\";s:12:\"english_name\";s:8:\"Silesian\";s:11:\"native_name\";s:17:\"Ślōnskŏ gŏdka\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/szl.zip\";s:3:\"iso\";a:1:{i:3;s:3:\"szl\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:13:\"Kōntynuować\";}}s:5:\"ta_IN\";a:8:{s:8:\"language\";s:5:\"ta_IN\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-27 03:22:47\";s:12:\"english_name\";s:5:\"Tamil\";s:11:\"native_name\";s:15:\"தமிழ்\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/4.7.2/ta_IN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ta\";i:2;s:3:\"tam\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:24:\"தொடரவும்\";}}s:5:\"ta_LK\";a:8:{s:8:\"language\";s:5:\"ta_LK\";s:7:\"version\";s:6:\"4.2.36\";s:7:\"updated\";s:19:\"2015-12-03 01:07:44\";s:12:\"english_name\";s:17:\"Tamil (Sri Lanka)\";s:11:\"native_name\";s:15:\"தமிழ்\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.2.36/ta_LK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ta\";i:2;s:3:\"tam\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:18:\"தொடர்க\";}}s:2:\"te\";a:8:{s:8:\"language\";s:2:\"te\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-26 15:47:39\";s:12:\"english_name\";s:6:\"Telugu\";s:11:\"native_name\";s:18:\"తెలుగు\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/te.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"te\";i:2;s:3:\"tel\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:30:\"కొనసాగించు\";}}s:2:\"th\";a:8:{s:8:\"language\";s:2:\"th\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2021-07-13 19:23:05\";s:12:\"english_name\";s:4:\"Thai\";s:11:\"native_name\";s:9:\"ไทย\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.2.19/th.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"th\";i:2;s:3:\"tha\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:15:\"ต่อไป\";}}s:2:\"tl\";a:8:{s:8:\"language\";s:2:\"tl\";s:7:\"version\";s:6:\"4.8.23\";s:7:\"updated\";s:19:\"2017-09-30 09:04:29\";s:12:\"english_name\";s:7:\"Tagalog\";s:11:\"native_name\";s:7:\"Tagalog\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.8.23/tl.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"tl\";i:2;s:3:\"tgl\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"Magpatuloy\";}}s:5:\"tr_TR\";a:8:{s:8:\"language\";s:5:\"tr_TR\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-13 11:42:48\";s:12:\"english_name\";s:7:\"Turkish\";s:11:\"native_name\";s:8:\"Türkçe\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/tr_TR.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"tr\";i:2;s:3:\"tur\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:5:\"Devam\";}}s:5:\"tt_RU\";a:8:{s:8:\"language\";s:5:\"tt_RU\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-11-20 20:20:50\";s:12:\"english_name\";s:5:\"Tatar\";s:11:\"native_name\";s:19:\"Татар теле\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/4.7.2/tt_RU.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"tt\";i:2;s:3:\"tat\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:17:\"дәвам итү\";}}s:3:\"tah\";a:8:{s:8:\"language\";s:3:\"tah\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-03-06 18:39:39\";s:12:\"english_name\";s:8:\"Tahitian\";s:11:\"native_name\";s:10:\"Reo Tahiti\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/tah.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"ty\";i:2;s:3:\"tah\";i:3;s:3:\"tah\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"ug_CN\";a:8:{s:8:\"language\";s:5:\"ug_CN\";s:7:\"version\";s:6:\"4.9.24\";s:7:\"updated\";s:19:\"2021-07-03 18:41:33\";s:12:\"english_name\";s:6:\"Uighur\";s:11:\"native_name\";s:16:\"ئۇيغۇرچە\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.9.24/ug_CN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ug\";i:2;s:3:\"uig\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:26:\"داۋاملاشتۇرۇش\";}}s:2:\"uk\";a:8:{s:8:\"language\";s:2:\"uk\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2021-04-18 15:43:06\";s:12:\"english_name\";s:9:\"Ukrainian\";s:11:\"native_name\";s:20:\"Українська\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.2.19/uk.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"uk\";i:2;s:3:\"ukr\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:20:\"Продовжити\";}}s:2:\"ur\";a:8:{s:8:\"language\";s:2:\"ur\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2021-03-24 07:22:35\";s:12:\"english_name\";s:4:\"Urdu\";s:11:\"native_name\";s:8:\"اردو\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.2.19/ur.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ur\";i:2;s:3:\"urd\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:19:\"جاری رکھیں\";}}s:5:\"uz_UZ\";a:8:{s:8:\"language\";s:5:\"uz_UZ\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2019-10-03 09:17:28\";s:12:\"english_name\";s:5:\"Uzbek\";s:11:\"native_name\";s:11:\"O‘zbekcha\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/uz_UZ.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"uz\";i:2;s:3:\"uzb\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:11:\"Davom etish\";}}s:2:\"vi\";a:8:{s:8:\"language\";s:2:\"vi\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-21 12:26:02\";s:12:\"english_name\";s:10:\"Vietnamese\";s:11:\"native_name\";s:14:\"Tiếng Việt\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/translation/core/5.3/vi.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"vi\";i:2;s:3:\"vie\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"Tiếp tục\";}}s:5:\"zh_CN\";a:8:{s:8:\"language\";s:5:\"zh_CN\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-14 00:41:45\";s:12:\"english_name\";s:15:\"Chinese (China)\";s:11:\"native_name\";s:12:\"简体中文\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/zh_CN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"zh\";i:2;s:3:\"zho\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"继续\";}}s:5:\"zh_HK\";a:8:{s:8:\"language\";s:5:\"zh_HK\";s:7:\"version\";s:6:\"5.2.19\";s:7:\"updated\";s:19:\"2022-01-20 08:52:23\";s:12:\"english_name\";s:19:\"Chinese (Hong Kong)\";s:11:\"native_name\";s:12:\"香港中文\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.19/zh_HK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"zh\";i:2;s:3:\"zho\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"繼續\";}}s:5:\"zh_TW\";a:8:{s:8:\"language\";s:5:\"zh_TW\";s:7:\"version\";s:3:\"5.3\";s:7:\"updated\";s:19:\"2019-11-17 13:26:53\";s:12:\"english_name\";s:16:\"Chinese (Taiwan)\";s:11:\"native_name\";s:12:\"繁體中文\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.3/zh_TW.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"zh\";i:2;s:3:\"zho\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"繼續\";}}}', 'no');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(4029, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:13:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:7:\"upgrade\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-6.4.1.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-6.4.1.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-6.4.1-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-6.4.1-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"6.4.1\";s:7:\"version\";s:5:\"6.4.1\";s:11:\"php_version\";s:5:\"7.0.0\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";}i:1;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-6.4.1.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-6.4.1.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-6.4.1-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-6.4.1-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"6.4.1\";s:7:\"version\";s:5:\"6.4.1\";s:11:\"php_version\";s:5:\"7.0.0\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:2;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-6.3.2.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-6.3.2.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-6.3.2-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-6.3.2-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"6.3.2\";s:7:\"version\";s:5:\"6.3.2\";s:11:\"php_version\";s:5:\"7.0.0\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:3;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-6.2.3.zip\";s:6:\"locale\";s:2:\"vi\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-6.2.3.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"6.2.3\";s:7:\"version\";s:5:\"6.2.3\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:4;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-6.1.4.zip\";s:6:\"locale\";s:2:\"vi\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-6.1.4.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"6.1.4\";s:7:\"version\";s:5:\"6.1.4\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:5;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-6.0.6.zip\";s:6:\"locale\";s:2:\"vi\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-6.0.6.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"6.0.6\";s:7:\"version\";s:5:\"6.0.6\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:6;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-5.9.8.zip\";s:6:\"locale\";s:2:\"vi\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-5.9.8.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.9.8\";s:7:\"version\";s:5:\"5.9.8\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:7;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-5.8.8.zip\";s:6:\"locale\";s:2:\"vi\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-5.8.8.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.8.8\";s:7:\"version\";s:5:\"5.8.8\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:8;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:63:\"https://downloads.wordpress.org/release/vi/wordpress-5.7.10.zip\";s:6:\"locale\";s:2:\"vi\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:63:\"https://downloads.wordpress.org/release/vi/wordpress-5.7.10.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:6:\"5.7.10\";s:7:\"version\";s:6:\"5.7.10\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:9;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:63:\"https://downloads.wordpress.org/release/vi/wordpress-5.6.12.zip\";s:6:\"locale\";s:2:\"vi\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:63:\"https://downloads.wordpress.org/release/vi/wordpress-5.6.12.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:6:\"5.6.12\";s:7:\"version\";s:6:\"5.6.12\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:10;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:63:\"https://downloads.wordpress.org/release/vi/wordpress-5.5.13.zip\";s:6:\"locale\";s:2:\"vi\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:63:\"https://downloads.wordpress.org/release/vi/wordpress-5.5.13.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:6:\"5.5.13\";s:7:\"version\";s:6:\"5.5.13\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:11;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:63:\"https://downloads.wordpress.org/release/vi/wordpress-5.4.14.zip\";s:6:\"locale\";s:2:\"vi\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:63:\"https://downloads.wordpress.org/release/vi/wordpress-5.4.14.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:6:\"5.4.14\";s:7:\"version\";s:6:\"5.4.14\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:12;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:63:\"https://downloads.wordpress.org/release/vi/wordpress-5.3.16.zip\";s:6:\"locale\";s:2:\"vi\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:63:\"https://downloads.wordpress.org/release/vi/wordpress-5.3.16.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:6:\"5.3.16\";s:7:\"version\";s:6:\"5.3.16\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}}s:12:\"last_checked\";i:1701185245;s:15:\"version_checked\";s:3:\"5.3\";s:12:\"translations\";a:0:{}}', 'no'),
(4030, '_site_transient_update_plugins', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1701185494;s:7:\"checked\";a:35:{s:33:\"admin-menu-editor/menu-editor.php\";s:6:\"1.10.2\";s:34:\"advanced-custom-fields-pro/acf.php\";s:6:\"5.7.10\";s:19:\"akismet/akismet.php\";s:6:\"4.1.10\";s:45:\"taxonomy-terms-order/taxonomy-terms-order.php\";s:5:\"1.6.1\";s:36:\"contact-form-7/wp-contact-form-7.php\";s:5:\"5.1.3\";s:24:\"elementors/elementor.php\";s:5:\"2.9.7\";s:33:\"elementors-refactor/elementor.php\";s:5:\"2.9.7\";s:33:\"duplicate-post/duplicate-post.php\";s:5:\"3.2.3\";s:53:\"facebook-for-woocommerce/facebook-for-woocommerce.php\";s:6:\"2.6.16\";s:9:\"hello.php\";s:5:\"1.7.2\";s:15:\"tutor/tutor.php\";s:5:\"2.0.0\";s:21:\"_lmspro/tutor-pro.php\";s:5:\"2.0.3\";s:20:\"lmspro/tutor-pro.php\";s:5:\"2.0.3\";s:37:\"post-types-order/post-types-order.php\";s:7:\"1.9.5.6\";s:27:\"woo-product-slider/main.php\";s:6:\"2.1.16\";s:51:\"rewrite-rules-inspector/rewrite-rules-inspector.php\";s:5:\"1.3.1\";s:21:\"safe-svg/safe-svg.php\";s:5:\"2.0.1\";s:27:\"svg-support/svg-support.php\";s:6:\"2.3.18\";s:37:\"tinymce-advanced/tinymce-advanced.php\";s:8:\"4.3.10.1\";s:41:\"_lmspro/tutor-lms-certificate-builder.php\";s:5:\"1.0.1\";s:37:\"user-role-editor/user-role-editor.php\";s:6:\"4.51.1\";s:27:\"woocommerce/woocommerce.php\";s:5:\"3.7.0\";s:39:\"woocommerce-admin/woocommerce-admin.php\";s:5:\"3.3.2\";s:37:\"woocommerce-ajax-cart/wooajaxcart.php\";s:5:\"1.3.5\";s:45:\"woocommerce-multilingual/wpml-woocommerce.php\";s:5:\"4.6.7\";s:69:\"woocommerce-per-product-shipping/woocommerce-shipping-per-product.php\";s:5:\"2.3.6\";s:51:\"wordpress-popular-posts/wordpress-popular-posts.php\";s:5:\"5.5.0\";s:42:\"woo-product-bundle/wpc-product-bundles.php\";s:5:\"5.2.6\";s:50:\"woo-product-bundle-premium/wpc-product-bundles.php\";s:5:\"5.3.1\";s:29:\"wp-mail-smtp/wp_mail_smtp.php\";s:5:\"3.0.3\";s:33:\"wpml-media-translation/plugin.php\";s:5:\"2.5.2\";s:34:\"wpml-string-translation/plugin.php\";s:6:\"2.10.4\";s:38:\"wpml-translation-management/plugin.php\";s:5:\"2.8.5\";s:27:\"wp-super-cache/wp-cache.php\";s:5:\"1.7.4\";s:24:\"wordpress-seo/wp-seo.php\";s:4:\"11.5\";}s:8:\"response\";a:13:{s:33:\"admin-menu-editor/menu-editor.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:31:\"w.org/plugins/admin-menu-editor\";s:4:\"slug\";s:17:\"admin-menu-editor\";s:6:\"plugin\";s:33:\"admin-menu-editor/menu-editor.php\";s:11:\"new_version\";s:4:\"1.12\";s:3:\"url\";s:48:\"https://wordpress.org/plugins/admin-menu-editor/\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/plugin/admin-menu-editor.1.12.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:70:\"https://ps.w.org/admin-menu-editor/assets/icon-128x128.png?rev=1418604\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:72:\"https://ps.w.org/admin-menu-editor/assets/banner-772x250.png?rev=1419590\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.7\";s:6:\"tested\";s:5:\"6.3.2\";s:12:\"requires_php\";s:3:\"5.6\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:45:\"taxonomy-terms-order/taxonomy-terms-order.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:34:\"w.org/plugins/taxonomy-terms-order\";s:4:\"slug\";s:20:\"taxonomy-terms-order\";s:6:\"plugin\";s:45:\"taxonomy-terms-order/taxonomy-terms-order.php\";s:11:\"new_version\";s:5:\"1.7.9\";s:3:\"url\";s:51:\"https://wordpress.org/plugins/taxonomy-terms-order/\";s:7:\"package\";s:69:\"https://downloads.wordpress.org/plugin/taxonomy-terms-order.1.7.9.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:73:\"https://ps.w.org/taxonomy-terms-order/assets/icon-256x256.png?rev=1564412\";s:2:\"1x\";s:73:\"https://ps.w.org/taxonomy-terms-order/assets/icon-128x128.png?rev=1564412\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:76:\"https://ps.w.org/taxonomy-terms-order/assets/banner-1544x500.png?rev=1564412\";s:2:\"1x\";s:75:\"https://ps.w.org/taxonomy-terms-order/assets/banner-772x250.png?rev=1564412\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"2.8\";s:6:\"tested\";s:5:\"6.3.2\";s:12:\"requires_php\";b:0;s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:15:\"tutor/tutor.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:19:\"w.org/plugins/tutor\";s:4:\"slug\";s:5:\"tutor\";s:6:\"plugin\";s:15:\"tutor/tutor.php\";s:11:\"new_version\";s:5:\"2.4.0\";s:3:\"url\";s:36:\"https://wordpress.org/plugins/tutor/\";s:7:\"package\";s:54:\"https://downloads.wordpress.org/plugin/tutor.2.4.0.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:58:\"https://ps.w.org/tutor/assets/icon-256x256.jpg?rev=2964518\";s:2:\"1x\";s:58:\"https://ps.w.org/tutor/assets/icon-128x128.jpg?rev=2964518\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:61:\"https://ps.w.org/tutor/assets/banner-1544x500.jpg?rev=2964518\";s:2:\"1x\";s:60:\"https://ps.w.org/tutor/assets/banner-772x250.jpg?rev=2964518\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.3\";s:6:\"tested\";s:5:\"6.3.2\";s:12:\"requires_php\";s:3:\"7.1\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:37:\"post-types-order/post-types-order.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:30:\"w.org/plugins/post-types-order\";s:4:\"slug\";s:16:\"post-types-order\";s:6:\"plugin\";s:37:\"post-types-order/post-types-order.php\";s:11:\"new_version\";s:5:\"2.1.1\";s:3:\"url\";s:47:\"https://wordpress.org/plugins/post-types-order/\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/plugin/post-types-order.2.1.1.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:69:\"https://ps.w.org/post-types-order/assets/icon-128x128.png?rev=1226428\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/post-types-order/assets/banner-1544x500.png?rev=1675574\";s:2:\"1x\";s:71:\"https://ps.w.org/post-types-order/assets/banner-772x250.png?rev=2870026\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"2.8\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";b:0;s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:27:\"woo-product-slider/main.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:32:\"w.org/plugins/woo-product-slider\";s:4:\"slug\";s:18:\"woo-product-slider\";s:6:\"plugin\";s:27:\"woo-product-slider/main.php\";s:11:\"new_version\";s:5:\"2.6.9\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/woo-product-slider/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/woo-product-slider.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:71:\"https://ps.w.org/woo-product-slider/assets/icon-256x256.png?rev=2727777\";s:2:\"1x\";s:71:\"https://ps.w.org/woo-product-slider/assets/icon-128x128.png?rev=2727777\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:73:\"https://ps.w.org/woo-product-slider/assets/banner-772x250.png?rev=2646089\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.0\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:3:\"5.6\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:27:\"svg-support/svg-support.php\";O:8:\"stdClass\":14:{s:2:\"id\";s:25:\"w.org/plugins/svg-support\";s:4:\"slug\";s:11:\"svg-support\";s:6:\"plugin\";s:27:\"svg-support/svg-support.php\";s:11:\"new_version\";s:5:\"2.5.5\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/svg-support/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/svg-support.2.5.5.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:56:\"https://ps.w.org/svg-support/assets/icon.svg?rev=1417738\";s:3:\"svg\";s:56:\"https://ps.w.org/svg-support/assets/icon.svg?rev=1417738\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/svg-support/assets/banner-1544x500.jpg?rev=1215377\";s:2:\"1x\";s:66:\"https://ps.w.org/svg-support/assets/banner-772x250.jpg?rev=1215377\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.8\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:3:\"7.2\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}s:14:\"upgrade_notice\";s:191:\"<p>Updating to 2.5+ Adds new features and addresses a number of earlier issues raised. Please take a backup before updating!\n2.5.5 fixes more reported errors in the 2.5 series of updates.</p>\";}s:37:\"user-role-editor/user-role-editor.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:30:\"w.org/plugins/user-role-editor\";s:4:\"slug\";s:16:\"user-role-editor\";s:6:\"plugin\";s:37:\"user-role-editor/user-role-editor.php\";s:11:\"new_version\";s:6:\"4.64.1\";s:3:\"url\";s:47:\"https://wordpress.org/plugins/user-role-editor/\";s:7:\"package\";s:66:\"https://downloads.wordpress.org/plugin/user-role-editor.4.64.1.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/user-role-editor/assets/icon-256x256.jpg?rev=1020390\";s:2:\"1x\";s:69:\"https://ps.w.org/user-role-editor/assets/icon-128x128.jpg?rev=1020390\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:71:\"https://ps.w.org/user-role-editor/assets/banner-772x250.png?rev=1263116\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.4\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:3:\"7.3\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:37:\"woocommerce-ajax-cart/wooajaxcart.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:35:\"w.org/plugins/woocommerce-ajax-cart\";s:4:\"slug\";s:21:\"woocommerce-ajax-cart\";s:6:\"plugin\";s:37:\"woocommerce-ajax-cart/wooajaxcart.php\";s:11:\"new_version\";s:6:\"1.3.25\";s:3:\"url\";s:52:\"https://wordpress.org/plugins/woocommerce-ajax-cart/\";s:7:\"package\";s:71:\"https://downloads.wordpress.org/plugin/woocommerce-ajax-cart.1.3.25.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:74:\"https://ps.w.org/woocommerce-ajax-cart/assets/icon-128x128.png?rev=1186993\";}s:7:\"banners\";a:0:{}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.0\";s:6:\"tested\";s:5:\"6.0.6\";s:12:\"requires_php\";b:0;s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:45:\"woocommerce-multilingual/wpml-woocommerce.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:38:\"w.org/plugins/woocommerce-multilingual\";s:4:\"slug\";s:24:\"woocommerce-multilingual\";s:6:\"plugin\";s:45:\"woocommerce-multilingual/wpml-woocommerce.php\";s:11:\"new_version\";s:5:\"5.2.1\";s:3:\"url\";s:55:\"https://wordpress.org/plugins/woocommerce-multilingual/\";s:7:\"package\";s:73:\"https://downloads.wordpress.org/plugin/woocommerce-multilingual.5.2.1.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:77:\"https://ps.w.org/woocommerce-multilingual/assets/icon-256x256.png?rev=2937122\";s:2:\"1x\";s:77:\"https://ps.w.org/woocommerce-multilingual/assets/icon-128x128.png?rev=2937122\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:79:\"https://ps.w.org/woocommerce-multilingual/assets/banner-772x250.png?rev=2937122\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.7\";s:6:\"tested\";s:5:\"6.3.2\";s:12:\"requires_php\";s:3:\"5.6\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:51:\"wordpress-popular-posts/wordpress-popular-posts.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:37:\"w.org/plugins/wordpress-popular-posts\";s:4:\"slug\";s:23:\"wordpress-popular-posts\";s:6:\"plugin\";s:51:\"wordpress-popular-posts/wordpress-popular-posts.php\";s:11:\"new_version\";s:5:\"6.3.4\";s:3:\"url\";s:54:\"https://wordpress.org/plugins/wordpress-popular-posts/\";s:7:\"package\";s:72:\"https://downloads.wordpress.org/plugin/wordpress-popular-posts.6.3.4.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:76:\"https://ps.w.org/wordpress-popular-posts/assets/icon-256x256.png?rev=1232659\";s:2:\"1x\";s:76:\"https://ps.w.org/wordpress-popular-posts/assets/icon-128x128.png?rev=1232659\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:79:\"https://ps.w.org/wordpress-popular-posts/assets/banner-1544x500.png?rev=2833992\";s:2:\"1x\";s:78:\"https://ps.w.org/wordpress-popular-posts/assets/banner-772x250.png?rev=2833998\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.3\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:3:\"7.2\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:42:\"woo-product-bundle/wpc-product-bundles.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:32:\"w.org/plugins/woo-product-bundle\";s:4:\"slug\";s:18:\"woo-product-bundle\";s:6:\"plugin\";s:42:\"woo-product-bundle/wpc-product-bundles.php\";s:11:\"new_version\";s:5:\"7.3.3\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/woo-product-bundle/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/woo-product-bundle.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:71:\"https://ps.w.org/woo-product-bundle/assets/icon-128x128.png?rev=1857793\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:73:\"https://ps.w.org/woo-product-bundle/assets/banner-772x250.png?rev=2425210\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";b:0;s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:29:\"wp-mail-smtp/wp_mail_smtp.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:26:\"w.org/plugins/wp-mail-smtp\";s:4:\"slug\";s:12:\"wp-mail-smtp\";s:6:\"plugin\";s:29:\"wp-mail-smtp/wp_mail_smtp.php\";s:11:\"new_version\";s:6:\"3.10.0\";s:3:\"url\";s:43:\"https://wordpress.org/plugins/wp-mail-smtp/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/plugin/wp-mail-smtp.3.10.0.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:65:\"https://ps.w.org/wp-mail-smtp/assets/icon-256x256.png?rev=1755440\";s:2:\"1x\";s:65:\"https://ps.w.org/wp-mail-smtp/assets/icon-128x128.png?rev=1755440\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/wp-mail-smtp/assets/banner-1544x500.jpg?rev=2811094\";s:2:\"1x\";s:67:\"https://ps.w.org/wp-mail-smtp/assets/banner-772x250.jpg?rev=2811094\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.2\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:3:\"7.2\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:20:\"lmspro/tutor-pro.php\";O:8:\"stdClass\":5:{s:11:\"new_version\";s:5:\"2.4.0\";s:7:\"package\";s:13:\"&product-key=\";s:6:\"tested\";s:5:\"6.3.2\";s:4:\"slug\";s:20:\"lmspro/tutor-pro.php\";s:3:\"url\";s:42:\"https://www.themeum.com/product/tutor-lms/\";}}s:12:\"translations\";a:7:{i:0;a:7:{s:4:\"type\";s:6:\"plugin\";s:4:\"slug\";s:7:\"akismet\";s:8:\"language\";s:2:\"vi\";s:7:\"version\";s:6:\"4.1.10\";s:7:\"updated\";s:19:\"2019-11-12 11:13:56\";s:7:\"package\";s:72:\"https://downloads.wordpress.org/translation/plugin/akismet/4.1.10/vi.zip\";s:10:\"autoupdate\";b:1;}i:1;a:7:{s:4:\"type\";s:6:\"plugin\";s:4:\"slug\";s:14:\"contact-form-7\";s:8:\"language\";s:2:\"vi\";s:7:\"version\";s:5:\"5.1.3\";s:7:\"updated\";s:19:\"2019-08-01 04:56:38\";s:7:\"package\";s:78:\"https://downloads.wordpress.org/translation/plugin/contact-form-7/5.1.3/vi.zip\";s:10:\"autoupdate\";b:1;}i:2;a:7:{s:4:\"type\";s:6:\"plugin\";s:4:\"slug\";s:14:\"duplicate-post\";s:8:\"language\";s:2:\"vi\";s:7:\"version\";s:5:\"3.2.3\";s:7:\"updated\";s:19:\"2019-07-13 13:53:21\";s:7:\"package\";s:78:\"https://downloads.wordpress.org/translation/plugin/duplicate-post/3.2.3/vi.zip\";s:10:\"autoupdate\";b:1;}i:3;a:7:{s:4:\"type\";s:6:\"plugin\";s:4:\"slug\";s:11:\"hello-dolly\";s:8:\"language\";s:2:\"vi\";s:7:\"version\";s:5:\"1.7.2\";s:7:\"updated\";s:19:\"2019-11-12 11:26:07\";s:7:\"package\";s:75:\"https://downloads.wordpress.org/translation/plugin/hello-dolly/1.7.2/vi.zip\";s:10:\"autoupdate\";b:1;}i:4;a:7:{s:4:\"type\";s:6:\"plugin\";s:4:\"slug\";s:11:\"woocommerce\";s:8:\"language\";s:2:\"vi\";s:7:\"version\";s:5:\"3.6.5\";s:7:\"updated\";s:19:\"2019-06-10 02:29:26\";s:7:\"package\";s:75:\"https://downloads.wordpress.org/translation/plugin/woocommerce/3.6.5/vi.zip\";s:10:\"autoupdate\";b:1;}i:5;a:7:{s:4:\"type\";s:6:\"plugin\";s:4:\"slug\";s:12:\"wp-mail-smtp\";s:8:\"language\";s:2:\"vi\";s:7:\"version\";s:5:\"3.0.3\";s:7:\"updated\";s:19:\"2019-11-12 11:21:12\";s:7:\"package\";s:76:\"https://downloads.wordpress.org/translation/plugin/wp-mail-smtp/3.0.3/vi.zip\";s:10:\"autoupdate\";b:1;}i:6;a:7:{s:4:\"type\";s:6:\"plugin\";s:4:\"slug\";s:13:\"wordpress-seo\";s:8:\"language\";s:2:\"vi\";s:7:\"version\";s:4:\"11.5\";s:7:\"updated\";s:19:\"2019-05-15 13:21:34\";s:7:\"package\";s:76:\"https://downloads.wordpress.org/translation/plugin/wordpress-seo/11.5/vi.zip\";s:10:\"autoupdate\";b:1;}}s:9:\"no_update\";a:11:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:3:\"5.3\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:54:\"https://downloads.wordpress.org/plugin/akismet.5.3.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:60:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=2818463\";s:2:\"1x\";s:60:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=2818463\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:63:\"https://ps.w.org/akismet/assets/banner-1544x500.png?rev=2900731\";s:2:\"1x\";s:62:\"https://ps.w.org/akismet/assets/banner-772x250.png?rev=2900731\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.8\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:6:\"5.6.20\";s:13:\"compatibility\";a:0:{}}s:36:\"contact-form-7/wp-contact-form-7.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:28:\"w.org/plugins/contact-form-7\";s:4:\"slug\";s:14:\"contact-form-7\";s:6:\"plugin\";s:36:\"contact-form-7/wp-contact-form-7.php\";s:11:\"new_version\";s:5:\"5.8.3\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/contact-form-7/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/contact-form-7.5.8.3.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:59:\"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255\";s:3:\"svg\";s:59:\"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/contact-form-7/assets/banner-1544x500.png?rev=860901\";s:2:\"1x\";s:68:\"https://ps.w.org/contact-form-7/assets/banner-772x250.png?rev=880427\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.2\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:3:\"7.4\";s:13:\"compatibility\";a:0:{}}s:33:\"duplicate-post/duplicate-post.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:28:\"w.org/plugins/duplicate-post\";s:4:\"slug\";s:14:\"duplicate-post\";s:6:\"plugin\";s:33:\"duplicate-post/duplicate-post.php\";s:11:\"new_version\";s:3:\"4.5\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/duplicate-post/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/duplicate-post.4.5.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/duplicate-post/assets/icon-256x256.png?rev=2336666\";s:2:\"1x\";s:67:\"https://ps.w.org/duplicate-post/assets/icon-128x128.png?rev=2336666\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/duplicate-post/assets/banner-1544x500.png?rev=2336666\";s:2:\"1x\";s:69:\"https://ps.w.org/duplicate-post/assets/banner-772x250.png?rev=2336666\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.2\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:6:\"5.6.20\";s:13:\"compatibility\";a:0:{}}s:53:\"facebook-for-woocommerce/facebook-for-woocommerce.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:38:\"w.org/plugins/facebook-for-woocommerce\";s:4:\"slug\";s:24:\"facebook-for-woocommerce\";s:6:\"plugin\";s:53:\"facebook-for-woocommerce/facebook-for-woocommerce.php\";s:11:\"new_version\";s:5:\"3.1.4\";s:3:\"url\";s:55:\"https://wordpress.org/plugins/facebook-for-woocommerce/\";s:7:\"package\";s:73:\"https://downloads.wordpress.org/plugin/facebook-for-woocommerce.3.1.4.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:69:\"https://ps.w.org/facebook-for-woocommerce/assets/icon.svg?rev=2040223\";s:3:\"svg\";s:69:\"https://ps.w.org/facebook-for-woocommerce/assets/icon.svg?rev=2040223\";}s:7:\"banners\";a:0:{}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.6\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";b:0;s:13:\"compatibility\";a:0:{}}s:9:\"hello.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/hello-dolly.1.7.3.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855\";s:2:\"1x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/hello-dolly/assets/banner-1544x500.jpg?rev=2645582\";s:2:\"1x\";s:66:\"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.6\";}s:51:\"rewrite-rules-inspector/rewrite-rules-inspector.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:37:\"w.org/plugins/rewrite-rules-inspector\";s:4:\"slug\";s:23:\"rewrite-rules-inspector\";s:6:\"plugin\";s:51:\"rewrite-rules-inspector/rewrite-rules-inspector.php\";s:11:\"new_version\";s:5:\"1.3.1\";s:3:\"url\";s:54:\"https://wordpress.org/plugins/rewrite-rules-inspector/\";s:7:\"package\";s:72:\"https://downloads.wordpress.org/plugin/rewrite-rules-inspector.1.3.1.zip\";s:5:\"icons\";a:1:{s:7:\"default\";s:74:\"https://s.w.org/plugins/geopattern-icon/rewrite-rules-inspector_e2e3e4.svg\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:79:\"https://ps.w.org/rewrite-rules-inspector/assets/banner-1544x500.png?rev=2533834\";s:2:\"1x\";s:78:\"https://ps.w.org/rewrite-rules-inspector/assets/banner-772x250.png?rev=2533843\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.1\";}s:21:\"safe-svg/safe-svg.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:22:\"w.org/plugins/safe-svg\";s:4:\"slug\";s:8:\"safe-svg\";s:6:\"plugin\";s:21:\"safe-svg/safe-svg.php\";s:11:\"new_version\";s:5:\"2.2.2\";s:3:\"url\";s:39:\"https://wordpress.org/plugins/safe-svg/\";s:7:\"package\";s:57:\"https://downloads.wordpress.org/plugin/safe-svg.2.2.2.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:53:\"https://ps.w.org/safe-svg/assets/icon.svg?rev=2779013\";s:3:\"svg\";s:53:\"https://ps.w.org/safe-svg/assets/icon.svg?rev=2779013\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/safe-svg/assets/banner-1544x500.png?rev=2683939\";s:2:\"1x\";s:63:\"https://ps.w.org/safe-svg/assets/banner-772x250.png?rev=2683939\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.7\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:3:\"7.4\";s:13:\"compatibility\";a:0:{}}s:37:\"tinymce-advanced/tinymce-advanced.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:30:\"w.org/plugins/tinymce-advanced\";s:4:\"slug\";s:16:\"tinymce-advanced\";s:6:\"plugin\";s:37:\"tinymce-advanced/tinymce-advanced.php\";s:11:\"new_version\";s:5:\"5.9.2\";s:3:\"url\";s:47:\"https://wordpress.org/plugins/tinymce-advanced/\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/plugin/tinymce-advanced.5.9.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/tinymce-advanced/assets/icon-256x256.png?rev=971511\";s:2:\"1x\";s:68:\"https://ps.w.org/tinymce-advanced/assets/icon-128x128.png?rev=971511\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/tinymce-advanced/assets/banner-1544x500.png?rev=2390186\";s:2:\"1x\";s:71:\"https://ps.w.org/tinymce-advanced/assets/banner-772x250.png?rev=2390186\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.9\";s:6:\"tested\";s:5:\"6.3.2\";s:12:\"requires_php\";s:3:\"5.6\";s:13:\"compatibility\";a:0:{}}s:27:\"woocommerce/woocommerce.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:25:\"w.org/plugins/woocommerce\";s:4:\"slug\";s:11:\"woocommerce\";s:6:\"plugin\";s:27:\"woocommerce/woocommerce.php\";s:11:\"new_version\";s:5:\"8.3.1\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/woocommerce/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/woocommerce.8.3.1.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/woocommerce/assets/icon-256x256.gif?rev=2869506\";s:2:\"1x\";s:64:\"https://ps.w.org/woocommerce/assets/icon-128x128.gif?rev=2869506\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/woocommerce/assets/banner-1544x500.png?rev=3000842\";s:2:\"1x\";s:66:\"https://ps.w.org/woocommerce/assets/banner-772x250.png?rev=3000842\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.3\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:3:\"7.4\";s:13:\"compatibility\";a:0:{}}s:27:\"wp-super-cache/wp-cache.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:28:\"w.org/plugins/wp-super-cache\";s:4:\"slug\";s:14:\"wp-super-cache\";s:6:\"plugin\";s:27:\"wp-super-cache/wp-cache.php\";s:11:\"new_version\";s:6:\"1.11.0\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/wp-super-cache/\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/plugin/wp-super-cache.1.11.0.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/wp-super-cache/assets/icon-256x256.png?rev=1095422\";s:2:\"1x\";s:67:\"https://ps.w.org/wp-super-cache/assets/icon-128x128.png?rev=1095422\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/wp-super-cache/assets/banner-1544x500.png?rev=1082414\";s:2:\"1x\";s:69:\"https://ps.w.org/wp-super-cache/assets/banner-772x250.png?rev=1082414\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.2\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:3:\"5.6\";s:13:\"compatibility\";a:0:{}}s:24:\"wordpress-seo/wp-seo.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:27:\"w.org/plugins/wordpress-seo\";s:4:\"slug\";s:13:\"wordpress-seo\";s:6:\"plugin\";s:24:\"wordpress-seo/wp-seo.php\";s:11:\"new_version\";s:4:\"21.6\";s:3:\"url\";s:44:\"https://wordpress.org/plugins/wordpress-seo/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/wordpress-seo.21.6.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:58:\"https://ps.w.org/wordpress-seo/assets/icon.svg?rev=2363699\";s:3:\"svg\";s:58:\"https://ps.w.org/wordpress-seo/assets/icon.svg?rev=2363699\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/wordpress-seo/assets/banner-1544x500.png?rev=2643727\";s:2:\"1x\";s:68:\"https://ps.w.org/wordpress-seo/assets/banner-772x250.png?rev=2643727\";}s:11:\"banners_rtl\";a:2:{s:2:\"2x\";s:73:\"https://ps.w.org/wordpress-seo/assets/banner-1544x500-rtl.png?rev=2643727\";s:2:\"1x\";s:72:\"https://ps.w.org/wordpress-seo/assets/banner-772x250-rtl.png?rev=2643727\";}s:8:\"requires\";s:3:\"6.2\";s:6:\"tested\";s:5:\"6.4.1\";s:12:\"requires_php\";s:5:\"7.2.5\";s:13:\"compatibility\";a:0:{}}}}', 'no'),
(4031, '_site_transient_update_themes', 'O:8:\"stdClass\":4:{s:12:\"last_checked\";i:1701185247;s:7:\"checked\";a:1:{s:7:\"site_el\";s:5:\"1.0.0\";}s:8:\"response\";a:0:{}s:12:\"translations\";a:0:{}}', 'no'),
(4042, 'course-category_children', 'a:0:{}', 'yes'),
(4046, '_transient_timeout_ure_users_without_role', '1701185420', 'no'),
(4047, '_transient_ure_users_without_role', '0', 'no'),
(4048, '_transient_timeout_plugin_slugs', '1701271896', 'no'),
(4049, '_transient_plugin_slugs', 'a:35:{i:0;s:33:\"admin-menu-editor/menu-editor.php\";i:1;s:34:\"advanced-custom-fields-pro/acf.php\";i:2;s:19:\"akismet/akismet.php\";i:3;s:45:\"taxonomy-terms-order/taxonomy-terms-order.php\";i:4;s:36:\"contact-form-7/wp-contact-form-7.php\";i:5;s:24:\"elementors/elementor.php\";i:6;s:33:\"elementors-refactor/elementor.php\";i:7;s:33:\"duplicate-post/duplicate-post.php\";i:8;s:53:\"facebook-for-woocommerce/facebook-for-woocommerce.php\";i:9;s:9:\"hello.php\";i:10;s:15:\"tutor/tutor.php\";i:11;s:21:\"_lmspro/tutor-pro.php\";i:12;s:20:\"lmspro/tutor-pro.php\";i:13;s:37:\"post-types-order/post-types-order.php\";i:14;s:27:\"woo-product-slider/main.php\";i:15;s:51:\"rewrite-rules-inspector/rewrite-rules-inspector.php\";i:16;s:21:\"safe-svg/safe-svg.php\";i:17;s:27:\"svg-support/svg-support.php\";i:18;s:37:\"tinymce-advanced/tinymce-advanced.php\";i:19;s:41:\"_lmspro/tutor-lms-certificate-builder.php\";i:20;s:37:\"user-role-editor/user-role-editor.php\";i:21;s:27:\"woocommerce/woocommerce.php\";i:22;s:39:\"woocommerce-admin/woocommerce-admin.php\";i:23;s:37:\"woocommerce-ajax-cart/wooajaxcart.php\";i:24;s:45:\"woocommerce-multilingual/wpml-woocommerce.php\";i:25;s:69:\"woocommerce-per-product-shipping/woocommerce-shipping-per-product.php\";i:26;s:51:\"wordpress-popular-posts/wordpress-popular-posts.php\";i:27;s:42:\"woo-product-bundle/wpc-product-bundles.php\";i:28;s:50:\"woo-product-bundle-premium/wpc-product-bundles.php\";i:29;s:29:\"wp-mail-smtp/wp_mail_smtp.php\";i:30;s:33:\"wpml-media-translation/plugin.php\";i:31;s:34:\"wpml-string-translation/plugin.php\";i:32;s:38:\"wpml-translation-management/plugin.php\";i:33;s:27:\"wp-super-cache/wp-cache.php\";i:34;s:24:\"wordpress-seo/wp-seo.php\";}', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 3, '_wp_page_template', 'default'),
(4, 11, '_wp_attached_file', 'woocommerce-placeholder.png'),
(5, 11, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1200;s:6:\"height\";i:1200;s:4:\"file\";s:27:\"woocommerce-placeholder.png\";s:5:\"sizes\";a:7:{s:21:\"woocommerce_thumbnail\";a:5:{s:4:\"file\";s:35:\"woocommerce-placeholder-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";s:9:\"uncropped\";b:0;}s:29:\"woocommerce_gallery_thumbnail\";a:4:{s:4:\"file\";s:35:\"woocommerce-placeholder-100x100.png\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:9:\"image/png\";}s:18:\"woocommerce_single\";a:4:{s:4:\"file\";s:35:\"woocommerce-placeholder-600x600.png\";s:5:\"width\";i:600;s:6:\"height\";i:600;s:9:\"mime-type\";s:9:\"image/png\";}s:6:\"medium\";a:4:{s:4:\"file\";s:35:\"woocommerce-placeholder-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:37:\"woocommerce-placeholder-1024x1024.png\";s:5:\"width\";i:1024;s:6:\"height\";i:1024;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:35:\"woocommerce-placeholder-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:35:\"woocommerce-placeholder-768x768.png\";s:5:\"width\";i:768;s:6:\"height\";i:768;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(47, 12, '_edit_lock', '1656954343:1'),
(48, 1, '_edit_lock', '1656991103:1'),
(90, 81, '_menu_item_type', 'custom'),
(91, 81, '_menu_item_menu_item_parent', '0'),
(92, 81, '_menu_item_object_id', '81'),
(93, 81, '_menu_item_object', 'custom'),
(94, 81, '_menu_item_target', ''),
(95, 81, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(96, 81, '_menu_item_xfn', ''),
(97, 81, '_menu_item_url', '#'),
(99, 82, '_menu_item_type', 'custom'),
(100, 82, '_menu_item_menu_item_parent', '0'),
(101, 82, '_menu_item_object_id', '82'),
(102, 82, '_menu_item_object', 'custom'),
(103, 82, '_menu_item_target', ''),
(104, 82, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(105, 82, '_menu_item_xfn', ''),
(106, 82, '_menu_item_url', '#'),
(108, 83, '_menu_item_type', 'custom'),
(109, 83, '_menu_item_menu_item_parent', '0'),
(110, 83, '_menu_item_object_id', '83'),
(111, 83, '_menu_item_object', 'custom'),
(112, 83, '_menu_item_target', ''),
(113, 83, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(114, 83, '_menu_item_xfn', ''),
(115, 83, '_menu_item_url', '#'),
(117, 84, '_menu_item_type', 'custom'),
(118, 84, '_menu_item_menu_item_parent', '0'),
(119, 84, '_menu_item_object_id', '84'),
(120, 84, '_menu_item_object', 'custom'),
(121, 84, '_menu_item_target', ''),
(122, 84, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(123, 84, '_menu_item_xfn', ''),
(124, 84, '_menu_item_url', '#'),
(126, 85, '_menu_item_type', 'custom'),
(127, 85, '_menu_item_menu_item_parent', '0'),
(128, 85, '_menu_item_object_id', '85'),
(129, 85, '_menu_item_object', 'custom'),
(130, 85, '_menu_item_target', ''),
(131, 85, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(132, 85, '_menu_item_xfn', ''),
(133, 85, '_menu_item_url', '#'),
(135, 86, '_menu_item_type', 'custom'),
(136, 86, '_menu_item_menu_item_parent', '0'),
(137, 86, '_menu_item_object_id', '86'),
(138, 86, '_menu_item_object', 'custom'),
(139, 86, '_menu_item_target', ''),
(140, 86, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(141, 86, '_menu_item_xfn', ''),
(142, 86, '_menu_item_url', '#'),
(144, 90, '_edit_lock', '1657528109:1'),
(149, 90, '_wp_old_slug', 'trang-chu'),
(150, 93, '_edit_lock', '1658931428:1'),
(151, 95, '_edit_lock', '1657530182:1'),
(152, 95, '_edit_last', '1'),
(153, 98, '_wp_attached_file', '2022/07/hero-banner-1-scaled.jpg'),
(154, 98, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:2560;s:6:\"height\";i:887;s:4:\"file\";s:32:\"2022/07/hero-banner-1-scaled.jpg\";s:5:\"sizes\";a:14:{s:6:\"medium\";a:4:{s:4:\"file\";s:25:\"hero-banner-1-300x104.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:104;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:26:\"hero-banner-1-1024x355.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:355;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:25:\"hero-banner-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:25:\"hero-banner-1-768x266.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:266;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"1536x1536\";a:4:{s:4:\"file\";s:26:\"hero-banner-1-1536x532.jpg\";s:5:\"width\";i:1536;s:6:\"height\";i:532;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"2048x2048\";a:4:{s:4:\"file\";s:26:\"hero-banner-1-2048x709.jpg\";s:5:\"width\";i:2048;s:6:\"height\";i:709;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:19:\"site-featured-image\";a:4:{s:4:\"file\";s:27:\"hero-banner-1-2000x1200.jpg\";s:5:\"width\";i:2000;s:6:\"height\";i:1200;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"site-thumbnail-avatar\";a:4:{s:4:\"file\";s:25:\"hero-banner-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"woocommerce_thumbnail\";a:5:{s:4:\"file\";s:25:\"hero-banner-1-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:9:\"uncropped\";b:0;}s:18:\"woocommerce_single\";a:4:{s:4:\"file\";s:25:\"hero-banner-1-600x208.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:208;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:29:\"woocommerce_gallery_thumbnail\";a:4:{s:4:\"file\";s:25:\"hero-banner-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"shop_catalog\";a:4:{s:4:\"file\";s:25:\"hero-banner-1-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:11:\"shop_single\";a:4:{s:4:\"file\";s:25:\"hero-banner-1-600x208.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:208;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"shop_thumbnail\";a:4:{s:4:\"file\";s:25:\"hero-banner-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}s:14:\"original_image\";s:17:\"hero-banner-1.jpg\";}'),
(155, 93, '_edit_last', '1'),
(156, 93, 'hero_banner_0_image', '109'),
(157, 93, '_hero_banner_0_image', 'field_62cbe2c6d2d40'),
(158, 93, 'hero_banner_1_image', '98'),
(159, 93, '_hero_banner_1_image', 'field_62cbe2c6d2d40'),
(160, 93, 'hero_banner', '2'),
(161, 93, '_hero_banner', 'field_62cbe268d2d3f'),
(162, 99, 'hero_banner_0_image', '98'),
(163, 99, '_hero_banner_0_image', 'field_62cbe2c6d2d40'),
(164, 99, 'hero_banner_1_image', '98'),
(165, 99, '_hero_banner_1_image', 'field_62cbe2c6d2d40'),
(166, 99, 'hero_banner', '2'),
(167, 99, '_hero_banner', 'field_62cbe268d2d3f'),
(174, 101, '_wp_attached_file', '2022/07/Rectangle-19.jpg'),
(175, 101, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1440;s:6:\"height\";i:350;s:4:\"file\";s:24:\"2022/07/Rectangle-19.jpg\";s:5:\"sizes\";a:11:{s:6:\"medium\";a:4:{s:4:\"file\";s:23:\"Rectangle-19-300x73.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:73;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:25:\"Rectangle-19-1024x249.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:249;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:24:\"Rectangle-19-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:24:\"Rectangle-19-768x187.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:187;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"site-thumbnail-avatar\";a:4:{s:4:\"file\";s:24:\"Rectangle-19-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"woocommerce_thumbnail\";a:5:{s:4:\"file\";s:24:\"Rectangle-19-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:9:\"uncropped\";b:0;}s:18:\"woocommerce_single\";a:4:{s:4:\"file\";s:24:\"Rectangle-19-600x146.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:146;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:29:\"woocommerce_gallery_thumbnail\";a:4:{s:4:\"file\";s:24:\"Rectangle-19-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"shop_catalog\";a:4:{s:4:\"file\";s:24:\"Rectangle-19-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:11:\"shop_single\";a:4:{s:4:\"file\";s:24:\"Rectangle-19-600x146.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:146;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"shop_thumbnail\";a:4:{s:4:\"file\";s:24:\"Rectangle-19-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(186, 103, '_edit_lock', '1657696497:1'),
(187, 103, '_edit_last', '1'),
(188, 103, '_regular_price', '2.300.000'),
(189, 103, '_sale_price', '2.100.000'),
(190, 103, 'total_sales', '0'),
(191, 103, '_tax_status', 'taxable'),
(192, 103, '_tax_class', ''),
(193, 103, '_manage_stock', 'no'),
(194, 103, '_backorders', 'no'),
(195, 103, '_sold_individually', 'no'),
(196, 103, '_virtual', 'no'),
(197, 103, '_downloadable', 'no'),
(198, 103, '_download_limit', '-1'),
(199, 103, '_download_expiry', '-1'),
(200, 103, '_stock', NULL),
(201, 103, '_stock_status', 'instock'),
(202, 103, '_wc_average_rating', '0'),
(203, 103, '_wc_review_count', '0'),
(204, 103, '_product_version', '3.7.0'),
(205, 103, '_price', '2.100.000'),
(206, 104, '_edit_lock', '1657696529:1'),
(207, 104, '_edit_last', '1'),
(208, 104, '_regular_price', '3000000'),
(209, 104, '_sale_price', '2800000'),
(210, 104, 'total_sales', '0'),
(211, 104, '_tax_status', 'taxable'),
(212, 104, '_tax_class', ''),
(213, 104, '_manage_stock', 'no'),
(214, 104, '_backorders', 'no'),
(215, 104, '_sold_individually', 'no'),
(216, 104, '_virtual', 'no'),
(217, 104, '_downloadable', 'no'),
(218, 104, '_download_limit', '-1'),
(219, 104, '_download_expiry', '-1'),
(220, 104, '_stock', NULL),
(221, 104, '_stock_status', 'instock'),
(222, 104, '_wc_average_rating', '0'),
(223, 104, '_wc_review_count', '0'),
(224, 104, '_product_version', '3.7.0'),
(225, 104, '_price', '2800000'),
(226, 105, '_edit_lock', '1657696686:1'),
(227, 105, '_edit_last', '1'),
(228, 105, '_regular_price', '3600000'),
(229, 105, '_sale_price', '3400000'),
(230, 105, 'total_sales', '0'),
(231, 105, '_tax_status', 'taxable'),
(232, 105, '_tax_class', ''),
(233, 105, '_manage_stock', 'no'),
(234, 105, '_backorders', 'no'),
(235, 105, '_sold_individually', 'no'),
(236, 105, '_virtual', 'no'),
(237, 105, '_downloadable', 'no'),
(238, 105, '_download_limit', '-1'),
(239, 105, '_download_expiry', '-1'),
(240, 105, '_stock', NULL),
(241, 105, '_stock_status', 'instock'),
(242, 105, '_wc_average_rating', '0'),
(243, 105, '_wc_review_count', '0'),
(244, 105, '_product_version', '3.7.0'),
(245, 105, '_price', '3400000'),
(256, 107, '_regular_price', '3600000'),
(257, 107, 'total_sales', '0'),
(258, 107, '_tax_status', 'taxable'),
(259, 107, '_tax_class', ''),
(260, 107, '_manage_stock', 'no'),
(261, 107, '_backorders', 'no'),
(262, 107, '_sold_individually', 'yes'),
(263, 107, '_virtual', 'yes'),
(264, 107, '_downloadable', 'no'),
(265, 107, '_download_limit', '-1'),
(266, 107, '_download_expiry', '-1'),
(267, 107, '_stock', NULL),
(268, 107, '_stock_status', 'instock'),
(269, 107, '_wc_average_rating', '0'),
(270, 107, '_wc_review_count', '0'),
(271, 107, '_product_version', '3.7.0'),
(272, 107, '_price', '3600000'),
(274, 107, '_tutor_product', 'yes'),
(275, 107, '_thumbnail_id', '101'),
(278, 110, 'hero_banner_0_image', '109'),
(279, 110, '_hero_banner_0_image', 'field_62cbe2c6d2d40'),
(280, 110, 'hero_banner_1_image', '98'),
(281, 110, '_hero_banner_1_image', 'field_62cbe2c6d2d40'),
(282, 110, 'hero_banner', '2'),
(283, 110, '_hero_banner', 'field_62cbe268d2d3f'),
(284, 111, 'hero_banner_0_image', '109'),
(285, 111, '_hero_banner_0_image', 'field_62cbe2c6d2d40'),
(286, 111, 'hero_banner_1_image', '98'),
(287, 111, '_hero_banner_1_image', 'field_62cbe2c6d2d40'),
(288, 111, 'hero_banner', '2'),
(289, 111, '_hero_banner', 'field_62cbe268d2d3f'),
(291, 112, '_edit_lock', '1657891366:1'),
(292, 112, '_edit_last', '1'),
(293, 114, '_wp_attached_file', '2022/07/Web-1920-–-1.jpg'),
(294, 114, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:888;s:6:\"height\";i:498;s:4:\"file\";s:26:\"2022/07/Web-1920-–-1.jpg\";s:5:\"sizes\";a:10:{s:6:\"medium\";a:4:{s:4:\"file\";s:26:\"Web-1920-–-1-300x168.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:168;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:26:\"Web-1920-–-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:26:\"Web-1920-–-1-768x431.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:431;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"site-thumbnail-avatar\";a:4:{s:4:\"file\";s:26:\"Web-1920-–-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"woocommerce_thumbnail\";a:5:{s:4:\"file\";s:26:\"Web-1920-–-1-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:9:\"uncropped\";b:0;}s:18:\"woocommerce_single\";a:4:{s:4:\"file\";s:26:\"Web-1920-–-1-600x336.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:336;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:29:\"woocommerce_gallery_thumbnail\";a:4:{s:4:\"file\";s:26:\"Web-1920-–-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"shop_catalog\";a:4:{s:4:\"file\";s:26:\"Web-1920-–-1-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:11:\"shop_single\";a:4:{s:4:\"file\";s:26:\"Web-1920-–-1-600x336.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:336;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"shop_thumbnail\";a:4:{s:4:\"file\";s:26:\"Web-1920-–-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(297, 115, '_wp_attached_file', '2022/07/Web-1920-–-1-1.jpg'),
(298, 115, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:888;s:6:\"height\";i:498;s:4:\"file\";s:28:\"2022/07/Web-1920-–-1-1.jpg\";s:5:\"sizes\";a:10:{s:6:\"medium\";a:4:{s:4:\"file\";s:28:\"Web-1920-–-1-1-300x168.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:168;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:28:\"Web-1920-–-1-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:28:\"Web-1920-–-1-1-768x431.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:431;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"site-thumbnail-avatar\";a:4:{s:4:\"file\";s:28:\"Web-1920-–-1-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"woocommerce_thumbnail\";a:5:{s:4:\"file\";s:28:\"Web-1920-–-1-1-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:9:\"uncropped\";b:0;}s:18:\"woocommerce_single\";a:4:{s:4:\"file\";s:28:\"Web-1920-–-1-1-600x336.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:336;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:29:\"woocommerce_gallery_thumbnail\";a:4:{s:4:\"file\";s:28:\"Web-1920-–-1-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"shop_catalog\";a:4:{s:4:\"file\";s:28:\"Web-1920-–-1-1-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:11:\"shop_single\";a:4:{s:4:\"file\";s:28:\"Web-1920-–-1-1-600x336.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:336;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"shop_thumbnail\";a:4:{s:4:\"file\";s:28:\"Web-1920-–-1-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(317, 117, '_wp_attached_file', '2022/07/c-1.jpg'),
(318, 117, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1024;s:6:\"height\";i:580;s:4:\"file\";s:15:\"2022/07/c-1.jpg\";s:5:\"sizes\";a:10:{s:6:\"medium\";a:4:{s:4:\"file\";s:15:\"c-1-300x170.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:170;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:15:\"c-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:15:\"c-1-768x435.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:435;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"site-thumbnail-avatar\";a:4:{s:4:\"file\";s:15:\"c-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"woocommerce_thumbnail\";a:5:{s:4:\"file\";s:15:\"c-1-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:9:\"uncropped\";b:0;}s:18:\"woocommerce_single\";a:4:{s:4:\"file\";s:15:\"c-1-600x340.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:340;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:29:\"woocommerce_gallery_thumbnail\";a:4:{s:4:\"file\";s:15:\"c-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"shop_catalog\";a:4:{s:4:\"file\";s:15:\"c-1-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:11:\"shop_single\";a:4:{s:4:\"file\";s:15:\"c-1-600x340.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:340;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"shop_thumbnail\";a:4:{s:4:\"file\";s:15:\"c-1-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(319, 118, '_wp_attached_file', '2022/07/c-2.jpg'),
(320, 118, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1231;s:6:\"height\";i:691;s:4:\"file\";s:15:\"2022/07/c-2.jpg\";s:5:\"sizes\";a:11:{s:6:\"medium\";a:4:{s:4:\"file\";s:15:\"c-2-300x168.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:168;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:16:\"c-2-1024x575.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:15:\"c-2-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:15:\"c-2-768x431.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:431;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"site-thumbnail-avatar\";a:4:{s:4:\"file\";s:15:\"c-2-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"woocommerce_thumbnail\";a:5:{s:4:\"file\";s:15:\"c-2-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:9:\"uncropped\";b:0;}s:18:\"woocommerce_single\";a:4:{s:4:\"file\";s:15:\"c-2-600x337.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:337;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:29:\"woocommerce_gallery_thumbnail\";a:4:{s:4:\"file\";s:15:\"c-2-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"shop_catalog\";a:4:{s:4:\"file\";s:15:\"c-2-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:11:\"shop_single\";a:4:{s:4:\"file\";s:15:\"c-2-600x337.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:337;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"shop_thumbnail\";a:4:{s:4:\"file\";s:15:\"c-2-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(321, 119, '_wp_attached_file', '2022/07/c-3.jpg'),
(322, 119, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1087;s:6:\"height\";i:610;s:4:\"file\";s:15:\"2022/07/c-3.jpg\";s:5:\"sizes\";a:11:{s:6:\"medium\";a:4:{s:4:\"file\";s:15:\"c-3-300x168.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:168;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:16:\"c-3-1024x575.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:15:\"c-3-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:15:\"c-3-768x431.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:431;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"site-thumbnail-avatar\";a:4:{s:4:\"file\";s:15:\"c-3-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"woocommerce_thumbnail\";a:5:{s:4:\"file\";s:15:\"c-3-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:9:\"uncropped\";b:0;}s:18:\"woocommerce_single\";a:4:{s:4:\"file\";s:15:\"c-3-600x337.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:337;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:29:\"woocommerce_gallery_thumbnail\";a:4:{s:4:\"file\";s:15:\"c-3-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"shop_catalog\";a:4:{s:4:\"file\";s:15:\"c-3-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:11:\"shop_single\";a:4:{s:4:\"file\";s:15:\"c-3-600x337.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:337;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"shop_thumbnail\";a:4:{s:4:\"file\";s:15:\"c-3-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(323, 120, '_wp_attached_file', '2022/07/c-4.jpg'),
(324, 120, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1123;s:6:\"height\";i:633;s:4:\"file\";s:15:\"2022/07/c-4.jpg\";s:5:\"sizes\";a:11:{s:6:\"medium\";a:4:{s:4:\"file\";s:15:\"c-4-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:16:\"c-4-1024x577.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:577;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:15:\"c-4-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:15:\"c-4-768x433.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:433;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"site-thumbnail-avatar\";a:4:{s:4:\"file\";s:15:\"c-4-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:21:\"woocommerce_thumbnail\";a:5:{s:4:\"file\";s:15:\"c-4-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:9:\"uncropped\";b:0;}s:18:\"woocommerce_single\";a:4:{s:4:\"file\";s:15:\"c-4-600x338.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:338;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:29:\"woocommerce_gallery_thumbnail\";a:4:{s:4:\"file\";s:15:\"c-4-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"shop_catalog\";a:4:{s:4:\"file\";s:15:\"c-4-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:11:\"shop_single\";a:4:{s:4:\"file\";s:15:\"c-4-600x338.jpg\";s:5:\"width\";i:600;s:6:\"height\";i:338;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"shop_thumbnail\";a:4:{s:4:\"file\";s:15:\"c-4-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(332, 123, '_regular_price', '1200000'),
(333, 123, 'total_sales', '0'),
(334, 123, '_tax_status', 'taxable'),
(335, 123, '_tax_class', ''),
(336, 123, '_manage_stock', 'no'),
(337, 123, '_backorders', 'no'),
(338, 123, '_sold_individually', 'yes'),
(339, 123, '_virtual', 'yes'),
(340, 123, '_downloadable', 'no'),
(341, 123, '_download_limit', '-1'),
(342, 123, '_download_expiry', '-1'),
(343, 123, '_stock', NULL),
(344, 123, '_stock_status', 'instock'),
(345, 123, '_wc_average_rating', '0'),
(346, 123, '_wc_review_count', '0'),
(347, 123, '_product_version', '3.7.0'),
(348, 123, '_price', '1200000'),
(350, 123, '_tutor_product', 'yes'),
(358, 125, '_edit_lock', '1658334427:1'),
(359, 128, '_edit_lock', '1658905895:1'),
(360, 7, '_edit_lock', '1658909668:1'),
(361, 130, '_edit_lock', '1658932845:1'),
(362, 130, '_edit_last', '1'),
(363, 132, '_wp_attached_file', '2022/07/home_sub_banner.png'),
(364, 132, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:2000;s:6:\"height\";i:581;s:4:\"file\";s:27:\"2022/07/home_sub_banner.png\";s:5:\"sizes\";a:12:{s:6:\"medium\";a:4:{s:4:\"file\";s:26:\"home_sub_banner-300x87.png\";s:5:\"width\";i:300;s:6:\"height\";i:87;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:28:\"home_sub_banner-1024x297.png\";s:5:\"width\";i:1024;s:6:\"height\";i:297;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:27:\"home_sub_banner-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:27:\"home_sub_banner-768x223.png\";s:5:\"width\";i:768;s:6:\"height\";i:223;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"1536x1536\";a:4:{s:4:\"file\";s:28:\"home_sub_banner-1536x446.png\";s:5:\"width\";i:1536;s:6:\"height\";i:446;s:9:\"mime-type\";s:9:\"image/png\";}s:21:\"site-thumbnail-avatar\";a:4:{s:4:\"file\";s:27:\"home_sub_banner-100x100.png\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:9:\"image/png\";}s:21:\"woocommerce_thumbnail\";a:5:{s:4:\"file\";s:27:\"home_sub_banner-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";s:9:\"uncropped\";b:0;}s:18:\"woocommerce_single\";a:4:{s:4:\"file\";s:27:\"home_sub_banner-600x174.png\";s:5:\"width\";i:600;s:6:\"height\";i:174;s:9:\"mime-type\";s:9:\"image/png\";}s:29:\"woocommerce_gallery_thumbnail\";a:4:{s:4:\"file\";s:27:\"home_sub_banner-100x100.png\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"shop_catalog\";a:4:{s:4:\"file\";s:27:\"home_sub_banner-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";}s:11:\"shop_single\";a:4:{s:4:\"file\";s:27:\"home_sub_banner-600x174.png\";s:5:\"width\";i:600;s:6:\"height\";i:174;s:9:\"mime-type\";s:9:\"image/png\";}s:14:\"shop_thumbnail\";a:4:{s:4:\"file\";s:27:\"home_sub_banner-100x100.png\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(365, 93, 'image', '132'),
(366, 93, '_image', 'field_62e0ff4d87289'),
(367, 133, 'hero_banner_0_image', '109'),
(368, 133, '_hero_banner_0_image', 'field_62cbe2c6d2d40'),
(369, 133, 'hero_banner_1_image', '98'),
(370, 133, '_hero_banner_1_image', 'field_62cbe2c6d2d40'),
(371, 133, 'hero_banner', '2'),
(372, 133, '_hero_banner', 'field_62cbe268d2d3f'),
(373, 133, 'image', '132'),
(374, 133, '_image', 'field_62e0ff4d87289'),
(375, 93, 'home_sub_banner', '132'),
(376, 93, '_home_sub_banner', 'field_62e0ff4d87289'),
(377, 134, 'hero_banner_0_image', '109'),
(378, 134, '_hero_banner_0_image', 'field_62cbe2c6d2d40'),
(379, 134, 'hero_banner_1_image', '98'),
(380, 134, '_hero_banner_1_image', 'field_62cbe2c6d2d40'),
(381, 134, 'hero_banner', '2'),
(382, 134, '_hero_banner', 'field_62cbe268d2d3f'),
(383, 134, 'image', '132'),
(384, 134, '_image', 'field_62e0ff4d87289'),
(385, 134, 'home_sub_banner', '132'),
(386, 134, '_home_sub_banner', 'field_62e0ff4d87289'),
(432, 142, '_regular_price', '2300000'),
(433, 142, 'total_sales', '0'),
(434, 142, '_tax_status', 'taxable'),
(435, 142, '_tax_class', ''),
(436, 142, '_manage_stock', 'no'),
(437, 142, '_backorders', 'no'),
(438, 142, '_sold_individually', 'yes'),
(439, 142, '_virtual', 'yes'),
(440, 142, '_downloadable', 'no'),
(441, 142, '_download_limit', '-1'),
(442, 142, '_download_expiry', '-1'),
(443, 142, '_stock', NULL),
(444, 142, '_stock_status', 'instock'),
(445, 142, '_wc_average_rating', '0'),
(446, 142, '_wc_review_count', '0'),
(447, 142, '_product_version', '3.7.0'),
(448, 142, '_price', '2300000'),
(450, 142, '_tutor_product', 'yes'),
(451, 142, '_thumbnail_id', '119'),
(462, 146, '_tutor_course_code', '00146'),
(463, 146, '_tutor_course_settings', 'a:3:{s:16:\"maximum_students\";s:1:\"0\";s:17:\"enrollment_expiry\";s:1:\"0\";s:26:\"_tutor_grade_point_average\";s:5:\"80.00\";}'),
(464, 146, '_tutor_course_price_type', 'free'),
(465, 146, '_course_duration', 'a:3:{s:5:\"hours\";s:2:\"00\";s:7:\"minutes\";s:2:\"00\";s:7:\"seconds\";s:2:\"00\";}'),
(466, 146, '_tutor_course_level', 'intermediate'),
(467, 146, '_video', 'a:8:{s:6:\"source\";s:2:\"-1\";s:15:\"source_video_id\";s:0:\"\";s:6:\"poster\";s:0:\"\";s:19:\"source_external_url\";s:0:\"\";s:16:\"source_shortcode\";s:0:\"\";s:14:\"source_youtube\";s:0:\"\";s:12:\"source_vimeo\";s:0:\"\";s:15:\"source_embedded\";s:0:\"\";}'),
(468, 146, '_tutor_enable_qa', 'yes'),
(469, 146, '_tutor_is_public_course', 'no'),
(470, 146, 'course_banner_image', ''),
(471, 146, '_course_banner_image', 'field_62d12341e59b1'),
(472, 146, '_tutor_course_parent', ''),
(473, 146, '_tutor_course_children', '');

-- --------------------------------------------------------

--
-- Table structure for table `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
CREATE TABLE `wp_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2022-07-01 02:30:09', '2022-07-01 02:30:09', '<!-- wp:paragraph -->\n<p>Cảm ơn vì đã sử dụng WordPress. Đây là bài viết đầu tiên của bạn. Sửa hoặc xóa nó, và bắt đầu bài viết của bạn nhé!</p>\n<!-- /wp:paragraph -->', 'Chào tất cả mọi người!', '', 'publish', 'open', 'open', '', 'chao-moi-nguoi', '', '', '2022-07-01 02:30:09', '2022-07-01 02:30:09', '', 0, 'http://mythosedu.com/?p=1', 0, 'post', '', 1),
(2, 1, '2022-07-01 02:30:09', '2022-07-01 02:30:09', '<!-- wp:paragraph -->\n<p>Đây là trang mẫu. Nó khác với bài viết bởi vì nó thường cố định và hiển thị trong menu của bạn. Nhiều người bắt đầu với trang Giới thiệu nơi bạn chia sẻ thông tin cho những ai ghé thăm. Nó có thể bắt đầu như thế này:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>Chào bạn! Tôi là một người bán hàng, và đây là website của tôi. Tôi sống ở Hà Nội, có một gia đình nhỏ, và tôi thấy cách sử dụng WordPress rất thú vị.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>... hoặc cái gì đó như thế này:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>Công ty chúng tôi được thành lập năm 2010, và cung cấp dịch vụ chất lượng cho rất nhiều sự kiện tại khắp Việt Nam. Với văn phòng đặt tại Hà Nội, TP. Hồ Chí Minh cùng hơn 40 nhân sự, chúng tôi là nơi nhiều đối tác tin tưởng giao cho tổ chức các sự kiện lớn.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>Là một người dùng WordPress mới, bạn nên ghé thăm <a href=\"http://mythosedu.com/wp-admin/\">bảng tin</a> để xóa trang này và tạo trang mới cho nội dung của chính bạn. Chúc bạn vui vẻ!</p>\n<!-- /wp:paragraph -->', 'Trang Mẫu', '', 'publish', 'closed', 'open', '', 'Trang mẫu', '', '', '2022-07-01 02:30:09', '2022-07-01 02:30:09', '', 0, 'http://mythosedu.com/?page_id=2', 0, 'page', '', 0),
(3, 1, '2022-07-01 02:30:09', '2022-07-01 02:30:09', '<!-- wp:heading --><h2>Chúng tôi là ai</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Địa chỉ website là: http://mythosedu.com.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Thông tin cá nhân nào bị thu thập và tại sao thu thập</h2><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Bình luận</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Khi khách truy cập để lại bình luận trên trang web, chúng tôi thu thập dữ liệu được hiển thị trong biểu mẫu bình luận và cũng là địa chỉ IP của người truy cập và chuỗi user agent của người dùng trình duyệt để giúp phát hiện spam</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Một chuỗi ẩn danh được tạo từ địa chỉ email của bạn (còn được gọi là hash) có thể được cung cấp cho dịch vụ Gravatar để xem bạn có đang sử dụng nó hay không. Chính sách bảo mật của dịch vụ Gravatar có tại đây: http://automattic.com/privacy/. Sau khi chấp nhận bình luận của bạn, ảnh tiểu sử của bạn được hiển thị công khai trong ngữ cảnh bình luận của bạn.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Thư viện</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Nếu bạn tải hình ảnh lên trang web, bạn nên tránh tải lên hình ảnh có dữ liệu vị trí được nhúng (EXIF GPS) đi kèm. Khách truy cập vào trang web có thể tải xuống và giải nén bất kỳ dữ liệu vị trí nào từ hình ảnh trên trang web.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Thông tin liên hệ</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Cookies</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Nếu bạn viết bình luận trong website, bạn có thể cung cấp cần nhập tên, email địa chỉ website trong cookie. Các thông tin này nhằm giúp bạn không cần nhập thông tin nhiều lần khi viết bình luận khác. Cookie này sẽ được lưu giữ trong một năm.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Nếu bạn vào trang đăng nhập, chúng tôi sẽ thiết lập một cookie tạm thời để xác định nếu trình duyệt cho phép sử dụng cookie. Cookie này không bao gồm thông tin cá nhân và sẽ được gỡ bỏ khi bạn đóng trình duyệt.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Khi bạn đăng nhập, chúng tôi sẽ thiết lập một vài cookie để lưu thông tin đăng nhập và lựa chọn hiển thị. Thông tin đăng nhập gần nhất lưu trong hai ngày, và lựa chọn hiển thị gần nhất lưu trong một năm. Nếu bạn chọn &quot;Nhớ tôi&quot;, thông tin đăng nhập sẽ được lưu trong hai tuần. Nếu bạn thoát tài khoản, thông tin cookie đăng nhập sẽ bị xoá.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Nếu bạn sửa hoặc công bố bài viết, một bản cookie bổ sung sẽ được lưu trong trình duyệt. Cookie này không chứa thông tin cá nhân và chỉ đơn giản bao gồm ID của bài viết bạn đã sửa. Nó tự động hết hạn sau 1 ngày.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Nội dung nhúng từ website khác</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Các bài viết trên trang web này có thể bao gồm nội dung được nhúng (ví dụ: video, hình ảnh, bài viết, v.v.). Nội dung được nhúng từ các trang web khác hoạt động theo cùng một cách chính xác như khi khách truy cập đã truy cập trang web khác.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Những website này có thể thu thập dữ liệu về bạn, sử dụng cookie, nhúng các trình theo dõi của bên thứ ba và giám sát tương tác của bạn với nội dung được nhúng đó, bao gồm theo dõi tương tác của bạn với nội dung được nhúng nếu bạn có tài khoản và đã đăng nhập vào trang web đó.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Phân tích</h3><!-- /wp:heading --><!-- wp:heading --><h2>Chúng tôi chia sẻ dữ liệu của bạn với ai</h2><!-- /wp:heading --><!-- wp:heading --><h2>Dữ liệu của bạn tồn tại bao lâu</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Nếu bạn để lại bình luận, bình luận và siêu dữ liệu của nó sẽ được giữ lại vô thời hạn. Điều này là để chúng tôi có thể tự động nhận ra và chấp nhận bất kỳ bình luận nào thay vì giữ chúng trong khu vực đợi kiểm duyệt.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Đối với người dùng đăng ký trên trang web của chúng tôi (nếu có), chúng tôi cũng lưu trữ thông tin cá nhân mà họ cung cấp trong hồ sơ người dùng của họ. Tất cả người dùng có thể xem, chỉnh sửa hoặc xóa thông tin cá nhân của họ bất kỳ lúc nào (ngoại trừ họ không thể thay đổi tên người dùng của họ). Quản trị viên trang web cũng có thể xem và chỉnh sửa thông tin đó.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Các quyền nào của bạn với dữ liệu của mình</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Nếu bạn có tài khoản trên trang web này hoặc đã để lại nhận xét, bạn có thể yêu cầu nhận tệp xuất dữ liệu cá nhân mà chúng tôi lưu giữ về bạn, bao gồm mọi dữ liệu bạn đã cung cấp cho chúng tôi. Bạn cũng có thể yêu cầu chúng tôi xóa mọi dữ liệu cá nhân mà chúng tôi lưu giữ về bạn. Điều này không bao gồm bất kỳ dữ liệu nào chúng tôi có nghĩa vụ giữ cho các mục đích hành chính, pháp lý hoặc bảo mật.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Các dữ liệu của bạn được gửi tới đâu</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Các bình luận của khách (không phải là thành viên) có thể được kiểm tra thông qua dịch vụ tự động phát hiện spam.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Thông tin liên hệ của bạn</h2><!-- /wp:heading --><!-- wp:heading --><h2>Thông tin bổ sung</h2><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Cách chúng tôi bảo vệ dữ liệu của bạn</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Các quá trình tiết lộ dữ liệu mà chúng tôi thực hiện</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Những bên thứ ba chúng tôi nhận dữ liệu từ đó</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Việc quyết định và/hoặc thu thập thông tin tự động mà chúng tôi áp dụng với dữ liệu người dùng</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Các yêu cầu công bố thông tin được quản lý</h3><!-- /wp:heading -->', 'Chính sách bảo mật', '', 'draft', 'closed', 'open', '', 'chinh-sach-bao-mat', '', '', '2022-07-01 02:30:09', '2022-07-01 02:30:09', '', 0, 'http://mythosedu.com/?page_id=3', 0, 'page', '', 0),
(6, 1, '2022-07-01 02:57:29', '2022-07-01 02:57:29', '', 'Dashboard', '', 'publish', 'closed', 'closed', '', 'dashboard', '', '', '2022-07-01 02:57:29', '2022-07-01 02:57:29', '', 0, 'http://mythosedu.com/?page_id=6', 0, 'page', '', 0),
(7, 1, '2022-07-01 02:57:29', '2022-07-01 02:57:29', '[tutor_student_registration_form]', 'Student Registration', '', 'publish', 'closed', 'closed', '', 'student-registration', '', '', '2022-07-01 02:57:29', '2022-07-01 02:57:29', '', 0, 'http://mythosedu.com/?page_id=7', 0, 'page', '', 0),
(8, 1, '2022-07-01 02:57:29', '2022-07-01 02:57:29', '[tutor_instructor_registration_form]', 'Instructor Registration', '', 'publish', 'closed', 'closed', '', 'instructor-registration', '', '', '2022-07-01 02:57:29', '2022-07-01 02:57:29', '', 0, 'http://mythosedu.com/?page_id=8', 0, 'page', '', 0),
(11, 1, '2022-07-01 07:32:32', '2022-07-01 07:32:32', '', 'woocommerce-placeholder', '', 'inherit', 'open', 'closed', '', 'woocommerce-placeholder', '', '', '2022-07-01 07:32:32', '2022-07-01 07:32:32', '', 0, 'http://mythosedu.com/wp-content/uploads/2022/07/woocommerce-placeholder.png', 0, 'attachment', 'image/png', 0),
(12, 1, '2022-07-01 07:33:28', '2022-07-01 07:33:28', '', 'Shop', '', 'publish', 'closed', 'closed', '', 'shop', '', '', '2022-07-01 07:33:28', '2022-07-01 07:33:28', '', 0, 'http://mythosedu.com/shop/', 0, 'page', '', 0),
(13, 1, '2022-07-01 07:33:28', '2022-07-01 07:33:28', '<!-- wp:shortcode -->[woocommerce_cart]<!-- /wp:shortcode -->', 'Cart', '', 'publish', 'closed', 'closed', '', 'cart', '', '', '2022-07-01 07:33:28', '2022-07-01 07:33:28', '', 0, 'http://mythosedu.com/cart/', 0, 'page', '', 0),
(14, 1, '2022-07-01 07:33:28', '2022-07-01 07:33:28', '<!-- wp:shortcode -->[woocommerce_checkout]<!-- /wp:shortcode -->', 'Checkout', '', 'publish', 'closed', 'closed', '', 'checkout', '', '', '2022-07-01 07:33:28', '2022-07-01 07:33:28', '', 0, 'http://mythosedu.com/checkout/', 0, 'page', '', 0),
(15, 1, '2022-07-01 07:33:28', '2022-07-01 07:33:28', '<!-- wp:shortcode -->[woocommerce_my_account]<!-- /wp:shortcode -->', 'My account', '', 'publish', 'closed', 'closed', '', 'my-account', '', '', '2022-07-01 07:33:28', '2022-07-01 07:33:28', '', 0, 'http://mythosedu.com/my-account/', 0, 'page', '', 0),
(32, 1, '2022-07-01 09:38:00', '2022-07-01 09:38:00', '', 'Course Enrolled &ndash; 1 July, 2022 @ 9:38 am', '', 'completed', 'closed', 'closed', '', 'course-enrolled-1-july-2022-938-am', '', '', '2022-07-01 09:38:00', '2022-07-01 09:38:00', '', 31, 'http://mythosedu.com/tutor_enrolled/course-enrolled-1-july-2022-938-am/', 0, 'tutor_enrolled', '', 0),
(81, 1, '2022-07-06 02:51:29', '2022-07-06 02:51:29', '', 'Your learning', '', 'publish', 'closed', 'closed', '', 'your-learning', '', '', '2022-07-06 03:00:48', '2022-07-06 03:00:48', '', 0, 'http://mythosedu.com/?p=81', 1, 'nav_menu_item', '', 0),
(82, 1, '2022-07-06 03:00:48', '2022-07-06 03:00:48', '', 'Explore courses', '', 'publish', 'closed', 'closed', '', 'explore-courses', '', '', '2022-07-06 03:00:48', '2022-07-06 03:00:48', '', 0, 'http://mythosedu.com/?p=82', 2, 'nav_menu_item', '', 0),
(83, 1, '2022-07-06 03:02:23', '2022-07-06 03:02:23', '', 'About', '', 'publish', 'closed', 'closed', '', 'about', '', '', '2022-07-06 03:02:23', '2022-07-06 03:02:23', '', 0, 'http://mythosedu.com/?p=83', 1, 'nav_menu_item', '', 0),
(84, 1, '2022-07-06 03:02:23', '2022-07-06 03:02:23', '', 'Privacy Policy', '', 'publish', 'closed', 'closed', '', 'privacy-policy', '', '', '2022-07-06 03:02:23', '2022-07-06 03:02:23', '', 0, 'http://mythosedu.com/?p=84', 2, 'nav_menu_item', '', 0),
(85, 1, '2022-07-06 03:02:23', '2022-07-06 03:02:23', '', 'Terms of Service', '', 'publish', 'closed', 'closed', '', 'terms-of-service', '', '', '2022-07-06 03:02:23', '2022-07-06 03:02:23', '', 0, 'http://mythosedu.com/?p=85', 3, 'nav_menu_item', '', 0),
(86, 1, '2022-07-06 03:02:23', '2022-07-06 03:02:23', '', 'Contact Us', '', 'publish', 'closed', 'closed', '', 'contact-us', '', '', '2022-07-06 03:02:23', '2022-07-06 03:02:23', '', 0, 'http://mythosedu.com/?p=86', 4, 'nav_menu_item', '', 0),
(87, 1, '2022-07-06 14:49:41', '2022-07-06 14:49:41', '', 'Course Enrolled &ndash; 6 July, 2022 @ 2:49 pm', '', 'completed', 'closed', 'closed', '', 'course-enrolled-6-july-2022-249-pm', '', '', '2022-07-06 14:49:41', '2022-07-06 14:49:41', '', 62, 'http://mythosedu.com/tutor_enrolled/course-enrolled-6-july-2022-249-pm/', 0, 'tutor_enrolled', '', 0),
(88, 3, '2022-07-06 15:23:41', '2022-07-06 15:23:41', '', 'Course Enrolled &ndash; 6 July, 2022 @ 3:23 pm', '', 'completed', 'closed', 'closed', '', 'course-enrolled-6-july-2022-323-pm', '', '', '2022-07-06 15:23:41', '2022-07-06 15:23:41', '', 62, 'http://mythosedu.com/tutor_enrolled/course-enrolled-6-july-2022-323-pm/', 0, 'tutor_enrolled', '', 0),
(90, 1, '2022-07-11 08:29:54', '2022-07-11 08:29:54', '', 'Home', '', 'publish', 'open', 'open', '', 'home', '', '', '2022-07-11 08:30:28', '2022-07-11 08:30:28', '', 0, 'http://mythosedu.com/?p=90', 0, 'post', '', 0),
(91, 1, '2022-07-11 08:29:54', '2022-07-11 08:29:54', '', 'Trang chủ', '', 'inherit', 'closed', 'closed', '', '90-revision-v1', '', '', '2022-07-11 08:29:54', '2022-07-11 08:29:54', '', 90, 'http://mythosedu.com/90-revision-v1/', 0, 'revision', '', 0),
(92, 1, '2022-07-11 08:30:16', '2022-07-11 08:30:16', '', 'Home', '', 'inherit', 'closed', 'closed', '', '90-revision-v1', '', '', '2022-07-11 08:30:16', '2022-07-11 08:30:16', '', 90, 'http://mythosedu.com/90-revision-v1/', 0, 'revision', '', 0),
(93, 1, '2022-07-11 08:34:34', '2022-07-11 08:34:34', '', 'Home', '', 'publish', 'closed', 'closed', '', 'home', '', '', '2022-07-27 09:08:45', '2022-07-27 09:08:45', '', 0, 'http://mythosedu.com/?page_id=93', 0, 'page', '', 0),
(94, 1, '2022-07-11 08:34:34', '2022-07-11 08:34:34', '', 'Home', '', 'inherit', 'closed', 'closed', '', '93-revision-v1', '', '', '2022-07-11 08:34:34', '2022-07-11 08:34:34', '', 93, 'http://mythosedu.com/93-revision-v1/', 0, 'revision', '', 0),
(95, 1, '2022-07-11 08:44:17', '2022-07-11 08:44:17', 'a:7:{s:8:\"location\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"param\";s:4:\"page\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:2:\"93\";}}}s:8:\"position\";s:6:\"normal\";s:5:\"style\";s:7:\"default\";s:15:\"label_placement\";s:3:\"top\";s:21:\"instruction_placement\";s:5:\"label\";s:14:\"hide_on_screen\";s:0:\"\";s:11:\"description\";s:0:\"\";}', 'Home sliders', 'home-sliders', 'publish', 'closed', 'closed', '', 'group_62cbe25c03d77', '', '', '2022-07-11 08:44:17', '2022-07-11 08:44:17', '', 0, 'http://mythosedu.com/?post_type=acf-field-group&#038;p=95', 1, 'acf-field-group', '', 0),
(96, 1, '2022-07-11 08:44:17', '2022-07-11 08:44:17', 'a:10:{s:4:\"type\";s:8:\"repeater\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:9:\"collapsed\";s:0:\"\";s:3:\"min\";s:0:\"\";s:3:\"max\";s:0:\"\";s:6:\"layout\";s:5:\"table\";s:12:\"button_label\";s:0:\"\";}', 'Hero banner', 'hero_banner', 'publish', 'closed', 'closed', '', 'field_62cbe268d2d3f', '', '', '2022-07-11 08:44:17', '2022-07-11 08:44:17', '', 95, 'http://mythosedu.com/?post_type=acf-field&p=96', 0, 'acf-field', '', 0),
(97, 1, '2022-07-11 08:44:17', '2022-07-11 08:44:17', 'a:15:{s:4:\"type\";s:5:\"image\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"return_format\";s:3:\"url\";s:12:\"preview_size\";s:9:\"1536x1536\";s:7:\"library\";s:3:\"all\";s:9:\"min_width\";s:0:\"\";s:10:\"min_height\";s:0:\"\";s:8:\"min_size\";s:0:\"\";s:9:\"max_width\";s:0:\"\";s:10:\"max_height\";s:0:\"\";s:8:\"max_size\";s:0:\"\";s:10:\"mime_types\";s:0:\"\";}', 'Image', 'image', 'publish', 'closed', 'closed', '', 'field_62cbe2c6d2d40', '', '', '2022-07-11 08:44:17', '2022-07-11 08:44:17', '', 96, 'http://mythosedu.com/?post_type=acf-field&p=97', 0, 'acf-field', '', 0),
(98, 1, '2022-07-11 08:50:10', '2022-07-11 08:50:10', '', 'hero-banner-1', '', 'inherit', 'open', 'closed', '', 'hero-banner-1', '', '', '2022-07-11 08:50:10', '2022-07-11 08:50:10', '', 93, 'http://mythosedu.com/wp-content/uploads/2022/07/hero-banner-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(99, 1, '2022-07-11 08:50:47', '2022-07-11 08:50:47', '', 'Home', '', 'inherit', 'closed', 'closed', '', '93-revision-v1', '', '', '2022-07-11 08:50:47', '2022-07-11 08:50:47', '', 93, 'http://mythosedu.com/93-revision-v1/', 0, 'revision', '', 0),
(101, 1, '2022-07-13 03:35:47', '2022-07-13 03:35:47', '', 'Rectangle 19', '', 'inherit', 'open', 'closed', '', 'rectangle-19', '', '', '2022-07-15 09:03:40', '2022-07-15 09:03:40', '', 106, 'http://mythosedu.com/wp-content/uploads/2022/07/Rectangle-19.jpg', 0, 'attachment', 'image/jpeg', 0),
(103, 1, '2022-07-13 07:14:48', '2022-07-13 07:14:48', '', 'Course 1', '', 'publish', 'open', 'closed', '', 'course-1', '', '', '2022-07-13 07:17:10', '2022-07-13 07:17:10', '', 0, 'http://mythosedu.com/?post_type=product&#038;p=103', 0, 'product', '', 0),
(104, 1, '2022-07-13 07:17:42', '2022-07-13 07:17:42', '', 'Course 2', '', 'publish', 'open', 'closed', '', 'course-2', '', '', '2022-07-13 07:17:43', '2022-07-13 07:17:43', '', 0, 'http://mythosedu.com/?post_type=product&#038;p=104', 0, 'product', '', 0),
(105, 1, '2022-07-13 07:18:17', '2022-07-13 07:18:17', '', 'Course 3', '', 'publish', 'open', 'closed', '', 'course-3', '', '', '2022-07-13 07:18:17', '2022-07-13 07:18:17', '', 0, 'http://mythosedu.com/?post_type=product&#038;p=105', 0, 'product', '', 0),
(107, 1, '2022-07-13 07:45:08', '2022-07-13 07:45:08', '', 'Course title 10', '', 'publish', 'open', 'closed', '', 'course-title-10', '', '', '2022-07-27 10:22:16', '2022-07-27 10:22:16', '', 0, 'http://mythosedu.com/product/course-title-10/', 0, 'product', '', 0),
(109, 1, '2022-07-14 01:49:50', '2022-07-14 01:49:50', '', 'mythosedu-img', '', 'inherit', 'open', 'closed', '', 'mythosedu-img', '', '', '2022-07-14 01:49:50', '2022-07-14 01:49:50', '', 93, 'http://mythosedu.com/wp-content/uploads/2022/07/mythosedu-img.jpeg', 0, 'attachment', 'image/jpeg', 0),
(110, 1, '2022-07-14 01:50:05', '2022-07-14 01:50:05', '', 'Home', '', 'inherit', 'closed', 'closed', '', '93-revision-v1', '', '', '2022-07-14 01:50:05', '2022-07-14 01:50:05', '', 93, 'http://mythosedu.com/93-revision-v1/', 0, 'revision', '', 0),
(111, 1, '2022-07-14 01:50:44', '2022-07-14 01:50:44', '', 'Home', '', 'inherit', 'closed', 'closed', '', '93-revision-v1', '', '', '2022-07-14 01:50:44', '2022-07-14 01:50:44', '', 93, 'http://mythosedu.com/93-revision-v1/', 0, 'revision', '', 0),
(112, 1, '2022-07-15 08:21:28', '2022-07-15 08:21:28', 'a:7:{s:8:\"location\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"param\";s:9:\"post_type\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:7:\"courses\";}}}s:8:\"position\";s:6:\"normal\";s:5:\"style\";s:8:\"seamless\";s:15:\"label_placement\";s:3:\"top\";s:21:\"instruction_placement\";s:5:\"label\";s:14:\"hide_on_screen\";s:0:\"\";s:11:\"description\";s:0:\"\";}', 'Course Banner Detail Page', 'course-banner-detail-page', 'publish', 'closed', 'closed', '', 'group_62d1232ebf50a', '', '', '2022-07-15 09:01:29', '2022-07-15 09:01:29', '', 0, 'http://mythosedu.com/?post_type=acf-field-group&#038;p=112', 0, 'acf-field-group', '', 0),
(113, 1, '2022-07-15 08:21:28', '2022-07-15 08:21:28', 'a:15:{s:4:\"type\";s:5:\"image\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"return_format\";s:3:\"url\";s:12:\"preview_size\";s:5:\"large\";s:7:\"library\";s:3:\"all\";s:9:\"min_width\";i:320;s:10:\"min_height\";s:0:\"\";s:8:\"min_size\";s:0:\"\";s:9:\"max_width\";i:1920;s:10:\"max_height\";s:0:\"\";s:8:\"max_size\";s:0:\"\";s:10:\"mime_types\";s:0:\"\";}', 'Course banner image', 'course_banner_image', 'publish', 'closed', 'closed', '', 'field_62d12341e59b1', '', '', '2022-07-15 08:38:23', '2022-07-15 08:38:23', '', 112, 'http://mythosedu.com/?post_type=acf-field&#038;p=113', 0, 'acf-field', '', 0),
(114, 1, '2022-07-15 08:27:13', '2022-07-15 08:27:13', '', 'Web 1920 – 1', '', 'inherit', 'open', 'closed', '', 'web-1920-1', '', '', '2022-07-15 08:27:13', '2022-07-15 08:27:13', '', 106, 'http://mythosedu.com/wp-content/uploads/2022/07/Web-1920-–-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(115, 1, '2022-07-15 08:34:26', '2022-07-15 08:34:26', '', 'Web 1920 – 1', '', 'inherit', 'open', 'closed', '', 'web-1920-1-2', '', '', '2022-07-15 08:34:26', '2022-07-15 08:34:26', '', 106, 'http://mythosedu.com/wp-content/uploads/2022/07/Web-1920-–-1-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(116, 1, '2022-07-16 01:51:09', '2022-07-16 01:51:09', '...', 'Course title 10', '', 'inherit', 'closed', 'closed', '', '100-autosave-v1', '', '', '2022-07-16 01:51:09', '2022-07-16 01:51:09', '', 100, 'http://mythosedu.com/100-autosave-v1/', 0, 'revision', '', 0),
(117, 1, '2022-07-16 01:56:34', '2022-07-16 01:56:34', '', 'c-1', '', 'inherit', 'open', 'closed', '', 'c-1', '', '', '2022-07-16 01:56:34', '2022-07-16 01:56:34', '', 0, 'http://mythosedu.com/wp-content/uploads/2022/07/c-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(118, 1, '2022-07-16 01:56:37', '2022-07-16 01:56:37', '', 'c-2', '', 'inherit', 'open', 'closed', '', 'c-2', '', '', '2022-07-16 01:56:37', '2022-07-16 01:56:37', '', 0, 'http://mythosedu.com/wp-content/uploads/2022/07/c-2.jpg', 0, 'attachment', 'image/jpeg', 0),
(119, 1, '2022-07-16 01:56:40', '2022-07-16 01:56:40', '', 'c-3', '', 'inherit', 'open', 'closed', '', 'c-3', '', '', '2022-07-16 01:56:40', '2022-07-16 01:56:40', '', 0, 'http://mythosedu.com/wp-content/uploads/2022/07/c-3.jpg', 0, 'attachment', 'image/jpeg', 0),
(120, 1, '2022-07-16 01:56:43', '2022-07-16 01:56:43', '', 'c-4', '', 'inherit', 'open', 'closed', '', 'c-4', '', '', '2022-07-16 01:56:43', '2022-07-16 01:56:43', '', 0, 'http://mythosedu.com/wp-content/uploads/2022/07/c-4.jpg', 0, 'attachment', 'image/jpeg', 0),
(123, 1, '2022-07-19 09:06:21', '2022-07-19 09:06:21', '', 'Auto Draft', '', 'publish', 'open', 'closed', '', 'auto-draft', '', '', '2022-07-19 09:06:21', '2022-07-19 09:06:21', '', 0, 'http://mythosedu.com/product/auto-draft/', 0, 'product', '', 0),
(125, 1, '2022-07-20 09:26:13', '2022-07-20 09:26:13', '', 'Courses', '', 'publish', 'closed', 'closed', '', 'courses', '', '', '2022-07-20 09:26:13', '2022-07-20 09:26:13', '', 0, 'http://mythosedu.com/?page_id=125', 0, 'page', '', 0),
(126, 1, '2022-07-20 09:26:13', '2022-07-20 09:26:13', '', 'Courses', '', 'inherit', 'closed', 'closed', '', '125-revision-v1', '', '', '2022-07-20 09:26:13', '2022-07-20 09:26:13', '', 125, 'http://mythosedu.com/125-revision-v1/', 0, 'revision', '', 0),
(128, 1, '2022-07-27 02:34:54', '2022-07-27 02:34:54', '', 'Forgot password', '', 'publish', 'closed', 'closed', '', 'forgot-password', '', '', '2022-07-27 02:34:54', '2022-07-27 02:34:54', '', 0, 'http://mythosedu.com/?page_id=128', 0, 'page', '', 0),
(129, 1, '2022-07-27 02:34:54', '2022-07-27 02:34:54', '', 'Forgot password', '', 'inherit', 'closed', 'closed', '', '128-revision-v1', '', '', '2022-07-27 02:34:54', '2022-07-27 02:34:54', '', 128, 'http://mythosedu.com/128-revision-v1/', 0, 'revision', '', 0),
(130, 1, '2022-07-27 09:04:11', '2022-07-27 09:04:11', 'a:7:{s:8:\"location\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"param\";s:4:\"page\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:2:\"93\";}}}s:8:\"position\";s:6:\"normal\";s:5:\"style\";s:7:\"default\";s:15:\"label_placement\";s:3:\"top\";s:21:\"instruction_placement\";s:5:\"label\";s:14:\"hide_on_screen\";s:0:\"\";s:11:\"description\";s:0:\"\";}', 'Home Sub Banner', 'home-sub-banner', 'publish', 'closed', 'closed', '', 'group_62e0ff450576f', '', '', '2022-07-27 09:08:04', '2022-07-27 09:08:04', '', 0, 'http://mythosedu.com/?post_type=acf-field-group&#038;p=130', 2, 'acf-field-group', '', 0),
(131, 1, '2022-07-27 09:04:11', '2022-07-27 09:04:11', 'a:15:{s:4:\"type\";s:5:\"image\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"return_format\";s:3:\"url\";s:12:\"preview_size\";s:5:\"large\";s:7:\"library\";s:3:\"all\";s:9:\"min_width\";s:0:\"\";s:10:\"min_height\";s:0:\"\";s:8:\"min_size\";s:0:\"\";s:9:\"max_width\";s:0:\"\";s:10:\"max_height\";s:0:\"\";s:8:\"max_size\";s:0:\"\";s:10:\"mime_types\";s:0:\"\";}', 'Home Sub Banner Image', 'home_sub_banner', 'publish', 'closed', 'closed', '', 'field_62e0ff4d87289', '', '', '2022-07-27 09:08:04', '2022-07-27 09:08:04', '', 130, 'http://mythosedu.com/?post_type=acf-field&#038;p=131', 0, 'acf-field', '', 0),
(132, 1, '2022-07-27 09:05:38', '2022-07-27 09:05:38', '', 'home_sub_banner', '', 'inherit', 'open', 'closed', '', 'home_sub_banner', '', '', '2022-07-27 09:05:38', '2022-07-27 09:05:38', '', 93, 'http://mythosedu.com/wp-content/uploads/2022/07/home_sub_banner.png', 0, 'attachment', 'image/png', 0),
(133, 1, '2022-07-27 09:05:49', '2022-07-27 09:05:49', '', 'Home', '', 'inherit', 'closed', 'closed', '', '93-revision-v1', '', '', '2022-07-27 09:05:49', '2022-07-27 09:05:49', '', 93, 'http://mythosedu.com/93-revision-v1/', 0, 'revision', '', 0),
(134, 1, '2022-07-27 09:08:45', '2022-07-27 09:08:45', '', 'Home', '', 'inherit', 'closed', 'closed', '', '93-revision-v1', '', '', '2022-07-27 09:08:45', '2022-07-27 09:08:45', '', 93, 'http://mythosedu.com/93-revision-v1/', 0, 'revision', '', 0),
(142, 5, '2022-07-28 07:51:43', '2022-07-28 07:51:43', '', 'Auto Draft', '', 'publish', 'open', 'closed', '', 'auto-draft-2', '', '', '2022-07-28 08:06:39', '2022-07-28 08:06:39', '', 0, 'http://mythosedu.com/product/auto-draft-2/', 0, 'product', '', 0),
(143, 5, '2022-07-28 07:52:02', '2022-07-28 07:52:02', '..', 'Session 1', '', 'publish', 'closed', 'closed', '', 'session-1', '', '', '2022-07-28 07:52:02', '2022-07-28 07:52:02', '', 141, 'http://mythosedu.com/topics/session-1/', 1, 'topics', '', 0),
(144, 5, '2022-07-28 07:52:34', '2022-07-28 07:52:34', '...', 'Session 2', '', 'publish', 'closed', 'closed', '', 'session-2', '', '', '2022-07-28 07:52:34', '2022-07-28 07:52:34', '', 141, 'http://mythosedu.com/topics/session-2/', 2, 'topics', '', 0),
(146, 1, '2023-11-28 15:36:44', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'draft', 'closed', 'closed', '', 'auto-draft', '', '', '2023-11-28 15:36:44', '2023-11-28 15:36:44', '', 0, 'http://mythosedu.com/?post_type=courses&#038;p=146', 0, 'courses', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_termmeta`
--

DROP TABLE IF EXISTS `wp_termmeta`;
CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_termmeta`
--

INSERT INTO `wp_termmeta` (`meta_id`, `term_id`, `meta_key`, `meta_value`) VALUES
(6, 24, 'thumbnail_id', '0'),
(7, 15, 'product_count_product_cat', '6');

-- --------------------------------------------------------

--
-- Table structure for table `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
CREATE TABLE `wp_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(20) NOT NULL DEFAULT 0,
  `term_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`, `term_order`) VALUES
(1, 'Chưa được phân loại', 'khong-phan-loai', 0, 0),
(2, 'simple', 'simple', 0, 0),
(3, 'grouped', 'grouped', 0, 0),
(4, 'variable', 'variable', 0, 0),
(5, 'external', 'external', 0, 0),
(6, 'exclude-from-search', 'exclude-from-search', 0, 0),
(7, 'exclude-from-catalog', 'exclude-from-catalog', 0, 0),
(8, 'featured', 'featured', 0, 0),
(9, 'outofstock', 'outofstock', 0, 0),
(10, 'rated-1', 'rated-1', 0, 0),
(11, 'rated-2', 'rated-2', 0, 0),
(12, 'rated-3', 'rated-3', 0, 0),
(13, 'rated-4', 'rated-4', 0, 0),
(14, 'rated-5', 'rated-5', 0, 0),
(15, 'Uncategorized', 'uncategorized', 0, 1),
(16, 'Header Menu', 'header-menu', 0, 0),
(17, 'Footer Menu', 'footer-menu', 0, 0),
(18, 'news', 'news', 0, 0),
(24, 'Workshop', 'workshop', 0, 0),
(25, 'Soft Skills', 'soft-skills', 0, 0),
(26, 'Teaching skill', 'teaching-skill', 0, 0),
(28, 'HR Training', 'hr-training', 0, 0),
(29, 'Internal Courses', 'internal-courses', 0, 0),
(30, 'External Courses', 'external-courses', 0, 0),
(31, 'SPEACIAL COURSES', 'speacial-courses', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_relationships`
--

DROP TABLE IF EXISTS `wp_term_relationships`;
CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0),
(79, 24, 0),
(81, 16, 0),
(82, 16, 0),
(83, 17, 0),
(84, 17, 0),
(85, 17, 0),
(86, 17, 0),
(90, 1, 0),
(103, 2, 0),
(103, 15, 0),
(104, 2, 0),
(104, 15, 0),
(105, 2, 0),
(105, 15, 0),
(107, 2, 0),
(107, 15, 0),
(121, 24, 0),
(123, 2, 0),
(123, 15, 0),
(136, 29, 0),
(137, 29, 0),
(138, 31, 0),
(142, 2, 0),
(142, 15, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 2),
(2, 2, 'product_type', '', 0, 6),
(3, 3, 'product_type', '', 0, 0),
(4, 4, 'product_type', '', 0, 0),
(5, 5, 'product_type', '', 0, 0),
(6, 6, 'product_visibility', '', 0, 0),
(7, 7, 'product_visibility', '', 0, 0),
(8, 8, 'product_visibility', '', 0, 0),
(9, 9, 'product_visibility', '', 0, 0),
(10, 10, 'product_visibility', '', 0, 0),
(11, 11, 'product_visibility', '', 0, 0),
(12, 12, 'product_visibility', '', 0, 0),
(13, 13, 'product_visibility', '', 0, 0),
(14, 14, 'product_visibility', '', 0, 0),
(15, 15, 'product_cat', '', 0, 6),
(16, 16, 'nav_menu', '', 0, 2),
(17, 17, 'nav_menu', '', 0, 4),
(18, 18, 'category', '', 0, 0),
(24, 24, 'course-category', '', 0, 1),
(25, 25, 'post_tag', '', 0, 0),
(26, 26, 'post_tag', '', 0, 0),
(28, 28, 'course-tag', '', 0, 0),
(29, 29, 'course-tag', '', 0, 2),
(30, 30, 'course-tag', '', 0, 0),
(31, 31, 'course-tag', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_tutor_earnings`
--

DROP TABLE IF EXISTS `wp_tutor_earnings`;
CREATE TABLE `wp_tutor_earnings` (
  `earning_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `course_id` bigint(20) DEFAULT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `order_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_price_total` decimal(16,2) DEFAULT NULL,
  `course_price_grand_total` decimal(16,2) DEFAULT NULL,
  `instructor_amount` decimal(16,2) DEFAULT NULL,
  `instructor_rate` decimal(16,2) DEFAULT NULL,
  `admin_amount` decimal(16,2) DEFAULT NULL,
  `admin_rate` decimal(16,2) DEFAULT NULL,
  `commission_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deduct_fees_amount` decimal(16,2) DEFAULT NULL,
  `deduct_fees_name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deduct_fees_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process_by` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_tutor_notifications`
--

DROP TABLE IF EXISTS `wp_tutor_notifications`;
CREATE TABLE `wp_tutor_notifications` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('READ','UNREAD') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `topic_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_tutor_quiz_attempts`
--

DROP TABLE IF EXISTS `wp_tutor_quiz_attempts`;
CREATE TABLE `wp_tutor_quiz_attempts` (
  `attempt_id` bigint(20) NOT NULL,
  `course_id` bigint(20) DEFAULT NULL,
  `quiz_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `total_questions` int(11) DEFAULT NULL,
  `total_answered_questions` int(11) DEFAULT NULL,
  `total_marks` decimal(9,2) DEFAULT NULL,
  `earned_marks` decimal(9,2) DEFAULT NULL,
  `attempt_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempt_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempt_ip` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempt_started_at` datetime DEFAULT NULL,
  `attempt_ended_at` datetime DEFAULT NULL,
  `is_manually_reviewed` int(11) DEFAULT NULL,
  `manually_reviewed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_tutor_quiz_attempt_answers`
--

DROP TABLE IF EXISTS `wp_tutor_quiz_attempt_answers`;
CREATE TABLE `wp_tutor_quiz_attempt_answers` (
  `attempt_answer_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `quiz_id` bigint(20) DEFAULT NULL,
  `question_id` bigint(20) DEFAULT NULL,
  `quiz_attempt_id` bigint(20) DEFAULT NULL,
  `given_answer` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_mark` decimal(8,2) DEFAULT NULL,
  `achieved_mark` decimal(8,2) DEFAULT NULL,
  `minus_mark` decimal(8,2) DEFAULT NULL,
  `is_correct` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_tutor_quiz_questions`
--

DROP TABLE IF EXISTS `wp_tutor_quiz_questions`;
CREATE TABLE `wp_tutor_quiz_questions` (
  `question_id` bigint(20) NOT NULL,
  `quiz_id` bigint(20) DEFAULT NULL,
  `question_title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_mark` decimal(9,2) DEFAULT NULL,
  `question_settings` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_tutor_quiz_question_answers`
--

DROP TABLE IF EXISTS `wp_tutor_quiz_question_answers`;
CREATE TABLE `wp_tutor_quiz_question_answers` (
  `answer_id` bigint(20) NOT NULL,
  `belongs_question_id` bigint(20) DEFAULT NULL,
  `belongs_question_type` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer_title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_correct` tinyint(4) DEFAULT NULL,
  `image_id` bigint(20) DEFAULT NULL,
  `answer_two_gap_match` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer_view_format` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer_settings` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_tutor_withdraws`
--

DROP TABLE IF EXISTS `wp_tutor_withdraws`;
CREATE TABLE `wp_tutor_withdraws` (
  `withdraw_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `amount` decimal(16,2) DEFAULT NULL,
  `method_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'webmaster'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'syntax_highlighting', 'true'),
(7, 1, 'comment_shortcuts', 'false'),
(8, 1, 'admin_color', 'fresh'),
(9, 1, 'use_ssl', '0'),
(10, 1, 'show_admin_bar_front', 'false'),
(11, 1, 'locale', ''),
(12, 1, 'wp_capabilities', 'a:2:{s:13:\"administrator\";b:1;s:16:\"tutor_instructor\";b:1;}'),
(13, 1, 'wp_user_level', '10'),
(14, 1, 'dismissed_wp_pointers', ''),
(15, 1, 'show_welcome_panel', '0'),
(17, 1, 'wp_dashboard_quick_press_last_post_id', '127'),
(18, 1, 'community-events-location', 'a:1:{s:2:\"ip\";s:13:\"171.252.153.0\";}'),
(19, 1, '_is_tutor_instructor', '1656644249'),
(20, 1, '_tutor_instructor_status', 'approved'),
(21, 1, '_tutor_instructor_approved', '1656644249'),
(22, 1, '_tutor_instructor_course_id', '9'),
(23, 1, '_tutor_instructor_course_id', '10'),
(24, 1, '_woocommerce_tracks_anon_id', 'woo:ICNkcWbSEt43LzR3gAP2gHKG'),
(25, 1, '_tutor_instructor_course_id', '18'),
(26, 1, '_tutor_instructor_course_id', '19'),
(27, 1, '_tutor_instructor_course_id', '20'),
(28, 1, '_tutor_instructor_course_id', '21'),
(29, 1, '_tutor_instructor_course_id', '22'),
(30, 1, '_tutor_instructor_course_id', '23'),
(31, 1, '_tutor_instructor_course_id', '25'),
(32, 1, '_tutor_instructor_course_id', '26'),
(33, 1, '_tutor_instructor_course_id', '27'),
(34, 1, '_tutor_instructor_course_id', '28'),
(35, 1, '_tutor_instructor_course_id', '29'),
(36, 1, '_tutor_instructor_course_id', '30'),
(37, 1, '_tutor_instructor_course_id', '31'),
(38, 1, 'wc_last_active', '1701129600'),
(39, 1, 'closedpostboxes_courses', 'a:2:{i:0;s:20:\"tutor-attach-product\";i:1;s:19:\"tutor-course-topics\";}'),
(40, 1, 'metaboxhidden_courses', 'a:0:{}'),
(41, 1, '_is_tutor_student', '1657118982'),
(42, 1, '_wc_plugin_framework_facebook_for_woocommerce_dismissed_messages', 'a:3:{s:56:\"facebook-for-woocommerce-deprecated-wc-version-as-of-6-4\";b:1;s:36:\"facebook_for_woocommerce_get_started\";b:1;s:56:\"facebook-for-woocommerce-deprecated-wc-version-as-of-6-5\";b:1;}'),
(43, 1, 'wp_user-settings', 'libraryContent=browse'),
(44, 1, 'wp_user-settings-time', '1657936571'),
(45, 1, 'dismissed_wc_admin_notice', '1'),
(48, 1, '_tutor_instructor_course_id', '59'),
(49, 1, '_tutor_instructor_course_id', '60'),
(50, 1, '_tutor_instructor_course_id', '61'),
(51, 1, '_tutor_instructor_course_id', '62'),
(53, 1, '_tutor_instructor_course_id', '70'),
(54, 1, '_tutor_instructor_course_id', '71'),
(55, 1, '_tutor_instructor_course_id', '72'),
(57, 1, '_tutor_instructor_course_id', '75'),
(58, 1, 'ame_show_hints', 'a:3:{s:17:\"ws_sidebar_pro_ad\";b:0;s:16:\"ws_whats_new_120\";b:0;s:24:\"ws_hint_menu_permissions\";b:0;}'),
(59, 2, 'nickname', 'admins'),
(60, 2, 'first_name', 'Admins'),
(61, 2, 'last_name', ''),
(62, 2, 'description', ''),
(63, 2, 'rich_editing', 'true'),
(64, 2, 'syntax_highlighting', 'true'),
(65, 2, 'comment_shortcuts', 'false'),
(66, 2, 'admin_color', 'fresh'),
(67, 2, 'use_ssl', '0'),
(68, 2, 'show_admin_bar_front', 'false'),
(69, 2, 'locale', ''),
(72, 2, 'dismissed_wp_pointers', ''),
(73, 2, 'session_tokens', 'a:1:{s:64:\"5df3613d71225dcaca1fb0c993c716f9425d4511acbb226ae797b280671affbc\";a:4:{s:10:\"expiration\";i:1657186904;s:2:\"ip\";s:9:\"127.0.0.1\";s:2:\"ua\";s:133:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.66 Safari/537.36 Edg/103.0.1264.44\";s:5:\"login\";i:1657014104;}}'),
(74, 2, 'wc_last_active', '1656979200'),
(76, 2, 'ame_rui_first_login_done', '1'),
(77, 2, 'wp_dashboard_quick_press_last_post_id', '77'),
(78, 2, 'community-events-location', 'a:1:{s:2:\"ip\";s:9:\"127.0.0.0\";}'),
(79, 2, 'billing_first_name', 'Admins'),
(80, 2, 'billing_last_name', ''),
(81, 2, 'billing_company', ''),
(82, 2, 'billing_address_1', ''),
(83, 2, 'billing_address_2', ''),
(84, 2, 'billing_city', ''),
(85, 2, 'billing_postcode', ''),
(86, 2, 'billing_country', ''),
(87, 2, 'billing_state', ''),
(88, 2, 'billing_phone', ''),
(89, 2, 'billing_email', 'admins@mythosedu.com'),
(90, 2, 'shipping_first_name', ''),
(91, 2, 'shipping_last_name', ''),
(92, 2, 'shipping_company', ''),
(93, 2, 'shipping_address_1', ''),
(94, 2, 'shipping_address_2', ''),
(95, 2, 'shipping_city', ''),
(96, 2, 'shipping_postcode', ''),
(97, 2, 'shipping_country', ''),
(98, 2, 'shipping_state', ''),
(99, 2, '_tutor_profile_job_title', ''),
(100, 2, '_tutor_profile_bio', ''),
(101, 2, '_tutor_profile_photo', ''),
(102, 2, 'last_update', '1657726196'),
(104, 1, 'ame_rui_first_login_done', '1'),
(105, 2, 'wp_capabilities', 'a:1:{s:6:\"admins\";b:1;}'),
(106, 2, 'wp_user_level', '10'),
(107, 2, '_wc_plugin_framework_facebook_for_woocommerce_dismissed_messages', 'a:2:{s:56:\"facebook-for-woocommerce-deprecated-wc-version-as-of-6-4\";b:1;s:36:\"facebook_for_woocommerce_get_started\";b:1;}'),
(108, 2, '_tutor_instructor_course_id', '79'),
(109, 2, '_tutor_instructor_course_id', '80'),
(110, 2, 'wp_mail_smtp_dash_widget_lite_hide_graph', '1'),
(111, 2, 'closedpostboxes_dashboard', 'a:4:{i:0;s:32:\"wp_mail_smtp_reports_widget_lite\";i:1;s:18:\"dashboard_activity\";i:2;s:25:\"wpclever_dashboard_widget\";i:3;s:17:\"dashboard_primary\";}'),
(112, 2, 'metaboxhidden_dashboard', 'a:5:{i:0;s:32:\"wp_mail_smtp_reports_widget_lite\";i:1;s:19:\"dashboard_right_now\";i:2;s:18:\"dashboard_activity\";i:3;s:25:\"wpclever_dashboard_widget\";i:4;s:36:\"woocommerce_dashboard_recent_reviews\";}'),
(114, 1, 'managenav-menuscolumnshidden', 'a:5:{i:0;s:11:\"link-target\";i:1;s:11:\"css-classes\";i:2;s:3:\"xfn\";i:3;s:11:\"description\";i:4;s:15:\"title-attribute\";}'),
(115, 1, 'metaboxhidden_nav-menus', 'a:11:{i:0;s:21:\"add-post-type-product\";i:1;s:21:\"add-post-type-courses\";i:2;s:20:\"add-post-type-lesson\";i:3;s:24:\"add-post-type-tutor_quiz\";i:4;s:31:\"add-post-type-tutor_assignments\";i:5;s:12:\"add-post_tag\";i:6;s:15:\"add-post_format\";i:7;s:15:\"add-product_cat\";i:8;s:15:\"add-product_tag\";i:9;s:19:\"add-course-category\";i:10;s:14:\"add-course-tag\";}'),
(116, 1, 'nav_menu_recently_edited', '17'),
(150, 1, '_tutor_instructor_course_id', '100'),
(161, 1, '_tutor_instructor_course_id', '102'),
(170, 1, '_tutor_instructor_course_id', '106'),
(173, 1, '_woocommerce_persistent_cart_1', 'a:1:{s:4:\"cart\";a:0:{}}'),
(209, 1, '_tutor_instructor_course_id', '121'),
(212, 1, '_tutor_instructor_course_id', '124'),
(250, 1, 'session_tokens', 'a:1:{s:64:\"e1f53da5118f48725984309cf341b50f2e96c21a16957caa312792c2c8d93cba\";a:4:{s:10:\"expiration\";i:1701358011;s:2:\"ip\";s:9:\"127.0.0.1\";s:2:\"ua\";s:80:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:101.0) Gecko/20100101 Firefox/101.0\";s:5:\"login\";i:1701185211;}}'),
(253, 1, '_tutor_instructor_course_id', '135'),
(254, 1, '_tutor_instructor_course_id', '136'),
(255, 1, '_tutor_instructor_course_id', '137'),
(256, 1, '_tutor_instructor_course_id', '138'),
(340, 1, '_tutor_instructor_course_id', '145'),
(342, 1, '_tutor_instructor_course_id', '146');

-- --------------------------------------------------------

--
-- Table structure for table `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
CREATE TABLE `wp_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT 0,
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'webmaster', '$P$BNXMsqTWSl59viU5fDjzr2V8t6ObzD/', 'webmaster', 'heckmanle@gmail.com', '', '2022-07-01 02:30:09', '', 0, 'webmaster'),
(2, 'admins', '$P$B.q0aQzWQU9V0wfQd0CSlq4pzH/XV21', 'admins', 'admins@mythosedu.com', 'http://mythosedu.com', '2022-07-05 09:41:21', '', 0, 'Admins');

-- --------------------------------------------------------

--
-- Table structure for table `wp_wc_download_log`
--

DROP TABLE IF EXISTS `wp_wc_download_log`;
CREATE TABLE `wp_wc_download_log` (
  `download_log_id` bigint(20) UNSIGNED NOT NULL,
  `timestamp` datetime NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_wc_product_meta_lookup`
--

DROP TABLE IF EXISTS `wp_wc_product_meta_lookup`;
CREATE TABLE `wp_wc_product_meta_lookup` (
  `product_id` bigint(20) NOT NULL,
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `virtual` tinyint(1) DEFAULT 0,
  `downloadable` tinyint(1) DEFAULT 0,
  `min_price` decimal(10,2) DEFAULT NULL,
  `max_price` decimal(10,2) DEFAULT NULL,
  `onsale` tinyint(1) DEFAULT 0,
  `stock_quantity` double DEFAULT NULL,
  `stock_status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'instock',
  `rating_count` bigint(20) DEFAULT 0,
  `average_rating` decimal(3,2) DEFAULT 0.00,
  `total_sales` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_wc_product_meta_lookup`
--

INSERT INTO `wp_wc_product_meta_lookup` (`product_id`, `sku`, `virtual`, `downloadable`, `min_price`, `max_price`, `onsale`, `stock_quantity`, `stock_status`, `rating_count`, `average_rating`, `total_sales`) VALUES
(103, '', 0, 0, '2.10', '2.10', 1, NULL, 'instock', 0, '0.00', 0),
(104, '', 0, 0, '2800000.00', '2800000.00', 1, NULL, 'instock', 0, '0.00', 0),
(105, '', 0, 0, '3400000.00', '3400000.00', 1, NULL, 'instock', 0, '0.00', 0),
(107, '', 0, 0, '3600000.00', '3600000.00', 0, NULL, 'instock', 0, '0.00', 0),
(123, '', 0, 0, '1200000.00', '1200000.00', 0, NULL, 'instock', 0, '0.00', 0),
(142, '', 0, 0, '2300000.00', '2300000.00', 0, NULL, 'instock', 0, '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_wc_tax_rate_classes`
--

DROP TABLE IF EXISTS `wp_wc_tax_rate_classes`;
CREATE TABLE `wp_wc_tax_rate_classes` (
  `tax_rate_class_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_wc_tax_rate_classes`
--

INSERT INTO `wp_wc_tax_rate_classes` (`tax_rate_class_id`, `name`, `slug`) VALUES
(1, 'Reduced rate', 'reduced-rate'),
(2, 'Zero rate', 'zero-rate');

-- --------------------------------------------------------

--
-- Table structure for table `wp_wc_webhooks`
--

DROP TABLE IF EXISTS `wp_wc_webhooks`;
CREATE TABLE `wp_wc_webhooks` (
  `webhook_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_created_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `api_version` smallint(6) NOT NULL,
  `failure_count` smallint(6) NOT NULL DEFAULT 0,
  `pending_delivery` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_api_keys`
--

DROP TABLE IF EXISTS `wp_woocommerce_api_keys`;
CREATE TABLE `wp_woocommerce_api_keys` (
  `key_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consumer_key` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consumer_secret` char(43) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nonces` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `truncated_key` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_access` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_attribute_taxonomies`
--

DROP TABLE IF EXISTS `wp_woocommerce_attribute_taxonomies`;
CREATE TABLE `wp_woocommerce_attribute_taxonomies` (
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_label` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attribute_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_orderby` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_public` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_downloadable_product_permissions`
--

DROP TABLE IF EXISTS `wp_woocommerce_downloadable_product_permissions`;
CREATE TABLE `wp_woocommerce_downloadable_product_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `download_id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `order_key` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `downloads_remaining` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_granted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access_expires` datetime DEFAULT NULL,
  `download_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_log`
--

DROP TABLE IF EXISTS `wp_woocommerce_log`;
CREATE TABLE `wp_woocommerce_log` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `timestamp` datetime NOT NULL,
  `level` smallint(6) NOT NULL,
  `source` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_order_itemmeta`
--

DROP TABLE IF EXISTS `wp_woocommerce_order_itemmeta`;
CREATE TABLE `wp_woocommerce_order_itemmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_order_items`
--

DROP TABLE IF EXISTS `wp_woocommerce_order_items`;
CREATE TABLE `wp_woocommerce_order_items` (
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_item_type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `order_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_payment_tokenmeta`
--

DROP TABLE IF EXISTS `wp_woocommerce_payment_tokenmeta`;
CREATE TABLE `wp_woocommerce_payment_tokenmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `payment_token_id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_payment_tokens`
--

DROP TABLE IF EXISTS `wp_woocommerce_payment_tokens`;
CREATE TABLE `wp_woocommerce_payment_tokens` (
  `token_id` bigint(20) UNSIGNED NOT NULL,
  `gateway_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_sessions`
--

DROP TABLE IF EXISTS `wp_woocommerce_sessions`;
CREATE TABLE `wp_woocommerce_sessions` (
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `session_key` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_expiry` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_woocommerce_sessions`
--

INSERT INTO `wp_woocommerce_sessions` (`session_id`, `session_key`, `session_value`, `session_expiry`) VALUES
(2515, '1', 'a:7:{s:4:\"cart\";s:6:\"a:0:{}\";s:11:\"cart_totals\";s:367:\"a:15:{s:8:\"subtotal\";i:0;s:12:\"subtotal_tax\";i:0;s:14:\"shipping_total\";i:0;s:12:\"shipping_tax\";i:0;s:14:\"shipping_taxes\";a:0:{}s:14:\"discount_total\";i:0;s:12:\"discount_tax\";i:0;s:19:\"cart_contents_total\";i:0;s:17:\"cart_contents_tax\";i:0;s:19:\"cart_contents_taxes\";a:0:{}s:9:\"fee_total\";i:0;s:7:\"fee_tax\";i:0;s:9:\"fee_taxes\";a:0:{}s:5:\"total\";i:0;s:9:\"total_tax\";i:0;}\";s:15:\"applied_coupons\";s:6:\"a:0:{}\";s:22:\"coupon_discount_totals\";s:6:\"a:0:{}\";s:26:\"coupon_discount_tax_totals\";s:6:\"a:0:{}\";s:21:\"removed_cart_contents\";s:6:\"a:0:{}\";s:8:\"customer\";s:707:\"a:26:{s:2:\"id\";s:1:\"1\";s:13:\"date_modified\";s:0:\"\";s:8:\"postcode\";s:0:\"\";s:4:\"city\";s:0:\"\";s:9:\"address_1\";s:0:\"\";s:7:\"address\";s:0:\"\";s:9:\"address_2\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:2:\"VN\";s:17:\"shipping_postcode\";s:0:\"\";s:13:\"shipping_city\";s:0:\"\";s:18:\"shipping_address_1\";s:0:\"\";s:16:\"shipping_address\";s:0:\"\";s:18:\"shipping_address_2\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:16:\"shipping_country\";s:2:\"VN\";s:13:\"is_vat_exempt\";s:0:\"\";s:19:\"calculated_shipping\";s:0:\"\";s:10:\"first_name\";s:0:\"\";s:9:\"last_name\";s:0:\"\";s:7:\"company\";s:0:\"\";s:5:\"phone\";s:0:\"\";s:5:\"email\";s:19:\"heckmanle@gmail.com\";s:19:\"shipping_first_name\";s:0:\"\";s:18:\"shipping_last_name\";s:0:\"\";s:16:\"shipping_company\";s:0:\"\";}\";}', 1701358013);

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_shipping_zones`
--

DROP TABLE IF EXISTS `wp_woocommerce_shipping_zones`;
CREATE TABLE `wp_woocommerce_shipping_zones` (
  `zone_id` bigint(20) UNSIGNED NOT NULL,
  `zone_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_order` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_shipping_zone_locations`
--

DROP TABLE IF EXISTS `wp_woocommerce_shipping_zone_locations`;
CREATE TABLE `wp_woocommerce_shipping_zone_locations` (
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `zone_id` bigint(20) UNSIGNED NOT NULL,
  `location_code` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_shipping_zone_methods`
--

DROP TABLE IF EXISTS `wp_woocommerce_shipping_zone_methods`;
CREATE TABLE `wp_woocommerce_shipping_zone_methods` (
  `zone_id` bigint(20) UNSIGNED NOT NULL,
  `instance_id` bigint(20) UNSIGNED NOT NULL,
  `method_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method_order` bigint(20) UNSIGNED NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_tax_rates`
--

DROP TABLE IF EXISTS `wp_woocommerce_tax_rates`;
CREATE TABLE `wp_woocommerce_tax_rates` (
  `tax_rate_id` bigint(20) UNSIGNED NOT NULL,
  `tax_rate_country` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tax_rate_state` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tax_rate` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tax_rate_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tax_rate_priority` bigint(20) UNSIGNED NOT NULL,
  `tax_rate_compound` int(11) NOT NULL DEFAULT 0,
  `tax_rate_shipping` int(11) NOT NULL DEFAULT 1,
  `tax_rate_order` bigint(20) UNSIGNED NOT NULL,
  `tax_rate_class` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_tax_rate_locations`
--

DROP TABLE IF EXISTS `wp_woocommerce_tax_rate_locations`;
CREATE TABLE `wp_woocommerce_tax_rate_locations` (
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `location_code` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rate_id` bigint(20) UNSIGNED NOT NULL,
  `location_type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_wpmailsmtp_debug_events`
--

DROP TABLE IF EXISTS `wp_wpmailsmtp_debug_events`;
CREATE TABLE `wp_wpmailsmtp_debug_events` (
  `id` int(10) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `initiator` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_wpmailsmtp_debug_events`
--

INSERT INTO `wp_wpmailsmtp_debug_events` (`id`, `content`, `initiator`, `event_type`, `created_at`) VALUES
(1, 'Mailer: Default (none)\r\nPHPMailer was able to connect to SMTP server but failed while trying to send an email.', '{\"file\":\"D:\\\\SRC\\\\traininghub_frontend_uat\\\\wp-content\\\\plugins\\\\wp-mail-smtp\\\\src\\\\Reports\\\\Emails\\\\Summary.php\",\"line\":112}', 0, '2022-07-11 12:01:06'),
(2, 'Mailer: Default (none)\r\nPHPMailer was able to connect to SMTP server but failed while trying to send an email.', '{\"file\":\"D:\\\\SRC\\\\traininghub_frontend_uat\\\\wp-includes\\\\class-wp-recovery-mode-email-service.php\",\"line\":217}', 0, '2022-07-12 17:38:28'),
(3, 'Mailer: Default (none)\r\nPHPMailer was able to connect to SMTP server but failed while trying to send an email.', '{\"file\":\"D:\\\\SRC\\\\traininghub_frontend_uat\\\\wp-includes\\\\user.php\",\"line\":2050}', 0, '2022-07-13 01:29:58'),
(4, 'Mailer: Default (none)\r\nPHPMailer was able to connect to SMTP server but failed while trying to send an email.', '{\"file\":\"D:\\\\SRC\\\\traininghub_frontend_uat\\\\wp-includes\\\\pluggable.php\",\"line\":1980}', 0, '2022-07-13 01:31:11'),
(5, 'Mailer: Default (none)\r\nPHPMailer was able to connect to SMTP server but failed while trying to send an email.', '{\"file\":\"D:\\\\SRC\\\\traininghub_frontend_uat\\\\wp-content\\\\plugins\\\\wp-mail-smtp\\\\src\\\\Reports\\\\Emails\\\\Summary.php\",\"line\":112}', 0, '2022-07-18 12:02:01'),
(6, 'Mailer: Default (none)\r\nPHPMailer was able to connect to SMTP server but failed while trying to send an email.', '{\"file\":\"D:\\\\SRC\\\\traininghub_frontend_uat\\\\wp-content\\\\plugins\\\\wp-mail-smtp\\\\src\\\\Reports\\\\Emails\\\\Summary.php\",\"line\":112}', 0, '2022-07-25 17:44:58'),
(7, 'Mailer: Default (none)\r\nPHPMailer was able to connect to SMTP server but failed while trying to send an email.', '{\"file\":\"\\/home\\/www\\/vu_traininghub_frontend\\/wp-includes\\/pluggable.php\",\"line\":1980}', 0, '2022-07-28 00:42:04'),
(8, 'Mailer: Default (none)\r\nPHPMailer was able to connect to SMTP server but failed while trying to send an email.', '{\"file\":\"\\/home\\/www\\/vu_traininghub_frontend\\/wp-includes\\/pluggable.php\",\"line\":1980}', 0, '2022-07-28 00:42:43');

-- --------------------------------------------------------

--
-- Table structure for table `wp_wpmailsmtp_tasks_meta`
--

DROP TABLE IF EXISTS `wp_wpmailsmtp_tasks_meta`;
CREATE TABLE `wp_wpmailsmtp_tasks_meta` (
  `id` bigint(20) NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_wpmailsmtp_tasks_meta`
--

INSERT INTO `wp_wpmailsmtp_tasks_meta` (`id`, `action`, `data`, `date`) VALUES
(1, 'wp_mail_smtp_summary_report_email', 'W10=', '2022-07-05 09:49:47'),
(2, 'wp_mail_smtp_admin_notifications_update', 'W10=', '2022-07-05 09:49:55'),
(3, 'wp_mail_smtp_admin_notifications_update', 'W10=', '2022-07-06 14:39:09'),
(4, 'wp_mail_smtp_admin_notifications_update', 'W10=', '2022-07-11 08:28:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_actionscheduler_actions`
--
ALTER TABLE `wp_actionscheduler_actions`
  ADD PRIMARY KEY (`action_id`),
  ADD KEY `hook` (`hook`),
  ADD KEY `status` (`status`),
  ADD KEY `scheduled_date_gmt` (`scheduled_date_gmt`),
  ADD KEY `args` (`args`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `last_attempt_gmt` (`last_attempt_gmt`),
  ADD KEY `claim_id` (`claim_id`),
  ADD KEY `claim_id_status_scheduled_date_gmt` (`claim_id`,`status`,`scheduled_date_gmt`);

--
-- Indexes for table `wp_actionscheduler_claims`
--
ALTER TABLE `wp_actionscheduler_claims`
  ADD PRIMARY KEY (`claim_id`),
  ADD KEY `date_created_gmt` (`date_created_gmt`);

--
-- Indexes for table `wp_actionscheduler_groups`
--
ALTER TABLE `wp_actionscheduler_groups`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `slug` (`slug`(191));

--
-- Indexes for table `wp_actionscheduler_logs`
--
ALTER TABLE `wp_actionscheduler_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `action_id` (`action_id`),
  ADD KEY `log_date_gmt` (`log_date_gmt`);

--
-- Indexes for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_comments`
--
ALTER TABLE `wp_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10)),
  ADD KEY `woo_idx_comment_type` (`comment_type`);

--
-- Indexes for table `wp_links`
--
ALTER TABLE `wp_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Indexes for table `wp_options`
--
ALTER TABLE `wp_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`),
  ADD KEY `autoload` (`autoload`);

--
-- Indexes for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_posts`
--
ALTER TABLE `wp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_terms`
--
ALTER TABLE `wp_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Indexes for table `wp_term_relationships`
--
ALTER TABLE `wp_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Indexes for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Indexes for table `wp_tutor_earnings`
--
ALTER TABLE `wp_tutor_earnings`
  ADD PRIMARY KEY (`earning_id`);

--
-- Indexes for table `wp_tutor_notifications`
--
ALTER TABLE `wp_tutor_notifications`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `wp_tutor_quiz_attempts`
--
ALTER TABLE `wp_tutor_quiz_attempts`
  ADD PRIMARY KEY (`attempt_id`);

--
-- Indexes for table `wp_tutor_quiz_attempt_answers`
--
ALTER TABLE `wp_tutor_quiz_attempt_answers`
  ADD PRIMARY KEY (`attempt_answer_id`);

--
-- Indexes for table `wp_tutor_quiz_questions`
--
ALTER TABLE `wp_tutor_quiz_questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `wp_tutor_quiz_question_answers`
--
ALTER TABLE `wp_tutor_quiz_question_answers`
  ADD PRIMARY KEY (`answer_id`);

--
-- Indexes for table `wp_tutor_withdraws`
--
ALTER TABLE `wp_tutor_withdraws`
  ADD PRIMARY KEY (`withdraw_id`);

--
-- Indexes for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_users`
--
ALTER TABLE `wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `wp_wc_download_log`
--
ALTER TABLE `wp_wc_download_log`
  ADD PRIMARY KEY (`download_log_id`),
  ADD KEY `permission_id` (`permission_id`),
  ADD KEY `timestamp` (`timestamp`);

--
-- Indexes for table `wp_wc_product_meta_lookup`
--
ALTER TABLE `wp_wc_product_meta_lookup`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `virtual` (`virtual`),
  ADD KEY `downloadable` (`downloadable`),
  ADD KEY `stock_status` (`stock_status`),
  ADD KEY `stock_quantity` (`stock_quantity`),
  ADD KEY `onsale` (`onsale`),
  ADD KEY `min_max_price` (`min_price`,`max_price`);

--
-- Indexes for table `wp_wc_tax_rate_classes`
--
ALTER TABLE `wp_wc_tax_rate_classes`
  ADD PRIMARY KEY (`tax_rate_class_id`),
  ADD UNIQUE KEY `slug` (`slug`(191));

--
-- Indexes for table `wp_wc_webhooks`
--
ALTER TABLE `wp_wc_webhooks`
  ADD PRIMARY KEY (`webhook_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `wp_woocommerce_api_keys`
--
ALTER TABLE `wp_woocommerce_api_keys`
  ADD PRIMARY KEY (`key_id`),
  ADD KEY `consumer_key` (`consumer_key`),
  ADD KEY `consumer_secret` (`consumer_secret`);

--
-- Indexes for table `wp_woocommerce_attribute_taxonomies`
--
ALTER TABLE `wp_woocommerce_attribute_taxonomies`
  ADD PRIMARY KEY (`attribute_id`),
  ADD KEY `attribute_name` (`attribute_name`(20));

--
-- Indexes for table `wp_woocommerce_downloadable_product_permissions`
--
ALTER TABLE `wp_woocommerce_downloadable_product_permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD KEY `download_order_key_product` (`product_id`,`order_id`,`order_key`(16),`download_id`),
  ADD KEY `download_order_product` (`download_id`,`order_id`,`product_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_order_remaining_expires` (`user_id`,`order_id`,`downloads_remaining`,`access_expires`);

--
-- Indexes for table `wp_woocommerce_log`
--
ALTER TABLE `wp_woocommerce_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `level` (`level`);

--
-- Indexes for table `wp_woocommerce_order_itemmeta`
--
ALTER TABLE `wp_woocommerce_order_itemmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `order_item_id` (`order_item_id`),
  ADD KEY `meta_key` (`meta_key`(32));

--
-- Indexes for table `wp_woocommerce_order_items`
--
ALTER TABLE `wp_woocommerce_order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `wp_woocommerce_payment_tokenmeta`
--
ALTER TABLE `wp_woocommerce_payment_tokenmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `payment_token_id` (`payment_token_id`),
  ADD KEY `meta_key` (`meta_key`(32));

--
-- Indexes for table `wp_woocommerce_payment_tokens`
--
ALTER TABLE `wp_woocommerce_payment_tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `wp_woocommerce_sessions`
--
ALTER TABLE `wp_woocommerce_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD UNIQUE KEY `session_key` (`session_key`);

--
-- Indexes for table `wp_woocommerce_shipping_zones`
--
ALTER TABLE `wp_woocommerce_shipping_zones`
  ADD PRIMARY KEY (`zone_id`);

--
-- Indexes for table `wp_woocommerce_shipping_zone_locations`
--
ALTER TABLE `wp_woocommerce_shipping_zone_locations`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `location_type_code` (`location_type`(10),`location_code`(20));

--
-- Indexes for table `wp_woocommerce_shipping_zone_methods`
--
ALTER TABLE `wp_woocommerce_shipping_zone_methods`
  ADD PRIMARY KEY (`instance_id`);

--
-- Indexes for table `wp_woocommerce_tax_rates`
--
ALTER TABLE `wp_woocommerce_tax_rates`
  ADD PRIMARY KEY (`tax_rate_id`),
  ADD KEY `tax_rate_country` (`tax_rate_country`),
  ADD KEY `tax_rate_state` (`tax_rate_state`(2)),
  ADD KEY `tax_rate_class` (`tax_rate_class`(10)),
  ADD KEY `tax_rate_priority` (`tax_rate_priority`);

--
-- Indexes for table `wp_woocommerce_tax_rate_locations`
--
ALTER TABLE `wp_woocommerce_tax_rate_locations`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `tax_rate_id` (`tax_rate_id`),
  ADD KEY `location_type_code` (`location_type`(10),`location_code`(20));

--
-- Indexes for table `wp_wpmailsmtp_debug_events`
--
ALTER TABLE `wp_wpmailsmtp_debug_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_wpmailsmtp_tasks_meta`
--
ALTER TABLE `wp_wpmailsmtp_tasks_meta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_actionscheduler_actions`
--
ALTER TABLE `wp_actionscheduler_actions`
  MODIFY `action_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `wp_actionscheduler_claims`
--
ALTER TABLE `wp_actionscheduler_claims`
  MODIFY `claim_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2405;

--
-- AUTO_INCREMENT for table `wp_actionscheduler_groups`
--
ALTER TABLE `wp_actionscheduler_groups`
  MODIFY `group_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wp_actionscheduler_logs`
--
ALTER TABLE `wp_actionscheduler_logs`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=544;

--
-- AUTO_INCREMENT for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_comments`
--
ALTER TABLE `wp_comments`
  MODIFY `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `wp_links`
--
ALTER TABLE `wp_links`
  MODIFY `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_options`
--
ALTER TABLE `wp_options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4063;

--
-- AUTO_INCREMENT for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=474;

--
-- AUTO_INCREMENT for table `wp_posts`
--
ALTER TABLE `wp_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wp_terms`
--
ALTER TABLE `wp_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `wp_tutor_earnings`
--
ALTER TABLE `wp_tutor_earnings`
  MODIFY `earning_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_tutor_notifications`
--
ALTER TABLE `wp_tutor_notifications`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_tutor_quiz_attempts`
--
ALTER TABLE `wp_tutor_quiz_attempts`
  MODIFY `attempt_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_tutor_quiz_attempt_answers`
--
ALTER TABLE `wp_tutor_quiz_attempt_answers`
  MODIFY `attempt_answer_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_tutor_quiz_questions`
--
ALTER TABLE `wp_tutor_quiz_questions`
  MODIFY `question_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_tutor_quiz_question_answers`
--
ALTER TABLE `wp_tutor_quiz_question_answers`
  MODIFY `answer_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_tutor_withdraws`
--
ALTER TABLE `wp_tutor_withdraws`
  MODIFY `withdraw_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  MODIFY `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `wp_users`
--
ALTER TABLE `wp_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wp_wc_download_log`
--
ALTER TABLE `wp_wc_download_log`
  MODIFY `download_log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_wc_tax_rate_classes`
--
ALTER TABLE `wp_wc_tax_rate_classes`
  MODIFY `tax_rate_class_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wp_wc_webhooks`
--
ALTER TABLE `wp_wc_webhooks`
  MODIFY `webhook_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_api_keys`
--
ALTER TABLE `wp_woocommerce_api_keys`
  MODIFY `key_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_attribute_taxonomies`
--
ALTER TABLE `wp_woocommerce_attribute_taxonomies`
  MODIFY `attribute_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_downloadable_product_permissions`
--
ALTER TABLE `wp_woocommerce_downloadable_product_permissions`
  MODIFY `permission_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_log`
--
ALTER TABLE `wp_woocommerce_log`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_order_itemmeta`
--
ALTER TABLE `wp_woocommerce_order_itemmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_order_items`
--
ALTER TABLE `wp_woocommerce_order_items`
  MODIFY `order_item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_payment_tokenmeta`
--
ALTER TABLE `wp_woocommerce_payment_tokenmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_payment_tokens`
--
ALTER TABLE `wp_woocommerce_payment_tokens`
  MODIFY `token_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_sessions`
--
ALTER TABLE `wp_woocommerce_sessions`
  MODIFY `session_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2516;

--
-- AUTO_INCREMENT for table `wp_woocommerce_shipping_zones`
--
ALTER TABLE `wp_woocommerce_shipping_zones`
  MODIFY `zone_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_shipping_zone_locations`
--
ALTER TABLE `wp_woocommerce_shipping_zone_locations`
  MODIFY `location_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_shipping_zone_methods`
--
ALTER TABLE `wp_woocommerce_shipping_zone_methods`
  MODIFY `instance_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_tax_rates`
--
ALTER TABLE `wp_woocommerce_tax_rates`
  MODIFY `tax_rate_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_woocommerce_tax_rate_locations`
--
ALTER TABLE `wp_woocommerce_tax_rate_locations`
  MODIFY `location_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_wpmailsmtp_debug_events`
--
ALTER TABLE `wp_wpmailsmtp_debug_events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wp_wpmailsmtp_tasks_meta`
--
ALTER TABLE `wp_wpmailsmtp_tasks_meta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wp_wc_download_log`
--
ALTER TABLE `wp_wc_download_log`
  ADD CONSTRAINT `fk_wp_wc_download_log_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `wp_woocommerce_downloadable_product_permissions` (`permission_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
