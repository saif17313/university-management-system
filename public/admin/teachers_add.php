<?php
require_once __DIR__ . '/../../src/db.php';

$errors = [];
$success = '';
// fetch departments for dropdown
$depsRes = $mysqli->query("SELECT dept_id, dept_name FROM departments ORDER BY dept_name");
$departments = $depsRes ? $depsRes->fetch_all(MYSQLI_ASSOC) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $t_name = trim($_POST['t_name'] ?? '');
    $gender = $_POST['gender'] ?? 'Male';
    $salary = $_POST['salary'] !== '' ? floatval($_POST['salary']) : null;
    $dept_id = isset($_POST['dept_id']) && $_POST['dept_id'] !== '' ? intval($_POST['dept_id']) : null;

    if ($t_name === '') $errors[] = "Teacher name is required.";
    if ($salary === null || $salary < 0) $errors[] = "Salary must be a non-negative number.";

    if (empty($errors)) {
        $stmt = $mysqli->prepare("INSERT INTO teachers (t_name, gender, salary, dept_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $t_name, $gender, $salary, $dept_id);
        if ($stmt->execute()) {
            $success = "Teacher added successfully.";
            // clear fields
            $t_name = '';
            $gender = 'Male';
            $salary = '';
            $dept_id = '';
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
  <title>Add Teacher</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
  <nav><a href="../index.php">Home</a> | <a href="teachers_list.php">Teachers List</a></nav>
  <main class="container">
    <h2>Add Teacher</h2>

    <?php if ($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <?php if (!empty($errors)): ?><div class="errors"><ul><?php foreach ($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach; ?></ul></div><?php endif; ?>

    <form method="post" action="">
      <label>Full Name</label>
      <input type="text" name="t_name" value="<?=htmlspecialchars($t_name ?? '')?>" required>

      <label>Gender</label>
      <select name="gender">
        <option value="Male" <?=isset($gender) && $gender==='Male' ? 'selected' : ''?>>Male</option>
        <option value="Female" <?=isset($gender) && $gender==='Female' ? 'selected' : ''?>>Female</option>
      </select>

      <label>Salary</label>
      <input type="number" step="0.01" min="0" name="salary" value="<?=htmlspecialchars($salary ?? '')?>" required>

      <label>Department</label>
      <select name="dept_id">
        <option value="">-- Select department --</option>
        <?php foreach ($departments as $d): ?>
          <option value="<?=htmlspecialchars($d['dept_id'])?>" <?=isset($dept_id) && $dept_id===$d['dept_id'] ? 'selected' : ''?>><?=htmlspecialchars($d['dept_name'])?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="btn">Add Teacher</button>
    </form>
  </main>
</body>
</html>
