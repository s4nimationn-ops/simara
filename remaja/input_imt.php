<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['remaja']);
$uid = $_SESSION['user_id'];
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tinggi = floatval($_POST['tinggi']);
    $berat = floatval($_POST['berat']);
    if ($tinggi <= 0 || $berat <= 0) $msg = 'Tinggi & berat harus lebih besar dari 0.';
    else {
        $imt = $berat / (($tinggi/100)*($tinggi/100));
        $status = ($imt < 18.5) ? 'Kurus' : (($imt < 25) ? 'Normal' : 'Kelebihan berat badan');
        $stmt = mysqli_prepare($conn, "INSERT INTO data_imt (user_id, tinggi_cm, berat_kg, hasil_imt, status_imt) VALUES (?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, 'iddss', $uid, $tinggi, $berat, $imt, $status);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_affected_rows($stmt) > 0) { $msg = 'Data IMT tersimpan.'; }
        else $msg = 'Gagal menyimpan.';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Input IMT - SIMARA</title>
  <link href="/assets/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">
  <div class="card p-4">
    <h4>Input Indeks Massa Tubuh (IMT)</h4>
    <?php if($msg): ?><div class="alert alert-info"><?=$msg?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label>Tinggi Badan (cm)</label><input name="tinggi" type="number" step="0.1" class="form-control" required></div>
      <div class="mb-3"><label>Berat Badan (kg)</label><input name="berat" type="number" step="0.1" class="form-control" required></div>
      <button class="btn btn-primary">Simpan</button>
      <a class="btn btn-secondary" href="dashboard.php">Kembali</a>
    </form>
  </div>
</div>
</body>
</html>
