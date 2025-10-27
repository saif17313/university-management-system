<?php
require_once __DIR__ . '/../../src/db.php';
$book_no = isset($_GET['book_no']) ? intval($_GET['book_no']) : 0;
$course_no = isset($_GET['course_no']) ? strtoupper(trim($_GET['course_no'])) : '';
if ($book_no <= 0 || $course_no === '') die("Invalid parameters.");

$stmt = $mysqli->prepare("DELETE FROM book_refs WHERE book_no = ? AND course_no = ?");
$stmt->bind_param("is", $book_no, $course_no);
if ($stmt->execute()) {
    $stmt->close();
    header("Location: bookrefs_list.php?deleted=1");
    exit;
} else {
    $err = $stmt->error; $stmt->close();
    die("Delete failed: " . htmlspecialchars($err));
}
