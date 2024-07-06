-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2024 at 07:19 PM
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
-- Database: `homeproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `flats`
--

CREATE TABLE `flats` (
  `f_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `flat_num` varchar(10) NOT NULL,
  `beds` int(11) NOT NULL,
  `baths` int(11) NOT NULL,
  `sqft` int(11) NOT NULL,
  `floor` int(11) NOT NULL,
  `additional_info` varchar(200) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'Vacant',
  `rent_amount` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flats`
--

INSERT INTO `flats` (`f_id`, `p_id`, `flat_num`, `beds`, `baths`, `sqft`, `floor`, `additional_info`, `status`, `rent_amount`, `image_path`) VALUES
(82, 74, '1c', 4, 3, 1200, 1, 'akjfakugd', 'Occupied', 50000, '/uploads/390231947.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `flat_images`
--

CREATE TABLE `flat_images` (
  `image_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `a_image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `m_id` int(11) NOT NULL,
  `o_username` varchar(255) NOT NULL,
  `t_username` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `maintenance_desc` varchar(255) NOT NULL,
  `f_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `rental_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_month` text NOT NULL,
  `payment_year` text NOT NULL,
  `paid_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `rental_id`, `amount`, `payment_month`, `payment_year`, `paid_date`) VALUES
(25, 39, 50000.00, '08', '2024', '0000-00-00'),
(26, 39, 50000.00, '06', '2024', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `p_id` int(11) NOT NULL,
  `o_username` varchar(20) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `location_a` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `lift_status` varchar(2) NOT NULL,
  `total_flats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`p_id`, `o_username`, `p_name`, `location_a`, `address`, `lift_status`, `total_flats`) VALUES
(48, 'ashik', 'p-4', 'Mirpur', 'House Building, Mirpur', '1', 0),
(49, 'ashik', 'asdasd', 'Dhanmondi', 'H#113,Gulshan,Dhaka', '1', 0),
(74, 'Asif', 'Asif Villa', 'Dhanmondi', 'asfafad', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `rental_id` int(11) NOT NULL,
  `f_id` int(11) DEFAULT NULL,
  `t_username` varchar(255) DEFAULT NULL,
  `st_date` date DEFAULT NULL,
  `rent_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`rental_id`, `f_id`, `t_username`, `st_date`, `rent_amount`, `status`) VALUES
(39, 82, 'sazzad42', '2024-06-26', 50000.00, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `rent_requests`
--

CREATE TABLE `rent_requests` (
  `request_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `t_username` varchar(255) NOT NULL,
  `o_username` varchar(255) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `st_date` date NOT NULL,
  `message` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(14) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` int(14) NOT NULL,
  `address` varchar(100) NOT NULL,
  `o_flag` int(11) NOT NULL DEFAULT 0,
  `p_enlisted` int(12) NOT NULL,
  `verification_code` varchar(32) NOT NULL,
  `email_verified` varchar(10) NOT NULL DEFAULT 'Unverified',
  `t_flag` int(11) NOT NULL DEFAULT 0,
  `tenant_f_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `pass`, `name`, `email`, `phone`, `address`, `o_flag`, `p_enlisted`, `verification_code`, `email_verified`, `t_flag`, `tenant_f_id`) VALUES
('ashik', '1234', 'Mukitur Rahman', 'tafsir@gmail.c', 1680544555, 'House Building, Uttara', 1, 2, '', 'Unverified', 0, NULL),
('Asif', '1234', 'Asif', 'ASfasfasf@gmail.com', 1680552240, 'asdasf', 1, 1, '', 'Unverified', 0, NULL),
('ismail', '1234', 'Ismail Shikder', 'ismailnotes45@gmail.com', 1312222922, 'Dhaka', 1, 0, '', 'Unverified', 0, NULL),
('montasir', '1234', 'Montasir Abd', 'monta@gmail.com', 1312222922, 'Dhaka', 1, 0, '', 'Unverified', 1, NULL),
('neketa', '1234', 'Maisha Zarin', 'maishazarin@gmail.com', 1312222922, 'kallyanpur', 1, 3, '', 'Unverified', 1, NULL),
('neketa444', '1234', 'Ismail Shikder', 'ismail@gmail.com', 1680544555, 'House Building, Uttara', 0, 0, '', 'Unverified', 0, NULL),
('sazzad42', '1234', 'Sazzad Hossain', 'shadshanto@gmail.com', 1680544555, 'Dhanmondi, Dhaka', 1, 2, '', 'Unverified', 1, 82),
('shihab', '1234', 'Sohaib', 'mz@gmail.com', 1312224552, 'Dhanmondi, Dhaka', 0, 0, '', 'Unverified', 1, NULL),
('tafsir', '1234', 'Tafsir Faiyaz', 'tt@gmail.com', 1670445530, 'Dhaka', 0, 0, '', 'Unverified', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flats`
--
ALTER TABLE `flats`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `flat_images`
--
ALTER TABLE `flat_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `f_id` (`f_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `o_username` (`o_username`),
  ADD KEY `t_username` (`t_username`),
  ADD KEY `fk_maintenance_f_id` (`f_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payments_ibfk_1` (`rental_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `user_id` (`o_username`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `rentals_ibfk_1` (`f_id`),
  ADD KEY `rentals_ibfk_2` (`t_username`);

--
-- Indexes for table `rent_requests`
--
ALTER TABLE `rent_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `rent_requests_ibfk_1` (`f_id`),
  ADD KEY `rent_requests_ibfk_2` (`t_username`),
  ADD KEY `rent_requests_ibfk_3` (`o_username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `fk_users_tenant_f_id` (`tenant_f_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flats`
--
ALTER TABLE `flats`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `flat_images`
--
ALTER TABLE `flat_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `rent_requests`
--
ALTER TABLE `rent_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flats`
--
ALTER TABLE `flats`
  ADD CONSTRAINT `p_id` FOREIGN KEY (`p_id`) REFERENCES `properties` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flat_images`
--
ALTER TABLE `flat_images`
  ADD CONSTRAINT `f_id` FOREIGN KEY (`f_id`) REFERENCES `flats` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `fk_maintenance_f_id` FOREIGN KEY (`f_id`) REFERENCES `flats` (`f_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `o_username` FOREIGN KEY (`o_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_username` FOREIGN KEY (`t_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`rental_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`o_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`f_id`) REFERENCES `flats` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`t_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rent_requests`
--
ALTER TABLE `rent_requests`
  ADD CONSTRAINT `rent_requests_ibfk_1` FOREIGN KEY (`f_id`) REFERENCES `flats` (`f_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rent_requests_ibfk_2` FOREIGN KEY (`t_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rent_requests_ibfk_3` FOREIGN KEY (`o_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_tenant_f_id` FOREIGN KEY (`tenant_f_id`) REFERENCES `flats` (`f_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
