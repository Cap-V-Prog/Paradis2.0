-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2023 at 06:20 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paradis`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `U_ID` int(11) NOT NULL,
  `I_ID` int(11) NOT NULL,
  `Quant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `I_ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `Description` text NOT NULL,
  `Image` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itemsells`
--

CREATE TABLE `itemsells` (
  `S_ID` int(11) NOT NULL,
  `I_ID` int(11) NOT NULL,
  `Quant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sells`
--

CREATE TABLE `sells` (
  `S_ID` int(11) NOT NULL,
  `U_ID` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `PaymentMethod` set('Debit','Credit','PayPal','Other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spotlight`
--

CREATE TABLE `spotlight` (
  `I_ID` int(11) NOT NULL,
  `Discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `T_ID` int(11) NOT NULL,
  `TagName` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagitem`
--

CREATE TABLE `tagitem` (
  `T_ID` int(11) NOT NULL,
  `I_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `U_ID` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Address` varchar(30) NOT NULL,
  `Tell` char(9) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Birthday` date NOT NULL,
  `NIF` char(9) NOT NULL,
  `Gender` set('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `U_ID` (`U_ID`),
  ADD KEY `I_ID` (`I_ID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`I_ID`);

--
-- Indexes for table `itemsells`
--
ALTER TABLE `itemsells`
  ADD KEY `I_ID` (`I_ID`),
  ADD KEY `S_ID` (`S_ID`);

--
-- Indexes for table `sells`
--
ALTER TABLE `sells`
  ADD PRIMARY KEY (`S_ID`),
  ADD KEY `U_ID` (`U_ID`);

--
-- Indexes for table `spotlight`
--
ALTER TABLE `spotlight`
  ADD KEY `I_ID` (`I_ID`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`T_ID`);

--
-- Indexes for table `tagitem`
--
ALTER TABLE `tagitem`
  ADD KEY `I_ID` (`I_ID`),
  ADD KEY `T_ID` (`T_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`U_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `I_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sells`
--
ALTER TABLE `sells`
  MODIFY `S_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `T_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `U_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`U_ID`) REFERENCES `users` (`U_ID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`I_ID`) REFERENCES `inventory` (`I_ID`);

--
-- Constraints for table `itemsells`
--
ALTER TABLE `itemsells`
  ADD CONSTRAINT `itemsells_ibfk_1` FOREIGN KEY (`I_ID`) REFERENCES `inventory` (`I_ID`),
  ADD CONSTRAINT `itemsells_ibfk_2` FOREIGN KEY (`S_ID`) REFERENCES `sells` (`S_ID`);

--
-- Constraints for table `sells`
--
ALTER TABLE `sells`
  ADD CONSTRAINT `sells_ibfk_1` FOREIGN KEY (`U_ID`) REFERENCES `users` (`U_ID`);

--
-- Constraints for table `spotlight`
--
ALTER TABLE `spotlight`
  ADD CONSTRAINT `spotlight_ibfk_1` FOREIGN KEY (`I_ID`) REFERENCES `inventory` (`I_ID`);

--
-- Constraints for table `tagitem`
--
ALTER TABLE `tagitem`
  ADD CONSTRAINT `tagitem_ibfk_1` FOREIGN KEY (`I_ID`) REFERENCES `inventory` (`I_ID`),
  ADD CONSTRAINT `tagitem_ibfk_2` FOREIGN KEY (`T_ID`) REFERENCES `tag` (`T_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
