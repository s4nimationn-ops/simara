<?php
session_start();
require_once '../config/db.php';

// ================== Fungsi Ambil ID YouTube ==================
function getYoutubeId($url) {
    preg_match("/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([^\&\?\/]+)/", $url, $matches);
    return $matches[1] ?? '';
}

// ================== HAPUS POSTER ==================
if (isset($_GET['hapus_poster'])) {
    $id = intval($_GET['hapus_poster']);
    $q = mysqli_query($conn, "SELECT poster FROM artikel WHERE id=$id");
    $d = mysqli_fetch_assoc($q);
    if ($d && !empty($d['poster']) && file_exists("../uploads/".$d['poster'])) {
        unlink("../uploads/".$d['poster']);
    }
    mysqli_query($conn, "UPDATE artikel SET poster='' WHERE id=$id");
    header("Location: admin_input.php");
    exit;
}

// ================== HAPUS FOTO LAIN ==================
if (isset($_GET['hapus_foto']) && isset($_GET['foto'])) {
    $id = intval($_GET['hapus_foto']);
    $foto = $_GET['foto'];

    $q = mysqli_query($conn, "SELECT foto_lain FROM artikel WHERE id=$id");
    $d = mysqli_fetch_assoc($q);
    if ($d) {
        $fotoLain = json_decode($d['foto_lain'], true) ?? [];
        $fotoLain = array_filter($fotoLain, function($f) use ($foto) {
            return $f !== $foto;
        });
        if (file_exists("../uploads/".$foto)) {
            unlink("../uploads/".$foto);
        }
        mysqli_query($conn, "UPDATE artikel SET foto_lain='".json_encode(array_values($fotoLain))."' WHERE id=$id");
    }
    header("Location: admin_input.php");
    exit;
}

// ================== Proses Simpan Artikel ==================
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

    $foto_lain = [];
    for ($i = 1; $i <= 2; $i++) {
        if (!empty($_FILES['foto_lain'.$i]['name'])) {
            $fotoName = time().'_'.$i.'_'.basename($_FILES['foto_lain'.$i]['name']);
            $targetFoto = "../uploads/".$fotoName;
            if (move_uploaded_file($_FILES['foto_lain'.$i]['tmp_name'], $targetFoto)) {
                $foto_lain[] = $fotoName;
            }
        }
    }
    $foto_lain_json = json_encode($foto_lain);

    mysqli_query($conn, "INSERT INTO artikel (judul, konten, poster, video, foto_lain, tanggal) 
        VALUES ('$judul', '$konten', '$poster', '$video', '$foto_lain_json', NOW())");
    header("Location: admin_input.php");
    exit;
}

// ================== Proses Update Artikel ==================
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
            if (!empty($poster) && file_exists("../uploads/".$poster)) unlink("../uploads/".$poster);
            $poster = $posterName;
        }
    }

    $existing_foto_lain = json_decode($_POST['foto_lain_lama'], true) ?? [];
    $new_foto_lain = $existing_foto_lain;
    for ($i = 1; $i <= 2; $i++) {
        if (!empty($_FILES['foto_lain'.$i]['name'])) {
            $fotoName = time().'_'.$i.'_'.basename($_FILES['foto_lain'.$i]['name']);
            $targetFoto = "../uploads/".$fotoName;
            if (move_uploaded_file($_FILES['foto_lain'.$i]['tmp_name'], $targetFoto)) {
                $new_foto_lain[] = $fotoName;
            }
        }
    }

    $foto_lain_json = json_encode($new_foto_lain);
    mysqli_query($conn, "UPDATE artikel 
        SET judul='$judul', konten='$konten', poster='$poster', video='$video', foto_lain='$foto_lain_json' 
        WHERE id=$id");
    header("Location: admin_input.php");
    exit;
}

// ================== Proses Hapus Artikel ==================
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $q = mysqli_query($conn, "SELECT poster, foto_lain FROM artikel WHERE id=$id");
    $d = mysqli_fetch_assoc($q);

    if ($d) {
        if (!empty($d['poster']) && file_exists("../uploads/".$d['poster'])) unlink("../uploads/".$d['poster']);
        $foto_lain = json_decode($d['foto_lain'], true);
        if (is_array($foto_lain)) {
            foreach ($foto_lain as $f) if (file_exists("../uploads/".$f)) unlink("../uploads/".$f);
        }
    }

    mysqli_query($conn, "DELETE FROM artikel WHERE id=$id");
    header("Location: admin_input.php");
    exit;
}

// ================== Ambil Data Artikel ==================
$artikel = mysqli_query($conn, "SELECT * FROM artikel ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Input Artikel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background: #f8fafc; font-family: 'Poppins', sans-serif; }
.card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
.card-header { background: #2563eb; color: white; font-weight: 600; }
.poster-preview, .foto-lain-preview { max-width: 150px; border-radius: 8px; margin-top: 10px; }
.table thead { background: #2563eb; color: white; }
.btn-edit { background: #facc15; color: #000; }
.btn-hapus { background: #ef4444; color: #fff; }
</style>
</head>
<body class="p-4">

<div class="container">
  <!-- Tombol Kembali -->
  <a class="btn btn-secondary mb-3" href="dashboard.php">⬅ Kembali ke Dashboard</a>

  <!-- Form Tambah Artikel -->
  <div class="card mb-5">
    <div class="card-header"><i class="bi bi-journal-plus"></i> Tambah Artikel Baru</div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Judul Artikel</label>
          <input type="text" name="judul" class="form-control" required placeholder="Masukkan judul artikel...">
        </div>
        <div class="mb-3">
          <label class="form-label">Konten</label>
          <textarea name="konten" class="form-control" rows="5" required placeholder="Tulis konten artikel di sini..."></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Poster</label>
          <input type="file" name="poster" class="form-control" onchange="previewImage(this,'previewPoster')">
          <img id="previewPoster" class="poster-preview d-none"/>
        </div>
        <div class="mb-3">
          <label class="form-label">Foto Lain 1</label>
          <input type="file" name="foto_lain1" class="form-control" onchange="previewImage(this,'previewFoto1')">
          <img id="previewFoto1" class="foto-lain-preview d-none"/>
        </div>
        <div class="mb-3">
          <label class="form-label">Foto Lain 2</label>
          <input type="file" name="foto_lain2" class="form-control" onchange="previewImage(this,'previewFoto2')">
          <img id="previewFoto2" class="foto-lain-preview d-none"/>
        </div>
        <div class="mb-3">
          <label class="form-label">Link YouTube (opsional)</label>
          <input type="text" name="video" class="form-control" placeholder="https://youtube.com/watch?v=...">
        </div>
        <button type="submit" name="simpan" class="btn btn-primary w-100"><i class="bi bi-save"></i> Simpan Artikel</button>
      </form>
    </div>
  </div>

  <!-- Daftar Artikel -->
  <div class="card">
    <div class="card-header"><i class="bi bi-journal-text"></i> Daftar Artikel</div>
    <div class="card-body table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Tanggal</th>
            <th style="width: 150px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php $no=1; while($row = mysqli_fetch_assoc($artikel)): ?>
          <?php $fotoLainArr = json_decode($row['foto_lain'], true) ?? []; ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td>
              <button class="btn btn-edit btn-sm" onclick="toggleEdit(<?= $row['id'] ?>)"><i class="bi bi-pencil-square"></i></button>
              <a href="?hapus=<?= $row['id'] ?>" class="btn btn-hapus btn-sm" onclick="return confirm('Yakin hapus artikel ini?')"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
          <tr id="edit-form-<?= $row['id'] ?>" style="display:none;">
            <td colspan="4">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <div class="mb-2">
                  <label>Judul</label>
                  <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($row['judul']) ?>">
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
                    <div class="mt-2 d-flex align-items-center gap-2">
                        <img src="../uploads/<?= $row['poster'] ?>" class="poster-preview">
                        <a href="?hapus_poster=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus poster ini?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="mb-2">
                  <label>Foto Lain</label>
                  <input type="file" name="foto_lain1" class="form-control mb-1">
                  <input type="file" name="foto_lain2" class="form-control">
                  <input type="hidden" name="foto_lain_lama" value='<?= json_encode($fotoLainArr) ?>'>
                  <?php foreach ($fotoLainArr as $f): ?>
                    <div class="mt-2 d-inline-flex align-items-center gap-2 me-2 mb-2">
                        <img src="../uploads/<?= $f ?>" class="foto-lain-preview">
                        <a href="?hapus_foto=<?= $row['id'] ?>&foto=<?= urlencode($f) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus foto ini?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                  <?php endforeach; ?>
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
                <button type="submit" name="update" class="btn btn-success w-100 mt-2"><i class="bi bi-save"></i> Simpan Perubahan</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function toggleEdit(id) {
  const row = document.getElementById('edit-form-' + id);
  row.style.display = row.style.display === 'none' || row.style.display === '' ? 'table-row' : 'none';
}

function previewImage(input, targetId) {
  const img = document.getElementById(targetId);
  const file = input.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = e => {
      img.src = e.target.result;
      img.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
  }
}
</script>

</body>
</html>
