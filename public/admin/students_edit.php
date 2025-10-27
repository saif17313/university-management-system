<?php
require_once __DIR__ . '/../../src/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Invalid student id.");

$depsRes = $mysqli->query("SELECT dept_id, dept_name FROM departments ORDER BY dept_name");
$departments = $depsRes ? $depsRes->fetch_all(MYSQLI_ASSOC) : [];

$teachRes = $mysqli->query("SELECT t_id, t_name FROM teachers ORDER BY t_name");
$teachers = $teachRes ? $teachRes->fetch_all(MYSQLI_ASSOC) : [];

$stmt = $mysqli->prepare("SELECT * FROM students WHERE s_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$student = $res->fetch_assoc();
$stmt->close();
if (!$student) die("Student not found.");

$errors = [];
$success = '';

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
        $u = $mysqli->prepare("UPDATE students SET s_name = ?, cgpa = ?, dept_id = ?, advisor_id = ? WHERE s_id = ?");
        $u->bind_param("sdiii", $s_name, $cgpa, $dept_id, $advisor_id, $id);
        if ($u->execute()) {
            $success = "Student updated.";
            $student['s_name'] = $s_name;
            $student['cgpa'] = $cgpa;
            $student['dept_id'] = $dept_id;
            $student['advisor_id'] = $advisor_id;
        } else $errors[] = "Update failed: " . $u->error;
        $u->close();
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Student</title>
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
    <h2>Edit Student #<?=htmlspecialchars($student['s_id'])?></h2>
    <?php if ($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <?php if (!empty($errors)): ?><div class="errors"><ul><?php foreach($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach;?></ul></div><?php endif; ?>

    <form method="post" action="">
      <label>Full Name</label>
      <input type="text" name="s_name" value="<?=htmlspecialchars($student['s_name'])?>" required>

      <label>CGPA</label>
      <input type="number" step="0.01" min="0" max="4" name="cgpa" value="<?=htmlspecialchars($student['cgpa'])?>" required>

      <label>Department</label>
      <select name="dept_id" required>
        <option value="">-- select department --</option>
        <?php foreach($departments as $d): ?>
          <option value="<?=htmlspecialchars($d['dept_id'])?>" <?=($student['dept_id']==$d['dept_id'])?'selected':''?>><?=htmlspecialchars($d['dept_name'])?></option>
        <?php endforeach; ?>
      </select>

      <label>Advisor</label>
      <select name="advisor_id">
        <option value="">-- select advisor (optional) --</option>
        <?php foreach($teachers as $t): ?>
          <option value="<?=htmlspecialchars($t['t_id'])?>" <?=($student['advisor_id']==$t['t_id'])?'selected':''?>><?=htmlspecialchars($t['t_name'])?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="btn">Save Changes</button>
    </form>
    
    <p><a href="students_list.php" class="btn">← Back to List</a></p>
  </main>
</body>
</html>
