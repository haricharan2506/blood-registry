<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $city = trim($_POST['city'] ?? '');
  $group = trim($_POST['group'] ?? '');
  $last_donated = $_POST['last_donated'] ?? null;
  if (!$name || !$email || !$phone || !$city || !$group) $errors[] = "All fields are required.";

  if (!$errors) {
    $stmt = $pdo->prepare("INSERT INTO donors(name,email,phone,city,group_name,last_donated,created_at) VALUES(?,?,?,?,?,?,NOW())");
    $stmt->execute([$name,$email,$phone,$city,$group,$last_donated ?: null]);
    header("Location: /blood-registry/public/thanks.php?name=" . urlencode($name));
    exit;
  }
}
?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<main class="wrap">
  <h1>Become a Donor</h1>
  <p class="sm">Fill the form below to join the registry.</p>

  <?php if ($errors): ?>
    <div class="card" style="border-left:4px solid #ef4444;margin:12px 0;">
      <?php foreach ($errors as $e) echo "<p>".e($e)."</p>"; ?>
    </div>
  <?php endif; ?>

  <form class="card form-card" method="post" novalidate>
    <div class="grid">
      <div>
        <label class="label">Full Name *</label>
        <input class="input" name="name" required>
      </div>
      <div>
        <label class="label">Email *</label>
        <input class="input" type="email" name="email" required>
      </div>
      <div>
        <label class="label">Phone *</label>
        <input class="input" name="phone" required>
      </div>
      <div>
        <label class="label">City *</label>
        <input class="input" name="city" required>
      </div>
      <div>
        <label class="label">Blood Group *</label>
        <select name="group" class="input select" required>
          <option value="">Select group</option>
          <?php foreach (['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $g): ?>
            <option value="<?php echo $g; ?>"><?php echo $g; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="label">Last Donated (optional)</label>
        <input class="input" type="date" name="last_donated">
      </div>
    </div>
    <div style="margin-top:14px">
      <button class="btn" type="submit">Submit</button>
    </div>
  </form>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
