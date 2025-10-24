<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);
$nama = $_SESSION['nama'];

// =====================
// DATA STATISTIK UTAMA
// =====================
$total_remaja = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE role='remaja'"))[0];
$total_kader  = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE role='kader'"))[0];

// =====================
// DATA IMT
// =====================
$q_imt = mysqli_query($conn, "
  SELECT 
    ROUND(AVG(hasil_imt),1) AS rata_imt,
    SUM(CASE WHEN status_imt='Kurus' THEN 1 ELSE 0 END) AS kurus,
    SUM(CASE WHEN status_imt='Normal' THEN 1 ELSE 0 END) AS normal,
    SUM(CASE WHEN status_imt='Gemuk' THEN 1 ELSE 0 END) AS gemuk
  FROM data_imt
");
$imt = mysqli_fetch_assoc($q_imt);

// =====================
// DATA POLA MAKAN
// =====================
$q_pola = mysqli_query($conn, "
  SELECT 
    ROUND(AVG(sarapan_per_minggu),1) AS sarapan,
    ROUND(AVG(buah_sayur_per_minggu),1) AS buah_sayur,
    ROUND(AVG(liter_air_per_hari),1) AS air
  FROM data_pola_makan
");
$pola = mysqli_fetch_assoc($q_pola);

// =====================
// DATA AKTIVITAS
// =====================
$q_aktivitas = mysqli_query($conn, "
  SELECT 
    ROUND(AVG(olahraga_per_minggu),1) AS olahraga,
    ROUND(AVG(gadget_jam_per_hari),1) AS gadget
  FROM data_aktivitas
");
$aktivitas = mysqli_fetch_assoc($q_aktivitas);

// =====================
// DATA GAD7 (SCREENING MENTAL)
// =====================
$q_gad = mysqli_query($conn, "
  SELECT 
    SUM(CASE WHEN kategori='Minimal' THEN 1 ELSE 0 END) AS minimal,
    SUM(CASE WHEN kategori='Ringan' THEN 1 ELSE 0 END) AS ringan,
    SUM(CASE WHEN kategori='Sedang' THEN 1 ELSE 0 END) AS sedang,
    SUM(CASE WHEN kategori='Berat' THEN 1 ELSE 0 END) AS berat
  FROM data_gad7
");
$gad = mysqli_fetch_assoc($q_gad);
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Admin - Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    .hero-section {
      background: linear-gradient(135deg, #007bff, #66b3ff);
      color: #fff;
      padding: 90px 0 160px;
      text-align: center;
      position: relative;
    }

    .hero-section h1 {
      font-size: 3rem;
      font-weight: 700;
      text-shadow: 0 3px 6px rgba(0,0,0,0.25);
    }

    .chart-card {
      border-radius: 18px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      padding: 25px;
      background: #fff;
      margin-bottom: 30px;
      height: 350px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .chart-card canvas {
      max-height: 250px !important;
    }

    small.text-muted {
      display: block;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>

<body>
<?php include 'navbar.php'; ?>

<section class="hero-section">
  <h1>Dashboard Admin</h1>
  <p class="lead mt-2">Statistik Kesehatan dan Mental Remaja</p>
</section>

<div class="container my-5">
  <div class="row g-4">

    <!-- === Jumlah Pengguna === -->
    <div class="col-md-6">
      <div class="chart-card">
        <h5 class="text-center mb-3">📊 Jumlah Pengguna</h5>
        <canvas id="chartUsers"></canvas>
        <small class="text-muted">Perbandingan antara jumlah remaja dan kader dalam sistem.</small>
      </div>
    </div>

    <!-- === Grafik IMT === -->
    <div class="col-md-6">
      <div class="chart-card">
        <h5 class="text-center mb-3">⚖️ Status IMT Remaja</h5>
        <canvas id="chartIMT"></canvas>
        <small class="text-muted">Distribusi status IMT dari seluruh remaja yang sudah mengisi data.</small>
      </div>
    </div>

    <!-- === Pola Makan === -->
    <div class="col-md-6">
      <div class="chart-card">
        <h5 class="text-center mb-3">🍎 Pola Makan (Rata-rata)</h5>
        <canvas id="chartPola"></canvas>
        <small class="text-muted">Rata-rata frekuensi sarapan, konsumsi buah & sayur, serta asupan air harian.</small>
      </div>
    </div>

    <!-- === Aktivitas === -->
    <div class="col-md-6">
      <div class="chart-card">
        <h5 class="text-center mb-3">🏃 Aktivitas Harian</h5>
        <canvas id="chartAktivitas"></canvas>
        <small class="text-muted">Rata-rata jumlah olahraga per minggu dan durasi penggunaan gadget per hari.</small>
      </div>
    </div>

    <!-- === Mental Health === -->
    <div class="col-md-6 mx-auto">
      <div class="chart-card">
        <h5 class="text-center mb-3">🧠 Kondisi Mental Remaja</h5>
        <canvas id="chartMental"></canvas>
        <small class="text-muted">Klasifikasi tingkat kecemasan dari hasil skrining seluruh remaja.</small>
      </div>
    </div>

  </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
// ===== USERS =====
new Chart(document.getElementById('chartUsers'), {
  type: 'doughnut',
  data: {
    labels: ['Remaja', 'Kader'],
    datasets: [{
      data: [<?= $total_remaja ?>, <?= $total_kader ?>],
      backgroundColor: ['#007bff', '#28a745']
    }]
  },
  options: {
    plugins: { legend: { position: 'bottom' } },
    maintainAspectRatio: false
  }
});

// ===== IMT =====
new Chart(document.getElementById('chartIMT'), {
  type: 'pie',
  data: {
    labels: ['Kurus', 'Normal', 'Gemuk'],
    datasets: [{
      data: [<?= $imt['kurus'] ?>, <?= $imt['normal'] ?>, <?= $imt['gemuk'] ?>],
      backgroundColor: ['#60a5fa', '#34d399', '#fbbf24']
    }]
  },
  options: {
    plugins: { legend: { position: 'bottom' } },
    maintainAspectRatio: false
  }
});

// ===== POLA MAKAN =====
new Chart(document.getElementById('chartPola'), {
  type: 'bar',
  data: {
    labels: ['Sarapan (x/minggu)', 'Buah & Sayur (x/minggu)', 'Air (L/hari)'],
    datasets: [{
      data: [<?= $pola['sarapan'] ?>, <?= $pola['buah_sayur'] ?>, <?= $pola['air'] ?>],
      backgroundColor: ['#f97316', '#22c55e', '#3b82f6']
    }]
  },
  options: {
    scales: { y: { beginAtZero: true } },
    maintainAspectRatio: false
  }
});

// ===== AKTIVITAS =====
new Chart(document.getElementById('chartAktivitas'), {
  type: 'bar',
  data: {
    labels: ['Olahraga (x/minggu)', 'Gadget (jam/hari)'],
    datasets: [{
      data: [<?= $aktivitas['olahraga'] ?>, <?= $aktivitas['gadget'] ?>],
      backgroundColor: ['#10b981', '#ef4444']
    }]
  },
  options: {
    scales: { y: { beginAtZero: true } },
    maintainAspectRatio: false
  }
});

// ===== MENTAL HEALTH =====
new Chart(document.getElementById('chartMental'), {
  type: 'doughnut',
  data: {
    labels: ['Minimal', 'Ringan', 'Sedang', 'Berat'],
    datasets: [{
      data: [<?= $gad['minimal'] ?>, <?= $gad['ringan'] ?>, <?= $gad['sedang'] ?>, <?= $gad['berat'] ?>],
      backgroundColor: ['#22c55e', '#3b82f6', '#facc15', '#ef4444']
    }]
  },
  options: {
    plugins: { legend: { position: 'bottom' } },
    maintainAspectRatio: false
  }
});
</script>
</body>
</html>
