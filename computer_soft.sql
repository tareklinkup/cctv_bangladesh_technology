-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 21, 2022 at 08:52 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `computer_soft`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

DROP TABLE IF EXISTS `tbl_account`;
CREATE TABLE IF NOT EXISTS `tbl_account` (
  `Acc_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `Acc_Code` varchar(50) NOT NULL,
  `Acc_Tr_Type` varchar(25) DEFAULT NULL,
  `Acc_Name` varchar(200) NOT NULL,
  `Acc_Type` varchar(50) NOT NULL,
  `Acc_Description` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Acc_SlNo`),
  KEY `branch_id` (`branch_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assets`
--

DROP TABLE IF EXISTS `tbl_assets`;
CREATE TABLE IF NOT EXISTS `tbl_assets` (
  `as_id` int(11) NOT NULL AUTO_INCREMENT,
  `as_date` date DEFAULT NULL,
  `as_name` varchar(50) DEFAULT NULL,
  `as_sp_name` varchar(100) DEFAULT NULL,
  `as_qty` int(11) DEFAULT NULL,
  `as_rate` decimal(10,2) DEFAULT NULL,
  `as_amount` decimal(10,2) DEFAULT NULL,
  `buy_or_sale` enum('buy','sale') NOT NULL DEFAULT 'buy',
  `valuation` decimal(20,2) DEFAULT 0.00,
  `unit_valuation` decimal(20,2) DEFAULT 0.00,
  `as_note` text DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `branchid` int(11) DEFAULT NULL,
  PRIMARY KEY (`as_id`),
  KEY `as_date` (`as_date`),
  KEY `status` (`status`),
  KEY `branchid` (`branchid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank_accounts`
--

DROP TABLE IF EXISTS `tbl_bank_accounts`;
CREATE TABLE IF NOT EXISTS `tbl_bank_accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(500) NOT NULL,
  `account_number` varchar(250) NOT NULL,
  `account_type` varchar(200) NOT NULL,
  `bank_name` varchar(250) NOT NULL,
  `branch_name` varchar(250) DEFAULT NULL,
  `initial_balance` float NOT NULL,
  `description` varchar(2000) NOT NULL,
  `saved_by` int(11) NOT NULL,
  `saved_datetime` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`account_id`),
  KEY `branch_id` (`branch_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank_transactions`
--

DROP TABLE IF EXISTS `tbl_bank_transactions`;
CREATE TABLE IF NOT EXISTS `tbl_bank_transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `transaction_type` varchar(10) NOT NULL,
  `amount` float NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `saved_by` int(11) NOT NULL,
  `saved_datetime` datetime NOT NULL,
  `branch_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`transaction_id`),
  KEY `account_id` (`account_id`),
  KEY `transaction_date` (`transaction_date`),
  KEY `transaction_type` (`transaction_type`),
  KEY `branch_id` (`branch_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

DROP TABLE IF EXISTS `tbl_brand`;
CREATE TABLE IF NOT EXISTS `tbl_brand` (
  `brand_SiNo` int(11) NOT NULL AUTO_INCREMENT,
  `ProductCategory_SlNo` int(11) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `status` char(2) NOT NULL,
  `brand_branchid` int(11) NOT NULL,
  PRIMARY KEY (`brand_SiNo`),
  KEY `ProductCategory_SlNo` (`ProductCategory_SlNo`),
  KEY `status` (`status`),
  KEY `brand_branchid` (`brand_branchid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brunch`
--

DROP TABLE IF EXISTS `tbl_brunch`;
CREATE TABLE IF NOT EXISTS `tbl_brunch` (
  `brunch_id` int(11) NOT NULL AUTO_INCREMENT,
  `Brunch_name` varchar(250) CHARACTER SET utf8 NOT NULL,
  `Brunch_title` varchar(250) CHARACTER SET utf8 NOT NULL,
  `Brunch_address` text CHARACTER SET utf8 NOT NULL,
  `Brunch_sales` varchar(1) NOT NULL COMMENT 'Wholesales = 1, Retail = 2',
  `add_date` date NOT NULL,
  `add_time` datetime NOT NULL,
  `add_by` char(50) NOT NULL,
  `update_by` char(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`brunch_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_brunch`
--

INSERT INTO `tbl_brunch` (`brunch_id`, `Brunch_name`, `Brunch_title`, `Brunch_address`, `Brunch_sales`, `add_date`, `add_time`, `add_by`, `update_by`, `status`) VALUES
(1, 'Main Branch', 'Main Branch', 'Branch address here', '', '2022-03-20', '2022-03-20 19:01:07', '', '', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashtransaction`
--

DROP TABLE IF EXISTS `tbl_cashtransaction`;
CREATE TABLE IF NOT EXISTS `tbl_cashtransaction` (
  `Tr_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Tr_Id` varchar(50) NOT NULL,
  `Tr_date` date NOT NULL,
  `Tr_Type` varchar(20) NOT NULL,
  `Tr_account_Type` varchar(50) NOT NULL,
  `Acc_SlID` int(11) NOT NULL,
  `Tr_Description` varchar(255) NOT NULL,
  `In_Amount` decimal(18,2) NOT NULL,
  `Out_Amount` decimal(18,2) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(100) NOT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Tr_branchid` int(11) NOT NULL,
  PRIMARY KEY (`Tr_SlNo`),
  KEY `Tr_SlNo` (`Tr_SlNo`),
  KEY `Tr_Id` (`Tr_Id`),
  KEY `Tr_date` (`Tr_date`),
  KEY `Tr_Type` (`Tr_Type`),
  KEY `Acc_SlID` (`Acc_SlID`),
  KEY `status` (`status`),
  KEY `Tr_branchid` (`Tr_branchid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_checks`
--

DROP TABLE IF EXISTS `tbl_checks`;
CREATE TABLE IF NOT EXISTS `tbl_checks` (
  `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cus_id` int(20) DEFAULT NULL,
  `SM_id` int(20) UNSIGNED DEFAULT NULL,
  `bank_name` varchar(250) DEFAULT NULL,
  `branch_name` varchar(250) DEFAULT NULL,
  `check_no` varchar(250) DEFAULT NULL,
  `check_amount` decimal(18,2) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `check_date` timestamp NULL DEFAULT NULL,
  `remid_date` timestamp NULL DEFAULT NULL,
  `sub_date` timestamp NULL DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `check_status` char(5) DEFAULT 'Pe' COMMENT 'Pe =Pending, Pa = Paid',
  `status` char(5) NOT NULL DEFAULT 'a',
  `created_by` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `branch_id` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cus_id` (`cus_id`),
  KEY `SM_id` (`SM_id`),
  KEY `date` (`date`),
  KEY `remid_date` (`remid_date`),
  KEY `check_status` (`check_status`),
  KEY `status` (`status`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_color`
--

DROP TABLE IF EXISTS `tbl_color`;
CREATE TABLE IF NOT EXISTS `tbl_color` (
  `color_SiNo` int(11) NOT NULL AUTO_INCREMENT,
  `color_name` varchar(100) NOT NULL,
  `status` char(2) NOT NULL,
  PRIMARY KEY (`color_SiNo`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company`
--

DROP TABLE IF EXISTS `tbl_company`;
CREATE TABLE IF NOT EXISTS `tbl_company` (
  `Company_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Company_Name` varchar(150) NOT NULL,
  `Repot_Heading` text NOT NULL,
  `Company_Logo_org` varchar(250) NOT NULL,
  `Company_Logo_thum` varchar(250) NOT NULL,
  `Invoice_Type` int(11) NOT NULL,
  `Currency_Name` varchar(50) DEFAULT NULL,
  `Currency_Symbol` varchar(10) DEFAULT NULL,
  `SubCurrency_Name` varchar(50) DEFAULT NULL,
  `print_type` int(11) NOT NULL,
  `company_BrunchId` int(11) NOT NULL,
  PRIMARY KEY (`Company_SlNo`),
  KEY `Invoice_Type` (`Invoice_Type`),
  KEY `print_type` (`print_type`),
  KEY `company_BrunchId` (`company_BrunchId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_company`
--

INSERT INTO `tbl_company` (`Company_SlNo`, `Company_Name`, `Repot_Heading`, `Company_Logo_org`, `Company_Logo_thum`, `Invoice_Type`, `Currency_Name`, `Currency_Symbol`, `SubCurrency_Name`, `print_type`, `company_BrunchId`) VALUES
(1, 'Computer Software', 'Address and phone number here', '', '', 1, 'BDT', NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_country`
--

DROP TABLE IF EXISTS `tbl_country`;
CREATE TABLE IF NOT EXISTS `tbl_country` (
  `Country_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `CountryName` varchar(50) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Country_SlNo`),
  KEY `Status` (`Status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currentinventory`
--

DROP TABLE IF EXISTS `tbl_currentinventory`;
CREATE TABLE IF NOT EXISTS `tbl_currentinventory` (
  `inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `purchase_quantity` float NOT NULL,
  `purchase_return_quantity` float NOT NULL,
  `sales_quantity` float NOT NULL,
  `sales_return_quantity` float NOT NULL,
  `damage_quantity` float NOT NULL,
  `transfer_from_quantity` float NOT NULL,
  `transfer_to_quantity` float NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`inventory_id`),
  KEY `product_id` (`product_id`),
  KEY `transfer_from_quantity` (`transfer_from_quantity`),
  KEY `transfer_to_quantity` (`transfer_to_quantity`),
  KEY `branch_id` (`branch_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_currentinventory`
--

INSERT INTO `tbl_currentinventory` (`inventory_id`, `product_id`, `purchase_quantity`, `purchase_return_quantity`, `sales_quantity`, `sales_return_quantity`, `damage_quantity`, `transfer_from_quantity`, `transfer_to_quantity`, `branch_id`) VALUES
(1, 1, 21, 0, 1, 0, 0, 0, 0, 1),
(2, 2, 20, 2, 6, 0, 0, 0, 0, 1),
(3, 5, 15, 0, 10, 0, 0, 0, 0, 1),
(4, 4, 15, 0, 2, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

DROP TABLE IF EXISTS `tbl_customer`;
CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `Customer_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Customer_Code` varchar(50) NOT NULL,
  `Customer_Name` varchar(150) NOT NULL,
  `Customer_Type` varchar(50) NOT NULL,
  `Customer_Phone` varchar(50) NOT NULL,
  `Customer_Mobile` varchar(15) NOT NULL,
  `Customer_Email` varchar(50) NOT NULL,
  `Customer_OfficePhone` varchar(50) NOT NULL,
  `Customer_Address` varchar(300) NOT NULL,
  `owner_name` varchar(250) DEFAULT NULL,
  `Country_SlNo` int(11) NOT NULL,
  `area_ID` int(11) NOT NULL,
  `Customer_Web` varchar(50) NOT NULL,
  `Customer_Credit_Limit` decimal(18,2) NOT NULL,
  `previous_due` decimal(18,2) NOT NULL,
  `image_name` varchar(1000) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Customer_brunchid` int(11) NOT NULL,
  PRIMARY KEY (`Customer_SlNo`),
  KEY `Customer_Code` (`Customer_Code`),
  KEY `Customer_Mobile` (`Customer_Mobile`),
  KEY `Customer_Type` (`Customer_Type`),
  KEY `Country_SlNo` (`Country_SlNo`),
  KEY `area_ID` (`area_ID`),
  KEY `status` (`status`),
  KEY `Customer_brunchid` (`Customer_brunchid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`Customer_SlNo`, `Customer_Code`, `Customer_Name`, `Customer_Type`, `Customer_Phone`, `Customer_Mobile`, `Customer_Email`, `Customer_OfficePhone`, `Customer_Address`, `owner_name`, `Country_SlNo`, `area_ID`, `Customer_Web`, `Customer_Credit_Limit`, `previous_due`, `image_name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Customer_brunchid`) VALUES
(1, 'C00001', 'Md Jakirul Isalm', 'retail', '', '01911978897', '', '', 'mirpur', 'Mozammel Hossain', 0, 1, '', '10000.00', '0.00', NULL, 'a', 'Admin', '2022-03-20 19:09:58', NULL, NULL, 1),
(2, 'C00002', 'Mr. X', 'G', '', '017', '', '', 'mirpur', NULL, 0, 0, '', '0.00', '0.00', NULL, 'a', 'Admin', '2022-03-21 14:28:37', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_payment`
--

DROP TABLE IF EXISTS `tbl_customer_payment`;
CREATE TABLE IF NOT EXISTS `tbl_customer_payment` (
  `CPayment_id` int(11) NOT NULL AUTO_INCREMENT,
  `CPayment_date` date DEFAULT NULL,
  `CPayment_invoice` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_customerID` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_TransactionType` varchar(20) DEFAULT NULL,
  `CPayment_amount` decimal(18,2) DEFAULT NULL,
  `out_amount` float NOT NULL DEFAULT 0,
  `CPayment_Paymentby` varchar(50) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `CPayment_notes` varchar(225) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_brunchid` int(11) DEFAULT NULL,
  `CPayment_previous_due` float NOT NULL DEFAULT 0,
  `CPayment_Addby` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_AddDAte` date DEFAULT NULL,
  `CPayment_status` varchar(1) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `CPayment_UpdateDAte` date DEFAULT NULL,
  PRIMARY KEY (`CPayment_id`),
  KEY `CPayment_date` (`CPayment_date`),
  KEY `CPayment_invoice` (`CPayment_invoice`),
  KEY `CPayment_customerID` (`CPayment_customerID`),
  KEY `CPayment_TransactionType` (`CPayment_TransactionType`),
  KEY `account_id` (`account_id`),
  KEY `CPayment_brunchid` (`CPayment_brunchid`),
  KEY `CPayment_status` (`CPayment_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_damage`
--

DROP TABLE IF EXISTS `tbl_damage`;
CREATE TABLE IF NOT EXISTS `tbl_damage` (
  `Damage_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Damage_InvoiceNo` varchar(50) NOT NULL,
  `Damage_Date` date NOT NULL,
  `Damage_Description` varchar(300) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Damage_brunchid` int(11) NOT NULL,
  PRIMARY KEY (`Damage_SlNo`),
  KEY `Damage_InvoiceNo` (`Damage_InvoiceNo`),
  KEY `Damage_Date` (`Damage_Date`),
  KEY `status` (`status`),
  KEY `Damage_brunchid` (`Damage_brunchid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_damagedetails`
--

DROP TABLE IF EXISTS `tbl_damagedetails`;
CREATE TABLE IF NOT EXISTS `tbl_damagedetails` (
  `DamageDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Damage_SlNo` int(11) NOT NULL,
  `Product_SlNo` int(11) NOT NULL,
  `DamageDetails_DamageQuantity` float NOT NULL,
  `damage_rate` float NOT NULL,
  `damage_amount` float NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`DamageDetails_SlNo`),
  KEY `Damage_SlNo` (`Damage_SlNo`),
  KEY `Product_SlNo` (`Product_SlNo`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

DROP TABLE IF EXISTS `tbl_department`;
CREATE TABLE IF NOT EXISTS `tbl_department` (
  `Department_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Department_Name` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Department_SlNo`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designation`
--

DROP TABLE IF EXISTS `tbl_designation`;
CREATE TABLE IF NOT EXISTS `tbl_designation` (
  `Designation_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Designation_Name` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Designation_SlNo`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_district`
--

DROP TABLE IF EXISTS `tbl_district`;
CREATE TABLE IF NOT EXISTS `tbl_district` (
  `District_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `District_Name` varchar(50) NOT NULL,
  `status` char(10) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`District_SlNo`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_district`
--

INSERT INTO `tbl_district` (`District_SlNo`, `District_Name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 'Dhaka', 'a', 'Admin', '2022-03-20 19:04:58', NULL, NULL),
(2, 'Bogura', 'a', 'Admin', '2022-03-20 19:05:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

DROP TABLE IF EXISTS `tbl_employee`;
CREATE TABLE IF NOT EXISTS `tbl_employee` (
  `Employee_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Designation_ID` int(11) NOT NULL,
  `Department_ID` int(11) NOT NULL,
  `Employee_ID` varchar(50) NOT NULL,
  `Employee_Name` varchar(150) NOT NULL,
  `Employee_JoinDate` date NOT NULL,
  `Employee_Gender` varchar(20) NOT NULL,
  `Employee_BirthDate` date NOT NULL,
  `Employee_NID` varchar(50) NOT NULL,
  `Employee_ContactNo` varchar(20) NOT NULL,
  `Employee_Email` varchar(50) NOT NULL,
  `Employee_MaritalStatus` varchar(50) NOT NULL,
  `Employee_FatherName` varchar(150) NOT NULL,
  `Employee_MotherName` varchar(150) NOT NULL,
  `Employee_PrasentAddress` text NOT NULL,
  `Employee_PermanentAddress` text NOT NULL,
  `Employee_Pic_org` varchar(250) NOT NULL,
  `Employee_Pic_thum` varchar(250) NOT NULL,
  `salary_range` int(11) NOT NULL,
  `Employee_Reference` text DEFAULT NULL,
  `status` char(10) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) NOT NULL,
  `AddTime` varchar(50) NOT NULL,
  `UpdateBy` varchar(50) NOT NULL,
  `UpdateTime` varchar(50) NOT NULL,
  `Employee_brinchid` int(11) NOT NULL,
  PRIMARY KEY (`Employee_SlNo`),
  KEY `Designation_ID` (`Designation_ID`),
  KEY `Department_ID` (`Department_ID`),
  KEY `Employee_ID` (`Employee_ID`),
  KEY `status` (`status`),
  KEY `Employee_brinchid` (`Employee_brinchid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_payment`
--

DROP TABLE IF EXISTS `tbl_employee_payment`;
CREATE TABLE IF NOT EXISTS `tbl_employee_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_date` date DEFAULT NULL,
  `month_id` int(11) NOT NULL,
  `total_payment_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `status` char(2) DEFAULT 'a',
  `saved_by` int(11) NOT NULL,
  `saved_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_date` (`payment_date`),
  KEY `month_id` (`month_id`),
  KEY `status` (`status`),
  KEY `paymentBranch_id` (`branch_id`),
  KEY `saved_by` (`saved_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_payment_details`
--

DROP TABLE IF EXISTS `tbl_employee_payment_details`;
CREATE TABLE IF NOT EXISTS `tbl_employee_payment_details` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `salary` decimal(20,2) NOT NULL DEFAULT 0.00,
  `benefit` decimal(20,2) NOT NULL DEFAULT 0.00,
  `deduction` decimal(20,2) NOT NULL DEFAULT 0.00,
  `net_payable` decimal(20,2) NOT NULL DEFAULT 0.00,
  `payment` decimal(20,2) NOT NULL DEFAULT 0.00,
  `comment` text DEFAULT NULL,
  `saved_by` int(11) UNSIGNED DEFAULT NULL,
  `saved_at` datetime DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` char(2) NOT NULL DEFAULT 'a',
  `branch_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE,
  KEY `branch_id` (`branch_id`) USING BTREE,
  KEY `payment_id` (`payment_id`) USING BTREE,
  KEY `employee_id` (`employee_id`) USING BTREE,
  KEY `saved_by` (`saved_by`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenses`
--

DROP TABLE IF EXISTS `tbl_expenses`;
CREATE TABLE IF NOT EXISTS `tbl_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `rate` decimal(18,2) NOT NULL DEFAULT 0.00,
  `status` varchar(1) NOT NULL,
  `added_by` varchar(30) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `update_by` varchar(30) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_expenses`
--

INSERT INTO `tbl_expenses` (`id`, `name`, `rate`, `status`, `added_by`, `add_time`, `update_by`, `update_time`, `branch_id`) VALUES
(1, 'Back Part', '100.00', 'a', 'Admin', '2022-03-20 21:31:55', NULL, NULL, 1),
(2, 'Screen protector', '80.00', 'a', 'Admin', '2022-03-20 21:32:15', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_head`
--

DROP TABLE IF EXISTS `tbl_expense_head`;
CREATE TABLE IF NOT EXISTS `tbl_expense_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head_name` varchar(100) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `status` enum('a','d') DEFAULT 'a',
  `saved_by` int(11) DEFAULT NULL,
  `saved_datetime` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_investment_account`
--

DROP TABLE IF EXISTS `tbl_investment_account`;
CREATE TABLE IF NOT EXISTS `tbl_investment_account` (
  `Acc_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `Acc_Code` varchar(50) NOT NULL,
  `Acc_Tr_Type` varchar(25) DEFAULT NULL,
  `Acc_Name` varchar(200) NOT NULL,
  `Acc_Type` varchar(50) NOT NULL,
  `Acc_Description` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Acc_SlNo`),
  KEY `status` (`status`) USING BTREE,
  KEY `branch_id` (`branch_id`) USING BTREE,
  KEY `Acc_Code` (`Acc_Code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_investment_transactions`
--

DROP TABLE IF EXISTS `tbl_investment_transactions`;
CREATE TABLE IF NOT EXISTS `tbl_investment_transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `transaction_type` varchar(10) NOT NULL,
  `amount` float NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `saved_by` int(11) NOT NULL,
  `saved_datetime` datetime NOT NULL,
  `branch_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`transaction_id`),
  KEY `transaction_date` (`transaction_date`),
  KEY `transaction_type` (`transaction_type`),
  KEY `status` (`status`),
  KEY `saved_by` (`saved_by`) USING BTREE,
  KEY `account_id` (`account_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_loan_accounts`
--

DROP TABLE IF EXISTS `tbl_loan_accounts`;
CREATE TABLE IF NOT EXISTS `tbl_loan_accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(500) NOT NULL,
  `account_number` varchar(250) NOT NULL,
  `account_type` varchar(200) NOT NULL,
  `bank_name` varchar(250) NOT NULL,
  `branch_name` varchar(250) DEFAULT NULL,
  `initial_balance` float NOT NULL,
  `description` varchar(2000) NOT NULL,
  `saved_by` int(11) NOT NULL,
  `saved_datetime` datetime NOT NULL,
  `save_date` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`account_id`),
  KEY `save_date` (`save_date`),
  KEY `branch_id` (`branch_id`) USING BTREE,
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_loan_transactions`
--

DROP TABLE IF EXISTS `tbl_loan_transactions`;
CREATE TABLE IF NOT EXISTS `tbl_loan_transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `transaction_type` varchar(30) NOT NULL,
  `amount` float NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `saved_by` int(11) NOT NULL,
  `saved_datetime` datetime NOT NULL,
  `branch_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`transaction_id`),
  KEY `account_id` (`account_id`),
  KEY `transaction_date` (`transaction_date`),
  KEY `transaction_type` (`transaction_type`),
  KEY `branch_id` (`branch_id`),
  KEY `status` (`status`),
  KEY `saved_by` (`saved_by`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_month`
--

DROP TABLE IF EXISTS `tbl_month`;
CREATE TABLE IF NOT EXISTS `tbl_month` (
  `month_id` int(11) NOT NULL AUTO_INCREMENT,
  `month_name` char(30) NOT NULL,
  PRIMARY KEY (`month_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

DROP TABLE IF EXISTS `tbl_product`;
CREATE TABLE IF NOT EXISTS `tbl_product` (
  `Product_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Product_Code` varchar(50) NOT NULL,
  `Product_Name` varchar(150) NOT NULL,
  `ProductCategory_ID` int(11) NOT NULL,
  `color` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `size` varchar(11) NOT NULL DEFAULT 'na',
  `vat` float NOT NULL,
  `Product_ReOrederLevel` int(11) NOT NULL,
  `Product_Purchase_Rate` decimal(18,2) NOT NULL,
  `Product_SellingPrice` decimal(18,2) NOT NULL,
  `Product_MinimumSellingPrice` decimal(18,2) NOT NULL,
  `Product_WholesaleRate` decimal(18,2) NOT NULL,
  `one_cartun_equal` varchar(20) NOT NULL,
  `is_service` varchar(10) NOT NULL DEFAULT 'false',
  `is_serial` tinyint(1) NOT NULL DEFAULT 0,
  `Unit_ID` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(100) NOT NULL,
  `AddTime` varchar(30) NOT NULL,
  `UpdateBy` varchar(50) NOT NULL,
  `UpdateTime` varchar(30) NOT NULL,
  `Product_branchid` int(11) NOT NULL,
  PRIMARY KEY (`Product_SlNo`),
  UNIQUE KEY `Product_Code` (`Product_Code`),
  KEY `ProductCategory_ID` (`ProductCategory_ID`),
  KEY `is_service` (`is_service`),
  KEY `Unit_ID` (`Unit_ID`),
  KEY `status` (`status`),
  KEY `Product_branchid` (`Product_branchid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`Product_SlNo`, `Product_Code`, `Product_Name`, `ProductCategory_ID`, `color`, `brand`, `size`, `vat`, `Product_ReOrederLevel`, `Product_Purchase_Rate`, `Product_SellingPrice`, `Product_MinimumSellingPrice`, `Product_WholesaleRate`, `one_cartun_equal`, `is_service`, `is_serial`, `Unit_ID`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Product_branchid`) VALUES
(1, 'P00001', 'Samsung j-2', 1, 0, 0, 'na', 0, 10, '5000.00', '5990.00', '0.00', '5590.00', '', 'false', 0, 1, 'a', 'Admin', '2022-03-20 20:32:00', '', '', 1),
(2, 'P00002', 'Apple mouse', 2, 0, 0, 'na', 0, 5, '150.00', '220.00', '0.00', '200.00', '', 'false', 1, 1, 'a', 'Admin', '2022-03-20 20:32:49', '', '', 1),
(3, 'P00003', 'A4 Tech Keyboard', 3, 0, 0, 'na', 0, 5, '400.00', '460.00', '0.00', '420.00', '', 'false', 1, 1, 'a', 'Admin', '2022-03-21 11:00:07', '', '', 1),
(4, 'P00004', 'a4', 1, 0, 0, 'na', 0, 10, '100.00', '20.00', '0.00', '0.00', '', 'false', 1, 1, 'a', 'Admin', '2022-03-21 14:41:09', '', '', 1),
(5, 'P00005', 'a10', 1, 0, 0, 'na', 0, 5, '1000.00', '2000.00', '0.00', '0.00', '', 'false', 0, 1, 'a', 'Admin', '2022-03-21 14:41:49', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_productcategory`
--

DROP TABLE IF EXISTS `tbl_productcategory`;
CREATE TABLE IF NOT EXISTS `tbl_productcategory` (
  `ProductCategory_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `ProductCategory_Name` varchar(150) NOT NULL,
  `ProductCategory_Description` varchar(300) NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) NOT NULL,
  `AddTime` varchar(30) NOT NULL,
  `UpdateBy` varchar(50) NOT NULL,
  `UpdateTime` varchar(30) NOT NULL,
  `category_branchid` int(11) NOT NULL,
  PRIMARY KEY (`ProductCategory_SlNo`),
  KEY `status` (`status`),
  KEY `category_branchid` (`category_branchid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_productcategory`
--

INSERT INTO `tbl_productcategory` (`ProductCategory_SlNo`, `ProductCategory_Name`, `ProductCategory_Description`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `category_branchid`) VALUES
(1, 'Mobile', 'Mobile', 'a', 'Admin', '2022-03-20 20:26:53', '', '', 1),
(2, 'Mouse', 'Mouse', 'a', 'Admin', '2022-03-20 20:27:28', '', '', 1),
(3, 'Keyboard', 'Keyboard', 'a', 'Admin', '2022-03-20 20:27:37', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_serial_numbers`
--

DROP TABLE IF EXISTS `tbl_product_serial_numbers`;
CREATE TABLE IF NOT EXISTS `tbl_product_serial_numbers` (
  `ps_id` int(11) NOT NULL AUTO_INCREMENT,
  `ps_prod_id` int(11) NOT NULL DEFAULT 0,
  `ps_serial_number` varchar(100) DEFAULT NULL,
  `ps_purchase_inv` varchar(255) DEFAULT NULL,
  `ps_purchase_supp_id` int(11) NOT NULL DEFAULT 0,
  `ps_s_status` enum('yes','no') NOT NULL DEFAULT 'no',
  `ps_s_r_status` enum('yes','no') NOT NULL DEFAULT 'no',
  `ps_s_r_amount` double NOT NULL DEFAULT 0,
  `ps_s_discount` float NOT NULL DEFAULT 0,
  `ps_p_status` enum('yes','no') NOT NULL DEFAULT 'no',
  `ps_p_r_status` enum('yes','no') NOT NULL DEFAULT 'no',
  `ps_p_r_amount` double DEFAULT 0,
  `ps_sale_date` varchar(20) DEFAULT NULL,
  `ps_brunch_id` int(11) NOT NULL DEFAULT 0,
  `ps_add_by` int(11) NOT NULL DEFAULT 0,
  `ps_update_by` int(11) NOT NULL DEFAULT 0,
  `ps_status` enum('a','d') NOT NULL DEFAULT 'a',
  `ps_transfer_from` int(11) DEFAULT NULL,
  `ps_transfer_to` int(11) DEFAULT NULL,
  `sales_details_id` int(11) NOT NULL DEFAULT 0,
  `purchase_details_id` int(11) NOT NULL DEFAULT 0,
  `purchase_rate` float NOT NULL DEFAULT 0,
  `purchase_discount` float NOT NULL DEFAULT 0,
  `purchase_total` float NOT NULL DEFAULT 0,
  `purchase_date` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ps_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product_serial_numbers`
--

INSERT INTO `tbl_product_serial_numbers` (`ps_id`, `ps_prod_id`, `ps_serial_number`, `ps_purchase_inv`, `ps_purchase_supp_id`, `ps_s_status`, `ps_s_r_status`, `ps_s_r_amount`, `ps_s_discount`, `ps_p_status`, `ps_p_r_status`, `ps_p_r_amount`, `ps_sale_date`, `ps_brunch_id`, `ps_add_by`, `ps_update_by`, `ps_status`, `ps_transfer_from`, `ps_transfer_to`, `sales_details_id`, `purchase_details_id`, `purchase_rate`, `purchase_discount`, `purchase_total`, `purchase_date`) VALUES
(1, 2, 'a-1', '2022000001', 1, 'yes', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 1, 2, 150, 0, 150, '2022-03-20'),
(2, 2, 'a-2', '2022000001', 1, 'yes', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 1, 2, 150, 0, 150, '2022-03-20'),
(3, 2, 'a-3', '2022000001', 1, 'yes', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 3, 2, 150, 0, 150, '2022-03-20'),
(4, 2, 'a-4', '2022000001', 1, 'yes', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 5, 2, 150, 0, 150, '2022-03-20'),
(5, 2, 'a-5', '2022000001', 1, 'yes', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 6, 2, 150, 0, 150, '2022-03-20'),
(6, 2, 'a-6', '2022000001', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 2, 150, 0, 150, '2022-03-20'),
(7, 2, 'a-7', '2022000001', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 2, 150, 0, 150, '2022-03-20'),
(8, 2, 'a-8', '2022000001', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 2, 150, 0, 150, '2022-03-20'),
(9, 2, 'a-9', '2022000001', 1, 'no', 'no', 0, 0, 'yes', 'yes', 300, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 2, 150, 0, 150, '2022-03-20'),
(10, 2, 'a-10', '2022000001', 1, 'no', 'no', 0, 0, 'yes', 'yes', 300, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 2, 150, 0, 150, '2022-03-20'),
(11, 2, 'm-1', '2022000004', 1, 'yes', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 8, 7, 150, 0, 150, '2022-03-21'),
(12, 2, 'm-2', '2022000004', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 7, 150, 0, 150, '2022-03-21'),
(13, 2, 'm-3', '2022000004', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 7, 150, 0, 150, '2022-03-21'),
(14, 2, 'm-4', '2022000004', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 7, 150, 0, 150, '2022-03-21'),
(15, 2, 'm-5', '2022000004', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 7, 150, 0, 150, '2022-03-21'),
(16, 2, 'm-6', '2022000004', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 7, 150, 0, 150, '2022-03-21'),
(17, 2, 'm-7', '2022000004', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 7, 150, 0, 150, '2022-03-21'),
(18, 2, 'm-8', '2022000004', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 7, 150, 0, 150, '2022-03-21'),
(19, 2, 'm-9', '2022000004', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 7, 150, 0, 150, '2022-03-21'),
(20, 2, 'm-10', '2022000004', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 7, 150, 0, 150, '2022-03-21'),
(21, 4, '5', '2022000005', 1, 'yes', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 9, 9, 100, 0, 100, '2022-03-21'),
(22, 4, '6', '2022000005', 1, 'yes', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 9, 9, 100, 0, 100, '2022-03-21'),
(23, 4, '7', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(24, 4, '8', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(25, 4, '9', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(26, 4, '10', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(27, 4, '11', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(28, 4, '12', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(29, 4, '13', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(30, 4, '14', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(31, 4, '15', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(32, 4, '16', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(33, 4, '17', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(34, 4, '18', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21'),
(35, 4, '19', '2022000005', 1, 'no', 'no', 0, 0, 'yes', 'no', 0, NULL, 1, 0, 0, 'a', NULL, NULL, 0, 9, 100, 0, 100, '2022-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasedetails`
--

DROP TABLE IF EXISTS `tbl_purchasedetails`;
CREATE TABLE IF NOT EXISTS `tbl_purchasedetails` (
  `PurchaseDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `PurchaseMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `PurchaseDetails_TotalQuantity` float NOT NULL,
  `PurchaseDetails_Rate` decimal(18,2) NOT NULL,
  `purchase_cost` decimal(18,2) NOT NULL,
  `PurchaseDetails_Discount` decimal(18,2) NOT NULL,
  `PurchaseDetails_TotalAmount` decimal(18,2) NOT NULL,
  `warranty_month` int(11) DEFAULT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseDetails_branchID` int(11) NOT NULL,
  PRIMARY KEY (`PurchaseDetails_SlNo`),
  KEY `PurchaseMaster_IDNo` (`PurchaseMaster_IDNo`),
  KEY `Product_IDNo` (`Product_IDNo`),
  KEY `Status` (`Status`),
  KEY `PurchaseDetails_branchID` (`PurchaseDetails_branchID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchasedetails`
--

INSERT INTO `tbl_purchasedetails` (`PurchaseDetails_SlNo`, `PurchaseMaster_IDNo`, `Product_IDNo`, `PurchaseDetails_TotalQuantity`, `PurchaseDetails_Rate`, `purchase_cost`, `PurchaseDetails_Discount`, `PurchaseDetails_TotalAmount`, `warranty_month`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseDetails_branchID`) VALUES
(1, 1, 1, 10, '5000.00', '0.00', '0.00', '50000.00', NULL, 'a', 'Admin', '2022-03-20 20:39:28', NULL, NULL, 1),
(2, 1, 2, 10, '150.00', '0.00', '0.00', '1500.00', NULL, 'a', 'Admin', '2022-03-20 20:39:28', NULL, NULL, 1),
(3, 2, 1, 10, '5000.00', '0.00', '0.00', '50000.00', NULL, 'a', 'Admin', '2022-03-20 20:42:35', NULL, NULL, 1),
(6, 3, 1, 1, '5000.00', '0.00', '0.00', '5000.00', 24, 'a', NULL, NULL, 'Admin', '2022-03-21 11:40:52', 1),
(7, 4, 2, 10, '150.00', '0.00', '0.00', '1500.00', 12, 'a', 'Admin', '2022-03-21 14:31:00', NULL, NULL, 1),
(8, 5, 5, 15, '1000.00', '0.00', '0.00', '15000.00', 5, 'a', 'Admin', '2022-03-21 14:45:55', NULL, NULL, 1),
(9, 5, 4, 15, '100.00', '0.00', '0.00', '1500.00', 12, 'a', 'Admin', '2022-03-21 14:45:55', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasemaster`
--

DROP TABLE IF EXISTS `tbl_purchasemaster`;
CREATE TABLE IF NOT EXISTS `tbl_purchasemaster` (
  `PurchaseMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Supplier_SlNo` int(11) NOT NULL,
  `Employee_SlNo` int(11) NOT NULL,
  `PurchaseMaster_InvoiceNo` varchar(50) NOT NULL,
  `PurchaseMaster_OrderDate` date NOT NULL,
  `PurchaseMaster_PurchaseFor` varchar(50) NOT NULL,
  `PurchaseMaster_Description` longtext NOT NULL,
  `PurchaseMaster_TotalAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_DiscountAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_Tax` decimal(18,2) NOT NULL,
  `PurchaseMaster_Freight` decimal(18,2) NOT NULL,
  `PurchaseMaster_SubTotalAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_PaidAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_DueAmount` decimal(18,2) NOT NULL,
  `previous_due` float DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseMaster_BranchID` int(11) NOT NULL,
  PRIMARY KEY (`PurchaseMaster_SlNo`),
  KEY `Supplier_SlNo` (`Supplier_SlNo`),
  KEY `Employee_SlNo` (`Employee_SlNo`),
  KEY `PurchaseMaster_InvoiceNo` (`PurchaseMaster_InvoiceNo`),
  KEY `PurchaseMaster_OrderDate` (`PurchaseMaster_OrderDate`),
  KEY `status` (`status`),
  KEY `PurchaseMaster_BranchID` (`PurchaseMaster_BranchID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchasemaster`
--

INSERT INTO `tbl_purchasemaster` (`PurchaseMaster_SlNo`, `Supplier_SlNo`, `Employee_SlNo`, `PurchaseMaster_InvoiceNo`, `PurchaseMaster_OrderDate`, `PurchaseMaster_PurchaseFor`, `PurchaseMaster_Description`, `PurchaseMaster_TotalAmount`, `PurchaseMaster_DiscountAmount`, `PurchaseMaster_Tax`, `PurchaseMaster_Freight`, `PurchaseMaster_SubTotalAmount`, `PurchaseMaster_PaidAmount`, `PurchaseMaster_DueAmount`, `previous_due`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseMaster_BranchID`) VALUES
(1, 1, 0, '2022000001', '2022-03-20', '1', '', '51500.00', '0.00', '0.00', '0.00', '51500.00', '0.00', '51500.00', 0, 'a', 'Admin', '2022-03-20 20:39:28', NULL, NULL, 1),
(2, 1, 0, '2022000002', '2022-03-20', '1', '', '50000.00', '0.00', '0.00', '0.00', '50000.00', '10000.00', '40000.00', 51500, 'a', 'Admin', '2022-03-20 20:42:35', NULL, NULL, 1),
(3, 1, 0, '2022000003', '2022-03-21', '1', '', '5000.00', '0.00', '0.00', '0.00', '5000.00', '0.00', '5000.00', 91200, 'a', 'Admin', '2022-03-21 11:05:48', 'Admin', '2022-03-21 11:40:52', 1),
(4, 1, 0, '2022000004', '2022-03-21', '1', '', '1500.00', '0.00', '0.00', '0.00', '1500.00', '1500.00', '0.00', 96200, 'a', 'Admin', '2022-03-21 14:31:00', NULL, NULL, 1),
(5, 1, 0, '2022000005', '2022-03-21', '1', '', '16500.00', '0.00', '0.00', '0.00', '16500.00', '16500.00', '0.00', 96200, 'a', 'Admin', '2022-03-21 14:45:55', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasereturn`
--

DROP TABLE IF EXISTS `tbl_purchasereturn`;
CREATE TABLE IF NOT EXISTS `tbl_purchasereturn` (
  `PurchaseReturn_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `PurchaseMaster_InvoiceNo` varchar(50) NOT NULL,
  `Supplier_IDdNo` int(11) NOT NULL,
  `PurchaseReturn_ReturnDate` date NOT NULL,
  `PurchaseReturn_ReturnAmount` decimal(18,2) NOT NULL,
  `PurchaseReturn_Description` varchar(300) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseReturn_brunchID` int(11) NOT NULL,
  PRIMARY KEY (`PurchaseReturn_SlNo`),
  KEY `PurchaseMaster_InvoiceNo` (`PurchaseMaster_InvoiceNo`),
  KEY `Supplier_IDdNo` (`Supplier_IDdNo`),
  KEY `PurchaseReturn_ReturnDate` (`PurchaseReturn_ReturnDate`),
  KEY `Status` (`Status`),
  KEY `PurchaseReturn_brunchID` (`PurchaseReturn_brunchID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchasereturn`
--

INSERT INTO `tbl_purchasereturn` (`PurchaseReturn_SlNo`, `PurchaseMaster_InvoiceNo`, `Supplier_IDdNo`, `PurchaseReturn_ReturnDate`, `PurchaseReturn_ReturnAmount`, `PurchaseReturn_Description`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseReturn_brunchID`) VALUES
(1, '2022000001', 1, '2022-03-20', '300.00', '', 'a', 'Admin', '2022-03-20 21:25:06', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasereturndetails`
--

DROP TABLE IF EXISTS `tbl_purchasereturndetails`;
CREATE TABLE IF NOT EXISTS `tbl_purchasereturndetails` (
  `PurchaseReturnDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `PurchaseReturn_SlNo` int(11) NOT NULL,
  `PurchaseReturnDetailsProduct_SlNo` int(11) NOT NULL,
  `PurchaseReturnDetails_ReturnQuantity` float NOT NULL,
  `PurchaseReturnDetails_ReturnAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseReturnDetails_brachid` int(11) NOT NULL,
  PRIMARY KEY (`PurchaseReturnDetails_SlNo`),
  KEY `PurchaseReturn_SlNo` (`PurchaseReturn_SlNo`),
  KEY `PurchaseReturnDetailsProduct_SlNo` (`PurchaseReturnDetailsProduct_SlNo`),
  KEY `Status` (`Status`),
  KEY `PurchaseReturnDetails_brachid` (`PurchaseReturnDetails_brachid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchasereturndetails`
--

INSERT INTO `tbl_purchasereturndetails` (`PurchaseReturnDetails_SlNo`, `PurchaseReturn_SlNo`, `PurchaseReturnDetailsProduct_SlNo`, `PurchaseReturnDetails_ReturnQuantity`, `PurchaseReturnDetails_ReturnAmount`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseReturnDetails_brachid`) VALUES
(1, 1, 1, 0, '0.00', 'a', 'Admin', '2022-03-20 21:25:06', NULL, NULL, 1),
(2, 1, 2, 2, '300.00', 'a', 'Admin', '2022-03-20 21:25:06', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotaion_customer`
--

DROP TABLE IF EXISTS `tbl_quotaion_customer`;
CREATE TABLE IF NOT EXISTS `tbl_quotaion_customer` (
  `quotation_customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` char(50) NOT NULL,
  `contact_number` varchar(35) NOT NULL,
  `customer_address` text NOT NULL,
  `quation_customer_branchid` int(11) NOT NULL,
  PRIMARY KEY (`quotation_customer_id`),
  KEY `quation_customer_branchid` (`quation_customer_branchid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_details`
--

DROP TABLE IF EXISTS `tbl_quotation_details`;
CREATE TABLE IF NOT EXISTS `tbl_quotation_details` (
  `SaleDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `SaleDetails_TotalQuantity` float NOT NULL,
  `SaleDetails_Rate` decimal(18,2) NOT NULL,
  `SaleDetails_Discount` decimal(18,2) NOT NULL,
  `SaleDetails_Tax` decimal(18,2) NOT NULL,
  `SaleDetails_Freight` decimal(18,2) NOT NULL,
  `SaleDetails_TotalAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleDetails_BranchId` int(11) NOT NULL,
  PRIMARY KEY (`SaleDetails_SlNo`),
  KEY `SaleMaster_IDNo` (`SaleMaster_IDNo`),
  KEY `Product_IDNo` (`Product_IDNo`),
  KEY `Status` (`Status`),
  KEY `SaleDetails_BranchId` (`SaleDetails_BranchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_master`
--

DROP TABLE IF EXISTS `tbl_quotation_master`;
CREATE TABLE IF NOT EXISTS `tbl_quotation_master` (
  `SaleMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleMaster_InvoiceNo` varchar(50) NOT NULL,
  `SaleMaster_customer_name` varchar(500) NOT NULL,
  `SaleMaster_customer_mobile` varchar(50) NOT NULL,
  `SaleMaster_customer_address` varchar(1000) NOT NULL,
  `SaleMaster_SaleDate` date NOT NULL,
  `SaleMaster_Description` longtext DEFAULT NULL,
  `SaleMaster_TotalSaleAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TotalDiscountAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TaxAmount` decimal(18,2) NOT NULL,
  `SaleMaster_Freight` decimal(18,2) NOT NULL,
  `SaleMaster_SubTotalAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleMaster_branchid` int(11) NOT NULL,
  PRIMARY KEY (`SaleMaster_SlNo`),
  KEY `SaleMaster_InvoiceNo` (`SaleMaster_InvoiceNo`),
  KEY `SaleMaster_SaleDate` (`SaleMaster_SaleDate`),
  KEY `Status` (`Status`),
  KEY `SaleMaster_branchid` (`SaleMaster_branchid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_saledetails`
--

DROP TABLE IF EXISTS `tbl_saledetails`;
CREATE TABLE IF NOT EXISTS `tbl_saledetails` (
  `SaleDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `SaleDetails_TotalQuantity` float NOT NULL,
  `Purchase_Rate` decimal(18,2) DEFAULT NULL,
  `SaleDetails_Rate` decimal(18,2) NOT NULL,
  `SaleDetails_Discount` decimal(18,2) NOT NULL,
  `Discount_amount` decimal(18,2) DEFAULT NULL,
  `SaleDetails_Tax` decimal(18,2) NOT NULL,
  `SaleDetails_TotalAmount` decimal(18,2) NOT NULL,
  `warranty` int(11) DEFAULT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleDetails_BranchId` int(11) NOT NULL,
  PRIMARY KEY (`SaleDetails_SlNo`),
  KEY `SaleMaster_IDNo` (`SaleMaster_IDNo`),
  KEY `Product_IDNo` (`Product_IDNo`),
  KEY `Status` (`Status`),
  KEY `SaleDetails_BranchId` (`SaleDetails_BranchId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_saledetails`
--

INSERT INTO `tbl_saledetails` (`SaleDetails_SlNo`, `SaleMaster_IDNo`, `Product_IDNo`, `SaleDetails_TotalQuantity`, `Purchase_Rate`, `SaleDetails_Rate`, `SaleDetails_Discount`, `Discount_amount`, `SaleDetails_Tax`, `SaleDetails_TotalAmount`, `warranty`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleDetails_BranchId`) VALUES
(1, 1, 2, 2, '150.00', '220.00', '0.00', NULL, '0.00', '440.00', NULL, 'a', 'Admin', '2022-03-20 21:27:58', NULL, NULL, 1),
(3, 2, 2, 1, '150.00', '220.00', '0.00', NULL, '0.00', '220.00', NULL, 'a', 'Admin', '2022-03-21 12:47:36', NULL, NULL, 1),
(5, 3, 2, 1, '150.00', '220.00', '0.00', NULL, '0.00', '220.00', 0, 'a', 'Admin', '2022-03-21 12:49:15', NULL, NULL, 1),
(6, 4, 2, 1, '150.00', '220.00', '0.00', NULL, '0.00', '220.00', 12, 'a', 'Admin', '2022-03-21 14:28:37', NULL, NULL, 1),
(7, 4, 1, 1, '5000.00', '5990.00', '0.00', NULL, '0.00', '5990.00', 12, 'a', 'Admin', '2022-03-21 14:28:37', NULL, NULL, 1),
(8, 5, 2, 1, '150.00', '220.00', '0.00', NULL, '0.00', '220.00', 12, 'a', 'Admin', '2022-03-21 14:31:26', NULL, NULL, 1),
(9, 6, 4, 2, '100.00', '20.00', '0.00', NULL, '0.00', '40.00', 2, 'a', 'Admin', '2022-03-21 14:48:02', NULL, NULL, 1),
(10, 6, 5, 10, '1000.00', '2000.00', '0.00', NULL, '0.00', '20000.00', 12, 'a', 'Admin', '2022-03-21 14:48:02', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salereturn`
--

DROP TABLE IF EXISTS `tbl_salereturn`;
CREATE TABLE IF NOT EXISTS `tbl_salereturn` (
  `SaleReturn_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleMaster_InvoiceNo` varchar(50) NOT NULL,
  `SaleReturn_ReturnDate` date NOT NULL,
  `SaleReturn_ReturnAmount` decimal(18,2) NOT NULL,
  `SaleReturn_Description` varchar(300) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleReturn_brunchId` int(11) NOT NULL,
  PRIMARY KEY (`SaleReturn_SlNo`),
  KEY `SaleMaster_InvoiceNo` (`SaleMaster_InvoiceNo`),
  KEY `SaleReturn_ReturnDate` (`SaleReturn_ReturnDate`),
  KEY `Status` (`Status`),
  KEY `SaleReturn_brunchId` (`SaleReturn_brunchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salereturndetails`
--

DROP TABLE IF EXISTS `tbl_salereturndetails`;
CREATE TABLE IF NOT EXISTS `tbl_salereturndetails` (
  `SaleReturnDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleReturn_IdNo` int(11) NOT NULL,
  `SaleReturnDetailsProduct_SlNo` int(11) NOT NULL,
  `SaleReturnDetails_ReturnQuantity` float NOT NULL,
  `SaleReturnDetails_ReturnAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleReturnDetails_brunchID` int(11) NOT NULL,
  PRIMARY KEY (`SaleReturnDetails_SlNo`),
  KEY `SaleReturn_IdNo` (`SaleReturn_IdNo`),
  KEY `SaleReturnDetailsProduct_SlNo` (`SaleReturnDetailsProduct_SlNo`),
  KEY `Status` (`Status`),
  KEY `SaleReturnDetails_brunchID` (`SaleReturnDetails_brunchID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salesmaster`
--

DROP TABLE IF EXISTS `tbl_salesmaster`;
CREATE TABLE IF NOT EXISTS `tbl_salesmaster` (
  `SaleMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleMaster_InvoiceNo` varchar(50) NOT NULL,
  `SalseCustomer_IDNo` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `SaleMaster_SaleDate` date NOT NULL,
  `SaleMaster_Description` longtext DEFAULT NULL,
  `SaleMaster_SaleType` varchar(50) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT 'Cash',
  `SaleMaster_TotalSaleAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TotalDiscountAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TaxAmount` decimal(18,2) NOT NULL,
  `SaleMaster_Freight` decimal(18,2) DEFAULT 0.00,
  `SaleMaster_SubTotalAmount` decimal(18,2) NOT NULL,
  `SaleMaster_PaidAmount` decimal(18,2) NOT NULL,
  `SaleMaster_DueAmount` decimal(18,2) NOT NULL,
  `SaleMaster_Previous_Due` double(18,2) DEFAULT NULL,
  `Status` char(1) NOT NULL DEFAULT 'a',
  `is_service` varchar(10) NOT NULL DEFAULT 'false',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleMaster_branchid` int(11) NOT NULL,
  PRIMARY KEY (`SaleMaster_SlNo`),
  KEY `SaleMaster_InvoiceNo` (`SaleMaster_InvoiceNo`),
  KEY `SalseCustomer_IDNo` (`SalseCustomer_IDNo`),
  KEY `employee_id` (`employee_id`),
  KEY `SaleMaster_SaleDate` (`SaleMaster_SaleDate`),
  KEY `Status` (`Status`),
  KEY `is_service` (`is_service`),
  KEY `SaleMaster_branchid` (`SaleMaster_branchid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_salesmaster`
--

INSERT INTO `tbl_salesmaster` (`SaleMaster_SlNo`, `SaleMaster_InvoiceNo`, `SalseCustomer_IDNo`, `employee_id`, `SaleMaster_SaleDate`, `SaleMaster_Description`, `SaleMaster_SaleType`, `payment_type`, `SaleMaster_TotalSaleAmount`, `SaleMaster_TotalDiscountAmount`, `SaleMaster_TaxAmount`, `SaleMaster_Freight`, `SaleMaster_SubTotalAmount`, `SaleMaster_PaidAmount`, `SaleMaster_DueAmount`, `SaleMaster_Previous_Due`, `Status`, `is_service`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleMaster_branchid`) VALUES
(1, '220100001', 1, NULL, '2022-03-20', '', 'retail', 'Cash', '440.00', '0.00', '0.00', '0.00', '440.00', '0.00', '440.00', 0.00, 'a', 'false', 'Admin', '2022-03-20 21:27:58', NULL, NULL, 1),
(2, '220100002', 1, NULL, '2022-03-21', '', 'retail', 'Cash', '220.00', '0.00', '0.00', '0.00', '220.00', '0.00', '220.00', 440.00, 'a', 'false', 'Admin', '2022-03-21 12:13:59', 'Admin', '2022-03-21 12:47:36', 1),
(3, '220100003', 1, NULL, '2022-03-21', '', 'retail', 'Cash', '220.00', '0.00', '0.00', '0.00', '220.00', '220.00', '0.00', 660.00, 'a', 'false', 'Admin', '2022-03-21 12:48:50', 'Admin', '2022-03-21 12:49:15', 1),
(4, '220100004', 2, NULL, '2022-03-21', '', 'retail', 'Cash', '6210.00', '0.00', '0.00', '0.00', '6210.00', '6210.00', '0.00', 0.00, 'a', 'false', 'Admin', '2022-03-21 14:28:37', NULL, NULL, 1),
(5, '220100005', 1, NULL, '2022-03-21', '', 'retail', 'Cash', '220.00', '0.00', '0.00', '0.00', '220.00', '0.00', '220.00', 660.00, 'a', 'false', 'Admin', '2022-03-21 14:31:26', NULL, NULL, 1),
(6, '220100006', 1, NULL, '2022-03-21', '', 'retail', 'Cash', '20040.00', '0.00', '0.00', '0.00', '20040.00', '20040.00', '0.00', 880.00, 'a', 'false', 'Admin', '2022-03-21 14:48:02', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_servicecompany`
--

DROP TABLE IF EXISTS `tbl_servicecompany`;
CREATE TABLE IF NOT EXISTS `tbl_servicecompany` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_servicedetails`
--

DROP TABLE IF EXISTS `tbl_servicedetails`;
CREATE TABLE IF NOT EXISTS `tbl_servicedetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_invoice` varchar(15) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `imei` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `service_status` varchar(1) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `receive_date` date DEFAULT NULL,
  `status` varchar(1) NOT NULL,
  `added_by` varchar(30) DEFAULT NULL,
  `added_time` varchar(30) DEFAULT NULL,
  `update_by` varchar(30) DEFAULT NULL,
  `update_time` varchar(30) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_servicedetails`
--

INSERT INTO `tbl_servicedetails` (`id`, `service_invoice`, `product_name`, `model`, `imei`, `quantity`, `service_status`, `company_id`, `transfer_date`, `receive_date`, `status`, `added_by`, `added_time`, `update_by`, `update_time`, `branch_id`) VALUES
(4, '220100001', 'Samsung', 'j-2', '1025', 1, 'd', NULL, '0000-00-00', '0000-00-00', 'a', 'Admin', '2022-03-20 21:46:44', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_serviceexpense`
--

DROP TABLE IF EXISTS `tbl_serviceexpense`;
CREATE TABLE IF NOT EXISTS `tbl_serviceexpense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_invoice` varchar(20) NOT NULL,
  `expense_id` int(11) NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `quantity` float NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `status` varchar(1) NOT NULL,
  `added_by` varchar(30) DEFAULT NULL,
  `added_time` datetime DEFAULT NULL,
  `update_by` varchar(30) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_serviceexpense`
--

INSERT INTO `tbl_serviceexpense` (`id`, `service_invoice`, `expense_id`, `price`, `quantity`, `amount`, `status`, `added_by`, `added_time`, `update_by`, `update_time`, `branch_id`) VALUES
(7, '220100001', 2, '80.00', 1, '80.00', 'a', 'Admin', '2022-03-20 21:46:44', NULL, NULL, 1),
(8, '220100001', 1, '100.00', 1, '100.00', 'a', 'Admin', '2022-03-20 21:46:44', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_servicemaster`
--

DROP TABLE IF EXISTS `tbl_servicemaster`;
CREATE TABLE IF NOT EXISTS `tbl_servicemaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `paid` decimal(18,2) NOT NULL,
  `due` decimal(18,2) NOT NULL,
  `note` text NOT NULL,
  `status` varchar(1) NOT NULL,
  `added_by` varchar(30) NOT NULL,
  `added_time` datetime NOT NULL,
  `update_by` varchar(30) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_servicemaster`
--

INSERT INTO `tbl_servicemaster` (`id`, `date`, `invoice`, `customer_id`, `total`, `paid`, `due`, `note`, `status`, `added_by`, `added_time`, `update_by`, `update_time`, `branch_id`) VALUES
(1, '2022-03-20', '220100001', 1, '180.00', '150.00', '30.00', '', 'a', 'Admin', '2022-03-20 21:36:22', 'Admin', '2022-03-20 21:46:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms`
--

DROP TABLE IF EXISTS `tbl_sms`;
CREATE TABLE IF NOT EXISTS `tbl_sms` (
  `row_id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(30) NOT NULL,
  `sms_text` varchar(500) NOT NULL,
  `sent_by` int(11) NOT NULL,
  `sent_datetime` datetime NOT NULL,
  PRIMARY KEY (`row_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms_settings`
--

DROP TABLE IF EXISTS `tbl_sms_settings`;
CREATE TABLE IF NOT EXISTS `tbl_sms_settings` (
  `sms_enabled` varchar(10) NOT NULL DEFAULT 'false',
  `api_key` varchar(500) NOT NULL,
  `url` varchar(1000) NOT NULL,
  `bulk_url` varchar(1000) NOT NULL,
  `sms_type` varchar(50) NOT NULL,
  `sender_id` varchar(200) NOT NULL,
  `sender_name` varchar(200) NOT NULL,
  `sender_phone` varchar(50) NOT NULL,
  `saved_by` int(11) DEFAULT NULL,
  `saved_datetime` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sms_settings`
--

INSERT INTO `tbl_sms_settings` (`sms_enabled`, `api_key`, `url`, `bulk_url`, `sms_type`, `sender_id`, `sender_name`, `sender_phone`, `saved_by`, `saved_datetime`) VALUES
('false', 'C20036315d8f41beb57b36.68545984', 'http://esms.linktechbd.com/smsapi', 'http://esms.linktechbd.com/smsapimany', 'text', 'Link-UpTech', 'Link-Up Technology', '01911-978897', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

DROP TABLE IF EXISTS `tbl_supplier`;
CREATE TABLE IF NOT EXISTS `tbl_supplier` (
  `Supplier_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Supplier_Code` varchar(50) NOT NULL,
  `Supplier_Name` varchar(150) NOT NULL,
  `Supplier_Type` varchar(50) NOT NULL,
  `Supplier_Phone` varchar(50) NOT NULL,
  `Supplier_Mobile` varchar(15) NOT NULL,
  `Supplier_Email` varchar(50) NOT NULL,
  `Supplier_OfficePhone` varchar(50) NOT NULL,
  `Supplier_Address` varchar(300) NOT NULL,
  `contact_person` varchar(250) DEFAULT NULL,
  `District_SlNo` int(11) NOT NULL,
  `Country_SlNo` int(11) NOT NULL,
  `Supplier_Web` varchar(150) NOT NULL,
  `previous_due` decimal(18,2) NOT NULL,
  `image_name` varchar(1000) DEFAULT NULL,
  `Status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Supplier_brinchid` int(11) NOT NULL,
  PRIMARY KEY (`Supplier_SlNo`),
  KEY `Supplier_Code` (`Supplier_Code`),
  KEY `Supplier_Mobile` (`Supplier_Mobile`),
  KEY `District_SlNo` (`District_SlNo`),
  KEY `Country_SlNo` (`Country_SlNo`),
  KEY `Status` (`Status`),
  KEY `Supplier_brinchid` (`Supplier_brinchid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`Supplier_SlNo`, `Supplier_Code`, `Supplier_Name`, `Supplier_Type`, `Supplier_Phone`, `Supplier_Mobile`, `Supplier_Email`, `Supplier_OfficePhone`, `Supplier_Address`, `contact_person`, `District_SlNo`, `Country_SlNo`, `Supplier_Web`, `previous_due`, `image_name`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Supplier_brinchid`) VALUES
(1, 'S00001', 'Shop Nill Store', '', '', '01796953487', '', '', 'Bogura', 'JS Group', 0, 0, '', '0.00', NULL, 'a', 'Admin', '2022-03-20 20:34:36', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_payment`
--

DROP TABLE IF EXISTS `tbl_supplier_payment`;
CREATE TABLE IF NOT EXISTS `tbl_supplier_payment` (
  `SPayment_id` int(11) NOT NULL AUTO_INCREMENT,
  `SPayment_date` date DEFAULT NULL,
  `SPayment_invoice` varchar(20) DEFAULT NULL,
  `SPayment_customerID` varchar(20) DEFAULT NULL,
  `SPayment_TransactionType` varchar(25) DEFAULT NULL,
  `SPayment_amount` decimal(18,2) DEFAULT NULL,
  `SPayment_Paymentby` varchar(20) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `SPayment_notes` varchar(225) DEFAULT NULL,
  `SPayment_brunchid` int(11) DEFAULT NULL,
  `SPayment_status` varchar(2) DEFAULT NULL,
  `SPayment_Addby` varchar(100) DEFAULT NULL,
  `SPayment_AddDAte` date DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `SPayment_UpdateDAte` date DEFAULT NULL,
  PRIMARY KEY (`SPayment_id`),
  KEY `SPayment_date` (`SPayment_date`),
  KEY `SPayment_invoice` (`SPayment_invoice`),
  KEY `SPayment_customerID` (`SPayment_customerID`),
  KEY `SPayment_TransactionType` (`SPayment_TransactionType`),
  KEY `account_id` (`account_id`),
  KEY `SPayment_brunchid` (`SPayment_brunchid`),
  KEY `SPayment_status` (`SPayment_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transferdetails`
--

DROP TABLE IF EXISTS `tbl_transferdetails`;
CREATE TABLE IF NOT EXISTS `tbl_transferdetails` (
  `transferdetails_id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `purchase_rate` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`transferdetails_id`),
  KEY `transfer_id` (`transfer_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transfermaster`
--

DROP TABLE IF EXISTS `tbl_transfermaster`;
CREATE TABLE IF NOT EXISTS `tbl_transfermaster` (
  `transfer_id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_date` date NOT NULL,
  `transfer_by` int(11) NOT NULL,
  `transfer_from` int(11) NOT NULL,
  `transfer_to` int(11) NOT NULL,
  `total_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `note` varchar(500) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_datetime` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`transfer_id`),
  KEY `transfer_date` (`transfer_date`),
  KEY `transfer_from` (`transfer_from`),
  KEY `transfer_to` (`transfer_to`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit`
--

DROP TABLE IF EXISTS `tbl_unit`;
CREATE TABLE IF NOT EXISTS `tbl_unit` (
  `Unit_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Unit_Name` varchar(150) NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Unit_SlNo`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_unit`
--

INSERT INTO `tbl_unit` (`Unit_SlNo`, `Unit_Name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 'PCS', 'a', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `User_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` varchar(50) NOT NULL,
  `FullName` varchar(150) NOT NULL,
  `User_Name` varchar(150) NOT NULL,
  `UserEmail` varchar(200) NOT NULL,
  `userBrunch_id` int(11) NOT NULL,
  `User_Password` varchar(50) NOT NULL,
  `UserType` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `verifycode` int(11) NOT NULL,
  `image_name` varchar(1000) DEFAULT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Brunch_ID` int(11) NOT NULL,
  PRIMARY KEY (`User_SlNo`),
  KEY `User_ID` (`User_ID`),
  KEY `User_Name` (`User_Name`),
  KEY `User_Password` (`User_Password`),
  KEY `UserType` (`UserType`),
  KEY `status` (`status`),
  KEY `Brunch_ID` (`Brunch_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`User_SlNo`, `User_ID`, `FullName`, `User_Name`, `UserEmail`, `userBrunch_id`, `User_Password`, `UserType`, `status`, `verifycode`, `image_name`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Brunch_ID`) VALUES
(1, 'U0001', 'Admin', 'admin', 'admin@host.com', 1, 'c4ca4238a0b923820dcc509a6f75849b', 'm', 'a', 1, NULL, NULL, NULL, NULL, NULL, 1),
(2, '', 'Jakirul Islam', 'jakirul', 'jakirul', 1, 'c4ca4238a0b923820dcc509a6f75849b', 'u', 'a', 0, NULL, NULL, '2022-03-20 19:18:35', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_access`
--

DROP TABLE IF EXISTS `tbl_user_access`;
CREATE TABLE IF NOT EXISTS `tbl_user_access` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `access` text NOT NULL,
  `saved_by` int(11) NOT NULL,
  `saved_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`access_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_activity`
--

DROP TABLE IF EXISTS `tbl_user_activity`;
CREATE TABLE IF NOT EXISTS `tbl_user_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  `status` char(2) NOT NULL DEFAULT 'a',
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user_activity`
--

INSERT INTO `tbl_user_activity` (`id`, `user_id`, `ip_address`, `login_time`, `logout_time`, `status`, `branch_id`) VALUES
(1, 1, '::1', '2022-03-20 19:03:48', NULL, 'a', 1),
(2, 1, '::1', '2022-03-21 09:27:07', '2022-03-21 11:34:35', 'a', 1),
(3, 1, '::1', '2022-03-21 11:34:38', '2022-03-21 12:05:35', 'a', 1),
(4, 1, '::1', '2022-03-21 12:05:39', NULL, 'a', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
