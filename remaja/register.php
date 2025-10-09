<?php
require_once __DIR__ . '/../config/db.php';
session_start();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim(mysqli_real_escape_string($conn, $_POST['nama']));
    $no_hp = trim(mysqli_real_escape_string($conn, $_POST['no_hp']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = $_POST['password'];

    if (!$nama || !$email || !$password) {
        $err = 'Semua kolom wajib diisi.';
    } else {
        $q = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($q) > 0) {
            $err = 'Email sudah digunakan.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = mysqli_query($conn, "INSERT INTO users (nama,email,password,role) VALUES ('$nama','$email','$hash','remaja')");
            if ($ins) {
                echo "<script>alert('Registrasi berhasil. Silakan login.');location.href='login.php';</script>"; 
                exit;
            } else {
                $err = 'Gagal registrasi.';
            }
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Remaja - SIMARA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #e6f0ff, #d2e8ff);
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .register-card {
      background: #fff;
      padding: 2.5rem;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 450px;
      animation: fadeIn 0.8s ease;
    }

    .register-card h4 {
      font-weight: 700;
      margin-bottom: 1rem;
      color: #0d6efd;
      text-align: center;
    }

    .input-group-text {
      background: transparent;
      border-right: none;
    }

    .form-control {
      border-left: none;
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #0d6efd;
    }

    .btn-register {
      background-color: #0d6efd;
      border: none;
      padding: 0.75rem;
      font-size: 1rem;
    }

    .btn-register:hover {
      background-color: #0b5ed7;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-15px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="register-card">
    <h4>Daftar Sebagai Remaja</h4>
    <?php if($err): ?><div class="alert alert-danger"><?=htmlspecialchars($err)?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="bi bi-person"></i></span>
        <input name="nama" class="form-control" placeholder="Nama Lengkap" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
        <input name="no_hp" type="no_hp" class="form-control" placeholder="Nomor Hp" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
        <input name="email" type="email" class="form-control" placeholder="Email" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="bi bi-lock"></i></span>
        <input name="password" type="password" class="form-control" placeholder="Password" required>
      </div>
      <button class="btn btn-register w-100">Daftar Akun</button>
      <p class="mt-3 text-center text-muted">
        Sudah punya akun? <a href="login.php" class="text-decoration-none">Masuk di sini</a>
      </p>
      <p class="text-center text-muted mt-3 mb-0">
          <a href="../index.php">Kembali ke Beranda</a>
      </p>
    </form>
  </div>
</body>
</html>
