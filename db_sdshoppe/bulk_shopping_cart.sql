-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 12:34 PM
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
(120183, 2, 'Midnight-Corded', 123514, 'Meldridge', 'Pingco', 350.00, NULL, NULL, '', '', '0000-00-00', 20000.00, '', 0.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulk_shopping_cart`
--
ALTER TABLE `bulk_shopping_cart`
  ADD PRIMARY KEY (`bulk_cart_id`),
  ADD KEY `bulk_customer_id` (`customer_id`),
  ADD KEY `bulk_product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulk_shopping_cart`
--
ALTER TABLE `bulk_shopping_cart`
  MODIFY `bulk_cart_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120184;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bulk_shopping_cart`
--
ALTER TABLE `bulk_shopping_cart`
  ADD CONSTRAINT `bulk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `users_credentials` (`ID`),
  ADD CONSTRAINT `bulk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
