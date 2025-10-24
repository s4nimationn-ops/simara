<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);

// Ambil data dari form
$kurus   = $_POST['kurus'] ?? null;
$normal  = $_POST['normal'] ?? null;
$gemuk   = $_POST['gemuk'] ?? null;
$obesitas = $_POST['obesitas'] ?? null;

// Daftar kategori & artikel terpilih
$kategori_list = [
  'Kurus'   => $kurus,
  'Normal'  => $normal,
  'Gemuk'   => $gemuk,
  'Obesitas'=> $obesitas
];

// Hapus kategori lama dulu (supaya tidak ada yang dobel)
mysqli_query($conn, "UPDATE artikel SET kategori_rekomendasi = NULL");

// Simpan pilihan baru
foreach ($kategori_list as $kategori => $artikel_id) {
  if (!empty($artikel_id)) {
    mysqli_query($conn, "
      UPDATE artikel 
      SET kategori_rekomendasi = '$kategori' 
      WHERE id = '$artikel_id'
    ");
  }
}

header('Location: dashboard.php?success=1');
exit;
?>
