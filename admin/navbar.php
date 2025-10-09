<?php if(session_status()===PHP_SESSION_NONE) session_start(); ?>
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/index.php">SIMARA - Admin</a>

    <!-- Tombol Toggle Mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin" aria-controls="navAdmin" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navAdmin">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="input_kader.php">Tambah Kader</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="biodata_kader.php">Biodata</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-outline-light ms-2" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
.navbar {
  z-index: 9999 !important;  /* Naikkan supaya tidak tertimpa */
}
</style>
