USE university_db;

-- View 1: Total students per department
CREATE OR REPLACE VIEW view_students_per_dept AS
SELECT d.dept_id, d.dept_name, COUNT(s.s_id) AS total_students
FROM departments d
LEFT JOIN students s ON d.dept_id = s.dept_id
GROUP BY d.dept_id, d.dept_name;

-- View 2: Total teachers per faculty
CREATE OR REPLACE VIEW view_teachers_per_faculty AS
SELECT d.faculty, COUNT(t.t_id) AS total_teachers
FROM departments d
LEFT JOIN teachers t ON d.dept_id = t.dept_id
GROUP BY d.faculty;

-- View 3: Teachers with salary above average
CREATE OR REPLACE VIEW view_high_salary_teachers AS
SELECT t.t_id, t.t_name, t.salary, d.dept_name
FROM teachers t
JOIN departments d ON t.dept_id = d.dept_id
WHERE t.salary > (SELECT AVG(salary) FROM teachers);

-- View 4: Students with CGPA above their department average
CREATE OR REPLACE VIEW view_top_students AS
SELECT s.s_id, s.s_name, s.cgpa, d.dept_name
FROM students s
JOIN departments d ON s.dept_id = d.dept_id
WHERE s.cgpa > (
  SELECT AVG(s2.cgpa)
  FROM students s2
  WHERE s2.dept_id = s.dept_id
);

-- View 5: Books linked to each course
CREATE OR REPLACE VIEW view_books_per_course AS
SELECT c.course_no, c.course_name, COUNT(br.book_no) AS total_books
FROM courses c
LEFT JOIN book_refs br ON c.course_no = br.course_no
GROUP BY c.course_no, c.course_name;
