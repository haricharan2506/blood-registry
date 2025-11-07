<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<?php
$group = trim($_GET['group'] ?? '');
$city  = trim($_GET['city'] ?? '');
$donors = [];
if ($group && $city) {
  $stmt = $pdo->prepare("SELECT * FROM donors WHERE group_name=? AND city LIKE ? ORDER BY created_at DESC");
  $stmt->execute([$group, "%$city%"]);
  $donors = $stmt->fetchAll();
}
?>
<main class="wrap">
  <h1>Search Donors</h1>
  <form class="card" method="get">
    <div class="grid">
      <div>
        <label class="label">Blood Group</label>
        <select name="group" class="input select">
          <option value="">Any</option>
          <?php foreach (['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $g): ?>
            <option value="<?php echo $g; ?>" <?php echo $group===$g?'selected':''; ?>><?php echo $g; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="label">City</label>
        <input class="input" name="city" value="<?php echo e($city); ?>" placeholder="e.g., Hyderabad">
      </div>
    </div>
    <div style="margin-top:12px">
      <button class="btn" type="submit">Search</button>
    </div>
  </form>

  <div class="section card">
    <table class="table">
      <thead><tr><th>Name</th><th>Blood Group</th><th>City</th><th>Phone</th><th>Last Donated</th></tr></thead>
      <tbody>
        <?php if (!$donors): ?>
          <tr><td colspan="5">No donors found. Try different filters.</td></tr>
        <?php else: foreach ($donors as $d): ?>
          <tr>
            <td><?php echo e($d['name']); ?></td>
            <td><span class="badge"><?php echo e($d['group_name']); ?></span></td>
            <td><?php echo e($d['city']); ?></td>
            <td><?php echo e($d['phone']); ?></td>
            <td><?php echo e($d['last_donated']); ?></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
