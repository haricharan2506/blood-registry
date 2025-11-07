<?php require_once __DIR__ . '/../config/db.php'; unset($_SESSION['user_id'], $_SESSION['user_email'], $_SESSION['user_name']); header("Location: /blood-registry/public/"); ?>
