-- ==========================================
-- KUET (Khulna University of Engineering & Technology) Seed Data
-- Based on actual departments and realistic data
-- ==========================================

USE university_db;

-- ==========================================
-- DROP ALL PREVIOUS RECORDS
-- ==========================================

-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

-- Delete all existing data from tables
DELETE FROM book_refs;
DELETE FROM books;
DELETE FROM students;
DELETE FROM courses;
DELETE FROM teachers;
DELETE FROM departments;
DELETE FROM users;

-- Reset auto-increment counters
ALTER TABLE book_refs AUTO_INCREMENT = 1;
ALTER TABLE books AUTO_INCREMENT = 1;
ALTER TABLE students AUTO_INCREMENT = 1;
ALTER TABLE courses AUTO_INCREMENT = 1;
ALTER TABLE teachers AUTO_INCREMENT = 1;
ALTER TABLE departments AUTO_INCREMENT = 1;
ALTER TABLE users AUTO_INCREMENT = 1;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

SELECT 'All previous records deleted successfully!' AS Status;

-- ==========================================
-- DEPARTMENTS (Based on KUET Faculties)
-- ==========================================

INSERT INTO departments (dept_name, faculty, no_of_students) VALUES
-- Faculty of Civil Engineering
('Civil Engineering', 'Civil Engineering', 240),
('Urban & Regional Planning', 'Civil Engineering', 120),
('Building Engineering & Construction Management', 'Civil Engineering', 60),

-- Faculty of Electrical & Electronic Engineering  
('Electrical & Electronic Engineering', 'Electrical & Electronic Engineering', 240),
('Electronics & Communication Engineering', 'Electrical & Electronic Engineering', 180),
('Biomedical Engineering', 'Electrical & Electronic Engineering', 120),

-- Faculty of Mechanical Engineering
('Mechanical Engineering', 'Mechanical Engineering', 240),
('Industrial Engineering & Management', 'Mechanical Engineering', 120),
('Energy Science & Engineering', 'Mechanical Engineering', 120),

-- Faculty of Computer Science & Engineering
('Computer Science & Engineering', 'Computer Science & Engineering', 240),

-- Faculty of Chemical Engineering
('Chemical Engineering', 'Chemical Engineering', 180),
('Leather Engineering', 'Chemical Engineering', 60),

-- Faculty of Architecture
('Architecture', 'Architecture', 120),

-- Other Departments
('Mathematics', 'Science', 80),
('Physics', 'Science', 80),
('Chemistry', 'Science', 80),
('Humanities', 'Arts & Humanities', 60);

-- ==========================================
-- TEACHERS (Realistic KUET Faculty)
-- ==========================================

INSERT INTO teachers (t_name, gender, salary, dept_id) VALUES
-- Computer Science & Engineering (dept_id = 10)
('Dr. Md. Rezaul Karim', 'Male', 95000, 10),
('Dr. Kazi Sakib', 'Male', 92000, 10),
('Dr. Mahmudul Hasan', 'Male', 88000, 10),
('Dr. Tasnim Ahmed', 'Female', 90000, 10),
('Md. Ashraful Islam', 'Male', 75000, 10),
('Sharmin Akter', 'Female', 72000, 10),

-- Electrical & Electronic Engineering (dept_id = 4)
('Dr. Muhammad Abdus Salam', 'Male', 98000, 4),
('Dr. Quazi Delwar Hossain', 'Male', 96000, 4),
('Dr. Anika Rahman', 'Female', 89000, 4),
('Md. Rakibul Hassan', 'Male', 78000, 4),
('Fahmida Sultana', 'Female', 76000, 4),

-- Mechanical Engineering (dept_id = 7)
('Dr. Mohammad Ali', 'Male', 94000, 7),
('Dr. Khandaker Akhter Hossain', 'Male', 91000, 7),
('Dr. Nasrin Jahan', 'Female', 87000, 7),
('Md. Shahriar Hossain', 'Male', 74000, 7),

-- Civil Engineering (dept_id = 1)
('Dr. Muhammed Alamgir', 'Male', 97000, 1),
('Dr. Tanvir Ahmed', 'Male', 93000, 1),
('Dr. Roksana Akter', 'Female', 90000, 1),
('Md. Saiful Islam', 'Male', 77000, 1),

-- Chemical Engineering (dept_id = 11)
('Dr. Jiban Krishna Biswas', 'Male', 92000, 11),
('Dr. Farhana Yasmin', 'Female', 88000, 11),
('Md. Shahrukh Khan', 'Male', 75000, 11),

-- Architecture (dept_id = 13)
('Dr. Mohammad Foysal', 'Male', 89000, 13),
('Archi. Lamia Karim', 'Female', 84000, 13),
('Archi. Mehedi Hasan', 'Male', 78000, 13),

-- Mathematics (dept_id = 14)
('Dr. Abdul Hakim', 'Male', 85000, 14),
('Dr. Fahima Khatun', 'Female', 82000, 14),

-- Physics (dept_id = 15)
('Dr. Abul Kashem', 'Male', 86000, 15),
('Dr. Rehana Parvin', 'Female', 83000, 15),

-- Industrial Engineering (dept_id = 8)
('Dr. Sabbir Ahmed', 'Male', 88000, 8),
('Nusrat Jahan', 'Female', 76000, 8);

-- ==========================================
-- STUDENTS (Realistic KUET Students)
-- ==========================================

INSERT INTO students (s_name, cgpa, dept_id, advisor_id) VALUES
-- CSE Students (dept_id = 10)
('Md. Fahim Rahman', 3.78, 10, 1),
('Tasnia Islam', 3.92, 10, 1),
('Rahim Uddin', 3.45, 10, 2),
('Fatema Khatun', 3.67, 10, 2),
('Md. Tanvir Hossain', 3.55, 10, 3),
('Sadia Afrin', 3.88, 10, 3),
('Karim Hossain', 3.34, 10, 4),
('Nusrat Jahan', 3.71, 10, 4),
('Md. Rakib Hasan', 3.82, 10, 5),
('Ayesha Siddika', 3.96, 10, 5),
('Sabbir Ahmed', 3.28, 10, 6),
('Lamia Rahman', 3.63, 10, 6),

-- EEE Students (dept_id = 4)
('Md. Arif Hossain', 3.75, 4, 7),
('Nafisa Tabassum', 3.84, 4, 7),
('Imran Khan', 3.52, 4, 8),
('Sumaiya Akter', 3.69, 4, 8),
('Md. Shahriar Islam', 3.43, 4, 9),
('Farhana Yasmin', 3.77, 4, 9),
('Rafiqul Islam', 3.38, 4, 10),
('Tasnuva Haque', 3.91, 4, 10),

-- Mechanical Engineering Students (dept_id = 7)
('Md. Mahmudul Hasan', 3.56, 7, 12),
('Sabrina Sultana', 3.73, 7, 12),
('Aminul Islam', 3.47, 7, 13),
('Nadia Afrin', 3.85, 7, 13),
('Md. Kamrul Hasan', 3.62, 7, 14),
('Ishrat Jahan', 3.79, 7, 14),

-- Civil Engineering Students (dept_id = 1)
('Md. Saif Rahman', 3.68, 1, 16),
('Mithila Akter', 3.81, 1, 16),
('Jahangir Alam', 3.54, 1, 17),
('Roksana Begum', 3.76, 1, 17),
('Md. Hasan Mahmud', 3.41, 1, 18),
('Sharmin Sultana', 3.87, 1, 18),

-- Chemical Engineering Students (dept_id = 11)
('Md. Shakib Al Hasan', 3.72, 11, 20),
('Tahmina Khatun', 3.64, 11, 20),
('Sajib Rahman', 3.49, 11, 21),
('Bushra Anjum', 3.83, 11, 21),

-- Architecture Students (dept_id = 13)
('Md. Farhan Ahmed', 3.58, 13, 23),
('Labiba Rahman', 3.74, 13, 23),
('Riyad Hossain', 3.66, 13, 24),
('Anika Tasnim', 3.89, 13, 24),

-- Mathematics Students (dept_id = 14)
('Md. Rashed Kabir', 3.71, 14, 26),
('Sumaya Akter', 3.86, 14, 26),

-- Physics Students (dept_id = 15)
('Md. Shakil Ahmed', 3.53, 15, 28),
('Nabila Tahsin', 3.78, 15, 28),

-- Industrial Engineering Students (dept_id = 8)
('Md. Nazmul Haque', 3.61, 8, 30),
('Farah Diba', 3.74, 8, 30);

-- ==========================================
-- COURSES (Realistic KUET Courses)
-- ==========================================

INSERT INTO courses (course_no, course_name, credit, d_id) VALUES
-- CSE Courses (dept_id = 10)
('CSE2101', 'Data Structures', 3.0, 10),
('CSE2201', 'Algorithms', 3.0, 10),
('CSE3101', 'Database Systems', 3.0, 10),
('CSE3201', 'Computer Networks', 3.0, 10),
('CSE3301', 'Operating Systems', 3.0, 10),
('CSE4101', 'Software Engineering', 3.0, 10),
('CSE4201', 'Artificial Intelligence', 3.0, 10),
('CSE4301', 'Machine Learning', 3.0, 10),
('CSE3401', 'Computer Graphics', 3.0, 10),
('CSE4401', 'Compiler Design', 3.0, 10),

-- EEE Courses (dept_id = 4)
('EEE2101', 'Circuit Theory', 3.0, 4),
('EEE2201', 'Digital Electronics', 3.0, 4),
('EEE3101', 'Electrical Machines', 3.0, 4),
('EEE3201', 'Power Systems', 3.0, 4),
('EEE3301', 'Control Systems', 3.0, 4),
('EEE4101', 'Communication Systems', 3.0, 4),
('EEE3401', 'Microprocessors', 3.0, 4),
('EEE4201', 'Signal Processing', 3.0, 4),

-- Mechanical Engineering Courses (dept_id = 7)
('ME2101', 'Engineering Mechanics', 3.0, 7),
('ME2201', 'Thermodynamics', 3.0, 7),
('ME3101', 'Fluid Mechanics', 3.0, 7),
('ME3201', 'Heat Transfer', 3.0, 7),
('ME3301', 'Manufacturing Processes', 3.0, 7),
('ME4101', 'Machine Design', 3.0, 7),
('ME4201', 'Automobile Engineering', 3.0, 7),

-- Civil Engineering Courses (dept_id = 1)
('CE2101', 'Structural Analysis', 3.0, 1),
('CE2201', 'Concrete Technology', 3.0, 1),
('CE3101', 'Geotechnical Engineering', 3.0, 1),
('CE3201', 'Transportation Engineering', 3.0, 1),
('CE3301', 'Water Resources Engineering', 3.0, 1),
('CE4101', 'Environmental Engineering', 3.0, 1),

-- Chemical Engineering Courses (dept_id = 11)
('ChE2101', 'Chemical Process Principles', 3.0, 11),
('ChE2201', 'Chemical Engineering Thermodynamics', 3.0, 11),
('ChE3101', 'Mass Transfer', 3.0, 11),
('ChE3201', 'Reactor Design', 3.0, 11),
('ChE4101', 'Process Control', 3.0, 11),

-- Mathematics Courses (dept_id = 14)
('MATH1101', 'Calculus I', 3.0, 14),
('MATH1201', 'Linear Algebra', 3.0, 14),
('MATH2101', 'Differential Equations', 3.0, 14),
('MATH3101', 'Numerical Methods', 3.0, 14),

-- Physics Courses (dept_id = 15)
('PHY1101', 'Classical Mechanics', 3.0, 15),
('PHY1201', 'Electricity & Magnetism', 3.0, 15),
('PHY2101', 'Quantum Mechanics', 3.0, 15),
('PHY3101', 'Solid State Physics', 3.0, 15);

-- ==========================================
-- BOOKS (Academic & Reference Books)
-- ==========================================

INSERT INTO books (book_name, author, edition) VALUES
-- Computer Science Books
('Introduction to Algorithms', 'Cormen, Leiserson, Rivest, Stein', 3),
('Database System Concepts', 'Silberschatz, Korth, Sudarshan', 7),
('Computer Networks', 'Andrew S. Tanenbaum', 5),
('Operating System Concepts', 'Abraham Silberschatz', 10),
('Software Engineering', 'Ian Sommerville', 10),
('Artificial Intelligence: A Modern Approach', 'Stuart Russell, Peter Norvig', 4),
('Pattern Recognition and Machine Learning', 'Christopher Bishop', 1),
('Computer Graphics: Principles and Practice', 'John F. Hughes', 3),
('Data Structures and Algorithm Analysis', 'Mark Allen Weiss', 3),
('Compiler Design', 'Alfred V. Aho', 2),

-- Electrical Engineering Books
('Electric Circuits', 'James W. Nilsson', 11),
('Digital Design', 'Morris Mano', 6),
('Electrical Machinery Fundamentals', 'Stephen J. Chapman', 5),
('Power System Analysis', 'John J. Grainger', 2),
('Modern Control Engineering', 'Katsuhiko Ogata', 5),
('Communication Systems', 'Simon Haykin', 5),
('Microprocessor Architecture', 'Jean-Michel Muller', 1),
('Digital Signal Processing', 'John G. Proakis', 4),

-- Mechanical Engineering Books
('Engineering Mechanics: Statics', 'R.C. Hibbeler', 14),
('Thermodynamics: An Engineering Approach', 'Yunus A. Cengel', 9),
('Fluid Mechanics', 'Frank M. White', 8),
('Heat and Mass Transfer', 'Yunus A. Cengel', 5),
('Manufacturing Engineering and Technology', 'Serope Kalpakjian', 7),
('Mechanical Engineering Design', 'Joseph Shigley', 11),
('Automotive Mechanics', 'William H. Crouse', 10),

-- Civil Engineering Books
('Structural Analysis', 'R.C. Hibbeler', 10),
('Properties of Concrete', 'A.M. Neville', 5),
('Principles of Geotechnical Engineering', 'Braja M. Das', 9),
('Transportation Engineering', 'C. Jotin Khisty', 4),
('Water Resources Engineering', 'Larry W. Mays', 3),
('Environmental Engineering', 'Howard S. Peavy', 1),

-- Chemical Engineering Books
('Elementary Principles of Chemical Processes', 'Richard M. Felder', 4),
('Introduction to Chemical Engineering Thermodynamics', 'J.M. Smith', 8),
('Mass Transfer Operations', 'Robert Treybal', 3),
('Chemical Reactor Analysis and Design', 'Gilbert F. Froment', 3),
('Process Dynamics and Control', 'Dale E. Seborg', 4),

-- Mathematics Books
('Calculus', 'James Stewart', 8),
('Linear Algebra and Its Applications', 'David C. Lay', 5),
('Differential Equations', 'Dennis G. Zill', 11),
('Numerical Methods for Engineers', 'Steven C. Chapra', 7),

-- Physics Books
('Classical Mechanics', 'Herbert Goldstein', 3),
('Introduction to Electrodynamics', 'David J. Griffiths', 4),
('Introduction to Quantum Mechanics', 'David J. Griffiths', 3),
('Solid State Physics', 'Neil W. Ashcroft', 1);

-- ==========================================
-- BOOK REFERENCES (Link books to courses)
-- ==========================================

INSERT INTO book_refs (book_no, course_no) VALUES
-- CSE Course Books
(1, 'CSE2101'), (9, 'CSE2101'),   -- Data Structures
(1, 'CSE2201'),                    -- Algorithms
(2, 'CSE3101'),                    -- Database Systems
(3, 'CSE3201'),                    -- Computer Networks
(4, 'CSE3301'),                    -- Operating Systems
(5, 'CSE4101'),                    -- Software Engineering
(6, 'CSE4201'),                    -- Artificial Intelligence
(7, 'CSE4301'),                    -- Machine Learning
(8, 'CSE3401'),                    -- Computer Graphics
(10, 'CSE4401'),                   -- Compiler Design

-- EEE Course Books
(11, 'EEE2101'),                   -- Circuit Theory
(12, 'EEE2201'),                   -- Digital Electronics
(13, 'EEE3101'),                   -- Electrical Machines
(14, 'EEE3201'),                   -- Power Systems
(15, 'EEE3301'),                   -- Control Systems
(16, 'EEE4101'),                   -- Communication Systems
(17, 'EEE3401'),                   -- Microprocessors
(18, 'EEE4201'),                   -- Signal Processing

-- Mechanical Course Books
(19, 'ME2101'),                    -- Engineering Mechanics
(20, 'ME2201'),                    -- Thermodynamics
(21, 'ME3101'),                    -- Fluid Mechanics
(22, 'ME3201'),                    -- Heat Transfer
(23, 'ME3301'),                    -- Manufacturing Processes
(24, 'ME4101'),                    -- Machine Design
(25, 'ME4201'),                    -- Automobile Engineering

-- Civil Course Books
(26, 'CE2101'),                    -- Structural Analysis
(27, 'CE2201'),                    -- Concrete Technology
(28, 'CE3101'),                    -- Geotechnical Engineering
(29, 'CE3201'),                    -- Transportation Engineering
(30, 'CE3301'),                    -- Water Resources Engineering
(31, 'CE4101'),                    -- Environmental Engineering

-- Chemical Course Books
(32, 'ChE2101'),                   -- Chemical Process Principles
(33, 'ChE2201'),                   -- Chemical Engineering Thermodynamics
(34, 'ChE3101'),                   -- Mass Transfer
(35, 'ChE3201'),                   -- Reactor Design
(36, 'ChE4101'),                   -- Process Control

-- Mathematics Course Books
(37, 'MATH1101'),                  -- Calculus I
(38, 'MATH1201'),                  -- Linear Algebra
(39, 'MATH2101'),                  -- Differential Equations
(40, 'MATH3101'),                  -- Numerical Methods

-- Physics Course Books
(41, 'PHY1101'),                   -- Classical Mechanics
(42, 'PHY1201'),                   -- Electricity & Magnetism
(43, 'PHY2101'),                   -- Quantum Mechanics
(44, 'PHY3101');                   -- Solid State Physics

-- ==========================================
-- USERS (Admin, Sample Teachers & Students)
-- ==========================================

INSERT INTO users (username, password_hash, role, ref_id) VALUES
-- Admin
('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin', NULL),

-- Sample Teachers (password: teacher123)
('rezaul.karim', 'cc4f4fb6b01814d5cfb0afe8d81c7c41dcd78c1a1b0c44a39d6e8f8c03dc2e64', 'teacher', 1),
('sakib.cse', 'cc4f4fb6b01814d5cfb0afe8d81c7c41dcd78c1a1b0c44a39d6e8f8c03dc2e64', 'teacher', 2),
('salam.eee', 'cc4f4fb6b01814d5cfb0afe8d81c7c41dcd78c1a1b0c44a39d6e8f8c03dc2e64', 'teacher', 7),
('ali.me', 'cc4f4fb6b01814d5cfb0afe8d81c7c41dcd78c1a1b0c44a39d6e8f8c03dc2e64', 'teacher', 12),
('alamgir.ce', 'cc4f4fb6b01814d5cfb0afe8d81c7c41dcd78c1a1b0c44a39d6e8f8c03dc2e64', 'teacher', 16),

-- Sample Students (password: student123)
('1805001', '74cc1c60799e0a786ac7094b532f01b56ce395b99bb6e7e1a90db2c370e9ba46', 'student', 1),
('1805002', '74cc1c60799e0a786ac7094b532f01b56ce395b99bb6e7e1a90db2c370e9ba46', 'student', 2),
('1705021', '74cc1c60799e0a786ac7094b532f01b56ce395b99bb6e7e1a90db2c370e9ba46', 'student', 13),
('1605031', '74cc1c60799e0a786ac7094b532f01b56ce395b99bb6e7e1a90db2c370e9ba46', 'student', 19),
('1805051', '74cc1c60799e0a786ac7094b532f01b56ce395b99bb6e7e1a90db2c370e9ba46', 'student', 27);

-- Display summary
SELECT 'Seed Data Loaded Successfully!' AS Status;
SELECT COUNT(*) AS Total_Departments FROM departments;
SELECT COUNT(*) AS Total_Teachers FROM teachers;
SELECT COUNT(*) AS Total_Students FROM students;
SELECT COUNT(*) AS Total_Courses FROM courses;
SELECT COUNT(*) AS Total_Books FROM books;
SELECT COUNT(*) AS Total_Book_References FROM book_refs;
SELECT COUNT(*) AS Total_Users FROM users;
