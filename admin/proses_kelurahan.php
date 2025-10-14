<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);

// ===== TAMBAH DATA =====
if (isset($_POST['tambah'])) {
    $nama_kelurahan = mysqli_real_escape_string($conn, $_POST['nama_kelurahan']);
    $kecamatan_id = intval($_POST['kecamatan_id']);

    $q = "INSERT INTO kelurahan (nama_kelurahan, kecamatan_id) VALUES ('$nama_kelurahan', '$kecamatan_id')";
    if (mysqli_query($conn, $q)) {
        header("Location: kelola_kelurahan.php?status=success");
    } else {
        echo "Gagal menambah data: " . mysqli_error($conn);
    }
    exit;
}

// ===== EDIT DATA =====
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $nama_kelurahan = mysqli_real_escape_string($conn, $_POST['nama_kelurahan']);
    $kecamatan_id = intval($_POST['kecamatan_id']);

    $q = "UPDATE kelurahan SET nama_kelurahan='$nama_kelurahan', kecamatan_id='$kecamatan_id' WHERE id='$id'";
    if (mysqli_query($conn, $q)) {
        header("Location: kelola_kelurahan.php?status=updated");
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
    exit;
}

// ===== HAPUS DATA =====
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $q = "DELETE FROM kelurahan WHERE id='$id'";
    if (mysqli_query($conn, $q)) {
        header("Location: kelola_kelurahan.php?status=deleted");
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
    exit;
}

// ===== DEFAULT =====
header("Location: kelola_kelurahan.php");
exit;
?>
