<?php
require_once '../config/db.php';
require_once '../config/session.php';
cek_role(['remaja']);
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sarapan = intval($_POST['sarapan_per_minggu']);
    $buah = intval($_POST['buah_sayur_per_minggu']);
    $air = floatval($_POST['liter_air_per_hari']);

    if ($air <= 0) {
        header("Location: input_pola_makan.php?error=air");
        exit;
    }

    $cek = mysqli_query($conn, "SELECT id FROM data_pola_makan WHERE user_id='$user_id'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE data_pola_makan 
                             SET sarapan_per_minggu='$sarapan', buah_sayur_per_minggu='$buah', liter_air_per_hari='$air', tanggal_input=NOW() 
                             WHERE user_id='$user_id'");
    } else {
        mysqli_query($conn, "INSERT INTO data_pola_makan (user_id, sarapan_per_minggu, buah_sayur_per_minggu, liter_air_per_hari)
                             VALUES ('$user_id','$sarapan','$buah','$air')");
    }

    header("Location: dashboard.php?status=success");
    exit;
}
?>
