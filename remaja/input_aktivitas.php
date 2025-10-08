<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['remaja']);
$uid = $_SESSION['user_id'];
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $olahraga = intval($_POST['olahraga']);
    $gadget = floatval($_POST['gadget']);
    $stmt = mysqli_prepare($conn, "INSERT INTO data_aktivitas (user_id,olahraga_per_minggu,gadget_jam_per_hari) VALUES (?,?,?)");
    mysqli_stmt_bind_param($stmt,'iid',$uid,$olahraga,$gadget);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt)>0) $msg='Data aktivitas tersimpan.';
    else $msg='Gagal menyimpan.';
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Input Aktivitas - SIMARA</title>
  <link href="/assets/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">
  <div class="card p-4">
    <h4>Form Aktivitas Olahraga</h4>
    <?php if($msg): ?><div class="alert alert-info"><?=$msg?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label>Berapa kali olahraga dalam seminggu?</label><input name="olahraga" type="number" min="0" class="form-control" required></div>
      <div class="mb-3"><label>Berapa jam menggunakan gadget dalam sehari?</label><input name="gadget" type="number" step="0.1" class="form-control" required></div>
      <button class="btn btn-primary">Simpan</button>
      <a class="btn btn-secondary" href="dashboard.php">Kembali</a>
    </form>
  </div>
</div>
</body>
</html>
