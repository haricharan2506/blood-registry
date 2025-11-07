<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$errors=[]; $done=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']??'');
  $email=trim($_POST['email']??'');
  $phone=trim($_POST['phone']??'');
  $city=trim($_POST['city']??'');
  $group=trim($_POST['group']??'');
  $password=trim($_POST['password']??'');
  $confirm=trim($_POST['confirm']??'');

  if(!$name||!$email||!$phone||!$city||!$group||!$password||!$confirm) $errors[]='All fields are required.';
  if($password!==$confirm) $errors[]='Passwords do not match.';

  if(!$errors){
    // check unique email
    $st=$pdo->prepare("SELECT id FROM users WHERE email=? LIMIT 1"); $st->execute([$email]);
    if($st->fetch()){ $errors[]='Email already registered.'; }
  }

  if(!$errors){
    $hash=password_hash($password, PASSWORD_BCRYPT);
    $pdo->prepare("INSERT INTO users(name,email,password_hash,phone,city,group_name,created_at) VALUES(?,?,?,?,?,?,NOW())")
        ->execute([$name,$email,$hash,$phone,$city,$group]);
    $done=true;
  }
}
?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<main class="wrap">
  <h1>Create Your Account</h1>
  <?php if($done): ?>
    <div class="card" style="border-left:4px solid #22c55e">
      <p>Account created! You can now <a class="btn" href="/blood-registry/public/user-login.php">Log in</a>.</p>
    </div>
  <?php endif; ?>
  <?php if($errors): ?><div class="card" style="border-left:4px solid #ef4444"><?php foreach($errors as $e) echo "<p>".e($e)."</p>"; ?></div><?php endif; ?>

  <form class="card form-card" method="post" novalidate>
    <div class="grid">
      <div><label class="label">Full Name *</label><input class="input" name="name" required></div>
      <div><label class="label">Email *</label><input class="input" type="email" name="email" required></div>
      <div><label class="label">Phone *</label><input class="input" name="phone" required></div>
      <div><label class="label">City *</label><input class="input" name="city" required></div>
      <div>
        <label class="label">Blood Group *</label>
        <select class="input select" name="group" required>
          <option value="">Select group</option>
          <?php foreach (['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $g): ?>
            <option value="<?php echo $g; ?>"><?php echo $g; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div><label class="label">Password *</label><input class="input" type="password" name="password" required></div>
      <div><label class="label">Confirm Password *</label><input class="input" type="password" name="confirm" required></div>
    </div>
    <div style="margin-top:12px"><button class="btn" type="submit">Sign Up</button></div>
  </form>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
