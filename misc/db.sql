-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2024 at 05:35 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
  `email` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `OTP` varchar(5) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountID`, `username`, `email`, `pwd`, `OTP`, `status`) VALUES
('A0001', 'Cheah Shaoren', 'shaorencheah@gmail.com', '$2y$10$DMX3k8/SbTzfW8.PHBawrOLmt71sm0VeO7WHTX9LfDILL4y525sna', 'Z2L7Q', 'Verified'),
('A0002', 'Jacob Tan', 'jacobtan@gmail.com', '$2y$10$tdPnBmX8Asz50X17Hw5bpun21UwLMge5Oi/.pv6LPpQMGxhCUlhR.', 'LI5BB', 'Verified'),
('A0003', 'Jane Lee', 'janelee@gmail.com', '$2y$10$r/EL/nE/EHWOKbBToCmBZ.RslOLf1.UhzvEAurCi2YYPqDvN1xUYS', '72KPB', 'Verified'),
('A0004', 'Kenneth Young', 'kennethyoung@gmail.com', '$2y$10$PiVER9VwJQgXQ8T7V8ii/.Kpid6RGiwV/RJgJb46yjVmBsz1XTj7S', 'UCN4I', 'Verified');

-- --------------------------------------------------------

--
-- Table structure for table `assigned`
--

CREATE TABLE `assigned` (
  `taskID` varchar(255) NOT NULL,
  `assignedMember` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assigned`
--

INSERT INTO `assigned` (`taskID`, `assignedMember`) VALUES
('T0001', 'A0002'),
('T0001', 'A0003'),
('T0002', 'A0001'),
('T0003', 'A0003'),
('T0004', 'A0004'),
('T0005', 'A0001'),
('T0005', 'A0002'),
('T0006', 'A0003'),
('T0006', 'A0004');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `workspaceID` varchar(255) NOT NULL,
  `accountID` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`workspaceID`, `accountID`, `role`) VALUES
('W0001', 'A0001', 'Owner'),
('W0002', 'A0001', 'Owner'),
('W0002', 'A0002', 'Member'),
('W0002', 'A0003', 'Member'),
('W0002', 'A0004', 'Member'),
('W0003', 'A0002', 'Owner'),
('W0004', 'A0003', 'Owner'),
('W0005', 'A0004', 'Owner');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`taskID`, `workspaceID`, `creator`, `taskName`, `taskDesc`, `type`, `priority`, `creationDate`, `due`) VALUES
('T0001', 'W0002', 'A0001', 'Create Test Cases', 'Develop test cases for all modules.', 'To-Do', 'Low Priority', '2024-07-01 05:31:44', '2024-07-18 11:28:00'),
('T0002', 'W0002', 'A0001', 'Identify the Functional and Non-Functional Requirements', 'Research and define the requirements before client meeting.', 'Completed', 'High Priority', '2024-07-01 05:32:28', '2024-06-29 11:31:00'),
('T0003', 'W0002', 'A0001', 'Design Wireframe', 'Develop Low-fidelity and High-fidelity prototype.', 'Completed', 'Medium Priority', '2024-07-01 05:33:17', '2024-06-29 11:32:00'),
('T0004', 'W0002', 'A0001', 'Conduct QA Testing', 'Carry out test cases and compile results.', 'To-Do', 'Medium Priority', '2024-07-01 05:33:48', '2024-07-17 11:33:00'),
('T0005', 'W0002', 'A0001', 'Complete Back-end', 'Complete the back-end of relevant modules.', 'In Progress', 'High Priority', '2024-07-01 05:34:18', '2024-07-06 11:34:00'),
('T0006', 'W0002', 'A0001', 'Complete Front-end', 'Develop the front-end for relevant modules.', 'In Progress', 'High Priority', '2024-07-01 05:34:43', '2024-07-06 11:34:00');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `workspace`
--

INSERT INTO `workspace` (`workspaceID`, `workspaceName`, `workspaceDesc`, `type`, `creationDate`, `owner`, `workspaceCode`) VALUES
('W0001', 'Your Personal Workspace', 'This is your personal workspace, start adding tasks now!', 'Personal', '2024-07-01 05:17:38', 'A0001', 'FL9JZ'),
('W0002', 'SunCollab Development', 'Workspace to keep track of the SDLC processes of SunCollab development.', 'Collaboration', '2024-07-01 05:22:06', 'A0001', 'WKR3J'),
('W0003', 'Your Personal Workspace', 'This is your personal workspace, start adding tasks now!', 'Personal', '2024-07-01 05:25:11', 'A0002', 'J2CNJ'),
('W0004', 'Your Personal Workspace', 'This is your personal workspace, start adding tasks now!', 'Personal', '2024-07-01 05:26:07', 'A0003', 'S7A33'),
('W0005', 'Your Personal Workspace', 'This is your personal workspace, start adding tasks now!', 'Personal', '2024-07-01 05:27:36', 'A0004', 'YYPJG');

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
