<?php
require_once __DIR__ . '/../config/db.php';
session_start();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim(mysqli_real_escape_string($conn, $_POST['nama']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = $_POST['password'];

    if (!$nama || !$email || !$password) $err = 'Semua kolom wajib diisi.';
    else {
        $q = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($q) > 0) $err = 'Email sudah digunakan.';
        else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = mysqli_query($conn, "INSERT INTO users (nama,email,password,role) VALUES ('$nama','$email','$hash','remaja')");
            if ($ins) {
                echo "<script>alert('Registrasi berhasil. Silakan login.');location.href='login.php';</script>"; exit;
            } else $err = 'Gagal registrasi.';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Remaja - SIMARA</title>
  <link href="/assets/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <h4 class="mb-3">Daftar Sebagai Remaja</h4>
        <?php if($err): ?><div class="alert alert-danger"><?=htmlspecialchars($err)?></div><?php endif; ?>
        <form method="post">
          <div class="mb-3"><label>Nama</label><input name="nama" class="form-control" required></div>
          <div class="mb-3"><label>Email</label><input name="email" type="email" class="form-control" required></div>
          <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
          <button class="btn btn-primary w-100">Daftar</button>
          <p class="mt-3 text-muted">Sudah punya akun? <a href="login.php">Login</a></p>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
