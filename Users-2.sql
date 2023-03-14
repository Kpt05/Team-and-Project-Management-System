-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 20, 2023 at 07:52 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Source_Tech`
--

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL,
  `accountType` varchar(64) NOT NULL,
  `firstName` varchar(64) NOT NULL,
  `middleName` varchar(64) DEFAULT NULL,
  `lastName` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `empNo` varchar(128) NOT NULL,
  `gender` varchar(64) NOT NULL,
  `DOB` date NOT NULL,
  `phoneNumber` varchar(64) DEFAULT NULL,
  `address` varchar(128) NOT NULL,
  `teams` varchar(64) NOT NULL,
  `lastLogin` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `accountType`, `firstName`, `middleName`, `lastName`, `email`, `password`, `empNo`, `gender`, `DOB`, `phoneNumber`, `address`, `teams`, `lastLogin`, `creationDate`) VALUES
(1, 'Administrator', 'Rhys', '', 'Garman', 'admin.test@sourcetech.net', '$2y$10$XtVcSOR3cQkDxSKBz2Hnw.I8VhtBZ0btV9S3uc7o5zilXfPQLjNuu', '0000000000001', 'male', '2005-01-02', '', 'Radyr Comprehensive School', 'Team 1', '2023-02-20 12:15:43', '2023-02-20 12:15:43'),
(2, 'Manager', 'Kevin', '', 'Titus', 'manager.test@sourcetech.net', '$2y$10$.lQx/Yy/SwVVr6yX6zNJ7OvoYDGN7gJ0W2er9TeUR15T2FQb7pwwe', '0000000000002', 'male', '2005-01-02', '', 'Radyr, Cardiff, UK', 'Team 1', '2023-02-20 16:18:03', '2023-02-20 16:18:03'),
(3, 'Employee', 'William', '', 'Morgan', 'employee.test@sourcetech.net', '$2y$10$om7sogGkD9ORbUmHp/wQMuEDCX0lFfWC9ZaGZDI02LCyQnMNxVxF6', '0000000000003', 'male', '2004-12-01', '', 'Radyr, Cardiff, UK', 'Team 3', '2023-02-20 16:19:24', '2023-02-20 16:19:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `empNo` (`empNo`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
