<?php
// public/admin/departments_list.php
require_once __DIR__ . '/../../src/db.php';

// fetch all departments
$res = $mysqli->query("SELECT * FROM departments ORDER BY dept_id ASC");
$departments = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Departments</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
  <nav><a href="../index.php">Home</a> | <a href="departments_add.php">Add Department</a></nav>
  <main class="container">
    <h2>Departments</h2>

    <table class="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Department</th>
          <th>Faculty</th>
          <th># Students</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($departments)): ?>
          <tr><td colspan="5">No departments found.</td></tr>
        <?php else: ?>
          <?php foreach ($departments as $d): ?>
            <tr>
              <td><?=htmlspecialchars($d['dept_id'])?></td>
              <td><?=htmlspecialchars($d['dept_name'])?></td>
              <td><?=htmlspecialchars($d['faculty'])?></td>
              <td><?=htmlspecialchars($d['no_of_students'])?></td>
              <td>
                <a href="departments_edit.php?id=<?=urlencode($d['dept_id'])?>">Edit</a> |
                <a href="departments_delete.php?id=<?=urlencode($d['dept_id'])?>" onclick="return confirm('Delete this department?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
