-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 29, 2023 at 10:59 AM
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

--
-- Dumping data for table `gamehistory`
--

INSERT INTO `gamehistory` (`gameID`, `userID`, `gameEndedTime`, `gameResult`, `gameMode`, `vsAI`, `difficultyAI`, `scoreGained`, `FEN`, `isWhite`) VALUES
(7, 5, '2023-11-02 20:15:11', '1', 'BULLET', 1, 0, -3, 'rn2kb1r/ppp2ppp/5p1n/3p3K/4Pq2/5b2/PPPP3P/RNB2B2 w kq - 6 11', 1),
(8, 5, '2023-11-02 20:15:49', '1', 'BULLET', 1, 0, -7, 'r2qkb1r/ppp2ppp/8/3ppb2/2Pn4/3K4/PP1P2PP/RNBn1BNR w kq - 1 10', 1),
(9, 5, '2023-11-02 20:17:22', '1', 'BULLET', 1, 0, -8, 'r1b1kb1r/pppp1ppp/1q1np3/2K5/8/8/P1P3PP/RN4Nn w kq - 2 15', 1),
(10, 5, '2023-11-02 20:18:50', '1', 'BULLET', 1, 0, -8, 'r1b1kb1r/ppp2ppp/8/3pp1q1/3n4/6K1/PPPP2PP/RNBn1BNR w kq - 4 10', 1),
(15, 5, '2023-11-23 23:27:27', '2', 'BULLET', 1, 0, -6, 'rnbq1b2/1p2pp1p/p1p5/k2p4/1P1Q4/2N2N2/P1PP1PPP/R1BQKB1R b KQ - 0 7', 0),
(16, 5, '2023-12-17 20:42:40', '1', 'BULLET', 1, 0, -5, 'r3kb1r/ppp1pppp/2n5/3n1b2/8/4K3/PPP2PPP/R1Bq1B1R w kq - 2 5', 1),
(17, 5, '2023-12-17 20:42:55', '1', 'BULLET', 1, 0, -7, 'rn2k1nr/ppp1bppp/3qp3/6K1/4p3/8/PPPP1P1P/RNBb1B1R w kq - 2 8', 1);

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

--
-- Dumping data for table `savedgames`
--

INSERT INTO `savedgames` (`savedGameID`, `userID`, `FEN`, `gameMode`, `vsAI`, `difficultyAI`, `isWhite`, `lastModified`, `white_time`, `black_time`) VALUES
(27, 5, 'r1bqkbnr/2p2ppp/p1p5/4p3/4P3/2N2N2/PPPP1PPP/R1BQK2R b KQkq - 0 1', 'BLITZ', 1, 3, 0, '2023-12-29 17:17:24', 55, 79);

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
(5, 'gabriel', '$5$rounds=5000$gabrielsukapokem$kMQmLOvFZP2alpq2qgNk.Xdqh77lImJKZrFHPyONi00', '$5$rounds=5000$gabrielsukapokemongabriel$', 950, 0, 2, 0, 1000),
(6, 'data2', '$5$rounds=5000$gabrielsukapokem$gxuDw5tgn75ujyYwcq7W1a5p4rLkUktHEVRut/tGKj4', '$5$rounds=5000$gabrielsukapokemonwqrwer$', 1000, 0, 0, 0, 1000),
(7, 'data3', '$5$rounds=5000$gabrielsukapokem$Vu8ztiEKv9ETp9yHem1m5XHE5Zx8jaxcetA5R6utg12', '$5$rounds=5000$gabrielsukapokemoncxvsfdf$', 1000, 0, 0, 0, 1000),
(8, 'data4', '$5$rounds=5000$gabrielsukapokem$sUa4VVZO8lXZlWMdAQp9HB/MOlgT/re0bdrCP2p5jUC', '$5$rounds=5000$gabrielsukapokemonvcxvd$', 1000, 0, 0, 0, 1000),
(9, 'data5', '$5$rounds=5000$gabrielsukapokem$bJdK7lgYDCQuP2SqOpvjBYcPvBQcUvAZzQKp6pjXXC5', '$5$rounds=5000$gabrielsukapokemon124qwe$', 1000, 0, 0, 0, 1000),
(10, 'data6', '$5$rounds=5000$gabrielsukapokem$2FGZ/RY6fKw0NOU0bkTIEXbQeMucbhYEqDJANJ/8hD2', '$5$rounds=5000$gabrielsukapokemondata6$', 1000, 0, 0, 0, 1000),
(11, 'data7', '$5$rounds=5000$gabrielsukapokem$Qofp2AdiHGgEIieNknYN9V6ECsRG..NKGDbLHsgXMI6', '$5$rounds=5000$gabrielsukapokemondata7$', 1000, 0, 0, 0, 1000),
(13, 'data9', '$5$rounds=5000$gabrielsukapokem$XWQQiMq5mx4TAg7z362ndBUlf1pINOWN5N49hetj0C.', '$5$rounds=5000$gabrielsukapokemondata9$', 1000, 0, 0, 0, 1000),
(14, 'data10', '$5$rounds=5000$gabrielsukapokem$4vg2ImldptwjbrFuofO3B6ZTuLYvC9mmoc5nECY/nM7', '$5$rounds=5000$gabrielsukapokemondata10$', 1000, 0, 0, 0, 1000);

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
  MODIFY `gameID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `savedgames`
--
ALTER TABLE `savedgames`
  MODIFY `savedGameID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
