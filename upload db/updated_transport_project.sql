-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2026 at 12:48 PM
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
-- Database: `updated_transport_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `city_master`
--

CREATE TABLE `city_master` (
  `city_id` int(11) NOT NULL,
  `state_name` text NOT NULL,
  `city_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city_master`
--

INSERT INTO `city_master` (`city_id`, `state_name`, `city_name`) VALUES
(1, 'maharashtra', 'yavatmal'),
(3, 'maharashtra', 'wardha'),
(5, 'maharashtra', 'amravati');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `logo` varchar(255) DEFAULT NULL,
  `seal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `firms`
--

INSERT INTO `firms` (`firm_id`, `firm_name`, `alias`, `address1`, `address2`, `city`, `state`, `phone`, `mobile`, `gst_no`, `pan_no`, `email`, `mailing_id`, `email_password`, `cin_number`, `mesme_number`, `start_date`, `end_date`, `cgst`, `sgst`, `igst`, `bank_name`, `account_number`, `branch_name`, `ifsc_code`, `jurisdiction`, `isfinish`, `financial_year`, `created_at`, `logo`, `seal`) VALUES
(1, 'prafulla kinkar transport services', 'prafulla kinkar transport', 'H.NO.46 WARD NO 6 DATATRAY NAGAR, LOHARA ROAD, YAVATMAL, MAHARASHTRA, INDIA', '40/600', 'Aurangabad', 'Maharashtra', '07057445099', '992652552', '', '', 'patilagrotechindia@gmailcom', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', '', '0', '2024', '2026-02-19 03:20:47', '1773997338_logo.png', '1773997338_seal.png'),
(2, 'shreetech software development', 'shreetech software development', 'H.NO.46 WARD NO 6 DATATRAY NAGAR, LOHARA ROAD, YAVATMAL, MAHARASHTRA, INDIA', '40/600', 'Akola', 'Maharashtra', '07020689724', '992652552', '', '', 'patilagrotechindia@gmail.com', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', '', '0', '2024', '2026-02-19 11:37:11', NULL, NULL),
(3, 'shreeinfotech software development private limited', 'shreeinfotech software development', 'H.NO.49, WARD NO 6, DATTATRAY NAGAR, LOHARA ROAD , YAVATMAL', 'DAPAKI ROAD', 'Akola', 'Maharashtra', '07020689724', '992652552', '', '', 'kinkarprafulla.shreeinfotech@gmail.com', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', '', '0', '2024', '2026-03-17 11:54:37', NULL, NULL),
(5, 'kinkar & transport seviccces', 'xyz softw devel', 'DAPAKI ROAD', 'DAPAKI ROAD', 'Akola', 'Maharashtra', '07020689724', '07057445099', '27bcipk4372a24', '', 'patilagrotechindia@gmail.com', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', '', '0', '2024-2025', '2026-03-20 09:02:18', '1773997338_logo.png', '1773997338_seal.png');

-- --------------------------------------------------------

--
-- Table structure for table `freight_gst_details`
--

CREATE TABLE `freight_gst_details` (
  `freight_id` int(11) NOT NULL,
  `lr_id` varchar(255) NOT NULL,
  `lot_no` varchar(50) DEFAULT NULL,
  `pr_no` varchar(50) DEFAULT NULL,
  `pm_no` varchar(50) DEFAULT NULL,
  `freight` decimal(12,2) DEFAULT 0.00,
  `hamali` decimal(12,2) DEFAULT 0.00,
  `pre_bhadha` decimal(12,2) DEFAULT 0.00,
  `bilty_charge` decimal(12,2) DEFAULT 0.00,
  `collection_charges` decimal(12,2) DEFAULT 0.00,
  `cpc` decimal(12,2) DEFAULT 0.00,
  `other_charge` decimal(12,2) DEFAULT 0.00,
  `total` decimal(12,2) DEFAULT 0.00,
  `apply_gst` enum('Yes','No') DEFAULT 'No',
  `cgst` decimal(12,2) DEFAULT 0.00,
  `sgst` decimal(12,2) DEFAULT 0.00,
  `igst` decimal(12,2) DEFAULT 0.00,
  `advance_amount` decimal(12,2) DEFAULT 0.00,
  `grand_total` decimal(12,2) DEFAULT 0.00,
  `url_name` varchar(150) DEFAULT NULL,
  `print_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mill_freight` decimal(10,2) DEFAULT NULL,
  `agent_commission` decimal(10,2) DEFAULT NULL,
  `gadi_bhada` decimal(10,2) DEFAULT NULL,
  `profit` decimal(10,2) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `freight_type` varchar(20) DEFAULT 'TO PAY',
  `booking_type` varchar(20) DEFAULT NULL,
  `delivery_type` varchar(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freight_gst_details`
--

INSERT INTO `freight_gst_details` (`freight_id`, `lr_id`, `lot_no`, `pr_no`, `pm_no`, `freight`, `hamali`, `pre_bhadha`, `bilty_charge`, `collection_charges`, `cpc`, `other_charge`, `total`, `apply_gst`, `cgst`, `sgst`, `igst`, `advance_amount`, `grand_total`, `url_name`, `print_type`, `created_at`, `mill_freight`, `agent_commission`, `gadi_bhada`, `profit`, `weight`, `rate`, `freight_type`, `booking_type`, `delivery_type`, `remarks`) VALUES
(20, 'LR-2026-0001', NULL, NULL, NULL, 454.00, 54.00, 54.00, 54.00, 54.00, 540.00, 54.00, 0.00, 'No', 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2026-03-16 14:42:44', NULL, NULL, NULL, NULL, NULL, NULL, 'TO PAY', NULL, NULL, NULL),
(21, 'LR-2026-0001', NULL, NULL, NULL, 454.00, 54.00, 54.00, 54.00, 54.00, 540.00, 54.00, 0.00, 'No', 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2026-03-16 14:49:25', NULL, NULL, NULL, NULL, NULL, NULL, 'TO PAY', NULL, NULL, NULL),
(22, 'LR-2026-0001', NULL, NULL, NULL, 454.00, 54.00, 54.00, 54.00, 54.00, 540.00, 54.00, 0.00, 'No', 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2026-03-16 14:51:43', NULL, NULL, NULL, NULL, NULL, NULL, 'TO PAY', NULL, NULL, NULL),
(23, 'LR-2026-0002', NULL, NULL, NULL, 4534.00, 44.00, 44.00, 44.00, 5.00, 5.00, 54.00, 0.00, 'No', 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2026-03-17 12:00:27', NULL, NULL, NULL, NULL, NULL, NULL, 'TO PAY', NULL, NULL, NULL),
(24, 'LR-2026-0003', NULL, NULL, NULL, 4534.00, 44.00, 44.00, 44.00, 44.00, 5.00, 5.00, 0.00, 'No', 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2026-03-20 09:11:17', NULL, NULL, NULL, NULL, NULL, NULL, 'TO PAY', NULL, NULL, NULL),
(25, 'LR-2026-0004', NULL, NULL, NULL, 25000.00, 0.00, 44.00, 0.00, 0.00, 0.00, 6000.00, 0.00, 'No', 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2026-04-03 06:56:52', NULL, NULL, NULL, NULL, NULL, NULL, 'TO PAY', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_master`
--

CREATE TABLE `group_master` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `product_name` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_master`
--

INSERT INTO `group_master` (`group_id`, `group_name`, `product_name`) VALUES
(1, 'kinkar', ''),
(15, 'kinkar123', ''),
(27, 'kinkar123', ''),
(28, 'kinkar123', '');

-- --------------------------------------------------------

--
-- Table structure for table `logistics_profit_analysis`
--

CREATE TABLE `logistics_profit_analysis` (
  `profit_id` int(11) NOT NULL,
  `lr_id` varchar(255) NOT NULL,
  `revenue_amount` decimal(15,2) DEFAULT 0.00,
  `gadi_bhada` decimal(15,2) DEFAULT 0.00,
  `agent_comm_1` decimal(15,2) DEFAULT 0.00,
  `agent_comm_2` decimal(15,2) DEFAULT 0.00,
  `net_profit` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lr_entry`
--

CREATE TABLE `lr_entry` (
  `id` int(11) NOT NULL,
  `lr_id` varchar(255) NOT NULL,
  `lr_date` date DEFAULT NULL,
  `ref_lr_no` varchar(50) DEFAULT NULL,
  `pm` varchar(50) DEFAULT NULL,
  `from_city` varchar(150) DEFAULT NULL,
  `to_city` varchar(150) DEFAULT NULL,
  `consignor` varchar(150) DEFAULT NULL,
  `consignee` varchar(150) DEFAULT NULL,
  `cnsnr_address` varchar(255) DEFAULT NULL,
  `cnsgne_address` varchar(255) DEFAULT NULL,
  `cnsnr_gstin` varchar(20) DEFAULT NULL,
  `cnsgne_gstin` varchar(20) DEFAULT NULL,
  `billing_branch` varchar(150) DEFAULT NULL,
  `billed_to` varchar(150) DEFAULT NULL,
  `vehicle_no` varchar(30) DEFAULT NULL,
  `owner_name` varchar(150) DEFAULT NULL,
  `transport_mode` varchar(50) DEFAULT 'By Road',
  `transport_remark` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `delivery_at` varchar(150) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `policy_no` varchar(100) DEFAULT NULL,
  `insurance_amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `lot_no` varchar(50) DEFAULT NULL,
  `pr_no` varchar(50) DEFAULT NULL,
  `pm_no` varchar(50) DEFAULT NULL,
  `agent_name` varchar(100) DEFAULT NULL,
  `bill_to` varchar(100) DEFAULT NULL,
  `account_type` varchar(50) DEFAULT NULL,
  `firm_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lr_entry`
--

INSERT INTO `lr_entry` (`id`, `lr_id`, `lr_date`, `ref_lr_no`, `pm`, `from_city`, `to_city`, `consignor`, `consignee`, `cnsnr_address`, `cnsgne_address`, `cnsnr_gstin`, `cnsgne_gstin`, `billing_branch`, `billed_to`, `vehicle_no`, `owner_name`, `transport_mode`, `transport_remark`, `remarks`, `delivery_at`, `company_name`, `policy_no`, `insurance_amount`, `created_at`, `lot_no`, `pr_no`, `pm_no`, `agent_name`, `bill_to`, `account_type`, `firm_id`) VALUES
(15, 'LR-2026-0001', '2026-03-06', '1111', '1111', '3', '1', '1', '3', 'H.NO.49, WARD NO 6, DATTATRAY NAGAR, LOHARA ROAD , YAVATMAL', 'DAPAKI ROAD', '18', '11', '1111', '3', '12', '11111', 'By Air', '11111', 'good', 'tiruanantpuream', 'SHREEINFOTECH SOFTWARE DEVELOPMENT PRIVATE LIMITED', '111', 111.00, '2026-03-16 14:49:25', '44432', '423442', '34234', 'cbvb', 'fgdf', 'Consignor', 1),
(16, 'LR-2026-0001', '2026-03-06', '1111', '1111', '3', '1', '1', '3', 'H.NO.49, WARD NO 6, DATTATRAY NAGAR, LOHARA ROAD , YAVATMAL', 'DAPAKI ROAD', '18', '11', '1111', '3', '12', '11111', 'By Air', '11111', 'good', 'tiruanantpuream', 'SHREEINFOTECH SOFTWARE DEVELOPMENT PRIVATE LIMITED', '111', 111.00, '2026-03-16 14:51:43', '44432', '423442', '34234', 'cbvb', 'fgdf', 'Consignor', 2),
(17, 'LR-2026-0002', '2026-03-04', '1111', '1111', '5', '1', '1', '3', 'H.NO.49, WARD NO 6, DATTATRAY NAGAR, LOHARA ROAD , YAVATMAL', 'DAPAKI ROAD', '18', '18', 'yavatmal', '1', '12', '11111', 'By Air', '11111', 'good', 'tiruanantpuream', 'SHREEINFOTECH SOFTWARE DEVELOPMENT PRIVATE LIMITED', '54535', 111.00, '2026-03-17 12:00:27', '54353', '5345', '453', '3453', '5345', 'Consignor', 3),
(18, 'LR-2026-0003', '2026-03-19', '1111', '1111', '1', '5', '1', '3', 'H.NO.49, WARD NO 6, DATTATRAY NAGAR, LOHARA ROAD , YAVATMAL', 'DAPAKI ROAD', '11', '11', '1111', '1', '12', '11111', 'By Air', '11111', 'good', 'tiruanantpuream', 'SHREEINFOTECH SOFTWARE DEVELOPMENT PRIVATE LIMITED', '111', 111.00, '2026-03-20 09:11:17', 'gdfg', 'fgfdg', 'fgfd', 'fgd', 'fgdf', 'Consignor', 5),
(19, 'LR-2026-0004', '0000-00-00', '1111', '1111', '1', '5', '1', '3', 'Peshwe Plot', 'DAPAKI ROAD', '11', '11', '1111', '1', '12', '', 'By Road', '', '', 'tiruanantpuream', 'SHREEINFOTECH SOFTWARE DEVELOPMENT PRIVATE LIMITED', '', 0.00, '2026-04-03 06:56:52', 'gdfg', 'fgfdg', '', 'fgd', 'fgdf', 'Consignor', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `party_invoice_details`
--

CREATE TABLE `party_invoice_details` (
  `invoice_id` int(11) NOT NULL,
  `lr_id` varchar(255) NOT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `value_of_goods` decimal(10,2) DEFAULT NULL,
  `eway_bill_no` varchar(50) DEFAULT NULL,
  `ewb_exp_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `party_invoice_details`
--

INSERT INTO `party_invoice_details` (`invoice_id`, `lr_id`, `invoice_no`, `invoice_date`, `value_of_goods`, `eway_bill_no`, `ewb_exp_date`, `created_at`) VALUES
(16, 'LR-2026-0001', '43453453', '2026-03-13', 56544.00, '564', '2026-03-13', '2026-03-16 07:42:08'),
(17, 'LR-2026-0002', '43453453', '2026-03-05', 56544.00, '564', '2026-03-20', '2026-03-17 04:59:17'),
(18, 'LR-2026-0002', '7', '2026-03-26', 56544.00, '564', '2026-03-26', '2026-03-17 04:59:32'),
(19, 'LR-2026-0003', '43453453', '2026-03-14', 56544.00, '564', '2026-03-19', '2026-03-20 02:10:20'),
(20, 'LR-2026-0004', '7878', '2026-04-03', 56544.00, '564', '2026-04-03', '2026-04-03 12:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `party_master`
--

CREATE TABLE `party_master` (
  `party_id` int(11) NOT NULL,
  `ledger_group` text NOT NULL,
  `party_name` text NOT NULL,
  `address_one` text NOT NULL,
  `address_two` text NOT NULL,
  `state_name` text NOT NULL,
  `city_name` text NOT NULL,
  `mobile_number` text NOT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `party_master`
--

INSERT INTO `party_master` (`party_id`, `ledger_group`, `party_name`, `address_one`, `address_two`, `state_name`, `city_name`, `mobile_number`, `email`) VALUES
(1, 'Bank', 'prafulla', 'DAPAKI ROAD', 'DAPAKI ROAD', 'Maharashtra', 'yavatmal', '07020689724', NULL),
(3, 'Bank', 'prafulla123', 'DAPAKI ROAD', 'DAPAKI ROAD', 'Maharashtra', '', '07020689724', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `product_id` int(11) NOT NULL,
  `lr_id` varchar(255) DEFAULT NULL,
  `product_name` varchar(150) DEFAULT NULL,
  `group_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `actual_wt` decimal(10,2) DEFAULT NULL,
  `charge_wt` decimal(10,2) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `rate_type` varchar(50) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `length` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `height` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`product_id`, `lr_id`, `product_name`, `group_name`, `description`, `qty`, `actual_wt`, `charge_wt`, `unit`, `rate`, `rate_type`, `amount`, `length`, `width`, `height`, `created_at`) VALUES
(25, 'LR-2026-0001', 'shreetech software', '', 'fgdfggdfgdfgd', 545, 45.00, 45.00, 'cotton bel', 54.00, 'Per Kg', 54.00, 54.00, 54.00, 54.00, '2026-03-16 14:42:24'),
(29, 'LR-2026-0002', 'shreeinfotech software', '', 'gfhfghgfhf', 34, 43.00, 43.00, 'cotton bel', 43.00, 'Per Kg', 43.00, 43.00, 43.00, 43.00, '2026-03-17 11:59:56'),
(31, 'LR-2026-0003', 'infotech software', '', 'dfgddfg', 45, 54.00, 54.00, 'cotton bel', 54.00, 'Per Kg', 54.00, 54.00, 54.00, 54.00, '2026-03-20 09:10:37');

-- --------------------------------------------------------

--
-- Table structure for table `product_master`
--

CREATE TABLE `product_master` (
  `id` int(11) NOT NULL,
  `group_name` varchar(155) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_master`
--

INSERT INTO `product_master` (`id`, `group_name`, `product_name`) VALUES
(1, '', 'xcsdf'),
(22, '', 'shreetech'),
(30, '', 'shreeinfotech software'),
(31, '', 'xcsdf'),
(32, '', 'pringer');

-- --------------------------------------------------------

--
-- Table structure for table `trip_expense`
--

CREATE TABLE `trip_expense` (
  `id` int(11) NOT NULL,
  `lr_id` varchar(50) DEFAULT NULL,
  `diesel` decimal(10,2) DEFAULT NULL,
  `driver_payment` decimal(10,2) DEFAULT NULL,
  `toll` decimal(10,2) DEFAULT NULL,
  `other_expense` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_master`
--

CREATE TABLE `unit_master` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(155) NOT NULL,
  `unit_value` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_master`
--

INSERT INTO `unit_master` (`unit_id`, `unit_name`, `unit_value`) VALUES
(1, 'cotton bel', '30000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'tc100', '$2y$10$3KEotaW4nT3WAiinPxGhvul/LsQ9gYxsYwMMNd67k4Xt8/n50YCkC');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_master`
--

CREATE TABLE `vehicle_master` (
  `vehicle_id` int(11) NOT NULL,
  `owner_broker_name` text NOT NULL,
  `vehicle_number` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_master`
--

INSERT INTO `vehicle_master` (`vehicle_id`, `owner_broker_name`, `vehicle_number`) VALUES
(12, 'prafulla', 'mh29 907890');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city_master`
--
ALTER TABLE `city_master`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `firms`
--
ALTER TABLE `firms`
  ADD PRIMARY KEY (`firm_id`);

--
-- Indexes for table `freight_gst_details`
--
ALTER TABLE `freight_gst_details`
  ADD PRIMARY KEY (`freight_id`),
  ADD KEY `lr_id` (`lr_id`);

--
-- Indexes for table `group_master`
--
ALTER TABLE `group_master`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `logistics_profit_analysis`
--
ALTER TABLE `logistics_profit_analysis`
  ADD PRIMARY KEY (`profit_id`),
  ADD KEY `fk_lr_profit` (`lr_id`);

--
-- Indexes for table `lr_entry`
--
ALTER TABLE `lr_entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lr_id` (`lr_id`);

--
-- Indexes for table `party_invoice_details`
--
ALTER TABLE `party_invoice_details`
  ADD PRIMARY KEY (`invoice_id`),
  ADD UNIQUE KEY `unique_invoice_lr` (`lr_id`,`invoice_no`);

--
-- Indexes for table `party_master`
--
ALTER TABLE `party_master`
  ADD PRIMARY KEY (`party_id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `unique_product` (`lr_id`,`product_name`,`qty`);

--
-- Indexes for table `product_master`
--
ALTER TABLE `product_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trip_expense`
--
ALTER TABLE `trip_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_master`
--
ALTER TABLE `unit_master`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `vehicle_master`
--
ALTER TABLE `vehicle_master`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city_master`
--
ALTER TABLE `city_master`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `firms`
--
ALTER TABLE `firms`
  MODIFY `firm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `freight_gst_details`
--
ALTER TABLE `freight_gst_details`
  MODIFY `freight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `group_master`
--
ALTER TABLE `group_master`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `logistics_profit_analysis`
--
ALTER TABLE `logistics_profit_analysis`
  MODIFY `profit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lr_entry`
--
ALTER TABLE `lr_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `party_invoice_details`
--
ALTER TABLE `party_invoice_details`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `party_master`
--
ALTER TABLE `party_master`
  MODIFY `party_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product_master`
--
ALTER TABLE `product_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `trip_expense`
--
ALTER TABLE `trip_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_master`
--
ALTER TABLE `unit_master`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicle_master`
--
ALTER TABLE `vehicle_master`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logistics_profit_analysis`
--
ALTER TABLE `logistics_profit_analysis`
  ADD CONSTRAINT `fk_lr_profit` FOREIGN KEY (`lr_id`) REFERENCES `lr_entry` (`lr_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
