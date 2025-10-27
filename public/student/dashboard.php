<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('student');
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Student Dashboard</title><link rel="stylesheet" href="../../css/style.css"></head>
<body>
<nav class="navbar">
  <a href="../logout.php">Logout</a>
</nav>
<main class="container">
  <h2>Welcome, <?=htmlspecialchars($_SESSION['user']['username'])?></h2>
  <p>Your Student ID: <?=htmlspecialchars($_SESSION['user']['ref_id'])?></p>
  <p>Feature idea: Show your CGPA, department, and advisor using JOIN query.</p>
</main>
</body></html>
