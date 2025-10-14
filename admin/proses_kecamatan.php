<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);

// Tambah data
if (isset($_POST['tambah'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama_kecamatan']);
  mysqli_query($conn, "INSERT INTO kecamatan (nama_kecamatan) VALUES ('$nama')");
  header("Location: kelola_kecamatan.php");
  exit;
}

// Edit data
if (isset($_POST['edit'])) {
  $id = intval($_POST['id']);
  $nama = mysqli_real_escape_string($conn, $_POST['nama_kecamatan']);
  mysqli_query($conn, "UPDATE kecamatan SET nama_kecamatan='$nama' WHERE id=$id");
  header("Location: kelola_kecamatan.php");
  exit;
}

// Hapus data
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  mysqli_query($conn, "DELETE FROM kecamatan WHERE id=$id");
  header("Location: kelola_kecamatan.php");
  exit;
}
?>
