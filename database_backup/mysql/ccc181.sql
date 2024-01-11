-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2022 at 10:37 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccc181`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `user_type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`id`, `first_name`, `last_name`, `username`, `password`, `user_type`, `status`, `date`) VALUES
(1, 'Raymart', 'Paraiso', 'admin1', 'admin1', 'Owner', 'yes', '2022-10-14 00:00:00'),
(2, 'Jonaem', 'Azis', 'admin2', 'admin2', 'Staff', 'yes', '2022-10-14 00:00:00'),
(3, 'Faheem', 'Azis', 'admin3', 'admin3', 'Staff', 'yes', '2022-10-14 00:00:00'),
(163, 'hjhg', 'hgj', 'ahgjmin1', 'admin1hjg', 'staff', 'yes', '2022-12-04 12:46:56');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `contact_no`) VALUES
(59, 'lebron', 'bryant', '09876543221'),
(60, 'Kobe', 'James', '09876543221'),
(61, 'Kawhi', 'Curry', '09123345678'),
(62, 'Michael', 'Mcgregor', '09876543221'),
(63, 'Faheem', 'Walaybuot', '09876543221'),
(64, 'Jonaem', 'Talopusta', '12345678901');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `ex_date` datetime DEFAULT current_timestamp(),
  `ex_name` varchar(50) DEFAULT NULL,
  `ex_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `ex_date`, `ex_name`, `ex_amount`) VALUES
(29, '2022-11-19 00:00:00', 'coke', 200),
(30, '2022-11-17 00:00:00', 'sprite', 100),
(31, '2022-11-09 00:00:00', 'royal', 150),
(32, '2022-11-02 00:00:00', 'balde', 75),
(34, '2022-10-12 00:00:00', 'sabon', 109),
(35, '2022-11-03 00:00:00', 'bbq', 6),
(36, '2022-06-08 00:00:00', 'Detergent', 109),
(37, '2022-01-22 00:00:00', 'royal mismo', 90),
(39, '2022-03-11 00:00:00', 'tawas', 300),
(40, '2022-04-20 00:00:00', 'valorant bundle', 2500),
(41, '2022-05-13 00:00:00', 'laptop', 3000),
(42, '2022-07-12 00:00:00', 'ice water', 384),
(43, '2022-08-23 00:00:00', 'welkin genshin', 250),
(44, '2022-09-09 00:00:00', 'bootleg jordans', 450),
(50, '2022-11-29 10:27:00', 'lastiko', 130),
(51, '2022-02-14 17:12:01', 'downyy', 300),
(52, '2022-11-30 20:11:00', 'sud.an', 25),
(55, '2022-12-01 07:47:00', 'pamahaw', 15),
(56, '2022-12-01 07:55:00', 'gatas na milk', 25);

-- --------------------------------------------------------

--
-- Table structure for table `laundry_type_services`
--

CREATE TABLE `laundry_type_services` (
  `laundry_id` int(11) NOT NULL,
  `service_type` varchar(50) DEFAULT NULL,
  `laundry_type` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laundry_type_services`
--

INSERT INTO `laundry_type_services` (`laundry_id`, `service_type`, `laundry_type`, `price`) VALUES
(7, 'Rush', '              Shirts', 45),
(8, 'Rush', 'Comforters', 80),
(9, 'Rush', 'Jeans', 70),
(10, 'Non-rush', ' Shirts', 35),
(11, 'Non-rush', 'Jeans', 60),
(12, 'Non-rush', ' Comforters', 75);

-- --------------------------------------------------------

--
-- Table structure for table `summary`
--

CREATE TABLE `summary` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT current_timestamp(),
  `sales` int(11) DEFAULT NULL,
  `expenses` int(11) DEFAULT NULL,
  `profit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `summary`
--

INSERT INTO `summary` (`id`, `date`, `sales`, `expenses`, `profit`) VALUES
(1, '2022-01-22', 0, 90, -90),
(2, '2022-02-14', 0, 300, -300),
(3, '2022-03-11', 0, 300, -300),
(4, '2022-04-20', 0, 2500, -2500),
(5, '2022-05-13', 0, 3000, -3000),
(6, '2022-06-08', 0, 109, -109),
(7, '2022-07-12', 0, 384, -384),
(8, '2022-08-23', 0, 250, -250),
(9, '2022-09-09', 0, 450, -450),
(10, '2022-10-12', 0, 109, -109),
(11, '2022-11-02', 0, 75, -75),
(12, '2022-11-03', 0, 6, -6),
(13, '2022-11-09', 0, 150, -150),
(14, '2022-11-17', 0, 100, -100),
(15, '2022-11-19', 0, 200, -200),
(16, '2022-11-23', 1480, 0, 1480),
(17, '2022-11-24', 1225, 0, 1225),
(18, '2022-11-29', 945, 130, 815),
(19, '2022-11-30', 715, 25, 690),
(20, '2022-12-01', 160, 40, 120),
(22, '2022-12-04', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `trans_date` datetime DEFAULT current_timestamp(),
  `customer_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `total_amount` bigint(20) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `claim_status` varchar(50) DEFAULT NULL,
  `laundry_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `trans_date`, `customer_id`, `admin_id`, `service_id`, `weight`, `total_amount`, `payment_status`, `claim_status`, `laundry_status`) VALUES
(8, '2022-11-23 00:00:00', 60, 1, 9, 13, 910, 'Paid', 'Claimed', 'Done'),
(9, '2022-11-23 00:00:00', 61, 1, 9, 3, 210, 'Paid', 'Claimed', 'Done'),
(11, '2022-11-23 15:33:44', 62, 1, 7, 8, 360, 'Unpaid', 'Unclaimed', 'Pending'),
(12, '2022-11-24 11:27:39', 59, 2, 7, 21, 945, 'Paid', 'Claimed', 'Pending'),
(13, '2022-11-24 11:39:27', 63, 2, 9, 4, 280, 'Paid', 'Claimed', 'Done'),
(14, '2022-11-29 02:08:02', 60, 1, 8, 4, 320, 'Unpaid', 'Unclaimed', 'Pending'),
(15, '2022-11-29 02:08:18', 63, 1, 9, 7, 490, 'Paid', 'Unclaimed', 'Pending'),
(16, '2022-11-29 02:08:28', 63, 1, 7, 3, 135, 'Unpaid', 'Unclaimed', 'Pending'),
(17, '2022-11-30 15:48:38', 64, 1, 10, 3, 105, 'Paid', 'Claimed', 'Pending'),
(18, '2022-11-30 15:48:51', 59, 1, 11, 4, 240, 'Paid', 'Claimed', 'Done'),
(19, '2022-11-30 15:49:00', 61, 1, 12, 2, 150, 'Paid', 'Claimed', 'Done'),
(20, '2022-11-30 15:49:18', 61, 1, 10, 2, 70, 'Paid', 'Claimed', 'Done'),
(21, '2022-11-30 15:49:33', 62, 1, 12, 2, 150, 'Paid', 'Claimed', 'Done'),
(24, '2022-12-01 07:22:58', 64, 1, 8, 2, 160, 'Paid', 'Claimed', 'Done');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `first_name` (`first_name`),
  ADD KEY `username` (`username`),
  ADD KEY `password` (`password`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `laundry_type_services`
--
ALTER TABLE `laundry_type_services`
  ADD PRIMARY KEY (`laundry_id`);

--
-- Indexes for table `summary`
--
ALTER TABLE `summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `service_id` (`service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `laundry_type_services`
--
ALTER TABLE `laundry_type_services`
  MODIFY `laundry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `summary`
--
ALTER TABLE `summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin_accounts` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `laundry_type_services` (`laundry_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
