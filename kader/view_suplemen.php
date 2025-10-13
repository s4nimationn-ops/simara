<?php
require_once '../config/session.php';
require_once '../config/db.php';
cek_role(['kader']);

$kader_id = $_SESSION['user_id'];

// Ambil semua data pemberian suplemen oleh kader ini
$query = "
  SELECT ps.*, u.nama AS nama_remaja
  FROM pemberian_suplemen ps
  JOIN users u ON ps.user_id = u.id
  WHERE ps.kader_id = '$kader_id'
  ORDER BY ps.tanggal_pemberian DESC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Riwayat Pemberian Suplemen - SIMARA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background: #f8fafc;
  font-family: 'Poppins', sans-serif;
}
.card {
  border-radius: 15px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.table {
  background: white;
  border-radius: 10px;
  overflow: hidden;
}
.table th {
  background-color: #2563eb;
  color: white;
  text-align: center;
  vertical-align: middle;
}
.table td {
  text-align: center;
  vertical-align: middle;
}
.btn-primary {
  background-color: #2563eb;
  border: none;
}
.btn-primary:hover {
  background-color: #1e40af;
}
</style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
  <div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="text-primary fw-bold mb-0">💊 Riwayat Pemberian Suplemen</h4>
      <a href="input_suplemen.php" class="btn btn-primary btn-sm">+ Tambah Data</a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Remaja</th>
            <th>Tanggal</th>
            <th>Vitamin B Kompleks</th>
            <th>Vitamin D3</th>
            <th>Vitamin C</th>
            <th>Zinc</th>
            <th>Tablet Tambah Darah</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          if (mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_assoc($result)):
          ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama_remaja']); ?></td>
            <td><?= date('d/m/Y H:i', strtotime($row['tanggal_pemberian'])); ?></td>
            <td><?= $row['vit_bkomplek'] ? '✅' : '❌'; ?></td>
            <td><?= $row['vit_d3'] ? '✅' : '❌'; ?></td>
            <td><?= $row['vit_c'] ? '✅' : '❌'; ?></td>
            <td><?= $row['zinc'] ? '✅' : '❌'; ?></td>
            <td><?= $row['tablet_tambah_darah'] ? '✅' : '❌'; ?></td>
          </tr>
          <?php
            endwhile;
          else:
          ?>
          <tr>
            <td colspan="8" class="text-muted">Belum ada data pemberian suplemen.</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="text-end mt-3">
      <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
  </div>
</div>

</body>
</html>
