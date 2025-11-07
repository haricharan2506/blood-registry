<?php
// public/admin-set-password.php  (delete after success)
require_once __DIR__ . '/../config/db.php';

// CHANGE THIS if you want a different admin password:
$plain = 'admin123';

// Create a fresh bcrypt hash on *your* PHP version
$hash = password_hash($plain, PASSWORD_BCRYPT, ['cost' => 10]);

// Ensure the admin row exists, then set the new hash
$pdo->prepare("
  INSERT INTO admins (email, password_hash)
  VALUES ('admin@example.com', :h)
  ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)
")->execute([':h' => $hash]);

// Show what DB we touched and the hash length (should be 60)
$db = $pdo->query('SELECT DATABASE() AS db')->fetch()['db'];
$row = $pdo->prepare("SELECT email, LENGTH(password_hash) AS len FROM admins WHERE email=?");
$row->execute(['admin@example.com']);
$info = $row->fetch();

header('Content-Type: text/plain');
echo "DB: {$db}\n";
echo "Admin reset for: {$info['email']}\n";
echo "Hash length: {$info['len']}\n";
echo "Password is now: {$plain}\n";
