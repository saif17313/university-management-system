<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('teacher');
require_once __DIR__ . '/../../src/db.php';

// Get current teacher ID
$teacher_id = $_SESSION['user']['ref_id'];

// Fetch teacher details
$t_stmt = $mysqli->prepare("
  SELECT t.t_id, t.t_name, t.salary, d.dept_name
  FROM teachers t
  LEFT JOIN departments d ON t.dept_id = d.dept_id
  WHERE t.t_id = ?");
$t_stmt->bind_param("i", $teacher_id);
$t_stmt->execute();
$teacher = $t_stmt->get_result()->fetch_assoc();
$t_stmt->close();

// Fetch advised students
$s_res = $mysqli->prepare("
  SELECT s.s_id, s.s_name, s.cgpa, d.dept_name
  FROM students s
  JOIN departments d ON s.dept_id = d.dept_id
  WHERE s.advisor_id = ?");
$s_res->bind_param("i", $teacher_id);
$s_res->execute();
$students = $s_res->get_result()->fetch_all(MYSQLI_ASSOC);
$s_res->close();

// Calculate average CGPA of advised students
$avg_cgpa = null;
if (!empty($students)) {
    $ids = array_column($students, 'cgpa');
    $avg_cgpa = round(array_sum($ids) / count($ids), 2);
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Teacher Dashboard</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<nav class="navbar">
  <a href="../logout.php">Logout</a>
</nav>

<main class="container">
  <h2>👨‍🏫 Teacher Dashboard</h2>

  <section>
    <h3>Teacher Info</h3>
    <p><b>Name:</b> <?=htmlspecialchars($teacher['t_name'])?></p>
    <p><b>Department:</b> <?=htmlspecialchars($teacher['dept_name'])?></p>
    <p><b>Salary:</b> <?=htmlspecialchars($teacher['salary'])?></p>
  </section>

  <section>
    <h3>Advised Students</h3>
    <?php if (empty($students)): ?>
      <p>No students assigned yet.</p>
    <?php else: ?>
      <table class="data-table">
        <thead><tr><th>ID</th><th>Name</th><th>Department</th><th>CGPA</th></tr></thead>
        <tbody>
          <?php foreach($students as $s): ?>
          <tr>
            <td><?=$s['s_id']?></td>
            <td><?=htmlspecialchars($s['s_name'])?></td>
            <td><?=htmlspecialchars($s['dept_name'])?></td>
            <td><?=$s['cgpa']?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p><b>Average CGPA:</b> <?=$avg_cgpa?></p>
    <?php endif; ?>
  </section>
</main>
</body>
</html>
