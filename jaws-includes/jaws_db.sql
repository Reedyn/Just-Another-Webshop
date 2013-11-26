-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2013 at 03:02 PM
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
  PRIMARY KEY (`CurrencyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`CurrencyId`, `CurrencyName`, `CurrencyMultiplier`, `CurrencySign`) VALUES
(1, 'Euro', 8.9, '€'),
(2, 'USDollar', 6.58, '$');

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
  PRIMARY KEY (`OrderId`),
  KEY `SSNr` (`SSNr`),
  KEY `ChargedCard` (`ChargedCard`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE IF NOT EXISTS `order_list` (
  `OrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Amount` int(11) NOT NULL,
  KEY `PurchaseId` (`OrderId`),
  KEY `ProductId` (`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `Price` int(11) NOT NULL,
  `Stock` int(11) NOT NULL,
  PRIMARY KEY (`ProductId`),
  KEY `Taxanomy` (`Taxanomy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductId`, `Name`, `Description`, `ImgUrl`, `Taxanomy`, `Price`, `Stock`) VALUES
(1, 'BenQ 1234', 'BenqDescrtiption', 'img/url.jpg', 1, 2000, 100),
(2, '2name', '2description', 'img/url.jpg', 1, 200, 100),
(3, '3name', '3description', 'img/url.jpg', 1, 200, 100),
(4, '4name', '4description', 'img/url.jpg', 1, 200, 100),
(5, '5name', '5description', 'img/url.jpg', 1, 200, 100);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `taxanomies`
--

INSERT INTO `taxanomies` (`TaxanomyId`, `TaxanomyName`, `TaxanomyParent`) VALUES
(1, 'KING', NULL);

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
  PRIMARY KEY (`SSNr`),
  FULLTEXT KEY `Mail` (`Mail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`SSNr`, `Mail`, `Password`, `FirstName`, `LastName`, `StreetAddress`, `PostAddress`, `City`, `Telephone`, `SessionKey`, `IsAdmin`) VALUES
(199205075931, 'marcusandreas@hotmail.com', '621955', 'Marcus', 'Börjesson', 'Tändsticksgränd 11', '55315', 'Jönköping', '0708794290', 0, NULL);

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
-- Constraints for table `order_list`
--
ALTER TABLE `order_list`
  ADD CONSTRAINT `order_list_ibfk_1` FOREIGN KEY (`ProductId`) REFERENCES `products` (`ProductId`),
  ADD CONSTRAINT `order_list_ibfk_2` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`);

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
