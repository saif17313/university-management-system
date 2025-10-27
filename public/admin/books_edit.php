<?php
require_once __DIR__ . '/../../src/db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Invalid book id.");

$stmt = $mysqli->prepare("SELECT * FROM books WHERE book_no = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$book = $res->fetch_assoc();
$stmt->close();
if (!$book) die("Book not found.");

$errors = []; $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_name = trim($_POST['book_name'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $edition = isset($_POST['edition']) ? intval($_POST['edition']) : null;

    if ($book_name === '') $errors[] = "Book name required.";
    if ($edition !== null && $edition < 0) $errors[] = "Edition must be non-negative.";

    if (empty($errors)) {
        $u = $mysqli->prepare("UPDATE books SET book_name = ?, author = ?, edition = ? WHERE book_no = ?");
        $u->bind_param("ssii", $book_name, $author, $edition, $id);
        if ($u->execute()) { $success = "Book updated."; $book['book_name']=$book_name; $book['author']=$author; $book['edition']=$edition; }
        else $errors[] = "Update failed: " . $u->error;
        $u->close();
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Edit Book</title><link rel="stylesheet" href="../../css/style.css"></head>
<body>
  <nav><a href="books_list.php">Back to list</a></nav>
  <main class="container">
    <h2>Edit Book #<?=htmlspecialchars($book['book_no'])?></h2>
    <?php if ($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <?php if (!empty($errors)): ?><div class="errors"><ul><?php foreach($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach;?></ul></div><?php endif; ?>

    <form method="post" action="">
      <label>Book Name</label>
      <input type="text" name="book_name" value="<?=htmlspecialchars($book['book_name'])?>" required>
      <label>Author</label>
      <input type="text" name="author" value="<?=htmlspecialchars($book['author'])?>">
      <label>Edition</label>
      <input type="number" name="edition" min="0" value="<?=htmlspecialchars($book['edition'])?>">
      <button class="btn" type="submit">Save</button>
    </form>
  </main>
</body></html>
