-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 23, 2020 at 01:45 PM
-- Server version: 5.6.46-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectmanagementapp`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `user_auth`$$
CREATE DEFINER=`cpses_nawf8asm70`@`localhost` PROCEDURE `user_auth` (IN `user_name` CHAR(15), IN `pass` VARCHAR(20))  BEGIN
	SELECT USER_LOGIN.Username, USER_LOGIN.salt INTO @id, @salt FROM USER_LOGIN WHERE USER_LOGIN.username = user_name;
	IF (SELECT COUNT(USER_LOGIN.Username) FROM USER_LOGIN WHERE USER_LOGIN.Username = user_name AND USER_LOGIN.PasswordHash = UNHEX(SHA1(CONCAT(HEX(@salt), pass)))) != 1 THEN
		SET @message_text = 'Login incorrect';
		SELECT @message_text as response;
	ELSE
		SELECT @id AS username;
	END IF;
END$$

DROP PROCEDURE IF EXISTS `user_create`$$
CREATE DEFINER=`cpses_nawf8asm70`@`localhost` PROCEDURE `user_create` (IN `user_name` VARCHAR(15), IN `pass` VARCHAR(20))  BEGIN
	IF (SELECT COUNT(USER_LOGIN.Username) FROM USER_LOGIN WHERE USER_LOGIN.Username = user_name) > 0 THEN
		SET @message_text = CONCAT('Username '', user_name, '' already exists');
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;
	ELSE
		SET @salt = UNHEX(SHA1(CONCAT(RAND(), RAND(), RAND())));
		INSERT INTO USER_LOGIN(Username, ClientID, EmployeeID, PasswordHash, Salt)
        VALUES (user_name, NULL, NULL, UNHEX(SHA1(CONCAT(HEX(@salt), pass))), @salt);
	END IF;
END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `Check_Leader_ID`$$
$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ASSIGNED_MENU`
--

DROP TABLE IF EXISTS `ASSIGNED_MENU`;
CREATE TABLE IF NOT EXISTS `ASSIGNED_MENU` (
  `AssignedID` int(6) NOT NULL AUTO_INCREMENT,
  `MenuID` int(6) NOT NULL,
  `Username` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`AssignedID`),
  KEY `MenuID` (`MenuID`),
  KEY `Username` (`Username`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ASSIGNED_MENU`
--

INSERT INTO `ASSIGNED_MENU` (`AssignedID`, `MenuID`, `Username`) VALUES
(1, 1, 'jlimano'),
(2, 2, 'jlimano'),
(3, 3, 'jlimano'),
(4, 1, 'junren'),
(5, 2, 'junren'),
(6, 3, 'junren'),
(7, 1, 'violeta'),
(8, 2, 'violeta'),
(9, 3, 'violeta'),
(10, 1, 'yaseen'),
(11, 2, 'yaseen'),
(12, 3, 'yaseen'),
(13, 1, 'dbotello'),
(14, 2, 'dbotello'),
(15, 3, 'dbotello'),
(16, 4, 'jsmith'),
(17, 5, 'jlimano'),
(18, 5, 'junren'),
(19, 5, 'violeta'),
(20, 5, 'dbotello'),
(21, 5, 'yaseen'),
(22, 6, 'jlimano'),
(23, 6, 'junren'),
(24, 6, 'dbotello'),
(25, 6, 'violeta'),
(26, 6, 'yaseen'),
(27, 7, 'jlimano'),
(28, 7, 'junren'),
(29, 7, 'dbotello'),
(30, 7, 'violeta'),
(31, 7, 'yaseen'),
(32, 8, 'jlimano'),
(33, 8, 'junren'),
(34, 8, 'dbotello'),
(35, 8, 'violeta'),
(36, 8, 'yaseen'),
(37, 8, 'jdoe'),
(38, 8, 'jdoe2'),
(39, 4, 'dsmith');

-- --------------------------------------------------------

--
-- Table structure for table `BUDGET`
--

DROP TABLE IF EXISTS `BUDGET`;
CREATE TABLE IF NOT EXISTS `BUDGET` (
  `BudgetID` int(6) NOT NULL AUTO_INCREMENT,
  `ProjectID` int(6) NOT NULL,
  `ItemName` varchar(25) DEFAULT NULL,
  `AllocationCost` double DEFAULT NULL,
  `EmpID` int(6) DEFAULT NULL,
  `WorksID` int(6) DEFAULT NULL,
  PRIMARY KEY (`BudgetID`),
  KEY `ProjectID` (`ProjectID`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `BUDGET`
--

INSERT INTO `BUDGET` (`BudgetID`, `ProjectID`, `ItemName`, `AllocationCost`, `EmpID`, `WorksID`) VALUES
(1, 1, 'SALARY INFO', 5580, 5, NULL),
(2, 1, 'SALARY INFO', 5550, 4, NULL),
(3, 1, 'SALARY INFO', 5580, 6, NULL),
(4, 1, 'SALARY INFO', 5625, 7, NULL),
(5, 1, 'SALARY INFO', 5625, 8, NULL),
(6, 2, 'SALARY INFO', 8205, 4, NULL),
(7, 2, 'SALARY INFO', 8175, 5, NULL),
(8, 2, 'SALARY INFO', 8205, 6, NULL),
(9, 2, 'SALARY INFO', 8160, 7, NULL),
(10, 2, 'SALARY INFO', 8160, 8, NULL),
(11, 3, 'SALARY INFO', 8325, 4, NULL),
(12, 3, 'SALARY INFO', 8295, 5, NULL),
(13, 3, 'SALARY INFO', 8325, 6, NULL),
(14, 3, 'SALARY INFO', 8325, 7, NULL),
(15, 3, 'SALARY INFO', 8325, 8, NULL),
(16, 3, 'SALARY INFO', 76, 5, NULL),
(17, 1, 'SALARY INFO', 15, 5, NULL),
(18, 3, 'SALARY INFO', 75, 6, NULL),
(19, 1, 'SALARY INFO', 75, 8, 0),
(20, 1, 'SALARY INFO', 15, 5, 150),
(21, 1, 'SALARY INFO', 15, 5, 152),
(22, 1, 'SALARY INFO', 15, 5, 153),
(23, 1, 'SALARY INFO', 15, 5, 154),
(24, 1, 'SALARY INFO', 30.5, 5, 155),
(25, 1, 'SALARY INFO', 69, 4, 156),
(32, 1, 'overtime food reimburse', 150, NULL, NULL),
(31, 1, 'transport reimburse', 500, NULL, NULL),
(39, 1, 'salary', 0, 4, NULL),
(40, 1, 'SALARY INFO', 75, 6, 165),
(41, 1, 'SALARY INFO', 75, 6, 166);

--
-- Triggers `BUDGET`
--
DROP TRIGGER IF EXISTS `Delete_BUDGET_Trigger`;
DELIMITER $$
CREATE TRIGGER `Delete_BUDGET_Trigger` AFTER DELETE ON `BUDGET` FOR EACH ROW UPDATE `PROJECT` SET PROJECT.NetGainOrLoss = PROJECT.Revenue - (SELECT SUM(AllocationCost) FROM `BUDGET` WHERE BUDGET.ProjectID = PROJECT.ProjectID) WHERE OLD.ProjectID = PROJECT.ProjectID
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `UPDATE_PROJECT_ON_INsERT`;
DELIMITER $$
CREATE TRIGGER `UPDATE_PROJECT_ON_INsERT` AFTER INSERT ON `BUDGET` FOR EACH ROW UPDATE `PROJECT` SET PROJECT.NetGainOrLoss = PROJECT.Revenue - (SELECT SUM(AllocationCost) FROM `BUDGET` WHERE BUDGET.ProjectID = PROJECT.ProjectID) WHERE NEW.ProjectID = PROJECT.ProjectID
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `UPDATE_PROJECT_ON_UPDATE`;
DELIMITER $$
CREATE TRIGGER `UPDATE_PROJECT_ON_UPDATE` AFTER UPDATE ON `BUDGET` FOR EACH ROW UPDATE `PROJECT` SET PROJECT.NetGainOrLoss = PROJECT.Revenue - (SELECT SUM(AllocationCost) FROM `BUDGET` WHERE BUDGET.ProjectID = PROJECT.ProjectID) WHERE PROJECT.ProjectID = NEW.ProjectID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `CLIENT`
--

DROP TABLE IF EXISTS `CLIENT`;
CREATE TABLE IF NOT EXISTS `CLIENT` (
  `ClientID` int(6) NOT NULL AUTO_INCREMENT,
  `ProjectID` int(6) DEFAULT NULL,
  `ClientName` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Phone1` bigint(10) DEFAULT NULL,
  `Phone2` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`ClientID`),
  KEY `ProjectID` (`ProjectID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `CLIENT`
--

INSERT INTO `CLIENT` (`ClientID`, `ProjectID`, `ClientName`, `Email`, `Phone1`, `Phone2`) VALUES
(1, 1, 'John Smith', 'johnsmith@xyz.net', 5698751289, 6485693321),
(2, 2, 'Anna Flores', 'annaflores@zpayments.biz', 4895632212, 0),
(3, 3, 'Brianna Floyd', 'bfloyd@viennawine.com', 3658975562, 0),
(6, 12, 'David Smith', 'dmsith@gmail.com', 1324567894, 0);

-- --------------------------------------------------------

--
-- Table structure for table `EMPLOYEE`
--

DROP TABLE IF EXISTS `EMPLOYEE`;
CREATE TABLE IF NOT EXISTS `EMPLOYEE` (
  `EmployeeID` int(6) NOT NULL AUTO_INCREMENT,
  `EmployeeName` varchar(30) DEFAULT NULL,
  `Phone1` bigint(10) DEFAULT NULL,
  `Phone2` bigint(10) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `HourlyRate` double DEFAULT NULL,
  PRIMARY KEY (`EmployeeID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `EMPLOYEE`
--

INSERT INTO `EMPLOYEE` (`EmployeeID`, `EmployeeName`, `Phone1`, `Phone2`, `Email`, `HourlyRate`) VALUES
(4, 'Daniel Botello', 7135971511, 2816206780, 'danielbotello2000@yahoo.com', 17.25),
(5, 'Johannes Limano', 3465589090, 0, 'johannes.dominic@gmail.com', 15.25),
(6, 'Violeta', 1234567891, 0, 'violeta@gmail.com', 15),
(7, 'Junren', 4561236897, 2020, 'junren@gmail.com', 16),
(8, 'Yaseen', 3641237452, 0, 'yaseen@gmail.com', 15),
(13, 'John Doe', 1234567894, 0, 'johndoe@gmail.com', 12),
(17, 'First Employee', 1234567893, NULL, 'first_employee@mail.com', 12),
(18, 'Second Employee', 1234567894, NULL, 'second_employee@mail.com', 12),
(19, 'Third Employee', 1234567895, NULL, 'third_employee@mail.com', 12);

--
-- Triggers `EMPLOYEE`
--
DROP TRIGGER IF EXISTS `SALARY_UPDATE`;
DELIMITER $$
CREATE TRIGGER `SALARY_UPDATE` BEFORE UPDATE ON `EMPLOYEE` FOR EACH ROW IF (NEW.HourlyRate <= OLD.HourlyRate) THEN
        SET @message_text = CONCAT('new salary must be greater than current salary');
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;

ELSEIF (Check_Leader_ID(NEW.EmployeeID) = TRUE)
	THEN
		SET NEW.HourlyRate = New.HourlyRate;

ELSEIF (NEW.HourlyRate > (SELECT DISTINCT EMPLOYEE.HourlyRate
    FROM `PROJECT`, `EMPLOYEE` WHERE PROJECT.ProjectLeaderID = EMPLOYEE.EmployeeID)) THEN
        SET @message_text = CONCAT('new salary must be less or equal to project leader salary');
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;
ELSE
	SET NEW.HourlyRate = New.HourlyRate;
    END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `MENU`
--

DROP TABLE IF EXISTS `MENU`;
CREATE TABLE IF NOT EXISTS `MENU` (
  `MenuID` int(6) NOT NULL AUTO_INCREMENT,
  `MenuName` varchar(30) NOT NULL,
  `url` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`MenuID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MENU`
--

INSERT INTO `MENU` (`MenuID`, `MenuName`, `url`) VALUES
(1, 'Manage Projects', 'index1.php'),
(2, 'Manage Employees', 'employees.php'),
(3, 'Manage Clients', 'client.php'),
(4, 'Task Progress Report', 'clientReporting.php'),
(5, 'Budget Report', 'BudgetReport.php'),
(6, 'Manage Employees\' Tasks', 'task.php'),
(7, 'Manage Budget', 'budget.php'),
(8, 'Manage Works On', 'works_on_update.php');

-- --------------------------------------------------------

--
-- Table structure for table `PROJECT`
--

DROP TABLE IF EXISTS `PROJECT`;
CREATE TABLE IF NOT EXISTS `PROJECT` (
  `ProjectID` int(6) NOT NULL AUTO_INCREMENT,
  `ProjectName` varchar(20) DEFAULT NULL,
  `ProjectLeaderID` int(6) NOT NULL,
  `FlagStatus` varchar(1) DEFAULT NULL,
  `Revenue` double DEFAULT NULL,
  `NetGainOrLoss` double DEFAULT NULL,
  `Start_Date` date DEFAULT NULL,
  `End_Date` date DEFAULT NULL,
  PRIMARY KEY (`ProjectID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `PROJECT`
--

INSERT INTO `PROJECT` (`ProjectID`, `ProjectName`, `ProjectLeaderID`, `FlagStatus`, `Revenue`, `NetGainOrLoss`, `Start_Date`, `End_Date`) VALUES
(1, 'XYZ Car Rental', 4, 'A', 32000, 2990.5, '2020-03-21', '2020-07-21'),
(2, 'Z Mobile E-Payments', 4, 'I', 50000, 9095, '2020-05-15', '2020-09-15'),
(3, 'Vienna Wine Store', 4, 'I', 45000, 3254, '2020-07-08', '2020-11-12'),
(12, 'Project Management D', 17, 'A', 55000, NULL, '2020-04-15', '2020-07-10'),
(14, 'test project', 4, 'I', 55000, NULL, '2020-04-15', '2020-06-25');

-- --------------------------------------------------------

--
-- Table structure for table `TASK`
--

DROP TABLE IF EXISTS `TASK`;
CREATE TABLE IF NOT EXISTS `TASK` (
  `TaskID` int(6) NOT NULL AUTO_INCREMENT,
  `Description` varchar(255) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `FinishDate` date DEFAULT NULL,
  `FlagStatus` varchar(1) DEFAULT NULL,
  `FlagActive` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`TaskID`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TASK`
--

INSERT INTO `TASK` (`TaskID`, `Description`, `StartDate`, `DueDate`, `FinishDate`, `FlagStatus`, `FlagActive`) VALUES
(1, 'Setting up the repository', '2020-03-21', '2020-03-21', '2020-03-21', 'C', 'A'),
(2, 'Client meeting for  gathering requirements', '2020-03-23', '2020-03-23', '2020-03-23', 'C', 'A'),
(3, 'Database Design', '2020-03-23', '2020-03-26', '2020-03-26', 'C', 'A'),
(4, 'Database Insertions', '2020-03-26', '2020-03-30', '2020-03-31', 'L', 'A'),
(5, 'Data Request from Client', '2020-03-26', '2020-03-30', '2020-03-31', 'L', 'A'),
(6, 'Front-end from Adobe Xd', '2020-03-31', '2020-04-07', '2020-04-07', 'C', 'D'),
(7, 'Front-end design', '2020-03-31', '2020-04-07', '2020-04-07', 'O', 'A'),
(8, 'Meeting with client for prototype', '2020-04-08', '2020-04-08', NULL, 'U', 'A'),
(9, 'Front-end code', '2020-04-08', '2020-04-17', NULL, 'U', 'A'),
(10, 'Connecting between front-end and back-end', '2020-04-17', '2020-04-28', NULL, 'U', 'A'),
(11, 'Meeting with client for finished prototype', '2020-04-29', '2020-04-29', NULL, 'U', 'A'),
(12, 'Bug fixing and polishing', '2020-04-29', '2020-05-06', NULL, 'U', 'A'),
(13, 'Deployement to Server', '2020-05-06', '2020-05-15', NULL, 'U', 'A'),
(14, 'Repository setup', '2020-05-15', '2020-05-15', NULL, 'U', 'A'),
(15, 'Meeting with client to gather requirements', '2020-05-15', '2020-05-15', NULL, 'U', 'A'),
(16, 'Tools and libraries research for android and iOS app development', '2020-05-18', '2020-06-01', NULL, 'U', 'A'),
(17, 'Database design', '2020-06-02', '2020-06-10', NULL, 'U', 'A'),
(18, 'Database insertions', '2020-06-10', '2020-06-17', NULL, 'U', 'A'),
(19, 'Data request from client and API access request', '2020-06-10', '2020-06-17', NULL, 'U', 'A'),
(20, 'Front-end design', '2020-06-17', '2020-06-24', NULL, 'U', 'A'),
(21, 'Meeting with client for prototype', '2020-06-25', '2020-06-25', NULL, 'U', 'A'),
(22, 'Front-end code', '2020-06-25', '2020-07-09', NULL, 'U', 'A'),
(23, 'Back-end code', '2020-06-25', '2020-07-09', NULL, 'U', 'A'),
(24, 'Connecting front-end with back-end', '2020-07-10', '2020-07-21', NULL, 'U', 'A'),
(25, 'Meeting with client for finished prototype', '2020-07-22', '2020-07-22', NULL, 'U', 'A'),
(26, 'Bug-fixing and polishing', '2020-07-22', '2020-08-05', NULL, 'U', 'A'),
(27, 'Deployment', '2020-08-06', '2020-08-20', NULL, 'U', 'A'),
(28, 'Repository setup', '2020-07-08', '2020-07-08', NULL, 'U', 'A'),
(29, 'Meeting with client to gather requirements', '2020-07-08', '2020-07-08', NULL, 'U', 'A'),
(30, 'Tools and libraries research for android and iOS app development', '2020-07-09', '2020-07-22', NULL, 'U', 'A'),
(31, 'Database design', '2020-07-23', '2020-07-30', NULL, 'U', 'A'),
(32, 'Database insertions', '2020-07-31', '2020-08-11', NULL, 'U', 'A'),
(33, 'Data request from client and API access request', '2020-07-31', '2020-08-11', NULL, 'U', 'A'),
(34, 'Front-end design', '2020-08-12', '2020-08-19', NULL, 'U', 'A'),
(35, 'Meeting with client for prototype', '2020-08-20', '2020-08-20', NULL, 'U', 'A'),
(36, 'Front-end code', '2020-08-20', '2020-09-03', NULL, 'U', 'A'),
(37, 'Back-end code', '2020-08-20', '2020-09-03', NULL, 'U', 'A'),
(38, 'Connecting front-end with back-end', '2020-09-04', '2020-09-11', NULL, 'U', 'A'),
(39, 'Meeting with client for finished prototype', '2020-09-14', '2020-09-14', NULL, 'U', 'A'),
(40, 'Bug-fixing and polishing', '2020-09-15', '2020-09-29', NULL, 'U', 'A'),
(41, 'Deployment', '2020-09-30', '2020-10-14', NULL, 'U', 'A'),
(44, 'test', '2020-04-14', '2020-04-20', NULL, 'O', 'A'),
(45, 'Meeting with Client', '2020-04-15', '2020-04-17', NULL, 'O', 'A'),
(46, 'Development', '2020-04-20', '2020-06-15', NULL, 'U', 'A'),
(47, 'Testing', '2020-06-16', '2020-07-20', NULL, 'U', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `USER_LOGIN`
--

DROP TABLE IF EXISTS `USER_LOGIN`;
CREATE TABLE IF NOT EXISTS `USER_LOGIN` (
  `Username` varchar(15) NOT NULL,
  `ClientID` int(6) DEFAULT NULL,
  `EmployeeID` int(6) DEFAULT NULL,
  `PasswordHash` binary(20) NOT NULL,
  `Salt` binary(20) NOT NULL,
  PRIMARY KEY (`Username`),
  KEY `ClientID` (`ClientID`),
  KEY `EmployeeID` (`EmployeeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `USER_LOGIN`
--

INSERT INTO `USER_LOGIN` (`Username`, `ClientID`, `EmployeeID`, `PasswordHash`, `Salt`) VALUES
('jlimano', NULL, 5, 0x1f41d4eb662a7ac416982375a180de385d5d14a7, 0xa72f4e4084173c6ebd91dbf4570ef55827ad1471),
('dbotello', NULL, 4, 0x11a950fb8709df9cfda156354067238a3b46bfd6, 0x634456351485af2f5189e75270e0e0f7f601d80f),
('violeta', NULL, 6, 0x4400a2dfd42a90ff5a572f033f13b74b8ebe00ca, 0x9a754862e7f6fffcd4011963860cb033977fd081),
('yaseen', NULL, 8, 0xdadea407d43465eaecd4a88bd87889224a687e2f, 0xb5283c106509dd3940bfd22ba9f05e5537ee5356),
('junren', NULL, 7, 0x83d5fcd9ac8232266f6541c6680bbb30dbbace3a, 0xf53d57369ae1fcff96e07012c55df71c7d797010),
('jsmith', 1, NULL, 0x6b63a8ae63805aa0a435e45988f22ea5283309ae, 0x080f518fc6daf21e50aed23bc0be4cf1d47fe4cf),
('aflores', 2, NULL, 0x26917c755276e0c6c9fcdf96bb97d3f25b18d723, 0x44c0808a6764c275dfed9edbf63e45fee2175f8e),
('bfloyd', 3, NULL, 0xa60ef5a8ba17136b449ff254de6b916a845d437e, 0x0be2594e9efbc94ea255f3418dd5137d79cea0f3),
('jdoe', NULL, 13, 0x12e6b118e712c0a19e72a3842523e36dfd2cbd6c, 0x637c48bfb17e9f23f3335f38791a762d74440a0f),
('dsmith', 6, NULL, 0x320892550d57b23ff35bdbfd3167b5367ac418e4, 0x1ca292771d1e910257e95aeb3b5da08396dc5ac5);

-- --------------------------------------------------------

--
-- Table structure for table `WORKS_ON`
--

DROP TABLE IF EXISTS `WORKS_ON`;
CREATE TABLE IF NOT EXISTS `WORKS_ON` (
  `WorksID` int(6) NOT NULL AUTO_INCREMENT,
  `ProjectID` int(6) NOT NULL,
  `EmployeeID` int(6) NOT NULL,
  `TaskID` int(6) NOT NULL,
  `WorkingHours` double DEFAULT NULL,
  PRIMARY KEY (`WorksID`),
  KEY `ProjectID` (`ProjectID`),
  KEY `EmployeeID` (`EmployeeID`),
  KEY `TaskID` (`TaskID`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `WORKS_ON`
--

INSERT INTO `WORKS_ON` (`WorksID`, `ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES
(1, 1, 4, 1, 2),
(2, 1, 5, 2, 3),
(3, 1, 6, 2, 4),
(4, 1, 4, 3, 24),
(5, 1, 5, 3, 24),
(6, 1, 6, 3, 24),
(7, 1, 7, 3, 24),
(8, 1, 8, 3, 24),
(9, 1, 4, 4, 30),
(10, 1, 5, 4, 30),
(11, 1, 6, 4, 30),
(12, 1, 7, 4, 30),
(13, 1, 8, 4, 30),
(14, 1, 4, 5, 30),
(15, 1, 5, 5, 30),
(16, 1, 6, 5, 30),
(17, 1, 7, 5, 30),
(18, 1, 8, 5, 30),
(19, 1, 4, 7, 48),
(20, 1, 5, 7, 48),
(21, 1, 6, 7, 48),
(22, 1, 7, 7, 48),
(23, 1, 8, 7, 48),
(24, 1, 7, 8, 3),
(25, 1, 8, 8, 3),
(26, 1, 4, 9, 61),
(27, 1, 5, 9, 61),
(28, 1, 6, 9, 61),
(29, 1, 7, 9, 61),
(30, 1, 8, 9, 61),
(31, 1, 4, 10, 64),
(32, 1, 5, 10, 64),
(33, 1, 6, 10, 64),
(34, 1, 7, 10, 64),
(35, 1, 8, 10, 64),
(36, 1, 7, 11, 3),
(37, 1, 8, 11, 3),
(38, 1, 4, 12, 48),
(39, 1, 5, 12, 48),
(40, 1, 6, 12, 48),
(41, 1, 7, 12, 48),
(42, 1, 8, 12, 48),
(43, 1, 4, 13, 64),
(44, 1, 5, 13, 64),
(45, 1, 6, 13, 64),
(46, 1, 7, 13, 64),
(47, 1, 8, 13, 64),
(48, 2, 5, 14, 1),
(49, 2, 4, 15, 3),
(50, 2, 6, 15, 3),
(51, 2, 4, 16, 89),
(52, 2, 5, 16, 88),
(53, 2, 6, 16, 88),
(54, 2, 7, 16, 88),
(55, 2, 8, 16, 88),
(56, 2, 4, 17, 48),
(57, 2, 5, 17, 48),
(58, 2, 6, 17, 48),
(59, 2, 7, 17, 48),
(60, 2, 8, 17, 48),
(61, 2, 4, 18, 48),
(62, 2, 5, 18, 48),
(63, 2, 6, 18, 48),
(64, 2, 7, 19, 48),
(65, 2, 8, 19, 48),
(66, 2, 4, 20, 48),
(67, 2, 5, 20, 48),
(68, 2, 6, 20, 48),
(69, 2, 7, 20, 48),
(70, 2, 8, 20, 48),
(71, 2, 5, 21, 3),
(72, 2, 6, 21, 3),
(73, 2, 4, 22, 72),
(74, 2, 5, 22, 69),
(75, 2, 6, 23, 69),
(76, 2, 7, 23, 72),
(77, 2, 8, 23, 72),
(78, 2, 4, 24, 64),
(79, 2, 5, 24, 64),
(80, 2, 6, 24, 64),
(81, 2, 7, 24, 64),
(82, 2, 8, 24, 64),
(83, 2, 7, 25, 3),
(84, 2, 8, 25, 3),
(85, 2, 4, 26, 88),
(86, 2, 5, 26, 88),
(87, 2, 6, 26, 88),
(88, 2, 7, 26, 85),
(89, 2, 8, 26, 85),
(90, 2, 4, 27, 88),
(91, 2, 5, 27, 88),
(92, 2, 6, 27, 88),
(93, 2, 7, 27, 88),
(94, 2, 8, 27, 88),
(95, 3, 5, 28, 1),
(96, 3, 4, 29, 3),
(97, 3, 6, 29, 3),
(98, 3, 4, 30, 80),
(99, 3, 5, 30, 80),
(100, 3, 6, 30, 80),
(101, 3, 7, 30, 80),
(102, 3, 8, 30, 80),
(103, 3, 4, 31, 48),
(104, 3, 5, 31, 48),
(105, 3, 6, 31, 48),
(106, 3, 7, 31, 48),
(107, 3, 8, 31, 48),
(108, 3, 4, 32, 64),
(109, 3, 5, 32, 64),
(110, 3, 6, 32, 64),
(111, 3, 7, 33, 64),
(112, 3, 8, 33, 64),
(113, 3, 4, 34, 48),
(114, 3, 5, 34, 48),
(115, 3, 6, 34, 48),
(116, 3, 7, 34, 48),
(117, 3, 8, 34, 48),
(118, 3, 5, 35, 3),
(119, 3, 6, 35, 3),
(120, 3, 4, 36, 88),
(121, 3, 5, 36, 85),
(122, 3, 6, 37, 85),
(123, 3, 7, 37, 88),
(124, 3, 8, 37, 88),
(125, 3, 4, 38, 48),
(126, 3, 5, 38, 48),
(127, 3, 6, 38, 48),
(128, 3, 7, 38, 48),
(129, 3, 8, 38, 48),
(130, 3, 7, 39, 3),
(131, 3, 8, 39, 3),
(132, 3, 4, 40, 88),
(133, 3, 5, 40, 88),
(134, 3, 6, 40, 88),
(135, 3, 7, 40, 88),
(136, 3, 8, 40, 88),
(137, 3, 4, 41, 88),
(138, 3, 5, 41, 88),
(139, 3, 6, 41, 88),
(140, 3, 7, 41, 88),
(141, 3, 8, 41, 88),
(151, 1, 5, 8, 1),
(150, 1, 8, 8, 5),
(149, 3, 6, 3, 5),
(148, 1, 5, 5, 1),
(147, 3, 5, 41, 5),
(152, 1, 5, 8, 1),
(153, 1, 5, 8, 1),
(154, 1, 5, 8, 1),
(155, 1, 5, 8, 2),
(165, 1, 6, 7, 5),
(166, 1, 6, 9, 5);

--
-- Triggers `WORKS_ON`
--
DROP TRIGGER IF EXISTS `Delete_WO_Trigger`;
DELIMITER $$
CREATE TRIGGER `Delete_WO_Trigger` BEFORE DELETE ON `WORKS_ON` FOR EACH ROW DELETE FROM `BUDGET` WHERE OLD.WorksID = BUDGET.WorksID
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Insert_WO_Trigger`;
DELIMITER $$
CREATE TRIGGER `Insert_WO_Trigger` BEFORE INSERT ON `WORKS_ON` FOR EACH ROW INSERT INTO BUDGET (ProjectID, ItemName, AllocationCost, EmpID, WorksID)
VALUES (NEW.ProjectID, 'SALARY INFO',
        NEW.WorkingHours * (SELECT HourlyRate
                        FROM EMPLOYEE
                        WHERE EMPLOYEE.EmployeeID = NEW.EmployeeID),
        NEW.EmployeeID, (SELECT AUTO_INCREMENT 
                         FROM information_schema.TABLES 
                         WHERE TABLE_SCHEMA = "projectmanagementapp" 
                         AND TABLE_NAME = "WORKS_ON")
       )
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Update_WO_Trigger`;
DELIMITER $$
CREATE TRIGGER `Update_WO_Trigger` AFTER UPDATE ON `WORKS_ON` FOR EACH ROW UPDATE BUDGET
SET BUDGET.AllocationCost = (
    SELECT NEW.WorkingHours * EMPLOYEE.HourlyRate
    FROM EMPLOYEE
    WHERE EMPLOYEE.EmployeeID = NEW.EmployeeID 
)
WHERE BUDGET.WorksID = NEW.WorksID
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
