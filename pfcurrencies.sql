-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2016 at 07:22 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pfcurrencies`
--

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE IF NOT EXISTS `discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `action` enum('No action','Apply a 2% discount','Send an Email Notification') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No action',
  `total_amount_discount` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`id`, `order_id`, `action`, `total_amount_discount`) VALUES
(1, 1, 'Send an Email Notification', 3033.3763848),
(2, 2, 'Send an Email Notification', 5176.9623634),
(3, 3, 'Send an Email Notification', 2022.2509232),
(4, 4, 'Send an Email Notification', 3538.9391156),
(5, 5, 'Send an Email Notification', 6976.7656851),
(6, 6, 'Send an Email Notification', 8796.791516),
(7, 7, 'Send an Email Notification', 12639.06827),
(8, 8, 'Send an Email Notification', 10111.2546161),
(9, 9, 'Send an Email Notification', 9100.1291544),
(10, 10, 'Apply a 2% discount', 14341.34748459),
(11, 11, 'Send an Email Notification', 20222.5092321),
(12, 27, 'Apply a 2% discount', 21512.021226836),
(13, 28, 'Apply a 2% discount', 3671.384956106),
(14, 37, 'Apply a 2% discount', 17209.616981508),
(15, 60, 'Send an Email Notification', 20076.4818356),
(16, 61, 'Send an Email Notification', 24091.7782027),
(17, 62, 'Send an Email Notification', 2670.1720841),
(18, 63, 'Send an Email Notification', 20076.4818356),
(19, 64, 'Send an Email Notification', 29010.5162524),
(20, 65, 'Send an Email Notification', 11142.4474187),
(21, 66, 'Send an Email Notification', 11142.4474187),
(22, 67, 'Send an Email Notification', 689486.6156788),
(23, 68, 'Send an Email Notification', 68942.6386233),
(24, 69, 'Send an Email Notification', 1104.206501),
(25, 72, 'Apply a 2% discount', 13980.978260844);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1428928635),
('m130524_201442_init', 1428928646);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `operation` enum('Purchase','Pay') COLLATE utf8_unicode_ci NOT NULL,
  `fcp` enum('USD','GBP','EUR','KES') COLLATE utf8_unicode_ci NOT NULL,
  `rate` double NOT NULL,
  `surcharge` double NOT NULL,
  `initial_amout` double NOT NULL,
  `fcp_amount` double NOT NULL,
  `fcp_amount_surcharged` double NOT NULL,
  `amount_of_surcharge` double NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=84 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userid`, `operation`, `fcp`, `rate`, `surcharge`, `initial_amout`, `fcp_amount`, `fcp_amount_surcharged`, `amount_of_surcharge`, `created_at`) VALUES
(1, 1, 'Purchase', 'GBP', 0.05192234, 5, 150, 2888.9298903, 3033.3763848, 144.4464945, '2015-06-14 09:29:21'),
(2, 1, 'Purchase', 'GBP', 0.05192234, 5, 256, 4930.4403461, 5176.9623634, 246.5220173, '2015-06-14 09:35:24'),
(3, 1, 'Purchase', 'GBP', 0.05192234, 5, 100, 1925.9532602, 2022.2509232, 96.297663, '2015-06-14 09:49:09'),
(4, 1, 'Purchase', 'GBP', 0.05192234, 5, 175, 3370.4182053, 3538.9391156, 168.5209103, '2015-06-14 09:51:26'),
(5, 1, 'Purchase', 'GBP', 0.05192234, 5, 345, 6644.5387477, 6976.7656851, 332.2269374, '2015-06-14 09:53:26'),
(6, 1, 'Purchase', 'GBP', 0.05192234, 5, 435, 8377.8966819, 8796.791516, 418.8948341, '2015-06-14 09:55:48'),
(7, 1, 'Purchase', 'GBP', 0.05192234, 5, 625, 12037.2078762, 12639.06827, 601.8603938, '2015-06-14 09:56:44'),
(8, 1, 'Purchase', 'GBP', 0.05192234, 5, 500, 9629.766301, 10111.2546161, 481.4883151, '2015-06-14 10:01:28'),
(9, 1, 'Purchase', 'GBP', 0.05192234, 5, 450, 8666.7896709, 9100.1291544, 433.3394835, '2015-06-14 10:03:32'),
(10, 1, 'Purchase', 'EUR', 0.07175058, 5, 1000, 13937.1695671, 14634.0280455, 696.8584784, '2015-06-14 10:04:48'),
(11, 1, 'Purchase', 'GBP', 0.05192234, 5, 1000, 19259.532602, 20222.5092321, 962.9766301, '2015-06-14 10:05:28'),
(12, 1, 'Pay', 'USD', 0.08079111, 0, 1000, 80.79111, 80.79111, 0, '2015-06-14 10:32:11'),
(13, 1, 'Pay', 'USD', 0.08079111, 0, 30000, 2423.7333, 2423.7333, 0, '2015-06-14 10:34:31'),
(14, 1, 'Pay', 'USD', 0.08079111, 0, 30000, 2423.7333, 2423.7333, 0, '2015-06-14 10:40:58'),
(15, 1, 'Pay', 'USD', 0.08079111, 0, 25000, 2019.77775, 2019.77775, 0, '2015-06-14 10:42:04'),
(16, 1, 'Pay', 'USD', 0.08079111, 0, 500, 40.395555, 40.395555, 0, '2015-06-14 10:50:58'),
(17, 1, 'Pay', 'USD', 0.08079111, 0, 1500, 121.186665, 121.186665, 0, '2015-06-14 10:56:35'),
(18, 1, 'Pay', 'USD', 0.08079111, 0, 2000, 161.58222, 161.58222, 0, '2015-06-14 10:58:24'),
(19, 1, 'Pay', 'USD', 0.08079111, 0, 1800, 145.423998, 145.423998, 0, '2015-06-14 10:58:58'),
(20, 1, 'Pay', 'USD', 0.08079111, 0, 2500, 201.977775, 201.977775, 0, '2015-06-14 10:59:18'),
(21, 1, 'Pay', 'USD', 0.08079111, 0, 3000, 242.37333, 242.37333, 0, '2015-06-14 11:00:12'),
(22, 1, 'Pay', 'USD', 0.08079111, 0, 1000, 80.79111, 80.79111, 0, '2015-06-14 11:00:27'),
(23, 1, 'Pay', 'USD', 0.08079111, 0, 1800, 145.423998, 145.423998, 0, '2015-06-14 11:00:54'),
(24, 1, 'Pay', 'EUR', 0.07175058, 0, 375, 26.9064675, 26.9064675, 0, '2015-06-14 11:13:40'),
(25, 1, 'Pay', 'USD', 0.08079111, 0, 125, 10.0988888, 10.0988888, 0, '2015-06-14 11:14:45'),
(26, 1, 'Purchase', 'USD', 0.08079111, 7.5, 1600, 19804.1591457, 21289.4710816, 1485.3119359, '2015-06-14 18:48:59'),
(27, 1, 'Purchase', 'EUR', 0.07175058, 5, 1500, 20905.7543507, 21951.0420682, 1045.2877175, '2015-06-14 18:49:45'),
(28, 1, 'Purchase', 'EUR', 0.07175058, 5, 256, 3567.9154092, 3746.3111797, 178.3957705, '2015-06-14 18:50:46'),
(29, 1, 'Pay', 'USD', 0.08079111, 0, 1000, 80.79111, 80.79111, 0, '2015-06-14 18:56:19'),
(30, 1, 'Pay', 'USD', 0.08079111, 0, 1800, 145.423998, 145.423998, 0, '2015-06-14 18:58:44'),
(31, 1, 'Pay', 'USD', 0.08079111, 0, 120, 9.6949332, 9.6949332, 0, '2015-06-14 19:00:21'),
(32, 1, 'Pay', 'USD', 0.08079111, 0, 120, 9.6949332, 9.6949332, 0, '2015-06-14 19:00:56'),
(33, 1, 'Pay', 'KES', 7.85883362, 0, 560, 4400.9468272, 4400.9468272, 0, '2015-06-14 19:01:47'),
(34, 1, 'Pay', 'EUR', 0.07175058, 0, 230, 16.5026334, 16.5026334, 0, '2015-06-14 19:03:09'),
(35, 1, 'Pay', 'EUR', 0.07175058, 0, 255, 18.2963979, 18.2963979, 0, '2015-06-14 19:05:07'),
(36, 1, 'Pay', 'KES', 7.85883362, 0, 1300, 10216.483706, 10216.483706, 0, '2015-06-14 19:07:58'),
(37, 1, 'Purchase', 'EUR', 0.07175058, 5, 1200, 16724.6034806, 17560.8336546, 836.230174, '2015-06-14 19:08:13'),
(38, 1, 'Purchase', 'USD', 0.08042173, 7.5, 2300, 28599.2355549, 30744.1782215, 2144.9426666, '2015-06-15 12:49:28'),
(39, 1, 'Pay', 'USD', 0.08051238, 0, 3300, 265.690854, 265.690854, 0, '2015-06-15 14:30:40'),
(40, 1, 'Pay', 'USD', 0.08051238, 0, 13200, 1062.763416, 1062.763416, 0, '2015-06-15 14:31:46'),
(41, 1, 'Purchase', 'USD', 0.08051238, 7.5, 6, 74.5227007, 80.1119033, 5.5892026, '2015-06-15 14:32:21'),
(42, 1, 'Pay', 'USD', 0.08051238, 0, 13320, 1072.4249016, 1072.4249016, 0, '2015-06-15 14:33:18'),
(43, 1, 'Purchase', 'USD', 0.08062143, 7.5, 1000, 12403.6499973, 13333.9237471, 930.2737498, '2015-06-16 16:22:41'),
(44, 1, 'Pay', 'USD', 0.08062143, 0, 3330, 268.4693619, 268.4693619, 0, '2015-06-16 16:23:41'),
(45, 1, 'Purchase', 'USD', 0.08062143, 7.5, 250, 3100.9124993, 3333.4809367, 232.5684374, '2015-06-16 16:24:19'),
(46, 1, 'Pay', 'USD', 0.08062143, 0, 200, 16.124286, 16.124286, 0, '2015-06-16 16:24:40'),
(47, 1, 'Purchase', 'USD', 0.08062143, 7.5, 26, 322.4948999, 346.6820174, 24.1871175, '2015-06-16 16:25:15'),
(48, 1, 'Purchase', 'USD', 0.08042238, 7.5, 1000, 12434.3497419, 13366.9259725, 932.5762306, '2015-06-17 13:09:41'),
(49, 1, 'Pay', 'USD', 0.08047577, 0, 1000, 80.47577, 80.47577, 0, '2015-06-17 13:10:40'),
(50, 1, 'Pay', 'USD', 0.08236927, 0, 10000, 823.6927, 823.6927, 0, '2015-06-23 10:53:10'),
(51, 1, 'Pay', 'USD', 0.08229674, 0, 10000, 822.9674, 822.9674, 0, '2015-06-24 12:04:53'),
(52, 1, 'Purchase', 'USD', 0.08229674, 7.5, 1000, 12151.1496081, 13062.4858287, 911.3362206, '2015-06-24 12:05:50'),
(53, 1, 'Purchase', 'USD', 0.08229674, 7.5, 1000, 12151.1496081, 13062.4858287, 911.3362206, '2015-06-24 13:28:05'),
(54, 1, 'Purchase', 'USD', 0.08229674, 7.5, 1500, 18226.7244122, 19593.7287431, 1367.0043309, '2015-06-24 13:29:08'),
(55, 1, 'Purchase', 'USD', 0.08229674, 7.5, 2000, 24302.2992162, 26124.9716574, 1822.6724412, '2015-06-24 13:32:26'),
(56, 1, 'Purchase', 'USD', 0.08229674, 7.5, 444, 5395.110426, 5799.743708, 404.633282, '2015-06-24 13:33:55'),
(57, 1, 'Purchase', 'USD', 0.0824, 7.5, 144, 1747.5728155, 1878.6407767, 131.0679612, '2015-06-24 13:36:08'),
(58, 1, 'Pay', 'USD', 0.0824, 0, 1000, 82.4, 82.4, 0, '2015-06-24 13:40:42'),
(59, 1, 'Pay', 'USD', 0.0824, 0, 1000, 82.4, 82.4, 0, '2015-06-24 13:41:15'),
(60, 1, 'Purchase', 'GBP', 0.0523, 5, 1000, 19120.458891, 20076.4818356, 956.0229446, '2015-06-24 13:41:40'),
(61, 1, 'Purchase', 'GBP', 0.0523, 5, 1200, 22944.5506692, 24091.7782027, 1147.2275335, '2015-06-24 13:44:44'),
(62, 1, 'Purchase', 'GBP', 0.0523, 5, 133, 2543.0210325, 2670.1720841, 127.1510516, '2015-06-24 13:52:43'),
(63, 1, 'Purchase', 'GBP', 0.0523, 5, 1000, 19120.458891, 20076.4818356, 956.0229446, '2015-06-24 13:55:15'),
(64, 1, 'Purchase', 'GBP', 0.0523, 5, 1445, 27629.0630975, 29010.5162524, 1381.4531549, '2015-06-24 14:02:11'),
(65, 1, 'Purchase', 'GBP', 0.0523, 5, 555, 10611.8546845, 11142.4474187, 530.5927342, '2015-06-24 14:05:02'),
(66, 1, 'Purchase', 'GBP', 0.0523, 5, 555, 10611.8546845, 11142.4474187, 530.5927342, '2015-06-24 14:05:49'),
(67, 1, 'Purchase', 'GBP', 0.0523, 5, 34343, 656653.9196941, 689486.6156788, 32832.6959847, '2015-06-24 14:07:18'),
(68, 1, 'Purchase', 'GBP', 0.0523, 5, 3434, 65659.6558317, 68942.6386233, 3282.9827916, '2015-06-24 14:08:23'),
(69, 1, 'Purchase', 'GBP', 0.0523, 5, 55, 1051.625239, 1104.206501, 52.581262, '2015-06-24 14:09:42'),
(70, 1, 'Pay', 'USD', 0.0825, 0, 1000, 82.5, 82.5, 0, '2015-06-24 14:10:36'),
(71, 1, 'Pay', 'GBP', 0.0524, 0, 1000, 52.4, 52.4, 0, '2015-06-24 14:10:48'),
(72, 1, 'Purchase', 'EUR', 0.0736, 5, 1000, 13586.9565217, 14266.3043478, 679.3478261, '2015-06-24 14:10:58'),
(73, 1, 'Purchase', 'USD', 0.0822, 7.5, 2300, 27980.5352798, 30079.0754258, 2098.540146, '2015-07-01 12:51:40'),
(74, 1, 'Purchase', 'USD', 0.0822, 7.5, 2500, 30413.6253041, 32694.6472019, 2281.0218978, '2015-07-01 12:51:55'),
(75, 1, 'Purchase', 'USD', 0.0821, 7.5, 2300, 28014.6163216, 30115.7125457, 2101.0962241, '2015-07-01 12:52:08'),
(76, 1, 'Purchase', 'USD', 0.0821, 7.5, 2000, 24360.5359318, 26187.5761267, 1827.0401949, '2015-07-01 12:52:52'),
(77, 1, 'Purchase', 'USD', 0.0821, 7.5, 27000, 328867.2350792, 353532.2777101, 24665.0426309, '2015-07-01 12:54:41'),
(78, 1, 'Pay', 'USD', 0.0821, 0, 27000, 2216.7, 2216.7, 0, '2015-07-01 12:54:55'),
(79, 1, 'Pay', 'USD', 0.0821, 0, 30000, 2463, 2463, 0, '2015-07-01 12:55:17'),
(80, 1, 'Purchase', 'USD', 0.0812, 7.5, 400, 4926.1083744, 5295.5665025, 369.4581281, '2015-07-05 14:21:25'),
(81, 1, 'Pay', 'USD', 0.0755, 0, 324900, 24529.95, 24529.95, 0, '2015-10-19 16:16:50'),
(82, 1, 'Pay', 'USD', 0.0753, 0, 416000, 31324.8, 31324.8, 0, '2015-10-19 17:46:25'),
(83, 1, 'Pay', 'USD', 0.0753, 0, 329000, 24773.7, 24773.7, 0, '2015-10-19 17:48:40');

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE IF NOT EXISTS `rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utctime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from` enum('ZAR','USD','GBP','EUR','KES') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ZAR',
  `to` enum('USD','GBP','EUR','KES') COLLATE utf8_unicode_ci NOT NULL,
  `rate` double NOT NULL,
  `surcharge` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`id`, `utctime`, `from`, `to`, `rate`, `surcharge`) VALUES
(1, '2015-10-19T17:46:25+02:00', 'ZAR', 'USD', 0.0753, 7.5),
(2, '2015-06-24T14:10:48+02:00', 'ZAR', 'GBP', 0.0524, 5),
(3, '2015-06-24T14:10:57+02:00', 'ZAR', 'EUR', 0.0736, 5),
(4, '2015-06-13T12:20:02+02:00', 'ZAR', 'KES', 7.85883362, 2.5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Mouhamad Ounayssi', 'Sjv3jMRb7Cav3Di8TCuVf7--QbUTFw_m', '$2y$13$BUbmRjfDJZ5Xv/FrIeyxBOnkIG.60KslxWOPTqIP177IM6ixufntG', '2MFv6zHnVrPMO4AsHUD-JYUFMOIsvc8X_1428934676', 'mouhamad.ounayssi@gmail.com', 10, 1428929594, 1428934676);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
