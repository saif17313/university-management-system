<?php
require_once __DIR__ . '/../src/auth.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = $_POST['role'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = "Username and password required.";
    } else {
        if (login($username, $password)) {
            $userRole = $_SESSION['user']['role'];
            if ($userRole === 'admin') header("Location: admin/dashboard.php");
            elseif ($userRole === 'teacher') header("Location: teacher/dashboard.php");
            elseif ($userRole === 'student') header("Location: student/dashboard.php");
            exit;
        } else {
            $errors[] = "Invalid credentials.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | UMS</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($errors)): ?><div class="errors"><ul><?php foreach($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach;?></ul></div><?php endif; ?>
    <form method="post" action="">
      <label>Username</label>
      <input type="text" name="username" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <label>Role</label>
      <select name="role" required>
        <option value="">--Select Role--</option>
        <option value="admin">Admin</option>
        <option value="teacher">Teacher</option>
        <option value="student">Student</option>
      </select>
      <button type="submit" class="btn">Login</button>
    </form>
  </div>
</body>
</html>
