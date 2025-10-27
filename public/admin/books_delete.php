<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('admin');
require_once __DIR__ . '/../../src/db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Invalid book id.");

// check if book is referenced in book_refs
$check = $mysqli->prepare("SELECT COUNT(*) FROM book_refs WHERE book_no = ?");
$check->bind_param("i", $id);
$check->execute();
$check->bind_result($refs);
$check->fetch();
$check->close();

if ($refs > 0) {
    die("⚠️ Cannot delete: book is referenced by $refs course(s).");
}

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

