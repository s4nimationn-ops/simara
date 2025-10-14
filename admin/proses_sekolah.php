<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);

// ===== TAMBAH DATA =====
if (isset($_POST['tambah'])) {
    $nama_sekolah = mysqli_real_escape_string($conn, $_POST['nama_sekolah']);
    $kelurahan_id = intval($_POST['kelurahan_id']);

    $q = "INSERT INTO sekolah (nama_sekolah, kelurahan_id) VALUES ('$nama_sekolah', '$kelurahan_id')";
    if (mysqli_query($conn, $q)) {
        header("Location: kelola_sekolah.php?status=success");
    } else {
        echo "Gagal menambah data: " . mysqli_error($conn);
    }
    exit;
}

// ===== EDIT DATA =====
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $nama_sekolah = mysqli_real_escape_string($conn, $_POST['nama_sekolah']);
    $kelurahan_id = intval($_POST['kelurahan_id']);

    $q = "UPDATE sekolah SET nama_sekolah='$nama_sekolah', kelurahan_id='$kelurahan_id' WHERE id='$id'";
    if (mysqli_query($conn, $q)) {
        header("Location: kelola_sekolah.php?status=updated");
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
    exit;
}

// ===== HAPUS DATA =====
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $q = "DELETE FROM sekolah WHERE id='$id'";
    if (mysqli_query($conn, $q)) {
        header("Location: kelola_sekolah.php?status=deleted");
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
    exit;
}

// ===== DEFAULT =====
header("Location: kelola_sekolah.php");
exit;
?>
