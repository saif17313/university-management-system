<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | University Management System</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form method="POST" action="#">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <label for="role">Select Role</label>
      <select id="role" name="role" required>
        <option value="admin">Admin</option>
        <option value="teacher">Teacher</option>
        <option value="student">Student</option>
      </select>

      <button type="submit" class="btn">Login</button>
    </form>
  </div>
</body>
</html>
