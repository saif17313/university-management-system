<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('admin');
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Admin Dashboard</title><link rel="stylesheet" href="../../css/style.css"></head>
<body>
<nav class="navbar">
  <a href="departments_list.php">Departments</a>
  <a href="teachers_list.php">Teachers</a>
  <a href="courses_list.php">Courses</a>
  <a href="books_list.php">Books</a>
  <a href="students_list.php">Students</a>
  <a href="../logout.php">Logout</a>
</nav>
<main class="container">
  <h2>Welcome, <?=htmlspecialchars($_SESSION['user']['username'])?></h2>
  <p>You have full control over the university database.</p>
</main>
</body></html>
