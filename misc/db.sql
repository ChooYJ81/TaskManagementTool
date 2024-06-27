-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2024 at 07:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sptmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountID` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `phoneNo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `OTP` varchar(5) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountID`, `username`, `phoneNo`, `email`, `pwd`, `OTP`, `status`) VALUES
('A0001', 'John Smith', NULL, 'test@mail.com', '$2y$10$DxC8bnloaERsfPG9aqThfu6.p6pRrxJsyFShXmw51nFIdkUyYpwIG', '123AB', 'Verified'),
('A0002', 'Jacob', '012345678', 'jacob@mail.com', '12345', NULL, ''),
('A0003', 'Jie', NULL, 'chooyanjie@gmail.com', '$2y$10$rqUkNSRKQPYbze4vn0AB6um2OtYcLjmJZOHIfemcvU2sqqgYrvgSu', 'HXE5C', 'Verified'),
('A0004', 'test3', NULL, 'test3@mail.com', '$2y$10$xxSeo85.1dzlq1bwu8eukumzCkcuKWObJJFAEyyhjwrFnVsi4DYQ.', 'IVNGV', 'Verified');

-- --------------------------------------------------------

--
-- Table structure for table `assigned`
--

CREATE TABLE `assigned` (
  `taskID` varchar(255) NOT NULL,
  `assignedMember` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigned`
--

INSERT INTO `assigned` (`taskID`, `assignedMember`) VALUES
('T0001', 'A0001'),
('T0003', 'A0001'),
('T0004', 'A0001'),
('T0005', 'A0001'),
('T0006', 'A0001'),
('T0007', 'A0001'),
('T0008', 'A0001');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `workspaceID` varchar(255) NOT NULL,
  `accountID` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`workspaceID`, `accountID`, `role`) VALUES
('W0001', 'A0001', 'Owner'),
('W0001', 'A0002', 'Member'),
('W0002', 'A0001', 'Owner'),
('W0003', 'A0001', 'Owner'),
('W0003', 'A0002', 'Member'),
('W0004', 'A0001', 'Owner'),
('W0005', 'A0001', 'Owner'),
('W0006', 'A0003', 'Owner'),
('W0007', 'A0004', 'Owner');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `taskID` varchar(255) NOT NULL,
  `workspaceID` varchar(255) NOT NULL,
  `creator` varchar(255) NOT NULL,
  `taskName` varchar(255) DEFAULT NULL,
  `taskDesc` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `due` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`taskID`, `workspaceID`, `creator`, `taskName`, `taskDesc`, `type`, `priority`, `creationDate`, `due`) VALUES
('T0001', 'W0001', 'A0001', 'Complete Front-end', 'Please complete the design for the upcoming modules.', 'Completed', 'Low Priority', '2024-06-20 18:27:36', '2024-06-10 00:27:00'),
('T0002', 'W0001', 'A0001', 'Design Database Architecture', 'Please finish up and finalize the database ERD to be shown to client on the upcoming meeting.', 'To-Do', 'Medium Priority', '2024-06-20 18:28:07', '2024-06-12 00:28:00'),
('T0003', 'W0001', 'A0001', '12', '12', 'To-Do', 'Medium Priority', '2024-06-23 16:20:16', '2024-06-23 22:20:00'),
('T0004', 'W0001', 'A0001', '12', '12', 'In Progress', 'Low Priority', '2024-06-23 16:20:33', '2024-06-24 22:20:00'),
('T0005', 'W0001', 'A0001', '21', '12', 'In Progress', 'Medium Priority', '2024-06-23 16:20:43', '2024-06-23 22:20:00'),
('T0006', 'W0001', 'A0001', '12', '12', 'In Progress', 'Low Priority', '2024-06-23 16:20:53', '2024-06-23 22:20:00'),
('T0007', 'W0001', 'A0001', '12', '12', 'To-Do', 'Medium Priority', '2024-06-23 16:21:05', '2024-06-25 22:21:00'),
('T0008', 'W0001', 'A0001', '12', '12', 'Completed', 'Medium Priority', '2024-06-23 16:21:16', '2024-06-25 22:21:00'),
('T0009', 'W0003', 'A0001', 'test task', '123', 'To-Do', 'Medium Priority', '2024-06-26 19:09:04', '2024-06-28 01:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `workspace`
--

CREATE TABLE `workspace` (
  `workspaceID` varchar(255) NOT NULL,
  `workspaceName` varchar(255) DEFAULT NULL,
  `workspaceDesc` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `workspaceCode` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workspace`
--

INSERT INTO `workspace` (`workspaceID`, `workspaceName`, `workspaceDesc`, `type`, `creationDate`, `owner`, `workspaceCode`) VALUES
('W0001', 'Testing Workspace', 'this is a testing workspace', 'Personal', '2024-06-20 11:50:23', 'A0001', '079U8'),
('W0002', 'Testing Workspace B', 'Hello there~', 'Collaboration', '2024-06-20 16:20:01', 'A0001', 'RX7KN'),
('W0003', 'Testing Workspace C', 'Hellooo this is for testing purposes', 'Personal', '2024-06-20 16:43:06', 'A0001', NULL),
('W0004', 'Testing Workspace D', 'This is another testing workspace.', 'Personal', '2024-06-20 18:17:22', 'A0001', 'F46NS'),
('W0005', 'test2', '123', 'Personal', '2024-06-25 10:48:24', 'A0001', 'ADT29'),
('W0006', 'Your Personal Workspace', 'This is your personal workspace, start adding tasks now!', 'Personal', '2024-06-26 14:22:35', 'A0003', 'Z6QP9'),
('W0007', 'Your Personal Workspace', 'This is your personal workspace, start adding tasks now!', 'Personal', '2024-06-26 19:41:44', 'A0004', 'R2LXS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `assigned`
--
ALTER TABLE `assigned`
  ADD PRIMARY KEY (`taskID`,`assignedMember`),
  ADD KEY `assignedMember` (`assignedMember`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`workspaceID`,`accountID`),
  ADD KEY `accountID` (`accountID`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`taskID`),
  ADD KEY `workspaceID` (`workspaceID`),
  ADD KEY `creator` (`creator`);

--
-- Indexes for table `workspace`
--
ALTER TABLE `workspace`
  ADD PRIMARY KEY (`workspaceID`),
  ADD KEY `owner` (`owner`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assigned`
--
ALTER TABLE `assigned`
  ADD CONSTRAINT `assigned_ibfk_1` FOREIGN KEY (`taskID`) REFERENCES `task` (`taskID`),
  ADD CONSTRAINT `assigned_ibfk_2` FOREIGN KEY (`assignedMember`) REFERENCES `account` (`accountID`);

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`workspaceID`) REFERENCES `workspace` (`workspaceID`),
  ADD CONSTRAINT `member_ibfk_2` FOREIGN KEY (`accountID`) REFERENCES `account` (`accountID`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`workspaceID`) REFERENCES `workspace` (`workspaceID`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`creator`) REFERENCES `account` (`accountID`);

--
-- Constraints for table `workspace`
--
ALTER TABLE `workspace`
  ADD CONSTRAINT `workspace_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `account` (`accountID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
