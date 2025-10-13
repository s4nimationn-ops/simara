<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['remaja']); // only remaja
$uid = $_SESSION['user_id'];
$nama = $_SESSION['nama'];

// fetch latest IMT, pola makan, aktivitas for summary
$imt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM data_imt WHERE user_id=$uid ORDER BY tanggal_input DESC LIMIT 1"));
$pola = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM data_pola_makan WHERE user_id=$uid ORDER BY tanggal_input DESC LIMIT 1"));
$aktiv = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM data_aktivitas WHERE user_id=$uid ORDER BY tanggal_input DESC LIMIT 1"));
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard Remaja - SIMARA</title>
  <link href="/assets/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">
  <div class="bg-white p-4 rounded shadow-sm mb-4">
    <h3>Halo, <?=htmlspecialchars($nama)?></h3>
    <p class="text-muted">Ringkasan kesehatan terakhir</p>
  </div>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card p-3 text-center">
        <h6>Indeks Massa Tubuh</h6>
        <h3><?= $imt ? number_format($imt['hasil_imt'],2) : '-' ?></h3>
        <p class="text-muted"><?= $imt['status_imt'] ?? 'Belum diisi' ?></p>
        <a class="btn btn-outline-primary" href="input_imt.php">Isi</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-3 text-center">
        <h6>Pola Makan</h6>
        <p class="text-muted">Sarapan: <?= $pola['sarapan_per_minggu'] ?? '-' ?>x/mgg</p>
        <p class="text-muted">Buah & Sayur: <?= $pola['buah_sayur_per_minggu'] ?? '-' ?>x/mgg</p>
        <a class="btn btn-outline-primary" href="input_pola_makan.php">Isi</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-3 text-center">
        <h6>Aktivitas Olahraga</h6>
        <p class="text-muted">Olahraga per minggu: <?= $aktiv['olahraga_per_minggu'] ?? '-' ?>x</p>
        <p class="text-muted">Jam gadget/hari: <?= $aktiv['gadget_jam_per_hari'] ?? '-' ?> jam</p>
        <a class="btn btn-outline-primary" href="input_aktivitas.php">Isi</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
