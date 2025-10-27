<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('admin');
require_once __DIR__ . '/../../src/db.php';
$res = $mysqli->query("SELECT book_no, book_name, author, edition FROM books ORDER BY book_no");
$books = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Books | Admin Panel</title><link rel="stylesheet" href="../../css/style.css"></head>
<body>
<?php include __DIR__ . '/../../src/admin_nav.php'; ?>
  <main class="container">
    <h2>Books</h2>
    <a href="books_add.php" class="btn">➕ Add Book</a>

    <table class="data-table">
      <thead><tr><th>ID</th><th>Name</th><th>Author</th><th>Edition</th><th>Actions</th></tr></thead>
      <tbody>
        <?php if (empty($books)): ?><tr><td colspan="5">No books found.</td></tr>
        <?php else: foreach($books as $b): ?>
          <tr>
            <td><?=htmlspecialchars($b['book_no'])?></td>
            <td><?=htmlspecialchars($b['book_name'])?></td>
            <td><?=htmlspecialchars($b['author'])?></td>
            <td><?=htmlspecialchars($b['edition'])?></td>
            <td><a href="books_edit.php?id=<?=urlencode($b['book_no'])?>">Edit</a> |
                <a href="books_delete.php?id=<?=urlencode($b['book_no'])?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </main>
</body></html>
