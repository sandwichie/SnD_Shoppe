-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 02:49 PM
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
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `roll_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category`, `price`, `quantity`, `Status`, `product_image`, `product_descript`, `date`, `roll_price`) VALUES
(1, 'Enchanted-Beaded', 'beaded lace', 1000.00, 50, 'In Stock', 'Assets\\inventory\\Enchanted-beaded CYAN.JPG', 'hi', '2024-11-26 13:49:01', 30000.00),
(2, 'Midnight-Corded', 'corded lace', 350.00, 100, 'In Stock', 'Assets\\inventory\\Midnight-corded.JPG', '', '2024-11-25 05:56:14', 20000.00),
(3, 'Spark Fly-Caviar', 'caviar', 600.00, 80, 'In Stock', 'Assets\\inventory\\Spark Fly-caviar.JPG', '', '2024-11-25 06:01:36', 30000.00),
(4, 'Bejeweled-Beaded', 'beaded lace', 1200.00, 40, 'In Stock', 'Assets\\inventory\\Bejeweled-beaded.JPG', '', '2024-11-25 05:56:21', 20000.00),
(5, 'Wonderland Beaded Lace', 'beaded lace', 1000.00, 60, 'In Stock', 'Assets\\inventory\\Wonderland beaded lace.JPG', '', '2024-11-25 06:01:32', 30000.00),
(6, 'Epiphany Candy Crush', 'candy crush', 350.00, 120, 'In Stock', 'Assets\\inventory\\Epiphany candy crush.JPG', '', '2024-11-25 05:59:46', 20000.00),
(7, 'Daylight-Caviar\r\n', 'caviar', 200.00, 100, 'In Stock', 'Assets\\inventory\\daylight-caviar.jpg', '', '2024-11-25 06:01:29', 30000.00),
(8, 'Style Corded Lace', 'corded lace', 320.00, 100, 'In Stock', 'Assets\\inventory\\style-corded.jpeg', '', '2024-11-25 06:00:51', 20000.00),
(9, 'Timeless Candy Crush', 'candy crush', 570.00, 100, 'In Stock', 'Assets\\inventory\\timeless-candy.jpg', '', '2024-11-25 06:01:26', 30000.00),
(10, 'Forever Winter Caviar', 'caviar', 380.00, 100, 'In Stock', 'Assets\\inventory\\ForeverWin-Caviar.jpg', '', '2024-11-25 06:00:58', 20000.00),
(11, 'Don Quixote Beaded Lace', 'beaded lace', 500.00, 80, 'In Stock', 'Assets\\inventory\\donqui-beaded.jpg', '', '2024-11-25 06:01:22', 30000.00),
(12, 'Flower Candy Crush', 'candy crush', 400.00, 100, 'In Stock', 'Assets\\inventory\\flower-candyc.jpg', '', '2024-11-25 06:01:02', 20000.00),
(13, 'Snap Shoot Caviar', 'caviar', 250.00, 90, 'In Stock', 'Assets\\inventory\\Snapshoot-caviar.jpg', '', '2024-11-25 06:01:18', 30000.00),
(14, 'Teenage Corded Lace', 'corded lace', 630.00, 120, 'In Stock', 'Assets\\inventory\\teenage-corded.jpg', '', '2024-11-25 06:01:07', 20000.00),
(15, 'Yawn Candy Crush', 'candy crush', 840.00, 130, 'In Stock', 'Assets\\inventory\\yawn-candyc.jpg', '', '2024-11-25 06:01:13', 30000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
