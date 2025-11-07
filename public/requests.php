<?php require_once __DIR__ . '/../config/db.php'; require_login(); ?>
<?php
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action']) && $_POST['action']==='status') {
  $id=(int)$_POST['id']; $status=$_POST['status'];
  $pdo->prepare("UPDATE requests SET status=? WHERE id=?")->execute([$status,$id]);
  header("Location: /blood-registry/public/requests.php"); exit;
}
$reqs = $pdo->query("SELECT * FROM requests ORDER BY created_at DESC")->fetchAll();
?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<main class="wrap">
  <h1>Requests</h1>
  <div class="card">
    <table class="table">
      <thead><tr><th>Patient</th><th>Group</th><th>City</th><th>Hospital</th><th>Units</th><th>Contact</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($reqs as $r): ?>
          <tr>
            <td><?php echo e($r['patient']); ?></td>
            <td><span class="badge"><?php echo e($r['group_name']); ?></span></td>
            <td><?php echo e($r['city']); ?></td>
            <td><?php echo e($r['hospital']); ?></td>
            <td><?php echo e($r['units']); ?></td>
            <td><?php echo e($r['contact']); ?></td>
            <td><?php echo e($r['status']); ?></td>
            <td>
              <form method="post" style="display:flex;gap:6px">
                <input type="hidden" name="action" value="status">
                <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                <input type="hidden" name="status" value="<?php echo $r['status']==='OPEN'?'FULFILLED':'OPEN'; ?>">
                <button class="btn" type="submit"><?php echo $r['status']==='OPEN'?'Mark Fulfilled':'Reopen'; ?></button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
