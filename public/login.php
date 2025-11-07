<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = trim($_POST['password'] ?? '');
  $stmt = $pdo->prepare("SELECT * FROM admins WHERE email=? LIMIT 1");
  $stmt->execute([$email]);
  $admin = $stmt->fetch();
  if ($admin && password_verify($password, $admin['password_hash'])) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_email'] = $admin['email'];
    header("Location: /blood-registry/public/dashboard.php");
    exit;
  } else {
    $error = "Invalid credentials.";
  }
}
?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<main class="wrap">
  <h1>Admin Login</h1>
  <?php if ($error): ?><div class="card" style="border-left:4px solid #ef4444"><?php echo e($error); ?></div><?php endif; ?>
  <form class="card form-card" method="post" novalidate>
    <label class="label">Email</label>
    <input class="input" type="email" name="email" required>
    <label class="label">Password</label>
    <input class="input" type="password" name="password" required>
    <div style="margin-top:12px">
      <button class="btn" type="submit">Login</button>
    </div>
  </form>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
