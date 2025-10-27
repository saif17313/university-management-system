<?php
require_once __DIR__ . '/../../src/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Invalid teacher id.");

$stmt = $mysqli->prepare("DELETE FROM teachers WHERE t_id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $stmt->close();
    header("Location: teachers_list.php?deleted=1");
    exit;
} else {
    $err = $stmt->error;
    $stmt->close();
    die("Delete failed: " . htmlspecialchars($err));
}
