<?php
require_once '../config/db.php';
require_once '../config/session.php';
cek_role(['remaja']);

$user_id = $_SESSION['user_id'];
$tinggi = floatval($_POST['tinggi_cm']);
$berat = floatval($_POST['berat_kg']);

// hitung IMT
if ($tinggi > 0) {
    $hasil_imt = $berat / pow($tinggi / 100, 2);
    $hasil_imt = round($hasil_imt, 3);

    if ($hasil_imt < 18.5) {
        $status_imt = "Kurus";
    } elseif ($hasil_imt >= 18.5 && $hasil_imt < 25) {
        $status_imt = "Normal";
    } else {
        $status_imt = "Gemuk";
    }
} else {
    $hasil_imt = 0;
    $status_imt = "Tidak valid";
}

// cek apakah user sudah pernah mengisi
$q_cek = mysqli_query($conn, "SELECT id FROM data_imt WHERE user_id='$user_id' LIMIT 1");

if (mysqli_num_rows($q_cek) > 0) {
    // UPDATE
    $sql = "UPDATE data_imt SET 
              tinggi_cm='$tinggi', 
              berat_kg='$berat', 
              hasil_imt='$hasil_imt',
              status_imt='$status_imt',
              tanggal_input=NOW()
            WHERE user_id='$user_id'";
} else {
    // INSERT
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
