-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 18, 2024 at 03:51 PM
-- Server version: 5.7.42-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `SSTPL_UPLINK`
--

-- --------------------------------------------------------

--
-- Table structure for table `UP_Data`
--

CREATE TABLE `UP_Data` (
  `id` int(11) NOT NULL,
  `Address` text,
  `MAC` varchar(200) DEFAULT NULL,
  `Time` datetime DEFAULT NULL,
  `freq` int(11) DEFAULT NULL,
  `Modulation` varchar(100) DEFAULT NULL,
  `Data_Rate` varchar(100) DEFAULT NULL,
  `Code_Rate` varchar(100) DEFAULT NULL,
  `RSSI` int(11) DEFAULT NULL,
  `LORA_SNR` float DEFAULT NULL,
  `PAYLOAD` text,
  `Port_no` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `UP_Data`
--

INSERT INTO `UP_Data` (`id`, `Address`, `MAC`, `Time`, `freq`, `Modulation`, `Data_Rate`, `Code_Rate`, `RSSI`, `LORA_SNR`, `PAYLOAD`, `Port_no`) VALUES
(1, '506f98000000c2f1', '506f980000000118', '2023-10-11 17:08:14', 866495000, 'Power_Anukampa', '7', '10', -85, 6.5, 'aa0300010009cdd7aa0324002f0594000000000000000100000000000027100000015e000003750000037500015dca5622', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `UP_Data`
--
ALTER TABLE `UP_Data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Time` (`Time`),
  ADD KEY `Address` (`Address`(200));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `UP_Data`
--
ALTER TABLE `UP_Data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6142613;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
