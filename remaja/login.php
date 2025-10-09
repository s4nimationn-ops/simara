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
  <title>Login - SIMARA</title>
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

    .login-card {
      background: #fff;
      padding: 2.5rem;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      animation: fadeIn 0.8s ease;
    }

    .login-card h4 {
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

    .btn-login {
      background-color: #0d6efd;
      border: none;
      padding: 0.75rem;
      font-size: 1rem;
      font-weight: 500;
    }

    .btn-login:hover {
      background-color: #0b5ed7;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .text-muted a {
      color: #0d6efd;
      text-decoration: none;
      font-weight: 500;
    }

    .text-muted a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h4><i class="bi bi-recycle me-2"></i>SIMARA</h4>
    <?php if($err): ?>
      <div class="alert alert-danger text-center py-2"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="bi bi-lock"></i></span>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button class="btn btn-login w-100 text-white" type="submit">Masuk</button>
    </form>
    <p class="text-center text-muted mt-3 mb-0">
      Belum punya akun? <a href="register.php">Daftar</a>
    </p>
    <p class="text-center text-muted mt-3 mb-0">
          <a href="../index.php">Kembali ke Beranda</a>
    </p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
