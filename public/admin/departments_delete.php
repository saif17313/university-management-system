<?php
// public/admin/departments_delete.php
require_once __DIR__ . '/../../src/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Invalid department id.");
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
