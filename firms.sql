-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2026 at 12:37 PM
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
-- Database: `transport_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `firms`
--

CREATE TABLE `firms` (
  `firm_id` int(11) NOT NULL,
  `firm_name` varchar(150) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `address1` varchar(200) DEFAULT NULL,
  `address2` varchar(200) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `gst_no` varchar(20) DEFAULT NULL,
  `pan_no` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mailing_id` varchar(255) NOT NULL,
  `email_password` varchar(255) NOT NULL,
  `cin_number` varchar(255) NOT NULL,
  `mesme_number` varchar(255) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `cgst` varchar(255) NOT NULL,
  `sgst` varchar(255) NOT NULL,
  `igst` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `ifsc_code` varchar(255) NOT NULL,
  `jurisdiction` varchar(255) NOT NULL,
  `isfinish` varchar(255) NOT NULL,
  `financial_year` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `firms`
--

INSERT INTO `firms` (`firm_id`, `firm_name`, `alias`, `address1`, `address2`, `city`, `state`, `phone`, `mobile`, `gst_no`, `pan_no`, `email`, `mailing_id`, `email_password`, `cin_number`, `mesme_number`, `start_date`, `end_date`, `cgst`, `sgst`, `igst`, `bank_name`, `account_number`, `branch_name`, `ifsc_code`, `jurisdiction`, `isfinish`, `financial_year`, `created_at`) VALUES
(1, 'shreeinfotech software development private limited', 'shreetech software development', 'H.NO.46 WARD NO 6 DATATRAY NAGAR, LOHARA ROAD, YAVATMAL, MAHARASHTRA, INDIA', '40/600', 'Aurangabad', 'Maharashtra', '07057445099', '07057445099', '', '', 'patilagrotechindia@gmailcom', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', '', '0', '2024', '2026-02-19 03:20:47'),
(2, 'shreetech software development', 'shreetech software development', 'H.NO.46 WARD NO 6 DATATRAY NAGAR, LOHARA ROAD, YAVATMAL, MAHARASHTRA, INDIA', '40/600', 'Akola', 'Maharashtra', '07020689724', '', '', '', 'patilagrotechindia@gmail.com', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', '', '0', '2024', '2026-02-19 11:37:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `firms`
--
ALTER TABLE `firms`
  ADD PRIMARY KEY (`firm_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `firms`
--
ALTER TABLE `firms`
  MODIFY `firm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
