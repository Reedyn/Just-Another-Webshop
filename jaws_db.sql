-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: 10.101.1.89
-- Generation Time: Feb 05, 2014 at 08:31 AM
-- Server version: 5.5.30
-- PHP Version: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `174637-justanotherwebshop`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`CardId`, `CardNr`, `CardName`, `ExpiryMonth`, `ExpiryYear`) VALUES
(1, 123456789, 'Marcus Börjesson', '04', '16'),
(31, 2147483647, '54543', '15', '09'),
(32, 2147483647, '543543', '543', '543'),
(33, 2147483647, 'Gustav Lindqvist', '15', '09'),
(34, 2147483647, 'Gustav Lindqvist', '16', '08'),
(35, 2147483647, 'Gustav Lindqvist', '16', '07');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`CurrencyId`, `CurrencyName`, `CurrencyMultiplier`, `CurrencySign`, `CurrencyLayout`) VALUES
(1, 'Euro', 1, '&euro;', 'prefix'),
(2, 'US Dollar', 0.74, '$', 'prefix'),
(3, 'Swedish Krona', 0.11, 'SEK', 'suffix'),
(4, 'BitCoin', 1.59, 'mBTC', 'suffix'),
(8, 'Norwegian Kroner', 0.12, 'NOK', 'suffix');

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
  `ShippingCost` int(11) NOT NULL,
  PRIMARY KEY (`OrderId`),
  KEY `SSNr` (`SSNr`),
  KEY `ChargedCard` (`ChargedCard`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `ProductId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `Description` text NOT NULL,
  `ImgUrl` text NOT NULL,
  `Taxanomy` int(11) NOT NULL,
  `Price` int(11) unsigned NOT NULL,
  `Stock` int(11) unsigned NOT NULL,
  `ProductWeight` double unsigned NOT NULL,
  PRIMARY KEY (`ProductId`),
  KEY `Taxanomy` (`Taxanomy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductId`, `Name`, `Description`, `ImgUrl`, `Taxanomy`, `Price`, `Stock`, `ProductWeight`) VALUES
(12, 'Jofa LT890', 'Black helmet for all purposes', '/content/img/7_jaws.jpg', 13, 55, 2, 800),
(13, 'Jofa LT716W', 'White helmet', '/content/img/9_jaws.jpg', 13, 50, 2, 700),
(16, 'Figure Skates 2000', 'Skates for figure skating', '/content/img/3_jaws.jpg', 17, 800, 2, 1200),
(18, 'Bauer GH200', 'black hockey helmet', '/content/img/2_jaws.jpg', 19, 90, 10, 1200),
(19, 'Reebook SK93', 'Hockey skate from Reebook', '/content/img/5_jaws.jpg', 16, 500, 13, 1200),
(20, 'Bauer NME5 Hockey Goalie', 'Fashionable hockey helmet for goalkeepers', '/content/img/bauer-nme5-hockey-goalie-helmet-VRR-33772-S.jpg', 20, 400, 45, 600);

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE IF NOT EXISTS `shipping` (
  `MaxWeight` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  PRIMARY KEY (`MaxWeight`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`MaxWeight`, `Price`) VALUES
(200, 1),
(500, 2),
(2000, 5),
(5000, 8),
(20000, 25),
(100000, 50);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `taxanomies`
--

INSERT INTO `taxanomies` (`TaxanomyId`, `TaxanomyName`, `TaxanomyParent`) VALUES
(1, 'Root', 0),
(13, 'Helmets', 1),
(14, 'Skates', 1),
(16, 'Hockey Skates', 14),
(17, 'Figure Skates', 14),
(18, 'Hockey Helmets', 13),
(19, 'Cool Hockey Helmets', 18),
(20, 'Goalie Helmets', 18);

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
  `SessionKey` text NOT NULL,
  `IsAdmin` tinyint(1) DEFAULT NULL,
  `PwSalt` text NOT NULL,
  `ResetKey` text NOT NULL,
  PRIMARY KEY (`SSNr`),
  KEY `SSNr_2` (`SSNr`),
  KEY `SSNr_3` (`SSNr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`SSNr`, `Mail`, `Password`, `FirstName`, `LastName`, `StreetAddress`, `PostAddress`, `City`, `Telephone`, `SessionKey`, `IsAdmin`, `PwSalt`, `ResetKey`) VALUES
(1402058120, 'marcusandreas@hotmail.com', '005c9e384f4fd85ad51fbac919d4df2f', 'Marcus', 'BÃ¶rjesson', '10 Downing Street', '99999', 'London', '+463650070', '6bc2593ccc3da79892c44', 1, '749e98fb836ff7343fbf7', ''),
(9000000000, 'davidklaar@gmail.com', 'f17eddbd49206fba8960db4f2fe848e8', 'David', 'Klar', 'Tre st', 'Jdjfk', 'JÃ¶nkÃ¶ping ', '+4600000', '', 1, '72883c3c58599c64cc5c3', ''),
(9102011914, 'gustav@glindqvist.se', '1eefdc7a860b2519c3221725b9fe02b5', 'Gustav', 'Lindqvist', 'HermansvÃ¤gen 104', '55453', 'JÃ¶nkÃ¶ping', '46761479126', 'd45e77a7f4464739e42b5', 1, '9ecb0368a92fecee25667', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
