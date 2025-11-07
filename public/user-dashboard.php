<?php require_once __DIR__ . '/../config/db.php'; require_user_login(); ?>
<?php
$uid = $_SESSION['user_id'];
$st = $pdo->prepare("SELECT * FROM users WHERE id=?"); $st->execute([$uid]); $user = $st->fetch();

// Fetch this user's requests
$req = $pdo->prepare("SELECT * FROM requests WHERE user_id=? ORDER BY created_at DESC"); $req->execute([$uid]); $reqs = $req->fetchAll();
?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<main class="wrap">
  <h1>Welcome, <?php echo e($user['name']); ?> 👋</h1>
  <div class="grid section">
    <div class="card">
      <h3>Your Profile</h3>
      <p class="sm">Email: <?php echo e($user['email']); ?></p>
      <p class="sm">Phone: <?php echo e($user['phone']); ?></p>
      <p class="sm">City: <?php echo e($user['city']); ?></p>
      <p class="sm">Blood Group: <span class="badge"><?php echo e($user['group_name']); ?></span></p>
      <a class="btn secondary" href="/blood-registry/public/user-edit.php">Edit Profile</a>
    </div>
    <div class="card">
      <h3>Your Requests</h3>
      <?php if(!$reqs): ?>
        <p class="sm">No requests yet. <a href="/blood-registry/public/request-blood.php">Create one</a>.</p>
      <?php else: ?>
        <table class="table">
          <thead><tr><th>Patient</th><th>Group</th><th>Units</th><th>Status</th><th>Created</th></tr></thead>
          <tbody>
            <?php foreach($reqs as $r): ?>
              <tr>
                <td><?php echo e($r['patient']); ?></td>
                <td><span class="badge"><?php echo e($r['group_name']); ?></span></td>
                <td><?php echo e($r['units']); ?></td>
                <td><?php echo e($r['status']); ?></td>
                <td><?php echo e($r['created_at']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
