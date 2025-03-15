-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 06:13 AM
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
-- Database: `dk_labacts`
--

-- --------------------------------------------------------

--
-- Table structure for table `sample`
--

CREATE TABLE `tb_lab2` (
  `ID` int(11) NOT NULL,
  `LastName` varchar(40) DEFAULT NULL,
  `FirstName` varchar(40) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `City` varchar(30) DEFAULT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sample`
--

INSERT INTO `tb_lab2` (`ID`, `LastName`, `FirstName`, `Age`, `City`) VALUES
(1, 'Cervantes', 'Ellaine', 32, 'Makati'),
(2, 'Cruz', 'Catherine', 22, 'Makati'),
(3, 'Magno', 'Rafael', 40, 'Makati'),
(4, 'Mardrigral', 'Gerald', 20, 'Mandaluyong'),
(5, 'Fernandez', 'Hernald', 51, 'Mandaluyong'),
(6, 'Rosas', 'Kate', 18, 'Mandaluyong'),
(7, 'Juancho', 'Antonio', 21, 'Pasig'),
(8, 'Jimenez', 'Hazzel', 33, 'Pasig'),
(9, 'Martinez', 'Leo', 27, 'Pasig'),
(10, 'Mendez', 'Susan', 38, 'Pasig'),
(11, 'Santiago', 'Diego', 38, 'Pateros'),
(12, 'George', 'Leonardo', 41, 'Pateros'),
(13, 'Fernando', 'Cloe', 22, 'Pateros'),
(14, 'Constance', 'Bridgett', 22, 'Caloocan'),
(15, 'Damaris', 'Charlotte', 56, 'Caloocan'),
(16, 'Dominguez', 'Emerald', 65, 'Caloocan'),
(17, 'Green', 'Harper', 47, 'Caloocan'),
(18, 'Amaro', 'Eduardo', 44, 'Caloocan'),
(19, 'Amaro', 'Abu', 22, 'Pasay'),
(20, 'Ines', 'Ella', 32, 'Pasay'),
(21, 'Cervantes', 'Letis', 45, 'Pasay'),
(22, 'Anaise', 'Astrid', 47, 'Pasay'),
(23, 'De Generes', 'Adelberee', 32, 'Pasay'),
(24, 'Arceles', 'Melissando', 30, 'Pasay'),
(25, 'Elorde', 'Yvette', 23, 'Makati');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sample`
--
ALTER TABLE `tb_lab2`
  ADD PRIMARY KEY (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
