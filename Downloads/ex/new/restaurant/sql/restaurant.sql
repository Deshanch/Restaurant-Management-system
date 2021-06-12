-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2020 at 01:57 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `cookingstaff`
--

CREATE TABLE `cookingstaff` (
  `EmployeeId` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cookingstaff`
--

INSERT INTO `cookingstaff` (`EmployeeId`) VALUES
('C1'),
('C2'),
('C3');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Bill_NO` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Payment` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Bill_NO`, `Date`, `Payment`) VALUES
(1001, '2020-03-11', '9500.00'),
(1002, '2020-04-11', '3200.00'),
(1003, '2020-06-11', '0.00'),
(1004, '2020-02-21', '3400.00'),
(1005, '2020-03-11', '3400.00'),
(1007, '2020-07-08', '0.00'),
(1008, '2020-07-08', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `customerbuys`
--

CREATE TABLE `customerbuys` (
  `Bill_NO` int(11) NOT NULL,
  `F_NO` varchar(10) NOT NULL,
  `Qunatity` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Time` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customerbuys`
--

INSERT INTO `customerbuys` (`Bill_NO`, `F_NO`, `Qunatity`, `Price`, `Time`) VALUES
(1001, 'F001', 2, '500.00', '2020-07-09'),
(1001, 'F005', 4, '250.00', '2020-07-09');

-- --------------------------------------------------------

--
-- Table structure for table `delivering`
--

CREATE TABLE `delivering` (
  `Bill_NO` int(11) NOT NULL,
  `EMP_ID` varchar(10) DEFAULT NULL,
  `Amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delivering`
--

INSERT INTO `delivering` (`Bill_NO`, `EMP_ID`, `Amount`) VALUES
(1002, 'D2', 4),
(1007, 'D3', 5);

-- --------------------------------------------------------

--
-- Table structure for table `deliveryboy`
--

CREATE TABLE `deliveryboy` (
  `EmployeeId` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deliveryboy`
--

INSERT INTO `deliveryboy` (`EmployeeId`) VALUES
('D1'),
('D2'),
('D3');

-- --------------------------------------------------------

--
-- Table structure for table `dine_in`
--

CREATE TABLE `dine_in` (
  `Bill_NO` int(11) NOT NULL,
  `Emp_ID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dine_in`
--

INSERT INTO `dine_in` (`Bill_NO`, `Emp_ID`) VALUES
(1003, 'W1'),
(1004, 'W1');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EmployeeId` varchar(10) NOT NULL,
  `FName` varchar(15) DEFAULT NULL,
  `LName` varchar(20) DEFAULT NULL,
  `DOB` date NOT NULL,
  `Salary` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmployeeId`, `FName`, `LName`, `DOB`, `Salary`) VALUES
('C1', 'Pasan', 'Lakshan', '1997-08-01', '26000.00'),
('C2', 'Roshini', 'Lakshani', '1997-06-11', '25000.00'),
('C3', 'Suranga', 'Priyasad', '1996-04-09', '15000.00'),
('D1', 'Milan', 'Deepashan', '1996-06-15', '26000.00'),
('D2', 'Lasith', 'Bandara', '1997-06-16', '26000.00'),
('D3', 'Jayantha', 'Priyasad', '1997-04-11', '25000.00'),
('W1', 'Oshanda', 'Dias', '1997-06-12', '20000.00'),
('W2', 'Roshan', 'Pranandu', '1995-04-11', '23000.00'),
('W3', 'Suranga', 'Pranandu', '1995-04-23', '22000.00');

-- --------------------------------------------------------

--
-- Table structure for table `foodbeverages`
--

CREATE TABLE `foodbeverages` (
  `F_NO` varchar(10) NOT NULL,
  `Item` varchar(30) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Availability` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foodbeverages`
--

INSERT INTO `foodbeverages` (`F_NO`, `Item`, `Price`, `Availability`) VALUES
('F001', 'Fried Rice', '400.00', 1000),
('F002', 'Kottu', '400.00', 80),
('F003', 'Vegetable Chopsuey', '200.00', 1000),
('F004', 'Sea food', '800.00', 40),
('F005', 'Buriani', '250.00', 88);

-- --------------------------------------------------------

--
-- Table structure for table `prepare`
--

CREATE TABLE `prepare` (
  `I_NO` varchar(10) NOT NULL,
  `F_NO` varchar(10) NOT NULL,
  `Amount` int(11) DEFAULT NULL,
  `food_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prepare`
--

INSERT INTO `prepare` (`I_NO`, `F_NO`, `Amount`, `food_amount`) VALUES
('I001', 'F001', 10, 100),
('I002', 'F001', 10, 100),
('I002', 'F002', 40, 100),
('I003', 'F001', 60, 100),
('I003', 'F002', 70, 100),
('I003', 'F003', 55, 100),
('I006', 'F001', 90, 100),
('I006', 'F003', 40, 100),
('I007', 'F004', 60, 100),
('I010', 'F001', 10, 100),
('I011', 'F001', 40, 100);

-- --------------------------------------------------------

--
-- Table structure for table `rawmaterial`
--

CREATE TABLE `rawmaterial` (
  `I_NO` varchar(10) NOT NULL,
  `ItemName` varchar(30) DEFAULT NULL,
  `avalibility` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rawmaterial`
--

INSERT INTO `rawmaterial` (`I_NO`, `ItemName`, `avalibility`) VALUES
('I001', 'rice', 35),
('I002', 'flour', 10),
('I003', 'vegetables', 5),
('I005', 'fruits', 140),
('I006', 'flavours', 50),
('I007', 'bread and bun packs', 15),
('I008', 'noodles Kg', 20),
('I009', 'spaghetti Kg', 15),
('I010', 'pasta Kg', 20),
('I011', 'cheese 500g', 10),
('I012', 'Butter', 50),
('I013', 'Mushroom', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `S_ID` varchar(10) NOT NULL,
  `Name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`S_ID`, `Name`) VALUES
('S001', 'Nipuna Rice Mills'),
('S003', 'jeewika vegetable Exporters'),
('S004', 'Bairaha Farms PLC'),
('S005', 'kelum fruitz'),
('S006', 'Wijitha (Pvt) Ltd'),
('S007', 'Food corner supercenter'),
('S008', 'Araliya Rice'),
('S009', 'karu brothers suplliers'),
('S010', 'Ranco Dairy Products (pvt) ltd'),
('S011', 'Blue Line Caterers Pvt.Ltd'),
('S012', 'Finagle Lanka (Pvt) Ltd'),
('S013', 'Prabatha foods');

-- --------------------------------------------------------

--
-- Table structure for table `supply`
--

CREATE TABLE `supply` (
  `supply_NO` int(11) NOT NULL,
  `SS_ID` varchar(10) NOT NULL,
  `II_NO` varchar(10) NOT NULL,
  `Payment` decimal(10,2) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supply`
--

INSERT INTO `supply` (`supply_NO`, `SS_ID`, `II_NO`, `Payment`, `Quantity`, `Date`) VALUES
(45, 'S001', 'I001', '5000.00', 50, '2020-01-15'),
(47, 'S003', 'I003', '9000.00', 25, '2020-06-15'),
(50, 'S012', 'I007', '2500.00', 25, '2020-06-15'),
(52, 'S011', 'I009', '2000.00', 25, '2020-06-16'),
(53, 'S011', 'I010', '2000.00', 25, '2020-06-16'),
(54, 'S005', 'I005', '39000.00', 10, '2020-06-16'),
(55, 'S006', 'I006', '27360.00', 150, '2020-06-16'),
(58, 'S010', 'I011', '12000.00', 10, '2020-06-16'),
(60, 'S001', 'I001', '5000.00', 50, '2020-01-19'),
(61, 'S008', 'I001', '3150.00', 30, '2020-06-19'),
(62, 'S003', 'I003', '9000.00', 25, '2020-06-19'),
(67, 'S012', 'I005', '2000.00', 60, '2020-07-09'),
(68, 'S012', 'I005', '5000.00', 60, '2020-07-09'),
(69, 'S012', 'I005', '5000.00', 60, '2020-07-09');

-- --------------------------------------------------------

--
-- Table structure for table `take_away`
--

CREATE TABLE `take_away` (
  `Bill_NO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `take_away`
--

INSERT INTO `take_away` (`Bill_NO`) VALUES
(1005),
(1008);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `last_login` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `last_login`, `is_deleted`) VALUES
(1, 'Vikum', 'Ravihansa', 'viki@gmail.com', 'ea0c04513c32717f3a09ff7b1fa882c4d8424b2a', '0000-00-00 00:00:00', 1),
(2, 'Nipuna', 'Madubashana', 'nipu@gmail.com', 'a22df3cc7c282365512bd0377c55de46b30cbce5', '0000-00-00 00:00:00', 0),
(3, 'Thaja', 'Manoharee', 'thejaa@gmail.com', 'cdef79d2ca875d8b85dbd19f8c473ccf51e09502', '0000-00-00 00:00:00', 1),
(4, 'Ajan', 'Sri Sheheran', 'ajan@gmail.com', '23ace7331ef30c45051de4e683719db7391b9980', '0000-00-00 00:00:00', 1),
(5, 'Binary', 'Shashipraba', 'binary@gmail.com', '1addf1d86143ea21f2396d9efed7079fd5307b4d', '0000-00-00 00:00:00', 0),
(6, 'Peshala', 'Sachintha', 'peshala@gmail.com', 'c42a409d5603d4c661d79089164e531e6367b62f', '0000-00-00 00:00:00', 1),
(8, 'Chamli', 'Deshan', 'chamli@gmail.com', 'c8eaef9bbd83c8b7e6d18a5c286f8dedb028f558', '2020-05-02 12:40:16', 1),
(9, 'Amal', 'udayakantha', 'amal@gmail.com', '7a671c37cb54c6697b951e2d1519f2d53de2e78f', '2020-07-10 17:26:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `waiter`
--

CREATE TABLE `waiter` (
  `EmployeeId` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `waiter`
--

INSERT INTO `waiter` (`EmployeeId`) VALUES
('W1'),
('W2'),
('W3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cookingstaff`
--
ALTER TABLE `cookingstaff`
  ADD PRIMARY KEY (`EmployeeId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Bill_NO`);

--
-- Indexes for table `customerbuys`
--
ALTER TABLE `customerbuys`
  ADD PRIMARY KEY (`Bill_NO`,`F_NO`),
  ADD KEY `FK_FoodBeveragesCustomerbuys` (`F_NO`);

--
-- Indexes for table `delivering`
--
ALTER TABLE `delivering`
  ADD PRIMARY KEY (`Bill_NO`),
  ADD KEY `FK_deliveryBoy_delivering` (`EMP_ID`);

--
-- Indexes for table `deliveryboy`
--
ALTER TABLE `deliveryboy`
  ADD PRIMARY KEY (`EmployeeId`);

--
-- Indexes for table `dine_in`
--
ALTER TABLE `dine_in`
  ADD PRIMARY KEY (`Bill_NO`),
  ADD KEY `FK_WaiterDineIn` (`Emp_ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeId`);

--
-- Indexes for table `foodbeverages`
--
ALTER TABLE `foodbeverages`
  ADD PRIMARY KEY (`F_NO`);

--
-- Indexes for table `prepare`
--
ALTER TABLE `prepare`
  ADD PRIMARY KEY (`I_NO`,`F_NO`),
  ADD KEY `FK_FoodBeverages_Prepare` (`F_NO`);

--
-- Indexes for table `rawmaterial`
--
ALTER TABLE `rawmaterial`
  ADD PRIMARY KEY (`I_NO`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`S_ID`);

--
-- Indexes for table `supply`
--
ALTER TABLE `supply`
  ADD PRIMARY KEY (`supply_NO`),
  ADD KEY `FK_Supplier_Supply` (`SS_ID`),
  ADD KEY `FK_RawMaterial_Supply` (`II_NO`);

--
-- Indexes for table `take_away`
--
ALTER TABLE `take_away`
  ADD PRIMARY KEY (`Bill_NO`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waiter`
--
ALTER TABLE `waiter`
  ADD PRIMARY KEY (`EmployeeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `supply`
--
ALTER TABLE `supply`
  MODIFY `supply_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cookingstaff`
--
ALTER TABLE `cookingstaff`
  ADD CONSTRAINT `FK_EmployeeCookingStaff` FOREIGN KEY (`EmployeeId`) REFERENCES `employee` (`EmployeeId`);

--
-- Constraints for table `customerbuys`
--
ALTER TABLE `customerbuys`
  ADD CONSTRAINT `FK_CustomerCustomerbuys` FOREIGN KEY (`Bill_NO`) REFERENCES `customer` (`Bill_NO`),
  ADD CONSTRAINT `FK_FoodBeveragesCustomerbuys` FOREIGN KEY (`F_NO`) REFERENCES `foodbeverages` (`F_NO`);

--
-- Constraints for table `delivering`
--
ALTER TABLE `delivering`
  ADD CONSTRAINT `FK_customer_delivering` FOREIGN KEY (`Bill_NO`) REFERENCES `customer` (`Bill_NO`),
  ADD CONSTRAINT `FK_deliveryBoy_delivering` FOREIGN KEY (`EMP_ID`) REFERENCES `deliveryboy` (`EmployeeId`);

--
-- Constraints for table `deliveryboy`
--
ALTER TABLE `deliveryboy`
  ADD CONSTRAINT `FK_EmployeeDeliveryBoy` FOREIGN KEY (`EmployeeId`) REFERENCES `employee` (`EmployeeId`);

--
-- Constraints for table `dine_in`
--
ALTER TABLE `dine_in`
  ADD CONSTRAINT `FK_CustomerDineIn` FOREIGN KEY (`Bill_NO`) REFERENCES `customer` (`Bill_NO`),
  ADD CONSTRAINT `FK_WaiterDineIn` FOREIGN KEY (`Emp_ID`) REFERENCES `waiter` (`EmployeeId`);

--
-- Constraints for table `prepare`
--
ALTER TABLE `prepare`
  ADD CONSTRAINT `FK_FoodBeverages_Prepare` FOREIGN KEY (`F_NO`) REFERENCES `foodbeverages` (`F_NO`),
  ADD CONSTRAINT `FK_RawMaterial_Prepare` FOREIGN KEY (`I_NO`) REFERENCES `rawmaterial` (`I_NO`);

--
-- Constraints for table `supply`
--
ALTER TABLE `supply`
  ADD CONSTRAINT `FK_RawMaterial_Supply` FOREIGN KEY (`II_NO`) REFERENCES `rawmaterial` (`I_NO`),
  ADD CONSTRAINT `FK_Supplier_Supply` FOREIGN KEY (`SS_ID`) REFERENCES `supplier` (`S_ID`);

--
-- Constraints for table `take_away`
--
ALTER TABLE `take_away`
  ADD CONSTRAINT `FK_customer_takeAway` FOREIGN KEY (`Bill_NO`) REFERENCES `customer` (`Bill_NO`);

--
-- Constraints for table `waiter`
--
ALTER TABLE `waiter`
  ADD CONSTRAINT `FK_EmployeeWaiter` FOREIGN KEY (`EmployeeId`) REFERENCES `employee` (`EmployeeId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
