-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 17, 2024 at 06:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learnfy_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `Assignment`
--

CREATE TABLE `Assignment` (
  `AssignmentID` int(11) NOT NULL,
  `CourseID` int(11) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `user_id` int(20) NOT NULL,
  `playlist_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`user_id`, `playlist_id`) VALUES
(13, 11),
(13, 12);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(20) NOT NULL,
  `content_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `tutor_id` int(20) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(20) NOT NULL,
  `tutor_id` int(20) NOT NULL,
  `cid` int(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `video` varchar(100) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `tutor_id`, `cid`, `title`, `description`, `video`, `thumb`, `date`, `status`) VALUES
(10, 12, 11, 'deep learning ', 'neural networks', 'gO3Uy23cKqzD1sKGAAESorInksWgTonBCUVkvQMgrF1ONPtWTlICVI4LRyLdbUFFJ.mp4', 'jmdnrflFF8HNOtSC9xwEyxOh8gJ1pneyOAVQPve6P2hmyTqXolPNEEOfB6x8LLjiT.JPG', '2024-03-17', 'active'),
(11, 12, 12, 'gg', '4Jhy586T1l', 'T9ikzaiXLPINhNmMy4F2Q6CxvrTiRPp66MbL8xtxpW7Pq90Pa5qifXVLR1FUhayS7.mp4', 'XvElSMYHLDbm2tcLP2Ix3S4H6Edvxc8gmxdXgEGu6YbEgrC90Q4osDtxrfC43pTf1.png', '2024-03-17', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `Course`
--

CREATE TABLE `Course` (
  `CourseID` int(11) NOT NULL,
  `CourseName` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `InstructorID` int(11) DEFAULT NULL,
  `image` varchar(100) NOT NULL,
  `cstatus` varchar(20) NOT NULL DEFAULT 'de-active',
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Course`
--

INSERT INTO `Course` (`CourseID`, `CourseName`, `Description`, `InstructorID`, `image`, `cstatus`, `date`) VALUES
(11, 'Deep Learning ', 'Neural Networks ', 12, 'snMPBZ4SbFE5all1y5NnSjdWtFLRWZvsGkGu37x79qd7MmLRGFWBbvNdXrXPnippq.jpg', 'active', '2024-03-17'),
(12, 'PHP', 'Server Side Scripting Language ', 12, 'VD2Z5rfo0NamD54cHE0repqCn2c9oSmkDcfjWG64gGTiMPepmfGmrTIUlG51xDRuA.jpg', 'active', '2024-03-17');

-- --------------------------------------------------------

--
-- Table structure for table `discussion`
--

CREATE TABLE `discussion` (
  `did` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `response` varchar(1000) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_create`
--

CREATE TABLE `discussion_create` (
  `tid` int(20) NOT NULL,
  `did` int(20) NOT NULL,
  `Question` varchar(1000) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `due_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Lecture`
--

CREATE TABLE `Lecture` (
  `LectureID` int(11) NOT NULL,
  `CourseID` int(11) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Notes` text DEFAULT NULL,
  `VideoURL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` int(20) NOT NULL,
  `tutor_id` int(20) NOT NULL,
  `content_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `id` int(20) NOT NULL,
  `course_id` int(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profession_name`
--

CREATE TABLE `profession_name` (
  `pid` int(20) NOT NULL,
  `pname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profession_name`
--

INSERT INTO `profession_name` (`pid`, `pname`) VALUES
(1, 'student'),
(2, 'teacher'),
(3, 'web developer'),
(4, 'machine learning engineer'),
(5, 'software engineer'),
(6, 'other');

-- --------------------------------------------------------

--
-- Table structure for table `Quiz`
--

CREATE TABLE `Quiz` (
  `QuizID` int(11) NOT NULL,
  `CourseID` int(11) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Role_name`
--

CREATE TABLE `Role_name` (
  `rid` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Role_name`
--

INSERT INTO `Role_name` (`rid`, `role_name`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `sid` int(20) NOT NULL,
  `rid` int(20) NOT NULL,
  `pid` int(20) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `iname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`sid`, `rid`, `pid`, `lname`, `fname`, `iname`, `email`, `password`, `image`) VALUES
(12, 2, 4, 'Machaya', 'Tendai', 'terrencE', 'tendai12@gmail.com', '$2y$10$cRPIdMtO8H6nbJzfoZNaLe/ThWxYBg4JZVFNFZOjLhZI8j6cj76A6', 'mTZa8qyy7DjoLJo8xdRt2Wz5y4g9FozSKnVDkWX1xbgLFlkeiVrUwuWhJldsAYrPa.ico'),
(13, 1, 2, 'Machaya', 'Tindo', 'terrencE', 'tendai121@gmail.com', '$2y$10$zfb2b16/dggTTZdrcreHbOwg5CiF.zqMEX7QYZlBb2qF28lmScxly', 'V6vemN9JakuX5odw9TrckIwX8qpKRbVMZ1VynZkObNfzFV3fwK73qWKDdO50BM7Ui.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Assignment`
--
ALTER TABLE `Assignment`
  ADD PRIMARY KEY (`AssignmentID`),
  ADD KEY `fk_assignment_course` (`CourseID`);

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`user_id`,`playlist_id`),
  ADD KEY `playlist_id` (`playlist_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comments_user` (`user_id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_content_tutor` (`tutor_id`),
  ADD KEY `fk_content_playlist` (`cid`);

--
-- Indexes for table `Course`
--
ALTER TABLE `Course`
  ADD PRIMARY KEY (`CourseID`),
  ADD KEY `fk_course_instructor` (`InstructorID`);

--
-- Indexes for table `discussion`
--
ALTER TABLE `discussion`
  ADD KEY `did` (`did`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `discussion_create`
--
ALTER TABLE `discussion_create`
  ADD PRIMARY KEY (`did`),
  ADD KEY `fk_users_discussion` (`tid`);

--
-- Indexes for table `Lecture`
--
ALTER TABLE `Lecture`
  ADD PRIMARY KEY (`LectureID`),
  ADD KEY `fk_lecture_course` (`CourseID`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`user_id`,`tutor_id`,`content_id`),
  ADD KEY `fk_likes_tutor` (`tutor_id`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_playlist_tutor` (`course_id`) USING BTREE;

--
-- Indexes for table `profession_name`
--
ALTER TABLE `profession_name`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `Quiz`
--
ALTER TABLE `Quiz`
  ADD PRIMARY KEY (`QuizID`),
  ADD KEY `fk_quiz_course` (`CourseID`);

--
-- Indexes for table `Role_name`
--
ALTER TABLE `Role_name`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`sid`),
  ADD KEY `fk_users_role` (`rid`),
  ADD KEY `fk_users_pname` (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Assignment`
--
ALTER TABLE `Assignment`
  MODIFY `AssignmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Course`
--
ALTER TABLE `Course`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `discussion_create`
--
ALTER TABLE `discussion_create`
  MODIFY `did` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Lecture`
--
ALTER TABLE `Lecture`
  MODIFY `LectureID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Quiz`
--
ALTER TABLE `Quiz`
  MODIFY `QuizID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `sid` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Assignment`
--
ALTER TABLE `Assignment`
  ADD CONSTRAINT `fk_assignment_course` FOREIGN KEY (`CourseID`) REFERENCES `Course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `Course` (`CourseID`),
  ADD CONSTRAINT `fk_bookmark_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `fk_content_playlist` FOREIGN KEY (`cid`) REFERENCES `Course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_content_tutor` FOREIGN KEY (`tutor_id`) REFERENCES `Users` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Course`
--
ALTER TABLE `Course`
  ADD CONSTRAINT `fk_course_instructor` FOREIGN KEY (`InstructorID`) REFERENCES `Users` (`sid`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `discussion`
--
ALTER TABLE `discussion`
  ADD CONSTRAINT `fk_discussion_discussion` FOREIGN KEY (`did`) REFERENCES `discussion_create` (`did`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_disscussion_user` FOREIGN KEY (`uid`) REFERENCES `Users` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `discussion_create`
--
ALTER TABLE `discussion_create`
  ADD CONSTRAINT `fk_discussion_users` FOREIGN KEY (`tid`) REFERENCES `Users` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Lecture`
--
ALTER TABLE `Lecture`
  ADD CONSTRAINT `fk_lecture_course` FOREIGN KEY (`CourseID`) REFERENCES `Course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_likes_tutor` FOREIGN KEY (`tutor_id`) REFERENCES `Users` (`sid`) ON UPDATE CASCADE;

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `fk_playlist_tutor` FOREIGN KEY (`course_id`) REFERENCES `Course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Quiz`
--
ALTER TABLE `Quiz`
  ADD CONSTRAINT `fk_quiz_course` FOREIGN KEY (`CourseID`) REFERENCES `Course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `fk_users_pname` FOREIGN KEY (`pid`) REFERENCES `profession_name` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`rid`) REFERENCES `Role_name` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
