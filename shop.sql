-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2022 at 07:24 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `catID` int(11) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Description` text CHARACTER SET utf8 NOT NULL,
  `Ordering` int(11) NOT NULL,
  `visibilty` tinyint(4) NOT NULL DEFAULT 0,
  `allow_comment` tinyint(4) NOT NULL DEFAULT 0,
  `allow_ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catID`, `Name`, `Description`, `Ordering`, `visibilty`, `allow_comment`, `allow_ads`) VALUES
(17, 'Elctronics', 'Electronics on store', 1, 0, 0, 0),
(18, 'clothes', 'clothes as items', 0, 0, 0, 0),
(19, 'shoes', 'shoes as item ', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `cid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `statue` tinyint(4) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `itme_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`cid`, `comment`, `statue`, `date`, `itme_id`, `user_id`) VALUES
(24, 'rcdcfdcdfcfdf COMMENT', 0, '2022-08-01', 57, 10);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(11) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` varchar(255) CHARACTER SET utf8 NOT NULL,
  `add_Date` date NOT NULL,
  `counteryMade` varchar(255) NOT NULL,
  `sattus` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_id` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `Name`, `Description`, `Price`, `add_Date`, `counteryMade`, `sattus`, `Rating`, `approve`, `Cat_id`, `Member_ID`) VALUES
(57, 'iphone', 'iphon very good device ', '200', '2022-08-01', 'egypt', '1', 0, 0, 17, 8),
(58, 't-shirt', 't-shirt is goooooood', '366', '2022-08-01', 'esdse', '2', 0, 0, 18, 1),
(59, 'black shoes', 'tujuyh', '3333', '2022-08-01', 'egypt', '1', 0, 0, 19, 1),
(60, 'samsung', 'gyc jn jhn', '4888', '2022-08-01', 'saudi', '2', 0, 0, 17, 1),
(61, 'screen ', 'cxcxbhncjxh', '5000', '2022-08-01', 'egypt', '2', 0, 0, 17, 8),
(62, 'wifi', 'nbjnjn', '444', '2022-08-01', 'egypt', '1', 0, 0, 17, 8),
(63, 'mob', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb', '1000', '2022-08-01', 'cairo', '2', 0, 0, 17, 8),
(64, 'hb nb nb nnb ', 'b jnknkn jb jkbjnbk', '400', '0000-00-00', 'cairo', '', 0, 0, 18, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To identity User',
  `Username` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'username to login',
  `Password` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'password to login',
  `Email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `FullName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'identify user group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'seller rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user approve',
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`) VALUES
(1, 'omar', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '', '', 1, 0, 0, NULL),
(8, 'momhamed', '1c6637a8f2e1f75e06ff9984894d6bd16a3a36a9', 'xds@ewsss', 'exdsexdcxdcxdf', 0, 0, 0, '2022-07-25'),
(9, 'erfrrf', '9f41a95cba557b2894771eed96e07a4ded82537f', 'er@s', 'dre', 0, 0, 1, '2022-07-25'),
(10, 'Application', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'aa@aa', 'Application API', 0, 0, 1, '2022-08-08'),
(11, 'Ahmed', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'aa@aa.com', '', 0, 0, 1, '2022-08-14'),
(12, '0', '0', '0', '', 0, 0, 1, '2022-08-14'),
(13, 'abobakr', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'abo@hh.com', '', 0, 0, 1, '2022-08-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `Items_1` (`itme_id`),
  ADD KEY `user_1` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `Cat_1` (`Cat_id`),
  ADD KEY `member_1` (`Member_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `catID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To identity User', AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Items_1` FOREIGN KEY (`itme_id`) REFERENCES `items` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `Cat_1` FOREIGN KEY (`Cat_id`) REFERENCES `categories` (`catID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
