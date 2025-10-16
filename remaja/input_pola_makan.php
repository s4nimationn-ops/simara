<?php
require_once '../config/session.php';
require_once '../config/db.php';
cek_role(['remaja']);

$user_id = $_SESSION['user_id'];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sarapan = intval($_POST['sarapan_per_minggu']);
    $buah_sayur = intval($_POST['buah_sayur_per_minggu']);
    $liter_air = floatval($_POST['liter_air_per_hari']);

    // Validasi backend: nilai harus lebih dari 0
    if ($sarapan > 0 && $buah_sayur > 0 && $liter_air > 0) {
        $stmt = $conn->prepare("INSERT INTO data_pola_makan (user_id, sarapan_per_minggu, buah_sayur_per_minggu, liter_air_per_hari) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $user_id, $sarapan, $buah_sayur, $liter_air);
        $stmt->execute();
        $msg = '<div class="alert alert-success">✅ Data pola makan berhasil disimpan!</div>';
    } else {
        $msg = '<div class="alert alert-danger">⚠️ Semua nilai harus lebih dari 0.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Pola Makan - SIMARA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background-color: #f8f9fa;
  font-family: 'Poppins', sans-serif;
}
.card {
  border-radius: 15px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.btn-primary {
  background-color: #2563eb;
  border: none;
}
.btn-primary:hover {
  background-color: #1e40af;
}
</style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container py-5">
  <div class="col-md-6 mx-auto">
    <div class="card p-4">
      <h4 class="text-primary fw-bold mb-3">🍎 Form Input Pola Makan</h4>
      <?= $msg; ?>
      <form method="POST" onsubmit="return validateInput()">
        <div class="mb-3">
          <label class="form-label fw-semibold">Berapa kali sarapan dalam seminggu?</label>
          <input type="number" name="sarapan_per_minggu" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Berapa kali konsumsi buah dan sayur dalam seminggu?</label>
          <input type="number" name="buah_sayur_per_minggu" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Berapa liter air putih dalam sehari?</label>
          <input type="number" name="liter_air_per_hari" class="form-control" step="0.1" min="0.1" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
      </form>
    </div>
  </div>
</div>

<script>
function validateInput() {
  const sarapan = parseFloat(document.querySelector('[name="sarapan_per_minggu"]').value);
  const buah = parseFloat(document.querySelector('[name="buah_sayur_per_minggu"]').value);
  const air = parseFloat(document.querySelector('[name="liter_air_per_hari"]').value);

  if (sarapan <= 0 || buah <= 0 || air <= 0) {
    alert('Semua nilai harus lebih dari 0!');
    return false;
  }
  return true;
}
</script>

</body>
</html>
