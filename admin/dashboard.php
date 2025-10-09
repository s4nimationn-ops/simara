<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);
$nama = $_SESSION['nama'];

// Ambil data total pengguna
$total_remaja = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE role='remaja'"))[0];
$total_kader = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE role='kader'"))[0];
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Admin - Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
/* ====== HERO SECTION ====== */
.hero-section {
  background: linear-gradient(135deg, #007bff, #66b3ff);
  color: #fff;
  padding: 90px 0 160px;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.hero-section h1 {
  font-size: 3rem;
  font-weight: 700;
  position: relative;
  z-index: 2;
  text-shadow: 0 3px 6px rgba(0, 0, 0, 0.25);
}

/* ====== GELOMBANG ====== */
.custom-shape-divider-bottom-hero {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 200%;
  overflow: hidden;
  line-height: 0;
}

.custom-shape-divider-bottom-hero svg {
  position: absolute;
  width: 200%;
  height: 160px;
}

.shape-fill {
  fill: url(#blueGradient);
}

/* ====== ANIMASI GELOMBANG ====== */
.wave1 {
  animation: waveMove 12s linear infinite;
  opacity: 0.8;
}
.wave2 {
  animation: waveMove2 16s linear infinite;
  opacity: 0.5;
}

@keyframes waveMove {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
@keyframes waveMove2 {
  0% { transform: translateX(0); }
  100% { transform: translateX(50%); }
}

/* ====== ANIMASI MASUK ====== */
.fade-in {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 1.2s ease-out forwards;
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ====== CARD SECTION ====== */
.stat-container {
  display: flex;
  justify-content: center;
  gap: 40px;
  flex-wrap: wrap;
  margin-top: 50px;
}

.stat-card {
  width: 320px;
  height: 160px;
  border-radius: 20px;
  color: #fff;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 25px 35px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
}

.stat-text h1 {
  font-size: 48px;
  font-weight: bold;
  margin: 0;
}

.stat-text p {
  margin: 0;
  font-size: 18px;
  font-weight: 500;
  opacity: 0.9;
}

.stat-icon {
  font-size: 55px;
  opacity: 0.8;
}

/* Warna */
.remaja { background-color: #007bff; }
.kader { background-color: #198754; }

/* ====== FIXED NAVBAR ====== */
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
  background-color: #0056b3;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
}

/* Hilangkan jarak putih antara navbar dan hero */
body {
  margin: 0;
  padding: 0;
  background-color: #f8f9fa;
  overflow-x: hidden;
}

.hero-section {
  margin-top: 0 !important;
  padding-top: 100px; /* ini ganti nilai sesuai tinggi navbar kamu */
}

  </style>
</head>

<body>
<?php include 'navbar.php'; ?>

<!-- ===== HERO SECTION ===== -->
<section class="hero-section fade-in">
  <h1>Data Pengguna</h1>
  <div class="custom-shape-divider-bottom-hero">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="wave1">
      <defs>
        <linearGradient id="blueGradient" x1="0%" y1="0%" x2="0%" y2="100%">
          <stop offset="0%" stop-color="#66b3ff"/>
          <stop offset="100%" stop-color="#e0f3ff"/>
        </linearGradient>
      </defs>
      <path d="M0,40 C300,120 900,-40 1200,40 L1200,120 L0,120 Z" class="shape-fill"></path>
    </svg>
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="wave2">
      <path d="M0,60 C400,140 800,-20 1200,60 L1200,120 L0,120 Z" class="shape-fill"></path>
    </svg>
  </div>
</section>

<!-- ===== CARD STATISTIK ===== -->
<div class="stat-container">
  <div class="stat-card remaja">
    <div class="stat-text">
      <h1><?= $total_remaja ?></h1>
      <p>Total Remaja</p>
    </div>
    <div class="stat-icon">
      <i class="fas fa-user-graduate"></i>
    </div>
  </div>

  <div class="stat-card kader">
    <div class="stat-text">
      <h1><?= $total_kader ?></h1>
      <p>Total Kader</p>
    </div>
    <div class="stat-icon">
      <i class="fas fa-users-cog"></i>
    </div>
  </div>
</div>

<!-- ===== GRAFIK ===== -->
<div class="container my-5">
  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card p-4 shadow-sm">
        <h5 class="text-center mb-3">Statistik Jumlah Pengguna</h5>
        <canvas id="chartData"></canvas>
      </div>
    </div>
  </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
const ctx = document.getElementById('chartData').getContext('2d');
new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['Remaja', 'Kader'],
    datasets: [{
      data: [<?= $total_remaja ?>, <?= $total_kader ?>],
      backgroundColor: ['#007bff', '#28a745'],
      borderWidth: 0
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: 'bottom' }
    }
  }
});
</script>
</body>
</html>
