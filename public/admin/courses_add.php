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

    // Stronger validation
    if ($course_no === '') {
        $errors[] = "Course code is required.";
    } elseif (!preg_match("/^[A-Z]{3}[0-9]{4}$/", $course_no)) {
        $errors[] = "Course code must follow format: 3 letters + 4 digits (e.g., CSE1101).";
    }
    
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
  <nav class="navbar">
    <a href="../index.php">🏠 Home</a>
    <a href="departments_list.php">Departments</a>
    <a href="teachers_list.php">Teachers</a>
    <a href="courses_list.php">Courses</a>
    <a href="books_list.php">Books</a>
    <a href="students_list.php">Students</a>
  </nav>
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
    
    <p><a href="courses_list.php" class="btn">← Back to List</a></p>
  </main>
</body>
</html>
