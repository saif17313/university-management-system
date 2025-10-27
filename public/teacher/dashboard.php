<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('teacher');
require_once __DIR__ . '/../../src/db.php';

// Get current teacher ID
$teacher_id = $_SESSION['user']['ref_id'];

// Fetch teacher details with department ID
$t_stmt = $mysqli->prepare("
  SELECT t.t_id, t.t_name, t.salary, t.dept_id, d.dept_name
  FROM teachers t
  LEFT JOIN departments d ON t.dept_id = d.dept_id
  WHERE t.t_id = ?");
$t_stmt->bind_param("i", $teacher_id);
$t_stmt->execute();
$teacher = $t_stmt->get_result()->fetch_assoc();
$t_stmt->close();

$teacher_dept_id = $teacher['dept_id'];

// Fetch advised students
$s_res = $mysqli->prepare("
  SELECT s.s_id, s.s_name, s.cgpa, d.dept_name
  FROM students s
  JOIN departments d ON s.dept_id = d.dept_id
  WHERE s.advisor_id = ?");
$s_res->bind_param("i", $teacher_id);
$s_res->execute();
$students = $s_res->get_result()->fetch_all(MYSQLI_ASSOC);
$s_res->close();

// Calculate average CGPA of advised students
$avg_cgpa = null;
if (!empty($students)) {
    $ids = array_column($students, 'cgpa');
    $avg_cgpa = round(array_sum($ids) / count($ids), 2);
}

// Department Students Filtering & Sorting
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$filter_cgpa = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Build query for department students
$dept_sql = "SELECT s.s_id, s.s_name, s.cgpa, t.t_name AS advisor_name
             FROM students s
             LEFT JOIN teachers t ON s.advisor_id = t.t_id
             WHERE s.dept_id = ?";

// Apply CGPA filter
if ($filter_cgpa == 'high') {
    $dept_sql .= " AND s.cgpa >= 3.5";
} elseif ($filter_cgpa == 'medium') {
    $dept_sql .= " AND s.cgpa >= 3.0 AND s.cgpa < 3.5";
} elseif ($filter_cgpa == 'low') {
    $dept_sql .= " AND s.cgpa < 3.0";
}

// Apply sorting
if ($sort_by == 'cgpa_desc') {
    $dept_sql .= " ORDER BY s.cgpa DESC";
} elseif ($sort_by == 'cgpa_asc') {
    $dept_sql .= " ORDER BY s.cgpa ASC";
} else {
    $dept_sql .= " ORDER BY s.s_name ASC";
}

$dept_stmt = $mysqli->prepare($dept_sql);
$dept_stmt->bind_param("i", $teacher_dept_id);
$dept_stmt->execute();
$dept_students = $dept_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$dept_stmt->close();

// Calculate department statistics
$dept_stats = [];
if (!empty($dept_students)) {
    $cgpas = array_column($dept_students, 'cgpa');
    $dept_stats['total'] = count($dept_students);
    $dept_stats['avg_cgpa'] = round(array_sum($cgpas) / count($cgpas), 2);
    $dept_stats['max_cgpa'] = max($cgpas);
    $dept_stats['min_cgpa'] = min($cgpas);
    $dept_stats['high_performers'] = count(array_filter($cgpas, function($c) { return $c >= 3.5; }));
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Teacher Dashboard</title>
  <link rel="stylesheet" href="../../css/style.css">
  <style>
    .filter-panel {
      background: var(--gray-50);
      padding: 1.5rem;
      border-radius: var(--radius-lg);
      margin: 1.5rem 0;
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      align-items: center;
    }
    .filter-panel label {
      font-weight: 600;
      margin-right: 0.5rem;
    }
    .filter-panel select {
      padding: 0.5rem 1rem;
      border: 2px solid var(--gray-300);
      border-radius: var(--radius-md);
      font-size: 0.95rem;
    }
    .filter-panel button {
      padding: 0.5rem 1.5rem;
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: var(--radius-md);
      cursor: pointer;
      font-weight: 600;
    }
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 1rem;
      margin: 1.5rem 0;
    }
    .stat-box {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
      color: white;
      padding: 1.5rem;
      border-radius: var(--radius-lg);
      text-align: center;
    }
    .stat-number {
      font-size: 2rem;
      font-weight: 700;
      display: block;
      margin-bottom: 0.5rem;
    }
    .stat-label {
      font-size: 0.9rem;
      opacity: 0.9;
    }
  </style>
</head>
<body>
<nav class="navbar">
  <a href="dashboard.php">🏠 Dashboard</a>
  <a href="../logout.php">🚪 Logout</a>
</nav>

<main class="container">
  <h2>👨‍🏫 Teacher Dashboard</h2>

  <div class="dashboard-card">
    <h3>📋 Teacher Information</h3>
    <p><b>Name:</b> <?=htmlspecialchars($teacher['t_name'])?></p>
    <p><b>Department:</b> <?=htmlspecialchars($teacher['dept_name'])?></p>
    <p><b>Salary:</b> $<?=number_format($teacher['salary'])?></p>
  </div>

  <div class="dashboard-card">
    <h3>👥 My Advised Students</h3>
    <?php if (empty($students)): ?>
      <p>No students assigned yet.</p>
    <?php else: ?>
      <table class="data-table">
        <thead><tr><th>ID</th><th>Name</th><th>Department</th><th>CGPA</th></tr></thead>
        <tbody>
          <?php foreach($students as $s): ?>
          <tr>
            <td><?=$s['s_id']?></td>
            <td><?=htmlspecialchars($s['s_name'])?></td>
            <td><?=htmlspecialchars($s['dept_name'])?></td>
            <td><?=$s['cgpa']?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p style="margin-top: 1rem;"><b>Average CGPA of My Students:</b> <span style="color: var(--primary-color); font-size: 1.2rem;"><?=$avg_cgpa?></span></p>
    <?php endif; ?>
  </div>

  <div class="dashboard-card">
    <h3>📊 Department Students Analysis</h3>
    <p style="color: var(--gray-600); margin-bottom: 1rem;">
      View and analyze all students in <b><?=htmlspecialchars($teacher['dept_name'])?></b> department
    </p>

    <?php if (!empty($dept_stats)): ?>
    <div class="stats-grid">
      <div class="stat-box">
        <span class="stat-number"><?=$dept_stats['total']?></span>
        <span class="stat-label">Total Students</span>
      </div>
      <div class="stat-box" style="background: linear-gradient(135deg, var(--success-color), #059669);">
        <span class="stat-number"><?=$dept_stats['avg_cgpa']?></span>
        <span class="stat-label">Average CGPA</span>
      </div>
      <div class="stat-box" style="background: linear-gradient(135deg, var(--accent-color), #d97706);">
        <span class="stat-number"><?=$dept_stats['max_cgpa']?></span>
        <span class="stat-label">Highest CGPA</span>
      </div>
      <div class="stat-box" style="background: linear-gradient(135deg, var(--danger-color), #dc2626);">
        <span class="stat-number"><?=$dept_stats['min_cgpa']?></span>
        <span class="stat-label">Lowest CGPA</span>
      </div>
      <div class="stat-box" style="background: linear-gradient(135deg, var(--secondary-color), #0e7490);">
        <span class="stat-number"><?=$dept_stats['high_performers']?></span>
        <span class="stat-label">High Performers (≥3.5)</span>
      </div>
    </div>
    <?php endif; ?>

    <form method="GET" class="filter-panel">
      <div>
        <label>📌 Filter by CGPA:</label>
        <select name="filter" onchange="this.form.submit()">
          <option value="all" <?=$filter_cgpa=='all'?'selected':''?>>All Students</option>
          <option value="high" <?=$filter_cgpa=='high'?'selected':''?>>High (≥ 3.5)</option>
          <option value="medium" <?=$filter_cgpa=='medium'?'selected':''?>>Medium (3.0 - 3.5)</option>
          <option value="low" <?=$filter_cgpa=='low'?'selected':''?>>Low (< 3.0)</option>
        </select>
      </div>

      <div>
        <label>🔄 Sort by:</label>
        <select name="sort" onchange="this.form.submit()">
          <option value="name" <?=$sort_by=='name'?'selected':''?>>Name (A-Z)</option>
          <option value="cgpa_desc" <?=$sort_by=='cgpa_desc'?'selected':''?>>CGPA (High to Low)</option>
          <option value="cgpa_asc" <?=$sort_by=='cgpa_asc'?'selected':''?>>CGPA (Low to High)</option>
        </select>
      </div>

      <button type="submit">Apply Filters</button>
      <?php if ($filter_cgpa != 'all' || $sort_by != 'name'): ?>
        <a href="dashboard.php" style="padding: 0.5rem 1rem; background: var(--gray-400); color: white; border-radius: var(--radius-md); text-decoration: none;">Reset</a>
      <?php endif; ?>
    </form>

    <?php if (empty($dept_students)): ?>
      <p>No students found with the selected filters.</p>
    <?php else: ?>
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>CGPA</th>
            <th>Advisor</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($dept_students as $ds): ?>
          <tr>
            <td><?=$ds['s_id']?></td>
            <td><?=htmlspecialchars($ds['s_name'])?></td>
            <td>
              <span style="
                padding: 0.25rem 0.75rem;
                border-radius: 1rem;
                font-weight: 600;
                background: <?=$ds['cgpa'] >= 3.5 ? '#d1fae5' : ($ds['cgpa'] >= 3.0 ? '#fef3c7' : '#fee2e2')?>;
                color: <?=$ds['cgpa'] >= 3.5 ? '#065f46' : ($ds['cgpa'] >= 3.0 ? '#92400e' : '#991b1b')?>;
              ">
                <?=$ds['cgpa']?>
              </span>
            </td>
            <td><?=htmlspecialchars($ds['advisor_name'] ?? 'Not Assigned')?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p style="margin-top: 1rem; color: var(--gray-600);">
        <b>Showing <?=count($dept_students)?> student(s)</b>
        <?php if ($filter_cgpa != 'all'): ?>
          with <?=$filter_cgpa?> CGPA
        <?php endif; ?>
      </p>
    <?php endif; ?>
  </div>
</main>
</body>
</html>
