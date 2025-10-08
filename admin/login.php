<?php
require_once __DIR__ . '/../config/db.php';
session_start();
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $pw = $_POST['password'];
    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND role='admin' LIMIT 1");
    if ($u = mysqli_fetch_assoc($q)) {
        if (password_verify($pw,$u['password'])) {
            $_SESSION['user_id']=$u['id']; $_SESSION['role']=$u['role']; $_SESSION['nama']=$u['nama'];
            header('Location: dashboard.php'); exit;
        } else $err='Password salah.';
    } else $err='Admin tidak ditemukan.';
}
?>
<!doctype html>
<html lang="id"><head><meta charset="utf-8"><title>Admin Login</title>
<link href="/assets/css/style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container py-5"><div class="row justify-content-center"><div class="col-md-5">
  <div class="card p-4">
    <h4>Login Admin</h4>
    <?php if($err): ?><div class="alert alert-danger"><?=$err?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label>Email</label><input name="email" class="form-control" required></div>
      <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
      <button class="btn btn-primary w-100">Masuk</button>
    </form>
  </div>
</div></div></div>
</body></html>
