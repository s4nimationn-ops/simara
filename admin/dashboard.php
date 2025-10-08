<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);
$nama = $_SESSION['nama'];
// simple stats
$total_remaja = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM users WHERE role='remaja'"))[0];
$total_kader = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM users WHERE role='kader'"))[0];
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Admin - Dashboard</title>
<link href="/assets/css/style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><?php include 'navbar.php'; ?>
<div class="container py-5">
  <h3>Halo, <?=htmlspecialchars($nama)?></h3>
  <div class="row mt-4">
    <div class="col-md-4"><div class="card p-3"><h5>Total Remaja</h5><h2><?=$total_remaja?></h2></div></div>
    <div class="col-md-4"><div class="card p-3"><h5>Total Kader</h5><h2><?=$total_kader?></h2></div></div>
  </div>
</div></body></html>
