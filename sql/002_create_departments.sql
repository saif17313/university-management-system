
CREATE DATABASE IF NOT EXISTS university_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE university_db;

CREATE TABLE IF NOT EXISTS departments (
  dept_id INT PRIMARY KEY AUTO_INCREMENT,
  dept_name VARCHAR(50) NOT NULL,
  faculty VARCHAR(50) NOT NULL,
  no_of_students INT DEFAULT 0 CHECK (no_of_students >= 0)
);

-- Sample data
INSERT INTO departments (dept_name, faculty, no_of_students) VALUES
('Computer Science & Engineering', 'Engineering', 120),
('Electrical & Electronic Engineering', 'Engineering', 100),
('Civil Engineering', 'Engineering', 80);
