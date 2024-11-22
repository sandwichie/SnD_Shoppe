-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 06:38 PM
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
(122300000080, 123491, 'Juan', 'Dela Cruz', 1, '4', 'Late Shipping', 'Item was shipped a little late but great quality', '2024-11-21 11:14:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `product_id` (`product_id`),
  ADD KEY `userF` (`user_firstname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `post_id` bigint(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122300000113;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD CONSTRAINT `prodRating` FOREIGN KEY (`user_id`) REFERENCES `users_credentials` (`ID`),
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `product_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_credentials` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
