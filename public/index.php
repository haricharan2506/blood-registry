<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<main class="hero">
  <section>
    <span class="kicker">Save Lives Today</span>
    <h1 class="title">Find blood donors near you—fast.</h1>
    <p class="subtitle">Search a verified network of volunteer donors by blood group and city. Register as a donor in minutes and make a life-saving impact.</p>

    <div class="section grid">
      <a class="card" href="/blood-registry/public/search.php">
        <h3>🔎 Quick Search</h3>
        <p class="sm">Filter by blood group & city and contact donors instantly.</p>
      </a>
      <a class="card" href="/blood-registry/public/register.php">
        <h3>🩸 Become a Donor</h3>
        <p class="sm">Join the registry and help patients in your community.</p>
      </a>
      <a class="card" href="/blood-registry/public/request-blood.php">
        <h3>📣 Request Blood</h3>
        <p class="sm">Need units urgently? Post a request for admins to match.</p>
      </a>
    </div>
  </section>

  <form class="card form-card" action="/blood-registry/public/search.php" method="get" novalidate>
    <h3>Search donors now</h3>
    <label class="label">Blood Group *</label>
    <select name="group" class="input select" required>
      <option value="">Select group</option>
      <?php foreach (['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $g): ?>
        <option value="<?php echo $g; ?>"><?php echo $g; ?></option>
      <?php endforeach; ?>
    </select>

    <label class="label">City *</label>
    <input type="text" name="city" class="input" placeholder="e.g., Hyderabad" required>

    <div style="margin-top:14px; display:flex; gap:10px;">
      <button class="btn" type="submit">Search Donors</button>
      <a class="btn secondary" href="/blood-registry/public/register.php">Register as Donor</a>
    </div>
  </form>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
