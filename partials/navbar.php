<?php // partials/navbar.php ?>
<header class="nav">
  <a href="/blood-registry/public/" class="brand">🩸 Blood Registry</a>
  <nav>
    <a href="/blood-registry/public/register.php">Become a Donor</a>
    <a href="/blood-registry/public/request-blood.php">Request Blood</a>
    <a href="/blood-registry/public/search.php">Search</a>

    <?php if (is_user_logged_in()): ?>
      <a href="/blood-registry/public/user-dashboard.php">My Dashboard</a>
      <a href="/blood-registry/public/user-logout.php">Logout</a>
    <?php else: ?>
      <a href="/blood-registry/public/user-login.php">User Login</a>
      <a href="/blood-registry/public/user-register.php">Sign Up</a>
    <?php endif; ?>

    <?php if (is_logged_in()): ?>
      <a href="/blood-registry/public/dashboard.php">Admin</a>
      <a href="/blood-registry/public/logout.php">Logout</a>
    <?php else: ?>
      <a href="/blood-registry/public/login.php">Admin</a>
    <?php endif; ?>
  </nav>
</header>
