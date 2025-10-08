<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['remaja']);
$uid = $_SESSION['user_id'];
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sarapan = intval($_POST['sarapan']);
    $buah = intval($_POST['buah']);
    $air = floatval($_POST['air']);
    $stmt = mysqli_prepare($conn, "INSERT INTO data_pola_makan (user_id,sarapan_per_minggu,buah_sayur_per_minggu,liter_air_per_hari) VALUES (?,?,?,?)");
    mysqli_stmt_bind_param($stmt,'iiid',$uid,$sarapan,$buah,$air);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt)>0) $msg='Data pola makan tersimpan.';
    else $msg='Gagal menyimpan.';
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Input Pola Makan - SIMARA</title>
  <link href="/assets/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">
  <div class="card p-4">
    <h4>Form Pola Makan</h4>
    <?php if($msg): ?><div class="alert alert-info"><?=$msg?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label>Berapa kali sarapan dalam seminggu?</label><input name="sarapan" type="number" min="0" class="form-control" required></div>
      <div class="mb-3"><label>Berapa kali konsumsi buah & sayur dalam seminggu?</label><input name="buah" type="number" min="0" class="form-control" required></div>
      <div class="mb-3"><label>Berapa liter minum air putih dalam sehari?</label><input name="air" type="number" step="0.1" class="form-control" required></div>
      <button class="btn btn-primary">Simpan</button>
      <a class="btn btn-secondary" href="dashboard.php">Kembali</a>
    </form>
  </div>
</div>
</body>
</html>
