<?php
require_once '../config/db.php';
$q = mysqli_query($conn, "SELECT id, nama_sekolah FROM sekolah ORDER BY nama_sekolah ASC");

echo '<option value="">-- Pilih Sekolah --</option>';
while ($row = mysqli_fetch_assoc($q)) {
    echo '<option value="'.$row['id'].'">'.htmlspecialchars($row['nama_sekolah']).'</option>';
}
?>
