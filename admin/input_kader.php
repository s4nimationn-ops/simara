<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pw = $_POST['password'];

    if (!$nama || !$email || !$pw) {
        $msg = 'Lengkapi data.';
    } else {
        $q = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($q) > 0) {
            $msg = 'Email sudah ada.';
        } else {
            $hash = password_hash($pw, PASSWORD_DEFAULT);
            $insert = mysqli_query($conn, "INSERT INTO users (nama,no_hp,email,password,role) VALUES ('$nama', '$no_hp','$email','$hash','kader')");
            if ($insert) {
                echo "<script>
                        alert('Kader berhasil ditambahkan!');
                        window.location.href='biodata_kader.php';
                      </script>";
                exit;
            } else {
                $msg = 'Terjadi kesalahan saat menyimpan data.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tambah Kader</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding-top: 0;
      background-color: #ffffff;
      overflow-x: hidden;
    }

    /* ===== HERO SECTION ANIMASI ===== */
    .hero-section {
      background: linear-gradient(135deg, #007bff, #4facfe);
      color: #fff;
      padding: 100px 0 160px;
      text-align: center;
      position: relative;
      overflow: visible;
      z-index: 1;
      margin-top: 56px;

      opacity: 0;
      transform: translateY(-30px);
      transition: opacity 1s ease, transform 1s ease;
    }

    .hero-section.show {
      opacity: 1;
      transform: translateY(0);
    }

    /* ===== CARD ANIMASI ===== */
    .card {
      border-radius: 20px;
      opacity: 0;
      transform: translateY(50px);
      transition: opacity 1s ease 0.4s, transform 1s ease 0.4s;
    }

    .card.show {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>
<body>
  <!-- NAVBAR (langsung tampil tanpa animasi) -->
  <?php include 'navbar.php'; ?>

  <!-- HERO SECTION -->
  <div class="hero-section">
    <h1 class="fw-bold">Tambah Kader Posyandu</h1>
  </div>

  <!-- FORM TAMBAH KADER -->
  <div class="container my-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 600px;">
      <?php if($msg):?><div class="alert alert-info"><?=$msg?></div><?php endif;?>
      <form method="post">
        <div class="mb-3">
          <label for="nama" class="form-label">Nama</label>
          <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
          <label for="no_hp" class="form-label">Nomor Hp</label>
          <input type="text" class="form-control" id="no_hp" name="no_hp" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Simpan</button>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Saat halaman selesai dimuat, animasikan hero-section & card saja
    window.addEventListener('load', () => {
      document.querySelector('.hero-section').classList.add('show');
      document.querySelector('.card').classList.add('show');
    });
  </script>
</body>
</html>
