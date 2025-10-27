<?php
require_once __DIR__ . '/../../src/db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Invalid book id.");

$stmt = $mysqli->prepare("DELETE FROM books WHERE book_no = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $stmt->close();
    header("Location: books_list.php?deleted=1");
    exit;
} else {
    $err = $stmt->error; $stmt->close();
    die("Delete failed: " . htmlspecialchars($err));
}
