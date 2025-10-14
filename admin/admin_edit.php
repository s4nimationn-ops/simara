<?php
session_start();
require_once '../config/db.php';

// ===== Fungsi Ambil ID YouTube =====
function getYoutubeId($url) {
    preg_match("/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([^\&\?\/]+)/", $url, $matches);
    return $matches[1] ?? '';
}

// ===== Ambil Artikel Berdasarkan ID =====
if (!isset($_GET['id'])) {
    die("Artikel tidak ditemukan!");
}

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM artikel WHERE id = $id");
$artikel = mysqli_fetch_assoc($query);

if (!$artikel) {
    die("Artikel tidak ditemukan!");
}

// ===== Update Artikel =====
if (isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $konten = mysqli_real_escape_string($conn, $_POST['konten']);
    $video = mysqli_real_escape_string($conn, $_POST['video']);

    // Upload poster baru jika ada
    $poster = $artikel['poster'];
    if (!empty($_FILES['poster']['name'])) {
        $posterName = time() . '_' . basename($_FILES['poster']['name']);
        $target = "../uploads/" . $posterName;
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $target)) {
            // hapus poster lama jika ada
            if (!empty($poster) && file_exists("../uploads/" . $poster)) {
                unlink("../uploads/" . $poster);
            }
            $poster = $posterName;
        }
    }

    mysqli_query($conn, "UPDATE artikel SET 
        judul = '$judul',
        konten = '$konten',
        poster = '$poster',
        video = '$video'
        WHERE id = $id
    ");

    header("Location: admin_input.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Artikel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f5f5; }
        .poster-preview { max-width: 100%; border-radius: 5px; margin-top: 10px; }
    </style>
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4">✏ Edit Artikel</h2>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($artikel['judul']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Konten</label>
            <textarea name="konten" class="form-control" rows="5" required><?= htmlspecialchars($artikel['konten']) ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Link YouTube (boleh link asli)</label>
                    <input type="text" name="video" class="form-control" value="<?= htmlspecialchars($artikel['video']) ?>">
                </div>
                <?php if (!empty($artikel['video'])): ?>
                    <div class="ratio ratio-16x9 mb-3">
                        <iframe src="https://www.youtube.com/embed/<?= getYoutubeId($artikel['video']) ?>"
                                frameborder="0" allowfullscreen></iframe>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Poster</label>
                    <input type="file" name="poster" class="form-control">
                </div>
                <?php if (!empty($artikel['poster'])): ?>
                    <img src="../uploads/<?= htmlspecialchars($artikel['poster']) ?>" class="poster-preview" alt="Poster">
                <?php endif; ?>
            </div>
        </div>

        <button type="submit" name="update" class="btn btn-warning w-100 mb-2">💾 Update Artikel</button>
        <a href="admin_input.php" class="btn btn-secondary w-100">⬅ Kembali</a>
    </form>
</div>

</body>
</html>
