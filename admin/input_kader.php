<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);
$msg='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $nama = mysqli_real_escape_string($conn,$_POST['nama']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $pw = $_POST['password'];
    if (!$nama || !$email || !$pw) $msg='Lengkapi data.';
    else {
        $q = mysqli_query($conn,"SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($q)>0) $msg='Email sudah ada.';
        else {
            $hash = password_hash($pw, PASSWORD_DEFAULT);
            mysqli_query($conn,"INSERT INTO users (nama,email,password,role) VALUES ('$nama','$email','$hash','kader')");
            $msg='Kader berhasil ditambahkan.';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Tambah Kader</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* ===== NAVBAR FIXED ===== */
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background: linear-gradient(90deg, #005cff, #2f9bff);
  z-index: 3000;
  box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.navbar a, .navbar-brand, .navbar-nav .nav-link {
  color: #fff !important;
}

.navbar a:hover, .navbar-nav .nav-link.active {
  color: #ffeb3b !important;
}

body {
  margin: 0;
  padding-top: 70px; /* memberi ruang di bawah navbar */
  background-color: #ffffff;
  overflow-x: hidden;
}


/* ===== HERO SECTION ===== */
.hero-section {
  background: linear-gradient(135deg, #007bff, #4facfe);
  color: #fff;
  padding: 100px 0 160px;
  text-align: center;
  position: relative;
  overflow: visible;
  z-index: 1;
}

.hero-section h1 {
  font-size: 3rem;
  font-weight: 700;
  text-shadow: 0 3px 6px rgba(0,0,0,0.25);
}

/* ===== GELOMBANG ===== */
.custom-shape-divider-bottom-hero {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 200%;
  overflow: hidden;
  line-height: 0;
  z-index: 0;
}

.custom-shape-divider-bottom-hero svg {
  position: absolute;
  width: 200%;
  height: 160px;
}

.shape-fill {
  fill: url(#blueGradient);
}

.wave1 {
  animation: waveMove 12s linear infinite;
  opacity: 0.8;
}
.wave2 {
  animation: waveMove2 16s linear infinite;
  opacity: 0.5;
}

@keyframes waveMove {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
@keyframes waveMove2 {
  0% { transform: translateX(0); }
  100% { transform: translateX(50%); }
}

/* ===== CONTAINER & CARD ===== */
.container {
  position: relative;
  max-width: 100%;
  width: 100%;
  padding: 0 20px;
  margin: -100px auto 60px;
  z-index: 10;
}

.card {
  max-width: 600px;
  margin: 0 auto;
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
  border: none;
  padding: 30px 25px;
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.25);
}
</style>
</head>

<body>
  <?php include 'navbar.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- ===== HERO SECTION ===== -->
  <section class="hero-section">
    <h1>Tambah Kader Posyandu</h1>
    <div class="custom-shape-divider-bottom-hero">
      <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="wave1">
        <path d="M0,40 C300,120 900,-40 1200,40 L1200,120 L0,120 Z" class="shape-fill"></path>
      </svg>
      <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="wave2">
        <path d="M0,60 C400,140 800,-20 1200,60 L1200,120 L0,120 Z" class="shape-fill"></path>
      </svg>
    </div>
  </section>

  <!-- ===== FORM TAMBAH KADER ===== -->
  <div class="container">
    <div class="card p-4">
      <?php if($msg):?>
        <div class="alert alert-info"><?=$msg?></div>
      <?php endif;?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input name="email" type="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input name="password" type="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100">Simpan</button>
      </form>
    </div>
  </div>
</body>
</html>
