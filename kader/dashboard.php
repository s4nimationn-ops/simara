<?php
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../config/session.php';
cek_role(['kader']);
$nama = $_SESSION['nama'];
$remaja = mysqli_query($conn, "SELECT id,nama,email FROM users WHERE role='remaja' ORDER BY created_at DESC LIMIT 20");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kader Dashboard</title>
  <link href="/assets/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }

    /* Hero Header */
    .hero-header {
      background: linear-gradient(135deg, #1e824c, #27ae60);
      color: #fff;
      padding: 60px 20px;
      border-bottom-left-radius: 50px;
      border-bottom-right-radius: 50px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      opacity: 0;
      transform: translateY(-40px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .hero-header.show {
      opacity: 1;
      transform: translateY(0);
    }

    /* Card Dashboard */
    .dashboard-card {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .dashboard-card.show {
      opacity: 1;
      transform: translateY(0);
    }

    /* Animasi tabel baris */
    tbody tr {
      opacity: 0;
      transform: translateY(20px);
    }
    tbody tr.show-row {
      opacity: 1;
      transform: translateY(0);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }

    /* Efek hover tombol */
    .btn {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <!-- Hero Header -->
  <div class="hero-header" id="heroHeader">
    <h2 class="fw-bold mb-2">Selamat Datang Kembali, <?= htmlspecialchars($nama) ?> 👋</h2>
    <p class="mb-0">Mari bantu pemantauan kesehatan remaja melalui Posyandu.</p>
  </div>

  <!-- Konten Dashboard -->
  <div class="container py-5">
    <div class="card p-3 mt-3 shadow-sm dashboard-card">
      <h4 class="mb-3 text-primary fw-bold">📋 Daftar Remaja Terbaru</h4>
      <table class="table table-striped align-middle">
        <thead class="table-primary">
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th width="250">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($r = mysqli_fetch_assoc($remaja)): ?>
          <tr>
            <td><?= htmlspecialchars($r['nama']) ?></td>
            <td><?= htmlspecialchars($r['email']) ?></td>
            <td>
              <div class="d-flex gap-2">
                <a href="input_antropometri.php?uid=<?= $r['id'] ?>" class="btn btn-sm btn-primary">Input Antropometri</a>
                <a href="input_screening.php?uid=<?= $r['id'] ?>" class="btn btn-sm btn-secondary">Input Screening</a>
              </div>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    window.addEventListener('DOMContentLoaded', () => {
      // Animasi header
      document.getElementById('heroHeader').classList.add('show');

      // Animasi card dashboard
      setTimeout(() => {
        document.querySelector('.dashboard-card').classList.add('show');
      }, 300);

      // Animasi baris tabel satu per satu
      const rows = document.querySelectorAll('tbody tr');
      rows.forEach((row, i) => {
        setTimeout(() => row.classList.add('show-row'), 500 + i * 150);
      });
    });
  </script>
</body>
</html>
