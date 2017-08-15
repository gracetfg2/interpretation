-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 12, 2017 at 03:15 PM
-- Server version: 10.0.32-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mouscho2_DesignProxy`
--

-- --------------------------------------------------------

--
-- Table structure for table `BehaviorGlobal`
--

CREATE TABLE `BehaviorGlobal` (
  `BehaviorIndex` int(11) UNSIGNED NOT NULL COMMENT 'Binds textarea feedback together',
  `PageOpenedTime` bigint(64) UNSIGNED NOT NULL,
  `FirstCharTime` bigint(64) UNSIGNED NOT NULL,
  `DesignerID` int(11) UNSIGNED NOT NULL COMMENT 'ID of the designer that data belongs to'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `BehaviorGlobal`
--

INSERT INTO `BehaviorGlobal` (`BehaviorIndex`, `PageOpenedTime`, `FirstCharTime`, `DesignerID`) VALUES
(23, 1502237231412, 1502237235349, 1);

-- --------------------------------------------------------

--
-- Table structure for table `BehaviorTextarea`
--

CREATE TABLE `BehaviorTextarea` (
  `Idx` int(11) NOT NULL,
  `BehaviorIndex` int(10) UNSIGNED NOT NULL COMMENT 'Binds multiple textareas to one page submission',
  `FirstCharTime` bigint(64) UNSIGNED NOT NULL,
  `LastCharTime` bigint(64) UNSIGNED NOT NULL,
  `PauseCount` int(10) UNSIGNED NOT NULL,
  `PauseTime` int(10) UNSIGNED NOT NULL,
  `WordCount` int(10) UNSIGNED NOT NULL,
  `SentenceCount` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Stores behavior info for each textarea submitted';

--
-- Dumping data for table `BehaviorTextarea`
--

INSERT INTO `BehaviorTextarea` (`Idx`, `BehaviorIndex`, `FirstCharTime`, `LastCharTime`, `PauseCount`, `PauseTime`, `WordCount`, `SentenceCount`) VALUES
(15, 23, 1502237235351, 1502237236276, 0, 0, 1, 1),
(16, 23, 1502237237655, 1502237238896, 0, 0, 4, 1),
(17, 23, 1502237240230, 1502237242796, 0, 0, 10, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BehaviorGlobal`
--
ALTER TABLE `BehaviorGlobal`
  ADD PRIMARY KEY (`BehaviorIndex`),
  ADD KEY `DesignerID` (`DesignerID`);

--
-- Indexes for table `BehaviorTextarea`
--
ALTER TABLE `BehaviorTextarea`
  ADD PRIMARY KEY (`Idx`),
  ADD KEY `BehaviorIndex` (`BehaviorIndex`),
  ADD KEY `BehaviorIndex_2` (`BehaviorIndex`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `BehaviorGlobal`
--
ALTER TABLE `BehaviorGlobal`
  MODIFY `BehaviorIndex` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Binds textarea feedback together', AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `BehaviorTextarea`
--
ALTER TABLE `BehaviorTextarea`
  MODIFY `Idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
