-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 05:44 AM
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
-- Database: `db_sdshoppe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adminID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `pics` varchar(255) NOT NULL,
  `login_attempts` int(11) DEFAULT 0,
  `lockout_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adminID`, `name`, `password`, `position`, `pics`, `login_attempts`, `lockout_time`) VALUES
(1, 'Sharleen', 'sharleenadmin', 'IT Tech', 'images\\shao.jpg', 0, NULL),
(2, 'Shaima', 'ownerofhaus', 'OWNER', 'images\\shai.jpg', 0, NULL),
(3, 'Danica', 'slayable', 'Admin', 'images\\dani.jpg', 0, NULL),
(4, 'Francis ', 'dandadan', 'Admin', 'images\\raf.jpg', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bulk_order_details`
--

CREATE TABLE `bulk_order_details` (
  `bulk_order_id` int(8) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `grand_total` decimal(10,2) NOT NULL,
  `delivery_method` varchar(255) NOT NULL,
  `delivery_date` date NOT NULL,
  `payment_id` int(11) NOT NULL,
  `status` enum('To Pay','To Ship','To Receive','Completed','Cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bulk_order_details`
--

INSERT INTO `bulk_order_details` (`bulk_order_id`, `customer_id`, `order_date`, `grand_total`, `delivery_method`, `delivery_date`, `payment_id`, `status`) VALUES
(50000027, 1, '2024-12-01 14:27:45', 50500.00, 'Pick Up', '2024-02-01', 123, 'To Pay'),
(50000028, 1, '2024-12-01 15:32:06', 40500.00, 'Contact Seller', '2024-12-01', 124, 'To Pay'),
(50000029, 1, '2024-12-01 15:42:12', 40500.00, 'Pick Up', '2004-12-01', 3212104, 'To Pay'),
(50000030, 1, '2024-12-01 16:11:01', 45000.00, 'Pick Up', '2024-12-12', 3212105, 'To Pay'),
(50000031, 1, '2024-12-01 16:22:15', 40500.00, 'Pick Up', '2024-12-01', 125, 'To Pay'),
(50000032, 1, '2024-12-01 16:42:34', 56000.00, 'Contact Seller', '2024-12-02', 126, 'To Pay'),
(50000033, 123513, '2024-12-01 17:12:31', 36000.00, 'Pick Up', '2024-12-12', 127, 'To Pay'),
(50000034, 123513, '2024-12-01 17:33:48', 36000.00, 'Contact Seller', '2024-12-12', 128, 'To Pay'),
(50000035, 123513, '2024-12-01 18:33:42', 36000.00, 'Pick Up', '2024-12-12', 129, 'To Pay'),
(50000036, 123513, '2024-12-01 18:50:32', 180000.00, 'Contact Seller', '2024-12-12', 3212106, 'To Pay'),
(50000037, 123513, '2024-12-01 19:04:13', 40500.00, 'Contact Seller', '2024-12-12', 130, 'To Pay'),
(50000038, 123513, '2024-12-01 19:08:23', 60000.00, 'Pick Up', '2024-12-12', 131, 'To Pay'),
(50000039, 123513, '2024-12-01 19:20:38', 36000.00, 'Contact Seller', '2024-12-12', 132, 'To Pay'),
(50000040, 123513, '2024-12-01 19:25:52', 40500.00, 'Contact Seller', '2024-12-12', 134, 'To Pay'),
(50000041, 123513, '2024-12-02 05:52:39', 30500.00, 'Pick Up', '2025-02-20', 135, 'To Pay'),
(50000042, 123513, '2024-12-02 06:19:05', 54000.00, 'Contact Seller', '2024-12-12', 136, 'To Pay'),
(50000047, 1, '2024-12-02 10:01:10', 12000.00, 'Contact Seller', '2024-12-10', 137, 'To Pay'),
(50000048, 123475, '2024-12-04 16:59:43', 40500.00, 'Pick Up', '2024-12-06', 11220000, 'To Pay'),
(50000049, 123470, '2024-12-05 03:07:32', 82500.00, 'Pick Up', '2024-12-25', 11220000, 'To Pay');

-- --------------------------------------------------------

--
-- Table structure for table `bulk_order_items`
--

CREATE TABLE `bulk_order_items` (
  `bulk_order_items` int(11) NOT NULL,
  `bulk_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `yards` int(11) NOT NULL,
  `rolls` int(11) NOT NULL,
  `item_subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bulk_order_items`
--

INSERT INTO `bulk_order_items` (`bulk_order_items`, `bulk_order_id`, `product_id`, `product_name`, `color`, `yards`, `rolls`, `item_subtotal`) VALUES
(26, 50000020, 3, 'Spark Fly-Caviar', 'Fuchsia Pink', 0, 5, 0.00),
(27, 50000022, 4, 'Bejeweled-Beaded', 'Champagne', 33, 2, 0.00),
(28, 50000022, 1, 'Enchanted-Beaded', 'White', 33, 0, 0.00),
(29, 50000023, 2, 'Midnight-Corded', 'Blush Pink', 34, 4, 0.00),
(30, 50000023, 4, 'Bejeweled-Beaded', 'Champagne', 43, 0, 0.00),
(31, 50000024, 2, 'Midnight-Corded', 'Emerald Green', 34, 4, 0.00),
(32, 50000024, 1, 'Enchanted-Beaded', 'Red', 30, 5, 0.00),
(33, 50000024, 8, 'Style Corded Lace', 'No colors available', 42, 0, 0.00),
(34, 50000025, 2, 'Midnight-Corded', 'Lavender', 37, 4, 0.00),
(35, 50000025, 1, 'Enchanted-Beaded', 'White', 46, 0, 0.00),
(36, 50000025, 6, 'Epiphany Candy Crush', 'Fuchsia Pink', 37, 10, 0.00),
(37, 50000026, 4, 'Bejeweled-Beaded', 'Pink-Champagne', 45, 0, 0.00),
(38, 50000026, 3, 'Spark Fly-Caviar', 'Fuchsia Pink', 35, 0, 0.00),
(39, 50000026, 3, 'Spark Fly-Caviar', 'Magenta', 0, 8, 0.00),
(40, 50000027, 6, 'Epiphany Candy Crush', 'Pink', 30, 2, 50500.00),
(41, 50000028, 11, 'Style Panel Lace ', 'Blue', 30, 1, 40500.00),
(42, 50000029, 11, 'Style Panel Lace ', 'Red', 30, 1, 40500.00),
(43, 50000030, 12, 'Wannabe Panel Lace', 'Dirty White', 30, 1, 45000.00),
(44, 50000031, 14, 'Glam Panel Lace ', 'Cyan', 30, 1, 40500.00),
(45, 50000032, 4, 'Bejeweled-Beaded', 'Pink-Champagne', 30, 1, 56000.00),
(46, 50000033, 16, 'Queendom Velvet Embroider ', 'Yellow', 30, 1, 36000.00),
(47, 50000034, 17, 'Campfire Velvet Embroider ', 'Maroon', 30, 1, 36000.00),
(48, 50000035, 19, 'Sour Grapes Velvet Embroider ', 'Black', 30, 1, 36000.00),
(49, 50000036, 15, 'Primadona Heavy Beaded Lace', 'Pink', 30, 1, 180000.00),
(50, 50000037, 10, 'Corded Embroider Lace All Over ', 'Baby Pink', 30, 1, 40500.00),
(51, 50000038, 1, 'Enchanted-Beaded', 'Red', 30, 1, 60000.00),
(52, 50000039, 23, 'Winter Velvet Embroider', 'White', 30, 1, 36000.00),
(53, 50000040, 13, 'Little Freak Panel All Over Lace', 'Lilac', 30, 1, 40500.00),
(54, 50000041, 6, 'Epiphany Candy Crush', 'Fuchsia Pink', 30, 1, 30500.00),
(55, 50000042, 21, 'Circles Velvet Embroider', 'Red', 30, 1, 36000.00),
(56, 50000042, 8, 'Love Talk Corded 3D Lace ', 'Baby Blue', 30, 0, 18000.00),
(57, 50000047, 16, 'Queendom Velvet Embroider ', 'Blue', 30, 0, 12000.00),
(58, 50000048, 11, 'Style Panel Lace ', 'White', 30, 1, 40500.00),
(59, 50000049, 26, 'Croissant', 'gren', 30, 2, 82500.00);

-- --------------------------------------------------------

--
-- Table structure for table `bulk_payment`
--

CREATE TABLE `bulk_payment` (
  `payment_id` int(8) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `acc_name` varchar(255) NOT NULL,
  `method` enum('GCash','Maya','COD','') NOT NULL,
  `ref_num` varchar(255) NOT NULL,
  `proof` varchar(255) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `confirmation` enum('Not yet confirmed','Confirmed','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bulk_payment`
--

INSERT INTO `bulk_payment` (`payment_id`, `customer_id`, `customer_name`, `number`, `acc_name`, `method`, `ref_num`, `proof`, `payment_date`, `confirmation`) VALUES
(3212102, 123514, 'Meldridge Pingco', 2147483647, 'dani', 'GCash', 'fgdgsdgfe2343ref', 'uploads/67499e8f59937_70a92c5e-cf1e-49f6-940e-035a409a06a1.jpg', '2024-11-29 10:59:27', 'Not yet confirmed'),
(3212103, 123514, 'Meldridge Pingco', 2147483647, 'Meldridge', 'GCash', 'cefdfdsfdsfd', 'uploads/6749a411b9897_70a92c5e-cf1e-49f6-940e-035a409a06a1.jpg', '2024-11-29 11:22:57', 'Not yet confirmed'),
(3212104, 1, 'Sharleen Olaguir', 2324876, 'chao', 'GCash', '24135486', 'uploads/674c83d471913_Chart.jpeg', '2024-12-01 15:42:12', 'Not yet confirmed'),
(3212105, 1, 'Sharleen Olaguir', 2324876, 'chao', 'GCash', '24135486', 'uploads/674c8a95de8dc_Copy-of-fall-canada.png', '2024-12-01 16:11:01', 'Not yet confirmed'),
(3212106, 123513, 'Yzekiel Cooper', 2324876, 'yzzek', 'GCash', '54564', 'uploads/674caff8b8c5e_Shrek_(character).png', '2024-12-01 18:50:32', 'Not yet confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `bulk_shopping_cart`
--

CREATE TABLE `bulk_shopping_cart` (
  `bulk_cart_id` int(6) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `yards` int(11) DEFAULT NULL,
  `rolls` int(11) DEFAULT NULL,
  `color` varchar(255) NOT NULL,
  `delivery_method` varchar(255) NOT NULL,
  `delivery_date` date NOT NULL,
  `roll_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `item_subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bulk_shopping_cart`
--

INSERT INTO `bulk_shopping_cart` (`bulk_cart_id`, `product_id`, `product`, `customer_id`, `firstname`, `lastname`, `unit_price`, `yards`, `rolls`, `color`, `delivery_method`, `delivery_date`, `roll_price`, `payment_method`, `item_subtotal`) VALUES
(120183, 2, 'Midnight-Corded', 123514, 'Meldridge', 'Pingco', 350.00, NULL, NULL, '', '', '0000-00-00', 20000.00, '', 0.00),
(120214, 21, 'Circles Velvet Embroider', 123513, 'Yzekiel', 'Cooper', 400.00, 30, 1, 'Red', 'Pick Up', '2024-12-12', 24000.00, 'GCash', 36000.00),
(120218, 10, 'Corded Embroider Lace All Over ', 1, 'Sharleen ', 'Olaguir', 450.00, 30, 0, 'Blue', 'Pick Up', '0120-12-12', 27000.00, 'COD', 13500.00),
(120221, 4, 'Bejeweled-Beaded', 123470, 'Shaima', 'Mangadang', 1200.00, NULL, NULL, '', '', '0000-00-00', 20000.00, '', 0.00),
(120222, 4, 'Bejeweled-Beaded', 123470, 'Shaima', 'Mangadang', 1200.00, NULL, NULL, '', '', '0000-00-00', 20000.00, '', 0.00),
(120223, 4, 'Bejeweled-Beaded', 1, 'Sharleen ', 'Olaguir', 1200.00, NULL, NULL, '', '', '0000-00-00', 20000.00, '', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `cod_payment`
--

CREATE TABLE `cod_payment` (
  `cod_payment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `method` set('COD','','','') NOT NULL,
  `confirmation` enum('Not yet confirmed','Confirmed','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cod_payment`
--

INSERT INTO `cod_payment` (`cod_payment_id`, `customer_id`, `method`, `confirmation`) VALUES
(123, 1, 'COD', 'Not yet confirmed'),
(124, 1, 'COD', 'Not yet confirmed'),
(125, 1, 'COD', 'Not yet confirmed'),
(126, 1, 'COD', 'Not yet confirmed'),
(127, 123513, 'COD', 'Confirmed'),
(128, 123513, 'COD', 'Not yet confirmed'),
(129, 123513, 'COD', 'Not yet confirmed'),
(130, 123513, 'COD', 'Not yet confirmed'),
(131, 123513, 'COD', 'Not yet confirmed'),
(132, 123513, 'COD', 'Not yet confirmed'),
(134, 123513, 'COD', 'Not yet confirmed'),
(135, 123513, 'COD', 'Not yet confirmed'),
(136, 123513, 'COD', 'Not yet confirmed'),
(137, 1, 'COD', 'Not yet confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(11) NOT NULL,
  `1st_Week` decimal(10,2) NOT NULL,
  `2nd_Week` decimal(10,2) NOT NULL,
  `3rd_Week` decimal(10,2) NOT NULL,
  `4th_Week` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `1st_Week`, `2nd_Week`, `3rd_Week`, `4th_Week`) VALUES
(202411, 45000.00, 32045.00, 63874.00, 56381.00);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notif_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notif_id`, `id`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 'Admin is currently working on your order. Your order #200063 is now \"To Receive\".', 0, '2024-12-02 18:02:38'),
(2, 1, 'Admin is currently working on your order. Your order #200063 is now \"To Ship\".', 1, '2024-12-02 18:34:04'),
(3, 1, 'Admin is currently working on your order. Your order #200062 is now \"To Receive\".', 0, '2024-12-03 10:07:35'),
(4, 1, 'Your Order #200062 is now completed! Thank you for buying our product, suki!', 0, '2024-12-03 10:17:12'),
(5, 123474, 'Your Order #200064 is now on their way! Thank you for your patience.', 0, '2024-12-03 10:56:35'),
(6, 1, 'Your Order #200063 is now on their way! Thank you for your patience.', 0, '2024-12-03 10:56:49'),
(7, 1, 'Your Order #200063 is now on their way! Thank you for your patience.', 0, '2024-12-03 10:59:21'),
(8, 1, 'Your Order #200063 is now completed! Thank you for buying our product.', 0, '2024-12-03 11:30:25'),
(9, 1, 'Your Order #200063 is now completed! Thank you for buying our product.', 0, '2024-12-03 12:03:39'),
(10, 123470, 'Your Order #200081 is now on its way! Thank you for your patience.', 1, '2024-12-03 12:04:51'),
(11, 1, 'Your Order #200077 is now on its way! Thank you for your patience.', 0, '2024-12-03 12:07:18'),
(12, 1, 'Your Order #200077 is now completed! Thank you for buying our product.', 0, '2024-12-03 12:08:30'),
(13, 1, 'Your Order #200084 is now on its way! Thank you for your patience.', 1, '2024-12-03 12:15:56'),
(14, 1, 'Your Order #200084 is now on its way! Thank you for your patience.', 1, '2024-12-03 12:27:41'),
(15, 123470, 'Your Order #200082 is now on its way! Thank you for your patience.', 1, '2024-12-03 12:30:45'),
(16, 123475, 'Your Order #200087 is now to ship! We\'re preparing your items for shipment.', 0, '2024-12-04 17:01:53'),
(17, 123475, 'Your Order #200087 is now on its way! Thank you for your patience.', 0, '2024-12-04 17:03:01'),
(18, 123475, 'Your Order #200087 is now on its way! Thank you for your patience.', 0, '2024-12-04 17:17:50'),
(19, 123475, 'Your Order #200087 is now on its way! Thank you for your patience.', 0, '2024-12-04 17:24:49'),
(20, 123475, 'Your Order #200087 is now on its way! Thank you for your patience.', 0, '2024-12-04 17:25:16'),
(21, 123475, 'Your Order #200087 is now on its way! Thank you for your patience.', 0, '2024-12-04 17:25:43'),
(22, 123475, 'Your Order #200087 is now on its way! Thank you for your patience.', 0, '2024-12-04 17:27:00'),
(23, 123475, 'Your Order #200087 is now on its way! Thank you for your patience.', 0, '2024-12-04 17:27:58'),
(24, 1, 'Your Order #200085 is now on its way! Thank you for your patience.', 0, '2024-12-04 17:28:11'),
(25, 123475, 'Your Order #200087 is now on its way! Thank you for your patience.', 0, '2024-12-04 17:30:05'),
(26, 123475, 'Your Order #200087 is now on its way! Thank you for your patience.', 1, '2024-12-04 17:32:22'),
(27, 123470, 'Your Order #200088 is now to ship! We\'re preparing your items for shipment.', 0, '2024-12-05 03:11:53'),
(28, 123470, 'Your Order #200088 is now on its way! Thank you for your patience.', 1, '2024-12-05 03:12:35'),
(29, 123470, 'Your Order #200088 is now on its way! Thank you for your patience.', 0, '2024-12-05 03:14:59'),
(30, 123470, 'Your Order #200088 is now completed! Thank you for buying our product.', 0, '2024-12-05 03:15:18');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_num` int(15) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `delivery_option` varchar(50) NOT NULL,
  `payment` int(15) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` enum('To Pay','To Ship','To Receive','Completed','Cancelled') NOT NULL,
  `track_num` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_num`, `customer_id`, `sub_total`, `shipping_fee`, `total_price`, `delivery_option`, `payment`, `order_date`, `Status`, `track_num`) VALUES
(200062, 1, 1550.00, 44.00, 1594.00, 'lbc', 100066, '2024-11-22 14:08:46', 'Completed', '12345688'),
(200063, 1, 6000.00, 60.00, 6060.00, 'ninja-van', 100067, '2024-11-23 06:41:04', 'Completed', '12345689'),
(200064, 123474, 10000.00, 0.00, 10000.00, 'ninja-van', 100068, '2024-11-23 08:40:26', 'To Receive', NULL),
(200065, 123513, 1550.00, 44.00, 1594.00, 'lbc', 100069, '2024-11-25 03:49:47', 'To Ship', '102503'),
(200076, 123513, 600.00, 60.00, 660.00, 'ninja-van', 100082, '2024-11-29 06:07:12', 'To Pay', NULL),
(200077, 1, 1200.00, 44.00, 1244.00, 'lbc', 100083, '2024-11-29 13:41:19', 'Completed', NULL),
(200081, 123470, 5850.00, 90.00, 5940.00, 'ninja-van', 100090, '2024-11-29 17:26:06', 'To Receive', '010101'),
(200082, 123470, 450.00, 60.00, 510.00, 'jnt', 100091, '2024-11-29 17:31:07', 'To Receive', NULL),
(200083, 123470, 600.00, 64.00, 664.00, 'lbc', 100092, '2024-11-29 17:37:55', 'To Pay', NULL),
(200084, 1, 450.00, 60.00, 510.00, 'ninja-van', 100093, '2024-12-01 15:22:37', 'To Receive', NULL),
(200085, 1, 450.00, 44.00, 494.00, 'lbc', 100094, '2024-12-01 16:46:56', 'To Receive', NULL),
(200086, 123513, 800.00, 40.00, 840.00, 'jnt', 100095, '2024-12-01 16:47:47', 'To Pay', NULL),
(200087, 123475, 900.00, 44.00, 944.00, 'lbc', 100096, '2024-12-04 17:00:49', 'To Receive', '170V3Y0U'),
(200088, 123470, 1100.00, 90.00, 1190.00, 'ninja-van', 100097, '2024-12-05 03:10:46', 'Completed', '6876248');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_items_id` int(11) NOT NULL,
  `order_num` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `color` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_items_id`, `order_num`, `product_id`, `product_name`, `color`, `quantity`) VALUES
(20, '200062', 3, 'Spark Fly-Caviar', 'Fuchsia Pink', 2),
(21, '200062', 6, 'Epiphany Candy Crush', 'Pink', 1),
(22, '200063', 4, 'Bejeweled-Beaded', 'Purple-Pink', 5),
(23, '200064', 5, 'Wonderland Beaded Lace', 'Royal Blue', 2),
(24, '200064', 19, 'gumamela', 'Others', 1),
(25, '200065', 4, 'Bejeweled-Beaded', 'Purple-Pink', 1),
(26, '200065', 6, 'Epiphany Candy Crush', 'Pink', 1),
(38, '200076', 3, 'Spark Fly-Caviar', '', 1),
(39, '200077', 8, 'Love Talk Corded 3D Lace ', 'Blush Pink', 2),
(43, '200081', 1, 'Enchanted-Beaded', 'Red', 3),
(44, '200081', 4, 'Bejeweled-Beaded', 'Pink', 1),
(45, '200081', 3, 'Spark Fly-Caviar', 'Emerald Green', 2),
(46, '200081', 14, 'Glam Panel Lace ', '', 1),
(47, '200082', 9, 'Diva Corded All Over Lace ', '', 1),
(48, '200083', 8, 'Love Talk Corded 3D Lace ', 'Green', 1),
(49, '200084', 13, 'Little Freak Panel All Over Lace', 'Lilac', 1),
(50, '200085', 9, 'Diva Corded All Over Lace ', 'Baby Blue', 1),
(51, '200086', 23, 'Winter Velvet Embroider', 'White', 2),
(52, '200087', 11, 'Style Panel Lace ', 'Blue', 2),
(53, '200088', 26, 'Croissant', 'penk', 2);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(15) NOT NULL,
  `customer_id` int(15) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `number` varchar(11) NOT NULL,
  `acc_name` varchar(255) NOT NULL,
  `method` enum('Maya','Gcash','','') NOT NULL,
  `ref_num` varchar(255) NOT NULL,
  `proof` varchar(255) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `confirmation` enum('Not yet confirmed','Confirmed','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `customer_id`, `customer_name`, `number`, `acc_name`, `method`, `ref_num`, `proof`, `payment_date`, `confirmation`) VALUES
(100001, 1, 'Sharleen Olaguir', '09989333165', 'Sharleen Olaguir', 'Gcash', '4634873156753', 'edfdsfds', '2024-11-21 15:51:41', 'Not yet confirmed'),
(100066, 1, 'Sharleen Olaguir', '09989333165', 'shao', 'Gcash', '24135486', 'uploads/6740906ed0e49_410945053_1072793487371854_6481595374348650915_n.png', '2024-12-03 15:35:18', 'Not yet confirmed'),
(100067, 1, 'Sharleen Olaguir', '09989333165', 'shao', 'Maya', '24135486', 'uploads/674179005ec1f_heneh.png', '2024-12-03 15:51:36', 'Confirmed'),
(100068, 123474, 'Danica Kassandra Lepardo', '09989333165', 'chao', 'Maya', '24135486', 'uploads/674194fad4e29_III-CINS_POSTER.jpg', '2024-12-03 15:55:05', 'Confirmed'),
(100069, 123513, 'Yzekiel Cooper', '2324876', 'sadasdsad', 'Maya', '24135486', 'uploads/6743f3dbacccb_business-report-pie.png', '2024-11-25 03:49:47', 'Not yet confirmed'),
(100082, 123513, 'Yzekiel Cooper', '78787', 'yzzek', 'Gcash', '32', 'uploads/67495a10a856c_Chart.jpeg', '2024-11-29 06:07:12', 'Not yet confirmed'),
(100083, 1, 'Sharleen Olaguir', '546', 'chao', 'Maya', '54564', 'uploads/6749c47f76f63_Shrek_(character).png', '2024-11-29 13:41:19', 'Not yet confirmed'),
(100084, 123470, 'Shaima Mangadang', '232', 'shai', 'Gcash', '32', 'uploads/6749f78965df0_green.jpg', '2024-11-29 17:19:05', 'Not yet confirmed'),
(100085, 123470, 'Shaima Mangadang', '232', 'shai', 'Gcash', '32', 'uploads/6749f7acde52e_green.jpg', '2024-11-29 17:19:40', 'Not yet confirmed'),
(100086, 123470, 'Shaima Mangadang', '232', 'shai', 'Gcash', '32', 'uploads/6749f87322ad3_green.jpg', '2024-11-29 17:22:59', 'Not yet confirmed'),
(100087, 123470, 'Shaima Mangadang', '232', 'shai', 'Gcash', '32', 'uploads/6749f8b2170d5_green.jpg', '2024-11-29 17:24:02', 'Not yet confirmed'),
(100088, 123470, 'Shaima Mangadang', '232', 'shai', 'Gcash', '32', 'uploads/6749f8daaa5ec_green.jpg', '2024-11-29 17:24:42', 'Not yet confirmed'),
(100089, 123470, 'Shaima Mangadang', '232', 'shai', 'Gcash', '32', 'uploads/6749f8f9e0685_green.jpg', '2024-11-29 17:25:13', 'Not yet confirmed'),
(100090, 123470, 'Shaima Mangadang', '232', 'shai', 'Gcash', '32', 'uploads/6749f92e01329_green.jpg', '2024-11-29 17:26:06', 'Not yet confirmed'),
(100091, 123470, 'Shaima Mangadang', '215', 'shai', 'Maya', '32', 'uploads/6749fa5b427ee_455703904_1029671688950731_4237392567667379515_n.jpg', '2024-11-29 17:31:07', 'Not yet confirmed'),
(100092, 123470, 'Shaima Mangadang', '78787', 'shai', 'Gcash', '32', 'uploads/6749fbf3c7b60_Homemade-Croissants-Recipe60.jpg', '2024-11-29 17:37:55', 'Not yet confirmed'),
(100093, 1, 'Sharleen Olaguir', '2324876', 'chao', 'Gcash', '32', 'uploads/674c7f3d52e70_maxresdefault.jpg', '2024-12-01 15:22:37', 'Not yet confirmed'),
(100094, 1, 'Sharleen Olaguir', '09989333165', 'chao', 'Gcash', '8787', 'uploads/674c93005391c_sign-out-alt.png', '2024-12-01 16:46:56', 'Not yet confirmed'),
(100095, 123513, 'Yzekiel Cooper', '215', 'yzzek', 'Maya', '8787', 'uploads/674c93335ca0f_product-sales-comparison-chart.png', '2024-12-01 16:47:47', 'Not yet confirmed'),
(100096, 123475, 'la gasmen', '654897', 'la', 'Gcash', '987354', 'uploads/67508ac1cfe24_e66e283b-2a4c-4cf1-8c6c-49e7ad41a866.jpg', '2024-12-04 17:01:27', 'Confirmed'),
(100097, 123470, 'Shaima Mangadang', '2324876', 'shai', 'Gcash', '54564', 'uploads/675119b6d68b9_lacherpatisserie-petitgateaux-01.jpg', '2024-12-05 03:11:48', 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` enum('beaded lace','corded lace','caviar','candy crush','panel','velvet') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 100,
  `Status` varchar(255) NOT NULL,
  `product_image` varchar(100) DEFAULT NULL,
  `product_descript` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `roll_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category`, `price`, `quantity`, `Status`, `product_image`, `product_descript`, `date`, `roll_price`) VALUES
(1, 'Enchanted-Beaded', 'beaded lace', 1000.00, 20, 'In Stock', 'Assets\\inventory\\Enchanted-beaded CYAN.JPG', '', '2024-12-02 07:03:16', 30000.00),
(2, 'Midnight-Corded', 'corded lace', 350.00, 100, 'In Stock', 'Assets\\inventory\\Midnight-corded.JPG', '', '2024-11-26 13:52:36', 20000.00),
(3, 'Spark Fly-Caviar', 'caviar', 600.00, 77, 'In Stock', 'Assets\\inventory\\Spark Fly-caviar.JPG', '', '2024-11-29 17:26:06', 30000.00),
(4, 'Bejeweled-Beaded', 'beaded lace', 1200.00, 7, 'In Stock', 'Assets\\inventory\\Bejeweled-beaded.JPG', '', '2024-12-01 16:42:34', 20000.00),
(5, 'Wonderland Beaded Lace', 'beaded lace', 1000.00, 58, 'In Stock', 'Assets\\inventory\\Wonderland beaded lace.JPG', '', '2024-11-29 05:17:33', 30000.00),
(6, 'Epiphany Candy Crush', 'candy crush', 350.00, 89, 'In Stock', 'Assets\\inventory\\Epiphany candy crush.JPG', '', '2024-12-02 05:52:39', 20000.00),
(7, 'Juno Corded Spanish Lace ', 'corded lace', 350.00, 100, 'In Stock', 'Assets\\inventory\\Juno Spanish Lace.JPG', 'low', '2024-11-29 09:42:33', 21000.00),
(8, 'Love Talk Corded 3D Lace ', 'corded lace', 600.00, 67, 'In Stock', 'Assets\\inventory\\Love Talk 3D Lace.JPG', '', '2024-12-02 06:19:05', 36000.00),
(9, 'Diva Corded All Over Lace ', 'corded lace', 450.00, 98, 'In Stock', 'Assets\\inventory\\DIVA.JPG', '', '2024-12-01 16:46:56', 27000.00),
(10, 'Corded Embroider Lace All Over ', 'corded lace', 450.00, 70, 'In Stock', 'Assets\\inventory\\corded embroider lace.JPG', '', '2024-12-01 19:04:13', 27000.00),
(11, 'Style Panel Lace ', 'panel', 450.00, 68, 'In Stock', 'Assets\\inventory\\style panel.JPG', '', '2024-12-04 17:00:49', 27000.00),
(12, 'Wannabe Panel Lace', 'panel', 500.00, 70, 'In Stock', 'Assets\\inventory\\wannabe.JPG', '', '2024-12-01 16:11:01', 30000.00),
(13, 'Little Freak Panel All Over Lace', 'panel', 450.00, 69, 'In Stock', 'Assets\\inventory\\little freak.JPG', '', '2024-12-01 19:25:52', 27000.00),
(14, 'Glam Panel Lace ', 'panel', 450.00, 69, 'In Stock', 'Assets\\inventory\\glam panel.JPG', '', '2024-12-01 16:22:15', 27000.00),
(15, 'Primadona Heavy Beaded Lace', 'beaded lace', 2000.00, 70, 'In Stock', 'Assets\\inventory\\primadona.JPG', '', '2024-12-01 18:50:32', 120000.00),
(16, 'Queendom Velvet Embroider ', 'velvet', 400.00, 40, 'In Stock', 'Assets\\inventory\\queendom.JPG', '', '2024-12-02 10:01:10', 24000.00),
(17, 'Campfire Velvet Embroider ', 'velvet', 400.00, 70, 'In Stock', 'Assets\\inventory\\campfire.JPG', '', '2024-12-01 17:33:48', 24000.00),
(18, 'Caramel Velvet Embroiderer', 'velvet', 400.00, 100, 'In Stock', 'Assets\\inventory\\caramel.JPG', '', '2024-11-29 09:44:54', 24000.00),
(19, 'Sour Grapes Velvet Embroider ', 'velvet', 400.00, 70, 'In Stock', 'Assets\\inventory\\sour grapes.JPG', '', '2024-12-01 18:33:42', 24000.00),
(20, 'Kingdom Velvet Embroider', 'velvet', 400.00, 100, 'In Stock', 'Assets\\inventory\\kingdom.JPG', '', '2024-11-29 09:45:22', 24000.00),
(21, 'Circles Velvet Embroider', 'velvet', 400.00, 70, 'In Stock', 'Assets\\inventory\\circles.JPG', '', '2024-12-02 06:19:05', 24000.00),
(22, 'Coffee Velvet Embroider', 'velvet', 400.00, 100, 'In Stock', 'Assets\\inventory\\coffee.JPG', '', '2024-11-29 09:45:49', 24000.00),
(23, 'Winter Velvet Embroider', 'velvet', 400.00, 68, 'In Stock', 'Assets\\inventory\\winter.JPG', '', '2024-12-01 19:20:38', 24000.00),
(26, 'Croissant', 'panel', 550.00, 68, '', 'new_products/674eb8b889af8_Homemade-Croissants-Recipe60.jpg', '', '2024-12-05 03:10:46', 33000.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_colors`
--

CREATE TABLE `product_colors` (
  `color_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_name` varchar(50) NOT NULL,
  `product_pic` varchar(255) DEFAULT NULL,
  `rolls` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_colors`
--

INSERT INTO `product_colors` (`color_id`, `product_id`, `color_name`, `product_pic`, `rolls`) VALUES
(1, 1, 'Cyan', 'Assets\\inventory\\1 Enchanted-beaded P1000\\Enchanted-beaded CYAN.JPG', 50),
(2, 1, 'Red', 'Assets\\inventory\\1 Enchanted-beaded P1000\\Enchanted-beaded RED.JPG', 50),
(3, 1, 'Royal Blue', 'Assets\\inventory\\1 Enchanted-beaded P1000\\Enchanted-beaded ROYALBLUE.JPG', 50),
(4, 1, 'White', 'Assets\\inventory\\1 Enchanted-beaded P1000\\Enchanted-beaded WHITE.JPG', 50),
(5, 2, 'Blush Pink', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded BLUSHPINK.JPG', 50),
(6, 2, 'Champagne', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded CHAMPAGNE.JPG', 50),
(7, 2, 'Emerald Green', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded EMERALD GREEN(1).JPG', 50),
(8, 2, 'Lavender', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded LAVENDER.JPG', 50),
(9, 2, 'Red', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded RED.JPG', 0),
(10, 3, 'Champagne', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar CHAMPAGNE.JPG', 0),
(11, 3, 'Emerald Green', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar EMERALD GREEN.JPG', 0),
(12, 3, 'Fuchsia Pink', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar FUCHSIA PINK.JPG', 0),
(13, 3, 'Magenta', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar MAGENTA.JPG', 0),
(14, 3, 'Red', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar RED.JPG', 0),
(15, 4, 'Champagne', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded CHAMPAGNE.JPG', 0),
(16, 4, 'Dark Green', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded DARKGREEN.JPG', 0),
(17, 4, 'Pink-Champagne', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded PINK-CHAMPAGNE.JPG', 0),
(18, 4, 'Pink', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded PINK.JPG', 0),
(19, 4, 'Purple-Pink', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded PURPLE-PINK.JPG', 0),
(20, 5, 'Champagne', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace  CHAMPAGNE(1).JPG', 0),
(21, 5, 'Royal Blue', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace ROYALBLUE(1).JPG', 0),
(22, 5, 'Silver', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace SILVER.JPG', 0),
(23, 5, 'White-Purple', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace WHITE-PURPLE.JPG', 0),
(24, 6, 'Red', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush  RED.JPG', 0),
(25, 6, 'Silver', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush SILVER.JPG', 0),
(26, 6, 'Aqua Blue', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush AQUABLUE.JPG', 0),
(27, 6, 'Champagne', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush CHAMPAGNE.JPG', 0),
(28, 6, 'Emerald Green', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush EMERALD GREEN.JPG', 0),
(29, 6, 'Fuchsia Pink', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush FUCHSIA PINK.JPG', 0),
(30, 6, 'Green', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush GREEN.JPG', 0),
(31, 6, 'Orange', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush ORANGE.JPG', 0),
(32, 6, 'Pink', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush PINK.JPG', 0),
(36, 7, 'Aqua Blue', 'Assets\\inventory\\7 Juno (CORDED) Spanish Lace 350\\Juno Spanish Lace AQUA BLUE.JPG', 0),
(37, 7, 'Blush Pink', 'Assets\\inventory\\7 Juno (CORDED) Spanish Lace 350\\Juno Spanish Lace BLUSH PINK.JPG', 0),
(38, 7, 'Orange', 'Assets\\inventory\\7 Juno (CORDED) Spanish Lace 350\\Juno Spanish Lace ORANGE.JPG', 0),
(39, 7, 'White', 'Assets\\inventory\\7 Juno (CORDED) Spanish Lace 350\\Juno Spanish Lace WHITE.JPG', 0),
(40, 8, 'Baby Blue', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace BABY BLUE.JPG', 0),
(41, 8, 'Blue', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace BLUE.JPG', 0),
(42, 8, 'Blush Pink', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace BLUSH PINK.JPG', 0),
(43, 8, 'Emerald Green', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace EMERALD GREEN.JPG', 0),
(44, 8, 'Green', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace GREEN.JPG', 0),
(45, 8, 'Grey', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace GREY.JPG', 0),
(46, 8, 'Yellow', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace YELLOW.JPG', 0),
(47, 9, 'Baby Blue', 'Assets\\inventory\\9 Diva (CORDED) All Over Lace 450\\baby blue.JPG', 0),
(48, 9, 'Gold', 'Assets\\inventory\\9 Diva (CORDED) All Over Lace 450\\gold.JPG', 0),
(49, 9, 'Pink', 'Assets\\inventory\\9 Diva (CORDED) All Over Lace 450\\pink.JPG', 0),
(50, 10, 'Blue', 'Assets\\inventory\\10 (CORDED) Embroider Lace All Over 450\\blue.JPG', 0),
(51, 10, 'Baby Pink', 'Assets\\inventory\\10 (CORDED) Embroider Lace All Over 450\\pink.jpeg', 0),
(52, 10, 'White', 'Assets\\inventory\\10 (CORDED) Embroider Lace All Over 450\\white.JPG', 0),
(53, 11, 'Blue', 'Assets\\inventory\\11 Style Panel Lace 450\\blue.JPG', 0),
(54, 11, 'Red', 'Assets\\inventory\\11 Style Panel Lace 450\\red.JPG', 0),
(55, 11, 'White', 'Assets\\inventory\\11 Style Panel Lace 450\\white.JPG', 0),
(56, 12, 'Dirty White', 'Assets\\inventory\\12 Wannabe (PANEL) Lace 500\\dirty white.JPG', 0),
(57, 12, 'Khaki', 'Assets\\inventory\\12 Wannabe (PANEL) Lace 500\\khaki.JPG', 0),
(58, 12, 'Yellow', 'Assets\\inventory\\12 Wannabe (PANEL) Lace 500\\yellow.JPG', 0),
(59, 13, 'Red', 'Assets\\inventory\\13 Little Freak (PANEL) All Over Lace 450\\red.JPG', 0),
(60, 13, 'Lilac', 'Assets\\inventory\\13 Little Freak (PANEL) All Over Lace 450\\violet.JPG', 0),
(61, 13, 'White', 'Assets\\inventory\\13 Little Freak (PANEL) All Over Lace 450\\white.JPG', 0),
(62, 14, 'Cyan', 'Assets\\inventory\\14 Glam Panel Lace 450\\cyan.JPG', 0),
(63, 14, 'Silver', 'Assets\\inventory\\14 Glam Panel Lace 450\\silver.JPG', 0),
(64, 14, 'White', 'Assets\\inventory\\14 Glam Panel Lace 450\\white.JPG', 0),
(65, 15, 'Blue', 'Assets\\inventory\\15 Primadona (BEADED) Heavy Beaded Lace 2000\\blue.JPG', 0),
(66, 15, 'Green', 'Assets\\inventory\\15 Primadona (BEADED) Heavy Beaded Lace 2000\\green.JPG', 0),
(67, 15, 'Pink', 'Assets\\inventory\\15 Primadona (BEADED) Heavy Beaded Lace 2000\\pink.JPG', 0),
(68, 16, 'Blue', 'Assets\\inventory\\16 Queendom Velvet Embroider 400\\a.blue.JPG', 0),
(69, 16, 'Yellow', 'Assets\\inventory\\16 Queendom Velvet Embroider 400\\a.yellow.JPG', 0),
(70, 17, 'Blue Green', 'Assets\\inventory\\17 Campfire Velvet Embroider\\blue green.JPG', 0),
(71, 17, 'Maroon', 'Assets\\inventory\\17 Campfire Velvet Embroider\\maroon.JPG', 0),
(72, 18, 'White', 'Assets\\inventory\\18 Caramel Velvet Embroiderer\\white.JPG', 0),
(73, 19, 'Black', 'Assets\\inventory\\19 Sour Grapes Velvet Embroider\\black.JPG', 0),
(74, 20, 'Violet', 'Assets\\inventory\\20 Kindom Velvet Embroider\\violet.JPG', 0),
(75, 21, 'Red', 'Assets\\inventory\\21 Circles Velvet Embroider\\red.JPG', 0),
(76, 22, 'White', 'Assets\\inventory\\22 Coffee Velvet Embroider\\white.JPG', 0),
(77, 23, 'White', 'Assets\\inventory\\23 Winter Velvet Embroider\\white.JPG', 0),
(83, 26, 'gren', 'new_products\\colors\\674ebaf437b73_Shrek_(character).png', 0),
(85, 26, 'choco', 'new_products\\colors\\674ebb2898d4d_lacherpatisserie-petitgateaux-01.jpg', 0),
(89, 26, 'penk', 'new_products\\colors\\674ecd7b14f7e_maxresdefault.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `post_id` bigint(12) NOT NULL,
  `user_id` int(6) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` varchar(1) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_ratings`
--

INSERT INTO `product_ratings` (`post_id`, `user_id`, `user_firstname`, `user_lastname`, `product_id`, `rating`, `title`, `description`, `time`) VALUES
(122300000059, 123507, 'mel', 'cutie', 1, '5', 'Danica', 'Lepardo', '2024-11-20 09:17:07'),
(122300000060, 123470, 'Shaima', 'Mangadang', 1, '4', 'dddddddddddddddddddddd', 'dsatrgrgdgdfgdgrrgr', '2024-11-20 09:27:46'),
(122300000061, 123470, 'Shaima', 'Mangadang', 1, '5', 'sfdfsdf', 'cccccccccccc', '2024-11-20 09:28:46'),
(122300000062, 123474, 'Danica Kassandra', 'Lepardo', 3, '1', 'HAYNAKOOOOOOOOOOOOOOOOOOOOOOOOOO', 'skadhsjkfhdsjfhdsfjdshfjsdhfdksjfsdkjfhdsjfhf', '2024-11-20 09:29:52'),
(122300000063, 123474, 'Danica Kassandra', 'Lepardo', 1, '4', 'goggoogog', 'dddddddd', '2024-11-20 09:31:27'),
(122300000064, 123474, 'Danica Kassandra', 'Lepardo', 1, '1', 'EHHEHEHEHE', 'huhuhuhuhu', '2024-11-20 09:31:45'),
(122300000065, 123474, 'Danica Kassandra', 'Lepardo', 1, '4', 'kaboggg', 'FSFfsdddsdfsdfddddddddddddddddddsdfsgsdgdgdgdhsgbfsajkdfhjkfhdjkfbdsjdnfjkdnfdjfnsdjkfsdjkfbnsdjfkndsfjnsfjsnfjsdnfjksdfbndsjfbsdjfndsffdsjvndskjvndsfjdnfdjfndsfjkdsnvjsdnvsjdfnsdjfndsfjdsfjsdfsdfnsfksfasleifhaweoiftafklsdjf;leirupsefjsdlkvjsld;knfmweklnfklsvnsdmnvx,vkdfjkdjfkjfkjf', '2024-11-20 09:32:20'),
(122300000066, 123474, 'Danica Kassandra', 'Lepardo', 1, '5', 'sjxhjshdjsahdjashd', '11111111111211332143244234', '2024-11-20 09:34:27'),
(122300000067, 123474, 'Danica Kassandra', 'Lepardo', 1, '5', 'end the sem', 'please!!!!!!!!!', '2024-11-20 09:37:44'),
(122300000068, 123474, 'Danica Kassandra', 'Lepardo', 1, '2', 'ayaw q na', 'sdfsdfsdfsdf', '2024-11-20 09:38:04'),
(122300000069, 123474, 'Danica Kassandra', 'Lepardo', 1, '4', 'last oneee', 'haysttttt', '2024-11-20 09:39:07'),
(122300000070, 123474, 'Danica Kassandra', 'Lepardo', 1, '5', 'last one ULIT', 'HAYNAKO', '2024-11-20 09:39:32'),
(122300000071, 123474, 'Danica Kassandra', 'Lepardo', 1, '1', 'sssssssss', 'fsfgsdfdsfs', '2024-11-20 09:53:53'),
(122300000072, 123474, 'Danica Kassandra', 'Lepardo', 1, '5', 'sdsfdsfds', 'sdvdsdfs', '2024-11-20 09:54:10'),
(122300000073, 123474, 'Danica Kassandra', 'Lepardo', 1, '5', 'sssssssssssssssssss', 'aadasfdsaf', '2024-11-20 09:56:30'),
(122300000074, 123474, 'Danica Kassandra', 'Lepardo', 1, '3', 'dddsdsfsdfd', 'dsfsdfddddddddddd', '2024-11-20 09:56:41'),
(122300000075, 123474, 'Danica Kassandra', 'Lepardo', 1, '5', 'Great Fabrics', 'I really like this', '2024-11-20 10:14:23'),
(122300000078, 123470, 'Shaima', 'Mangadang', 1, '3', 'Shipped a little late than expected', '', '2024-11-21 11:05:51'),
(122300000079, 123470, 'Shaima', 'Mangadang', 1, '5', 'Wow!!!', 'The fabrics are very high quality!!', '2024-11-21 11:11:41'),
(122300000080, 123491, 'Juan', 'Dela Cruz', 1, '4', 'Late Shipping', 'Item was shipped a little late but great quality', '2024-11-21 11:14:07'),
(122300000114, 123513, 'Yzekiel', 'Cooper', 6, '5', 'nice', 'angas ng tela lods. will buy again', '2024-11-24 07:37:26'),
(122300000115, 123513, 'Yzekiel', 'Cooper', 3, '3', 'okay lang', 'ganda sana ng tela kayo yung name favorites song ng ex ko yan kaya 3 star muna ', '2024-11-24 07:38:36'),
(122300000116, 123513, 'Yzekiel', 'Cooper', 5, '5', 'naks', 'ganda po maam', '2024-11-24 15:10:29');

-- --------------------------------------------------------

--
-- Table structure for table `product_revenue`
--

CREATE TABLE `product_revenue` (
  `revenue_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `items_sold` int(11) NOT NULL,
  `total_revenue` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_revenue`
--

INSERT INTO `product_revenue` (`revenue_id`, `product_id`, `items_sold`, `total_revenue`) VALUES
(1, 1, 34, 4000.00),
(2, 2, 0, 0.00),
(3, 3, 5, 3000.00),
(4, 4, 37, 64400.00),
(5, 5, 2, 2000.00),
(6, 6, 32, 31200.00),
(7, 7, 0, 0.00),
(8, 8, 33, 19800.00),
(9, 9, 2, 900.00),
(10, 10, 30, 40500.00),
(11, 11, 32, 41400.00),
(12, 12, 30, 45000.00),
(13, 13, 31, 40950.00),
(14, 14, 31, 40950.00),
(15, 15, 30, 180000.00),
(16, 16, 60, 48000.00),
(17, 17, 30, 36000.00),
(18, 18, 0, 0.00),
(19, 19, 30, 36000.00),
(20, 20, 0, 0.00),
(21, 21, 30, 36000.00),
(22, 22, 30, 36000.00),
(23, 23, 32, 36800.00),
(24, 26, 2, 1100.00);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `week_start` date DEFAULT NULL,
  `week_end` date DEFAULT NULL,
  `monday` decimal(10,2) NOT NULL,
  `tuesday` decimal(10,2) NOT NULL,
  `wednesday` decimal(10,2) NOT NULL,
  `thursday` decimal(10,2) NOT NULL,
  `friday` decimal(10,2) NOT NULL,
  `saturday` decimal(10,2) NOT NULL,
  `sunday` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `week_start`, `week_end`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES
(10202411, NULL, NULL, 10000.00, 15365.00, 12365.00, 10689.00, 15365.00, 14896.00, 16000.00),
(10202416, '2024-11-25', '2024-12-01', 1550.00, 0.00, 0.00, 1800.00, 6300.00, 0.00, 72450.00);

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `cart_id` int(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`cart_id`, `product_id`, `product`, `customer_id`, `firstname`, `lastname`, `unit_price`, `quantity`, `color`, `total_price`) VALUES
(100011, 5, 'Wonderland Beaded Lace', 123507, 'Yzekiel', 'Cooper', 1000.00, 2, 'Royal Blue', 2000.00),
(100089, 7, 'Juno Corded Spanish Lace ', 123513, 'Yzekiel', 'Cooper', 350.00, 1, 'Aqua Blue', 350.00),
(100090, 16, 'Queendom Velvet Embroider ', 123513, 'Yzekiel', 'Cooper', 400.00, 1, 'Blue', 400.00);

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE `statistics` (
  `stats_id` int(11) NOT NULL,
  `total_sales` decimal(10,2) NOT NULL,
  `total_icnome` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statistics`
--

INSERT INTO `statistics` (`stats_id`, `total_sales`, `total_icnome`) VALUES
(98765, 150486.00, 1698583.00);

-- --------------------------------------------------------

--
-- Table structure for table `users_credentials`
--

CREATE TABLE `users_credentials` (
  `ID` int(6) NOT NULL,
  `FIRSTNAME` varchar(255) NOT NULL,
  `LASTNAME` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PASSWORD` varchar(15) NOT NULL,
  `BIRTHDATE` date NOT NULL,
  `GENDER` varchar(10) NOT NULL,
  `ADDRESS` varchar(255) NOT NULL,
  `SUBDIVISION` varchar(255) DEFAULT NULL,
  `BARANGAY` varchar(255) NOT NULL,
  `POSTAL` varchar(255) NOT NULL,
  `CITY` varchar(255) NOT NULL,
  `PLACE` varchar(255) NOT NULL,
  `PHONE` varchar(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `login_attempts` int(11) DEFAULT 0,
  `lockout_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_credentials`
--

INSERT INTO `users_credentials` (`ID`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `BIRTHDATE`, `GENDER`, `ADDRESS`, `SUBDIVISION`, `BARANGAY`, `POSTAL`, `CITY`, `PLACE`, `PHONE`, `date`, `login_attempts`, `lockout_time`) VALUES
(1, 'Sharleen ', 'Olaguir', 'shaolaguir@gmail.com', 'sharleenadmin', '2003-10-25', 'female', '11 Suha St.', 'Post Proper', 'Southside', '1200', 'Taguig', 'Metro Manila', '09989333165', '2024-12-05 04:39:51', 0, NULL),
(123470, 'Shaima', 'Mangadang', 'shaimamangadang@gmail.com', 'shaima123', '1987-10-25', 'Female', 'Manila', '', '', '', '', 'Luzon', '09874514531', '2024-11-25 15:34:46', 0, NULL),
(123474, 'Danica Kassandra', 'Lepardo', 'imdanicuhkasi@gmail.com', 'danicuh!23', '2003-06-12', 'Female', 'sa ayala malls davao', '', '', '', '', 'Mindanao', '09865745127', '2024-12-05 03:21:04', 3, '2024-12-05 04:24:04'),
(123475, 'la', 'gasmen', 'lrncndrw@gmail.com', 'lagasmen123', '2003-06-01', 'Male', 'Pasig', '', '', '', '', 'Metro Manila', '2147483647', '2024-12-04 17:28:23', 0, NULL),
(123476, 'xiao', 'lin', 'xiao@gmail.com', 'xiaoxiao123', '0005-02-10', 'Female', 'Sa genshin', '', '', '', '', '', '2147483647', '2024-11-25 15:34:46', 0, NULL),
(123482, 'Satoru', 'Gojo', 'gojo@gmail.com', 'gojojo12', '1989-07-12', 'male', 'jjk', '', '', '', '', '', '09123456789', '2024-11-25 15:34:46', 0, NULL),
(123484, 'Suguru', 'Geto', 'sugs@gmail.com ', 'sugurugeto', '2000-10-29', 'male', 'jjk', '', '', '', '', '', '09326545126', '2024-12-04 18:02:01', 3, '2024-12-04 19:05:01'),
(123486, 'Juan', 'Dela Cruz', 'juan123@gmai.com', 'juan123', '2001-02-10', 'female', 'MAkati', '', '', '', '', '', '12345678912', '2024-12-04 18:01:15', 0, NULL),
(123496, 'franz', 'mangao', 'franz123@gmail.com', 'qwertyu', '2024-11-08', 'male', 'Makati City', '', '', '', '', '', '0965234875', '2024-11-25 15:34:46', 0, NULL),
(123513, 'Yzekiel', 'Cooper', 'yzekeilcooper@gmail.com', 'yzekpogi!45', '2003-10-25', 'Male', '11 Pomelo St.', 'Panam ', 'Pinagsama', '1630', 'Taguig', 'Metro Manila', '09989331654', '2024-11-25 15:34:46', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `bulk_order_details`
--
ALTER TABLE `bulk_order_details`
  ADD PRIMARY KEY (`bulk_order_id`);

--
-- Indexes for table `bulk_order_items`
--
ALTER TABLE `bulk_order_items`
  ADD PRIMARY KEY (`bulk_order_items`);

--
-- Indexes for table `bulk_payment`
--
ALTER TABLE `bulk_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `bulk_shopping_cart`
--
ALTER TABLE `bulk_shopping_cart`
  ADD PRIMARY KEY (`bulk_cart_id`),
  ADD KEY `bulk_customer_id` (`customer_id`),
  ADD KEY `bulk_product_id` (`product_id`);

--
-- Indexes for table `cod_payment`
--
ALTER TABLE `cod_payment`
  ADD PRIMARY KEY (`cod_payment_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notif_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_num`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_items_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`color_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `product_id` (`product_id`),
  ADD KEY `userF` (`user_firstname`);

--
-- Indexes for table `product_revenue`
--
ALTER TABLE `product_revenue`
  ADD PRIMARY KEY (`revenue_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`stats_id`);

--
-- Indexes for table `users_credentials`
--
ALTER TABLE `users_credentials`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bulk_order_details`
--
ALTER TABLE `bulk_order_details`
  MODIFY `bulk_order_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50000050;

--
-- AUTO_INCREMENT for table `bulk_order_items`
--
ALTER TABLE `bulk_order_items`
  MODIFY `bulk_order_items` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `bulk_payment`
--
ALTER TABLE `bulk_payment`
  MODIFY `payment_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3212107;

--
-- AUTO_INCREMENT for table `bulk_shopping_cart`
--
ALTER TABLE `bulk_shopping_cart`
  MODIFY `bulk_cart_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120224;

--
-- AUTO_INCREMENT for table `cod_payment`
--
ALTER TABLE `cod_payment`
  MODIFY `cod_payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202413;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_num` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200089;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100098;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `post_id` bigint(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122300000117;

--
-- AUTO_INCREMENT for table `product_revenue`
--
ALTER TABLE `product_revenue`
  MODIFY `revenue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10202417;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100094;

--
-- AUTO_INCREMENT for table `statistics`
--
ALTER TABLE `statistics`
  MODIFY `stats_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98766;

--
-- AUTO_INCREMENT for table `users_credentials`
--
ALTER TABLE `users_credentials`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123515;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD CONSTRAINT `product_colors_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_revenue`
--
ALTER TABLE `product_revenue`
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
