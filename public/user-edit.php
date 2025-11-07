<?php require_once __DIR__ . '/../config/db.php'; require_user_login(); ?>
<?php
$uid = $_SESSION['user_id'];
$st = $pdo->prepare("SELECT * FROM users WHERE id=?"); $st->execute([$uid]); $user = $st->fetch();
$errors=[]; $done=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']??'');
  $phone=trim($_POST['phone']??'');
  $city=trim($_POST['city']??'');
  $group=trim($_POST['group']??'');
  if(!$name||!$phone||!$city||!$group) $errors[]='All fields are required.';
  if(!$errors){
    $pdo->prepare("UPDATE users SET name=?, phone=?, city=?, group_name=? WHERE id=?")->execute([$name,$phone,$city,$group,$uid]);
    $done=true; $st->execute([$uid]); $user=$st->fetch();
  }
}
?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<main class="wrap">
  <h1>Edit Profile</h1>
  <?php if($done): ?><div class="card" style="border-left:4px solid #22c55e"><p>Profile updated.</p></div><?php endif; ?>
  <?php if($errors): ?><div class="card" style="border-left:4px solid #ef4444"><?php foreach($errors as $e) echo "<p>".e($e)."</p>"; ?></div><?php endif; ?>
  <form class="card form-card" method="post">
    <div class="grid">
      <div><label class="label">Full Name</label><input class="input" name="name" value="<?php echo e($user['name']); ?>" required></div>
      <div><label class="label">Phone</label><input class="input" name="phone" value="<?php echo e($user['phone']); ?>" required></div>
      <div><label class="label">City</label><input class="input" name="city" value="<?php echo e($user['city']); ?>" required></div>
      <div>
        <label class="label">Blood Group</label>
        <select class="input select" name="group" required>
          <?php foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $g): ?>
            <option value="<?php echo $g; ?>" <?php echo $user['group_name']===$g?'selected':''; ?>><?php echo $g; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div style="margin-top:12px"><button class="btn" type="submit">Save Changes</button></div>
  </form>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
