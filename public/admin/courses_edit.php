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

    // Stronger validation
    if ($course_name === '') {
        $errors[] = "Course name is required.";
    } elseif (!preg_match("/^[A-Za-z0-9 .,:&'-]+$/", $course_name)) {
        $errors[] = "Course name may only contain letters, numbers, spaces, and basic punctuation.";
    } elseif (strlen($course_name) < 3 || strlen($course_name) > 200) {
        $errors[] = "Course name must be between 3 and 200 characters.";
    }
    
    if (!is_numeric($_POST['credit'] ?? '')) {
        $errors[] = "Credit must be a valid number.";
    } elseif ($credit <= 0 || $credit > 4) {
        $errors[] = "Credit must be between 0.5 and 4.0.";
    }

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
  <nav class="navbar">
    <a href="../index.php">🏠 Home</a>
    <a href="departments_list.php">Departments</a>
    <a href="teachers_list.php">Teachers</a>
    <a href="courses_list.php">Courses</a>
    <a href="books_list.php">Books</a>
    <a href="students_list.php">Students</a>
  </nav>
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
    
    <p><a href="courses_list.php" class="btn">← Back to List</a></p>
  </main>
</body>
</html>
