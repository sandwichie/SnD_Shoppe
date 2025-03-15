-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 12:35 PM
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
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bulk_payment`
--

INSERT INTO `bulk_payment` (`payment_id`, `customer_id`, `customer_name`, `number`, `acc_name`, `method`, `ref_num`, `proof`, `payment_date`) VALUES
(3212102, 123514, 'Meldridge Pingco', 2147483647, 'dani', 'GCash', 'fgdgsdgfe2343ref', 'uploads/67499e8f59937_70a92c5e-cf1e-49f6-940e-035a409a06a1.jpg', '2024-11-29 10:59:27'),
(3212103, 123514, 'Meldridge Pingco', 2147483647, 'Meldridge', 'GCash', 'cefdfdsfdsfd', 'uploads/6749a411b9897_70a92c5e-cf1e-49f6-940e-035a409a06a1.jpg', '2024-11-29 11:22:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulk_payment`
--
ALTER TABLE `bulk_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulk_payment`
--
ALTER TABLE `bulk_payment`
  MODIFY `payment_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3212104;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
