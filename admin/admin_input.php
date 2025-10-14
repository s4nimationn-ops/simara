<?php
session_start();
require_once '../config/db.php';

// ========== Fungsi Ambil ID YouTube ==========
function getYoutubeId($url) {
    preg_match("/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([^\&\?\/]+)/", $url, $matches);
    return $matches[1] ?? '';
}

// ========== Proses Simpan Artikel ==========
if (isset($_POST['simpan'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $konten = mysqli_real_escape_string($conn, $_POST['konten']);
    $video = mysqli_real_escape_string($conn, $_POST['video']);

    $poster = '';
    if (!empty($_FILES['poster']['name'])) {
        $posterName = time().'_'.basename($_FILES['poster']['name']);
        $target = "../uploads/".$posterName;
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $target)) {
            $poster = $posterName;
        }
    }

    mysqli_query($conn, "INSERT INTO artikel (judul, konten, poster, video, tanggal) VALUES ('$judul', '$konten', '$poster', '$video', NOW())");
    header("Location: admin_input.php");
    exit;
}

// ========== Proses Update Artikel ==========
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $konten = mysqli_real_escape_string($conn, $_POST['konten']);
    $video = mysqli_real_escape_string($conn, $_POST['video']);

    $poster = $_POST['poster_lama'];
    if (!empty($_FILES['poster']['name'])) {
        $posterName = time().'_'.basename($_FILES['poster']['name']);
        $target = "../uploads/".$posterName;
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $target)) {
            if (!empty($poster) && file_exists("../uploads/".$poster)) {
                unlink("../uploads/".$poster);
            }
            $poster = $posterName;
        }
    }

    mysqli_query($conn, "UPDATE artikel SET judul='$judul', konten='$konten', poster='$poster', video='$video' WHERE id=$id");
    header("Location: admin_input.php");
    exit;
}

// ========== Proses Hapus Artikel ==========
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $q = mysqli_query($conn, "SELECT poster FROM artikel WHERE id=$id");
    $d = mysqli_fetch_assoc($q);
    if ($d && !empty($d['poster']) && file_exists("../uploads/".$d['poster'])) {
        unlink("../uploads/".$d['poster']);
    }
    mysqli_query($conn, "DELETE FROM artikel WHERE id=$id");
    header("Location: admin_input.php");
    exit;
}

// ========== Ambil Data Artikel ==========
$artikel = mysqli_query($conn, "SELECT * FROM artikel ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Input Artikel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f5f5; }
        .table thead { background: #007bff; color: white; }
        .btn-edit { background: #ffc107; color: #000; }
        .btn-edit:hover { background: #e0a800; color: #000; }
        .btn-hapus { background: #dc3545; color: white; }
        .btn-hapus:hover { background: #bb2d3b; color: white; }
        .poster-preview { max-width: 200px; margin-top: 10px; border-radius: 6px; }
        .edit-form { display: none; background: #f8f9fa; padding: 15px; border-radius: 8px; }
    </style>
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4">📰 Tambah Artikel Baru</h2>
    <form method="post" enctype="multipart/form-data" class="mb-5">
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Konten</label>
            <textarea name="konten" class="form-control" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label>Poster</label>
            <input type="file" name="poster" class="form-control">
        </div>
        <div class="mb-3">
            <label>Link YouTube (boleh link asli)</label>
            <input type="text" name="video" class="form-control">
        </div>
        <button type="submit" name="simpan" class="btn btn-primary w-100">💾 Simpan Artikel</button>
    </form>

    <h3 class="mb-3">📃 Daftar Artikel</h3>
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th style="width: 50px;">#</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th style="width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; while($row = mysqli_fetch_assoc($artikel)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="toggleEdit(<?= $row['id'] ?>)">Edit</button>
                    <a href="?hapus=<?= $row['id'] ?>" class="btn btn-hapus btn-sm" onclick="return confirm('Yakin hapus artikel ini?')">Hapus</a>
                </td>
            </tr>
            <tr id="edit-form-<?= $row['id'] ?>" class="edit-form">
                <td colspan="4">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <div class="mb-2">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($row['judul']) ?>" required>
                        </div>
                        <div class="mb-2">
                            <label>Konten</label>
                            <textarea name="konten" class="form-control" rows="4"><?= htmlspecialchars($row['konten']) ?></textarea>
                        </div>
                        <div class="mb-2">
                            <label>Poster</label>
                            <input type="file" name="poster" class="form-control">
                            <input type="hidden" name="poster_lama" value="<?= $row['poster'] ?>">
                            <?php if ($row['poster']): ?>
                                <img src="../uploads/<?= htmlspecialchars($row['poster']) ?>" class="poster-preview">
                            <?php endif; ?>
                        </div>
                        <div class="mb-2">
                            <label>Link YouTube</label>
                            <input type="text" name="video" class="form-control" value="<?= htmlspecialchars($row['video']) ?>">
                            <?php if ($row['video']): ?>
                                <div class="ratio ratio-16x9 mt-2">
                                    <iframe src="https://www.youtube.com/embed/<?= getYoutubeId($row['video']) ?>" frameborder="0" allowfullscreen></iframe>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="update" class="btn btn-success w-100 mt-2">💾 Simpan Perubahan</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function toggleEdit(id) {
    const row = document.getElementById('edit-form-' + id);
    row.style.display = (row.style.display === 'none' || row.style.display === '') ? 'table-row' : 'none';
}
</script>

</body>
</html>
