<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('admin');
require_once __DIR__ . '/../../src/db.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Reports & Analytics | Admin Panel</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../../src/admin_nav.php'; ?>

  <main class="container">
    <h2>📊 Admin Reports & Analytics</h2>

    <section>
      <h3>1️⃣ Students Per Department</h3>
      <?php
      $res=$mysqli->query("SELECT * FROM view_students_per_dept");
      echo '<table class="data-table"><tr><th>Department</th><th>Total Students</th></tr>';
      while($row=$res->fetch_assoc()){
        echo '<tr><td>'.htmlspecialchars($row['dept_name']).'</td><td>'.$row['total_students'].'</td></tr>';
      }
      echo '</table>';
      ?>
    </section>

    <section>
      <h3>2️⃣ Teachers Per Faculty</h3>
      <?php
      $res=$mysqli->query("SELECT * FROM view_teachers_per_faculty");
      echo '<table class="data-table"><tr><th>Faculty</th><th>Total Teachers</th></tr>';
      while($row=$res->fetch_assoc()){
        echo '<tr><td>'.htmlspecialchars($row['faculty']).'</td><td>'.$row['total_teachers'].'</td></tr>';
      }
      echo '</table>';
      ?>
    </section>

    <section>
      <h3>3️⃣ Teachers Earning Above Average Salary</h3>
      <?php
      $res=$mysqli->query("SELECT * FROM view_high_salary_teachers");
      echo '<table class="data-table"><tr><th>ID</th><th>Name</th><th>Department</th><th>Salary</th></tr>';
      while($row=$res->fetch_assoc()){
        echo '<tr><td>'.$row['t_id'].'</td><td>'.htmlspecialchars($row['t_name']).'</td><td>'.
             htmlspecialchars($row['dept_name']).'</td><td>'.$row['salary'].'</td></tr>';
      }
      echo '</table>';
      ?>
    </section>

    <section>
      <h3>4️⃣ Top Students (CGPA > Dept Average)</h3>
      <?php
      $res=$mysqli->query("SELECT * FROM view_top_students");
      echo '<table class="data-table"><tr><th>ID</th><th>Name</th><th>Department</th><th>CGPA</th></tr>';
      while($row=$res->fetch_assoc()){
        echo '<tr><td>'.$row['s_id'].'</td><td>'.htmlspecialchars($row['s_name']).'</td><td>'.
             htmlspecialchars($row['dept_name']).'</td><td>'.$row['cgpa'].'</td></tr>';
      }
      echo '</table>';
      ?>
    </section>

    <section>
      <h3>5️⃣ Books Per Course</h3>
      <?php
      $res=$mysqli->query("SELECT * FROM view_books_per_course");
      echo '<table class="data-table"><tr><th>Course</th><th>Total Books</th></tr>';
      while($row=$res->fetch_assoc()){
        echo '<tr><td>'.htmlspecialchars($row['course_name']).'</td><td>'.$row['total_books'].'</td></tr>';
      }
      echo '</table>';
      ?>
    </section>
  </main>
</body>
</html>
