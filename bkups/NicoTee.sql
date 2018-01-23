-- Database: `shopnico` --
-- Table `additems` --
CREATE TABLE `additems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemname` varchar(100) NOT NULL,
  `itemdate` varchar(100) NOT NULL,
  `itemprice` varchar(10) NOT NULL,
  `itemqty` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `additems` (`id`, `itemname`, `itemdate`, `itemprice`, `itemqty`) VALUES
(1, 'Phone', '18th December, 2017', '500', '88'),
(2, 'Tv', '19th December, 2017', '300', '188'),
(3, '1.5 Cabel', '1st January, 2018', '40', '184'),
(4, 'Fufu', '3rd January, 2018', '3', '0'),
(5, 'Sunphosate', '10th January, 2018', '16', '374');

-- Table `dbmanager` --
CREATE TABLE `dbmanager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateGiven` text NOT NULL,
  `Alert1` text NOT NULL,
  `Alert2` text NOT NULL,
  `Alert3` text NOT NULL,
  `Alert4` text NOT NULL,
  `Alert5` text NOT NULL,
  `dateEnding` text NOT NULL,
  `DoneWithPeriod` varchar(3) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `dbmanager` (`id`, `dateGiven`, `Alert1`, `Alert2`, `Alert3`, `Alert4`, `Alert5`, `dateEnding`, `DoneWithPeriod`) VALUES
(1, '2018-01-15', '2018-01-20', '2018-12-21', '2018-12-22', '2018-12-23', '2018-12-24', '2018-12-25', 'no');

-- Table `deleted_staff` --
CREATE TABLE `deleted_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(10) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL,
  `delete_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table `onlineupdate` --
CREATE TABLE `onlineupdate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dated` text NOT NULL,
  `seconds` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `onlineupdate` (`id`, `dated`, `seconds`) VALUES
(1, '9h January, 2018', '20');

-- Table `receiptitems` --
CREATE TABLE `receiptitems` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `receiptNum` text NOT NULL,
  `ItemName` text NOT NULL,
  `Quantity` text NOT NULL,
  `Price` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

INSERT INTO `receiptitems` (`id`, `receiptNum`, `ItemName`, `Quantity`, `Price`) VALUES
(1, '1', 'Phone', '2', '1000'),
(2, '2', 'Tv', '10', '3000'),
(3, '3', 'Phone', '8', '4000'),
(4, '4', 'Phone', '2', '1000'),
(5, '5', 'Fufu', '199', '597'),
(6, '5', '1.5 Cabel', '10', '400'),
(7, '6', 'Sunphosate', '500', '8000'),
(8, '7', 'Tv', '90', '27000'),
(9, '8', '1.5 Cabel', '1', '40'),
(10, '8', 'Sunphosate', '10', '160'),
(11, '9', 'Sunphosate', '10', '160'),
(12, '10', 'Sunphosate', '80', '1280'),
(13, '10', 'Tv', '10', '3000'),
(14, '11', 'Sunphosate', '10', '160'),
(15, '12', 'Sunphosate', '10', '160'),
(16, '13', 'Sunphosate', '1', '16'),
(17, '14', '1.5 Cabel', '5', '200'),
(18, '14', 'Sunphosate', '5', '80'),
(19, '14', 'Tv', '2', '600'),
(20, '14', 'Fufu', '1', '3'),
(21, '14', 'Phone', '100', '50000');

-- Table `sale` --
CREATE TABLE `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemname` text NOT NULL,
  `itemprice` text NOT NULL,
  `itemqty` text NOT NULL,
  `totalamount` text NOT NULL,
  `staffname` text NOT NULL,
  `grandtotal` text NOT NULL,
  `qtyleft` text NOT NULL,
  `itemdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Cname` text NOT NULL,
  `Caddress` text NOT NULL,
  `Cmobile` text NOT NULL,
  `dateSold` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO `sale` (`id`, `itemname`, `itemprice`, `itemqty`, `totalamount`, `staffname`, `grandtotal`, `qtyleft`, `itemdate`, `Cname`, `Caddress`, `Cmobile`, `dateSold`) VALUES
(1, 'Phone', '500', '2', '1000', 'ADMINISTRATOR', '1000', '198', '2017-12-18 13:37:26', '', '', '', '2017-12-18'),
(2, 'Tv', '300', '10', '3000', 'ADMINISTRATOR', '3000', '290', '2017-12-19 09:52:52', '', '', '', '2017-12-19'),
(3, 'Phone', '500', '8', '4000', 'ADMINISTRATOR', '4000', '190', '2017-12-19 09:54:20', '', '', '', '2017-12-19'),
(4, 'Phone', '500', '2', '1000', 'ADMINISTRATOR', '1000', '188', '2018-01-01 15:33:42', '', '', '', '2018-01-01'),
(5, 'Fufu', '3', '199', '597', 'ADMINISTRATOR', '997', '1', '2018-01-03 18:36:29', '', '', '', '2018-01-03'),
(6, 'Sunphosate', '16', '500', '8000', 'ADMINISTRATOR', '8000', '500', '2018-01-10 14:03:35', '', '', '', '2018-01-10'),
(7, 'Tv', '300', '90', '27000', 'ADMINISTRATOR', '27000', '200', '2018-01-10 14:21:26', '', '', '', '2018-01-10'),
(8, '1.5 Cabel', '40', '1', '40', 'ADMINISTRATOR', '200', '189', '2018-01-12 09:07:00', '', '', '', '2018-01-12'),
(9, 'Sunphosate', '16', '10', '160', 'ADMINISTRATOR', '160', '480', '2018-01-12 10:02:28', '', '', '', '2018-01-12'),
(10, 'Sunphosate', '16', '80', '1280', 'ADMINISTRATOR', '4280', '400', '2018-01-12 10:23:12', '', '', '', '2018-01-12'),
(11, 'Sunphosate', '16', '10', '160', 'ADMINISTRATOR', '160', '390', '2018-01-12 10:25:20', '', '', '', '2018-01-12'),
(12, 'Sunphosate', '16', '10', '160', 'ADMINISTRATOR', '160', '380', '2018-01-12 11:31:30', 'ss', 'ss', 'ss', '2018-01-12'),
(13, 'Sunphosate', '16', '1', '16', 'ADMINISTRATOR', '16', '379', '2018-01-12 11:35:30', 'dACOS', '025', '0245558', '2018-01-12'),
(14, '1.5 Cabel', '40', '5', '200', 'ADMINISTRATOR', '50883', '184', '2018-01-12 12:16:55', 'Dacosta Agyenim Boateng', 'Hse No. ', '02455586', '2018-01-12');

-- Table `sellitem` --
CREATE TABLE `sellitem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemid` text NOT NULL,
  `itemname` text NOT NULL,
  `item_price` text NOT NULL,
  `quantity` text NOT NULL,
  `total_amount` text NOT NULL,
  `sell_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table `stocklist` --
CREATE TABLE `stocklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemname` text NOT NULL,
  `itemprice` text NOT NULL,
  `itemqty` text NOT NULL,
  `total` text NOT NULL,
  `itemdate` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `stocklist` (`id`, `itemname`, `itemprice`, `itemqty`, `total`, `itemdate`) VALUES
(1, 'Phone', '500', '200', '100000', '18th December, 2017'),
(2, 'Tv', '300', '300', '90000', '19th December, 2017'),
(3, '1.5 Cabel', '40', '200', '8000', '1st January, 2018'),
(4, 'Fufu', '3', '200', '600', '3rd January, 2018'),
(5, 'Sunphosate', '15', '500', '7500', '10th January, 2018');

-- Table `users` --
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` text NOT NULL,
  `fullname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `mobile` text NOT NULL,
  `address` text NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` varchar(3) NOT NULL DEFAULT 'yes',
  `login` varchar(3) NOT NULL DEFAULT 'no',
  `last_entry` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `user_id`, `fullname`, `username`, `password`, `mobile`, `address`, `add_date`, `active`, `login`, `last_entry`) VALUES
(0, 'ADMINISTRATOR', 'ADMINISTRATOR', 'adminis', '202cb962ac59075b964b07152d234b70', '0548157455', 'BOX 7', '2018-01-17 09:25:57', 'yes', 'yes', '17th January, 2018 -  8:25 AM'),
(1, '22223', 'Junior Baffour', 'junior', '7e4f882d2ea10f9f8a665f9d92e4087f', '05478788855', 'Goaso', '2018-01-01 15:52:35', 'yes', 'yes', '1st January, 2018 -  2:52 PM'),
(2, 'nico1', 'Obio Tetteh', 'oboi', '202cb962ac59075b964b07152d234b70', '0245858575', 'Goaso', '2018-01-15 23:05:01', 'yes', 'yes', '16th January, 2018 -  10:05 AM');

