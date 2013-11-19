-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 19 nov 2013 kl 09:19
-- Serverversion: 5.6.12-log
-- PHP-version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `jaws_db`
--
CREATE DATABASE IF NOT EXISTS `jaws_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `jaws_db`;

-- --------------------------------------------------------

--
-- Tabellstruktur `cards`
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
-- Dumpning av Data i tabell `cards`
--

INSERT INTO `cards` (`CardId`, `CardNr`, `CardName`, `ExpiryMonth`, `ExpiryYear`) VALUES
(1, 123456789, 'Marcus Börjesson', '04', '16');

-- --------------------------------------------------------

--
-- Tabellstruktur `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumpning av Data i tabell `categories`
--

INSERT INTO `categories` (`Id`, `Name`) VALUES
(1, 'Monitor');

-- --------------------------------------------------------

--
-- Tabellstruktur `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `ProductId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Category` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Stock` int(11) NOT NULL,
  PRIMARY KEY (`ProductId`),
  KEY `Category` (`Category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumpning av Data i tabell `products`
--

INSERT INTO `products` (`ProductId`, `Name`, `Category`, `Price`, `Stock`) VALUES
(1, 'BenQ 1234', 1, 2000, 100);

-- --------------------------------------------------------

--
-- Tabellstruktur `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `PurchaseId` int(11) NOT NULL AUTO_INCREMENT,
  `SSNr` double NOT NULL,
  `PurchaseDate` date NOT NULL,
  `Discount` float NOT NULL,
  `ChargedCard` int(11) NOT NULL,
  PRIMARY KEY (`PurchaseId`),
  KEY `SSNr` (`SSNr`),
  KEY `ChargedCard` (`ChargedCard`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumpning av Data i tabell `purchases`
--

INSERT INTO `purchases` (`PurchaseId`, `SSNr`, `PurchaseDate`, `Discount`, `ChargedCard`) VALUES
(1, 199205075931, '2013-11-19', 0, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `purchase_list`
--

CREATE TABLE IF NOT EXISTS `purchase_list` (
  `PurchaseId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  UNIQUE KEY `ProductId` (`ProductId`),
  KEY `PurchaseId` (`PurchaseId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `purchase_list`
--

INSERT INTO `purchase_list` (`PurchaseId`, `ProductId`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `SSNr` double NOT NULL,
  `Mail` text NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `StreetAddress` text NOT NULL,
  `PostAddress` text NOT NULL,
  `City` text NOT NULL,
  `Telephone` text NOT NULL,
  PRIMARY KEY (`SSNr`),
  UNIQUE KEY `SSNr` (`SSNr`),
  KEY `SSNr_2` (`SSNr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`SSNr`, `Mail`, `FirstName`, `LastName`, `StreetAddress`, `PostAddress`, `City`, `Telephone`) VALUES
(199205075931, 'marcusandreas@hotmail.com', 'Marcus', 'Börjesson', 'Tändsticksgränd 11', '55315', 'Jönköping', '0708794290');

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`Category`) REFERENCES `categories` (`Id`);

--
-- Restriktioner för tabell `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`ChargedCard`) REFERENCES `cards` (`CardId`),
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`SSNr`) REFERENCES `users` (`SSNr`);

--
-- Restriktioner för tabell `purchase_list`
--
ALTER TABLE `purchase_list`
  ADD CONSTRAINT `purchase_list_ibfk_2` FOREIGN KEY (`PurchaseId`) REFERENCES `purchases` (`PurchaseId`),
  ADD CONSTRAINT `purchase_list_ibfk_1` FOREIGN KEY (`ProductId`) REFERENCES `products` (`ProductId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
