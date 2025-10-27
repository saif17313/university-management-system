-- sql/005_create_students.sql
USE university_db;

CREATE TABLE IF NOT EXISTS students (
  s_id INT PRIMARY KEY AUTO_INCREMENT,
  s_name VARCHAR(100) NOT NULL,
  cgpa DECIMAL(3,2) CHECK (cgpa BETWEEN 0 AND 4),
  dept_id INT,
  advisor_id INT,
  FOREIGN KEY (dept_id) REFERENCES departments(dept_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (advisor_id) REFERENCES teachers(t_id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

-- Sample Data
INSERT INTO students (s_name, cgpa, dept_id, advisor_id) VALUES
('Rahim Uddin', 3.75, 1, 1),
('Karim Hossain', 3.20, 1, 3),
('Lima Akter', 3.90, 2, 2),
('Nusrat Jahan', 3.10, 4, 4),
('Siam Rahman', 3.60, 2, 2);
