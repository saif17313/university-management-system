<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('admin');
require_once __DIR__ . '/../../src/db.php';

$sql = "SELECT c.course_no, c.course_name, c.credit, d.dept_name
        FROM courses c
        LEFT JOIN departments d ON c.d_id = d.dept_id
        ORDER BY c.course_no";
$res = $mysqli->query($sql);
$courses = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Courses | Admin Panel</title>
<link rel="stylesheet" href="../../css/style.css"></head>
<body>
<?php include __DIR__ . '/../../src/admin_nav.php'; ?>
  <main class="container">
    <h2>Courses</h2>
    <a href="courses_add.php" class="btn">➕ Add Course</a>

    <table class="data-table">
      <thead><tr><th>Code</th><th>Name</th><th>Credit</th><th>Department</th><th>Actions</th></tr></thead>
      <tbody>
        <?php if (empty($courses)): ?>
          <tr><td colspan="5">No courses found.</td></tr>
        <?php else: foreach ($courses as $c): ?>
          <tr>
            <td><?=htmlspecialchars($c['course_no'])?></td>
            <td><?=htmlspecialchars($c['course_name'])?></td>
            <td><?=htmlspecialchars($c['credit'])?></td>
            <td><?=htmlspecialchars($c['dept_name'] ?? '—')?></td>
            <td><a href="courses_edit.php?code=<?=urlencode($c['course_no'])?>">Edit</a> |
                <a href="courses_delete.php?code=<?=urlencode($c['course_no'])?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
