<?php
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../config/session.php';
cek_role(['kader']);

$kader_id = $_SESSION['user_id'];
$target = intval($_GET['uid'] ?? 0);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $tekanan = mysqli_real_escape_string($conn, $_POST['tekanan']);
    $riwayat = mysqli_real_escape_string($conn, $_POST['riwayat']);
    $hb = floatval($_POST['hemoglobin']);
    $stmt = mysqli_prepare($conn, "INSERT INTO pemeriksaan_kader (user_id,kader_id,tekanan_darah,deskripsi_riwayat,hemoglobin) VALUES (?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, 'iissd', $user_id, $kader_id, $tekanan, $riwayat, $hb);
    mysqli_stmt_execute($stmt);
    $msg = (mysqli_stmt_affected_rows($stmt) > 0) ? 'Data screening tersimpan.' : 'Gagal menyimpan.';
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Input Screening</title>
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
      text-align: center;
      border-bottom-left-radius: 50px;
      border-bottom-right-radius: 50px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      opacity: 0;
      transform: translateY(-40px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .hero-header.show {
      opacity: 1;
      transform: translateY(0);
    }

    /* Card form */
    .form-card {
      max-width: 600px;
      margin: 0 auto;
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .form-card.show {
      opacity: 1;
      transform: translateY(0);
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
  <h2 class="fw-bold mb-2">📋 Input Screening Kesehatan</h2>
  <p class="mb-0">Pastikan data pemeriksaan remaja diisi dengan benar.</p>
</div>

<!-- Form Input Screening -->
<div class="container py-5">
  <div class="card p-4 shadow-sm form-card">
    <h4 class="mb-3 text-primary fw-bold">Form Screening</h4>
    <?php if ($msg): ?><div class="alert alert-info"><?= $msg ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="user_id" value="<?= $target ?>">
      <div class="mb-3">
        <label class="form-label">Tekanan Darah</label>
        <input name="tekanan" class="form-control" placeholder="Contoh: 120/80 mmHg" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Deskripsi Riwayat Penyakit</label>
        <textarea name="riwayat" class="form-control" rows="3" placeholder="Masukkan riwayat penyakit (jika ada)"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Hemoglobin (g/dL)</label>
        <input name="hemoglobin" type="number" step="0.1" class="form-control" placeholder="Contoh: 13.5">
      </div>
      <button class="btn btn-primary w-100 mt-2">Simpan</button>
    </form>
  </div>
</div>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('heroHeader').classList.add('show');
    setTimeout(() => document.querySelector('.form-card').classList.add('show'), 300);
  });
</script>

</body>
</html>
