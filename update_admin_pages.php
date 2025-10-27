<?php
// Script to add authentication and unified navigation to all admin pages
$adminDir = __DIR__ . '/public/admin/';

$files = [
    'departments_add.php', 'departments_edit.php', 'departments_delete.php',
    'teachers_add.php', 'teachers_edit.php', 'teachers_delete.php',
    'students_add.php', 'students_edit.php', 'students_delete.php',
    'courses_add.php', 'courses_edit.php', 'courses_delete.php',
    'books_add.php', 'books_edit.php', 'books_delete.php',
    'bookrefs_add.php', 'bookrefs_delete.php'
];

foreach ($files as $file) {
    $filePath = $adminDir . $file;
    if (!file_exists($filePath)) {
        echo "Skipping $file (not found at $filePath)\n";
        continue;
    }
    
    $content = file_get_contents($filePath);
    
    // Check if already has auth
    if (strpos($content, "require_login('admin')") !== false) {
        echo "✓ $file already has authentication\n";
        continue;
    }
    
    // Add authentication after first <?php
    if (preg_match('/^<\?php\s*\n/', $content)) {
        $content = preg_replace(
            '/^<\?php\s*\n/',
            "<?php\nrequire_once __DIR__ . '/../../src/auth.php';\nrequire_login('admin');\n",
            $content
        );
    }
    
    // Replace old navbar with unified nav include
    if (strpos($content, '<nav class="navbar">') !== false && strpos($content, 'admin_nav.php') === false) {
        // Remove old navbar
        $content = preg_replace(
            '/<nav class="navbar">.*?<\/nav>/s',
            '<?php include __DIR__ . \'/../../src/admin_nav.php\'; ?>',
            $content
        );
    }
    
    file_put_contents($filePath, $content);
    echo "✅ Updated $file\n";
}

echo "\nAll files updated!\n";
