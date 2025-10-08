<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$nama = $_SESSION['nama'] ?? '';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="/index.php">SIMARA</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/index.php#tentang">Tentang</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.php#fitur">Fitur</a></li>
        <?php if(!$nama): ?>
          <li class="nav-item"><a class="nav-link btn btn-primary text-white ms-2" href="/remaja/login.php">Login</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/remaja/dashboard.php"><?=htmlspecialchars($nama)?></a></li>
          <li class="nav-item"><a class="nav-link btn btn-outline-danger ms-2" href="/logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
