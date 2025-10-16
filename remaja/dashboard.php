<?php
session_start();
require_once '../config/db.php';
require_once '../config/session.php';

// Pastikan user login sebagai remaja
cek_role(['remaja']);
$user_id = $_SESSION['user_id'];
$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Remaja';

// ================= IMT TERAKHIR =================
$q_imt = mysqli_query($conn, "SELECT * FROM data_imt WHERE user_id='$user_id' ORDER BY tanggal_input DESC LIMIT 1");
if (!$q_imt) die("Query IMT gagal: " . mysqli_error($conn));
$imt = mysqli_fetch_assoc($q_imt);
$imt_value = $imt['hasil_imt'] ?? '-';
$imt_status = $imt['status_imt'] ?? 'Belum diisi';

// ================= DATA IMT UNTUK GRAFIK =================
$q_imt_grafik = mysqli_query($conn, "SELECT tanggal_input, status_imt FROM data_imt WHERE user_id='$user_id' ORDER BY tanggal_input ASC");
$imt_labels = [];
$imt_values = [];

// Mapping status ke angka
function status_to_number($status) {
    if ($status == "Kurus") return 1;
    if ($status == "Normal") return 2;
    if ($status == "Gemuk") return 3;
    return 0;
}

while ($row = mysqli_fetch_assoc($q_imt_grafik)) {
    $imt_labels[] = date('d/m/Y', strtotime($row['tanggal_input']));
    $imt_values[] = status_to_number($row['status_imt']);
}
$total_data_imt = count($imt_values);

// ================= Pola Makan =================
$q_pola = mysqli_query($conn, "SELECT * FROM data_pola_makan WHERE user_id='$user_id' ORDER BY tanggal_input DESC LIMIT 1");
if (!$q_pola) die("Query Pola Makan gagal: " . mysqli_error($conn));
$pola = mysqli_fetch_assoc($q_pola);
$sarapan = $pola['sarapan_per_minggu'] ?? '-';
$buah_sayur = $pola['buah_sayur_per_minggu'] ?? '-';

// ================= Aktivitas =================
$q_aktivitas = mysqli_query($conn, "SELECT * FROM data_aktivitas WHERE user_id='$user_id' ORDER BY tanggal_input DESC LIMIT 1");
if (!$q_aktivitas) die("Query Aktivitas gagal: " . mysqli_error($conn));
$aktivitas = mysqli_fetch_assoc($q_aktivitas);
$olahraga = $aktivitas['olahraga_per_minggu'] ?? '-';
$gadget = $aktivitas['gadget_jam_per_hari'] ?? '-';

// ================= TTD =================
$q_ttd = mysqli_query($conn, "
  SELECT tanggal_pemberian 
  FROM pemberian_suplemen 
  WHERE user_id = '$user_id' AND tablet_tambah_darah = 1 
  ORDER BY tanggal_pemberian DESC 
  LIMIT 1
");
if (!$q_ttd) die("Query TTD gagal: " . mysqli_error($conn));
$ttd = mysqli_fetch_assoc($q_ttd);
$terakhir_ttd = $ttd ? new DateTime($ttd['tanggal_pemberian']) : null;
$hari_ini = new DateTime();
if ($terakhir_ttd) $terakhir_ttd->modify('-8 days'); // simulasi
$selisih_hari = $terakhir_ttd ? $hari_ini->diff($terakhir_ttd)->days : null;

// ================= GAD-7 =================
$q_gad = mysqli_query($conn, "SELECT * FROM data_gad7 WHERE user_id='$user_id' ORDER BY tanggal_input DESC, id DESC LIMIT 1");
if (!$q_gad) die("Query GAD-7 gagal: " . mysqli_error($conn));
$gad = mysqli_fetch_assoc($q_gad);

$gad_score = $gad['total_skor'] ?? '-';
$gad_result = $gad['kategori'] ?? 'Belum diisi';

$boleh_screening = true;
$sisa_waktu = 0;
$durasi_tunggu = 1; // menit

if ($gad) {
    $waktu_terakhir = strtotime($gad['tanggal_input']);
    $waktu_sekarang = time();
    $selisih_menit = ($waktu_sekarang - $waktu_terakhir) / 60;
    $sisa_waktu = $durasi_tunggu - $selisih_menit;

    if ($sisa_waktu > 0) {
        $boleh_screening = false;
    }
}

// ================= Artikel =================
$q_artikel = mysqli_query($conn, "SELECT * FROM artikel ORDER BY tanggal DESC");
if (!$q_artikel) die("Query artikel gagal: " . mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Remaja - SIMARA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { background: #f9fafb; font-family: 'Poppins', sans-serif; }
.navbar { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
.card { border: none; border-radius: 18px; box-shadow: 0 6px 15px rgba(0,0,0,0.08); transition: all 0.3s ease; }
.card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
.card h5 { font-weight: 600; }
.metric-value { font-size: 2rem; font-weight: 700; color: #2563eb; }
.header-box {
  background: linear-gradient(135deg, #3b82f6, #06b6d4);
  color: white;
  border-radius: 15px;
  padding: 25px 30px;
  box-shadow: 0 6px 12px rgba(0,0,0,0.1);
}
.gad-box { margin-top: 20px; background: rgba(255,255,255,0.15); padding: 15px; border-radius: 12px; }
.gad-box .score { font-size: 1.4rem; font-weight: 600; }
.badge-wait { background: rgba(0,0,0,0.3); color: #fff; padding: 6px 12px; border-radius: 10px; }
.chart-container {
  max-width: 1000px; /* ukuran grafik diperbesar */
  margin: 0 auto;
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
      <a href="logout.php" class="text-danger text-decoration-none">Logout</a>
    </div>
  </div>
</nav>

<!-- Header -->
<div class="container my-4">
  <div class="header-box text-center">
    <h4>Halo, <?= htmlspecialchars($nama); ?> 👋</h4>
    <p class="mb-0">Berikut ringkasan kesehatan terakhirmu</p>

    <!-- Screening GAD-7 -->
    <div class="gad-box mt-3">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h5>🧠 Screening Kesehatan Mental</h5>
          <div class="score">Skor: <?= htmlspecialchars($gad_score); ?> | <?= htmlspecialchars($gad_result); ?></div>
        </div>
        <div>
          <?php if ($boleh_screening): ?>
            <a href="gad7_screening.php" class="btn btn-primary">Mulai Screening</a>
          <?php else: ?>
            <span class="badge-wait">Tunggu <?= ceil($sisa_waktu); ?> menit lagi ⏳</span>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Alert TTD -->
<?php if (!$terakhir_ttd || $selisih_hari >= 7): ?>
<div class="container mt-4">
  <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
    <div class="d-flex align-items-center">
      <i class="bi bi-capsule me-2 fs-5"></i>
      <div>
        <strong>Pengingat:</strong> Sudah <?= $selisih_hari ?? 'beberapa'; ?> hari sejak terakhir minum <strong>Tablet Tambah Darah</strong>.<br>
        Jangan lupa diminum hari ini ya! 💊
      </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
<?php endif; ?>

<!-- Box Inputan -->
<div class="container mt-4">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card text-center p-4">
        <div class="mb-2 text-primary"><i class="bi bi-activity" style="font-size: 2rem;"></i></div>
        <h5>Indeks Massa Tubuh</h5>
        <div class="metric-value"><?= $imt_value; ?></div>
        <p class="text-muted"><?= $imt_status; ?></p>
        <a href="input_imt.php" class="btn btn-outline-primary w-100">Isi / Perbarui</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center p-4">
        <div class="mb-2 text-success"><i class="bi bi-egg-fried" style="font-size: 2rem;"></i></div>
        <h5>Pola Makan</h5>
        <p class="mb-1 text-muted">Sarapan: <?= $sarapan; ?>x/minggu</p>
        <p class="text-muted">Buah & Sayur: <?= $buah_sayur; ?>x/minggu</p>
        <a href="input_pola_makan.php" class="btn btn-outline-primary w-100">Isi / Perbarui</a>
      </div>
    </div>
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

<!-- Grafik Garis IMT -->
<?php if ($total_data_imt > 0): ?>
<div class="container mt-5">
  <h4 class="mb-4 fw-bold text-primary text-center">📈 Grafik Kategori IMT Kamu</h4>
  <div class="card p-4 shadow-sm chart-container">
    <canvas id="imtLineChart"></canvas>
  </div>
</div>
<?php endif; ?>

<!-- Artikel -->
<div class="container mt-5">
  <h4 class="mb-4 fw-bold text-primary">📚 Artikel</h4>
  <div class="row g-4">
    <?php if (mysqli_num_rows($q_artikel) > 0): ?>
      <?php while ($artikel = mysqli_fetch_assoc($q_artikel)): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <?php if (!empty($artikel['poster'])): ?>
              <img src="../uploads/<?= htmlspecialchars($artikel['poster']); ?>" 
                   class="card-img-top" 
                   alt="Poster Artikel" 
                   style="height: 200px; object-fit: cover;">
            <?php endif; ?>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($artikel['judul']); ?></h5>
              <p class="card-text text-muted"><?= substr(strip_tags($artikel['konten']), 0, 100); ?>...</p>
              <?php if (!empty($artikel['video'])): ?>
                <div class="ratio ratio-16x9 mb-3">
                  <iframe src="<?= htmlspecialchars($artikel['video']); ?>" frameborder="0" allowfullscreen></iframe>
                </div>
              <?php endif; ?>
              <a href="artikel_detail.php?id=<?= $artikel['id']; ?>" class="btn btn-outline-primary mt-auto">Baca Selengkapnya</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-muted text-center">Belum ada artikel.</p>
    <?php endif; ?>
  </div>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if ($total_data_imt > 0): ?>
<script>
const kategoriMap = {
    1: 'Kurus',
    2: 'Normal',
    3: 'Gemuk'
};
const labels = <?= json_encode($imt_labels) ?>;
const values = <?= json_encode($imt_values) ?>;
const ctx = document.getElementById('imtLineChart').getContext('2d');

new Chart(ctx, {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{
      label: 'Kategori IMT',
      data: values,
      borderColor: '#2563eb',
      backgroundColor: 'rgba(37, 99, 235, 0.2)',
      borderWidth: 3,
      tension: 0.3,
      fill: true,
      pointRadius: 6,
      pointBackgroundColor: '#2563eb'
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        min: 1,
        max: 3,
        ticks: {
          stepSize: 1,
          callback: function(value) {
            return kategoriMap[value] || '';
          }
        },
        title: { display: true, text: 'Kategori IMT' }
      },
      x: {
        title: { display: true, text: 'Tanggal Input' }
      }
    },
    plugins: {
      tooltip: {
        callbacks: {
          label: function(context) {
            return 'Kategori: ' + kategoriMap[context.parsed.y];
          }
        }
      },
      legend: { display: false }
    }
  }
});
</script>
<?php endif; ?>
</body>
</html>
