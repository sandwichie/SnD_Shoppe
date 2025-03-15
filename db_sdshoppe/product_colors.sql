-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 03:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `product_colors`
--

CREATE TABLE `product_colors` (
  `color_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_name` varchar(50) NOT NULL,
  `product_pic` varchar(255) DEFAULT NULL,
  `yards` int(11) NOT NULL,
  `rolls` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_colors`
--

INSERT INTO `product_colors` (`color_id`, `product_id`, `color_name`, `product_pic`, `yards`, `rolls`) VALUES
(1, 1, 'Cyan', 'Assets\\inventory\\1 Enchanted-beaded\\Enchanted-beaded CYAN.JPG', 35, 0),
(2, 1, 'Red', 'Assets\\inventory\\1 Enchanted-beaded\\Enchanted-beaded RED.JPG', 0, 0),
(3, 1, 'Royal Blue', 'Assets\\inventory\\1 Enchanted-beaded P1000\\Enchanted-beaded ROYALBLUE.JPG', 23, 0),
(4, 1, 'White', 'Assets\\inventory\\1 Enchanted-beaded P1000\\Enchanted-beaded WHITE.JPG', 10, 0),
(5, 2, 'Blush Pink', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded BLUSHPINK.JPG', 20, 25),
(6, 2, 'Champagne', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded CHAMPAGNE.JPG', 40, 50),
(7, 2, 'Emerald Green', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded EMERALD GREEN(1).JPG', 45, 50),
(8, 2, 'Lavender', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded LAVENDER.JPG', 15, 50),
(9, 2, 'Red', 'Assets\\inventory\\2 Midnight-corded\\Midnight-corded RED.JPG', 80, 50),
(10, 3, 'Champagne', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar CHAMPAGNE.JPG', 35, 50),
(11, 3, 'Emerald Green', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar EMERALD GREEN.JPG', 60, 50),
(12, 3, 'Fuchsia Pink', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar FUCHSIA PINK.JPG', 12, 50),
(13, 3, 'Magenta', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar MAGENTA.JPG', 70, 50),
(14, 3, 'Red', 'Assets\\inventory\\3 Spark Fly-caviar P600\\Spark Fly-caviar RED.JPG', 50, 50),
(15, 4, 'Champagne', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded CHAMPAGNE.JPG', 50, 50),
(16, 4, 'Dark Green', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded DARKGREEN.JPG', 10, 50),
(17, 4, 'Pink-Champagne', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded PINK-CHAMPAGNE.JPG', 70, 50),
(18, 4, 'Pink', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded PINK.JPG', 23, 50),
(19, 4, 'Purple-Pink', 'Assets\\inventory\\4 Bejeweled-Beaded\\Bejeweled-beaded PURPLE-PINK.JPG', 12, 50),
(20, 5, 'Champagne', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace  CHAMPAGNE(1).JPG', 50, 50),
(21, 5, 'Royal Blue', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace ROYALBLUE(1).JPG', 10, 50),
(22, 5, 'Silver', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace SILVER.JPG', 80, 50),
(23, 5, 'White-Purple', 'Assets\\inventory\\5 wonderland beaded lace\\Wonderland-beaded lace WHITE-PURPLE.JPG', 100, 50),
(24, 6, 'Red', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush  RED.JPG', 120, 50),
(25, 6, 'Silver', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush SILVER.JPG', 15, 50),
(26, 6, 'Aqua Blue', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush AQUABLUE.JPG', 0, 50),
(27, 6, 'Champagne', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush CHAMPAGNE.JPG', 0, 50),
(28, 6, 'Emerald Green', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush EMERALD GREEN.JPG', 0, 50),
(29, 6, 'Fuchsia Pink', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush FUCHSIA PINK.JPG', 0, 10),
(30, 6, 'Green', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush GREEN.JPG', 0, 50),
(31, 6, 'Orange', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush ORANGE.JPG', 0, 50),
(32, 6, 'Pink', 'Assets\\inventory\\6 Epiphany candy crush\\Epiphany candy crush PINK.JPG', 0, 50),
(36, 7, 'Aqua Blue', 'Assets\\inventory\\7 Juno (CORDED) Spanish Lace 350\\Juno Spanish Lace AQUA BLUE.JPG', 0, 50),
(37, 7, 'Blush Pink', 'Assets\\inventory\\7 Juno (CORDED) Spanish Lace 350\\Juno Spanish Lace BLUSH PINK.JPG', 0, 50),
(38, 7, 'Orange', 'Assets\\inventory\\7 Juno (CORDED) Spanish Lace 350\\Juno Spanish Lace ORANGE.JPG', 0, 50),
(39, 7, 'White', 'Assets\\inventory\\7 Juno (CORDED) Spanish Lace 350\\Juno Spanish Lace WHITE.JPG', 0, 50),
(40, 8, 'Baby Blue', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace BABY BLUE.JPG', 0, 50),
(41, 8, 'Blue', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace BLUE.JPG', 0, 50),
(42, 8, 'Blush Pink', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace BLUSH PINK.JPG', 0, 50),
(43, 8, 'Emerald Green', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace EMERALD GREEN.JPG', 0, 50),
(44, 8, 'Green', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace GREEN.JPG', 0, 50),
(45, 8, 'Grey', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace GREY.JPG', 0, 50),
(46, 8, 'Yellow', 'Assets\\inventory\\8 Love Talk (CORDED) 3D Lace 600\\Love Talk 3D Lace YELLOW.JPG', 0, 50),
(47, 9, 'Baby Blue', 'Assets\\inventory\\9 Diva (CORDED) All Over Lace 450\\baby blue.JPG', 0, 50),
(48, 9, 'Gold', 'Assets\\inventory\\9 Diva (CORDED) All Over Lace 450\\gold.JPG', 0, 50),
(49, 9, 'Pink', 'Assets\\inventory\\9 Diva (CORDED) All Over Lace 450\\pink.JPG', 0, 50),
(50, 10, 'Blue', 'Assets\\inventory\\10 (CORDED) Embroider Lace All Over 450\\blue.JPG', 0, 50),
(51, 10, 'Baby Pink', 'Assets\\inventory\\10 (CORDED) Embroider Lace All Over 450\\pink.jpeg', 0, 50),
(52, 10, 'White', 'Assets\\inventory\\10 (CORDED) Embroider Lace All Over 450\\white.JPG', 0, 50),
(53, 11, 'Blue', 'Assets\\inventory\\11 Style Panel Lace 450\\blue.JPG', 0, 50),
(54, 11, 'Red', 'Assets\\inventory\\11 Style Panel Lace 450\\red.JPG', 0, 50),
(55, 11, 'White', 'Assets\\inventory\\11 Style Panel Lace 450\\white.JPG', 0, 50),
(56, 12, 'Dirty White', 'Assets\\inventory\\12 Wannabe (PANEL) Lace 500\\dirty white.JPG', 0, 50),
(57, 12, 'Khaki', 'Assets\\inventory\\12 Wannabe (PANEL) Lace 500\\khaki.JPG', 0, 50),
(58, 12, 'Yellow', 'Assets\\inventory\\12 Wannabe (PANEL) Lace 500\\yellow.JPG', 0, 50),
(59, 13, 'Red', 'Assets\\inventory\\13 Little Freak (PANEL) All Over Lace 450\\red.JPG', 0, 50),
(60, 13, 'Lilac', 'Assets\\inventory\\13 Little Freak (PANEL) All Over Lace 450\\violet.JPG', 0, 50),
(61, 13, 'White', 'Assets\\inventory\\13 Little Freak (PANEL) All Over Lace 450\\white.JPG', 0, 50),
(62, 14, 'Cyan', 'Assets\\inventory\\14 Glam Panel Lace 450\\cyan.JPG', 0, 50),
(63, 14, 'Silver', 'Assets\\inventory\\14 Glam Panel Lace 450\\silver.JPG', 0, 50),
(64, 14, 'White', 'Assets\\inventory\\14 Glam Panel Lace 450\\white.JPG', 0, 50),
(65, 15, 'Blue', 'Assets\\inventory\\15 Primadona (BEADED) Heavy Beaded Lace 2000\\blue.JPG', 0, 50),
(66, 15, 'Green', 'Assets\\inventory\\15 Primadona (BEADED) Heavy Beaded Lace 2000\\green.JPG', 0, 50),
(67, 15, 'Pink', 'Assets\\inventory\\15 Primadona (BEADED) Heavy Beaded Lace 2000\\pink.JPG', 0, 50),
(68, 16, 'Blue', 'Assets\\inventory\\16 Queendom Velvet Embroider 400\\a.blue.JPG', 0, 50),
(69, 16, 'Yellow', 'Assets\\inventory\\16 Queendom Velvet Embroider 400\\a.yellow.JPG', 0, 50),
(70, 17, 'Blue Green', 'Assets\\inventory\\17 Campfire Velvet Embroider\\blue green.JPG', 0, 50),
(71, 17, 'Maroon', 'Assets\\inventory\\17 Campfire Velvet Embroider\\maroon.JPG', 0, 50),
(72, 18, 'White', 'Assets\\inventory\\18 Caramel Velvet Embroiderer\\white.JPG', 0, 50),
(73, 19, 'Black', 'Assets\\inventory\\19 Sour Grapes Velvet Embroider\\black.JPG', 0, 50),
(74, 20, 'Violet', 'Assets\\inventory\\20 Kindom Velvet Embroider\\violet.JPG', 0, 50),
(75, 21, 'Red', 'Assets\\inventory\\21 Circles Velvet Embroider\\red.JPG', 0, 50),
(76, 22, 'White', 'Assets\\inventory\\22 Coffee Velvet Embroider\\white.JPG', 0, 50),
(77, 23, 'White', 'Assets\\inventory\\23 Winter Velvet Embroider\\white.JPG', 0, 50),
(83, 26, 'gren', 'new_products\\colors\\674ebaf437b73_Shrek_(character).png', 0, 50),
(85, 26, 'choco', 'new_products\\colors\\674ebb2898d4d_lacherpatisserie-petitgateaux-01.jpg', 0, 50),
(89, 26, 'penk', 'new_products\\colors\\674ecd7b14f7e_maxresdefault.jpg', 0, 50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`color_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

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
