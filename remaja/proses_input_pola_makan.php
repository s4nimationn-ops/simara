<?php
require_once '../config/session.php';
require_once '../config/db.php';
cek_role(['remaja']);

$user_id = $_SESSION['user_id'];

$sarapan = intval($_POST['sarapan_per_minggu']);
$buah_sayur = intval($_POST['buah_sayur_per_minggu']);
$air = floatval($_POST['liter_air_per_hari']);

// Validasi air putih
if ($air <= 0) {
    echo "<script>alert('Jumlah air putih tidak boleh 0!'); history.back();</script>";
    exit;
}

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO data_pola_makan (user_id, sarapan_per_minggu, buah_sayur_per_minggu, liter_air_per_hari) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiid", $user_id, $sarapan, $buah_sayur, $air);

if ($stmt->execute()) {
    echo "<script>alert('Data pola makan berhasil disimpan!'); window.location.href='dashboard.php';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan saat menyimpan data.'); history.back();</script>";
}

$stmt->close();
$conn->close();
?>
