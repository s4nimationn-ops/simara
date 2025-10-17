<?php
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../config/session.php';
cek_role(['kader']);

$nama = $_SESSION['nama'];

// ambil data remaja terbaru
$remaja = mysqli_query($conn, "SELECT id, nama, email, alamat, no_hp, status_kesehatan FROM users WHERE role='remaja' ORDER BY created_at DESC LIMIT 20");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kader Dashboard</title>
  <link href="/assets/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

    tbody tr {
      opacity: 0;
      transform: translateY(20px);
    }
    tbody tr.show-row {
      opacity: 1;
      transform: translateY(0);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }

    a.nama-link {
      text-decoration: none;
      color: #0d6efd;
      cursor: pointer;
    }
    a.nama-link:hover {
      text-decoration: underline;
    }

    .btn {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    /* Modal modern */
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
    #detailModal .modal-body {
      background-color: #f4f6f8;
    }
    #detailModal .detail-box {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    #detailModal .detail-box:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }
    #detailModal h6 {
      font-weight: 600;
      color: #555;
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
        <thead class="table-success">
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Status</th>
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

  <!-- Modal Detail Remaja (Modern) -->
  <div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-semibold"><i class="bi bi-person-circle me-2"></i> Detail Remaja</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="detail-box">
            <div class="mb-3">
              <h6><i class="bi bi-person-fill text-success me-2"></i>Nama</h6>
              <p class="mb-0 fs-6 fw-semibold text-dark" id="modalNama"></p>
            </div>
            <hr>
            <div class="mb-3">
              <h6><i class="bi bi-geo-alt-fill text-danger me-2"></i>Alamat</h6>
              <p class="mb-0 fs-6 fw-semibold text-dark" id="modalAlamat"></p>
            </div>
            <hr>
            <div>
              <h6><i class="bi bi-telephone-fill text-primary me-2"></i>No HP</h6>
              <p class="mb-0 fs-6 fw-semibold text-dark" id="modalHP"></p>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light border-0">
          <button type="button" class="btn btn-outline-success px-4" data-bs-dismiss="modal">
            <i class="bi bi-check-circle me-1"></i> Tutup
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.addEventListener('DOMContentLoaded', () => {
      // Animasi header dan tabel
      document.getElementById('heroHeader').classList.add('show');
      setTimeout(() => document.querySelector('.dashboard-card').classList.add('show'), 300);

      const rows = document.querySelectorAll('tbody tr');
      rows.forEach((row, i) => {
        setTimeout(() => row.classList.add('show-row'), 400 + i * 120);
      });

      // Event klik nama remaja → tampilkan modal detail
      $('.nama-link').click(function(e){
        e.preventDefault();
        $('#modalNama').text($(this).data('nama'));
        $('#modalAlamat').text($(this).data('alamat') || 'Belum diisi');
        $('#modalHP').text($(this).data('hp') || 'Belum diisi');
        $('#detailModal').modal('show');
      });
    });
  </script>
</body>
</html>
