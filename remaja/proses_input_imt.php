<?php
require_once '../config/db.php';
require_once '../config/session.php';
cek_role(['remaja']);

$user_id = $_SESSION['user_id'];
$tinggi = floatval($_POST['tinggi_cm']);
$berat = floatval($_POST['berat_kg']);

// ================= HITUNG IMT =================
if ($tinggi > 0) {
    $hasil_imt = $berat / pow($tinggi / 100, 2);
    $hasil_imt = round($hasil_imt, 2);

    if ($hasil_imt < 18.5) {
        $status_imt = "Kurus";
    } elseif ($hasil_imt >= 18.5 && $hasil_imt < 25) {
        $status_imt = "Normal";
    } elseif ($hasil_imt >= 25 && $hasil_imt < 30) {
        $status_imt = "Gemuk";
    } else {
        $status_imt = "Obesitas";
    }

} else {
    $hasil_imt = 0;
    $status_imt = "Tidak valid";
}

// ================= CEK DATA =================
$q_cek = mysqli_query($conn, "SELECT id FROM data_imt WHERE user_id='$user_id' LIMIT 1");

if (mysqli_num_rows($q_cek) > 0) {
    // Dulu update — sekarang insert juga
    $sql = "INSERT INTO data_imt (user_id, tinggi_cm, berat_kg, hasil_imt, status_imt, tanggal_input) 
            VALUES ('$user_id', '$tinggi', '$berat', '$hasil_imt', '$status_imt', NOW())";
} else {
    $sql = "INSERT INTO data_imt (user_id, tinggi_cm, berat_kg, hasil_imt, status_imt) 
            VALUES ('$user_id','$tinggi','$berat','$hasil_imt','$status_imt')";
}

if (mysqli_query($conn, $sql)) {
    header("Location: dashboard.php?status=success");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
