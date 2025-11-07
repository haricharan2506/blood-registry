<?php require_once __DIR__ . '/../config/db.php'; require_login(); ?>
<?php
$id = (int)($_GET['id'] ?? 0);
$pdo->prepare("DELETE FROM donors WHERE id=?")->execute([$id]);
header("Location: /blood-registry/public/donors.php"); exit;
