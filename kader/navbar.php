<?php if(session_status()===PHP_SESSION_NONE) session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
 <div class="container">
  <a class="navbar-brand" href="/index.php">SIMARA - Kader</a>
  <div class="collapse navbar-collapse" id="navk">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
      <li class="nav-item"><a class="nav-link" href="view.php">Data</a></li>
      <li class="nav-item"><a class="nav-link" href="input_suplemen.php">Suplemen</a></li>
      <li class="nav-item"><a class="nav-link btn btn-outline-light ms-2" href="logout.php">Logout</a></li>
    </ul>
  </div>
 </div>
</nav>
