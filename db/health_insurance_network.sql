-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 19, 2019 at 06:44 PM
-- Server version: 5.7.19
-- PHP Version: 7.0.23

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
-- Table structure for table `diagnosis`
--

DROP TABLE IF EXISTS `diagnosis`;
CREATE TABLE IF NOT EXISTS `diagnosis` (
  `did` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `diag_code` int(11) NOT NULL,
  `diag_name` int(11) NOT NULL,
  UNIQUE KEY `did` (`did`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hin_user`
--

DROP TABLE IF EXISTS `hin_user`;
CREATE TABLE IF NOT EXISTS `hin_user` (
  `uid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` bit(1) NOT NULL,
  `sub_role` varchar(50) NOT NULL,
  UNIQUE KEY `uid` (`uid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email_id` (`email_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hin_user`
--

INSERT INTO `hin_user` (`uid`, `name`, `email_id`, `username`, `password`, `role`, `sub_role`) VALUES
(0, 'Admin User', 'aliazeemh@gmail.com', 'admin', '*EFF0C114C1FD3F32E7EFF9778ABCE91A9224B99A', b'0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

DROP TABLE IF EXISTS `hospital`;
CREATE TABLE IF NOT EXISTS `hospital` (
  `hosp_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hosp_name` varchar(120) NOT NULL,
  `did_supports` json NOT NULL,
  UNIQUE KEY `hosp_id` (`hosp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `insurance`
--

DROP TABLE IF EXISTS `insurance`;
CREATE TABLE IF NOT EXISTS `insurance` (
  `ipid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `insurance_comp_name` varchar(120) NOT NULL,
  UNIQUE KEY `ipid` (`ipid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_claim`
--

DROP TABLE IF EXISTS `insurance_claim`;
CREATE TABLE IF NOT EXISTS `insurance_claim` (
  `claim_no` int(11) NOT NULL,
  `policy_number` int(11) NOT NULL,
  `ipid` int(11) NOT NULL,
  `inprocess_claim` bit(1) NOT NULL DEFAULT b'0',
  `status` bit(1) NOT NULL DEFAULT b'0',
  `hosp_id` int(11) NOT NULL,
  `claim_amount` int(11) NOT NULL,
  `did` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_policy_holder`
--

DROP TABLE IF EXISTS `insurance_policy_holder`;
CREATE TABLE IF NOT EXISTS `insurance_policy_holder` (
  `policy_number` int(11) NOT NULL,
  `ipid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `CNIC` int(11) NOT NULL,
  `mobile_number` int(11) NOT NULL,
  `valid_date` date NOT NULL,
  `total_limit` int(11) NOT NULL,
  `limit_consumed` int(11) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `tf_id` int(11) NOT NULL,
  `fcid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `limit_type`
--

DROP TABLE IF EXISTS `limit_type`;
CREATE TABLE IF NOT EXISTS `limit_type` (
  `tf_id` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `hospital` int(11) NOT NULL,
  `maternity_normal` int(11) NOT NULL,
  `maternity_complex` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tariff`
--

DROP TABLE IF EXISTS `tariff`;
CREATE TABLE IF NOT EXISTS `tariff` (
  `ipid` int(11) NOT NULL,
  `tf_id` int(11) NOT NULL,
  `tariff_name` int(11) NOT NULL,
  `packages` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
