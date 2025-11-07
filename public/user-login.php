<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email=trim($_POST['email']??'');
  $password=trim($_POST['password']??'');
  $st=$pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1"); $st->execute([$email]);
  $u=$st->fetch();
  if($u && password_verify($password, $u['password_hash'])){
    $_SESSION['user_id']=$u['id'];
    $_SESSION['user_email']=$u['email'];
    $_SESSION['user_name']=$u['name'];
    header("Location: /blood-registry/public/user-dashboard.php"); exit;
  }else{$error='Invalid credentials.';}
}
?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<main class="wrap">
  <h1>User Login</h1>
  <?php if($error): ?><div class="card" style="border-left:4px solid #ef4444"><?php echo e($error); ?></div><?php endif; ?>
  <form class="card form-card" method="post" novalidate>
    <label class="label">Email</label>
    <input class="input" type="email" name="email" required>
    <label class="label">Password</label>
    <input class="input" type="password" name="password" required>
    <div style="margin-top:12px"><button class="btn" type="submit">Login</button></div>
    <p class="sm" style="margin-top:8px">No account? <a href="/blood-registry/public/user-register.php">Create one</a>.</p>
  </form>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
