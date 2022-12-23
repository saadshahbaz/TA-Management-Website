-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 14, 2022 at 11:57 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xampp_starter`
--

-- --------------------------------------------------------

--
-- Table structure for table `Course`
--

CREATE TABLE `Course` (
  `courseName` varchar(256) NOT NULL,
  `courseDesc` text NOT NULL,
  `term` varchar(8) NOT NULL,
  `year` varchar(4) NOT NULL,
  `courseNumber` varchar(8) NOT NULL,
  `courseInstructor` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Course`
--

INSERT INTO `Course` (`courseName`, `courseDesc`, `term`, `year`, `courseNumber`, `courseInstructor`) VALUES
('Principles of Web Development', 'The course discusses the major principles, algorithms, languages and technologies that underlie web development. Students receive practical hands-on experience through a project.', 'Fall', '2022', 'COMP 250', 'joseph@comp307.com'),
('Honours Project in Computer Science and Biology', 'One-semester research project applying computational approaches to a biological problem. The project is (co)-supervised by a professor in Computer Science and/or Biology or related fields.', 'Winter', '2023', 'COMP 402', 'mathieu@comp307.com');

-- --------------------------------------------------------

--
-- Table structure for table `Professor`
--

CREATE TABLE `Professor` (
  `professor` varchar(40) NOT NULL,
  `faculty` varchar(30) NOT NULL,
  `department` varchar(30) NOT NULL,
  `course` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Professor`
--

INSERT INTO `Professor` (`professor`, `faculty`, `department`, `course`) VALUES
('joseph@comp307.com', 'Science', 'Computer Science', 'COMP 250'),
('mathieu@comp307.com', 'Science', 'Computer Science', 'COMP 402');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`firstName`, `lastName`, `email`, `password`, `createdAt`, `updatedAt`) VALUES
('Avinash', 'Bhat', 'avi@comp307.com', '$2y$10$iqQA5ffMBUaBn0weeSM8.eKbEwhyGPOqV.DxKL.Ox2A1cq.0QfpuW', '2022-10-11 04:42:50', '2022-10-11 04:42:50'),
('Jane', 'Doe', 'jane@comp307.com', '$2y$10$Jq/Ab6L6yPpGbPmyt5tC1e5uO81fP4YBLAow4LHPRgVtLjU8rcK7C', '2022-10-13 18:09:22', '2022-10-13 18:09:22'),
('John', 'Doe', 'john@comp307.com', '$2y$10$jAGY.QSoQwIoTH13LWUaKu3LdCoYOG2zey0pz4qJNtTdaF3G4Elqy', '2022-10-09 16:46:43', '2022-10-09 16:46:43'),
('Joseph', 'Vybihal', 'joseph@comp307.com', '$2y$10$MwaR9.9RqkKnjGsj6ELtAugh4EwRjh84esjwp6tf52XOTZpy6xxGu', '2022-10-13 14:36:07', '2022-10-13 14:36:07'),
('Mathieu', 'Blanchette', 'mathieu@comp307.com', '$2y$10$5HxIGFEmYO6OyG7IOgjlmuCRofwLTG2Ah9DtiEdGetHD.rZZN0Xbq', '2022-10-13 18:09:22', '2022-10-13 18:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `UserType`
--

CREATE TABLE `UserType` (
  `idx` int(11) NOT NULL,
  `userType` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `UserType`
--

INSERT INTO `UserType` (`idx`, `userType`) VALUES
(1, 'student'),
(2, 'professor'),
(3, 'ta'),
(4, 'admin'),
(5, 'sysop');

-- --------------------------------------------------------

--
-- Table structure for table `User_UserType`
--

CREATE TABLE `User_UserType` (
  `userId` varchar(40) NOT NULL,
  `userTypeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `User_UserType`
--

INSERT INTO `User_UserType` (`userId`, `userTypeId`) VALUES
('john@comp307.com', 5),
('avi@comp307.com', 5),
('joseph@comp307.com', 2),
('jane@comp307.com', 3),
('jane@comp307.com', 1),
('mathieu@comp307.com', 2),
('mathieu@comp307.com', 5),
('mathieu@comp307.com', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Course`
--
ALTER TABLE `Course`
  ADD PRIMARY KEY (`courseNumber`),
  ADD KEY `CourseInstructor_ForeignKey` (`courseInstructor`);

--
-- Indexes for table `Professor`
--
ALTER TABLE `Professor`
  ADD PRIMARY KEY (`professor`),
  ADD KEY `CourseNumber_ForeignKey` (`course`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`email`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `UserType`
--
ALTER TABLE `UserType`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `idx` (`idx`);

--
-- Indexes for table `User_UserType`
--
ALTER TABLE `User_UserType`
  ADD KEY `User_ForeignKey` (`userId`),
  ADD KEY `UserType_ForeignKey` (`userTypeId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Course`
--
ALTER TABLE `Course`
  ADD CONSTRAINT `CourseInstructor_ForeignKey` FOREIGN KEY (`courseInstructor`) REFERENCES `User` (`email`) ON UPDATE CASCADE;

--
-- Constraints for table `Professor`
--
ALTER TABLE `Professor`
  ADD CONSTRAINT `CourseNumber_ForeignKey` FOREIGN KEY (`course`) REFERENCES `Course` (`courseNumber`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ProfName_ForeignKey` FOREIGN KEY (`professor`) REFERENCES `User` (`email`) ON UPDATE CASCADE;

--
-- Constraints for table `User_UserType`
--
ALTER TABLE `User_UserType`
  ADD CONSTRAINT `UserType_ForeignKey` FOREIGN KEY (`userTypeId`) REFERENCES `UserType` (`idx`) ON UPDATE CASCADE,
  ADD CONSTRAINT `User_ForeignKey` FOREIGN KEY (`userId`) REFERENCES `User` (`email`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



CREATE TABLE `TA` (
  `email` varchar(40) NOT NULL,
  `faculty` varchar(30) NOT NULL,
  `department` varchar(30) NOT NULL,
  `course` varchar(30) NOT NULL,
  `term` varchar(30) NOT NULL,
  `years` varchar(4) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `TA`
   ADD PRIMARY KEY(
     `email`,
     `course`,
     `term`,
     `years`
   );

   ALTER TABLE `TA`
        ADD KEY `CourseNumber_ForeignKey` (`course`),
        ADD CONSTRAINT `TAemail_ForeignKey` FOREIGN KEY (`email`) REFERENCES `User` (`email`) ON UPDATE CASCADE;
        ADD CONSTRAINT `CourseNumber_ForeignKey` FOREIGN KEY (`course`) REFERENCES `Course` (`courseNumber`) ON UPDATE CASCADE,


CREATE TABLE `TA_Ratings` (
  `student_email` varchar(40) NOT NULL,
  `ta_email` varchar(30) NOT NULL,
  `rating` int(1) NOT NULL,
  `Notes` varchar(500) NOT NULL,
  `course` varchar(40) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `TA_Ratings`
   ADD PRIMARY KEY(
     `student_email`,
     `ta_email`,
     `course`
   );

CREATE TABLE `TA_COHORT` (
  `term_year` varchar(30) NOT NULL,
  `ta_name` varchar(100) NOT NULL,
  `student_id` varchar(40) NOT NULL,
  `legal_name` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL,
  `grad_ugrad` varchar(20) NOT NULL,
  `supervisor_name` varchar(100) NOT NULL,
  `priority` varchar(3) NOT NULL,
  `hours_allocated` varchar (4) NOT NULL,
  `date_applied` varchar(40) NOT NULL,
  `location_assigned` varchar(40) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `course_applied` varchar(100) NOT NULL,
  `open_to_other_courses` varchar(3) NOT NULL,
  `Notes` varchar(500) NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `TA_COHORT`
   ADD PRIMARY KEY(
     `email`,
     `student_id`,
     `term_year`
   );

CREATE TABLE `Course_Quota` (
  `term_year` varchar(30) NOT NULL,
  `course_num` varchar(30) NOT NULL,
  `course_type` varchar(30) NOT NULL,
  `course_name` varchar(30) NOT NULL,
  `instructor_name` varchar(30) NOT NULL,
  `course_enrollement_num` varchar(5) NOT NULL,
  `ta_quota` varchar(5) NOT NULL,
)

ALTER TABLE `Course_Quota`
   ADD PRIMARY KEY(
     `term_year`,
     `course_num`,
     `course_type`, 
     `course_name`
   );


