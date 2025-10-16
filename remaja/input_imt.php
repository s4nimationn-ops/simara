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
<title>Input IMT - SIMARA</title>
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
  #status_imt {
    font-weight: 600;
    text-transform: uppercase;
  }
</style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <h4 class="text-primary fw-bold mb-4 text-center">⚖️ Form Indeks Massa Tubuh</h4>

        <form action="proses_input_imt.php" method="POST" onsubmit="return validateIMT()">
          <div class="mb-3">
            <label for="tinggi_cm" class="form-label">Tinggi Badan (cm)</label>
            <input type="number" name="tinggi_cm" id="tinggi_cm" class="form-control" min="1" required>
            <div id="error_tinggi" class="error-text">Tinggi badan tidak boleh 0 atau negatif.</div>
          </div>

          <div class="mb-3">
            <label for="berat_kg" class="form-label">Berat Badan (kg)</label>
            <input type="number" name="berat_kg" id="berat_kg" class="form-control" min="1" required>
            <div id="error_berat" class="error-text">Berat badan tidak boleh 0 atau negatif.</div>
          </div>

          <div class="mb-3">
            <label for="hasil_imt" class="form-label">Hasil IMT (otomatis)</label>
            <input type="text" id="hasil_imt" class="form-control bg-light" readonly>
          </div>

          <div class="mb-3">
            <label for="status_imt" class="form-label">Status IMT</label>
            <input type="text" id="status_imt" class="form-control bg-light text-center" readonly>
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
function hitungIMT() {
  const tinggi = parseFloat(document.getElementById('tinggi_cm').value);
  const berat = parseFloat(document.getElementById('berat_kg').value);
  const hasilInput = document.getElementById('hasil_imt');
  const statusInput = document.getElementById('status_imt');

  if (tinggi > 0 && berat > 0) {
    const tinggiMeter = tinggi / 100;
    const imt = berat / (tinggiMeter * tinggiMeter);
    hasilInput.value = imt.toFixed(2);

    let status = '';
    let warna = '';

    if (imt < 18.5) {
      status = 'Kurus';
      warna = 'text-primary';
    } else if (imt >= 18.5 && imt < 25) {
      status = 'Normal';
      warna = 'text-success';
    } else if (imt >= 25 && imt < 30) {
      status = 'Gemuk';
      warna = 'text-warning';
    } else {
      status = 'Obesitas';
      warna = 'text-danger';
    }

    statusInput.value = status;
    statusInput.className = `form-control bg-light text-center fw-semibold ${warna}`;
  } else {
    hasilInput.value = '';
    statusInput.value = '';
    statusInput.className = 'form-control bg-light text-center';
  }
}

// Validasi input sebelum submit
function validateIMT() {
  const tinggi = parseFloat(document.getElementById('tinggi_cm').value);
  const berat = parseFloat(document.getElementById('berat_kg').value);
  const errorTinggi = document.getElementById('error_tinggi');
  const errorBerat = document.getElementById('error_berat');
  let valid = true;

  if (tinggi <= 0) {
    errorTinggi.style.display = 'block';
    valid = false;
  } else {
    errorTinggi.style.display = 'none';
  }

  if (berat <= 0) {
    errorBerat.style.display = 'block';
    valid = false;
  } else {
    errorBerat.style.display = 'none';
  }

  return valid;
}

// Jalankan otomatis saat user mengetik
document.getElementById('tinggi_cm').addEventListener('input', hitungIMT);
document.getElementById('berat_kg').addEventListener('input', hitungIMT);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
