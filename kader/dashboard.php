<?php
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../config/session.php';
cek_role(['kader']);

$nama = $_SESSION['nama'];

// === Statistik Status Kesehatan ===
$q_stat = mysqli_query($conn, "
  SELECT 
    SUM(CASE WHEN status_kesehatan='Anemia' THEN 1 ELSE 0 END) AS anemia,
    SUM(CASE WHEN status_kesehatan='Darah Rendah' THEN 1 ELSE 0 END) AS darah_rendah,
    SUM(CASE WHEN status_kesehatan='Normal' THEN 1 ELSE 0 END) AS normal,
    SUM(CASE WHEN status_kesehatan='Darah Tinggi' THEN 1 ELSE 0 END) AS darah_tinggi
  FROM users
  WHERE role='remaja'
");
$stat = mysqli_fetch_assoc($q_stat);

// Ambil data remaja + nilai & status IMT terbaru
$remaja = mysqli_query($conn, "
  SELECT 
    u.id, 
    u.nama, 
    u.email, 
    u.alamat, 
    u.no_hp, 
    u.status_kesehatan,
    d.hasil_imt,
    d.status_imt
  FROM users u
  LEFT JOIN (
    SELECT user_id, hasil_imt, status_imt
    FROM data_imt
    WHERE (user_id, tanggal_input) IN (
      SELECT user_id, MAX(tanggal_input)
      FROM data_imt
      GROUP BY user_id
    )
  ) d ON u.id = d.user_id
  WHERE u.role='remaja'
  ORDER BY u.created_at DESC
  LIMIT 20
");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kader Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
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
    .hero-header.show { opacity: 1; transform: translateY(0); }

    .dashboard-card {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .dashboard-card.show { opacity: 1; transform: translateY(0); }

    /* ===== GRAFIK CARD ===== */
    .chart-card {
      border-radius: 18px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      padding: 25px;
      background: #fff;
      margin: 40px auto;
      max-width: 600px;
      text-align: center;
    }
    .chart-container {
      position: relative;
      width: 100%;
      max-width: 400px;
      height: 350px;
      margin: 0 auto;
    }
    small.text-muted {
      display: block;
      text-align: center;
      margin-top: 10px;
    }

    a.nama-link {
      text-decoration: none;
      color: #0d6efd;
      cursor: pointer;
    }
    a.nama-link:hover { text-decoration: underline; }

    /* ===== MODAL ===== */
    #detailModal .modal-content {
      border-radius: 1rem;
      overflow: hidden;
      border: none;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    #detailModal .modal-header {
      background: linear-gradient(135deg, #1e824c, #27ae60);
      color: #fff;
      border: none;
    }
    #detailModal .modal-body { background-color: #f4f6f8; }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <!-- Hero Header -->
  <div class="hero-header" id="heroHeader">
    <h2 class="fw-bold mb-2">Selamat Datang Kembali, <?= htmlspecialchars($nama) ?> </h2>
    <p class="mb-0">Mari bantu pemantauan kesehatan remaja melalui Posyandu.</p>
  </div>

  <!-- Grafik Status Kesehatan -->
  <div class="container my-5">
    <div class="chart-card">
      <h5 class="text-center mb-3">Status Kesehatan Darah Remaja</h5>
      <div class="chart-container">
        <canvas id="chartKesehatan"></canvas>
      </div>
      <small class="text-muted">
        Distribusi kondisi darah remaja berdasarkan data kesehatan terakhir.
      </small>
    </div>
  </div>

  <!-- Konten Dashboard -->
  <div class="container pb-5">
    <div class="card p-3 mt-3 shadow-sm dashboard-card">
      <h4 class="mb-3 text-primary fw-bold">Daftar Remaja Terbaru</h4>
      <table class="table table-striped align-middle">
        <thead class="table-success">
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Status Kesehatan</th>
            <th>Nilai IMT</th>
            <th>Status IMT</th>
            <th width="250">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($r = mysqli_fetch_assoc($remaja)): ?>
          <tr>
            <td>
              <a href="#" 
                 class="nama-link" 
                 data-nama="<?= htmlspecialchars($r['nama']) ?>" 
                 data-alamat="<?= htmlspecialchars($r['alamat']) ?>" 
                 data-hp="<?= htmlspecialchars($r['no_hp']) ?>">
                 <?= htmlspecialchars($r['nama']) ?>
              </a>
            </td>
            <td><?= htmlspecialchars($r['email']) ?></td>
            <td><?= $r['status_kesehatan'] ? htmlspecialchars($r['status_kesehatan']) : '-' ?></td>
            <td><?= $r['hasil_imt'] ? number_format($r['hasil_imt'], 2) : '-' ?></td>
            <td><?= $r['status_imt'] ? htmlspecialchars($r['status_imt']) : '-' ?></td>
            <td>
              <div class="d-flex gap-2">
                <a href="input_antropometri.php?uid=<?= $r['id'] ?>" class="btn btn-sm btn-primary">
                  <i class="bi bi-rulers me-1"></i> Antropometri
                </a>
                <a href="input_screening.php?uid=<?= $r['id'] ?>" class="btn btn-sm btn-outline-success">
                  <i class="bi bi-clipboard2-pulse me-1"></i> Screening
                </a>
              </div>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Detail -->
  <div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-semibold"><i class="bi bi-person-circle me-2"></i> Detail Remaja</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="detail-box">
            <h6><i class="bi bi-person-fill text-success me-2"></i>Nama</h6>
            <p id="modalNama" class="fw-semibold"></p>
            <hr>
            <h6><i class="bi bi-geo-alt-fill text-danger me-2"></i>Alamat</h6>
            <p id="modalAlamat" class="fw-semibold"></p>
            <hr>
            <h6><i class="bi bi-telephone-fill text-primary me-2"></i>No HP</h6>
            <p id="modalHP" class="fw-semibold"></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('heroHeader').classList.add('show');
      document.querySelector('.dashboard-card').classList.add('show');

      document.querySelectorAll('.nama-link').forEach(link => {
        link.addEventListener('click', e => {
          e.preventDefault();
          document.getElementById('modalNama').textContent = link.dataset.nama;
          document.getElementById('modalAlamat').textContent = link.dataset.alamat || 'Belum diisi';
          document.getElementById('modalHP').textContent = link.dataset.hp || 'Belum diisi';
          new bootstrap.Modal(document.getElementById('detailModal')).show();
        });
      });

      new Chart(document.getElementById('chartKesehatan'), {
        type: 'pie',
        data: {
          labels: ['Anemia', 'Darah Rendah', 'Normal', 'Darah Tinggi'],
          datasets: [{
            data: [
              <?= $stat['anemia'] ?>, 
              <?= $stat['darah_rendah'] ?>, 
              <?= $stat['normal'] ?>, 
              <?= $stat['darah_tinggi'] ?>
            ],
            backgroundColor: ['#ef4444', '#f59e0b', '#22c55e', '#3b82f6']
          }]
        },
        options: {
          plugins: { legend: { position: 'bottom' } },
          responsive: true,
          maintainAspectRatio: false
        }
      });
    });
  </script>
</body>
</html>
