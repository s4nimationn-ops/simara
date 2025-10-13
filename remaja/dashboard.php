<?php
session_start();
require_once '../config/db.php';
require_once '../config/session.php';

// pastikan user login sebagai remaja
cek_role(['remaja']);
$user_id = $_SESSION['user_id'];
$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Remaja';

// ambil data IMT terakhir
$q_imt = mysqli_query($conn, "SELECT * FROM data_imt WHERE user_id='$user_id' ORDER BY tanggal_input DESC LIMIT 1");
$imt = mysqli_fetch_assoc($q_imt);
$imt_value = $imt['hasil_imt'] ?? '-';
$imt_status = $imt['status_imt'] ?? 'Belum diisi';

// ambil data pola makan terakhir
$q_pola = mysqli_query($conn, "SELECT * FROM data_pola_makan WHERE user_id='$user_id' ORDER BY tanggal_input DESC LIMIT 1");
$pola = mysqli_fetch_assoc($q_pola);
$sarapan = $pola['sarapan_per_minggu'] ?? '-';
$buah_sayur = $pola['buah_sayur_per_minggu'] ?? '-';

// ambil data aktivitas terakhir
$q_aktivitas = mysqli_query($conn, "SELECT * FROM data_aktivitas WHERE user_id='$user_id' ORDER BY tanggal_input DESC LIMIT 1");
$aktivitas = mysqli_fetch_assoc($q_aktivitas);
$olahraga = $aktivitas['olahraga_per_minggu'] ?? '-';
$gadget = $aktivitas['gadget_jam_per_hari'] ?? '-';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Remaja - SIMARA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
  background: #f9fafb;
  font-family: 'Poppins', sans-serif;
}
.navbar {
  background: white;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.card {
  border: none;
  border-radius: 18px;
  box-shadow: 0 6px 15px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}
.card h5 {
  font-weight: 600;
}
.metric-value {
  font-size: 2rem;
  font-weight: 700;
  color: #2563eb;
}
.btn-outline-primary {
  border-radius: 10px;
  font-weight: 500;
}
.btn-outline-primary:hover {
  background-color: #2563eb;
  color: white;
}
.header-box {
  background: linear-gradient(135deg, #3b82f6, #06b6d4);
  color: white;
  border-radius: 15px;
  padding: 25px 30px;
  box-shadow: 0 6px 12px rgba(0,0,0,0.1);
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="#">SIMARA</a>
    <div class="ms-auto d-flex align-items-center gap-3">
      <span class="fw-semibold"><?= htmlspecialchars($nama); ?></span>
      <a href="../logout.php" class="text-danger text-decoration-none">Logout</a>
    </div>
  </div>
</nav>

<!-- Header -->
<div class="container my-4">
  <div class="header-box text-center">
    <h4>Halo, <?= htmlspecialchars($nama); ?> 👋</h4>
    <p class="mb-0">Berikut ringkasan kesehatan terakhirmu</p>
  </div>
</div>

<!-- Content -->
<div class="container mt-4">
  <div class="row g-4">
    <!-- Card IMT -->
    <div class="col-md-4">
      <div class="card text-center p-4">
        <div class="mb-2 text-primary"><i class="bi bi-activity" style="font-size: 2rem;"></i></div>
        <h5>Indeks Massa Tubuh</h5>
        <div class="metric-value"><?= $imt_value; ?></div>
        <p class="text-muted"><?= $imt_status; ?></p>
        <a href="input_imt.php" class="btn btn-outline-primary w-100">Isi / Perbarui</a>
      </div>
    </div>

    <!-- Card Pola Makan -->
    <div class="col-md-4">
      <div class="card text-center p-4">
        <div class="mb-2 text-success"><i class="bi bi-egg-fried" style="font-size: 2rem;"></i></div>
        <h5>Pola Makan</h5>
        <p class="mb-1 text-muted">Sarapan: <?= $sarapan; ?>x/minggu</p>
        <p class="text-muted">Buah & Sayur: <?= $buah_sayur; ?>x/minggu</p>
        <a href="input_pola_makan.php" class="btn btn-outline-primary w-100">Isi / Perbarui</a>
      </div>
    </div>

    <!-- Card Aktivitas -->
    <div class="col-md-4">
      <div class="card text-center p-4">
        <div class="mb-2 text-warning"><i class="bi bi-person-walking" style="font-size: 2rem;"></i></div>
        <h5>Aktivitas Olahraga</h5>
        <p class="mb-1 text-muted">Olahraga: <?= $olahraga; ?>x/minggu</p>
        <p class="text-muted">Gadget: <?= $gadget; ?> jam/hari</p>
        <a href="input_aktivitas.php" class="btn btn-outline-primary w-100">Isi / Perbarui</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
