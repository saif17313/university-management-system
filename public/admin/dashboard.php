<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('admin');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard | University Management System</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../../src/admin_nav.php'; ?>

<main class="container">
  <h2>👨‍💼 Admin Dashboard</h2>
  <p style="font-size: 1.1rem; color: #4b5563; margin-bottom: 2rem;">
    Welcome, <strong><?=htmlspecialchars($_SESSION['user']['username'])?></strong>! 
    You have full control over the university database.
  </p>

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
    
    <div class="dashboard-card">
      <h3>📁 Departments</h3>
      <p>Manage university departments and faculties</p>
      <a href="departments_list.php" class="btn" style="margin-top: 1rem;">View Departments</a>
    </div>

    <div class="dashboard-card">
      <h3>👨‍🏫 Teachers</h3>
      <p>Manage teacher profiles and assignments</p>
      <a href="teachers_list.php" class="btn" style="margin-top: 1rem;">View Teachers</a>
    </div>

    <div class="dashboard-card">
      <h3>👨‍🎓 Students</h3>
      <p>Manage student records and advisors</p>
      <a href="students_list.php" class="btn" style="margin-top: 1rem;">View Students</a>
    </div>

    <div class="dashboard-card">
      <h3>📚 Courses</h3>
      <p>Manage course catalog and credits</p>
      <a href="courses_list.php" class="btn" style="margin-top: 1rem;">View Courses</a>
    </div>

    <div class="dashboard-card">
      <h3>📖 Books</h3>
      <p>Manage library books and references</p>
      <a href="books_list.php" class="btn" style="margin-top: 1rem;">View Books</a>
    </div>

    <div class="dashboard-card">
      <h3>🔗 Book References</h3>
      <p>Link books to courses</p>
      <a href="bookrefs_list.php" class="btn" style="margin-top: 1rem;">View References</a>
    </div>

    <div class="dashboard-card">
      <h3>📊 Reports</h3>
      <p>View analytics and insights</p>
      <a href="reports.php" class="btn" style="margin-top: 1rem;">View Reports</a>
    </div>

  </div>
</main>
</body>
</html>
