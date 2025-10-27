-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 05:18 PM
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
-- Database: `university_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_no` int(11) NOT NULL,
  `book_name` varchar(150) NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `edition` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_no`, `book_name`, `author`, `edition`) VALUES
(1, 'Discrete Mathematics', 'Rosen', 8),
(2, 'Database System Concepts', 'Silberschatz', 7),
(3, 'Data and Computer Communications', 'William Stallings', 6),
(4, 'Solid Mechanics', 'Rowland Richards', 3);

-- --------------------------------------------------------

--
-- Table structure for table `book_refs`
--

CREATE TABLE `book_refs` (
  `book_no` int(11) NOT NULL,
  `course_no` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_refs`
--

INSERT INTO `book_refs` (`book_no`, `course_no`) VALUES
(1, 'CSE1101'),
(2, 'CSE3109'),
(3, 'EEE1101'),
(4, 'ME3101');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_no` varchar(10) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `credit` decimal(3,1) DEFAULT NULL CHECK (`credit` > 0 and `credit` <= 4),
  `d_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_no`, `course_name`, `credit`, `d_id`) VALUES
('CSE1101', 'Discrete Mathematics', 3.0, 1),
('CSE3109', 'Database Systems', 3.0, 1),
('EEE1101', 'Basic Electrical Engineering', 3.0, 2),
('ME3101', 'Solid Mechanics', 3.0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(50) NOT NULL,
  `faculty` varchar(50) NOT NULL,
  `no_of_students` int(11) DEFAULT 0 CHECK (`no_of_students` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `dept_name`, `faculty`, `no_of_students`) VALUES
(1, 'Computer Science & Engineering', 'Engineering', 120),
(2, 'Electrical & Electronic Engineering', 'Engineering', 100),
(4, 'Civil Engineering', 'Engineering', 80);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `cgpa` decimal(3,2) DEFAULT NULL CHECK (`cgpa` between 0 and 4),
  `dept_id` int(11) DEFAULT NULL,
  `advisor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`s_id`, `s_name`, `cgpa`, `dept_id`, `advisor_id`) VALUES
(6, 'Rahim Uddin', 3.75, 1, 1),
(7, 'Karim Hossain', 3.20, 1, 2),
(8, 'Lima Akter', 3.90, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `t_id` int(11) NOT NULL,
  `t_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female') DEFAULT 'Male',
  `salary` decimal(10,2) DEFAULT NULL CHECK (`salary` >= 0),
  `dept_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`t_id`, `t_name`, `gender`, `salary`, `dept_id`) VALUES
(1, 'Alice Ahmed', 'Female', 8000.00, 1),
(2, 'Bob Khan', 'Male', 7500.00, 2),
(3, 'Charlie Roy', 'Male', 9000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL,
  `ref_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `role`, `ref_id`) VALUES
(1, 'admin', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'admin', NULL),
(2, 'teacher1', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'teacher', 1),
(3, 'student1', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'student', 6);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_books_per_course`
-- (See below for the actual view)
--
CREATE TABLE `view_books_per_course` (
`course_no` varchar(10)
,`course_name` varchar(100)
,`total_books` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_high_salary_teachers`
-- (See below for the actual view)
--
CREATE TABLE `view_high_salary_teachers` (
`t_id` int(11)
,`t_name` varchar(100)
,`salary` decimal(10,2)
,`dept_name` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_students_per_dept`
-- (See below for the actual view)
--
CREATE TABLE `view_students_per_dept` (
`dept_id` int(11)
,`dept_name` varchar(50)
,`total_students` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_teachers_per_faculty`
-- (See below for the actual view)
--
CREATE TABLE `view_teachers_per_faculty` (
`faculty` varchar(50)
,`total_teachers` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_top_students`
-- (See below for the actual view)
--
CREATE TABLE `view_top_students` (
`s_id` int(11)
,`s_name` varchar(100)
,`cgpa` decimal(3,2)
,`dept_name` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure for view `view_books_per_course`
--
DROP TABLE IF EXISTS `view_books_per_course`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `view_books_per_course`  AS SELECT `c`.`course_no` AS `course_no`, `c`.`course_name` AS `course_name`, count(`br`.`book_no`) AS `total_books` FROM (`courses` `c` left join `book_refs` `br` on(`c`.`course_no` = `br`.`course_no`)) GROUP BY `c`.`course_no`, `c`.`course_name` ;

-- --------------------------------------------------------

--
-- Structure for view `view_high_salary_teachers`
--
DROP TABLE IF EXISTS `view_high_salary_teachers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `view_high_salary_teachers`  AS SELECT `t`.`t_id` AS `t_id`, `t`.`t_name` AS `t_name`, `t`.`salary` AS `salary`, `d`.`dept_name` AS `dept_name` FROM (`teachers` `t` join `departments` `d` on(`t`.`dept_id` = `d`.`dept_id`)) WHERE `t`.`salary` > (select avg(`teachers`.`salary`) from `teachers`) ;

-- --------------------------------------------------------

--
-- Structure for view `view_students_per_dept`
--
DROP TABLE IF EXISTS `view_students_per_dept`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `view_students_per_dept`  AS SELECT `d`.`dept_id` AS `dept_id`, `d`.`dept_name` AS `dept_name`, count(`s`.`s_id`) AS `total_students` FROM (`departments` `d` left join `students` `s` on(`d`.`dept_id` = `s`.`dept_id`)) GROUP BY `d`.`dept_id`, `d`.`dept_name` ;

-- --------------------------------------------------------

--
-- Structure for view `view_teachers_per_faculty`
--
DROP TABLE IF EXISTS `view_teachers_per_faculty`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `view_teachers_per_faculty`  AS SELECT `d`.`faculty` AS `faculty`, count(`t`.`t_id`) AS `total_teachers` FROM (`departments` `d` left join `teachers` `t` on(`d`.`dept_id` = `t`.`dept_id`)) GROUP BY `d`.`faculty` ;

-- --------------------------------------------------------

--
-- Structure for view `view_top_students`
--
DROP TABLE IF EXISTS `view_top_students`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `view_top_students`  AS SELECT `s`.`s_id` AS `s_id`, `s`.`s_name` AS `s_name`, `s`.`cgpa` AS `cgpa`, `d`.`dept_name` AS `dept_name` FROM (`students` `s` join `departments` `d` on(`s`.`dept_id` = `d`.`dept_id`)) WHERE `s`.`cgpa` > (select avg(`s2`.`cgpa`) from `students` `s2` where `s2`.`dept_id` = `s`.`dept_id`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_no`);

--
-- Indexes for table `book_refs`
--
ALTER TABLE `book_refs`
  ADD PRIMARY KEY (`book_no`,`course_no`),
  ADD KEY `course_no` (`course_no`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_no`),
  ADD KEY `d_id` (`d_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `advisor_id` (`advisor_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`t_id`),
  ADD KEY `dept_id` (`dept_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_refs`
--
ALTER TABLE `book_refs`
  ADD CONSTRAINT `book_refs_ibfk_1` FOREIGN KEY (`book_no`) REFERENCES `books` (`book_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_refs_ibfk_2` FOREIGN KEY (`course_no`) REFERENCES `courses` (`course_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `departments` (`dept_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`advisor_id`) REFERENCES `teachers` (`t_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
