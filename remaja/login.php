<?php
require_once __DIR__ . '/../config/db.php';
session_start();
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pw = $_POST['password'];
    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");
    if ($u = mysqli_fetch_assoc($q)) {
        if (password_verify($pw, $u['password'])) {
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['role'] = $u['role'];
            $_SESSION['nama'] = $u['nama'];
            // redirect by role
            if ($u['role'] === 'remaja') header('Location: dashboard.php');
            elseif ($u['role'] === 'kader') header('Location: ../kader/dashboard.php');
            else header('Location: ../admin/dashboard.php');
            exit;
        } else $err = 'Kata sandi salah.';
    } else $err = 'Akun tidak ditemukan.';
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login Remaja - SIMARA</title>
  <link href="/assets/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card p-4">
        <h4 class="mb-3">Login</h4>
        <?php if($err): ?><div class="alert alert-danger"><?=htmlspecialchars($err)?></div><?php endif; ?>
        <form method="post">
          <div class="mb-3"><label>Email</label><input name="email" class="form-control" required></div>
          <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
          <button class="btn btn-primary w-100">Masuk</button>
          <p class="mt-3 text-muted">Belum punya akun? <a href="register.php">Daftar</a></p>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
