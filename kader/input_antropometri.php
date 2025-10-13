<?php
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../config/session.php';
cek_role(['kader']);

$kader_id = $_SESSION['user_id'];
$nama = $_SESSION['nama'];
$target = intval($_GET['uid'] ?? 0);
$msg='';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $tinggi = floatval($_POST['tinggi']);
    $berat = floatval($_POST['berat']);
    $lingkar = floatval($_POST['lingkar']);

    $stmt = mysqli_prepare($conn, "INSERT INTO pemeriksaan_kader (user_id,kader_id,tinggi_cm,berat_kg,lingkar_lengan_cm) VALUES (?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt,'iiidd',$user_id,$kader_id,$tinggi,$berat,$lingkar);
    mysqli_stmt_execute($stmt);

    $msg = (mysqli_stmt_affected_rows($stmt)>0)?'✅ Data antropometri tersimpan.':'❌ Gagal menyimpan.';
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Input Antropometri</title>
  <link href="/assets/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }

    /* Hero Header */
    .hero-header {
      background: linear-gradient(135deg, #1e824c, #27ae60);
      color: #fff;
      padding: 60px 20px;
      border-bottom-left-radius: 50px;
      border-bottom-right-radius: 50px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      opacity: 0;
      transform: translateY(-60px) scale(0.95);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .hero-header.show {
      opacity: 1;
      transform: translateY(0) scale(1);
    }

    /* Card form animasi */
    .form-card {
      max-width: 500px;
      margin: 40px auto;
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .form-card.show {
      opacity: 1;
      transform: translateY(0);
    }

    .form-label {
      font-weight: 600;
    }
    .form-control {
      padding: 10px;
      border-radius: 8px;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <!-- Hero Header -->
  <div class="hero-header" id="heroHeader">
    <h2 class="fw-bold mb-2">Input Data Antropometri 📝</h2>
    <p class="mb-0">Oleh Kader: <?= htmlspecialchars($nama) ?></p>
  </div>

  <!-- Form Box -->
  <div class="container">
    <div class="card p-4 shadow form-card" id="formCard">
      <h4 class="mb-3 text-primary fw-bold">📌 Form Pemeriksaan</h4>
      <?php if($msg): ?>
        <div class="alert alert-info"><?= $msg ?></div>
      <?php endif; ?>

      <form method="post">
        <input type="hidden" name="user_id" value="<?= $target ?>">
        <div class="mb-3">
          <label class="form-label">Tinggi Badan (cm)</label>
          <input name="tinggi" type="number" step="0.1" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Berat Badan (kg)</label>
          <input name="berat" type="number" step="0.1" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Lingkar Lengan (cm)</label>
          <input name="lingkar" type="number" step="0.1" class="form-control" required>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a class="btn btn-secondary" href="dashboard.php">Kembali</a>
      </form>
    </div>
  </div>

  <script>
    window.addEventListener('DOMContentLoaded', () => {
      // animasi hero header (fade + slide + scale)
      const hero = document.getElementById('heroHeader');
      hero.classList.add('show');

      // animasi card form
      setTimeout(() => {
        document.getElementById('formCard').classList.add('show');
      }, 400);
    });
  </script>
</body>
</html>
