<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);

if (!isset($_GET['id'])) {
    header("Location: admin_artikel_rekomendasi.php");
    exit;
}

$id = intval($_GET['id']);

// Hapus artikel berdasarkan ID
$stmt = $conn->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo "<script>alert('Artikel berhasil dihapus!'); window.location='admin_artikel_rekomendasi.php';</script>";
exit;
?>
