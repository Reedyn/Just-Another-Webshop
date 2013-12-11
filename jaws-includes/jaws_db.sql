-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 11 dec 2013 kl 18:13
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
-- Tabellstruktur `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `CurrencyId` int(11) NOT NULL AUTO_INCREMENT,
  `CurrencyName` text NOT NULL,
  `CurrencyMultiplier` double NOT NULL,
  `CurrencySign` text NOT NULL,
  PRIMARY KEY (`CurrencyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumpning av Data i tabell `currencies`
--

INSERT INTO `currencies` (`CurrencyId`, `CurrencyName`, `CurrencyMultiplier`, `CurrencySign`) VALUES
(1, 'Euro', 8.9, '€'),
(2, 'USDollar', 6.58, '$');

-- --------------------------------------------------------

--
-- Tabellstruktur `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `OrderId` int(11) NOT NULL AUTO_INCREMENT,
  `SSNr` double NOT NULL,
  `OrderDate` text NOT NULL,
  `Discount` float NOT NULL,
  `ChargedCard` int(11) NOT NULL,
  `OrderIP` text NOT NULL,
  PRIMARY KEY (`OrderId`),
  KEY `SSNr` (`SSNr`),
  KEY `ChargedCard` (`ChargedCard`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `orders`
--

INSERT INTO `orders` (`OrderId`, `SSNr`, `OrderDate`, `Discount`, `ChargedCard`, `OrderIP`) VALUES
(1, 199205075931, 'date', 0, 1, ''),
(2, 199205075931, 'date', 0, 1, ''),
(3, 199205075931, 'date', 0, 1, ''),
(4, 199205075931, 'date', 0, 1, '');

-- --------------------------------------------------------

--
-- Tabellstruktur `order_lists`
--

CREATE TABLE IF NOT EXISTS `order_lists` (
  `OrderListId` double unsigned NOT NULL AUTO_INCREMENT,
  `OrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Amount` int(11) unsigned NOT NULL,
  PRIMARY KEY (`OrderListId`),
  KEY `PurchaseId` (`OrderId`),
  KEY `ProductId` (`ProductId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumpning av Data i tabell `order_lists`
--

INSERT INTO `order_lists` (`OrderListId`, `OrderId`, `ProductId`, `Amount`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 1, 5, 1),
(6, 2, 1, 1),
(7, 2, 2, 1),
(8, 3, 3, 1),
(9, 4, 4, 1),
(10, 4, 3, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `ProductId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Description` text NOT NULL,
  `ImgUrl` text NOT NULL,
  `Taxanomy` int(11) NOT NULL,
  `Price` int(11) unsigned NOT NULL,
  `Stock` int(11) unsigned NOT NULL,
  `ProductWeight` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ProductId`),
  KEY `Taxanomy` (`Taxanomy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumpning av Data i tabell `products`
--

INSERT INTO `products` (`ProductId`, `Name`, `Description`, `ImgUrl`, `Taxanomy`, `Price`, `Stock`, `ProductWeight`) VALUES
(1, 'BenQ 1234', 'BenqDescrtiption', 'img/url.jpg', 1, 2000, 100, 0),
(2, '2name', '2description', 'img/url.jpg', 1, 200, 100, 0),
(3, '3name', '3description', 'img/url.jpg', 1, 200, 100, 0),
(4, '4name', '4description', 'img/url.jpg', 1, 200, 100, 0),
(5, '5name', '5description', 'img/url.jpg', 1, 200, 100, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `taxanomies`
--

CREATE TABLE IF NOT EXISTS `taxanomies` (
  `TaxanomyId` int(11) NOT NULL AUTO_INCREMENT,
  `TaxanomyName` text NOT NULL,
  `TaxanomyParent` int(11) DEFAULT NULL,
  PRIMARY KEY (`TaxanomyId`),
  KEY `TaxanomyParent` (`TaxanomyParent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumpning av Data i tabell `taxanomies`
--

INSERT INTO `taxanomies` (`TaxanomyId`, `TaxanomyName`, `TaxanomyParent`) VALUES
(1, 'MasterParent', NULL);

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
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
  FULLTEXT KEY `Mail` (`Mail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`SSNr`, `Mail`, `Password`, `FirstName`, `LastName`, `StreetAddress`, `PostAddress`, `City`, `Telephone`, `SessionKey`, `IsAdmin`, `PwSalt`) VALUES
(12345, 'asd@asd.asd', 'adcebf74e3e24ef7953eee75349cfba5', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 0, NULL, '7120'),
(199205075931, 'marcus', 'd5b1ee4b463dc7db3b0eaaa0ea2cb5b4', 'Sven', 'Börjesson', 'Tändsticksgränd 11', '55315', 'Jönköping', '0708794290', 0, NULL, '1234');

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`SSNr`) REFERENCES `users` (`SSNr`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`ChargedCard`) REFERENCES `cards` (`CardId`);

--
-- Restriktioner för tabell `order_lists`
--
ALTER TABLE `order_lists`
  ADD CONSTRAINT `order_lists_ibfk_1` FOREIGN KEY (`ProductId`) REFERENCES `products` (`ProductId`),
  ADD CONSTRAINT `order_lists_ibfk_2` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`);

--
-- Restriktioner för tabell `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`Taxanomy`) REFERENCES `taxanomies` (`TaxanomyId`);

--
-- Restriktioner för tabell `taxanomies`
--
ALTER TABLE `taxanomies`
  ADD CONSTRAINT `taxanomies_ibfk_1` FOREIGN KEY (`TaxanomyParent`) REFERENCES `taxanomies` (`TaxanomyId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
