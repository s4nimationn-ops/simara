<?php
require_once '../config/session.php';
require_once '../config/db.php';
cek_role(['remaja']);
$user_id = $_SESSION['user_id'];
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
    background-color: #f9fafb;
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
    background-color: #1d4ed8;
  }
  .error-text {
    color: red;
    font-size: 0.9rem;
    display: none;
  }
</style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <h4 class="text-primary fw-bold mb-4 text-center">🍎 Form Pola Makan Remaja</h4>

        <form action="proses_input_pola_makan.php" method="POST" onsubmit="return validateAir()">
          <!-- Sarapan -->
          <div class="mb-3">
            <label class="form-label">Berapa kali sarapan dalam seminggu?</label>
            <input type="number" name="sarapan_per_minggu" class="form-control" min="0" required>
          </div>

          <!-- Buah & Sayur -->
          <div class="mb-3">
            <label class="form-label">Berapa kali konsumsi buah & sayur dalam seminggu?</label>
            <input type="number" name="buah_sayur_per_minggu" class="form-control" min="0" required>
          </div>

          <!-- Air putih -->
          <div class="mb-3">
            <label class="form-label">Berapa liter minum air putih dalam sehari?</label>
            <input type="number" step="0.1" name="liter_air_per_hari" id="liter_air_per_hari" class="form-control" min="0" required>
            <div id="error_air" class="error-text">Nilai air putih tidak boleh 0.</div>
          </div>

          <div class="d-flex justify-content-between">
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script>
function validateAir() {
  const air = parseFloat(document.getElementById('liter_air_per_hari').value);
  const errorText = document.getElementById('error_air');

  if (air <= 0) {
    errorText.style.display = 'block';
    return false;
  } else {
    errorText.style.display = 'none';
    return true;
  }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
