<?php
require_once __DIR__ . '/../../src/db.php';
$code = isset($_GET['code']) ? strtoupper(trim($_GET['code'])) : '';
if ($code === '') die("Invalid course code.");

$depsRes = $mysqli->query("SELECT dept_id, dept_name FROM departments ORDER BY dept_name");
$departments = $depsRes ? $depsRes->fetch_all(MYSQLI_ASSOC) : [];

// fetch existing
$stmt = $mysqli->prepare("SELECT * FROM courses WHERE course_no = ?");
$stmt->bind_param("s", $code);
$stmt->execute();
$res = $stmt->get_result();
$course = $res->fetch_assoc();
$stmt->close();
if (!$course) die("Course not found.");

$errors = []; $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = trim($_POST['course_name'] ?? '');
    $credit = isset($_POST['credit']) ? floatval($_POST['credit']) : 0;
    $d_id = isset($_POST['d_id']) && $_POST['d_id'] !== '' ? intval($_POST['d_id']) : null;

    if ($course_name === '') $errors[] = "Course name required.";
    if ($credit <= 0 || $credit > 4) $errors[] = "Credit must be 0 < credit ≤ 4.";

    if (empty($errors)) {
        $u = $mysqli->prepare("UPDATE courses SET course_name = ?, credit = ?, d_id = ? WHERE course_no = ?");
        $u->bind_param("sdis", $course_name, $credit, $d_id, $code);
        if ($u->execute()) {
            $success = "Course updated.";
            $course['course_name'] = $course_name;
            $course['credit'] = $credit;
            $course['d_id'] = $d_id;
        } else $errors[] = "Update failed: " . $u->error;
        $u->close();
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Course</title>
<link rel="stylesheet" href="../../css/style.css"></head>
<body>
  <nav><a href="courses_list.php">Back to list</a></nav>
  <main class="container">
    <h2>Edit Course <?=htmlspecialchars($course['course_no'])?></h2>
    <?php if ($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <?php if (!empty($errors)): ?><div class="errors"><ul><?php foreach($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach;?></ul></div><?php endif; ?>
    <form method="post" action="">
      <label>Course Name</label>
      <input type="text" name="course_name" value="<?=htmlspecialchars($course['course_name'])?>" required>

      <label>Credit</label>
      <input type="number" step="0.5" name="credit" min="0.5" max="4" value="<?=htmlspecialchars($course['credit'])?>" required>

      <label>Department</label>
      <select name="d_id">
        <option value="">-- Select department --</option>
        <?php foreach ($departments as $d): ?>
          <option value="<?=htmlspecialchars($d['dept_id'])?>" <?=($course['d_id']==$d['dept_id']) ? 'selected' : ''?>><?=htmlspecialchars($d['dept_name'])?></option>
        <?php endforeach; ?>
      </select>

      <button class="btn" type="submit">Save</button>
    </form>
  </main>
</body>
</html>
