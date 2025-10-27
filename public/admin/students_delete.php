<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('admin');
require_once __DIR__ . '/../../src/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Invalid student id.");

$stmt = $mysqli->prepare("DELETE FROM students WHERE s_id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $stmt->close();
    header("Location: students_list.php?deleted=1");
    exit;
} else {
    $err = $stmt->error;
    $stmt->close();
    die("Delete failed: " . htmlspecialchars($err));
}
