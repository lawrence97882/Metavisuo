-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2019 at 02:35 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `majormco`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account` int(11) NOT NULL,
  `num` varchar(30) NOT NULL,
  `bank` varchar(30) DEFAULT NULL,
  `vendor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":3000,"cy":500}';

-- --------------------------------------------------------

--
-- Table structure for table `adjustment`
--

CREATE TABLE `adjustment` (
  `adjustment` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `date` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `amount` double DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":1000,"cy":200}';

-- --------------------------------------------------------

--
-- Table structure for table `charge`
--

CREATE TABLE `charge` (
  `charge` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `wconnection` int(11) NOT NULL,
  `invoice` int(11) NOT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":200,"cy":900}';

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `vendor` int(11) DEFAULT NULL,
  `zone` int(11) DEFAULT NULL,
  `code` varchar(30) DEFAULT NULL,
  `valid` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":1400,"cy":500}';

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client`, `user`, `vendor`, `zone`, `code`, `valid`) VALUES
(1, 3, 1, 1, 'KH001', 1),
(2, 2, 1, 2, 'mig05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `closing_balance`
--

CREATE TABLE `closing_balance` (
  `closing_balance` int(11) NOT NULL,
  `invoice` int(11) NOT NULL,
  `amount` double DEFAULT NULL,
  `initial` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{}';

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `invoice_1` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ref` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":1800,"cy":1800}';

-- --------------------------------------------------------

--
-- Table structure for table `msg`
--

CREATE TABLE `msg` (
  `msg` int(11) NOT NULL,
  `vendor` int(11) NOT NULL,
  `num` varchar(30) NOT NULL,
  `body` varchar(255) DEFAULT NULL,
  `auto` int(1) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":1800, "cy":150}';

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `date` date NOT NULL,
  `bank` varchar(30) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `ref` varchar(30) NOT NULL,
  `amount` double DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":500,"cy":100}';

-- --------------------------------------------------------

--
-- Table structure for table `reader`
--

CREATE TABLE `reader` (
  `reader` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `valid` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":2500,"cy":1200}';

--
-- Dumping data for table `reader`
--

INSERT INTO `reader` (`reader`, `user`, `valid`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `receiver`
--

CREATE TABLE `receiver` (
  `receiver` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `msg` int(11) NOT NULL,
  `valid` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":1400,"cy":100}';

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `auto` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":600,"cy":900}';

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `state` int(11) NOT NULL,
  `wconnection` int(11) NOT NULL,
  `date` date NOT NULL,
  `disconnection` int(1) NOT NULL,
  `wreading` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":1400,"cy":1200}';

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `subscription` int(11) NOT NULL,
  `wconnection` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":1000,"cy":900}';

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":2400, "cy":500}';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user`, `name`, `password`, `phone`, `email`, `id_no`, `address`) VALUES
(1, 'Elias msafiri', 'elias', '071234567', 'eliasmusafiri', '34526883', '6754'),
(2, 'eureka waters', '1234', '12345678', 'eureka', '345678', '1234'),
(3, 'Douglas', '1234', '071234567', 'DOUGLAS', '1234567', '3456');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `valid` int(1) NOT NULL,
  `code` varchar(30) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `business_no` varchar(30) DEFAULT NULL,
  `logo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":2500,"cy":150}';

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor`, `user`, `valid`, `code`, `price`, `business_no`, `logo`) VALUES
(1, 2, 1, 'eu', 130, '330768', 'eureka.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wconnection`
--

CREATE TABLE `wconnection` (
  `wconnection` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `meter_no` varchar(30) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":1400,"cy":900}';

--
-- Dumping data for table `wconnection`
--

INSERT INTO `wconnection` (`wconnection`, `client`, `meter_no`, `name`, `end_date`, `latitude`, `longitude`) VALUES
(1, 1, '45', 'douglas2', '2030-12-31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wconsumption`
--

CREATE TABLE `wconsumption` (
  `wconsumption` int(11) NOT NULL,
  `wconnection` int(11) NOT NULL,
  `invoice` int(11) NOT NULL,
  `prev_date` date DEFAULT NULL,
  `prev_value` int(5) DEFAULT NULL,
  `curr_value` int(5) DEFAULT NULL,
  `curr_date` date DEFAULT NULL,
  `price` double DEFAULT NULL,
  `units` int(5) DEFAULT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":1800,"cy":900}';

-- --------------------------------------------------------

--
-- Table structure for table `wreading`
--

CREATE TABLE `wreading` (
  `wreading` int(11) NOT NULL,
  `wconnection` int(11) NOT NULL,
  `reader` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `value` int(10) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":1800,"cy":1200}';

--
-- Dumping data for table `wreading`
--

INSERT INTO `wreading` (`wreading`, `wconnection`, `reader`, `date`, `value`, `latitude`, `longitude`, `timestamp`) VALUES
(1, 1, 1, '2019-06-01', 32, NULL, NULL, '2019-06-04 09:46:40'),
(6, 1, 1, '2019-06-03', 45, NULL, NULL, '2019-06-04 09:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `zone` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(30) DEFAULT NULL,
  `demarcation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='{"cx":600, "cy":500}';

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`zone`, `name`, `code`, `demarcation`) VALUES
(1, 'KAHUHO', 'KH', NULL),
(2, 'migon', 'mig', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account`),
  ADD UNIQUE KEY `id1` (`num`),
  ADD KEY `vendor` (`vendor`);

--
-- Indexes for table `adjustment`
--
ALTER TABLE `adjustment`
  ADD PRIMARY KEY (`adjustment`),
  ADD UNIQUE KEY `id2` (`client`,`date`,`reason`);

--
-- Indexes for table `charge`
--
ALTER TABLE `charge`
  ADD PRIMARY KEY (`charge`),
  ADD UNIQUE KEY `id3` (`wconnection`,`service`,`invoice`),
  ADD KEY `service` (`service`),
  ADD KEY `invoice` (`invoice`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client`),
  ADD UNIQUE KEY `id4` (`user`,`valid`),
  ADD KEY `vendor` (`vendor`),
  ADD KEY `zone` (`zone`);

--
-- Indexes for table `closing_balance`
--
ALTER TABLE `closing_balance`
  ADD PRIMARY KEY (`closing_balance`),
  ADD UNIQUE KEY `id5` (`invoice`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice`),
  ADD UNIQUE KEY `id6` (`client`,`timestamp`),
  ADD KEY `invoice_1` (`invoice_1`);

--
-- Indexes for table `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`msg`),
  ADD UNIQUE KEY `id7` (`vendor`,`num`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment`),
  ADD UNIQUE KEY `id8` (`client`,`date`,`ref`);

--
-- Indexes for table `reader`
--
ALTER TABLE `reader`
  ADD PRIMARY KEY (`reader`),
  ADD UNIQUE KEY `id9` (`user`,`valid`);

--
-- Indexes for table `receiver`
--
ALTER TABLE `receiver`
  ADD PRIMARY KEY (`receiver`),
  ADD UNIQUE KEY `id10` (`client`,`msg`,`valid`),
  ADD KEY `msg` (`msg`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service`),
  ADD UNIQUE KEY `id11` (`name`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`state`),
  ADD UNIQUE KEY `id12` (`wconnection`,`date`,`disconnection`),
  ADD KEY `wreading` (`wreading`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`subscription`),
  ADD UNIQUE KEY `id13` (`wconnection`,`service`),
  ADD KEY `service` (`service`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user`),
  ADD UNIQUE KEY `id14` (`name`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor`),
  ADD UNIQUE KEY `id15` (`user`,`valid`);

--
-- Indexes for table `wconnection`
--
ALTER TABLE `wconnection`
  ADD PRIMARY KEY (`wconnection`),
  ADD UNIQUE KEY `id16` (`client`,`meter_no`);

--
-- Indexes for table `wconsumption`
--
ALTER TABLE `wconsumption`
  ADD PRIMARY KEY (`wconsumption`),
  ADD UNIQUE KEY `id17` (`wconnection`,`invoice`),
  ADD KEY `invoice` (`invoice`);

--
-- Indexes for table `wreading`
--
ALTER TABLE `wreading`
  ADD PRIMARY KEY (`wreading`),
  ADD UNIQUE KEY `id18` (`date`,`wconnection`),
  ADD KEY `wconnection` (`wconnection`),
  ADD KEY `reader` (`reader`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`zone`),
  ADD UNIQUE KEY `id19` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adjustment`
--
ALTER TABLE `adjustment`
  MODIFY `adjustment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge`
--
ALTER TABLE `charge`
  MODIFY `charge` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `closing_balance`
--
ALTER TABLE `closing_balance`
  MODIFY `closing_balance` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `msg`
--
ALTER TABLE `msg`
  MODIFY `msg` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reader`
--
ALTER TABLE `reader`
  MODIFY `reader` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `receiver`
--
ALTER TABLE `receiver`
  MODIFY `receiver` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `state` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `subscription` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wconnection`
--
ALTER TABLE `wconnection`
  MODIFY `wconnection` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wconsumption`
--
ALTER TABLE `wconsumption`
  MODIFY `wconsumption` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wreading`
--
ALTER TABLE `wreading`
  MODIFY `wreading` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `zone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`vendor`) REFERENCES `vendor` (`vendor`);

--
-- Constraints for table `adjustment`
--
ALTER TABLE `adjustment`
  ADD CONSTRAINT `adjustment_ibfk_1` FOREIGN KEY (`client`) REFERENCES `client` (`client`);

--
-- Constraints for table `charge`
--
ALTER TABLE `charge`
  ADD CONSTRAINT `charge_ibfk_1` FOREIGN KEY (`service`) REFERENCES `service` (`service`),
  ADD CONSTRAINT `charge_ibfk_2` FOREIGN KEY (`wconnection`) REFERENCES `wconnection` (`wconnection`),
  ADD CONSTRAINT `charge_ibfk_3` FOREIGN KEY (`invoice`) REFERENCES `invoice` (`invoice`);

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`user`),
  ADD CONSTRAINT `client_ibfk_2` FOREIGN KEY (`vendor`) REFERENCES `vendor` (`vendor`),
  ADD CONSTRAINT `client_ibfk_3` FOREIGN KEY (`zone`) REFERENCES `zone` (`zone`);

--
-- Constraints for table `closing_balance`
--
ALTER TABLE `closing_balance`
  ADD CONSTRAINT `closing_balance_ibfk_1` FOREIGN KEY (`invoice`) REFERENCES `invoice` (`invoice`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`client`) REFERENCES `client` (`client`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`invoice_1`) REFERENCES `invoice` (`invoice`);

--
-- Constraints for table `msg`
--
ALTER TABLE `msg`
  ADD CONSTRAINT `msg_ibfk_1` FOREIGN KEY (`vendor`) REFERENCES `vendor` (`vendor`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`client`) REFERENCES `client` (`client`);

--
-- Constraints for table `reader`
--
ALTER TABLE `reader`
  ADD CONSTRAINT `reader_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`user`);

--
-- Constraints for table `receiver`
--
ALTER TABLE `receiver`
  ADD CONSTRAINT `receiver_ibfk_1` FOREIGN KEY (`client`) REFERENCES `client` (`client`),
  ADD CONSTRAINT `receiver_ibfk_2` FOREIGN KEY (`msg`) REFERENCES `msg` (`msg`);

--
-- Constraints for table `state`
--
ALTER TABLE `state`
  ADD CONSTRAINT `state_ibfk_1` FOREIGN KEY (`wconnection`) REFERENCES `wconnection` (`wconnection`),
  ADD CONSTRAINT `state_ibfk_2` FOREIGN KEY (`wreading`) REFERENCES `wreading` (`wreading`);

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`wconnection`) REFERENCES `wconnection` (`wconnection`),
  ADD CONSTRAINT `subscription_ibfk_2` FOREIGN KEY (`service`) REFERENCES `service` (`service`);

--
-- Constraints for table `vendor`
--
ALTER TABLE `vendor`
  ADD CONSTRAINT `vendor_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`user`);

--
-- Constraints for table `wconnection`
--
ALTER TABLE `wconnection`
  ADD CONSTRAINT `wconnection_ibfk_1` FOREIGN KEY (`client`) REFERENCES `client` (`client`);

--
-- Constraints for table `wconsumption`
--
ALTER TABLE `wconsumption`
  ADD CONSTRAINT `wconsumption_ibfk_1` FOREIGN KEY (`wconnection`) REFERENCES `wconnection` (`wconnection`),
  ADD CONSTRAINT `wconsumption_ibfk_2` FOREIGN KEY (`invoice`) REFERENCES `invoice` (`invoice`);

--
-- Constraints for table `wreading`
--
ALTER TABLE `wreading`
  ADD CONSTRAINT `wreading_ibfk_1` FOREIGN KEY (`wconnection`) REFERENCES `wconnection` (`wconnection`),
  ADD CONSTRAINT `wreading_ibfk_2` FOREIGN KEY (`reader`) REFERENCES `reader` (`reader`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
