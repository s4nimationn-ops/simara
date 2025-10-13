<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['kader']);

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
  echo "<div class='alert alert-danger'>ID tidak valid.</div>";
  exit;
}

$q_user = mysqli_query($conn, "SELECT * FROM users WHERE id=$id AND role='remaja'");
$remaja = mysqli_fetch_assoc($q_user);
if (!$remaja) {
  echo "<div class='alert alert-warning'>Data remaja tidak ditemukan.</div>";
  exit;
}

// Ambil data tambahan
$imt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM data_imt WHERE user_id=$id ORDER BY tanggal_input DESC LIMIT 1"));
$pola = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM data_pola_makan WHERE user_id=$id ORDER BY tanggal_input DESC LIMIT 1"));
$aktiv = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM data_aktivitas WHERE user_id=$id ORDER BY tanggal_input DESC LIMIT 1"));
$periksa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemeriksaan_kader WHERE user_id=$id ORDER BY tanggal_periksa DESC LIMIT 1"));
?>

<div class="text-start">
  <h5 class="fw-bold text-primary mb-2"><?= htmlspecialchars($remaja['nama']) ?></h5>
  <p><b>Email:</b> <?= htmlspecialchars($remaja['email']) ?></p>

  <div class="row">
    <div class="col-md-6">
      <div class="card mb-3 shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold text-secondary">📏 Pemeriksaan Kader</h6>
          <?php if($periksa): ?>
            <p>Tinggi: <?= $periksa['tinggi_cm'] ?> cm<br>
               Berat: <?= $periksa['berat_kg'] ?> kg<br>
               Lingkar Lengan: <?= $periksa['lingkar_lengan_cm'] ?> cm<br>
               Tekanan Darah: <?= $periksa['tekanan_darah'] ?><br>
               Hemoglobin: <?= $periksa['hemoglobin'] ?><br>
               <small class="text-muted">Tanggal: <?= $periksa['tanggal_periksa'] ?></small></p>
          <?php else: ?><p class="text-muted">Belum ada pemeriksaan.</p><?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card mb-3 shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold text-secondary">📉 Indeks Massa Tubuh</h6>
          <?php if($imt): ?>
            <p>IMT: <?= $imt['hasil_imt'] ?><br>
               Status: <?= $imt['status_imt'] ?><br>
               <small class="text-muted">Tanggal: <?= $imt['tanggal_input'] ?></small></p>
          <?php else: ?><p class="text-muted">Belum ada data IMT.</p><?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card mb-3 shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold text-secondary">🍽️ Pola Makan</h6>
          <?php if($pola): ?>
            <p>Sarapan / Minggu: <?= $pola['sarapan_per_minggu'] ?><br>
               Buah & Sayur / Minggu: <?= $pola['buah_sayur_per_minggu'] ?><br>
               Air Putih / Hari: <?= $pola['liter_air_per_hari'] ?> L</p>
          <?php else: ?><p class="text-muted">Belum ada data pola makan.</p><?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card mb-3 shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold text-secondary">🏃 Aktivitas Olahraga</h6>
          <?php if($aktiv): ?>
            <p>Olahraga / Minggu: <?= $aktiv['olahraga_per_minggu'] ?><br>
               Waktu Gadget / Hari: <?= $aktiv['gadget_jam_per_hari'] ?> jam</p>
          <?php else: ?><p class="text-muted">Belum ada data aktivitas.</p><?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
