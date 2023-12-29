-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 29, 2023 at 01:28 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unityaccess`
--
CREATE DATABASE IF NOT EXISTS `unityaccess` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `unityaccess`;

-- --------------------------------------------------------

--
-- Table structure for table `gamehistory`
--

CREATE TABLE `gamehistory` (
  `gameID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `gameEndedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gameResult` varchar(255) NOT NULL,
  `gameMode` varchar(255) NOT NULL,
  `vsAI` tinyint(1) NOT NULL,
  `difficultyAI` int(10) NOT NULL,
  `scoreGained` int(10) NOT NULL,
  `FEN` varchar(255) NOT NULL,
  `isWhite` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `savedgames`
--

CREATE TABLE `savedgames` (
  `savedGameID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `FEN` varchar(255) NOT NULL,
  `gameMode` varchar(255) NOT NULL,
  `vsAI` tinyint(1) NOT NULL,
  `difficultyAI` int(10) NOT NULL,
  `isWhite` tinyint(1) NOT NULL,
  `lastModified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `white_time` int(11) NOT NULL DEFAULT '-1',
  `black_time` int(11) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(10) NOT NULL,
  `username` varchar(10) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `score` int(10) NOT NULL DEFAULT '1000',
  `win` int(10) NOT NULL DEFAULT '0',
  `lose` int(10) NOT NULL DEFAULT '0',
  `draw` int(10) NOT NULL DEFAULT '0',
  `highestScore` int(10) NOT NULL DEFAULT '1000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `hash`, `salt`, `score`, `win`, `lose`, `draw`, `highestScore`) VALUES
(1, 'player', '$5$rounds=5000$gabrielsukapokem$4Lm.oBDwjk6ERHx3.yPhnfW3nXQmGCfficFBhKgZqK7', '$5$rounds=5000$gabrielsukapokemonplayer$', 1000, 0, 0, 0, 1000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gamehistory`
--
ALTER TABLE `gamehistory`
  ADD PRIMARY KEY (`gameID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `savedgames`
--
ALTER TABLE `savedgames`
  ADD PRIMARY KEY (`savedGameID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gamehistory`
--
ALTER TABLE `gamehistory`
  MODIFY `gameID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `savedgames`
--
ALTER TABLE `savedgames`
  MODIFY `savedGameID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gamehistory`
--
ALTER TABLE `gamehistory`
  ADD CONSTRAINT `gamehistory_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `savedgames`
--
ALTER TABLE `savedgames`
  ADD CONSTRAINT `savedgames_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
