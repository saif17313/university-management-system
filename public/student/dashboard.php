<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('student');
require_once __DIR__ . '/../../src/db.php';

// Get current student ID
$student_id = $_SESSION['user']['ref_id'];

// Debug: Check if student_id is valid
if (!$student_id || $student_id <= 0) {
    die("Error: No valid student ID found in session. Please contact administrator.");
}

// Fetch student + dept + advisor info
$stmt = $mysqli->prepare("
  SELECT s.s_id, s.s_name, s.cgpa,
         d.dept_name, t.t_name AS advisor_name, t.salary AS advisor_salary
  FROM students s
  LEFT JOIN departments d ON s.dept_id = d.dept_id
  LEFT JOIN teachers t ON s.advisor_id = t.t_id
  WHERE s.s_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch all courses in student's department
$courses = [];
if ($student) {
  $c_stmt = $mysqli->prepare("
    SELECT c.course_no, c.course_name, c.credit
    FROM courses c
    WHERE c.d_id = (
      SELECT dept_id FROM students WHERE s_id = ?
    )");
  $c_stmt->bind_param("i", $student_id);
  $c_stmt->execute();
  $courses = $c_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $c_stmt->close();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<nav class="navbar">
  <a href="../logout.php">Logout</a>
</nav>

<main class="container">
  <h2>🎓 Student Dashboard</h2>

  <?php if (!$student): ?>
    <p>Student data not found.</p>
  <?php else: ?>
    <section>
      <h3>Profile Information</h3>
      <p><b>Name:</b> <?=htmlspecialchars($student['s_name'])?></p>
      <p><b>Department:</b> <?=htmlspecialchars($student['dept_name'])?></p>
      <p><b>CGPA:</b> <?=htmlspecialchars($student['cgpa'])?></p>
    </section>

    <section>
      <h3>Advisor Information</h3>
      <?php if ($student['advisor_name']): ?>
        <p><b>Advisor:</b> <?=htmlspecialchars($student['advisor_name'])?></p>
        <p><b>Advisor Salary:</b> <?=htmlspecialchars($student['advisor_salary'])?></p>
      <?php else: ?>
        <p>No advisor assigned yet.</p>
      <?php endif; ?>
    </section>

    <section>
      <h3>Available Courses (Your Department)</h3>
      <?php if (empty($courses)): ?>
        <p>No courses found for your department.</p>
      <?php else: ?>
        <table class="data-table">
          <thead><tr><th>Course Code</th><th>Course Name</th><th>Credit</th></tr></thead>
          <tbody>
            <?php foreach($courses as $c): ?>
              <tr>
                <td><?=htmlspecialchars($c['course_no'])?></td>
                <td><?=htmlspecialchars($c['course_name'])?></td>
                <td><?=htmlspecialchars($c['credit'])?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </section>
  <?php endif; ?>
</main>
</body>
</html>
