<?php
require_once '../config/session.php';
require_once '../config/db.php';
cek_role(['remaja']);

$user_id = $_SESSION['user_id'];
$tinggi = floatval($_POST['tinggi_cm']);
$berat = floatval($_POST['berat_kg']);
$hasil = floatval($_POST['hasil_imt']);
$status = mysqli_real_escape_string($conn, $_POST['status_imt']);

$sql = "INSERT INTO data_imt (user_id, tinggi_cm, berat_kg, hasil_imt, status_imt)
        VALUES ('$user_id', '$tinggi', '$berat', '$hasil', '$status')";
if (mysqli_query($conn, $sql)) {
    header("Location: dashboard.php?success=imt");
    exit;
} else {
    echo "Gagal menyimpan data: " . mysqli_error($conn);
}
?>
