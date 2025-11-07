<?php require_once __DIR__ . '/../config/db.php'; require_login(); ?>
<?php
$id = (int)($_GET['id'] ?? 0);
$donor = $pdo->prepare("SELECT * FROM donors WHERE id=?");
$donor->execute([$id]);
$donor = $donor->fetch();
if (!$donor){ http_response_code(404); echo "Not found"; exit; }

$errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST'){
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $city = trim($_POST['city'] ?? '');
  $group = trim($_POST['group'] ?? '');
  $last_donated = $_POST['last_donated'] ?? null;
  if(!$name||!$email||!$phone||!$city||!$group) $errors[]='All fields are required.';
  if(!$errors){
    $pdo->prepare("UPDATE donors SET name=?, email=?, phone=?, city=?, group_name=?, last_donated=? WHERE id=?")->execute([$name,$email,$phone,$city,$group,$last_donated?:null,$id]);
    header("Location: /blood-registry/public/donors.php"); exit;
  }
}
?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<main class="wrap">
  <h1>Edit Donor</h1>
  <?php if ($errors): ?><div class="card" style="border-left:4px solid #ef4444"><?php foreach ($errors as $e) echo "<p>".e($e)."</p>"; ?></div><?php endif; ?>
  <form class="card form-card" method="post">
    <div class="grid">
      <div><label class="label">Name</label><input class="input" name="name" value="<?php echo e($donor['name']); ?>" required></div>
      <div><label class="label">Email</label><input class="input" type="email" name="email" value="<?php echo e($donor['email']); ?>" required></div>
      <div><label class="label">Phone</label><input class="input" name="phone" value="<?php echo e($donor['phone']); ?>" required></div>
      <div><label class="label">City</label><input class="input" name="city" value="<?php echo e($donor['city']); ?>" required></div>
      <div>
        <label class="label">Group</label>
        <select class="input select" name="group" required>
          <?php foreach (['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $g): ?>
            <option value="<?php echo $g; ?>" <?php echo $donor['group_name']===$g?'selected':''; ?>><?php echo $g; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div><label class="label">Last Donated</label><input class="input" type="date" name="last_donated" value="<?php echo e($donor['last_donated']); ?>"></div>
    </div>
    <div style="margin-top:12px"><button class="btn" type="submit">Update</button></div>
  </form>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
