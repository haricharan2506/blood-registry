<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<main class="wrap">
  <div class="card">
    <h2>Thank you, <?php echo e($_GET['name'] ?? 'Donor'); ?>! 🎉</h2>
    <p class="sm">Your details have been added. We’ll contact you when there’s a matching request.</p>
    <a class="btn" href="/blood-registry/public/">Go Home</a>
  </div>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
