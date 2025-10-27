<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  echo "User tidak ditemukan";
  exit;
}

$q = mysqli_query($conn, "
  UPDATE pemberian_suplemen 
  SET tanggal_minum_terakhir = NOW()
  WHERE id = (
    SELECT id FROM (
      SELECT id FROM pemberian_suplemen 
      WHERE user_id = '$user_id' AND tablet_tambah_darah = 1 
      ORDER BY tanggal_pemberian DESC LIMIT 1
    ) AS t
  )
");

if ($q) echo "OK";
else echo mysqli_error($conn);
?>
