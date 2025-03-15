-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 03:19 AM
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
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adminID`, `name`, `password`) VALUES
(1, 'sharleen', 'sharleenadmin');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_num` int(15) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `delivery_option` varchar(50) NOT NULL,
  `payment` int(15) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` enum('To Pay','To Ship','To Receive','Completed','Cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_num`, `customer_id`, `sub_total`, `total_price`, `delivery_option`, `payment`, `order_date`, `Status`) VALUES
(200062, 1, 1550.00, 1594.00, 'lbc', 100066, '2024-11-22 14:08:46', 'Completed'),
(200063, 1, 6000.00, 6060.00, 'ninja-van', 100067, '2024-11-23 06:41:04', 'To Receive'),
(200064, 123474, 10000.00, 10000.00, 'ninja-van', 100068, '2024-11-23 08:40:26', 'To Pay');

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
(24, '200064', 19, 'gumamela', 'Others', 1);

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
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `customer_id`, `customer_name`, `number`, `acc_name`, `method`, `ref_num`, `proof`, `payment_date`) VALUES
(100001, 1, 'Sharleen Olaguir', '09989333165', 'Sharleen Olaguir', 'Gcash', '4634873156753', 'edfdsfds', '2024-11-21 15:51:41'),
(100066, 1, 'Sharleen Olaguir', '09989333165', 'shao', 'Gcash', '24135486', 'uploads/6740906ed0e49_410945053_1072793487371854_6481595374348650915_n.png', '2024-11-22 14:08:46'),
(100067, 1, 'Sharleen Olaguir', '09989333165', 'shao', 'Maya', '24135486', 'uploads/674179005ec1f_heneh.png', '2024-11-23 06:41:04'),
(100068, 123474, 'Danica Kassandra Lepardo', '09989333165', 'chao', 'Maya', '24135486', 'uploads/674194fad4e29_III-CINS_POSTER.jpg', '2024-11-23 08:40:26');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` enum('beaded lace','corded lace','caviar','candy crush') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 100,
  `Status` varchar(255) NOT NULL,
  `product_image` varchar(100) DEFAULT NULL,
  `product_descript` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category`, `price`, `quantity`, `Status`, `product_image`, `product_descript`, `date`) VALUES
(1, 'Enchanted-Beaded', 'beaded lace', 1000.00, 50, 'In Stock', 'Assets\\inventory\\Enchanted-beaded CYAN.JPG', '', '2024-11-24 11:47:41'),
(2, 'Midnight-Corded', 'corded lace', 350.00, 100, 'In Stock', 'Assets\\inventory\\Midnight-corded.JPG', '', '2024-11-24 11:47:41'),
(3, 'Spark Fly-Caviar', 'caviar', 600.00, 80, 'In Stock', 'Assets\\inventory\\Spark Fly-caviar.JPG', '', '2024-11-24 11:47:41'),
(4, 'Bejeweled-Beaded', 'beaded lace', 1200.00, 40, 'In Stock', 'Assets\\inventory\\Bejeweled-beaded.JPG', '', '2024-11-24 11:47:41'),
(5, 'Wonderland Beaded Lace', 'beaded lace', 1000.00, 60, 'In Stock', 'Assets\\inventory\\Wonderland beaded lace.JPG', '', '2024-11-24 11:47:41'),
(6, 'Epiphany Candy Crush', 'candy crush', 350.00, 120, 'In Stock', 'Assets\\inventory\\Epiphany candy crush.JPG', '', '2024-11-24 11:47:41'),
(7, 'Daylight-Caviar\r\n', 'caviar', 200.00, 100, 'In Stock', 'Assets\\inventory\\daylight-caviar.jpg', '', '2024-11-24 11:47:41'),
(8, 'Style Corded Lace', 'corded lace', 320.00, 100, 'In Stock', 'Assets\\inventory\\style-corded.jpeg', '', '2024-11-24 11:47:41'),
(9, 'Timeless Candy Crush', 'candy crush', 570.00, 100, 'In Stock', 'Assets\\inventory\\timeless-candy.jpg', '', '2024-11-24 11:47:41'),
(10, 'Forever Winter Caviar', 'caviar', 380.00, 100, 'In Stock', 'Assets\\inventory\\ForeverWin-Caviar.jpg', '', '2024-11-24 11:47:41'),
(11, 'Don Quixote Beaded Lace', 'beaded lace', 500.00, 80, 'In Stock', 'Assets\\inventory\\donqui-beaded.jpg', '', '2024-11-24 11:47:41'),
(12, 'Flower Candy Crush', 'candy crush', 400.00, 100, 'In Stock', 'Assets\\inventory\\flower-candyc.jpg', '', '2024-11-24 11:47:41'),
(13, 'Snap Shoot Caviar', 'caviar', 250.00, 90, 'In Stock', 'Assets\\inventory\\Snapshoot-caviar.jpg', '', '2024-11-24 11:47:41'),
(14, 'Teenage Corded Lace', 'corded lace', 630.00, 120, 'In Stock', 'Assets\\inventory\\teenage-corded.jpg', '', '2024-11-24 11:47:41'),
(15, 'Yawn Candy Crush', 'candy crush', 840.00, 130, 'In Stock', 'Assets\\inventory\\yawn-candyc.jpg', '', '2024-11-24 11:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `product_colors`
--

CREATE TABLE `product_colors` (
  `color_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_name` varchar(50) NOT NULL,
  `product_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_colors`
--

INSERT INTO `product_colors` (`color_id`, `product_id`, `color_name`, `product_pic`) VALUES
(1, 1, 'Cyan', 'Assets\\inventory\\1 Enchanted-beaded P1000\\Enchanted-beaded CYAN.JPG'),
(2, 1, 'Red', 'Assets\\inventory\\1 Enchanted-beaded P1000\\Enchanted-beaded RED.JPG'),
(3, 1, 'Royal Blue', 'Assets\\inventory\\1 Enchanted-beaded P1000\\Enchanted-beaded ROYALBLUE.JPG'),
(4, 1, 'White', 'Assets\\inventory\\1 Enchanted-beaded P1000\\Enchanted-beaded WHITE.JPG'),
(5, 2, 'Blush Pink', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded BLUSHPINK.JPG'),
(6, 2, 'Champagne', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded CHAMPAGNE.JPG'),
(7, 2, 'Emerald Green', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded EMERALD GREEN(1).JPG'),
(8, 2, 'Lavender', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded LAVENDER.JPG'),
(9, 2, 'Red', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded RED.JPG'),
(10, 3, 'Champagne', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar CHAMPAGNE.JPG'),
(11, 3, 'Emerald Green', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar EMERALD GREEN.JPG'),
(12, 3, 'Fuchsia Pink', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar FUCHSIA PINK.JPG'),
(13, 3, 'Magenta', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar MAGENTA.JPG'),
(14, 3, 'Red', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar RED.JPG'),
(15, 4, 'Champagne', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded CHAMPAGNE.JPG'),
(16, 4, 'Dark Green', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded DARKGREEN.JPG'),
(17, 4, 'Pink-Champagne', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded PINK-CHAMPAGNE.JPG'),
(18, 4, 'Pink', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded PINK.JPG'),
(19, 4, 'Purple-Pink', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded PURPLE-PINK.JPG'),
(20, 5, 'Champagne', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace  CHAMPAGNE(1).JPG'),
(21, 5, 'Royal Blue', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace ROYALBLUE(1).JPG'),
(22, 5, 'Silver', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace SILVER.JPG'),
(23, 5, 'White-Purple', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace WHITE-PURPLE.JPG'),
(24, 6, 'Red', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush  RED.JPG'),
(25, 6, 'Silver', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush SILVER.JPG'),
(26, 6, 'Aqua Blue', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush AQUABLUE.JPG'),
(27, 6, 'Champagne', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush CHAMPAGNE.JPG'),
(28, 6, 'Emerald Green', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush EMERALD GREEN.JPG'),
(29, 6, 'Fuchsia Pink', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush FUCHSIA PINK.JPG'),
(30, 6, 'Green', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush GREEN.JPG'),
(31, 6, 'Orange', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush ORANGE.JPG'),
(32, 6, 'Pink', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush PINK.JPG');

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
(100001, 1, 'Enchanted-Beaded', 123470, 'Shaima', 'Mangadang', 1000.00, 3, 'Red', 3000.00),
(100007, 4, 'Bejeweled-Beaded', 123470, 'Shaima', 'Mangadang', 1200.00, 1, 'Pink', 1200.00),
(100008, 3, 'Spark Fly-Caviar', 123470, 'Shaima', 'Mangadang', 600.00, 2, 'Emerald Green', 1200.00),
(100011, 5, 'Wonderland Beaded Lace', 123507, 'Yzekiel', 'Cooper', 1000.00, 2, 'Royal Blue', 2000.00),
(100018, 5, 'Wonderland Beaded Lace', 123513, 'Yzekiel', 'Cooper', 1000.00, 1, 'Royal Blue', 1000.00),
(100019, 4, 'Bejeweled-Beaded', 123513, 'Yzekiel', 'Cooper', 1200.00, 1, 'Purple-Pink', 1200.00);

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
  `PHONE` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_credentials`
--

INSERT INTO `users_credentials` (`ID`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `BIRTHDATE`, `GENDER`, `ADDRESS`, `SUBDIVISION`, `BARANGAY`, `POSTAL`, `CITY`, `PLACE`, `PHONE`) VALUES
(1, 'Sharleen', 'Olaguir', 'shaolaguir@gmail.com', 'sharleenadmin', '2003-10-25', 'female', '11 Suha St.', 'Post Proper', 'Southside', '1200', 'Taguig', 'Metro Manila', '09989333165'),
(123470, 'Shaima', 'Mangadang', 'shaimamangadang@gmail.com', 'shaima123', '1987-10-25', 'Female', 'Manila', '', '', '', '', 'Luzon', '09874514531'),
(123474, 'Danica Kassandra', 'Lepardo', 'imdanicuhkasi@gmail.com', 'danicuh!23', '2003-06-12', 'Female', 'sa ayala malls davao', '', '', '', '', 'Mindanao', '09865745127'),
(123475, 'la', 'gasmen', 'lagasmen@gmail.com', 'lagasmen123', '2003-06-01', 'Male', 'Pasig', '', '', '', '', 'Metro Manila', '2147483647'),
(123476, 'xiao', 'lin', 'xiao@gmail.com', 'xiaoxiao123', '0005-02-10', 'Female', 'Sa genshin', '', '', '', '', '', '2147483647'),
(123482, 'Satoru', 'Gojo', 'gojo@gmail.com', 'gojojo12', '1989-07-12', 'male', 'jjk', '', '', '', '', '', '09123456789'),
(123484, 'Suguru', 'Geto', 'sugs@gmail.com ', 'sugurugeto', '2000-10-29', 'male', 'jjk', '', '', '', '', '', '09326545126'),
(123486, 'Juan', 'Dela Cruz', 'juan123@gmai.com', 'juan123', '2001-02-10', 'female', 'MAkati', '', '', '', '', '', '12345678912'),
(123496, 'franz', 'mangao', 'franz123@gmail.com', 'qwertyu', '2024-11-08', 'male', 'Makati City', '', '', '', '', '', '0965234875'),
(123513, 'Yzekiel', 'Cooper', 'yzekeilcooper@gmail.com', 'yzekpogi!45', '2003-10-25', 'Male', '11 Pomelo St.', 'Panam ', 'Pinagsama', '1630', 'Taguig', 'Metro Manila', '09989331654');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adminID`);

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
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_id`);

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
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_num` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200065;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100069;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `post_id` bigint(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122300000117;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100050;

--
-- AUTO_INCREMENT for table `users_credentials`
--
ALTER TABLE `users_credentials`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123514;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD CONSTRAINT `product_colors_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
