<?php
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../config/session.php';
cek_role(['kader']);
$kader_id = $_SESSION['user_id'];
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
    $msg = (mysqli_stmt_affected_rows($stmt)>0)?'Data antropometri tersimpan.':'Gagal menyimpan.';
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Input Antropometri</title>
<link href="/assets/css/style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><?php include 'navbar.php'; ?>
<div class="container py-5"><div class="card p-4">
  <h4>Input Antropometri</h4>
  <?php if($msg):?><div class="alert alert-info"><?=$msg?></div><?php endif; ?>
  <form method="post">
    <input type="hidden" name="user_id" value="<?= $target ?>">
    <div class="mb-3"><label>Tinggi Badan (cm)</label><input name="tinggi" step="0.1" class="form-control" required></div>
    <div class="mb-3"><label>Berat Badan (kg)</label><input name="berat" step="0.1" class="form-control" required></div>
    <div class="mb-3"><label>Lingkar Lengan (cm)</label><input name="lingkar" step="0.1" class="form-control" required></div>
    <button class="btn btn-primary">Simpan</button>
  </form>
</div></div></body></html>
