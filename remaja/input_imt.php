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
<title>Input IMT - SIMARA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background: #f8fafc;
  font-family: 'Poppins', sans-serif;
}
.card {
  border-radius: 15px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.btn-primary {
  background-color: #4f46e5;
  border: none;
}
.btn-primary:hover {
  background-color: #4338ca;
}
#hasilIMT {
  font-weight: 600;
  font-size: 1.1rem;
  color: #2563eb;
}
</style>
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <h4 class="text-primary fw-bold mb-4">📊 Form Indeks Massa Tubuh (IMT)</h4>

        <form action="proses_input_imt.php" method="POST" id="imtForm">
          <div class="mb-3">
            <label class="form-label fw-semibold">Tinggi Badan (cm)</label>
            <input type="number" step="0.1" id="tinggi" name="tinggi_cm" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Berat Badan (kg)</label>
            <input type="number" step="0.1" id="berat" name="berat_kg" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Hasil IMT</label>
            <input type="text" id="hasil_imt" name="hasil_imt" class="form-control" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Status IMT</label>
            <input type="text" id="status_imt" name="status_imt" class="form-control" readonly>
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// Hitung IMT otomatis saat tinggi atau berat berubah
document.getElementById('imtForm').addEventListener('input', function() {
  const tinggi = parseFloat(document.getElementById('tinggi').value);
  const berat = parseFloat(document.getElementById('berat').value);
  
  if (tinggi > 0 && berat > 0) {
    const tinggiMeter = tinggi / 100;
    const imt = berat / (tinggiMeter * tinggiMeter);
    document.getElementById('hasil_imt').value = imt.toFixed(2);

    let status = '';
    if (imt < 18.5) status = 'Kurus';
    else if (imt < 25) status = 'Normal';
    else if (imt < 30) status = 'Gemuk';
    else status = 'Obesitas';
    document.getElementById('status_imt').value = status;
  }
});
</script>

</body>
</html>
