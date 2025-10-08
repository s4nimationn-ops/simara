<?php
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../config/session.php';
cek_role(['kader']);
$nama = $_SESSION['nama'];
// show recent remaja list
$remaja = mysqli_query($conn, "SELECT id,nama,email FROM users WHERE role='remaja' ORDER BY created_at DESC LIMIT 20");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Kader Dashboard</title>
<link href="/assets/css/style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><?php include 'navbar.php'; ?>
<div class="container py-5">
  <h4>Halo, <?=htmlspecialchars($nama)?></h4>
  <div class="card p-3 mt-3"><h5>Daftar Remaja (terbaru)</h5>
    <table class="table table-striped mt-2"><thead><tr><th>Nama</th><th>Email</th><th>Aksi</th></tr></thead><tbody>
    <?php while($r=mysqli_fetch_assoc($remaja)): ?>
      <tr>
        <td><?=htmlspecialchars($r['nama'])?></td>
        <td><?=htmlspecialchars($r['email'])?></td>
        <td>
          <a href="input_antropometri.php?uid=<?=$r['id']?>" class="btn btn-sm btn-primary">Input Antropometri</a>
          <a href="input_screening.php?uid=<?=$r['id']?>" class="btn btn-sm btn-secondary">Input Screening</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody></table>
  </div>
</div></body></html>
