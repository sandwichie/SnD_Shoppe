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
(50000024, 123514, '2024-11-29 11:17:09', 0.00, 'Contact Seller', '2024-12-01', 11221122, 'To Pay'),
(50000025, 123514, '2024-11-29 11:20:07', 351900.00, 'Pick Up', '2024-12-03', 11221122, 'To Pay'),
(50000026, 123514, '2024-11-29 11:22:57', 315000.00, 'Contact Seller', '2024-12-01', 3212103, 'To Pay');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulk_order_details`
--
ALTER TABLE `bulk_order_details`
  ADD PRIMARY KEY (`bulk_order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulk_order_details`
--
ALTER TABLE `bulk_order_details`
  MODIFY `bulk_order_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50000027;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
