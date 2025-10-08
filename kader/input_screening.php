<?php
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../config/session.php';
cek_role(['kader']);
$kader_id = $_SESSION['user_id'];
$target = intval($_GET['uid'] ?? 0);
$msg='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $user_id = intval($_POST['user_id']);
    $tekanan = mysqli_real_escape_string($conn,$_POST['tekanan']);
    $riwayat = mysqli_real_escape_string($conn,$_POST['riwayat']);
    $hb = floatval($_POST['hemoglobin']);
    $stmt = mysqli_prepare($conn, "INSERT INTO pemeriksaan_kader (user_id,kader_id,tekanan_darah,deskripsi_riwayat,hemoglobin) VALUES (?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt,'iissd',$user_id,$kader_id,$tekanan,$riwayat,$hb);
    mysqli_stmt_execute($stmt);
    $msg = (mysqli_stmt_affected_rows($stmt)>0)?'Data screening tersimpan.':'Gagal menyimpan.';
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Input Screening</title>
<link href="/assets/css/style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><?php include 'navbar.php'; ?>
<div class="container py-5"><div class="card p-4">
  <h4>Input Screening Kesehatan</h4>
  <?php if($msg):?><div class="alert alert-info"><?=$msg?></div><?php endif; ?>
  <form method="post">
    <input type="hidden" name="user_id" value="<?= $target ?>">
    <div class="mb-3"><label>Tekanan Darah</label><input name="tekanan" class="form-control" required></div>
    <div class="mb-3"><label>Deskripsi Riwayat Penyakit</label><textarea name="riwayat" class="form-control" rows="3"></textarea></div>
    <div class="mb-3"><label>Hemoglobin (g/dL)</label><input name="hemoglobin" type="number" step="0.1" class="form-control"></div>
    <button class="btn btn-primary">Simpan</button>
  </form>
</div></div></body></html>
