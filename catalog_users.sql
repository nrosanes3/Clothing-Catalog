-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 17, 2021 at 04:53 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nrosanes3`
--

-- --------------------------------------------------------

--
-- Table structure for table `catalog_users`
--

CREATE TABLE `catalog_users` (
  `u_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `date_last_login` datetime DEFAULT NULL,
  `date_registered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catalog_users`
--

INSERT INTO `catalog_users` (`u_id`, `first_name`, `last_name`, `user_name`, `email`, `password`, `date_last_login`, `date_registered`) VALUES
(1, 'Michelle', 'Poulin', 'michelle', 'mpoulin@nait.ca', 'Password1', '2021-12-12 22:00:25', '2021-12-11 05:55:22'),
(2, 'Nina', 'Rosanes', 'nrosanes3', 'nrosanes3@nait.ca', '1Forrest1', '2021-12-17 16:51:14', '2021-12-11 05:55:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catalog_users`
--
ALTER TABLE `catalog_users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catalog_users`
--
ALTER TABLE `catalog_users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
