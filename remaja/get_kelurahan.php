<?php
require_once '../config/db.php';

if (isset($_POST['kecamatan_id'])) {
    $kec_id = intval($_POST['kecamatan_id']);
    $q = mysqli_query($conn, "SELECT id, nama_kelurahan FROM kelurahan WHERE kecamatan_id = $kec_id ORDER BY nama_kelurahan ASC");

    echo '<option value="">-- Pilih Kelurahan --</option>';
    while ($row = mysqli_fetch_assoc($q)) {
        echo '<option value="'.$row['id'].'">'.htmlspecialchars($row['nama_kelurahan']).'</option>';
    }
}
?>
