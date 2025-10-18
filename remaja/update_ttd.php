<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';

cek_role(['remaja']);

$user_id = $_SESSION['user_id'];
$now = date('Y-m-d');

// Ambil ID pemberian terbaru untuk user ini
$q_get = mysqli_query($conn, "
  SELECT id 
  FROM pemberian_suplemen 
  WHERE user_id = '$user_id' AND tablet_tambah_darah = 1
  ORDER BY tanggal_pemberian DESC
  LIMIT 1
");

if (!$q_get) {
    echo 'Error: ' . mysqli_error($conn);
    exit;
}

$data = mysqli_fetch_assoc($q_get);

if ($data) {
    // Jika ada data, update tanggal minum terakhir
    $id = $data['id'];
    $update = mysqli_query($conn, "
      UPDATE pemberian_suplemen 
      SET tanggal_minum_terakhir = '$now' 
      WHERE id = '$id'
    ");
} else {
    // Jika belum ada data (user baru), buat data baru
    $update = mysqli_query($conn, "
      INSERT INTO pemberian_suplemen (user_id, tablet_tambah_darah, tanggal_pemberian, tanggal_minum_terakhir)
      VALUES ('$user_id', 1, '$now', '$now')
    ");
}

if ($update) {
    echo 'OK';
} else {
    echo 'Error: ' . mysqli_error($conn);
}
?>
