-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 01, 2019 at 12:11 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `health_insurance_network`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_hr`
--

DROP TABLE IF EXISTS `company_hr`;
CREATE TABLE IF NOT EXISTS `company_hr` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(20) NOT NULL,
  `address` varchar(120) NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `POC` varchar(20) NOT NULL,
  `logo` varchar(120) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_hr`
--

INSERT INTO `company_hr` (`company_id`, `company_name`, `address`, `phone_number`, `POC`, `logo`) VALUES
(1, 'Free Exporter', 'Plot ABC/123, XYZ, Block 16, near PQR, Anonymous City ', '+923312667569', 'Hr Executive', '');

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

DROP TABLE IF EXISTS `diagnosis`;
CREATE TABLE IF NOT EXISTS `diagnosis` (
  `did` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `diag_code` varchar(20) NOT NULL,
  `diag_name` tinytext NOT NULL,
  UNIQUE KEY `did` (`did`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `diagnosis`
--

INSERT INTO `diagnosis` (`did`, `diag_code`, `diag_name`) VALUES
(2, '01A1', 'flu'),
(1, '01A0', 'High fever'),
(3, '04B3', 'Neuro'),
(4, '08C9', 'Cancer');

-- --------------------------------------------------------

--
-- Table structure for table `hin_user`
--

DROP TABLE IF EXISTS `hin_user`;
CREATE TABLE IF NOT EXISTS `hin_user` (
  `uid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `profile_image` tinytext NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(1) NOT NULL,
  `sub_role` varchar(50) NOT NULL,
  UNIQUE KEY `uid` (`uid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email_id` (`email_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hin_user`
--

INSERT INTO `hin_user` (`uid`, `name`, `profile_image`, `email_id`, `username`, `password`, `role`, `sub_role`) VALUES
(2, 'Ayaz', 'web/img/profile/02_profile_ayaz.jpeg', 'ayaz@gmail.com', 'ayaz', '*46EEC0452F01F5FA2258E2D5A3AFD1846A1E371F', 1, '1'),
(1, 'Admin User', 'web/img/profile/profile_dp.jpg', 'aliazeemh@gmail.com', 'admin', '*49203FC99D577CBFF30503D8FE016DB18C7F3C5C', 0, '0'),
(3, 'Atif Iqbal', 'web/img/profile/03_profile_atif.jpeg', 'atif@gmail.com', 'atif', '*F4C31210CFAC3A3549570450B6F091B644EB6552', 2, '1'),
(4, 'QA', '', 'demo@gmail.com', 'demo', '*46EEC0452F01F5FA2258E2D5A3AFD1846A1E371F', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

DROP TABLE IF EXISTS `hospital`;
CREATE TABLE IF NOT EXISTS `hospital` (
  `hosp_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hosp_name` varchar(120) NOT NULL,
  `did_supports` json NOT NULL,
  `hosp_logo` tinytext NOT NULL,
  UNIQUE KEY `hosp_id` (`hosp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`hosp_id`, `hosp_name`, `did_supports`, `hosp_logo`) VALUES
(1, 'Agha Khan Hospital', '[\"01A0\", \"01A1\", \"04B3\", \"08C9\"]', '');

-- --------------------------------------------------------

--
-- Table structure for table `insurance`
--

DROP TABLE IF EXISTS `insurance`;
CREATE TABLE IF NOT EXISTS `insurance` (
  `ipid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Insurance_code` varchar(5) NOT NULL,
  `insurance_comp_name` varchar(120) NOT NULL,
  `insurance_logo` varchar(255) NOT NULL,
  UNIQUE KEY `ipid` (`ipid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `insurance`
--

INSERT INTO `insurance` (`ipid`, `Insurance_code`, `insurance_comp_name`, `insurance_logo`) VALUES
(1, 'JLI', 'Jubilee Life Insurance', ''),
(2, 'NJI', 'New Jubilee Life Insurance', ''),
(3, 'EFU', 'EFU Life Insurance', '');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_claim`
--

DROP TABLE IF EXISTS `insurance_claim`;
CREATE TABLE IF NOT EXISTS `insurance_claim` (
  `claim_no` int(11) NOT NULL,
  `policy_number` varchar(15) NOT NULL,
  `CNIC` varchar(15) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `ipid` int(11) NOT NULL,
  `claim_date` datetime NOT NULL DEFAULT '2019-01-01 00:00:00',
  `inprocess_claim` bit(1) NOT NULL DEFAULT b'0',
  `status` bit(1) NOT NULL DEFAULT b'0',
  `hosp_id` int(11) NOT NULL,
  `claim_amount` int(11) NOT NULL,
  `did` json NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `insurance_claim`
--

INSERT INTO `insurance_claim` (`claim_no`, `policy_number`, `CNIC`, `patient_name`, `ipid`, `claim_date`, `inprocess_claim`, `status`, `hosp_id`, `claim_amount`, `did`) VALUES
(1, '215-32568-8', '42101-5356928-6', 'My Child', 1, '2019-03-25 19:55:00', b'1', b'0', 1, 75000, '[\"01A0\", \"01A1\"]'),
(2, '325-38486-9', '28101-5356928-6', 'Tanveer Ahmed', 2, '2019-05-15 14:30:00', b'0', b'1', 1, 50000, '[\"01A1\"]');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_policy_holder`
--

DROP TABLE IF EXISTS `insurance_policy_holder`;
CREATE TABLE IF NOT EXISTS `insurance_policy_holder` (
  `policy_number` varchar(15) NOT NULL,
  `ipid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `CNIC` varchar(15) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `valid_date` date NOT NULL,
  `total_limit` int(11) NOT NULL,
  `limit_consumed` int(11) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `tf_id` int(11) NOT NULL,
  `fcid` int(11) NOT NULL,
  UNIQUE KEY `fcid` (`fcid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `insurance_policy_holder`
--

INSERT INTO `insurance_policy_holder` (`policy_number`, `ipid`, `name`, `CNIC`, `mobile_number`, `valid_date`, `total_limit`, `limit_consumed`, `company_id`, `tf_id`, `fcid`) VALUES
('215-32568-8', 1, 'Ali Hamza', '42101-5356928-6', '+923123456789', '2019-12-31', 450000, 0, 1, 1, 1),
('325-38486-9', 2, 'Tanveer Ahmed', '28101-5356928-6', '+923124567899', '2019-12-31', 500000, 0, 1, 1, 2),
('215-32568-8', 3, 'Talha Khan', '52101-5356928-6', '+923145678978', '2019-12-31', 550000, 0, 1, 1, 3),
('325-38486-9', 1, 'Ashfaq Ahmed', '05661-5356928-6', '+923124587897', '2019-12-31', 450000, 0, 1, 1, 4),
('215-32568-8', 1, 'M. Faisal', '75801-5356928-6', '+923145678979', '2019-12-31', 450000, 0, 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `ins_ph_coverage`
--

DROP TABLE IF EXISTS `ins_ph_coverage`;
CREATE TABLE IF NOT EXISTS `ins_ph_coverage` (
  `fcid` int(11) NOT NULL,
  `patient_name` varchar(50) NOT NULL,
  `did_supports` json NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ins_ph_coverage`
--

INSERT INTO `ins_ph_coverage` (`fcid`, `patient_name`, `did_supports`) VALUES
(1, 'My Wife', '[\"01A0\", \"01A1\", \"04B3\", \"08C9\"]'),
(1, 'My Child', '[\"01A0\", \"01A1\", \"04B3\", \"08C9\"]'),
(2, 'Spouse', '[]'),
(2, 'Tanveer\' child 1', '[]'),
(3, 'Talha\' spouse', '[]'),
(3, 'Talha\'s Child', '[]');

-- --------------------------------------------------------

--
-- Table structure for table `limit_type`
--

DROP TABLE IF EXISTS `limit_type`;
CREATE TABLE IF NOT EXISTS `limit_type` (
  `ipid` int(11) NOT NULL,
  `tf_id` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `hospital` int(11) NOT NULL,
  `maternity_normal` int(11) NOT NULL,
  `maternity_complex` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `limit_type`
--

INSERT INTO `limit_type` (`ipid`, `tf_id`, `room`, `hospital`, `maternity_normal`, `maternity_complex`) VALUES
(1, 1, 2000, 300000, 80000, 120000),
(2, 1, 3000, 350000, 85000, 130000),
(3, 1, 3500, 400000, 90000, 150000);

-- --------------------------------------------------------

--
-- Table structure for table `tariff`
--

DROP TABLE IF EXISTS `tariff`;
CREATE TABLE IF NOT EXISTS `tariff` (
  `ipid` int(11) NOT NULL,
  `tf_id` int(11) NOT NULL,
  `tariff_name` varchar(25) NOT NULL,
  `packages` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tariff`
--

INSERT INTO `tariff` (`ipid`, `tf_id`, `tariff_name`, `packages`) VALUES
(1, 1, 'Standard Package', 450000),
(2, 1, 'Standard Package', 500000),
(3, 1, 'Standard Package', 550000);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
