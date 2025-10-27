<?php
require_once __DIR__ . '/../../src/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Invalid teacher id.");

// fetch departments
$depsRes = $mysqli->query("SELECT dept_id, dept_name FROM departments ORDER BY dept_name");
$departments = $depsRes ? $depsRes->fetch_all(MYSQLI_ASSOC) : [];

// fetch teacher
$stmt = $mysqli->prepare("SELECT * FROM teachers WHERE t_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$teacher = $res->fetch_assoc();
$stmt->close();
if (!$teacher) die("Teacher not found.");

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $t_name = trim($_POST['t_name'] ?? '');
    $gender = $_POST['gender'] ?? 'Male';
    $salary = $_POST['salary'] !== '' ? floatval($_POST['salary']) : null;
    $dept_id = isset($_POST['dept_id']) && $_POST['dept_id'] !== '' ? intval($_POST['dept_id']) : null;

    if ($t_name === '') $errors[] = "Teacher name is required.";
    if ($salary === null || $salary < 0) $errors[] = "Salary must be a non-negative number.";

    if (empty($errors)) {
        $u = $mysqli->prepare("UPDATE teachers SET t_name = ?, gender = ?, salary = ?, dept_id = ? WHERE t_id = ?");
        $u->bind_param("ssdii", $t_name, $gender, $salary, $dept_id, $id);
        if ($u->execute()) {
            $success = "Teacher updated successfully.";
            $teacher['t_name'] = $t_name;
            $teacher['gender'] = $gender;
            $teacher['salary'] = $salary;
            $teacher['dept_id'] = $dept_id;
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
  <title>Edit Teacher</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
  <nav><a href="teachers_list.php">Back to list</a></nav>
  <main class="container">
    <h2>Edit Teacher #<?=htmlspecialchars($teacher['t_id'])?></h2>

    <?php if ($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <?php if (!empty($errors)): ?><div class="errors"><ul><?php foreach ($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach; ?></ul></div><?php endif; ?>

    <form method="post" action="">
      <label>Full Name</label>
      <input type="text" name="t_name" value="<?=htmlspecialchars($teacher['t_name'])?>" required>

      <label>Gender</label>
      <select name="gender">
        <option value="Male" <?=($teacher['gender']==='Male') ? 'selected' : ''?>>Male</option>
        <option value="Female" <?=($teacher['gender']==='Female') ? 'selected' : ''?>>Female</option>
      </select>

      <label>Salary</label>
      <input type="number" step="0.01" min="0" name="salary" value="<?=htmlspecialchars($teacher['salary'])?>" required>

      <label>Department</label>
      <select name="dept_id">
        <option value="">-- Select department --</option>
        <?php foreach ($departments as $d): ?>
          <option value="<?=htmlspecialchars($d['dept_id'])?>" <?=($teacher['dept_id']==$d['dept_id']) ? 'selected' : ''?>><?=htmlspecialchars($d['dept_name'])?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="btn">Save Changes</button>
    </form>
  </main>
</body>
</html>
