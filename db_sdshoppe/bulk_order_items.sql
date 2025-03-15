-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 09:23 AM
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
(36, 50000025, 6, 'Epiphany Candy Crush', 'Fuchsia Pink', 37, 10, 0.00),
(37, 50000026, 4, 'Bejeweled-Beaded', 'Pink-Champagne', 45, 0, 0.00),
(38, 50000026, 3, 'Spark Fly-Caviar', 'Fuchsia Pink', 35, 0, 0.00),
(39, 50000026, 3, 'Spark Fly-Caviar', 'Magenta', 0, 8, 0.00),
(40, 50000027, 2, 'Midnight-Corded', 'Lavender', 34, 2, 0.00),
(41, 50000028, 4, 'Bejeweled-Beaded', 'Dark Green', 33, 4, 0.00),
(42, 50000028, 1, 'Enchanted-Beaded', 'Royal Blue', 40, 0, 0.00),
(43, 50000029, 1, 'Enchanted-Beaded', 'Red', 32, 3, 122000.00),
(44, 50000029, 2, 'Midnight-Corded', 'Blush Pink', 0, 3, 60000.00),
(45, 50000030, 4, 'Bejeweled-Beaded', 'Pink-Champagne', 34, 4, 120800.00),
(46, 50000030, 3, 'Spark Fly-Caviar', 'Magenta', 0, 4, 120000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulk_order_items`
--
ALTER TABLE `bulk_order_items`
  ADD PRIMARY KEY (`bulk_order_items`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulk_order_items`
--
ALTER TABLE `bulk_order_items`
  MODIFY `bulk_order_items` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
