<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$errors = [];
$done = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $patient = trim($_POST['patient'] ?? '');
  $hospital = trim($_POST['hospital'] ?? '');
  $city = trim($_POST['city'] ?? '');
  $group = trim($_POST['group'] ?? '');
  $units = (int)($_POST['units'] ?? 0);
  $contact = trim($_POST['contact'] ?? '');
  $uid = is_user_logged_in() ? $_SESSION['user_id'] : null;

  if (!$patient || !$hospital || !$city || !$group || !$units || !$contact) $errors[] = "All fields are required.";
  if (!$errors) {
    $stmt = $pdo->prepare("INSERT INTO requests(patient,hospital,city,group_name,units,contact,user_id,status,created_at) VALUES(?,?,?,?,?,?,?, 'OPEN', NOW())");
    $stmt->execute([$patient,$hospital,$city,$group,$units,$contact,$uid]);
    $done = true;
  }
}
?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<main class="wrap">
  <h1>Request Blood</h1>
  <?php if ($done): ?>
    <div class="card" style="border-left:4px solid #22c55e">
      <p>Request posted! <?php echo is_user_logged_in() ? 'You can track it in your dashboard.' : 'Consider creating an account to track your requests.'; ?></p>
    </div>
  <?php endif; ?>

  <?php if ($errors): ?>
    <div class="card" style="border-left:4px solid #ef4444"><?php foreach ($errors as $e) echo "<p>".e($e)."</p>"; ?></div>
  <?php endif; ?>

  <form class="card form-card" method="post" novalidate>
    <div class="grid">
      <div>
        <label class="label">Patient Name *</label>
        <input class="input" name="patient" required>
      </div>
      <div>
        <label class="label">Hospital *</label>
        <input class="input" name="hospital" required>
      </div>
      <div>
        <label class="label">City *</label>
        <input class="input" name="city" required>
      </div>
      <div>
        <label class="label">Blood Group *</label>
        <select name="group" class="input select" required>
          <option value="">Select</option>
          <?php foreach (['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $g): ?>
            <option value="<?php echo $g; ?>"><?php echo $g; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="label">Units Needed *</label>
        <input class="input" type="number" min="1" name="units" required>
      </div>
      <div>
        <label class="label">Contact Phone *</label>
        <input class="input" name="contact" required>
      </div>
    </div>
    <div style="margin-top:12px">
      <button class="btn" type="submit">Submit Request</button>
    </div>
  </form>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
