-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 02, 2023 at 11:22 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `gamehistory`
--

CREATE TABLE `gamehistory` (
  `gameID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `gameEndedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gameResult` varchar(10) NOT NULL,
  `gameMode` varchar(10) NOT NULL,
  `vsAI` tinyint(1) NOT NULL,
  `difficultyAI` int(10) NOT NULL,
  `scoreGained` int(10) NOT NULL,
  `FEN` varchar(255) NOT NULL,
  `isWhite` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gamehistory`
--

INSERT INTO `gamehistory` (`gameID`, `userID`, `gameEndedTime`, `gameResult`, `gameMode`, `vsAI`, `difficultyAI`, `scoreGained`, `FEN`, `isWhite`) VALUES
(1, 1, '2023-10-29 22:09:26', '1', 'BULLET', 1, 0, -4, 'r1b1k2r/pppp1ppp/4p3/2b1K1q1/4P3/8/PP4PP/nN5n w kq - 4 16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `preference`
--

CREATE TABLE `preference` (
  `preferenceID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `fullscreen` tinyint(1) NOT NULL DEFAULT '1',
  `masterVolume` float NOT NULL DEFAULT '100',
  `musicVolume` float NOT NULL DEFAULT '100',
  `sfxVolume` float NOT NULL DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `preference`
--

INSERT INTO `preference` (`preferenceID`, `userID`, `fullscreen`, `masterVolume`, `musicVolume`, `sfxVolume`) VALUES
(1, 1, 1, 100, 100, 100);

-- --------------------------------------------------------

--
-- Table structure for table `savedgames`
--

CREATE TABLE `savedgames` (
  `savedGameID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `FEN` varchar(255) NOT NULL,
  `gameMode` varchar(10) NOT NULL,
  `vsAI` tinyint(1) NOT NULL,
  `difficultyAI` int(10) NOT NULL,
  `isWhite` tinyint(1) NOT NULL,
  `lastModified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savedgames`
--

INSERT INTO `savedgames` (`savedGameID`, `userID`, `FEN`, `gameMode`, `vsAI`, `difficultyAI`, `isWhite`, `lastModified`) VALUES
(1, 1, 'r1bqkbnr/pppppppp/8/8/8/4n1P1/PPP1PP1P/RN1QKBNR w KQkq - 0 5', 'BULLET', 1, 0, 1, '2023-10-30 23:20:32');

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
(1, 'player', '$5$rounds=5000$gabrielsukapokem$4Lm.oBDwjk6ERHx3.yPhnfW3nXQmGCfficFBhKgZqK7', '$5$rounds=5000$gabrielsukapokemonplayer$', 976, 0, 0, 0, 1000);

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
-- Indexes for table `preference`
--
ALTER TABLE `preference`
  ADD PRIMARY KEY (`preferenceID`),
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
  MODIFY `gameID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `preference`
--
ALTER TABLE `preference`
  MODIFY `preferenceID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `savedgames`
--
ALTER TABLE `savedgames`
  MODIFY `savedGameID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gamehistory`
--
ALTER TABLE `gamehistory`
  ADD CONSTRAINT `gamehistory_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `preference`
--
ALTER TABLE `preference`
  ADD CONSTRAINT `preference_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `savedgames`
--
ALTER TABLE `savedgames`
  ADD CONSTRAINT `savedgames_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
