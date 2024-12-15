-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 09:58 AM
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
-- Database: `jamar_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(11) NOT NULL,
  `PostID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Content` text NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentID`, `PostID`, `UserID`, `Content`, `CreatedAt`) VALUES
(4, 3, 9, 'Pareee ko', '2024-12-15 07:43:31'),
(6, 3, 6, 'Kuya Reymar', '2024-12-15 07:46:04'),
(8, 3, 12, 'paree', '2024-12-15 08:11:10'),
(15, 3, 10, 'pree', '2024-12-15 08:27:42'),
(17, 5, 10, '@ALLYNDUMAPIAS', '2024-12-15 08:34:42'),
(18, 5, 12, '@PhillipDelacerna', '2024-12-15 08:40:10'),
(19, 5, 12, '@KLYDESABUERO', '2024-12-15 08:40:59'),
(20, 6, 13, 'MIGOOOO', '2024-12-15 08:47:42'),
(21, 6, 1, 'PAREE', '2024-12-15 08:49:19'),
(22, 3, 1, '@REYMAR OBENZA', '2024-12-15 08:50:55');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Content` text DEFAULT NULL,
  `ImagePath` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostID`, `UserID`, `Content`, `ImagePath`, `CreatedAt`) VALUES
(3, 1, 'Partner', 'uploads/675e6b0324896_reymar.jpg', '2024-12-15 05:37:07'),
(5, 10, 'MGA KASAMA', 'uploads/675e9491f0940_bros.jpg', '2024-12-15 08:34:25'),
(6, 12, 'Exercise!', 'uploads/675e96964967f_Exercise.jpg', '2024-12-15 08:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password_hash` varchar(255) NOT NULL,
  `Bio` text DEFAULT NULL,
  `date_joined` date DEFAULT curdate(),
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Email`, `Password_hash`, `Bio`, `date_joined`, `profile_pic`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'yes', '2024-12-02', 'uploads/allyn - Copy.jpg', '2024-12-13 16:19:57'),
(6, 'John Louis\nSancala', 'dodong@gmail.com', '2bd25d9ec85427b5ce9c2a4ab404bba3', NULL, '2024-12-11', 'uploads/cha2.jpg', '2024-12-13 16:19:57'),
(9, 'Leyam Dumapias', 'leyam@gmail.com', '5febc16afc55ca6fe35579544a31b9dc', NULL, '2024-12-14', 'uploads/leyam.jpg', '2024-12-13 18:10:01'),
(10, 'Jester  Palangan', 'jesterp@gmail.com', '694915d7d4acf50bbf43a1038e3e9f17', NULL, '2024-12-14', 'uploads/jester.jpg', '2024-12-13 18:56:34'),
(11, 'Reymar Obenza', 'reymar1@gmail.com', 'db00cf75ba73d04eba2e0c69841d3c70', NULL, '2024-12-14', 'uploads/allyn - Copy.jpg', '2024-12-14 02:16:40'),
(12, 'Allyn Dumapias', 'allyn@gmail.com', '15fe52331da130611ca76048887a860d', NULL, '2024-12-15', 'uploads/allyn - Copy.jpg', '2024-12-15 07:44:36'),
(13, 'Klyde Sabuero', 'klyde@gmail.com', 'b9e58584d9fa818e18b1c259383037d4', NULL, '2024-12-15', 'uploads/klyde.png', '2024-12-15 08:44:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `PostID` (`PostID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`PostID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
