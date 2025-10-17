<?php
session_start();
require_once _DIR_ . '/../config/db.php';
require_once _DIR_ . '/../config/session.php';
cek_role(['remaja']);

$user_id = $_SESSION['user_id'];
$now = date('Y-m-d H:i:s');

// Perbarui tanggal terakhir minum TTD
$q = "
  UPDATE pemberian_suplemen 
  SET tanggal_minum_terakhir = '$now'
  WHERE user_id = '$user_id' AND tablet_tambah_darah = 1
  ORDER BY tanggal_pemberian DESC
  LIMIT 1
";
if (mysqli_query($conn, $q)) {
    echo 'OK';
} else {
    echo 'Error: ' . mysqli_error($conn);
}
?>