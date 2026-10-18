-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2026 at 11:12 AM
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
-- Database: `web_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `Email`, `Username`, `Password`) VALUES
(1, 'Axcel Kurt Mangabat', 'axcelmangabat@gmail.com', 'Heron', '$2y$10$tnNLjWZnN5bTmvxK6Do.0uNXZK9rLEGe6742.c4aQqiNb7BBjdVKW'),
(2, 'Enrico Gonzales', 'gonzalesenrico@gmail.com', 'Kokoi', '$2y$10$JuqSOjfAN0fvywwXv4XKresLvS6YdR1RDJY9CJAEhRjVG9VzhMtKe'),
(3, 'helo', 'helo@yes', 'utin', '$2y$10$VKGsSLdP7Ya4n5FO7sFhTOjKVxpsOhT67A/AleyvLFILoH8GAQS0W'),
(4, 'Aezer Mangabat', 'aezer@gmail.com', 'sosong', '$2y$10$l.ELrJd2sV6jSMuuBwWkNuEaFnFZiYwq9MrpK2O2WR4ny1VE.xIYm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `unique_email` (`Email`),
  ADD UNIQUE KEY `unique_username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
