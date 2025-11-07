<?php
// public/admin-self-test.php
require_once __DIR__ . '/../config/db.php';

$out = [];

// 1) Which DB are we actually using?
try {
  $db = $pdo->query("SELECT DATABASE() AS db")->fetch()['db'] ?? null;
  $out['database_in_use'] = $db;
} catch (Throwable $e) {
  $out['database_in_use_error'] = $e->getMessage();
}

// 2) Ensure admins table exists (self-heal)
try {
  $pdo->exec("
    CREATE TABLE IF NOT EXISTS admins (
      id INT AUTO_INCREMENT PRIMARY KEY,
      email VARCHAR(190) UNIQUE NOT NULL,
      password_hash VARCHAR(255) NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
  ");
  $out['admins_table_exists'] = true;
} catch (Throwable $e) {
  $out['admins_table_exists'] = false;
  $out['admins_table_error'] = $e->getMessage();
}

// 3) Upsert the known admin (password = admin123)
try {
  $hash = '$2y$10$y1jfqEim2z2y1yG1o6GkOeS3v0oA3qzJ2Yf0pQY1lRxX7oY7d4e9C'; // admin123
  $stmt = $pdo->prepare("
    INSERT INTO admins (email, password_hash)
    VALUES ('admin@example.com', ?)
    ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)
  ");
  $stmt->execute([$hash]);
  $out['admin_row_upserted'] = true;
} catch (Throwable $e) {
  $out['admin_row_upserted'] = false;
  $out['admin_row_error'] = $e->getMessage();
}

// 4) Read it back & verify
try {
  $st = $pdo->prepare("SELECT * FROM admins WHERE email=? LIMIT 1");
  $st->execute(['admin@example.com']);
  $row = $st->fetch();
  $out['admin_found'] = !!$row;
  $out['stored_email'] = $row['email'] ?? null;
  $out['hash_len'] = isset($row['password_hash']) ? strlen($row['password_hash']) : null;
  $out['verify_admin123'] = $row ? password_verify('admin123', $row['password_hash']) : null;
} catch (Throwable $e) {
  $out['verify_error'] = $e->getMessage();
}

// 5) Show result
header('Content-Type: application/json');
echo json_encode($out, JSON_PRETTY_PRINT);
