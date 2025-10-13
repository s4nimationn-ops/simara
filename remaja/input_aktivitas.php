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
<title>Input Aktivitas - SIMARA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: #f8fafc; font-family: 'Poppins', sans-serif; }
.card { border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.btn-primary { background-color: #4f46e5; border: none; }
.btn-primary:hover { background-color: #4338ca; }
</style>
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <h4 class="text-primary fw-bold mb-4">🏃 Aktivitas Olahraga</h4>
        <form action="proses_input_aktivitas.php" method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold">Berapa kali olahraga dalam seminggu?</label>
            <input type="number" name="olahraga_per_minggu" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Berapa jam menggunakan gadget dalam sehari?</label>
            <input type="number" step="0.1" name="gadget_jam_per_hari" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
