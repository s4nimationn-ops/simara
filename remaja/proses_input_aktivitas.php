<?php
require_once '../config/session.php';
require_once '../config/db.php';
cek_role(['remaja']);

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil data dari form
$user_id = $_SESSION['user_id'];
$olahraga_per_minggu = $_POST['olahraga_per_minggu'] ?? '';
$gadget_jam_per_hari = $_POST['gadget_jam_per_hari'] ?? '';

// Simpan ke database
$query = "INSERT INTO data_aktivitas (user_id, olahraga_per_minggu, gadget_jam_per_hari)
          VALUES ('$user_id', '$olahraga_per_minggu', '$gadget_jam_per_hari')";

if (mysqli_query($conn, $query)) {
    // Jika berhasil simpan
    header("Location: dashboard.php?sukses=aktivitas");
    exit;
} else {
    echo "Terjadi kesalahan: " . mysqli_error($conn);
}
?>
