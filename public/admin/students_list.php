<?php
require_once __DIR__ . '/../../src/db.php';

// fetch students with JOINs
$sql = "SELECT s.s_id, s.s_name, s.cgpa, d.dept_name, t.t_name AS advisor_name
        FROM students s
        LEFT JOIN departments d ON s.dept_id = d.dept_id
        LEFT JOIN teachers t ON s.advisor_id = t.t_id
        ORDER BY s.s_id";
$res = $mysqli->query($sql);
$students = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Students</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
  <nav class="navbar">
    <a href="../index.php">🏠 Home</a>
    <a href="departments_list.php">Departments</a>
    <a href="teachers_list.php">Teachers</a>
    <a href="courses_list.php">Courses</a>
    <a href="books_list.php">Books</a>
    <a href="students_list.php">Students</a>
  </nav>
  <main class="container">
    <h2>Students</h2>
    <a href="students_add.php" class="btn">➕ Add Student</a>

    <table class="data-table">
      <thead>
        <tr><th>ID</th><th>Name</th><th>CGPA</th><th>Department</th><th>Advisor</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if (empty($students)): ?>
          <tr><td colspan="6">No students found.</td></tr>
        <?php else: foreach($students as $s): ?>
          <tr>
            <td><?=htmlspecialchars($s['s_id'])?></td>
            <td><?=htmlspecialchars($s['s_name'])?></td>
            <td><?=htmlspecialchars(number_format($s['cgpa'],2))?></td>
            <td><?=htmlspecialchars($s['dept_name'])?></td>
            <td><?=htmlspecialchars($s['advisor_name'] ?? '—')?></td>
            <td>
              <a href="students_edit.php?id=<?=urlencode($s['s_id'])?>">Edit</a> |
              <a href="students_delete.php?id=<?=urlencode($s['s_id'])?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
