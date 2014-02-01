-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 01, 2014 at 03:22 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jaws_db`
--
CREATE DATABASE IF NOT EXISTS `jaws_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `jaws_db`;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `CardId` int(11) NOT NULL AUTO_INCREMENT,
  `CardNr` int(11) NOT NULL,
  `CardName` text NOT NULL,
  `ExpiryMonth` char(11) NOT NULL,
  `ExpiryYear` char(11) NOT NULL,
  PRIMARY KEY (`CardId`),
  UNIQUE KEY `CardId` (`CardId`,`CardNr`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`CardId`, `CardNr`, `CardName`, `ExpiryMonth`, `ExpiryYear`) VALUES
(1, 123456789, 'Marcus Börjesson', '04', '16');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `CurrencyId` int(11) NOT NULL AUTO_INCREMENT,
  `CurrencyName` text NOT NULL,
  `CurrencyMultiplier` double NOT NULL,
  `CurrencySign` text NOT NULL,
  `CurrencyLayout` text NOT NULL,
  PRIMARY KEY (`CurrencyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`CurrencyId`, `CurrencyName`, `CurrencyMultiplier`, `CurrencySign`, `CurrencyLayout`) VALUES
(1, 'Euro', 1, '€', 'prefix'),
(2, 'US Dollar', 0.74, '$', 'prefix'),
(3, 'SEK', 0.11, 'kr', 'suffix');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `OrderId` int(11) NOT NULL AUTO_INCREMENT,
  `SSNr` double NOT NULL,
  `OrderDate` text NOT NULL,
  `Discount` float NOT NULL,
  `ChargedCard` int(11) NOT NULL,
  `OrderIP` text NOT NULL,
  `OrderTotal` int(11) NOT NULL,
  PRIMARY KEY (`OrderId`),
  KEY `SSNr` (`SSNr`),
  KEY `ChargedCard` (`ChargedCard`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderId`, `SSNr`, `OrderDate`, `Discount`, `ChargedCard`, `OrderIP`, `OrderTotal`) VALUES
(2, 621955621955, '2014-02-01 14:04:38', 0, 1, 'unknown', 0),
(3, 621955621955, '2014-02-01 14:06:37', 0, 1, '', 0),
(4, 621955621955, '2014-02-01 14:07:54', 0, 1, '127.0.0.1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_lists`
--

CREATE TABLE IF NOT EXISTS `order_lists` (
  `OrderListId` double unsigned NOT NULL AUTO_INCREMENT,
  `OrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Amount` int(11) unsigned NOT NULL,
  `OrderListTotal` int(11) NOT NULL,
  PRIMARY KEY (`OrderListId`),
  KEY `PurchaseId` (`OrderId`),
  KEY `ProductId` (`ProductId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `order_lists`
--

INSERT INTO `order_lists` (`OrderListId`, `OrderId`, `ProductId`, `Amount`, `OrderListTotal`) VALUES
(1, 2, 9, 2, 0),
(2, 2, 8, 1, 0),
(3, 3, 7, 1, 0),
(4, 3, 8, 2, 0),
(5, 3, 9, 3, 0),
(6, 4, 9, 3, 0),
(7, 4, 8, 2, 0),
(8, 4, 7, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `ProductId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Description` text NOT NULL,
  `ImgUrl` text NOT NULL,
  `Taxanomy` int(11) NOT NULL,
  `Price` int(11) unsigned NOT NULL,
  `Stock` int(11) unsigned NOT NULL,
  `ProductWeight` double unsigned NOT NULL,
  PRIMARY KEY (`ProductId`),
  KEY `Taxanomy` (`Taxanomy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductId`, `Name`, `Description`, `ImgUrl`, `Taxanomy`, `Price`, `Stock`, `ProductWeight`) VALUES
(7, 'Playstation', 'Sonyï¿½s first console and quite succesful too, runs games  like Crash Bandicoot, Gran Turismo and many more.', '/img/helmet.jpg', 2, 650, 43, 27),
(8, 'Xbox', 'The Xbox is Microsofts answer to the Playstation, runs the famous game Halo, along with a series of huge titles.', 'Xbox.jpg', 2, 930, 13, 4.5),
(9, 'GameBoy Color', 'The GameBoy Color is a portable gaming device from Nintendo, most famous for running Pokémon amongst other games. Also has color on screen, hence the name.', 'GameBoyColor.jpg', 2, 366, 71, 0.2),
(10, 'Nintendo 64', 'Nintendos 64-bit console running games like Super Mario 64, Mario Kart 64 and many more.', 'N64.jpg', 2, 1000, 50, 2);

-- --------------------------------------------------------

--
-- Table structure for table `taxanomies`
--

CREATE TABLE IF NOT EXISTS `taxanomies` (
  `TaxanomyId` int(11) NOT NULL AUTO_INCREMENT,
  `TaxanomyName` text NOT NULL,
  `TaxanomyParent` int(11) DEFAULT NULL,
  PRIMARY KEY (`TaxanomyId`),
  KEY `TaxanomyParent` (`TaxanomyParent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `taxanomies`
--

INSERT INTO `taxanomies` (`TaxanomyId`, `TaxanomyName`, `TaxanomyParent`) VALUES
(1, 'MasterParent', NULL),
(2, 'Consoles', NULL),
(3, 'Games', NULL),
(4, 'Accessories', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `SSNr` double NOT NULL,
  `Mail` text NOT NULL,
  `Password` text NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `StreetAddress` text NOT NULL,
  `PostAddress` text NOT NULL,
  `City` text NOT NULL,
  `Telephone` text NOT NULL,
  `SessionKey` int(11) NOT NULL,
  `IsAdmin` tinyint(1) DEFAULT NULL,
  `PwSalt` text NOT NULL,
  PRIMARY KEY (`SSNr`),
  UNIQUE KEY `SSNr` (`SSNr`),
  KEY `SSNr_2` (`SSNr`),
  FULLTEXT KEY `Mail` (`Mail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`SSNr`, `Mail`, `Password`, `FirstName`, `LastName`, `StreetAddress`, `PostAddress`, `City`, `Telephone`, `SessionKey`, `IsAdmin`, `PwSalt`) VALUES
(1, '2', 'e49e2aed685de5fd1f502e3e528842d2', '4', '5', '6', '7', '8', '9', 0, NULL, '395d05b6fd932b8b91bd3'),
(12345, 'asd@asd.asd', 'adcebf74e3e24ef7953eee75349cfba5', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 0, NULL, '7120'),
(199205075931, 'marcus@lolmail.com', 'd5b1ee4b463dc7db3b0eaaa0ea2cb5b4', 'Sven', 'Börjesson', 'Tändsticksgränd 11', '55315', 'Jönköping', '0708794290', 0, NULL, '1234'),
(621955621955, 'marcus@marcus.se', 'bfbe8c51cb64342cead571420e59c8ca', 'marcus', 'lololol', 'Street yo', '12345', 'jonkeeen', '+46123456', 96, NULL, '41afdc2df118e40194453');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`SSNr`) REFERENCES `users` (`SSNr`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`ChargedCard`) REFERENCES `cards` (`CardId`);

--
-- Constraints for table `order_lists`
--
ALTER TABLE `order_lists`
  ADD CONSTRAINT `order_lists_ibfk_1` FOREIGN KEY (`ProductId`) REFERENCES `products` (`ProductId`),
  ADD CONSTRAINT `order_lists_ibfk_2` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`Taxanomy`) REFERENCES `taxanomies` (`TaxanomyId`);

--
-- Constraints for table `taxanomies`
--
ALTER TABLE `taxanomies`
  ADD CONSTRAINT `taxanomies_ibfk_1` FOREIGN KEY (`TaxanomyParent`) REFERENCES `taxanomies` (`TaxanomyId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
