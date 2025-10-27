<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('admin');
// public/admin/departments_delete.php
require_once __DIR__ . '/../../src/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Invalid department id.");
}

// check if department is referenced by teachers or courses
$check = $mysqli->prepare("SELECT 
  (SELECT COUNT(*) FROM teachers WHERE dept_id = ?) +
  (SELECT COUNT(*) FROM courses WHERE d_id = ?) +
  (SELECT COUNT(*) FROM students WHERE dept_id = ?) AS refs");
$check->bind_param("iii", $id, $id, $id);
$check->execute();
$check->bind_result($refs);
$check->fetch();
$check->close();

if ($refs > 0) {
    die("⚠️ Cannot delete: department is referenced by teachers, courses, or students.");
}

// attempt delete
$stmt = $mysqli->prepare("DELETE FROM departments WHERE dept_id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $stmt->close();
    header("Location: departments_list.php?deleted=1");
    exit;
} else {
    $err = $stmt->error;
    $stmt->close();
    die("Delete failed: " . htmlspecialchars($err));
}

