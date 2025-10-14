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
$sarapan = $_POST['sarapan_per_minggu'] ?? '';
$buah_sayur = $_POST['buah_sayur_per_minggu'] ?? '';
$liter_air = $_POST['liter_air_per_hari'] ?? '';

// Validasi sederhana
if (empty($sarapan) || empty($buah_sayur) || empty($liter_air)) {
    echo "Semua field harus diisi!";
    exit;
}

// Simpan ke database
$query = "INSERT INTO data_pola_makan (user_id, sarapan_per_minggu, buah_sayur_per_minggu, liter_air_per_hari)
          VALUES ('$user_id', '$sarapan', '$buah_sayur', '$liter_air')";

if (mysqli_query($conn, $query)) {
    // Jika berhasil simpan
    header("Location: dashboard.php?sukses=polamakan");
    exit;
} else {
    echo "Terjadi kesalahan: " . mysqli_error($conn);
}
?>
