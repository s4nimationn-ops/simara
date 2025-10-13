<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['kader']);
include 'navbar.php';

// Query disesuaikan dengan struktur database kamu (simara_db.sql)
$query = "
SELECT 
  u.id, 
  u.nama, 
  u.email, 
  u.role,
  p.tinggi_cm, 
  p.berat_kg, 
  p.lingkar_lengan_cm,
  p.tekanan_darah, 
  p.hemoglobin,
  p.tanggal_periksa,
  i.hasil_imt,
  i.status_imt,
  m.sarapan_per_minggu,
  m.buah_sayur_per_minggu,
  m.liter_air_per_hari,
  a.olahraga_per_minggu,
  a.gadget_jam_per_hari
FROM users u
LEFT JOIN pemeriksaan_kader p ON u.id = p.user_id
LEFT JOIN data_imt i ON u.id = i.user_id
LEFT JOIN data_pola_makan m ON u.id = m.user_id
LEFT JOIN data_aktivitas a ON u.id = a.user_id
WHERE u.role = 'remaja'
ORDER BY u.nama ASC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Remaja - SIMARA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8fafc; font-family: 'Poppins', sans-serif; }
    .navbar-brand { font-weight: bold; color: #f8fafc !important; }
    .card { border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .table th { white-space: nowrap; }
    .modal-header { background: #0d6efd; color: white; }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="card p-4">
    <h4 class="fw-bold text-primary mb-3">📋 Daftar Remaja</h4>
    <div class="table-responsive">
      <table id="remajaTable" class="table table-striped table-hover align-middle">
        <thead class="table-primary">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Tinggi (cm)</th>
            <th>Berat (kg)</th>
            <th>IMT</th>
            <th>Status IMT</th>
            <th>Tekanan Darah</th>
            <th>Hemoglobin</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): $no=1; ?>
            <?php while($row=mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= $row['tinggi_cm'] ?: '-' ?></td>
                <td><?= $row['berat_kg'] ?: '-' ?></td>
                <td><?= $row['hasil_imt'] ?: '-' ?></td>
                <td><?= $row['status_imt'] ?: '-' ?></td>
                <td><?= $row['tekanan_darah'] ?: '-' ?></td>
                <td><?= $row['hemoglobin'] ?: '-' ?></td>
                <td>
                  <button class="btn btn-outline-info btn-sm detail-btn" data-id="<?= $row['id'] ?>">
                    Detail
                  </button>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="10" class="text-center text-muted">Belum ada data remaja.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Data Remaja</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="detailContent" class="p-3 text-center text-muted">Memuat data...</div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function(){
  $('#remajaTable').DataTable({ pageLength: 10, language: { search: "Cari:" } });

  $('.detail-btn').click(function(){
    let id = $(this).data('id');
    $('#detailContent').html('<div class="py-4 text-center">🔄 Memuat data...</div>');
    $('#detailModal').modal('show');
    $.get('get_remaja.php', {id: id}, function(data){
      $('#detailContent').html(data);
    });
  });
});
</script>

</body>
</html>
