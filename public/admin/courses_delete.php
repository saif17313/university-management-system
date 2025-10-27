<?php
require_once __DIR__ . '/../../src/db.php';
$code = isset($_GET['code']) ? strtoupper(trim($_GET['code'])) : '';
if ($code === '') die("Invalid course code.");

// check if course is referenced in book_refs
$check = $mysqli->prepare("SELECT COUNT(*) FROM book_refs WHERE course_no = ?");
$check->bind_param("s", $code);
$check->execute();
$check->bind_result($refs);
$check->fetch();
$check->close();

if ($refs > 0) {
    die("⚠️ Cannot delete: course is referenced by $refs book reference(s).");
}

$stmt = $mysqli->prepare("DELETE FROM courses WHERE course_no = ?");
$stmt->bind_param("s", $code);
if ($stmt->execute()) {
    $stmt->close();
    header("Location: courses_list.php?deleted=1");
    exit;
} else {
    $err = $stmt->error; $stmt->close();
    die("Delete failed: " . htmlspecialchars($err));
}

