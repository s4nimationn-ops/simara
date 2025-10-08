<?php if(session_status()===PHP_SESSION_NONE) session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="/index.php">SIMARA - Admin</a>
    <div class="collapse navbar-collapse" id="navAdmin">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="input_kader.php">Tambah Kader</a></li>
        <li class="nav-item"><a class="nav-link btn btn-outline-light ms-2" href="/logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
