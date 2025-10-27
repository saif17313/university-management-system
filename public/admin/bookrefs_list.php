<?php
require_once __DIR__ . '/../../src/auth.php';
require_login('admin');
require_once __DIR__ . '/../../src/db.php';
$sql = "SELECT br.book_no, b.book_name, br.course_no, c.course_name
        FROM book_refs br
        JOIN books b ON br.book_no = b.book_no
        JOIN courses c ON br.course_no = c.course_no
        ORDER BY br.book_no";
$res = $mysqli->query($sql);
$refs = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Book References | Admin Panel</title><link rel="stylesheet" href="../../css/style.css"></head>
<body>
<?php include __DIR__ . '/../../src/admin_nav.php'; ?>
  <main class="container">
    <h2>Book References</h2>
    <a href="bookrefs_add.php" class="btn">➕ Add Link</a>

    <table class="data-table">
      <thead><tr><th>Book ID</th><th>Book Name</th><th>Course Code</th><th>Course Name</th><th>Action</th></tr></thead>
      <tbody>
        <?php if (empty($refs)): ?><tr><td colspan="5">No links found.</td></tr>
        <?php else: foreach($refs as $r): ?>
          <tr>
            <td><?=htmlspecialchars($r['book_no'])?></td>
            <td><?=htmlspecialchars($r['book_name'])?></td>
            <td><?=htmlspecialchars($r['course_no'])?></td>
            <td><?=htmlspecialchars($r['course_name'])?></td>
            <td><a href="bookrefs_delete.php?book_no=<?=urlencode($r['book_no'])?>&course_no=<?=urlencode($r['course_no'])?>" class="delete-btn" onclick="return confirm('Are you sure you want to remove this link?')">Remove</a></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </main>
</body></html>
