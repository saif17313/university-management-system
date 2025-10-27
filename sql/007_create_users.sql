USE university_db;

CREATE TABLE IF NOT EXISTS users (
  user_id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','teacher','student') NOT NULL,
  ref_id INT DEFAULT NULL
);

-- Example logins
-- password for all below = 12345
INSERT INTO users (username, password_hash, role, ref_id) VALUES
('admin',  SHA2('12345',256), 'admin', NULL),
('teacher1', SHA2('12345',256), 'teacher', 1),
('student1', SHA2('12345',256), 'student', 1);
