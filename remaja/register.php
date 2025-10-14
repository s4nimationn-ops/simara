<?php
require_once '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $kecamatan_id = intval($_POST['kecamatan_id']);
    $kelurahan_id = intval($_POST['kelurahan_id']);
    $sekolah_id = intval($_POST['sekolah_id']);

    // simpan ke tabel users
    $query = "INSERT INTO users (nama, email, password, role, kecamatan_id, kelurahan_id, sekolah_id)
              VALUES ('$nama', '$email', '$password', 'remaja', '$kecamatan_id', '$kelurahan_id', '$sekolah_id')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
        header("Location: login.php");
        exit;
    } else {
        $error = "Terjadi kesalahan: " . mysqli_error($conn);
    }
}

// ambil daftar kecamatan
$q_kecamatan = mysqli_query($conn, "SELECT * FROM kecamatan ORDER BY nama_kecamatan ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Remaja - SIMARA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body {
      background: #f9fafb;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <h3 class="text-center text-primary mb-4 fw-bold">Daftar Akun Remaja</h3>

        <?php if (isset($error)): ?>
          <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Kecamatan</label>
            <select id="kecamatan" name="kecamatan_id" class="form-select" required>
              <option value="">-- Pilih Kecamatan --</option>
              <?php while ($k = mysqli_fetch_assoc($q_kecamatan)): ?>
                <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kecamatan']); ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Kelurahan</label>
            <select id="kelurahan" name="kelurahan_id" class="form-select" required>
              <option value="">-- Pilih Kelurahan --</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Sekolah</label>
            <select id="sekolah" name="sekolah_id" class="form-select" required>
              <option value="">-- Pilih Sekolah --</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary w-100 mt-3">Daftar</button>
          <p class="text-center mt-3">Sudah punya akun? <a href="login.php">Login</a></p>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

  // Load kelurahan berdasarkan kecamatan
  $('#kecamatan').on('change', function() {
    var kecamatan_id = $(this).val();
    if (kecamatan_id) {
      $.ajax({
        url: 'get_kelurahan.php',
        type: 'POST',
        data: { kecamatan_id: kecamatan_id },
        success: function(data) {
          $('#kelurahan').html(data);
        }
      });
    } else {
      $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');
    }
  });

  // Load semua sekolah (global)
  $.ajax({
    url: 'get_sekolah.php',
    type: 'GET',
    success: function(data) {
      $('#sekolah').html(data);
    }
  });

});
</script>

</body>
</html>
