<?php
// config/db.php
$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';
$DB_NAME = getenv('DB_NAME') ?: 'blood_registry';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';

try {
  $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4", $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
} catch (PDOException $e) {
  http_response_code(500);
  echo "Database connection failed.";
  exit;
}

session_start();

// Admin helpers
function is_logged_in() { return isset($_SESSION['admin_id']); }
function require_login() {
  if (!is_logged_in()) {
    header("Location: /blood-registry/public/login.php");
    exit;
  }
}

// User helpers
function is_user_logged_in() { return isset($_SESSION['user_id']); }
function require_user_login() {
  if (!is_user_logged_in()) {
    header("Location: /blood-registry/public/user-login.php");
    exit;
  }
}

function e($str) { return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }
?>
