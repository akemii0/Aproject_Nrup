-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 24, 2023 at 05:32 PM
-- Server version: 8.0.32-0ubuntu0.20.04.2
-- PHP Version: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u_220170202_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `pid` int UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `phase` enum('design','development','testing','deployment','complete') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uid` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`pid`, `title`, `start_date`, `end_date`, `phase`, `description`, `uid`) VALUES
(3, 'Movie and TV Series rating website', '2023-02-20', '2023-06-21', 'development', 'This website shows ratings of many different TV series and movies. It also has comment section below every movie and tv series where users can see other users\' opinions.', 1),
(5, 'Outfit builder', '2023-03-28', '2023-09-26', 'design', 'This application allows the user to upload photos of their clothes, which the A.I uses its algorithm to make the best outfit for the user based on the style the user prefers.', 2),
(7, 'Random Game Generator', '2022-12-05', '2023-02-21', 'testing', 'Generates a random game for the user to play.', 1),
(8, 'test with login', '2023-04-30', '2023-04-30', 'complete', 'test test test', 7),
(9, 'test without login', '2023-04-20', '2023-04-24', 'complete', 'test test test test ', 10),
(10, 'chrisid3 test', '2023-04-20', '2023-04-24', 'complete', 'test test test', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `email`) VALUES
(1, 'Amy@1221', '$2y$10$5rl9XPT9TMDXwXPkQvhOSuVO1fz3.6tBSulmYEJ/PvEWAg.dNGlZa', 'amy123@gmail.com'),
(2, 'danyyy211', '$2y$10$nx5.rAPtkf3W9tIcdjDPCuhcKDv4r5Vah4QVH4E8JPJJ7E8sLRzOy', 'dany19@gmail.com'),
(3, 'chris112', '$2y$10$xTa/rzLGMASCdIFk0RwnZ.rhOqjtDgkxFV09YxbiXKfMqbFXE30Ki', 'chris12@gmail.com'),
(4, 'hailey123', '$2y$10$oZwm6NapthYU7RyJ09PUNOGLBvJe2EvlJ0fGOJ5HhcBT8EJGCzwAm', 'haileyy@gmail.com'),
(7, 'hitman12', '$2y$10$1rAhegI2g7Co50ykDLnr5.bf//emswpYXlSxwTTeO70avti/HmTh2', 'hitman32@gmail.com'),
(10, 'mrJ', '$2y$10$3VdSB4RGQ7NaDy9oHeohrOxvp5K.aIM8mUe19Qfl.OdM9Nol3W28.', 'hibye@gmail.com'),
(11, 'Trooper42', '$2y$10$zrMh4vCnDcXxyVtS8BbeLeW2nfNI1tcST717Inuo3EvcaH20qwvie', 'trooper_259@gmail.com'),
(13, 'check213123', '$2y$10$qRWxvnNL.TuWYXrIZuavgOAvydr8301xkSIPrqAABEytirlnw7HH.', 'check@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `pid` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
