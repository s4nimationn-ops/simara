<?php
require_once '../config/db.php';
require_once '../config/session.php';
cek_role(['remaja']);
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $olahraga = intval($_POST['olahraga_per_minggu']);
    $gadget = floatval($_POST['gadget_jam_per_hari']);

    if ($gadget <= 0) {
        header("Location: input_aktivitas.php?error=gadget");
        exit;
    }

    $cek = mysqli_query($conn, "SELECT id FROM data_aktivitas WHERE user_id='$user_id'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE data_aktivitas 
                             SET olahraga_per_minggu='$olahraga', gadget_jam_per_hari='$gadget', tanggal_input=NOW() 
                             WHERE user_id='$user_id'");
    } else {
        mysqli_query($conn, "INSERT INTO data_aktivitas (user_id, olahraga_per_minggu, gadget_jam_per_hari)
                             VALUES ('$user_id','$olahraga','$gadget')");
    }

    header("Location: dashboard.php?status=success");
    exit;
}
?>
