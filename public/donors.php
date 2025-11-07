<?php require_once __DIR__ . '/../config/db.php'; require_login(); ?>
<?php
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action']) && $_POST['action']==='delete') {
  $id = (int)$_POST['id'];
  $pdo->prepare("DELETE FROM donors WHERE id=?")->execute([$id]);
  header("Location: /blood-registry/public/donors.php");
  exit;
}
$donors = $pdo->query("SELECT * FROM donors ORDER BY created_at DESC")->fetchAll();
?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<main class="wrap">
  <div class="section" style="display:flex;justify-content:space-between;align-items:center">
    <h1>Donors</h1>
    <a class="btn" href="/blood-registry/public/add-donor.php">+ Add Donor</a>
  </div>
  <div class="card">
    <table class="table">
      <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>City</th><th>Group</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($donors as $d): ?>
          <tr>
            <td><?php echo e($d['name']); ?></td>
            <td><?php echo e($d['email']); ?></td>
            <td><?php echo e($d['phone']); ?></td>
            <td><?php echo e($d['city']); ?></td>
            <td><span class="badge"><?php echo e($d['group_name']); ?></span></td>
            <td style="display:flex; gap:8px;">
              <a class="btn secondary" href="/blood-registry/public/edit-donor.php?id=<?php echo $d['id']; ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this donor?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                <button class="btn" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
