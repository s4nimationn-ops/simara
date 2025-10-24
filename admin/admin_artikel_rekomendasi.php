<?php
session_start();
require_once '../config/db.php';
require_once '../config/session.php';
cek_role(['admin']); // pastikan hanya admin yang bisa akses

$msg = "";

// Proses tambah artikel baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $konten = mysqli_real_escape_string($conn, $_POST['konten']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori_rekomendasi']);
    $tanggal = date('Y-m-d H:i:s');

    if (!empty($judul) && !empty($konten) && !empty($kategori)) {
        $query = "
            INSERT INTO artikel (judul, konten, tanggal, kategori_rekomendasi)
            VALUES ('$judul', '$konten', '$tanggal', '$kategori')
        ";

        if (mysqli_query($conn, $query)) {
            $msg = "✅ Artikel rekomendasi berhasil ditambahkan!";
        } else {
            $msg = "❌ Gagal menambahkan artikel: " . mysqli_error($conn);
        }
    } else {
        $msg = "⚠️ Semua kolom wajib diisi!";
    }
}

// Ambil semua artikel rekomendasi
$q_artikel = mysqli_query($conn, "SELECT * FROM artikel ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Artikel Rekomendasi - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fb;
            font-family: 'Poppins', sans-serif;
        }
        .page-header {
            background: linear-gradient(135deg, #007bff, #66b3ff);
            color: #fff;
            padding: 60px 0;
            text-align: center;
            border-radius: 0 0 40px 40px;
            margin-bottom: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        .card-header {
            font-weight: 600;
            background-color: #fff !important;
            border-bottom: 2px solid #eee;
        }
        table th {
            background-color: #007bff;
            color: white;
            vertical-align: middle;
        }
        .btn-primary {
            background: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background: #0056d2;
        }
    </style>
</head>

<body>
<?php include 'navbar.php'; ?>

<div class="page-header">
    <h1 class="fw-bold">📚 Kelola Artikel Rekomendasi IMT</h1>
    <p class="lead mb-0">Tambahkan atau kelola artikel yang akan direkomendasikan berdasarkan hasil IMT remaja.</p>
</div>

<div class="container mb-5">

    <?php if (!empty($msg)): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <!-- FORM TAMBAH ARTIKEL -->
    <div class="card mb-4">
        <div class="card-header">
            📝 Tambah Artikel Rekomendasi
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Artikel</label>
                    <input type="text" name="judul" class="form-control shadow-sm" placeholder="Masukkan judul artikel..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Konten</label>
                    <textarea name="konten" class="form-control shadow-sm" rows="6" placeholder="Tulis isi artikel..." required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Kategori Rekomendasi (hasil IMT)</label>
                    <select name="kategori_rekomendasi" class="form-select shadow-sm" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Kurus">Kurus (IMT Rendah)</option>
                        <option value="Normal">Normal</option>
                        <option value="Gemuk">Gemuk</option>
                        <option value="Obesitas">Obesitas</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary px-4 py-2">
                    💾 Simpan Artikel
                </button>
            </form>
        </div>
    </div>

    <!-- DAFTAR ARTIKEL -->
    <div class="card">
        <div class="card-header">
            📄 Daftar Artikel Rekomendasi
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Judul</th>
                        <th>Kategori Rekomendasi</th>
                        <th>Tanggal</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($q_artikel) > 0): ?>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($q_artikel)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="text-start"><?= htmlspecialchars($row['judul']) ?></td>
                                <td>
                                    <span class="badge bg-info text-dark"><?= htmlspecialchars($row['kategori_rekomendasi'] ?: '-') ?></span>
                                </td>
                                <td><?= date('d M Y H:i', strtotime($row['tanggal'])) ?></td>
                                <td>
                                    <a href="artikel_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="artikel_hapus.php?id=<?= $row['id'] ?>" 
                                       onclick="return confirm('Yakin ingin menghapus artikel ini?')" 
                                       class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-3">Belum ada artikel rekomendasi</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.js"></script>
</body>
</html>
