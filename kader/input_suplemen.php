<?php
require_once '../config/session.php';
require_once '../config/db.php';
cek_role(['kader']);

$kader_id = $_SESSION['user_id'];

// Ambil daftar remaja dari tabel users
$q_remaja = mysqli_query($conn, "SELECT id, nama FROM users WHERE role='remaja' ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pemberian Suplemen - SIMARA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background-color: #f8f9fa;
  font-family: 'Poppins', sans-serif;
}
.hero-header {
  background: linear-gradient(135deg, #1e824c, #27ae60);
  color: #fff;
  padding: 60px 20px;
  text-align: center;
  border-bottom-left-radius: 50px;
  border-bottom-right-radius: 50px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  opacity: 0;
  transform: translateY(-40px);
  transition: opacity 0.8s ease, transform 0.8s ease;
}
.hero-header.show {
  opacity: 1;
  transform: translateY(0);
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
.btn-success {
  background-color: #22c55e;
  border: none;
}
.btn-success:hover {
  background-color: #16a34a;
}
.form-check-label {
  font-weight: 500;
}
</style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="text-primary fw-bold mb-0">💊 Form Pemberian Suplemen</h4>
          <a href="view_suplemen.php" class="btn btn-success btn-sm">Lihat Riwayat</a>
        </div>

        <form action="proses_input_suplemen.php" method="POST">
          <!-- Pilih remaja -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Remaja</label>
            <select name="user_id" class="form-select" required>
              <option value="">-- Pilih Nama Remaja --</option>
              <?php while ($r = mysqli_fetch_assoc($q_remaja)): ?>
                <option value="<?= $r['id']; ?>"><?= htmlspecialchars($r['nama']); ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <!-- Checklist suplemen -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Suplemen yang diberikan:</label>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="vit_bkomplek" value="1" id="bkomplek">
              <label class="form-check-label" for="bkomplek">Vitamin B Kompleks</label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="vit_d3" value="1" id="d3">
              <label class="form-check-label" for="d3">Vitamin D3</label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="vit_c" value="1" id="vitc">
              <label class="form-check-label" for="vitc">Vitamin C</label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="zinc" value="1" id="zinc">
              <label class="form-check-label" for="zinc">Zinc</label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="tablet_tambah_darah" value="1" id="ttd">
              <label class="form-check-label" for="ttd">Tablet Tambah Darah</label>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // efek animasi header jika digunakan
  document.addEventListener("DOMContentLoaded", function() {
    const hero = document.querySelector('.hero-header');
    if (hero) hero.classList.add('show');
  });
</script>
</body>
</html>
