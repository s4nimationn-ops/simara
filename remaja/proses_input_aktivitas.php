<?php
require_once '../config/session.php';
require_once '../config/db.php';
cek_role(['remaja']);

$user_id = $_SESSION['user_id'];

// Ambil data dari form
$olahraga = intval($_POST['olahraga_per_minggu']);
$gadget = floatval($_POST['gadget_jam_per_hari']);

// Validasi input
if ($gadget <= 0) {
    echo "<script>alert('Jam penggunaan gadget tidak boleh 0!'); history.back();</script>";
    exit;
}

if ($olahraga < 0) {
    echo "<script>alert('Nilai olahraga tidak valid!'); history.back();</script>";
    exit;
}

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO data_aktivitas (user_id, olahraga_per_minggu, gadget_jam_per_hari) VALUES (?, ?, ?)");
$stmt->bind_param("iid", $user_id, $olahraga, $gadget);

if ($stmt->execute()) {
    echo "<script>alert('Data aktivitas berhasil disimpan!'); window.location.href='dashboard.php';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan saat menyimpan data.'); history.back();</script>";
}

$stmt->close();
$conn->close();
?>
