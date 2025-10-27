USE university_db;

CREATE TABLE IF NOT EXISTS teachers (
  t_id INT PRIMARY KEY AUTO_INCREMENT,
  t_name VARCHAR(100) NOT NULL,
  gender ENUM('Male','Female') DEFAULT 'Male',
  salary DECIMAL(10,2) CHECK (salary >= 0),
  dept_id INT,
  FOREIGN KEY (dept_id) REFERENCES departments(dept_id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

-- sample teachers (make sure dept ids exist in departments table)
INSERT INTO teachers (t_name, gender, salary, dept_id) VALUES
('Alice Ahmed', 'Female', 8000.00, 1),
('Bob Khan', 'Male', 7500.00, 2),
('Charlie Roy', 'Male', 9000.00, 1);
