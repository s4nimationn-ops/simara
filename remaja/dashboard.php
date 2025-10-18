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

// ================= DATA IMT UNTUK GRAFIK =================
$q_imt_grafik = mysqli_query($conn, "SELECT tanggal_input, hasil_imt FROM data_imt WHERE user_id='$user_id' ORDER BY tanggal_input ASC");
$imt_labels = [];
$imt_values = [];

while ($row = mysqli_fetch_assoc($q_imt_grafik)) {
    $imt_labels[] = date('d/m/Y', strtotime($row['tanggal_input']));
    $imt_values[] = (float)$row['hasil_imt'];
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
  SELECT id, tanggal_pemberian, tanggal_minum_terakhir 
  FROM pemberian_suplemen 
  WHERE user_id = '$user_id' AND tablet_tambah_darah = 1 
  ORDER BY tanggal_pemberian DESC 
  LIMIT 1
");
if (!$q_ttd) die("Query TTD gagal: " . mysqli_error($conn));

$ttd = mysqli_fetch_assoc($q_ttd);
$hari_ini = new DateTime();
$tampilkan_notifikasi = false;
$pesan_notif = "";

// 🆕 Jika remaja baru (belum ada data sama sekali)
if (!$ttd) {
    $tampilkan_notifikasi = true;
    $pesan_notif = "Kamu belum pernah minum tablet tambah darah. Yuk mulai hari ini! 💊";
} else {
    // 👩‍🦱 Remaja lama
    $terakhir_minum = !empty($ttd['tanggal_minum_terakhir']) ? new DateTime($ttd['tanggal_minum_terakhir']) : null;

    if ($terakhir_minum) {
        $selisih_hari = $hari_ini->diff($terakhir_minum)->days;

        // Tampilkan notifikasi hanya jika sudah 7 hari atau lebih
        if ($selisih_hari >= 7) {
            $tampilkan_notifikasi = true;
            $pesan_notif = "Sudah $selisih_hari hari sejak terakhir kamu minum tablet tambah darah. Saatnya minum lagi hari ini! 💊";
        }
    } else {
        // Jika kolom tanggal_minum_terakhir masih kosong
        $tampilkan_notifikasi = true;
        $pesan_notif = "Belum ada data minum tablet. Jangan lupa mulai hari ini ya! 💊";
    }
}


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
<?php if ($tampilkan_notifikasi): ?>
<div class="container mt-4">
  <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert" id="alertTTD">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <i class="bi bi-capsule me-2 fs-5"></i>
        <strong>Pengingat Tablet Tambah Darah</strong><br>
        <?= htmlspecialchars($pesan_notif); ?>
      </div>
      <button class="btn btn-sm btn-primary ms-3" id="btnSudahMinum">Saya sudah minum</button>
    </div>
  </div>
</div>

<script>
document.getElementById('btnSudahMinum').addEventListener('click', function() {
  fetch('update_ttd.php', { method: 'POST' })
    .then(res => res.text())
    .then(res => {
      if (res.trim() === 'OK') {
        const alertBox = document.getElementById('alertTTD');
        alertBox.classList.remove('show');
        setTimeout(() => alertBox.remove(), 500);
      } else {
        alert('Gagal memperbarui status: ' + res);
      }
    })
    .catch(err => alert('Terjadi kesalahan: ' + err));
});
</script>
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
const labels = <?= json_encode($imt_labels) ?>;
const values = <?= json_encode($imt_values) ?>;
const ctx = document.getElementById('imtLineChart').getContext('2d');

// Hitung min dan max nilai Y agar grafik dinamis
const minValue = Math.min(...values);
const maxValue = Math.max(...values);
const padding = 1;
const yMin = Math.floor(minValue - padding);
const yMax = Math.ceil(maxValue + padding);

new Chart(ctx, {
  type: 'line',
  data: {
    labels: labels,
    datasets: [
      {
        label: 'Nilai IMT',
        data: values,
        borderColor: '#2563eb',
        backgroundColor: 'rgba(37, 99, 235, 0.2)',
        borderWidth: 3,
        tension: 0.3,
        fill: true,
        pointRadius: 6,
        pointBackgroundColor: '#2563eb'
      },
      {
        label: 'Batas Normal Bawah (18.5)',
        data: Array(values.length).fill(18.5),
        borderColor: 'green',
        borderWidth: 2,
        borderDash: [6, 6],
        pointRadius: 0,
        fill: false
      },
      {
        label: 'Batas Normal Atas (24.9)',
        data: Array(values.length).fill(24.9),
        borderColor: 'red',
        borderWidth: 2,
        borderDash: [6, 6],
        pointRadius: 0,
        fill: false
      }
    ]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        suggestedMin: yMin,
        suggestedMax: yMax,
        ticks: {
          stepSize: 1,
          callback: function(value) {
            return value.toFixed(1);
          }
        },
        title: { display: true, text: 'Nilai IMT' }
      },
      x: {
        title: { display: true, text: 'Tanggal Input' }
      }
    },
    plugins: {
      tooltip: {
        callbacks: {
          label: function(context) {
            return 'IMT: ' + context.parsed.y.toFixed(1);
          }
        }
      },
      legend: { display: true }
    }
  }
});
</script>
<?php endif; ?>

</body>
</html>
