<?php
require_once '../config/db.php';

if (!isset($_GET['id'])) {
    die("Artikel tidak ditemukan.");
}

$id = intval($_GET['id']);
$q = mysqli_query($conn, "SELECT * FROM artikel WHERE id = $id");
$artikel = mysqli_fetch_assoc($q);

if (!$artikel) {
    die("Artikel tidak ditemukan.");
}

function getYoutubeId($url) {
    $pattern = '/(?:youtu\.be\/|v=)([a-zA-Z0-9_-]+)/';
    if (preg_match($pattern, $url, $matches)) {
        return $matches[1];
    }
    return null;
}

// Pisahkan paragraf dari konten artikel
$paragraf = preg_split('/\n+/', trim($artikel['konten']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($artikel['judul']); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background: #f8f9fa; }
    .poster-artikel {
      display: block;
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      cursor: zoom-in;
      transition: 0.3s;
      object-fit: cover;
    }
    .poster-artikel:hover { opacity: 0.8; }

    /* Galeri foto tambahan */
    .galeri-foto {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 15px;
      margin: 25px 0;
    }
    .galeri-foto img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      border-radius: 8px;
      cursor: zoom-in;
      transition: 0.3s;
    }
    .galeri-foto img:hover { opacity: 0.8; }

    .modal {
      display: none;
      position: fixed;
      z-index: 9999;
      padding-top: 60px;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.8);
    }
    .modal-content {
      margin: auto;
      display: block;
      max-width: 80%;
      border-radius: 8px;
    }
    .close {
      position: absolute;
      top: 15px;
      right: 35px;
      color: white;
      font-size: 40px;
      font-weight: bold;
      cursor: pointer;
    }
    .konten-artikel { margin-top: 25px; font-size: 18px; line-height: 1.7; color: #333; }
    .judul-artikel { font-weight: 700; }
    .btn-back { margin-bottom: 20px; }
  </style>
</head>
<body>
<div class="container my-5">

  <a href="dashboard.php" class="btn btn-secondary btn-back">&larr; Kembali ke Dashboard</a>

  <h1 class="judul-artikel mb-3"><?= htmlspecialchars($artikel['judul']); ?></h1>
  <p class="text-muted"><?= date('d M Y', strtotime($artikel['tanggal'])); ?></p>

  <!-- Poster Utama -->
  <?php if (!empty($artikel['poster'])): ?>
    <img src="../uploads/<?= htmlspecialchars($artikel['poster']); ?>" 
         alt="Poster Artikel" 
         class="poster-artikel mb-4"
         onclick="zoomImage(this)">
  <?php endif; ?>

  <!-- Konten Artikel + Galeri di tengah -->
  <div class="konten-artikel">
    <?php
    $titik_sisip = 2; // sisipkan galeri setelah paragraf ke-2
    foreach ($paragraf as $i => $p) {
        echo "<p>" . nl2br(htmlspecialchars($p)) . "</p>";

        if ($i + 1 == $titik_sisip) {
            if (!empty($artikel['foto_lain'])) {
                $foto_array = json_decode($artikel['foto_lain'], true);
                if (is_array($foto_array) && count($foto_array) > 0) {
                    echo '<div class="galeri-foto">';
                    foreach ($foto_array as $foto) {
                        echo '<img src="../uploads/' . htmlspecialchars($foto) . '" alt="Foto Tambahan" onclick="zoomImage(this)">';
                    }
                    echo '</div>';
                }
            }
        }
    }
    ?>
  </div>

  <!-- Video YouTube -->
  <?php if (!empty($artikel['video'])): ?>
    <?php
      $video_id = getYoutubeId($artikel['video']);
      if ($video_id):
    ?>
      <div class="ratio ratio-16x9 mt-4">
        <iframe src="https://www.youtube.com/embed/<?= $video_id; ?>" 
                frameborder="0" 
                allowfullscreen>
        </iframe>
      </div>
    <?php else: ?>
      <p class="text-danger mt-3">Link video tidak valid</p>
    <?php endif; ?>
  <?php endif; ?>

</div>

<!-- Modal Zoom -->
<div id="zoomModal" class="modal" onclick="closeZoom()">
    <span class="close">&times;</span>
    <img class="modal-content" id="zoomedImage">
</div>

<script>
function zoomImage(img) {
    document.getElementById("zoomModal").style.display = "block";
    document.getElementById("zoomedImage").src = img.src;
}
function closeZoom() {
    document.getElementById("zoomModal").style.display = "none";
}
</script>
</body>
</html>
