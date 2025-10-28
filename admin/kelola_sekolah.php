<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);
$nama = $_SESSION['nama'];

$q = mysqli_query($conn, "
  SELECT sekolah.id, sekolah.nama_sekolah, kelurahan.nama_kelurahan
  FROM sekolah
  JOIN kelurahan ON sekolah.kelurahan_id = kelurahan.id
  ORDER BY kelurahan.nama_kelurahan, sekolah.nama_sekolah ASC
");

$q_kelurahan = mysqli_query($conn, "SELECT * FROM kelurahan ORDER BY nama_kelurahan ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Sekolah - SIMARA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
  body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; padding-top: 70px; }
  .card { border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
  .btn-primary { background-color: #007bff; border: none; }
  .btn-primary:hover { background-color: #0056b3; }
  .modal-dialog { margin-top: 80px !important; }
</style>
</head>
<body>
<?php include 'navbar.php'; ?>

<?php if (isset($_GET['status'])): ?>
<div class="position-fixed end-0 p-3" style="top: 80px; z-index: 2000;">
  <div id="toastSimara" class="toast align-items-center text-white 
    <?php 
      if ($_GET['status']=='success') echo 'bg-success';
      elseif ($_GET['status']=='updated') echo 'bg-warning';
      elseif ($_GET['status']=='deleted') echo 'bg-danger';
    ?> 
    border-0 shadow-lg fade show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body fw-semibold">
        <?php
          if ($_GET['status']=='success') echo '✅ Data berhasil ditambahkan!';
          elseif ($_GET['status']=='updated') echo '✏️ Data berhasil diperbarui!';
          elseif ($_GET['status']=='deleted') echo '🗑️ Data berhasil dihapus!';
        ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script>
  // Inisialisasi toast
  const toastEl = document.getElementById('toastSimara');
  const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
  toast.show();
</script>
<?php endif; ?>


<div class="container mt-4">
  <div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="fw-bold text-primary mb-0">🏫 Kelola Sekolah</h4>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Sekolah</button>
    </div>

    <table id="tabelSekolah" class="table table-striped table-bordered align-middle">
      <thead class="table-primary">
        <tr class="text-center">
          <th>No</th>
          <th>Nama Sekolah</th>
          <th>Kelurahan</th>
          <th width="20%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; while($r=mysqli_fetch_assoc($q)): ?>
        <tr>
          <td class="text-center"><?= $no++; ?></td>
          <td><?= htmlspecialchars($r['nama_sekolah']); ?></td>
          <td><?= htmlspecialchars($r['nama_kelurahan']); ?></td>
          <td class="text-center">
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit"
              data-id="<?= $r['id']; ?>" data-nama="<?= htmlspecialchars($r['nama_sekolah']); ?>">
              Edit
            </button>
            <a href="proses_sekolah.php?hapus=<?= $r['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="proses_sekolah.php" class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Tambah Sekolah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama Sekolah</label>
          <input type="text" name="nama_sekolah" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Kelurahan</label>
          <select name="kelurahan_id" class="form-select" required>
            <option value="">-- Pilih Kelurahan --</option>
            <?php while($kl=mysqli_fetch_assoc($q_kelurahan)): ?>
              <option value="<?= $kl['id']; ?>"><?= htmlspecialchars($kl['nama_kelurahan']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="proses_sekolah.php" class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Edit Sekolah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit_id">
        <div class="mb-3">
          <label class="form-label">Nama Sekolah</label>
          <input type="text" name="nama_sekolah" id="edit_nama" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Kelurahan</label>
          <select name="kelurahan_id" id="edit_kelurahan" class="form-select" required>
            <option value="">-- Pilih Kelurahan --</option>
            <?php mysqli_data_seek($q_kelurahan,0); while($kc=mysqli_fetch_assoc($q_kelurahan)): ?>
              <option value="<?= $kc['id']; ?>"><?= htmlspecialchars($kc['nama_kelurahan']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="edit" class="btn btn-warning text-white">Perbarui</button>
      </div>
    </form>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
  new DataTable('#tabelSekolah');
</script>
</body>
</html>
