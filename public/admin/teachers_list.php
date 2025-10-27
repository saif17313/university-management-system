<?php
require_once __DIR__ . '/../../src/db.php';

// fetch teachers with department name
$sql = "SELECT t.t_id, t.t_name, t.gender, t.salary, d.dept_name
        FROM teachers t
        LEFT JOIN departments d ON t.dept_id = d.dept_id
        ORDER BY t.t_id ASC";
$res = $mysqli->query($sql);
$teachers = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Teachers</title>
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
    <h2>Teachers</h2>
    <a href="teachers_add.php" class="btn">➕ Add Teacher</a>

    <table class="data-table">
      <thead>
        <tr>
          <th>ID</th><th>Name</th><th>Gender</th><th>Salary</th><th>Department</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($teachers)): ?>
          <tr><td colspan="6">No teachers found.</td></tr>
        <?php else: ?>
          <?php foreach ($teachers as $t): ?>
            <tr>
              <td><?=htmlspecialchars($t['t_id'])?></td>
              <td><?=htmlspecialchars($t['t_name'])?></td>
              <td><?=htmlspecialchars($t['gender'])?></td>
              <td><?=htmlspecialchars(number_format($t['salary'],2))?></td>
              <td><?=htmlspecialchars($t['dept_name'] ?? '—')?></td>
              <td>
                <a href="teachers_edit.php?id=<?=urlencode($t['t_id'])?>">Edit</a> |
                <a href="teachers_delete.php?id=<?=urlencode($t['t_id'])?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
