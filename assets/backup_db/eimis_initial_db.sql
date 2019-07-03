-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2016 at 10:48 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xeroneit_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesses`
--

DROP TABLE IF EXISTS `accesses`;
CREATE TABLE IF NOT EXISTS `accesses` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `accesses` (`id`, `name`) VALUES
(1, 'Read'),
(2, 'Add'),
(3, 'Edit'),
(4, 'Delete'),
(5, 'Approve');

-- --------------------------------------------------------

--
-- Table structure for table `account_head`
--

DROP TABLE IF EXISTS `account_head`;
CREATE TABLE IF NOT EXISTS `account_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `account_type_id` int(11) NOT NULL,
  `remarks` text CHARACTER SET latin1 NOT NULL,
  `status` enum('0','1') CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

DROP TABLE IF EXISTS `account_type`;
CREATE TABLE IF NOT EXISTS `account_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_course`
--

DROP TABLE IF EXISTS `applicant_course`;
CREATE TABLE IF NOT EXISTS `applicant_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` bigint(11) NOT NULL COMMENT 'applicant_info.id',
  `class_id` int(11) NOT NULL,
  `type` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'mandatory',
  `course_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_info`
--

DROP TABLE IF EXISTS `applicant_info`;
CREATE TABLE IF NOT EXISTS `applicant_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admission_roll` varchar(20) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `name_bangla` varchar(100) CHARACTER SET latin1 NOT NULL,
  `father_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `father_name_bangla` varchar(100) CHARACTER SET latin1 NOT NULL,
  `mother_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `mother_name_bangla` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_relation` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_occupation` varchar(100) NOT NULL,
  `gurdian_income` double NOT NULL,
  `gurdian_present_village` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_present_post` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_present_thana` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_present_district` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_permanent_village` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_permanent_post` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_permanent_thana` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_permanent_district` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_mobile` varchar(50) DEFAULT NULL,
  `gurdian_email` varchar(100) DEFAULT NULL,
  `religion` varchar(100) CHARACTER SET latin1 NOT NULL,
  `quota_id` int(11) NOT NULL,
  `quota_description` text NOT NULL COMMENT 'name,identity,address',
  `previous_institute` varchar(100) CHARACTER SET latin1 NOT NULL,
  `class_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  `birth_certificate_no` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `gender` varchar(100) CHARACTER SET latin1 NOT NULL,
  `mobile` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `mobile_code` varchar(100) CHARACTER SET latin1 NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `payment_status` enum('0','1') CHARACTER SET latin1 NOT NULL COMMENT 'is form price paid?',
  `registered_at` datetime NOT NULL,
  `exam_version` enum('Bengali','English') CHARACTER SET latin1 NOT NULL DEFAULT 'Bengali',
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 NOT NULL,
  `image` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'is still applicant?',
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admission_roll` (`admission_roll`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `image` (`image`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `certificate_template`
--

DROP TABLE IF EXISTS `certificate_template`;
CREATE TABLE IF NOT EXISTS `certificate_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` enum('Character','Testimonial','Transfer','Appeared','Studentship') CHARACTER SET latin1 NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


INSERT INTO `certificate_template` (`id`, `name`, `content`) VALUES
(1, 'Character', ''),
(2, 'Testimonial', ''),
(3, 'Transfer', ''),
(4, 'Appeared', ''),
(5, 'Studentship', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `ip_address` varchar(16) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `user_agent` varchar(120) CHARACTER SET utf8 NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` longtext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `ordering` int(11) NOT NULL,
  `level` enum('Primary','Secondary','Higher Secondary','Graduation','Post Graduation') CHARACTER SET latin1 NOT NULL DEFAULT 'Primary',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ordering` (`ordering`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `class_period`
--

DROP TABLE IF EXISTS `class_period`;
CREATE TABLE IF NOT EXISTS `class_period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period_name` varchar(50) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ordering` (`ordering`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `class_roll`
--

DROP TABLE IF EXISTS `class_roll`;
CREATE TABLE IF NOT EXISTS `class_roll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `last_used_roll` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`,`dept_id`,`shift_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `class_routine`
--

DROP TABLE IF EXISTS `class_routine`;
CREATE TABLE IF NOT EXISTS `class_routine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `day` varchar(100) CHARACTER SET latin1 NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `status` enum('Subjective','All','None') CHARACTER SET latin1 NOT NULL DEFAULT 'None',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `class_section`
--

DROP TABLE IF EXISTS `class_section`;
CREATE TABLE IF NOT EXISTS `class_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `default` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'is default?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `class_shift`
--

DROP TABLE IF EXISTS `class_shift`;
CREATE TABLE IF NOT EXISTS `class_shift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shift_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `default` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'is default?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_code` varchar(50) DEFAULT NULL,
  `course_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `dept_id` int(11) NOT NULL,
  `type` enum('0','1') CHARACTER SET latin1 NOT NULL DEFAULT '1' COMMENT 'mandatory',
  `class_id` int(12) NOT NULL,
  `session_id` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `credit` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course_material`
--

DROP TABLE IF EXISTS `course_material`;
CREATE TABLE IF NOT EXISTS `course_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `course_id` int(12) NOT NULL,
  `class_id` int(12) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET latin1 NOT NULL,
  `document_url` varchar(100) CHARACTER SET latin1 NOT NULL,
  `session_id` int(11) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `class_id` int(11) NOT NULL,
  `default` enum('0','1') CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `start_roll` int(11) NOT NULL DEFAULT '1',
  `seat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
CREATE TABLE IF NOT EXISTS `district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `district_name` varchar(100) NOT NULL,
  `division_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `district_name`, `division_name`, `status`) VALUES
(1, 'Bagerhat', 'Khulna', 1),
(2, 'Bandarban', 'Chittagong', 1),
(3, 'Barguna', 'Barisal', 1),
(4, 'Barisal', 'Barishal', 1),
(5, 'Bhola', 'Barisal', 1),
(6, 'Bogra', 'Rajshahi', 1),
(7, 'Brahamanbaria', 'Chittagong', 1),
(8, 'Chandpur', 'Chittagong', 1),
(9, 'Chapainababganj', 'Rajshahi', 1),
(10, 'Chittagong', 'Chittagong', 1),
(11, 'Chuadanga', 'Khulna', 1),
(12, 'Comilla', 'Chittagong', 1),
(13, 'Cox''s Bazar', 'Chittagong', 1),
(14, 'Dhaka', 'Dhaka', 1),
(15, 'Dinajpur', 'Rangpur', 1),
(16, 'Faridpur', 'Dhaka', 1),
(17, 'Feni', 'Chittagong', 1),
(18, 'Gaibandha', 'Rangpur', 1),
(19, 'Gazipur', 'Dhaka', 1),
(20, 'Gopalganj', 'Dhaka', 1),
(21, 'Habiganj', 'Sylhet', 1),
(22, 'Jamalpur', 'Dhaka', 1),
(23, 'Jessore', 'Khulna', 1),
(24, 'Jhalokathi', 'Barisal', 1),
(25, 'Jhenaidah', 'Khulna', 1),
(26, 'Joypurhat', 'Rajshahi', 1),
(27, 'Khagrachhari', 'Chittagong', 1),
(28, 'Khulna', 'Khulna', 1),
(29, 'Kishorganj', 'Dhaka', 1),
(30, 'Kurigram', 'Rangpur', 1),
(31, 'Kushtia', 'Khulna', 1),
(32, 'Lalmonirhat', 'Rangpur', 1),
(33, 'Laxmipur', 'Chittagong', 1),
(34, 'Madaripur', 'Dhaka', 1),
(35, 'Magura', 'Khulna', 1),
(36, 'Manikganj', 'Dhaka', 1),
(37, 'Meherpur', 'Khulna', 1),
(38, 'Moulavibazar', 'Sylhet', 1),
(39, 'Munshiganj', 'Dhaka', 1),
(40, 'Mymensingh', 'Dhaka', 1),
(41, 'Naogaon', 'Rajshahi', 1),
(42, 'Narayanganj', 'Dhaka', 1),
(43, 'Natore', 'Rajshahi', 1),
(44, 'Netrakona', 'Dhaka', 1),
(45, 'Nilfamari', 'Rangpur', 1),
(46, 'Noakhali', 'Chittagong', 1),
(47, 'Norail', 'Khulna', 1),
(48, 'Norsingdi', 'Dhaka', 1),
(49, 'Pabna', 'Rajshahi', 1),
(50, 'Panchagarh', 'Rangpur', 1),
(51, 'Patuakhali', 'Barisal', 1),
(52, 'Pirojpur', 'Barisal', 1),
(53, 'Rajbari', 'Dhaka', 1),
(54, 'Rajshahi', 'Rajshahi', 1),
(55, 'Rangamati', 'Chittagong', 1),
(56, 'Rangpur', 'Rangpur', 1),
(57, 'Satkhira', 'Khulna', 1),
(58, 'Shariatpur', 'Khulna', 1),
(59, 'Sherpur', 'Dhaka', 1),
(60, 'Sirajganj', 'Rajshahi', 1),
(61, 'Sunamganj', 'Sylhet', 1),
(62, 'Sylhet', 'Sylhet', 1),
(63, 'Tangail', 'Dhaka', 1),
(64, 'Thakurgaon', 'Rangpur', 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

DROP TABLE IF EXISTS `email_config`;
CREATE TABLE IF NOT EXISTS `email_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email_address` varchar(200) NOT NULL,
  `smtp_host` varchar(200) NOT NULL,
  `smtp_port` varchar(100) NOT NULL,
  `smtp_user` varchar(100) NOT NULL,
  `smtp_password` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `financial_year`
--

DROP TABLE IF EXISTS `financial_year`;
CREATE TABLE IF NOT EXISTS `financial_year` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `status` enum('0','1') CHARACTER SET latin1 NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `forget_password`
--

DROP TABLE IF EXISTS `forget_password`;
CREATE TABLE IF NOT EXISTS `forget_password` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `confirmation_code` varchar(15) CHARACTER SET latin1 NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `success` int(11) NOT NULL DEFAULT '0',
  `expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `form_sell`
--

DROP TABLE IF EXISTS `form_sell`;
CREATE TABLE IF NOT EXISTS `form_sell` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `price` double NOT NULL COMMENT 'form price',
  `payment_method_id` int(11) NOT NULL,
  `payment_reference_no` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `paid_amount` double NOT NULL,
  `sold_by` int(11) NOT NULL COMMENT 'users.id (0 means online)',
  `sold_at` datetime NOT NULL,
  `remarks` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `applicant_id` (`applicant_id`),
  UNIQUE KEY `transaction_id` (`transaction_id`,`payment_method_id`),
  UNIQUE KEY `payment_reference_no` (`payment_reference_no`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gpa_config`
--

DROP TABLE IF EXISTS `gpa_config`;
CREATE TABLE IF NOT EXISTS `gpa_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_mark` double NOT NULL,
  `end_mark` double NOT NULL,
  `grade_point` float NOT NULL,
  `grade_name` varchar(100) NOT NULL,
  `result_type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `circulation`;
CREATE TABLE IF NOT EXISTS `circulation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(99) NOT NULL,
  `book_id` varchar(99) NOT NULL,
  `issue_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `return_date` date NOT NULL,
  `fine_amount` double NOT NULL,
  `is_returned` tinyint(1) NOT NULL,
  `is_expired` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


--
-- Table structure for table `circulation_config`
--

DROP TABLE IF EXISTS `circulation_config`;
CREATE TABLE IF NOT EXISTS `circulation_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_day_limit` varchar(99) NOT NULL,
  `issu_book_limit` int(11) NOT NULL,
  `fine_per_day` double NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `circulation_config`
--

INSERT INTO `circulation_config` (`id`, `issue_day_limit`, `issu_book_limit`, `fine_per_day`, `deleted`) VALUES
(1, '7', 3, 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `library_book_category`
--

DROP TABLE IF EXISTS `library_book_category`;
CREATE TABLE IF NOT EXISTS `library_book_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL COMMENT 'library_book_info.id',
  `category_id` int(11) NOT NULL COMMENT 'library_book_category.id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- Table structure for table `library_book_info`
--

DROP TABLE IF EXISTS `library_book_info`;
CREATE TABLE IF NOT EXISTS `library_book_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `physical_form` enum('Book','Journal','CD/DVD','Manuscript','Others') CHARACTER SET utf8 NOT NULL,
  `author` text CHARACTER SET utf8 NOT NULL,
  `subtitle` varchar(100) CHARACTER SET utf8 NOT NULL,
  `edition_year` year(4) NOT NULL,
  `publisher` varchar(100) CHARACTER SET utf8 NOT NULL,
  `series` varchar(100) CHARACTER SET utf8 NOT NULL,
  `size1` enum('Medium','Large','Huge','Small','Tiny') CHARACTER SET utf8 NOT NULL,
  `price` varchar(100) CHARACTER SET utf8 NOT NULL,
  `call_no` varchar(100) CHARACTER SET utf8 NOT NULL,
  `location` varchar(100) CHARACTER SET utf8 NOT NULL,
  `clue_page` varchar(100) CHARACTER SET utf8 NOT NULL,
  `category_id` varchar(100) CHARACTER SET utf8 NOT NULL,
  `editor` varchar(100) CHARACTER SET utf8 NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `edition` varchar(100) CHARACTER SET utf8 NOT NULL,
  `publishing_year` year(4) NOT NULL,
  `publication_place` varchar(100) CHARACTER SET utf8 NOT NULL,
  `number_of_pages` int(11) NOT NULL,
  `number_of_books` int(11) NOT NULL,
  `dues` varchar(100) CHARACTER SET utf8 NOT NULL,
  `isbn` varchar(100) CHARACTER SET utf8 NOT NULL,
  `source_details` enum('Local Purchase','University','World Bank Donation','Personal Donation','Others') CHARACTER SET utf8 NOT NULL,
  `notes` varchar(100) CHARACTER SET utf8 NOT NULL,
  `cover` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT 'cover_default.jpg',
  `pdf` text CHARACTER SET utf8,
  `is_uploaded` enum('0','1') CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `deleted` enum('0','1') CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `status` enum('0','1') CHARACTER SET utf8 NOT NULL DEFAULT '1',
  `add_date` datetime NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `isbn` (`isbn`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


--
-- Table structure for table `library_category`
--

DROP TABLE IF EXISTS `library_category`;
CREATE TABLE IF NOT EXISTS `library_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `deleted` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='all categories of book store here';



DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`) VALUES
(1, 'Administration - Role'),
(2, 'Administration - User'),
(3, 'Administration - Financial Year & Session'),
(4, 'Administration - Class'),
(5, 'Administration - Course'),
(6, 'Administration - Section\r\n'),
(7, 'Administration - Department'),
(8, 'Administration - Shift'),
(9, 'Administration - Certificate Template'),
(10, 'Administration - Rank & Designation\r\n'),
(11, 'Administration -  Account\r\n'),
(12, 'Administration - Period'),
(13, 'Administration - Online Admission'),
(14, 'Administration - Result Configuration'),
(15, 'Administration - Library'),
(16, 'Administration - Dashboard'),
(18, 'Notification'),
(19, 'Student -  Admission/Promotion'),
(20, 'Student -  Certificate Issue'),
(21, 'Student - Query/Complain'),
(22, 'Teacher'),
(23, 'Teacher - Assign Class'),
(24, 'Staff'),
(25, 'Accounts - Admission Report'),
(26, 'Accounts - Form Sell Report'),
(27, 'Result Processing & Report'),
(28, 'Library'),
(29, 'Online Admission'),
(30, 'Teacher attendance'),
(31, 'Administrator - SMS & Email Configuration'),
(32, 'Administrator - General Configuration');
INSERT INTO `modules` (`id`, `name`) VALUES (33, 'Administration - Yearly Config');

-- --------------------------------------------------------

--
-- Table structure for table `online_admission_configure`
--

DROP TABLE IF EXISTS `online_admission_configure`;
CREATE TABLE IF NOT EXISTS `online_admission_configure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `form_price` double NOT NULL DEFAULT '0',
  `is_admission_open` enum('0','1') NOT NULL DEFAULT '1',
  `is_admission_test` enum('0','1') NOT NULL DEFAULT '0',
  `application_last_date` date NOT NULL,
  `send_sms_after_application` enum('0','1') NOT NULL DEFAULT '0',
  `send_sms_after_admission` enum('0','1') NOT NULL DEFAULT '0',
  `usable_admission_roll` varchar(20) NOT NULL DEFAULT '0001',
  `admission_test_date` date NOT NULL,
  `result_publish_date` date NOT NULL,
  `admission_last_date` date NOT NULL,
  `notice_for_applicant` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `online_admission_merit_list`
--

DROP TABLE IF EXISTS `online_admission_merit_list`;
CREATE TABLE IF NOT EXISTS `online_admission_merit_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE IF NOT EXISTS `payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method_name` varchar(100) NOT NULL,
  `payment_method_type` enum('Offline','Paypal','Stripe','Bank') NOT NULL,
  `payment_account_no` varchar(100) NOT NULL,
  `api_username` varchar(100) NOT NULL,
  `api_password` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`id`, `payment_method_name`, `payment_method_type`, `payment_account_no`, `api_username`, `api_password`, `comment`, `status`) VALUES
(1, 'Cash', 'Offline', '', '', '', '', '1'),
(2, 'Bank', 'Bank', '', '', '', '', '1'),
(3, 'PayPal', 'Paypal', '', '', '', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `quota`
--

DROP TABLE IF EXISTS `quota`;
CREATE TABLE IF NOT EXISTS `quota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quota_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

DROP TABLE IF EXISTS `rank`;
CREATE TABLE IF NOT EXISTS `rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `for` enum('Teacher','Employee') CHARACTER SET latin1 NOT NULL,
  `type` enum('Academic','Administrative') CHARACTER SET latin1 NOT NULL COMMENT 'acedemic=desigation and administrative=rank for employee',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

DROP TABLE IF EXISTS `result`;
CREATE TABLE IF NOT EXISTS `result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) NOT NULL,
  `exam_id` int(10) NOT NULL,
  `obtained_gpa` float NOT NULL,
  `grade_name` varchar(100) NOT NULL,
  `total_marks` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`,`exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `result_config`
--

DROP TABLE IF EXISTS `result_config`;
CREATE TABLE IF NOT EXISTS `result_config` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `result_exam_name`
--

DROP TABLE IF EXISTS `result_exam_name`;
CREATE TABLE IF NOT EXISTS `result_exam_name` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `exam_name` varchar(150) NOT NULL,
  `class_id` int(10) NOT NULL,
  `dept_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `result_type` enum('marks','gpa','cgpa') NOT NULL,
  `is_complete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `result_marks`
--

DROP TABLE IF EXISTS `result_marks`;
CREATE TABLE IF NOT EXISTS `result_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(100) NOT NULL,
  `exam_id` int(10) NOT NULL,
  `course_id` int(11) NOT NULL,
  `obtained_mark` float DEFAULT NULL,
  `grade_point` float DEFAULT NULL,
  `grade` varchar(10) NOT NULL,
  `is_submit` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`,`exam_id`,`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `departments` text CHARACTER SET latin1 NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `editable` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`, `name`, `departments`, `status`, `editable`) VALUES
(1, 'Admin', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100', '1', '0'),
(2, 'Student', '0', '1', '0'),
(3, 'Teacher', '0', '1', '0'),
(4, 'Staff', '0', '1', '0');


-- --------------------------------------------------------

--
-- Table structure for table `role_privilleges`
--

DROP TABLE IF EXISTS `role_privilleges`;
CREATE TABLE IF NOT EXISTS `role_privilleges` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `role_id` int(30) NOT NULL,
  `modules` varchar(30) CHARACTER SET latin1 NOT NULL,
  `accesses` varchar(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `role_privilleges` (`id`, `role_id`, `modules`, `accesses`) VALUES
(1, 1, '1', '1,2,3,4,5'),
(2, 1, '2', '1,2,3,4,5'),
(3, 1, '3', '1,2,3,4,5'),
(4, 1, '4', '1,2,3,4,5'),
(5, 1, '5', '1,2,3,4,5'),
(6, 1, '6', '1,2,3,4,5'),
(7, 1, '7', '1,2,3,4,5'),
(8, 1, '8', '1,2,3,4,5'),
(9, 1, '9', '1,2,3,4,5'),
(10, 1, '10', '1,2,3,4,5'),
(11, 1, '11', '1,2,3,4,5'),
(12, 1, '12', '1,2,3,4,5'),
(13, 1, '13', '1,2,3,4,5'),
(14, 1, '14', '1,2,3,4,5'),
(15, 1, '15', '1,2,3,4,5'),
(16, 1, '16', '1,2,3,4,5'),
(18, 1, '18', '1,2,3,4,5'),
(19, 1, '19', '1,2,3,4,5'),
(20, 1, '20', '1,2,3,4,5'),
(21, 1, '21', '1,2,3,4,5'),
(22, 1, '22', '1,2,3,4,5'),
(23, 1, '23', '1,2,3,4,5'),
(24, 1, '24', '1,2,3,4,5'),
(25, 1, '25', '1,2,3,4,5'),
(26, 1, '26', '1,2,3,4,5'),
(27, 1, '27', '1,2,3,4,5'),
(28, 1, '28', '1,2,3,4,5'),
(29, 1, '29', '1,2,3,4,5'),
(30, 1, '30', '1,2,3,4,5'),
(31, 1, '31', '1,2,3,4,5'),
(32, 1, '32', '1,2,3,4,5'),
(33, 1, '33', '1,2,3,4,5'),
(34, 1, '34', '1,2,3,4,5'),
(35, 1, '35', '1,2,3,4,5'),
(36, 1, '36', '1,2,3,4,5'),
(37, 1, '37', '1,2,3,4,5'),
(38, 1, '38', '1,2,3,4,5'),
(39, 1, '39', '1,2,3,4,5'),
(40, 1, '40', '1,2,3,4,5'),
(41, 1, '41', '1,2,3,4,5'),
(42, 1, '42', '1,2,3,4,5'),
(43, 1, '43', '1,2,3,4,5'),
(44, 1, '44', '1,2,3,4,5'),
(45, 1, '45', '1,2,3,4,5'),
(46, 1, '46', '1,2,3,4,5'),
(47, 1, '47', '1,2,3,4,5'),
(48, 1, '48', '1,2,3,4,5'),
(49, 1, '49', '1,2,3,4,5'),
(50, 1, '50', '1,2,3,4,5'),
(54, 5, '15', '1,2,3,4,5'),
(55, 5, '28', '1,2,3,4,5');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slip`
--

DROP TABLE IF EXISTS `slip`;
CREATE TABLE IF NOT EXISTS `slip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slip_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `class_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `slip_type` enum('Admission','Post Admission') NOT NULL,
  `financial_year_id` int(11) NOT NULL COMMENT 'session.id',
  `total_amount` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_id` (`class_id`,`dept_id`,`slip_type`,`financial_year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slip_head`
--

DROP TABLE IF EXISTS `slip_head`;
CREATE TABLE IF NOT EXISTS `slip_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slip_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sms_config`
--

DROP TABLE IF EXISTS `sms_config`;
CREATE TABLE IF NOT EXISTS `sms_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` enum('planet','plivo','twilio','2-way','clickatell') CHARACTER SET utf8 NOT NULL,
  `auth_id` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `api_id` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sms_email_history`
--

DROP TABLE IF EXISTS `sms_email_history`;
CREATE TABLE IF NOT EXISTS `sms_email_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_info_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET latin1 NOT NULL COMMENT 'subject',
  `message` text CHARACTER SET latin1 NOT NULL,
  `sent_at` datetime NOT NULL,
  `type` enum('SMS','Email','Notification') NOT NULL DEFAULT 'Email',
  `viewed` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_education_info`
--

DROP TABLE IF EXISTS `staff_education_info`;
CREATE TABLE IF NOT EXISTS `staff_education_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `level` varchar(100) CHARACTER SET latin1 NOT NULL,
  `institute` varchar(100) CHARACTER SET latin1 NOT NULL,
  `duration` varchar(50) CHARACTER SET latin1 NOT NULL,
  `result` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_info`
--

DROP TABLE IF EXISTS `staff_info`;
CREATE TABLE IF NOT EXISTS `staff_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(100) NOT NULL,
  `national_id` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `religion` enum('Islam','Hinduism','Cristianity','Buddhist','Others') CHARACTER SET latin1 NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET latin1 NOT NULL,
  `rank_id` int(11) NOT NULL COMMENT 'rank.id',
  `job_class_id` int(11) NOT NULL COMMENT 'rank.id',
  `father_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `mobile` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `home_district` int(11) NOT NULL COMMENT 'district.id',
  `address` text CHARACTER SET latin1 NOT NULL,
  `image` text CHARACTER SET latin1,
  `staff_no` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT 'employeeID or TeacherID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `teacher_no` (`staff_no`),
  UNIQUE KEY `national_id` (`national_id`),
  UNIQUE KEY `image` (`image`(500))
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_training_info`
--

DROP TABLE IF EXISTS `staff_training_info`;
CREATE TABLE IF NOT EXISTS `staff_training_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `training_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `institute_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `address` text CHARACTER SET latin1 NOT NULL,
  `duration` varchar(100) CHARACTER SET latin1 NOT NULL,
  `remarks` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_attendence`
--

DROP TABLE IF EXISTS `student_attendence`;
CREATE TABLE IF NOT EXISTS `student_attendence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_info_id` int(11) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `class_id` int(100) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

DROP TABLE IF EXISTS `student_course`;
CREATE TABLE IF NOT EXISTS `student_course` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL COMMENT 'student_info.id',
  `class_id` int(11) NOT NULL,
  `type` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'mandatory',
  `course_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

DROP TABLE IF EXISTS `student_info`;
CREATE TABLE IF NOT EXISTS `student_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_roll` varchar(20) DEFAULT NULL,
  `student_id` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `name_bangla` varchar(100) NOT NULL,
  `father_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `father_name_bangla` varchar(100) NOT NULL,
  `mother_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `mother_name_bangla` varchar(100) NOT NULL,
  `gurdian_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_relation` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_occupation` varchar(100) NOT NULL,
  `gurdian_income` double NOT NULL,
  `gurdian_present_village` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_present_post` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_present_thana` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_present_district` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_permanent_village` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_permanent_post` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_permanent_thana` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_permanent_district` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gurdian_mobile` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `gurdian_email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `religion` varchar(100) CHARACTER SET latin1 NOT NULL,
  `quota_id` int(11) NOT NULL,
  `quota_description` text NOT NULL COMMENT 'name,identity,address',
  `previous_institute` varchar(100) CHARACTER SET latin1 NOT NULL,
  `class_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  `birth_certificate_no` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `gender` enum('Male','Female') CHARACTER SET latin1 NOT NULL,
  `mobile` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `mobile_code` varchar(100) CHARACTER SET latin1 NOT NULL,
  `payment_status` enum('0','1') CHARACTER SET latin1 NOT NULL,
  `admitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `exam_version` enum('Bengali','English') CHARACTER SET latin1 NOT NULL DEFAULT 'Bengali',
  `image` text CHARACTER SET latin1,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'is still student?',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`),
  UNIQUE KEY `birth_certificate_no` (`birth_certificate_no`),
  UNIQUE KEY `class_roll` (`class_roll`,`session_id`,`shift_id`,`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_query`
--

DROP TABLE IF EXISTS `student_query`;
CREATE TABLE IF NOT EXISTS `student_query` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_info_id` int(11) NOT NULL,
  `message_subject` text NOT NULL,
  `message_body` text NOT NULL,
  `sent_at` datetime NOT NULL,
  `replied` enum('0','1') NOT NULL DEFAULT '0',
  `reply_message` text NOT NULL,
  `reply_at` datetime NOT NULL,
  `reply_viewed` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_education_info`
--

DROP TABLE IF EXISTS `teacher_education_info`;
CREATE TABLE IF NOT EXISTS `teacher_education_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `level` varchar(100) CHARACTER SET latin1 NOT NULL,
  `institute` varchar(100) CHARACTER SET latin1 NOT NULL,
  `duration` varchar(50) CHARACTER SET latin1 NOT NULL,
  `result` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_info`
--

DROP TABLE IF EXISTS `teacher_info`;
CREATE TABLE IF NOT EXISTS `teacher_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_name` varchar(100) NOT NULL,
  `national_id` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `religion` enum('Islam','Hinduism','Cristianity','Buddhist','Others') CHARACTER SET latin1 NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET latin1 NOT NULL,
  `rank_id` int(11) NOT NULL COMMENT 'rank.id',
  `administrative_rank` int(11) NOT NULL COMMENT 'rank.id',
  `father_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `mobile` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `home_district` int(11) NOT NULL COMMENT 'district.id',
  `address` text CHARACTER SET latin1 NOT NULL,
  `image` text CHARACTER SET latin1,
  `teacher_no` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT 'employeeID or TeacherID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `teacher_no` (`teacher_no`),
  UNIQUE KEY `national_id` (`national_id`),
  UNIQUE KEY `image` (`image`(500))
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_staff_attendance`
--

DROP TABLE IF EXISTS `teacher_staff_attendance`;
CREATE TABLE IF NOT EXISTS `teacher_staff_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_staff_id` varchar(100) NOT NULL,
  `teacher_staff_name` varchar(150) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` int(5) NOT NULL,
  `user_type` enum('1','2') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_training_info`
--

DROP TABLE IF EXISTS `teacher_training_info`;
CREATE TABLE IF NOT EXISTS `teacher_training_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `training_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `institute_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `address` text CHARACTER SET latin1 NOT NULL,
  `duration` varchar(100) CHARACTER SET latin1 NOT NULL,
  `remarks` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `thana`
--

DROP TABLE IF EXISTS `thana`;
CREATE TABLE IF NOT EXISTS `thana` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `district_id` int(11) NOT NULL,
  `thana_name` varchar(250) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

DROP TABLE IF EXISTS `transaction_history`;
CREATE TABLE IF NOT EXISTS `transaction_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_info_id` varchar(100) CHARACTER SET latin1 NOT NULL,
  `slip_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `total_amount` double NOT NULL,
  `date_time` date NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `payment_reference_no` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_method_id` (`payment_method_id`,`payment_reference_no`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


ALTER TABLE `transaction_history` ADD `paid_amount` DOUBLE NOT NULL AFTER `transaction_id`;
ALTER TABLE `transaction_history` ADD `payment_date` DATETIME NOT NULL AFTER `paid_amount`;
ALTER TABLE `transaction_history` ADD `user_id` INT NOT NULL AFTER `payment_date`;
ALTER TABLE `transaction_history` ADD `payment_method` VARCHAR(100) NOT NULL AFTER `user_id`;

-- --------------------------------------------------------

--
-- Table structure for table `university_board`
--

DROP TABLE IF EXISTS `university_board`;
CREATE TABLE IF NOT EXISTS `university_board` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `institute_name` text CHARACTER SET latin1 NOT NULL,
  `is_university` int(1) NOT NULL DEFAULT '1',
  `district_id` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `email` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `password` varchar(50) CHARACTER SET latin1 NOT NULL,
  `role_id` int(50) NOT NULL,
  `user_type` enum('Operator','Individual') CHARACTER SET latin1 NOT NULL,
  `type_details` enum('Applicant','Student','Teacher') CHARACTER SET latin1 NOT NULL,
  `reference_id` varchar(50) CHARACTER SET latin1 NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `payment_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paypal_email` varchar(250) NOT NULL,
  `stripe_secret_key` varchar(150) NOT NULL,
  `stripe_publishable_key` varchar(150) NOT NULL,
  `currency` enum('USD','AUD','CAD','EUR','ILS','NZD','RUB','SGD','SEK','BRL','VND') CHARACTER SET utf8 NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `payment_config` (`id`, `paypal_email`, `stripe_secret_key`, `stripe_publishable_key`, `currency`, `deleted`) VALUES
(1, 'paypal_email@example.com', ' ', '', 'USD', '0');


ALTER TABLE `student_course` ADD INDEX(`student_id`);
ALTER TABLE `applicant_course` ADD INDEX(`applicant_id`);
ALTER TABLE `course` ADD INDEX( `dept_id`, `class_id`, `session_id`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE
ALGORITHM = UNDEFINED
VIEW `view_applicant_info`

(id, admission_roll, name, name_bangla, father_name, father_name_bangla, mother_name, mother_name_bangla, gurdian_name, gurdian_relation, gurdian_occupation, gurdian_income, gurdian_present_village, gurdian_present_post, gurdian_present_thana, gurdian_present_district, gurdian_permanent_village, gurdian_permanent_post, gurdian_permanent_thana, gurdian_permanent_district, gurdian_mobile, gurdian_email, religion, quota_id, quota_description, previous_institute, class_id, dept_id, shift_id, session_id, birth_date, birth_certificate_no, gender, mobile, mobile_code, email, payment_status, registered_at, exam_version, username, password, image, status, deleted,class_name,dept_name,shift_name,session_name,price,payment_method_id,payment_method_name,sold_by,sold_by_name,sold_at,remarks,courses,quota_name,is_in_merit_list)

 
AS

select applicant_info.*,class_name,dept_name,shift_name,session.name,price,payment_method_id,payment_method_name,sold_by,users.username,sold_at,remarks,
group_concat(DISTINCT  cast( REPLACE(course.course_name,',','__') as char)  order by course.id separator ',') as course,quota_name,online_admission_merit_list.status

from applicant_info 

left join class on (class.id=applicant_info.class_id)

left join department on (department.id=applicant_info.dept_id)

left join class_shift on (class_shift.id= applicant_info.shift_id)

left join session on (session.id=applicant_info.session_id)

left join form_sell on (applicant_info.id=form_sell.applicant_id)

left join users on (form_sell.sold_by=users.id)

left join payment_method on (form_sell.payment_method_id=payment_method.id)

left join applicant_course on (applicant_course.applicant_id=applicant_info.id)

left join course on (applicant_course.course_id=course.id)

left join online_admission_merit_list on (applicant_info.id=online_admission_merit_list.applicant_id)

left join quota on (applicant_info.quota_id=quota.id)


group by applicant_course.applicant_id;




CREATE
ALGORITHM = UNDEFINED
VIEW `view_result_marks`(id,student_id,exam_id,course_id,obtained_mark,grade_point,grade,is_submit,class_id,dept_id,session_id,exam_name,class_name,course_name,dept_name,session_name,is_complete,student_name)
 
AS

select result_marks.*,result_exam_name.class_id,result_exam_name.dept_id,result_exam_name.session_id,result_exam_name.exam_name,class.class_name,course.course_name,department.dept_name,session.name as session_name,result_exam_name.is_complete,student_info.name


from result_marks

left join result_exam_name on (result_exam_name.id = result_marks.exam_id)

left join course on (course.id = result_marks.course_id)

left join class on (result_exam_name.class_id = class.id)

left join department on (result_exam_name.dept_id = department.id)

left join session on (result_exam_name.session_id = session.id)

left join student_info on (student_info.student_id = result_marks.student_id);



CREATE
 ALGORITHM = UNDEFINED
 VIEW `view_student_info`
 
 (id,class_roll,student_id,name,name_bangla,father_name,father_name_bangla,mother_name,mother_name_bangla,gurdian_name,gurdian_relation,gurdian_occupation,gurdian_income,gurdian_present_village,
 gurdian_present_post,gurdian_present_thana,gurdian_present_district,gurdian_permanent_village,gurdian_permanent_post,gurdian_permanent_thana,
 gurdian_permanent_district,gurdian_mobile,gurdian_email,religion,quota_id,quota_description,previous_institute,class_id,dept_id,section_id,shift_id,session_id,birth_date,birth_certificate_no,gender,
 mobile,email,mobile_code,payment_status,admitted_at,
 exam_version,image,status,deleted,gurdian_present_thana_name , gurdian_present_district_name ,gurdian_permanent_thana_name,gurdian_permanent_district_name,class_name,dept_name, 
 section_name,shift_name,courses,session_name)
 
 AS 
 
select student_info.*, present_thana.thana_name, present_district.district_name, permanent_thana.thana_name, permanent_district.district_name,class_name,
dept_name,section_name,shift_name, 

group_concat(DISTINCT  cast( REPLACE(course.course_name,',','__') as char)  order by course.id separator ',') as course,
session.name

from student_info 

left join  thana as present_thana on (present_thana.id=student_info.gurdian_present_thana)

left join thana as permanent_thana on (permanent_thana.id=student_info.gurdian_permanent_thana)

left join district as present_district on (present_district.id=student_info.gurdian_present_district)

left join district as permanent_district on (permanent_district.id= student_info.gurdian_permanent_district)

left join class on (class.id=student_info.class_id)

left join department on (department.id=student_info.dept_id)

left join class_section on (class_section.id = student_info.section_id)

left join class_shift on (class_shift.id= student_info.shift_id)

left join student_course on (student_course.student_id=student_info.id)

left join course on (student_course.course_id=course.id)

left join session on (session.id=student_info.session_id)


group by student_course.student_id;



CREATE
 ALGORITHM = UNDEFINED
 VIEW `view_class_routine`
 
 (id,class_id,course_id,period_id,day,start_time,end_time,teacher_id,section_id,dept_id,shift_id,session_id,status,class_name,course_name, 
 teacher_name,section_name,shift_name,dept_name,session,period_name)  

 AS 
 
 
Select class_routine.*, class_name,course_name, teacher_name, section_name,shift_name,dept_name,session.name as session,period_name

from class_routine 

left join class on (class.id=class_routine.class_id)

left join course on (class_routine.course_id=course.id)

left join teacher_info on (class_routine.teacher_id=teacher_info.id)


left join class_section on (class_section.id = class_routine.section_id)

left join class_shift on (class_shift.id= class_routine.shift_id)

left join department on (department.id=class_routine.dept_id)

left join session on (session.id=class_routine.session_id)

left join class_period on (class_routine.period_id=class_period.id);



CREATE
 ALGORITHM = UNDEFINED
 VIEW `view_student_attendence`
 (student_info_id,student_id,teacher_id,class_id,course_id,dept_id,section_id,shift_id,session_id,total_class,present_class,present_percentage,class_name,course_name,course_code,
section_name,shift_name,dept_name,session,teacher_name)

 AS 
 
select student_info_id,student_id,teacher_id,student_attendence.class_id,student_attendence.course_id,student_attendence.dept_id,student_attendence.section_id,student_attendence.shift_id,student_attendence.session_id,count(student_attendence.id) as total_class , 
SUM(student_attendence.status) as present_class, SUM(student_attendence.status)/count(student_attendence.id)*100 as percent,class_name,course_name,course_code,
section_name,shift_name,dept_name,session.name,teacher_name from

student_attendence

left join class on (class.id=student_attendence.class_id)

left join course on (student_attendence.course_id=course.id)

left join class_section on (class_section.id = student_attendence.section_id)

left join class_shift on (class_shift.id= student_attendence.shift_id)

left join department on (department.id=student_attendence.dept_id)

left join session on (session.id=student_attendence.session_id)

left join teacher_info on (teacher_info.id=student_attendence.teacher_id)

group by `course_id` , `student_id`;




CREATE
 ALGORITHM = UNDEFINED
 VIEW `view_slip_details`
 
 (id, slip_name,class_id,dept_id,slip_type,financial_year_id,total_amount,heads_name, heads_id, slip_amount,class_name, dept_name, session_name)
 
 AS
 
select slip.*,
group_concat(DISTINCT  cast(REPLACE(account_head.account_name,',','__') as char)  order by slip_head.id separator ',') as head_name,
group_concat(DISTINCT  cast(REPLACE(slip_head.account_id,',','__') as char)  order by slip_head.id separator ',') as head_id,
group_concat(cast(REPLACE(slip_head.amount,',','__') as char)  order by slip_head.id separator ',') as slip_amount,
class.class_name, department.dept_name,session.name as session_name

from slip 
left join slip_head on (slip.id=slip_head.slip_id)
left join account_head on (slip_head.account_id=account_head.id)
left join class on (class.id=slip.class_id)
left join department on (department.id=slip.dept_id)
left join session on (session.id=slip.financial_year_id)

group by slip_head.slip_id;


CREATE
ALGORITHM = UNDEFINED
VIEW `view_transaction_details`(id,student_info_id,slip_id,class_id,payment_type,total_amount,date_time,payment_method_id,payment_reference_no,transaction_id,paid_amount,payment_date,user_id,payment_method,slip_name,dept_id,slip_type,
financial_year_id,total_amount_2,heads_name,heads_id,slip_amount,class_name,dept_name,session_name,payment_method_name,payment_method_type,payment_account_no,name)
AS
select transaction_history.*,
view_slip_details.slip_name,view_slip_details.dept_id,view_slip_details.slip_type,view_slip_details.financial_year_id,view_slip_details.total_amount,heads_name, 
heads_id, view_slip_details.slip_amount,view_slip_details.class_name,view_slip_details.dept_name, view_slip_details.session_name
,payment_method_name,payment_method_type,payment_account_no,student_info.name 
from transaction_history
left join view_slip_details on (view_slip_details.id=transaction_history.slip_id)
left join payment_method on (payment_method.id=transaction_history.payment_method_id)
left join student_info on (student_info.id=transaction_history.student_info_id);
