<?php
require_once __DIR__ . '/../../src/db.php';

$errors = [];
$success = '';

// Fetch departments and teachers for dropdowns
$depsRes = $mysqli->query("SELECT dept_id, dept_name FROM departments ORDER BY dept_name");
$departments = $depsRes ? $depsRes->fetch_all(MYSQLI_ASSOC) : [];

$teachRes = $mysqli->query("SELECT t_id, t_name FROM teachers ORDER BY t_name");
$teachers = $teachRes ? $teachRes->fetch_all(MYSQLI_ASSOC) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s_name = trim($_POST['s_name'] ?? '');
    $cgpa = $_POST['cgpa'] !== '' ? floatval($_POST['cgpa']) : null;
    $dept_id = isset($_POST['dept_id']) ? intval($_POST['dept_id']) : null;
    $advisor_id = isset($_POST['advisor_id']) && $_POST['advisor_id'] !== '' ? intval($_POST['advisor_id']) : null;

    // Stronger validation
    if ($s_name === '') {
        $errors[] = "Student name is required.";
    } elseif (!preg_match("/^[A-Za-z .'-]+$/", $s_name)) {
        $errors[] = "Student name may only contain letters, spaces, periods, hyphens, and apostrophes.";
    } elseif (strlen($s_name) < 2 || strlen($s_name) > 100) {
        $errors[] = "Student name must be between 2 and 100 characters.";
    }
    
    if ($cgpa === null) {
        $errors[] = "CGPA is required.";
    } elseif (!is_numeric($_POST['cgpa'] ?? '')) {
        $errors[] = "CGPA must be a valid number.";
    } elseif ($cgpa < 0 || $cgpa > 4) {
        $errors[] = "CGPA must be between 0.00 and 4.00.";
    }
    
    if ($dept_id === null || $dept_id <= 0) {
        $errors[] = "Department is required.";
    }

    if (empty($errors)) {
        $stmt = $mysqli->prepare("INSERT INTO students (s_name, cgpa, dept_id, advisor_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdii", $s_name, $cgpa, $dept_id, $advisor_id);
        if ($stmt->execute()) {
            $success = "Student added successfully.";
            $s_name = '';
            $cgpa = '';
            $dept_id = '';
            $advisor_id = '';
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
  <title>Add Student</title>
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
    <h2>Add Student</h2>
    <?php if ($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <?php if (!empty($errors)): ?><div class="errors"><ul><?php foreach($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach;?></ul></div><?php endif; ?>

    <form method="post" action="">
      <label>Full Name</label>
      <input type="text" name="s_name" value="<?=htmlspecialchars($s_name ?? '')?>" required>

      <label>CGPA</label>
      <input type="number" step="0.01" min="0" max="4" name="cgpa" value="<?=htmlspecialchars($cgpa ?? '')?>" required>

      <label>Department</label>
      <select name="dept_id" required>
        <option value="">-- select department --</option>
        <?php foreach($departments as $d): ?>
          <option value="<?=htmlspecialchars($d['dept_id'])?>" <?=isset($dept_id) && $dept_id==$d['dept_id']?'selected':''?>><?=htmlspecialchars($d['dept_name'])?></option>
        <?php endforeach; ?>
      </select>

      <label>Advisor</label>
      <select name="advisor_id">
        <option value="">-- select advisor (optional) --</option>
        <?php foreach($teachers as $t): ?>
          <option value="<?=htmlspecialchars($t['t_id'])?>" <?=isset($advisor_id) && $advisor_id==$t['t_id']?'selected':''?>><?=htmlspecialchars($t['t_name'])?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="btn">Add Student</button>
    </form>
    
    <p><a href="students_list.php" class="btn">← Back to List</a></p>
  </main>
</body>
</html>
