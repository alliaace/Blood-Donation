-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2018 at 11:41 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blooddonation`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood_ad`
--

CREATE TABLE `blood_ad` (
  `id` int(11) NOT NULL,
  `recipient_userid` int(11) NOT NULL,
  `bloodgroup` varchar(3) NOT NULL,
  `totalneed` int(11) NOT NULL,
  `adactive` tinyint(1) NOT NULL DEFAULT '1',
  `postdate` datetime NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `donators`
--

CREATE TABLE `donators` (
  `id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `recipient_userid` int(11) NOT NULL,
  `donor_userid` int(11) NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT '2',
  `requestedon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `password_enc` varchar(255) DEFAULT NULL,
  `salt` varchar(10) NOT NULL,
  `bloodgroup` varchar(3) DEFAULT NULL,
  `phone` int(15) DEFAULT NULL,
  `lastDonated` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `username`, `gender`, `email`, `password_enc`, `salt`, `bloodgroup`, `phone`, `lastDonated`) VALUES
(1, 'sheikh', 'hamza', 'admin', 'm', 'x', 'momplsWC9Y4cYgiylWXmTioeb6gxYzkwM2Q2ZDY3', '1c903d6d67', 'o+', 0, '2018-01-08'),
(2, 'as', 'as', 'aa', 'm', 'a', '/ufLEtGWb5JBC5K+TDyHRmxLrFszZmVkMjExNTZm', '3fed21156f', 'b+', 1, NULL),
(3, 'g', 'g', 'g', 'm', 'g', '+7Z1C/pGVeFhJBaDCYV9+LNRaG00YzJmYjg5YzA3', '4c2fb89c07', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood_ad`
--
ALTER TABLE `blood_ad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donators`
--
ALTER TABLE `donators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blood_ad`
--
ALTER TABLE `blood_ad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donators`
--
ALTER TABLE `donators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
