<?php
require_once __DIR__ . '/../../src/db.php';

$errors = [];
$success = '';
// get departments for dropdown
$depsRes = $mysqli->query("SELECT dept_id, dept_name FROM departments ORDER BY dept_name");
$departments = $depsRes ? $depsRes->fetch_all(MYSQLI_ASSOC) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_no = strtoupper(trim($_POST['course_no'] ?? ''));
    $course_name = trim($_POST['course_name'] ?? '');
    $credit = isset($_POST['credit']) ? floatval($_POST['credit']) : 0;
    $d_id = isset($_POST['d_id']) && $_POST['d_id'] !== '' ? intval($_POST['d_id']) : null;

    if ($course_no === '') $errors[] = "Course code is required.";
    if ($course_name === '') $errors[] = "Course name is required.";
    if ($credit <= 0 || $credit > 4) $errors[] = "Credit must be between 0 and 4.";

    if (empty($errors)) {
        $stmt = $mysqli->prepare("INSERT INTO courses (course_no, course_name, credit, d_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $course_no, $course_name, $credit, $d_id);
        if ($stmt->execute()) {
            $success = "Course added.";
            $course_no = $course_name = '';
            $credit = '';
            $d_id = '';
        } else {
            $errors[] = "Insert failed: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Add Course</title>
<link rel="stylesheet" href="../../css/style.css"></head>
<body>
  <nav><a href="../index.php">Home</a> | <a href="courses_list.php">Courses</a></nav>
  <main class="container">
    <h2>Add Course</h2>
    <?php if ($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <?php if (!empty($errors)): ?><div class="errors"><ul><?php foreach($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach;?></ul></div><?php endif; ?>

    <form method="post" action="">
      <label>Course Code (e.g. CSE1101)</label>
      <input type="text" name="course_no" value="<?=htmlspecialchars($course_no ?? '')?>" required>

      <label>Course Name</label>
      <input type="text" name="course_name" value="<?=htmlspecialchars($course_name ?? '')?>" required>

      <label>Credit</label>
      <input type="number" step="0.5" name="credit" min="0.5" max="4" value="<?=htmlspecialchars($credit ?? '')?>" required>

      <label>Department</label>
      <select name="d_id">
        <option value="">-- Select department --</option>
        <?php foreach ($departments as $d): ?>
          <option value="<?=htmlspecialchars($d['dept_id'])?>" <?=isset($d_id) && $d_id == $d['dept_id'] ? 'selected' : ''?>><?=htmlspecialchars($d['dept_name'])?></option>
        <?php endforeach; ?>
      </select>

      <button class="btn" type="submit">Add Course</button>
    </form>
  </main>
</body>
</html>
