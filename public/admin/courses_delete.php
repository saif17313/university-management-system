<?php
require_once __DIR__ . '/../../src/db.php';
$code = isset($_GET['code']) ? strtoupper(trim($_GET['code'])) : '';
if ($code === '') die("Invalid course code.");

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
