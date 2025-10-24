<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);

// Pastikan ada ID
if (!isset($_GET['id'])) {
    header("Location: admin_artikel_rekomendasi.php");
    exit;
}

$id = (int) $_GET['id'];

// Ambil data artikel
$stmt = $conn->prepare("SELECT * FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result  = $stmt->get_result();
$artikel = $result->fetch_assoc();

if (!$artikel) {
    echo "<script>alert('Artikel tidak ditemukan!'); window.location='admin_artikel_rekomendasi.php';</script>";
    exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul   = $_POST['judul'];
    $konten  = $_POST['konten'];
    $kategori_rekomendasi = $_POST['kategori_rekomendasi'];
    $tanggal = date('Y-m-d H:i:s');

    $stmt_update = $conn->prepare("
        UPDATE artikel 
        SET judul = ?, konten = ?, kategori_rekomendasi = ?, tanggal = ?
        WHERE id = ?
    ");
    $stmt_update->bind_param("ssssi", $judul, $konten, $kategori_rekomendasi, $tanggal, $id);
    $stmt_update->execute();

    echo "<script>alert('✅ Artikel berhasil diperbarui!'); window.location='admin_artikel_rekomendasi.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Artikel Rekomendasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: 'Poppins', sans-serif; }
    .card { border-radius: 15px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); margin-top: 50px; }
    .btn-primary { background: #007bff; border: none; }
    .btn-primary:hover { background: #0056d2; }
    .btn-secondary { background: #6c757d; border: none; }
    .btn-secondary:hover { background: #5a6268; }
  </style>
</head>
<body>

<div class="container">
  <div class="card">
    <div class="card-header bg-white fw-bold fs-5">
      ✏️ Edit Artikel Rekomendasi
    </div>
    <div class="card-body">
      <form method="POST">
        <div class="mb-3">
          <label class="form-label fw-semibold">Judul Artikel</label>
          <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($artikel['judul']); ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Konten</label>
          <textarea name="konten" class="form-control" rows="7" required><?= htmlspecialchars($artikel['konten']); ?></textarea>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Kategori Rekomendasi (hasil IMT)</label>
          <select name="kategori_rekomendasi" class="form-select" required>
            <option value="Kurus"   <?= $artikel['kategori_rekomendasi'] === 'Kurus'   ? 'selected' : '' ?>>Kurus</option>
            <option value="Normal"  <?= $artikel['kategori_rekomendasi'] === 'Normal'  ? 'selected' : '' ?>>Normal</option>
            <option value="Gemuk"   <?= $artikel['kategori_rekomendasi'] === 'Gemuk'   ? 'selected' : '' ?>>Gemuk</option>
            <option value="Obesitas"<?= $artikel['kategori_rekomendasi'] === 'Obesitas'? 'selected' : '' ?>>Obesitas</option>
          </select>
        </div>

        <div class="d-flex justify-content-between">
          <a href="admin_artikel_rekomendasi.php" class="btn btn-secondary px-4">← Kembali</a>
          <button type="submit" class="btn btn-primary px-4">💾 Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
