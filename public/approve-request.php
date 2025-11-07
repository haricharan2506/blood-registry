<?php require_once __DIR__ . '/../config/db.php'; require_login(); ?>
<?php
$id = (int)($_GET['id'] ?? 0);
$pdo->prepare("UPDATE requests SET status='FULFILLED' WHERE id=?")->execute([$id]);
header("Location: /blood-registry/public/requests.php"); exit;
