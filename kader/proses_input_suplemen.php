<?php
require_once '../config/session.php';
require_once '../config/db.php';
cek_role(['kader']);

$kader_id = $_SESSION['user_id'];
$user_id = intval($_POST['user_id']);

$vit_bkomplek = isset($_POST['vit_bkomplek']) ? 1 : 0;
$vit_d3 = isset($_POST['vit_d3']) ? 1 : 0;
$vit_c = isset($_POST['vit_c']) ? 1 : 0;
$zinc = isset($_POST['zinc']) ? 1 : 0;
$ttd = isset($_POST['tablet_tambah_darah']) ? 1 : 0;

$sql = "INSERT INTO pemberian_suplemen 
        (user_id, kader_id, vit_bkomplek, vit_d3, vit_c, zinc, tablet_tambah_darah)
        VALUES ('$user_id', '$kader_id', '$vit_bkomplek', '$vit_d3', '$vit_c', '$zinc', '$ttd')";

if (mysqli_query($conn, $sql)) {
  header("Location: dashboard.php?success=suplemen");
  exit;
} else {
  echo "Terjadi kesalahan: " . mysqli_error($conn);
}
?>
