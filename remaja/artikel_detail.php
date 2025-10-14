<?php
require_once '../config/db.php';

// Ambil ID artikel dari URL
if (!isset($_GET['id'])) {
    echo "Artikel tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM artikel WHERE id = $id";
$result = mysqli_query($conn, $query);
$artikel = mysqli_fetch_assoc($result);

if (!$artikel) {
    echo "Artikel tidak ditemukan.";
    exit;
}

// Fungsi ambil video_id dari link YouTube
function getYoutubeId($url) {
    $pattern = '/(youtu\.be\/|v=)([a-zA-Z0-9_-]+)/';
    if (preg_match($pattern, $url, $matches)) {
        return $matches[2];
    }
    return null;
}

// Pisahkan paragraf pertama dan sisanya
$konten = trim($artikel['konten']);
$paragraf = preg_split('/\r\n|\r|\n/', $konten, 2);
$paragraf_pertama = $paragraf[0] ?? '';
$paragraf_selanjutnya = $paragraf[1] ?? '';

$video_id = !empty($artikel['video']) ? getYoutubeId($artikel['video']) : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($artikel['judul']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 20px;
        }

        .artikel-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 15px;
            padding: 8px 14px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .artikel-container h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .artikel-container .tanggal {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .poster-wrapper {
            text-align: center;
            margin: 20px 0;
            cursor: zoom-in;
        }

        .poster-wrapper img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            display: block;
            margin: 0 auto;
            transition: 0.3s;
        }

        .poster-wrapper img:hover {
            opacity: 0.8;
        }

        .paragraf-1, .konten-lanjutan {
            line-height: 1.6;
            margin-bottom: 20px;
        }

        h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .video-wrapper {
            margin-top: 30px;
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            overflow: hidden;
            border-radius: 8px;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* ===== Modal Zoom Gambar ===== */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
        }

        .modal-content {
            display: block;
            margin: auto;
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 30px;
            color: #fff;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-close:hover {
            color: #bbb;
        }
    </style>
</head>
<body>

<div class="artikel-container">
    <!-- Tombol kembali -->
    <a href="dashboard.php" class="back-button">← Kembali ke Dashboard</a>

    <!-- Judul Artikel -->
    <h2><?php echo htmlspecialchars($artikel['judul']); ?></h2>
    <p class="tanggal"><?php echo date('d M Y', strtotime($artikel['tanggal'])); ?></p>

    <?php if (!empty($artikel['sub_judul'])): ?>
        <h4><?php echo htmlspecialchars($artikel['sub_judul']); ?></h4>
    <?php endif; ?>

    <!-- Paragraf pertama -->
    <?php if (!empty($paragraf_pertama)): ?>
        <p class="paragraf-1"><?php echo nl2br(htmlspecialchars($paragraf_pertama)); ?></p>
    <?php endif; ?>

    <!-- Gambar poster -->
    <?php if (!empty($artikel['poster'])): ?>
        <div class="poster-wrapper">
            <img id="posterImg" src="../uploads/<?php echo htmlspecialchars($artikel['poster']); ?>" alt="Poster Artikel">
        </div>
    <?php endif; ?>

    <!-- Paragraf selanjutnya -->
    <?php if (!empty($paragraf_selanjutnya)): ?>
        <div class="konten-lanjutan">
            <?php echo nl2br(htmlspecialchars($paragraf_selanjutnya)); ?>
        </div>
    <?php endif; ?>

    <!-- Video YouTube -->
    <?php if ($video_id): ?>
        <div class="video-wrapper">
            <iframe src="https://www.youtube.com/embed/<?php echo $video_id; ?>" allowfullscreen></iframe>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Zoom Gambar -->
<div id="posterModal" class="modal">
    <span class="modal-close">&times;</span>
    <img class="modal-content" id="posterZoom">
</div>

<script>
    const modal = document.getElementById("posterModal");
    const posterImg = document.getElementById("posterImg");
    const modalImg = document.getElementById("posterZoom");
    const closeBtn = document.getElementsByClassName("modal-close")[0];

    if (posterImg) {
        posterImg.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
        }
    }

    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    modal.onclick = function(e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>
