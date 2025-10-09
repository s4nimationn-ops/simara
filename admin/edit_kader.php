<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
cek_role(['admin']);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: biodata_kader.php');
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id AND role='kader'");
if (mysqli_num_rows($result) == 0) {
    header('Location: biodata_kader.php');
    exit;
}

$kader = mysqli_fetch_assoc($result);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    if ($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $update = "UPDATE users SET nama='$nama', no_hp='$no_hp', email='$email', password='$hash' WHERE id=$id";
    } else {
        $update = "UPDATE users SET nama='$nama', no_hp='$no_hp', email='$email' WHERE id=$id";
    }

    if (mysqli_query($conn, $update)) {
        $msg = "Data kader berhasil diperbarui.";
        $kader = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));
    } else {
        $msg = "Gagal memperbarui data.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Kader</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { padding-top: 56px; background-color: #f8f9fa; }
    .container { max-width: 600px; margin-top: 40px; }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container">
    <h2 class="mb-4 fw-bold text-primary">Edit Kader</h2>
    <?php if($msg): ?><div class="alert alert-info"><?= $msg ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($kader['nama']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">No HP</label>
        <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($kader['no_hp']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($kader['email']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password (kosongkan jika tidak ingin diubah)</label>
        <input type="password" name="password" class="form-control">
      </div>
      <button class="btn btn-primary w-100">Simpan Perubahan</button>
    </form>
  </div>
</body>
</html>
