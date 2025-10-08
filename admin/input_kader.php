<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);
$msg='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $nama = mysqli_real_escape_string($conn,$_POST['nama']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $pw = $_POST['password'];
    if (!$nama || !$email || !$pw) $msg='Lengkapi data.';
    else {
        $q = mysqli_query($conn,"SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($q)>0) $msg='Email sudah ada.';
        else {
            $hash = password_hash($pw, PASSWORD_DEFAULT);
            mysqli_query($conn,"INSERT INTO users (nama,email,password,role) VALUES ('$nama','$email','$hash','kader')");
            $msg='Kader berhasil ditambahkan.';
        }
    }
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Tambah Kader</title>
<link href="/assets/css/style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><?php include 'navbar.php'; ?><div class="container py-5">
  <div class="card p-4"><h4>Tambah Kader Posyandu</h4>
    <?php if($msg):?><div class="alert alert-info"><?=$msg?></div><?php endif;?>
    <form method="post">
      <div class="mb-3"><label>Nama</label><input name="nama" class="form-control" required></div>
      <div class="mb-3"><label>Email</label><input name="email" type="email" class="form-control" required></div>
      <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
      <button class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div></body></html>
