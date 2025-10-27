<?php
require_once __DIR__ . '/../../src/db.php';
$errors = []; $success = '';

// fetch books and courses for selects
$booksRes = $mysqli->query("SELECT book_no, book_name FROM books ORDER BY book_name");
$books = $booksRes ? $booksRes->fetch_all(MYSQLI_ASSOC) : [];
$coursesRes = $mysqli->query("SELECT course_no, course_name FROM courses ORDER BY course_no");
$courses = $coursesRes ? $coursesRes->fetch_all(MYSQLI_ASSOC) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_no = isset($_POST['book_no']) ? intval($_POST['book_no']) : 0;
    $course_no = isset($_POST['course_no']) ? strtoupper(trim($_POST['course_no'])) : '';

    if ($book_no <= 0) $errors[] = "Select a book.";
    if ($course_no === '') $errors[] = "Select a course.";

    if (empty($errors)) {
        $stmt = $mysqli->prepare("INSERT INTO book_refs (book_no, course_no) VALUES (?, ?)");
        $stmt->bind_param("is", $book_no, $course_no);
        if ($stmt->execute()) { $success = "Book linked to course."; }
        else {
            if (strpos($stmt->error, 'Duplicate') !== false) $errors[] = "This book is already linked to the course.";
            else $errors[] = "Insert failed: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Link Book to Course</title><link rel="stylesheet" href="../../css/style.css"></head>
<body>
  <nav class="navbar">
    <a href="../index.php">🏠 Home</a>
    <a href="departments_list.php">Departments</a>
    <a href="teachers_list.php">Teachers</a>
    <a href="courses_list.php">Courses</a>
    <a href="books_list.php">Books</a>
    <a href="students_list.php">Students</a>
  </nav>
  <main class="container">
    <h2>Link Book to Course</h2>
    <?php if ($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <?php if (!empty($errors)): ?><div class="errors"><ul><?php foreach($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach;?></ul></div><?php endif; ?>

    <form method="post" action="">
      <label>Book</label>
      <select name="book_no">
        <option value="">-- select a book --</option>
        <?php foreach($books as $b): ?>
          <option value="<?=htmlspecialchars($b['book_no'])?>"><?=htmlspecialchars($b['book_name'])?></option>
        <?php endforeach; ?>
      </select>

      <label>Course</label>
      <select name="course_no">
        <option value="">-- select a course --</option>
        <?php foreach($courses as $c): ?>
          <option value="<?=htmlspecialchars($c['course_no'])?>"><?=htmlspecialchars($c['course_no'] . ' — ' . $c['course_name'])?></option>
        <?php endforeach; ?>
      </select>

      <button class="btn" type="submit">Link</button>
    </form>
    
    <p><a href="bookrefs_list.php" class="btn">← Back to List</a></p>
  </main>
</body></html>
