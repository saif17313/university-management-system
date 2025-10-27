<?php
// public/admin/departments_add.php
require_once __DIR__ . '/../../src/db.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dept_name = trim($_POST['dept_name'] ?? '');
    $faculty = trim($_POST['faculty'] ?? '');
    $no_of_students = intval($_POST['no_of_students'] ?? 0);

    // Simple validation
    if ($dept_name === '') $errors[] = "Department name is required.";
    if ($faculty === '') $errors[] = "Faculty is required.";
    if ($no_of_students < 0) $errors[] = "Number of students cannot be negative.";

    if (empty($errors)) {
        $stmt = $mysqli->prepare("INSERT INTO departments (dept_name, faculty, no_of_students) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $dept_name, $faculty, $no_of_students);
        if ($stmt->execute()) {
            $success = "Department added successfully.";
            // clear form values
            $dept_name = $faculty = '';
            $no_of_students = 0;
        } else {
            $errors[] = "Insert failed: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Department</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
  <nav><a href="../index.php">Home</a> | <a href="departments_list.php">Department List</a></nav>
  <main class="container">
    <h2>Add Department</h2>

    <?php if ($success): ?>
      <div class="success"><?=htmlspecialchars($success)?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
      <div class="errors">
        <ul>
          <?php foreach ($errors as $e): ?>
            <li><?=htmlspecialchars($e)?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" action="">
      <label>Department name</label>
      <input type="text" name="dept_name" value="<?=htmlspecialchars($dept_name ?? '')?>" required>

      <label>Faculty</label>
      <input type="text" name="faculty" value="<?=htmlspecialchars($faculty ?? '')?>" required>

      <label>Number of students</label>
      <input type="number" name="no_of_students" min="0" value="<?=htmlspecialchars($no_of_students ?? 0)?>">

      <button type="submit" class="btn">Add Department</button>
    </form>
  </main>
</body>
</html>
