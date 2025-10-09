<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);

// Ambil keyword pencarian jika ada
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Query ambil data kader
$sql = "SELECT * FROM users WHERE role='kader'";
if ($search) {
  $sql .= " AND (nama LIKE '%$search%' OR email LIKE '%$search%' OR no_hp LIKE '%$search%')";
}
$sql .= " ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Biodata Kader</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { 
      padding-top: 56px; 
      background-color: #f8f9fa; 
      overflow-x: hidden;
    }
    .table-container { 
      margin-top: 30px; 
      opacity: 0;
      transform: translateY(50px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .table-container.show {
      opacity: 1;
      transform: translateY(0);
    }
    .page-title {
      opacity: 0;
      transform: translateY(-30px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .page-title.show {
      opacity: 1;
      transform: translateY(0);
    }
    .search-form {
      opacity: 0;
      transform: translateY(-30px);
      transition: opacity 0.8s ease 0.2s, transform 0.8s ease 0.2s;
    }
    .search-form.show {
      opacity: 1;
      transform: translateY(0);
    }
    .table thead th { background-color: #007bff; color: #fff; }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container table-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="fw-bold text-primary page-title">Biodata Kader</h1>
      <form class="d-flex search-form" method="get">
        <input class="form-control me-2" type="search" name="search" placeholder="Cari nama/email/no HP" value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary" type="submit">Cari</button>
      </form>
    </div>

    <div class="table-responsive shadow-lg rounded">
      <table class="table table-striped table-hover align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Email</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1;
          if (mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_assoc($result)):
          ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['no_hp']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
              <a href="edit_kader.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="hapus_kader.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
          </tr>
          <?php 
            endwhile;
          else:
          ?>
          <tr>
            <td colspan="5" class="text-center">Belum ada data kader</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    window.addEventListener('load', () => {
      document.querySelector('.page-title').classList.add('show');
      document.querySelector('.search-form').classList.add('show');
      document.querySelector('.table-container').classList.add('show');
    });
  </script>
</body>
</html>
