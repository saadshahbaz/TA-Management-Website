BEGIN TRANSACTION;
PRAGMA foreign_keys=1;
CREATE TABLE `User` (
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `studentId` varchar(10)  NULL,
  `username` varchar(40)  NULL,
  PRIMARY KEY (`email`)
);
INSERT INTO User VALUES('Avinash','Bhat','avi@comp307.com','$2y$10$iqQA5ffMBUaBn0weeSM8.eKbEwhyGPOqV.DxKL.Ox2A1cq.0QfpuW','260845298','avinash.bhatt');
INSERT INTO User VALUES('Jane','Doe','jane@comp307.com','$2y$10$Jq/Ab6L6yPpGbPmyt5tC1e5uO81fP4YBLAow4LHPRgVtLjU8rcK7C','260845299','jane.doe');
INSERT INTO User VALUES('John','Doe','john@comp307.com','$2y$10$jAGY.QSoQwIoTH13LWUaKu3LdCoYOG2zey0pz4qJNtTdaF3G4Elqy','260845288','john.doe');
INSERT INTO User VALUES('Joseph','Vybihal','joseph@comp307.com','$2y$10$MwaR9.9RqkKnjGsj6ELtAugh4EwRjh84esjwp6tf52XOTZpy6xxGu','260845289','joseph.vybihal');

CREATE TABLE `Course` (
  `courseName` varchar(256) NOT NULL,
  `courseDesc` text NOT NULL,
  `term` varchar(8) NOT NULL,
  `year` varchar(4) NOT NULL,
  `courseNumber` varchar(8) NOT NULL ,
  `courseInstructor` varchar(40) NOT NULL,
  PRIMARY KEY (`courseNumber`, `term`, `year`),
  CONSTRAINT CourseInstructor_ForeignKey
   FOREIGN KEY (`courseInstructor`) REFERENCES `User` (`email`) ON UPDATE CASCADE
);
INSERT INTO Course VALUES('Principles of Web Development','The course discusses the major principles, algorithms, languages and technologies that underlie web development. Students receive practical hands-on experience through a project.','Fall','2022','COMP 250','joseph@comp307.com');
INSERT INTO Course VALUES('Honours Project in Computer Science and Biology','One-semester research project applying computational approaches to a biological problem. The project is (co)-supervised by a professor in Computer Science and/or Biology or related fields.','Winter','2023','COMP 402','jane@comp307.com');
CREATE TABLE `Professor` (
  `professor` varchar(40) NOT NULL,
  `faculty` varchar(30) NOT NULL,
  `department` varchar(30) NOT NULL,
  `course` varchar(10) NOT NULL,
  PRIMARY KEY (`professor`, `course`),
  CONSTRAINT CourseNumber_ForeignKey
    FOREIGN KEY (`course`) REFERENCES `Course` (`courseNumber`) ON UPDATE CASCADE,
  CONSTRAINT ProfName_ForeignKey
   FOREIGN KEY (`professor`) REFERENCES `User` (`email`) ON UPDATE CASCADE
);
INSERT INTO Professor VALUES('joseph@comp307.com','Science','Computer Science','COMP 250');
INSERT INTO Professor VALUES('jane@comp307.com','Science','Computer Science','COMP 402');

CREATE TABLE `UserType` (
  `idx` int(11) NOT NULL,
  `userType` varchar(9) NOT NULL,
  PRIMARY KEY (`idx`)
);
INSERT INTO UserType VALUES(1,'student');
INSERT INTO UserType VALUES(2,'professor');
INSERT INTO UserType VALUES(3,'ta');
INSERT INTO UserType VALUES(4,'admin');
INSERT INTO UserType VALUES(5,'sysop');

CREATE TABLE `User_UserType` (
  `userId` varchar(40) NOT NULL,
  `userTypeId` int(11) NOT NULL,
  PRIMARY KEY(
     `userId`,
     `userTypeId`
  ),
  CONSTRAINT User_ForeignKey
   FOREIGN KEY (`userId`) REFERENCES `User` (`email`) ON UPDATE CASCADE,
  CONSTRAINT UserType_ForeignKey
  FOREIGN KEY (`userTypeId`) REFERENCES `UserType` (`idx`) ON UPDATE CASCADE
);




CREATE TABLE `Student_Course` (
  `studentId` varchar(40) NOT NULL,
  `courseId` varchar(10) NOT NULL,
  CONSTRAINT Student_ForeignKey
    FOREIGN KEY (`studentId`) REFERENCES `User` (`email`) ON UPDATE CASCADE,
  CONSTRAINT Course_ForeignKey
    FOREIGN KEY (`courseId`) REFERENCES `Course` (`courseNumber`) ON UPDATE CASCADE
);


CREATE TABLE `Prof_Info` (
  `email` varchar(40) NOT NULL,
  `faculty` varchar(40) NOT NULL,
  `department` varchar(40) NOT NULL,
  PRIMARY KEY ("email","faculty", "department")
);

CREATE TABLE `USER_ACCESS` (
  `email` varchar(40) NOT NULL,
  `userTypeId` varchar(5) NOT NULL,
  PRIMARY KEY ("email","userTypeId")
);

CREATE TABLE `OfficeHours` (
  `email` varchar(40) NOT NULL,
  `course` varchar(40) NOT NULL,
  `term` varchar(30) NOT NULL,
  `year` varchar(4) NOT NULL,
  `day` varchar(10) NOT NULL,
  `start_time` varchar(100) NOT NULL,
  `end_time` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `responsibilities` varchar(500) NOT NULL,
  `position` varchar(100) NOT NULL,
  PRIMARY KEY (`email`,`course`,`term`,`year`,`day`,`start_time`,`end_time`),
  CONSTRAINT OfficeHours_ForeignKey
    FOREIGN KEY (`email`) REFERENCES `User` (`email`) ON UPDATE CASCADE,
  CONSTRAINT OfficeHours_Course_ForeignKey
    FOREIGN KEY (`course`) REFERENCES `Course` (`courseNumber`) ON UPDATE CASCADE
);

CREATE TABLE `TA` (
  `email` varchar(40)  NOT NULL,
  `student_id` varchar(30) NOT NULL,
  `assigned_hours` varchar(4) NOT NULL,
  `ta_name` varchar(100) NOT NULL,
  `course` varchar(30) NOT NULL,
  `term` varchar(30) NOT NULL,
  `years` varchar(4)NOT NULL,
  PRIMARY KEY ("email","course", "term", "years"),
  CONSTRAINT TA_ForeignKey
   FOREIGN KEY (`email`) REFERENCES `User` (`email`) ON DELETE RESTRICT,
   FOREIGN KEY (`course`) REFERENCES `Course` (`courseNumber`)
);

CREATE TABLE `TA_Ratings` (
  `student_email` varchar(40) NOT NULL,
  `ta_email` varchar(30)  NOT NULL,
  `rating` int(1) NOT NULL,
  `Notes` varchar(500) NOT NULL,
  `course` varchar(40) NOT NULL,
  `term` varchar(30) NOT NULL,
  `years` varchar(4) NOT NULL,
  PRIMARY KEY ("student_email","ta_email", "course", "term", "years")
);
CREATE TABLE `TA_COHORT` (
  `term_year` varchar(30)  NOT NULL,
  `ta_name` varchar(100) NOT NULL,
  `student_id` varchar(40)  NOT NULL,
  `legal_name` varchar(100) NOT NULL,
  `email` varchar(40)  NOT NULL,
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
  `Notes` varchar(500) NULL,
  PRIMARY KEY ("email","student_id", "term_year")

);
CREATE TABLE `Course_Quota` (
  `term_year` varchar(30)  NOT NULL,
  `course_num` varchar(30)  NOT NULL,
  `course_type` varchar(30)  NOT NULL,
  `course_name` varchar(30)  NOT NULL,
  `instructor_name` varchar(30) NOT NULL,
  `course_enrollement_num` varchar(5) NOT NULL,
  `ta_quota` varchar(5) NOT NULL,
  `flagged` varchar(5) NOT NULL,
  `ratio` int NOT NULL,
  PRIMARY KEY ("term_year","course_num", "course_type", "course_name")
);
CREATE TABLE `TA_WISHLIST` (
`ta_email` varchar(30) NOT NULL,
`term_year` varchar(30) NOT NULL,
`course_num` varchar(30) NOT NULL,
`prof_name` varchar(100) NOT NULL,
`ta_name` varchar(100) NOT NULL,
PRIMARY KEY ("ta_email","term_year", "course_num", "prof_name", "ta_name")
);

CREATE TABLE `TA_PERFORMANCE_LOG` (
`ta_email` varchar(30) NOT NULL,
`term_year` varchar(30) NOT NULL,
`course_num` varchar(30) NOT NULL,
`ta_name` varchar(100) NOT NULL, 
`comment` varchar(500) NOT NULL,
`time_stamp` varchar(100) NOT NULL
);

CREATE TABLE `ed_stats` (
`course_num` varchar(200) NOT NULL,
`term_year` varchar(100) NOT NULL,
`name` varchar(200) NOT NULL,
`email` varchar(200) NOT NULL,
`role` varchar(30) NOT NULL,
`tutorial` varchar(200) NOT NULL, 
`sis_id` varchar(30) NOT NULL,
`questions` varchar(30) NOT NULL,
`posts` varchar(30) NOT NULL,
`announcements` varchar(30) NOT NULL,
`comments` varchar(30) NOT NULL,
`answers` varchar(30) NOT NULL,
`accepted_answers` varchar(30) NOT NULL,
`hearts` varchar(30) NOT NULL,
`endorsements` varchar(30) NOT NULL,
`declines` varchar(30) NOT NULL,
`declines_given` varchar(30) NOT NULL,
`days_active` varchar(30) NOT NULL,
`last_active` varchar(200) NOT NULL,
`enrolled` varchar(200) NOT NULL
);

CREATE TABLE `message` (
  `course` varchar(40) NOT NULL,
  `term` varchar(30) NOT NULL,
  `year` varchar(4) NOT NULL,
  `user` varchar(30) NOT NULL,
  `time` varchar(30) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `tag` varchar(30),
  PRIMARY KEY(
     `course`,
     `term`,
     `year`,
     `user`,
     `time`
   ),
  CONSTRAINT message_ForeignKey
   FOREIGN KEY (`course`, `term`, `year`) REFERENCES `Course` (`courseNumber`,`term`, `year`)
);

INSERT INTO `User` (`firstName`, `lastName`, `email`, `password`, `studentId`, `username`) VALUES
('Mathieu', 'Blanchette', 'mathieu@comp307.com', '$2y$10$5HxIGFEmYO6OyG7IOgjlmuCRofwLTG2Ah9DtiEdGetHD.rZZN0Xbq','260845200', 'mathieu.blanchette'),
('Ali Murtaza', 'Malik', 'ali.malik@mcgill.ca', '$2y$10$BeRmXpghgI4W.4Ojow1.p.ONz04hf1dYVLqsH9ScI2fsAXpd8GG3C', '260845298', 'ali.malik'),
('Doruk', 'Can', 'Doruk@mcgill.ca', '$2y$10$paS3gzcHk/IYfzyRaKqEk.rxUFIg1EaxY8cYczt3cUqVmcazSSivG', '', 'doruk.can'),
('Saumyaa', 'Verma', 'saumya.verma@mcgill.ca', '$2y$10$4WChTJyN.gsIXJfTEX02JeosHMKIBlUhTqnjUzULy.zTAIuaak7.a', '260845259', 'saumya.verma'),
('Sym', 'Piracha', 'sym.piracha@mcgill.ca', '$2y$10$5aicsVN7CiRJsKBCGaVhruQoUmR6p7oJMMJLnJrBe6c8dmQzFSXom', '260845256', 'sym.piracha'),
('Saad', 'Shahbaz', 'saad.shahbaz@mcgill.ca', '$2y$10$Sw5w3wR5EEM4nQdFxcAFVutnGkHoLlyhv54MvSnn0BpvMX70XKtL6', '260845253', 'saad.shahbaz'),
('Test', 'test', 'test.hussain@mcgill.ca', '$2y$10$Yibh0ujkpUrPtCCSS2DWGOZ3YfkFzWHuhbCZif3FIDTw/8st8eD62', '260845255', 'test.test'),
('Zahra', 'Hussain', 'zahra.hussain@mcgill.ca', '$2y$10$Yibh0ujkpUrPtCCSS2DWGOZ3YfkFzWHuhbCZif3FIDTw/8st8eD62', '260845254', 'zahra.hussain');


INSERT INTO `User_UserType` (`userId`, `userTypeId`) VALUES
('ali.malik@mcgill.ca', 1),
('avi@comp307.com', 5),
('Doruk@mcgill.ca', 2),
('jane@comp307.com', 1),
('jane@comp307.com', 3),
('john@comp307.com', 5),
('joseph@comp307.com', 2),
('mathieu@comp307.com', 2),
('saad.shahbaz@mcgill.ca', 3),
('saad.shahbaz@mcgill.ca', 4),
('saad.shahbaz@mcgill.ca', 5),
('saumya.verma@mcgill.ca', 1),
('saumya.verma@mcgill.ca', 3),
('sym.piracha@mcgill.ca', 3),
('zahra.hussain@mcgill.ca', 2),
('zahra.hussain@mcgill.ca', 3),
('zahra.hussain@mcgill.ca', 4);



INSERT INTO `ed_stats` (`course_num`, `term_year`, `name`, `email`, `role`, `tutorial`, `sis_id`, `questions`, `posts`, `announcements`, `comments`, `answers`, `accepted_answers`, `hearts`, `endorsements`, `declines`, `declines_given`, `days_active`, `last_active`, `enrolled`) VALUES
('COMP 250', 'Fall 2019', 'Joseph Vybihal', 'joseph.vybihal@mcgill.ca', 'admin', '', 'McG_3718', '248', '0', '0', '5', '28', '96', '87', '33', '0', '0', '0', '29', 'Fri, 09 Dec 2022 08:47:57 AEDT'),
('COMP 250', 'Fall 2022', 'Joseph Vybihal', 'joseph.vybihal@mcgill.ca', 'admin', '', 'McG_3718', '248', '0', '0', '5', '28', '96', '87', '33', '0', '0', '0', '29', 'Fri, 09 Dec 2022 08:47:57 AEDT');



INSERT INTO `TA` (`email`, `student_id`, `assigned_hours`, `ta_name`, `course`, `term`, `years`) VALUES
('saad.shahbaz@mcgill.ca', '260845253', '90', 'Saad Shahbaz', 'COMP 250', 'Fall', '2022'),
('sym.piracha@mcgill.ca', '260845256', '90', 'Sym Piracha', 'COMP 250', 'Fall', '2022'),
('zahra.hussain@mcgill.ca', '260845254', '90', 'Zahra Hussain', 'COMP 250', 'Fall', '2022');

INSERT INTO `TA_COHORT` (`term_year`, `ta_name`, `student_id`, `legal_name`, `email`, `grad_ugrad`, `supervisor_name`, `priority`, `hours_allocated`, `date_applied`, `location_assigned`, `phone`, `degree`, `course_applied`, `open_to_other_courses`, `Notes`) VALUES
('Winter 2022', 'Ann', '839298344', 'Ann Mickey', 'Ann.Micky@mail', 'grad', 'sunny', 'no', '180', '10/31/21', 'Montreal', '8348395594', 'Philosophy', 'PHIL 101', 'no', ''),
('Winter 2022', 'Chloe', '883822838', 'Chloe Vincent', 'Chloe.Vincent@mail', 'ugrad', 'grant', 'no', '180', '10/28/21', 'Montreal', '9589038656', 'Math', 'MATH 122', 'no', 'really wants to teach'),
('Winter 2022', 'Ella', '749322733', 'Ella Scarf', 'Ella.Scarf@mail', 'ugrad', 'poppy', 'no', '90', '10/27/21', 'Montreal', '7382651874', 'Computer Science', 'COMP 308', 'yes', ''),
('Winter 2022', 'Harry', '647333829', 'Harry Notebook', 'Harry.Notebook@mail', 'grad', 'lisa', 'no', '180', '10/30/21', 'Montreal', '1833248950', 'Religion', 'RELG 355', 'no', ''),
('Winter 2022', 'Joseph', '473227888', 'Joseph Drawer', 'Joseph.Drawer@mail', 'grad', 'ron', 'no', '180', '10/29/21', 'Montreal', '8373785984', 'Geography', 'GEOG 315', 'no', ''),
('Winter 2022', 'Julia', '639322665', 'Julia Bottle', 'Julia.Bottle@mail', 'ugrad', 'ruth', 'yes', '90', '10/25/21', 'Montreal', '8950932367', 'Art History', 'ARTH 333', 'yes', ''),
('Winter 2022', 'Maddie', '857622594', 'Maddie Mirror', 'Maddie.Mirror@mail', 'ugrad', 'bernard', 'yes', '90', '10/26/21', 'Montreal', '9039351234', 'Environment', 'ENVR 421', 'yes', ''),
('Winter 2022', 'Bob', '157322936', 'Robert Bunny', 'Robert.bunny@mcgill', 'grad', 'gwynn', 'yes', '90', '10/24/21', 'Montreal', '6873651223', 'Computer Science', 'COMP 202, COMP 303', 'yes', ''),
('Winter 2022', 'Saad', '260845253', 'Saad Shahbaz', 'saad.shahbaz@mcgill.ca', 'grad', 'gwynn', 'yes', '90', '10/24/21', 'Montreal', '6873651223', 'Computer Science', 'COMP 202, COMP 303', 'yes', '');


INSERT INTO `TA_PERFORMANCE_LOG` (`ta_email`, `term_year`, `course_num`, `ta_name`, `comment`, `time_stamp`) VALUES
('saad.shahbaz@mcgill.ca', 'Fall 2022', 'COMP 250', 'Saad Shahbaz', 'Checked alls assignments within deadline!', '2022-12-07 20:55:47'),
('saad.shahbaz@mcgill.ca', 'Fall 2022', 'COMP 250', 'Saad Shahbaz', 'Works Really Hard!', '2022-12-08 10:04:28'),
('saad.shahbaz@mcgill.ca', 'Fall 2022', 'COMP 250', 'Saad Shahbaz', 'Good TA!', '2022-12-11 23:40:16');

INSERT INTO `TA_Ratings` (`student_email`, `ta_email`, `rating`, `Notes`, `course`, `term`, `years`) VALUES
('ali.malik@mcgill.ca', 'saad.shahbaz@mcgill.ca', 5, 'Yes!', 'COMP 250', 'Fall', '2022'),
('saad.shahbaz@mail.mcgill.ca', 'zahra.hussain@mcgill.ca', 5, 'Good TA!', 'COMP 250', 'Fall', '2022'),
('saad.shahbaz@mcgill.ca', 'saad.shahbaz@mcgill.ca', 5, 'das', 'COMP 250', 'Fall', '2022');

INSERT INTO `TA_WISHLIST` (`ta_email`, `term_year`, `course_num`, `prof_name`, `ta_name`) VALUES
('saad.shahbaz@mcgill.ca', 'Fall 2022', 'COMP 250', 'Joseph Vybihal', 'Saad Shahbaz'),
('zahra.hussain@mcgill.ca', 'Fall 2022', 'COMP 250', 'Saad Shahbaz', 'Zahra Hussain');



INSERT INTO `TA_PERFORMANCE_LOG` (`ta_email`, `term_year`, `course_num`, `ta_name`, `comment`, `time_stamp`) VALUES
('saad.shahbaz@mcgill.ca', 'Fall 2022', 'COMP 250', 'Saad Shahbaz', 'Checked alls assignments within deadline!', '2022-12-07 20:55:47'),
('saad.shahbaz@mcgill.ca', 'Fall 2022', 'COMP 250', 'Saad Shahbaz', 'Works Really Hard!', '2022-12-08 10:04:28'),
('saad.shahbaz@mcgill.ca', 'Fall 2022', 'COMP 250', 'Saad Shahbaz', 'Good TA!', '2022-12-11 23:40:16');
COMMIT;

PRAGMA foreign_keys=ON;


