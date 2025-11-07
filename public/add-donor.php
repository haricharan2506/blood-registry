<?php require_once __DIR__ . '/../config/db.php'; require_login(); ?>
<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD']==='POST'){
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $city = trim($_POST['city'] ?? '');
  $group = trim($_POST['group'] ?? '');
  if(!$name||!$email||!$phone||!$city||!$group) $errors[]='All fields are required.';
  if(!$errors){
    $pdo->prepare("INSERT INTO donors(name,email,phone,city,group_name,created_at) VALUES(?,?,?,?,?,NOW())")->execute([$name,$email,$phone,$city,$group]);
    header("Location: /blood-registry/public/donors.php"); exit;
  }
}
?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<main class="wrap">
  <h1>Add Donor</h1>
  <?php if ($errors): ?><div class="card" style="border-left:4px solid #ef4444"><?php foreach ($errors as $e) echo "<p>".e($e)."</p>"; ?></div><?php endif; ?>
  <form class="card form-card" method="post">
    <div class="grid">
      <div><label class="label">Name</label><input class="input" name="name" required></div>
      <div><label class="label">Email</label><input class="input" type="email" name="email" required></div>
      <div><label class="label">Phone</label><input class="input" name="phone" required></div>
      <div><label class="label">City</label><input class="input" name="city" required></div>
      <div>
        <label class="label">Group</label>
        <select class="input select" name="group" required>
          <?php foreach (['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $g): ?>
            <option value="<?php echo $g; ?>"><?php echo $g; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div style="margin-top:12px"><button class="btn" type="submit">Save</button></div>
  </form>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
