<?php
// Unified Admin Navigation Bar
// Include this file in all admin pages for consistent navigation
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
?>
<nav class="navbar">
  <a href="dashboard.php">🏠 Dashboard</a>
  <a href="departments_list.php">📁 Departments</a>
  <a href="teachers_list.php">👨‍🏫 Teachers</a>
  <a href="students_list.php">👨‍🎓 Students</a>
  <a href="courses_list.php">📚 Courses</a>
  <a href="books_list.php">📖 Books</a>
  <a href="bookrefs_list.php">🔗 Book References</a>
  <a href="reports.php">📊 Reports</a>
  <a href="../logout.php">🚪 Logout</a>
</nav>
