<?php
// public/admin/departments_edit.php
require_once __DIR__ . '/../../src/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Invalid department id.");
}

$errors = [];
$success = '';

// fetch department
$stmt = $mysqli->prepare("SELECT * FROM departments WHERE dept_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$dept = $res->fetch_assoc();
$stmt->close();

if (!$dept) die("Department not found.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dept_name = trim($_POST['dept_name'] ?? '');
    $faculty = trim($_POST['faculty'] ?? '');
    $no_of_students = intval($_POST['no_of_students'] ?? 0);

    if ($dept_name === '') $errors[] = "Department name is required.";
    if ($faculty === '') $errors[] = "Faculty is required.";
    if ($no_of_students < 0) $errors[] = "Number of students cannot be negative.";

    if (empty($errors)) {
        $u = $mysqli->prepare("UPDATE departments SET dept_name = ?, faculty = ?, no_of_students = ? WHERE dept_id = ?");
        $u->bind_param("ssii", $dept_name, $faculty, $no_of_students, $id);
        if ($u->execute()) {
            $success = "Department updated successfully.";
            // refresh $dept values
            $dept['dept_name'] = $dept_name;
            $dept['faculty'] = $faculty;
            $dept['no_of_students'] = $no_of_students;
        } else {
            $errors[] = "Update failed: " . $u->error;
        }
        $u->close();
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Department</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
  <nav><a href="departments_list.php">Back to list</a></nav>
  <main class="container">
    <h2>Edit Department #<?=htmlspecialchars($dept['dept_id'])?></h2>

    <?php if ($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <?php if (!empty($errors)): ?>
      <div class="errors"><ul><?php foreach ($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>

    <form method="post" action="">
      <label>Department name</label>
      <input type="text" name="dept_name" value="<?=htmlspecialchars($dept['dept_name'])?>" required>

      <label>Faculty</label>
      <input type="text" name="faculty" value="<?=htmlspecialchars($dept['faculty'])?>" required>

      <label>Number of students</label>
      <input type="number" name="no_of_students" min="0" value="<?=htmlspecialchars($dept['no_of_students'])?>">

      <button type="submit" class="btn">Save Changes</button>
    </form>
  </main>
</body>
</html>
