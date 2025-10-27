
USE university_db;

-- Courses table
CREATE TABLE IF NOT EXISTS courses (
  course_no VARCHAR(10) PRIMARY KEY,
  course_name VARCHAR(100) NOT NULL,
  credit DECIMAL(3,1) CHECK (credit > 0 AND credit <= 4),
  d_id INT,
  FOREIGN KEY (d_id) REFERENCES departments(dept_id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

-- Books table
CREATE TABLE IF NOT EXISTS books (
  book_no INT PRIMARY KEY AUTO_INCREMENT,
  book_name VARCHAR(150) NOT NULL,
  author VARCHAR(100),
  edition INT
);

-- Book references: many-to-many between books and courses
CREATE TABLE IF NOT EXISTS book_refs (
  book_no INT,
  course_no VARCHAR(10),
  PRIMARY KEY (book_no, course_no),
  FOREIGN KEY (book_no) REFERENCES books(book_no)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (course_no) REFERENCES courses(course_no)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- Sample courses (ensure departments exist)
INSERT INTO courses (course_no, course_name, credit, d_id) VALUES
('CSE1101', 'Discrete Mathematics', 3.0, 1),
('CSE3109', 'Database Systems', 3.0, 1),
('EEE1101', 'Basic Electrical Engineering', 3.0, 2),
('ME3101', 'Solid Mechanics', 3.0, 4);

-- Sample books
INSERT INTO books (book_name, author, edition) VALUES
('Discrete Mathematics', 'Rosen', 8),
('Database System Concepts', 'Silberschatz', 7),
('Data and Computer Communications', 'William Stallings', 6),
('Solid Mechanics', 'Rowland Richards', 3);

-- Sample book_refs (use inserted book_no ids; if your books table already has entries ids may differ)
INSERT INTO book_refs (book_no, course_no) VALUES
(1, 'CSE1101'),
(2, 'CSE3109'),
(3, 'EEE1101'),
(4, 'ME3101');
