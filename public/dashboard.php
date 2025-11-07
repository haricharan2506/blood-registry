<?php
// ✅ Must be FIRST — this loads session + database + require_login()
require_once __DIR__ . '/../config/db.php';

// ✅ Now we can safely protect the page
require_login();
?>

<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<main class="wrap">
  <h1>Admin Dashboard</h1>

  <div class="grid">
    <a class="card" href="/blood-registry/public/donors.php">
      <h3>Manage Donors</h3>
      <p class="sm">Add, edit, or remove donors.</p>
    </a>

    <a class="card" href="/blood-registry/public/requests.php">
      <h3>Manage Requests</h3>
      <p class="sm">Review and mark requests as fulfilled.</p>
    </a>
  </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
